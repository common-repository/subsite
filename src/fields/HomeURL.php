<?php

namespace WPSubsite\fields;

use \WPSubsite\fields\SubsiteFieldBase;

class HomeURL extends SubsiteFieldBase {

  protected $labelText = 'Home URL:';
  protected $fieldName = 'subsite_home_url';

  public function getOutput() {

    $output = parent::getOutput();

    $home_url = !empty(\WPSubsite\state\SubsiteState::$homeURLOriginal) ? \WPSubsite\state\SubsiteState::$homeURLOriginal : get_home_url();

    return '<span>' . ltrim($home_url, '/') . '/</span>' . $output;
  }

}