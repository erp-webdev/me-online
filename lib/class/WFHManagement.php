<?php 

class WFHManagement extends mainsql{

    public function getWfhClearanceItems($empid, $dbname)
    {
        $sql = "SELECT A.*
                FROM viewApplyWFHClearance A
                WHERE A.EmpID = '$empid'
                ORDER by A.DTRDATE DESC";
        
        return $this->get_row($sql, $dbname);
    }



}