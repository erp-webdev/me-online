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

        if($this->mailtest){
            $body .= '<p><b>NOTICE<b> This is a test mail and not intended for actual notification. 
                Should you receive this email, please let us know through devteam@megaworldcorp.com. 
                The email test is inteded for ' . $to . ' </p>';
        
            $to = 'kayag.global@megaworldcorp.com';
        }

        return $sendmail = mail($to, $subject, $body, $headers);
    }
}