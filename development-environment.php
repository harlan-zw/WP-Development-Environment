<?php
/*
Plugin Name: Easy Development
Plugin URI: http://github.com/loonpwn/easy-wp-development
Description: A plugin we run locally to make development easier for ourselves
Version: 1.0
Author: Harlan Wilton
Author URI: https://harlanzw.com
License: GPL2
*/

const PLUGIN_KEY = 'development-environment';

/**
 * Commonly used environment variables to hold which environment we're on
 */
const ENVIRONMENT_KEYS = [
	'WP_ENV',
	'APPLICATION_ENV'
];

/**
 * Given an array of keys, try and find value associated to them. Will look at global constants as well
 * as environment based configuration ($_ENV)
 *
 * @param $possible_keys
 * @param $matcher
 *
 * @return bool
 */
function match_env_constant($possible_keys, $matcher) {
	/**
	 * We try and match a users environment configuration to the environment
	 */
	foreach($possible_keys as $env_key) {

		if (!defined($env_key) && empty(getenv($env_key))) {
			continue;
		}

		$env_value = defined($env_key) ? constant($env_key) : getenv($env_key);

		if ($matcher($env_value)) {
			return true;
		}
	}
	return false;
}

/**
 * Commonly used environment names used for local development
 */
const DEVELOPMENT_FLAGS = [
	'development',
	'dev',
	'local',
	'staging',
	'sandbox',
	'test',
	'testing'
];

$env_is_development = match_env_constant(ENVIRONMENT_KEYS, function($value) {
	return in_array(strtolower($value), DEVELOPMENT_FLAGS);
});

// let the user setup custom filtering if they don't work for the above
$env_is_development = apply_filters(PLUGIN_KEY . '/is-development', $env_is_development);

/**
 * Checks if the current environment is production
 * @return bool
 */
function is_production() {
	global $env_is_development;
	return !$env_is_development;
}

// never run on production
if (is_production()) {
	return;
}

// include composer autoloader
require 'vendor/autoload.php';

// include our components
$components = [
	'disallow-indexing',
	'flush-rewrites',
	'no-password-logins',
	'whoops-error-handling',
];

foreach($components as $component) {
	$include = true;
	if (apply_filters('development-environment/require-component-' . $component, $include)) {
		require 'components/' . $component . '.php';
	}
}