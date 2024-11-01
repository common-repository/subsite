<?php

namespace WPSubsite\fields;

class FieldLabel {

  protected $fieldObj = null;
  protected $htmlClassName = 'subsite-field-label';
  public $text = '';


  public function __construct($text = '') {
    $this->text = $text;
  }

  public function setField($obj) {
    $this->fieldObj = $obj;
  }

  public function getHtmlClassName() {
    return $this->htmlClassName;
  }

  public function setHtmlClassName($name) {
    $this->htmlClassName = $name;
  }

  public function getOutput() {

    $field_id = $this->fieldObj ? $this->fieldObj->getInputId() : '';
   
    return '<label for="'  .$field_id . '">' . $this->text . '</label>';

  }

  public function setText($text) {
    $this->text = $text;
  }

  public function getText() {
    return $this->text;
  }

  public function render() {

    print wp_kses(
      $this->getOutput(),
      ['label' => ['for' => [], 'id' => [], 'class' =>[]], 'span' => ['id' => [], 'class' =>[]], 'p' => ['id' => [], 'class' =>[]]]
    );
  }

}