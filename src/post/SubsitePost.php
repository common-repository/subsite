<?php

namespace WPSubsite\post;

class SubSitePost {

  public $realPost = null;

  public function __construct($id = null) {
    $this->setRealPost(get_post($id));
    
  }

  public function setRealPost($post) {
    $this->realPost = $post;
  }

  public function getHomeURL() {

    $home_url_relative = $this->subsite_home_url;

    if ($this->subsite_subdomain) {
      $home_url = rtrim($this->subsite_subdomain, '/') . '/' . ltrim($home_url_relative, '/');
    }
    else {
      $home_url_initial = \WPSubsite\state\SubsiteState::getInitialHomeURL();
      $home_url = ltrim($home_url_initial, '/') . '/' . $home_url_relative;
    }
   
    return $home_url;
  }

  public function save() {

    if (!$this->ID) {
      throw new \InvalidParameterException('Invalid post ID');
    }

    if (!current_user_can('edit_post', $this->ID)) {
      return;
    }

    $fields = \WPSubsite\post\SubsitePostType::getFields();

    foreach($fields as $field_obj) {

      $field_obj->setPost($this);
      $field_obj->saveValue();

    }

  }

  public function getFieldValue($field_name) {
    return get_post_meta($this->realPost->ID, $field_name, true);

  }

  public function __get($key) {

    if (isset($this->{$key})) {
      return $this->{$key};
    }

    if ($this->realPost) {

      if (metadata_exists('post', $this->realPost->ID, $key)) {
        return $this->getFieldValue($key);
      }

      return $this->realPost->{$key};
    }

    throw new \InvalidArgumentException("{$key} not found in " . get_class($this));
  }

  public function hasSubdomain() {

    $subdomain_field = new \WPSubsite\fields\Subdomain;

    return $this->getFieldValue($subdomain_field->getName());
  }
}