<?php

    if ($logged == 1) {

        //*********************** MAIN CODE START **********************\\

        # ASSIGNED VALUE
        $page_title = "Performance Appraisal Ratee View";

        //***********************  MAIN CODE END  **********************\\

        global $sroot, $profile_id, $unix3month;

        $datenow = date('Y-m-d'); //AND a.DateAppraisal >= '".$datenow." 00:00:00.000'

        $dbname = "AND a.Designation = 'GLOBAL01' AND b.DB_NAME = 'GL' ";
        $ratt = "AND b.DB_NAME = 'GL' ";

        //$status = "AND a.Status = 'Rated' OR a.Status = 'Unrated' OR a.Status = 'Completed'";
        //URL GETTER
        //$company = $_GET['company'];
        $groupid = $_GET['groupid'];
        $pafad = $_GET['pafad'];
        $appid = $_GET['appid'];
        $rid = $_GET['rid'];
        $sub = $_GET['sub'];

        $appraisal = $pafsql->appraisal("id = " . $groupid);

        if($pafad == 'ratee'){

            $command = "appid = '".$appid."' AND rempid = '".$profile_idnum."' AND status = 'Completed' AND appStatus = 'Active' AND appdt <= '".$datenow." 00:00:00.000' and DBNAME='GL' AND desig = 'GLOBAL01'" ;
            $viewAppraisal = $pafsql->appFunctionKev($command);
            // ADDED 05/04/2018 BY KEVS
            // DETERMINE UNIT VERSIONS FOR INTEGRATION OF NEW FUNCTIONS
            $created_at  = null;
            if(count($viewAppraisal) > 0)
                $created_at = date('Y-m-d', strtotime($viewAppraisal[0]['created_at']));

            foreach ($viewAppraisal as $row) {

                $rstat1 = $row['rstat1'];
                $rstat3 = $row['rstat3'];
                $rstat2 = $row['rstat2'];
                $rstat4 = $row['rstat4'];
                $rcomm1 = $row['rcomm1'];
                $nobj = $row['nobj'];
                $devplana = $row['dplana'];
                $devplanb = $row['dplanb'];
                $devplanc = $row['dplanc'];
                $devpland = $row['dpland'];

                if ($row['rempid2'] == NULL && $row['rempid3'] == NULL && $row['rempid4'] == NULL) {
                    $auth = 'Final1';
                    $flashRater = 1;
                } elseif ($row['rempid2'] != NULL && $row['rempid3'] == NULL && $row['rempid4'] == NULL) {
                    $auth = 'Final2';
                    $flashRater = 2;
                } elseif ($row['rempid2'] != NULL && $row['rempid3'] != NULL && $row['rempid4'] == NULL) {
                    $auth = 'Final3';
                    $flashRater = 3;
                } elseif ($row['rempid2'] != NULL && $row['rempid3'] != NULL && $row['rempid4'] != NULL) {
                    $auth = 'Final4';
                    $flashRater = 4;
                } else {
                    $auth = '0';
                    $flashRater = 0;
                }

                //Work Results
                $commandresp = "PAFRelID = '".$appid."' AND Status = '1'";
                $checkWResults = $pafsql->checkWResults($commandresp);
                //Personal Core Competencies
                $select = "[id] AS pccid, [PAFRelID] AS appid, [Code] AS code, [Competency] AS competency, [GDescription] AS jd, [GWeight] AS gweight, [GRating] AS grating, [GWRating] AS gwrating, [Remarks] AS remarks";
                $from = "PAFRelCAssessment";
                $commandrank = "PAFRelID = '".$appid."' ";
                $checkRank = $pafsql->checkRank($select, $from, $commandrank);
                //check set for the next review
                $checksetwr  = $pafsql->checksetwr($appid);
                $checkpcc = $pafsql->checksetpcc($appid);
            }

        } elseif ($pafad == 'rater') {

            if ($sub == 1) {
                $SQLCHECK = " AND rempid1 = '".$profile_idnum."' ";
            } elseif ($sub == 2) {
                $SQLCHECK = " AND rempid2 = '".$profile_idnum."' ";
            } elseif ($sub == 3) {
                $SQLCHECK = " AND rempid3 = '".$profile_idnum."' ";
            } elseif ($sub == 4) {
                $SQLCHECK = " AND rempid4 = '".$profile_idnum."' ";
            }

            $command = "appid = '".$appid."' AND rempid = '".$rid."' AND rstat1 = '1' ".$SQLCHECK." AND appStatus = 'Active' AND appdt <= '".$datenow." 00:00:00.000'
                        AND DBNAME='GL' AND desig = 'GLOBAL01'";
            $checkEvaluation = $pafsql->appFunctionKev($command);

            // ADDED 05/04/2018 BY KEVS
            // DETERMINE UNIT VERSIONS FOR INTEGRATION OF NEW FUNCTIONS
            $created_at  = null;
            if(count($checkEvaluation) > 0)
                $created_at = date('Y-m-d', strtotime($checkEvaluation[0]['created_at']));

            foreach ($checkEvaluation as $row) {

                if ($row['ranid'] == 'RF' || $row['ranid'] == 'RF II' || $row['ranid'] == 'SRF' || $row['ranid'] == 'SRF II' || $row['ranid'] == 'R001' || $row['ranid'] == 'R002' || $row['ranid'] == 'R003' || $row['ranid'] == 'R004') {
                    $rankid = 'RFP';
                } else {
                    $rankid = 'SCP';
                }

                $rstat1 = $row['rstat1'];
                $rstat3 = $row['rstat3'];
                $rstat2 = $row['rstat2'];
                $rstat4 = $row['rstat4'];

                $rcomm1 = $row['rcomm1'];
                $rcomm2 = $row['rcomm2'];
                $rcomm3 = $row['rcomm3'];
                $rcomm4 = $row['rcomm4'];
                $nobj = $row['nobj'];
                $devplana = $row['dplana'];
                $devplanb = $row['dplanb'];
                $devplanc = $row['dplanc'];
                $devpland = $row['dpland'];

                if (($row['rempid2'] == NULL || $row['rempid2'] == 0) && ($row['rempid3'] == NULL || $row['rempid3'] == 0) && ($row['rempid4'] == NULL || $row['rempid4'] == 0)) {
                    $auth = 'Final1'; $flashRater = 1;
                    $rprom = $row['rprom1'];
                    $rincr = $row['rincr1'];
                   // $rcommx = $row['rcomm1'];
                } elseif (($row['rempid2'] != NULL || $row['rempid2'] != 0) && ($row['rempid3'] == NULL || $row['rempid3'] == 0) && ($row['rempid4'] == NULL || $row['rempid4'] == 0)) {
                    $auth = 'Final2'; $flashRater = 2;
                    $rprom = $row['rprom2'];
                    $rincr = $row['rincr2'];
                   // $rcommx = $row['rcomm2'];
                } elseif (($row['rempid2'] != NULL || $row['rempid2'] != 0) && ($row['rempid3'] != NULL || $row['rempid3'] != 0) && ($row['rempid4'] == NULL || $row['rempid4'] == 0)) {
                    $auth = 'Final3'; $flashRater = 3;
                    $rprom = $row['rprom3'];
                    $rincr = $row['rincr3'];
                   // $rcommx = $row['rcomm3'];
                } elseif (($row['rempid2'] != NULL || $row['rempid2'] != 0) && ($row['rempid3'] != NULL || $row['rempid3'] != 0) && ($row['rempid4'] != NULL || $row['rempid4'] != 0)) {
                    $auth = 'Final4'; $flashRater = 4;
                    $rprom = $row['rprom4'];
                    $rincr = $row['rincr4'];
                    //$rcommx = $row['rcomm4'];
                } else {
                    $auth = '0'; $flashRater = 0;
                    $rprom = '';
                    $rincr = '';
                }

                //Work Results
                $commandresp = "PAFRelID = '".$appid."' AND Status = '1'";
                $checkWResults = $pafsql->checkWResults($commandresp);
                //Personal Core Competencies
                $select = "[id] AS pccid, [PAFRelID] AS appid, [Code] AS code, [Competency] AS competency, [GDescription] AS jd, [GWeight] AS gweight, [GRating] AS grating, [GWRating] AS gwrating, [Remarks] AS remarks";
                $from = "PAFRelCAssessment";
                $commandrank = "PAFRelID = '".$appid."' ";
                $checkRank = $pafsql->checkRank($select, $from, $commandrank);
                //check set for the next review
                $checksetwr  = $pafsql->checksetwr($appid);
                $checkpcc = $pafsql->checksetpcc($appid);
            }
        }

        if (isset($_POST['acceptResultbtn'])) {

            $pafup['status'] = '';
            $pafup['appid'] = $_POST['appid'];
            $pafup['computed'] = '';
            $pafup['pafad'] = 'ratee';
            $pafup['increase'] = '';
            $pafup['promote'] = '';
            $pafup['nobjective'] = '';
            $pafup['remarks'] = str_replace('’',"'", $_POST['remarks']);
            $pafup['devplana'] = '';
            $pafup['devplanb'] = '';
            $pafup['devplanc'] = '';
            $pafup['devpland'] = $_POST['devpland'];
            $pafup['statdiv'] = '';
            $pafup['date'] = date('Y-m-d');
            $pafup['attachfile'] = '';

            $pup = $pafsql->pafgl_update($pafup, 'update');

            echo '{"success": true}';
            exit();
        }

        if (isset($_POST['updateAppraisal']) || isset($_POST['saveAppraisal2'])) {

            $appid = $_POST['appid'];
            $rempid = $_POST['appid'];
            $cmscore = $_POST['cmscore'];
            $apscore = $_POST['apscore'];
            $s5score = $_POST['s5score'];
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
                $pafpostwr['stat'] = 'upwr';
                $pafpostwr['wid'] = $wid[$i];
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
                $pafpostpcc['stat'] = 'uppcc'; $pafpostpcc['pccid'] = $pccid[$i];

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
                $pafpostsp['appid'] = $appid;
                $pafpostsp['rempid'] = $rempid;
                $pafpostsp['setpccname'] = str_replace('"',"'", $setpccname[$i]);
                $pafpostsp['setpccw'] = $setpccw[$i];

                $pow = $pafsql->pafgl_evaluate_setpcc($appid, $rempid, $i + 1, str_replace("'" ," ", $setpccname[$i]), $setpccw[$i]);
                //if($checkifsave == 2) { $pow = $pafsql->pafgl_evaluate_uppcc($appid, $rempid, $i + 1, $setpccname[$i], $setpccw[$i]); }
                //else { $pow = $pafsql->pafgl_evaluate_setpcc($appid, $rempid, $i + 1, $setpccname[$i], $setpccw[$i]); }

            }

            //$sub = 'rater'.$_POST['sub'];
            $sub = $_POST['sub'];
			if(isset($_POST['updateAppraisal'])){ // enter condition here

	            if ($_POST['final'] == 'Completed') {
	                $pafup['status'] = 'Completed';

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
						$pafup['status'] = 'Incomplete';
	                    if ($_POST['raterx'] == 'rater2') {
	                        $ratername = $_POST['r3name'];
	                        $ratereadd = $_POST['r3eadd'];
	                    } elseif ($_POST['raterx'] == 'rater3') {
	                        $ratername = $_POST['r4name'];
	                        $ratereadd = $_POST['r4eadd'];
	                    }

	                    $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 98%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>Performance Evaluation Request for Recommendation of ".ucwords(strtolower($_POST['rname']))."</span><br><br>Hi ".ucwords(strtolower($ratername)).",<br><br>";
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
	                    $sendmail = mail($ratereadd, "Performance Evaluation for your Recommendation", $message, $headers);
	            }
			}else{
				$pafup['status'] = 'Incomplete';
			}

            $pafup['promote'] = $_POST['promotion'];
            $pafup['promotepos'] = $_POST['promotionpos'];
            $pafup['increase'] = $_POST['increase'];
            $pafup['appid'] = $appid;
            $pafup['computed'] = $_POST['op'];
            $pafup['pafad'] = $_POST['raterx'];
            $pafup['nobjective'] = $_POST['nobjective'];
            $pafup['remarks'] = str_replace('’',"'", $_POST['remarks']);
            $pafup['devplana'] = $_POST['devplana'];
            $pafup['devplanb'] = $_POST['devplanb'];
            $pafup['devplanc'] = $_POST['devplanc'];
            $pafup['devpland'] = $_POST['devpland'];
			if(isset($_POST['updateAppraisal'])){ // enter condition here
				$pafup['statdiv'] = 1;
			}else{
				$pafup['statdiv'] = null;
			}
            $pafup['date'] = date('Y-m-d');
            $pafup['attachfile'] = '';
			$sampul = $pafup['statdiv'];

            $pup = $pafsql->pafgl_update($pafup, 'update');

			if(isset($_POST['updateAppraisal'])){
            	echo '{"success": true}';
			}else{
				echo '{"success": true, "type": 2}';
			}

            exit();
        }
    }
    else
    {
        echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
    }

?>
