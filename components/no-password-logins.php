<?php

/**
 * Password logins always work, as long as the username is correct
 */
add_filter('check_password', function() {
	return true;
});
