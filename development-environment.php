<?php
/**
 * Class DevelopmentEnvironment
 *
 * Initialize our environment by first checking if we are in a development environment. Then loading all of our development environment
 * components given.
 */
class DevelopmentEnvironment {

	/**
	 * The plugin key used for our filters & hooks
	 */
	const PLUGIN_KEY = 'development-environment';

	/**
	 * Commonly used environment variables to hold which environment we're on
	 */
	const ENVIRONMENT_KEYS = [
		'WP_ENV',
		'APPLICATION_ENV'
	];

	CONST COMPONENTS = [
		'disallow-indexing',
		'flush-rewrites',
		'no-password-logins',
		'which-template',
		'whoops-error-handling',
	];

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


	private $env_is_development;

	public function __construct() {
		// setup the environment
		$this->detect_development_environment();

		// don't run if we're using wp-cli - causes potential issues
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			return;
		}

		add_action('init', function() {
			// if we're not in production - let's load our components
			if (!$this->is_production()) {
				$this->load_components();
			}
		});

	}

	/**
	 * Detects if the current wordpress instance is running in development
	 */
	private function detect_development_environment() {
		$this->env_is_development = $this->match_env_constant(self::ENVIRONMENT_KEYS, function($value) {
			return in_array(strtolower($value), self::DEVELOPMENT_FLAGS);
		});

		// let the user setup custom filtering if they don't work for the above
		$this->env_is_development = apply_filters(self::PLUGIN_KEY . '/is-development', $this->env_is_development);
	}

	/**
	 * Given an array of keys, try and find value associated to them. Will look at global constants as well
	 * as environment based configuration ($_ENV)
	 *
	 * @param $possible_keys
	 * @param $matcher
	 *
	 * @return bool
	 */
	private function match_env_constant($possible_keys, $matcher) {
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
	 * Checks if the current environment is production
	 * @return bool
	 */
	public function is_production() {
		return !$this->env_is_development;
	}

	/**
	 * Attempt to load all components and our composer files
	 */
	private function load_components() {
		foreach(self::COMPONENTS as $component) {
			$include = true;
			if (apply_filters(self::PLUGIN_KEY . '/require-component-' . $component, $include)) {
				require 'components/' . $component . '.php';
			}
		}
	}

	/**
	 * Attempts to get the clients ID but only looks at non-spoofable variables
	 * @return bool|string Client IP Or false if couldn't get
	 */
	public static function get_client_ip_no_spoof() {
		// We ONLY look at the remote_addr because it CANNOT be spoofed
		if (getenv('REMOTE_ADDR')) {
			return getenv('REMOTE_ADDR');
		}
		return false;
	}

	/**
	 * Checks if the current user IP is coming from the local host.
	 * @return bool
	 */
	public static function is_local_host_client() {
		$ip = self::get_client_ip_no_spoof();
		// @todo add in a whitelist
		return $ip === '127.0.0.1' || $ip === 'localhost';
	}

}
