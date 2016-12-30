# metisa-wordpress-plugin
(Plugin is still under development)

Metisa for WooCommerce is a WordPress plugin that connects to your Metisa account, to generate insights based on your WooCommerce store data.

### Development Setup
To develop for this plugin, you'll need:
* MAMP software to install WordPress on your local machine. Follow [this guide][1].
* This repo, cloned into the /wp-content/plugins folder _after_ installing WP locally.

### Notes
* Use admin/settings.php to toggle production/development mode and set up your local environment. 
* Be careful when developing. __Do not__ delete the Metisa plugin from the WordPress Plugins dashboard. That will delete your repo and your work may be lost forever. Deactivating is safe.  
* WordPress debug mode is off by default. To turn it on, follow this [tutorial][3]. All logged messages can then be found in /wp-content/debug.log
  * By default this will only log errors.
  * Use `log_me(thing_to_log)` anywhere to log anthing you want to debug.log. Implementation can be found in metisa.php
* In Step 2 when connecting Metisa to store from plugin dashboard, it will only succeed if your localhost is tunneled through `ngrok`.
  * Get [ngrok][2].
  * Run `gulp serve` normally, then run `./ngrok http <port>` from your Downloads folder.
  * Replace `callback_url` param in metisa-admin-display.php to use the https url generated above.


[1]: https://codex.wordpress.org/Installing_WordPress_Locally_on_Your_Mac_With_MAMP
[2]: https://ngrok.com/
[3]: https://www.smashingmagazine.com/2011/03/ten-things-every-wordpress-plugin-developer-should-know/
