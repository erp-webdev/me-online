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
        $adminarray = array("2014-05-N791", "2009-09-V206", "2012-04-U384", "MASTER", "2012-03-U273", '2019-06-0321', '2022-06-0015');
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
        case 'clear_search':	
            
            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NUM_ROWS * ($page - 1);
            
            unset($_SESSION['searchads']);
        
            $ads_data = $tblsql->get_activities(0, $start, ACT_NUM_ROWS, NULL, 0, 0, 1, 2, 0, $profile_dbname);
            $ads_count = $tblsql->get_activities(0, 0, 0, NULL, 1, 0, 1, 2, 0, $profile_dbname);        

            $pages = $mainsql->pagination("ads", $ads_count, ACT_NUM_ROWS, 9);
	
            ?>	

            <script src="<?php echo JS; ?>/jquery-1.7.2.min.js"></script>  
            <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui.js"></script>    
            <script type="text/javascript" src="<?php echo JS; ?>/jquery.resizecrop.min.js"></script>
            <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui-timepicker-addon.js"></script>    
            <script type="text/javascript">

                $('.activity_img').resizecrop({
                    width: 140,
                    height: 100,
                    vertical: "top"
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
                            $("#uactivity_user").val(obj.activity_user);              
                            $("#uactivity_filename").val(obj.activity_filename);   
                            $("#uactivity_db").val(obj.activity_db);           
                            $("#uactivity_id").val(adid);    
                        }
                    });
                });
            </script>

            <table border="0" cellspacing="0" class="tdata width100per margintop25">
                <?php if ($ads_data) : ?>
                <?php foreach ($ads_data as $key => $value) : ?>                                    
                <tr class="trdata centertalign">
                    <td width="30%"<?php if ($key == 0) : ?> class="topborder"<?php endif; ?>><span attribute="<?php echo $value['activity_id']; ?>" attribute2="<?php echo $value['activity_title']; ?>" class="btnviewads"><img src="<?php echo WEB; ?>/uploads/<?php echo $value['activity_ads'] ? 'ads' : 'activity'; ?>/<?php echo $value['activity_filename']; ?>" class="activity_img cursorpoint" /></span></td>
                    <td width="70%" class="lefttalign<?php if ($key == 0) : ?> topborder<?php endif; ?>"><span class="btnviewads cursorpoint bold" attribute="<?php echo $value['activity_id']; ?>" attribute2="<?php echo $value['activity_title']; ?>"><?php echo $value['activity_title']; ?></span><?php if ($profile_level == 7 || $profile_level == 10) : ?><br><span class="btneditads cursorpoint" attribute="<?php echo $value['activity_id']; ?>">Edit</span> | <span class="btndelads cursorpoint" attribute="<?php echo $value['activity_id']; ?>">Delete</span><?php endif; ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if ($pages) : ?>
                <tr>
                    <td colspan="2" class="centertalign"><?php echo $pages; ?></td>
                </tr>
                <?php endif; ?>
                <?php else : ?>
                <tr>
                    <td class="bold centertalign noborder"><br><br>You have no ads listed</td>
                </tr>
                <?php endif; ?>
            </table>
            <input type="hidden" id="adspage" name="adspage" value="<?php echo $page; ?>" />
            <?php
        break;
        case 'view':	
            $act_id = $_POST['actid'];
    
            $single_activity = $tblsql->get_activities($act_id);
            $largeword = array('View this Ad on Different Level', 'YES, Make it Bigger', 'Don\'t See Anything with this Tiny Image?');
            $whatlword = $largeword[rand(0, 2)];
            
            ?>
            <div class="centertalign">
                <img src="<?php echo WEB; ?>/uploads/ads/<?php echo $single_activity[0]['activity_filename']; ?>" class="width100per" />
                <a href="<?php echo WEB; ?>/uploads/ads/<?php echo $single_activity[0]['activity_filename']; ?>" target="_blank"><button class="bigbtn"><?php echo $whatlword; ?></button></a>
            </div>
            <?php
            
        break;
        case 'edit':	
            $ad_id = $_POST['adid'];
    
            $single_ad = $tblsql->get_activities($ad_id);
        
            foreach ($single_ad as $key => $value) : 
                echo '{"activity_id":"'.$value['activity_id'].'", "activity_title":"'.str_replace("'", "", $value['activity_title']).'", "activity_date":"'.date('Y-m-d', $value['activity_date']).'", "activity_filename":"'.$value['activity_filename'].'", "activity_db":"'.$value['activity_db'].'"}';
            endforeach; 
        break;
        case 'delete':	
            $ad_id = $_POST['adid'];
    
            $del_ad = $tblsql->ads_action(NULL, 'delete', $ad_id);			
            if($del_ad) :    
        
                //AUDIT TRAIL
                $post['EMPID'] = $profile_idnum;
                $post['TASKS'] = "DELETE_ADS";
                $post['DATA'] = $ad_id;
                $post['DATE'] = date("m/d/Y H:i:s.000");

                $log = $mainsql->log_action($post, 'add');
        
                return TRUE;
            else :
                return FALSE;
            endif;
        break;
        case 'table':
            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NUM_ROWS * ($page - 1);
        
            // SEARCH
            $searchads_sess = $_SESSION['searchads'];
            if ($_POST['searchads']) {        
                $searchads = $_POST['searchads'] ? $_POST['searchads'] : NULL;            
                $_SESSION['searchads'] = $searchads;
            }
            elseif ($searchads_sess) {
                $searchads = $searchads_sess ? $searchads_sess : NULL;
                $_POST['searchads'] = $searchads != 0 ? $searchads : NULL;
            }
            else {
                $searchads = NULL;
                $_POST['searchads'] = NULL;
            }  
        
            $ads_data = $tblsql->get_activities(0, $start, ACT_NUM_ROWS, $searchads, 0, 0, 1, 2, 0, $profile_dbname);
            $ads_count = $tblsql->get_activities(0, 0, 0, $searchads, 1, 0, 1, 2, 0, $profile_dbname);        

            $pages = $mainsql->pagination("ads", $ads_count, ACT_NUM_ROWS, 9);
	
            ?>	

            <script src="<?php echo JS; ?>/jquery-1.7.2.min.js"></script>  
            <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui.js"></script>    
            <script type="text/javascript" src="<?php echo JS; ?>/jquery.resizecrop.min.js"></script>
            <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui-timepicker-addon.js"></script>    
            <script type="text/javascript">

                $('.activity_img').resizecrop({
                    width: 140,
                    height: 100,
                    vertical: "top"
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
                        $("#uactivity_user").val(obj.activity_user);            
                        $("#uactivity_filename").val(obj.activity_filename);   
                        $("#uactivity_db").val(obj.activity_db);           
                        $("#uactivity_id").val(adid);    
                    }
                });
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
            </script>

            <table border="0" cellspacing="0" class="tdata width100per margintop25">
                <?php if ($ads_data) : ?>
                <?php foreach ($ads_data as $key => $value) : ?>                                    
                <tr class="trdata centertalign">
                    <td width="30%"<?php if ($key == 0) : ?> class="topborder"<?php endif; ?>><span attribute="<?php echo $value['activity_id']; ?>" attribute2="<?php echo $value['activity_title']; ?>" class="btnviewads"><img src="<?php echo WEB; ?>/uploads/<?php echo $value['activity_ads'] ? 'ads' : 'activity'; ?>/<?php echo $value['activity_filename']; ?>" class="activity_img cursorpoint" /></span></td>
                    <td width="70%" class="lefttalign<?php if ($key == 0) : ?> topborder<?php endif; ?>"><span class="btnviewads cursorpoint bold" attribute="<?php echo $value['activity_id']; ?>" attribute2="<?php echo $value['activity_title']; ?>"><?php echo $value['activity_title']; ?></span><?php if ($profile_level == 7 || $profile_level == 10) : ?><br><span class="btneditads cursorpoint" attribute="<?php echo $value['activity_id']; ?>">Edit</span> | <span class="btndelads cursorpoint" attribute="<?php echo $value['activity_id']; ?>">Delete</span><?php endif; ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if ($pages) : ?>
                <tr>
                    <td colspan="2" class="centertalign"><?php echo $pages; ?></td>
                </tr>
                <?php endif; ?>
                <?php else : ?>
                <tr>
                    <td class="bold centertalign noborder"><br><br>You have no ads listed</td>
                </tr>
                <?php endif; ?>
            </table>
            <input type="hidden" id="adspage" name="adspage" value="<?php echo $page; ?>" />
            <?php
        break;
        default:
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";   
    }            
	
?>			