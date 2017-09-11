<?php

/**
 * Disallow search engines to index the site
 */
add_action('pre_option_blog_public', function() {
	return false;
});
