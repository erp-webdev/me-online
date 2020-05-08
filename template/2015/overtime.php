	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
                    <?php

                        if ($holirest == 1) :
                            //echo '<script type="text/javascript">alert("This is not a regular day");</script>';
                        endif;
                
                        $shiftsched2 = $mainsql->get_schedshiftdtr($profile_idnum, date("Y-m-d", strtotime($odate)));        
                        $sft2 = $shiftsched2[0]['ShiftID'];

                        $dtr_data = $mainsql->get_dtr_bydate($profile_idnum, date("m/d/Y", strtotime($odate)));                  

                        $numdays = intval(date("N", $odate));

                        $otimein = $shiftsched2[0]['CreditTimeIN'];
                        $otimeout = $shiftsched2[0]['CreditTimeOut'];
                        $dtimein = $dtr_data[0]['TimeIN'];
                        $dtimeout = $dtr_data[0]['TimeOut'];
                
                        $chkdtrin = $dtimein ? date('g:ia', strtotime($dtimein)) : 0;
                        $chkdtrout = $dtimeout ? date('g:ia', strtotime($dtimeout)) : 0;   

                        $limitin1 = strtotime($otimeout);
                        $limitin2 = strtotime($otimeout);
                        $limitout1 = strtotime($otimeout);
                        $limitout2 = strtotime($dtimeout ? $dtimeout : $otimeout);
                    ?>

                    <script type="text/javascript">
                        $(function() {	
                            $('.datetimepickot1').datetimepicker('destroy');
                            $('.datetimepickot2').datetimepicker('destroy');
                            $('.datetimepickot1').datetimepicker({
                                dateFormat: 'yy-mm-dd',
                                timeFormat: "hh:mmtt",
                                minDate: '<?php echo date("Y-m-d", strtotime($odate)); ?>',
                                maxDate: '<?php echo date("Y-m-d", strtotime($odate)); ?>'
                                //minTime: '<?php echo date("H:i:s", $limitin1); ?>',
                                //maxTime: '<?php echo date("H:i:s", $limitin2); ?>'    
                            });

                            $('.datetimepickot2').datetimepicker({
                                dateFormat: 'yy-mm-dd',
                                timeFormat: "hh:mmtt",
                                minDate: '<?php echo date("Y-m-d", strtotime($odate)); ?>',
                                maxDate: '<?php echo date("Y-m-d", strtotime($odate) + 86400); ?>'
                                <?php if ($chkdtrout) : ?>,
                                minTime: '<?php echo date("H:i:s", $limitout1); ?>',
                                maxTime: '<?php echo date("H:i:s", $limitout2); ?>'   
                                <?php endif; ?>   
                            });
                        });
                    </script>
                    
                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainot" class="mainbody lefttalign whitetext">  
                                <b class="mediumtext lorangetext">OVERTIME REQUEST</b><br><br>
                                <b>MAIN INFORMATION</b><br><br>
                                <div class="column2">
                                    <b><?php echo ucfirst($profile_nadd); ?> ID: </b><?php echo $profile_idnum; ?><br>
                                    <b>Name: </b><?php echo $profile_full; ?><br>
                                    <b>Position: </b><?php echo $profile_pos; ?><br>
                                    <b>Status: </b>Open<br>
                                    <b>Department: </b><?php echo $profile_dept; ?><br>
                                </div><br>                                
                                
                                <div id="alert"></div>
                                <form id="frmapplyot" action="?ignore-page-cache=true" method="post" enctype="multipart/form-data">
                                    <div id="tabs">
                                        <ul>
                                            <li><a href="#ldetails">Details</a></li>
                                            <li><a href="#lattach">Attachments</a></li>
                                            <li><a href="#lapprover">Approvers</a></li>
                                        </ul>

                                        <div id="ldetails">
                                            <table class="tdataform" border="0" cellspacing="0">
                                                <tr>
                                                    <td width="15%"><b>Type: </b></td>
                                                    <td width="85%" colspan="3">
                                                        <select id="ot_type" name="ot_type" class="txtbox width300">
                                                            <option value="Reg OT PM">Reg OT PM (OT after Shift)</option>
                                                            <!--option value="Reg OT AM">Reg OT AM (OT before Shift)</option>
                                                            <option value="Regular Day">Regular Day (OT AM and OT PM)</option-->
                                                            <option value="Rest Day">Rest Day</option>
                                                            <option value="Holiday">Holiday</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="15%"><b>DTR Date: </b></td>
                                                    <td width="35%"><input id="ot_date" type="text" name="ot_date" value="<?php echo date("Y-m-d"); ?>" class="txtbox datepick5 width95per" readonly /></td>
                                                </tr>
                                                <tr>
                                                    <td width="15%"><b>Time Shift: </b></td>
                                                    <td width="85%" colspan="3">
                                                        <span id="timeshift"><?php echo $otshift; ?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="15%"><b>DTR: </b></td>
                                                    <td width="85%" colspan="3">
                                                        <span id="dtrshift"><?php echo $otdtr; ?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="15%"><b>OT From: </b></td>
                                                    <td width="35%"><input id="ot_from" type="text" name="ot_from" value="<?php echo $otin; ?>" class="txtbox width95per datetimepickot1" readonly /></td>
                                                    <td width="15%"><b>OT To: </b></td>
                                                    <td width="35%"><input id="ot_to" type="text" name="ot_to" value="<?php echo $otout; ?>" class="txtbox datetimepickot2 width95per" readonly /></td>
                                                </tr>
                                                <tr>
                                                    <td width="15%"><b>Hours: </b></td>
                                                    <td width="85%" colspan="3">
                                                        
                                                        <span id="othours"><?php echo $othours; ?></span><input id="txtothours" type="hidden" name="txtothours" value="<?php echo $othours; ?>" />
                                                        <script type="text/javascript">// slider
                                                            $("#txtothours").spinner({
                                                              step: 0.5,
                                                              spin: function( event, ui ) {
                                                                if ( ui.value > <?php echo $hours; ?> ) {
                                                                  $(this).spinner( "value", <?php echo $hours; ?> );
                                                                  return false;
                                                                } else if ( ui.value < 0 ) {
                                                                  $(this).spinner( "value", 0 );
                                                                  return false;
                                                                }   
                                                              }
                                                            });
                                                        </script>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Reason: </b></td>
                                                    <td colspan="3">
                                                        <textarea id="ot_reason" name="ot_reason" rows="5" class="txtarea width95per"></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <i>* If there's something wrong with date or time represent within this application, please check your DTR first</i>
                                                    </td>
                                                </tr>
                                            </table>  
                                        <?php
                                            /*if ($chkdtrin == '0' || $chkdtrout == '0') :
                                                echo "<script type='text/javascript'>alert('Either or both DTR in or out is NOT SET so you can\'t apply an overtime, pls apply for a manual DTR instead, thank you.');
                                                $(function() { $('#btnotapply').addClass('invisible'); });</script>";            
                                            else :
                                                echo "<script type='text/javascript'>$(function() { $('#btnotapply').removeClass('invisible'); });</script>";
                                            endif;*/
                                        ?>  
                                        </div>
                                        <div id="lattach">
                                            <input type="file" name="attachment1" class="whitetext" /><br>
                                            <input type="file" name="attachment2" class="whitetext" /><br>
                                            <input type="file" name="attachment3" class="whitetext" /><br>
                                            <input type="file" name="attachment4" class="whitetext" /><br>
                                            <input type="file" name="attachment5" class="whitetext" />
                                            <br><br>
                                            <i>* it must be PDF or image (JPG or GIF) and not more than 200Kb each</i>
                                        </div>
                                        <div id="lapprover">
                                            <?php if ($ot_app) : ?>
                                            <?php foreach($ot_app as $key => $value) : ?>
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
                                        <input id="invalid" type="hidden" name="invalid" value="0" />
                                        <input type="hidden" name="empid" value="<?php echo $profile_idnum; ?>" />
                                        <input type="hidden" name="reqnbr" value="<?php echo "OT-".$finsec; ?>" />
                                        <input type="hidden" name="user" value="<?php echo $profile_idnum; ?>" />
                                        <input id="btnotapply" type="submit" name="btnotapply" value="Submit" class="btn margintop10" />
                                        <a href="<?php echo WEB; ?>/pending"><input type="button" name="btncancel" value="Cancel" class="redbtn margintop10" /></a>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>