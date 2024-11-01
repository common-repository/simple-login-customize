<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       apsaraaruna.com
 * @since      1.0.0
 *
 * @package    Simple_Login_Customize
 * @subpackage Simple_Login_Customize/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specif  ic hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identif  ier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Simple_Login_Customize
 * @subpackage Simple_Login_Customize/includes
 * @author     Apsara Aruna <info@apsaraaruna.com>
 */
class Simple_Login_Customize {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Simple_Login_Customize_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identif  ier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identif  y this plugin.
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
		if   ( defined( 'SLC_WHITE_LABEL_VERSION' ) ) {
			$this->version = SLC_WHITE_LABEL_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'simple-login-customize';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Simple_Login_Customize_Loader. Orchestrates the hooks of the plugin.
	 * - Simple_Login_Customize_i18n. Defines internationalization functionality.
	 * - Simple_Login_Customize_Admin. Defines all hooks for the admin area.
	 * - Simple_Login_Customize_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-simple-login-customize-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-simple-login-customize-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-simple-login-customize-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-simple-login-customize-public.php';

		$this->loader = new Simple_Login_Customize_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Simple_Login_Customize_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Simple_Login_Customize_i18n();

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

		$options1 = get_option('slc_display_options');
		$options2 = get_option('slc_extra_options');

		$plugin_admin = new Simple_Login_Customize_Admin( $this->get_plugin_name(), $this->get_version() );
		$plugin_settings = new Simple_Login_Customize_Admin_Settings( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		$this->loader->add_action( 'admin_menu', $plugin_settings, 'Setup_Plugin_Options_Menu' );
		$this->loader->add_action( 'admin_init', $plugin_settings, 'initialize_display_options' );
		$this->loader->add_action( 'admin_init', $plugin_settings, 'initialize_extra_options' );
		// $this->loader->add_action( 'admin_init', $plugin_settings, 'initialize_input_examples' );

		$this->loader->add_filter('safe_style_css',$plugin_admin, 'add_filter_style' );
		
		if (!empty($options1['login_username'])) {
			$this->loader->add_filter( 'authenticate', $plugin_admin, 'remove_email_login' );
			$this->loader->add_filter( 'gettext', $plugin_admin, 'register_text' );
			$this->loader->add_filter( 'ngettext', $plugin_admin, 'register_text' );
		}

		if (!empty($options2['disable_cf7_email_validation'])) {
			$this->loader->add_filter( 'init', $plugin_admin, 'remove_cf7_email_validation' );
		}		

		if (!empty($options2['slc_hide_wp_ver'])) {
			$this->loader->add_filter( 'init', $plugin_admin, 'remove_wordpress_version' );
		}

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$options1 = get_option('slc_display_options');

		$plugin_public = new Simple_Login_Customize_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'login_enqueue_scripts', $plugin_public, 'slc_login_style' );
		$this->loader->add_action( 'login_enqueue_scripts', $plugin_public, 'Slc_background_image' );
		
		$this->loader->add_filter( 'login_headerurl', $plugin_public, 'Slc_Login_Logo_url' );
		$this->loader->add_filter( 'login_headertitle', $plugin_public, 'Slc_Login_Logo_Url_title' );
		// $this->loader->add_action( 'login_head', $plugin_public, 'Slc_Custom_Login_style' );
		
		$this->loader->add_filter( 'login_footer', $plugin_public, 'Slc_Custom_Login_head' );
		$this->loader->add_filter( 'login_footer', $plugin_public, 'Slc_Copy_rights' );

		if (!empty($options1['login_logo'])) {
			$this->loader->add_filter( 'login_headerurl', $plugin_public, 'Slc_Custom_logo' );
			$this->loader->add_action( 'after_setup_theme', $plugin_public, 'Slc_Config_Custom_logo' );
		}

		if (!empty($options1['hide_lostpassword'])) {
			$this->loader->add_filter( 'login_footer', $plugin_public, 'Slc_Hide_Lost_Your_password' );
		}
		
		if (!empty($options1['back_to_blog'])) {
			$this->loader->add_filter( 'login_footer', $plugin_public, 'Slc_Back_To_blog' );
		}	
		if (!empty($options1['custom_err_msg'])) {
			$this->loader->add_filter( 'login_errors', $plugin_public, 'Slc_Custom_Login_Error_message' );

		}

		
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
	 * The name of the plugin used to uniquely identif  y it within the context of
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
	 * @return    Simple_Login_Customize_Loader    Orchestrates the hooks of the plugin.
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
