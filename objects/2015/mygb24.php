<?php
if ($logged == 1 && $profile_dbname != 'ECINEMA' && $profile_dbname != 'EPARKVIEW' && $profile_dbname != 'NEWTOWN' && $profile_dbname != 'LAFUERZA') {
        $_SESSION['megaglamball']="0";
        echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/megaworld-yuletide-glamball-2024'</script>";
	}
	else
	{
        $_SESSION['megaglamball']="1";
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
?>
