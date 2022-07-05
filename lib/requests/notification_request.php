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
	include(CLASSES."/lmssql.class.php");

    $mainsql = new mainsql;
    $register = new regsql;
    $pafsql	= new pafsql;
	$lmssql = new lmssql;

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
		case 'lmsview':
		case 'lmssubmit':
        case 'lmsdelete':
        case 'lvcancel':
        case 'mdcancel':
		case 'sccancel':
		case 'coeprint':
		case 'coesend':
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
            dbname = $("#dbname").val();
            doctype = $(this).attr("attribute");
            user = $(this).attr("attribute2");
            userdb = $(this).attr("attribute20");
            nxtapp = $(this).attr("attribute21");
            nxtappdb = $(this).attr("attribute22");
            reqnbr = $(this).attr("attribute3");
            empid = $(this).attr("attribute4");
            trans = 'APPROVED';

			if (doctype == "WH") {
				var whArray = [];
				var count = 0;
				$.each($('.wfhseq'),function (){

					arrayid = $(this).attr('attribute');

					whArray[count] = { "SeqID" : $(this).val(), "ApprovedHrs" : $("#wfhApprovedHrs" + arrayid).val() };

					count++;
				});

				var tempData = [];
				for(var index=0; index<whArray.length; index++){
						tempData.push(whArray[index]);
				}
				var whJSON = JSON.stringify(tempData);

				var r = confirm("This action cannot be UNDONE. Are you sure you want to approve this request?");

                if (r == true)
                {
                    var approve_msg;
                    var pendpage = $("#pendpage").val();

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
                        data: "trans=" + trans + "&remarks=" + remarks + "&doctype=" + doctype + "&reqnbr=" + reqnbr
						+ "&user=" + user + "&userdb=" + userdb + "&nxtapp=" + nxtapp  + "&nxtappdb=" + nxtappdb
						+ "&empid=" + empid + "&data=" +  whJSON + "&dbname=" + dbname ,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {
							console.log(data);
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
                                    url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=tablepend&page=" + pendpage,
                                    data: "searchnoti=" + searchnoti + "&notifrom=" + notifrom + "&notito=" + notito,
                                    type: "POST",
                                    complete: function(){
                                        $("#loading").hide();
                                    },
                                    success: function(data) {
                                        $("#btnnotiall").removeClass("invisible");
                                        $("#penddata").html(data);
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
            else if (doctype == "OT") {

                approvehours = $("#approvehours").val();

                var r = confirm("This action cannot be UNDONE. Are you sure you want to approve this request?");

                if (r == true)
                {
                    var approve_msg;
                    var pendpage = $("#pendpage").val();

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
                        data: "trans=" + trans + "&remarks=" + remarks + "&doctype=" + doctype + "&reqnbr=" + reqnbr + "&user=" + user + "&userdb=" + userdb + "&nxtapp=" + nxtapp  + "&nxtappdb=" + nxtappdb + "&empid=" + empid + "&approvehours=" + approvehours + "&dbname=" + dbname,
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
                                    url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=tablepend&page=" + pendpage,
                                    data: "searchnoti=" + searchnoti + "&notifrom=" + notifrom + "&notito=" + notito,
                                    type: "POST",
                                    complete: function(){
                                        $("#loading").hide();
                                    },
                                    success: function(data) {
                                        $("#btnnotiall").removeClass("invisible");
                                        $("#penddata").html(data);
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
                    var pendpage = $("#pendpage").val();

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
                        data: "trans=" + trans + "&remarks=" + remarks + "&doctype=" + doctype + "&reqnbr=" + reqnbr + "&user=" + user + "&userdb=" + userdb + "&empid=" + empid + "&dbname=" + dbname,
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
                                    url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=tablepend&page=" + pendpage,
                                    data: "searchnoti=" + searchnoti + "&notifrom=" + notifrom + "&notito=" + notito,
                                    type: "POST",
                                    complete: function(){
                                        $("#loading").hide();
                                    },
                                    success: function(data) {
                                        $("#btnnotiall").removeClass("invisible");
                                        $("#penddata").html(data);
                                        changeUrl('', '<?php echo WEB; ?>/pending');
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
            dbname = $("#dbname").val();
            doctype = $(this).attr("attribute");
            user = $(this).attr("attribute2");
            userdb = $(this).attr("attribute20");
            reqnbr = $(this).attr("attribute3");
            empid = $(this).attr("attribute4");
            trans = 'REJECT';

            var r = confirm("This action is cannot be UNDONE. Are you sure you want to reject this request?");

            if (r == true)
            {
                var approve_msg;
                var pendpage = $("#pendpage").val();

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
                    data: "trans=" + trans + "&remarks=" + remarks + "&doctype=" + doctype + "&reqnbr=" + reqnbr + "&user=" + user + "&userdb=" + userdb + "&empid=" + empid + "&dbname=" + dbname,
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
                                url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=tablepend&page=" + pendpage,
                                data: "searchnoti=" + searchnoti + "&notifrom=" + notifrom + "&notito=" + notito,
                                type: "POST",
                                complete: function(){
                                    $("#loading").hide();
                                },
                                success: function(data) {
                                    $("#btnnotiall").removeClass("invisible");
                                    $("#penddata").html(data);
                                    changeUrl('', '<?php echo WEB; ?>/pending');
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
            dbname = $("#dbname").val();
            doctype = $(this).attr("attribute");
            user = 0;
            reqnbr = $(this).attr("attribute3");
            empid = $(this).attr("attribute4");
            trans = 'CANCEL';

            var r = confirm("This action is cannot be UNDONE. Are you sure you want to cancel this request?");

            if (r == true)
            {

                var approve_msg;

                var pendpage = $("#pendpage").val();

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
                    data: "trans=" + trans + "&remarks=" + remarks + "&doctype=" + doctype + "&reqnbr=" + reqnbr + "&user=" + user + "&empid=" + empid + "&dbname=" + dbname,
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
                                url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=tablepend&page=" + pendpage,
                                data: "searchnoti=" + searchnoti + "&notifrom=" + notifrom + "&notito=" + notito,
                                type: "POST",
                                complete: function(){
                                    $("#loading").hide();
                                },
                                success: function(data) {
                                    $("#btnnotiall").removeClass("invisible");
                                    $("#penddata").html(data);
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

        $(".btnlvcancel").on("click", function() {

            reqnbr = $(this).attr("attribute");
            dtrdate = $(this).attr("attribute2");
            status = 0;

            var r = confirm("This action is cannot be UNDONE. Are you sure you want to cancel this dated leave?");
            if (r == true)
            {
                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=lvcancel",
                    data: "reqnbr=" + reqnbr + "&dtrdate=" + dtrdate,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {

                        $.ajax(
                        {
                            url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=lvtable",
                            data: "reqnbr=" + reqnbr,
                            type: "POST",
                            complete: function(){
                                $("#loading").hide();
                            },
                            success: function(data) {
                                $(".divlvdata").html(data);
                            }
                        })

                    }
                })
            }
        });

        $(".btnobcancel").on("click", function() {

            reqnbr = $(this).attr("attribute");
            dtrdate = $(this).attr("attribute2");
            seqid = $(this).attr("attribute3");
            status = 0;

            var r = confirm("This action is cannot be UNDONE. Are you sure you want to cancel this dated OBT?");
            if (r == true)
            {
                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=obcancel",
                    data: "seqid=" + seqid,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {

                        $.ajax(
                        {
                            url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=obtable",
                            data: "reqnbr=" + reqnbr,
                            type: "POST",
                            complete: function(){
                                $("#loading").hide();
                            },
                            success: function(data) {
                                $(".divobdata").html(data);
                            }
                        })

                    }
                })
            }
        });

        $(".btnmdcancel").on("click", function() {

            reqnbr = $(this).attr("attribute");
            dtrdate = $(this).attr("attribute2");
            status = 0;

            var r = confirm("This action is cannot be UNDONE. Are you sure you want to cancel this dated manual DTR?");
            if (r == true)
            {
                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=mdcancel",
                    data: "reqnbr=" + reqnbr + "&dtrdate=" + dtrdate,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {

                        $.ajax(
                        {
                            url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=mdtable",
                            data: "reqnbr=" + reqnbr,
                            type: "POST",
                            complete: function(){
                                $("#loading").hide();
                            },
                            success: function(data) {
                                $(".divmddata").html(data);
                            }
                        })

                    }
                })
            }
        });

        $(".btnsccancel").on("click", function() {

            reqnbr = $(this).attr("attribute");
            dtrdate = $(this).attr("attribute2");
            status = 0;

            var r = confirm("This action is cannot be UNDONE. Are you sure you want to cancel this dated change of schedule?");
            if (r == true)
            {
                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=sccancel",
                    data: "reqnbr=" + reqnbr + "&dtrdate=" + dtrdate,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {

                        $.ajax(
                        {
                            url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=sctable",
                            data: "reqnbr=" + reqnbr,
                            type: "POST",
                            complete: function(){
                                $("#loading").hide();
                            },
                            success: function(data) {
                                $(".divtsdata").html(data);
                            }
                        })

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
						else if (doctype == 'WH') {
                title = "Work From Home #";
            }

            $("#noti_title").html(title + ' ' + refnum);
            $(".floatdiv").removeClass("invisible");
            $("#nview").show({
              effect : 'slide',
              easing : 'easeOutQuart',
              direction : 'up',
              duration : 500
            });

            $("#noti_data").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

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


        $(".btnrnotidata").on("click", function() {

            doctype = $(this).attr('attribute2');
            refnum = $(this).attr('attribute');
            dbname = $('#rmandb').val();

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
						}

            $("#noti_title").html(title + ' ' + refnum);
            $(".floatdiv").removeClass("invisible");
            $("#nview").show({
              effect : 'slide',
              easing : 'easeOutQuart',
              direction : 'up',
              duration : 500
            });

            $("#noti_data").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=datarman",
                data: "refnum=" + refnum + "&doctype=" + doctype + "&dbname=" + dbname,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $("#noti_data").html(data);
                }
            })
        });


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
                title = "Work From Home #";
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

        $("#chknotiall").change(function() {
            $('#checknoti input[type="checkbox"]').prop('checked', this.checked);
        });

        </script>
        <?php
        break;
     }
     ?>

    <?php

    switch ($sec) {
        case 'periodsel':
            $dtr_year = $_POST['year'];

            $year_select = '';
            $dtr_period = $mainsql->get_dtr_period($dtr_year, $profile_comp);
            if ($dtr_period) :
                foreach ($dtr_period as $key => $value) :
                    $year_select .= '<option value="'.date("Y-m-d", strtotime($value['PRFrom']))." ".date("Y-m-d", strtotime($value['PRTo'])).'">'.$value['PeriodID']." ".$value['PRYear']." ".date("m/d/Y", strtotime($value['PRFrom']))." to ".date("m/d/Y", strtotime($value['PRTo'])).'</option>';
                endforeach;
            endif;
            echo $year_select;
        break;
        case 'lvcancel':

            $lvcpost['REQ'] = $_POST['reqnbr'];
            $lvcpost['DTRDATE'] = $_POST['dtrdate'];
            $lvcpost['STATUS'] = 0;

            $lvcancel_request = $mainsql->leave_action($lvcpost, 'lvitemcancel');

            echo $lvcancel_request;

        break;
        case 'obcancel':

            $obcpost['SEQID'] = $_POST['seqid'];
            $obcancel_request = $mainsql->ob_action($obcpost, 'obitemcancel');

            echo $obcancel_request;

        break;
        case 'mdcancel':
            $mdcpost['REQ'] = $_POST['reqnbr'];
            $mdcpost['DTRDATE'] = $_POST['dtrdate'];
            $mdcpost['STATUS'] = 0;

            $mdcancel_request = $mainsql->md_action($mdcpost, 'mditemcancel');

            echo $mdcancel_request;

        break;
        case 'sccancel':

            $sccpost['REQ'] = $_POST['reqnbr'];
            $sccpost['DTRDATE'] = $_POST['dtrdate'];
            $sccpost['STATUS'] = 0;

            $sccancel_request = $mainsql->sc_action($sccpost, 'scitemcancel');

            echo $sccancel_request;

        break;
        case 'lvtable':

            $refnum = $_POST['reqnbr'];
            $applv_data = $tblsql->get_leavedata($refnum);
            $applv_count = count($applv_data);

            ?>
            <table class="tdatablk">
                <tr>
                    <th>Date</th>
                    <th>Duration</th>
                    <th>w/ Pay</th>
                    <th>Cancel</th>
                </tr>
                <?php
                    foreach($applv_data as $key => $value) :
                ?>
                <tr>
                    <td><?php echo date("M j", strtotime($value['LeaveDate'])); ?></td>
                    <td><?php
                        if ($value['Duration'] == "WD") :
                            echo "Whole Day";
                        elseif ($value['Duration'] == "HD") :
                            echo "Half Day";
                        elseif ($value['Duration'] == "HD1") :
                            echo "Half Day AM";
                        elseif ($value['Duration'] == "HD2") :
                            echo "Half Day PM";
                        endif;
                    ?></td>
                    <td class="centertalign">
                        <?php echo $value['WithPay'] ? "<i class='fa fa-check'></i>" : "<i class='fa fa-times'></i>"; ?>
                    </td>
                    <td class="centertalign"><?php if ($applv_count > 1) : ?><i class="btnlvcancel fa fa-times redtext cursorpoint" attribute="<?php echo $refnum; ?>" attribute2="<?php echo date('Y-m-d 00:00:00.000', strtotime($value['LeaveDate'])); ?>"></i><?php endif; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php
        break;
        case 'obtable':

            $refnum = $_POST['reqnbr'];
            $appobt_data = $tblsql->get_obtdata($refnum);
            $appobt_count = count($appobt_data);

            ?>
            <table class="tdatablk">
                <tr>
                    <th>In</th>
                    <th>Out</th>
                    <th>Cancel</th>
                </tr>
                <?php foreach($appobt_data as $key => $value) : ?>
                <tr>
                    <td><?php echo date("M j, Y g:ia", strtotime($value['ObTimeInDate'])); ?></td>
                    <td><?php echo date("M j, Y g:ia", strtotime($value['ObTimeOutDate'])); ?></td>
                    <td class="centertalign"><?php if ($appobt_count > 1) : ?><i class="btnobcancel fa fa-times redtext cursorpoint" attribute="<?php echo $refnum; ?>" attribute2="<?php echo date('Y-m-d', strtotime($value['ObTimeInDate'])); ?>" attribute3="<?php echo $value['SeqID']; ?>"></i><?php endif; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php
        break;
        case 'mdtable':

            $refnum = $_POST['reqnbr'];
            $appmd_data = $mainsql->get_mdtrdata($refnum);
            $appmd_count = count($appmd_data);

            ?>
            <table class="tdatablk">
                <tr>
                    <th width="100px">DTR Date</th>
                    <th width="80px">Day</th>
                    <th width="100px">Time IN</th>
                    <?php if ($value['Activities']) : ?>
                    <th width="200px">Activities</th>
                    <th width="150px">Shift Desc</th>
                    <th width="150px">New Shift Desc</th>
                    <?php else : ?>
                    <th width="100px">Time OUT</th>
                    <th width="200px">Shift Desc</th>
                    <th width="200px">New Shift Desc</th>
                    <?php endif; ?>
                    <th width="100px">Cancel</th>
                </tr>
                <?php
                    foreach ($appmd_data as $key => $value) :
                        $shifts2 = $mainsql->get_shift($value['NewShiftDesc']);
                        ?>
                        <tr>
                            <?php $timearray = preg_split('/\s+/', trim($value['TimeIn'])); $timearray2 = preg_split('/\s+/', trim($value['TimeOUt'])); ?>
                            <td><?php echo date('F j, Y', strtotime($value['DTRDate'])); ?></td>
                            <td><?php echo $value['Day']; ?></td>
                            <td><?php echo $timearray[3] ? date('g:ia', strtotime($timearray[3])) : ''; ?></td>
                            <?php if ($value['Activities']) : ?>
                            <td><?php echo $value['Activities']; ?></td>
                            <?php else : ?>
                            <td><?php echo $timearray[3] ? date('g:ia', strtotime($timearray2[3])) : ''; ?></td>
                            <?php endif; ?>
                            <td><?php echo $value['ShiftDesc']; ?></td>
                            <td><?php echo $value['NewShiftDesc'] ? $shifts2[0]['ShiftDesc'] : 'REST DAY'; ?></td>

                            <td class="centertalign"><?php if ($appmd_count > 1) : ?><i class="btnmdcancel fa fa-times redtext cursorpoint" attribute="<?php echo $refnum; ?>" attribute2="<?php echo date('Y-m-d 00:00:00.000', strtotime($value['DTRDate'])); ?>"></i><?php endif; ?></td>
                        </tr>
                        <?php
                    endforeach;
                ?>
            </table>
            <?php
        break;
        case 'sctable':

            $refnum = $_POST['reqnbr'];
            $appts_data = $tblsql->get_tsdata($refnum);
            $appts_count = count($appts_data);

            ?>
            <table class="tdatablk">
                <tr>
                    <th width="100px">DTR Date</th>
                    <th width="200px">Current Shift Desc</th>
                    <th width="200px">New Shift Desc</th>
                    <th width="150px">Shift Time IN</th>
                    <th width="150px">Shift Time OUT</th>
                    <th width="80px">Cancel</th>
                </tr>
                <?php
                    foreach ($appts_data as $key => $value) :
                        $oldshiftdesc = $mainsql->get_shift($value['ShiftID']);
                        ?>
                        <tr>
                            <td><?php echo date('M j, Y', strtotime($value['DTRDate'])); ?></td>
                            <td><?php echo $value['ShiftID'] ? $oldshiftdesc[0]['ShiftDesc'] : 'REST DAY'; ?></td>
                            <td><?php echo $value['NewShiftDesc'] ? $value['NewShiftDesc'] : 'REST DAY'; ?></td>
                            <td><?php echo $value['TimeIn'] ? date('g:ia', strtotime($value['TimeIn'])) : 'N/A'; ?></td>
                            <td><?php echo $value['TimeOut'] ? date('g:ia', strtotime($value['TimeOut'])) : 'N/A'; ?></td>
                            <td class="centertalign"><?php if ($appts_count > 1) : ?><i class="btnsccancel fa fa-times redtext cursorpoint" attribute="<?php echo $refnum; ?>" attribute2="<?php echo date('Y-m-d 00:00:00.000', strtotime($value['DTRDate'])); ?>"></i><?php endif; ?></td>
                        </tr>
                        <?php
                        $pdtrto = strtotime($value['DTRDate']);
                    endforeach;
                ?>
            </table>
            <?php
        break;
        case 'table':

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NOTI_NUM_ROWS * ($page - 1);

            if ($_POST['clear_search']) :

                unset($_SESSION['searchnoti']);
                unset($_SESSION['notitype']);
                unset($_SESSION['notifrom']);
                unset($_SESSION['notito']);

            else :

                $searchnoti_sess = $_SESSION['searchnoti'];
                $notitype_sess = $_SESSION['notitype'];
                $notifrom_sess = $_SESSION['notifrom'];
                $notito_sess = $_SESSION['notito'];
                if ($_POST) {
                    $searchnoti = $_POST['searchnoti'] ? $_POST['searchnoti'] : NULL;
                    $_SESSION['searchnoti'] = $searchnoti;
                    $notitype = $_POST['notitype'] ? $_POST['notitype'] : NULL;
                    $_SESSION['notitype'] = $notitype;
                    $notifrom = $_POST['notifrom'] ? $_POST['notifrom'] : NULL;
                    $_SESSION['notifrom'] = $notifrom;
                    $notito = $_POST['notito'] ? $_POST['notito'] : NULL;
                    $_SESSION['notito'] = $notito;
                }
                elseif ($searchnoti_sess || $notitype_sess) {
                    $searchnoti = $searchnoti_sess ? $searchnoti_sess : NULL;
                    $_POST['searchnoti'] = $searchnoti != 0 ? $searchnoti : NULL;
                    $notitype = $notitype_sess ? $notitype_sess : NULL;
                    $_POST['notitype'] = $notitype != 0 ? $notitype : NULL;
                    $notifrom = $notifrom_sess ? $notifrom_sess : NULL;
                    $_POST['notifrom'] = $notifrom != 0 ? $notifrom : NULL;
                    $notito = $notito_sess ? $notito_sess : NULL;
                    $_POST['notito'] = $notito != 0 ? $notito : NULL;
                }
                else {
                    $searchnoti = NULL;
                    $_POST['searchnoti'] = NULL;
                    $notitype = NULL;
                    $_POST['notitype'] = NULL;
                    $notifrom = NULL;
                    $_POST['notifrom'] = NULL;
                    $notito = NULL;
                    $_POST['notito'] = NULL;
                }

            endif;

            //var_dump($searchnoti);


            $notification_data = $tblsql->get_notification(NULL, $start, NOTI_NUM_ROWS, $searchnoti, 0, $profile_idnum, $notifrom, $notito, $notitype);
            $notification_count = $tblsql->get_notification(NULL, 0, 0, $searchnoti, 1, $profile_idnum, $notifrom, $notito, $notitype);

            $pages = $mainsql->pagination("notification", $notification_count, NOTI_NUM_ROWS, 9);

            //var_dump($notification_data);
            ?>

            <table border="0" cellspacing="0" class="tdata width100per">
                <?php if ($notification_data) : ?>
                <tr>
                    <th width="4%">&nbsp;</th>
                    <th width="5%">Type</th>
                    <th width="20%">Reference #</th>
                    <th width="7%">Level</th>
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
                        $ot_data = $mainsql->get_overtimedata($value['Reference'], $value['DBNAME']);
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

                            $requestor_data = $register->get_allmember($value['EmpID']);
                            if ($value['Approved'] == 1) :
                                if ($value['ApprovedDate01']) :
                                    $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate01']));
                                    if (!trim($value['Signatory02']) || trim($value['Signatory02']) == '') :
                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                        $nlevel = 1;
                                    else:
                                        $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
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
                            $approver_data = $register->get_allmember($value['Signatory01']);
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

                            $requestor_data = $register->get_allmember($value['EmpID']);
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

                            $approver_data = $register->get_allmember($value['Signatory06']);
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

                            $requestor_data = $register->get_allmember($value['EmpID']);
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

                            $approver_data = $register->get_allmember($value['Signatory05']);
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

                            $requestor_data = $register->get_allmember($value['EmpID']);
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
                            $approver_data = $register->get_allmember($value['Signatory04']);
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

                            $requestor_data = $register->get_allmember($value['EmpID']);
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
                            $approver_data = $register->get_allmember($value['Signatory03']);
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
                            $requestor_data = $register->get_allmember($value['EmpID']);
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
                            $approver_data = $register->get_allmember($value['Signatory02']);
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
                    <td class="centertalign"><?php if ($displaychk) : ?><input id="chkapp<?php echo $key; ?>" type="checkbox" name="chkapp[<?php echo $key; ?>]" value="<?php echo $value['Reference']; ?>" attribute="<?php echo $value['DocType']; ?>" attribute2="<?php echo $profile_idnum; ?>" attribute3="<?php echo $value['EmpID']; ?>" attribute4="<?php echo $value['DocType'] == 'OT' ? $ot_data[0]['ApprovedHrs'] : 0; ?>" class="chkapp" /><?php endif; ?></td>
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
                    <td colspan="7" class="centertalign"><?php echo $pages; ?></td>
                </tr>
                <?php endif; ?>
                <?php else : ?>
                <tr>
                    <td class="bold centertalign noborder"><br><br>You have no notification</td>
                </tr>
                <?php endif; ?>
            </table>
            <input type="hidden" id="notipage" name="notipage" value="<?php echo $page; ?>" />

            <?php
        break;

        /*case 'tableunread':



            $notification_data = $tblsql->get_notification(NULL, $start, NOTI_NUM_ROWS, $searchnoti, 0, $profile_idnum, $notifrom, $notito, $notitype);
            $notification_count = $tblsql->get_notification(NULL, 0, 0, $searchnoti, 1, $profile_idnum, $notifrom, $notito, $notitype);

            $pages = $mainsql->pagination("notification", $notification_count, NOTI_NUM_ROWS, 9);

            //var_dump($notification_data);
            ?>

            <table border="0" cellspacing="0" class="tdata width100per">
                <?php if ($notification_data) : ?>
                <tr>
                    <th width="4%">&nbsp;</th>
                    <th width="5%">Type</th>
                    <th width="20%">Reference #</th>
                    <th width="7%">Level</th>
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

                            $requestor_data = $register->get_allmember($value['EmpID']);
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
                            $approver_data = $register->get_allmember($value['Signatory01']);
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

                            $requestor_data = $register->get_allmember($value['EmpID']);
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

                            $approver_data = $register->get_allmember($value['Signatory06']);
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

                            $requestor_data = $register->get_allmember($value['EmpID']);
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

                            $approver_data = $register->get_allmember($value['Signatory05']);
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

                            $requestor_data = $register->get_allmember($value['EmpID']);
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
                            $approver_data = $register->get_allmember($value['Signatory04']);
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

                            $requestor_data = $register->get_allmember($value['EmpID']);
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
                            $approver_data = $register->get_allmember($value['Signatory03']);
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
                            $requestor_data = $register->get_allmember($value['EmpID']);
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
                            $approver_data = $register->get_allmember($value['Signatory02']);
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
                    <td class="centertalign"><?php if ($displaychk) : ?><input id="chkapp<?php echo $key; ?>" type="checkbox" name="chkapp[<?php echo $key; ?>]" value="<?php echo $value['Reference']; ?>" attribute="<?php echo $value['DocType']; ?>" attribute2="<?php echo $profile_idnum; ?>" attribute3="<?php echo $value['EmpID']; ?>" attribute4="<?php echo $value['DocType'] == 'OT' ? $ot_data[0]['ApprovedHrs'] : 0; ?>" class="chkapp" /><?php endif; ?></td>
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
                    <td colspan="7" class="centertalign"><?php echo $pages; ?></td>
                </tr>
                <?php endif; ?>
                <?php else : ?>
                <tr>
                    <td class="bold centertalign noborder"><br><br>You have no notification</td>
                </tr>
                <?php endif; ?>
            </table>
            <input type="hidden" id="notipage" name="notipage" value="<?php echo $page; ?>" />

            <?php
        break;*/

        case 'tablepend':

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NOTI_NUM_ROWS * ($page - 1);

            if ($_POST['clear_search']) :

                unset($_SESSION['searchpend']);
                unset($_SESSION['pendtype']);
                unset($_SESSION['pendfrom']);
                unset($_SESSION['pendto']);

            else :

                $searchpend_sess = $_SESSION['searchpend'];
                $pendtype_sess = $_SESSION['pendtype'];
                $pendfrom_sess = $_SESSION['pendfrom'];
                $pendto_sess = $_SESSION['pendto'];
                if ($_POST) {
                    $searchpend = $_POST['searchpend'] ? $_POST['searchpend'] : NULL;
                    $_SESSION['searchpend'] = $searchpend;
                    $pendtype = $_POST['pendtype'] ? $_POST['pendtype'] : NULL;
                    $_SESSION['pendtype'] = $pendtype;
                    $pendfrom = $_POST['pendfrom'] ? $_POST['pendfrom'] : NULL;
                    $_SESSION['pendfrom'] = $pendfrom;
                    $pendto = $_POST['pendto'] ? $_POST['pendto'] : NULL;
                    $_SESSION['pendto'] = $pendto;
                }
                elseif ($searchpend_sess) {
                    $searchpend = $searchpend_sess ? $searchpend_sess : NULL;
                    $_POST['searchpend'] = $searchpend != 0 ? $searchpend : NULL;
                    $pendtype = $pendtype_sess ? $pendtype_sess : NULL;
                    $_POST['pendtype'] = $pendtype != 0 ? $pendtype : NULL;
                    $pendfrom = $pendfrom_sess ? $pendfrom_sess : NULL;
                    $_POST['pendfrom'] = $pendfrom != 0 ? $pendfrom : NULL;
                    $pendto = $pendto_sess ? $pendto_sess : NULL;
                    $_POST['pendto'] = $pendto != 0 ? $pendto : NULL;
                }
                else {
                    $searchpend = NULL;
                    $_POST['searchpend'] = NULL;
                    $pendtype = NULL;
                    $_POST['pendtype'] = NULL;
                    $pendfrom = NULL;
                    $_POST['pendfrom'] = NULL;
                    $pendto = NULL;
                    $_POST['pendto'] = NULL;
                }

            endif;

            //var_dump($searchnoti);


            $pending_data = $tblsql->get_pendingnoti(NULL, $start, NOTI_NUM_ROWS, $searchpend, 0, $profile_idnum, $pendfrom, $pendto, $pendtype, $profile_dbname);
            $pending_count = $tblsql->get_pendingnoti(NULL, 0, 0, $searchpend, 1, $profile_idnum, $pendfrom, $pendto, $pendtype, $profile_dbname);

            //var_dump($pending_count);

		    $pages = $mainsql->pagination("pending", $pending_count, NOTI_NUM_ROWS, 9);

            //var_dump($notification_data);
            ?>

            <table border="0" cellspacing="0" class="tdata width100per">
                <?php if ($pending_data) : ?>
                <tr>
                    <th width="4%"><input id="chkappall" type="checkbox" name="chkappall" value="1" class="chkappall" /></th>
                    <th width="5%">Type</th>
                    <th width="20%">Reference #</th>
                    <th width="7%">Level</th>
                    <th width="18%">Date Filed</th>
                    <th width="26%">Status</th>
                    <th width="20%">Last Updated</th>
                </tr>
                <?php foreach ($pending_data as $key => $value) :

                    //READ STATUS
                    $get_read = $mainsql->get_read($profile_idnum, $value['Reference'], 1);

                    if ($value['DocType'] == 'LV') :
                        $typestat = "LEAVE APPLICATION from ";
                    elseif ($value['DocType'] == 'OT') :
                        $typestat = "OVERTIME APPLICATION from ";
                        $ot_data = $mainsql->get_overtimedata($value['Reference'], $value['DBNAME']);
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
										elseif ($value['DocType'] == 'WH') :
                        $typestat = "WORK FROM HOME APPLICATION from ";
                    endif;

                    //var_dump($value['Signatory06']);

                    $displaychk = 0;

                    if (trim($value['Signatory01'])) :

                        if ($value['Signatory01'] == $profile_idnum) :

                            $requestor_data = $logsql->get_allmember($value['EmpID'], $value['DBNAME']);
                            if ($value['Approved'] == 1) :
                                if ($value['ApprovedDate01']) :
                                    $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate01']));
                                    if (trim($value['Signatory02']) == '') :
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
                            $approver_data = $logsql->get_allmember($value['Signatory01'], $value['SignatoryDB01']);
                            if ($value['Approved'] == 1) :
                                if ($value['ApprovedDate01']) :
                                    $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate01']));
                                    if (trim($value['Signatory02']) == '') :
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

                            $requestor_data = $logsql->get_allmember($value['EmpID'], $value['DBNAME']);
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

                            $approver_data = $logsql->get_allmember($value['Signatory06'], $value['SignatoryDB06']);
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

                            $requestor_data = $logsql->get_allmember($value['EmpID'], $value['DBNAME']);
                            if ($value['Approved'] == 1) :
                                if ($value['ApprovedDate05']) :
                                    $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate05']));
                                    if (trim($value['Signatory06']) == '') :
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

                            $approver_data = $logsql->get_allmember($value['Signatory05'], $value['SignatoryDB05']);
                            if ($value['Approved'] == 1) :
                                if ($value['ApprovedDate05']) :
                                    $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate05']));
                                    if (trim($value['Signatory06']) == '') :
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

                            $requestor_data = $logsql->get_allmember($value['EmpID'], $value['DBNAME']);
                            if ($value['Approved'] == 1) :
                                if ($value['ApprovedDate04']) :
                                    $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate04']));
                                    if (trim($value['Signatory05']) == '') :
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
                            $approver_data = $logsql->get_allmember($value['Signatory04'], $value['SignatoryDB04']);
                            if ($value['Approved'] == 1) :
                                if ($value['ApprovedDate04']) :
                                    $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate04']));
                                    if (trim($value['Signatory05']) == '') :
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

                            $requestor_data = $logsql->get_allmember($value['EmpID'], $value['DBNAME']);
                            if ($value['Approved'] == 1) :
                                if ($value['ApprovedDate03']) :
                                    $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate03']));
                                    if (trim($value['Signatory04']) == '') :
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
                            $approver_data = $logsql->get_allmember($value['Signatory03'], $value['SignatoryDB03']);
                            if ($value['Approved'] == 1) :
                                if ($value['ApprovedDate03']) :
                                    $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate03']));
                                    if (trim($value['Signatory04']) == '') :
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
                            $requestor_data = $logsql->get_allmember($value['EmpID'], $value['DBNAME']);
                            if ($value['Approved'] == 1) :
                                if ($value['ApprovedDate02']) :
                                    $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate02']));
                                    if (trim($value['Signatory03']) == '') :
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
                            $approver_data = $logsql->get_allmember($value['Signatory02'], $value['SignatoryDB02']);
                            if ($value['Approved'] == 1) :
                                if ($value['ApprovedDate02']) :
                                    $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate02']));
                                    if (trim($value['Signatory03']) == '') :
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
                <tr class="trdata centertalign<?php echo $get_read ? ' lorangetext' : ' whitetext'; ?>" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>" attribute5="<?php echo $value['DBNAME']; ?>">
                    <td class="centertalign"><?php if ($displaychk) : ?><input id="chkapp<?php echo $key; ?>" type="checkbox" name="chkapp[<?php echo $key; ?>]" value="<?php echo $value['Reference']; ?>" attribute="<?php echo $value['DocType']; ?>" attribute2="<?php echo $profile_idnum; ?>" attribute3="<?php echo $value['EmpID']; ?>" attribute4="<?php echo $value['DocType'] == 'OT' ? $ot_data[0]['ApprovedHrs'] : 0; ?>" attribute5="<?php echo $value['DBNAME']; ?>" class="chkapp" /><?php endif; ?></td>
                    <td class="btnpenddata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>" attribute5="<?php echo $value['DBNAME']; ?>"><?php echo $value['DocType']; ?></td>
                    <td class="btnpenddata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>" attribute5="<?php echo $value['DBNAME']; ?>"><?php echo $value['Reference']; ?></td>
                    <td class="btnpenddata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>" attribute5="<?php echo $value['DBNAME']; ?>"><?php echo $nlevel; ?></td>
                    <td class="btnpenddata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>" attribute5="<?php echo $value['DBNAME']; ?>"><?php echo date("M j, Y g:ia", strtotime($value['DateFiled'])); ?></td>
                    <td class="btnpenddata cursorpoint tinytext" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>" attribute5="<?php echo $value['DBNAME']; ?>"><?php echo $astatus; ?></td>
                    <td class="btnpenddata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>" attribute5="<?php echo $value['DBNAME']; ?>"><?php echo $date_approved; ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if ($pages) : ?>
                <tr>
                    <td colspan="7" class="centertalign"><?php echo $pages; ?></td>
                </tr>
                <?php endif; ?>
                <?php else : ?>
                <tr>
                    <td class="bold centertalign noborder"><br><br>You have no pending notification</td>
                </tr>
                <?php endif; ?>
            </table>
            <input type="hidden" id="pendpage" name="pendpage" value="<?php echo $page; ?>" />

            <?php
        break;
        case 'tablerman':

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = REQ_NUM_ROWS * ($page - 1);

            if ($_POST['clear_search']) :

                unset($_SESSION['rmantype']);
                unset($_SESSION['searchrman']);
                unset($_SESSION['rmanfrom']);
                unset($_SESSION['rmanto']);

            else :

                $rmantype_sess = $_SESSION['rmantype'];
                $searchrman_sess = $_SESSION['searchrman'];
                $rmanfrom_sess = $_SESSION['rmanfrom'];
                $rmanto_sess = $_SESSION['rmanto'];
                if ($_POST) {
                    $rmantype = $_POST['rmantype'] ? $_POST['rmantype'] : NULL;
                    $_SESSION['rmantype'] = $rmantype;
                    $searchrman = $_POST['searchrman'] ? $_POST['searchrman'] : NULL;
                    $_SESSION['searchrman'] = $searchrman;
                    $rmanfrom = $_POST['rmanfrom'] ? $_POST['rmanfrom'] : date('Y-m-d', strtotime("-6 months"));
                    $_SESSION['rmanfrom'] = $rmanfrom;
                    $rmanto = $_POST['rmanto'] ? $_POST['rmanto'] : date('Y-m-d');
                    $_SESSION['rmanto'] = $rmanto;
                }
                elseif ($searchrman_sess) {
                    $rmantype = $rmantype_sess ? $rmantype_sess : NULL;
                    $_POST['rmantype'] = $rmantype != 0 ? $rmantype : NULL;
                    $searchrman = $searchrman_sess ? $searchrman_sess : NULL;
                    $_POST['searchrman'] = $searchrman != 0 ? $searchrman : NULL;
                    $rmanfrom = $rmanfrom_sess ? $rmanfrom_sess : date('Y-m-d', strtotime("-6 months"));
                    $_POST['rmanfrom'] = $rmanfrom != 0 ? $rmanfrom : date('Y-m-d', strtotime("-6 months"));
                    $rmanto = $rmanto_sess ? $rmanto_sess : date('Y-m-d');
                    $_POST['rmanto'] = $rmanto != 0 ? $rmanto : date('Y-m-d');
                }
                else {
                    $rmantype = NULL;
                    $_POST['rmantype'] = NULL;
                    $searchrman = NULL;
                    $_POST['searchrman'] = NULL;
                    $rmanfrom = date('Y-m-d', strtotime("-6 months"));
                    $_POST['rmanfrom'] = date('Y-m-d', strtotime("-6 months"));
                    $rmanto = date('Y-m-d');
                    $_POST['rmanto'] = date('Y-m-d');
                }

            endif;

            //var_dump($searchrman);

            if (strlen($searchrman) >= 5) :
                $notification_data = $mainsql->get_notification(NULL, $start, REQ_NUM_ROWS, $searchrman, 0, NULL, $rmanfrom, $rmanto, $rmantype);
                $notification_count = $mainsql->get_notification_count(NULL, 0, 0, $searchrman, NULL, $rmanfrom, $rmanto, $rmantype);
                //var_dump($notification_count);
                $pages = $mainsql->pagination("reqman", $notification_count[0]['EmpCount'], REQ_NUM_ROWS, 9);
            else :
                $notification_data = NULL;
                $notification_count = NULL;
                $pages = NULL;
            endif;

            //var_dump($notification_count[0]['EmpCount']);
            ?>

            <table border="0" cellspacing="0" class="tdata width100per">
            <?php if ($notification_data) : ?>
            <tr>
                <th width="7%" rowspan="2">Type</th>
                <th width="19%" rowspan="2">Reference #</th>
                <th width="19%" rowspan="2">Request by</th>
                <th width="5%" rowspan="2">Level</th>
                <th width="24%" colspan="2">Date</th>
                <th width="26%" rowspan="2">Status</th>
            </tr>
            <tr>
                <th width="12%">Filed</th>
                <th width="12%">Approved</th>
            </tr>
            <?php foreach ($notification_data as $key => $value) :

                if ($value['DocType'] == 'LV') : $typestat = "LEAVE APPLICATION from ";
                elseif ($value['DocType'] == 'OT') : $typestat = "OVERTIME APPLICATION from ";
                elseif ($value['DocType'] == 'OB') : $typestat = "OBT APPLICATION from ";
                elseif ($value['DocType'] == 'NP') : $typestat = "NO PUNCH APPLICATION from ";
                elseif ($value['DocType'] == 'MD') : $typestat = "MANUAL DTR APPLICATION from ";
								elseif ($value['DocType'] == 'SC') : $typestat = "CHANGE SCHEDULE APPLICATION from ";
                elseif ($value['DocType'] == 'WH') : $typestat = "WORK FROM HOME from ";
                endif;

                $displaychk = 0;

                if (trim($value['Signatory01'])) :

                    if ($value['Signatory01'] == $profile_idnum) :

                        $requestor_data = $logsql->get_allmember($value['EmpID']);
                        if ($value['Approved'] == 1) :
                            if ($value['ApprovedDate01']) :
                                $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate01']));
                                if (!trim($value['Signatory02']) || trim($value['Signatory02']) == '') :
                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                    $nlevel = 1;
                                else:
                                    $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
                                    $nlevel = 2;
                                endif;
                            else :
                                $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED";
                                $nlevel = 1;
                            endif;
                        elseif ($value['Approved'] == 2) :
                            $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED";
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
                        $approver_data = $logsql->get_allmember($value['Signatory01'], $value['DB_NAME01']);
                        if ($value['Approved'] == 1) :
                            if ($value['ApprovedDate01']) :
                                $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate01']));
                                if (!trim($value['Signatory02']) || trim($value['Signatory02']) == '') :
                                    $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
                                    $nlevel = 1;
                                else:
                                    $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
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
                            $astatus = "CANCELLED";
                            $nlevel = 1;
                        else :
                            $nlevel = 1;
                            $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                        endif;
                    endif;
                endif;

                if (trim($value['Signatory06']) && $value['ApprovedDate05']) :

                    if ($value['Signatory06'] == $profile_idnum) :

                        $requestor_data = $logsql->get_allmember($value['EmpID']);
                        if ($value['Approved'] == 1) :
                            if ($value['ApprovedDate06']) :
                                $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate06']));
                                $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                $nlevel = 6;
                            else :
                                $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED";
                                $nlevel = 6;
                            endif;
                        elseif ($value['Approved'] == 2) :
                            $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED";
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

                        $approver_data = $logsql->get_allmember($value['Signatory06'], $value['DB_NAME06']);
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
                            $astatus = "CANCELLED";
                            $nlevel = 6;
                        else :
                            $nlevel = 6;
                            $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                        endif;

                    endif;

                elseif (trim($value['Signatory05']) && $value['ApprovedDate04']) :

                    if ($value['Signatory05'] == $profile_idnum) :

                        $requestor_data = $logsql->get_allmember($value['EmpID']);
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
                                $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED";
                                $nlevel = 5;
                            endif;
                        elseif ($value['Approved'] == 2) :
                            $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED";
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

                        $approver_data = $logsql->get_allmember($value['Signatory05'], $value['DB_NAME05']);
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
                            $astatus = "CANCELLED";
                            $nlevel = 5;
                        else :
                            $nlevel = 5;
                            $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                        endif;
                    endif;

                elseif (trim($value['Signatory04']) && $value['ApprovedDate03']) :

                    if ($value['Signatory04'] == $profile_idnum) :

                        $requestor_data = $logsql->get_allmember($value['EmpID']);
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
                                $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED";
                                $nlevel = 4;
                            endif;
                        elseif ($value['Approved'] == 2) :
                            $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED";
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
                        $approver_data = $logsql->get_allmember($value['Signatory04'], $value['DB_NAME04']);
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
                            $astatus = "CANCELLED";
                            $nlevel = 4;
                        else :
                            $nlevel = 4;
                            $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                        endif;
                    endif;

                elseif (trim($value['Signatory03']) && $value['ApprovedDate02']) :

                    if ($value['Signatory03'] == $profile_idnum) :

                        $requestor_data = $logsql->get_allmember($value['EmpID']);
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
                                $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED";
                                $nlevel = 3;
                            endif;
                        elseif ($value['Approved'] == 2) :
                            $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED";
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
                        $approver_data = $logsql->get_allmember($value['Signatory03'], $value['DB_NAME03']);
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
                            $astatus = "CANCELLED";
                            $nlevel = 3;
                        else :
                            $nlevel = 3;
                            $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                        endif;
                    endif;

                elseif (trim($value['Signatory02']) && $value['ApprovedDate01']) :

                    if ($value['Signatory02'] == $profile_idnum) :
                        $requestor_data = $logsql->get_allmember($value['EmpID']);
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
                                $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED";
                                $nlevel = 2;
                            endif;
                        elseif ($value['Approved'] == 2) :
                            $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED";
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
                        $approver_data = $logsql->get_allmember($value['Signatory02'], $value['DB_NAME02']);
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
                                $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                $nlevel = 2;
                            endif;
                        elseif ($value['Approved'] == 2) :
                            $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                            $nlevel = 2;
                        elseif ($value['Approved'] == 3) :
                            $astatus = "CANCELLED";
                            $nlevel = 2;
                        else :
                            $nlevel = 2;
                            $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                        endif;

                    endif;

                endif;

            ?>
            <tr class="btnrnotidata cursorpoint trdata centertalign whitetext" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>">
                <td><?php echo $value['DocType']; ?></td>
                <td><?php echo $value['Reference']; ?></td>
                <td><?php echo $value['EmpID']; ?></td>
                <td><?php echo $nlevel; ?></td>
                <td><?php echo date("M j, Y", strtotime($value['DateFiled'])); ?></td>
                <?php $oldyear = date("Y", strtotime($value['APPROVALDATE'])); ?>
                <td><?php echo $oldyear >= "2013" ? date("M j, Y", strtotime($value['APPROVALDATE'])) : ''; ?></td>
                <td class="tinytext"><?php echo $astatus; ?></td>
            </tr>
            <?php endforeach; ?>
            <?php if ($pages) : ?>
            <tr>
                <td colspan="7" class="centertalign"><?php echo $pages; ?></td>
            </tr>
            <?php endif; ?>
            <?php else : ?>
                <?php if (strlen($searchrman) < 5) : ?>
                <tr>
                    <td class="bold centertalign noborder"><br><br>Search must be minimum of 5 characters <i>* <?php echo $profile_nadd; ?> ID must full (2015-01-XXXX)</i></td>
                </tr>
                <?php else : ?>
                <tr>
                    <td class="bold centertalign noborder"><br><br>No request has been found <i>* <?php echo $profile_nadd; ?> ID must full (2015-01-XXXX)</td>
                </tr>
                <?php endif; ?>
            <?php endif; ?>
        </table>
        <input type="hidden" id="notipage" name="notipage" value="<?php echo $page; ?>" />
        <input type="hidden" id="rmandb" name="rmandb" value="<?php echo $profile_dbname; ?>" />

            <?php
        break;
        case 'approve':

            $doctype = $_POST['doctype'];
            $apppost['REQNBR'] = $_POST['reqnbr'];
            $apppost['TRANS'] = $_POST['trans'];
            $apppost['USER'] = $_POST['user'];
            $apppost['EMPID'] = $_POST['empid'];
            $apppost['REMARKS'] = $_POST['remarks'];
            $apppost['DBNAME'] = $_POST['dbname'];

						if ($doctype == 'WH'):
							 $apppost['data'] = $_POST['data'];
							 $reqtype = 10;
							 $reqdesc = "WFH";
							 $app_request = $mainsql->wh_action($apppost, 'approve');
            elseif ($doctype == 'OT') :
                $reqtype = 1;
                $reqdesc = "Overtime";
                $apppost['OTTYPE'] = NULL;
                $apppost['APPROVEDHRS'] = $_POST['approvehours'];
                $app_request = $mainsql->ot_action($apppost, 'approve');
            elseif ($doctype == 'LV') :
                $reqtype = 2;
                $reqdesc = "Leave";
                $app_request = $mainsql->leave_action($apppost, 'approve');
            elseif ($doctype == 'OB') :
                $reqtype = 4;
                $reqdesc = "Official Business Trip";
                $app_request = $mainsql->ob_action($apppost, 'approve');
            elseif ($doctype == 'NP') :
                $reqtype = 6;
                $reqdesc = "Non-Punching Authorization";
                $app_request = $mainsql->np_action($apppost, 'approve');
            elseif ($doctype == 'MD') :
                $reqtype = 7;
                $reqdesc = "Manual DTR";
                $app_request = $mainsql->md_action($apppost, 'approve');
            elseif ($doctype == 'SC') :
                $reqtype = 8;
                $reqdesc = "Change Schedule";
                $app_request = $mainsql->sc_action($apppost, 'approve');
            elseif ($doctype == 'TS') :
                $reqtype = 8;
                $reqdesc = "Schedule Change";
                $app_request = $mainsql->ts_action($apppost, 'approve');
            elseif ($doctype == 'LU') :
                $reqtype = 9;
                $reqdesc = "Offset";
                $app_request = $mainsql->lu_action($apppost, 'approve');
            endif;

            //sleep(2);

            if ($_POST['trans'] == 'CANCEL') :
                $delete_read = $mainsql->delete_read(NULL, $refnum);
            endif;

            // $requestor = $logsql->get_allmember($_POST['empid']);
            // Modified by kevs; May 29, 2019; Fix issues on email notification to different employee from different company
            $requestor = $logsql->get_allmember($_POST['empid'], $_POST['dbname']);
            $request_info = $tblsql->get_mrequest($reqtype, 0, 0, 0, $_POST['reqnbr'], 0, NULL, NULL, NULL, NULL);
            $approver = $logsql->get_allmember($_POST['user'], $_POST['userdb']);
            if ($_POST['nxtapp']) : $nxtapprover = $logsql->get_allmember($_POST['nxtapp'], $_POST['nxtappdb']); endif;

            $reqemailblock = $mainsql->get_appemailblock($_POST['empid'], $_POST['dbname']);
            $appemailblock = $mainsql->get_appemailblock($_POST['user']);
            if ($_POST['nxtapp']) : $nappemailblock = $mainsql->get_newemailblock($_POST['nxtapp'], $_POST['nxtappdb']); endif;

            if ($_POST['user']) :
                $bywhom = $approver[0]['FName']." ".$approver[0]['LName'];
            else :
                $bywhom = "YOU";
            endif;

            if ((int)$app_request == 1) :

                if ($reqemailblock) :

                    //SEND EMAIL (REQUESTOR)

                    $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>".$reqdesc." Request ".ucfirst($_POST['trans'] == 'CANCEL' ? 'CANCELLED' : $_POST['trans'])."</span><br><br>Hi ".$requestor[0]['FName'].",<br><br>";
                    $message .= "Your request for ".($reqtype == 7 ? "manual DTR" : strtolower($reqdesc))." with Reference No: ".$_POST['reqnbr']." was ".strtoupper($_POST['trans'] == 'CANCEL' ? 'CANCELLED' : $_POST['trans'])." by ".$bywhom." on ".date('F j, Y')."." ;
                    $message .= "<br><br>Thanks,<br>";
                    $message .= SITENAME." Admin";
                    $message .= "<hr />".MAILFOOT."</div>";

                    $headers = "From: ".NOTIFICATION_EMAIL."\r\n";
                    $headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                    $sendmail = mail($requestor[0]['EmailAdd'], "Response to your ".$reqdesc." Request", $message, $headers);

                endif;

                if ($appemailblock) :

                    //SEND EMAIL (APPROVER)

                    $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>".$reqdesc." Request ".ucfirst($_POST['trans'] == 'CANCEL' ? 'CANCELLED' : $_POST['trans'])."</span><br><br>Hi ".$approver[0]['FName'].",<br><br>";
                    $message .= "Request for ".($reqtype == 7 ? "manual DTR" : strtolower($reqdesc))." with Reference No: ".$_POST['reqnbr']." was ".strtoupper($_POST['trans'] == 'CANCEL' ? 'CANCELLED' : $_POST['trans'])." by YOU on ".date('F j, Y').".";
                    $message .= "<br><br>Thanks,<br>";
                    $message .= SITENAME." Admin";
                    $message .= "<hr />".MAILFOOT."</div>";

                    $headers = "From: ".NOTIFICATION_EMAIL."\r\n";
                    $headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                    $sendmail = mail($approver[0]['EmailAdd'], "Your Response to ".$reqdesc." Request", $message, $headers);

                endif;

                if ($nappemailblock) :
                    //SEND EMAIL (NEXT APPROVER)

                    $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New $reqdesc Request from ".$requestor[0]['FName']." ".$requestor[0]['LName']."</span><br><br>Hi ".$nxtapprover[0]['FName'].",<br><br>";
                    $message .= "New request ".$requestor[0]['FName']." ".$requestor[0]['LName']." for ".strtolower($reqdesc)." with Reference No: ".$_POST['reqnbr']." for your approval. ";
                    $message .= "<br><br>Thanks,<br>";
                    $message .= SITENAME." Admin";
                    $message .= "<hr />".MAILFOOT."</div>";

                    $headers = "From: ".NOTIFICATION_EMAIL."\r\n";
                    $headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                    $sendmail = mail($nxtapprover[0]['EmailAdd'], "New $reqdesc for your Approval", $message, $headers);
                endif;
            endif;

            //READ STATUS
            if ($_POST['empid'] && $_POST['reqnbr']) :
                $insert_reqread = $mainsql->insert_read($_POST['empid'], $_POST['reqnbr']); //requestor
            endif;
            if ($_POST['nxtapp'] && $_POST['reqnbr']) :
                $insert_appread = $mainsql->insert_read($_POST['nxtapp'], $_POST['reqnbr']); //next approver
            endif;

            //var_dump($app_request);
            echo $app_request ? 1 : 0;

        break;
        case 'data':

            $doctype = $_POST['doctype'];
            $refnum = $_POST['refnum'];

            $notification_data = $mainsql->get_notification($refnum);
            $attachment_data = $mainsql->get_attachments($refnum, 0, $notification_data[0]['DBNAME']);

            $approver_data1 = $logsql->get_allmember($notification_data[0]['Signatory01'],$notification_data[0]['DB_NAME01']);
            $approver_data2 = $logsql->get_allmember($notification_data[0]['Signatory02'],$notification_data[0]['DB_NAME02']);
            $approver_data3 = $logsql->get_allmember($notification_data[0]['Signatory03'],$notification_data[0]['DB_NAME03']);
            $approver_data4 = $logsql->get_allmember($notification_data[0]['Signatory04'],$notification_data[0]['DB_NAME04']);
            $approver_data5 = $logsql->get_allmember($notification_data[0]['Signatory05'],$notification_data[0]['DB_NAME05']);
            $approver_data6 = $logsql->get_allmember($notification_data[0]['Signatory06'],$notification_data[0]['DB_NAME06']);

            $requestor_data = $logsql->get_allmember($notification_data[0]['EmpID']);

            $chkexpire = 0;

            //READ STATUS
            $get_read = $mainsql->get_read($profile_idnum, $refnum, 1);
            if ($get_read) :
                $delete_read = $mainsql->delete_read($profile_idnum, $refnum);
            endif;
            ?>

            <table class="tdataform2 rightmargin margintop10 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">

            <?php
            //var_dump($notification_data);
            //if ($notification_data[0]['EmpID'] != $profile_idnum) :
                ?>

                    <tr>
                        <td width="25%"><b>Requested by</b></td>
                        <td width="75%"><?php echo $requestor_data[0]['FName'].' '.$requestor_data[0]['LName'].' ('.$notification_data[0]['EmpID'].')'; ?>
                        <input type="hidden" id="dbname" name="dbname" value="<?php echo $notification_data[0]['DBNAME'] ?>" attribute="<?php echo $attachment_data; ?>" />
                        </td>
                    </tr>

                <?php
            //endif;

            if ($doctype == 'OT') :
                $application_data = $tblsql->get_nrequest(1, $refnum);

                $chkexpire = $mainsql->check_appexpire($application_data[0]['DtrDate']);

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.WEB.'/uploads/ot/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <?php if ($notification_data[0]['EmpID'] == $profile_idnum && $notification_data[0]['Approved'] != 3 && $notification_data[0]['Approved'] != 2) : ?>
                    <!--tr>
                        <td width="25%">&nbsp;</td>
                        <td width="75%"><a href="<?php echo WEB; ?>/otpdf?id=<?php echo $refnum; ?>" target="_blank"><button class="btn">Print OT Form</button></a></td>
                    </tr-->
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['ReqDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>DTR Date</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['DtrDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>From</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['FromDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>To</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['ToDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>OT Type</b></td>
                        <td><?php echo $application_data[0]['OTType']; ?></td>
                    </tr>
                    <tr>
                        <td><b>Applied Hours</b></td>
                        <td><?php echo $application_data[0]['Hrs']; ?></td>
                    </tr>
                    <?php if ($notification_data[0]['Approved'] == 1) : ?>
                    <tr>
                        <td><b>Approved Hours</b></td>
                        <td>
                            <?php echo $application_data[0]['ApprovedHrs'] ? $application_data[0]['ApprovedHrs'] : 0; ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td><b>Reason</b></td>
                        <td><?php echo stripslashes($application_data[0]['Reason']); ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['DtrDate']);
                $pdtrto = strtotime($application_data[0]['DtrDate']);

            elseif ($doctype == 'LV') :
                $application_data = $tblsql->get_nrequest(2, $refnum);
                //$appleave_data = $tblsql->get_leavedata($refnum);

                $chkexpire = $mainsql->check_appexpire($application_data[0]['AbsenceFromDate'], $application_data[0]['AbsenceToDate']);

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.WEB.'/uploads/leave/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($notification_data[0]['DateFiled'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Coverage</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['AbsenceFromDate'])); ?> - <?php echo date('F j, Y', strtotime($application_data[0]['AbsenceToDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Type</b></td>
                        <td><?php echo $application_data[0]['LeaveDesc']; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="divlvdata width100per notidatadiv">
                            <table class="tdatablk width100per">
                                <tr>
                                    <th>Date</th>
                                    <th>Duration</th>
                                    <th>w/ Pay</th>
                                    <th>Cancel</th>
                                </tr>
                                <?php
                                    $applv_data = $tblsql->get_leavedata($refnum);
                                    $applv_count = count($applv_data);
                                    foreach($applv_data as $key => $value) :
                                ?>
                                <tr>
                                    <td><?php echo date("M j", strtotime($value['LeaveDate'])); ?></td>
                                    <td><?php

                                        if ($value['Duration'] >= 8) :
                                            echo number_format($value['Duration'], 1)." hours";
                                        else :
                                            echo number_format($value['Duration'], 1)." hours";
                                        endif;

                                        /*if ($value['Duration'] == "WD") :
                                            echo "Whole Day";
                                        elseif ($value['Duration'] == "HD") :
                                            echo "Half Day";
                                        elseif ($value['Duration'] == "HD1") :
                                            echo "Half Day AM";
                                        elseif ($value['Duration'] == "HD2") :
                                            echo "Half Day PM";
                                        endif;*/
                                    ?></td>
                                    <td class="centertalign">
                                        <?php echo $value['WithPay'] ? "<i class='fa fa-check'></i>" : "<i class='fa fa-times'></i>"; ?>
                                    </td>
                                    <td class="centertalign"><?php if ($applv_count > 1) : ?><i class="btnlvcancel fa fa-times redtext cursorpoint" attribute="<?php echo $refnum; ?>" attribute2="<?php echo date('Y-m-d 00:00:00.000', strtotime($value['LeaveDate'])); ?>"></i><?php endif; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Reason</b></td>
                        <td><?php echo stripslashes($application_data[0]['Reason']); ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['AbsenceFromDate']);
                $pdtrto = strtotime($application_data[0]['AbsenceToDate']);

            elseif ($doctype == 'MA') :
                $application_data = $tblsql->get_nrequest(3, $refnum);

                $chkexpire = $mainsql->check_appexpire($application_data[0]['DateFrom'], $application_data[0]['DateTo']);

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.WEB.'/uploads/ma/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['ReqDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>From</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['DateFrom'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>To</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['DateTo'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Type</b></td>
                        <td><?php echo $application_data[0]['TypeAvail']; ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['DateFrom']);
                $pdtrto = strtotime($application_data[0]['DateTo']);

            elseif ($doctype == 'OB') :
                $application_data = $tblsql->get_nrequest(4, $refnum);
                $appobt_data = $tblsql->get_obtdata($refnum);

                $chkexpire = $mainsql->check_appexpire($application_data[0]['OBTimeINDate'], $application_data[0]['OBTimeOutDate']);

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.WEB.'/uploads/ob/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <?php if ($notification_data[0]['EmpID'] == $profile_idnum && $notification_data[0]['Approved'] != 3 && $notification_data[0]['Approved'] != 2) : ?>
                    <tr>
                        <td width="25%">&nbsp;</td>
                        <td width="75%"><a href="<?php echo WEB; ?>/obtpdf?id=<?php echo $refnum; ?>" target="_blank"><button class="btn">Print OBT Form</button></a></td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['DateFiled'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>From</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['OBTimeINDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>To</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['OBTimeOutDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Destination</b></td>
                        <td><?php echo $application_data[0]['Destination']; ?></td>
                    </tr>
                    <tr>
                        <td><b>Purpose</b></td>
                        <td><?php echo stripslashes($application_data[0]['Reason']); ?></td>
                    </tr>
                    <tr>
                        <td><b>OBT Time Entry</b></td>
                        <td>
                            <div class="width100per notidatadiv">
                            <table class="tdatablk">
                                <tr>
                                    <th>In</th>
                                    <th>Out</th>
                                </tr>
                                <?php foreach($appobt_data as $key => $value) : ?>
                                <tr>
                                    <td><?php echo date("M j, Y g:ia", strtotime($value['ObTimeInDate'])); ?></td>
                                    <td><?php echo date("M j, Y g:ia", strtotime($value['ObTimeOutDate'])); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Biometric Time Entry</b></td>
                        <td>
                            <div class="width100per notidatadiv">
                            <table class="tdatablk">
                                <tr>
                                    <th>In</th>
                                    <th>Out</th>
                                </tr>
                                <?php foreach($appobt_data as $key => $value) : ?>
                                <tr>
                                    <td><?php if(!empty($value['ActualTimeInDate'])) echo date("M j, Y g:ia", strtotime($value['ActualTimeInDate'])); else echo 'No Biometric Entry'; ?></td>
                                    <td><?php if(!empty($value['ActualTimeOutDate'])) echo date("M j, Y g:ia", strtotime($value['ActualTimeOutDate'])); else echo 'No Biometric Entry'; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Days</b></td>
                        <td><?php echo $application_data[0]['Days']; ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['OBTimeINDate']);
                $pdtrto = strtotime($application_data[0]['OBTimeINDate']);

            elseif ($doctype == 'NP') :
                $application_data = $tblsql->get_nrequest(6, $refnum);

                $chkexpire = $mainsql->check_appexpire($application_data[0]['DateCovered']);

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.WEB.'/uploads/np/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($notification_data[0]['DateFiled'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Date Coverage</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['DateCovered'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Time IN</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['DateTimeIN'])); ?><br><?php echo date('g:ia', strtotime($application_data[0]['TimeIn'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Time OUT</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['DateTimeOUT'])); ?><br><?php echo date('g:ia', strtotime($application_data[0]['TimeOut'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Reason</b></td>
                        <td><?php echo stripslashes($application_data[0]['Reason']); ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['DateCovered']);
                $pdtrto = strtotime($application_data[0]['DateCovered']);

            elseif ($doctype == 'MD') :
                $application_data = $tblsql->get_mrequest(7, $refnum);

                $chkexpiremd = 0;

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.WEB.'/uploads/md/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y g:ia', strtotime($application_data[0]['ReqDate'])); ?></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                        <div class="divmddata width100per notidatadiv">
                            <table class="tdatablk">
                                <tr>
                                    <th width="100px">DTR Date</th>
                                    <th width="80px">Day</th>
                                    <th width="100px">Time IN</th>
                                    <th width="100px">Time OUT</th>
                                    <th width="200px">Shift Desc</th>
                                    <th width="200px">New Shift Desc</th>
                                    <th width="100px">Cancel</th>
                                </tr>
                                <?php
                                    $appmd_data = $tblsql->get_mdtrdata($refnum);
                                    $appmd_count = count($appmd_data);

                                    foreach ($appmd_data as $key => $value) :
                                        $shifts2 = $mainsql->get_shift($value['NewShiftDesc']);
                                        $chkmditem = $mainsql->check_appexpire($value['DTRDate']);
                                        if ($chkmditem) : $chkexpiremd++; endif;
                                        ?>
                                        <tr>
                                            <?php $timearray = preg_split('/\s+/', trim($value['TimeIn'])); $timearray2 = preg_split('/\s+/', trim($value['TimeOUt'])); ?>
                                            <td><?php echo date('F j, Y', strtotime($value['DTRDate'])); ?></td>
                                            <td><?php echo $value['Day']; ?></td>
                                            <td><?php echo $timearray[3] ? date('g:ia', strtotime($timearray[3])) : ''; ?></td>
                                            <td><?php echo $timearray[3] ? date('g:ia', strtotime($timearray2[3])) : ''; ?></td>
                                            <td><?php echo $value['ShiftDesc']; ?></td>
                                            <td><?php echo $value['NewShiftDesc'] ? $shifts2[0]['ShiftDesc'] : 'REST DAY'; ?></td>
                                            <td class="centertalign"><?php if ($appmd_count > 1) : ?><i class="btnmdcancel fa fa-times redtext cursorpoint" attribute="<?php echo $refnum; ?>" attribute2="<?php echo date('Y-m-d 00:00:00.000', strtotime($value['DTRDate'])); ?>"></i><?php endif; ?></td>
                                        </tr>
                                        <?php
                                        $pdtrto = strtotime($value['DTRDate']);
                                    endforeach;

                                    $chkexpire = $chkexpiremd ? 1 : 0;
                                ?>
                            </table>
                        </div>
                        </td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['DateStart']);

            elseif ($doctype == 'SC') :
                $application_data = $tblsql->get_mrequest(8, $refnum);
                //var_dump($application_data);

                $chkexpiresc = 0;

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.WEB.'/uploads/sc/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($notification_data[0]['DateFiled'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Remarks</b></td>
                        <td><?php echo $application_data[0]['REMARKS']; ?></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                        <div class="divtsdata width100per notidatadiv">
                            <table class="tdatablk">
                                <tr>
                                    <th width="100px">DTR Date</th>
                                    <th width="200px">Current Shift Desc</th>
                                    <th width="200px">New Shift Desc</th>
                                    <th width="150px">Shift Time IN</th>
                                    <th width="150px">Shift Time OUT</th>
                                    <th width="80px">Cancel</th>
                                </tr>
                                <?php
                                    //$ts_data = $tblsql->get_nrequest(8, $refnum);
                                    $appts_data = $tblsql->get_tsdata($refnum);
                                    $appts_count = count($appts_data);
                                    foreach ($appts_data as $key => $value) :
                                        $oldshiftdesc = $mainsql->get_shift($value['ShiftID']);
                                        $oldshift = $oldshiftdesc[0]['ShiftDesc'] ? $oldshiftdesc[0]['ShiftDesc'] : $value['ShiftID'];
                                        $chkscitem = $mainsql->check_appexpire($value['DTRDate']);
                                        if ($chkscitem) : $chkexpiresc++; endif;
                                        ?>
                                        <tr>
                                            <td><?php echo date('M j, Y', strtotime($value['DTRDate'])); ?></td>
                                            <td><?php echo $value['ShiftID'] ? $oldshift : 'REST DAY'; ?></td>
                                            <td><?php echo $value['NewShiftDesc'] ? $value['NewShiftDesc'] : 'REST DAY'; ?></td>
                                            <td><?php echo $value['TimeIn'] ? date('g:ia', strtotime($value['TimeIn'])) : 'N/A'; ?></td>
                                            <td><?php echo $value['TimeOut'] ? date('g:ia', strtotime($value['TimeOut'])) : 'N/A'; ?></td>
                                            <td class="centertalign"><?php if ($appts_count > 1) : ?><i class="btnsccancel fa fa-times redtext cursorpoint" attribute="<?php echo $refnum; ?>" attribute2="<?php echo date('Y-m-d 00:00:00.000', strtotime($value['DTRDate'])); ?>"></i><?php endif; ?></td>
                                        </tr>
                                        <?php
                                        $pdtrto = strtotime($value['DTRDate']);
                                    endforeach;

                                    $chkexpire = $chkexpiresc ? 1 : 0;
                                ?>
                            </table>
                        </div>
                        </td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['DateStart']);
            elseif ($doctype == 'TS') :
                $application_data = $tblsql->get_mrequest(5, $refnum);
                //var_dump($application_data);

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.WEB.'/uploads/sc/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($notification_data[0]['DateFiled'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>DTR Date</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['DateCovered'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Current Shift Desc</b></td>
                        <td><?php echo $application_data[0]['ChangeSchedFrom']; ?></td>
                    </tr>
                    <tr>
                        <td><b>New Shift Desc</b></td>
                        <td><?php echo $application_data[0]['ChangeSchedTo']; ?></td>
                    </tr>
                    <tr>
                        <td><b>Reason</b></td>
                        <td><?php echo stripslashes($application_data[0]['Reason']); ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['DateStart']);

            elseif ($doctype == 'LU') :
                $application_data = $tblsql->get_nrequest(9, $refnum);

                $chkexpire = $mainsql->check_appexpire($application_data[0]['DtrDate']);

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.WEB.'/uploads/ot/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <?php if ($notification_data[0]['EmpID'] == $profile_idnum && $notification_data[0]['Approved'] != 3 && $notification_data[0]['Approved'] != 2) : ?>
                    <!--tr>
                        <td width="25%">&nbsp;</td>
                        <td width="75%"><a href="<?php echo WEB; ?>/otpdf?id=<?php echo $refnum; ?>" target="_blank"><button class="btn">Print OT Form</button></a></td>
                    </tr-->
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b><input type="hidden" id="dbname" name="dbname" value="<?php echo $notification_data[0]['DBNAME'] ?>" /></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['ReqDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>DTR Date</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['DtrDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Type</b></td>
                        <td><?php echo $application_data[0]['LUType']; ?></td>
                    </tr>
                    <tr>
                        <td><b>Applied Hours</b></td>
                        <td><?php echo $application_data[0]['LUHrs']; ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['DtrDate']);
                $pdtrto = strtotime($application_data[0]['DtrDate']);

            endif;

            ?>

                    <?php
                        $ifposted = $mainsql->get_posted($pdtrfrom, $pdtrto, $profile_comp);
                        $thisisposted = $ifposted[0]['AttPost'] ? 1 : 0;
                    ?>

                    <tr>
                        <td colspan="2">
                            <div class="hrborder">&nbsp;</div>
                        </td>
                    </tr>

                    <?php
                    if ($notification_data[0]['Approved'] == 3) :
                        ?>
                        <tr>
                            <td><b>Status</b></td>
                            <td>CANCELLED BY YOU</td>
                        </tr>
                        <tr>
                            <td><b>Date</b></td>
                            <td><?php echo date('F j, Y | g:ia', strtotime($notification_data[0]['RejectedDate'])); ?></td>
                        </tr>
                        <?php
                    else :
                        ?>

                        <?php if ($notification_data[0]['Approved'] != 3) : ?>
                        <?php if (trim($notification_data[0]['Signatory01'])) : ?>
                        <tr>
                            <td><b>Signatory 1</b></td>
                            <td><?php echo $approver_data1[0]['FName'].' '.$approver_data1[0]['LName']; ?></td>
                        </tr>
                        <tr>
                            <?php //var_dump($notification_data[0]['Signatory01']); ?>
                            <?php if ($notification_data[0]['Signatory01'] == $profile_idnum) : ?>
                            <td><b><?php echo $notification_data[0]['ApprovedDate01'] ? 'Status' : '&nbsp;'; ?></b></td>
                            <td>
                                <?php if (!$notification_data[0]['ApprovedDate01'] && $notification_data[0]['Approved'] != 2) : ?>
                                    <?php if ($doctype == 'OT') : ?>
                                        <script type="text/javascript">// slider
                                            $(".approvehours").spinner({
                                              step: 0.5,
                                              spin: function( event, ui ) {
                                                if ( ui.value > <?php echo $application_data[0]['Hrs']; ?> ) {
                                                  $(this).spinner( "value", <?php echo $application_data[0]['Hrs']; ?> );
                                                  return false;
                                                } else if ( ui.value < 0 ) {
                                                  $(this).spinner( "value", 0 );
                                                  return false;
                                                }
                                              }
                                            });
                                        </script>
                                        <b>Approve Hour/s</b> <input type="text" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs'] < $application_data[0]['Hrs'] ? $application_data[0]['ApprovedHrs'] :  $application_data[0]['Hrs']; ?>" class="approvehours txtbox width50 righttalign" readonly />
                                    <?php endif; ?>
                                    <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10" />
                                    <?php if (!$chkexpire) : ?>
                                    <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory01']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME01'] ? $notification_data[0]['DB_NAME01'] : 0; ?>"<?php if ($notification_data[0]['Signatory02']) : ?> attribute21="<?php echo $notification_data[0]['Signatory02'] ? $notification_data[0]['Signatory02'] : 0; ?>" attribute22="<?php echo $notification_data[0]['DB_NAME02'] ? $notification_data[0]['DB_NAME02'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
                                    <?php endif; ?>
                                    <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory01']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME01'] ? $notification_data[0]['DB_NAME01'] : 0; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" />
                                <?php else : ?>
                                    <?php if ($notification_data[0]['ApprovedDate01'] != NULL) : ?>
                                        <?php if ($notification_data[0]['Approved'] != 2) : ?>
                                            APPROVED BY YOU
                                        <?php else : ?>
                                            REJECTED BY YOU
                                        <?php endif; ?>
                                    <?php else : ?>
                                        TO BE APPROVED BY YOU
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <?php else : ?>
                            <td><b>Status</b></td>
                            <td><?php
                                if ($notification_data[0]['ApprovedDate01']) :
                                    echo 'APPROVED';
                                else :
                                    if ($notification_data[0]['Approved'] == 2) :
                                        echo 'REJECTED';
                                    else :
                                        echo 'TO BE APPROVED';
                                    endif;
                                endif; ?><span id="remarks" name="remarks">&nbsp;</span></td>
                            <?php endif; ?>
                        </tr>
                        <?php if ($notification_data[0]['ApprovedDate01']) : ?>
                        <tr>
                            <td><b>Date</b></td>
                            <td><?php echo date("F j, Y | g:ia", strtotime($notification_data[0]['ApprovedDate01'])); ?></td>
                        </tr>
                            <?php if (trim($notification_data[0]['Remarks01'])) : ?>
                            <tr>
                                <td><b>Remarks</b></td>
                                <td><?php echo $mainsql->truncate($notification_data[0]['Remarks01'], 50); ?></td>
                            </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php if (trim($notification_data[0]['Signatory02'])) : ?>
                        <tr>
                            <td><b>Signatory 2</b></td>
                            <td><?php echo $approver_data2[0]['FName'].' '.$approver_data2[0]['LName']; ?></td>
                        </tr>
                        <tr>
                            <?php if ($notification_data[0]['Signatory02'] == $profile_idnum) : ?>
                            <td><b><?php echo $notification_data[0]['ApprovedDate02'] ? 'Status' : '&nbsp;'; ?></b></td>
                            <td>
                                <?php if (!$notification_data[0]['ApprovedDate02'] && $notification_data[0]['ApprovedDate01'] && $notification_data[0]['Approved'] != 2) : ?>
                                    <?php if ($doctype == 'OT') : ?>
                                        <script type="text/javascript">// slider
                                            $(".approvehours").spinner({
                                              step: 0.5,
                                              spin: function( event, ui ) {
                                                if ( ui.value > <?php echo $application_data[0]['Hrs']; ?> ) {
                                                  $(this).spinner( "value", <?php echo $application_data[0]['Hrs']; ?> );
                                                  return false;
                                                } else if ( ui.value < 0 ) {
                                                  $(this).spinner( "value", 0 );
                                                  return false;
                                                }
                                              }
                                            });
                                        </script>
                                        <b>Approve Hour/s</b> <input type="text" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs'] < $application_data[0]['Hrs'] ? $application_data[0]['ApprovedHrs'] :  $application_data[0]['Hrs']; ?>" class="approvehours txtbox width50 righttalign" readonly />
                                        <!--input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" /-->
                                    <?php endif; ?>
                                    <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10" />
                                    <?php if (!$chkexpire) : ?>
                                    <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory02']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME02'] ? $notification_data[0]['DB_NAME02'] : 0; ?>"<?php if ($notification_data[0]['Signatory03']) : ?> attribute21="<?php echo $notification_data[0]['Signatory03'] ? $notification_data[0]['Signatory03'] : 0; ?>" attribute22="<?php echo $notification_data[0]['DB_NAME03'] ? $notification_data[0]['DB_NAME03'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
                                    <?php endif; ?>
                                    <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory02']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME02'] ? $notification_data[0]['DB_NAME02'] : 0; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" />
                                <?php else : ?>
                                    <?php if ($notification_data[0]['ApprovedDate02'] != NULL) : ?>
                                        <?php if ($notification_data[0]['Approved'] != 2) : ?>
                                            APPROVED BY YOU
                                        <?php else : ?>
                                            REJECTED BY YOU
                                        <?php endif; ?>
                                    <?php else : ?>
                                        TO BE APPROVED BY YOU
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <?php else : ?>
                            <td><b>Status</b></td>
                            <td><?php
                                if ($notification_data[0]['ApprovedDate02']) :
                                    echo 'APPROVED';
                                else :
                                    if ($notification_data[0]['Approved'] == 2) :
                                        echo 'REJECTED';
                                    else :
                                        echo 'TO BE APPROVED';
                                    endif;
                                endif; ?><span id="remarks" name="remarks">&nbsp;</span></td>
                            <?php endif; ?>
                        </tr>
                        <?php if ($notification_data[0]['ApprovedDate02']) : ?>
                        <tr>
                            <td><b>Date</b></td>
                            <td><?php echo date("F j, Y | g:ia", strtotime($notification_data[0]['ApprovedDate02'])); ?></td>
                        </tr>
                            <?php if (trim($notification_data[0]['Remarks02'])) : ?>
                            <tr>
                                <td><b>Remarks</b></td>
                                <td><?php echo $mainsql->truncate($notification_data[0]['Remarks02'], 50); ?></td>
                            </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php if (trim($notification_data[0]['Signatory03'])) : ?>
                        <tr>
                            <td><b>Signatory 3</b></td>
                            <td><?php echo $approver_data3[0]['FName'].' '.$approver_data3[0]['LName']; ?></td>
                        </tr>
                        <tr>
                            <?php if ($notification_data[0]['Signatory03'] == $profile_idnum) : ?>
                            <td><b><?php echo $notification_data[0]['ApprovedDate03'] ? 'Status' : '&nbsp;'; ?></b></td>
                            <td>
                                <?php if (!$notification_data[0]['ApprovedDate03'] && $notification_data[0]['ApprovedDate02'] && $notification_data[0]['Approved'] != 2) : ?>
                                    <?php if ($doctype == 'OT') : ?>
                                        <script type="text/javascript">// slider
                                            $(".approvehours").spinner({
                                              step: 0.5,
                                              spin: function( event, ui ) {
                                                if ( ui.value > <?php echo $application_data[0]['Hrs']; ?> ) {
                                                  $(this).spinner( "value", <?php echo $application_data[0]['Hrs']; ?> );
                                                  return false;
                                                } else if ( ui.value < 0 ) {
                                                  $(this).spinner( "value", 0 );
                                                  return false;
                                                }
                                              }
                                            });
                                        </script>
                                        <b>Approve Hour/s</b> <input type="text" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs'] < $application_data[0]['Hrs'] ? $application_data[0]['ApprovedHrs'] :  $application_data[0]['Hrs']; ?>" class="approvehours txtbox width50 righttalign" readonly />
                                        <!--input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" /-->
                                    <?php endif; ?>
                                    <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10" />
                                    <?php if (!$chkexpire) : ?>
                                    <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory03']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME03'] ? $notification_data[0]['DB_NAME03'] : 0; ?>"<?php if ($notification_data[0]['Signatory04']) : ?> attribute21="<?php echo $notification_data[0]['Signatory04'] ? $notification_data[0]['Signatory04'] : 0; ?>" attribute22="<?php echo $notification_data[0]['DB_NAME04'] ? $notification_data[0]['DB_NAME04'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
                                    <?php endif; ?>
                                    <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory03']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME03'] ? $notification_data[0]['DB_NAME03'] : 0; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" />
                                <?php else : ?>
                                    <?php if ($notification_data[0]['ApprovedDate03'] != NULL) : ?>
                                        <?php if ($notification_data[0]['Approved'] != 2) : ?>
                                            APPROVED BY YOU
                                        <?php else : ?>
                                            REJECTED BY YOU
                                        <?php endif; ?>
                                    <?php else : ?>
                                        TO BE APPROVED BY YOU
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <?php else : ?>
                            <td><b>Status</b></td>
                            <td><?php
                                if ($notification_data[0]['ApprovedDate03']) :
                                    echo 'APPROVED';
                                else :
                                    if ($notification_data[0]['Approved'] == 2) :
                                        echo 'REJECTED';
                                    else :
                                        echo 'TO BE APPROVED';
                                    endif;
                                endif; ?><span id="remarks" name="remarks">&nbsp;</span></td>
                            <?php endif; ?>
                        </tr>
                        <?php if ($notification_data[0]['ApprovedDate03']) : ?>
                        <tr>
                            <td><b>Date</b></td>
                            <td><?php echo date("F j, Y | g:ia", strtotime($notification_data[0]['ApprovedDate03'])); ?></td>
                        </tr>
                            <?php if (trim($notification_data[0]['Remarks03'])) : ?>
                            <tr>
                                <td><b>Remarks</b></td>
                                <td><?php echo $mainsql->truncate($notification_data[0]['Remarks03'], 50); ?></td>
                            </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php if (trim($notification_data[0]['Signatory04'])) : ?>
                        <tr>
                            <td><b>Signatory 4</b></td>
                            <td><?php echo $approver_data4[0]['FName'].' '.$approver_data4[0]['LName']; ?></td>
                        </tr>
                        <tr>
                            <?php if ($notification_data[0]['Signatory04'] == $profile_idnum) : ?>
                            <td><b><?php echo $notification_data[0]['ApprovedDate04'] ? 'Status' : '&nbsp;'; ?></b></td>
                            <td>
                                <?php if (!$notification_data[0]['ApprovedDate04'] && $notification_data[0]['ApprovedDate03'] && $notification_data[0]['Approved'] != 2) : ?>
                                    <?php if ($doctype == 'OT') : ?>
                                        <script type="text/javascript">// slider
                                            $(".approvehours").spinner({
                                              step: 0.5,
                                              spin: function( event, ui ) {
                                                if ( ui.value > <?php echo $application_data[0]['Hrs']; ?> ) {
                                                  $(this).spinner( "value", <?php echo $application_data[0]['Hrs']; ?> );
                                                  return false;
                                                } else if ( ui.value < 0 ) {
                                                  $(this).spinner( "value", 0 );
                                                  return false;
                                                }
                                              }
                                            });
                                        </script>
                                        <b>Approve Hour/s</b> <input type="text" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs'] < $application_data[0]['Hrs'] ? $application_data[0]['ApprovedHrs'] :  $application_data[0]['Hrs']; ?>" class="approvehours txtbox width50 righttalign" readonly />
                                        <!--input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" /-->
                                    <?php endif; ?>
                                    <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10" />
                                    <?php if (!$chkexpire) : ?>
                                    <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory04']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME04'] ? $notification_data[0]['DB_NAME04'] : 0; ?>"<?php if ($notification_data[0]['Signatory05']) : ?> attribute21="<?php echo $notification_data[0]['Signatory05'] ? $notification_data[0]['Signatory05'] : 0; ?>" attribute22="<?php echo $notification_data[0]['DB_NAME05'] ? $notification_data[0]['DB_NAME05'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
                                    <?php endif; ?>
                                    <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory04']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME04'] ? $notification_data[0]['DB_NAME04'] : 0; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" />
                                <?php else : ?>
                                    <?php if ($notification_data[0]['ApprovedDate04'] != NULL) : ?>
                                        <?php if ($notification_data[0]['Approved'] != 2) : ?>
                                            APPROVED BY YOU
                                        <?php else : ?>
                                            REJECTED BY YOU
                                        <?php endif; ?>
                                    <?php else : ?>
                                        TO BE APPROVED BY YOU
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <?php else : ?>
                            <td><b>Status</b></td>
                            <td><?php
                                if ($notification_data[0]['ApprovedDate04']) :
                                    echo 'APPROVED';
                                else :
                                    if ($notification_data[0]['Approved'] == 2) :
                                        echo 'REJECTED';
                                    else :
                                        echo 'TO BE APPROVED';
                                    endif;
                                endif; ?><span id="remarks" name="remarks">&nbsp;</span></td>
                            <?php endif; ?>
                        </tr>
                        <?php if ($notification_data[0]['ApprovedDate04']) : ?>
                        <tr>
                            <td><b>Date</b></td>
                            <td><?php echo date("F j, Y | g:ia", strtotime($notification_data[0]['ApprovedDate04'])); ?></td>
                        </tr>
                            <?php if (trim($notification_data[0]['Remarks04'])) : ?>
                            <tr>
                                <td><b>Remarks</b></td>
                                <td><?php echo $mainsql->truncate($notification_data[0]['Remarks04'], 50); ?></td>
                            </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php if (trim($notification_data[0]['Signatory05'])) : ?>
                        <tr>
                            <td><b>Signatory 5</b></td>
                            <td><?php echo $approver_data5[0]['FName'].' '.$approver_data5[0]['LName']; ?></td>
                        </tr>
                        <tr>
                            <?php if ($notification_data[0]['Signatory05'] == $profile_idnum) : ?>
                            <td><b><?php echo $notification_data[0]['ApprovedDate05'] ? 'Status' : '&nbsp;'; ?></b></td>
                            <td>
                                <?php if (!$notification_data[0]['ApprovedDate05'] && $notification_data[0]['ApprovedDate04'] && $notification_data[0]['Approved'] != 2) : ?>
                                    <?php if ($doctype == 'OT') : ?>
                                        <script type="text/javascript">// slider
                                            $(".approvehours").spinner({
                                              step: 0.5,
                                              spin: function( event, ui ) {
                                                if ( ui.value > <?php echo $application_data[0]['Hrs']; ?> ) {
                                                  $(this).spinner( "value", <?php echo $application_data[0]['Hrs']; ?> );
                                                  return false;
                                                } else if ( ui.value < 0 ) {
                                                  $(this).spinner( "value", 0 );
                                                  return false;
                                                }
                                              }
                                            });
                                        </script>
                                        <b>Approve Hour/s</b> <input type="text" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs'] < $application_data[0]['Hrs'] ? $application_data[0]['ApprovedHrs'] :  $application_data[0]['Hrs']; ?>" class="approvehours txtbox width50 righttalign" readonly />
                                        <!--input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" /-->
                                    <?php endif; ?>
                                    <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10" />
                                    <?php if (!$chkexpire) : ?>
                                    <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory05']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME05'] ? $notification_data[0]['DB_NAME05'] : 0; ?>"<?php if ($notification_data[0]['Signatory06']) : ?> attribute21="<?php echo $notification_data[0]['Signatory06'] ? $notification_data[0]['Signatory06'] : 0; ?>" attribute22="<?php echo $notification_data[0]['DB_NAME06'] ? $notification_data[0]['DB_NAME06'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
                                    <?php endif; ?>
                                    <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory05']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME05'] ? $notification_data[0]['DB_NAME05'] : 0; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" />
                                <?php else : ?>
                                    <?php if ($notification_data[0]['ApprovedDate05'] != NULL) : ?>
                                        <?php if ($notification_data[0]['Approved'] != 2) : ?>
                                            APPROVED BY YOU
                                        <?php else : ?>
                                            REJECTED BY YOU
                                        <?php endif; ?>
                                    <?php else : ?>
                                        TO BE APPROVED BY YOU
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <?php else : ?>
                            <td><b>Status</b></td>
                            <td><?php
                                if ($notification_data[0]['ApprovedDate05']) :
                                    echo 'APPROVED';
                                else :
                                    if ($notification_data[0]['Approved'] == 2) :
                                        echo 'REJECTED';
                                    else :
                                        echo 'TO BE APPROVED';
                                    endif;
                                endif; ?><span id="remarks" name="remarks">&nbsp;</span></td>
                            <?php endif; ?>
                        </tr>
                        <?php if ($notification_data[0]['ApprovedDate05']) : ?>
                        <tr>
                            <td><b>Date</b></td>
                            <td><?php echo date("F j, Y | g:ia", strtotime($notification_data[0]['ApprovedDate05'])); ?></td>
                        </tr>
                            <?php if (trim($notification_data[0]['Remarks05'])) : ?>
                            <tr>
                                <td><b>Remarks</b></td>
                                <td><?php echo $mainsql->truncate($notification_data[0]['Remarks05'], 50); ?></td>
                            </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php if (trim($notification_data[0]['Signatory06'])) : ?>
                        <tr>
                            <td><b>Signatory 6</b></td>
                            <td><?php echo $approver_data6[0]['FName'].' '.$approver_data6[0]['LName']; ?></td>
                        </tr>
                        <tr >
                            <?php if ($notification_data[0]['Signatory06'] == $profile_idnum) : ?>
                            <td><b><?php echo $notification_data[0]['ApprovedDate06'] ? 'Status' : '&nbsp;'; ?></b></td>
                            <td>
                                <?php if (!$notification_data[0]['ApprovedDate06'] && $notification_data[0]['ApprovedDate05'] && $notification_data[0]['Approved'] != 2) : ?>
                                    <?php if ($doctype == 'OT') : ?>
                                        <script type="text/javascript">// slider
                                            $(".approvehours").spinner({
                                              step: 0.5,
                                              spin: function( event, ui ) {
                                                if ( ui.value > <?php echo $application_data[0]['Hrs']; ?> ) {
                                                  $(this).spinner( "value", <?php echo $application_data[0]['Hrs']; ?> );
                                                  return false;
                                                } else if ( ui.value < 0 ) {
                                                  $(this).spinner( "value", 0 );
                                                  return false;
                                                }
                                              }
                                            });
                                        </script>
                                        <b>Approve Hour/s</b> <input type="text" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs'] < $application_data[0]['Hrs'] ? $application_data[0]['ApprovedHrs'] :  $application_data[0]['Hrs']; ?>" class="approvehours txtbox width50 righttalign" readonly />
                                        <!--input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" /-->
                                    <?php endif; ?>
                                    <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10" />
                                    <?php if (!$chkexpire) : ?>
                                    <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory06']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME06'] ? $notification_data[0]['DB_NAME06'] : 0; ?>" attribute21="0" attribute22="0" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
                                    <?php endif; ?>
                                    <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory06']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME06'] ? $notification_data[0]['DB_NAME06'] : 0; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="smlbtn btnred" />
                                <?php else : ?>
                                    <?php if ($notification_data[0]['ApprovedDate06'] != NULL) : ?>
                                        <?php if ($notification_data[0]['Approved'] != 2) : ?>
                                            APPROVED BY YOU
                                        <?php else : ?>
                                            REJECTED BY YOU
                                        <?php endif; ?>
                                    <?php else : ?>
                                        TO BE APPROVED BY YOU
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <?php else : ?>
                            <td><b>Status</b></td>
                            <td><?php
                                if ($notification_data[0]['ApprovedDate06']) :
                                    echo 'APPROVED';
                                else :
                                    if ($notification_data[0]['Approved'] == 2) :
                                        echo 'REJECTED';
                                    else :
                                        echo 'TO BE APPROVED';
                                    endif;
                                endif; ?><span id="remarks" name="remarks">&nbsp;</span></td>
                            <?php endif; ?>
                        </tr>
                        <?php if ($notification_data[0]['ApprovedDate06']) : ?>
                        <tr>
                            <td><b>Date</b></td>
                            <td><?php echo date("F j, Y | g:ia", strtotime($notification_data[0]['ApprovedDate06'])); ?></td>
                        </tr>
                            <?php if (trim($notification_data[0]['Remarks06'])) : ?>
                            <tr>
                                <td><b>Remarks</b></td>
                                <td><?php echo $mainsql->truncate($notification_data[0]['Remarks06'], 50); ?></td>
                            </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php if ($notification_data[0]['EmpID'] == $profile_idnum && $notification_data[0]['Approved'] != 2) : ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td><input id="btncancel" type="button" name="btncancel" value="Cancel" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['EmpID']; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btncancel btnred smlbtn" /></td>
                        </tr>
                        <?php endif; ?>
                        <?php endif; ?>

                        <?php if ($chkexpire && $notification_data[0]['Approved'] == 0) : ?>
                        <tr>
                            <td colspan="2" class="centertalign redbg"><span class="whitetext bold">APPLICATION EXPIRED</span></td>
                        </tr>
                        <?php endif; ?>

                    <?php endif; ?>

                    <?php if ($thisisposted) : ?>
                    <tr>
                        <td colspan="2" class="centertalign redbg"><span class="whitetext bold">POSTED</span></td>
                    </tr>
                    <?php endif; ?>
                </table>

            <?php

            //var_dump($approver_data1);

        break;
		//lms start
		case 'lmsview':
			$id = $_POST['id'];

			$sql = "SELECT id,
						TrainingName,
						convert(varchar, TrainingDate, 101) as TrainingDate,
						CreditHours,
						TrainingProvider,
						TrainingVenue,
						TrainingAmount,
						convert(varchar, BondStartDate, 101) as BondStartDate,
						convert(varchar, BondEndDate, 101) as BondEndDate,
						TrainingBond,
                        TrainingBondDays,
                        TrainingAmountPerDay,
                        TrainingBalance,
                        TrainingBalanceDay,
                        CertPath,
                        BondStatus_
                        FROM HREmpTrainingBond where id = $id";


			$result = $lmssql->get_row($sql, 'SUBSIDIARY');

			echo json_encode($result);
		break;
		case 'lmsdelete':
			$id = $_POST['id'];

			$sql = "DELETE FROM HREmpTraining WHERE id = $id";

			$result = $lmssql->get_execute($sql, 'SUBSIDIARY');

			if($result){
				echo "<meta http-equiv='refresh' content='0'>";
				echo "<script>alert('Training has been deleted!');</script>";
			}else{
				echo $sql;
				?>
				<!-- <h5 align="center">New Training Error!</h5> -->
				<?php
			}
		break;
		case 'lmssubmit':

			$lmsid = $_POST["lmsid"];
			$type = $_POST["lmstype"];
			$empid = $_POST["empid"];
			$dbname = $_POST["dbname"];

			$lmstraining = $_POST["lmstraining"];
			$lmsdate = $_POST["lmsdate"];
			$lmscredit = $_POST["lmscredit"];
			$lmsprovider = $_POST["lmsprovider"];
			$lmsvenue = $_POST["lmsvenue"];
			$lmsamount = $_POST["lmsamount"];
			$lmsbondstart = $_POST["lmsbondstart"];
			$lmsbondend = $_POST["lmsbondend"];
			$lmsbond = $_POST["lmsbond"];

			if($type == 'new'){
				$sql = "INSERT INTO HREmpTraining (EmpID, DBNAME, TrainingName, TrainingDate, CreditHours, TrainingProvider, TrainingVenue, TrainingAmount, BondStartDate, BondEndDate, TrainingBond)
						VALUES ('".$empid."','".$dbname."','".$lmstraining."','".$lmsdate."','".$lmscredit."','".$lmsprovider."','".$lmsvenue."','".$lmsamount."','".$lmsbondstart."','".$lmsbondend."','".$lmsbond."')";

				$result = $lmssql->get_execute($sql, 'SUBSIDIARY');

				if($result){
					echo "<meta http-equiv='refresh' content='0'>";
					echo "<script>alert('A New Training has been saved!');</script>";
				}else{
					echo $sql;
					?>
					<!-- <h5 align="center">New Training Error!</h5> -->
					<?php
				}
			}else{
				$sql = "UPDATE HREmpTraining SET TrainingName = '$lmstraining', TrainingDate = '$lmsdate', CreditHours = '$lmscredit', TrainingProvider = '$lmsprovider', TrainingVenue = '$lmsvenue', TrainingAmount = '$lmsamount',
						BondStartDate = '$lmsbondstart', BondEndDate = '$lmsbondend', TrainingBond = '$lmsbond' where id = $lmsid";

				$result = $lmssql->get_execute($sql, 'SUBSIDIARY');

				if($result){
					echo "<meta http-equiv='refresh' content='0'>";
					echo "<script>alert('Training has been saved!');</script>";
				}else{
					echo $sql;
					?>
					<!-- <h5 align="center">New Training Error!</h5> -->
					<?php
				}
			}

		break;
		//coestart
		case 'coenew':
			$level = $_POST["level"];

			$sql_companies = "SELECT * FROM HRCompany";
			$admin_companies = $mainsql->get_row($sql_companies);

		?>
			<div style="padding-top:20px;font-size:12px;">
				<!-- <div id="compensation_note" style="text-align: center; padding-bottom: 10px; color: red;">
					<i>** Note: Kindly direct CoE with Compensation (Salary) requests to Payroll Group **</i>
				</div> -->
				<table align="center">
					<tr>
						<td width="5%"></td>
						<td width="40%" align="left">
							<label>Employee ID: </label>
						</td>
						<td width="55%" align="left">
							<input id="coeemp" name="coeempid" type="text" <?php if($level == 1){ echo "readonly";} ?> value="<?php if($level == 1){ echo $profile_idnum;} ?>" class="txtbox" style="width:185px;">
						</td>
					</tr>

					<?php if($level != 1){ ?>
						<tr id="coecompany">
							<td></td>
							<td>
								<label>Company: </label>
							</td>
							<td>
								<select id="coecompany" name="coecompany" class="txtbox" style="width:193px;">
									<option value="" selected>Please Select</option>

									<!-- <?php foreach ($admin_companies as $key => $admin_company) { ?>
									<option value="<?php echo $admin_company['CompanyID']; ?>" <?php if($company_sort == $admin_company['CompanyID']){ echo "selected";} ?>><?php echo $admin_company['CompanyName']; ?></option>
									<?php }?> -->

									<?php
									$dbase_array = array(
										'GL' => ['GLOBAL01', 'LGMI01'],
										'MEGAWORLD' => ['MEGA01'],
										'CITYLINK' => ['CITYLINK01'],
										'ECINEMA' => ['ECC02'],
										'ECOC' => ['ECOC01'],
										'EPARKVIEW' => ['ECP02'],
										'EREX' => ['ERA01'],
										'FIRSTCENTRO' => ['FCI01'],
										'GLOBAL_HOTEL' => ['GLOBALHOTEL'],
										'LAFUERZA' => ['LFI01'],
										'LCTM' => ['LUCK01'],
										'MCTI' => ['MCTI'],
										'MLI' => ['MLI01'],
										'NCCAI' => ['NCCAI'],
										'NEWTOWN' => ['NEWTOWN01'],
										'SUNTRUST' => ['SUNT01'],
										'TOWNSQUARE' => ['TOWN01'],
										'SIRUS' => ['SIRUS'],
										'ASIAAPMI' => ['ASIAAPMI'],
										'MALL_ADMIN' => ['Boracay'],
										'AGILE' => ['AGILE']
									);

								foreach ($admin_companies as $key => $admin_company) {
									if(in_array($admin_company['CompanyID'], $dbase_array[$profile_dbname])){?>
										<option value="<?php echo $admin_company['CompanyID']; ?>"><?php echo $admin_company['CompanyName']; ?></option>
								<?php
									}
								}
								?>
								</select>
							</td>
						</tr>
					<?php }?>

					<tr>
						<td></td>
						<td align="left">
							<label>CoE Type: </label>
						</td>
						<td align="left">
							<select id="coetype" name="coetype" class="txtbox" style="width:193px;">
								<option value="">Please Select</option>
								<option value="COE">Certificate Of Employment</option>
								<option value="COECOMPENSATION">CoE with Compensation</option>
								<option value="COEHOUSINGPLAN">CoE for Company Housing Plan</option>
								<option value="COEJOBDESC">CoE with Job Desc</option>
								<option value="COEGOODMORAL">CoE with Good Moral</option>
								<option value="COEAPPROVEDLEAVE">CoE with Approved Leave</option>
								<?php if($level != 1){  ?><option value="COESEPARATED">CoE for Separated Employee</option> <?php } ?>
								<?php if($level != 1){  ?><option value="COESEPARATEDCOMPLETE">CoE for Separated Employee (Complete/No Accountability)</option> <?php } ?>
								<option value="COECORRECTIONNAME">CoE for Correction Name</option>
                                <?php if($level != 1){  ?><option value="COENONCASHADVANCEMENT">CoE for Non-Cash Advancement</option> <?php } ?>
                                <?php if($profile_idnum == '2021-09-0351'){  ?><option value="PHILHEALTHCSF">PhilHealth CSF</option> <?php } ?>
                                <?php if($profile_idnum == '2021-09-0351'){  ?><option value="PHILHEALTHCF1">PhilHealth CF1</option> <?php } ?>
                                <?php if($profile_idnum == '2021-09-0351'){  ?><option value="COEFORCOMPENSATION">CoE for Employee Compensation</option> <?php } ?>
                                <?php if($profile_idnum == '2021-09-0351'){  ?><option value="SSSCERT">SSS Certificate</option> <?php } ?>
                                <?php if($profile_idnum == '2021-09-0351'){  ?><option value="PHILHEALTHCERT">Philhealth Certificate</option> <?php } ?>
                                <?php if($profile_idnum == '2021-09-0351'){  ?><option value="PAGIBIGCERT">Pagibig Certificate</option> <?php } ?>
                                
							</select>
						</td>
					</tr>

					<tr id="coenamediv1">
						<td></td>
						<td>
							<label>Correction Name: </label>
						</td>
						<td>
							<input name="coecorrection" type="textarea" value="" class="txtbox" style="width:185px;">
						</td>
					</tr>

					<tr id="coejobdiv1">
						<td></td>
						<td>
							<label>Job Responsibilities: </label>
						</td>
						<td>
							<button class="add_field_button fa fa-plus">ADD TASK</button>
							<div class="coejobinput">
								<div class="first"><input type="text" name="coetasks[]" class="tasks"/><a href="#" class="remove_field fa fa-close"></a></div>
							</div>
						</td>
					</tr>

					<tr id="coeleavediv1">
						<td></td>
						<td>
							<label id="leave_from1">Leave From: </label>
						</td>
						<td>
							<input id="coeleavefrom" name="coeleavefrom" type="text" class="txtbox datepick" style="width:185px;">
						</td>
					</tr>

					<tr id="coeleavediv2">
						<td></td>
						<td>
							<label id="leave_to1">Leave To: </label>
						</td>
						<td>
							<input id="coeleaveto" name="coeleaveto" type="text" class="txtbox datepick" style="width:185px;">
						</td>
					</tr>

					<tr id="coeleavediv3">
						<td></td>
						<td>
							<label>Return To: </label>
						</td>
						<td>
							<input id="coeleavereturn" name="coeleavereturn" type="text" class="txtbox datepick" style="width:185px;">
						</td>
					</tr>

					<tr id="coeleavediv4">
						<td></td>
						<td>
							<label>Attach Image: </label>
						</td>
						<td>
							<input id="coeleavefile" name="coeleavefile" type="file">
						</td>
					</tr>

					<tr id="coecatdiv">
						<td></td>
						<td align="left">
							<label>Category: </label>
						</td>
						<td align="left">
							<select id="coecategory" name="coecategory" class="txtbox" style="width:193px;">
								<option id="coe" value="">Please Select</option>
								<option id="coe" value="LOAN">Loan</option>
								<option id="coe" value="SCHOOLREQ">School Requirements</option>
								<option id="coe" value="VISA">VISA</option>
								<option id="coe" value="OTHERS">Others</option>
								<option id="noncash" value="MATERNITY">Maternity</option>
								<option id="noncash" value="SICKNESS">Sickness</option>
							</select>
						</td>
					</tr>

					<tr id="coereasondiv">
						<td></td>
						<td align="left">
							<label>Reason: </label>
						</td>
						<td align="left">
							<select id="coereason" name="coereason" class="txtbox" style="width:193px;">
								<option id="default" value="">Please Select</option>
								<option id="loanopt" value="Car Loan Application">Car Loan Application</option>
								<option id="loanopt" value="Housing Loan Application">Housing Loan Application</option>
								<option id="loanopt" value="Bank Loan Application">Bank Loan Application</option>
								<option id="loanopt" value="Personal Loan Application">Personal Loan Application</option>
								<option id="loanopt" value="Credit Card Application">Credit Card Application</option>
								<option id="loanopt" value="Postpaid Application">Postpaid Application</option>
								<option id="schoolopt" value="Application for Masters Degree">Application for Masters Degree</option>
								<option id="schoolopt" value="Scholarship Application">Scholarship Application</option>
								<?php
								foreach($countries as $key => $value){
									echo "<option id='visaopt' value=".$key.">".$value."</option>";
								}
								?>
							</select>
						</td>
					</tr>

					<tr id="coeothersdiv">
						<td></td>
						<td>
							<label id="other_reason">Requirement For: </label>
						</td>
						<td id="other_reason_text">
							<input name="coeothers" type="textarea" value="" class="txtbox" style="width:185px;">
						</td>
					</tr>

                    <tr id="coeothersdiv0">
						<td></td>
						<td>
							<label id="other_reason">Last Day Reported: </label>
						</td>
						<td id="other_reason_date">
							<input name="coeothersdate" type="text" class="txtbox datepick" style="width:185px;">
						</td>
					</tr>

					<?php if($level != 1){ ?>
					<tr id="coehpa">
						<td></td>
						<td>
							<label>Percentage: </label>
						</td>
						<td>
							<select id="hpa_percentage" name="hpa_percentage" class="txtbox" style="width:193px;">
								<option value="">Please Select</option>
								<option value="25%">25%</option>
								<option value="30%">30%</option>
								<option value="35%">35%</option>
							</select>
						</td>
					</tr>
					<?php }?>

					<tr id="coeavail">
						<td></td>
						<td>
							<label>Availment No.: </label>
						</td>
						<td>
							<input name="avail_no" type="textarea" value="" class="txtbox" style="width:185px;">
						</td>
					</tr>

					<tr>
						<td colspan="3" align="center">
							<button id="submitcoe" value="Submit" class="smlbtn">Submit</button>
						</td>
					</tr>
				</table>
			</div>

			<script>
			$(document).ready(function(){

				<?php

					$daynum = date("j");
					if ($daynum >= 16) :
						$limitdate = date("y-m-1", strtotime("-45 days"));
					else :
						$limitdate = date("y-m-1", strtotime("-45 days"));
						//$limitdate = date("y-m-16", strtotime("-30 days"));
					endif;

					$limitodate = date("y-m-t", strtotime("30 days"));
					$limitodate_ = date("y-m-t", strtotime("30 days"));

					// if($profile_dbname == 'GL')
					//     if($limitodate > date('y-m-t', strtotime('2018-12-31'))){
					//         $limitodate = date('y-m-t', strtotime('2018-12-31'));
					//     }

				?>

				$(".datepick").datepicker({
					dateFormat: 'mm/dd/yy',
					changeMonth: true,
					changeDay: true,
					changeYear: true
				});

				var max_fields      = 5; //maximum input boxes allowed
				var wrapper   		= $(".coejobinput"); //Fields wrapper
				var add_button      = $(".add_field_button"); //Add button ID

				var x = 1; //initlal text box count
				$(add_button).click(function(e){ //on add input button click
					e.preventDefault();
					if(x < max_fields){ //max input box allowed
						x++; //text box increment
						$(wrapper).append('<div><input type="text" name="coetasks[]" class="tasks"/><a href="#" class="remove_field fa fa-close"></a></div>'); //add input box
					}
				});

				$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
					e.preventDefault(); $(this).parent('div').remove(); x--;
				});

				function removeCOEValues(){

					$("#coeleavefrom").val('');
					$("#coeleaveto").val('');
					$("#coeleavereturn").val('');
					$("#coeleavefile").val(null);
					$("#coecategory").val('');
					$("#hpa_percentage").val('');
					$("input[name=avail_no]").val('');
					$("input[name=coeothers]").val('');
					$("input[name=coecorrection]").val('');

					$(".tasks").each(function(){
						$(this).remove();
					});
					$(".remove_field").each(function(){
						$(this).remove();
					});

				}

				$("#coecatdiv").hide();
				$("#coereasondiv").hide();
				$("#coeleavediv1").hide();
				$("#coejobdiv1").hide();
				$("#coeleavediv2").hide();
				$("#coeleavediv3").hide();
				$("#coeleavediv4").hide();
				$("#coenamediv1").hide();
				$("#coehpa").hide();
				$("#coeavail").hide();
				$("#compensation_note").hide();
                $("#coeothersdiv0").hide();


				$("select[name=coetype]").change(function(){
					if($("select[name=coetype]").val() != "COE"){
						removeCOEValues();

						$("#coecatdiv").hide();
						$("#coereasondiv").hide();
						$("#coejobdiv1").hide();
						$("#coenamediv1").hide();
						$("#coeleavediv1").hide();
						$("#coeleavediv2").hide();
						$("#coeleavediv3").hide();
						$("#coeleavediv4").hide();
						$("#coeavail").hide();
						$("#coehpa").hide();
						$("#compensation_note").hide();

						if($("select[name=coetype]").val() == "COEAPPROVEDLEAVE"){
							$("#coeleavediv1").show();
                            $("#leave_from1").html("Leave From:");
                            $("#leave_to1").html("Leave To:");
							$("#coeleavediv2").show();
							$("#coeleavediv3").show();
							$("#coeleavediv4").show();
							$("#coeothersdiv").show();
							$("#other_reason").html("Requirement For:");
						}else if($("select[name=coetype]").val() == "COECORRECTIONNAME"){
							$("#other_reason").html("Requirement For:");
							$("#coeothersdiv").show();
							$("#coenamediv1").show();
						}else if ($("select[name=coetype]").val() == "COEJOBDESC") {
							$("#other_reason").html("Requirement For:");
							$("#coeothersdiv").show();
							$("#coejobdiv1").show();
						}else if($("select[name=coetype]").val() == "COEGOODMORAL"){
							$("#coeothersdiv").show();
							$("#other_reason").html("Requirement For:");
						}else if($("select[name=coetype]").val() == "COEHOUSINGPLAN"){
							$("#coehpa").show();
							$("#coeavail").show();
							$("#coeothersdiv").hide();
						}else if($("select[name=coetype]").val() == "COECOMPENSATION"){
							$("#other_reason").html("Requirement For:");
							$("#coeothersdiv").show();
						}else if($("select[name=coetype]").val() == "COESEPARATED"){
							$("#other_reason").html("Requirement For:");
							$("#coeothersdiv").show();
						}else if($("select[name=coetype]").val() == "COESEPARATEDCOMPLETE"){
							$("#other_reason").html("Requirement For:");
							$("#coeothersdiv").show();
						}else if($("select[name=coetype]").val() == "COENONCASHADVANCEMENT"){
						    $("#coecatdiv").show();
						    $("#other_reason").hide();
							$("#coeothersdiv").hide();
                            $("select option[id=noncash]").show();
                            $("select option[id=coe]").hide();
						}else if($("select[name=coetype]").val() == "COEFORCOMPENSATION"){
							$("#coeothersdiv").hide();
                            $("#coeothersdiv0").show();
						}else if($("select[name=coetype]").val() == "SSSCERT" || $("select[name=coetype]").val() == "PHILHEALTHCERT" ||
                         $("select[name=coetype]").val() == "PAGIBIGCERT"){
							$("#coeleavediv1").show();
						    $("#coeleavediv2").show();
                            $("#leave_from1").html("From:");
                            $("#leave_to1").html("To:");
							$("#coeothersdiv").hide();
						}

					}else{
						removeCOEValues();

						$("#coeleavediv1").hide();
						$("#coenamediv1").hide();
						$("#coejobdiv1").hide();
						$("#coeleavediv2").hide();
						$("#coeleavediv3").hide();
						$("#coeleavediv4").hide();
						$("#coecatdiv").show();
                        $("#coeothersdiv0").hide();
						$("#other_reason").html("Other Reason:");
						$("#coehpa").hide();
						$("#coeavail").hide();
						$("#coeothersdiv").show();
						$("#compensation_note").show();
                        $("select option[id=coe]").show();
                        $("select option[id=noncash]").hide();
                        $("#coeothersdiv0").hide();
                        
						// $("input[name=coeothers]").css({"visibility":"visible"});
					}
				});

				$("select[name=coecategory]").change(function(){
					if($("select[name=coecategory]").val() == 'LOAN'){
						$("#coereasondiv").show();
						$("select option[id=default]").attr('selected', true).change();
						$("select option[id=loanopt]").show();
						$("select option[id=schoolopt]").hide();
						$("select option[id=visaopt]").hide();
					}else if ($("select[name=coecategory]").val() == 'SCHOOLREQ') {
						$("#coereasondiv").show();
						$("select option[id=default]").attr('selected', true).change();
						$("select option[id=loanopt]").hide();
						$("select option[id=schoolopt]").show();
						$("select option[id=visaopt]").hide();
					}else if ($("select[name=coecategory]").val() == 'VISA') {
						$("#coereasondiv").show();
						$("select option[id=default]").attr('selected', true).change();
						$("select option[id=loanopt]").hide();
						$("select option[id=schoolopt]").hide();
						$("select option[id=visaopt]").show();
						$("#coeothersdiv").hide();
					}else if ($("select[name=coecategory]").val() == 'SICKNESS') {
						$("#coeothersdiv").hide();
					}else if ($("select[name=coecategory]").val() == 'MATERNITY') {
						$("#coeothersdiv").hide();
					}else{
						$("#coereasondiv").hide();
						$("#coeothersdiv").show();
					}

				});

				$("#submitcoe").on("click", function(){


					var form_data = new FormData();

					var emp = $("#coeemp").val();
					var type = $("select[name=coetype]").val();
					var category = $("select[name=coecategory]").val();
					var reason = $("select[name=coereason]").val();

                    if (type == 'COEFORCOMPENSATION'){
                        var other = $("input[name=coeothersdate]").val();
                    }else{
                        var other = $("input[name=coeothers]").val();
                    }
					var leavefrom = $("input[name=coeleavefrom]").val();
					var leaveto = $("input[name=coeleaveto]").val();
					var leavereturn = $("input[name=coeleavereturn]").val();
					if(type == 'COEAPPROVEDLEAVE'){
						var leavefile = $("#coeleavefile").prop('files')[0];
					}else{
						var leavefile = null;
					}

					var correction_name = $("input[name=coecorrection]").val();
					var avail_no = $("input[name=avail_no]").val();
					var hpa_percentage = $("select[name=hpa_percentage]").val();
					var coe_company = <?php if($level != 1){?>$("select[name=coecompany]").val() <?php }else{ echo "'$profile_comp'"; }?>;
					var tasks = $('input:text.tasks').serialize();

					if(!emp){
						alert("Employee ID is required!");
						return false;
					}else if (!coe_company){
						alert("Company ID is required!");
						return false;
					}else if (!type){
						alert("CoE Type is required!");
						return false;
					}

					if(type == 'COE'){
						if(!category){
							alert("CoE Category is required!");
							return false;
						}
					}else if (type == 'COEAPPROVEDLEAVE') {
						if(!leavefrom){
							alert("Leave from input is required!");
							return false;
						}else if(!leaveto){
							alert("Leave to input is required!");
							return false;
						}else if(!leavereturn){
							alert("Return to input is required!");
							return false;
						}else if($("#coeleavefile").get(0).files.length === 0){
							alert("Image attachment is required!");
							return false;
						}
					}

					form_data.append('file', leavefile);
					form_data.append('emp', emp);
					form_data.append('type', type);
					form_data.append('category', category);
					form_data.append('reason', reason);
					form_data.append('other', other);
					form_data.append('leavefrom', leavefrom);
					form_data.append('leaveto', leaveto);
					form_data.append('leavereturn', leavereturn);
					form_data.append('correctionname', correction_name);
					form_data.append('avail_no', avail_no);
					form_data.append('hpa_percentage', hpa_percentage);
					form_data.append('coe_company', coe_company);
					form_data.append('coetasks', tasks);
					console.log(form_data);

					$("#submitcoe").hide();
					$("#coedata").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

					$.ajax(
					{
						url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=coesubmit",
					 	processData: false,
						contentType: false,
						// data: "=" + emp + "&=" + type + "&=" + category + "&=" + reason + "&=" + other +
						// 	  "&=" + leavefrom + "&=" + leaveto + "&=" + leavereturn + "&=" +correction_name + "&" + tasks +
						// 	  "&=" + hpa_percentage + "&=" + avail_no + "&=" +coe_company + "&form_data=" +form_data,
						data: form_data,
						type: "POST",
						complete: function(){
							$("#loading").hide();
						},
						success: function(data) {
							$("#coedata").html(data);
						}
					});
				});

			});
			</script>

		<?php
		break;

		case 'coesearch':

			$ref_no = $_POST["ref_no"];
			$level = $_POST["level"];
			$approver = $_POST["approver"];

			if($ref_no == '' || $ref_no == "" || $ref_no == null){
				echo "<script>location.reload();</script>";
				break;
			}

			$sql = "SELECT B.FullName, A.* FROM COERequests A LEFT JOIN viewHREmpMaster B on A.emp_id = B.EmpID WHERE (A.ref_no = '".$ref_no."' OR B.FullName LIKE '%$ref_no%')";
			if($level == 3){
				$sql .= " AND type <> 'COECOMPENSATION'";
			}elseif ($level == 2) {
				$sql .= " AND type = 'COECOMPENSATION'";
			}

			$sql .= " ORDER BY CASE WHEN A.STATUS = 'CANCELLED' THEN 0
	              WHEN A.STATUS = 'DONE' THEN 1
	              WHEN A.STATUS = 'FOR RELEASE' THEN 2
	              ELSE 3
	              END DESC, created_at ASC";

			$result = $mainsql->get_row($sql);

			?>
			<table border="0" cellspacing="0" class="tdata width100per">
				<?php
				if ($result) :
					?>
				<tr>
				</tr>
				<tr>
					<th width="5%">#</th>
					<!-- <th width="10%">Date Requested</th> -->
					<th width="20%">FullName</th>
					<th width="10%">Type</th>
					<th width="10%">Employee</th>
					<th width="10%">Company ID</th>
					<th width="10%">Status</th>
					<th width="10%">Date Completed</th>
				</tr>
				<?php foreach ($result as $key => $value) : ?>
				<?php //$appdata = $mainsql->get_notification($value['ReqNbr']); ?>
				<tr class="btncoe cursorpoint trdata centertalign" attribute="<?php echo $value['id']; ?>" attribute5="2" attribute6="<?php echo $approver; ?>">
					<td><?php echo $start + $key + 1; ?></td>
					<!-- <td><?php //echo date('m/d/Y', strtotime($value['created_at'])); ?></td> -->
					<td><?php echo $value['FullName']; ?></td>
					<td><?php echo $value['type']; ?></td>
					<td><?php echo $value['emp_id']; ?></td>
					<td><?php echo $value['company']; ?></td>
					<td><?php echo $value['status']; ?></td>
					<td><?php echo $value['released_at'] ? date('m/d/Y', strtotime($value['released_at'])) : ''; ?></td>
				</tr>
				<?php endforeach; ?>

				<?php else : ?>
				<tr>
					<td class="bold centertalign noborder"><br><br>No COE Requisition found!
					</td>
				</tr>
				<?php endif; ?>
			</table>
			<script>
			$(".btncoe").on("click", function(){

				var id = $(this).attr('attribute');
				var level = $(this).attr('attribute5');
				var approver_level = $(this).attr('attribute6');

				$("#coe_data").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

				$("#coe_title").html('Certificate Of Employment');
				$(".floatdiv").removeClass("invisible");
				$("#coeview").show({
				  effect : 'slide',
				  easing : 'easeOutQuart',
				  direction : 'up',
				  duration : 500
				});

				$.ajax(
				{
					url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=coeold",
					data: "id=" + id + "&level=" +level+ "&approver_level=" +approver_level,
					type: "POST",
					complete: function(){
						$("#loading").hide();
					},
					success: function(data) {
						$("#coedata").html(data);
					}
				})

			});
			</script>

			<?php
		break;

		case 'coesort':

			$company_sort = $_POST["company_sort"];
			$level = $_POST["level"];

			$_SESSION["company_sort"] = $company_sort;

			$sql = "SELECT B.FullName,[outer].* FROM";
			$sql .= "(SELECT ROW_NUMBER() OVER(ORDER BY CASE WHEN STATUS = 'CANCELLED' THEN 0
	            WHEN STATUS = 'DONE' THEN 1
	            WHEN STATUS = 'FOR RELEASE' THEN 2
	            ELSE 3
	            END DESC, created_at ASC) as ROW_NUMBER, * FROM COERequests";

			if($company_sort != ''){
				$sql .= " WHERE company = '".$company_sort."'";

				if($level == 3){
					$sql .= " AND type <> 'COECOMPENSATION'";
				}elseif ($level == 2) {
					$sql .= " AND type = 'COECOMPENSATION'";
				}

			}else{
				if($level == 3){
					$sql .= " WHERE type <> 'COECOMPENSATION'";
				}elseif ($level == 2) {
					$sql .= " WHERE type = 'COECOMPENSATION'";
				}
			}



			$sql .= ") as [outer] LEFT JOIN viewHREmpMaster B on B.empid = [outer].emp_id WHERE [outer].[ROW_NUMBER] BETWEEN 1 AND 10 ORDER BY CASE WHEN [outer].STATUS = 'CANCELLED' THEN 0
	              WHEN [outer].STATUS = 'DONE' THEN 1
	              WHEN [outer].STATUS = 'FOR RELEASE' THEN 2
	              ELSE 3
	              END DESC, created_at ASC";

			$result = $mainsql->get_row($sql);

			$coe_count = $mainsql->get_coe(0, 0, null, 1, 2,$profile_idnum, $company_sort);

			$pages = $mainsql->pagination("coeadmin", $coe_count, NUM_ROWS, 9);

			?>

			<table border="0" cellspacing="0" class="tdata width100per">
				<?php
				if ($result) :
					?>
				<tr>
				</tr>
				<tr>
					<th width="5%">#</th>
					<!-- <th width="10%">Date Requested</th> -->
					<th width="20%">FullName</th>
					<th width="10%">Type</th>
					<th width="10%">Employee</th>
					<th width="10%">Company ID</th>
					<th width="10%">Status</th>
					<th width="10%">Date Completed</th>
				</tr>
				<?php foreach ($result as $key => $value) : ?>
				<?php //$appdata = $mainsql->get_notification($value['ReqNbr']); ?>
				<tr class="btncoe cursorpoint trdata centertalign" attribute="<?php echo $value['id']; ?>" attribute5="2">
					<td><?php echo $start + $key + 1; ?></td>
					<!-- <td><?php //echo date('m/d/Y', strtotime($value['created_at'])); ?></td> -->
					<td><?php echo $value['FullName']; ?></td>
					<td><?php echo $value['type']; ?></td>
					<td><?php echo $value['emp_id']; ?></td>
					<td><?php echo $value['company']; ?></td>
					<td><?php echo $value['status']; ?></td>
					<td><?php echo $value['released_at'] ? date('m/d/Y', strtotime($value['released_at'])) : ''; ?></td>
				</tr>
				<?php endforeach; ?>
				<?php if ($pages) : ?>
				<tr>
					<td colspan="10" class="centertalign"><?php echo $pages; ?></td>
				</tr>
				<?php endif; ?>
				<?php else : ?>
				<tr>
					<td class="bold centertalign noborder"><br><br>No COE Requisition found!
					</td>
				</tr>
				<?php endif; ?>
			</table>
			<script>
			$(".btncoe").on("click", function(){

				var id = $(this).attr('attribute');
				var level = $(this).attr('attribute5');
				var approver_level = $(this).attr('attribute6');
				$("#coe_data").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

				$("#coe_title").html('Certificate Of Employment');
				$(".floatdiv").removeClass("invisible");
				$("#coeview").show({
				  effect : 'slide',
				  easing : 'easeOutQuart',
				  direction : 'up',
				  duration : 500
				});

				$.ajax(
				{
					url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=coeold",
					data: "id=" + id + "&level=" +level+ "&approver_level=" +approver_level,
					type: "POST",
					complete: function(){
						$("#loading").hide();
					},
					success: function(data) {
						$("#coedata").html(data);
					}
				})

			});
			</script>

			<?php
		break;

		case 'coesubmit':

			$coeemp = trim($_POST["emp"]);
			$coetype = trim($_POST["type"]);
			$coecategory = trim($_POST["category"]);
			$coereason = str_replace("'","''",$_POST["reason"]);
			$coeother = str_replace("'","''",$_POST["other"]);
			$leave_from = $_POST["leavefrom"];
			$leave_to = $_POST["leaveto"];
			$leave_return = $_POST["leavereturn"];
			$datetoday = date('Y-m-d');
			$tasks = $_POST["coetasks"];
			$tasks = str_replace("coetasks%5B%5D=", "", $tasks);
			$tasks = explode("&", $tasks);
			$hpa_percentage = $_POST["hpa_percentage"];
			$coe_company = ($_POST["coe_company"] != '') ? $_POST["coe_company"] : $profile_comp;
			$avail_no = $_POST["avail_no"];
			$tasks = json_encode($tasks);

			if($coe_company == ''){
				$coe_company = $profile_comp;
			}

			$coetypes = [
				"2" => ["COECOMPENSATION"
				],
				"3" => ["COE","COEHOUSINGPLAN","COEJOBDESC","COEGOODMORAL","COEAPPROVEDLEAVE","COESEPARATED","COESEPARATEDCOMPLETE","COECORRECTIONNAME"
				]
			];
			$correction_name = $_POST["correctionname"];

			// backend validation
			$coe_validation = "SELECT * FROM viewHREmpMaster WHERE EmpID = '$coeemp' AND CompanyID = '$coe_company'";
			$coe_validation = $mainsql->get_row($coe_validation);

			if(empty($coe_validation)){
				?><h3 align="center">COE Request Failed! No Employee with the given Company ID found on the database.</h3><?php
				exit(0);
			} elseif (empty($coe_validation[0]['EmailAdd'])) {
				?><h3 align="center">COE Request Failed! No Employee Email set on the database.</h3><?php
				exit(0);
			}
			// end backend validation

			$coeref = "SELECT * FROM COERequests WHERE YEAR(created_at) = YEAR(GETDATE())";
			$coeref_count = $mainsql->get_numrow($coeref);

			// $refno = strtoupper("RN".str_replace('-','',$coeemp).uniqid());
			$refno = strtoupper("RN".str_replace('-','',$coeemp).$coe_company.'-'.date("Y").str_pad($coeref_count, 4, "0", STR_PAD_LEFT));


			if($coecategory == 'LOAN'){ // loan excempted for two or more loan pending coe
				$coe_check = "SELECT * from COERequests WHERE emp_id = '$coeemp' and company = '$coe_company' and type = '$coetype' and category = '$coecategory' and reason like '$coereason'
				and status not in ('Done','Cancelled')";
			}else{
				$coe_check = "SELECT * from COERequests WHERE emp_id = '$coeemp' and company = '$coe_company' and type = '$coetype' and category = '$coecategory'
				and status not in ('Done','Cancelled')";
			}

			$coe_check_result = $mainsql->get_numrow($coe_check);
			$coe_count = 0;

			if($coe_check_result > 0){
				$coe_count = 1;
			}
			if($coe_count > 0){
				$result = false;
			}else{

				if($_FILES['file']){

					$allowedExts = array("JPG", "JPEG", "GIF", "PNG", "jpg", "jpeg", "gif", "png");
					$image = $_FILES['file']['tmp_name'];
					$filename = $_FILES['file']['name'];
					$filesize = $_FILES['file']['size'];
					$filetype = $_FILES['file']['type'];

					$tempext = explode(".", $filename);
					$extension = end($tempext);
					$extension = end($tempext);

					if (($filesize < 2097152) && in_array($extension, $allowedExts)){
						$path = "../../uploads/coe/";
						$fixname = 'coe_'.$refno.".".$extension;
						$target_path = $path.$fixname;

						$filemove = move_uploaded_file(
							$_FILES['file']['tmp_name'],
							$target_path
						);
					}else{
						?><br /><h3 align="center">File size must be less than or equal to 2MB and must be an image type.</h3><?php
						exit(0);
					}
				}else{

					$fixname = null;
				}

				$sql = "INSERT INTO COERequests (ref_no, emp_id, type, category, reason, other_reason, status, company, requested_by, created_at, updated_by, updated_at, leave_from, leave_to, leave_return, correction_name, job_desc, hpa_percent, avail_no, image_src)
						VALUES ('".$refno."','".$coeemp."', '".$coetype."', '".$coecategory."', '".$coereason."', '".$coeother."', 'On Process', '".$coe_company."', '".$profile_idnum."', '".$datetoday."', '".$profile_idnum."', '".$datetoday."',
								'".$leave_from."', '".$leave_to."', '".$leave_return."', '".$correction_name."', '".$tasks."', '".$hpa_percentage."', '".$avail_no."', '".$fixname."')";

				$result = $mainsql->get_execute($sql);

				$coe_sql = "SELECT * FROM COERequests Where ref_no='$refno'";

				$coe_result = $mainsql->get_row($coe_sql);
			}

			if($result){

				echo "<meta http-equiv='refresh' content='0'>";
				echo "<script>alert('A new CoE has been applied!');</script>";

				$emp_info = "SELECT * FROM viewHREmpMaster A
							left join HRCompany B on A.CompanyID = B.CompanyID
							left join HRDivision C on A.DivisionID = C.DivisionID
							left join HRDepartment D on A.DeptID = D.DeptID
							WHERE A.EmpID='$coeemp' AND A.CompanyID ='$coe_company'";

				$emp_hr  = "SELECT B.EmailAdd, A.level FROM COEUsers A
							LEFT JOIN SUBSIDIARY.DBO.viewHREmpMaster B on A.emp_id = B.EmpID AND A.[DB_NAME] = B.DBNAME
							WHERE ";

				if(in_array($coetype, $coetypes["2"])){
					$emp_hr .="A.[level] = '2'";
				}else{
					$emp_hr .="A.[level] = '3'";//change to 3 to mail the individual assigned hr in coeusers and delete #hrportal
				}
				$emp_hr .=" or A.[level] ='1'";

				$emp_info = $mainsql->get_row($emp_info);
				$emp_hr = $mainsql->get_row($emp_hr);

				if($emp_hr[0]['level'] == 2){
					$title_notif = 'PR';
				}else{
					$title_notif = 'HR';
				}

				$hr_emails = array();

				foreach($emp_hr as $hr_id){
					array_push($hr_emails, $hr_id['EmailAdd']);
				}

				$coes = [
					'COECOMPENSATION' => 'CoE with Compensation',
					'COEHOUSINGPLAN' => 'CoE for Company Housing Plan',
					'COEJOBDESC' => 'CoE with Job Description',
					'COEGOODMORAL' => 'CoE with Good Moral',
					'COEAPPROVEDLEAVE' => 'CoE with Approved Leave',
					'COECORRECTIONNAME' => 'CoE for Correction Name',
					'COESEPARATED' => 'CoE for Separated Employee',
					'COESEPARATEDCOMPLETE' => 'CoE for Separated Employee (Complete/No Accountability)',
                    'COENONCASHADVANCEMENT' => 'CoE for Non-Cash Advancement',
                    'PHILHEALTHCSF' => 'PhilHealth CSF',
                    'PHILHEALTHCF1' => 'PhilHealth CF1',
                    'COEFORCOMPENSATION' => 'CoE for Employee Compensation',
                    'SSSCERT' => 'SSS Certificate',
                    'PHILHEALTHCERT' => 'Philhealth Certificate',
                    'PAGIBIGCERT' => 'Pagibig Certificate'
				];
				$coes2 = [
					'LOAN' => 'Certificate of Employment (Loan0)',
					'SCHOOLREQ' => 'Certificate of Employment (School Requirement)',
					'VISA' => 'Certificate of Employment (VISA)',
                    'MATERNITY' => 'Maternity',
                    'SICKNESS' => 'Sickness'
				];

				//change dates according to database
				//SEND EMAIL TO EMPLOYEE
				$message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 95%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New Certificate of Employment Request</span><br><br>Hi ".$emp_info[0]['NickName'].",<br><br>";
				if($coeemp == $profile_idnum){
					if($coetype == 'COE'){
                        if($coecategory == 'OTHERS'){
                            $message .= "You have successfully submitted a Certificate of Employment (".$coeother.") with a Reference No: ".$refno.".";
                        }else{
                            $message .= "You have successfully submitted a Certificate of Employment (".$coes2["$coecategory"].") with a Reference No: ".$refno.".";
                        }
					}elseif($coetype == 'COENONCASHADVANCEMENT'){
						$message .= "You have successfully submitted a Certificate of Employment (CoE for Non-Cash Advancement - ".$coes2["$coecategory"].") with a Reference No: ".$refno.".";
					}else{
						$message .= "You have successfully submitted a Certificate of Employment (".$coes["$coetype"].") with a Reference No: ".$refno.".";
					}
				}else{
					if($coetype == 'COE'){
                        if($coecategory == 'OTHERS'){
                            $message .= "You have successfully submitted a Certificate of Employment (".$coeother.") with a Reference No: ".$refno.".";
                        }else{
                            $message .= "You have successfully submitted a Certificate of Employment (".$coes2["$coecategory"].") with a Reference No: ".$refno.".";
                        }
					}elseif($coetype == 'COENONCASHADVANCEMENT'){
						$message .= "A new Certificate of Employment (CoE for Non-Cash Advancement - ".$coes2["$coecategory"].") has been requested for you with a Reference No: ".$refno.".";
					}else{
						$message .= "A new Certificate of Employment (".$coes["$coetype"].") has been requested for you with a Reference No: ".$refno.".";
					}
				}
				$message .= "<br><br>Thanks,<br>";
				$message .= SITENAME." Admin";
				$message .= "<br>Click<a href='https://portal.megaworldcorp.com/me/login'> here</a> to login";
				$message .= "<hr />".MAILFOOT."</div>";

				$headers = "From: ".NOTIFICATION_EMAIL."\r\n";
				$headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

				$coe_emp_email = $emp_info[0]['EmailAdd'];

				if(!$emp_info[0]['Active']){
					$coe_emp_email = $emp_info[0]['EmailAdd2'];
				}

				if(!empty($coe_emp_email)){
					$emp_sendmail = mail($coe_emp_email, "New COE Request", $message, $headers);
				}

				//backhere
				//SEND EMAIL TO HR
				// foreach($hr_emails as $email){
				// }

					$message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 95%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New Certificate of Employment Request</span><br><br>";

					$message .= "A new Certificate of Employment ";
					if($coetype == 'COE'){
                        if($coecategory = 'OTHERS'){
                            $message .= "(".$coeother.")";
                        }else{
                            $message .= "(".$coes2["$coecategory"].")";
                        }
					}elseif($coetype == 'COENONCASHADVANCEMENT'){
                        $message .= "(CoE for Non-Cash Advancement - ".$coes2["$coecategory"].")";
                    }else{
						$message .= "(".$coes["$coetype"].")";
					}
					$message .= ", created at ".date('F j, Y', strtotime($coe_result[0]['created_at'])).", has been requested for ".$emp_info[0]['FullName']."(".$emp_info[0]['CompanyName'].") - (".$emp_info[0]['DeptDesc'].") with a Reference No: ".$refno.".";

					$message .= "<br><br>Thanks,<br>";
					$message .= SITENAME." Admin";
					$message .= "<br>Click<a href='https://portal.megaworldcorp.com/me/login'> here</a> to login";
					$message .= "<hr />".MAILFOOT."</div>";

					$headers = "From: ".NOTIFICATION_EMAIL."\r\n";
					$headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

					$sendmail = mail(implode(',', $hr_emails), "New COE Request ($title_notif Notification)", $message, $headers);
					// $sendmail = mail('shart.global@megaworldcorp.com', "New COE Request ($title_notif Notification)", $message, $headers);

				//$sendmail = mail("hrportal@megaworldcorp.com", "New COE Request ($title_notif Notification)", $message, $headers); //#HRPortal


			}else{
				?><h3 align="center">COE Request Failed! Please make sure you have no pending COE request of this type/category.</h3><?php
			}

		break;

		case 'coeold':

			$id = $_POST['id'];
			$level = $_POST['level'];
			$approver_level = $_POST['approver_level'];

			$sql = "SELECT * FROM COERequests WHERE id=$id";

			$result = $mainsql->get_row($sql);

			$date_resigned_empid = $result[0]['emp_id'];
			$date_resigned_sql = "SELECT DateResigned from viewHREmpMaster WHERE EmpID = '$date_resigned_empid'";
			$date_resigned_data = $mainsql->get_row($date_resigned_sql);
			if(date('Y-m-d', strtotime($date_resigned_data[0]['DateResigned'])) > date('Y-m-d')){
				$date_resigned = date('F j, Y', strtotime($date_resigned_data[0]['DateResigned']));
			}

			$coe_comp = $result[0]['company'];
			$coe_comp = "SELECT * FROM HRCompany Where CompanyID = '$coe_comp'";
			$coe_comp = $mainsql->get_row($coe_comp);

			$tasks = json_decode($result[0]['job_desc'], true);
			?>

			<div style="padding-top:20px;font-size:12px;" id="coe_old_div">
				<table align="center">
					<tr>
						<td width="5%"></td>
						<td width="40%" align="left" <?php if($level != 2) { ?>width="40%"<?php }else{ echo "width='40%'"; } ?>><label>Employee ID: </label></td>
						<td width="55%" align="left"<?php if($level != 2) { ?>width="40%"<?php }else{ echo "width='55%'"; } ?>><?php echo $result[0]['emp_id']; ?></td>
					</tr>

					<?php if($level != 1){ ?>
						<td width="5%"></td>
						<td align="left" <?php if($level != 2) { ?>width="40%"<?php }else{ echo "width='40%'"; } ?>><label>Company: </label></td>
						<td align="left"<?php if($level != 2) { ?>width="40%"<?php }else{ echo "width='55%'"; } ?>><?php echo $coe_comp[0]['CompanyName']; ?></td>
					<?php } ?>

					<tr>
						<td></td>
						<td align="left"><label>CoE Type: </label></td>
						<td align="left">
							<?php if($result[0]['type'] == 'COE'){ echo "Certificate Of Employment"; }?>
							<?php if($result[0]['type'] == 'COECOMPENSATION'){ echo "CoE with Compensation"; }?>
							<?php if($result[0]['type'] == 'COEHOUSINGPLAN'){ echo "CoE for Company Housing Plan"; }?>
							<?php if($result[0]['type'] == 'COEJOBDESC'){ echo "CoE with Job Desc"; }?>
							<?php if($result[0]['type'] == 'COEGOODMORAL'){ echo "CoE with Good Moral"; }?>
							<?php if($result[0]['type'] == 'COEAPPROVEDLEAVE'){ echo "CoE with Approved Leave"; }?>
							<?php if($result[0]['type'] == 'COESEPARATED'){ echo "CoE for Separated Employee"; }?>
							<?php if($result[0]['type'] == 'COESEPARATEDCOMPLETE'){ echo "CoE for Separated Employee (Complete/No Accountability)"; }?>
							<?php if($result[0]['type'] == 'COECORRECTIONNAME'){ echo "CoE for Correction Name"; }?>
							<?php if($result[0]['type'] == 'COENONCASHADVANCEMENT'){ echo "CoE for Non-Cash Advancement"; }?>
							<?php if($result[0]['type'] == 'PHILHEALTHCSF'){ echo "PhilHealth CSF"; }?>
							<?php if($result[0]['type'] == 'PHILHEALTHCF1'){ echo "PhilHealth CF1"; }?>
							<?php if($result[0]['type'] == 'COEFORCOMPENSATION'){ echo "CoE for Employee Compensation"; }?>
							<?php if($result[0]['type'] == 'SSSCERT'){ echo "SSS Certificate"; }?>
						</td>
					</tr>

					<tr id="coejobdiv1">
						<td></td>
						<td>
							<label>Job Responsibilities: </label>
						</td>
						<td>
							<?php if($level != 1){ ?>
							<button align="center" class="add_field_button fa fa-plus">ADD TASK</button></br>
							<?php } ?>
							<div class="coejobinput">
								<?php foreach($tasks as $task){ ?>
								<div class="first">
									<?php if($level != 1){ ?>
										<a href="#" class="remove_field fa fa-close"></a>
									<?php } ?>
									<input type="text" name="coetasks[]" class="txtbox tasks" style="width:175px;" value="<?php echo $task; ?>"/>
								</div>
								<?php } ?>
							</div>
						</td>
					</tr>

					<tr id="coenamediv1">
						<td></td>
						<td align="left">
							<label>Correction Name: </label>
						</td>
						<td align="left">
							<?php echo $result[0]['correction_name']; ?>
						</td>
					</tr>

					<tr id="coeleavediv1">
						<td></td>
						<td align="left">
							<label id="leave_from2">Leave From: </label>
						</td>
						<td align="left">
							<?php echo date('m/d/Y', strtotime($result[0]['leave_from'])); ?>
						</td>
					</tr>

					<tr id="coeleavediv2">
						<td></td>
						<td align="left">
							<label id="leave_to2">Leave To: </label>
						</td>
						<td align="left">
							<?php echo date('m/d/Y', strtotime($result[0]['leave_to'])); ?>
						</td>
					</tr>

					<tr id="coeleavediv3">
						<td></td>
						<td align="left">
							<label>Return To: </label>
						</td>
						<td align="left">
							<?php echo date('m/d/Y', strtotime($result[0]['leave_return'])); ?>
						</td>
					</tr>
					<!--   -->
					<tr id="coeleavediv4">
						<td></td>
						<td align="left">
							<label>Attachment: </label>
						</td>
						<td align="left">
							<?php
								echo '<u><a style="color: #0000ff !important;" href="'.WEB.'/uploads/coe/'.$result[0]['image_src'].'" target="_blank">Image File</a></u>';
							?>
						</td>
					</tr>

					<tr id="coecatdiv2">
						<td></td>
						<td align="left"><label>Category: </label></td>
						<td align="left">
							<?php if($result[0]['category'] == 'LOAN'){ echo "Loan"; }?>
							<?php if($result[0]['category'] == 'SCHOOLREQ'){ echo "School Requirements"; }?>
							<?php if($result[0]['category'] == 'VISA'){ echo "VISA"; }?>
							<?php if($result[0]['category'] == 'OTHERS'){ echo "Others"; }?>
                            <?php if($result[0]['category'] == 'MATERNITY'){ echo "Maternity"; }?>
                            <?php if($result[0]['category'] == 'SICKNESS'){ echo "Sickness"; }?>
						</td>
					</tr>

					<tr id="coereasondiv2">
						<td></td>
						<td align="left"><label>Reason: </label></td>
						<td align="left">
							<?php if($result[0]['reason'] == 'Car Loan Application'){ echo "Car Loan Application"; }  ?>
							<?php if($result[0]['reason'] == 'Housing Loan Application'){ echo "Housing Loan Application"; }  ?>
							<?php if($result[0]['reason'] == 'Bank Loan Application'){ echo "Bank Loan Application"; }  ?>
							<?php if($result[0]['reason'] == 'Personal Loan Application'){ echo "Personal Loan Application"; }  ?>
							<?php if($result[0]['reason'] == 'Credit Card Application'){ echo "Credit Card Application"; }  ?>
							<?php if($result[0]['reason'] == 'Postpaid Application'){ echo "Postpaid Application"; }  ?>
							<?php if($result[0]['reason'] == 'Application for Masters Degree'){ echo "Application for Masters Degree"; }  ?>
							<?php if($result[0]['reason'] == 'Scholarship Application'){ echo "Scholarship Application"; }  ?>
							<?php
							foreach($countries as $key => $value){
								if($result[0]['reason'] == $key){ echo $value; }
							}
							?>
						</td>
					</tr>

					<tr id="coeothersdiv2">
						<td></td>
						<td align="left"><label id="other_reason">Requirement For: </label></td>
						<td align="left">
							<?php if($level == 2){ ?>
									<input id="coeothers2" name="coeothers2" type="textarea" value="<?php if($result[0]['other_reason'] != null){echo $result[0]['other_reason'];} ?>" class="txtbox" style="width:185px;">
							<?php }else{
									echo $result[0]['other_reason']; }
							?>
						</td>
					</tr>
                    

					<tr id="coeavail2">
						<td></td>
						<td align="left"><label>Avail No.: </label></td>
						<td align="left">
							<?php if($level == 2){ ?>
									<input id="avail_no2" name="avail_no2" type="textarea" value="<?php if($result[0]['avail_no'] != null){echo $result[0]['avail_no'];} ?>" class="txtbox" style="width:185px;">
							<?php }else{
									echo $result[0]['avail_no']; }
							?>
						</td>
					</tr>

					<?php if($level != 1){ ?>
					<tr id="coehpa2">
						<td></td>
						<td align="left"><label>Percentage: </label></td>
						<td align="left">
							<?php if($level == 2){ ?>
									<select id="hpa_percent2" name="coestatus2" class="txtbox" style="width:193px;" >
										<option value="">Please Select</option>
										<option value="25%"<?php if($result[0]['hpa_percent'] == '25%'){ echo "selected"; }  ?>>25%</option>
										<option value="30%"<?php if($result[0]['hpa_percent'] == '30%'){ echo "selected"; }  ?>>30%</option>
										<option value="35%"<?php if($result[0]['hpa_percent'] == '35%'){ echo "selected"; }  ?>>35%</option>
									</select>
							<?php } ?>
						</td>
					</tr>
				<?php }?>

					<tr id="coestatusdiv2">
						<td></td>
						<td align="left"><label>Status: </label></td>
						<td align="left">
							<?php if($level == 2){ ?>
								<?php if($result[0]['status'] == 'Done' || $result[0]['status'] == 'Cancelled'){ ?>
										<select id="coestatus2" name="coestatus2" class="txtbox" style="width:193px;" >
											<option id="statusopt" value="<?php echo $result[0]['status']; ?>"><?php if($result[0]['status'] == 'Done'){echo 'Done/Claimed';}else{echo $result[0]['status'];} ?></option>
										</select>
								<?php }else{ ?>
										<select id="coestatus2" name="coestatus2" class="txtbox" style="width:193px;" >
											<!-- <option id="statusopt" value="Pending"<?php //if($result[0]['status'] == 'Pending'){ echo "selected"; }  ?>>Pending</option> -->
											<?php if($result[0]['status'] == 'On Process'){ ?>
												<option id="statusopt" value="On Process"<?php if($result[0]['status'] == 'On Process'){ echo "selected"; }  ?>>On Process</option>
											<?php } ?>

											<?php if($result[0]['status'] == 'On Process' || $result[0]['status'] == 'For Approval'){ ?>
												<option id="statusopt" value="For Approval"<?php if($result[0]['status'] == 'For Approval'){ echo "selected"; }  ?>>For Approval - (E-signature)</option>
											<?php } ?>

											<?php if($result[0]['status'] == 'On Process' || $result[0]['status'] == 'For Release'){ ?>
												<option id="statusopt" value="For Release"<?php if($result[0]['status'] == 'For Release'){ echo "selected"; }  ?>>For Release</option>
											<?php } ?>

											<?php if($result[0]['status'] == 'On Done' || $result[0]['status'] == 'For Release'){ ?>
												<option id="statusopt" value="Done"<?php if($result[0]['status'] == 'Done'){ echo "selected"; }  ?>>Done/Claimed</option>
											<?php } ?>

											<?php if($result[0]['status'] == 'Cancelled'){ ?>
												<option id="statusopt" value="Cancelled"<?php if($result[0]['status'] == 'Cancelled'){ echo "selected"; }  ?>>Cancelled</option>
											<?php } ?>
										</select>
								<?php } ?>
							<?php }else{ ?>
									<?php //if($result[0]['status'] == 'Pending'){ echo "Pending"; }  ?>
									<?php if($result[0]['status'] == 'On Process'){ echo "On Process"; }  ?>
									<?php if($result[0]['status'] == 'For Approval'){ echo "For Approval"; }  ?>
									<?php if($result[0]['status'] == 'For Release'){ echo "For Release"; }  ?>
									<?php if($result[0]['status'] == 'Done'){ echo "Done/Claimed"; }  ?>
									<?php if($result[0]['status'] == 'Cancelled'){ echo "Cancelled"; }  ?>
							<?php } ?>
						</td>
					</tr>

					<tr id="coerefno2">
						<td></td>
						<td align="left">
							<label>Ref no.: </label>
						</td>
						<td align="left">
							<?php echo $result[0]['ref_no']; ?>
						</td>
					</tr>

					<?php if($result[0]['status'] == 'Cancelled'){ ?>
					<tr id="coe_cancelled">
						<td></td>
						<td align="left">
							<label>Cancellation Remarks: </label>
						</td>
						<td align="left">
							<?php echo $result[0]['cancel_remarks']; ?>
						</td>
					</tr>
					<?php } ?>

					<?php if($level == 2 && (in_array($result[0]['status'], ['For Release', 'Done'] ))){ ?>
						<tr id="coeapproval">
							<td></td>
							<td align="left">
								<label>E-signature Approval: </label>
							</td>
							<td align="left">
								<?php echo $result[0]['approved'] ? 'Approved' : 'N/A'; ?>
							</td>
						</tr>
                        <tr id="coeapproval">
							<td></td>
							<td align="left">
								<label>Released At</label>
							</td>
							<td align="left">
								<?php echo $result[0]['released_at'] ? date("Y-m-d H:i A", strtotime($result[0]['released_at'])) : '--'; ?>
							</td>
						</tr>
					<?php } ?>

					<tr>
						<td colspan="3" align="center">
							<?php if($level == 2){
									if($result[0]['status'] == 'On Process' || $result[0]['status'] == 'For Release' || $result[0]['status'] == 'Done' || $result[0]['status'] == 'For Approval'){?>
										<button id="printcoe" value="Print" attribute="<?php echo $result[0]['id']; ?>" attribute2="<?php echo $result[0]['status']; ?>" attribute3="<?php echo $result[0]['type']; ?>" class="smlbtn" style="background-color:#3EC2FB; width:45px;">Print</button>
							<?php 	} ?>

							<?php	if(($result[0]['status'] == 'For Release' || $result[0]['status'] == 'Done') && $result[0]['status'] != 'Cancelled' && $result[0]['approved'] == 1){?>
										<button id="sendcoe" value="Send" attribute4="<?php echo $date_resigned; ?>" attribute="<?php echo $result[0]['id']; ?>" attribute2="<?php echo $result[0]['status']; ?>" attribute3="<?php echo $result[0]['type']; ?>" class="smlbtn" style="background-color:#3EC2FB; width:45px;">Send</button>
										<!-- <a href="<?php echo WEB; ?>/coe_pdf?id=<?php echo $result[0]['id']; ?>&type=<?php echo $result[0]['type']; ?>&send=TRUE" target="_blank"><button class="smlbtn" style="background-color:#3EC2FB; width:45px;">Send</button></a> -->
							<?php 	} ?>
							<?php	if($result[0]['status'] == 'Done' || $result[0]['status'] == 'Cancelled'){ ?>
							<?php 	}else{
										if($result[0]['status'] == 'For Approval'){
											if($approver_level == "1"){?>
												<button id="savecoe" value="Save" attribute9="<?php echo $result[0]['company']; ?>" attribute8="<?php echo $result[0]['status']; ?>" attribute5="<?php echo $result[0]['ref_no']; ?>" attribute4="<?php echo $result[0]["type"]; ?>" attribute3="<?php echo $result[0]['emp_id']; ?>" attribute="<?php echo $result[0]['id'] ?>" attribute2="<?php echo $result[0]['cancelled_at'].$result[0]['released_at']; ?>" class="smlbtn" style="width:<?php echo $result[0]['status'] == 'For Approval' ? '55px' : '40px'; ?>;" <?php if($result[0]['cancelled_at'] != null || $result[0]['released_at'] != null){ echo "disabled";} ?>> <?php echo $result[0]['status'] == 'For Approval' ? 'Approve' : 'Save'; ?></button>
							<?php 			}
										}else{ ?>
											<button id="savecoe" value="Save" attribute9="<?php echo $result[0]['company']; ?>" attribute8="<?php echo $result[0]['status']; ?>" attribute5="<?php echo $result[0]['ref_no']; ?>" attribute4="<?php echo $result[0]["type"]; ?>" attribute3="<?php echo $result[0]['emp_id']; ?>" attribute="<?php echo $result[0]['id'] ?>" attribute2="<?php echo $result[0]['cancelled_at'].$result[0]['released_at']; ?>" class="smlbtn" style="width:<?php echo $result[0]['status'] == 'For Approval' ? '55px' : '40px'; ?>;" <?php if($result[0]['cancelled_at'] != null || $result[0]['released_at'] != null){ echo "disabled";} ?>> <?php echo $result[0]['status'] == 'For Approval' ? 'Approve' : 'Save'; ?></button>
								  <?php }
									} ?>
							<?php } ?>

							<?php if($result[0]['status'] == 'Done' || $result[0]['status'] == 'Cancelled'){ ?>
							<?php }else{ ?>

								<button id="coecancel" class="btncancel btnred smlbtn" style="width:45px;">Cancel</button>

							<?php } ?>

							<?php if($level == 2){

							 	  } ?>

						</td>
					</tr>
				</table>
			</div>

			<div id="coe_old_cancel" style="padding-top:20px;font-size:12px;padding-top:50px;">
				<table align="center">
					<tr>
						<td width="5%"></td>
						<td width="40%" align="left"><label>Cancellation Remarks: </label></td>
						<td width="55%" align="left">
							<textarea id="cancel_remarks" name="cancel_remarks" class="txtbox" style="width:195px;"></textarea>
							<!-- <input id="cancel_remarks" name="cancel_remarks" type="text" class="txtbox" style="width:185px;"> -->
						</td>
						<tr>
							<td colspan="3" align="center">
								<div style="padding-top: 25px;">
									<button id="coecancelsubmit" value="Cancel" attribute9="<?php echo $result[0]['company']; ?>" attribute5="<?php echo $result[0]['ref_no']; ?>" attribute4="<?php echo $result[0]["type"]; ?>" attribute3="<?php echo $result[0]['emp_id']; ?>" attribute="<?php echo $result[0]['id'] ?>" attribute2="<?php echo $result[0]['cancelled_at'].$result[0]['released_at']; ?>" class=" smlbtn" style="background-color:#3EC2FB; width:50px;" <?php if($result[0]['cancelled_at'] != null || $result[0]['released_at'] != null){ echo "disabled";} ?>>Submit</button>
									<button id="coeback" class="smlbtn btncancel btnred" style="width:50px;">Back</button>
								</div>
							</td>
						</tr>
					</tr>
				</table>
			</div>

			<script>
				$(document).ready(function(){

					$("#coeleavediv1").hide();
					$("#coeleavediv2").hide();
					$("#coeleavediv3").hide();
					$("#coeleavediv4").hide();
					$("#coenamediv1").hide();
					$("#coecatdiv2").hide();
					$("#coecatdiv3").hide();
					$("#coereasondiv2").hide();
					$("#coejobdiv1").hide();
					$("#coeavail2").hide();
					$("#coehpa2").hide();
					$("#coe_old_cancel").hide();


					if('<?php echo $level ?>' != 2){
						$("select option[id=statusopt]").hide();
					}
					if('<?php echo $result[0]['type']; ?>' == 'COEAPPROVEDLEAVE'){
						$("#coeleavediv1").show();
						$("#coeleavediv2").show();
						$("#other_reason").html("Other Reason:");
						$("#coeleavediv3").show();
						$("#coeleavediv4").show();
						$("#coecatdiv2").hide();
                        $("#coecatdiv3").hide();
						$("#coereasondiv2").hide();
					}else if ('<?php echo $result[0]['type']; ?>' == 'COECORRECTIONNAME') {
						$("#coenamediv1").show();
						$("#other_reason").html("Other Reason:");
						$("#coecatdiv2").hide();
                        $("#coecatdiv3").hide();
						$("#coereasondiv2").hide();

					}else if ('<?php echo $result[0]['type']; ?>' == 'COE') {
						$("#coecatdiv2").show();
						$("#coereasondiv2").show();
                        $("#coecatdiv3").hide();
					}else if ('<?php echo $result[0]['type']; ?>' == 'COEJOBDESC') {
						$("#coejobdiv1").show();
					}else if ('<?php echo $result[0]['type']; ?>' == 'COEHOUSINGPLAN') {
						$("#coeothersdiv2").hide();
						$("#coeavail2").show();
						$("#coehpa2").show();
					}else if ('<?php echo $result[0]['type']; ?>' == 'COENONCASHADVANCEMENT') {
                        $("#coecatdiv2").show();
                        $("#coeothersdiv2").hide();
					}else if ('<?php echo $result[0]['type']; ?>' == 'SSSCERT' || '<?php echo $result[0]['type']; ?>' == 'PAGIBIGCERT' ||
                     '<?php echo $result[0]['type']; ?>' == 'PHILHEALTHCERT') {
                        $("#coeleavediv1").show();
						$("#coeleavediv2").show();
                        $("#leave_from1").html("From:");
                        $("#leave_to1").html("To:");
						$("#coeothersdiv2").hide();
					}

                    

 					//add input box
					var max_fields      = 10;
					var wrapper   		= $(".coejobinput");
					var add_button      = $(".add_field_button");

					var x = 1;
					$(add_button).click(function(e){
						e.preventDefault();
						if(x < max_fields){
							x++;
							$(wrapper).append('<div><a href="#" class="remove_field fa fa-close"></a><input type="text" name="coetasks[]" class="txtbox tasks" style="width:175px;"/></div>');
						}
					});

					$(wrapper).on("click",".remove_field", function(e){
						e.preventDefault(); $(this).parent('div').remove(); x--;
					});

					$("#coecancel").on("click", function(){
						$("#coe_old_cancel").show();
						$("#coe_old_div").hide();
					});

					$("#coeback").on("click", function(){
						$("#coe_old_cancel").hide();
						$("#coe_old_div").show();
					});

					$("#coecancelsubmit").on("click", function(){
						$("#savecoe").hide();
						$("#coecancelsubmit").hide();
						var id = $(this).attr('attribute');
						var emp_id = $(this).attr('attribute3');
						var company_id = $(this).attr('attribute9');
						var type = $(this).attr('attribute4');
						var ref_no = $(this).attr('attribute5');
						var status = 'Cancelled';
						var others = $("#coeothers2").val();
						var cancel_remarks = $("#cancel_remarks").val();
						var disabutton = $(this).attr('attribute2');
						var tasks = $('input:text.tasks').serialize();

						if(disabutton != ''){
							alert('This request cannot be cancelled!');
							return;
						}

						$("#coedata").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

						$.ajax(
						{
							url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=coesave",
							data: "id=" + id + "&emp_id=" + emp_id + "&status=" + status + "&others=" + others + "&" + tasks
										+ "&ref_no=" + ref_no + "&type=" + type + '&company_id=' +company_id
										+ "&cancel_remarks=" +cancel_remarks,
							type: "POST",
							complete: function(){
								$("#loading").hide();
							},
							success: function(data) {
								$("#coedata").html(data);
							}
						});
					});

					$("#savecoe").on("click", function(){
						$("#coecancel").hide();
						$("#savecoe").hide();
						var id = $(this).attr('attribute');
						var company_id = $(this).attr('attribute9');
						var old_status = $(this).attr('attribute8');
						var emp_id = $(this).attr('attribute3');
						var type = $(this).attr('attribute4');
						var ref_no = $(this).attr('attribute5');
						var status = $("#coestatus2").val();
						var others = $("#coeothers2").val();
						var disabutton = $(this).attr('attribute2');
						var tasks = $('input:text.tasks').serialize();
						var hpa_percent = $("#hpa_percent2").val();
						var avail_no = $("#avail_no2").val();
						var cancel_remarks = '';

						if(disabutton != ''){
							return;
						}

						$("#coedata").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

						$.ajax(
						{
							url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=coesave",
							data: "id=" + id + "&emp_id=" + emp_id + "&status=" + status + "&others=" + others + "&" + tasks + "&ref_no=" + ref_no + "&type=" + type + '&hpa_percent=' + hpa_percent + '&avail_no=' + avail_no + '&old_status=' +old_status + '&company_id=' +company_id + '&cancel_remarks='+cancel_remarks,
							type: "POST",
							complete: function(){
								$("#loading").hide();
							},
							success: function(data) {
								$("#coedata").html(data);
							}
						});

					});

					$("#sendcoe").on('click', function(){
						var id = $(this).attr('attribute');
						var status = $(this).attr('attribute2');
						var type = $(this).attr('attribute3');
						var date_resigned = $(this).attr('attribute4');

						if( new Date(date_resigned) < new Date() && type != 'COECOMPENSATION'){
							alert('You can send the COE on or after the resignation effectivity date. (Resignation Date: '+date_resigned+')');
							return;
						} else
                        {
                            // alert('Working');
                        }

						if(type == 'COEAPPROVEDLEAVE'){
							var start_date = "<?php echo date('m/d/Y', strtotime($result[0]['leave_from'])); ?>";
							var end_date = "<?php echo date('m/d/Y', strtotime($result[0]['leave_to'])); ?>";
							var return_date = "<?php echo date('m/d/Y', strtotime($result[0]['leave_return'])); ?>";
							var url_print = "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=coesend&type=COEAPPROVEDLEAVE";
							var data_print = "id=" + id + "&status=" + status + "&start_date=" + start_date + "&end_date=" + end_date + "&return_date=" + return_date + "&send=" + true;
						}else{
							var url_print = "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=coesend&type="+type;
							var data_print = "id=" + id + "&status=" + status + "&start_date=" + start_date + "&end_date=" + end_date + "&return_date=" + return_date + "&send=" + true;
						}

						if(status == 'For Release' || status == 'Done'){

							if (confirm('The signed certificate will now be sent to the employee and the request will be marked as Done/Claimed.\r\n\r\nPlease confirm to continue.')) {

								$("#coedata").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

								$.ajax(
								{
									url: url_print,
									data: data_print,
									type: "POST",
									complete: function(){
										$("#loading").hide();
									},
									success: function(data) {
										$("#coedata").html(data);
									}
								});
							}

						}


					});

					$("#printcoe").on('click', function(){
						var id = $(this).attr('attribute');
						var status = $(this).attr('attribute2');
						var type = $(this).attr('attribute3');

						if(type == 'COEAPPROVEDLEAVE'){
							var start_date = "<?php echo date('m/d/Y', strtotime($result[0]['leave_from'])); ?>";
							var end_date = "<?php echo date('m/d/Y', strtotime($result[0]['leave_to'])); ?>";
							var return_date = "<?php echo date('m/d/Y', strtotime($result[0]['leave_return'])); ?>";
							var url_print = "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=coeprint&type=COEAPPROVEDLEAVE";
							var data_print = "id=" + id + "&status=" + status + "&start_date=" + start_date + "&end_date=" + end_date + "&return_date=" + return_date + "&send=" + false;
						}else{
							var url_print = "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=coeprint&type="+type;
							var data_print = "id=" + id + "&status=" + status + "&start_date=" + start_date + "&end_date=" + end_date + "&return_date=" + return_date + "&send=" + false;
						}

						if(status == 'For Release' || status == 'Done' || status == 'On Process' || status == 'For Approval'){

								$.ajax(
								{
									url: url_print,
									data: data_print,
									type: "POST",
									complete: function(){
										$("#loading").hide();
									},
									success: function(data) {
										$("#coedata").html(data);
									}
								});


						}
					});

				});
			</script>
			<?php
		break;

		case 'coesend':

		include(OBJ."/coe_pdf.php");

		break;

		case 'coeprint':

			$id = $_POST["id"];
			$type = $_GET["type"];
			if($_POST["send"] == "true"){
				$send_email = TRUE;
			}else{
				$send_email = FALSE;
			}

			$sql = "SELECT * FROM COERequests WHERE id = $id";

			$coe = $mainsql->get_row($sql);
			$emp_id = $coe[0]['emp_id'];

			$query = "SELECT top 1
						CASE
							WHEN A.GENDER = 'F' or A.GENDER = 'FEMALE' THEN 'MS.'
							WHEN A.GENDER = 'M' or A.GENDER = 'MALE' THEN 'MR.'
						END AS Salutation,
						CASE
							WHEN A.GENDER = 'F' or A.GENDER = 'FEMALE' THEN 'She'
							WHEN A.GENDER = 'M' or A.GENDER = 'MALE' THEN 'He'
						END AS Gender,
						CASE
							WHEN A.GENDER = 'F' or A.GENDER = 'FEMALE' THEN 'her'
							WHEN A.GENDER = 'M' or A.GENDER = 'MALE' THEN 'his'
						END AS Gender2,
						CASE
							WHEN A.GENDER = 'F' or A.GENDER = 'FEMALE' THEN 'her'
							WHEN A.GENDER = 'M' or A.GENDER = 'MALE' THEN 'him'
						END AS Gender3,
					A.FName+' '+
					 
					 CASE WHEN RTRIM(LTRIM(ISNULL(A.MNAME, ''))) <> ' ' 
						THEN SUBSTRING(A.MNAME, 1, 1) +  '. ' ELSE ' ' END +A.LName AS FullName,

                        A.FName,
                        A.MName,
                        A.LName,
                        A.BirthDate,
                        A.PhilHealthNbr,
                        F.PhilHealthNbr as CompPhilHealthNbr,
                        A.SSSNbr,
                        F.SSSNbr as CompSSSNbr,
                        A.PagibigNbr,
                        F.PagibigNbr as CompPagibigNbr,
						A.Allowance,
						A.MonthlyRate,
						A.RankID,
						B.RankDesc,
						C.DeptDesc,
						D.DivisionName,
						E.PositionDesc,
						A.HireDate as HireDate,
						getdate() as CurrentDate,
						DATEADD(DAY, -1, A.DateResigned) as DateResigned,
						A.CompanyID,
						F.CompanyName,
                        G.StatusDesc
						FROM
							viewhrempmaster A
						LEFT JOIN
							HRRank B on A.RankID = B.RankID
						LEFT JOIN
							HRDepartment C on A.DeptID = C.DeptID
						LEFT JOIN
							HRDivision D on A.DivisionID = D.DivisionID
						LEFT JOIN
							HRPosition E on A.PositionID = E.PositionID
						LEFT JOIN
							HRCompany F on A.CompanyID = F.CompanyID
                        LEFT JOIN 
                            HRStatus G ON A.EmpStatus = G.StatusID 
						WHERE
							A.EmpID = '$emp_id'";


			$emp_info = $mainsql->get_row($query);

            // if date of resignation is not yet in-effect, employee must be issued working up to present.
            if(!empty($emp_info[0]['DateResigned'])){
            if(date('Y-m-d', strtotime($emp_info[0]['DateResigned'])) > date('Y-m-d'))
                    $emp_info[0]['DateResigned'] = null;
            }

			$emp_info[0]['HireDate'] = $emp_info[0]['HireDate'] ?  date('F j, Y', strtotime($emp_info[0]['HireDate'])) : null;
			$emp_info[0]['CurrentDate'] = $emp_info[0]['CurrentDate'] ?  date('F j, Y', strtotime($emp_info[0]['CurrentDate'])) : null;
		    $DateResigned2 = $emp_info[0]['DateResigned'] ?  date('Y-m-d', strtotime($emp_info[0]['DateResigned'])) : null;
			$emp_info[0]['DateResigned'] = $emp_info[0]['DateResigned'] ?  date('F j, Y', strtotime($emp_info[0]['DateResigned'])) : null;

            if ($coe[0]["type"] == 'PHILHEALTHCSF' || $coe[0]["type"] == 'PHILHEALTHCF1'){
			    include(TEMP.'/philhealth_pdf.php');
			    ?>
			    <script>
			    	$(document).ready(function(){
			    		$(".closebutton").click();
			    		var divToPrint=document.getElementById("myDivToPrint2");
			    		newWin= window.open("");
			    		newWin.document.write(divToPrint.outerHTML);
			    		var is_chrome = Boolean(newWin.chrome);

    			    		if (is_chrome) {
			    			setTimeout(function() { // wait until all resources loaded
			    				newWin.print();
			    				newWin.close();
			    			}, 250);
			    		} else {
			    			newWin.print();
			    			newWin.close();
			    		}
			    	});
			    </script>
			    <?}
            elseif ($coe[0]["type"] == 'SSSCERT' || $coe[0]["type"] == 'PHILHEALTHCERT' || $coe[0]["type"] == 'PAGIBIGCERT'){
			    include(TEMP.'/certificates_pdf.php');
			    ?>
			    <script>
			    	$(document).ready(function(){
			    		$(".closebutton").click();
			    		var divToPrint=document.getElementById("myDivToPrint3");
			    		newWin= window.open("");
			    		newWin.document.write(divToPrint.outerHTML);
			    		var is_chrome = Boolean(newWin.chrome);

    			    		if (is_chrome) {
			    			setTimeout(function() { // wait until all resources loaded
			    				newWin.print();
			    				newWin.close();
			    			}, 250);
			    		} else {
			    			newWin.print();
			    			newWin.close();
			    		}
			    	});
			    </script>
			    <?}
            else {
                include(TEMP.'/coe_pdf.php');
                ?>
                <script>
                    $(document).ready(function(){
                        $(".closebutton").click();
                        var divToPrint=document.getElementById("myDivToPrint");
                        newWin= window.open("");
                        newWin.document.write(divToPrint.outerHTML);
                        var is_chrome = Boolean(newWin.chrome);    
                            if (is_chrome) {
                            setTimeout(function() { // wait until all resources loaded
                                newWin.print();
                                newWin.close();
                            }, 250);
                            } else {
                                newWin.print();
                                newWin.close();
                            }
                        });
                    </script>
                    <?}
                

		break;

		case 'coesave':

			$id = $_POST["id"];
			$coeemp = $_POST["emp_id"];
			$coe_company = $_POST["company_id"];
			$refno = $_POST["ref_no"];
			$coetype = $_POST["type"];
			$status = $_POST["status"];
			$old_status = $_POST["old_status"];
			$others = $_POST["others"];
			$datetoday = date('Y-m-d');
			$tasks = $_POST["coetasks"];
			$hpa_percent = $_POST["hpa_percent"];
			$avail_no = $_POST["avail_no"];
			$cancel_remarks = $_POST["cancel_remarks"] ? $_POST["cancel_remarks"] : null ;

			$tasks = json_encode($tasks);

			$coe_old = "SELECT * FROM COERequests WHERE id=$id";

			$coe_old = $mainsql->get_row($coe_old);


			$coetypes = [
				"2" => ["COECOMPENSATION"
				],
				"3" => ["COE","COEHOUSINGPLAN","COEJOBDESC","COEGOODMORAL","COEAPPROVEDLEAVE","COESEPARATED","COESEPARATEDCOMPLETE","COECORRECTIONNAME"
				]
			];

			if($status == "Cancelled"){
				$sql = "UPDATE
							COERequests
						SET
							status = '".$status."',
							updated_at = '".$datetoday."',
							updated_by = '".$profile_idnum."',
							cancelled_at = '".$datetoday."',
							cancelled_by = '".$profile_idnum."',
							cancel_remarks = '".$cancel_remarks."'
						WHERE
							id=$id";
			}else if($status == "Done"){
				$sql = "UPDATE
							COERequests
						SET
							status = '".$status."',
							other_reason = '".$others."',
							updated_at = '".$datetoday."',
							updated_by = '".$profile_idnum."',
							released_at = '".$datetoday."',
							released_by = '".$profile_idnum."',
							job_desc = '".$tasks."',
							hpa_percent = '".$hpa_percent."',
							avail_no = '".$avail_no."'
						WHERE
							id=$id";
			}else{
				$sql = "UPDATE
							COERequests
						SET
							status = '".$status."',
							other_reason = '". str_replace("'", "`", $others) ."',
							updated_at = '".$datetoday."',
							updated_by = '".$profile_idnum."',
							job_desc = '".str_replace("'", "`", $tasks)."',
							hpa_percent = '".$hpa_percent."',
							avail_no = '".$avail_no."'
						WHERE
							id=$id";
			}

			$coe_message = 'CoE has been saved!';
			if($coe_old[0]['status'] == 'For Approval' && $status != 'Cancelled'){

				$coe_message = 'CoE has been approved!';
				$status = 'For Release';

				$sql = "UPDATE
							COERequests
						SET
							status = '".$status."',
							updated_at = '".$datetoday."',
							updated_by = '".$profile_idnum."',
							approved = 1
						WHERE
							id=$id";

                // if COECOMPENSATION, send pdf after approval
                if($coe_old[0]['type'] == 'COECOMPENSATION'){
			        $result = $mainsql->get_execute($sql);
                    $_POST["send"] = "true";
                    include(OBJ."/coe_pdf.php");   
				    echo "<script>$('#coedata').html('COEC Has been sent to the employee!')</script>";

                }
			}

			$result = $mainsql->get_execute($sql);

			if($result){

				echo "<meta http-equiv='refresh' content='0'>";
				echo "<script>alert('$coe_message');</script>";

				$coe_query = "SELECT * FROM COERequests WHERE id=$id";

				$coe_result = $mainsql->get_row($coe_query);

				if($coe_old[0]['status'] == $status){
					return;
				}

				if($old_status != $status){
				if($status == 'On Process' || $status == 'For Approval' || $status == 'For Release' || $status == 'Cancelled' || $status == 'Done'){


					$emp_info = "SELECT * FROM viewHREmpMaster A
								left join HRCompany B on A.CompanyID = B.CompanyID
								left join HRDivision C on A.DivisionID = C.DivisionID WHERE A.EmpID='$coeemp' AND A.CompanyID ='$coe_company'";
					$emp_hr  = "SELECT B.EmailAdd, A.level FROM COEUsers A
								LEFT JOIN SUBSIDIARY.DBO.viewHREmpMaster B on A.emp_id = B.EmpID AND A.[DB_NAME] = B.DBNAME
								WHERE ";

					if($status == 'For Approval'){
						if(in_array($coetype, $coetypes["2"])){
							$emp_hr .="A.[level] = '5'";
						}else{
							$emp_hr .="A.[level] = '4'";
						}
					}else{
						if(in_array($coetype, $coetypes["2"])){
							$emp_hr .="A.[level] = '2'";
						}else{
							$emp_hr .="A.[level] = '3'";
						}
						$emp_hr .=" or A.[level] ='1'";
					}

					$emp_info = $mainsql->get_row($emp_info);
					$emp_hr = $mainsql->get_row($emp_hr);

					if($emp_hr[0]['level'] == 2){
						$title_notif = 'PR';
					}else{
						$title_notif = 'HR';
					}

					$hr_emails = array();

					foreach($emp_hr as $hr_id){
						array_push($hr_emails, $hr_id['EmailAdd']);
					}

					$message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 95%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>Certificate of Employment Request</span><br><br>Hi ".$emp_info[0]['NickName'].",<br><br>";

					if($status == 'For Release'){
						$message .= "Your Certificate of Employment ($coetype) with a Reference No: ".$refno." was sent to your ";
					    
                        if(!$emp_info[0]['Active']){
                            $message .= "Personal Email Address.";
                        }else{
                            $message .= "Corporate Email Address.";
                        }
						if($emp_hr[0]['level'] != 2){
							$message .= " Should you need a copy with the original signature, please coordinate with your HR Business Partner.";
						}
					}else if ($status == 'Cancelled'){
						if($profile_idnum == $coeemp){
							$cancelled_by_email = 'You';
						}else{
							$cancelled_by_email = 'the CoE Admins';
						}
						$message .= "Your Certificate of Employment ($coetype) with a Reference No. ".$refno." has been Cancelled by $cancelled_by_email at ".date('F j, Y', strtotime($coe_result[0]['created_at']))." with remarks: ".$cancel_remarks;
					}else if ($status == 'On Process'){
						$message .= "Your Certificate of Employment ($coetype) with a Reference No. ".$refno." is now On Process (".date('F j, Y', strtotime($coe_result[0]['updated_at'])).").";
					}else if ($status == 'For Approval'){
						$message .= "Your Certificate of Employment ($coetype) with a Reference No. ".$refno." is now For Approval (".date('F j, Y', strtotime($coe_result[0]['updated_at'])).").";
					}else if ($status == 'Done'){
						$message .= "Your Certificate of Employment ($coetype) with a Reference No. ".$refno." has been Done/Claimed at ".date('F j, Y', strtotime($coe_result[0]['updated_at'])).".";
					}
					$message .= "<br><br>Thanks,<br>";
					$message .= SITENAME." Admin";
					$message .= "<br>Click<a href='https://portal.megaworldcorp.com/me/login'> here</a> to login";
					$message .= "<hr />".MAILFOOT."</div>";

					$headers = "From: ".NOTIFICATION_EMAIL."\r\n";
					$headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

					$coe_emp_email = $emp_info[0]['EmailAdd'];

					if(!$emp_info[0]['Active']){
						$coe_emp_email = $emp_info[0]['EmailAdd2'];
					}

					$emp_sendmail = mail($coe_emp_email, "COE Request Update", $message, $headers);

					// SEND NOTIF TO ADMINS IF THE COE IS DONE/CANCELLED AND TO THE APPROVERS IF FOR APPROVAL
					if($status == 'Cancelled' || $status == 'Done' || ($status == 'For Release' && $coe_old[0]['status'] == 'For Approval')){

						$message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 95%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>Certificate of Employment Request</span><br><br>";

						if($status == 'Cancelled'){// gohere
							if($profile_idnum == $coeemp){
								$cancelled_by_email = 'the Employee';
							}else{
								$cancelled_by_email = 'the CoE Admins';
							}
							$message .= "The Requested Certificate of Employment ($coetype) for ".$emp_info[0]['FullName']."(".$emp_info[0]['CompanyName'].") - (".$emp_info[0]['DivisionName'].") with a Reference No. ".$refno." has been Cancelled by $cancelled_by_email at ".date('F j, Y', strtotime($coe_result[0]['created_at']))." with remarks: ".$cancel_remarks;
						}else if ($status == 'For Release' && $coe_old[0]['status'] == 'For Approval'){
							$message .= "The Requested Certificate of Employment ($coetype) for ".$emp_info[0]['FullName']."(".$emp_info[0]['CompanyName'].") - (".$emp_info[0]['DivisionName'].") with a Reference No. ".$refno." has been Approved at ".date('F j, Y', strtotime($coe_result[0]['updated_at'])).".";
						}else if ($status == 'Done'){
							$message .= "The Requested Certificate of Employment ($coetype) for ".$emp_info[0]['FullName']."(".$emp_info[0]['CompanyName'].") - (".$emp_info[0]['DivisionName'].") with a Reference No. ".$refno." has been Done/Claimed at ".date('F j, Y', strtotime($coe_result[0]['updated_at'])).".";
						}

						$message .= "<br><br>Thanks,<br>";
						$message .= SITENAME." Admin";
						$message .= "<br>Click<a href='https://portal.megaworldcorp.com/me/login'> here</a> to login";
						$message .= "<hr />".MAILFOOT."</div>";

						$headers = "From: ".NOTIFICATION_EMAIL."\r\n";
						$headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

						$sendmail = mail(implode(',', $hr_emails), "COE Request Update ($title_notif Notification)", $message, $headers);
						// $sendmail = mail('shart.global@megaworldcorp.com', "COE Request Update ($title_notif Notification)", $message, $headers);

					}elseif ($status == 'For Approval') {
						$message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 95%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>Certificate of Employment Request for Approval</span><br><br>";
						$message .= "The Requested Certificate of Employment ($coetype) for ".$emp_info[0]['FullName']."(".$emp_info[0]['CompanyName'].") - (".$emp_info[0]['DivisionName'].") with a Reference No. ".$refno." is now for your approval.";

						$message .= "<br><br>Thanks,<br>";
						$message .= SITENAME." Admin";
						$message .= "<br>Click<a href='https://portal.megaworldcorp.com/me/login'> here</a> to login";
						$message .= "<hr />".MAILFOOT."</div>";

						$headers = "From: ".NOTIFICATION_EMAIL."\r\n";
						$headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

						if($coetype != 'COECOMPENSATION'){
							if ($coe_old[0]["company"] == 'GLOBAL01' || $coe_old[0]["company"] == 'LGMI01' ) {
								// Ma'am Joy Notification
								$approver_email = 'jfalim@globalcompanies.com.ph';
								// $approver_email = 'shart.global@megaworldcorp.com';  
							}elseif ($coe_old[0]["company"] == 'MCTI') {
								// Sir Joey Notification
								// $approver_email = 'jvillafuerte@megaworldcorp.com';
							}else{
								// Sir Raffy Notification
								// $approver_email = 'rperez@megaworldcorp.com';
							}
							array_push($hr_emails, $approver_email);
							// $sendmail = mail($approver_email, "COE Request for Approval", $message, $headers);
							$sendmail = mail(implode(',', $hr_emails), "COE Request Update (Approvers Notification)", $message, $headers);
						}else{
							// INSERT COMPENSATION APPROVERS HERE

                            //R&F to Supervisor
                            $rfs = array(
                                'RF','RF II','SRF','SRF II','AS','AS II','AS III','S','S II','S III',
                                'SS','SS II','SS III',
                                'RF','R001','R002','R003','R004','S005','S006','S007','S008','S','SS',
                                
                            );
                            $man = array('AM','AM II','AM III','MGR-A','M','M II','M III',
                                        'SM','SM II','SM III', //end of megaworld ranks);
                                        'M009','M010','M011','M012','M','M-TTTI','SM','SM - TTTI','D013','D014',
                                        ); // end of GL RANKS
                            
                            $avp = array('AVP','AVP-TTTI', 'SAVP');
                            //vp & up - Ms. Lourdes
                            $vpup = array(
                                'FVP', //end of GL RANKS
                                'VP', 'EVP','SEVP','SVP','FVP','COO','D015','D016' // end of MEGA RANKS
                            );

                            $COEC_APPROVERS = [
                                "GLOBAL01" => [
                                    'prepared' => [
                                        'name' => 'SULAT, CLARA NUÑEZ',
                                        'id' => '2021-02-0013',
                                        'designation' => 'PAYROLL ASSOCIATE',
                                        'esign' => 'coe_csulat.png',
                                        'email' => 'cnsulat.global@megaworldcorp.com'
                                    ],
                                    'approver' => [
                                        'RFSP' => [
                                            'name' => 'BRANCO, ARLENE AYSON',
                                            'id' => '2014-10-0004',
                                            'designation' => 'Payroll Manager',
                                            'esign' => 'coe_abranco.png',
                                            'email' => 'abranco@megaworldcorp.com'
                                        ],
                                        'M' => [
                                            'name' => 'BRANCO, ARLENE AYSON',
                                            'id' => '2014-10-0004',
                                            'designation' => 'Payroll Manager',
                                            'esign' => 'coe_abranco.png',
                                            'email' => 'abranco@megaworldcorp.com'
                                        ],
                                        'AVP'=>[
                                            'name' => 'BRANCO, ARLENE AYSON',
                                            'id' => '2014-10-0004',
                                            'designation' => 'Payroll Manager',
                                            'esign' => 'coe_abranco.png',
                                            'email' => 'abranco@megaworldcorp.com'
                                        ],
                                        'VP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                    ]
                                
                                    ],
                                
                                "LGMI01" => [
                                    'prepared' => [
                                        'name' => 'ESLIT, IRENE SUBONG',
                                        'id' => '2021-06-0163',
                                        'designation' => 'Payroll Analyst',
                                        'esign' => 'coe_ieslit.png',
                                        'email' => 'ieslit.global@megaworldcorp.com'
                                    ],
                                    'approver' => [
                                        'RFSP' => [
                                            'name' => 'BRANCO, ARLENE AYSON',
                                            'id' => '2014-10-0004',
                                            'designation' => 'Payroll Manager',
                                            'esign' => 'coe_abranco.png',
                                            'email' => 'abranco@megaworldcorp.com'
                                        ],
                                        'M' => [
                                            'name' => 'BRANCO, ARLENE AYSON',
                                            'id' => '2014-10-0004',
                                            'designation' => 'Payroll Manager',
                                            'esign' => 'coe_abranco.png',
                                            'email' => 'abranco@megaworldcorp.com'
                                        ],
                                        'AVP'=>[
                                            'name' => 'BRANCO, ARLENE AYSON',
                                            'id' => '2014-10-0004',
                                            'designation' => 'Payroll Manager',
                                            'esign' => 'coe_abranco.png',
                                            'email' => 'abranco@megaworldcorp.com'
                                        ],
                                        'VP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                    ]
                                
                                    ],
                
                                "GLOBALHOTEL" => [
                                    'prepared' => [
                                        'name' => 'ESLIT, IRENE SUBONG',
                                        'id' => '2021-06-0163',
                                        'designation' => 'Payroll Analyst',
                                        'esign' => 'coe_ieslit.png',
                                        'email' => 'ieslit.global@megaworldcorp.com'
                                    ],
                                    'approver' => [
                                        'RFSP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'M' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'AVP'=>[
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'VP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                    ]
                                
                                    ],
                
                                "ECOC01" => [
                                    'prepared' => [
                                        'name' => 'TERMULO, MA. VERONICA SALUTA',
                                        'id' => '2011-03-V837',
                                        'designation' => 'Payroll Supervisor', 
                                        'esign' => 'coe_mtermulo.png',
                                        'email' => 'vtermulo@megaworldcorp.com'
                                    ],
                                    'approver' => [
                                        'RFSP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'M' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'AVP'=>[
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'VP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                    ]
                                
                                    ],
                                    
                                "MLI01" => [
                                    'prepared' => [
                                        'name' => 'TERMULO, MA. VERONICA SALUTA',
                                        'id' => '2011-03-V837',
                                            'designation' => 'Payroll Supervisor', 
                                            'esign' => 'coe_mtermulo.png',
                                            'email' => 'vtermulo@megaworldcorp.com'
                                    ],
                                    'approver' => [
                                        'RFSP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'M' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'AVP'=>[
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'VP' => [
                                            'name' => 'RAMILO, LOURDES ONG',
                                            'id' => '1997-03-8638',
                                            'designation' => 'Vice President',
                                            'esign' => 'coe_lramilo.png',
                                            'email' => 'dramilo@megaworldcorp.com'
                                        ],
                                    ]
                                
                                    ], 
                                "MREIT_FMI" => [
                                    'prepared' => [
                                        'name' => 'TERMULO, MA. VERONICA SALUTA',
                                        'id' => '2011-03-V837',
                                        'designation' => 'Payroll Supervisor', 
                                        'esign' => 'coe_mtermulo.png',
                                        'email' => 'vtermulo@megaworldcorp.com'
                                    ],
                                    'approver' => [
                                        'RFSP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'M' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'AVP'=>[
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'VP' => [
                                            'name' => 'RAMILO, LOURDES ONG',
                                            'id' => '1997-03-8638',
                                            'designation' => 'Vice President',
                                            'esign' => 'coe_lramilo.png',
                                            'email' => 'dramilo@megaworldcorp.com'
                                        ],
                                    ]
                                
                                    ],
                
                                "MREIT_INC" => [
                                    'prepared' => [
                                        'name' => 'TERMULO, MA. VERONICA SALUTA',
                                        'id' => '2011-03-V837',
                                        'designation' => 'Payroll Supervisor', 
                                        'esign' => 'coe_mtermulo.png',
                                        'email' => 'vtermulo@megaworldcorp.com'
                                    ],
                                    'approver' => [
                                        'RFSP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'M' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'AVP'=>[
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'VP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                    ]
                                
                                    ],
                
                                "MREIT_PMI" => [
                                    'prepared' => [
                                        'name' => 'TERMULO, MA. VERONICA SALUTA',
                                        'id' => '2011-03-V837',
                                        'designation' => 'Payroll Supervisor', 
                                        'esign' => 'coe_mtermulo.png',
                                        'email' => 'vtermulo@megaworldcorp.com'
                                    ],
                                    'approver' => [
                                        'RFSP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'M' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'AVP'=>[
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'VP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                    ]
                                
                                    ],
                
                                "Rowenta" => [
                                    'prepared' => [
                                        'name' => 'TERMULO, MA. VERONICA SALUTA',
                                        'id' => '2011-03-V837',
                                        'designation' => 'Payroll Supervisor', 
                                        'esign' => 'coe_mtermulo.png',
                                        'email' => 'vtermulo@megaworldcorp.com'
                                    ],
                                    'approver' => [
                                        'RFSP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'M' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'AVP'=>[
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'VP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                    ]
                                
                                    ],
                                    
                                "LUCK01" => [
                                    'prepared' => [
                                        'name' => 'TERMULO, MA. VERONICA SALUTA',
                                        'id' => '2011-03-V837',
                                        'designation' => 'Payroll Supervisor', 
                                            'esign' => 'coe_mtermulo.png',
                                            'email' => 'vtermulo@megaworldcorp.com'
                                    ],
                                    'approver' => [
                                        'RFSP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'M' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'AVP'=>[
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'VP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                    ]
                                
                                    ],
                
                                "SIRUS" => [
                                    'prepared' => [
                                        'name' => 'TERMULO, MA. VERONICA SALUTA',
                                        'id' => '2011-03-V837',
                                        'designation' => 'Payroll Supervisor', 
                                            'esign' => 'coe_mtermulo.png',
                                            'email' => 'vtermulo@megaworldcorp.com'
                                    ],
                                    'approver' => [
                                        'RFSP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'M' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'AVP'=>[
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'VP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                    ]
                                
                                    ],
                
                                "ERA01" => [
                                    'prepared' => [
                                        'name' => 'TERMULO, MA. VERONICA SALUTA',
                                        'id' => '2011-03-V837',
                                        'designation' => 'Payroll Supervisor', 
                                            'esign' => 'coe_mtermulo.png',
                                            'email' => 'vtermulo@megaworldcorp.com'
                                    ],
                                    'approver' => [
                                        'RFSP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'M' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'AVP'=>[
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'VP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                    ]
                                
                                    ],
                
                                "ECC02" => [
                                    'prepared' => [
                                        'name' => 'TERMULO, MA. VERONICA SALUTA',
                                        'id' => '2011-03-V837',
                                        'designation' => 'Payroll Supervisor', 
                                            'esign' => 'coe_mtermulo.png',
                                            'email' => 'vtermulo@megaworldcorp.com'
                                    ],
                                    'approver' => [
                                        'RFSP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'M' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'AVP'=>[
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'VP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                    ]
                                
                                    ],
                
                                "CITYLINK01" => [
                                    'prepared' => [
                                        'name' => 'TERMULO, MA. VERONICA SALUTA',
                                        'id' => '2011-03-V837',
                                        'designation' => 'Payroll Supervisor', 
                                            'esign' => 'coe_mtermulo.png',
                                            'email' => 'vtermulo@megaworldcorp.com'
                                    ],
                                    'approver' => [
                                        'RFSP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'M' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'AVP'=>[
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'VP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                    ]
                                
                                    ],
                
                                "NCCAI" => [
                                    'prepared' => [
                                        'name' => 'TERMULO, MA. VERONICA SALUTA',
                                        'id' => '2011-03-V837',
                                        'designation' => 'Payroll Supervisor', 
                                            'esign' => 'coe_mtermulo.png',
                                            'email' => 'vtermulo@megaworldcorp.com'
                                    ],
                                    'approver' => [
                                        'RFSP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'M' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'AVP'=>[
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'VP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                    ]
                                
                                    ],
                
                                "MEGA01" => [
                                    'prepared' => [
                                        'name' => 'ANASTACIO, MAE HAZEL BALAGOSA',
                                        'id' => '2015-11-0550',
                                        'designation' => 'Senior Payroll Associate',
                                            'esign' => 'coe_manastacio.png',
                                            'email' => 'manastacio.global@megaworldcorp.com'
                                    ],
                                    'approver' => [
                                        'RFSP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'M' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'AVP'=>[
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'VP' => [
                                            'name' => 'RAMILO, LOURDES ONG',
                                            'id' => '1997-03-8638',
                                            'designation' => 'Vice President',
                                            'esign' => 'coe_lramilo.png',
                                            'email' => 'dramilo@megaworldcorp.com'
                                        ],
                                    ]
                                
                                    ],
                
                                "TOWN01" => [
                                    'prepared' => [
                                        'name' => 'ANASTACIO, MAE HAZEL BALAGOSA',
                                        'id' => '2015-11-0550',
                                        'designation' => 'Senior Payroll Associate',
                                            'esign' => 'abranco.png',
                                            'email' => 'manastacio.global@megaworldcorp.com'
                                    ],
                                    'approver' => [
                                        'RFSP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'M' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'AVP'=>[
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'VP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                    ]
                                
                                    ],
                
                                "LFI01" => [
                                    'prepared' => [
                                        'name' => 'ANASTACIO, MAE HAZEL BALAGOSA',
                                        'id' => '2015-11-0550',
                                        'designation' => 'Senior Payroll Associate',
                                            'esign' => 'abranco.png',
                                            'email' => 'manastacio.global@megaworldcorp.com'
                                    ],
                                    'approver' => [
                                        'RFSP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'M' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'AVP'=>[
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'VP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                    ]
                                
                                    ],
                
                                "NEWTOWN01" => [
                                    'prepared' => [
                                        'name' => 'ANASTACIO, MAE HAZEL BALAGOSA',
                                        'id' => '2015-11-0550',
                                        'designation' => 'Senior Payroll Associate',
                                            'esign' => 'abranco.png',
                                            'email' => 'manastacio.global@megaworldcorp.com'
                                    ],
                                    'approver' => [
                                        'RFSP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'M' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'AVP'=>[
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'VP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                    ]
                                
                                    ],
                
                                "ASIAAPMI" => [
                                    'prepared' => [
                                        'name' => 'JERIZA MAE V. SIOCO',
                                        'id' => '2020-09-0022',
                                        'designation' => 'Payroll Manager',
                                        'esign' => 'coe_jsioco.png',
                                        'email' => 'jsioco@asia-affinity.com'
                                    ],
                                    'approver' => [
                                        'RFSP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'M' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'AVP'=>[
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                        'VP' => [
                                            'name' => 'GUARINA, MARILOU CABUHAT',
                                            'id' => '1994-03-8275',
                                            'designation' => 'Senior Assistant Vice President',
                                            'esign' => 'coe_mguarina.png',
                                            'email' => 'mguarina@megaworldcorp.com'
                                        ],
                                    ]
                                
                                ]
                            ];

                            $rank_approver = '';
                            if(in_array($emp_info[0]['RankID'], $rfs))
								$rank_approver = 'RFSP';
							elseif(in_array($emp_info[0]['RankID'], $man))
								$rank_approver = 'M';
							elseif(in_array($emp_info[0]['RankID'], $avp))
								$rank_approver = 'AVP';
							elseif(in_array($emp_info[0]['RankID'], $vpup))
								$rank_approver = 'VP';

							$approver_email = $COEC_APPROVERS[$emp_info[0]['CompanyID']]['approver'][$rank_approver]['email']; 
							
                            array_push($hr_emails, $approver_email);
                            if($emp_info[0]['CompanyID'] != 'ASIAAPMI'){
							    array_push($hr_emails, 'abranco@megaworldcorp.com');
							    array_push($hr_emails, 'mguarina@megaworldcorp.com');
                            }
							$sendmail = mail(implode(',', $hr_emails), "COE Request Update (Approvers Notification)", $message, $headers); 

						}

					}

				}
				}


			}else{
				?><h5 align="center">Error in Saving Certificate of Employment!</h5><?php
			}

		break;
		//coeend
		//coeend
        case 'datapend':

            $doctype = $_POST['doctype'];
            $refnum = $_POST['refnum'];
            $dbname = $_POST['dbname'];

            $notification_data = $mainsql->get_notification($refnum, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, $dbname);
            $attachment_data = $mainsql->get_attachments($refnum, 0, $dbname);

            //var_dump($notification_data[0]['DB_NAME02']);

            $approver_data1 = $logsql->get_allmember($notification_data[0]['Signatory01'], $notification_data[0]['DB_NAME01']);
            $approver_data2 = $logsql->get_allmember($notification_data[0]['Signatory02'], $notification_data[0]['DB_NAME02']);
            $approver_data3 = $logsql->get_allmember($notification_data[0]['Signatory03'], $notification_data[0]['DB_NAME03']);
            $approver_data4 = $logsql->get_allmember($notification_data[0]['Signatory04'], $notification_data[0]['DB_NAME04']);
            $approver_data5 = $logsql->get_allmember($notification_data[0]['Signatory05'], $notification_data[0]['DB_NAME05']);
            $approver_data6 = $logsql->get_allmember($notification_data[0]['Signatory06'], $notification_data[0]['DB_NAME06']);

            $defdbname01 = $notification_data[0]['DB_NAME01'] ? $notification_data[0]['DB_NAME01'] : 'MEGAWORLD';
            $defdbname02 = $notification_data[0]['DB_NAME02'] ? $notification_data[0]['DB_NAME02'] : 'MEGAWORLD';
            $defdbname03 = $notification_data[0]['DB_NAME03'] ? $notification_data[0]['DB_NAME03'] : 'MEGAWORLD';
            $defdbname04 = $notification_data[0]['DB_NAME04'] ? $notification_data[0]['DB_NAME04'] : 'MEGAWORLD';
            $defdbname05 = $notification_data[0]['DB_NAME05'] ? $notification_data[0]['DB_NAME05'] : 'MEGAWORLD';
            $defdbname06 = $notification_data[0]['DB_NAME06'] ? $notification_data[0]['DB_NAME06'] : 'MEGAWORLD';

            $requestor_data = $logsql->get_allmember($notification_data[0]['EmpID'], $dbname);
            $requestor_data = $logsql->get_allmember($notification_data[0]['EmpID'], $dbname);

            $chkexpire = 0;

            //READ STATUS
            $get_read = $mainsql->get_read($profile_idnum, $refnum, 1);
            if ($get_read) :
                $delete_read = $mainsql->delete_read($profile_idnum, $refnum);
            endif;
            ?>

            <table class="tdataform2 rightmargin margintop10 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">

            <?php
            //var_dump($notification_data);
            //if ($notification_data[0]['EmpID'] != $profile_idnum) :
                ?>

                    <tr>
                        <td width="25%"><b>Requested by</b></td>
                        <td width="25%"><?php echo $requestor_data[0]['FName'].' '.$requestor_data[0]['LName'].' ('.$notification_data[0]['EmpID'].')'; ?>
                            <input type="hidden" id="dbname" name="dbname" value="<?php echo $dbname ?>" />
                        </td>
                    </tr>

                <?php
            //endif;

            if ($doctype == 'OT') :
                $application_data = $tblsql->get_nrequest(1, $refnum);

                $chkexpire = $mainsql->check_appexpire($application_data[0]['DtrDate']);

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.($dbname == 'MARKETING' ? 'https://www.marketingsalesagents.com' : WEB).'/uploads/ot/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['ReqDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>DTR Date</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['DtrDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>From</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['FromDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>To</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['ToDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>OT Type</b></td>
                        <td><?php echo $application_data[0]['OTType']; ?></td>
                    </tr>
                    <tr>
                        <td><b>Applied Hours</b></td>
                        <td><?php echo $application_data[0]['Hrs']; ?></td>
                    </tr>
                    <?php if ($notification_data[0]['Approved'] == 1) : ?>
                    <tr>
                        <td><b>Approved Hours</b></td>
                        <td>
                            <?php echo $application_data[0]['ApprovedHrs'] ? $application_data[0]['ApprovedHrs'] : 0; ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td><b>Reason</b></td>
                        <td><?php echo stripslashes($application_data[0]['Reason']); ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['DtrDate']);
                $pdtrto = strtotime($application_data[0]['DtrDate']);

            elseif ($doctype == 'LV') :
                $application_data = $tblsql->get_nrequest(2, $refnum);
                //$appleave_data = $tblsql->get_leavedata($refnum);
                //var_dump($application_data);

                $chkexpire = $mainsql->check_appexpire($application_data[0]['AbsenceFromDate'], $application_data[0]['AbsenceToDate']);

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.($dbname == 'MARKETING' ? 'https://www.marketingsalesagents.com' : WEB).'/uploads/leave/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($notification_data[0]['DateFiled'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Coverage</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['AbsenceFromDate'])); ?> - <?php echo date('F j, Y', strtotime($application_data[0]['AbsenceToDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Type</b></td>
                        <td><?php echo $application_data[0]['LeaveDesc']; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="divlvdata width100per notidatadiv">
                            <table class="tdatablk width100per">
                                <tr>
                                    <th>Date</th>
                                    <th>Duration</th>
                                    <th>w/ Pay</th>
                                    <th>Cancel</th>
                                </tr>
                                <?php
                                    $applv_data = $tblsql->get_leavedata($refnum);
                                    $applv_count = count($applv_data);
                                    foreach($applv_data as $key => $value) :
                                ?>
                                <tr>
                                    <td><?php echo date("M j", strtotime($value['LeaveDate'])); ?></td>
                                    <td><?php
                                        if ($value['Duration'] >= 8) :
                                            echo number_format($value['Duration'], 1)." hours";
                                        else :
                                            echo number_format($value['Duration'], 1)." hours";
                                        endif;
                                        /*if ($value['Duration'] >= "WD") :
                                            echo "Whole Day";
                                        elseif ($value['Duration'] == "HD") :
                                            echo "Half Day";
                                        elseif ($value['Duration'] == "HD1") :
                                            echo "Half Day AM";
                                        elseif ($value['Duration'] == "HD2") :
                                            echo "Half Day PM";
                                        endif;*/
                                    ?></td>
                                    <td class="centertalign">
                                        <?php echo $value['WithPay'] ? "<i class='fa fa-check'></i>" : "<i class='fa fa-times'></i>"; ?>
                                    </td>
                                    <td class="centertalign"><?php if ($applv_count > 1) : ?><i class="btnlvcancel fa fa-times redtext cursorpoint" attribute="<?php echo $refnum; ?>" attribute2="<?php echo date('Y-m-d 00:00:00.000', strtotime($value['LeaveDate'])); ?>"></i><?php endif; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Reason</b></td>
                        <td><?php echo stripslashes($application_data[0]['Reason']); ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['AbsenceFromDate']);
                $pdtrto = strtotime($application_data[0]['AbsenceToDate']);

            elseif ($doctype == 'MA') :
                $application_data = $tblsql->get_nrequest(3, $refnum);

                $chkexpire = $mainsql->check_appexpire($application_data[0]['DateFrom'], $application_data[0]['DateTo']);

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.($dbname == 'MARKETING' ? 'https://www.marketingsalesagents.com' : WEB).'/uploads/ma/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['ReqDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>From</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['DateFrom'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>To</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['DateTo'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Type</b></td>
                        <td><?php echo $application_data[0]['TypeAvail']; ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['DateFrom']);
                $pdtrto = strtotime($application_data[0]['DateTo']);

            elseif ($doctype == 'OB') :
                $application_data = $tblsql->get_nrequest(4, $refnum);
                $appobt_data = $tblsql->get_obtdata($refnum);

                $chkexpire = $mainsql->check_appexpire($application_data[0]['OBTimeINDate'], $application_data[0]['OBTimeOutDate']);

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.($dbname == 'MARKETING' ? 'https://www.marketingsalesagents.com' : WEB).'/uploads/ob/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <?php if ($notification_data[0]['EmpID'] == $profile_idnum && $notification_data[0]['Approved'] != 3 && $notification_data[0]['Approved'] != 2) : ?>
                    <tr>
                        <td width="25%">&nbsp;</td>
                        <td width="75%"><a href="<?php echo WEB; ?>/obtpdf?id=<?php echo $refnum; ?>&db=<?php echo $dbname; ?>" target="_blank"><button class="btn">Print OBT Form</button></a></td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['DateFiled'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>From</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['OBTimeINDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>To</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['OBTimeOutDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Destination</b></td>
                        <td><?php echo $application_data[0]['Destination']; ?></td>
                    </tr>
                    <tr>
                        <td><b>Purpose</b></td>
                        <td><?php echo stripslashes($application_data[0]['Reason']); ?></td>
                    </tr>
                    <tr>
                        <td><b>OBT Time Entry</b></td>
                        <td>
                            <div class="divobdata width100per notidatadiv">
                            <table class="tdatablk">
                                <tr>
                                    <th>In</th>
                                    <th>Out</th>
                                    <th>Cancel</th>
                                </tr>
                                <?php $appobt_count = count($appobt_data); ?>
                                <?php foreach($appobt_data as $key => $value) : ?>
                                <tr>
                                    <td><?php echo date("M j, Y g:ia", strtotime($value['ObTimeInDate'])); ?></td>
                                    <td><?php echo date("M j, Y g:ia", strtotime($value['ObTimeOutDate'])); ?></td>
                                    <td class="centertalign"><?php if ($appobt_count > 1) : ?><i class="btnobcancel fa fa-times redtext cursorpoint" attribute="<?php echo $refnum; ?>" attribute2="<?php echo date('Y-m-d', strtotime($value['ObTimeInDate'])); ?>" attribute3="<?php echo $value['SeqID']; ?>"></i><?php endif; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                            </div>
                        </td>
                    </tr>
                     <tr>
                        <td><b>Biometric Time Entry</b></td>
                        <td>
                            <div class="width100per notidatadiv">
                            <table class="tdatablk">
                                <tr>
                                    <th>In</th>
                                    <th>Out</th>
                                </tr>
                                <?php foreach($appobt_data as $key => $value) : ?>
                                <tr>
                                    <td><?php if(!empty($value['ActualTimeInDate'])) echo date("M j, Y g:ia", strtotime($value['ActualTimeInDate'])); else echo 'No Biometric Entry'; ?></td>
                                    <td><?php if(!empty($value['ActualTimeOutDate'])) echo date("M j, Y g:ia", strtotime($value['ActualTimeOutDate'])); else echo 'No Biometric Entry'; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Days</b></td>
                        <td><?php echo $application_data[0]['Days']; ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['OBTimeINDate']);
                $pdtrto = strtotime($application_data[0]['OBTimeINDate']);

            elseif ($doctype == 'NP') :
                $application_data = $tblsql->get_nrequest(6, $refnum);
                
                $chkexpire = $mainsql->check_appexpire($application_data[0]['DateCovered']);

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.($dbname == 'MARKETING' ? 'https://www.marketingsalesagents.com' : WEB).'/uploads/np/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($notification_data[0]['DateFiled'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Date Coverage</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['DateCovered'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Time IN</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['DateTimeIN'])); ?><br><?php echo date('g:ia', strtotime($application_data[0]['TimeIn'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Time OUT</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['DateTimeOUT'])); ?><br><?php echo date('g:ia', strtotime($application_data[0]['TimeOut'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Reason</b></td>
                        <td><?php echo stripslashes($application_data[0]['Reason']); ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['DateCovered']);
                $pdtrto = strtotime($application_data[0]['DateCovered']);
            
            elseif ($doctype == 'WC') :
                    $application_data = $tblsql->get_nrequest(11, $refnum);
                    // $chkexpire = $mainsql->check_appexpire($application_data[0]['DTRFrom']);
                    $chkexpire = 0;
                    ?>
                        <?php if ($attachment_data) : ?>
                        <tr>
                            <td width="25%"><b>Attachment/s</b></td>
                            <td width="75%"><?php
                                foreach ($attachment_data as $key => $value) :
                                    echo '<a href="'.($dbname == 'MARKETING' ? 'https://www.marketingsalesagents.com' : WEB).'/uploads/wc/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                                endforeach;
                            ?>
                            </td>
                        </tr>
                        <?php endif; ?>
    
                        <tr>
                            <td width="25%"><b>Status</b></td>
                            <td width="75%"><?php
                                if ($notification_data[0]['Approved'] == 2) :
                                    echo "<span class='redtext'>REJECTED</span>";
                                elseif ($notification_data[0]['Approved'] == 1) :
                                    echo "<span class='greentext'>APPROVED</span>";
                                elseif ($notification_data[0]['Approved'] == 3) :
                                    echo "<span class='redtext'>CANCELLED</span>";
                                else :
                                    echo "FOR APPROVAL";
                                endif;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Clearance Type</b></td>
                            <td><?php echo $application_data[0]['ClearanceType']; ?></td>
                        </tr>
                        <tr>
                            <td><b>Date Applied</b></td>
                            <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['AppliedDate'])); ?></td>
                        </tr>
                        <tr>
                            <td><b>DTR From</b></td>
                            <td><?php echo date('F j, Y', strtotime($application_data[0]['DTRFrom'])); ?></td>
                        </tr>
                        <tr>
                            <td><b>DTR To</b></td>
                            <td><?php echo date('F j, Y', strtotime($application_data[0]['DTRTo'])); ?></td>
                        </tr>
                        <tr>
                            <td><b>Reason</b></td>
                            <td><?php echo stripslashes($application_data[0]['Reason']); ?></td>
                        </tr>
    
                    <?php
                    $pdtrfrom = strtotime($application_data[0]['DTRFrom']);
                    $pdtrto = strtotime($application_data[0]['DTRTo']);
    
			elseif ($doctype == 'WH') : //WFH HERE
				$application_data = $tblsql->get_mrequest(10, $refnum);

				?>

				<tr>
					<td width="25%"><b>Status</b></td>
					<td width="75%"><?php
						if ($notification_data[0]['Approved'] == 2) :
							echo "<span class='redtext'>REJECTED</span>";
						elseif ($notification_data[0]['Approved'] == 1) :
							echo "<span class='greentext'>APPROVED</span>";
						elseif ($notification_data[0]['Approved'] == 3) :
							echo "<span class='redtext'>CANCELLED</span>";
						else :
							echo "FOR APPROVAL";
						endif;
						?>
					</td>
				</tr>
				<tr>
					<td><b>Date Applied</b></td>
					<td><?php echo date('F j, Y g:ia', strtotime($application_data[0]['AppliedDate'])); ?></td>
				</tr>

				<tr>
					<td colspan="2">
					<div class="divmddata width100per notidatadiv">
						<table class="tdatablk">
							<?php $appwh_data = $tblsql->get_whdata($refnum); ?>
							<tr>
								<th width="70px" style="text-align:left">DTR Date</th>
								<th width="50px" style="text-align:left">Applied Hrs</th>
								<th width="50px" style="text-align:left">Approved Hrs</th>
								<th width="100%" style="text-align:left">Task/s</th>
								<th width="10px">x</th>
							</tr>
							<?php
								$appwh_count = count($appwh_data);
								$approvers = array($notification_data[0]['Signatory01'], $notification_data[0]['Signatory02'], $notification_data[0]['Signatory03'],
													$notification_data[0]['Signatory04'], $notification_data[0]['Signatory05'], $notification_data[0]['Signatory06']);
								foreach ($appwh_data as $key => $value) :

									$holiday = $mainsql->get_shiftdtr($profile_idnum, $value['DTRDate'], $profile_dbname);
									$wfday = date('w', strtotime($value['DTRDate']));
									?>
									<script>
									$(function() {

										$(".resetwfh").hide();

										$(".wfhcancel<?php echo $key; ?>").click(function() {
											arrayid = $(this).attr('attribute');
											$("#wfhApprovedHrs" + arrayid).val(0);

											$(".wfhwarning" + arrayid).attr("style", "display: none");

											$(".reset"+ arrayid).show();

										});

										$(".wfhwarn<?php echo $key; ?>").click(function(){
											arrayid = $(this).attr('attribute');
											approvehours = $(this).attr('attribute2');
											type = $(this).attr('attribute3');

											if(type == 1){
												$("#wfhApprovedHrs" + arrayid).val(approvehours);
											}

											$(".wfhwarning" + arrayid).attr("style", "display: none");
											$(".reset"+ arrayid).show();


										});

										$(".wfh8<?php echo $key; ?>").click(function(){
											arrayid = $(this).attr('attribute');

											$("#wfhApprovedHrs" + arrayid).val(8);

											$(".wfhwarning" + arrayid).attr("style", "display: none");
											$(".reset"+ arrayid).show();
										});

										$(".wfh6<?php echo $key; ?>").click(function(){
											arrayid = $(this).attr('attribute');
											applied = $(this).attr('attribute3');
											excess = $(this).attr('excess');

											$("#wfhApprovedHrs" + arrayid).val(applied - excess);


											$(".wfhwarning" + arrayid).attr("style", "display: none");
											$(".reset"+ arrayid).show();
										});

										$(".reset<?php echo $key; ?>").click(function(){
											arrayid = $(this).attr('attribute');

											$("#wfhApprovedHrs" + arrayid).val($("#wfhApprovedHrs" + arrayid).attr("attribute3"));
											$(".whwarning").attr("style", "color: red;");
											$(".reset"+arrayid).hide();
										});

									});
									</script>
									<tr>
										<td <?php if($key != 0){ ?>style="border-top: 1px solid #888"<?php } ?> class="centertalign"><p style="<?php if($holiday['SHIFT'] == 'HOLIDAY' || $wfday == 6 || $wfday == 0){ echo 'color: red;'; } ?>"><?php echo date('F j, Y', strtotime($value['DTRDate']));?></p></td>
										<td <?php if($key != 0){ ?>style="border-top: 1px solid #888"<?php } ?> class="centertalign"><?php echo $value['AppliedHrs']; ?></td>
										<td <?php if($key != 0){ ?>style="border-top: 1px solid #888"<?php } ?> class="centertalign">
											<?php if(in_array($profile_idnum, $approvers)){ ?>
												<input type="hidden" class="wfhseq" attribute="<?php echo $key; ?>" name="wfhSeq[<?php echo $key; ?>]" value="<?php echo $value['SeqID']; ?>">
												<input style="width: 50px;" value="<?php echo $value['ApprovedHrs']; ?>" step=".25" id="wfhApprovedHrs<?php echo $key; ?>" type="number" name="wfhApprovedHrs[<?php echo $key; ?>]" attribute="<?php echo $key; ?>" attribute2="<?php echo $value['AppliedHrs']; ?>" attribute3="<?php echo $value['ApprovedHrs']; ?>" class="txtbox ApprovedHrs">
											<?php }else{
													echo $value['ApprovedHrs'];
											 	  }
											 ?>
										</td>
										<td <?php if($key != 0){ ?>style="border-top: 1px solid #888"<?php } ?> width="100%" class="leftalign">
											<?php
												$wh_act = json_decode($value['Activities'], true);
												foreach($wh_act as $act_details){
													echo "(".$act_details['start_time'] ." - " . $act_details['end_time'] .") ".$act_details['act']."</br></br>";
													$excess = $act_details['excess'];
												}
												$show_warning = false;

												if (!$chkexpire){
													if(trim($notification_data[0]['Signatory01']) == $profile_idnum){
														if (!$notification_data[0]['ApprovedDate01'] && $notification_data[0]['Approved'] != 2){
															$show_warning = true;
														}
													}
													if (trim($notification_data[0]['Signatory02']) == $profile_idnum) {
														if(!$notification_data[0]['ApprovedDate02'] && $notification_data[0]['ApprovedDate01'] && $notification_data[0]['Approved'] != 2){
															$show_warning = true;
														}
													}
													if (trim($notification_data[0]['Signatory03']) == $profile_idnum) {
														if(!$notification_data[0]['ApprovedDate03'] && $notification_data[0]['ApprovedDate02'] && $notification_data[0]['Approved'] != 2){
															$show_warning = true;
														}
													}
													if (trim($notification_data[0]['Signatory04']) == $profile_idnum) {
														if(!$notification_data[0]['ApprovedDate04'] && $notification_data[0]['ApprovedDate03'] && $notification_data[0]['Approved'] != 2){
															$show_warning = true;
														}
													}
													if (trim($notification_data[0]['Signatory05']) == $profile_idnum) {
														if(!$notification_data[0]['ApprovedDate05'] && $notification_data[0]['ApprovedDate04'] && $notification_data[0]['Approved'] != 2){
															$show_warning = true;
														}
													}
													if (trim($notification_data[0]['Signatory06']) == $profile_idnum) {
														if(!$notification_data[0]['ApprovedDate06'] && $notification_data[0]['ApprovedDate05'] && $notification_data[0]['Approved'] != 2){
															$show_warning = true;
														}
													}
												}

											if($show_warning){

												if($holiday['SHIFT'] == 'HOLIDAY' || $wfday == 6  || $wfday == 0){
													if($value['AppliedHrs'] > 8){
											?>
														<p class="wfhwarning<?php echo $key; ?> whwarning" style="color: red;">The applied hours falls on a Holiday / Saturday / Sunday and exceeds 8 hours per day.</br><a href="#" class="wfhwarn<?php echo $key; ?>" attribute="<?php echo $key; ?>" attribute2="<?php echo $value['AppliedHrs']; ?>" attribute3="1"> <u>Approve applied hours</a></u> or <u><a href="#" onClick="$('.wfhcancel<?php echo $key; ?>').click();" class="<?php echo $key; ?>" attribute="<?php echo $key; ?>" attribute3="0">cancel applied hours </a></u>or <u><a href="#" class="wfh8<?php echo $key; ?>" attribute="<?php echo $key; ?>" attribute3="0">approve 8 hours only?</a></u></p>
														<p><a href="#" class="reset<?php echo $key;?> resetwfh" attribute="<?php echo $key; ?>" style="color: red;"><u>undo</u></a></p>
											<?php
													}else{
											?>
														<p class="wfhwarning<?php echo $key; ?> whwarning" style="color: red;">The applied hours falls on a Holiday / Saturday / Sunday. Do you want to approve the applied hours?</br><u><a href="#" class="wfhwarn<?php echo $key; ?>" attribute="<?php echo $key; ?>" attribute2="<?php echo $value['AppliedHrs']; ?>" attribute3="1">Approve applied hours</a></u> or <u><a href="#" class="wfhwarn<?php echo $key; ?>" onClick="$('.wfhcancel<?php echo $key; ?>').click();" attribute="<?php echo $key; ?>" attribute3="0">cancel applied hours?</a></u></p>
														<p><a href="#" class="reset<?php echo $key;?> resetwfh" attribute="<?php echo $key; ?>" style="color: red;"><u>undo</u><a></p>
											<?php
													}
												}else{
													if($excess > 0 && $value['AppliedHrs'] <= 8){
											?>

											<p class="wfhwarning<?php echo $key; ?> whwarning" style="color: red;">The applied hours is beyond 6:00 pm.</br>
												<u><a href="#" class="wfhwarn<?php echo $key; ?>" attribute="<?php echo $key; ?>" attribute2="<?php echo $value['AppliedHrs']; ?>" attribute3="1">Approve applied hours</a></u> or
												<u><a href="#" class="wfh6<?php echo $key; ?>" attribute="<?php echo $key; ?>" attribute3="<?php echo $value['AppliedHrs']; ?>" excess="<?php echo $excess; ?>">approve up to 6:00 pm only?</a></u></p>

											<p><a href="#" class="reset<?php echo $key;?> resetwfh" attribute="<?php echo $key; ?>" style="color: red;"><u>undo</u></a></p>

											<?php
													}elseif ($excess > 0 && $value['AppliedHrs'] > 8){
											?>

											<p class="wfhwarning<?php echo $key; ?> whwarning" style="color: red;">The applied hours is beyond 6:00 pm and exceeds 8 hours per day.</br>
												<u><a href="#" class="wfhwarn<?php echo $key; ?>" attribute="<?php echo $key; ?>" attribute2="<?php echo $value['AppliedHrs']; ?>" attribute3="1">Approve applied hours</a></u> or
												<u><a href="#" class="wfh6<?php echo $key; ?>" attribute="<?php echo $key; ?>" attribute3="<?php echo $value['AppliedHrs']; ?>" excess="<?php echo $excess; ?>">approve up to 6:00 pm only</a></u> or
											  <u><a href="#" class="wfh8<?php echo $key; ?>" attribute="<?php echo $key; ?>" attribute3="0">approve 8 hours only?</a></u></p>

												<p><a href="#" class="reset<?php echo $key;?> resetwfh" attribute="<?php echo $key; ?>" style="color: red;"><u>undo</u></a></p>

											<?php
													}else{
													if($value['AppliedHrs'] > 8){
											?>
														<p class="wfhwarning<?php echo $key; ?> whwarning" style="color: red;">The applied hours exceeds 8 hours per day, do you want to approve the applied hours?</br><u><a href="#" class="wfhwarn<?php echo $key; ?>" attribute="<?php echo $key; ?>" attribute2="<?php echo $value['AppliedHrs']; ?>" attribute3="1">Approve applied hours</a></u> or <u><a href="#" class="wfh8<?php echo $key; ?>" attribute="<?php echo $key; ?>" attribute3="0">approve 8 hours only?</a></u></p>
														<p><a href="#" class="reset<?php echo $key;?> resetwfh" attribute="<?php echo $key; ?>" style="color: red;"><u>undo</u></a></p>
											<?php
													}else{
														?>
														<p><a href="#" class="reset<?php echo $key;?> resetwfh" attribute="<?php echo $key; ?>" style="color: red;"><u>undo</u></a></p>
														<?php
													}
												}
												}
											}
											?>
										</td>
										<td <?php if($key != 0){ ?>style="border-top: 1px solid #888"<?php } ?> class="centertalign">
											<?php if(in_array($profile_idnum, $approvers)){ ?>
												<?php if ($appwh_count > 1) : ?>
													<i class="wfhcancel<?php echo $key; ?> fa fa-times redtext cursorpoint" attribute="<?php echo $key; ?>"></i>
												<?php endif; ?>
											<?php } ?>
										</td>
									</tr>
									<?php
									$pdtrto = strtotime($value['DTRDate']);
								endforeach;

							?>
						</table>
					</div>
					</td>
				</tr>

				<?php
            elseif ($doctype == 'MD') :
                $application_data = $tblsql->get_mrequest(7, $refnum);

                $chkexpiremd = 0;

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.($dbname == 'MARKETING' ? 'https://www.marketingsalesagents.com' : WEB).'/uploads/md/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y g:ia', strtotime($application_data[0]['ReqDate'])); ?></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                        <div class="divmddata width100per notidatadiv">
                            <table class="tdatablk">
                                <?php $appmd_data = $tblsql->get_mdtrdata($refnum); ?>
                                <tr>
                                    <th width="100px">DTR Date</th>
                                    <th width="80px">Day</th>
                                    <th width="100px">Time IN</th>
                                    <?php if ($appmd_data[0]['Activities']) : ?>
                                    <th width="200px">Activities</th>
                                    <th width="150px">Shift Desc</th>
                                    <th width="150px">New Shift Desc</th>
                                    <?php else : ?>
                                    <th width="100px">Time OUT</th>
                                    <th width="200px">Shift Desc</th>
                                    <th width="200px">New Shift Desc</th>
                                    <?php endif; ?>
                                    <th width="100px">Cancel</th>
                                </tr>
                                <?php
                                    $appmd_count = count($appmd_data);

                                    foreach ($appmd_data as $key => $value) :
                                        $shifts2 = $mainsql->get_shift($value['NewShiftDesc']);
                                        $chkmditem = $mainsql->check_appexpire($value['DTRDate']);
                                        if ($chkmditem) : $chkexpiremd++; endif;
                                        ?>
                                        <tr>
                                            <?php $timearray = preg_split('/\s+/', trim($value['TimeIn'])); $timearray2 = preg_split('/\s+/', trim($value['TimeOUt'])); ?>
                                            <td><?php echo date('F j, Y', strtotime($value['DTRDate'])); ?></td>
                                            <td><?php echo $value['Day']; ?></td>
                                            <td><?php echo $timearray[3] ? date('g:ia', strtotime($timearray[3])) : ''; ?></td>
                                            <?php if ($value['Activities']) : ?>
                                            <td><?php echo $value['Activities']; ?></td>
                                            <?php else : ?>
                                            <td><?php echo $timearray[3] ? date('g:ia', strtotime($timearray2[3])) : ''; ?></td>
                                            <?php endif; ?>
                                            <td><?php echo $value['ShiftDesc']; ?></td>
                                            <td><?php echo $value['NewShiftDesc'] ? $shifts2[0]['ShiftDesc'] : 'REST DAY'; ?></td>
                                            <td class="centertalign"><?php if ($appmd_count > 1) : ?><i class="btnmdcancel fa fa-times redtext cursorpoint" attribute="<?php echo $refnum; ?>" attribute2="<?php echo date('Y-m-d 00:00:00.000', strtotime($value['DTRDate'])); ?>"></i><?php endif; ?></td>
                                        </tr>
                                        <?php
                                        $pdtrto = strtotime($value['DTRDate']);
                                    endforeach;

                                    $chkexpire = $chkexpiremd ? 1 : 0;
                                ?>
                            </table>
                        </div>
                        </td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['DateStart']);

            elseif ($doctype == 'SC') :
                $application_data = $tblsql->get_mrequest(8, $refnum);
                //var_dump($application_data);

                $chkexpiresc = 0;

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.($dbname == 'MARKETING' ? 'https://www.marketingsalesagents.com' : WEB).'/uploads/sc/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($notification_data[0]['DateFiled'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Remarks</b></td>
                        <td><?php echo $application_data[0]['REMARKS']; ?></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                        <div class="divtsdata width100per notidatadiv">
                            <table class="tdatablk">
                                <tr>
                                    <th width="100px">DTR Date</th>
                                    <th width="200px">Current Shift Desc</th>
                                    <th width="200px">New Shift Desc</th>
                                    <th width="150px">Shift Time IN</th>
                                    <th width="150px">Shift Time OUT</th>
                                    <th width="80px">Cancel</th>
                                </tr>
                                <?php
                                    //$ts_data = $tblsql->get_nrequest(8, $refnum);
                                    $appts_data = $tblsql->get_tsdata($refnum);
                                    $appts_count = count($appts_data);
                                    //var_dump($appts_data);
                                    foreach ($appts_data as $key => $value) :
                                        $oldshiftdesc = $mainsql->get_shift($value['ShiftID']);
                                        $chkscitem = $mainsql->check_appexpire($value['DTRDate']);
                                        if ($chkscitem) : $chkexpiresc++; endif;
                                        ?>
                                        <tr>
                                            <td><?php echo date('M j, Y', strtotime($value['DTRDate'])); ?></td>
                                            <td><?php echo $value['ShiftID'] ? $oldshiftdesc[0]['ShiftDesc'] : 'REST DAY'; ?></td>
                                            <td><?php echo $value['NewShiftDesc'] ? $value['NewShiftDesc'] : 'REST DAY'; ?></td>
                                            <td><?php echo $value['TimeIn'] ? date('g:ia', strtotime($value['TimeIn'])) : 'N/A'; ?></td>
                                            <td><?php echo $value['TimeOut'] ? date('g:ia', strtotime($value['TimeOut'])) : 'N/A'; ?></td>
                                            <td class="centertalign"><?php if ($appts_count > 1 && $notification_data[0]['Approved'] != 3) : ?><i class="btnsccancel fa fa-times redtext cursorpoint" attribute="<?php echo $refnum; ?>" attribute2="<?php echo date('Y-m-d 00:00:00.000', strtotime($value['DTRDate'])); ?>"></i><?php endif; ?></td>
                                        </tr>
                                        <?php
                                        $pdtrto = strtotime($value['DTRDate']);
                                    endforeach;

                                    $chkexpire = $chkexpiresc ? 1 : 0;
                                ?>
                            </table>
                        </div>
                        </td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['DateStart']);

            elseif ($doctype == 'LU') :
                $application_data = $tblsql->get_nrequest(9, $refnum);

                $chkexpire = $mainsql->check_appexpire($application_data[0]['DtrDate']);

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.($dbname == 'MARKETING' ? 'https://www.marketingsalesagents.com' : WEB).'/uploads/ot/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <?php if ($notification_data[0]['EmpID'] == $profile_idnum && $notification_data[0]['Approved'] != 3 && $notification_data[0]['Approved'] != 2) : ?>
                    <!--tr>
                        <td width="25%">&nbsp;</td>
                        <td width="75%"><a href="<?php echo WEB; ?>/otpdf?id=<?php echo $refnum; ?>" target="_blank"><button class="btn">Print OT Form</button></a></td>
                    </tr-->
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b><input type="hidden" id="dbname" name="dbname" value="<?php echo $notification_data[0]['DBNAME'] ?>" /></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['ReqDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>DTR Date</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['DtrDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Type</b></td>
                        <td><?php echo $application_data[0]['LUType']; ?></td>
                    </tr>
                    <tr>
                        <td><b>Applied Hours</b></td>
                        <td><?php echo $application_data[0]['LUHrs']; ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['DtrDate']);
                $pdtrto = strtotime($application_data[0]['DtrDate']);

            endif;

            ?>

						                    <?php //signatorystart
						                        $ifposted = $mainsql->get_posted($pdtrfrom, $pdtrto, $profile_comp);
						                        $thisisposted = $ifposted[0]['Post'] ? 1 : 0;
						                    ?>

						                    <tr>
						                        <td colspan="2">
						                            <div class="hrborder">&nbsp;</div>
						                        </td>
						                    </tr>
																<tr>
																	<td colspan="2">
																		<div style="max-height: 120px; overflow-y: auto;" class='signatoryapp'>
																			<script>
																			$(document).ready(function(){
																				if($("#approvehere").attr("appr")){
																					var elemRect = $("#approvehere").offset().top;
																					var elemRect2 = $(".signatoryapp").offset().top;
																					var gap = elemRect - elemRect2;
																					// $('signatoryapp').scrollTo('#btnapp');
																					$('.signatoryapp').animate({
																			        scrollTop: gap - 100
																			    }, 1000);
																				}
																			});
																			</script>
																			<table width="100%">

						                    <?php if ($notification_data[0]['Approved'] != 3) : ?>
						                    <?php if (trim($notification_data[0]['Signatory01'])) : ?>
						                    <tr>
																	<td><b>Signatory 1</b></td>
																	<td><?php echo $approver_data1[0]['FName'].' '.$approver_data1[0]['LName']; ?></td>
						                      <!-- <td width="50%">
																		<table width="100%">
																			<tr>
																				<td><b>Signatory 1</b></td>
																				<td width="50%"><?php //echo $approver_data1[0]['FName'].' '.$approver_data1[0]['LName']; ?></td>
																			</tr>
																		</table>
																	</td> -->

																	<!-- <td width="50%"> -->
																		<!-- signatory 4 -->
																		<!-- <table width="100%"> -->
																			<!-- <tr> -->
																				<!-- <td><b>Signatory 4</b></td> -->
																				<!-- <td width="50%"><?php //echo $approver_data4[0]['FName'].' '.$approver_data4[0]['LName']; ?></td> -->
																			<!-- </tr> -->
																		<!-- </table> -->
																		<!-- signatory 4 -->
																	<!-- </td> -->
						                    </tr>
						                    <tr>
						                        <?php //var_dump($notification_data[0]['Signatory01']);goherespence ?>
						                        <?php if ($notification_data[0]['Signatory01'] == $profile_idnum) : // && $defdbname01 == $profile_dbname ?>

						                        <td><b><?php echo $notification_data[0]['ApprovedDate01'] ? 'Status' : '&nbsp;'; ?></b></td>
						                        <td>
						                            <?php if (!$notification_data[0]['ApprovedDate01'] && $notification_data[0]['Approved'] != 2) : ?>
						                                <?php if ($doctype == 'OT') : ?>
						                                    <script type="text/javascript">// slider
						                                        $(".approvehours").spinner({
						                                          step: 0.5,
						                                          spin: function( event, ui ) {
						                                            if ( ui.value > <?php echo $application_data[0]['Hrs']; ?> ) {
						                                              $(this).spinner( "value", <?php echo $application_data[0]['Hrs']; ?> );
						                                              return false;
						                                            } else if ( ui.value < 0 ) {
						                                              $(this).spinner( "value", 0 );
						                                              return false;
						                                            }
						                                          }
						                                        });
						                                    </script>
						                                    <b>Approve Hour/s</b> <input type="text" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs'] < $application_data[0]['Hrs'] ? $application_data[0]['ApprovedHrs'] :  $application_data[0]['Hrs']; ?>" class="approvehours txtbox width50 righttalign" readonly />
						                                <?php endif; ?>
						                                <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10" />
						                                <?php if (!$chkexpire) : ?>
																							<?php if (!$notification_data[0]['ApprovedDate01'] && $notification_data[0]['Approved'] != 2) : ?>
																							<?php if ($doctype == 'WH') : ?>
																								<script>
																									$(".wfhapproveall").click(function(){
																										var approve = $(this).attr("value");
																										var overwrite = false;

																											if(approve == 0){
																												$(this).attr("value", 1);

																												$(".ApprovedHrs").each(function(){
																													if($(this).val() != $(this).attr("attribute3")){
																														overwrite = true;
																													}
																												});

																												if(overwrite){
																													if(confirm("All of your changes on the Approved hours will be overwritten with the applied hours. Are you sure you want to continue?")){
																														$(".ApprovedHrs").each(function(){
																															$(this).val($(this).attr("attribute2"));
																														});
																														$(".whwarning").attr("style", "display: none");
																													}else{
																														$(".wfhapproveall").click();
																													}
																												}else{
																													$(".ApprovedHrs").each(function(){
																														$(this).val($(this).attr("attribute2"));
																													});
																													$(".whwarning").attr("style", "display: none");
																												}


																											}else{
																												$(this).attr("value", 0);
																												$(".ApprovedHrs").each(function(){
																													$(this).val($(this).attr("attribute3"));
																												});
																												$(".whwarning").attr("style", "color: red");
																											}

																									});
																								</script>
																								<input type="checkbox" class="wfhapproveall" value="0"><b>Approve all applied hours</b></br></br>

																							<?php endif; ?>
																							<?php endif; ?>
																							<div id="approvehere" appr="1"></div>
						                                <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory01']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME01'] ? $notification_data[0]['DB_NAME01'] : 0; ?>"<?php if ($notification_data[0]['Signatory02']) : ?> attribute21="<?php echo $notification_data[0]['Signatory02'] ? $notification_data[0]['Signatory02'] : 0; ?>" attribute22="<?php echo $notification_data[0]['DB_NAME02'] ? $notification_data[0]['DB_NAME02'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
						                                <?php endif; ?>
						                                <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory01']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME01'] ? $notification_data[0]['DB_NAME01'] : 0; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" />
						                            <?php else : ?>
						                                <?php if ($notification_data[0]['ApprovedDate01'] != NULL) : ?>
						                                    <?php if ($notification_data[0]['Approved'] != 2) : ?>
						                                        APPROVED BY YOU
						                                    <?php else : ?>
						                                        REJECTED BY YOU
						                                    <?php endif; ?>
						                                <?php else : ?>
						                                    TO BE APPROVED BY YOU
						                                <?php endif; ?>
						                            <?php endif; ?>
						                        </td>
						                        <?php else : ?>
						                        <td><b>Status</b></td>
						                        <td><?php
						                            if ($notification_data[0]['ApprovedDate01']) :
						                                echo 'APPROVED';
						                            else :
						                                if ($notification_data[0]['Approved'] == 2) :
						                                    echo 'REJECTED';
						                                else :
						                                    echo 'TO BE APPROVED';
						                                endif;
						                            endif; ?><span id="remarks" name="remarks">&nbsp;</span></td>
						                        <?php endif; ?>
						                    </tr>
						                    <?php if ($notification_data[0]['ApprovedDate01']) : ?>
						                    <tr>
						                        <td><b>Date</b></td>
						                        <td><?php echo date("F j, Y | g:ia", strtotime($notification_data[0]['ApprovedDate01'])); ?></td>
						                    </tr>
						                        <?php if (trim($notification_data[0]['Remarks01'])) : ?>
						                        <tr>
						                            <td><b>Remarks</b></td>
						                            <td><?php echo $mainsql->truncate($notification_data[0]['Remarks01'], 50); ?></td>
						                        </tr>
						                        <?php endif; ?>
						                    <?php endif; ?>
						                    <?php endif; ?>
						                    <?php if (trim($notification_data[0]['Signatory02'])) : ?>
						                    <tr>
						                        <td><b>Signatory2</b></td>
						                        <td><?php echo $approver_data2[0]['FName'].' '.$approver_data2[0]['LName']; ?></td>
						                    </tr>
						                    <tr>
						                        <?php if ($notification_data[0]['Signatory02'] == $profile_idnum) : ?>
						                        <td><b><?php echo $notification_data[0]['ApprovedDate02'] ? 'Status' : '&nbsp;'; ?></b></td>
						                        <td>
						                            <?php if (!$notification_data[0]['ApprovedDate02'] && $notification_data[0]['ApprovedDate01'] && $notification_data[0]['Approved'] != 2) : ?>
						                                <?php if ($doctype == 'OT') : ?>
						                                    <script type="text/javascript">// slider
						                                        $(".approvehours").spinner({
						                                          step: 0.5,
						                                          spin: function( event, ui ) {
						                                            if ( ui.value > <?php echo $application_data[0]['Hrs']; ?> ) {
						                                              $(this).spinner( "value", <?php echo $application_data[0]['Hrs']; ?> );
						                                              return false;
						                                            } else if ( ui.value < 0 ) {
						                                              $(this).spinner( "value", 0 );
						                                              return false;
						                                            }
						                                          }
						                                        });
						                                    </script>
						                                    <b>Approve Hour/s</b> <input type="text" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs'] < $application_data[0]['Hrs'] ? $application_data[0]['ApprovedHrs'] :  $application_data[0]['Hrs']; ?>" class="approvehours txtbox width50 righttalign" readonly />
						                                    <!-- <b>Approve Hour/s</b> <input type="text" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['Hrs']; ?>" class="approvehours txtbox width50 righttalign" readonly /> -->
						                                    <!--input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" /-->
						                                <?php endif; ?>
						                                <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10" />
						                                <?php if (!$chkexpire) : ?>
																							<?php if (!$notification_data[0]['ApprovedDate02'] && $notification_data[0]['ApprovedDate01'] && $notification_data[0]['Approved'] != 2) : ?>
																							<?php if ($doctype == 'WH') : ?>
																								<script>
																									$(".wfhapproveall").click(function(){
																										var approve = $(this).attr("value");
																										var overwrite = false;

																											if(approve == 0){
																												$(this).attr("value", 1);

																												$(".ApprovedHrs").each(function(){
																													if($(this).val() != $(this).attr("attribute3")){
																														overwrite = true;
																													}
																												});

																												if(overwrite){
																													if(confirm("All of your changes on the Approved hours will be overwritten with the applied hours. Are you sure you want to continue?")){
																														$(".ApprovedHrs").each(function(){
																															$(this).val($(this).attr("attribute2"));
																														});
																														$(".whwarning").attr("style", "display: none");
																													}else{
																														$(".wfhapproveall").click();
																													}
																												}else{
																													$(".ApprovedHrs").each(function(){
																														$(this).val($(this).attr("attribute2"));
																													});
																													$(".whwarning").attr("style", "display: none");
																												}


																											}else{
																												$(this).attr("value", 0);
																												$(".ApprovedHrs").each(function(){
																													$(this).val($(this).attr("attribute3"));
																												});
																												$(".whwarning").attr("style", "color: red");
																											}

																									});
																								</script>
																								<input type="checkbox" class="wfhapproveall" value="0"><b>Approve all applied hours</b></br></br>

																							<?php endif; ?>
																							<?php endif; ?>
																							<div id="approvehere" appr="1"></div>
						                                <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory02']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME02'] ? $notification_data[0]['DB_NAME02'] : 0; ?>"<?php if ($notification_data[0]['Signatory03']) : ?> attribute21="<?php echo $notification_data[0]['Signatory03'] ? $notification_data[0]['Signatory03'] : 0; ?>" attribute22="<?php echo $notification_data[0]['DB_NAME03'] ? $notification_data[0]['DB_NAME03'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
						                                <?php endif; ?>
						                                <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory02']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME02'] ? $notification_data[0]['DB_NAME02'] : 0; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" />
						                            <?php else : ?>
						                                <?php if ($notification_data[0]['ApprovedDate02'] != NULL) : ?>
						                                    <?php if ($notification_data[0]['Approved'] != 2) : ?>
						                                        APPROVED BY YOU
						                                    <?php else : ?>
						                                        REJECTED BY YOU
						                                    <?php endif; ?>
						                                <?php else : ?>
						                                    TO BE APPROVED BY YOU
						                                <?php endif; ?>
						                            <?php endif; ?>
						                        </td>
						                        <?php else : ?>
						                        <td><b>Status</b></td>
						                        <td><?php
						                            if ($notification_data[0]['ApprovedDate02']) :
						                                echo 'APPROVED';
						                            else :
						                                if ($notification_data[0]['Approved'] == 2) :
						                                    echo 'REJECTED';
						                                else :
						                                    echo 'TO BE APPROVED';
						                                endif;
						                            endif; ?><span id="remarks" name="remarks">&nbsp;</span></td>
						                        <?php endif; ?>
						                    </tr>
						                    <?php if ($notification_data[0]['ApprovedDate02']) : ?>
						                    <tr>
						                        <td><b>Date</b></td>
						                        <td><?php echo date("F j, Y | g:ia", strtotime($notification_data[0]['ApprovedDate02'])); ?></td>
						                    </tr>
						                        <?php if (trim($notification_data[0]['Remarks02'])) : ?>
						                        <tr>
						                            <td><b>Remarks</b></td>
						                            <td><?php echo $mainsql->truncate($notification_data[0]['Remarks02'], 50); ?></td>
						                        </tr>
						                        <?php endif; ?>
						                    <?php endif; ?>
						                    <?php endif; ?>
						                    <?php if (trim($notification_data[0]['Signatory03'])) : ?>
						                    <tr>
						                        <td><b>Signatory 3</b></td>
						                        <td><?php echo $approver_data3[0]['FName'].' '.$approver_data3[0]['LName']; ?></td>
						                    </tr>
						                    <tr>
						                        <?php if ($notification_data[0]['Signatory03'] == $profile_idnum) : ?>
						                        <td><b><?php echo $notification_data[0]['ApprovedDate03'] ? 'Status' : '&nbsp;'; ?></b></td>
						                        <td>
						                            <?php if (!$notification_data[0]['ApprovedDate03'] && $notification_data[0]['ApprovedDate02'] && $notification_data[0]['Approved'] != 2) : ?>
						                                <?php if ($doctype == 'OT') : ?>
						                                    <script type="text/javascript">// slider
						                                        $(".approvehours").spinner({
						                                          step: 0.5,
						                                          spin: function( event, ui ) {
						                                            if ( ui.value > <?php echo $application_data[0]['Hrs']; ?> ) {
						                                              $(this).spinner( "value", <?php echo $application_data[0]['Hrs']; ?> );
						                                              return false;
						                                            } else if ( ui.value < 0 ) {
						                                              $(this).spinner( "value", 0 );
						                                              return false;
						                                            }
						                                          }
						                                        });
						                                    </script>
						                                    <b>Approve Hour/s</b> <input type="text" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs'] < $application_data[0]['Hrs'] ? $application_data[0]['ApprovedHrs'] :  $application_data[0]['Hrs']; ?>" class="approvehours txtbox width50 righttalign" readonly />
						                                    <!--input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" /-->
						                                <?php endif; ?>
						                                <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10" />
						                                <?php if (!$chkexpire) : ?>
																							<?php if (!$notification_data[0]['ApprovedDate03'] && $notification_data[0]['ApprovedDate02'] && $notification_data[0]['Approved'] != 2) : ?>
																							<?php if ($doctype == 'WH') : ?>
																								<script>
																									$(".wfhapproveall").click(function(){
																										var approve = $(this).attr("value");
																										var overwrite = false;

																											if(approve == 0){
																												$(this).attr("value", 1);

																												$(".ApprovedHrs").each(function(){
																													if($(this).val() != $(this).attr("attribute3")){
																														overwrite = true;
																													}
																												});

																												if(overwrite){
																													if(confirm("All of your changes on the Approved hours will be overwritten with the applied hours. Are you sure you want to continue?")){
																														$(".ApprovedHrs").each(function(){
																															$(this).val($(this).attr("attribute2"));
																														});
																														$(".whwarning").attr("style", "display: none");
																													}else{
																														$(".wfhapproveall").click();
																													}
																												}else{
																													$(".ApprovedHrs").each(function(){
																														$(this).val($(this).attr("attribute2"));
																													});
																													$(".whwarning").attr("style", "display: none");
																												}


																											}else{
																												$(this).attr("value", 0);
																												$(".ApprovedHrs").each(function(){
																													$(this).val($(this).attr("attribute3"));
																												});
																												$(".whwarning").attr("style", "color: red");
																											}

																									});
																								</script>
																								<input type="checkbox" class="wfhapproveall" value="0"><b>Approve all applied hours</b></br></br>

																							<?php endif; ?>
																							<?php endif; ?>
																							<div id="approvehere" appr="1"></div>
						                                <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory03']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME03'] ? $notification_data[0]['DB_NAME03'] : 0; ?>"<?php if ($notification_data[0]['Signatory04']) : ?> attribute21="<?php echo $notification_data[0]['Signatory04'] ? $notification_data[0]['Signatory04'] : 0; ?>" attribute22="<?php echo $notification_data[0]['DB_NAME04'] ? $notification_data[0]['DB_NAME04'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
						                                <?php endif; ?>
						                                <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory03']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME03'] ? $notification_data[0]['DB_NAME03'] : 0; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" />
						                            <?php else : ?>
						                                <?php if ($notification_data[0]['ApprovedDate03'] != NULL) : ?>
						                                    <?php if ($notification_data[0]['Approved'] != 2) : ?>
						                                        APPROVED BY YOU
						                                    <?php else : ?>
						                                        REJECTED BY YOU
						                                    <?php endif; ?>
						                                <?php else : ?>
						                                    TO BE APPROVED BY YOU
						                                <?php endif; ?>
						                            <?php endif; ?>
						                        </td>
						                        <?php else : ?>
						                        <td><b>Status</b></td>
						                        <td><?php
						                            if ($notification_data[0]['ApprovedDate03']) :
						                                echo 'APPROVED';
						                            else :
						                                if ($notification_data[0]['Approved'] == 2) :
						                                    echo 'REJECTED';
						                                else :
						                                    echo 'TO BE APPROVED';
						                                endif;
						                            endif; ?><span id="remarks" name="remarks">&nbsp;</span></td>
						                        <?php endif; ?>
						                    </tr>
						                    <?php if ($notification_data[0]['ApprovedDate03']) : ?>
						                    <tr>
						                        <td><b>Date</b></td>
						                        <td><?php echo date("F j, Y | g:ia", strtotime($notification_data[0]['ApprovedDate03'])); ?></td>
						                    </tr>
						                        <?php if (trim($notification_data[0]['Remarks03'])) : ?>
						                        <tr>
						                            <td><b>Remarks</b></td>
						                            <td><?php echo $mainsql->truncate($notification_data[0]['Remarks03'], 50); ?></td>
						                        </tr>
						                        <?php endif; ?>
						                    <?php endif; ?>
						                    <?php endif; ?>
						                    <?php if (trim($notification_data[0]['Signatory04'])) : ?>
						                    <tr>
						                        <td><b>Signatory 4</b></td>
						                        <td><?php echo $approver_data4[0]['FName'].' '.$approver_data4[0]['LName']; ?></td>
						                    </tr>
						                    <tr>
						                        <?php if ($notification_data[0]['Signatory04'] == $profile_idnum) : ?>
						                        <td><b><?php echo $notification_data[0]['ApprovedDate04'] ? 'Status' : '&nbsp;'; ?></b></td>
						                        <td>
						                            <?php if (!$notification_data[0]['ApprovedDate04'] && $notification_data[0]['ApprovedDate03'] && $notification_data[0]['Approved'] != 2) : ?>
						                                <?php if ($doctype == 'OT') : ?>
						                                    <script type="text/javascript">// slider
						                                        $(".approvehours").spinner({
						                                          step: 0.5,
						                                          spin: function( event, ui ) {
						                                            if ( ui.value > <?php echo $application_data[0]['Hrs']; ?> ) {
						                                              $(this).spinner( "value", <?php echo $application_data[0]['Hrs']; ?> );
						                                              return false;
						                                            } else if ( ui.value < 0 ) {
						                                              $(this).spinner( "value", 0 );
						                                              return false;
						                                            }
						                                          }
						                                        });
						                                    </script>
						                                    <b>Approve Hour/s</b> <input type="text" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs'] < $application_data[0]['Hrs'] ? $application_data[0]['ApprovedHrs'] :  $application_data[0]['Hrs']; ?>" class="approvehours txtbox width50 righttalign" readonly />
						                                    <!--input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" /-->
						                                <?php endif; ?>
						                                <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10" />
						                                <?php if (!$chkexpire) : ?>
																							<?php if (!$notification_data[0]['ApprovedDate04'] && $notification_data[0]['ApprovedDate03'] && $notification_data[0]['Approved'] != 2) : ?>
																							<?php if ($doctype == 'WH') : ?>
																								<script>
																									$(".wfhapproveall").click(function(){
																										var approve = $(this).attr("value");
																										var overwrite = false;

																											if(approve == 0){
																												$(this).attr("value", 1);

																												$(".ApprovedHrs").each(function(){
																													if($(this).val() != $(this).attr("attribute3")){
																														overwrite = true;
																													}
																												});

																												if(overwrite){
																													if(confirm("All of your changes on the Approved hours will be overwritten with the applied hours. Are you sure you want to continue?")){
																														$(".ApprovedHrs").each(function(){
																															$(this).val($(this).attr("attribute2"));
																														});
																														$(".whwarning").attr("style", "display: none");
																													}else{
																														$(".wfhapproveall").click();
																													}
																												}else{
																													$(".ApprovedHrs").each(function(){
																														$(this).val($(this).attr("attribute2"));
																													});
																													$(".whwarning").attr("style", "display: none");
																												}


																											}else{
																												$(this).attr("value", 0);
																												$(".ApprovedHrs").each(function(){
																													$(this).val($(this).attr("attribute3"));
																												});
																												$(".whwarning").attr("style", "color: red");
																											}

																									});
																								</script>
																								<input type="checkbox" class="wfhapproveall" value="0"><b>Approve all applied hours</b></br></br>

																							<?php endif; ?>
																							<?php endif; ?>
																							<div id="approvehere" appr="1"></div>
						                                <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory04']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME04'] ? $notification_data[0]['DB_NAME04'] : 0; ?>"<?php if ($notification_data[0]['Signatory05']) : ?> attribute21="<?php echo $notification_data[0]['Signatory05'] ? $notification_data[0]['Signatory05'] : 0; ?>" attribute22="<?php echo $notification_data[0]['DB_NAME05'] ? $notification_data[0]['DB_NAME05'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
						                                <?php endif; ?>
						                                <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory04']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME04'] ? $notification_data[0]['DB_NAME04'] : 0; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" />
						                            <?php else : ?>
						                                <?php if ($notification_data[0]['ApprovedDate04'] != NULL) : ?>
						                                    <?php if ($notification_data[0]['Approved'] != 2) : ?>
						                                        APPROVED BY YOU
						                                    <?php else : ?>
						                                        REJECTED BY YOU
						                                    <?php endif; ?>
						                                <?php else : ?>
						                                    TO BE APPROVED BY YOU
						                                <?php endif; ?>
						                            <?php endif; ?>
						                        </td>
						                        <?php else : ?>
						                        <td><b>Status</b></td>
						                        <td><?php
						                            if ($notification_data[0]['ApprovedDate04']) :
						                                echo 'APPROVED';
						                            else :
						                                if ($notification_data[0]['Approved'] == 2) :
						                                    echo 'REJECTED';
						                                else :
						                                    echo 'TO BE APPROVED';
						                                endif;
						                            endif; ?><span id="remarks" name="remarks">&nbsp;</span></td>
						                        <?php endif; ?>
						                    </tr>
						                    <?php if ($notification_data[0]['ApprovedDate04']) : ?>
						                    <tr>
						                        <td><b>Date</b></td>
						                        <td><?php echo date("F j, Y | g:ia", strtotime($notification_data[0]['ApprovedDate04'])); ?></td>
						                    </tr>
						                        <?php if (trim($notification_data[0]['Remarks04'])) : ?>
						                        <tr>
						                            <td><b>Remarks</b></td>
						                            <td><?php echo $mainsql->truncate($notification_data[0]['Remarks04'], 50); ?></td>
						                        </tr>
						                        <?php endif; ?>
						                    <?php endif; ?>
						                    <?php endif; ?>
						                    <?php if (trim($notification_data[0]['Signatory05'])) : ?>
						                    <tr>
						                        <td><b>Signatory 5</b></td>
						                        <td><?php echo $approver_data5[0]['FName'].' '.$approver_data5[0]['LName']; ?></td>
						                    </tr>
						                    <tr>
						                        <?php if ($notification_data[0]['Signatory05'] == $profile_idnum && $defdbname05 == $profile_dbname) : ?>
						                        <td><b><?php echo $notification_data[0]['ApprovedDate05'] ? 'Status' : '&nbsp;'; ?></b></td>
						                        <td>
						                            <?php if (!$notification_data[0]['ApprovedDate05'] && $notification_data[0]['ApprovedDate04'] && $notification_data[0]['Approved'] != 2) : ?>
						                                <?php if ($doctype == 'OT') : ?>
						                                    <script type="text/javascript">// slider
						                                        $(".approvehours").spinner({
						                                          step: 0.5,
						                                          spin: function( event, ui ) {
						                                            if ( ui.value > <?php echo $application_data[0]['Hrs']; ?> ) {
						                                              $(this).spinner( "value", <?php echo $application_data[0]['Hrs']; ?> );
						                                              return false;
						                                            } else if ( ui.value < 0 ) {
						                                              $(this).spinner( "value", 0 );
						                                              return false;
						                                            }
						                                          }
						                                        });
						                                    </script>
						                                    <b>Approve Hour/s</b> <input type="text" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs'] < $application_data[0]['Hrs'] ? $application_data[0]['ApprovedHrs'] :  $application_data[0]['Hrs']; ?>" class="approvehours txtbox width50 righttalign" readonly />
						                                    <!--input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" /-->
						                                <?php endif; ?>
						                                <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10" />
						                                <?php if (!$chkexpire) : ?>
																							<?php if (!$notification_data[0]['ApprovedDate05'] && $notification_data[0]['ApprovedDate04'] && $notification_data[0]['Approved'] != 2) : ?>
																							<?php if ($doctype == 'WH') : ?>
																								<script>
																									$(".wfhapproveall").click(function(){
																										var approve = $(this).attr("value");
																										var overwrite = false;

																											if(approve == 0){
																												$(this).attr("value", 1);

																												$(".ApprovedHrs").each(function(){
																													if($(this).val() != $(this).attr("attribute3")){
																														overwrite = true;
																													}
																												});

																												if(overwrite){
																													if(confirm("All of your changes on the Approved hours will be overwritten with the applied hours. Are you sure you want to continue?")){
																														$(".ApprovedHrs").each(function(){
																															$(this).val($(this).attr("attribute2"));
																														});
																														$(".whwarning").attr("style", "display: none");
																													}else{
																														$(".wfhapproveall").click();
																													}
																												}else{
																													$(".ApprovedHrs").each(function(){
																														$(this).val($(this).attr("attribute2"));
																													});
																													$(".whwarning").attr("style", "display: none");
																												}


																											}else{
																												$(this).attr("value", 0);
																												$(".ApprovedHrs").each(function(){
																													$(this).val($(this).attr("attribute3"));
																												});
																												$(".whwarning").attr("style", "color: red");
																											}

																									});
																								</script>
																								<input type="checkbox" class="wfhapproveall" value="0"><b>Approve all applied hours</b></br></br>

																							<?php endif; ?>
																							<?php endif; ?>
																							<div id="approvehere" appr="1"></div>
						                                <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory05']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME05'] ? $notification_data[0]['DB_NAME05'] : 0; ?>"<?php if ($notification_data[0]['Signatory06']) : ?> attribute21="<?php echo $notification_data[0]['Signatory06'] ? $notification_data[0]['Signatory06'] : 0; ?>" attribute22="<?php echo $notification_data[0]['DB_NAME06'] ? $notification_data[0]['DB_NAME06'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
						                                <?php endif; ?>
						                                <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory05']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME05'] ? $notification_data[0]['DB_NAME05'] : 0; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" />
						                            <?php else : ?>
						                                <?php if ($notification_data[0]['ApprovedDate05'] != NULL) : ?>
						                                    <?php if ($notification_data[0]['Approved'] != 2) : ?>
						                                        APPROVED BY YOU
						                                    <?php else : ?>
						                                        REJECTED BY YOU
						                                    <?php endif; ?>
						                                <?php else : ?>
						                                    TO BE APPROVED BY YOU
						                                <?php endif; ?>
						                            <?php endif; ?>
						                        </td>
						                        <?php else : ?>
						                        <td><b>Status</b></td>
						                        <td><?php
						                            if ($notification_data[0]['ApprovedDate05']) :
						                                echo 'APPROVED';
						                            else :
						                                if ($notification_data[0]['Approved'] == 2) :
						                                    echo 'REJECTED';
						                                else :
						                                    echo 'TO BE APPROVED';
						                                endif;
						                            endif; ?><span id="remarks" name="remarks">&nbsp;</span></td>
						                        <?php endif; ?>
						                    </tr>
						                    <?php if ($notification_data[0]['ApprovedDate05']) : ?>
						                    <tr>
						                        <td><b>Date</b></td>
						                        <td><?php echo date("F j, Y | g:ia", strtotime($notification_data[0]['ApprovedDate05'])); ?></td>
						                    </tr>
						                        <?php if (trim($notification_data[0]['Remarks05'])) : ?>
						                        <tr>
						                            <td><b>Remarks</b></td>
						                            <td><?php echo $mainsql->truncate($notification_data[0]['Remarks05'], 50); ?></td>
						                        </tr>
						                        <?php endif; ?>
						                    <?php endif; ?>
						                    <?php endif; ?>
						                    <?php if (trim($notification_data[0]['Signatory06'])) : ?>
						                    <tr>
						                        <td><b>Signatory 6</b></td>
						                        <td><?php echo $approver_data6[0]['FName'].' '.$approver_data6[0]['LName']; ?></td>
						                    </tr>
						                    <tr >
						                        <?php if ($notification_data[0]['Signatory06'] == $profile_idnum && $defdbname06 == $profile_dbname) : ?>
						                        <td><b><?php echo $notification_data[0]['ApprovedDate06'] ? 'Status' : '&nbsp;'; ?></b></td>
						                        <td>
						                            <?php if (!$notification_data[0]['ApprovedDate06'] && $notification_data[0]['ApprovedDate05'] && $notification_data[0]['Approved'] != 2) : ?>
						                                <?php if ($doctype == 'OT') : ?>
						                                    <script type="text/javascript">// slider
						                                        $(".approvehours").spinner({
						                                          step: 0.5,
						                                          spin: function( event, ui ) {
						                                            if ( ui.value > <?php echo $application_data[0]['Hrs']; ?> ) {
						                                              $(this).spinner( "value", <?php echo $application_data[0]['Hrs']; ?> );
						                                              return false;
						                                            } else if ( ui.value < 0 ) {
						                                              $(this).spinner( "value", 0 );
						                                              return false;
						                                            }
						                                          }
						                                        });
						                                    </script>
						                                    <b>Approve Hour/s</b> <input type="text" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs'] < $application_data[0]['Hrs'] ? $application_data[0]['ApprovedHrs'] :  $application_data[0]['Hrs']; ?>" class="approvehours txtbox width50 righttalign" readonly />
						                                    <!--input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" /-->
						                                <?php endif; ?>
						                                <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10" />
						                                <?php if (!$chkexpire) : ?>
																							<?php if (!$notification_data[0]['ApprovedDate06'] && $notification_data[0]['ApprovedDate05'] && $notification_data[0]['Approved'] != 2) : ?>
																							<?php if ($doctype == 'WH') : ?>
																								<script>
																									$(".wfhapproveall").click(function(){
																										var approve = $(this).attr("value");
																										var overwrite = false;

																											if(approve == 0){
																												$(this).attr("value", 1);

																												$(".ApprovedHrs").each(function(){
																													if($(this).val() != $(this).attr("attribute3")){
																														overwrite = true;
																													}
																												});

																												if(overwrite){
																													if(confirm("All of your changes on the Approved hours will be overwritten with the applied hours. Are you sure you want to continue?")){
																														$(".ApprovedHrs").each(function(){
																															$(this).val($(this).attr("attribute2"));
																														});
																														$(".whwarning").attr("style", "display: none");
																													}else{
																														$(".wfhapproveall").click();
																													}
																												}else{
																													$(".ApprovedHrs").each(function(){
																														$(this).val($(this).attr("attribute2"));
																													});
																													$(".whwarning").attr("style", "display: none");
																												}


																											}else{
																												$(this).attr("value", 0);
																												$(".ApprovedHrs").each(function(){
																													$(this).val($(this).attr("attribute3"));
																												});
																												$(".whwarning").attr("style", "color: red");
																											}

																									});
																								</script>
																								<input type="checkbox" class="wfhapproveall" value="0"><b>Approve all applied hours</b></br></br>

																							<?php endif; ?>
																							<?php endif; ?>
																							<div id="approvehere" appr="1"></div>
						                                <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory06']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME06'] ? $notification_data[0]['DB_NAME06'] : 0; ?>" attribute21="0" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
						                                <?php endif; ?>
						                                <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory06']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME06'] ? $notification_data[0]['DB_NAME06'] : 0; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="smlbtn btnred" />
						                            <?php else : ?>
						                                <?php if ($notification_data[0]['ApprovedDate06'] != NULL) : ?>
						                                    <?php if ($notification_data[0]['Approved'] != 2) : ?>
						                                        APPROVED BY YOU
						                                    <?php else : ?>
						                                        REJECTED BY YOU
						                                    <?php endif; ?>
						                                <?php else : ?>
						                                    TO BE APPROVED BY YOU
						                                <?php endif; ?>
						                            <?php endif; ?>
						                        </td>
						                        <?php else : ?>
						                        <td><b>Status</b></td>
						                        <td><?php
						                            if ($notification_data[0]['ApprovedDate06']) :
						                                echo 'APPROVED';
						                            else :
						                                if ($notification_data[0]['Approved'] == 2) :
						                                    echo 'REJECTED';
						                                else :
						                                    echo 'TO BE APPROVED';
						                                endif;
						                            endif; ?><span id="remarks" name="remarks">&nbsp;</span></td>
						                        <?php endif; ?>
						                    </tr>
						                    <?php if ($notification_data[0]['ApprovedDate06']) : ?>
						                    <tr>
						                        <td><b>Date</b></td>
						                        <td><?php echo date("F j, Y | g:ia", strtotime($notification_data[0]['ApprovedDate06'])); ?></td>
						                    </tr>
						                        <?php if (trim($notification_data[0]['Remarks06'])) : ?>
						                        <tr>
						                            <td><b>Remarks</b></td>
						                            <td><?php echo $mainsql->truncate($notification_data[0]['Remarks06'], 50); ?></td>
						                        </tr>
						                        <?php endif; ?>
						                    <?php endif; ?>
						                    <?php endif; ?>
						                    <?php if ($notification_data[0]['EmpID'] == $profile_idnum && $notification_data[0]['Approved'] != 2) : ?>
						                    <tr>
						                        <td>&nbsp;</td>
						                        <td><input id="btncancel" type="button" name="btncancel" value="Cancel" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['EmpID']; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btncancel btnred smlbtn" /></td>
						                    </tr>
						                    <?php endif; ?>
						                    <?php endif; ?>

						                    <?php if ($chkexpire && $notification_data[0]['Approved'] == 0) : ?>
						                    <tr>
						                        <td colspan="2" class="centertalign redbg"><span class="whitetext bold">APPLICATION EXPIRED</span></td>
						                    </tr>
						                    <?php endif; ?>

						                    <?php if ($thisisposted) : ?>
						                    <tr>
						                        <td colspan="2" class="centertalign redbg"><span class="whitetext bold">POSTED</span></td>
						                    </tr>
						                    <?php endif; ?>

															</table>
															</script>

														</div>
													</td>
												</tr>

						                </table>


						            <?php //signatoryend

						            //var_dump($approver_data1);

        break;
        case 'datarman':

            $doctype = $_POST['doctype'];
            $refnum = $_POST['refnum'];
            $dbname = $_POST['dbname'];

            $notification_data = $mainsql->get_notification($refnum);
            $attachment_data = $mainsql->get_attachments($refnum, 0, $dbname);

            $approver_data1 = $logsql->get_allmember($notification_data[0]['Signatory01'], $notification_data[0]['DB_NAME01']);
            $approver_data2 = $logsql->get_allmember($notification_data[0]['Signatory02'], $notification_data[0]['DB_NAME02']);
            $approver_data3 = $logsql->get_allmember($notification_data[0]['Signatory03'], $notification_data[0]['DB_NAME03']);
            $approver_data4 = $logsql->get_allmember($notification_data[0]['Signatory04'], $notification_data[0]['DB_NAME04']);
            $approver_data5 = $logsql->get_allmember($notification_data[0]['Signatory05'], $notification_data[0]['DB_NAME05']);
            $approver_data6 = $logsql->get_allmember($notification_data[0]['Signatory06'], $notification_data[0]['DB_NAME06']);

            //var_dump($notification_data[0]['DBNAME']);

            $requestor_data = $logsql->get_allmember($notification_data[0]['EmpID'], $dbname);

            $chkexpire = 0;

            //READ STATUS
            $get_read = $mainsql->get_read($profile_idnum, $refnum, 1);
            if ($get_read) :
                $delete_read = $mainsql->delete_read($profile_idnum, $refnum);
            endif;
            ?>

            <table class="tdataform2 rightmargin margintop10 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">

            <?php
            //var_dump($notification_data);
            //if ($notification_data[0]['EmpID'] != $profile_idnum) :
                ?>

                    <tr>
                        <td width="25%"><b>Requested by</b></td>
                        <td width="75%"><?php echo $requestor_data[0]['FName'].' '.$requestor_data[0]['LName'].' ('.$notification_data[0]['EmpID'].')'; ?>
                        <input type="hidden" id="dbname" name="dbname" value="<?php echo $notification_data[0]['DBNAME'] ?>" attribute="<?php echo $attachment_data; ?>" />
                        </td>
                    </tr>

                <?php
            //endif;
						if ($doctype == 'WH') : //WFH HERE
							$application_data = $tblsql->get_mrequest(10, $refnum);

							?>

							<tr>
								<td width="25%"><b>Status</b></td>
								<td width="75%"><?php
									if ($notification_data[0]['Approved'] == 2) :
										echo "<span class='redtext'>REJECTED</span>";
									elseif ($notification_data[0]['Approved'] == 1) :
										echo "<span class='greentext'>APPROVED</span>";
									elseif ($notification_data[0]['Approved'] == 3) :
										echo "<span class='redtext'>CANCELLED</span>";
									else :
										echo "FOR APPROVAL";
									endif;
									?>
								</td>
							</tr>
							<tr>
								<td><b>Date Applied</b></td>
								<td><?php echo date('F j, Y g:ia', strtotime($application_data[0]['AppliedDate'])); ?></td>
							</tr>

							<tr>
								<td colspan="2">
								<div class="divmddata width100per notidatadiv">
									<table class="tdatablk">
										<?php $appwh_data = $tblsql->get_whdata($refnum); ?>
										<tr>
											<th width="70px">DTR Date</th>
											<th width="50px">Applied Hrs</th>
											<th width="50px">Approved Hrs</th>
											<th width="100%">Activities</th>
											<th width="10px">x</th>
										</tr>
										<?php
											$appwh_count = count($appwh_data);
											$approvers = array($notification_data[0]['Signatory01'], $notification_data[0]['Signatory02'], $notification_data[0]['Signatory03'],
																$notification_data[0]['Signatory04'], $notification_data[0]['Signatory05'], $notification_data[0]['Signatory06']);
											foreach ($appwh_data as $key => $value) :
												?>
												<script>
												$(function() {

													$(".wfhcancel<?php echo $key; ?>").click(function() {
														arrayid = $(this).attr('attribute');
														$("#wfhApprovedHrs" + arrayid).val(0);

													});

												});
												</script>
												<tr>
													<td <?php if($key != 0){ ?>style="border-top: 1px solid #888"<?php } ?> class="centertalign"><?php echo date('F j, Y', strtotime($value['DTRDate'])); ?></td>
													<td <?php if($key != 0){ ?>style="border-top: 1px solid #888"<?php } ?> class="centertalign"><?php echo $value['AppliedHrs']; ?></td>
													<td <?php if($key != 0){ ?>style="border-top: 1px solid #888"<?php } ?> class="centertalign">
														<?php if(in_array($profile_idnum, $approvers)){ ?>
															<input type="hidden" class="wfhseq" attribute="<?php echo $key; ?>" name="wfhSeq[<?php echo $key; ?>]" value="<?php echo $value['SeqID']; ?>">
															<input style="width: 50px;" value="<?php echo $value['ApprovedHrs'] ?>" id="wfhApprovedHrs<?php echo $key; ?>" type="number" name="wfhApprovedHrs[<?php echo $key; ?>]" attribute="<?php echo $key; ?>" class="txtbox ApprovedHrs">
														<?php }else{
																echo $value['ApprovedHrs'];
																}
														 ?>
													</td>
													<td <?php if($key != 0){ ?>style="border-top: 1px solid #888"<?php } ?> width="100%" class="leftalign">
														<?php
															$wh_act = json_decode($value['Activities'], true);
															foreach($wh_act as $act_details){
																echo "(".$act_details['time'].") ".$act_details['act']."</br></br>";
															}
														?>
													</td>
													<td <?php if($key != 0){ ?>style="border-top: 1px solid #888"<?php } ?> class="centertalign">
														<?php if(in_array($profile_idnum, $approvers)){ ?>
															<?php if ($appwh_count > 1) : ?>
																<i class="wfhcancel<?php echo $key; ?> fa fa-times redtext cursorpoint" attribute="<?php echo $key; ?>"></i>
															<?php endif; ?>
														<?php } ?>
													</td>
												</tr>
												<?php
												$pdtrto = strtotime($value['DTRDate']);
											endforeach;

										?>
									</table>
								</div>
								</td>
							</tr>

							<?php

            elseif ($doctype == 'OT') :
                $application_data = $tblsql->get_nrequest(1, $refnum);

                $chkexpire = $mainsql->check_appexpire($application_data[0]['DtrDate']);

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.WEB.'/uploads/ot/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <?php if ($notification_data[0]['EmpID'] == $profile_idnum && $notification_data[0]['Approved'] != 3 && $notification_data[0]['Approved'] != 2) : ?>
                    <!--tr>
                        <td width="25%">&nbsp;</td>
                        <td width="75%"><a href="<?php echo WEB; ?>/otpdf?id=<?php echo $refnum; ?>" target="_blank"><button class="btn">Print OT Form</button></a></td>
                    </tr-->
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['ReqDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>DTR Date</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['DtrDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>From</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['FromDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>To</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['ToDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>OT Type</b></td>
                        <td><?php echo $application_data[0]['OTType']; ?></td>
                    </tr>
                    <tr>
                        <td><b>Applied Hours</b></td>
                        <td><?php echo $application_data[0]['Hrs']; ?></td>
                    </tr>
                    <?php if ($notification_data[0]['Approved'] == 1) : ?>
                    <tr>
                        <td><b>Approved Hours</b></td>
                        <td>
                            <?php echo $application_data[0]['ApprovedHrs'] ? $application_data[0]['ApprovedHrs'] : 0; ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td><b>Reason</b></td>
                        <td><?php echo stripslashes($application_data[0]['Reason']); ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['DtrDate']);
                $pdtrto = strtotime($application_data[0]['DtrDate']);

            elseif ($doctype == 'LV') :
                $application_data = $tblsql->get_nrequest(2, $refnum);
                //$appleave_data = $tblsql->get_leavedata($refnum);

                $chkexpire = $mainsql->check_appexpire($application_data[0]['AbsenceFromDate'], $application_data[0]['AbsenceToDate']);

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.WEB.'/uploads/leave/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($notification_data[0]['DateFiled'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Coverage</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['AbsenceFromDate'])); ?> - <?php echo date('F j, Y', strtotime($application_data[0]['AbsenceToDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Type</b></td>
                        <td><?php echo $application_data[0]['LeaveDesc']; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="divlvdata width100per notidatadiv">
                            <table class="tdatablk width100per">
                                <tr>
                                    <th>Date</th>
                                    <th>Duration</th>
                                    <th>w/ Pay</th>
                                    <th>Cancel</th>
                                </tr>
                                <?php
                                    $applv_data = $tblsql->get_leavedata($refnum);
                                    $applv_count = count($applv_data);
                                    foreach($applv_data as $key => $value) :
                                ?>
                                <tr>
                                    <td><?php echo date("M j", strtotime($value['LeaveDate'])); ?></td>
                                    <td><?php

                                        if ($value['Duration'] >= 8) :
                                            echo number_format($value['Duration'], 1)." hours";
                                        else :
                                            echo number_format($value['Duration'], 1)." hours";
                                        endif;

                                        /*if ($value['Duration'] == "WD") :
                                            echo "Whole Day";
                                        elseif ($value['Duration'] == "HD") :
                                            echo "Half Day";
                                        elseif ($value['Duration'] == "HD1") :
                                            echo "Half Day AM";
                                        elseif ($value['Duration'] == "HD2") :
                                            echo "Half Day PM";
                                        endif;*/
                                    ?></td>
                                    <td class="centertalign">
                                        <?php echo $value['WithPay'] ? "<i class='fa fa-check'></i>" : "<i class='fa fa-times'></i>"; ?>
                                    </td>
                                    <td class="centertalign"><?php if ($applv_count > 1) : ?><i class="btnlvcancel fa fa-times redtext cursorpoint" attribute="<?php echo $refnum; ?>" attribute2="<?php echo date('Y-m-d 00:00:00.000', strtotime($value['LeaveDate'])); ?>"></i><?php endif; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Reason</b></td>
                        <td><?php echo stripslashes($application_data[0]['Reason']); ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['AbsenceFromDate']);
                $pdtrto = strtotime($application_data[0]['AbsenceToDate']);

            elseif ($doctype == 'MA') :
                $application_data = $tblsql->get_nrequest(3, $refnum);

                $chkexpire = $mainsql->check_appexpire($application_data[0]['DateFrom'], $application_data[0]['DateTo']);

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.WEB.'/uploads/ma/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['ReqDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>From</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['DateFrom'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>To</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['DateTo'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Type</b></td>
                        <td><?php echo $application_data[0]['TypeAvail']; ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['DateFrom']);
                $pdtrto = strtotime($application_data[0]['DateTo']);

            elseif ($doctype == 'OB') :
                $application_data = $tblsql->get_nrequest(4, $refnum);
                $appobt_data = $tblsql->get_obtdata($refnum);

                $chkexpire = $mainsql->check_appexpire($application_data[0]['OBTimeINDate'], $application_data[0]['OBTimeOutDate']);

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.WEB.'/uploads/ob/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <?php if ($notification_data[0]['EmpID'] == $profile_idnum && $notification_data[0]['Approved'] != 3 && $notification_data[0]['Approved'] != 2) : ?>
                    <tr>
                        <td width="25%">&nbsp;</td>
                        <td width="75%"><a href="<?php echo WEB; ?>/obtpdf?id=<?php echo $refnum; ?>" target="_blank"><button class="btn">Print OBT Form</button></a></td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['DateFiled'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>From</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['OBTimeINDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>To</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['OBTimeOutDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Destination</b></td>
                        <td><?php echo $application_data[0]['Destination']; ?></td>
                    </tr>
                    <tr>
                        <td><b>Purpose</b></td>
                        <td><?php echo stripslashes($application_data[0]['Reason']); ?></td>
                    </tr>
                    <tr>
                        <td><b>Detail</b></td>
                        <td>
                            <div class="width100per notidatadiv">
                            <table class="tdatablk">
                                <tr>
                                    <th>In</th>
                                    <th>Out</th>
                                </tr>
                                <?php foreach($appobt_data as $key => $value) : ?>
                                <tr>
                                    <td><?php echo date("M j, Y g:ia", strtotime($value['ObTimeInDate'])); ?></td>
                                    <td><?php echo date("M j, Y g:ia", strtotime($value['ObTimeOutDate'])); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Days</b></td>
                        <td><?php echo $application_data[0]['Days']; ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['OBTimeINDate']);
                $pdtrto = strtotime($application_data[0]['OBTimeINDate']);

            elseif ($doctype == 'NP') :
                $application_data = $tblsql->get_nrequest(6, $refnum);

                $chkexpire = $mainsql->check_appexpire($application_data[0]['DateCovered']);

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.WEB.'/uploads/np/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($notification_data[0]['DateFiled'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Date Coverage</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['DateCovered'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Time IN</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['DateTimeIN'])); ?><br><?php echo date('g:ia', strtotime($application_data[0]['TimeIn'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Time OUT</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['DateTimeOUT'])); ?><br><?php echo date('g:ia', strtotime($application_data[0]['TimeOut'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Reason</b></td>
                        <td><?php echo stripslashes($application_data[0]['Reason']); ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['DateCovered']);
                $pdtrto = strtotime($application_data[0]['DateCovered']);

            elseif ($doctype == 'MD') :
                $application_data = $tblsql->get_mrequest(7, $refnum);

                $chkexpiremd = 0;

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.WEB.'/uploads/md/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y g:ia', strtotime($application_data[0]['ReqDate'])); ?></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                        <div class="divmddata width100per notidatadiv">
                            <table class="tdatablk">
                                <?php $appmd_data = $tblsql->get_mdtrdata($refnum); ?>
                                <tr>
                                    <th width="100px">DTR Date</th>
                                    <th width="80px">Day</th>
                                    <th width="100px">Time IN</th>
                                    <?php if ($appmd_data[0]['Activities']) : ?>
                                    <th width="200px">Activities</th>
                                    <th width="150px">Shift Desc</th>
                                    <th width="150px">New Shift Desc</th>
                                    <?php else : ?>
                                    <th width="100px">Time OUT</th>
                                    <th width="200px">Shift Desc</th>
                                    <th width="200px">New Shift Desc</th>
                                    <?php endif; ?>
                                    <th width="100px">Cancel</th>
                                </tr>
                                <?php
                                    $appmd_count = count($appmd_data);
                                    $appmd_count = count($appmd_data);

                                    foreach ($appmd_data as $key => $value) :
                                        $shifts2 = $mainsql->get_shift($value['NewShiftDesc']);
                                        $chkmditem = $mainsql->check_appexpire($value['DTRDate']);
                                        if ($chkmditem) : $chkexpiremd++; endif;
                                        ?>
                                        <tr>
                                            <?php $timearray = preg_split('/\s+/', trim($value['TimeIn'])); $timearray2 = preg_split('/\s+/', trim($value['TimeOUt'])); ?>
                                            <td><?php echo date('F j, Y', strtotime($value['DTRDate'])); ?></td>
                                            <td><?php echo $value['Day']; ?></td>
                                            <td><?php echo $timearray[3] ? date('g:ia', strtotime($timearray[3])) : ''; ?></td>
                                            <?php if ($value['Activities']) : ?>
                                            <td><?php echo $value['Activities']; ?></td>
                                            <?php else : ?>
                                            <td><?php echo $timearray[3] ? date('g:ia', strtotime($timearray2[3])) : ''; ?></td>
                                            <?php endif; ?>
                                            <td><?php echo $value['ShiftDesc']; ?></td>
                                            <td><?php echo $value['NewShiftDesc'] ? $shifts2[0]['ShiftDesc'] : 'REST DAY'; ?></td>
                                            <td class="centertalign"><?php if ($appmd_count > 1) : ?><i class="btnmdcancel fa fa-times redtext cursorpoint" attribute="<?php echo $refnum; ?>" attribute2="<?php echo date('Y-m-d 00:00:00.000', strtotime($value['DTRDate'])); ?>"></i><?php endif; ?></td>
                                        </tr>
                                        <?php
                                        $pdtrto = strtotime($value['DTRDate']);
                                    endforeach;

                                    $chkexpire = $chkexpiremd ? 1 : 0;
                                ?>
                            </table>
                        </div>
                        </td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['DateStart']);

            elseif ($doctype == 'SC') :
                $application_data = $tblsql->get_mrequest(8, $refnum);
                //var_dump($application_data);

                $chkexpiresc = 0;

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.WEB.'/uploads/sc/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($notification_data[0]['DateFiled'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Remarks</b></td>
                        <td><?php echo $application_data[0]['REMARKS']; ?></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                        <div class="divtsdata width100per notidatadiv">
                            <table class="tdatablk">
                                <tr>
                                    <th width="100px">DTR Date</th>
                                    <th width="200px">Current Shift Desc</th>
                                    <th width="200px">New Shift Desc</th>
                                    <th width="150px">Shift Time IN</th>
                                    <th width="150px">Shift Time OUT</th>
                                    <th width="80px">Cancel</th>
                                </tr>
                                <?php
                                    //$ts_data = $tblsql->get_nrequest(8, $refnum);
                                    $appts_data = $tblsql->get_tsdata($refnum);
                                    $appts_count = count($appts_data);
                                    foreach ($appts_data as $key => $value) :
                                        $oldshiftdesc = $mainsql->get_shift($value['ShiftID']);
                                        $oldshift = $oldshiftdesc[0]['ShiftDesc'] ? $oldshiftdesc[0]['ShiftDesc'] : $value['ShiftID'];
                                        $chkscitem = $mainsql->check_appexpire($value['DTRDate']);
                                        if ($chkscitem) : $chkexpiresc++; endif;
                                        ?>
                                        <tr>
                                            <td><?php echo date('M j, Y', strtotime($value['DTRDate'])); ?></td>
                                            <td><?php echo $value['ShiftID'] ? $oldshift : 'REST DAY'; ?></td>
                                            <td><?php echo $value['NewShiftDesc'] ? $value['NewShiftDesc'] : 'REST DAY'; ?></td>
                                            <td><?php echo $value['TimeIn'] ? date('g:ia', strtotime($value['TimeIn'])) : 'N/A'; ?></td>
                                            <td><?php echo $value['TimeOut'] ? date('g:ia', strtotime($value['TimeOut'])) : 'N/A'; ?></td>
                                            <td class="centertalign"><?php if ($appts_count > 1) : ?><i class="btnsccancel fa fa-times redtext cursorpoint" attribute="<?php echo $refnum; ?>" attribute2="<?php echo date('Y-m-d 00:00:00.000', strtotime($value['DTRDate'])); ?>"></i><?php endif; ?></td>
                                        </tr>
                                        <?php
                                        $pdtrto = strtotime($value['DTRDate']);
                                    endforeach;

                                    $chkexpire = $chkexpiresc ? 1 : 0;
                                ?>
                            </table>
                        </div>
                        </td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['DateStart']);
            elseif ($doctype == 'TS') :
                $application_data = $tblsql->get_mrequest(5, $refnum);
                //var_dump($application_data);

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.WEB.'/uploads/sc/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($notification_data[0]['DateFiled'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>DTR Date</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['DateCovered'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Current Shift Desc</b></td>
                        <td><?php echo $application_data[0]['ChangeSchedFrom']; ?></td>
                    </tr>
                    <tr>
                        <td><b>New Shift Desc</b></td>
                        <td><?php echo $application_data[0]['ChangeSchedTo']; ?></td>
                    </tr>
                    <tr>
                        <td><b>Reason</b></td>
                        <td><?php echo stripslashes($application_data[0]['Reason']); ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['DateStart']);

            elseif ($doctype == 'LU') :
                $application_data = $tblsql->get_nrequest(9, $refnum);

                $chkexpire = $mainsql->check_appexpire($application_data[0]['DtrDate']);

                ?>
                    <?php if ($attachment_data) : ?>
                    <tr>
                        <td width="25%"><b>Attachment/s</b></td>
                        <td width="75%"><?php
                            foreach ($attachment_data as $key => $value) :
                                echo '<a href="'.WEB.'/uploads/ot/'.$value['AttachFile'].'" target="_blank">'.$value['AttachFile'].'</a><br>';
                            endforeach;
                        ?>
                        </td>
                    </tr>
                    <?php endif; ?>

                    <?php if ($notification_data[0]['EmpID'] == $profile_idnum && $notification_data[0]['Approved'] != 3 && $notification_data[0]['Approved'] != 2) : ?>
                    <!--tr>
                        <td width="25%">&nbsp;</td>
                        <td width="75%"><a href="<?php echo WEB; ?>/otpdf?id=<?php echo $refnum; ?>" target="_blank"><button class="btn">Print OT Form</button></a></td>
                    </tr-->
                    <?php endif; ?>

                    <tr>
                        <td width="25%"><b>Status</b><input type="hidden" id="dbname" name="dbname" value="<?php echo $notification_data[0]['DBNAME'] ?>" /></td>
                        <td width="75%"><?php
                            if ($notification_data[0]['Approved'] == 2) :
                                echo "<span class='redtext'>REJECTED</span>";
                            elseif ($notification_data[0]['Approved'] == 1) :
                                echo "<span class='greentext'>APPROVED</span>";
                            elseif ($notification_data[0]['Approved'] == 3) :
                                echo "<span class='redtext'>CANCELLED</span>";
                            else :
                                echo "FOR APPROVAL";
                            endif;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date Applied</b></td>
                        <td><?php echo date('F j, Y | g:ia', strtotime($application_data[0]['ReqDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>DTR Date</b></td>
                        <td><?php echo date('F j, Y', strtotime($application_data[0]['DtrDate'])); ?></td>
                    </tr>
                    <tr>
                        <td><b>Type</b></td>
                        <td><?php echo $application_data[0]['LUType']; ?></td>
                    </tr>
                    <tr>
                        <td><b>Applied Hours</b></td>
                        <td><?php echo $application_data[0]['LUHrs']; ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['DtrDate']);
                $pdtrto = strtotime($application_data[0]['DtrDate']);

            endif;

            ?>

                    <?php
                        $ifposted = $mainsql->get_posted($pdtrfrom, $pdtrto, $profile_comp);
                        $thisisposted = $ifposted[0]['AttPost'] ? 1 : 0;
                    ?>

                    <tr>
                        <td colspan="2">
                            <div class="hrborder">&nbsp;</div>
                        </td>
                    </tr>

                    <?php
                    if ($notification_data[0]['Approved'] == 3) :
                        ?>
                        <tr>
                            <td><b>Status</b></td>
                            <td>CANCELLED</td>
                        </tr>
                        <tr>
                            <td><b>Date</b></td>
                            <td><?php echo date('F j, Y | g:ia', strtotime($notification_data[0]['RejectedDate'])); ?></td>
                        </tr>
                        <?php
                    else :
                        ?>

                        <?php if ($notification_data[0]['Approved'] != 3) : ?>
                        <?php if (trim($notification_data[0]['Signatory01'])) : ?>
                        <tr>
                            <td><b>Signatory 1</b></td>
                            <td><?php echo $approver_data1[0]['FName'].' '.$approver_data1[0]['LName']; ?></td>
                        </tr>
                        <tr>
                            <?php //var_dump($notification_data[0]['Signatory01']); ?>
                            <?php if ($notification_data[0]['Signatory01'] == $profile_idnum) : ?>
                            <td><b><?php echo $notification_data[0]['ApprovedDate01'] ? 'Status' : '&nbsp;'; ?></b></td>
                            <td>
                                <?php if (!$notification_data[0]['ApprovedDate01'] && $notification_data[0]['Approved'] != 2) : ?>
                                    <?php if ($doctype == 'OT') : ?>
                                        <script type="text/javascript">// slider
                                            $(".approvehours").spinner({
                                              step: 0.5,
                                              spin: function( event, ui ) {
                                                if ( ui.value > <?php echo $application_data[0]['Hrs']; ?> ) {
                                                  $(this).spinner( "value", <?php echo $application_data[0]['Hrs']; ?> );
                                                  return false;
                                                } else if ( ui.value < 0 ) {
                                                  $(this).spinner( "value", 0 );
                                                  return false;
                                                }
                                              }
                                            });
                                        </script>
                                        <b>Approve Hour/s</b> <input type="text" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs'] < $application_data[0]['Hrs'] ? $application_data[0]['ApprovedHrs'] :  $application_data[0]['Hrs']; ?>" class="approvehours txtbox width50 righttalign" readonly />
                                    <?php endif; ?>
                                    <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10" />
                                    <?php if (!$chkexpire) : ?>
                                    <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory01']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME01'] ? $notification_data[0]['DB_NAME01'] : 0; ?>"<?php if ($notification_data[0]['Signatory02']) : ?> attribute21="<?php echo $notification_data[0]['Signatory02'] ? $notification_data[0]['Signatory02'] : 0; ?>" attribute22="<?php echo $notification_data[0]['DB_NAME02'] ? $notification_data[0]['DB_NAME02'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
                                    <?php endif; ?>
                                    <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory01']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME01'] ? $notification_data[0]['DB_NAME01'] : 0; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" />
                                <?php else : ?>
                                    <?php if ($notification_data[0]['ApprovedDate01'] != NULL) : ?>
                                        <?php if ($notification_data[0]['Approved'] != 2) : ?>
                                            APPROVED BY YOU
                                        <?php else : ?>
                                            REJECTED
                                        <?php endif; ?>
                                    <?php else : ?>
                                        TO BE APPROVED BY YOU
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <?php else : ?>
                            <td><b>Status</b></td>
                            <td><?php
                                if ($notification_data[0]['ApprovedDate01']) :
                                    echo 'APPROVED';
                                else :
                                    if ($notification_data[0]['Approved'] == 2) :
                                        echo 'REJECTED';
                                    else :
                                        echo 'TO BE APPROVED';
                                    endif;
                                endif; ?><span id="remarks" name="remarks">&nbsp;</span></td>
                            <?php endif; ?>
                        </tr>
                        <?php if ($notification_data[0]['ApprovedDate01']) : ?>
                        <tr>
                            <td><b>Date</b></td>
                            <td><?php echo date("F j, Y | g:ia", strtotime($notification_data[0]['ApprovedDate01'])); ?></td>
                        </tr>
                            <?php if (trim($notification_data[0]['Remarks01'])) : ?>
                            <tr>
                                <td><b>Remarks</b></td>
                                <td><?php echo $mainsql->truncate($notification_data[0]['Remarks01'], 50); ?></td>
                            </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php if (trim($notification_data[0]['Signatory02'])) : ?>
                        <tr>
                            <td><b>Signatory 2</b></td>
                            <td><?php echo $approver_data2[0]['FName'].' '.$approver_data2[0]['LName']; ?></td>
                        </tr>
                        <tr>
                            <?php if ($notification_data[0]['Signatory02'] == $profile_idnum) : ?>
                            <td><b><?php echo $notification_data[0]['ApprovedDate02'] ? 'Status' : '&nbsp;'; ?></b></td>
                            <td>
                                <?php if (!$notification_data[0]['ApprovedDate02'] && $notification_data[0]['ApprovedDate01'] && $notification_data[0]['Approved'] != 2) : ?>
                                    <?php if ($doctype == 'OT') : ?>
                                        <script type="text/javascript">// slider
                                            $(".approvehours").spinner({
                                              step: 0.5,
                                              spin: function( event, ui ) {
                                                if ( ui.value > <?php echo $application_data[0]['Hrs']; ?> ) {
                                                  $(this).spinner( "value", <?php echo $application_data[0]['Hrs']; ?> );
                                                  return false;
                                                } else if ( ui.value < 0 ) {
                                                  $(this).spinner( "value", 0 );
                                                  return false;
                                                }
                                              }
                                            });
                                        </script>
                                        <b>Approve Hour/s</b> <input type="text" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs'] < $application_data[0]['Hrs'] ? $application_data[0]['ApprovedHrs'] :  $application_data[0]['Hrs']; ?>" class="approvehours txtbox width50 righttalign" readonly />
                                        <!--input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" /-->
                                    <?php endif; ?>
                                    <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10" />
                                    <?php if (!$chkexpire) : ?>
                                    <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory02']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME02'] ? $notification_data[0]['DB_NAME02'] : 0; ?>"<?php if ($notification_data[0]['Signatory03']) : ?> attribute21="<?php echo $notification_data[0]['Signatory03'] ? $notification_data[0]['Signatory03'] : 0; ?>" attribute22="<?php echo $notification_data[0]['DB_NAME03'] ? $notification_data[0]['DB_NAME03'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
                                    <?php endif; ?>
                                    <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory02']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME02'] ? $notification_data[0]['DB_NAME02'] : 0; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" />
                                <?php else : ?>
                                    <?php if ($notification_data[0]['ApprovedDate02'] != NULL) : ?>
                                        <?php if ($notification_data[0]['Approved'] != 2) : ?>
                                            APPROVED BY YOU
                                        <?php else : ?>
                                            REJECTED
                                        <?php endif; ?>
                                    <?php else : ?>
                                        TO BE APPROVED BY YOU
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <?php else : ?>
                            <td><b>Status</b></td>
                            <td><?php
                                if ($notification_data[0]['ApprovedDate02']) :
                                    echo 'APPROVED';
                                else :
                                    if ($notification_data[0]['Approved'] == 2) :
                                        echo 'REJECTED';
                                    else :
                                        echo 'TO BE APPROVED';
                                    endif;
                                endif; ?><span id="remarks" name="remarks">&nbsp;</span></td>
                            <?php endif; ?>
                        </tr>
                        <?php if ($notification_data[0]['ApprovedDate02']) : ?>
                        <tr>
                            <td><b>Date</b></td>
                            <td><?php echo date("F j, Y | g:ia", strtotime($notification_data[0]['ApprovedDate02'])); ?></td>
                        </tr>
                            <?php if (trim($notification_data[0]['Remarks02'])) : ?>
                            <tr>
                                <td><b>Remarks</b></td>
                                <td><?php echo $mainsql->truncate($notification_data[0]['Remarks02'], 50); ?></td>
                            </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php if (trim($notification_data[0]['Signatory03'])) : ?>
                        <tr>
                            <td><b>Signatory 3</b></td>
                            <td><?php echo $approver_data3[0]['FName'].' '.$approver_data3[0]['LName']; ?></td>
                        </tr>
                        <tr>
                            <?php if ($notification_data[0]['Signatory03'] == $profile_idnum) : ?>
                            <td><b><?php echo $notification_data[0]['ApprovedDate03'] ? 'Status' : '&nbsp;'; ?></b></td>
                            <td>
                                <?php if (!$notification_data[0]['ApprovedDate03'] && $notification_data[0]['ApprovedDate02'] && $notification_data[0]['Approved'] != 2) : ?>
                                    <?php if ($doctype == 'OT') : ?>
                                        <script type="text/javascript">// slider
                                            $(".approvehours").spinner({
                                              step: 0.5,
                                              spin: function( event, ui ) {
                                                if ( ui.value > <?php echo $application_data[0]['Hrs']; ?> ) {
                                                  $(this).spinner( "value", <?php echo $application_data[0]['Hrs']; ?> );
                                                  return false;
                                                } else if ( ui.value < 0 ) {
                                                  $(this).spinner( "value", 0 );
                                                  return false;
                                                }
                                              }
                                            });
                                        </script>
                                        <b>Approve Hour/s</b> <input type="text" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs'] < $application_data[0]['Hrs'] ? $application_data[0]['ApprovedHrs'] :  $application_data[0]['Hrs']; ?>" class="approvehours txtbox width50 righttalign" readonly />
                                        <!--input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" /-->
                                    <?php endif; ?>
                                    <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10" />
                                    <?php if (!$chkexpire) : ?>
                                    <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory03']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME03'] ? $notification_data[0]['DB_NAME03'] : 0; ?>"<?php if ($notification_data[0]['Signatory04']) : ?> attribute21="<?php echo $notification_data[0]['Signatory04'] ? $notification_data[0]['Signatory04'] : 0; ?>" attribute22="<?php echo $notification_data[0]['DB_NAME04'] ? $notification_data[0]['DB_NAME04'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
                                    <?php endif; ?>
                                    <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory03']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME03'] ? $notification_data[0]['DB_NAME03'] : 0; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" />
                                <?php else : ?>
                                    <?php if ($notification_data[0]['ApprovedDate03'] != NULL) : ?>
                                        <?php if ($notification_data[0]['Approved'] != 2) : ?>
                                            APPROVED BY YOU
                                        <?php else : ?>
                                            REJECTED
                                        <?php endif; ?>
                                    <?php else : ?>
                                        TO BE APPROVED BY YOU
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <?php else : ?>
                            <td><b>Status</b></td>
                            <td><?php
                                if ($notification_data[0]['ApprovedDate03']) :
                                    echo 'APPROVED';
                                else :
                                    if ($notification_data[0]['Approved'] == 2) :
                                        echo 'REJECTED';
                                    else :
                                        echo 'TO BE APPROVED';
                                    endif;
                                endif; ?><span id="remarks" name="remarks">&nbsp;</span></td>
                            <?php endif; ?>
                        </tr>
                        <?php if ($notification_data[0]['ApprovedDate03']) : ?>
                        <tr>
                            <td><b>Date</b></td>
                            <td><?php echo date("F j, Y | g:ia", strtotime($notification_data[0]['ApprovedDate03'])); ?></td>
                        </tr>
                            <?php if (trim($notification_data[0]['Remarks03'])) : ?>
                            <tr>
                                <td><b>Remarks</b></td>
                                <td><?php echo $mainsql->truncate($notification_data[0]['Remarks03'], 50); ?></td>
                            </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php if (trim($notification_data[0]['Signatory04'])) : ?>
                        <tr>
                            <td><b>Signatory 4</b></td>
                            <td><?php echo $approver_data4[0]['FName'].' '.$approver_data4[0]['LName']; ?></td>
                        </tr>
                        <tr>
                            <?php if ($notification_data[0]['Signatory04'] == $profile_idnum) : ?>
                            <td><b><?php echo $notification_data[0]['ApprovedDate04'] ? 'Status' : '&nbsp;'; ?></b></td>
                            <td>
                                <?php if (!$notification_data[0]['ApprovedDate04'] && $notification_data[0]['ApprovedDate03'] && $notification_data[0]['Approved'] != 2) : ?>
                                    <?php if ($doctype == 'OT') : ?>
                                        <script type="text/javascript">// slider
                                            $(".approvehours").spinner({
                                              step: 0.5,
                                              spin: function( event, ui ) {
                                                if ( ui.value > <?php echo $application_data[0]['Hrs']; ?> ) {
                                                  $(this).spinner( "value", <?php echo $application_data[0]['Hrs']; ?> );
                                                  return false;
                                                } else if ( ui.value < 0 ) {
                                                  $(this).spinner( "value", 0 );
                                                  return false;
                                                }
                                              }
                                            });
                                        </script>
                                        <b>Approve Hour/s</b> <input type="text" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs'] < $application_data[0]['Hrs'] ? $application_data[0]['ApprovedHrs'] :  $application_data[0]['Hrs']; ?>" class="approvehours txtbox width50 righttalign" readonly />
                                        <!--input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" /-->
                                    <?php endif; ?>
                                    <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10" />
                                    <?php if (!$chkexpire) : ?>
                                    <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory04']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME04'] ? $notification_data[0]['DB_NAME04'] : 0; ?>"<?php if ($notification_data[0]['Signatory05']) : ?> attribute21="<?php echo $notification_data[0]['Signatory05'] ? $notification_data[0]['Signatory05'] : 0; ?>" attribute22="<?php echo $notification_data[0]['DB_NAME05'] ? $notification_data[0]['DB_NAME05'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
                                    <?php endif; ?>
                                    <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory04']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME04'] ? $notification_data[0]['DB_NAME04'] : 0; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" />
                                <?php else : ?>
                                    <?php if ($notification_data[0]['ApprovedDate04'] != NULL) : ?>
                                        <?php if ($notification_data[0]['Approved'] != 2) : ?>
                                            APPROVED BY YOU
                                        <?php else : ?>
                                            REJECTED
                                        <?php endif; ?>
                                    <?php else : ?>
                                        TO BE APPROVED BY YOU
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <?php else : ?>
                            <td><b>Status</b></td>
                            <td><?php
                                if ($notification_data[0]['ApprovedDate04']) :
                                    echo 'APPROVED';
                                else :
                                    if ($notification_data[0]['Approved'] == 2) :
                                        echo 'REJECTED';
                                    else :
                                        echo 'TO BE APPROVED';
                                    endif;
                                endif; ?><span id="remarks" name="remarks">&nbsp;</span></td>
                            <?php endif; ?>
                        </tr>
                        <?php if ($notification_data[0]['ApprovedDate04']) : ?>
                        <tr>
                            <td><b>Date</b></td>
                            <td><?php echo date("F j, Y | g:ia", strtotime($notification_data[0]['ApprovedDate04'])); ?></td>
                        </tr>
                            <?php if (trim($notification_data[0]['Remarks04'])) : ?>
                            <tr>
                                <td><b>Remarks</b></td>
                                <td><?php echo $mainsql->truncate($notification_data[0]['Remarks04'], 50); ?></td>
                            </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php if (trim($notification_data[0]['Signatory05'])) : ?>
                        <tr>
                            <td><b>Signatory 5</b></td>
                            <td><?php echo $approver_data5[0]['FName'].' '.$approver_data5[0]['LName']; ?></td>
                        </tr>
                        <tr>
                            <?php if ($notification_data[0]['Signatory05'] == $profile_idnum) : ?>
                            <td><b><?php echo $notification_data[0]['ApprovedDate05'] ? 'Status' : '&nbsp;'; ?></b></td>
                            <td>
                                <?php if (!$notification_data[0]['ApprovedDate05'] && $notification_data[0]['ApprovedDate04'] && $notification_data[0]['Approved'] != 2) : ?>
                                    <?php if ($doctype == 'OT') : ?>
                                        <script type="text/javascript">// slider
                                            $(".approvehours").spinner({
                                              step: 0.5,
                                              spin: function( event, ui ) {
                                                if ( ui.value > <?php echo $application_data[0]['Hrs']; ?> ) {
                                                  $(this).spinner( "value", <?php echo $application_data[0]['Hrs']; ?> );
                                                  return false;
                                                } else if ( ui.value < 0 ) {
                                                  $(this).spinner( "value", 0 );
                                                  return false;
                                                }
                                              }
                                            });
                                        </script>
                                        <b>Approve Hour/s</b> <input type="text" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs'] < $application_data[0]['Hrs'] ? $application_data[0]['ApprovedHrs'] :  $application_data[0]['Hrs']; ?>" class="approvehours txtbox width50 righttalign" readonly />
                                        <!--input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" /-->
                                    <?php endif; ?>
                                    <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10" />
                                    <?php if (!$chkexpire) : ?>
                                    <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory05']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME05'] ? $notification_data[0]['DB_NAME05'] : 0; ?>"<?php if ($notification_data[0]['Signatory06']) : ?> attribute21="<?php echo $notification_data[0]['Signatory06'] ? $notification_data[0]['Signatory06'] : 0; ?>" attribute22="<?php echo $notification_data[0]['DB_NAME06'] ? $notification_data[0]['DB_NAME06'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
                                    <?php endif; ?>
                                    <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory05']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME05'] ? $notification_data[0]['DB_NAME05'] : 0; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" />
                                <?php else : ?>
                                    <?php if ($notification_data[0]['ApprovedDate05'] != NULL) : ?>
                                        <?php if ($notification_data[0]['Approved'] != 2) : ?>
                                            APPROVED BY YOU
                                        <?php else : ?>
                                            REJECTED
                                        <?php endif; ?>
                                    <?php else : ?>
                                        TO BE APPROVED BY YOU
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <?php else : ?>
                            <td><b>Status</b></td>
                            <td><?php
                                if ($notification_data[0]['ApprovedDate05']) :
                                    echo 'APPROVED';
                                else :
                                    if ($notification_data[0]['Approved'] == 2) :
                                        echo 'REJECTED';
                                    else :
                                        echo 'TO BE APPROVED';
                                    endif;
                                endif; ?><span id="remarks" name="remarks">&nbsp;</span></td>
                            <?php endif; ?>
                        </tr>
                        <?php if ($notification_data[0]['ApprovedDate05']) : ?>
                        <tr>
                            <td><b>Date</b></td>
                            <td><?php echo date("F j, Y | g:ia", strtotime($notification_data[0]['ApprovedDate05'])); ?></td>
                        </tr>
                            <?php if (trim($notification_data[0]['Remarks05'])) : ?>
                            <tr>
                                <td><b>Remarks</b></td>
                                <td><?php echo $mainsql->truncate($notification_data[0]['Remarks05'], 50); ?></td>
                            </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php if (trim($notification_data[0]['Signatory06'])) : ?>
                        <tr>
                            <td><b>Signatory 6</b></td>
                            <td><?php echo $approver_data6[0]['FName'].' '.$approver_data6[0]['LName']; ?></td>
                        </tr>
                        <tr >
                            <?php if ($notification_data[0]['Signatory06'] == $profile_idnum) : ?>
                            <td><b><?php echo $notification_data[0]['ApprovedDate06'] ? 'Status' : '&nbsp;'; ?></b></td>
                            <td>
                                <?php if (!$notification_data[0]['ApprovedDate06'] && $notification_data[0]['ApprovedDate05'] && $notification_data[0]['Approved'] != 2) : ?>
                                    <?php if ($doctype == 'OT') : ?>
                                        <script type="text/javascript">// slider
                                            $(".approvehours").spinner({
                                              step: 0.5,
                                              spin: function( event, ui ) {
                                                if ( ui.value > <?php echo $application_data[0]['Hrs']; ?> ) {
                                                  $(this).spinner( "value", <?php echo $application_data[0]['Hrs']; ?> );
                                                  return false;
                                                } else if ( ui.value < 0 ) {
                                                  $(this).spinner( "value", 0 );
                                                  return false;
                                                }
                                              }
                                            });
                                        </script>
                                        <b>Approve Hour/s</b> <input type="text" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs'] < $application_data[0]['Hrs'] ? $application_data[0]['ApprovedHrs'] :  $application_data[0]['Hrs']; ?>" class="approvehours txtbox width50 righttalign" readonly />
                                        <!--input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" /-->
                                    <?php endif; ?>
                                    <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10" />
                                    <?php if (!$chkexpire) : ?>
                                    <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory06']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME06'] ? $notification_data[0]['DB_NAME06'] : 0; ?>" attribute21="0" attribute22="0" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
                                    <?php endif; ?>
                                    <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory06']; ?>" attribute20="<?php echo $notification_data[0]['DB_NAME06'] ? $notification_data[0]['DB_NAME06'] : 0; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="smlbtn btnred" />
                                <?php else : ?>
                                    <?php if ($notification_data[0]['ApprovedDate06'] != NULL) : ?>
                                        <?php if ($notification_data[0]['Approved'] != 2) : ?>
                                            APPROVED BY YOU
                                        <?php else : ?>
                                            REJECTED
                                        <?php endif; ?>
                                    <?php else : ?>
                                        TO BE APPROVED BY YOU
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <?php else : ?>
                            <td><b>Status</b></td>
                            <td><?php
                                if ($notification_data[0]['ApprovedDate06']) :
                                    echo 'APPROVED';
                                else :
                                    if ($notification_data[0]['Approved'] == 2) :
                                        echo 'REJECTED';
                                    else :
                                        echo 'TO BE APPROVED';
                                    endif;
                                endif; ?><span id="remarks" name="remarks">&nbsp;</span></td>
                            <?php endif; ?>
                        </tr>
                        <?php if ($notification_data[0]['ApprovedDate06']) : ?>
                        <tr>
                            <td><b>Date</b></td>
                            <td><?php echo date("F j, Y | g:ia", strtotime($notification_data[0]['ApprovedDate06'])); ?></td>
                        </tr>
                            <?php if (trim($notification_data[0]['Remarks06'])) : ?>
                            <tr>
                                <td><b>Remarks</b></td>
                                <td><?php echo $mainsql->truncate($notification_data[0]['Remarks06'], 50); ?></td>
                            </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php if ($notification_data[0]['EmpID'] == $profile_idnum && $notification_data[0]['Approved'] != 2) : ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td><input id="btncancel" type="button" name="btncancel" value="Cancel" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['EmpID']; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btncancel btnred smlbtn" /></td>
                        </tr>
                        <?php endif; ?>
                        <?php endif; ?>

                        <?php if ($chkexpire && $notification_data[0]['Approved'] == 0) : ?>
                        <tr>
                            <td colspan="2" class="centertalign redbg"><span class="whitetext bold">APPLICATION EXPIRED</span></td>
                        </tr>
                        <?php endif; ?>

                    <?php endif; ?>

                    <?php if ($thisisposted) : ?>
                    <tr>
                        <td colspan="2" class="centertalign redbg"><span class="whitetext bold">POSTED</span></td>
                    </tr>
                    <?php endif; ?>
                </table>

            <?php

            //var_dump($approver_data1);

        break;
        default:
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";

    }

?>
