	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
    
            <div id="mainsplashlog" class="mainsplashlog centertalign">  
                <div id="fpass" class="div6">                    
                    <div id="ltitle" class="lowerlist robotobold cattext whitetext centertalign">Change My Password</div>
                    <i id="fpass_title" class="whitetext fpass_title">* To update your password, please fill up textbox below. New password must not contain <b>ampersand (&amp;)</b> nor <b>plus sign (+)</b></i>
                    <form name="formupass" method="post" enctype="multipart/form-data">
                        <div class="divpass">
                            <input type="hidden" name="empnum" value="<?php echo $profile_idnum; ?>" />
                            <input type="password" name="opassword" size="20" id="opassword" placeholder="Old Password" class="txtbox width250" />
                        </div>
                        <div class="divpass">
                            <input type="password" name="npassword" size="20" id="npassword" placeholder="New Password" class="txtbox width250" />
                        </div>
                        <div class="divpass">
                            <input type="password" name="cpassword" size="20" id="cpassword" placeholder="Confirm New Password" class="txtbox width250" />
                        </div>
                        <div align="center" class="width250">
                            <br><input type="submit" class="btn" value="Update My Password">&nbsp;<input type="button" value="Cancel" class="redbtn" onClick="parent.location='<?php echo WEB; ?>'" />
                            <input type="hidden" name="dbname" id="dbname" value="<?php echo $profile_dbname; ?>" />
                        </div>
                    </form>
                    
                </div>
            </div>

    <?php include(TEMP."/footer.php"); ?>