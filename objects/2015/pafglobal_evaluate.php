<?php

    if ($logged == 1) {

        # PAGINATION
        $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
        $start = NUM_ROWS * ($page - 1);

        //*********************** MAIN CODE START **********************\\

        # ASSIGNED VALUE
        $page_title = "Performance Appraisal Evaluation Form";

        //***********************  MAIN CODE END  **********************\\

        global $sroot, $profile_id, $unix3month;


        $datenow = date('Y-m-d'); //AND a.DateAppraisal >= '".$datenow." 00:00:00.000'
        $groupid = $_GET['groupid'];
        $appid = $_GET['appid'];
        $rid = $_GET['rid'];

        $dbname = "AND a.Designation = 'GLOBAL01' AND b.DB_NAME = 'GL'  ";
        $dbnamekev = "AND desig = 'GLOBAL01' AND DBNAME = 'GL'  ";
        $ratt = "AND b.DB_NAME = 'GL' ";
        $rattkev = "AND DBNAME = 'GL' ";

        $company = $_GET['company'];

        $command = "a.id = '".$appid."' AND RateeEmpID = '".$rid."' AND (a.RaterStatus = NULL OR a.RaterStatus = '2') AND g.Status = 'Active' AND g.AppraisalDate <= '".$datenow." 00:00:00.000' ".$dbname." ";

        $commandkev = "appid = '".$appid."' AND rempid = '".$rid."' AND (rstat1 = NULL OR rstat1 = '2') AND appStatus = 'Active' AND appdt <= '".$datenow." 00:00:00.000' ".$dbnamekev." and DBNAME='GL' ";

        $evaluateRatee = $pafsql->appFunctionKev($commandkev);
        //$checkRater = $pafsql->checkRater($rid, $status1, $company, $profile_idnum, $datenow);

        // ADDED 05/04/2018 BY KEVS
        // DETERMINE UNIT VERSIONS FOR INTEGRATION OF NEW FUNCTIONS
        $created_at  = null;
        if(count($evaluateRatee) > 0)
            $created_at = date('Y-m-d', strtotime($evaluateRatee[0]['created_at']));

        $r1 = 1;

        $command = "id = $groupid";
        $appraisal = $pafsql->appraisal($command);

        foreach ($evaluateRatee as $row) {
            $rstat1 = $row['rstat1'];
            $rstat3 = $row['rstat3'];
            $rstat2 = $row['rstat2'];
            $rstat4 = $row['rstat4'];

            $rcomm1 = $row['rcomm1'];
            $nobj = $row['nobj'];
            $devplana = $row['dplana'];
            $devplanb = $row['dplanb'];
            $devplanc = $row['dplanc'];

            $rprom1 = $row['rprom1'];
            $rincr1 = $row['rincr1'];

            if (($row['rempid2'] == NULL || $row['rempid2'] == 0) && ($row['rempid3'] == NULL || $row['rempid3'] == 0) && ($row['rempid4'] == NULL || $row['rempid4'] == 0)) {
                $r2 = 1;
                $auth = 'Final1';
                $flashRater = 1;
            }

            if ($row['ranid'] == 'R001' || $row['ranid'] == 'R002' || $row['ranid'] == 'R003' || $row['ranid'] == 'R004') {
                $rankid = 'RFP';
            } else {
                $rankid = 'SCP';
            }

            $checkifsave = $row['rstat1'];
            $checkReponsibility = $pafsql->checkReponsibility($row['posid']);

            //Work Results
            if($checkifsave == 2){
                $commandresp = "PAFRelID = '".$appid."' AND Status = '1'";
            } else {
                $commandresp = "RateeEmpID = '".$row['rempid']."' AND Status = '2'";
            }
            $checkWResults = $pafsql->checkWResults($commandresp);
            //Personal Core Competencies
            if($checkifsave == 2){
                $select = "[id] AS pccid, [PAFRelID] AS appid, [Code] AS code, [Competency] AS competency, [GDescription] AS jd, [GWeight] AS gweight, [GRating] AS grating, [GWRating] AS gwrating, [Remarks] AS remarks";
                $from = "PAFRelCAssessment";
                $commandrank = "PAFRelID = '".$appid."' ";
            } else {
                $select = "[id] AS pccid, [Code] AS code, [JobCompetency] AS competency, [JobDescription] AS jd, [GWeight] AS gweight";
                $from = "PAFGMCAssessment";
                $commandrank = "JobCode = '".$row['rempid']."' AND CompanyID = 'GLOBAL01' AND TypeRank = '".$rankid."' ";
            }
            $checkRank = $pafsql->checkRank($select, $from, $commandrank);

            //check set for the next review
            $checksetwr  = $pafsql->checksetwr($appid);

            if ($checkifsave == 2) {
                $checkpcc = $pafsql->checksetpcc($appid);
                //$checkpcc = $pafsql->checkcorepcc($rankid);
            } else {
                $checkpcc = $pafsql->checkcorepcc($rankid);
            }
        }

        //Process Now
        if ($_POST['procAppraisal'] || $_POST['saveAppraisal']) {

            $appid = $_POST['appid'];
            $rempid = $_POST['rempid'];
            $cmscore = $_POST['cmscore'];
            $apscore = $_POST['apscore'];
            //check form if save
            $checkifsave = $_POST['checkifsave'];

            // ---- WORK RESULTS ---- //
            $wid = $_POST['wid'];
            $wrp3obj = $_POST['wrp3obj'];
            $wrp3weight = $_POST['wrp3weight'];
            $wrp3achieve = $_POST['wrp3achieve'];
            $wrp3rating = $_POST['wrp3rating'];
            $wrp3wrating = $_POST['wrp3wrating'];
            $wrp3resachieve = $_POST['wrp3resachieve'];
            $wrp3remarks = $_POST['wrp3remarks'];

            for ($i=0; $i < count($wid); $i++) {


                $pafpostwr['appid'] = $appid;
                $pafpostwr['rempid'] = $rempid;
                if($_POST['procAppraisal']) { $pafpostwr['stat'] = 'upwr'; $pafpostwr['wid'] = $wid[$i]; }
                else { $pafpostwr['stat'] = 'addwr'; $pafpostwr['wid'] = ''; }
                $pafpostwr['wrp3obj'] = $wrp3obj[$i];
                $pafpostwr['wrp3weight'] = $wrp3weight[$i];
                $pafpostwr['wrp3achieve'] = $wrp3achieve[$i];
                $pafpostwr['wrp3rating'] = $wrp3rating[$i];
                $pafpostwr['wrp3wrating'] = $wrp3wrating[$i];
                $pafpostwr['wrp3resachieve'] = str_replace('"',"'", $wrp3resachieve[$i]);
                $pafpostwr['wrp3remarks'] = str_replace('"',"'", $wrp3remarks[$i]);

                $pow = $pafsql->pafgl_evaluate($pafpostwr, 'wr');
            }

            // ---- PERSONAL CORE COMPETENCIES ---- //
            $pccid = $_POST['pccid'];
            $pcccode = $_POST['pcccode'];
            $pcctitle = $_POST['pcctitle'];
            $pccjd = $_POST['pccjd'];
            $pccweight = $_POST['pccweight'];
            $pccrate = $_POST['pccrate'];
            $pccwrating = $_POST['pccwrating'];
            $pccremarks = $_POST['pccremarks'];

            for ($i=0; $i < count($pcctitle); $i++) {

                //$pafpostpcc['pccid'] =
                $pafpostpcc['appid'] = $appid;
                $pafpostpcc['rempid'] = $rempid;
                $pafpostpcc['pcccode'] = $pcccode[$i];
                $pafpostpcc['pccweight'] = $pccweight[$i];
                $pafpostpcc['pccrate'] = $pccrate[$i];
                $pafpostpcc['pccwrating'] = $pccwrating[$i];
                $pafpostpcc['pccremarks'] = $pccremarks[$i];
                $pafpostpcc['pcctitle'] = str_replace('"',"'", $pcctitle[$i]);
                $pafpostpcc['pccjd'] = str_replace('"',"'", $pccjd[$i]);
                if($checkifsave == 2) { $pafpostpcc['stat'] = 'uppcc'; $pafpostpcc['pccid'] = $pccid[$i]; }
                else { $pafpostpcc['stat'] = 'addpcc'; $pafpostpcc['pccid'] = ''; }

                $pow = $pafsql->pafgl_evaluate($pafpostpcc, 'pcc');
            }

            // ---- SET OBJECTIVE FOR THE NEXT REVIEW PERIOD ---- //
            $setobj = $_POST['setobj'];
            $setweight = $_POST['setweight'];
            $setmoa = $_POST['setmoa'];

            $del = $pafsql->pafgl_deletewr($appid);
            for ($i=0; $i < count($setobj); $i++) {
                $pafpostso['appid'] = $appid;
                $pafpostso['rempid'] = $rempid;
                $pafpostso['setobj'] = str_replace('"',"'", $setobj[$i]);
                $pafpostso['setweight'] = $setweight[$i];
                $pafpostso['setmoa'] = str_replace('"',"'", $setmoa[$i]);

                if($setobj[$i] != NULL){
                    $pow = $pafsql->pafgl_evaluate_setwr($appid, $rempid, str_replace("'"," ", $setobj[$i]), $setweight[$i], str_replace("'"," ", $setmoa[$i]));
                }
            }

            // ---- SET PERSONAL CORE COMPETENCIES FOR THE NEXT REVIEW PERIOD ---- //
            $setpccname = $_POST['setpccname'];
            $setpccw = $_POST['setpccw'];

            $del = $pafsql->pafgl_deletepcc($appid);
            for ($i=0; $i < count($setpccname); $i++) {
                if(empty(trim($setpccname[$i])))
                    continue;

                $pafpostsp['appid'] = $appid;
                $pafpostsp['rempid'] = $rempid;
                $pafpostsp['setpccname'] = str_replace('',"'", $setpccname[$i]);
                $pafpostsp['setpccw'] = $setpccw[$i];

                $pow = $pafsql->pafgl_evaluate_setpcc($appid, $rempid, $i + 1, str_replace("'" ," ", $setpccname[$i]), $setpccw[$i]);
                //if($checkifsave == 2) { $pow = $pafsql->pafgl_evaluate_uppcc($appid, $rempid, $i + 1, $setpccname[$i], $setpccw[$i]); }
                //else { $pow = $pafsql->pafgl_evaluate_setpcc($appid, $rempid, $i + 1, $setpccname[$i], $setpccw[$i]); }

            }

            if($_POST['procAppraisal']) {
                $pafup['statdiv'] = 1;
				$pafup['status'] = $_POST['final'];
                if ($_POST['final'] == 'Completed') {
                    //SEND EMAIL (RATEE)
                    $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 98%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>FINAL Performance Evaluation Rating for your Comments and Acceptance</span><br><br>Hi ".ucwords(strtolower($_POST['rname'])).",<br><br>";
                    $message .= "Your Final Performance Evaluation Rating is now ready for viewing and forwarded on ".date('F j, Y')." for your comments and acceptance.";
                    $message .= "<br><br>Thanks,<br>";
                    $message .= SITENAME." Admin";
                    $message .= "<hr />For any concerns regarding SSEP, please contact the Megaworld Payroll Department @ Loc. 242. This email is system generated, please do not reply.</div>";

                    $headers = "From: ".NOTIFICATION_EMAIL."\r\n";
                    $headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    //echo $message.'<br />';
                    //echo $_POST['r2eadd'];
                    $sendmail = mail($_POST['readd'], "Performance Evaluation Rating", $message, $headers);

                } elseif($_POST['final'] == 'Incomplete') {
                    //SEND EMAIL (APPROVER)
                    $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 98%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>Performance Evaluation Request for Recommendation of ".ucwords(strtolower($_POST['rname']))."</span><br><br>Hi ".ucwords(strtolower($_POST['r2name'])).",<br><br>";
                    $message .= "Performance Evaluation of ".ucwords(strtolower($_POST['rname']))." has been forwarded to you on ".date('F j, Y')." for your Recommendation. ";
                    $message .= "<br><br>Thanks,<br>";
                    $message .= SITENAME." Admin";
                    $message .= "<hr />For any concerns regarding SSEP, please contact the Megaworld Payroll Department @ Loc. 242. This email is system generated, please do not reply.</div>";

                    $headers = "From: ".NOTIFICATION_EMAIL."\r\n";
                    $headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    //echo $message.'<br />';
                    //echo $_POST['r2eadd'];
                    $sendmail = mail($_POST['r2eadd'], "Performance Evaluation for your Recommendation", $message, $headers);
                }
            } elseif($_POST['saveAppraisal']) {
                $pafup['statdiv'] = 2;
				$pafup['status'] = 'Incomplete';
            }

            $pafup['promote'] = $_POST['promotion'];
            $pafup['promotepos'] = $_POST['promotionpos'];
            $pafup['increase'] = $_POST['increase'];
            $pafup['appid'] = $appid;
            $pafup['computed'] = $_POST['op'];
            $pafup['pafad'] = 'rater1';
            $pafup['nobjective'] = $_POST['nobjective'];
            $pafup['remarks'] = $_POST['remarks'];
            $pafup['devplana'] = $_POST['devplana'];
            $pafup['devplanb'] = $_POST['devplanb'];
            $pafup['devplanc'] = $_POST['devplanc'];
            $pafup['devpland'] = $_POST['devpland'];
            $pafup['date'] = date('Y-m-d');
            $pafup['attachfile'] = '';

            $pup = $pafsql->pafgl_update($pafup, 'update');

			//Global Compute Score
			$comp_score['RelAppID'] = $groupid;
			$comp_score['RateeEmpID'] = $rid;
			$update_computed_score = $pafsql->gl_compute_score($comp_score, 'update');

            if ($_POST['procAppraisal']):
                echo '{"success": true, "type": 1}';
            elseif ($_POST['saveAppraisal']) :
                echo '{"success": true, "type": 2}';
            endif;
            exit();
        }

    }
    else
    {
        echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
    }

?>
