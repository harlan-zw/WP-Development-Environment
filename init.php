<?php
/*
Plugin Name: Development Environment
Plugin URI: https://github.com/loonpwn/wp-development-environment
Description: Run extra components in our development environment for easier debugging and usability
Version: 1.0.6
Author: Harlan Wilton
Author URI: https://harlanzw.com
License: GPL2
*/

// include composer autoloader so we can utilize our libraries
require 'vendor/autoload.php';

// wrap in an anonymous function to avoid accidental global (min php 5.3)
$init_development_environment = function() {
	// check the php version
	$update_php = new WPUpdatePhp( '7' );
	if (!$update_php->does_it_meet_required_php_version()) {
		return;
	}
	// initialize our plugin
	global $development_environment;
	// we store our value in a global
	$development_environment = new DevelopmentEnvironment();
};

// begin
$init_development_environment();
