<?php
if ($logged == 1 && $profile_dbname != 'ECINEMA' && $profile_dbname != 'EPARKVIEW' && $profile_dbname != 'NEWTOWN' && $profile_dbname != 'LAFUERZA') {
        $_SESSION['megafunrun']="0";
        echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/megaworld-35th-anniversary-fun-run'</script>";
	}
	else
	{
        $_SESSION['megafunrun']="1";
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
?>
