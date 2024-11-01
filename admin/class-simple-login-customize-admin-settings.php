<?php

/**
 * The settings of the plugin.
 *
 * @link       http://devinvinson.com
 * @since      1.0.0
 *
 * @package    Simple_Login_Customize
 * @subpackage Simple_Login_Customize/admin
 */

/**
 * Class WordPress_Plugin_Template_Settings
 *
 */
class Simple_Login_Customize_Admin_Settings {

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

	}

	/**
	 * This function introduces the theme options into the 'Settings' menu and into a top-level
	 * 'Simple_Login_Customize' menu.
	 */
	public function Setup_Plugin_Options_Menu() {

		//Add the menu to the Plugins set of menu items
		add_options_page(
			'Simple Login Customize Options',// The title to be displayed in the browser window for this page.
			'Simple Login Customize',// The text to be displayed for this menu item
			'manage_options',// Which type of users can see this menu item
			'slc_options',// The unique ID - that is, the slug - for this menu item
			array( $this, 'Render_Settings_Page_content')// The name of the function to call when rendering this menu's page
		);

	}

	/**
	 * Provides default values for the Display Options.
	 *
	 * @return array
	 */
	public function Default_Display_options() {

		$defaults = array(
			'login_username'	=>	0,
			'hide_lostpassword'	=>	0,
			'back_to_blog'		=>	0,
			'login_logo'		=>	0,
			'custom_err_msg '	=>	0,
			'custom_err_msg_txt'=>	'Please enter valid login credentials.',
			'background_category' => 'sport'
		);

		return $defaults;

	}

		/**
	 * Provide default values for the Social Options.
	 *
	 * @return array
	 */
		public function default_social_options() {

			$defaults = array(
				'cf7_email_valid'	=>	'',
				'hide_wp_ver'		=>	'',
				'googleplus'	=>	'',
			);

			return  $defaults;

		}


	/**
	 * Renders a simple page to display for the theme menu defined above.
	 */
	public function Render_Settings_Page_content( $active_tab = '' ) {
		?>
		<!-- Create a header in the default WordPress 'wrap' container -->
		<div class="wrap">

			<h2><?php _e( 'Simple Login Customize Options', 'simple-login-customize' ); ?></h2>
			<?php //settings_errors(); ?>

			<?php if ( isset( $_GET[ 'tab' ] ) ) {
				$active_tab = isset($_GET['tab']) ? sanitize_key($_GET['tab']) : 'display_options';;
			} else if ( $active_tab == 'extra_options' ) {
				$active_tab = 'extra_options';
			} else if ( $active_tab == 'input_examples' ) {
				$active_tab = 'input_examples';
			} else {
				$active_tab = 'display_options';
			} // end if  /else ?>

			<h2 class="nav-tab-wrapper">
				<a href="?page=slc_options&tab=display_options" class="nav-tab <?php echo $active_tab == 'display_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Admin Login Options', 'simple-login-customize' ); ?></a>
				<a href="?page=slc_options&tab=extra_options" class="nav-tab <?php echo $active_tab == 'extra_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Help', 'simple-login-customize' ); ?></a>
			</h2>

			<form method="post" action="options.php">
				<?php

				if ( $active_tab == 'display_options' ) {

					settings_fields( 'slc_display_options' );
					do_settings_sections( 'slc_display_options' );

					submit_button();

				} elseif ( $active_tab == 'extra_options' ) {

					settings_fields( 'slc_extra_options' );
					do_settings_sections( 'slc_extra_options' );

				} else {

					settings_fields( 'slc__input_examples' );
					do_settings_sections( 'slc_input_examples' );

				} 

				?>
			</form>

		</div><!-- /.wrap -->
		<?php
	}


	/**
	 * This function provides a simple description for the General Options page.
	 *
	 * It's called from the 'slc_initialize_theme_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function general_options_callback() {
		$options = get_option('slc_display_options');
		// var_dump($options);
		// echo '<p>' . __( 'Select which areas of content you wish to display.', 'simple-login-customize' ) . '</p>';
	} // end general_options_callback




	/**
	 * Initializes the theme's display options page by registering the Sections,
	 * Fields, and Settings.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_display_options() {

		// if   the theme options don't exist, create them.
		if ( false == get_option( 'slc_display_options' ) ) {
			$default_array = $this->Default_Display_options();
			add_option( 'slc_display_options', $default_array );
		}


		add_settings_section(
			'general_settings_section', // ID used to identif  y this section and with which to register options
			__( 'Admin Login Options', 'simple-login-customize' ),// Title to be displayed on the administration page
			array( $this, 'general_options_callback'),// Callback used to render the description of the section
			'slc_display_options'// Page on which to add this section of options
		);

		add_settings_field(
			'login_logo',
			__( 'Custom Logo', 'simple-login-customize' ),
			array( $this, 'toggle_login_logo_callback'),
			'slc_display_options',
			'general_settings_section',
			array(
				__( 'Activate this setting to show the custom logo. Add logo in <a href="customize.php">here.</a> Logo size 300x100px', 'simple-login-customize' ),
			)
		);

		// Next, we'll introduce the fields for toggling the visibility of content elements.
		add_settings_field(
			'login_username', // ID used to identif  y the field throughout the theme
			__( 'Login with Username', 'simple-login-customize' ),// The label to the left of the option interface element
			array( $this, 'Login_With_Username_callback'),// The name of the function responsible for rendering the option interface
			'slc_display_options',// The page on which this option will be displayed
			'general_settings_section',// The name of the section to which this field belongs
			array( // The array of arguments to pass to the callback. In this case, just a description.
				__( 'Activate login with only username.', 'simple-login-customize' ),
			)
		);

		add_settings_field(
			'show_content',
			__( 'Lost password', 'simple-login-customize' ),
			array( $this, 'toggle_content_callback'),
			'slc_display_options',
			'general_settings_section',
			array(
				__( 'Activate this setting to hide the lost password.', 'simple-login-customize' ),
			)
		);

		add_settings_field(
			'back_to_blog',
			__( 'Back to blog', 'simple-login-customize' ),
			array( $this, 'toggle_footer_callback'),
			'slc_display_options',
			'general_settings_section',
			array(
				__( 'Activate this setting to hide the back to blog.', 'simple-login-customize' ),
			)
		);

		add_settings_field(
			'custom_error_msg',
			__( 'Custom error message', 'simple-login-customize' ),
			array( $this, 'toggle_custom_error_msg_callback'),
			'slc_display_options',
			'general_settings_section',
			array(
				__( 'Activate this setting to customize login error message.', 'simple-login-customize' ),
			)
		);

		add_settings_field(
			'background_image_category',
			__( 'Background category', 'simple-login-customize' ),
			array( $this, 'toggle_background_image_callback'),
			'slc_display_options',
			'general_settings_section',
			array(
				__( 'Activate this setting to customize login error message.', 'simple-login-customize' ),
			)
		);
		// Finally, we register the fields with WordPress
		register_setting(
			'slc_display_options',
			'slc_display_options',
			'validate_input_examples'
		);

	} // end slc_initialize_theme_options

	/**
	 * This function renders the interface elements for toggling the visibility of the header element.
	 *
	 * It accepts an array or arguments and expects the first element in the array to be the description
	 * to be displayed next to the checkbox.
	 */
	public function Login_With_Username_callback($args) {

		// First, we read the options collection
		$options = get_option('slc_display_options');

		// Next, we update the name attribute to access this element's ID in the context of the display options array
		// We also access the login_username element of the options collection in the call to the checked() helper function
		$html = '<input type="checkbox" id="login_username" name="slc_display_options[login_username]" value="1" ' . checked( 1, isset( $options['login_username'] ) ? $options['login_username'] : 0, false ) . '/>';

		// Here, we'll take the first argument of the array and add it to a label next to the checkbox
		$html .= '<label for="login_username">&nbsp;'  . $args[0] . '</label>';

		$allowed_html = array(
			'input' => array(
				'type'  => array(),
				'id'    => array(),
				'name'  => array(),
				'value' => array(),
				'checked'  => array()
			),
		);

		echo wp_kses($html ,$allowed_html );

	} // end Login_With_Username_callback

	public function toggle_content_callback($args) {

		$options = get_option('slc_display_options');

		$html = '<input type="checkbox" id="hide_lostpassword" name="slc_display_options[hide_lostpassword]" value="1" ' . checked( 1, isset( $options['hide_lostpassword'] ) ? $options['hide_lostpassword'] : 0, false ) . '/>';
		$html .= '<label for="hide_lostpassword">&nbsp;'  . $args[0] . '</label>';

		$allowed_html = array(
			'input' => array(
				'type'  => array(),
				'id'    => array(),
				'name'  => array(),
				'value' => array(),
				'checked'  => array()
			),
		);

		echo wp_kses($html ,$allowed_html );

	} // end toggle_content_callback

	public function toggle_footer_callback($args) {

		$options = get_option('slc_display_options');

		$html = '<input type="checkbox" id="back_to_blog" name="slc_display_options[back_to_blog]" value="1" ' . checked( 1, isset( $options['back_to_blog'] ) ? $options['back_to_blog'] : 0, false ) . '/>';
		$html .= '<label for="back_to_blog">&nbsp;'  . $args[0] . '</label>';

		$allowed_html = array(
			'input' => array(
				'type'  => array(),
				'id'    => array(),
				'name'  => array(),
				'value' => array(),
				'checked'  => array()
			),
		);

		echo wp_kses($html ,$allowed_html );

	} // end toggle_footer_callback	

	public function toggle_custom_error_msg_callback($args) {

		$options = get_option('slc_display_options');


		if (!isset( $options['custom_err_msg'] )) {
			$options['custom_err_msg'] = 0;
		}

		$html = '<input type="checkbox" id="custom_err_msg" onclick="OnChangeCheckbox(this)" name="slc_display_options[custom_err_msg]" value="1" ' . checked( 1, isset( $options['custom_err_msg'] ) ? $options['custom_err_msg'] : 0, false ) . '/>';
		$html .= '<label for="custom_err_msg">&nbsp;'  . $args[0] . '</label>';
		$display = ($options['custom_err_msg'] == 0) ? "display:none" : "display:block";

		$html .= '<p id="custom_txt" style="'. $display .'"><input type="text"  id="custom_err_msg_txt" name="slc_display_options[custom_err_msg_txt]" value="' . $options['custom_err_msg_txt'] . '" /></p>';

		$allowed_html = array(
			'input' => array(
				'type'  => array(),
				'id'    => array(),
				'name'  => array(),
				'value' => array(),
				'onclick' => array(),
				'checked'  => array(),
			),
			'p' =>array(
				'id' => array(),
				'style' => array(),
			)

		);

		echo wp_kses($html ,$allowed_html );

	} // end toggle_custom_error_msg_callback	

	public function toggle_login_logo_callback($args) {

		$options = get_option('slc_display_options');

		add_theme_support( 'custom-logo' );

		$html = '<input type="checkbox" id="login_logo" name="slc_display_options[login_logo]" value="1" ' . checked( 1, isset( $options['login_logo'] ) ? $options['login_logo'] : 0, false ) . '/>';
		$html .= '<label for="login_logo">&nbsp;'  . $args[0] . '</label>';

		$allowed_html = array(
			'input' => array(
				'type'  => array(),
				'id'    => array(),
				'name'  => array(),
				'value' => array(),
				'checked'  => array()
			),
			'a' => array(
				'href' => array()
			)
		);

		echo wp_kses($html ,$allowed_html );

	} // end toggle_login_logo_callback

	public function toggle_background_image_callback(){
		$options = get_option('slc_display_options');

		if ( empty($options['background_category']) ) {
			$default_array = $this->Default_Display_options();
			$options['background_category'] = $default_array['background_category'];
		}

		$html = '<select id="background_category" name="slc_display_options[background_category]">';
		$html .= '<option value="nature" selected>' . __( 'Nature', 'simple-login-customize' ) . '</option>';
		$html .= '<option value="sport"' . selected( $options['background_category'], 'sport', false) . '>' . __( 'Sport', 'simple-login-customize' ) . '</option>';
		$html .= '<option value="landscape"' . selected( $options['background_category'], 'landscape', false) . '>' . __( 'Landscape', 'simple-login-customize' ) . '</option>';
		$html .= '<option value="background"' . selected( $options['background_category'], 'background', false) . '>' . __( 'Background', 'simple-login-customize' ) . '</option>';
		$html .= '<option value="wallpaper"' . selected( $options['background_category'], 'wallpaper', false) . '>' . __( 'Wallpaper', 'simple-login-customize' ) . '</option>';
		$html .= '<option value="flower"' . selected( $options['background_category'], 'flower', false) . '>' . __( 'Flower', 'simple-login-customize' ) . '</option>';
		$html .= '<option value="fashion"' . selected( $options['background_category'], 'fashion', false) . '>' . __( 'Fashion', 'simple-login-customize' ) . '</option>';
		$html .= '<option value="health"' . selected( $options['background_category'], 'health', false) . '>' . __( 'Health', 'simple-login-customize' ) . '</option>';
		$html .= '<option value="travel"' . selected( $options['background_category'], 'travel', false) . '>' . __( 'Travel', 'simple-login-customize' ) . '</option>';
		$html .= '<option value="animal"' . selected( $options['background_category'], 'animal', false) . '>' . __( 'Animal', 'simple-login-customize' ) . '</option>';
		$html .= '<option value="arts"' . selected( $options['background_category'], 'arts', false) . '>' . __( 'Arts', 'simple-login-customize' ) . '</option>';
		$html .= '<option value="water"' . selected( $options['background_category'], 'water', false) . '>' . __( 'Water', 'simple-login-customize' ) . '</option>';	$html .= '</select>';

		$allowed_html = array(
			'select' => array(
				'id'    => array(),
				'name'  => array(),
				'value' => array(),
				'checked'  => array()
			),
			'option' =>array(
				'value' => array(),
				'disabled' => array(),
				'selected' => array()
			)
		);

		echo wp_kses($html ,$allowed_html );
	}


	public function validate_input_examples( $input ) {

		// Create our array for storing the validated options
		$output = array();

		// Loop through each of the incoming options
		foreach( $input as $key => $value ) {

			// Check to see if   the current option has a value. if   so, process it.
			if ( isset( $input[$key] ) ) {

				// Strip all HTML and PHP tags and properly handle quoted strings
				$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );

			} // end if  

		} // end foreach

		// Return the array processing any additional functions filtered by this action
		return apply_filters( 'validate_input_examples', $output, $input );

	} // end validate_input_examples



	/**
	 * Initializes the theme's social options by registering the Sections,
	 * Fields, and Settings.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_extra_options() {
		// delete_option('slc_extra_options');
		if( false == get_option( 'slc_extra_options' ) ) {
			$default_array = $this->default_social_options();
			update_option( 'slc_extra_options', $default_array );
		} // end if

		add_settings_section(
			'extra_settings_section',// ID used to identify this section and with which to register options
			__( 'Help', 'slc-while-label' ),// Title to be displayed on the administration page
			array( $this, 'social_options_callback'),	// Callback used to render the description of the section
			'slc_extra_options'		// Page on which to add this section of options
		);

		register_setting(
			'slc_extra_options',
			'slc_extra_options',
			'validate_input_examples',
			array( $this, 'sanitize_social_options')
		);

	}

	/**
	 * This function provides a simple description for the Social Options page.
	 *
	 * It's called from the 'slc__theme_initialize_social_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function social_options_callback() {
		echo '<h2>You may also like this plugin</h2>
		<p> <a href="https://wordpress.org/plugins/widget-youtube-subscribtion/" target="_blank">Easy Youtube Subscribe Button Widget >></a></p>
		<p> <a href="https://wordpress.org/plugins/popup-notification-news-alert/" target="_blank">Toast Popup Notification News Alert >></a></p>
		<p> <a href="https://wordpress.org/plugins/embed-page-facebook/" target="_blank">Easy Facebook Embed Page Widget >></a></p>';
	} // end general_options_callback



}