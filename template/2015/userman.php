	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->

                    
                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainemps" class="mainbody lefttalign whitetext">  
                                <b class="mediumtext lorangetext">EMPLOYEES MANAGEMENT</b><br><br>                                
                                
                                <table class="width100per">
                                    <tr>
                                        <td><span class="fa fa-search"></span> Search: 
                                            <input type="text" id="searchemp" name="searchemp" value="<?php echo $_SESSION['searchemp'] ? $_SESSION['searchemp'] : ''; ?>" placeholder="by <?php echo $profile_nadd; ?> ID, lastname or firstname" class="smltxtbox width250" />&nbsp;
                                            <input type="button" id="btnemp" name="btnemp" value="Search" class="smlbtn" />
                                            <input type="button" id="btnempall" name="btnempall" value="View All" class="smlbtn<?php if (!$_SESSION['searchemp']) : ?> invisible<?php endif; ?>" />                                            
                                        </td>
                                        <td class="righttalign">
                                            <!--input type="button" id="btnread" name="btnread" value="Mark as Read" class="smlbtn btnred" />
                                            <input type="button" id="btnunread" name="btnunread" value="Mark as Unread" class="smlbtn btnred" /-->                            
                                        </td>
                                    </tr>
                                </table>
                                
                                <div id="empdata">
                                <table border="0" cellspacing="0" class="tdata width100per">
                                    <?php if ($emp_data) : ?>
                                    <tr>
                                        <th width="15%"><?php echo ucfirst($profile_nadd); ?> ID</th>
                                        <th width="23%">Last Name</th>
                                        <th width="22%">First Name</th>
                                        <th width="20%">Position</th>
                                        <th width="20%">Department</th>
                                    </tr>
                                    <?php foreach ($emp_data as $key => $value) : ?>                                    
                                    <tr class="btnempdata cursorpoint trdata centertalign whitetext" attribute="<?php echo md5($value['EmpID']); ?>">
                                        <td><?php echo $value['EmpID']; ?></td>
                                        <td><?php echo $value['LName']; ?></td>
                                        <td><?php echo $value['FName']; ?></td>
                                        <td><?php echo $value['PositionDesc']; ?></td>
                                        <td><?php echo $value['DeptDesc']; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if ($pages) : ?>
                                    <tr>
                                        <td colspan="7" class="centertalign"><?php echo $pages; ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php else : ?>
                                    <tr>
                                        <td class="bold centertalign noborder"><br><br>You have no employees listed</td>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                                <input type="hidden" id="emppage" name="emppage" value="<?php echo $page; ?>" />   
                                </div>
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>