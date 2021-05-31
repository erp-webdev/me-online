<?php

class pafsql
{
    function __construct()
    {
		// ini_set('session.gc_maxlifetime', 60);
        // ini_set('session.gc_maxlifetime', 360);
    }

    public function db_connect() //connect to database
    {
        $result = mssql_connect(DBHOST1, DBUSER1, DBPASS1);
        if(!$result) return false;
        else return $result;
    }

    public function db_select($con) //connect to database
    {
        $result = mssql_select_db(DBNAME1, $con);
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

    function get_sp_data($sp_name, $parameters = NULL)
    {
        // TYPE:
        // 1 - array
        // 2 - num_row

        $con = $this->db_connect();

        $stmt = mssql_init(DBNAME1.'.dbo.'.$sp_name, $con);

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

    /* ADDONS + Performance Appraisal - Form */
    public function appraisal($command)
    {
        $sql = "SELECT * FROM PAFMainAppGroup WHERE $command";
        return $this->get_row($sql);
    }

    function appGroup($command)
    {
        $sql = "SELECT DISTINCT
                    b.id AS gid,
                    b.CompanyID AS cid,
                    b.Title AS title,
                    b.Author As author,
                    b.AppraisalDate AS appdt,
                    b.Status AS status
                    FROM PAFMainEmpData AS a
                LEFT JOIN PAFMainAppGroup AS b ON b.id = a.RelAppID
                WHERE
                    ".$command."
                ORDER BY b.AppraisalDate DESC";

        $result = $this->get_row($sql);
        return $result;
    }

    function appGroup2($command)
    {
        $sql = "SELECT DISTINCT
                    b.id AS gid,
                    b.CompanyID AS cid,
                    b.Title AS title,
                    b.Author As author,
                    b.AppraisalDate AS appdt,
                    b.Status AS status
                    FROM PAFMainEmpData AS a
                LEFT JOIN PAFMainAppGroup AS b ON b.id = a.RelAppID
                WHERE
                    ".$command."
                ORDER BY b.AppraisalDate DESC";

        //$result = $this->get_row($sql);
        return $sql;
    }

    function checkReponsibility($posid)
    {
        $sql = "SELECT
                    GenResponsibilities AS grep
                    FROM PAFGlobalResponsibilities
                WHERE
                    PositionID = '".$posid."' ";

        $result = $this->get_row($sql);
        return $result;
    }

    function checkWResults($commandresp)
    {
        $sql = "SELECT
                    id AS wid,
                    Objective AS wrobj,
                    Weight AS wobj,
                    Achievement AS wachieve,
                    Rating AS wrating,
                    WRating AS wwrating,
                    ResultsAchieved AS wresachieve,
                    Comments AS wremarks,
                    MOA
                    FROM PAFGlobalWResults
                WHERE
                    ".$commandresp." ";

        $result = $this->get_row($sql);
        return $result;
    }

    function appFunction($command)
    {
        $sql = "SELECT
                    a.id AS appid,
                    a.RateeEmpID AS rempid,
                    a.RateeComment AS rcomm,
                    a.RaterEmpID AS rempid1,
                    a.RaterStatus AS rstat1,
                    a.RaterOption AS ropt1,
                    a.RaterPromote AS rprom1,
                    a.RaterIncrease AS rincr1,
                    a.RaterCot AS rcot1,
                    a.RaterComment AS rcomm1,
                    a.Rater2EmpID AS rempid2,
                    a.Rater2Status AS rstat2,
                    a.Rater2Option AS ropt2,
                    a.Rater2Promote AS rprom2,
                    a.Rater2Increase AS rincr2,
                    a.Rater2Cot AS rcot2,
                    a.Rater2Comment AS rcomm2,
                    a.Rater3EmpID AS rempid3,
                    a.Rater3Status AS rstat3,
                    a.Rater3Option AS ropt3,
                    a.Rater3Promote AS rprom3,
                    a.Rater3Increase AS rincr3,
                    a.Rater3Cot AS rcot3,
                    a.Rater3Comment AS rcomm3,
                    a.Rater4EmpID AS rempid4,
                    a.Rater4Status AS rstat4,
                    a.Rater4Option AS ropt4,
                    a.Rater4Promote AS rprom4,
                    a.Rater4Increase AS rincr4,
                    a.Rater4Cot AS rcot4,
                    a.Rater4Comment AS rcomm4,
                    a.CMScore AS cmscore,
                    a.APScore AS apscore,
                    a.TScore AS tscore,
                    a.S5Score AS S5Score,
                    a.Status AS status,
                    a.Computed AS computed,
                    a.Score AS score,
                    a.Promotion AS promote,
                    a.Designation AS desig,
                    a.ORComment AS orcomm,
                    a.FileUpload AS fupload,
                    a.GenResponsibilities AS gresp,
                    a.NObjective AS nobj,
                    a.DevPlanA AS dplana,
                    a.DevPlanB AS dplanb,
                    a.DevPlanC AS dplanc,
                    a.DevPlanD AS dpland,
                    b.HireDate AS hdate,
                    b.FName AS rfname,
                    b.LName AS rlname,
                    b.EmailAdd AS readd,
                    b1.Fname AS r1fname,
                    b1.LName AS r1lname,
                    b1.EmailAdd AS r1eadd,
                    b2.Fname AS r2fname,
                    b2.LName AS r2lname,
                    b2.EmailAdd AS r2eadd,
                    b3.Fname AS r3fname,
                    b3.LName AS r3lname,
                    b3.EmailAdd AS r3eadd,
                    b4.Fname AS r4fname,
                    b4.LName AS r4lname,
                    b4.EmailAdd AS r4eadd,
                    d.DeptID AS depid,
                    d.DeptDesc AS depdesc,
                    e.RankID AS ranid,
                    e.RankDesc AS randesc,
                    f.PositionID AS posid,
                    f.PositionDesc AS posdesc,
                    g.id AS gid,
                    g.Title AS title,
                    g.Author As author,
                    g.AppraisalDate AS appdt,
                    g.PeriodFrom AS perfrom,
                    g.PeriodTo AS perto,
                    g.created_at
                    FROM PAFMainEmpData AS a
                LEFT JOIN HREmpMaster AS b ON a.RateeEmpID = b.EmpID
                LEFT JOIN HREmpMaster AS b1 ON a.RaterEmpID = b1.EmpID AND b1.DB_NAME=b.DB_NAME
                LEFT JOIN HREmpMaster AS b2 ON a.Rater2EmpID = b2.EmpID AND b2.DB_NAME=b.DB_NAME
                LEFT JOIN HREmpMaster AS b3 ON a.Rater3EmpID = b3.EmpID AND b3.DB_NAME=b.DB_NAME
                LEFT JOIN HREmpMaster AS b4 ON a.Rater4EmpID = b4.EmpID AND b4.DB_NAME=b.DB_NAME
                LEFT JOIN HREmpOrg AS c ON a.RateeEmpID = c.EmpID AND c.DB_NAME=b.DB_NAME
                LEFT JOIN HRDepartment AS d ON c.DeptID = d.DeptID AND d.DB_NAME=b.DB_NAME
                LEFT JOIN HRRank AS e ON c.RankID = e.RankID AND e.DB_NAME=b.DB_NAME
                LEFT JOIN HRPosition AS f ON c.PositionID = f.PositionID AND f.DB_NAME=b.DB_NAME
                LEFT JOIN PAFMainAppGroup AS g ON a.RelAppID = g.id
                WHERE
                b.DB_NAME = c.DB_NAME AND
                    ".$command."

                ORDER BY d.DeptDesc, b.HireDate ASC";
        $result = $this->get_row($sql);
        return $result;
    }

    function appFunctionKev($command)
    {
        $sql = "SELECT * FROM viewPAFMainEmpData
                WHERE ".$command." ORDER BY depdesc, hdate ASC";
        // echo $sql; exit;
        $result = $this->get_row($sql);
        return $result;
    }

    function checkRank($select, $from, $commandrank)
    {
        $sql = "SELECT ".$select."
                  FROM ".$from."
                  WHERE ".$commandrank."
                  ORDER BY [Type] ASC";

        $result = $this->get_row($sql);
        return $result;
    }

    function checker($from, $command)
    {
        $sql = "SELECT *
                 ".$from."
                 WHERE
                    ".$command."";
        $result = $this->get_row($sql);
        return $result;
    }

    //Evaluation of Appraisal
    function checkEvalCA($eid)
    {
        $sql = "SELECT *
                    FROM PAFRelCAssessment
                WHERE
                    PAFRelID = '".$eid."' ";

        $result = $this->get_row($sql);
        return $result;
    }

    function checkEvalGC($eid)
    {
        $sql = "SELECT *
                    FROM PAFRelGCUTEvalPeriod
                WHERE
                    PAFRelID = '".$eid."' ";

        $result = $this->get_row($sql);
        return $result;
    }

    function checkEvalGF($eid)
    {
        $sql = "SELECT *
                    FROM PAFRelGFTCYEvalPeriod
                WHERE
                    PAFRelID = '".$eid."' ";

        $result = $this->get_row($sql);
        return $result;
    }

    function checkEvalID($eid)
    {
        $sql = "SELECT *
                    FROM PAFRelIDevelopmentPlan
                WHERE
                    PAFRelID = '".$eid."' ";

        $result = $this->get_row($sql);
        return $result;
    }

    //GLOBAL
    //wr
    function checksetwr($appid)
    {
        $sql = "SELECT *
                    FROM PAFGlobalSETWR
                WHERE
                    PAFRelID = '".$appid."' ";

        $result = $this->get_row($sql);
        return $result;
    }

    //Pcc
    function checkcorepcc($rankid)
    {
        $sql = "SELECT *
                    FROM PAFGMCCore
                WHERE
                    Type = '".$rankid."' AND CompanyID = 'GLOBAL01' ";

        $result = $this->get_row($sql);
        return $result;
    }
    //pcc
    function checksetpcc($appid)
    {
         $sql = "SELECT *
                    FROM PAFGlobalSETPCC
                WHERE
                    PAFRelID = '".$appid."'
                order by cast([order] as int) asc";

        $result = $this->get_row($sql);
        return $result;
    }

    //REmover
    function paf_deleteca($appid){

        $sql = "DELETE FROM PAFRelCAssessment
                WHERE PAFRelID = ".$appid." ";

         //myssl_query($sql);
         $result = mssql_query($sql);
         return $result;
    }

    function paf_deleteg2($appid){

        $sql = "DELETE FROM PAFRelGCUTEvalPeriod
                WHERE PAFRelID = ".$appid." ";

         //myssl_query($sql);
         $result = mssql_query($sql);
         return $result;
    }

    function paf_deleteg3($appid){

        $sql = "DELETE FROM PAFRelGFTCYEvalPeriod
                WHERE PAFRelID = ".$appid." ";

         //myssl_query($sql);
         $result = mssql_query($sql);
         return $result;
    }

    function paf_evaluate($value, $action, $id = 0)
    {
        $val = array();

        switch ($action) {
            case 'addca':

                $accepted_field = array('appid', 'caCode', 'caTitle', 'caType', 'caOrder', 'caRp', 'caAp', 'caGaps', 'caRemarks');
                //$accepted_field = array('g2Title1', 'g2Rad1', 'g2Rad2', 'g2Rad3', 'g2Rad4', 'g2Rad5', 'g2Comments1');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'caRemarks'):
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        elseif ($key == 'appid' || $key == 'caOrder' || $key == 'caID' || $key == 'caRp' || $key == 'caAp' || $key == 'caType' || $key == 'caCode'  || $key == 'caTitle' || $key == 'caGaps'):
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;

                        $knum++;
                    endif;
                endforeach;

                //$add_paf = $this->get_sp_data('SP_PAFRelCAssessment_Insert', $val);
                $add_paf = $this->get_sp_data('SP_PAFRelCAssessment_Insert', $val);

                if($add_paf) {
                    //echo $add_paf;
                    return TRUE;
                } else {
                    return FALSE;
                }

            break;

            case 'addg2':

                //$accepted_field = array('caTitle', 'caType', 'caOrder', 'caRp', 'caAp', 'caGaps', 'caRemarks');
                $accepted_field = array('appid', 'g2Title1', 'g2Rad', 'g2Comments1');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'g2Title1' || $key == 'appid' || $key == 'g2Rad'):
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        elseif ($key == 'g2Comments1'):
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;

                        $knum++;
                    endif;
                endforeach;

                //var_dump($)
                //$add_paf = $this->get_sp_data('SP_PAFRelCAssessment_Insert', $val);
                $add_paf = $this->get_sp_data('SP_PAFRelGCUTEvalPeriod_Insert', $val);

                if($add_paf) {
                    //echo $add_paf;
                    return TRUE;
                } else {
                    return FALSE;
                }

            break;

            case 'addg3':

                //$accepted_field = array('caTitle', 'caType', 'caOrder', 'caRp', 'caAp', 'caGaps', 'caRemarks');
                $accepted_field = array('appid', 'g3Title1', 'g3MS');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'g3Title1' || $key == 'g3MS'):
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        elseif ($key == 'appid'):
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;

                        $knum++;
                    endif;
                endforeach;

                //$add_paf = $this->get_sp_data('SP_PAFRelCAssessment_Insert', $val);
                $add_paf = $this->get_sp_data('SP_PAFRelGFTCYEvalPeriod_Insert', $val);

                if($add_paf) {
                    //echo $add_paf;
                    return TRUE;
                } else {
                    return FALSE;
                }

            break;

            case 'addidp':

                //$accepted_field = array('caTitle', 'caType', 'caOrder', 'caRp', 'caAp', 'caGaps', 'caRemarks');
                $accepted_field = array('appid', 'idpTitle', 'idpRp', 'idpAp', 'idpGaps', 'idpComments');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'idpTitle'):
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        elseif ($key == 'idpComments' || $key == 'appid' || $key == 'idpRp' || $key == 'idpAp' || $key == 'idpGaps'):
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;

                        $knum++;
                    endif;
                endforeach;

                //$add_paf = $this->get_sp_data('SP_PAFRelCAssessment_Insert', $val);
                $add_paf = $this->get_sp_data('SP_PAFRelIDevelopmentPlan_Insert', $val);

                if($add_paf) {
                    //echo $add_paf;
                    return TRUE;
                } else {
                    return FALSE;
                }

            break;
            /*
            case 'approve':


            break;*/
        }
    }

    /* UPdate */
    function paf_update($value, $action, $id = 0)
    {
        switch ($action) {

            case 'update':

            $accepted_field = array('date', 'pmdm', 'increase', 'promote', 'cot', 'attachfile', 'statdiv', 'status', 'remarks', 'orcomm', 'appid', 'pafad', 'computed', 'fscore', 'promotepos');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'date' || $key == 'appid' || $key == 'pmdm' || $key == 'increase' || $key == 'promote' || $key == 'attachfile' || $key == 'cot' || $key == 'status' || $key == 'statdiv' || $key == 'pafad' || $key == 'fscore' || $key == 'computed' || $key == 'promotepos'):
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        elseif ($key == 'remarks' || $key == 'orcomm'):
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;
                        $knum++;
                    endif;
                endforeach;

                $update_appr = $this->get_sp_data('SP_PAFMainEmpData_Update', $val);

                if($update_appr) {
                    return 1;
                } else {
                    return 0;
                }
        break;

        case 'rating':

            $accepted_field = array('caID', 'caAp', 'caGaps', 'caRemarks', 'g2ID', 'g2Rad', 'g2Title1', 'g2Comments1', 'g3ID', 'g3Title1', 'g3MS', 'update');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'caID' || $key == 'g2ID' || $key == 'g3ID' || $key == 'caAp' || $key == 'caGaps' || $key == 'g2Rad' || $key == 'g2Title1' || $key == 'g3Title1' || $key == 'update'):
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        elseif ($key == 'caRemarks' || $key == 'g2Comments1' || $key == 'g3MS'):
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;
                        $knum++;
                    endif;
                endforeach;

                $update_appr = $this->get_sp_data('SP_PAFRelRating_Update', $val);

                if($update_appr) {
                    return 1;
                } else {
                    return 0;
                }
        break;

        }
    }
	/* Mega Update Computed Score */
	public function mega_compute_score($value, $action, $id = 0) {

		$accepted_field = array('RelAppID');

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

		//$add_paf = $this->get_sp_data('SP_PAFRelCAssessment_Insert', $val);
		$add_paf = $this->get_sp_data('spMegaUpdateComputation', $val);

		if($add_paf) {
			//echo $add_paf;
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/* Global Update Computed Score */
	public function gl_compute_score($value, $action, $id = 0){

		$accepted_field = array('RelAppID', 'RateeEmpID');

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

		//$add_paf = $this->get_sp_data('SP_PAFRelCAssessment_Insert', $val);
		$add_paf = $this->get_sp_data('spGlobalUpdateComputation', $val);

		if($add_paf) {
			//echo $add_paf;
			return TRUE;
		} else {
			return FALSE;
		}
	}

    /* GLOBAL ONE PAF */
    function pafgl_update($value, $action, $id = 0)
    {
        switch ($action) {

            case 'update':

            $accepted_field = array('statdiv', 'appid', 'status',  'computed', 'pafad', 'promote', 'increase', 'nobjective', 'remarks', 'devplana', 'devplanb', 'devplanc', 'devpland', 'date', 'attachfile', 'promotepos');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'statdiv' || $key == 'appid' || $key == 'status' || $key == 'computed' || $key == 'pafad' || $key == 'promote' || $key == 'increase' || $key == 'date' || $key == 'attachfile' || $key == 'promotepos'):
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        elseif ($key == 'nobjective' || $key == 'remarks' || $key == 'devplana' || $key == 'devplanb' || $key == 'devplanc' || $key == 'devpland'):
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;
                        if($key = 'remarks')
                            $val[$knum]['field_maxlen'] = 2048;
                        $knum++;
                    endif;
                endforeach;

                $update_appr = $this->get_sp_data('SP_PAFMainEmpData_GLUpdate', $val);

                if($update_appr) {
                    return 1;
                } else {
                    return 0;
                }
        break;

        }
    }

    function pafgl_evaluate($value, $action, $id = 0)
    {
         switch ($action) {
            case 'wr':

                $accepted_field = array('wid', 'appid', 'rempid', 'stat', 'wrp3obj', 'wrp3weight', 'wrp3achieve', 'wrp3rating', 'wrp3wrating', 'wrp3resachieve', 'wrp3remarks');
                //$accepted_field = array('g2Title1', 'g2Rad1', 'g2Rad2', 'g2Rad3', 'g2Rad4', 'g2Rad5', 'g2Comments1');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'wrp3resachieve' || $key == 'wrp3remarks'):
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        elseif ($key == 'wid' || $key == 'appid' || $key == 'rempid' || $key == 'stat' || $key == 'wrp3obj' || $key == 'wrp3weight' || $key == 'wrp3achieve' || $key == 'wrp3rating' || $key == 'wrp3wrating'):
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;

                        $knum++;
                    endif;
                endforeach;

                //$add_paf = $this->get_sp_data('SP_PAFRelCAssessment_Insert', $val);
                $add_paf = $this->get_sp_data('SP_PAF2GlobalWResults_Insert', $val);

                if($add_paf) {
                    //echo $add_paf;
                    return TRUE;
                } else {
                    return FALSE;
                }

            break;

            case 'pcc':

                $accepted_field = array('pccid', 'appid', 'rempid', 'stat', 'pcccode', 'pcctitle', 'pccjd', 'pccweight', 'pccrate', 'pccwrating', 'pccremarks');
                //$accepted_field = array('g2Title1', 'g2Rad1', 'g2Rad2', 'g2Rad3', 'g2Rad4', 'g2Rad5', 'g2Comments1');

                $knum = 0;
                foreach ($value as $key => $value) :
                    if (in_array($key, $accepted_field)) :
                        $val[$knum]['field_name'] = $key;
                        $val[$knum]['field_value'] = $value;
                        if ($key == 'pccjd' || $key == 'pccremarks'):
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        elseif ($key == 'pccid' || $key == 'appid' || $key == 'rempid' || $key == 'stat' || $key == 'pcccode' || $key == 'pcctitle' || $key == 'pccweight' || $key == 'pccrate' || $key == 'pccwrating'):
                            $val[$knum]['field_type'] = SQLVARCHAR;
                        endif;
                        $val[$knum]['field_isoutput'] = false;
                        $val[$knum]['field_isnull'] = false;
                        $val[$knum]['field_maxlen'] = 512;

                        $knum++;
                    endif;
                endforeach;

                //$add_paf = $this->get_sp_data('SP_PAFRelCAssessment_Insert', $val);
                $add_paf = $this->get_sp_data('SP_PAF2GlobalPCC_Insert', $val);

                if($add_paf) {
                    //echo $add_paf;
                    return TRUE;
                } else {
                    return FALSE;
                }

            break;

        }
    }

    function pafgl_deletewr($appid){
         $sql = "DELETE FROM PAFGlobalSETWR
                WHERE PAFRelID = ".$appid." ";

         //myssl_query($sql);
         $result = mssql_query($sql);
         return $result;
    }

    function pafgl_evaluate_setwr($appid, $rempid, $setobj, $setweight, $setmoa)
    {
         $sql = "INSERT INTO PAFGlobalSETWR (PAFRelID, RateeEmpID, Objective, Weight, MOA)
                VALUES ('".$appid."', '".$rempid."', '".$setobj."', '".$setweight."', '".$setmoa."') ";

         //myssl_query($sql);
         $result = mssql_query($sql);
         return $result;
    }

    function pafgl_deletepcc($appid){
         $sql = "DELETE FROM PAFGlobalSETPCC
                WHERE PAFRelID = ".$appid." ";

         //myssl_query($sql);
         $result = mssql_query($sql);
         return $result;
    }

    function pafgl_evaluate_setpcc($appid, $rempid, $i, $setpccname, $setweight)
    {
         $sql = "INSERT INTO PAFGlobalSETPCC (PAFRelID, RateeEmpID, [Order], Competency, Weight)
                VALUES ('".$appid."', '".$rempid."', '".$i."', '".$setpccname."', '".$setweight."') ";

         //myssl_query($sql);
         $result = mssql_query($sql);
         return $result;
    }

    function pafsample()
    {
         $sql = "SELECT TOP 1000 [id]
              ,[RelAppID]
              ,[RateeEmpID]
              ,[Designation]
              ,[RaterEmpID]
              ,[Rater2EmpID]
              ,[Rater3EmpID]
              ,[Rater4EmpID]
          FROM [DB_APPRAISAL].[dbo].[PAFMainEmpData]
          WHERE RateeEmpID IN (SELECT EmpID FROM [TOWNSQUARE].[dbo].[HREmpMaster])";

        $result = $this->get_row($sql);
        return $result;
    }

    function getnonsub($empid)
    {
         $sql = "SELECT FName, LName
          FROM [MEGAWORLD].[dbo].[HREmpMaster]
          WHERE EmpID = '".$empid."'";

        $result = $this->get_row($sql);
        return $result;
    }

    function getsub($empid)
    {
         $sql = "SELECT FName, LName
          FROM [TOWNSQUARE].[dbo].[HREmpMaster]
          WHERE EmpID = '".$empid."'";

        $result = $this->get_row($sql);
        return $result;
    }

    /*
    function pafgl_evaluate_setpcc($appid, $rempid, $i, $setpccname, $setweight)
    {
         $sql = "UPDATE PAFGlobalSETPCC SET (PAFRelID = '".$appid."', RateeEmpID = '".$rempid."', [Order] = '".$i."', Competency = '".$setpccname."', Weight)
                VALUES (, , , , '".$setweight."') ";

         //myssl_query($sql);
         $result = mssql_query($sql);
         return $result;
    }*/
}

?>
