<?php
/**
 * @purpose Make login's easier by not checking if the password is correct
 */


// IMPORTANT - We only run this if the user is connecting from localhost;
if (!DevelopmentEnvironment::is_local_host_client()) {
	return;
}

/**
 * Password login's always work, as long as the username is correct
 */
add_filter('check_password', function() {
	return true;
});
