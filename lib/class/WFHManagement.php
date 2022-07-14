<?php 

class WFHManagement extends mainsql{

    public function getWfhClearanceItems($empid, $dbname)
    {
        $sql = "SELECT * FROM viewApplyWFHClearance 
                WHERE EmpID = '$empid'
                ORDER by DTRDATE DESC"
        
        return $this->get_row($sql, $dbname);
    }



}