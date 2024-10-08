<?php	

    include("../../config.php");

    extract($_POST);

    if ($username && $dbname) :

        $cookiename = 'megasubs_user';

        $expire = time() + 60;
        $_SESSION[$cookiename] = $username;
        $_SESSION['megasubs_password'] = $password;
        $_SESSION['megasubs_db'] = $dbname;

        $getmem = $logsql->get_member2($username, $password);

        $is_hash = $getmem[0]['PasswordHash'] ? true : false;
        $login_failed_attempt = $logsql->check_login_user($username);
        $login_failed_attempt ?  $logsql->update_login_failed($username, 0, $getmem[0]['EmailAdd']) : $logsql->insert_user_activity($username, $getmem[0]['EmailAdd'], $is_hash);

        //AUDIT TRAIL
        $post['EMPID'] = $username;
        $post['TASKS'] = "LOGIN";
        $post['DATA'] = $username;
        $post['DATE'] = date("m/d/Y H:i:s.000");
        $log = $logsql->log_action($post, 'add');

        $success = 1;

    else :

        $success = 0;

    endif;

	echo $success;

?>