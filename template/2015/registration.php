	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->

                    <div id="floatdiv" class="floatdiv invisible">
                        <!-- SEND FEEDBACK - BEGIN --> 
                        <div id="fback" class="fback" style="display: none">
                            <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                            <div id="fback_title" class="robotobold cattext dbluetext"></div>
                            <div class="viewscroll2">
                            <table class="tdataform2 rightmargin margintop10 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">
                                <form name="rate_act" id="rate_act" action="?ignore-page-cache=true" method="POST" enctype="multipart/form-data">
                                <tr>
                                    <td class="inlineblk">
                                        <b class="inlineblk">Rating:</b>&nbsp;
                                        <div id="rating" class="rating inlineblk"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Comments/Suggestions:</b><br>
                                        <input type="hidden" id="fback_rate" name="fback_rate" value="0" />
                                        <textarea rows="5" cols="60" id="fback_comment" name="fback_comment" class="txtarea smalltext"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <input type="hidden" id="fback_empid" name="fback_empid" value="<?php echo $profile_id; ?>" />
                                        <input type="hidden" id="fback_activityid" name="fback_activityid" value="" />
                                        <input type="hidden" id="fback_registryid" name="fback_registryid" value="" />
                                        <input type="submit" id="btnfback" name="btnfback" value="Send My Feedback" class="btn btnfback" />
                                    </td>
                                </tr>
                                </form>                          
                            </table>
                            </div>
                        </div>
                        <!-- SEND FEEDBACK - END -->                         
                    </div>
                    
                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainactivity" class="mainbody lefttalign whitetext">  
                                <b class="mediumtext lorangetext">MY REGISTRATION</b><br><br> 
                                
                                <table class="width100per">
                                    <tr>
                                        <td class="righttalign">
                                            <a href="<?php echo WEB; ?>/activity">
                                                <input type="button" id="btnact" name="btnact" value="List of Activities" class="smlbtn" />
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                                
                                <div id="registration_table" class="dirheight">
                                <table class="tdata" width="100%">
                                    <tr>
                                        <th width="35%">Event Title</th>
                                        <th width="10%">Will go directly</th>
                                        <th width="20%">Date Registered</th>
                                        <th width="15%">Status</th>
                                        <th width="25%" colspan="2">Manage</th>
                                    </tr>

                                    <?php if ($my_registration) : ?>
                                    <?php foreach ($my_registration as $key => $value) : ?>
                                    <?php 
                                        $checkfback = $tblsql->get_feedback($profile_id, $value['activity_id'], 1); 
                                        $fb_info = $checkfback ? $tblsql->get_feedback(0, 0, 0, $value['registry_id']) : NULL;
                                        $nobackout = ($value['activity_datestart'] - 172800) <= date('U') ? 1 : 0;
                                        $actfeedback = $value['activity_datestart'] >= date('U') ? 1 : 0;
                                    ?>
                                    <tr>
                                        <td><a class="whitetext" attribute="<?php echo $value['registry_id']; ?>"><b><?php echo $value['activity_title']; ?></b><?php if ($value['activity_id'] == 150) : ?> (AUTO-REGISTERED)<?php endif; ?></a><?php if ($value['registry_status'] == 2) : ?><br>Confirmation Code: <?php echo $value['activity_id'].'-'.substr($profile_idnum, -4).$value['registry_date']; ?><?php endif; ?><?php echo trim($value['registry_details']) ? '<br><b>Attendees:</b> '.$value['registry_details'] : ''; ?><?php echo trim($value['registry_vehicle']) ? '<br><b>Bus No.:</b> '.$value['registry_vehicle'] : ''; ?>
                                            <!-- kevs <?php var_dump($value['activity_datestart']);  ?> -->
                                            <?php if (!$checkfback && $actfeedback) : ?><br><a class="btnsendfback cursorpoint lgraytext" attribute="<?php echo $value['registry_id']; ?>">Send a feedback</a><?php else : ?><br><a class="tooltip cursorpoint whitetext" title="<?php echo 'Comment: '.$fb_info[0]['fback_comment']; ?>"><?php for($star=1; $star<=$fb_info[0]['fback_rate']; $star++) : ?><i class="fa fa-star lorangetext"></i><?php endfor; ?></a><?php endif; ?></td>
                                        <td class="centertalign"><?php echo $value['registry_godirectly'] ? '<i class="fa fa-check greentext"></i>' : '<i class="fa fa-times redtext"></i>'; ?></td>
                                        <td class="centertalign"><?php echo date("M j, Y", $value['registry_date']); ?><br><?php echo date("g:ia", $value['registry_date']); ?></td>
                                        <td class="centertalign"><?php if ($value['registry_status'] == 2) : echo '<span class="whitetext">Approved</span>'; elseif ($value['registry_status'] == 1) : echo '<span class="whitetext">For Approval</span>'; else : echo '<span class="whitetext">Attended</span>'; endif; ?></td>
                                        <td class="centertalign"><?php if (in_array($value['activity_id'], ['2660', '2661'])) : ?><a href="<?php echo WEB; ?>/qrcode/<?php echo md5($value['registry_id']); ?>"><button class="smlbtn">QR Code</button></a><?php endif; ?><?php if (!$nobackout && !$value['activity_backout'] && $value['registry_status'] != 4) : ?> <a class="btndelreg cursorpoint" attribute="<?php echo $value['registry_id']; ?>"><button class="smlbtn btnred">Backout</button></a><?php endif; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if ($pages) : ?>
                                    <tr>
                                        <td colspan="8" align="center" class="whitebg"><?php echo $pages; ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php else : ?>
                                    <tr>
                                        <td colspan="8" align="center">No activity registration found</td>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>