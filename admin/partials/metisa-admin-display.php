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
</div>
