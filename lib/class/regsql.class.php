<?php

class regsql {

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

    function get_sp_data($sp_name, $parameters = NULL, $dbname = NULL)
	{
        // TYPE:
        // 1 - array
        // 2 - num_row

        $con = $this->db_connect();

        $maindb = $dbname ? $dbname : MAINDB;

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

	function check_member($username, $password)
	{

		$sql = "SELECT COUNT(EmpID) AS mcount FROM viewHREmpMaster WHERE EmpID = '".$username."' AND EPassword = '".$password."'  AND Active = 1";
		$result = $this->get_row($sql);
		if($result[0]['mcount'] <= 0) :
			return FALSE;
		else :
			return TRUE;
		endif;
	}

	function check_user($username)
	{

		$sql = "SELECT COUNT(EmpID) AS mcount FROM viewHREmpMaster WHERE EmpID = '".$username."'";
		$result = $this->get_row($sql);
		if($result[0]['mcount'] <= 0) :
			return FALSE;
		else :
			return TRUE;
		endif;
	}

    function get_member($username, $dbname = NULL)
	{
		$sql = "SELECT TOP 1 *
            FROM viewHREmpMaster WHERE EmpID = '".$username."' AND Active = 1";
		$result = $this->get_row($sql, $dbname);
		return $result;
	}

    function get_allmember($username)
	{
		$sql = "SELECT TOP 1 *
            FROM viewHREmpMaster WHERE EmpID = '".$username."'";
		$result = $this->get_row($sql);
		return $result;
	}

    function get_member_by_hash($emphash, $dbname = NULL)
	{
		$sql = "SELECT TOP 1 *
            FROM viewHREmpMaster WHERE CONVERT(VARCHAR(32), HashBytes('MD5', EmpID), 2) = '".$emphash."'";
        // if ($dbname != NULL){
        //     $sql .= " AND DBNAME = ".'$dbname';
        // }
		$result = $this->get_row($sql, $dbname);
		return $result;
	}

    function get_member_by_hash2($emphash, $dbname = NULL)
	{
		$sql = "SELECT TOP 1 *
            FROM HREmpMaster WHERE CONVERT(VARCHAR(32), HashBytes('MD5', EmpID), 2) = '".$emphash."'";
		$result = $this->get_row($sql, $dbname);
		return $result;
	}

    function get_family_data($empid)
	{
		$sql = "SELECT *
            FROM HRFamilyBackGround WHERE EmpId = '".$empid."'
            ORDER BY LineSeqID ASC";
		$result = $this->get_row($sql);
		return $result;
	}

    function get_education_data($empid)
	{
		$sql = "SELECT *
            FROM HREducation WHERE EmpID = '".$empid."'
            ORDER BY LineSeqID ASC";
		$result = $this->get_row($sql);
		return $result;
	}

    function get_training_data($empid)
	{
		$sql = "SELECT *
            FROM HREmpTraining WHERE EmpID = '".$empid."'
            ORDER BY LineSeqID ASC";
		$result = $this->get_row($sql);
		return $result;
	}

    function get_skill_data($empid)
	{
		$sql = "SELECT *
            FROM HREmpSkill WHERE EmpID = '".$empid."'";
		$result = $this->get_row($sql);
		return $result;
	}

    function get_prevwork_data($empid)
	{
		$sql = "SELECT *
            FROM HREmpPreviousWork WHERE EmpID = '".$empid."'
            ORDER BY SeqID DESC";
		$result = $this->get_row($sql);
		return $result;
	}

    function get_org_data($empid)
	{
		$sql = "SELECT *
            FROM HREmpOrg WHERE EmpID = '".$empid."'
            ORDER BY SeqID DESC";
		$result = $this->get_row($sql);
		return $result;
	}

    function get_pix_data($empid)
	{
		$sql = "SELECT *
            FROM HREmpPictures WHERE EmpID = '".$empid."'";
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

    /* Update */

    function get_upmember_by_hash($emphash)
	{
		$sql = "SELECT TOP 1 *
            FROM HRUpdateEmpMaster WHERE CONVERT(VARCHAR(32), HashBytes('MD5', EmpID), 2) = '".$emphash."'";
		$result = $this->get_row($sql);
		return $result;
	}

    function get_upmember_data($empid)
	{
		$sql = "SELECT TOP 1 *
            FROM HRUpdateEmpMaster WHERE EmpID = '".$empid."'";
		$result = $this->get_row($sql);
		return $result;
	}

    function get_upfamily_data($empid)
	{
		$sql = "SELECT *
            FROM HRUpdateFamilyBackGround WHERE EmpID = '".$empid."'
            ORDER BY LineSeqID ASC";
		$result = $this->get_row($sql);
		return $result;
	}

    function get_upeducation_data($empid)
	{
		$sql = "SELECT *
            FROM HRUpdateEducation WHERE EmpID = '".$empid."'
            ORDER BY LineSeqID ASC";
		$result = $this->get_row($sql);
		return $result;
	}

    function get_upprevwork_data($empid)
	{
		$sql = "SELECT *
            FROM HRUpdateEmpPreviousWork WHERE EmpID = '".$empid."'
            ORDER BY SeqID DESC";
		$result = $this->get_row($sql);
		return $result;
	}

    function get_uporg_data($empid)
	{
		$sql = "SELECT *
            FROM HRUpdateEmpOrg WHERE EmpID = '".$empid."'
            ORDER BY SeqID DESC";
		$result = $this->get_row($sql);
		return $result;
	}

    function del_upprofile_data($empid)
    {
        $sql = "DELETE FROM HRUpdateEmpMaster WHERE EmpID = '".$empid."' ";
        $del_upprofile = $this->get_execute($sql);

        if($del_upprofile) :
            return TRUE;
        else :
            return FALSE;
        endif;
    }

    function del_upfamily_data($empid)
    {
        $sql = "DELETE FROM HRUpdateFamilyBackGround WHERE EmpID = '".$empid."' ";
        $del_upfamily = $this->get_execute($sql);

        if($del_upfamily) :
            return TRUE;
        else :
            return FALSE;
        endif;
    }

    function del_upeducation_data($empid)
    {
        $sql = "DELETE FROM HRUpdateEducation WHERE EmpID = '".$empid."' ";
        $del_upfamily = $this->get_execute($sql);

        if($del_upfamily) :
            return TRUE;
        else :
            return FALSE;
        endif;
    }

    function del_upprevwork_data($empid)
    {
        $sql = "DELETE FROM HRUpdateEmpPreviousWork WHERE EmpID = '".$empid."' ";
        $del_upfamily = $this->get_execute($sql);

        if($del_upfamily) :
            return TRUE;
        else :
            return FALSE;
        endif;
    }

    function del_uporg_data($empid)
    {
        $sql = "DELETE FROM HRUpdateEmpOrg WHERE EmpID = '".$empid."' ";
        $del_upfamily = $this->get_execute($sql);

        if($del_upfamily) :
            return TRUE;
        else :
            return FALSE;
        endif;
    }

    function del_upimage($empid)
    {
        $sql = "DELETE FROM HRUpdateEmpPictures WHERE EmpID = '".$empid."' ";
        $del_upfamily = $this->get_execute($sql);

        if($del_upfamily) :
            return TRUE;
        else :
            return FALSE;
        endif;
    }

    function change_password($newpassword, $empidnum, $dbname)
    {
        $sql = "UPDATE HREmpMaster SET
            EPassword = '".$newpassword."'
            WHERE EmpID = '".$empidnum."'";

        $result = $this->get_execute($sql, $dbname);

        if($result) :
            return TRUE;
        else :
            return FALSE;
        endif;

    }

    function update_member($post)
	{
        $accepted_field = array('TRANS', 'EMPID', 'LName', 'FName', 'MName', 'NickName', 'UnitStreet', 'Barangay', 'TownCity', 'StateProvince', 'Zip', 'Region', 'Country', 'HomeNumber', 'OfficeNumber', 'OfficeExtNumber', 'MobileNumber', 'EmailAdd', 'EmailAdd2', 'BirthDate', 'BirthPlace', 'Gender', 'Status', 'Religion', 'Citizenship', 'Height', 'Weight', 'BloodType', 'SkinComplexion', 'SSSNbr', 'TINNbr', 'PhilHealthNbr', 'PagibigNbr', 'ContactPerson', 'ContactAddress', 'ContactTelNbr', 'ContactMobileNbr');

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

        $insert_updateemp = $this->get_sp_data('SP_PROFILE_UPDATE', $val);

        if($insert_updateemp) :
            return TRUE;
        else :
            return FALSE;
        endif;
	}

    function update_member2($post)
	{
        $accepted_field = array('TRANS', 'EMPID', 'LName', 'FName', 'MName', 'EmailAdd', 'EmailAdd2', 'NickName', 'UnitStreet', 'Barangay', 'TownCity', 'StateProvince', 'Zip', 'Region', 'Country', 'PermUnitStreet', 'PermBarangay', 'PermTownCity', 'PermStateProvince', 'PermZip', 'PermRegion', 'PermCountry', 'HomeNumber', 'MobileNumber', 'Gender', 'Citizenship', 'BirthDate', 'BirthPlace', 'MotherMaiden', 'SpouseName', 'SpouseOccupation', 'IncomeSource', 'OtherIncomeSource', 'ContactPerson', 'ContactAddress', 'ContactTelNbr', 'ContactMobileNbr', 'OffUnitStreet', 'OffBarangay', 'OffTownCity', 'OffStateProvince', 'OffZip', 'OffRegion', 'OffCountry', 'BloodType', 'MedHistory', 'Medication');

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

        $insert_updateemp = $this->get_sp_data('SP_PROFILE_UPDATE2', $val, $post['DBNAME']);

        if($insert_updateemp) :
            return TRUE;
        else :
            return FALSE;
        endif;
	}

    function insert_fdependent($post)
	{
        $accepted_field = array('EmpID', 'Dependent', 'Relation', 'Gender', 'Birthdate', 'pwd');

        $knum = 0;
        $val = array();
        foreach ($post as $key => $value) :
            if (in_array($key, $accepted_field)) :
                $val[$knum]['field_name'] = $key;
                $val[$knum]['field_value'] = $value;
                if ($key == 'pwd') :
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

        $insert_dep = $this->get_sp_data('SP_INSERT_UDEPENDENT', $val, $post['DBNAME']);

        if($insert_dep) :
            return TRUE;
        else :
            return FALSE;
        endif;
	}

    function update_fdependent($post)
	{
        $accepted_field = array('EmpID', 'Dependent', 'Relation', 'Gender', 'Birthdate', 'pwd', 'SeqID');

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

        $update_dep = $this->get_sp_data('SP_UPDATE_UDEPENDENT', $val, $post['DBNAME']);

        if($update_dep) :
            return TRUE;
        else :
            return FALSE;
        endif;
	}

    function update_family($post)
	{
        $falsecnt = 0;

		if(is_array($post)) :
			foreach($post as $k => $v) :

                $accepted_field = array('TRANS', 'EMPID', 'NAME', 'RELATION', 'FAMBIRTHDATE', 'FAMOCCUPATION');

                $knum = 0;
                $val = array();

                foreach ($v as $key => $value) :
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

                $insert_updatefamily = $this->get_sp_data('SP_FAMILY_UPDATE', $val);

                if(!$insert_updatefamily) :
                    $falsecnt++;
                endif;

                unset($val);
			endforeach;

            if($falsecnt) :
                return FALSE;
            else :
                return TRUE;
            endif;

		endif;
	}

    function update_independent($post, $eid)
	{
        $falsecnt = 0;

        if(is_array($post)) :
			foreach($post as $k => $v) :

                $accepted_field = array('TRANS', 'EMPID', 'DEPENDENT', 'DEPRELATION', 'DEPADDRESS', 'DEPTELNBR', 'DEPMOBILENO', 'DEPEMAILADD', 'DEPGENDER', 'DEPBIRTHDATE', 'DEPPHILHEALTH', 'DEPTAX');

                $knum = 0;
                $val = array();
                foreach ($v as $key => $value) :
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

                $insert_updatedependent = $this->get_sp_data('SP_DEPENDENT_UPDATE', $val);

                if(!$insert_updatedependent) :
                    $falsecnt++;
                endif;

                unset($val);
			endforeach;

            if($falsecnt) :
                return FALSE;
            else :
                return TRUE;
            endif;

		endif;
	}

    function update_education($post, $eid)
	{
        $falsecnt = 0;

        if(is_array($post)) :
			foreach($post as $k => $v) :

                $accepted_field = array('TRANS', 'EMPID', 'EDUCATTAINMENT', 'SCHOOL', 'COURSE', 'YEARGRADUATED');

                $knum = 0;
                $val = array();
                foreach ($v as $key => $value) :
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

                $insert_updateeducation = $this->get_sp_data('SP_EDUCATION_UPDATE', $val);

                if(!$insert_updateeducation) :
                    $falsecnt++;
                endif;

                unset($val);
			endforeach;

            if($falsecnt) :
                return FALSE;
            else :
                return TRUE;
            endif;

		endif;
	}

    function update_prevwork($post, $eid)
	{
        $falsecnt = 0;

        if(is_array($post)) :
			foreach($post as $k => $v) :

                $accepted_field = array('TRANS', 'EMPID', 'PREVCOMPANY', 'PREVPOSITION', 'DATESTARTED', 'DATERESIGNED');

                $knum = 0;
                $val = array();
                foreach ($v as $key => $value) :
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

                $insert_updateprevwork = $this->get_sp_data('SP_PREVWORK_UPDATE', $val);

                if(!$insert_updateprevwork) :
                    $falsecnt++;
                endif;

                unset($val);
			endforeach;

            if($falsecnt) :
                return FALSE;
            else :
                return TRUE;
            endif;

		endif;
	}

    function update_org($post, $eid)
	{
        $accepted_field = array('TRANS', 'EMPID', 'DEPTID', 'POSITIONID');

        $knum = 0;
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

        $insert_updateorg = $this->get_sp_data('SP_ORG_UPDATE', $val);

        if($insert_updateorg) :
            return TRUE;
        else :
            return FALSE;
        endif;
	}

    function update_picture($post, $eid)
	{
        $accepted_field = array('TRANS', 'EMPID', 'PICTURE');

        $knum = 0;
        foreach ($post as $key => $value) :
            if (in_array($key, $accepted_field)) :
                $val[$knum]['field_name'] = $key;
                $val[$knum]['field_value'] = $value;
                if ($key == 'PICTURE') :
                    $val[$knum]['field_type'] = SQLTEXT;
                    $val[$knum]['field_isoutput'] = false;
                    $val[$knum]['field_isnull'] = false;
                elseif ($key == 'TRANS') :
                    $val[$knum]['field_type'] = SQLINT1;
                    $val[$knum]['field_isoutput'] = false;
                    $val[$knum]['field_isnull'] = false;
                else :
                    $val[$knum]['field_type'] = SQLVARCHAR;
                    $val[$knum]['field_isoutput'] = false;
                    $val[$knum]['field_isnull'] = false;
                    $val[$knum]['field_maxlen'] = 512;
                endif;

                $knum++;
            endif;
        endforeach;

        $insert_updatepix = $this->get_sp_data('SP_PICTURE_UPDATE', $val);

        if($insert_updatepix) :
            return TRUE;
        else :
            return FALSE;
        endif;
	}

    function approve_update_member($eid)
	{
		$empinfo = $this->get_upmember_data($eid);

        /* Personal */

        $sql = "UPDATE HREmpMaster SET ";

        $sql .= " LName = '".$empinfo[0]['LName']."',
                FName = '".$empinfo[0]['FName']."',
                MName = '".$empinfo[0]['MName']."',
                NickName = '".$empinfo[0]['NickName']."',
                UnitStreet = '".$empinfo[0]['UnitStreet']."',
                Barangay = '".$empinfo[0]['Barangay']."',
                TownCity = '".$empinfo[0]['TownCity']."',
                StateProvince = '".$empinfo[0]['StateProvince']."',
                Zip = '".$empinfo[0]['Zip']."',
                Country = '".$empinfo[0]['Country']."', ";

        $sql .= "HomeNumber = '".$empinfo[0]['HomeNumber']."',
                MobileNumber = '".$empinfo[0]['MobileNumber']."',
                EmailAdd = '".$empinfo[0]['EmailAdd']."',
                BirthDate = '".$empinfo[0]['BirthDate']."',
                BirthPlace = '".$empinfo[0]['BirthPlace']."',
                Gender = '".$empinfo[0]['Gender']."',
                Status = '".$empinfo[0]['Status']."',
                SSSNbr = '".$empinfo[0]['SSSNbr']."',
                PhilHealthNbr = '".$empinfo[0]['PhilHealthNbr']."',
                TINNbr = '".$empinfo[0]['TINNbr']."',
                PagibigNbr = '".$empinfo[0]['PagibigNbr']."',
                Citizenship = '".$empinfo[0]['Citizenship']."',
                Religion = '".$empinfo[0]['Religion']."', ";

        $sql .= "OfficeNumber = '".$empinfo[0]['OfficeNumber']."',
                OfficeExtNumber = '".$empinfo[0]['OfficeExtNumber']."',
                EmailAdd2 = '".$empinfo[0]['EmailAdd2']."', ";

        $sql .= "BloodType = '".$empinfo[0]['BloodType']."',
                SkinComplexion = '".$empinfo[0]['SkinComplexion']."',
                Height = '".$empinfo[0]['Height']."',
                Weight = '".$empinfo[0]['Weight']."', ";

        $sql .= "ContactPerson = '".$empinfo[0]['ContactPerson']."',
                ContactAddress = '".$empinfo[0]['ContactAddress']."',
                ContactMobileNbr = '".$empinfo[0]['ContactMobileNbr']."',
                ContactTelNbr = '".$empinfo[0]['ContactTelNbr']."' ";

        $sql .= "WHERE EmpID = '".$eid."'";

        $update_profile = $this->get_execute($sql);

        /* Family */

        $faminfo = $this->get_upfamily_data($eid);

        if ($faminfo) :

            $delupfam = $this->del_upfamily_data($eid);

            if ($delupfam) :
                $update_family = 1;
                foreach ($faminfo as $key => $value) :

                    $sqlfam = "INSERT HRFamilyBackGround (EmpID, Name, Relation, BirthDate, Occupation)
                        VALUES ('".$eid."', '".$value['Name']."', '".$value['Relation']."', '".$value['BirthDate']."', '".$value['Occupation']."') ";

                    $ufamily = $this->get_execute($sqlfam);

                    if (!$ufamily) :
                        $update_family--;
                    endif;
                endforeach;
            endif;
        endif;

        $update_family = $update_family < 1 ? 0 : 1;

        /* Education */

        $eduinfo = $this->get_upeducation_data($eid);

        if ($eduinfo) :

            $delupedu = $this->del_upeducation_data($eid);

            if ($delupedu) :
                $update_education = 1;
                foreach ($eduinfo as $key => $value) :

                    $sqledu = "INSERT HREducation (EmpID, EducAttainment, School, Course, YearGraduated)
                        VALUES ('".$eid."', '".$value['EducAttainment']."', '".$value['School']."', '".$value['Course']."', '".$value['YearGraduated']."') ";

                    $ueducation = $this->get_execute($sqledu);

                    if (!$ueducation) :
                        $update_education--;
                    endif;

                endforeach;
            endif;
        endif;

        $update_education = $update_education < 1 ? 0 : 1;

        /* Previous Work */

        $pworkinfo = $this->get_upprevwork_data($eid);

        if ($pworkinfo) :

            $deluppwork = $this->del_upprevwork_data($eid);

            if ($deluppwork) :
                $update_pwork = 1;
                foreach ($pworkinfo as $key => $value) :

                    $sqlpwork = "INSERT HREmpPreviousWork (EmpID, PrevCompany, PrevPosition, DateStarted, DateResigned)
                        VALUES ('".$eid."', '".$value['PrevCompany']."', '".$value['PrevPosition']."', '".$value['DateStarted']."', '".$value['DateResigned']."') ";

                    $upwork = $this->get_execute($sqlpwork);

                    if (!$upwork) :
                        $update_pwork--;
                    endif;

                endforeach;
            endif;
        endif;

        $update_pwork = $update_pwork < 1 ? 0 : 1;

        /* Org */

        $orginfo = $this->get_uporg_data($eid);

        if ($orginfo) :

            $deluppwork = $this->del_uporg_data($eid);

            if ($deluppwork) :
                $sqlorg = "INSERT HREmpOrg (EmpID, DeptID, PositionID)
                    VALUES ('".$eid."', '".$orginfo[0]['DeptID']."', '".$orginfo[0]['PositionID']."') ";

                $update_org = $this->get_execute($sqlorg);
            endif;
        endif;

        /* Image */

        $imginfo = $mainsql->get_upimage($eid);

        if ($imginfo) :

            $delupimg = $this->del_upimage($eid);

            if ($delupimg) :
                $sqlimg = "INSERT HREmpPictures (EmpID, Picture) VALUES ($eid, SELECT Picture FROM HRUpdateEmpPictures WHERE EmpID = '".$eid."') ";

                $update_img = $this->get_execute($sqlimg);
            endif;
        endif;

        if ($update_profile || $update_family || $update_education || $update_pwork || $update_org || $update_img) :
            return TRUE;
        else :
            return FALSE;
        endif;
	}

    function reject_update_member($eid)
	{
        $delupprofile = $this->del_upprofile_data($eid);
        $delupfam = $this->del_upfamily_data($eid);
        $delupedu = $this->del_upeducation_data($eid);
        $deluppwork = $this->del_upprevwork_data($eid);
        $deluporg = $this->del_uporg_data($eid);
        $delupimg = $this->del_upimage($eid);

        if ($delupprofile || $delupfam || $delupedu || $deluppwork || $deluporg || $delupimg) :
            return TRUE;
        else :
            return FALSE;
        endif;
	}

}
?>
