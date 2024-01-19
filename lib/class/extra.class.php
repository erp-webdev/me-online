<?php

class extra {
	
	public function db_connect() //connect to database
	{
			$result = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);	 //define in includes/config.php
			if(!$result) return false;
			else return $result;
	}
	private function db_result_to_array($result, $type) //Transform query results into array
	{
			if(!$result) return false;
			$res_array = array();
			for($count = 0; $row = $result->fetch_assoc(); $count++)
			{
				$res_array[$count] = $row;
								
			}
			return $res_array;
	}
	private function db_result_to_num($result) //Transform query results into array
	{
			if(!$result) return false;
			$row_cnt = $result->num_rows;
			return $row_cnt;
	}
	
	/*
	TYPES:
	1 - article
	*/
	public function get_row($sql, $type) //Get rows of a table from $sql
	{
			if(!$sql) return;
			$conn = $this->db_connect();
			$result = $conn->query($sql);
			if(!$result) return;
			$result = $this->db_result_to_array($result, $type);
			return $result;
	}
	
	public function get_numrow($sql) //Get num rows of a table from $sql
	{
			if(!$sql) return;
			$conn = $this->db_connect();
			$result = $conn->query($sql);
			if(!$result) return;
			$result = $this->db_result_to_num($result);
			return $result;
	}
	
	public function db_query($sql) //Get rows of a table from $sql
	{
			if(!$sql) return;
			$conn = $this->db_connect();
			$result = $conn->query($sql);
			return $result;
	}
    
    public function db_insert($sql) //Get rows of a table from $sql
	{
			if(!$sql) return;
			$conn = $this->db_connect();
			$result = $conn->query($sql);
            $result = $conn->insert_id;
			return $result;
	}
	
	# MAIN CLASS
    
    function get_old_data()
	{
		$sql= "SELECT e.* ";
		$sql.= " FROM tbl_oldlist e ";

		$result = $this->get_row($sql, 1);		
			
		return $result;
	}
    
    # ACTIONS
    
    function insert_new_data($value)
	{
        $value = $value ? extract($value) : NULL;

		$sql = "INSERT INTO tbl_emplist SET
                    emp_idnum = '".$empid."',
                    emp_fullidnum = '".$empid2."',
                    emp_idhash = '".md5($empid)."',
                    emp_position = '".$position_id."',
                    emp_rank = '".$rank_id."',
                    emp_estatus = '".$empstatus."',
                    emp_taxid = '".$taxid."',
                    emp_lastname = '".$lname."',	
                    emp_firstname = '".$fname."', 	
                    emp_middlename = '".$mname."', 		
                    emp_email = '".$email."', 	
                    emp_corpemail = '".$email."', 	
                    emp_bday = '".date("Y-m-d", strtotime($bdate))."', 	
                    emp_sex = '".($sex == "MALE" ? 'm' : 'f')."', 	
                    emp_sss = '".$sss."', 	
                    emp_tin = '".$tin."', 	
                    emp_philhealth = '".$philhealth."', 	
                    emp_pagibig = '".$pagibig."', 	
                    emp_corpdiv = '".$div_id."',
                    emp_password = '".md5($password)."',
                    emp_datehired = '".date("Y-m-d", strtotime($hiredate))."',
                    emp_corpdept = '".$dept_id."',
                    emp_dateupdate = ".date("U").",
                    emp_status = 2"; 
        
        if($this->db_query($sql)) :
            return TRUE;
        else :
            return FALSE;
        endif;			
	}

	
	# MISCELLEANNOUS

}
?>