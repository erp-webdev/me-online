<?php

    // if ($logged == 1 && $profile_dbname != 'ECINEMA' && $profile_dbname != 'EPARKVIEW' && $profile_dbname != 'NEWTOWN') {
	if ($profile_dbname != 'EPARKVIEW' && $profile_dbname != 'NEWTOWN') {

        //*********************** MAIN CODE START **********************\\

        # ASSIGNED VALUE
        $page_title = "Performance Appraisal Viewer";

        //***********************  MAIN CODE END  **********************\\

        global $sroot, $profile_id, $unix3month;
        $dbnamekev = ''; $rattkev = ''; $participantkev = ''; $commandkev ='';
        $datenow = date('Y-m-d'); //AND a.DateAppraisal >= '".$datenow." 00:00:00.000'

        $groupid = $_GET['groupid'];

        if ($comp == 'GLOBA01' || $comp == 'GLOBAL1' ){ //|| $comp == 'LGMI01' ) {
            $dbname = "AND a.Designation = 'GLOBAL01' AND f.DB_NAME = 'GL' AND e.DB_NAME = 'GL' AND d.DB_NAME = 'GL' ";

            $dbnamekev = "AND desig = 'GLOBAL01' ";

            $ratt = "AND b.DB_NAME = 'GL'";
            $rattkev = "AND DBNAME = 'GL'";
        } else {
            $dbname = "AND a.Designation = 'MEGA01' ";
            $dbnamekev = "AND desig = 'MEGA01' ";

            $ratt = "AND (b.DB_NAME = 'MEGAWORLD' OR b.DB_NAME = 'NCCAI' OR b.DB_NAME = 'LCTM' OR b.DB_NAME = 'MLI' OR b.DB_NAME = 'TOWNSQUARE' OR b.DB_NAME = 'SUNTRUST' OR b.DB_NAME = 'FIRSTCENTRO' OR b.DB_NAME = 'EREX' OR b.DB_NAME = 'EPARKVIEW' OR b.DB_NAME = 'ECOC' OR b.DB_NAME = 'ECINEMA' OR b.DB_NAME = 'CITYLINK' OR DBNAME = 'SIRUS' OR DBNAME = 'ASIAAPMI') ";

            $rattkev = "AND (DBNAME = 'MEGAWORLD' OR DBNAME = 'NCCAI' OR DBNAME = 'LCTM' OR DBNAME = 'MLI' OR DBNAME = 'TOWNSQUARE' OR DBNAME = 'SUNTRUST' OR DBNAME = 'FIRSTCENTRO' OR DBNAME = 'EREX' OR DBNAME = 'EPARKVIEW' OR DBNAME = 'ECOC' OR DBNAME = 'ECINEMA' OR DBNAME = 'CITYLINK' OR DBNAME = 'SIRUS' OR DBNAME = 'ASIAAPMI') ";
        }

        //echo $comp;
        if ($groupid == NULL) {
            $group = 0;
                $participant[] = "RateeEmpID = '".$profile_idnum."' ";
                $participant[] .= "RaterEmpID = '".$profile_idnum."' ";
                $participant[] .= "Rater2EmpID = '".$profile_idnum."' ";
                $participant[] .= "Rater3EmpID = '".$profile_idnum."' ";
                $participant[] .= "Rater4EmpID = '".$profile_idnum."' ";

                $participantkev[] = "rempid = '".$profile_idnum."' ";
                $participantkev[] .= "rempid1 = '".$profile_idnum."' ";
                $participantkev[] .= "rempid2 = '".$profile_idnum."' ";
                $participantkev[] .= "rempid3 = '".$profile_idnum."' ";
                $participantkev[] .= "rempid4 = '".$profile_idnum."' ";

            $command = "(".implode( ' OR ', $participant).") AND b.Status = 'Active' AND b.AppraisalDate <= '".$datenow." 00:00:00.000'";

            $commandkev = "(".implode( ' OR ', $participantkev).") AND b.Status = 'Active' AND appdt <= '".$datenow." 00:00:00.000'";

            $groupapp = $pafsql->appGroup($command);
            $groupapp2 = $pafsql->appGroup2($command);
            //var_dump(count($groupapp));
        } else {
            $group = 1;
            for ($i=0; $i <= 4; $i++) {

                if($i == 0){

                    $participant = " RateeEmpID = '".$profile_idnum."' ".$ratt." ";
                    $participantkev = " rempid = '".$profile_idnum."' ".$rattkev." ";

                }elseif($i == 1){

                    $participant = "RaterEmpID = '".$profile_idnum."'";
                    $participantkev = "rempid1 = '".$profile_idnum."'
                     rempid1db='".$profile_dbname."'" ;

                } else {

                    $participant = "Rater".$i."EmpID = '".$profile_idnum."'";
                    $participantkev = "rempid".$i." = '".$profile_idnum."'
                     rempid".$i."db='".$profile_dbname."'" ;;

                }




                $command = "".$participant." AND a.RelAppID = ".$groupid." AND b.FName IS NOT NULL AND g.Status = 'Active' AND g.AppraisalDate <= '".$datenow." 00:00:00.000' ".$dbname." ";

                $commandkev = "".$participantkev." AND RelAppID = ".$groupid." AND rfname IS NOT NULL AND appStatus = 'Active' AND appdt <= '".$datenow." 00:00:00.000' ".$dbnamekev." ";

                //echo $mco
                ${"rater$i"} = $pafsql->appFunctionKev($commandkev);
                //var_dump(${"rater$i"});


                foreach (${"rater$i"} as $row) {
                    if (($row['rempid2'] == NULL || $row['rempid2'] == 0) && ($row['rempid3'] == NULL || $row['rempid3'] == 0) && ($row['rempid4'] == NULL || $row['rempid4'] == 0)) {
                        $auth = 'Final1';
                        $flashRater = 1;
                    } elseif (($row['rempid2'] != NULL || $row['rempid2'] != 0) && ($row['rempid3'] == NULL || $row['rempid3'] == 0) && ($row['rempid4'] == NULL || $row['rempid4'] == 0)) {
                        $auth = 'Final2';
                        $flashRater = 2;
                    } elseif (($row['rempid2'] != NULL || $row['rempid2'] != 0) && ($row['rempid3'] != NULL || $row['rempid3'] != 0) && ($row['rempid4'] == NULL || $row['rempid4'] == 0)) {
                        $auth = 'Final3';
                        $flashRater = 3;
                    } elseif (($row['rempid2'] != NULL || $row['rempid2'] != 0) && ($row['rempid3'] != NULL || $row['rempid3'] != 0) && ($row['rempid4'] != NULL || $row['rempid4'] != 0)) {
                        $auth = 'Final4';
                        $flashRater = 4;
                    } else {
                        $auth = '0';
                        $flashRater = 0;
                    }
                }
            }
        }

    }
    else
    {
        echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
    }

?>
