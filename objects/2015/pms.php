<?php

    if ($logged == 1 && $profile_dbname != 'ECINEMA' && $profile_dbname != 'EPARKVIEW' && $profile_dbname != 'NEWTOWN') {
        //*********************** MAIN CODE START **********************\\

        # ASSIGNED VALUE
        $page_title = "Performance Management";

        //***********************  MAIN CODE END  **********************\\

    }
    else
    {
        echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
    }

?>
