<?php 
// include OBJ . '/Mail/Mail.php';

class WFHClearance{

    public $types = [
        'sickness' => 'Sickness / Illness',
    ];

    function getTypes(){
        return $this->types;
    }

}
