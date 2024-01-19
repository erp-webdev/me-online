	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
                    
                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainleave" class="mainbody lefttalign whitetext">  
                                <b class="mediumtext lorangetext">MEAL ALLOWANCE FORM</b><br><br>
                                <b>MAIN INFORMATION</b><br><br>
                                <div class="column2">
                                    <b><?php echo ucfirst($profile_nadd); ?> ID: </b>2014-01-N506<br>
                                    <b>Name: </b>JOSE ZEQUE ISLETA III<br>
                                    <b>Position: </b>Sr. Web Developer<br>
                                    <b>Status: </b>Open<br>
                                    <b>Department: </b>Information Technology<br>
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
                                                    <td width="15%"><b>Type: </b></td>
                                                    <td width="85%" colspan="3">
                                                        <select name="ma_type" class="txtbox width95">
                                                            <option value="field">Field</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="15%"><b>From: </b></td>
                                                    <td width="35%"><input id="ma_from" type="text" name="ma_from" value="<?php echo date('Y-m-d'); ?>" class="txtbox datepick3 width95per" /></td>
                                                    <td width="15%"><b>To: </b></td>
                                                    <td width="35%"><input id="ma_to" type="text" name="ma_to" value="<?php echo date('Y-m-d'); ?>" class="txtbox datepick3 width95per" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="15%">&nbsp;</td>
                                                    <td width="85%" colspan="3">
                                                        <div id="mealsched" class="mealsched">
                                                        
                                                        </div>                                                          
                                                    </td>
                                                </tr>
                                            </table>    
                                        </div>
                                        <div id="lattach">
                                            <b>Attachments</b><br><br>
                                            <input type="file" name="attachment1" class="whitetext" /><br>
                                            <input type="file" name="attachment2" class="whitetext" /><br>
                                            <input type="file" name="attachment3" class="whitetext" /><br>
                                            <input type="file" name="attachment4" class="whitetext" /><br>
                                            <input type="file" name="attachment5" class="whitetext" />
                                        </div>
                                        <div id="lapprover">
                                            <b>Approvers</b><br><br>
                                            <?php if ($ma_app) : ?>
                                            <?php foreach($ma_app as $key => $value) : ?>
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
                                        <a href="<?php echo WEB; ?>/notification"><input type="button" name="btncancel" value="Cancel" class="redbtn margintop10" /></a>                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>