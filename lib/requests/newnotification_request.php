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

                var r = confirm("This action is cannot be UNDONE. Are you sure you want to approve this request?");

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

                var r = confirm("This action is cannot be UNDONE. Are you sure you want to approve this request?");

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
            
        $(".btnpenddata").on("click", function() {	
        
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

            $("#pend_title").html(title + ' ' + refnum);
            $(".floatdiv").removeClass("invisible");
            $("#nview").removeClass("invisible");
            
            $("#pend_data").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/notification_request.php?sec=datapend",
                data: "refnum=" + refnum + "&doctype=" + doctype,
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
        case 'sccancel':            
            
            $sccpost['REQ'] = $_POST['reqnbr'];
            $sccpost['DTRDATE'] = $_POST['dtrdate'];                                    
            $sccpost['STATUS'] = 0;                                    
            
            $sccancel_request = $mainsql->sc_action($sccpost, 'scitemcancel');
            
            echo $sccancel_request;
            
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
            

            $notification_data = $cloud->get_notification(NULL, $start, NOTI_NUM_ROWS, $searchnoti, 0, $profile_idnum, $notifrom, $notito, $notitype);
            $notification_count = $cloud->get_notification(NULL, 0, 0, $searchnoti, 1, $profile_idnum, $notifrom, $notito, $notitype);

            $pages = $cloud->pagination("notification", $notification_count, NOTI_NUM_ROWS, 9);
            
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
            

            $pending_data = $cloud->get_pendingnoti(NULL, $start, NOTI_NUM_ROWS, $searchpend, 0, $profile_idnum, $pendfrom, $pendto, $pendtype);
            $pending_count = $cloud->get_pendingnoti(NULL, 0, 0, $searchpend, 1, $profile_idnum, $pendfrom, $pendto, $pendtype);
        
            //var_dump($pending_count);

		    $pages = $cloud->pagination("pending", $pending_count, NOTI_NUM_ROWS, 9);
            
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

                    if (trim($value['Signatory01'])) : 

                        if ($value['Signatory01'] == $profile_idnum) :

                            $requestor_data = $register->get_member($value['EmpID']);
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
                            $approver_data = $register->get_member($value['Signatory01']);
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

                            $approver_data = $register->get_member($value['Signatory05']);
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

                            $requestor_data = $register->get_member($value['EmpID']);
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
                            $approver_data = $register->get_member($value['Signatory04']);
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

                            $requestor_data = $register->get_member($value['EmpID']);
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
                            $approver_data = $register->get_member($value['Signatory03']);
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
                            $requestor_data = $register->get_member($value['EmpID']);                                
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
                            $approver_data = $register->get_member($value['Signatory02']);
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
                <tr class="trdata centertalign whitetext" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>">
                    <td class="centertalign"><?php if ($displaychk) : ?><input id="chkapp<?php echo $key; ?>" type="checkbox" name="chkapp[<?php echo $key; ?>]" value="<?php echo $value['Reference']; ?>" attribute="<?php echo $value['DocType']; ?>" attribute2="<?php echo $profile_idnum; ?>" attribute3="<?php echo $value['EmpID']; ?>" attribute4="<?php echo $value['DocType'] == 'OT' ? $ot_data[0]['ApprovedHrs'] : 0; ?>" class="chkapp" /><?php endif; ?></td>
                    <td class="btnpenddata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>"><?php echo $value['DocType']; ?></td>
                    <td class="btnpenddata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>"><?php echo $value['Reference']; ?></td>
                    <td class="btnpenddata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>"><?php echo $nlevel; ?></td>
                    <td class="btnpenddata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>"><?php echo date("M j, Y g:ia", strtotime($value['DateFiled'])); ?></td>
                    <td class="btnpenddata cursorpoint tinytext" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>"><?php echo $astatus; ?></td>
                    <td class="btnpenddata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>"><?php echo $date_approved; ?></td>
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
            $start = NOTI_NUM_ROWS * ($page - 1);   
        
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

            $notification_data = $cloud->get_notification(NULL, $start, NOTI_NUM_ROWS, $searchrman, 0, NULL, $rmanfrom, $rmanto, $rmantype);
            $notification_count = $cloud->get_notification(NULL, 0, 0, $searchrman, 1, NULL, $rmanfrom, $rmanto, $rmantype);

            $pages = $cloud->pagination("reqman", $notification_count, NOTI_NUM_ROWS, 9);
            
            //var_dump($notification_data);
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
                endif;

                if (trim($value['Signatory01'])) : 

                    if ($value['Signatory01'] == $profile_idnum) :

                        $requestor_data = $register->get_member($value['EmpID']);
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
                        $approver_data = $register->get_member($value['Signatory01']);
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

                        $approver_data = $register->get_member($value['Signatory05']);
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

                        $requestor_data = $register->get_member($value['EmpID']);
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
                        $approver_data = $register->get_member($value['Signatory04']);
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

                        $requestor_data = $register->get_member($value['EmpID']);
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
                        $approver_data = $register->get_member($value['Signatory03']);
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
                        $requestor_data = $register->get_member($value['EmpID']);                                
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
                        $approver_data = $register->get_member($value['Signatory02']);
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
            <tr class="btnnotidata cursorpoint trdata centertalign whitetext" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>">
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
            <tr>
                <td class="bold centertalign noborder"><br><br>You have no notification</td>
            </tr>
            <?php endif; ?>
        </table>
        <input type="hidden" id="notipage" name="notipage" value="<?php echo $page; ?>" />

            <?php
        break;
        case 'approve':
            
            $doctype = $_POST['doctype'];
            $apppost['REQNBR'] = $_POST['reqnbr'];
            $apppost['TRANS'] = $_POST['trans'];
            $apppost['USER'] = $_POST['user'];
            $apppost['EMPID'] = $_POST['empid'];
            $apppost['REMARKS'] = $_POST['remarks'];                        
            
            if ($doctype == 'OT') :
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
            endif;
            
            if ($_POST['trans'] == 'CANCEL') :
                $delete_read = $mainsql->delete_read(NULL, $refnum);
            endif;            
            
            $requestor = $register->get_member($_POST['empid']);
            $request_info = $tblsql->get_mrequest($reqtype, 0, 0, 0, $_POST['reqnbr'], 0, NULL, NULL, NULL, NULL);
            $approver = $register->get_member($_POST['user']);
            if ($_POST['nxtapp']) : $nxtapprover = $register->get_member($_POST['nxtapp']); endif;
        
            $reqemailblock = $mainsql->get_appemailblock($_POST['empid']);
            $appemailblock = $mainsql->get_appemailblock($_POST['user']);
            if ($_POST['nxtapp']) : $nappemailblock = $mainsql->get_newemailblock($_POST['nxtapp']); endif;
            
            if ($_POST['user']) :
                $bywhom = $approver[0]['FName']." ".$approver[0]['LName'];
            else :
                $bywhom = "YOU";
            endif;

            if ($reqemailblock) :

                //SEND EMAIL (REQUESTOR)

                $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>".$reqdesc." Request ".ucfirst($_POST['trans'])."</span><br><br>Hi ".$requestor[0]['NickName'].",<br><br>";
                $message .= "Your request for ".($reqtype == 7 ? "manual DTR" : strtolower($reqdesc))." with Reference No: ".$_POST['reqnbr']." on ".date('F j, Y')." was ".strtoupper($_POST['trans'])." by ".$bywhom.".";
                $message .= "<br><br>Thanks,<br>";
                $message .= SITENAME." Admin";
                $message .= "<hr />".MAILFOOT."</div>";

                $headers = "From: ".NOTIFICATION_EMAIL."\r\n";
                $headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                //$sendmail = mail($requestor[0]['EmailAdd'], "Response to your ".$reqdesc." Request", $message, $headers);   
            
            endif;

            if ($appemailblock) :
            
                //SEND EMAIL (APPROVER)

                $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>".$reqdesc." Request ".ucfirst($_POST['trans'])."</span><br><br>Hi ".$approver[0]['NickName'].",<br><br>";
                $message .= "Request for ".($reqtype == 7 ? "manual DTR" : strtolower($reqdesc))." with Reference No: ".$_POST['reqnbr']." on ".date('F j, Y')." was ".strtoupper($_POST['trans'])." by ".$bywhom.".";
                $message .= "<br><br>Thanks,<br>";
                $message .= SITENAME." Admin";
                $message .= "<hr />".MAILFOOT."</div>";

                $headers = "From: ".NOTIFICATION_EMAIL."\r\n";
                $headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                //$sendmail = mail($approver[0]['EmailAdd'], "Your Response to ".$reqdesc." Request", $message, $headers);  
            
            endif;
            
            if ($nappemailblock) :        
                //SEND EMAIL (NEXT APPROVER)

                $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New Leave Request from ".$requestor[0]['FName']." ".$requestor[0]['LName']."</span><br><br>Hi ".$nxtapprover[0]['NickName'].",<br><br>";
                $message .= "New request ".$requestor[0]['FName']." ".$requestor[0]['LName']." for leave with Reference No: ".$_POST['reqnbr']." on ".date('F j, Y')." for your approval. ";
                $message .= "<br><br>Thanks,<br>";
                $message .= SITENAME." Admin";
                $message .= "<hr />".MAILFOOT."</div>";

                $headers = "From: ".NOTIFICATION_EMAIL."\r\n";
                $headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                //$sendmail = mail($nxtapprover[0]['EmailAdd'], "New Leave Request for your Approval", $message, $headers);  
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
            
            $notification_data = $tblsql->get_notification($refnum);            
            $attachment_data = $mainsql->get_attachments($refnum); 
            
            $approver_data1 = $register->get_member($notification_data[0]['Signatory01']);
            $approver_data2 = $register->get_member($notification_data[0]['Signatory02']);
            $approver_data3 = $register->get_member($notification_data[0]['Signatory03']);
            $approver_data4 = $register->get_member($notification_data[0]['Signatory04']);
            $approver_data5 = $register->get_member($notification_data[0]['Signatory05']);
            $approver_data6 = $register->get_member($notification_data[0]['Signatory06']);
            
            $requestor_data = $register->get_member($notification_data[0]['EmpID']);
            
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
                        </td>
                    </tr>
                
                <?php
            //endif;
            
            if ($doctype == 'OT') :            
                $application_data = $tblsql->get_nrequest(1, $refnum);
            
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
                        <td><?php echo $application_data[0]['Reason']; ?></td>
                    </tr> 

                <?php
                $pdtrfrom = strtotime($application_data[0]['DtrDate']);
                $pdtrto = strtotime($application_data[0]['DtrDate']);
            
            elseif ($doctype == 'LV') :            
                $application_data = $tblsql->get_nrequest(2, $refnum);
                $appleave_data = $tblsql->get_leavedata($refnum);
            
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
                            <div class="width100per notidatadiv">
                            <table class="tdatablk">
                                <tr>
                                    <th>Date</th>
                                    <th>Duration</th>
                                    <th>w/ Pay</th>
                                </tr>            
                                <?php foreach($appleave_data as $key => $value) : ?>
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
                                </tr>            
                                <?php endforeach; ?>
                            </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Reason</b></td>
                        <td><?php echo $application_data[0]['Reason']; ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['AbsenceFromDate']);
                $pdtrto = strtotime($application_data[0]['AbsenceToDate']);            
            
            elseif ($doctype == 'MA') :            
                $application_data = $tblsql->get_nrequest(3, $refnum);
            
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
                        <td><?php echo $application_data[0]['Reason']; ?></td>
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
                        <td><?php echo $application_data[0]['Reason']; ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['DateCovered']);
                $pdtrto = strtotime($application_data[0]['DateCovered']);  
            
            elseif ($doctype == 'MD') :            
                $application_data = $tblsql->get_mrequest(7, $refnum);
            
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
                        <div class="divdtrdata width100per notidatadiv">
                            <table class="tdatablk">
                                <tr>
                                    <th width="100px">DTR Date</th>
                                    <th width="80px">Day</th>
                                    <th width="150px">Time IN</th>
                                    <th width="150px">Time OUT</th>
                                    <th width="200px">Shift Desc</th>
                                    <th width="200px">New Shift Desc</th>
                                </tr>
                                <?php
                                    $dtr_data = $tblsql->get_nrequest(7, $refnum);
            
                                    foreach ($dtr_data as $key => $value) :
                                        $shifts2 = $mainsql->get_shift($value['NewShiftDesc']);
                                        ?>
                                        <tr>
                                            <?php $timearray = preg_split('/\s+/', trim($value['TimeIn'])); $timearray2 = preg_split('/\s+/', trim($value['TimeOUt'])); ?>
                                            <td><?php echo date('F j, Y', strtotime($value['DTRDate'])); ?></td>
                                            <td><?php echo $value['Day']; ?></td>
                                            <td><?php echo $timearray[3] ? date('g:ia', strtotime($timearray[3])) : ''; ?></td>
                                            <td><?php echo $timearray[3] ? date('g:ia', strtotime($timearray2[3])) : ''; ?></td>
                                            <td><?php echo $value['ShiftDesc']; ?></td>
                                            <td><?php echo $value['NewShiftDesc'] ? $shifts2[0]['ShiftDesc'] : 'REST DAY'; ?></td>
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
                $pdtrfrom = strtotime($application_data[0]['DateStart']);
            
            elseif ($doctype == 'SC') :            
                $application_data = $tblsql->get_mrequest(8, $refnum);
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
                        <td><?php echo $application_data[0]['Reason']; ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['DateStart']);
            endif;
            
            ?>
                
                    <?php                         
                        $ifposted = $mainsql->get_posted($pdtrfrom, $pdtrto, $profile_comp);
                        $thisisposted = $ifposted[0]['Post'] ? 1 : 0;
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
                                <?php if (!$notification_data[0]['ApprovedDate01'] && $notification_data[0]['Approved'] != 2 && !$thisisposted) : ?>
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
                                        <b>Approve Hour/s</b> <input type="text" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['Hrs']; ?>" class="approvehours txtbox width50 righttalign" readonly />
                                    <?php endif; ?>
                                    <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10"></textarea>
                                    <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory01']; ?>"<?php if ($notification_data[0]['Signatory02']) : ?> attribute21="<?php echo $notification_data[0]['Signatory02'] ? $notification_data[0]['Signatory02'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
                                    <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory01']; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" /></td>
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
                                <?php if (!$notification_data[0]['ApprovedDate02'] && $notification_data[0]['ApprovedDate01'] && $notification_data[0]['Approved'] != 2 && !$thisisposted) : ?>
                                    <?php if ($doctype == 'OT') : ?>
                                        <input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" />
                                    <?php endif; ?>
                                    <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10"></textarea>
                                    <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory02']; ?>"<?php if ($notification_data[0]['Signatory03']) : ?> attribute21="<?php echo $notification_data[0]['Signatory03'] ? $notification_data[0]['Signatory03'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
                                    <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory02']; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" /></td>
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
                                <?php if (!$notification_data[0]['ApprovedDate03'] && $notification_data[0]['ApprovedDate02'] && $notification_data[0]['Approved'] != 2 && !$thisisposted) : ?>
                                    <?php if ($doctype == 'OT') : ?>
                                        <input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" />
                                    <?php endif; ?>
                                    <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10"></textarea>
                                    <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory03']; ?>"<?php if ($notification_data[0]['Signatory04']) : ?> attribute21="<?php echo $notification_data[0]['Signatory04'] ? $notification_data[0]['Signatory04'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
                                    <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory03']; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" /></td>
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
                                <?php if (!$notification_data[0]['ApprovedDate04'] && $notification_data[0]['ApprovedDate03'] && $notification_data[0]['Approved'] != 2 && !$thisisposted) : ?>
                                    <?php if ($doctype == 'OT') : ?>
                                        <input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" />
                                    <?php endif; ?>
                                    <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10"></textarea>
                                    <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory04']; ?>"<?php if ($notification_data[0]['Signatory05']) : ?> attribute21="<?php echo $notification_data[0]['Signatory05'] ? $notification_data[0]['Signatory05'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
                                    <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory04']; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" /></td>
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
                                <?php if (!$notification_data[0]['ApprovedDate05'] && $notification_data[0]['ApprovedDate04'] && $notification_data[0]['Approved'] != 2 && !$thisisposted) : ?>
                                    <?php if ($doctype == 'OT') : ?>
                                        <input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" />
                                    <?php endif; ?>
                                    <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10"></textarea>
                                    <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory05']; ?>"<?php if ($notification_data[0]['Signatory06']) : ?> attribute21="<?php echo $notification_data[0]['Signatory06'] ? $notification_data[0]['Signatory06'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
                                    <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory05']; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" /></td>
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
                                <?php if (!$notification_data[0]['ApprovedDate06'] && $notification_data[0]['ApprovedDate05'] && $notification_data[0]['Approved'] != 2 && !$thisisposted) : ?>
                                    <?php if ($doctype == 'OT') : ?>
                                        <input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" />
                                    <?php endif; ?>
                                    <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10"></textarea>
                                    <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory06']; ?>" attribute21="0" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
                                    <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory06']; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="smlbtn btnred" /></td>
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
                        <?php if ($notification_data[0]['EmpID'] == $profile_idnum && $notification_data[0]['Approved'] != 2 && !$thisisposted) : ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td><input id="btncancel" type="button" name="btncancel" value="Cancel" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['EmpID']; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btncancel btnred smlbtn" /></td>
                        </tr>
                        <?php endif; ?>
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
        case 'datapend':        
        
            $doctype = $_POST['doctype'];
            $refnum = $_POST['refnum'];
            
            $notification_data = $tblsql->get_pendingnoti($refnum);            
            $attachment_data = $mainsql->get_attachments($refnum); 
            
            $approver_data1 = $register->get_member($notification_data[0]['Signatory01']);
            $approver_data2 = $register->get_member($notification_data[0]['Signatory02']);
            $approver_data3 = $register->get_member($notification_data[0]['Signatory03']);
            $approver_data4 = $register->get_member($notification_data[0]['Signatory04']);
            $approver_data5 = $register->get_member($notification_data[0]['Signatory05']);
            $approver_data6 = $register->get_member($notification_data[0]['Signatory06']);
            
            $requestor_data = $register->get_member($notification_data[0]['EmpID']);
            
            //READ STATUS
            $get_read = $mainsql->get_read($profile_idnum, $refnum, 1);
            if ($get_read) :
                $delete_read = $mainsql->delete_read($profile_idnum, $refnum);
            endif; 
            ?>

            <table class="tdataform2 rightmargin margintop10 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">
                
            <?php
            //var_dump($notification_data);
            if ($notification_data[0]['EmpID'] != $profile_idnum) :
                ?>
                
                    <tr>
                        <td width="25%"><b>Requested by</b></td>
                        <td width="75%"><?php echo $requestor_data[0]['FName'].' '.$requestor_data[0]['LName'].' ('.$notification_data[0]['EmpID'].')'; ?>
                        </td>
                    </tr>
                
                <?php
            endif;
            
            if ($doctype == 'OT') :            
                $application_data = $tblsql->get_nrequest(1, $refnum);
            
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
                        <td><?php echo $application_data[0]['Reason']; ?></td>
                    </tr> 

                <?php
                $pdtrfrom = strtotime($application_data[0]['DtrDate']);
                $pdtrto = strtotime($application_data[0]['DtrDate']);
            
            elseif ($doctype == 'LV') :            
                $application_data = $tblsql->get_nrequest(2, $refnum);
                $appleave_data = $tblsql->get_leavedata($refnum);
            
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
                            <div class="width100per notidatadiv">
                            <table class="tdatablk">
                                <tr>
                                    <th>Date</th>
                                    <th>Duration</th>
                                    <th>w/ Pay</th>
                                </tr>            
                                <?php foreach($appleave_data as $key => $value) : ?>
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
                                </tr>            
                                <?php endforeach; ?>
                            </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Reason</b></td>
                        <td><?php echo $application_data[0]['Reason']; ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['AbsenceFromDate']);
                $pdtrto = strtotime($application_data[0]['AbsenceToDate']);            
            
            elseif ($doctype == 'MA') :            
                $application_data = $tblsql->get_nrequest(3, $refnum);
            
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
                        <td><?php echo $application_data[0]['Reason']; ?></td>
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
                        <td><?php echo $application_data[0]['Reason']; ?></td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['DateCovered']);
                $pdtrto = strtotime($application_data[0]['DateCovered']);  
            
            elseif ($doctype == 'MD') :            
                $application_data = $tblsql->get_mrequest(7, $refnum);
            
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
                        <div class="divdtrdata width100per notidatadiv">
                            <table class="tdatablk">
                                <tr>
                                    <th width="100px">DTR Date</th>
                                    <th width="80px">Day</th>
                                    <th width="150px">Time IN</th>
                                    <th width="150px">Time OUT</th>
                                    <th width="200px">Shift Desc</th>
                                    <th width="200px">New Shift Desc</th>
                                </tr>
                                <?php
                                    $dtr_data = $tblsql->get_nrequest(7, $refnum);
            
                                    foreach ($dtr_data as $key => $value) :
                                        $shifts2 = $mainsql->get_shift($value['NewShiftDesc']);
                                        ?>
                                        <tr>
                                            <?php $timearray = preg_split('/\s+/', trim($value['TimeIn'])); $timearray2 = preg_split('/\s+/', trim($value['TimeOUt'])); ?>
                                            <td><?php echo date('F j, Y', strtotime($value['DTRDate'])); ?></td>
                                            <td><?php echo $value['Day']; ?></td>
                                            <td><?php echo $timearray[3] ? date('g:ia', strtotime($timearray[3])) : ''; ?></td>
                                            <td><?php echo $timearray[3] ? date('g:ia', strtotime($timearray2[3])) : ''; ?></td>
                                            <td><?php echo $value['ShiftDesc']; ?></td>
                                            <td><?php echo $value['NewShiftDesc'] ? $shifts2[0]['ShiftDesc'] : 'REST DAY'; ?></td>
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
                $pdtrfrom = strtotime($application_data[0]['DateStart']);
            
            elseif ($doctype == 'SC') :            
                $application_data = $tblsql->get_mrequest(8, $refnum);
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
                                ?>
                            </table>
                        </div>
                        </td>
                    </tr>

                <?php
                $pdtrfrom = strtotime($application_data[0]['DateStart']);
            endif;
            
            ?>
                
                    <?php                         
                        $ifposted = $mainsql->get_posted($pdtrfrom, $pdtrto, $profile_comp);
                        $thisisposted = $ifposted[0]['Post'] ? 1 : 0;
                    ?>
                
                    <tr>
                        <td colspan="2">
                            <div class="hrborder">&nbsp;</div>
                        </td>
                    </tr>
                
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
                            <?php if (!$notification_data[0]['ApprovedDate01'] && $notification_data[0]['Approved'] != 2 && !$thisisposted) : ?>
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
                                    <b>Approve Hour/s</b> <input type="text" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['Hrs']; ?>" class="approvehours txtbox width50 righttalign" readonly />
                                <?php endif; ?>
                                <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10"></textarea>
                                <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory01']; ?>"<?php if ($notification_data[0]['Signatory02']) : ?> attribute21="<?php echo $notification_data[0]['Signatory02'] ? $notification_data[0]['Signatory02'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
                                <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory01']; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" /></td>
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
                            <?php if (!$notification_data[0]['ApprovedDate02'] && $notification_data[0]['ApprovedDate01'] && $notification_data[0]['Approved'] != 2 && !$thisisposted) : ?>
                                <?php if ($doctype == 'OT') : ?>
                                    <input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" />
                                <?php endif; ?>
                                <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10"></textarea>
                                <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory02']; ?>"<?php if ($notification_data[0]['Signatory03']) : ?> attribute21="<?php echo $notification_data[0]['Signatory03'] ? $notification_data[0]['Signatory03'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
                                <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory02']; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" /></td>
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
                            <?php if (!$notification_data[0]['ApprovedDate03'] && $notification_data[0]['ApprovedDate02'] && $notification_data[0]['Approved'] != 2 && !$thisisposted) : ?>
                                <?php if ($doctype == 'OT') : ?>
                                    <input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" />
                                <?php endif; ?>
                                <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10"></textarea>
                                <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory03']; ?>"<?php if ($notification_data[0]['Signatory04']) : ?> attribute21="<?php echo $notification_data[0]['Signatory04'] ? $notification_data[0]['Signatory04'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
                                <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory03']; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" /></td>
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
                            <?php if (!$notification_data[0]['ApprovedDate04'] && $notification_data[0]['ApprovedDate03'] && $notification_data[0]['Approved'] != 2 && !$thisisposted) : ?>
                                <?php if ($doctype == 'OT') : ?>
                                    <input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" />
                                <?php endif; ?>
                                <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10"></textarea>
                                <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory04']; ?>"<?php if ($notification_data[0]['Signatory05']) : ?> attribute21="<?php echo $notification_data[0]['Signatory05'] ? $notification_data[0]['Signatory05'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
                                <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory04']; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" /></td>
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
                            <?php if (!$notification_data[0]['ApprovedDate05'] && $notification_data[0]['ApprovedDate04'] && $notification_data[0]['Approved'] != 2 && !$thisisposted) : ?>
                                <?php if ($doctype == 'OT') : ?>
                                    <input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" />
                                <?php endif; ?>
                                <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10"></textarea>
                                <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory05']; ?>"<?php if ($notification_data[0]['Signatory06']) : ?> attribute21="<?php echo $notification_data[0]['Signatory06'] ? $notification_data[0]['Signatory06'] : 0; ?>"<?php endif; ?> attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
                                <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory05']; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnrej smlbtn btnred" /></td>
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
                            <?php if (!$notification_data[0]['ApprovedDate06'] && $notification_data[0]['ApprovedDate05'] && $notification_data[0]['Approved'] != 2 && !$thisisposted) : ?>
                                <?php if ($doctype == 'OT') : ?>
                                    <input type="hidden" name="approvehours" id="approvehours" value="<?php echo $application_data[0]['ApprovedHrs']; ?>" />
                                <?php endif; ?>
                                <input id="remarks" type="text" name="remarks" placeholder="Remarks..." class="txtbox width95per<?php echo $doctype == 'OT' ? ' margintop10' : ''; ?> marginbottom10"></textarea>
                                <input id="btnapp" type="button" name="btnapp" value="Approve" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory06']; ?>" attribute21="0" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btnapp smlbtn" />&nbsp;
                                <input id="btnrej" type="button" name="btnrej" value="Reject" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['Signatory06']; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="smlbtn btnred" /></td>
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
                    <?php if ($notification_data[0]['EmpID'] == $profile_idnum && $notification_data[0]['Approved'] != 2 && !$thisisposted) : ?>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input id="btncancel" type="button" name="btncancel" value="Cancel" attribute="<?php echo $doctype; ?>" attribute2="<?php echo $notification_data[0]['EmpID']; ?>" attribute3="<?php echo $refnum; ?>" attribute4="<?php echo $notification_data[0]['EmpID']; ?>" class="btncancel btnred smlbtn" /></td>
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