<?php
	
	if ($logged == 1) {
        
        if ($np_app) :

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NUM_ROWS * ($page - 1);

            //*********************** MAIN CODE START **********************\\

            # ASSIGNED VALUE
            $page_title = "No Punching Authorization";	

            //***********************  MAIN CODE END  **********************\\

            global $sroot, $profile_id, $unix3month;

            // REGISTER NP
            if ($_POST['btnnpapply'] || $_POST['btnnpapply_x']) :
        
                //CHECK DATE IF ITS APPLIED - START
        
                $npastart = date("Y-m-d", strtotime($_POST['npa_date']));        
                $npaend = date("Y-m-d", strtotime($_POST['npa_date']));        
                
                $npaapplied = $mainsql->get_npadata_applied($profile_idnum, $npastart, $npaend);
                if ($npaapplied) :                        
                    echo '{"success": false, "error": "One of the date on NPA has been applied or approved "}';
                    exit();
                endif;
        
                //CHECK DATE IF ITS APPLIED - END

                $allowedExts = array("JPG", "JPEG", "GIF", "PNG", "PDF", "jpg", "jpeg", "gif", "png", "pdf");
        
                if (!$_FILES['attachment1']['name']) :
                    echo '{"success": false, "error": "Attachment is required on this application"}';
                    exit();                    
                endif;
        
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

                $nppost['EMPID'] = $_POST['empid'];
                $nppost['REQNBR'] = $_POST['reqnbr'];
                $nppost['TRANS'] = "APPLY";
                $nppost['ACTUALTIMEIN'] = $_POST['npa_atin'];
                $nppost['ACTUALTIMEOUT'] = $_POST['npa_atout'];
                $nppost['TIMEIN'] = $_POST['npa_in'];
                $nppost['TIMEOUT'] = $_POST['npa_out'];
                $nppost['DATEIN'] = $_POST['npa_din'];
                $nppost['DATEOUT'] = $_POST['npa_dout'];
                $nppost['REASON'] = $_POST['npa_reason'];
                $nppost['APPROVER01'] = $_POST['approver1'];
                $nppost['APPROVER02'] = $_POST['approver2'];
                $nppost['APPROVER03'] = $_POST['approver3'];
                $nppost['APPROVER04'] = $_POST['approver4'];
                $nppost['APPROVER05'] = $_POST['approver5'];
                $nppost['APPROVER06'] = $_POST['approver6'];
                $nppost['DBAPPROVER01'] = $_POST['dbapprover1'];
                $nppost['DBAPPROVER02'] = $_POST['dbapprover2'];
                $nppost['DBAPPROVER03'] = $_POST['dbapprover3'];
                $nppost['DBAPPROVER04'] = $_POST['dbapprover4'];
                $nppost['DBAPPROVER05'] = $_POST['dbapprover5'];
                $nppost['DBAPPROVER06'] = $_POST['dbapprover6'];
                $nppost['USER'] = $_POST['user'];
                $nppost['REMARKS'] = "";

                $add_np = $mainsql->np_action($nppost, 'add');			
                //var_dump($add_np);
                if($add_np) : 

                    for($i=1; $i<=5; $i++) :

                        if ($_FILES['attachment'.$i]['name']) :

                            $image = $_FILES['attachment'.$i]['tmp_name'];
                            $filename = $_FILES['attachment'.$i]['name'];
                            $filesize = $_FILES['attachment'.$i]['size'];
                            $filetype = $_FILES['attachment'.$i]['type'];

                            $tempext = explode(".", $filename);
                            $extension = end($tempext);

                            if (($filesize < 524288) && in_array($extension, $allowedExts)) :

                                $path = "uploads/np/";
                                $fixname = 'attach_'.$add_np.'_'.$i.'.'.$extension;
                                $target_path = $path.$fixname; 

                                $filemove = move_uploaded_file($image, $target_path);

                                $attach['attachfile'] = $fixname;
                                $attach['attachtype'] = $filetype;
                                $attach['reqnbr'] = $add_np;

                                if($filemove) :
                                    $add_attach = $mainsql->attach_action($attach, 'add');			
                                endif;
                            endif;

                        endif;

                    endfor;
        
                    $requestor = $register->get_member($_POST['empid']);
                    $request_info = $tblsql->get_mrequest(6, 0, 0, 0, $add_np, 0, NULL, NULL, NULL, NULL);
                    $approver = $logsql->get_allmember($_POST['approver1'], $_POST['dbapprover1']);
        
                    $reqemailblock = $mainsql->get_newemailblock($_POST['empid']);
                    $appemailblock = $mainsql->get_newemailblock($_POST['approver1']);

                    if ($reqemailblock) :

                        //SEND EMAIL (REQUESTOR)

                        $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New Non-Punching Authorization Request</span><br><br>Hi ".$requestor[0]['NickName'].",<br><br>";
                        $message .= "You opened a new request for non-punching authorization with Reference No: ".$add_np." on ".date('F j, Y')." and it's subject for approval. ";
                        $message .= "<br><br>Thanks,<br>";
                        $message .= SITENAME." Admin";
			            $message .= "<br>Click<a href='https://portal.megaworldcorp.com/me/login'> here</a> to login";
                        $message .= "<hr />".MAILFOOT."</div>";

                        $headers = "From: ".NOTIFICATION_EMAIL."\r\n";
                        $headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                        $sendmail = mail($requestor[0]['EmailAdd'], "New Non-Punching Authorization Request", $message, $headers); 
        
                    endif; 

                    if ($appemailblock) :             

                        //SEND EMAIL (APPROVER)

                        $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New Non-Punching Authorization Request from ".$requestor[0]['FName']." ".$requestor[0]['LName']."</span><br><br>Hi ".$approver[0]['NickName'].",<br><br>";
                        $message .= "New request ".$requestor[0]['FName']." ".$requestor[0]['LName']." for non-punching authorization with Reference No: ".$add_np." on ".date('F j, Y')." for your approval. ";
                        $message .= "<br><br>Thanks,<br>";
                        $message .= SITENAME." Admin";
			            $message .= "<br>Click<a href='https://portal.megaworldcorp.com/me/login'> here</a> to login";

                        $message .= "<hr />".MAILFOOT."</div>";

                        $headers = "From: ".NOTIFICATION_EMAIL."\r\n";
                        $headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                        $sendmail = mail($approver[0]['EmailAdd'], "New Non-Punching Authorization Request for your Approval", $message, $headers);   
        
                    endif;
        
                    //READ STATUS                    
                    if ($_POST['approver1'] && $add_np) :
                        $insert_read = $mainsql->insert_read($_POST['approver1'], $add_np);
                    endif;

                    //AUDIT TRAIL
                    $post['EMPID'] = $profile_idnum;
                    $post['TASKS'] = "CREATE_NPA";
                    $post['DATA'] = $add_np;
                    $post['DATE'] = date("m/d/Y H:i:s.000");

                    $log = $mainsql->log_action($post, 'add');

                    echo '{"success": true}';
                    exit();
                else :
                    echo '{"success": false, "error": "There was a problem on NPA application"}';
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