<?php

class mainsql {

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

	public function get_row($sql, $dbname = NULL)
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

    function get_employee($start = 0, $limit = 0, $search = NULL, $count = 0)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY LName ASC) as ROW_NUMBER, ";
        $sql .= " EmpID, FName, MName, LName, NickName, EmailAdd, CompanyID,
            SSSNbr, PhilHealthNbr, TINNbr, PagibigNbr, TaxID, LocationID, AccountNo, EPassword
            FROM viewHREmpMaster ";
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

    function get_appemployee($start = 0, $limit = 0, $search = NULL, $count = 0)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY LName ASC) as ROW_NUMBER, ";
        $sql .= " EmpID, FName, MName, LName, NickName, EmailAdd, CompanyID,
            SSSNbr, PhilHealthNbr, TINNbr, PagibigNbr, TaxID, LocationID, AccountNo, EPassword
            FROM viewHREmpMaster ";
        $sql .= " WHERE EmpID != '' ";
        if ($search != NULL) : $sql .= " AND (EmpID = '".$search."' OR LName LIKE '%".$search."%' OR FName LIKE '%".$search."%') "; endif;
        $sql .= " AND Active = 1";
        $sql .= ") AS [outer] ";
        if ($limit) :
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

		if ($count) : $result = $this->get_numrow($sql);
        else : $result = $this->get_row($sql);
        endif;
		return $result;
	}

    function get_upemployee($start = 0, $limit = 0, $search = NULL, $count = 0)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY LName ASC) as ROW_NUMBER, ";
        $sql .= " EmpID, FName, MName, LName, NickName, EmailAdd, CompanyID,
            SSSNbr, PhilHealthNbr, TINNbr, PagibigNbr, TaxID, LocationID, AccountNo, EPassword
            FROM viewHRUpdateEmpMaster ";
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

    function get_upemployee2($start = 0, $limit = 0, $search = NULL, $count = 0)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY LName ASC) as ROW_NUMBER, ";
        $sql .= " EmpID, LName, FName, MName, NickName, EmailAdd, EmailAdd2, UnitStreet, Barangay, TownCity, StateProvince, Zip, Region, Country, MobileNumber, ContactPerson, ContactAddress, ContactTelNbr, ContactMobileNbr
            FROM HRUpdateEmpMaster ";
        $sql .= " WHERE EmpID != '' ";
        if ($search != NULL) : $sql .= " AND (EmpID = '".$search."' OR LName LIKE '%".$search."%' OR FName LIKE '%".$search."%') "; endif;
        $sql .= ") AS [outer] ";
        if ($limit) :
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

		if ($count) : $result = $this->get_numrow($sql);
        else : $result = $this->get_row($sql);
        endif;
		return $result;
	}

    function get_users_email($start = 0, $limit = 0, $search = NULL, $count = 0, $dbname = NULL)
	{
		$sql = "SELECT [outer].* FROM ( ";

        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY LName ASC) as ROW_NUMBER, ";
        $sql .= " EmpID, FName, MName, LName, NickName, EmailAdd
            FROM viewHREmpMaster ";
        $sql .= " WHERE Active = 1";
        $sql .= ") AS [outer] ";
        if ($limit) :
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

		if ($count != 0) $result = $this->get_numrow($sql);
        else $result = $this->get_row($sql, $dbname);

		return $result;
	}

    function get_users_bydb($id = 0, $dbname = NULL)
	{
        $sql = " SELECT e.EmpID, e.FullName, e.LName, e.FName, e.MName, e.NickName, e.HireDate, e.ContactPerson, e.ContactAddress,
                e.ContactMobileNbr, e.SSSNbr, e.PhilHealthNbr, e.TINNbr, e.PagibigNbr,
                v.DivisionName, d.DeptDesc
                FROM viewHREmpMaster e ";
        $sql .= " LEFT JOIN HRDivision v ON v.DivisionID = e.DivisionID ";
        $sql .= " LEFT JOIN HRDepartment d ON d.DeptID = e.DeptID ";
        $sql .= " WHERE e.EmpID = '".$id."' AND e.Active = 1";

		if ($count != 0) $result = $this->get_numrow($sql);
        else $result = $this->get_row($sql, $dbname);

		return $result;
	}

    function get_approvers($empid, $count = 0, $dbname = NULL)
	{
		$sql = "SELECT DISTINCT TYPE, SIGNATORY1, SIGNATORY2, SIGNATORY3, SIGNATORY4, SIGNATORY5, SIGNATORY6, SIGNATORYID1, SIGNATORYID2, SIGNATORYID3, SIGNATORYID4, SIGNATORYID5, SIGNATORYID6, SIGNATORYDB1, SIGNATORYDB2, SIGNATORYDB3, SIGNATORYDB4, SIGNATORYDB5, SIGNATORYDB6, TYPE FROM GLMEmpSignatory WHERE EMPID = '".$empid."' AND (TYPE = 'frmApplicationLVWeb' OR TYPE= 'frmApplicationWHWeb' OR TYPE = 'frmApplicationOTWeb' OR TYPE = 'frmApplicationOBWeb' OR TYPE = 'frmApplicationMDWeb' OR TYPE = 'frmApplicationNPWeb' OR TYPE = 'frmApplicationSCWeb')   ";
		if ($count) : $result = $this->get_numrow($sql);
        else : $result = $this->get_row($sql, $dbname);
        endif;
		return $result;
	}

    function get_altapprovers($empid, $count = 0, $dbname = NULL)
	{
		$sql = "SELECT DISTINCT DocType, ToUserID, UserID, LevelApprover FROM ApprovalAlternative WHERE EMPID = '".$empid."' AND (GETDATE() BETWEEN FromDate AND ToDate) AND (DocType = 'frmApplicationLVWeb' OR DocType = 'frmApplicationWHWeb' OR DocType = 'frmApplicationOTWeb' OR DocType = 'frmApplicationOBWeb' OR DocType = 'frmApplicationMDWeb' OR DocType = 'frmApplicationNPWeb' OR DocType = 'frmApplicationSCWeb')   ";
		if ($count) : $result = $this->get_numrow($sql);
        else : $result = $this->get_row($sql, $dbname);
        endif;
		return $result;
	}

    function get_altapprovers2($empid, $doctype = NULL, $level = 0, $dbname = NULL)
	{
		$sql = "SELECT DISTINCT ToUserID, UserID FROM ApprovalAlternative WHERE EMPID = '".$empid."' AND (GETDATE() BETWEEN FromDate AND ToDate) AND LevelApprover = ".$level." AND (DocType = '".$doctype."') ";
        $result = $this->get_row($sql, $dbname);
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


        if ($empid) :
            $result = $this->get_numrow($sql);
		    return $result;
        else :
		    return 0;
        endif;
    }

    function get_recent_memo()
	{
        $sql = "SELECT ";
        $sql .= " MemoID, MemoName, MemoAttach, MemoAttachType, MemoDate FROM HRMemo ";
        $sql .= " WHERE MemoStatus != 0 ";
        $sql .= " AND MemoDate BETWEEN '".date('Y-m-d')." 00:00:00.000' AND '".date('Y-m-d')." 23:59:59.000' ";
        $result = $this->get_numrow($sql);
		return $result;
    }

    function get_nextcutoff($company)
    {
        $sql = "SELECT TOP 1 GETDATE(), PRFrom ";
        $sql .= " FROM HRCompanyCutOff ";
        $sql .= " WHERE CompanyID = '".$company."' AND PeriodFrom <= GETDATE() ";
        $sql .= " ORDER BY PeriodFrom DESC ";

		$result = $this->get_row($sql);
		return $result[0]['PRFrom'];
    }

    /* PROFILE */

    function get_posi_data($id = 0, $dbname = NULL)
    {

        $sql = "SELECT * FROM HRPosition ";
        if ($id != 0) : $sql .= " WHERE PositionID = '".$id."'"; endif;

		$result = $this->get_row($sql, $dbname);

		return $result;
    }

    function get_dept_data($id = NULL, $dbname = NULL)
    {

        $sql = "SELECT * FROM HRDepartment ";
        if ($id != NULL) : $sql .= " WHERE DeptID = '".$id."'"; endif;

		$result = $this->get_row($sql, $dbname);

		return $result;
    }

    function get_dep_data($id = NULL, $dbname = NULL)
    {

        $sql = "SELECT * FROM HRDependents ";
        if ($id != NULL) : $sql .= " WHERE EmpID = '".$id."'"; endif;

		$result = $this->get_row($sql, $dbname);

		return $result;
    }

    /* IMAGES */

    function get_image($type = 0, $id = 0)
    {
        // 1 - profile
        // 2 - attachments

        if ($type == 2) :
            $sql = "SELECT * FROM HREmpFiles ";
            if ($id != 0) : $sql .= " WHERE EmpID = '".$id."'"; endif;
        elseif ($type == 3) :
            $sql = "SELECT * FROM HRActivity ";
            if ($id != 0) : $sql .= " WHERE activity_id = '".$id."'"; endif;
        else :
            $sql = "SELECT * FROM HREmpPictures ";
            if ($id != 0) : $sql .= " WHERE EmpID = '".$id."'"; endif;
        endif;

		$result = $this->get_row($sql);

		return $result;
    }

    /* EMAIL BLOCKER */

    function get_newemailblock($empid, $dbname = NULL)
	{
		$sql = "SELECT EMAIL FROM FN_SENDEMAIL('".$empid."', 0) ";
		$result = $this->get_row($sql, $dbname);
		return $result[0]['EMAIL'];
    }

    function get_appemailblock($empid, $dbname = NULL)
	{
		$sql = "SELECT EMAIL FROM FN_SENDEMAIL('".$empid."', 1) ";
		$result = $this->get_row($sql, $dbname);
		return $result[0]['EMAIL'];
    }

    function set_emailblock($empid, $value = 0, $new = 0, $dbname = NULL)
	{
		$sql = "UPDATE SYEmailNotificationSettings ";
        if ($new == 1) : $sql .= " SET NewFormCreatedOrToBeApproved = ".$value." ";
        else : $sql .= " SET ApprovedOrDisapprove = ".$value." "; endif;
        $sql .= " WHERE EmpID = '".$empid."' ";
		$result = $this->get_execute($sql, $dbname);
		return $result ? 1 : 0;
    }

    /* PAYSLIP BLOCKER */

    function get_psblock($empid, $dbname = NULL)
	{
		$sql = "SELECT UserView FROM FN_GETPAYSLIP('".$empid."') ";
		$result = $this->get_row($sql, $dbname);
		return $result[0]['UserView'];
    }

    function set_psblock($empid, $value = 0, $dbname = NULL)
	{
        $sql = "UPDATE SYUserRights SET UserView = ".$value." WHERE UserName = '".$empid."' and ProgramID = 'frmPersonalPayslipWeb'";
		$result = $this->get_execute($sql, $dbname);
		return $result ? 1 : 0;
    }

    /* READ and UNREAD STATUS */

    function get_read($empid, $reqnbr = NULL, $count = 0, $start = 0, $limit = 0)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY ReqNbr DESC) as ROW_NUMBER, ";
        $sql .= " ReqNbr FROM HRRead WHERE EmpID = '".$empid."' ";
        if ($reqnbr != NULL) $sql .= " AND ReqNbr = '".$reqnbr."' ";
        $sql .= ") AS [outer] ";
        if ($limit) :
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

		if ($count) : $result = $this->get_numrow($sql);
        else : $result = $this->get_row($sql);
        endif;
		return $result;
    }

    function insert_read($empid, $reqnbr)
	{
        $sql = "INSERT INTO HRRead (ReqNbr, EmpID) VALUES ('".$reqnbr."', '".$empid."')";
		$result = $this->get_execute($sql);
		return $result ? 1 : 0;
    }

    function delete_read($empid = NULL, $reqnbr)
	{
        $sql = "DELETE FROM HRRead WHERE ReqNbr = '".$reqnbr."' ";
        if ($empid != NULL) $sql .= " AND EmpID = '".$empid."' ";
		$result = $this->get_execute($sql);
		return $result ? 1 : 0;
    }

    /* NOTIFICATION */


    function get_notification($id = NULL, $start = 0, $limit = 0, $search = NULL, $count = 0, $empid = NULL, $from = NULL, $to = NULL, $dtype = NULL, $dbname = NULL)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY DateFiled DESC) as ROW_NUMBER, ";
        $sql .= " EmpID, DateFiled, DocType, Reference, ApprovedDate01, ApprovedDate02, ApprovedDate03, ApprovedDate04, ApprovedDate05, ApprovedDate06,
            Signatory01, Signatory02, Signatory03, Signatory04, Signatory05, Signatory06,
            DB_NAME01, DB_NAME02, DB_NAME03, DB_NAME04, DB_NAME05, DB_NAME06,
            Remarks01, Remarks02, Remarks03, Remarks04, Remarks05, Remarks06, Approved, RejectedDate, POSTEDDATE, APPROVALDATE FROM TED_VIEW_NOTIFICATION ";
        $sql .= " WHERE EmpID IS NOT NULL ";
        if ($id != NULL) : $sql .= " AND Reference = '".$id."' "; endif;
        if ($search != NULL) : $sql .= " AND (Reference LIKE '%".$search."%' OR EmpID = '".$search."' OR FULLNAME LIKE '%".$search."%') "; endif;
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
        else : $result = $this->get_row($sql, $dbname);
        endif;
        return $result;
	}

    function get_notification_count($id = NULL, $start = 0, $limit = 0, $search = NULL, $empid = NULL, $from = NULL, $to = NULL, $dtype = NULL, $dbname = NULL)
	{
		$sql = "SELECT COUNT(EmpID) AS EmpCount FROM TED_VIEW_NOTIFICATION ";
        $sql .= " WHERE EmpID IS NOT NULL ";
        if ($id != NULL) : $sql .= " AND Reference = '".$id."' "; endif;
        if ($search != NULL) : $sql .= " AND (Reference LIKE '%".$search."%' OR EmpID = '".$search."' OR FULLNAME LIKE '%".$search."%') "; endif;
        if ($dtype != NULL) : $sql .= " AND DocType = '".$dtype."' "; endif;
        if ($empid != NULL) : $sql .= " AND ((EmpID = '".$empid."') OR (Signatory01 = '".$empid."' OR Signatory02 = '".$empid."' OR Signatory03 = '".$empid."' OR Signatory04 = '".$empid."' OR Signatory05 = '".$empid."' OR Signatory06 = '".$empid."') AND Approved != 3) "; endif;
        if ($from && $to) :
            $sql .= " AND DateFiled BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' ";
        endif;

        /*$sql .= " ORDER BY DateFiled DESC ";
        if ($limit) :
            $sql .= " OFFSET ".$start." ROWS ";
            $sql .= " FETCH NEXT ".$limit." ROWS ONLY ";
        endif;*/

        $result = $this->get_row($sql, $dbname);
        return $result;
	}

    function get_pendingnoti($id = NULL, $start = 0, $limit = 0, $search = NULL, $count = 0, $empid = NULL, $from = NULL, $to = NULL, $dtype = NULL, $dbname = NULL)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY DateFiled DESC) as ROW_NUMBER, ";
        $sql .= " EmpID, DateFiled, DocType, Reference, ApprovedDate01, ApprovedDate02, ApprovedDate03, ApprovedDate04, ApprovedDate05, ApprovedDate06,
            Signatory01, Signatory02, Signatory03, Signatory04, Signatory05, Signatory06, Approved, POSTEDDATE, DBNAME FROM TED_VIEW_NOTIFICATION2 ";
        $sql .= " WHERE EmpID != '' AND Approved = 0 ";
        if ($id != NULL) : $sql .= " AND Reference = '".$id."' "; endif;
        if ($search != NULL) : $sql .= " AND (Reference LIKE '%".$search."%' OR EmpID LIKE '%".$search."%' OR FullName LIKE '%".$search."%') "; endif;
        if ($dtype != NULL) : $sql .= " AND DocType = '".$dtype."' "; endif;
        if ($empid != NULL) : $sql .= " AND ((EmpID = '".$empid."' AND DBNAME = '".$dbname."') OR (Signatory01 = '".$empid."' OR Signatory02 = '".$empid."' OR Signatory03 = '".$empid."' OR Signatory04 = '".$empid."' OR Signatory05 = '".$empid."' OR Signatory06 = '".$empid."') AND Approved != 3) "; endif;           if ($from && $to) :
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

        if ($empid || $limit) :
            if ($count) : $result = $this->get_numrow($sql);
            else : $result = $this->get_row($sql, $dbname);
            endif;
		    return $result;
        else :
		    return 0;
        endif;
	}

    function get_overtimedata($id = NULL, $dbname = NULL)
	{

        $sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY ReqDate DESC) as ROW_NUMBER, ";
        $sql .= " ReqNbr, ReqDate, EmpID, OTType, FromDate, ToDate, Hrs, ApprovedHrs, Reason, ForApproval, Approved, DtrDate, SeqID FROM viewApplyOT ";
        $sql .= " WHERE SeqId != 0 ";
        if ($id != NULL) : $sql .= " AND ReqNbr = '".$id."'"; endif;
        $sql .= ") AS [outer] ";

        $result = $this->get_row($sql, $dbname);
        return $result;

    }

    function get_nrequest($type = 1, $id = NULL, $grp = 0, $start = 0, $limit = 0, $search = NULL, $count = 0, $empid = NULL, $status = 0, $from = NULL, $to = NULL)
	{

        switch($type) {

            case 1: // OVERTIME

                $sql = "SELECT [outer].* FROM ( ";
                $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY ReqDate DESC) as ROW_NUMBER, ";
                $sql .= " ReqNbr, ReqDate, EmpID, OTType, FromDate, ToDate, Hrs, ApprovedHrs, Reason, ForApproval, Approved, DtrDate, SeqID FROM viewApplyOT ";
                $sql .= " WHERE SeqId != 0 ";
                if ($id != NULL) : $sql .= " AND ReqNbr = '".$id."'"; endif;
                if ($search != NULL) : $sql .= " AND ReqNbr LIKE '%".$search."%' "; endif;
                if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
                if ($status != 0) : $sql .= " AND Approved = '".$status."' ";
                endif;
                if ($from && $to) :
                    $sql .= " AND ReqDate BETWEEN '".$from."' AND '".$to."' ";
                endif;
                $sql .= ") AS [outer] ";
                if ($limit) :
                    $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
                endif;

                /*$sql .= " ORDER BY ReqDate DESC ";
                if ($limit) :
                    $sql .= " OFFSET ".$start." ROWS ";
                    $sql .= " FETCH NEXT ".$limit." ROWS ONLY ";
                endif;*/

                if ($count) : $result = $this->get_numrow($sql);
                else : $result = $this->get_row($sql);
                endif;

            break;

            case 2: // LEAVE

                $sql = "SELECT [outer].* FROM ( ";
                $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY DateFiled DESC) as ROW_NUMBER, ";
                $sql .= " LeaveRef, DateFiled, EmpID, LeaveDesc, AbsenceFromDate, AbsenceToDate, Days, Hours,
                        Reason, Status, CreatedDate FROM viewApplyLeave ";
                $sql .= " WHERE SeqId != 0 ";
                if ($id != NULL) : $sql .= " AND LeaveRef = '".$id."'"; endif;
                if ($search != NULL) : $sql .= " AND LeaveRef LIKE '%".$search."%' "; endif;
                if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
                if ($status != 0) : $sql .= " AND Approved = '".$status."' ";
                endif;
                if ($from && $to) :
                    $sql .= " AND DateFiled BETWEEN '".$from."' AND '".$to."' ";
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

            break;

            case 3: // MEAL ALLOWANCE

                $sql = "SELECT [outer].* FROM ( ";
                $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY ReqDate DESC) as ROW_NUMBER, ";
                $sql .= " ReqNbr, ReqDate, EmpID, DateFrom, DateTo, TypeAvail, Approved FROM viewApplyMA ";
                $sql .= " WHERE SeqID != 0 ";
                if ($id != NULL) : $sql .= " AND ReqNbr = '".$id."'"; endif;
                if ($search != NULL) : $sql .= " AND ReqNbr LIKE '%".$search."%' "; endif;
                if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
                if ($status != 0) : $sql .= " AND Approved = '".$status."' ";
                endif;
                if ($from && $to) :
                    $sql .= " AND ReqDate BETWEEN '".$from."' AND '".$to."' ";
                endif;
                $sql .= ") AS [outer] ";
                if ($limit) :
                    $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
                endif;

                /*$sql .= " ORDER BY ReqDate DESC ";
                if ($limit) :
                    $sql .= " OFFSET ".$start." ROWS ";
                    $sql .= " FETCH NEXT ".$limit." ROWS ONLY ";
                endif;*/

                if ($count) : $result = $this->get_numrow($sql);
                else : $result = $this->get_row($sql);
                endif;

            break;

            case 4: // OBT

                $sql = "SELECT [outer].* FROM ( ";
                $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY DateFiled DESC) as ROW_NUMBER, ";
                $sql .= " ReqNbr, DateFiled, EmpID, OBTimeINDate, OBTimeOutDate, Duration, Days, Destination,
                            Reason, NoteOffBusinessRef, Approved FROM viewApplyOBT ";
                $sql .= " WHERE SeqID != 0 ";
                if ($id != NULL) : $sql .= " AND ReqNbr = '".$id."'"; endif;
                if ($search != NULL) : $sql .= " AND ReqNbr LIKE '%".$search."%' "; endif;
                if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
                if ($status != 0) : $sql .= " AND Approved = '".$status."' ";
                endif;
                if ($from && $to) :
                    $sql .= " AND DateFiled BETWEEN '".$from."' AND '".$to."' ";
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

            break;

            case 5: // CTS

                $sql = "SELECT [outer].* FROM ( ";
                $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY DateFiled DESC) as ROW_NUMBER, ";
                $sql .= " ChangeTimeRef, DateFiled, DateCovered, ChangeSchedFrom, ChangeSchedTo, Day,
                            NewShiftId, Reason, Waivered, RestDay, Approved, Stats, WriteSched FROM viewApplyCTS ";
                $sql .= " WHERE SeqID != 0 ";
                if ($id != NULL) : $sql .= " AND ChangeTimeRef = '".$id."'"; endif;
                if ($search != NULL) : $sql .= " AND ReqNbr LIKE '%".$search."%' "; endif;
                if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
                if ($status != 0) : $sql .= " AND Approved = '".$status."' ";
                endif;
                if ($from && $to) :
                    $sql .= " AND DateFiled BETWEEN '".$from."' AND '".$to."' ";
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

            break;

            case 6: // NPA

                $sql = "SELECT [outer].* FROM ( ";
                $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY DateFiled DESC) as ROW_NUMBER, ";
                $sql .= " NonPunchRef, EmpID, DateFiled, DateCovered, DateTimeIN, DateTimeOUT,
                            TimeIn, TimeOut, Reason, StatusForms FROM viewApplyNPA ";
                $sql .= " WHERE SeqID != 0 ";
                if ($id != NULL) : $sql .= " AND NonPunchRef = '".$id."'"; endif;
                if ($search != NULL) : $sql .= " AND NonPunchRef LIKE '%".$search."%' "; endif;
                if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
                if ($status != 0) : $sql .= " AND StatusForms = '".$status."' ";
                endif;
                if ($from && $to) :
                    $sql .= " AND DateFiled BETWEEN '".$from."' AND '".$to."' ";
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

            break;

            case 7: // Manual DTR

                $sql = "SELECT [outer].* FROM ( ";
                $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY ReqDate DESC) as ROW_NUMBER, ";
                $sql .= " SeqID, EmpID, ForApproval, ReqDate, ReqNbr, Posted, PostedDate, Level, Revised, StatusForms, DateStart, LateApproved, Expr1, Day, DTRDate, Expr2, ShiftDesc, TimeIn, TimeInDate, TimeOUt, TimeOutDate, Status, NewShiftDesc, Remarks, RestDay, ShiftID, WriteSched FROM viewApplyMDTR";
                $sql .= " WHERE SeqID != 0 ";
                if ($id != NULL) : $sql .= " AND ReqNbr = '".$id."'"; endif;
                if ($search != NULL) : $sql .= " AND ReqNbr LIKE '%".$search."%' "; endif;
                if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
                if ($status != 0) : $sql .= " AND StatusForms = '".$status."' "; endif;
                if ($from && $to) :
                    $sql .= " AND ReqDate BETWEEN '".$from."' AND '".$to."' ";
                endif;
                if ($grp != 0) : $sql .= " GROUP BY ReqNbr "; endif;
                $sql .= ") AS [outer] ";
                if ($limit) :
                    $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
                endif;

                /*$sql .= " ORDER BY ReqDate DESC ";
                if ($limit) :
                    $sql .= " OFFSET ".$start." ROWS ";
                    $sql .= " FETCH NEXT ".$limit." ROWS ONLY ";
                endif;*/

                if ($count) : $result = $this->get_numrow($sql);
                else : $result = $this->get_row($sql);
                endif;

            break;

            case 8: // Time Scheduler

                $sql = "SELECT [outer].* FROM ( ";
                $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY ReqDate DESC) as ROW_NUMBER, ";
                $sql .= " EmpID, ForApproval, ReqDate, ReqNbr, Posted, PostedDate, Level, Revised, StatusForms, DateStart, LateApproved, Expr1, DateIn, DateOut, Day, DTRDate, Expr2, ShiftID, TimeIn, TimeOut, NewShiftDesc, NewShiftID, Remarks, Restday, Status, Expr3, Expr4, WriteSched FROM viewApplySC ";
                $sql .= " WHERE ReqNbr != NULL ";
                if ($id != NULL) : $sql .= " AND ReqNbr = '".$id."'"; endif;
                if ($search != NULL) : $sql .= " AND ReqNbr LIKE '%".$search."%' "; endif;
                if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
                if ($status != 0) : $sql .= " AND StatusForms = '".$status."' ";
                endif;
                if ($from && $to) :
                    $sql .= " AND ReqDate BETWEEN '".$from."' AND '".$to."' ";
                endif;
                if ($grp != 0) : $sql .= " GROUP BY ReqNbr "; endif;
                $sql .= ") AS [outer] ";
                if ($limit) :
                    $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
                endif;

                /*$sql .= " ORDER BY ReqDate DESC ";
                if ($limit) :
                    $sql .= " OFFSET ".$start." ROWS ";
                    $sql .= " FETCH NEXT ".$limit." ROWS ONLY ";
                endif;*/

                if ($count) : $result = $this->get_numrow($sql);
                else : $result = $this->get_row($sql);
                endif;

            break;

            case 9: // OFFSET

                $sql = "SELECT [outer].* FROM ( ";
                $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY ReqDate DESC) as ROW_NUMBER, ";
                $sql .= " ReqNbr, ReqDate, EmpID, LUType, LUHrs, ForApproval, Approved, DtrDate, SeqID FROM viewApplyLU ";
                $sql .= " WHERE SeqId != 0 ";
                if ($id != NULL) : $sql .= " AND ReqNbr = '".$id."'"; endif;
                if ($search != NULL) : $sql .= " AND ReqNbr LIKE '%".$search."%' "; endif;
                if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
                if ($status != 0) : $sql .= " AND Approved = '".$status."' ";
                endif;
                if ($from && $to) :
                    $sql .= " AND ReqDate BETWEEN '".$from."' AND '".$to."' ";
                endif;
                $sql .= ") AS [outer] ";
                if ($limit) :
                    $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
                endif;

                /*$sql .= " ORDER BY ReqDate DESC ";
                if ($limit) :
                    $sql .= " OFFSET ".$start." ROWS ";
                    $sql .= " FETCH NEXT ".$limit." ROWS ONLY ";
                endif;*/

                if ($count) : $result = $this->get_numrow($sql);
                else : $result = $this->get_row($sql);
                endif;

            break;
        }

		return $result;
	}


    function get_attachments($empid = NULL, $count = 0, $dbname = NULL)
	{
        $sql = " SELECT ReqNbr, AttachFile, AttachType FROM HRAttach ";
        $sql .= " WHERE ReqNbr != '' ";
        if ($empid != NULL) : $sql .= " AND ReqNbr = '".$empid."' "; endif;

        if ($count) : $result = $this->get_numrow($sql);
        else : $result = $this->get_row($sql, $dbname);
        endif;
		return $result;
	}

    function get_posted($from, $to, $company)
    {
        $sql = "SELECT AttPost FROM HRCompanyCutOff WHERE PeriodFrom <= '".date('Y-m-d', $from)." 00:00:00.000' AND PeriodTo >= '".date('Y-m-d', $from)." 23:59:59.999' AND CompanyID='".$company."'";
		$result = $this->get_row($sql);
		return $result;
    }

    /* LEAVE */

    function get_leave($desc = NULL)
	{
		$sql = "SELECT LeaveID, LeaveDesc FROM HRLeaves WHERE Active = 1";
        if ($desc != NULL) : $sql .= " AND LeaveDesc = '".$desc."' "; endif;
		$result = $this->get_row($sql);
		return $result;
    }

    function get_leavebal($empid, $leaveid)
	{
		$sql = "SELECT LeaveID, EarnedDays, EarnedHrs, UsedDays, UsedHrs, BalanceDays, BalanceHrs, DateEffect FROM HREmpLBalance WHERE EmpID = '".$empid."' AND LeaveID = '".$leaveid."' AND DateEffect <= GETDATE() ";
		$result = $this->get_row($sql);
		return $result;
	}

    function get_leavebal_byid($empid, $leaveid)
	{
		$sql = "SELECT LeaveID, EarnedDays, EarnedHrs, UsedDays, UsedHrs, BalanceDays, BalanceHrs, DateEffect FROM HREmpLBalance WHERE EmpID = '".$empid."' AND LeaveID = '".$leaveid."' AND DateEffect <= GETDATE() ";
		$result = $this->get_row($sql);
		return $result;
	}

    function get_newleavebal_byid($empid, $leaveid)
	{
		$sql = "SELECT BALANCE = DBO.FN_GET_ACTUAL_LEAVE_BALANCE_CURRENT('".$leaveid."', '".$empid."') ";
		$result = $this->get_row($sql);
		return $result;
	}

    function get_newleavebal_byid_pryear($empid, $leaveid, $pryear)
    {
        $sql = "SELECT BALANCE = DBO.FN_GET_ACTUAL_LEAVE_BALANCE_PRYEAR('".$leaveid."', '".$empid."', '". $pryear ."') ";
        $result = $this->get_row($sql);
        return $result;
    }

    function get_leavebytype($empid = NULL, $type = NULL, $year = 0, $count = 0)
	{
        $sql = "SELECT ";
        $sql .= " LeaveRef, DateFiled, EmpID, LeaveDesc, AbsenceFromDate, AbsenceToDate, Days, Hours,
                Reason, Status, CreatedDate FROM viewApplyLeave ";
        $sql .= " WHERE SeqId != 0 ";
        $sql .= " AND Status != 2 AND Status != 3";
        if ($type != NULL) : $sql .= " AND LeaveDesc = '".$type."' "; endif;
        if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
        if ($year != 0) : $sql .= " AND YEAR(AbsenceFromDate) = ".$year." "; endif;
        $sql .= " ORDER BY DateFiled DESC ";
        if ($count) : $result = $this->get_numrow($sql);
        else : $result = $this->get_row($sql);
        endif;

		return $result;
	}

    function get_leaveledgerbytype($empid = NULL, $type = NULL, $year = 0, $count = 0)
	{
        $sql = "SELECT * FROM viewSLVL_Ledger ";
        $sql .= " WHERE SeqId != 0 ";
        if ($type != NULL) : $sql .= " AND LeaveID = '".$type."' "; endif;
        if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
        if ($year != 0) : $sql .= " AND PRYear = ".$year." "; endif;
        $sql .= " AND (EarnedDays != 0 OR UsedDays != 0)";
        $sql .= " ORDER BY Date ASC ";
        if ($count) : $result = $this->get_numrow($sql);
        else : $result = $this->get_row($sql);
        endif;

		return $result;
	}

    /* LOAN LEDGER */

    function get_emploan($empid = NULL)
	{
		$sql = "SELECT * FROM ViewEmpLoan WHERE Active = 1";
        if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
        $sql .= " ORDER BY CAST(DateGranted AS Date) DESC ";
		$result = $this->get_row($sql);
		return $result;
    }

    function get_loandata($aid)
	{
		$sql = "SELECT * FROM PRLoanLedger WHERE ApplyTo = '".$aid."' ORDER BY TranType, PRYear, PeriodID";
		$result = $this->get_row($sql);
		return $result;
	}

    /* ACITIVITY */

    function get_activities($id = 0, $start = 0, $limit = 0, $search = NULL, $count = 0, $random = 0, $not_all = 0, $wads = 0, $all = 0, $db = NULL)
	{

        $sql = "SELECT [outer].* FROM ( ";
        if ($random != 0) :
            $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY activity_date DESC) as ROW_NUMBER, ";
        else :
            if ($wads == 1) :
            $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY activity_datestart DESC) as ROW_NUMBER, ";
            elseif ($wads == 2) :
            $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY activity_date DESC) as ROW_NUMBER, ";
            else :
            $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY activity_date DESC) as ROW_NUMBER, ";
            endif;
        endif;
        $sql .= " * FROM HRActivity ";
        if ($all != 0) : $sql.=" WHERE activity_status >= 0 ";
        else : $sql.=" WHERE activity_status = 1 "; endif;
        $sql.=" AND activity_offsite = 0 ";
		if ($search != NULL) $sql.=" AND activity_title LIKE '%".$search."%'";
        if ($db != NULL) : $sql .= " AND activity_db = '".$db."' "; endif;
		if ($id != 0) $sql.=" AND activity_id = ".$id;
        if ($wads == 1) : $sql.=" AND activity_ads = 0 ";
        elseif ($wads == 2) : $sql.=" AND activity_ads = 1 ";
        endif;
        $sql .= ") AS [outer] ";
        if ($limit) :
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

        if ($count) : $result = $this->get_numrow($sql);
        else : $result = $this->get_row($sql);
        endif;
		return $result;
	}

    /* MEMORANDUM */

    function get_memo($id = 0, $start = 0, $limit = 0, $search = NULL, $count = 0, $from = 0, $to = 0, $type = 0)
	{

        $sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY MemoDate DESC) as ROW_NUMBER, ";
        $sql .= " MemoID, MemoName, MemoAttach, MemoAttachType, MemoDate ";
        $sql .= " FROM HRMemo ";
        $sql .= " WHERE MemoStatus = 2 ";
        if ($id != 0) : $sql .= " AND MemoID = ".$id; endif;
        if ($search != NULL) : $sql .= " AND (MemoName LIKE '%".$search."%') "; endif;
        if ($type != 0) : $sql .= " AND MemoType = ".$type; endif;
        if ($from && $to) :
            $sql .= " AND MemoDate BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' ";
        endif;
        $sql .= ") AS [outer] ";
        if ($limit) :
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

        /*$sql .= " ORDER BY MemoDate DESC ";
        if ($limit) :
            $sql .= " OFFSET ".$start." ROWS ";
            $sql .= " FETCH NEXT ".$limit." ROWS ONLY ";
        endif;*/

        if ($count) : $result = $this->get_numrow($sql);
        else : $result = $this->get_row($sql);
        endif;
		return $result;
	}

	/* COE Requisition */
	function get_coe($start = 0, $limit = 0, $empid = NULL, $count = 0, $level = 1,$profile_idnum)
	{
		$emp_type = "SELECT * FROM COEUsers WHERE emp_id='".$profile_idnum."' ORDER BY level asc";
		$emp_type = $this->get_row($emp_type);

		$sql = "SELECT [outer].* FROM(";
		$sql .= "SELECT ROW_NUMBER() OVER(ORDER BY created_at) as ROW_NUMBER, * FROM COERequests ";
		if($level == 1){
			$sql .= "WHERE emp_id ='".$empid."')";
		}else{
			if($emp_type[0]['level'] != '1'){
				if($emp_type[0]['level'] == '2'){
					$sql .= "WHERE type = 'COECOMPENSATION'";
				}else{
					$sql .= "WHERE type != 'COECOMPENSATION'";
				}
			}
			$sql .= ")";
		}
		$sql .= " as [outer]";
		if($limit){
			$sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) +1)." AND ".intval($start + $limit);
		}
		$sql .= " ORDER BY [outer].id desc";
		if ($count) : $result = $this->get_numrow($sql);
		else : $result = $this->get_row($sql);
		endif;

		return $result;
	}

    /* MY REQUEST */

    function get_mrequest($type = 1, $id = NULL, $start = 0, $limit = 0, $search = NULL, $count = 0, $empid = NULL, $status = NULL, $from = NULL, $to = NULL)
	{

        switch($type) {

            case 1: // OVERTIME

                $sql = "SELECT [outer].* FROM ( ";
                $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY ReqDate DESC) as ROW_NUMBER, ";
                $sql .= " ReqNbr, ReqDate, EmpID, OTType, FromDate, ToDate, Hrs, ApprovedHrs, Reason, ForApproval, Approved, DtrDate, SeqID FROM viewApplyOT ";
                $sql .= " WHERE SeqId != 0 ";
                if ($id != NULL) : $sql .= " AND ReqNbr = '".$id."' "; endif;
                if ($search != NULL) : $sql .= " AND ReqNbr LIKE '%".$search."%' "; endif;
                if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
                if ($status != NULL) : $sql .= " AND Approved = '".$status."' ";
                endif;
                if ($from && $to) :
                    $sql .= " AND ReqDate BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' ";
                endif;
                $sql .= ") AS [outer] ";
                if ($limit) :
                    $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
                endif;

                /*$sql .= " ORDER BY ReqDate DESC ";
                if ($limit) :
                    $sql .= " OFFSET ".$start." ROWS ";
                    $sql .= " FETCH NEXT ".$limit." ROWS ONLY ";
                endif;*/

                if ($count) : $result = $this->get_numrow($sql);
                else : $result = $this->get_row($sql);
                endif;

            break;

            case 2: // LEAVE

                $sql = "SELECT [outer].* FROM ( ";
                $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY DateFiled DESC) as ROW_NUMBER, ";
                $sql .= " LeaveRef, DateFiled, EmpID, LeaveDesc, AbsenceFromDate, AbsenceToDate, Days, Hours,
                        Reason, Status, CreatedDate FROM viewApplyLeave ";
                $sql .= " WHERE SeqId != 0 ";
                if ($id != NULL) : $sql .= " AND LeaveRef = '".$id."' "; endif;
                if ($search != NULL) : $sql .= " AND LeaveRef LIKE '%".$search."%' "; endif;
                if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
                if ($status != NULL) : $sql .= " AND Approved = '".$status."' ";
                endif;
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

            break;

            case 3: // MEAL ALLOWANCE

                $sql = "SELECT [outer].* FROM ( ";
                $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY ReqDate DESC) as ROW_NUMBER, ";
                $sql .= " ReqNbr, ReqDate, DateFrom, DateTo, TypeAvail, Approved FROM viewApplyMA ";
                $sql .= " WHERE SeqID != 0 ";
                if ($id != NULL) : $sql .= " AND ReqNbr = '".$id."' "; endif;
                if ($search != NULL) : $sql .= " AND ReqNbr LIKE '%".$search."%' "; endif;
                if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
                if ($status != 0) : $sql .= " AND Approved = '".$status."' ";
                endif;
                if ($from && $to) :
                    $sql .= " AND ReqDate BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' ";
                endif;
                $sql .= ") AS [outer] ";
                if ($limit) :
                    $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
                endif;

                /*$sql .= " ORDER BY ReqDate DESC ";
                if ($limit) :
                    $sql .= " OFFSET ".$start." ROWS ";
                    $sql .= " FETCH NEXT ".$limit." ROWS ONLY ";
                endif;*/

                if ($count) : $result = $this->get_numrow($sql);
                else : $result = $this->get_row($sql);
                endif;

            break;

            case 4: // OBT

                $sql = "SELECT [outer].* FROM ( ";
                $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY DateFiled DESC) as ROW_NUMBER, ";
                $sql .= " ReqNbr, EmpID, DateFiled, OBTimeINDate, OBTimeOutDate, Duration, Days, Destination,
                            Reason, NoteOffBusinessRef, Approved FROM viewApplyOBT ";
                $sql .= " WHERE SeqID != 0 ";
                if ($id != NULL) : $sql .= " AND ReqNbr = '".$id."' "; endif;
                if ($search != NULL) : $sql .= " AND ReqNbr LIKE '%".$search."%' "; endif;
                if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
                if ($status != 0) : $sql .= " AND Approved = '".$status."' ";
                endif;
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

            break;

            case 5: // CTS

                $sql = "SELECT [outer].* FROM ( ";
                $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY DateFiled DESC) as ROW_NUMBER, ";
                $sql .= " ChangeTimeRef, DateFiled, DateCovered, ChangeSchedFrom, ChangeSchedTo, Day,
                            NewShiftId, Reason, Waivered, RestDay, Approved, Stats, WriteSched FROM HRFrmApplyChangeTS ";
                $sql .= " WHERE SeqID != 0 ";
                if ($id != NULL) : $sql .= " AND ChangeTimeRef = '".$id."' "; endif;
                if ($search != NULL) : $sql .= " AND ChangeTimeRef LIKE '%".$search."%' "; endif;
                if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
                if ($status != 0) : $sql .= " AND Approved = '".$status."' ";
                endif;
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

            break;

            case 6: // NPA

                $sql = "SELECT [outer].* FROM ( ";
                $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY DateFiled DESC) as ROW_NUMBER, ";
                $sql .= " NonPunchRef, EmpID, DateFiled, DateCovered, DateTimeIN, DateTimeOUT,
                            TimeIn, TimeOut, Reason, StatusForms FROM viewApplyNPA ";
                $sql .= " WHERE SeqID != 0 ";
                if ($id != NULL) : $sql .= " AND NonPunchRef = '".$id."' "; endif;
                if ($search != NULL) : $sql .= " AND NonPunchRef LIKE '%".$search."%' "; endif;
                if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
                if ($status != 0) : $sql .= " AND StatusForms = '".$status."' ";
                endif;
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

            break;

            case 7: // Manual DTR

                $sql = "SELECT [outer].* FROM ( ";
                $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY ReqDate DESC) as ROW_NUMBER, ";
                $sql .= " ReqNbr, EmpID, ReqDate, DateStart, Posted, PostedDate, StatusForms FROM HRFrmApplyWFH ";
                $sql .= " WHERE SeqID != 0 ";
                if ($id != NULL) : $sql .= " AND ReqNbr = '".$id."' "; endif;
                if ($search != NULL) : $sql .= " AND ReqNbr LIKE '%".$search."%' "; endif;
                if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
                if ($status != 0) : $sql .= " AND StatusForms = '".$status."' ";
                endif;
                if ($from && $to) :
                    $sql .= " AND ReqDate BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' ";
                endif;
                $sql .= ") AS [outer] ";
                if ($limit) :
                    $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
                endif;

                /*$sql .= " ORDER BY ReqDate DESC ";
                if ($limit) :
                    $sql .= " OFFSET ".$start." ROWS ";
                    $sql .= " FETCH NEXT ".$limit." ROWS ONLY ";
                endif;*/

                if ($count) : $result = $this->get_numrow($sql);
                else : $result = $this->get_row($sql);
                endif;

            break;

            case 8: // Time Scheduler

                $sql = "SELECT [outer].* FROM ( ";
                $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY ReqDate DESC) as ROW_NUMBER, ";
                $sql .= " EmpID, ForApproval, ReqDate, ReqNbr, Posted, PostedDate, Level, Revised, StatusForms, DateStart, LateApproved, REMARKS FROM HRFrmTimeScheduler ";
                $sql .= " WHERE SeqID != 0 ";
                if ($id != NULL) : $sql .= " AND ReqNbr = '".$id."' "; endif;
                if ($search != NULL) : $sql .= " AND ReqNbr LIKE '%".$search."%' "; endif;
                if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
                if ($status != 0) : $sql .= " AND StatusForms = '".$status."' ";
                endif;
                if ($from && $to) :
                    $sql .= " AND ReqDate BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' ";
                endif;
                $sql .= ") AS [outer] ";
                if ($limit) :
                    $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
                endif;

                /*$sql .= " ORDER BY ReqDate DESC ";
                if ($limit) :
                    $sql .= " OFFSET ".$start." ROWS ";
                    $sql .= " FETCH NEXT ".$limit." ROWS ONLY ";
                endif;*/

                if ($count) : $result = $this->get_numrow($sql);
                else : $result = $this->get_row($sql);
                endif;

            break;
			case 10: // WFH

			$sql = "SELECT [outer].* FROM ( ";
			$sql .= " SELECT ROW_NUMBER() OVER(ORDER BY AppliedDate DESC) as ROW_NUMBER, ";
			$sql .= "  EmpID,convert(varchar, AppliedDate, 121) as AppliedDate,convert(varchar, FromDate, 121) as FromDate,convert(varchar, ToDate, 121) as ToDate,Reference,Status,Approved FROM viewApplyWH ";
			$sql .= " WHERE SeqID != 0 ";
			if ($id != NULL) : $sql .= " AND Reference = '".$id."' "; endif;
			if ($search != NULL) : $sql .= " AND Reference LIKE '%".$search."%' "; endif;
			if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
			if ($status != NULL) : $sql .= " AND Approved = '".$status."' ";
			endif;
			if ($from && $to) :
				$sql .= " AND AppliedDate BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' ";
			endif;
			$sql .= "GROUP BY EmpID,AppliedDate,FromDate,ToDate,Reference,Status,Approved ) AS [outer] ";
			if ($limit) :
				$sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
			endif;

			/*$sql .= " ORDER BY ReqDate DESC ";
			if ($limit) :
				$sql .= " OFFSET ".$start." ROWS ";
				$sql .= " FETCH NEXT ".$limit." ROWS ONLY ";
			endif;*/

			if ($count) : $result = $this->get_numrow($sql);
			else : $result = $this->get_row($sql);
			endif;

            break;
        }

		return $result;
	}

    function get_leavedata($leaveref = NULL)
    {
        $sql = "SELECT Duration, LeaveDate, Status, WithPay FROM HRFrmApplyLeaveItem ";
        if ($leaveref != NULL) : $sql .= " WHERE LeaveRef = '".$leaveref."' AND Status != 'CANCELLED' "; endif;
		$result = $this->get_row($sql);
		return $result;
    }

    function get_mdtrdata($mdtrref = NULL)
    {
        $sql = "SELECT Day, DTRDate, ShiftDesc, TimeIn, TimeOUt, Status, NewShiftDesc, Activities FROM HRFrmManualDTRItem ";
        if ($mdtrref != NULL) : $sql .= " WHERE ReqNbr = '".$mdtrref."' AND Status != 'CANCELLED' "; endif;
		$result = $this->get_row($sql);
		return $result;
    }

    function get_obtdata($obtref = NULL)
    {
        $sql = "SELECT ObTimeInDate, ObTimeOutDate, Status, ActualTimeInDate, ActualTimeOutDate  FROM HRFrmApplyNoticeOfficialBusinessItem ";
        if ($obtref != NULL) : $sql .= " WHERE ReqNbr = '".$obtref."' "; endif;
        $sql .= " AND Status != 'CANCELLED'";
		$result = $this->get_row($sql);
		return $result;
    }

    function get_tsdata($tsref = NULL)
    {
        $sql = "SELECT DTRDate, ShiftID, TimeIn, TimeOut, NewShiftDesc, NewShiftID, Status FROM HRFrmTimeSchedulerItem ";
        if ($tsref != NULL) : $sql .= " WHERE ReqNbr = '".$tsref."' AND Status != 'CANCELLED' "; endif;

		$result = $this->get_row($sql);
		return $result;
    }

    /* FOR APPLICATION CHECKING */

    function get_leavedata_applied($idnum, $from, $to)
    {
        $sql = "SELECT * FROM HRFrmApplyLeaveItem ";
        $sql .= " WHERE LeaveRef IN ";
        $sql .= " (SELECT Reference FROM TED_VIEW_NOTIFICATION WHERE EmpID ='".$idnum."' ";
        $sql .= " AND Approved IN (0,1)) ";
        $sql .= " AND LeaveDate BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' ";
        $sql .= " AND Status != 'CANCELLED' ";
		$result = $this->get_numrow($sql);
		return $result;
    }

    function get_obtdata_applied($idnum, $from, $to)
    {
        $sql = "SELECT * FROM HRFrmApplyNoticeOfficialBusinessItem ";
        $sql .= " WHERE ReqNbr IN ";
        $sql .= " (SELECT Reference FROM TED_VIEW_NOTIFICATION WHERE EmpID ='".$idnum."' ";
        $sql .= " AND Approved IN (0,1)) ";
        $sql .= " AND ObTimeInDate BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' ";
        $sql .= " AND Status != 'CANCELLED' ";
		$result = $this->get_numrow($sql);
		return $result;
    }

	function get_whdata_applied($idnum, $from, $to)
	{
		$sql = "SELECT * FROM HRFrmApplyWH";
		$sql .= " WHERE ReqNbr IN ";
		$sql .= " (SELECT Reference FROM TED_VIEW_NOTIFICATION WHERE EmpID ='".$idnum."' ";
		$sql .= " AND Approved IN (0,1)) ";
		$sql .= " AND DTRDate BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' ";
		$sql .= " AND Status != 'CANCELLED' ";
		$result = $this->get_numrow($sql);
		return $result;
	}

	function get_whdata_applieddata($idnum, $from, $to)
	{
		$sql = "SELECT * FROM HRFrmApplyWHItem ";
		$sql .= " WHERE ReqNbr IN ";
		$sql .= " (SELECT Reference FROM TED_VIEW_NOTIFICATION WHERE EmpID ='".$idnum."' ";
		$sql .= " AND Approved IN (0,1)) ";
		$sql .= " AND DTRDate BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' ";
		$sql .= " AND Status != 'CANCELLED' ";
		$result = $this->get_row($sql);
		return $result;
	}

    function get_mandtrdata_applied($idnum, $from, $to)
    {
        $sql = "SELECT * FROM HRFrmManualDTRItem ";
        $sql .= " WHERE ReqNbr IN ";
        $sql .= " (SELECT Reference FROM TED_VIEW_NOTIFICATION WHERE EmpID ='".$idnum."' ";
        $sql .= " AND Approved IN (0,1)) ";
        $sql .= " AND DTRDate BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' ";
        $sql .= " AND Status != 'CANCELLED' ";
		$result = $this->get_numrow($sql);
		return $result;
    }

    function get_mandtrdata_applieddata($idnum, $from, $to)
    {
        $sql = "SELECT * FROM HRFrmManualDTRItem ";
        $sql .= " WHERE ReqNbr IN ";
        $sql .= " (SELECT Reference FROM TED_VIEW_NOTIFICATION WHERE EmpID ='".$idnum."' ";
        $sql .= " AND Approved IN (0,1)) ";
        $sql .= " AND DTRDate BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' ";
        $sql .= " AND Status != 'CANCELLED' ";
		$result = $this->get_row($sql);
		return $result;
    }

    function get_tscheddata_applied($idnum, $from, $to)
    {
        $sql = "SELECT * FROM HRFrmTimeSchedulerItem ";
        $sql .= " WHERE ReqNbr IN ";
        $sql .= " (SELECT Reference FROM TED_VIEW_NOTIFICATION WHERE EmpID ='".$idnum."' ";
        $sql .= " AND Approved IN (0,1)) ";
        $sql .= " AND DTRDate BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' ";
        $sql .= " AND Status != 'CANCELLED' ";
        // ALLOW FILING OF SCHEDULER WITH OFFSET, BUT HAS ALREADY FILED SCHEDULER FIRST
        $sql .= " AND OFFSETDATE IS NOT NULL";
		$result = $this->get_numrow($sql);
		return $result;
    }

    function get_tscheddata_applieddata($idnum, $from, $to)
    {
        $sql = "SELECT * FROM HRFrmTimeSchedulerItem ";
        $sql .= " WHERE ReqNbr IN ";
        $sql .= " (SELECT Reference FROM TED_VIEW_NOTIFICATION WHERE EmpID ='".$idnum."' ";
        $sql .= " AND Approved IN (0,1)) ";
        $sql .= " AND DTRDate BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' ";
		$result = $this->get_row($sql);
		return $result;
    }

    function get_npadata_applied($idnum, $from, $to)
    {
        $sql = "SELECT * FROM HRFrmApplyNonPunching ";
        $sql .= " WHERE NonPunchRef IN ";
        $sql .= " (SELECT Reference FROM TED_VIEW_NOTIFICATION WHERE EmpID ='".$idnum."' ";
        $sql .= " AND Approved IN (0,1)) ";
        $sql .= " AND DateTimeIN BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' ";
		$result = $this->get_numrow($sql);
		return $result;
    }

    function get_otdata_applied($idnum, $from, $to)
    {
        $sql = "SELECT * FROM HRFrmApplyOT ";
        $sql .= " WHERE ReqNbr IN ";
        $sql .= " (SELECT Reference FROM TED_VIEW_NOTIFICATION WHERE EmpID ='".$idnum."' ";
        $sql .= " AND Approved IN (0,1)) ";
        $sql .= " AND FromDate BETWEEN '".$from.".000' AND '".$to.".000' ";
		$result = $this->get_numrow($sql);
		return $result;
    }

    function get_otdata_applieddata($idnum, $from, $to)
    {
        $sql = "SELECT * FROM HRFrmApplyOT ";
        $sql .= " WHERE ReqNbr IN ";
        $sql .= " (SELECT Reference FROM TED_VIEW_NOTIFICATION WHERE EmpID ='".$idnum."' ";
        $sql .= " AND Approved IN (0,1)) ";
        $sql .= " AND FromDate BETWEEN '".$from.".000' AND '".$to.".000' ";
		$result = $this->get_row($sql);
		return $result;
    }

    function get_ludata_applied($idnum, $from, $to)
    {
        $sql = "SELECT * FROM HRFrmApplyLU ";
        $sql .= " WHERE ReqNbr IN ";
        $sql .= " (SELECT Reference FROM TED_VIEW_NOTIFICATION WHERE EmpID ='".$idnum."' ";
        $sql .= " AND Approved IN (0,1)) ";
        $sql .= " AND DTRDate BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' ";
		$result = $this->get_numrow($sql);
		return $result;
    }

    /* FOR APPROVER CHECKING */

    function check_appexpire($dtrdate1, $dtrdate2 = NULL)
    {
        $dtr1 = strtotime($dtrdate1);
        $dtr2 = $dtrdate2 ? strtotime($dtrdate2) : 0;

        $daynum = date("j");
        if ($daynum >= 16) :
            $expdate = strtotime(date("y-m-1", strtotime("-1 month")));
        else :
            $expdate = strtotime(date("y-m-16", strtotime("-2 month")));
        endif;

        if ($dtr1 < $expdate) :
            return 1;
        else :
            if ($dtr2 && $dtr2 < $expdate) :
                return 1;
            else :
                return 0;
            endif;
        endif;
    }

    /* DTR */

    function get_dtr_year($company, $dbname = NULL)
	{
		$sql = "SELECT DISTINCT PRYear FROM HRCompanyCutOff ";
        $sql .= " WHERE CompanyID = '".$company."' AND PaymentType = 'SEMI-MONTHLY' ORDER BY PRYear DESC";
		$result = $this->get_row($sql, $dbname);
		return $result;
    }

    function get_dtr_period($year, $company, $all = 0, $dbname = NULL)
	{
        $numbdays = date("j");
        if ($numbdays <= 15) : $enddays = 15;
        else : $enddays = date("t"); endif;

		$sql = "SELECT PeriodID, PRYear, PRFrom, PRTo, PeriodFrom, PeriodTo, AttPost FROM HRCompanyCutOff WHERE PRYear='".$year."' ";
        if ($all == 0) : $sql .= " AND PeriodTo <= GETDATE() ";
        elseif ($all == 1) : $sql .= " AND PeriodTo <= '".date("m")."/".$enddays."/".date("Y")."' ";
        endif;

        $sql .= " AND CompanyID = '".$company."' AND PaymentType = 'SEMI-MONTHLY' ORDER BY PeriodID DESC";
		$result = $this->get_row($sql, $dbname);
		return $result;
    }

    function get_dtr_data($empid, $from, $to, $company, $dbname = NULL)
	{
		$sql = "SELECT DISTINCT DTRDATE, ShiftDesc, TimeINDate, TimeIN, TimeOutDate, TimeOut, LateHrs, UTHrs, Absent, LEAVETYPE, L01, L02, L03, L04, L05, L10, L12, L14, OTHrs01, OTHrs02, OTHrs03, OTHrs04, OTHrs05, OTHrs06, OTHrs07, OTHrs08, OTHrs09, OTHrs10, OTHrs11, OTHrs12, OTHrs13, OTHrs14, OTHrs15, OTHrs16, OTHrs17, OTHrs18, OTHrs19, OTHrs20, OTHrs21, OTHrs22, OTHrs23, OTHrs24, OTHrs25, WorkHrs, RegHrs, OB, ApprovedOTHrs, ActualOTHrs, NDHrs, LEAVE_DESC, L15, ML FROM viewHRDTR ";
        $sql .= " WHERE EmpID = '".$empid."' AND DTRDATE BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' ";
        $sql .= " AND Posted = (SELECT top 1 AttPost FROM HRCompanyCutOff WHERE PaymentType <> 'SPECIAL' AND PeriodFrom BETWEEN '".$from."' AND '".$to."' AND CompanyID='".$company."') ";
        $sql .= " ORDER BY DTRDATE ASC ";
		$result = $this->get_row($sql, $dbname);
		return $result;
    }

    function get_dtr_dates($empid, $from, $to, $company, $dbname = NULL)
    {
	$sql = "SELECT DISTINCT DTRDATE, ShiftDesc, TimeINDate, TimeIN, TimeOutDate, TimeOut, LateHrs, UTHrs, Absent, LEAVETYPE, L01, L02, L03, L04, L05, L10, L12, L14, OTHrs01, OTHrs02, OTHrs03, OTHrs04, OTHrs05, OTHrs06, OTHrs07, OTHrs08, OTHrs09, OTHrs10, OTHrs11, OTHrs12, OTHrs13, OTHrs14, OTHrs15, OTHrs16, OTHrs17, OTHrs18, OTHrs19, OTHrs20, OTHrs21, OTHrs22, OTHrs23, OTHrs24, OTHrs25, WorkHrs, RegHrs, OB, ApprovedOTHrs, ActualOTHrs, NDHrs, LEAVE_DESC FROM viewHRDTR ";
        $sql .= " WHERE EmpID = '".$empid."' AND COMPANYID = '".$company."' AND DTRDATE BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' ";
        $sql .= " ORDER BY DTRDATE ASC ";
	$result = $this->get_row($sql, $dbname);
	return $result;
    }



    /* RESTDAY - HOLIDAY */

    function get_restday($empid, $dtrdate)
	{
		$sql = "SELECT DAYOFF FROM FN_GETRESTDAYSCHED('".$empid."', '".$dtrdate."') ";
		$result = $this->get_row($sql);
		return $result;
    }

    function get_appliedrestday($empid, $dtrdate, $company)
	{
        $sql = "SELECT RESTDAY FROM FN_GETRESTDAYSCHEDULER('".$empid."', '".$dtrdate."', '".$company."')";
		$result = $this->get_row($sql);
		return $result;
    }

    function get_appliedsched($empid, $dtrdate, $company)
	{
		$sql = "SELECT NEWSHIFTID FROM FN_GETSHIFTSCHEDULER('".$empid."', '".$dtrdate."', '".$company."') ";
		$result = $this->get_row($sql);
		return $result;
    }

    function get_mdtrrestday($empid, $dtrdate, $company)
	{
        $sql = "SELECT RestDay FROM FN_GETRESTDAYMDTR('".$empid."', '".$dtrdate."', '".$company."')";
		$result = $this->get_row($sql);
		return $result;
    }

    function get_mdtrsched($empid, $dtrdate, $company)
	{
		$sql = "SELECT ShiftID FROM FN_GETSHIFTMDTR('".$empid."', '".$dtrdate."', '".$company."') ";
		$result = $this->get_row($sql);
		return $result;
    }

    function get_scheddef($empid, $dtrdate)
	{
		$sql = "SELECT SHIFTID FROM FN_GETSHIFTSCHED('".$empid."', '".$dtrdate."') ";
		$result = $this->get_row($sql);
		return $result;
    }

    function get_holiday($count = 0, $month = 0, $day = 0, $location = NULL)
	{
		if ($location != NULL) :
            $sql = "SELECT ID, Description, HolidayMonth, HolidayDay, Type FROM viewHolidayList ";
            $sql .= " WHERE Type = 'LC' AND HolidayMonth = '".$month.".00' AND HolidayDay = '".$day.".00' ";
            $sql .= " AND ID = '".$location."' ";
        endif;
		if ($count) :
            $result = $this->get_numrow($sql);
            if (!$result) :
                $sql2 = "SELECT ID, Description, HolidayMonth, HolidayDay, Type FROM viewHolidayList ";
                $sql2 .= " WHERE Type <> 'LC' AND HolidayMonth = '".$month.".00' AND HolidayDay = '".$day.".00' ";
                $result = $this->get_numrow($sql2);
            endif;
        else :
            $result = $this->get_row($sql);
            if (!$result) :
                $sql2 = "SELECT ID, Description, HolidayMonth, HolidayDay, Type FROM viewHolidayList ";
                $sql2 .= " WHERE Type <> 'LC' AND HolidayMonth = '".$month.".00' AND HolidayDay = '".$day.".00' ";
                $result = $this->get_row($sql2);
            endif;
        endif;

		return $result;
    }

    /* PAYSLIP */

    function get_payslip_period($year, $company, $id = 0, $all = 0)
	{
		$sql = "SELECT PeriodID, PRYear, PRFrom, PRTo, PeriodFrom, PeriodTo, PaymentType FROM HRCompanyCutOff WHERE PRYear='".$year."' AND PaymentType <> 'SPECIAL'  ";
        if ($id) : $sql .= " AND PeriodID = '".$id."' "; endif;
           // $sql .= " AND PeriodID != 'S02' ";
	    $sql .= " AND PeriodID NOT IN ('SP13', 'SP23', 'SP24') ";
        if ($all == 0) : $sql .= " AND PeriodTo <= GETDATE() "; endif;
        $sql .= " AND CompanyID = '".$company."' ORDER BY PaymentType, PeriodID DESC";
		$result = $this->get_row($sql);
		return $result;
    }

    function get_payslip_data($empid, $year, $pr)
	{
		$sql = "SELECT TOP 1 * FROM PRSummaryH ";
        $sql .= " WHERE EmpID = '".$empid."' ";
        $sql .= " AND PRYear = '".$year."' AND PeriodID = '".$pr."' ";

		$result = $this->get_row($sql);
		return $result;
    }

    function get_payslip_sldata($empid, $year, $pr)
	{
		$sql = "SELECT * FROM TED_VIEW_SL_CONVERSION_PAYSLIP ";
        $sql .= " WHERE EmpID = '".$empid."' ";
        $sql .= " AND PRYear = '".$year."' AND PeriodID = '".$pr."' ";
		$result = $this->get_row($sql);
		return $result;
    }

    function get_payslip_sldata2($empid, $year, $pr)
	{
		$sql = "SELECT * FROM TED_VIEW_SL_CONVERSION_PAYSLIP ";
        $sql .= " WHERE EmpID = '".$empid."' ";
        $sql .= " AND PRYear = '".$year."' AND PeriodID = '".$pr."' ";
		$result = $this->get_row($sql);
		return $sql;
    }

    function get_payslip_ext($ext)
	{
		$sql = "SELECT OExtDesc FROM PROtherExt ";
        $sql .= " WHERE OExtID = '".$ext."' ";
		$result = $this->get_row($sql);
		return $result;
    }

    function get_payslip_otherearn($empid, $year, $pr, $tax = 0)
	{
		$sql = "SELECT B.OExtDesc, A.Amount FROM PROtherExtMaster A, PROtherExt B ";
        $sql .= " WHERE EmpID = '".$empid."' ";
        $sql .= " AND A.OExtID LIKE 'OE%' ";
        $sql .= " AND A.PRYear = '".$year."' AND A.PeriodID = '".$pr."' AND A.OExtID = B.OExtID ";
        if ($tax == 1) : $sql .= " AND B.Taxable = 1 ";
        else : $sql .= " AND B.Taxable = 0 ";
        endif;
		$result = $this->get_row($sql);
		return $result;
    }

    function get_payslip_otherdeduct($empid, $year, $pr)
	{
		$sql = "SELECT B.OExtDesc, A.Amount FROM PROtherExtMaster A, PROtherExt B ";
        $sql .= " WHERE EmpID = '".$empid."' ";
        $sql .= " AND A.OExtID LIKE 'OD%' ";
        $sql .= " AND A.PRYear = '".$year."' AND A.PeriodID = '".$pr."' AND A.OExtID = B.OExtID ";
		$result = $this->get_row($sql);
		return $result;
    }

    function get_payslip_oedesc()
	{
		$sql = "SELECT OExtID, OExtDesc FROM PROtherExt ";
        $sql .= " WHERE OExtID LIKE 'OE%' ";
		$result = $this->get_row($sql);
		return $result;
    }

    function get_payslip_oddesc()
	{
		$sql = "SELECT OExtID, OExtDesc FROM PROtherExt ";
        $sql .= " WHERE OExtID LIKE 'OD%' ";
		$result = $this->get_row($sql);
		return $result;
    }

    function get_payslip_loan($empid)
	{
		$sql = "SELECT EmpID, Balance, OExtDesc FROM view_loan_payslip ";
        $sql .= " WHERE EmpID = '".$empid."' ";
		$result = $this->get_row($sql);
		return $result;
    }

    function get_payslip_loan2($empid, $pryear, $periodid)
    {
        $sql = "SELECT EmpID, Balance, OExtDesc FROM viewLoanLedger ";
        $sql .= " WHERE EmpID = '".$empid."' and PRYear = $pryear and PeriodID='$periodid'";
        $result = $this->get_row($sql);
        return $result;
    }

    function get_payslip_allowancetype($type)
	{
	   	if ($type == 1) :
            $sql = "SELECT * FROM PROtherExt WHERE OExtType IN ('ALLOWANCE','EARNING') AND Taxable = 0 AND Active = 1";
        elseif ($type == 2) :
            $sql = "SELECT * FROM PROtherExt WHERE OExtType IN ('ALLOWANCE','EARNING') AND Taxable = 1 AND Active = 1";
        else :
            $sql = "SELECT * FROM PROtherExt WHERE OExtType IN ('DEDUCTION') AND Active = 1";
        endif;

        $result = $this->get_row($sql);
		return $result;
    }

    function get_payslip_allownacevalue($empid, $oe, $year, $pr)
	{

        $sql = "SELECT ".$oe." FROM PRSummaryH A, PRSummaryExtH B ";
        $sql .= " WHERE A.BatNbr = B.BatNbr AND A.EmpID = '".$empid."' AND A.PRYear = '".$year."' AND A.PeriodID = '".$pr."' ";
		$result = $this->get_row($sql);
		return $result;
    }


    function get_payslip_oemaster($empid, $year, $pr, $tax = 0)
	{
		if ($tax) :
            if ($pr == 'SP21') :
                $sql = "SELECT B.OE23, B.OE24, B.OE50, B.OE26, B.OE25, B.OE50 FROM PRSummaryH A, PRSummaryExtH B ";
                $sql .= " WHERE A.BatNbr = B.BatNbr AND A.EmpID = '".$empid."' AND A.PRYear = '".$year."' AND A.PeriodID = '".$pr."' ";
            else :
                $sql = "SELECT B.OE01, B.OE03, B.OE05, B.OE07, B.OE09, B.OE10, B.OE11, B.OE13, B.OE15, B.OE17, B.OE18, B.OE21, B.OE23, B.OE25, B.OE36, B.OE38, B.OE39, B.OE40, B.OE41, B.OE43, B.OE44, B.OE45, B.OE48 FROM PRSummaryH A, PRSummaryExtH B ";
                $sql .= " WHERE A.BatNbr = B.BatNbr AND A.EmpID = '".$empid."' AND A.PRYear = '".$year."' AND A.PeriodID = '".$pr."' ";
            endif;
        else :
            if ($pr == 'SP21') :
                $sql = "SELECT B.OE23, B.OE24, B.OE50, B.OE26, B.OE25, B.OE50 FROM PRSummaryH A, PRSummaryExtH B ";
                $sql .= " WHERE A.BatNbr = B.BatNbr AND A.EmpID = '".$empid."' AND A.PRYear = '".$year."' AND A.PeriodID = '".$pr."' ";
            else :
                //$sql = "SELECT A.AllowanceAdj, B.OE02, B.OE04, B.OE06, B.OE08, B.OE12, B.OE14, B.OE16, B.OE19, B.OE20, B.OE22, B.OE24, B.OE26, B.OE27, B.OE28, B.OE29, B.OE30, B.OE31, B.OE32, B.OE33, B.OE34, B.OE35, B.OE37, B.OE42, B.OE46, B.OE47, B.OE49, B.OE50 FROM PRSummaryH A, PRSummaryExtH B ";
                $sql = "SELECT A.AllowanceAdj, B.OE02, B.OE04, B.OE06, B.OE08, B.OE12, B.OE14, B.OE16, B.OE19, B.OE20, B.OE22, B.OE24, B.OE26, B.OE27, B.OE28, B.OE29, B.OE30, B.OE31, B.OE32, B.OE33, B.OE34, B.OE35, B.OE37, B.OE42, B.OE46, B.OE47, B.OE49, B.OE50 FROM PRSummaryH A, PRSummaryExtH B ";
                $sql .= " WHERE A.BatNbr = B.BatNbr AND A.EmpID = '".$empid."' AND A.PRYear = '".$year."' AND A.PeriodID = '".$pr."' ";
            endif;
        endif;

		$result = $this->get_row($sql);
		return $result;
    }

    function get_payslip_odmaster($empid, $year, $pr)
	{
		$sql = "SELECT OD01, OD02, OD03, OD04, OD05, OD06, OD07, OD08, OD09, OD10, OD11, OD12, OD13, OD14, OD15, OD16, OD17, OD18, OD19, OD20, OD21, OD22, OD23, OD24, OD25, OD26, OD27, OD28, OD29, OD30, OD31, OD32, OD33, OD34, OD35, OD36, OD37, OD38, OD39, OD40, OD41, OD42, OD43, OD44, OD45, OD46, OD47, OD48, OD49, OD50, OD51, OD52, OD53, OD54, OD55 FROM PRSummaryExtH ";
        $sql .= " WHERE EmpID = '".$empid."' ";
        $sql .= " AND PRYear = '".$year."' AND PeriodID = '".$pr."' ";
		$result = $this->get_row($sql);
		return $result;
    }

    function get_payslip_otmaster($empid, $year, $pr)
	{
		$sql = "SELECT OTHrs01, OTPay01, OTHrs02, OTPay02, OTHrs03, OTPay03, OTHrs04, OTPay04, OTHrs05, OTPay05, OTHrs06, OTPay06, OTHrs07, OTPay07, OTHrs08, OTPay08, OTHrs09, OTPay09, OTHrs10, OTPay10, OTHrs11, OTPay11, OTHrs12, OTPay12, OTHrs13, OTPay13, OTHrs14, OTPay14, OTHrs15, OTPay15, OTHrs16, OTPay16, OTHrs17, OTPay17, OTHrs18, OTPay18, OTHrs19, OTPay19, OTHrs20, OTPay20, OTHrs21, OTPay21, OTHrs22, OTPay22, OTHrs23, OTPay23 FROM PRSummaryH ";
        $sql .= " WHERE EmpID = '".$empid."' ";
        $sql .= " AND PRYear = '".$year."' AND PeriodID = '".$pr."' ";
		$result = $this->get_row($sql);
		return $result;
    }

    function get_payslip_oeleave($empid, $year, $pr)
	{
		$sql = "SELECT OE05, OE06, OE07, OE08 FROM PRSummaryH ";
        $sql .= " WHERE EmpID = '".$empid."' ";
        $sql .= " AND PRYear = '".$year."' AND PeriodID = '".$pr."' ";
		$result = $this->get_row($sql);
		return $result;
    }

    function get_payslip_convleave($empid, $year)
	{
		$sql = "SELECT * FROM PRLeaveConvert ";
        $sql .= " WHERE EmpID = '".$empid."' ";
        $sql .= " AND CPRYear = '".$year."'";
		$result = $this->get_row($sql);
		return $result;
    }

    /* REQUEST */

    function get_request($type, $id = 0, $start = 0, $limit = 0, $search = NULL, $count = 0, $empid = NULL, $status = 0, $from = NULL, $to = NULL)
	{
        switch($type) {

            case "ot" :
                $sql = "SELECT ReqNbr, ReqDate, FromDate, ToDate, Hrs, OTType, Reason, Approved FROM HRFrmApplyOT ";
                $sql .= " WHERE ReqNbr != NULL ";
                if ($id != 0) : $sql .= " AND ReqNbr = ".$id; endif;
                if ($search != NULL) : $sql .= " AND ReqNbr LIKE '%".$search."%' "; endif;
                if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
                if ($status != 0) : $sql .= " AND Approved = '".$status."' "; endif;
                if ($from && $to) :
                    $sql .= " AND ReqDate BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' ";
                endif;
                $sql .= " ORDER BY ReqDate DESC ";
                if ($limit) :
                    $sql .= " OFFSET ".$start." ROWS ";
                    $sql .= " FETCH NEXT ".$limit." ROWS ONLY ";
                endif;
                if ($count) : $result = $this->get_numrow($sql);
                else : $result = $this->get_row($sql);
                endif;
                return $result;
            break;
            case "lv" :
                $sql = "SELECT LeaveRef, DateFiled, AbsenceFromDate, AbsenceToDate, Hrs, AbsentID, Reason, Approved FROM HRFrmApplyOT ";
                $sql .= " WHERE ReqNbr != NULL ";
                if ($id != 0) : $sql .= " AND ReqNbr = ".$id; endif;
                if ($search != NULL) : $sql .= " AND ReqNbr LIKE '%".$search."%' "; endif;
                if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
                if ($status != 0) : $sql .= " AND Approved = '".$status."' "; endif;
                if ($from && $to) :
                    $sql .= " AND ReqDate BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' ";
                endif;
                $sql .= " ORDER BY ReqDate DESC ";
                if ($limit) :
                    $sql .= " OFFSET ".$start." ROWS ";
                    $sql .= " FETCH NEXT ".$limit." ROWS ONLY ";
                endif;
                if ($count) : $result = $this->get_numrow($sql);
                else : $result = $this->get_row($sql);
                endif;
                return $result;
            break;
            case "ma" :
            break;
            case "ob" :
            break;
            case "ts" :
            break;
            case "np" :
            break;
            case "md" :
            break;
            case "sc" :
            break;

        }
    }

    # APPLICATION

    # Overtime

    function get_dtr_bydate($empid, $date)
	{
		$sql = "SELECT DTRDATE, ShiftDesc, TimeINDate, TimeOutDate, TimeIN, TimeOut, LateHrs, UTHrs, Absent, LEAVETYPE, L01, L02, L03, L04, L05, OTHrs01, OTHrs02, OTHrs03, OTHrs04, OTHrs05, OTHrs06, OTHrs07, OTHrs08, OTHrs09, OTHrs10, OTHrs11, OTHrs12, OTHrs13, OTHrs14, OTHrs15, OTHrs16, OTHrs17, OTHrs18, OTHrs19, OTHrs20, OTHrs21, OTHrs22, OTHrs23, OTHrs24, OTHrs25, WorkHrs, RegHrs, OB, ApprovedOTHrs, NDHrs, LEAVE_DESC FROM viewHRDTR ";
        $sql .= " WHERE EmpID = '".$empid."' AND DTRDATE = '".date("m/d/Y", strtotime($date))."' ";
        $sql .= " ORDER BY POSTED DESC ";
		$result = $this->get_row($sql);
		return $result;
    }


    function get_schedshiftdtr($empid = NULL, $date)
	{
		$sql = "SELECT TOP 1 ShiftID, ShiftDesc, TimeIN, TimeOut, CreditTimeIN, CreditTimeOut, LateHrs, UTHrs
            FROM viewHRDTR
            WHERE DTRDate = '".date("m/d/Y", strtotime($date))."' ";
        if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
		$result = $this->get_row($sql);
		return $result;
    }

    function get_otout($empid, $date)
    {
        $sql = "SELECT [TimeOut]=CONVERT(CHAR(8), DATEADD(MINUTE,(SELECT NUMHrs FROM HRShift WHERE ShiftID=HRDTR.ShiftID)*60, CONVERT(CHAR(10), TIMEINDATE, 101) + ' ' + CONVERT(CHAR(8), CASE WHEN TimeIN>CreditTimeIN THEN TimeIN ELSE CreditTimeIN END, 108)),108) FROM HRDTR ";
        $sql .= " WHERE EMPID = '".$empid."' AND DTRDate = '".date("m/d/Y", strtotime($date))."'";
		$result = $this->get_row($sql);
		return $result;
    }

    # Leave

    function get_schedshift($empid = NULL)
	{
		$sql = "SELECT MonShiftID, TueShiftID, WedShiftID, ThuShiftID, FriShiftID, SatShiftID, SunShiftID
            FROM HREmpShiftSchedule
            WHERE (EffectivityDate <= GETDATE() OR EffectivityDate = NULL) AND (ApprovedDate <= GETDATE() OR ApprovedDate = NULL) ";
        if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
		$result = $this->get_row($sql);
		return $result;
    }

    function get_shift($shiftid = NULL)
	{
		$sql = "SELECT ShiftID, ShiftDesc, TimeIN, TimeOUT, NUMHrs, BreakIN, BreakOUT, BreakHours
            FROM HRShift ";
        $sql .= " WHERE Active = 1 ";
        if ($shiftid != NULL) : $sql .= " AND ShiftID = '".$shiftid."' "; endif;
		$result = $this->get_row($sql);
		return $result;
    }

    function get_shiftdtr($empid, $date, $dbname)
    {
    $sql = "select '060' as SHIFT, '08:00:00.0000000' as STARTTIME, '18:00:00.0000000' as STARTTIME, '10' as NUMHRS";
      $result = $this->get_row($sql);

      return $result;
    }

    function get_logs($id = NULL, $start = 0, $limit = 0, $search = NULL, $count = 0, $from = NULL, $to = NULL)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY Date DESC) as ROW_NUMBER, ";
        $sql .= " EmpID, Tasks, Data, Date FROM HRWebLogs ";
        $sql .= " WHERE EmpID != NULL ";
        if ($id != NULL) : $sql .= " AND EmpID = '".$id."' "; endif;
        if ($search != NULL) : $sql .= " AND (EmpID LIKE '%".$search."%') "; endif;
        if ($from && $to) :
            $sql .= " AND Date BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' ";
        endif;
        $sql .= ") AS [outer] ";
        if ($limit) :
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

        if ($count) : $result = $this->get_numrow($sql);
        else : $result = $this->get_row($sql);
        endif;
		return $result;
	}

    # ACTIONS

    function dtr_action($value, $action, $id = 0)
	{
        $val = array();

		switch ($action) {
			case 'calculate':

                $accepted_field = array('strEMPID', 'dteDTRDate', 'OVERWRITE', 'STATUS', 'intFINALPAY');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;

                        $knum++;
                    endif;
                endforeach;

                $calculate_dtr = $this->get_sp_data('SP_COMPUTE_TK', $val);

                if($calculate_dtr) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;
            case 'delentry':

                $accepted_field = array('EMPID', 'DTRDATE', 'STATUS');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;

                        $knum++;
                    endif;
                endforeach;

                $delete_dtr = $this->get_sp_data('SP_DELETE_RECORD', $val);

                if($delete_dtr) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;

        }
    }

    function approver_action($value, $action, $id = 0)
	{
        $val = array();

		switch ($action) {
            case 'migrate':

                $sql = "INSERT INTO GLMEmpSignatory (EMPID, SIGNATORY1, SIGNATORYID1, TYPE) VALUES ('".$value."', 'BRANCO, ARLENE AYSON', '2014-10-0004', 'frmApplicationLVWeb') ";
                $exec = $this->get_execute($sql);
                $sql = "INSERT INTO GLMEmpSignatory (EMPID, SIGNATORY1, SIGNATORYID1, TYPE) VALUES ('".$value."', 'BRANCO, ARLENE AYSON', '2014-10-0004', 'frmApplicationOTWeb') ";
                $exec = $this->get_execute($sql);
                $sql = "INSERT INTO GLMEmpSignatory (EMPID, SIGNATORY1, SIGNATORYID1, TYPE) VALUES ('".$value."', 'BRANCO, ARLENE AYSON', '2014-10-0004', 'frmApplicationOBWeb') ";
                $exec = $this->get_execute($sql);
                $sql = "INSERT INTO GLMEmpSignatory (EMPID, SIGNATORY1, SIGNATORYID1, TYPE) VALUES ('".$value."', 'BRANCO, ARLENE AYSON', '2014-10-0004', 'frmApplicationMDWeb') ";
                $exec = $this->get_execute($sql);
                $sql = "INSERT INTO GLMEmpSignatory (EMPID, SIGNATORY1, SIGNATORYID1, TYPE) VALUES ('".$value."', 'BRANCO, ARLENE AYSON', '2014-10-0004', 'frmApplicationSCWeb') ";
                $exec = $this->get_execute($sql);
                $sql = "INSERT INTO GLMEmpSignatory (EMPID, SIGNATORY1, SIGNATORYID1, TYPE) VALUES ('".$value."', 'BRANCO, ARLENE AYSON', '2014-10-0004', 'frmApplicationNPWeb') ";
                $exec = $this->get_execute($sql);
                //return $sql;

                if($exec) {
                    return TRUE;
                } else {
                    return FALSE;
                }

            break;
			case 'update':

                $dbname = $value['DBNAME'];
                //var_dump($dbname);

                $accepted_field = array('EMPID', 'TYPE', 'SIGNATORYID01', 'SIGNATORYID02', 'SIGNATORYID03', 'SIGNATORYID04', 'SIGNATORYID05', 'SIGNATORYID06', 'SIGNATORYDB01', 'SIGNATORYDB02', 'SIGNATORYDB03', 'SIGNATORYDB04', 'SIGNATORYDB05', 'SIGNATORYDB06', 'ALTID01', 'ALTID02', 'ALTID03', 'ALTID04', 'ALTID05', 'ALTID06', 'ALTIDDB01', 'ALTIDDB02', 'ALTIDDB03', 'ALTIDDB04', 'ALTIDDB05', 'ALTIDDB06');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;

                        $knum++;
                    endif;
                endforeach;

                $update_appr = $this->get_sp_data('INSERTAPPROVER', $val, $dbname);

                if($update_appr) {
                    return 1;
                } else {
                    return 0;
                }

			break;
        }
    }

    function activity_action($value, $action, $id = 0)
	{
        $val = array();


		switch ($action) {
			case 'add':

                $accepted_field = array(activity_type, activity_title, activity_venue, activity_description, activity_datestart, activity_dateend, activity_approve, activity_cvehicle, activity_guest, activity_dependent, activity_feedback, activity_offsite, activity_ads, activity_slots, activity_filename, activity_user, activity_date, activity_endregister, activity_status, activity_db);

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'activity_type' || $key == 'activity_status' || $key == 'activity_approve' || $key == 'activity_cvehicle' || $key == 'activity_guest' || $key == 'activity_dependent' || $key == 'activity_feedback' || $key == 'activity_offsite' || $key == 'activity_ads' || $key == 'activity_slots' || $key == 'activity_endregister') :
                            $val[$knum]['field_type'] = SQLINT1;
                        elseif ($key == 'activity_datestart' || $key == 'activity_dateend' || $key == 'activity_user' || $key == 'activity_date') :
                            $val[$knum]['field_type'] = SQLINT4;
                        else :
                            $val[$knum]['field_type'] = SQLVARCHAR;
                            $val[$knum]['field_maxlen'] = 512;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $knum++;
                    endif;
                endforeach;

                $add_activity = $this->get_sp_data('SP_ADD_ACTIVITY', $val);

                if($add_activity) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;

            case 'update':

                $accepted_field = array(activity_id, activity_type, activity_title, activity_venue, activity_description, activity_datestart, activity_dateend, activity_approve, activity_cvehicle, activity_guest, activity_dependent, activity_feedback, activity_ads, activity_slots, activity_date);

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'activity_type' || $key == 'activity_approve' || $key == 'activity_cvehicle' || $key == 'activity_guest' || $key == 'activity_dependent' || $key == 'activity_feedback' || $key == 'activity_slots') :
                            $val[$knum]['field_type'] = SQLINT1;
                        elseif ($key == 'activity_datestart' || $key == 'activity_dateend' || $key == 'activity_date') :
                            $val[$knum]['field_type'] = SQLINT4;
                        else :
                            $val[$knum]['field_type'] = SQLVARCHAR;
                            $val[$knum]['field_maxlen'] = 512;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $knum++;
                    endif;
                endforeach;

                $val[$knum]['field_name'] = 'activity_id';
                $val[$knum]['field_value'] = $id;
                $val[$knum]['field_type'] = SQLINT4;
                $val[$knum]['field_isoutput'] = false;
                $val[$knum]['field_isnull'] = false;
                $val[$knum]['field_maxlen'] = 16;

                $update_activity = $this->get_sp_data('SP_UPDATE_ACTIVITY', $val);

                if($update_activity) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;

            case 'update_attach':

                $accepted_field = array('activity_filename');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;
                        $knum++;
                    endif;
                endforeach;

                $val[$knum]['field_name'] = 'activity_id';
                $val[$knum]['field_value'] = $id;
                $val[$knum]['field_type'] = SQLINT4;
                $val[$knum]['field_isoutput'] = false;
                $val[$knum]['field_isnull'] = false;
                $val[$knum]['field_maxlen'] = 16;


                $update_actattach = $this->get_sp_data('SP_UPDATE_ACTATTACH', $val);

                if($update_actattach) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;

            case 'delete':

                $val[$knum]['field_name'] = 'activity_id';
                $val[$knum]['field_value'] = $id;
                $val[$knum]['field_type'] = SQLINT4;
                $val[$knum]['field_isoutput'] = false;
                $val[$knum]['field_isnull'] = false;
                $val[$knum]['field_maxlen'] = 16;

                $delete_act = $this->get_sp_data('SP_DELETE_ACTIVITY', $val);

                if($delete_act) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;
		}
	}



    function memo_action($value, $action, $id = 0)
	{
        $val = array();


		switch ($action) {
			case 'add':

                $accepted_field = array('memo_title', 'memo_attachtype', 'memo_date', 'memo_user', 'memo_status', 'memo_type');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'memo_status' || $key == 'memo_type') :
                            $val[$knum]['field_type'] = SQLINT1;
                        else :
                            $val[$knum]['field_type'] = SQLVARCHAR;
                            $val[$knum]['field_maxlen'] = 512;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $knum++;
                    endif;
                endforeach;

                $add_memo = $this->get_sp_data('SP_ADD_MEMO', $val);

                if($add_memo) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;

            case 'update':

                $accepted_field = array('memo_title', 'memo_date', 'memo_user');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;
                        $knum++;
                    endif;
                endforeach;

                $val[$knum]['field_name'] = 'memo_id';
                $val[$knum]['field_value'] = $id;
                $val[$knum]['field_type'] = SQLINT4;
                $val[$knum]['field_isoutput'] = false;
                $val[$knum]['field_isnull'] = false;
                $val[$knum]['field_maxlen'] = 16;

                $update_memo = $this->get_sp_data('SP_UPDATE_MEMO', $val);

                if($update_memo) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;

            case 'update_attach':

                $accepted_field = array('memo_attach', 'memo_attachtype');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;
                        $knum++;
                    endif;
                endforeach;

                $val[$knum]['field_name'] = 'memo_id';
                $val[$knum]['field_value'] = $id;
                $val[$knum]['field_type'] = SQLINT4;
                $val[$knum]['field_isoutput'] = false;
                $val[$knum]['field_isnull'] = false;
                $val[$knum]['field_maxlen'] = 16;


                $update_attach = $this->get_sp_data('SP_UPDATE_ATTACH', $val);

                if($update_attach) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;

            case 'delete':

                $val[$knum]['field_name'] = 'memo_id';
                $val[$knum]['field_value'] = $id;
                $val[$knum]['field_type'] = SQLINT4;
                $val[$knum]['field_isoutput'] = false;
                $val[$knum]['field_isnull'] = false;
                $val[$knum]['field_maxlen'] = 16;

                $delete_memo = $this->get_sp_data('SP_DELETE_MEMO', $val);

                if($delete_memo) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;
		}
	}

    function attach_action($value, $action, $id = 0)
	{
        $val = array();

		switch ($action) {
			case 'add':

                $accepted_field = array('attachfile', 'attachtype', 'reqnbr');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;
                        $knum++;
                    endif;
                endforeach;

                $add_attach = $this->get_sp_data('SP_ADD_ATTACH', $val);

                if($add_attach) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;
        }
    }

    function leave_action($value, $action, $id = 0)
	{
        $val = array();

		switch ($action) {
			case 'add':

                //$accepted_field = array('EMPID', 'REQNBR', 'TRANS', 'ABSENTID', 'ABSENTFROMDATE', 'ABSENTTODATE', 'DAYS', 'HOURS', 'REASON', 'APPROVER01', 'APPROVER02', 'APPROVER03', 'APPROVER04', 'APPROVER05', 'APPROVER06', 'USER', 'REMARKS');

                $accepted_field = array('EMPID', 'REQNBR', 'TRANS', 'ABSENTID', 'ABSENTFROMDATE', 'ABSENTTODATE', 'DAYS', 'HOURS', 'REASON', 'APPROVER01', 'APPROVER02', 'APPROVER03', 'APPROVER04', 'APPROVER05', 'APPROVER06', 'DBAPPROVER01', 'DBAPPROVER02', 'DBAPPROVER03', 'DBAPPROVER04', 'DBAPPROVER05', 'DBAPPROVER06', 'USER', 'REMARKS');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'DAYS' || $key == 'HOURS') :
                            $val[$knum]['field_type'] = SQLFLT8;
                        else :
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;

                        $knum++;
                    endif;
                endforeach;

                $add_leave = $this->get_sp_data_status('SP_INSERT_APPLY_LV', $val);

                if($add_leave) {
                    return $add_leave;
                } else {
                    return FALSE;
                }

			break;

            case 'add_item':

                $accepted_field = array('EMPID', 'REQNBR', 'DURATION', 'LEAVEDATE', 'WITHPAY', 'ABSENTID');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'WITHPAY') :
                            $val[$knum]['field_type'] = SQLINT1;
                        else :
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;
                        $knum++;
                    endif;
                endforeach;

                $add_litem = $this->get_sp_data_status('SP_INSERT_LEAVEITEM', $val);

                if($add_litem) {
                    return $add_litem;
                } else {
                    return FALSE;
                }

			break;

            case 'approve':

                $dbname = $value['DBNAME'];

                $accepted_field = array('REQNBR', 'TRANS', 'USER', 'EMPID', 'REMARKS');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;
                        $knum++;
                    endif;
                endforeach;

                $approve_leave = $this->get_sp_data('SP_INSERT_APPLY_LV', $val, $dbname);

                if($approve_leave) {
                    return 1;
                } else {
                    return 0;
                }

			break;

            case 'lvitemcancel':

                $accepted_field = array('REQ', 'DTRDATE', 'STATUS');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;
                        $knum++;
                    endif;
                endforeach;

                $cancel_lvitem = $this->get_sp_data('SP_CANCEL_LEAVE', $val);

                if($cancel_lvitem) {
                    return '1';
                } else {
                    return '0';
                }

			break;
        }
    }

    function ot_action($value, $action, $id = 0)
	{
        $val = array();

		switch ($action) {
			case 'add':

                $accepted_field = array('EMPID', 'REQNBR', 'TRANS', 'APLYHRS', 'APPROVEDHRS', 'FROMDATE', 'TODATE', 'DTRDATE', 'REASON', 'OTTYPE', 'APPROVER01', 'APPROVER02', 'APPROVER03', 'APPROVER04', 'APPROVER05', 'APPROVER06', 'DBAPPROVER01', 'DBAPPROVER02', 'DBAPPROVER03', 'DBAPPROVER04', 'DBAPPROVER05', 'DBAPPROVER06', 'USER', 'REMARKS');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'APLYHRS' || $key == 'APPROVEDHRS') :
                            $val[$knum]['field_type'] = SQLFLT8;
                        else :
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;

                        $knum++;
                    endif;
                endforeach;

                $add_ot = $this->get_sp_data_status('SP_INSERT_APPLY_OT', $val);

                if($add_ot) {
                    return $add_ot;
                } else {
                    return FALSE;
                }

			break;

            case 'approve':

                $dbname = $value['DBNAME'];

                $accepted_field = array('APPROVEDHRS', 'REQNBR', 'TRANS', 'OTTYPE', 'USER', 'EMPID', 'REMARKS');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;
                        $knum++;
                    endif;
                endforeach;

                $approve_ot = $this->get_sp_data_status('SP_INSERT_APPLY_OT', $val, $dbname);

                if($approve_ot) {
                    return 1;
                } else {
                    return 0;
                }

			break;
        }
    }

    function ob_action($value, $action, $id = 0)
	{
        $val = array();

		switch ($action) {
			case 'add':

                $accepted_field = array('EMPID', 'REQNBR', 'TRANS', 'OBTIMEINDATE', 'OBTIMEOUTDATE', 'DAYS', 'DESTINATION', 'REASON', 'APPROVER01', 'APPROVER02', 'APPROVER03', 'APPROVER04', 'APPROVER05', 'APPROVER06', 'DBAPPROVER01', 'DBAPPROVER02', 'DBAPPROVER03', 'DBAPPROVER04', 'DBAPPROVER05', 'DBAPPROVER06', 'USER', 'REMARKS');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'DAYS') :
                            $val[$knum]['field_type'] = SQLFLT8;
                        else :
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;

                        $knum++;
                    endif;
                endforeach;

                $add_ob = $this->get_sp_data_status('SP_INSERT_APPLY_OBT', $val);

                if($add_ob) {
                    return $add_ob;
                } else {
                    return FALSE;
                }

			break;

            case 'add_item':

                $accepted_field = array('REQNBR', 'OBTIMEINDATE', 'OBTIMEOUTDATE', 'ACTUALTIMEINDATE', 'ACTUALTIMEOUTDATE');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;
                        $knum++;
                    endif;
                endforeach;

                $add_obitem = $this->get_sp_data_status('SP_INSERT_OBTITEM', $val);

                if($add_obitem) {
                    return $add_obitem;
                } else {
                    return FALSE;
                }

			break;

            case 'approve':

                $dbname = $value['DBNAME'];

                $accepted_field = array('REQNBR', 'TRANS', 'USER', 'EMPID', 'REMARKS');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;
                        $knum++;
                    endif;
                endforeach;

                $approve_ob = $this->get_sp_data('SP_INSERT_APPLY_OBT', $val, $dbname);

                if($approve_ob) {
                    return 1;
                } else {
                    return 0;
                }

			break;

            case 'obitemcancel':

                $seqid = $value['SEQID'];

                $sql = "UPDATE HRFrmApplyNoticeOfficialBusinessItem ";
                $sql .= " SET Status = 'CANCELLED' ";
                $sql .= " WHERE SeqID = '".$seqid."' ";
                $result = $this->get_execute($sql);
                return $result ? 1 : 0;

			break;
        }
    }

	function wh_action($value, $action, $id = 0)
	{
        $val = array();

		switch ($action) {
			case 'add':

                $accepted_field = array('EMPID', 'REQNBR', 'TRANS', 'DATESTART', 'DATEEND','APPROVER01', 'APPROVER02', 'APPROVER03', 'APPROVER04', 'APPROVER05', 'APPROVER06', 'DBAPPROVER01', 'DBAPPROVER02', 'DBAPPROVER03', 'DBAPPROVER04', 'DBAPPROVER05', 'DBAPPROVER06', 'USER', 'REMARKS');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;

                        $knum++;
                    endif;
                endforeach;

                $add_md = $this->get_sp_data_status('SP_INSERT_APPLY_WH', $val);

                if($add_md) {
                    return $add_md;
                } else {
                    return FALSE;
                }

			break;

            case 'add_item':

                $accepted_field = array('REQNBR', 'DTRDATE', 'AppliedHrs', 'Activities');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'RESTDAY') :
                            $val[$knum]['field_type'] = SQLINT1;
                        else :
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;
                        $knum++;
                    endif;
                endforeach;

                $add_mditem = $this->get_sp_data_status('SP_INSERT_WHITEM', $val);

                if($add_mditem) {
                    return $add_mditem;
                } else {
                    return FALSE;
                }

			break;

            case 'approve':

                $dbname = $value['DBNAME'];

				$data = json_decode($value['data'], true);


				foreach($data as $key => $valu){
					$sql = "UPDATE HRFrmApplyWFHItem set ApprovedHrs = $valu[ApprovedHrs] where SeqID = $valu[SeqID]";
					$result = $this->get_execute($sql, $dbname);
				}

                $accepted_field = array('REQNBR', 'TRANS', 'USER', 'EMPID', 'REMARKS');

                $knum = 0;

				unset($value['data']);

                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;
                        $knum++;
                    endif;
                endforeach;

                $approve_wh = $this->get_sp_data('SP_INSERT_APPLY_WH', $val, $dbname);

                if($approve_wh) {
                    return 1;
                } else {
                    return 0;
                }

			break;
        }
    }

    function md_action($value, $action, $id = 0)
	{
        $val = array();

		switch ($action) {
			case 'add':

                $accepted_field = array('EMPID', 'REQNBR', 'TRANS', 'DATESTART', 'APPROVER01', 'APPROVER02', 'APPROVER03', 'APPROVER04', 'APPROVER05', 'APPROVER06', 'DBAPPROVER01', 'DBAPPROVER02', 'DBAPPROVER03', 'DBAPPROVER04', 'DBAPPROVER05', 'DBAPPROVER06', 'USER', 'REMARKS');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;

                        $knum++;
                    endif;
                endforeach;

                $add_md = $this->get_sp_data_status('SP_INSERT_APPLY_MD', $val);

                if($add_md) {
                    return $add_md;
                } else {
                    return FALSE;
                }

			break;

            case 'add_item':

                $accepted_field = array('REQNBR', 'DTRDATE', 'SHIFTDESC', 'TIMEINDATE', 'TIMEOUTDATE', 'TIMEIN', 'TIMEOUT', 'NEWSHIFTDESC', 'RESTDAY', 'SHIFTID');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'RESTDAY') :
                            $val[$knum]['field_type'] = SQLINT1;
                        else :
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;
                        $knum++;
                    endif;
                endforeach;

                $add_mditem = $this->get_sp_data_status('SP_INSERT_MDITEM', $val);

                if($add_mditem) {
                    return $add_mditem;
                } else {
                    return FALSE;
                }

			break;

            case 'approve':

                $dbname = $value['DBNAME'];

                $accepted_field = array('REQNBR', 'TRANS', 'USER', 'EMPID', 'REMARKS');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;
                        $knum++;
                    endif;
                endforeach;

                $approve_md = $this->get_sp_data('SP_INSERT_APPLY_MD', $val, $dbname);

                if($approve_md) {
                    return 1;
                } else {
                    return 0;
                }

			break;

            case 'mditemcancel':

                $accepted_field = array('REQ', 'DTRDATE', 'STATUS');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;
                        $knum++;
                    endif;
                endforeach;

                $cancel_mditem = $this->get_sp_data('SP_CANCEL_MANUALDTR', $val);

                if($cancel_mditem) {
                    return '1';
                } else {
                    return '0';
                }

			break;
        }
    }

    function np_action($value, $action, $id = 0)
	{
        $val = array();

		switch ($action) {
			case 'add':

                $accepted_field = array('EMPID', 'REQNBR', 'TRANS', 'ACTUALTIMEIN', 'ACTUALTIMEOUT', 'TIMEIN', 'TIMEOUT', 'DATEIN', 'DATEOUT', 'REASON', 'APPROVER01', 'APPROVER02', 'APPROVER03', 'APPROVER04', 'APPROVER05', 'APPROVER06', 'DBAPPROVER01', 'DBAPPROVER02', 'DBAPPROVER03', 'DBAPPROVER04', 'DBAPPROVER05', 'DBAPPROVER06', 'USER', 'REMARKS');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;

                        $knum++;
                    endif;
                endforeach;

                $add_np = $this->get_sp_data_status('SP_INSERT_APPLY_NPA', $val);

                if($add_np) {
                    return $add_np;
                } else {
                    return FALSE;
                }

			break;

            case 'approve':

                $dbname = $value['DBNAME'];

                $accepted_field = array('REQNBR', 'TRANS', 'USER', 'EMPID', 'REMARKS');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;
                        $knum++;
                    endif;
                endforeach;

                $approve_np = $this->get_sp_data('SP_INSERT_APPLY_NPA', $val, $dbname);

                if($approve_np) {
                    return 1;
                } else {
                    return 0;
                }

			break;
        }
    }

    function sc_action($value, $action, $id = 0)
	{
        $val = array();

		switch ($action) {
			case 'add':

                $accepted_field = array('EMPID', 'REQNBR', 'TRANS', 'DATESTART', 'APPROVER01', 'APPROVER02', 'APPROVER03', 'APPROVER04', 'APPROVER05', 'APPROVER06', 'DBAPPROVER01', 'DBAPPROVER02', 'DBAPPROVER03', 'DBAPPROVER04', 'DBAPPROVER05', 'DBAPPROVER06', 'USER', 'REMARKS');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;

                        $knum++;
                    endif;
                endforeach;

                $add_sc = $this->get_sp_data_status('SP_INSERT_APPLY_SC', $val);

                if($add_sc) {
                    return $add_sc;
                } else {
                    return FALSE;
                }

			break;

            case 'add_item':

                $accepted_field = array('REQNBR', 'DTRDATE', 'SHITID', 'TIMEIN', 'TIMEOUT', 'NEWSHITDESC', 'NEWSHITID', 'RESTDAY');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'RESTDAY') :
                            $val[$knum]['field_type'] = SQLINT1;
                        else :
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;
                        $knum++;
                    endif;
                endforeach;

                $add_scitem = $this->get_sp_data_status('SP_INSERT_SCITEM', $val);

                if($add_scitem) {
                    return $add_scitem;
                } else {
                    return FALSE;
                }

			break;

            case 'approve':

                $dbname = $value['DBNAME'];

                $accepted_field = array('REQNBR', 'TRANS', 'USER', 'EMPID', 'REMARKS');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;
                        $knum++;
                    endif;
                endforeach;

                $approve_sc = $this->get_sp_data('SP_INSERT_APPLY_SC', $val, $dbname);

                if($approve_sc) {
                    return '1';
                } else {
                    return '0';
                }

			break;

            case 'scitemcancel':

                $accepted_field = array('REQ', 'DTRDATE', 'STATUS');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;
                        $knum++;
                    endif;
                endforeach;

                $cancel_scitem = $this->get_sp_data('SP_CANCEL_TIMESCHEDULER', $val);

                if($cancel_scitem) {
                    return '1';
                } else {
                    return '0';
                }

			break;
        }
    }

    function ts_action($value, $action, $id = 0)
	{
        $val = array();

		switch ($action) {

            case 'approve':

                $dbname = $value['DBNAME'];

                $accepted_field = array('REQNBR', 'TRANS', 'USER', 'EMPID', 'REMARKS');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;
                        $knum++;
                    endif;
                endforeach;

                $approve_ts = $this->get_sp_data('SP_INSERT_APPLY_TS', $val, $dbname);

                if($approve_ts) {
                    return 1;
                } else {
                    return 0;
                }

			break;
        }
    }

    function lu_action($value, $action, $id = 0)
	{
        $val = array();

		switch ($action) {
			case 'add':

                $accepted_field = array('EMPID', 'REQNBR', 'TRANS', 'APLYHRS', 'DTRDATE', 'LUTYPE', 'APPROVER01', 'APPROVER02', 'APPROVER03', 'APPROVER04', 'APPROVER05', 'APPROVER06', 'DBAPPROVER01', 'DBAPPROVER02', 'DBAPPROVER03', 'DBAPPROVER04', 'DBAPPROVER05', 'DBAPPROVER06', 'USER', 'REMARKS');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'APLYHRS') :
                            $val[$knum]['field_type'] = SQLFLT8;
                        else :
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;

                        $knum++;
                    endif;
                endforeach;

                $add_ul = $this->get_sp_data_status('SP_INSERT_APPLY_UL', $val);

                if($add_ul) {
                    return $add_ul;
                } else {
                    return FALSE;
                }

			break;

            case 'approve':

                $dbname = $value['DBNAME'];

                $accepted_field = array('REQNBR', 'TRANS', 'LUTYPE', 'USER', 'EMPID', 'REMARKS');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;
                        $knum++;
                    endif;
                endforeach;

                $approve_ul = $this->get_sp_data('SP_INSERT_APPLY_UL', $val, $dbname);

                if($approve_ul) {
                    return 1;
                } else {
                    return 0;
                }

			break;
        }
    }

    function log_action($value, $action, $id = 0)
	{
        $val = array();

		switch ($action) {
			case 'add':

                $accepted_field = array('EMPID', 'TASKS', 'DATA', 'DATE');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        $val[$knum]['field_type'] = SQLVARCHAR;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;

                        $knum++;
                    endif;
                endforeach;

                $val[$knum]['field_name'] = 'IP';
                $val[$knum]['field_value'] = $_SERVER['REMOTE_ADDR'];
                $val[$knum]['field_type'] = SQLVARCHAR;
                $val[$knum]['field_isoutput'] = false;
                $val[$knum]['field_isnull'] = false;
                $val[$knum]['field_maxlen'] = 512;

                $knum++;

                $val[$knum]['field_name'] = 'MACHNAME';
                $val[$knum]['field_value'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
                $val[$knum]['field_type'] = SQLVARCHAR;
                $val[$knum]['field_isoutput'] = false;
                $val[$knum]['field_isnull'] = false;
                $val[$knum]['field_maxlen'] = 512;

                $add_log = $this->get_sp_data('SP_ADD_LOG', $val);

                if($add_log) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;
        }
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
