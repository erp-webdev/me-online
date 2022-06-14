	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->

                    <div id="floatdiv" class="floatdiv invisible">

                        <div id="actview" class="fview">
                            <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>

                            <div id="cards">
                                <div class="front">
                                    <div id="mview_title" class="robotobold cattext dbluetext"></div>
                                    <div id="activity_data" class="floatdata margintop15"></div>
                                </div>
                                <div id="actreg" class="back whitebg">
                                    <div id="actreg_title" class="robotobold cattext dbluetext"></div>
                                    <div class="floatdata margintop30">
                                        <form name="regis_act" id="regis_act" action="?ignore-page-cache=true" method="POST" enctype="multipart/form-data">
                                            <table class="width100per">
                                                <tr>
                                                    <td width="30%"><b>Registrant</b></td>
                                                    <td width="70%"><?php echo $profile_full.' ('.$profile_idnum.')'; ?></td>
                                                </tr>
                                                <tr id="godir">
                                                    <td><b>I'll go directly</b></td>
                                                    <td>
                                                        <select id="registry_godirectly" name="registry_godirectly" class="txtbox">
                                                            <option value="1">Yes</option>
                                                            <option value="0">No</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr id="numchild">
                                                    <td class="valigntop"><b>No. of Children</b></td>
                                                    <td>
                                                        <select id="numchi" name="numchi" class="txtbox">
                                                            <?php for ($ii=0; $ii<=5; $ii++) : ?>
                                                            <option value="<?php echo $ii; ?>"><?php echo $ii; ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr id="children" class="invisible">
                                                    <td class="valigntop"><b>Children</b></td>
                                                    <td id="divchidata"></td>
                                                </tr>
                                                <tr id="numdependent">
                                                    <td class="valigntop"><b>No. of Dependent</b></td>
                                                    <td>
                                                        <select id="numindi" name="numindi" class="txtbox">
                                                            <?php for ($ii=0; $ii<=5; $ii++) : ?>
                                                            <option value="<?php echo $ii; ?>"><?php echo $ii; ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr id="dependent" class="invisible">
                                                    <td class="valigntop"><b>Dependent/s</b></td>
                                                    <td id="divindidata"></td>
                                                </tr>
                                                <tr id="numguest">
                                                    <td class="valigntop"><b>No. of Guest</b></td>
                                                    <td>
                                                        <select id="numgue" name="numgue" class="txtbox">
                                                            <?php for ($ii=0; $ii<=5; $ii++) : ?>
                                                            <option value="<?php echo $ii; ?>"><?php echo $ii; ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr id="guest" class="invisible">
                                                    <td class="valigntop"><b>Guest/s</b></td>
                                                    <td id="divguestdata"></td>
                                                </tr>
                                            </table>
                                            <!--table id="godiryes" class="width100per">
                                                <tr>
                                                    <td width="30%"><b>Vehicle Plate Number</b></td>
                                                    <td width="70%">
                                                        <input id="registry_platenum" type="text" name="registry_platenum" class="txtbox" />
                                                    </td>
                                                </tr>
                                            </table-->
                                            <table id="godirno" class="width100per invisible">
                                                <tr>
                                                    <td rowspan="2" width="30%"><b>Company Vehicle</b></td>
                                                    <td width="5%">
                                                        <input id="registry_vrin" type="checkbox" name="registry_vrin" />
                                                    </td>
                                                    <td width="65%">To <span class="placedata"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input id="registry_vrout" type="checkbox" name="registry_vrout" />
                                                    </td>
                                                    <td>From <span class="placedata"></span></td>
                                                </tr>
                                            </table>
                                            <div class="spanapp width100per redtext italic margintop25 righttalign">* subject by your superior's approval</div>
                                            <div class="width100per margintop25 centertalign">
                                                <input id="registry_uid" type="hidden" name="registry_uid" value="<?php echo $profile_id; ?>" />
                                                <input id="registry_activityid" type="hidden" name="registry_activityid" value="" />
                                                <input id="registry_activitytype" type="hidden" name="registry_activitytype" value="" />
                                                <input id="registry_db" type="hidden" name="registry_db" value="<?php echo $profile_dbname; ?>" />
                                                <input id="registry_approve" type="hidden" name="registry_approve" value="" />
                                                <button name="btnregsub" class="btn btnregsub" value="1"><i class="fa fa-check"></i> Submit</button>
                                                <button class="redbtn btnreg2"><i class="fa fa-times"></i> Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if ($profile_level == 7 || $profile_level == 9 || $profile_level == 10) : ?>
                        <!-- CREATE ACTIVITY - BEGIN -->
                        <div id="actadd" class="fadd" style="display: none;">
                            <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                            <div id="actadd_title" class="robotobold cattext marginbottom15 dbluetext">Create Activity</div>
                            <table class="tdataform2 rightmargin margintop15 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">
                                <form name="create_act" id="create_act" action="?ignore-page-cache=true" method="POST" enctype="multipart/form-data">
                                <tr>
                                    <td>Activity Title</td>
                                    <td>
                                        <input type="text" name="activity_title" id="activity_title" value="<?php echo $_POST['activity_title']; ?>" class="txtbox width300" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Venue</td>
                                    <td>
                                        <input type="text" name="activity_venue" id="activity_venue" value="<?php echo $_POST['activity_venue']; ?>" class="txtbox width300" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td>
                                        <input type="text" name="activity_description" id="activity_description" value="<?php echo $_POST['activity_description']; ?>" class="txtbox width350" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Type</td>
                                    <td>
                                        <select name="activity_type" id="activity_type" class="activity_type txtbox width300">
                                            <option value="1">Training</option>
                                            <option value="2">Project Visit</option>
                                            <option value="3">Wellness</option>
                                            <option value="4">Party</option>
                                            <option value="5">Fun Day</option>
                                            <option value="6">Other</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date</td>
                                    <td>
                                        <input type="text" name="activity_dates" id="activity_dates" class="txtbox checkindate width95" value="<?php echo date("Y-m-d"); ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Time</td>
                                    <td>
                                        <input type="text" name="activity_timein" id="activity_timein" class="txtbox timepick width95" value="8:00am" />&nbsp;<input type="text" name="activity_timeout" id="activity_timeout" class="txtbox timepick width95" value="6:00pm" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>
                                        <span class="actatt07"><input id="activity_endregister" type="checkbox" name="activity_endregister" value="1" /> <label for="activity_endregister">Disable Registration</label></span>
                                        <span class="actatt02"><input id="activity_guest" type="checkbox" name="activity_guest" value="1" /> <label for="activity_guest">Guest</label></span>
                                        <span class="actatt03"><input id="activity_dependent" type="checkbox" name="activity_dependent" value="1" /> <label for="activity_dependent">Dependent</label></span>
                                        <span class="actatt04"><input id="activity_cvehicle" type="checkbox" name="activity_cvehicle" value="1" /> <label for="activity_cvehicle">Company Vehicle</label></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>
                                        <span class="actatt08"><input id="activity_backout" type="checkbox" name="activity_backout" value="1" /> <label for="activity_feedback">Disable Backout</label></span>
                                        <span class="actatt01"><input id="activity_approve" type="checkbox" name="activity_approve" value="1" /> <label for="activity_approve">Need Approval</label></span>
                                        <span class="actatt05"><input id="activity_feedback" type="checkbox" name="activity_feedback" value="1" /> <label for="activity_feedback">Feedback</label></span>
                                        <span class="actatt06"><input id="activity_offsite" type="checkbox" name="activity_offsite" value="1" /> <label for="activity_offsite">Offreg Only</label></span>
                                    </td>
                                </tr>
                                <tr id="acthours">
                                    <td>Hours</td>
                                    <td>
                                        <select name="activity_hours" id="activity_hours" class="txtbox width95">
                                            <?php
                                                $ah = 0;
                                                while ($ah <= 24) :
                                                    echo '<option value="'.number_format($ah, 2).'">'.number_format($ah, 1).'</option>';
                                                    $ah = $ah + 0.5;
                                                endwhile;
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Slot</td>
                                    <td>
                                        <select name="activity_slots" id="activity_slots" class="txtbox width95" value="<?php echo $_POST['activity_slots']; ?>">
                                            <?php for ($i=1; $i<=5000; $i++) : ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Image</td>
                                    <td>
                                        <input type="file" name="activity_attach" id="activity_attach" class="txtbox width200" class="txtbox" /><br /><i>* must be image (jpg, jpeg, gif, png) and less than or equal 10Mb</i>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" class="paddingtop45">
                                        <input type="submit" name="btncreateact" id="btncreateact" value="Create" class="btn btncreateact" />
                                        <input type="hidden" name="activity_user" id="activity_user" value="<?php echo $profile_id; ?>" />
                                        <input type="hidden" name="pagenum" id="pagenum" value="<?php echo $_GET['page'] ? $_GET['page'] : 1; ?>" />
                                    </td>
                                </tr>
                                </form>
                            </table>
                        </div>
                        <!-- CREATE ACTIVITY - END -->
                        <!-- UPDATE ACTIVITY - BEGIN -->
                        <div id="actedit" class="fedit" style="display: none;">
                            <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                            <div id="actedit_title" class="robotobold cattext dbluetext marginbottom15">Update Activity</div>
                            <input type="hidden" id="json_data" name="json_data" />
                            <table class="tdataform2 rightmargin margintop15 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">
                                <form name="edit_act" id="edit_act" method="POST" action="?ignore-page-cache=true" enctype="multipart/form-data">

                                <tr>
                                    <td>Activity Title</td>
                                    <td>
                                        <input type="text" name="activity_title" id="uactivity_title" value="" class="txtbox width300" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Venue</td>
                                    <td>
                                        <input type="text" name="activity_venue" id="uactivity_venue" value="" class="txtbox width300" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td>
                                        <input type="text" name="activity_description" id="uactivity_description" value="" class="txtbox width350" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Type</td>
                                    <td>
                                        <select name="activity_type" id="uactivity_type" class="activity_type txtbox width300">
                                            <option value="1">Training</option>
                                            <option value="2">Project Visit</option>
                                            <option value="3">Wellness</option>
                                            <option value="4">Party</option>
                                            <option value="5">Fun Day</option>
                                            <option value="6">Other</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date</td>
                                    <td>
                                        <input type="text" name="activity_dates" id="uactivity_dates" class="txtbox checkindate width95" value="<?php echo date("Y-m-d"); ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Time</td>
                                    <td>
                                        <input type="text" name="activity_timein" id="uactivity_timein" class="txtbox timepick width95" value="8:00am" />&nbsp;<input type="text" name="activity_timeout" id="uactivity_timeout" class="txtbox timepick width95" value="6:00pm" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>
                                        <span class="uactatt07"><input id="uactivity_endregister" type="checkbox" name="activity_endregister" value="1" /> <label for="activity_endregister">Disable Registration</label></span>
                                        <span class="uactatt02"><input id="uactivity_guest" type="checkbox" name="activity_guest" value="1" /> <label for="activity_guest">Guest</label></span>
                                        <span class="uactatt03"><input id="uactivity_dependent" type="checkbox" name="activity_dependent" value="1" /> <label for="activity_dependent">Dependent</label></span>
                                        <span class="uactatt04"><input id="uactivity_cvehicle" type="checkbox" name="activity_cvehicle" value="1" /> <label for="activity_cvehicle">Company Vehicle</label></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>
                                        <span class="uactatt08"><input id="uactivity_backout" type="checkbox" name="activity_backout" value="1" /> <label for="activity_feedback">Disable Backout</label></span>
                                        <span class="uactatt05"><input id="uactivity_feedback" type="checkbox" name="activity_feedback" value="1" /> <label for="activity_feedback">Feedback</label></span>
                                        <span class="uactatt06"><input id="uactivity_offsite" type="checkbox" name="activity_offsite" value="1" /> <label for="activity_offsite">Offreg Only</label></span>
                                        <span class="uactatt01"><input id="uactivity_approve" type="checkbox" name="activity_approve" value="1" /> <label for="activity_approve">Need Approval</label></span>
                                    </td>
                                </tr>
                                <tr id="uacthours">
                                    <td>Hours</td>
                                    <td>
                                        <select name="activity_hours" id="uactivity_hours" class="txtbox width95">
                                            <?php
                                                $ah = 0;
                                                while ($ah <= 24) :
                                                    echo '<option value="'.number_format($ah, 2).'">'.number_format($ah, 1).'</option>';
                                                    $ah = $ah + 0.5;
                                                endwhile;
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Slot</td>
                                    <td>
                                        <select name="activity_slots" id="uactivity_slots" class="txtbox width95" value="<?php echo $_POST['activity_slots']; ?>">
                                            <?php for ($i=1; $i<=5000; $i++) : ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Image</td>
                                    <td>
                                        <input type="file" name="activity_attach" id="uactivity_attach" class="txtbox width200" class="txtbox" /><br /><i>* must be image (jpg, jpeg, gif, png) and less than or equal 10Mb</i>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2" align="center" class="paddingtop45">
                                        <input type="submit" name="btnupdateact" value="Update" class="btn btnupdateact" />
                                        <input type="submit" name="btnresendact" value="Send Activity to Employees via Email" class="btn btnresendact" />
                                        <input type="hidden" name="activity_filename" id="uactivity_filename" />
                                        <input type="hidden" name="activity_db" id="uactivity_db" />
                                        <input type="hidden" name="activity_user" id="uactivity_user" value="<?php echo $profile_id; ?>" />
                                        <input type="hidden" name="activity_id" id="uactivity_id" />
                                        <input type="hidden" name="pagenum" id="pagenum" value="<?php echo $_GET['page'] ? $_GET['page'] : 1; ?>" />
                                    </td>
                                </tr>
                                </form>
                            </table>
                        </div>
                        <!-- UPDATE ACTIVITY - END -->
                        <?php endif; ?>
                    </div>

                    <div id="mainsplashtext" class="mainsplashtext lefttalign">
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainactivity" class="mainbody lefttalign whitetext">
                                <b class="mediumtext lorangetext">ACTIVITIES</b><br><br>

                                <table class="width100per">
                                    <tr>
                                        <td><span class="fa fa-search"></span> Search by:
                                            <input type="text" id="searchactivity" name="searchactivity" value="<?php echo $_SESSION['searchactivity'] ? $_SESSION['searchactivity'] : ''; ?>" placeholder="activity title" class="smltxtbox searchactivity" />&nbsp;
                                            <input type="button" id="btnsearchactivity" name="btnsearchactivity" value="Search" class="smlbtn btnsearchactivity" />
                                            <input type="button" id="btnsearchallactivity" name="btnsearchallactivity" value="View All" class="btnsearchallactivity smlbtn<?php if (!$_SESSION['searchactivity']) : ?> invisible<?php endif; ?>" />
                                        </td>
                                        <td class="righttalign">
                                            <?php if ($profile_level == 7 || $profile_level == 10 || $profile_idnum = '2016-06-0457') : ?>
                                            <input type="button" id="btnaddactivity" name="btnaddactivity" value="Create Activity" class="btnaddactivity smlbtn" />&nbsp;
                                            <?php endif; ?>
                                            <?php if ($staff_count) : ?>
                                            <a href="<?php echo WEB; ?>/unapprove_register">
                                                <input type="button" id="btnuareg" name="btnuareg" value="Registrations for Approval" class="smlbtn btnred" />
                                            </a>&nbsp;
                                            <?php endif; ?>
                                            <a href="<?php echo WEB; ?>/registration">
                                                <input type="button" id="btnmyreg" name="btnmyreg" value="My Registration" class="smlbtn" />
                                            </a>
                                        </td>
                                    </tr>
                                </table>

                                <div id="activitydata">
                                <table border="0" cellspacing="0" class="tdata width100per margintop25">
                                    <?php if ($activity_data) : ?>
                                    <?php foreach ($activity_data as $key => $value) : ?>

                                    <?php
                                        $if_registered = $tblsql->chk_registered($value['activity_id'], $profile_idnum);

                                        $countreg = 0;
                                        $regdata = $tblsql->get_registrant(0, 0, 0, 0, $value['activity_id']);

                                        if ($value['activity_type'] == 3 || $value['activity_type'] == 6) :
                                            if ($value['activity_dependent'] == 1) :
                                                foreach ($regdata as $k => $v) :
                                                    $countreg = $countreg + $v['registry_dependent'];
                                                endforeach;
                                                $countreg = $countreg + count($regdata);
                                            else :
                                                $countreg = count($regdata);
                                            endif;
                                        elseif ($value['activity_type'] == 1) :
                                            if ($value['activity_guest'] == 1) :
                                                foreach ($regdata as $k => $v) :
                                                    $countreg = $countreg + $v['registry_guest'];
                                                endforeach;
                                                $countreg = $countreg + count($regdata);
                                            else :
                                                $countreg = count($regdata);
                                            endif;
                                        elseif ($value['activity_type'] == 5) :
                                            foreach ($regdata as $k => $v) :
                                                $countreg = $countreg + $v['registry_child'];
                                            endforeach;
                                        else :
                                            $countreg = count($regdata);
                                        endif;

                                        if ((strtotime(date("Y-m-d", $value['activity_datestart'])) <= date("U")) || $if_registered || $value['activity_endregister']) :
                                            $disable_reg = 1;
                                        else :
                                            $disable_reg = 0;
                                        endif;

                                    ?>
                                    <?php $slot_remain = $value['activity_slots'] - $countreg; ?>
                                    <tr class="trdata centertalign">
                                        <td width="30%"<?php if ($key == 0) : ?> class="topborder"<?php endif; ?>><span attribute="<?php echo $value['activity_id']; ?>" attribute2="<?php echo $value['activity_title']; ?>" class="btnviewactivity"><img src="<?php echo WEB; ?>/uploads/<?php echo $value['activity_ads'] ? 'ads' : 'activity'; ?>/<?php echo $value['activity_filename']; ?>" class="activity_img cursorpoint" /></span></td>
                                        <td width="70%" class="lefttalign<?php if ($key == 0) : ?> topborder<?php endif; ?>"><span class="btnviewactivity cursorpoint bold" attribute="<?php echo $value['activity_id']; ?>" attribute2="<?php echo $value['activity_title']; ?>"><?php echo $value['activity_title']; ?></span><?php echo $if_registered ? ' <span class="stamp spangreen">REGISTERED</span>' : ''; ?><br><?php echo date('F j, Y', $value['activity_datestart']); ?> | <?php echo date('g:ia', $value['activity_datestart']); ?> to <?php echo date('g:ia', $value['activity_dateend']); ?><br><?php echo $value['activity_venue']; ?>

                                        <?php if(!$disable_reg) : ?>
                                        <?php if ($value['activity_id'] != 218) : ?>
                                        <br /><br />Total Slots: <?php echo $value['activity_slots']; ?><br />
                                        Slots Remaining: <?php echo $slot_remain <= 0 ? 0 : $slot_remain; ?><br />
                                        <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if ($slot_remain > 0) : ?><?php echo $disable_reg ? '' : '<br><span class="btnregactivity cursorpoint" attribute="'.$value['activity_id'].'" attribute2="'.$value['activity_title'].'">Register</span>'; ?><?php endif; ?><?php if ($profile_level == 7 || $profile_level == 10 || $profile_idnum == '2016-06-0457') : ?><?php echo $disable_reg ? '<br>' : ' | '; ?><span onClick="location.href='<?php echo WEB; ?>/registrant?id=<?php echo $value['activity_id']; ?>'" class="cursorpoint">Registrants (<?php echo $countreg; ?>)</span> | <span class="btneditactivity cursorpoint" attribute="<?php echo $value['activity_id']; ?>">Edit</span> | <span class="btndelactivity cursorpoint" attribute="<?php echo $value['activity_id']; ?>">Delete</span><?php endif; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if ($pages) : ?>
                                    <tr>
                                        <td colspan="2" class="centertalign"><?php echo $pages; ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php else : ?>
                                    <tr>
                                        <td class="bold centertalign noborder"><br><br>You have no activity listed</td>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                                <input type="hidden" id="activitypage" name="activitypage" value="<?php echo $page; ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
					<script>
						$(document).ready(function(){
							$(".btnregsub").show();
							$(".btnreg2").show();
							$(".btnregsub").on("click", function(){
								$(".btnregsub").hide();
								$(".btnreg2").hide();
							});
						});

					</script>

    <?php include(TEMP."/footer.php"); ?>
