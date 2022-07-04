<?php 

class Mail{

    public function send($to, $subject, $body, $cc = null, $bcc = null)
    {
        $headers = "From: ".NOTIFICATION_EMAIL."\r\n";
        $headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        return $sendmail = mail($to, $subject, $body, $headers);
    }
}