<?php

class register
{
	var $ccount = false;
	
	public function db_connect() //connect to database
	{
			$result = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);	 //define in includes/config.php
			if(!$result) return false;
			else return $result;
	}
	
	private function db_result_to_array($result) //Transform query results into array
	{
			if(!$result) return false;
			$res_array = array();
			for($count = 0; $row = $result->fetch_assoc(); $count++)
			{
				$res_array[$count] = $row;							
			}
			return $res_array;
	}
	
	public function db_query($sql) //Get rows of a table from $sql
	{
			if(!$sql) return;
			$conn = $this->db_connect();
			$result = $conn->query($sql);
			return $result;
	}
	
	public function get_row($sql) //Get rows of a table from $sql
	{
			if(!$sql) return;
			$conn = $this->db_connect();
			$result = $conn->query($sql);
			if(!$result) return;
			$result = $this->db_result_to_array($result);
			return $result;
	}
	
	function check_user($username)
	{
		$nameid = md5($username);

		$sql = "SELECT COUNT(emp_id) AS mcount FROM tbl_emplist WHERE emp_idhash = '".$nameid."'";
		$result = $this->get_row($sql);			
		if($result[0]['mcount'] <= 0) 
		{
			return false;
		}
		else
		{
			return true;
		}	
	}		
	
	function check_member($username, $password)
	{		
        $userhash = md5($username);
        $passhash = md5($password);
		
		$sql = "SELECT COUNT(emp_id) AS mcount FROM tbl_emplist WHERE emp_idhash = '".$userhash."' AND emp_password = '".$passhash."' AND emp_status = 2 ";		
		$result = $this->get_row($sql);			
		if($result[0]['mcount'] <= 0) 
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}	
	}		
	
	function get_member($username)
	{
		$nameid = md5($username);

		$sql = "SELECT emp_id, emp_level, emp_idnum, emp_password, emp_firstname, emp_middlename, emp_lastname, emp_suffixname, emp_nickname, emp_bday, emp_corptel, emp_corpemail, emp_piccontent FROM tbl_emplist WHERE emp_idhash = '".$nameid."' AND emp_status = 2 LIMIT 1";
		$result = $this->get_row($sql);			
		return $result;
	}
    
    function get_member_by_id($empid)
	{
		$sql = "SELECT emp_id, emp_level, emp_idnum, emp_password, emp_firstname, emp_middlename, emp_lastname, emp_suffixname, emp_nickname, emp_bday, emp_corptel, emp_corpemail, emp_piccontent FROM tbl_emplist WHERE emp_id = '".$empid."' AND emp_status = 2 LIMIT 1";
		$result = $this->get_row($sql);			
		return $result;
	}
    
    function get_member_by_empid($empid)
	{
		$sql = "SELECT emp_id, emp_level, emp_idnum, emp_password, emp_firstname, emp_middlename, emp_lastname, emp_suffixname, emp_nickname, emp_bday, emp_corptel, emp_corpemail, emp_piccontent FROM tbl_emplist WHERE emp_idnum = '".$empid."' AND emp_status = 2 LIMIT 1";
		$result = $this->get_row($sql);			
		return $result;
	}
    
    function get_approver($dept = 0)
	{
		$sql = "SELECT emp_id, emp_level, emp_idnum, emp_password, emp_firstname, emp_middlename, emp_lastname, emp_suffixname, emp_nickname, emp_bday, emp_corptel, emp_corpemail, emp_piccontent 
        FROM tbl_emplist 
        WHERE emp_status = 2 
        AND emp_level = 2 ";
        if ($dept) : $sql .= " AND emp_corpdept = ".$dept." "; endif;
		$result = $this->get_row($sql);			
		return $result;
	}
    
    function get_member_by_hash($hash)
	{        
        $sql = "SELECT e.*, p.position_description, d.dept_name, v.div_name 
        FROM tbl_emplist e, tbl_position p, tbl_dept d, tbl_division v 
        WHERE md5(CONCAT('2014', emp_idnum)) = '".$hash."' 
        AND p.position_id = e.emp_position
        AND d.dept_id = e.emp_corpdept
        AND v.div_id = e.emp_corpdiv
        LIMIT 0, 1 ";	
		$result = $this->get_row($sql);			
		return $result;
	}
    
    function edit_member($post, $eid)
	{		
		if(is_array($post)) :			
			$input = array();
			foreach($post as $key => $value) :
                if ($key != 'content') : $input[$key] = mysql_escape_string($value); 
                else : $input[$key] = $value;
                endif;
			endforeach;
			
			extract($input);			
			
			$sql = "UPDATE tbl_emplist SET
                    emp_position = '".$postapp."',
                    emp_lastname = '".$lastname."',	
                    emp_firstname = '".$firstname."', 	
                    emp_middlename = '".$middlename."', 	
                    emp_suffixname = '".$suffixname."', 	
                    emp_nickname = '".$nickname."', 	
                    emp_addressnum = '".$addressnumber."',
                    emp_addressstreet = '".$addressstreet."',
                    emp_addressbrgy = '".$addressbrgy."',
                    emp_addresscity = '".$addresscity."',
                    emp_addressregion = '".$addressregion."',
                    emp_addresszip = '".$addresszip."',
                    emp_addresscountry = '".$addresscountry."', 	
                    emp_address2 = '".$provincialaddress."', 	
                    emp_contact = '".$contactno."', 	
                    emp_email = '".$email."', 	
                    emp_bday = '".$birthday."', 	
                    emp_bplace = '".$birthplace."', 	
                    emp_sex = '".$sex."', 	
                    emp_civil = '".$civil."', 	
                    emp_sss = '".$sss."', 	
                    emp_tin = '".$tin."', 	
                    emp_philhealth = '".$philhealth."', 	
                    emp_pagibig = '".$hdmf."', 	
                    emp_spousename = '".$spouse."', 	
                    emp_spousebday = '".$sbday."', 	
                    emp_spousecompany = '".$scomp."', 	
                    emp_spousework = '".$soccupation."', 	
                    emp_children = '".$children_data."', 	
                    emp_fathername = '".$father."', 	
                    emp_fatherbday = '".$fbday."',
                    emp_fathercompany = '".$fcomp."', 	
                    emp_fatherwork = '".$foccupation."', 	
                    emp_mothername = '".$mother."', 	
                    emp_motherbday = '".$mbday."', 	
                    emp_mothercompany = '".$mcomp."', 	
                    emp_motherwork = '".$moccupation."', 	
                    emp_brosis = '".$brosis_data."', 	
                    emp_relativename = '".$relatives."', 	
                    emp_relativerelation = '".$relationship."', 	
                    emp_relativecompany = '".$relcomp."',	
                    emp_relativeposition = '".$relposition."', 	
                    emp_schoolname = '".$school."', 	
                    emp_schoolfrom = '".$from."', 	
                    emp_schoolto = '".$to."', 	
                    emp_schooldegree = '".$degree."', 	
                    emp_govlic = '".$govlic_data."', 	
                    emp_seminar = '".$seminar_data."',	
                    emp_skill = '".$otherskills."', 	
                    emp_organization = '".$organization."', 	
                    emp_history = '".$hcomp."',
                    emp_emergencyname = '".$emergency."', 	
                    emp_emergencyadd = '".$eadd."', 	
                    emp_emergencytelno = '".$ephone."', 	
                    emp_corpdiv = '".$cdiv."', 	
                    emp_corpgrp = '".$cgrp."', 	
                    emp_corpdept = '".$cdept."',
                    emp_corpsec = '".$csec."', 	 	
                    emp_corptel = '".$cphone."', 	
                    emp_corpemail = '".$cemail."', 	
                    emp_corpapprover = '".$capprover."', ";
            if ($content) :
                $sql .= "emp_piccontent = '".$content."', 	
                        emp_picfilename = '".$binFile_name."', 	
                        emp_picsize = '".$binFile_size."', 	
                        emp_picfiletype = '".$binFile_type."', ";
            endif;
            $sql .= "emp_dateupdate = ".date("U")."
                    WHERE emp_id = ".$eid;
			
			if($this->db_query($sql)) :
				return TRUE;
			else :
				return FALSE;
			endif;			
		endif;
	}
    
    function update_member($post, $eid)
	{		
		if(is_array($post)) :			
			$input = array();
			foreach($post as $key => $value) :
                if ($key != 'content') : $input[$key] = mysql_escape_string($value); 
                else : $input[$key] = $value;
                endif;
			endforeach;
			
			extract($input);			
			
			$sql = "INSERT INTO tbl_emplist_update SET
                    emp_idnum = '".$empnum."',
                    emp_idhash = '".md5($empnum)."',
                    emp_position = '".$postapp."',
                    emp_lastname = '".$lastname."',	
                    emp_firstname = '".$firstname."', 	
                    emp_middlename = '".$middlename."', 	
                    emp_suffixname = '".$suffixname."', 	
                    emp_nickname = '".$nickname."', 	
                    emp_addressnum = '".$addressnumber."',
                    emp_addressstreet = '".$addressstreet."',
                    emp_addressbrgy = '".$addressbrgy."',
                    emp_addresscity = '".$addresscity."',
                    emp_addressregion = '".$addressregion."',
                    emp_addresszip = '".$addresszip."',
                    emp_addresscountry = '".$addresscountry."', 	
                    emp_address2 = '".$provincialaddress."', 	
                    emp_contact = '".$contactno."', 	
                    emp_email = '".$email."', 	
                    emp_bday = '".$birthday."', 	
                    emp_bplace = '".$birthplace."', 	
                    emp_sex = '".$sex."', 	
                    emp_civil = '".$civil."', 	
                    emp_sss = '".$sss."', 	
                    emp_tin = '".$tin."', 	
                    emp_philhealth = '".$philhealth."', 	
                    emp_pagibig = '".$hdmf."', 	
                    emp_spousename = '".$spouse."', 	
                    emp_spousebday = '".$sbday."', 	
                    emp_spousecompany = '".$scomp."', 	
                    emp_spousework = '".$soccupation."', 	
                    emp_children = '".$children_data."', 	
                    emp_fathername = '".$father."', 	
                    emp_fatherbday = '".$fbday."',
                    emp_fathercompany = '".$fcomp."', 	
                    emp_fatherwork = '".$foccupation."', 	
                    emp_mothername = '".$mother."', 	
                    emp_motherbday = '".$mbday."', 	
                    emp_mothercompany = '".$mcomp."', 	
                    emp_motherwork = '".$moccupation."', 	
                    emp_brosis = '".$brosis_data."', 	
                    emp_relativename = '".$relatives."', 	
                    emp_relativerelation = '".$relationship."', 	
                    emp_relativecompany = '".$relcomp."',	
                    emp_relativeposition = '".$relposition."', 	
                    emp_schoolname = '".$school."', 	
                    emp_schoolfrom = '".$from."', 	
                    emp_schoolto = '".$to."', 	
                    emp_schooldegree = '".$degree."', 	
                    emp_govlic = '".$govlic_data."', 	
                    emp_seminar = '".$seminar_data."',	
                    emp_skill = '".$otherskills."', 	
                    emp_organization = '".$organization."', 	
                    emp_history = '".$hcomp."',
                    emp_emergencyname = '".$emergency."', 	
                    emp_emergencyadd = '".$eadd."', 	
                    emp_emergencytelno = '".$ephone."', 	
                    emp_corpdiv = '".$cdiv."', 	
                    emp_corpgrp = '".$cgrp."', 	
                    emp_corpdept = '".$cdept."',
                    emp_corpsec = '".$csec."', 	 	
                    emp_corptel = '".$cphone."', 	
                    emp_corpemail = '".$cemail."', 	
                    emp_corpapprover = '".$capprover."', ";
            if ($password) :
                $sql .= "emp_password = '".md5($password)."', ";
            endif;
            if ($content) :
                $sql .= "emp_piccontent = '".$content."', 	
                        emp_picfilename = '".$binFile_name."', 	
                        emp_picsize = '".$binFile_size."', 	
                        emp_picfiletype = '".$binFile_type."', ";
            endif;
            $sql .= "emp_dateupdate = ".date("U").", 	
                    emp_status = 1 ";
			
			if($this->db_query($sql)) :
                if ($password) :
                    $sqlpass = "UPDATE tbl_emplist SET emp_password = '".md5($password)."' 
                        WHERE emp_id = ".$eid;
                    $update_pass = $this->db_query($sqlpass);
                endif;        
				return TRUE;
			else :
				return FALSE;
			endif;			
		endif;
	}
	
	function add_member($post)
	{		
		if(is_array($post)) :			
			$input = array();
			foreach($post as $key => $value) :
                if ($key != 'content') : $input[$key] = mysql_escape_string($value); 
                else : $input[$key] = $value;
                endif;
			endforeach;
			
			extract($input);			
			
			$sql = "INSERT INTO tbl_emplist SET
                    emp_idnum = '".$empnum."',
                    emp_idhash = '".md5($empnum)."',
                    emp_password = '".md5($passwordgen)."',
                    emp_position = '".$postapp."',
                    emp_datehired = '".$datehired."',
                    emp_lastname = '".$lastname."',	
                    emp_firstname = '".$firstname."', 	
                    emp_middlename = '".$middlename."', 
                    emp_suffixname = '".$suffixname."', 	
                    emp_nickname = '".$nickname."', 	
                    emp_addressnum = '".$addressnumber."',
                    emp_addressstreet = '".$addressstreet."',
                    emp_addressbrgy = '".$addressbrgy."',
                    emp_addresscity = '".$addresscity."',
                    emp_addressregion = '".$addressregion."',
                    emp_addresszip = '".$addresszip."',
                    emp_addresscountry = '".$addresscountry."', 	
                    emp_address2 = '".$provincialaddress."', 	
                    emp_contact = '".$contactno."', 	
                    emp_email = '".$email."', 	
                    emp_bday = '".$birthday."', 	
                    emp_bplace = '".$birthplace."', 
                    emp_sex = '".$sex."', 	
                    emp_civil = '".$civil."', 	
                    emp_sss = '".$sss."', 	
                    emp_tin = '".$tin."', 	
                    emp_philhealth = '".$philhealth."', 	
                    emp_pagibig = '".$hdmf."', 	
                    emp_spousename = '".$spouse."', 	
                    emp_spousebday = '".$sbday."', 	
                    emp_spousecompany = '".$scomp."', 	
                    emp_spousework = '".$soccupation."', 	
                    emp_children = '".$children_data."', 	
                    emp_fathername = '".$father."', 	
                    emp_fatherbday = '".$fbday."',
                    emp_fathercompany = '".$fcomp."', 	
                    emp_fatherwork = '".$foccupation."', 	
                    emp_mothername = '".$mother."', 	
                    emp_motherbday = '".$mbday."', 	
                    emp_mothercompany = '".$mcomp."', 	
                    emp_motherwork = '".$moccupation."', 	
                    emp_brosis = '".$brosis_data."', 	
                    emp_relativename = '".$relatives."', 	
                    emp_relativerelation = '".$relationship."', 	
                    emp_relativecompany = '".$relcomp."',	
                    emp_relativeposition = '".$relposition."', 	
                    emp_schoolname = '".$school."', 	
                    emp_schoolfrom = '".$from."', 	
                    emp_schoolto = '".$to."', 	
                    emp_schooldegree = '".$degree."', 	
                    emp_govlic = '".$govlic_data."', 	
                    emp_seminar = '".$seminar_data."',	
                    emp_skill = '".$otherskills."', 	
                    emp_organization = '".$organization."', 	
                    emp_history = '".$hcomp."', 	
                    emp_emergencyname = '".$emergency."', 	
                    emp_emergencyadd = '".$eadd."', 	
                    emp_emergencytelno = '".$ephone."',	
                    emp_corpdiv = '".$cdiv."', 	
                    emp_corpgrp = '".$cgrp."', 	
                    emp_corpdept = '".$cdept."',
                    emp_corpsec = '".$csec."', 	 	
                    emp_corptel = '".$cphone."', 	
                    emp_corpemail = '".$cemail."', 	 	
                    emp_piccontent = '".$content."', 	
                    emp_picfilename = '".$binFile_name."', 	
                    emp_picsize = '".$binFile_size."', 	
                    emp_picfiletype = '".$binFile_type."', 	
                    emp_datecreate = ".date("U").", 	
                    emp_dateupdate = ".date("U").", 	
                    emp_level = ".$elevel.", 	
                    emp_status = 1 ";
			
			if($this->db_query($sql)) :
				return TRUE;
			else :
				return FALSE;
			endif;			
		endif;
	}
    
    function change_password($newpassword, $empidnum)
    {
        $sql = "UPDATE tbl_emplist SET
            emp_password = '".md5($newpassword)."',
            emp_dateupdate = ".date("U")."
            WHERE emp_idnum = '".$empidnum."'";
        
        if($this->db_query($sql)) : 
            return TRUE;
        else :
            return FALSE;
        endif;			
        
    }  

	function mailthis($post)
	{
		if(is_array($post))
		{
			
			$input = array();
			foreach($post as $key => $value) {
				$input[$key] = mysql_escape_string($value);
			}
			
			extract($input);
		
			$to  = $email; 				
			$subject = 'Megaworld New Account Password';
		
			$message = '
			<html>
			<head>
			  <title>Megaworld New Account Password</title>
			</head>
			<body>
			  <p>Hi '.$fname.'</p>
			  <p>It seems that you have asked for us to send you your password.</p>
			  <p>Below is the information that you will need to login to the site and forums.</p>
			  <p>Username: '.$uname.'<br />Password: '.$pass.'<br />E-Mail Address: '.$email.'</p>
			</body>
			</html>
			';
		
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";		
			$headers .= 'To: '.$fname.' '.$lname.' <'.$email.'>' . "\r\n";
			$headers .= 'From: Megaworld Admin <admin@megaworld.com.ph>' . "\r\n";
		
			mail($to, $subject, $message, $headers);
			
		}
	}
    
    function random_password() {
	    $alphabet = array('a','b','c','d','e','f','g','h','i','j','k','m','n','p','r','s','t','u','v','x','y','z','1','2','3','4','5','6','7','8','9');
	    $pass = "";
	    for ($i = 0; $i < 8; $i++) {
	        $n = rand(0, count($alphabet)-1);
	        $pass .= $alphabet[$n];
	    }
	    return $pass;
	}

}

?>