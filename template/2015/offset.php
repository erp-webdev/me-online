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
                            <div id="mainlu" class="mainbody lefttalign whitetext">  
                                <b class="mediumtext lorangetext">OFFSET REQUEST</b><br><br>
                                <b>MAIN INFORMATION</b><br><br>
                                <div class="column2">
                                    <b><?php echo ucfirst($profile_nadd); ?> ID: </b><?php echo $profile_idnum; ?><br>
                                    <b>Name: </b><?php echo $profile_full; ?><br>
                                    <b>Position: </b><?php echo $profile_pos; ?><br>
                                    <b>Status: </b>Open<br>
                                    <b>Department: </b><?php echo $profile_dept; ?><br>
                                </div><br>                                
                                
                                <div id="alert"></div>
                                <form id="frmapplylu" action="?ignore-page-cache=true" method="post" enctype="multipart/form-data">
                                    <div id="tabs">
                                        <ul>
                                            <li><a href="#ldetails">Details</a></li>
                                            <li><a href="#lattach">Attachments</a></li>
                                            <li><a href="#lapprover">Approvers</a></li>
                                        </ul>

                                        <div id="ldetails">
                                            <table class="tdataform" border="0" cellspacing="0">
                                                <tr>
                                                    <td width="15%"><b>DTR Date: </b></td>
                                                    <td width="35%"><input id="lu_date" type="text" name="lu_date" value="<?php echo $odate; ?>" class="txtbox datepick5 width50per" readonly />&nbsp;<span id="offset_loading"></span></td>                                                    
                                                </tr>
                                                <tr>
                                                    <td width="15%"><b>Type: </b></td>
                                                    <td width="85%" colspan="3">
                                                        <select id="lu_type" name="lu_type" class="txtbox width50per">
                                                            <option value="1">Late</option>
                                                            <option value="2">Undertime</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="15%"><b>Overtime Date: </b></td>
                                                    <td width="85%" colspan="3">
                                                        <input id="lu_offdate" type="text" name="lu_offdate" value="<?php echo $ydate; ?>" class="txtbox datepick5 width50per" readonly />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="15%"><b>Time Shift: </b></td>
                                                    <td width="85%" colspan="3">
                                                        <span id="timeshift"><?php echo $lushift; ?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="15%"><b>DTR: </b></td>
                                                    <td width="85%" colspan="3">
                                                        <span id="dtrshift"><?php echo $ludtr; ?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="15%"><b>Overtime Hours: </b></td>
                                                    <td width="85%" colspan="3">
                                                        <span id="ovhours"><?php echo number_format($ovhours, 2); ?></span><input id="txtovhours" type="hidden" name="txtovhours" value="<?php echo number_format($ovhours, 2); ?>" /><span id="offset_noot" class="orangetext"></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="15%"><b id="lutexttype">Late Hours: </b></td>
                                                    <td width="85%" colspan="3">                                                        
                                                        <span id="luhours"><?php echo number_format($luhours, 2); ?></span><input id="txtluhours" type="hidden" name="txtluhours" value="<?php echo number_format($luhours, 2); ?>" />
                                                    </td>
                                                </tr>
                                            </table>  
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
                                            <?php if ($lu_app) : ?>
                                            <?php foreach($lu_app as $key => $value) : ?>
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
                                        <input type="hidden" name="reqnbr" value="<?php echo "LU-".$finsec; ?>" />
                                        <input type="hidden" name="user" value="<?php echo $profile_idnum; ?>" />
                                        <input id="btnluapply" type="submit" name="btnluapply" value="Submit" class="btn invisible margintop10" />
                                        <a href="<?php echo WEB; ?>/notification"><input type="button" name="btncancel" value="Cancel" class="redbtn margintop10" /></a>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>