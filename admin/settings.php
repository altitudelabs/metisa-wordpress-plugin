<?php

/**
 * Developer configurations
 *
 * Change all values on first start of development servers.
 */
global $metisa_production, $metisa_url, $metisa_client_id, $metisa_client_secret, $metisa_localhost_https, $metisa_localhost_http;

// True for production mode, False for development.
$metisa_production = False;

// Non-SSL localhost used for Authenticating with Metisa to avoid exceeding ngrok rate limits.
$metisa_localhost_http = trailingslashit( 'http://localhost:8000' );

/**
 * Run gulp serve, run ngrok SSL tunnel, then use https url provided.
 *
 * Only use $metisa_localhost_https for Step 2 'Connect Metisa'
 * Do not use this url for larger page loads like in Step 1,
 * use $metisa_localhost_http instead.
 */
$metisa_localhost_https = trailingslashit( 'https://cad4609c.ngrok.io' );

// Used if $metisa_production == True.
$metisa_url_live = trailingslashit( 'https://askmetisa.com/' );

$metisa_client_id = 'GUu7od3nojPSjhKWAz8Vq5N7LL2wNGM4AIbGnJ5D';
$metisa_client_secret = 'hNgAlg4VyKNLVY83TuMwFFOcFPSxqoTzgTATmZTmKosCUOmgPh4N0XAlenqrGerczwgjpqUszhiAup0otoaCflmH6d9rGBXeMqLn7JM0ltYSyx19ryOL2fc3ZWBRDyAP';
