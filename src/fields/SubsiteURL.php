<?php

namespace WPSubsite\fields;

use \WPSubsite\fields\SubsiteFieldBase;

class SubsiteURL extends SubsiteFieldBase {

  protected $labelText = 'URL: ';
  protected $fieldName = 'subsite_url';

  public function getInputName() {
    return parent::getInputName() . '[]';
  }

}