<?php
	
	if ($logged == 1) {
        
        if ($ot_app) :

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NUM_ROWS * ($page - 1);

            //*********************** MAIN CODE START **********************\\

            # ASSIGNED VALUE
            $page_title = "Overtime Application";	

            //***********************  MAIN CODE END  **********************\\

            global $sroot, $profile_id, $unix3month;


            // REGISTER OT
            if ($_POST['btnotapply'] || $_POST['btnotapply_x']) :
        
                //CHECK DATE IF ITS APPLIED - START
        
                $otstart = date("Y-m-d H:i:s", strtotime($_POST['ot_from']));        
                $otend = date("Y-m-d H:i:s", strtotime($_POST['ot_to']));        
                
                $otapplied = $mainsql->get_otdata_applied($profile_idnum, $otstart, $otend);
                if ($otapplied) :                        
                    $otapplied2 = $mainsql->get_otdata_applieddata($profile_idnum, $otstart, $otend);
                    echo '{"success": false, "error": "One of the date on overtime has been applied or approved. Please check reference # '.$otapplied2[0]['ReqNbr'].'"}';
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

                $otpost['EMPID'] = $_POST['empid'];
                $otpost['REQNBR'] = $_POST['reqnbr'];
                $otpost['TRANS'] = "APPLY";
                $otpost['APLYHRS'] = $_POST['txtothours'];
                $otpost['APPROVEDHRS'] = 0;
                $otpost['FROMDATE'] = $_POST['ot_from'];
                $otpost['TODATE'] = $_POST['ot_to'];
                $otpost['DTRDATE'] = $_POST['ot_date'];
                $otpost['REASON'] = addslashes($_POST['ot_reason']);
                $otpost['OTTYPE'] = $_POST['ot_type'];
                $otpost['APPROVER01'] = $_POST['approver1'];
                $otpost['APPROVER02'] = $_POST['approver2'];
                $otpost['APPROVER03'] = $_POST['approver3'];
                $otpost['APPROVER04'] = $_POST['approver4'];
                $otpost['APPROVER05'] = $_POST['approver5'];
                $otpost['APPROVER06'] = $_POST['approver6'];
                $otpost['DBAPPROVER01'] = $_POST['dbapprover1'];
                $otpost['DBAPPROVER02'] = $_POST['dbapprover2'];
                $otpost['DBAPPROVER03'] = $_POST['dbapprover3'];
                $otpost['DBAPPROVER04'] = $_POST['dbapprover4'];
                $otpost['DBAPPROVER05'] = $_POST['dbapprover5'];
                $otpost['DBAPPROVER06'] = $_POST['dbapprover6'];
                $otpost['USER'] = $_POST['user'];
                $otpost['REMARKS'] = "";

                $add_ot = $mainsql->ot_action($otpost, 'add');			
                if($add_ot) :

                    for($i=1; $i<=5; $i++) :

                        if ($_FILES['attachment'.$i]['name']) :

                            $image = $_FILES['attachment'.$i]['tmp_name'];
                            $filename = $_FILES['attachment'.$i]['name'];
                            $filesize = $_FILES['attachment'.$i]['size'];
                            $filetype = $_FILES['attachment'.$i]['type'];

                            $tempext = explode(".", $filename);
                            $extension = end($tempext);

                            if (($filesize < 10485760) && in_array($extension, $allowedExts)) :

                                $path = "uploads/ot/";
                                $fixname = 'attach_'.$add_ot.'_'.$i.'.'.$extension;
                                $target_path = $path.$fixname; 

                                $filemove = move_uploaded_file($image, $target_path);

                                $attach['attachfile'] = $fixname;
                                $attach['attachtype'] = $filetype;
                                $attach['reqnbr'] = $add_ot;

                                if($filemove) :
                                    $add_attach = $mainsql->attach_action($attach, 'add');			
                                endif;

                            endif;

                        endif;

                    endfor; 
        
                    $requestor = $register->get_member($_POST['empid']);
                    $request_info = $tblsql->get_mrequest(1, 0, 0, 0, $add_ot, 0, NULL, NULL, NULL, NULL);
                    $approver = $logsql->get_allmember($_POST['approver1'], $_POST['dbapprover1']);
                    //$approver = $register->get_member($_POST['approver1']);
        
                    $reqemailblock = $mainsql->get_newemailblock($_POST['empid']);
                    $appemailblock = $mainsql->get_newemailblock($_POST['approver1']);

                    if ($reqemailblock) :

                        //SEND EMAIL (REQUESTOR)

                        $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New Overtime Request</span><br><br>Hi ".$requestor[0]['NickName'].",<br><br>";
                        $message .= "You opened a new request for overtime with Reference No: ".$add_ot." on ".date('F j, Y')." and it's subject for approval. ";
                        $message .= "<br><br>Thanks,<br>";
                        $message .= SITENAME." Admin";
			$message .= "<br>Click<a href='https://portal.megaworldcorp.com/me/login'> here</a> to login";
			$message .= "<hr />".MAILFOOT."</div>";

                        $headers = "From: ".NOTIFICATION_EMAIL."\r\n";
                        $headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                        $sendmail = mail($requestor[0]['EmailAdd'], "New Overtime Request", $message, $headers);   
        
                    endif; 

                    if ($appemailblock) :           

                        //SEND EMAIL (APPROVER)

                        $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New Overtime Request from ".$requestor[0]['FName']." ".$requestor[0]['LName']."</span><br><br>Hi ".$approver[0]['NickName'].",<br><br>";
                        $message .= "New request ".$requestor[0]['FName']." ".$requestor[0]['LName']." for overtime with Reference No: ".$add_ot." on ".date('F j, Y')." for your approval. ";
                        $message .= "<br><br>Thanks,<br>";
                        $message .= SITENAME." Admin";
			$message .= "<br>Click<a href='https://portal.megaworldcorp.com/me/login'> here</a> to login";

                        $message .= "<hr />".MAILFOOT."</div>";

                        $headers = "From: ".NOTIFICATION_EMAIL."\r\n";
                        $headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                        $sendmail = mail($approver[0]['EmailAdd'], "New Overtime Request for your Approval", $message, $headers);   
        
                    endif;
        
                    //READ STATUS                    
                    if ($_POST['approver1'] && $add_ot) :
                        $insert_read = $mainsql->insert_read($_POST['approver1'], $add_ot);
                    endif;

                    //AUDIT TRAIL
                    $post['EMPID'] = $profile_idnum;
                    $post['TASKS'] = "CREATE_OT";
                    $post['DATA'] = $add_ot;
                    $post['DATE'] = date("m/d/Y H:i:s.000");

                    $log = $mainsql->log_action($post, 'add');

                    echo '{"success": true}';
                    exit();
                else :
                    echo '{"success": false, "error": "There was a problem on OT application"}';
                    exit();
                endif; 

            endif;


            $odate = date("Y-m-d");     
            $otype = "Reg OT PM";       

            // this is for holiday checking
            $monthnum = date("n", strtotime($odate));
            $daynum = date("j", strtotime($odate));

            $shiftsched = $mainsql->get_schedshift($profile_idnum);
            $dtr_data = $mainsql->get_dtr_bydate($profile_idnum, $odate);  

            $vdates = date("Y-m-d", strtotime($odate));
            $udates = date("U", strtotime($odate));
            $dates = date("M j", strtotime($odate));
            $days = date("D", strtotime($odate));
            $numdays = intval(date("N", strtotime($odate)));
            
            $shiftsched2 = $mainsql->get_schedshiftdtr($profile_idnum, $odate);        
            $sft2 = $shiftsched2[0]['ShiftID'];
            
            $thisholiday = $mainsql->get_holiday(1, $monthnum, $daynum, $profile_location);

            //var_dump($dtr_data);
            
            if (!$sft2 || $thisholiday) : $holirest = 1;
            else : $holirest = 0; endif;
            
            $dtrin = $dtr_data[0]['TimeIN'];
            $dtrout = $dtr_data[0]['TimeOut'];
            
            $dtrtimein = $dtrin ? date('g:ia', strtotime($dtrin)) : 'NOT SET';
            $dtrtimeout = $dtrout ? date('g:ia', strtotime($dtrout)) : 'NOT SET';
            
            $dtr_text = $dtr_data ? $dtrtimein.' - '.$dtrtimeout : '';
            
            $chkdtrin = $dtrin ? date('g:ia', strtotime($dtrin)) : 0;
            $chkdtrout = $dtrout ? date('g:ia', strtotime($dtrout)) : 0;
            
            $otdtr = $sft2 ? $dtr_text : 'REST DAY';
        
            $otimein = $shiftsched2[0]['CreditTimeIN'];
            $otimeout = $shiftsched2[0]['CreditTimeOut'];
            $dtimein = $dtr_data[0]['TimeIN'];
            $dtimeout = $dtr_data[0]['TimeOut'];   

            $otin = $vdates.' '.date('h:ia', strtotime($otimeout));
            $vdates2 = date("Y-m-d", strtotime($odate));
            $otout = $vdates2.' '.date('h:ia', strtotime($dtimeout ? $dtimeout : $otimeout));

            $sft = $mainsql->get_shift($shiftsched2[0]['ShiftID']);
            
            $otshift = $shiftsched2[0]['ShiftID'] ? $sft[0]['ShiftDesc'] : 'REST DAY';

            $in = strtotime($otin);
            $out = strtotime($otout);

            if ($in > $out) :
                $otdate = date("Y-m-d", strtotime($odate) + 86400);
            else :
                $otdate = $odate;
            endif;

            $hin = strtotime($odate.' '.date("g:ia", $in));
            $hout = strtotime($otdate.' '.date("g:ia", $out));

            $hours = floor((($hout - $hin) / 3600) * 2) / 2;

            if ($holirest == 2 || $holirest == 3) :
                if ($hours > 8) :
                    $hours = $hours - 1;
                endif;            
            endif;
            
            $othours = $hours < 1 ? 0 : floor($hours * 2) / 2;
        
        else :
        
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."'</script>";
        
        endif;

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>