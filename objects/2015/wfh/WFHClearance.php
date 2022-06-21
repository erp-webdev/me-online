<?php 
include OBJ . '/mail/Mail.php';
class WFHClearance{

    private $types = [
        'sickness' => 'Sickness / Illness',
    ];

    function getTypes(){
        return $this->types;
    }

}
