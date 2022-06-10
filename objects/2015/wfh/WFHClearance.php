<?php 
include OBJ . '/mail/Mail.php';

class WFHClearance implements Mail{

    public $types = [
        'sickness' => 'Sickness / Illness',
    ];

    public function create($params)
    {
        
    }
}