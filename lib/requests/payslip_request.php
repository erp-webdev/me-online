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
        case 'perioddata':                    
            $payslip_year = $_POST['year'];  
            $payslip_cover = $_POST['cover'];  
            
            if ($payslip_cover) :
                $payslip_period = $mainsql->get_payslip_period($payslip_year, $profile_comp, $payslip_cover);
            else :
                $payslip_period = $mainsql->get_payslip_period($payslip_year, $profile_comp);
            endif;
            // New payslip cutoff beginning april 2020
            if($payslip_period[0]['PRYear'] > 2020 || ($payslip_period[0]['PRYear'] == 2020 && !in_array( $payslip_period[0]['PeriodID'], ['S01', 'S02', 'S03', 'S04', 'S05', 'S06', 'S07', 'S08', 'S09'])))
                echo '{"periodcover":"'.($payslip_period[0]['PRFrom'] ? date("m/d/Y", strtotime($payslip_period[0]['PRFrom'])).' to '.date("m/d/Y", strtotime($payslip_period[0]['PRTo'])) : '').'", "prto":"'.($payslip_period[0]['PRTo'] ? date("m/d/Y", strtotime($payslip_period[0]['PRTo'])) : '').'"}';
            else
                echo '{"periodcover":"'.($payslip_period[0]['PeriodFrom'] ? date("m/d/Y", strtotime($payslip_period[0]['PeriodFrom'])).' to '.date("m/d/Y", strtotime($payslip_period[0]['PeriodTo'])) : '').'", "prto":"'.($payslip_period[0]['PeriodTo'] ? date("m/d/Y", strtotime($payslip_period[0]['PRTo'])) : '').'"}';
            
        break;
        case 'periodsel':                
            $payslip_year = $_POST['year'];
            
            $year_select = '';
            $payslip_period = $mainsql->get_payslip_period($payslip_year, $profile_comp);    
            if ($payslip_period) :
                foreach ($payslip_period as $key => $value) :
                    if ($value['PeriodID'] != 'SP23') :
                    $year_select .= '<option value="'.$value['PeriodID'].'">'.$value['PaymentType']." ".$value['PRYear']." ".date("m/d/Y", strtotime($value['PeriodFrom']))." to ".date("m/d/Y", strtotime($value['PeriodTo'])).'</option>';
                    endif;
                endforeach;
                $year_select .= '<option value="SP04">SL CONVERSION '.$payslip_year.'</option>';
                if ($payslip_year == '2017') :
                $year_select .= '<option value="SP21">13TH MONTH '.$payslip_year.'</option>';
                else :
                  $year_select .= '<option value="SP08">13TH MONTH 1/2 '.$payslip_year.'</option>';
                  $year_select .= '<option value="SP21">13TH MONTH 2/2 '.$payslip_year.'</option>';
                endif;
                $year_select .= '<!--option value="SP23">YEAREND BONUS '.$payslip_year.'</option-->';
            endif;
            echo $year_select;
        break;
        case 'periodsel2':                
            $payslip_year = $_POST['year'];
            $payslip_period = $mainsql->get_payslip_period($payslip_year, $profile_comp);    
            if ($payslip_period) :            
                $latestperiod = $payslip_period[0]['PeriodID'];
            endif;
            echo $latestperiod;
        break;
        case 'table':                
            $payslip_year = $_POST['year'];  
            $payslip_cover = $_POST['cover'];  
        
            $payslip_data = $mainsql->get_payslip_data($profile_idnum, $payslip_year, $payslip_cover);      
            $payslip_sldata = $mainsql->get_payslip_sldata($profile_idnum, $payslip_year, $payslip_cover);      
            $payslip_sldata2 = $mainsql->get_payslip_sldata2($profile_idnum, $payslip_year, $payslip_cover);      
            
            //var_dump($payslip_sldata);
            
            $payslip_oedesc = $mainsql->get_payslip_oedesc(); 
            $payslip_oddesc = $mainsql->get_payslip_oddesc(); 
            
            //LOANS
            $payslip_loans = $mainsql->get_payslip_loan2($profile_idnum, $payslip_year, $payslip_cover);

            //EARNED TAXABLE
            $payslip_oemaster1 = $mainsql->get_payslip_oemaster($profile_idnum, $payslip_year, $payslip_cover, 1);   
            //EARNED NON-TAXABLE
            $payslip_oemaster2 = $mainsql->get_payslip_oemaster($profile_idnum, $payslip_year, $payslip_cover);     
            
            //EARNED TAXABLE
            $payslip_etaxable = $mainsql->get_payslip_allowancetype(2);         
            //EARNED NON-TAXABLE
            $payslip_enontaxable = $mainsql->get_payslip_allowancetype(1);         
            //DEDUCTION
            $payslip_deduction = $mainsql->get_payslip_allowancetype(3);         
            
            $i = 0;
            foreach ($payslip_etaxable as $key => $value) :            
                $iot[$i] = 'B.'.$value['OExtID'];
                $i++;  
            endforeach;
            $arrot = implode(',', $iot);
            
            $i = 0;
            foreach ($payslip_enontaxable as $key => $value) :            
                $ion[$i] = 'B.'.$value['OExtID'];
                $i++;  
            endforeach;
            $arron = implode(',', $ion);
            
            $i = 0;
            foreach ($payslip_deduction as $key => $value) :            
                $iod[$i] = 'B.'.$value['OExtID'];
                $i++;  
            endforeach;
            $arrod = implode(',', $iod);
            
            //var_dump($arrod);
            
            //EARNED TAXABLE
            $payslip_getetaxable = $mainsql->get_payslip_allownacevalue($profile_idnum, $arrot, $payslip_year, $payslip_cover);   
            //EARNED NON-TAXABLE
            $payslip_getenontaxable = $mainsql->get_payslip_allownacevalue($profile_idnum, $arron, $payslip_year, $payslip_cover);       
            //DEDUCTION
            $payslip_getdeduction = $mainsql->get_payslip_allownacevalue($profile_idnum, $arrod, $payslip_year, $payslip_cover); 
            
            $payslip_earn = $mainsql->get_payslip_otherearn($profile_idnum, $payslip_year, $payslip_cover, 1); 
            $payslip_earn2 = $mainsql->get_payslip_otherearn($profile_idnum, $payslip_year, $payslip_cover, 0); 
            $payslip_deduct = $mainsql->get_payslip_otherdeduct($profile_idnum, $payslip_year, $payslip_cover);
            
            $payslip_odmaster = $mainsql->get_payslip_odmaster($profile_idnum, $payslip_year, $payslip_cover);
            $payslip_otmaster = $mainsql->get_payslip_otmaster($profile_idnum, $payslip_year, $payslip_cover);  
            //var_dump($payslip_otmaster);

            //var_dump($payslip_oddesc);
            
            $leave_data = $mainsql->get_leave();
            
            //$oeleave = $mainsql->get_payslip_oeleave($profile_idnum, $payslip_year, $payslip_cover);
            //$covertleave = $mainsql->get_payslip_convleave($profile_idnum, $payslip_year);
            
            //var_dump($payslip_data);
            ?>   

            <table  border="0" cellspacing="0" class="tdata margintop25 tinytext width100per">
                
                <?php if($payslip_cover != 'SP04') : ?>
                                    
                    <?php if($payslip_data) : ?>

                    <tr>
                        <td width="34%" class="noborder valigntop">
                            <table border="0" cellspacing="0" class="tdata width100per">
                                <tr >
                                    <th height="30" width="34%">TAX EARNINGS</th>
                                    <th height="30" width="33%">UNIT</th>
                                    <th height="30" width="33%">AMOUNT</th>
                                </tr>
                                <?php if ($payslip_data[0]['RegPay']) : ?>
                                <tr class="trdata">
                                    <td>BASIC PAY</td>
                                    <td class="centertalign"><!--<?php echo number_format($payslip_data[0]['RegHrs'] / 8, 1); ?> days--></td>
                                    <td class="righttalign"><?php echo number_format($payslip_data[0]['RegPay'], 2); ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if ($payslip_data[0]['NDPay']) : ?>
                                <tr class="trdata">
                                    <td>ND</td>
                                    <td class="centertalign"><?php echo $payslip_data[0]['NDHrs'] >= 1 ? number_format($payslip_data[0]['NDHrs'], 2).' hours' : number_format($payslip_data[0]['NDHrs'] * 60, 2).' mins'; ?></td>
                                    <td class="righttalign"><?php echo number_format($payslip_data[0]['NDPay'], 2); ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php 
                                    $absent_num = $payslip_data[0]['AbsentHrs'] - $payslip_data[0]['TotalLeaveHrs']; 
                                    $absent_pay = $payslip_data[0]['AbsentPay'] - $payslip_data[0]['TotalLeavePay']; 
                                ?>
                                <?php if ($absent_num > 0) : ?>
                                    <?php if ($payslip_cover != 'SP21' && $payslip_cover != 'SP08') : ?>
                                    <tr class="trdata">
                                        <td>Absent</td>
                                        <td class="centertalign"><?php echo number_format($absent_num / 8, 1); ?> days</td>
                                        <td class="righttalign">(<?php echo number_format($absent_pay, 2); ?>)</td>
                                    </tr>
                                    <?php endif; ?>
                                <?php endif; ?> 
                               
                               <?php if ($payslip_cover == 'SP21' || $payslip_cover == 'SP08') : ?>
                                <tr class="trdata">
                                    <td>13TH MONTH PAY (TAXABLE)</td>
                                    <td class="centertalign"></td>
                                    <td class="righttalign">
                                        <?php 

                                        foreach($payslip_oemaster1[0] as $key => $value){

                                            if($key == 'OE23'){
                                                echo number_format($value, 2);
                                            }
                                        }

                                         ?>
                                    </td>
                                </tr>
                                <?php endif; ?>

                                <?php if ($payslip_data[0]['LatePay']) : ?>
                                <tr class="trdata">
                                    <td>LATE</td>
                                    <td class="centertalign"><?php echo $payslip_data[0]['LateHrs'] >= 1 ? number_format($payslip_data[0]['LateHrs'], 2).' hours' : number_format($payslip_data[0]['LateHrs'] * 60, 2).' mins'; ?></td>
                                    <td class="righttalign">(<?php echo number_format($payslip_data[0]['LatePay'], 2); ?>)</td>
                                </tr>
                                <?php endif; ?>
                                <?php if ($payslip_data[0]['UTPay']) : ?>
                                <tr class="trdata">
                                    <td>UT</td>
                                    <td class="centertalign"><?php echo $payslip_data[0]['UTHrs'] >= 1 ? number_format($payslip_data[0]['UTHrs'], 2).' hours' : number_format($payslip_data[0]['UTHrs'] * 60, 2).' mins'; ?></td>
                                    <td class="righttalign">(<?php echo number_format($payslip_data[0]['UTPay'], 2); ?>)</td>
                                </tr>
                                <?php endif; ?>
                                    
                                <?php 
                                    $ottype = array(
                                        0 => array('OTID'=>'OTHrs01', 'OTDesc'=>'Regular OT'),
                                        1 => array('OTID'=>'OTHrs02', 'OTDesc'=>'NP Regular OT'),
                                        2 => array('OTID'=>'OTHrs03', 'OTDesc'=>'Restday/Sunday'),
                                        3 => array('OTID'=>'OTHrs04', 'OTDesc'=>'Special Holiday'),
                                        4 => array('OTID'=>'OTHrs05', 'OTDesc'=>'Legal Holiday'),
                                        5 => array('OTID'=>'OTHrs06', 'OTDesc'=>'Special Holiday - Restday'),
                                        6 => array('OTID'=>'OTHrs07', 'OTDesc'=>'Legal Holiday - Restday'),
                                        7 => array('OTID'=>'OTHrs08', 'OTDesc'=>'OT - Restday/Sunday'),
                                        8 => array('OTID'=>'OTHrs09', 'OTDesc'=>'OT - Special Holiday'),
                                        9 => array('OTID'=>'OTHrs10', 'OTDesc'=>'OT - Legal Holiday'),
                                        10 => array('OTID'=>'OTHrs11', 'OTDesc'=>'OT - Special Holiday - Restday/Sunday'),
                                        11 => array('OTID'=>'OTHrs12', 'OTDesc'=>'OT - Legal Holiday - Restday/Sunday'),
                                        12 => array('OTID'=>'OTHrs13', 'OTDesc'=>'NightDiff - Restday/Sunday'),
                                        13 => array('OTID'=>'OTHrs14', 'OTDesc'=>'NightDiff - Special Holiday'),
                                        14 => array('OTID'=>'OTHrs15', 'OTDesc'=>'NightDiff - Legal Holiday'),
                                        15 => array('OTID'=>'OTHrs16', 'OTDesc'=>'NightDiff - Special Holiday - Restday/Sunday'),
                                        16 => array('OTID'=>'OTHrs17', 'OTDesc'=>'NightDiff - Legal Holiday - Restday/Sunday'),
                                        17 => array('OTID'=>'OTHrs18', 'OTDesc'=>'NightDiff - Restday/Sunday'),
                                        18 => array('OTID'=>'OTHrs19', 'OTDesc'=>'NightDiff - Special Holiday'),
                                        19 => array('OTID'=>'OTHrs20', 'OTDesc'=>'NightDiff - Legal Holiday'),
                                        20 => array('OTID'=>'OTHrs21', 'OTDesc'=>'NightDiff - Special Holiday - Restday/Sunday'),
                                        21 => array('OTID'=>'OTHrs22', 'OTDesc'=>'NightDiff - Legal Holiday - Restday/Sunday'),
                                        22 => array('OTID'=>'OTHrs23', 'OTDesc'=>'Restday/Saturday')
                                    );
            
                                    if ($payslip_cover != 'SP21' && $payslip_cover != 'SP08') : 
                                    
                                    foreach ($payslip_otmaster as $key => $value) :
                                        foreach ($value as $k => $v) :
                                            if ($v && $k != 'OTPay01' && $k != 'OTPay02' && $k != 'OTPay03' && $k != 'OTPay04' && $k != 'OTPay05' && $k != 'OTPay06' && $k != 'OTPay07' && $k != 'OTPay08' && $k != 'OTPay09' && $k != 'OTPay10' && $k != 'OTPay11' && $k != 'OTPay12' && $k != 'OTPay13' && $k != 'OTPay14' && $k != 'OTPay15' && $k != 'OTPay16' && $k != 'OTPay17' && $k != 'OTPay18' && $k != 'OTPay19' && $k != 'OTPay20' && $k != 'OTPay21' && $k != 'OTPay22' && $k != 'OTPay23') :
                                                echo '<tr class="trdata"><td>';
                                                if ($k == 'OTHrs01') : echo $ottype[0]["OTDesc"];
                                                elseif ($k == 'OTHrs02') : echo $ottype[1]["OTDesc"];
                                                elseif ($k == 'OTHrs03') : echo $ottype[2]["OTDesc"];
                                                elseif ($k == 'OTHrs04') : echo $ottype[3]["OTDesc"];
                                                elseif ($k == 'OTHrs05') : echo $ottype[4]["OTDesc"];
                                                elseif ($k == 'OTHrs06') : echo $ottype[5]["OTDesc"];
                                                elseif ($k == 'OTHrs07') : echo $ottype[6]["OTDesc"];
                                                elseif ($k == 'OTHrs08') : echo $ottype[7]["OTDesc"];
                                                elseif ($k == 'OTHrs09') : echo $ottype[8]["OTDesc"];
                                                elseif ($k == 'OTHrs10') : echo $ottype[9]["OTDesc"];
                                                elseif ($k == 'OTHrs11') : echo $ottype[10]["OTDesc"];
                                                elseif ($k == 'OTHrs12') : echo $ottype[11]["OTDesc"];
                                                elseif ($k == 'OTHrs13') : echo $ottype[12]["OTDesc"];
                                                elseif ($k == 'OTHrs14') : echo $ottype[13]["OTDesc"];
                                                elseif ($k == 'OTHrs15') : echo $ottype[14]["OTDesc"];
                                                elseif ($k == 'OTHrs16') : echo $ottype[15]["OTDesc"];
                                                elseif ($k == 'OTHrs17') : echo $ottype[16]["OTDesc"];
                                                elseif ($k == 'OTHrs18') : echo $ottype[17]["OTDesc"];
                                                elseif ($k == 'OTHrs19') : echo $ottype[18]["OTDesc"];
                                                elseif ($k == 'OTHrs20') : echo $ottype[19]["OTDesc"];
                                                elseif ($k == 'OTHrs21') : echo $ottype[20]["OTDesc"];
                                                elseif ($k == 'OTHrs22') : echo $ottype[21]["OTDesc"];
                                                elseif ($k == 'OTHrs23') : echo $ottype[22]["OTDesc"];
                                                endif; 
                                                echo '</td><td class="centertalign">';
                                                if ($k == 'OTHrs01') : echo number_format($value['OTHrs01'], 1).' hours';
                                                elseif ($k == 'OTHrs02') : echo number_format($value['OTHrs02'], 1).' hours';
                                                elseif ($k == 'OTHrs03') : echo number_format($value['OTHrs03'], 1).' hours';
                                                elseif ($k == 'OTHrs04') : echo number_format($value['OTHrs04'], 1).' hours';
                                                elseif ($k == 'OTHrs05') : echo number_format($value['OTHrs05'], 1).' hours';
                                                elseif ($k == 'OTHrs06') : echo number_format($value['OTHrs06'], 1).' hours';
                                                elseif ($k == 'OTHrs07') : echo number_format($value['OTHrs07'], 1).' hours';
                                                elseif ($k == 'OTHrs08') : echo number_format($value['OTHrs08'], 1).' hours';
                                                elseif ($k == 'OTHrs09') : echo number_format($value['OTHrs09'], 1).' hours';
                                                elseif ($k == 'OTHrs10') : echo number_format($value['OTHrs10'], 1).' hours';
                                                elseif ($k == 'OTHrs11') : echo number_format($value['OTHrs11'], 1).' hours';
                                                elseif ($k == 'OTHrs12') : echo number_format($value['OTHrs12'], 1).' hours';
                                                elseif ($k == 'OTHrs13') : echo number_format($value['OTHrs13'], 1).' hours';
                                                elseif ($k == 'OTHrs14') : echo number_format($value['OTHrs14'], 1).' hours';
                                                elseif ($k == 'OTHrs15') : echo number_format($value['OTHrs15'], 1).' hours';
                                                elseif ($k == 'OTHrs16') : echo number_format($value['OTHrs16'], 1).' hours';
                                                elseif ($k == 'OTHrs17') : echo number_format($value['OTHrs17'], 1).' hours';
                                                elseif ($k == 'OTHrs18') : echo number_format($value['OTHrs18'], 1).' hours';
                                                elseif ($k == 'OTHrs19') : echo number_format($value['OTHrs19'], 1).' hours';
                                                elseif ($k == 'OTHrs20') : echo number_format($value['OTHrs20'], 1).' hours';
                                                elseif ($k == 'OTHrs21') : echo number_format($value['OTHrs21'], 1).' hours';
                                                elseif ($k == 'OTHrs22') : echo number_format($value['OTHrs22'], 1).' hours';
                                                elseif ($k == 'OTHrs23') : echo number_format($value['OTHrs23'], 1).' hours';
                                                endif;
                                                echo '</td><td class="righttalign">';
                                                if ($k == 'OTHrs01') : echo number_format($value['OTPay01'], 2);
                                                elseif ($k == 'OTHrs02') : echo number_format($value['OTPay02'], 2);
                                                elseif ($k == 'OTHrs03') : echo number_format($value['OTPay03'], 2);
                                                elseif ($k == 'OTHrs04') : echo number_format($value['OTPay04'], 2);
                                                elseif ($k == 'OTHrs05') : echo number_format($value['OTPay05'], 2);
                                                elseif ($k == 'OTHrs06') : echo number_format($value['OTPay06'], 2);
                                                elseif ($k == 'OTHrs07') : echo number_format($value['OTPay07'], 2);
                                                elseif ($k == 'OTHrs08') : echo number_format($value['OTPay08'], 2);
                                                elseif ($k == 'OTHrs09') : echo number_format($value['OTPay09'], 2);
                                                elseif ($k == 'OTHrs10') : echo number_format($value['OTPay10'], 2);
                                                elseif ($k == 'OTHrs11') : echo number_format($value['OTPay11'], 2);
                                                elseif ($k == 'OTHrs12') : echo number_format($value['OTPay12'], 2);
                                                elseif ($k == 'OTHrs13') : echo number_format($value['OTPay13'], 2);
                                                elseif ($k == 'OTHrs14') : echo number_format($value['OTPay14'], 2);
                                                elseif ($k == 'OTHrs15') : echo number_format($value['OTPay15'], 2);
                                                elseif ($k == 'OTHrs16') : echo number_format($value['OTPay16'], 2);
                                                elseif ($k == 'OTHrs17') : echo number_format($value['OTPay17'], 2);
                                                elseif ($k == 'OTHrs18') : echo number_format($value['OTPay18'], 2);
                                                elseif ($k == 'OTHrs19') : echo number_format($value['OTPay19'], 2);
                                                elseif ($k == 'OTHrs20') : echo number_format($value['OTPay20'], 2);
                                                elseif ($k == 'OTHrs21') : echo number_format($value['OTPay21'], 2);
                                                elseif ($k == 'OTHrs22') : echo number_format($value['OTPay22'], 2);
                                                elseif ($k == 'OTHrs23') : echo number_format($value['OTPay23'], 2);
                                                endif; 
                                                echo '</td></tr>';

                                            endif;
                                        endforeach;
                                    endforeach;
            
                                    endif;
                                ?>
                                <?php
            
                                    if ($payslip_cover != 'SP21' && $payslip_cover != 'SP08') : 
                                    $otherallowance = 0;
                                    foreach ($payslip_getetaxable as $key => $value) :
                                        foreach ($value as $k => $v) :
                                            if ($v) :
                                                echo '<tr class="trdata">';
                                                if ($k == 'OE01') : 
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[0]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE02') : 
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[1]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE03') : 
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[2]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE04') : 
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[3]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE05') : 
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[4]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE06') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[5]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE07') : 
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[6]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE08') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[7]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE09') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[8]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE10') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[9]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE11') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[10]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE12') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[11]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE13') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[12]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE14') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[13]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE15') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[14]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE16') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[15]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE17') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[16]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE18') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[17]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE19') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[18]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE20') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[19]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $minusallowance += $v;
                                                elseif ($k == 'OE21') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[20]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE22') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[21]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE23') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[22]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE24') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[23]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE25') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[24]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE26') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[25]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE27') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[26]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE28') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[27]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE29') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[28]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE30') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[29]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $minusallowance += $v;
                                                elseif ($k == 'OE31') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[30]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE32') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[31]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE33') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[32]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $minusallowance += $v;
                                                elseif ($k == 'OE34') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[33]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE35') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[34]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $minusallowance += $v;
                                                elseif ($k == 'OE36') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[35]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE37') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[36]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE38') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[37]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE39') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[38]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE40') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[39]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE41') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[40]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $minusallowance += $v;
                                                elseif ($k == 'OE42') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[41]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $minusallowance += $v;
                                                elseif ($k == 'OE43') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[42]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE44') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[43]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE45') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[44]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE46') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[45]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE47') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[46]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE48') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[47]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE49') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[48]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE50') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[49]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE51') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[50]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE52') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[51]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE53') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[52]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE54') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[53]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE55') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[54]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE56') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[54]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE57') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[55]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                endif; 
                                                echo '</tr>';
                                            endif;
                                        endforeach;
                                    endforeach;
                                    endif;


                                ?>

                            </table>                                        
                        </td>
                        <!-- Non Tax -->
                        <td width="33%" class="noborder valigntop">
                            <table border="0" cellspacing="0" class="tdata width100per">
                                <tr>
                                    <th height="30" width="65%">NON-TAX EARNINGS</th>
                                    <th height="30" width="35%">AMOUNT</th>
                                </tr>
                                
                                
                                <?php
                                    $otherallowance = 0;
                                    $minusallowance = 0;
                                    foreach ($payslip_getenontaxable as $key => $value) :
                                        foreach ($value as $k => $v) :
                                            if ($v) :
                                                if ($k == 'OE01') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE02') : 
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE03') : 
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE04') : 
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE06') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE08') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE09') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE10') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE11') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE12') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE13') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE14') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE15') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE16') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE17') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE18') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE19') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE20') :
                                                    $minusallowance += $v;
                                                elseif ($k == 'OE21') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE22') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE23') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE24') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE25') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE26') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE27') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE28') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE29') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE30') :
                                                    $minusallowance += $v;
                                                elseif ($k == 'OE31') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE32') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE33') : 
                                                    $minusallowance += $v;
                                                elseif ($k == 'OE34') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE35') : 
                                                    $minusallowance += $v;
                                                elseif ($k == 'OE36') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE37') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE38') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE39') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE40') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE41') :
                                                    $minusallowance += $v;
                                                elseif ($k == 'OE42') :
                                                    $minusallowance += $v;
                                                elseif ($k == 'OE43') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE44') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE45') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE46') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE47') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE48') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE49') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE50') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE51') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE52') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE53') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE54') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE55') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE56') :
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE57') :
                                                    $otherallowance += $v;
                                                endif; 
                                            endif;
                                        endforeach;
                                    endforeach;
                                //var_dump($otherallowance);
                                ?>
                                <?php if ($payslip_cover != 'SP21' && $payslip_cover != 'SP08') : ?>
                                    <?php if ($payslip_data[0]['Allowance'] - $minusallowance) : ?>
                                    <tr class="trdata">
                                        <td>ALLOWANCE</td>
                                        <td class="righttalign"><?php echo number_format(($payslip_data[0]['Allowance'] - $minusallowance), 2); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                <?php endif; ?>
                                
                                <?php
                                    $otherallowance = 0;
                                    $minusallowance = 0;
                                    foreach ($payslip_getenontaxable as $key => $value) :
                                        foreach ($value as $k => $v) :
                                            if ($v) :
                                                echo '<tr class="trdata">';
                                                if ($k == 'OE01') : 
                                                    echo '<td>';
                                                    echo $payslip_oedesc[0]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE02') : 
                                                    echo '<td>';
                                                    echo $payslip_oedesc[1]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE03') : 
                                                    echo '<td>';
                                                    echo $payslip_oedesc[2]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE04') : 
                                                    echo '<td>';
                                                    echo $payslip_oedesc[3]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                /*elseif ($k == 'OE05') : 
                                                    echo '<td>';
                                                    echo $payslip_oedesc[4]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;*/
                                                elseif ($k == 'OE06') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[5]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                /*elseif ($k == 'OE07') : 
                                                    echo '<td>';
                                                    echo $payslip_oedesc[6]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;*/
                                                elseif ($k == 'OE08') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[7]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE09') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[8]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE10') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[9]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE11') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[10]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE12') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[11]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE13') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[12]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE14') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[13]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE15') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[14]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE16') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[15]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE17') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[16]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE18') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[17]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE19') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[18]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE20') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[19]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $minusallowance += $v;
                                                elseif ($k == 'OE21') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[20]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE22') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[21]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE23') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[22]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE24') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[23]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE25') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[24]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE26') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[25]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE27') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[26]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE28') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[27]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE29') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[28]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE30') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[29]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $minusallowance += $v;
                                                elseif ($k == 'OE31') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[30]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE32') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[31]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE33') : 
                                                    echo '<td>';
                                                    echo $payslip_oedesc[32]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $minusallowance += $v;
                                                elseif ($k == 'OE34') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[33]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE35') : 
                                                    echo '<td>';
                                                    echo $payslip_oedesc[34]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $minusallowance += $v;
                                                elseif ($k == 'OE36') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[35]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE37') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[36]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE38') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[37]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE39') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[38]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE40') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[39]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE41') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[40]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $minusallowance += $v;
                                                elseif ($k == 'OE42') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[41]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $minusallowance += $v;
                                                elseif ($k == 'OE43') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[42]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE44') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[43]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE45') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[44]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE46') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[45]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE47') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[46]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE48') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[47]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE49') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[48]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE50') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[49]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE51') :
                                                    echo '<td>';
                                                    echo $payslip_oedesc[50]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE52') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[51]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE53') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[52]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE54') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[53]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE55') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[54]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE56') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[54]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                elseif ($k == 'OE57') :
                                                    echo '<td colspan=2>';
                                                    echo $payslip_oedesc[55]["OExtDesc"];
                                                    echo '</td><td class="righttalign">';
                                                    echo number_format($v, 2);
                                                    echo '</td>';
                                                    $otherallowance += $v;
                                                endif; 
                                                echo '</tr>';
                                            endif;
                                        endforeach;
                                    endforeach;
                                //var_dump($otherallowance);
                                ?>
                            </table>                                                             
                        </td>

                        <td width="33%" class="valigntop noborder">
                            <table border="0" cellspacing="0" class="tdata width100per">
                                <tr>
                                    <th height="30" width="65%">DEDUCTIONS</th>
                                    <th height="30" width="35%">AMOUNT</th>
                                </tr>
                                <?php if ($payslip_data[0]['SSSEE']) : ?>
                                <tr class="trdata">
                                    <td>SSS</td>
                                    <td class="righttalign"><?php echo number_format($payslip_data[0]['SSSEE'], 2); ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if ($payslip_data[0]['PhilHEE']) : ?>
                                <tr class="trdata">
                                    <td>PhilHealth</td>
                                    <td class="righttalign"><?php echo number_format($payslip_data[0]['PhilHEE'], 2); ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if ($payslip_data[0]['PAGIBIGEE']) : ?>
                                <tr class="trdata">
                                    <td>Pag-IBIG</td>
                                    <td class="righttalign"><?php echo number_format($payslip_data[0]['PAGIBIGEE'], 2); ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if ($payslip_data[0]['WTax']) : ?>
                                <tr class="trdata">
                                    <td>W/Tax</td>
                                    <td class="righttalign"><?php echo number_format($payslip_data[0]['WTax'], 2); ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php //if ($payslip_deduct) : ?>
                                    <?php //foreach($payslip_deduct as $k => $v) : ?>
                                    <!--tr class="trdata">
                                        <td><?php echo $v['OExtDesc']; ?></td>
                                        <td class="righttalign"><?php echo number_format($v['Amount'], 2); ?></td>
                                    </tr-->
                                    <?php //endforeach; ?>
                                <?php //endif; ?>
                                <?php
                                    if($payslip_cover != 'SP21' && $payslip_cover != 'SP08')
                                    foreach ($payslip_odmaster as $key => $value) :
                                        foreach ($value as $k => $v) :
                                            if ($v) :
                                                echo '<tr class="trdata"><td>';
                                                if ($k == 'OD01') : echo $payslip_oddesc[0]["OExtDesc"];
                                                elseif ($k == 'OD02') : echo $payslip_oddesc[1]["OExtDesc"];
                                                elseif ($k == 'OD03') : echo $payslip_oddesc[2]["OExtDesc"];
                                                elseif ($k == 'OD04') : echo $payslip_oddesc[3]["OExtDesc"];
                                                elseif ($k == 'OD05') : echo $payslip_oddesc[4]["OExtDesc"];
                                                elseif ($k == 'OD06') : echo $payslip_oddesc[5]["OExtDesc"];
                                                elseif ($k == 'OD07') : echo $payslip_oddesc[6]["OExtDesc"];
                                                elseif ($k == 'OD08') : echo $payslip_oddesc[7]["OExtDesc"];
                                                elseif ($k == 'OD09') : echo $payslip_oddesc[8]["OExtDesc"];
                                                elseif ($k == 'OD10') : echo $payslip_oddesc[9]["OExtDesc"];
                                                elseif ($k == 'OD11') : echo $payslip_oddesc[10]["OExtDesc"];
                                                elseif ($k == 'OD12') : echo $payslip_oddesc[11]["OExtDesc"];
                                                elseif ($k == 'OD13') : echo $payslip_oddesc[12]["OExtDesc"];
                                                elseif ($k == 'OD14') : echo $payslip_oddesc[13]["OExtDesc"];
                                                elseif ($k == 'OD15') : echo $payslip_oddesc[14]["OExtDesc"];
                                                elseif ($k == 'OD16') : echo $payslip_oddesc[15]["OExtDesc"];
                                                elseif ($k == 'OD17') : echo $payslip_oddesc[16]["OExtDesc"];
                                                elseif ($k == 'OD18') : echo $payslip_oddesc[17]["OExtDesc"];
                                                elseif ($k == 'OD19') : echo $payslip_oddesc[18]["OExtDesc"];
                                                elseif ($k == 'OD20') : echo $payslip_oddesc[19]["OExtDesc"];
                                                elseif ($k == 'OD21') : echo $payslip_oddesc[20]["OExtDesc"];
                                                elseif ($k == 'OD22') : echo $payslip_oddesc[21]["OExtDesc"];
                                                elseif ($k == 'OD23') : echo $payslip_oddesc[22]["OExtDesc"];
                                                elseif ($k == 'OD24') : echo $payslip_oddesc[23]["OExtDesc"];
                                                elseif ($k == 'OD25') : echo $payslip_oddesc[24]["OExtDesc"];
                                                elseif ($k == 'OD26') : echo $payslip_oddesc[25]["OExtDesc"];
                                                elseif ($k == 'OD27') : echo $payslip_oddesc[26]["OExtDesc"];
                                                elseif ($k == 'OD28') : echo $payslip_oddesc[27]["OExtDesc"];
                                                elseif ($k == 'OD29') : echo $payslip_oddesc[28]["OExtDesc"];
                                                elseif ($k == 'OD30') : echo $payslip_oddesc[29]["OExtDesc"];
                                                elseif ($k == 'OD31') : echo $payslip_oddesc[30]["OExtDesc"];
                                                elseif ($k == 'OD32') : echo $payslip_oddesc[31]["OExtDesc"];
                                                elseif ($k == 'OD33') : echo $payslip_oddesc[32]["OExtDesc"];
                                                elseif ($k == 'OD34') : echo $payslip_oddesc[33]["OExtDesc"];
                                                elseif ($k == 'OD35') : echo $payslip_oddesc[34]["OExtDesc"];
                                                elseif ($k == 'OD36') : echo $payslip_oddesc[35]["OExtDesc"];
                                                elseif ($k == 'OD37') : echo $payslip_oddesc[36]["OExtDesc"];
                                                elseif ($k == 'OD38') : echo $payslip_oddesc[37]["OExtDesc"];
                                                elseif ($k == 'OD39') : echo $payslip_oddesc[38]["OExtDesc"];
                                                elseif ($k == 'OD40') : echo $payslip_oddesc[39]["OExtDesc"];
                                                elseif ($k == 'OD41') : echo $payslip_oddesc[40]["OExtDesc"];
                                                elseif ($k == 'OD42') : echo $payslip_oddesc[41]["OExtDesc"];
                                                elseif ($k == 'OD43') : echo $payslip_oddesc[42]["OExtDesc"];
                                                elseif ($k == 'OD44') : echo $payslip_oddesc[43]["OExtDesc"];
                                                elseif ($k == 'OD45') : echo $payslip_oddesc[44]["OExtDesc"];
                                                elseif ($k == 'OD46') : echo $payslip_oddesc[45]["OExtDesc"];
                                                elseif ($k == 'OD47') : echo $payslip_oddesc[46]["OExtDesc"];
                                                elseif ($k == 'OD48') : echo $payslip_oddesc[47]["OExtDesc"];
                                                elseif ($k == 'OD49') : echo $payslip_oddesc[48]["OExtDesc"];
                                                elseif ($k == 'OD50') : echo $payslip_oddesc[49]["OExtDesc"];
                                                elseif ($k == 'OD51') : echo $payslip_oddesc[50]["OExtDesc"];
                                                elseif ($k == 'OD52') : echo $payslip_oddesc[51]["OExtDesc"];
                                                elseif ($k == 'OD53') : echo $payslip_oddesc[52]["OExtDesc"];
                                                elseif ($k == 'OD54') : echo $payslip_oddesc[53]["OExtDesc"];
                                                elseif ($k == 'OD55') : echo $payslip_oddesc[54]["OExtDesc"];
                                                endif; 
                                                echo '</td>
                                                <!-- '.json_encode($payslip_oddesc).' 123 -->
                                                <td class="righttalign safd">';
                                                echo number_format($v, 2);
                                                echo '</td></tr>';
                                            endif;
                                        endforeach;
                                    endforeach;
                                ?>
                            </table>                                                            
                        </td>
                    </tr>

                    <?php 
                        $reg_pay = $payslip_data[0]['RegPay'] ? $payslip_data[0]['RegPay'] : 0;
                        $late_pay = $payslip_data[0]['LatePay'] ? $payslip_data[0]['LatePay'] : 0;
                        $ut_pay = $payslip_data[0]['UTPay'] ? $payslip_data[0]['UTPay'] : 0;
                        $ot_pay = $payslip_data[0]['TotalOTPay'] ? $payslip_data[0]['TotalOTPay'] : 0;
                        $allowance_pay = $payslip_data[0]['Allowance'] ? $payslip_data[0]['Allowance'] : 0;
                        $sss_pay = $payslip_data[0]['SSSEE'] ? $payslip_data[0]['SSSEE'] : 0;
                        $phealth_pay = $payslip_data[0]['PhilHEE'] ? $payslip_data[0]['PhilHEE'] : 0;
                        $pagibig_pay = $payslip_data[0]['PAGIBIGEE'] ? $payslip_data[0]['PAGIBIGEE'] : 0;
                        $wtax_pay = $payslip_data[0]['WTax'] ? $payslip_data[0]['WTax'] : 0; 
                        $total_main = $payslip_data[0]['TaxableIncome'];

                        if ($payslip_cover != 'SP21' && $payslip_cover != 'SP08') 
                        $total_taxtable = $payslip_data[0]['GrossPay'];
                        else
                            $total_taxtable = $payslip_data[0]['TaxableOtherEarn'];

                        //- $payslip_data[0]['OtherEarn'];
                        //$non_tax = $payslip_data[0]['OtherEarn'] - $payslip_data[0]['TaxableOtherEarn'] + $payslip_data[0]['Allowance'];
                        //$non_tax = $payslip_data[0]['OtherEarn'] + $payslip_data[0]['Allowance'];
                        $non_tax = $payslip_data[0]['Allowance'] + $payslip_data[0]['OtherEarn'];

                        $total_earn = $total_taxtable + $non_tax;

                        //$reg_pay + $ot_pay - ($late_pay + $ut_pay);
                        //$total_ntax = $allowance_pay;
                        //$total_earn = $total_main + $total_ntax;
                        $total_deduct = $payslip_data[0]['TotalDeduction'];
                        $net_pay = $payslip_data[0]['NetPay'];
                    ?>
                    <tr>
                        <td width="34%" class="valigntop">
                            <table border="0" cellspacing="0" class="tdata width100per">
                                <tr>
                                    <td class="noborder" width="77%">TOTAL</td>
                                    <td class="noborder" width="33%" class="righttalign"><?php echo number_format($total_taxtable, 2); ?></td>
                                </tr>
                                <tr>
                                    <td class="noborder">TOTAL EARNINGS</td>
                                    <td class="noborder righttalign"><?php echo number_format($total_earn, 2); ?></td>
                                </tr>
                            </table>                                        
                        </td>
                        <td width="33%" class="valigntop">
                            <table border="0" cellspacing="0" class="tdata width100per">
                                <tr>
                                    <td class="noborder" width="65%">TOTAL</td>
                                    <td width="35%" class="noborder righttalign"><?php echo number_format($non_tax, 2); ?></td>
                                </tr>
                            </table> 
                        </td>
                        <td width="33%" class="valigntop">
                            <table border="0" cellspacing="0" class="tdata width100per">
                                <tr>
                                    <td class="noborder" width="77%">TOTAL</td>
                                    <td class="noborder" width="33%" class="righttalign">(<?php echo number_format($total_deduct, 2); ?>)</td>
                                </tr>
                                <tr>
                                    <td class="noborder">NET PAY</td>
                                    <td class="noborder righttalign"><?php echo number_format($net_pay, 2); ?></td>
                                </tr>
                            </table>                         
                        </td>
                    </tr>
                    <?php if ($payslip_cover != 'SP21' && $payslip_cover != 'SP08') : ?>
                    <tr>
                        <td width="34%" class="valigntop noborder">
                            <!--table border="0" cellspacing="0" class="tdata width100per">
                                <tr>
                                    <td class="noborder" width="60%">YEAR TO DATE</td>
                                    <td class="noborder righttalign" width="40%">01/01/2015 to 05/31/2015</td>
                                </tr>
                                <tr>
                                    <td class="noborder">NET TAXABLE EARNING</td>
                                    <td class="noborder righttalign"><?php echo number_format($payslip_data[0]['WTax'], 2); ?></td>
                                </tr>
                                <tr>
                                    <td class="noborder">W/ TAX</td>
                                    <td class="noborder righttalign"><?php echo number_format($payslip_data[0]['WTax'], 2); ?></td>
                                </tr>
                                <tr>
                                    <td class="noborder">SSS</td>
                                    <td class="noborder righttalign"><?php echo number_format($payslip_data[0]['WTax'], 2); ?></td>
                                </tr>
                                <tr>
                                    <td class="noborder">PHIL-HEALTH</td>
                                    <td class="noborder righttalign"><?php echo number_format($payslip_data[0]['WTax'], 2); ?></td>
                                </tr>
                                <tr>
                                    <td class="noborder">PAG-IBIG</td>
                                    <td class="noborder righttalign"><?php echo number_format($payslip_data[0]['WTax'], 2); ?></td>
                                </tr>
                            </table--> 
                        </td>
                        
                        <td width="33%" class="valigntop noborder">
                            <?php if ($payslip_loans) : ?>
                            <table border="0" cellspacing="0" class="tdata width100per">
                                <tr>
                                    <th height="30" width="65%">LOAN BREAKDOWN BALANCE</th>
                                    <th height="30" width="35%">AMOUNT</th>
                                </tr>
                                <?php foreach($payslip_loans as $key => $value) : ?>
                                    <tr class="trdata">
                                        <td><?php echo $value['OExtDesc']; ?></td>
                                        <td class="righttalign"><?php echo number_format($value['Balance'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>        
                            <?php endif; ?>
                        </td>
                        <td width="33%" class="valigntop noborder">
                            <?php if ($leave_data) : ?>
                            <table border="0" cellspacing="0" class="tdata width100per">
                                <tr>
                                    <th height="30" colspan="2">LEAVE BALANCE</th>
                                </tr>
                                <?php foreach ($leave_data as $key => $value) : ?>
                                    <?php $leave_bal = $mainsql->get_leavebal_byid($profile_idnum, $value['LeaveID']); ?>
                                    <?php if ($value['LeaveID'] == 'L01' || $value['LeaveID'] == 'L03') : ?>
                                    <tr class="trdata">
                                        <td width="65%"><?php echo $value['LeaveDesc']; ?></td>
                                        <?php if ($profile_compressed) : ?>
                                        <td width="35%" class="righttalign"><?php echo $leave_bal[0]['BalanceHrs'] ? number_format($leave_bal[0]['BalanceHrs'], 2) : '0.00' ; ?> hours</td>
                                        <?php else : ?>
                                        <td width="35%" class="righttalign"><?php echo $leave_bal[0]['BalanceDays'] ? number_format($leave_bal[0]['BalanceDays'], 2) : '0.00' ; ?> days</td>
                                        <?php endif; ?>
                                    </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>    
                            </table>        
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <?php else : ?>

                    <tr>
                        <td class="bold centertalign noborder"><br><br>No payslip record found on this period</td>
                    </tr>                                    

                    <?php endif; ?>
                
                <?php else : ?>
                
                    <?php if($payslip_sldata) : ?>
                
                    <?php $totalsl = 0; $totalal = 0; $totalde = 0; $gross = 0; ?>
                
                    <tr>
                        <td width="34%" class="noborder valigntop">
                            <table border="0" cellspacing="0" class="tdata width100per">
                                <tr >
                                    <th height="30" width="34%">TAX EARNINGS </th>
                                    <th height="30" width="33%">UNIT</th>
                                    <th height="30" width="33%">AMOUNT</th>
                                </tr>
                                <?php foreach ($payslip_sldata as $key => $value) : ?>
                                    <?php if ($value['OExtID'] == 'OE07') : ?>
                                    <tr class="trdata">
                                        <td><?php echo $value['OExtDesc2']; ?></td>
                                        <td class="centertalign"><?php echo $value['BALANCEDAYS'] ? $value['BALANCEDAYS'].' day/s' : ''; ?></td>
                                        <td class="righttalign"><?php $totalsl = $totalsl + $value['Amount']; $gross = $gross + $value['Amount']; echo number_format($value['Amount'], 2); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                
                            </table>                                        
                        </td>
                        <td width="33%" class="noborder valigntop">
                            <table border="0" cellspacing="0" class="tdata width100per">
                                <tr>
                                    <th height="30" width="34%">NON-TAX EARNINGS</th>
                                    <th height="30" width="33%">UNIT</th>
                                    <th height="30" width="35%">AMOUNT</th>
                                </tr>
                                <?php foreach ($payslip_sldata as $key => $value) : ?>
                                    <?php //var_dump($totalal); ?>
                                    <?php if ($value['OExtID'] != 'OE07') : ?>
                                    <tr class="trdata">
                                        <td><?php echo $value['OExtDesc2']; ?></td>
                                        <td class="centertalign"><?php echo $value['BALANCEDAYS'] ? $value['BALANCEDAYS'].' day/s' : ''; ?></td>
                                        <td class="righttalign"><?php $totalal = $totalal + $value['Amount']; $gross = $gross + $value['Amount']; echo number_format($value['Amount'], 2); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </table>                                                             
                        </td>
                        <td width="33%" class="valigntop noborder">
                            <table border="0" cellspacing="0" class="tdata width100per">
                                <tr>
                                    <th height="30" width="65%">DEDUCTIONS</th>
                                    <th height="30" width="35%">AMOUNT</th>
                                </tr>
                                <?php foreach ($payslip_sldata as $key => $value) : ?>
                                    <?php if ($value['OExtID'] == 'OE07') : ?>
                                    <tr class="trdata">
                                        <td>Withholding Tax</td>
                                        <td class="righttalign"><?php $totalde = $totalde + $value['WTax']; echo number_format($value['WTax'], 2); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </table>                                                            
                        </td>
                    </tr>
                
                    <?php 
                        $totalearn = $totalsl + $totalal; 
                        $grandtotal = $gross - $totalde; 
                    ?>
                
                    <tr>
                        <td width="34%" class="valigntop">
                            <table border="0" cellspacing="0" class="tdata width100per">
                                <tr>
                                    <td class="noborder" width="77%">TOTAL</td>
                                    <td class="noborder righttalign" width="33%"><?php echo number_format($totalsl, 2); ?></td>
                                </tr>
                                <tr>
                                    <td class="noborder">TOTAL EARNINGS </td>
                                    <td class="noborder righttalign"><?php echo number_format($totalearn, 2); ?></td>
                                </tr>
                            </table>                                        
                        </td>
                        <td width="33%" class="valigntop">
                            <table border="0" cellspacing="0" class="tdata width100per">
                                <tr>
                                    <td class="noborder" width="65%">TOTAL</td>
                                    <td width="35%" class="noborder righttalign"><?php echo number_format($totalal, 2); ?></td>
                                </tr>
                            </table> 
                        </td>
                        <td width="33%" class="valigntop">
                            <table border="0" cellspacing="0" class="tdata width100per">
                                <tr>
                                    <td class="noborder" width="77%">TOTAL</td>
                                    <td class="noborder righttalign" width="33%">(<?php echo number_format($totalde, 2); ?>)</td>
                                </tr>
                                <tr>
                                    <td class="noborder">NET PAY</td>
                                    <td class="noborder righttalign"><?php echo number_format($grandtotal, 2); ?></td>
                                </tr>
                            </table>                         
                        </td>
                    </tr>
                    <tr>
                        <td width="34%" class="valigntop noborder">&nbsp;</td>
                        <td width="33%" class="valigntop noborder">&nbsp;</td>
                        <td width="33%" class="valigntop noborder">&nbsp;</td>
                    </tr>
                
                    <?php else : ?>

                    <tr>
                        <td class="bold centertalign noborder"><br><br>No payslip record found on this period</td>
                    </tr>                                    

                    <?php endif; ?>                          

                <?php endif; ?>

            </table>

            <?php
        break;
        default:
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";   
        
    }            
	
?>			