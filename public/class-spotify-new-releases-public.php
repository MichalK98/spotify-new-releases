<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       chickencross.se
 * @since      1.0.0
 *
 * @package    Spotify_New_Releases
 * @subpackage Spotify_New_Releases/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Spotify_New_Releases
 * @subpackage Spotify_New_Releases/public
 * @author     Michal Kurowski <michal10203040@gmail.com>
 */
class Spotify_New_Releases_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Spotify_New_Releases_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Spotify_New_Releases_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/spotify-new-releases-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Spotify_New_Releases_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Spotify_New_Releases_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/spotify-new-releases-public.js', array( 'jquery' ), $this->version, true );
		wp_localize_script($this->plugin_name, 'spotify_dog_ajax_obj', [
			'ajax_url' => admin_url('admin-ajax.php'),
			]);
	}

}
