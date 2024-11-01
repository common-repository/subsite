<?php

namespace WPSubsite\fields;

use \WPSubsite\fields\SubsiteFieldBase;

class SearchExclusive extends SubsiteFieldBase {

  protected $labelText = 'Exclusive search:';
  protected $fieldName = 'subsite_search_exclusive';

  public function getOutput() {

    $checked = $this->getValue() ? 'checked="checked"' : '';

    if (subsite_freemius()->can_use_premium_code__premium_only()) {
      $output = "<input id=\"wp-subsite-input-exclusive-search\" type=\"checkbox\" {$checked} value=\"1\" name=\"{$this->getInputName()}\">";
    }
    else {
      $output = "<input type=\"hidden\" value=\"0\" name=\"{$this->getInputName()}\">";
   
    }

    $output .= "<label for=\"wp-subsite-input-exclusive-search\">When a user uses the search box from this subsite, return only results from this subsite</label>";

    if (!subsite_freemius()->can_use_premium_code__premium_only()) {
      $output .=
        '<div>This is a <a href="' . subsite_freemius()->get_upgrade_url() . '">Pro version</a> feature only.</div>';
    }

    return $output;

  }

}