<?php

class cloud {
    
    public function db_connect() //connect to database
	{
        $result = mssql_connect(DBHOST, DBUSER, DBPASS);
        if(!$result) return false;
        else return $result;
	}  
    public function db_select($con) //connect to database
	{
        $result = mssql_select_db(DBCLOUD, $con);
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
    
	public function get_row($sql)
	{
        if(!$sql) return;
        $con = $this->db_connect();
        $seltab = $this->db_select($con);
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
    
    public function get_execute($sql) //Get num rows of a table from $sql
	{
        if(!$sql) return;
        $con = $this->db_connect();
        $seltab = $this->db_select($con);
        $result = mssql_query($sql);
        if(!$result) return;
        return $result;
	}
	
	# MAINSQL CLASS
    
    function get_sp_data_status($sp_name, $parameters = NULL)
	{        
        // TYPE:
        // 1 - array
        // 2 - num_row
        
        $status = 0;
        $con = $this->db_connect();
        
        $stmt = mssql_init(DBNAME.'.dbo.'.$sp_name, $con);
        
        if ($parameters) :
            foreach ($parameters as $key => $value) :
                //var_dump($value);
                mssql_bind($stmt, '@'.$value['field_name'], $value['field_value'], $value['field_type'], $value['field_isoutput'], $value['field_isnull'], $value['field_maxlen']);
            endforeach;
        endif;
        
        $status = "failed";
        mssql_bind($stmt, '@STATUS', $status, SQLVARCHAR, true);

        $query = mssql_execute($stmt);
        
        $result = $status;
        
		return $result;
	}		
    
     function get_sp_data($sp_name, $parameters = NULL)
	{        
        // TYPE:
        // 1 - array
        // 2 - num_row
        
        $status = 0;
        $con = $this->db_connect();
        
        $stmt = mssql_init(DBNAME.'.dbo.'.$sp_name, $con);
        
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
    
    function get_employee($start = 0, $limit = 0, $search = NULL, $count = 0)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY LName ASC) as ROW_NUMBER, ";
        $sql .= " EmpID, FName, MName, LName, NickName, EmailAdd, CompanyID, 
            SSSNbr, PhilHealthNbr, TINNbr, PagibigNbr, TaxID, LocationID, AccountNo, EPassword
            FROM VIEWHREMPMASTER ";  
        $sql .= " WHERE EmpID != '' ";      
        if ($search != NULL) : $sql .= " AND (EmpID = '".$search."' OR LName LIKE '%".$search."%' OR FName LIKE '%".$search."%') "; endif;        
        $sql .= " AND EmpStatus != 'RS'";
        $sql .= ") AS [outer] ";
        if ($limit) : 
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;
        
		if ($count) : $result = $this->get_numrow($sql);			
        else : $result = $this->get_row($sql);			
        endif;
		return $result;
	}	
    
    function get_users_email($start = 0, $limit = 0, $search = NULL, $count = 0)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY LName ASC) as ROW_NUMBER, ";
        $sql .= " EmpID, FName, MName, LName, NickName, EmailAdd
            FROM VIEWHREMPMASTER ";          
        $sql .= " WHERE Active = 1";
        $sql .= ") AS [outer] ";
        if ($limit) : 
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

		if ($count != 0) $result = $this->get_numrow($sql);	
        else $result = $this->get_row($sql);		
			
		return $result;
	}
    
    function get_approvers($empid, $count = 0)
	{
		$sql = "SELECT DISTINCT TYPE, SIGNATORY1, SIGNATORY2, SIGNATORY3, SIGNATORY4, SIGNATORY5, SIGNATORY6, SIGNATORYID1, SIGNATORYID2, SIGNATORYID3, SIGNATORYID4, SIGNATORYID5, SIGNATORYID6, TYPE FROM GLMEmpSignatory WHERE EMPID = '".$empid."' AND (TYPE = 'frmApplicationLVWeb' OR TYPE = 'frmApplicationOTWeb' OR TYPE = 'frmApplicationOBWeb' OR TYPE = 'frmApplicationMDWeb' OR TYPE = 'frmApplicationNPWeb' OR TYPE = 'frmApplicationSCWeb')   ";
		if ($count) : $result = $this->get_numrow($sql);			
        else : $result = $this->get_row($sql);			
        endif;
		return $result;
	}	
    
    function get_recent_noti($empid = NULL)
	{
        $sql = "SELECT ";
        $sql .= " DateFiled, DocType, Reference, ApprovedDate01, ApprovedDate02, ApprovedDate03, ApprovedDate04, ApprovedDate05, ApprovedDate06,
            Signatory01, Signatory02, Signatory03, Signatory04, Signatory05, Signatory06, Approved, APPROVALDATE FROM TED_VIEW_NOTIFICATION ";
        $sql .= " WHERE EmpID != NULL ";
        if ($empid != NULL) : $sql .= " AND (EmpID = '".$empid."' OR Signatory01 = '".$empid."' OR Signatory02 = '".$empid."' OR Signatory03 = '".$empid."' OR Signatory04 = '".$empid."' OR Signatory05 = '".$empid."' OR Signatory06 = '".$empid."') "; endif;        
        $sql .= " AND (DateFiled BETWEEN '".date('Y-m-d')." 00:00:00.000' AND '".date('Y-m-d')." 23:59:59.000' OR ApprovedDate01 BETWEEN '".date('Y-m-d')." 00:00:00.000' AND '".date('Y-m-d')." 23:59:59.000' OR ApprovedDate02 BETWEEN '".date('Y-m-d')." 00:00:00.000' AND '".date('Y-m-d')." 23:59:59.000' OR ApprovedDate03 BETWEEN '".date('Y-m-d')." 00:00:00.000' AND '".date('Y-m-d')." 23:59:59.000' OR ApprovedDate04 BETWEEN '".date('Y-m-d')." 00:00:00.000' AND '".date('Y-m-d')." 23:59:59.000' OR ApprovedDate05 BETWEEN '".date('Y-m-d')." 00:00:00.000' AND '".date('Y-m-d')." 23:59:59.000' OR ApprovedDate06 BETWEEN '".date('Y-m-d')." 00:00:00.000' AND '".date('Y-m-d')." 23:59:59.000') "; 
        $result = $this->get_numrow($sql);			
		return $result;
    }
    
    /* NOTIFICATION */
    
    
    function get_notification($id = NULL, $start = 0, $limit = 0, $search = NULL, $count = 0, $empid = NULL, $from = NULL, $to = NULL, $dtype = NULL)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY DateFiled DESC) as ROW_NUMBER, ";
        $sql .= " EmpID, DateFiled, DocType, Reference, ApprovedDate01, ApprovedDate02, ApprovedDate03, ApprovedDate04, ApprovedDate05, ApprovedDate06,
            Signatory01, Signatory02, Signatory03, Signatory04, Signatory05, Signatory06, 
            Remarks01, Remarks02, Remarks03, Remarks04, Remarks05, Remarks06, Approved, RejectedDate, POSTEDDATE, APPROVALDATE FROM TED_VIEW_NOTIFICATION ";        
        $sql .= " WHERE EmpID != NULL ";
        if ($id != NULL) : $sql .= " AND Reference = '".$id."' "; endif;        
        if ($search != NULL) : $sql .= " AND (Reference LIKE '%".$search."%' OR EmpID LIKE '%".$search."%' OR FULLNAME LIKE '%".$search."%') "; endif;        
        if ($dtype != NULL) : $sql .= " AND DocType = '".$dtype."' "; endif;        
        if ($empid != NULL) : $sql .= " AND ((EmpID = '".$empid."') OR (Signatory01 = '".$empid."' OR Signatory02 = '".$empid."' OR Signatory03 = '".$empid."' OR Signatory04 = '".$empid."' OR Signatory05 = '".$empid."' OR Signatory06 = '".$empid."') AND Approved != 3) "; endif;           
        if ($from && $to) : 
            $sql .= " AND DateFiled BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' "; 
        endif; 
        $sql .= ") AS [outer] ";
        if ($limit) : 
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;
        
        /*$sql .= " ORDER BY DateFiled DESC ";        
        if ($limit) : 
            $sql .= " OFFSET ".$start." ROWS "; 
            $sql .= " FETCH NEXT ".$limit." ROWS ONLY ";
        endif;*/
        
        if ($count) : $result = $this->get_numrow($sql);			
        else : $result = $this->get_row($sql);			
        endif;
		return $result;
	}
    
    function get_pendingnoti($id = NULL, $start = 0, $limit = 0, $search = NULL, $count = 0, $empid = NULL, $from = NULL, $to = NULL, $dtype = NULL)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY DateFiled DESC) as ROW_NUMBER, ";
        $sql .= " EmpID, DateFiled, DocType, Reference, ApprovedDate01, ApprovedDate02, ApprovedDate03, ApprovedDate04, ApprovedDate05, ApprovedDate06,
            Signatory01, Signatory02, Signatory03, Signatory04, Signatory05, Signatory06, Approved, POSTEDDATE FROM TED_VIEW_NOTIFICATION2 ";
        $sql .= " WHERE EmpID != NULL AND Approved = 0 ";
        if ($id != NULL) : $sql .= " AND Reference = '".$id."' "; endif;        
        if ($search != NULL) : $sql .= " AND (Reference LIKE '%".$search."%' OR EmpID LIKE '%".$search."%' OR FULLNAME LIKE '%".$search."%') "; endif;        
        if ($dtype != NULL) : $sql .= " AND DocType = '".$dtype."' "; endif;        
        if ($empid != NULL) : $sql .= " AND ((EmpID = '".$empid."') OR (Signatory01 = '".$empid."' OR Signatory02 = '".$empid."' OR Signatory03 = '".$empid."' OR Signatory04 = '".$empid."' OR Signatory05 = '".$empid."' OR Signatory06 = '".$empid."') AND Approved != 3) "; endif;           if ($from && $to) : 
            $sql .= " AND DateFiled BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' "; 
        endif; 
        $sql .= ") AS [outer] ";
        if ($limit) : 
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;
        
        /*$sql .= " ORDER BY DateFiled DESC ";        
        if ($limit) : 
            $sql .= " OFFSET ".$start." ROWS "; 
            $sql .= " FETCH NEXT ".$limit." ROWS ONLY ";
        endif;*/
        
        if ($count) : $result = $this->get_numrow($sql);			
        else : $result = $this->get_row($sql);			
        endif;
		return $result;
	}
    
    # REPLACE 1900 to 1971
    
    function remove1900($datestring) {
        $newdate = str_replace("1900", "1971", $datestring);
        
        return $newdate;
    }
    
    # MISCELLEANNOUS
	
	function pagination($section, $record, $limit, $range = 9, $idnum = 0) {
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
            if(!$paged) {
                $paged = 1;
            }

            // On the first page, don't put the First page link
            if($paged != 1) {
                $pagetxt .= "<a href='".$web_root."/".$section."/page/1".($idnum ? "?id=".$idnum : "")."' class='whitetext nodecor'><i class='fa fa-lg fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;</a>";
                $prev_var = $_GET['page'] ? $_GET['page'] - 1 : "0"; //previous page_num
                $pagetxt .= "<a href='".$web_root."/".$section."/page/".$prev_var."".($idnum ? "?id=".$idnum : "")."' class='whitetext nodecor'>Previous&nbsp;&nbsp;&nbsp;</a>";
            }

            // We need the sliding effect only if there are more pages than is the sliding range
            if($max_page > $range) {
                // When closer to the beginning
                if($paged < $range) {
                    for($i = 1; $i <= ($range + 1); $i++) {
                        $pagetxt .= "<a href='".$web_root."/".$section."/page/".$i."".($idnum ? "?id=".$idnum : "")."' class='nodecor'>";
                        if($i==$paged) $pagetxt .= "<div class = 'pageactive dgraytext'>".$i."</div>";
                        else $pagetxt .= "<div class = 'pagelink whitetext'>".$i."</div>";				
                        $pagetxt .= "</a>";
                    }
                }
                // When closer to the end
                elseif($paged >= ($max_page - ceil(($range/2)))) {
                    for($i = $max_page - $range; $i <= $max_page; $i++) {
                        $pagetxt .= "<a href='".$web_root."/".$section."/page/".$i."".($idnum ? "?id=".$idnum : "")."' class='nodecor'>";
                        if($i==$paged) $pagetxt .= "<div class = 'pageactive dgraytext'>".$i."</div>";
                        else $pagetxt .= "<div class = 'pagelink whitetext'>".$i."</div>";				
                        $pagetxt .= "</a>";
                    }
                }
                // Somewhere in the middle
                elseif($paged >= $range && $paged < ($max_page - ceil(($range/2)))) {
                    for($i = ($paged - ceil($range/2)); $i <= ($paged + ceil(($range/2))); $i++) {
                        $pagetxt .= "<a href='".$web_root."/".$section."/page/".$i."".($idnum ? "?id=".$idnum : "")."' class='nodecor'>";
                        if($i==$paged) $pagetxt .= "<div class = 'pageactive dgraytext'>".$i."</div>";
                        else $pagetxt .= "<div class = 'pagelink whitetext'>".$i."</div>";				
                        $pagetxt .= "</a>";
                    }
                }
            }
            // Less pages than the range, no sliding effect needed
            else {
                for($i = 1; $i <= $max_page; $i++) {
                    $pagetxt .= "<a href='".$web_root."/".$section."/page/".$i."".($idnum ? "?id=".$idnum : "")."' class='nodecor'>";
                    if($i==$paged) $pagetxt .= "<div class = 'pageactive dgraytext'>".$i."</div>";
                    else $pagetxt .= "<div class = 'pagelink whitetext'>".$i."</div>";				
                    $pagetxt .= "</a>";
                }
            }


            // On the last page, don't put the Last page link
            if($paged != $max_page) {
                $next_var= $_GET['page'] ? $_GET['page'] + 1 : "2"; //next page_num
                $pagetxt .= "<a href='".$web_root."/".$section."/page/".$next_var."".($idnum ? "?id=".$idnum : "")."' class = 'whitetext nodecor'>&nbsp;&nbsp;&nbsp;Next</a>";
                $pagetxt .= "<a href='".$web_root."/".$section."/page/".$max_page."".($idnum ? "?id=".$idnum : "")."' class = 'whitetext nodecor'>&nbsp;&nbsp;&nbsp;<i class='fa fa-lg fa-angle-double-right'></i></a>";
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
    
    function cleanstring($input) {
        $input = str_replace(' ', '-', $input);
        $input = str_replace('.', '', $input);
        $input = str_replace(',', '', $input);
        echo preg_replace('@[^0-9A-Za-z\.]+@i', '', $input);
    }
    
    function cleanstring2($input) {
        $input = str_replace(' ', '-', $input);
        $input = str_replace('.', '', $input);
        $input = str_replace(',', '', $input);
        $input = str_replace(':', '', $input);
        return $input;
    }
    
    function cleannxtline($input) {
        return addslashes(trim(preg_replace('/\r|\n/', ' ', str_replace("'", "&rsquo;", $input))));
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
	
	function filter_bad_comments($comment)
	{		
		
        $replace_with = "***THIS COMMENT HAS BEEN DELETED DUE TO VIOLATION OF MEGAWORLD IHR TERMS AND CONDITIONS.***";

		$badwords = array( "pokpok", " kupal ", " slut\."," kups ", "fucker"," slut ", " pucha ", " tae ", "bullshit", "shit", " shit\.", " gago ", " puta ", " tangina ", " tonto ", " tang ", " asshole ", "fuck", "pekpek", " titi ", " etits ", " tits ", " penis ", " vagina ", "pudayday", " puday ", " kepyas ", "kepkep", " dede ", "tarantado", "bitch", " hosto ", " Ass ", "Ass wipe", "Biatch", " Bitches ", "Biatches", "Beyotch", "Bulbol", "Bolbol",  " Boobs ", " Cunt ", "Callboy", "Callgirl", " Clit ", " Douche bag ", "Dumb ass", " Dodo ", " Dipshit ", " Dung face ", " Echas ", " Fag ", " Hoe ", " Hooker ", "Jakol", "Jackol", " Kunt ", "Kantot", "Putang ina", " Pussy ", " Prat ", " Prick ", " Satan ", " Shit ", " Ulol ", " puke ", " puki ", "kakantutin", "kakantuten", "makantot", " Ass "," Echas "," Tits ","Asshole","Fuck","Tang ina"," Ass wipe "," Fag ", "tarantado"," Bitch "," Gago ","Biatch"," Ulol "," Bitches "," Ulul "," Biatches "," Gagi "," Utong ","Beyotch"," Hoe ","Beeyotch"," Hooker ","bulbol", "haliparot"," Bolbol "," Jakol "," Boobs "," Jackol ","Bullshit"," Kunt ","Kantot"," Cunt "," Nigger ","Pakshit","Pokpok","Putang ina","Callboy"," Puta ","Callgirl"," Puerta "," Clit "," Pwerta ","Chimi a a"," Pussy ","Douche bag"," Prat "," Prick ","Dumb ass"," Satan "," Dodo "," Doofus "," Shit ","Dipshit"," Dung face "," ebs ","kanguso","kapangilya","p0kp0k","p0t@"," fcuk "," pwet "," pwit ","haliparot","lawlaw", "pokpok", "Pokpok", "showbizjuice", " Pwe ", "Pweh", " pwe ", "pwe\!", "pweh", "fuck ", " fuck", "Fuck ", " Fuck", " fuck ", " Fuck ", "fuck", "Fuck", " Faggot ", " faggot ", "Faggot ", "faggot ", " Faggot", " faggot", " echusera ", " Echusera ", " Ngoyngoy ", " ngoyngoy ", "Ngoyngoy ", "ngoyngoy ", " Ngoyngoy", " ngoyngoy", "Ngoyngoy", "ngoyngoy", "pwe ", "pwe.", " che ", " bitch\.", "crap");	
	
		$bw_exp = "";
		$badword_match = 0;
		foreach ($badwords as $badwords_exp) :
            $bw_exp = "/".$badwords_exp."/i";		
			if (preg_match($bw_exp, $comment)) :
				$badword_match = $badword_match + 1;
			endif;
		endforeach;	
			
		if ($badword_match > 0) :
			return $replace_with;
		else :
			return $comment;
		endif;
	
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