<?php

namespace WPSubsite\actions;

use WPSubsite\actions\ActionBase;

class SearchExclusiveAction extends ActionBase {

  public function apply() {

    add_action( 'pre_get_posts',
      function($query) {
        if ( !is_admin() && $query->is_search() && $query->is_main_query() ) {

          $subsite = \WPSubsite\state\SubsiteState::getActiveSubsite();

          if (!$subsite) {
            $subsite = \WPSubsite\state\SubsiteState::getReferringSubsite();
          }

          if ($subsite && $subsite->getFieldValue('subsite_search_exclusive')) {
            $field_obj = new \WPSubsite\fields\SubsiteSelect();

            $meta_query = $query->get('meta_query');
            if (!$meta_query) {
              $meta_query = [];
            }

            $meta_query[] = [
              'key' => $field_obj->getName(),
              'value' => $subsite->ID
            ];

            $query->set('meta_query', $meta_query);

            return $query;
          }
        }
      }
    );
  }
}