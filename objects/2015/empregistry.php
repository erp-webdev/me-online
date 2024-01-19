<?php
	
	if ($logged == 1) {
        
        if ($profile_level == 7 || $profile_level == 9 || $profile_level == 10) {

            # ASSIGNED VALUE
            $page_title = "Event Registry";	

            //***********************  MAIN CODE END  **********************\\

            global $sroot, $profile_id, $unix3month;

            // REGISTER MDTR
            if ($_POST['btnregistry'] || $_POST['btnregistry_x']) :

                $dept = $_POST['deptid']; 
                $actid = $_POST['actid']; //activity id of the event
                $godirectly = $_POST['godir'];

                $eventregistry = $tblsql->addeventregistry($dept, $actid, $godirectly);

                if ($eventregistry) :
                    echo '{"success": true, "numreg": "'.$eventregistry.'"}';
                    exit();
                else :
                    echo '{"success": false, "error": "There was a problem on activity registry"}';
                    exit();
                endif;
            endif;

            $dept_data = $tblsql->get_dept();
            $act_data = $tblsql->get_activities(0, 0, 0, NULL, 0, 0, 1, 1, 0, '999');
            
        }
        else
        {
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
        }
        
	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>