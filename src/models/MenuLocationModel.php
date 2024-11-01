<?php

namespace WPSubsite\models;

use \WPSubsite\models\ModelBase;

class MenuLocationModel extends ModelBase {

  public static function all() {

    return get_registered_nav_menus();

  }

}