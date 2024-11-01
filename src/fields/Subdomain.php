<?php

namespace WPSubsite\fields;

use \WPSubsite\fields\SubsiteFieldBase;

class Subdomain extends SubsiteFieldBase {

  protected $labelText = 'Subdomain: ';
  protected $fieldName = 'subsite_subdomain';

  public function getOutput() {

    if (!subsite_freemius()->can_use_premium_code__premium_only()) {
      return '<div>This is a <a href="' . subsite_freemius()->get_upgrade_url() . '">Pro version</a> feature only.</div>';
    }

    return parent::getOutput();
  }

}