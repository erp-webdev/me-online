<?php
	
	if ($logged == 1 && $profile_dbname != 'ECINEMA' && $profile_dbname != 'EPARKVIEW' && $profile_dbname != 'NEWTOWN' && $profile_dbname != 'LAFUERZA') {

		# PAGINATION
		$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
		$start = MEMO_NUM_ROWS * ($page - 1);
		
		//*********************** MAIN CODE START **********************\\
			
		# ASSIGNED VALUE
		$page_title = "Memorandum";	
		
		//***********************  MAIN CODE END  **********************\\
		
		global $sroot, $profile_id, $unix3month;
        
        $searchmemo_sess = $_SESSION['searchmemo'];
        $memofrom_sess = $_SESSION['memofrom'];
        $memoto_sess = $_SESSION['memoto'];
        if ($_POST['searchmemo'] || $_POST['memofrom'] || $_POST['memoto']) {        
            $searchmemo = $_POST['searchmemo'] ? $_POST['searchmemo'] : NULL;            
            $_SESSION['searchmemo'] = $searchmemo;
            $memofrom = $_POST['memofrom'] ? $_POST['memofrom'] : NULL;            
            $_SESSION['memofrom'] = $memofrom;
            $memoto = $_POST['memoto'] ? $_POST['memoto'] : NULL;            
            $_SESSION['memoto'] = $memoto;
        }
        elseif ($searchmemo_sess || $memofrom_sess || $memoto_sess) {
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
        
                $path = "uploads/memo/";
                $newfilename = 'memo'.date('U').'.'.$extension;
                $target_path = $path.$newfilename; 

                $filemove = move_uploaded_file($image, $target_path);
                        
                $_POST['announce_title'] = $_POST['memo_title']; 
                $_POST['announce_date'] = strtotime($_POST['memo_date']); 
                //$_POST['announce_attach'] = NULL;
                $_POST['announce_attachtype'] = $filetype;
                $_POST['announce_path'] = NULL;
                $_POST['announce_filename'] = $newfilename;
                $_POST['announce_flag'] = 1;
                $_POST['announce_receiver'] = 1;
                $_POST['announce_user'] = $_POST['memo_user']; 
                $_POST['announce_pubdate'] = date('U'); 
                $_POST['announce_status'] = 1;
                $_POST['announce_db'] = $profile_dbname;
        
                if($filemove) :
                    $add_memo = $tblsql->memo_action($_POST, 'add');
                    //var_dump($add_memo);
                    if($add_memo) : 
        
                        //AUDIT TRAIL
                        $post['EMPID'] = $profile_idnum;
                        $post['TASKS'] = "CREATE_MEMO";
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
        
        // SEND MEMO
        if ($_POST['btnresendmemo'] || $_POST['btnresendmemo_x']) :
        
            if($_POST['memo_title']) : 
        
                $memo_title = $_POST['memo_title'];
                $memo_id = $_POST['memo_id'];
                $memo_filename = $_POST['memo_filename'];
                $memo_db = $_POST['memo_db'];

                //SEND EMAIL
                $mailcount = 0;
        
                if ($memo_db) :
                    $receivers = $tblsql->get_users_bulkmail(0, 0, NULL, 0, $memo_db);
                    foreach ($receivers as $key => $value) :

                        $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New ".($memo_db == 'GL' ? 'Global Companies' : 'Megaworld Corporation')." Memo Published</span><br><br>Hi ".$value['FullName'].",<br><br>";
                        $message .= "A new memo has just been published!<br><br>";
                        $message .= "<b>Re: <span style='color: #024485;'>".$memo_title."</span></b><br><br>";
                        $message .= "Click the link to go to memos page.<br>";
                        $message .= "<a href='".UNIWEB."/memo'>".UNIWEB."/memo</a><br><br>";
                        if ($memo_filename) :
                        $message .= "Click <a href='".UNIWEB."/uploads/memo/".$memo_filename."'>here</a> to view/download.<br><br>";
                        endif;

                        if ($memo_db == 'GL') :        
                            $message .= "Thanks,<br>";
                            $message .= "ME Online - Global Companies";
                            $message .= "</div>";

                            $headers = "From: noreply@globalcompanies.com.ph\r\n";
                            $headers .= "Reply-To: noreply@globalcompanies.com.ph\r\n";
                        else :
                            $message .= "Thanks,<br>";
                            $message .= "ME Online - Megaworld Corporation";
                            $message .= "</div>";

                            $headers = "From: meonline-memo-noreply@megaworldcorp.com\r\n";
                            $headers .= "Reply-To: noreply@megaworldcorp.com\r\n";        
                        endif;

                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                        //DIRECT MAIL
                        //$sendmail = mail($value['emp_corpemail'], "Megaworld HR Portal Memo", $message, $headers);                    
                        //THRU DATABASE
                        if ($value['EmailAdd']) :
                            if ($memo_db == 'GL') :     
                                $appendmail = $mails->mail_cue('meonline-memo-noreply@megaworldcorp.com', $value['EmailAdd'], "ME Online Memo", $message, $headers);
                            else :
                                $appendmail = $mails->mail_cue('meonline-memo-noreply@megaworldcorp.com', $value['EmailAdd'], "ME Online Memo", $message, $headers);
                            endif;
                        endif;
                        if($appendmail) : 
                            $mailcount++; 
                        endif;

                    endforeach;
        
                    //$mailcount++;
                    //$appendmail = $mails->mail_cue('meonline_memo@megaworldcorp.com', "jisleta@megaworldcorp.com", "ME Online Memo", $message, $headers);

                    //AUDIT TRAIL
                    $post['EMPID'] = $profile_idnum;
                    $post['TASKS'] = "SEND_MEMO";
                    $post['DATA'] = $_POST['memo_title'];
                    $post['DATE'] = date("m/d/Y H:i:s.000");

                    $log = $mainsql->log_action($post, 'add');

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

                    $path = "uploads/memo/";
                    $newfilename = 'memo'.date('U').'.'.$extension;
                    $target_path = $path.$newfilename; 

                    $filemove = move_uploaded_file($image, $target_path);
        
                    $_POST['announce_filename'] = $newfilename;
            
                    if($filemove) :
                        $updateimage_memo = $tblsql->memo_action($_POST, 'update_attach', $_POST['memo_id']);			
                    endif;

                else :
                    echo '{"success": false, "fileerror": true}';
                    exit();
                endif; 
                
            endif;
        
            $_POST['announce_title'] = $_POST['memo_title']; 
            $_POST['announce_date'] = strtotime($_POST['memo_date']); 
            $_POST['announce_user'] = $_POST['memo_user']; 

            $update_memo = $tblsql->memo_action($_POST, 'update', $_POST['memo_id']);			
            if($update_memo) :
        
                //AUDIT TRAIL
                $post['EMPID'] = $profile_idnum;
                $post['TASKS'] = "UPDATE_MEMO";
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

        $memo_data = $tblsql->get_memos(0, $start, MEMO_NUM_ROWS, $searchmemo, 0, strtotime($memofrom), strtotime($memoto), $profile_dbname);
        $memo_count = $tblsql->get_memos(0, 0, 0, $searchmemo, 1, strtotime($memofrom), strtotime($memoto), $profile_dbname);        

		$pages = $mainsql->pagination("memo", $memo_count, MEMO_NUM_ROWS, 9);
        
        //var_dump($memo_data);

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>