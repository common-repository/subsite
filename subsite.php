<?php

/**
 * WP Subsite
 *
 * @package JK
 * @author JK Plugins
 *
 * Plugin Name:       Subsite
 * Description:       Create subsites within a WordPress site
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Version:           1.0
 * Author:            JK Plugins
 * Text Domain:       wp_subsite
 * Author URI:        https://www.jkplugins.com
 *
 * @package           jk-plugins
 */

 if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require __DIR__ . '/vendor/autoload.php';

/* Register Custom Post Type */
\WPSubsite\post\SubsitePostType::initialize();

/* Initialize Global Post Actions */
\WPSubsite\post\PostActions::initialize();

/* Dispatch Actions if a subsite is active */
add_action('wp', function() {
  $subsite = \WPSubsite\state\SubsiteState::getActiveSubsite();

  if ($subsite) {
    \WPSubsite\actions\ActionDispatcher::dispatch($subsite);
  }

});


add_action( 'init',  function() {

  \WPSubsite\state\SubsiteState::$homeURLInitial = get_home_url();

  $actions = \WPSubsite\actions\ActionDispatcher::getEarlyActions();

  foreach($actions as $action) {
    $action->apply();
  }

} );

/* Add CSS */
add_action('admin_enqueue_scripts', function() {
  wp_enqueue_style('wpsubsite-styles',
    plugins_url('src' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'wp-subsite.css', __FILE__)
  );
});

if ( ! function_exists( 'subsite_freemius' ) ) {
  // Create a helper function for easy SDK access.
  function subsite_freemius() {
      global $subsite_freemius;

      if ( ! isset( $subsite_freemius ) ) {
          // Include Freemius SDK.
          require_once dirname(__FILE__) . '/freemius/start.php';

          $subsite_freemius = fs_dynamic_init( array(
              'id'                  => '12864',
              'slug'                => 'subsite',
              'type'                => 'plugin',
              'public_key'          => 'pk_620239e6b9c79f19e13ba0220a13f',
              'is_premium'          => true,
              'premium_suffix'      => 'Pro',
              // If your plugin is a serviceware, set this option to false.
              'has_premium_version' => true,
              'has_addons'          => false,
              'has_paid_plans'      => true,
              'trial'               => array(
                  'days'               => 14,
                  'is_require_payment' => false,
              ),
              'menu'                => array(
                  'first-path'     => 'plugins.php',
                  'support'        => false,
              ),
          ) );
      }

      return $subsite_freemius;
  }

  // Init Freemius.
  subsite_freemius();
  // Signal that SDK was initiated.
  do_action( 'subsite_freemius_loaded' );
}



