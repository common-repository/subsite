<?php

namespace WPSubsite\post;

use WPSubsite\lib\Constants;

class SubSitePostType {

  public static function initialize() {

    $class_path = '\WPSubsite\post\SubsitePostType';

    add_action('init', [$class_path, 'register']);
    
    add_action('add_meta_boxes', [$class_path, 'addFields']);
    //add_action('admin_init', [$class_path, 'removeMetaBoxes'], 15);
    
    add_action('save_post', function($post_id) {
      if (get_post_type($post_id) == Constants::SUBSITE_POST_TYPE_NAME) {
        $post = new \WPSubsite\post\SubsitePost($post_id);
        return $post->save();
      }
    });
  }

  public static function getFields() {

    return [
      new \WPSubsite\fields\HomeURL,
      
      new \WPSubsite\fields\SubsiteLogo,
      new \WPSubsite\fields\MenuLocationSelect,
      new \WPSubsite\fields\SubsiteURLs,
      //new \WPSubsite\fields\SubsiteURLPatterns,
      new \WPSubsite\fields\Subdomain,
      new \WPSubsite\fields\SearchExclusive,
      new \WPSubsite\fields\SubsiteCSS

    ];

  }

  public static function register() {

    register_post_type( Constants::SUBSITE_POST_TYPE_NAME,
      array(
          'labels' => array(
              'name' => __( 'Subsite' ),
              'singular_name' => __( 'Subsites' )
          ),
          'supports' => array('title', 'custom-fields'),
          'public' => true,
          'has_archive' => false,
          'show_in_rest' => true,

      )
    );

    //register_post_meta( Constants::SUBSITE_POST_TYPE_NAME, 'testfield', ['type' => 'string', 'single' => true] );


  }

  public static function addFields() {

    global $post;

    $field_objs = self::getFields();

    add_meta_box(
      'subsite-fields-meta-box',
      __( 'Subsite Options', 'textdomain' ),
      function() use ($field_objs, $post) {
        foreach($field_objs as $obj) {
          if ($post) {
            $obj->setPost(new \WPSubsite\post\SubsitePost($post->ID));
          }

          $obj->renderWithWrapper();
        }

        wp_nonce_field( 'subsite-fields', '_subsite_nonce' );
      },
      Constants::SUBSITE_POST_TYPE_NAME,
      'advanced',
      'high'
    );

  }

  public static function removeMetaBoxes() {
    // echo "removing";
    // remove_meta_box('subsite-fields-meta-box', ['page', 'post'], 'normal');
  }
}
