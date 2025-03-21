<?php
/**
 * Guidestar Consulting Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Guidestar Consulting
 * @since 1.0.1
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_GUIDESTAR_CONSULTING_VERSION', '1.0.1' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'guidestar-consulting-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_GUIDESTAR_CONSULTING_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );


// Custom Shit
// require get_stylesheet_directory() . '/inc/roles.php';
// require get_stylesheet_directory() . '/inc/remove-admin-bar.php';
// require get_stylesheet_directory() . '/inc/header.php';
// require get_stylesheet_directory() . '/inc/logout-redirect.php';
require get_stylesheet_directory() . '/inc/water-utility.php';

require get_stylesheet_directory() . '/tools/calculators/percent-efficiency-calculator.php';
require get_stylesheet_directory() . '/tools/calculators/chemical-feed-adjustment-calculator.php';
require get_stylesheet_directory() .  '/tools/calculators/stormwater-calculator.php';
require get_stylesheet_directory() .   '/tools/calculators/avg-annual-water-loss.php';
require get_stylesheet_directory() .    '/tools/calculatorController.php';
require get_stylesheet_directory() .    '/tools/calculators/disinfection-dosing-calculator.php';