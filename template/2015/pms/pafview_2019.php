                <div id="paf" class="mainbody lefttalign whitetext print">
                <?php if(count($checkEvaluation) > 0 && $pafad == 'rater') {  ?>

                    <b class="mediumtext lorangetext"><a href="<?php echo WEB; ?>/paf?groupid=<?php echo $groupid; ?>"><i class="mediumtext fa fa-arrow-left" style="color:#fff;opacity:.8;"></i></a> Performance Appraisal Viewer <?php if($pafad == 'divhead'){ echo '- Division Head'; } elseif($pafad == 'rater') { echo '- Supervisor/Approver'; } ?></b><br>
                        <!--<p>You're a ratee!</p>-->
                        <div>
                        <?php foreach($checkEvaluation as $row) { ?>
                        <hr style="width:99%;" />
                        <table style="width:98%;">
                            <thead>
                                <tr>
                                    <th colspan="2" style="font-weight:italic;">(<?php echo $row['randesc']; ?>) <!--<span style="font-weight:normal;"></span>--></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><b class="smallesttext lwhitetext">Employee Name:</b> <span style="font-weight:normal;"><?php echo ucwords(strtolower($row['rfname'].' '.$row['rlname'])); ?></span></td>
                                    <td><b class="smallesttext lwhitetext">Department:</b> <span style="font-weight:normal;"><?php echo ucwords(strtolower($row['depdesc'])); ?></span></td>
                                </tr>
                                <tr>
                                    <td><b class="smallesttext lwhitetext">Designation:</b> <span style="font-weight:normal;"><?php echo $row['posdesc']; ?></span></td>
                                    <td><b class="smallesttext lwhitetext">Date Hired:</b> <span style="font-weight:normal;"><?php echo date('m-d-Y', strtotime($row['hdate'])); ?></span></td>
                                </tr>
                                <tr>
                                    <td><b class="smallesttext lwhitetext">Period:</b> <span style="font-weight:normal;">From | <u><?php echo date('m-d-Y', strtotime($row['perfrom'])); // echo date('Y-m-d', strtotime($row['dtfrom'])); ?></u> To | <u><?php echo date('m-d-Y', strtotime($row['perto']));// echo date('Y-m-d', strtotime($row['dtto'])); ?></u></span></td>
                                    <td><b class="smallesttext lwhitetext">Date Appraisal:</b> <span style="font-weight:normal;"><?php echo date('m-d-Y', strtotime($row['appdt'])); ?></span></td>
                                </tr>
                            </tbody>
                        </table>
                        <hr style="width:99%;" />
                        <?php
                            //Parameters
                            //if ($rstat1 == 1) { $rtrstat = 'Approved'; }
                            //elseif ($rstat2 == 1) { $rtrstat = 'Approved'; }
                            //elseif ($rstat3 == 1) { $rtrstat = 'Approved'; }
                            //elseif ($rstat4 == 1) { $rtrstat = 'Approved'; }

                            $rtrstat = 'Approved';
                            $dhstat = 1;

                            if($sub == 1 && $rstat1 == 1){
                                $param1 = 1;
                            } elseif($sub == 2 && $rstat2 == 1) {
                                $param1 = 1;
                            } elseif($sub == 3 && $rstat3 == 1) {
                                $param1 = 1;
                            } elseif($sub == 4 && $rstat4 == 1) {
                                $param1 = 1;
                            } else {
                                $param1 = 0;
                            }
                        ?>
                        <?php } ?>
                            <div  class="print" style="overflow-y:scroll;max-height:400px;margin-top:10px;">
                            <!-- Competency Assessment -->
                            <h4>I. Competency Assessment</h4>
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
                            <?php if ($pafad == 'rater' && $rtrstat == 'Approved' && $dhstat != $param1) { ?>
                                <!-- start of cheking if not yet approved by the division head, if not do create form -->
                                <form id="frm_pafview" class="formx"  method="post" enctype="multipart/form-data">
                            <?php } ?>

                            <?php if(count($checkEvalCA) > 0) { ?>
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
                                    <td><?php echo ucwords(strtolower(strtoupper($row['Competency']))); ?>
                                    </td>
                                    <td style="text-align:center;width:25px;">
                                        <input type="hidden" name="caRp[]" class="reqp<?php echo $row['id']; ?>" value="<?php echo $row['ReqProficiency']; ?>">
                                        <?php echo $RP = $row['ReqProficiency']; ?>
                                    </td>

                                    <?php if ($pafad == 'rater' && $rtrstat == 'Approved' && $dhstat != $param1) { ?>
                                    <td style="text-align:center;width:25px;">
                                        <!-- create select input if not yet approved by the division head -->
                                        <input type="hidden" name="caid[]" value="<?php echo $row['id']; ?>">
                                        <select name="caAp[]" class="width25 smltxtbox actp<?php echo $row['id']; ?> checker" >
                                            <option <?php if ($row['ActProficiency'] == '5') { ?>selected="selected"<?php } ?>><?php if ($row['ActProficiency'] == '5') { echo $row['ActProficiency']; } else { ?>5<?php } ?></option>
                                            <option <?php if ($row['ActProficiency'] == '4') { ?>selected="selected"<?php } ?>><?php if ($row['ActProficiency'] == '4') { echo $row['ActProficiency']; } else { ?>4<?php } ?></option>
                                            <option <?php if ($row['ActProficiency'] == '3') { ?>selected="selected"<?php } ?>><?php if ($row['ActProficiency'] == '3') { echo $row['ActProficiency']; } else { ?>3<?php } ?></option>
                                            <option <?php if ($row['ActProficiency'] == '2') { ?>selected="selected"<?php } ?>><?php if ($row['ActProficiency'] == '2') { echo $row['ActProficiency']; } else { ?>2<?php } ?></option>
                                            <option <?php if ($row['ActProficiency'] == '1') { ?>selected="selected"<?php } ?>><?php if ($row['ActProficiency'] == '1') { echo $row['ActProficiency']; } else { ?>1<?php } ?></option>
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
                                            <select class="width25 smltxtbox boxRem caTraining<?php echo $row['id']; ?>" name="caRemarkst[]" style="display:none;width:96.5%;" >
                                            <?php if($row['Code'] == 'RFQW' || $row['Code'] == 'RFIR' || $row['Code'] == 'RFINT' || $row['Code'] == 'RFI' || $row['Code'] == 'RFF' || $row['Code'] == 'RFD' || $row['Code'] == 'RFATT'){ ?>
                                                <option>Winning Atitude Seminar</option>
                                                <option>Others</option>
                                            <?php } elseif($row['Code'] == 'RFAP') { ?>
                                                <option>Time Management Seminar</option>
                                                <option>Others</option>
                                            <?php } elseif($row['Code'] == 'RFCO') { ?>
                                                <option>Delightful Customer Experience Workshop</option>
                                                <option>Others</option>
                                            <?php } elseif ($row['Code'] == 'RFC') { ?>
                                                <option>Effective Business Writing Workshop</option>
                                                <option>Others</option>
                                            <?php } else { ?>
                                                <option>Others</option>
                                            <?php } ?>
                                            </select>

                                            <input type="text" style="width:93.1%;" placeholder="Add your remarks" name="caRemarksr[]" class="width25 smltxtbox boxRem caRemarks<?php echo $row['id']; ?> " value="<?php echo $row['Remarks']; ?>" />
                                        <?php } elseif($rankid == 'SCP' && $row['Type'] == 'CORE'){ ?>
                                            <select class="width25 smltxtbox boxRem caTraining<?php echo $row['id']; ?>" name="caRemarkst[]" style="display:none;width:96.5%;">
                                            <?php if($row['Code'] == 'SUPPM' || $row['Code'] == 'SUPJ' || $row['Code'] == 'SUPL' ) { ?>
                                                <option>Supervisors' Workshop</option>
                                                <?php if($semi == 1){ ?><option>Manager's Forum</option>
                                                <?php }elseif($semi == 2){ ?><option>Leader's Conference</option><?php } ?>
                                                <option>Others</option>
                                            <?php } elseif($row['Code'] == 'SUPC' ) { ?>
                                                <option>Effective Business Writing Workshop</option>
                                                <option>Others</option>
                                            <?php } elseif($row['Code'] == 'SUPIR' || $row['Code'] == 'SUPINT' || $row['Code'] == 'SUPATT' ) { ?>
                                                <option>Winning Atitude Seminar</option>
                                                <option>Others</option>
                                            <?php } elseif($row['Code'] == 'SUPOS') { ?>
                                                <option>Time Management Seminar</option>
                                                <option>Others</option>
                                            <?php } elseif($row['Code'] == 'SUPCO') { ?>
                                                <option>Delightful Customer Experience Workshop</option>
                                                <option>Others</option>
                                            <?php } elseif($row['Code'] == 'SUPTPK') { ?>
                                                <option>Public Seminar</option>
                                                <option>Others</option>
                                            <?php } else { ?>
                                                <option>Others</option>
                                            <?php } ?>
                                            </select>

                                            <input type="text" style="width:93.1%;" placeholder="Add your remarks" name="caRemarksr[]" class="width25 smltxtbox boxRem caRemarks<?php echo $row['id']; ?> " value="<?php echo $row['Remarks']; ?>" />
                                        <?php } else { ?>
                                            <input type="text" style="width:95%;" class="width25 smltxtbox boxRem " name="caRemarksr[]" value="<?php echo $row['Remarks']; ?>" placeholder="Add your remarks" />
                                        <?php } ?>
                                    </td>
                                    <?php } else { ?>
                                    <td style="text-align:center;width:25px;"><?php echo $AP = $row['ActProficiency']; ?></td>
                                    <td style="text-align:center;width:25px;"><?php echo $GAPS = $row['Gaps']; ?></td>
                                    <td style="text-align:left;"><?php echo nl2br($row['Remarks']); ?></td>
                                    <?php } ?>
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
                                        //$('.caRemarks<?php //echo $row["id"]; ?>').attr("readonly", false);
                                        // $('.caRemarks<?php //echo $row["id"]; ?>').val('--');
                                        // $('.caRemarks<?php //echo $row["id"]; ?>').hide('fast');
                                        // $('.caTraining<?php //echo $row["id"]; ?>').show('slow');
                                    } else {
                                        $('.result<?php echo $row["id"]; ?>').val('');
                                        $('.divResult<?php echo $row["id"]; ?>').text('');
                                        // $('.caTraining<?php echo $row["id"]; ?>').hide('fast');
                                        // $('.caRemarks<?php echo $row["id"]; ?>').val('');
                                        // $('.caRemarks<?php echo $row["id"]; ?>').val('');
                                        //$('.caRemarks<?php echo $row["id"]; ?>').attr("readonly", false);
                                        // $('.caRemarks<?php echo $row["id"]; ?>').show('slow');
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

                            <?php } else { ?>
                                    <table style="width:99%;">
                                        <tr style="background-color:#fff;">
                                            <td colspan="7" style="text-align:center;font-weight:bold;color:#A70606;"> Kindly inform the HR for the Competency Assessment Form </td>
                                        </tr>
                                    </table>
                            <?php } ?>


                            <?php if(count($checkEvalGC) > 0) { ?>
                            <!-- Goals Covered  Under The Evaluation Period -->
                            <h4>II. Goals Covered Under The Evaluation Period</h4>

                            <table id="gcutep" class="tdata" cellspacing="0" width="99%" border="0" style="height:auto;">
                                <thead>
                                <tr>
                                    <th style="text-align:left;width:150px;">Goals</th>
                                    <th style="text-align:center;width:45px;">E<br />(5)</th>
                                    <th style="text-align:center;width:45px;">EE<br />(4)</th>
                                    <th style="text-align:center;width:45px;">ME<br />(3)</th>
                                    <th style="text-align:center;width:45px;">NI<br />(2)</th>
                                    <th style="text-align:center;width:45px;">U<br />(1)</th>
                                    <th style="text-align:center;width:210px;">Remarks</th>
                                </tr>
                                </thead>
                                <tbody id="jsgoals">
                                <?php $counterg2 = 0; ?>
                                    <?php foreach ($checkEvalGC as $row) { $grade1 += $row['Grade']; ?>
                                    <tr>
                                        <?php $trainstr = stristr($row['Goals'], 'mandatory training'); ?>
                                        <?php $counterg2++; ?>
                                        <?php if ($pafad == 'rater' && $rtrstat == 'Approved' && $dhstat != $param1) { ?>

                                            <input type="hidden" name="g2ID[]" value="<?php echo $counterg2; ?>">
                                            <td style="text-align:center;">
                                               <input type="text" class="smltxtbox" name="g2Title1[]" value="<?php echo $row['Goals']; ?>" style="width:88%;" <?php if($trainstr) { ?>readonly<?php } ?> required />
                                                <span style="font-size: 10px"> <?php echo $row['MeasureOfSuccess']; ?></span>
                                            </td>
                                            <td style="text-align:center;">
                                                <input type="radio" value="5" name="g2Rad<?php echo $counterg2; ?>" <?php if($row['Grade'] == 5) { ?>checked="checked"<?php } elseif($row['Grade'] != 5 && $trainstr) { ?>disabled<?php } ?> >
                                            </td>
                                            <td style="text-align:center;">
                                                <input type="radio" value="4" name="g2Rad<?php echo $counterg2; ?>" <?php if($row['Grade'] == 4) { ?>checked="checked"<?php } elseif($row['Grade'] != 4 && $trainstr) { ?>disabled<?php } ?> >
                                            </td>
                                            <td style="text-align:center;">
                                                <input type="radio" value="3" name="g2Rad<?php echo $counterg2; ?>" <?php if($row['Grade'] == 3) { ?>checked="checked"<?php } elseif($row['Grade'] != 3 && $trainstr) { ?>disabled<?php } ?> >
                                            </td>
                                            <td style="text-align:center;">
                                                <input type="radio" value="2" name="g2Rad<?php echo $counterg2; ?>" <?php if($row['Grade'] == 2) { ?>checked="checked"<?php } elseif($row['Grade'] != 2 && $trainstr) { ?>disabled<?php } ?> >
                                            </td>
                                            <td style="text-align:center;">
                                                <input type="radio" value="1" name="g2Rad<?php echo $counterg2; ?>" <?php if($row['Grade'] == 1) { ?>checked="checked"<?php } elseif($row['Grade'] != 1 && $trainstr) { ?>disabled<?php } ?> >
                                            </td>
                                            <td style="text-align:center;">
                                                <input type="text" name="g2Comments1[]" value="<?php echo $row['Comments']; ?>" style="width:96.5%;" class="smltxtbox" />
                                            </td>

                                <?php } else { ?>

                                    <td><?php echo $counterg2.'. &nbsp;&nbsp;'.$row['Goals']; ?></td>
                                    <td style="text-align:center;"><?php if($row['Grade'] == 5) { echo '<i class="fa fa-check"></i>'; } ?></td>
                                    <td style="text-align:center;"><?php if($row['Grade'] == 4) { echo '<i class="fa fa-check"></i>'; } ?></td>
                                    <td style="text-align:center;"><?php if($row['Grade'] == 3) { echo '<i class="fa fa-check"></i>'; } ?></td>
                                    <td style="text-align:center;"><?php if($row['Grade'] == 2) { echo '<i class="fa fa-check"></i>'; } ?></td>
                                    <td style="text-align:center;"><?php if($row['Grade'] == 1) { echo '<i class="fa fa-check"></i>'; } ?></td>
                                    <td style="text-align:left;"><?php echo $row['Comments']; ?></td>

                                <?php } ?>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <br />
                            <?php if ($pafad == 'rater' && $rtrstat == 'Approved' && $dhstat != $param1) { ?>
                                <a class="smlbtn" id="addrowg" style="background-color:#3EC2FB;" >Add Row</a>
                                <a class="smlbtn" id="delrowg" style="background-color:#D20404;" >Delete</a>


                            <!-- script for Adding new row for goals -->
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    var counter = <?php  echo $counterg2 + 1; ?>;
                                    $("#addrowg").click(function () {
                                        if(counter>50){
                                            //alert("Only 10 textboxes allow");
                                            return false;
                                        }
                                    var newTextBoxDiv = $(document.createElement('tbody'))
                                         .attr("id", 'jsgoals' + counter);

                                    newTextBoxDiv.after().html(
                                        '<input type="hidden" name="g2ID[]" value="'+ counter +'">' +
                                        '<tr>' +
                                            '<td style="text-align:center;">' +
                                                '<input type="text" class="smltxtbox checker" name="g2Title1[]" style="width:88%;" required />' +
                                            '</td>' +
                                            '<td style="text-align:center;">' +
                                                '<input type="radio" value="5" name="g2Rad'+ counter +'" required>' +
                                            '</td>' +
                                            '<td style="text-align:center;">' +
                                                '<input type="radio" value="4" name="g2Rad'+ counter +'" required>' +
                                            '</td>' +
                                            '<td style="text-align:center;">' +
                                                '<input type="radio" value="3" name="g2Rad'+ counter +'" required>' +
                                            '</td>' +
                                            '<td style="text-align:center;">' +
                                                '<input type="radio" value="2" name="g2Rad'+ counter +'" required>' +
                                            '</td>' +
                                            '<td style="text-align:center;">' +
                                                '<input type="radio" value="1" name="g2Rad'+ counter +'" required>' +
                                            '</td>' +
                                            '<td style="text-align:center;">' +
                                                '<input type="text" name="g2Comments1[]" style="width:96%;" class="smltxtbox checker" required />' +
                                            '</td>' +
                                        '</tr>'
                                    );
                                    newTextBoxDiv.appendTo("#gcutep");
                                    counter++;
                                    });

                                    $("#delrowg").click(function(){
                                        if(counter==2)
                                        {
                                            //alert("No more forms to remove");
                                            return false;
                                        }
                                            counter--;
                                            $("#jsgoals" + counter).remove();
                                    });
                                });
                            </script>
                            <?php } ?>

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

                            <table class="tdata" cellspacing="0" style="width:99%;">
                                <thead>
                                    <tr>
                                        <th style="text-align:left;"><p style="font-size:10px;"><b>Overall Rating <span style="font-size:9px;">(Based on Generated Score and Combined Score of Part I and II )</span></b></p></th>
                                        <th>E<br />(5)</th>
                                        <th>EE<br />(4)</th>
                                        <th>ME<br />(3)</th>
                                        <th>NI<br />(2)</th>
                                        <th>U<br />(1)</th>
                                        <th>Comment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($checkEvaluation as $row) { ?>
                                    <tr>
                                        <td width="21%;">
                                            <p style="font-size:10px;">
                                            <!-- <?php echo $row['computed']; ?> -->
                                                <!--<b>Overall Rating <span style="font-size:9px;">(Based on Parts I and II)</span></b><br />-->
                                                Conduct/Memo = 15%<br>
                                                Attendance & Punctuality = 10%<br>
                                                Compliance to the 5S + 2 = 5%<br>
                                                Performance Goals = 70%<br>
                                                <!--(Please check one of the appropriate box)-->
                                            </p>
                                        </td>
                                        <td width="5%;" style="text-align:center;">
                                            <span id="o5" style="<?php if($row['computed'] != 5) echo "display:none"; ?>"><i class="fa fa-check"></i></span>
                                            <?php if($row['computed'] == 5) { ?>  <?php $note1 = '(<i class="fa fa-thumbs-up"></i>) According to your rating you are Exceptional.'; $color1 = '#06A716'; } ?>
                                        </td>
                                        <td  width="5%;" style="text-align:center;">
                                            <span id="o4" style="<?php if($row['computed'] >= 4 && $row['computed'] < 5) echo ''; else echo "display:none"; ?>"><i class="fa fa-check"></i></span>
                                            <?php if($row['computed'] < 5 && $row['computed'] >= 4) { ?>  <?php $note1 = '(<i class="fa fa-thumbs-up"></i>) According to your rating you Exceeds Expectations.'; $color1 = '#06A716'; } ?>
                                        </td>
                                        <td width="5%;" style="text-align:center;">
                                            <span id="o3" style="<?php if($row['computed'] >= 3 && $row['computed'] < 4) echo ''; else echo "display:none"; ?>"><i class="fa fa-check"></i></span>
                                            <?php if($row['computed'] < 4 && $row['computed'] >= 3) { ?> <?php $note1 = '(<i class="fa fa-thumbs-up"></i>) According to your rating you Meets Expectations.'; $color1 = '#06A716'; } ?>
                                        </td>
                                        <td width="5%;" style="text-align:center;">
                                            <span id="o2" style="<?php if($row['computed'] >= 2 && $row['computed'] < 3) echo ''; else echo "display:none"; ?>"><i class="fa fa-check"></i></span>
                                            <?php if($row['computed'] < 3 && $row['computed'] >= 2) { ?> <?php $note1 = '(<i class="fa fa-thumbs-up"></i>) According to your rating you still Need Improvements.'; $color1 = '#06A716'; } ?>
                                        </td>
                                        <td width="5%;" style="text-align:center;">
                                            <span id="01" style="<?php if($row['computed'] >= 1 && $row['computed'] < 2) echo ''; else echo "display:none"; ?>"><i class="fa fa-check"></i></span>
                                            <?php if($row['computed'] < 2 && $row['computed'] >= 1) { ?><?php $note1 = '(<i class="fa fa-thumbs-down"></i>) According to your rating you have No Evidence of Skills'; $color1 = '#A70606'; } ?>
                                        </td>
                                        <td width="20%;" style="text-align:center;">
                                            <?php if ($pafad == 'rater' && $rtrstat == 'Approved' && $dhstat != $param1) { ?>
                                                <input type="text" class="smltxtbox" value="<?php echo $row['orcomm']; ?>" name="orcomm" style="width:97.2%;" class="txtbox" />
                                            <?php } else { ?>
                                                <?php echo nl2br($row['orcomm']); ?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php } ?>

                            <?php //if(count($checkEvalGF) > 0) { ?>
                            <!-- Part III - Goals For The Coming Year Or Evaluation Period  -->
                            <h4>III. Goals For The Coming Year Or Evaluation Period</h4>
                            <table id="gftcyoep" class="tdata" cellspacing="0" width="99%" border="0" style="height:auto;">
                                <thead>
                                <tr>
                                    <?php if ($pafad == 'rater' && $rtrstat == 'Approved' && $dhstat != $param1) { ?>

                                    <?php } else { ?>
                                        <th width="5"></th>
                                    <?php } ?>
                                    <th style="text-align:left;width:50%;">Goals</th>
                                    <th style="text-align:left;width:50%;">Measure of Success</th>
                                </tr>
                                </thead>
                                <tbody id="jsgoals2">
                                <?php $count = 1; ?>
                                <?php foreach ($checkEvalGF as $key) { ?>
                                <tr>
                                    <?php if ($pafad == 'rater' && $rtrstat == 'Approved' && $dhstat != $param1) { ?>
                                    <input type="hidden" name="g3ID[]" value="<?php echo $key['id']; ?>">
                                    <td style="text-align:left;"><input type="text" class="smltxtbox checker" name="g3Title1[]" value="<?php echo $key['Goals']; ?>" style="width:98%;" required /></td>
                                    <td style="text-align:left;"><input type="text" class="smltxtbox checker" name="g3MS[]" value="<?php echo $key['MeasureOSuccess']; ?>" style="width:98%;" required /></td>
                                    <?php } else { ?>
                                        <td><?php echo $count++.'.'; ?></td>
                                        <td style="text-align:left;"><?php echo $key['Goals']; ?></td>
                                        <td style="text-align:left;"><?php echo $key['MeasureOSuccess']; ?></td>
                                    <?php } ?>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table><br />
                            <?php //} ?>
                            <?php if ($pafad == 'rater' && $rtrstat == 'Approved' && $dhstat != $param1) { ?>
                                <a class="smlbtn" id="addrowg2" style="background-color:#3EC2FB;" >Add Row</a>
                                <a class="smlbtn" id="delrowg2" style="background-color:#D20404;" >Delete</a>

                            <br /><br />
                            <!-- script for Adding new row for goals -->
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    var counter = 2;
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
                                        if(counter==2)
                                        {
                                            //alert("No more forms to remove");
                                            return false;
                                        }
                                            counter--;
                                            $("#jsgoals2" + counter).remove();
                                    });

                                });
                            </script>
                            <?php } ?>

                            <?php if(count($checkEvalID) > 0) { ?>
                            <!-- Part IV - Individual Development Plan  -->
                            <h4>IV. Individual Development Plan</h4>
                            <table class="tdata" cellspacing="0" width="99%" border="0" style="height:auto;">
                                <tr>
                                    <th width="5"></th>
                                    <th style="text-align:left;width:30%;">Summary of Competency Gaps</th>
                                    <th style="text-align:center;width:35px;">RP</th>
                                    <th style="text-align:center;width:35px;">AP</th>
                                    <th style="text-align:center;width:35px;">Gaps</th>
                                    <th style="text-align:left;">Development Action</th>
                                </tr>
                                <?php $count = 1; ?>
                                <?php foreach ($checkEvalID as $key) { ?>
                                <tr>
                                    <td><?php echo $count++.'.'; ?></td>
                                    <td><?php echo $key['SummaryOCGaps']; ?></td>
                                    <td style="text-align:center;width:25px;"><?php echo $key['Required']; ?></td>
                                    <td style="text-align:center;width:25px;"><?php echo $key['Actual']; ?></td>
                                    <td style="text-align:center;width:25px;"><?php echo $key['Gaps']; ?></td>
                                    <td style="text-align:left;"><?php echo $key['DevelopmentAction']; ?></td>
                                </tr>
                                <?php } ?>
                            </table><br />
                            <?php } ?>

                            <!--
                            <table class="tdata" style="width:99.5%;">
                                <tr style="background-color:#fff;">
                                    <td colspan="7" style="text-align:center;font-weight:bold;color:<?php echo $color1; ?>;"><?php echo $note1; ?></td>
                                </tr>
                            </table>
                            -->

                            <?php foreach($checkEvaluation AS $row) { ?>
                                <?php
                                    $cmscore = $row['cmscore'] * 0.15;
                                    $apscore = $row['apscore'] * 0.10;
                                    $s5score = $row['S5Score'] * 0.05;
                                ?>
                                <h4 style="text-align:center;"> Final Summary </h4>
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
                                        <td>Conduct and Compliance to the company policy </td>
                                        <td style="text-align:center;">15%</td>
                                        <td style="text-align:center;"><?php echo $row['cmscore']; ?></td>
                                        <td style="text-align:center;"><?php echo $cmscore; ?><input type="hidden" name="cmscore" class="boxPom" value="<?php echo $cmscore; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Attendance and Punctuality</td>
                                        <td style="text-align:center;">10%</td>
                                        <td style="text-align:center;"><?php echo $row['apscore']; ?></td>
                                        <td style="text-align:center;"><?php echo $apscore; ?><input type="hidden" name="apscore" class="boxPom" value="<?php echo $apscore; ?>"></td>
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
                                        <td style="text-align:center;border-top:1px solid #fff;"><?php echo $ffinal1 = $cmscore + $apscore + $s5score; ?></td>
                                    </tr>
                                </table><br />

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
                                        <td style="text-align:center;" ><span id="rateCA"><?php $cc1 = $countap - 1; $ffx1 = $grade0 / $cc1; echo number_format((float)$ffx1, 2, '.', ''); ?></span></td>
                                        <td style="text-align:center;"><span  id="fvCA"><?php $gfx1 = $ffx1 * 0.3; echo $fin1 = number_format((float)$gfx1, 2, '.', ''); ?></span><input type="hidden" name="cmscore" class="boxPom" value="<?php echo $cmscore; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Goals Covered Under The Evaluation Period</td>
                                        <td style="text-align:center;">40%</td>
                                        <td style="text-align:center;" ><span id="rateGoals"><?php $cc2 = $counterg2; $ffx2 = $grade1 / $cc2; echo number_format((float)$ffx2, 2, '.', ''); ?></span></td>
                                        <td style="text-align:center;" ><span id="fvGoals"><?php $gfx2 = $ffx2 * 0.4; echo $fin2 = number_format((float)$gfx2, 2, '.', ''); ?></span><input type="hidden" name="apscore" class="boxPom" value="<?php echo $apscore; ?>"><input type="hidden" name="s5score" class="boxPom" value="<?php echo $s5score; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="text-align:center;"></td>
                                        <td style="text-align:right;font-weight:bold;">Total:</td>
                                        <td style="text-align:center;border-top:1px solid #fff;"><span id="bTotal"><?php echo $final2 = $fin1 + $fin2 ?></span></td>
                                    </tr>

                                    <tr>
                                        <td style="font-weight:bold;text-align:right;">Overall Performance : </td>
                                        <td style="text-align:center;" id="overallTotal">
                                            <?php
                                                echo $ggfin = $ffinal1 + $final2;
                                                // $ggfin = $ffinal1 + $final2;
                                                // echo number_format((float)$ggfin, 2, '.', '');

                                            ?></td>
                                        <td style="text-align:center;"></td>
                                        <td style="text-align:center;"></td>
                                    </tr>

                                    <tr>
                                        <td style="font-weight:bold;text-align:right;">Percentage Equivalent : </td>
                                        <td style="text-align:center;"><span id="perEqv"><?php $finincrease = round($ggfin / 5 * 100); echo $finincrease.'%';  ?></span></td>
                                        <td style="text-align:center;background-color:#fff;font-weight:bold;color:<?php echo $color1; ?>;" colspan="2"><span id="note"><?php echo $note1; ?></span></td>
                                    </tr>
                                </table>
                            <?php } ?>

                            <h4 style="text-align:center;"> Comment and Recommendation </h4>
                            <?php foreach ($checkEvaluation as $row) { ?>
                            <input type="hidden" value="<?php echo $row['appid']; ?>" name="appid" />
                            <input type="hidden" value="<?php echo $sub; ?>" name="sub" />
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
                            <!-- Comments and approval buttons -->
                                <?php if($flashRater == $sub) { $max1i = 1; ?><input type="hidden" name="final" value="Completed"><?php } else { $max1i = 2; ?> <input type="hidden" name="final" value="Incomplete"> <?php } ?>
                                <?php for ($i=1; $i <= $flashRater; $i++) {  ?>

                                    <?php //if ($pafad == 'rater' && $rtrstat == 'Approved' && $dhstat != $param1) { ?>
                                        <?php if($sub == $i) { ?>
                                            <!--<input type="file" class="width25 smltxtbox" id="upfile1" style="display:none;float:left;marign-right:5px;margin-top:-2.5px;" name="upfile" />-->
                                                <h3><strong>Equivalent system generated percentage increase: </strong> <span id="incVa">

                                                    <?php

                                                        $inc = $row['Increase'];
                                                        if(trim($row['promote']) != $row['randesc'] && !empty(trim($row['promote']))){
                                                            $inc = $row['Proincrease'];
                                                        }

                                                        echo round(($row['computed'] / 5) * $inc, 2);

                                                     ?>
                                                </span></h3>
                                                <p><strong>Final Recommendation;</strong> please fill up your desired recommendations below. This will override system generated percentage for salary increase.</p>
                                                <table>
                                                    <tr>
                                                        <td width="150px">Promotion To Level</td>
                                                        <td><input type="text" id="promoteto" class="promotion" name="promotion" list="ranks" value="<?php echo $row['promote']; ?>" autocomplete="off" onChange="" onClick="this.value = '';" data-promote="<?php echo $row['randesc']; ?>" width="200px"></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="150px">New Position Title</td>
                                                        <td>
                                                            <input type="text" id="promotetoPos" class="promotetoPos" name="promotetoPos" value="<?php echo $row['promotePos']; ?>">&nbsp;&nbsp;&nbsp;
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

                                                                foreach ($ranks as $rank) {

                                                                    ?>

                                                                    <option value="<?php echo $rank; ?>">
                                                                        <?php if($row['randesc'] == $rank) {echo '(current rank)'; } ?>
                                                                        <?php if(trim($row['promote']) == $rank) echo 'Approver Recommendation'; ?>
                                                                        <?php if($rank == $ranks[array_search($row['randesc'], $ranks) + 1]) echo '(System recommended)'; ?>

                                                                    </option>

                                                                    <?php
                                                                }

                                                            ?>
                                                            </datalist>
                                                        </td>
                                                    </tr>
                                                    <?php if($max1i == 1) { ?>
                                                        <tr>
                                                            <td width="150px">Salary Increase</td>
                                                            <td>
                                                                <input type="number" min="1" max="100" name="increase" value="<?php echo $row['recinc']; ?>" step="0.25"> %
                                                            </td>
                                                        </tr>
                                                            
                                                    <?php } else { ?>
                                                        <!-- <input type="hidden" name="increase" value=""> -->
                                                        <!-- <input type="hidden" name="promotion" value=""> -->
                                                    <?php } ?>
                                                </table>
                                                <p>
                                                    
                                                </p>
                                                

                                            

                                            <p><strong>Promotion History for the last 3 years :</strong> <br>  <?php if(!empty($row['ProHistory'])) echo $row['ProHistory']; else echo 'Not Set'; ?></p>
                                            <p><strong>Attendance and Punctuality History for the last 3 years :</strong> <br>  <?php if(!empty($row['APComment'])) echo $row['APComment']; else echo 'Not Set'; ?></p>
                                            <p><strong>Conduct and Compliance to the company policy History for the last 3 years :</strong> <br>  <?php if(!empty($row['CMComment'])) echo $row['CMComment']; else echo 'Not Set'; ?></p>

											<?php if(date("Y") == '2021' && false ){?>
												<?php if($max1i == 1) { ?>
												<p>Performance Summary: (This will only be displayed for the evaluator/1st approver and for the final approver)</p>

												<textarea name="remarks" class="remarks checker" style="width:98.4%;min-height:100px;" required><?php if($checkifsave == 2) { echo stripslashes($row['rcomm1']); } ?></textarea>
												<br /><br />
												<?php } ?>
											<?php } ?>

											<p><?php if($i == 1) { ?>Evaluator/Rater Comments: <?php } else { echo 'Approver '.$i.' Comments: '; } ?> (This will not be displayed in the ratee's form. The comments may only be viewed by the final approver. Other recommendations such as employee movements, etc may be stated here and will be subject for approval)</p>
                                            <input type="hidden" value="rater<?php echo $i; ?>" name="raterx">
                                            <textarea name="remarks" class="remarks checker" style="width:98.4%;min-height:100px;" required><?php echo $row['rcomm'.$i]; ?></textarea>
                                            <br /><br />
                                            <?php if ($pafad == 'rater' && $rtrstat == 'Approved' && $dhstat != $param1) : ?>
                                            <input type="submit" value="Approve Rating" name="updateAppraisal" class="smlbtn" id="approveapp" style="float:right;margin-right:10px;" />
											<a onclick="myFunction()" id="refrbtn" class="relapp smlbtn" style="float:right;margin-right:10px;display:none;background-color:#3EC2FB;"><i class="fa fa-undo"></i> Refresh page</a>
											<button type="submit" name="saveAppraisal2" class="saveapp smlbtn" id="saveapp2" style="float:right;background-color:#3EC2FB;margin-right:10px;">Save Appraisal</button>
                                            <a href="<?php echo WEB; ?>/pafview?groupid=<?php echo $groupid; ?>&pafad=rater&sub=<?php echo $sub; ?>&appid=<?php echo $appid; ?>&rid=<?php echo $rid; ?>" class="viewapp smlbtn" id="viewapp" style="display:none;float:right;background-color:#3EC2FB;margin-right:10px;">View Result</a>
                                            <br /><br />
                                            <script type="text/javascript">
                                                 jQuery(document).ready(function($) {

                                            </script>
                                            <?php endif; ?>
                                        <?php } else { ?>
                                            <?php if ($row['rcomm'.$i] != NULL && $sub == $i) { ?>
                                            <table style="width:99.5%;border:1px solid #fff;">
                                                <tr>
                                                    <th width="55%"><?php if($i == 1) { ?>Evaluator/Approver Comment <?php } else { echo 'Approver '.$i.' Comment'; } ?></th>
                                                    <?php if ($i != 1) { ?>
                                                    <th width="15%" style="text-align:center;">Recommended % Increase</th>
                                                    <th width="15%" style="text-align:center;">Recommended Promotion</th>
                                                    <?php } ?>
                                                    <th width="15%" style="text-align:center;">Status</th>

                                                </tr>
                                                <tr>
                                                    <td><?php echo nl2br($row['rcomm'.$i]); ?></td>
                                                    <?php if ($i != 1) { ?>
                                                    <td><?php echo $row['rincr'.$i] ? $row['rincr'.$i].'%' : ''; ?></td>
                                                    <td><?php echo $row['rprom'.$i] ? $row['rprom'.$i] : ''; ?></td>
                                                    <?php } ?>
                                                    <td style="background-color:#fff;color:#333;text-align:center;"><?php if($row['rstat'.$i] == 1) { echo '<div style="color:#00a569"><i class="fa fa-check"></i> Approved</div>'; } else { echo '<div style="color:#FF5656"><i class="fa fa-times"></i> Unapproved</div>'; } ?></td>
                                                </tr>
                                            </table>
                                            <br />
                                            <?php } elseif ($flashRater == $sub) { ?>
                                            <table style="width:99.5%;border:1px solid #fff;">
                                                <tr>
                                                    <th width="55%"><?php if($i == 1) { ?>Evaluator/Approver Comment <?php } else { echo 'Approver '.$i.' Comment'; } ?></th>
                                                    <th width="15%" style="text-align:center;">Status</th>
                                                </tr>
                                                <tr>
                                                    <td><?php echo nl2br($row['rcomm'.$i]); ?></td>
                                                    <td style="background-color:#fff;color:#333;text-align:center;"><?php if($row['rstat'.$i] == 1) { echo '<div style="color:#00a569"><i class="fa fa-check"></i> Approved</div>'; } else { echo '<div style="color:#FF5656"><i class="fa fa-times"></i> Unapproved</div>'; } ?></td>
                                                </tr>
                                            </table>
                                            <br />
                                        <?php } ?>
                                        <?php } ?>
                                    <?php if (!($pafad == 'rater' && $rtrstat == 'Approved' && $dhstat != $param1)) { ?>
                                        <?php if ($row['rcomm'.$i] != NULL && $sub == $i) { ?>
                                        <table style="width:99.5%;border:1px solid #fff;">
                                            <tr>
                                                <th width="55%"><?php if($i == 1) { ?>Evaluator/Approver Comment <?php } else { echo 'Approver '.$i.' Comment'; } ?></th>
                                                <th width="15%" style="text-align:center;">Status</th>
                                            </tr>
                                            <tr>
                                                <td><?php echo nl2br($row['rcomm'.$i]); ?></td>
                                                <td style="background-color:#fff;color:#333;text-align:center;"><?php if($row['rstat'.$i] == 1) { echo '<div style="color:#00a569"><i class="fa fa-check"></i> Approved</div>'; } else { echo '<div style="color:#FF5656"><i class="fa fa-times"></i> Unapproved</div>'; } ?></td>
                                            </tr>
                                        </table>
                                        <br />
                                        <?php } elseif($flashRater == $sub) { ?>
                                        <table style="width:99.5%;border:1px solid #fff;">
                                            <tr>
                                                <th width="55%"><?php if($i == 1) { ?>Evaluator/Approver Comment <?php } else { echo 'Approver '.$i.' Comment'; } ?></th>
                                                <th width="15%" style="text-align:center;">Status</th>
                                            </tr>
                                            <tr>
                                                <td><?php echo nl2br($row['rcomm'.$i]); ?></td>
                                                <td style="background-color:#fff;color:#333;text-align:center;"><?php if($row['rstat'.$i] == 1) { echo '<div style="color:#00a569"><i class="fa fa-check"></i> Approved</div>'; } else { echo '<div style="color:#FF5656"><i class="fa fa-times"></i> Unapproved</div>'; } ?></td>
                                            </tr>
                                        </table>
                                        <br />
                                        <?php } ?>
                                    <?php } ?>

                                <?php } ?>

                                <?php if ($row['rcomm'] != NULL) { ?>
                                <h4>Employee's/Ratee's Comment</h4>
                                    <table style="width:99.5%;border:1px solid #fff;">
                                        <tr>
                                            <td><?php echo nl2br($row['rcomm']); ?></td>
                                        </tr>
                                    </table>
                                <!-- End of ratees comment -->
                                <?php } ?>
                            <!-- end of comments and approval -->
                            <?php } ?>
                            </div>
                            </div>
                        <?php if ($pafad == 'rater' && $rtrstat == 'Approved' && $dhstat != $param1) { ?>
                        <!-- end of cheking if not yet approved by the division head -->
                            </form>
                        <?php } ?>

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
                                $('#approveapp').click(function(){

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
                                    if (hasNoValue) {
                                          $('#errorp').html('You must fill up all the fields, *Important so we can improve your subordinates capabilities');
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
                            });

                            function computeScore() {
                                // HR Total
                                var apscore = <?php echo $checkEvaluation[0]['apscore']; ?>;
                                var cmscore = <?php echo $checkEvaluation[0]['cmscore']; ?>;
                                var s5score = <?php echo $checkEvaluation[0]['S5Score']; ?>;
                                if(isNaN(apscore) || apscore == undefined) apscore = 0;
                                if(isNaN(cmscore) || cmscore == undefined) cmscore = 0;
                                if(isNaN(s5score) || s5score == undefined) s5score = 0;

                                var apscore_ = parseFloat(( (apscore) * 0.1 ).toFixed(2))
                                var cmscore_ = parseFloat(( (cmscore) * 0.15 ).toFixed(2))
                                var s5score_ = parseFloat(( (s5score) * 0.05 ).toFixed(2))
                                var hrTotal = apscore_ + cmscore_ + s5score_;

                                // PCC
                                var $pcc_total = 0;
                                $pcc_scores = document.getElementsByName('caAp[]');
                                for($i = 0; $i < $pcc_scores.length; $i++){
                                    $pcc_total = $pcc_total + parseInt($pcc_scores[$i].value);
                                }

                                var pcc_ave = parseFloat(($pcc_total / $pcc_scores.length).toFixed(2));
                                $('#rateCA').html(pcc_ave);
                                $('#fvCA').html((pcc_ave * 0.3).toFixed(2));

                                // Goals
                                var goal_total = 0;
                                var goal_scores = document.getElementsByName('g2Title1[]');

                                for($i = 0; $i < goal_scores.length; $i++){
                                    var n = 'input[name="g2Rad' + ($i+1).toString() + '"]:checked';
                                    goal_total = goal_total  + parseInt($(n).val());
                                }

                                var goal_ave = parseFloat((goal_total/goal_scores.length).toFixed(2))
                                $('#rateGoals').html(goal_ave);
                                $('#fvGoals').html((goal_ave * 0.4).toFixed(2));

                                $('#bTotal').html((goal_ave * 0.4 + pcc_ave * 0.3).toFixed(2));

                                // Overall Score
                                var grand_score = parseFloat(((hrTotal) + (pcc_ave * 0.3) + (goal_ave * 0.4)).toFixed(2));
                                $('#overallTotal').html(grand_score);

                                // Percentage
                                var grand_score_percentage = parseFloat(((grand_score/5) * 100).toFixed(2));
                                $('#perEqv').html(grand_score_percentage);

                                // Increase
                                var reg_increase = <?php echo $checkEvaluation[0]['Increase']; ?>;
                                var pro_increase = <?php echo $checkEvaluation[0]['Proincrease']; ?>;
                                var inc = reg_increase;
                                var rank_current = $('#promoteto').data('promote');
                                var rank_promotion = $.trim($('#promoteto').val());
                                if(rank_current != rank_promotion && rank_promotion != '' && rank_promotion != undefined)
                                    inc = pro_increase;

                                $('input[name="increase"]').attr({
                                    max: inc
                                });

                                var percent_increase = parseFloat(((grand_score / 5) * (inc / 100) * 100).toFixed(2));
                                $('#incVa').html(percent_increase);

                                for($i = 1; $i <= 5; $i++){
                                    $('#o' + $i).attr({
                                        style: 'display:none',
                                    });
                                }

                                var note = ''
                                if(grand_score == 5){
                                    note = '<span style="color:#06A716 ">(<i class="fa fa-thumbs-up"></i>) According to your rating you are Exceptional.</span>';
                                    $('#o5').removeAttr('style');
                                }else if(grand_score >= 4){
                                    note = '<span style="color:#06A716 ">(<i class="fa fa-thumbs-up"></i>) According to your rating you Exceeds Expectations.</span>';
                                    $('#o4').removeAttr('style');
                                }else if(grand_score >= 3){
                                    note = '<span style="color:#06A716 ">(<i class="fa fa-thumbs-up"></i>) According to your rating you Meets Expectations.</span>';
                                    $('#o3').removeAttr('style');
                                }else if(grand_score >= 2){
                                    note = '<span style="color:#06A716 ">(<i class="fa fa-thumbs-up"></i>) According to your rating you still Need Improvements.</span>';
                                    $('#o2').removeAttr('style');
                                }else{
                                    note = '<span style="color: #A70606">(<i class="fa fa-thumbs-down"></i>) According to your rating you have No Evidence of Skills</span>';
                                    $('#o1').removeAttr('style');
                                }



                                $('#note').html(note);

                            }

                            $(document).on('change', '#promoteto', function(event) {
                                computeScore();
                            });

                            $('select[name="caAp[]"]').on('change', function(){
                                computeScore();
                            });

                            $(document).on('change', 'input', function(event) {
                                computeScore();
                            });

                            $(document).on('change', 'input[name="increase"]', function(event) {
                                computeScore();
                            });

                        </script>


                <?php } elseif (count($viewAppraisal) > 0 && $pafad == 'ratee') { ?>

                        <form id="frm_pafview" class="formg" method="post" enctype="multipart/form-data">
                        <!-- Checks if user is Ratee -->
                        <a href="<?php echo WEB; ?>/paf?groupid=<?php echo $groupid; ?>"><i class="mediumtext fa fa-arrow-left" style="color:#fff;opacity:.8;"></i></a> <b class="mediumtext lorangetext">Ratee - Appraisal Rating Result</b><br>
                        <!--<p>You're a ratee!</p>-->
                        <div >
                            <?php foreach($viewAppraisal as $row) { ?>
                            <input type="hidden" value="<?php echo $row['pafid']; ?>" name="pafid" />
                            <hr />
                            <table style="width:100%;">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="font-weight:italic;">(<?php echo $row['randesc']; ?>) <!--<span style="font-weight:normal;"></span>--></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><b class="smallesttext lwhitetext">Employee Name:</b> <span style="font-weight:normal;"><?php echo ucwords(strtolower($row['rfname'].' '.$row['rlname'])); ?></span></td>
                                        <td><b class="smallesttext lwhitetext">Department:</b> <span style="font-weight:normal;"><?php echo ucwords(strtolower($row['depdesc'])); ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><b class="smallesttext lwhitetext">Designation:</b> <span style="font-weight:normal;"><?php echo ucwords(strtolower($row['posdesc'])); ?></span></td>
                                        <td><b class="smallesttext lwhitetext">Date Hired:</b> <span style="font-weight:normal;"><?php echo date('Y-m-d', strtotime($row['hdate'])); ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><b class="smallesttext lwhitetext">Period:</b> <span style="font-weight:normal;">From | <u><?php echo date('Y-m-d', strtotime($row['perfrom']));//echo '2019-01-01';  ?></u> To | <u><?php echo date('Y-m-d', strtotime($row['perto'])); //echo '2019-12-31';  ?></u></span></td>
                                        <td><b class="smallesttext lwhitetext">Date Appraisal:</b> <span style="font-weight:normal;"><?php echo date('Y-m-d', strtotime($row['appdt'])); ?></span></td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr />
                            <?php } ?>
                            <div class="print" style="overflow-y:scroll;max-height:514px;margin-top:10px;">
                            <!-- Competency Assessment -->
                            <h4>I. Comptency Assessment</h4>

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

                            <table class="tdata" cellspacing="0" width="98%" border="0" style="height:auto;">
                                <tr>
                                    <th width="5"></th>
                                    <th style="text-align:left;width:25%;">Competency</th>
                                    <th style="text-align:center;width:35px;">Required Proficiency</th>
                                    <th style="text-align:center;width:35px;">Actual Proficiency</th>
                                    <th style="text-align:center;width:35px;">Gaps</th>
                                    <th style="text-align:center;width:210px;">Remarks/Training</th>
                                </tr>
                                <?php $countap = 1; foreach ($checkEvalCA as $key) { $grade0 += $key['ActProficiency']; ?>
                                    <?php if($type != $key['Type']){ ?>
                                            <?php if($key['Type'] == 'CORE'){ ?>
                                            <tr>
                                                <th colspan="6"><u>Core</u></th>
                                            </tr>
                                            <?php } else { ?>
                                            <tr>
                                                <th colspan="6"><u>Job-Specific</u></th>
                                            </tr>
                                            <?php } ?>
                                            <?php $type = $key['Type']; ?>
                                    <?php } ?>
                                <tr>
                                    <td><?php echo $countap++.'. '; ?></td>
                                    <td><?php echo ucwords(strtolower($key['Competency'])); ?></td>
                                    <td style="text-align:center;width:25px;"><?php echo $key['ReqProficiency']; ?></td>
                                    <td style="text-align:center;width:25px;"><?php echo $key['ActProficiency']; ?></td>
                                    <td style="text-align:center;width:25px;"><?php if ($key['Gaps'] < 0) { echo $key['Gaps']; } ?></td>
                                    <td style="text-align:left;width:210px;"><?php echo $key['Remarks']; ?></td>
                                </tr>
                                <?php } ?>
                            </table>

                            <?php if(count($checkEvalGC) > 0){ ?>
                            <!-- Goals Covered  Under The Evaluation Period -->
                            <h4>II. Goals Covered Under The Evaluation Period</h4>
                            <table class="tdata" cellspacing="0" width="98%" border="0" style="height:auto;">
                                <tr>
                                    <th style="text-align:left;width:25%;">Goals</th>
                                    <th style="text-align:center;width:45px;">E<br />(5)</th>
                                    <th style="text-align:center;width:45px;">EE<br />(4)</th>
                                    <th style="text-align:center;width:45px;">ME<br />(3)</th>
                                    <th style="text-align:center;width:45px;">NI<br />(2)</th>
                                    <th style="text-align:center;width:45px;">U<br />(1)</th>
                                    <th style="text-align:center;">Remarks</th>
                                </tr>
                                <?php $counterg2 = 0; foreach ($checkEvalGC as $key) { $grade1 += $key['Grade']; $counterg2++; ?>
                                <tr>
                                    <td><?php echo $counterg2.'. '.$key['Goals']; ?></td>
                                    <td style="text-align:center;"><?php if($key['Grade'] == 5) { echo '<i class="fa fa-check"></i>'; } ?></td>
                                    <td style="text-align:center;"><?php if($key['Grade'] == 4) { echo '<i class="fa fa-check"></i>'; } ?></td>
                                    <td style="text-align:center;"><?php if($key['Grade'] == 3) { echo '<i class="fa fa-check"></i>'; } ?></td>
                                    <td style="text-align:center;"><?php if($key['Grade'] == 2) { echo '<i class="fa fa-check"></i>'; } ?></td>
                                    <td style="text-align:center;"><?php if($key['Grade'] == 1) { echo '<i class="fa fa-check"></i>'; } ?></td>
                                    <td style="text-align:left;"><?php echo $key['Comments']; ?></td>
                                </tr>
                                <?php } ?>
                            </table><br />
                            <?php } ?>

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

                            <br />
                            <table class="tdata" cellspacing="0" style="width:99%;">
                                <thead>
                                    <tr>
                                        <th style="text-align:left;"><p style="font-size:10px;"><b>Overall Rating <span style="font-size:9px;">(Based on Generated Score and Combined Score of Part I and II )</span></b></p></th>
                                        <th>E<br />(5)</th>
                                        <th>EE<br />(4)</th>
                                        <th>ME<br />(3)</th>
                                        <th>NI<br />(2)</th>
                                        <th>U<br />(1)</th>
                                        <th>Comment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($viewAppraisal as $row) { ?>
                                    <tr>
                                        <td width="21%;">
                                            <p style="font-size:10px;">
                                                <!--<b>Overall Rating <span style="font-size:9px;">(Based on Parts I and II)</span></b><br />-->
                                                Conduct/Memo = 15%<br>
                                                Attendance & Punctuality = 10%<br>
                                                Compliance to the 5S + 2 = 5%<br>
                                                Performance Goals = 70%<br>
                                                <!--(Please check one of the appropriate box)-->
                                            </p>
                                        </td>
                                        <td width="5%;" style="text-align:center;">
                                            <span id="o5" style="<?php if($row['computed'] != 5) echo "display:none" ?>"><i class="fa fa-check"></i></span>
                                            <?php if($row['computed'] == 5) { ?>  <?php $note1 = '(<i class="fa fa-thumbs-up"></i>) According to your rating you are Exceptional.'; $color1 = '#06A716'; } ?>
                                        </td>
                                        <td  width="5%;" style="text-align:center;">
                                            <span id="o4" style="<?php if($row['computed'] < 5 && $row['computed'] >= 4) echo ''; else echo "display:none" ?>"><i class="fa fa-check"></i></span>
                                            <?php if($row['computed'] < 5 && $row['computed'] >= 4) { ?>  <?php $note1 = '(<i class="fa fa-thumbs-up"></i>) According to your rating you Exceeds Expectations.'; $color1 = '#06A716'; } ?>
                                        </td>
                                        <td width="5%;" style="text-align:center;">
                                            <span id="o3" style="<?php if($row['computed'] < 4 && $row['computed'] >= 3) echo ''; else echo "display:none" ?>"><i class="fa fa-check"></i></span>
                                            <?php if($row['computed'] < 4 && $row['computed'] >= 3) { ?> <?php $note1 = '(<i class="fa fa-thumbs-up"></i>) According to your rating you Meets Expectations.'; $color1 = '#06A716'; } ?>
                                        </td>
                                        <td width="5%;" style="text-align:center;">
                                            <span id="o4" style="<?php if($row['computed'] < 3 && $row['computed'] >= 2) echo ''; else echo "display:none" ?>"><i class="fa fa-check"></i></span>
                                            <?php if($row['computed'] < 3 && $row['computed'] >= 2) { ?> <?php $note1 = '(<i class="fa fa-thumbs-up"></i>) According to your rating you still Need Improvements.'; $color1 = '#06A716'; } ?>
                                        </td>
                                        <td width="5%;" style="text-align:center;">
                                            <span style="<?php if($row['computed'] < 2 && $row['computed'] >= 1) echo ''; else echo "display:none" ?>"><i class="fa fa-check"></i></span>
                                            <?php if($row['computed'] < 2 && $row['computed'] >= 1) { ?><?php $note1 = '(<i class="fa fa-thumbs-down"></i>) According to your rating you have No Evidence of Skills'; $color1 = '#A70606'; } ?>
                                        </td>
                                        <td width="20%;" style="text-align:center;">
                                            <?php echo nl2br($row['orcomm']); ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <?php if(count($checkEvalGF) > 0) { ?>
                            <!-- Part III - Goals For The Coming Year Or Evaluation Period  -->
                            <h4>III. Goals For The Coming Year Or Evaluation Period</h4>
                            <table class="tdata" cellspacing="0" width="98%" border="0" style="height:auto;">
                                <tr>
                                    <th width="5"></th>
                                    <th style="text-align:left;width:50%;">Goals</th>
                                    <th style="text-align:left;width:50%;">Measure of Success</th>
                                </tr>
                                <?php $count = 1; ?>
                                <?php foreach ($checkEvalGF as $key) { ?>
                                <tr>
                                    <td><?php echo $count++.'.'; ?></td>
                                    <td style="text-align:left;"><?php echo $key['Goals']; ?></td>
                                    <td style="text-align:left;"><?php echo $key['MeasureOSuccess']; ?></td>
                                </tr>
                                <?php } ?>
                            </table><br />
                            <?php } ?>

                            <?php if(count($checkEvalID) > 0) { ?>

                            <!-- Part IV - Individual Development Plan  -->
                            <h4>IV. Individual Development Plan</h4>
                            <table class="tdata" cellspacing="0" width="98%" border="0" style="height:auto;">
                                <tr>
                                    <th width="5"></th>
                                    <th style="text-align:left;width:30%;">Summary of Competency Gaps</th>
                                    <th style="text-align:center;width:35px;">RP</th>
                                    <th style="text-align:center;width:35px;">AP</th>
                                    <th style="text-align:center;width:35px;">Gaps</th>
                                    <th style="text-align:center;">Development Action</th>
                                </tr>
                                <?php $count = 1; ?>
                                <?php foreach ($checkEvalID as $key) { ?>
                                <tr>
                                    <td><?php echo $count++.'.'; ?></td>
                                    <td><?php echo $key['SummaryOCGaps']; ?></td>
                                    <td style="text-align:center;width:25px;"><?php echo $key['Required']; ?></td>
                                    <td style="text-align:center;width:25px;"><?php echo $key['Actual']; ?></td>
                                    <td style="text-align:center;width:25px;"><?php echo $key['Gaps']; ?></td>
                                    <td style="text-align:center;"><?php echo $key['DevelopmentAction']; ?></td>
                                </tr>
                                <?php } ?>
                            </table><br />
                            <?php } ?>

                             <?php foreach($viewAppraisal AS $row) { ?>
                                <?php
                                    $cmscore = $row['cmscore'] * 0.15;
                                    $apscore = $row['apscore'] * 0.10;
                                    $s5score = $row['S5Score'] * 0.05;
                                ?>
                                <h4 style="text-align:center;"> Final Summary </h4>
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
                                        <td>Conduct and Compliance to the company policy </td>
                                        <td style="text-align:center;">15%</td>
                                        <td style="text-align:center;"><?php echo $row['cmscore']; ?></td>
                                        <td style="text-align:center;"><?php echo $cmscore; ?><input type="hidden" name="cmscore" class="boxPom" value="<?php echo $cmscore; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Attendance and Punctuality</td>
                                        <td style="text-align:center;">10%</td>
                                        <td style="text-align:center;"><?php echo $row['apscore']; ?></td>
                                        <td style="text-align:center;"><?php echo $apscore; ?><input type="hidden" name="apscore" class="boxPom" value="<?php echo $apscore; ?>"></td>
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
                                        <td style="text-align:center;border-top:1px solid #fff;"><?php echo $ffinal1 = $cmscore + $apscore + $s5score;  ?></td>
                                    </tr>
                                </table><br />

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
                                        <td style="text-align:center;"><?php $cc1 = $countap - 1; $ffx1 = $grade0 / $cc1; echo number_format((float)$ffx1, 2, '.', ''); ?></td>
                                        <td style="text-align:center;"><?php $gfx1 = $ffx1 * 0.3; echo $fin1 = number_format((float)$gfx1, 2, '.', ''); ?><input type="hidden" name="cmscore" class="boxPom" value="<?php echo $cmscore; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Goals Covered Under The Evaluation Period</td>
                                        <td style="text-align:center;">40%</td>
                                        <td style="text-align:center;"><?php $cc2 = $counterg2; $ffx2 = $grade1 / $cc2; echo number_format((float)$ffx2, 2, '.', ''); ?></td>
                                        <td style="text-align:center;"><?php $gfx2 = $ffx2 * 0.4; echo $fin2 = number_format((float)$gfx2, 2, '.', ''); ?><input type="hidden" name="apscore" class="boxPom" value="<?php echo $apscore; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="text-align:center;"></td>
                                        <td style="text-align:right;font-weight:bold;">Total:</td>
                                        <td style="text-align:center;border-top:1px solid #fff;">
                                            <?php

                                            // echo $final2 = $fin1 + $fin2;
                                            $final2 = $gfx1 + $gfx2;
                                            echo number_format((float)$final2, 2, '.', '');
                                            ?>


                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="font-weight:bold;text-align:right;">Overall Performance : </td>
                                        <td style="text-align:center;"><?php echo $ggfin = $ffinal1 + $final2; ?></td>
                                        <td style="text-align:center;"></td>
                                        <td style="text-align:center;"></td>
                                    </tr>

                                    <tr>
                                        <td style="font-weight:bold;text-align:right;">Percentage Equivalent : </td>
                                        <td style="text-align:center;"><?php echo round($ggfin / 5 * 100).'%';  ?></td>
                                        <td style="text-align:center;background-color:#fff;font-weight:bold;color:<?php echo $color1; ?>;" colspan="2"><?php echo $note1; ?></td>
                                    </tr>
                                </table>
                            <?php } ?>

                            <?php foreach($viewAppraisal AS $row) { ?>
                                <?php if ($row['rcomm'] != NULL) { ?>
                                <h4>Employee's/Ratee's Comment</h4>
                                    <table style="width:99.5%;border:1px solid #fff;">
                                        <tr>
                                            <td><?php echo nl2br($row['rcomm']); ?></td>
                                        </tr>
                                    </table>
                                <!-- End of ratees comment -->
                                <?php } else { ?>
                                        <input type="hidden" value="<?php echo $row['appid'] ?>" name="appid" />
                                        <input type="hidden" value="<?php echo $row['pafid']; ?>" name="pafid" />
                                        <h4>Employee/Ratee Comments</h4>
                                        <textarea name="remarks" class="remarks" style="width:98.4%;min-height:100px;" required><?php echo $row['rcomm']; ?></textarea>
                                        <!--<p>I have met with the above-named employee to discuss and review this performance appraisal.</p>-->
                                        <br /><br /><input type="submit" value="Accept Result" name="acceptResultbtn" class="smlbtn" id="sendapp" style="float:right;margin-right:10px;" />
                                <?php } ?>
                            <!-- End of foreach looping -->
                            <?php } ?>
                            </div>
                        </div>
                        <!-- end of ratee form -->
                        </form>

                        <div id="alert"></div>

                <?php } else { ?>

                    <p style="text-align:center;background-color:#fff;font-weight:bold;color:#3063a4;padding:6px 0;font-size:1em;margin-top:25px;">You have no rights to view this appraisal result.</p>

                <?php } ?>
                </div>
            </div>
        </div>



    <!--

        Status

        -Recommendation for Promotion W/ Increase
        -Recommendation for Promotion W/o Increase
        -Recommendation for Salary Increase

    -->
