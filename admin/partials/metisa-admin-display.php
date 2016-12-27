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
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
  <h1><?= esc_html(get_admin_page_title()); ?></h1>

  <h3>Step 1: Authenticate with Metisa</h3>
  <div>
    <input id="oauth-authorize" name="oauth" type="button" value="Authenticate with Metisa" class="button button-secondary" />
  </div>
  <div>
    <form action="<?php echo admin_url('admin-post.php'); ?>" method="post">
      <input type="hidden" name="action" value="metisa_authcode_submit" />

      <label for="metisa-auth-code">Paste your Metisa code here:</label>
      <input type="text" name="metisa-auth-code" id="metisa_auth_code" />
      <?php submit_button( 'Save authentication code' ); ?>
    </form>
  </div>


<?php
if ( get_option( 'metisa_access_token') )
{
  $woocommerce_query_string = array(
    'app_name' => urlencode('Metisa for WooCommerce'),
    'scope' => 'read_write',
    'return_url' => menu_page_url('Metisa'),
    'callback_url' => 'https://localhost:8001/integrations/woocommerce/api/',
    'user_id' => site_url()
  );

  // Build URL with WC API endpoint's required query parameters.
  $woocommerce_api_key_endpoint = add_query_arg( $woocommerce_query_string, site_url( '/wc-auth/v1/authorize/' ) );
?>

  <h3>Step 2: Connect Metisa to your store</h3>
  <div>
    <a class="button button-primary" href="<?php echo $woocommerce_api_key_endpoint ?>">
      Connect Metisa
    </a>
  </div>

<?php
}
?>

</div>
