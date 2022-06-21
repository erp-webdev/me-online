<?php 
include OBJ . '/mail/Mail.php';
class WFHClearance{

    private $type;
    private $covered

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
            echo '{"success": false, "error": "All inputs on Work from Home must be completed (Total Worked Hours & Acitivities). Unless the date is excluded."}';
            exit();
        }

        // Check Covered Period
        

    }

    public function submit($params)
    {
        
    }

}
