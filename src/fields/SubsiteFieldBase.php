<?php

namespace WPSubsite\fields;

use WPSubsite\fields\FieldWrapper;
use WPSubsite\lib\Constants;

abstract class SubsiteFieldBase {

  protected $post = null;
  protected $labelObj;
  protected $labelText = '';
  protected $fieldName = '';
  protected $fieldInstructions = '';
  protected $fieldValue = null;
  protected $fieldInputName = null;
  protected $htmlWrapperClassName = 'subsite-field-wrapper';
  protected $valueIsSet = false;

  public function getOutput() {

    return "<input id=\"" . $this->getInputId() . "\" class=\"subsite-input-" . sanitize_html_class($this->getInputName()) . "\" type=\"text\" value=\"" . htmlspecialchars($this->getValue()) . "\" name=\"{$this->getInputName()}\" >\n";
    
  }
  
  public function preRender() {
    return true;
  }

  public function render() {
    $this->preRender();
    print wp_kses(
      $this->getOutput(),
      Constants::SUBSITE_FIELD_RENDERER_ALLOWED_HTML
    );
  }

  public function renderWithWrapper() {
    $this->preRender();
    return FieldWrapper::renderFromFieldObj($this);
  }
  
  public function getLabel() {
    if (!$this->labelObj) {
      $this->labelObj = new \WPSubsite\fields\FieldLabel();
      $this->labelObj->setText($this->labelText);
      $this->labelObj->setField($this);
    }

    return $this->labelObj;
  }

  public function getLabelText() {
    return $this->getLabel()->getText();
  }

  public function setLabelText($text) {
    $this->getLabel()->setText($text);
  }

  public function setName($name) {
    $this->fieldName = $name;
  }

  public function getName() {
    return $this->fieldName;
  }

  public function getInputId() {
    return 'subsite-input-' . sanitize_html_class($this->getName());
  }

  public function setInputName($name) {
    $this->fieldInputName = $name;
  }

  public function getInputName() {
   if (!$this->fieldInputName) {
    if (preg_match('/[A-Za-z0-9\-_]+/', $this->getName())) {
      return $this->getName();
    }
   }
   
   return $this->fieldInputName;
  }

  public function setInstructions($text) {
    $this->fieldInstructions = $text;
  }

  public function getInstructions() {
    return $this->fieldInstructions;
  }

  public function setPost($post) {
    $this->post = $post;
  }
  
  public function getPost() {
    return $this->post;
  }

  public function isPostback() {

    if (strtolower(filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING)) == 'post') {
      return true;
    }

  }

  public function getSubmittedValueByName($name) {

    check_admin_referer( 'subsite-fields', '_subsite_nonce' );

    return (isset($_POST[$name])) ? wp_kses_post($_POST[$name]) : null;

  }

  public function getSavedValueByName($name) {
    
    if ($post = $this->getPost()) {
      return get_post_meta($post->ID, $name, true);
    }

    return null;
  }

  public function getValueByName($name) {
    return $this->isPostback() ? $this->getSubmittedValueByName($name) : $this->getSavedValueByName($name);
  }

  public function getValue() {

    if ($this->valueIsSet) {
      return $this->fieldValue;
    }

    $name = $this->getName();
    return $this->getValueByName($name);
    
  }

  public function getSaveableValue() {
    return $this->getValue();
  }

  public function setValue($val) {
    $this->fieldValue = $val;
    $this->valueIsSet = true;
  }

  public function unsetValue() {
    $this->fieldValue = null;
    $this->valueIsSet = false;
  }

  public function getHtmlWrapperClassName() {
    return $this->htmlWrapperClassName;
  }

  public function setHtmlWrapperClassName($name) {
    $this->htmlWrapperClassName = $name;
  }

  public function saveValue() {

    if (!$this->post) {
      throw new \InvalidArgumentException("Post must be applied to field before saving");
    }

    update_post_meta($this->post->ID, $this->getName(), $this->getSaveableValue());

  }
}