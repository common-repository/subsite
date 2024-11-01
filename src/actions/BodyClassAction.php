<?php

namespace WPSubsite\actions;

use WPSubsite\actions\ActionBase;

class BodyClassAction extends ActionBase {

  public function apply() {

    add_filter('body_class',
      function($classes) {

        $subsite = \WPSubsite\state\SubsiteState::getActiveSubsite();

        if ($subsite) {
          $classes[] = 'subsite-' . intval($subsite->ID);
        }

        return $classes;
      }

    );

  }
}

