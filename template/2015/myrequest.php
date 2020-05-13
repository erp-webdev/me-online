	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->

                    <div id="floatdiv" class="floatdiv invisible">
                        <!-- VIEW NOTIFICATION - BEGIN -->
                        <div id="nview" class="rview" style="display: none;">
                            <div class="rclose cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                            <div id="pend_title" class="pend_title robotobold cattext dbluetext"></div>
                            <div id="pend_data">

                            </div>
                        </div>
                        <!-- VIEW NOTIFICATION - END -->
                    </div>

                    <div id="mainsplashtext" class="mainsplashtext lefttalign">
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainnotification" class="mainbody lefttalign whitetext">
                                <b class="mediumtext lorangetext">MY REQUESTS</b><br><br>
                                <table class="marginbottom20">
                                    <tr>
                                        <td>Type:
                                            <select id="mreqtype" name="mreqtype" class="width80 smltxtbox">
                                                <option value="1"<?php echo $mreqtype == 1 ? ' selected' : ''; ?>>OVERTIME</option>
                                                <option value="2"<?php echo $mreqtype == 2 ? ' selected' : ''; ?>>LEAVE</option>
                                                <option value="4"<?php echo $mreqtype == 4 ? ' selected' : ''; ?>>OFFICIAL BUSINESS TRIP</option>
                                                <option value="6"<?php echo $mreqtype == 6 ? ' selected' : ''; ?>>NON PUNCHING AUTHORIZATION</option>
                                                <option value="7"<?php echo $mreqtype == 7 ? ' selected' : ''; ?>>MANUAL DTR</option>
												<option value="8"<?php echo $mreqtype == 8 ? ' selected' : ''; ?>>SCHEDULER</option>
                                                <?php
																								$empids_wfh = array("2004-04-8966","2016-06-0457","2000-06-8166","2018-11-0605","2016-06-0144","2010-12-V034","2020-03-0079","1999-09-8123","2019-02-0033","2007-06-M314","2015-03-0093","2019-01-0028","2019-02-0070","2018-08-0453","2016-06-0464","2019-07-0386","2017-04-0933","2018-07-0406","2019-07-0457","2009-07-V177","2011-08-U036",
										                                                "1993-07-8463","2008-04-M764","2011-07-V980","2006-06-M168","2001-12-8773","1998-08-8602","2001-07-M219","2013-06-N202","2012-05-U417","2008-02-M719","2005-09-M103","2006-06-M163","1997-06-8727","2012-04-U354","1991-10-8274","2007-05-M477","1991-08-8310","1987-07-8128","1996-01-8509","1997-03-8638","2008-06-M829","2013-02-U861","2002-09-8855","1997-05-8715","2012-01-U197",
										                                                "2001-10-8752","2009-07-V176","2013-03-U940","2016-04-0140","2016-06-0145","2017-11-0016","2019-01-0000","2019-02-0002","2019-09-0133","1990-03-8284");

																								if(in_array($profile_idnum, $empids_wfh)){ ?>
													<option value="10"<?php echo $mreqtype == 10 ? ' selected' : ''; ?>>WFH</option>
												<?php } ?>
                                                <!--option value="9"<?php echo $mreqtype == 9 ? ' selected' : ''; ?>>OFFSET</option-->
                                            </select>
                                            <!--&nbsp;Status:
                                            <select id="mreqstatus" name="mreqstatus" class="width80 smltxtbox">
                                                <option value=""<?php echo !$mreqstatus ? ' selected' : ''; ?>>ALL</option>
                                                <option value="0"<?php echo $mreqstatus == 0 ? ' selected' : ''; ?>>FOR APPROVAL</option>
                                                <option value="1"<?php echo $mreqstatus == 1 ? ' selected' : ''; ?>>APPROVED</option>
                                                <option value="2"<?php echo $mreqstatus == 2 ? ' selected' : ''; ?>>REJECTED</option>
                                                <option value="3"<?php echo $mreqstatus == 3 ? ' selected' : ''; ?>>CANCELLED</option>
                                            </select-->&nbsp;
                                            From:&nbsp;<input type="text" id="mreqfrom" name="mreqfrom" value="<?php echo date("Y-m-d", strtotime("-1 year")); ?>" class="width55 smltxtbox datepick2" />&nbsp;
                                            To:&nbsp;<input type="text" id="mreqto" name="mreqto" value="<?php echo date("Y-m-d"); ?>" class="width55 smltxtbox datepick2" />&nbsp;
                                            Ref. #:&nbsp;<input type="text" id="mreqrefnum" name="mreqrefnum" class="width80 smltxtbox datepicker" />&nbsp;
                                            <input type="button" id="btnmreq" name="btnmreq" value="Search" class="smlbtn" />
                                            <?php if ($_SESSION['mreqfrom']) : ?>
                                            <input type="button" id="btnmreqall" name="btnmreqall" value="View All" class="smlbtn" />
                                            <?php endif; ?>

                                        </td>
                                    </tr>
                                </table>

                                <div id="mreqdata">

                                <?php
                                switch($mreqtype) {

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
										<?php $appdata = $mainsql->get_notification($value['Reference']);?>
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
                                            $leavedata = $mainsql->get_leavedata($value['LeaveRef']);
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
                                            <td><?php echo date("h:i A", strtotime($mainsql->remove1900($value['TimeIn']))); ?></td>
                                            <td><?php echo date("m/d/Y", strtotime($value['DateCovered'])); ?></td>
                                            <td><?php echo date("h:i A", strtotime($mainsql->remove1900($value['TimeOut']))); ?></td>
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
                                    case 9:
                                    ?>

                                    <table border="0" cellspacing="0" class="tdata width100per">
                                        <?php if ($mreq_data) : ?>
                                        <tr>
                                            <th colspan="10">OFFSET TRANSACTION</th>
                                        </tr>
                                        <tr>
                                            <th width="10%">#</th>
                                            <th width="15%">Ref. #</th>
                                            <th width="15%">Date Applied</th>
                                            <th width="15%">DTR Date</th>
                                            <th width="15%">Hours</th>
                                            <th width="15%">Offset Type</th>
                                            <th width="15%">Status</th>
                                        </tr>
                                        <?php foreach ($mreq_data as $key => $value) : ?>
                                        <?php $appdata = $mainsql->get_notification($value['ReqNbr']); ?>
                                        <tr class="btnpenddata cursorpoint trdata centertalign" attribute="<?php echo $value['ReqNbr']; ?>" attribute2="OT">
                                            <td><?php echo $start + $key + 1; ?></td>
                                            <td><?php echo $value['ReqNbr']; ?></td>
                                            <td><?php echo date("m/d/Y", strtotime($value['ReqDate'])); ?></td>
                                            <td><?php echo date("m/d/Y", strtotime($value['DtrDate'])); ?></td>
                                            <td><?php echo $value['LUHrs'] == 1 ? $value['Hrs'] : 0; ?></td>
                                            <td><?php echo $value['LUType']; ?></td>
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
                                            <td colspan="7" class="centertalign"><?php echo $pages; ?></td>
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

                                }
                                ?>

                                </div>

                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>
