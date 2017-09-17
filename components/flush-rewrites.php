<?php
/**
 * @purpose Avoid weird permalink issues due to the rewrite rules not being flushed.
 *
 * @note this will slow down the site, since it will rebuild the 'options' wp_options field on every load.
 */

add_action('init', function() {
	flush_rewrite_rules();
}, 0);
