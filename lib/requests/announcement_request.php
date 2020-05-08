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

    if (in_array($profile_idnum, $adminarray3)) :
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
        case 'clear_search':	
            
            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NUM_ROWS * ($page - 1);
            
            unset($_SESSION['searchmemo']);
            unset($_SESSION['memofrom']);
            unset($_SESSION['memoto']);
            
            $memo_data = $mainsql->get_memo(0, $start, MEMO_NUM_ROWS, NULL, 0, 0, 0, 2);
            $memo_count = $mainsql->get_memo(0, 0, 0, NULL, 1, 0, 0, 2);

            $pages = $mainsql->pagination("memo", $memo_count, MEMO_NUM_ROWS, 9);
            ?>	

            <script src="<?php echo JS; ?>/jquery-1.7.2.min.js"></script>  
            <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui.js"></script>    
            <script type="text/javascript" src="<?php echo JS; ?>/jquery.resizecrop.min.js"></script>
            <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui-timepicker-addon.js"></script>    
            <script type="text/javascript">
                
            $(".btnviewmemo").on("click", function() {		
                memattach = $(this).attr('attribute');
                window.open("<?php echo WEB; ?>/uploads/" + memattach, "popupWindow", "width=950, height=800, scrollbars=yes");
                return false;
            });
            
            $(".btneditmemo").on("click", function() {		
                $(".floatdiv").removeClass("invisible");
                $("#madd").addClass("invisible");
                $("#medit").removeClass("invisible");
                $(".medit_msg").slideUp();

                memid = $(this).attr('attribute');

                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/announcement_request.php?sec=edit",
                    data: "memid=" + memid,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {
                        var obj = $.parseJSON(data);
                        $("#umemo_title").val(obj.memo_title);                            
                        $("#umemo_date").val(obj.memo_date);                
                        $("#umemo_user").val(obj.memo_user);    
                        $("#umemo_id").val(memid);    
                    }
                })

                return false;
            });

            $(".btndelmemo").on("click", function() {		

                var r = confirm("Are you sure you want to delete this announcement?");
                memid = $(this).attr('attribute');

                if (r == true)
                {
                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/announcement_request.php?sec=delete",
                        data: "memid=" + memid,
                        type: "POST",
                        success: function(data) {                        
                            $.ajax(
                            {
                                url: "<?php echo WEB; ?>/lib/requests/announcement_request.php?sec=table",
                                success: function(data) {                        
                                    $("#memodata").html(data);
                                }
                            })
                        }
                    })

                    return false;
                }

            });
            </script>

            <table border="0" cellspacing="0" class="tdata width100per margintop25">
                <?php if ($memo_data) : ?>
                <?php foreach ($memo_data as $key => $value) : ?>                                    
                <tr class="trdata centertalign">
                    <td width="30%"<?php if ($key == 0) : ?> class="topborder"<?php endif; ?>><span class="btnviewmemo cursorpoint" attribute="<?php echo $value['MemoAttach']; ?>">View</span></td>
                    <td width="70%" class="lefttalign<?php if ($key == 0) : ?> topborder<?php endif; ?>"><span class="btnviewmemo cursorpoint bold" attribute="<?php echo $value['MemoAttach']; ?>"><?php echo $value['MemoName']; ?></span><br>Published: <?php echo date('F j, Y', strtotime($value['MemoDate'])); ?><?php if ($profile_level == 7 || $profile_level == 10) : ?><br><span class="btneditmemo cursorpoint" attribute="<?php echo $value['MemoID']; ?>">Edit</span> | <span class="btndelmemo cursorpoint" attribute="<?php echo $value['MemoID']; ?>">Delete</span><?php endif; ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if ($pages) : ?>
                <tr>
                    <td colspan="2" class="centertalign"><?php echo $pages; ?></td>
                </tr>
                <?php endif; ?>
                <?php else : ?>
                <tr>
                    <td class="bold centertalign noborder"><br><br>You have no announcement listed</td>
                </tr>
                <?php endif; ?>
            </table>
            <input type="hidden" id="memopage" name="memopage" value="<?php echo $page; ?>" />  
            <?php
        break;
        case 'edit':	
            $mem_id = $_POST['memid'];
    
            $single_memo = $mainsql->get_memo($mem_id);
        
            foreach ($single_memo as $key => $value) : 
    
                echo '{"memo_id":"'.$value['MemoID'].'", "memo_title":"'.addslashes($value['MemoName']).'", "memo_date":"'.date('Y-m-d', strtotime($value['MemoDate'])).'", "memo_attach":"'.htmlentities($value['MemoAttach']).'"}';
            
            endforeach; 
        break;
        case 'delete':	
            $mem_id = $_POST['memid'];
    
            $del_memo = $mainsql->memo_action(NULL, 'delete', $mem_id);			
            if($del_memo) :    
        
                //AUDIT TRAIL
                $post['EMPID'] = $profile_idnum;
                $post['TASKS'] = "DELETE_ANN";
                $post['DATA'] = $mem_id;
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
            $searchmemo_sess = $_SESSION['searchmemo'];
            $memofrom_sess = $_SESSION['memofrom'];
            $memoto_sess = $_SESSION['memoto'];
            if ($_POST) {        
                $searchmemo = $_POST['searchmemo'] ? $_POST['searchmemo'] : NULL;            
                $_SESSION['searchmemo'] = $searchmemo;
                $memofrom = $_POST['memofrom'] ? $_POST['memofrom'] : NULL;            
                $_SESSION['memofrom'] = $memofrom;
                $memoto = $_POST['memoto'] ? $_POST['memoto'] : NULL;            
                $_SESSION['memoto'] = $memoto;
            }
            elseif ($searchmemo_sess) {
                $searchmemo = $searchmemo_sess ? $searchmemo_sess : NULL;
                $_POST['searchmemo'] = $searchmemo != 0 ? $searchmemo : NULL;
                $memofrom = $memofrom_sess ? $memofrom_sess : NULL;
                $_POST['memofrom'] = $memofrom != 0 ? $memofrom : NULL;
                $memoto = $memoto_sess ? $memoto_sess : NULL;
                $_POST['memoto'] = $memoto != 0 ? $memoto : NULL;
            }
            else {
                $searchmemo = NULL;
                $_POST['searchmemo'] = NULL;
                $memofrom = NULL;
                $_POST['memofrom'] = NULL;
                $memoto = NULL;
                $_POST['memoto'] = NULL;
            }   
        
            $memo_data = $mainsql->get_memo(0, $start, MEMO_NUM_ROWS, $searchmemo, 0, $memofrom, $memoto, 2);
            $memo_count = $mainsql->get_memo(0, 0, 0, $searchmemo, 1, $memofrom, $memoto, 2);
            
            //var_dump($memo_data);

            $pages = $mainsql->pagination("memo", $memo_count, MEMO_NUM_ROWS, 9);
	
            ?>	

            <script src="<?php echo JS; ?>/jquery-1.7.2.min.js"></script>  
            <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui.js"></script>    
            <script type="text/javascript" src="<?php echo JS; ?>/jquery.resizecrop.min.js"></script>
            <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui-timepicker-addon.js"></script>    
            <script type="text/javascript">
                
            $(".btnviewmemo").on("click", function() {		
                memattach = $(this).attr('attribute');
                window.open("<?php echo WEB; ?>/uploads/" + memattach, "popupWindow", "width=950, height=800, scrollbars=yes");
                return false;
            });
            
            $(".btneditmemo").on("click", function() {		
                $(".floatdiv").removeClass("invisible");
                $("#madd").addClass("invisible");
                $("#medit").removeClass("invisible");
                $(".medit_msg").slideUp();

                memid = $(this).attr('attribute');

                $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/announcement_request.php?sec=edit",
                    data: "memid=" + memid,
                    type: "POST",
                    complete: function(){
                        $("#loading").hide();
                    },
                    success: function(data) {
                        var obj = $.parseJSON(data);
                        $("#umemo_title").val(obj.memo_title);                            
                        $("#umemo_date").val(obj.memo_date);                
                        $("#umemo_user").val(obj.memo_user);    
                        $("#umemo_id").val(memid);    
                    }
                })

                return false;
            });

            $(".btndelmemo").on("click", function() {		

                var r = confirm("Are you sure you want to delete this announcement?");
                memid = $(this).attr('attribute');

                if (r == true)
                {
                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/announcement_request.php?sec=delete",
                        data: "memid=" + memid,
                        type: "POST",
                        success: function(data) {                        
                            $.ajax(
                            {
                                url: "<?php echo WEB; ?>/lib/requests/announcement_request.php?sec=table",
                                success: function(data) {                        
                                    $("#memodata").html(data);
                                }
                            })
                        }
                    })

                    return false;
                }

            });
            </script>

            <table border="0" cellspacing="0" class="tdata width100per margintop25">
                <?php if ($memo_data) : ?>
                <?php foreach ($memo_data as $key => $value) : ?>                                    
                <tr class="trdata centertalign">
                    <td width="30%"<?php if ($key == 0) : ?> class="topborder"<?php endif; ?>><button class="smlbtn btnviewmemo cursorpoint" attribute="<?php echo $value['MemoAttach']; ?>">View</button></td>
                    <td width="70%" class="lefttalign<?php if ($key == 0) : ?> topborder<?php endif; ?>"><span class="btnviewmemo cursorpoint bold" attribute="<?php echo $value['MemoAttach']; ?>"><?php echo $value['MemoName']; ?></span><br>Published: <?php echo date('F j, Y', strtotime($value['MemoDate'])); ?><?php if ($profile_level == 7 || $profile_level == 10) : ?><br><span class="btneditmemo cursorpoint" attribute="<?php echo $value['MemoID']; ?>">Edit</span> | <span class="btndelmemo cursorpoint" attribute="<?php echo $value['MemoID']; ?>">Delete</span><?php endif; ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if ($pages) : ?>
                <tr>
                    <td colspan="2" class="centertalign"><?php echo $pages; ?></td>
                </tr>
                <?php endif; ?>
                <?php else : ?>
                <tr>
                    <td class="bold centertalign noborder"><br><br>You have no announcement listed</td>
                </tr>
                <?php endif; ?>
            </table>
            <input type="hidden" id="memopage" name="memopage" value="<?php echo $page; ?>" />  
            <?php
        break;
        default:
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";   
    }            
	
?>			