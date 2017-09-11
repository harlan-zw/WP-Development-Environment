<?php

if (!class_exists('PrettyPageHandler')) {
	// include the vendor for file
}

$whoops = new \Whoops\Run();

if (defined('DOING_AJAX') && DOING_AJAX) {
	$handler = new \Whoops\Handler\JsonResponseHandler();
} else {
	$handler = new \Whoops\Handler\PrettyPageHandler();
	$handler->setPageTitle( get_bloginfo( 'name' ) . ' - Whoops an Error!' );
}


$whoops->pushHandler( $handler );
$whoops->register();