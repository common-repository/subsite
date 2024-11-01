<?php

namespace WPSubsite\fields;

use \WPSubsite\fields\SubsiteSelect;

class SubsiteSelect extends SubsiteFieldBase {

  public $fieldName = 'subsite_choice';
  public $labelText = 'Choose a Subsite';

  public function getOutput() {

    $subsites = \WPSubsite\models\SubsiteModel::all();

    $output = '<select name="' . $this->getName() . '"><option value="">- None -</option>';

    foreach($subsites as $subsite) {

      $selected = ($subsite->ID == $this->getValue()) ? ' selected="selected" ' : '';

      $output .= "<option {$selected} value=\"{$subsite->ID}\">{$subsite->post_title}</option>";
    }

    $output .= '</select>';

    return $output;

  }

}