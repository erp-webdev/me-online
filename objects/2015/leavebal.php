<?php

	if ($logged == 1) {

		# PAGINATION
		$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
		$start = NUM_ROWS * ($page - 1);

		//*********************** MAIN CODE START **********************\\

		# ASSIGNED VALUE
		$page_title = "Leave Balance";

		//***********************  MAIN CODE END  **********************\\

		global $sroot, $profile_id, $unix3month;

        $leave_data = $mainsql->get_leave();

				$cnt = 0;

				while($cnt < 4) :

						$lbalancepost['EMPID'] = $profile_idnum;
						if($cnt == 0){
							$lbalancepost['LEAVEID'] = 'L01';
						}elseif ($cnt == 1) {
							$lbalancepost['LEAVEID'] = 'L02';
						}elseif ($cnt == 2) {
							$lbalancepost['LEAVEID'] = 'L03';
						}elseif ($cnt == 3) {
							$lbalancepost['LEAVEID'] = 'L05';
						}

						$calculate_balance = $mainsql->calculate_lbalance($lbalancepost, $dbname);
						$cnt++;

				endwhile;

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}

?>
