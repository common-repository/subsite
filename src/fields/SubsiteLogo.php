<?php

namespace WPSubsite\fields;

use \WPSubsite\fields\SubsiteFieldBase;

class SubsiteLogo extends SubsiteFieldBase {

  protected $labelText = 'Logo: ';
  protected $fieldName = 'subsite_logo';

  public function getOutput() {

    $media_id = $this->getValue();

    $image_url = null;
    $image_display = (!$media_id) ? " display:none; " : '';
    $button_label = 'Add Logo';

    if ($media_id) {
      $image_url = wp_get_attachment_image_url($media_id, 'full');
      $button_label = 'Change Logo';
    }

    $output = "<div><img style=\"{$image_display}\" id=\"{$this->getName()}_img\" src=\"{$image_url}\"></div>";
    $output .= "<input id=\"{$this->getName()}\" name=\"{$this->getName()}\" type=\"hidden\" value=\"" . htmlspecialchars($this->getValue()) . "\" />";
    $output .= "<div><input id=\"subsite_logo_upload_button\" class=\"button\" type=\"button\" value=\"" . $button_label . "\" /></div>";

    return $output;
  }


  public function preRender() {

    parent::preRender();

    wp_enqueue_script(
      'wp-subsite-logo-upload-button',
      plugin_dir_url(__FILE__) . 'js/SubsiteLogoUploadButton.js'
    );
    
    return true;
  }
}