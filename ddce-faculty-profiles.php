<?php
/**
 * Plugin Name: DDCE Faculty Profiles
 * Version: 1.0
 * Description: Creates a custom post type which allows a user to add a faculty profile with a name, title, and short bio. Each profile opens a modal with bio info.
 * Plugin URI: https://github.austin.utexas.edu/ddce/ddce-faculty-profiles
 * Author: Division of Diversity and Community Engagement
 * Text Domain: ddce-faculty-profiles
 */

if( !defined( 'ABSPATH' ) || !class_exists( 'DiversityFacultyDirectory') ) return;

Class DiversityFacultyDirectory {

  private static $instance = null;

  public function __construct() {
    // Define path and URL to the ACF plugin.
    define( 'DIVERSITYPROFILES_ACF_PATH', plugin_dir_path( __FILE__ ) . 'includes/acf/' );
    define( 'DIVERSITYPROFILES_ACF_URL', plugin_dir_url( __FILE__ ) . 'includes/acf/' );

    add_action( 'init', [$this, 'initialize'], 0, 0 );
    add_shortcode( 'faculty_profile', [$this, 'registers_faculty_shortcode'] );

  }

  public static function instance() {
    self::$instance ?? self::$instance;

    return self::$instance = new DiversityFacultyDirectory();
  }

  public function initialize() {
    // Bail early if called directly from functions.php or plugin file.
    if( !did_action( 'plugins_loaded' ) ) return;

    $this->register_profiles_cpt();

    require_once( plugin_dir_path( __FILE__ ) . 'admin/acf-fields.php' );

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
      'publicly_queryable' => false,
      'rewrite' => true,
      'show_ui' => true,
      'supports' => [
        'title',
        'thumbnail',
      ],
    ]);
  }

  // Add Shortcode
  public function registers_faculty_shortcode( $atts ) {
    ob_start();

    // Attributes
    $atts = shortcode_atts(
      array(
        'slug' => '',
      ),
      $atts,
      'faculty_profile'
    );

    $profile = get_posts([
      'name' => sanitize_text_field($atts['slug']),
      'post_type' => 'ddce-faculty-profile'
    ]);

    return '<div class="ddce-faculty-profile-container"><div class="ddce-faculty-profile-image">' . get_the_post_thumbnail($profile[0]->ID) . '</div><h3>' . $profile[0]->post_title . '</h3><h4>' . get_post_meta($profile[0]->ID, 'role', true) .'</h4></div>';

    return ob_get_clean();
  }

} // End DiversityFacultyDirectory class

DiversityFacultyDirectory::instance();
