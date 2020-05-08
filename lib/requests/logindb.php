<?php	

    include("../../config.php");

    extract($_POST);

    if ($username && $dbname) :

        $cookiename = 'megasubs_user';

        $expire = time() + 60;
        $_SESSION[$cookiename] = $username;
        $_SESSION['megasubs_password'] = $password;
        $_SESSION['megasubs_db'] = $dbname;

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