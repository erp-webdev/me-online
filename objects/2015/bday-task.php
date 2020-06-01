<?php 

    $last_notify = LAST_NOTIFY;

    if ($last_notify != date("Y-m-d") || !$last_notify) :

        //SEND EMAIL
        $mailcount = 0;

        $bimgdata = $tblsql->get_bdayimg();
        $receivers = $tblsql->get_users_birthday(0, 0, NULL, 0, 0);

        foreach ($receivers as $key => $value) :

            $bdaymsg = $bimgdata[0]['bimg_message'] ? "<br><br><span style='font-size: 18px; color: #F00; font-weight: bold;'>".$bimgdata[0]['bimg_message']."</span>" : '';

            if ($value['DBNAME'] == 'GL') :
                if ($value['CompanyID'] == 'GLOBAL01') :
                    $bdayfile = $bimgdata[0]['bimg_filename2'];
                elseif ($value['CompanyID'] == 'LGMI01') :
                    $bdayfile = $bimgdata[0]['bimg_filename3'];
                endif;
            else :
                $bdayfile = $bimgdata[0]['bimg_filename1'];
            endif;
        
            $message = "<div style='display: block; border: 5px solid #F00; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%; text-align: center;'><span style='font-size: 24px; color: #F00; font-weight: bold;'>".strtoupper($value['FName'].' '.$value['LName'])."</span><br><br><img src='".WEB."/uploads/birthday/".$bdayfile."' style='width: 95%; margin: 0px auto;' />".$bdaymsg."<br /><br /><span style='font-size: 10px; color: #999; '>* Please click <a href='".WEB."/uploads/birthday/".$bdayfile."' target='_blank' style='font-weight: bold; color: #666;'>here</a> if you don't see any image.</span></div>";

            //$message = "<div style='display: block; padding: 10px; font-size: 14px; font-family: Verdana; width: 100%; text-align: center;'>Dear User,<br><br>Earlier today, we sent you an email that contained nothing but well wishes for your birthday.<br><br>This was purely a mistake if today is not your birthday, so please accept our apologies for littering your inbox. We are are truly sorry that you have received this email in error.<br><br>We care about you above all else and have taken measures to ensure  that this will not happen again.<br><br>If you have any questions or concerns, please contact you respective HR business partner.<br><br>Sincerely,<br><br>ISM-Web Development Team</div>";

            $headers = "From: meonline-bday-noreply@alias.megaworldcorp.com\r\n";
            $headers .= "Reply-To: noreply@megaworldcorp.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            $cc = 'hrportal@megaworldcorp.com';

            if ($value['EmailAdd']) :
                if ($value['DBNAME'] == 'GL') :     
                    $appendmail = $mails->mail_cue('meonline-bday-noreply@alias.megaworldcorp.com', $value['EmailAdd'], "Happy Birthday to you!", $message, $headers, $cc);
                else :
                    $appendmail = $mails->mail_cue('meonline-bday-noreply@alias.megaworldcorp.com', $value['EmailAdd'], "Happy Birthday to you!", $message, $headers, $cc);
                endif;

                //AUDIT TRAIL
                $post['EMPID'] = $profile_idnum;
                $post['TASKS'] = "BIRTHDAY_SEND";
                $post['DATA'] = $value['FName'];
                $post['DATE'] = date("m/d/Y H:i:s.000");

                echo var_dump($appendmail);

        		// define("DBNAME", $value['DBNAME']);
                // $log = $tblsql->log_action($post, 'add');
        		// define("DBNAME", 'SUBSIDIARY');

                //$appendmail2 = $mails->mail_cue('meonline_bday@megaworldcorp.com', 'hrportal@megaworldcorp.com', "Happy Birthday to you!", $message, $headers);
            endif;
            if($appendmail) : 
                $mailcount++; 
            endif;

        endforeach;

        $post['set_lastnotify'] = date("Y-m-d");
        $edit_lnotify = $tblsql->setting_action($post, 'last_notify');

        echo "Birthday card has been successfully sent to ".$mailcount." birthday celebrant";  

    endif;

 ?>