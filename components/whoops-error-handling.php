<?php
/**
 * @purpose Swap out the default error handling for Whoops Error Handling. This provides a user friendly
 * error screen with full stack trace.
 */

$whoops = new \Whoops\Run();

// if it's an ajax request we respond with json
if (defined('DOING_AJAX') && DOING_AJAX) {
	$handler = new \Whoops\Handler\JsonResponseHandler();
} else {
	// otherwise a html pretty page
	$handler = new \Whoops\Handler\PrettyPageHandler();
	$handler->setPageTitle( get_bloginfo( 'name' ) . ' - Whoops an Error!' );
}

$whoops->pushHandler( $handler );
$whoops->register();