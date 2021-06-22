<?php
/**
 * Plugin Name: DDCE Profiles
 * Version: 1.0
 * Description: Creates a custom post type which allows a user to add a profile with a name, title, and short bio. Each profile opens a modal with bio info.
 * Plugin URI: https://github.austin.utexas.edu/ddce/ddce-profiles
 * Author: Division of Diversity and Community Engagement
 * Text Domain: ddce-profiles
 */

if( !defined( 'ABSPATH' ) || !class_exists( 'DiversityProfilesDirectory') ) return;

Class DiversityProfilesDirectory {

  private static $instance = null;

  public function __construct() {
    // Define path and URL to the ACF plugin.
    define( 'DIVERSITYPROFILES_ACF_PATH', plugin_dir_path( __FILE__ ) . 'includes/acf/' );
    define( 'DIVERSITYPROFILES_ACF_URL', plugin_dir_url( __FILE__ ) . 'includes/acf/' );

    add_action( 'init', [$this, 'initialize'], 0, 0 );
    add_shortcode( 'ddce_profile', [$this, 'registers_ddce_profile_shortcode'] );
    add_action('wp_footer', [$this, 'adds_modal_to_footer']);

  }

  public static function instance() {
    self::$instance ?? self::$instance;

    return self::$instance = new DiversityProfilesDirectory();
  }

  public static function initialize() {
    // Bail early if called directly from functions.php or plugin file.
    if( !did_action( 'plugins_loaded' ) ) return;

    $this->register_profiles_cpt();

    require_once( plugin_dir_path( __FILE__ ) . 'admin/acf-fields.php' );

  }

  // Register DDCE Profiles post type
  private static function register_profiles_cpt() {
    register_post_type( 'ddce-profile', [
      'labels' => [
        'name' => __( 'DDCE Profiles', 'ddce-profile' ),
        'singular_name' => __( 'DDCE Profile', 'ddce-profile' ),
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
  public static function registers_ddce_profile_shortcode( $atts ) {

    wp_enqueue_script( 'ddce_profiles_modal_js', plugin_dir_url( __FILE__ ) . 'frontend/js/ddce-profiles-modal.js', [], NULL, true );
    add_action( 'wp_enqueue_scripts', 'ddce_profiles_modal_js' );

    wp_enqueue_style( 'ddce_profiles_modal_styles', plugin_dir_url( __FILE__ ) . 'frontend/css/ddce-profiles-modal.css' );
    add_action( 'wp_enqueue_scripts', 'ddce_profiles_modal_styles' );

    ob_start();

    // Attributes
    $atts = shortcode_atts(
      array(
        'slug' => '',
      ),
      $atts,
      'ddce_profile'
    );

    $profile = get_posts([
      'name' => sanitize_text_field($atts['slug']),
      'post_type' => 'ddce-profile'
    ]);

    return '<div class="ddce-profile-container" tabindex="0"><div class="ddce-profile-image">' . get_the_post_thumbnail($profile[0]->ID) . '</div><h3 class="ddce-profile-name">' . $profile[0]->post_title . '</h3><h4 class="ddce-profile-role">' . get_post_meta($profile[0]->ID, 'role', true) . '</h4><div class="ddce-profile-background">' . get_post_meta($profile[0]->ID, 'background', true) . '</div></div>';

    return ob_get_clean();
  }

  public static function adds_modal_to_footer(){
    echo '<div id="profileInfoModal" aria-hidden="true" tabindex="-1" role="dialog"><article class="modal-info"><button type="button" class="close rounded-circle" aria-label="Close" data-dismiss="modal">X<span aria-hidden="true" class="sr-only">Close Modal</span></button><h1 class="modal-profile-name"></h1><h2 class="modal-profile-role"></h2><hr/><div class="modal-profile-background"></div></article></div>';
  }

} // End DiversityProfilesDirectory class

DiversityProfilesDirectory::instance();
