<?php
/**
 * Plugin Name: DDCE Faculty Profiles
 * Version: 1.0
 * Description: Creates a custom post type which allows a user to add a faculty profile with a name, title, and short bio. Each profile opens a modal with bio info.
 * Plugin URI: https://github.austin.utexas.edu/ddce/ddce-faculty-profiles
 * Author: Division of Diversity and Community Engagement
 * Text Domain: ddce-faculty-profiles
 */

if( !defined( 'ABSPATH' ) || !class_exists( 'DiversityFacultyProfiles') ) return;

Class DiversityFacultyProfiles {

  private static $instance = null;

  public function __construct() {

    add_action( 'init', [$this, 'initialize'], 0, 0 );

  }

  public static function instance() {
    if( isset( self::$instance) ) return self::$instance;

    return self::$instance = new DiversityFacultyProfiles();
  }

  public function initialize() {
    // Bail early if called directly from functions.php or plugin file.
    if( !did_action( 'plugins_loaded' ) ) return;

    $this->register_profiles_cpt();

    register_deactivation_hook( __FILE__, [$this, 'deactivate'] );
  }

  // Register Faculty Profiles post type
  private function register_profiles_cpt() {
    register_post_type( 'ddce-faculty-profile', [
      'labels' => [
        'name' => __( 'Faculty Profiles', 'ddce-faculty-profile' ),
        'singular_name' => __( 'Faculty Profile', 'ddce-faculty-profile' ),
      ],
      'public' => true,
      'has_archive' => false,
      'menu_icon' => 'dashicons-businessperson',
      'publicly_queryable' => true,
      'rewrite' => true,
      'show_ui' => true,
      'supports' => [
        'title',
        'thumbnail',
        'custom-fields',
      ],
    ]);

  }

} // End DiversityFacultyProfiles class

DiversityFacultyProfiles::instance();
