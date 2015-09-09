<?php
/**
 * @package   Behavior Flow
 * @author    ThemeAvenue <web@themeavenue.net>
 * @license   GPL-2.0+
 * @link      http://themeavenue.net
 * @copyright 2014 ThemeAvenue
 *
 * @wordpress-plugin
 * Plugin Name:       Behavior Flow
 * Plugin URI:        http://themeavenue.net
 * Description:       Behavior Flow helps improve the page load time of your site by preloading pages based on users behavior
 * Version:           0.1.0
 * Author:            ThemeAvenue
 * Author URI:        http://themeavenue.net
 * Text Domain:       behavior-flow
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Behavior_Flow' ) ):

	class Behavior_Flow {


		/**
		 * @var $instance Behavior_Flow Plugin instance
		 * @since 0.1.0
		 */
		private static $instance;

		/**
		 * @var array Post types available for prerendering
		 * @since 0.1.0
		 */
		public $post_types;

		/**
		 * Main Behavior_Flow Instance
		 *
		 * @since 0.1.0
		 * @return Behavior_Flow instance
		 */
		public static function instance() {

			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Behavior_Flow ) ) {
				self::$instance = new Behavior_Flow;
				self::$instance->setup_constants();
				self::$instance->includes();
				add_action( 'init', array( self::$instance, 'get_post_types' ) );
			}

			return self::$instance;

		}

		/**
		 * Throw error on object clone
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @since 0.1.0
		 * @return void
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'behavior-flow' ), '0.1.0' );
		}

		/**
		 * Disable unserializing of the class
		 *
		 * @since 0.1.0
		 * @return void
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'behavior-flow' ), '0.1.0' );
		}

		/**
		 * Setup plugin constants
		 *
		 * @since 0.1.0
		 * @return void
		 */
		private function setup_constants() {
			define( 'BF_VERSION', '0.1.0' );
			define( 'BH_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
			define( 'BH_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
		}

		/**
		 * Load all necessary files
		 *
		 * @since 0.1.0
		 * @return void
		 */
		private function includes() {
			require_once( BH_PATH . 'includes/scripts.php' );
			require_once( BH_PATH . 'includes/admin/functions-metabox.php' );
			require_once( BH_PATH . 'includes/functions-prerender.php' );
		}

		/**
		 * Get all public post types
		 *
		 * @since 0.1.0
		 * @return void
		 */
		public function get_post_types() {

			$post_types = get_post_types();
			$screens    = array();

			foreach ( $post_types as $post_type ) {

				// We don't want attachments here
				if ( 'attachment' === $post_type ) {
					continue;
				}

				$pt_object = get_post_type_object( $post_type );

				if ( is_null( $pt_object ) ) {
					continue;
				}

				if ( true === $pt_object->public ) {
					$screens[ $post_type ] = $pt_object->labels->name;
				}

			}

			$this->post_types = apply_filters( 'bf_post_types', $screens );

		}

	}

endif;

/**
 * The main function responsible for returning the one Behavior_Flow
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * @since 0.1.0
 * @return object Behavior_Flow
 */
function BF() {
	return Behavior_Flow::instance();
}

// Get Behavior Flow Running
BF();