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

    <script type="text/javascript">
    </script>

    <?php

    switch ($sec) {
        case 'data':

            $type = $_POST['type'];
            $leavetype = $mainsql->get_leave($type);

            $leave_data = $mainsql->get_leavebytype($profile_idnum, $type, date('Y'));
            $leave_balance = $mainsql->get_leavebal($profile_idnum, $leavetype[0]['LeaveID']);

            //var_dump($leave_data);

                ?>

                <table class="tdataform2 rightmargin margintop10 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td><b>Earned Balance</b></td>
                        <?php if ($profile_compressed) : ?>
                        <td class="righttalign"><?php echo $leave_balance[0]['EarnedHrs']; ?> hours</td>
                        <?php else : ?>
                        <td class="righttalign"><?php echo $leave_balance[0]['EarnedDays']; ?> days</td>
                        <?php endif; ?>
                    </tr>

                    <tr>
                        <td colspan="2" class="centertalign">
                        <?php if ($leave_data) : ?>
                        <div class="divdtrdata topbotborder width100per">

                            <table class="tdatablk margintopbot20">
                                <tr>
                                    <th width="25%">Reference #</th>
                                    <th width="25%">Date Applied</th>
                                    <th width="35%">Coverage</th>
                                    <th width="15%">Credits</th>
                                </tr>
                                <?php
                                    foreach ($leave_data as $key => $value)  :
                                    ?>
                                    <tr>
                                        <td><?php echo $value['LeaveRef']; ?></td>
                                        <td><?php echo date('F j, Y g:ia', strtotime($value['DateFiled'])); ?></td>
                                        <td><?php echo date('m/d/Y', strtotime($value['AbsenceFromDate'])).' - '.date('m/d/Y', strtotime($value['AbsenceToDate'])); ?></td>
                                        <?php if ($profile_compressed) : ?>
                                        <td class="centertalign"><?php echo number_format($value['Hours'], 2); ?></td>
                                        <?php else : ?>
                                        <td class="centertalign"><?php echo number_format($value['Days'], 2); ?></td>
                                        <?php endif; ?>
                                    </tr>
                                    <?php
                                    endforeach;
                                ?>

                            </table>

                        </div>
                        <?php else : ?>
                        <div class="topbotborder width100per">
                        <br><br><br>No <?php echo strtolower($type); ?> has been filed.<br><br><br><br>
                        </div>
                        <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Remaining Balance</b></td>
                        <?php if ($profile_compressed) : ?>
                        <td class="righttalign"><?php echo $leave_balance[0]['BalanceHrs']; ?> hours</td>
                        <?php else : ?>
                        <td class="righttalign"><?php echo $leave_balance[0]['BalanceDays']; ?> days</td>
                        <?php endif; ?>
                    </tr>
            </table>

            <?php

            //var_dump($approver_data1);

        break;

        case 'ledger':

            $type = $_POST['type'];
            $type2 = $_POST['type2'];

            $leave_data = $mainsql->get_leaveledgerbytype($profile_idnum, $type2, date('Y'));
            $leave_balance = $mainsql->get_leavebal($profile_idnum, $type2);
						$usable_balance = $mainsql->get_usablebal($profile_idnum, $type2);

            //var_dump($leave_data);

                ?>

                <table class="tdataform2 rightmargin margintop10 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td><b>Earned</b></td>
                        <td class="righttalign">
                            <?php if ($profile_compressed) : ?>
                            <?php echo $leave_balance[0]['EarnedHrs'] ? number_format($leave_balance[0]['EarnedHrs'], 2) : 0; ?> hours (<?php echo $leave_balance[0]['EarnedDays'] ? number_format($leave_balance[0]['EarnedDays'], 3) : 0; ?> days)
                            <?php else : ?>
                            <?php echo $leave_balance[0]['EarnedDays'] ? number_format($leave_balance[0]['EarnedDays'], 3) : 0; ?> days
                            <?php endif; ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" class="centertalign">
                        <?php if ($leave_data) : ?>
                        <div class="divdtrdata topbotborder width100per">

                            <table class="tdatablk width100per margintopbot20">
                                <tr>
                                    <th width="25%">Date</th>
                                    <th width="20%">Earned</th>
                                    <th width="20%">Used</th>
                                    <th width="45%">Remarks</th>
                                </tr>
                                <?php
                                    foreach ($leave_data as $key => $value)  :
                                    ?>
                                    <tr>
                                        <td><?php echo date('F j, Y', strtotime($value['Date'])); ?></td>
                                        <?php if ($profile_compressed) : ?>
                                        <td class="centertalign"><?php echo $value['EarnedHrs'] ? number_format($value['EarnedHrs'], 2) : ''; ?></td>
                                        <td class="centertalign"><?php echo $value['UsedHrs'] ? number_format($value['UsedHrs'], 2) : ''; ?></td>
                                        <td class="centertalign"><?php echo $value['Remark']; ?></td>
                                        <?php else : ?>
                                        <td class="centertalign"><?php echo $value['EarnedDays'] ? number_format($value['EarnedDays'], 2) : ''; ?></td>
                                        <td class="centertalign"><?php echo $value['UsedDays'] ? number_format($value['UsedDays'], 2) : ''; ?></td>
                                        <td class="centertalign"><?php echo $value['Remark']; ?></td>
                                        <?php endif; ?>
                                    </tr>
                                    <?php
                                    endforeach;
                                ?>

                            </table>

                        </div>
                        <?php else : ?>
                        <div class="topbotborder width100per">
                        <br><br><br>No <?php echo strtolower($type); ?> has been found on this ledger.<br><br><br><br>
                        </div>
                        <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Remaining Balance</b></td>
                        <?php if ($profile_compressed) : ?>
                        <td class="righttalign"><b><?php echo $leave_balance[0]['BalanceHrs'] ? number_format($leave_balance[0]['BalanceHrs'], 2) : 0; ?> hours (<?php echo $leave_balance[0]['BalanceDays'] ? number_format($leave_balance[0]['BalanceDays'], 2) : 0; ?> days)</b></td>
                        <?php else : ?>
                        <td class="righttalign"><b><?php echo $leave_balance[0]['BalanceDays'] ? number_format($leave_balance[0]['BalanceDays'], 2) : 0; ?> days</b></td>
                        <?php endif; ?>
                    </tr>
										<tr>
											<td>Pending For Approval</td>
											<?php if ($profile_compressed) : ?>
											<td class="righttalign"><?php echo $usable_balance[0]['BalanceHrs'] ? number_format($leave_balance[0]['BalanceHrs'], 2) - number_format($usable_balance[0]['BalanceHrs'], 2) : 0; ?> hours (<?php echo $usable_balance[0]['BalanceHrs'] ? number_format($leave_balance[0]['BalanceDays'], 2) - number_format($usable_balance[0]['BalanceHrs']/8, 2)  : 0; ?> days)</td>
											<?php else : ?>
											<td class="righttalign"><?php echo $usable_balance[0]['BalanceHrs'] ? number_format($leave_balance[0]['BalanceDays'], 2) - number_format($usable_balance[0]['BalanceHrs'], 2)/8 : 0; ?> days</td>
											<?php endif; ?>
										</tr>
										<tr>
											<td>Usable Balance</td>
											<?php if ($profile_compressed) : ?>
											<td class="righttalign"><?php echo $usable_balance[0]['BalanceHrs'] ? number_format($usable_balance[0]['BalanceHrs'], 2) : 0; ?> hours (<?php echo $usable_balance[0]['BalanceHrs'] ? number_format($usable_balance[0]['BalanceHrs']/8, 2)  : 0; ?> days)</td>
											<?php else : ?>
											<td class="righttalign"><?php echo $usable_balance[0]['BalanceHrs'] ? number_format($usable_balance[0]['BalanceHrs'], 2)/8 : 0; ?> days</td>
											<?php endif; ?>
										</tr>
            </table>

            <?php

            //var_dump($approver_data1);

        break;
        default:
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";

    }

?>
