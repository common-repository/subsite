<?php

namespace WPSubsite\actions;

use WPSubsite\actions\ActionBase;

class HomeURLAction extends ActionBase {

  public function apply() {

    if (is_admin()) {
      return;
    }

    $subsite = \WPSubsite\state\SubsiteState::getActiveSubsite();

    if ($subsite && !$subsite->hasSubdomain()) {

      add_filter('home_url',
        function($url) use ($subsite) {

          $url_parts = parse_url($url);
          //print_r($url_parts);
          /**
           * We're only concerned with the *actual* home URL here.
           * Home URLS sometimes also include paths (?) and we don't
           * want to alter those.
           */
          if (empty($url_parts['path'])) {
            return static::replaceURLWithSubsiteHome($url, $subsite->getHomeURL());
          }

          return $url;
        }
      );

    }
  

  }

  public static function replaceURLWithSubsiteHome($url, $subsite_home_url) {

    // wordpress.local/study-abroad/about
    // studyabroad.local/about

    $subsite_url_parts = parse_url($subsite_home_url);
    $given_url_parts = parse_url($url);

    if (empty($given_url_parts['scheme'])) {
      $given_url_parts['scheme'] = is_ssl() ? 'https' : 'http';
    }

    $new_url = "{$given_url_parts['scheme']}://{$subsite_url_parts['host']}";

    if (!empty($subsite_url_parts['path'])) {
      $new_url .= '/' . ltrim($subsite_url_parts['path'], '/');
    }

    if (!empty($given_url_parts['path'])) {
      $new_url .= '/' . ltrim($given_url_parts['path'], '/');
    }

    //echo "Changing {$url} to {$new_url}<br>\n";

    return $new_url;

  }
}