# metisa-wordpress-plugin
(Plugin is still under development)

Metisa for WooCommerce is a WordPress plugin that connects to your Metisa account, to generate insights based on your WooCommerce store data.

### Development Setup
To develop for this plugin, you'll need:
* MAMP software to install WordPress on your local machine. Follow [this guide][1].
* This repo, cloned into the /wp-content/plugins folder _after_ installing WP locally.

### Notes
* In Step 2 when connecting Metisa to store from plugin dashboard, it will only succeed if your localhost is tunneled through `ngrok`.
  * Get [ngrok][2]
  * Run `gulp serve` normally, then run `./ngrok http <port>` from your Downloads folder.


[1]: https://codex.wordpress.org/Installing_WordPress_Locally_on_Your_Mac_With_MAMP
[2]: https://ngrok.com/
