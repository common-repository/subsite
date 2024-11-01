<?php

namespace WPSubsite\fields;

use \WPSubsite\fields\SubsiteFieldTextarea;

class SubsiteURLPatterns extends SubsiteFieldTextarea {

  protected $labelText = 'Add regex URL patterns for this Subsite, one per line';
  protected $fieldName = 'subsite_url_patterns';

}