<?php
	
	if ($logged == 1) {
        
        //if ($lu_app) :

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NUM_ROWS * ($page - 1);

            //*********************** MAIN CODE START **********************\\

            # ASSIGNED VALUE
            $page_title = "Late Undertime Application";	

            //***********************  MAIN CODE END  **********************\\

            global $sroot, $profile_id, $unix3month;


            // REGISTER LU
            if ($_POST['btnluapply'] || $_POST['btnluapply_x']) :
        
                //CHECK DATE IF ITS APPLIED - START
        
                $lustart = date("Y-m-d", strtotime($_POST['lu_date']));        
                $luend = date("Y-m-d", strtotime($_POST['lu_date']));        
                
                $luapplied = $tblsql->get_ludata_applied($profile_idnum, $lustart, $luend);
                if ($luapplied) :                        
                    echo '{"success": false, "error": "No offset application for this date has been applied nor approved "}';
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

                $lupost['EMPID'] = $_POST['empid'];
                $lupost['REQNBR'] = $_POST['reqnbr'];
                $lupost['TRANS'] = "APPLY";
                $lupost['APLYHRS'] = $_POST['txtluhours'];
                $lupost['DTRDATE'] = $_POST['lu_date'];
                $lupost['LUTYPE'] = $_POST['lu_type'];
                $lupost['APPROVER01'] = $_POST['approver1'];
                $lupost['APPROVER02'] = $_POST['approver2'];
                $lupost['APPROVER03'] = $_POST['approver3'];
                $lupost['APPROVER04'] = $_POST['approver4'];
                $lupost['APPROVER05'] = $_POST['approver5'];
                $lupost['APPROVER06'] = $_POST['approver6'];
                $lupost['DBAPPROVER01'] = $_POST['dbapprover1'];
                $lupost['DBAPPROVER02'] = $_POST['dbapprover2'];
                $lupost['DBAPPROVER03'] = $_POST['dbapprover3'];
                $lupost['DBAPPROVER04'] = $_POST['dbapprover4'];
                $lupost['DBAPPROVER05'] = $_POST['dbapprover5'];
                $lupost['DBAPPROVER06'] = $_POST['dbapprover6'];
                $lupost['USER'] = $_POST['user'];
                $lupost['REMARKS'] = "";

                $add_lu = $mainsql->lu_action($lupost, 'add');			
                if($add_lu) :

                    for($i=1; $i<=5; $i++) :

                        if ($_FILES['attachment'.$i]['name']) :

                            $image = $_FILES['attachment'.$i]['tmp_name'];
                            $filename = $_FILES['attachment'.$i]['name'];
                            $filesize = $_FILES['attachment'.$i]['size'];
                            $filetype = $_FILES['attachment'.$i]['type'];

                            $tempext = explode(".", $filename);
                            $extension = end($tempext);

                            if (($filesize < 10485760) && in_array($extension, $allowedExts)) :

                                $path = "uploads/lu/";
                                $target_path = $path.basename($filename); 

                                $filemove = move_uploaded_file($image, $target_path);

                                $attach['attachfile'] = $filename;
                                $attach['attachtype'] = $filetype;
                                $attach['reqnbr'] = $add_lu;

                                if($filemove) :
                                    $add_attach = $mainsql->attach_action($attach, 'add');			
                                endif;

                            endif;

                        endif;

                    endfor; 
        
                    $requestor = $register->get_member($_POST['empid']);
                    $request_info = $tblsql->get_mrequest(1, 0, 0, 0, $add_lu, 0, NULL, NULL, NULL, NULL);
                    $approver = $register->get_member($_POST['approver1']);
        
                    $reqemailblock = $mainsql->get_newemailblock($_POST['empid']);
                    $appemailblock = $mainsql->get_newemailblock($_POST['approver1']);

                    if ($reqemailblock) :

                        //SEND EMAIL (REQUESTOR)

                        $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New Offset Request</span><br><br>Hi ".$requestor[0]['NickName'].",<br><br>";
                        $message .= "You opened a new request for offset with Reference No: ".$add_lu." on ".date('F j, Y')." and it's subject for approval. ";
                        $message .= "<br><br>Thanks,<br>";
                        $message .= SITENAME." Admin";
                        $message .= "<hr />".MAILFOOT."</div>";

                        $headers = "From: ".NOTIFICATION_EMAIL."\r\n";
                        $headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                        $sendmail = mail($requestor[0]['EmailAdd'], "New Offset Request", $message, $headers);   
        
                    endif; 

                    if ($appemailblock) :           

                        //SEND EMAIL (APPROVER)

                        $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New Offest Request from ".$requestor[0]['FName']." ".$requestor[0]['LName']."</span><br><br>Hi ".$approver[0]['NickName'].",<br><br>";
                        $message .= "New request ".$requestor[0]['FName']." ".$requestor[0]['LName']." for overtime with Reference No: ".$add_lu." on ".date('F j, Y')." for your approval. ";
                        $message .= "<br><br>Thanks,<br>";
                        $message .= SITENAME." Admin";
                        $message .= "<hr />".MAILFOOT."</div>";

                        $headers = "From: ".NOTIFICATION_EMAIL."\r\n";
                        $headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                        $sendmail = mail($approver[0]['EmailAdd'], "New Offset Request for your Approval", $message, $headers);   
        
                    endif;
        
                    //READ STATUS                    
                    if ($_POST['approver1'] && $add_lu) :
                        $insert_read = $mainsql->insert_read($_POST['approver1'], $add_lu);
                    endif;

                    //AUDIT TRAIL
                    $post['EMPID'] = $profile_idnum;
                    $post['TASKS'] = "CREATE_LU";
                    $post['DATA'] = $add_lu;
                    $post['DATE'] = date("m/d/Y H:i:s.000");

                    $log = $mainsql->log_action($post, 'add');

                    echo '{"success": true}';
                    exit();
                else :
                    echo '{"success": false, "error": "There was a problem on late undertime application"}';
                    exit();
                endif; 

            endif;


            $odate = date("Y-m-d", strtotime("-1 day"));     
            $ydate = date("Y-m-d", strtotime("-2 day"));     

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

            //var_dump($odate);
            
            $dtrin = $dtr_data[0]['TimeIN'];
            $dtrout = $dtr_data[0]['TimeOut'];
            
            $dtrtimein = $dtrin ? date('g:ia', strtotime($dtrin)) : 'NOT SET';
            $dtrtimeout = $dtrout ? date('g:ia', strtotime($dtrout)) : 'NOT SET';
            
            $dtr_text = $dtr_data ? $dtrtimein.' - '.$dtrtimeout : '';
            
            $chkdtrin = $dtrin ? date('g:ia', strtotime($dtrin)) : 0;
            $chkdtrout = $dtrout ? date('g:ia', strtotime($dtrout)) : 0;
            
            $ludtr = $sft2 ? $dtr_text : 'REST DAY';
        
            $otimein = $shiftsched2[0]['CreditTimeIN'];
            $otimeout = $shiftsched2[0]['CreditTimeOut'];
            $dtimein = $dtr_data[0]['TimeIN'];
            $dtimeout = $dtr_data[0]['TimeOut'];   
        
            $ot_app = $mainsql->get_otdata_bydate($profile_idnum, $ydate);
            $ovhours = $ot_app ? $ot_app[0]['ApprovedHrs'] : 0;

            $luin = $vdates.' '.date('h:ia', strtotime($otimeout));
            $vdates2 = date("Y-m-d", strtotime($odate));
            $luout = $vdates2.' '.date('h:ia', strtotime($dtimeout ? $dtimeout : $otimeout));

            $sft = $mainsql->get_shift($shiftsched2[0]['ShiftID']);
            
            $lushift = $shiftsched2[0]['ShiftID'] ? $sft[0]['ShiftDesc'] : 'REST DAY';

            $in = strtotime($luin);
            $out = strtotime($luout);

            if ($in > $out) :
                $ludate = date("Y-m-d", strtotime($odate) + 86400);
            else :
                $ludate = $odate;
            endif;

            $hin = strtotime($odate.' '.date("g:ia", $in));
            $hout = strtotime($ludate.' '.date("g:ia", $out));

            $hours = floor((($hout - $hin) / 3600) * 2) / 2;

            if ($holirest == 2 || $holirest == 3) :
                if ($hours > 8) :
                    $hours = $hours - 1;
                endif;            
            endif;
            
            $luhours = $hours < 1 ? 0 : floor($hours * 2) / 2;
        
        /*else :
        
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."'</script>";
        
        endif;*/

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>