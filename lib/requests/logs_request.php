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
        default:
        ?>
        <script type="text/javascript">
        
        </script>
        <?php
        break;
     }
     ?>

    <?php

    switch ($sec) {
        case 'table':  

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = LOGS_NUM_ROWS * ($page - 1);   
        
            if ($_POST['clear_search']) :
        
                unset($_SESSION['searchlogs']);
                unset($_SESSION['logsfrom']);
                unset($_SESSION['logsto']);
        
            else :
            
                $searchlogs_sess = $_SESSION['searchlogs'];
                $logsfrom_sess = $_SESSION['logsfrom'];
                $logsto_sess = $_SESSION['logsto'];
                if ($_POST) {        
                    $searchlogs = $_POST['searchlogs'] ? $_POST['searchlogs'] : NULL;            
                    $_SESSION['searchlogs'] = $searchlogs;
                    $logsfrom = $_POST['logsfrom'] ? $_POST['logsfrom'] : NULL;            
                    $_SESSION['logsfrom'] = $logsfrom;
                    $logsto = $_POST['logsto'] ? $_POST['logsto'] : NULL;            
                    $_SESSION['logsto'] = $logsto;
                }
                elseif ($searchlogs_sess) {
                    $searchlogs = $searchlogs_sess ? $searchlogs_sess : NULL;
                    $_POST['searchlogs'] = $searchlogs != 0 ? $searchlogs : NULL;
                    $logsfrom = $logsfrom_sess ? $logsfrom_sess : NULL;
                    $_POST['logsfrom'] = $logsfrom != 0 ? $logsfrom : NULL;
                    $logsto = $logsto_sess ? $logsto_sess : NULL;
                    $_POST['logsto'] = $logsto != 0 ? $logsto : NULL;
                }
                else {
                    $searchlogs = NULL;
                    $_POST['searchlogs'] = NULL;
                    $logsfrom = NULL;
                    $_POST['logsfrom'] = NULL;
                    $logsto = NULL;
                    $_POST['logsto'] = NULL;
                }    
        
            endif;

            $logs_data = $mainsql->get_logs(NULL, $start, LOGS_NUM_ROWS, $searchlogs, 0, ($logsfrom ? date("m/d/Y", strtotime($logsfrom)) : NULL), ($logsfrom ? date("m/d/Y", strtotime($logsto)) : NULL));
            $logs_count = $mainsql->get_logs(NULL, 0, 0, $searchlogs, 1, ($logsfrom ? date("m/d/Y", strtotime($logsfrom)) : NULL), ($logsfrom ? date("m/d/Y", strtotime($logsto)) : NULL));

            $pages = $mainsql->pagination("logs", $logs_count, LOGS_NUM_ROWS, 9);
            ?>   

            <table border="0" cellspacing="0" class="tdata width100per">
                <?php if ($logs_data) : ?>
                <tr>
                    <th width="40%">Employee</th>
                    <th width="20%">Tasks</th>
                    <th width="15%">Data</th>
                    <th width="25%">Date</th>
                </tr>
                <?php foreach ($logs_data as $key => $value) : ?>  
                <?php $emp_info = $register->get_member($value['EmpID']); ?>
                <tr class="btnlogsdata cursorpoint trdata centertalign whitetext">
                    <td><?php echo $emp_info[0]['FName']; ?> <?php echo $emp_info[0]['LName']; ?> (<?php echo $value['EmpID']; ?>)</td>
                    <td><?php echo $value['Tasks']; ?></td>
                    <td><?php echo $value['Data']; ?></td>
                    <td><?php echo date("M j, Y | g:ia", strtotime($value['Date'])); ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if ($pages) : ?>
                <tr>
                    <td colspan="4" class="centertalign"><?php echo $pages; ?></td>
                </tr>
                <?php endif; ?>
                <?php else : ?>
                <tr>
                    <td class="bold centertalign noborder"><br><br>You have no logs</td>
                </tr>
                <?php endif; ?>
            </table>
            <input type="hidden" id="logspage" name="logspage" value="<?php echo $page; ?>" />

            <?php
        break; 
        default:
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";    
        
    }            
	
?>			