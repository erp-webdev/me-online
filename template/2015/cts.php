	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
                    
                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainleave" class="mainbody lefttalign whitetext">  
                                <b class="mediumtext lorangetext">CHANGE OF TIME SCHEDULE</b><br><br>
                                <b>MAIN INFORMATION</b><br><br>
                                <div class="column2">
                                    <b><?php echo ucfirst($profile_nadd); ?> ID: </b><?php echo $profile_idnum; ?><br>
                                    <b>Name: </b><?php echo $profile_full; ?><br>
                                    <b>Position: </b><?php echo $profile_pos; ?><br>
                                    <b>Status: </b>Open<br>
                                    <b>Department: </b><?php echo $profile_dept; ?><br>
                                </div><br>
                                
                                <form id="frm_cts" method="post" enctype="multipart/form-data">
                                    <div id="tabs">
                                        <ul>
                                            <li><a href="#ldetails">Details</a></li>
                                            <li><a href="#lattach">Attachments</a></li>
                                            <li><a href="#lapprover">Approvers</a></li>
                                        </ul>

                                        <div id="ldetails">
                                            <table class="tdataform" border="0" cellspacing="0">
                                                <tr>
                                                    <td width="15%"><b>Message: </b></td>
                                                    <td width="85%" colspan="3"></td>
                                                </tr>
                                                <tr>
                                                    <td width="15%"><b>Date Covered: </b></td>
                                                    <td width="35%"><input id="cts_date" type="text" name="cts_date" class="txtbox datepick3 width200" /></td>
                                                    <td width="15%"><b>Day: </b></td>
                                                    <td width="35%"><span id="ctsday" class="ctsday"></span></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                    <div id="divcts" class="divcts">
                                                            
                                                    </div>
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
                                        </div>
                                        <div id="lapprover">
                                            <?php if ($sc_app) : ?>
                                            <?php foreach($sc_app as $key => $value) : ?>
                                                <?php if ($key < 6) : ?>
                                                <b>Level <?php echo $key; ?>:</b> <?php echo $value[0]; ?> <input type="hidden" name="txtapp<?php echo $key; ?>" value="<?php echo $value[1]; ?>" /><br>           
                                                <?php endif; ?>
                                            <?php endforeach; ?>                    
                                            <?php else : ?>
                                                No approvers has been set
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="righttalign">
                                        <input type="submit" name="btnsubcts" value="Submit" class="btn margintop10" />
                                        <input type="button" name="btncancel" value="Cancel" class="redbtn margintop10" />
                                    </div>
                                
                                </form>
                                
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>