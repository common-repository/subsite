<?php

namespace WPSubsite\fields;

use \WPSubsite\fields\SubsiteFieldTextarea;

class SubsiteCSS extends SubsiteFieldTextarea {

  protected $labelText = 'Add CSS for this subsite';
  protected $fieldName = 'subsite_css';

  public function getOutput() {

    if (!subsite_freemius()->can_use_premium_code__premium_only()) {
      return '<div>This is a <a href="' . subsite_freemius()->get_upgrade_url() . '">Pro version</a> feature only.</div>';
    }

    return parent::getOutput();
  }

}