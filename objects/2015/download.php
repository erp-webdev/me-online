<?php
	
	if ($logged == 1) {

		# PAGINATION
		$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
		$start = ACT_NUM_ROWS * ($page - 1);
		
		//*********************** MAIN CODE START **********************\\
			
		# ASSIGNED VALUE
		$page_title = "Downloads";	
		
		//***********************  MAIN CODE END  **********************\\
		
		global $sroot, $profile_id, $unix3month;
        
        $searchdl_sess = $_SESSION['searchdl'];
        if ($_POST['btndl']) {        
            $searchdl = $_POST['searchdl'] ? $_POST['searchdl'] : NULL;            
            $_SESSION['searchdl'] = $searchdl;
        }
        elseif ($searchdl_sess) {
            $searchdl = $searchdl_sess ? $searchdl_sess : NULL;
            $_POST['searchdl'] = $searchdl != 0 ? $searchdl : NULL;
        }
        else {
            $searchdl = NULL;
            $_POST['searchdl'] = NULL;
        }  

        // ADD ACTIVITY
        if ($_POST['btncreatedownload'] || $_POST['btncreatedownload_x']) :
            
            $allowedExts = array("JPG", "JPEG", "GIF", "PNG", "jpg", "jpeg", "gif", "png", "pdf");
            $tempext = explode(".", $_FILES["download_image"]["name"]);
            $extension = end($tempext);
            $filesize = $_FILES['download_image']['size'];

            if (($filesize < 1048576) && in_array($extension, $allowedExts)) :

                $image = $_FILES['download_image']['tmp_name'];
                $fp = fopen($image, 'r');
                $content = fread($fp, filesize($image));
                $content = addslashes($content);
                fclose($fp);
    
                $actfile['filename'] = $_FILES['download_image']['name'];
                $actfile['filesize'] = $_FILES['download_image']['size'];
                $actfile['filetype'] = $_FILES['download_image']['type'];
                $actfile['filetemp'] = $content;
        
                if($actfile['filename']) :
                    $add_download = $mainsql->download_action($_POST, $actfile, 'add');			
                    //var_dump($add_download);
                    if($add_download) : 
        
                        $adtype = $_POST['download_ads'] == 1 ? "Ad" : "Activity";
                        
                        //SEND EMAIL
                        $mailcount = 0;
        
                        //AUDIT TRAIL
                        $log = $mainsql->log_action("ADD_ACTIVITY", $add_download, $profile_id);
        
                        echo '{"success":true, "mailcount": "'.$mailcount.'"}';
                        exit();
                    else :
                        echo '{"success": false, "dberror": true}';
                        exit();
                    endif;
                endif;

            else :
                echo '{"success": false, "fileerror": true}';
                exit();
            endif; 
        endif;

        // EDIT ACTIVITY
        if ($_POST['btnupdateads'] || $_POST['btnupdateads_x']) :

            if ($_FILES['download_image']["name"]) :
            
                $allowedExts = array("JPG", "JPEG", "GIF", "PNG", "jpg", "jpeg", "gif", "png");
                $tempext = explode(".", $_FILES["download_image"]["name"]);
                $extension = end($tempext);
                $filesize = $_FILES['download_image']['size'];
    
                if (($filesize < 1048576) && in_array($extension, $allowedExts)) :
            
                    $image = $_FILES['download_image']['tmp_name'];
                    $fp = fopen($image, 'r');
                    $content = fread($fp, filesize($image));
                    $content = addslashes($content);
                    fclose($fp);
        
                    $actfile['filename'] = $_FILES['download_image']['name'];
                    $actfile['filesize'] = $_FILES['download_image']['size'];
                    $actfile['filetype'] = $_FILES['download_image']['type'];
                    $actfile['filetemp'] = $content;
            
                    if($actfile['filename']) :
                        $updateimage_download = $mainsql->download_action(NULL, $actfile, 'update_image', $_POST['download_id']);			
                    endif;

                else :
                    echo '{"success": false, "fileerror": true}';
                    exit();
                endif; 
                
            endif;

            $update_ads = $mainsql->download_action($_POST, NULL, 'update', $_POST['download_id']);			
            if($update_ads) : 
        
                //AUDIT TRAIL
                $log = $mainsql->log_action("UPDATE_ADS", $_POST['download_id'], $profile_id); 
        
                echo '{"success": true}';
                exit();
            else :
                echo '{"success": false}';
                exit();
            endif;
            
        endif;
        
        $download_cat = $tblsql->get_download(0, 0, 0, NULL, 0, 0, 1);
        $download_count = $tblsql->get_download(0, 0, 0, NULL, 1, 0, 0);

		$pages = $mainsql->pagination("ads", $ads_count, ACT_NUM_ROWS, 9);

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>