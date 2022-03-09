	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
                    
                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainnotification" class="mainbody lefttalign whitetext">  
                                <b class="mediumtext lorangetext">DAILY TIME RECORD</b><br><br>
                                
                                <table>
                                    <tr>
                                        <td>Year: 
                                            <select id="dtr_year" name="dtr_year" class="smltxtbox">
                                                <?php $yearend = strtotime(date('Y').'-12-15'); ?>
                                                <?php $yearval = date('U') > $yearend ? date("Y") + 1 : date("Y"); ?>
                                                <?php foreach ($dtr_year as $key => $value) : ?>
                                                <option value="<?php echo $value['PRYear']; ?>"<?php echo $value['PRYear'] == $yearval ? ' selected' : ''; ?>><?php echo $value['PRYear']; ?></option>    
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>DTR Cut-off: 
                                            <select id="dtr_cover" name="dtr_cover" class="width250 smltxtbox">
                                                <?php foreach ($dtr_period as $key => $value) : ?>
                                                <option value="<?php echo date("Y-m-d", strtotime($value['PeriodFrom']))." ".date("Y-m-d", strtotime($value['PeriodTo'])); ?>" dfrom="<?php echo strtotime($value['PeriodFrom']); ?>" dto="<?php echo strtotime($value['PeriodTo']); ?>" posted="<?php echo $value['AttPost']; ?>">
                                                    <?php echo $value['PeriodID']." ".$value['PRYear']." ".date("m/d/Y", strtotime($value['PeriodFrom']))." to ".date("m/d/Y", strtotime($value['PeriodTo'])); ?>
                                                </option>  
                                                <?php endforeach; ?>
                                            </select>&nbsp;&nbsp;
                                            <?php $attpost = $dtr_period[0]['AttPost']; ?>
                                            <span id="txtposted" class="lgreentext bold<?php echo $attpost == 1 ? "" : " invisible"; ?>"><i class="fa fa-check"></i> POSTED</span>
                                            <a href id="btntopayslip"  href="<?php echo WEB; ?>/payslip"  class="<?php echo $attpost == 1 ? "" : " invisible"; ?>"></i> Payslip</a>
                                            
                                        </td>
                                    </tr>
                                </table>
                                
                                <div id="dtrdata" class="innerdata">
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

                                            
                                        </tr>
                                        <tr>                                        
                                            <th width="4%">In</th>
                                            <th width="4%">Out</th>  
                                        </tr>
                                        <?php 
                                            $total_workhrs = 0;
                                            $total_latehrs = 0;
                                            $total_uthrs = 0;
                                            $total_ndhrs = 0;
                                            $total_absent = 0;
                                            $total_leave = 0;
                                            $total_sh = 0;
                                    
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
                                            <td><?php echo $value['TimeOut'] ? date("h:ia", strtotime($timearray2[3])) : ''; ?></td>
                                            <td><?php echo $value['OB'] ? '<i class="fa fa-check greentext"></i>' : '<i class="fa fa-times redtext"></i>'; ?></td>
                                            <td><?php echo number_format($value['WorkHrs'], 2); ?></td>
                                            <td class="lredtext"><?php echo number_format($absent, 2); ?></td>
                                            <td class="lorangetext"><?php echo number_format($value['LateHrs'], 2); ?></td>
                                            <td class="lorangetext"><?php echo number_format($value['UTHrs'], 2); ?></td>
                                            <td class="lbluetext"><?php echo number_format($ndhours, 2); ?></td>
                                            <td><?php echo number_format($leavedays, 2); ?></td>
                                            <td><?php echo $value['LEAVE_DESC']; ?></td>
                                            <td><?php echo number_format($value['ML'],2); ?></td>
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
                                </div>
                                
                                <div class="margintop25">
                                    <span class="bold">Note: </span><span class="italic">All value are based on hours for example 2.35 hours is equal to 2 hours and 21 minutes where 60 minutes x 0.35 = 21 minutes.</span>
                                </div>
                                
                            </div>
                        </div>
                    </div>



    <?php include(TEMP."/footer.php"); ?>