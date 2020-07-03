	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->

		<div id="leavefloat" class="floatdiv invisible">
			<!-- VIEW NOTIFICATION - BEGIN -->
			<div id="leaveview" class="fview" style="display: none;">
				<div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i>
				</div>
				<div id="leave_title" class="pend_title robotobold cattext dbluetext" align="center">
				</div>
				<div id="leave_data" style="text-align: center; padding-top: 50px;">
				</div>
			</div>
			<!-- VIEW NOTIFICATION - END -->
		</div>

                    <div id="mainsplashtext" class="mainsplashtext lefttalign">
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainleave" class="mainbody lefttalign whitetext">
                                <b class="mediumtext lorangetext">LEAVE REQUEST</b><br><br>
                                <b>MAIN INFORMATION</b><br><br>
                                <div class="column2">
                                    <b><?php echo ucfirst($profile_nadd); ?> ID: </b><?php echo $profile_idnum; ?><br>
                                    <b>Name: </b><?php echo $profile_full; ?><br>
                                    <b>Position: </b><?php echo $profile_pos; ?><br>
                                    <b>Status: </b>Open<br>
                                    <b>Department: </b><?php echo $profile_dept; ?><br>
                                </div><br>
                                <div id="alert"></div>
                                <form id="frmapplyleave" action="?ignore-page-cache=true" method="post" enctype="multipart/form-data">
                                    <div id="tabs">
                                        <ul>
                                            <li><a href="#ldetails">Details</a></li>
                                            <li><a href="#lbalance">Leave Balance</a></li>
                                            <li><a href="#lattach">Attachments</a></li>
                                            <li><a href="#lapprover">Approvers</a></li>
                                        </ul>

                                        <div id="ldetails">
                                            <table>
                                                <tr>
                                                    <td width="50%" class="valigntop">
                                                        <table class="tdataform" border="0" cellspacing="0">
                                                            <tr>
                                                                <td width="15%"><b>Type: </b></td>
                                                                <td width="85%" colspan="3">
                                                                    <select id="leave_type" name="leave_type" class="txtbox width95per">
                                                                        <?php foreach ($leave_data as $key => $value) : ?>
                                                                        <option value="<?php echo $value['LeaveID']; ?>"><?php echo $value['LeaveDesc']; ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="15%"><b>From: </b></td>
                                                                <td width="35%"><input type="text" id="leave_from" name="leave_from" value="<?php echo date('Y-m-d'); ?>" class="txtbox datepick7 width95per" readonly /></td>
                                                                <td width="15%"><b>To: </b></td>
                                                                <td width="35%"><input type="text" id="leave_to" name="leave_to" value="<?php echo date('Y-m-d'); ?>" class="txtbox datepick7 width95per" readonly /><input type="text" class="txtbox width95per leave2" readonly /></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Reason: </b></td>
                                                                <td colspan="3">
                                                                    <textarea id="leave_reason" name="leave_reason" rows="5" class="txtarea width95per"></textarea>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td width="50%" class="valigntop">

                                                        <b>Leave Details</b><br><br>

                                                        <table class="tdatahead vsmalltext" border="0" cellspacing="0">
                                                            <tr>
                                                                <th width="20%" class="centertalign">Date</th>
                                                                <th width="40%" class="centertalign">Duration</th>
                                                                <th width="20%" class="centertalign">w/ Pay</th>
                                                                <th width="20%" class="centertalign">Status</th>
                                                            </tr>
                                                        </table>

                                                        <div id="leavesched" class="leavesched">
															<?php
																$leave_bal = $mainsql->get_leavebal($profile_idnum, 'L04');
															?>
															<script type="text/javascript">
																	function formatDate(date) {
																	    var d = new Date(date),
																	        month = '' + (d.getMonth() + 1),
																	        day = '' + d.getDate(),
																	        year = d.getFullYear();

																	    if (month.length < 2) month = '0' + month;
																	    if (day.length < 2) day = '0' + day;

																	    return [year, month, day].join('-');
																	}

																	$(document).ready(function() {
																		$('.leave2').hide();
																		if($('#leave_type').val() == 'L04'){
																			var from_default = new Date("<?php echo date('Y-m-d', strtotime($leave_bal[0][DateEffect])); ?>");
																			$('#leave_from').datepicker("setDate", from_default);
																		}

																		$('#leave_from').on('change', function (e) {
																			if($('#leave_type').val() == 'L04'){
																				var from = new Date($('#leave_from').val());
																				var from_sum = new Date((from.getTime() + (<?php echo $leave_bal[0][BalanceDays]-1;?>)*24*60*60*1000));
																				var final = formatDate(from_sum);
																				$('#leave_to').val(final);
																				$('#leave_to').hide();
																				$('.leave2').val(final);
																				$('.leave2').show();
																			}else{
																				$('#leave_to').show();
																				$('.leave2').hide();
																			}
																		});
																		$('#leave_type').on('change', function (e) {
																			$(".total_day").html('');
																			$(".total_pay").html('');
																			if($('#leave_type').val() != 'L04'){
																				$('#leave_from').val(formatDate(Date()));
																				$('#leave_to').val(formatDate(Date()));
																				$('#leave_to').show();
																				$('.leave2').hide();
																			}else{
																				var from_default = new Date("<?php echo date('Y-m-d', strtotime($leave_bal[0][DateEffect])); ?>");
																				$('#leave_from').datepicker("setDate", from_default);

																				var from = new Date($('#leave_from').val());
																				var from_sum = new Date((from.getTime() + (<?php echo $leave_bal[0][BalanceDays] -1;?>)*24*60*60*1000));
																				var final = formatDate(from_sum);
																				$('#leave_to').val(final);
																				$('#leave_to').hide();
																				$('.leave2').val(final);
																				$('.leave2').show();
																			}
																		});

															   		});

                                                                $(function() {
                                                                    $(".leave_duration").change(function() {

                                                                        var sltype1 = new Array();
                                                                        var sldate = new Array();
                                                                        var sltype2 = new Array();
                                                                        var sptype = new Array();
                                                                        var empid;
                                                                        $('input[name^="leave_pay"]').each(function(){
                                                                            var checked = $(this).is(':checked');

                                                                            if (checked) {
                                                                                sptype.push($(this).val());
                                                                            }
                                                                            else {
                                                                                sptype.push(0);
                                                                            }
                                                                        });

                                                                        $('select[name^="leave_duration"]').each(function(){
                                                                            sltype1.push($(this).val());
                                                                        });

                                                                        $('select[name^="leave_duration"]').each(function(){
                                                                            sldate.push($(this).attr('attribute'));
                                                                        });

                                                                        i = 0;

                                                                        $('select[name^="leave_duration"]').each(function(){
                                                                            if (sptype[i] == 1) {
                                                                                sltype2.push($(this).val());
                                                                            }
                                                                            else {
                                                                                sltype2.push(0);
                                                                            }
                                                                            i++;
                                                                        });

                                                                        empid = $('#lempid').val();

                                                                        $.ajax(
                                                                        {
                                                                            url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getleaveday",
                                                                            data: "stype=" + sltype1 + "&sdate=" + sldate + "&empid=" + empid,
                                                                            type: "POST",
                                                                            complete: function(){
                                                                                $("#loading").hide();
                                                                            },
                                                                            success: function(data) {
                                                                                $("#leavetotal").removeClass("invisible");
                                                                                $(".total_day").html(data);
                                                                                $("#tdayswop").val(data);
                                                                            }
                                                                        })

                                                                        $.ajax(
                                                                        {
                                                                            url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getleavepay",
                                                                            data: "stype=" + sltype2 + "&sdate=" + sldate + "&empid=" + empid,
                                                                            type: "POST",
                                                                            complete: function(){
                                                                                $("#loading").hide();
                                                                            },
                                                                            success: function(data) {
                                                                                $("#leavetotal").removeClass("invisible");
                                                                                $(".total_pay").html(data);
                                                                                $("#tdays").val(data);
                                                                            }
                                                                        })
                                                                    });

                                                                    $(".leave_pay").change(function() {

                                                                        var sltype1 = new Array();
                                                                        var sldate = new Array();
                                                                        var sltype2 = new Array();
                                                                        var sptype = new Array();
                                                                        var empid;

                                                                        $('input[name^="leave_pay"]').each(function(){
                                                                            var checked = $(this).is(':checked');

                                                                            if (checked) {
                                                                                sptype.push($(this).val());
                                                                            }
                                                                            else {
                                                                                sptype.push(0);
                                                                            }
                                                                        });

                                                                        $('select[name^="leave_duration"]').each(function(){
                                                                            sltype1.push($(this).val());
                                                                        });

                                                                        $('select[name^="leave_duration"]').each(function(){
                                                                            sldate.push($(this).attr('attribute'));
                                                                        });

                                                                        i = 0;

                                                                        $('select[name^="leave_duration"]').each(function(){
                                                                            if (sptype[i] == 1) {
                                                                                sltype2.push($(this).val());
                                                                            }
                                                                            else {
                                                                                sltype2.push(0);
                                                                            }
                                                                            i++;
                                                                        });

                                                                        empid = $('#lempid').val();

                                                                        $.ajax(
                                                                        {
                                                                            url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getleaveday",
                                                                            data: "stype=" + sltype1 + "&sdate=" + sldate + "&empid=" + empid,
                                                                            type: "POST",
                                                                            complete: function(){
                                                                                $("#loading").hide();
                                                                            },
                                                                            success: function(data) {
                                                                                $("#leavetotal").removeClass("invisible");
                                                                                $(".total_day").html(data);
                                                                                $("#tdayswop").val(data);
                                                                            }
                                                                        })

                                                                        $.ajax(
                                                                        {
                                                                            url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getleavepay",
                                                                            data: "stype=" + sltype2 + "&sdate=" + sldate + "&empid=" + empid,
                                                                            type: "POST",
                                                                            complete: function(){
                                                                                $("#loading").hide();
                                                                            },
                                                                            success: function(data) {
                                                                                $("#leavetotal").removeClass("invisible");
                                                                                $(".total_pay").html(data);
                                                                                $("#tdays").val(data);
                                                                            }
                                                                        })
                                                                    });

                                                                });

                                                            </script>

                                                            <?php

                                                                $leave_from = strtotime(date('Y-m-d')." 00:00:00");
                                                                $leave_to = strtotime(date('Y-m-d')." 23:59:59");
                                                                ?>

                                                                <table width="100%" class="tdatamid vsmalltext" border="0" cellspacing="0">

                                                                <?php

                                                                $i = 0;
                                                                $total_day = 0;
                                                                while($leave_from <= $leave_to) {

                                                                    $vdates = date("Y-m-d", $leave_from);
                                                                    $udates = date("U", $leave_from);
                                                                    $dates = date("M j", $leave_from);
                                                                    $days = date("D", $leave_from);
                                                                    $numdays = intval(date("N", $leave_from));

                                                                    $shiftsched2 = $mainsql->get_schedshiftdtr($profile_idnum, $vdates);
                                                                    $sft2 = $shiftsched2[0]['ShiftID'];

                                                                    $dayshift = $mainsql->get_shift($shiftsched2[0]['ShiftID']);

                                                                    $hours = $dayshift[0]['NUMHrs'] - $dayshift[0]['BreakHours'];

                                                                    $ddisplay = $sft2 ? 1 : 0;

                                                                    $getnumhours = $mainsql->get_shift($sft2);

                                                                    $wdhours = $getnumhours[0]['NUMHrs'] - $getnumhours[0]['BreakHours'];
                                                                    if ($getnumhours[0]['NUMHrs'] <= 4) :
                                                                        $hdhours = $getnumhours[0]['NUMHrs'] - $getnumhours[0]['BreakHours'];
                                                                    else :
                                                                        $hdhours = ($getnumhours[0]['NUMHrs'] - $getnumhours[0]['BreakHours']) / 2;
                                                                    endif;

                                                                    // this is for holiday checking
                                                                    $monthnum = date("n", $leave_from);
                                                                    $daynum = date("j", $leave_from);

                                                                    $thisholiday = $mainsql->get_holiday(1, $monthnum, $daynum, $profile_location);
                                                                    $restday = $sft2 ? 0 : 1;

                                                                    $daycount = $thisholiday || $restday ? 0 : $hours;
                                                                    $total_day = $total_day + $daycount;
                                                                    $leave_from = strtotime("+1 day", $leave_from);
                                                                    if ($ddisplay && !$thisholiday) :
                                                                    ?>

                                                                    <tr>
                                                                        <td width="20%" class="centertalign">
                                                                            <input id="leave_date[<?php echo $i; ?>]" type="hidden" name="leave_date[<?php echo $i; ?>]" value="<?php echo $vdates; ?>" />
                                                                            <?php echo $days; ?><br><?php echo $dates; ?>
                                                                        </td>
                                                                        <td width="40%" class="centertalign">
                                                                            <select name="leave_duration[<?php echo $i; ?>]" id="leave_duration[<?php echo $i; ?>]" attribute="<?php echo $udates; ?>" class="leave_duration smltxtbox width95per">
                                                                                <option value="<?php echo 'WD'; //echo $wdhours; ?>"<?php echo $getnumhours[0]['NUMHrs'] == 9 ? ' selected' : ''; ?>>Whole-Day</option>
                                                                                <option value="<?php echo 'HD1'; //echo $hdhours; ?>"<?php echo $getnumhours[0]['NUMHrs'] == 4 ? ' selected' : ''; ?>>Half-Day AM</option>
                                                                                <option value="<?php echo 'HD2'; //echo $hdhours; ?>">Half-Day PM</option>
                                                                                <option value="0">None</option>
                                                                            </select>
                                                                        </td>
                                                                        <td width="20%" class="centertalign"><input type="checkbox" name="leave_pay[<?php echo $i; ?>]" id="leave_pay[<?php echo $i; ?>]" value="1" attribute="<?php echo $udates; ?>" class="leave_pay" checked /></td>
                                                                        <td width="20%" class="centertalign">CLOSE</td>
                                                                    </tr>

                                                                    <?php

                                                                    $i++;

                                                                    endif;

                                                                    $leave_from = strtotime("+1 day", $leave_from);
                                                                }

                                                                if (!$i) :
                                                                ?>
                                                                    <tr>
                                                                        <td class="centertalign">Please check your DTR first</td>
                                                                    </tr>
                                                                <?php
                                                                endif;

                                                                ?>
                                                                </table>


                                                        </div>
                                                        <div id="leavetotal" class="leavetotal">
                                                            <b>Total <?php echo $profile_compressed ? 'Hours' : 'Days'; ?>: <span class='total_day'><?php echo ($profile_compressed ? $total_day : $total_day / 8); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;With Pay: <span class='total_pay'><?php echo ($profile_compressed ? $total_day : $total_day / 8); ?></span>
                                                        </div>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <i>* If there's something wrong with date or time represent within this application, please check your DTR first</i>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div id="lbalance">
                                            <table>
                                                <tr>
                                                    <th width="55%">Leave Type</th>
                                                    <th width="30%">Balance (<?php echo $profile_compressed ? 'hours' : 'days'; ?>)</th>
                                                    <!--th width="15%">w/ Pay</th>
                                                    <th width="15%">w/o Pay</th-->
                                                </tr>

                                                <?php
                                                    if ($leave_data) :

                                                        foreach ($leave_data as $key => $value) :
                                                        ?>
                                                            <tr class="trdata">
                                                                <?php $leave_bal = $mainsql->get_leavebal_byid($profile_idnum, $value['LeaveID']); ?>
                                                                <td><?php echo $value['LeaveDesc']; ?></td>
                                                                <?php if ($profile_compressed) : ?>
                                                                <td class="lefttalign"><?php echo $leave_bal[0]['BalanceHrs'] ? number_format($leave_bal[0]['BalanceHrs'], 2) : '0.00' ; ?></td>
                                                                <?php else : ?>
                                                                <td class="lefttalign"><?php echo $leave_bal[0]['BalanceDays'] ? number_format($leave_bal[0]['BalanceDays'], 2) : '0.00' ; ?></td>
                                                                <?php endif; ?>
                                                                <!--td class="centertalign">0.00</td>
                                                                <td class="centertalign">0.00</td-->
                                                            </tr>
                                                        <?php
                                                        endforeach;

                                                    else :
                                                        ?>

                                                        <tr class="trdata">
                                                            <td colspan="7" class="centertalign">No record found</td>
                                                        </tr>

                                                        <?php
                                                    endif;
                                                ?>
                                            </table>
                                        </div>
                                        <div id="lattach">
                                            <input id="attachment1" type="file" name="attachment1" class="whitetext" /><br>
                                            <input id="attachment2" type="file" name="attachment2" class="whitetext" /><br>
                                            <input id="attachment3" type="file" name="attachment3" class="whitetext" /><br>
                                            <input id="attachment4" type="file" name="attachment4" class="whitetext" /><br>
                                            <input id="attachment5" type="file" name="attachment5" class="whitetext" />
                                            <br><br>
                                            <i>* it must be PDF or image (JPG or GIF) and not more than 200Kb each</i>
                                        </div>
                                        <div id="lapprover">
                                            <?php if($lv_app) : ?>
                                            <?php foreach($lv_app as $key => $value) : ?>
                                                <?php if ($key < 6) : ?>
                                                <b>Level <?php echo $key; ?>:</b> <?php echo trim($value[0]) ? $value[0] : '-- NOT SET --'; ?> <input type="hidden" name="approver<?php echo $key; ?>" value="<?php echo $value[1]; ?>" /><input type="hidden" name="dbapprover<?php echo $key; ?>" value="<?php echo $value[2]; ?>" /><br>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php else : ?>
                                                No approvers has been set
                                            <?php endif; ?>
                                        </div>

                                    </div>
                                    <div class="righttalign">
                                        <?php
                                            $microsec = microtime();
                                            $micsec = explode(' ', $microsec);
                                            $finsec = str_replace('.', '', $micsec[1].$micsec[0]);
                                        ?>
                                        <?php $leave_bal2 = $mainsql->get_leavebal_byid($profile_idnum, "L01"); ?>
                                        <?php $leave_balance = $leave_bal2[0]['BalanceHrs'] ? $leave_bal2[0]['BalanceHrs'] : 0; ?>
																				<!-- test here -->
                                        <!--input id="days" type="hidden" name="days" value="" /-->
                                        <input type="hidden" id="lempid" name="empid" value="<?php echo $profile_idnum; ?>" />
                                        <input type="hidden" name="reqnbr" value="<?php echo "LV-".$finsec; ?>" />
                                        <input type="hidden" name="user" value="<?php echo $profile_idnum; ?>" />
                                        <input id="tdayswop" type="hidden" name="dayswop" value="" />
                                        <input id="tdays" name="days" value="8" />
                                        <input id="totaldays" type="hidden" name="totaldays" value="8" />
                                        <input id="tbalance" type="hidden" name="balance" value="<?php echo $leave_balance <= 0 ? 0 : round($leave_balance * 2, 0) / 2; ?>" />
                                        <input id="btnleaveapply" type="submit" name="btnleaveapply" value="Submit" class="btn margintop10" />
                                        <a href="<?php echo WEB; ?>/pending"><input type="button" name="btncancel" value="Cancel" class="redbtn margintop10" /></a>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                    <script type="text/javascript">
                        <?php
                        // Temporary solution for application of leave from 2019

                         ?>
                         /*
                        $(document).on('change', '#leave_from', function(event){
                            // event.preventDefault();

                            check_leave_date();
                        });

                        $(document).on('change', '#leave_to', function(event){
                            // event.preventDefault();

                            check_leave_date();
                        });

                        $(document).on('change', '#leave_type', function(event){
                            // event.preventDefault();

                            check_leave_date();
                        });

                        function check_leave_date() {
                            var lfrom = $('#leave_from').val();
                            var lto = $('#leave_to').val();

                            if(lfrom >= '2020-01-01' || lto >= '2020-01-01'){

                                if('<?php echo $profile_dbname; ?>' == 'GL'){

                                    $('#btnleaveapply').prop({
                                        disabled: true,
                                        readonly: true,
                                    })

                                    alert('You have no leave balance for covered dates starting January 1, 2020')

                                }else{
                                    if($('#leave_type').val() == 'L01'){
                                         $('#btnleaveapply').prop({
                                            disabled: true,
                                            readonly: true,
                                         })
                                    alert('You have no leave balance for covered dates starting January 1, 2020')
                                    }else{
                                        $('#btnleaveapply').prop({
                                            disabled: false,
                                            readonly: false,
                                         })
                                    }
                                }

                            }else{
                                $('#btnleaveapply').prop({
                                    disabled: false,
                                        readonly: false,
                                 })
                            }
                        }

                            check_leave_date();
alert('Vacation Leave/Sick Leave/Emergency Leave will be suspended until further notice.'); $('#btnleaveapply').hide();

    */


                    </script>

    <?php include(TEMP."/footer.php"); ?>
