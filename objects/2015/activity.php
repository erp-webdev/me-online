<?php
	
	if ($logged == 1 && $profile_dbname != 'ECINEMA' && $profile_dbname != 'EPARKVIEW' && $profile_dbname != 'NEWTOWN' && $profile_dbname != 'LAFUERZA') {

		# PAGINATION
		$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
		$start = ACT_NUM_ROWS * ($page - 1);
		
		//*********************** MAIN CODE START **********************\\
			
		# ASSIGNED VALUE
		$page_title = "Activities";	
		
		//***********************  MAIN CODE END  **********************\\
		
		global $sroot, $profile_id, $unix3month;
        
        $searchactivity_sess = $_SESSION['searchactivity'];
        if ($_POST['btnactivity']) {        
            $searchactivity = $_POST['searchactivity'] ? $_POST['searchactivity'] : NULL;            
            $_SESSION['searchactivity'] = $searchactivity;
        }
        elseif ($searchactivity_sess) {
            $searchactivity = $searchactivity_sess ? $searchactivity_sess : NULL;
            $_POST['searchactivity'] = $searchactivity != 0 ? $searchactivity : NULL;
        }
        else {
            $searchactivity = NULL;
            $_POST['searchactivity'] = NULL;
        }   
        
        // REGISTER ACTIVITY
        if ($_POST['btnregsub'] || $_POST['btnregsub_x']) :
            $activity_data = $tblsql->get_activities($_POST['registry_activityid']);
        
            $count_registry = 0;
            $cnt_registered = $tblsql->cnt_registered($_POST['registry_activityid']);
            
            if ($activity_data[0]['activity_type'] == 1) :
                $count_registry = count($cnt_registered); 
                foreach ($cnt_registered as $k => $v) :
                    $count_registry = $count_registry + $v['numgue'];
                endforeach; 
            elseif ($activity_data[0]['activity_type'] == 3) :
                $count_registry = count($cnt_registered); 
                foreach ($cnt_registered as $k => $v) :
                    $count_registry = $count_registry + $v['numindi'];
                endforeach; 
            elseif ($activity_data[0]['activity_type'] == 5) :
                foreach ($cnt_registered as $k => $v) :
                    $count_registry = $count_registry + $v['numchi'];
                endforeach; 
            elseif ($activity_data[0]['activity_type'] == 6) :
                $count_registry = count($cnt_registered); 
                foreach ($cnt_registered as $k => $v) :
                    $count_registry = $count_registry + $v['numindi'];
                    $count_registry = $count_registry + $v['numgue'];
                endforeach; 
            else :
                $count_registry = count($cnt_registered); 
            endif;
        
            $slot_remain = $activity_data[0]['activity_slots'] - $count_registry;
        
            if ($slot_remain > 0) :
        
                $approver = $tblsql->get_employee_byid($lv_app[1][1], 0, 0, 0, $lv_app[1][2]);
        
                if($_POST['registry_approve'] && $approver[0]['EmailAdd']) :
                    $_POST['registry_status'] = 1;
                else :
                    $_POST['registry_status'] = 2;
                endif;

                $reg_details = '';
                if ($activity_data[0]['activity_type'] == 1) :
                    for ($c = 0; $c < $_POST['numgue']; $c++) :
                        $comma = ($c != 0 ? ', ' : '');
                        $reg_details .= $comma.str_replace(',', '', $_POST['registry_gname'][$c]);     
                    endfor;
                elseif ($activity_data[0]['activity_type'] == 3 || $activity_data[0]['activity_type'] == 6) :
                    for ($c = 0; $c < $_POST['numindi']; $c++) :
                        $comma = ($c != 0 ? ', ' : '');
                        $reg_details .= $comma.str_replace(',', '', $_POST['registry_dname'][$c]);     
                    endfor;
                elseif ($activity_data[0]['activity_type'] == 5) :
                    for ($c = 0; $c < $_POST['numchi']; $c++) :
                        $comma = ($c != 0 ? ', ' : '');
                        $reg_details .= $comma.str_replace(',', '', $_POST['registry_cname'][$c]).' ('.str_replace(',', '', $_POST['registry_cage'][$c]).'-'.str_replace(',', '', $_POST['registry_crel'][$c]).')';        
                    endfor;
                else :
                    $reg_details = NULL;
                endif;
        
                $_POST['registry_offidnum'] = NULL;
                $_POST['registry_offname'] = NULL;
                $_POST['registry_offcomp'] = 0;
                $_POST['registry_offpos'] = NULL;  
        
                $_POST['registry_godirectly'] = $_POST['registry_godirectly'] ? 1 : 0;
                $_POST['registry_vrin'] = $_POST['registry_vrin'] ? 1 : 0;
                $_POST['registry_vrout'] = $_POST['registry_vrout'] ? 1 : 0;
                $_POST['registry_details'] = $reg_details; 
                $_POST['registry_platenum'] = $_POST['registry_platenum'] ? $_POST['registry_platenum'] : NULL;
                $_POST['registry_child'] = $_POST['numchi'] ? $_POST['numchi'] : 0;
                $_POST['registry_dependent'] = $_POST['numindi'] ? $_POST['numindi'] : 0;
                $_POST['registry_guest'] = $_POST['numgue'] ? $_POST['numgue'] : 0;
                $_POST['registry_date'] = date('U');
                $_POST['registry_dateattend'] = 0;
                $_POST['registry_approver'] = $approver[0]['EmailAdd'] ? $lv_app[1][1] : NULL;
                $_POST['registry_auto'] = 0;
                $_POST['registry_offsite'] = 0;

                $reg_activity = $tblsql->register_action($_POST, 'add');			
                if($reg_activity) : 

                    //SEND EMAIL
                    $registrator = $tblsql->get_employee_byid($_POST['registry_uid'], 0, 0, 0, $profile_dbname);
                    $activity_info = $tblsql->get_activities($_POST['registry_activityid']);

                    $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>ME Online '".$activity_info[0]['activity_title']."' Registration</span><br><br>Hi ".$registrator[0]['FName'].",<br><br>";
                    $message .= "You have successfully registered on ".$activity_info[0]['activity_title'].".<br><br>";
                    $message .= "<b>Confirmation Code: </b> ".$activity_info[0]['activity_id']."-".substr($_POST['registry_uid'], -4).$_POST['registry_date'].". ".($_POST['registry_approve'] && $approver[0]['EmailAdd']) ? '<i>this number will activate upon approved</i>' : '';
                    if ($_POST['registry_approve'] && $approver[0]['EmailAdd']) : $message .= "Please wait for your immediate head's approval."; endif;
                    $message .= "<br><br>Thanks,<br>";
                    $message .= "ME Online Admin";
                    $message .= "<hr />".MAILFOOT."</div>";

                    $headers = "From: meonline-act-noreply@alias.megaworldcorp.com\r\n";
                    $headers .= "Reply-To: noreply@megaworldcorp.com\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                    $sendmail = mail($registrator[0]['EmailAdd'], "Megaworld ME Online Activity Registration", $message, $headers);       

                    if ($approver[0]['EmailAdd'] && $_POST['registry_approve']) :

                        $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>ME Online '".$activity_info[0]['activity_title']."' Registration's Approval</span><br><br>Hi ".($approver[0]['FName'] ? $approver[0]['FName'] : $approver[0]['FName']).",<br><br>";
                        $message .= $registrator[0]['FName']." ".$registrator[0]['LName']." have registered on ".$activity_info[0]['activity_title']." and subject for approval.<br><br>"; 
                        $message .= "Click the link to go to activity approve page.<br>";
                        $message .= "<a href='".UNIWEB."/unapprove_register'>".UNIWEB."/unapprove_register</a><br><br>";
                        $message .= "Thanks,<br>";
                        $message .= "ME Online Admin";
                        $message .= "<hr />".MAILFOOT."</div>";

                        $headers = "From: meonline-act-noreply@alias.megaworldcorp.com\r\n";
                        $headers .= "Reply-To: noreply@megaworldcorp.com\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                        $sendmail = mail($approver[0]['EmailAdd'], "Megaworld ME Online Activity Approval", $message, $headers);  
                    endif;

                    //AUDIT TRAIL
                    $post['EMPID'] = $profile_idnum;
                    $post['TASKS'] = "REG_ACTIVITY";
                    $post['DATA'] = $reg_activity;
                    $post['DATE'] = date("m/d/Y H:i:s.000");

                    $log = $mainsql->log_action($post, 'add');

                    echo '{"success": true, "details": "'.$reg_details.'"}';
                    exit();
                else :
                    echo '{"success": false}';
                    exit();
                endif;
        
            else :
                echo '{"success": false, "details": "not available"}';
                exit();        
            endif;
        
        endif;

        // ADD ACTIVITY
        if ($_POST['btncreateact'] || $_POST['btncreateact_x']) :
            
            $image = $_FILES['activity_attach']['tmp_name'];
            $filename = $_FILES['activity_attach']['name'];
            $filesize = $_FILES['activity_attach']['size'];
            $filetype = $_FILES['activity_attach']['type'];
            
            $allowedExts = array("JPG", "JPEG", "GIF", "PNG", "PDF", "jpg", "jpeg", "gif", "png");
            $tempext = explode(".", $filename);
            $extension = end($tempext);

            if (($filesize < 10485760) && in_array($extension, $allowedExts)) :
        
                $path = "uploads/activity/";
                $newfilename = 'activity'.date('U').'.'.$extension;
                $target_path = $path.$newfilename; 

                $filemove = move_uploaded_file($image, $target_path);
        
                $_POST['activity_datestart'] = strtotime($_POST['activity_dates'].' '.$_POST['activity_timein']); 
                $_POST['activity_dateend'] = strtotime($_POST['activity_dates'].' '.$_POST['activity_timeout']);
                $_POST['activity_approve'] = $_POST['activity_approve'] ? 1 : 0;
                $_POST['activity_cvehicle'] = $_POST['activity_cvehicle'] ? 1 : 0;
                $_POST['activity_guest'] = $_POST['activity_guest'] ? 1 : 0;
                $_POST['activity_dependent'] = $_POST['activity_dependent'] ? 1 : 0;
                $_POST['activity_feedback'] = $_POST['activity_feedback'] ? 1 : 0;
                $_POST['activity_offsite'] = $_POST['activity_offsite'] ? 1 : 0;
                $_POST['activity_hours'] = $_POST['activity_hours'];
                $_POST['activity_ads'] = 0; 
                $_POST['activity_endregister'] = $_POST['activity_endregister'] ? 1 : 0;
                $_POST['activity_backout'] = $_POST['activity_backout'] ? 1 : 0;
                $_POST['activity_filename'] = $newfilename;
                $_POST['activity_status'] = 1;
                $_POST['activity_date'] = date('U'); 
                $_POST['activity_db'] = $profile_dbname;
        
                if($filemove) :
                    $add_act = $tblsql->activity_action($_POST, 'add');			
                    if($add_act) : 
        
                        //AUDIT TRAIL
                        $post['EMPID'] = $profile_idnum;
                        $post['TASKS'] = "CREATE_ACTIVITY";
                        $post['DATA'] = $add_act;
                        $post['DATE'] = date("m/d/Y H:i:s.000");

                        $log = $mainsql->log_action($post, 'add');
        
                        echo '{"success": true}';
                        exit();
                    else :
                        echo '{"success": false}';
                        exit();
                    endif;
                else :
                    echo '{"success": false}';
                    exit();
                endif;

            else :
                echo '{"success": false, "fileerror":true}';
                exit();
            endif;  
        endif;
        
        // SEND ADS
        if ($_POST['btnresendact'] || $_POST['btnresendact_x']) :
        
            if($_POST['activity_title']) : 
        
                $activity_title = $_POST['activity_title'];
                $activity_id = $_POST['activity_id'];
                $activity_filename = $_POST['activity_filename'];
                $activity_db = $_POST['activity_db'];

                //SEND EMAIL
                $mailcount = 0;
        
                $receivers = $tblsql->get_users_bulkmail(0, 0, NULL, 0, $activity_db);
                foreach ($receivers as $key => $value) :

                    $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New ".($activity_db == 'GL' ? 'Global Companies' : 'Megaworld Corporation')." Activity Published</span><br><br>Hi ".$value['FullName'].",<br><br>";
                    $message .= "A new activity has just been published!<br><br>";
                    $message .= "<b>Re: <span style='color: #024485;'>".$activity_title."</span></b><br><br>";
                    $message .= "Click the link to go to activity page.<br>";
                    $message .= "<a href='".UNIWEB."/activity'>".UNIWEB."/activity</a><br><br>";
                    if ($activity_filename) :
                    $message .= "Click <a href='".UNIWEB."/uploads/activity/".$activity_filename."'>here</a> to view/download.<br><br>";
                    endif;
        
                    if ($activity_db == 'GL') :        
                        $message .= "Thanks,<br>";
                        $message .= "ME Online - Global Companies";
                        $message .= "</div>";

                        $headers = "From: noreply@globalcompanies.com.ph\r\n";
                        $headers .= "Reply-To: noreply@globalcompanies.com.ph\r\n";
                        $headers .= "Reply-To: noreply@globalcompanies.com.ph\r\n";
                    else :
                        $message .= "Thanks,<br>";
                        $message .= "ME Online - Megaworld Corporation";
                        $message .= "</div>";

                        $headers = "From: meonline-act-noreply@alias.megaworldcorp.com\r\n";
                        $headers .= "Reply-To: noreply@megaworldcorp.com\r\n";        
                    endif;
        
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                    //DIRECT MAIL
                    //$sendmail = mail($value['emp_corpemail'], "Megaworld HR Portal Memo", $message, $headers);                    
                    //THRU DATABASE
                    if ($value['EmailAdd']) :
                        if ($activity_db == 'GL') :     
                            $appendmail = $mails->mail_cue('meonline-act-noreply@alias.megaworldcorp.com', $value['EmailAdd'], "ME Online Activity", $message, $headers);
                        else :
                            $appendmail = $mails->mail_cue('meonline-act-noreply@alias.megaworldcorp.com', $value['EmailAdd'], "ME Online Activity", $message, $headers);
                        endif;
                    endif;
                    if($appendmail) : 
                        $mailcount++; 
                    endif;

                endforeach;
        
                //$mailcount++;
                //$appendmail = $mails->mail_cue('meonline_activity@megaworldcorp.com', "jisleta@megaworldcorp.com", "ME Online Activity", $message, $headers);

                //AUDIT TRAIL
                $post['EMPID'] = $profile_idnum;
                $post['TASKS'] = "SEND_ACTIVITY";
                $post['DATA'] = $_POST['activity_title'];
                $post['DATE'] = date("m/d/Y H:i:s.000");
        
                $log = $mainsql->log_action($post, 'add');

                echo '{"success": true, "rmailcount": "'.$mailcount.'", "status": "'.$appendmail.'"}';
                exit();
            else :
                echo '{"success": false}';
                exit();
            endif;
        endif;

        // EDIT ACTIVITY
        if ($_POST['btnupdateact'] || $_POST['btnupdateact_x']) :
        
            if ($_FILES['activity_attach']["name"]) :
        
                $image = $_FILES['activity_attach']['tmp_name'];
                $filename = $_FILES['activity_attach']['name'];
                $filesize = $_FILES['activity_attach']['size'];
                $filetype = $_FILES['activity_attach']['type'];

                $allowedExts = array("JPG", "JPEG", "GIF", "PNG", "PDF", "jpg", "jpeg", "gif", "png");
                $tempext = explode(".", $filename);
                $extension = end($tempext);

                if (($filesize < 10485760) && in_array($extension, $allowedExts)) :

                    $path = "uploads/activity/";
                    $newfilename = 'activity'.date('U').'.'.$extension;
                    $target_path = $path.$newfilename; 

                    $filemove = move_uploaded_file($image, $target_path);

                    $_POST['activity_filename'] = $newfilename;

                    $update_act = $tblsql->activity_action($_POST, 'update_attach', $_POST['activity_id']);

                else :
                    echo '{"success": false, "fileerror": true}';
                    exit();                
                endif;              
            endif;
            
            $_POST['activity_datestart'] = strtotime($_POST['activity_dates'].' '.$_POST['activity_timein']); 
            $_POST['activity_dateend'] = strtotime($_POST['activity_dates'].' '.$_POST['activity_timeout']);
            $_POST['activity_approve'] = $_POST['activity_approve'] ? 1 : 0;
            $_POST['activity_cvehicle'] = $_POST['activity_cvehicle'] ? 1 : 0;
            $_POST['activity_guest'] = $_POST['activity_guest'] ? 1 : 0;
            $_POST['activity_dependent'] = $_POST['activity_dependent'] ? 1 : 0;
            $_POST['activity_feedback'] = $_POST['activity_feedback'] ? 1 : 0;
            $_POST['activity_offsite'] = $_POST['activity_offsite'] ? 1 : 0;
            $_POST['activity_hours'] = $_POST['activity_hours'];
            $_POST['activity_ads'] = 0;  
            $_POST['activity_endregister'] = $_POST['activity_endregister'] ? 1 : 0;
            $_POST['activity_backout'] = $_POST['activity_backout'] ? 1 : 0;
            $_POST['activity_date'] = date('U'); 

            $update_act = $tblsql->activity_action($_POST, 'update', $_POST['activity_id']);			
            if($update_act) : 
        
                //AUDIT TRAIL
                $post['EMPID'] = $profile_idnum;
                $post['TASKS'] = "UPDATE_ACTIVITY";
                $post['DATA'] = $_POST['activity_id'];
                $post['DATE'] = date("m/d/Y H:i:s.000");

                $log = $mainsql->log_action($post, 'add');
        
                echo '{"success": true}';
                exit();
            else :
                echo '{"success": false}';
                exit();
            endif;
            
        endif;

        $activity_data = $tblsql->get_activities(0, $start, ACT_NUM_ROWS, $searchactivity, 0, 0, 1, 1, 0, $profile_dbname);
        $activity_count = $tblsql->get_activities(0, 0, 0, $searchactivity, 1, 0, 1, 1, 0, $profile_dbname);        

		$pages = $mainsql->pagination("activity", $activity_count, ACT_NUM_ROWS, 9);
        
        $staff_count = $tblsql->get_staff(0, 0, 1, $profile_idnum);

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>