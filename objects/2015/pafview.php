<?php

    if ($logged == 1) {

        //*********************** MAIN CODE START **********************\\

        # ASSIGNED VALUE
        $page_title = "Performance Appraisal Ratee View";

        //***********************  MAIN CODE END  **********************\\

        global $sroot, $profile_id, $unix3month;

        $datenow = date('Y-m-d'); //AND a.DateAppraisal >= '".$datenow." 00:00:00.000'

        //$status = "AND a.Status = 'Rated' OR a.Status = 'Unrated' OR a.Status = 'Completed'";
        //URL GETTER
        //$company = $_GET['company'];

        if ($comp == 'GLOBA01' || $comp == 'LGMI01' || $comp == 'GLOBAL1') {
            $dbname = "AND a.Designation = 'GLOBAL01' AND b.DB_NAME = 'GL' ";
            $ratt = "AND b.DB_NAME = 'GL' ";
        } else {
            $dbname = "AND a.Designation = 'MEGA01' ";
            $ratt = "AND b.DB_NAME = 'MEGAWORLD' ";
        }

        $groupid = $_GET['groupid'];
        $pafad = $_GET['pafad'];
        $appid = $_GET['appid'];
        $rid = $_GET['rid'];
        $sub = $_GET['sub'];

        if($pafad == 'ratee'){

            $command = "appid = '".$appid."' AND rempid = '".$profile_idnum."' AND status = 'Completed' AND appStatus = 'Active' AND appdt <= '".$datenow." 00:00:00.000'  AND DBNAME <> 'GL'"; //
            $viewAppraisal = $pafsql->appFunctionKev($command);

            foreach ($viewAppraisal as $row) {

                $rstat1 = $row['rstat1'];
                $rstat3 = $row['rstat3'];
                $rstat2 = $row['rstat2'];
                $rstat4 = $row['rstat4'];

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

                $checkEvalCA = $pafsql->checkEvalCA($row['appid']);
                $checkEvalGC = $pafsql->checkEvalGC($row['appid']);
                $checkEvalGF = $pafsql->checkEvalGF($row['appid']);
                $checkEvalID = $pafsql->checkEvalID($row['appid']);
            }

            echo "<!-- kevs:: ";
            echo json_decode($viewAppraisal); 
            echo "-->"
            
        } elseif ($pafad == 'rater') {

            if ($sub == 1) {
                $SQLCHECK = " AND rempid1 = '".$profile_idnum."'  ";
            } elseif ($sub == 2) {
                $SQLCHECK = " AND rempid2 = '".$profile_idnum."'  ";
            } elseif ($sub == 3) {
                $SQLCHECK = " AND rempid3 = '".$profile_idnum."'  ";
            } elseif ($sub == 4) {
                $SQLCHECK = " AND rempid4 = '".$profile_idnum."'  ";
            }

            // $command = "appid = '".$appid."' AND rempid = '".$rid."' AND appStatus = 'Active' AND appdt <= '".$datenow." 00:00:00.000' AND DBNAME = 'MEGAWORLD' ";
            $command = "appid = '".$appid."' AND rempid = '".$rid."' AND appStatus = 'Active' AND appdt <= '".$datenow." 00:00:00.000'";
            $command .= $SQLCHECK;
            $checkEvaluation = $pafsql->appFunctionKev($command);

            foreach ($checkEvaluation as $row) {

                if ($row['ranid'] == 'RF' || $row['ranid'] == 'RF II' || $row['ranid'] == 'SRF' || $row['ranid'] == 'SRF II' || $row['ranid'] == 'R001' || $row['ranid'] == 'R002' || $row['ranid'] == 'R003' || $row['ranid'] == 'R004') {
                    $rankid = 'RFP';
                } else {
                    if($row['ranid'] == 'AM' || $row['ranid'] == 'AM II' || $row['ranid'] == 'AM III' || $row['ranid'] == 'M' || $row['ranid'] == 'M II' || $row['ranid'] == 'M III'){
                        $semi = 1;
                    } elseif ($row['ranid'] == 'SM' || $row['ranid'] == 'SM II' || $row['ranid'] == 'SM III' || $row['ranid'] == 'AVP' || $row['ranid'] == 'SAVP' || $row['ranid'] == 'VP' || $row['ranid'] == 'SVP' || $row['ranid'] == 'COO' || $row['ranid'] == 'FVP'){
                        $semi = 2;
                    } else {
                        $semi = 0;
                    }
                    $rankid = 'SCP';
                }

                $rstat1 = $row['rstat1'];
                $rstat3 = $row['rstat3'];
                $rstat2 = $row['rstat2'];
                $rstat4 = $row['rstat4'];
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

                $checkEvalCA = $pafsql->checkEvalCA($row['appid']);
                $checkEvalGC = $pafsql->checkEvalGC($row['appid']);
                $checkEvalGF = $pafsql->checkEvalGF($row['appid']);
                $checkEvalID = $pafsql->checkEvalID($row['appid']);
            }
        }

        if (isset($_POST['approveAppraisal'])) {

            $pafup['remarks'] =  addslashes(str_replace('’',"'", $_POST['remarks']));
            $pafup['appid'] = $_POST['appid'];
            $pafup['statdiv'] = '1';
            $pafup['computed'] = '';
            $pafup['fscore'] = '';
            $pafup['pmdm'] = $_POST['pmdm'];
            $pafup['orcomm'] = $_POST['orcomm'];
            $pafup['status'] = '';
            $pafup['pafad'] = 'divhead';
            $pafup['promote'] = $_POST['promotion'];
            $pafup['promotionpos'] = $_POST['promotetoPos'];


            $pup = $pafsql->paf_update($pafup, 'update');

            echo '{"success": true}';
            exit();
        }

        if (isset($_POST['acceptResultbtn'])) {

            $pafup['remarks'] = addslashes(str_replace('’',"'", $_POST['remarks']));
            $pafup['appid'] = $_POST['appid'];
            $pafup['statdiv'] = '1';
            $pafup['cot'] = '';
            $pafup['computed'] = '';
            $pafup['fscore'] = '';
            $pafup['pmdm'] = '';
            $pafup['promote'] = '';
            $pafup['attachfile'] = '';
            $pafup['increase'] = '';
            $pafup['orcomm'] = '';
            $pafup['status'] = '';
            $pafup['pafad'] = 'ratee';
            $pafup['date'] = date('Y-m-d');

            $pup = $pafsql->paf_update($pafup, 'update');

            echo '{"success": true}';
            exit();
        }

        if (isset($_POST['updateAppraisal']) || isset($_POST['saveAppraisal2'])) {

            $appid = $_POST['appid'];
            $cmscore = $_POST['cmscore'];
            $apscore = $_POST['apscore'];
            $s5score = $_POST['s5score'];

            //******Part 2 - Competency Assessment Updater
            $caid   = $_POST['caid'];
            $caAp   = $_POST['caAp'];
            $caRp   = $_POST['caRp'];
            $caGaps = $_POST['caGaps'];
            $caType = $_POST['caType'];
            $caRemarkst = $_POST['caRemarkst'];
            $caRemarksr = $_POST['caRemarksr'];

            for ($i=0; $i < count($caid); $i++) {

               $pafpostca['update'] = 'upca';
               //competency assessment
               $pafpostca['caID'] = $caid[$i];
               $pafpostca['caAp'] = $caAp[$i];
               $pafpostca['caGaps'] = $caGaps[$i];

               if($caType[$i] == 'CORE' && $caGaps[$i] < 0){
                    if($caRemarkst[$i] == 'Others' || $caRemarksr[$i] != '--'){
                        $getRem = $caRemarksr[$i];
                    } else {
                        $getRem = $caRemarkst[$i];
                    }
                } else {
                    $getRem = $caRemarksr[$i];
                }

               $pafpostca['caRemarks'] = str_replace('"',"'",$getRem);
               //goals covered
               $pafpostca['g2Title1'] = '';
               $pafpostca['g2ID'] = '';
               $pafpostca['g2Rad'] = '';
               $pafpostca['g2Comments1'] = '';
               //goals for the coming year
               $pafpostca['g3ID'] = '';
               $pafpostca['g3Title1'] = '';
               $pafpostca['g3MS'] = '';

               $pow = $pafsql->paf_update($pafpostca, 'rating');
            }

            //******Part 2 - Goals Covered Under The Evaluation Period
            $g2Title1 = $_POST['g2Title1'];
            $g2ID = $_POST['g2ID'];
            $g2name = 'g2Rad';
            $g2Comments1 = $_POST['g2Comments1'];

            $pow = $pafsql->paf_deleteg2($appid);

            for ($i=0; $i < count($g2ID); $i++) {

                if(($g2Title1[$i] != NULL) || ($g2Title1[$i] != '')){
                    $g2idf = $g2name.$g2ID[$i];
                    $counter = $i;

                    $pafpostg2['appid'] = $appid;
                    $pafpostg2['g2Title1'] = str_replace('"',"'",$g2Title1[$i]); //$caTitle[$i];
                    $pafpostg2['g2Rad'] = $_POST["$g2idf"];
                    $pafpostg2['g2Comments1'] = str_replace('’',"'", str_replace('"',"'",$g2Comments1[$i]));

                    //insert to class db
                    $pow = $pafsql->paf_evaluate($pafpostg2, 'addg2');
                }
            }

            //******Part 3 - Goals For The Coming Year Or Evaluation Period
            $g3ID = $_POST['g3ID'];
            $g3Title1 = $_POST['g3Title1'];
            $g3MS = $_POST['g3MS'];

            $pow = $pafsql->paf_deleteg3($appid);

            for ($i=0; $i < count($g3Title1); $i++) {

                if(($g3Title1[$i] != NULL) || ($g3Title1[$i] != '')){

                    $pafpostg3['appid'] = $appid;

                    $pafpostg3['g3Title1'] = str_replace('"',"'",$g3Title1[$i]); //$caTitle[$i];
                    $pafpostg3['g3MS'] = str_replace('"',"'",$g3MS[$i]);

                    //insert to class db
                    $pow = $pafsql->paf_evaluate($pafpostg3, 'addg3');
                }

            }

            //---------*Compute PART 1 and PART 2 Rating*----------
            //compute all actual proficiency
            $fcaAp = 0;
            $countAp = 0;
            for ($i=0; $i < count($caid); $i++) {
                $countAp++;
                if ($caAp[$i] == 5) {
                    $fcaAp += 5;
                } elseif ($caAp[$i] == 4) {
                    $fcaAp += 4;
                } elseif ($caAp[$i] == 3) {
                    $fcaAp += 3;
                } elseif ($caAp[$i] == 2) {
                    $fcaAp += 2;
                } elseif ($caAp[$i] == 1) {
                    $fcaAp += 1;
                }
            }

            //compute all Goals covered under the evaluation period
            $g2 = 0;
            $countg2 = 0;
            for ($i=0; $i < count($g2ID); $i++) {
                $g2idf = $g2name.$g2ID[$i];
                $countg2++;
                $g2 += $_POST["$g2idf"];
            }

            $part1 = $fcaAp / $countAp;
            $fpart1 = $part1 * 0.3;
            //part 1 score
            $part2 = $g2 / $countg2;
            $fpart2 = $part2 * 0.4;
            //part 2 score
            $num = $fpart1 + $fpart2;
            //$numff = $fpart1 + $fpart2;
            //$numf1 = $numff * 0.7;

            /*$part1 = $fcaAp + $g2;
            //$fpart1 = $part1 * 0.3;
            //part 1 score
            $part2 = $countAp + $countg2;
            //$fpart2 = $part2 * 0.7;
            //part 2 score
            // $num = $fpart1 + $fpart2;*/
            //$numf1 = $part1 / $part2;

            $numf1 = $num;
            $num = $numf1 + $apscore + $cmscore + $s5score;

            //strpos the period
            /*$numx = strpos($num, '.');
            if ($numx !== false) {
                list($num1, $num2) = explode(".", $num);
                $n1 = substr($num1, 0, 1);
                $n2 = substr($num2, 0, 2);
                $computed = $n1.'.'.$n2;
            } else {
                $computed = $num;
            }*/
            $computed = number_format((float)$num, 2, '.', '');

            //Round off
            if ($num&1) {
                //echo 'Odd Number<br />';
                $fscore = round($num);
            } else {
                //echo 'Even Number<br />';
                //echo 'Round - '.(int)$num;
                list($num1, $num2) = explode(".", $num);
                $f1 = substr($num1, 0, 1);
                $f2 = substr($num2, 0, 1);
                if ($f2 > 5) {
                    $fscore = round($num);
                } else {
                    $fscore = $f1;
                }
            }

            //$sub = 'rater'.$_POST['sub'];
            $sub = $_POST['sub'];
            //Finally insert it to the main ratee database
            $pafup['appid'] = $_POST['appid'];
            $pafup['remarks'] = addslashes($_POST['remarks']);
			if(isset($_POST['updateAppraisal'])){
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
			if(isset($_POST['updateAppraisal'])){
				$pafup['statdiv'] = 1;
			}else{
				$pafup['statdiv'] = null;
			}
            $pafup['pmdm'] = '';

            /*
            if($row['computed'] < 5 && $row['computed'] >= 4) {
                $pafup['increase'] = 12;
            } elseif($row['computed'] < 4 && $row['computed'] >= 3) {
                $pafup['increase'] = 10;
            } elseif($row['computed'] < 3 && $row['computed'] >= 2) {
                $pafup['increase'] = 8;
            } else {
                $pafup['increase'] = 0;
            }*/

            $pafup['increase'] = $_POST['increase'];
            $pafup['promote'] = $_POST['promotion'];
            $pafup['promotepos'] = $_POST['promotetoPos'];
            $pafup['attachfile'] = '';
            $pafup['cot'] = '';
            $pafup['orcomm'] = $_POST['orcomm'];
            $pafup['computed'] = $computed;
            $pafup['fscore'] =  $fscore;
            $pafup['pafad'] = $_POST['raterx'];
            $pafup['date'] = date('Y-m-d');

            $pup = $pafsql->paf_update($pafup, 'update');

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
