<?php

	if ($logged == 1) {

		# PAGINATION
		$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
		$start = NUM_ROWS * ($page - 1);
        $type = $_GET['type'] ? $_GET['type'] : 0;

		//*********************** MAIN CODE START **********************\\

		# ASSIGNED VALUE
		$page_title = "COE Requisition";

		//***********************  MAIN CODE END  **********************\\

		global $sroot, $profile_id, $unix3month;

		$coe_data = $mainsql->get_coe($start, NUM_ROWS, $profile_idnum, 0);
		$sql_users = "SELECT * FROM COEUsers";
		$coe_users = $mainsql->get_row($sql_users);
		$coe_count = $mainsql->get_coe(0, 0, $profile_idnum, 1);
		$pages = $mainsql->pagination("coe", $coe_count, NUM_ROWS, 9);

        var_dump($coe_data);
        //var_dump($mreq_data);

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}

?>
