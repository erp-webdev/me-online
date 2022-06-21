<?php 
include OBJ . '/mail/Mail.php';

class WFHClearance implements Mail{

    private $types = [
        'sickness' => 'Sickness / Illness',
    ];

    public function getTypes(){
        return $this->types;
    }

}