	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->

                    <div id="floatdiv" class="floatdiv invisible">
                        <!-- VIEW NOTIFICATION - BEGIN -->
                        <div id="fdbname" class="fview invisible">
                            <div id="noti_title" class="noti_title robotobold cattext dbluetext">Choose Company</div>
                            <div id="noti_data">
                                <br>
                                <select id="txtlogdbname" name="txtlogdbname" class="txtbox">
                                </select>
                                <button id="btnlogdbname" name="btnlogdbname" value="1" class="btn">Submit</button>
                                <button id="btnlogdbcancel" name="btnlogdbcancel" value="1" class="redbtn">Cancel</button>
                            </div>
                        </div>
                        <!-- VIEW NOTIFICATION - END -->
                    </div>

                    <div id="mainsplashlog" class="mainsplashlog lefttalign">
                        <div id="ltitle" class="lowerlist robotobold cattext whitetext centertalign"><?php echo WELCOME; ?></div>
                        <div class="whitetext">The online <?php echo $profile_nadd; ?> self-service employees' portal for <?php echo COMPNAME; ?> employees. It is your electronic ingress for timekeeping application such as leave, OBT, etc. Manage your DTR and payslips.</div>
                        <table class="margintop15 centertalign vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">
                            <!--tr>
                                <td><div class="curvebox centermargin">
                                    <select name="company" id="company" class="txtbox width95">
                                        <option value="2" selected>Global One</option>
                                        <option value="3">Luxury Global Malls</option>
                                    </select>
                                </div></td>
                            </tr-->
                            <tr>
                                <td><div class="curvebox centermargin"><input type="text" name="username" id="username" placeholder="Employee id" class="txtbox width95" /></div></td>
                            </tr>
                            <tr>
                                <td><div class="curvebox centermargin"><input type="password" name="password" id="password" placeholder="Password" class="txtbox width95" /></div></td>
                            </tr>
                            <tr>
                                <td><input type="submit" name="btnlogin" id="btnlogin" value="LOGIN" class="bigbtn btnlogin" />
                            <br><a href="<?php echo WEB; ?>/forgot_password" class="lgraytext">Forgot your password</a>
                            <br><span id="errortd" class="redtext"></span>  </td>
                            </tr>
                        </table>
                    </div>

    <?php include(TEMP."/footer.php"); ?>
