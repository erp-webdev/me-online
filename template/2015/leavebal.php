	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->

                    <div id="floatdiv" class="floatdiv invisible">                                         
                        <!-- VIEW NOTIFICATION - BEGIN --> 
                        <div id="lbview" class="fview" style="display: none;">
                            <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                            <div id="lbal_title" class="lbal_title robotobold cattext dbluetext"></div>
                            
                            <div id="lbal_data">
                            
                            </div>
                        </div>
                        <!-- VIEW NOTIFICATION - END -->    
                    </div>
                    
                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainnotification" class="mainbody lefttalign whitetext">  
                                <b class="mediumtext lorangetext">LEAVE BALANCE</b><br><br>
                                
                                <table border="0" cellspacing="0" class="tdata" style="width: 100%">
                                    <tr>
                                        <th width="35%" rowspan="2">Leave Type</th>
                                        <th width="30%" colspan="3"><?php echo $profile_compressed ? 'Hours' : 'Days'; ?></th>
                                        <th width="10%" rowspan="2">Validity</th>
                                        <th width="25%" colspan="2" rowspan="2">View <i class="fa fa-eye"></i></th>
                                    </tr>
                                    <tr>
                                        <th width="10%">Earned</th>
                                        <th width="10%">Used</th>
                                        <th width="10%">Balance</th>
                                    </tr>
                                    
                                    <?php 
                                        if ($leave_data) :
                                        
                                            foreach ($leave_data as $key => $value) :
                                            ?>
                                                <?php $leave_bal = $mainsql->get_leavebal_byid($profile_idnum, $value['LeaveID']); ?>
                                                <tr class="trdata">
                                                    <td><?php echo $value['LeaveDesc']; ?></td>
                                                    <?php if ($profile_compressed) : ?>
                                                    <td class="centertalign"><?php echo $leave_bal[0]['EarnedHrs'] ? number_format($leave_bal[0]['EarnedHrs'], 2) : '0.00' ; ?></td>
                                                    <td class="centertalign"><?php echo $leave_bal[0]['UsedHrs'] ? number_format($leave_bal[0]['UsedHrs'], 2) : '0.00' ; ?></td>
                                                    <td class="centertalign"><?php echo $leave_bal[0]['BalanceHrs'] ? number_format($leave_bal[0]['BalanceHrs'], 2) : '0.00' ; ?></td>
                                                    <?php else : ?>
                                                    <td class="centertalign"><?php echo $leave_bal[0]['EarnedDays'] ? number_format($leave_bal[0]['EarnedDays'], 2) : '0.00' ; ?></td>
                                                    <td class="centertalign"><?php echo $leave_bal[0]['UsedDays'] ? number_format($leave_bal[0]['UsedDays'], 2) : '0.00' ; ?></td>
                                                    <td class="centertalign"><?php echo $leave_bal[0]['BalanceDays'] ? number_format($leave_bal[0]['BalanceDays'], 2) : '0.00' ; ?></td>
                                                    <?php endif; ?>        
                                                    <td class="centertalign"><?php echo $leave_bal ? 'VALID' : 'INVALID' ; ?></td>
                                                    <td class="centertalign"><?php echo $leave_bal ? '<span class = "btnlbaldata cursorpoint" attribute="'.$value['LeaveDesc'].'">Summary</span>' : '&nbsp;'; ?></td>
                                                    <td class="centertalign"><?php echo $leave_bal ? '<span class = "btnlleddata cursorpoint" attribute="'.$value['LeaveDesc'].'" attribute2="'.$value['LeaveID'].'">Ledger</span>' : '&nbsp;'; ?></td>
                                                </tr>
                                            <?php
                                            endforeach;

                                        else :
                                            ?>
                                    
                                            <tr class="trdata">
                                                <td colspan="7" class="centertalign">No record found</td>
                                            </tr>    
                                    
                                            <?php                                            
                                        endif;
                                    ?>
                                </table>
                                <!--p>
                                    <b>MESSAGE:</b>	Pending Balance refers to the total requested DAYS that have not been APPROVED/REJECTED.
                                </p-->
                                
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>