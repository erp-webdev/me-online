<?php 
include OBJ . '/mail/Mail.php';
class WFHClearance extends mainsql{

    private $types = [
        'sickness' => 'Sickness / Illness'
    ];

    private $allowedExts = array("JPG", "JPEG", "GIF", "PNG", "PDF", "jpg", "jpeg", "gif", "png", "pdf");
     
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
        $this->wfc_action($params, 'add');
        $this->createLog($params, 'add');
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
                        $add_attach = $mainsql->attach_action($attach, 'add');			
                    endif;
                endif;

            endif;

        endfor;
    }

    public function approve($params)
    {
        $this->wfc_action($params, 'add');
        $this->createLog($params, 'add');
    }

    private function createLog($params, $action)
    {
        $mainsql->log_action($params, 'add');
    }

}
