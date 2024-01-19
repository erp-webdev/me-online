<?php

    if ($logged == 1) {

        //*********************** MAIN CODE START **********************\\

        # ASSIGNED VALUE
        $page_title = "Learning and Development";

        //***********************  MAIN CODE END  **********************\\

        $subpage = $_GET['subpage'];

        switch ($subpage) {
            case 'employee':
				// $lmsdata = $lms->select_employees($_GET['db'], $_GET['EmpID']);
                break;

            default:
                // main page
                // $lmsdata = $lms->select_employees('GL');
                break;
        }


    }
    else
    {
        echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
    }

?>
