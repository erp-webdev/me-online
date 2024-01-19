	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->

                    <div id="floatdiv" class="floatdiv invisible">                                         
                        <!-- VIEW NOTIFICATION - BEGIN --> 
                        <div id="nview" class="fview invisible">
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
                                <b class="mediumtext lorangetext">NOTIFICATIONS</b><br><br>                                
                                
                                <table class="width100per">
                                    <tr>
                                        <td><span class="fa fa-search"></span> Search: 
                                            <select id="notitype" name="notitype" class="smltxtbox width95">
                                                <option value=""<?php echo !$_SESSION['notitype'] ? ' selected' : ''; ?>>All</option>
                                                <option value="LV"<?php echo $_SESSION['notitype'] == 'LV' ? ' selected' : ''; ?>>Leave</option>
                                                <option value="OT"<?php echo $_SESSION['notitype'] == 'OT' ? ' selected' : ''; ?>>Overtime</option>
                                                <option value="OB"<?php echo $_SESSION['notitype'] == 'OB' ? ' selected' : ''; ?>>Official Business Trip</option>
                                                <option value="NP"<?php echo $_SESSION['notitype'] == 'NP' ? ' selected' : ''; ?>>Non-Punching Authorization</option>
                                                <option value="MD"<?php echo $_SESSION['notitype'] == 'MD' ? ' selected' : ''; ?>>Manual DTR</option>
                                                <option value="SC"<?php echo $_SESSION['notitype'] == 'SC' ? ' selected' : ''; ?>>Time Scheduler</option>
                                                <!--option value="LU"<?php echo $_SESSION['notitype'] == 'LU' ? ' selected' : ''; ?>>Offset</option-->
                                            </select>
                                            <input type="text" id="notifrom" name="notifrom" value="<?php echo $_SESSION['notifrom'] ? $_SESSION['notifrom'] : '2014-08-01'; ?>" placeholder="From.." class="smltxtbox width55 datepick2" /> - 
                                            <input type="text" id="notito" name="notito" value="<?php echo $_SESSION['notito'] ? $_SESSION['notito'] : date("Y-m-d"); ?>" placeholder="To..." class="smltxtbox width55 datepick2" /> by 
                                            <input type="text" id="searchnoti" name="searchnoti" value="<?php echo $_SESSION['searchnoti'] ? $_SESSION['searchnoti'] : ''; ?>" placeholder="reference no.<?php echo $profile_level ? " or <?php echo $profile_nadd; ?> ID" : ""; ?>" class="smltxtbox width160" />&nbsp;
                                            <input type="button" id="btnnoti" name="btnnoti" value="Search" class="smlbtn" />
                                            <input type="button" id="btnnotiall" name="btnnotiall" value="View All" class="smlbtn<?php if (!$_SESSION['searchnoti'] && !$_SESSION['notifrom'] && !$_SESSION['notito']) : ?> invisible<?php endif; ?>" />                                            
                                            <input type="button" id="btnapprchk" name="btnapprchk" value="Approve Checked" class="smlbtn invisible" />
                                        </td>
                                        <td class="righttalign">
                                            <a href="<?php echo WEB; ?>/unread"><input type="button" value="Unread" class="smlbtn btnred" /></a>
                                            <!--input type="button" id="btnunread" name="btnunread" value="Mark as Unread" class="smlbtn btnred" /-->                            
                                        </td>
                                    </tr>
                                </table>
                                
                                <div id="notidata">
                                <table border="0" cellspacing="0" class="tdata width100per">
                                    <?php if ($notification_data) : ?>
                                    <tr>
                                        <th width="4%">&nbsp;</th>
                                        <th width="5%">Type</th>
                                        <th width="20%">Reference #</th>
                                        <th width="7%">Level</th>
                                        <th width="18%">Date Filed</th>
                                        <th width="26%">Status</th>
                                        <th width="20%">Last Updated</th>
                                    </tr>
                                    <?php foreach ($notification_data as $key => $value) : 

                                        //READ STATUS
                                        $get_read = $mainsql->get_read($profile_idnum, $value['Reference'], 1);                    

                                        if ($value['DocType'] == 'LV') : 
                                            $typestat = "LEAVE APPLICATION from ";
                                        elseif ($value['DocType'] == 'OT') : 
                                            $typestat = "OVERTIME APPLICATION from ";
                                            $ot_data = $mainsql->get_nrequest(1, $value['Reference']);
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
                                        elseif ($value['DocType'] == 'LU') : 
                                            $typestat = "OFFSET APPLICATION from ";
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
                                                $approver_data = $logsql->get_allmember($value['Signatory01']);
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
                                                    $astatus = "CANCELLED by YOU";                                                    
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

                                                $approver_data = $logsql->get_allmember($value['Signatory06']);
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

                                                $approver_data = $logsql->get_allmember($value['Signatory05']);
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
                                                    $astatus = "CANCELLED by YOU";                                                    
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
                                                $approver_data = $logsql->get_allmember($value['Signatory04']);
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
                                                    $astatus = "CANCELLED by YOU";                                                    
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
                                                $approver_data = $logsql->get_allmember($value['Signatory03']);
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
                                                    $astatus = "CANCELLED by YOU";                                                    
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
                                                $approver_data = $logsql->get_allmember($value['Signatory02']);
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
                                                    $astatus = "CANCELLED by YOU";                                                    
                                                    $nlevel = 2;
                                                else :
                                                    $nlevel = 2;
                                                    $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                endif;

                                            endif;

                                        endif;

                                    ?>                                    
                                    <tr class="trdata centertalign whitetext" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>">
                                        <td class="centertalign"><?php if ($displaychk) : ?><input id="chkapp<?php echo $key; ?>" type="checkbox" name="chkapp[<?php echo $key; ?>]" value="<?php echo $value['Reference']; ?>" attribute="<?php echo $value['DocType']; ?>" attribute2="<?php echo $profile_idnum; ?>" attribute3="<?php echo $value['EmpID']; ?>" attribute4="<?php echo $value['DocType'] == 'OT' ? $ot_data[0]['ApprovedHrs'] : 0; ?>" class="chkapp" /><?php endif; ?></td>
                                        <td class="btnnotidata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>"><?php echo $value['DocType']; ?></td>
                                        <td class="btnnotidata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>"><?php echo $value['Reference']; ?></td>
                                        <td class="btnnotidata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>"><?php echo $nlevel; ?></td>
                                        <td class="btnnotidata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>"><?php echo date("M j, Y g:ia", strtotime($value['DateFiled'])); ?></td>
                                        <td class="btnnotidata cursorpoint tinytext" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>"><?php echo $astatus; ?></td>
                                        <td class="btnnotidata cursorpoint" attribute="<?php echo $value['Reference']; ?>" attribute2="<?php echo $value['DocType']; ?>"><?php echo $date_approved; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if ($pages) : ?>
                                    <tr>
                                        <td colspan="7" class="centertalign"><?php echo $pages; ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php else : ?>
                                    <tr>
                                        <td class="bold centertalign noborder"><br><br>You have no notification</td>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                                <input type="hidden" id="notipage" name="notipage" value="<?php echo $page; ?>" />  
                                </div>
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>