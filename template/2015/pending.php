	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->

                    <div id="floatdiv" class="floatdiv invisible">
                        <!-- VIEW PENDING - BEGIN -->
                        <div id="nview" class="rview" style="display: none;">
                            <div class="rclose cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                            <div id="pend_title" class="pend_title robotobold cattext dbluetext"></div>
                            <div id="pend_data">

                            </div>
                        </div>
                        <!-- VIEW PENDING - END -->
                    </div>

                    <div id="mainsplashtext" class="mainsplashtext lefttalign">
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainpending" class="mainbody lefttalign whitetext">
                                <b class="mediumtext lorangetext">PENDING REQUESTS</b><br><br>

                                <table class="width100per">
                                    <tr>
                                        <td><span class="fa fa-search"></span> Search:
                                            <select id="pendtype" name="pendtype" class="smltxtbox width95">
                                                <option value=""<?php echo !$_SESSION['pendtype'] ? ' selected' : ''; ?>>All</option>
                                                <option value="LV"<?php echo $_SESSION['pendtype'] == 'LV' ? ' selected' : ''; ?>>Leave</option>
                                                <option value="OT"<?php echo $_SESSION['pendtype'] == 'OT' ? ' selected' : ''; ?>>Overtime</option>
                                                <option value="OB"<?php echo $_SESSION['pendtype'] == 'OB' ? ' selected' : ''; ?>>Official Business Trip</option>
                                                <option value="NP"<?php echo $_SESSION['pendtype'] == 'NP' ? ' selected' : ''; ?>>Non-Punching Authorization</option>
                                                <option value="MD"<?php echo $_SESSION['pendtype'] == 'MD' ? ' selected' : ''; ?>>Manual DTR</option>
												<option value="SC"<?php echo $_SESSION['pendtype'] == 'SC' ? ' selected' : ''; ?>>Time Scheduler</option>
												<?php
												$empids_wfh = array("2014-07-N923", "2004-04-8966","2016-06-0457","2000-06-8166","2018-11-0605","2016-06-0144","2010-12-V034","2020-03-0079","1999-09-8123","2019-02-0033","2007-06-M314","2015-03-0093","2019-01-0028","2019-02-0070","2018-08-0453","2016-06-0464","2019-07-0386","2017-04-0933","2018-07-0406","2019-07-0457","2009-07-V177","2011-08-U036",
																						"1993-07-8463","2008-04-M764","2011-07-V980","2006-06-M168","2001-12-8773","1998-08-8602","2001-07-M219","2013-06-N202","2012-05-U417","2008-02-M719","2005-09-M103","2006-06-M163","1997-06-8727","2012-04-U354","1991-10-8274","2007-05-M477","1991-08-8310","1987-07-8128","1996-01-8509","1997-03-8638","2008-06-M829","2013-02-U861","2002-09-8855","1997-05-8715","2012-01-U197",
																						"2001-10-8752","2009-07-V176","2013-03-U940","2016-04-0140","2016-06-0145","2017-11-0016","2019-01-0000","2019-02-0002","2019-09-0133","1990-03-8284");
												if(in_array($profile_idnum, $empids_wfh)){ ?>
													<option value="WH"<?php echo $_SESSION['pendtype'] == 'WH' ? ' selected' : ''; ?>>Work from Home</option>
												<?php } ?>
										    </select>
                                            <input type="text" id="pendfrom" name="pendfrom" value="<?php echo $_SESSION['pendfrom'] ? $_SESSION['pendfrom'] : '2014-08-01'; ?>" placeholder="From.." class="smltxtbox width55 datepick2" /> -
                                            <input type="text" id="pendto" name="pendto" value="<?php echo $_SESSION['pendto'] ? $_SESSION['pendto'] : date("Y-m-d"); ?>" placeholder="To..." class="smltxtbox width55 datepick2" /> by
                                            <input type="text" id="searchpend" name="searchpend" value="<?php echo $_SESSION['searchpend'] ? $_SESSION['searchpend'] : ''; ?>" placeholder="reference no.<?php echo $profile_level ? " or ".$profile_nadd." ID" : ""; ?>" class="smltxtbox width200" />&nbsp;
                                            <input type="button" id="btnpend" name="btnpend" value="Search" class="smlbtn" />
                                            <input type="button" id="btnpendall" name="btnpendall" value="View All" class="smlbtn<?php if (!$_SESSION['searchpend'] && !$_SESSION['pendfrom'] && !$_SESSION['pendto']) : ?> invisible<?php endif; ?>" />
                                            <input type="button" id="btnapprchk" name="btnapprchk" value="Approve Checked" class="smlbtn invisible" />
                                        </td>
                                        <td class="righttalign">
                                            <?php if ($profile_level >= 9) : ?>
                                            <a href="<?php echo WEB; ?>/unread"><input type="button" value="Unread" class="smlbtn btnred" /></a>
                                            <?php endif; ?>
                                            <!--input type="button" id="btnread" name="btnread" value="Mark as Read" class="smlbtn btnred" />
                                            <input type="button" id="btnunread" name="btnunread" value="Mark as Unread" class="smlbtn btnred" /-->
                                        </td>
                                    </tr>
                                </table>

                                <div id="penddata">
                                <table border="0" cellspacing="0" class="tdata width100per">
                                    <?php if ($pending_data) : ?>
                                    <tr>
                                        <th width="4%"><input id="chkappall" type="checkbox" name="chkappall" value="1" class="chkappall" /></th>
                                        <th width="5%">Type</th>
                                        <th width="20%">Reference #</th>
                                        <th width="7%">Level</th>
                                        <th width="18%">Date Filed</th>
                                        <th width="26%">Status</th>
                                        <th width="20%">Last Updated</th>
                                    </tr>
                                    <?php foreach ($pending_data as $key => $value) :

                                        //READ STATUS
                                        $get_read = $mainsql->get_read($profile_idnum, $value['Reference'], 1);

                                        if ($value['DocType'] == 'LV') :
                                            $typestat = "LEAVE APPLICATION from ";
                                        elseif ($value['DocType'] == 'OT') :
                                            $typestat = "OVERTIME APPLICATION from ";
                                            $ot_data = $mainsql->get_overtimedata($value['Reference'], $value['DBNAME']);
                                        elseif ($value['DocType'] == 'OB') :
                                            $typestat = "OBT APPLICATION from ";
                                        elseif ($value['DocType'] == 'NP') :
                                            $typestat = "NO PUNCH APPLICATION from ";
                                        elseif ($value['DocType'] == 'MD') :
                                            $typestat = "MANUAL DTR APPLICATION from ";
                                        elseif ($value['DocType'] == 'SC') :
                                            $typestat = "CHANGE SCHEDULE APPLICATION from ";
                                        elseif ($value['DocType'] == 'TS') :
                                            $typestat = "SCHEDULE CHANGE APPLICATION from ";
										elseif ($value['DocType'] == 'WH') :
                                            $typestat = "WORK FROM HOME APPLICATION from ";
                                        endif;

                                        //var_dump($value['Signatory06']);

                                        $displaychk = 0;

                                        if (trim($value['Signatory01'])) :

                                            if ($value['Signatory01'] == $profile_idnum) :

                                                $requestor_data = $logsql->get_allmember($value['EmpID'], $value['DBNAME']);
                                                if ($value['Approved'] == 1) :
                                                    if ($value['ApprovedDate01']) :
                                                        $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate01']));
                                                        if (trim($value['Signatory02']) == '') :
                                                            $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                                            $nlevel = 1;
                                                        else:
                                                            $nlevel = 2;
                                                        endif;
                                                    else :
                                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";
                                                        $nlevel = 1;
                                                    endif;
                                                elseif ($value['Approved'] == 2) :
                                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";
                                                    $nlevel = 1;
                                                elseif ($value['Approved'] == 3) :
                                                    $astatus = "CANCELLED by ".$requestor_data[0]['FName']." ".$requestor_data[0]['LName'];
                                                    $nlevel = 1;
                                                else :
                                                    $nlevel = 1;
                                                    $astatus = "<span class='lorangetext'>".$typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." for your APPROVAL</span>";
                                                    $displaychk = 1;
                                                    $signatory = $value['Signatory01'];
                                                endif;
                                            else :
                                                $approver_data = $logsql->get_allmember($value['Signatory01'], $value['SignatoryDB01']);
                                                if ($approver_data) :
                                                    if ($value['Approved'] == 1) :
                                                        if ($value['ApprovedDate01']) :
                                                            $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate01']));
                                                            if (trim($value['Signatory02']) == '') :
                                                                $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
                                                                $nlevel = 1;
                                                            else:
                                                                $nlevel = 2;
                                                            endif;
                                                        else :
                                                            $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                            $nlevel = 1;
                                                        endif;
                                                    elseif ($value['Approved'] == 2) :
                                                        $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                        $nlevel = 1;
                                                    elseif ($value['Approved'] == 3) :
                                                        $astatus = "CANCELLED by YOU";
                                                        $nlevel = 1;
                                                    else :
                                                        $nlevel = 1;
                                                        $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                    endif;
                                                else :
                                                    $astatus = "NO NEXT APPROVER WAS ACTIVE";
                                                endif;
                                            endif;
                                        endif;

                                        if (trim($value['Signatory06']) && $value['ApprovedDate05']) :

                                            if ($value['Signatory06'] == $profile_idnum) :

                                                $requestor_data = $logsql->get_allmember($value['EmpID'], $value['DBNAME']);
                                                if ($value['Approved'] == 1) :
                                                    if ($value['ApprovedDate06']) :
                                                        $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate06']));
                                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                                        $nlevel = 6;
                                                    else :
                                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";
                                                        $nlevel = 6;
                                                    endif;
                                                elseif ($value['Approved'] == 2) :
                                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";
                                                    $nlevel = 6;
                                                elseif ($value['Approved'] == 3) :
                                                    $astatus = "CANCELLED by ".$requestor_data[0]['FName']." ".$requestor_data[0]['LName'];
                                                    $nlevel = 6;
                                                else :
                                                    $nlevel = 6;
                                                    $astatus = "<span class='lorangetext'>".$typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." for your APPROVAL</span>";
                                                    $displaychk = 1;
                                                    $signatory = $value['Signatory06'];
                                                endif;

                                            else :

                                                $approver_data = $logsql->get_allmember($value['Signatory06'], $value['SignatoryDB06']);
                                                if ($approver_data) :
                                                    if ($value['Approved'] == 1) :
                                                        if ($value['ApprovedDate06']) :
                                                            $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate06']));
                                                            $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
                                                            $nlevel = 6;
                                                        else :
                                                            $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                            $nlevel = 6;
                                                        endif;
                                                    elseif ($value['Approved'] == 2) :
                                                        $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                        $nlevel = 6;
                                                    elseif ($value['Approved'] == 3) :
                                                        $astatus = "CANCELLED by YOU";
                                                        $nlevel = 6;
                                                    else :
                                                        $nlevel = 6;
                                                        $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                    endif;
                                                else :
                                                    $astatus = "NO NEXT APPROVER WAS ACTIVE";
                                                endif;

                                            endif;

                                        elseif (trim($value['Signatory05']) && $value['ApprovedDate04']) :

                                            if ($value['Signatory05'] == $profile_idnum) :

                                                $requestor_data = $logsql->get_allmember($value['EmpID'], $value['DBNAME']);
                                                if ($value['Approved'] == 1) :
                                                    if ($value['ApprovedDate05']) :
                                                        $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate05']));
                                                        if (trim($value['Signatory06']) == '') :
                                                            $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                                            $nlevel = 5;
                                                        else:
                                                            $nlevel = 6;
                                                        endif;
                                                    else :
                                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";
                                                        $nlevel = 5;
                                                    endif;
                                                elseif ($value['Approved'] == 2) :
                                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";
                                                    $nlevel = 5;
                                                elseif ($value['Approved'] == 3) :
                                                    $astatus = "CANCELLED by ".$requestor_data[0]['FName']." ".$requestor_data[0]['LName'];
                                                    $nlevel = 5;
                                                else :
                                                    $nlevel = 5;
                                                    $astatus = "<span class='lorangetext'>".$typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." for your APPROVAL</span>";
                                                    $displaychk = 1;
                                                    $signatory = $value['Signatory05'];
                                                endif;

                                            else :

                                                $approver_data = $logsql->get_allmember($value['Signatory05'], $value['SignatoryDB05']);
                                                if ($approver_data) :
                                                    if ($value['Approved'] == 1) :
                                                        if ($value['ApprovedDate05']) :
                                                            $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate05']));
                                                            if (trim($value['Signatory06']) == '') :
                                                                $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
                                                                $nlevel = 5;
                                                            else :
                                                                $nlevel = 6;
                                                            endif;
                                                        else :
                                                            $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                            $nlevel = 5;
                                                        endif;
                                                    elseif ($value['Approved'] == 2) :
                                                        $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                        $nlevel = 5;
                                                    elseif ($value['Approved'] == 3) :
                                                        $astatus = "CANCELLED by YOU";
                                                        $nlevel = 5;
                                                    else :
                                                        $nlevel = 5;
                                                        $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                    endif;
                                                else :
                                                    $astatus = "NO NEXT APPROVER WAS ACTIVE";
                                                endif;
                                            endif;

                                        elseif (trim($value['Signatory04']) && $value['ApprovedDate03']) :

                                            if ($value['Signatory04'] == $profile_idnum) :

                                                $requestor_data = $logsql->get_allmember($value['EmpID'], $value['DBNAME']);
                                                if ($value['Approved'] == 1) :
                                                    if ($value['ApprovedDate04']) :
                                                        $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate04']));
                                                        if (trim($value['Signatory05']) == '') :
                                                            $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                                            $nlevel = 4;
                                                        else:
                                                            $nlevel = 5;
                                                        endif;
                                                    else :
                                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";
                                                        $nlevel = 4;
                                                    endif;
                                                elseif ($value['Approved'] == 2) :
                                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";
                                                    $nlevel = 4;
                                                elseif ($value['Approved'] == 3) :
                                                    $astatus = "CANCELLED by ".$requestor_data[0]['FName']." ".$requestor_data[0]['LName'];
                                                    $nlevel = 4;
                                                else :
                                                    $nlevel = 4;
                                                    $astatus = "<span class='lorangetext'>".$typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." for your APPROVAL</span>";
                                                    $displaychk = 1;
                                                    $signatory = $value['Signatory04'];
                                                endif;

                                            else :
                                                $approver_data = $logsql->get_allmember($value['Signatory04'], $value['SignatoryDB04']);
                                                if ($approver_data) :
                                                    if ($value['Approved'] == 1) :
                                                        if ($value['ApprovedDate04']) :
                                                            $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate04']));
                                                            if (trim($value['Signatory05']) == '') :
                                                                $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
                                                                $nlevel = 4;
                                                            else :
                                                                $nlevel = 5;
                                                            endif;
                                                        else :
                                                            $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                            $nlevel = 4;
                                                        endif;
                                                    elseif ($value['Approved'] == 2) :
                                                        $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                        $nlevel = 4;
                                                    elseif ($value['Approved'] == 3) :
                                                        $astatus = "CANCELLED by YOU";
                                                        $nlevel = 4;
                                                    else :
                                                        $nlevel = 4;
                                                        $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                    endif;
                                                else :
                                                    $astatus = "NO NEXT APPROVER WAS ACTIVE";
                                                endif;
                                            endif;

                                        elseif (trim($value['Signatory03']) && $value['ApprovedDate02']) :

                                            if ($value['Signatory03'] == $profile_idnum) :

                                                $requestor_data = $logsql->get_allmember($value['EmpID'], $value['DBNAME']);
                                                if ($value['Approved'] == 1) :
                                                    if ($value['ApprovedDate03']) :
                                                        $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate03']));
                                                        if (trim($value['Signatory04']) == '') :
                                                            $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                                            $nlevel = 3;
                                                        else:
                                                            $nlevel = 4;
                                                        endif;
                                                    else :
                                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";
                                                        $nlevel = 3;
                                                    endif;
                                                elseif ($value['Approved'] == 2) :
                                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";
                                                    $nlevel = 3;
                                                elseif ($value['Approved'] == 3) :
                                                    $astatus = "CANCELLED by ".$requestor_data[0]['FName']." ".$requestor_data[0]['LName'];
                                                    $nlevel = 3;
                                                else :
                                                    $nlevel = 3;
                                                    $astatus = "<span class='lorangetext'>".$typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." for your APPROVAL</span>";
                                                    $displaychk = 1;
                                                    $signatory = $value['Signatory03'];
                                                endif;


                                            else :
                                                $approver_data = $logsql->get_allmember($value['Signatory03'], $value['SignatoryDB03']);
                                                if ($approver_data) :
                                                    if ($value['Approved'] == 1) :
                                                        if ($value['ApprovedDate03']) :
                                                            $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate03']));
                                                            if (trim($value['Signatory04']) == '') :
                                                                $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
                                                                $nlevel = 3;
                                                            else :
                                                                $nlevel = 4;
                                                            endif;
                                                        else :
                                                            $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                            $nlevel = 3;
                                                        endif;
                                                    elseif ($value['Approved'] == 2) :
                                                        $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                        $nlevel = 3;
                                                    elseif ($value['Approved'] == 3) :
                                                        $astatus = "CANCELLED by YOU";
                                                        $nlevel = 3;
                                                    else :
                                                        $nlevel = 3;
                                                        $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                    endif;
                                                else :
                                                    $astatus = "NO NEXT APPROVER WAS ACTIVE";
                                                endif;
                                            endif;

                                        elseif (trim($value['Signatory02']) && $value['ApprovedDate01']) :

                                            if ($value['Signatory02'] == $profile_idnum) :
                                                $requestor_data = $logsql->get_allmember($value['EmpID'], $value['DBNAME']);
                                                if ($value['Approved'] == 1) :
                                                    if ($value['ApprovedDate02']) :
                                                        $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate02']));
                                                        if (trim($value['Signatory03']) == '') :
                                                            $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                                            $nlevel = 2;
                                                        else:
                                                            $nlevel = 3;
                                                        endif;
                                                    else :
                                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";
                                                        $nlevel = 2;
                                                    endif;
                                                elseif ($value['Approved'] == 2) :
                                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";
                                                    $nlevel = 2;
                                                elseif ($value['Approved'] == 3) :
                                                    $astatus = "CANCELLED by ".$requestor_data[0]['FName']." ".$requestor_data[0]['LName'];
                                                    $nlevel = 2;
                                                else :
                                                    $nlevel = 2;
                                                    $astatus = "<span class='lorangetext'>".$typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." for your APPROVAL</span>";
                                                    $displaychk = 1;
                                                    $signatory = $value['Signatory02'];
                                                endif;
                                            else :
                                                $approver_data = $logsql->get_allmember($value['Signatory02'], $value['SignatoryDB02']);
                                                if ($approver_data) :
                                                    if ($value['Approved'] == 1) :
                                                        if ($value['ApprovedDate02']) :
                                                            $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate02']));
                                                            if (trim($value['Signatory03']) == '') :
                                                                $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
                                                                $nlevel = 2;
                                                            else :
                                                                $nlevel = 3;
                                                            endif;
                                                        else :
                                                            $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                            $nlevel = 2;
                                                        endif;
                                                    elseif ($value['Approved'] == 2) :
                                                        $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                        $nlevel = 2;
                                                    elseif ($value['Approved'] == 3) :
                                                        $astatus = "CANCELLED by YOU";
                                                        $nlevel = 2;
                                                    else :
                                                        $nlevel = 2;
                                                        $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                    endif;
                                                else :
                                                    $astatus = "NO NEXT APPROVER WAS ACTIVE";
                                                endif;

                                            endif;

                                        endif;

                                    ?>
                                    <tr class="trdata centertalign<?php echo $get_read ? ' lorangetext' : ' whitetext'; ?>" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>" attribute5="<?php echo $value['DBNAME']; ?>">
                                        <td class="centertalign"><?php if ($displaychk) : ?><input id="chkapp<?php echo $key; ?>" type="checkbox" name="chkapp[<?php echo $key; ?>]" value="<?php echo $value['Reference']; ?>" attribute="<?php echo $value['DocType']; ?>" attribute2="<?php echo $profile_idnum; ?>" attribute3="<?php echo $value['EmpID']; ?>" attribute4="<?php echo $value['DocType'] == 'OT' ? $ot_data[0]['ApprovedHrs'] : 0; ?>" attribute5="<?php echo $value['DBNAME']; ?>" class="chkapp" /><?php endif; ?></td>
                                        <td class="btnpenddata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>" attribute5="<?php echo $value['DBNAME']; ?>"><?php echo $value['DocType']; ?></td>
                                        <td class="btnpenddata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>" attribute5="<?php echo $value['DBNAME']; ?>"><?php echo $value['Reference']; ?></td>
                                        <td class="btnpenddata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>" attribute5="<?php echo $value['DBNAME']; ?>"><?php echo $nlevel; ?></td>
                                        <td class="btnpenddata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>" attribute5="<?php echo $value['DBNAME']; ?>"><?php echo date("M j, Y g:ia", strtotime($value['DateFiled'])); ?></td>
                                        <td class="btnpenddata cursorpoint tinytext" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>" attribute5="<?php echo $value['DBNAME']; ?>"><?php echo $astatus; ?></td>
                                        <td class="btnpenddata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>" attribute5="<?php echo $value['DBNAME']; ?>"><?php echo $date_approved; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if ($pages) : ?>
                                    <tr>
                                        <td colspan="7" class="centertalign"><?php echo $pages; ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php else : ?>
                                    <tr>
                                        <td class="bold centertalign noborder"><br><br>You have no pending notification</td>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                                <input type="hidden" id="pendpage" name="pendpage" value="<?php echo $page; ?>" />
                                </div>
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>
