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
        $adminarray = array("2014-05-N791", "2009-09-V206", "2012-04-U384", "MASTER", "2012-03-U273");
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
    elseif (in_array($profile_idnum, $adminarray2) || $profile_idnum == '2014-01-N506') :
        $profile_level = 7;
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
        case 'bdayimg':	
    
            $bimg_data = $tblsql->get_bdayimg(0, 0, 0, 0);
            
            if ($bimg_data) :
                if ($bimg_data[0]['bimg_filename1']) : ?>
                    <img src="<?php echo WEB; ?>/uploads/birthday/<?php echo $bimg_data[0]['bimg_filename1']; ?>" class="width200 inline valigntop" />
                <?php endif; ?>
                <?php if ($bimg_data[0]['bimg_filename2']) : ?>
                    <img src="<?php echo WEB; ?>/uploads/birthday/<?php echo $bimg_data[0]['bimg_filename2']; ?>" class="width200 inline valigntop" />
                <?php endif; ?>
                <?php if ($bimg_data[0]['bimg_filename3']) : ?>
                    <img src="<?php echo WEB; ?>/uploads/birthday/<?php echo $bimg_data[0]['bimg_filename3']; ?>" class="width200 inline valigntop" />
                <?php endif; 
            endif; 
            
        break;
        case 'clear_search':	
            
            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NUM_ROWS * ($page - 1);
            
            unset($_SESSION['searchactivity']);
            
            $activity_data = $tblsql->get_activities(0, $start, ACT_NUM_ROWS, $searchactivity, 0, 0, 1, 1, 0, $profile_dbname);
            $activity_count = $tblsql->get_activities(0, 0, 0, $searchactivity, 1, 0, 1, 1, 0, $profile_dbname);          

            $pages = $mainsql->pagination("activity", $activity_count, ACT_NUM_ROWS, 9);
            ?>	

            <script src="<?php echo JS; ?>/jquery-1.7.2.min.js"></script>  
            <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui.js"></script>    
            <script type="text/javascript" src="<?php echo JS; ?>/jquery.resizecrop.min.js"></script>
            <script type="text/javascript" src="<?php echo JS; ?>/jquery.flip.js"></script>
            <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui-timepicker-addon.js"></script>    
            <script type="text/javascript">
                
                $("#cards").flip({
                    trigger: 'manual'
                });

                $('.activity_img').resizecrop({
                    width: 140,
                    height: 100,
                    vertical: "top"
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
                                $(".uactatt06").addClass("invisible"); //offreg
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
            </script>
            
            <table border="0" cellspacing="0" class="tdata width100per margintop25">
                <?php if ($activity_data) : ?>
                <?php foreach ($activity_data as $key => $value) : ?>  

                <?php                                        
                    $if_registered = $tblsql->chk_registered($value['activity_id'], $profile_idnum); 
            
                    $countreg = 0;
                    $regdata = $tblsql->get_registrant(0, 0, 0, 0, $value['activity_id']);
                                    
                    if ($value['activity_type'] == 3 || $value['activity_type'] == 6) :
                        if ($value['activity_dependent'] == 1) :
                            foreach ($regdata as $k => $v) :
                                $countreg = $countreg + $v['registry_dependent'];
                            endforeach; 
                            $countreg = $countreg + count($regdata);
                        else :
                            $countreg = count($regdata);
                        endif;
                    elseif ($value['activity_type'] == 1) :
                        if ($value['activity_guest'] == 1) :
                            foreach ($regdata as $k => $v) :
                                $countreg = $countreg + $v['registry_guest'];
                            endforeach; 
                            $countreg = $countreg + count($regdata);
                        else :
                            $countreg = count($regdata);
                        endif;
                    elseif ($value['activity_type'] == 5) :
                        foreach ($regdata as $k => $v) :
                            $countreg = $countreg + $v['registry_child'];
                        endforeach; 
                    else :
                        $countreg = count($regdata);
                    endif;

                    if ((strtotime(date("Y-m-d", $value['activity_datestart'])) <= date("U")) || $if_registered || $value['activity_endregister']) :
                        $disable_reg = 1;
                    else :
                        $disable_reg = 0;
                    endif;

                ?>
                <?php $slot_remain = $value['activity_slots'] - $countreg; ?>
                <tr class="trdata centertalign">
                    <td width="30%"<?php if ($key == 0) : ?> class="topborder"<?php endif; ?>><span attribute="<?php echo $value['activity_id']; ?>" attribute2="<?php echo $value['activity_title']; ?>" class="btnviewactivity"><img src="<?php echo WEB; ?>/uploads/<?php echo $value['activity_ads'] ? 'ads' : 'activity'; ?>/<?php echo $value['activity_filename']; ?>" class="activity_img cursorpoint" /></span></td>
                    <td width="70%" class="lefttalign<?php if ($key == 0) : ?> topborder<?php endif; ?>"><span class="btnviewactivity cursorpoint bold" attribute="<?php echo $value['activity_id']; ?>" attribute2="<?php echo $value['activity_title']; ?>"><?php echo $value['activity_title']; ?></span><?php echo $if_registered ? ' <span class="stamp spangreen">REGISTERED</span>' : ''; ?><br><?php echo date('F j, Y', $value['activity_datestart']); ?> | <?php echo date('g:ia', $value['activity_datestart']); ?> to <?php echo date('g:ia', $value['activity_dateend']); ?><br><?php echo $value['activity_venue']; ?>

                    <?php if(!$disable_reg) : ?>
                    <?php if ($value['activity_id'] != 218) : ?>
                    <br /><br />Total Slots: <?php echo $value['activity_slots']; ?><br />
                    Slots Remaining: <?php echo $slot_remain <= 0 ? 0 : $slot_remain; ?><br />
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($slot_remain > 0) : ?><?php echo $disable_reg ? '' : '<br><span class="btnregactivity cursorpoint" attribute="'.$value['activity_id'].'" attribute2="'.$value['activity_title'].'">Register</span>'; ?><?php endif; ?><?php if ($profile_level == 7 || $profile_level == 10) : ?><?php echo $disable_reg ? '<br>' : ' | '; ?><span onClick="location.href='<?php echo WEB; ?>/registrant?id=<?php echo $value['activity_id']; ?>'" class="cursorpoint">Registrants (<?php echo $countreg; ?>)</span> | <span class="btneditactivity cursorpoint" attribute="<?php echo $value['activity_id']; ?>">Edit</span> | <span class="btndelactivity cursorpoint" attribute="<?php echo $value['activity_id']; ?>">Delete</span><?php endif; ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if ($pages) : ?>
                <tr>
                    <td colspan="2" class="centertalign"><?php echo $pages; ?></td>
                </tr>
                <?php endif; ?>
                <?php else : ?>
                <tr>
                    <td class="bold centertalign noborder"><br><br>You have no activity listed</td>
                </tr>
                <?php endif; ?>
            </table>
            <input type="hidden" id="activitypage" name="activitypage" value="<?php echo $page; ?>" />    
            <?php
        break;
        case 'view':	
            $act_id = $_POST['actid'];
    
            $single_activity = $tblsql->get_activities($act_id);
            
            $if_registered = $tblsql->chk_registered($act_id, $profile_idnum); 
            //var_dump($if_registered);

            if ((strtotime(date("Y-m-d", $single_activity[0]['activity_datestart'])) <= date("U")) || $if_registered || $single_activity[0]['activity_endregister']) :
                $disable_reg = 1;
            else :
                $disable_reg = 0;
            endif;
            
            ?>
            <script type="text/javascript">
                /* FLIP */
                $(function() {
                    $("#cards").flip({
                        trigger: 'manual'
                    });
                    $(".btnreg").click(function() {		
                        $("#cards").flip(true);
                    });
                    $(".btnreg2").click(function() {		
                        $("#cards").flip(false);
                    });
                });
            </script>
            <div class="width100per margintop10 lefttalign">
                <?php echo $tblsql->diamond_killer($single_activity[0]['activity_description']); ?>
            </div>
            <?php if (!$disable_reg) : ?>
            <div class="width100per margintop10 centertalign">
                <button class="bigbtn btnreg"><i class="fa fa-edit"></i> Register</button>
            </div>
            <?php endif; ?>
            <div class="width100per margintop10">
                
                <?php echo $single_activity[0]['activity_datestart'] ? '<b>When:</b> '.date('F j, Y g:ia', $single_activity[0]['activity_datestart']).'<br><br>' : ''; ?>
                <?php echo $single_activity[0]['activity_venue'] ? '<b>Where:</b> '.$single_activity[0]['activity_venue'].'<br><br>' : ''; ?>
                <table class="tdatablk centertalign">
                    <tr>
                        <th width="20%">Approval Required</th>
                        <th width="20%">Guest Allowed</th>
                        <?php echo $single_activity[0]['activity_type'] == 5 ? '<th width="20%">Children Mandatory</th>' : '<th width="20%">Dependent Allowed</th>'; ?>
                        <th width="20%">Company Vehicle</th>
                        <th width="20%">Slots</th>
                    </tr>
                    <tr>
                        <td><?php echo $single_activity[0]['activity_approve'] ? '<i class="fa fa-check greentext"></i>' : '<i class="fa fa-times redtext"></i>'; ?></td>
                        <td><?php echo $single_activity[0]['activity_guest'] ? '<i class="fa fa-check greentext"></i>' : '<i class="fa fa-times redtext"></i>'; ?></td>
                        <td><?php echo ($single_activity[0]['activity_dependent'] || $single_activity[0]['activity_type'] == 5) ? '<i class="fa fa-check greentext"></i>' : '<i class="fa fa-times redtext"></i>'; ?></td>
                        <td><?php echo $single_activity[0]['activity_cvehicle'] ? '<i class="fa fa-check greentext"></i>' : '<i class="fa fa-times redtext"></i>'; ?></td>
                        <td><?php echo $single_activity[0]['activity_slots'] ? $single_activity[0]['activity_slots'] : 'unlimited'; ?></td>
                    </tr>
                </table>
            </div>
            <img src="<?php echo WEB; ?>/uploads/activity/<?php echo $single_activity[0]['activity_filename']; ?>" class="width100per margintop25" />
            
            
            <?php
            
        break;
        case 'viewdata':	
            $act_id = $_POST['actid'];
    
            $single_activity = $tblsql->get_activities($act_id);
            
            foreach ($single_activity as $key => $value) : 
                
                $dateinbreak = explode(" ", date("Y-m-d H:i:s", $value['activity_datestart']));
                $dateoutbreak = explode(" ", date("Y-m-d H:i:s", $value['activity_dateend']));
                $dateinval = $dateinbreak[0];
                $timeinval = $dateinbreak[1];
                $timeoutval = $dateoutbreak[1];
        
                $if_registered = $tblsql->chk_registered($act_id, $profile_idnum); 
        
                if ((strtotime(date("Y-m-d", $value['activity_datestart'])) <= date("U")) || $if_registered || $value['activity_endregister']) :
                    $disable_reg = 1;
                else :
                    $disable_reg = 0;
                endif;
        
                if ($value['activity_approve']) :
                    $approve_reg = 1;
                else :
                    $approve_reg = 0;
                endif;
            
                $count_registry = 0;
                $cnt_registered = $tblsql->cnt_registered($act_id);
                
                if ($value['activity_type'] == 1) :

                    $count_registry = count($cnt_registered); 

                elseif ($value['activity_type'] == 2) :

                    foreach ($cnt_registered as $k => $v) :
                        $count_registry = $count_registry + $v['registry_dependent'];
                        $count_registry = $count_registry + $v['registry_guest'];
                    endforeach; 

                else :

                    $count_registry = count($cnt_registered); 

                endif;
            
                $slot_remain = $value['activity_slots'] - $count_registry;
            
                if ($slot_remain <= 0) : $disable_reg = 1; endif;
    
                echo '{"activity_id":"'.$value['activity_id'].'", "activity_type":"'.$value['activity_type'].'", "activity_title":"'.str_replace("'", "", $value['activity_title']).'", "activity_description":"'.$mainsql->cleannxtline($value['activity_description']).'", "activity_venue":"'.$value['activity_venue'].'", "activity_datein":"'.$dateinval.'", "activity_timein":"'.date('g:ia', $value['activity_datestart']).'", "activity_timeout":"'.date('g:ia', $value['activity_dateend']).'", "activity_approve":"'.$value['activity_approve'].'", "activity_guest":"'.$value['activity_guest'].'", "activity_dependent":"'.$value['activity_dependent'].'", "activity_endregister":"'.$value['activity_endregister'].'", "activity_cvehicle":"'.$value['activity_cvehicle'].'", "activity_ads":"'.$value['activity_ads'].'", "activity_feedback":"'.$value['activity_feedback'].'", "activity_offsite":"'.$value['activity_offsite'].'", "activity_slots":"'.$value['activity_slots'].'", "activity_available":"'.$count_registry.'", "disable_reg":"'.$disable_reg.'", "approve_reg":"'.$approve_reg.'"}';
            
            endforeach; 
            
        break;
        case 'edit':	
            $act_id = $_POST['actid'];
    
            $single_activity = $tblsql->get_activities($act_id);
        
            foreach ($single_activity as $key => $value) : 
    
                echo '{"activity_id":"'.$value['activity_id'].'", "activity_title":"'.str_replace("'", "", $value['activity_title']).'", "activity_type":"'.$value['activity_type'].'", "activity_venue":"'.$value['activity_venue'].'", "activity_description":"'.trim(preg_replace('/\s\s+/', ' ', $value['activity_description'])).'", "activity_dates":"'.date('Y-m-d', $value['activity_datestart']).'", "activity_timein":"'.date('g:ia', $value['activity_datestart']).'", "activity_timeout":"'.date('g:ia', $value['activity_dateend']).'", "activity_approve":"'.$value['activity_approve'].'", "activity_cvehicle":"'.$value['activity_cvehicle'].'", "activity_guest":"'.$value['activity_guest'].'", "activity_dependent":"'.$value['activity_dependent'].'", "activity_feedback":"'.$value['activity_feedback'].'", "activity_offsite":"'.$value['activity_offsite'].'", "activity_ads":"'.$value['activity_ads'].'", "activity_slots":"'.$value['activity_slots'].'", "activity_endregister":"'.$value['activity_endregister'].'", "activity_backout":"'.$value['activity_backout'].'", "activity_filename":"'.$value['activity_filename'].'", "activity_db":"'.$value['activity_db'].'"}';
            
            endforeach; 
        break;
        case 'delete':	
            $act_id = $_POST['actid'];
    
            $del_activity = $tblsql->activity_action(NULL, 'delete', $act_id);			
            if($del_activity) :    
        
                //AUDIT TRAIL
                $post['EMPID'] = $profile_idnum;
                $post['TASKS'] = "DELETE_ACTIVITY";
                $post['DATA'] = $act_id;
                $post['DATE'] = date("m/d/Y H:i:s.000");

                $log = $mainsql->log_action($post, 'add');
        
                return TRUE;
            else :
                return FALSE;
            endif;
        break;
        case 'editreg':	
            $reg_id = $_POST['regid'];
    
            $single_registry = $tblsql->get_registration($reg_id);
        
            foreach ($single_registry as $key => $value) : 
                
                $dateinbreak = explode(" ", date("Y-m-d H:i:s", $value['activity_datestart']));
                $dateoutbreak = explode(" ", date("Y-m-d H:i:s", $value['activity_dateend']));
                $dateinval = $dateinbreak[0];
                $timeinval = $dateinbreak[1];
                $timeoutval = $dateoutbreak[1];
    
                echo '{"registry_id":"'.$value['registry_id'].'", "activity_id":"'.$value['activity_id'].'", "activity_title":"'.$value['activity_title'].'", "activity_venue":"'.$value['activity_venue'].'", "activity_datein":"'.$dateinval.'", "activity_timein":"'.date('g:ia', $value['activity_datestart']).'", "activity_timeout":"'.date('g:ia', $value['activity_dateend']).'", "registry_godirectly":"'.$value['registry_godirectly'].'", "registry_vrin":"'.$value['registry_vrin'].'", "registry_vrout":"'.$value['registry_vrout'].'", "registry_details":"'.$value['registry_details'].'", "registry_platenum":"'.$value['registry_platenum'].'", "registry_dependent":"'.$value['registry_dependent'].'", "registry_guest":"'.$value['registry_guest'].'", "registry_date":"'.date("F j, Y - g:ia", $value['registry_date']).'", "registry_status":"'.$value['registry_status'].'"}';
            
            endforeach; 
        break;
        case 'delreg':	
            $reg_id = $_POST['regid'];
    
            $del_reg = $tblsql->register_action(NULL, 'delete', $reg_id);			
            $del_fback = $tblsql->register_action(NULL, 'delfeedback', $reg_id);			
            
            if($del_reg) :    
        
                //AUDIT TRAIL
                $post['EMPID'] = $profile_idnum;
                $post['TASKS'] = "DELETE_REGISTRATION";
                $post['DATA'] = $reg_id;
                $post['DATE'] = date("m/d/Y H:i:s.000");

                $log = $mainsql->log_action($post, 'add');
        
                return TRUE;
            else :
                return FALSE;
            endif;
        break;
        case 'regtable':
            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NUM_ROWS * ($page - 1);
        
            $my_registration = $tblsql->get_registration(0, 0, 0, 0, $profile_id);
	
            ?>	

            <script src="<?php echo JS; ?>/jquery-1.7.2.min.js"></script>  
            <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui.js"></script>    
            <script type="text/javascript" src="<?php echo JS; ?>/jquery.resizecrop.min.js"></script>
            <script type="text/javascript" src="<?php echo JS; ?>/jquery.flip.js"></script>
            <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui-timepicker-addon.js"></script>    
            <script type="text/javascript">
    
                /* TOOLTIP */
                $(function() {
                    $('.tooltip').tooltip();
                });
                
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
                    $("#fback").removeClass("invisible");
                    $("#fvreg").addClass("invisible");

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
                    <th width="35%">Event Title</th>
                    <th width="10%">Will go directly</th>
                    <th width="20%">Date Registered</th>
                    <th width="15%">Status</th>
                    <th width="25%">Manage</th>
                </tr>

                <?php if ($my_registration) : ?>
                <?php foreach ($my_registration as $key => $value) : ?>
                <?php 
                    $checkfback = $tblsql->get_feedback($profile_id, $value['activity_id'], 1); 
                    $fb_info = $checkfback ? $tblsql->get_feedback(0, 0, 0, $value['registry_id']) : NULL;
                    $nobackout = ($value['activity_datestart'] - 172800) <= date('U') ? 1 : 0;
                    $actfeedback = $value['activity_datestart'] >= date('U') ? 1 : 0;
                ?>
                <tr>
                    <td><a class="whitetext" attribute="<?php echo $value['registry_id']; ?>"><b><?php echo $value['activity_title']; ?></b><?php if ($value['activity_id'] == 150) : ?> (AUTO-REGISTERED)<?php endif; ?></a><?php if ($value['registry_status'] == 2) : ?><br>Confirmation Code: <?php echo $value['activity_id'].'-'.substr($profile_idnum, -4).$value['registry_date']; ?><?php endif; ?><?php echo trim($value['registry_details']) ? '<br><b>Attendees:</b> '.$value['registry_details'] : ''; ?><?php if (!$checkfback && $actfeedback) : ?><br><a class="btnsendfback cursorpoint lgraytext" attribute="<?php echo $value['registry_id']; ?>">Send a feedback</a><?php else : ?><br><a class="tooltip cursorpoint whitetext" title="<?php echo 'Comment: '.$fb_info[0]['fback_comment']; ?>"><?php for($star=1; $star<=$fb_info[0]['fback_rate']; $star++) : ?><i class="fa fa-star lorangetext"></i><?php endfor; ?></a><?php endif; ?></td>
                    <td class="centertalign"><?php echo $value['registry_godirectly'] ? '<i class="fa fa-check greentext"></i>' : '<i class="fa fa-times redtext"></i>'; ?></td>
                    <td class="centertalign"><?php echo date("M j, Y", $value['registry_date']); ?><br><?php echo date("g:ia", $value['registry_date']); ?></td>
                    <td class="centertalign"><?php if ($value['registry_status'] == 2) : echo '<span class="whitetext">Approved</span>'; elseif ($value['registry_status'] == 1) : echo '<span class="whitetext">For Approval</span>'; else : echo '<span class="whitetext">Attended</span>'; endif; ?></td>
                    <td class="centertalign"><?php if (!$nobackout && !$value['activity_backout'] && $value['registry_status'] != 4) : ?> <a class="btndelreg cursorpoint" attribute="<?php echo $value['registry_id']; ?>"><button class="smlbtn btnred">Backout</button></a><?php endif; ?></td>
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
        case 'approvereg':	
            $reg_id = $_POST['regid'];
    
            $app_reg = $tblsql->register_action(NULL, 'approve', $reg_id);			
            if($app_reg) :    
        
                //AUDIT TRAIL
                $post['EMPID'] = $profile_idnum;
                $post['TASKS'] = "APPROVE_REGISTRATION";
                $post['DATA'] = $reg_id;
                $post['DATE'] = date("m/d/Y H:i:s.000");

                $log = $mainsql->log_action($post, 'add');
        
                return TRUE;
            else :
                return FALSE;
            endif;
        break;
        case 'unapprovetable':
            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NUM_ROWS * ($page - 1);
        
            $staff = $tblsql->get_staff($start, NUM_ROWS, 0, $profile_id);
            $staff_count = $tblsql->get_staff(0, 0, 1, $profile_id);

            $pages = $tblsql->pagination("unapprove_register", $staff_count, NUM_ROWS, 9);
	
            ?>	

            <script src="<?php echo JS; ?>/jquery-1.7.2.min.js"></script>  
            <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui.js"></script>    
            <script type="text/javascript" src="<?php echo JS; ?>/jquery.resizecrop.min.js"></script>
            <script type="text/javascript" src="<?php echo JS; ?>/jquery.flip.js"></script>
            <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui-timepicker-addon.js"></script>    
            <script type="text/javascript">
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
                    <th width="50%">Registrants</th>
                    <th width="10%">Will go directly</th>
                    <th width="20%">Date Registered</th>
                    <th width="25%">Status</th>
                </tr>

                <?php if ($staff) : ?>
                <?php foreach ($staff as $key => $value) : ?>
                <?php $act_info = $tblsql->get_activities($value['registry_activityid']); ?>
                <tr>
                    <td><a class="bold whitetext"><?php echo $value['FName'].' '.$value['LName']; ?></a><br>will attend at <?php echo $act_info[0]['activity_title'] ?><br>From <?php echo date('F j, Y g:ia', $act_info[0]['activity_datestart']); ?> to <?php echo date('g:ia', $act_info[0]['activity_dateend']); ?></td>
                    <td class="centertalign"><?php echo $value['registry_godirectly'] ? '<i class="fa fa-check greentext"></i>' : '<i class="fa fa-times redtext"></i>'; ?></td>
                    <td class="centertalign"><?php echo date("M j, Y", $value['registry_date']); ?><br><?php echo date("g:ia", $value['registry_date']); ?></td>
                    <td class="centertalign"><span class="btnregapprove greentext cursorpoint" attribute="<?php echo $value['registry_id']; ?>">Click to Approve</span></td>
                </tr>
                <?php endforeach; ?>
                <?php if ($pages) : ?>
                <tr>
                    <td colspan="4" align="center"><?php echo $pages; ?></td>
                </tr>
                <?php endif; ?>

                <?php else : ?>
                <tr>
                    <td colspan="4" align="center">No activity registrants found</td>
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
            $searchactivity_sess = $_SESSION['searchactivity'];
            if ($_POST['searchactivity']) {        
                $searchactivity = $_POST['searchactivity'] ? $_POST['searchactivity'] : NULL;            
                $_SESSION['searchactivity'] = $searchactivity;
            }
            elseif ($searchactivity_sess) {
                $searchactivity = $searchactivity_sess ? $searchactivity_sess : NULL;
                $_POST['searchactivity'] = $searchactivity != 0 ? $searchactivity : NULL;
            }
            else {
                $searchactivity = NULL;
                $_POST['searchactivity'] = NULL;
            }   

            $activity_data = $tblsql->get_activities(0, $start, ACT_NUM_ROWS, $searchactivity, 0, 0, 1, 1, 0, $profile_dbname);
        $activity_count = $tblsql->get_activities(0, 0, 0, $searchactivity, 1, 0, 1, 1, 0, $profile_dbname);         

            $pages = $mainsql->pagination("activity", $activity_count, ACT_NUM_ROWS, 9);
	
            ?>	

            <script src="<?php echo JS; ?>/jquery-1.7.2.min.js"></script>  
            <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui.js"></script>    
            <script type="text/javascript" src="<?php echo JS; ?>/jquery.resizecrop.min.js"></script>
            <script type="text/javascript" src="<?php echo JS; ?>/jquery.flip.js"></script>
            <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui-timepicker-addon.js"></script>    
            <script type="text/javascript">
                
                $("#cards").flip({
                    trigger: 'manual'
                });

                $('.activity_img').resizecrop({
                    width: 140,
                    height: 100,
                    vertical: "top"
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
                                $(".uactatt06").addClass("invisible"); //offreg
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
            </script>
            
            <table border="0" cellspacing="0" class="tdata width100per margintop25">
                <?php if ($activity_data) : ?>
                <?php foreach ($activity_data as $key => $value) : ?>  

                <?php                                        
                    $if_registered = $tblsql->chk_registered($value['activity_id'], $profile_idnum); 
                    //var_dump($if_registered);

                    $countreg = 0;
                    $regdata = $tblsql->get_registrant(0, 0, 0, 0, $value['activity_id']);
                                    
                    if ($value['activity_type'] == 3 || $value['activity_type'] == 6) :
                        if ($value['activity_dependent'] == 1) :
                            foreach ($regdata as $k => $v) :
                                $countreg = $countreg + $v['registry_dependent'];
                            endforeach; 
                            $countreg = $countreg + count($regdata);
                        else :
                            $countreg = count($regdata);
                        endif;
                    elseif ($value['activity_type'] == 1) :
                        if ($value['activity_guest'] == 1) :
                            foreach ($regdata as $k => $v) :
                                $countreg = $countreg + $v['registry_guest'];
                            endforeach; 
                            $countreg = $countreg + count($regdata);
                        else :
                            $countreg = count($regdata);
                        endif;
                    elseif ($value['activity_type'] == 5) :
                        foreach ($regdata as $k => $v) :
                            $countreg = $countreg + $v['registry_child'];
                        endforeach; 
                    else :
                        $countreg = count($regdata);
                    endif;

                    if ((strtotime(date("Y-m-d", $value['activity_datestart'])) <= date("U")) || $if_registered || $value['activity_endregister']) :
                        $disable_reg = 1;
                    else :
                        $disable_reg = 0;
                    endif;

                ?>
                <?php $slot_remain = $value['activity_slots'] - $countreg; ?>
                <tr class="trdata centertalign">
                    <td width="30%"<?php if ($key == 0) : ?> class="topborder"<?php endif; ?>><span attribute="<?php echo $value['activity_id']; ?>" attribute2="<?php echo $value['activity_title']; ?>" class="btnviewactivity"><img src="<?php echo WEB; ?>/uploads/<?php echo $value['activity_ads'] ? 'ads' : 'activity'; ?>/<?php echo $value['activity_filename']; ?>" class="activity_img cursorpoint" /></span></td>
                    <td width="70%" class="lefttalign<?php if ($key == 0) : ?> topborder<?php endif; ?>"><span class="btnviewactivity cursorpoint bold" attribute="<?php echo $value['activity_id']; ?>" attribute2="<?php echo $value['activity_title']; ?>"><?php echo $value['activity_title']; ?></span><?php echo $if_registered ? ' <span class="stamp spangreen">REGISTERED</span>' : ''; ?><br><?php echo date('F j, Y', $value['activity_datestart']); ?> | <?php echo date('g:ia', $value['activity_datestart']); ?> to <?php echo date('g:ia', $value['activity_dateend']); ?><br><?php echo $value['activity_venue']; ?>

                    <?php if(!$disable_reg) : ?>
                    <?php if ($value['activity_id'] != 218) : ?>
                    <br /><br />Total Slots: <?php echo $value['activity_slots']; ?><br />
                    Slots Remaining: <?php echo $slot_remain <= 0 ? 0 : $slot_remain; ?><br />
                    <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($slot_remain > 0) : ?><?php echo $disable_reg ? '' : '<br><span class="btnregactivity cursorpoint" attribute="'.$value['activity_id'].'" attribute2="'.$value['activity_title'].'">Register</span>'; ?><?php endif; ?><?php if ($profile_level == 7 || $profile_level == 10) : ?><?php echo $disable_reg ? '<br>' : ' | '; ?><span onClick="location.href='<?php echo WEB; ?>/registrant?id=<?php echo $value['activity_id']; ?>'" class="cursorpoint">Registrants (<?php echo $countreg; ?>)</span> | <span class="btneditactivity cursorpoint" attribute="<?php echo $value['activity_id']; ?>">Edit</span> | <span class="btndelactivity cursorpoint" attribute="<?php echo $value['activity_id']; ?>">Delete</span><?php endif; ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if ($pages) : ?>
                <tr>
                    <td colspan="2" class="centertalign"><?php echo $pages; ?></td>
                </tr>
                <?php endif; ?>
                <?php else : ?>
                <tr>
                    <td class="bold centertalign noborder"><br><br>You have no activity listed</td>
                </tr>
                <?php endif; ?>
            </table>
            <input type="hidden" id="activitypage" name="activitypage" value="<?php echo $page; ?>" />   
            <?php
        break;
        default:
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";   
    }            
	
?>			