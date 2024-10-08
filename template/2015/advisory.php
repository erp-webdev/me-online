	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
            <div id="mainsplashlog" class="mainsplashlog centertalign">  
                <div class="">                    
                  <span class="lowerlist robotobold cattext whitetext centertalign">Password Update Advisory</span>
                  <br>
                  <p class="whitetext" style="text-align:justify;">
                    To maintain the security of your account, we strongly recommend updating your ME Online portal password regularly. Ensure your password is strong by using at least 8 characters, including a combination of uppercase and lowercase letters, numbers, and special characters.
                  </p>
                  <p class="whitetext" style="text-align:justify;">
                    You can update your password by logging into ME Online and navigating to the <b>"Change Password"</b> link located next to your account name. Regular password updates help safeguard your account from unauthorized access and ensure the protection of your data.
                  </p>
                  <br>
                  <p class="whitetext" style="text-align:justify;">
                    <i>Note: This advisory will continue to appear on your screen until you change your password or opt to waive this reminder.</i>
                  </p>

                  <input type="button" value="Change Password" class="btn" onClick="parent.location='<?php echo WEB; ?>/change_password'" />&nbsp;<input type="button" value="Waive" class="redbtn" onClick="parent.location='<?php echo WEB; ?>/waive_advisory'" />
                </div>
            </div>

    <?php include(TEMP."/footer.php"); ?>