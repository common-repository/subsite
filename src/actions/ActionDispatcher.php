<?php

namespace WPSubsite\Actions;

class ActionDispatcher {

  /**
   * Actions that have to fire on init, even before
   * current post is available
  */
  public static function getEarlyActions() {

    $actions = [

    ];

    if (subsite_freemius()->can_use_premium_code__premium_only()) {
      $actions[] = new \WPSubsite\actions\SearchExclusiveAction();
      $actions[] = new \WPSubsite\actions\SubdomainURLAction();
      $actions[] = new \WPSubsite\actions\SearchApplySubsiteAction();
    }

    return $actions;
  }

  public static function getActions() {

    return [
      //new \WPSubsite\actions\HomeURLAction(),
      new \WPSubsite\actions\BodyClassAction(),
      new \WPSubsite\actions\BreadcrumbAction(),
      new \WPSubsite\actions\MenuAction(),
      new \WPSubsite\actions\LogoAction()
    ];

  }

  public static function dispatch($subsite) {
    
    foreach (static::getActions() as $action) {
      $action->setSubsite($subsite);
      $action->apply();
    }
  }

}