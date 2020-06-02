<?php
	
	if ($logged == 1) {
        
        if ($sc_app) :

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NUM_ROWS * ($page - 1);

            //*********************** MAIN CODE START **********************\\

            # ASSIGNED VALUE
            $page_title = "Time Scheduler";	

            //***********************  MAIN CODE END  **********************\\

            global $sroot, $profile_id, $unix3month;

            // REGISTER SC
            if ($_POST['btnscapply'] || $_POST['btnscapply_x']) :
        
                //CHECK DATE IF ITS APPLIED - START
        
                $tschedstart = date("Y-m-d", strtotime($_POST['tsched_from']));        
                $tschedend = date("Y-m-d", strtotime($_POST['tsched_to']));        
                
                $tsapplied = $mainsql->get_tscheddata_applied($profile_idnum, $tschedstart, $tschedend);
                if ($tsapplied) :                        
                    $tsapplied2 = $mainsql->get_tscheddata_applieddata($profile_idnum, $tschedstart, $tschedend);
                    echo '{"success": false, "error": "One of the date on time scheduler has been applied or approved. Please check reference # '.$tsapplied2[0]['ReqNbr'].'"}';
                    exit();
                endif;
        
                //CHECK DATE IF ITS APPLIED - END

                $allowedExts = array("JPG", "JPEG", "GIF", "PNG", "PDF", "jpg", "jpeg", "gif", "png", "pdf");
        
                $errorfile = 0;
                for($i=1; $i<=5; $i++) :

                    if ($_FILES['attachment'.$i]['name']) :
                        $filename = $_FILES['attachment'.$i]['name'];
                        $filesize = $_FILES['attachment'.$i]['size'];

                        $tempext = explode(".", $filename);
                        $extension = end($tempext);

                        if (($filesize >= 209715) || !in_array($extension, $allowedExts)) :
                            $errorfile++;
                        endif;
                    endif;
                endfor;
        
                if ($errorfile) :
                    echo '{"success": false, "error": "One of the attachment isn\'t PDF, JPG nor GIF and/or not less then 200Kb"}';
                    exit();
                endif;
        
                //TSCHED ITEMS
                $mail_details = '';

                $err_item = 0;
                $tsitemcount = count($_POST['tsched_newsched']);
        
                //var_dump($tsitemcount);

                $cnti = 1;

                while($cnti <= $tsitemcount) :
        
                    $oldshiftdesc = $mainsql->get_shift($_POST['shift_id'][$cnti]);
                    $shiftdesc = $mainsql->get_shift($_POST['tsched_newsched'][$cnti]);

                    if ($cnti == 1) :
                        $scitempost['REQNBR'] = 0;
                    else : 
                        $scitempost['REQNBR'] = $add_scitem;
                    endif;

                    $scitempost['DTRDATE'] = $_POST['dtr_date'][$cnti];
                    $scitempost['SHITID'] = $_POST['shift_id'][$cnti];
                    $scitempost['TIMEIN'] = $_POST['tsched_timein'][$cnti];
                    $scitempost['TIMEOUT'] = $_POST['tsched_timeout'][$cnti];
                    $scitempost['NEWSHITDESC'] = $_POST['tsched_newsched'][$cnti] ? $shiftdesc[0]['ShiftDesc'] : NULL;        
                    $scitempost['NEWSHITID'] = $_POST['tsched_newsched'][$cnti];
                    $scitempost['RESTDAY'] = $_POST['tsched_newsched'][$cnti] ? 0 : 1;

                    if ($_POST['shift_id'][$cnti] != $_POST['tsched_newsched'][$cnti]) :
                        $add_scitem = $mainsql->sc_action($scitempost, 'add_item');	
                        if ($add_scitem) :
                            $mail_details .= "<tr><td>".date('M j', strtotime($_POST['dtr_date'][$cnti]))."</td><td>".($_POST['shift_id'][$cnti] ? $oldshiftdesc[0]['ShiftDesc'] : NULL)."</td><td>".($_POST['tsched_newsched'][$cnti] ? $shiftdesc[0]['ShiftDesc'] : NULL)."</td></tr>";
                            $cnti++;
                        endif;
                    else :
                        $cnti++;
                    endif;    

                endwhile;

                $scpost['EMPID'] = $_POST['empid'];
                $scpost['REQNBR'] = $add_scitem;
                $scpost['TRANS'] = "APPLY";
                $scpost['FROMDATE'] = $_POST['tsched_from'];
                $scpost['APPROVER01'] = $_POST['approver1'];
                $scpost['APPROVER02'] = $_POST['approver2'];
                $scpost['APPROVER03'] = $_POST['approver3'];
                $scpost['APPROVER04'] = $_POST['approver4'];
                $scpost['APPROVER05'] = $_POST['approver5'];
                $scpost['APPROVER06'] = $_POST['approver6'];
                $scpost['DBAPPROVER01'] = $_POST['dbapprover1'];
                $scpost['DBAPPROVER02'] = $_POST['dbapprover2'];
                $scpost['DBAPPROVER03'] = $_POST['dbapprover3'];
                $scpost['DBAPPROVER04'] = $_POST['dbapprover4'];
                $scpost['DBAPPROVER05'] = $_POST['dbapprover5'];
                $scpost['DBAPPROVER06'] = $_POST['dbapprover6'];
                $scpost['USER'] = $_POST['user'];
                $scpost['REMARKS'] = $_POST['tsched_remarks'];

                $add_sc = $mainsql->sc_action($scpost, 'add');			

                if($add_sc) : 

                    for($i=1; $i<=5; $i++) :

                        if ($_FILES['attachment'.$i]['name']) :

                            $image = $_FILES['attachment'.$i]['tmp_name'];
                            $filename = $_FILES['attachment'.$i]['name'];
                            $filesize = $_FILES['attachment'.$i]['size'];
                            $filetype = $_FILES['attachment'.$i]['type'];

                            $tempext = explode(".", $filename);
                            $extension = end($tempext);

                            if (($filesize < 10485760) && in_array($extension, $allowedExts)) :

                                $path = "uploads/sc/";
                                $fixname = 'attach_'.$add_sc.'_'.$i.'.'.$extension;
                                $target_path = $path.$fixname; 

                                $filemove = move_uploaded_file($image, $target_path);

                                $attach['attachfile'] = $fixname;
                                $attach['attachtype'] = $filetype;
                                $attach['reqnbr'] = $add_sc;

                                if($filemove) :
                                    $add_attach = $mainsql->attach_action($attach, 'add');			
                                endif;

                            endif;

                        endif;

                    endfor;
        
                    $requestor = $register->get_member($_POST['empid']);
                    $request_info = $tblsql->get_mrequest(8, 0, 0, 0, $add_sc, 0, NULL, NULL, NULL, NULL);
                    $approver = $logsql->get_allmember($_POST['approver1'], $_POST['dbapprover1']);
        
                    $reqemailblock = $mainsql->get_newemailblock($_POST['empid']);
                    $appemailblock = $mainsql->get_newemailblock($_POST['approver1']);

                    if ($reqemailblock) :

                        //SEND EMAIL (REQUESTOR)

                        $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New Change Schedule Request</span><br><br>Hi ".$requestor[0]['NickName'].",<br><br>";
                        $message .= "You opened a new request for change schedule with Reference No: ".$add_sc." on ".date('F j, Y')." and it's subject for approval. ";
                        $message .= "<br><br><table border='1' cellpadding='3' cellspacing='0' style='border: 1px solid #666; font-size: 12px; font-family: Verdana;'>";
                        $message .= "<tr><td style='background-color: #024485; color: #FFF; text-align: center'><b>Date</b></td><td style='background-color: #024485; color: #FFF; text-align: center'><b>Current Shift</b></td><td style='background-color: #024485; color: #FFF; text-align: center'><b>New Shift</b></td></tr>";
                        $message .= $mail_details;
                        $message .= "</table>";
                        $message .= "<br><br>Thanks,<br>";
                        $message .= SITENAME." Admin";
			$message .= "<br>Click<a href='https://portal.megaworldcorp.com/me/login'> here</a> to login";
                        $message .= "<hr />".MAILFOOT."</div>";

                        $headers = "From: ".NOTIFICATION_EMAIL."\r\n";
                        $headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                        $sendmail = mail($requestor[0]['EmailAdd'], "New Change Schedule Request", $message, $headers);   
        
                    endif; 

                    if ($appemailblock) :           

                        //SEND EMAIL (APPROVER)

                        $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New Change Schedule Request from ".$requestor[0]['FName']." ".$requestor[0]['LName']."</span><br><br>Hi ".$approver[0]['NickName'].",<br><br>";
                        $message .= "New request ".$requestor[0]['FName']." ".$requestor[0]['LName']." for change schedule with Reference No: ".$add_sc." on ".date('F j, Y')." for your approval. ";
                        $message .= "<br><br>Thanks,<br>";
                        $message .= SITENAME." Admin";
			$message .= "<br>Click<a href='https://portal.megaworldcorp.com/me/login'> here</a> to login";

                        $message .= "<hr />".MAILFOOT."</div>";

                        $headers = "From: ".NOTIFICATION_EMAIL."\r\n";
                        $headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                        $sendmail = mail($approver[0]['EmailAdd'], "New Change Schedule Request for your Approval", $message, $headers);   
        
                    endif;
        
                    //READ STATUS                    
                    if ($_POST['approver1'] && $add_sc) :
                        $insert_read = $mainsql->insert_read($_POST['approver1'], $add_sc);
                    endif;

                    //AUDIT TRAIL
                    $post['EMPID'] = $profile_idnum;
                    $post['TASKS'] = "CREATE_SC";
                    $post['DATA'] = $add_sc;
                    $post['DATE'] = date("m/d/Y H:i:s.000");

                    $log = $mainsql->log_action($post, 'add');
        
                    if ($err_item) :
                        echo '{"success": false, "error": "One or more of time scheduler item hasn\'t been process due network problem. Please forward email notification with its request ID."}';
                        exit();        
                    else :
                        echo '{"success": true}';
                        exit();
                    endif;
                else :
                    echo '{"success": false, "error": "There was a problem on time scheduler application"}';
                    exit();
                endif; 

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