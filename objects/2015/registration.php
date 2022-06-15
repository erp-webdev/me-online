<?php

	if ($logged == 1) {

		# PAGINATION
		$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
		$start = NUM_ROWS * ($page - 1);

		//*********************** MAIN CODE START **********************\\

		# ASSIGNED VALUE
		$page_title = "My Registration";

		//***********************  MAIN CODE END  **********************\\

		global $sroot, $profile_id, $unix3month;

        // FEDDBACK ACTIVITY
        if ($_POST['btnfback'] || $_POST['btnfback_x']) :

            $_POST['fback_date'] = date('U');

            $fback_activity = $tblsql->register_action($_POST, 'feedback');
            if($fback_activity) :
                echo '{"success": true}';
                exit();
            else :
                echo '{"success": false}';
                exit();
            endif;

        endif;
		echo $profile_dbname; exit;
        $my_registration = $tblsql->get_registration(0, 0, 0, 0, $profile_id, $profile_dbname);

		$_SESSION["xmas"] = 0;
		foreach($my_registration as $activ){
			if($activ['activity_id'] == '2661' || $activ['activity_id'] == '2660' ){
				$_SESSION["xmas"] = 1;
			}
		}
	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}

?>
