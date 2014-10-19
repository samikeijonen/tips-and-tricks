<?php
/**
 * Plugin Name:       Tips and tricks
 * Plugin URI:        https://foxland.fi/downloads/tips-and-tricks
 * Description:       Helpful tips and tricks for editors.
 * Version:           1.0.0
 * Author:            Sami Keijonen
 * Author URI:        https://foxland.fi
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain:       tips-and-tricks
 * Domain Path:       /languages
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License as published by the Free Software Foundation; either version 2 of the License, 
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write 
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package    Tips and Tricks
 * @version    1.0.0
 * @author     Sami Keijonen <sami.keijonen@foxnet.fi>
 * @copyright  Copyright (c) 2014, Sami Keijonen
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Sets up and initializes the Message Board plugin.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
final class Tips_And_Tricks {

	public $version;

	public $dir_path = '';

	public $dir_uri = '';

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new Tips_And_Tricks;
			$instance->setup();
			$instance->includes();
			$instance->setup_actions();
		}

		return $instance;
	}

	private function __construct() {}

	private function setup() {
	
		$this->version  = '1.0.0';
		$this->dir_path = trailingslashit( plugin_dir_path( __FILE__ ) );
		$this->dir_uri  = trailingslashit( plugin_dir_url(  __FILE__ ) );
	}

	private function includes() {

		require_once( $this->dir_path . 'includes/post-types.php' );
		require_once( $this->dir_path . 'includes/taxonomies.php' );


		if ( is_admin() ) {
			require_once( $this->dir_path . 'admin/admin-functions.php' );
		}
		
	}

	private function setup_actions() {

		/* Internationalize the text strings used. */
		add_action( 'plugins_loaded', array( $this, 'i18n' ), 2 );
		
		/* Enqueue admin scripts and styles. */
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

	}

	/**
	 * Loads the translation files.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function i18n() {
		load_plugin_textdomain( 'tips-and-tricks', false, 'tips-and-tricks/languages' );
	}
	
	/**
	* Load scripts for the setting page.
	*
	* @since  1.0.0
	* @return void
	*/
	public function enqueue_admin_scripts( $hook ) {
	
		/* Return if we are not on 'post.php' or 'post-new.php'. */
		if( $hook != 'post.php' && $hook != 'post-new.php' ) {
			return;
		}
		
		/* Use the .min stylesheet if SCRIPT_DEBUG is turned off. */
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	
		/* Load admin js. */
		wp_enqueue_script( 'tips-and-tricks-admin-js', plugin_dir_url(__FILE__) . 'admin/js/tips-and-tricks-admin' . $suffix . '.js', array(), $this->version );
	
		/* Load admin styles. */
		wp_enqueue_style( 'tips-and-tricks-admin-styles', plugin_dir_url(__FILE__) . 'admin/css/tips-and-tricks-admin' . $suffix . '.css', array(), $this->version );
	
	}
	
}

function tips_and_tricks() {
	return Tips_And_Tricks::get_instance();
}

tips_and_tricks();
