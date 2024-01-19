	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
                    
                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainactivity" class="mainbody lefttalign whitetext">  
                                <b class="mediumtext lorangetext">BIRTHDAY CARD MANAGEMENT</b><br><br>                            
                                
                                <form name="add_bimg" id="add_bimg" action="?ignore-page-cache=true" method="POST" enctype="multipart/form-data">
                                    <span id="bimg_title"></span>
                                    <table class="tdataform">
                                        <tr>
                                            <td colspan="2"><textarea id="bimg_message" name="bimg_message" rows="5" cols="70" placeholder="Birthday message (not required)..." class="txtarea marginbottom5"><?php echo $bimg_data[0]['bimg_message']; ?></textarea></td>
                                        </tr>
                                        <tr>
                                            <td>Megaworld</td>
                                            <td><input id="bimg_filename1" type="file" name="bimg_filename1" class="txtbox txtfile" /></td>
                                        </tr>
                                        <tr>
                                            <td>Global One</td>
                                            <td><input id="bimg_filename2" type="file" name="bimg_filename2" class="txtbox txtfile" /></td>
                                        </tr>
                                        <tr>
                                            <td>Luxury Global</td>
                                            <td><input id="bimg_filename3" type="file" name="bimg_filename3" class="txtbox txtfile" /></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><button id="btncreatebimg" type="submit" name="btncreatebimg" value="1" class="btn">Update Birthday Card</button>
                                            </td>
                                        </tr>
                                    </table><!--&nbsp;
                                    <button id="btnsendbday" type="submit" name="btnsendbday" value="1" class="btn">Send Birthday Card</button-->
                                    
                                </form>
                                
                                <div id="divbdayimg" class="margintop25">
                                    <?php if ($bimg_data) : ?>
                                        <?php if ($bimg_data[0]['bimg_filename1']) : ?>
                                        <img src="<?php echo WEB; ?>/uploads/birthday/<?php echo $bimg_data[0]['bimg_filename1']; ?>" class="width200 inline valigntop" />
                                        <?php endif; ?>
                                        <?php if ($bimg_data[0]['bimg_filename2']) : ?>
                                        <img src="<?php echo WEB; ?>/uploads/birthday/<?php echo $bimg_data[0]['bimg_filename2']; ?>" class="width200 inline valigntop" />
                                        <?php endif; ?>
                                        <?php if ($bimg_data[0]['bimg_filename3']) : ?>
                                        <img src="<?php echo WEB; ?>/uploads/birthday/<?php echo $bimg_data[0]['bimg_filename3']; ?>" class="width200 inline valigntop" />
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>