<?php
	if ($logged == 1) {
        if ($wfhc_app) :

            include OBJ . '/wfh/WFHClearance.php';

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NUM_ROWS * ($page - 1);

            //*********************** MAIN CODE START **********************\\

            # ASSIGNED VALUE
            $page_title = "WFH Clearance";

            global $sroot, $profile_id, $unix3month;
            
            $wfh_clearance = new WFHClearance();
            
            switch ($_POST['btnwfhclearanceapply']) {
                case 'Submit':
                    $params = [
                        'wfh_type' => $_POST['wfh_type'],
                        'wfhc_from' => strtotime($_POST['wfhc_from']),
                        'wfhc_to' => strtotime($_POST['wfhc_to']),
                        'reason' => $_POST['reason'],
                        'attachments' => [
                            $_FILES['attachment1'],
                            $_FILES['attachment2'],
                            $_FILES['attachment3'],
                            $_FILES['attachment4'],
                            $_FILES['attachment5']
                        ]
                    ];

                    $wfh_clearance->validate($params);
                    $wfh_clearance->submit($params);
                    break;
            }

            //***********************  MAIN CODE END  **********************\\
        else :

            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."'</script>";

        endif;

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}

?>
