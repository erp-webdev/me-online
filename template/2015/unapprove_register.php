	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->

                    <div id="floatdiv" class="floatdiv invisible">    
                    </div>
                    
                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainactivity" class="mainbody lefttalign whitetext">  
                                <b class="mediumtext lorangetext">FOR APPROVAL REGISTRATION</b><br><br> 
                                <table class="width100per">
                                    <tr>
                                        <td class="righttalign">
                                            <a href="<?php echo WEB; ?>/activity">
                                                <input type="button" id="btnact" name="btnact" value="List of Activities" class="smlbtn" />
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                                
                                <div id="uregistration_table">
                                <table class="tdata" width="100%">
                                    <tr>
                                        <th width="50%">Registrants</th>
                                        <th width="10%">Will go directly</th>
                                        <th width="20%">Date Registered</th>
                                        <th width="25%">Status</th>
                                    </tr>

                                    <?php if ($staff) : ?>
                                    <?php foreach ($staff as $key => $value) : ?>
                                    <?php $act_info = $tblsql->get_activities($value['registry_activityid']); ?>
                                    <tr>
                                        <td><a class="bold whitetext"><?php echo $value['FName'].' '.$value['LName']; ?></a><br>will attend at <?php echo $act_info[0]['activity_title'] ?><br>From <?php echo date('F j, Y g:ia', $act_info[0]['activity_datestart']); ?> to <?php echo date('g:ia', $act_info[0]['activity_dateend']); ?></td>
                                        <td class="centertalign"><?php echo $value['registry_godirectly'] ? '<i class="fa fa-check greentext"></i>' : '<i class="fa fa-times redtext"></i>'; ?></td>
                                        <td class="centertalign"><?php echo date("M j, Y", $value['registry_date']); ?><br><?php echo date("g:ia", $value['registry_date']); ?></td>
                                        <td class="centertalign"><span class="btnregapprove greentext cursorpoint" attribute="<?php echo $value['registry_id']; ?>">Click to Approve</span></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if ($pages) : ?>
                                    <tr>
                                        <td colspan="4" align="center"><?php echo $pages; ?></td>
                                    </tr>
                                    <?php endif; ?>

                                    <?php else : ?>
                                    <tr>
                                        <td colspan="4" align="center">No activity registrants found</td>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>