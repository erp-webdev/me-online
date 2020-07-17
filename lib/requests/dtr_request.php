<?php

	include("../../config.php");
	//**************** USER MANAGEMENT - START ****************\\

	include(LIB."/login/chklog.php");

    $logged = $logstat;
    $profile_full = $logfname;
    $profile_name = $lognick;
    $profile_id = $userid;
    $profile_idnum = $logname;
    $profile_email = $email;
    $profile_bday = $bday;
    $profile_comp = $company;
    $profile_sss = $sss;
    $profile_tin = $tin;
    $profile_phealth = $phealth;
    $profile_pagibig = $pagibig;
    $profile_acctnum = $acctnum;
    $profile_location = $location;
    $profile_minothours = $minothours;
    $profile_dbname = $dbname;
    $profile_compressed = $compressed;

    if ($profile_dbname == "ECINEMA" || $profile_dbname == "EPARKVIEW" || $profile_dbname == "LAFUERZA" || $profile_dbname == "GLOBAL_HOTEL") :
        $adminarray = array("2011-03-V835");
    elseif ($profile_dbname == "CITYLINK" || $profile_dbname == "ECOC" || $profile_dbname == "EREX" || $profile_dbname == "FIRSTCENTRO" || $profile_dbname == "LCTM" || $profile_dbname == "MLI" || $profile_dbname == "NCCAI" || $profile_dbname == "SUNTRUST" || $profile_dbname == "TOWNSQUARE") :
        $adminarray = array("2009-10-V255");
    elseif ($profile_dbname == "GL") :
        $adminarray = array("2014-10-0004", "2014-10-0568", "2016-03-0261", "2017-01-0792");
    else :
        $adminarray = array("2014-05-N791", "2009-09-V206", "2012-04-U384", "MASTER", "2012-03-U273", "2014-01-N506");
    endif;

    /* MAIN DB CONNECTOR - START */

    define("MAINDB", $dbname);
    include(CLASSES."/mainsql.class.php");
    include(CLASSES."/regsql.class.php");
    include(CLASSES."/pafsql.class.php");

    $mainsql = new mainsql;
    $register = new regsql;
    $pafsql	= new pafsql;

    /* MAIN DB CONNECTOR - END */

    $logdata = $logsql->get_member($_SESSION['megasubs_user']);

    $deptdata = $mainsql->get_dept_data($userdata[0]['DeptID']);
    $posdata = $mainsql->get_posi_data($userdata[0]['PositionID']);
    $usertax = $register->get_memtax($userdata[0]['TaxID']);

    $profile_dept = $deptdata[0]['DeptDesc'];
	$profile_pos = $posdata[0]['PositionDesc'];
    $profile_taxdesc = $usertax[0]['Description'];

    include(LIB."/init/approverinit.php");

    //var_dump($_SESSION['megassep_admin']);

    if (in_array($profile_idnum, $adminarray)) :
        $profile_level = 9;
    elseif ($_SESSION['megassep_admin']) :
        $profile_level = 10;
    else :
        $profile_level = 0;
    endif;

    $profile_hash = md5('2014'.$profile_idnum);

	$GLOBALS['level'] = $profile_level;

	//***************** USER MANAGEMENT - END *****************\\
?>

<?php

    $sec = $profile_id ? $_GET['sec'] : NULL;

    ?>

    <?php

    switch ($sec) {

	case 'get_dtr' :
		$from = $_POST['from'];
		$to = $_POST['to'];
		$count = 0;

		$dtr = $mainsql->get_dtr_dates($profile_id, $from, $to, $profile_comp, $profile_dbname);
		if($dtr){
			foreach ($dtr as $key => $date) {
				if($date['TimeIN'] != NULL){
					$count++;
				}
			}
			if($count > 0){
				echo true;
			}else{
				echo false;
			}
		}else{
			echo false;
		}

	break;

        case 'periodsel':
            $dtr_year = $_POST['year'];

            $year_select = '';
            $dtr_period = $mainsql->get_dtr_period($dtr_year, $profile_comp, 1);
            if ($dtr_period) :
                foreach ($dtr_period as $key => $value) :
                    $year_select .= '<option value="'.date("Y-m-d", strtotime($value['PeriodFrom'])).' '.date("Y-m-d", strtotime($value['PeriodTo'])).'" dfrom="'.strtotime($value['PeriodFrom']).'" dto="'.strtotime($value['PeriodTo']).'" posted="'.$value['AttPost'].'">'.$value['PeriodID']." ".$value['PRYear'].' '.date("m/d/Y", strtotime($value['PeriodFrom'])).' to '.date("m/d/Y", strtotime($value['PeriodTo'])).'</option>';
                endforeach;
            endif;
            echo $year_select;
        break;

        case 'periodvar':
            $dtr_year = $_POST['year'];

            $year_select = '';
            $dtr_period = $mainsql->get_dtr_period($dtr_year, $profile_comp, 1);
            if ($dtr_period) :
                echo '{"dcover":"'.date("Y-m-d", strtotime($dtr_period[0]['PeriodFrom'])).' '.date("Y-m-d", strtotime($dtr_period[0]['PeriodTo'])).'", "dfrom":"'.strtotime($dtr_period[0]['PeriodFrom']).'", "dto":"'.strtotime($dtr_period[0]['PeriodTo']).'", "posted":"'.$dtr_period[0]['AttPost'].'"}';
            endif;
        break;

        case 'calculate':

            $_POST['strEMPID'] = $profile_idnum;
            $_POST['dteDTRDate'] = date("m/d/Y", $_POST['dateunix']);
            $_POST['OVERWRITE'] = 0;
            $_POST['STATUS'] = 'INITIAL';
            $_POST['intFINALPAY'] = 0;

            $dfrom = $_POST['dateunix'];

            $daynow = date('j');
            $month15 = date('U', strtotime(date('Y-m-15')));
            $lastyear = date('Y', strtotime("-1 month"));
            $lastmonth = date('m', strtotime("-1 month"));
            $lastday = date('t', strtotime("-1 month"));
            $month15l = date('U', strtotime(date($lastyear.'-'.$lastmonth.'-15')));
            $monthlast = date('U', strtotime(date($lastyear.'-'.$lastmonth.'-'.$lastday)));

            if ($daynow >= 3 && $daynow < 18) :
                $lastpoint = $monthlast;
            else :
                if ($daynow >= 1 && $daynow < 3) :
                    $lastpoint = $month15l;
                else :
                    $lastpoint = $month15;
                endif;
            endif;

            if ($dfrom > $lastpoint) :
                $dtr_calculate = $mainsql->dtr_action($_POST, 'calculate');
            else :
                $dtr_calculate = 0;
            endif;

            //$dtr_calculate = $mainsql->dtr_action($_POST, 'calculate');

            echo $dtr_calculate;
        break;

        case 'cover_calculate':

            $datefrom = date('U', strtotime($_POST['from']));
            $dateto = date('U', strtotime($_POST['to']));
            $dtrcal_count = 0;

            while ($datefrom <= $dateto ) :
                $_POST['strEMPID'] = $profile_idnum;
                $_POST['dteDTRDate'] = date("m/d/Y", $datefrom);
                $_POST['OVERWRITE'] = 0;
                $_POST['STATUS'] = 'INITIAL';
                $_POST['intFINALPAY'] = 0;

                $dtr_calculate = $mainsql->dtr_action($_POST, 'calculate');

                $dtrcal_count++;
                $datefrom = $datefrom + 86400;

            endwhile;

            echo $dtrcal_count;

        break;

        case 'table':
            $dtr_cover = $_POST['cover'];
            $dtr_period = explode(" ", $dtr_cover);

            $dtr_data = $mainsql->get_dtr_data($profile_idnum, date("m/d/Y", strtotime($dtr_period[0].' 00:00:00')), date("m/d/Y", strtotime($dtr_period[1].' 23:59:59')), $profile_comp);

            //var_dump($dtr_data);
            ?>

            <table border="0" cellspacing="0" class="tdata" style="width:<?php echo $dtr_data ? ' 2400px' : ' 100%'; ?>">
                <?php if($dtr_data) : ?>
                    <tr>
                        <th width="5%" rowspan="2">DTR Date</th>
                        <th width="5%" rowspan="2">DTR Day</th>
                        <th width="15%" rowspan="2">Shift Desc</th>
                        <th width="8%" colspan="2">Time</th>
                        <th width="2%" rowspan="2">OBT</th>
                        <th width="5%" rowspan="2">Work hr(s)</th>
                        <th width="5%" rowspan="2">Absent</th>
                        <th width="5%" rowspan="2">Late hr(s)</th>
                        <th width="5%" rowspan="2"><span class="cursorpoint" title="Undertime">UT hr(s)</span></th>
                        <th width="5%" rowspan="2"><span class="cursorpoint" title="Night Difference">ND hr(s)</span></th>
                        <th width="5%" rowspan="2">Leave Days</th>
                        <th width="10%" rowspan="2">Leave Type</th>
                        <th width="5%" rowspan="2">ML</th>
                        <th width="5%" rowspan="2">ROT</th>
                        <th width="5%" rowspan="2">NPROT</th>
                        <th width="5%" rowspan="2">DO</th>
                        <th width="5%" rowspan="2">SH</th>
                        <th width="5%" rowspan="2">LH</th>
                        <th width="5%" rowspan="2">SHDO</th>
                        <th width="5%" rowspan="2">LHDO</th>
                        <th width="5%" rowspan="2">OTDO</th>
                        <th width="5%" rowspan="2">OTSH</th>
                        <th width="5%" rowspan="2">OTLH</th>
                        <th width="5%" rowspan="2">OTSHDO</th>
                        <th width="5%" rowspan="2">OTLHDO</th>
                        <th width="5%" rowspan="2">NDDO</th>
                        <th width="5%" rowspan="2">NDSH</th>
                        <th width="5%" rowspan="2">NDLH</th>
                        <th width="5%" rowspan="2">NDSHDO</th>
                        <th width="5%" rowspan="2">NDLHDO</th>
                        <th width="5%" rowspan="2">NPDO</th>
                        <th width="5%" rowspan="2">NPSH</th>
                        <th width="5%" rowspan="2">NPLH</th>
                        <th width="5%" rowspan="2">NPSHDO</th>
                        <th width="5%" rowspan="2">NPLHDO</th>
                        <!--th width="5%" rowspan="2"><span class="cursorpoint" title="Regular Overtime">ROT hr(s)</span></th>
                        <th width="5%" rowspan="2"><span class="cursorpoint" title="Special Holiday/Legal Holiday/Restday">SH/LH/RD hr(s)</span></th-->
                    </tr>
                    <tr>
                        <th width="5%">In</th>
                        <th width="5%">Out</th>
                    </tr>
                    <?php
                        $total_workhrs = 0;
                        $total_latehrs = 0;
                        $total_uthrs = 0;
                        $total_ndhrs = 0;
                        $total_absent = 0;
                        $total_leave = 0;
                        $total_sh = 0;
                        $total_ml = 0;

                        $total_ot01 = 0;
                        $total_ot02 = 0;
                        $total_ot03 = 0;
                        $total_ot04 = 0;
                        $total_ot05 = 0;
                        $total_ot06 = 0;
                        $total_ot07 = 0;
                        $total_ot08 = 0;
                        $total_ot09 = 0;
                        $total_ot10 = 0;
                        $total_ot11 = 0;
                        $total_ot12 = 0;
                        $total_ot13 = 0;
                        $total_ot14 = 0;
                        $total_ot15 = 0;
                        $total_ot16 = 0;
                        $total_ot17 = 0;
                        $total_ot18 = 0;
                        $total_ot19 = 0;
                        $total_ot20 = 0;
                        $total_ot21 = 0;
                        $total_ot22 = 0;

                        $shiftsched = $mainsql->get_schedshift($profile_idnum);
                    ?>
                    <?php foreach ($dtr_data as $key => $value) : ?>
                    <?php

                        $numdays = intval(date("N", strtotime($value['DTRDATE'])));

                        $leavedays = $value['L01'] + $value['L02'] + $value['L03'] + $value['L04'] + $value['L05'] + $value['L06'] + $value['L07'] + $value['L08'] + $value['L09'] + $value['L10'] + $value['L11'] + $value['L12'] + $value['L13'] + $value['L14'] + $value['L15'] + $value['L16'] + $value['L17'] + $value['L18'] + $value['L19'] + $value['L20'];
                        $absent = $value['Absent'] - ($value['L01'] + $value['L02'] + $value['L03'] + $value['L04'] + $value['L05'] + $value['L06'] + $value['L07'] + $value['L08'] + $value['L09'] + $value['L10'] + $value['L11'] + $value['L12'] + $value['L13'] + $value['L14'] + $value['L15'] + $value['L16'] + $value['L17'] + $value['L18'] + $value['L19'] + $value['L20']);

                        $absent = $absent < 0 ? 0 : $absent;

                        $shhours = $value['OTHrs02'] + $value['OTHrs03'] + $value['OTHrs04'] + $value['OTHrs05'] + $value['OTHrs06'] + $value['OTHrs07'] + $value['OTHrs08'] + $value['OTHrs09'] + $value['OTHrs10'] + $value['OTHrs11'] + $value['OTHrs12'] + $value['OTHrs13'] + $value['OTHrs14'] + $value['OTHrs15'] + $value['OTHrs16'] + $value['OTHrs17'] + $value['OTHrs18'] + $value['OTHrs19'] + $value['OTHrs20'] + $value['OTHrs21'] + $value['OTHrs22'] + $value['OTHrs23'] + $value['OTHrs24'] + $value['OTHrs25'];

                        // NDHours
                        /*if (!$profile_minothours) :
                            $ndhours = ($value['NDHrs'] + $value['OTHrs14'] + $value['OTHrs15'] + $value['OTHrs16'] + $value['OTHrs17'] + $value['OTHrs18'] + $value['OTHrs19'] + $value['OTHrs20'] + $value['OTHrs21'] + $value['OTHrs22']);
                        elseif ($profile_minothours == 1) :
                            $ndhours = ($value['NDHrs'] + $value['OTHrs02'] + $value['OTHrs13'] + $value['OTHrs14'] + $value['OTHrs15'] + $value['OTHrs16'] + $value['OTHrs17'] + $value['OTHrs18'] + $value['OTHrs19'] + $value['OTHrs20'] + $value['OTHrs21'] + $value['OTHrs22']);
                        else :
                            if (($value['OTHrs01'] + $value['OTHrs02']) < $profile_minothours) :
                                $ndhours = ($value['OTHrs13'] + $value['OTHrs14'] + $value['OTHrs15'] + $value['OTHrs16'] + $value['OTHrs17'] + $value['OTHrs18'] + $value['OTHrs19'] + $value['OTHrs20'] + $value['OTHrs21'] + $value['OTHrs22']);
                            else :
                                $ndhours = ($value['NDHrs'] + $value['OTHrs02'] + $value['OTHrs13'] + $value['OTHrs14'] + $value['OTHrs15'] + $value['OTHrs16'] + $value['OTHrs17'] + $value['OTHrs18'] + $value['OTHrs19'] + $value['OTHrs20'] + $value['OTHrs21'] + $value['OTHrs22']);
                            endif;
                        endif;*/
                        $ndhours = $value['NDHrs'];

                        // ROT
                        if (!$profile_minothours) :
                            $rot = 0;
                        elseif ($profile_minothours == 1) :
                            $rot = ($value['OTHrs01'] + $value['OTHrs02']);
                        else :
                            if (($value['ApprovedOTHrs'] < $value['ActualOTHrs'] && $value['ApprovedOTHrs'] < $profile_minothours) || ($value['ApprovedOTHrs'] >= $value['ActualOTHrs'] && $value['ActualOTHrs'] < $profile_minothours)) :
                                $rot = 0;
                            else :
                                $rot = ($value['OTHrs01'] + $value['OTHrs02']);
                            endif;
                        endif;

                        //SH/LH/RD
                        if ($value['ApprovedOTHrs'] < $value['ActualOTHrs']) :
                            if ($value['ApprovedOTHrs'] < ($value['OTHrs03'] + $value['OTHrs04'] + $value['OTHrs05'] + $value['OTHrs06'] + $value['OTHrs07'] + $value['OTHrs08'] + $value['OTHrs09'] + $value['OTHrs10'] + $value['OTHrs11'] + $value['OTHrs12'] + $value['OTHrs13'])) :
                                $shlhrd = $value['ApprovedOTHrs'];
                            else :
                                $shlhrd = $value['OTHrs03'] + $value['OTHrs04'] + $value['OTHrs05'] + $value['OTHrs06'] + $value['OTHrs07'] + $value['OTHrs08'] + $value['OTHrs09'] + $value['OTHrs10'] + $value['OTHrs11'] + $value['OTHrs12'] + $value['OTHrs13'];
                            endif;
                        else :
                            if ($value['ActualOTHrs'] < ($value['OTHrs03'] + $value['OTHrs04'] + $value['OTHrs05'] + $value['OTHrs06'] + $value['OTHrs07'] + $value['OTHrs08'] + $value['OTHrs09'] + $value['OTHrs10'] + $value['OTHrs11'] + $value['OTHrs12'] + $value['OTHrs13'])) :
                                $shlhrd = $value['ActualOTHrs'];
                            else :
                                $shlhrd = $value['OTHrs03'] + $value['OTHrs04'] + $value['OTHrs05'] + $value['OTHrs06'] + $value['OTHrs07'] + $value['OTHrs08'] + $value['OTHrs09'] + $value['OTHrs10'] + $value['OTHrs11'] + $value['OTHrs12'] + $value['OTHrs13'];
                            endif;
                        endif;

                        $total_workhrs = $total_workhrs + $value['WorkHrs'];
                        $total_latehrs = $total_latehrs + $value['LateHrs'];
                        $total_uthrs = $total_uthrs + $value['UTHrs'];
                        $total_ndhrs = $total_ndhrs + $ndhours;
                        $total_absent = $total_absent + $absent;
                        $total_leave = $total_leave + $leavedays;
                        $total_ot = $total_ot + $rot;
                        $total_sh = $total_sh + $shlhrd;
                        $total_ml = $total_ml + $value['ML'];

                        $total_ot01 = $total_ot01 + $value['OTHrs01'];
                        $total_ot02 = $total_ot02 + $value['OTHrs02'];
                        $total_ot03 = $total_ot03 + $value['OTHrs03'] + $value['OTHrs23'];
                        $total_ot04 = $total_ot04 + $value['OTHrs04'];
                        $total_ot05 = $total_ot05 + $value['OTHrs05'];
                        $total_ot06 = $total_ot06 + $value['OTHrs06'];
                        $total_ot07 = $total_ot07 + $value['OTHrs07'];
                        $total_ot08 = $total_ot08 + $value['OTHrs08'];
                        $total_ot09 = $total_ot09 + $value['OTHrs09'];
                        $total_ot10 = $total_ot10 + $value['OTHrs10'];
                        $total_ot11 = $total_ot11 + $value['OTHrs11'];
                        $total_ot12 = $total_ot12 + $value['OTHrs12'];
                        $total_ot13 = $total_ot13 + $value['OTHrs13'];
                        $total_ot14 = $total_ot14 + $value['OTHrs14'];
                        $total_ot15 = $total_ot15 + $value['OTHrs15'];
                        $total_ot16 = $total_ot16 + $value['OTHrs16'];
                        $total_ot17 = $total_ot17 + $value['OTHrs17'];
                        $total_ot18 = $total_ot18 + $value['OTHrs18'];
                        $total_ot19 = $total_ot19 + $value['OTHrs19'];
                        $total_ot20 = $total_ot20 + $value['OTHrs20'];
                        $total_ot21 = $total_ot21 + $value['OTHrs21'];
                        $total_ot22 = $total_ot22 + $value['OTHrs22'];

                        $holidate = explode('/', date("m/d/Y", strtotime($value['DTRDATE'])));
                        $thisisholiday = $mainsql->get_holiday(1, $holidate[0], $holidate[1], $profile_location);
                        $restdaydate = $mainsql->get_restday($profile_idnum, date("m/d/Y", strtotime($value['DTRDATE'])));
                        $appliedrestdaydate = $mainsql->get_appliedrestday($profile_idnum, date("m/d/Y", strtotime($value['DTRDATE'])), $profile_comp);
                        $appliedscheddate = $mainsql->get_appliedsched($profile_idnum, date("m/d/Y", strtotime($value['DTRDATE'])), $profile_comp);
                        $mdtrrestdaydate = $mainsql->get_mdtrrestday($profile_idnum, date("m/d/Y", strtotime($value['DTRDATE'])), $profile_comp);
                        $mdtrscheddate = $mainsql->get_mdtrsched($profile_idnum, date("m/d/Y", strtotime($value['DTRDATE'])), $profile_comp);

                        //var_dump($restdaydate[0]['DAYOFF'].' '.$appliedrestdaydate[0]['RESTDAY']);

                        if ($appliedscheddate[0]['NEWSHIFTID']) :
                            if ($mdtrscheddate[0]['ShiftID']) :
                                $thisisrestday = 0;
                            else :
                                $thisisrestday = $mdtrrestdaydate[0]['RestDay'] ? 1 : 0;
                            endif;
                        else :
                            if ($mdtrscheddate[0]['ShiftID']) :
                                $thisisrestday = 0;
                            else :
                                if ($appliedrestdaydate[0]['RESTDAY']) :
                                    $thisisrestday = $restdaydate[0]['DAYOFF'] ? 1 : $appliedrestdaydate[0]['RESTDAY'];
                                else :
                                    $thisisrestday = $mdtrrestdaydate[0]['RestDay'] ? 1 : 0;
                                endif;
                            endif;
                        endif;

                    ?>

                    <tr class="trdata centertalign">
                        <td><?php echo date("M j", strtotime($value['DTRDATE'])); ?></td>
                        <td><?php echo date("l", strtotime($value['DTRDATE'])); ?></td>
                        <td><?php
                            if ($thisisholiday == 1) :
                                echo 'HOLIDAY';
                            /*elseif ($thisisrestday == 1) :
                                echo 'RESTDAY';*/
                            else :
                                echo $value['ShiftDesc'];
                            endif;
                        ?></td>
                        <?php $timearray = preg_split('/\s+/', trim($value['TimeIN'])); $timearray2 = preg_split('/\s+/', trim($value['TimeOut'])); ?>
                        <td><?php
                            if ($value['TimeINDate'] == $value['TimeIN']) :
                                $value['TimeIN'] = 0;
                            endif;
                            if ($value['TimeOutDate'] == $value['TimeOut']) :
                                $value['TimeOut'] = 0;
                            endif;
                            echo $value['TimeIN'] ? date("h:ia", strtotime($timearray[3])) : '';
                        ?></td>
                        <td><?php if ($value['TimeOut']) : echo $value['TimeOut'] ? date("h:ia", strtotime($timearray2[3])) : ''; endif; ?></td>
                        <td><?php echo $value['OB'] ? '<i class="fa fa-check greentext"></i>' : '<i class="fa fa-times redtext"></i>'; ?></td>
                        <td><?php echo number_format($value['WorkHrs'], 2); ?></td>
                        <td class="lredtext"><?php echo number_format($absent, 2); ?></td>
                        <td class="lorangetext"><?php echo number_format($value['LateHrs'], 2); ?></td>
                        <td class="lorangetext"><?php echo number_format($value['UTHrs'], 2); ?></td>
                        <td class="lbluetext"><?php echo number_format($ndhours, 2); ?></td>
                        <td><?php echo number_format($leavedays, 2); ?></td>
                        <td><?php echo $value['LEAVE_DESC']; ?></td>
                        <td><?php echo number_format($value['ML'], 2); ?></td>
                        <td><?php echo $value['OTHrs01'] ? number_format($value['OTHrs01'], 2) : '0.00'; ?></td>
                        <td><?php echo $value['OTHrs02'] ? number_format($value['OTHrs02'], 2) : '0.00'; ?></td>
                        <td><?php echo ($value['OTHrs03'] || $value['OTHrs23']) ? number_format($value['OTHrs03'] + $value['OTHrs23'], 2) : '0.00'; ?></td>
                        <td><?php echo $value['OTHrs04'] ? number_format($value['OTHrs04'], 2) : '0.00'; ?></td>
                        <td><?php echo $value['OTHrs05'] ? number_format($value['OTHrs05'], 2) : '0.00'; ?></td>
                        <td><?php echo $value['OTHrs06'] ? number_format($value['OTHrs06'], 2) : '0.00'; ?></td>
                        <td><?php echo $value['OTHrs07'] ? number_format($value['OTHrs07'], 2) : '0.00'; ?></td>
                        <td><?php echo $value['OTHrs08'] ? number_format($value['OTHrs08'], 2) : '0.00'; ?></td>
                        <td><?php echo $value['OTHrs09'] ? number_format($value['OTHrs09'], 2) : '0.00'; ?></td>
                        <td><?php echo $value['OTHrs10'] ? number_format($value['OTHrs10'], 2) : '0.00'; ?></td>
                        <td><?php echo $value['OTHrs11'] ? number_format($value['OTHrs11'], 2) : '0.00'; ?></td>
                        <td><?php echo $value['OTHrs12'] ? number_format($value['OTHrs12'], 2) : '0.00'; ?></td>
                        <td><?php echo $value['OTHrs13'] ? number_format($value['OTHrs13'], 2) : '0.00'; ?></td>
                        <td><?php echo $value['OTHrs14'] ? number_format($value['OTHrs14'], 2) : '0.00'; ?></td>
                        <td><?php echo $value['OTHrs15'] ? number_format($value['OTHrs15'], 2) : '0.00'; ?></td>
                        <td><?php echo $value['OTHrs16'] ? number_format($value['OTHrs16'], 2) : '0.00'; ?></td>
                        <td><?php echo $value['OTHrs17'] ? number_format($value['OTHrs17'], 2) : '0.00'; ?></td>
                        <td><?php echo $value['OTHrs18'] ? number_format($value['OTHrs18'], 2) : '0.00'; ?></td>
                        <td><?php echo $value['OTHrs19'] ? number_format($value['OTHrs19'], 2) : '0.00'; ?></td>
                        <td><?php echo $value['OTHrs20'] ? number_format($value['OTHrs20'], 2) : '0.00'; ?></td>
                        <td><?php echo $value['OTHrs21'] ? number_format($value['OTHrs21'], 2) : '0.00'; ?></td>
                        <td><?php echo $value['OTHrs22'] ? number_format($value['OTHrs22'], 2) : '0.00'; ?></td>
                        <!--td><?php echo number_format($rot, 2); ?></td>
                        <td><?php echo number_format($shlhrd, 2); ?></td-->
                    </tr>
                    <?php endforeach; ?>
                    <tr class="bold centertalign">
                        <td colspan="6">Total</td>
                        <td><?php echo number_format($total_workhrs, 2); ?></td>
                        <td class="lredtext"><?php echo number_format($total_absent, 2); ?></td>
                        <td class="lorangetext"><?php echo number_format($total_latehrs, 2); ?></td>
                        <td class="lorangetext"><?php echo number_format($total_uthrs, 2); ?></td>
                        <td class="lbluetext"><?php echo number_format($total_ndhrs, 2); ?></td>
                        <td><?php echo number_format($total_leave, 2); ?></td>
                        <td>&nbsp;</td>
                        <td><?php echo number_format($total_ml, 2); ?></td>
                        <td><?php echo number_format($total_ot01, 2); ?></td>
                        <td><?php echo number_format($total_ot02, 2); ?></td>
                        <td><?php echo number_format($total_ot03, 2); ?></td>
                        <td><?php echo number_format($total_ot04, 2); ?></td>
                        <td><?php echo number_format($total_ot05, 2); ?></td>
                        <td><?php echo number_format($total_ot06, 2); ?></td>
                        <td><?php echo number_format($total_ot07, 2); ?></td>
                        <td><?php echo number_format($total_ot08, 2); ?></td>
                        <td><?php echo number_format($total_ot09, 2); ?></td>
                        <td><?php echo number_format($total_ot10, 2); ?></td>
                        <td><?php echo number_format($total_ot11, 2); ?></td>
                        <td><?php echo number_format($total_ot12, 2); ?></td>
                        <td><?php echo number_format($total_ot13, 2); ?></td>
                        <td><?php echo number_format($total_ot14, 2); ?></td>
                        <td><?php echo number_format($total_ot15, 2); ?></td>
                        <td><?php echo number_format($total_ot16, 2); ?></td>
                        <td><?php echo number_format($total_ot17, 2); ?></td>
                        <td><?php echo number_format($total_ot18, 2); ?></td>
                        <td><?php echo number_format($total_ot19, 2); ?></td>
                        <td><?php echo number_format($total_ot20, 2); ?></td>
                        <td><?php echo number_format($total_ot21, 2); ?></td>
                        <td><?php echo number_format($total_ot22, 2); ?></td>
                        <!--td><?php echo number_format($total_ot, 2); ?></td>
                        <td><?php echo number_format($total_sh, 2); ?></td-->
                    </tr>
                <?php else : ?>
                    <tr>
                        <td colspan="14" class="bold centertalign noborder"><br><br>No DTR record found on this period</td>
                    </tr>
                <?php endif; ?>
            </table>

            <?php
        break;
        default:
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";

    }

?>
