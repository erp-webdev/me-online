<?php 

	include("../../config.php"); 
	include(LIB."/login/chklog.php");

    if($logstat != 1){
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
        exit;
    }

    define("MAINDB", $dbname);
    include(CLASSES."/mainsql.class.php");
    $mainsql = new mainsql;

    $post['EMPID'] = $logname;
    $post['TASKS'] = $_POST['action'];
    $post['DATA'] = $logname;
    $post['DATE'] = date("m/d/Y H:i:s.000");

    echo $mainsql->log_action($post, 'add');
?>			
