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
        $notadmin = 0;
    elseif ($_SESSION['megassep_admin']) :
        $profile_level = 10;
        $notadmin = 0;
    else :
        $profile_level = 0;
        $notadmin = 1;
    endif;

    $profile_hash = md5('2014'.$profile_idnum);

	$GLOBALS['level'] = $profile_level;

    $sql = "select count (distinct empid) as approving
    from SUBSIDIARY.dbo.viewGLMEmpSignatory
    where (SIGNATORYID1 = '".$profile_idnum."' and SIGNATORYDB1 = '".$profile_dbname."')
    or (SIGNATORYID2 = '".$profile_idnum."' and SIGNATORYDB2 = '".$profile_dbname."')
    or (SIGNATORYID3 = '".$profile_idnum."' and SIGNATORYDB3 = '".$profile_dbname."')
    or (SIGNATORYID4 = '".$profile_idnum."' and SIGNATORYDB4 = '".$profile_dbname."')
    or (SIGNATORYID5 = '".$profile_idnum."' and SIGNATORYDB5 = '".$profile_dbname."')
    or (SIGNATORYID6 = '".$profile_idnum."' and SIGNATORYDB6 = '".$profile_dbname."')
    AND [TYPE] = 'frmApplicationLVWeb'";
    $isapprover = $mainsql->get_row($sql);
    $isapprover = $isapprover[0]['approving'];

	//***************** USER MANAGEMENT - END *****************\\

    $sec = $profile_id ? $_GET['sec'] : NULL;

    switch ($sec) {
        case 'pstoggle':
            
            $toggleval = $_POST['toggleval'];  
            $empid = $_POST['empid']; 
            $dbname = $_POST['dbname'];             
            
            $ps_toggle = $mainsql->set_psblock($empid, $toggleval, $dbname);
            
            //AUDIT TRAIL
            $post['EMPID'] = $profile_idnum;
            $post['TASKS'] = "PAYSLIP_TOGGLE";
            $post['DATA'] = $empid;
            $post['DATE'] = date("m/d/Y H:i:s.000");

            $log = $mainsql->log_action($post, 'add');
            
            echo $ps_toggle;
            
        break; 
        case 'nebtoggle':
            
            $toggleval = $_POST['toggleval'];  
            $empid = $_POST['empid'];    
            $dbname = $_POST['dbname'];           
            
            $neb_toggle = $mainsql->set_emailblock($empid, $toggleval, 1, $dbname);
            
            echo $neb_toggle;
            
        break;            
        case 'aebtoggle':
            
            $toggleval = $_POST['toggleval'];  
            $empid = $_POST['empid'];    
            $dbname = $_POST['dbname'];           
            
            $aeb_toggle = $mainsql->set_emailblock($empid, $toggleval, 0, $dbname);
            
            echo $aeb_toggle;
            
        break;            
        case 'table':
            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = REQ_NUM_ROWS * ($page - 1);   
        
            if ($_POST['clear_search']) :
        
                unset($_SESSION['searchdtrm']);
        
            else :
            
                $searchdtrm_sess = $_SESSION['searchdtrm'];
                if ($_POST) {        
                    $searchdtrm = $_POST['searchdtrm'] ? $_POST['searchdtrm'] : NULL;            
                    $_SESSION['searchdtrm'] = $searchdtrm;
                }
                elseif ($searchdtrm_sess) {
                    $searchdtrm = $searchdtrm_sess ? $searchdtrm_sess : NULL;
                    $_POST['searchdtrm'] = $searchdtrm != 0 ? $searchdtrm : NULL;
                }
                else {
                    $searchdtrm = NULL;
                    $_POST['searchdtrm'] = NULL;
                }             
        
            endif;

  
            if (strlen($searchdtrm) >= 3) :
                $dtrman_data = $mainsql->get_employee($start, REQ_NUM_ROWS, $searchdtrm, 0);
                $dtrman_count = $mainsql->get_employee(0, 0, $searchdtrm, 1);
                $pages = $mainsql->pagination("dtrman", $dtrman_count, REQ_NUM_ROWS, 9);            
            else :
                $dtrman_data = NULL;
                $dtrman_count = NULL;
                $pages = NULL;
            endif;
            ?>   

            <script type="text/javascript">
                $(function() {	

                    $(".pstoggle").on("click", function() {	

                        toggleval = $(this).attr('attribute');
                        empid = $(this).attr('attribute2');
                        dbname = $(this).attr('attribute3');

                        pstoggleobj = $(this);

                        $.ajax(
                        {
                            url: "<?php echo WEB; ?>/lib/requests/dtrman_request.php?sec=pstoggle",
                            data: "toggleval=" + toggleval + "&empid=" + empid + "&dbname=" + dbname,
                            type: "POST",
                            complete: function(){
                                $("#loading").hide();
                            },
                            success: function(data) {
                                if (toggleval == 1) {
                                    pstoggleobj.attr('attribute', 0);
                                    pstoggleobj.removeClass('fa-times');
                                    pstoggleobj.removeClass('redtext');
                                    pstoggleobj.addClass('fa-check');
                                    pstoggleobj.addClass('greentext');
                                }
                                else {
                                    pstoggleobj.attr('attribute', 1);
                                    pstoggleobj.removeClass('fa-check');
                                    pstoggleobj.removeClass('greentext');
                                    pstoggleobj.addClass('fa-times');
                                    pstoggleobj.addClass('redtext');
                                }

                            }
                        })
                    });

                    $(".nebtoggle").on("click", function() {	

                        toggleval = $(this).attr('attribute');
                        empid = $(this).attr('attribute2');
                        dbname = $(this).attr('attribute3');

                        nebtoggleobj = $(this);

                        $.ajax(
                        {
                            url: "<?php echo WEB; ?>/lib/requests/dtrman_request.php?sec=nebtoggle",
                            data: "toggleval=" + toggleval + "&empid=" + empid + "&dbname=" + dbname,
                            type: "POST",
                            complete: function(){
                                $("#loading").hide();
                            },
                            success: function(data) {
                                if (toggleval == 1) {
                                    nebtoggleobj.attr('attribute', 0);
                                    nebtoggleobj.removeClass('fa-times');
                                    nebtoggleobj.removeClass('redtext');
                                    nebtoggleobj.addClass('fa-check');
                                    nebtoggleobj.addClass('greentext');
                                }
                                else {
                                    nebtoggleobj.attr('attribute', 1);
                                    nebtoggleobj.removeClass('fa-check');
                                    nebtoggleobj.removeClass('greentext');
                                    nebtoggleobj.addClass('fa-times');
                                    nebtoggleobj.addClass('redtext');
                                }

                            }
                        })
                    });

                    $(".aebtoggle").on("click", function() {	

                        toggleval = $(this).attr('attribute');
                        empid = $(this).attr('attribute2');
                        dbname = $(this).attr('attribute3');

                        aebtoggleobj = $(this);

                        $.ajax(
                        {
                            url: "<?php echo WEB; ?>/lib/requests/dtrman_request.php?sec=aebtoggle",
                            data: "toggleval=" + toggleval + "&empid=" + empid + "&dbname=" + dbname,
                            type: "POST",
                            complete: function(){
                                $("#loading").hide();
                            },
                            success: function(data) {
                                if (toggleval == 1) {
                                    aebtoggleobj.attr('attribute', 0);
                                    aebtoggleobj.removeClass('fa-times');
                                    aebtoggleobj.removeClass('redtext');
                                    aebtoggleobj.addClass('fa-check');
                                    aebtoggleobj.addClass('greentext');
                                }
                                else {
                                    aebtoggleobj.attr('attribute', 1);
                                    aebtoggleobj.removeClass('fa-check');
                                    aebtoggleobj.removeClass('greentext');
                                    aebtoggleobj.addClass('fa-times');
                                    aebtoggleobj.addClass('redtext');
                                }

                            }
                        })
                    });

                });
            </script>
            <table border="0" cellspacing="0" class="tdata width100per">
                <?php if ($dtrman_data) : ?>
                <tr>
                    <th width="15%"><?php echo ucfirst($profile_nadd); ?>ID</th>
                    <th width="20%">Last Name</th>
                    <th width="20%">First Name</th>
                    <!--th width="15%">Company</th-->
                    <th width="17%">Payslip Menu</th>
                    <th width="18%" colspan="2">Notification Mail</th>
                    <th width="20%">DTR</th>
                </tr>
                <!--tr>
                    <th width="10%">New Request</th>
                    <th width="10%">Approve/Disapprove Mail</th>
                </tr-->
                <?php foreach ($dtrman_data as $key => $value) : ?> 
                <?php 
                    $chkps = $mainsql->get_psblock($value['EmpID'], $value['DBNAME']); 
                    $chkneb = $mainsql->get_newemailblock($value['EmpID'], $value['DBNAME']);
                    $chkaeb = $mainsql->get_appemailblock($value['EmpID'], $value['DBNAME']);
                ?>
                <tr class="trdata centertalign whitetext">
                    <td><?php echo $value['EmpID']; ?></td>
                    <td><?php echo $value['LName']; ?></td>
                    <td><?php echo $value['FName']; ?></td>
                    <!--td><?php echo $value['DBNAME']; ?></td-->
                    <td class="chkps centertalign"><?php if ($chkps) : ?><i attribute="0" attribute2="<?php echo $value['EmpID']; ?>" attribute3="<?php echo $value['DBNAME']; ?>" class="pstoggle fa fa-check greentext cursorpoint"></i><?php else : ?><i attribute="1" attribute2="<?php echo $value['EmpID']; ?>" attribute3="<?php echo $value['DBNAME']; ?>" class="pstoggle fa fa-times redtext cursorpoint"></i><?php endif; ?></td>
                    <td class="chkps centertalign"><?php if ($chkneb) : ?><i attribute="0" attribute2="<?php echo $value['EmpID']; ?>" class="nebtoggle fa fa-check greentext cursorpoint"></i><?php else : ?><i attribute="1" attribute2="<?php echo $value['EmpID']; ?>" attribute3="<?php echo $value['DBNAME']; ?>" class="nebtoggle fa fa-times redtext cursorpoint"></i><?php endif; ?></td>
                    <td class="chkps centertalign"><?php if ($chkaeb) : ?><i attribute="0" attribute2="<?php echo $value['EmpID']; ?>" attribute3="<?php echo $value['DBNAME']; ?>" class="aebtoggle fa fa-check greentext cursorpoint"></i><?php else : ?><i attribute="1" attribute2="<?php echo $value['EmpID']; ?>" class="aebtoggle fa fa-times redtext cursorpoint"></i><?php endif; ?></td>
                    <td><a href="<?php echo WEB.'/userdtr?id='.md5($value['EmpID']).'&db='.trim($profile_dbname); ?>" class="lorangetext">View/Edit DTR</a></td>
                </tr>
                <?php endforeach; ?>
                <?php if ($pages) : ?>
                <tr>
                    <td colspan="7" class="centertalign"><?php echo $pages; ?></td>
                </tr>
                <?php endif; ?>
                <?php else : ?>
                    <?php if (strlen($searchdtrm) < 3) : ?>
                    <tr>
                        <td class="bold centertalign noborder"><br><br>Search must be minimum of 3 characters <i>* <?php echo $profile_nadd; ?> ID must full (2015-01-XXXX)</i></td>
                    </tr>
                    <?php else : ?>
                    <tr>
                        <td class="bold centertalign noborder"><br><br>No employees listed</td>
                    </tr>
                    <?php endif; ?>
                <?php endif; ?>
            </table>
            <input type="hidden" id="dtrmpage" name="dtrmpage" value="<?php echo $page; ?>" />         

            <?php
        break;
        default:
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";   
        
    }            
	
?>