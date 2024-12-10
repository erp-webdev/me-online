<?php
if ($logged == 1 && $profile_dbname != 'ECINEMA' && $profile_dbname != 'EPARKVIEW' && $profile_dbname != 'NEWTOWN' && $profile_dbname != 'LAFUERZA') {
        $_SESSION['iloilo']="0";
        echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/iloilo-glitz-and-glam-2024'</script>";
	}
	else
	{
        $_SESSION['iloilo']="1";
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
?>
