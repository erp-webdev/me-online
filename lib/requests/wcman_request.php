<?php

	include("../../config.php");

	include(LIB."/login/chklog.php");

    $logged = $logstat;
    $profile_full = $logfname;
    $profile_name = $lognick;
    $profile_id = $userid;
    $profile_idnum = $logname;
    $profile_email = $email;
    $profile_dbname = $dbname;

    define("MAINDB", $dbname);
    include(CLASSES."/mainsql.class.php");
    include(CLASSES."/WFHManagement.php");

    $mainsql = new mainsql;
    $accessman = new WFHManagement;

    switch ($sec) {

        case 'update-item':

            echo "{success:true}";
            break;
        default:
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";

    }

?>
