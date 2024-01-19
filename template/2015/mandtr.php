	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
                    
                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="maindtr" class="mainbody lefttalign whitetext">  
                                <b class="mediumtext lorangetext">MANUAL DTR</b><br><br>
                                <b>MAIN INFORMATION</b><br><br>
                                <div class="column2">
                                    <b><?php echo ucfirst($profile_nadd); ?> ID: </b><?php echo $profile_idnum; ?><br>
                                    <b>Name: </b><?php echo $profile_full; ?><br>
                                    <b>Position: </b><?php echo $profile_pos; ?><br>
                                    <b>Status: </b>Open<br>
                                    <b>Department: </b><?php echo $profile_dept; ?><br>
                                </div><br>
                                
                                <div id="alert"></div>
                                <form id="frmapplymd" name="frmapplymd" action="?ignore-page-cache=true" method="post" enctype="multipart/form-data">
                                    <div id="tabs">
                                        <ul>
                                            <li><a href="#ldetails">Details</a></li>
                                            <li><a href="#lattach">Attachments</a></li>
                                            <li><a href="#lapprover">Approvers</a></li>
                                        </ul>

                                        <div id="ldetails">
                                            <table class="tdataform" border="0" cellspacing="0">
                                                <tr>
                                                    <td width="15%"><b>DTR Date: </b></td>
                                                    <td width="85%"><input id="mdtr_from" type="text" name="mdtr_from" value="<?php echo $mandtr_fdate; ?>" class="txtbox datepick6" readonly /> - <input id="mdtr_to" type="text" name="mdtr_to" value="<?php echo $mandtr_todate; ?>" class="txtbox datepick6" readonly /></td>
                                                </tr>
                                                <tr>
                                                    <td width="15%">&nbsp;</td>
                                                    <td width="85%" colspan="3">
                                                        <div id="mandtr" class="mandtr">
                                                            
                                                            <table width="100%" class="tdata vsmalltext" border="0" cellspacing="0">
                                                                <tr>
                                                                    <th width="3%">#</th>
                                                                    <th width="6%">Exclude</th>
                                                                    <th width="14%">Date</th>
                                                                    <th width="9%">In</th>
                                                                    <th width="9%">Date</th>
                                                                    <th width="9%">Out</th>
                                                                    <th width="22%">Shift Desc</th>
                                                                    <th width="22%">New Shift Desc</th>
                                                                </tr>
                                                            
                                                                <?php

                                                                    $key = 1;

                                                                    $shiftsched = $mainsql->get_schedshift($profile_idnum);
                                                                    $shiftlist = $mainsql->get_shift();

                                                                    while($mandtr_from <= $mandtr_today) {

                                                                        $udate = date("U", $mandtr_from);
                                                                        $dates = date("Y-m-d", $mandtr_from);
                                                                        $days = date("D m/d/y", $mandtr_from);
                                                                        $numdays = intval(date("N", $mandtr_from));

                                                                        $_POST['strEMPID'] = $profile_idnum;
                                                                        $_POST['dteDTRDate'] = date("m/d/Y", $mandtr_from);
                                                                        $_POST['OVERWRITE'] = 0;
                                                                        $_POST['STATUS'] = 'INITIAL';
                                                                        $_POST['intFINALPAY'] = 0;
                                                        
                                                                        $dtr_calculate = $mainsql->dtr_action($_POST, 'calculate');
                                                                        
                                                                        $dtr_data = $mainsql->get_dtr_bydate($profile_idnum, date("m/d/Y", $udate));  

                                                                        $shiftsched2 = $mainsql->get_schedshiftdtr($profile_idnum, $dates);       
                                                                        $sft = $mainsql->get_shift($shiftsched2[0]['ShiftID']);

                                                                        $dtimein = trim($dtr_data[0]['TimeIN']);
                                                                        $dtimeout = trim($dtr_data[0]['TimeOut']);
                                                                        
                                                                        $timein = date('h:ia', strtotime($sft[0]['TimeIN']));
                                                                        $timeout = date('h:ia', strtotime($sft[0]['TimeOUT']));

                                                                        $datein = strtotime($dates.' '.$timein);
                                                                        $dateout = strtotime($dates.' '.$timeout);

                                                                        $totaltime = $dateout - $datein;

                                                                        ?>
                                                                
                                                                        <script type="text/javascript">
                                                                            
                                                                            $(function() {	
                                                                                
                                                                                $("#mdtr_absent<?php echo $key; ?>").change(function() {
                            
                                                                                    arrayid = $(this).attr('attribute');        

                                                                                    shiftid = $("#mdtr_newsched" + arrayid).val();

                                                                                    dtrin = $("#mdtr_timein" + arrayid).attr('dtr');
                                                                                    dtrout = $("#mdtr_timeout" + arrayid).attr('dtr');	

                                                                                    dayin = $("#mdtr_dayin" + arrayid).val();
                                                                                    dayout = $("#mdtr_dayout" + arrayid).val();

                                                                                    //if (shiftid) {
                                                                                        $("#mdtr_timein" + arrayid).prop('readonly', false);
                                                                                        $("#mdtr_dayout" + arrayid).prop('readonly', false);
                                                                                        $("#mdtr_timeout" + arrayid).prop('readonly', false);
                                                                                        $("#mdtr_timein" + arrayid).timepicker("option", "disabled", false);
                                                                                        $("#mdtr_dayout" + arrayid).datepicker("option", "disabled", false);
                                                                                        $("#mdtr_timeout" + arrayid).timepicker("option", "disabled", false);
                                                                                    /*} else {
                                                                                        $("#mdtr_timein" + arrayid).prop('readonly', true);
                                                                                        $("#mdtr_dayout" + arrayid).prop('readonly', true);
                                                                                        $("#mdtr_timeout" + arrayid).prop('readonly', true);
                                                                                        $("#mdtr_timein" + arrayid).timepicker("option", "disabled", true);
                                                                                        $("#mdtr_dayout" + arrayid).datepicker("option", "disabled", true);
                                                                                        $("#mdtr_timeout" + arrayid).timepicker("option", "disabled", true);
                                                                                    }*/

                                                                                    if ($(this).is(':checked')) {

                                                                                        if (dtrin == 0) {
                                                                                            $("#mdtr_timein" + arrayid).val('');
                                                                                        }
                                                                                        if (dtrout == 0) {
                                                                                            $("#mdtr_timeout" + arrayid).val(''); 
                                                                                        }                                
                                                                                        $(".mdtr_hours" + arrayid).val('0');

                                                                                    } else {

                                                                                        if (dtrin == 0) {
                                                                                            $.ajax(
                                                                                            {
                                                                                                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=setmdin",
                                                                                                data: "shiftid=" + shiftid,
                                                                                                type: "POST",
                                                                                                complete: function(){
                                                                                                    $("#loading").hide();
                                                                                                },
                                                                                                success: function(data) {
                                                                                                    timein = data;
                                                                                                    $("#mdtr_timein" + arrayid).val(data);
                                                                                                }
                                                                                            })                          
                                                                                        } else {
                                                                                            timein = $("#mdtr_timein" + arrayid).val();
                                                                                        }

                                                                                        if (dtrout == 0) {                
                                                                                            $.ajax(
                                                                                            {
                                                                                                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=setmdout",
                                                                                                data: "shiftid=" + shiftid,
                                                                                                type: "POST",
                                                                                                complete: function(){
                                                                                                    $("#loading").hide();
                                                                                                },
                                                                                                success: function(data) {
                                                                                                    timeout = data;
                                                                                                    $("#mdtr_timeout" + arrayid).val(data);
                                                                                                    $.ajax(
                                                                                                    {
                                                                                                        url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=gethour",
                                                                                                        data: "dayin=" + dayin + "&timein=" + timein + "&dayout=" + dayout + "&timeout=" + timeout,
                                                                                                        type: "POST",
                                                                                                        complete: function(){
                                                                                                            $("#loading").hide();
                                                                                                        },
                                                                                                        success: function(data) {
                                                                                                            $(".mdtr_hours" + arrayid).val(data);
                                                                                                        }
                                                                                                    })  
                                                                                                }
                                                                                            })                                
                                                                                        } else {
                                                                                            timeout = $("#mdtr_timeout" + arrayid).val();
                                                                                            $.ajax(
                                                                                            {
                                                                                                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=gethour",
                                                                                                data: "dayin=" + dayin + "&timein=" + timein + "&dayout=" + dayout + "&timeout=" + timeout,
                                                                                                type: "POST",
                                                                                                complete: function(){
                                                                                                    $("#loading").hide();
                                                                                                },
                                                                                                success: function(data) {
                                                                                                    $(".mdtr_hours" + arrayid).val(data);
                                                                                                }
                                                                                            })  
                                                                                        }
                                                                                    }
                                                                                });
                        
                                                                                $(".mdtr_dayin<?php echo $key; ?>").change(function() {	
                                                                                    dayin = $(".mdtr_dayin<?php echo $key; ?>").val();
                                                                                    timein = $(".mdtr_timein<?php echo $key; ?>").val();
                                                                                    dayout = $(".mdtr_dayout<?php echo $key; ?>").val();
                                                                                    timeout = $(".mdtr_timeout<?php echo $key; ?>").val();

                                                                                    if (dayin && timein && dayout && timeout) {

                                                                                        $.ajax(
                                                                                        {
                                                                                            url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=gethour",
                                                                                            data: "dayin=" + dayin + "&timein=" + timein + "&dayout=" + dayout + "&timeout=" + timeout,
                                                                                            type: "POST",
                                                                                            complete: function(){
                                                                                                $("#loading").hide();
                                                                                            },
                                                                                            success: function(data) {
                                                                                                $(".mdtr_hours<?php echo $key; ?>").val(data);
                                                                                            }
                                                                                        })
                                                                                    }
                                                                                    else {
                                                                                        $(".mdtr_hours<?php echo $key; ?>").val('-1');
                                                                                    }                            
                                                                                });

                                                                                $(".mdtr_timein<?php echo $key; ?>").change(function() {	
                                                                                    dayin = $(".mdtr_dayin<?php echo $key; ?>").val();
                                                                                    timein = $(".mdtr_timein<?php echo $key; ?>").val();
                                                                                    dayout = $(".mdtr_dayout<?php echo $key; ?>").val();
                                                                                    timeout = $(".mdtr_timeout<?php echo $key; ?>").val();

                                                                                    if (dayin && timein && dayout && timeout) {

                                                                                        $.ajax(
                                                                                        {
                                                                                            url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=gethour",
                                                                                            data: "dayin=" + dayin + "&timein=" + timein + "&dayout=" + dayout + "&timeout=" + timeout,
                                                                                            type: "POST",
                                                                                            complete: function(){
                                                                                                $("#loading").hide();
                                                                                            },
                                                                                            success: function(data) {
                                                                                                $(".mdtr_hours<?php echo $key; ?>").val(data);
                                                                                            }
                                                                                        })
                                                                                    }
                                                                                    else {
                                                                                        $(".mdtr_hours<?php echo $key; ?>").val('-1');
                                                                                    }                            
                                                                                });

                                                                                $(".mdtr_dayout<?php echo $key; ?>").change(function() {	
                                                                                    dayin = $(".mdtr_dayin<?php echo $key; ?>").val();
                                                                                    timein = $(".mdtr_timein<?php echo $key; ?>").val();
                                                                                    dayout = $(".mdtr_dayout<?php echo $key; ?>").val();
                                                                                    timeout = $(".mdtr_timeout<?php echo $key; ?>").val();

                                                                                    if (dayin && timein && dayout && timeout) {

                                                                                        $.ajax(
                                                                                        {
                                                                                            url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=gethour",
                                                                                            data: "dayin=" + dayin + "&timein=" + timein + "&dayout=" + dayout + "&timeout=" + timeout,
                                                                                            type: "POST",
                                                                                            complete: function(){
                                                                                                $("#loading").hide();
                                                                                            },
                                                                                            success: function(data) {
                                                                                                $(".mdtr_hours<?php echo $key; ?>").val(data);
                                                                                            }
                                                                                        })
                                                                                    }
                                                                                    else {
                                                                                        $(".mdtr_hours<?php echo $key; ?>").val('-1');
                                                                                    }                            
                                                                                });

                                                                                $(".mdtr_timeout<?php echo $key; ?>").change(function() {	
                                                                                    dayin = $(".mdtr_dayin<?php echo $key; ?>").val();
                                                                                    timein = $(".mdtr_timein<?php echo $key; ?>").val();
                                                                                    dayout = $(".mdtr_dayout<?php echo $key; ?>").val();
                                                                                    timeout = $(".mdtr_timeout<?php echo $key; ?>").val();

                                                                                    if (dayin && timein && dayout && timeout) {

                                                                                        $.ajax(
                                                                                        {
                                                                                            url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=gethour",
                                                                                            data: "dayin=" + dayin + "&timein=" + timein + "&dayout=" + dayout + "&timeout=" + timeout,
                                                                                            type: "POST",
                                                                                            complete: function(){
                                                                                                $("#loading").hide();
                                                                                            },
                                                                                            success: function(data) {
                                                                                                $(".mdtr_hours<?php echo $key; ?>").val(data);
                                                                                            }
                                                                                        })
                                                                                    }
                                                                                    else {
                                                                                        $(".mdtr_hours<?php echo $key; ?>").val('-1');
                                                                                    }                            
                                                                                });

                                                                                $('.mdtr_dayout<?php echo $key; ?>').datepicker({ 
                                                                                    dateFormat: 'yy-mm-dd',
                                                                                    minDate: '<?php echo date("Y-m-d", strtotime($dates)); ?>',
                                                                                    maxDate: '<?php echo date("Y-m-d", strtotime($dates) + 86400); ?>'
                                                                                });
                                                                            });
                                                                        </script>

                                                                        <tr>
                                                                            <td class="centertalign"><?php echo $key; ?></td>
                                                                            <td class="centertalign"><input id="mdtr_absent<?php echo $key; ?>" type="checkbox" name="mdtr_absent[<?php echo $key; ?>]" attribute="<?php echo $key; ?>" class="mdtr_absent"></td>
                                                                            <td class="centertalign">
                                                                                <?php echo $days; ?>                 
                                                                                <input id="mdtr_dayin<?php echo $key; ?>" type="hidden" name="mdtr_dayin[<?php echo $key; ?>]" value="<?php echo $dates; ?>" class="mdtr_dayin<?php echo $key; ?>" />
                                                                            </td>
                                                                            <td class="centertalign">
                                                                                
                                                                                <?php //if ($dtimein) : 
                                                                                    //echo date('h:ia', strtotime($dtimein));
                                                                                    ?>
                                                                                    <!--input id="mdtr_timein<?php echo $key; ?>" type="hidden" name="mdtr_timein[<?php echo $key; ?>]" dtr="1" value="<?php echo date('h:ia', strtotime($dtimein)); ?>" class="mdtr_timein<?php echo $key; ?>" /-->
                                                                                    <?php
                                                                                //else :
                                                                                $timeinval = $dtimein ? date('h:ia', strtotime($dtimein)) : date('h:ia', strtotime($sft[0]['TimeIN']));
                                                                                ?>                            
                                                                                <input id="mdtr_timein<?php echo $key; ?>" type="text" name="mdtr_timein[<?php echo $key; ?>]" dtr="0" value="<?php echo $shiftsched2[0]['ShiftID'] ? $timeinval : ''; ?>" class="mdtr_timein<?php echo $key; ?> txtbox width70 timepick" readonly />
                                                                                <?php //endif; ?>
                                                                            </td>
                                                                            <td class="centertalign">
                                                                                <?php //if ($dtimeout) : 
                                                                                    //echo $dates;
                                                                                //else :
                                                                                ?>                   
                                                                                <input id="mdtr_dayout<?php echo $key; ?>" type="text" name="mdtr_dayout[<?php echo $key; ?>]" value="<?php echo $dates; ?>" class="mdtr_dayout<?php echo $key; ?> txtbox width70 datepick3" readonly />
                                                                                <?php //endif; ?></td>
                                                                            <td class="centertalign">
                                                                                <?php //if ($dtimeout) : 
                                                                                    //echo date('h:ia', strtotime($dtimeout));
                                                                                    ?>
                                                                                    <!--input id="mdtr_timeout<?php echo $key; ?>" type="hidden" name="mdtr_timeout[<?php echo $key; ?>]" dtr="1" value="<?php echo date('h:ia', strtotime($dtimeout)); ?>" class="mdtr_timeout<?php echo $key; ?>" /-->
                                                                                    <?php
                                                                                //else :
                                                                                $timeoutval = $dtimeout ? date('h:ia', strtotime($dtimeout)) : date('h:ia', strtotime($sft[0]['TimeOUT']));
                                                                                ?>                   
                                                                                <input id="mdtr_timeout<?php echo $key; ?>" type="text" name="mdtr_timeout[<?php echo $key; ?>]" dtr="0" value="<?php echo $shiftsched2[0]['ShiftID'] ? $timeoutval : ''; ?>" class="mdtr_timeout<?php echo $key; ?> txtbox width70 timepick" readonly />
                                                                                <?php //endif; ?>
                                                                            </td>
                                                                            <td class="centertalign">
                                                                                <input id="mdtr_hours<?php echo $key; ?>" type="hidden" name="mdtr_hours[<?php echo $key; ?>]" value="<?php echo $shiftsched2[0]['ShiftID'] ? $totaltime : 0; ?>" class="mdtr_hours<?php echo $key; ?>" />
                                                                                <?php echo $shiftsched2[0]['ShiftID'] ? $sft[0]['ShiftDesc'] : 'REST DAY'; ?>
                                                                                <input type="hidden" name="mdtr_shiftdesc[<?php echo $key; ?>]" value="<?php echo $shiftsched2[0]['ShiftID'] ? $sft[0]['ShiftDesc'] : 'REST DAY'; ?>" />
                                                                            </td>
                                                                            <td class="centertalign">
                                                                                <?php /*if ($dtimein && $dtimeout) : 
                                                                                    echo $shiftsched2[0]['ShiftID'] ? $sft[0]['ShiftDesc'] : 'REST DAY';
                                                                                else :*/
                                                                                ?>                        
                                                                                <select id="mdtr_newsched<?php echo $key; ?>" name="mdtr_newsched[<?php echo $key; ?>]" attribute="<?php echo $key; ?>" class="mdtr_newsched txtbox width95">
                                                                                    <option value=""<?php echo $sft  ? " selected" : ""; ?>>REST DAY</option>
                                                                                    <?php foreach ($shiftlist as $k => $v) : ?>
                                                                                    <option value="<?php echo $v['ShiftID']; ?>"<?php echo $v['ShiftID'] == $shiftsched2[0]['ShiftID'] ? " selected" : ""; ?>><?php echo $v['ShiftDesc']; ?></option>
                                                                                    <?php endforeach; ?>
                                                                                </select>   
                                                                                <?php //endif; ?>
                                                                            </td>
                                                                        </tr>

                                                                        <?php
                                                                        $key++;

                                                                        $mandtr_from = strtotime("+1 day", $mandtr_from);
                                                                    }

                                                                ?>  
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <i>* If there's something wrong with date or time represent within this application, please check your DTR first</i>
                                                    </td>
                                                </tr>
                                            </table>   
                                            <br><br>
                                            <i>* please check your DTR first to update recent schedule</i>   
                                        </div>
                                        <div id="lattach">
                                            <input type="file" name="attachment1" class="whitetext" /><br>
                                            <input type="file" name="attachment2" class="whitetext" /><br>
                                            <input type="file" name="attachment3" class="whitetext" /><br>
                                            <input type="file" name="attachment4" class="whitetext" /><br>
                                            <input type="file" name="attachment5" class="whitetext" />
                                            <br><br>
                                            <i>* it must be PDF or image (JPG or GIF) and not more than 200Kb each</i>
                                        </div>
                                        <div id="lapprover">
                                            <?php if ($md_app) : ?>
                                            <?php foreach($md_app as $key => $value) : ?>
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
                                        <input id="ndays" type="hidden" name="ndays" value="<?php echo $dayn; ?>" />
                                        <input type="hidden" name="empid" value="<?php echo $profile_idnum; ?>" />
                                        <input type="hidden" name="reqnbr" value="<?php echo "MD-".$finsec; ?>" />
                                        <input type="hidden" name="user" value="<?php echo $profile_idnum; ?>" />
                                        <input id="btnmdapply" type="submit" name="btnmdapply" value="Submit" class="btn margintop10" />
                                        <a href="<?php echo WEB; ?>/pending"><input type="button" name="btncancel" value="Cancel" class="redbtn margintop10" /></a>
                                    </div>
                                    
                                </form>
                                
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>