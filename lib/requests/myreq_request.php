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

    <script type="text/javascript">

        $(".btnpenddata").on("click", function() {

            doctype = $(this).attr('attribute2');
            refnum = $(this).attr('attribute');
            dbname = $(this).attr('attribute5');

            if (doctype == 'LV') {
                title = "Leave Application #";
            }
            else if (doctype == 'NP') {
                title = "No Punch Authorization #";
            }
            else if (doctype == 'MA') {
                title = "Meal Allowance Application #";
            }
            else if (doctype == 'OB') {
                title = "OBT Application #";
            }
            else if (doctype == 'OT') {
                title = "Overtime Application #";
            }
            else if (doctype == 'MD') {
                title = "Manual DTR Application #";
            }
            else if (doctype == 'SC') {
                title = "Change of Time Schedule Application #";
            }
            else if (doctype == 'TS') {
                title = "Change Schedule Application #";
            }
			else if (doctype == 'WH') {
                title = "Work From Home Application #";
            }else if (doctype == 'WC') {
                title = "WFH Clearance Application #";
            }

            $("#pend_title").html(title + ' ' + refnum);
            $(".floatdiv").removeClass("invisible");
            $("#nview").show({
              effect : 'slide',
              easing : 'easeOutQuart',
              direction : 'up',
              duration : 500
            });

            $("#pend_data").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=datapend",
                data: "refnum=" + refnum + "&doctype=" + doctype + "&dbname=" + dbname,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $("#pend_data").html(data);
                }
            })
        });

    </script>

    <?php

    switch ($sec) {
        case 'table':

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NUM_ROWS * ($page - 1);

            if ($_POST['clear_search']) :

                unset($_SESSION['mreqstatus']);
                unset($_SESSION['mreqfrom']);
                unset($_SESSION['mreqto']);
                unset($_SESSION['mreqrefnum']);

            endif;

            $mreqtype_sess = $_SESSION['mreqtype'];
            $mreqstatus_sess = $_SESSION['mreqstatus'];
            $mreqfrom_sess = $_SESSION['mreqfrom'];
            $mreqto_sess = $_SESSION['mreqto'];
            $mreqrefnum_sess = $_SESSION['mreqrefnum'];
            if ($_POST) {
                $mreqtype = $_POST['mreqtype'] ? $_POST['mreqtype'] : 1;
                $_SESSION['mreqtype'] = $mreqtype;
                $mreqstatus = $_POST['mreqstatus'] ? $_POST['mreqstatus'] : 0;
                $_SESSION['mreqstatus'] = $mreqstatus;
                $mreqfrom = $_POST['mreqfrom'] ? $_POST['mreqfrom'] : NULL;
                $_SESSION['mreqfrom'] = $mreqfrom;
                $mreqto = $_POST['mreqto'] ? $_POST['mreqto'] : NULL;
                $_SESSION['mreqto'] = $mreqto;
                $mreqrefnum = $_POST['mreqrefnum'] ? $_POST['mreqrefnum'] : NULL;
                $_SESSION['mreqrefnum'] = $mreqrefnum;
            }
            elseif ($mreqtype_sess || $mreqstatus_sess || $mreqfrom_sess || $mreqto_sess || $mreqrefnum_sess) {
                $mreqtype = $mreqtype_sess ? $mreqtype_sess : 1;
                $_POST['mreqtype'] = $mreqtype != 0 ? $mreqtype : 1;
                $mreqstatus = $mreqstatus_sess ? $mreqstatus_sess : 0;
                $_POST['mreqstatus'] = $mreqstatus != 0 ? $mreqstatus : 0;
                $mreqfrom = $mreqfrom_sess ? $mreqfrom_sess : NULL;
                $_POST['mreqfrom'] = $mreqfrom != 0 ? $mreqfrom : NULL;
                $mreqto = $mreqto_sess ? $mreqto_sess : NULL;
                $_POST['mreqto'] = $mreqto != 0 ? $mreqto : NULL;
                $mreqrefnum = $mreqrefnum_sess ? $mreqrefnum_sess : NULL;
                $_POST['mreqrefnum'] = $mreqrefnum != 0 ? $mreqrefnum : NULL;
            }
            else {
                $mreqtype = 1;
                $_POST['mreqtype'] = 1;
                $mreqstatus = 0;
                $_POST['mreqstatus'] = 0;
                $mreqfrom = NULL;
                $_POST['mregfrom'] = NULL;
                $mreqto = NULL;
                $_POST['mreqto'] = NULL;
                $mreqrefnum = NULL;
                $_POST['mregrefnum'] = NULL;
            }

            $mreq_data = $mainsql->get_mrequest($mreqtype, 0, $start, NUM_ROWS, $mreqrefnum, 0, $profile_idnum, $mreqstatus, $mreqfrom, $mreqto);
            $mreq_count = $mainsql->get_mrequest($mreqtype, 0, 0, 0, $mreqrefnum, 1, $profile_idnum, $mreqstatus, $mreqfrom, $mreqto);

            $pages = $mainsql->pagination("myrequest", $mreq_count, NUM_ROWS, 9);

            //var_dump($mreq_data);

            switch($mreqtype) {

                case 11:
                    ?>

                    <table border="0" cellspacing="0" class="tdata width100per">
                        <?php if ($mreq_data) : ?>
                        <tr>
                            <th colspan="10">WFH Clearance</th>
                        </tr>
                        <tr>
                            <th width="5%">#</th>
                            <th width="10%">Ref. #</th>
                            <th width="10%">Date Applied</th>
                            <th width="5%">Date From</th>
                            <th width="5%">Date To</th>
                            <th width="5%">Status</th>
                        </tr>

                        <?php foreach ($mreq_data as $key => $value) : ?>
                        <?php $appdata = $mainsql->get_notification($value['RefNbr']);?>
                        <tr class="btnpenddata cursorpoint trdata centertalign" attribute="<?php echo $value['RefNbr']; ?>" attribute2="WC" attribute5="<?php echo $profile_dbname; ?>">
                            <td><?php echo $start + $key + 1; ?></td>
                            <td><?php echo $value['RefNbr']; ?></td>
                            <td><?php echo date("m/d/Y", strtotime($value['AppliedDate'])); ?></td>
                            <td><?php echo date("m/d/Y", strtotime($value['DTRFrom'])); ?></td>
                            <td><?php echo date("m/d/Y", strtotime($value['DTRTo'])); ?></td>
                            <td><?php echo $value['Status']; ?></td>
                        </tr>
                        <?php endforeach; ?>


                        <?php if ($pages) : ?>
                        <tr>
                            <td colspan="10" class="centertalign"><?php echo $pages; ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php else : ?>
                        <tr>
                            <td class="bold centertalign noborder"><br><br>You have no WFH Clearance applied</td>
                        </tr>
                        <?php endif; ?>
                    </table>

                    <?php
                    break;
                    
				case 10:
				?>

				<table border="0" cellspacing="0" class="tdata width100per">
					<?php if ($mreq_data) : ?>
					<tr>
						<th colspan="10">Work From Home</th>
					</tr>
					<tr>
						<th width="5%">#</th>
						<th width="10%">Ref. #</th>
						<th width="10%">Date Applied</th>
						<th width="5%">Date From</th>
						<th width="5%">Date To</th>
						<th width="5%">Status</th>
					</tr>

					<?php foreach ($mreq_data as $key => $value) : ?>
					<?php $appdata = $mainsql->get_notification($value['Reference']); ?>
					<tr class="btnpenddata cursorpoint trdata centertalign" attribute="<?php echo $value['Reference']; ?>" attribute2="WH" attribute5="<?php echo $profile_dbname; ?>">
						<td><?php echo $start + $key + 1; ?></td>
						<td><?php echo $value['Reference']; ?></td>
						<td><?php echo date("m/d/Y", strtotime($value['AppliedDate'])); ?></td>
						<td><?php echo date("m/d/Y", strtotime($value['FromDate'])); ?></td>
						<td><?php echo date("m/d/Y", strtotime($value['ToDate'])); ?></td>
						<td><?php
							if ($appdata[0]['Approved'] == 1) :
								echo 'APPROVED';
							elseif ($appdata[0]['Approved'] == 2) :
								echo 'REJECTED';
							elseif ($appdata[0]['Approved'] == 3) :
								echo 'CANCELLED';
							elseif ($appdata[0]['Approved'] == 0) :
								echo 'TO BE APPROVED';
							endif;
						?></td>
					</tr>
					<?php endforeach; ?>


					<?php if ($pages) : ?>
					<tr>
						<td colspan="10" class="centertalign"><?php echo $pages; ?></td>
					</tr>
					<?php endif; ?>
					<?php else : ?>
					<tr>
						<td class="bold centertalign noborder"><br><br>You have no WFH applied</td>
					</tr>
					<?php endif; ?>
				</table>

				<?php
				break;
                case 1:
                ?>

                <table border="0" cellspacing="0" class="tdata width100per">
                    <?php if ($mreq_data) : ?>
                    <tr>
                        <th colspan="10">OVERTIME TRANSACTION</th>
                    </tr>
                    <tr>
                        <th width="5%">#</th>
                        <th width="10%">Ref. #</th>
                        <th width="10%">Date Applied</th>
                        <th width="5%">DTR Date</th>
                        <th width="5%">From</th>
                        <th width="5%">To</th>
                        <th width="5%">Approved Hours</th>
                        <th width="10%">OT Type</th>
                        <th width="40%">Reason</th>
                        <th width="5%">Status</th>
                    </tr>
                    <?php foreach ($mreq_data as $key => $value) : ?>
                    <?php $appdata = $mainsql->get_notification($value['ReqNbr']); ?>
                    <tr class="btnpenddata cursorpoint trdata centertalign" attribute="<?php echo $value['ReqNbr']; ?>" attribute2="OT" attribute5="<?php echo $profile_dbname; ?>">
                        <td><?php echo $start + $key + 1; ?></td>
                        <td><?php echo $value['ReqNbr']; ?></td>
                        <td><?php echo date("m/d/Y", strtotime($value['ReqDate'])); ?></td>
                        <td><?php echo date("m/d/Y", strtotime($value['DtrDate'])); ?></td>
                        <td><?php echo date("h:i A", strtotime($value['FromDate'])); ?></td>
                        <td><?php echo date("h:i A", strtotime($value['ToDate'])); ?></td>
                        <td><?php echo $appdata[0]['Approved'] == 1 ? $value['ApprovedHrs'] : ''; ?></td>
                        <td><?php echo $value['OTType']; ?></td>
                        <td><?php echo $mainsql->truncate(stripslashes($value['Reason']), 40); ?></td>
                        <td><?php
                            if ($appdata[0]['Approved'] == 1) :
                                echo 'APPROVED';
                            elseif ($appdata[0]['Approved'] == 2) :
                                echo 'REJECTED';
                            elseif ($appdata[0]['Approved'] == 3) :
                                echo 'CANCELLED';
                            endif;
                        ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if ($pages) : ?>
                    <tr>
                        <td colspan="10" class="centertalign"><?php echo $pages; ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php else : ?>
                    <tr>
                        <td class="bold centertalign noborder"><br><br>You have no overtime applied</td>
                    </tr>
                    <?php endif; ?>
                </table>

                <?php
                break;
                case 2:
                ?>

                <table border="0" cellspacing="0" class="tdata width100per">
                    <?php if ($mreq_data) : ?>
                    <tr>
                        <th colspan="9">LEAVE TRANSACTION</th>
                    </tr>
                    <tr>
                        <th width="5%" rowspan="2">#</th>
                        <th width="15%" rowspan="2">Ref. #</th>
                        <th width="15%" rowspan="2">Type</th>
                        <th width="10%" rowspan="2">Date Applied</th>
                        <th width="10%" rowspan="2">From</th>
                        <th width="10%" rowspan="2">To</th>
                        <th width="20%" colspan="2">Hours</th>
                        <th width="15%" rowspan="2">Status</th>
                    </tr>
                    <tr>
                        <th width="10%">w/ Pay</th>
                        <th width="10%">w/o Pay</th>
                    </tr>
                    <?php foreach ($mreq_data as $key => $value) : ?>
                    <?php $appdata2 = $mainsql->get_notification($value['LeaveRef']); ?>
                    <?php
                        $leavedata = $tblsql->get_leavedata($value['LeaveRef']);
                        $wpay = 0;
                        $wopay = 0;

                        foreach ($leavedata as $k => $v) :
                            if ($v['Status'] == "APPROVED") :
                                if ($v['Duration'] == 9 || $v['Duration'] == 8) :
                                    if ($v['WithPay']) :
                                        $wpay = $wpay + $v['Duration'];
                                    else :
                                        $wopay = $wopay + $v['Duration'];
                                    endif;
                                else :
                                    if ($v['WithPay']) :
                                        $wpay = $wpay + $v['Duration'];
                                    else :
                                        $wopay = $wopay + $v['Duration'];
                                    endif;
                                endif;
                            endif;
                        endforeach;
                    ?>

                    <tr class="btnpenddata cursorpoint trdata centertalign" attribute="<?php echo $value['LeaveRef']; ?>" attribute2="LV" attribute5="<?php echo $profile_dbname; ?>">
                        <td><?php echo $start + $key + 1; ?></td>
                        <td><?php echo $value['LeaveRef']; ?></td>
                        <td><?php echo $value['LeaveDesc']; ?></td>
                        <td><?php echo date("m/d/Y", strtotime($value['DateFiled'])); ?></td>
                        <td><?php echo date("m/d/Y", strtotime($value['AbsenceFromDate'])); ?></td>
                        <td><?php echo date("m/d/Y", strtotime($value['AbsenceToDate'])); ?></td>
                        <td><?php echo $wpay; ?></td>
                        <td><?php echo $wopay; ?></td>
                        <td><?php
                            if ($appdata2[0]['Approved'] == 1) :
                                echo 'APPROVED';
                            elseif ($appdata2[0]['Approved'] == 2) :
                                echo 'REJECTED';
                            elseif ($appdata2[0]['Approved'] == 3) :
                                echo 'CANCELLED';
                            endif;
                        ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if ($pages) : ?>
                    <tr>
                        <td colspan="9" class="centertalign"><?php echo $pages; ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php else : ?>
                    <tr>
                        <td class="bold centertalign noborder"><br><br>You have no leave applied</td>
                    </tr>
                    <?php endif; ?>
                </table>

                <?php
                break;
                case 3:

                ?>

                <table border="0" cellspacing="0" class="tdata width100per">
                    <?php if ($mreq_data) : ?>
                    <tr>
                        <th colspan="7">MEAL ALLOWANCE</th>
                    </tr>
                    <tr>
                        <th width="10%">#</th>
                        <th width="15%">Ref. #</th>
                        <th width="15%">Type</th>
                        <th width="15%">Date Applied</th>
                        <th width="15%">From</th>
                        <th width="15%">To</th>
                        <th width="15%">Status</th>
                    </tr>
                    <?php foreach ($mreq_data as $key => $value) : ?>
                    <?php $appdata3 = $mainsql->get_notification($value['ReqNbr']); ?>
                    <tr class="btnpenddata cursorpoint trdata centertalign" attribute="<?php echo $value['ReqNbr']; ?>" attribute2="MA" attribute5="<?php echo $profile_dbname; ?>">
                        <td><?php echo $start + $key + 1; ?></td>
                        <td><?php echo $value['ReqNbr']; ?><</td>
                        <td><?php echo $value['TypeAvail']; ?><</td>
                        <td><?php echo date("m/d/Y", strtotime($value['ReqDate'])); ?></td>
                        <td><?php echo date("m/d/Y h:i A", strtotime($value['FromDate'])); ?></td>
                        <td><?php echo date("m/d/Y h:i A", strtotime($value['ToDate'])); ?></td>
                        <td><?php
                            if ($appdata3[0]['Approved'] == 1) :
                                echo 'APPROVED';
                            elseif ($appdata3[0]['Approved'] == 2) :
                                echo 'REJECTED';
                            elseif ($appdata3[0]['Approved'] == 3) :
                                echo 'CANCELLED';
                            endif;
                        ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if ($pages) : ?>
                    <tr>
                        <td colspan="7" class="centertalign"><?php echo $pages; ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php else : ?>
                    <tr>
                        <td class="bold centertalign noborder"><br><br>You have no meal allowance applied</td>
                    </tr>
                    <?php endif; ?>
                </table>

                <?php

                break;
                case 4:

                ?>

                <table border="0" cellspacing="0" class="tdata width100per">
                    <?php if ($mreq_data) : ?>
                    <tr>
                        <th colspan="7">OFFICIAL BUSINESS TRIP</th>
                    </tr>
                    <tr>
                        <th width="10%">#</th>
                        <th width="15%">Ref. #</th>
                        <th width="10%">Date Applied</th>
                        <th width="10%">From</th>
                        <th width="10%">To</th>
                        <th width="30%">Destination</th>
                        <th width="15%">Status</th>
                    </tr>
                    <?php foreach ($mreq_data as $key => $value) : ?>
                    <?php $appdata4 = $mainsql->get_notification($value['ReqNbr']); ?>
                    <tr class="btnpenddata cursorpoint trdata centertalign" attribute="<?php echo $value['ReqNbr']; ?>" attribute2="OB" attribute5="<?php echo $profile_dbname; ?>">
                        <td><?php echo $start + $key + 1; ?></td>
                        <td><?php echo $value['ReqNbr']; ?></td>
                        <td><?php echo date("m/d/Y", strtotime($value['DateFiled'])); ?></td>
                        <td><?php echo date("m/d/Y", strtotime($value['OBTimeINDate'])); ?></td>
                        <td><?php echo date("m/d/Y", strtotime($value['OBTimeOutDate'])); ?></td>
                        <td><?php echo $value['Destination']; ?></td>
                        <td><?php
                            if ($appdata4[0]['Approved'] == 1) :
                                echo 'APPROVED';
                            elseif ($appdata4[0]['Approved'] == 2) :
                                echo 'REJECTED';
                            elseif ($appdata4[0]['Approved'] == 3) :
                                echo 'CANCELLED';
                            endif;
                        ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if ($pages) : ?>
                    <tr>
                        <td colspan="7" class="centertalign"><?php echo $pages; ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php else : ?>
                    <tr>
                        <td class="bold centertalign noborder"><br><br>You have no OBT applied</td>
                    </tr>
                    <?php endif; ?>
                </table>

                <?php

                break;
                case 5:

                ?>

                <table border="0" cellspacing="0" class="tdata width100per">
                    <?php if ($mreq_data) : ?>
                    <tr>
                        <th colspan="8">CHANGE OF TIME SCHEDULE</th>
                    </tr>
                    <tr>
                        <th width="5%">#</th>
                        <th width="15%">Ref. #</th>
                        <th width="15%">Date Applied</th>
                        <th width="15%">Date Covered</th>
                        <th width="10%">Day</th>
                        <th width="15%">Change From</th>
                        <th width="15%">Change To</th>
                        <th width="10%">Status</th>
                    </tr>
                    <?php foreach ($mreq_data as $key => $value) : ?>
                    <?php $appdata5 = $mainsql->get_notification($value['ChangeTimeRef']); ?>
                    <tr class="btnpenddata cursorpoint trdata centertalign" attribute="<?php echo $value['ChangeTimeRef']; ?>" attribute2="SC" attribute5="<?php echo $profile_dbname; ?>">
                        <td><?php echo $start + $key + 1; ?></td>
                        <td><?php echo $value['ChangeTimeRef']; ?></td>
                        <td><?php echo date("m/d/Y", strtotime($value['DateFiled'])); ?></td>
                        <td><?php echo date("m/d/Y", strtotime($value['DateCovered'])); ?></td>
                        <td><?php echo $value['Day']; ?></td>
                        <td><?php echo $value['ChangeSchedFrom']; ?></td>
                        <td><?php echo $value['ChangeSchedTo']; ?></td>
                        <td><?php
                            if ($appdata5[0]['Approved'] == 1) :
                                echo 'APPROVED';
                            elseif ($appdata5[0]['Approved'] == 2) :
                                echo 'REJECTED';
                            elseif ($appdata5[0]['Approved'] == 3) :
                                echo 'CANCELLED';
                            endif;
                        ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if ($pages) : ?>
                    <tr>
                        <td colspan="8" class="centertalign"><?php echo $pages; ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php else : ?>
                    <tr>
                        <td class="bold centertalign noborder"><br><br>You have no change of time schedule applied</td>
                    </tr>
                    <?php endif; ?>
                </table>

                <?php

                break;
                case 6:

                ?>

                <table border="0" cellspacing="0" class="tdata width100per">
                    <?php if ($mreq_data) : ?>
                    <tr>
                        <th colspan="10">NON PUNCHING AUTHORIZATION</th>
                    </tr>
                    <tr>
                        <th width="5%" rowspan="2">#</th>
                        <th width="15%" rowspan="2">Ref. #</th>
                        <th width="15%" rowspan="2">Date Applied</th>
                        <th width="15%" rowspan="2">Date Covered</th>
                        <th width="10%" colspan="2">In</th>
                        <th width="10%" colspan="2">Out</th>
                        <th width="20%" rowspan="2">Reason</th>
                        <th width="10%" rowspan="2">Status</th>
                    </tr>
                    <tr>
                        <th width="5%">Date</th>
                        <th width="5%">Time</th>
                        <th width="5%">Date</th>
                        <th width="5%">Time</th>
                    </tr>
                    <?php foreach ($mreq_data as $key => $value) : ?>
                    <?php $appdata6 = $mainsql->get_notification($value['NonPunchRef']); ?>
                    <tr class="btnpenddata cursorpoint trdata centertalign" attribute="<?php echo $value['NonPunchRef']; ?>" attribute2="NP" attribute5="<?php echo $profile_dbname; ?>">
                        <td><?php echo $start + $key + 1; ?></td>
                        <td><?php echo $value['NonPunchRef']; ?></td>
                        <td><?php echo date("m/d/Y", strtotime($value['DateFiled'])); ?></td>
                        <td><?php echo date("m/d/Y", strtotime($value['DateCovered'])); ?></td>
                        <td><?php echo date("m/d/Y", strtotime($value['DateCovered'])); ?></td>
                        <td><?php echo date("h:i A", strtotime($value['TimeIn'])); ?></td>
                        <td><?php echo date("m/d/Y", strtotime($value['DateCovered'])); ?></td>
                        <td><?php echo date("h:i A", strtotime($value['TimeOut'])); ?></td>
                        <td><?php echo $mainsql->truncate(stripslashes($value['Reason']), 30); ?></td>
                        <td><?php
                            if ($appdata6[0]['Approved'] == 1) :
                                echo 'APPROVED';
                            elseif ($appdata6[0]['Approved'] == 2) :
                                echo 'REJECTED';
                            elseif ($appdata6[0]['Approved'] == 3) :
                                echo 'CANCELLED';
                            endif;
                        ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if ($pages) : ?>
                    <tr>
                        <td colspan="10" class="centertalign"><?php echo $pages; ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php else : ?>
                    <tr>
                        <td class="bold centertalign noborder"><br><br>You have no non-punching authorization applied</td>
                    </tr>
                    <?php endif; ?>
                </table>

                <?php

                break;
                case 7:

                ?>

                <table border="0" cellspacing="0" class="tdata width100per">
                    <?php if ($mreq_data) : ?>
                    <tr>
                        <th colspan="4">MANUAL DTR</th>
                    </tr>
                    <tr>
                        <th width="15%">#</th>
                        <th width="30%">Ref. #</th>
                        <th width="30%">Date Applied</th>
                        <th width="25%">Status</th>
                    </tr>
                    <?php foreach ($mreq_data as $key => $value) : ?>
                    <?php $appdata7 = $mainsql->get_notification($value['ReqNbr']); ?>
                    <tr class="btnpenddata cursorpoint trdata centertalign" attribute="<?php echo $value['ReqNbr']; ?>" attribute2="MD" attribute5="<?php echo $profile_dbname; ?>">
                        <td><?php echo $start + $key + 1; ?></td>
                        <td><?php echo $value['ReqNbr']; ?></td>
                        <td><?php echo date("m/d/Y", strtotime($value['ReqDate'])); ?></td>
                        <td><?php
                            if ($appdata7[0]['Approved'] == 1) :
                                echo 'APPROVED';
                            elseif ($appdata7[0]['Approved'] == 2) :
                                echo 'REJECTED';
                            elseif ($appdata7[0]['Approved'] == 3) :
                                echo 'CANCELLED';
                            endif;
                        ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if ($pages) : ?>
                    <tr>
                        <td colspan="4" class="centertalign"><?php echo $pages; ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php else : ?>
                    <tr>
                        <td class="bold centertalign noborder"><br><br>You have no manual DTR applied</td>
                    </tr>
                    <?php endif; ?>
                </table>

                <?php

                break;
                case 8:

                ?>

                <table border="0" cellspacing="0" class="tdata width100per">
                    <?php if ($mreq_data) : ?>
                    <tr>
                        <th colspan="4">TIME SCHEDULER</th>
                    </tr>
                    <tr>
                        <th width="15%">#</th>
                        <th width="30%">Ref. #</th>
                        <th width="30%">Date Applied</th>
                        <th width="25%">Status</th>
                    </tr>
                    <?php foreach ($mreq_data as $key => $value) : ?>
                    <?php $appdata8 = $mainsql->get_notification($value['ReqNbr']); ?>
                    <tr class="btnpenddata cursorpoint trdata centertalign" attribute="<?php echo $value['ReqNbr']; ?>" attribute2="SC" attribute5="<?php echo $profile_dbname; ?>">
                        <td><?php echo $start + $key + 1; ?></td>
                        <td><?php echo $value['ReqNbr']; ?></td>
                        <td><?php echo date("m/d/Y", strtotime($value['ReqDate'])); ?></td>
                        <td><?php
                            if ($appdata8[0]['Approved'] == 1) :
                                echo 'APPROVED';
                            elseif ($appdata8[0]['Approved'] == 2) :
                                echo 'REJECTED';
                            elseif ($appdata8[0]['Approved'] == 3) :
                                echo 'CANCELLED';
                            endif;
                        ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if ($pages) : ?>
                    <tr>
                        <td colspan="4" class="centertalign"><?php echo $pages; ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php else : ?>
                    <tr>
                        <td class="bold centertalign noborder"><br><br>You have no time scheduler applied</td>
                    </tr>
                    <?php endif; ?>
                </table>

                <?php

                break;
            }

        break;
        default:
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";

    }

?>
