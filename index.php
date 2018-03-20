<?php
/*
Plugin Name: Wordpress Newsletter Api
Plugin URI: https://github.com/strootje/wp-newsletter-api
Description: Adds an endpoint for managing newsletters
Version: 0.1
Author: bas@strootje.com
Author URI: https://www.strootje.com/projects/wp-newsletter-api
License: Mozilla Public License, version 2.0
License URI: https://www.tldrlegal.com/l/mpl-2.0
*/

const PLUGINNAME = 'wp-newsletter-api';
include __DIR__ . '/vendor/autoload.php';
use WPNewsletterApi\Plugin;

add_action('plugins_loaded', function() {
	$plugin = new Plugin();
	$plugin->addActions();
	$plugin->addFilters();
});
