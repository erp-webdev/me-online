<?php

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