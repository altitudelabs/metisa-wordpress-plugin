<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Metisa
 * @subpackage Metisa/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Metisa
 * @subpackage Metisa/admin
 * @author     Your Name <email@example.com>
 */

class Metisa_Admin {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $metisa    The ID of this plugin.
	 */
	private $metisa;

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
	 * @param      string    $metisa       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */

	private $metisa_token_url = 'http://127.0.0.1:8000/oauth/token/';

	public function __construct( $metisa, $version ) {
		$this->metisa = $metisa;
		$this->version = $version;
		$this->plugin_name = 'Metisa';

		// Add Metisa plugin page to admin menu after it is created.
		add_action( 'admin_menu', array( $this, 'create_metisa_admin_menu' ) );

		// Form action triggers this hook that calls metisa_handle_authcode_submit().
		add_action( 'admin_post_metisa_authcode_submit', array( $this, 'metisa_handle_authcode_submit' ) );
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
		 * defined in Metisa_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Metisa_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->metisa, plugin_dir_url( __FILE__ ) . 'css/metisa-admin.css', array(), $this->version, 'all' );

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
		 * defined in Metisa_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Metisa_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->metisa, plugin_dir_url( __FILE__ ) . 'js/metisa-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Create the admin menu
	 * TODO: ADD METISA LOGO TO DIRECTORY
	 */
	public function create_metisa_admin_menu() {
		log_me('create_metisa_admin_menu() fired.');

		// Add main page
		add_menu_page(
			'Metisa for WooCommerce',
			'Metisa',
			'read',
			$this->plugin_name,
			array(
				$this,
				'load_admin_page_partial',
			),
			plugins_url( 'metisa/images/icon.png' )
		);
	}

	// Load the plugin admin page partial.
	public function load_admin_page_partial() {
		log_me('load_admin_page_partial() fired.');

		require_once plugin_dir_path( __FILE__ ). 'partials/metisa-admin-display.php';
	}



	public function metisa_handle_authcode_submit() {
		log_me('metisa_handle_authcode_submit() fired.');
	  // Process form data.
		$metisa_auth_code = '';

		// Sanitize form data.
		if ( !empty($_POST) ) {
			log_me( $_POST );

			foreach($_POST as $key => $value) {
				if ( $key == 'metisa-auth-code' ) {
					$metisa_auth_code = $value;

					log_me('Found metisa_auth_code: ' . $metisa_auth_code);
				}
			}

			if ( $metisa_auth_code && current_user_can( 'manage_options' ) ) {
				log_me('Trying to authenticate client with Metisa...');

		    $this->authenticate_client_with_metisa( $metisa_auth_code );
		  }
		} else {
			log_me('Error, $_POST array is empty.');
		}

	}

	public function authenticate_client_with_metisa( $authorization_code = null ) {
		log_me('authenticate_client_with_metisa() fired.');
		log_me('$authorization_code: ' . $authorization_code);

	  // Authenticate client.
		log_me('try inside authenticate_client_with_metisa() fired.');

    // Get access response that contains access token.
    $response = wp_remote_post( 'http://localhost:8001/oauth/token/', array(
			'headers' => array(
				'Content-Type' => 'application/x-www-form-urlencoded'
			),
			'method' => 'POST',
			'cookies' => array(),
      'body' => array(
        'code' => $authorization_code,
        'grant_type' => 'authorization_code',
        'redirect_uri' => 'http://localhost:8001/integrations/woocommerce/code/',
        'client_id' => 'NMo0n3J6PBic9VoSZblGQ3bWiBDBIZe2n4wHepZC',
        'client_secret' => 'V8fmCMe1R372SD1T8GDLahH6p5c5fyEKVdA9Q1EOEOrBcnVoYgKWbSvAzrPhH8Vzlln5QqHr3Mib6dmbKCmq35HGV3ZD9Uqp0EDExfTo5qHIOgoygogbGn4gVzvenVxm'
        )
      )
    );

		// Handle errors.
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();

			log_me('Logging error message: ');
			log_me($error_message);
		} else {
			log_me('No errors, received response: ');
			log_me($response);
		}

    // if ( !empty( $response ) ) {
    //   $response = json_decode( $response );
		//
    //   if ( is_object( $response ) ) {
		// 		log_me('Access token received.');
		// 		log_me($response->access_token);
		//
    //     // Save the access token.
    //     save_token_to_db( $response->access_token, 'access_token' );
		//
    //     // Save the refresh token.
    //     save_token_to_db( $response->refresh_token, 'refresh_token' );
    //   }
    // }

		wp_redirect( $_SERVER['HTTP_REFERER'] );
		die();
	  return false;
	}

	// 2 Token Types: (1) access_token and (2) refresh_token.
	function save_token_to_db( $token, $type ) {
		log_me('save_token_to_db() fired.');
	  // Save tokens to 'Option' table in WP database.
	  if ($type === 'access_token') {
	    update_option( 'metisa_access_token', $token, '', 'yes');
	  } elseif ($type === 'refresh_token') {
	    update_option( 'metisa_refresh_token', $token, '', 'yes');
	  }
	}
}


/**
 * This is outside the class definition.
 */
