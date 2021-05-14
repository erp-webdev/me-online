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

    if ($profile_dbname == "MARKETING") :
        $profile_nadd = 'agent';
    else :
        $profile_nadd = 'employee';
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

    $sec = $profile_id ? $_GET['sec'] : NULL;

    switch ($sec) {
        case 'table': 
            

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = APPR_NUM_ROWS * ($page - 1);   
        
            if ($_POST['clear_search']) :
        
                unset($_SESSION['searchpsman']);
        
            else :
            
                $searchpsman_sess = $_SESSION['searchpsman'];
                if ($_POST) {        
                    $searchpsman = $_POST['searchpsman'] ? $_POST['searchpsman'] : NULL;            
                    $_SESSION['searchpsman'] = $searchpsman;
                }
                elseif ($searchpsman_sess) {
                    $searchpsman = $searchpsman_sess ? $searchpsman_sess : NULL;
                    $_POST['searchpsman'] = $searchpsman != 0 ? $searchpsman : NULL;
                }
                else {
                    $searchpsman = NULL;
                    $_POST['searchpsman'] = NULL;
                }         
        
            endif;

            $psman_data = $tblsql->get_employee_with_inactive($start, APPR_NUM_ROWS, $searchpsman, 0, $profile_dbname);
            $psman_count = $tblsql->get_employee_with_inactive(0, 0, $searchpsman, 1, $profile_dbname);

            $pages = $mainsql->pagination("pslipman", $psman_count, APPR_NUM_ROWS, 9);
            ?>   

            <table border="0" cellspacing="0" class="tdata width100per">
                <?php if ($psman_data) : ?>
                <tr>
                    <th width="20%"><?php echo ucfirst($profile_nadd); ?> ID</th>
                    <th width="30%">Last Name</th>
                    <th width="30%">First Name</th>
                    <th width="20%">Manage</th>
                </tr>
                <?php foreach ($psman_data as $key => $value) : ?>    
                <tr class="trdata centertalign whitetext">
                    <td><?php echo $value['EmpID']; ?></td>
                    <td><?php echo $value['LName']; ?></td>
                    <td><?php echo $value['FName']; ?></td>
                    <td><a href="<?php echo WEB.'/userps?id='.md5($value['EmpID']); ?>" class="lorangetext">View Payslip</a></td>
                </tr>
                <?php endforeach; ?>
                <?php if ($pages) : ?>
                <tr>
                    <td colspan="4" class="centertalign"><?php echo $pages; ?></td>
                </tr>
                <?php endif; ?>
                <?php else : ?>
                <tr>
                    <td class="bold centertalign noborder"><br><br>You have no employees listed</td>
                </tr>
                <?php endif; ?>
            </table>
            <input type="hidden" id="psmanpage" name="psmanpage" value="<?php echo $page; ?>" />          

            <?php
        break;
        default:
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";   
        
    }            
	
?>