<?php

namespace WPSubsite\actions;

use WPSubsite\actions\ActionBase;

class SubdomainURLAction extends ActionBase {

  public function apply() {

    if (is_admin()) {
      return;
    }

    if ($subsite = \WPSubsite\state\SubsiteState::getSubsiteFromHost()) {

      if (!\WPSubsite\state\SubsiteState::$activeSubsite) {
        \WPSubsite\state\SubsiteState::setActiveSubsite($subsite);
      }
      
      $subdomain_url = $subsite->getFieldValue('subsite_subdomain');

      add_filter('site_url',
        function($url) use ($subdomain_url) {
          return \WPSubsite\actions\HomeURLAction::replaceURLWithSubsiteHome($url, $subdomain_url);
        }
      );

      add_filter('home_url',
        function($url) use ($subdomain_url) {
          return \WPSubsite\actions\HomeURLAction::replaceURLWithSubsiteHome($url, $subdomain_url);
        }
      );

      /*
       * Set the WordPress homepage to the homepage of the subdomain, 
       * So the root subdomain shows this page instead of the "real" WordPress homepage
       */
      $home_postid = null;

      if ($home_url = $subsite->subsite_home_url) {
        $home_postid = \url_to_postid($home_url);
      }

      add_filter('pre_option_page_on_front',
        function ($value) use ($home_postid) {
            if ($home_postid) {
              return $home_postid;
            }
            
            return $value;
        }
      );
  
      add_filter('pre_option_show_on_front',
        function ($value) use ($home_postid) {
          if ($post = get_post($home_postid)) {
            return $post->post_type;
          }
          return $value;
        }
      );

      // flush_rewrite_rules();
      // echo "adding rewrite";
      // add_rewrite_rule('^subsite-subpage4/?', 'index.php?page_id=2298', 'top');
      // flush_rewrite_rules();
      //add_rewrite_rule('([^/]+)', 'index.php?pagename=subsite-home');

      // add_filter('request',
      //   function($request) {
      //     print_r($request);

      //     $name = (!empty($request['pagename'])) ? $request['pagename'] : $request['name'];

      //     echo "postid<br>";
      //     echo 'http://wpsubdomain.local/test-subsite/' . $name;
      //     echo url_to_postid('test-subsite/' . $name);
      //     if ($request['name'] == 'testingjim') {
      //       $request['name'] = 'template-sticky';
      //     }

      //     return $request;
      //   }, 1
      // );

    //   add_filter('template_redirect', 
    //   function() use ($subsite) {
        
    //       global $wp;
    //       global $wp_query;
    //       global $post;
    //       if ($wp_query->is_main_query()) {
    //         echo "HERE";
            
    //         wp_reset_postdata();
            
    //         $post = get_post($subsite->ID);
    //         setup_postdata($post);
    //         echo "----SUBSITE: {$subsite->ID} ----<br>";
    //         print_r($post);

    //         $GLOBALS['wp_query'] = $wp_query;
    //         $wp->register_globals();

    //       }
        
    //   }
    // );

    }

    
    
    global $wp_query;       
    //$wp_query = new \WP_Query(array('p'=>123));
    //add_rewrite_rule( '(.*)','index.php?pagename=subsite-home&customvariable=$matches[1]', 'top' );

  }

  //public static function alterWPQueryForPost
}