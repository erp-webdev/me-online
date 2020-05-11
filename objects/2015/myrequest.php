<?php

	if ($logged == 1) {

		# PAGINATION
		$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
		$start = NUM_ROWS * ($page - 1);
        $type = $_GET['type'] ? $_GET['type'] : 0;

		//*********************** MAIN CODE START **********************\\

		# ASSIGNED VALUE
		$page_title = "My Requests";

		//***********************  MAIN CODE END  **********************\\

		global $sroot, $profile_id, $unix3month;

        if ($type) {
            $_SESSION['mreqtype'] = $type;
        }

        $mreqtype_sess = $_SESSION['mreqtype'];
        $mreqstatus_sess = $_SESSION['mreqstatus'];
        $mreqfrom_sess = $_SESSION['mreqfrom'];
        $mreqto_sess = $_SESSION['mreqto'];
        $mreqrefnum_sess = $_SESSION['mreqrefnum'];
        if ($_POST) {
            $mreqtype = $_POST['mreqtype'] ? $_POST['mreqtype'] : 1;
            $_SESSION['mreqtype'] = $mreqtype;
            $mreqstatus = $_POST['mreqstatus'] ? $_POST['mreqstatus'] : 0;
            $_SESSION['mreqstatus'] = $mreqstatus;
            $mreqfrom = $_POST['mreqfrom'] ? $_POST['mreqfrom'] : NULL;
            $_SESSION['mreqfrom'] = $mreqfrom;
            $mreqto = $_POST['mreqto'] ? $_POST['mreqto'] : NULL;
            $_SESSION['mreqto'] = $mreqto;
            $mreqrefnum = $_POST['mreqrefnum'] ? $_POST['mreqrefnum'] : NULL;
            $_SESSION['mreqrefnum'] = $mreqrefnum;
        }
        elseif ($mreqtype_sess || $mreqstatus_sess || $mreqfrom_sess || $mreqto_sess || $mreqrefnum_sess) {
            $mreqtype = $mreqtype_sess ? $mreqtype_sess : 1;
            $_POST['mreqtype'] = $mreqtype != 0 ? $mreqtype : 1;
            $mreqstatus = $mreqstatus_sess ? $mreqstatus_sess : 0;
            $_POST['mreqstatus'] = $mreqstatus != 0 ? $mreqstatus : 0;
            $mreqfrom = $mreqfrom_sess ? $mreqfrom_sess : NULL;
            $_POST['mreqfrom'] = $mreqfrom != 0 ? $mreqfrom : NULL;
            $mreqto = $mreqto_sess ? $mreqto_sess : NULL;
            $_POST['mreqto'] = $mreqto != 0 ? $mreqto : NULL;
            $mreqrefnum = $mreqrefnum_sess ? $mreqrefnum_sess : NULL;
            $_POST['mreqrefnum'] = $mreqrefnum != 0 ? $mreqrefnum : NULL;
        }
        else {
            $mreqtype = 1;
            $_POST['mreqtype'] = 1;
            $mreqstatus = 0;
            $_POST['mreqstatus'] = 0;
            $mreqfrom = NULL;
            $_POST['mregfrom'] = NULL;
            $mreqto = NULL;
            $_POST['mreqto'] = NULL;
            $mreqrefnum = NULL;
            $_POST['mregrefnum'] = NULL;
        }


        $mreq_data = $mainsql->get_mrequest($mreqtype, 0, $start, NUM_ROWS, $mreqrefnum, 0, $profile_idnum, $mreqstatus, $mreqfrom, $mreqto);
        $mreq_count = $mainsql->get_mrequest($mreqtype, 0, 0, 0, $mreqrefnum, 1, $profile_idnum, $mreqstatus, $mreqfrom, $mreqto);

		$pages = $mainsql->pagination("myrequest", $mreq_count, NUM_ROWS, 9);

        //var_dump($mreqto);
        var_dump($mreq_data);

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}

?>
