<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<style>
        .loading-screen {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .spinner {
        border: 4px solid rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        border-top: 4px solid #3498db;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
        margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        textarea.ng-invalid,
        input.ng-invalid,
        select.ng-invalid{
            background-color: hsl(0deg 25% 50%);
        }

        .ng-invalid::placeholder{
            color: white;
        }

        .jobdesc-popup {
            display: none;
            position: absolute;
            padding: 10px;
            background-color: #555;
            color: #fff;
            border-radius: 3px;
            z-index: 10000
        }
</style>

<div class="rightsplashtext lefttalign">

    <div ng-app='myApp' ng-controller='myCtrl' id="paf" class="mainbody lefttalign whitetext">
        <table style="width:99%;" ng-show="record === ''">
            <tr style="background-color:#fff;">
                <td colspan="7" style="text-align:center;font-weight:bold;color:#A70606;"> You do not have permission to view this evaluation </td>
            </tr>
        </table>
        <form  name="myForm" ng-show="record != ''">
            <div class="loading-screen" ng-show="loading">
                <div class="spinner"></div>
                <p>Please wait...</p>
            </div>

            <div ng-show="!loading">
                <h2 class="mediumtext lorangetext">
                    <a href="<?php echo WEB; ?>/pms"><i class="mediumtext fa fa-arrow-left"
                            style="color:#fff;opacity:.8;"></i> </a> Performance Appraisal Form
                </h2>
                <hr>
                <table style="width:100%;">
                    <thead>
                        <tr>
                            <th colspan="2" style="font-weight:italic;">For (<span ng-bind="record.Rank"></span>) <span
                                    style="font-weight:normal;">*Confidential</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><b class="smallesttext lwhitetext">Employee Name:</b> <span style="font-weight:normal;"
                                    ng-bind="record.FullName"></span></td>
                            <td><b class="smallesttext lwhitetext">Department:</b> <span style="font-weight:normal;"
                                    ng-bind="record.Department"></span></td>
                        </tr>
                        <tr>
                            <td><b class="smallesttext lwhitetext">Designation:</b> <span style="font-weight:normal;"
                                    ng-bind="record.Position"></span></td>
                            <td><b class="smallesttext lwhitetext">Date Hired:</b> <span style="font-weight:normal;"
                                    ng-bind="record.HireDate"></span></td>
                        </tr>
                        <tr>
                            <td>

                                <b class="smallesttext lwhitetext">Period:</b>

                                <span style="font-weight:normal;">
                                    From | <u ng-bind="formatDate(record.group.PeriodFrom) |  date:'yyyy-MM-dd'"></u>
                                    To | <u ng-bind="formatDate(record.group.PeriodTo) |  date:'yyyy-MM-dd'"></u>
                                </span>

                            </td>
                            <td><b class="smallesttext lwhitetext">Appraisal Date:</b> <span style="font-weight:normal;"
                                    ng-bind="formatDate(record.group.AppraisalDate) |  date:'yyyy-MM-dd'"></span></td>
                        </tr>
                    </tbody>
                </table>
                <hr/>

                <div class="print" style="overflow-x:none;overflow-y:scroll;max-height:514px;">
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

                    <div ng-show="record.competencies.length > 0">
                        <hr>
                        <br />
                        <p>
                            <b class="smalltext lwhitetext">Part I - Staff Member's Competencies Assessment</b><br />
                        </p>
                        <div style="width:98%;border: 2px solid #fff;padding:2px;margin-bottom:15px;">
                            <p><b>Rating Scale:</b></p>
                            <p>Use the following descriptions to rate the staff member's performance for each of the required competencies.</p>
                            <table style="width:100%;">
                                <tbody>
                                    <tr>
                                        <td>5 - <b>E</b>xceptional</td>
                                        <td style="text-align:center;"></td>
                                    </tr>
                                    <tr>
                                        <td>4 - <b>E</b>xceeds <b>E</b>xpectations</td>
                                        <td style="text-align:center;"></td>
                                    </tr>
                                    <tr>
                                        <td>3 - <b>M</b>eets <b>E</b>xpectations</td>
                                        <td style="text-align:center;"></td>
                                    </tr>
                                    <tr>
                                        <td>2 - <b>N</b>eeds <b>I<b/>mprovement</td>
                                        <td style="text-align:center;"></td>
                                    </tr>
                                    <tr>
                                        <td>1 - Does Not Meet Expectations</td>
                                        <td style="text-align:center;"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <table id="comass" border="0" cellspacing="0" class="tdata" style="width:99%;">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th width="60%;">Goals</th>
                                    <th width="15%;">Required Proficiency</th>
                                    <th width="15%;">Actual Proficiency</th>
                                    <th width="15%;">Gaps</th>
                                    <!-- <th width="30%;">Training/Remarks</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th colspan="5"><u>Core</u></th>
                                </tr>
                                <tr ng-repeat="competency in record.competencies" ng-if="competency.Type == 'CORE'">
                                    <td style="vertical-align: top;"><span ng-bind="$index + 1"></span></td>
                                    <td>
                                        <b ng-bind="competency.Competency"></b>
                                        <br>
                                        <br>
                                        <span ng-bind-html="displayDescription(competency.Description)"></span>
                                        <!-- <i ng-show="competency.Type == 'CORE'" class="jobdesc-btn" style="cursor: pointer"> Click to see description </i>
                                        <div class="jobdesc-popup">
                                            <span  ng-bind="competency.Description"></span>
                                        </div> -->
                                        <br><br>
                                        <strong>Remarks</strong> <br>
                                        <textarea ng-model="competency.Remarks" cols="60" rows="3" placeholder="Add your remarks" ng-disabled="is_approved" required class="checker caRemarks" minlength="10"></textarea>
                                    </td>
                                    <td style="text-align:center;width:25px;">
                                        <span ng-bind="competency.RequiredProficiency"></span>
                                    </td>
                                    <td style="text-align:center;width:25px;">
                                        <input type="number" clas="width50 smltxtbox actp " min="1" max="5" onkeypress="return (event.charCode >= 49 && event.charCode <= 53) || event.charCode==8" onKeyDown="if(this.value.length==1 && event.keyCode!=8 ) return false;" onfocusin="(this.value == 0) ? this.value = '' : false" onfocusout="(this.value == '') ? this.value = 0 : false" ng-model="competency.ActualProficiency" ng-disabled="is_approved" ng-change="competency.Gaps = compute_gaps(competency); updateRecord()" required>
                                    </td>
                                    <td style="text-align:center;width:25px;">
                                        <span ng-bind="competency.Gaps"></span>
                                    </td>
                                    <!-- <td style="text-align:left;">
                                        <textarea ng-model="competency.Remarks" cols="20" rows="2" placeholder="Add your remarks" ng-disabled="is_approved" required class="checker caRemarks"></textarea>
                                    </td> -->
                                    
                                </tr>

                                <tr>
                                    <th colspan="5"><u>Job-Specific</u></th>
                                </tr>

                                <tr ng-repeat="competency in record.competencies" ng-if="competency.Type == 'JOB-SPECIFIC'">
                                    <td style="vertical-align: top;"><span ng-bind="$index + 1"></span></td>
                                    <td>
                                        <b ng-bind="competency.Competency" ></b>
                                        <br><br>
                                        <strong>Remarks</strong><br>
                                        <textarea ng-model="competency.Remarks" cols="60" rows="2" placeholder="Add your remarks" ng-disabled="is_approved" required class="checker caRemarks" minlength="10"></textarea>
                                    </td>
                                    <td style="text-align:center;width:25px;">
                                        <span ng-bind="competency.RequiredProficiency"></span>
                                    </td>
                                    <td style="text-align:center;width:25px;">
                                        <input type="number" clas="width50 smltxtbox actp " min="1" max="5" onkeypress="return (event.charCode >= 49 && event.charCode <= 53) || event.charCode==8" onKeyDown="if(this.value.length==1 && event.keyCode!=8 ) return false;" onfocusin="(this.value == 0) ? this.value = '' : false" onfocusout="(this.value == '') ? this.value = 0 : false" ng-model="competency.ActualProficiency" ng-disabled="is_approved" ng-change="updateRecord()" required>
                                    </td>
                                    <td style="text-align:center;width:25px;">
                                        <span ng-bind="competency.Gaps"></span>
                                    </td>
                                    <!-- <td style="text-align:left;">
                                        <textarea ng-model="competency.Remarks" cols="20" rows="2" placeholder="Add your remarks" ng-disabled="is_approved" required class="checker caRemarks"></textarea>
                                    </td> -->
                                </tr>

                            </tbody>

                        </table>
                    </div>

                    <div ng-show="record.competencies.length == 0">
                        <hr>
                        <table style="width:99%;">
                            <tr style="background-color:#fff;">
                                <td colspan="7" style="text-align:center;font-weight:bold;color:#A70606;"> Kindly inform the HR for the Competency Assessment Form </td>
                            </tr>
                        </table>
                    </div>

                    <div>
                    <br />
                        <p>
                            <b class="smalltext lwhitetext">Part II - Goals Covered Under the Evaluation Period</b><br />
                        </p>

                    </div>
                    <table id="gcutep" border="0" cellspacing="0" class="tdata" style="width:99%;">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Goals</th>
                                <th width="40px">Rating</th>
                                <!-- <th>Comments</th> -->
                            </tr>
                        </thead>
                        <tbody id="jsgoals">
                            <tr ng-repeat="goal in record.goals">
                                <td style="vertical-align: top;"><span ng-bind="$index+1"></span></td>
                                <td style="">
                                    <textarea class="checker" cols="80" rows="3" ng-model="goal.Goals" ng-readonly="goal.id != null || goal.Goals == '8 hrs mandatory training' || is_approved" placeholder="Provide SMART Goal" ng-required="goal.Goals != '8 hrs mandatory training'" minlength="goal.Goals != '8 hrs mandatory training' && goal.id == null ? 10 : ''"></textarea>
                                    
                                    <br>
                                    <br>
                                    <b ng-show="goal.Goals != '8 hrs mandatory training'">Measure of Success</b><br>
                                    <textarea class="checker" cols="80" rows="3" ng-required="goal.Goals != '8 hrs mandatory training' && goal.id == null" ng-model="goal.MeasureOfSuccess" ng-disabled="goal.id != null || goal.Goals == '8 hrs mandatory training' || is_approved"  ng-show="goal.Goals != '8 hrs mandatory training' && goal.id == null" placeholder="Provide measure of success" ng-minlength="goal.Goals != '8 hrs mandatory training' && goal.id == null ? 10 : ''"></textarea>
                                    <span ng-bind="goal.MeasureOfSuccess"  ng-show="goal.Goals != '8 hrs mandatory training' && goal.id != null"></span>
                                    <br> <br>
                                    <strong>Comments</strong><br>
                                    <textarea class="checker" cols="80" rows="2" ng-model="goal.Comments" placeholder="Provide your comments" ng-disabled="is_approved" minlength="10" required></textarea>
                                    <span ng-show="goal.id == null && goal.Goals != '8 hrs mandatory training'" >
                                    <br><br>
                                    <a class="smlbtn" id="delrowg" style="background-color:#D20404;" ng-click="deleteGoal($index)">Delete</a>
                                    </span>
                                    
                                </td>
                                <td style="text-align:center;">
                                    <input type="number" clas="width50 smltxtbox actp " min="1" max="5" onkeypress="return (event.charCode >= 49 && event.charCode <= 53) || event.charCode==8" onKeyDown="if(this.value.length==1 && event.keyCode!=8 ) return false;" onfocusin="(this.value == 0) ? this.value = '' : false" onfocusout="(this.value == '') ? this.value = 0 : false" ng-model="goal.Grade" ng-disabled="goal.Goals == '8 hrs mandatory training' || is_approved" ng-change="updateRecord()" required>
                                </td>
                                <!-- <td style="text-align:center;">
                                    <textarea class="checker" cols="20" rows="2" ng-model="goal.Comments" placeholder="Provide your comments" ng-disabled="is_approved"></textarea>
                                </td> -->
                            </tr>
                        </tbody>
                    </table>
                    <br />
                    <a class="smlbtn" id="addrowg" style="background-color:#3EC2FB;" ng-show="!is_approved" ng-click="add_goal()">Add Row</a>
                    <!-- <a class="smlbtn" id="delrowg" style="background-color:#D20404;" >Delete</a>  -->
                    <i>Note: Don't use word with 'mandatory training' as new goal/objective</i>
                    <br /><br />

                    <p>
                        <b class="smalltext lwhitetext">Part III - Goals For The Coming Year Or Evaluation Period</b><br />
                    </p>
                    <table id="gftcyoep" border="0" cellspacing="0" class="tdata" style="width:99%;">
                        <thead>
                            <tr>
                                <th></th>
                                <th width="50%;">Goals</th>
                                <th width="50%;">Measure of Success</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="goal in record.goals_next">
                                <td>
                                    <a class="smlbtn"style="background-color:#D20404;" ng-click="deleteNextGoal($index)" ng-show="!is_approved">Delete</a>
                                </td>
                                <td style="text-align:center;">
                                    <textarea class="checker" cols="40" rows="5" minlength="10" ng-model="goal.Goals" required ng-disabled="is_approved"></textarea>
                                </td>
                                <td style="text-align:center;">
                                    <textarea class="checker" cols="40" rows="5" minlength="10" ng-model="goal.MeasureOfSuccess" required ng-disabled="is_approved"></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <a class="smlbtn"style="background-color:#3EC2FB;" ng-show="!is_approved" ng-click="addNextGoal()">Add Row</a>
                    <hr>
                    <table style="border:2px solid #fff;width:99%;" ng-show="record.AttendancePunctualityScore > 0 && record.ConductMemoScore > 0 && record.FiveSScore > 0">
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
                            <td style="text-align:center;"><span ng-bind="record.AttendancePunctualityScore"></span></td>
                            <td style="text-align:center;"><span ng-bind="(record.AttendancePunctualityScore*10/100).toFixed(2)"></span></td>
                        </tr>
                        <tr>
                            <td>Conduct and Compliance to the company policy <br>
                            <td style="text-align:center;">15%</td>
                            <td style="text-align:center;"><span ng-bind="record.ConductMemoScore"></span></td>
                            <td style="text-align:center;"><span ng-bind="(record.ConductMemoScore*15/100).toFixed(2)"></span></td>
                        </tr>

                        <tr>
                            <td>Customer Experience</td>
                            <td style="text-align:center;">5%</td>
                            <td style="text-align:center;"><span ng-bind="record.FiveSScore"></span></td>
                            <td style="text-align:center;"><span ng-bind="(record.FiveSScore*5/100).toFixed(2)"></span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:center;"></td>
                            <td style="text-align:right;font-weight:bold;">Total:</td>
                            <td style="text-align:center;border-top:1px solid #fff;"><span ng-bind="partHRScore.toFixed(2)"></span></td>
                        </tr>
                    </table>      
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
                            <td style="text-align:center;"><span ng-bind="totalCompetency"></span></td>
                            <td style="text-align:center;"><span ng-bind="round2((totalCompetency*30)/100)"></span></td>
                        </tr>
                        <tr>
                            <td>Goals Covered Under The Evaluation Period</td>
                            <td style="text-align:center;">40%</td>
                            <td style="text-align:center;"><span ng-bind="totalGoal"></span></td>
                            <td style="text-align:center;"><span ng-bind="round2((totalGoal*40)/100)"></span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:center;"></td>
                            <td style="text-align:right;font-weight:bold;">Total:</td>
                            <td style="text-align:center;border-top:1px solid #fff;"><span ng-bind="((totalCompetency*30/100)+(totalGoal*40/100)).toFixed(2)"></span></td>
                        </tr>

                        <tr>
                            <td style="font-weight:bold;text-align:right;">Overall Performance : </td>
                            <td style="text-align:center;"><span ng-bind="record.total_computed_score.toFixed(2)"></span><td style="text-align:center;"></td>
                            <td style="text-align:center;"></td>
                        </tr>

                        <tr>
                            <td style="font-weight:bold;text-align:right;">Percentage Equivalent : </td>
                            <td style="text-align:center;"><span id="perctotal" ng-bind="(record.total_computed_score/5*100).toFixed(2)"></span>%</td>
                            <td class="note" id="note" style="text-align:center;background-color:#fff;font-weight:bold;" colspan="2">
                                <span ng-show="record.total_computed_score == 5" style="color: #06A716">(<i class="fa fa-thumbs-up"></i>) This Employee is Exceptional</span>
                                <span ng-show="record.total_computed_score < 5 && record.total_computed_score >= 4" style="color: #06A716">(<i class="fa fa-thumbs-up"></i>) This Employee Exceeds Expectations</span>
                                <span ng-show="record.total_computed_score < 4 && record.total_computed_score >= 3" style="color: #06A716">(<i class="fa fa-thumbs-up"></i>) This Employee Meets Expectations</span>
                                <span ng-show="record.total_computed_score < 3 && record.total_computed_score >= 2" style="color: #06A716">(<i class="fa fa-thumbs-up"></i>) This Employee Needs Improvement</span>
                                <span ng-show="record.total_computed_score < 2 && record.total_computed_score >= 0" style="color: #A70606">(<i class="fa fa-thumbs-down"></i>) This Employee Does not Meet Expectation</span>
                            </td>
                        </tr>
                    </table><br />     
                    
                    <table style="width:99%;" ng-show="record.AttendancePunctualityScore == 0 || record.ConductMemoScore == 0 || record.FiveSScore == 0">
                        <tr style="background-color:#fff;">
                            <td colspan="7" style="text-align:center;font-weight:bold;color:#A70606;"> Kindly inform the HR for the Employee Conduct/Memo, Attendance Score, Customer Experience and Training Score </td>
                        </tr>
                    </table>

                    <div style="border:1px solid #fff;padding-left:5px;width:98.6%;">
                        <h4>PERFORMANCE SUMMARY <span style="font-size:10px;font-weight:normal;">(Written by Reviewing Manager)</span> </h4>
                        <h4><span ng-bind="record.Rater1FullName"></span></h4>
                        <p>
                            <textarea ng-model="record.PerformanceSummary" class="perfsummary checker" style="width:98.4%;min-height:100px;" required ng-show="record.for_approval_level == 1" ng-disabled="is_approved || record.for_approval_level > 1" minlength="25"></textarea>
                            <span ng-show="record.for_approval_level > 1 || record.status == 'Completed'" ng-bind="record.PerformanceSummary"></span>
                        </p>
                        <div ng-show="record.Rater2Comment != null && (record.for_approval_level > 2 || record.status == 'Completed')">
                            <h4><span ng-bind="record.Rater2FullName"></span>' Comment</h4>
                            <p ng-bind="record.Rater2Comment"></p>
                        </div>
                        <div ng-show="record.Rater3Comment != null && (record.for_approval_level > 3 || record.status == 'Completed')">
                            <h4><span ng-bind="record.Rater3FullName"></span>' Comment</h4>
                            <p ng-bind="record.Rater3Comment"></p>
                        </div>
                        <div ng-show="record.Rater4Comment != null && (record.for_approval_level > 4 || record.status == 'Completed')">
                            <h4><span ng-bind="record.Rater4FullName"></span>' Comment</h4>
                            <p ng-bind="record.Rater4Comment"></p>
                        </div>
                        <div ng-show="record.status == 'Incomplete' && !is_approved">
                            <div ng-show="record.for_approval_level == 2">
                                <hr>
                                <h4>EVALUATION COMMENT</h4>
                                <textarea ng-model="record.Rater2Comment" class="checker" style="width:98.4%;min-height:100px;" ng-show="record.for_approval_level == 2"  ng-disabled="is_approved"></textarea>
                            </div>
                            <div ng-show="record.for_approval_level == 3">
                                <hr>
                                <h4>EVALUATION COMMENT</h4>
                                <textarea ng-model="record.Rater3Comment" class="checker" style="width:98.4%;min-height:100px;" ng-show="record.for_approval_level == 3"  ng-disabled="is_approved"></textarea>
                            </div>
                            <div ng-show="record.for_approval_level == 4">
                                <hr>
                                <h4>EVALUATION COMMENT</h4>
                                <textarea ng-model="record.Rater4Comment" class="checker" style="width:98.4%;min-height:100px;" ng-show="record.for_approval_level == 4"  ng-disabled="is_approved"></textarea>
                            </div>
                        </div>
                    </div>
                    <br>
                    
                    <?php if(isset($_GET['page']))
                            if($_GET['page'] !== 'result') { ?>
                    <!-- <h3 style="">
                        <strong>Equivalent system generated percentage increase: </strong>
                        <span id="sys_gen_inc" ng-bind="record.system_increase | number:2"></span>%
                    </h3> -->

                    <div id="floatdiv" class="floatdiv invisible">
                        <div id="nview" class="fview" style="display: none;">
                            <div id="paf_title" class="paf_title robotobold cattext dbluetext">
                                Promotion To New Level
                            </div>
                            <div id="paf_data" style="color: black">
                                <span>Please select your recommendation of promotion to a new level if applicable.</span>
                                <table class="tdataform2 rightmargin margintop10 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td style="vertical-align:top; text-align:right">Current Level</td>
                                            <th style="vertical-align:top;"><span ng-bind="record.Rank"></span></th>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align:top; text-align:right">Next Level</td>
                                            <td style="vertical-align:top;">
                                                <b ng-bind="record.ranks[getRankIndex(record.Rank)+1]"></b>
                                                <br><span>Based on the Organizational Levels Hierarchy</span>
                                            </td>
                                        </tr>
                                    
                                        <tr>
                                            <td style="vertical-align:top; text-align:right">Your Recommendation</td>
                                            <th style="vertical-align:top;">
                                                <select id="finalrank" class="txtbox width95per" ng-model="finalRankPromotion" ng-change="setFinalRankPromotion()"  ng-disabled="is_approved">
                                                    <option value="NOT FOR PROMOTION">NOT FOR PROMOTION</option>
                                                    <option ng-repeat="rank in record.ranks" ng-show="$index > getRankIndex(record.Rank)">{{ rank }}</option>
                                                </select>
                                                <span>Please select "NOT FOR PROMOTION" if ratee is not recommended.</span>
                                            </th>
                                        </tr>
                                        <tr ng-show="getRankIndex(finalRankPromotion) > getRankIndex(record.Rank)+1">
                                            <th colspan="2"><span id="rankwarning" style="color: red;">You have skipped a level based on the organization's promotion level of hierarchy. Please click CONTINUE to proceed with the recommendation.</span></th>
                                        </tr>
                                        <tr>
                                            <th colspan="2" style="text-align:center"><button type="button" class="btn closebutton">Continue</button></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- VIEW NOTIFICATION - END -->
                    </div>

                    <div id="submitfloat" class="floatdiv invisible">
                        <div id="submitfloatnview" class="fview" style="display: none;">
                            <div class="robotobold cattext dbluetext" style="text-align:center">
                                Submit Evaluation
                            </div>
                            <div>
                                <p style="text-align:center; color: black">Are you sure you want to submit this evaluation?</p>
                                <p style="text-align:center">
                                    <button type="button" class="btn closebutton">Cancel</button>
                                    <button type="button" class="btn closebutton" ng-click="submit()">Submit</button>
                                </p>
                            </div>
                        </div>
                    </div>

                    <p><strong>Final Recommendation</strong> (Please fill up your desired recommendations below.)</p>
                    <table>
                        <tr>
                            <td style="vertical-align:top; width:150px">Promotion To Level</td>
                            <td>
                                
                                <input type="text" name="promotion" ng-model="record.recommended_rank" autocomplete="off" readonly style="width:350px !important"  ng-disabled="is_approved" required>
                                <br><br>
                                Current rank is <b ng-bind="record.Rank"></b>
                                <br> 
                                <span ng-show="false">
                                    System recommends for promotion to <b></b>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align:top; width:150px">New Position Title</td>
                            <td>
                                <input type="text" ng-model="finalPositionPromotion"  ng-disabled="is_approved" ng-change="setFinalPositionPromotion()" ng-required="finalRankPromotion != 'NOT FOR PROMOTION'" style="width:350px !important" > 
                                <br><br>
                                Current Position title is <b><span ng-bind="record.Position"></span></b>
                                
                            </td>
                        </tr>
                        <tr ng-show="isFinalApprover()">
                            <td style="vertical-align:top; width:150px">Salary Increase</td>
                            <td>
                                <input type="number" name="increase" ng-model="record.recommended_salary_increase" ng-max="finalRankPromotion != 'NOT FOR PROMOTION' ? record.group.PromotionalIncrease : record.group.RegularIncrease" ng-disabled="is_approved" ng-change="setFinalRecommendedIncrease()"> %
                                <br><br>
                                Salary increase will be the final recommended increase. 
                                Maximum increase of <span ng-bind="finalRankPromotion != 'NOT FOR PROMOTION' ? record.group.PromotionalIncrease : record.group.RegularIncrease"></span>%
                                <br>If left blank, equivalent system generated percentage increase will apply.
                            </td>
                        </tr>
                    </table>

                    <p><strong style="color:#F8FABC">Promotion History from the last 3 years: </strong> <br>
                        <span ng-bind="record.PromotionHistory"></span><br> 
                        <br> <strong style="color:#F8FABC">Conduct and Memo History from the last 3 years: </strong> <br>
                        <span ng-bind="record.ConductMemoComment"></span><br>
                        <br> <strong style="color:#F8FABC">Attendance and Punctuality History from the last 3 years: </strong> <br>
                        <span ng-bind="record.AttendancePunctualityComment"></span>
                    </p>

                    <button type="button" class="subapp smlbtn" id="submapp" style="float:right;margin-right:10px;"  ng-show="!is_approved">Submit Appraisal</button>
                    <button type="button" class="saveapp smlbtn" id="saveapp" style="float:right;background-color:#3EC2FB;margin-right:10px;" ng-click="save()"  ng-show="!is_approved">Save Appraisal</button>
                    
                    <?php } else{ ?>

                        <div style="border:1px solid #fff;padding-left:5px;width:98.6%;" ng-show="is_approved">
                            <h4 >Employee Comment </h4>
                            <textarea ng-model="record.EmpComment" class="checker" style="width:98.4%;min-height:100px;" ng-show="is_approved" ng-disabled="record.DateCompleted != null"></textarea>
                            <button type="button" class="subapp smlbtn" id="submapp" style="float:right;margin-right:10px;"  ng-show="is_approved && record.DateCompleted == null" ng-click="accept()">Accept Evaluation</button>
                        </div>
                        <br>
                    <?php } ?>

                </div>
                    
                </div>
            </div>
        </form>
    </div>
</div>


    <script>
    var app = angular.module('myApp', []);
    app.controller('myCtrl', function($scope, $http,  $sce) {
        let apiUrl = '<?php echo MEWEB; ?>/peoplesedge/api/pmsv1/';

        $scope.record = [];
        $scope.ApproverEmpID = '<?php echo $profile_idnum; ?>';
        $scope.ApproverEmpDB = '<?php echo $profile_dbname; ?>';
        $scope.loading = true;

        $http({
            method: 'GET',
            url: apiUrl + 'evaluation/show/<?php echo $_GET['ratee']; ?>',
            params: {EmpID: $scope.ApproverEmpID, DB: $scope.ApproverEmpDB}
        }).then(function successCallback(response) {
                // store the response data in a variable called `data`
                $scope.record = response.data;
                $scope.loading = false;
                
                if($scope.record != ""){
                    $scope.record.ApproverEmpID = $scope.ApproverEmpID;
                    $scope.record.ApproverEmpDB = $scope.ApproverEmpDB;
                    $scope.record.system_increase = parseFloat($scope.record.system_increase);
                    $scope.record.recommended_salary_increase = $scope.record.recommended_salary_increase == 0 ? '' : parseFloat($scope.record.recommended_salary_increase);
                    $scope.record.total_computed_score = parseFloat($scope.record.total_computed_score);
                    $scope.record.TrainingScore = parseInt($scope.record.TrainingScore);
                    $scope.record.AttendancePunctualityScore = parseInt($scope.record.AttendancePunctualityScore);
                    $scope.record.ConductMemoScore = parseInt($scope.record.ConductMemoScore);
                    $scope.record.FiveSScore = parseInt($scope.record.FiveSScore);
                    $scope.is_approved = false;

                    $scope.record.goals.forEach(function (evaluation) {
                        if(evaluation.Grade == null || evaluation.Grade == '')
                            evaluation.Grade = 0;
                        else
                            evaluation.Grade = parseInt(evaluation.Grade);
                    });

                    $scope.record.competencies.forEach(function (evaluation) {
                        if(evaluation.ActualProficiency == null || evaluation.ActualProficiency == '')
                            evaluation.ActualProficiency = 0;
                        else
                            evaluation.ActualProficiency = parseInt(evaluation.ActualProficiency);
                    });
                    
                    $scope.trainingexists = $scope.record.goals.some(function(evaluation) {
                        return evaluation.Goals === '8 hrs mandatory training';
                    });

                    if(!$scope.trainingexists){
                        var newGoal = {
                            "EvaluationID": '<?php echo $_GET['ratee']; ?>',
                            "Goals":  "8 hrs mandatory training",
                            "MeasureOfSuccess": "",
                            "Comments": null,
                            "Grade": $scope.record.TrainingScore,
                            "id": null
                        }

                        $scope.record.goals.push(newGoal);
                    }

                    if($scope.record.goals_next.length === 0){
                        for (let index = 0; index < 3; index++) {
                            $scope.addNextGoal();
                        }
                    }

                    $scope.updateRecord();
            
                    $scope.loading = false;

                    if($scope.record.Rater1EmpID == $scope.ApproverEmpID 
                        && $scope.record.Rater1DB == $scope.ApproverEmpDB 
                        && $scope.record.Rater1Status == 1){
                        $scope.is_approved = true;
                    }else if($scope.record.Rater2EmpID == $scope.ApproverEmpID 
                        && $scope.record.Rater2DB == $scope.ApproverEmpDB 
                        && $scope.record.Rater2Status == 1){
                        $scope.is_approved = true;
                    }else if($scope.record.Rater3EmpID == $scope.ApproverEmpID 
                        && $scope.record.Rater3DB == $scope.ApproverEmpDB 
                        && $scope.record.Rater3Status == 1){
                        $scope.is_approved = true;
                    }else if($scope.record.Rater4EmpID == $scope.ApproverEmpID 
                        && $scope.record.Rater4DB == $scope.ApproverEmpDB 
                        && $scope.record.Rater4Status == 1){
                            $scope.is_approved = true;
                    }

                    if($scope.record.for_approval_level == 1 
                        && $scope.record.Rater1EmpID !== $scope.ApproverEmpID 
                        && $scope.record.Rater1DB !== $scope.ApproverEmpDB ){
                            $scope.is_approved = true;
                    }else if($scope.record.for_approval_level == 2 
                        && $scope.record.Rater2EmpID !== $scope.ApproverEmpID 
                        && $scope.record.Rater2DB !== $scope.ApproverEmpDB ){
                            $scope.is_approved = true;
                    }else if($scope.record.for_approval_level == 3 
                        && $scope.record.Rater3EmpID !== $scope.ApproverEmpID 
                        && $scope.record.Rater3DB !== $scope.ApproverEmpDB ){
                            $scope.is_approved = true;
                    }else if($scope.record.for_approval_level == 4 
                        && $scope.record.Rater4EmpID !== $scope.ApproverEmpID 
                        && $scope.record.Rater4DB !== $scope.ApproverEmpDB ){
                            $scope.is_approved = true;
                    }

                    if($scope.record.Rater4EmpID != null && $scope.record.Rater4DB != null && $scope.record.Rater4Status != null ){
                            $scope.finalRankPromotion = $scope.record.Rater4RankPromotion;
                            $scope.finalPositionPromotion = $scope.record.Rater4PositionPromotion;
                            $scope.finalRecommendedIncrease = parseFloat($scope.record.Rater4Increase);
                    }else if($scope.record.Rater3EmpID != null 
                        && $scope.record.Rater3DB != null 
                        && $scope.record.Rater3Status != null ){
                            $scope.finalRankPromotion = $scope.record.Rater3RankPromotion;
                            $scope.finalPositionPromotion = $scope.record.Rater3PositionPromotion;
                            $scope.finalRecommendedIncrease = parseFloat($scope.record.Rater3Increase);
                    }else if($scope.record.Rater2EmpID != null 
                        && $scope.record.Rater2DB != null 
                        && $scope.record.Rater2Status != null ){
                            $scope.finalRankPromotion = $scope.record.Rater2RankPromotion;
                            $scope.finalPositionPromotion = $scope.record.Rater2PositionPromotion;
                            $scope.finalRecommendedIncrease = parseFloat($scope.record.Rater2Increase);
                    }else if($scope.record.Rater1EmpID != null 
                        && $scope.record.Rater1DB != null 
                        && $scope.record.Rater1Status != null ){
                            $scope.finalRankPromotion = $scope.record.Rater1RankPromotion;
                            $scope.finalPositionPromotion = $scope.record.Rater1PositionPromotion;
                            $scope.finalRecommendedIncrease = parseFloat($scope.record.Rater1Increase);
                    }

                    $scope.setFinalRankPromotion();
                    $scope.setFinalPositionPromotion();
                    $scope.setFinalRecommendedIncrease();

                    if($scope.record.status == 'Completed')
                        $scope.is_approved = true;
                }
            },
            function errorCallback(response) {
                    console.error("Error while retrieving record", response);
                    $scope.loading = true;
        });

        $scope.displayDescription = function(comp){
            return $sce.trustAsHtml(comp);
        }

        $scope.formatDate = function(date){
            var dateOut = new Date(date);
            return dateOut;
        };

        $scope.updateRecord = function(){
            $scope.totalGoal = parseFloat(($scope.record.goals.reduce(function(total, goal) {
                if(goal.Grade == null || goal.Grade == '' || goal.Grade == undefined)
                    goal.Grade = 0;
                
                return total + goal.Grade;
            }, 0) / $scope.record.goals.length).toFixed(2));

            $scope.totalCompetency= $scope.round2(($scope.record.competencies.reduce(function(total, competency) {

                if(parseInt(competency.RequiredProficiency) - parseInt(competency.ActualProficiency) > 0)
                    competency.Gaps = parseInt(competency.RequiredProficiency) - parseInt(competency.ActualProficiency);
                else
                    competency.Gaps = 0;

            return total + (parseFloat(competency.ActualProficiency) || 0);
            }, 0) / $scope.record.competencies.length));

            if(isNaN($scope.totalCompetency)){
                $scope.totalCompetency = 0;
            }

            $scope.record.evaluation_score =  (parseFloat($scope.totalCompetency.toFixed(2)) * 30/100) + (parseFloat($scope.totalGoal).toFixed(2) * 40/100);

            $scope.partHRScore = parseFloat((($scope.record.FiveSScore * 0.05) + ($scope.record.AttendancePunctualityScore * 0.1) + parseFloat($scope.record.ConductMemoScore * 0.15)).toFixed(2));

            $scope.record.total_computed_score = parseFloat($scope.record.evaluation_score) + parseFloat($scope.partHRScore);

            let percentage_increase = parseFloat($scope.record.group.RegularIncrease);
            if($scope.finalRankPromotion != 'NOT FOR PROMOTION')
                percentage_increase = parseFloat($scope.record.group.PromotionalIncrease);
            
            $scope.record.system_increase = ($scope.record.total_computed_score/5) * 100 * (percentage_increase/100);

            // round 2 decim
        }

        $scope.trustHTML = function(html){
            return $sce.trustAsHtml(html);
        }

        $scope.addNextGoal = function(){
            var newGoal = {
                "EvaluationID": '<?php echo $_GET['ratee']; ?>',
                "Goals":  "",
                "MeasureOfSuccess": "",
                "id": null
            }

            $scope.record.goals_next.push(newGoal);
        }

        $scope.add_goal = function (){
            var newGoal = {
                "EvaluationID": '<?php echo $_GET['ratee']; ?>',
                "Goals":  "",
                "MeasureOfSuccess": "",
                "Comments": null,
                "Grade": 0,
                "id": null
            }

            $scope.record.goals.push(newGoal);
        }
        
        $scope.deleteGoal = function($index){
            // delete goal from $scope.record.goals given the index
            $scope.record.goals.splice($index,1);
            
        }

        $scope.deleteNextGoal = function(index){
            $scope.record.goals_next.splice(index, 1);
        }

        $scope.setFinalRankPromotion = function(){
            if($scope.record.Rater1EmpID == $scope.ApproverEmpID && $scope.record.Rater1DB == $scope.ApproverEmpDB)
                $scope.record.Rater1RankPromotion = $scope.finalRankPromotion;
        
            if($scope.record.Rater2EmpID == $scope.ApproverEmpID && $scope.record.Rater2DB == $scope.ApproverEmpDB)
                $scope.record.Rater2RankPromotion = $scope.finalRankPromotion;

            if($scope.record.Rater3EmpID == $scope.ApproverEmpID && $scope.record.Rater3DB == $scope.ApproverEmpDB)
                $scope.record.Rater3RankPromotion = $scope.finalRankPromotion;
        
            if($scope.record.Rater4EmpID == $scope.ApproverEmpID && $scope.record.Rater4DB == $scope.ApproverEmpDB)
                $scope.record.Rater4RankPromotion = $scope.finalRankPromotion;
            
            $scope.record.recommended_rank = $scope.finalRankPromotion;
            $scope.updateRecord();
        }

        $scope.setFinalPositionPromotion = function(){
            if($scope.record.Rater1EmpID == $scope.ApproverEmpID && $scope.record.Rater1DB == $scope.ApproverEmpDB)
                $scope.record.Rater1PositionPromotion = $scope.finalPositionPromotion;
        
            if($scope.record.Rater2EmpID == $scope.ApproverEmpID && $scope.record.Rater2DB == $scope.ApproverEmpDB)
                $scope.record.Rater2PositionPromotion = $scope.finalPositionPromotion;

            if($scope.record.Rater3EmpID == $scope.ApproverEmpID && $scope.record.Rater3DB == $scope.ApproverEmpDB)
                $scope.record.Rater3PositionPromotion = $scope.finalPositionPromotion;
        
            if($scope.record.Rater4EmpID == $scope.ApproverEmpID && $scope.record.Rater4DB == $scope.ApproverEmpDB)
                $scope.record.Rater4PositionPromotion = $scope.finalPositionPromotion;
        }

        $scope.setFinalRecommendedIncrease = function(){
            if($scope.record.Rater1EmpID == $scope.ApproverEmpID && $scope.record.Rater1DB == $scope.ApproverEmpDB)
                $scope.record.Rater1Increase = $scope.finalRecommendedIncrease;
        
            if($scope.record.Rater2EmpID == $scope.ApproverEmpID && $scope.record.Rater2DB == $scope.ApproverEmpDB)
                $scope.record.Rater2Increase = $scope.finalRecommendedIncrease;

            if($scope.record.Rater3EmpID == $scope.ApproverEmpID && $scope.record.Rater3DB == $scope.ApproverEmpDB)
                $scope.record.Rater3Increase = $scope.finalRecommendedIncrease;
        
            if($scope.record.Rater4EmpID == $scope.ApproverEmpID && $scope.record.Rater4DB == $scope.ApproverEmpDB)
                $scope.record.Rater4Increase = $scope.finalRecommendedIncrease;       
        }

        $scope.isFinalApprover = function(){
            if($scope.record.Rater1EmpID == $scope.ApproverEmpID && $scope.record.Rater1DB == $scope.ApproverEmpDB && $scope.record.final_approver_level == 1)
                return true;
        
            if($scope.record.Rater2EmpID == $scope.ApproverEmpID && $scope.record.Rater2DB == $scope.ApproverEmpDB && $scope.record.final_approver_level == 2)
                return true;

            if($scope.record.Rater3EmpID == $scope.ApproverEmpID && $scope.record.Rater3DB == $scope.ApproverEmpDB && $scope.record.final_approver_level == 3)
                return true;
        
            if($scope.record.Rater4EmpID == $scope.ApproverEmpID && $scope.record.Rater4DB == $scope.ApproverEmpDB && $scope.record.final_approver_level == 4)
                return true;

            return false;
        }

        $scope.getRankIndex = function(rank){
            return $scope.record.ranks.indexOf(rank);
        }

        $scope.save = function(){
            $scope.loading = true;

            if($scope.record.recommended_salary_increase == '' || $scope.record.recommended_salary_increase == null){
                $scope.record.recommended_salary_increase = 0;
            }

            $http({
                method: 'POST',
                url: apiUrl + 'evaluation/save', 
                data:  $scope.record
            }).then(function successCallback(response) {
                    // store the response data in a variable called `data`
                    $scope.record = response.data;
                    console.log("Successfully saved record");
                    $scope.loading = false;

                    // refresh page
                    window.location.reload();
                },
                function errorCallback(response) {
                        // called asynchronously if an error occurs
                        // or server returns response with an error status.
                        $scope.loading = true;
                        console.error("Error while saving record", response);
            });
        }

        $scope.submit = function(){
            if($scope.validate()){
                $scope.record.submit = true;
                $scope.save();
            }
        }

        $scope.accept = function(){
            $scope.record.accept = true;
            $scope.save();
        }

        $scope.validate = function(){
            // angular 1.7 validate form on submit
            if($scope.myForm.$invalid){
                $('input.ng-invalid').first().focus();
                $('textarea.ng-invalid').first().focus();
                $('select.ng-invalid').first().focus();
                alert('Please check all required inputs!');
            }

            return !$scope.myForm.$invalid;
        }

        $scope.round2 = function(num){
            // return +num.toFixed(2);
            if(num ==  null || num == undefined || isNaN(num)) 
                return 0;

            return Math.round(num*100)/100;
        }

    });
    
    $('input[name="promotion"]').on('click', function(e){
        $("#floatdiv").removeClass("invisible");
        $("#nview").show({
            effect : 'slide',
            easing : 'easeOutQuart',
            direction : 'up',
            duration : 500
        });
    });

    $('#submapp').on('click', function(e){
        $("#submitfloat").removeClass("invisible");
        $("#submitfloatnview").show({
            effect : 'slide',
            easing : 'easeOutQuart',
            direction : 'up',
            duration : 500
        });

        // $scope.submit();
    });

    $(".jobdesc-btn").hover(function(event) {
        var hoverElement = $(this);
        var popup = $(this).parent().find(".jobdesc-popup");
        popup.css({
            left: hoverElement.offset().left,
            top: hoverElement.offset().top - hoverElement.outerHeight(),
            display: "block"
        });
        }, function() {
        var popup = $(this).parent().find(".jobdesc-popup");
        popup.css("display", "none");
    });

    </script>
    <?php include('session.php'); ?>
    