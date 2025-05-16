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
        .warningMsg{
            color: #ffb649; 
            font-weight: bold;
            /* background-color: #FFE57D;  */
            padding: 5px;
        }
</style>

<div class="rightsplashtext lefttalign">
    <div ng-app='myApp' ng-controller='myCtrl' id="paf" class="mainbody lefttalign whitetext">
        <form  name="myForm" >
            <div class="loading-screen" ng-show="loading">
                <div class="spinner"></div>
                <p>Please wait...</p>
            </div>

            <div ng-show="!loading && record == ''">
                <table style="width:100%;">
                    <tr style="background-color:#fff;">
                        <td colspan="7" style="text-align:center;font-weight:bold;color:#A70606;"> You do not have permission to view this performance evaluation</td>
                    </tr>
                </table>
                <br />
            </div>

            <div ng-show="is_approved && record.DateCompleted == null">
                <table style="width:100%;">
                    <tr style="background-color:#fff;">
                        <td colspan="7" style="text-align:center;font-weight:bold;color:#A70606;">This evaluation form has been submitted for the next approval.</td>
                    </tr>
                </table>
                <br />
            </div>

            <div ng-show="is_approved && record.DateCompleted != null">
                <table style="width:100%;">
                    <tr style="background-color:#fff;">
                        <td colspan="7" style="text-align:center;font-weight:bold;color:#A70606;">This evaluation form has been completed.</td>
                    </tr>
                </table>
                <br />
            </div>


            <div ng-show="!loading && record !== ''">
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
                                    ng-bind="formatDate(record.HireDate) |  date:'yyyy-MM-dd'"></span></td>
                        </tr>
                        <tr>
                            <td>

                                <b class="smallesttext lwhitetext">Period:</b>

                                <span style="font-weight:normal;">
                                    From | <u ng-bind="formatDate(record.HireDate) |  date:'yyyy-MM-dd'"></u>
                                    To | <u ng-bind="record.EndOfContractDate ? (formatDate(record.EndOfContractDate) | date:'yyyy-MM-dd') : ''" class="ng-binding"></u>

                                </span>

                            </td>
                            <td><b class="smallesttext lwhitetext">Appraisal Date:</b> <span style="font-weight:normal;"
                                ng-bind="record.EndOfContractDate ? (formatDate(record.EndOfContractDate) | date:'yyyy-MM-dd') : ''" class="ng-binding"></span></td>
                        </tr>
                    </tbody>
                </table>
                <hr/>

                <div class="print" style="overflow-x:none;overflow-y:scroll;max-height:514px;">
                    

                    <div style="border:2px solid #fff;padding-left:5px;width:98%;">
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
                                        <td>2 - <b>N</b>eeds <b>I</b>mprovement</td>
                                        <td style="text-align:center;"></td>
                                    </tr>
                                    <tr>
                                        <td>1 - Does Not Meet Expectations</td>
                                        <td style="text-align:center;"></td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                    <br />
                    <!-- Part 1 -->
                    <div style="border:1px solid #fff;padding:0 5px;width:98%;">
                        <h4>I. GENERAL RESPONSIBILITIES <span style="font-size:10px;font-weight:normal;">(Reason for position, according to job description)</span></h4>
                        <p style="margin-left:20px;" ng-bind="record.GeneralResponsibilities"></p>
                        <p style="background-color:#fff;color:red;padding:5px;" ng-show="record.GeneralResponsibilities == '' || record.GeneralResponsibilities == null">General Responsiblity is not set by HR</p>
                    </div><!-- End of part 1 -->
                    <br />

                    <!-- Part 2 -->
                    <div style="border:1px solid #fff;padding:0 5px;width:98%;">
                        <h4>II. PERFORMANCE SUMMARY <span style="font-size:10px;font-weight:normal;">(Written by Reviewing Manager)</span> </h4>
                        <h4><span ng-bind="record.Rater1FullName"></span></h4>
                        <p>
                            <textarea spellcheck='true' style="width:98.4%;min-height:100px;" class="perfsummary checker" rows="3" 
                                ng-model="record.PerformanceSummary" 
                                ng-show="record.for_approval_level == 1" ng-disabled="is_approved || record.for_approval_level > 1"
                                ng-class="{'ng-invalid': !record.PerformanceSummary || record.PerformanceSummary.length < 25, 
                                            'ng-valid': record.PerformanceSummary && record.PerformanceSummary.length >= 25}">
                            </textarea><br>
                            <small ng-show="record.PerformanceSummary.length < 25 && record.PerformanceSummary.length > 0" 
                            class='warningMsg'>
                                * Must be at least 25 characters long.
                            </small><br>
                            <span ng-show="record.for_approval_level > 1 || is_approved" ng-bind="record.PerformanceSummary"></span>
                            <span  ng-show="record.for_approval_level == 1" style="font-style:italic;margin-left:5px;font-size:10px;">Note: Salary increase will be based on the Overall Performance Rating.</span>
                        </p>
                    </div><!-- End of part 2 -->
                    <br />

                    <div ng-show="record.goals.length == 0 || record.goals == null">
                        <table style="width:100%;">
                            <tr style="background-color:#fff;">
                                <td colspan="7" style="text-align:center;font-weight:bold;color:#A70606;"> Kindly inform the HR for the Part III Work Result Form </td>
                            </tr>
                        </table>
                        <br />
                    </div>

                    <div ng-show="record.goals.length > 0 ">
                        <div style="border:1px solid #fff;padding-left:5px;padding-right:5px;width:98%;">
                            <h4>III. WORK RESULTS</h4>
                            <div style="font-size:9px;float:left;width:30%;">
                                Parameter: Achievement (%()w/ Rating)<br />
                                64 below (1)<br />
                                65-74 (2)<br />
                                75-84 (3)<br />
                                85-94 (4)<br />
                                95-100 (5)
                            </div>
                            <div style="font-size:10px;float:left;width:70%;">
                                Minimum of 3 objective according the SMART goal definition, and carried over from the last review period. Results achieved to be stated by Job Holder and commented by Reviewing Mgr. An additional objective is added in case of staff management responsibilities as "PMS". Weight is the importance of each objective versus the others. Achievement % is the volume of the objective achieved, and the rating is the quality of what has been achieved. Examples can be found in PMS Guidelines.
                            </div>
                            <div style="clear:both;"></div>

                            <div class="work-result-wrapper">
                                <div ng-repeat="goal in record.goals">
                                    <p style="text-decoration:underline;font-weight:bold;">OBJECTIVE <span ng-bind="$index+1"></span></p>
                                    <!-- objectives and ratings -->
                                    <div style="float:left;width:380px;">
                                        <div style="float:left;width:380px;">
                                            <p ng-bind="goal.Objective"></p>
                                            <p><span style="color:#F8FABC"><strong>Measurement of Success: </strong><span ng-bind="goal.MeasureOfSuccess"></span></span></p>
                                        </div>
                                    </div>

                                    <div style="width:320px;float:right;font-size:9px;margin-bottom:10px;">
                                        <ul style="list-style-type: none;margin:0;padding: 0;font-weight:bold;">
                                            <li style="display: inline;">Weight</li>
                                            <li style="display: inline;padding-left:10px;">Achievement %</li>
                                            <li style="display: inline;padding-left:41px;">Rating</li>
                                            <li style="display: inline;padding-left:20px;">Weighted Rating</li>
                                        </ul>
                                    </div>
                                    <div style="width:320px;float:right;font-size:9px;">
                                        <span ng-bind="goal.Weight"></span>%
                                        <input type="number"  min="10" max="100" class="width25 smltxtbox calcp3a checker" style="width:35px;margin-left:30px;"  ng-model="goal.Achievement" ng-change="updateRecord()" ng-disabled="is_approved" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode==8" onKeyDown="if ((this.value.length == 2 || this.value.length == 3) && ((this.value >= 10 && this.value <= 100 && !(this.value == 10 && event.keyCode == 48)) && event.keyCode != 8))  return false;" onfocusin="(this.value == 0) ? this.value = '' : false" onfocusout="(this.value == '') ? this.value = 0 : false" required> %</span>        

                                        <input type="number"  min="1" max="5" class="width25 smltxtbox calcp3r checker" style="width:35px;margin-left:45px;" ng-model="goal.Rating" ng-change="updateRecord()" ng-disabled="is_approved" onkeypress="return (event.charCode >= 49 && event.charCode <= 53) || event.charCode==8" onKeyDown="if(this.value.length==1 && event.keyCode!=8) return false;" onfocusin="(this.value == 0) ? this.value = '' : false" onfocusout="(this.value == '') ? this.value = 0 : false" required>
                                        <span style="margin-left:46px;" ng-bind="goal.WeightedRating = round2((goal.Achievement * goal.Weight * goal.Rating) / 10000)"></span>
                                    </div>

                                    <div style="clear:both;"></div>
                            
                                    <table>
                                        <tr>
                                            <td style="width: 100px">Results Achieved: </td>
                                            <td>
                                                <textarea spellcheck='true' class="checker" cols="80" rows="2" 
                                                        ng-model="goal.ResultsAchieved"
                                                        ng-disabled="is_approved" 
                                                        ng-class="{'ng-invalid': !goal.ResultsAchieved || goal.ResultsAchieved.length < 25, 
                                                                    'ng-valid': goal.ResultsAchieved && goal.ResultsAchieved.length >= 25}">
                                                </textarea>
                                                <small ng-show="goal.ResultsAchieved.length < 25 && goal.ResultsAchieved.length > 0" class='warningMsg'>
                                                    * Must be at least 25 characters long.
                                                </small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 100px">Comments: </td>
                                            <td>
                                                <textarea 
                                                        spellcheck='true' class="checker" cols="80" rows="2" 
                                                        ng-model="goal.Comments" 
                                                        ng-disabled="is_approved" 
                                                        ng-class="{'ng-invalid': !goal.Comments || goal.Comments.length < 25, 
                                                                    'ng-valid': goal.Comments && goal.Comments.length >= 25}">
                                                </textarea>
                                                <small ng-show="goal.Comments.length < 25 && goal.Comments.length > 0" 
                                                class='warningMsg'>
                                                    * Must be at least 25 characters long.
                                                </small>
                                            </td>
                                        </tr>
                                    </table>
                                    <div style="clear:both;"></div>
                            
                                </div>
                                <hr></hr>
                                <div style="padding:10px;margin-top:-15px;">
                                    <table class="tdata" cellspacing="0" style="width:180px;float:right;font-size:9px;">
                                        <tr>
                                            <th>Final Weight</th>
                                            <th style="text-align:center !important;">Final Weighted rating</th>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center;"><span ng-bind="totalGoalAchievement"></span>%</td>
                                            <td style="text-align:center;"><span ng-bind="totalGoalWeightRating | number: 2"></span></td>
                                        </tr>
                                    </table>
                                    <h4 style="float:right;margin-top:23px;margin-right:20px;">Overall Work Results</h4>
                                    <div style="clear:both;"></div>
                                </div><!-- end of overall work result -->
                            </div>
                        </div>
                    </div>

                    <div ng-show="record.competencies.length == 0 || record.competencies == null">
                        <table style="width:100%;">
                            <tr style="background-color:#fff;">
                                <td colspan="7" style="text-align:center;font-weight:bold;color:#A70606;"> Kindly inform the HR for the Part IV Personal Competencies Form </td>
                            </tr>
                        </table>
                        <br />
                    </div>

                    <div ng-show="record.competencies.length > 0">
                        <div style="border:1px solid #fff;padding-left:5px;padding-right:5px;width:98%;">
                            <h4>IV. PERSONAL CORE COMPETENCIES<span style="font-size:10px;font-weight:normal;"> (Minimum of 5 items agreed by both parties) </span></h4>

                            <div class="work-result-wrapper" ng-repeat="competency in record.competencies">

                                <p style="text-decoration:underline;font-weight:bold;margin-bottom:-5px;">
                                    <span ng-bind="$index+1"></span>) <span ng-bind="competency.Competency"></span>
                                </p>
                                <!-- objectives and ratings -->
                                <div style="float:left;width:400px;">
                                    <p ng-if="competency.Description" ng-bind-html="trustHTML(competency.Description)"></p>
                                    <p ng-if="!competency.Description" style="visibility:hidden;">-</p> <!-- This is the artificial placeholder -->
                                </div>
                                <div style="width:220px;float:right;font-size:9px;margin-bottom:10px;">
                                    <ul style="list-style-type: none;margin:0;padding: 0;font-weight:bold;">
                                        <li style="display: inline;">Weight</li>
                                        <li style="display: inline;padding-left:41px;">Rating</li>
                                        <li style="display: inline;padding-left:20px;">Weighted Rating</li>
                                    </ul>
                                </div>
                                <div style="width:220px;float:right;font-size:9px;">
                                    <span ng-bind="competency.Weight"></span>%
                                    <input type="number" min='1' max='5' style="width:35px;margin-left:50px;" class="width25 smltxtbox pccrate checker" ng-model="competency.Rating" ng-change="updateRecord()" ng-disabled="is_approved" onkeypress="return (event.charCode >= 49 && event.charCode <= 53) || event.charCode==8" onKeyDown="if(this.value.length==1 && event.keyCode!=8) return false;" onfocusin="(this.value == 0) ? this.value = '' : false" onfocusout="(this.value == '') ? this.value = 0 : false" required>
                                    <span style="margin-left:30px;" ng-bind="competency.WeightedRating = round2(competency.Rating * competency.Weight / 100)"></span>
                                </div>
                                <div style="width:710px;float:left;">
                                <!-- comments and achievments textarea -->
                                Comments:
                                <span class="px" style="font-style:italic;margin-left:5px;font-size:10px;" ng-show="competency.Rating != 3">(*Required field, if your rating is greater than or less than 3 to justify your rating to this employee)</span>
                                <textarea spellcheck='true'  cols="90" rows="3" 
                                        class="checker" 
                                        ng-model="competency.Remarks" 
                                        ng-disabled="is_approved" 
                                        ng-class="{'ng-invalid': (competency.Rating != 3 && (!competency.Remarks || competency.Remarks.length < 25)),
                                                    'ng-valid': competency.Rating == 3 || (competency.Remarks && competency.Remarks.length >= 25)}">
                                </textarea>
                                <br>
                                <small ng-show="competency.Rating != 3 && competency.Remarks.length > 0 && competency.Remarks.length < 25" class='warningMsg'>
                                    * Must be at least 25 characters long.
                                </small>
                                </div>
                                <div style="clear:both;"></div>

                            </div><!-- end of work result of each objectives -->
                            <hr></hr>

                            <!-- Overall work result -->
                            <div style="padding:5px;">
                                <table class="tdata" cellspacing="0" style="width:220px;float:right;font-size:9px;">
                                    <tr>
                                        <th>Final Weight</th>
                                        <th style="text-align:center !important;">Final Weighted rating</th>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center;"><span ng-bind="totalCompetencyWeight"></span>%</td>
                                        <td style="text-align:center;"><span ng-bind="totalCompetencyWeightRating | number: 2"></span></td>
                                    </tr>
                                </table>
                                <h4 style="float:right;margin-top:12px;margin-right:20px;">Overall Personal Core Comptencies</h4>
                                <div style="clear:both;"></div>
                            </div><!-- end of overall work result -->
                        </div><!-- End of part 4 -->
                    </div>
                    
                    <div >
                        <div style="border:1px solid #fff;padding-left:5px;padding-right:5px;width:98%;">
                            <h4>V. SETTING OBJECTIVES FOR NEXT REVIEW PERIOD</h4>
                            <p style="font-weight:bold;">WORK RESULTS <span style="font-weight:normal;">(Minimum 3 SMART objectives and potential PMS, set by Reviewing Manager)</span></p>

                            <div class="work-result-wrapper" id="partvwrap">
                                <div id="partvwork">
                                    <div ng-repeat="next_goal in record.goals_next">
                                        <p style="text-decoration:underline;font-weight:bold;">
                                            <a class="smlbtn" id="delrowv" style="background-color:#D20404;" ng-click="deleteNextGoal($index)" ng-show="!is_approved">Remove</a> 
                                            OBJECTIVE <span ng-bind="$index+1"></span>
                                        </p>
                                        <div style="float:left;width:380px;">
                                            <textarea spellcheck='true' style="width:167%;" class="checker" cols="80" rows="2" 
                                                    ng-model="next_goal.Objective" 
                                                    ng-disabled="is_approved" 
                                                    ng-class="{'ng-invalid': !next_goal.Objective || next_goal.Objective.length < 25, 
                                                                'ng-valid': next_goal.Objective && next_goal.Objective.length >= 25}">
                                            </textarea>
                                            <br>
                                            <small ng-show="next_goal.Objective.length < 25 && next_goal.Objective.length > 0" 
                                            class='warningMsg'>
                                                * Must be at least 25 characters long.
                                            </small>
                                        </div>
                                        <div style="width:60px;float:right;font-size:9px;">
                                            <p style="font-weight:bold;">Weight</p>
                                            <input style="width:35px;" type="number" ng-model="next_goal.Weight" min="1" max="100" class="width25 smltxtbox p5w checker" ng-change="updateRecord()" required  ng-disabled="is_approved"  onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode==8" onKeyDown="if ((this.value.length == 2 || this.value.length == 3) && ((this.value >= 10 && this.value <= 100 && !(this.value == 10 && event.keyCode == 48)) && event.keyCode != 8))  return false;" onfocusin="(this.value == 0) ? this.value = '' : false" onfocusout="(this.value == '') ? this.value = 0 : false"> %
                                        </div>
                                        <div style="clear:both;"></div>
                                        <div>
                                        <p> Measurement of accomplishment: </p>
                                            <textarea spellcheck='true' style="width:90%;" class="checker" cols="80" rows="2" 
                                                    ng-model="next_goal.MeasureOfSuccess" 
                                                    ng-disabled="is_approved" 
                                                    ng-class="{'ng-invalid': !next_goal.MeasureOfSuccess || next_goal.MeasureOfSuccess.length < 25, 
                                                                'ng-valid': next_goal.MeasureOfSuccess && next_goal.MeasureOfSuccess.length >= 25}">
                                            </textarea><br>
                                            <small ng-show="next_goal.MeasureOfSuccess.length < 25 && next_goal.MeasureOfSuccess.length > 0" 
                                            class='warningMsg'>
                                                * Must be at least 25 characters long.
                                            </small>
                                        
                                            <!-- <input type="text" style="margin-top:-8px;width:89%;" class="smltxtbox checker" ng-model="next_goal.MeasureOfSuccess" required  ng-disabled="is_approved" minlength="10"> -->
                                            <div style="clear:both;"></div>
                                        </div>
                                        <hr/>
                                    </div>
                                </div>
                            </div>
                            <a class="smlbtn" id="addrowv" style="background-color:#3EC2FB;" ng-click="addNextGoal()" ng-show="!is_approved">Add Objective</a>
                            
                            <div style="margin-top:-20px;" >
                                <table class="tdata" cellspacing="0" style="width:100px;float:right;font-size:9px;">
                                    <tr>
                                        <th>Total Weight %</th>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center;"><input type="number" class="width25 smltxtbox p5w checker" style="width:35px;" required min="100" max="100" ng-model="totalNextGoalWeight" readonly  ng-disabled="is_approved">
                                    </tr>
                                </table>
                                <div style="clear:both;"></div>
                            </div>
                        
                            <div>
                                <h4>PERSONAL CORE COMPETENCIES <span style="font-size:10px;font-weight:normal;">(Minimum of 5 items agreed by both parties)</span></h4>
                                <div class="pcc-main-wrapper">

                                    <div class="pcc-left-wrapper" style="float:left;width:100%;">
                                        <table class="tdata" cellspacing="5" style="width:100%;">
                                            <tr>
                                                <th style="border: 0">Competency</th>
                                                <th style="border: 0;">Description</th>
                                                <th style="width:20px;text-align:center;border:1px solid #fff;font-size:8px;">Weight</th>
                                            </thead>
                                            <tr ng-repeat="next_pcc in record.competencies_next">
                                                <td style="border:1px solid #fff;">
                                                    <span ng-show="next_pcc.id != null" ng-bind="next_pcc.Competency"></span>
                                                    <textarea spellcheck="true"   cols="15" rows="2" ng-show="next_pcc.id == null"  ng-model="next_pcc.Competency" width="100%" ng-disabled="is_approved"></textarea>

                                                    <!-- <input type="text" ng-show="next_pcc.Competency == ''" width="100%" ng-model="next_pcc.Competency" class="smltxtbox calcp5w checker" ng-disabled="is_approved"> -->
                                                </td>
                                                <td style="border:1px solid #fff;">
                                                    <span ng-show="next_pcc.id != null" ng-bind="next_pcc.Description"></span>
                                                    <textarea spellcheck="true"  id="description" cols="60" rows="2" ng-show="next_pcc.Description == null && !is_approved"  ng-model="next_pcc.Description" width="100%" ng-disabled="is_approved"></textarea>
                                                </td>
                                                <td><input type="number" ng-model="next_pcc.Weight" min="0" max="100" class="smltxtbox calcp5w checker" style="width:35px;" ng-change="updateRecord()"  ng-disabled="is_approved"  onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode==8" onKeyDown="if ((this.value.length == 2 || this.value.length == 3) && ((this.value >= 10 && this.value <= 100 && !(this.value == 10 && event.keyCode == 48)) && event.keyCode != 8))  return false;" onfocusin="(this.value == 0) ? this.value = '' : false" onfocusout="(this.value == '') ? this.value = 0 : false" required></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right"></td>
                                                <td style="text-align: right">Total Weight %</td>
                                                <td><input type="number" id="inputtotalnextweight" class="width25 smltxtbox p5w checker" style="width:35px;" required min="100" max="100" ng-model="totalNextCompetencyWeight" readonly  ng-disabled="is_approved"></td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div style="clear:both;"></div>
                                </div> <!-- end of pcc main wrapper -->
                                <hr></hr >
                                <h4 style="margin-top:5px;">Comments on next year's objectives :</h4>
                                <textarea spellcheck="true"  ng-model="record.NObjective" style="width:99%;"  ng-disabled="is_approved" class=" checker"></textarea>

                            </div>
                        </div>
                        <br />
                    </div>
                    <br />

                

                    <table style="border:1px solid #fff;width:99%;" >
                        <thead>
                            <tr>
                                <th style="text-align:left;width:350px;">A. PERFORMANCE EVALUATION - 100%</th>
                                <th style="text-align:center;">% Value</th>
                                <th style="text-align:center;">Rate</th>
                                <th style="text-align:center;">Final Value</th>
                            </tr>
                        </thead>
                        <tr>
                            <td>PART I - Work Results </td>
                            <td style="text-align:center;">50%</td>
                            <td style="text-align:center;"><span ng-bind="totalGoalWeightRating | number:2"></span></td>
                            <td style="text-align:center;" >
                                <span ng-bind="part1goal | number:2"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>PART II - Personal Core Competencies</td>
                            <td style="text-align:center;">50%</td>
                            <td style="text-align:center;"><span ng-bind="totalCompetencyWeightRating|number:2"></span></td>
                            <td style="text-align:center;">
                                <span ng-bind="part2competency | number:2"></span>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td style="text-align:center;"></td>
                            <td style="text-align:right;font-weight:bold;">Total:</td>
                            <td style="text-align:center;border-top:1px solid #fff;" >
                                <span ng-bind="round2(record.evaluation_score)"></span>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight:bold;text-align:right;">Overall Performance : </td>
                            <td style="text-align:center;"><span ng-bind="record.total_computed_score = round2(record.evaluation_score)"></span></td>
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;"></td>
                        </tr>

                        <tr>
                            <!--<td style="font-weight:bold;text-align:right;">Percentage Equivalent : </td>-->
                            <!--<td style="text-align:center;"><span id="pe">0</span>%</td>-->
                            <td style="text-align:center;background-color:#fff;font-weight:bold;color:#06A716;" colspan="4">
                                <p class="note5 note" style="color:#06A716;" ng-show="record.total_computed_score == 5">(<i class="fa fa-thumbs-up"></i>) This Employee is Exceptional</p>
                                <p class="note4 note" style="color:#06A716;" ng-show="record.total_computed_score < 5 && record.total_computed_score >= 4">(<i class="fa fa-thumbs-up"></i>) This Employee Exceeds Expectations</p>
                                <p class="note3 note" style="color:#06A716;" ng-show="record.total_computed_score < 4 && record.total_computed_score >= 3">(<i class="fa fa-thumbs-up"></i>) This Employee Meets Expectations</p>
                                <p class="note2 note" style="color:#06A716;" ng-show="record.total_computed_score < 3 && record.total_computed_score >= 2">(<i class="fa fa-thumbs-up"></i>) This Employee Needs Improvement</p>
                                <p class="note1 note" style="color:#A70606;" ng-show="record.total_computed_score < 2 && record.total_computed_score >= 1">(<i class="fa fa-thumbs-down"></i>) This Employee Does Not Meet Expectation</p>
                                <p class="note0 note" style="color:#06A716;" ng-show="record.total_computed_score == 0">No Performance Evaluation Score</p>
                            </td>
                        </tr>
                    </table><br />

                    <div style="border:1px solid #fff;padding-left:5px;padding-right:5px;width:98%;">
                        <h4>VI. DEVELOPMENT PLAN</h4>
                        <p>A. Key competencies to strengthen performance in current job (set by reviewing mgr):</p>
                        <textarea spellcheck='true'  style="width:99%;" class="checker" rows="3" 
                                ng-model="record.DevPlanA" 
                                ng-disabled="is_approved" 
                                ng-class="{'ng-invalid': !record.DevPlanA || record.DevPlanA.length < 25, 
                                            'ng-valid': record.DevPlanA && record.DevPlanA.length >= 25}">
                        </textarea><br>
                        <small ng-show="record.DevPlanA.length < 25 && record.DevPlanA.length > 0" 
                        class='warningMsg'>
                            * Must be at least 25 characters long.
                        </small>
                        <!--<p>B. Employee desired career path within next 2 to 3 years (set by job holder):</p>
                        <textarea spellcheck="true"  style="width:99%;" class="smltxtbox"></textarea>-->
                        <p>B. Key competencies needed to advance in employee desired career path (set by reviewing mgr):</p>
                        
                        <textarea spellcheck='true'  style="width:99%;" class="checker" rows="3" 
                                ng-model="record.DevPlanB" 
                                ng-disabled="is_approved" 
                                ng-class="{'ng-invalid': !record.DevPlanB || record.DevPlanB.length < 25, 
                                            'ng-valid': record.DevPlanB && record.DevPlanB.length >= 25}">
                        </textarea><br>
                        <small ng-show="record.DevPlanB.length < 25 && record.DevPlanB.length > 0" 
                        class='warningMsg'>
                            * Must be at least 25 characters long.
                        </small>
                        <p>C. Planned development / training activities (agreed by reviewing mgr and as per the following priority / feasibility order):</p>
                        <textarea spellcheck='true'  style="width:99%;" class="checker" rows="3" 
                                ng-model="record.DevPlanC" 
                                ng-disabled="is_approved" 
                                ng-class="{'ng-invalid': !record.DevPlanC || record.DevPlanC.length < 25, 
                                            'ng-valid': record.DevPlanC && record.DevPlanC.length >= 25}">
                        </textarea><br>
                        <small ng-show="record.DevPlanC.length < 25 && record.DevPlanC.length > 0" 
                        class='warningMsg'>
                            * Must be at least 25 characters long.
                        </small>
                    </div>
                    <br />

                    <div style="border:1px solid #fff;padding-left:5px;width:98.6%;">
                        <div ng-show="record.Rater2Comment != null && (record.for_approval_level > 2 || is_approved)">
                            <h4><span ng-bind="record.Rater2FullName"></span>' Comment</h4>
                            <p ng-bind="record.Rater2Comment"></p>
                        </div>
                        <div ng-show="record.Rater3Comment != null && (record.for_approval_level > 3 || is_approved)">
                            <h4><span ng-bind="record.Rater3FullName"></span>' Comment</h4>
                            <p ng-bind="record.Rater3Comment"></p>
                        </div>
                        <div ng-show="record.Rater4Comment != null && (record.for_approval_level > 4 || is_approved)">
                            <h4><span ng-bind="record.Rater4FullName"></span>' Comment</h4>
                            <p ng-bind="record.Rater4Comment"></p>
                        </div>
                        <div ng-show="record.status == 'Incomplete' && !is_approved">
                            <!-- <hr> -->
                            <h4 ng-show="!is_approved">EVALUATION COMMENT</h4>
                            <textarea spellcheck="true"  ng-model="record.Rater2Comment" class="checker" style="width:98.4%;min-height:100px;" ng-show="record.for_approval_level == 2 && !is_approved"  ng-disabled="is_approved"></textarea>
                            <textarea spellcheck="true"  ng-model="record.Rater3Comment" class="checker" style="width:98.4%;min-height:100px;" ng-show="record.for_approval_level == 3 && !is_approved"  ng-disabled="is_approved"></textarea>
                            <textarea spellcheck="true"  ng-model="record.Rater4Comment" class="checker" style="width:98.4%;min-height:100px;" ng-show="record.for_approval_level == 4 && !is_approved"  ng-disabled="is_approved"></textarea>
                            <span style="font-style:italic;margin-left:5px;font-size:10px;">Note: Salary increase will be based on the Overall Performance Rating.</span>
                        </div>
                    </div>
                    <br>
                    
                    <?php if(isset($_GET['page']))
                            if($_GET['page'] !== 'result') { ?>
                    <!-- <h3 style="">
                        <strong>Equivalent system generated percentage increase: </strong>
                        <span id="sys_gen_inc" ng-bind="record.system_increase | number:2"></span>%
                    </h3> -->

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



                <button type="button" class="subapp smlbtn" id="submapp" style="float:right;margin-right:10px;"  ng-show="!is_approved">Submit Appraisal</button>
                <button type="button" class="saveapp smlbtn" id="saveapp" style="float:right;background-color:#3EC2FB;margin-right:10px;" ng-click="save()"  ng-show="!is_approved">Save Appraisal</button>
                
                <?php }else{ ?>

                    <div style="border:1px solid #fff;padding-left:5px;width:98.6%;">
                        <h4>Employee Comment </h4>
                        <textarea spellcheck="true" id="EmployeeAccept" class="checker" style="width:98.4%;min-height:100px;" ng-show="is_approved" ng-hide="record.EmpComment != null"></textarea>
                        <div ng-show="record.EmpComment != null && is_approved">
                            <p ng-bind="record.EmpComment"></p>
                        </div>
                    </div>
                    <br>
                    <button type="button" class="subapp smlbtn" id="submapp" style="float:right;margin-right:10px;"  ng-show="is_approved && record.EmpComment == null" ng-click="accept()">Accept Evaluation</button>

                <?php } ?>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    // angular retrieve record from https://dev.megaworldcorp.com/test
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

                if($scope.record != ''){
                    $scope.record.ApproverEmpID = $scope.ApproverEmpID;
                    $scope.record.ApproverEmpDB = $scope.ApproverEmpDB;
                    $scope.record.system_increase = parseFloat($scope.record.system_increase);
                    $scope.record.recommended_salary_increase = $scope.record.recommended_salary_increase == 0 ? '' : parseFloat($scope.record.recommended_salary_increase);
                    $scope.record.total_computed_score = parseFloat($scope.record.total_computed_score);
                    $scope.is_approved = false;
                    $scope.updateRecord();

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

                    if($scope.record.status == 'Completed')
                        $scope.is_approved = true;

                    if($scope.record.goals_next.length === 0){
                        for (let index = 0; index < 3; index++) {
                            $scope.addNextGoal();
                        }
                    }

                    for(let i = $scope.record.competencies_next.length; i < 10; i++){
                        $scope.addNextPcc();
                    }
                }

                $scope.loading = false;
            },
            function errorCallback(response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                    console.error("Error while retrieving record", response);
                    $scope.loading = true;
                    window.location.reload();

        });

        $scope.formatDate = function(date){
            var dateOut = new Date(date);
            return dateOut;
        };

        $scope.updateRecord = function(){
            $scope.totalGoalAchievement = $scope.record.goals.reduce(function(total, goal) {
                return total + (parseFloat(goal.Weight) || 0);
                //return total + (parseFloat(goal.Achievement) * parseFloat(goal.Weight) / 100 || 0);
            }, 0);

            $scope.totalGoalWeightRating = $scope.record.goals.reduce(function(total, goal) {
                weightedRating = $scope.round2((goal.Achievement * goal.Weight * goal.Rating) / 10000) || 0;
                total += weightedRating;

                return total;
            }, 0);

            $scope.totalCompetencyWeight= $scope.record.competencies.reduce(function(total, competency) {
                return total + (parseFloat(competency.Weight) || 0);
            }, 0);

            $scope.totalCompetencyWeightRating = $scope.record.competencies.reduce(function(total, competency) {
                weightedRating = $scope.round2(competency.Rating * competency.Weight / 100) || 0;
                total += weightedRating;
                return total
            }, 0);

            $scope.totalNextCompetencyWeight = $scope.record.competencies_next.reduce(function(total, competency) {
                return total + ( parseFloat(competency.Weight) || 0);
            }, 0);

            $scope.totalNextGoalWeight = $scope.record.goals_next.reduce(function(total, goal) {
                return total + (  parseFloat(goal.Weight)  || 0);
            }, 0);

            if($scope.record.Rater4EmpID != null && $scope.record.Rater4DB != null && $scope.record.Rater4PositionPromotion != null){
                $scope.finalPositionPromotion = $scope.record.Rater4PositionPromotion;

            }else if($scope.record.Rater3EmpID != null && $scope.record.Rater3DB != null && $scope.record.Rater3PositionPromotion != null){
                $scope.finalPositionPromotion = $scope.record.Rater3PositionPromotion;

            }else if($scope.record.Rater2EmpID != null && $scope.record.Rater2DB != null && $scope.record.Rater2PositionPromotion != null){
                $scope.finalPositionPromotion = $scope.record.Rater2PositionPromotion;
                
            }else if($scope.record.Rater1EmpID != null && $scope.record.Rater1DB != null && $scope.record.Rater1PositionPromotion != null){
                $scope.finalPositionPromotion = $scope.record.Rater1PositionPromotion;       
            }

            if($scope.record.Rater4EmpID != null && $scope.record.Rater4DB != null && $scope.record.for_approval_level == 4){
                $scope.finalRankPromotion = $scope.record.Rater4RankPromotion;
            }else if($scope.record.Rater3EmpID != null && $scope.record.Rater3DB != null && $scope.record.for_approval_level == 3){
                $scope.finalRankPromotion = $scope.record.Rater3RankPromotion;
            }else if($scope.record.Rater2EmpID != null && $scope.record.Rater2DB != null && $scope.record.for_approval_level == 2){
                $scope.finalRankPromotion = $scope.record.Rater2RankPromotion;
                
            }else if($scope.record.Rater1EmpID != null && $scope.record.Rater1DB != null && $scope.record.for_approval_level == 1){
                $scope.finalRankPromotion = $scope.record.Rater1RankPromotion;       
            }

            if($scope.record.Rater4EmpID != null && $scope.record.Rater4DB != null && $scope.record.Rater4Increase != null){
                $scope.finalRecommendedIncrease = parseFloat($scope.record.Rater4Increase);
            }else if($scope.record.Rater3EmpID != null && $scope.record.Rater3DB != null && $scope.record.Rater3Increase != null){
                $scope.finalRecommendedIncrease = parseFloat($scope.record.Rater3Increase);
            }else if($scope.record.Rater2EmpID != null && $scope.record.Rater2DB != null && $scope.record.Rater2Increase != null){
                $scope.finalRecommendedIncrease = parseFloat($scope.record.Rater2Increase);
                
            }else if($scope.record.Rater1EmpID != null && $scope.record.Rater1DB != null && $scope.record.Rater1Increase != null){
                $scope.finalRecommendedIncrease = parseFloat($scope.record.Rater1Increase);  
            }

            $scope.part2competency = parseFloat(($scope.totalCompetencyWeightRating).toFixed(2)) * 50/100;
            $scope.part1goal = parseFloat(($scope.totalGoalWeightRating).toFixed(2))  * 50/100;
            $scope.record.evaluation_score = $scope.round2($scope.part2competency) + $scope.round2($scope.part1goal);

            $scope.record.total_computed_score = parseFloat($scope.record.evaluation_score);

            let percentage_increase = parseFloat($scope.record.group.RegularIncrease);
            if($scope.finalRankPromotion != 'NOT FOR PROMOTION')
                percentage_increase = parseFloat($scope.record.group.PromotionalIncrease);
            

            //system_increase matrix
            
            if($scope.record.total_computed_score <= 5.00 && $scope.record.total_computed_score >= 4.50){
                $scope.record.system_increase = 8;
            }
            else if($scope.record.total_computed_score <= 4.49 && $scope.record.total_computed_score >= 4.00){
                $scope.record.system_increase = 6;
            }
            else if($scope.record.total_computed_score <= 3.99 && $scope.record.total_computed_score >= 3.00){
                $scope.record.system_increase = 4;
            }
            else if($scope.record.total_computed_score < 3.00){
                $scope.record.system_increase = 0;
            }

        }

        $scope.trustHTML = function(html){
            return $sce.trustAsHtml(html);
        }

        $scope.addNextGoal = function (){
            var newGoal = {
                "EvaluationID": '<?php echo $_GET['ratee']; ?>',
                "Objective":  "",
                "MeasureOfSuccess": "",
                "Weight": 0,
                "id": null
            }

            $scope.record.goals_next.push(newGoal);
        }

        $scope.addNextPcc = function(){
            var newPCC = {
                "EvaluationID": '<?php echo $_GET['ratee']; ?>',
                "Competency":  "",
                "Description": "",
                "Weight": 0,
                "id": null,
                "SeqOrder": 1
            }

            $scope.record.competencies_next.push(newPCC);
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
                        $scope.loading = false;
                        console.error("Error while saving record", response);
                        $scope.validate();
            });
        }

        $scope.submit = function(){
            if($scope.validate()){
                $scope.record.submit = true;
                $scope.save();
            }
        }

        $scope.accept = function(){
            $scope.record.EmpComment = $("#EmployeeAccept").val();
            $scope.record.accept = true;
            $scope.save();
        }

        $scope.validate = function(){
            if($scope.myForm.$invalid || $scope.isAnyTextAreaInvalid()){
                $('input.ng-invalid').first().focus();
                $('textarea.ng-invalid').first().focus();
                $('select.ng-invalid').first().focus();
                alert('Please check all required inputs!');
            }

            return !$scope.myForm.$invalid && !$scope.isAnyTextAreaInvalid();
        };
        
        $scope.fields = [
            { model: 'record.DevPlanA', minLength: 25 },
            { model: 'record.DevPlanB', minLength: 25 },
            { model: 'record.DevPlanC', minLength: 25 },
            { model: 'record.PerformanceSummary', minLength: 25 }
        ];

        $scope.repeatFields = [
            { cluster: 'record.goals_next', model: 'next_goal.MeasureOfSuccess', minLength: 25 },
            { cluster: 'record.goals_next', model: 'next_goal.Objective', minLength: 25 },
            { cluster:'record.competencies', model: 'competency.Remarks', minLength: 25 },
            { cluster:'record.goals', model: 'goal.Comments', minLength: 25 },
            { cluster:'record.goals', model: 'goal.ResultsAchieved', minLength: 25 }
        ];

        $scope.isAnyTextAreaInvalid = function() {
            const invalidFields = $scope.fields.some(function(field) {
                return !$scope.$eval(field.model) || $scope.$eval(field.model).length < field.minLength;
            });

            let invalidRepeatFields = false;

            $scope.repeatFields.forEach(function(field) {
                const clusterItems = $scope.$eval(field.cluster); 

                if (Array.isArray(clusterItems)) {
                    clusterItems.forEach(function(item, index) {
                        const modelValue = $scope.$eval(`${field.cluster}[${index}].${field.model.split('.')[1]}`);
                        if(field.cluster=='record.competencies'){
                            if (item.Rating != 3 && (!modelValue || modelValue.length < field.minLength)) {
                                invalidRepeatFields = true;
                            }
                        }
                        else{
                            if (!modelValue || modelValue.length < field.minLength) {
                                invalidRepeatFields = true;
                            }
                        }
                    });
                } else {
                    const modelValue = $scope.$eval(field.model);
                    if (!modelValue || modelValue.length < field.minLength) {
                        invalidRepeatFields = true;
                    }
                }
            });

            return invalidFields || invalidRepeatFields;
        };

        $scope.round2 = function(num){
            // return +num.toFixed(2);
            if(num ==  null || num == undefined || isNaN(num)) 
                return 0;

            return Math.round((num + 0.00000001) *100)/100;
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

 </script>

<?php include('session.php'); ?>