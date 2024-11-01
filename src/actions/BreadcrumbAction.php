<?php

namespace WPSubsite\actions;

use WPSubsite\actions\ActionBase;

class BreadcrumbAction extends ActionBase {

  public function apply() {

    $this->apply_wpseo();

  }

  public function apply_wpseo() {
    add_filter( 'wpseo_breadcrumb_links',
      function($links) {

        if ($subsite = \WPSubsite\State\SubsiteState::getActiveSubsite()) {

          return array_map(
            function($link) use ($subsite) {
              $link['url'] = static::replaceHomeURLwithSubsiteHome($link['url'], $subsite);
              return $link;
            },
            $links
          );
        }

        return $links;

      }
    );
  }

  public static function replaceHomeURLwithSubsiteHome($url_given, \WPSubsite\post\SubsitePost $subsite) {

    $field_obj = new \WPSubsite\fields\HomeURL();

    if ($subsite->getFieldValue($field_obj->getName())
      && ($home_url_initial = \WPSubsite\State\SubsiteState::getInitialHomeURL())) {

      $url_parts_initial = parse_url(rtrim($home_url_initial, '/'));
      $url_parts_given = parse_url(rtrim($url_given, '/'));

      if (empty($url_parts_given['path'])) {
        if (!empty($url_parts_initial['host']) && !empty($url_parts_given['host'])) {
          if (rtrim($url_parts_initial['host'], '/') == rtrim($url_parts_given['host'], '/')) {
            return rtrim($url_given, '/') . '/' . $subsite->getFieldValue($field_obj->getName());
          }
        }
      }
    }

    return $url_given;
  }
}