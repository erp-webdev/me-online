	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->

                    <div id="floatdiv" class="floatdiv invisible">    
                    </div>
                    
                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainactivity" class="mainbody lefttalign whitetext">  
                                <b class="mediumtext lorangetext"><?php echo strtoupper($activity_title[0]['activity_title']); ?>'S REGISTRANTS</b><br><br> 
                                
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
                                        <th width="40%">Registrants</th>
                                        <th width="10%">Will go directly</th>
                                        <th width="15%">Date Registered</th>
                                        <th width="15%">Status</th>
                                        <th width="25%">Rating</th>
                                    </tr>

                                    <?php if ($registrants) : ?>
                                    <?php 
                                        $ratescore = 0; 
                                        $ratee = 0; 
                                    ?>
                                    <?php foreach ($registrants as $key => $value) : ?>
                                    <tr>
                                        <td><a class="bold whitetext" attribute="<?php echo $value['registry_id']; ?>"><?php echo $value['FName'].' '.$value['LName']; ?></a><?php if ($value['registry_status'] >= 2) : ?><br><b>Confirmation Code:</b> <?php echo $id.'-'.substr($value['EmpID'], -4).$value['registry_date']; ?><?php endif; ?><?php echo trim($value['registry_details']) ? '<br><b>Attendees:</b> '.$value['registry_details'] : ''; ?><?php if ($value['EmailAdd']) : ?><br><a href="mailto: <?php echo $value['EmailAdd']; ?>" class="greentext">Email this registrant</a><?php endif; ?></td>
                                        <td class="centertalign"><?php echo $value['registry_godirectly'] ? '<i class="fa fa-check greentext"></i>' : '<i class="fa fa-times redtext"></i>'; ?></td>
                                        <td class="centertalign"><?php echo date("M j, Y", $value['registry_date']); ?><br><?php echo date("g:ia", $value['registry_date']); ?></td>
                                        <td class="centertalign"><?php if ($value['registry_status'] == 2) : echo 'Approved'; elseif ($value['registry_status'] == 4) : echo '<span class="greentext">Attended</span>'; else : echo '<span class="redtext">For Approval</span>'; endif; ?></td>
                                        <td class="centertalign">
                                            <?php $feedback = $tblsql->get_feedback(0, $value['registry_activityid'], 0, $value['registry_id']); ?>
                                            <?php if ($feedback) : ?>
                                                <?php echo '<a title="'.$feedback[0]['fback_comment'].' - '.date("F j, Y", $feedback[0]['fback_date']).'" class="cursorpoint tooltip">'; ?>
                                                <?php for($i[$value['emp_id']]==0; $i[$value['emp_id']]<$feedback[0]['fback_rate']; $i[$value['emp_id']]++) : ?>
                                                    <?php echo '<i class="fa fa-star lorangetext"></i>'; ?>
                                                <?php endfor; ?>
                                                <?php echo '</a>'; ?>
                                                <?php 
                                                    $ratescore = $ratescore + $feedback[0]['fback_rate']; 
                                                    $ratee++; 
                                                ?>
                                            <?php else : ?>
                                                <?php //echo 'N/A'; ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if ($pages) : ?>
                                    <tr>
                                        <td colspan="5" align="center" class="whitebg"><?php echo $pages; ?></td>
                                    </tr>
                                    <?php endif; ?>

                                    <tr>
                                        <td colspan="4" class="righttalign"><b>Average Rating</b></td>
                                        <td class="centertalign">
                                            <?php $average_rate = round($ratescore / $ratee, 0); ?>
                                            <?php if ($average_rate) : ?>
                                            <?php for($y==0; $y<$average_rate; $y++) : ?>
                                                <?php echo '<i class="fa fa-star lorangetext"></i>'; ?>
                                            <?php endfor; ?>
                                            <?php else : ?>
                                                <?php echo '<i>no rate has been made</i>'; ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <?php else : ?>
                                    <tr>
                                        <td colspan="7" align="center">No activity registrants found</td>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>