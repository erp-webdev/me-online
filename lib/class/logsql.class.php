<?php

class logsql {

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

	# MAINSQL CLASS

    function get_sp_data($sp_name, $parameters = NULL, $dbname = NULL)
	{
        // TYPE:
        // 1 - array
        // 2 - num_row

        $con = $this->db_connect();

        $maindb = DBNAME;
        if($dbname != NULL)
            $maindb = $dbname;

        $stmt = mssql_init($maindb.'.dbo.'.$sp_name, $con);

        if ($parameters) :
            foreach ($parameters as $key => $value) :
                mssql_bind($stmt, '@'.$value['field_name'], $value['field_value'], $value['field_type'], $value['field_isoutput'], $value['field_isnull'], $value['field_maxlen']);
            endforeach;
        endif;

        $query = mssql_execute($stmt);

        $result = $query;

		return $result;
	}

    function check_member($username, $password = NULL)
	{

		$sql = "SELECT COUNT(EmpID) AS mcount FROM VIEWHREMPMASTER WHERE EmpID = '".$username."' ";
        $sql .= " AND CONVERT(VARBINARY(250),LTRIM(RTRIM(EPassword))) = CONVERT(VARBINARY(250),LTRIM(RTRIM('".$password."'))) ";
        $sql .= " AND Active = 1";
		$result = $this->get_row($sql);
		if($result[0]['mcount'] <= 0) :
			return FALSE;
		else :
			return $result[0]['mcount'];
		endif;
	}

	function check_user($username)
	{

		$sql = "SELECT COUNT(EmpID) AS mcount FROM VIEWHREMPMASTER WHERE EmpID = '".$username."'";
		$result = $this->get_row($sql);
		if($result[0]['mcount'] <= 0) :
			return FALSE;
		else :
			return TRUE;
		endif;
	}

    function get_member($username)
	{
		$sql = "SELECT TOP 1 *
            FROM VIEWHREMPMASTER WHERE EmpID = '".$username."' AND Active = 1 AND EmailAdd is not null";
		$result = $this->get_row($sql);
		return $result;
	}

    function get_member2($username, $password, $dbname = NULL)
	{
		$sql = "SELECT *
            FROM VIEWHREMPMASTER WHERE EmpID = '".$username."' ";
        $sql .= " AND CONVERT(VARBINARY(250),LTRIM(RTRIM(EPassword))) = CONVERT(VARBINARY(250),LTRIM(RTRIM('".$password."'))) ";
        if ($dbname) : $sql .= " AND DBNAME = '".$dbname."' "; endif;
        $sql .= " AND Active = 1";
		$result = $this->get_row($sql);
		return $result;
	}

    function get_allmember($username, $dbname = NULL)
	{

		$sql = "SELECT TOP 1 *
            FROM VIEWHREMPMASTER WHERE EmpID = '".$username."'";
        if ($dbname) : $sql .= " AND DBNAME = '".$dbname."' AND Active = 1 "; endif;
		$result = $this->get_row($sql);
		return $result;
	}

    function get_member_by_hash($emphash)
	{
		$sql = "SELECT TOP 1 *
            FROM VIEWHREMPMASTER WHERE CONVERT(VARCHAR(32), HashBytes('MD5', EmpID), 2) = '".$emphash."'";
		$result = $this->get_row($sql);
		return $result;
	}

    function get_upmember_by_hash($emphash)
	{
		$sql = "SELECT TOP 1 *
            FROM HRUpdateEmpMaster WHERE CONVERT(VARCHAR(32), HashBytes('MD5', EmpID), 2) = '".$emphash."'";
		$result = $this->get_row($sql);
		return $result;
	}

    function get_depdata_by_hash($emphash)
	{
		$sql = "SELECT *
            FROM HRUpdateDependents WHERE CONVERT(VARCHAR(32), HashBytes('MD5', EmpID), 2) = '".$emphash."'";
		$result = $this->get_row($sql);
		return $result;
	}

    function get_memtax($taxid)
	{
		$sql = "SELECT TOP 1 Description, Exemption
            FROM HRTax WHERE Code = '".$taxid."'";
		$result = $this->get_row($sql);
		return $result;
	}

    function update_member2($post)
	{
        $accepted_field = array('TRANS', 'EMPID', 'LName', 'FName', 'MName', 'EmailAdd', 'EmailAdd2', 'NickName', 'UnitStreet', 'Barangay', 'TownCity', 'StateProvince', 'Zip', 'Region', 'Country', 'PermUnitStreet', 'PermBarangay', 'PermTownCity', 'PermStateProvince', 'PermZip', 'PermRegion', 'PermCountry', 'HomeNumber', 'MobileNumber', 'Gender', 'Citizenship', 'BirthDate', 'BirthPlace', 'MotherMaiden', 'SpouseName', 'SpouseOccupation', 'IncomeSource', 'OtherIncomeSource', 'ContactPerson', 'ContactAddress', 'ContactTelNbr', 'ContactMobileNbr', 'DBNAME', 'OffUnitStreet', 'OffBarangay', 'OffTownCity', 'OffStateProvince', 'OffZip', 'OffRegion', 'OffCountry', 'BloodType', 'MedHistory', 'Medication'
	);

        $knum = 0;
        $val = array();
        foreach ($post as $key => $value) :
            if (in_array($key, $accepted_field)) :
                $val[$knum]['field_name'] = $key;
                $val[$knum]['field_value'] = $value;
                if ($key == 'TRANS') :
                $val[$knum]['field_type'] = SQLINT1;
                else :
                $val[$knum]['field_type'] = SQLVARCHAR;
                endif;
                $val[$knum]['field_isoutput'] = false;
                $val[$knum]['field_isnull'] = false;
                if ($key != 'TRANS') :
                $val[$knum]['field_maxlen'] = 512;
                endif;

                $knum++;
            endif;
        endforeach;



        $insert_updateemp = $this->get_sp_data('SP_PROFILE_UPDATE2', $val, 'SUBSIDIARY');


        if($insert_updateemp) :
            return TRUE;
        else :
            return FALSE;
        endif;
	}

    function update_dependent($post)
	{
        $accepted_field = array('EmpID', 'Dependent', 'Relation', 'Gender', 'Birthdate', 'pwd', 'SeqID', 'DBNAME');

        $knum = 0;
        $val = array();
        foreach ($post as $key => $value) :
            if (in_array($key, $accepted_field)) :
                $val[$knum]['field_name'] = $key;
                $val[$knum]['field_value'] = $value;
                if ($key == 'pwd') :
                $val[$knum]['field_type'] = SQLINT1;
                elseif ($key == 'SeqID') :
                $val[$knum]['field_type'] = SQLINT4;
                else :
                $val[$knum]['field_type'] = SQLVARCHAR;
                endif;
                $val[$knum]['field_isoutput'] = false;
                $val[$knum]['field_isnull'] = false;
                $val[$knum]['field_maxlen'] = 512;

                $knum++;
            endif;
        endforeach;

        $insert_updatedep = $this->get_sp_data('SP_PROFILE_DEPENDENT', $val);

        if($insert_updatedep) :
            return TRUE;
        else :
            return FALSE;
        endif;
	}

    function del_dependent($empid = NULL, $depid = 0, $dbname = NULL)
	{
        if ($empid || $depid) :
            $sql = "DELETE FROM HRUpdateDependents ";
            $sql .= " WHERE DepID != NULL ";
            if ($empid != NULL) : $sql .= " AND EmpID = '".$empid."'"; endif;
            if ($depid != 0) : $sql .= " AND DepID = '".$depid."'"; endif;
            if ($dbname != NULL) : $sql .= " AND DBNAME = '".$dbname."'"; endif;
            $result = $this->get_execute($sql);
            return $result;
        else :
            return false;
        endif;
	}

    function log_action($value, $action, $id = 0, $dbname = null)
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

                $add_log = $this->get_sp_data('SP_ADD_LOG', $val, $_SESSION['megasubs_db']);

                if($add_log) {
                    return TRUE;
                } else {
                    return FALSE;
                }

            break;
        }
    }

}
?>
