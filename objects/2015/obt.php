<?php
	
	if ($logged == 1) {
        
        if ($ob_app) :

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NUM_ROWS * ($page - 1);

            //*********************** MAIN CODE START **********************\\

            # ASSIGNED VALUE
            $page_title = "Official Business Trip Application";	

            //***********************  MAIN CODE END  **********************\\

            global $sroot, $profile_id, $unix3month;

            // REGISTER OB
            if ($_POST['btnobapply'] || $_POST['btnobapply_x']) :
        
                $obtitemcount = count($_POST['obt_date']);
        
                //CHECK IF DATE AND TIME OVERLAP
        
                $overlap = 0;
                for ($i=1; $i<=($obtitemcount - 1); $i++) :
                    $outob = strtotime($_POST['obt_dateout'][$i].' '.$_POST['obt_timeout'][$i]);
                    $inob = strtotime($_POST['obt_date'][($i + 1)].' '.$_POST['obt_timein'][($i + 1)]);
                    
                    if ($outob > $inob) :
                        $overlap++;
                    endif;
                endfor;
        
                if ($overlap) :                        
                    echo '{"success": false, "error": "You provide an overlap date in your application"}';
                    exit();
                endif;
        
                //CHECK FOR INVALID DATE/TIME IN AND OUT
        
                $invalidcnt = 0;
        
                foreach ($_POST['obt_hours'] as $kh => $vh) :
                    if ($vh < 0) :
                        $invalidcnt++;
                    endif;
                endforeach;  
        
                if ($invalidcnt) :                        
                    echo '{"success": false, "error": "One of the date on OBT is invalid where your time-in is greater than your time-out"}';
                    exit();
                endif;
                
                //CHECK DATE IF ITS APPLIED - START
        
                $obtstart = date("Y-m-d", strtotime($_POST['obt_from']));        
                $obtend = date("Y-m-d", strtotime($_POST['obt_to']));        
                
                $getobtapplied = $mainsql->get_obtdata_applied($profile_idnum, $obtstart, $obtend);
                if ($getobtapplied) :                        
                    echo '{"success": false, "error": "One of the date on OBT has been applied or approved "}';
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
        
                //OBT ITEMS
                $mail_details = '';

                $err_item = 0;
        
                $cnti = 1;

                while($cnti <= $obtitemcount) :

                    if ($cnti == 1) :
                        $obitempost['REQNBR'] = 0;
                    else : 
                        $obitempost['REQNBR'] = $add_obitem;
                    endif;
                    $obitempost['OBTIMEINDATE'] = $_POST['obt_date'][$cnti].' '.$_POST['obt_timein'][$cnti];
                    $obitempost['OBTIMEOUTDATE'] = $_POST['obt_dateout'][$cnti].' '.$_POST['obt_timeout'][$cnti];
                    $obitempost['ACTUALTIMEINDATE'] = $_POST['obt_actfrom'][$cnti];
                    $obitempost['ACTUALTIMEOUTDATE'] = $_POST['obt_actto'][$cnti];
                    
                    $add_obitem = $mainsql->ob_action($obitempost, 'add_item');		

                    if ($add_obitem) :
                        $mail_details .= "<tr><td>".date('M j g:ia', strtotime($_POST['obt_date'][$cnti].' '.$_POST['obt_timein'][$cnti]))."</td><td>".date('M j g:ia', strtotime($_POST['obt_dateout'][$cnti].' '.$_POST['obt_timeout'][$cnti]))."</td></tr>";
                        $cnti++;
                    endif;

                endwhile;

                $obpost['EMPID'] = $_POST['empid'];
                $obpost['REQNBR'] = $add_obitem;
                $obpost['TRANS'] = "APPLY";
                $obpost['OBTIMEINDATE'] = $_POST['obt_from'];
                $obpost['OBTIMEOUTDATE'] = $_POST['obt_to'];
                $obpost['DAYS'] = $_POST['ndays'];
                $obpost['DESTINATION'] = addslashes($_POST['obt_destination']);
                $obpost['REASON'] = addslashes($_POST['obt_purpose']);
                $obpost['APPROVER01'] = $_POST['approver1'];
                $obpost['APPROVER02'] = $_POST['approver2'];
                $obpost['APPROVER03'] = $_POST['approver3'];
                $obpost['APPROVER04'] = $_POST['approver4'];
                $obpost['APPROVER05'] = $_POST['approver5'];
                $obpost['APPROVER06'] = $_POST['approver6'];
                $obpost['DBAPPROVER01'] = $_POST['dbapprover1'];
                $obpost['DBAPPROVER02'] = $_POST['dbapprover2'];
                $obpost['DBAPPROVER03'] = $_POST['dbapprover3'];
                $obpost['DBAPPROVER04'] = $_POST['dbapprover4'];
                $obpost['DBAPPROVER05'] = $_POST['dbapprover5'];
                $obpost['DBAPPROVER06'] = $_POST['dbapprover6'];
                $obpost['USER'] = $_POST['user'];
                $obpost['REMARKS'] = "";

                $add_ob = $mainsql->ob_action($obpost, 'add');			
                if($add_ob) : 

                    for($i=1; $i<=5; $i++) :

                        if ($_FILES['attachment'.$i]['name']) :

                            $image = $_FILES['attachment'.$i]['tmp_name'];
                            $filename = $_FILES['attachment'.$i]['name'];
                            $filesize = $_FILES['attachment'.$i]['size'];
                            $filetype = $_FILES['attachment'.$i]['type'];

                            $tempext = explode(".", $filename);
                            $extension = end($tempext);

                            if (($filesize < 10485760) && in_array($extension, $allowedExts)) :

                                $path = "uploads/ob/";
                                $fixname = 'attach_'.$add_ob.'_'.$i.'.'.$extension;
                                $target_path = $path.$fixname; 

                                $filemove = move_uploaded_file($image, $target_path);

                                $attach['attachfile'] = $fixname;
                                $attach['attachtype'] = $filetype;
                                $attach['reqnbr'] = $add_ob;

                                if($filemove) :
                                    $add_attach = $mainsql->attach_action($attach, 'add');			
                                endif;

                            endif;

                        endif;

                    endfor;  
        
                    $requestor = $register->get_member($_POST['empid']);
                    $request_info = $tblsql->get_mrequest(4, 0, 0, 0, $add_ob, 0, NULL, NULL, NULL, NULL);
                    $approver = $logsql->get_allmember($_POST['approver1'], $_POST['dbapprover1']);
        
                    $reqemailblock = $mainsql->get_newemailblock($_POST['empid']);
                    $appemailblock = $mainsql->get_newemailblock($_POST['approver1']);

                    if ($reqemailblock) :

                        //SEND EMAIL (REQUESTOR)

                        $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New Official Business Trip Request</span><br><br>Hi ".$requestor[0]['NickName'].",<br><br>";
                        $message .= "You opened a new request for official business trip with Reference No: ".$add_ob." on ".date('F j, Y')." and it's subject for approval. ";
                        $message .= "<br><br><table border='1' cellpadding='3' cellspacing='0' style='border: 1px solid #666; font-size: 12px; font-family: Verdana;'>";
                        $message .= "<tr><td style='background-color: #024485; color: #FFF; text-align: center'><b>In</b></td><td style='background-color: #024485; color: #FFF; text-align: center'><b>Out</b></td></tr>";
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

                        $sendmail = mail($requestor[0]['EmailAdd'], "New Official Business Trip Request", $message, $headers);   
        
                    endif; 

                    if ($appemailblock) :           

                        //SEND EMAIL (APPROVER)

                        $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New Official Business Trip Request from ".$requestor[0]['FName']." ".$requestor[0]['LName']."</span><br><br>Hi ".$approver[0]['NickName'].",<br><br>";
                        $message .= "New request ".$requestor[0]['FName']." ".$requestor[0]['LName']." for official business trip with Reference No: ".$add_ob." on ".date('F j, Y')." for your approval. ";
                        $message .= "<br><br>Thanks,<br>";
                        $message .= SITENAME." Admin";
			$message .= "<br>Click<a href='https://portal.megaworldcorp.com/me/login'> here</a> to login";

                        $message .= "<hr />".MAILFOOT."</div>";

                        $headers = "From: ".NOTIFICATION_EMAIL."\r\n";
                        $headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                        $sendmail = mail($approver[0]['EmailAdd'], "New Official Business Trip Request for your Approval", $message, $headers);   
        
                    endif;
        
                    //READ STATUS                    
                    if ($_POST['approver1'] && $add_ob) :
                        $insert_read = $mainsql->insert_read($_POST['approver1'], $add_ob);
                    endif;

                    //AUDIT TRAIL
                    $post['EMPID'] = $profile_idnum;
                    $post['TASKS'] = "CREATE_OBT";
                    $post['DATA'] = $add_ob;
                    $post['DATE'] = date("m/d/Y H:i:s.000");

                    $log = $mainsql->log_action($post, 'add');
        
                    if ($err_item) :
                        echo '{"success": false, "error": "One or more of OBT item hasn\'t been process due network problem. Please forward email notification with its request ID."}';
                        exit();        
                    else :
                        echo '{"success": true}';
                        exit();
                    endif;
                else :
                    echo '{"success": false, "error": "There was a problem on OBT application"}';
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