<?php

namespace WPSubsite\state;

use WPSubsite\lib\Constants;

class SubsiteState {

  public static $activeSubsite = false;
  public static $homeURLInitial = null;
  public static $referringSubsite = null;

  public static function getInitialHomeURL() {
    return static::$homeURLInitial;
  }

  public static function setActiveSubsite(\WPSubsite\post\SubsitePost $subsite) {
    static::$activeSubsite = $subsite;
  }

  public static function getActiveSubsite() {
    
    global $wp;

    if (static::$activeSubsite === false) {

      $post = get_post();

      if ($post && !empty($post->ID)) {
        static::$activeSubsite = static::getSubsiteFromPost($post);
      }

      if (!static::$activeSubsite) {
        static::$activeSubsite = static::getSubsiteFromParams();
      }

      if (!static::$activeSubsite) {
        static::$activeSubsite = static::getSubsiteFromHost();
      }

      if (!static::$activeSubsite) {
        //check to make sure it's not the home url, e.g. for search
        $request_uri = !empty($wp->request) ? $wp->request : filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_STRING);
        static::$activeSubsite = static::getSubsiteFromUrlExplicit($request_uri);
      }

      /*
      if (!static::$activeSubsite && isset($_GET['_subsite'])) {
        $subsite = get_post($_GET['_subsite']);
        if ($subsite instanceof WP_Post) {
          static::$subsite = $subsite;
        }
      }
      */
    }
    return static::$activeSubsite;
  }

  public static function setReferringSubsite($subsite) {
    static::$referringSubsite = $subsite;
  }

  public static function getReferringSubsite() {
    
    if (!static::$referringSubsite) {
      if (wp_get_referer()) {
        $referer_url = wp_get_referer();
        $referer_post_id = url_to_postid($referer_url);
        
        if ($referer_post_id && $post = get_post($referer_post_id)) {
          static::$referringSubsite = \WPSubsite\state\SubsiteState::getSubsiteFromPost($post);
        }
      }

    }
    return static::$referringSubsite;
  }

  public static function getSubsiteFromParams() {
    
    $id = null;
    
    /*
     We don't currently need POST-based subsite ids, and it causes
     the linter to get upset about nonces.
     
     if (!empty($_POST['subsite_id'])) {
       $id = $_POST['subsite_id'];
      }
    */

    $url_subsite_id = filter_input(INPUT_GET, 'subsite_id', FILTER_SANITIZE_NUMBER_INT);

    if ($url_subsite_id) {
      $id = $url_subsite_id;
    }

    if ($id && is_numeric($id)) {
      return static::getSubsiteFromPostID($id);
    }

    return null;
  }

  public static function getSubsiteFromPost($post) {

    $subsite_selection_field = new \WPSubsite\fields\SubsiteSelect();
    $subsite_selection_field->setPost($post);

    if ($subsite_id = $subsite_selection_field->getValue()) {
      return static::getSubsiteFromPostID($subsite_id);
    }

    return null;

  }

  public static function getSubsiteFromHost() {

    $subsites = \WPSubsite\models\SubsiteModel::all();

    foreach ($subsites as $subsite) {
      if ($subdomain_url = $subsite->getFieldValue('subsite_subdomain')) {
        if (in_array(ltrim($subdomain_url, '/'), static::getHostURLPossibleMatches())) {
          return $subsite;
          break;
        }
      }
    }
    
    return null;
  }

  public static function getHostURLPossibleMatches() {

    $scheme = is_ssl() ? 'https' : 'http';
  
    return array_map(
      function($val) {
        return strtolower($val);
      },
      [
        filter_input(INPUT_SERVER, 'HTTP_HOST', FILTER_SANITIZE_STRING),
        $scheme . '://' . filter_input(INPUT_SERVER, 'HTTP_HOST', FILTER_SANITIZE_STRING),
      ]
    );

  }

  public static function getSubsiteFromPostID($id) {

    if (!$id || !is_numeric($id)) {
      throw new \InvalidArgumentException('id must be numeric');
    }

    return new \WPSubsite\post\SubsitePost($id);
  }

  public static function getSubsiteFromUrlExplicit($url) {
    
    $field_obj = new \WPSubsite\fields\SubsiteURLs;

    $url = '/' . ltrim($url, '/');

    //echo "Searching for {$url} serialized as " . serialize($url) . " in meta key {$field_obj->getName()}<br>\n";

    $query_args = [
      'post_type' => Constants::SUBSITE_POST_TYPE_NAME,
      'meta_query' => [
        'key' => $field_obj->getName(),
        'value' => serialize($url),
        'compare' => 'LIKE'
      ]
    ];

    $result = new \WP_Query( $query_args );
    
    if (is_wp_error($result)) {
      throw new \RuntimeException($result->get_error_messages());
    }
    
    if ($result) {
      $posts = $result->get_posts();
      
      if ($posts) {
      
        $post = array_pop($posts);

        if ($post->post_status === 'publish') {
          return new \WPSubsite\post\SubsitePost($post->ID);
        }
      }
    }

    return null;
  }

}