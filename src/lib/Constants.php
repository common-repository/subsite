<?php

namespace WPSubsite\lib;

class Constants {

  const SUBSITE_POST_TYPE_NAME = 'wp_subsite';
  const SUBSITE_POST_TYPE_LABEL= 'Subsite';
  const SUBSITE_POST_TYPE_LABEL_PLURAL = 'Subsites';
  const SUBSITE_FIELD_RENDERER_ALLOWED_HTML = [
    'div' => ['class' => [], 'id' => []],
    'input' => ['class' => [], 'maxlength' => [], 'id' => [], 'name' => [], 'type' => [], 'value' => []], 
    'button' => ['class' => [], 'id' => [], 'name' => [], 'value' => []], 
    'select' => ['option' => ['name' => [], 'id' => [], 'value' => []], 'class' => [], 'id' => [], 'name' => []],
    'option' => ['name' => [], 'id' => [], 'value' => [], 'class' => [], 'selected' => []],
    'label' => ['id' => [], 'for' => [], 'class' => []],
    'a' => ['class' => [], 'href' => [], 'id' => [], 'target' => []],
    'textarea' => ['class' => [], 'maxlength' => [], 'id' => [], 'name' => [], 'rows' => [], 'cols' => [], 'value' => []],
    'span' => ['class' => []],
    'p' => ['class' => []],
    'img' => ['src' => [], 'width' => [], 'height' => [], 'id' => [], 'class' => []],
    'picture' => ['srcset' => [], 'src' => [], 'width' => [], 'height' => [], 'id' => [], 'class' => []],
    'strong' => [], 
    'em' => []
  ];
}

