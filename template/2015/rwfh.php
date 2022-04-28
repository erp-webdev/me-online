<?php include(TEMP."/header.php"); ?>
<!-- BODY -->
<div id="mainsplashtext" class="mainsplashtext lefttalign">
    <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
    <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
    <div class="rightsplashtext lefttalign">
        <div id="mainwfh" class="mainbody lefttalign whitetext">
            <b class="mediumtext lorangetext">WFH Clearance</b> <small><i></i></small><br><br>
            <b>MAIN INFORMATION</b><br><br>
            <div class="column2">
                <b><?php echo ucfirst($profile_nadd); ?> ID: </b><?php echo $profile_idnum; ?><br>
                <b>Name: </b><?php echo $profile_full; ?><br>
                <b>Position: </b><?php echo $profile_pos; ?><br>
                <b>Status: </b>Open<br>
                <b>Department: </b><?php echo $profile_dept; ?><br>
            </div><br>

            <div id="alert"></div>
            <form id="frmapplyrwfh" name="frmapplyrwfh" action="?ignore-page-cache=true" method="post" enctype="multipart/form-data">
                
            <div id="tabs">
                <ul>
                    <li><a href="#ldetails">Details</a></li>
                    <li><a href="#lattach">Attachments</a></li>
                    <li><a href="#lapprover">Approvers</a></li>
                </ul>

                <div id="ldetails">
                    <table>
                        <tr>
                            <td width="50%" class="valigntop">
                                <table class="tdataform" border="0" cellspacing="0">
                                    <tr>
                                        <td width="15%"><b>Type: </b></td>
                                        <td width="85%" colspan="3">
                                            <select id="rwfh_type" name="rwfh_type" class="txtbox width95per">
                                                <option value="sickness">Illness/Sickness</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="15%"><b>Coverage: </b></td>
                                        <td width="35%"><input type="text" id="rwfh_from" name="rwfh_from" value="<?php echo date('Y-m-d'); ?>" class="txtbox datepick7 width95per" readonly /></td>
                                        <td width="15%"><b>To: </b></td>
                                        <td width="35%"><input type="text" id="rwfh_to" name="rwfh_to" value="<?php echo date('Y-m-d'); ?>" class="txtbox datepick7 width95per" readonly /><input type="text" class="txtbox width95per rwfh2" readonly /></td>
                                    </tr>
                                    <tr>
                                        <td><b>Reason: </b></td>
                                        <td colspan="3">
                                            <textarea id="rwfh_reason" name="rwfh_reason" rows="5" class="txtarea width95per"></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <i>* If there's something wrong with date or time represent within this application, please check your DTR first</i>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="lattach">
                    <input id="attachment1" type="file" name="attachment1" class="whitetext" /><br>
                    <input id="attachment2" type="file" name="attachment2" class="whitetext" /><br>
                    <input id="attachment3" type="file" name="attachment3" class="whitetext" /><br>
                    <input id="attachment4" type="file" name="attachment4" class="whitetext" /><br>
                    <input id="attachment5" type="file" name="attachment5" class="whitetext" />
                    <br><br>
                    <i>* it must be PDF or image (JPG or GIF) and not more than 200Kb each</i>
                </div>
                <div id="lapprover">
                    <?php if($rwh_app) : ?>
                    <?php foreach($rwh_app as $key => $value) : ?>
                        <?php if ($key < 6) : ?>
                        <b>Level <?php echo $key; ?>:</b> <?php echo trim($value[0]) ? $value[0] : '-- NOT SET --'; ?> <input type="hidden" name="approver<?php echo $key; ?>" value="<?php echo $value[1]; ?>" /><input type="hidden" name="dbapprover<?php echo $key; ?>" value="<?php echo $value[2]; ?>" /><br>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php else : ?>
                        No approvers has been set
                    <?php endif; ?>
                </div>
            </div>

                <div class="righttalign">
                    <?php
                        $microsec = microtime();
                        $micsec = explode(' ', $microsec);
                        $finsec = str_replace('.', '', $micsec[1].$micsec[0]);
                    ?>
                    <input id="ndays" type="hidden" name="ndays" value="<?php echo $dayn; ?>" />
                    <input type="hidden" name="empid" value="<?php echo $profile_idnum; ?>" />
                    <input type="hidden" name="reqnbr" value="<?php echo "WC-".$finsec; ?>" />
                    <input type="hidden" name="user" value="<?php echo $profile_idnum; ?>" />
                    <input id="btnwfhapply" type="submit" name="btnwfhapply" value="Submit" class="btn margintop10" />
                </div>

            </form>

        </div>
    </div>
</div>
<?php include(TEMP."/footer.php"); ?>
