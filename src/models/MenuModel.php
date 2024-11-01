<?php

namespace WPSubsite\models;

use \WPSubsite\models\ModelBase;

class MenuModel extends ModelBase {

  public static function all() {

    $menus = [];

    $query_result = get_terms(
      [
        'taxonomy' => 'nav_menu',
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => false,
      ]
    );

    if (is_wp_error($query_result)) {
      throw new \Exception($query_result->get_error_message());
    }
    else {
      $menus = array_map(
        function ($term_obj) {
          $new_term_obj = wp_get_nav_menu_object($term_obj);
          $new_term_obj->id = $new_term_obj->term_id;

          return $new_term_obj;
        }
        , $query_result
      );
    }

    return $menus;

  }

}