<?php 
include OBJ . '/mail/Mail.php';

class WFHClearance extends mainsql{

    private $types = [
        'sickness' => 'Sickness / Illness'
    ];

    private $register;
    private $logsql;

    private $allowedExts = array("JPG", "JPEG", "GIF", "PNG", "PDF", "jpg", "jpeg", "gif", "png", "pdf");
    
    public function __construct() {
        $this->register = new regsql();
        $this->logsql = new logsql();
    }

    public function getTypes(){
        return $this->types;
    }

    public function validate($params)
    {
        // Check type
        if(!in_array($params['wfh_type'], array_keys($this->getTypes()))){
            echo '{"success": false, "error": "Invalid selected type"}';
            exit();
        }

        // Check Covered Period
        if($params['wfhc_to'] < $params['wfhc_from']){
            echo '{"success": false, "error": "Incorrect coverage end of date."}';
            exit();
        }

        // Check reason 
        if(empty(trim($params['reason']))){
            echo '{"success": false, "error": "Reason for WFH Clearance is required."}';
            exit();
        }

        // Attachment
        if (!$_FILES['attachment1']['name']) {
            echo '{"success": false, "error": "Attachment is required."}';
            exit();
        }else{
            $errorfile = 0;
            for($i=1; $i<=5; $i++) :

                if ($_FILES['attachment'.$i]['name']) :
                    $filename = $_FILES['attachment'.$i]['name'];
                    $filesize = $_FILES['attachment'.$i]['size'];

                    $tempext = explode(".", $filename);
                    $extension = end($tempext);

                    if (($filesize >= 209715) || !in_array($extension, $this->allowedExts)) :
                        $errorfile++;
                    endif;
                endif;
            endfor;

            if ($errorfile) :
                echo '{"success": false, "error": "One of the attachment isn\'t PDF, JPG nor GIF and/or not less then 200Kb"}';
                exit();
            endif;
        }

    }

    public function submit($params)
    {
        // $post['EMPID'] = $profile_idnum;
        // $post['TASKS'] = "CREATE_WFHC";
        // $post['DATA'] = $add_np;
        // $post['DATE'] = date("m/d/Y H:i:s.000");
        
        return $this->wfc_action($params, 'add');
        // $this->createLog($post, 'add');
    }

    public function saveAttachment($add_wc)
    {
        for($i=1; $i<=5; $i++) :
    
            if ($_FILES['attachment'.$i]['name']) :

                $image = $_FILES['attachment'.$i]['tmp_name'];
                $filename = $_FILES['attachment'.$i]['name'];
                $filesize = $_FILES['attachment'.$i]['size'];
                $filetype = $_FILES['attachment'.$i]['type'];

                $tempext = explode(".", $filename);
                $extension = end($tempext);

                if (($filesize < 524288) && in_array($extension, $this->allowedExts)) :

                    $path = "uploads/wc/";
                    $fixname = 'attach_'.$add_wc.'_'.$i.'.'.$extension;
                    $target_path = $path.$fixname; 

                    $filemove = move_uploaded_file($image, $target_path);

                    $attach['attachfile'] = $fixname;
                    $attach['attachtype'] = $filetype;
                    $attach['reqnbr'] = $add_wc;

                    if($filemove) :
                        $add_attach = $this->attach_action($attach, 'add');			
                    endif;
                endif;

            endif;

        endfor;
    }

    public function approve($params)
    {
         $this->wfc_action($params, 'approved');
        $this->createLog($params, 'add');
    }

    public function notifyRequestor($empid, $add_wc)
    {
        $requestor = $this->register->get_member($empid);
        // $request_info = $tblsql->get_mrequest(6, 0, 0, 0, $add_wc, 0, NULL, NULL, NULL, NULL);
        // $approver = $logsql->get_allmember($approver1, $approverdb1);

        $reqemailblock = $this->get_newemailblock($empid);
        if ($reqemailblock) :

            //SEND EMAIL (REQUESTOR)

            $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New WFH Clearance Request</span><br><br>Hi ".$requestor[0]['NickName'].",<br><br>";
            $message .= "You opened a new request for WFH Clearance with Reference No: ".$add_wc." on ".date('F j, Y')." and it's subject for approval. ";
            $message .= "<br><br>Thanks,<br>";
            $message .= SITENAME." Admin";
            $message .= "<br>Click<a href='https://portal.megaworldcorp.com/me/login'> here</a> to login";
            $message .= "<hr />".MAILFOOT."</div>";

            $mail = new Mail();
            $sendmail = $mail->send($requestor[0]['EmailAdd'], "New WFH Clearance Request", $message);

        endif; 
    }

    public function notifyApprovers($empid, $add_wc, $approver1, $approverdb1)
    {
        $requestor = $this->register->get_member($empid);
        $approver = $this->logsql->get_allmember($approver1, $approverdb1);

        // $reqemailblock = $mainsql->get_newemailblock($empid);
        $appemailblock = $this->get_newemailblock($approver1);

        if ($appemailblock) :             

            //SEND EMAIL (APPROVER)

            $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New WFH Clearance Request from ".$requestor[0]['FName']." ".$requestor[0]['LName']."</span><br><br>Hi ".$approver[0]['NickName'].",<br><br>";
            $message .= "New request ".$requestor[0]['FName']." ".$requestor[0]['LName']." for WFH Clearance with Reference No: ".$add_wc." on ".date('F j, Y')." for your approval. ";
            $message .= "<br><br>Thanks,<br>";
            $message .= SITENAME." Admin";
            $message .= "<br>Click<a href='https://portal.megaworldcorp.com/me/login'> here</a> to login";

            $message .= "<hr />".MAILFOOT."</div>";

            $mail = new Mail();
            // $sendmail = $mail->send($approver[0]['EmailAdd'], "New WFH Clearance Request for your Approval", $message);
            $sendmail = $mail->send('kayag.global@megaworldcorp.com', "New WFH Clearance Request for your Approval", $message);

        endif;
    }

    private function createLog($params, $action)
    {
        $this->log_action($params, 'add');
    }

}
