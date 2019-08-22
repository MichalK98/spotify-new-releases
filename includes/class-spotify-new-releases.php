<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       chickencross.se
 * @since      1.0.0
 *
 * @package    Spotify_New_Releases
 * @subpackage Spotify_New_Releases/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Spotify_New_Releases
 * @subpackage Spotify_New_Releases/includes
 * @author     Michal Kurowski <michal10203040@gmail.com>
 */
class Spotify_New_Releases {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Spotify_New_Releases_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'SPOTIFY_NEW_RELEASES_VERSION' ) ) {
			$this->version = SPOTIFY_NEW_RELEASES_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'spotify-new-releases';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		// Register widget
		$this->register_widget();

		// Register ajax actions
		$this->register_ajax_actions();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Spotify_New_Releases_Loader. Orchestrates the hooks of the plugin.
	 * - Spotify_New_Releases_i18n. Defines internationalization functionality.
	 * - Spotify_New_Releases_Admin. Defines all hooks for the admin area.
	 * - Spotify_New_Releases_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-spotify-new-releases-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-spotify-new-releases-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-spotify-new-releases-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-spotify-new-releases-public.php';
		
		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-spotify-new-releases-widget.php';
		
		$this->loader = new Spotify_New_Releases_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Spotify_New_Releases_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Spotify_New_Releases_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Spotify_New_Releases_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Spotify_New_Releases_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Register the widget for the plugin.
	 *
	 * @since    1.0.0
	 */
	public function register_widget() {
		add_action('widgets_init', function(){
			register_widget('Spotify_New_Releases_Widget');
		});
	}

	/**
	 * Register the ajax actions.
	 *
	 * @since    1.0.0
	 */
	public function register_ajax_actions() {
		// POSTMAN
		// POST http://plugins.test/wp-admin/admin-ajax.php
		// action | spotify_dog__get

		// register action 'spotify_dog__get'
		// alla wp ajax actions registreras med 'wp_ajax_' fölt av namnet på action 'spotify_dog__get'
		add_action('wp_ajax_spotify_dog__get', [
			$this,
			'ajax_spotify_dog__get'
		]);
		// inte inloggad
		add_action('wp_ajax_nopriv_spotify_dog__get', [
			$this,
			'ajax_spotify_dog__get'
		]);
	}

	/**
	 * Respond to ajax action 'spotify_dog__get'.
	 *
	 * @since    1.0.0
	 */
	public function ajax_spotify_dog__get() {
		$response = wp_remote_get(SPOTIFY_RANDOM_DOG__GET_URL);
		// Nu vill vi kolla om det gick fel.
		if (is_wp_error($response) || wp_remote_retrieve_response_code($response) != 200) {
			// wp_send_json_error tar emot 1 param ($data)
			// den kommer retunera ett json objekt
			// {
			// "success": false,
			// "data": "nope"
			//}
			wp_send_json_error([
				// skickar in key value
				// få ut error koden
				'error_code' => wp_remote_retrieve_response_code($response),
				// få ut error msg
				'error_msg' => wp_remote_retrieve_response_message($response),
				// testa ändra SPOTIFY_RANDOM_DOG__GET_URL för att se om det funkar
			]);
		}
		// decode $body
		$body = json_decode(wp_remote_retrieve_body($response));
		// Få ut endast url genom $body->url

		// 1. Find out path from URL
		$url_path = parse_url($body->url, PHP_URL_PATH);
		
		// 2. Find the file extension from path
		$file_extension = pathinfo($url_path, PATHINFO_EXTENSION);

		// 3. If extension is 'mp4/ogv/avi' set type to viedo
		$video_extensions = ['mp4', 'ogv', 'avi'];
		$is_video = in_array(strtolower($file_extension), $video_extensions);
		
		if ($is_video) {
			$type = "video";
		} else {
			$type = "image";
		}

		wp_send_json_success([
			'type' => $type,
			'src' => $body->url,
		]);
	}
	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Spotify_New_Releases_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
