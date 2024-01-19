	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->

                    <div id="floatdiv" class="floatdiv invisible">                    
                        
                        <!-- EDIT APPROVERS - BEGIN --> 
                        <div id="aedit" class="fedit2" style="display: none;">
                            <div class="closebutton2 cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                            
                            <!-- SEARCH APPROVERS - BEGIN --> 
                            <div id="asearch" class="fsearch invisible">
                                <div class="closebutton3 cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                                <i class="fa fa-search"></i> Search approver <input id="apsrsearch" type="text" name="apsrsearch" placeholder="and press ENTER..." class="txtbox" /> <button id="btnapsrdel" name="btnapsrdel" class="btnapsrdel redbtn invisible">Delete this Approver</button>
                                <div id="apsr_data" class="apsr_data">

                                </div>
                                <div id="apsr_button" class="apsr_button centertalign">
                                    <input id="apsrtbid" type="hidden" name="apsrtbid" />
                                    <input id="apsrtbdb" type="hidden" name="apsrtbdb" />
                                </div>
                            </div>
                            <!-- SEARCH APPROVERS - END -->  
                            
                            <div id="appr_title" class="appr_title robotobold cattext dbluetext"></div>
                            <div id="appr_data">
                            
                            </div>
                            <div id="appr_button" class="appr_button centertalign">
                                <input id="appempid" type="hidden" name="appempid" />
                                <input id="appcount" type="hidden" name="appcount" />
                                <input id="appdbname" type="hidden" name="appdbname" />
                                <button id="btnapprovers" class="btn btnapprovers invisible">Update</button>
                            </div>
                        </div>
                        <!-- EDIT APPROVERS - END -->    
                    </div>
                    
                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainapprovers" class="mainbody lefttalign whitetext">  
                                <b class="mediumtext lorangetext">APPROVERS MANAGEMENT</b><br><br>                                
                                
                                <table class="width100per">
                                    <tr>
                                        <td><span class="fa fa-search"></span> Search: 
                                            <input type="text" id="searchappr" name="searchappr" value="<?php echo $_SESSION['searchappr'] ? $_SESSION['searchappr'] : ''; ?>" placeholder="by <?php echo $profile_nadd; ?> ID, lastname or firstname" class="smltxtbox width250" />&nbsp;
                                            <input type="button" id="btnappr" name="btnappr" value="Search" class="smlbtn" />
                                            <input type="button" id="btnapprall" name="btnapprall" value="View All" class="smlbtn<?php if (!$_SESSION['searchappr']) : ?> invisible<?php endif; ?>" />                                            
                                        </td>
                                        <td class="righttalign">
                                            <!--input type="button" id="btnread" name="btnread" value="Mark as Read" class="smlbtn btnred" />
                                            <input type="button" id="btnunread" name="btnunread" value="Mark as Unread" class="smlbtn btnred" /-->                            
                                        </td>
                                    </tr>
                                </table>
                                
                                <div id="apprdata">
                                <table border="0" cellspacing="0" class="tdata width100per">
                                    <?php if ($approver_data) : ?>
                                    <tr>
                                        <th width="20%"><?php echo ucfirst($profile_nadd); ?> ID</th>
                                        <th width="40%">Last Name</th>
                                        <th width="40%">First Name</th>
                                        <!--th width="20%">Company</th-->
                                    </tr>
                                    <?php foreach ($approver_data as $key => $value) : ?>                                    
                                    <tr class="btnapprdata cursorpoint trdata centertalign whitetext" attribute="<?php echo $value['EmpID']; ?>" attribute2="<?php echo $profile_dbname; ?>">
                                        <td><?php echo $value['EmpID']; ?></td>
                                        <td><?php echo $value['LName']; ?></td>
                                        <td><?php echo $value['FName']; ?></td>
                                        <!--td><?php echo $value['DBNAME']; ?></td-->
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
                                </div>
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>