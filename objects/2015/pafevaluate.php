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

        $appraisal = $pafsql->appraisal(" id = $groupid ");

        // kevs added code
        $dbnamekev = ''; $rattkev = ''; $commandkev='';

        if ($comp == 'GLOBA01' || $comp == 'GLOBAL1') {// || $comp == 'LGMI01') {
            $dbname = "AND a.Designation = 'GLOBAL01' AND b.DB_NAME = 'GL' ";
            $dbnamekev = "AND desig = 'GLOBAL01' AND DBNAME = 'GL' ";

            $ratt = "AND b.DB_NAME = 'GL' ";
            $rattkev = "AND DBNAME = 'GL' ";
        } else {
            $dbname = "AND a.Designation = 'MEGA01' ";
            $dbnamekev = "AND desig = 'MEGA01' ";
            $ratt = "AND b.DB_NAME = 'MEGAWORLD' ";
            $rattkev = "AND DBNAME = 'MEGAWORLD' ";
        }

        $company = $_GET['company'];

        $command = "a.id = '".$appid."' AND a.RelAppID = ".$groupid." AND RateeEmpID = '".$rid."' AND (a.RaterStatus = NULL OR a.RaterStatus = '2') AND g.Status = 'Active' AND g.AppraisalDate <= '".$datenow." 00:00:00.000' ".$dbname." ";
        $commandkev = "appid = '".$appid."' AND RelAppID = ".$groupid." AND rempid = '".$rid."' AND (rstat1 = NULL OR rstat1 = '2') AND appStatus = 'Active' AND appdt <= '".$datenow." 00:00:00.000' ".$dbnamekev." ";
        $evaluateRatee = $pafsql->appFunctionKev($commandkev);
        //$checkRater = $pafsql->checkRater($rid, $status1, $company, $profile_idnum, $datenow);

        $r1 = 1;

        foreach ($evaluateRatee as $row) {

            $checkifsave = $row['rstat1'];

            $rstat1 = $row['rstat1'];
            $rstat3 = $row['rstat3'];
            $rstat2 = $row['rstat2'];
            $rstat4 = $row['rstat4'];

            if (($row['rempid2'] == NULL || $row['rempid2'] == 0) && ($row['rempid3'] == NULL || $row['rempid3'] == 0) && ($row['rempid4'] == NULL || $row['rempid4'] == 0)) {
                $r2 = 1;
                $auth = 'Final1';
                $flashRater = 1;
            }

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

            //check if there is updated competency
            $comcr = "JobCode = '".$rid."' AND CompanyID = '".$row['desig']."' ";

            $select = "*";
            $from = "PAFGMCAssessment";

            $compchecker = $pafsql->checkRank($select, $from, $comcr);

            if(count($compchecker) > 0){
                $commandrank = "JobCode = '".$rid."' AND CompanyID = '".$row['desig']."' ";
            } else {
                $commandrank = "JobCode = '".$row['posid']."' AND CompanyID = '".$row['desig']."' AND TypeRank = '".$rankid."' ";
            }

            $checkRank = $pafsql->checkRank($select, $from, $commandrank);

            $checkEvalCA = $pafsql->checkEvalCA($row['appid']);
            $checkEvalGC = $pafsql->checkEvalGC($row['appid']);
            $checkEvalGF = $pafsql->checkEvalGF($row['appid']);
            $checkEvalID = $pafsql->checkEvalID($row['appid']);
        }

        //Process Now
         if ($_POST['procAppraisal'] || $_POST['saveAppraisal']) {

            $appid = $_POST['appid'];

            $cmscore = $_POST['cmscore'];
            $apscore = $_POST['apscore'];
            $s5score = $_POST['s5score'];

            $checkifsave = $_POST['checkifsave'];
            //******Part 1 - Competency Assessment
            $caTitle = $_POST['caTitle'];
            $caType = $_POST['caType'];
            $caOrder = $_POST['caOrder'];
            $caCode = $_POST['caCode'];
            $caRp = $_POST['caRp'];
            $caAp = $_POST['caAp'];
            $caGaps = $_POST['caGaps'];
            //$caGaps = $_POST['caGaps'];
            $caRemarkst = $_POST['caRemarkst'];
            $caRemarksr = $_POST['caRemarksr'];
            //$caRemarkjs = $_POST['caRemarkjs'];

            if($checkifsave == 2){

                $caid = $_POST['caid'];

                //$pow = $pafsql->paf_deleteca($appid);
                for ($i=0; $i < count($caid); $i++) {
                   $pafpostca['update'] = 'upca';
                   //competency assessment
                   $pafpostca['caID'] = $caid[$i];
                   $pafpostca['caAp'] = $caAp[$i];
                   $pafpostca['caGaps'] = $caGaps[$i];

                    if($caType[$i] == 'CORE' && $caGaps[$i] < 0){
                       if($caType[$i] == 'CORE' && $caRemarksr[$i] == '--'){
                            $pafpostca['caRemarks'] = $caRemarkst[$i];
                            //$getRem = $caRemarkst[$i];
                            //var_dump($caRemarkst[$i]);
                           // die();
                        } else {
                            $pafpostca['caRemarks'] = str_replace('"',"'", $caRemarksr[$i]);
                        }
                    } else {
                        $pafpostca['caRemarks'] = str_replace('"',"'", $caRemarksr[$i]);
                    }

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

            } else {

                for ($i=0; $i < count($caTitle); $i++) {

                    //$from = "PAFRelCAssessment";
                    //$command = "WHERE [PAFRelID] = '".$appid."' AND [Type] = '".$caType[$i]."' AND [Order] = '".$caOrder[$i]."' AND [Competency] = '".$caTitle[$i]."' AND [ReqProficiency] = '".$caRp[$i]."' AND [ActProficiency] = '".$caAp[$i]."' AND [Gaps] = '".$caGaps[$i]."' [Remarks]";
                    if(($caTitle[$i] != NULL) || ($caTitle[$i] != '')){

                        $pafpostca['appid'] = $appid;

                        $pafpostca['pafad'] = 'CA';
                        $pafpostca['caCode'] = $caCode[$i];
                        $pafpostca['caTitle'] = $caTitle[$i]; //$caTitle[$i];
                        $pafpostca['caType'] = $caType[$i];
                        $pafpostca['caOrder'] = $caOrder[$i];
                        $pafpostca['caRp'] = $caRp[$i];
                        $pafpostca['caAp'] = $caAp[$i];
                        $pafpostca['caGaps'] = $caGaps[$i];

                        if($caType[$i] == 'CORE' && $caGaps[$i] < 0){
                           if($caType[$i] == 'CORE' && $caRemarksr[$i] == '--'){
                                $pafpostca['caRemarks'] = $caRemarkst[$i];
                                //$getRem = $caRemarkst[$i];
                                //var_dump($caRemarkst[$i]);
                               // die();
                            } else {
                                $pafpostca['caRemarks'] = str_replace('"',"'", $caRemarksr[$i]);
                            }
                        } else {
                            $pafpostca['caRemarks'] = str_replace('"',"'", $caRemarksr[$i]);
                        }
                        //$pafpostca['caRemarks'] = str_replace('"',"'",$getRem);
                        //insert to class db
                        $pow = $pafsql->paf_evaluate($pafpostca, 'addca');
                    }
                }
            }

            //******Part 2 - Goals Covered Under the Evaluation Period
            $g2Title1 = $_POST['g2Title1'];
            $g2Comments1 = $_POST['g2Comments1'];
            $g2TitleID   = $_POST['g2TitleID'];
            if($checkifsave == 2){

                $g2ID = $_POST['g2ID'];
                $g2name = 'g2Rad';

                //$pow = $pafsql->paf_deleteg2($appid);
                for ($i=0; $i < count($g2Title1); $i++) {

                    if(($g2Title1[$i] != NULL) || trim($g2Title1[$i] != '')){
                        $g2idf = $g2name.$g2ID[$i];
                        $counter = $i;

                        $pafpostg2['appid'] = $appid;
                        $pafpostg2['g2Title1'] = str_replace('"',"'",$g2Title1[$i]); //$caTitle[$i];
                        $pafpostg2['g2Rad'] = $_POST[$g2idf];
                        $pafpostg2['g2Comments1'] = str_replace('"',"'",$g2Comments1[$i]);

                        //insert to class db
                        $pow = $pafsql->paf_evaluate($pafpostg2, 'addg2');
                    }
                }

            } else {
                for ($i=0; $i < count($g2Title1); $i++) {
                    $counter = $i;
                    $g2rad = 'g2Rad' . ($i + 1);
                    if(($g2Title1[$i] != NULL) || ($g2Title1[$i] != '')){

                        $pafpostg2['appid'] = $appid;
                        $pafpostg2['g2Title1'] = str_replace('"',"'",$g2Title1[$i]); //$caTitle[$i];
                        $pafpostg2['g2Rad'] = $_POST[$g2rad];
                        $pafpostg2['g2Comments1'] = str_replace('"',"'",$g2Comments1[$i]);
                        //insert to class db
                        $pow = $pafsql->paf_evaluate($pafpostg2, 'addg2');
                    }

                }

            }
            //******Part 3 - Goals For The Coming Year Or Evaluation Period
            $g3Title1 = $_POST['g3Title1'];
            $g3MS = $_POST['g3MS'];

            if($checkifsave == 2){

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

            } else {

                for ($i=0; $i < count($g3Title1); $i++) {

                    if(($g3Title1[$i] != NULL) || ($g3Title1[$i] != '')){

                        $pafpostg3['appid'] = $appid;

                        $pafpostg3['g3Title1'] = str_replace('"',"'",$g3Title1[$i]); //$caTitle[$i];
                        $pafpostg3['g3MS'] = str_replace('"',"'",$g3MS[$i]);

                        //insert to class db
                        $pow = $pafsql->paf_evaluate($pafpostg3, 'addg3');
                    }

                }
            }

            //******Part 4 - Individual Development Plan
            $idpTitle = $_POST['idpTitle'];
            $idpRp = $_POST['idpRp'];
            $idpAp = $_POST['idpAp'];
            $idpGaps = $_POST['idpGaps'];
            $idpComments = $_POST['idpComments'];

            for ($i=0; $i < count($idpTitle); $i++) {

                if(($idpTitle[$i] != NULL) || ($idpTitle[$i] != '')){

                    $pafpostidp['appid']       = $appid;

                    $pafpostidp['idpTitle']    = str_replace('"',"'",$idpTitle[$i]); //$caTitle[$i];
                    $pafpostidp['idpRp']       = $idpRp[$i];
                    $pafpostidp['idpAp']       = $idpAp[$i];
                    $pafpostidp['idpGaps']     = $idpGaps[$i];
                    $pafpostidp['idpComments'] = str_replace('"',"'",$idpComments[$i]);

                    //insert to class db
                    $pow = $pafsql->paf_evaluate($pafpostidp, 'addidp');
                }

            }

            //******Part 5 - Update PAF Main Employee Data
            if($checkifsave == 2){

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

                //echo 'fin -'.$fcaAp;

                $g2 = 0;
                $countg2 = 0;

                $g2ID = $_POST['g2ID'];
                $g2name = 'g2Rad';

                for ($i=0; $i < count($g2Title1); $i++) {
                    $counter = $i;
                    if(($g2Title1[$i] != NULL) || ($g2Title1[$i] != '')){
                        $countg2++;
                        $g2idf = $g2name.$g2ID[$i];
                        $g2 += $_POST["$g2idf"];
                    }
                }
                //echo 'fin-'.$g2;

            } else {

                $fcaAp = 0;
                $countAp = 0;
                for ($i=0; $i < count($caTitle); $i++) {
                    if(($caTitle[$i] != NULL) || ($caTitle[$i] != '')){
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
                }

                $g2 = 0;
                $countg2 = 0;
                for ($i=0; $i < count($g2Title1); $i++) {
                    $counter = $i;
                    if(($g2Title1[$i] != NULL) || ($g2Title1[$i] != '')){
                        $countg2++;
                        switch ($counter) {
                            case 0:
                                $g2 += $_POST['g2Rad1'];
                                break;
                            case 1:
                                $g2 += $_POST['g2Rad2'];
                                break;
                            case 2:
                                $g2 += $_POST['g2Rad3'];
                                break;
                            case 3:
                                $g2 += $_POST['g2Rad4'];
                                break;
                            case 4:
                                $g2 += $_POST['g2Rad5'];
                                break;
                        }
                    }
                }
            }

            if($countAp > 0 && $countg2 > 0) {

                $part1 = $fcaAp / $countAp;
                $fpart1 = $part1 * 0.3;
                //part 1 score
                $part2 = $g2 / $countg2;
                $fpart2 = $part2 * 0.4;
                //part 2 score
                $ggx1 = $apscore + $cmscore + $s5score;
                $numx = $fpart1 + $fpart2;

                $num = $numx + $ggx1;

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
            }

            $pafup['appid'] = $appid;
            $pafup['remarks'] = addslashes(str_replace('’',"'", $_POST['remarks']));
            $pafup['status'] = $_POST['final'];
            //$emnow = $_p
            if($_POST['procAppraisal']) {
                $pafup['statdiv'] = 1;
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

            $pafup['pmdm'] = '';
            $pafup['increase'] = $_POST['increase'];
            $pafup['promote'] = $_POST['promotion'];
            $pafup['promotepos'] = $_POST['promotetoPos'];
            $pafup['cot'] = '';
            $pafup['orcomm'] = '';
            $pafup['computed'] = $computed;
            $pafup['fscore'] =  $fscore;
            $pafup['pafad'] = 'rater1';
            $pafup['date'] = date('Y-m-d');
            $pafup['attachfile'] = '';

            /*//FOR ATTACHMENTS
            $allowedExts = array("JPG", "JPEG", "GIF", "PNG", "PDF", "jpg", "jpeg", "gif", "png", "pdf");


            if ($_FILES['upfile']){

                $image = $_FILES['upfile']['tmp_name'];
                $filename = $_FILES['upfile']['name'];
                $filesize = $_FILES['upfile']['size'];
                $filetype = $_FILES['upfile']['type'];

                $tempext = explode(".", $filename);
                $extension = end($tempext);

                if (($filesize < 10485760) && in_array($extension, $allowedExts)) {

                    $path = "uploads/paf/";
                    $target_path = $path.basename($appid.'_'.$filename);

                    $filemove = move_uploaded_file($image, $target_path);

                    $pafup['attachfile'] = $appid.'_'.$filename;
                    //$pafup['attachtype'] = $filetype;


                    //if($filemove){
                        //$add_attach = $mainsql->attach_action($attach, 'add');
                    //}
                }
            } */

            $pup = $pafsql->paf_update($pafup, 'update');

            if ($_POST['procAppraisal']) :
                echo '{"success": true, "type": 1}';
                exit();
            elseif ($_POST['saveAppraisal']) :
                echo '{"success": true, "type": 2}';
                exit();
            endif;
        }

    }
    else
    {
        echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
    }

?>
