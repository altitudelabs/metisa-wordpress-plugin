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

	// Get OAuth2 URL to Metisa endpoint.
	public function getAuthUrl() {
		// Determine URL to use basd on $metisa_production.
		global $metisa_production, $metisa_localhost_http, $metisa_url_live, $metisa_client_id;
		$metisa_url = ($metisa_production) ? $metisa_url_live : $metisa_localhost_http;

	  $state = 'm3ti5a';
	  $url = $metisa_url . 'oauth/authorize/';
	  $url .= '?response_type=code';
	  $url .= '&client_id=' . $metisa_client_id;
	  $url .= '&state=' . $state;

	  return $url;
	}

	/**
	 * Create the admin menu
	 * TODO: ADD METISA LOGO TO DIRECTORY
	 */
	public function create_metisa_admin_menu() {
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

		include plugin_dir_path( __FILE__ ). 'partials/metisa-admin-display.php';
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

					log_me('Received metisa_auth_code: ' . $metisa_auth_code);
				}
			}

			if ( $metisa_auth_code && current_user_can( 'manage_options' ) ) {
		    $this->authenticate_client_with_metisa( $metisa_auth_code );
		  }
		} else {
			log_me('Error, $_POST array is empty.');
		}

	}

	public function authenticate_client_with_metisa( $authorization_code = null ) {
		global $metisa_production, $metisa_localhost_http, $metisa_url_live, $metisa_client_id, $metisa_client_secret;
		$metisa_url = ($metisa_production) ? $metisa_url_live : $metisa_localhost_http;

		$oauth_token_endpoint = $metisa_url . 'oauth/token/';
		$redirect_uri = $metisa_url . 'integrations/woocommerce/code/';

    // Exchange authorization_code for access_token with Metisa server.
    $response = wp_remote_post( $oauth_token_endpoint, array(
			'headers' => array(
				'Content-Type' => 'application/x-www-form-urlencoded'
			),
			'method' => 'POST',
			'cookies' => array(),
      'body' => array(
        'code' => $authorization_code,
        'grant_type' => 'authorization_code',
        'redirect_uri' => $redirect_uri,
        'client_id' => $metisa_client_id,
        'client_secret' => $metisa_client_secret
        )
      )
    );

		// Handle errors.
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();

			log_me('Logging error message: ');
			log_me($error_message);
		} else {
			// Retrieve access token and save to db.
			if ( !empty( $response ) ) {
				$response = json_decode( wp_remote_retrieve_body( $response ), true );

				log_me('$response after json_decode: ');
				log_me($response);

				foreach($response as $key => $value) {
					if ( $key == 'access_token' ) {
						$access_token = $value;
					} elseif ( $key == 'refresh_token' ) {
						$refresh_token = $value;
					}
				}

	      // Save the access token.
	      $this->save_token_to_db( $access_token, 'access_token' );

	      // Save the refresh token.
	      $this->save_token_to_db( $refresh_token, 'refresh_token' );
	    }
		}

		wp_redirect( $_SERVER['HTTP_REFERER'] );

		// Callback attached to hooks must be explicitly killed in WP.
		die();
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
