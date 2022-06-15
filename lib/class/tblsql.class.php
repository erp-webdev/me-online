<?php

class tblsql {

    public function db_connect() //connect to database
	{
        $result = mssql_connect(DBHOST, DBUSER, DBPASS);
        if(!$result) return false;
        else return $result;
	}
    public function db_select($con) //connect to database
	{
        $result = mssql_select_db(DBNAME, $con);
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

	# TBLSQL CLASS

    function get_sp_data_status($sp_name, $parameters = NULL, $dbname = NULL)
	{
        // TYPE:
        // 1 - array
        // 2 - num_row

        $status = 0;
        $con = $this->db_connect();

        $maindb = DBNAME;

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

        $maindb = DBNAME;

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



    function get_employee($start = 0, $limit = 0, $search = NULL, $count = 0, $dbname = NULL)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY LName ASC) as ROW_NUMBER, ";
        $sql .= " EmpID, FName, MName, LName, EmailAdd, CompanyID,
            SSSNbr, PhilHealthNbr, PagibigNbr, LocationID, AccountNo, EPassword, DBNAME
            FROM VIEWHREMPMASTER ";
        $sql .= " WHERE EmpID != '' AND CompanyActive = 1 ";
        if ($dbname) : $sql .= " AND DBNAME = '".$dbname."' "; endif;
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

    function get_employee_with_inactive($start = 0, $limit = 0, $search = NULL, $count = 0, $dbname = NULL)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY LName ASC) as ROW_NUMBER, ";
        $sql .= " EmpID, FName, MName, LName, EmailAdd, CompanyID,
            SSSNbr, PhilHealthNbr, PagibigNbr, LocationID, AccountNo, EPassword, DBNAME
            FROM VIEWHREMPMASTER_INACTIVE ";
        $sql .= " WHERE EmpID != '' AND CompanyActive = 1 ";
        if ($dbname) : $sql .= " AND DBNAME = '".$dbname."' "; endif;
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

    function get_users_access($start = 0, $limit = 0, $search = NULL, $count = 0, $dbname)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY Fullname ASC) as ROW_NUMBER, ";
        $sql .= " *
            FROM MEAccess ";
        $sql .= " WHERE EmpID != ''";
        if ($dbname) : $sql .= " AND CompanyDB = '".$dbname."' "; endif;
        if ($search != NULL) : $sql .= " AND (EmpID = '".$search."' OR Fullname LIKE '%".$search."%') "; endif;
        $sql .= ") AS [outer] ";
        if ($limit) :
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

		if ($count) : $result = $this->get_numrow($sql);
        else : $result = $this->get_row($sql);
        endif;
		return $result;
	}

    function get_employee_byid($id = 0, $start = 0, $limit = 0, $count = 0, $dbname = NULL)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY LName ASC) as ROW_NUMBER, ";
        $sql .= " EmpID, FName, MName, LName, EmailAdd, CompanyID,
            SSSNbr, PhilHealthNbr, PagibigNbr, LocationID, AccountNo, EPassword, DBNAME
            FROM VIEWHREMPMASTER ";
        $sql .= " WHERE EmpID != '' AND CompanyActive = 1 ";
        if ($dbname) : $sql .= " AND DBNAME = '".$dbname."' "; endif;
        if ($id != 0) : $sql .= " AND EmpID = '".$id."'"; endif;
        $sql .= ") AS [outer] ";
        if ($limit) :
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

		if ($count) : $result = $this->get_numrow($sql);
        else : $result = $this->get_row($sql);
        endif;
		return $result;
	}

    function get_employee_bydept($dept = NULL)
	{
		$sql = "SELECT EmpID, FName, MName, LName, EmailAdd, CompanyID, DBNAME
            FROM VIEWHREMPMASTER ";
        $sql .= " WHERE EmpID != '' ";
        if ($dept) : $sql .= " AND DeptID = '".$dept."' "; endif;

        $result = $this->get_row($sql);
		return $result;
	}

    function get_appemployee($start = 0, $limit = 0, $search = NULL, $count = 0)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY LName ASC) as ROW_NUMBER, ";
        $sql .= " EmpID, FName, MName, LName, EmailAdd, CompanyID,
            SSSNbr, PhilHealthNbr, PagibigNbr, LocationID, AccountNo, EPassword, DBNAME
            FROM VIEWHREMPMASTER ";
        $sql .= " WHERE EmpID != '' ";
        if ($search != NULL) : $sql .= " AND (EmpID = '".$search."' OR LName LIKE '%".$search."%' OR FName LIKE '%".$search."%') "; endif;
        $sql .= " AND Active = 1 AND CompanyActive = 1";
        $sql .= ") AS [outer] ";
        if ($limit) :
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;
        // echo $sql;
		if ($count) : $result = $this->get_numrow($sql);
        else : $result = $this->get_row($sql);
        endif;
		return $result;
	}

    function get_upemployee2($start = 0, $limit = 0, $search = NULL, $count = 0)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY LName ASC) as ROW_NUMBER, ";
        $sql .= " EmpID, LName, FName, MName, NickName, EmailAdd, EmailAdd2, UnitStreet, Barangay, TownCity, StateProvince, Zip, Region, Country, MobileNumber, ContactPerson, ContactAddress, ContactTelNbr, ContactMobileNbr, DBNAME
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

    function get_users_updates()
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY EmpID ASC) as ROW_NUMBER, ";
        $sql .= " EmpID, DBNAME, Date
            FROM HRUpdateEmpList ";
        $sql .= ") AS [outer] ";
        if ($limit) :
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

        $result = $this->get_row($sql);

		return $result;
	}

    function get_users_email($start = 0, $limit = 0, $search = NULL, $count = 0)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY LName ASC) as ROW_NUMBER, ";
        $sql .= " EmpID, FName, LName, EmailAdd
            FROM VIEWHREMPMASTER ";
        $sql .= " WHERE Active = 1 AND CompanyActive = 1";
        $sql .= ") AS [outer] ";
        if ($limit) :
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

		if ($count != 0) $result = $this->get_numrow($sql);
        else $result = $this->get_row($sql);

		return $result;
	}

    function get_users_bulkmail($start = 0, $limit = 0, $search = NULL, $count = 0, $db = NULL)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY LName ASC) as ROW_NUMBER, ";
        $sql .= " EmpID, FullName, FName, LName, EmailAdd
            FROM VIEWHREMPMASTER ";
        $sql .= " WHERE Active = 1 AND CompanyActive = 1";
        $sql .= " AND EmailAdd IS NOT NULL ";
        if ($db != NULL) $sql.=" AND DBNAME = '".$db."'";
        $sql .= ") AS [outer] ";
        if ($limit) :
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;
		if ($count != 0) $result = $this->get_numrow($sql);
        else $result = $this->get_row($sql);

		return $result;
	}

    function get_users_birthday($start = 0, $limit = 0, $bday = NULL, $count = 0, $not = 0)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY LName ASC) as ROW_NUMBER, ";
        $sql .= " EmpID, FullName, FName, LName, EmailAdd, BirthDate, CompanyID, DBNAME
            FROM VIEWHREMPMASTER ";
        $sql .= " WHERE Active = 1 AND CompanyActive = 1";
        //$sql .= " AND EmpID = '2014-01-N506'";
        if ($bday) :
            $sql .= " AND DAY(BirthDate) = DAY('".$bday."') AND MONTH(BirthDate) = MONTH('".$bday."')";
        else :
            if ($not) :
                $sql .= " AND EmpID NOT IN(SELECT EmpID FROM VIEWHREMPMASTER WHERE Active = 1 AND CompanyActive = 1 AND DAY(BirthDate) = DAY(GETDATE()) AND MONTH(BirthDate) = MONTH(GETDATE()) AND EmailAdd IS NOT NULL AND BirthDate IS NOT NULL )";
            else :
                $sql .= " AND DAY(BirthDate) = DAY(GETDATE()) AND MONTH(BirthDate) = MONTH(GETDATE())";
            endif;
        endif;
        $sql .= " AND EmailAdd IS NOT NULL AND BirthDate IS NOT NULL ";
        $sql .= ") AS [outer] ";
        if ($limit) :
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

		if ($count != 0) $result = $this->get_numrow($sql);
        else $result = $this->get_row($sql);

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

        if ($id || $empid || $limit) :
            $result = $this->get_numrow($sql);
		    return $result;
        else :
		    return 0;
        endif;
    }

    /* NOTIFICATION */


    function get_notification($id = NULL, $start = 0, $limit = 0, $search = NULL, $count = 0, $empid = NULL, $from = NULL, $to = NULL, $dtype = NULL, $dbname = NULL)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY DateFiled DESC) as ROW_NUMBER, ";
        $sql .= " EmpID, DateFiled, DocType, Reference, ApprovedDate01, ApprovedDate02, ApprovedDate03, ApprovedDate04, ApprovedDate05, ApprovedDate06,
            Signatory01, Signatory02, Signatory03, Signatory04, Signatory05, Signatory06,
            DB_NAME01, DB_NAME02, DB_NAME03, DB_NAME04, DB_NAME05, DB_NAME06,
            Remarks01, Remarks02, Remarks03, Remarks04, Remarks05, Remarks06, Approved, RejectedDate, POSTEDDATE, APPROVALDATE, DBNAME FROM TED_VIEW_NOTIFICATION ";
        $sql .= " WHERE EmpID != '' ";
        if ($id != NULL) : $sql .= " AND Reference = '".$id."' "; endif;
        if ($search != NULL) : $sql .= " AND (Reference LIKE '%".$search."%' OR EmpID LIKE '%".$search."%' OR FULLNAME LIKE '%".$search."%') "; endif;
        if ($dtype != NULL) : $sql .= " AND DocType = '".$dtype."' "; endif;
        if ($empid != NULL) : $sql .= " AND ((EmpID = '".$empid."' AND DBNAME = '".$dbname."') OR ((Signatory01 = '".$empid."' AND SignatoryDB01 = '".$dbname."') OR (Signatory02 = '".$empid."' AND SignatoryDB02 = '".$dbname."') OR (Signatory03 = '".$empid."' AND SignatoryDB03 = '".$dbname."') OR (Signatory04 = '".$empid."' AND SignatoryDB04 = '".$dbname."') OR (Signatory05 = '".$empid."' AND SignatoryDB05 = '".$dbname."') OR (Signatory06 = '".$empid."' AND SignatoryDB06 = '".$dbname."')) AND Approved != 3) "; endif;
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

        if ($id || $empid || $limit) :
            if ($count) : $result = $this->get_numrow($sql);
            else : $result = $this->get_row($sql);
            endif;
		    return $result;
        else :
		    return 0;
        endif;
	}

    //TO BE FIXED (May 31, 2018)

    function get_pendingnoti($id = NULL, $start = 0, $limit = 0, $search = NULL, $count = 0, $empid = NULL, $from = NULL, $to = NULL, $dtype = NULL, $dbname = NULL)
	{
		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY DateFiled DESC) as ROW_NUMBER, ";
        $sql .= " EmpID, DateFiled, DocType, Reference, ApprovedDate01, ApprovedDate02, ApprovedDate03, ApprovedDate04, ApprovedDate05, ApprovedDate06,
            Signatory01, Signatory02, Signatory03, Signatory04, Signatory05, Signatory06,
            SignatoryDB01, SignatoryDB02, SignatoryDB03, SignatoryDB04, SignatoryDB05, SignatoryDB06, Approved, POSTEDDATE, DBNAME FROM TED_VIEW_NOTIFICATION2 ";
        $sql .= " WHERE EmpID != '' AND Approved = 0 ";
        if ($id != NULL) : $sql .= " AND Reference = '".$id."' "; endif;
        if ($search != NULL) : $sql .= " AND (Reference LIKE '%".$search."%' OR EmpID LIKE '%".$search."%' OR FULLNAME LIKE '%".$search."%') "; endif;
        if ($dtype != NULL) : $sql .= " AND DocType = '".$dtype."' "; endif;
        if ($empid != NULL) : $sql .= " AND ((EmpID = '".$empid."' AND DBNAME = '".$dbname."') OR ((Signatory01 = '".$empid."' AND SignatoryDB01 = '".$dbname."') OR (Signatory02 = '".$empid."' AND SignatoryDB02 = '".$dbname."') OR (Signatory03 = '".$empid."' AND SignatoryDB03 = '".$dbname."') OR (Signatory04 = '".$empid."' AND SignatoryDB04 = '".$dbname."') OR (Signatory05 = '".$empid."' AND SignatoryDB05 = '".$dbname."') OR (Signatory06 = '".$empid."' AND SignatoryDB06 = '".$dbname."')) AND Approved != 3) "; endif;
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

        if ($id || $empid || $limit) :
            if ($count) : $result = $this->get_numrow($sql);
            else : $result = $this->get_row($sql);
            endif;
		    return $result;
        else :
		    return 0;
        endif;
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
                        Reason, Approved, CreatedDate FROM viewApplyLeave ";
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
        if ($db != NULL) :
            if ($db == 'MLI' || $db == 'CITYLINK' || $db == 'ECOC' || $db == 'EREX' || $db == 'LCTM' || $db == 'NCCAI' || $db == 'SUNSTRUST' || $db == 'TOWNSQUARE') :
                $sql .= " AND activity_db = 'MEGAWORLD' ";
            elseif ($db == '999') :
                $sql .= " ";
            else :
                $sql .= " AND activity_db = '".$db."' ";
            endif;
        endif;
		if ($id != 0) $sql.=" AND activity_id = ".$id;
		//if ($not_all != 0) $sql.=" AND activity_dateend >= DATEDIFF(SECOND, '1970-01-01', GETDATE()) ";
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

    function chk_registered($actid, $uid)
	{

		$sql="SELECT r.registry_id ";
		$sql.=" FROM HREventRegistry r
			WHERE r.registry_status >= 1
            AND r.registry_activityid = ".$actid."
            AND r.registry_uid = '".$uid."'";

		$result = $this->get_numrow($sql);

		return $result;
	}

    function cnt_registered($actid)
	{

		$sql="SELECT r.registry_child, r.registry_guest, r.registry_dependent ";
		$sql.=" FROM HREventRegistry r
			WHERE r.registry_status >= 1
            AND r.registry_activityid = ".$actid;

		$result = $this->get_row($sql, 1);

		return $result;
	}

    function get_registration($id = 0, $start = 0, $limit = 0, $count = 0, $uid = NULL, $db = NULL)
	{
        $sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY registry_date DESC) as ROW_NUMBER, ";
		$sql .= " r.registry_id, a.activity_id, a.activity_title, a.activity_type, a.activity_venue, a.activity_datestart, a.activity_dateend, a.activity_backout, r.registry_uid, r.registry_godirectly, r.registry_vrin, r.registry_vrout, r.registry_details, r.registry_platenum, r.registry_child, r.registry_guest, r.registry_dependent, r.registry_date, r.registry_status, r.registry_hash ";
		$sql.=" FROM HREventRegistry r, HRActivity a ";
		$sql.=" WHERE r.registry_status >= 1
            AND r.registry_activityid = a.activity_id ";

		if ($db != NULL) $sql.=" AND r.registry_db = '".$db."'";
		if ($id != 0) $sql.=" AND r.registry_id = ".$id;
		if ($uid != NULL) $sql.=" AND r.registry_uid = '".$uid."'";
		if ($actid != 0) $sql.=" AND r.registry_activityid = '".$actid."'";
        $sql .= ") AS [outer] ";
        if ($limit) :
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;


		if ($count != 0) $result = $this->get_numrow($sql);
        else $result = $this->get_row($sql, 1);

		return $result;
	}

    function get_registrant($id = 0, $start = 0, $limit = 0, $count = 0, $actid = 0)
	{
        $sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY registry_date DESC) as ROW_NUMBER, ";
		$sql .= " r.registry_id, e.EmpID, e.LName, e.FName, e.EmailAdd,
            r.registry_uid, r.registry_godirectly, r.registry_details, r.registry_vrin, r.registry_vrout, r.registry_platenum, r.registry_child, r.registry_guest, r.registry_dependent, r.registry_date, r.registry_status, r.registry_hash ";
		$sql.=" FROM HREventRegistry r, VIEWHREMPMASTER e ";
		$sql.=" WHERE r.registry_status >= 1
            AND r.registry_uid = e.EmpID AND e.CompanyActive = 1 AND r.registry_db = e.DBNAME ";
		if ($id != 0) $sql.=" AND r.registry_id = ".$id;
		if ($actid != 0) $sql.=" AND r.registry_activityid = ".$actid;
        $sql .= ") AS [outer] ";
        if ($limit) :
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

		if ($count != 0) $result = $this->get_numrow($sql);
        else $result = $this->get_row($sql, 1);

		return $result;
	}

    function get_registrantmd5($id = NULL, $start = 0, $limit = 0, $count = 0, $actid = 0)
	{

        $sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY registry_date DESC) as ROW_NUMBER, ";
		$sql .= " r.registry_id, e.EmpID, e.LName, e.FName, e.EmailAdd,
            r.registry_uid, r.registry_godirectly, r.registry_details, r.registry_vrin, r.registry_vrout, r.registry_platenum, r.registry_child, r.registry_guest, r.registry_dependent, r.registry_date, r.registry_status, r.registry_hash ";
		$sql.=" FROM HREventRegistry r, VIEWHREMPMASTER e ";
		$sql.=" WHERE r.registry_status >= 1
            AND r.registry_uid = e.EmpID AND e.CompanyActive = 1 ";
		if ($id != NULL) $sql.=" AND CONVERT(NVARCHAR(32), HASHBYTES('MD5', CONVERT(VARCHAR,  r.registry_id, 2)), 2) = '".$id."'";
		if ($actid != 0) :
            if ($actid == 2106) :
                $sql.=" AND r.registry_activityid IN (2661, 2660)";
            else :
                $sql.=" AND r.registry_activityid = ".$actid;
            endif;
        endif;
        $sql .= ") AS [outer] ";
        if ($limit) :
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;


		if ($count != 0) $result = $this->get_numrow($sql);
        else $result = $this->get_row($sql, 1);

		return $result;
	}

    function get_staff($start = 0, $limit = 0, $count = 0, $headid = 0)
    {
        $sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY registry_date DESC) as ROW_NUMBER, ";
        $sql .= " r.registry_id, r.registry_activityid, e.EmpID, e.LName, e.FName, e.EmailAdd,
            r.registry_uid, r.registry_godirectly, r.registry_details, r.registry_vrin, r.registry_vrout,
			r.registry_platenum, r.registry_child, r.registry_guest, r.registry_dependent, r.registry_date, r.registry_status, r.registry_hash ";
		$sql.=" FROM VIEWHREMPMASTER e, HREventRegistry r ";
		$sql.=" WHERE e.Active = 1 AND r.registry_status = 1 AND r.registry_offsite = 0 AND r.registry_uid = e.EmpID AND e.CompanyActive = 1 ";
		if ($headid != 0) $sql.=" AND r.registry_approver = '".$headid."'";
        $sql .= ") AS [outer] ";
        if ($limit) :
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

		if ($count != 0) $result = $this->get_numrow($sql);
        else $result = $this->get_row($sql, 1);

		return $result;
    }

    function get_feedback($uid = 0, $actid = 0, $count = 0, $registryid = 0)
	{
        if ($actid != 0) :
            $sqliffb = "SELECT a.activity_feedback ";
            $sqliffb .= " FROM HRActivity a
                WHERE a.activity_status >= 1
                AND a.activity_id = ".$actid;
            $activity_fb = $this->get_row($sqliffb, 1);

            if ($activity_fb[0]['activity_feedback'] == 1) :
                $sql = "SELECT f.fback_rate, f.fback_comment, f.fback_date ";
                $sql .= " FROM HRFeedback f
                    WHERE f.fback_status >= 1 ";
                if ($uid != 0) $sql.=" AND f.fback_empid = '".$uid."'";
                if ($actid != 0) $sql.=" AND f.fback_activityid = ".$actid;
                if ($registryid != 0) $sql.=" AND f.fback_registryid = ".$registryid;

                if ($count != 0) $result = $this->get_numrow($sql);
                else $result = $this->get_row($sql, 1);
            else :
                $result = 1;
            endif;
        else :
            $sql = "SELECT f.fback_rate, f.fback_comment, f.fback_date ";
            $sql .= " FROM HRFeedback f
                WHERE f.fback_status >= 1 ";
            if ($uid != 0) $sql.=" AND f.fback_empid = '".$uid."'";
            if ($actid != 0) $sql.=" AND f.fback_activityid = ".$actid;
            if ($registryid != 0) $sql.=" AND f.fback_registryid = ".$registryid;

            if ($count != 0) $result = $this->get_numrow($sql);
            else $result = $this->get_row($sql, 1);
        endif;

		return $result;
	}



    /* MEMORANDUM */

    function get_memos($id = 0, $start = 0, $limit = 0, $search = NULL, $count = 0, $from = 0, $to = 0, $db = NULL)
	{

		$sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY m.announce_date DESC) as ROW_NUMBER, ";
        $sql .= " m.announce_id, m.announce_title, m.announce_date, m.announce_user, m.announce_receiver, m.announce_flag, m.announce_path, m.announce_attach, m.announce_filename, m.announce_pubdate, m.announce_db ";
		$sql.=" FROM HRMemo m ";
        $sql.=" WHERE m.announce_status = 1 ";
		if ($db != NULL) :
            if ($db == 'MLI' || $db == 'CITYLINK' || $db == 'ECOC' || $db == 'EREX' || $db == 'LCTM' || $db == 'NCCAI' || $db == 'SUNSTRUST' || $db == 'TOWNSQUARE') :
                $sql .= " AND m.announce_db = 'MEGAWORLD' ";
            else :
                $sql .= " AND m.announce_db = '".$db."' ";
            endif;
        endif;
		if ($search != NULL) $sql.=" AND m.announce_title LIKE '%".$search."%'";
		if ($id != 0) $sql.=" AND m.announce_id = ".$id;
        if ($from && $to) :
            $sql .= " AND m.announce_date BETWEEN ".$from." AND ".$to." ";
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

    /* DOWNLOADS */

    function get_form($id = 0, $start = 0, $limit = 0, $search = NULL, $count = 0, $cat = NULL, $catonly = 0)
	{

		$sql = "SELECT [outer].* FROM ( ";
        if ($catonly != 0) $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY d.download_cat ASC) as ROW_NUMBER, ";
        else $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY d.download_title ASC) as ROW_NUMBER, ";
        $sql .= "  ";
        $sql .= ($catonly != 0 ? " d.download_cat " : " d.download_id, d.download_title, d.download_attach, d.download_attachtype, d.download_filename, d.download_cat, d.download_user ");
		$sql.=" FROM HRDownload d
			WHERE d.download_status = 1";
		if ($search != NULL) $sql.=" AND d.download_title LIKE '%".$search."%'";
		if ($id != 0) $sql.=" AND d.download_id = ".$id;
		if ($cat != NULL) $sql.=" AND d.download_cat = '".$cat."' ";
        if ($catonly != 0) $sql .= " GROUP BY d.download_cat ";
        $sql .= ") AS [outer] ";
        if ($limit) :
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

        if ($count) : $result = $this->get_numrow($sql);
        else : $result = $this->get_row($sql);
        endif;

		return $result;
	}

    function get_form_icon($type, $filename = 0)
	{
        $apptype = explode('/', $type);
        $filetype = explode('.', $filename);
        if ($apptype[0] == 'image') : return 'fa-file-image-o';
        elseif ($apptype[0] == 'application') :
            if ($apptype[1] == 'pdf') : return 'fa-file-pdf-o';
            else :
                if ($filetype[1]) :
                    if ($filetype[1] == 'docx' || $filetype[1] == 'doc') : return 'fa-file-pdf-o';
                    elseif ($filetype[1] == 'xlsx' || $filetype[1] == 'xls') : return 'fa-file-excel-o';
                    elseif ($filetype[1] == 'pptx' || $filetype[1] == 'ppt') : return 'fa-file-powerpoint-o';
                    else : return 'fa-file-code-o'; endif;
                else :
                    return 'fa-file-code-o';
                endif;
            endif;
        else :
            return 'fa-file-code-o';
        endif;
	}

    function get_form_link($filename = 0)
	{
        $filetype = explode('.', $filename);

        if ($filetype[1]) :
            if ($filetype[1] == 'docx' || $filetype[1] == 'doc' || $filetype[1] == 'xlsx' || $filetype[1] == 'xls' || $filetype[1] == 'pptx' || $filetype[1] == 'ppt' || $filetype[1] == 'pdf') : return $this->cleanstring($filename);
            else : return 'image'; endif;
        else :
            return 'image';
        endif;
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
                        Reason, Approved, CreatedDate FROM viewApplyLeave ";
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
                $sql .= " ReqNbr, EmpID, ReqDate, DateStart, Posted, PostedDate, StatusForms FROM HRFrmManualDTR ";
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
                $sql .= " SeqID, EmpID, convert(varchar, AppliedDate, 121) as AppliedDate, FromDate, ToDate, Reference, ItemID, DTRDate, AppliedHrs, ApprovedHrs, TotalWorkedHrs, Activities, Status, Remarks, approvaldate, APPROVEDST, Approved FROM viewApplyWH ";
                $sql .= " WHERE SeqID != 0 ";
                if ($id != NULL) : $sql .= " AND Reference = '".$id."' "; endif;
                if ($search != NULL) : $sql .= " AND Reference LIKE '%".$search."%' "; endif;
                if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."' "; endif;
                if ($status != NULL) : $sql .= " AND Approved = '".$status."' ";
                endif;
                if ($from && $to) :
                    $sql .= " AND AppliedDate BETWEEN '".$from." 00:00:00.000' AND '".$to." 23:59:59.000' ";
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

	function get_whdata($whref = NULL)
    {
        $sql = "SELECT Reference, SeqID, convert(varchar, DTRDate, 121) as DTRDate, AppliedHrs, ApprovedHrs, TotalWorkedHrs, Status, Activities, Remarks FROM HRFrmApplyWFHItem ";
        if ($whref != NULL) : $sql .= " WHERE Reference = '".$whref."' AND Status != 'CANCELLED' "; endif;
		$result = $this->get_row($sql);
		return $result;
    }

    function get_obtdata($obtref = NULL)
    {
        $sql = "SELECT SeqID, ObTimeInDate, ObTimeOutDate, Status, ActualTimeInDate, ActualTimeOutDate FROM HRFrmApplyNoticeOfficialBusinessItem ";
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

    /* IMAGES */

    function get_image($type = 0, $id = 0)
    {
        // 1 - profile
        // 2 - attachments
        // 3 - activity

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

    # ACTIVITY REGISTRATION

    function addeventregistry($dept = 0, $actid, $godirectly = 0)
    {
        $users = $this->get_employee_bydept($dept);

        $cnt = 0;

        foreach($users as $key => $value) :

            $sql="DELETE FROM HREventRegistry WHERE
                registry_activityid = ".$actid." AND
                registry_uid = '".$value['EmpID']."'";

            $del_reg = $this->get_execute($sql);

            $sql2="INSERT INTO HREventRegistry (registry_activityid, registry_uid, registry_godirectly, registry_vrin, registry_vrout, registry_date, registry_status)
                VALUES (".$actid.", '".$value['EmpID']."', ".($godirectly ? 1 : 0).", ".($godirectly ? 0 : 1).", ".($godirectly ? 0 : 1).", ".date('U').", 2)";

            $add_reg = $this->get_execute($sql2);

            if($add_reg) :
                $cnt++;
            endif;

        endforeach;

        return $cnt;
    }

    function attendeventregistry($value, $id)
    {
        $value = extract($value);

        // $sql="UPDATE HREventRegistry
        //     SET registry_vehicle = '".$registry_vehicle."',
        //     registry_dateattend = '".date('U')."',
        //     registry_status = 4
        //     WHERE registry_id = ".$id;
         $sql="UPDATE HREventRegistry
            SET registry_vehicle = '',
            registry_dateattend = '".date('U')."',
            registry_status = 4
            WHERE registry_id = ".$id;

        $edit_reg = $this->get_execute($sql);
    }

    # DEPARTMENT

    function get_dept($id = NULL, $dbname = NULL)
    {

        $sql = "SELECT * FROM HRDepartment ";
        if ($id != NULL) : $sql .= " WHERE DeptID = '".$id."'"; endif;

		$result = $this->get_row($sql, $dbname);

		return $result;
    }

    # BIRTHDAY

    function get_bdayimg($id = 0, $start = 0, $limit = 0, $count = 0)
	{

        $sql = "SELECT [outer].* FROM ( ";
        $sql .= " SELECT ROW_NUMBER() OVER(ORDER BY bimg_id DESC) as ROW_NUMBER, ";
        $sql .= " * FROM HRBdayImg ";
        $sql.=" WHERE bimg_status = 1 ";
		if ($id != 0) $sql.=" AND bimg_id = ".$id;
        $sql .= ") AS [outer] ";
        if ($limit) :
            $sql .= " WHERE [outer].[ROW_NUMBER] BETWEEN ".(intval($start) + 1)." AND ".intval($start + $limit)." ORDER BY [outer].[ROW_NUMBER] ";
        endif;

        if ($count) : $result = $this->get_numrow($sql);
        else : $result = $this->get_row($sql);
        endif;
		return $result;
	}

    # SETTING

    function get_set($count = 0)
	{
		$sql="SELECT TOP 1 s.set_mailfoot, s.set_numrows, s.set_lastnotify
			FROM SYSetting s";

        if ($count == 1) $result = $this->get_numrow($sql);
		else $result = $this->get_row($sql);

		return $result;
	}

    # APPLICATION

    function register_action($value, $action, $id = 0)
	{
        $val = array();


		switch ($action) {
			case 'add':

                $accepted_field = array('registry_activityid', 'registry_uid', 'registry_offidnum', 'registry_offname', 'registry_offcomp', 'registry_offpos', 'registry_godirectly', 'registry_vrin', 'registry_vrout', 'registry_details', 'registry_platenum', 'registry_child', 'registry_dependent', 'registry_guest', 'registry_date', 'registry_dateattend', 'registry_approver', 'registry_auto', 'registry_offsite', 'registry_status', 'registry_db');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'registry_offcomp' || $key == 'registry_godirectly' || $key == 'registry_vrin' || $key == 'registry_vrout' || $key == 'registry_child' || $key == 'registry_dependent' || $key == 'registry_guest' || $key == 'registry_auto' || $key == 'registry_offsite' || $key == 'registry_status') :
                            $val[$knum]['field_type'] = SQLINT1;
                        elseif ($key == 'registry_activityid' || $key == 'registry_date' || $key == 'registry_dateattend') :
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

                $add_reg = $this->get_sp_data_status('SP_ADD_REGISTER', $val);

                if($add_reg) {
                    return $add_reg;
                } else {
                    return FALSE;
                }

			break;

            case 'approve':

                $val[$knum]['field_name'] = 'registry_id';
                $val[$knum]['field_value'] = $id;
                $val[$knum]['field_type'] = SQLINT4;
                $val[$knum]['field_isoutput'] = false;
                $val[$knum]['field_isnull'] = false;
                $val[$knum]['field_maxlen'] = 16;

                $approve_reg = $this->get_sp_data('SP_APP_REGISTER', $val);

                if($approve_reg) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;

            case 'feedback':

                $accepted_field = array('fback_registryid', 'fback_activityid', 'fback_empid', 'fback_rate', 'fback_comment', 'fback_date');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'fback_empid' || $key == 'fback_comment') :
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        else :
                            $val[$knum]['field_type'] = SQLINT4;
                            $val[$knum]['field_maxlen'] = 512;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $knum++;
                    endif;
                endforeach;

                $feedback_reg = $this->get_sp_data_status('SP_ADD_FEEDBACK', $val);

                if($feedback_reg) {
                    return $feedback_reg;
                } else {
                    return FALSE;
                }

			break;

            case 'delfeedback':

                $val[$knum]['field_name'] = 'fback_registryid';
                $val[$knum]['field_value'] = $id;
                $val[$knum]['field_type'] = SQLINT4;
                $val[$knum]['field_isoutput'] = false;
                $val[$knum]['field_isnull'] = false;
                $val[$knum]['field_maxlen'] = 16;

                $delete_fback = $this->get_sp_data('SP_DELETE_FEEDBACK', $val);

                if($delete_fback) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;

            case 'delete':

                $val[$knum]['field_name'] = 'registry_id';
                $val[$knum]['field_value'] = $id;
                $val[$knum]['field_type'] = SQLINT4;
                $val[$knum]['field_isoutput'] = false;
                $val[$knum]['field_isnull'] = false;
                $val[$knum]['field_maxlen'] = 16;

                $delete_reg = $this->get_sp_data('SP_DEL_REGISTER', $val);

                if($delete_reg) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;
		}
	}

    function ads_action($value, $action, $id = 0)
	{
        $val = array();

		switch ($action) {
			case 'add':

                $accepted_field = array('activity_type', 'activity_title', 'activity_venue', 'activity_description', 'activity_datestart', 'activity_dateend', 'activity_approve', 'activity_cvehicle', 'activity_guest', 'activity_dependent', 'activity_feedback', 'activity_offsite', 'activity_hours', 'activity_ads', 'activity_slots', 'activity_filename', 'activity_user', 'activity_date', 'activity_user', 'activity_endregister', 'activity_backout', 'activity_status', 'activity_db');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'activity_type' || $key == 'activity_status' || $key == 'activity_approve' || $key == 'activity_cvehicle' || $key == 'activity_guest' || $key == 'activity_dependent' || $key == 'activity_feedback' || $key == 'activity_offsite' || $key == 'activity_ads' || $key == 'activity_slots' || $key == 'activity_endregister' || $key == 'activity_backout') :
                            $val[$knum]['field_type'] = SQLINT1;
                        elseif ($key == 'activity_datestart' || $key == 'activity_dateend' || $key == 'activity_user' || $key == 'activity_date') :
                            $val[$knum]['field_type'] = SQLINT4;
                        elseif ($key == 'activity_hours') :
                            $val[$knum]['field_type'] = SQLFLT4;
                        else :
                            $val[$knum]['field_type'] = SQLVARCHAR;
                            $val[$knum]['field_maxlen'] = 512;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $knum++;
                    endif;
                endforeach;

                $add_ads = $this->get_sp_data_status('SP_ADD_ADS', $val);

                if($add_ads) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;

            case 'update':

                $accepted_field = array('activity_id', 'activity_title', 'activity_date', 'activity_user');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'activity_user' || $key == 'activity_date') :
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

                $update_ads = $this->get_sp_data('SP_UPDATE_ADS', $val);

                if($update_ads) {
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


                $update_actattach = $this->get_sp_data('SP_ATTACH_ADS', $val);

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

                $delete_ads = $this->get_sp_data('SP_DELETE_ADS', $val);

                if($delete_ads) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;
		}
	}

    function activity_action($value, $action, $id = 0)
	{
        $val = array();

		switch ($action) {
			case 'add':

                $accepted_field = array('activity_type', 'activity_title', 'activity_venue', 'activity_description', 'activity_datestart', 'activity_dateend', 'activity_approve', 'activity_cvehicle', 'activity_guest', 'activity_dependent', 'activity_feedback', 'activity_offsite', 'activity_hours', 'activity_ads', 'activity_slots', 'activity_filename', 'activity_user', 'activity_date', 'activity_user', 'activity_endregister', 'activity_backout', 'activity_status', 'activity_db');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'activity_type' || $key == 'activity_status' || $key == 'activity_approve' || $key == 'activity_cvehicle' || $key == 'activity_guest' || $key == 'activity_dependent' || $key == 'activity_feedback' || $key == 'activity_offsite' || $key == 'activity_ads' || $key == 'activity_endregister' || $key == 'activity_backout') :
                            $val[$knum]['field_type'] = SQLINT1;
                        elseif ($key == 'activity_datestart' || $key == 'activity_dateend' || $key == 'activity_user' || $key == 'activity_date' || $key == 'activity_slots') :
                            $val[$knum]['field_type'] = SQLINT4;
                        elseif ($key == 'activity_hours') :
                            $val[$knum]['field_type'] = SQLFLT4;
                        else :
                            $val[$knum]['field_type'] = SQLVARCHAR;
                            $val[$knum]['field_maxlen'] = 512;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $knum++;
                    endif;
                endforeach;

                $add_activity = $this->get_sp_data_status('SP_ADD_ACT', $val);

                if($add_activity) {
                    return $add_activity;
                } else {
                    return FALSE;
                }

			break;

            case 'update':

                $accepted_field = array('activity_id', 'activity_type', 'activity_title', 'activity_venue', 'activity_description', 'activity_datestart', 'activity_dateend', 'activity_approve', 'activity_cvehicle', 'activity_guest', 'activity_dependent', 'activity_feedback', 'activity_offsite', 'activity_hours', 'activity_slots', 'activity_user', 'activity_date', 'activity_endregister', 'activity_backout');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'activity_type' || $key == 'activity_approve' || $key == 'activity_cvehicle' || $key == 'activity_guest' || $key == 'activity_dependent' || $key == 'activity_feedback' || $key == 'activity_offsite' || $key == 'activity_endregister' || $key == 'activity_backout') :
                            $val[$knum]['field_type'] = SQLINT1;
                        elseif ($key == 'activity_datestart' || $key == 'activity_dateend' || $key == 'activity_user' || $key == 'activity_date' || $key == 'activity_slots') :
                            $val[$knum]['field_type'] = SQLINT4;
                        elseif ($key == 'activity_hours') :
                            $val[$knum]['field_type'] = SQLFLT4;
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

                $update_activity = $this->get_sp_data('SP_UPDATE_ACT', $val);

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


                $update_actattach = $this->get_sp_data('SP_ATTACH_ACT', $val);

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

                $delete_act = $this->get_sp_data('SP_DELETE_ACT', $val);

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

                $accepted_field = array('announce_title', 'announce_date', 'announce_attach', 'announce_attachtype', 'announce_path', 'announce_filename', 'announce_flag', 'announce_receiver', 'announce_user', 'announce_pubdate', 'announce_status', 'announce_db');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'announce_flag' || $key == 'announce_receiver' || $key == 'announce_status') :
                            $val[$knum]['field_type'] = SQLINT1;
                        elseif ($key == 'announce_user' || $key == 'announce_pubdate') :
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

                $add_memo = $this->get_sp_data_status('SP_ADD_MEMO', $val);

                if($add_memo) {
                    return $add_memo;
                } else {
                    return FALSE;
                }

			break;

            case 'update':

                $accepted_field = array('announce_id', 'announce_title', 'announce_date', 'announce_user');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'announce_user' || $key == 'announce_date') :
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

                $val[$knum]['field_name'] = 'announce_id';
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

                $accepted_field = array('announce_filename');

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

                $val[$knum]['field_name'] = 'announce_id';
                $val[$knum]['field_value'] = $id;
                $val[$knum]['field_type'] = SQLINT4;
                $val[$knum]['field_isoutput'] = false;
                $val[$knum]['field_isnull'] = false;
                $val[$knum]['field_maxlen'] = 16;


                $update_memoattach = $this->get_sp_data('SP_ATTACH_MEMO', $val);

                if($update_memoattach) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;

            case 'delete':

                $val[$knum]['field_name'] = 'announce_id';
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


    function form_action($value, $action, $id = 0)
	{
        $val = array();

		switch ($action) {
			case 'add':

                $accepted_field = array('download_title', 'download_cat', 'download_filename', 'download_attach', 'download_attachtype', 'download_user', 'download_pubdate', 'download_status');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'download_status') :
                            $val[$knum]['field_type'] = SQLINT1;
                        elseif ($key == 'download_pubdate' || $key == 'download_user') :
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

                $add_form = $this->get_sp_data_status('SP_ADD_FORM', $val);

                if($add_form) {
                    return $add_form;
                } else {
                    return FALSE;
                }

			break;

            case 'update':

                $accepted_field = array('download_id', 'download_title', 'download_cat', 'download_user', 'download_pubdate');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'download_pubdate') :
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

                $val[$knum]['field_name'] = 'download_id';
                $val[$knum]['field_value'] = $id;
                $val[$knum]['field_type'] = SQLINT4;
                $val[$knum]['field_isoutput'] = false;
                $val[$knum]['field_isnull'] = false;
                $val[$knum]['field_maxlen'] = 16;

                $update_form = $this->get_sp_data('SP_UPDATE_FORM', $val);

                if($update_form) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;

            case 'update_attach':

                $accepted_field = array('download_filename');

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

                $val[$knum]['field_name'] = 'download_id';
                $val[$knum]['field_value'] = $id;
                $val[$knum]['field_type'] = SQLINT4;
                $val[$knum]['field_isoutput'] = false;
                $val[$knum]['field_isnull'] = false;
                $val[$knum]['field_maxlen'] = 16;


                $update_formattach = $this->get_sp_data('SP_ATTACH_FORM', $val);

                if($update_formattach) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;

            case 'delete':

                $val[$knum]['field_name'] = 'download_id';
                $val[$knum]['field_value'] = $id;
                $val[$knum]['field_type'] = SQLINT4;
                $val[$knum]['field_isoutput'] = false;
                $val[$knum]['field_isnull'] = false;
                $val[$knum]['field_maxlen'] = 16;

                $delete_form = $this->get_sp_data('SP_DELETE_FORM', $val);

                if($delete_form) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;
		}
	}

    function bday_action($value, $action, $id = 0)
	{
        $val = array();

		switch ($action) {
			case 'add':

                $accepted_field = array('bimg_message', 'bimg_filename1', 'bimg_filename2', 'bimg_filename3', 'bimg_user', 'bimg_date', 'bimg_status');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'bimg_status') :
                            $val[$knum]['field_type'] = SQLINT1;
                        elseif ($key == 'bimg_date') :
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

                $add_bimg = $this->get_sp_data_status('SP_ADD_BIMG', $val);

                if($add_bimg) {
                    return $add_bimg;
                } else {
                    return FALSE;
                }

			break;

            case 'delete_all':

                $delete_bimg = $this->get_sp_data('SP_DELETE_BIMG', $val);

                if($delete_bimg) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;
		}
	}

    function setting_action($value, $action)
	{
        $value = $value ? extract($value) : NULL;

		switch ($action) {

            case 'update':

                $sql="UPDATE SYSetting
                    SET set_numrows = '".$set_numrows."',
                    set_mailfoot = '".$set_mailfoot."'";

                $update_set = $this->get_execute($sql);

                if($update_set) {
                    return TRUE;
                } else {
                    return FALSE;
                }

			break;

            case 'last_notify':

                $sql="UPDATE SYSetting
                    SET set_lastnotify = '".$set_lastnotify."'";

                $update_lastnotify = $this->get_execute($sql);

                if($update_lastnotify) {
                    return TRUE;
                } else {
                    return FALSE;
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

    function diamond_killer($input)
	{
        $str = $input;
        $str = str_replace("�", "", $str);
        $str = stripslashes($str);

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
