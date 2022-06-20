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
    elseif ($profile_dbname == "CITYLINK" || $profile_dbname == "ECOC" || $profile_dbname == "EREX" || $profile_dbname == "FIRSTCENTRO" || $profile_dbname == "LCTM" || $profile_dbname == "MLI" || $profile_dbname == "NCCAI" || $profile_dbname == "SUNTRUST" || $profile_dbname == "TOWNSQUARE" || $profile_dbname == "NEWTOWN") :
        $adminarray = array("2009-10-V255", '2016-06-0457');
    elseif ($profile_dbname == "GL") :
        $adminarray = array("2014-10-0004", "2014-10-0568", "2016-03-0261", "2017-01-0792", '2016-06-0457');
    else :
        $adminarray = array("2014-05-N791", "2009-09-V206", "2012-04-U384", "MASTER", "2012-03-U273", "2014-01-N506", '2016-06-0457');
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

            ?>

            <script type="text/javascript">

                $(".btnapprdata").on("click", function() {

                    empid = $(this).attr('attribute');
                    dbnames = $(this).attr('attribute2');

                    $(".btnapprovers").addClass('invisible');

                    $('.appr_msg').slideUp();
                    $("#appr_data").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');

                    $("#appr_title").html('Approver Management for <?php echo ucfirst($profile_nadd); ?>ID #' + empid);
                    $(".floatdiv").removeClass("invisible");
                    $(".fedit2").show({
                        effect : 'slide',
                        easing : 'easeOutQuart',
                        direction : 'up',
                        duration : 500
                    });

                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/approvers_request.php?sec=data",
                        data: "empid=" + empid + "&dbn=" + dbnames,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {
                            $("#appr_data").html(data);

                            $.ajax(
                            {
                                url: "<?php echo WEB; ?>/lib/requests/approvers_request.php?sec=chkdata",
                                data: "empid=" + empid,
                                type: "POST",
                                complete: function(){
                                    $("#loading").hide();
                                },
                                success: function(data) {
                                    if (data != 0) {
                                        $("#appcount").val(data);
                                    }
                                    else {
                                        $("#appcount").val(7);
                                    }
                                    $("#appempid").val(empid);
                                    $("#appdbname").val(dbnames);
                                    $("#txtdbname").html(dbnames);
                                    $(".btnapprovers").removeClass('invisible');
                                }
                            })
                        }
                    })

                });
            </script>

            <?php

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = REQ_NUM_ROWS * ($page - 1);

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

            if (strlen($searchappr) >= 5) :
                $approver_data = $mainsql->get_employee($start, REQ_NUM_ROWS, $searchappr, 0);
                $approver_count = $mainsql->get_employee(0, 0, $searchappr, 1);
                $pages = $mainsql->pagination("approvers", $approver_count, REQ_NUM_ROWS, 9);
            else :
                $approver_data = NULL;
                $approver_count = NULL;
                $pages = NULL;
            endif;
            ?>

            <table border="0" cellspacing="0" class="tdata width100per">
                <?php if ($approver_data) : ?>
                <tr>
                    <th width="20%"><?php echo ucfirst($profile_nadd); ?>ID</th>
                    <th width="40%">Last Name</th>
                    <th width="40%">First Name</th>
                    <!--th width="20%">Company</th-->
                </tr>
                <?php foreach ($approver_data as $key => $value) : ?>
                <tr class="btnapprdata cursorpoint trdata centertalign whitetext" attribute="<?php echo $value['EmpID']; ?>" attribute2="<?php echo $profile_dbname; ?>">
                    <td><?php echo $value['EmpID']; ?></td>
                    <td><?php echo str_replace('ï¿½', '&Ntilde', utf8_encode($value['LName'])); ?></td>
                    <td><?php echo $value['FName']; ?></td>
                    <!--td><?php echo $profile_dbname; ?></td-->
                </tr>
                <?php endforeach; ?>
                <?php if ($pages) : ?>
                <tr>
                    <td colspan="4" class="centertalign"><?php echo $pages; ?></td>
                </tr>
                <?php endif; ?>
                <?php else : ?>
                    <?php if (strlen($searchappr) < 5) : ?>
                    <tr>
                        <td class="bold centertalign noborder"><br><br>Search must be minimum of 5 characters <i>* <?php echo $profile_nadd; ?> ID must full (2015-01-XXXX)</i></td>
                    </tr>
                    <?php else : ?>
                    <tr>
                        <td class="bold centertalign noborder"><br><br>You have no employees listed</td>
                    </tr>
                    <?php endif; ?>
                <?php endif; ?>
            </table>
            <input type="hidden" id="apprpage" name="apprpage" value="<?php echo $page; ?>" />

            <?php
        break;
        case 'approve':

            $doctype = $_POST['doctype'];
            $apppost['REQNBR'] = $_POST['reqnbr'];
            $apppost['TRANS'] = $_POST['trans'];
            $apppost['USER'] = $_POST['user'];
            $apppost['EMPID'] = $_POST['empid'];
            $apppost['REMARKS'] = $_POST['remarks'];

            if ($doctype == 'OT') :
                $apppost['APPROVEDHRS'] = $_POST['approvehours'];
                $app_request = $mainsql->ot_action($apppost, 'approve');
            elseif ($doctype == 'LV') :
                $app_request = $mainsql->leave_action($apppost, 'approve');
            elseif ($doctype == 'OB') :
                $app_request = $mainsql->ob_action($apppost, 'approve');
            elseif ($doctype == 'NP') :
                $app_request = $mainsql->np_action($apppost, 'approve');
            elseif ($doctype == 'MD') :
                $app_request = $mainsql->md_action($apppost, 'approve');
            elseif ($doctype == 'SC') :
                $app_request = $mainsql->sc_action($apppost, 'approve');
            endif;

            //AUDIT TRAIL
            $post['EMPID'] = $profile_idnum;
            $post['TASKS'] = "APPROVED_".$doctype;
            $post['DATA'] = $_POST['reqnbr'];
            $post['DATE'] = date("m/d/Y H:i:s.000");

            $log = $mainsql->log_action($post, 'add');

            //var_dump($app_request);
            echo $app_request;

        break;
        case 'data':

            $empid = $_POST['empid'];
            $dbn = $_POST['dbn'];

            //var_dump($dbn);

            $emp_data = $tblsql->get_employee(0, 0, $empid, 0, $dbn);
            $emp_all = $tblsql->get_employee();
            ?>

            <script type="text/javascript">
                $(function() {
                    $(".combobox").on("click", function() {
                        tbid = $(this).attr('id');
                        tbdb = $(this).attr('attribute');
                        empid = $(this).val();

                        $("#asearch").removeClass("invisible");
                        $("#apsrsearch").val(empid);
                        $("#apsrtbid").val(tbid);
                        $("#apsrtbdb").val(tbdb);
                        $(".combobox").attr("disable", true);

                        $("#apsr_data").html('');
                        if (empid) {
                            $("#btnapsrdel").removeClass("invisible");
                            $("#apsr_data").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');
                            $.ajax(
                            {
                                url: "<?php echo WEB; ?>/lib/requests/approvers_request.php?sec=searchapsr",
                                data: "apsrsearch=" + empid,
                                type: "POST",
                                complete: function(){
                                    $("#loading").hide();
                                },
                                success: function(data) {
                                    $("#apsr_data").html(data);
                                }
                            })
                        }
                        else {
                            $("#btnapsrdel").addClass("invisible");
                        }

                        $("#apsrsearch").on("keypress", function(e) {
                            if (e.keyCode == 13) {

                                empid = $("#apsrsearch").val();

                                $("#apsr_data").html('<i class="fa fa-refresh fa-spin fa-lg"></i> Loading...');
                                $.ajax(
                                {
                                    url: "<?php echo WEB; ?>/lib/requests/approvers_request.php?sec=searchapsr",
                                    data: "apsrsearch=" + empid,
                                    type: "POST",
                                    complete: function(){
                                        $("#loading").hide();
                                    },
                                    success: function(data) {
                                        $("#apsr_data").html(data);
                                    }
                                })
                            }
                        });

                        $(".closebutton2").on("click", function() {
                            $(".fsearch").addClass("invisible");
                        });

                        $(".closebutton3").on("click", function() {
                            $(".fsearch").addClass("invisible");
                            $(".combobox").attr("disable", false);
                        });
                    });
                });
            </script>



            <table class="tdataform2 rightmargin margintop10 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">

            <?php


                //$appr_data = $mainsql->get_approvers(0, 0, $empid, 0);

                ?>
                    <tr>
                        <td width="15%"><b>Name</b></td>
                        <td width="85%"><?php echo $emp_data[0]['FName']; ?> <?php echo $emp_data[0]['LName']; ?> (<span id = "txtdbname"></span>)</td>
                    </tr>
                    <tr>
                        <td><b>E-mail Address</b></td>
                        <td><a href="mailto:<?php echo $emp_data[0]['EmailAdd']; ?>"><?php echo $emp_data[0]['EmailAdd']; ?></a></td>
                    </tr>
                    <!--tr>
                        <td><b>Position</b></td>
                        <td><?php echo $emp_data[0]['PositionDesc'] ? $emp_data[0]['PositionDesc'] : '-- NOT SET --'; ?></td>
                    </tr>
                    <tr>
                        <td><b>Department</b></td>
                        <td><?php echo $emp_data[0]['DeptDesc'] ? $emp_data[0]['DeptDesc'] : '-- NOT SET --'; ?></td>
                    </tr-->
                    <tr>
                        <td colspan="2" class="centertalign">
                            <?php $app_array = $mainsql->get_approvers($empid, 0, $dbn); ?>
                            <?php $alt_array = $mainsql->get_altapprovers($empid, 0, $dbn); ?>
                            <?php //var_dump($alt_array); ?>
                            <?php
                                $napp_array = array(
                                    0 => array("TYPE" => "frmApplicationLVWeb"),
                                    1 => array("TYPE" => "frmApplicationMDWeb"),
                                    2 => array("TYPE" => "frmApplicationNPWeb"),
                                    3 => array("TYPE" => "frmApplicationOBWeb"),
                                    4 => array("TYPE" => "frmApplicationOTWeb"),
																		5 => array("TYPE" => "frmApplicationSCWeb"),
                                    6 => array("TYPE" => "frmApplicationWHWeb")
                                );
                            ?>


                            <table class="tdatablk" width="100%">
                                <tr>
                                    <th width="22%">Applications</th>
                                    <th width="13%">Approver 1</th>
                                    <th width="13%">Approver 2</th>
                                    <th width="13%">Approver 3</th>
                                    <th width="13%">Approver 4</th>
                                    <th width="13%">Approver 5</th>
                                    <th width="13%">Approver 6</th>
                                </tr>
                                <?php foreach ($napp_array as $key => $value) : ?>
                                <?php
                                    if ($value['TYPE'] == "frmApplicationLVWeb") :
                                        $app_name = "Leave"; $app_var = "leave";
                                    elseif ($value['TYPE'] == "frmApplicationOTWeb") :
                                        $app_name = "Overtime"; $app_var = "ot";
                                    elseif ($value['TYPE'] == "frmApplicationOBWeb") :
                                        $app_name = "OBT"; $app_var = "obt";
                                    elseif ($value['TYPE'] == "frmApplicationMDWeb") :
                                        $app_name = "Manual DTR"; $app_var = "md";
                                    elseif ($value['TYPE'] == "frmApplicationNPWeb") :
                                        $app_name = "Non-Punching Authorization"; $app_var = "npa";
                                    elseif ($value['TYPE'] == "frmApplicationSCWeb") :
                                        $app_name = "Change Schedule"; $app_var = "sc";
									elseif ($value['TYPE'] == "frmApplicationWHWeb") :
                                        $app_name = "Work From Home"; $app_var = "wh";
                                    elseif ($value['TYPE'] == "frmApplicationWHCWeb") :
                                        $app_name = "WFH Clearance"; $app_var = "whc";
                                    endif;

                                    $appkey = array_search($value['TYPE'], array_column($app_array, 'TYPE'));
                                    $appkey = is_int($appkey) ? $appkey : 1000;
                                    //$altkey = array_search($value['TYPE'], array_column($alt_array, 'DocType'));
                                    //$altkey = is_int($altkey) ? $altkey : 1000;
                                    //var_dump($altkey);

                                    $alt01 = $mainsql->get_altapprovers2($empid, $value['TYPE'], 1, $dbn);
                                    $alt02 = $mainsql->get_altapprovers2($empid, $value['TYPE'], 2, $dbn);
                                    $alt03 = $mainsql->get_altapprovers2($empid, $value['TYPE'], 3, $dbn);
                                    $alt04 = $mainsql->get_altapprovers2($empid, $value['TYPE'], 4, $dbn);
                                    $alt05 = $mainsql->get_altapprovers2($empid, $value['TYPE'], 5, $dbn);
                                    $alt06 = $mainsql->get_altapprovers2($empid, $value['TYPE'], 6, $dbn);
                                ?>

                                <tr>
                                    <td><?php echo $app_name; ?><input id="apptype<?php echo $key; ?>" type="hidden" name="apptype<?php echo $key; ?>" value="<?php echo $value['TYPE']; ?>" /></td>
                                    <td>
                                        <input id="app1t<?php echo $key; ?>" attribute="dbapp1t<?php echo $key; ?>" value="<?php echo $app_array[$appkey]['SIGNATORYID1'] ? $app_array[$appkey]['SIGNATORYID1'] : ''; ?>" class="combobox width100per" readonly>
                                        <input type="hidden" id="dbapp1t<?php echo $key; ?>" value="<?php echo $app_array[$appkey]['SIGNATORYDB1'] ? $app_array[$appkey]['SIGNATORYDB1'] : ''; ?>">
                                        <input id="alt1t<?php echo $key; ?>" value="<?php echo $alt01[0]['UserID'] ? $alt01[0]['UserID'] : ''; ?>" class="combobox width100per" readonly>
                                    </td>
                                    <td>
                                        <input id="app2t<?php echo $key; ?>" attribute="dbapp2t<?php echo $key; ?>" value="<?php echo $app_array[$appkey]['SIGNATORYID2'] ? $app_array[$appkey]['SIGNATORYID2'] : ''; ?>" class="combobox width100per" readonly>
                                        <input type="hidden" id="dbapp2t<?php echo $key; ?>" value="<?php echo $app_array[$appkey]['SIGNATORYDB2'] ? $app_array[$appkey]['SIGNATORYDB2'] : ''; ?>">
                                        <input id="alt2t<?php echo $key; ?>" value="<?php echo $alt02[0]['UserID'] ? $alt02[0]['UserID'] : ''; ?>" class="combobox width100per" readonly>
                                    </td>
                                    <td>
                                        <input id="app3t<?php echo $key; ?>" attribute="dbapp3t<?php echo $key; ?>" value="<?php echo $app_array[$appkey]['SIGNATORYID3'] ? $app_array[$appkey]['SIGNATORYID3'] : ''; ?>" class="combobox width100per" readonly>
                                        <input type="hidden" id="dbapp3t<?php echo $key; ?>" value="<?php echo $app_array[$appkey]['SIGNATORYDB3'] ? $app_array[$appkey]['SIGNATORYDB3'] : ''; ?>">
                                        <input id="alt3t<?php echo $key; ?>" value="<?php echo $alt03[0]['UserID'] ? $alt03[0]['UserID'] : ''; ?>" class="combobox width100per" readonly>
                                    </td>
                                    <td>
                                        <input id="app4t<?php echo $key; ?>" attribute="dbapp4t<?php echo $key; ?>" value="<?php echo $app_array[$appkey]['SIGNATORYID4'] ? $app_array[$appkey]['SIGNATORYID4'] : ''; ?>" class="combobox width100per" readonly>
                                        <input type="hidden" id="dbapp4t<?php echo $key; ?>" value="<?php echo $app_array[$appkey]['SIGNATORYDB4'] ? $app_array[$appkey]['SIGNATORYDB4'] : ''; ?>">
                                        <input id="alt4t<?php echo $key; ?>" value="<?php echo $alt04[0]['UserID'] ? $alt04[0]['UserID'] : ''; ?>" class="combobox width100per" readonly>
                                    </td>
                                    <td>
                                        <input id="app5t<?php echo $key; ?>" attribute="dbapp5t<?php echo $key; ?>" value="<?php echo $app_array[$appkey]['SIGNATORYID5'] ? $app_array[$appkey]['SIGNATORYID5'] : ''; ?>" class="combobox width100per" readonly>
                                        <input type="hidden" id="dbapp5t<?php echo $key; ?>" value="<?php echo $app_array[$appkey]['SIGNATORYDB5'] ? $app_array[$appkey]['SIGNATORYDB5'] : ''; ?>">
                                        <input id="alt5t<?php echo $key; ?>" value="<?php echo $alt05[0]['UserID'] ? $alt05[0]['UserID'] : ''; ?>" class="combobox width100per" readonly>
                                    </td>
                                    <td>
                                        <input id="app6t<?php echo $key; ?>" attribute="dbapp6t<?php echo $key; ?>" value="<?php echo $app_array[$appkey]['SIGNATORYID6'] ? $app_array[$appkey]['SIGNATORYID6'] : ''; ?>" class="combobox width100per" readonly>
                                        <input type="hidden" id="dbapp6t<?php echo $key; ?>" value="<?php echo $app_array[$appkey]['SIGNATORYDB6'] ? $app_array[$appkey]['SIGNATORYDB6'] : ''; ?>">
                                        <input id="alt6t<?php echo $key; ?>" value="<?php echo $alt06[0]['UserID'] ? $alt06[0]['UserID'] : ''; ?>" class="combobox width100per" readonly>
                                    </td>
                                </tr>

                                <?php endforeach; ?>
                            </table>
                        </td>
                    </tr>


                </table>

            <?php

            //var_dump($approver_data1);

        break;
        case 'chkdata':
            $empid = $_POST['empid'];
            //$app_array = $mainsql->get_approvers($empid, 1);

            echo 7;

        break;
        case 'searchapsr':
            $apsrsearch = $_POST['apsrsearch'];
            $emp_data = $tblsql->get_appemployee(0, 0, $apsrsearch, 0);
            ?>

            <script type="text/javascript">
                $(function() {
                    $(".btnapsrdata").on("click", function() {
                        empid = $(this).attr('attribute');
                        dbname = $(this).attr('attribute2');
                        tbid = $("#apsrtbid").val();
                        tbdb = $("#apsrtbdb").val();

                        $("#asearch").addClass("invisible");
                        $("#apsrsearch").val('');
                        $("#apsrtbid").val('');
                        $(".combobox").attr("disable", false);

                        $("#" + tbid).val(empid);
                        $("#" + tbdb).val(dbname);
                    });


                    $(".btnapsrdel").on("click", function() {
                        empid = $(this).attr('attribute');
                        dbname = $(this).attr('attribute2');
                        tbid = $("#apsrtbid").val();
                        tbdb = $("#apsrtbdb").val();

                        $("#asearch").addClass("invisible");
                        $("#apsrsearch").val('');
                        $("#apsrtbid").val('');
                        $(".combobox").attr("disable", false);

                        $("#" + tbid).val('');
                        $("#" + tbdb).val('');
                    });
                });
            </script>

            <table border="0" cellspacing="0" class="tdata width100per">
                <?php if ($emp_data) : ?>
                <tr>
                    <th width="20%"><?php echo ucfirst($profile_nadd); ?>ID</th>
                    <th width="30%">Last Name</th>
                    <th width="30%">First Name</th>
                    <th width="20%">Company</th>
                </tr>
                <?php foreach ($emp_data as $key => $value) : ?>
                <tr class="btnapsrdata cursorpoint trdata centertalign" attribute="<?php echo $value['EmpID']; ?>" attribute2="<?php echo $value['DBNAME']; ?>">
                    <td class="dgraytext"><?php echo $value['EmpID']; ?></td>
                    <td class="dgraytext"><?php echo utf8_encode($value['LName']); ?></td>
                    <td class="dgraytext"><?php echo $value['FName']; ?></td>
                    <td class="dgraytext"><?php echo $value['DBNAME']; ?></td>
                </tr>
                <?php endforeach; ?>
                <?php else : ?>
                <tr>
                    <td class="bold centertalign noborder dgraytext"><br><br>You have no <?php echo $profile_nadd; ?> found</td>
                </tr>
                <?php endif; ?>
            </table>
            <?php

        break;
        case 'updateapprover':

            $apprpost['EMPID'] = $_POST['empid'];
            $apprpost['TYPE'] = $_POST['type'];
            $apprpost['SIGNATORYID01'] = $_POST['s1'] ? $_POST['s1'] : 0;
            $apprpost['SIGNATORYID02'] = $_POST['s2'] ? $_POST['s2'] : 0;
            $apprpost['SIGNATORYID03'] = $_POST['s3'] ? $_POST['s3'] : 0;
            $apprpost['SIGNATORYID04'] = $_POST['s4'] ? $_POST['s4'] : 0;
            $apprpost['SIGNATORYID05'] = $_POST['s5'] ? $_POST['s5'] : 0;
            $apprpost['SIGNATORYID06'] = $_POST['s6'] ? $_POST['s6'] : 0;
            $apprpost['SIGNATORYDB01'] = $_POST['d1'] ? $_POST['d1'] : 0;
            $apprpost['SIGNATORYDB02'] = $_POST['d2'] ? $_POST['d2'] : 0;
            $apprpost['SIGNATORYDB03'] = $_POST['d3'] ? $_POST['d3'] : 0;
            $apprpost['SIGNATORYDB04'] = $_POST['d4'] ? $_POST['d4'] : 0;
            $apprpost['SIGNATORYDB05'] = $_POST['d5'] ? $_POST['d5'] : 0;
            $apprpost['SIGNATORYDB06'] = $_POST['d6'] ? $_POST['d6'] : 0;
            $apprpost['ALTID01'] = $_POST['a1'] ? $_POST['a1'] : 0;
            $apprpost['ALTID02'] = $_POST['a2'] ? $_POST['a2'] : 0;
            $apprpost['ALTID03'] = $_POST['a3'] ? $_POST['a3'] : 0;
            $apprpost['ALTID04'] = $_POST['a4'] ? $_POST['a4'] : 0;
            $apprpost['ALTID05'] = $_POST['a5'] ? $_POST['a5'] : 0;
            $apprpost['ALTID06'] = $_POST['a6'] ? $_POST['a6'] : 0;
            $apprpost['ALTIDDB01'] = 0;
            $apprpost['ALTIDDB02'] = 0;
            $apprpost['ALTIDDB03'] = 0;
            $apprpost['ALTIDDB04'] = 0;
            $apprpost['ALTIDDB05'] = 0;
            $apprpost['ALTIDDB06'] = 0;
            $apprpost['DBNAME'] = $_POST['dbname'];

            //var_dump($apprpost['DBNAME']);
            $appr_request = $mainsql->approver_action($apprpost, 'update');

            if ($appr_request) :
                //AUDIT TRAIL
                $post['EMPID'] = $profile_idnum;
                $post['TASKS'] = "UPDATE_APPROVER";
                $post['DATA'] = $_POST['empid'];
                $post['DATE'] = date("m/d/Y H:i:s.000");

                $log = $mainsql->log_action($post, 'add');
            endif;

            //var_dump($appr_request);
            echo $appr_request;

        break;
        default:
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";

    }

?>
