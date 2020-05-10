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

    if (in_array($profile_idnum, $adminarray2)) :
        $profile_level = 9;
    elseif ($_SESSION['megassep_admin']) :
        $profile_level = 10;
    else :
        $profile_level = 0;
    endif;

    $profile_hash = md5('2014'.$profile_idnum);

	$GLOBALS['level'] = $profile_level;

	//***************** USER MANAGEMENT - END *****************\\

    $sec = $profile_id ? $_GET['sec'] : NULL;

        switch ($sec) {
            case 'gethour':
            case 'getleaveapply':
            case 'getleaveday':
            case 'getleavepay':
            case 'luparam':
            case 'otparam':
            case 'chkholirest':
            case 'getovdtr':
            case 'getovdate1':
            case 'getovdate2':
            case 'getovhour':
            case 'gettrueto':
            case 'gettruefrom2':
			case 'gettrueto2':
            case 'gettrueto3':
            case 'setscin':
            case 'setscout':
            case 'getnpabut':
            case 'setmdin':
            case 'setmddayout':
            case 'setmdout':
			case 'getmdndays':
            case 'getwfhdays':
            case 'gettsndays':
            case 'getobndays':
            case 'getleavebalance':
            break;
            case 'getnpa':

                $dtr_data = $mainsql->get_dtr_bydate($profile_idnum, $_POST['date']);

                $ddatein = $dtr_data[0]['DTRDATE'];
                $ddateout = $dtr_data[0]['TimeOutDate'];

                //var_dump(date("Y-m-d", strtotime($ddateout)));
                //var_dump($ddatein.' '.$ddateout);
                ?>
                <script type="text/javascript">
                $("#npa_din").datepicker({
                    dateFormat: 'yy-mm-dd',
                    minDate: '<?php echo date("Y-m-d", strtotime($ddatein)); ?>',
                    maxDate: '<?php echo date("Y-m-d", strtotime($ddatein)); ?>'
                });
                $("#npa_dout").datepicker({
                    dateFormat: 'yy-mm-dd',
                    <?php if ($dtimeout) : ?>
                    minDate: '<?php echo date("Y-m-d", strtotime($ddateout)); ?>',
                    maxDate: '<?php echo date("Y-m-d", strtotime($ddateout)); ?>'
                    <?php else : ?>
                    minDate: '<?php echo date("Y-m-d", strtotime($ddatein)); ?>',
                    maxDate: '<?php echo date("Y-m-d", strtotime($ddatein) + 86400); ?>'
                    <?php endif; ?>
                });
                $('#npa_in').timepicker({
                    timeFormat: "hh:mmtt"
                });
                $('#npa_out').timepicker({
                    timeFormat: "hh:mmtt"
                });
                </script>
                <?php
            break;
            case 'getovshift':

                $odate = strtotime($_POST['odate']." 00:00:00");
                $otype = $_POST['otype'];

                $vdates = date("Y-m-d", $odate);

                // this is for holiday checking
                $monthnum = date("n", $odate);
                $daynum = date("j", $odate);

                $shiftsched = $mainsql->get_schedshift($profile_idnum);
                $dtr_data = $mainsql->get_dtr_bydate($profile_idnum, date("m/d/Y", $odate));

                $dtrin = $dtr_data[0]['TimeIN'];
                $dtrout = $dtr_data[0]['TimeOut'];

                $dtrtimein = $dtrin ? date('g:ia', strtotime($dtrin)) : 'NOT SET';
                $dtrtimeout = $dtrout ? date('g:ia', strtotime($dtrout)) : 'NOT SET';

                $dtr_text = $dtr_data ? $dtrtimein.' - '.$dtrtimeout : '';

                $chkdtrin = $dtrin ? date('g:ia', strtotime($dtrin)) : 0;
                $chkdtrout = $dtrout ? date('g:ia', strtotime($dtrout)) : 0;

                //var_dump($chkdtrout);

                $numdays = intval(date("N", $odate));

                if ($numdays == 1) :
                    $sft = $shiftsched[0]['MonShiftID'];
                    $sftsched = $mainsql->get_shift($sft);
                elseif ($numdays == 2) :
                    $sft = $shiftsched[0]['TueShiftID'];
                    $sftsched = $mainsql->get_shift($sft);
                elseif ($numdays == 3) :
                    $sft = $shiftsched[0]['WedShiftID'];
                    $sftsched = $mainsql->get_shift($sft);
                elseif ($numdays == 4) :
                    $sft = $shiftsched[0]['ThuShiftID'];
                    $sftsched = $mainsql->get_shift($sft);
                elseif ($numdays == 5) :
                    $sft = $shiftsched[0]['FriShiftID'];
                    $sftsched = $mainsql->get_shift($sft);
                elseif ($numdays == 6) :
                    $sft = $shiftsched[0]['SatShiftID'];
                    $sftsched = $mainsql->get_shift($sft);
                elseif ($numdays == 7) :
                    $sft = $shiftsched[0]['SunShiftID'];
                    $sftsched = $mainsql->get_shift($sft);
                endif;

                $shiftsched2 = $mainsql->get_schedshiftdtr($profile_idnum, $vdates);
                $sft2 = $shiftsched2[0]['ShiftID'];

                $thisholiday = $mainsql->get_holiday(1, $monthnum, $daynum, $profile_location);

                //var_dump($shiftsched2);

                if ($otype == 'Reg OT PM') :
                    $otimein = date("h:ia", strtotime($shiftsched2[0]['CreditTimeIN']));
                    $otimeout = date("h:ia", strtotime($shiftsched2[0]['CreditTimeOut']));
                    $dtimein = $dtr_data[0]['TimeIN'];
                    $dtimeout = $dtr_data[0]['TimeOut'];

                    $limitin1 = strtotime($otimein);
                    $limitin2 = strtotime($otimeout);
                    $limitout1 = strtotime($otimeout);
                    $limitout2 = strtotime($dtimeout ? $dtimeout : $otimeout);
                elseif ($otype == 'Reg OT AM') :
                    $otimein = date("h:ia", strtotime($shiftsched2[0]['CreditTimeIN']));
                    $otimeout = date("h:ia", strtotime($shiftsched2[0]['CreditTimeIN']));
                    $dtimein = $dtr_data[0]['TimeIN'];
                    $dtimeout = $dtr_data[0]['TimeOut'];

                    $limitin1 = strtotime($dtimein ? $dtimein : $otimein);
                    $limitin2 = strtotime($otimein);
                    $limitout1 = strtotime($otimein);
                    $limitout2 = strtotime($otimein);
                elseif ($otype == 'Regular Day') :
                    $otimein = date("h:ia", strtotime($shiftsched2[0]['CreditTimeIN']));
                    $otimeout = date("h:ia", strtotime($shiftsched2[0]['CreditTimeOut']));
                    $dtimein = $dtr_data[0]['TimeIN'];
                    $dtimeout = $dtr_data[0]['TimeOut'];

                    $limitin1 = strtotime($otimein);
                    $limitin2 = strtotime($otimein);
                    $limitout1 = strtotime($otimeout);
                    $limitout2 = strtotime($dtimeout ? $dtimeout : $otimeout);
                elseif ($otype == 'Rest Day') :
                    if (!$sft2) :
                        $otimein = date("h:ia", strtotime($shiftsched2[0]['CreditTimeIN']));
                        $otimeout = date("h:ia", strtotime($shiftsched2[0]['CreditTimeOut']));
                        $dtimein = $dtr_data[0]['TimeIN'];
                        $dtimeout = $dtr_data[0]['TimeOut'];

                        $limitin1 = strtotime($otimein);
                        $limitin2 = strtotime($otimein);
                        $limitout1 = strtotime($otimeout);
                        $limitout2 = strtotime($dtimeout ? $dtimeout : $otimeout);
                    endif;
                elseif ($otype == 'Holiday') :
                    if ($thisholiday) :
                        $otimein = date("h:ia", strtotime($shiftsched2[0]['CreditTimeIN']));
                        $otimeout = date("h:ia", strtotime($shiftsched2[0]['CreditTimeOut']));
                        $dtimein = $dtr_data[0]['TimeIN'];
                        $dtimeout = $dtr_data[0]['TimeOut'];

                        //var_dump($otimein);

                        $limitin1 = strtotime($otimein);
                        $limitin2 = strtotime($otimein);
                        $limitout1 = strtotime($otimeout);
                        $limitout2 = strtotime($dtimeout ? $dtimeout : $otimeout);
                    endif;
                endif;

                if ($sft2) :

                    if ($otype == 'Holiday' || $otype == 'Rest Day') :

                    ?>

                    <script type="text/javascript">
                        $('.datetimepickot1').datetimepicker('destroy');
                        $('.datetimepickot2').datetimepicker('destroy');
                        $('.datetimepickot1').datetimepicker({
                            dateFormat: 'yy-mm-dd',
                            timeFormat: "hh:mmtt",
                            minDate: '<?php echo date("Y-m-d", $odate); ?>',
                            maxDate: '<?php echo date("Y-m-d", $odate); ?>'
                        });

                        $('.datetimepickot2').datetimepicker({
                            dateFormat: 'yy-mm-dd',
                            timeFormat: "hh:mmtt",
                            minDate: '<?php echo date("Y-m-d", $odate); ?>',
                            maxDate: '<?php echo date("Y-m-d", $odate + 86400); ?>'
                        });
                    </script>

                    <?php

                    elseif ($otype == 'Regular Day') :

                    ?>

                    <script type="text/javascript">
                        $('.datetimepickot1').datetimepicker('destroy');
                        $('.datetimepickot2').datetimepicker('destroy');
                        $('.datetimepickot1').datetimepicker({
                            dateFormat: 'yy-mm-dd',
                            timeFormat: "hh:mmtt",
                            minDate: '<?php echo date("Y-m-d", $odate); ?>',
                            maxDate: '<?php echo date("Y-m-d", $odate); ?>',
                            maxTime: '<?php echo date("H:i:s", $limitin2); ?>'
                        });

                        $('.datetimepickot2').datetimepicker({
                            dateFormat: 'yy-mm-dd',
                            timeFormat: "hh:mmtt",
                            minDate: '<?php echo date("Y-m-d", $odate); ?>',
                            maxDate: '<?php echo date("Y-m-d", $odate + 86400); ?>'
                        });
                    </script>

                    <?php

                    elseif ($otype == 'Reg OT PM') :
                        $usftin = strtotime($shiftsched2[0]['CreditTimeIN']);
                        $usftout = strtotime($shiftsched2[0]['CreditTimeOut']);

                    ?>

                    <script type="text/javascript">
                        $('.datetimepickot1').datetimepicker('destroy');
                        $('.datetimepickot2').datetimepicker('destroy');
                        $('.datetimepickot1').datetimepicker({
                            dateFormat: 'yy-mm-dd',
                            timeFormat: "hh:mmtt",
                            <?php if ($usftin > $usftout) : ?>
                            minDate: '<?php echo date("Y-m-d", $odate + 86400); ?>',
                            maxDate: '<?php echo date("Y-m-d", $odate + 86400); ?>',
                            <?php else : ?>
                            minDate: '<?php echo date("Y-m-d", $odate); ?>',
                            maxDate: '<?php echo date("Y-m-d", $odate); ?>',
                            <?php endif; ?>
                            minTime: '<?php echo date("H:i:s", $limitin1); ?>'
                            //maxTime: '<?php echo date("H:i:s", $limitin2); ?>'
                        });

                        $('.datetimepickot2').datetimepicker({
                            dateFormat: 'yy-mm-dd',
                            timeFormat: "hh:mmtt",
                            <?php if ($usftin > $usftout) : ?>
                            minDate: '<?php echo date("Y-m-d", $odate + 86400); ?>',
                            maxDate: '<?php echo date("Y-m-d", $odate + 86400); ?>'
                            <?php else : ?>
                            minDate: '<?php echo date("Y-m-d", $odate); ?>',
                            <?php //if ($chkdtrout) : ?>
                            //maxDate: '<?php echo date("Y-m-d", $odate); ?>'
                            <?php //else : ?>
                            maxDate: '<?php echo date("Y-m-d", $odate + 86400); ?>'
                            <?php //endif; ?>
                            <?php endif; ?>

                            <?php if ($chkdtrout) : ?>//,
                            //minTime: '<?php echo date("H:i:s", $limitout1); ?>',
                            //maxTime: '<?php echo date("H:i:s", $limitout2); ?>'
                            <?php endif; ?>
                        });
                    </script>



                    <?php

                    elseif ($otype == 'Reg OT AM') :

                    ?>

                    <script type="text/javascript">
                        $('.datetimepickot1').datetimepicker('destroy');
                        $('.datetimepickot2').datetimepicker('destroy');
                        $('.datetimepickot1').datetimepicker({
                            dateFormat: 'yy-mm-dd',
                            timeFormat: "hh:mmtt",
                            minDate: '<?php echo date("Y-m-d", $odate); ?>',
                            maxDate: '<?php echo date("Y-m-d", $odate); ?>'
                            <?php if ($chkdtrin) : ?>,
                            minTime: '<?php echo date("H:i:s", $limitin1); ?>',
                            maxTime: '<?php echo date("H:i:s", $limitin2); ?>'
                            <?php endif; ?>
                        });

                        $('.datetimepickot2').datetimepicker({
                            dateFormat: 'yy-mm-dd',
                            timeFormat: "hh:mmtt",
                            minDate: '<?php echo date("Y-m-d", $odate); ?>',
                            maxDate: '<?php echo date("Y-m-d", $odate + 86400); ?>',
                            minTime: '<?php echo date("H:i:s", $limitout1); ?>',
                            maxTime: '<?php echo date("H:i:s", $limitout2); ?>'
                        });
                    </script>

                    <?php

                    else :

                    ?>

                    <script type="text/javascript">
                        $('.datetimepickot1').datetimepicker('destroy');
                        $('.datetimepickot2').datetimepicker('destroy');
                        $('.datetimepickot1').datetimepicker({
                            dateFormat: 'yy-mm-dd',
                            timeFormat: "hh:mmtt",
                            minDate: '<?php echo date("Y-m-d", $odate); ?>',
                            maxDate: '<?php echo date("Y-m-d", $odate); ?>'
                            <?php if ($chkdtrin) : ?>,
                            minTime: '<?php echo date("H:i:s", $limitin1); ?>',
                            maxTime: '<?php echo date("H:i:s", $limitin2); ?>'
                            <?php endif; ?>
                        });

                        $('.datetimepickot2').datetimepicker({
                            dateFormat: 'yy-mm-dd',
                            timeFormat: "hh:mmtt",
                            minDate: '<?php echo date("Y-m-d", $odate); ?>',
                            maxDate: '<?php echo date("Y-m-d", $odate + 86400); ?>'
                            <?php if ($chkdtrout) : ?>,
                            minTime: '<?php echo date("H:i:s", $limitout1); ?>',
                            maxTime: '<?php echo date("H:i:s", $limitout2); ?>'
                            <?php endif; ?>
                        });
                    </script>

                    <?php

                    endif;

                else :

                ?>

                    <script type="text/javascript">
                        $('.datetimepickot1').datetimepicker('destroy');
                        $('.datetimepickot2').datetimepicker('destroy');
                        $('.datetimepickot1').datetimepicker({
                            dateFormat: 'yy-mm-dd',
                            timeFormat: "hh:mmtt",
                            minDate: '<?php echo date("Y-m-d", $odate); ?>',
                            maxDate: '<?php echo date("Y-m-d", $odate); ?>'
                        });

                        $('.datetimepickot2').datetimepicker({
                            dateFormat: 'yy-mm-dd',
                            timeFormat: "hh:mmtt",
                            minDate: '<?php echo date("Y-m-d", $odate); ?>',
                            maxDate: '<?php echo date("Y-m-d", $odate + 86400); ?>'
                        });
                    </script>

                <?php

                endif;

            break;
            case 'getmandtr':
                ?>

                <script type="text/javascript">
                    $(".datepick3").datepicker({
                        dateFormat: 'yy-mm-dd',
                        maxDate: "62D",
                        changeMonth: true,
                        changeYear: true
                    });

                    $('.timepick').timepicker({
                        timeFormat: "hh:mmtt"
                    });

                    $(".mdtr_newsched").change(function() {

                        shiftid = $(this).val();
                        arrayid = $(this).attr('attribute');

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
                            $("#mdtr_timein" + arrayid).prop('readonly', false);
                            $("#mdtr_dayout" + arrayid).prop('readonly', false);
                            $("#mdtr_timeout" + arrayid).prop('readonly', false);
                            $("#mdtr_timein" + arrayid).timepicker("option", "disabled", true);
                            $("#mdtr_dayout" + arrayid).datepicker("option", "disabled", true);
                            $("#mdtr_timeout" + arrayid).timepicker("option", "disabled", true);
                        }*/

                        $.ajax(
                        {
                            url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=setmddayout",
                            data: "shiftid=" + shiftid + "&dayin=" + dayin,
                            type: "POST",
                            complete: function(){
                                $("#loading").hide();
                            },
                            success: function(data) {
                                $("#mdtr_dayout" + arrayid).val(data);
                            }
                        })

                        if ($("#mdtr_absent" + arrayid).is(':checked')) {
                            if (dtrin == 0) {
                                $("#mdtr_timein" + arrayid).val('');
                            }
                            if (dtrout == 0) {
                                $("#mdtr_timeout" + arrayid).val('');
                            }
                            $(".mdtr_hours" + arrayid).val('0');
                        }
                        else {

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
                </script>

            <?php
            break;
            case 'getwfh':
                ?>

                <script type="text/javascript">
                    $(".datepick3").datepicker({
                        dateFormat: 'yy-mm-dd',
                        maxDate: "62D",
                        changeMonth: true,
                        changeYear: true
                    });

                    $('.timepick').timepicker({
                        timeFormat: "hh:mmtt"
                    });
                </script>

            <?php
            break;
            case 'gettsched':
                ?>

                <script type="text/javascript">
                    $(".tsched_newsched").change(function() {

                        shiftid = $(this).val();
                        arrayid = $(this).attr('attribute');
                        $("#btnscapply").addClass("invisible");

                        $.ajax(
                        {
                            url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=setscin",
                            data: "shiftid=" + shiftid,
                            type: "POST",
                            complete: function(){
                                $("#loading").hide();
                            },
                            success: function(data) {
                                $("#ts_timein" + arrayid).html(data);
                                $("#tsched_timein" + arrayid).val(data);
                            }
                        })

                        $.ajax(
                        {
                            url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=setscout",
                            data: "shiftid=" + shiftid,
                            type: "POST",
                            complete: function(){
                                $("#loading").hide();
                            },
                            success: function(data) {
                                $("#ts_timeout" + arrayid).html(data);
                                $("#tsched_timeout" + arrayid).val(data);
                                $("#btnscapply").removeClass("invisible");
                            }
                        })

                    });
                </script>

            <?php
            break;
            case 'getleavesched':

            ?>

            <script type="text/javascript">;

                $(".leave_duration").change(function() {
                    var ltype = $("#leave_type").val();
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
                        data: "ltype=" + ltype + "&stype=" + sltype1 + "&sdate=" + sldate + "&empid=" + empid,
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
                        data: "ltype=" + ltype + "&stype=" + sltype2 + "&sdate=" + sldate + "&empid=" + empid,
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

                    var ltype = $("#leave_type").val();
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
                        data: "ltype=" + ltype + "&stype=" + sltype1 + "&sdate=" + sldate + "&empid=" + empid,
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
                        data: "ltype=" + ltype + "&stype=" + sltype2 + "&sdate=" + sldate + "&empid=" + empid,
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
            </script>

            <?php
            break;
            default :

                $odate = strtotime($_POST['odate']." 00:00:00");
                $otype = $_POST['otype'];

        ?>

        <script type="text/javascript">

        $(".datepick").datepicker({
            dateFormat: 'mm/dd/yy',
            minDate: "08/01/2014",
            maxDate: "0D",
            changeMonth: true,
            changeYear: true
        });

        $(".datepickchild").datepicker({
            dateFormat: 'yy-mm-dd',
            yearRange: "-80:+1",
            changeMonth: true,
            changeYear: true
        });

        $(".datepick2").datepicker({
            dateFormat: 'yy-mm-dd',
            maxDate: "0D",
            changeMonth: true,
            changeYear: true
        });

        $(".datepick3").datepicker({
            dateFormat: 'yy-mm-dd',
            maxDate: "62D",
            changeMonth: true,
            changeYear: true
        });

        $(".checkindate").datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: "-3M",
            maxDate: "12M",
            changeMonth: true
        });

        $('.timein').timepicker({
            timeFormat: 'h:mmtt',
            stepHour: 1,
            stepMinute: 30,
            hourMin: 6,
            hourMax: 22
        });

        $('.datetimepick').datetimepicker({
            dateFormat: 'yy-mm-dd',
            timeFormat: "hh:mmtt"
        });

        $('.timepick').timepicker({
            timeFormat: "hh:mmtt"
        });

    </script>

    <?php

        break;
    }

    switch ($sec) {
        case 'gethour':

            $dayin = $_POST['dayin'];
            $timein = $_POST['timein'];
            $dayout = $_POST['dayout'];
            $timeout = $_POST['timeout'];

            $datein = strtotime($dayin.' '.$timein);
            $dateout = strtotime($dayout.' '.$timeout);

            $totaltime = $dateout - $datein;

            echo $totaltime;

        break;
        case 'luparam':

            $_POST['strEMPID'] = $profile_idnum;
            $_POST['dteDTRDate'] = date("m/d/Y", $dfrom);
            $_POST['OVERWRITE'] = 0;
            $_POST['STATUS'] = 'INITIAL';

            $dtr_calculate = $mainsql->dtr_action($_POST, 'calculate');

            $odate = strtotime($_POST['odate']." 00:00:00");
            $otype = $_POST['otype'];
            $offset = strtotime($_POST['ooffset']." 00:00:00");

            $shiftsched = $mainsql->get_schedshift($profile_idnum);
            $numdays = intval(date("N", $odate));

            $monthnum = date("n", $odate);
            $daynum = date("j", $odate);

            //DTR CALCULATE

            $dtrcal['strEMPID'] = $profile_idnum;
            $dtrcal['dteDTRDate'] = date("m/d/Y", $odate);
            $dtrcal['OVERWRITE'] = 0;
            $dtrcal['STATUS'] = 'INITIAL';

            $dtr_calculate = $mainsql->dtr_action($dtrcal, 'calculate');

            //CHECK HOLIDAY

            $vdates = date("Y-m-d", $odate);
            $nxtdates = date("Y-m-d", $odate + 86400);
            $udates = date("U", $odate);
            $dates = date("M j", $odate);
            $days = date("D", $odate);
            $numdays = intval(date("N", $odate));

            $shiftsched2 = $mainsql->get_schedshiftdtr($profile_idnum, $_POST['odate']);
            $sft2 = $shiftsched2[0]['ShiftID'];

            if ($otype == 1) :
                $lutext = "Late Hours: ";
                $luhours = number_format($shiftsched2[0]['LateHrs'], 2);
            else :
                $lutext = "Undertime Hours: ";
                $luhours = number_format($shiftsched2[0]['UTHrs'], 2);
            endif;

            $ot_app = $mainsql->get_otdata_bydate($profile_idnum, $_POST['offset']);

            //echo $sft2;
            if ($sft2) : $shift_data = $mainsql->get_shift($sft2); endif;

            //GET OT DTR

            $dtr_data = $mainsql->get_dtr_bydate($profile_idnum, date("m/d/Y", $odate));

            $dtrin = $dtr_data[0]['TimeIN'];
            $dtrout = $dtr_data[0]['TimeOut'];

            $dtrtimein = $dtrin ? date('g:ia', strtotime($dtrin)) : 'NOT SET';
            $dtrtimeout = $dtrout ? date('g:ia', strtotime($dtrout)) : 'NOT SET';

            $dtr_text = $dtr_data ? $dtrtimein.' - '.$dtrtimeout : '';

            $ludtr = $sft2 ? $dtr_text : 'REST DAY';

            $sft = $mainsql->get_shift($shiftsched2[0]['ShiftID']);

            $lushift = $shiftsched2[0]['ShiftID'] ? $sft[0]['ShiftDesc'] : 'REST DAY';

            echo '{"ludtr": "'.$ludtr.'", "lushift": "'.$lushift.'", "lutext": "'.$lutext.'", "luhours": "'.$luhours.'", "othours": "'.($ot_app ? number_format($ot_app[0]['ApprovedHrs'], 2) : '0.00').'"}';

        break;
        case 'otparam':

            $_POST['strEMPID'] = $profile_idnum;
            $_POST['dteDTRDate'] = date("m/d/Y", $dfrom);
            $_POST['OVERWRITE'] = 0;
            $_POST['STATUS'] = 'INITIAL';

            $dtr_calculate = $mainsql->dtr_action($_POST, 'calculate');

            $timefrom = strtotime($_POST['ofrom']);
            $timeto = strtotime($_POST['oto']);

            $odate = strtotime($_POST['odate']." 00:00:00");
            $otype = $_POST['otype'];

            $shiftsched = $mainsql->get_schedshift($profile_idnum);
            $numdays = intval(date("N", $odate));

            $monthnum = date("n", $odate);
            $daynum = date("j", $odate);

            //DTR CALCULATE

            $dtrcal['strEMPID'] = $profile_idnum;
            $dtrcal['dteDTRDate'] = date("m/d/Y", $odate);
            $dtrcal['OVERWRITE'] = 0;
            $dtrcal['STATUS'] = 'INITIAL';

            $dtr_calculate = $mainsql->dtr_action($dtrcal, 'calculate');

            //CHECK HOLIDAY

            $vdates = date("Y-m-d", $odate);
            $nxtdates = date("Y-m-d", $odate + 86400);
            $udates = date("U", $odate);
            $dates = date("M j", $odate);
            $days = date("D", $odate);
            $numdays = intval(date("N", $odate));

            $shiftsched2 = $mainsql->get_schedshiftdtr($profile_idnum, $_POST['odate']);
            $sft2 = $shiftsched2[0]['ShiftID'];

            /*$restdaydate = $mainsql->get_restday($profile_idnum, date("m/d/Y", strtotime($vdates)));
            $appliedrestdaydate = $mainsql->get_appliedrestday($profile_idnum, date("m/d/Y", strtotime($vdates)), $profile_comp);

            $thisisrestday = $appliedrestdaydate[0]['RESTDAY'] ? 1 : $restdaydate[0]['DAYOFF'];*/

            $restdaydate = $mainsql->get_restday($profile_idnum, date("m/d/Y", strtotime($vdates)));
            $appliedrestdaydate = $mainsql->get_appliedrestday($profile_idnum, date("m/d/Y", strtotime($vdates)), $profile_comp);
            $appliedscheddate = $mainsql->get_appliedsched($profile_idnum, date("m/d/Y", strtotime($vdates)), $profile_comp);
            $appliedmdtrdate = $mainsql->get_mdtrrestday($profile_idnum, date("m/d/Y", strtotime($vdates)), $profile_comp);


            if ($appliedscheddate[0]['NEWSHIFTID']) :
                $thisisrestday = 0;
            elseif ($appliedmdtrdate[0]['RestDay']) :
                $thisisrestday = 1;
            else :
                $thisisrestday = $restdaydate[0]['DAYOFF'] ? 1 : $appliedrestdaydate[0]['RESTDAY'];
            endif;

            //echo $sft2;
            if ($sft2) : $shift_data = $mainsql->get_shift($sft2); endif;

            //GET OT DTR

            $dtr_data = $mainsql->get_dtr_bydate($profile_idnum, date("m/d/Y", $odate));

            $dtrin = $dtr_data[0]['TimeIN'];
            $dtrout = $dtr_data[0]['TimeOut'];

            $dtrtimein = $dtrin ? date('g:ia', strtotime($dtrin)) : 'NOT SET';
            $dtrtimeout = $dtrout ? date('g:ia', strtotime($dtrout)) : 'NOT SET';

            $dtr_text = $dtr_data ? $dtrtimein.' - '.$dtrtimeout : '';

            $chkdtrin = $dtrin ? date('g:ia', strtotime($dtrin)) : 0;
            $chkdtrout = $dtrout ? date('g:ia', strtotime($dtrout)) : 0;

            $otdtr = !$thisisrestday ? $dtr_text : 'REST DAY';


            $otimein = $shiftsched2[0]['CreditTimeIN'];
            $otimeout = $shiftsched2[0]['CreditTimeOut'];
            $ddayin = $dtr_data[0]['TimeOutDate'];
            $dtimein = $dtr_data[0]['TimeIN'];
            $dtimeout = $dtr_data[0]['TimeOut'];


            $oin = $vdates.' '.date('h:ia', strtotime($dtimein ? $dtimein : $otimein));
            $oout = ($dtimeout ? date('Y-m-d', strtotime($ddayin)) : $vdates).' '.date('h:ia', strtotime($dtimeout ? $dtimeout : $otimeout));


            $monthnumf = date("n", ($timefrom ? $timefrom : strtotime($oin)));
            $daynumf = date("j", ($timefrom ? $timefrom : strtotime($oin)));
            $monthnumt = date("n", ($timeto ? $timeto : strtotime($oout)));
            $daynumt = date("j", ($timeto ? $timeto : strtotime($oout)));


            /*$tholiday = $mainsql->get_holiday(1, $monthnum, $daynum, $profile_location);
            if ($tholiday) :
                $thisholiday = 1;
            else :
                $tholidayf = $mainsql->get_holiday(1, $monthnumf, $daynumf, $profile_location);
                $tholidayt = $mainsql->get_holiday(1, $monthnumt, $daynumt, $profile_location);
                //var_dump($monthnumf.' '.$daynumf);
                if ($tholidayf || $tholidayt) :
                    $thisholiday = 1;
                else :
                    $thisholiday = 0;
                endif;
            endif;*/

            $thisholiday = $mainsql->get_holiday(1, $monthnum, $daynum, $profile_location);
            //var_dump($thisholiday);

            if ($otype == 'Reg OT PM') :
                if ($thisisrestday || $thisholiday) : $holirest = 1; $hrest = 0;
                else : $holirest = 0; $hrest = 0; endif;
            elseif ($otype == 'Reg OT AM') :
                if ($thisisrestday || $thisholiday) : $holirest = 1; $hrest = 0;
                else : $holirest = 0; $hrest = 0; endif;
            elseif ($otype == 'Regular Day') :
                if ($thisisrestday || $thisholiday) : $holirest = 1; $hrest = 0;
                else : $holirest = 0; $hrest = 0; endif;
            elseif ($otype == 'Rest Day') :
                if (!$thisisrestday) : $holirest = 2; $hrest = 0;
                else : $holirest = 0; $hrest = 1; endif;
            elseif ($otype == 'Holiday') :
                if (!$thisholiday) : $holirest = 3; $hrest = 0;
                else : $holirest = 0; $hrest = 1; endif;
            endif;

            //var_dump($dtimein.' '.$dtimeout);

            if ($otype == 'Rest Day' || $otype == 'Holiday') :
                $noinot = $dtrin ? 0 : 1;
            else :
                $noinot = 0;
            endif;


            //GET OT IN

            if ($otype == 'Reg OT PM') :

                $otimeout = $mainsql->get_otout($profile_idnum, date("m/d/Y", $odate));

                //var_dump($otimeout);

                $usfttruein = strtotime($otimein);
                $usftin = strtotime('Jan  1 1900 '.$otimeout[0]['TimeOut']);
                $usftout = strtotime('Jan  1 1900 '.$otimeout[0]['TimeOut']);
                if ($usfttruein > $usftout) :
                    $sftin = $nxtdates.' '.date('h:ia', strtotime($otimeout[0]['TimeOut']));
                else :
                    $sftin = $vdates.' '.date('h:ia', strtotime($otimeout[0]['TimeOut']));
                endif;
                if ($usftin > $usftout) :
                    $sftout = $nxtdates.' '.date('h:ia', strtotime($otimeout[0]['TimeOut']));
                else :
                    if ($usfttruein > $usftout) :
                        $sftout = $nxtdates.' '.date('h:ia', strtotime($otimeout[0]['TimeOut']));
                    else :
                        $sftout = $vdates.' '.date('h:ia', strtotime($otimeout[0]['TimeOut']));
                    endif;
                endif;
                //var_dump($otimein.' '.$otimeout[0]['TimeOut']);
                if ($usfttruein > $usftout) :
                    $otin = $nxtdates.' '.date('h:ia', strtotime($otimeout[0]['TimeOut']));
                else :
                    $otin = $vdates.' '.date('h:ia', strtotime($otimeout[0]['TimeOut']));
                endif;
            elseif ($otype == 'Reg OT AM') :

                $usftin = strtotime($otimein);
                $usftout = strtotime($otimein);
                $sftin = $vdates.' '.date('h:ia', strtotime($otimein));
                if ($usftin > $usftout) :
                    $sftout = $nxtdates.' '.date('h:ia', strtotime($otimein));
                else :
                    $sftout = $vdates.' '.date('h:ia', strtotime($otimein));
                endif;

                $otin = $vdates.' '.date('h:ia', strtotime($dtimein ? $dtimein : $otimein));
            elseif ($otype == 'Regular Day') :

                $usftin = strtotime($otimein);
                $usftout = strtotime($otimeout);
                $sftin = $vdates.' '.date('h:ia', strtotime($otimein));
                if ($usftin > $usftout) :
                    $sftout = $nxtdates.' '.date('h:ia', strtotime($otimeout));
                else :
                    $sftout = $vdates.' '.date('h:ia', strtotime($otimeout));
                endif;

                $otin = $vdates.' '.date('h:ia', strtotime($dtimein ? $dtimein : $otimein));
            elseif ($otype == 'Rest Day') :
                if ($thisisrestday) :

                    $usftin = strtotime($otimein);
                    $usftout = strtotime($otimeout);
                    $sftin = $vdates.' '.date('h:ia', strtotime($otimein));
                    if ($usftin > $usftout) :
                        $sftout = $nxtdates.' '.date('h:ia', strtotime($otimeout));
                    else :
                        $sftout = $vdates.' '.date('h:ia', strtotime($otimeout));
                    endif;

                    $otin = $vdates.' '.date('h:ia', strtotime($dtimein ? $dtimein : $otimein));
                endif;
            elseif ($otype == 'Holiday') :
                if ($thisholiday) :

                    $usftin = strtotime($otimein);
                    $usftout = strtotime($otimeout);
                    $sftin = $vdates.' '.date('h:ia', strtotime($otimein));
                    if ($usftin > $usftout) :
                        $sftout = $nxtdates.' '.date('h:ia', strtotime($otimeout));
                    else :
                        $sftout = $vdates.' '.date('h:ia', strtotime($otimeout));
                    endif;

                    $otin = $vdates.' '.date('h:ia', strtotime($dtimein ? $dtimein : $otimein));
                endif;
            endif;

            //GET OT OUT

            if ($otype == 'Reg OT PM') :
                $vdates2 = date("Y-m-d", $odate);
                $otout = ($dtimeout ? date('Y-m-d', strtotime($ddayin)) : $vdates).' '.date('h:ia', strtotime($dtimeout ? $dtimeout : $otimeout));
            elseif ($otype == 'Reg OT AM') :
                $otout = $vdates.' '.date('h:ia', strtotime($otimein));
            elseif ($otype == 'Regular Day') :
                $otout = ($dtimeout ? date('Y-m-d', strtotime($ddayin)) : $vdates).' '.date('h:ia', strtotime($dtimeout ? $dtimeout : $otimeout));
            elseif ($otype == 'Rest Day') :
                if ($thisisrestday) :
                    $otout = ($dtimeout ? date('Y-m-d', strtotime($ddayin)) : $vdates).' '.date('h:ia', strtotime($dtimeout ? $dtimeout : $otimeout));
                endif;
            elseif ($otype == 'Holiday') :
                if ($thisholiday) :
                    $otout = ($dtimeout ? date('Y-m-d', strtotime($ddayin)) : $vdates).' '.date('h:ia', strtotime($dtimeout ? $dtimeout : $otimeout));
                endif;
            endif;

            echo '{"holirest": "'.$holirest.'", "otdtr": "'.$otdtr.'", "otin": "'.$otin.'", "otout": "'.$otout.'", "sftin": "'.$sftin.'", "sftout": "'.$sftout.'", "chkdtrin": "'.$chkdtrin.'", "chkdtrout": "'.$chkdtrout.'", "hrest": "'.$hrest.'", "noinot": "'.$noinot.'"}';

        break;
        case 'chkholirest':

            $odate = strtotime($_POST['odate']." 00:00:00");
            $otype = $_POST['otype'];

            $shiftsched = $mainsql->get_schedshift($profile_idnum);
            $numdays = intval(date("N", $odate));

            $monthnum = date("n", $odate);
            $daynum = date("j", $odate);

            $shiftsched2 = $mainsql->get_schedshiftdtr($profile_idnum, $_POST['odate']);
            $sft2 = $shiftsched2[0]['ShiftID'];

            $thisholiday = $mainsql->get_holiday(1, $monthnum, $daynum, $profile_location);

            if ($otype == 'Reg OT PM') :
                if (!$sft2 || $thisholiday) : echo 1;
                else : echo 0; endif;
            elseif ($otype == 'Reg OT AM') :
                if (!$sft2 || $thisholiday) : echo 1;
                else : echo 0; endif;
            elseif ($otype == 'Regular Day') :
                if (!$sft2 || $thisholiday) : echo 1;
                else : echo 0; endif;
            elseif ($otype == 'Rest Day') :
                if ($sft2) : echo 2;
                else : echo 0; endif;
            elseif ($otype == 'Holiday') :
                if (!$thisholiday) : echo 3;
                else : echo 0; endif;
            endif;

        break;
        case 'getovshift':

            $odate = strtotime($_POST['odate']." 00:00:00");

            $shiftsched = $mainsql->get_schedshift($profile_idnum);
            $shiftsched2 = $mainsql->get_schedshiftdtr($profile_idnum, $_POST['odate']);

            //var_dump($shiftsched);

            $vdates = date("Y-m-d", $odate);
            $udates = date("U", $odate);
            $dates = date("M j", $odate);
            $days = date("D", $odate);
            $numdays = intval(date("N", $odate));

            $sft = $mainsql->get_shift($shiftsched2[0]['ShiftID']);
            $shiftdesc = $shiftsched2[0]['ShiftID'] ? $sft[0]['ShiftDesc'] : $shiftsched2[0]['ShiftDesc'];

            echo $shiftdesc ? $shiftdesc : 'REST DAY';

            //echo $shiftsched2[0]['ShiftID'];

        break;

        case 'getovhour':

            $timefrom = strtotime($_POST['ofrom']);
            $timeto = strtotime($_POST['oto']);

            $odate = strtotime($_POST['odate']." 00:00:00");
            $otype = $_POST['otype'];

            // this is for holiday checking
            $monthnum = date("n", $odate);
            $daynum = date("j", $odate);

            $dtr_data = $mainsql->get_dtr_bydate($profile_idnum, date("m/d/Y", $odate));

            $vdates = date("Y-m-d", $odate);
            $udates = date("U", $odate);
            $dates = date("M j", $odate);
            $days = date("D", $odate);
            $numdays = intval(date("N", $odate));

            $shiftsched2 = $mainsql->get_schedshiftdtr($profile_idnum, $_POST['odate']);
            $sft2 = $shiftsched2[0]['ShiftID'];

	        $shift_desc = $mainsql->get_shift($sft2);

            $otimein = $shiftsched2[0]['CreditTimeIN'];
            $otimeout = $shiftsched2[0]['CreditTimeOut'];
            $ddayin = $dtr_data[0]['TimeOutDate'];
            $dtimein = $dtr_data[0]['TimeIN'];
            $dtimeout = $dtr_data[0]['TimeOut'];


            $oin = $vdates.' '.date('h:ia', strtotime($dtimein ? $dtimein : $otimein));
            $oout = ($dtimeout ? date('Y-m-d', strtotime($ddayin)) : $vdates).' '.date('h:ia', strtotime($dtimeout ? $dtimeout : $otimeout));

            $monthnumf = date("n", ($timefrom ? $timefrom : strtotime($oin)));
            $daynumf = date("j", ($timefrom ? $timefrom : strtotime($oin)));
            $monthnumt = date("n", ($timeto ? $timeto : strtotime($oout)));
            $daynumt = date("j", ($timeto ? $timeto : strtotime($oout)));

            /*$tholiday = $mainsql->get_holiday(1, $monthnum, $daynum, $profile_location);
            if ($tholiday) :
                $thisholiday = 1;
            else :
                $tholidayf = $mainsql->get_holiday(1, $monthnumf, $daynumf, $profile_location);
                $tholidayt = $mainsql->get_holiday(1, $monthnumt, $daynumt, $profile_location);
                //var_dump($monthnumf.' '.$daynumf);
                if ($tholidayf || $tholidayt) :
                    $thisholiday = 1;
                else :
                    $thisholiday = 0;
                endif;
            endif;*/

            $thisholiday = $mainsql->get_holiday(1, $monthnum, $daynum, $profile_location);

            $sft_breakhrs = $shift_desc[0]['BreakHours'];
            $sft_breakin = strtotime($_POST['odate']." ".$shift_desc[0]['BreakIN']);
            $sft_breakout = strtotime($_POST['odate']." ".$shift_desc[0]['BreakOUT']);

            $restdaydate = $mainsql->get_restday($profile_idnum, date("m/d/Y", strtotime($vdates)));
            $appliedrestdaydate = $mainsql->get_appliedrestday($profile_idnum, date("m/d/Y", strtotime($vdates)), $profile_comp);

            $thisisrestday = $appliedrestdaydate[0]['RESTDAY'] ? 1 : $restdaydate[0]['DAYOFF'];

            if ($sft2) :

                if ($otype == 'Reg OT PM') :

                    if ($timefrom && $timeto) :
                        $otimein = date("Y-m-d", $timefrom).' '.date("h:ia", strtotime($shiftsched2[0]['CreditTimeOut']));
                        $otimeout = date("Y-m-d", $timeto).' '.date("h:ia", strtotime($shiftsched2[0]['CreditTimeOut']));
                        $dtimein = date("Y-m-d h:ia", $timefrom);
                        $dtimeout = date("Y-m-d h:ia", $timeto);
                    else :
                        $otimein = $vdates.' '.date("h:ia", strtotime($shiftsched2[0]['CreditTimeOut']));
                        $otimeout = $vdates.' '.date("h:ia", strtotime($shiftsched2[0]['CreditTimeOut']));
                        $dtimein = $dtr_data[0]['TimeIN'];
                        $dtimeout = $dtr_data[0]['TimeOut'];
                    endif;

                    $in = strtotime($dtimein);
                    $out = strtotime($dtimeout ? $dtimeout : $otimeout);

                    $hours = floor((($out - $in) / 3600) * 2) / 2;

                elseif ($otype == 'Reg OT AM') :

                    if ($timefrom && $timeto) :
                        $otimein = date("Y-m-d", $timefrom).' '.date("h:ia", strtotime($shiftsched2[0]['CreditTimeIN']));
                        $otimeout = date("Y-m-d", $timeto).' '.date("h:ia", strtotime($shiftsched2[0]['CreditTimeIN']));
                        $dtimein = date("Y-m-d h:ia", $timefrom);
                        $dtimeout = date("Y-m-d h:ia", $timeto);
                    else :
                        $otimein = $vdates.' '.date("h:ia", strtotime($shiftsched2[0]['CreditTimeIN']));
                        $otimeout = $vdates.' '.date("h:ia", strtotime($shiftsched2[0]['CreditTimeIN']));
                        $dtimein = $dtr_data[0]['TimeIN'];
                        $dtimeout = $dtr_data[0]['TimeOut'];
                    endif;

                    $in = strtotime($dtimein ? $dtimein : $otimein);
                    $out = strtotime($otimein);

                    //var_dump($hout.' '.$hin);

                    $hours = number_format(($out - $in) / 3600, 1);

                elseif ($otype == 'Regular Day') :

                    if ($timefrom && $timeto) :
                        $otimein = date("Y-m-d", $timefrom).' '.date("h:ia", strtotime($shiftsched2[0]['CreditTimeIN']));
                        $otimeout = $vdates.' '.date("h:ia", strtotime($shiftsched2[0]['CreditTimeOut']));
                        $dtimein = date("Y-m-d h:ia", $timefrom);
                        $dtimeout = date("Y-m-d h:ia", $timeto);
                    else :
                        $otimein = $vdates.' '.date("h:ia", strtotime($shiftsched2[0]['CreditTimeIN']));
                        $otimeout = $vdates.' '.date("h:ia", strtotime($shiftsched2[0]['CreditTimeOut']));
                        $dtimein = $dtr_data[0]['TimeIN'];
                        $dtimeout = $dtr_data[0]['TimeOut'];
                    endif;

                    $in = strtotime($dtimein ? $dtimein : $otimein);
                    $out = strtotime($dtimeout ? $dtimeout : $otimeout);
                    $din = strtotime($otimein);
                    $dout = strtotime($otimeout);

                    //var_dump($dtimein.' '.$dtimeout.' '.$otimein.' '.$otimeout);

                    $hours = (floor((($out - $dout) / 3600) * 2) / 2) + (floor((($din - $in) / 3600) * 2) / 2);

                elseif ($otype == 'Rest Day') :
                    if ($thisisrestday) :
                        if ($timefrom && $timeto) :
                            $otimein = date("Y-m-d", $timefrom).' '.date("h:ia", strtotime($shiftsched2[0]['CreditTimeIN']));
                            $otimeout = date("Y-m-d", $timeto).' '.date("h:ia", strtotime($shiftsched2[0]['CreditTimeOut']));
                            $dtimein = date("Y-m-d h:ia", $timefrom);
                            $dtimeout = date("Y-m-d h:ia", $timeto);
                        else :
                            $otimein = $vdates.' '.date("h:ia", strtotime($shiftsched2[0]['CreditTimeIN']));
                            $otimeout = $vdates.' '.date("h:ia", strtotime($shiftsched2[0]['CreditTimeOut']));
                            $dtimein = $dtr_data[0]['TimeIN'];
                            $dtimeout = $dtr_data[0]['TimeOut'];
                        endif;

                        $in = strtotime($dtimein ? $dtimein : $otimein);
                        $out = strtotime($dtimeout ? $dtimeout : $otimeout);

                        $hours = number_format(($out - $in) / 3600, 1);
                    endif;
                elseif ($otype == 'Holiday') :
                    if ($thisholiday) :
                        if ($timefrom && $timeto) :
                            $otimein = date("Y-m-d", $timefrom).' '.date("h:ia", strtotime($shiftsched2[0]['CreditTimeIN']));
                            $otimeout = date("Y-m-d", $timeto).' '.date("h:ia", strtotime($shiftsched2[0]['CreditTimeOut']));
                            $dtimein = date("Y-m-d h:ia", $timefrom);
                            $dtimeout = date("Y-m-d h:ia", $timeto);
                        else :
                            $otimein = $vdates.' '.date("h:ia", strtotime($shiftsched2[0]['CreditTimeIN']));
                            $otimeout = $vdates.' '.date("h:ia", strtotime($shiftsched2[0]['CreditTimeOut']));
                            $dtimein = $dtr_data[0]['TimeIN'];
                            $dtimeout = $dtr_data[0]['TimeOut'];
                        endif;

                        $in = strtotime($dtimein ? $dtimein : $otimein);
                        $out = strtotime($dtimeout ? $dtimeout : $otimeout);

                        $hours = number_format(($out - $in) / 3600, 1);
                    endif;
                endif;

                /*if ($otype == 'Rest Day') :
                    if ($hours >= 9) :
                        $hours = $hours - 1;
                    endif;
                elseif ($otype == 'Holiday') :
                    if ($sft_breakhrs) :
                        if ($timeto >= $sft_breakout) :
                            $hours = $hours - 1;
                        endif;
                    endif;
                endif;*/

            else :

                if ($timefrom && $timeto) :
                    $otimein = date("Y-m-d h:ia", $timefrom);
                    $otimeout = date("Y-m-d h:ia", $timeto);
                endif;

                $in = strtotime($otimein);
                $out = strtotime($otimeout);

                $hours = number_format(($out - $in) / 3600, 1);

                if ($otype == 'Regular Day') :
                    if ($hours >= 9) :
                        $hours = $hours - 9;
                    endif;
                /*elseif ($otype == 'Rest Day' || $otype == 'Holiday') :
                    if ($hours >= 9) :
                        $hours = $hours - 1;
                    endif;            */
                endif;

            endif;

            //echo $out.' '.$in;
            $hours = $hours < 1 ? 0 : $hours;
            echo (($out <= $in) ? 0 : floor($hours * 2) / 2);

        break;

        case 'getleavesched':

            $leave_type = $_POST['type'];

            $leave_from = strtotime($_POST['from']." 00:00:00");
            $leave_to = strtotime($_POST['to']." 23:59:59");
	    //if($leave_type == 'L01' || $leave_type == 'L02' || $leave_type == 'L03'){
		//echo "<script>alert('$leave_type Vacation Leave/Sick Leave/Emergency Leave will be suspended until further notice.'); $('#btnleaveapply').hide();</script>";
	    //}else{
		//echo "<script>$('#btnleaveapply').show();</script>";
	    //}
            ?>

            <table width="100%" class="tdatamid vsmalltext" border="0" cellspacing="0">

            <?php

            if ($leave_from > $leave_to) :
            ?>

                <tr>
                    <td colspan="5" class="centertalign">Your date range is invalid</td>
                </tr>

            <?php

            else :

                $i = 0;

                while($leave_from <= $leave_to) {

                    $vdates = date("Y-m-d", $leave_from);
                    $wdates = date("m/d/Y", $leave_from);
                    $udates = date("U", $leave_from);
                    $dates = date("M j", $leave_from);
                    $days = date("D", $leave_from);
                    $numdays = intval(date("N", $leave_from));
                    $shiftsched2 = $mainsql->get_schedshiftdtr($profile_idnum, $vdates);
                    $sft2 = $shiftsched2[0]['ShiftID'];
                    echo "<!-- ".$vdates. '=' . $sft2 ." -->";

                    if (!$sft2) :
                        $shiftsched2 = $mainsql->get_scheddef($profile_idnum, $vdates);
                        $sft2 = $shiftsched2[0]['SHIFTID'];
                    endif;

                    $ddisplay = $sft2 ? 1 : 0;
                    //$ddisplay = 1;

                    if ($vdates >= '2017-12-26' && $vdates <= '2017-12-29') :
                        $wdhours = 8;
                        $hdhours = 4;
                    //elseif ($vdates == '2018-03-28') :
                        //$wdhours = 6;
                        //$hdhours = 3;
                    else :

                        if ($leave_type == 'L01' || $leave_type == 'L03') :
                            if ($sft2) :
                                $getnumhours = $mainsql->get_shift($sft2);

                                $wdhours = $getnumhours[0]['NUMHrs'] - $getnumhours[0]['BreakHours'];
                                if ($getnumhours[0]['NUMHrs'] <= 4) :
                                    $hdhours = $getnumhours[0]['NUMHrs'] - $getnumhours[0]['BreakHours'];
                                else :
                                    $hdhours = ($getnumhours[0]['NUMHrs'] - $getnumhours[0]['BreakHours']) / 2;
                                endif;
                            else :
                                if ($days == 'Sat' || $days == 'Sun') :
                                    $getnumhours[0]['NUMHrs'] = 4;
                                    $wdhours = 4;
                                    $hdhours = 4;
                                else :
                                    $getnumhours[0]['NUMHrs'] = 8;
                                    $wdhours = 8;
                                    $hdhours = 4;
                                endif;
                            endif;
                        elseif ($leave_type == 'L12') :
                            $getnumhours[0]['NUMHrs'] = 8;
                            $wdhours = 8;
                            $hdhours = 8;

                        elseif ($leave_type == 'L04' || $leave_type == 'L05') :
                            if ($sft2) :
                                $getnumhours = $mainsql->get_shift($sft2);

                                $wdhours = $getnumhours[0]['NUMHrs'] - $getnumhours[0]['BreakHours'];
                                if ($getnumhours[0]['NUMHrs'] <= 4) :
                                    $hdhours = $getnumhours[0]['NUMHrs'] - $getnumhours[0]['BreakHours'];
                                else :
                                    $hdhours = ($getnumhours[0]['NUMHrs'] - $getnumhours[0]['BreakHours']) / 2;
                                endif;
                            else :
                                if ($days == 'Sat' || $days == 'Sun') :
                                    $getnumhours[0]['NUMHrs'] = 4;
                                    $wdhours = 4;
                                    $hdhours = 4;
                                else :
                                    $getnumhours[0]['NUMHrs'] = 8;
                                    $wdhours = 8;
                                    $hdhours = 4;
                                endif;
                            endif;
                        else :
                            if ($days == 'Sat' || $days == 'Sun') :
                                $getnumhours[0]['NUMHrs'] = 4;
                                $wdhours = 4;
                                $hdhours = 4;
                            else :
                                $getnumhours[0]['NUMHrs'] = 8;
                                $wdhours = 8;
                                $hdhours = 4;
                            endif;
                        endif;

                    endif;

                    // this is for holiday checking
                    $monthnum = date("n", $leave_from);
                    $daynum = date("j", $leave_from);

                    $thisholiday = $mainsql->get_holiday(1, $monthnum, $daynum, $profile_location);
                    $restdaydate = $mainsql->get_restday($profile_idnum, $wdates);
                    $appliedrestdaydate = $mainsql->get_appliedrestday($profile_idnum, $wdates, $profile_comp);
                    $appliedscheddate = $mainsql->get_appliedsched($profile_idnum, $wdates, $profile_comp);
                    echo "<!-- company:   $profile_comp -->";
                    if ($appliedscheddate[0]['NEWSHIFTID']) :
                        $thisisrestday = 0;
                    else :
                        $thisisrestday = $restdaydate[0]['DAYOFF'] ? 1 : $appliedrestdaydate[0]['RESTDAY'];
                    endif;

                    if ((!$thisisrestday && !$thisholiday) || $leave_type == 'L04') :
                    ?>

                    <tr>
                        <td width="20%" class="centertalign">
                            <input id="leave_date[<?php echo $i; ?>]" type="hidden" name="leave_date[<?php echo $i; ?>]" value="<?php echo $vdates; ?>" />
                            <?php echo $days; ?><br><?php echo $dates; ?>
                        </td>
                        <td width="40%" class="centertalign">
                            <select name="leave_duration[<?php echo $i; ?>]" id="leave_duration[<?php echo $i; ?>]" attribute="<?php echo $udates; ?>" class="leave_duration smltxtbox width95per" <?php echo $leave_type == 'L04' ? '' : ''; ?>>
                                <option value="<?php echo 'WD' //echo $wdhours; ?>"<?php echo ($getnumhours[0]['NUMHrs'] == 9 || $leave_type == 'L04') ? ' selected' : ''; ?>>Whole-Day</option>
                                <option value="<?php echo 'HD1' //echo $hdhours; ?>"<?php echo ($getnumhours[0]['NUMHrs'] == 4 && $leave_type != 'L04') ? ' selected' : ''; echo ($leave_type == 'L04') ? 'style="display:none;"' : '';?>>Half-Day AM</option>
                                <option value="<?php echo 'HD2' //echo $hdhours; ?>" <?php echo ($leave_type == 'L04') ? 'style="display:none;"' : ''; ?>>Half-Day PM</option>
				                <option value="0" attribute="0" <?php echo ($leave_type == 'L04') ? 'style="display:none;"' : ''; ?>>None</option>
                            </select>
                        </td>
                        <td width="20%" class="centertalign">
							<input type="checkbox" name="leave_pay[<?php echo $i; ?>]" id="leave_pay[<?php echo $i; ?>]" value="1" attribute="<?php echo $udates; ?>" class="leave_pay" <?php echo $leave_type == 'L04' ? 'checked onclick="return false;"' : 'checked'; ?>/>
						</td>
                        <td width="20%" class="centertalign">OPEN</td>
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

            endif;
            ?>
			<input type="checkbox" style="display:none" id="clickUpdate" attribute="<?php echo $udates; ?>" class="leave_pay"/>
            </table>
			<script>$('#clickUpdate').trigger('click');</script>
            <?php
        break;

        case 'getleaveapply':

            $leave_type = $_POST['type'];
            $leave_from = strtotime($_POST['from']." 00:00:00");
            $leave_to = strtotime($_POST['to']." 23:59:59");

            if ($leave_from < $leave_to) :

                $shiftsched = $mainsql->get_schedshift($profile_idnum);

                $total_day = 0;
                while($leave_from <= $leave_to) {

                    $vdates = date("Y-m-d", $leave_from);
                    $wdates = date("m/d/Y", $leave_from);
                    $numdays = intval(date("N", $leave_from));
                    $days = date("D", $leave_from);

                    $shiftsched2 = $mainsql->get_schedshiftdtr($profile_idnum, $vdates);
                    $sft2 = trim($shiftsched2[0]['ShiftID']);

                    //var_dump($sft2);


                    if (!$sft2) :
                        $shiftsched2 = $mainsql->get_scheddef($profile_idnum, $vdates);
                        $sft2 = trim($shiftsched2[0]['SHIFTID']);
                    endif;

                    //var_dump($vdates);

                    if ($profile_compressed) :
                        if ($vdates >= '2017-12-26' && $vdates <= '2017-12-29') :
                            $hours = 8;
                            //echo $vdates.' H';
                        //elseif ($vdates == '2018-03-28') :
                            //$hours = 6;
                        else :

                            if ($leave_type == 'L01' || $leave_type == 'L03') :
                                if ($sft2) :
                                    $dayshift = $mainsql->get_shift($sft2);
                                    if ($dayshift[0]['NUMHrs'] > 9) :
                                        $hours = 9;
                                    else :
                                        $hours = $dayshift[0]['NUMHrs'] - $dayshift[0]['BreakHours'];
                                    endif;
                                else :
                                    if ($days == 'Sat' || $days == 'Sun') :
                                        $hours = 4;
                                    else :
                                        $hours = 8;
                                    endif;
                                endif;
                            elseif ($leave_type == 'L12') :
                                $hours = 8;
                            elseif ($leave_type == 'L04' || $leave_type == 'L05') :
                                if ($sft2) :
                                    $dayshift = $mainsql->get_shift($sft2);
                                    if ($dayshift[0]['NUMHrs'] > 9) :
                                        $hours = 8;
                                    else :
                                        $hours = $dayshift[0]['NUMHrs'] - $dayshift[0]['BreakHours'];
                                    endif;
                                else :
                                    if ($days == 'Sat' || $days == 'Sun') :
                                        $hours = 4;
                                    else :
                                        $hours = 8;
                                    endif;
                                endif;
                            else :
                                if ($days == 'Sat' || $days == 'Sun') :
                                    $hours = 4;
                                else :
                                    $hours = 8;
                                endif;
                            endif;

                        endif;
                    else :
                        if ($leave_type == 'L01' || $leave_type == 'L03') :
                            if ($sft2) :
                                $dayshift = $mainsql->get_shift($sft2);
                                if ($dayshift[0]['NUMHrs'] > 9) :
                                    $hours = 9;
                                else :
                                    $hours = $dayshift[0]['NUMHrs'] - $dayshift[0]['BreakHours'];
                                endif;
                            else :
                                if ($days == 'Sat' || $days == 'Sun') :
                                    $hours = 4;
                                else :
                                    $hours = 8;
                                endif;
                            endif;
                        elseif ($leave_type == 'L12') :
                            $hours = 8;
                        elseif ($leave_type == 'L04' || $leave_type == 'L05') :
                            if ($sft2) :
                                $dayshift = $mainsql->get_shift($sft2);
                                if ($dayshift[0]['NUMHrs'] > 9) :
                                    $hours = 8;
                                else :
                                    $hours = $dayshift[0]['NUMHrs'] - $dayshift[0]['BreakHours'];
                                endif;
                            else :
                                if ($days == 'Sat' || $days == 'Sun') :
                                    $hours = 4;
                                else :
                                    $hours = 8;
                                endif;
                            endif;
                        else :
                            if ($days == 'Sat' || $days == 'Sun') :
                                $hours = 4;
                            else :
                                $hours = 8;
                            endif;
                        endif;
                    endif;

                    // this is for holiday checking
                    $monthnum = date("n", $leave_from);
                    $daynum = date("j", $leave_from);

                    $thisholiday = $mainsql->get_holiday(1, $monthnum, $daynum, $profile_location);

                    $restdaydate = $mainsql->get_restday($profile_idnum, $wdates);
                    $appliedrestdaydate = $mainsql->get_appliedrestday($profile_idnum, $wdates, $profile_comp);
                    $appliedscheddate = $mainsql->get_appliedsched($profile_idnum, $wdates, $profile_comp);

                    if ($appliedscheddate[0]['NEWSHIFTID']) :
                        $restday = 0;
                    else :
                        $restday = $restdaydate[0]['DAYOFF'] ? 1 : $appliedrestdaydate[0]['RESTDAY'];
                    endif;

                    //var_dump($hours);

                    $daycount = $thisholiday || $restday ? 0 : $hours;
                    $total_day = $total_day + $daycount;
                    $leave_from = strtotime("+1 day", $leave_from);
                }
                echo $total_day;
            else :
                echo 0;
            endif;
        break;
        case 'getleavebalance':
            $ltype = $_POST['ltype'];
            if ($ltype) :

                if ($ltype == 'L01' || $ltype == 'L03') :
                    $leave_bal = $mainsql->get_newleavebal_byid_pryear($profile_idnum, $ltype, date('Y', strtotime($_POST['lto'])));

                    if ($leave_bal[0]['BALANCE']) :
                        $balance = round($leave_bal[0]['BALANCE'] * 2, 0) / 2;
                    else :
                        $balance = 0;
                    endif;
                else :
                    $leave_bal = $mainsql->get_leavebal_byid($profile_idnum, $ltype);

                    if ($leave_bal[0]['BalanceHrs']) :
                        $balance = round($leave_bal[0]['BalanceHrs'] * 2, 0) / 2;
                    else :
                        $balance = 0;
                    endif;
                endif;

                /*if ($profile_compressed) :
                    if ($leave_bal[0]['BALANCE']) :
                        $balance = round($leave_bal[0]['BALANCE'] * 2, 0) / 2;
                    else :
                        $balance = 0;
                    endif;
                else :
                    if ($leave_bal[0]['BalanceDays']) :
                        $balance = round($leave_bal[0]['BalanceDays'] * 2, 0) / 2;
                    else :
                        $balance = 0;
                    endif;
                endif;*/
            else :
                $balance = 0;
            endif;
            echo $balance <= 0 ? 0 : $balance;
        break;
        case 'getleaveday':
            $ltype = $_POST['ltype'];
            $stype = $_POST['stype'];
            $sdate = $_POST['sdate'];
            $idnum = $_POST['empid'];
            if ($stype) :
                $stype_array = explode(',', $stype);
                $sdate_array = explode(',', $sdate);
                $total_day = 0;
                foreach ($stype_array as $key => $value) :

                    $vdates = date('Y-m-d', $sdate_array[$key]);

                    $shiftsched2 = $mainsql->get_schedshiftdtr($idnum, $vdates);
                    $sft2 = $shiftsched2[0]['ShiftID'];

                    $dayshift = $mainsql->get_shift($shiftsched2[0]['ShiftID']);

                    $hours = $dayshift[0]['NUMHrs'] - $dayshift[0]['BreakHours'];

                    $ddisplay = $sft2 ? 1 : 0;

                    $getnumhours = $mainsql->get_shift($sft2);

                    if ($sft2) :
                        if ($profile_compressed) :
                            $wdhours = $getnumhours[0]['NUMHrs'] - $getnumhours[0]['BreakHours'];
                        else :
                            $wdhours = 1;
                        endif;
                    else :
                        $wdhours = 1;
                    endif;
                    if ($getnumhours[0]['NUMHrs'] <= 4) :
                        if ($sft2) :
                            if ($profile_compressed) :
                                $hdhours = $getnumhours[0]['NUMHrs'] - $getnumhours[0]['BreakHours'];
                            else :
                                $hdhours = 0.5;
                            endif;
                        else :
                            $hdhours = 0.5;
                        endif;
                    else :
                        if ($sft2) :
                            if ($profile_compressed) :
                                $hdhours = ($getnumhours[0]['NUMHrs'] - $getnumhours[0]['BreakHours']) / 2;
                            else :
                                $hdhours = 0.5;
                            endif;
                        else :
                            $hdhours = 0.5;
                        endif;
                    endif;

                    if ($ltype == "L01" || $ltype == "L03") :
                        if ($value == "WD") :
                            //if ($vdates == '2018-03-28') :
                                //$hours = 6;
                            //else :
                                $hours = $wdhours;
                            //endif;
                        elseif ($value == "HD1") :
                            //if ($vdates == '2018-03-28') :
                                //$hours = 3;
                            //else :
                                $hours = $hdhours;
                            //endif;
                        elseif ($value == "HD2") :
                            //if ($vdates == '2018-03-28') :
                                //$hours = 3;
                            //else :
                                $hours = $hdhours;
                            //endif;
                        else :
                            $hours = 0;
                        endif;
                    else :
                        if ($value == "WD") :
                            //if ($vdates == '2018-03-28') :
                                //$hours = 6;
                            //else :
                                $hours = 8;
                            //endif;
                        elseif ($value == "HD1") :
                            //if ($vdates == '2018-03-28') :
                                //$hours = 3;
                            //else :
                                $hours = 4;
                            //endif;
                        elseif ($value == "HD2") :
                            //if ($vdates == '2018-03-28') :
                                //$hours = 3;
                            //else :
                                $hours = 4;
                            //endif;
                        else :
                            $hours = 0;
                        endif;
                    endif;
                    $daycount = $hours;
                    $total_day = $total_day + $daycount;
                endforeach;
            else :
                $total_day = 0;
            endif;
            echo $total_day;
        break;
        case 'getleavepay':
            $ltype = $_POST['ltype'];
            $stype = $_POST['stype'];
            $sdate = $_POST['sdate'];
            $idnum = $_POST['empid'];
            if ($stype) :
                $stype_array = explode(',', $stype);
                $sdate_array = explode(',', $sdate);
                $total_pay = 0;
                foreach ($stype_array as $key => $value) :

                    $vdates = date('Y-m-d', $sdate_array[$key]);

                    $shiftsched2 = $mainsql->get_schedshiftdtr($idnum, $vdates);
                    $sft2 = $shiftsched2[0]['ShiftID'];

                    $dayshift = $mainsql->get_shift($shiftsched2[0]['ShiftID']);

                    $hours = $dayshift[0]['NUMHrs'] - $dayshift[0]['BreakHours'];

                    $ddisplay = $sft2 ? 1 : 0;

                    $getnumhours = $mainsql->get_shift($sft2);

                    if ($sft2) :
                        if ($profile_compressed) :
                            $wdhours = $getnumhours[0]['NUMHrs'] - $getnumhours[0]['BreakHours'];
                        else :
                            $wdhours = 1;
                        endif;
                    else :
                        $wdhours = 1;
                    endif;
                    if ($getnumhours[0]['NUMHrs'] <= 4) :
                        if ($sft2) :
                            if ($profile_compressed) :
                                $hdhours = $getnumhours[0]['NUMHrs'] - $getnumhours[0]['BreakHours'];
                            else :
                                $hdhours = 0.5;
                            endif;
                        else :
                            $hdhours = 0.5;
                        endif;
                    else :
                        if ($sft2) :
                            if ($profile_compressed) :
                                $hdhours = ($getnumhours[0]['NUMHrs'] - $getnumhours[0]['BreakHours']) / 2;
                            else :
                                $hdhours = 0.5;
                            endif;
                        else :
                            $hdhours = 0.5;
                        endif;
                    endif;


                    if ($ltype == "L01" || $ltype == "L03") :
                        if ($value == "WD") :
                            //if ($vdates == '2018-03-28') :
                                //$vhours = 6;
                            //else :
                                $vhours = $wdhours;
                            //endif;
                        elseif ($value == "HD1") :
                            //if ($vdates == '2018-03-28') :
                                //$vhours = 3;
                            //else :
                                $vhours = $hdhours;
                            //endif;
                        elseif ($value == "HD2") :
                            //if ($vdates == '2018-03-28') :
                                //$vhours = 3;
                            //else :
                                $vhours = $hdhours;
                            //endif;
                        else :
                            $vhours = 0;
                        endif;
                    else :
                        if ($value == "WD") :
                            //if ($vdates == '2018-03-28') :
                                //$vhours = 6;
                            //else :
                                $vhours = 8;
                            //endif;
                        elseif ($value == "HD1") :
                            //if ($vdates == '2018-03-28') :
                                //$vhours = 3;
                            //else :
                                $vhours = 4;
                            //endif;
                        elseif ($value == "HD2") :
                            //if ($vdates == '2018-03-28') :
                                //$vhours = 3;
                            //else :
                                $vhours = 4;
                            //endif;
                        else :
                            $vhours = 0;
                        endif;
                    endif;
                    $daycount = $vhours;
                    $total_pay = $total_pay + $daycount;
                endforeach;
            else :
                $total_pay = 0;
            endif;
            echo $total_pay;
        break;

        case 'getobndays':

            $obt_from = strtotime($_POST['from']." 00:00:00");
            $obt_to = strtotime($_POST['to']." 23:59:59");

            if ($obt_from > $obt_to) :
                echo '0';
            else :
                $dayn = 0;
                while($obt_from <= $obt_to) {
                    $dayn++;
                    $obt_from = strtotime("+1 day", $obt_from);
                }
                echo $dayn;
            endif;

        break;

        case 'getobtsched':

            $obt_from = strtotime($_POST['from']." 00:00:00");
            $obt_to = strtotime($_POST['to']." 23:59:59");

            ?>

            <table width="100%" class="tdata vsmalltext" border="0" cellspacing="0">
                <tr>
                    <th width="10%">#</th>
                    <th width="25%">Date In</th>
                    <th width="20%">Time In</th>
                    <th width="25%">Date Out</th>
                    <th width="20%">Time Out</th>
                </tr>

            <?php

            if ($obt_from > $obt_to) :
            ?>

                <tr>
                    <td width="100%" colspan="4" class="centertalign">Your date range is invalid</td>
                </tr>

            <?php
            else :

                $key = 1;

                $dtr_calculate = $mainsql->dtr_action($_POST, 'calculate');

                $shiftsched = $mainsql->get_schedshift($profile_idnum);

                while($obt_from <= $obt_to) {

                    $date = date("m/d/Y", $obt_from);
                    $dates = date("Y-m-d", $obt_from);
                    $days = date("D m/d/y", $obt_from);
                    $numdays = intval(date("N", $obt_from));
                    $obt_from = strtotime("+1 day", $obt_from);

                    $dtrsft = $mainsql->get_schedshiftdtr($profile_idnum, $date);
                    //var_dump($dtrsft);

                    $shiftsched2 = $mainsql->get_schedshiftdtr($profile_idnum, $dates);
                    $sft2 = $shiftsched2[0]['ShiftID'];
                    $shifts = $mainsql->get_shift($sft2);

                    $obtoutdate = $shiftsched2[0]['TimeOut'] ? strtotime($shiftsched2[0]['TimeOutDate']) : strtotime($dates);

                    $obtin = $shiftsched2[0]['TimeIN'] ? strtotime(date('H:i:s', strtotime($shiftsched2[0]['TimeIN']))) : strtotime($shifts[0]['TimeIN']);
                    $obtout = $shiftsched2[0]['TimeOut'] ? strtotime(date('H:i:s', strtotime($shiftsched2[0]['TimeOut']))) : strtotime($shifts[0]['TimeOUT']);

                    $totaltime = $obtout - $obtin;

                    ?>

                    <script type="text/javascript">

                        $("#obt_timein<?php echo $key; ?>").change(function() {
                            dayin = $("#obt_date<?php echo $key; ?>").val();
                            timein = $("#obt_timein<?php echo $key; ?>").val();
                            dayout = $("#obt_dateout<?php echo $key; ?>").val();
                            timeout = $("#obt_timeout<?php echo $key; ?>").val();

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
                                        $("#obt_hours<?php echo $key; ?>").val(data);
                                    }
                                })
                            }
                            else {
                                $("#obt_hours<?php echo $key; ?>").val('-1');
                            }
                        });

                        $("#obt_dateout<?php echo $key; ?>").change(function() {
                            dayin = $("#obt_date<?php echo $key; ?>").val();
                            timein = $("#obt_timein<?php echo $key; ?>").val();
                            dayout = $("#obt_dateout<?php echo $key; ?>").val();
                            timeout = $("#obt_timeout<?php echo $key; ?>").val();

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
                                        $("#obt_hours<?php echo $key; ?>").val(data);
                                    }
                                })
                            }
                            else {
                                $("#obt_hours<?php echo $key; ?>").val('-1');
                            }
                        });

                        $("#obt_timeout<?php echo $key; ?>").change(function() {
                            dayin = $("#obt_date<?php echo $key; ?>").val();
                            timein = $("#obt_timein<?php echo $key; ?>").val();
                            dayout = $("#obt_dateout<?php echo $key; ?>").val();
                            timeout = $("#obt_timeout<?php echo $key; ?>").val();

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
                                        $("#obt_hours<?php echo $key; ?>").val(data);
                                    }
                                })
                            }
                            else {
                                $("#obt_hours<?php echo $key; ?>").val('-1');
                            }
                        });

                        $('.obtdateout<?php echo $key; ?>').datepicker({
                            dateFormat: 'yy-mm-dd',
                            minDate: '<?php echo date("Y-m-d", strtotime($dates)); ?>',
                            maxDate: '<?php echo date("Y-m-d", strtotime($dates) + 86400); ?>'
                        });
                    </script>

                    <tr>
                        <td class="centertalign"><?php echo $key; ?></td>
                        <td class="centertalign"><?php echo $days; ?>
                            <input id="obt_date<?php echo $key; ?>" type="hidden" name="obt_date[<?php echo $key; ?>]" value="<?php echo $dates; ?>" class="obt_date<?php echo $key; ?>" />
                        </td>
                        <td class="centertalign">
                            <input id="obt_timein<?php echo $key; ?>" type="text" name="obt_timein[<?php echo $key; ?>]" value="<?php echo $sft2 ? date('h:ia', $obtin) : '08:30am'; ?>" class="obt_timein<?php echo $key; ?> txtbox width95 timepick" readonly />
                        </td>
                        <td class="centertalign">
                            <input id="obt_dateout<?php echo $key; ?>" type="text" name="obt_dateout[<?php echo $key; ?>]" value="<?php echo $dates; ?>" class="txtbox width95 obtdateout<?php echo $key; ?>" readonly />
                        </td>
                        <td class="centertalign">
                            <input id="obt_timeout<?php echo $key; ?>" type="text" name="obt_timeout[<?php echo $key; ?>]" value="<?php echo $sft2 ? date('h:ia', $obtout) : '05:30pm'; ?>" class="obt_timeout<?php echo $key; ?> txtbox width95 timepick" readonly />
                            <input id="obt_hours<?php echo $key; ?>" type="hidden" name="obt_hours[<?php echo $key; ?>]" value="<?php echo $shiftsched2[0]['ShiftID'] ? $totaltime : 0; ?>" class="obt_hours<?php echo $key; ?>" />
                            <input id="obt_actfrom<?php echo $key; ?>" type="hidden" name="obt_actfrom[<?php echo $key; ?>]" value="<?php echo $dtrsft[0]['TimeIN'] ? ($dates.' '.date('H:i:s', strtotime($dtrsft[0]['TimeIN']))) : NULL; ?>" class="obt_actfrom<?php echo $key; ?>" />
                            <input id="obt_actto<?php echo $key; ?>" type="hidden" name="obt_actto[<?php echo $key; ?>]" value="<?php echo $dtrsft[0]['TimeOut'] ? ($dates.' '.date('H:i:s', strtotime($dtrsft[0]['TimeOut']))) : NULL; ?>" class="obt_actto<?php echo $key; ?>" />
                        </td>

                    </tr>

                    <?php
                    $key++;
                }

            endif;
            ?>

            </table>

            <?php

        break;

        case 'getmealsched':

            $meal_from = strtotime($_POST['from']." 00:00:00");
            $meal_to = strtotime($_POST['to']." 23:59:59");

            ?>

            <table width="100%" class="tdata vsmalltext" border="0" cellspacing="0">
                <tr>
                    <th width="10%">#</th>
                    <th width="30%">Date</th>
                    <th width="20%">From</th>
                    <th width="20%">To</th>
                    <th width="20%">Purpose</th>
                </tr>

            <?php

            if ($meal_from > $meal_to) :
            ?>

                <tr>
                    <td colspan="5" class="centertalign">Your date range is invalid</td>
                </tr>

            <?php
            else :

                $key = 1;

                $shiftsched = $mainsql->get_schedshift($profile_idnum);

                if ($shiftsched[0]['MonShiftID']) : $mon = 1; endif;
                if ($shiftsched[0]['TueShiftID']) : $tue = 1; endif;
                if ($shiftsched[0]['WedShiftID']) : $wed = 1; endif;
                if ($shiftsched[0]['ThuShiftID']) : $thu = 1; endif;
                if ($shiftsched[0]['FriShiftID']) : $fri = 1; endif;
                if ($shiftsched[0]['SatShiftID']) : $sat = 1; endif;
                if ($shiftsched[0]['SunShiftID']) : $sun = 1; endif;

                while($meal_from <= $meal_to) {

                    $dates = date("Y-m-d", $meal_from);
                    $days = date("D m/d/y", $meal_from);
                    $numdays = intval(date("N", $meal_from));
                    $meal_from = strtotime("+1 day", $meal_from);

                    if ($numdays == 1 && $mon) : $ddisplay = 1; $shifts = $mainsql->get_shift($shiftsched[0]['MonShiftID']); endif;
                    if ($numdays == 2 && $tue) : $ddisplay = 1; $shifts = $mainsql->get_shift($shiftsched[0]['TueShiftID']); endif;
                    if ($numdays == 3 && $wed) : $ddisplay = 1; $shifts = $mainsql->get_shift($shiftsched[0]['WedShiftID']); endif;
                    if ($numdays == 4 && $thu) : $ddisplay = 1; $shifts = $mainsql->get_shift($shiftsched[0]['ThuShiftID']); endif;
                    if ($numdays == 5 && $fri) : $ddisplay = 1; $shifts = $mainsql->get_shift($shiftsched[0]['FriShiftID']); endif;
                    if ($numdays == 6 && $sat) : $ddisplay = 1; $shifts = $mainsql->get_shift($shiftsched[0]['SatShiftID']); endif;
                    if ($numdays == 7 && $sun) : $ddisplay = 1; $shifts = $mainsql->get_shift($shiftsched[0]['SunShiftID']); endif;

                    ?>

                    <tr>
                        <td class="centertalign"><?php echo $key; ?></td>
                        <td class="centertalign"><?php echo $days; ?></td>
                        <td class="centertalign"><input type="text" name="ma_timein[<?php echo $dates; ?>]" value="<?php echo date('h:ia', strtotime($shifts[0]['TimeIN'])); ?>" class="txtbox width95 timepick" readonly /></td>
                        <td class="centertalign"><input type="text" name="ma_timeout[<?php echo $dates; ?>]" value="<?php echo date('h:ia', strtotime($shifts[0]['TimeOUT'])); ?>" class="txtbox width95 timepick" readonly /></td>
                        <td class="centertalign"><input type="text" name="ma_purpose[<?php echo $dates; ?>]" class="txtbox width200" /></td>
                    </tr>

                    <?php
                    $key++;
                }

            endif;
            ?>

            </table>

            <?php

        break;

        case 'setmddayout':

            $dayin = strtotime($_POST['dayin']);
            $shiftid = $_POST['shiftid'];
            if ($shiftid) :
                $shiftdata = $mainsql->get_shift($shiftid);
                $utimein = strtotime($shiftdata[0]['TimeIN']);
                $utimeout = strtotime($shiftdata[0]['TimeOUT']);

                if ($utimein > $utimeout) :
                    echo date("Y-m-d", $dayin + 86400);
                else :
                    echo date("Y-m-d", $dayin);
                endif;

            else :
                echo date("Y-m-d", $dayin);
            endif;

        break;

        case 'setmdin':

            $shiftid = $_POST['shiftid'];
            if ($shiftid) :
                $shiftdata = $mainsql->get_shift($shiftid);
                echo date("h:ia", strtotime($shiftdata[0]['TimeIN']));
            else :
                echo '';
            endif;

        break;

        case 'setmdout':

            $shiftid = $_POST['shiftid'];
            if ($shiftid) :
                $shiftdata = $mainsql->get_shift($shiftid);
                echo date("h:ia", strtotime($shiftdata[0]['TimeOUT']));
            else :
                echo '';
            endif;

        break;

        case 'gettrueto':

            $mdin = $_POST['from'];
            $mdout = $_POST['to'];

            $inyear = date('Y', strtotime($mdin));
            $inmonth = date('m', strtotime($mdin));
            $inday = date('d', strtotime($mdin));
            $innday = date('j', strtotime($mdin));

            $outyear = date('Y', strtotime($mdout));
            $outmonth = date('m', strtotime($mdout));
            $outday = date('d', strtotime($mdout));
            $outnday = date('j', strtotime($mdout));

            $lastday = date('t', strtotime($mdin));

            $mnow = date('U', strtotime(date('Y-m-d')));

            if ($innday >= 16) :
                $mout = strtotime($inyear.'-'.$inmonth.'-'.$lastday);
            else :
                $mout = strtotime($inyear.'-'.$inmonth.'-15');
            endif;
            if ($mout > $mnow) :
                $mdtrout = date('Y-m-d', $mnow);
            else :
                $mdtrout = date('Y-m-d', $mout);
            endif;

            echo $mdtrout;

        break;

        case 'gettruefrom2':

            $mdin = $_POST['from'];
            $mdout = $_POST['to'];

            $ymdin = strtotime($mdin);

            $inyear = date('Y', strtotime($mdin));
            $inmonth = date('m', strtotime($mdin));
            $inday = date('d', strtotime($mdin));
            $innday = date('j', strtotime($mdin));

            $outyear = date('Y', strtotime($mdout));
            $outmonth = date('m', strtotime($mdout));
            $outday = date('d', strtotime($mdout));
            $outnday = date('j', strtotime($mdout));

            $lastday = date('t', strtotime($mdout));

            if ($outnday >= 16) :
                $min = strtotime($outyear.'-'.$outmonth.'-16');
                $mout = strtotime($outyear.'-'.$outmonth.'-'.$lastday);
            else :
                $min = strtotime($outyear.'-'.$outmonth.'-01');
                $mout = strtotime($outyear.'-'.$outmonth.'-15');
            endif;

            if ($ymdin < $min || $ymdin > $mout) :
                $timein = date('Y-m-d', $min);
            else :
                $timein = date('Y-m-d', $ymdin);
            endif;

            echo $timein;

        break;

        case 'gettrueto2':

            $mdin = $_POST['from'];
            $mdout = $_POST['to'];

            $inyear = date('Y', strtotime($mdin));
            $inmonth = date('m', strtotime($mdin));
            $inday = date('d', strtotime($mdin));
            $innday = date('j', strtotime($mdin));

            $outyear = date('Y', strtotime($mdout));
            $outmonth = date('m', strtotime($mdout));
            $outday = date('d', strtotime($mdout));
            $outnday = date('j', strtotime($mdout));

            $lastday = date('t', strtotime($mdin));

            $mnow = date('U', strtotime(date('Y-m-d')));

            if ($innday >= 16) :
                $mout = strtotime($inyear.'-'.$inmonth.'-'.$lastday);
            else :
                $mout = strtotime($inyear.'-'.$inmonth.'-15');
            endif;

            $timeout = date('Y-m-d', $mout);

            echo $timeout;

        break;

		case 'gettrueto3':

            $mdin = $_POST['from'];
            $mdout = $_POST['to'];

			$date = date('Y-m-d', strtotime($mdin. ' + 6 days'));

            echo $date;

        break;

        case 'getmandtr':


            $mandtr_from = strtotime($_POST['from']." 00:00:00");
            $mandtr_to = strtotime($_POST['to']." 23:59:59");

            //var_dump($leave_from." ".$leave_to);

            ?>


            <table width="100%" class="tdata vsmalltext" border="0" cellspacing="0">
                <tr>
                    <th width="3%">#</th>
                    <th width="6%">No Working Day</th>
                    <th width="14%">Date</th>
                    <th width="9%">In</th>
                    <th width="9%">Date</th>
                    <th width="9%">Out</th>
                    <th width="22%">Shift Desc</th>
                    <th width="22%">New Shift Desc</th>
                </tr>

            <?php

            if ($mandtr_from > $mandtr_to) :
            ?>

                <tr>
                    <td colspan="8" class="centertalign">Your date range is invalid</td>
                </tr>

            <?php

            else :

                $key = 1;

                while($mandtr_from <= $mandtr_to) {

                    $udate = date("U", $mandtr_from);
                    $dates = date("Y-m-d", $mandtr_from);
                    $days = date("D m/d/y", $mandtr_from);
                    $numdays = intval(date("N", $mandtr_from));
                    $dtr_data = $mainsql->get_dtr_bydate($profile_idnum, date("m/d/Y", $udate));

                    $shiftlist = $mainsql->get_shift();

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
                            <input id="mdtr_timein<?php echo $key; ?>" type="text" name="mdtr_timein[<?php echo $key; ?>]" dtr="0" value="<?php echo $shiftsched2[0]['ShiftID'] ? $timeinval : ''; ?>" class="mdtr_timein<?php echo $key; ?> txtbox width70 timepick"readonly />
                            <?php //endif; ?>
                        </td>
                        <td class="centertalign">
                            <?php //if ($dtimeout) :
                                //echo $dates; ?>
                                <!--input id="mdtr_dayout<?php echo $key; ?>" type="hidden" name="mdtr_dayout[<?php echo $key; ?>]" value="<?php echo $dates; ?>" class="mdtr_dayout<?php echo $key; ?>" /-->
                                <?php
                            //else :
                            ?>
                            <input id="mdtr_dayout<?php echo $key; ?>" type="text" name="mdtr_dayout[<?php echo $key; ?>]" value="<?php echo $dates; ?>" class="mdtr_dayout<?php echo $key; ?> txtbox width70 datepick3"readonly />
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
                            <input id="mdtr_timeout<?php echo $key; ?>" type="text" name="mdtr_timeout[<?php echo $key; ?>]" dtr="0" value="<?php echo $shiftsched2[0]['ShiftID'] ? $timeoutval : ''; ?>" class="mdtr_timeout<?php echo $key; ?> txtbox width70 timepick"readonly />
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

            endif;
            ?>

            </table>

            <?php

        break;

		case 'getwfh':


            $wfh_from = strtotime($_POST['from']." 00:00:00");
            $wfh_to = strtotime($_POST['to']." 23:59:59");
            //var_dump($leave_from." ".$leave_to);

            ?>


            <table width="100%" class="tdata vsmalltext" border="0" cellspacing="0" ng-app="WFHApp" ng-controller="WFHController">
            <tr>
                <th width="15px">#</th>
                <th width="15px">Exclude</th>
                <th width="100px">Date</th>
                <th width="60px">Total Worked Hours</th>
                <th width="">Activities</th>
            </tr>

            <?php

            if ($wfh_from > $wfh_to) :
            ?>

                <tr>
                    <td colspan="8" class="centertalign">Your date range is invalid</td>
                </tr>

            <?php

            else :

                $key = 1;

                while($wfh_from <= $wfh_to) {

                    $udate = date("U", $wfh_from);
                    $dates = date("Y-m-d", $wfh_from);
                    $days = date("D m/d/y", $wfh_from);
                    $numdays = intval(date("N", $wfh_from));
                    $dtr_data = $mainsql->get_dtr_bydate($profile_idnum, date("m/d/Y", $udate));

                    $shiftlist = $mainsql->get_shift();

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

					<script>
					$(function() {

						$("#mdtr_absent<?php echo $key; ?>").change(function() {

							arrayid = $(this).attr('attribute');

							if($("#wfh_disable" + arrayid).val() == 0){
								$("#wfh_disable" + arrayid).val(1);
							}else{
								$("#wfh_disable" + arrayid).val(0);
							}



							if($("#wfh_totalworkedhours" + arrayid).prop("disabled")){
								$("#wfh_totalworkedhours" + arrayid).prop("disabled", false);
							}else{
								$("#wfh_totalworkedhours" + arrayid).prop("disabled", true);
							}

							if($("#wfh_activity" + arrayid).prop("disabled")){
								$("#wfh_activity" + arrayid).prop("disabled", false);
							}else{
								$("#wfh_activity" + arrayid).prop("disabled", true);
							}

						});

					});
					</script>

                    <tr id="tr<?php echo $key; ?>">
                        <td class="centertalign"><?php echo $key; ?></td>
                        <td class="centertalign"><input type="hidden" name="wfh_disable[<?php echo $key; ?>]" id="wfh_disable<?php echo $key; ?>" value=0><input id="mdtr_absent<?php echo $key; ?>" type="checkbox" name="mdtr_absent[<?php echo $key; ?>]" attribute="<?php echo $key; ?>" class="mdtr_absent"></td>
                        <td class="centertalign">
                            <?php echo $days; ?>
                            <input id="wfh_dayin<?php echo $key; ?>" type="hidden" name="wfh_dayin[<?php echo $key; ?>]" value="<?php echo $dates; ?>" class="wfh_dayin<?php echo $key; ?>" />
                        </td>
                        <td class="centertalign"><input style="width: 100%" id="wfh_totalworkedhours<?php echo $key; ?>" type="number" name="wfh_totalworkedhours[<?php echo $key; ?>]" attribute="<?php echo $key; ?>" class="wfh_totalworkedhours"></td>
                        <td class="centertalign" >
                            <textarea rows="1" style="display:none" name="wfh_activity[<?php echo $key; ?>]" id="wfh_activity<?php echo $key; ?>" class="txtbox"></textarea>
                            <table>
                                <tr ng-repeat="activity in wfh_activity<?php echo $key; ?>">
                                    <td style="border-bottom: 0px; margin: 0; padding: 0" >
                                        <input type="text" class="txtbox width80" ng-model="wfh_activity<?php echo $key; ?>[$index].time">
                                    </td>
                                    <td style="border-bottom: 0px; margin: 0; padding: 0" width="150px"><textarea class="txtarea" name="" id="" cols="30" rows="1" ng-model="wfh_activity<?php echo $key; ?>[$index].act" ng-click="check()"></textarea></td>
                                    <td style="border-bottom: 0px; margin: 0; padding: 0; text-align:left" width="120px"><button style="" type="button" class="smlbtn" ng-show="$index+1 == wfh_activity<?php echo $key; ?>.length" ng-click="addItem('wfh_activity<?php echo $key; ?>')">Add</button><button style="" type="button" class="redbtn " ng-show="wfh_activity<?php echo $key; ?>.length > 1" ng-click="delItem('wfh_activity<?php echo $key; ?>', $index)">Del</button></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <?php
                    $key++;

                    $wfh_from = strtotime("+1 day", $wfh_from);
                }

            endif;
            ?>

            </table>
            <script>

                $(document).ready(function () {
                    var wfh_app = angular.module('WFHApp', []);
                    wfh_app.controller('WFHController', function WFHController($scope){
                        
                        $scope.item = {time : '', act: ''};
                        
                        <?php $key = 1; $wfh_from = $wfh_from_original; while($wfh_from <= $wfh_today) { ?>

                        $scope.wfh_activity<?php echo $key; ?> = [];
                        $scope.wfh_activity<?php echo $key; ?>.push(angular.copy($scope.item));

                        $scope.$watch('wfh_activity<?php echo $key; ?>', function(newValue, oldValue, scope){
                            $('#wfh_activity<?php echo $key; ?>').text( JSON.stringify(newValue) );
                            console.log(JSON.stringify(newValue));
                        }, true);

                        <?php $key++;  $wfh_from = strtotime("+1 day", $wfh_from); } ?>

                        // Add new activity item
                        $scope.addItem = function(act){
                            $scope[act].push(angular.copy($scope.item));
                        }

                        // Remove item
                        $scope.delItem = function(act, index){
                            $scope[act].splice(index, 1);
                        }

                    });
                });

                </script>
            <?php

        break;

        case 'getmdndays':

            $tsched_from = strtotime($_POST['from']." 00:00:00");
            $tsched_to = strtotime($_POST['to']." 23:59:59");

            if ($tsched_from > $tsched_to) :
                echo '0';
            else :
                $dayn = 0;
                while($tsched_from <= $tsched_to) {
                    $dayn++;
                    $tsched_from = strtotime("+1 day", $tsched_from);
                }
                echo $dayn;
            endif;

        break;

		case 'getwfhdays':

            $tsched_from = strtotime($_POST['from']." 00:00:00");
            $tsched_to = strtotime($_POST['to']." 23:59:59");

            if ($tsched_from > $tsched_to) :
                echo '0';
            else :
                $dayn = 0;
                while($tsched_from <= $tsched_to) {
                    $dayn++;
                    $tsched_from = strtotime("+1 day", $tsched_from);
                }
                echo $dayn;
            endif;

        break;

        case 'getnpabut':

            $npa_date = strtotime($_POST['date']." 00:00:00");
            $npa_day = intval(date("N", $npa_date));

            $dtr_data = $mainsql->get_dtr_bydate($profile_idnum, date("m/d/Y", $npa_date));

            $dtimein = $dtr_data[0]['TimeIN'];
            $dtimeout = $dtr_data[0]['TimeOut'];

            if ($npa_date < date("U")) :
                if ($dtimein && $dtimeout) :
                    $fornpa = 1; //NOT NPA
                elseif ($dtimein || $dtimeout) :
                    $fornpa = 1; //FOR NPA
                else :
                    $fornpa = 1; //FOR DTR
                endif;
            else :
                $fornpa = 0; //DATE INVALID
            endif;

            echo $fornpa;

            ?>

            <?php

        break;

        case 'getnpa':

            $npa_daten = $_POST['date'];
            $npa_date = strtotime($_POST['date']." 00:00:00");
            $npa_day = intval(date("N", $npa_date));

            //var_dump($npa_date);

            $shiftsched = $mainsql->get_schedshift($profile_idnum);
            $dtr_data = $mainsql->get_dtr_bydate($profile_idnum, $_POST['date']);

            $ddatein = $dtr_data[0]['TimeINDate'];
            $ddateout = $dtr_data[0]['TimeOutDate'];
            $dtimein = $dtr_data[0]['TimeIN'];
            $dtimeout = $dtr_data[0]['TimeOut'];

            $shiftsched2 = $mainsql->get_schedshiftdtr($profile_idnum, $_POST['date']);
            $sft2 = $shiftsched2[0]['ShiftID'];
            $shifts2 = $mainsql->get_shift($sft2);

            //var_dump($ddatein.' '.$ddateout);

            if ($npa_date < date("U")) :
                if ($dtimein && $dtimeout) :
                    $fornpa = 1; //NOT NPA
                elseif (!$dtimein && !$dtimeout) :
                    $fornpa = 1; //FOR DTR
                elseif (!$dtimein) :
                    $fornpa = 1; //FOR NPA
                elseif (!$dtimeout) :
                    $fornpa = 1; //FOR NPA
                endif;
            else :
                $fornpa = 0; //DATE INVALID
            endif;

            //var_dump($fornpa);

            ?>

            <?php if($fornpa == 1) : ?>
            <table width="100%" class="tdataform width100per">
                <tr>
                    <?php if ($ddatein) : ?>
                        <td width="20%"><b>Actual Time In: </b></td>
                        <td width="30%">
                            <?php echo date('m/d/Y', strtotime($ddatein)).' '.date('h:ia', strtotime($dtimein)); ?><input id="npa_atin" type="hidden" name="npa_atin" value="<?php echo date('Y-m-d', strtotime($ddatein)).' '.date('h:ia', strtotime($dtimein)); ?>" />
                        </td>
                    <?php else : ?>
                        <td width="20%"><b>DTR Time In: </b></td>
                        <td width="30%">
                            <?php echo date('m/d/Y', strtotime($npa_daten)).' '.date('h:ia', strtotime($shifts2[0]['TimeIN'])); ?><input id="npa_atin" type="hidden" name="npa_atin" value="<?php echo date('Y-m-d', $npa_date).' '.date('h:ia', strtotime($shifts2[0]['TimeIN'])); ?>" />
                        </td>
                    <?php endif; ?>
                    <?php if ($dtimeout) : ?>
                        <td width="20%"><b>Actual Time Out: </b></td>
                        <td width="30%">
                            <?php echo date('m/d/Y', strtotime($ddateout)).' '.date('h:ia', strtotime($dtimeout)); ?><input id="npa_atout" type="hidden" name="npa_atout" value="<?php echo date('Y-m-d', strtotime($ddateout)).' '.date('h:ia', strtotime($dtimeout)); ?>" />
                        </td>
                    <?php else : ?>
                        <td width="20%"><b>DTR Time Out: </b></td>
                        <td width="30%">
                            <?php echo date('m/d/Y', strtotime($ddatein ? $ddatein : $npa_daten)).' '.date('h:ia', strtotime($shifts2[0]['TimeOUT'])); ?><input id="npa_atout" type="hidden" name="npa_atout" value="<?php echo date('Y-m-d', strtotime($ddatein ? $ddatein : $npa_daten)).' '.date('h:ia', strtotime($shifts2[0]['TimeOUT'])); ?>" />
                    </td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <td width="20%"><b>Date In: </b></td>
                    <td width="30%">
                        <?php if ($ddatein) : ?>
                            <input id="npa_din" type="text" name="npa_din" value="<?php echo date('Y-m-d', strtotime($ddatein)); ?>" class="txtbox width135 datepick3" readonly />
                        <?php else : ?>
                            <input id="npa_din" type="text" name="npa_din" value="<?php echo date('Y-m-d', $npa_date); ?>" class="txtbox width135 datepick3" readonly />
                        <?php endif; ?>
                    </td>
                    <td width="20%"><b>Date Out: </b></td>
                    <td width="30%">
                        <?php if ($dtimeout) : ?>
                            <input id="npa_dout" type="text" name="npa_dout" value="<?php echo date('Y-m-d', strtotime($ddateout)); ?>" class="txtbox width135 datepick3" readonly />
                        <?php else : ?>
                            <input id="npa_dout" type="text" name="npa_dout" value="<?php echo date('Y-m-d', strtotime($ddatein ? $ddatein : $npa_daten)); ?>" class="txtbox width135 datepick3" readonly />
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td width="20%"><b>Time In: </b></td>
                    <td width="30%">
                        <?php if ($dtimein) : ?>
                            <input id="npa_in" type="text" name="npa_in" value="<?php echo date('h:ia', strtotime($dtimein)); ?>" class="txtbox width135 timepick" readonly />
                        <?php else : ?>
                            <input id="npa_in" type="text" name="npa_in" value="<?php echo date('h:ia', strtotime($shifts2[0]['TimeIN'])); ?>" class="txtbox width135 timepick" readonly />
                        <?php endif; ?>
                    </td>
                    <td width="20%"><b>Time Out: </b></td>
                    <td width="30%">
                        <?php if ($dtimeout) : ?>
                            <input id="npa_out" type="text" name="npa_out" value="<?php echo date('h:ia', strtotime($dtimeout)); ?>" class="txtbox width135 timepick" readonly />
                        <?php else : ?>
                            <input id="npa_out" type="text" name="npa_out" value="<?php echo date('h:ia', strtotime($shifts2[0]['TimeOUT'])); ?>" class="txtbox width135 timepick" readonly />
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td><b>Reason: </b></td>
                    <td colspan="3">
                        <textarea id="npa_reason" name="npa_reason" rows="5" class="txtarea width95per"></textarea>
                    </td>
                </tr>
            </table>
            <?php elseif($fornpa == 2) : ?>
            <table width="100%" class="tdataform width100per">
                <tr>
                    <td width="20%"><b>Date In: </b></td>
                    <td width="30%"><?php echo date('m/d/Y', strtotime($ddatein)); ?></td>
                    <td width="20%"><b>Date Out: </b></td>
                    <td width="30%"><?php echo date('m/d/Y', strtotime($ddateout)); ?></td>
                </tr>
                <tr>
                    <td width="20%"><b>Time In: </b></td>
                    <td width="30%"><?php echo date('h:ia', strtotime($dtimein)); ?></td>
                    <td width="20%"><b>Time Out: </b></td>
                    <td width="30%"><?php echo date('h:ia', strtotime($dtimeout)); ?></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="margintop30">Sorry, You can no longer apply for a Non-Punching request for selected date.</div>
                    </td>
                </tr>
            </table>
            <?php elseif($fornpa == 0) : ?>
            <script type="text/javascript">
                alert('Either or both DTR in or out is NOT SET so you can\'t apply an NPA, pls apply for a manual DTR instead, thank you.');
            </script>
            <div class="margintop30">* No matching records found for selected date, pls apply for a manual <a href="<?php echo WEB; ?>/mandtr">DTR</a> instead, thank you.</div>
            <?php endif; ?>

            <?php

        break;

        case 'setscin':

            $shiftid = $_POST['shiftid'];
            if ($shiftid) :
                $shiftdata = $mainsql->get_shift($shiftid);
                echo date("h:ia", strtotime($shiftdata[0]['TimeIN']));
            else :
                echo '';
            endif;

        break;

        case 'setscout':

            $shiftid = $_POST['shiftid'];
            if ($shiftid) :
                $shiftdata = $mainsql->get_shift($shiftid);
                echo date("h:ia", strtotime($shiftdata[0]['TimeOUT']));
            else :
                echo '';
            endif;

        break;

        case 'gettsndays':

            $tsched_from = strtotime($_POST['from']." 00:00:00");
            $tsched_to = strtotime($_POST['to']." 23:59:59");

            if ($tsched_from > $tsched_to) :
                echo '0';
            else :
                $dayn = 0;
                while($tsched_from <= $tsched_to) {
                    $dayn++;
                    $tsched_from = strtotime("+1 day", $tsched_from);
                }
                echo $dayn;
            endif;

        break;

        case 'gettsched':


            $tsched_from = strtotime($_POST['from']." 00:00:00");
            $tsched_to = strtotime($_POST['to']." 23:59:59");

            //var_dump($leave_from." ".$leave_to);

            ?>


            <table width="100%" class="tdata vsmalltext" border="0" cellspacing="0">
                <tr>
                    <th width="5%">#</th>
                    <th width="20%">Date</th>
                    <th width="10%">In</th>
                    <th width="10%">Out</th>
                    <th width="27%">Shift Desc</th>
                    <th width="28%">New Shift Desc</th>
                </tr>

            <?php

            if ($tsched_from > $tsched_to) :
            ?>

                <tr>
                    <td width="100%" colspan="6" class="centertalign">Your date range is invalid</td>
                </tr>

            <?php

            else :

                $key = 1;

                $shiftsched = $mainsql->get_schedshift($profile_idnum);
                $shiftlist = $mainsql->get_shift();

                while($tsched_from <= $tsched_to) {

                    $dates = date("Y-m-d", $tsched_from);
                    $days = date("D m/d/y", $tsched_from);
                    $numdays = intval(date("N", $tsched_from));

                    $shiftsched2 = $mainsql->get_schedshiftdtr($profile_idnum, $dates);
                    $defsched2 = $mainsql->get_scheddef($profile_idnum, $dates);

                    if ($shiftsched2[0]['ShiftDesc'] == 'NO SHIFT') :
                        $sft = 'NS';
                    elseif ($shiftsched2[0]['ShiftDesc'] == 'RESTDAY') :
                        $sft = '';
                    else :
                        $sft = $shiftsched2[0]['ShiftID'];
                        if (!$sft) :
                            $sft = $defsched2[0]['SHIFTID'];
                        endif;
                    endif;
                    $shifts2 = $mainsql->get_shift($sft);

                    ?>

                    <tr>
                        <td class="centertalign"><?php echo $key; ?></td>
                        <td class="centertalign"><?php echo $days; ?><input type="hidden" name="dtr_date[<?php echo $key; ?>]" value="<?php echo $dates; ?>" /><input type="hidden" name="shift_id[<?php echo $key; ?>]" value="<?php echo $sft; ?>" /></td>
                        <td class="centertalign">
                            <span id="ts_timein<?php echo $key; ?>" name="ts_timein[<?php echo $key; ?>]">
                                <?php
                                if ($sft == 'NS') : echo '';
                                else : echo $sft ? date('h:ia', strtotime($shifts2[0]['TimeIN'])) : '';
                                endif;
                                ?></span><input id="tsched_timein<?php echo $key; ?>" type="hidden" name="tsched_timein[<?php echo $key; ?>]" value="<?php
                                if ($sft == 'NS') : echo '';
                                else : echo $sft ? date('h:ia', strtotime($shifts2[0]['TimeIN'])) : '';
                                endif;
                                ?>" />
                        </td>
                        <td class="centertalign">
                            <span id="ts_timeout<?php echo $key; ?>" name="ts_timeout[<?php echo $key; ?>]"><?php
                                if ($sft == 'NS') : echo '';
                                else : echo $sft ? date('h:ia', strtotime($shifts2[0]['TimeOUT'])) : '';
                                endif;
                                ?></span><input id="tsched_timeout<?php echo $key; ?>" type="hidden" name="tsched_timeout[<?php echo $key; ?>]" value="<?php
                                if ($sft == 'NS') : echo '';
                                else : echo $sft ? date('h:ia', strtotime($shifts2[0]['TimeOUT'])) : '';
                                endif;
                                ?>" />
                        </td>
                        <td class="centertalign"><?php
                                if ($sft == 'NS') : echo 'NO SHIFT';
                                else : echo $sft ? $shifts2[0]['ShiftDesc'] : 'REST DAY';
                                endif;
                                ?></td>
                        <td class="centertalign">
                            <select name="tsched_newsched[<?php echo $key; ?>]" attribute="<?php echo $key; ?>" class="tsched_newsched txtbox width150">
                                <option value=""<?php echo $sft  ? " selected" : ""; ?>>REST DAY</option>
                                <?php foreach ($shiftlist as $k => $v) : ?>
                                <option value="<?php echo $v['ShiftID']; ?>"<?php echo $v['ShiftID'] == $sft ? " selected" : ""; ?>><?php echo $v['ShiftDesc']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>

                    <?php
                    $key++;

                    $tsched_from = strtotime("+1 day", $tsched_from);
                }

            endif;
            ?></table><?php
            break;
        default:
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
    } ?>
