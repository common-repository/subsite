<?php

namespace WPSubsite\fields;

use \WPSubsite\fields\SubsiteFieldBase;

class MenuLocationSelect extends SubsiteFieldBase {

  protected $labelText = 'Menu to display in location ';
  protected $fieldName = 'menu_selections';

  public function getOutput() {

    $menu_locations = \WPSubsite\models\MenuLocationModel::all();
    $field_label_base = $this->getLabelText();
    $output = '';
    
    foreach($menu_locations as $key => $name) {

      $markup = '';

      $menu_select = new \WPSubsite\fields\MenuSelect();
      $menu_select->setName('subsite_menu_' . $key);
      $menu_select->setValue($this->getValueForLocation($key));
      
      $label = new \WPSubsite\fields\FieldLabel();
      $label->setText($field_label_base . '"' . $name . '"');

      $markup .= \WPSubsite\fields\FieldWrapper::getFieldLabelMarkup($label);
      $markup .= \WPSubsite\fields\FieldWrapper::getFieldInputMarkup($menu_select);

      $output .= \WPSubsite\fields\FieldWrapper::getOutput($markup);
    }

    return $output;

  }

  public function getValueForLocation($key) {
    return $this->getvalueByName('subsite_menu_' . $key);
  }

  public function getValue() {

    $menu_locations = \WPSubsite\models\MenuLocationModel::all();
    $values = [];

    foreach($menu_locations as $key => $name) {

      if ($val = $this->getValueForLocation($key)) {
        $values['subsite_menu_' . $key] = $val;
      }

    }

    return $values;

  }

  public function renderWithWrapper() {
    return $this->render();
  }
  
  public function saveValue() {

    if (!$this->post) {
      throw new \InvalidArgumentException("Post must be applied to field before saving");
    }

    $this->doForAllMenuLocations(
      function($key, $name) {
        $menu_select = new \WPSubsite\fields\MenuSelect();
        $menu_select->setName('subsite_menu_' . $key);
        $menu_select->setPost($this->getPost());
        $menu_select->saveValue();
      }
    );

  }

  public function doForAllMenuLocations(callable $callback) {

    foreach(\WPSubsite\models\MenuLocationModel::all() as $key => $name) {
      $callback($key, $name);
    }
  }


}