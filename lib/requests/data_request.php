<?php 

	include("../../config.php"); 
	//**************** USER MANAGEMENT - START ****************\\

	include(LIB."/login/chklog.php");
    include(LIB."/init/settinginit.php");

	$logged = $logstat;
    $profile_full = $logfname;
	$profile_name = $lognick;
	$profile_id = $userid;
	$profile_idnum = $logname;
	$profile_email = $email;
	$profile_comp = $company;
	$profile_pos = $position;
	$profile_dept = $department;
	$profile_sss = $sss;
	$profile_tin = $tin;
	$profile_phealth = $phealth;
	$profile_pagibig = $pagibig;
    $profile_acctnum = $acctnum;
    $profile_location = $location;

    if (in_array($profile_idnum, $adminarray)) :
	   $profile_level = 9;
    else :
        $profile_level = 0;
    endif;

    $profile_hash = md5('2014'.$profile_idnum);

    $profile_taxdesc = $taxdesc;

	$GLOBALS['level'] = $profile_level;
	
	//***************** USER MANAGEMENT - END *****************\\
?>

<?php	

    $sec = $_GET['sec'];

    switch ($sec) {
        case 'clear_search':	
            unset($_SESSION['searchact']);
        break;
        case 'edit':	
            $act_id = $_POST['actid'];
    
            $single_activity = $main->get_activities($act_id);
        
            foreach ($single_activity as $key => $value) : 
                
                $dateinbreak = explode(" ", date("Y-m-d H:i:s", $value['activity_datestart']));
                $dateoutbreak = explode(" ", date("Y-m-d H:i:s", $value['activity_dateend']));
                $dateinval = $dateinbreak[0];
                $timeinval = $dateinbreak[1];
                $timeoutval = $dateoutbreak[1];
    
                echo '{"activity_id":"'.$value['activity_id'].'", "activity_title":"'.$value['activity_title'].'", "activity_description":"'.addslashes($value['activity_description']).'", "activity_venue":"'.$value['activity_venue'].'", "activity_datein":"'.$dateinval.'", "activity_timein":"'.date('g:ia', $value['activity_datestart']).'", "activity_timeout":"'.date('g:ia', $value['activity_dateend']).'", "activity_approve":"'.$value['activity_approve'].'", "activity_guest":"'.$value['activity_guest'].'", "activity_dependent":"'.$value['activity_dependent'].'", "activity_cvehicle":"'.$value['activity_cvehicle'].'", "activity_slots":"'.$value['activity_slots'].'"}';
            
            endforeach; 
        break;
        case 'editreg':	
            $reg_id = $_POST['regid'];
    
            $single_registry = $main->get_registration($reg_id);
        
            foreach ($single_registry as $key => $value) : 
                
                $dateinbreak = explode(" ", date("Y-m-d H:i:s", $value['activity_datestart']));
                $dateoutbreak = explode(" ", date("Y-m-d H:i:s", $value['activity_dateend']));
                $dateinval = $dateinbreak[0];
                $timeinval = $dateinbreak[1];
                $timeoutval = $dateoutbreak[1];
    
                echo '{"registry_id":"'.$value['registry_id'].'", "activity_title":"'.$value['activity_title'].'", "activity_venue":"'.$value['activity_venue'].'", "activity_datein":"'.$dateinval.'", "activity_timein":"'.date('g:ia', $value['activity_datestart']).'", "activity_timeout":"'.date('g:ia', $value['activity_dateend']).'", "registry_godirectly":"'.$value['registry_godirectly'].'", "registry_vrin":"'.$value['registry_vrin'].'", "registry_vrout":"'.$value['registry_vrout'].'", "registry_platenum":"'.$value['registry_platenum'].'", "registry_dependent":"'.$value['registry_dependent'].'", "registry_guest":"'.$value['registry_guest'].'", "registry_date":"'.date("F j, Y - g:ia", $value['registry_date']).'", "registry_status":"'.$value['registry_status'].'"}';
            
            endforeach; 
        break;
        case 'delete':	
            $act_id = $_POST['actid'];
    
            $del_activity = $main->activity_action(NULL, NULL, 'delete', $act_id);			
            if($del_activity) :    
                return TRUE;
            else :
                return FALSE;
            endif;
        break;
        case 'delreg':	
            $reg_id = $_POST['regid'];
    
            $del_registry = $main->activity_action(NULL, NULL, 'delreg', $reg_id);			
            if($del_registry) :    
                return TRUE;
            else :
                return FALSE;
            endif;
        break;
        case 'regtable':
            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NUM_ROWS * ($page - 1);
        
            $my_registration = $main->get_registration(0, 0, 0, 0, $profile_id);
	
            ?>	

            <script src="<?php echo JS; ?>/jquery-1.7.2.min.js"></script>  
            <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui.js"></script>    
            <script type="text/javascript" src="<?php echo JS; ?>/jquery.resizecrop.min.js"></script>
            <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui-timepicker-addon.js"></script>    
            <script type="text/javascript">
                $(".btnviewreg").on("click", function() {		
                    $(".floatdiv").removeClass("invisible");
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
                                $("#registry_vr").html('<b>Will ride the company vehicle:</b><br />From The World Center to ' + obj.activity_venue + ': ' + vrin + '<br />From ' + obj.activity_venue + ' to The World Center: ' + vrin);
                            }
                            $("#registry_platenum").html(obj.registry_platenum);    
                            $("#registry_dependent").html(obj.registry_dependent);    
                            $("#registry_guest").html(obj.registry_guest);    
                            $("#registry_datereg").html(obj.registry_date);    
                            if (obj.registry_status == 1) { $("#registry_status").html('<span class="redtext">For approval</span>'); } else { $("#registry_status").html('<span class="greentext">Approved</span>'); }
                            $("#btnoutreg").attr('attribute', obj.registry_id);                    
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
            </script>

            <table class="tdata" width="100%">
                <tr>
                    <th width="30%">Event Title</th>
                    <th width="10%">Will go directly</th>
                    <th width="10%">Dependent</th>
                    <th width="10%">Guest</th>
                    <th width="15%">Date Registered</th>
                    <th width="15%">Status</th>
                    <th width="15%">Manage</th>
                </tr>
                
                <?php if ($my_registration) : ?>
                <?php foreach ($my_registration as $key => $value) : ?>
                <tr>
                    <td><a class="btnviewreg cursorpoint" attribute="<?php echo $value['registry_id']; ?>"><?php echo $value['activity_title']; ?></a></td>
                    <td class="centertalign"><?php echo $value['registry_godirectly'] ? '<i class="fa fa-check greentext"></i>' : '<i class="fa fa-times redtext"></i>'; ?></td>
                    <td class="centertalign"><?php echo $value['registry_dependent']; ?></td>
                    <td class="centertalign"><?php echo $value['registry_guest']; ?></td>
                    <td class="centertalign"><?php echo date("M j, Y", $value['registry_date']); ?><br><?php echo date("g:ia", $value['registry_date']); ?></td>
                    <td class="centertalign"><?php echo $value['registry_status'] == 2 ? '<span class="greentext">Approved</span>' : '<span class="redtext">For Approval</span>'; ?></td>
                    <td class="centertalign"><a class="btndelreg redtext cursorpoint" attribute="<?php echo $value['registry_id']; ?>">Backout</a></td>
                </tr>
                <?php endforeach; ?>
                <?php if ($pages) : ?>
                <tr>
                    <td colspan="7" align="center" class="whitebg"><?php echo $pages; ?></td>
                </tr>
                <?php endif; ?>
                <?php else : ?>
                <tr>
                    <td colspan="7" align="center">No activity registration found</td>
                </tr>
                <?php endif; ?>
            </table>
            <?php
        break;
        case 'table':
            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NUM_ROWS * ($page - 1);
        
            // SEARCH
            $searchact_sess = $_SESSION['searchact'];
            if ($_POST['searchact']) :
                $searchact = $_POST['searchact'] ? $_POST['searchact'] : 0;
                $_SESSION['searchact'] = $searchact;        
            elseif ($searchact_sess) :
                $searchact = $searchact_sess ? $searchact_sess : 0;
                $_POST['searchact'] = $searchact != 0 ? $searchact : NULL;
            else :
                $searchact = 0;
                $_POST['searchact'] = NULL;
            endif;
        
            $activities = $main->get_activities(0, $start, NUM_ROWS, $searchact, 0, 0, 1);
            $activities_count = $main->get_activities(0, 0, 0, $searchact, 1, 0, 1);
        
            $pages = $main->pagination("activity", $activities_count, NUM_ROWS, 9);
	
            ?>	

            <script src="<?php echo JS; ?>/jquery-1.7.2.min.js"></script>  
            <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui.js"></script>    
            <script type="text/javascript" src="<?php echo JS; ?>/jquery.resizecrop.min.js"></script>
            <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui-timepicker-addon.js"></script>    
            <script type="text/javascript">
                $('.activity_img').resizecrop({
                    width: 200,
                    height: 150,
                    vertical: "top"
                });  
                
                $(".btnviewact").on("click", function() {		
                    $("#floatdiv").removeClass("invisible");
                    $("#fview").removeClass("invisible");
                    $("#freg").addClass("invisible");
                    $("#fadd").addClass("invisible");
                    $("#fedit").addClass("invisible");
            
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
                            $("#fview_title").html(obj.activity_title);                
                            $("#vactivity_description").html(obj.activity_description);                                                            
                            if (!obj.activity_venue && obj.activity_venue == "" && obj.activity_venue == null) { $("#vactivity_venue").html('The World Center'); } else { $("#vactivity_venue").html(obj.activity_venue); }                
                            $("#vactivity_date").html(obj.activity_datein);                
                            $("#vactivity_timein").html(obj.activity_timein);                
                            $("#vactivity_timeout").html(obj.activity_timeout);    
                            if (obj.activity_approve == 1) { $("#vactivity_approve").html('<i class="fa fa-check fa-lg greentext"></i>'); } else { $("#vactivity_approve").html('<i class="fa fa-times fa-lg redtext"></i>'); }
                            if (obj.activity_guest == 1) { $("#vactivity_guest").html('<i class="fa fa-check fa-lg greentext"></i>'); } else { $("#vactivity_guest").html('<i class="fa fa-times fa-lg redtext"></i>'); }
                            if (obj.activity_dependent == 1) { $("#vactivity_dependent").html('<i class="fa fa-check fa-lg greentext"></i>'); } else { $("#vactivity_dependent").html('<i class="fa fa-times fa-lg redtext"></i>'); }
                            if (obj.activity_cvehicle == 1) { $("#vactivity_cvehicle").html('<i class="fa fa-check fa-lg greentext"></i>'); } else { $("#vactivity_cvehicle").html('<i class="fa fa-times fa-lg redtext"></i>'); }
                            $("#vactivity_slots").html(obj.activity_slots);    
                            $("#vactivity_img").attr('src', '<?php echo WEB; ?>/image?type=1&id=' + obj.activity_id);                    
                            $("#btnregact").attr('attribute', obj.activity_id);                    
                        }
                    })
            
                    return false;
                });
            
                $(".btnregact").on("click", function() {		
                    $(".floatdiv").removeClass("invisible");
                    $("#fview").addClass("invisible");
                    $("#freg").removeClass("invisible");
                    $("#fadd").addClass("invisible");
                    $("#fedit").addClass("invisible");
            
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
                            if (obj.activity_venue || obj.activity_venue == 'The World Center' || (obj.activity_venue != "" && obj.activity_venue != null)) 
                            {      
                                $("#cvehicle").remove();
                                $("#cvehicle2").remove();
                                var has_cvehicle = '<tr id="cvehicle"><td>I will ride the company vehicle</td><td><input type="checkbox" name="registry_vrin" id="registry_vrin" value="1" /> From The World Center to ' + obj.activity_venue + '</td></tr><tr id="cvehicle2"><td>&nbsp;</td><td><input type="checkbox" name="registry_vrout" id="registry_vrout" value="1" /> From ' + obj.activity_venue + ' to The World Center</td></tr>'
                                if (obj.activity_cvehicle == 1) { $("#has_cvehicle").after(has_cvehicle); } 
                            } 
                            else
                            {
                                $("#cvehicle").remove();
                                $("#cvehicle2").remove();
                            }
            
                            if (obj.activity_guest == 1) 
                            { 
                                $("#guest").remove();
                                $("#dependent").remove();
                                var onetoten = '';
                                for (var i = 1; i <= 10; i++) { 
                                    onetoten += '<option value="' + i + '">' + i + '</option>';
                                }
                                var has_guest = '<tr id="guest"><td>No. of guest/s</td><td><select name="activity_guest" id="activity_guest">' + onetoten + '</select></td></tr>';
                                $("#has_guest").after(has_guest);
                                
                                if (obj.activity_dependent == 1) 
                                { 
                                    var has_dependent = '<tr id="dependent"><td>No. of dependent/s</td><td><select name="activity_dependent" id="activity_dependent">' + onetoten + '</select></td></tr>';
                                    $("#guest").after(has_dependent);
                                }
                            } 
                            else
                            {
                                $("#guest").remove();
                                $("#dependent").remove();
                                var onetoten = '';
                                for (var i = 1; i <= 10; i++) { 
                                    onetoten += '<option value="' + i + '">' + i + '</option>';
                                }
                                if (obj.activity_dependent == 1) 
                                { 
                                    var has_dependent = '<tr id="dependent"><td>No. of dependent/s</td><td><select name="activity_dependent" id="activity_dependent">' + onetoten + '</select></td></tr>';
                                    $("#has_guest").after(has_dependent);
                                }
                            }

                            if (obj.activity_approve == 1) 
                            { 
                                $("#approve").remove();
                                var has_approve = '<tr id="approve"><td>To be approved</td><td><select name="registry_approve" id="registry_approve"></select></td></tr>';
                                $("#has_approve").after(has_approve);
                            } 
                            else
                            {
                                $("#approve").remove();
                            }
            
                            $("#freg_title").html(obj.activity_title + ' Registration');    
                            $("#registry_activityid").val(obj.activity_id);                              
                        }
                    })
                });
            
                $(".btnaddact").on("click", function() {	
                    $(".fadd_msg").css("display","none");
                    $("#cactivity_title").val("");
                    $("#cactivity_description").val("");
                    $("#cactivity_image").val("");			
                    $("#floatdiv").removeClass("invisible");
                    $("#fview").addClass("invisible");
                    $("#freg").addClass("invisible");
                    $("#fadd").removeClass("invisible");
                    $("#fedit").addClass("invisible");
                });
            
                $(".btneditact").on("click", function() {		
                    $("#floatdiv").removeClass("invisible");
                    $("#fview").addClass("invisible");
                    $("#freg").addClass("invisible");
                    $("#fadd").addClass("invisible");
                    $("#fedit").removeClass("invisible");
            
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
                            $("#uactivity_description").val(obj.activity_description);    
                            $("#uactivity_venue").val(obj.activity_venue);                
                            $("#uactivity_date").val(obj.activity_datein);                
                            $("#uactivity_timein").val(obj.activity_timein);                
                            $("#uactivity_timeout").val(obj.activity_timeout);    
                            if (obj.activity_approve == 1) { $("#uactivity_approve").prop('checked', true); } else { $("#uactivity_approve").prop('checked', false); }
                            if (obj.activity_guest == 1) { $("#uactivity_guest").prop('checked', true); } else { $("#uactivity_guest").prop('checked', false); }
                            if (obj.activity_dependent == 1) { $("#uactivity_dependent").prop('checked', true); } else { $("#uactivity_dependent").prop('checked', false); }
                            if (obj.activity_cvehicle == 1) { $("#uactivity_cvehicle").prop('checked', true); } else { $("#uactivity_cvehicle").prop('checked', false); }
                            $("#uactivity_slots").val(obj.activity_slots);    
                            $("#uactivity_user").val(obj.activity_user);    
                            $("#uactivity_id").val(actid);    
                        }
                    })
            
                    return false;
                });
            
                $(".btndelact").on("click", function() {		
            
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
                                        $("#activity_table").html(data);
                                    }
                                })
                            }
                        })
            
                        return false;
                    }
            
                });
            </script>

            <table class="tdata" width="100%">
                <tr>
                    <th colspan="2">List of Activities</td>
                </tr>
                <?php if ($activities) : ?>
                <?php foreach ($activities as $key => $value) : ?>
                <?php $if_registered = $main->chk_registered($value['activity_id'], $profile_id); ?>
                <tr>
                    <td width="200"><img src="<?php echo WEB; ?>/image?type=1&id=<?php echo $value['activity_id']; ?>" class="activity_img" /></td>
                    <td>
                        <?php $count_registry = 0; ?>
                        <?php $cnt_registered = $main->cnt_registered($value['activity_id']); ?>
                        <?php 
                            foreach ($cnt_registered as $k => $v) :
                                $count_registry++;
                                $count_registry = $count_registry + $v['registry_dependent'];
                                $count_registry = $count_registry + $v['registry_guest'];
                            endforeach; 
                        ?>
                        <?php $slot_remain = $value['activity_slots'] - $count_registry; ?>
                        <?php $slot_remain = $value['activity_slots'] - $count_registry; ?>
                        <b><?php echo $value['activity_title']; ?></b><br />
                        Date: <?php echo date("F j, Y - g:ia", $value['activity_datestart']); ?> to <?php echo date("g:ia", $value['activity_dateend']); ?><br /><br />
                        Total Slots: <?php echo $value['activity_slots']; ?><br />
                        Slots Remaining: <?php echo $slot_remain; ?><br /><br />
                        <a class="btnviewact cursorpoint" attribute="<?php echo $value['activity_id']; ?>">View</a><?php if ($slot_remain > 0) : ?> <?php if(!$if_registered) : ?>| <a class="btnregact cursorpoint" attribute="<?php echo $value['activity_id']; ?>">Register</a><?php endif; ?><?php endif; ?><span class="adminbox"> | <a class="btneditact cursorpoint" attribute="<?php echo $value['activity_id']; ?>">Edit</a> | <a class="btndelact redtext cursorpoint" attribute="<?php echo $value['activity_id']; ?>">Delete</a></span>
                    </td>                                  
                </tr>
                <?php endforeach; ?>
                <?php if ($pages) : ?>
                <tr>
                    <td colspan="2" align="center" class="whitebg"><?php echo $pages; ?></td>
                </tr>
                <?php endif; ?>
                <?php else : ?>
                <tr>
                    <td colspan="2" align="center">No activity list found</td>
                </tr>
                <?php endif; ?>
            </table>
            <?php
        break;
    }            
	
?>			