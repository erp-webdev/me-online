<?php

    include("../config.php");
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

?>
// JavaScript Document

function parallax(){
    var scrolled = $(window).scrollTop();
    $('.splashbg').css('top', (-(scrolled * 0.2) + 20) + 'px');
}

function changeUrl(page, url) {
    if (typeof (history.pushState) != "undefined") {
        var obj = { Page: page, Url: url };
        history.pushState(obj, obj.Page, obj.Url);
    } else {
        alert("Browser does not support HTML5.");
    }
}

/* DISABLE LINK */

function clickAndDisable(link) {
    link.onclick = function(event) {
        event.preventDefault();
    }
}

/* REGISTRATION */

function upperCase(strInput) {
    var theString = strInput.value;
    var strOutput = "";// Our temporary string used to build the function's output
    theString = theString.toUpperCase();
    strOutput = theString;
    strInput.value = strOutput;
}

function updatePos(strInput) {
    theString = strInput.selectedIndex;
    strValue = document.getElementsByTagName("option")[theString].text;
    strOutput = "";
    strValue = strValue.toUpperCase();
    strOutput = strValue;
    document.getElementById('comp_position').value = strOutput;
}

function updatePos2(strInput) {
    var theString = strInput.value;
    var strOutput = "";
    theString = theString.toUpperCase();
    strOutput = theString;
    document.getElementById('comp_position').value = strOutput;
}

function updateHired(strInput) {
    var theString = strInput.value;
    var strOutput = "";
    theString = theString.toUpperCase();
    strOutput = theString;
    document.getElementById('comp_from').value = strOutput;
}

function positionChk(val) {
    var p = val;
    if (p.options[p.selectedIndex].value == 1000000)
    {
        document.getElementById('divotherpos').style.display = "inline-block";
    }
    else
    {
        document.getElementById('divotherpos').style.display = "none";
    }
    return false;
}

function checkID(empID) {
    var theID = empID.value;
    $.ajax(
    {
        url: "<?php echo WEB; ?>/lib/requests/reg_request.php?sec=checkid",
        data: "id=" + theID,
        type: "POST",
        complete: function(){
            $("#loading").hide();
        },
        success: function(data) {
            if (data != 0) {
                $('#checkIDerr').html("Someone already used this employee ID");
            }
            else {
                $('#checkIDerr').html("");
            }
        }
    })
}

/* HIDE OVERLAY */
function hideOverlay() {
    $(".floatdiv").addClass("invisible");
}

/* COMMENT */
function chkCommentTxt() {
    if ($('#comment_message').val().length < 2)
    {
        $("#btncreatecomment").addClass("invisible");
    }
    else
    {
        $("#btncreatecomment").removeClass("invisible");
    }
}


$(function() {

    // scrollable
    $(window).scroll(function(){
        parallax();
    });


    // LATEST CYCLE
    $('#dashlatest').cycle({
        fx: 'scrollRight',
        next: '#right',
        delay: -4000,
        easing: 'easeInOutBack'
    });

    /* TOOLTIP */
    $(function() {
        $('.tooltip').tooltip();
    });

	/* MAIN NAVIGATION */

	$("#subapp").hover(function() {
		$(".appsubmenu").show();
	},function() {
		$(".appsubmenu").hide();
	});

    /* TABS */

    $("#tabs").tabs();

    /* FLIP */
    $("#cards").flip({
        trigger: 'manual'
    });
    $(".btnreg").click(function() {
        $("#cards").flip(true);
    });
    $(".btnreg2").click(function() {
        $("#cards").flip(false);
        return false;
    });

    /* FLOAT DIV CONTROL */

    /* Birthday */
    $(".btnbday").on("click", function() {
		$(".mfloatdiv").removeClass("invisible");
		$("#bdayview").removeClass("invisible");

        empid = $(this).attr('attribute');

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/reg_request.php?sec=bday",
	        data: "empid=" + empid,
	        type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	            var obj = $.parseJSON(data);
                $("#bday_subject").html(obj.bday_subject);
                $("#bday_full").html(obj.bday_empname);
                $("#bday_email").val(obj.bday_email);
                $("#bday_tonickname").val(obj.bday_empnick);
	        }
	    })

	    return false;
    });

    /* Profile */

    $("#chksameadd").on("click", function() {

        if($("#chksameadd:checked").length) {
            $("#PermUnitStreet").val($("#UnitStreet").val());
            $("#PermBarangay").val($("#Barangay").val());
            $("#PermTownCity").val($("#TownCity").val());
            $("#PermStateProvince").val($("#StateProvince").val());
            $("#PermZip").val($("#Zip").val());
        }
        else {
            $("#PermUnitStreet").val('');
            $("#PermBarangay").val('');
            $("#PermTownCity").val('');
            $("#PermStateProvince").val('');
            $("#PermZip").val('');
        }

    });

    $(".samewithadd").on("click", function() {

        if($(".samewithadd:checked").length) {
            personaladd = $("#UnitStreet").val() + ', ' + $("#Barangay").val() + ', ' + $("#TownCity").val() + ', ' + $("#StateProvince").val() + ' ' + $("#Zip").val();
            $("#ContactAddress").val(personaladd);
        }
        else {
            $("#ContactAddress").val('');
        }

    });

    $("#NumDependent").change(function() {
        numdep = $("#NumDependent option:selected").val();
        empid = $("#dempid").val();
        dbname = $("#ddbname").val();
        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/empupdate_request.php?sec=numdep",
            data: "numdep=" + numdep + "&empid=" + empid + "&dbname=" + dbname,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#divdependent").html(data);

            }
        })
    });


    $(".deldept").on("click", function() {

        var r = confirm("Are you sure you want to remove this dependent?");

		if (r == true)
		{

            depid = $(this).attr('attribute');
            emphash = $(this).attr('attribute2');

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/empupdate_request.php?sec=deldep",
                data: "depid=" + depid,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {

                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/empupdate_request.php?sec=empdep",
                        data: "emphash=" + emphash,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {
                            $("#udivdependent").html(data);

                        }
                    })

                }
            })
        }
    });

    /* Notification */

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
        if($(".chkapp:checked").length) {
            $("#btnapprchk").removeClass('invisible');
        }
        else {
            $("#btnapprchk").addClass('invisible');
        }
    });

    $("#btnapprchk").on("click", function() {

        var r = confirm("Are you sure you want to approved all checked request?");

		if (r == true)
		{
            var massapprove_msg;

            var pendpage = $("#pendpage").val();

            $(this).addClass('invisible');

            error = 0;
            $(".chkapp:checked").each(function() {

                reqnbr = $(this).val();
                remarks = "Approved";
                doctype = $(this).attr("attribute");
                user = $(this).attr("attribute2");
                empid = $(this).attr("attribute3");
                approvehours = $(this).attr("attribute4");
                dbname = $(this).attr("attribute5");
                trans = 'APPROVED';

                if (approvehours != 0) {

                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=approve",
                        data: "trans=" + trans + "&remarks=" + remarks + "&doctype=" + doctype + "&reqnbr=" + reqnbr + "&user=" + user + "&empid=" + empid + "&approvehours=" + approvehours + "&dbname=" + dbname,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {
                            if (data == 1) {
                                error = error;
                            }
                            else {
                                error = error + 1;
                            }
                        }
                    })

                }
                else {

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
                                error = error;
                            }
                            else {
                                error = error + 1;
                            }
                        }
                    })
                }

            });

            if (error == 0) {

                alert('Request you\'ve checked has been<br>successfully completed.');
                $("#penddata").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

                pendtype = $("#pendtype").val();

                searchpend = $("#searchpend").val();
                pendfrom = $("#pendfrom").val();
                pendto = $("#pendto").val();

                $.ajax(
                {

                    url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=tablepend&page=" + pendpage,
                    data: "searchpend=" + searchpend + "&pendtype=" + pendtype + "&pendfrom=" + pendfrom + "&pendto=" + pendto,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {
                        $("#btnnotiall").removeClass("invisible");
                        $("#penddata").html(data);
                        changeUrl('', '<?php echo WEB; ?>/pending');
                    }
                });
            }
            else {

                alert("Not all checked request<br>has been approved.");
                $("#penddata").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

                $('#remarks').addClass("invisible");
                $('#btnapp').addClass("invisible");
                $('#btnrej').addClass("invisible");

                pendtype = $("#pendtype").val();

                searchpend = $("#searchpend").val();
                pendfrom = $("#pendfrom").val();
                pendto = $("#pendto").val();

                pendpage = $("#pendpage").val();

                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=tablepend&page=" + pendpage,
                    data: "searchpend=" + searchpend + "&pendtype=" + pendtype + "&pendfrom=" + pendfrom + "&pendto=" + pendto,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {
                        $("#btnpendall").removeClass("invisible");
                        $("#penddata").html(data);
                        changeUrl('', '<?php echo WEB; ?>/notification');
                    }
                });
            }

        }

    });

    $("#searchnoti").on("keypress", function(e) {
        if (e.keyCode == 13) {

            searchnoti = $("#searchnoti").val();
            notitype = $("#notitype").val();
            notifrom = $("#notifrom").val();
            notito = $("#notito").val();

            notipage = 1;

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=tablepend",
                data: "searchnoti=" + searchnoti + "&notitype=" + notitype + "&notifrom=" + notifrom + "&notito=" + notito,
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
    });

    $("#btnnoti").on("click", function() {

        searchnoti = $("#searchnoti").val();
        notitype = $("#notitype").val();
        notifrom = $("#notifrom").val();
        notito = $("#notito").val();

        notipage = 1;

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=tablepend",
            data: "searchnoti=" + searchnoti + "&notitype=" + notitype + "&notifrom=" + notifrom + "&notito=" + notito,
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
    });

    $("#btnnotiall").on("click", function() {

        notipage = 1;
        $(this).addClass("invisible");

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=tablepend",
            data: "clear_search=1",
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#searchnoti").val("");
                $("#notifrom").val("2014-08-01");
                $("#notito").val("<?php echo date("Y-m-d"); ?>");
                $("#btnnotiall").addClass("invisible");
                $("#notidata").html(data);
                changeUrl('', '<?php echo WEB; ?>/notification');
            }
        })
    });

    /* Pending */

    $("#searchpend").on("keypress", function(e) {
        if (e.keyCode == 13) {

            searchpend = $("#searchpend").val();
            pendtype = $("#pendtype").val();
            pendfrom = $("#pendfrom").val();
            pendto = $("#pendto").val();

            pendpage = 1;

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=tablepend",
                data: "searchpend=" + searchpend + "&pendtype=" + pendtype + "&pendfrom=" + pendfrom + "&pendto=" + pendto,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $("#btnpendall").removeClass("invisible");
                    $("#penddata").html(data);
                    changeUrl('', '<?php echo WEB; ?>/pending');
                }
            })
        }
    });

    $("#btnpend").on("click", function() {

        searchpend = $("#searchpend").val();
        pendtype = $("#pendtype").val();
        pendfrom = $("#pendfrom").val();
        pendto = $("#pendto").val();

        pendpage = 1;

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=tablepend",
            data: "searchpend=" + searchpend + "&pendtype=" + pendtype + "&pendfrom=" + pendfrom + "&pendto=" + pendto,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#btnpendall").removeClass("invisible");
                $("#penddata").html(data);
                changeUrl('', '<?php echo WEB; ?>/pending');
            }
        })
    });

    $("#btnpendall").on("click", function() {

        pendpage = 1;
        $(this).addClass("invisible");

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=tablepend",
            data: "clear_search=1",
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#searchpend").val("");
                $("#pendfrom").val("2014-08-01");
                $("#pendto").val("<?php echo date("Y-m-d"); ?>");
                $("#btnpendall").addClass("invisible");
                $("#penddata").html(data);
                changeUrl('', '<?php echo WEB; ?>/pending');
            }
        })
    });

    // Request Management - START

    $("#searchrman").on("keypress", function(e) {
        if (e.keyCode == 13) {

            $("#rmandata").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

            rmantype = $("#rmantype").val();
            searchrman = $("#searchrman").val();
            rmanfrom = $("#rmanfrom").val();
            rmanto = $("#rmanto").val();

            rmanpage = 1;

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=tablerman",
                data: "searchrman=" + searchrman + "&rmanfrom=" + rmanfrom + "&rmanto=" + rmanto + "&rmantype=" + rmantype,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $("#btnrmanall").removeClass("invisible");
                    $("#rmandata").html(data);
                    changeUrl('', '<?php echo WEB; ?>/reqman');
                }
            })
        }
    });

    $("#btnrman").on("click", function() {

        $("#rmandata").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

        rmantype = $("#rmantype").val();
        searchrman = $("#searchrman").val();
        rmanfrom = $("#rmanfrom").val();
        rmanto = $("#rmanto").val();

        rmanpage = 1;

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=tablerman",
            data: "searchrman=" + searchrman + "&rmanfrom=" + rmanfrom + "&rmanto=" + rmanto + "&rmantype=" + rmantype,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#btnrmanall").removeClass("invisible");
                $("#rmandata").html(data);
                changeUrl('', '<?php echo WEB; ?>/reqman');
            }
        })
    });

    $("#btnrmanall").on("click", function() {

        $("#rmandata").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

        rmanpage = 1;
        $(this).addClass("invisible");

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=tablerman",
            data: "clear_search=1",
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#rmantype").val(null);
                $("#searchrman").val("");
                $("#rmanfrom").val("2014-08-01");
                $("#rmanto").val("<?php echo date("Y-m-d"); ?>");
                $("#btnrmanall").addClass("invisible");
                $("#rmandata").html(data);
                changeUrl('', '<?php echo WEB; ?>/reqman');
            }
        })
    });

    // Request Management - END

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
            title = "Work from Home #";
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





	$(".btncoe").on("click", function() {

        id = $(this).attr('attribute');
        level = $(this).attr('attribute5');


		$("#coe_title").html('Certificate of Employment');
		$("#coefloat").removeClass("invisible");
		$("#coeview").show({
		  effect : 'slide',
		  easing : 'easeOutQuart',
		  direction : 'up',
		  duration : 500
		});

        $("#coedata").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=coeold",
            data: "id=" + id + "&level=" + level,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#coedata").html(data);
            }
        })
    });

	$("#coenewreq").on("click", function() {

		level = $(this).attr('attribute5');

		$("#coe_title").html('Certificate of Employment');
		$("#coefloat").removeClass("invisible");
		$("#coeview").show({
		  effect : 'slide',
		  easing : 'easeOutQuart',
		  direction : 'up',
		  duration : 500
		});

		$("#coedata").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

		$.ajax(
		{
			url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=coenew",
			data: "level=" + level,
			type: "POST",
			complete: function(){
				$("#loading").hide();
			},
			success: function(data) {
				$("#loading").hide();
				$("#coedata").html(data);
			}
		})
	});

	$("#coesearch").on("click", function() {

		ref_no = $("#coeref").val();

		$.ajax(
		{
			url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=coesearch",
			data: "ref_no=" + ref_no,
			type: "POST",
			complete: function(){
				$("#loading").hide();
			},
			success: function(data) {
				$("#loading").hide();
				$("#tablecoe").html(data);
			}
		})
	});

	$("#company_sort").on("change", function() {

		var company_sort = $("select[name=company_sort]").val();

		$.ajax(
		{
			url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=coesort",
			data: "company_sort=" + company_sort,
			type: "POST",
			complete: function(){
				$("#loading").hide();
			},
			success: function(data) {
				$("#loading").hide();
				$("#tablecoe").html(data);
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
            title = "Work from Home Application #";
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



    /* My Request */

    $("#mreqtype").change(function() {
        mtype = $("#mreqtype option:selected").val();
        mstatus = $("#mreqstatus").val();
        mfrom = $("#mreqfrom").val();
        mto = $("#mreqto").val();
        mrefnum = $("#mreqrefnum").val();
        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/myreq_request.php?sec=table",
            data: "mreqtype=" + mtype + "&mreqfrom=" + mfrom + "&mreqto=" + mto + "&mreqrefnum=" + mrefnum,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#mreqdata").html(data);

            }
        })
    });

    $("#mreqrefnum").on("keypress", function(e) {
        if (e.keyCode == 13) {
            mtype = $("#mreqtype option:selected").val();
            mstatus = $("#mreqstatus").val();
            mfrom = $("#mreqfrom").val();
            mto = $("#mreqto").val();
            mrefnum = $("#mreqrefnum").val();
            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/myreq_request.php?sec=table",
                data: "mreqtype=" + mtype + "&mreqfrom=" + mfrom + "&mreqto=" + mto + "&mreqrefnum=" + mrefnum,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $("#mreqdata").html(data);

                }
            })
        }
    });

    $("#btnmreq").on("click", function() {
        mtype = $("#mreqtype option:selected").val();
        mstatus = $("#mreqstatus").val();
        mfrom = $("#mreqfrom").val();
        mto = $("#mreqto").val();
        mrefnum = $("#mreqrefnum").val();
        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/myreq_request.php?sec=table",
            data: "mreqtype=" + mtype + "&mreqfrom=" + mfrom + "&mreqto=" + mto + "&mreqrefnum=" + mrefnum,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#mreqdata").html(data);

            }
        })
    });

    $("#btnmreqall").on("click", function() {
        mtype = $("#mreqtype option:selected").val();
        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/myreq_request.php?sec=table",
            data: "mreqtype=" + mtype + "&clear_search=1",
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#mreqdata").html(data);

            }
        })
    });

    /* ADS */

    $(".searchads").on("keypress", function(e) {
        if (e.keyCode == 13) {

            $(".btnsearchallads").removeClass('invisible');

            msearch = $("#searchads").val();

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/ads_request.php?sec=table",
                data:  "searchads=" + msearch,
                type: "POST",
                success: function(data) {
                    $("#adsdata").html(data);
                }
            })

            return false;
        }
	});

    $(".btnsearchads").on("click", function() {

        $(".btnsearchallads").removeClass('invisible');

        msearch = $("#searchads").val();

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/ads_request.php?sec=table",
            data:  "searchads=" + msearch,
            type: "POST",
            success: function(data) {
                $("#adsdata").html(data);
            }
        })

        return false;
	});

    $(".btnsearchallads").on("click", function() {

        $(this).addClass('invisible');
        $("#searchads").val('');

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/ads_request.php?sec=clear_search",
            type: "POST",
            success: function(data) {
                $("#adsdata").html(data);
            }
        })

        return false;
	});

	$(".btnviewads").on("click", function() {
        $("#adview_title").html("");
		$(".floatdiv").removeClass("invisible");
		$("#adview").show({
            effect : 'slide',
            easing : 'easeOutQuart',
            direction : 'up',
            duration : 500
        });
        $("#adadd").hide();
		$("#adedit").hide();

        actid = $(this).attr('attribute');
        actname = $(this).attr('attribute2');

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/ads_request.php?sec=view",
	        data: "actid=" + actid,
	        type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
                $("#adview_title").html(actname);
                $("#ads_data").html(data);
	        }
	    })

	    return false;
	});

    $(".btnaddads").on("click", function() {
        $(".adadd_msg").css("display","none");
        $("#activity_title").val("");
        $("#activity_attach").val("");
		$(".floatdiv").removeClass("invisible");
		$("#adadd").show({
            effect : 'slide',
            easing : 'easeOutQuart',
            direction : 'up',
            duration : 500
        });
        $("#adview").hide();
		$("#adview").hide();
        $(".adadd_msg").slideUp();
	});

	$(".btneditads").on("click", function() {
		$(".floatdiv").removeClass("invisible");
        $("#adview").hide();
		$("#adadd").hide();
		$("#adedit").show({
            effect : 'slide',
            easing : 'easeOutQuart',
            direction : 'up',
            duration : 500
        });
        $(".adedit_msg").slideUp();

        adid = $(this).attr('attribute');

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/ads_request.php?sec=edit",
	        data: "adid=" + adid,
	        type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	            var obj = $.parseJSON(data);
                $("#uactivity_title").val(obj.activity_title);
                $("#uactivity_date").val(obj.activity_date);
                $("#uactivity_filename").val(obj.activity_filename);
                $("#uactivity_db").val(obj.activity_db);
                $("#uactivity_id").val(adid);
	        }
	    })

	    return false;
	});

    $(".btndelads").on("click", function() {

        var r = confirm("Are you sure you want to delete this ads?");
        adid = $(this).attr('attribute');

		if (r == true)
		{
			$.ajax(
		    {
		        url: "<?php echo WEB; ?>/lib/requests/ads_request.php?sec=delete",
		        data: "adid=" + adid,
		        type: "POST",
                success: function(data) {
                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/ads_request.php?sec=table",
                        success: function(data) {
                            $("#adsdata").html(data);
                        }
                    })
                }
		    })

		    return false;
		}

	});

    /* ACTIVITY */

    $(".searchactivity").on("keypress", function(e) {
        if (e.keyCode == 13) {

            $(".btnsearchallactivity").removeClass('invisible');

            msearch = $("#searchactivity").val();

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/act_request.php?sec=table",
                data:  "searchactivity=" + msearch,
                type: "POST",
                success: function(data) {
                    $("#activitydata").html(data);
                }
            })

            return false;
        }
	});

    $(".btnsearchactivity").on("click", function() {

        $(".btnsearchallactivity").removeClass('invisible');

        msearch = $("#searchactivity").val();

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/act_request.php?sec=table",
            data:  "searchactivity=" + msearch,
            type: "POST",
            success: function(data) {
                $("#activitydata").html(data);
            }
        })

        return false;
	});

    $(".btnsearchallactivity").on("click", function() {

        $(this).addClass('invisible');
        $("#searchactivity").val('');

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/act_request.php?sec=clear_search",
            type: "POST",
            success: function(data) {
                $("#activitydata").html(data);
            }
        })

        return false;
	});

    $("#registry_godirectly").change(function() {
        godir = $("#registry_godirectly option:selected").val();

        if (godir == 1) {
            $("#godiryes").removeClass('invisible');
            $("#godirno").addClass('invisible');
        } else {
            $("#godiryes").addClass('invisible');
            $("#godirno").removeClass('invisible');
        }

    });

    $(".btnregactivity").on("click", function() {
        $(".actreg_msg").css("display","none");
        $("#children").addClass('invisible');
        $("#dependent").addClass('invisible');
        $("#guest").addClass('invisible');
        $("#numchi").val(0);
        $("#divchidata").html('');
        $("#numdependent").val(0);
        $("#divindidata").html('');
        $("#numguest").val(0);
        $("#divguestdata").html('');

        $("#cards").flip(true);
        $("#mview_title").html("");
        $("#mview_title2").html("");
        $(".floatdiv").removeClass("invisible");
        $("#actview").show({
            effect : 'slide',
            easing : 'easeOutQuart',
            direction : 'up',
            duration : 500
        });
        $("#actadd").hide();
        $("#actedit").hide();

        actid = $(this).attr('attribute');
        actname = $(this).attr('attribute2');

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/act_request.php?sec=view",
            data: "actid=" + actid,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {

                $("#mview_title").html(actname);
                $("#actreg_title").html(actname + ' Registration');
                $("#activity_data").html(data);

                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/act_request.php?sec=viewdata",
                    data: "actid=" + actid,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {
                        var obj = $.parseJSON(data);
                        $("#registry_activityid").val(obj.activity_id);
                        $("#registry_activitytype").val(obj.activity_type);
                        $(".placedata").html(obj.activity_venue);
                        if (obj.activity_type == '5') {
                            $("#numchild").removeClass('invisible');
                        } else {
                            $("#numchild").addClass('invisible');
                            $("#children").addClass('invisible');
                        }
                        if (obj.activity_dependent == '1') {
                            $("#numdependent").removeClass('invisible');
                        } else {
                            $("#numdependent").addClass('invisible');
                            $("#dependent").addClass('invisible');
                        }
                        if (obj.activity_guest == '1') {
                            $("#numguest").removeClass('invisible');
                        } else {
                            $("#numguest").addClass('invisible');
                            $("#guest").addClass('invisible');
                        }
                        if (obj.activity_cvehicle == '0') {
                            $("#godir").addClass('invisible');
                            $("#godiryes").addClass('invisible');
                            $("#godirno").addClass('invisible');
                        } else {
                            $("#godir").removeClass('invisible');
                            $("#godiryes").removeClass('invisible');
                            $("#godirno").addClass('invisible');
                        }
                        if (obj.activity_approve == '1') {
                            $(".spanapp").removeClass('invisible');
                            $("#registry_approve").val(1);
                        } else {
                            $(".spanapp").addClass('invisible');
                            $("#registry_approve").val(0);
                        }
                    }
                })

            }
        })

        return false;
    });

    $("#numchi").change(function() {
        numchi = $("#numchi option:selected").val();

        if (numchi == 0) {
            $("#children").addClass('invisible');
            $("#divchidata").html('');
        } else {
            $("#children").removeClass('invisible');
            sltchi = '<b>Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Age&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Relation</b><br>';
            for (i=0; i<numchi; i++) {
                sltchi += '<input id="registry_cname' + i + '" type="text" name="registry_cname[' + i + ']" placeholder="Name" class="txtbox width135 marginbottom5" />&nbsp;<select id="registry_cage' + i + '" type="text" name="registry_cage[' + i + ']" class="txtbox width50 marginbottom5"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select>&nbsp;<select id="registry_crel' + i + '" name="registry_crel[' + i + ']" class="txtbox width95 marginbottom5"><option value="Daughter">Daughter</option><option value="Son">Son</option></select><br>';
            }
            $("#divchidata").html(sltchi);
        }
    });

    $("#numindi").change(function() {
        numdependent = $("#numindi option:selected").val();

        if (numdependent == 0) {
            $("#dependent").addClass('invisible');
            $("#divindidata").html('');
        } else {
            $("#dependent").removeClass('invisible');
            sltchi = '';
            for (i=0; i<numdependent; i++) {
                sltchi += '<input id="registry_dname' + i + '" type="text" name="registry_dname[' + i + ']" placeholder="Name" class="txtbox width135 marginbottom5" /><br>';
            }
            $("#divindidata").html(sltchi);
        }
    });

    $("#numgue").change(function() {
        numguest = $("#numgue option:selected").val();

        if (numguest == 0) {
            $("#guest").addClass('invisible');
            $("#divguestdata").html('');
        } else {
            $("#guest").removeClass('invisible');
            sltchi = '';
            for (i=0; i<numguest; i++) {
                sltchi += '<input id="registry_gname' + i + '" type="text" name="registry_gname[' + i + ']" placeholder="Name" class="txtbox width135 marginbottom5" /><br>';
            }
            $("#divguestdata").html(sltchi);
        }
    });

    $(".btnviewactivity").on("click", function() {
        $(".actreg_msg").css("display","none");
        $("#children").addClass('invisible');
        $("#dependent").addClass('invisible');
        $("#guest").addClass('invisible');
        $("#numchi").val(0);
        $("#divchidata").html('');
        $("#numdependent").val(0);
        $("#divindidata").html('');
        $("#numguest").val(0);
        $("#divguestdata").html('');

        $("#cards").flip(false);
        $("#mview_title").html("");
        $("#mview_title2").html("");
        $(".floatdiv").removeClass("invisible");
        $("#actview").show({
            effect : 'slide',
            easing : 'easeOutQuart',
            direction : 'up',
            duration : 500
        });
        $("#actadd").hide();
        $("#actedit").hide();

        actid = $(this).attr('attribute');
        actname = $(this).attr('attribute2');

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/act_request.php?sec=view",
            data: "actid=" + actid,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {

                $("#mview_title").html(actname);
                $("#actreg_title").html(actname + ' Registration');
                $("#activity_data").html(data);

                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/act_request.php?sec=viewdata",
                    data: "actid=" + actid,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {
                        var obj = $.parseJSON(data);
                        $("#registry_activityid").val(obj.activity_id);
                        $("#registry_activitytype").val(obj.activity_type);
                        $(".placedata").html(obj.activity_venue);
                        if (obj.activity_type == '5') {
                            $("#numchild").removeClass('invisible');
                        } else {
                            $("#numchild").addClass('invisible');
                            $("#children").addClass('invisible');
                        }
                        if (obj.activity_dependent == '1') {
                            $("#numdependent").removeClass('invisible');
                        } else {
                            $("#numdependent").addClass('invisible');
                            $("#dependent").addClass('invisible');
                        }
                        if (obj.activity_guest == '1') {
                            $("#numguest").removeClass('invisible');
                        } else {
                            $("#numguest").addClass('invisible');
                            $("#guest").addClass('invisible');
                        }
                        if (obj.activity_cvehicle == '0') {
                            $("#godir").addClass('invisible');
                            $("#godiryes").addClass('invisible');
                            $("#godirno").addClass('invisible');
                        } else {
                            $("#godir").removeClass('invisible');
                            $("#godiryes").removeClass('invisible');
                            $("#godirno").addClass('invisible');
                        }
                        if (obj.activity_approve == '1') {
                            $(".spanapp").removeClass('invisible');
                            $("#registry_approve").val(1);
                        } else {
                            $(".spanapp").addClass('invisible');
                            $("#registry_approve").val(0);
                        }
                    }
                })

            }
        })

        return false;
    });

    $("#activity_type").change(function() {
        acttype = $("#activity_type option:selected").val();

        if (acttype == 1) {
            $("#acthours").removeClass("invisible"); //hours
            $('#activity_approve').attr('checked', false);
            $('#activity_guest').attr('checked', false);
            $('#activity_dependent').attr('checked', false);
            $('#activity_cvehicle').attr('checked', false);
            $('#activity_feedback').attr('checked', false);
            $('#activity_offsite').attr('checked', false);
            $('#activity_endregister').attr('checked', false);
            $(".actatt01").removeClass("invisible"); //need approval
            $(".actatt02").removeClass("invisible"); //guest
            $(".actatt03").addClass("invisible"); //dependent
            $(".actatt04").removeClass("invisible"); //company vehicle
            $(".actatt05").removeClass("invisible"); //feedback
            $(".actatt06").removeClass("invisible"); //offreg
            $(".actatt07").removeClass("invisible"); //disable reg
            $(".actatt08").removeClass("invisible"); //disable backout
        } else if (acttype == 2) {
            $("#acthours").addClass("invisible"); //hours
            $('#activity_approve').attr('checked', false);
            $('#activity_guest').attr('checked', false);
            $('#activity_dependent').attr('checked', false);
            $('#activity_cvehicle').attr('checked', false);
            $('#activity_feedback').attr('checked', false);
            $('#activity_offsite').attr('checked', false);
            $('#activity_endregister').attr('checked', false);
            $(".actatt01").removeClass("invisible"); //need approval
            $(".actatt02").addClass("invisible"); //guest
            $(".actatt03").addClass("invisible"); //dependent
            $(".actatt04").removeClass("invisible"); //company vehicle
            $(".actatt05").removeClass("invisible"); //feedback
            $(".actatt06").addClass("invisible"); //offreg
            $(".actatt07").removeClass("invisible"); //disable reg
            $(".actatt08").removeClass("invisible"); //disable backout
        } else if (acttype == 3) {
            $("#acthours").addClass("invisible"); //hours
            $('#activity_approve').attr('checked', false);
            $('#activity_guest').attr('checked', false);
            $('#activity_dependent').attr('checked', false);
            $('#activity_cvehicle').attr('checked', false);
            $('#activity_feedback').attr('checked', false);
            $('#activity_offsite').attr('checked', false);
            $('#activity_endregister').attr('checked', false);
            $(".actatt01").addClass("invisible"); //need approval
            $(".actatt02").addClass("invisible"); //guest
            $(".actatt03").removeClass("invisible"); //dependent
            $(".actatt04").addClass("invisible"); //company vehicle
            $(".actatt05").addClass("invisible"); //feedback
            $(".actatt06").removeClass("invisible"); //offreg
            $(".actatt07").removeClass("invisible"); //disable reg
            $(".actatt08").removeClass("invisible"); //disable backout
        } else if (acttype == 4) {
            $("#acthours").addClass("invisible"); //hours
            $('#activity_approve').attr('checked', false);
            $('#activity_guest').attr('checked', false);
            $('#activity_dependent').attr('checked', false);
            $('#activity_cvehicle').attr('checked', false);
            $('#activity_feedback').attr('checked', false);
            $('#activity_offsite').attr('checked', false);
            $('#activity_endregister').attr('checked', false);
            $(".actatt01").addClass("invisible"); //need approval
            $(".actatt02").addClass("invisible"); //guest
            $(".actatt03").addClass("invisible"); //dependent
            $(".actatt04").removeClass("invisible"); //company vehicle
            $(".actatt05").addClass("invisible"); //feedback
            $(".actatt06").removeClass("invisible"); //offreg
            $(".actatt07").removeClass("invisible"); //disable reg
            $(".actatt08").removeClass("invisible"); //disable backout
        } else if (acttype == 5) {
            $("#acthours").addClass("invisible"); //hours
            $('#activity_approve').attr('checked', false);
            $('#activity_guest').attr('checked', false);
            $('#activity_dependent').attr('checked', false);
            $('#activity_cvehicle').attr('checked', false);
            $('#activity_feedback').attr('checked', false);
            $('#activity_offsite').attr('checked', false);
            $('#activity_endregister').attr('checked', false);
            $(".actatt01").addClass("invisible"); //need approval
            $(".actatt02").addClass("invisible"); //guest
            $(".actatt03").addClass("invisible"); //dependent
            $(".actatt04").addClass("invisible"); //company vehicle
            $(".actatt05").addClass("invisible"); //feedback
            $(".actatt06").addClass("invisible"); //offreg
            $(".actatt07").removeClass("invisible"); //disable reg
            $(".actatt08").removeClass("invisible"); //disable backout
        } else if (acttype == 6) {
            $("#acthours").addClass("invisible"); //hours
            $('#activity_approve').attr('checked', false);
            $('#activity_guest').attr('checked', false);
            $('#activity_dependent').attr('checked', false);
            $('#activity_cvehicle').attr('checked', false);
            $('#activity_feedback').attr('checked', false);
            $('#activity_offsite').attr('checked', false);
            $('#activity_endregister').attr('checked', false);
            $(".actatt01").removeClass("invisible"); //need approval
            $(".actatt02").addClass("invisible"); //guest
            $(".actatt03").removeClass("invisible"); //dependent
            $(".actatt04").removeClass("invisible"); //company vehicle
            $(".actatt05").removeClass("invisible"); //feedback
            $(".actatt06").removeClass("invisible"); //offreg
            $(".actatt07").removeClass("invisible"); //disable reg
            $(".actatt08").removeClass("invisible"); //disable backout
        }
    });

    $("#uactivity_type").change(function() {
        acttype = $("#uactivity_type option:selected").val();

        if (acttype == 1) {
            $("#uacthours").removeClass("invisible"); //hours
            $('#uactivity_approve').attr('checked', false);
            $('#uactivity_guest').attr('checked', false);
            $('#uactivity_dependent').attr('checked', false);
            $('#uactivity_cvehicle').attr('checked', false);
            $('#uactivity_feedback').attr('checked', false);
            $('#uactivity_offsite').attr('checked', false);
            $('#uactivity_endregister').attr('checked', false);
            $(".uactatt01").removeClass("invisible"); //need approval
            $(".uactatt02").removeClass("invisible"); //guest
            $(".uactatt03").addClass("invisible"); //dependent
            $(".uactatt04").removeClass("invisible"); //company vehicle
            $(".uactatt05").removeClass("invisible"); //feedback
            $(".uactatt06").removeClass("invisible"); //offreg
            $(".uactatt07").removeClass("invisible"); //disable reg
            $(".uactatt08").removeClass("invisible"); //disable backout
        } else if (acttype == 2) {
            $("#uacthours").addClass("invisible"); //hours
            $('#uactivity_approve').attr('checked', false);
            $('#uactivity_guest').attr('checked', false);
            $('#uactivity_dependent').attr('checked', false);
            $('#uactivity_cvehicle').attr('checked', false);
            $('#uactivity_feedback').attr('checked', false);
            $('#uactivity_offsite').attr('checked', false);
            $('#uactivity_endregister').attr('checked', false);
            $(".uactatt01").removeClass("invisible"); //need approval
            $(".uactatt02").addClass("invisible"); //guest
            $(".uactatt03").addClass("invisible"); //dependent
            $(".uactatt04").removeClass("invisible"); //company vehicle
            $(".uactatt05").removeClass("invisible"); //feedback
            $(".uactatt06").addClass("invisible"); //offreg
            $(".uactatt07").removeClass("invisible"); //disable reg
            $(".uactatt08").removeClass("invisible"); //disable backout
        } else if (acttype == 3) {
            $("#uacthours").addClass("invisible"); //hours
            $('#uactivity_approve').attr('checked', false);
            $('#uactivity_guest').attr('checked', false);
            $('#uactivity_dependent').attr('checked', false);
            $('#uactivity_cvehicle').attr('checked', false);
            $('#uactivity_feedback').attr('checked', false);
            $('#uactivity_offsite').attr('checked', false);
            $('#uactivity_endregister').attr('checked', false);
            $(".uactatt01").addClass("invisible"); //need approval
            $(".uactatt02").addClass("invisible"); //guest
            $(".uactatt03").removeClass("invisible"); //dependent
            $(".uactatt04").addClass("invisible"); //company vehicle
            $(".uactatt05").addClass("invisible"); //feedback
            $(".uactatt06").removeClass("invisible"); //offreg
            $(".uactatt07").removeClass("invisible"); //disable reg
            $(".uactatt08").removeClass("invisible"); //disable backout
        } else if (acttype == 4) {
            $("#uacthours").addClass("invisible"); //hours
            $('#uactivity_approve').attr('checked', false);
            $('#uactivity_guest').attr('checked', false);
            $('#uactivity_dependent').attr('checked', false);
            $('#uactivity_cvehicle').attr('checked', false);
            $('#uactivity_feedback').attr('checked', false);
            $('#uactivity_offsite').attr('checked', false);
            $('#uactivity_endregister').attr('checked', false);
            $(".uactatt01").addClass("invisible"); //need approval
            $(".uactatt02").addClass("invisible"); //guest
            $(".uactatt03").addClass("invisible"); //dependent
            $(".uactatt04").removeClass("invisible"); //company vehicle
            $(".uactatt05").addClass("invisible"); //feedback
            $(".uactatt06").removeClass("invisible"); //offreg
            $(".uactatt07").removeClass("invisible"); //disable reg
            $(".uactatt08").removeClass("invisible"); //disable backout
        } else if (acttype == 5) {
            $("#uacthours").addClass("invisible"); //hours
            $('#uactivity_approve').attr('checked', false);
            $('#uactivity_guest').attr('checked', false);
            $('#uactivity_dependent').attr('checked', false);
            $('#uactivity_cvehicle').attr('checked', false);
            $('#uactivity_feedback').attr('checked', false);
            $('#uactivity_offsite').attr('checked', false);
            $('#uactivity_endregister').attr('checked', false);
            $(".uactatt01").addClass("invisible"); //need approval
            $(".uactatt02").addClass("invisible"); //guest
            $(".uactatt03").addClass("invisible"); //dependent
            $(".uactatt04").addClass("invisible"); //company vehicle
            $(".uactatt05").addClass("invisible"); //feedback
            $(".uactatt06").addClass("invisible"); //offreg
            $(".uactatt07").removeClass("invisible"); //disable reg
            $(".uactatt08").removeClass("invisible"); //disable backout
        } else if (acttype == 6) {
            $("#uacthours").addClass("invisible"); //hours
            $('#uactivity_approve').attr('checked', false);
            $('#uactivity_guest').attr('checked', false);
            $('#uactivity_dependent').attr('checked', false);
            $('#uactivity_cvehicle').attr('checked', false);
            $('#uactivity_feedback').attr('checked', false);
            $('#uactivity_offsite').attr('checked', false);
            $('#uactivity_endregister').attr('checked', false);
            $(".uactatt01").removeClass("invisible"); //need approval
            $(".uactatt02").addClass("invisible"); //guest
            $(".uactatt03").removeClass("invisible"); //dependent
            $(".uactatt04").removeClass("invisible"); //company vehicle
            $(".uactatt05").removeClass("invisible"); //feedback
            $(".uactatt06").removeClass("invisible"); //offreg
            $(".uactatt07").removeClass("invisible"); //disable reg
            $(".uactatt08").removeClass("invisible"); //disable backout
        }
    });

    $(".btnaddactivity").on("click", function() {
        $(".fadd_msg").css("display","none");
        $("#activity_title").val("");
        $("#activity_attach").val("");
		$(".floatdiv").removeClass("invisible");
        $(".activity_type").val(1);
        $(".actatt01").removeClass("invisible"); //need approval
        $(".actatt02").removeClass("invisible"); //guest
        $(".actatt03").addClass("invisible"); //dependent
        $(".actatt04").removeClass("invisible"); //company vehicle
        $(".actatt05").removeClass("invisible"); //feedback
        $(".actatt06").removeClass("invisible"); //offreg
        $(".actatt07").removeClass("invisible"); //disable reg
        $(".actatt08").removeClass("invisible"); //disable backout
		$("#actadd").show({
            effect : 'slide',
            easing : 'easeOutQuart',
            direction : 'up',
            duration : 500
        });
        $("#actview").hide();
		$("#actedit").hide();
        $(".actadd_msg").slideUp();
	});

	$(".btneditactivity").on("click", function() {
		$(".floatdiv").removeClass("invisible");
        $("#actview").hide();
		$("#actadd").hide();
		$("#actedit").show({
            effect : 'slide',
            easing : 'easeOutQuart',
            direction : 'up',
            duration : 500
        });
        $(".actedit_msg").slideUp();

        actid = $(this).attr('attribute');

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/act_request.php?sec=edit",
	        data: "actid=" + actid,
	        type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	            var obj = $.parseJSON(data);
                $("#uactivity_title").val(obj.activity_title);
                $("#uactivity_type").val(obj.activity_type);
                if (obj.activity_type == 1) {
                    $("#uacthours").removeClass("invisible"); //hours
                    $(".uactatt01").removeClass("invisible"); //need approval
                    $(".uactatt02").removeClass("invisible"); //guest
                    $(".uactatt03").addClass("invisible"); //dependent
                    $(".uactatt04").removeClass("invisible"); //company vehicle
                    $(".uactatt05").removeClass("invisible"); //feedback
                    $(".uactatt06").removeClass("invisible"); //offreg
                    $(".uactatt07").removeClass("invisible"); //disable reg
                    $(".uactatt08").removeClass("invisible"); //disable backout
                } else if (obj.activity_type == 2) {
                    $("#uacthours").addClass("invisible"); //hours
                    $(".uactatt01").removeClass("invisible"); //need approval
                    $(".uactatt02").addClass("invisible"); //guest
                    $(".uactatt03").addClass("invisible"); //dependent
                    $(".uactatt04").removeClass("invisible"); //company vehicle
                    $(".uactatt05").removeClass("invisible"); //feedback
                    $(".uactatt06").addClass("invisible"); //offreg
                    $(".uactatt07").removeClass("invisible"); //disable reg
                    $(".uactatt08").removeClass("invisible"); //disable backout
                } else if (obj.activity_type == 3) {
                    $("#uacthours").addClass("invisible"); //hours
                    $(".uactatt01").addClass("invisible"); //need approval
                    $(".uactatt02").addClass("invisible"); //guest
                    $(".uactatt03").removeClass("invisible"); //dependent
                    $(".uactatt04").addClass("invisible"); //company vehicle
                    $(".uactatt05").addClass("invisible"); //feedback
                    $(".uactatt06").removeClass("invisible"); //offreg
                    $(".uactatt07").removeClass("invisible"); //disable reg
                    $(".uactatt08").removeClass("invisible"); //disable backout
                } else if (obj.activity_type == 4) {
                    $("#uacthours").addClass("invisible"); //hours
                    $(".uactatt01").addClass("invisible"); //need approval
                    $(".uactatt02").addClass("invisible"); //guest
                    $(".uactatt03").addClass("invisible"); //dependent
                    $(".uactatt04").removeClass("invisible"); //company vehicle
                    $(".uactatt05").addClass("invisible"); //feedback
                    $(".uactatt06").removeClass("invisible"); //offreg
                    $(".uactatt07").removeClass("invisible"); //disable reg
                    $(".uactatt08").removeClass("invisible"); //disable backout
                } else if (obj.activity_type == 5) {
                    $("#uacthours").addClass("invisible"); //hours
                    $(".uactatt01").addClass("invisible"); //need approval
                    $(".uactatt02").addClass("invisible"); //guest
                    $(".uactatt03").addClass("invisible"); //dependent
                    $(".uactatt04").addClass("invisible"); //company vehicle
                    $(".uactatt05").addClass("invisible"); //feedback
                    $(".uactatt06").addClass("invisible"); //offreg
                    $(".uactatt07").removeClass("invisible"); //disable reg
                    $(".uactatt08").removeClass("invisible"); //disable backout
                } else if (obj.activity_type == 6) {
                    $("#uacthours").addClass("invisible"); //hours
                    $(".uactatt01").removeClass("invisible"); //need approval
                    $(".uactatt02").addClass("invisible"); //guest
                    $(".uactatt03").removeClass("invisible"); //dependent
                    $(".uactatt04").removeClass("invisible"); //company vehicle
                    $(".uactatt05").removeClass("invisible"); //feedback
                    $(".uactatt06").removeClass("invisible"); //offreg
                    $(".uactatt07").removeClass("invisible"); //disable reg
                    $(".uactatt08").removeClass("invisible"); //disable backout
                }
                $("#uactivity_venue").val(obj.activity_venue);
                $("#uactivity_description").val(obj.activity_description);
                $("#uactivity_dates").val(obj.activity_dates);
                $("#uactivity_timein").val(obj.activity_timein);
                $("#uactivity_timeout").val(obj.activity_timeout);
                if (obj.activity_approve == 1) {
                    $("#uactivity_title").prop('checked', true);
                } else {
                    $("#uactivity_title").prop('checked', false);
                }
                if (obj.activity_cvehicle == 1) {
                    $("#uactivity_cvehicle").prop('checked', true);
                } else {
                    $("#uactivity_cvehicle").prop('checked', false);
                }
                if (obj.activity_guest == 1) {
                    $("#uactivity_guest").prop('checked', true);
                } else {
                    $("#uactivity_guest").prop('checked', false);
                }
                if (obj.activity_dependent == 1) {
                    $("#uactivity_dependent").prop('checked', true);
                } else {
                    $("#uactivity_dependent").prop('checked', false);
                }
                if (obj.activity_feedback == 1) {
                    $("#uactivity_feedback").prop('checked', true);
                } else {
                    $("#uactivity_feedback").prop('checked', false);
                }
                if (obj.activity_offsite == 1) {
                    $("#uactivity_offsite").prop('checked', true);
                } else {
                    $("#uactivity_offsite").prop('checked', false);
                }
                if (obj.activity_ads == 1) {
                    $("#uactivity_ads").prop('checked', true);
                } else {
                    $("#uactivity_ads").prop('checked', false);
                }
                if (obj.activity_endregister == 1) {
                    $("#uactivity_endregister").prop('checked', true);
                } else {
                    $("#uactivity_endregister").prop('checked', false);
                }
                if (obj.activity_backout == 1) {
                    $("#uactivity_backout").prop('checked', true);
                } else {
                    $("#uactivity_backout").prop('checked', false);
                }
                $("#uactivity_slots").val(obj.activity_slots);
                $("#uactivity_filename").val(obj.activity_filename);
                $("#uactivity_db").val(obj.activity_db);
                $("#uactivity_id").val(actid);
	        }
	    })

	    return false;
	});



    $(".btndelactivity").on("click", function() {

        var r = confirm("Are you sure you want to delete this activity?");
        actid = $(this).attr('attribute');

		if (r == true)
		{
			$.ajax(
		    {
		        url: "<?php echo WEB; ?>/lib/requests/act_request.php?sec=delete",
		        data: "actid=" + actid,
		        type: "POST",
                success: function(data) {
                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/act_request.php?sec=table",
                        success: function(data) {
                            $("#activitydata").html(data);
                        }
                    })
                }
		    })

		    return false;
		}

	});

    /* REGISTRATION */

	$(".btnviewreg").on("click", function() {
		$(".floatdiv").removeClass("invisible");
		$("#fback").addClass("invisible");
		$("#fvreg").removeClass("invisible");

        regid = $(this).attr('attribute');

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/act_request.php?sec=editreg",
	        data: "regid=" + regid,
	        type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	            var obj = $.parseJSON(data);
                $("#fvreg_title").html(obj.activity_title + ' Registration');
                if (!obj.activity_venue || obj.activity_venue == "" || obj.activity_venue == null) { $("#registry_venue").html('The World Center'); } else { $("#registry_venue").html(obj.activity_venue); }
                $("#registry_date").html(obj.activity_datein);
                $("#registry_timein").html(obj.activity_timein);
                $("#registry_timeout").html(obj.activity_timeout);
                if (obj.registry_godirectly == 1) { $("#registry_godirectly").html('<i class="fa fa-check fa-lg greentext"></i>'); } else { $("#registry_godirectly").html('<i class="fa fa-times fa-lg redtext"></i>'); }
                if (obj.activity_venue && obj.activity_venue != "" && obj.activity_venue != null) {
                    if (obj.registry_vrin == 1) { vrin = '<i class="fa fa-check fa-lg greentext"></i>'; } else { vrin = '<i class="fa fa-times fa-lg redtext"></i>'; }
                    if (obj.registry_vrout == 1) { vrout = '<i class="fa fa-check fa-lg greentext"></i>'; } else { vrout = '<i class="fa fa-times fa-lg redtext"></i>'; }
                    $("#registry_vr").html('<b>Will ride the company vehicle:</b><br />From AGT to ' + obj.activity_venue + ': ' + vrin + '<br />From ' + obj.activity_venue + ' to AGT: ' + vrout);
                }
                $("#registry_platenum").html(obj.registry_platenum);
                $("#registry_dependent").html(obj.registry_dependent);
                $("#registry_guest").html(obj.registry_guest);
                $("#registry_datereg").html(obj.registry_date);
                if (obj.registry_status == 1) { $("#registry_status").html('<span class="redtext">For approval</span>'); } else { $("#registry_status").html('<span class="greentext">Approved</span>'); }
                if (obj.registry_status == 4) { $("#btndelreg2").addClass("invisible"); } else { $("#btndelreg2").removeClass("invisible"); }
                $("#btndelreg2").attr('attribute', obj.registry_id);

	        }
	    })

	    return false;
	});

    $(".btnsendfback").on("click", function() {
		$(".floatdiv").removeClass("invisible");
		$("#fback").show({
            effect : 'slide',
            easing : 'easeOutQuart',
            direction : 'up',
            duration : 500
        });
		$("#fvreg").hide();

        regid = $(this).attr('attribute');

        $.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/act_request.php?sec=editreg",
	        data: "regid=" + regid,
	        type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	            var obj = $.parseJSON(data);
                $("#fback_title").html(obj.activity_title + '\'s Feedback');
                $("#fback_registryid").val(obj.registry_id);
                $("#fback_activityid").val(obj.activity_id);
	        }
	    })

	    return false;
	});

    $(".btndelreg").on("click", function() {

        var r = confirm("Are you sure you want to backout on this activity?");
        regid = $(this).attr('attribute');

		if (r == true)
		{
			$.ajax(
		    {
		        url: "<?php echo WEB; ?>/lib/requests/act_request.php?sec=delreg",
		        data: "regid=" + regid,
		        type: "POST",
                success: function(data) {
                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/act_request.php?sec=regtable",
                        success: function(data) {
                            $("#registration_table").html(data);
                        }
                    })
                }
		    })

		    return false;
		}

	});

    $(".btndelreg2").on("click", function() {

        var r = confirm("Are you sure you want to delete this registrant?");
        regid = $(this).attr('attribute');

		if (r == true)
		{
			$.ajax(
		    {
		        url: "<?php echo WEB; ?>/lib/requests/act_request.php?sec=delreg",
		        data: "regid=" + regid,
		        type: "POST",
                success: function(data) {
                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/act_request.php?sec=regmastertable",
                        success: function(data) {
                            $(".floatdiv").addClass("invisible");
		                    $("#fvreg").addClass("invisible");
                            $("#registration_table").html(data);
                        }
                    })
                }
		    })

		    return false;
		}

	});

    $(".btnregapprove").on("click", function() {

        var r = confirm("Are you sure you want to approve this registration?");
        regid = $(this).attr('attribute');

		if (r == true)
		{
			$.ajax(
		    {
		        url: "<?php echo WEB; ?>/lib/requests/act_request.php?sec=approvereg",
		        data: "regid=" + regid,
		        type: "POST",
                success: function(data) {
                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/act_request.php?sec=unapprovetable",
                        success: function(data) {
                            $("#uregistration_table").html(data);
                        }
                    })
                }
		    })

		    return false;
		}

	});


    /* RATING */

    $('.rating').raty({
        target : '#fback_rate',
        targetType : 'score',
        targetKeep : true
    });

    /* MEMO */

    $(".searchmemo").on("keypress", function(e) {
        if (e.keyCode == 13) {

            $(".btnsearchallmemo").removeClass('invisible');

            msearch = $("#searchmemo").val();
            mfrom = $("#memofrom").val();
            mto = $("#memoto").val();

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/memo_request.php?sec=table",
                data:  "searchmemo=" + msearch + "&memofrom=" + mfrom + "&memoto=" + mto,
                type: "POST",
                success: function(data) {
                    $("#memodata").html(data);
                }
            })

            return false;
        }
	});

    $(".btnsearchmemo").on("click", function() {

        $(".btnsearchallmemo").removeClass('invisible');

        msearch = $("#searchmemo").val();
        mfrom = $("#memofrom").val();
        mto = $("#memoto").val();

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/memo_request.php?sec=table",
            data:  "searchmemo=" + msearch + "&memofrom=" + mfrom + "&memoto=" + mto,
            type: "POST",
            success: function(data) {
                $("#memodata").html(data);
            }
        })

        return false;
	});

    $(".btnsearchallmemo").on("click", function() {

        $(this).addClass('invisible');
        $("#searchmemo").val('');
        $("#memofrom").val('08/01/2014');
        $("#memoto").val('<?php echo date('m/d/Y'); ?>');

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/memo_request.php?sec=clear_search",
            type: "POST",
            success: function(data) {
                $("#memodata").html(data);
            }
        })

        return false;
	});

	$(".btnviewmemo").on("click", function() {
        memattach = $(this).attr('attribute');
		window.open("<?php echo WEB; ?>/uploads/" + memattach, "popupWindow", "width=950, height=800, scrollbars=yes");
	    return false;
	});

    $(".btnaddmemo").on("click", function() {
        $(".madd_msg").css("display","none");
        $("#memo_title").val("");
        $("#memo_attach").val("");
		$(".floatdiv").removeClass("invisible");
		$("#madd").show({
            effect : 'slide',
            easing : 'easeOutQuart',
            direction : 'up',
            duration : 500
        });
		$("#medit").hide();
        $(".madd_msg").slideUp();
	});

	$(".btneditmemo").on("click", function() {
		$(".floatdiv").removeClass("invisible");
		$("#madd").hide();
		$("#medit").show({
            effect : 'slide',
            easing : 'easeOutQuart',
            direction : 'up',
            duration : 500
        });
        $(".medit_msg").slideUp();

        memid = $(this).attr('attribute');

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/memo_request.php?sec=edit",
	        data: "memid=" + memid,
	        type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	            var obj = $.parseJSON(data);
                $("#umemo_title").val(obj.memo_title);
                $("#umemo_date").val(obj.memo_date);
                $("#umemo_filename").val(obj.memo_filename);
                $("#umemo_db").val(obj.memo_db);
                $("#umemo_id").val(memid);
	        }
	    })

	    return false;
	});

    $(".btndelmemo").on("click", function() {

        var r = confirm("Are you sure you want to delete this memo?");
        memid = $(this).attr('attribute');

		if (r == true)
		{
			$.ajax(
		    {
		        url: "<?php echo WEB; ?>/lib/requests/memo_request.php?sec=delete",
		        data: "memid=" + memid,
		        type: "POST",
                success: function(data) {
                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/memo_request.php?sec=table",
                        success: function(data) {
                            $("#memodata").html(data);
                        }
                    })
                }
		    })

		    return false;
		}

	});

    /* FORMS */

    $(".searchform").on("keypress", function(e) {
        if (e.keyCode == 13) {

            $(".btnsearchallform").removeClass('invisible');

            msearch = $("#searchform").val();

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/forms_request.php?sec=table",
                data:  "searchform=" + msearch,
                type: "POST",
                success: function(data) {
                    $("#downdata").html(data);
                }
            })

            return false;
        }
	});

    $(".btnsearchform").on("click", function() {

        $(".btnsearchallform").removeClass('invisible');

        msearch = $("#searchform").val();

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/forms_request.php?sec=table",
            data:  "searchform=" + msearch,
            type: "POST",
            success: function(data) {
                $("#downdata").html(data);
            }
        })

        return false;
	});

    $(".btnsearchallform").on("click", function() {

        $(this).addClass('invisible');
        $("#searchform").val('');

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/forms_request.php?sec=clear_search",
            type: "POST",
            success: function(data) {
                $("#downdata").html(data);
            }
        })

        return false;
	});

    $(".btnaddform").on("click", function() {
        $(".fadd_msg").css("display","none");
        $("#download_title").val("");
        $("#download_attach").val("");
		$(".floatdiv").removeClass("invisible");
		$("#dladd").show({
            effect : 'slide',
            easing : 'easeOutQuart',
            direction : 'up',
            duration : 500
        });
		$("#dledit").hide();
        $(".dladd_msg").slideUp();
	});

	$(".btneditform").on("click", function() {
		$(".floatdiv").removeClass("invisible");
		$("#dladd").hide();
		$("#dledit").show({
            effect : 'slide',
            easing : 'easeOutQuart',
            direction : 'up',
            duration : 500
        });
        $(".dledit_msg").slideUp();

        formid = $(this).attr('attribute');

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/forms_request.php?sec=edit",
	        data: "formid=" + formid,
	        type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	            var obj = $.parseJSON(data);
                $("#udownload_title").val(obj.download_title);
                $("#udownload_cat").val(obj.download_cat);
                $("#udownload_user").val(obj.download_user);
                $("#udownload_id").val(formid);
	        }
	    })

	    return false;
	});

    $(".btndelform").on("click", function() {

        var r = confirm("Are you sure you want to delete this form?");
        formid = $(this).attr('attribute');

		if (r == true)
		{
			$.ajax(
		    {
		        url: "<?php echo WEB; ?>/lib/requests/forms_request.php?sec=delete",
		        data: "formid=" + formid,
		        type: "POST",
                success: function(data) {
                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/forms_request.php?sec=table",
                        success: function(data) {
                            $("#downdata").html(data);
                        }
                    })
                }
		    })

		    return false;
		}

	});


    /* DTR */

    $("#dtr_year").change(function() {
        dyear = $("#dtr_year option:selected").val();
        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/dtr_request.php?sec=periodsel",
            data: "year=" + dyear,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#dtr_cover").html(data);

            }
        })

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/dtr_request.php?sec=periodvar",
            data: "year=" + dyear,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {

                var obj = $.parseJSON(data);
                dcover = obj.dcover;
                dfrom = parseInt(obj.dfrom);
                dto = parseInt(obj.dto);
                posted = obj.posted;

                plus5dto = dto + 432000;
                curunixdate = Math.floor(Date.now() / 1000);

                if (posted == 0) {
                    if (curunixdate <= plus5dto) {
                        while(dfrom < (dto + 86400)) {

                            $.ajax(
                            {
                                url: "<?php echo WEB; ?>/lib/requests/dtr_request.php?sec=calculate",
                                data: "dateunix=" + dfrom,
                                type: "POST",
                                complete: function(){
                                    $("#loading").hide();
                                },
                                success: function(data) {}
                            })

                            dfrom = dfrom + 86400;
                            //alert(dfrom);
                        }
                    }
                    $("#txtposted").addClass('invisible');
                }
                else {
                    $("#txtposted").removeClass('invisible');
                }

                $("#dtrdata").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/dtr_request.php?sec=table",
                    data: "cover=" + dcover + "&dfrom=" + dfrom + "&dto=" + dto + "&posted=" + posted,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {
                        $("#dtrdata").html(data);
                    }
                })
            }
        });
    });

    $("#dtr_cover").change(function() {
        dcover = $("#dtr_cover option:selected").val();
        dfrom = $("#dtr_cover option:selected").attr("dfrom");
        dto = $("#dtr_cover option:selected").attr("dto");
        posted = $("#dtr_cover option:selected").attr("posted");

        dfrom = parseInt(dfrom);
        dto = parseInt(dto);

        plus5dto = dto + 432000;
        curunixdate = Math.floor(Date.now() / 1000);

        if (posted == 0) {
            if (curunixdate <= plus5dto) {
                while(dfrom < (dto + 86400)) {

                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/dtr_request.php?sec=calculate",
                        data: "dateunix=" + dfrom,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {}
                    })

                    dfrom = dfrom + 86400;
                    //alert(dfrom);
                }
            }
            $("#txtposted").addClass('invisible');
        }
        else {
            $("#txtposted").removeClass('invisible');
        }


        $("#dtrdata").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/dtr_request.php?sec=table",
            data: "cover=" + dcover + "&dfrom=" + dfrom + "&dto=" + dto + "&posted=" + posted,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#dtrdata").html(data);
            }
        })
    });

    /* USER DTR */

    $("#udtr_year").change(function() {
        empid = $("#udtr_empid").val();
        comp = $("#udtr_comp").val();
        minothours = $("#udtr_minothours").val();
        dyear = $("#udtr_year option:selected").val();

        dbname = $("#udtr_year option:selected").attr("dbname");

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/udtr_request.php?sec=periodsel",
            data: "year=" + dyear + "&comp=" + comp + "&dbname=" + dbname,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#udtr_cover").html(data);

            }
        })

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/udtr_request.php?sec=periodvar",
            data: "year=" + dyear + "&comp=" + comp + "&dbname=" + dbname,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {

                var obj = $.parseJSON(data);
                dcover = obj.dcover;
                dfrom = parseInt(obj.dfrom);
                dto = parseInt(obj.dto);
                posted = obj.posted;

                plus5dto = dto + 432000;
                curunixdate = Math.floor(Date.now() / 1000);

                if (posted == 0) {
                    if (curunixdate <= plus5dto) {

                        while(dfrom < dto) {

                            $.ajax(
                            {
                                url: "<?php echo WEB; ?>/lib/requests/udtr_request.php?sec=calculate",
                                data: "dateunix=" + dfrom + "&empid=" + empid,
                                type: "POST",
                                complete: function(){
                                    $("#loading").hide();
                                },
                                success: function(data) {}
                            })

                            dfrom = dfrom + 86400;
                            //alert(dfrom);
                        }
                    }
                    $("#txtposted").addClass('invisible');
                }
                else {
                    $("#txtposted").removeClass('invisible');
                }

                $("#udtrdata").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/udtr_request.php?sec=table",
                    data: "cover=" + dcover + "&dfrom=" + dfrom + "&dto=" + dto + "&posted=" + posted + "&empid=" + empid + "&comp=" + comp + "&minothours=" + minothours + "&dbname=" + dbname,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {
                        $("#udtrdata").html(data);
                    }
                })
            }
        });
    });

    $("#udtr_cover").change(function() {
        empid = $("#udtr_empid").val();
        comp = $("#udtr_comp").val();
        minothours = $("#udtr_minothours").val();
        dcover = $("#udtr_cover option:selected").val();
        dfrom = $("#udtr_cover option:selected").attr("dfrom");
        dto = $("#udtr_cover option:selected").attr("dto");
        posted = $("#udtr_cover option:selected").attr("posted");

        dbname = $("#udtr_cover option:selected").attr("dbname");

        dfrom = parseInt(dfrom);
        dto = parseInt(dto);

        plus5dto = dto + 432000;
        curunixdate = Math.floor(Date.now() / 1000);

        if (posted == 0) {
            if (curunixdate <= plus5dto) {

                while(dfrom < dto) {

                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/udtr_request.php?sec=calculate",
                        data: "dateunix=" + dfrom + "&empid=" + empid,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {}
                    })

                    dfrom = dfrom + 86400;
                    //alert(dfrom);
                }
            }
            $("#txtposted").addClass('invisible');
        }
        else {
            $("#txtposted").removeClass('invisible');
        }


        $("#udtrdata").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/udtr_request.php?sec=table",
            data: "cover=" + dcover + "&dfrom=" + dfrom + "&dto=" + dto + "&posted=" + posted + "&empid=" + empid + "&comp=" + comp + "&minothours=" + minothours + "&dbname=" + dbname,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#udtrdata").html(data);
            }
        })
    });

    $(".dtrmentry").on("click", function() {

        dtrdate = $(this).attr('attribute');

        empid = $("#udtr_empid").val();
        comp = $("#udtr_comp").val();
        dcover = $("#udtr_cover option:selected").val();
        dfrom = $("#udtr_cover option:selected").attr("dfrom");
        dto = $("#udtr_cover option:selected").attr("dto");
        posted = $("#udtr_cover option:selected").attr("posted");

        var r = confirm("Are you sure you want to delete this DTR entry as of " + dtrdate + " ?");

		if (r == true)
		{
			$.ajax(
		    {
		        url: "<?php echo WEB; ?>/lib/requests/udtr_request.php?sec=delentry",
		        data: "empid=" + empid + "&dtrdate=" + dtrdate,
		        type: "POST",
                success: function(data) {
                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/udtr_request.php?sec=table",
                        data: "cover=" + dcover + "&dfrom=" + dfrom + "&dto=" + dto + "&posted=" + posted + "&empid=" + empid + "&comp=" + comp,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {
                            $("#udtrdata").html(data);
                        }
                    })
                }
		    })

		    return false;
		}

	});

    /* LEAVE BALANCE */

    $(".btnlbaldata").on("click", function() {

        ltype = $(this).attr('attribute');

        $("#lbal_title").html(ltype + ' Summary');
		$(".floatdiv").removeClass("invisible");
		$("#lbview").show({
          effect : 'slide',
          easing : 'easeOutQuart',
          direction : 'up',
          duration : 500
        });

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/leavebal_request.php?sec=data",
            data: "type=" + ltype,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#lbal_data").html(data);
            }
        })
    });

    $(".btnlleddata").on("click", function() {

        ltype = $(this).attr('attribute');
        ltype2 = $(this).attr('attribute2');

        $("#lbal_title").html(ltype + ' Ledger');
		$(".floatdiv").removeClass("invisible");
		$("#lbview").show({
          effect : 'slide',
          easing : 'easeOutQuart',
          direction : 'up',
          duration : 500
        });

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/leavebal_request.php?sec=ledger",
            data: "type=" + ltype + "&type2=" + ltype2,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#lbal_data").html(data);
            }
        })
    });

    /* LOAN LEDGER */

    $("#loan_num").change(function() {
        applyto = $("#loan_num option:selected").val();
        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/loan_request.php?sec=data",
            data: "applyto=" + applyto,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#loandata").html(data);

            }
        })
    });


    /* PAYSLIP */

    $("#payslip_year").change(function() {
        dyear = $("#payslip_year option:selected").val();
        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/payslip_request.php?sec=periodsel",
            data: "year=" + dyear,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#payslip_cover").html(data);
            }
        })

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/payslip_request.php?sec=perioddata",
            data: "year=" + dyear,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                var obj = $.parseJSON(data);
                $("#payperiod").html(obj.periodcover);
                $("#payto").html(obj.prto);
            }
        })

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/payslip_request.php?sec=periodsel2",
            data: "year=" + dyear,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {

                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/payslip_request.php?sec=table",
                    data: "year=" + dyear + "&cover=" + data.trim(),
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {
                        $("#payslipdata").html(data);
                    }
                })

            }
        })
    });

    $("#payslip_cover").change(function() {
        dyear = $("#payslip_year option:selected").val();
        dcover = $("#payslip_cover option:selected").val();
        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/payslip_request.php?sec=table",
            data: "year=" + dyear + "&cover=" + dcover,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#payslipdata").html(data);
            }
        })

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/payslip_request.php?sec=perioddata",
            data: "year=" + dyear + "&cover=" + dcover,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                var obj = $.parseJSON(data);
                $("#payperiod").html(obj.periodcover);
                $("#payto").html(obj.prto);
            }
        })
    });

    /* USER PAYSLIP */

    $("#upayslip_year").change(function() {
        comp = $("#ups_comp").val();
        dyear = $("#upayslip_year option:selected").val();
        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/upayslip_request.php?sec=periodsel",
            data: "year=" + dyear + "&comp=" + comp,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#upayslip_cover").html(data);
            }
        })

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/upayslip_request.php?sec=perioddata",
            data: "year=" + dyear + "&comp=" + comp,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                var obj = $.parseJSON(data);
                $("#payperiod").html(obj.periodcover);
                $("#payto").html(obj.prto);
            }
        })
    });

    $("#upayslip_cover").change(function() {
        empid = $("#ups_empid").val();
        comp = $("#ups_comp").val();
        dyear = $("#upayslip_year option:selected").val();
        dcover = $("#upayslip_cover option:selected").val();
        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/upayslip_request.php?sec=table",
            data: "year=" + dyear + "&cover=" + dcover + "&empid=" + empid,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#upayslipdata").html(data);
            }
        })

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/upayslip_request.php?sec=perioddata",
            data: "year=" + dyear + "&cover=" + dcover + "&comp=" + comp,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                var obj = $.parseJSON(data);
                $("#payperiod").html(obj.periodcover);
                $("#payto").html(obj.prto);
            }
        })
    });


    /* APPLICATION */

    // Overtime

    $("#ot_date").change(function() {
        odate = $("#ot_date").val();
        otype = $("#ot_type").val();

        if (odate) {

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=otparam",
                data: "odate=" + odate + "&otype=" + otype,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    var obj = $.parseJSON(data);

                    if (obj.noinot == 1) {
                        alert("It is not possible to file an OT without time in on DTR");
                    }
                    else {
                        if (obj.holirest == 1) {
                            alert("This is not a regular day");
                        }
                        else if (obj.holirest == 2) {
                            alert("This is not a rest day");
                        }
                        else if (obj.holirest == 3) {
                            alert("This is not a holiday");
                        }
                    }
                    $("#invalid").val(obj.holirest);
                    $("#dtrshift").html(obj.otdtr);
                    $("#ot_from").val(obj.otin);
                    $("#ot_to").val(obj.otout);

                    ofrom = obj.otin;
                    oto = obj.otout;

                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getovshift",
                        data: "odate=" + odate + "&otype=" + otype,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {
                            $("#timeshift").html(data);
                        }
                    })

                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getovhour",
                        data: "odate=" + odate + "&otype=" + otype + "&ofrom=" + ofrom + "&oto=" + oto,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {
                            $("#othours").html(data);
                            $("#txtothours").val(data);
                        }
                    })
                }
            })

        }
    });

    $("#ot_type").change(function() {
        odate = $("#ot_date").val();
        otype = $("#ot_type").val();

        if (odate) {
            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=otparam",
                data: "odate=" + odate + "&otype=" + otype,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    var obj = $.parseJSON(data);

                    if (obj.noinot == 1) {
                        alert("It is not possible to file an OT without time in on DTR");
                    }
                    else {
                        if (obj.holirest == 1) {
                            alert("This is not a regular day");
                        }
                        else if (obj.holirest == 2) {
                            alert("This is not a rest day");
                        }
                        else if (obj.holirest == 3) {
                            alert("This is not a holiday");
                        }
                    }
                    $("#invalid").val(obj.holirest);
                    $("#dtrshift").html(obj.otdtr);
                    $("#ot_from").val(obj.otin);
                    $("#ot_to").val(obj.otout);

                    ofrom = obj.otin;
                    oto = obj.otout;

                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getovshift",
                        data: "odate=" + odate + "&otype=" + otype,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {
                            $("#timeshift").html(data);
                        }
                    })

                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getovhour",
                        data: "odate=" + odate + "&otype=" + otype + "&ofrom=" + ofrom + "&oto=" + oto,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {
                            $("#othours").html(data);
                            $("#txtothours").val(data);
                        }
                    })
                }
            })




        }
    });

    $("#ot_from").change(function() {
        odate = $("#ot_date").val();
        otype = $("#ot_type").val();
        ofrom = $("#ot_from").val();
        oto = $("#ot_to").val();

        if (odate) {

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getovhour",
                data: "odate=" + odate + "&otype=" + otype + "&ofrom=" + ofrom + "&oto=" + oto,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $("#othours").html(data);
                    $("#txtothours").val(data);
                }
            })
        }
    });

    $("#ot_to").change(function() {
        odate = $("#ot_date").val();
        otype = $("#ot_type").val();
        ofrom = $("#ot_from").val();
        oto = $("#ot_to").val();

        if (odate) {

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getovhour",
                data: "odate=" + odate + "&otype=" + otype + "&ofrom=" + ofrom + "&oto=" + oto,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $("#othours").html(data);
                    $("#txtothours").val(data);
                }
            })
        }
    });

    // Late Undertime

    $("#lu_date").change(function() {
        odate = $("#lu_date").val();
        otype = $("#lu_type").val();
        ooffset = $("#lu_offdate").val();

        $("#offset_loading").html('<i class="fa fa-refresh fa-spin fa-lg"></i>');
        $("#offset_noot").html('');
        $("#btnluapply").addClass('invisible');

        if (odate) {

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=luparam",
                data: "odate=" + odate + "&otype=" + otype + "&offset=" + ooffset,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    var obj = $.parseJSON(data);

                    $("#offset_loading").html('');

                    $("#timeshift").html(obj.lushift);
                    $("#dtrshift").html(obj.ludtr);
                    $("#lutexttype").html(obj.lutext);
                    $("#luhours").html(obj.luhours);
                    $("#txtluhours").val(obj.luhours);
                    $("#ovhours").html(obj.othours);
                    $("#txtovhours").val(obj.othours);

                    if (obj.othours >= obj.luhours || obj.luhours != 0) {
                        $("#btnluapply").removeClass('invisible');
                    } else {
                        $("#offset_noot").html('* You\'ve no overtime applied');
                    }
                }
            })

        }
    });

    $("#lu_type").change(function() {
        odate = $("#lu_date").val();
        otype = $("#lu_type").val();
        ooffset = $("#lu_offdate").val();

        $("#offset_loading").html('<i class="fa fa-refresh fa-spin fa-lg"></i>');
        $("#offset_noot").html('');
        $("#btnluapply").addClass('invisible');

        if (odate) {

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=luparam",
                data: "odate=" + odate + "&otype=" + otype + "&offset=" + ooffset,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    var obj = $.parseJSON(data);

                    $("#offset_loading").html('');

                    $("#timeshift").html(obj.lushift);
                    $("#dtrshift").html(obj.ludtr);
                    $("#lutexttype").html(obj.lutext);
                    $("#luhours").html(obj.luhours);
                    $("#txtluhours").val(obj.luhours);
                    $("#ovhours").html(obj.othours);
                    $("#txtovhours").val(obj.othours);

                    if (obj.othours >= obj.luhours || obj.luhours != 0) {
                        $("#btnluapply").removeClass('invisible');
                    } else {
                        $("#offset_noot").html('* You\'ve no overtime applied');
                    }
                }
            })

        }
    });

    $("#lu_offdate").change(function() {
        odate = $("#lu_date").val();
        otype = $("#lu_type").val();
        ooffset = $("#lu_offdate").val();

        $("#offset_loading").html('<i class="fa fa-refresh fa-spin fa-lg"></i>');
        $("#offset_noot").html('');
        $("#btnluapply").addClass('invisible');

        if (odate) {

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=luparam",
                data: "odate=" + odate + "&otype=" + otype + "&offset=" + ooffset,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    var obj = $.parseJSON(data);

                    $("#offset_loading").html('');

                    $("#timeshift").html(obj.lushift);
                    $("#dtrshift").html(obj.ludtr);
                    $("#lutexttype").html(obj.lutext);
                    $("#luhours").html(obj.luhours);
                    $("#txtluhours").val(obj.luhours);
                    $("#ovhours").html(obj.othours);
                    $("#txtovhours").val(obj.othours);

                    if (obj.othours >= obj.luhours || obj.luhours != 0) {
                        $("#btnluapply").removeClass('invisible');
                    } else {
                        $("#offset_noot").html('* You\'ve no overtime applied');
                    }
                }
            })

        }
    });

    // Leave

    $("#leave_type").change(function() {
        lfrom = $("#leave_from").val();
        lto = $("#leave_to").val();
        ltype = $("#leave_type").val();

        if (ltype) {

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getleavebalance",
                data: "ltype=" + ltype + "&lto="+lto,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $("#tbalance").val(data);
                    $("#btnleaveapply").addClass("invisible");

                    $("#leavesched").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

                    if (lfrom && lto) {

                        $.ajax(
                        {
                            url: "<?php echo WEB; ?>/lib/requests/dtr_request.php?sec=cover_calculate",
                            data: "from=" + lfrom + "&to=" + lto,
                            type: "POST",
                            complete: function(){
                                $("#loading").hide();
                            },
                            success: function(data) {}
                        })

                        $.ajax(
                        {
                            url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getleavesched",
                            data: "type=" + ltype + "&from=" + lfrom + "&to=" + lto,
                            type: "POST",
                            complete: function(){
                                $("#loading").hide();
                            },
                            success: function(data) {
                                $("#leavesched").html(data);
                            }
                        })

                        $.ajax(
                        {
                            url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getleaveapply",
                            data: "type=" + ltype + "&from=" + lfrom + "&to=" + lto,
                            type: "POST",
                            complete: function(){
                                $("#loading").hide();
                            },
                            success: function(data) {
                                if (data == 0) {
                                    $("#btnleaveapply").addClass("invisible");
                                }
                                else {
                                    $("#btnleaveapply").removeClass("invisible");
                                }
                                $("#leavetotal").removeClass("invisible");
                                <?php if ($profile_compressed) : ?>
                                $(".total_day").html(data);
                                $(".total_pay").html(data);
                                <?php else : ?>
                                $(".total_day").html(data / 8);
                                $(".total_pay").html(data / 8);
                                <?php endif; ?>
                                $("#tdayswop").val(data);
                                $("#tdays").val(data);
                                $("#totaldays").val(data);
                            }
                        })
                    }
                }
            })
        }
    });

    $("#leave_from").change(function() {
        lfrom = $("#leave_from").val();
        lto = $("#leave_to").val();
        ltype = $("#leave_type").val();
        $("#btnleaveapply").addClass("invisible");

        $("#leavesched").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

        if (lfrom && lto) {

	    $.ajax(
            {
		url: "<?php echo WEB; ?>/lib/requests/dtr_request.php?sec=get_dtr",
                data: "from=" + lfrom + "&to=" + lto,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
			if(data == true){
				$("#loading").hide();
				$("#leave_title").html('Leave Notification');
				$("#leavefloat").removeClass("invisible");
				$("#leaveview").show({
				  effect : 'slide',
				  easing : 'easeOutQuart',
				  direction : 'up',
				  duration : 500
				});
				$("#leave_data").html("<h4>You have biometric entry on one of the selected date/s.</h4>");
			}
		}
            })

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/dtr_request.php?sec=cover_calculate",
                data: "from=" + lfrom + "&to=" + lto,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {}
            })

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getleavesched",
                data: "type=" + ltype + "&from=" + lfrom + "&to=" + lto,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $("#leavesched").html(data);
                }
            })

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getleaveapply",
                data: "type=" + ltype + "&from=" + lfrom + "&to=" + lto,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    if (data == 0) {
                        $("#btnleaveapply").addClass("invisible");
                    }
                    else {
                        $("#btnleaveapply").removeClass("invisible");
                    }
                    $("#leavetotal").removeClass("invisible");
                    <?php if ($profile_compressed) : ?>
                    $(".total_day").html(data);
                    $(".total_pay").html(data);
                    <?php else : ?>
                    $(".total_day").html(data / 8);
                    $(".total_pay").html(data / 8);
                    <?php endif; ?>
                    $("#tdayswop").val(data);
                    $("#tdays").val(data);
                    $("#totaldays").val(data);
                }
            })
        }
    });

    $("#leave_to").change(function() {
        lfrom = $("#leave_from").val();
        lto = $("#leave_to").val();
        ltype = $("#leave_type").val();
        $("#btnleaveapply").addClass("invisible");

        $("#leavesched").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

        if (lfrom && lto) {

	    $.ajax(
            {
		url: "<?php echo WEB; ?>/lib/requests/dtr_request.php?sec=get_dtr",
                data: "from=" + lfrom + "&to=" + lto,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
			if(data == true){
				$("#loading").hide();
				$("#leave_title").html('Leave Notification');
				$("#leavefloat").removeClass("invisible");
				$("#leaveview").show({
				  effect : 'slide',
				  easing : 'easeOutQuart',
				  direction : 'up',
				  duration : 500
				});
				$("#leave_data").html("<h4>You have biometric entry on one of the selected date/s.</h4>");

			}
		}
            })

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/dtr_request.php?sec=cover_calculate",
                data: "from=" + lfrom + "&to=" + lto,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {}
            })

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getleavesched",
                data: "type=" + ltype + "&from=" + lfrom + "&to=" + lto,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $("#leavesched").html(data);

                }
            })

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getleaveapply",
                data: "type=" + ltype + "&from=" + lfrom + "&to=" + lto,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    if (data == 0) {
                        $("#btnleaveapply").addClass("invisible");
                    }
                    else {
                        $("#btnleaveapply").removeClass("invisible");
                    }
                    $("#leavetotal").removeClass("invisible");
                    <?php if ($profile_compressed) : ?>
                    $(".total_day").html(data);
                    $(".total_pay").html(data);
                    <?php else : ?>
                    $(".total_day").html(data / 8);
                    $(".total_pay").html(data / 8);
                    <?php endif; ?>
                    $("#tdayswop").val(data);
                    $("#tdays").val(data);
                    $("#totaldays").val(data);
                }
            })
        }
    });

    // OBT



    $("#obt_from").change(function() {
        ofrom = $("#obt_from").val();
        oto = $("#obt_to").val();
        $("#btnobapply").addClass("invisible");

        if (ofrom && oto) {

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=gettrueto2",
                data: "from=" + ofrom + "&to=" + oto,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {

                    $('#obt_to').val(data);

                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getobtsched",
                        data: "from=" + ofrom + "&to=" + data,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {
                            $("#obtsched").html(data);

                        }
                    })

                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getobndays",
                        data: "from=" + ofrom + "&to=" + data,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {
                            if (data == 0) {
                                $("#btnobapply").addClass("invisible");
                            }
                            else {
                                $("#btnobapply").removeClass("invisible");
                            }
                            $("#ndays").val(data);
                        }
                    })

                }
            })
        }
    });

    $("#obt_to").change(function() {
        ofrom = $("#obt_from").val();
        oto = $("#obt_to").val();
        $("#btnobapply").addClass("invisible");

        if (ofrom && oto) {

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=gettruefrom2",
                data: "from=" + ofrom + "&to=" + oto,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {

                    $('#obt_from').val(data);

                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getobtsched",
                        data: "from=" + data + "&to=" + oto,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {
                            $("#obtsched").html(data);

                        }
                    })

                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getobndays",
                        data: "from=" + data + "&to=" + oto,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {
                            if (data == 0) {
                                $("#btnobapply").addClass("invisible");
                            }
                            else {
                                $("#btnobapply").removeClass("invisible");
                            }
                            $("#ndays").val(data);

                        }
                    })
                }
            })
        }
    });

    // MEAL ALLOWANCE

    $("#ma_from").change(function() {
        mfrom = $("#ma_from").val();
        mto = $("#ma_to").val();

        if (mfrom && mto) {
            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getmealsched",
                data: "from=" + mfrom + "&to=" + mto,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $("#mealsched").html(data);

                }
            })
        }
    });

    $("#ma_to").change(function() {
        mfrom = $("#ma_from").val();
        mto = $("#ma_to").val();

        if (mfrom && mto) {
            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getmealsched",
                data: "from=" + mfrom + "&to=" + mto,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $("#mealsched").html(data);

                }
            })
        }
    });

	// WORK FROM HOME

	$("#wfh_from").change(function() {
		mfrom = $("#wfh_from_").val();
		mto = $("#wfh_to_").val();

		if (mfrom && mto) {

			$.ajax(
			{
				url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=gettrueto3",
				data: "from=" + mfrom,
				type: "POST",
				complete: function(){
					$("#loading").hide();
				},
				success: function(data) {

					$('#wfh_to_').datetimepicker('destroy');
					$('#wfh_to_').datepicker({
						dateFormat: 'yy-mm-dd',
						minDate: mfrom,
						maxDate: data
					});
          $('#wfh_to_').val(data);

				}
			})

		}
	});

	$("#wfh_to").change(function() {
		mfrom = $("#wfh_from").val();
		mto = $("#wfh_to").val();
		$("#btnwfhapply").addClass("invisible");
		$("#wfh").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

		if (mfrom && mto) {
			$.ajax(
			{
				url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getwfh",
				data: "from=" + mfrom + "&to=" + mto,
				type: "POST",
				complete: function(){
					$("#loading").hide();
				},
				success: function(data) {
					$("#wfh").html(data);

				}
			})

			$.ajax(
			{
				url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getwfhdays",
				data: "from=" + mfrom + "&to=" + mto,
				type: "POST",
				complete: function(){
					$("#loading").hide();
				},
				success: function(data) {
					if (data == 0) {
						$("#btnwfhapply").addClass("invisible");
					}
					else {
						$("#btnwfhapply").removeClass("invisible");
					}
					$("#ndays").val(data);

				}
			})
		}
	});

    // MANUAL DTR

    $("#mdtr_from").change(function() {
        mfrom = $("#mdtr_from").val();
        mto = $("#mdtr_to").val();
        $("#btnmdapply").addClass("invisible");
        $("#mandtr").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

        if (mfrom && mto) {

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=gettrueto",
                data: "from=" + mfrom,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {

                    $('#mdtr_to').datetimepicker('destroy');
                    $('#mdtr_to').datepicker({
                        dateFormat: 'yy-mm-dd',
                        minDate: mfrom,
                        maxDate: data
                    });
                    $('#mdtr_to').val(data);

                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getmandtr",
                        data: "from=" + mfrom + "&to=" + data,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {
                            $("#mandtr").html(data);

                        }
                    })

                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getmdndays",
                        data: "from=" + mfrom + "&to=" + data,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {
                            if (data == 0) {
                                $("#btnmdapply").addClass("invisible");
                            }
                            else {
                                $("#btnmdapply").removeClass("invisible");
                            }
                            $("#ndays").val(data);

                        }
                    })

                }
            })

        }
    });

    $("#mdtr_to").change(function() {
        mfrom = $("#mdtr_from").val();
        mto = $("#mdtr_to").val();
        $("#btnmdapply").addClass("invisible");
        $("#mandtr").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

        if (mfrom && mto) {
            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getmandtr",
                data: "from=" + mfrom + "&to=" + mto,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $("#mandtr").html(data);

                }
            })

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getmdndays",
                data: "from=" + mfrom + "&to=" + mto,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    if (data == 0) {
                        $("#btnmdapply").addClass("invisible");
                    }
                    else {
                        $("#btnmdapply").removeClass("invisible");
                    }
                    $("#ndays").val(data);

                }
            })
        }
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
            $("#mdtr_timein" + arrayid).prop('readonly', true);
            $("#mdtr_dayout" + arrayid).prop('readonly', true);
            $("#mdtr_timeout" + arrayid).prop('readonly', true);
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

    // CHANGE TIME SCHEDULE

    $("#cts_date").change(function() {
        ctsdate = $("#cts_date").val();

        if (ctsdate) {
            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getcts",
                data: "date=" + ctsdate,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $("#divcts").html(data);
                }
            })

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getctsday",
                data: "date=" + ctsdate,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $("#ctsday").html(data);
                }
            })
        }
    });

    // NON PUNCH AUTHORITY

    $("#npa_date").change(function() {
        npadate = $("#npa_date").val();

        if (npadate) {
            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getnpa",
                data: "date=" + npadate,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $("#divnpa").html(data);
                }
            })

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=getnpabut",
                data: "date=" + npadate,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    if (data == 1) {
                        $("#btnnpapply").removeClass("invisible");
                    }
                    else {
                        $("#btnnpapply").addClass("invisible");
                    }
                }
            })
        }
    });

    // TIME SCHEDULER

    $("#tsched_from").change(function() {
        tfrom = $("#tsched_from").val();
        tto = $("#tsched_to").val();
        $("#btnscapply").addClass("invisible");

        if (tfrom && tto) {

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=gettrueto2",
                data: "from=" + tfrom + "&to=" + tto,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {

                    $('#tsched_to').val(data);

                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=gettsched",
                        data: "from=" + tfrom + "&to=" + data,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {
                            $("#divtsched").html(data);

                        }
                    })

                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=gettsndays",
                        data: "from=" + tfrom + "&to=" + data,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {
                            if (data == 0) {
                                $("#btnscapply").addClass("invisible");
                            }
                            else {
                                $("#btnscapply").removeClass("invisible");
                            }
                            $("#ndays").val(data);

                        }
                    })
                }
            })
        }
    });

    $("#tsched_to").change(function() {
        tfrom = $("#tsched_from").val();
        tto = $("#tsched_to").val();
        $("#btnscapply").addClass("invisible");

        if (tfrom && tto) {

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=gettruefrom2",
                data: "from=" + tfrom + "&to=" + tto,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {

                    $('#tsched_from').val(data);

                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=gettsched",
                        data: "from=" + data + "&to=" + tto,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {
                            $("#divtsched").html(data);

                        }
                    })

                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/app_request.php?sec=gettsndays",
                        data: "from=" + data + "&to=" + tto,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {
                            if (data == 0) {
                                $("#btnscapply").addClass("invisible");
                            }
                            else {
                                $("#btnscapply").removeClass("invisible");
                            }
                            $("#ndays").val(data);

                        }
                    })
                }
            })
        }
    });

    /* EMPLOYEES MANAGEMENT */

    $("#btnemp").on("click", function() {

        searchemp = $("#searchemp").val();

        emppage = 1;

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/emp_request.php?sec=table",
            data: "searchemp=" + searchemp,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#btnempall").removeClass("invisible");
                $("#empdata").html(data);
                changeUrl('', '<?php echo WEB; ?>/userman');
            }
        })
    });

    $("#btnempall").on("click", function() {

        emppage = 1;

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/emp_request.php?sec=table",
            data: "clear_search=1",
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#searchemp").val("");
                $("#btnempall").addClass("invisible");
                $("#empdata").html(data);
                changeUrl('', '<?php echo WEB; ?>/userman');
            }
        })
    });

    $(".btnempdata").on("click", function() {
        empid = $(this).attr('attribute');
        window.location.href = "<?php echo WEB ?>/profile?edit=1&id=" + empid;
    });

    /* APPROVERS MANAGEMENT */

    $("#searchappr").on("keypress", function(e) {
        if (e.keyCode == 13) {

            searchappr = $("#searchappr").val();

            apprpage = 1;

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/approvers_request.php?sec=table",
                data: "searchappr=" + searchappr,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $("#btnapprall").removeClass("invisible");
                    $("#apprdata").html(data);
                    changeUrl('', '<?php echo WEB; ?>/approvers');
                }
            })
        }
    });

    $("#btnappr").on("click", function() {

        searchappr = $("#searchappr").val();

        apprpage = 1;

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/approvers_request.php?sec=table",
            data: "searchappr=" + searchappr,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#btnapprall").removeClass("invisible");
                $("#apprdata").html(data);
                changeUrl('', '<?php echo WEB; ?>/approvers');
            }
        })
    });

    $("#btnapprall").on("click", function() {

        apprpage = 1;

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/approvers_request.php?sec=table",
            data: "clear_search=1",
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#searchappr").val("");
                $("#btnapprall").addClass("invisible");
                $("#apprdata").html(data);
                changeUrl('', '<?php echo WEB; ?>/approvers');
            }
        })
    });

    $(".btnapprdata").on("click", function() {

        empid = $(this).attr('attribute');
        dbnames = $(this).attr('attribute2');

        $(".btnapprovers").addClass('invisible');

        $('.appr_msg').slideUp();
        $("#appr_data").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

        $("#appr_title").html('Approver Management for Employee ID #' + empid);
		$(".floatdiv").removeClass("invisible");
		$(".fedit2").show({
            effect : 'slide',
            easing : 'easeOutQuart',
            direction : 'up',
            duration : 500
        });

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/approvers_request.php?sec=data",
            data: "empid=" + empid + "&dbn=" + dbnames,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#appr_data").html(data);

                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/approvers_request.php?sec=chkdata",
                    data: "empid=" + empid,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {
                        if (data != 0) {
                            $("#appcount").val(data);
                        }
                        else {
                            $("#appcount").val(6);
                        }
                        $("#appempid").val(empid);
                        $("#appdbname").val(dbnames);
                        $("#txtdbname").html(dbnames);
                        $(".btnapprovers").removeClass('invisible');
                    }
                })
            }
        })

    });

    $("#btnapprovers").on("click", function() {

        var appr_msg;

        if (!$('.appr_msg').length)
        {
            $('#appr_title').after('<div class="appr_msg" style="display:none; padding:10px; text-align:center" />');
        }

        $('.appr_msg')
        .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing your approvers&hellip;')
        .css({
            color : '#006100',
            background : '#c6efce',
            border : '2px solid #006100',
            height : 'auto'
        })
        .slideDown();

        applength = $('#appcount').val();
        empid = $('#appempid').val();
        dbname = $('#appdbname').val();

        for (i = 0; i < applength; i++) {
            type = $('#apptype' + i).val();
            signa1 = $('#app1t' + i).val();
            signa2 = $('#app2t' + i).val();
            signa3 = $('#app3t' + i).val();
            signa4 = $('#app4t' + i).val();
            signa5 = $('#app5t' + i).val();
            signa6 = $('#app6t' + i).val();
            dbsigna1 = $('#dbapp1t' + i).val();
            dbsigna2 = $('#dbapp2t' + i).val();
            dbsigna3 = $('#dbapp3t' + i).val();
            dbsigna4 = $('#dbapp4t' + i).val();
            dbsigna5 = $('#dbapp5t' + i).val();
            dbsigna6 = $('#dbapp6t' + i).val();
            alt1 = $('#alt1t' + i).val();
            alt2 = $('#alt2t' + i).val();
            alt3 = $('#alt3t' + i).val();
            alt4 = $('#alt4t' + i).val();
            alt5 = $('#alt5t' + i).val();
            alt6 = $('#alt6t' + i).val();

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/approvers_request.php?sec=updateapprover",
                data: "empid=" + empid + "&type=" + type + "&s1=" + signa1 + "&s2=" + signa2 + "&s3=" + signa3 + "&s4=" + signa4 + "&s5=" + signa5 + "&s6=" + signa6 + "&d1=" + dbsigna1 + "&d2=" + dbsigna2 + "&d3=" + dbsigna3 + "&d4=" + dbsigna4 + "&d5=" + dbsigna5 + "&d6=" + dbsigna6 + "&a1=" + alt1 + "&a2=" + alt2 + "&a3=" + alt3 + "&a4=" + alt4 + "&a5=" + alt5 + "&a6=" + alt6 + "&dbname=" + dbname,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {


                    if (data == 1) {

                        $('.appr_msg').slideUp(function ()
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

                    }
                    else {

                        $('.appr_msg').slideUp(function ()
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

    });

    /* DTR MANAGEMENT */

    $("#searchdtrm").on("keypress", function(e) {
        if (e.keyCode == 13) {

            searchdtrm = $("#searchdtrm").val();

            dtrmpage = 1;

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/dtrman_request.php?sec=table",
                data: "searchdtrm=" + searchdtrm,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $("#btndtrmall").removeClass("invisible");
                    $("#dtrmdata").html(data);
                    changeUrl('', '<?php echo WEB; ?>/dtrman');
                }
            })
        }
    });

    $("#btndtrm").on("click", function() {

        searchdtrm = $("#searchdtrm").val();

        dtrmpage = 1;

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/dtrman_request.php?sec=table",
            data: "searchdtrm=" + searchdtrm,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#btndtrmall").removeClass("invisible");
                $("#dtrmdata").html(data);
                changeUrl('', '<?php echo WEB; ?>/dtrman');
            }
        })
    });

    $("#btndtrmall").on("click", function() {

        dtrmpage = 1;

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/dtrman_request.php?sec=table",
            data: "clear_search=1",
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#searchdtrm").val("");
                $("#btndtrmall").addClass("invisible");
                $("#dtrmdata").html(data);
                changeUrl('', '<?php echo WEB; ?>/dtrman');
            }
        })
    });

    /* PAYSLIP MANAGEMENT */

    $("#searchpsman").on("keypress", function(e) {
        if (e.keyCode == 13) {

            searchpsman = $("#searchpsman").val();

            psmanpage = 1;

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/psman_request.php?sec=table",
                data: "searchpsman=" + searchpsman,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $("#btnpsmanall").removeClass("invisible");
                    $("#psmandata").html(data);
                    changeUrl('', '<?php echo WEB; ?>/pslipman');
                }
            })
        }
    });

    $("#btnpsman").on("click", function() {

        searchpsman = $("#searchpsman").val();

        psmanpage = 1;

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/psman_request.php?sec=table",
            data: "searchpsman=" + searchpsman,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#btnpsmanall").removeClass("invisible");
                $("#psmandata").html(data);
                changeUrl('', '<?php echo WEB; ?>/pslipman');
            }
        })
    });

    $("#btnpsmanall").on("click", function() {

        psmanpage = 1;

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/psman_request.php?sec=table",
            data: "clear_search=1",
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#searchpsman").val("");
                $("#btnpsmanall").addClass("invisible");
                $("#psmandata").html(data);
                changeUrl('', '<?php echo WEB; ?>/pslipman');
            }
        })
    });

    /* LOGS */

    $("#btnlogs").on("click", function() {

        searchlogs = $("#searchlogs").val();
        logsfrom = $("#logsfrom").val();
        logsto = $("#logsto").val();

        logspage = 1;

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/logs_request.php?sec=table",
            data: "searchlogs=" + searchlogs + "&logsfrom=" + logsfrom + "&logsto=" + logsto,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#btnlogsall").removeClass("invisible");
                $("#logsdata").html(data);
                changeUrl('', '<?php echo WEB; ?>/logs');
            }
        })
    });

    $("#btnlogsall").on("click", function() {

        logspage = 1;

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/logs_request.php?sec=table",
            data: "clear_search=1",
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#searchlogs").val("");
                $("#logsfrom").val("2014-08-01");
                $("#logsto").val("<?php echo date("Y-m-d"); ?>");
                $("#btnlogsall").addClass("invisible");
                $("#logsdata").html(data);
                changeUrl('', '<?php echo WEB; ?>/logs');
            }
        })
    });

    /* UPDATES MANAGEMENT */

    $("#btnupd").on("click", function() {

        searchups = $("#searchups").val();

        updpage = 1;

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/empupdate_request.php?sec=table",
            data: "searchappr=" + searchups,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#btnupdall").removeClass("invisible");
                $("#upddata").html(data);
                changeUrl('', '<?php echo WEB; ?>/empupdate');
            }
        })
    });

    $("#btnupdall").on("click", function() {

        updpage = 1;

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/empupdate_request.php?sec=table",
            data: "clear_search=1",
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#searchups").val("");
                $("#btnupdall").addClass("invisible");
                $("#upddata").html(data);
                changeUrl('', '<?php echo WEB; ?>/empupdate');
            }
        })
    });

    $(".btnupddata").on("click", function() {

        empid = $(this).attr('attribute');

    });

    /* Users */

	$(".delUser").live("click", function() {

		empid = $(this).attr('attribute');

		var r = confirm("Are you sure you want to delete this user?");
		if (r == true)
		{
			$.ajax(
		    {
		        url: "<?php echo WEB; ?>/lib/requests/reg_request.php?sec=delemp",
		        data: "empid=" + empid,
		        type: "POST",
		        complete: function(){
		        	$("#loading").hide();
		    	},
		        success: function(data) {
		            window.location.href = window.location.href;
		        }
		    })

		    return false;
		}

	});

	$(".approveUser").live("click", function() {

		empid = $(this).attr('attribute');
		empstatus = $(this).attr('attribute2');
        $(".ustatusDiv" + empid).html('<i class="fa fa-refresh fa-spin fa-lg"></i>');
		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/reg_request.php?sec=approveemp",
	        data: "empid=" + empid + "&emp_status=" + empstatus,
	        type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	            $(".ustatusDiv" + empid).html(data);
	        }
	    })

	    return false;
	});

    $(".rclose").on("click", function() {
    $("#nview").hide({
          effect : 'slide',
          easing : 'easeOutQuart',
          direction : 'up',
          duration : 500,
          complete : hideOverlay
    });
    $(".fview").hide({
          effect : 'slide',
          easing : 'easeOutQuart',
          direction : 'up',
          duration : 500,
          complete : hideOverlay
        });
    $(".fadd").hide({
          effect : 'slide',
          easing : 'easeOutQuart',
          direction : 'up',
          duration : 500,
          complete : hideOverlay
        });
    $(".fedit").hide({
          effect : 'slide',
          easing : 'easeOutQuart',
          direction : 'up',
          duration : 500,
          complete : hideOverlay
        });
    $(".fback").hide({
          effect : 'slide',
          easing : 'easeOutQuart',
          direction : 'up',
          duration : 500,
          complete : hideOverlay
        });
    });

    $(".closebutton").on("click", function() {
		$("#nview").hide({
          effect : 'slide',
          easing : 'easeOutQuart',
          direction : 'up',
          duration : 500,
          complete : hideOverlay
        });
		$(".fview").hide({
          effect : 'slide',
          easing : 'easeOutQuart',
          direction : 'up',
          duration : 500,
          complete : hideOverlay
        });
		$(".fadd").hide({
          effect : 'slide',
          easing : 'easeOutQuart',
          direction : 'up',
          duration : 500,
          complete : hideOverlay
        });
		$(".fedit").hide({
          effect : 'slide',
          easing : 'easeOutQuart',
          direction : 'up',
          duration : 500,
          complete : hideOverlay
        });
		$(".fback").hide({
          effect : 'slide',
          easing : 'easeOutQuart',
          direction : 'up',
          duration : 500,
          complete : hideOverlay
        });
	});

    $(".closebutton2").on("click", function() {
		$("#fview").hide({
          effect : 'slide',
          easing : 'easeOutQuart',
          direction : 'up',
          duration : 500,
          complete : hideOverlay
        });
		$(".fadd").hide({
          effect : 'slide',
          easing : 'easeOutQuart',
          direction : 'up',
          duration : 500,
          complete : hideOverlay
        });
		$(".fedit").hide({
          effect : 'slide',
          easing : 'easeOutQuart',
          direction : 'up',
          duration : 500,
          complete : hideOverlay
        });
		$(".fedit2").hide({
          effect : 'slide',
          easing : 'easeOutQuart',
          direction : 'up',
          duration : 500,
          complete : hideOverlay
        });
	});

    $(".mclosebutton").on("click", function() {
		$("#mfview").hide({
          effect : 'slide',
          easing : 'easeOutQuart',
          direction : 'up',
          duration : 500,
          complete : hideOverlay
        });
		$(".fadd").hide({
          effect : 'slide',
          easing : 'easeOutQuart',
          direction : 'up',
          duration : 500,
          complete : hideOverlay
        });
		$(".fedit").hide({
          effect : 'slide',
          easing : 'easeOutQuart',
          direction : 'up',
          duration : 500,
          complete : hideOverlay
        });
	});

    /* CLEAR SEARCH */

    $(".btnsearchallsht").on("click", function() {
        $.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/shout_request.php?sec=clear_search",
	        type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	            window.location.href='<?php echo WEB; ?>/shoutbox';
	        }
	    })
    });

    /* PROFILE */


    $(".addFamily").on("click", function() {
        seqid = $(this).attr('attribute');
        nseqid = parseInt(seqid) - 1;
        $(this).attr("attribute", parseInt(seqid) + 1);

        var table = document.getElementById("tblFamily");
        var row = table.insertRow(seqid);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        cell1.innerHTML = 'Relationship<br><select type="text" name="Relation[' + nseqid + ']" id="Relation[' + nseqid + ']" class="tinytxtbox width135"><option value="FATHER">FATHER</option><option value="MOTHER">MOTHER</option><option value="SIBLING">SIBLING</option><option value="SPOUSE">SPOUSE</option><option value="CHILD">CHILD</option></select>';
        cell2.innerHTML = 'Name<br><input type="text" name="Name[' + nseqid + ']" size="30" id="Name[' + nseqid + ']" onChange="upperCase(this)" class="tinytxtbox" value="">';
        cell3.innerHTML = 'Birthday<br><input type="text" name="BirthDate[' + nseqid + ']" size="10" id="BirthDate[' + nseqid + ']"  value="<?php echo date("Y-m-d"); ?>" class="datepickchild tinytxtbox">';
        cell4.innerHTML = 'Profession<br><input type="text" name="Occupation[' + nseqid + ']" size="20" id="Occupation[' + nseqid + ']" onChange="upperCase(this)" class="tinytxtbox" value="">';

        $(".datepickchild").datepicker({
            dateFormat: 'yy-mm-dd',
            yearRange: "-80:+1",
            changeMonth: true,
            changeYear: true
        });

        if (seqid >= 10)
        {
            $(this).addClass("invisible");
        }

	    return false;
	});

    $(".addSchool").on("click", function() {
        seqid = $(this).attr('attribute');
        nseqid = parseInt(seqid) - 1;
        $(this).attr("attribute", parseInt(seqid) + 1);

        var table = document.getElementById("tblSchool");
        var row = table.insertRow(seqid);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        cell1.innerHTML = '<select type="text" name="EducAttainment[' + nseqid + ']" id="EducAttainment[' + nseqid + ']" class="tinytxtbox width135"><option value="COLLEGE GRADUATE">COLLEGE GRADUATE</option><option value="COLLEGE LEVEL">COLLEGE LEVEL</option><option value="TWO YEARS COURSE">TWO YEARS COURSE</option><option value="VOCATIONAL">VOCATIONAL</option></select>';
        cell2.innerHTML = '<input type="text" name="School[' + nseqid + ']" size="50" maxlength="256" id="School[' + nseqid + ']" onChange="TM_UpperCase(this)" class="tinytxtbox">';
        cell3.style.textAlign = "center";
        cell3.innerHTML = '<input type="text" name="YearGraduated[' + nseqid + ']" size="10" id="YearGraduated[' + nseqid + ']" value="" class="tinytxtbox">';
        cell4.style.textAlign = "center";
        cell4.innerHTML = '<input type="text" name="Course[' + nseqid + ']" size="30" maxlength="128" id="Course[' + nseqid + ']" class="tinytxtbox">';


        if (seqid >= 10)
        {
            $(this).addClass("invisible");
        }

	    return false;
	});
    $(".addTraining").on("click", function() {
        seqid = $(this).attr('attribute');
        nseqid = parseInt(seqid) - 1;
        $(this).attr("attribute", parseInt(seqid) + 1);

        if (seqid <= 10) {
            var table = document.getElementById("tblSeminar");
            var row = table.insertRow(seqid);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            cell1.innerHTML = '<input type="text" name="TrainingDesc[' + nseqid + ']" size="60" maxlength="256" id="TrainingDesc[' + nseqid + ']" onChange="TM_UpperCase(this)" class="tinytxtbox">';
            cell2.style.textAlign = "center";
            cell2.innerHTML = '<input type="text" name="DateFrom[' + nseqid + ']" size="20" id="DateFrom[' + nseqid + ']" class="datepick2 tinytxtbox"> - <input type="text" name="DateTo[' + nseqid + ']" size="20" id="DateTo[' + nseqid + ']" class="datepick2 tinytxtbox">';
            $(".datepick2").datepicker({
                dateFormat: 'yy-mm-dd',
                maxDate: "0D",
                changeMonth: true,
                changeYear: true
            });
        }
        else
        {
            $(this).addClass("invisible");
        }

	    return false;
	});
    $(".addSkill").on("click", function() {
        seqid = $(this).attr('attribute');
        $(this).attr("attribute", parseInt(seqid) + 1);

        if (seqid <= 10) {
            var table = document.getElementById("tblSkill");
            var row = table.insertRow(seqid);
            var cell1 = row.insertCell(0);
            cell1.innerHTML = '<input type="text" name="Competency[' + seqid + ']" size="40" maxlength="256" id="Competency[' + seqid + ']" onChange="TM_UpperCase(this)" class="tinytxtbox">';
        }
        else
        {
            $(this).addClass("invisible");
        }

	    return false;
	});

    $(".addPrevWork").on("click", function() {
        seqid = $(this).attr('attribute');
        nseqid = parseInt(seqid) - 1;
        $(this).attr("attribute", parseInt(seqid) + 1);

        if (seqid <= 10) {
            var table = document.getElementById("tblHistory");
            var row = table.insertRow(seqid);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            cell1.innerHTML = 'Name<br><input type="text" name="PrevCompany[' + nseqid + ']" size="40" maxlength="256" id="PrevCompany[' + nseqid + ']" class="tinytxtbox" onChange="TM_UpperCase(this)">';
            cell2.style.verticalAlign = "center";
            cell2.innerHTML = 'Position<br><input type="text" name="PrevPosition[' + nseqid + ']" size="20" maxlength="128" id="PrevPosition[' + nseqid + ']" class="tinytxtbox" onChange="TM_UpperCase(this)">';
            cell3.style.verticalAlign = "center";
            cell3.innerHTML = '<input type="text" name="Reason[' + nseqid + ']" size="20" maxlength="256" id="Reason[' + nseqid + ']" onChange="TM_UpperCase(this)" class="tinytxtbox">';
            cell4.style.verticalAlign = "center";
            cell4.innerHTML = 'From<br><input type="text" name="DateStarted[' + nseqid + ']" size="10" id="DateStarted[' + nseqid + ']" class="datepick2 tinytxtbox"><br>To<br><input type="text" name="DateResigned[' + nseqid + ']" size="10" id="DateResigned[' + nseqid + ']" class="datepick2 tinytxtbox">';
            $(".datepick2").datepicker({
                dateFormat: 'yy-mm-dd',
                maxDate: "0D",
                changeMonth: true,
                changeYear: true
            });
        }
        else
        {
            $(this).addClass("invisible");
        }

	    return false;
	});

    /* REGISTRATION */

    $(".iamhead").change(function() {
        if ($("#iamhead").is(':checked')) {
            userlevel = 1;
        } else {
            userlevel = 0;
        }
        userdept = $("#department option:selected").val();
        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/reg_request.php?sec=approvesel",
            data: "userlevel=" + userlevel + "&userdept=" + userdept,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#ihead").html(data);
            }
        })
    });

    $("#division").change(function() {
        divid = $("#division option:selected").val();
        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/reg_request.php?sec=deptsel",
            data: "divid=" + divid,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#department").html(data);

            }
        })
        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/reg_request.php?sec=dgrpsel",
            data: "divid=" + divid,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#dgroup").html(data);

            }
        })
    });

    $("#department").change(function() {
        if ($("#iamhead").is(':checked')) {
            userlevel = 1;
        } else {
            userlevel = 0;
        }
        deptid = $("#department option:selected").val();
        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/reg_request.php?sec=approvesel",
            data: "userlevel=" + userlevel + "&userdept=" + deptid,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#ihead").html(data);
            }
        })
        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/reg_request.php?sec=secsel",
            data: "deptid=" + deptid,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#dsection").html(data);
            }
        });
    });

    /* DATE/TIME PICKER */

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
        minDate: "<?php echo $limitdate; ?>",
        maxDate: "<?php echo $limitodate; ?>",
        changeMonth: true,
        changeYear: true
    });

    $(".datepick4").datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: "-1D",
        changeMonth: true,
        changeYear: true
    });

    $(".datepick5").datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: "<?php echo $limitdate; ?>",
        maxDate: "<?php echo $limitodate; ?>",
        changeMonth: true,
        changeYear: true
    });


    $(".datepick6").datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: "<?php echo $limitdate; ?>",
        maxDate: "0D",
        changeMonth: true,
        changeYear: true
    });

	$(".datepickwh").datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: "<?php echo $limitdate; ?>",
        maxDate: "-1D",
        changeMonth: true,
        changeYear: true
    });

    alert('<?php echo $limit_from; ?>');


    function initdp(max){
        $('.datepick7').each(function(index){
           $(this).datepicker('destroy');
        });

     $(".datepick7").datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: "<?php echo $limitdate; ?>",
        maxDate: max,
        changeMonth: true,
        changeYear: true
    });
    }

    initdp("<?php echo $limitodate; ?>");
    var olimitto = "<?php echo $limitodate_; ?>";
    var limitto = "<?php echo $limitodate; ?>";
    $(document).on('change', '#leave_type', function(){
        var ltype = $('#leave_type').val();
        if(ltype != "L01" && ltype != 'L03'){
            initdp(olimitto);
        }else{
            initdp("<?php echo $limitodate; ?>");
        }
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

    /* RESIZE CROP */

    $('.profile_pic').resizecrop({
        width: 100,
        height: 100,
        vertical: "center"
    });

    $('.activity_img').resizecrop({
        width: 140,
        height: 100,
        vertical: "top"
    });

    $('.vactivity_img').resizecrop({
        width: 400,
        height: 300,
        vertical: "top"
    });

    $('.latestpic').resizecrop({
        width: 300,
        height: 250,
        vertical: "top"
    });

    $('.album_thumb').resizecrop({
        width: 194,
        height: 150,
        vertical: "center"
    });

    $('.picture_thumb').resizecrop({
        width: 194,
        height: 150,
        vertical: "center"
    });

    $('.pixpic').resizecrop({
        width: 100,
        height: 75,
        vertical: "center"
    });

    $('.smallimg').resizecrop({
        width: 30,
        height: 30,
        vertical: "center"
    });

    $(".shakelog").on("click", function() {
        $("html, body").animate({ scrollTop: 0 }, 100);
        $('#errortd').html('<span class="redtext mediumtext2 bold">Please log-in</span>');
        $('.loginheader').effect('bounce', {times: 3, distance: 10}, 420);
		return false;
    });

    $("#username").bind('keyup', function (e) {
        if (e.which >= 97 && e.which <= 122) {
            var newKey = e.which - 32;
            e.keyCode = newKey;
            e.charCode = newKey;
        }

        $("#username").val(($("#username").val()).toUpperCase());
    });

	$("#username").on("keypress", function(e) {
        if (e.keyCode == 13) {
            username = $("#username").val();
			password = $("#password").val();

            /*password = password.replace("&", "");
            password = password.replace("+", "");
            password = password.replace("=", "");
            password = password.replace("@", "");
            password = password.replace(".", "");
            password = password.replace("ñ", "");
            password = password.replace("Ñ", "");*/
            //company = $("#company").val();

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/login.php",
                //data: "username=" + username + "&password=" + password + "&company=" + company,
                data: {username: username, password: password},
	            type: "POST",
		        complete: function(){
		        	$("#loading").hide();
		    	},
		        success: function(data) {
                    if (data == 0) {
                        //$('#errortd').html('<span class="redtext mediumtext2 bold">Access denied</span>');
                        $('.mainsplashlog').css({'margin-right' : '0px'});
                        $('.mainsplashlog').effect('shake', {times: 3, distance: 20}, 420);
                    }
                    else if (data == 1) {
                        window.location.href='<?php echo WEB; ?>';
                    }
                    else {
                        $('#floatdiv').removeClass('invisible');
                        $('#fdbname').removeClass('invisible');
                        $('#txtlogdbname').html(data);
                    }
                }
		    })
        }
	});

	$("#password").on("keypress", function(e) {
        if (e.keyCode == 13) {
            username = $("#username").val();
            username = username.toUpperCase();
			password = $("#password").val();

            /*password = password.replace("&", "");
            password = password.replace("+", "");
            password = password.replace("=", "");
            password = password.replace("@", "");
            password = password.replace(".", "");
            password = password.replace("ñ", "");
            password = password.replace("Ñ", "");*/
            //company = $("#company").val();
            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/login.php",
                //data: "username=" + username + "&password=" + password + "&company=" + company,
                data: {username: username, password: password},
	            type: "POST",
		        complete: function(){
		        	$("#loading").hide();
		    	},
		        success: function(data) {
                    if (data == 0) {
                        //$('#errortd').html('<span class="redtext mediumtext2 bold">Access denied</span>');
                        $('.mainsplashlog').css({'margin-right' : '0px'});
                        $('.mainsplashlog').effect('shake', {times: 3, distance: 20}, 420);
                    }
                    else if (data == 1) {
                        window.location.href='<?php echo WEB; ?>';
                    }
                    else {
                        $('#floatdiv').removeClass('invisible');
                        $('#fdbname').removeClass('invisible');
                        $('#txtlogdbname').html(data);
                    }
                }
		    })
        }
	});

	$("#btnlogin").on("click", function() {
		username = $("#username").val();
		password = $("#password").val();

        /*password = password.replace("&", "");
        password = password.replace("+", "");
        password = password.replace("=", "");
        password = password.replace("@", "");
        password = password.replace(".", "");
        password = password.replace("ñ", "");
        password = password.replace("Ñ", "");*/
		//company = $("#company").val();
	    $.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/login.php",
            //data: "username=" + username + "&password=" + password + "&company=" + company,
            data: {username: username, password: password},
            type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	        	if (data == 0) {
	        		//$('#errortd').html('<span class="redtext mediumtext2 bold">Access denied</span>');
                    $('.mainsplashlog').css({'margin-right' : '0px'});
		            $('.mainsplashlog').effect('shake', {times: 3, distance: 20}, 420);
	        	}
                else if (data == 1) {
                    window.location.href='<?php echo WEB; ?>';
	        	}
	        	else {
	        		$('#floatdiv').removeClass('invisible');
	        		$('#fdbname').removeClass('invisible');
                    $('#txtlogdbname').html(data);
	        	}
	        }
	    })
	});

	$("#btnlogdbname").on("click", function() {
		username = $("#username").val();
        password = $("#password").val();
        dbname = $("#txtlogdbname option:selected").val();

	    $.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/logindb.php",
            data: {username: username, password: password, dbname: dbname},
            type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
                if (data == 0) {
                    $('.mainsplashlog').css({'margin-right' : '0px'});
		            $('.mainsplashlog').effect('shake', {times: 3, distance: 20}, 420);
	        	}
                else {
                    window.location.href='<?php echo WEB; ?>';
	        	}
	        }
	    })
	});

    $("#btnlogdbcancel").on("click", function() {
        $('#floatdiv').addClass('invisible');
        $('#fdbname').addClass('invisible');
	});

});
