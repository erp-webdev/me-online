	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
    
            <div id="mainsplashlog" class="mainsplashlog centertalign">  
                <div id="forgot" class="div6 minheight150">                    
                    <span id="ltitle" class="lowerlist robotobold cattext whitetext centertalign">Forgot Password</span>
                    <i id="forgot_title" class="whitetext">The password reset link will be sent to your account's email address.</i>
                    <form name="formforget" method="post" enctype="multipart/form-data" class="margintop25">
                        <input type="text" name="empidnum" id="empidnum" class="txtbox width250" placeholder="Employee ID" /><br><br>
                        
                        <?php if($qnum == 1) : ?>
                        <input type="text" name="empidnum2" id="empidnum" class="txtbox width250" placeholder="SSS Number" /><br><br>
                        <?php elseif($qnum == 2) : ?>
                        <input type="text" name="empidnum2" id="empidnum" class="txtbox width250" placeholder="TIN Number" /><br><br>
                        <?php else : ?>
                        <input type="text" name="empidnum2" id="empidnum" class="txtbox width250" placeholder="Pag-ibig Number" /><br><br>
                        <?php endif; ?>
                        <i class="whitetext">Note: Please remove any special character <br> for the required government id.</i><br><br>
                        
                        <input type="hidden" name="qnumber" value="<?php echo $qnum; ?>" />
                        <input type="submit" name="btnforgot" id="btnforgot" value="Send Reset Link" class="btn" />&nbsp;<input type="button" value="Cancel" class="redbtn" onClick="parent.location='<?php echo WEB; ?>/login'" />
                    </form>   
                    
                </div>
            </div>

    <?php include(TEMP."/footer.php"); ?>