	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
    
            <div id="mainsplashlog" class="mainsplashlog centertalign">  
                <div id="fpass" class="div6">                    
                    <div id="ltitle" class="lowerlist robotobold cattext whitetext centertalign">Change Password</div>
                    <p style="text-align:justify;">
                        <i id="fpass_title" class="whitetext fpass_title">Ensure a strong password by using at least 8 characters, including a combination of uppercase and lowercase letters, numbers, and special characters.</b></i>
                    </p>
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
                            <br><input type="submit" class="btn" value="Update Password">&nbsp;<input type="button" value="Cancel" class="redbtn" onClick="parent.location='<?php echo WEB; ?>'" />
                            <input type="hidden" name="dbname" id="dbname" value="<?php echo $profile_dbname; ?>" />
                        </div>
                    </form>
                    
                </div>
            </div>

    <?php include(TEMP."/footer.php"); ?>