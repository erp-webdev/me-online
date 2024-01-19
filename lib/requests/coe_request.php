<?php

	include("../../config.php");
	include(LIB."/login/chklog.php");
    include(OBJ . '/mail/Mail.php');
    include(CLASSES . '/COE.php');

    $logged = $logstat;
    $profile_full = $logfname;
    $profile_name = $lognick;
    $profile_id = $userid;
    $profile_idnum = $logname;
    $profile_dbname = $dbname;

    /* MAIN DB CONNECTOR - START */

    define("MAINDB", $dbname);
    include(CLASSES."/mainsql.class.php");
    include(CLASSES."/COE.php");

    $mainsql = new mainsql;
    $coe = new COE;
    $mail = new Mail;

    
