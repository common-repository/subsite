<?php

namespace WPSubsite\fields;

use \WPSubsite\fields\FieldLabel;
use \WPSubsite\lib\Constants;

class FieldWrapper {

  public static function getOutput($field_markup, $options = []) {

    $field_obj = !empty($options['field_obj']) ? $options['field_obj'] : null;

    $class_name = 'subsite-field-wrapper';

    if ($field_obj) {
      $class_name = $field_obj->getHtmlWrapperClassName();
    }

    return '<div class="' . $class_name . '">' . $field_markup . '</div>';
  }

  public static function render($field_markup) {
    print wp_kses(
            self::getOutput($field_markup),
            Constants::SUBSITE_FIELD_RENDERER_ALLOWED_HTML
          );
  }

  public static function getFieldLabelMarkup(\WPSubsite\fields\FieldLabel $label) {
    return '<div class="' . $label->getHtmlClassName() . '">' . $label->getOutput() . '</div>';
  }

  public static function getFieldInputMarkup(\WPSubsite\fields\SubsiteFieldBase $field_obj) {
    return '<div class="subsite-field-input">' . $field_obj->getOutput() . '</div>';
  }

  public static function getOutputFromFieldObj(\WPSubsite\fields\SubsiteFieldBase $field_obj) {

    $label = $field_obj->getLabel();

    $output = self::getFieldLabelMarkup($label);
    $output .= self::getFieldInputMarkup($field_obj);

    return self::getOutput($output, ['field_obj' => $field_obj]);
  }

  public static function renderFromFieldObj($field_obj) {

    print wp_kses(
        self::getOutputFromFieldObj($field_obj),
        Constants::SUBSITE_FIELD_RENDERER_ALLOWED_HTML
      );
  }

}