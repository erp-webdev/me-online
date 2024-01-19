	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
                    
                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainnotification" class="mainbody lefttalign whitetext">  
                                <b class="mediumtext lorangetext">MESSAGES</b><br><br>
                                
                                <table border="0" cellspacing="0" class="width100per">
                                    <tr>
                                        <td><span class="fa fa-search"></span>&nbsp;Search message <input type="text" name="txtsearchmsg" placeholder="by date or part of message" class="txtbox" />&nbsp;<input type="button" name="btnsearchmsg" value="Search" class="btn" /></td>
                                        <td class="righttalign"><input type="button" name="btnaddmsg" value="Compose Message" class="btn" /></td>
                                    </tr>
                                </table>
                                
                                <table border="0" cellspacing="0" class="tdata">
                                    <tr>
                                        <th width="15%">Date</th>
                                        <th width="20%">Sender</th>
                                        <th width="50%">Message</th>
                                        <th width="15%" class="centertalign">Action</th>
                                    </tr>
                                    <tr class="trdata">
                                        <td>Oct 26, 2014 - 12:24pm</td>
                                        <td>EDMAR SULTAN</td>
                                        <td>Happy birthday Sir Jo ! haha</td>
                                        <td class="centertalign"><i class="fa fa-trash-o"></i></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>