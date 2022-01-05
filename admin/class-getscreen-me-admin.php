<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://getscreen.me
 * @since      1.0.0
 *
 * @package    GetScreen_Me
 * @subpackage GetScreen_Me/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    GetScreen_Me
 * @subpackage GetScreen_Me/admin
 * @author     Michael Dyhr Iversen <michael@qcompany.dk>
 */
class GetScreen_Me_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $getscreen_me    The ID of this plugin.
	 */
	private $getscreen_me;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The Options of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $getscreen_me    The ID of this plugin.
	 */
	private $getscreen_me_options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $getscreen_me       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $getscreen_me, $version ) {

		$this->getscreen_me = $getscreen_me;
		$this->version = $version;
		add_action( 'admin_menu', array( $this, 'getscreen_me_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'getscreen_me_page_init' ) );
		
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
		 * defined in GetScreen_Me_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The GetScreen_Me_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->getscreen_me, plugin_dir_url( __FILE__ ) . 'css/getscreen-me-admin.css', array(), $this->version, 'all' );

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
		 * defined in GetScreen_Me_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The GetScreen_Me_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->getscreen_me, plugin_dir_url( __FILE__ ) . 'js/getscreen-me-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function getscreen_me_settings_link( $links ) {
		// Build and escape the URL.
		$url = esc_url( add_query_arg(
			'page',
			'getscreen-me',
			get_admin_url() . 'admin.php'
		) );
		// Create the link.
		$settings_link = "<a href='$url'>" . __( 'Settings' ) . '</a>';
		// Adds the link to the end of the array.
		array_push(
			$links,
			$settings_link
		);
		return $links;
	}

	public function getscreen_me_add_plugin_page() {
		add_options_page(
			'GetScreen.Me', // page_title
			'GetScreen.Me', // menu_title
			'manage_options', // capability
			'getscreen-me', // menu_slug
			array( $this, 'getscreen_me_create_admin_page' ) // function
		);
	}

	public function getscreen_me_create_admin_page() {
		$this->getscreen_me_options = get_option( 'getscreen_me_option_name' ); ?>

		<div class="wrap">
			<h2>GetScreen.Me</h2>
			<p>Find your api key here: https://getscreen.me/dashboard/integrate/api</p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'getscreen_me_option_group' );
					do_settings_sections( 'getscreen-me-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function getscreen_me_page_init() {
		register_setting(
			'getscreen_me_option_group', // option_group
			'getscreen_me_option_name', // option_name
			array( $this, 'getscreen_me_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'getscreen_me_setting_section', // id
			'Settings', // title
			array( $this, 'getscreen_me_section_info' ), // callback
			'getscreen-me-admin' // page
		);

		add_settings_field(
			'api_key_0', // id
			'API Key', // title
			array( $this, 'api_key_0_callback' ), // callback
			'getscreen-me-admin', // page
			'getscreen_me_setting_section' // section
		);

		add_settings_field(
			'show_client_name_input_1', // id
			'Show Client Name input', // title
			array( $this, 'show_client_name_input_1_callback' ), // callback
			'getscreen-me-admin', // page
			'getscreen_me_setting_section' // section
		);

		add_settings_field(
			'force_client_name_input_2', // id
			'Force Client Name input', // title
			array( $this, 'force_client_name_input_2_callback' ), // callback
			'getscreen-me-admin', // page
			'getscreen_me_setting_section' // section
		);

		add_settings_field(
			'label_for_the_client_name_input_field_3', // id
			'Label for the Client Name input field', // title
			array( $this, 'label_for_the_client_name_input_field_3_callback' ), // callback
			'getscreen-me-admin', // page
			'getscreen_me_setting_section' // section
		);

		add_settings_field(
			'label_for_the_create_connection_4', // id
			'Label for the Create Connection', // title
			array( $this, 'label_for_the_create_connection_4_callback' ), // callback
			'getscreen-me-admin', // page
			'getscreen_me_setting_section' // section
		);

		add_settings_field(
			'label_for_the_url_created_5', // id
			'Label for the URL Created', // title
			array( $this, 'label_for_the_url_created_5_callback' ), // callback
			'getscreen-me-admin', // page
			'getscreen_me_setting_section' // section
		);

		add_settings_field(
			'force_link_as_overlay_6', // id
			'Force link to be overlay', // title
			array( $this, 'force_link_as_overlay_input_6_callback' ), // callback
			'getscreen-me-admin', // page
			'getscreen_me_setting_section' // section
		);
	}

	public function getscreen_me_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['api_key_0'] ) ) {
			$sanitary_values['api_key_0'] = sanitize_text_field( $input['api_key_0'] );
		}

		if ( isset( $input['show_client_name_input_1'] ) ) {
			$sanitary_values['show_client_name_input_1'] = $input['show_client_name_input_1'];
		}

		if ( isset( $input['force_client_name_input_2'] ) ) {
			$sanitary_values['force_client_name_input_2'] = $input['force_client_name_input_2'];
		}

		if ( isset( $input['label_for_the_client_name_input_field_3'] ) ) {
			$sanitary_values['label_for_the_client_name_input_field_3'] = sanitize_text_field( $input['label_for_the_client_name_input_field_3'] );
		}

		if ( isset( $input['label_for_the_create_connection_4'] ) ) {
			$sanitary_values['label_for_the_create_connection_4'] = sanitize_text_field( $input['label_for_the_create_connection_4'] );
		}

		if ( isset( $input['label_for_the_url_created_5'] ) ) {
			$sanitary_values['label_for_the_url_created_5'] = sanitize_text_field( $input['label_for_the_url_created_5'] );
		}

		if ( isset( $input['force_link_as_overlay_6'] ) ) {
			$sanitary_values['force_link_as_overlay_6'] = $input['force_link_as_overlay_6'];
		}

		return $sanitary_values;
	}

	public function getscreen_me_section_info() {
		
	}

	public function api_key_0_callback() {
		printf(
			'<input class="regular-text" type="text" name="getscreen_me_option_name[api_key_0]" id="api_key_0" value="%s">',
			isset( $this->getscreen_me_options['api_key_0'] ) ? esc_attr( $this->getscreen_me_options['api_key_0']) : ''
		);
	}

	public function show_client_name_input_1_callback() {
		printf(
			'<input type="checkbox" name="getscreen_me_option_name[show_client_name_input_1]" id="show_client_name_input_1" value="show_client_name_input_1" %s> <label for="show_client_name_input_1">Check this if you would like your client to enter their name</label>',
			( isset( $this->getscreen_me_options['show_client_name_input_1'] ) && $this->getscreen_me_options['show_client_name_input_1'] === 'show_client_name_input_1' ) ? 'checked' : ''
		);
	}

	public function force_client_name_input_2_callback() {
		printf(
			'<input type="checkbox" name="getscreen_me_option_name[force_client_name_input_2]" id="force_client_name_input_2" value="force_client_name_input_2" %s> <label for="force_client_name_input_2">Check this if you would force your client to enter their name</label>',
			( isset( $this->getscreen_me_options['force_client_name_input_2'] ) && $this->getscreen_me_options['force_client_name_input_2'] === 'force_client_name_input_2' ) ? 'checked' : ''
		);
	}

	public function label_for_the_client_name_input_field_3_callback() {
		printf(
			'<input class="regular-text" type="text" name="getscreen_me_option_name[label_for_the_client_name_input_field_3]" id="label_for_the_client_name_input_field_3" value="%s">',
			isset( $this->getscreen_me_options['label_for_the_client_name_input_field_3'] ) ? esc_attr( $this->getscreen_me_options['label_for_the_client_name_input_field_3']) : ''
		);
	}

	public function label_for_the_create_connection_4_callback() {
		printf(
			'<input class="regular-text" type="text" name="getscreen_me_option_name[label_for_the_create_connection_4]" id="label_for_the_create_connection_4" value="%s">',
			isset( $this->getscreen_me_options['label_for_the_create_connection_4'] ) ? esc_attr( $this->getscreen_me_options['label_for_the_create_connection_4']) : ''
		);
	}

	public function label_for_the_url_created_5_callback() {
		printf(
			'<input class="regular-text" type="text" name="getscreen_me_option_name[label_for_the_url_created_5]" id="label_for_the_url_created_5" value="%s"><small>Leave blank if you want to show the link</small>',
			isset( $this->getscreen_me_options['label_for_the_url_created_5'] ) ? esc_attr( $this->getscreen_me_options['label_for_the_url_created_5']) : ''
		);
	}

	public function force_link_as_overlay_input_6_callback() {
		printf(
			'<input type="checkbox" name="getscreen_me_option_name[force_link_as_overlay_6]" id="force_link_as_overlay_6" value="force_link_as_overlay_6" %s> <label for="force_link_as_overlay_6">Check this if you want the url returned to show as overlay instead of a link to a new tab</label>',
			( isset( $this->getscreen_me_options['force_link_as_overlay_6'] ) && $this->getscreen_me_options['force_link_as_overlay_6'] === 'force_link_as_overlay_6' ) ? 'checked' : ''
		);
	}

}
