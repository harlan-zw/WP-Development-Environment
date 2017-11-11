<?php
/**
 * @purpose Embed HTML comment into the code for which template file is being rendered.
 *
 * @todo potentially expand to show post details
 */


if (!function_exists('get_current_template')) {
	/**
	 * Get the template file being used to render the page
	 * @return mixed
	 */
	function get_current_template() {
		global $current_theme_template;
		return $current_theme_template;
	}
}

// set global on the current theme template
add_filter('template_include', function($t) {
	global $current_theme_template;
	return $current_theme_template = $t;
}, PHP_INT_MAX);

// show the template meta
add_action('wp_head', function() {
	$template = get_current_template();
	echo '<!--- == Development Environment Plugin ==
		 Template File: ' .  basename($template) . '
	     Template Path: ' . dirname($template) . '
	     --->';
}, PHP_INT_MAX);