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
                                <b class="mediumtext lorangetext">UNREAD NOTIFICATIONS</b><br><br>                                
                                
                                <!--table class="width100per">
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td class="righttalign">
                                            <!--input type="button" id="btnread" name="btnread" value="Mark as Read" class="smlbtn btnred" />
                                            <input type="button" id="btnunread" name="btnunread" value="Mark as Unread" class="smlbtn btnred" /-->                            
                                        </td>
                                    </tr>
                                </table-->
                                
                                <div id="notidata">
                                <table border="0" cellspacing="0" class="tdata width100per">
                                    <?php if ($unread_data) : ?>
                                    <tr>
                                        <!--th width="4%"><input id="chkappall" type="checkbox" name="chkappall" value="1" class="chkappall" /></th-->
                                        <th width="5%">Type</th>
                                        <th width="20%">Reference #</th>
                                        <th width="11%">Level</th>
                                        <th width="18%">Date Filed</th>
                                        <th width="26%">Status</th>
                                        <th width="20%">Last Updated</th>
                                    </tr>
                                    <?php foreach ($unread_data as $key => $value) : 
                                        
                                        $notification_data = $mainsql->get_notification($value['ReqNbr']);

                                        if ($notification_data[0]['DocType'] == 'LV') : 
                                            $typestat = "LEAVE APPLICATION from ";
                                        elseif ($notification_data[0]['DocType'] == 'OT') : 
                                            $typestat = "OVERTIME APPLICATION from ";
                                            $ot_data = $mainsql->get_nrequest(1, $notification_data[0]['Reference']);
                                        elseif ($notification_data[0]['DocType'] == 'OB') : 
                                            $typestat = "OBT APPLICATION from ";
                                        elseif ($notification_data[0]['DocType'] == 'NP') : 
                                            $typestat = "NO PUNCH APPLICATION from ";
                                        elseif ($notification_data[0]['DocType'] == 'MD') : 
                                            $typestat = "MANUAL DTR APPLICATION from ";
                                        elseif ($notification_data[0]['DocType'] == 'SC') : 
                                            $typestat = "CHANGE SCHEDULE APPLICATION from ";
                                        elseif ($notification_data[0]['DocType'] == 'TS') : 
                                            $typestat = "SCHEDULE CHANGE APPLICATION from ";
                                        endif;

                                        //var_dump($notification_data[0]['Signatory06']);

                                        $displaychk = 0;
            
                                        if (trim($notification_data[0]['Signatory01'])) : 

                                            if ($notification_data[0]['Signatory01'] == $profile_idnum) :

                                                $requestor_data = $register->get_member($notification_data[0]['EmpID']);
                                                if ($notification_data[0]['Approved'] == 1) :
                                                    if ($notification_data[0]['ApprovedDate01']) :                                  
                                                        $date_approved = date("M j, Y g:ia", strtotime($notification_data[0]['ApprovedDate01']));                                
                                                        if (trim($notification_data[0]['Signatory02']) == '') : 
                                                            $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                                            $nlevel = 1;
                                                        else:
                                                            $nlevel = 2;
                                                        endif;
                                                    else :
                                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";                                                    
                                                        $nlevel = 1;
                                                    endif;
                                                elseif ($notification_data[0]['Approved'] == 2) :
                                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";                                                    
                                                    $nlevel = 1;
                                                elseif ($notification_data[0]['Approved'] == 3) :
                                                    $astatus = "CANCELLED by ".$requestor_data[0]['FName']." ".$requestor_data[0]['LName'];                                                    
                                                    $nlevel = 1;
                                                else :
                                                    $nlevel = 1;
                                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." for your APPROVAL";
                                                    $displaychk = 1;
                                                    $signatory = $notification_data[0]['Signatory01'];
                                                endif;
                                            else :
                                                $approver_data = $register->get_member($notification_data[0]['Signatory01']);
                                                if ($notification_data[0]['Approved'] == 1) :
                                                    if ($notification_data[0]['ApprovedDate01']) : 
                                                        $date_approved = date("M j, Y g:ia", strtotime($notification_data[0]['ApprovedDate01']));
                                                        if (trim($notification_data[0]['Signatory02']) == '') : 
                                                            $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
                                                            $nlevel = 1;
                                                        else:
                                                            $nlevel = 2;
                                                        endif;
                                                    else :
                                                        $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];                                                    
                                                        $nlevel = 1;
                                                    endif;
                                                elseif ($notification_data[0]['Approved'] == 2) :
                                                    $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];                                                    
                                                    $nlevel = 1;
                                                elseif ($notification_data[0]['Approved'] == 3) :
                                                    $astatus = "CANCELLED by YOU";                                                    
                                                    $nlevel = 1;
                                                else :
                                                    $nlevel = 1;
                                                    $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                endif;                                                
                                            endif;
                                        endif;

                                        if (trim($notification_data[0]['Signatory06']) && $notification_data[0]['ApprovedDate05']) : 

                                            if ($notification_data[0]['Signatory06'] == $profile_idnum) :

                                                $requestor_data = $register->get_member($notification_data[0]['EmpID']);
                                                if ($notification_data[0]['Approved'] == 1) :
                                                    if ($notification_data[0]['ApprovedDate06']) :                                  
                                                        $date_approved = date("M j, Y g:ia", strtotime($notification_data[0]['ApprovedDate06']));
                                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                                        $nlevel = 6;
                                                    else :
                                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";                                                    
                                                        $nlevel = 6;
                                                    endif;
                                                elseif ($notification_data[0]['Approved'] == 2) :
                                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";                                                    
                                                    $nlevel = 6;
                                                elseif ($notification_data[0]['Approved'] == 3) :
                                                    $astatus = "CANCELLED by ".$requestor_data[0]['FName']." ".$requestor_data[0]['LName'];                                                    
                                                    $nlevel = 6;
                                                else :
                                                    $nlevel = 6;
                                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." for your APPROVAL";
                                                    $displaychk = 1;
                                                    $signatory = $notification_data[0]['Signatory06'];
                                                endif;

                                            else :

                                                $approver_data = $register->get_member($notification_data[0]['Signatory06']);
                                                if ($notification_data[0]['Approved'] == 1) :
                                                    if ($notification_data[0]['ApprovedDate06']) :                                  
                                                        $date_approved = date("M j, Y g:ia", strtotime($notification_data[0]['ApprovedDate06']));
                                                        $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
                                                        $nlevel = 6;
                                                    else :
                                                        $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];                                                    
                                                        $nlevel = 6;
                                                    endif;
                                                elseif ($notification_data[0]['Approved'] == 2) :
                                                    $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];                                                    
                                                    $nlevel = 6;
                                                elseif ($notification_data[0]['Approved'] == 3) :
                                                    $astatus = "CANCELLED by YOU";                                                    
                                                    $nlevel = 6;
                                                else :
                                                    $nlevel = 6;
                                                    $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                endif;

                                            endif;

                                        elseif (trim($notification_data[0]['Signatory05']) && $notification_data[0]['ApprovedDate04']) : 

                                            if ($notification_data[0]['Signatory05'] == $profile_idnum) :

                                                $requestor_data = $register->get_member($notification_data[0]['EmpID']);
                                                if ($notification_data[0]['Approved'] == 1) :
                                                    if ($notification_data[0]['ApprovedDate05']) :                                  
                                                        $date_approved = date("M j, Y g:ia", strtotime($notification_data[0]['ApprovedDate05']));                            
                                                        if (trim($notification_data[0]['Signatory06']) == '') : 
                                                            $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                                            $nlevel = 5;
                                                        else:
                                                            $nlevel = 6;
                                                        endif;
                                                    else :
                                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";                                                    
                                                        $nlevel = 5;
                                                    endif;
                                                elseif ($notification_data[0]['Approved'] == 2) :
                                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";                                                    
                                                    $nlevel = 5;
                                                elseif ($notification_data[0]['Approved'] == 3) :
                                                    $astatus = "CANCELLED by ".$requestor_data[0]['FName']." ".$requestor_data[0]['LName'];                                                    
                                                    $nlevel = 5;
                                                else :
                                                    $nlevel = 5;
                                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." for your APPROVAL";
                                                    $displaychk = 1;
                                                    $signatory = $notification_data[0]['Signatory05'];
                                                endif;

                                            else :

                                                $approver_data = $register->get_member($notification_data[0]['Signatory05']);
                                                if ($notification_data[0]['Approved'] == 1) :
                                                    if ($notification_data[0]['ApprovedDate05']) : 
                                                        $date_approved = date("M j, Y g:ia", strtotime($notification_data[0]['ApprovedDate05']));
                                                        if (trim($notification_data[0]['Signatory06']) == '') : 
                                                            $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
                                                            $nlevel = 5;
                                                        else :
                                                            $nlevel = 6;
                                                        endif;
                                                    else :
                                                        $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                        $nlevel = 5;
                                                    endif;
                                                elseif ($notification_data[0]['Approved'] == 2) :
                                                    $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                    $nlevel = 5;
                                                elseif ($notification_data[0]['Approved'] == 3) :
                                                    $astatus = "CANCELLED by YOU";                                                    
                                                    $nlevel = 5;
                                                else :
                                                    $nlevel = 5;
                                                    $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                endif;
                                            endif;

                                        elseif (trim($notification_data[0]['Signatory04']) && $notification_data[0]['ApprovedDate03']) : 

                                            if ($notification_data[0]['Signatory04'] == $profile_idnum) :

                                                $requestor_data = $register->get_member($notification_data[0]['EmpID']);
                                                if ($notification_data[0]['Approved'] == 1) :
                                                    if ($notification_data[0]['ApprovedDate04']) :                                  
                                                        $date_approved = date("M j, Y g:ia", strtotime($notification_data[0]['ApprovedDate04']));
                                                        if (trim($notification_data[0]['Signatory05']) == '') : 
                                                            $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                                            $nlevel = 4;
                                                        else:
                                                            $nlevel = 5;
                                                        endif;
                                                    else :
                                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";                                                    
                                                        $nlevel = 4;
                                                    endif;
                                                elseif ($notification_data[0]['Approved'] == 2) :
                                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";                                                    
                                                    $nlevel = 4;
                                                elseif ($notification_data[0]['Approved'] == 3) :
                                                    $astatus = "CANCELLED by ".$requestor_data[0]['FName']." ".$requestor_data[0]['LName'];                                                    
                                                    $nlevel = 4;
                                                else :                            
                                                    $nlevel = 4;
                                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." for your APPROVAL";
                                                    $displaychk = 1;
                                                    $signatory = $notification_data[0]['Signatory04'];
                                                endif;

                                            else :
                                                $approver_data = $register->get_member($notification_data[0]['Signatory04']);
                                                if ($notification_data[0]['Approved'] == 1) :
                                                    if ($notification_data[0]['ApprovedDate04']) : 
                                                        $date_approved = date("M j, Y g:ia", strtotime($notification_data[0]['ApprovedDate04']));
                                                        if (trim($notification_data[0]['Signatory05']) == '') : 
                                                            $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
                                                            $nlevel = 4;
                                                        else :
                                                            $nlevel = 5;
                                                        endif;
                                                    else :
                                                        $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                        $nlevel = 4;
                                                    endif;
                                                elseif ($notification_data[0]['Approved'] == 2) :
                                                    $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                    $nlevel = 4;
                                                elseif ($notification_data[0]['Approved'] == 3) :
                                                    $astatus = "CANCELLED by YOU";                                                    
                                                    $nlevel = 4;
                                                else :
                                                    $nlevel = 4;
                                                    $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                endif;
                                            endif;

                                        elseif (trim($notification_data[0]['Signatory03']) && $notification_data[0]['ApprovedDate02']) : 

                                            if ($notification_data[0]['Signatory03'] == $profile_idnum) :

                                                $requestor_data = $register->get_member($notification_data[0]['EmpID']);
                                                if ($notification_data[0]['Approved'] == 1) :
                                                    if ($notification_data[0]['ApprovedDate03']) :                                  
                                                        $date_approved = date("M j, Y g:ia", strtotime($notification_data[0]['ApprovedDate03']));
                                                        if (trim($notification_data[0]['Signatory04']) == '') : 
                                                            $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                                            $nlevel = 3;
                                                        else:
                                                            $nlevel = 4;
                                                        endif;
                                                    else :
                                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";                                                    
                                                        $nlevel = 3;
                                                    endif;
                                                elseif ($notification_data[0]['Approved'] == 2) :
                                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";                                                    
                                                    $nlevel = 3;
                                                elseif ($notification_data[0]['Approved'] == 3) :
                                                    $astatus = "CANCELLED by ".$requestor_data[0]['FName']." ".$requestor_data[0]['LName'];                                                    
                                                    $nlevel = 3;
                                                else :                            
                                                    $nlevel = 3;
                                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." for your APPROVAL";
                                                    $displaychk = 1;
                                                    $signatory = $notification_data[0]['Signatory03'];
                                                endif;


                                            else :
                                                $approver_data = $register->get_member($notification_data[0]['Signatory03']);
                                                if ($notification_data[0]['Approved'] == 1) :
                                                    if ($notification_data[0]['ApprovedDate03']) : 
                                                        $date_approved = date("M j, Y g:ia", strtotime($notification_data[0]['ApprovedDate03']));
                                                        if (trim($notification_data[0]['Signatory04']) == '') : 
                                                            $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
                                                            $nlevel = 3;
                                                        else :
                                                            $nlevel = 4;
                                                        endif;
                                                    else :
                                                        $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                        $nlevel = 3;
                                                    endif;
                                                elseif ($notification_data[0]['Approved'] == 2) :
                                                    $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                    $nlevel = 3;
                                                elseif ($notification_data[0]['Approved'] == 3) :
                                                    $astatus = "CANCELLED by YOU";                                                    
                                                    $nlevel = 3;
                                                else :
                                                    $nlevel = 3;
                                                    $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                endif;
                                            endif;

                                        elseif (trim($notification_data[0]['Signatory02']) && $notification_data[0]['ApprovedDate01']) : 

                                            if ($notification_data[0]['Signatory02'] == $profile_idnum) :
                                                $requestor_data = $register->get_member($notification_data[0]['EmpID']);                                
                                                if ($notification_data[0]['Approved'] == 1) :
                                                    if ($notification_data[0]['ApprovedDate02']) :                                  
                                                        $date_approved = date("M j, Y g:ia", strtotime($notification_data[0]['ApprovedDate02']));                            
                                                        if (trim($notification_data[0]['Signatory03']) == '') : 
                                                            $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." APPROVED by YOU and that's final.";
                                                            $nlevel = 2;
                                                        else:
                                                            $nlevel = 3;
                                                        endif;
                                                    else :
                                                        $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";                                                    
                                                        $nlevel = 2;                                                    
                                                    endif;
                                                elseif ($notification_data[0]['Approved'] == 2) :
                                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." REJECTED by YOU";                                                    
                                                    $nlevel = 2; 
                                                elseif ($notification_data[0]['Approved'] == 3) :
                                                    $astatus = "CANCELLED by ".$requestor_data[0]['FName']." ".$requestor_data[0]['LName'];                                                    
                                                    $nlevel = 2;
                                                else :
                                                    $nlevel = 2;
                                                    $astatus = $typestat.$requestor_data[0]['FName']." ".$requestor_data[0]['LName']." for your APPROVAL";
                                                    $displaychk = 1;
                                                    $signatory = $notification_data[0]['Signatory02'];
                                                endif;
                                            else :
                                                $approver_data = $register->get_member($notification_data[0]['Signatory02']);
                                                if ($notification_data[0]['Approved'] == 1) :
                                                    if ($notification_data[0]['ApprovedDate02']) : 
                                                        $date_approved = date("M j, Y g:ia", strtotime($notification_data[0]['ApprovedDate02']));
                                                        if (trim($notification_data[0]['Signatory03']) == '') : 
                                                            $astatus = "APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName']." and that's final.";
                                                            $nlevel = 2;
                                                        else :
                                                            $nlevel = 3;
                                                        endif;
                                                    else :
                                                        $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                        $nlevel = 2;
                                                    endif;
                                                elseif ($notification_data[0]['Approved'] == 2) :
                                                    $astatus = "REJECTED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                    $nlevel = 2;
                                                elseif ($notification_data[0]['Approved'] == 3) :
                                                    $astatus = "CANCELLED by YOU";                                                    
                                                    $nlevel = 2;
                                                else :
                                                    $nlevel = 2;
                                                    $astatus = "TO BE APPROVED by ".$approver_data[0]['FName']." ".$approver_data[0]['LName'];
                                                endif;

                                            endif;

                                        endif;

                                    ?>                                    
                                    <tr class="trdata centertalign lorangetext" attribute="<?php echo $notification_data[0]['Reference']; ?>" attribute2="<?php echo $notification_data[0]['DocType']; ?>">
                                        <!--td class="centertalign"><?php if ($displaychk) : ?><input id="chkapp<?php echo $key; ?>" type="checkbox" name="chkapp[<?php echo $key; ?>]" value="<?php echo $notification_data[0]['Reference']; ?>" attribute="<?php echo $notification_data[0]['DocType']; ?>" attribute2="<?php echo $profile_idnum; ?>" attribute3="<?php echo $notification_data[0]['EmpID']; ?>" attribute4="<?php echo $notification_data[0]['DocType'] == 'OT' ? $ot_data[0]['ApprovedHrs'] : 0; ?>" class="chkapp" /><?php endif; ?></td-->
                                        <td class="btnnotidata cursorpoint" attribute="<?php echo $notification_data[0]['Reference']; ?>" attribute2="<?php echo $notification_data[0]['DocType']; ?>"><?php echo $notification_data[0]['DocType']; ?></td>
                                        <td class="btnnotidata cursorpoint" attribute="<?php echo $notification_data[0]['Reference']; ?>" attribute2="<?php echo $notification_data[0]['DocType']; ?>"><?php echo $notification_data[0]['Reference']; ?></td>
                                        <td class="btnnotidata cursorpoint" attribute="<?php echo $notification_data[0]['Reference']; ?>" attribute2="<?php echo $notification_data[0]['DocType']; ?>"><?php echo $nlevel; ?></td>
                                        <td class="btnnotidata cursorpoint" attribute="<?php echo $notification_data[0]['Reference']; ?>" attribute2="<?php echo $notification_data[0]['DocType']; ?>"><?php echo date("M j, Y g:ia", strtotime($notification_data[0]['DateFiled'])); ?></td>
                                        <td class="btnnotidata cursorpoint tinytext" attribute="<?php echo $notification_data[0]['Reference']; ?>" attribute2="<?php echo $notification_data[0]['DocType']; ?>"><?php echo $astatus; ?></td>
                                        <td class="btnnotidata cursorpoint" attribute="<?php echo $notification_data[0]['Reference']; ?>" attribute2="<?php echo $notification_data[0]['DocType']; ?>"><?php echo $date_approved; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if ($pages) : ?>
                                    <tr>
                                        <td colspan="6" class="centertalign"><?php echo $pages; ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php else : ?>
                                    <tr>
                                        <td class="bold centertalign noborder"><br><br>You have no unread notification</td>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                                <input type="hidden" id="notipage" name="notipage" value="<?php echo $page; ?>" />   
                                </div>
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>