<?php 

class WFHManagement extends mainsql{

    function getWfhClearanceItems($empid, $dbname)
    {
        $sql = "SELECT A.*
                FROM viewApplyWFHClearance A
                WHERE A.EmpID = '$empid'
                ORDER by A.DTRDATE DESC";
        
        return $this->get_row($sql, $dbname);
    }

    function getWfhClearanceItems($start = 0, $limit = 0, $search = NULL, $count = 0)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY DTRDATE ASC) as ROW_NUMBER, ";
        $sql .= " EmpID, FName, MName, LName, DB_NAME() as DBNAME, DeptDesc,
                    RefNbr, ClearanceType, DTRDate, FormStatus, DTRWorkHours, WorkHours, 
                    FROM viewApplyWFHClearance ";
        $sql .= " WHERE EmpID != '' ";
        if ($search != NULL) : $sql .= " AND (EmpID = '".$search."' OR LName LIKE '%".$search."%' OR FName LIKE '%".$search."%') "; endif;
        $sql .= ") AS [outer] ";
        if ($limit) :
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;
        echo $sql; exit;
		if ($count) : $result = $this->get_numrow($sql);
        else : $result = $this->get_row($sql);
        endif;
		return $result;
	}



}