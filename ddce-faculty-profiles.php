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

  public static function instance() {
    if( isset( self::$instance) ) return self::$instance;

    return self::$instance = new DiversityFacultyProfiles();
  }

} // End DiversityFacultyProfiles class

DiversityFacultyProfiles::instance();
