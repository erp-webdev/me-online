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
		$sql_users = "SELECT A.*, B.* FROM COEUsers A
					LEFT JOIN SUBSIDIARY.DBO.viewHREmpMaster B on A.emp_id = B.EmpID AND A.[DB_NAME] = B.DBNAME
					WHERE A.empid = '$profile_id' and B.CompanyID = '$profile_comp'";
		$coe_users = $mainsql->get_numrow($sql_users);

		$sql_companies = "SELECT * FROM HRCompany";
		$admin_companies = $mainsql->get_row($sql_companies);

		$count = 0;
		var_dump($sql_users);exit(0);
		foreach ($coe_users as $key => $coe_user) {
			if(($profile_id == $coe_user["emp_id"] && $profile_dbname == $coe_user["DB_NAME"])){
				$count++;
			}
		}

		// foreach ($coe_users as $coe_user) {
		// 	if (($coe_user['emp_id'] == $profile_idnum)) {
		// 		if(empty($profile_email)){
		// 			$count++;
		// 			$admin_level = $coe_user['level'];
		// 		}else if($coe_user['EmailAdd'] == $profile_email){
		// 			$count++;
		// 			$admin_level = $coe_user['level'];
		// 		}
		// 	}
		// }

		if($count == 0){
			echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
		}


		$coe_count = $mainsql->get_coe(0, 0, null, 1, 2,$profile_idnum, $company_sort);

		$pages = $mainsql->pagination("coeadmin", $coe_count, NUM_ROWS, 9);

        // var_dump($coe_data);
        // var_dump($coe_data);

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}

?>
