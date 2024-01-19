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

    switch ($sec) {
        case 'approve':
        case 'sccancel':
        break;
        default:
        ?>
        <script type="text/javascript">

        $(".chkapp").on("click", function() {

            if($(".chkapp:checked").length) {
                $("#btnapprchk").removeClass('invisible');
            }
            else {
                $("#btnapprchk").addClass('invisible');
            }

        });

        $(".chkappall").change(function(){
            $(".chkapp").prop('checked', $(this).prop("checked"));
            if($(".chkappall:checked").length) {
                $("#btnapprchk").removeClass('invisible');
            }
            else {
                $("#btnapprchk").addClass('invisible');
            }
        });

        $("#btnapp").on("click", function() {

            remarks = $("#remarks").val();
            doctype = $(this).attr("attribute");
            user = $(this).attr("attribute2");
            nxtapp = $(this).attr("attribute21");
            reqnbr = $(this).attr("attribute3");
            empid = $(this).attr("attribute4");
            trans = 'APPROVED';

            if (doctype == "OT") {

                approvehours = $("#approvehours").val();

                var r = confirm("This action cannot be UNDONE. Are you sure you want to approve this request?");

                if (r == true)
                {
                    var approve_msg;

                    if (!$('.approve_msg').length)
                    {
                        $('#btnapp').before('<div class="approve_msg" style="display:none; padding:10px; text-align:center" />');
                    }

                    $('.approve_msg')
                    .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing your approval&hellip;')
                    .css({
                        color : '#006100',
                        background : '#c6efce',
                        border : '2px solid #006100',
                        height : 'auto'
                    })
                    .slideDown();

                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=approve",
                        data: "trans=" + trans + "&remarks=" + remarks + "&doctype=" + doctype + "&reqnbr=" + reqnbr + "&user=" + user + "&nxtapp=" + nxtapp + "&empid=" + empid + "&approvehours=" + approvehours,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {

                            if (data == 1) {

                                $('.approve_msg').slideUp(function ()
                                {
                                    $(this)
                                        .html('<p>Your approval has been successfully completed.</p>')
                                        .css({
                                            'color' : '#006100',
                                            'background' : '#c6efce',
                                            'borderColor' : '#006100',
                                            'margin-top' : '10px',
                                            'height' : 'auto'
                                        })
                                        .slideDown();
                                });
                                $('#remarks').addClass("invisible");
                                $('#btnapp').addClass("invisible");
                                $('#btnrej').addClass("invisible");

                                searchnoti = $("#searchnoti").val();
                                notifrom = $("#notifrom").val();
                                notito = $("#notito").val();

                                notipage = 1;

                                $.ajax(
                                {
                                    url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=table",
                                    data: "searchnoti=" + searchnoti + "&notifrom=" + notifrom + "&notito=" + notito,
                                    type: "POST",
                                    complete: function(){
                                        $("#loading").hide();
                                    },
                                    success: function(data) {
                                        $("#btnnotiall").removeClass("invisible");
                                        $("#notidata").html(data);
                                        changeUrl('', '<?php echo WEB; ?>/notification');
                                    }
                                })

                            }
                            else {

                                $('.approve_msg').slideUp(function ()
                                {
                                    $(this)
                                        .html("There was an error on approval.")
                                        .css({
                                            'color' : '#9c0006',
                                            'background' : '#ffc7ce',
                                            'borderColor' : '#9c0006',
                                            'margin-top' : '10px',
                                            'height' : 'auto'
                                        })
                                        .slideDown();
                                });

                            }
                        }
                    })

                }

            }
            else {

                var r = confirm("This action cannot be UNDONE. Are you sure you want to approve this request?");

                if (r == true)
                {
                    var approve_msg;

                    if (!$('.approve_msg').length)
                    {
                        $('#btnapp').before('<div class="approve_msg" style="display:none; padding:10px; text-align:center" />');
                    }

                    $('.approve_msg')
                    .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing your approval&hellip;')
                    .css({
                        color : '#006100',
                        background : '#c6efce',
                        border : '2px solid #006100',
                        height : 'auto'
                    })
                    .slideDown();

                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=approve",
                        data: "trans=" + trans + "&remarks=" + remarks + "&doctype=" + doctype + "&reqnbr=" + reqnbr + "&user=" + user + "&empid=" + empid,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {

                            if (data == 1) {

                                $('.approve_msg').slideUp(function ()
                                {
                                    $(this)
                                        .html('<p>Your approval has been successfully completed.</p>')
                                        .css({
                                            'color' : '#006100',
                                            'background' : '#c6efce',
                                            'borderColor' : '#006100',
                                            'margin-top' : '10px',
                                            'height' : 'auto'
                                        })
                                        .slideDown();
                                });
                                $('#remarks').addClass("invisible");
                                $('#btnapp').addClass("invisible");
                                $('#btnrej').addClass("invisible");

                                searchnoti = $("#searchnoti").val();
                                notifrom = $("#notifrom").val();
                                notito = $("#notito").val();

                                notipage = 1;

                                $.ajax(
                                {
                                    url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=table",
                                    data: "searchnoti=" + searchnoti + "&notifrom=" + notifrom + "&notito=" + notito,
                                    type: "POST",
                                    complete: function(){
                                        $("#loading").hide();
                                    },
                                    success: function(data) {
                                        $("#btnnotiall").removeClass("invisible");
                                        $("#notidata").html(data);
                                        changeUrl('', '<?php echo WEB; ?>/notification');
                                    }
                                })

                            }
                            else {

                                $('.approve_msg').slideUp(function ()
                                {
                                    $(this)
                                        .html("There was an error on approval.")
                                        .css({
                                            'color' : '#9c0006',
                                            'background' : '#ffc7ce',
                                            'borderColor' : '#9c0006',
                                            'margin-top' : '10px',
                                            'height' : 'auto'
                                        })
                                        .slideDown();
                                });

                            }
                        }
                    })

                }
            }
        });

        $("#btnrej").on("click", function() {

            remarks = $("#remarks").val();
            doctype = $(this).attr("attribute");
            user = $(this).attr("attribute2");
            reqnbr = $(this).attr("attribute3");
            empid = $(this).attr("attribute4");
            trans = 'REJECT';

            var r = confirm("This action is cannot be UNDONE. Are you sure you want to reject this request?");

            if (r == true)
            {
                var approve_msg;

                if (!$('.approve_msg').length)
                {
                    $('#btnrej').before('<div class="approve_msg" style="display:none; padding:10px; text-align:center" />');
                }

                $('.approve_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing your approval&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();

                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=approve",
                    data: "trans=" + trans + "&remarks=" + remarks + "&doctype=" + doctype + "&reqnbr=" + reqnbr + "&user=" + user + "&empid=" + empid,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {

                        if (data == 1) {

                            $('.approve_msg').slideUp(function ()
                            {
                                $(this)
                                    .html('<p>Your rejection has been successfully completed.</p>')
                                    .css({
                                        'color' : '#006100',
                                        'background' : '#c6efce',
                                        'borderColor' : '#006100',
                                        'margin-top' : '10px',
                                        'height' : 'auto'
                                    })
                                    .slideDown();
                            });
                            $('#remarks').addClass("invisible");
                            $('#btnapp').addClass("invisible");
                            $('#btnrej').addClass("invisible");

                            searchnoti = $("#searchnoti").val();
                            notifrom = $("#notifrom").val();
                            notito = $("#notito").val();

                            notipage = 1;

                            $.ajax(
                            {
                                url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=table",
                                data: "searchnoti=" + searchnoti + "&notifrom=" + notifrom + "&notito=" + notito,
                                type: "POST",
                                complete: function(){
                                    $("#loading").hide();
                                },
                                success: function(data) {
                                    $("#btnnotiall").removeClass("invisible");
                                    $("#notidata").html(data);
                                    changeUrl('', '<?php echo WEB; ?>/notification');
                                }
                            })

                        }
                        else {

                            $('.approve_msg').slideUp(function ()
                            {
                                $(this)
                                    .html("There was an error on rejection.")
                                    .css({
                                        'color' : '#9c0006',
                                        'background' : '#ffc7ce',
                                        'borderColor' : '#9c0006',
                                        'margin-top' : '10px',
                                        'height' : 'auto'
                                    })
                                    .slideDown();
                            });

                        }
                    }
                })

            }
        });

        $("#btncancel").on("click", function() {

            remarks = 0;
            doctype = $(this).attr("attribute");
            user = 0;
            reqnbr = $(this).attr("attribute3");
            empid = $(this).attr("attribute4");
            trans = 'CANCEL';

            var r = confirm("This action is cannot be UNDONE. Are you sure you want to cancel this request?");

            if (r == true)
            {

                var approve_msg;

                if (!$('.approve_msg').length)
                {
                    $('#btncancel').before('<div class="approve_msg" style="display:none; padding:10px; text-align:center" />');
                }

                $('.approve_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Cancelling your approval&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();

                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=approve",
                    data: "trans=" + trans + "&remarks=" + remarks + "&doctype=" + doctype + "&reqnbr=" + reqnbr + "&user=" + user + "&empid=" + empid,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {

                        if (data == 1) {

                            $('.approve_msg').slideUp(function ()
                            {
                                $(this)
                                    .html('<p>Your request has been successfully cancelled.</p>')
                                    .css({
                                        'color' : '#006100',
                                        'background' : '#c6efce',
                                        'borderColor' : '#006100',
                                        'margin-top' : '10px',
                                        'height' : 'auto'
                                    })
                                    .slideDown();
                            });
                            $('#btncancel').addClass("invisible");

                            searchnoti = $("#searchnoti").val();
                            notifrom = $("#notifrom").val();
                            notito = $("#notito").val();

                            notipage = 1;

                            $.ajax(
                            {
                                url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=table",
                                data: "searchnoti=" + searchnoti + "&notifrom=" + notifrom + "&notito=" + notito,
                                type: "POST",
                                complete: function(){
                                    $("#loading").hide();
                                },
                                success: function(data) {
                                    $("#btnnotiall").removeClass("invisible");
                                    $("#notidata").html(data);
                                    changeUrl('', '<?php echo WEB; ?>/notification');
                                }
                            })

                        }
                        else {

                            $('.approve_msg').slideUp(function ()
                            {
                                $(this)
                                    .html("There was an error on cancellation.")
                                    .css({
                                        'color' : '#9c0006',
                                        'background' : '#ffc7ce',
                                        'borderColor' : '#9c0006',
                                        'margin-top' : '10px',
                                        'height' : 'auto'
                                    })
                                    .slideDown();
                            });

                        }
                    }
                })

            }
        });




        $(".btnnotidata").on("click", function() {

            doctype = $(this).attr('attribute2');
            refnum = $(this).attr('attribute');

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

            $("#noti_data").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

            $("#noti_title").html(title + ' ' + refnum);
            $(".floatdiv").removeClass("invisible");
            $("#nview").removeClass("invisible");

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=data",
                data: "refnum=" + refnum + "&doctype=" + doctype,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $("#noti_data").html(data);
                }
            })
        });

        </script>
        <?php
        break;
     }
     ?>

    <?php

    switch ($sec) {
        case 'table':

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NOTI_NUM_ROWS * ($page - 1);

            $unread_data = $mainsql->get_read($profile_idnum, NULL, 0, $start, NOTI_NUM_ROWS);
            $unread_count = $mainsql->get_read($profile_idnum, NULL, 1);

            $pages = $mainsql->pagination("unread", $unread_count, NOTI_NUM_ROWS, 9);

            //var_dump($notification_data);
            ?>

            <table border="0" cellspacing="0" class="tdata width100per">
                <?php if ($notification_data) : ?>
                <tr>
                    <!--th width="4%">&nbsp;</th-->
                    <th width="5%">Type</th>
                    <th width="20%">Reference #</th>
                    <th width="11%">Level</th>
                    <th width="18%">Date Filed</th>
                    <th width="26%">Status</th>
                    <th width="20%">Last Updated</th>
                </tr>
                <?php foreach ($notification_data as $key => $value) :

                    //READ STATUS
                    $get_read = $mainsql->get_read($profile_idnum, $value['Reference'], 1);

                    if ($value['DocType'] == 'LV') :
                        $typestat = "LEAVE APPLICATION from ";
                    elseif ($value['DocType'] == 'OT') :
                        $typestat = "OVERTIME APPLICATION from ";
                        $ot_data = $tblsql->get_nrequest(1, $value['Reference']);
                    elseif ($value['DocType'] == 'OB') :
                        $typestat = "OBT APPLICATION from ";
                    elseif ($value['DocType'] == 'NP') :
                        $typestat = "NO PUNCH APPLICATION from ";
                    elseif ($value['DocType'] == 'MD') :
                        $typestat = "MANUAL DTR APPLICATION from ";
                    elseif ($value['DocType'] == 'SC') :
                        $typestat = "CHANGE SCHEDULE APPLICATION from ";
                    elseif ($value['DocType'] == 'TS') :
                        $typestat = "SCHEDULE CHANGE APPLICATION from ";
                    endif;

                    //var_dump($value['Signatory06']);

                    $displaychk = 0;

                    if (trim($value['Signatory01'])) :

                        if ($value['Signatory01'] == $profile_idnum) :

                            $requestor_data = $register->get_member($value['EmpID']);
                            if ($value['Approved'] == 1) :
                                if ($value['ApprovedDate01']) :
                                    $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate01']));
                                    if (!trim($value['Signatory02']) || trim($value['Signatory02']) == '') :
                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                        $nlevel = 1;
                                    else:
                                        $nlevel = 2;
                                    endif;
                                else :
                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";
                                    $nlevel = 1;
                                endif;
                            elseif ($value['Approved'] == 2) :
                                $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";
                                $nlevel = 1;
                            elseif ($value['Approved'] == 3) :
                                $astatus = "CANCELLED by ".$requestor_data[0]['FName']." ".$requestor_data[0]['LName'];
                                $nlevel = 1;
                            else :
                                $nlevel = 1;
                                $astatus = "<span class='lorangetext'>".$typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." for your APPROVAL</span>";
                                $displaychk = 1;
                                $signatory = $value['Signatory01'];
                            endif;
                        else :
                            $approver_data = $register->get_member($value['Signatory01']);
                            if ($value['Approved'] == 1) :
                                if ($value['ApprovedDate01']) :
                                    $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate01']));
                                    if (!trim($value['Signatory02']) || trim($value['Signatory02']) == '') :
                                        $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
                                        $nlevel = 1;
                                    else:
                                        $nlevel = 2;
                                    endif;
                                else :
                                    $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                    $nlevel = 1;
                                endif;
                            elseif ($value['Approved'] == 2) :
                                $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                $nlevel = 1;
                            elseif ($value['Approved'] == 3) :
                                $astatus = "CANCELLED by YOU";
                                $nlevel = 1;
                            else :
                                $nlevel = 1;
                                $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                            endif;
                        endif;
                    endif;

                    if (trim($value['Signatory06']) && $value['ApprovedDate05']) :

                        if ($value['Signatory06'] == $profile_idnum) :

                            $requestor_data = $register->get_member($value['EmpID']);
                            if ($value['Approved'] == 1) :
                                if ($value['ApprovedDate06']) :
                                    $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate06']));
                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                    $nlevel = 6;
                                else :
                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";
                                    $nlevel = 6;
                                endif;
                            elseif ($value['Approved'] == 2) :
                                $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";
                                $nlevel = 6;
                            elseif ($value['Approved'] == 3) :
                                $astatus = "CANCELLED by ".$requestor_data[0]['FName']." ".$requestor_data[0]['LName'];
                                $nlevel = 6;
                            else :
                                $nlevel = 6;
                                $astatus = "<span class='lorangetext'>".$typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." for your APPROVAL</span>";
                                $displaychk = 1;
                                $signatory = $value['Signatory06'];
                            endif;

                        else :

                            $approver_data = $register->get_member($value['Signatory06']);
                            if ($value['Approved'] == 1) :
                                if ($value['ApprovedDate06']) :
                                    $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate06']));
                                    $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
                                    $nlevel = 6;
                                else :
                                    $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                    $nlevel = 6;
                                endif;
                            elseif ($value['Approved'] == 2) :
                                $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                $nlevel = 6;
                            elseif ($value['Approved'] == 3) :
                                $astatus = "CANCELLED by YOU";
                                $nlevel = 6;
                            else :
                                $nlevel = 6;
                                $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                            endif;

                        endif;

                    elseif (trim($value['Signatory05']) && $value['ApprovedDate04']) :

                        if ($value['Signatory05'] == $profile_idnum) :

                            $requestor_data = $register->get_member($value['EmpID']);
                            if ($value['Approved'] == 1) :
                                if ($value['ApprovedDate05']) :
                                    $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate05']));
                                    if (!trim($value['Signatory06']) || trim($value['Signatory06']) == '') :
                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                        $nlevel = 5;
                                    else:
                                        $nlevel = 6;
                                    endif;
                                else :
                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";
                                    $nlevel = 5;
                                endif;
                            elseif ($value['Approved'] == 2) :
                                $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";
                                $nlevel = 5;
                            elseif ($value['Approved'] == 3) :
                                $astatus = "CANCELLED by ".$requestor_data[0]['FName']." ".$requestor_data[0]['LName'];
                                $nlevel = 5;
                            else :
                                $nlevel = 5;
                                $astatus = "<span class='lorangetext'>".$typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." for your APPROVAL</span>";
                                $displaychk = 1;
                                $signatory = $value['Signatory05'];
                            endif;

                        else :

                            $approver_data = $register->get_member($value['Signatory05']);
                            if ($value['Approved'] == 1) :
                                if ($value['ApprovedDate05']) :
                                    $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate05']));
                                    if (!trim($value['Signatory06']) || trim($value['Signatory06']) == '') :
                                        $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
                                        $nlevel = 5;
                                    else :
                                        $nlevel = 6;
                                    endif;
                                else :
                                    $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                    $nlevel = 5;
                                endif;
                            elseif ($value['Approved'] == 2) :
                                $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                $nlevel = 5;
                            elseif ($value['Approved'] == 3) :
                                $astatus = "CANCELLED by YOU";
                                $nlevel = 5;
                            else :
                                $nlevel = 5;
                                $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                            endif;
                        endif;

                    elseif (trim($value['Signatory04']) && $value['ApprovedDate03']) :

                        if ($value['Signatory04'] == $profile_idnum) :

                            $requestor_data = $register->get_member($value['EmpID']);
                            if ($value['Approved'] == 1) :
                                if ($value['ApprovedDate04']) :
                                    $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate04']));
                                    if (!trim($value['Signatory05']) || trim($value['Signatory05']) == '') :
                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                        $nlevel = 4;
                                    else:
                                        $nlevel = 5;
                                    endif;
                                else :
                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";
                                    $nlevel = 4;
                                endif;
                            elseif ($value['Approved'] == 2) :
                                $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";
                                $nlevel = 4;
                            elseif ($value['Approved'] == 3) :
                                $astatus = "CANCELLED by ".$requestor_data[0]['FName']." ".$requestor_data[0]['LName'];
                                $nlevel = 4;
                            else :
                                $nlevel = 4;
                                $astatus = "<span class='lorangetext'>".$typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." for your APPROVAL</span>";
                                $displaychk = 1;
                                $signatory = $value['Signatory04'];
                            endif;

                        else :
                            $approver_data = $register->get_member($value['Signatory04']);
                            if ($value['Approved'] == 1) :
                                if ($value['ApprovedDate04']) :
                                    $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate04']));
                                    if (!trim($value['Signatory05']) || trim($value['Signatory05']) == '') :
                                        $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
                                        $nlevel = 4;
                                    else :
                                        $nlevel = 5;
                                    endif;
                                else :
                                    $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                    $nlevel = 4;
                                endif;
                            elseif ($value['Approved'] == 2) :
                                $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                $nlevel = 4;
                            elseif ($value['Approved'] == 3) :
                                $astatus = "CANCELLED by YOU";
                                $nlevel = 4;
                            else :
                                $nlevel = 4;
                                $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                            endif;
                        endif;

                    elseif (trim($value['Signatory03']) && $value['ApprovedDate02']) :

                        if ($value['Signatory03'] == $profile_idnum) :

                            $requestor_data = $register->get_member($value['EmpID']);
                            if ($value['Approved'] == 1) :
                                if ($value['ApprovedDate03']) :
                                    $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate03']));
                                    if (!trim($value['Signatory04']) || trim($value['Signatory04']) == '') :
                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                        $nlevel = 3;
                                    else:
                                        $nlevel = 4;
                                    endif;
                                else :
                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";
                                    $nlevel = 3;
                                endif;
                            elseif ($value['Approved'] == 2) :
                                $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";
                                $nlevel = 3;
                            elseif ($value['Approved'] == 3) :
                                $astatus = "CANCELLED by ".$requestor_data[0]['FName']." ".$requestor_data[0]['LName'];
                                $nlevel = 3;
                            else :
                                $nlevel = 3;
                                $astatus = "<span class='lorangetext'>".$typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." for your APPROVAL</span>";
                                $displaychk = 1;
                                $signatory = $value['Signatory03'];
                            endif;


                        else :
                            $approver_data = $register->get_member($value['Signatory03']);
                            if ($value['Approved'] == 1) :
                                if ($value['ApprovedDate03']) :
                                    $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate03']));
                                    if (!trim($value['Signatory04']) || trim($value['Signatory04']) == '') :
                                        $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
                                        $nlevel = 3;
                                    else :
                                        $nlevel = 4;
                                    endif;
                                else :
                                    $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                    $nlevel = 3;
                                endif;
                            elseif ($value['Approved'] == 2) :
                                $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                $nlevel = 3;
                            elseif ($value['Approved'] == 3) :
                                $astatus = "CANCELLED by YOU";
                                $nlevel = 3;
                            else :
                                $nlevel = 3;
                                $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                            endif;
                        endif;

                    elseif (trim($value['Signatory02']) && $value['ApprovedDate01']) :

                        if ($value['Signatory02'] == $profile_idnum) :
                            $requestor_data = $register->get_member($value['EmpID']);
                            if ($value['Approved'] == 1) :
                                if ($value['ApprovedDate02']) :
                                    $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate02']));
                                    if (!trim($value['Signatory03']) || trim($value['Signatory03']) == '') :
                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                        $nlevel = 2;
                                    else:
                                        $nlevel = 3;
                                    endif;
                                else :
                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";
                                    $nlevel = 2;
                                endif;
                            elseif ($value['Approved'] == 2) :
                                $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";
                                $nlevel = 2;
                            elseif ($value['Approved'] == 3) :
                                $astatus = "CANCELLED by ".$requestor_data[0]['FName']." ".$requestor_data[0]['LName'];
                                $nlevel = 2;
                            else :
                                $nlevel = 2;
                                $astatus = "<span class='lorangetext'>".$typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." for your APPROVAL</span>";
                                $displaychk = 1;
                                $signatory = $value['Signatory02'];
                            endif;
                        else :
                            $approver_data = $register->get_member($value['Signatory02']);
                            if ($value['Approved'] == 1) :
                                if ($value['ApprovedDate02']) :
                                    $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate02']));
                                    if (!trim($value['Signatory03']) || trim($value['Signatory03']) == '') :
                                        $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
                                        $nlevel = 2;
                                    else :
                                        $nlevel = 3;
                                    endif;
                                else :
                                    $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                    $nlevel = 2;
                                endif;
                            elseif ($value['Approved'] == 2) :
                                $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                $nlevel = 2;
                            elseif ($value['Approved'] == 3) :
                                $astatus = "CANCELLED by YOU";
                                $nlevel = 2;
                            else :
                                $nlevel = 2;
                                $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                            endif;

                        endif;

                    endif;

                ?>
                <tr class="trdata centertalign whitetext" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>">
                    <!--td class="centertalign"><?php if ($displaychk) : ?><input id="chkapp<?php echo $key; ?>" type="checkbox" name="chkapp[<?php echo $key; ?>]" value="<?php echo $value['Reference']; ?>" attribute="<?php echo $value['DocType']; ?>" attribute2="<?php echo $profile_idnum; ?>" attribute3="<?php echo $value['EmpID']; ?>" attribute4="<?php echo $value['DocType'] == 'OT' ? $ot_data[0]['ApprovedHrs'] : 0; ?>" class="chkapp" /><?php endif; ?></td-->
                    <td class="btnnotidata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>"><?php echo $value['DocType']; ?></td>
                    <td class="btnnotidata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>"><?php echo $value['Reference']; ?></td>
                    <td class="btnnotidata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>"><?php echo $nlevel; ?></td>
                    <td class="btnnotidata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>"><?php echo date("M j, Y g:ia", strtotime($value['DateFiled'])); ?></td>
                    <td class="btnnotidata cursorpoint tinytext" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>"><?php echo $astatus; ?></td>
                    <td class="btnnotidata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>"><?php echo $date_approved; ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if ($pages) : ?>
                <tr>
                    <td colspan="6" class="centertalign"><?php echo $pages; ?></td>
                </tr>
                <?php endif; ?>
                <?php else : ?>
                <tr>
                    <td class="bold centertalign noborder"><br><br>You have no unread notification</td>
                </tr>
                <?php endif; ?>
            </table>
            <input type="hidden" id="notipage" name="notipage" value="<?php echo $page; ?>" />

            <?php
        break;
        default:
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";

    }

?>
