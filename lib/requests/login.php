<?php	

    include("../../config.php");

    extract($_POST);

    if ($admin) :

        $expire = time() + 60;
        $_SESSION['megassep_admin'] = 'admin';
        $_SESSION['ssep_comp'] = NULL;

        $success = $_SESSION['megasubs_admin'];

    else :

        $cookiename = 'megasubs_user';

        $checkfmem = $logsql->check_member($username, $password);
        $getmem = $logsql->get_member2($username, $password);
        
        if ($checkfmem == 1)
        {
            if($getmem[0]['DBNAME'] != 'MARKETING'){
                if ($chkmem[0]['PasswordHash']) {
                    $success = (password_verify($oldpass, $chkmem[0]['PasswordHash'])) ? 1 : 0;
                }
                else {
                    $chkmem = $logsql->check_member($username, $password);    
                    if($chkmem){
                        $success=1;
                    }
                }
                if($success==1){
                    $expire = time() + 60;
                    $_SESSION[$cookiename] = $username;
                    //$_SESSION['ssep_comp'] = $company;
                    $_SESSION['ssep_comp'] = $getmem[0]['CompanyID'];
                    $_SESSION['megasubs_password'] =$getmem[0]['EPassword'];
                    $_SESSION['megasubs_db'] = $getmem[0]['DBNAME'];
        
                    //AUDIT TRAIL
                    $post['EMPID'] = $username;
                    $post['TASKS'] = "LOGIN";
                    $post['DATA'] = $username;
                    $post['DATE'] = date("m/d/Y H:i:s.000");
                    $log = $logsql->log_action($post, 'add');
                }
            }
        }        
        elseif ($checkfmem > 1)
        {
            $dbname = '';
            foreach ($getmem as $key => $value) :
                $dbname .= "<option value='".trim($value['DBNAME'])."'>".trim($value['DBNAME'])."</option>";
            endforeach;
            
            $success = $dbname;
            
        }
        else
        {	
            $success = 0;		
        }	

    endif;

	echo $success;

?>