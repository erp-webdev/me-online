	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->

                    <div id="floatdiv" class="floatdiv invisible">
                        <!-- VIEW NOTIFICATION - BEGIN -->
                        <div id="nview" class="fview" style="display: none;">
                            <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                            <div id="noti_title" class="noti_title robotobold cattext dbluetext"></div>
                            <div id="noti_data">

                            </div>
                        </div>
                        <!-- VIEW NOTIFICATION - END -->
                    </div>

                    <div id="mainsplashtext" class="mainsplashtext lefttalign">
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainnotification" class="mainbody lefttalign whitetext">
                                <b class="mediumtext lorangetext">REQUESTS MANAGEMENT</b><br><br>

                                <table class="width100per">
                                    <tr>
                                        <td><span class="fa fa-search"></span> Search:
                                            <select id="rmantype" name="rmantype" class="smltxtbox width95">
                                                <option value=""<?php echo !$_SESSION['rmantype'] ? ' selected' : ''; ?>>All</option>
                                                <option value="LV"<?php echo $_SESSION['rmantype'] == 'LV' ? ' selected' : ''; ?>>Leave</option>
                                                <option value="OT"<?php echo $_SESSION['rmantype'] == 'OT' ? ' selected' : ''; ?>>Overtime</option>
                                                <option value="OB"<?php echo $_SESSION['rmantype'] == 'OB' ? ' selected' : ''; ?>>Official Business Trip</option>
                                                <option value="NP"<?php echo $_SESSION['rmantype'] == 'NP' ? ' selected' : ''; ?>>Non-Punching Authorization</option>
                                                <option value="MD"<?php echo $_SESSION['rmantype'] == 'MD' ? ' selected' : ''; ?>>Manual DTR</option>
											    <option value="SC"<?php echo $_SESSION['rmantype'] == 'SC' ? ' selected' : ''; ?>>Time Scheduler</option>
                                                <option value="WH"<?php echo $_SESSION['rmantype'] == 'WH' ? ' selected' : ''; ?>>Work From Home</option>
                                                <option value="WC"<?php echo $_SESSION['rmantype'] == 'WC' ? ' selected' : ''; ?>>WFH Clearance</option>
                                            </select>
                                            <input type="text" id="rmanfrom" name="rmanfrom" value="<?php echo $_SESSION['rmanfrom'] ? $_SESSION['rmanfrom'] : date('Y-m-d', strtotime("-6 months")); ?>" placeholder="From.." class="smltxtbox width55 datepick2" /> -
                                            <input type="text" id="rmanto" name="rmanto" value="<?php echo $_SESSION['rmanto'] ? $_SESSION['rmanto'] : date("Y-m-d"); ?>" placeholder="To..." class="smltxtbox width55 datepick2" /> by
                                            <input type="text" id="searchrman" name="searchrman" value="<?php echo $_SESSION['searchrman'] ? $_SESSION['searchrman'] : ''; ?>" placeholder="reference no. or EmpID or Name" class="smltxtbox width200" />&nbsp;
                                            <input type="button" id="btnrman" name="btnrman" value="Search" class="smlbtn" />

                                        </td>
                                        <td class="righttalign">
                                            <!--input type="button" id="btnread" name="btnread" value="Mark as Read" class="smlbtn btnred" />
                                            <input type="button" id="btnunread" name="btnunread" value="Mark as Unread" class="smlbtn btnred" /-->
                                        </td>
                                    </tr>
                                </table>

                                <div id="rmandata">
                                <table border="0" cellspacing="0" class="tdata width100per">
                                    <?php if ($notification_data) : ?>
                                    <tr>
                                        <th width="7%" rowspan="2">Type</th>
                                        <th width="19%" rowspan="2">Reference #</th>
                                        <th width="19%" rowspan="2">Request by</th>
                                        <th width="5%" rowspan="2">Level</th>
                                        <th width="24%" colspan="2">Date</th>
                                        <th width="26%" rowspan="2">Status</th>
                                    </tr>
                                    <tr>
                                        <th width="12%">Filed</th>
                                        <th width="12%">Approved</th>
                                    </tr>
                                    <?php foreach ($notification_data as $key => $value) :

                                        if ($value['DocType'] == 'LV') : $typestat = "LEAVE APPLICATION from ";
                                        elseif ($value['DocType'] == 'OT') : $typestat = "OVERTIME APPLICATION from ";
                                        elseif ($value['DocType'] == 'OB') : $typestat = "OBT APPLICATION from ";
                                        elseif ($value['DocType'] == 'NP') : $typestat = "NO PUNCH APPLICATION from ";
                                        elseif ($value['DocType'] == 'MD') : $typestat = "MANUAL DTR APPLICATION from ";
                                        elseif ($value['DocType'] == 'SC') : $typestat = "CHANGE SCHEDULE APPLICATION from ";
                                        elseif ($value['DocType'] == 'WH') : $typestat = "WORK FROM HOME APPLICATION from ";
                                        elseif ($value['DocType'] == 'WC') : $typestat = "WFH CLEARANCE APPLICATION from ";
                                        endif;

                                        //var_dump($value['Signatory06']);

                                        $displaychk = 0;

                                        if (trim($value['Signatory01'])) :

                                            if ($value['Signatory01'] == $profile_idnum) :

                                                $requestor_data = $logsql->get_allmember($value['EmpID']);
                                                if ($value['Approved'] == 1) :
                                                    if ($value['ApprovedDate01']) :
                                                        $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate01']));
                                                        if (!trim($value['Signatory02']) || trim($value['Signatory02']) == '') :
                                                            $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                                            $nlevel = 1;
                                                        else:
                                                            $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
                                                            $nlevel = 2;
                                                        endif;
                                                    else :
                                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED";
                                                        $nlevel = 1;
                                                    endif;
                                                elseif ($value['Approved'] == 2) :
                                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED";
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
                                                $approver_data = $logsql->get_allmember($value['Signatory01'], $value['DB_NAME01']);
                                                if ($value['Approved'] == 1) :
                                                    if ($value['ApprovedDate01']) :
                                                        $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate01']));
                                                        if (!trim($value['Signatory02']) || trim($value['Signatory02']) == '') :
                                                            $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
                                                            $nlevel = 1;
                                                        else:
                                                            $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
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
                                                    $astatus = "CANCELLED";
                                                    $nlevel = 1;
                                                else :
                                                    $nlevel = 1;
                                                    $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                endif;
                                            endif;
                                        endif;

                                        if (trim($value['Signatory06']) && $value['ApprovedDate05']) :

                                            if ($value['Signatory06'] == $profile_idnum) :

                                                $requestor_data = $logsql->get_allmember($value['EmpID']);
                                                if ($value['Approved'] == 1) :
                                                    if ($value['ApprovedDate06']) :
                                                        $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate06']));
                                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                                        $nlevel = 6;
                                                    else :
                                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED";
                                                        $nlevel = 6;
                                                    endif;
                                                elseif ($value['Approved'] == 2) :
                                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED";
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

                                                $approver_data = $logsql->get_allmember($value['Signatory06'], $value['DB_NAME06']);
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
                                                    $astatus = "CANCELLED";
                                                    $nlevel = 6;
                                                else :
                                                    $nlevel = 6;
                                                    $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                endif;

                                            endif;

                                        elseif (trim($value['Signatory05']) && $value['ApprovedDate04']) :

                                            if ($value['Signatory05'] == $profile_idnum) :

                                                $requestor_data = $logsql->get_allmember($value['EmpID']);
                                                if ($value['Approved'] == 1) :
                                                    if ($value['ApprovedDate05']) :
                                                        $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate05']));
                                                        if (!trim($value['Signatory06']) || trim($value['Signatory06']) == '') :
                                                            $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                                            $nlevel = 5;
                                                        else:
                                                            $nlevel = 6;
                                                        endif;
                                                    else :
                                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED";
                                                        $nlevel = 5;
                                                    endif;
                                                elseif ($value['Approved'] == 2) :
                                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED";
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

                                                $approver_data = $logsql->get_allmember($value['Signatory05'], $value['DB_NAME05']);
                                                if ($value['Approved'] == 1) :
                                                    if ($value['ApprovedDate05']) :
                                                        $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate05']));
                                                        if (!trim($value['Signatory06']) || trim($value['Signatory06']) == '') :
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
                                                    $astatus = "CANCELLED";
                                                    $nlevel = 5;
                                                else :
                                                    $nlevel = 5;
                                                    $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                endif;
                                            endif;

                                        elseif (trim($value['Signatory04']) && $value['ApprovedDate03']) :

                                            if ($value['Signatory04'] == $profile_idnum) :

                                                $requestor_data = $logsql->get_allmember($value['EmpID']);
                                                if ($value['Approved'] == 1) :
                                                    if ($value['ApprovedDate04']) :
                                                        $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate04']));
                                                        if (!trim($value['Signatory05']) || trim($value['Signatory05']) == '') :
                                                            $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                                            $nlevel = 4;
                                                        else:
                                                            $nlevel = 5;
                                                        endif;
                                                    else :
                                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED";
                                                        $nlevel = 4;
                                                    endif;
                                                elseif ($value['Approved'] == 2) :
                                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED";
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
                                                $approver_data = $logsql->get_allmember($value['Signatory04'], $value['DB_NAME04']);
                                                if ($value['Approved'] == 1) :
                                                    if ($value['ApprovedDate04']) :
                                                        $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate04']));
                                                        if (!trim($value['Signatory05']) || trim($value['Signatory05']) == '') :
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
                                                    $astatus = "CANCELLED";
                                                    $nlevel = 4;
                                                else :
                                                    $nlevel = 4;
                                                    $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                endif;
                                            endif;

                                        elseif (trim($value['Signatory03']) && $value['ApprovedDate02']) :

                                            if ($value['Signatory03'] == $profile_idnum) :

                                                $requestor_data = $logsql->get_allmember($value['EmpID']);
                                                if ($value['Approved'] == 1) :
                                                    if ($value['ApprovedDate03']) :
                                                        $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate03']));
                                                        if (!trim($value['Signatory04']) || trim($value['Signatory04']) == '') :
                                                            $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                                            $nlevel = 3;
                                                        else:
                                                            $nlevel = 4;
                                                        endif;
                                                    else :
                                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED";
                                                        $nlevel = 3;
                                                    endif;
                                                elseif ($value['Approved'] == 2) :
                                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED";
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
                                                $approver_data = $logsql->get_allmember($value['Signatory03'], $value['DB_NAME03']);
                                                if ($value['Approved'] == 1) :
                                                    if ($value['ApprovedDate03']) :
                                                        $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate03']));
                                                        if (!trim($value['Signatory04']) || trim($value['Signatory04']) == '') :
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
                                                    $astatus = "CANCELLED";
                                                    $nlevel = 3;
                                                else :
                                                    $nlevel = 3;
                                                    $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                endif;
                                            endif;

                                        elseif (trim($value['Signatory02']) && $value['ApprovedDate01']) :

                                            if ($value['Signatory02'] == $profile_idnum) :
                                                $requestor_data = $logsql->get_allmember($value['EmpID']);
                                                if ($value['Approved'] == 1) :
                                                    if ($value['ApprovedDate02']) :
                                                        $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate02']));
                                                        if (!trim($value['Signatory03']) || trim($value['Signatory03']) == '') :
                                                            $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                                            $nlevel = 2;
                                                        else:
                                                            $nlevel = 3;
                                                        endif;
                                                    else :
                                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED";
                                                        $nlevel = 2;
                                                    endif;
                                                elseif ($value['Approved'] == 2) :
                                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED";
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
                                                $approver_data = $logsql->get_allmember($value['Signatory02'], $value['DB_NAME02']);
                                                if ($value['Approved'] == 1) :
                                                    if ($value['ApprovedDate02']) :
                                                        $date_approved = date("M j, Y g:ia", strtotime($value['ApprovedDate02']));
                                                        if (!trim($value['Signatory03']) || trim($value['Signatory03']) == '') :
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
                                                    $astatus = "CANCELLED";
                                                    $nlevel = 2;
                                                else :
                                                    $nlevel = 2;
                                                    $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                endif;

                                            endif;

                                        endif;

                                    ?>
                                    <tr class="btnrnotidata cursorpoint trdata centertalign whitetext" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>">
                                        <td><?php echo $value['DocType']; ?></td>
                                        <td><?php echo $value['Reference']; ?></td>
                                        <td><?php echo $value['EmpID']; ?></td>
                                        <td><?php echo $nlevel; ?></td>
                                        <td><?php echo date("M j, Y", strtotime($value['DateFiled'])); ?></td>
                                        <?php $oldyear = date("Y", strtotime($value['APPROVALDATE'])); ?>
                                        <td><?php echo $oldyear >= "2013" ? date("M j, Y", strtotime($value['APPROVALDATE'])) : ''; ?></td>
                                        <td class="tinytext"><?php echo $astatus; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if ($pages) : ?>
                                    <tr>
                                        <td colspan="7" class="centertalign"><?php echo $pages; ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php else : ?>
                                        <?php if (strlen($searchrman) < 5) : ?>
                                        <tr>
                                            <td class="bold centertalign noborder"><br><br>Search must be minimum of 5 characters <i>* <?php echo $profile_nadd; ?> ID must full (2015-01-XXXX)</i></td>
                                        </tr>
                                        <?php else : ?>
                                        <tr>
                                            <td class="bold centertalign noborder"><br><br>No request has been found</td>
                                        </tr>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </table>
                                <input type="hidden" id="rmanpage" name="rmanpage" value="<?php echo $page; ?>" />
                                <input type="hidden" id="rmandb" name="rmandb" value="<?php echo $profile_dbname; ?>" />
                                </div>
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>
