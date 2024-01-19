	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
                    
                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            
                            <div id="mainnotification" class="mainbody lefttalign whitetext">  
                                <b class="hugetext5 lorangetext">Internal Server Error</b><br><br>

                                <div class="lorangetext hugetext3 bold">500</div>
                                <br>
                                You can either head back to the following link: 
                                    <ul>
                                    <li onclick="window.history.back();" class="underlined cursorpoint whitetext">where you belong</li><a href="<?php echo WEB; ?>" class="underlined whitetext"><li>on our homepage</li></a><li>click one of the menu on the left</li>
                                    </ul>
                            </div>
                            
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>