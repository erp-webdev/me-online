<?php

    if ($logged == 1) {

        //*********************** MAIN CODE START **********************\\

        # ASSIGNED VALUE
        $page_title = "Performance Appraisal Viewer";

        //***********************  MAIN CODE END  **********************\\

        global $sroot, $profile_id, $unix3month;

        $datenow = date('Y-m-d'); //AND a.DateAppraisal >= '".$datenow." 00:00:00.000'

        // codes ni kevs
        $dbnamekev = ''; $rattkev = ''; $participantkev = ''; $commandkev = '';

        $dbname = "AND a.Designation = 'GLOBAL01' AND b.DB_NAME = 'GL' ";

        $dbnamekev = "AND desig = 'GLOBAL01' ";
		

        $ratt = "AND b.DB_NAME = 'GL' ";
        $rattkev = "AND DBNAME = 'GL' ";

        $groupid = $_GET['groupid'];

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

            $command = "".implode( ' OR ', $participant)." AND b.Status = 'Active' AND b.AppraisalDate <= '".$datenow." 00:00:00.000' ".$dbname." ";
            $commandkev = "".implode( ' OR ', $participantkev)." AND appStatus = 'Active' AND appdt <= '".$datenow." 00:00:00.000' ".$dbnamekev." ";
            $groupapp = $pafsql->appGroup($command);
        } else {
            $group = 1;
            for ($i=0; $i <= 4; $i++) {

                if($i == 0){

                    $participant = " RateeEmpID = '".$profile_idnum."'";
                    $participantkev = " rempid = '".$profile_idnum."' 
                     AND DBNAME='".$profile_dbname."'";

                }elseif($i == 1){

                    $participant = "RaterEmpID = '".$profile_idnum."' ";
                    $participantkev = "rempid1 = '".$profile_idnum."' 
                        and rempid1db='".$profile_dbname."' ";

                } else {

                    $participant = "Rater".$i."EmpID = '".$profile_idnum."'";
                    $participantkev = "rempid" . $i . " = '".$profile_idnum."' 
                    and rempid".$i."db='".$profile_dbname."' ";
                }

                $command = "".$participant." AND a.RelAppID = ".$groupid." AND g.Status = 'Active' AND a.Designation = 'GLOBAL01' AND g.AppraisalDate <= '".$datenow." 00:00:00.000' ".$dbname." ";

                $commandkev = "".$participantkev." AND RelAppID = ".$groupid." AND appStatus = 'Active' AND desig = 'GLOBAL01' AND appdt <= '".$datenow." 00:00:00.000' ".$dbnamekev." ";

                ${"rater$i"} = $pafsql->appFunctionKev($commandkev);

                //var_dump(${"rater$i"});
            }
        }

    }
    else
    {
        echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
    }

?>
