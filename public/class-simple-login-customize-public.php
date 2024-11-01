<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       apsaraaruna.com
 * @since      1.0.0
 *
 * @package    Simple_Login_Customize
 * @subpackage Simple_Login_Customize/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Simple_Login_Customize
 * @subpackage Simple_Login_Customize/public
 * @author     Apsara Aruna <info@apsaraaruna.com>
 */
class Simple_Login_Customize_Public {

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
		 * defined in Simple_Login_Customize_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_Login_Customize_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/simple-login-customize-public.css', array(), $this->version, 'all' );
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
		 * defined in Simple_Login_Customize_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_Login_Customize_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-login-customize-public.js', array( 'jquery' ), $this->version, false );

	}

	function Slc_Custom_logo(){ 
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
		?>
		<style type="text/css">
			#login h1 a, .login h1 a {background-image: url('<?php echo esc_url($image[0]) ?>');}
			</style><?php
		}

		function Slc_Login_Logo_url() {
			return home_url();
		}

		function Slc_Login_Logo_Url_title() {
			return get_bloginfo();
		}

		function slc_login_style()
		{
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/custom-login-style.css', array(), $this->version, 'all' );
		}
		

		function Slc_Custom_Login_Error_message(){
			$options = get_option('slc_display_options');

			if ($options['custom_err_msg_txt'] =="") {
				return 'Please enter valid login credentials.';
			} else {
				return $options['custom_err_msg_txt'];
			}
			
		}

		function Slc_background_image(){ 
			$options = get_option('slc_display_options');
			?>
			<style>body.login { background: linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.45)), url( "https://source.unsplash.com/random/1600/?<?php echo $options['background_category']; ?>" ) !important; background-repeat: no-repeat !important; background-attachment: fixed !important; background-position: center !important; background-size: cover !important;</style>
		<?php }

		function Slc_Custom_Login_head() {
			remove_action('login_footer', 'wp_shake_js', 12);
		}

		function Slc_Hide_Lost_Your_password(){ ?>
			<style type="text/css">p#nav{display: none;}</style><?php 
		}	

		function Slc_Back_To_blog(){ ?>
			<style type="text/css">p#backtoblog{display: none;}</style><?php 
		}

		function Slc_Copy_rights(){
			echo '<div><p class="copyrights">&copy; '.date('Y').' | '. get_bloginfo().'. All rights reserved. </p></div>';
		}

		function Slc_Config_Custom_logo() {

			add_theme_support( 'custom-logo' );

		}

	}
