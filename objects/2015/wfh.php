<?php

	if ($logged == 1) {

        if ($wh_app) :

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NUM_ROWS * ($page - 1);

            //*********************** MAIN CODE START **********************\\

            # ASSIGNED VALUE
            $page_title = "Work from Home";

            //***********************  MAIN CODE END  **********************\\

            global $sroot, $profile_id, $unix3month;

            // REGISTER wfh
            if ($_POST['btnwfhapply'] || $_POST['btnwfhapply_x']) :

                //CHECK FOR INVALID DATE/TIME IN AND OUT

                $invalidcnt = 0;

                //CHECK DATE IF ITS APPLIED - START

                if ($_POST['wfh_from'] || $_POST['wfh_to']) :
                    if ($_POST['wfh_from'] && $_POST['wfh_to']) :
                    else :
                        echo '{"success": false, "error": "One of the date on Work from Home must be complete with time in and out. Unless both are blank"}';
                        exit();
                    endif;
                endif;

				$wfhitemcount = count($_POST['wfh_dayin']);

				$wfhcnt = 1;
				$wfherror = 0;
                while($wfhcnt <= $wfhitemcount){

					if($_POST['wfh_disable'][$wfhcnt]){
						$wfhcnt++;
						continue;
					}
                    if(!($_POST['wfh_totalworkedhours'][$wfhcnt] || $_POST['wfh_activity'][$wfhcnt])){
						$wfherror = 1;
					}
					$wfhcnt++;
                }
				if($wfherror){
					echo '{"success": false, "error": "All inputs on Work from Home must be completed (Total Worked Hours & Acitivities). Unless the date is excluded."}';
					exit();
				}

                $wfhstart = date("Y-m-d", strtotime($_POST['wfh_from']));
                $wfhend = date("Y-m-d", strtotime($_POST['wfh_to']));

                $wfhapplied = $mainsql->get_whdata_applied($profile_idnum, $wfhstart, $wfhend);
                if ($wfhapplied) :
                    $wfhapplieddata = $mainsql->get_whdata_applieddata($profile_idnum, $wfhstart, $wfhend);
                    echo '{"success": false, "error": "One of the date on Work from Home has been applied or approved with Request ID No. '.$wfhapplieddata[0]['ReqNbr'].'"}';
                    exit();
                endif;

                //CHECK DATE IF ITS APPLIED - END


                //WFH ITEMS
                $mail_details = '';

                $err_item = 0;
                $wfhitemcount = count($_POST['wfh_dayin']);

                $cnti = 1;

                while($cnti <= $wfhitemcount) :

					if($_POST['wfh_disable'][$cnti]){
						$cnti++;
						continue;
					}
                    $shiftdesc = $mainsql->get_shift($_POST['tsched_newsched'][$cnti]);

                    if ($cnti == 1) :
                        $wfhitempost['REQNBR'] = 0;
                    else :
                        $wfhitempost['REQNBR'] = $add_wfhitem;
                    endif;
                    $wfhitempost['DTRDATE'] = $_POST['wfh_dayin'][$cnti];
					$wfhitempost['AppliedHrs'] = $_POST['wfh_totalworkedhours'][$cnti];
                    $wfhitempost['Activities'] = $_POST['wfh_activity'][$cnti];
                    $temp_activities = json_decode( $wfhitempost['Activities']);
                        var_dump($temp_activities[0]); exit;
                    for($j = 0; $j < count($temp_activities); $j++){
                        if(trim($temp_activities[j]->act) == ''){
                            unset($temp_activities[j]);
                        } 
                    }
                    $wfhitempost['Activities'] = json_encode($temp_activities);

                            $add_wfhitem = $mainsql->wh_action($wfhitempost, 'add_item');
							$cnti++;

                endwhile;

                $wfhpost['EMPID'] = $_POST['empid'];
                $wfhpost['REQNBR'] = $add_wfhitem;
                $wfhpost['TRANS'] = "APPLY";
				$wfhpost['DATESTART'] = $_POST['wfh_from'];
                $wfhpost['DATEEND'] = $_POST['wfh_to'];
                $wfhpost['APPROVER01'] = $_POST['approver1'];
                $wfhpost['APPROVER02'] = $_POST['approver2'];
                $wfhpost['APPROVER03'] = $_POST['approver3'];
                $wfhpost['APPROVER04'] = $_POST['approver4'];
                $wfhpost['APPROVER05'] = $_POST['approver5'];
                $wfhpost['APPROVER06'] = $_POST['approver6'];
                $wfhpost['DBAPPROVER01'] = $_POST['dbapprover1'];
                $wfhpost['DBAPPROVER02'] = $_POST['dbapprover2'];
                $wfhpost['DBAPPROVER03'] = $_POST['dbapprover3'];
                $wfhpost['DBAPPROVER04'] = $_POST['dbapprover4'];
                $wfhpost['DBAPPROVER05'] = $_POST['dbapprover5'];
                $wfhpost['DBAPPROVER06'] = $_POST['dbapprover6'];
                $wfhpost['USER'] = $_POST['user'];
                $wfhpost['REMARKS'] = "";

                //var_dump($mdpost);

                $add_wfh = $mainsql->wh_action($wfhpost, 'add');

                if($add_wfh) :

                    $requestor = $register->get_member($_POST['empid']);
                    $request_info = $tblsql->get_mrequest(7, 0, 0, 0, $add_wfh, 0, NULL, NULL, NULL, NULL);
                    $approver = $logsql->get_allmember($_POST['approver1'], $_POST['dbapprover1']);

                    $reqemailblock = $mainsql->get_newemailblock($_POST['empid']);
                    $appemailblock = $mainsql->get_newemailblock($_POST['approver1']);

                    if ($reqemailblock) :

                        //SEND EMAIL (REQUESTOR)

                        $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New Work from Home Request</span><br><br>Hi ".$requestor[0]['NickName'].",<br><br>";
                        $message .= "You opened a new request for Work from Home with Reference No: ".$add_wfh." on ".date('F j, Y')." and it's subject for approval. ";
                        $message .= "<br><br>Thanks,<br>";
                        $message .= SITENAME." Admin";
						$message .= "<br>Click<a href='https://portal.megaworldcorp.com/me/login'> here</a> to login";
						$message .= "<hr />".MAILFOOT."</div>";

                        $headers = "From: ".NOTIFICATION_EMAIL."\r\n";
                        $headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                        $sendmail = mail($requestor[0]['EmailAdd'], "New Work from Home Request", $message, $headers);

                    endif;

                    if ($appemailblock) :

                        //SEND EMAIL (APPROVER)

                        $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New Work from Home Request from ".$requestor[0]['FName']." ".$requestor[0]['LName']."</span><br><br>Hi ".$approver[0]['NickName'].",<br><br>";
                        $message .= "New request ".$requestor[0]['FName']." ".$requestor[0]['LName']." for Work from Home with Reference No: ".$add_wfh." on ".date('F j, Y')." for your approval. ";
                        $message .= "<br><br>Thanks,<br>";
                        $message .= SITENAME." Admin";
			$message .= "<br>Click<a href='https://portal.megaworldcorp.com/me/login'> here</a> to login";
                        $message .= "<hr />".MAILFOOT."</div>";

                        $headers = "From: ".NOTIFICATION_EMAIL."\r\n";
                        $headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                        $sendmail = mail($approver[0]['EmailAdd'], "New Work from Home Request for your Approval", $message, $headers);

                    endif;

                    //READ STATUS
                    if ($_POST['approver1'] && $add_wfh) :
                        $insert_read = $mainsql->insert_read($_POST['approver1'], $add_wfh);
                    endif;

                    //AUDIT TRAIL
                    $post['EMPID'] = $profile_idnum;
                    $post['TASKS'] = "CREATE_WORK_FROM_HOME";
                    $post['DATA'] = $add_wfh;
                    $post['DATE'] = date("m/d/Y H:i:s.000");

                    $log = $mainsql->log_action($post, 'add');

                    if ($err_item) :
                        echo '{"success": false, "error": "One or more of Work from Home item hasn\'t been process due network problem. Please forward email notification with its request ID."}';
                        exit();
                    else :
                        echo '{"success": true}';
                        exit();
                    endif;
                else :
                    echo '{"success": false, "error": "There was a problem on Work from Home application"}';
                    exit();
                endif;

            endif;

            $cday = date("U");
            $nday = date("j");

            if ($nday <= 15) :
                $wfh_fdate = date("Y-m-01", $cday);
                $wfh_from = strtotime(date("Y-m-01 00:00:00", $cday));
                $wfh_from2 = strtotime(date("Y-m-01 00:00:00", $cday));
                $wfh_tdate = date("Y-m-15", $cday);
                $wfh_to = strtotime(date("Y-m-15 23:59:59", $cday));
                $wfh_to2 = strtotime(date("Y-m-15 23:59:59", $cday));
            else :
                $wfh_fdate = date("Y-m-16", $cday);
                $wfh_from = strtotime(date("Y-m-16 00:00:00", $cday));
                $wfh_from2 = strtotime(date("Y-m-16 00:00:00", $cday));
                $wfh_tdate = date("Y-m-t", $cday);
                $wfh_to = strtotime(date("Y-m-t 23:59:59", $cday));
                $wfh_to2 = strtotime(date("Y-m-t 23:59:59", $cday));
            endif;

            $wfh_todate = date("Y-m-d", $cday);
            $wfh_today = strtotime(date("Y-m-d 23:59:59", $cday));

            if ($wfh_from2 > $wfh_to2) :
                $dayn = 0;
            else :
                $dayn = 0;
                while($wfh_from2 <= $wfh_to2) {
                    $dayn++;
                    $wfh_from2 = strtotime("+1 day", $wfh_from2);
                }
            endif;

        else :

            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."'</script>";

        endif;

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}

?>
