<?php

	// server should keep session data for 1 hour
	ini_set('session.gc_maxlifetime', 600);

	// each client remember their session id for exactly 1 hour
	session_set_cookie_params(600);

    session_start();

	$cookiename = 'megassep_user';

	$username = $_SESSION[$cookiename];

	if ($username) {
        echo "1";
	}
	else
	{
		echo "-1";
        session_destroy();
	}

?>
