<?php

namespace WPSubsite\actions;

use WPSubsite\actions\ActionBase;

class SearchApplySubsiteAction extends ActionBase {

  public function apply() {

    if (is_search()) {
      $subsite = \WPSubsite\state\SubsiteState::getActiveSubsite();

      if (!$subsite) {
        $subsite = \WPSubsite\state\SubsiteState::getReferringSubsite();
        \WPSubsite\state\SubsiteState::setActiveSubsite($subsite);
      }
    }

    wp_enqueue_script(
      'wp-subsite-search',
      plugin_dir_url(__FILE__) . 'js/SearchApplySubsiteAction.js'
    );
  }
}