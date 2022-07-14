<?php include(TEMP."/header.php"); ?>

<!-- BODY -->
                <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                    <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                    <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                    <div class="rightsplashtext lefttalign">
                        <div id="mainapprovers" class="mainbody lefttalign whitetext">  
                            <b class="mediumtext lorangetext">WFH MANAGEMENT</b><br><br>                                
                            
                            <table class="width100per">
                                <tr>
                                    <td><span class="fa fa-search"></span> Search: 
                                        <input type="text" id="searchwcman" name="searchwcman" value="<?php echo $_SESSION['searchwcman'] ? $_SESSION['searchwcman'] : ''; ?>" placeholder="by <?php echo $profile_nadd; ?> ID, lastname or firstname" class="smltxtbox width250" />&nbsp;
                                        <input type="button" id="btnwcman" name="btnwcman" value="Search" class="smlbtn" />
                                        <input type="button" id="btnwcmanall" name="btnwcmanall" value="View All" class="smlbtn<?php if (!$_SESSION['searchwcman']) : ?> invisible<?php endif; ?>" />                                            
                                    </td>
                                    <td class="righttalign">
                                        <!--input type="button" id="btnread" name="btnread" value="Mark as Read" class="smlbtn btnred" />
                                        <input type="button" id="btnunread" name="btnunread" value="Mark as Unread" class="smlbtn btnred" /-->                            
                                    </td>
                                </tr>
                            </table>
                            
                            <div id="wcmandata">
                            <table border="0" cellspacing="0" class="tdata width100per">
                                <?php if ($wcman_data) : ?>
                                <tr>
                                    <th width="20%"><?php echo ucfirst($profile_nadd); ?> ID</th>
                                    <th width="30%">Last Name</th>
                                    <th width="30%">First Name</th>
                                    <th width="20%">Manage</th>
                                </tr>
                                <?php foreach ($wcman_data as $key => $value) : ?>    
                                <tr class="trdata centertalign whitetext">
                                    <td><?php echo $value['EmpID']; ?></td>
                                    <td><?php echo $value['LName']; ?></td>
                                    <td><?php echo $value['FName']; ?></td>
                                    <td><a href="<?php echo WEB.'/wfhmanitems?comp='.$value['DBNAME'].'&id='.$value['EmpID']; ?>" class="lorangetext">View Clearance</a></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if ($pages) : ?>
                                <tr>
                                    <td colspan="4" class="centertalign"><?php echo $pages; ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php else : ?>
                                <tr>
                                    <td class="bold centertalign noborder"><br><br>No available WFH Clearance</td>
                                </tr>
                                <?php endif; ?>
                            </table>
                            <input type="hidden" id="wcmanpage" name="wcmanpage" value="<?php echo $page; ?>" />      
                            </div>
                        </div>
                    </div>
                </div>

<?php include(TEMP."/footer.php"); ?>