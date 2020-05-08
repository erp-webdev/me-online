<?php

class main {
	
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
    
    function get_data($id = 0, $start = 0, $limit = 0, $search = NULL, $count = 0, $random = 0, $not_all = 0)
	{
        
		$sql="SELECT a.activity_id, a.activity_title, a.activity_description, a.activity_venue, a.activity_datestart, a.activity_dateend, 
			a.activity_approve, a.activity_guest, a.activity_dependent, a.activity_cvehicle, a.activity_slots, a.activity_user ";
		$sql.=" FROM tbl_activity a
			WHERE a.activity_status = 1";
		if ($search != NULL) $sql.=" AND a.activity_title LIKE '%".$search."%'";
		if ($id != 0) $sql.=" AND a.activity_id = ".$id;		
		if ($not_all != 0) $sql.=" AND a.activity_dateend >= UNIX_TIMESTAMP()";
        if ($random != 0) :
            $sql .= " ORDER BY RAND() ";
            $sql.=" LIMIT 0, 5 ";	
        else :
            $sql .= " ORDER BY a.activity_datestart DESC ";
            if ($limit != 0) $sql.=" LIMIT ".$start.", ".$limit;	
        endif;

		if ($count != 0) $result = $this->get_numrow($sql);	
        else $result = $this->get_row($sql, 1);	
			
		return $result;
	}
    
    function get_registration($id = 0, $start = 0, $limit = 0, $count = 0, $uid = 0)
	{
        
		$sql="SELECT r.registry_id, a.activity_title, a.activity_venue, a.activity_datestart, a.activity_dateend, 
            r.registry_uid, r.registry_godirectly, r.registry_vrin, r.registry_vrout, 
			r.registry_platenum, r.registry_guest, r.registry_dependent, r.registry_date, r.registry_status ";
		$sql.=" FROM tbl_eventregistry r, tbl_activity a
			WHERE r.registry_status >= 1 
            AND a.activity_id = r.registry_activityid ";
		if ($id != 0) $sql.=" AND r.registry_id = ".$id;
		if ($uid != 0) $sql.=" AND r.registry_uid = ".$uid;
        $sql .= " ORDER BY r.registry_date DESC ";
        if ($limit != 0) $sql.=" LIMIT ".$start.", ".$limit;	

		if ($count != 0) $result = $this->get_numrow($sql);	
        else $result = $this->get_row($sql, 1);	
			
		return $result;
	}
    
    function chk_registered($actid, $uid)
	{
        
		$sql="SELECT r.registry_id ";
		$sql.=" FROM tbl_eventregistry r
			WHERE r.registry_status >= 1 
            AND r.registry_activityid = ".$actid."
            AND r.registry_uid = ".$uid;

		$result = $this->get_numrow($sql);	
			
		return $result;
	}
    
    function cnt_registered($actid)
	{
        
		$sql="SELECT r.registry_guest, r.registry_dependent ";
		$sql.=" FROM tbl_eventregistry r
			WHERE r.registry_status >= 1 
            AND r.registry_activityid = ".$actid;

		$result = $this->get_row($sql, 1);	
			
		return $result;
	}
    
    function get_users($id = 0, $start = 0, $limit = 0, $search, $count = 0, $nameid = 0, $profile_id = 0, $approver_id = 0, $status = 0, $level = 0)
	{
		$sql= "SELECT e.emp_id, e.emp_level, e.emp_idnum, e.emp_password, e.emp_firstname, e.emp_middlename, e.emp_lastname, e.emp_suffixname, e.emp_nickname, e.emp_corptel, e.emp_corpemail, d.dept_name, e.emp_status ";
		$sql.= " FROM tbl_emplist e, tbl_dept d ";
		if ($status != 0) : $sql.= " WHERE e.emp_status = ".$status." ";
        else : $sql.= " WHERE e.emp_status >= 1 "; endif;
        $sql.= " AND d.dept_id = e.emp_corpdept ";
		if ($search != NULL) $sql.=" AND (e.emp_firstname LIKE '%".$search."%' OR e.emp_lastname LIKE '%".$search."%' OR e.emp_idnum LIKE '%".$search."%' )";
		if ($id != 0) $sql.=" AND e.emp_id = ".$id;
		if ($nameid != 0) $sql.=" AND e.emp_idnum = '".$nameid."'";
		if ($profile_id != 0) $sql.=" AND e.emp_id != ".$profile_id." AND e.emp_level < 9 ";
		if ($approver_id != 0) $sql.=" AND e.emp_id != ".$approver_id." AND e.emp_corpapprover = ".$approver_id." ";
		if ($level != 0) $sql.=" AND e.emp_level = ".$level;
		$sql.=" ORDER BY e.emp_datecreate DESC ";
		if ($limit != 0) $sql.=" LIMIT ".$start.", ".$limit;

		if ($count != 0) $result = $this->get_numrow($sql);	
        else $result = $this->get_row($sql, 1);		
			
		return $result;
	}
    
    function get_position($id = 0, $name = NULL, $start = 0, $limit = 0, $search = NULL, $count = 0, $max = 0)
	{
        
		$sql = "SELECT ".($max ? " MAX(position_id) AS posid " : " p.position_id, p.position_description ");
		$sql .= " FROM tbl_position p ";
		if ($search != NULL || $id != 0) $sql .= " WHERE p.position_description != NULL ";
		if ($search != NULL) $sql .= " AND p.position_description LIKE '%".$search."%' ";
		if ($id != 0) $sql .= " AND p.position_id = ".$id;
		if ($name != NULL) $sql .= " AND p.position_description = ".$name;
        $sql .= " ORDER BY position_description ASC ";
		if ($limit != 0) $sql .= " LIMIT ".$start.", ".$limit;	

		if ($count != 0) $result = $this->get_numrow($sql);	
        else $result = $this->get_row($sql, 1);	
			
		return $result;
	}
    
    function get_division($id = 0, $name = NULL, $start = 0, $limit = 0, $search = NULL, $count = 0)
	{
        
		$sql = "SELECT d.div_id, d.div_name ";
		$sql .= " FROM tbl_division d ";
		$sql .= " WHERE d.div_status = 2 ";
		if ($search != NULL) $sql .= " AND d.div_name LIKE '%".$search."%' ";
		if ($id != 0) $sql .= " AND d.div_id = ".$id;
		if ($name != NULL) $sql .= " AND d.div_name = ".$name;
        $sql .= " ORDER BY d.div_name ASC ";
		if ($limit != 0) $sql .= " LIMIT ".$start.", ".$limit;	

		if ($count != 0) $result = $this->get_numrow($sql);	
        else $result = $this->get_row($sql, 1);	
			
		return $result;
	}
    
    function get_dept($id = 0, $name = NULL, $start = 0, $limit = 0, $search = NULL, $count = 0, $div = 0)
	{
        
		$sql = "SELECT d.dept_id, d.dept_name, d.dept_acronym, d.dept_local ";
		$sql .= " FROM tbl_dept d ";
		$sql .= " WHERE d.dept_status = 2 ";
		if ($search != NULL) $sql .= " AND (d.dept_name LIKE '%".$search."%' OR d.dept_acronym LIKE '%".$search."%') ";
		if ($id != 0) $sql .= " AND d.dept_id = ".$id;
		if ($name != NULL) $sql .= " AND d.dept_name = '".$name."' ";
		if ($div != 0) $sql .= " AND d.dept_divid = ".$div;
        $sql .= " ORDER BY d.dept_name ASC ";
		if ($limit != 0) $sql .= " LIMIT ".$start.", ".$limit;	

		if ($count != 0) $result = $this->get_numrow($sql);	
        else $result = $this->get_row($sql, 1);	
			
		return $result;
	}
    
    function get_dgroup($id = 0, $name = NULL, $start = 0, $limit = 0, $search = NULL, $count = 0, $div = 0)
	{
        
		$sql = "SELECT d.dgroup_id, d.dgroup_name ";
		$sql .= " FROM tbl_divgroup d ";
		$sql .= " WHERE d.dgroup_status = 2 ";
		if ($search != NULL) $sql .= " AND d.dgroup_name LIKE '%".$search."%' ";
		if ($id != 0) $sql .= " AND d.dgroup_id = ".$id;
		if ($name != NULL) $sql .= " AND d.dgroup_name = '".$name."' ";
		if ($div != 0) $sql .= " AND d.dgroup_divid = ".$div;
        $sql .= " ORDER BY d.dgroup_name ASC ";
		if ($limit != 0) $sql .= " LIMIT ".$start.", ".$limit;	

		if ($count != 0) $result = $this->get_numrow($sql);	
        else $result = $this->get_row($sql, 1);	
			
		return $result;
	}
    
    function get_section($id = 0, $name = NULL, $start = 0, $limit = 0, $search = NULL, $count = 0, $dept = 0)
	{
        
		$sql = "SELECT s.sec_id, s.sec_name ";
		$sql .= " FROM tbl_deptsection s ";
		$sql .= " WHERE s.sec_status = 2 ";
		if ($search != NULL) $sql .= " AND s.sec_name LIKE '%".$search."%' ";
		if ($id != 0) $sql .= " AND s.sec_id = ".$id;
		if ($name != NULL) $sql .= " AND s.sec_name = '".$name."' ";
		if ($dept != 0) $sql .= " AND s.sec_deptid = ".$dept;
        $sql .= " ORDER BY s.sec_name ASC ";
		if ($limit != 0) $sql .= " LIMIT ".$start.", ".$limit;	

		if ($count != 0) $result = $this->get_numrow($sql);	
        else $result = $this->get_row($sql, 1);	
			
		return $result;
	}
	
	function get_set($count = 0)
	{
		$sql="SELECT s.set_announce, s.set_mailfoot, s.set_numrows
			FROM tbl_setting s
            LIMIT 0, 1";

        if ($count == 1) $result = $this->get_numrow($sql);			
		else $result = $this->get_row($sql, 1);			
			
		return $result;
	}
    
    # ACTIONS
    
    function data_action($value, $files, $action, $id = 0)
	{
        $value = $value ? extract($value) : NULL;
        $files = $files ? extract($files) : NULL;

		switch ($action) {
            case 'register':	

                $sql="INSERT INTO tbl_eventregistry 
                    (registry_id, registry_activityid, registry_uid, registry_godirectly, registry_vrin, registry_vrout, registry_platenum, registry_dependent, registry_guest, registry_date, registry_status)
                    VALUES
                    ('', '".$registry_activityid."', '".$registry_uid."', ".($registry_godirectly ? 1 : 0).", ".($registry_vrin ? 1 : 0).", ".($registry_vrout ? 1 : 0).", '".($registry_platenum ? $registry_platenum : NULL)."', ".$registry_dependent.", ".$registry_guest.", UNIX_TIMESTAMP(), ".$registry_status.")";				

                $lastid = $this->db_insert($sql);

                if($lastid) {
                    return $lastid;
                } else {
                    return FALSE;
                }

			break;
            
			case 'add':	
            
                $actin = strtotime($activity_date.' '.$activity_timein);
				$actout = strtotime($activity_date.' '.$activity_timeout);

                $sql="INSERT INTO tbl_activity 
                    (activity_id, activity_title, activity_description, activity_venue, activity_datestart, activity_dateend, activity_approve, activity_guest, activity_dependent, activity_cvehicle, activity_slots, activity_image, activity_date, activity_status)
                    VALUES
                    ('', '".$activity_title."', '".$activity_description."', '".$activity_venue."', ".$actin.", ".$actout.", ".($activity_approve ? 1 : 0).", ".($activity_guest ? 1 : 0).", ".($activity_dependent ? 1 : 0).", ".($activity_cvehicle ? 1 : 0).", ".$activity_slots.", '".$filetemp."', UNIX_TIMESTAMP(), 1)";				

                $lastid = $this->db_insert($sql);

                if($lastid) {
                    return $lastid;
                } else {
                    return FALSE;
                }

			break;
            
            case 'update':	
            
                $actin = strtotime($activity_date.' '.$activity_timein);
				$actout = strtotime($activity_date.' '.$activity_timeout);

                $sql="UPDATE tbl_activity 
                    SET activity_title = '".$activity_title."', 
                    activity_description = '".$activity_description."', 
                    activity_venue = '".$activity_venue."', 
                    activity_datestart = ".$actin.", 
                    activity_dateend = ".$actout.", 
                    activity_approve = ".($activity_approve ? 1 : 0).", 
                    activity_guest = ".($activity_guest ? 1 : 0).", 
                    activity_dependent = ".($activity_dependent ? 1 : 0).", 
                    activity_cvehicle = '".($activity_cvehicle ? 1 : 0)."', 
                    activity_slots = ".$activity_slots.", 
                    activity_date = UNIX_TIMESTAMP()
                    WHERE activity_id = ".$id;				

                $update_act = $this->db_query($sql);

                if($update_act) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;
            
            case 'update_image':	

                $sql="UPDATE tbl_activity 
                    SET activity_image = '".$filetemp."'
                    WHERE activity_id = ".$id;				

                $update_img = $this->db_query($sql);

                if($update_img) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;
            
            case 'delete':	

                $sql="UPDATE tbl_activity 
                    SET activity_status = 0
                    WHERE activity_id = ".$id;				

                $delete_act = $this->db_query($sql);

                if($delete_act) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;
            
            case 'delreg':	

                $sql="UPDATE tbl_eventregistry 
                    SET registry_status = 0
                    WHERE registry_id = ".$id;				

                $delete_reg = $this->db_query($sql);

                if($delete_reg) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;
		}
	}   
    
    function position_action($value, $action, $id = 0)
	{

		switch ($action) {
			case 'add':	

                $sql="INSERT INTO tbl_position
                    (position_id, position_description)
                    VALUES
                    ('".$id."', '".$value."')";				

                $addpos = $this->db_insert($sql);

                if($addpos) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;
		}
	}
    
    function user_action($value, $action, $id = 0)
	{
        $value = $value ? extract($value) : NULL;

		switch ($action) {

			case 'delete':

				$sql="UPDATE tbl_emplist SET emp_status = 0
					WHERE emp_id = ".$id;

				if($this->db_query($sql)) {
					return TRUE;
				} else {
					return FALSE;
				}			

			break;

			case 'approve':

				$sql="UPDATE tbl_emplist SET emp_status = ".($_POST['emp_status'] == 2 ? 1 : 2)."
					WHERE emp_id = ".$id;

				if($this->db_query($sql)) {
					if ($_POST['emp_status'] == 2) return 1;
					else return 2;
				} else {
					return FALSE;
				}			

			break;
		}
	}

	
	# MISCELLEANNOUS
	
	function pagination($section, $record, $limit, $range = 9, $idnum = 0){
	  // $paged - number of the current page
	  global $paged;
		$web_root = ROOT;
		
		$pagetxt = "";
		
	  // How much pages do we have?
		$paged = $_GET['page'] ? $_GET['page'] : "1";
	
		$max_num_pages = ceil($record/$limit);
	
		if (!$max_page) {
			$max_page = $max_num_pages;
		}

	  // We need the pagination only if there are more than 1 page
	  if($max_page > 1){
		if(!$paged){
		  $paged = 1;
		}
		
		// On the first page, don't put the First page link
		if($paged != 1){
		  $pagetxt .= "<a href='".$web_root."/".$section."/page/1".($idnum ? "?id=".$idnum : "")."' class='blacktext nodecor'><i class='fa fa-lg fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;</a>";
		  $prev_var = $_GET['page'] ? $_GET['page'] - 1 : "0"; //previous page_num
		  $pagetxt .= "<a href='".$web_root."/".$section."/page/".$prev_var."".($idnum ? "?id=".$idnum : "")."' class='blacktext nodecor'>Previous&nbsp;&nbsp;&nbsp;</a>";
		}
		
		// We need the sliding effect only if there are more pages than is the sliding range
		if($max_page > $range){
		  // When closer to the beginning
		  if($paged < $range){
				for($i = 1; $i <= ($range + 1); $i++){
					$pagetxt .= "<a href='".$web_root."/".$section."/page/".$i."".($idnum ? "?id=".$idnum : "")."' class='nodecor'>";
					if($i==$paged) $pagetxt .= "<div class = 'pageactive whitetext'>".$i."</div>";
					else $pagetxt .= "<div class = 'pagelink blacktext'>".$i."</div>";				
					$pagetxt .= "</a>";
				}
		  }
		  // When closer to the end
		  elseif($paged >= ($max_page - ceil(($range/2)))){
				for($i = $max_page - $range; $i <= $max_page; $i++){
					$pagetxt .= "<a href='".$web_root."/".$section."/page/".$i."".($idnum ? "?id=".$idnum : "")."' class='nodecor'>";
					if($i==$paged) $pagetxt .= "<div class = 'pageactive whitetext'>".$i."</div>";
					else $pagetxt .= "<div class = 'pagelink blacktext'>".$i."</div>";				
					$pagetxt .= "</a>";
				}
		  }
		  // Somewhere in the middle
		  elseif($paged >= $range && $paged < ($max_page - ceil(($range/2)))) {
				for($i = ($paged - ceil($range/2)); $i <= ($paged + ceil(($range/2))); $i++) {
					$pagetxt .= "<a href='".$web_root."/".$section."/page/".$i."".($idnum ? "?id=".$idnum : "")."' class='nodecor'>";
					if($i==$paged) $pagetxt .= "<div class = 'pageactive whitetext'>".$i."</div>";
					else $pagetxt .= "<div class = 'pagelink blacktext'>".$i."</div>";				
					$pagetxt .= "</a>";
				}
		  }
		}
		// Less pages than the range, no sliding effect needed
		else{
		  for($i = 1; $i <= $max_page; $i++){
				$pagetxt .= "<a href='".$web_root."/".$section."/page/".$i."".($idnum ? "?id=".$idnum : "")."' class='nodecor'>";
				if($i==$paged) $pagetxt .= "<div class = 'pageactive whitetext'>".$i."</div>";
				else $pagetxt .= "<div class = 'pagelink blacktext'>".$i."</div>";				
				$pagetxt .= "</a>";
		  }
		}
	
		
		// On the last page, don't put the Last page link
		if($paged != $max_page){
			$next_var= $_GET['page'] ? $_GET['page'] + 1 : "2"; //next page_num
			$pagetxt .= "<a href='".$web_root."/".$section."/page/".$next_var."".($idnum ? "?id=".$idnum : "")."' class = 'blacktext nodecor'>&nbsp;&nbsp;&nbsp;Next</a>";
			$pagetxt .= "<a href='".$web_root."/".$section."/page/".$max_page."".($idnum ? "?id=".$idnum : "")."' class = 'blacktext nodecor'>&nbsp;&nbsp;&nbsp;<i class='fa fa-lg fa-angle-double-right'></i></a>";
		}
	  }
		
		return $pagetxt;
	}
	
	
	
	function curPageURL() 
	{
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	
	function cleanuserinput($input)
	{
		if (get_magic_quotes_gpc()) {
			$clean = mysqli_real_escape_string(stripslashes($input));
		}
		else
		{
			$clean = mysqli_real_escape_string($input);
		}
		return $clean;
	}
	
	function cleanpostvar($getvar)
	{		
		$conn = $this->db_connect();
		$str = $conn->real_escape_string($getvar);
		return $str;
	}

	function cleanpostname($input, $reverse=false)
	{

		if($reverse==true) {
			$str = $input;		
			$str = str_replace("ï¿½", "&rsquo;", $str);
			$str = str_replace("ÃƒÂ©", "&eacute;", $str);
			$str = str_replace("â€¦ ï¿½", "&nbsp;", $str);
			$str = str_replace("â€¦", "&nbsp;", $str);
			$str = str_replace("&amp;", "&", $str);
			$str = str_replace("&quot;", "\"", $str);
			$str = str_replace("&rsquo;", "'", $str);
			$str = str_replace("ï¿½", "&ntilde;", $str);
			$str = str_replace("ï¿½", "&eacute;", $str);			
			$str = str_replace("ï¿½", "&Eacute;", $str);			
			$str = str_replace("ï¿½", "&hellip;", $str);
			$str = str_replace("ï¿½", "&nbsp;", $str);
			$str = str_replace("Ã©", "&eacute;", $str);				
			$str = str_replace("Ã±", "&ntilde;", $str);			
			$str = str_replace("Ã'", "&Ntilde;", $str);			
			$str = str_replace("ï¿½", "&Ntilde;", $str);
			$str = str_replace("&nbsp;", " ", $str);
			$str = str_replace("â€™", "'", $str);			
			$str = stripslashes($str);
		} else {
			$str = stripslashes($input);
			$str = str_replace("&amp;", "&", $str);
			$str = str_replace("&quot;", "\"", $str);
			$str = str_replace("&rsquo;", "'", $str);
			$str = str_replace(" ", "-", $str);
			$str = str_replace("&ntilde;", "n", $str);
			$str = str_replace("&eacute;", "ï¿½", $str);			
			$str = str_replace("&hellip;", "", $str);						
			$str = stripslashes(urldecode(html_entity_decode($str)));
			$str = preg_replace("/[^a-zA-Z0-9-]/", "", urldecode($str));
		}

		return $str;
	}
	
	function get_logs($artid)
	{		
		$sql = "SELECT a.log_content, a.log_date, b.user_firstname, b. user_lastname
			 FROM logs a, users b
			 WHERE b.ID = a.user_id
			 AND a.object_id = $artid
			 AND a.log_status = 1
			 AND a.log_deleted = 0";
		$record = mysqli_query($con, $sql);
		while($row = mysqli_fetch_assoc($record)) {
			$result[] = $row;
		
		}
		mysqli_free_result($record);
		return $result;
	}
	
	function activate_directory_tab($link,$tab)
	{
		if($link == $tab)
		{
			return 'class="dir_link current"';
		}else{
			return 'class="dir_link"';
		}	
	}
	
	function truncate($string, $length)
	{
		if (strlen($string) <= $length) {
			$string = $string; //do nothing
			}
		else {
			$string = wordwrap($string, $length);
			$string = substr($string, 0, strpos($string, "\n"));
			$string .= '...';
		}
		return $string;
	}
	
	function filter_bad_comments($comment, $username=false)
	{
	
		
		if ($username == false)
		{
			$replace_with = "***THIS COMMENT HAS BEEN DELETED DUE TO VIOLATION OF SPOT.PH'S TERMS AND CONDITIONS.***";
		}else{
			$replace_with = "***";
		}

		$badwords = array( "pokpok", " kupal ", " slut\."," kups ", "fucker"," slut ", " pucha ", " tae ", "bullshit", "shit", " shit\.", " gago ", " puta ", " tangina ", " tonto ", " tang ", " asshole ", "fuck", "pekpek", " titi ", " etits ", " tits ", " penis ", " vagina ", "pudayday", " puday ", " kepyas ", "kepkep", " dede ", "tarantado", "bitch", " hosto ", " Ass ", "Ass wipe", "Biatch", " Bitches ", "Biatches", "Beyotch", "Bulbol", "Bolbol",  " Boobs ", " Cunt ", "Callboy", "Callgirl", " Clit ", " Douche bag ", "Dumb ass", " Dodo ", " Dipshit ", " Dung face ", " Echas ", " Fag ", " Hoe ", " Hooker ", "Jakol", "Jackol", " Kunt ", "Kantot", "Putang ina", " Pussy ", " Prat ", " Prick ", " Satan ", " Shit ", " Ulol ", " puke ", " puki ", "kakantutin", "kakantuten", "makantot", " Ass "," Echas "," Tits ","Asshole","Fuck","Tang ina"," Ass wipe "," Fag ","Tarantado"," Bitch "," Gago ","Biatch"," Ulol "," Bitches "," Ulul "," Biatches "," Gagi "," Utong ","Beyotch"," Hoe ","Beeyotch"," Hooker ","Bulbol","Haliparot"," Bolbol "," Jakol "," Boobs "," Jackol ","Bullshit"," Kunt ","Kantot"," Cunt "," Nigger ","Pakshit","Pokpok","Putang ina","Callboy"," Puta ","Callgirl"," Puerta "," Clit "," Pwerta ","Chimi a a"," Pussy ","Douche bag"," Prat "," Prick ","Dumb ass"," Satan "," Dodo "," Doofus "," Shit ","Dipshit"," Dung face "," ebs ","kanguso","kapangilya","p0kp0k","p0t@"," fcuk "," pwet "," pwit ","haliparot","lawlaw", "pokpok", "Pokpok", "showbizjuice", " Pwe ", "Pweh", " pwe ", "pwe\!", "pweh", "fuck ", " fuck", "Fuck ", " Fuck", " fuck ", " Fuck ", "fuck", "Fuck", " Faggot ", " faggot ", "Faggot ", "faggot ", " Faggot", " faggot", " echusera ", " Echusera ", " Ngoyngoy ", " ngoyngoy ", "Ngoyngoy ", "ngoyngoy ", " Ngoyngoy", " ngoyngoy", "Ngoyngoy", "ngoyngoy", "pwe ", "pwe.", " che ", " bitch\.", "crap");	
	
		$bw_exp = "";
		$badword_match = 0;
		foreach ($badwords as $badwords_exp) {
		//echo $value;
		$bw_exp="/" . $badwords_exp ."/i";
		
			if (preg_match($bw_exp, $comment)) {
				$badword_match = $badword_match + 1;
			}
		}	
			
		if($badword_match > 0)
		{
			return $replace_with;
		}else{
			return $comment;
		}
	
	}
	
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