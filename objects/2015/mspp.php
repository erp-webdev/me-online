<?php
if ($logged == 1 && $profile_dbname != 'ECINEMA' && $profile_dbname != 'EPARKVIEW' && $profile_dbname != 'NEWTOWN' && $profile_dbname != 'LAFUERZA') {
        $_SESSION['megasaya']="0";
        echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/mega-sayang-paskong-pilipino'</script>";
	}
	else
	{
        $_SESSION['megasaya']="1";
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
?>
