<?php
    
    // BIRTHDAY MESSAGE
    if ($_POST['btnbdaysend'] || $_POST['btnbdaysend_x']) :

        $message = "<div style='display: block; border: 5px solid #FF0000; padding: 10px; font-size: 12px; font-family: Verdana; width: 700px;'><span style='font-size: 18px; color: #FF0000; font-weight: bold;'>Happy Birthday from ".$_POST['bday_fromname']."</span><br><br>Hi ".$_POST['bday_tonickname'].",<br><br>";
        $message .= "You have a birthday message from ".$_POST['bday_fromname'].".<br><br>";
        $message .= "<b>Message:</b><br>";
        $message .= $_POST['bday_message']."<br><br>";
        $message .= $_POST['bday_fromnick'];
        $message .= "<hr />".MAILFOOT."</div>";

        $headers = "From: meonline-bday-noreply@alias.megaworldcorp.com\r\n";
        $headers .= "Reply-To: noreply@megaworldcorp.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        //$sendmail = mail($_POST['bday_email'], "HR Portal Birthday Message from ".$_POST['bday_fromname'], $message, $headers);               
        if($sendmail) :    
            echo '{"success":true}';
            exit();
        else :
            echo '{"success":false}';
            exit();
        endif;
    endif;

    $birthdays = $main->get_bday($profile_id);

?>