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

    ?>

    <script type="text/javascript">
    </script>

    <?php

    switch ($sec) {
        case 'data':
            
            $loanledgerdata = $_POST['applyto'];
            $loan_data = $mainsql->get_loandata($loanledgerdata);
            
            ?>

            <table border="0" cellspacing="0" class="tdata" style="width: 100%">
                <tr>
                    <th width="10%">Rec No.</th>
                    <th width="10%">PRYear</th>
                    <th width="15%">Refernce Date</th>
                    <th width="20%">Loan Description</th>
                    <th width="15%">Loan Amount</th>
                    <th width="15%">Payment</th>
                    <th width="15%">Balance</th>
                </tr>
                <?php 
                    if ($loan_data) :
                         
                        $payslip_oddesc = $mainsql->get_payslip_oddesc();

                        foreach ($loan_data as $key => $value) : 
                            switch($value['TranType']) :
                                case 'L':
                                ?>
                                <tr class="trdata centertalign">
                                    <td><?php echo $value['SeqID']; ?></td>
                                    <td><?php echo $value['PRYear']; ?></td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <?php //echo $value['OExtID']; ?>
                                        <?php
                                            if ($value['OExtID'] == 'OD01') : echo $payslip_oddesc[0]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD02') : echo $payslip_oddesc[1]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD03') : echo $payslip_oddesc[2]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD04') : echo $payslip_oddesc[3]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD05') : echo $payslip_oddesc[4]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD06') : echo $payslip_oddesc[5]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD07') : echo $payslip_oddesc[6]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD08') : echo $payslip_oddesc[7]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD09') : echo $payslip_oddesc[8]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD10') : echo $payslip_oddesc[9]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD11') : echo $payslip_oddesc[10]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD12') : echo $payslip_oddesc[11]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD13') : echo $payslip_oddesc[12]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD14') : echo $payslip_oddesc[13]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD15') : echo $payslip_oddesc[14]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD16') : echo $payslip_oddesc[15]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD17') : echo $payslip_oddesc[16]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD18') : echo $payslip_oddesc[17]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD19') : echo $payslip_oddesc[18]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD20') : echo $payslip_oddesc[19]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD21') : echo $payslip_oddesc[20]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD22') : echo $payslip_oddesc[21]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD23') : echo $payslip_oddesc[22]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD24') : echo $payslip_oddesc[23]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD25') : echo $payslip_oddesc[24]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD26') : echo $payslip_oddesc[25]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD27') : echo $payslip_oddesc[26]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD28') : echo $payslip_oddesc[27]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD29') : echo $payslip_oddesc[28]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD30') : echo $payslip_oddesc[29]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD31') : echo $payslip_oddesc[30]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD32') : echo $payslip_oddesc[31]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD33') : echo $payslip_oddesc[32]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD34') : echo $payslip_oddesc[33]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD35') : echo $payslip_oddesc[34]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD36') : echo $payslip_oddesc[35]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD37') : echo $payslip_oddesc[36]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD38') : echo $payslip_oddesc[37]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD39') : echo $payslip_oddesc[38]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD40') : echo $payslip_oddesc[39]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD41') : echo $payslip_oddesc[40]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD42') : echo $payslip_oddesc[41]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD43') : echo $payslip_oddesc[42]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD44') : echo $payslip_oddesc[43]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD45') : echo $payslip_oddesc[44]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD46') : echo $payslip_oddesc[45]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD47') : echo $payslip_oddesc[46]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD48') : echo $payslip_oddesc[47]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD49') : echo $payslip_oddesc[48]["OExtDesc"];
                                            elseif ($value['OExtID'] == 'OD50') : echo $payslip_oddesc[49]["OExtDesc"];
                                            endif; 
                                        ?>
                                    </td> <td><?php echo number_format($value['TotalPayable'], 2, '.', ','); ?></td>
                                    <td>&nbsp;</td>                     
                                    <td><?php echo number_format($balance += $value['TotalPayable'], 2, '.', ','); ?></td>
                                </tr>
                                <?php
                                break;
                                case 'P':
                                ?>
                                <tr class="trdata centertalign">
                                    <td><?php echo $value['SeqID']; ?></td>
                                    <td><?php echo $value['PRYear']; ?></td>
                                    <td><?php echo date('M j, Y', strtotime($value['RefDate'])); ?></td>
                                    <td>&nbsp;</td> 
                                    <td>&nbsp;</td>
                                    <td><?php echo number_format(abs($value['Amount']), 2, '.', ','); ?></td>             
                                    <td><?php echo number_format($balance += $value['Amount'], 2, '.', ','); ?></td>
                                </tr>
                                <?php
                                break;
                            endswitch;
                        endforeach;
                        ?>
                        <tr class="trdata">
                            <td colspan="6" class="lefttalign bold">Balance:</td>
                            <td class="centertalign"><?php echo number_format($balance, 2, '.', ','); ?></td>
                        </tr>
                        <?php
                    else :
                        ?>
                        <tr class="trdata">
                            <td colspan="4" class="centertalign">No record found</td>
                        </tr>    
                        <?php                                            
                    endif;
                ?>
            </table>
                    
            <?php
            
            //var_dump($approver_data1);
            
        break;
        default:
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";   
        
    }            
	
?>			