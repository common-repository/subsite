<?php

namespace WPSubsite\fields;

use \WPSubsite\fields\SubsiteFieldBase;

class SubsiteFieldTextarea extends SubsiteFieldBase {

  public function getOutput() {

    return "<textarea id=\""
      . $this->getInputId()
      . "\" class=\"subsite-input-"
      . sanitize_html_class($this->getInputName())
      . "\" name=\"{$this->getInputName()}\" >\n"
      . htmlspecialchars($this->getValue())
      . '</textarea>';

  }

}