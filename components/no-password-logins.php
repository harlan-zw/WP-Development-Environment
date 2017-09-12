<?php
// IMPORTANT - We only run this if the user is connecting from localhost

// Function to get the client IP address
function dev_env_get_client_ip() {
	// We ONLY look at the remote_addr because it CANNOT be spoofed
	if ( getenv( 'REMOTE_ADDR' ) ) {
		return getenv( 'REMOTE_ADDR' );
	}
	return false;
}

// find users ip
$ip = dev_env_get_client_ip();

// check if they are connecting from localhost
global $is_local_host;
$is_local_host = $ip === '127.0.0.1' || $ip === 'localhost';

// only allow this to run from our localhost
if (!$is_local_host) {
	return;
}

/**
 * Password logins always work, as long as the username is correct
 */
add_filter('check_password', function() {
	return true;
});
