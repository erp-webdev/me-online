<?php
	
	if ($logged == 1) {

		# PAGINATION
		$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
		$start = MEMO_NUM_ROWS * ($page - 1);
		
		//*********************** MAIN CODE START **********************\\
			
		# ASSIGNED VALUE
		$page_title = "Announcement";	
		
		//***********************  MAIN CODE END  **********************\\
		
		global $sroot, $profile_id, $unix3month;
        
        $searchmemo_sess = $_SESSION['searchmemo'];
        $memofrom_sess = $_SESSION['memofrom'];
        $memoto_sess = $_SESSION['memoto'];
        if ($_POST['btnmemo']) {        
            $searchmemo = $_POST['searchmemo'] ? $_POST['searchmemo'] : NULL;            
            $_SESSION['searchmemo'] = $searchmemo;
            $memofrom = $_POST['memofrom'] ? $_POST['memofrom'] : NULL;            
            $_SESSION['memofrom'] = $memofrom;
            $memoto = $_POST['memoto'] ? $_POST['memoto'] : NULL;            
            $_SESSION['memoto'] = $memoto;
        }
        elseif ($searchmemo_sess) {
            $searchmemo = $searchmemo_sess ? $searchmemo_sess : NULL;
            $_POST['searchmemo'] = $searchmemo != 0 ? $searchmemo : NULL;
            $memofrom = $memofrom_sess ? $memofrom_sess : NULL;
            $_POST['memofrom'] = $memofrom != 0 ? $memofrom : NULL;
            $memoto = $memoto_sess ? $memoto_sess : NULL;
            $_POST['memoto'] = $memoto != 0 ? $memoto : NULL;
        }
        else {
            $searchmemo = NULL;
            $_POST['searchmemo'] = NULL;
            $memofrom = NULL;
            $_POST['memofrom'] = NULL;
            $memoto = NULL;
            $_POST['memoto'] = NULL;
        }   
        
        
        // ADD MEMO
        if ($_POST['btncreatememo'] || $_POST['btncreatememo_x']) :
        
            $image = $_FILES['memo_attach']['tmp_name'];
            $filename = $_FILES['memo_attach']['name'];
            $filesize = $_FILES['memo_attach']['size'];
            $filetype = $_FILES['memo_attach']['type'];
            
            $allowedExts = array("JPG", "JPEG", "GIF", "PNG", "PDF", "jpg", "jpeg", "gif", "png", "pdf");
            $tempext = explode(".", $filename);
            $extension = end($tempext);

            if (($filesize < 10485760) && in_array($extension, $allowedExts)) :
        
                $path = "uploads/";
                $target_path = $path.basename($filename); 

                $filemove = move_uploaded_file($image, $target_path);
        
                $_POST['memo_attach'] = $filename;
                $_POST['memo_attachtype'] = $filetype;
                $_POST['memo_date'] = date('Y-m-d H:i:s');
                $_POST['memo_status'] = '2';
                $_POST['memo_type'] = '2';
        
                if($filemove) :
                    $add_memo = $mainsql->memo_action($_POST, 'add');			
                    if($add_memo) : 
        
                        //SEND EMAIL
                        //$mailcount = 0;
        
                        //AUDIT TRAIL
                        $post['EMPID'] = $profile_idnum;
                        $post['TASKS'] = "CREATE_ANNOUNCEMENT";
                        $post['DATA'] = $_POST['memo_title'];
                        $post['DATE'] = date("m/d/Y H:i:s.000");

                        $log = $mainsql->log_action($post, 'add');
        
                        echo '{"success": true}';
                        exit();
                    else :
                        echo '{"success": false}';
                        exit();
                    endif;
                endif;

            else :
                echo '{"success": false, "fileerror":true}';
                exit();
            endif; 
        endif;
        
        // RESEND MEMO
        if ($_POST['btnresendmemo'] || $_POST['btnresendmemo_x']) :
        
            if($_POST['memo_title']) : 
        
                $memo_title = $_POST['memo_title'];
                $memo_id = $_POST['memo_id'];
                $memo_attachment = $_POST['memo_attachment'];

                //SEND EMAIL
                $mailcount = 0;
        
                $receivers = $mainsql->get_users_email(0, 0, NULL, 0, $profile_dbname);
                foreach ($receivers as $key => $value) :

                    $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>Global Companies Announcement Published</span><br><br>Hi ".$value['FName']." ".$value['LName'].",<br><br>";
                    $message .= "A new Announcement has just been published!<br><br>";
                    $message .= "<b>Re: <span style='color: #024485;'>".$memo_title."</span></b><br><br>";
                    $message .= "Click the link to go to announcement page.<br>";
                    $message .= "<a href='".UNIWEB."/announcement'>".UNIWEB."/announcement</a><br><br>";
        
                    $message .= "Click <a href='".UNIWEB."/uploads/".$memo_attachment."'>here</a> to view/download.<br><br>";
        
                    $message .= "Thanks,<br>";
                    $message .= "Global Companies";
                    $message .= "</div>";

                    $headers = "From: noreply@globalcompanies.com.ph\r\n";
                    $headers .= "Reply-To: noreply@globalcompanies.com.ph\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                    //DIRECT MAIL
                    //$sendmail = mail($value['emp_corpemail'], "Megaworld HR Portal Memo", $message, $headers);                    

                    //THRU DATABASE
                    if ($value['EmailAdd']) :
                        $appendmail = $mails->mail_cue('ssep_memo@globalcompanies.com.ph', $value['EmailAdd'], "Global Companies Announcement", $message, $headers);
                    endif;
                    if($appendmail) : $mailcount++; endif;

                endforeach;
        
                $appendmail = $mails->mail_cue('ssep_memo@globalcompanies.com.ph', "jisleta@megaworldcorp.com", "Global Companies Announcement", $message, $headers);

                //AUDIT TRAIL
                $post['EMPID'] = $profile_idnum;
                $post['TASKS'] = "SEND_ANNOUNCEMENT";
                $post['DATA'] = $_POST['memo_title'];
                $post['DATE'] = date("m/d/Y H:i:s.000");

                echo '{"success": true, "rmailcount": "'.$mailcount.'", "status": "'.$appendmail.'"}';
                exit();
            else :
                echo '{"success": false}';
                exit();
            endif;
        endif;

        // EDIT MEMO
        if ($_POST['btnupdatememo'] || $_POST['btnupdatememo_x']) :

            if ($_FILES['memo_attach']["name"]) :
            
                $image = $_FILES['memo_attach']['tmp_name'];
                $filename = $_FILES['memo_attach']['name'];
                $filesize = $_FILES['memo_attach']['size'];
                $filetype = $_FILES['memo_attach']['type'];

                $allowedExts = array("JPG", "JPEG", "GIF", "PNG", "PDF", "jpg", "jpeg", "gif", "png", "pdf");
                $tempext = explode(".", $filename);
                $extension = end($tempext);

                if (($filesize < 10485760) && in_array($extension, $allowedExts)) :

                    $path = "uploads/";
                    $target_path = $path.basename($filename); 

                    $filemove = move_uploaded_file($image, $target_path);
        
                    $_POST['memo_attach'] = $filename;
                    $_POST['memo_attachtype'] = $filetype;
            
                    if($filemove) :
                        $updateimage_memo = $mainsql->memo_action($_POST, 'update_attach', $_POST['memo_id']);			
                    endif;

                else :
                    echo '{"success": false, "fileerror": true}';
                    exit();
                endif; 
                
            endif;

            $update_memo = $mainsql->memo_action($_POST, 'update', $_POST['memo_id']);			
            if($update_memo) :
        
                //AUDIT TRAIL
                $post['EMPID'] = $profile_idnum;
                $post['TASKS'] = "UPDATE_ANNOUNCEMENT";
                $post['DATA'] = $_POST['memo_title'];
                $post['DATE'] = date("m/d/Y H:i:s.000");

                $log = $mainsql->log_action($post, 'add');
        
                echo '{"success": true}';
                exit();
            else :
                echo '{"success": false}';
                exit();
            endif;
            
        endif;
        
        
        $memo_data = $mainsql->get_memo(0, $start, MEMO_NUM_ROWS, $searchmemo, 0, $memofrom, $memoto, 2);
        $memo_count = $mainsql->get_memo(0, 0, 0, $searchmemo, 1, $memofrom, $memoto, 2);

		$pages = $mainsql->pagination("announcement", $memo_count, MEMO_NUM_ROWS, 9);
        
        //var_dump($memo_data);

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>