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
        case 'clear_search':	
            
            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NUM_ROWS * ($page - 1);
            
            unset($_SESSION['searchform']);
        
            $form_cat = $tblsql->get_form(0, 0, 0, NULL, 0, NULL, 1);
            $form_count = $tblsql->get_form(0, 0, 0, NULL, 1, NULL, 0);
	
            ?>	

            <script src="<?php echo JS; ?>/jquery-1.7.2.min.js"></script>  
            <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui.js"></script>    
            <script type="text/javascript" src="<?php echo JS; ?>/jquery.resizecrop.min.js"></script>
            <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui-timepicker-addon.js"></script>    
            <script type="text/javascript">

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
            </script>
            
            <div class="valigntop<?php if ($form_count > 20) : ?> twocolumn2<?php endif; ?> width100per margintop25">
                <ul class="downlist">                        
                <?php if ($form_cat) : ?>
                <?php foreach ($form_cat as $key => $value) : ?>                            
                    <?php if ($value['download_cat'] != '0') : ?>
                        <div class="roboto cattext2 margintop30bot20"><?php echo $value['download_cat']; ?></div>
                    <?php endif; ?>
                    <?php $forms = $tblsql->get_form(0, 0, 0, NULL, 0, $value['download_cat'], 0); ?>
                    <?php if ($forms) : ?>
                    <?php foreach ($forms as $k => $v) : ?>                            
                    <li>
                        <a href="<?php echo WEB; ?>/uploads/download/<?php echo $v['download_filename']; ?>" target="_blank">
                            <b><i class="fa <?php echo $tblsql->get_form_icon($v['download_attachtype'], $v['download_filename']); ?> fa-lg"></i>&nbsp;&nbsp;<?php echo $v['download_title']; ?></b></a><br>&nbsp;&nbsp;&nbsp;&nbsp;<?php if ($profile_level == 7 || $profile_level == 10) : ?> <a class="btneditform whitetext cursorpoint" attribute="<?php echo $v['download_id']; ?>">Edit</a> | <a class="btndelform redtext cursorpoint" attribute="<?php echo $v['download_id']; ?>">Delete</a><?php endif; ?>

                    </li>
                    <?php endforeach; ?>
                    <?php else : ?>No form found on this category<?php endif; ?>
                <?php endforeach; ?>
                <?php if ($pages) : ?>
                <tr>
                    <td colspan="2" align="center"><?php echo $pages; ?></td>
                </tr>
                <?php endif; ?>
                <?php else : ?>No form category found<?php endif; ?>
                </ul>                  
            </div>
            <?php
        break;
        case 'view':	
            $act_id = $_POST['actid'];
    
            $single_activity = $tblsql->get_activities($act_id);
            
            ?>
            <img src="<?php echo WEB; ?>/uploads/ads/<?php echo $single_activity[0]['activity_filename']; ?>" class="width100per" />
            <?php
            
        break;
        case 'edit':	
            $form_id = $_POST['formid'];
    
            $single_form = $tblsql->get_form($form_id);
        
            foreach ($single_form as $key => $value) : 
    
                echo '{"download_id":"'.$value['download_id'].'", "download_title":"'.addslashes($value['download_title']).'", "download_cat":"'.$value['download_cat'].'"}';
            
            endforeach; 
        break;
        case 'delete':	
            $form_id = $_POST['formid'];
    
            $del_form = $tblsql->form_action(NULL, 'delete', $form_id);			
            if($del_form) :    
        
                //AUDIT TRAIL
                $post['EMPID'] = $profile_idnum;
                $post['TASKS'] = "DELETE_FORM";
                $post['DATA'] = $form_id;
                $post['DATE'] = date("m/d/Y H:i:s.000");

                $log = $mainsql->log_action($post, 'add');
            
                //$log = $mainsql->log_action("DELETE_MEMO", $mem_id, $profile_id);
        
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
            $searchform_sess = $_SESSION['searchform'];
            if ($_POST['searchform']) {        
                $searchform = $_POST['searchform'] ? $_POST['searchform'] : NULL;            
                $_SESSION['searchform'] = $searchform;
            }
            elseif ($searchform_sess) {
                $searchform = $searchform_sess ? $searchform_sess : NULL;
                $_POST['searchform'] = $searchform != 0 ? $searchform : NULL;
            }
            else {
                $searchform = NULL;
                $_POST['searchform'] = NULL;
            }  
        
            $form_cat = $tblsql->get_form(0, 0, 0, NULL, 0, NULL, 1);
            $form_count = $tblsql->get_form(0, 0, 0, NULL, 1, NULL, 0);  
	
            ?>	

            <script src="<?php echo JS; ?>/jquery-1.7.2.min.js"></script>  
            <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui.js"></script>    
            <script type="text/javascript" src="<?php echo JS; ?>/jquery.resizecrop.min.js"></script>
            <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui-timepicker-addon.js"></script>    
            <script type="text/javascript">
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
            </script>

            
            <div class="valigntop<?php if ($form_count > 20) : ?> twocolumn2<?php endif; ?> width100per margintop25">
                <ul class="downlist">                        
                <?php if ($form_cat) : ?>
                <?php foreach ($form_cat as $key => $value) : ?>                            
                    <?php if ($value['download_cat'] != '0') : ?>
                        <div class="roboto cattext2 margintop30bot20"><?php echo $value['download_cat']; ?></div>
                    <?php endif; ?>
                    <?php $forms = $tblsql->get_form(0, 0, 0, $searchform, 0, $value['download_cat'], 0); ?>
                    <?php if ($forms) : ?>
                    <?php foreach ($forms as $k => $v) : ?>                            
                    <li>
                        <a href="<?php echo WEB; ?>/uploads/download/<?php echo $v['download_filename']; ?>" target="_blank">
                            <b><i class="fa <?php echo $tblsql->get_form_icon($v['download_attachtype'], $v['download_filename']); ?> fa-lg"></i>&nbsp;&nbsp;<?php echo $v['download_title']; ?></b></a><br>&nbsp;&nbsp;&nbsp;&nbsp;<?php if ($profile_level == 7 || $profile_level == 10) : ?>  <a class="btneditform whitetext cursorpoint" attribute="<?php echo $v['download_id']; ?>">Edit</a> | <a class="btndelform redtext cursorpoint" attribute="<?php echo $v['download_id']; ?>">Delete</a><?php endif; ?>

                    </li>
                    <?php endforeach; ?>
                    <?php else : ?>No form found on this category<?php endif; ?>
                <?php endforeach; ?>
                <?php if ($pages) : ?>
                <tr>
                    <td colspan="2" align="center"><?php echo $pages; ?></td>
                </tr>
                <?php endif; ?>
                <?php else : ?>No form category found<?php endif; ?>
                </ul>                  
            </div>
            <?php
        break;
        default:
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";   
    }            
	
?>			