<?php
/**
 * Always flush the rewrite rules on any load, this is to avoid any weird debugging issues
 * with permalinks. Note that this will slow down the site, since it will rebuild the 'options'
 * wp_options field.
 */
add_action('init', function() {
	flush_rewrite_rules();
}, 0);
