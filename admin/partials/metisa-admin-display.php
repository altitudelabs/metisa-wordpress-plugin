<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Metisa
 * @subpackage Metisa/admin/partials
 */

global $metisa_production, $metisa_localhost_https, $metisa_url_live;
$metisa_url = ($metisa_production) ? $metisa_url_live : $metisa_localhost_https;

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
  <h1><?= esc_html(get_admin_page_title()); ?></h1>

  <h3>Step 1: Authenticate with Metisa</h3>
  <div>
    <a class="button button-secondary" href="<?php echo Metisa_Admin::getAuthUrl(); ?>" target="_blank">
      Authenticate with Metisa
    </a>
  </div>
  <div>
    <form action="<?php echo admin_url('admin-post.php'); ?>" method="post">
      <?php wp_nonce_field( 'save_authcode' ); ?>

      <!-- Value field in this hidden input will trigger metisa_handle_authcode_submit(). -->
      <input type="hidden" name="action" value="metisa_authcode_submit" />

      <label for="metisa-auth-code">Paste your Metisa code here:</label>
      <input type="text" name="metisa-auth-code" id="metisa_auth_code" />
      <?php submit_button( 'Save authentication code' ); ?>
    </form>
  </div>

<?php

// Check if there's already an access token from Step 1.
if ( get_option( 'metisa_access_token') )
{
  $callback_url = $metisa_url . 'integrations/woocommerce/api/';

  // Check for success param in URL, returned by WooCommerce API auth.
  $success = False;
  if ( isset( $_GET['success'] ) ) {
    if ( $_GET['success'] == 1 ) {
      $success = True;
    }
  }

  $woocommerce_query_string = array(
    'app_name' => 'Metisa',
    'scope' => 'read_write',
    'return_url' => menu_page_url('Metisa'),
    'user_id' => urlencode( site_url() ),
    'callback_url' => $callback_url
  );

  // Build URL with WC API endpoint's required query parameters.
  $woocommerce_api_key_endpoint = add_query_arg( $woocommerce_query_string, site_url( '/wc-auth/v1/authorize/' ) );

?>

  <h3>Step 2: Connect Metisa to your store</h3>
  <div>
    <?php

    if ($success) {
      echo "<p>Connected Metisa successfully!</p>";
    }

    ?>

    <a class="button button-primary" href="<?php echo $woocommerce_api_key_endpoint ?>">
      Connect Metisa
    </a>
  </div>

<?php
} ?>

</div>
