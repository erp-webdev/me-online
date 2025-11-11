<?php
if ($logged == 1 && $profile_dbname != 'ECINEMA' && $profile_dbname != 'EPARKVIEW' && $profile_dbname != 'NEWTOWN' && $profile_dbname != 'LAFUERZA') {
        $_SESSION['mega-christmas'] = "0";
        if($_SESSION['bacolod']=="1"){
			echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/makulay-ang-pasko-sa-mega-2025-bacolod'</script>";
		}
		else if($_SESSION['iloilo']=="1"){
			echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/makulay-ang-pasko-sa-mega-2025-iloilo'</script>";
		}
		else if($_SESSION['cebu']=="1"){
			echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/makulay-ang-pasko-sa-mega-2025-cebu'</script>";
		}
		else if($_SESSION['ncr']=="1"){
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/makulay-ang-pasko-sa-mega-2025'</script>";
        }
	}
	else
	{
        $_SESSION['mega-christmas'] = "1";
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
?>
