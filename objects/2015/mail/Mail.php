<?php 

class Mail{

    private $mailtest;

    public function __construct() {
        $this->mailtest = MAIL_TEST;
    }

    public function send($to, $subject, $body, $cc = null, $bcc = null)
    {
        $headers = "From: ".NOTIFICATION_EMAIL."\r\n";
        $headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        if($this->mailtest)
            $to = 'kayag.global@megaworldcorp.com';
            
        return $sendmail = mail($to, $subject, $body, $headers);
    }
}