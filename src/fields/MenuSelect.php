<?php

/**
 * This class is intended to always be accessed through 
 * a "MenuLocationSelect" class
 */


namespace WPSubsite\fields;

use \WPSubsite\fields\SubsiteFieldBase;
use \WPSubsite\models\MenuModel;

class MenuSelect extends SubsiteFieldBase {

  protected $labelText = 'Menu to display on this subsite';
  protected $fieldName = 'subsite_menu';

  public function getOutput() {

    $menus = \WPSubsite\models\MenuModel::all();

    if ($menus) {

      $output = '<select name="' . $this->getName() . '"><option value="">- None-</option>';

      foreach ($menus as $menu_data) {

        $selected = ($this->getValue() && ($menu_data->id == $this->getValue())) ? ' selected="selected" ' : '';

        $output .= "<option {$selected} value=\"{$menu_data->id}\">{$menu_data->name}</option>";
      }
  
      $output .= '</select>';

    }

    return $output;
  }

}