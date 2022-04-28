<?php include(TEMP."/header.php"); ?>

<!-- BODY -->

                
                
                <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                    <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                    <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                    <div class="rightsplashtext lefttalign">
                        <div id="mainapprovers" class="mainbody lefttalign whitetext">  
                            <b class="mediumtext lorangetext">Access MANAGEMENT</b><br><br>                                
                            
                            <table class="width100per">
                                <tr>
                                    <td><span class="fa fa-search"></span> Search: 
                                        <input type="text" id="searchpsman" name="searchpsman" value="<?php echo $_SESSION['searchpsman'] ? $_SESSION['searchpsman'] : ''; ?>" placeholder="by <?php echo $profile_nadd; ?> ID, lastname or firstname" class="smltxtbox width250" />&nbsp;
                                        <input type="button" id="btnpsman" name="btnpsman" value="Search" class="smlbtn" />
                                        <input type="button" id="btnpsmanall" name="btnpsmanall" value="View All" class="smlbtn<?php if (!$_SESSION['searchpsman']) : ?> invisible<?php endif; ?>" />                                            
                                    </td>
                                    <td class="righttalign">
                                        <!--input type="button" id="btnread" name="btnread" value="Mark as Read" class="smlbtn btnred" />
                                        <input type="button" id="btnunread" name="btnunread" value="Mark as Unread" class="smlbtn btnred" /-->                            
                                    </td>
                                </tr>
                            </table>
                            
                            
                        </div>
                    </div>
                </div>

<?php include(TEMP."/footer.php"); ?>