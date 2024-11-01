<?php

namespace WPSubsite\actions;

use WPSubsite\actions\ActionBase;

class LogoAction extends ActionBase {

  public function apply() {

    add_filter('get_custom_logo', function($html) {

      if ($subsite = $this->getSubsite() ) {

        $home_url = $subsite->getHomeURL();

        $output = "<a href=\"{$home_url}\" class=\"custom-logo-link\" rel=\"home\">";
        $output .= wp_get_attachment_image($subsite->subsite_logo, 'full', 'false', ['class' => 'custom-logo']);
        $output .= '</a>';
       
        return $output;
      }
    });

  }
}