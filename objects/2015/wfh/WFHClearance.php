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
            echo $params['wfhc_to'] . '===' . $params['wfhc_from'];exit;
            echo '{"success": false, "error": "Incorrect coverage end of date."}';
            exit();

        }

    }

    public function submit($params)
    {
		echo '{"success": false, "error": "Your session has expired! Kindly logout and login again to continue."}';
        
    }

}
