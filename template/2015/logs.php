	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
                    
                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainlogs" class="mainbody lefttalign whitetext">  
                                <b class="mediumtext lorangetext">LOGS</b><br><br>                                
                                
                                <table class="width100per">
                                    <tr>
                                        <td><span class="fa fa-search"></span> Search: 
                                            <input type="text" id="logsfrom" name="logsfrom" value="<?php echo $_SESSION['logsfrom'] ? $_SESSION['logsfrom'] : '2014-08-01'; ?>" placeholder="From.." class="smltxtbox width55 datepick2" /> - 
                                            <input type="text" id="logsto" name="logsto" value="<?php echo $_SESSION['logsto'] ? $_SESSION['logsto'] : date("Y-m-d"); ?>" placeholder="To..." class="smltxtbox width55 datepick2" /> by 
                                            <input type="text" id="searchlogs" name="searchlogs" value="<?php echo $_SESSION['searchlogs'] ? $_SESSION['searchlogs'] : ''; ?>" placeholder="<?php echo $profile_nadd; ?> ID" class="smltxtbox" />&nbsp;
                                            <input type="button" id="btnlogs" name="btnlogs" value="Search" class="smlbtn" />
                                            <input type="button" id="btnlogsall" name="btnlogsall" value="View All" class="smlbtn<?php if (!$_SESSION['searchlogs'] && !$_SESSION['logsfrom'] && !$_SESSION['logsto']) : ?> invisible<?php endif; ?>" />                                            
                                        </td>
                                        <td class="righttalign">
                                            <!--input type="button" id="btnread" name="btnread" value="Mark as Read" class="smlbtn btnred" />
                                            <input type="button" id="btnunread" name="btnunread" value="Mark as Unread" class="smlbtn btnred" /-->                            
                                        </td>
                                    </tr>
                                </table>
                                
                                <div id="logsdata">
                                <table border="0" cellspacing="0" class="tdata width100per">
                                    <?php if ($logs_data) : ?>
                                    <tr>
                                        <th width="40%">Employee</th>
                                        <th width="20%">Tasks</th>
                                        <th width="15%">Data</th>
                                        <th width="25%">Date</th>
                                    </tr>
                                    <?php foreach ($logs_data as $key => $value) : ?>  
                                    <?php $emp_info = $register->get_member($value['EmpID']); ?>
                                    <tr class="btnlogsdata cursorpoint trdata centertalign whitetext">
                                        <td><?php echo $emp_info[0]['FName']; ?> <?php echo $emp_info[0]['LName']; ?> (<?php echo $value['EmpID']; ?>)</td>
                                        <td><?php echo $value['Tasks']; ?></td>
                                        <td><?php echo $value['Data']; ?></td>
                                        <td><?php echo date("M j, Y | g:ia", strtotime($value['Date'])); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if ($pages) : ?>
                                    <tr>
                                        <td colspan="4" class="centertalign"><?php echo $pages; ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php else : ?>
                                    <tr>
                                        <td class="bold centertalign noborder"><br><br>You have no logs</td>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                                <input type="hidden" id="logspage" name="logspage" value="<?php echo $page; ?>" />   
                                </div>
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>