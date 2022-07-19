<?php 

class AccessManagement extends tblsql{

    /* Check user access to specifiy form */
    public function hasAccess($user_empid, $user_dbname, $company_db, $access)
    {
        $user_access = $this->userAccess($user_empid, $user_dbname, $company_db);

        if(!count($user_access))
            return 0;

        switch($access){
            case 'Form': 
                return $user_access[0]['Form'];
            case 'dtr': 
                return $user_access[0]['dtr'];
            case 'payslip': 
                return $user_access[0]['payslip'];
            case 'request': 
                return $user_access[0]['request'];
            case 'approvers': 
                return $user_access[0]['approvers'];
            case 'activities': 
                return $user_access[0]['activities'];
            case 'ads': 
                return $user_access[0]['ads'];
            case 'memo': 
                return $user_access[0]['memo'];
            case 'birthday': 
                return $user_access[0]['birthday'];
            case 'forms': 
                return $user_access[0]['forms'];
            case 'wfh': 
                return $user_access[0]['wfh'];
            case 'access': 
                return $user_access[0]['access'];
        }

        return 0;

    }

    /* Get user access */
    public function userAccess($user_empid, $user_dbname, $company_db)
    {
        $sql = "SELECT TOP 1 * FROM MEAccess 
                WHERE EmpID = '$user_empid' AND EmpIDDB = '$user_dbname'  
                AND CompanyDB = '$company_db'";

        $result = $this->get_row($sql);
        var_dump($result); exit;
        return $result;
    }

    /*create access*/
    public function setAccess($user_empid, $user_dbname, $company_db, $access)
    {
        
    }

}