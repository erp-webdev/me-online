<?php
	
	if ($logged == 1 && ($profile_level == 7 || $profile_level == 10 || $profile_idnum = '2015-05-0108')) {
		
		//*********************** MAIN CODE START **********************\\
			
		# ASSIGNED VALUE
		$page_title = "Birthday Card Management";	
		
		//***********************  MAIN CODE END  **********************\\
		
		global $sroot, $profile_id, $unix3month;

        // BIRTHDAY IMAGE
        if ($_POST['btncreatebimg'] || $_POST['btncreatebimg_x']) :
        
            /*if (!$_POST['bimg_message']) :
                echo '{"success": false, "required": true}';    
                exit();
            endif;*/
            
            $image1 = $_FILES['bimg_filename1']['tmp_name'];
            $filename1 = $_FILES['bimg_filename1']['name'];
            $filesize1 = $_FILES['bimg_filename1']['size'];
            $filetype1 = $_FILES['bimg_filename1']['type'];
        
            $image2 = $_FILES['bimg_filename2']['tmp_name'];
            $filename2 = $_FILES['bimg_filename2']['name'];
            $filesize2 = $_FILES['bimg_filename2']['size'];
            $filetype2 = $_FILES['bimg_filename2']['type'];
        
            $image3 = $_FILES['bimg_filename3']['tmp_name'];
            $filename3 = $_FILES['bimg_filename3']['name'];
            $filesize3 = $_FILES['bimg_filename3']['size'];
            $filetype3 = $_FILES['bimg_filename3']['type'];
            
            $allowedExts = array("JPG", "JPEG", "GIF", "PNG", "jpg", "jpeg", "gif", "png");
            $tempext1 = explode(".", $filename1);
            $extension1 = end($tempext1);
            $tempext2 = explode(".", $filename2);
            $extension2 = end($tempext2);
            $tempext3 = explode(".", $filename3);
            $extension3 = end($tempext3);

            if (($filesize1 < 10485760) && in_array($extension1, $allowedExts) && ($filesize2 < 10485760) && in_array($extension2, $allowedExts) && ($filesize3 < 10485760) && in_array($extension3, $allowedExts)) :
        
                $path = "uploads/birthday/";
        
                $newfilename1 = 'bday1'.date('U').'.'.$extension1;
                $target_path1 = $path.$newfilename1; 
                $filemove1 = move_uploaded_file($image1, $target_path1);
        
                $newfilename2 = 'bday2'.date('U').'.'.$extension2;
                $target_path2 = $path.$newfilename2; 
                $filemove2 = move_uploaded_file($image2, $target_path2);
        
                $newfilename3 = 'bday3'.date('U').'.'.$extension3;
                $target_path3 = $path.$newfilename3; 
                $filemove3 = move_uploaded_file($image3, $target_path3);
        
                $_POST['bimg_filename1'] = $newfilename1;
                $_POST['bimg_filename2'] = $newfilename2;
                $_POST['bimg_filename3'] = $newfilename3;
                $_POST['bimg_status'] = 1;
                $_POST['bimg_user'] = $profile_idnum;
                $_POST['bimg_date'] = date('U');
        
                if($filemove1 && $filemove2 && $filemove3) :
                    $del_bimg = $tblsql->bday_action($_POST, 'delete_all');	
                    $add_bimg = $tblsql->bday_action($_POST, 'add');			
                    if($add_bimg) : 
        
                        //AUDIT TRAIL
                        $post['EMPID'] = $profile_idnum;
                        $post['TASKS'] = "CREATE_BDAYIMG";
                        $post['DATA'] = $add_bimg;
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
        if ($_POST['btnsendbday'] || $_POST['btnsendbday_x']) :

            //SEND EMAIL
            $mailcount = 0;

            $bimgdata = $tblsql->get_bdayimg();
            $receivers = $tblsql->get_users_birthday(0, 0, NULL, 0);
            foreach ($receivers as $key => $value) :

                if(!$value['EmailAdd']){
                    $value['EmailAdd'] = $value['EmailAdd2'];
                }

                $message = "<div style='display: block; border: 5px solid #F00; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%; text-align: center;'><span style='font-size: 24px; color: #F00; font-weight: bold;'>".strtoupper($value['FullName'])."</span><br><br><img src='".WEB."/uploads/birthday/".$bimgdata[0]['bimg_filename']."' /><br><br><span style='font-size: 18px; color: #F00; font-weight: bold;'>".$bimgdata[0]['bimg_message']."</span>";

                $message .= "</div>";

                $headers = "From: noreply@alias.megaworldcorp.com\r\n";
                $headers .= "Reply-To: noreply@megaworldcorp.com\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                //DIRECT MAIL
                //$sendmail = mail($value['emp_corpemail'], "Megaworld HR Portal Memo", $message, $headers);                    
                //THRU DATABASE
                if ($value['EmailAdd']) :
                    if ($value['DBNAME'] == 'GL') :     
                        $appendmail = $mails->mail_cue('meonline-bday-noreply@alias.megaworldcorp.com', $value['EmailAdd'], "Happy Birthday to you!", $message, $headers);
                    else :
                        $appendmail = $mails->mail_cue('meonline-bday-noreply@alias.megaworldcorp.com', $value['EmailAdd'], "Happy Birthday to you!", $message, $headers);
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
            $post['TASKS'] = "SEND_BIRTHDAY";
            $post['DATA'] = "Everyone";
            $post['DATE'] = date("m/d/Y H:i:s.000");

            $log = $mainsql->log_action($post, 'add');

            echo '{"success": true, "rmailcount": "'.$mailcount.'", "status": "'.$appendmail.'"}';
            exit();
        endif;

        $bimg_data = $tblsql->get_bdayimg();

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>