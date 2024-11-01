<?php

/**
 * The admin-specif  ic functionality of the plugin.
 *
 * @link       apsaraaruna.com
 * @since      1.0.0
 *
 * @package    Simple_Login_Customize
 * @subpackage Simple_Login_Customize/admin
 */

/**
 * The admin-specif  ic functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specif  ic stylesheet and JavaScript.
 *
 * @package    Simple_Login_Customize
 * @subpackage Simple_Login_Customize/admin
 * @author     Apsara Aruna <info@apsaraaruna.com>
 */
class Simple_Login_Customize_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->load_dependencies();
	}

	/**
	 * Load the required dependencies for the Admin facing functionality.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wppb_Demo_Plugin_Admin_Settings. Registers the admin settings and page.
	 *
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) .  'admin/class-simple-login-customize-admin-settings.php';

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simple_Login_Customize_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_Login_Customize_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/simple-login-customize-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simple_Login_Customize_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_Login_Customize_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-login-customize-admin.js', array( 'jquery' ), $this->version, false );

	}

	function remove_email_login(){
		remove_filter( 'authenticate', 'wp_authenticate_email_password', 20 );
	}

	function register_text( $translated ) {
		$translated = str_ireplace(
			'Username or Email Address',
			'Username',
			$translated
		);
		return $translated;
	}

	function remove_cf7_email_validation(){
		add_filter( 'wpcf7_validate_configuration', '__return_false' , 10, 3 );
	}

	function remove_wordpress_version(){
		remove_action('wp_head', 'wp_generator');
	}

	function add_filter_style($styles){
		$styles[] = 'display';
		return $styles;
	}

}
