<?php
	
	if ($logged == 1 && $profile_dbname != 'ECINEMA' && $profile_dbname != 'EPARKVIEW' && $profile_dbname != 'NEWTOWN' && $profile_dbname != 'LAFUERZA') :

		# PAGINATION
		$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
		$start = ACT_NUM_ROWS * ($page - 1);
		
		//*********************** MAIN CODE START **********************\\
			
		# ASSIGNED VALUE
		$page_title = "Ads";	
		
		//***********************  MAIN CODE END  **********************\\
		
		global $sroot, $profile_id, $unix3month;
        
        $searchads_sess = $_SESSION['searchads'];
        if ($_POST['btnads']) {        
            $searchads = $_POST['searchads'] ? $_POST['searchads'] : NULL;            
            $_SESSION['searchads'] = $searchads;
        }
        elseif ($searchads_sess) {
            $searchads = $searchads_sess ? $searchads_sess : NULL;
            $_POST['searchads'] = $searchads != 0 ? $searchads : NULL;
        }
        else {
            $searchads = NULL;
            $_POST['searchads'] = NULL;
        }  

        // ADD ACTIVITY
        if ($_POST['btncreateads'] || $_POST['btncreateads_x']) :
            
            $image = $_FILES['activity_attach']['tmp_name'];
            $filename = $_FILES['activity_attach']['name'];
            $filesize = $_FILES['activity_attach']['size'];
            $filetype = $_FILES['activity_attach']['type'];
            
            $allowedExts = array("JPG", "JPEG", "GIF", "PNG", "PDF", "jpg", "jpeg", "gif", "png", "pdf");
            $tempext = explode(".", $filename);
            $extension = end($tempext);

            if (in_array($extension, $allowedExts)) :
            // if (($filesize < 35485760) && in_array($extension, $allowedExts)) :
        
                $path = "uploads/ads/";
                $newfilename = 'ads'.date('U').'.'.$extension;
                $target_path = $path.$newfilename; 

                $filemove = move_uploaded_file($image, $target_path);
        
                $_POST['activity_type'] = 0;
                $_POST['activity_venue'] = NULL; 
                $_POST['activity_description'] = NULL; 
                $_POST['activity_datestart'] = strtotime('2037-01-01 12:00am'); 
                $_POST['activity_dateend'] = strtotime('2037-01-01 12:00am'); 
                $_POST['activity_approve'] = 0;
                $_POST['activity_cvehicle'] = 0;
                $_POST['activity_guest'] = 0;
                $_POST['activity_dependent'] = 0;
                $_POST['activity_feedback'] = 0;
                $_POST['activity_offsite'] = 0;
                $_POST['activity_hours'] = 0;
                $_POST['activity_ads'] = 1;
                $_POST['activity_slots'] = 0;
                $_POST['activity_filename'] = $newfilename;
                $_POST['activity_endregister'] = 0;
                $_POST['activity_backout'] = 0;
                $_POST['activity_status'] = 1;
                $_POST['activity_date'] = strtotime($_POST['activity_date']); 
                $_POST['activity_db'] = $profile_dbname;
        
                if($filemove) :
                    $add_ad = $tblsql->ads_action($_POST, 'add');			
                    if($add_ad) : 
        
                        //AUDIT TRAIL
                        $post['EMPID'] = $profile_idnum;
                        $post['TASKS'] = "CREATE_ADS";
                        $post['DATA'] = $add_ad;
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
        if ($_POST['btnresendads'] || $_POST['btnresendads_x']) :
        
            if($_POST['activity_title']) : 
        
                $activity_title = $_POST['activity_title'];
                $activity_id = $_POST['activity_id'];
                $activity_filename = $_POST['activity_filename'];
                $activity_db = $_POST['activity_db'];

                //SEND EMAIL
                $mailcount = 0;

                if ($activity_db) :
        
                    $receivers = $tblsql->get_users_bulkmail(0, 0, NULL, 0, $activity_db);
                    foreach ($receivers as $key => $value) :

                        $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New ".($activity_db == 'GL' ? 'Global Companies' : 'Megaworld Corporation')." Ad Published</span><br><br>Hi ".$value['FullName'].",<br><br>";
                        $message .= "A new ad has just been published!<br><br>";
                        $message .= "<b>Re: <span style='color: #024485;'>".$activity_title."</span></b><br><br>";
                        $message .= "Click the link to go to ads page.<br>";
                        $message .= "<a href='".UNIWEB."/ads'>".UNIWEB."/ads</a><br><br>";
                        if ($activity_filename) :
                        $message .= '<img src="'.UNIWEB."/uploads/ads/".$activity_filename.'" alt="$activity_title" height="400px"> <br><br>';
                        $message .= "Click <a href='".UNIWEB."/uploads/ads/".$activity_filename."'>here</a> to view/download.<br><br>";
                        endif;

                        if ($memo_db == 'GL') :        
                            $message .= "Thanks,<br>";
                            $message .= "ME Online - Global Companies";
                            $message .= "</div>";

                            $headers = "From: noreply@alias.megaworldcorp.com\r\n";
                            $headers .= "Reply-To: noreply@globalcompanies.com.ph\r\n";
                        else :
                            $message .= "Thanks,<br>";
                            $message .= "ME Online - Megaworld Corporation";
                            $message .= "</div>";

                            $headers = "From: meonline-ads-noreply@alias.megaworldcorp.com\r\n";
                            $headers .= "Reply-To: noreply@megaworldcorp.com\r\n";        
                        endif;

                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                        //DIRECT MAIL
                        //$sendmail = mail($value['emp_corpemail'], "Megaworld HR Portal Memo", $message, $headers);                    
                        //THRU DATABASE
                        if ($value['EmailAdd']) :
                            if ($memo_db == 'GL') :     
                                $appendmail = $mails->mail_cue('noreply@alias.megaworldcorp.com', $value['EmailAdd'], $activity_title, $message, $headers);
                            else :
                                $appendmail = $mails->mail_cue('noreply@alias.megaworldcorp.com', $value['EmailAdd'], $activity_title, $message, $headers);
                            endif;
                        endif;
                        if($appendmail) : 
                            $mailcount++; 
                        endif;

                    endforeach;

                    //$mailcount++;
                    //$appendmail = $mails->mail_cue('meonline_ads@megaworldcorp.com', "jisleta@megaworldcorp.com", "ME Online Ads", $message, $headers);

                    //AUDIT TRAIL
                    $post['EMPID'] = $profile_idnum;
                    $post['TASKS'] = "SEND_AD";
                    $post['DATA'] = $_POST['activity_title'];
                    $post['DATE'] = date("m/d/Y H:i:s.000");

                    echo '{"success": true, "rmailcount": "'.$mailcount.'", "status": "'.$appendmail.'"}';
                    exit();
                else :
                    echo '{"success": false}';
                    exit();
                endif;
            else :
                echo '{"success": false}';
                exit();
            endif;
        endif;

        // EDIT ADS
        if ($_POST['btnupdateads'] || $_POST['btnupdateads_x']) :
        
            if ($_FILES['activity_attach']["name"]) :
        
                $image = $_FILES['activity_attach']['tmp_name'];
                $filename = $_FILES['activity_attach']['name'];
                $filesize = $_FILES['activity_attach']['size'];
                $filetype = $_FILES['activity_attach']['type'];

                $allowedExts = array("JPG", "JPEG", "GIF", "PNG", "PDF", "jpg", "jpeg", "gif", "png", "pdf");
                $tempext = explode(".", $filename);
                $extension = end($tempext);

                if (($filesize < 10485760) && in_array($extension, $allowedExts)) :

                    $path = "uploads/ads/";
                    $newfilename = 'ads'.date('U').'.'.$extension;
                    $target_path = $path.$newfilename; 

                    $filemove = move_uploaded_file($image, $target_path);

                    $_POST['activity_filename'] = $newfilename;

                    $update_ads = $tblsql->ads_action($_POST, 'update_attach', $_POST['activity_id']);

                else :
                    echo '{"success": false, "fileerror": true}';
                    exit();                
                endif;              
            endif;
            
            $_POST['activity_date'] = strtotime($_POST['activity_date']); 

            $update_ads = $tblsql->ads_action($_POST, 'update', $_POST['activity_id']);			
            if($update_ads) : 
        
                //AUDIT TRAIL
                $post['EMPID'] = $profile_idnum;
                $post['TASKS'] = "UPDATE_ADS";
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

        $ads_data = $tblsql->get_activities(0, $start, ACT_NUM_ROWS, $searchads, 0, 0, 1, 2, 0, $profile_dbname);
        $ads_count = $tblsql->get_activities(0, 0, 0, $searchads, 1, 0, 1, 2, 0, $profile_dbname);        

		$pages = $mainsql->pagination("ads", $ads_count, ACT_NUM_ROWS, 9);

	else :
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	endif;
	
?>