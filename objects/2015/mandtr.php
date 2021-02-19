<?php
	
	if ($logged == 1) {
        
        if ($md_app) :

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NUM_ROWS * ($page - 1);

            //*********************** MAIN CODE START **********************\\

            # ASSIGNED VALUE
            $page_title = "Manual DTR";	

            //***********************  MAIN CODE END  **********************\\

            global $sroot, $profile_id, $unix3month;

            // REGISTER MDTR
            if ($_POST['btnmdapply'] || $_POST['btnmdapply_x']) :
        
                //CHECK FOR INVALID DATE/TIME IN AND OUT
        
                $invalidcnt = 0;
        
                
        
                foreach ($_POST['mdtr_hours'] as $kh => $vh) :
                    if ($vh < 0) :
                        $invalidcnt++;
                    endif;
                endforeach;  
        
                if ($invalidcnt) :                        
                    echo '{"success": false, "error": "One of the date on manual DTR is invalid where your time-in is greater than your time-out or date coverage and format is invalid"}';
                    exit();
                endif;

                //CHECK DATE IF ITS APPLIED - START
        
                if ($_POST['mdtr_from'] || $_POST['mdtr_to']) :
                    if ($_POST['mdtr_from'] && $_POST['mdtr_to']) :
                    else :
                        echo '{"success": false, "error": "One of the date on manual DTR must be complete with time in and out. Unless both are blank"}';
                        exit();
                    endif;
                endif;
        
                $mdtrstart = date("Y-m-d", strtotime($_POST['mdtr_from']));        
                $mdtrend = date("Y-m-d", strtotime($_POST['mdtr_to']));        
                
                $mdtrapplied = $mainsql->get_mandtrdata_applied($profile_idnum, $mdtrstart, $mdtrend);
                if ($mdtrapplied) :                        
                    $mdtrapplieddata = $mainsql->get_mandtrdata_applieddata($profile_idnum, $mdtrstart, $mdtrend);
                    echo '{"success": false, "error": "One of the date on manual DTR has been applied or approved with Request ID No. '.$mdtrapplieddata[0]['ReqNbr'].'"}';
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
        
                foreach ($_POST['mdtr_dayin'] as $key => $value) :
        
                    if ($_POST['mdtr_timein'][$key] && $_POST['mdtr_timeout'][$key]) :
                        if (!preg_match("/\d{1,2}:\d{1,2}(?:am|pm)/i", $_POST['mdtr_timein'][$key]) || !preg_match("/\d{1,2}:\d{1,2}(?:am|pm)/i", $_POST['mdtr_timeout'][$key])) :
                            echo '{"success": false, "error": "One of the time has invalid format. It must be like as 12:12pm or 08:03am"}';
                            exit();
                        endif;
                    endif;

                endforeach; 
        
                //MANDTR ITEMS
                $mail_details = '';

                $err_item = 0;
                $mdtritemcount = count($_POST['mdtr_dayin']);

                $cnti = 1;

                while($cnti <= $mdtritemcount) :

                    $shiftdesc = $mainsql->get_shift($_POST['tsched_newsched'][$cnti]);
        
                    if ($cnti == 1) :
                        $mditempost['REQNBR'] = 0;
                    else : 
                        $mditempost['REQNBR'] = $add_mditem;
                    endif;
                    $mditempost['DTRDATE'] = $_POST['mdtr_dayin'][$cnti];
                    $mditempost['SHIFTDESC'] = $_POST['mdtr_shiftdesc'][$cnti];
                    $mditempost['TIMEINDATE'] = $_POST['mdtr_timein'][$cnti] ? $_POST['mdtr_dayin'][$cnti] : NULL;
                    $mditempost['TIMEOUTDATE'] = $_POST['mdtr_timeout'][$cnti] ? $_POST['mdtr_dayout'][$cnti] : NULL;
                    $mditempost['TIMEIN'] = $_POST['mdtr_timein'][$cnti] ? $_POST['mdtr_timein'][$cnti] : NULL;
                    $mditempost['TIMEOUT'] = $_POST['mdtr_timeout'][$cnti] ? $_POST['mdtr_timeout'][$cnti] : NULL;
                    $mditempost['NEWSHIFTDESC'] = $_POST['mdtr_newsched'][$cnti] ? $_POST['mdtr_newsched'][$cnti] : NULL;        
                    $mditempost['RESTDAY'] = $_POST['mdtr_newsched'][$cnti] ? 0 : 1;
                    $mditempost['SHIFTID'] = $_POST['mdtr_newsched'][$cnti];
                    
                    if ($_POST['mdtr_timein'][$cnti] && $_POST['mdtr_timeout'][$cnti]) :
        
                        if (($_POST['mdtr_shiftdesc'][$cnti] != "NO SHIFT") && ($_POST['mdtr_newsched'][$cnti] != 0)) :

                            $add_mditem = $mainsql->md_action($mditempost, 'add_item');	
                            var_dump($add_mditem); exit;
                            if ($add_mditem) :
                                $newhiftdesc = $mainsql->get_shift($_POST['mdtr_newsched'][$cnti]);
                                $mail_details .= "<tr><td>".date('M j', strtotime($value))."</td><td>".($_POST['mdtr_timein'][$cnti] ? date('M j g:ia', strtotime($_POST['mdtr_dayin'][$cnti].' '.$_POST['mdtr_timein'][$cnti])) : '')."</td><td>".($_POST['mdtr_timeout'][$cnti] ? date('M j g:ia', strtotime($_POST['mdtr_dayout'][$cnti].' '.$_POST['mdtr_timeout'][$cnti])) : '')."</td><td>".($_POST['mdtr_shiftdesc'][$cnti] ? $_POST['mdtr_shiftdesc'][$cnti] : 'RESTDAY')."</td><td>".($_POST['mdtr_newsched'][$cnti] ? $newhiftdesc[0]['ShiftDesc'] : 'RESTDAY')."</td></tr>";
                                $cnti++;
                            endif;
                        else :
                            $cnti++;
                        endif;
        
                    else :
        
                        if ((($_POST['mdtr_shiftdesc'][$cnti] != "RESTDAY") && ($_POST['mdtr_newsched'][$cnti] != "")) || (($_POST['mdtr_shiftdesc'][$cnti] != "NO SHIFT") && ($_POST['mdtr_newsched'][$cnti] != 0))) :

                            $add_mditem = $mainsql->md_action($mditempost, 'add_item');	

                            if ($add_mditem) :
                                $newhiftdesc = $mainsql->get_shift($_POST['mdtr_newsched'][$cnti]);
                                $mail_details .= "<tr><td>".date('M j', strtotime($value))."</td><td>".($_POST['mdtr_timein'][$cnti] ? date('M j g:ia', strtotime($_POST['mdtr_dayin'][$cnti].' '.$_POST['mdtr_timein'][$cnti])) : '')."</td><td>".($_POST['mdtr_timeout'][$cnti] ? date('M j g:ia', strtotime($_POST['mdtr_dayout'][$cnti].' '.$_POST['mdtr_timeout'][$cnti])) : '')."</td><td>".($_POST['mdtr_shiftdesc'][$cnti] ? $_POST['mdtr_shiftdesc'][$cnti] : 'RESTDAY')."</td><td>".($_POST['mdtr_newsched'][$cnti] ? $newhiftdesc[0]['ShiftDesc'] : 'RESTDAY')."</td></tr>";
                                $cnti++;
                            endif;
                        else :
                            $cnti++;
                        endif;
        
                    endif;
                endwhile;

                $mdpost['EMPID'] = $_POST['empid'];
                $mdpost['REQNBR'] = $add_mditem;
                $mdpost['TRANS'] = "APPLY";
                $mdpost['DATESTART'] = $_POST['mdtr_from'];
                $mdpost['APPROVER01'] = $_POST['approver1'];
                $mdpost['APPROVER02'] = $_POST['approver2'];
                $mdpost['APPROVER03'] = $_POST['approver3'];
                $mdpost['APPROVER04'] = $_POST['approver4'];
                $mdpost['APPROVER05'] = $_POST['approver5'];
                $mdpost['APPROVER06'] = $_POST['approver6'];
                $mdpost['DBAPPROVER01'] = $_POST['dbapprover1'];
                $mdpost['DBAPPROVER02'] = $_POST['dbapprover2'];
                $mdpost['DBAPPROVER03'] = $_POST['dbapprover3'];
                $mdpost['DBAPPROVER04'] = $_POST['dbapprover4'];
                $mdpost['DBAPPROVER05'] = $_POST['dbapprover5'];
                $mdpost['DBAPPROVER06'] = $_POST['dbapprover6'];
                $mdpost['USER'] = $_POST['user'];
                $mdpost['REMARKS'] = "";
        
                //var_dump($mdpost);

                $add_md = $mainsql->md_action($mdpost, 'add');		
                if($add_md) : 

                    for($i=1; $i<=5; $i++) :

                        if ($_FILES['attachment'.$i]['name']) :

                            $image = $_FILES['attachment'.$i]['tmp_name'];
                            $filename = $_FILES['attachment'.$i]['name'];
                            $filesize = $_FILES['attachment'.$i]['size'];
                            $filetype = $_FILES['attachment'.$i]['type'];

                            $tempext = explode(".", $filename);
                            $extension = end($tempext);

                            if (($filesize < 10485760) && in_array($extension, $allowedExts)) :

                                $path = "uploads/md/";
                                $fixname = 'attach_'.$add_md.'_'.$i.'.'.$extension;
                                $target_path = $path.$fixname; 

                                $filemove = move_uploaded_file($image, $target_path);

                                $attach['attachfile'] = $fixname;
                                $attach['attachtype'] = $filetype;
                                $attach['reqnbr'] = $add_md;

                                if($filemove) :
                                    $add_attach = $mainsql->attach_action($attach, 'add');			
                                endif;

                            endif;

                        endif;

                    endfor;
        
                    $requestor = $register->get_member($_POST['empid']);
                    $request_info = $tblsql->get_mrequest(7, 0, 0, 0, $add_md, 0, NULL, NULL, NULL, NULL);
                    $approver = $logsql->get_allmember($_POST['approver1'], $_POST['dbapprover1']);
        
                    $reqemailblock = $mainsql->get_newemailblock($_POST['empid']);
                    $appemailblock = $mainsql->get_newemailblock($_POST['approver1']);

                    if ($reqemailblock) :

                        //SEND EMAIL (REQUESTOR)

                        $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New manual DTR Request</span><br><br>Hi ".$requestor[0]['NickName'].",<br><br>";
                        $message .= "You opened a new request for Manual DTR with Reference No: ".$add_md." on ".date('F j, Y')." and it's subject for approval. ";
                        $message .= "<br><br><table border='1' cellpadding='3' cellspacing='0' style='border: 1px solid #666; font-size: 12px; font-family: Verdana;'>";
                        $message .= "<tr><td style='background-color: #024485; color: #FFF; text-align: center'><b>Date</b></td><td style='background-color: #024485; color: #FFF; text-align: center'><b>In</b></td><td style='background-color: #024485; color: #FFF; text-align: center'><b>Out</b></td><td style='background-color: #024485; color: #FFF; text-align: center'><b>Current Shift</b></td><td style='background-color: #024485; color: #FFF; text-align: center'><b>New Shift</b></td></tr>";
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

                        $sendmail = mail($requestor[0]['EmailAdd'], "New Manual DTR Request", $message, $headers); 
        
                    endif; 

                    if ($appemailblock) :           

                        //SEND EMAIL (APPROVER)

                        $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New manual DTR Request from ".$requestor[0]['FName']." ".$requestor[0]['LName']."</span><br><br>Hi ".$approver[0]['NickName'].",<br><br>";
                        $message .= "New request ".$requestor[0]['FName']." ".$requestor[0]['LName']." for Manual DTR with Reference No: ".$add_md." on ".date('F j, Y')." for your approval. ";
                        $message .= "<br><br>Thanks,<br>";
                        $message .= SITENAME." Admin";
			            $message .= "<br>Click<a href='https://portal.megaworldcorp.com/me/login'> here</a> to login";
                        $message .= "<hr />".MAILFOOT."</div>";

                        $headers = "From: ".NOTIFICATION_EMAIL."\r\n";
                        $headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                        $sendmail = mail($approver[0]['EmailAdd'], "New Manual DTR Request for your Approval", $message, $headers);
        
                    endif;
        
                    //READ STATUS
                    if ($_POST['approver1'] && $add_md) :
                        $insert_read = $mainsql->insert_read($_POST['approver1'], $add_md);
                    endif;

                    //AUDIT TRAIL
                    $post['EMPID'] = $profile_idnum;
                    $post['TASKS'] = "CREATE_MANUAL_DTR";
                    $post['DATA'] = $add_md;
                    $post['DATE'] = date("m/d/Y H:i:s.000");

                    $log = $mainsql->log_action($post, 'add');

                    if ($err_item) :
                        echo '{"success": false, "error": "One or more of manual DTR item hasn\'t been process due network problem. Please forward email notification with its request ID."}';
                        exit();        
                    else :
                        echo '{"success": true}';
                        exit();
                    endif;
                else :
                    echo '{"success": false, "error": "There was a problem on manual DTR application"}';
                    exit();
                endif; 

            endif;

            $cday = date("U");
            $nday = date("j");

            if ($nday <= 15) :
                $mandtr_fdate = date("Y-m-01", $cday);       
                $mandtr_from = strtotime(date("Y-m-01 00:00:00", $cday));       
                $mandtr_from2 = strtotime(date("Y-m-01 00:00:00", $cday));       
                $mandtr_tdate = date("Y-m-15", $cday);       
                $mandtr_to = strtotime(date("Y-m-15 23:59:59", $cday));
                $mandtr_to2 = strtotime(date("Y-m-15 23:59:59", $cday));
            else :
                $mandtr_fdate = date("Y-m-16", $cday);       
                $mandtr_from = strtotime(date("Y-m-16 00:00:00", $cday));       
                $mandtr_from2 = strtotime(date("Y-m-16 00:00:00", $cday));       
                $mandtr_tdate = date("Y-m-t", $cday);       
                $mandtr_to = strtotime(date("Y-m-t 23:59:59", $cday));
                $mandtr_to2 = strtotime(date("Y-m-t 23:59:59", $cday));
            endif;       
        
            $mandtr_todate = date("Y-m-d", $cday);       
            $mandtr_today = strtotime(date("Y-m-d 23:59:59", $cday));

            if ($mandtr_from2 > $mandtr_to2) : 
                $dayn = 0;
            else : 
                $dayn = 0;
                while($mandtr_from2 <= $mandtr_to2) {
                    $dayn++;
                    $mandtr_from2 = strtotime("+1 day", $mandtr_from2);
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