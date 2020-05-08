<?php

	if ($logged == 1) {

		# PAGINATION
		$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
		$start = NOTI_NUM_ROWS * ($page - 1);

		//*********************** MAIN CODE START **********************\\

		# ASSIGNED VALUE
		$page_title = "Pending Requests";

		//***********************  MAIN CODE END  **********************\\

		global $sroot, $profile_id, $unix3month;

        $searchpend_sess = $_SESSION['searchpend'];
        $pendtype_sess = $_SESSION['pendtype'];
        $pendfrom_sess = $_SESSION['pendfrom'];
        $pendto_sess = $_SESSION['pendto'];
        if ($_POST) {
            $searchpend = $_POST['searchpend'] ? $_POST['searchpend'] : NULL;
            $_SESSION['searchpend'] = $searchpend;
            $pendtype = $_POST['pendtype'] ? $_POST['pendtype'] : NULL;
            $_SESSION['pendtype'] = $pendtype;
            $pendfrom = $_POST['pendfrom'] ? $_POST['pendfrom'] : NULL;
            $_SESSION['pendfrom'] = $pendfrom;
            $pendto = $_POST['pendto'] ? $_POST['pendto'] : NULL;
            $_SESSION['pendto'] = $pendto;
        }
        elseif ($searchpend_sess || $pendtype_sess) {
            $searchpend = $searchpend_sess ? $searchpend_sess : NULL;
            $_POST['searchpend'] = $searchpend != 0 ? $searchpend : NULL;
            $pendtype = $pendtype_sess ? $pendtype_sess : NULL;
            $_POST['pendtype'] = $pendtype != 0 ? $pendtype : NULL;
            $pendfrom = $pendfrom_sess ? $pendfrom_sess : NULL;
            $_POST['pendfrom'] = $pendfrom != 0 ? $pendfrom : NULL;
            $pendto = $pendto_sess ? $pendto_sess : NULL;
            $_POST['pendto'] = $pendto != 0 ? $pendto : NULL;
        }
        else {
            $searchpend = NULL;
            $_POST['searchpend'] = NULL;
            $pendtype = NULL;
            $_POST['pendtype'] = NULL;
            $pendfrom = NULL;
            $_POST['pendfrom'] = NULL;
            $pendto = NULL;
            $_POST['pendto'] = NULL;
        }

        $pending_data = $tblsql->get_pendingnoti(NULL, $start, NOTI_NUM_ROWS, $searchpend, 0, $profile_idnum, $pendfrom, $pendto, $pendtype, $profile_dbname);
        $pending_count = $tblsql->get_pendingnoti(NULL, 0, 0, $searchpend, 1, $profile_idnum, $pendfrom, $pendto, $pendtype, $profile_dbname);

		// var_dump($pending_data);
        //var_dump($pending_count);

		$pages = $mainsql->pagination("pending", $pending_count, NOTI_NUM_ROWS, 9);


        //var_dump($pending_data);

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}

?>
