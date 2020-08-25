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

		$company_sort = $_SESSION["company_sort"] ? $_SESSION["company_sort"] : null ;

		$coe_data = $mainsql->get_coe($start, NUM_ROWS, null, 0, 2,$profile_idnum, $company_sort);
		$sql_users = "SELECT * FROM COEUsers";
		$coe_users = $mainsql->get_row($sql_users);

		$sql_companies = "SELECT * FROM HRCompany";
		$admin_companies = $mainsql->get_row($sql_companies);

		$count = 0;
		foreach ($coe_users as $key => $coe_user) {
			if(($profile_id == $coe_user["emp_id"] && $profile_dbname == $coe_user["DB_NAME"]) || $profile_id == '2019-02-0033' || $profile_idnum == '2016-06-0457'){
				$count++;
			}
		}
		if($count == 0){
			echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
		}

		$coe_count = $mainsql->get_coe(0, 0, null, 1, 2,$profile_idnum, $company_sort);

		$pages = $mainsql->pagination("coeadmin", $coe_count, NUM_ROWS, 9);

        var_dump($coe_data);
        // var_dump($coe_data);

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}

?>
