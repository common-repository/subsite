<?php

namespace WPSubsite\fields;

use \WPSubsite\fields\SubsiteFieldBase;

class SubsiteURLPattern extends SubsiteFieldBase {

  protected $labelText = 'URL Pattern: ';
  protected $fieldName = 'subsite_url_pattern';

  public function getInputName() {
    return parent::getInputName() . '[]';
  }

}