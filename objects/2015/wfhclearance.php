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
                        'empid' => $_POST['empid'],
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

                    $wcpost['EMPID'] = $_POST['empid'];
                    $wcpost['REQNBR'] = $_POST['reqnbr'];
                    $wcpost['TRANS'] = "APPLY";

                    $wcpost['CLEARANCETYPE'] = $_POST['wfh_type'];
                    $wcpost['DATESTART'] = $_POST['wfhc_from'];
                    $wcpost['DATEEND'] = $_POST['wfhc_to'];
                    $wcpost['REASON'] = $_POST['reason'];

                    $wcpost['APPROVER01'] = $_POST['approver1'];
                    $wcpost['APPROVER02'] = $_POST['approver2'];
                    $wcpost['APPROVER03'] = $_POST['approver3'];
                    $wcpost['APPROVER04'] = $_POST['approver4'];
                    $wcpost['APPROVER05'] = $_POST['approver5'];
                    $wcpost['APPROVER06'] = $_POST['approver6'];
                    $wcpost['DBAPPROVER01'] = $_POST['dbapprover1'];
                    $wcpost['DBAPPROVER02'] = $_POST['dbapprover2'];
                    $wcpost['DBAPPROVER03'] = $_POST['dbapprover3'];
                    $wcpost['DBAPPROVER04'] = $_POST['dbapprover4'];
                    $wcpost['DBAPPROVER05'] = $_POST['dbapprover5'];
                    $wcpost['DBAPPROVER06'] = $_POST['dbapprover6'];
                    $wcpost['USER'] = $_POST['user'];
                    $wcpost['REMARKS'] = "";

                    $wfh_clearance->validate($params);
                    $add_wc = $wfh_clearance->submit($wcpost);

                    if($add_wc) : 

                        $wfh_clearance->saveAttachment($add_wc);
                        $wfh_clearance->notifyRequestor($_POST['empid'], $add_wc);
                        $wfh_clearance->notifyApprovers($_POST['empid'], $add_wc, $_POST['approver1'], $_POST['dbapprover1']);
                        echo '{"success": true}';
                        exit();
                        
                    endif;
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
