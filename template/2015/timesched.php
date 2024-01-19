	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
                    
                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainsc" class="mainbody lefttalign whitetext">  
                                <b class="mediumtext lorangetext">TIME SCHEDULER</b><br><br>
                                <b>MAIN INFORMATION</b><br><br>
                                <div class="column2">
                                    <b><?php echo ucfirst($profile_nadd); ?> ID: </b><?php echo $profile_idnum; ?><br>
                                    <b>Name: </b><?php echo $profile_full; ?><br>
                                    <b>Position: </b><?php echo $profile_pos; ?><br>
                                    <b>Status: </b>Open<br>
                                    <b>Department: </b><?php echo $profile_dept; ?><br>
                                </div><br>
                                
                                <div id="alert"></div>
                                <form id="frmapplysc" action="?ignore-page-cache=true" method="post" enctype="multipart/form-data">
                                    <div id="tabs">
                                        <ul>
                                            <li><a href="#ldetails">Details</a></li>
                                            <li><a href="#lattach">Attachments</a></li>
                                            <li><a href="#lapprover">Approvers</a></li>
                                        </ul>

                                        <div id="ldetails">
                                            <table class="tdataform" border="0" cellspacing="0">
                                                <tr>
                                                    <td width="15%"><b>DTR Date: </b></td>
                                                    <td width="85%"><input id="tsched_from" type="text" name="tsched_from" class="txtbox datepick3" readonly /> - <input id="tsched_to" type="text" name="tsched_to" class="txtbox datepick3" readonly /></td>
                                                </tr>
                                                <tr>
                                                    <td width="15%"><b>Remarks</b></td>
                                                    <td width="85%" colspan="3">
                                                        <textarea id="tsched_remarks" name="tsched_remarks" rows="3" class="txtarea width95per"></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="15%">&nbsp;</td>
                                                    <td width="85%" colspan="3">
                                                        <div id="divtsched" class="divtsched">
                                                        
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <i>* If there's something wrong with date or time represent within this application, please check your DTR first</i>
                                                    </td>
                                                </tr>
                                            </table>   
                                        </div>
                                        <div id="lattach">
                                            <input type="file" name="attachment1" class="whitetext" /><br>
                                            <input type="file" name="attachment2" class="whitetext" /><br>
                                            <input type="file" name="attachment3" class="whitetext" /><br>
                                            <input type="file" name="attachment4" class="whitetext" /><br>
                                            <input type="file" name="attachment5" class="whitetext" />
                                            <br><br>
                                            <i>* it must be PDF or image (JPG or GIF) and not more than 200Kb each</i>
                                        </div>
                                        <div id="lapprover">
                                            <?php if ($sc_app) : ?>
                                            <?php foreach($sc_app as $key => $value) : ?>
                                                <?php if ($key < 6) : ?>
                                                <b>Level <?php echo $key; ?>:</b> <?php echo trim($value[0]) ? $value[0] : '-- NOT SET --'; ?> <input type="hidden" name="approver<?php echo $key; ?>" value="<?php echo $value[1]; ?>" /><input type="hidden" name="dbapprover<?php echo $key; ?>" value="<?php echo $value[2]; ?>" /><br>           
                                                <?php endif; ?>
                                            <?php endforeach; ?>                     
                                            <?php else : ?>
                                                No approvers has been set
                                            <?php endif; ?>                               
                                        </div>

                                    </div>
                                    <div class="righttalign">
                                        <?php 
                                            $microsec = microtime(); 
                                            $micsec = explode(' ', $microsec);
                                            $finsec = str_replace('.', '', $micsec[1].$micsec[0]);
                                        ?>
                                        <input id="ndays" type="hidden" name="ndays" value="0" />
                                        <input type="hidden" name="empid" value="<?php echo $profile_idnum; ?>" />
                                        <input type="hidden" name="reqnbr" value="<?php echo "SC-".$finsec; ?>" />
                                        <input type="hidden" name="user" value="<?php echo $profile_idnum; ?>" />
                                        <input id="btnscapply" type="submit" name="btnscapply" value="Submit" class="btn invisible margintop10" />
                                        <a href="<?php echo WEB; ?>/pending"><input type="button" name="btncancel" value="Cancel" class="redbtn margintop10" /></a>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>