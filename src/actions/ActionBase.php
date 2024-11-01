<?php

namespace WPSubsite\actions;

abstract class ActionBase {

  protected $subsite;

  public function setSubsite(\WPSubsite\post\SubsitePost $subsite) {
    $this->subsite = $subsite;
  }

  public function getSubsite() {
    return $this->subsite;
  }

  abstract public function apply();
}