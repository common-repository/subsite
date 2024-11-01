<?php

namespace WPSubsite\fields;

use \WPSubsite\fields\SubsiteFieldBase;

class SubsiteFieldRepeatable extends SubsiteFieldBase {

  public $subFieldClass;
  protected $htmlWrapperClassName = 'subsite-field-wrapper subsite-field-wrapper-repeatable';
  
  public function getSubfieldObj() {

    if (!class_exists($this->subFieldClass)) {
      throw new \InvalidArgumentException("Provided sub class doesnt exist: " . $this->subFieldClass);
    }

    return new $this->subFieldClass;
  }

  public function getOutput() {
    
    $output = '';
    $field_vals = $this->getSavedValueByName($this->getName());

    //$output .= "field vals " . print_r($field_vals, 1);

    $field_count = count($field_vals) ? count($field_vals) : 1;
    
    for($i = 0; $i < $field_count; $i++) {

      $sub_field_obj = $this->getSubfieldObj();

      if (isset($field_vals[$i])) {
        $sub_field_obj->setValue($field_vals[$i]);
      }

      $output .= \WPSubsite\fields\FieldWrapper::getOutputFromFieldObj($sub_field_obj);
      $output .= "<button class=\"dashicons dashicons-plus\"></Button>";

    }

    return $output;

  }

  public function getSaveableValue() {

    $sub_field_obj = $this->getSubfieldObj();

    return parent::getValueByName($sub_field_obj->getName());
  }

  public function getLabel() {

    if (!$this->labelObj) {
      $this->labelObj = parent::getLabel();
      $this->labelObj->setHtmlClassName($this->labelObj->getHtmlClassName() . ' ' . $this->labelObj->getHtmlClassName() . '-repeatable');
    }

    return $this->labelObj;
  }

}

