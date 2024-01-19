	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
                    
                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainapprovers" class="mainbody lefttalign whitetext">  
                                <b class="mediumtext lorangetext"><?php echo strtoupper($profile_nadd); ?> UPDATES MANAGEMENT</b><br><br>                                
                                
                                <table class="width100per">
                                    <tr>
                                        <td><span class="fa fa-search"></span> Search: 
                                            <input type="text" id="searchups" name="searchups" value="<?php echo $_SESSION['searchups'] ? $_SESSION['searchups'] : ''; ?>" placeholder="by <?php echo $profile_nadd; ?> ID, lastname or firstname" class="smltxtbox width250" />&nbsp;
                                            <input type="button" id="btnupd" name="btnupd" value="Search" class="smlbtn" />
                                            <input type="button" id="btnupdall" name="btnupdall" value="View All" class="smlbtn<?php if (!$_SESSION['searchappr']) : ?> invisible<?php endif; ?>" />                                            
                                        </td>
                                        <td class="righttalign">
                                            <!--input type="button" id="btnread" name="btnread" value="Mark as Read" class="smlbtn btnred" />
                                            <input type="button" id="btnunread" name="btnunread" value="Mark as Unread" class="smlbtn btnred" /-->                            
                                        </td>
                                    </tr>
                                </table>
                                
                                <div id="upddata">
                                <table border="0" cellspacing="0" class="tdata width100per">
                                    <?php if ($upddate_data) : ?>
                                    <tr>
                                        <th width="15%"><?php echo ucfirst($profile_nadd); ?> ID</th>
                                        <th width="23%">Last Name</th>
                                        <th width="22%">First Name</th>
                                        <th width="20%">Company</th>
                                        <th width="20%">Manage</th>
                                    </tr>
                                    <?php foreach ($upddate_data as $key => $value) : ?>                                    
                                    <tr class="btnupddata cursorpoint trdata centertalign whitetext" attribute="<?php echo $value['EmpID']; ?>">
                                        <td><?php echo $value['EmpID']; ?></td>
                                        <td><?php echo $value['LName']; ?></td>
                                        <td><?php echo $value['FName']; ?></td>
                                        <td><?php echo $value['DBNAME']; ?></td>
                                        <td><a href="<?php echo WEB.'/idprofile?id='.md5($value['EmpID']); ?>" class="lorangetext">View/Approved Profile</a></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if ($pages) : ?>
                                    <tr>
                                        <td colspan="5" class="centertalign"><?php echo $pages; ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php else : ?>
                                    <tr>
                                        <td class="bold centertalign noborder"><br><br>You have no employees updates listed</td>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                                <input type="hidden" id="updpage" name="updpage" value="<?php echo $page; ?>" />   
                                </div>
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>