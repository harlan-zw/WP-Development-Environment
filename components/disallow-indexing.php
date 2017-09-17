<?php
/**
 * @purpose: Disallow search engines to index our site in development mode
 *
 */

/**
 * Filter will make the blog public option always off
 */
add_action('pre_option_blog_public', function() {
	return false;
});
