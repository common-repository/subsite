<?php

namespace WPSubsite\post;

use WPSubsite\lib\Constants;

class PostActions {

  public static $METABOX_NAME = 'wp_subsite';

  public static function initialize() {

    /*
    * Add subsite selection metabox
    */

    $class_path = '\WPSubsite\post\PostActions';

    add_action('add_meta_boxes', [$class_path, 'addMetaBoxes']);
    add_action('save_post', [$class_path, 'savePost']);
    add_action('do_meta_boxes', [$class_path, 'removeExtraMetaBoxes'],11,2);
  }

  public static function removeExtraMetaBoxes() {
    global $wp_meta_boxes;

    if (!empty($wp_meta_boxes[static::$METABOX_NAME]['normal'])) {
      foreach($wp_meta_boxes[static::$METABOX_NAME]['normal'] as $priority => $boxes) {
        foreach($boxes as $box_id => $box_data) {
          if ($box_id != 'postcustom') {
            remove_meta_box($box_id, static::$METABOX_NAME, 'normal');
          }
        }
      }
    }
  }

  public static function addMetaBoxes() {

    if (!subsite_freemius()->can_use_premium_code__premium_only()) {
      return;
    }

    global $post;

    $post_type = get_post_type($post);
    $post_type_info = get_post_type_object($post_type);

    if ($post_type != Constants::SUBSITE_POST_TYPE_NAME && !empty($post_type_info->public)) {

      add_meta_box(
        static::$METABOX_NAME,
        __( 'Subsite', 'textdomain' ),
        function() use ($post) {
          $obj = new \WPSubsite\fields\SubsiteSelect();
          $obj->setHtmlWrapperClassName('subsite-field-wrapper metabox-subsite-selection');
          $obj->setPost(new \WPSubsite\post\SubsitePost($post->ID));
          $obj->renderWithWrapper();
        },
        null,
        'side',
        'low'
      );
    }
  }

  public static function savePost() {

    if (!subsite_freemius()->can_use_premium_code__premium_only()) {
      return;
    }

    global $post;

    $field_obj = new \WPSubsite\fields\SubsiteSelect();

    if (!empty($post->ID)) {
      update_post_meta($post->ID, $field_obj->getName(), $field_obj->getSaveableValue());
    }

  }

}