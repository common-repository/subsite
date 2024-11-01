<?php

namespace WPSubsite\actions;

use WPSubsite\actions\ActionBase;

class MenuAction extends ActionBase {

  public function apply() {

    add_filter('wp_nav_menu_args', function($args) {
      $subsite = $this->getSubsite();
      if ($subsite) {
        $args['menu'] = static::getMenuForSubsite($subsite, $args);
      }

      return $args;
    });

  }

  public static function getMenuForSubsite(\WPSubsite\post\SubsitePost $subsite, $options = []) {
    
    $menu_select_field = new \WPSubsite\fields\MenuLocationSelect();
    $menu_select_field->setPost($subsite);

    if ($menu_id = $menu_select_field->getValueForLocation($options['theme_location'])) {
      return wp_get_nav_menu_object($menu_id);
    }

    return null;
  }
}