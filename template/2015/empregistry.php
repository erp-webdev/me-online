	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
                    
                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainnotification" class="mainbody lefttalign whitetext">  
                                <b class="mediumtext lorangetext">ACTIVITY REGISTRY</b><br><br>
                                <span id="actreg_title"></span>
                                <form id="frmactreg" action="?ignore-page-cache=true" method="post" enctype="multipart/form-data">
                                    <table>
                                        <tr>
                                            <td>Department</td>
                                            <td>
                                                <select id="deptid" name="deptid" class="txtbox width350">
                                                    <?php foreach ($dept_data as $key => $value) : ?>
                                                    <option value="<?php echo $value['DeptID']; ?>"><?php echo $value['DeptDesc'].' ('.$value['DBNAME'].')'; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Activity</td>
                                            <td>
                                                <select id="actid" name="actid" class="txtbox width350">
                                                    <?php foreach ($act_data as $key => $value) : ?>
                                                    <option value="<?php echo $value['activity_id']; ?>"><?php echo $value['activity_title'].' ('.$value['activity_db'].')'; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Go Directly</td>
                                            <td>
                                                <select id="godir" name="godir" class="txtbox width20">
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>
                                                <input id="btnregistry" type="submit" name="btnregistry" class="btn" />
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>