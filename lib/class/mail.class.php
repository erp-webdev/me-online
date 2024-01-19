<?php

class mails {
	
	public function db_connect() //connect to database
	{
			$result = new mysqli(MAIL_DBHOST, MAIL_DBUSER, MAIL_DBPASS, MAIL_DBNAME);	 //define in includes/config.php
			if(!$result) return false;
			else return $result;
	}
    public function db_disconnect() //connect to database
	{
			$result = mysqli_close();	 //define in includes/config.php
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
    
    function mail_cue($from, $to, $subject, $message, $header, $bcc = NULL, $cc = NULL)
    {
        $sql="INSERT INTO mailq.tbl_mail 
            SET mail_from = '".$from."',
            mail_to = '".$to."',
            mail_subject = '".addslashes($subject)."',
            mail_headers = '".$header."', ";
        if ($bcc) : $sql .= " mail_bcc = '".$bcc."', "; endif;
        if ($cc) : $sql .= " mail_cc = '".$cc."', "; endif;
        $sql .= " mail_body = '".addslashes($message)."'";

        if($this->db_query($sql)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

	
	# MISCELLEANNOUS
	
	function clean_variable($var, $type = 0)
	{
		if (get_magic_quotes_gpc())
		{
			$newvar = stripslashes($var);
		}
		else
		{
			$newvar = $var;
		}           
		
		if ($type == 1) //numeric (such as ID)
		{                 
			$conn = $this->db_connect(1);
			$newvar = $conn->real_escape_string($newvar);
			$newvar = (int)$newvar;
			return $newvar;
		}
		elseif ($type == 2) //alphanum with dash (such as postname or slug)
		{
			$newvar = preg_replace("/[^a-zA-Z0-9-_]/", "", $newvar);          
			$newvar = strtolower($newvar);
			$conn = $this->db_connect(1);            
			$newvar = $conn->real_escape_string($newvar);
			
			return $newvar;
		}
		elseif ($type == 3) // block some MySQL parameter
		{
			$sqlword = array("/scheme/i","/delete/i", "/update/i","/union/i","/insert/i","/drop/i","/http/i","/--/i");
			$newvar = preg_replace($sqlword, "", $newvar);
			$conn = $this->db_connect(1);            
			$newvar = $conn->real_escape_string($newvar);
			
			return $newvar;
		}
		else // simple... MySQL Real Escape String only
		{                 
			$conn = $this->db_connect(1);            
			$newvar = $conn->real_escape_string($newvar);
			
			return $newvar;
		}
	}

}
?>