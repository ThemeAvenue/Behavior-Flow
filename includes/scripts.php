<?php
/**
 * @package   Behavior Flow/Assets
 * @author    ThemeAvenue <web@themeavenue.net>
 * @license   GPL-2.0+
 * @link      http://themeavenue.net
 * @copyright 2014 ThemeAvenue
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'admin_enqueue_scripts', 'bf_admin_scripts' );
/**
 * Register and enqueue plugin scripts
 *
 * @since 0.1.0
 * @return void
 */
function bf_admin_scripts() {
	wp_register_script( 'bf-select2', BH_URL . 'assets/js/vendor/select2.min.js', array( 'jquery' ), '3.5.2', true );
	wp_register_script( 'bf-main', BH_URL . 'assets/js/behavior-flow.js', array( 'jquery' ), BF_VERSION, true );
	wp_enqueue_script( 'bf-select2' );
	wp_enqueue_script( 'bf-main' );
}

add_action( 'admin_enqueue_scripts', 'bf_admin_stylesheets' );
/**
 * Register and enqueue plugin stylesheets
 *
 * @since 0.1.0
 * @return void
 */
function bf_admin_stylesheets() {
	wp_register_style( 'bf-main', BH_URL . 'assets/css/behavior-flow.css', false, BF_VERSION, 'all' );
	wp_enqueue_style( 'bf-main' );
}