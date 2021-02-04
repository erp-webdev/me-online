	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->

                    <div id="mainsplashtext" class="mainsplashtext lefttalign">
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainnotification" class="mainbody lefttalign whitetext">
                                <b class="mediumtext lorangetext">PAYSLIP</b><br><br>

                                <table>

                                    <tr>
                                        <td>
                                            <!--input type="button" value="PRINT" class="btn" /-->
                                        </td>
                                        <td>Year Period:
                                            <select id="payslip_year" name="payslip_year" class="width95 smltxtbox">
                                                <?php foreach ($dtr_year as $key => $value) : ?>
                                                <option value="<?php echo $value['PRYear']; ?>"<?php echo $value['PRYear'] == date("Y") ? ' selected' : ''; ?>><?php echo $value['PRYear']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>Pay Period:
                                            <select id="payslip_cover" name="payslip_cover" class="width250 smltxtbox">
                                                <?php if ($payslip_period) : ?>
                                                <?php foreach ($payslip_period as $key => $value) : ?>

                                                <?php if ($value['PeriodID'] != 'SP23' && ($profile_idnum != '2019-12-0708') ) : ?>
                                                <option value="<?php echo $value['PeriodID']; ?>"<?php echo $key == 1 ? ' selected' : ''; ?>>
                                                    <?php
                                                        // new payslip period beginning april2020
                                                        if($value['PRYear'] > 2020 || ($value['PRYear'] == 2020 && !in_array( $value['PeriodID'], ['S01', 'S02', 'S03', 'S04', 'S05', 'S06', 'S07', 'S08', 'S09'])))
                                                            echo $value['PaymentType']." ".$value['PRYear']." ".date("m/d/Y", strtotime($value['PRFrom']))." to ".date("m/d/Y", strtotime($value['PRTo']));
                                                        else
                                                            echo $value['PaymentType']." ".$value['PRYear']." ".date("m/d/Y", strtotime($value['PeriodFrom']))." to ".date("m/d/Y", strtotime($value['PeriodTo']));
                                                    ?>
                                                    <?php //echo $value['PaymentType']." ".$value['PRYear']." ".date("m/d/Y", strtotime($value['PeriodFrom']))." to ".date("m/d/Y", strtotime($value['PeriodTo'])); ?>
                                                </option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>

                                                <option value="SP04">
                                                    SL CONVERSION <?php echo date("Y"); ?>
                                                </option>
                                                <!--13 MONTH - START -->

                                                <option value="SP08">
                                                    13TH MONTH 1/2 <?php echo date("Y"); ?>
                                                </option>
                                                <option value="SP21">
                                                    13TH MONTH <?php echo date("Y"); ?>
                                                </option>

                                                <!--13 MONTH - END -->
                                                <?php if ($profile_idnum == '2016-06-0457') : ?>
                                                <option value="SP23">
                                                    YEAREND BONUS <?php echo date("Y"); ?>
                                                </option>
                                                <?php endif; ?>

                                                <?php endif; ?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>

                                <div class="column3 margintop25">
                                    <b><?php echo ucfirst($profile_nadd); ?> ID: </b><?php echo $profile_idnum; ?><br>
                                    <b>Name: </b><?php echo $profile_full; ?><br>
                                    <b>Department: </b><?php echo ucwords(strtolower($profile_dept)); ?><br>
                                    <b>Tax Exemption: </b><?php echo $profile_taxdesc; ?><br>
                                    <b>SSS #: </b><?php echo $profile_sss; ?><br>
                                    <b>TIN #: </b><?php echo $profile_tin; ?><br>
                                    <b>Cut-off Date: </b><span id='payperiod'>
                                        <?php
                                            // new pay period beginning apr2020
                                            if($payslip_period[1]['PRYear'] > 2020 || ($payslip_period[1]['PRYear'] == 2020 && !in_array( $payslip_period[1]['PeriodID'], ['S01', 'S02', 'S03', 'S04', 'S05', 'S06', 'S07', 'S08', 'S09'])))
                                                echo date("m/d/Y", strtotime($payslip_period[1]['PRFrom'] ? $payslip_period[1]['PRFrom'] : $payslip_period[0]['PRFrom'])) . " to " . date("m/d/Y", strtotime($payslip_period[1]['PRTo'] ? $payslip_period[1]['PRTo'] : $payslip_period[0]['PRTo']));
                                            else
                                                echo date("m/d/Y", strtotime($payslip_period[1]['PeriodFrom'] ? $payslip_period[1]['PeriodFrom'] : $payslip_period[0]['PeriodFrom'])). " to " . date("m/d/Y", strtotime($payslip_period[1]['PeriodTo'] ? $payslip_period[1]['PeriodTo'] : $payslip_period[0]['PeriodTo']));
                                            ?></span><br>
                                    <b>Pay Period: </b><span id='payto'>
                                        <?php
                                            // new pay period beginning apr2020
                                            if($payslip_period[1]['PRYear'] > 2020 || ($payslip_period[1]['PRYear'] == 2020 && !in_array( $payslip_period[1]['PeriodID'], ['S01', 'S02', 'S03', 'S04', 'S05', 'S06', 'S07', 'S08', 'S09'])))
                                                echo date("m/d/Y", strtotime($payslip_period[1]['PRTo'] ? $payslip_period[1]['PRTo'] : $payslip_period[0]['PRTo']));
                                            else
                                                echo date("m/d/Y", strtotime($payslip_period[1]['PRTo'] ? $payslip_period[1]['PRTo'] : $payslip_period[0]['PRTo']));

                                            ?></span><br>
                                    <b>Account #: </b><?php echo $profile_acctnum; ?><br>
                                </div>

                                <div id="payslipdata" class="innerdata">
                                <table border="0" cellspacing="0" class="tdata margintop25 tinytext width100per">

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
                                                    <td class="centertalign"><!--?php echo number_format($payslip_data[0]['RegHrs'] / 8, 1); ?> days--></td>
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
                                                <tr class="trdata">
                                                    <td>ABSENT</td>
                                                    <td class="centertalign"><?php echo number_format($absent_num / 8, 1); ?> days</td>
                                                    <td class="righttalign">(<?php echo number_format($absent_pay, 2); ?>)</td>
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
                                                ?>
                                                <?php //if ($payslip_earn) : ?>
                                                    <?php //foreach($payslip_earn as $k => $v) : ?>
                                                    <!--tr class="trdata">
                                                        <td colspan="2"><?php echo $v['OExtDesc']; ?></td>
                                                        <td class="righttalign"><?php echo number_format($v['Amount'], 2); ?></td>
                                                    </tr-->
                                                    <?php //endforeach; ?>
                                                <?php //endif; ?>

                                                <?php
                                                    $otherallowance = 0;
                                                    $minusallowance = 0;
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
                                                ?>


                                            </table>
                                        </td>
                                        <td width="33%" class="noborder valigntop">
                                            <table border="0" cellspacing="0" class="tdata width100per">
                                                <tr>
                                                    <th height="30" width="65%">NON-TAX EARNINGS</th>
                                                    <th height="30" width="35%">AMOUNT</th>
                                                </tr>
                                                <?php //if ($payslip_earn2) : ?>
                                                    <?php //foreach($payslip_earn2 as $k => $v) : ?>
                                                    <!--tr class="trdata">
                                                        <td><?php echo $v['OExtDesc']; ?></td>
                                                        <td class="righttalign"><?php echo number_format($v['Amount'], 2); ?></td>
                                                    </tr-->
                                                    <?php //endforeach; ?>
                                                <?php //endif; ?>

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

                                                <?php if ($payslip_data[0]['Allowance'] - $minusallowance) : ?>
                                                <tr class="trdata">
                                                    <td>ALLOWANCE</td>
                                                    <td class="righttalign"><?php echo number_format(($payslip_data[0]['Allowance'] - $minusallowance), 2); ?></td>
                                                </tr>
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
                                                                elseif ($k == 'OE05') :
                                                                    echo '<td>';
                                                                    echo $payslip_oedesc[4]["OExtDesc"];
                                                                    echo '</td><td class="righttalign">';
                                                                    echo number_format($v, 2);
                                                                    echo '</td>';
                                                                    $otherallowance += $v;
                                                                elseif ($k == 'OE06') :
                                                                    echo '<td>';
                                                                    echo $payslip_oedesc[5]["OExtDesc"];
                                                                    echo '</td><td class="righttalign">';
                                                                    echo number_format($v, 2);
                                                                    echo '</td>';
                                                                    $otherallowance += $v;
                                                                elseif ($k == 'OE07') :
                                                                    echo '<td>';
                                                                    echo $payslip_oedesc[6]["OExtDesc"];
                                                                    echo '</td><td class="righttalign">';
                                                                    echo number_format($v, 2);
                                                                    echo '</td>';
                                                                    $otherallowance += $v;
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
                                                ?>
                                            </table>
                                        </td>
                                        <!-- kevs <?php var_dump($payslip_oedesc); ?> -->
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
												<?php if($payslip_data[0]['PRYear'] >= 2021) : ?>
												<tr class="trdata">
                                                    <td>Provident Fund</td>
                                                    <td class="righttalign"><?php echo number_format($payslip_data[0]['SSSEEP'], 2); ?></td>
                                                </tr>
												<?php endif; ?>
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
                                                                echo '</td><td class="righttalign">';
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

										$provident_pay = $payslip_data[0]['SSSEEP'] ? $payslip_data[0]['SSSEEP'] : 0;

                                        $total_taxable = $payslip_data[0]['GrossPay'];
                                        //$non_tax = $payslip_data[0]['OtherEarn'] - $payslip_data[0]['TaxableOtherEarn'] + $payslip_data[0]['Allowance'];
                                        //$non_tax = $payslip_data[0]['OtherEarn'] + $payslip_data[0]['Allowance'];
                                        $non_tax = $payslip_data[0]['Allowance'] + $payslip_data[0]['OtherEarn'];

                                        $total_earn = $total_taxable + $non_tax;

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
                                                    <td class="noborder" width="33%" class="righttalign"><?php echo number_format($total_taxable, 2); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="noborder">TOTAL EARNINGS </td>
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
                                        <!--td width="33%" class="valigntop noborder">
                                            <?php if ($payslip_data[0]['PTDLoanBal01'] || $payslip_data[0]['PTDLoanBal02'] || $payslip_data[0]['PTDLoanBal03'] || $payslip_data[0]['PTDLoanBal04'] || $payslip_data[0]['PTDLoanBal05'] || $payslip_data[0]['PTDLoanBal06'] || $payslip_data[0]['PTDLoanBal07'] || $payslip_data[0]['PTDLoanBal08'] || $payslip_data[0]['PTDLoanBal09'] || $payslip_data[0]['PTDLoanBal10'] || $payslip_data[0]['PTDLoanBal11'] || $payslip_data[0]['PTDLoanBal12'] || $payslip_data[0]['PTDLoanBal13'] || $payslip_data[0]['PTDLoanBal14'] || $payslip_data[0]['PTDLoanBal15'] || $payslip_data[0]['PTDLoanBal16'] || $payslip_data[0]['PTDLoanBal17'] || $payslip_data[0]['PTDLoanBal18'] || $payslip_data[0]['PTDLoanBal19'] || $payslip_data[0]['PTDLoanBal20'] || $payslip_data[0]['PTDLoanBal21'] || $payslip_data[0]['PTDLoanBal22'] || $payslip_data[0]['PTDLoanBal23'] || $payslip_data[0]['PTDLoanBal24'] || $payslip_data[0]['PTDLoanBal25']) : ?>
                                            <table border="0" cellspacing="0" class="tdata width100per">
                                                <tr>
                                                    <th height="30" width="65%">LOAN BREAKDOWN BALANCE</th>
                                                    <th height="30" width="35%">AMOUNT</th>
                                                </tr>
                                                <?php $loancnt = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25'); ?>
                                                <?php foreach($loancnt as $lc) : ?>
                                                    <?php if ($payslip_data[0]['PTDLoanBal'.$lc]) : ?>
                                                    <?php $ext_data = $mainsql->get_payslip_ext("OD".$lc); ?>
                                                    <tr class="trdata">
                                                        <td><?php echo $ext_data[0]['OExtDesc']; ?></td>
                                                        <td class="righttalign"><?php echo number_format($payslip_data[0]['PTDLoanBal'.$lc], 2); ?></td>
                                                    </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </table>
                                            <?php endif; ?>
                                        </td-->
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

                                    <?php else : ?>

                                    <tr>
                                        <td class="bold centertalign noborder"><br><br>No payslip record found on this period</td>
                                    </tr>

                                    <?php endif; ?>

                                </table>
                                </div>

                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>
