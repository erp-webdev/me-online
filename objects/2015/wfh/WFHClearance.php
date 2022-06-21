<?php 
include OBJ . '/Mail/Mail.php';

public class WFHClearance{

    private $types = [
        'sickness' => 'Sickness / Illness',
    ];

    public function getTypes(){
        return $this->types;
    }

}
