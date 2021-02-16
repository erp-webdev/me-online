<?php

	if ($logged == 1 && in_array($profile_dbname, ['MEGAWORLD','MLI'])) {

		# PAGINATION
		$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
		$start = ACT_NUM_ROWS * ($page - 1);

		//*********************** MAIN CODE START **********************\\

		# ASSIGNED VALUE
		$page_title = "Forms";

		//***********************  MAIN CODE END  **********************\\

		global $sroot, $profile_id, $unix3month;

        $searchform_sess = $_SESSION['searchform'];
        if ($_POST['searchform']) {
            $searchform = $_POST['searchform'] ? $_POST['searchform'] : NULL;
            $_SESSION['searchform'] = $searchform;
        }
        elseif ($searchform_sess) {
            $searchform = $searchform_sess ? $searchform_sess : NULL;
            $_POST['searchform'] = $searchform != 0 ? $searchform : NULL;
        }
        else {
            $searchform = NULL;
            $_POST['searchform'] = NULL;
        }

        // ADD FORM
        if ($_POST['btncreateform'] || $_POST['btncreateform_x']) :

            $image = $_FILES['download_filename']['tmp_name'];
            $filename = $_FILES['download_filename']['name'];
            $filesize = $_FILES['download_filename']['size'];
            $filetype = $_FILES['download_filename']['type'];

            $allowedExts = array("JPG", "JPEG", "GIF", "PNG", "PDF", "jpg", "jpeg", "gif", "png", "pdf");
            $tempext = explode(".", $filename);
            $extension = end($tempext);

            //var_dump($filesize.' '.$extension);

            if (($filesize < 10485760) && in_array($extension, $allowedExts)) :

                $path = "uploads/download/";
                $target_path = $path.basename($filename);

                $filemove = move_uploaded_file($image, $target_path);

                $_POST['download_attach'] = NULL;
                $_POST['download_attachtype'] = $filetype;
                $_POST['download_filename'] = $filename;
                $_POST['download_pubdate'] = date('U');
                $_POST['download_status'] = 1;

                if($filemove) :
                    $add_form = $tblsql->form_action($_POST, 'add');
                    if($add_form) :
        
                        //AUDIT TRAIL
                        $post['EMPID'] = $profile_idnum;
                        $post['TASKS'] = "CREATE_FORM";
                        $post['DATA'] = $add_form;
                        $post['DATE'] = date("m/d/Y H:i:s.000");

                        $log = $mainsql->log_action($post, 'add');

                        echo '{"success": true}';
                        exit();
                    else :
                        echo '{"success": false, "fileerror": 1}';
                        exit();
                    endif;
                else :
                    echo '{"success": false, "fileerror": 2}';
                    exit();
                endif;

            else :
                echo '{"success": false, "fileerror":true}';
                exit();
            endif;
        endif;

        // EDIT FORM
        if ($_POST['btnupdateform'] || $_POST['btnupdateform_x']) :

            if ($_FILES['download_attach']["name"]) :

                $image = $_FILES['download_attach']['tmp_name'];
                $filename = $_FILES['download_attach']['name'];
                $filesize = $_FILES['download_attach']['size'];
                $filetype = $_FILES['download_attach']['type'];

                $allowedExts = array("JPG", "JPEG", "GIF", "PNG", "PDF", "jpg", "jpeg", "gif", "png", "pdf");
                $tempext = explode(".", $filename);
                $extension = end($tempext);

                if (($filesize < 10485760) && in_array($extension, $allowedExts)) :
                    $path = "uploads/download/";
                    $target_path = $path.basename($filename);

                    $filemove = move_uploaded_file($image, $target_path);

                    $_POST['download_filename'] = $filename;

                    $update_ads = $tblsql->form_action($_POST, 'update_attach', $_POST['download_id']);

                else :
                    echo '{"success": false, "fileerror": true}';
                    exit();
                endif;
            endif;

            $_POST['download_pubdate'] = date('U');

            $update_form = $tblsql->form_action($_POST, 'update', $_POST['download_id']);
            if($update_form) :

                //AUDIT TRAIL
                $post['EMPID'] = $profile_idnum;
                $post['TASKS'] = "UPDATE_FORM";
                $post['DATA'] = $_POST['download_id'];
                $post['DATE'] = date("m/d/Y H:i:s.000");

                $log = $mainsql->log_action($post, 'add');

                echo '{"success": true}';
                exit();
            else :
                echo '{"success": false}';
                exit();
            endif;

        endif;

        $form_cat = $tblsql->get_form(0, 0, 0, NULL, 0, NULL, 1);
        $form_count = $tblsql->get_form(0, 0, 0, NULL, 1, NULL, 0);

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}

?>
