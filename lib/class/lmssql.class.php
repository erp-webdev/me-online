<?php

class lmssql {
    
    public function db_connect() //connect to database
	{
        $result = mssql_connect(DBHOST, DBUSER, DBPASS);
        if(!$result) return false;
        else return $result;
	}  
    public function db_select($con, $dbname = NULL) //connect to database
	{
        $maindb = $dbname ? $dbname : MAINDB;
        
        $result = mssql_select_db($maindb, $con);
        if(!$result) return false;
        else return $result;
	}    
    
	private function db_result_to_array($query) //Transform query results into array
	{
        if(!$query) return false;
        $res_array = array();
        for($count = 0; $row = mssql_fetch_array($query, MSSQL_ASSOC); $count++) :
            $res_array[$count] = $row;								
		endfor;
        
        return $res_array;
	}
	private function db_result_to_num($query) //Transform query results into array
	{
        if(!$query) return false;
        $row_cnt = mssql_num_rows($query);
        return $row_cnt;
	}
    
	public function get_row($sql, $dbname = 'SUBSIDIARY')
	{
        if(!$sql) return;
        $con = $this->db_connect();
        $seltab = $this->db_select($con, $dbname);
        $result = mssql_query($sql);
        if(!$result) return;
        $result = $this->db_result_to_array($result);
        return $result;
	}
	
	public function get_numrow($sql) //Get num rows of a table from $sql
	{
        if(!$sql) return;
        $con = $this->db_connect();
        $seltab = $this->db_select($con);
        $result = mssql_query($sql);
        if(!$result) return;
        $result = $this->db_result_to_num($result);
        return $result;
	}
    
    public function get_execute($sql, $dbname = NULL) //Get num rows of a table from $sql
	{
        if(!$sql) return;
        $con = $this->db_connect();
        $seltab = $this->db_select($con, $dbname);
        $result = mssql_query($sql);
        if(!$result) return;
        return $result;
	}
	
	# MAINSQL CLASS
    
    function get_sp_data_status($sp_name, $parameters = NULL, $dbname = NULL)
	{        
        // TYPE:
        // 1 - array
        // 2 - num_row
        
        $status = 0;
        $con = $this->db_connect();
        
        $maindb = $dbname ? $dbname : MAINDB;
        
        $stmt = mssql_init($maindb.'.dbo.'.$sp_name, $con);
        
        if ($parameters) :
            foreach ($parameters as $key => $value) :
                //var_dump($value);
                mssql_bind($stmt, '@'.$value['field_name'], $value['field_value'], $value['field_type'], $value['field_isoutput'], $value['field_isnull'], $value['field_maxlen']);
            endforeach;
        endif;
        
        $status = NULL;
        mssql_bind($stmt, '@STATUS', $status, SQLVARCHAR, true);

        $query = mssql_execute($stmt);
        
        $result = $status;
        
		return $result;
	}		
    
    function get_sp_data($sp_name, $parameters = NULL, $dbname = NULL)
	{        
        // TYPE:
        // 1 - array
        // 2 - num_row
        
        $status = 0;
        $con = $this->db_connect();
        
        $maindb = $dbname ? $dbname : MAINDB;
        $stmt = mssql_init($maindb.'.dbo.'.$sp_name, $con);
        
        if ($parameters) :
            foreach ($parameters as $key => $value) :
                //var_dump($value);
                mssql_bind($stmt, '@'.$value['field_name'], $value['field_value'], $value['field_type'], $value['field_isoutput'], $value['field_isnull'], $value['field_maxlen']);
            endforeach;
        endif;

        $query = mssql_execute($stmt);
        
        $result = $query;
        
		return $result;
	}		

    // // List Employees of each Database
    // function select_employees($dbname, $empid = null)
    // {
    //     // $sql = "SELECT        B.Active, B.EmpID, B.DBNAME, B.FullName, B.FName, B.LName, B.MName, C.PositionDesc, D.DeptDesc, 
    //     //                         E.DivisionName, F.RankDesc, B.HireDate, B.DATERESIGNED
    //     //         FROM            dbo.VIEWHREMPMASTER_INACTIVE AS b LEFT OUTER JOIN
    //     //                                  dbo.HRPosition AS C ON B.PositionID = C.PositionID AND C.DBNAME = B.DBNAME LEFT OUTER JOIN
    //     //                                  dbo.HRDepartment AS D ON B.DeptID = D.DeptID AND D.DBNAME = B.DBNAME LEFT OUTER JOIN
    //     //                                  dbo.HRDivision AS E ON B.DivisionID = E.DivisionID AND E.DBNAME = B.DBNAME LEFT OUTER JOIN
    //     //                                  dbo.HRRank AS F ON B.RankID = F.RankID AND F.DBNAME = B.DBNAME
    //     //         WHERE        (B.CompanyActive = 1) and B.DBNAME = '$dbname' ";

    //     // if(!empty($empid))
    //     //     $sql .= " and EmpID='$empid' ";
    //     // else
    //     //     $sql .= " and Active=1 ";

    //     // $sql .= " ORDER BY FullName";

    //     // $result = $this->get_row($sql, 'SUBSIDIARY');

    //     return 'levs';
    // }

    // // List employee training summary per year
    // function select_employees_with_training($dbname, $year, $page = null, $record = null)
    // {
    //     $sql = "SELECT * FROM ViewEmpTrainingSummaryPerYear WHERE DBNAME = '$dbname' and TrainingYear = $year ";

    //     $result = $this->get_row($sql);

    //     return $result;
    // }

    // // List Employee's Trainings
    // function select_employee_trainings($dbname, $empid)
    // {
    //     $sql = "SELECT * FROM HREmpTraining WHERE DBNAME = '$dbname' AND EmpID = '$empid'";

    //     $result = $this->get_row($sql);

    //     return $result;
    // }

    // Update employee training
    // function select_update_employee_training($id, $params)
    // {
    //     $sql = "UPDATE HREmpTraining SET 
    //         [EmpID] = $params['EmpID']
    //        ,[DBNAME] = $params['DBNAME']
    //        ,[TrainingName] = $params['TrainingName']
    //        ,[TrainingDate] = $params['TrainingDate']
    //        ,[CreditHours] = $params['CreditHours']
    //        ,[CertPath] = $params['CertPath']
    //        ,[TrainingProvider] = $params['TrainingProvider']
    //        ,[TrainingVenue] = $params['TrainingVenue']
    //        ,[TrainingAmount] = $params['TrainingAmount']
    //        ,[BondStartDate] = $params['BondStartDate']
    //        ,[BondEndDate] = $params['BondEndDate']
    //        ,[BondStatus] = $params['BondStatus']
    //        ,[UpdatedAt] = GETDATE()
    //        ,[CreatedBy] = ''
    //        ,[UpdatedBy] = ''
    //        WHERE id = $id";

    //     $result = mssql_query($sql);
    //     return $result;
    // }

    // Insert new employee training
    // function insert_employee_training($params)
    // {
    //     $sql = "INSERT INTO HREmpTraining ([EmpID]
    //        ,[DBNAME]
    //        ,[TrainingName]
    //        ,[TrainingDate]
    //        ,[CreditHours]
    //        ,[CertPath]
    //        ,[TrainingProvider]
    //        ,[TrainingVenue]
    //        ,[TrainingAmount]
    //        ,[BondStartDate]
    //        ,[BondEndDate]
    //        ,[BondStatus]
    //        ,[UpdatedAt]
    //        ,[CreatedBy]
    //        ,[UpdatedBy]) 
    //        VALUE ($params['EmpID']
    //        ,$params['DBNAME']
    //        ,$params['TrainingName']
    //        ,$params['TrainingDate']
    //        ,$params['CreditHours']
    //        ,$params['CertPath']
    //        ,$params['TrainingProvider']
    //        ,$params['TrainingVenue']
    //        ,$params['TrainingAmount']
    //        ,$params['BondStartDate']
    //        ,$params['BondEndDate']
    //        ,$params['BondStatus']
    //        ,GETDATE()
    //        ,''
    //        ,''";

    //     $result = mssql_query($sql);
    //     return $result;

    // }

    // Delete Employee training
    // function delete_employee_training($id)
    // {
    //     $sql = "DELETE HREmpTraining WHERE id = $id";

    //     $result = mssql_query($sql);
    //     return $result;
    // }
}

?>
