        <!--<?php // if($rstat1 == 2) { ?>pow<?php// } ?>-->
        <?php if (count($evaluateRatee) > 0) { ?>
        <b class="mediumtext lorangetext"><a href="<?php echo WEB; ?>/paf?groupid=<?php echo $groupid; if(isset($_GET['sub'])) echo '&sub=' . $_GET['sub']; ?>&ref=emp<?php echo $_GET['appid']; ?>"><i class="mediumtext fa fa-arrow-left" style="color:#fff;opacity:.8;"></i></a> Performance Appraisal Form - Supervisor/Rater</b><br><br>
        <div>

        <form id="frm_paf" method="post" <?php //action="?ignore-page-cache=true" ?> enctype="multipart/form-data" >
            <fieldset>
            <?php foreach($evaluateRatee as $row) { ?>

            <?php if($r1 == $r2) { $max1i = 1; ?><input type="hidden" name="final" value="Completed"><?php } else { $max1i = 2; ?><input type="hidden" name="final" value="Incomplete"><?php } ?>


            <input type="hidden" value="<?php echo $row['appid']; ?>" name="appid" >
            <input type="hidden" value="1" name="sub">
            <input type="hidden" value="<?php echo $row['rstat1']; ?>" name="checkifsave">
            <input type="hidden" value="<?php echo $row['rfname']; ?>"  name="rname">
            <input type="hidden" value="<?php echo $row['readd']; ?>"  name="readd">
            <input type="hidden" value="<?php echo $row['r1fname']; ?>"  name="r1name">
            <input type="hidden" value="<?php echo $row['r1eadd']; ?>" name="r1eadd">
            <input type="hidden" value="<?php echo $row['r2fname']; ?>"  name="r2name">
            <input type="hidden" value="<?php echo $row['r2eadd']; ?>" name="r2eadd">
            <input type="hidden" value="<?php echo $row['r3fname']; ?>"  name="r3name">
            <input type="hidden" value="<?php echo $row['r3eadd']; ?>" name="r3eadd">
            <input type="hidden" value="<?php echo $row['r4fname']; ?>"  name="r4name">
            <input type="hidden" value="<?php echo $row['r4eadd']; ?>" name="r4eadd">

            <hr style="width:99%;"></hr>
            <table style="width:99%;">
                <thead>
                    <tr>
                        <th colspan="2" style="font-weight:italic;">(For <?php echo $row['randesc']; ?> Position) <span style="font-weight:normal;">*Confidential</span></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><b class="smallesttext lwhitetext">Employee Name:</b> <span style="font-weight:normal;"><?php echo ucwords(strtolower($row['rfname'].' '.$row['rlname'])); ?></span></td>
                        <td><b class="smallesttext lwhitetext">Department:</b> <span style="font-weight:normal;"><?php echo ucwords(strtolower($row['depdesc'])); ?></span></td>
                    </tr>
                    <tr>
                        <td><b class="smallesttext lwhitetext">Designation:</b> <span style="font-weight:normal;"><?php if($row['posdesc'] != NULL) { echo $row['posdesc']; } else { echo 'No Designated Position'; } ?></span></td>
                        <td><b class="smallesttext lwhitetext">Date Hired:</b> <span style="font-weight:normal;"><?php echo date('m-d-Y', strtotime($row['hdate'])); ?></span></td>
                    </tr>
                    <tr>
                    <td><b class="smallesttext lwhitetext">Period:</b>


                        <?php if( strpos(strtolower($row['Title']), 'regularization') !== false ) : ?>

                        <span style="font-weight:normal;">
                            From | <u><?php echo date('m-d-Y', strtotime($row['hdate'])); // echo date('Y-m-d', strtotime($row['dtfrom'])); ?></u>
                            To | <u><?php echo date('m-d-Y', strtotime($row['PermanencyDate']));// echo date ('Y-m-d', strtotime($row['dtto'])); ?></u>
                        </span>

                        <?php else: ?>

                        <span style="font-weight:normal;">
                            From | <u><?php echo date('m-d-Y', strtotime($row['perfrom'])); // echo date('Y-m-d', strtotime($row['dtfrom'])); ?></u>
                            To | <u><?php echo date('m-d-Y', strtotime($row['perto']));// echo date ('Y-m-d', strtotime($row['dtto'])); ?></u>
                        </span>

                        <?php endif; ?>

                    </td>


                        <td><b class="smallesttext lwhitetext">Date Appraisal:</b> <span style="font-weight:normal;"><?php echo date('m-d-Y', strtotime($row['appdt'])); ?></span></td>
                    </tr>
                </tbody>
            </table>
            <hr style="width:99%;"></hr>
            <?php } ?>
            
            <div  class="print" style="overflow-x:none;overflow-y:scroll;max-height:400px;padding-bottom:5px;">
            <p><i>This Performance Appraisal Form aims to provide a formal, recorded, regular review of an individual's performance and competencies. It is to be used for annual evaluations, and at other times during the year when formal feedback is needed.</i></p>
            <p><i>This is a three (3) part Appraisal Form whice are as follows:</i></p>
            <!-- Part 1 -->
            <p>
                <b class="smallesttext lwhitetext">Part I - Staff Member's Competencies Assessment</b>
                <br />
                These include knowledge, skills and abilities. Rate each factor based on performance during the period identified above.
            </p>
            <!-- Part 2 -->
            <p>
                <b class="smallesttext lwhitetext">Part II - Goals from previous year or previous evaluation period</b>
                <br />
                Rate employee's performance on each goal established at the beginning of the period.
            </p>
            <!-- Part 3 -->
            <p>
                <b class="smallesttext lwhitetext">Part III - Goals for the coming year or evaluation period</b>
                <br />
                Input the agreed performance goals for the next period to be evaluated.
            </p>
            <!-- Part 4 -->
            <!-- <p>
                <b class="smallesttext lwhitetext">Part IV - Individual Development Plan</b>
                <br />
                Action plan on how to close the competency gap/s improve future employee performance.
            </p>
-->
        <?php if(count($checkRank) > 0) { ?>
            <br />
            <!-- Part I - Staff Member's Competencies Assessment -->
            <p>
                <b class="smalltext lwhitetext">Part I - Staff Member's Competencies Assessment</b><br />
            </p>

            <!-- Rating Guide -->
            <div style="width:98%;border: 2px solid #fff;padding:2px;margin-bottom:15px;">
                <p><b>Rating Scale:</b></p>
                <p>Use the following descriptions to rate the staff member's performance for each of the required competencies.</p>
                <table style="width:100%;">
                    <thead>
                        <tr>
                            <th>Core Competencies</th>
                            <th style="text-align:center;"></th>
                            <th>Job-Specific Competencies</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>5 - <b>E</b>xceptional</td>
                            <td style="text-align:center;"></td>
                            <td>5 - <b>E</b>xpert / <b>C</b>onsultant</td>
                        </tr>
                        <tr>
                            <td>4 - <b>E</b>xceeds <b>E</b>xpectations</td>
                            <td style="text-align:center;"></td>
                            <td>4 - <b>C</b>an <b>W</b>ork <b>A</b>nd <b>T</b>each</td>
                        </tr>
                        <tr>
                            <td>3 - <b>M</b>eets <b>E</b>xpectations</td>
                            <td style="text-align:center;"></td>
                            <td>3 - <b>C</b>an <b>W<b/>ork <b>W</b>ithout <b>S</b>upervision</td>
                        </tr>
                        <tr>
                            <td>2 - <b>N</b>eeds <b>I<b/>mprovement</td>
                            <td style="text-align:center;"></td>
                            <td>2 - <b>C</b>an <b>W<b/>ork <b>W</b>ith <b>M</b>uch <b>S</b>upervision</td>
                        </tr>
                        <tr>
                            <td>1 - <b>N</b>o <b>E</b>vidence <b>O</b>f <b>S</b>kill</td>
                            <td style="text-align:center;"></td>
                            <td>1 - <b>N</b>o <b>K</b>nowledge</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- End of Rating Guide -->

        <?php if($checkifsave == 2) { ?>

            <table id="comass" border="0" cellspacing="0" class="tdata" style="width:99%;">
                <thead>
                    <tr>
                        <th></th>
                        <th width="30%;">Goals</th>
                        <th width="15%;">Required Proficiency</th>
                        <th width="15%;">Actual Proficiency</th>
                        <th width="15%;">Gaps</th>
                        <th width="30%;">Training/Remarks</th>
                    </tr>
                </thead>

                <?php $countap = 1; ?>
                <?php foreach ($checkEvalCA as $row) { ?>

                    <?php $grade0 += $row['ActProficiency']; ?>
                    <?php if($type != $row['Type']){ ?>
                            <?php if($row['Type'] == 'CORE'){ ?>
                            <tr>
                                <th colspan="6"><u>Core</u></th>
                            </tr>
                            <?php } else { ?>
                            <tr>
                                <th colspan="6"><u>Job-Specific</u></th>
                            </tr>
                            <?php } ?>
                            <?php $type = $row['Type']; ?>
                    <?php } ?>
                <tr>
                    <td><?php echo $countap++.'.'; ?></td>
                    <td><?php echo ucwords(strtolower(strtoupper($row['Competency']))); ?></td>
                    <td style="text-align:center;width:25px;">
                        <input type="hidden" name="caRp[]" class="reqp<?php echo $row['id']; ?> boxRem" value="<?php echo $row['ReqProficiency']; ?>">
                        <?php echo $RP = $row['ReqProficiency']; ?>
                    </td>
                    <td style="text-align:center;width:25px;">
                        <!-- create select input if not yet approved by the division head -->
                        <input type="hidden" name="caid[]" value="<?php echo $row['id']; ?>">
                        <select class="form1" name="caAp[]" class="width25 smltxtbox actp<?php echo $row['id']; ?> checker" onChange="totalp1()" >
                            <option <?php if ($row['ActProficiency'] == NULL) { ?>selected="selected"<?php } ?> value="0">0</option>
                            <option <?php if ($row['ActProficiency'] == '5') { ?>selected="selected"<?php } ?>value="5"><?php if ($row['ActProficiency'] == '5') { echo $row['ActProficiency']; } else { ?>5<?php } ?></option>
                            <option <?php if ($row['ActProficiency'] == '4') { ?>selected="selected"<?php } ?>value="4"><?php if ($row['ActProficiency'] == '4') { echo $row['ActProficiency']; } else { ?>4<?php } ?></option>
                            <option <?php if ($row['ActProficiency'] == '3') { ?>selected="selected"<?php } ?>value="3"><?php if ($row['ActProficiency'] == '3') { echo $row['ActProficiency']; } else { ?>3<?php } ?></option>
                            <option <?php if ($row['ActProficiency'] == '2') { ?>selected="selected"<?php } ?>value="2"><?php if ($row['ActProficiency'] == '2') { echo $row['ActProficiency']; } else { ?>2<?php } ?></option>
                            <option <?php if ($row['ActProficiency'] == '1') { ?>selected="selected"<?php } ?>value="1"><?php if ($row['ActProficiency'] == '1') { echo $row['ActProficiency']; } else { ?>1<?php } ?></option>
                        </select>
                    </td>
                    <td style="text-align:center;width:25px;">
                        <input type="hidden" name="caGaps[]" value="<?php echo $row['Gaps']; ?>" class="width25 smltxtbox result<?php echo $row['id']; ?>">
                        <div class="divResult<?php echo $row['id']; ?>">
                            <?php if($row['Gaps'] < 0) { ?>
                            <?php echo $GAPS = $row['Gaps']; ?>
                            <?php } ?>
                        </div>
                    </td>

                    <td style="text-align:left;">

                        <input type="hidden" value="<?php echo $row['Type']; ?>" name="caType[]">
                       <?php if($rankid == 'RFP' && $row['Type'] == 'CORE') { ?>
                            <select class="width25 smltxtbox caTraining<?php echo $row['id']; ?>" name="caRemarkst[]" style="display:none;width:96.5%;" />
                            <?php if($row['Code'] == 'RFQW' || $row['Code'] == 'RFIR' || $row['Code'] == 'RFINT' || $row['Code'] == 'RFI' || $row['Code'] == 'RFF' || $row['Code'] == 'RFD' || $row['Code'] == 'RFATT'){ ?>
                                <option>Winning Atitude Seminar</option>
                                <option>Motivational Seminar</option>
                                <option>Professional Etiquettes/Professionalism</option>
                                <option>Others</option>
                            <?php } elseif($row['Code'] == 'RFAP') { ?>
                                <option>Time Management Seminar</option>
                                <option>Others</option>
                            <?php } elseif($row['Code'] == 'RFCO') { ?>
                                <option>Customer Service</option>
                                <option>24 7 Secrets of S.E.R.V.I.C.E.</option>
                                <option>Others</option>
                            <?php } elseif ($row['Code'] == 'RFC') { ?>
                                <option>English Grammar</option>
                                <option>Oral Communication</option>
                                <option>Written Communication</option>
                                <option>Assertive Communication</option>
                                <option>Presentation Skills</option>
                                <option>Others</option>
                            <?php } else { ?>
                                <option value="">Select</option>
                                <option>Others</option>
                            <?php } ?>
                            </select>
                            <input type="text" style="width:93.1%;" placeholder="Add your remarks" name="caRemarksr[]" class="width25 smltxtbox caRemarks<?php echo $row['id']; ?>" value="<?php echo $row['Remarks']; ?>" />
                        <?php } elseif($rankid == 'SCP' && $row['Type'] == 'CORE'){ ?>
                            <select class="width25 smltxtbox caTraining<?php echo $row['id']; ?>" name="caRemarkst[]" style="display:none;width:96.5%;">
                            <?php if($row['Code'] == 'SUPPM' || $row['Code'] == 'SUPJ' || $row['Code'] == 'SUPL' ) { ?>
                                <option>Supervisors' Workshop</option>
                                <option>Employee Discipline Orientation   </option>
                                <?php if($semi == 1){ ?><option>Manager's Forum</option>
                                <?php } elseif($semi == 2){ ?><option>Leader's Conference</option><?php } ?>
                                <option>Others</option>
                            <?php } elseif($row['Code'] == 'SUPC' ) { ?>
                                <option>Effective Business Writing Workshop</option>
                                <option>Others</option>
                            <?php } elseif($row['Code'] == 'SUPIR' || $row['Code'] == 'SUPINT' || $row['Code'] == 'SUPATT' ) { ?>
                                 <option>Winning Atitude Seminar</option>
                                <option>Motivational Seminar</option>
                                <option>Professional Etiquettes/Professionalism</option>
                                <option>Others</option>
                            <?php } elseif($row['Code'] == 'SUPOS') { ?>
                                <option>Time Management Seminar</option>
                                <option>Others</option>
                            <?php } elseif($row['Code'] == 'SUPCO') { ?>
                                 <option>Customer Service</option>
                                <option>24 7 Secrets of S.E.R.V.I.C.E.</option>
                                <option>Others</option>
                            <?php } elseif($row['Code'] == 'SUPTPK') { ?>
                                <option>Public Seminar</option>
                                <option>Others</option>
                            <?php } else { ?>
                                <option value="">Select</option>
                                <option>Others</option>
                            <?php } ?>
                            </select>

                            <input type="text" style="width:93.1%;" placeholder="Add your remarks" name="caRemarksr[]" class="width25 smltxtbox caRemarks<?php echo $row['id']; ?>" value="<?php echo $row['Remarks']; ?>" />
                        <?php } else { ?>
                            <input type="text" style="width:95%;" class="width25 smltxtbox" name="caRemarksr[]" value="<?php echo $row['Remarks']; ?>" placeholder="Add your remarks" />
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </table>

            <script>




                <?php foreach($checkEvalCA as $row) { ?>
                $('.actp<?php echo $row["id"]; ?>').change(function(){

                    var reqp<?php echo $row["id"]; ?>;
                    var actp<?php echo $row["id"]; ?>;
                    reqp<?php echo $row["id"]; ?> = parseFloat($('.reqp<?php echo $row["id"]; ?>').val());
                    actp<?php echo $row["id"]; ?> = parseFloat($('.actp<?php echo $row["id"]; ?>').val());
                    var result<?php echo $row["id"]; ?> = actp<?php echo $row["id"]; ?> - reqp<?php echo $row["id"]; ?>;
                    if (result<?php echo $row["id"]; ?> < 0) {
                        $('.result<?php echo $row["id"]; ?>').val(result<?php echo $row["id"]; ?>);
                        $('.divResult<?php echo $row["id"]; ?>').text(result<?php echo $row["id"]; ?>);
                        //$('.caRemarks<?php echo $row["id"]; ?>').attr("readonly", false);
                        // $('.caRemarks<?php //echo $row["id"]; ?>').val('--');
                        // $('.caRemarks<?php //echo $row["id"]; ?>').hide('fast');
						// $('.caTraining<?php //echo $row["id"]; ?>').show('slow');
                        $('.caTraining<?php echo $row["id"]; ?>').val('');
                    } else {
                        $('.result<?php echo $row["id"]; ?>').val('');
                        $('.divResult<?php echo $row["id"]; ?>').text('');
                        $('.caTraining<?php echo $row["id"]; ?>').hide('fast');
                        $('.caRemarks<?php echo $row["id"]; ?>').val('');
                        //$('.caRemarks<?php echo $row["id"]; ?>').attr("readonly", false);
                        $('.caRemarks<?php echo $row["id"]; ?>').show('slow');
                    }
                });

                $('.caTraining<?php echo $row["id"]; ?>').change(function(){
                    var caOthers<?php echo $row["id"]; ?>;
                    caOthers<?php echo $row["id"]; ?> = $('.caTraining<?php echo $row["id"]; ?>').val();
                    if (caOthers<?php echo $row["id"] ?> == 'Others'){
                        $('.caRemarks<?php echo $row["id"]; ?>').show('slow');
                        $('.caRemarks<?php echo $row["id"]; ?>').val('');
                    } else {
                        $('.caRemarks<?php echo $row["id"]; ?>').hide('slow');
                        $('.caRemarks<?php echo $row["id"]; ?>').val('--');
                    }
                });
                <?php } ?>

                /*$(".actp").on('change', function () {
                            var self = $(this);
                            var reqp = $(this).parent().prev('td').find('input').val();
                            var comp = self.val() - reqp;
                            //self.next().next().val(comp);
                            if(comp < 0) {
                                self.parent().next('td').find('div').html(comp);
                                self.parent().next('td').find('input').val(comp);
                                self.parent().next('td').next('td').find('select').show('slow');
                                self.parent().next('td').next('td').find('input').hide('slow');
                            } else {
                                self.parent().next('td').find('div').html('');
                                self.parent().next('td').find('input').val('');
                                self.parent().next('td').next('td').find('select').hide('fast');
                                self.parent().next('td').next('td').find('input').show('slow');
                            }
                           fnAlltotal();
                       });

                       function fnAlltotal(){
                             var total=0
                             $(".resgap").each(function(){
                                total += parseFloat($(this).val()||0);
                             });
                             var gaptotal = total.toFixed(2);
                       } */
            </script>

        <?php } else { ?>

            <table id="comass" border="0" cellspacing="0" class="tdata" style="width:99%;">
            <thead>
                <tr>
                    <th width="30%;">Goals</th>
                    <th width="15%;">Required Proficiency</th>
                    <th width="15%;">Actual Proficiency</th>
                    <th width="15%;">Gaps</th>
                    <th width="30%;">Training/Remarks</th>
                </tr>
            </thead>
                <!-- Core Competency -->
                <?php foreach($checkRank as $row){ ?>

                <?php if($type != $row['Type']) { ?>
                        <?php if($row['Type'] == 'CORE'){ ?>
                        <tr>
                            <th colspan="6"><u>CORE</u></th>
                        </tr>
                        <?php } else { ?>
                        <tr>
                            <th colspan="6"><u>JOB-SPECIFIC</u></th>
                        </tr>
                        <?php } ?>
                        <?php $type = $row['Type']; ?>
                <?php } ?>
                <tr>
                    <td>
                        <?php echo ucwords(strtolower($row['JobCompetency'])); ?>
                        <input type="hidden" name="caTitle[]" value="<?php echo $row['JobCompetency']; ?>" class="smltxtbox" name="caTitle[]">
                        <input type="hidden" name="caOrder[]" value="<?php echo $row['Order']; ?>">
                        <input type="hidden" name="caType[]" value="<?php echo $row['Type'] ?>">
                    </td>
                    <td style="text-align:center;">
                        <input type="hidden" name="caRp[]" class="reqp<?php echo $row['id']; ?> boxRem" value="<?php echo $row['ReqProficiency']; ?>">
                        <?php echo $row['ReqProficiency']; ?>
                    </td>
                    <td style="text-align:center;">
                        <select name="caAp[]" class="width25 smltxtbox actp<?php echo $row['id']; ?> checker" required onChange="totalp1()">
                            <option value="0">0</option>
                            <option value="5">5</option>
                            <option value="4">4</option>
                            <option value="3">3</option>
                            <option value="2">2</option>
                            <option value="1">1</option>
                        </select>
                        <input type="hidden" class="">
                    </td>
                    <td style="text-align:center;">
                        <input type="hidden" name="caGaps[]" class="width25 smltxtbox result<?php echo $row['id']; ?>">
                        <div class="divResult<?php echo $row['id']; ?>">0</div>
                    </td>
                    <td style="text-align:center;">
                        <input type="hidden" value="<?php echo $row['Code']; ?>" name="caCode[]" >
                       <?php if(1!=1) { ?>
                            <select class="width25 smltxtbox caTraining<?php echo $row['id']; ?>" name="caRemarkst[]" style="display:none;width:96.5%;" onChange="totalp1()"/>
                            <?php if($row['Code'] == 'RFQW' || $row['Code'] == 'RFIR' || $row['Code'] == 'RFINT' || $row['Code'] == 'RFI' || $row['Code'] == 'RFF' || $row['Code'] == 'RFD' || $row['Code'] == 'RFATT'){ ?>
                                <option>Winning Atitude Seminar</option>
                                <option>Motivational Seminar</option>
                                <option>Professional Etiquettes/Professionalism</option>
                                <option>Others</option>
                            <?php } elseif($row['Code'] == 'RFAP') { ?>
                                <option>Time Management Seminar</option>
                                <option>Others</option>
                            <?php } elseif($row['Code'] == 'RFCO') { ?>
                                <option>Customer Service</option>
                                <option>24 7 Secrets of S.E.R.V.I.C.E.</option>
                                <option>Others</option>
                            <?php } elseif ($row['Code'] == 'RFC') { ?>
                                <option>English Grammar</option>
                                <option>Oral Communication</option>
                                <option>Written Communication</option>
                                <option>Assertive Communication</option>
                                <option>Presentation Skills</option>
                                <option>Others</option>
                            <?php } else { ?>
                                <option value="">Select</option>
                                <option>Others</option>
                            <?php } ?>
                            </select>

                            <input type="text" style="display:none;width:93.1%;" placeholder="Add your remarks" name="caRemarksr[]" class="width25 smltxtbox caRemarks<?php echo $row['id']; ?>" style="width:96%;" />
                        <?php } elseif(1!=1){ ?>
                            <select class="width25 smltxtbox caTraining<?php echo $row['id']; ?>" name="caRemarkst[]" style="display:none;width:96.5%;">
                            <?php if($row['Code'] == 'SUPPM' || $row['Code'] == 'SUPJ' || $row['Code'] == 'SUPL' ) { ?>
                                <option>Supervisors' Workshop</option>
                                <option>Employee Discipline Orientation    </option>
                                <?php if($semi == 1){ ?><option>Manager's Forum</option>
                                <?php }elseif($semi == 2){ ?><option>Leader's Conference</option><?php } ?>
                                <option>Others</option>
                            <?php } elseif($row['Code'] == 'SUPC' ) { ?>
                                <option>Effective Business Writing Workshop</option>
                                <option>Others</option>
                            <?php } elseif($row['Code'] == 'SUPIR' || $row['Code'] == 'SUPINT' || $row['Code'] == 'SUPATT' ) { ?>
                                <option>Winning Atitude Seminar</option>
                                <option>Motivational Seminar</option>
                                <option>Professional Etiquettes/Professionalism</option>
                                <option>Others</option>
                            <?php } elseif($row['Code'] == 'SUPOS') { ?>
                                <option>Time Management Seminar</option>
                                <option>Others</option>
                            <?php } elseif($row['Code'] == 'SUPCO') { ?>
                                 <option>Customer Service</option>
                                <option>24 7 Secrets of S.E.R.V.I.C.E.</option>
                                <option>Others</option>
                            <?php } elseif($row['Code'] == 'SUPTPK') { ?>
                                <option>Public Seminar</option>
                                <option>Others</option>
                            <?php } else { ?>
                                <option value="">Select</option>
                                <option>Others</option>
                            <?php } ?>
                            </select>

                            <input type="text" style="display:none;width:93.1%;" placeholder="Add your remarks" name="caRemarksr[]" class="width25 smltxtbox caRemarks<?php echo $row['id']; ?>" style="width:96%;" />
                        <?php } else { ?>
                            <input type="text" style="width:95%;" class="width25 smltxtbox" name="caRemarksr[]" placeholder="Add your remarks" />
                        <?php } ?>

                    </td>
                </tr>
                <?php } ?>
            </table>

            <script>
                <?php foreach($checkRank as $row) { ?>
                $('.actp<?php echo $row["id"]; ?>').change(function(){
                    var reqp<?php echo $row["id"]; ?>;
                    var actp<?php echo $row["id"]; ?>;
                    reqp<?php echo $row["id"]; ?> = parseFloat($('.reqp<?php echo $row["id"]; ?>').val());
                    actp<?php echo $row["id"]; ?> = parseFloat($('.actp<?php echo $row["id"]; ?>').val());
                    var result<?php echo $row["id"]; ?> = actp<?php echo $row["id"]; ?> - reqp<?php echo $row["id"]; ?>;
                    if (result<?php echo $row["id"]; ?> < 0) {
                        $('.result<?php echo $row["id"]; ?>').val(result<?php echo $row["id"]; ?>);
                        $('.divResult<?php echo $row["id"]; ?>').text(result<?php echo $row["id"]; ?>);
                        // $('.caRemarks<?php //echo $row["id"]; ?>').hide('fast');
                        // $('.caRemarks<?php //echo $row["id"]; ?>').val('--');
                        // $('.caTraining<?php //echo $row["id"]; ?>').show('slow');
						// $('.caRemarks<?php //echo $row["id"]; ?>').val('');
                        // $('.caRemarks<?php //echo $row["id"]; ?>').show('slow');
						$('.caTraining<?php echo $row["id"]; ?>').val('');
                    } else {
                        $('.result<?php echo $row["id"]; ?>').val('');
                        $('.divResult<?php echo $row["id"]; ?>').text('');
                        // $('.caRemarks<?php //echo $row["id"]; ?>').val('');
						$('.caTraining<?php echo $row["id"]; ?>').val('');
                        // $('.caTraining<?php //echo $row["id"]; ?>').hide('fast');
                        // $('.caRemarks<?php //echo $row["id"]; ?>').show('slow');
                    }
                });

                $('.caTraining<?php echo $row["id"]; ?>').change(function(){
                    var caOthers<?php echo $row["id"]; ?>;
                    caOthers<?php echo $row["id"]; ?> = $('.caTraining<?php echo $row["id"]; ?>').val();
                    if (caOthers<?php echo $row["id"] ?> == 'Others'){
                        $('.caRemarks<?php echo $row["id"]; ?>').show('slow');
                        $('.caRemarks<?php echo $row["id"]; ?>').val('');
                    } else {
                        $('.caRemarks<?php echo $row["id"]; ?>').hide('slow');
                        $('.caRemarks<?php echo $row["id"]; ?>').val('--');
                    }
                });

                <?php } ?>
            </script>

        <?php } ?>

    <?php } else { ?>
    <input type="hidden" class="smltxtbox boxRem" style="width:96%;" required />
    <table style="width:99%;">
        <tr style="background-color:#fff;">
            <td colspan="7" style="text-align:center;font-weight:bold;color:#A70606;"> Kindly inform the HR for the Competency Assessment Form </td>
        </tr>
    </table>
    <?php } ?>
            <br />
            <!-- Part II - Goals Covered Under the Evaluation Period -->
            <p>
                <b class="smalltext lwhitetext">Part II - Goals Covered Under the Evaluation Period</b><br />
            </p>

            <table id="gcutep" border="0" cellspacing="0" class="tdata" style="width:99%;">
                <thead>
                    <tr>
                        <th width="21%;">Goals</th>
                        <th width="5%;">E<br />(5)</th>
                        <th width="5%;">EE<br />(4)</th>
                        <th width="5%;">ME<br />(3)</th>
                        <th width="5%;">NI<br />(2)</th>
                        <th width="5%;">U<br />(1)</th>
                        <th width="20%;">Comments</th>
                    </tr>
                </thead>
                <tbody id="jsgoals">
                <?php $counterg2 = 0; if($checkifsave == 2) { ?>
                    <?php foreach ($checkEvalGC as $row) { ?>
                        <?php

                            $counterg2++;
                            $grade1 += $row['Grade'];
                            $trainstr = stristr($row['Goals'], 'mandatory training');
                        ?>
                        <tr>
                            <input type="hidden" name="g2ID[]" value="<?php echo $counterg2; ?>">
                            <td style="text-align:center;">

                              <input type="hidden" name="g2TitleID[]" value="<?php echo $row['id']; ?>">
                               <input type="text" class="smltxtbox checker" name="g2Title1[]" value="<?php echo $row['Goals']; ?>" style="width:88%;" <?php if($trainstr) { ?>readonly<?php } ?> required />
                               <span style="font-size: 10px"> <?php echo $row['MeasureOfSuccess']; ?></span>
                            </td>
                              <td style="text-align:center;">
                                  <input type="radio" class="radiop1" value="5" onClick="totalp1()" name="g2Rad<?php echo $counterg2; ?>" <?php if($row['Grade'] == 5) { ?>checked="checked"<?php } elseif($row['Grade'] != 5 && $trainstr) { ?>disabled<?php } ?> >
                              </td>
                              <td style="text-align:center;">
                                  <input type="radio" class="radiop1" value="4" onClick="totalp1()" name="g2Rad<?php echo $counterg2; ?>" <?php if($row['Grade'] == 4) { ?>checked="checked"<?php } elseif($row['Grade'] != 4 && $trainstr) { ?>disabled<?php } ?> >
                              </td>
                              <td style="text-align:center;">
                                  <input type="radio" class="radiop1" value="3" onClick="totalp1()" name="g2Rad<?php echo $counterg2; ?>" <?php if($row['Grade'] == 3) { ?>checked="checked"<?php } elseif($row['Grade'] != 3 && $trainstr) { ?>disabled<?php } ?> >
                              </td>
                              <td style="text-align:center;">
                                  <input type="radio" class="radiop1" value="2" onClick="totalp1()" name="g2Rad<?php echo $counterg2; ?>" <?php if($row['Grade'] == 2) { ?>checked="checked"<?php } elseif($row['Grade'] != 2 && $trainstr) { ?>disabled<?php } ?> >
                              </td>
                              <td style="text-align:center;">
                                  <input type="radio" class="radiop1" value="1" onClick="totalp1()" name="g2Rad<?php echo $counterg2; ?>" <?php if($row['Grade'] == 1) { ?>checked="checked"<?php } elseif($row['Grade'] != 1 && $trainstr) { ?>disabled<?php } ?> >
                              </td>
                              <td style="text-align:center;">
                                  <input type="text" name="g2Comments1[]" value="<?php echo $row['Comments']; ?>" style="width:96.5%;" class="smltxtbox" />
                              </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>

                        <?php foreach($evaluateRatee AS $row) { ?>
                        <?php if($row['tscore'] == NULL || $row['tscore'] == '' || $row['tscore'] == '0') { ?>
                        <tr>
                            <td style="text-align:center;">
                                <input type="text" class="smltxtbox" name="g2Title1[]" onClick="totalp1()" value="8 hrs mandatory training" style="width:88%;" readonly />
                            </td>
                            <td style="text-align:center;">
                                <input disabled type="radio" value="5" class="radiop1" name="g2Rad1" onClick="totalp1()" required>
                            </td>
                            <td style="text-align:center;">
                                <input disabled type="radio" value="4" class="radiop1" name="g2Rad1" onClick="totalp1()" required>
                            </td>
                            <td style="text-align:center;">
                                <input disabled type="radio" value="3" class="radiop1" name="g2Rad1" onClick="totalp1()" required>
                            </td>
                            <td style="text-align:center;">
                                <input disabled type="radio" value="2" class="radiop1" name="g2Rad1" onClick="totalp1()" required>
                            </td>
                            <td style="text-align:center;">
                                <input disabled type="radio" value="1" checked="checked" name="g2Rad1" onClick="totalp1()" required>
                            </td>
                            <td style="text-align:center;">
                                <input  type="text" name="g2Comments1[]" style="width:96.5%;" class="smltxtbox" />
                            </td>
                        </tr>
                      <!--   <tr>
                            <td style="text-align:center;">
                                <input type="text" class="smltxtbox" name="g2Title1[]" value="5S+2" style="width:88%;" readonly />
                            </td>
                            <td style="text-align:center;">
                                <input type="radio" value="5" checked="checked" name="g2Rad2" required>
                            </td>
                            <td style="text-align:center;">
                                <input type="radio" value="4" checked="checked" name="g2Rad2" required>
                            </td>
                            <td style="text-align:center;">
                                <input type="radio" value="3" checked="checked" name="g2Rad2" required>
                            </td>
                            <td style="text-align:center;">
                                <input type="radio" value="2" checked="checked" name="g2Rad2" required>
                            </td>
                            <td style="text-align:center;">
                                <input type="radio" value="1" checked="checked" name="g2Rad2" required>
                            </td>
                            <td style="text-align:center;">
                                <input type="text" name="g2Comments1[]" style="width:96.5%;" class="smltxtbox" />
                            </td>
                        </tr> -->
                        <?php } else { ?>
                        <tr>
                            <td style="text-align:center;">
                                <input type="text" class="smltxtbox" name="g2Title1[]" value="8 hrs mandatory training" style="width:88%;" readonly />
                            </td>
                            <td style="text-align:center;">
                                <?php if($row['tscore'] == "5"){ ?><input type="radio" class="radiop1" value="5" checked="checked" name="g2Rad1"  onClick="totalp1()" required><?php } else { ?><input type="radio" class="radiop1" value="5" disabled><?php } ?>
                            </td>
                            <td style="text-align:center;">
                                <?php if($row['tscore'] == "4"){ ?><input type="radio" class="radiop1" value="4" checked="checked" name="g2Rad1" onClick="totalp1()"  required><?php } else { ?><input type="radio" class="radiop1" value="4" disabled><?php } ?>
                            </td>
                            <td style="text-align:center;">
                                <?php if($row['tscore'] == "3"){ ?><input type="radio" class="radiop1" value="3" checked="checked" name="g2Rad1" onClick="totalp1()"  required><?php } else { ?><input type="radio" class="radiop1" value="3" disabled><?php } ?>
                            </td>
                            <td style="text-align:center;">
                                <?php if($row['tscore'] == "2"){ ?><input type="radio" class="radiop1" value="2" checked="checked" name="g2Rad1" onClick="totalp1()"  required><?php } else { ?><input type="radio" class="radiop1" value="2" disabled><?php } ?>
                            </td>
                            <td style="text-align:center;">
                                <?php if($row['tscore'] == "1"){ ?><input type="radio" class="radiop1" value="1" checked="checked" name="g2Rad1" onClick="totalp1()"  required><?php } else { ?><input type="radio" class="radiop1" value="1" disabled><?php } ?>
                            </td>
                            <td style="text-align:center;">
                                <input type="text" name="g2Comments1[]" style="width:96.5%;" class="smltxtbox" />
                            </td>
                        </tr>
                       <!--  <tr>
                            <td style="text-align:center;">
                                <input type="text" class="smltxtbox" name="g2Title1[]" value="5S+2" style="width:88%;" readonly />
                            </td>
                            <td style="text-align:center;">
                                <?php if($row['S5Score'] == "5"){ ?><input type="radio" value="5" checked="checked" name="g2Rad2" onClick="totalp1()" required><?php } else { ?><input type="radio" value="5" disabled><?php } ?>
                            </td>
                            <td style="text-align:center;">
                                <?php if($row['S5Score'] == "4"){ ?><input type="radio" value="4" checked="checked" name="g2Rad2" required><?php } else { ?><input type="radio" value="4" disabled><?php } ?>
                            </td>
                            <td style="text-align:center;">
                                <?php if($row['S5Score'] == "3"){ ?><input type="radio" value="3" checked="checked" name="g2Rad2" required><?php } else { ?><input type="radio" value="3" disabled><?php } ?>
                            </td>
                            <td style="text-align:center;">
                                <?php if($row['S5Score'] == "2"){ ?><input type="radio" value="2" checked="checked" name="g2Rad2" required><?php } else { ?><input type="radio" value="2" disabled><?php } ?>
                            </td>
                            <td style="text-align:center;">
                                <?php if($row['S5Score'] == "1"){ ?><input type="radio" value="1" checked="checked" name="g2Rad2" required><?php } else { ?><input type="radio" value="1" disabled><?php } ?>
                            </td>
                            <td style="text-align:center;">
                                <input type="text" name="g2Comments1[]" style="width:96.5%;" class="smltxtbox" />
                            </td>
                        </tr> -->
                        <?php } ?>
                    <?php } ?>
                    <?php
                        $i = 2;
                        foreach ($checkEvalGC as $row) {
                        ?>
                        <tr>
                            <td style="text-align:center;">
                               <input type="text" class="smltxtbox checker" name="g2Title1[]" value="<?php echo $row['Goals']; ?>" style="width:88%;" readonly required />
                               <span style="font-size: 10px"> <?php echo $row['MeasureOfSuccess']; ?></span>
                            </td>
                            <td style="text-align:center;">
                                <input type="radio" class="radiop1" value="5"  name="g2Rad<?php echo $i; ?>" onClick="totalp1()" <?php if($row['Grade'] == 5) echo 'checked'; ?> required>
                            </td>
                            <td style="text-align:center;">
                                <input type="radio" class="radiop1" value="4"  name="g2Rad<?php echo $i; ?>" onClick="totalp1()"  <?php if($row['Grade'] == 5) echo 'checked'; ?> required>
                            </td>
                            <td style="text-align:center;">
                                <input type="radio" class="radiop1" value="3"  name="g2Rad<?php echo $i; ?>" onClick="totalp1()"  <?php if($row['Grade'] == 5) echo 'checked'; ?> required>
                            </td>
                            <td style="text-align:center;">
                                <input type="radio" class="radiop1" value="2"  name="g2Rad<?php echo $i; ?>" onClick="totalp1()"  <?php if($row['Grade'] == 5) echo 'checked'; ?> required>
                            </td>
                            <td style="text-align:center;">
                                <input type="radio" class="radiop1" value="1" checked name="g2Rad<?php echo $i; ?>" onClick="totalp1()"  <?php if($row['Grade'] == 5) echo 'checked'; ?> required>
                            </td>
                            <td style="text-align:center;">
                                <input type="text" name="g2Comments1[]" value="<?php //echo $row['Comments']; ?>" style="width:96.5%;" class="smltxtbox" />
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php } ?>
                <?php } ?>
                </tbody>
            </table>
            <br />
                <a class="smlbtn" id="addrowg" style="background-color:#3EC2FB;" >Add Row</a>
                <a class="smlbtn" id="delrowg" style="background-color:#D20404;" >Delete</a> <i>Note: Don't use word with 'mandatory training' as new goal/objective</i>
            <br /><br />
            <table style="border: 2px solid #fff; width:25%; margin: 0 auto;">
                <tr>
                    <th>Rating Guide</th>
                    <th style="text-align:center;"></th>
                </tr>
                <tr>
                    <td>5 - Exceptional</td>
                    <td style="text-align:center;"></td>
                </tr>
                <tr>
                    <td>4 - Exceeds Expectations</td>
                    <td style="text-align:center;"></td>
                </tr>
                <tr>
                    <td>3 - Meets Expectations</td>
                    <td style="text-align:center;"></td>
                </tr>
                <tr>
                    <td>2 - Needs Improvement</td>
                    <td style="text-align:center;"></td>
                </tr>
                <tr>
                    <td>1 - No Evidence of Skill</td>
                    <td style="text-align:center;"></td>
                </tr>
            </table><br />

            <!-- script for Adding new row for goals -->
            <script type="text/javascript">
                $(document).ready(function(){
                    var counter = <?php if($checkifsave == 2){ echo $counterg2 + 1; } else { echo '2'; } ?>;
                    $("#addrowg").click(function () {
                        if(counter>50) {
                            //alert("Only 10 textboxes allow");
                            return false;
                        }
                    var newTextBoxDiv = $(document.createElement('tbody'))
                         .attr("id", 'jsgoals' + counter);

                    newTextBoxDiv.after().html(
                        '<input type="hidden" name="g2ID[]" value="'+ counter +'">' +
                        '<tr>' +
                            '<td style="text-align:center;">' +
                                '<input type="text" class="smltxtbox checker" name="g2Title1[]" style="width:88%;" onClick="totalp1()" required />' +
                            '</td>' +
                            '<td style="text-align:center;">' +
                                '<input type="radio" class="radiop1" value="5" name="g2Rad'+ counter +'" onClick="totalp1()" required>' +
                            '</td>' +
                            '<td style="text-align:center;">' +
                                '<input type="radio" class="radiop1" value="4" name="g2Rad'+ counter +'" onClick="totalp1()" required>' +
                            '</td>' +
                            '<td style="text-align:center;">' +
                                '<input type="radio" class="radiop1" value="3" name="g2Rad'+ counter +'" onClick="totalp1()" required>' +
                            '</td>' +
                            '<td style="text-align:center;">' +
                                '<input type="radio" class="radiop1" value="2" name="g2Rad'+ counter +'" onClick="totalp1()" required>' +
                            '</td>' +
                            '<td style="text-align:center;">' +
                                '<input type="radio" class="radiop1" checked value="1" name="g2Rad'+ counter +'" onClick="totalp1()" required>' +
                            '</td>' +
                            '<td style="text-align:center;">' +
                                '<input type="text" name="g2Comments1[]" style="width:96%;" class="smltxtbox checker" required />' +
                            '</td>' +
                        '</tr>'
                    );

                    newTextBoxDiv.appendTo("#gcutep");
                    counter++;

                    totalp1();
                    });

                    $("#delrowg").click(function(){
                        if(counter==<?php if($checkifsave == 2){ echo $counterg2 + 1; } else { echo '2'; } ?>)
                        {
                            //alert("No more forms to remove");
                            return false;
                        }
                            counter--;
                            $("#jsgoals" + counter).remove();
                        totalp1();
                    });
                });
            </script>
            <!-- Part III - Goals For The Coming Year Or Evaluation Period -->
            <p>
                <b class="smalltext lwhitetext">Part III - Goals For The Coming Year Or Evaluation Period</b><br />
            </p>
            <table id="gftcyoep" border="0" cellspacing="0" class="tdata" style="width:99%;">
                <thead>
                    <tr>
                        <th width="50%;">Goals</th>
                        <th width="50%;">Measure of Success</th>
                    </tr>
                </thead>
                <tbody id="jsgoals2">
                    <?php $counterg3 = 1; if($checkifsave == 2) { ?>

                        <?php foreach($checkEvalGF as $key) { $counterg3++; ?>
                        <tr>
                            <input type="hidden" name="g3ID[]" value="<?php echo $key['id']; ?>">
                            <td style="text-align:center;">
                                <input type="text" class="smltxtbox checker" name="g3Title1[]" value="<?php echo $key['Goals']; ?>" style="width:98%;" required />
                            </td>
                            <td style="text-align:center;">
                                <input type="text" class="smltxtbox checker" name="g3MS[]" value="<?php echo $key['MeasureOSuccess']; ?>" style="width:98%;" required />
                            </td>
                        </tr>
                        <?php } ?>

                    <?php } else { ?>
                    <tr>
                        <td style="text-align:center;">
                            <input type="text" class="smltxtbox checker" name="g3Title1[]" style="width:98%;float:right;" required />
                        </td>
                        <td style="text-align:center;">
                            <input type="text" class="smltxtbox checker" name="g3MS[]" style="width:98%;" class="smltxtbox" required />
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br />
                <a class="smlbtn" id="addrowg2" style="background-color:#3EC2FB;" >Add Row</a>
                <a class="smlbtn" id="delrowg2" style="background-color:#D20404;" >Delete</a>

            <!-- script for Adding new row for goals -->
            <script type="text/javascript">
                $(document).ready(function(){
                    var counter = <?php if($checkifsave == 2){ echo $counterg3 + 1; } else { echo '2'; } ?>;
                    $("#addrowg2").click(function () {
                        if(counter>50){
                            //alert("Only 10 textboxes allow");
                            return false;
                        }
                    var newTextBoxDiv = $(document.createElement('tbody'))
                        .attr("id", 'jsgoals2' + counter);

                    newTextBoxDiv.after().html('<tr>' +
                        '<td style="text-align:center;">' +
                            '<input type="text" class="smltxtbox checker" name="g3Title1[]" style="width:98%;float:right;" required />' +
                        '</td>' +
                        '<td style="text-align:center;">' +
                            '<input type="text" class="smltxtbox checker" name="g3MS[]" style="width:98%;" class="smltxtbox" required />' +
                        '</td>' +
                    '</tr>');

                    newTextBoxDiv.appendTo("#gftcyoep");
                        counter++;
                    });

                    $("#delrowg2").click(function(){
                        if(counter==<?php if($checkifsave == 2){ echo $counterg3 + 1; } else { echo '2'; } ?>)
                        {
                            //alert("No more forms to remove");
                            return false;
                        }
                            counter--;
                            $("#jsgoals2" + counter).remove();
                    });

                });
            </script>
            <br />

            <?php foreach($evaluateRatee AS $row) { ?>
                <?php if($row['cmscore'] != NULL && $row['apscore'] != NULL && $row['tscore'] != NULL && $row['S5Score'] != NULL){ ?>
                <?php
                    $cmscore = $row['cmscore'] * 0.15;
                    $apscore = $row['apscore'] * 0.10;
                    $s5score = $row['S5Score'] * 0.05;
                ?>
                <br />
                <table style="border:2px solid #fff;width:99%;">
                    <thead>
                    <tr>
                        <th style="text-align:left;width:350px;">A. HR RELATED EVALUATION - 30%</th>
                        <th style="text-align:center;">% Value</th>
                        <th style="text-align:center;">Rate</th>
                        <th style="text-align:center;">Final Value</th>
                    </tr>
                    </thead>
                    <tr>
                        <td>Attendance and Punctuality <br>
                        <td style="text-align:center;">10%</td>
                        <td style="text-align:center;"><?php echo $row['apscore']; ?></td>
                        <td style="text-align:center;"><?php echo $apscore; ?><input type="hidden" name="apscore" class="boxPom" value="<?php echo $apscore; ?>"></td>
                    </tr>
                    <tr>
                        <td>Conduct and Compliance to the company policy <br>
                        <td style="text-align:center;">15%</td>
                        <td style="text-align:center;"><?php echo $row['cmscore']; ?></td>
                        <td style="text-align:center;"><?php echo $cmscore; ?><input type="hidden" name="cmscore" class="boxPom" value="<?php echo $cmscore; ?>"></td>
                    </tr>

                    <tr>
                        <td>Compliance to the 5S + 2 Process</td>
                        <td style="text-align:center;">5%</td>
                        <td style="text-align:center;"><?php echo $row['S5Score']; ?></td>
                        <td style="text-align:center;"><?php echo $s5score; ?><input type="hidden" name="s5score" class="boxPom" value="<?php echo $s5score; ?>"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align:center;"></td>
                        <td style="text-align:right;font-weight:bold;">Total:</td>
                        <td style="text-align:center;border-top:1px solid #fff;"><input type="hidden" id="totalhr" value="<?php echo $ffinal1 = $cmscore + $apscore + $s5score; ?>"> <?php echo $ffinal1 = $cmscore + $apscore + $s5score; ?></td>
                    </tr>
                </table>
                <?php //if($checkifsave == 2) { ?>
                <h4 style="text-align:center;"> Final Summary </h4>
                <table style="border:2px solid #fff;width:99%;">
                    <thead>
                    <tr>
                        <th style="text-align:left;width:350px;">B. PERFORMANCE EVALUATION - 70%</th>
                        <th style="text-align:center;">% Value</th>
                        <th style="text-align:center;">Rate</th>
                        <th style="text-align:center;">Final Value</th>
                    </tr>
                    </thead>
                    <tr>
                        <td>Competency Assessment </td>
                        <td style="text-align:center;">30%</td>
                        <td style="text-align:center;"><span id="total1"><?php $cc1 = $countap - 1; $ffx1 = $grade0 / $cc1; echo number_format((float)$ffx1, 2, '.', ''); ?></span></td>
                        <td style="text-align:center;"><span id="total2"><?php $gfx1 = $ffx1 * 0.3; echo $fin1 = number_format((float)$gfx1, 2, '.', ''); ?></span><input type="hidden" name="cmscore" class="boxPom" value="<?php echo $cmscore; ?>"></td>
                    </tr>
                    <tr>
                        <td>Goals Covered Under The Evaluation Period</td>
                        <td style="text-align:center;">40%</td>
                        <td style="text-align:center;"><span id="total3"><?php $cc2 = $counterg2; $ffx2 = $grade1 / $cc2; echo number_format((float)$ffx2, 2, '.', ''); ?></span></td>
                        <td style="text-align:center;"><span id="total4" onchange="total5()"><?php $gfx2 = $ffx2 * 0.4; echo $fin2 = number_format((float)$gfx2, 2, '.', ''); ?></span><input type="hidden" name="apscore" class="boxPom" value="<?php echo $apscore; ?>"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align:center;"></td>
                        <td style="text-align:right;font-weight:bold;">Total:</td>
                        <td style="text-align:center;border-top:1px solid #fff;">
                          <span id="total5">
                            <?php

                            echo $final2 = $fin1 + $fin2
                            // $final2 = $gfx1 + $gfx2;
                            // echo number_format((float)$final2, 2, '.', '');

                            ?>
                          </span>
                            </td>
                    </tr>

                    <tr>
                        <td style="font-weight:bold;text-align:right;">Overall Performance : </td>
                        <td style="text-align:center;">
                          <span id="totalall">
                            <?php
                                echo $ggfin = $ffinal1 + $final2;
                                // echo number_format((float)$ggfin, 2, '.', '');
                                ?>
                          </span>
                            </td>
                        <td style="text-align:center;"></td>
                        <td style="text-align:center;"></td>
                    </tr>

                    <tr>
                        <td style="font-weight:bold;text-align:right;">Percentage Equivalent : </td>
                        <td style="text-align:center;"><span id="perctotal"><?php $finincrease = round($ggfin / 5 * 100); echo $finincrease.'%';  ?></span></td>

                            <?php if($row['computed'] == 5) { ?> <?php $note1 = '(<i class="fa fa-thumbs-up"></i>) This Employee is Exceptional'; $color1 = '#06A716'; } ?>
                            <?php if($row['computed'] < 5 && $row['computed'] >= 4) { ?> <?php $note1 = '(<i class="fa fa-thumbs-up"></i>) This Employee Exceeds Expectations'; $color1 = '#06A716'; } ?>
                            <?php if($row['computed'] < 4 && $row['computed'] >= 3) { ?> <?php $note1 = '(<i class="fa fa-thumbs-up"></i>) This Employee Meets Expectations'; $color1 = '#06A716'; } ?>
                            <?php if($row['computed'] < 3 && $row['computed'] >= 2) { ?> <?php $note1 = '(<i class="fa fa-thumbs-up"></i>) This Employee Needs Improvement'; $color1 = '#06A716'; } ?>
                            <?php if($row['computed'] < 2 && $row['computed'] >= 1) { ?> <?php $note1 = '(<i class="fa fa-thumbs-down"></i>) This Employee has No Evidence of Skill'; $color1 = '#A70606'; } ?>

                        <td class="note" id="note" style="text-align:center;background-color:#fff;font-weight:bold;color:<?php echo $color1; ?>;" colspan="2"><?php echo $note1; ?></td>
                    </tr>
                </table><br />
                <?php //} ?>

                <?php } else { ?>
                <br /><br />
                <input type="hidden" class="smltxtbox boxPom" style="width:96%;" required />
                <table style="width:99%;">
                    <tr style="background-color:#fff;">
                        <td colspan="7" style="text-align:center;font-weight:bold;color:#A70606;"> Kindly inform the HR for the Employee Conduct/Memo, Attendance Score, 5S + 2 Score and Training Score </td>
                    </tr>
                </table>
                <?php } ?>
            <?php } ?>

                <h3><strong>Equivalent system generated percentage increase: </strong><span id="computed_perc"> <?php echo $finincrease * ($appraisal[0]['Increase']/100).'%'; ?></span></h3>
                <p><strong>Final Recommendation;</strong> please fill up your desired recommendations below.</p>
                <table>
                    <tr>
                        <td style="vertical-align:top; width:150px">Promotion To Level</td>
                        <td>
                            <datalist id="ranks">
                                <?php
                                    $ranks = [
                                    'Rank and File',
                                    'Rank and File II',
                                    'Senior Rank and File',
                                    'SENIOR RANK AND FILE I',
                                    'Senior Rank and File II',
                                    'Assistant Supervisor',
                                    'Assistant Supervisor II',
                                    'Assistant Supervisor III',
                                    'Supervisor',
                                    'Supervisor II',
                                    'Supervisor III',
                                    'Senior Supervisor',
                                    'Senior Supervisor II',
                                    'Senior Supervisor III',
                                    'Assistant Manager',
                                    'Assistant Manager II',
                                    'Assistant Manager III',
                                    'Manager',
                                    'Manager II',
                                    'MANAGER III',
                                    'Senior Manager',
                                    'Senior Manager II',
                                    'Assistant Vice President',
                                    'Senior Assistant Vice President',
                                    'VICE PRESIDENT',
                                    'SENIOR VICE PRESIDENT',
                                    'SENIOR EXECUTIVE VICE PRESIDENT',
                                    'FIRST VICE PRESIDENT',
                                    'CHIEF OPERATING OFFICER'
                                    ];

                                    $i = false;
                                    $j = false;
                                    foreach($ranks as $rank):
                                        if($rank == $evaluateRatee[0]['randesc'])
                                            $j = true;

                                        if($j):
                                ?>

                                <option class="datalistalist1" value="<?php echo $rank ?>">
                                        <?php
                                            // echo $rank;

                                            if($i){
                                            $txt =  '(system ';
                                                if($evaluateRatee[0]['promote'] == $rank)
                                                    $txt .= "and approver's ";

                                            $txt .='recommended)';
                                            echo $txt;
                                            $i = false;
                                            }elseif($evaluateRatee[0]['promote'] == $rank){
                                                echo "(approver's recommendations)";
                                            }

                                            if($evaluateRatee[0]['randesc'] == $rank){
                                            echo '(current rank)';
                                            $i = true;
                                            }

                                        ?>
                                </option>

                                <?php endif; endforeach; ?>
                                </datalist>
                            <input type="text" id="promoteto" class="promotion" name="promotion" list="ranks" value="<?php echo $evaluateRatee[0]['promote']; ?>" autocomplete="off" onChange="totalp1()" onClick="this.value = ''; totalp1()" data-promote="<?php echo $evaluateRatee[0]['randesc']; ?>" style="width:350px !important">
                            <br><br>
                            Current rank is <b>"<?php echo $evaluateRatee[0]['randesc']; ?>" </b>
                            <br>
                            <?php if($evaluateRatee[0]['promote']  == $ranks[array_search($evaluateRatee[0]['randesc'], $ranks) + 1]) : ?>
                                Evaluator and System recommends for promotion to <b> "<?php echo $evaluateRatee[0]['promote']; ?>" </b>
                            <?php else : ?>
                                <?php if($evaluateRatee[0]['promote']  != $evaluateRatee[0]['randesc'] && !empty(trim($evalateRatee[0]['promote']))) :?>
                                Evaluator recommends for promotion to <b>"<?php echo $evaluateRatee[0]['promote']; ?>"</b> 
                                <br>
                                <? endif; ?>
                                System recommends for promotion to <b> "<?php echo $ranks[array_search($evaluateRatee[0]['randesc'], $ranks) + 1]; ?>"</b>

                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top; width:150px">New Position Title</td>
                        <td>
                            <input type="text" id="promotetoPos" class="promotetoPos" name="promotetoPos" value="<?php echo $evaluateRatee[0]['promotePos']; ?>" style="width:350px !important">
                            <br><br>
                            Current Position title is <b>"<?php echo $evaluateRatee[0]['posdesc']; ?>"</b>
                        </td>
                    </tr>
                    <?php if($max1i == 1) { ?>
                        <tr>
                            <td style="vertical-align:top; width:150px">Salary Increase</td>
                            <td>
                                <input type="number" min="1" max="100" name="increase" value="<?php echo $evaluateRatee[0]['recinc']; ?>" step="0.01"> %
                                <br><br>
                                Salary increase will be the final recommended increase. If left blank, equivalent system generated percentage increase will apply.
                            </td>
                        </tr>
                    <?php } else { ?>
                        
                        <input type="hidden" name="increase" value="">

                    <?php } ?>
                </table>

            <p><strong>Promotion History for the last 3 years :</strong> <br>  <?php if(!empty($evaluateRatee[0]['ProHistory'])) echo $evaluateRatee[0]['ProHistory']; else echo 'Not Set'; ?></p>
            <p><strong>Attendance and Punctuality History for the last 3 years :</strong> <br>  <?php if(!empty($evaluateRatee[0]['APComment'])) echo $evaluateRatee[0]['APComment']; else echo 'Not Set'; ?></p>
            <p><strong>Conduct and Compliance to the company policy History for the last 3 years :</strong> <br>  <?php if(!empty($evaluateRatee[0]['CMComment'])) echo $evaluateRatee[0]['CMComment']; else echo 'Not Set'; ?></p>

			<?php if(date("Y") == '2021' && false){ ?>
            <p>Performance Summary: (This will be displayed only for The evaulator or 1st Approver and the Final Approver)</p>
            <textarea name="remarks" class="remarks checker" style="width:98.4%;min-height:100px;" required><?php if($checkifsave == 2) { echo stripslashes($row['rcomm1']); } ?></textarea>
            <br /><br />
			<?php } ?>

			<p>Comments: (This will not be displayed in the ratee's form. The comments may only be viewed by the final approver. Other recommendations such as employee movements, etc may be stated here and will be subject for approval)</p>
            <textarea name="remarks" class="remarks checker" style="width:98.4%;min-height:100px;" required><?php if($checkifsave == 2) { echo stripslashes($row['rcomm1']); } ?></textarea>
            <br /><br />
            <div style="float:right;">For evaluator's review and prior to submission to approver, click on the "Save Appraisal" button and click "Refresh page" to reload your browser and view the computed final employees evaluation summary.</div>
            <div style="clear:both;margin-bottom:10px;"></div>
            <a href="<?php echo WEB; ?>/pafview?groupid=<?php echo $groupid; ?>&pafad=rater&sub=1&appid=<?php echo $appid; ?>&rid=<?php echo $rid; ?>" class="viewapp smlbtn" id="viewapp" style="display:none;float:right;background-color:#3EC2FB;margin-right:10px;">View Result</a>
            <button type="submit" value="1" name="procAppraisal" class="subapp smlbtn" id="subapp" style="float:right;margin-right:10px;">Submit Appraisal</button>&nbsp;&nbsp;&nbsp;
            <a onclick="myFunction()" class="relapp smlbtn" style="float:right;margin-right:10px;display:none;background-color:#3EC2FB;"><i class="fa fa-undo"></i> Refresh page</a>
            <button type="submit" value="1" name="saveAppraisal" class="saveapp smlbtn" id="saveapp" style="float:right;background-color:#3EC2FB;margin-right:10px;">Save Appraisal</button>

            <a class="smlbtn" style="float:right;margin-right:10px;background-color:#3EC2FB !important;" href="<?php echo WEB; ?>/paf?groupid=<?php echo $groupid; if(isset($_GET['sub'])) echo '&sub=' . $_GET['sub']; ?>&ref=emp<?php echo $_GET['appid']; ?>"><i class=" fa fa-arrow-left" style="color:#fff;opacity:.8;"></i> Return to Approver's List</a>
            <br /><br />
        </fieldset>
        </form>
        </div>
        <div id="alert"></div>

        <div id="errdialog" title="" style="display:none;">
            <p id="errorp"></p>
        </div>

        <script type="text/javascript">
            function myFunction() {
                location.reload();
            }
            $(function ()
            {
                $('.subapp').click(function(){

                    if (confirm('Are you sure you want to submit? You may not be able to modify this form once submitted.')){
                        var hasNoValue;
                        $('.checker').each(function(i) {
                           var cc1 = $(this).val();
                           var ccfin = $.trim(cc1);
                           if (ccfin == '') {
                                $( this ).css("background-color", "#FCC4C4");
                                hasNoValue = true;
                           } else {
                                $( this ).css("background-color", "#fff");
                           }
                        });

                        // $('input.checker[type="text"]').each(function(){
                        //     var cc1 = $(this).val();
                        //     var ccfin = $.trim(cc1);
                        //     if (gibberish.detect(ccfin) != 1) {
                        //         $( this ).css("background-color", "#FCC4C4");
                        //         hasNoValue = true;
                        //         console.log(ccfin + ": " + gibberish.detect(ccfin));
                        //     } else {
                        //         $( this ).css("background-color", "#fff");
                        //     }
                        // });

                        if (hasNoValue) {
                              $('#errorp').html('You must fill up all the fields with phrase or sentence or valid value, *Important so we can improve your subordinates capabilities');
                              $( "#errdialog" ).dialog({
                                 title: "Fill-up all the fields"
                              });
                              return false;
                        }
                    } else {
                        return false;
                    }
                   // var checker = $('.checker').val();
                });

                $('#saveapp').click(function(){
                    //$('.'+newClass).prop('checked','true');
                    $("input").prop('required',false);
                    $("select").prop('required',false);
                    $("textarea").prop('required',false);
                });
            });

            totalp1();

            $(document).on('change', 'select[name="caAp[]"]', function(event) {
                var ap = parseInt($(this).val());
                var rp = parseInt($(this).closest('tr').find('input[name="caRp[]"]').val());
                var tr = $(this).closest('tr');

                if(ap - rp < 0){
                    $(tr).find('input[name="caGaps[]"]').val(ap - rp);
                    $(tr).find('input[name="caGaps[]"]').closest('td').find('div').html(ap - rp);
                }else{
					$(tr).find('input[name="caGaps[]"]').val('');
                    $(tr).find('input[name="caGaps[]"]').closest('td').find('div').html('');
                }
            });

            function totalp1(){
              var items = document.getElementsByName("caAp[]");
              var itemCount = items.length;
              var total = 0;
              for(var i = 0; i < itemCount; i++)
              {
                  total = total +  parseInt(items[i].value);
              }
              total = (total / i).toFixed(2);
              total2 = (total * .3).toFixed(2);
              document.getElementById('total1').innerHTML = total;
              document.getElementById('total2').innerHTML = total2;
              totalp2(total2);
            }

            function totalp2(totalfp1){
              var total2 = totalfp1;
              var val1 = 0;
              var total3 = 0;
              var radno = 0;
              var total4 = 0;

              var totalall = 0;
              var perctotal = 0;
              for( i = 0; i < document.getElementsByClassName('radiop1').length; i++ ){
                  if( document.getElementsByClassName('radiop1')[i].checked == true ){
                      val1 = document.getElementsByClassName('radiop1')[i].value;
                      val1 = parseFloat(val1);
                      total3 = total3 + val1;
                      radno++;
                  }
              }

              total3 = parseFloat((total3 / radno).toFixed(2));
              total4 = parseFloat((total3 * .4).toFixed(2));

              document.getElementById('total3').innerHTML = total3;
              document.getElementById('total4').innerHTML = total4.toFixed(2);
              total5(total2, total4);
            }

            function total5(totalp1, totalp2){
              var total5 = 0;
              var total2 = parseFloat(totalp1);
              var total4 = totalp2;
              totalhr = parseFloat(document.getElementById('totalhr').value);

              total5 = (parseFloat(total4 + total2)).toFixed(2);
              totalall = (totalhr + parseFloat(total5)).toFixed(2);
              perctotal = ((totalall / 5) * 100).toFixed(0);

              document.getElementById('totalall').innerHTML = totalall;
              document.getElementById('perctotal').innerHTML = perctotal+"%";
              document.getElementById('total5').innerHTML = total5;

              var note = '';
              var color = '';
              if(totalall == 5){
                note = '<i class="fa fa-thumbs-up"></i> This Employee is Exceptional';
                color = '#06A716';
              }else if(totalall < 5 && totalall >= 4){
                note = '<i class="fa fa-thumbs-up"></i> This Employee Exceeds Expectations';
                color = '#06A716';
              }else if(totalall < 4 && totalall >= 3){
                note = '<i class="fa fa-thumbs-up"></i> This Employee Meets Expectations';
                color = '#06A716';
              }else if(totalall < 3 && totalall >= 2){
                note = '<i class="fa fa-thumbs-up"></i> This Employee Needs Improvement';
                color = '#06A716';
              }else if(totalall < 2 ){
                note = '<i class="fa fa-thumbs-down"></i> This Employee has No Evidence of Skill';
                color = '#A70606';
              }

              document.getElementById('note').innerHTML = note;
              document.getElementById('note').setAttribute("style", "text-align:center;background-color:#fff;font-weight:bold;color:"+color+";");

              compperc(totalall);
            }

            function compperc(totalall){
              var selected_rank = document.getElementById('promoteto').value;
              var previous_rank = "<?php echo $evaluateRatee[0]['randesc']; ?>";
              var reg_increase = <?php echo $appraisal[0]['Increase']; ?>;
              var pro_increase = <?php echo $appraisal[0]['Proincrease']; ?>;
              var inc = reg_increase;
              if(selected_rank != previous_rank && selected_rank.trim() != '' && selected_rank != undefined){
                inc = pro_increase;
              }

              $('input[name="increase"]').attr({
                  max: inc
              });

              var increase_percentage =  ((totalall/5) * (inc /100 ) * 100).toFixed(2);
              document.getElementById('computed_perc').innerHTML = increase_percentage + "%";

            }

            $(document).on('change', 'input[name="promotion"]', function(){
                totalp1();
            });

            $(document).on("keypress", 'form', function (e) {
                var code = e.keyCode || e.which;
                if (code == 13) {
                    e.preventDefault();
                    return false;
                }
            });
        </script>
    </div>
    </div>
    <!-- end if -->
    <?php } else { ?>

        <p style="text-align:center;font-size:1.2em;margin-top:55px;">You have no rights to rate this employee</p>

    <?php } ?>
