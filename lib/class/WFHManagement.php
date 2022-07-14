<?php 

class WFHManagement extends mainsql{

    public function getWfhClearanceItems($empid, $dbname)
    {
        $sql = "SELECT A.*, B.DeptDesc
                FROM viewApplyWFHClearance A
                LEFT JOIN HRDepartment B on A.DeptID = B.DeptID
                WHERE A.EmpID = '$empid'
                ORDER by A.RefNbr, A.DTRDATE DESC";
        
        return $this->get_row($sql, $dbname);
    }



}