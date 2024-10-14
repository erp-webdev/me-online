<?php include(TEMP."/header.php"); ?>

<!-- BODY -->
    
<div id="mainsplashlog" class="mainsplashlog centertalign">  
      <div id="rpass" class="div6">                    
         <div id="ltitle" class="lowerlist robotobold cattext whitetext centertalign">New Password</div><br>
         <i id="rpass_title" class="whitetext rpass_title"><br><br></i>
         <form id='resetpassfrm' method="post" enctype="multipart/form-data" action="<?php echo WEB; ?>/reset-password">
            <div class="divpass">
                  <input type="password" name="resetpassword" size="20" id="resetpassword" placeholder="Set a New Password" class="txtbox width250" />
            </div>
            <div class="divpass">
                  <input type="password" name="confirmresetpassword" size="20" id="confirmresetpassword" placeholder="Confirm New Password" class="txtbox width250" />
            </div>
            <br>
            <div align="center" class="width250">
                  <br><input type="submit" class="btn" value="Set Password">&nbsp;<input type="button" value="Cancel" class="redbtn"  onClick="parent.location='<?php echo WEB; ?>'"/>
            </div>
         </form>
      </div>
</div>

<?php include(TEMP."/footer.php"); ?>
