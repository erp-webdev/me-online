<?php

	include("config.php");

    //var_dump($_SESSION['ssep_comp']);
    //var_dump(DBNAME);

    $section = $_REQUEST['section'];

	//**************** USER MANAGEMENT - START ****************\\

	include(LIB."/login/chklog.php");

    include(LIB."/init/settinginit.php");

    if ($_SESSION['megassep_admin']) :
        $logged = 1;
        $profile_full = 'ME Online Admin';
        $profile_name = 'Admin';
        $profile_id = 'admin';
        $profile_idnum = 'admin';
        $profile_email = 'jisleta@megaworldcorp.com';
	    $profile_pic = NULL;
    else :
        $logged = $logstat;
        $profile_full = $logfname;
        $profile_name = $lognick;
        $profile_id = $userid;
        $profile_idnum = $logname;
        define("IDNUM", $_SESSION['megasubs_user']);
        $profile_email = $email;
        $profile_bday = $bday;
        $profile_comp = $company;
        $profile_sss = $sss;
        $profile_tin = $tin;
	    $profile_pic = $logpic;
        $profile_phealth = $phealth;
        $profile_pagibig = $pagibig;
        $profile_acctnum = $acctnum;
        $profile_location = $location;
        $profile_minothours = $minothours;
        $profile_dbname = $dbname;
        $profile_compressed = $compressed;
        if ($profile_comp ==  'GLOBALHOTEL') :
            define("SITENAME", "GLOBAL HOTEL SSEP - BETA");
            define("SYSTEMNAME", "GLOBAL HOTEL SSEP  - BETA");
            define("WELCOME", "Welcome to Global Hotel SSEP  - BETA");
            define("COMPNAME", "Global Hotel");
        endif;
    endif;

    /* MAIN DB CONNECTOR - START */

    if ($logstat) :

        define("MAINDB", $dbname);
        include(CLASSES."/mainsql.class.php");
        include(CLASSES."/regsql.class.php");
        include(CLASSES."/pafsql.class.php");
        //include(CLASSES."/lmssql.class.php");

        $mainsql = new mainsql;
        $register = new regsql;
        $pafsql	= new pafsql;
        //$lms = new lmssql;

        /* MAIN DB CONNECTOR - END */

        $logdata = $register->get_member($_SESSION['megasubs_user'], $dbname);

        //var_dump($logdata[0]['PositionID']);

        $deptdata = $mainsql->get_dept_data($logdata[0]['DeptID'], $dbname);
        $posdata = $mainsql->get_posi_data($logdata[0]['PositionID'], $dbname);
        $usertax = $register->get_memtax($logdata[0]['TaxID']);

        //var_dump($deptdata);

        $profile_dept = $deptdata[0]['DeptDesc'];
        $profile_pos = $posdata[0]['PositionDesc'];
        $profile_taxdesc = $usertax[0]['Description'];

        include(LIB."/init/approverinit.php");

        //var_dump($_SESSION['megassep_admin']);

        if ($profile_dbname == "ECINEMA" || $profile_dbname == "EPARKVIEW" || $profile_dbname == "LAFUERZA") :
            $adminarray = array("2011-03-V835", "2015-09-8725", "000015", "2015-11-0550", "2011-12-8558", "2016-04-8756", "2014-10-0004", "2016-06-0457","2017-06-1073","2015-03-0155","2018-08-0483","2019-02-0034","2019-05-0278");
        elseif ($profile_dbname == "CITYLINK" || $profile_dbname == "ECOC" || $profile_dbname == "EREX" || $profile_dbname == "LCTM" || $profile_dbname == "MLI" || $profile_dbname == "NCCAI" || $profile_dbname == "SUNTRUST" || $profile_dbname == "TOWNSQUARE") :
            $adminarray = array("2017-06-1124", "2009-09-V206", "2012-04-U384","2018-07-0406","2007-06-M314","2019-02-0034","2019-03-0123","2018-08-0483","2014-10-0004");
        elseif ($profile_dbname == "FIRSTCENTRO" || $profile_dbname == "MCTI") :
            $adminarray = array("2009-10-V255", "2016-06-0479", "2011-03-V835", "2015-11-0550", "2014-10-0004", "2013-08-N300","2017-06-1073","2007-06-M314","2018-07-0406","2015-03-0155","2018-08-0483","2019-02-0034");
        elseif ($profile_dbname == "GLOBAL_HOTEL") :
            $adminarray = array("2018-01-0000", "2011-03-V835", "2014-10-0004", "2016-06-0457","2017-06-1073","2017-10-0011","2019-01-0008","2019-01-0004","2015-03-0155","2018-07-0406","2015-11-0550","2018-08-0483");
        elseif ($profile_dbname == "GL" || $profile_dbname == "SIRUS" || $profile_dbname == "ASIAAPMI") :
            $adminarray = array("2014-10-0004", "2014-10-0568", "2016-03-0261", "2017-01-0792", "2011-04-V859", "2015-11-0550", "2016-06-0457", "2018-07-0406","2007-06-M314","2019-02-0034","2019-03-0123","2019-02-0033");
        elseif ($profile_dbname == "NEWTOWN") :
            $adminarray = array("2014-10-0004","2018-05-0001","2017-06-1073","2015-03-0155","2018-08-0483","2019-02-0034");
        elseif ($profile_dbname == "MEGAWORLD") :
            $adminarray = array("2018-05-0235","2009-09-V206", "2017-06-1124", "2016-06-0457","2018-07-0406","2007-06-M314","2019-03-0123","2015-11-0550","2011-03-V835","2014-10-0004");
        else :
            $adminarray = array("2014-05-N791", "2009-09-V206", "MASTER", "2012-03-U273", "2014-01-N506", "2016-06-0457", "2018-07-0406","2017-06-1073","2007-06-M314","2019-02-0034","2019-03-0123","2018-09-0494","2017-06-1124","2019-05-0278","2011-03-V835","2016-05-0259","2020-04-0107","2020-07-0148");
        endif;

        //PAYSLIP MANAGEMENT ADMINS
        $PAYSLIP_MANAGEMENT = [
            'CITYLINK' => ['1994-03-8275', '2014-10-0004', '2007-06-M314', '2018-08-0483', '2019-05-0278'],
            'ECOC' => ['1994-03-8275', '2014-10-0004', '2007-06-M314', '2018-08-0483', '2019-05-0278'],
            'ECINEMA' => ['1994-03-8275', '2014-10-0004', '2007-06-M314', '2018-08-0483', '2019-05-0278'],
            'EPARKVIEW' => ['1994-03-8275', '2014-10-0004', '2007-06-M314', '2018-08-0483', '2019-05-0278'],
            'EREX' => ['1994-03-8275', '2014-10-0004', '2007-06-M314', '2018-08-0483', '2019-05-0278'],
            'FIRSTCENTRO' => ['1994-03-8275', '2014-10-0004', '2007-06-M314', '2018-08-0483', '2019-05-0278'],
            'GL' => ['1994-03-8275', '2014-10-0004', '2007-06-M314', '2011-04-V859', '2019-03-0123'],
            'GLOBAL_HOTEL' => ['1994-03-8275', '2014-10-0004', '2007-06-M314', '2018-08-0483'],
            'LAFUERZA' => ['1994-03-8275', '2014-10-0004', '2007-06-M314', '2018-08-0483', '2019-05-0278'],
            'LCTM' => ['1994-03-8275', '2014-10-0004', '2007-06-M314', '2018-08-0483', '2019-05-0278'],
            'MARKETING' => ['1994-03-8275', '2014-10-0004', '2007-06-M314'],
            'MCTI' => ['1994-03-8275', '2014-10-0004', '2007-06-M314', '2018-08-0483'],
            'MARKETING' => ['1994-03-8275', '2014-10-0004', '2007-06-M314'],
            'MEGAWORLD' => ['1994-03-8275', '2014-10-0004', '2007-06-M314', '2015-11-0550'],
            'MLI' => ['1994-03-8275', '2014-10-0004', '2007-06-M314'],
            'NCCAI' => ['1994-03-8275', '2014-10-0004', '2007-06-M314', '2018-08-0483'],
            'NEWTOWN' => ['1994-03-8275', '2014-10-0004', '2007-06-M314', '2018-08-0483'],
            'SUNTRUST' => ['1994-03-8275', '2014-10-0004', '2007-06-M314', '2018-08-0483', '2019-05-0278'],
            'TOWNSQUARE' => ['1994-03-8275', '2014-10-0004', '2007-06-M314', '2018-08-0483'],
            'ASIAAPMI' => ['2014-10-0004'],
            'SIRUS' => ['2014-10-0004'],

        ];

        $psadminarray = $PAYSLIP_MANAGEMENT[$profile_dbname];

        // if ($profile_dbname == "CITYLINK" || $profile_dbname == "ECOC" || $profile_dbname == "EREX" || $profile_dbname == "LCTM" || $profile_dbname == "MLI" || $profile_dbname == "NCCAI" || $profile_dbname == "SUNTRUST" || $profile_dbname == "TOWNSQUARE") :
        //     $psadminarray = array("1994-03-8275","2018-08-0483","2014-10-0004");
        // elseif ($profile_dbname == "GLOBAL_HOTEL" || $profile_dbname == "LAFUERZA") :
        //     $psadminarray = array("1994-03-8275", "2014-10-0004", "2011-03-V835","2018-08-0483");
        // elseif ($profile_dbname == "GL") :
        //     $psadminarray = array("1994-03-8275", "2014-10-0004", "2011-04-V859", "2015-11-0550", "2016-06-0457","2019-03-0123");
        // elseif ($profile_dbname == "ECINEMA" || $profile_dbname == "EPARKVIEW" || $profile_dbname == "MCTI") :
        //     $psadminarray = array("1994-03-8275", "2014-10-0004", "2015-11-0550","2018-08-0483","2019-05-0278");
        // elseif ($profile_dbname == "NEWTOWN") :
        //     $psadminarray = array("1994-03-8275", "2014-10-0004", "2017-06-1073","2018-08-0483");
        // else :
        //     $psadminarray = array("1994-03-8275", "2009-09-V206", "MASTER", "2012-03-U273", "2016-06-0457","2015-11-0550","2014-10-0004");
        // endif;

	    //var_dump($adminarray);

        if ($profile_dbname == "MARKETING") :
            $profile_nadd = 'agent';
        else :
            $profile_nadd = 'employee';
        endif;


        if (in_array($profile_idnum, $adminarray) || $profile_idnum == "2016-06-0457") :
            $profile_level = 9;
        elseif (in_array($profile_idnum, $adminarray2) || $profile_idnum == "2016-06-0457") :
            $profile_level = 7;
        elseif ($_SESSION['megassep_admin']) :
            $profile_level = 10;
        else :
            $profile_level = 0;
        endif;

        if (in_array($profile_idnum, $psadminarray) || $profile_idnum == "2016-06-0457") :
            $profile_ps = 1;
        else :
            $profile_ps = 0;
        endif;

        $llblock = $mainsql->get_emploan($profile_idnum);
        $psblock = $mainsql->get_psblock($profile_idnum, $dbname);
        //$unread_notification = $mainsql->get_read($profile_idnum, NULL, 1);
        //$pend_notification = $tblsql->get_pendingnoti(NULL, 0, 0, NULL, 1, $profile_idnum, NULL, NULL, NULL, $profile_dbname);

        //var_dump($profile_level);

        $profile_hash = md5($profile_idnum);

        $GLOBALS['level'] = $profile_level;

    endif;

	//***************** USER MANAGEMENT - END *****************\\

	if ($section) :
		if (!file_exists(OBJ."/".$section.".php")) :
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/404'</script>";
        else :
            include(OBJ."/".$section.".php");
		    include(TEMP."/".$section.".php");
        endif;
	else :
		$ishome = 1;
		include(OBJ."/index.php");
		include(TEMP."/index.php");
    endif;



?>
