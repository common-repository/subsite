<?php

namespace WPSubsite\models;

use WPSubsite\models\ModelBase;
use WPSubsite\lib\Constants;

class SubsiteModel extends ModelBase {

  public static function all() {

    $posts = get_posts([
      'post_type' => Constants::SUBSITE_POST_TYPE_NAME,
      'post_status' => ['publish', 'private'],
      'numberposts' => -1,
      'order'    => 'ASC'
    ]);

    return array_map(
      function($val) {
        
        $wrapper = new \WPSubsite\post\SubsitePost();
        $wrapper->setRealPost($val);

        return $wrapper;
      },
      $posts
    );
  }
}