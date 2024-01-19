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

    $sec = $profile_id ? $_GET['sec'] : NULL;

    switch ($sec) {
        case 'numdep':
            $numdep = $_POST["numdep"] ? (int)$_POST["numdep"] : 0;
            $empid = $_POST["empid"] ? $_POST["empid"] : NULL;
            $dbname = $_POST["dbname"] ? $_POST["dbname"] : NULL;

            $dependent_data = $mainsql->get_dep_data($empid, $dbname);

            for ($idep=0; $idep<$numdep; $idep++) :
                ?>
                <script type="text/javascript">
                    $(".datepick2").datepicker({
                        dateFormat: 'yy-mm-dd',
                        maxDate: "0D",
                        changeMonth: true,
                        changeYear: true
                    });
                </script>
                <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                    <tr>
                        <td><span class="lorangetext">*</span> Name<br><input attribute="Dependent Name" type="text" name="Dependent[<?php echo $idep; ?>]" size="35" id="Dependent<?php echo $idep; ?>" onChange="upperCase(this)" value="<?php echo $dependent_data[$idep]['Dependent']; ?>" class="txtbox"></td>
						<td>Relationship <br>
							<select attribute="Dependent Relation" type="text" name="Relation[<?php echo $idep; ?>]" id="Relation<?php echo $idep; ?>" onChange="upperCase(this)" class="txtbox">
								<option value="" selected>Select...</option>
								<option value="FATHER"<?php echo $dependent_data['Relation'] == 'FATHER' ? ' selected' : ''; ?>>FATHER</option>
								<option value="MOTHER"<?php echo $dependent_data['Relation'] == 'MOTHER' ? ' selected' : ''; ?>>MOTHER</option>
								<option value="CHILD"<?php echo $dependent_data['Relation'] == 'CHILD' ? ' selected' : ''; ?>>CHILD</option>
							</select>
						</td>
						<td>Gender <br>
                            <select attribute="Dependent Gender" type="text" name="Gender[<?php echo $idep; ?>]" id="Gender<?php echo $idep; ?>" onChange="upperCase(this)" class="txtbox">
                                <option value="F"<?php echo $dependent_data[$idep]['Gender'] == 'F' ? ' selected' : ''; ?>>F</option>
                                <option value="M"<?php echo $dependent_data[$idep]['Gender'] == 'M' ? ' selected' : ''; ?>>M</option>
                            </select>
                        </td>
                        <td>Birthdate <br><input attribute="Dependent Birthdate" type="text" name="Birthdate[<?php echo $idep; ?>]" size="15" id="Birthdate<?php echo $idep; ?>" value="<?php echo date('Y-m-d', strtotime($dependent_data[$idep]['Birthdate'])); ?>" class="datepick2 txtbox" readonly></td>
                        <td>PWD <br><input attribute="Dependent PWD" type="checkbox" name="pwd[<?php echo $idep; ?>]" size="15" id="pwd<?php echo $idep; ?>" value="1"<?php $dependent_data[$idep]['pwd'] ? ' checked' : ''; ?>>
                        <input type="hidden" name="SeqID[<?php echo $idep; ?>]" id="SeqID<?php echo $idep; ?>" value="<?php echo $dependent_data[$idep]['SeqID']; ?>"></td>
                    </tr>
                </table>
                <?php
            endfor;
        break;
        case 'deldep':
            $depid = $_POST["depid"];

            $dependent_data = $logsql->del_dependent(NULL, $depid);

        break;
        case 'empdep':
            $empid = $_POST["emphash"];

            $dependent_data = $logsql->get_depdata_by_hash($empid);

            ?>
            <script type="text/javascript">
                $(".datepick2").datepicker({
                    dateFormat: 'yy-mm-dd',
                    maxDate: "0D",
                    changeMonth: true,
                    changeYear: true
                });
            </script>
            <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                <?php foreach ($dependent_data as $key => $value) :
                    ?>
                    <tr>
                        <td><span class="lorangetext">*</span> Name<br><input attribute="Dependent Name" type="text" name="Dependent[<?php echo $idep; ?>]" size="30" id="Dependent<?php echo $idep; ?>" onChange="upperCase(this)" value="<?php echo $value['Dependent']; ?>" class="txtbox"></td>
                        <td>Gender <br>
                            <select attribute="Dependent Gender" type="text" name="Gender[<?php echo $idep; ?>]" id="Gender<?php echo $idep; ?>" onChange="upperCase(this)" class="txtbox">
                                <option value="F"<?php echo $value['Gender'] == 'F' ? ' selected' : ''; ?>>F</option>
                                <option value="M"<?php echo $value['Gender'] == 'M' ? ' selected' : ''; ?>>M</option>
                            </select>
                        </td>
                        <td>Relationship <br><input attribute="Dependent Relation" type="text" name="Relation[<?php echo $idep; ?>]" size="20" id="Relation<?php echo $idep; ?>" onChange="upperCase(this)" value="<?php echo $value['Relation']; ?>" class="txtbox"></td>
                        <td>Birthdate <br><input attribute="Dependent Birthdate" type="text" name="Birthdate[<?php echo $idep; ?>]" size="15" id="Birthdate<?php echo $idep; ?>" value="<?php echo date('Y-m-d', strtotime($value['Birthdate'])); ?>" class="datepick2 txtbox" readonly></td>
                        <td>PWD <br><input attribute="Dependent PWD" type="checkbox" name="pwd[<?php echo $idep; ?>]" size="15" id="pwd<?php echo $idep; ?>" value="1"<?php echo $value['pwd'] ? ' checked' : ''; ?>>
                        <input type="hidden" name="SeqID[<?php echo $idep; ?>]" id="SeqID<?php echo $idep; ?>" value="<?php echo $value['SeqID']; ?>"></td>
                        <td><?php echo !$value['SeqID'] ? '<span attribute="'.$value['DepID'].'" class="deldept fa fa-times redtext cursorpoint"></span>' : ''; ?></td>
                    </tr>
                    <?php
                    $idep++;
                endforeach; ?>
            </table>
            <?php
        break;
        case 'table':

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = APPR_NUM_ROWS * ($page - 1);

            if ($_POST['clear_search']) :

                unset($_SESSION['searchappr']);

            else :

                $searchappr_sess = $_SESSION['searchappr'];
                if ($_POST) {
                    $searchappr = $_POST['searchappr'] ? $_POST['searchappr'] : NULL;
                    $_SESSION['searchappr'] = $searchappr;
                }
                elseif ($searchappr_sess) {
                    $searchappr = $searchappr_sess ? $searchappr_sess : NULL;
                    $_POST['searchappr'] = $searchappr != 0 ? $searchappr : NULL;
                }
                else {
                    $searchappr = NULL;
                    $_POST['searchappr'] = NULL;
                }

            endif;

            $upddate_data = $tblsql->get_upemployee2($start, APPR_NUM_ROWS, $searchappr, 0);
            //var_dump($upddate_data);
            $upddate_count = $tblsql->get_upemployee2(0, 0, $searchappr, 1);

            $pages = $mainsql->pagination("empupdate", $upddate_count, APPR_NUM_ROWS, 9);
            ?>

            <table border="0" cellspacing="0" class="tdata width100per">
                <?php if ($upddate_data) : ?>
                <tr>
                    <th width="15%"><?php echo ucfirst($profile_nadd); ?>ID</th>
                    <th width="23%">Last Name</th>
                    <th width="22%">First Name</th>
                    <th width="20%">Company</th>
                    <th width="20%">Manage</th>
                </tr>
                <?php foreach ($upddate_data as $key => $value) : ?>
                <tr class="btnupddata cursorpoint trdata centertalign whitetext" attribute="<?php echo $value['EmpID']; ?>">
                    <td><?php echo $value['EmpID']; ?></td>
                    <td><?php echo $value['LName']; ?></td>
                    <td><?php echo $value['FName']; ?></td>
                    <td><?php echo $value['DBNAME']; ?></td>
                    <td><a href="<?php echo WEB.'/idprofile?id='.md5($value['EmpID']); ?>" class="lorangetext">View/Approved Profile</a></td>
                </tr>
                <?php endforeach; ?>
                <?php if ($pages) : ?>
                <tr>
                    <td colspan="4" class="centertalign"><?php echo $pages; ?></td>
                </tr>
                <?php endif; ?>
                <?php else : ?>
                <tr>
                    <td class="bold centertalign noborder"><br><br>You have no employees updates listed</td>
                </tr>
                <?php endif; ?>
            </table>
            <input type="hidden" id="updpage" name="updpage" value="<?php echo $page; ?>" />

            <?php
        break;
        default:
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";

    }

?>
