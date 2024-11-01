<?php

namespace WPSubsite\fields;

use \WPSubsite\fields\SubsiteFieldTextarea;

class SubsiteURLs extends SubsiteFieldTextarea {

  protected $labelText = 'Add URLs for this Subsite, one per line';
  protected $fieldName = 'subsite_urls';

  public function getOutput() {

    $output = parent::getOutput();

    if (!subsite_freemius()->can_use_premium_code__premium_only()) {
      $output = '
        <div class="wp-subsite-pro-message">
        <span>
          The <a href="' . subsite_freemius()->get_upgrade_url() . '">Pro version</a> allows content managers to choose a subsite when editing pages, instead of specifying the URLs here. 
        </span>
        </div>
      ' . $output;
    }

    return $output;
  }

}