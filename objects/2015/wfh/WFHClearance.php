<?php 
include OBJ . '/mail/Mail.php';
class WFHClearance{

    private $types = [
        'sickness' => 'Sickness / Illness'
    ];

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
        }

    }

    public function submit($params)
    {
		echo '{"success": false, "error": "Your session has expired! Kindly logout and login again to continue."}';
        
    }

}
