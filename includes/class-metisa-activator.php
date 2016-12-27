<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Metisa
 * @subpackage Metisa/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Metisa
 * @subpackage Metisa/includes
 * @author     Your Name <email@example.com>
 */
class Metisa_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		// // Hard coded for development only
		// $client_id = 'eeLVV5P3RK7BpBSVz7VVIYP0rCkbgl4hzFS94FtH';
		// $client_secret = 'XuL3MPAZBTZspv9PMytwoqkJvMHXAmFxRqd7LTc0UoAazp2XQPdtWVzzg8Op35lFOahKchiyQQnxUogjVKveReHrAOX7gDzr5uCnmxK5CzykIHN3VZ3ZaOGHLVSvHKjE';
		// $client_type = 'Confidential';
		// $authorization_grant_type = 'authorization-code';
		// $redirect_uris = 'https://google.com/';
		//
		// // Register new app with Metisa OAuth2
		// $registration_url = 'https://askmetisa.com/oauth/applications/register/';
		//
		// $registration_response = wp_remote_retrieve_body( wp_remote_post($registration_url, array(
		// 		'method' => 'POST',
		// 		'blocking' => true,
		// 		'headers' => array(),
		// 		'body' => array(
		// 			'client_id' => $client_id,
		// 			'client_secret' => $client_secret,
		// 			'client_type' => $client_type,
		// 			'authorization_grant_type' => $authorization_grant_type,
		// 			'redirect_uris' => $redirect_uris
		// 		)
		// 	))
		// );
	}

}
