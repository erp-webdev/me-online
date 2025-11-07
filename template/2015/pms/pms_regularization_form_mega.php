<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<link rel="stylesheet" href="<?php echo CSS; ?>/SpellChecker/spellcheck.css">
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

    .warningMsg{
        color: #ffb649; 
        font-weight: bold;
        /* background-color: #FFE57D;  */
        padding: 5px;
    }

    .feedback-trigger {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 10px;
        font-weight: bold;
        color: #4da3ff;   
        cursor: pointer;
        text-decoration: none;
        padding: 4px 8px;
        border-radius: 4px;
        transition: background-color 0.2s ease;
    }

    .feedback-trigger:hover {
        background-color: rgba(13, 110, 253, 0.1);
        text-decoration: underline;
    }

    .floating-feedback {
        position: absolute;
        bottom: 20px;
        right: 20px;
        width: 360px;
        height: auto;
        max-height: 330px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.7);
        background: #1e2a38; /* Dark blue-gray */
        border-radius: 8px;
        padding: 10px 0;
        font-family: Arial, sans-serif;
        z-index: 999;
        color: #e6e6e6; /* Light text */
        overflow: hidden;
    }

    .feedback-content {
        height: 250px;
        overflow: auto;
    }

    /* Scrollbar styling inside feedback-content */
    .feedback-content::-webkit-scrollbar {
        width: 10px;
    }

    .feedback-content::-webkit-scrollbar-track {
        background: #1e2a38;
    }

    .feedback-content::-webkit-scrollbar-thumb {
        background-color: #3a4a5c;
        border-radius: 5px;
    }

    .feedback-content::-webkit-scrollbar-thumb:hover {
        background-color: #4d5f73;
    }


    .feedback-header-title {
        font-size: 16px;
        font-weight: 600;
        color: #4da3f1; /* Accent blue */
        padding: 10px 16px;
        border-bottom: 1px solid #2d3b4b;
    }

    .feedback-item {
        padding: 12px 16px;
        border-bottom: 1px solid #2b3a49;
    }

    .feedback-header {
        display: flex;
        align-items: center;
        margin-bottom: 6px;
    }

    .avatar {
        width: 34px;
        height: 34px;
        background-color: #3a6ea5; /* Muted blue */
        border-radius: 50%;
        color: #fff;
        font-size: 16px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 10px;
    }

    .author {
        font-size: 12px;
        font-weight: bold;
        display: block;
        color: #ffffff;
    }

    .date {
        color: #9fb3c9;
    }

    .remarks {
        white-space: pre-wrap;
        font-size: 14px;
        margin-left: 45px;
        color: #dcdcdc;
    }

    .resolve-btn {
        display: inline-block;
        margin: 7px;
        padding: 6px 12px;
        font-size: 13px;
        background-color: #3a6ea5; /* Change as needed */
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        float: right;
    }

    .resolve-btn:hover {
        background-color: #4b82c2;
    }

    .done{
        color:#4b82c2;
        float: right;
        font-size: 12px;
    }

    .action-comment{
        padding: 10px;
    }
</style>

<div class="rightsplashtext lefttalign">
    <div ng-app='myApp' ng-controller='myCtrl' id="paf" class="mainbody lefttalign whitetext">
        <form  name="myForm" ng-show="record != ''">
           <div class="loading-screen" ng-show="loading">
                <div class="spinner"></div>
                <p class="blacktext">Just a moment while we set things up</p>
            </div>

            <div id='evaluation-form-wrapper'>
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
                            <td colspan="7" style="text-align:center;font-weight:bold;color:#A70606;">
                                <span ng-show="(record.hr_comments | filter:{ 
                                        EvaluationID: record.EvaluationID,
                                        ReadAt: null, 
                                        AssignedTo: '<?php echo $profile_idnum.'|'.$profile_dbname; ?>' }).length == 0">
                                    This evaluation form has been completed.
                                </span>
                                <span ng-show="(record.hr_comments | filter:{ 
                                        EvaluationID: record.EvaluationID,
                                        ReadAt: null, 
                                        AssignedTo: '<?php echo $profile_idnum.'|'.$profile_dbname; ?>' }).length > 0">
                                    You have pending HR feedback. Click <i style="color:blue;">View Feedback</i> in any section that includes feedback to review and complete the required updates. The section will remain open until all items in that section are marked as done.
                                </span>
                            </td>
                        </tr>
                    </table>
                    <br />
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
                        <p><i>This Performance Appraisal Form aims to provide a formal, recorded, regular review of an individual's performance and competencies. It is to be used for annual evaluations, and at other times during the year when formal feedback is needed.</i></p>
                        <p><i>This is a four (4) part Appraisal Form which are as follows:</i></p>
                        <!-- Part 1 -->
                        <p>
                            <b class="smallesttext lwhitetext">Part I - Competency Assessment</b>
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
                        <p>
                            <b class="smallesttext lwhitetext">Part IV - Individual Development Plan</b>
                            <br />
                            Action plan on how to close the competency gap/s improve future employee performance.
                        </p>

                        <div ng-show="record.competencies.length > 0">
                            <hr>
                            <br />
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
                            <br>
                            <p>
                                <b class="smalltext lwhitetext">Part I - Competency Assessment</b><br />
                            </p>
                            <table id="comass" border="0" cellspacing="0" class="tdata" style="width:99%;">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th width="60%;">Competency</th>
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
                                        <td class='textareaGroup'>
                                            <b ng-bind="competency.Competency"></b>
                                            <a type="button"
                                                class="add-comment-btn feedback-trigger"
                                                ng-show="(record.hr_comments | filter:{ 
                                                    Section: 'current_competencies', 
                                                    PartID: competency.id,
                                                    ReadAt: null, 
                                                    AssignedTo: '<?php echo $profile_idnum.'|'.$profile_dbname; ?>' }).length > 0"
                                                data-field="current_competencies"
                                                data-partid="{{ competency.id }}">View Feedback</a>
                                            <br>
                                            <br>
                                            <span ng-bind-html="displayDescription(competency.Description)"></span>
                                            <!-- <i ng-show="competency.Type == 'CORE'" class="jobdesc-btn" style="cursor: pointer"> Click to see description </i>
                                            <div class="jobdesc-popup">
                                                <span  ng-bind="competency.Description"></span>
                                            </div> -->
                                            <br><br>
                                            <strong>Remarks</strong> <br>
                                            <textarea ng-class="is_approved && (record.hr_comments | filter:{ 
                                                    Section: 'current_competencies', 
                                                    PartID: competency.id,
                                                    ReadAt: null, 
                                                    AssignedTo: '<?php echo $profile_idnum.'|'.$profile_dbname; ?>' }).length == 0 ? '' : 'spellcheck' "
                                                    spellcheck='true' cols="60" rows="3"  placeholder="Add your remarks" 
                                                    class="checker caRemarks" 
                                                    ng-model="competency.Remarks" 
                                                    ng-disabled="is_approved && (record.hr_comments | filter:{ 
                                                    Section: 'current_competencies', 
                                                    PartID: competency.id,
                                                    ReadAt: null, 
                                                    AssignedTo: '<?php echo $profile_idnum.'|'.$profile_dbname; ?>' }).length == 0" 
                                                    minlength='25' required>
                                            </textarea>
                                            <br>
                                            <small class='warningMsg' style="display:none;">
                                                * This is a required field. Must be at least 25 characters long.
                                            </small><br>
                                        </td>
                                        <td style="text-align:center;width:25px;">
                                            <span ng-bind="competency.RequiredProficiency"></span>
                                        </td>
                                        <td style="text-align:center;width:25px;">
                                            <input type="number" class="width50 smltxtbox actp " min="1" max="5" onkeypress="return (event.charCode >= 49 && event.charCode <= 53) || event.charCode==8" onKeyDown="if(this.value.length==1 && event.keyCode!=8 ) return false;" onfocusin="(this.value == 0) ? this.value = '' : false" onfocusout="(this.value == '') ? this.value = 0 : false" ng-model="competency.ActualProficiency" ng-disabled="is_approved" ng-change="competency.Gaps = compute_gaps(competency); updateRecord()" required>
                                        </td>
                                        <td style="text-align:center;width:25px;">
                                            <span ng-bind="competency.Gaps"></span>
                                        </td>
                                        <!-- <td style="text-align:left;">
                                            <textarea spellcheck="true"  ng-model="competency.Remarks" cols="20" rows="2" placeholder="Add your remarks" ng-disabled="is_approved" required class="checker caRemarks"></textarea>
                                        </td> -->
                                        
                                    </tr>

                                    <tr>
                                        <th colspan="5"><u>Job-Specific</u></th>
                                    </tr>

                                    <tr ng-repeat="competency in record.competencies" ng-if="competency.Type == 'JOB-SPECIFIC'">
                                        <td style="vertical-align: top;"><span ng-bind="$index + 1"></span></td>
                                        <td class='textareaGroup'>
                                            <b ng-bind="competency.Competency" ></b>
                                            <a type="button"
                                                class="add-comment-btn feedback-trigger"
                                                ng-show="(record.hr_comments | filter:{ 
                                                    Section: 'current_competencies', 
                                                    PartID: competency.id,
                                                    ReadAt: null, 
                                                    AssignedTo: '<?php echo $profile_idnum.'|'.$profile_dbname; ?>' }).length > 0"
                                                data-field="current_competencies"
                                                data-partid="{{ competency.id }}">View Feedback</a>
                                            <br><br>
                                            <strong>Remarks</strong><br>
                                            <textarea ng-class="is_approved && (record.hr_comments | filter:{ 
                                                    Section: 'current_competencies', 
                                                    PartID: competency.id,
                                                    ReadAt: null, 
                                                    AssignedTo: '<?php echo $profile_idnum.'|'.$profile_dbname; ?>' }).length == 0 ? '' : 'spellcheck' "
                                                    spellcheck='true' cols="60" rows="3"  placeholder="Add your remarks" 
                                                    class="checker caRemarks" 
                                                    ng-model="competency.Remarks" 
                                                    ng-disabled="is_approved && (record.hr_comments | filter:{ 
                                                    Section: 'current_competencies', 
                                                    PartID: competency.id,
                                                    ReadAt: null, 
                                                    AssignedTo: '<?php echo $profile_idnum.'|'.$profile_dbname; ?>' }).length == 0" 
                                                    minlength='25' required>
                                            </textarea>
                                            <br>
                                            <small class='warningMsg' style="display:none;">
                                                * This is a required field. Must be at least 25 characters long.
                                            </small>
                                        </td>
                                        <td style="text-align:center;width:25px;">
                                            <span ng-bind="competency.RequiredProficiency"></span>
                                        </td>
                                        <td style="text-align:center;width:25px;">
                                            <input type="number" class="width50 smltxtbox actp " min="1" max="5" onkeypress="return (event.charCode >= 49 && event.charCode <= 53) || event.charCode==8" onKeyDown="if(this.value.length==1 && event.keyCode!=8) return false;" onfocusin="(this.value == 0) ? this.value = '' : false" onfocusout="(this.value == '') ? this.value = 0 : false" ng-model="competency.ActualProficiency" ng-disabled="is_approved" ng-change="updateRecord()" required>
                                        </td>
                                        <td style="text-align:center;width:25px;">
                                            <span ng-bind="competency.Gaps"></span>
                                        </td>
                                        <!-- <td style="text-align:left;">
                                            <textarea spellcheck="true"  ng-model="competency.Remarks" cols="20" rows="2" placeholder="Add your remarks" ng-disabled="is_approved" required class="checker caRemarks"></textarea>
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
                                    <td class='textareaGroup'>
                                        <textarea spellcheck="true"  class="checker" cols="80" rows="3" ng-model ="goal.Goals" required ng-bind="goal.Goals" ng-disabled="goal.id != null || goal.Goals == '8 hrs mandatory training'" placeholder="Provide SMART Goal" ng-attr-minlength="{{goal.id == null ? 25 : 0}}" ng-class="goal.id == null ? 'spellcheck' : '' "></textarea>
                                        <br>
                                        <b ng-show="goal.Goals != '8 hrs mandatory training'">Measure of Success</b>
                                        <br>
                                        <textarea spellcheck="true"  class="checker" cols="80" rows="3" ng-required="goal.Goals != '8 hrs mandatory training' && goal.id == null" ng-model="goal.MeasureOfSuccess" ng-disabled="goal.id != null || goal.Goals == '8 hrs mandatory training' || is_approved"  ng-show="goal.Goals != '8 hrs mandatory training' && goal.id == null" placeholder="Provide measure of success" ng-attr-minlength="{{goal.id == null ? 25 : 0}}" ng-class="goal.id == null ? 'spellcheck' : '' "></textarea>
                                        <span ng-bind="goal.MeasureOfSuccess"  ng-show="goal.Goals != '8 hrs mandatory training' && goal.id != null"></span>
                                        <br> <br>
                                        <strong>Comments</strong>
                                        <a type="button"
                                        class="add-comment-btn feedback-trigger"
                                        ng-show="(record.hr_comments | filter:{ 
                                            Section: 'current_goal', 
                                            PartID: goal.id,
                                            ReadAt: null, 
                                            AssignedTo: '<?php echo $profile_idnum.'|'.$profile_dbname; ?>' }).length > 0"
                                        data-field="current_goal"
                                        data-partid="{{ goal.id }}">View Feedback</a><br>
                                        <textarea ng-class="is_approved && (record.hr_comments | filter:{ 
                                                    Section: 'current_goal', 
                                                    PartID: goal.id,
                                                    ReadAt: null, 
                                                    AssignedTo: '<?php echo $profile_idnum.'|'.$profile_dbname; ?>' }).length == 0 ? '' : 'spellcheck' "
                                                spellcheck='true' cols="80" rows="2" placeholder="Provide your comments" 
                                                class="checker" 
                                                ng-model="goal.Comments"
                                                ng-disabled="is_approved && (record.hr_comments | filter:{ 
                                                    Section: 'current_goal', 
                                                    PartID: goal.id,
                                                    ReadAt: null, 
                                                    AssignedTo: '<?php echo $profile_idnum.'|'.$profile_dbname; ?>' }).length == 0" 
                                                minlength='25' required>
                                        </textarea>
                                        <br>
                                        <small class='warningMsg' style="display:none;">
                                            * This is a required field. Must be at least 25 characters long.
                                        </small>
                                        <span ng-show="goal.id == null && goal.Goals != '8 hrs mandatory training'">
                                        <br><br>
                                        <a class="smlbtn" id="delrowg" style="background-color:#D20404;" ng-click="deleteGoal($index)">Delete</a>
                                        </span>
                                        
                                    </td>
                                    <td style="text-align:center;">
                                        <input type="number" clas="width50 smltxtbox actp " min="1" max="5" onkeypress="return (event.charCode >= 49 && event.charCode <= 53) || event.charCode==8" onKeyDown="if(this.value.length==1 && event.keyCode!=8) return false;" onfocusin="(this.value == 0) ? this.value = '' : false" onfocusout="(this.value == '') ? this.value = 0 : false" ng-model="goal.Grade" ng-disabled="goal.Goals == '8 hrs mandatory training' || is_approved" ng-change="updateRecord()" required>
                                    </td>
                                    <!-- <td style="text-align:center;">
                                        <textarea spellcheck="true"  class="checker" cols="20" rows="2" ng-model="goal.Comments" placeholder="Provide your comments" ng-disabled="is_approved"></textarea>
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
                                    <td class='textareaGroup'>
                                        <textarea ng-class="is_approved && (record.hr_comments | filter:{ 
                                                Section: 'next_goal', 
                                                PartID: goal.id,
                                                ReadAt: null, 
                                                AssignedTo: '<?php echo $profile_idnum.'|'.$profile_dbname; ?>' }).length == 0 ? '' : 'spellcheck' "
                                            spellcheck='true' cols="40" rows="3" 
                                            class="checker" 
                                            ng-model="goal.Goals" 
                                            ng-disabled="is_approved && (record.hr_comments | filter:{ 
                                                Section: 'next_goal', 
                                                PartID: goal.id,
                                                ReadAt: null, 
                                                AssignedTo: '<?php echo $profile_idnum.'|'.$profile_dbname; ?>' }).length == 0" 
                                            minlength='25' required>
                                        </textarea>
                                        <a type="button"
                                        class="add-comment-btn feedback-trigger"
                                        ng-show="(record.hr_comments | filter:{ 
                                            Section: 'next_goal', 
                                            PartID: goal.id,
                                            ReadAt: null, 
                                            AssignedTo: '<?php echo $profile_idnum.'|'.$profile_dbname; ?>' }).length > 0"
                                        data-field="next_goal"
                                        data-partid="{{ goal.id }}">View Feedback</a>
                                        <br>
                                        <small class='warningMsg' style="display:none;">
                                            * This is a required field. Must be at least 25 characters long.
                                        </small>
                                    </td>
                                    <td class='textareaGroup'>
                                        <textarea ng-class="is_approved && (record.hr_comments | filter:{ 
                                                Section: 'next_goal', 
                                                PartID: goal.id,
                                                ReadAt: null, 
                                                AssignedTo: '<?php echo $profile_idnum.'|'.$profile_dbname; ?>' }).length == 0 ? '' : 'spellcheck' "
                                                spellcheck='true' cols="40" rows="3" 
                                                class="checker" 
                                                ng-model="goal.MeasureOfSuccess" 
                                                ng-disabled="is_approved && (record.hr_comments | filter:{ 
                                                Section: 'next_goal', 
                                                PartID: goal.id,
                                                ReadAt: null, 
                                                AssignedTo: '<?php echo $profile_idnum.'|'.$profile_dbname; ?>' }).length == 0" 
                                                minlength='25' required>
                                        </textarea>
                                        <a type="button"
                                        class="feedback-trigger"
                                        ng-show="(record.hr_comments | filter:{ 
                                            Section: 'next_goal', 
                                            PartID: goal.id,
                                            ReadAt: null, 
                                            AssignedTo: '<?php echo $profile_idnum.'|'.$profile_dbname; ?>' }).length > 0">&nbsp;</a>
                                        <br>
                                        <small class='warningMsg' style="display:none;">
                                            * This is a required field. Must be at least 25 characters long.
                                        </small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <a class="smlbtn"style="background-color:#3EC2FB;" ng-show="!is_approved" ng-click="addNextGoal()">Add Row</a>
                        <hr>
                        <p>
                            <b class="smalltext lwhitetext">Part VI - Individual Development Plan</b><br />
                        </p>
                        <table id="comass" border="0" cellspacing="0" class="tdata" style="width:99%;">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th width="60%;">Summary of Competency Gaps</th>
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
                                    
                                    <tr ng-repeat="competency in record.competencies" ng-if="competency.Type == 'CORE' && competency.Gaps != 0">
                                        <td style="vertical-align: top;"></td>
                                        <td>
                                            <b ng-bind="competency.Competency"></b>
                                            <br>
                                            Remarks: <span ng-bind-html="displayDescription(competency.Remarks)"></span>
                                            <br>
                                            <br>
                                        </td>
                                        <td style="text-align:center;width:25px;">
                                            <span ng-bind="competency.RequiredProficiency"></span>
                                        </td>
                                        <td style="text-align:center;width:25px;">
                                            <span ng-bind="competency.ActualProficiency"></span>
                                        </td>
                                        <td style="text-align:center;width:25px;">
                                            <span ng-bind="competency.Gaps"></span>
                                        </td>
                                        
                                    </tr>

                                    <tr>
                                        <th colspan="5"><u>Job-Specific</u></th>
                                    </tr>

                                    <tr ng-repeat="competency in record.competencies" ng-if="competency.Type == 'JOB-SPECIFIC' && competency.Gaps != 0">
                                        <td style="vertical-align: top;"><span ng-bind="$index + 1"></span></td>
                                        <td>
                                            <b ng-bind="competency.Competency" ></b>
                                            <br><br>
                                            Remarks: <span ng-bind-html="displayDescription(competency.Remarks)"></span>
                                        </td>
                                        <td style="text-align:center;width:25px;">
                                            <span ng-bind="competency.RequiredProficiency"></span>
                                        </td>
                                        <td style="text-align:center;width:25px;">
                                            <span ng-bind="competency.ActualProficiency"></span>
                                        </td>
                                        <td style="text-align:center;width:25px;">
                                            <span ng-bind="competency.Gaps"></span>
                                        </td>
                                    </tr>

                                </tbody>

                            </table>

                        <h4 style="text-align:center;"> Final Summary </h4>
                        <table style="border:2px solid #fff;width:99%;">
                            <thead>
                            <tr>
                                <th style="text-align:left;width:350px;">A. PERFORMANCE EVALUATION - 100%</th>
                                <th style="text-align:center;">% Value</th>
                                <th style="text-align:center;">Rate</th>
                                <th style="text-align:center;">Final Value</th>
                            </tr>
                            </thead>
                            <tr>
                                <td>Competency Assessment </td>
                                <td style="text-align:center;">30%</td>
                                <td style="text-align:center;"><span ng-bind="totalCompetency"></span></td>
                                <td style="text-align:center;" >
                                    <span ng-bind="(totalCompetency*30/100) | number:2"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>Goals Covered Under The Evaluation Period</td>
                                <td style="text-align:center;">70%</td>
                                <td style="text-align:center;"><span ng-bind="totalGoal"></span></td>
                                <td style="text-align:center;" >
                                    <span ng-bind="(totalGoal*70/100) | number:2"></span>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="text-align:center;"></td>
                                <td style="text-align:right;font-weight:bold;">Total:</td>
                                <td style="text-align:center;border-top:1px solid #fff;">
                                    <span  ng-bind="record.evaluation_score | number:2"></span>
                                </td>
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

                        <div style="border:1px solid #fff;padding-left:5px;width:98.6%;">
                            <h4>
                                VI. PERFORMANCE SUMMARY 
                                <span style="font-size:10px;font-weight:normal;">(Written by Reviewing Manager)</span>
                                <a type="button"
                                    class="add-comment-btn feedback-trigger"
                                    ng-show="(record.hr_comments | filter:{ 
                                        Section: 'PerformanceSummary', 
                                        PartID: record.EvaluationID,
                                        ReadAt: null, 
                                        AssignedTo: '<?php echo $profile_idnum.'|'.$profile_dbname; ?>' }).length > 0"
                                    data-field="PerformanceSummary"
                                    data-partid="{{ record.EvaluationID }}">View Feedback</a>
                                <br>
                                <span  ng-show="record.for_approval_level == 1 || (record.hr_comments | filter:{ 
                                        Section: 'PerformanceSummary', 
                                        PartID: record.EvaluationID,
                                        ReadAt: null, 
                                        AssignedTo: '<?php echo $profile_idnum.'|'.$profile_dbname; ?>' }).length > 0" style=" font-weight:normal; font-size:11px;">Note: When creating the performance summary for the ratee, <b>DO NOT include details about salary increases or promotions, as the ratee will have access to this information.</b></span> 
                            </h4>
                            <h4><span ng-bind="record.Rater1FullName"></span></h4>
                            <p class='textareaGroup'>
                                <textarea spellcheck='true' style="width:710px; min-height:100px;"  class="perfsummary checker" rows="3" 
                                    ng-model="record.PerformanceSummary" 
                                    ng-class="record.for_approval_level == 1 || (record.hr_comments | filter:{ 
                                        Section: 'PerformanceSummary', 
                                        PartID: record.EvaluationID,
                                        ReadAt: null, 
                                        AssignedTo: '<?php echo $profile_idnum.'|'.$profile_dbname; ?>' }).length > 0 ? 'spellcheck' : '' " 
                                    ng-show="record.for_approval_level == 1 || (record.hr_comments | filter:{ 
                                        Section: 'PerformanceSummary', 
                                        PartID: record.EvaluationID,
                                        ReadAt: null, 
                                        AssignedTo: '<?php echo $profile_idnum.'|'.$profile_dbname; ?>' }).length > 0" 
                                    ng-disabled="(is_approved || record.for_approval_level > 1) && (record.hr_comments | filter:{ 
                                        Section: 'PerformanceSummary', 
                                        PartID: record.EvaluationID,
                                        ReadAt: null, 
                                        AssignedTo: '<?php echo $profile_idnum.'|'.$profile_dbname; ?>' }).length == 0"
                                    minlength='25' required>
                                </textarea><br>
                                <small class='warningMsg' style="display:none;">
                                    * This is a required field. Must be at least 25 characters long.
                                </small>
                                <span ng-show="(record.for_approval_level > 1 || is_approved) && (record.hr_comments | filter:{ 
                                        Section: 'PerformanceSummary', 
                                        PartID: record.EvaluationID,
                                        ReadAt: null, 
                                        AssignedTo: '<?php echo $profile_idnum.'|'.$profile_dbname; ?>' }).length == 0" ng-bind="record.PerformanceSummary"></span>
                            </p>
                            <!-- <hr> -->
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
                            <div ng-show="!is_approved && record.for_approval_level > 1">
                                <!-- <hr> -->
                                 <h4 ng-show="!is_approved">EVALUATION COMMENT</h4>
                                <textarea ng-class="record.for_approval_level == 2 && !is_approved ? 'spellcheck' : '' " style="width:710px; min-height:100px;" ng-model="record.Rater2Comment" class="checker" ng-show="record.for_approval_level == 2 && !is_approved"  ng-disabled="is_approved" ></textarea>
                                <textarea ng-class="record.for_approval_level == 3 && !is_approved ? 'spellcheck' : '' " style="width:710px; min-height:100px;" ng-model="record.Rater3Comment" class="checker" ng-show="record.for_approval_level == 3 && !is_approved"  ng-disabled="is_approved" ></textarea>
                                <textarea ng-class="record.for_approval_level == 4 && !is_approved ? 'spellcheck' : '' " style="width:710px; min-height:100px;" ng-model="record.Rater4Comment" class="checker" ng-show="record.for_approval_level == 4 && !is_approved"  ng-disabled="is_approved" ></textarea>
                            </div>
                        </div>
                        <br>
                        
                        <?php if(isset($_GET['page']))
                                if($_GET['page'] !== 'result') { ?>

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
                                <textarea spellcheck="true" 
                                    id="EmployeeAccept" 
                                    class="checker" 
                                    style="width:98.4%;min-height:100px;" 
                                    ng-show="is_approved" 
                                    ng-hide="record.EmpComment != null"
                                    ng-class="record.EmpComment == null ? 'spellcheck' : '' "></textarea>
                                <div ng-show="record.EmpComment != null && is_approved">
                                    <p ng-bind="record.EmpComment"></p>
                                </div>
                            </div>
                            <br>
                            <button type="button" class="subapp smlbtn" id="submapp" style="float:right;margin-right:10px;"  ng-show="is_approved && record.EmpComment == null" ng-click="accept()">Accept Evaluation</button>
                            <button type="button" class="smlbtn" style="float:right;background-color:#3EC2FB;margin-right:10px;" ng-show="record.status == 'Completed' && record.group.EvaluationType == 'Regularization'" id='pmr_sign_doc'>Sign PMR Documents</button>
                        <?php } ?>

                    </div>

                        
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    // angular retrieve record from https://dev.megaworldcorp.com/test
    $('#evaluation-form-wrapper').hide();
    var app = angular.module('myApp', []);
    app.factory('spellCheckerService', ['$q', function($q) {
        let spellCheckerModule = null; 
        const SPELLCHECK_MODULE_PATH = '<?php echo JS; ?>/SpellChecker/spellcheck.js';

        async function loadSpellCheckerModule() {
            if (spellCheckerModule) {
                return spellCheckerModule; 
            }
            try {
                const module = await import(SPELLCHECK_MODULE_PATH);
                spellCheckerModule = module;
                console.log('SpellChecker module loaded successfully:', module);
                return module;
            } catch (error) {
                console.error('Failed to load SpellChecker module:', error);
                return $q.reject(error);
            }
        }

        return {
            initializeSpellingChecker: async function() {
                try {
                    const module = await loadSpellCheckerModule();
                    if (module && typeof module.initializeSpellingChecker === 'function') {
                        module.initializeSpellingChecker();
                    } else {
                        console.warn('initializeSpellingChecker function not found in the module.');
                    }
                } catch (error) {
                    console.error('Error calling initializeSpellingChecker:', error);
                }
            },

            
            getSpellCheckerClass: async function() {
                try {
                    const module = await loadSpellCheckerModule();
                    if (module && module.SpellChecker) {
                        return module.SpellChecker;
                    } else {
                        console.warn('SpellChecker class not found in the module.');
                        return null;
                    }
                } catch (error) {
                    console.error('Error getting SpellChecker class:', error);
                    return null;
                }
            }
        };
    }]);

    var allComments = [];
    app.controller('myCtrl', function($scope, $http,  $sce, spellCheckerService) {
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

                    if($scope.record.goals_next.length === 0){
                        for (let index = 0; index < 3; index++) {
                            $scope.addNextGoal();
                        }
                    }

                    $scope.updateRecord();
            
                    $scope.record.group.PeriodFrom = $scope.record.HireDate;
                    let date = new Date($scope.record.HireDate);
                    $scope.record.group.PeriodTo = date.setMonth(date.getMonth() + 6);
                    $scope.record.group.AppraisalDate = date.setDate(date.getDate() + 1);
                    console.log("Successfully retrieved record");

                    // // redirect, if evaluation is complete
                    // if($scope.record.status == "Completed"){
                    //     window.location.href = "pms?page=paf&ratee="+$scope.record.EvaluationID;
                    // }

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

                    if($scope.record.status == 'Completed')
                        $scope.is_approved = true;
                }

                allComments = $scope.record.hr_comments;
                $scope.loading = false;
                $('#evaluation-form-wrapper').show();
                spellCheckerService.initializeSpellingChecker();
            },
            function errorCallback(response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                    console.error("Error while retrieving record", response);
                    window.location.reload();

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

            $scope.totalCompetency= parseFloat(($scope.record.competencies.reduce(function(total, competency) {

                if(parseInt(competency.RequiredProficiency) - parseInt(competency.ActualProficiency) > 0)
                    competency.Gaps = parseInt(competency.RequiredProficiency) - parseInt(competency.ActualProficiency);
                else
                    competency.Gaps = 0;
                
                return total + (parseFloat(competency.ActualProficiency) || 0);
            }, 0) / $scope.record.competencies.length).toFixed(2));

            if(isNaN($scope.totalCompetency)){
                $scope.totalCompetency = 0;
            }

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

            $scope.record.evaluation_score =  (parseFloat($scope.totalCompetency.toFixed(2)) * 30/100) + (parseFloat($scope.totalGoal).toFixed(2) * 70/100);

            $scope.partHRScore = parseFloat((($scope.record.FiveSScore * 0.05) + ($scope.record.AttendancePunctualityScore * 0.1) + parseFloat($scope.record.ConductMemoScore * 0.15)).toFixed(2));

            $scope.record.total_computed_score = parseFloat($scope.record.evaluation_score);

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
            $('#evaluation-form-wrapper').hide();
            if($scope.record.recommended_salary_increase == '' || $scope.record.recommended_salary_increase == null){
                $scope.record.recommended_salary_increase = 0;
            }
            $http({
                method: 'POST',
                url: apiUrl + 'evaluation/save', 
                data:  $scope.record
            }).then(function successCallback(response) {
                    $scope.record = response.data;
                    console.log("Successfully saved record");
                    // refresh page
                    window.location.reload();
                },
                function errorCallback(response) {
                        // called asynchronously if an error occurs
                        // or server returns response with an error status.
                        $scope.loading = false;
                        $('#evaluation-form-wrapper').show();
                        
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
            if($scope.myForm.$invalid){
                $('input.ng-invalid').first().focus();
                $('textarea.ng-invalid').first().closest('.textareaGroup').find('.livespell_textarea').focus();
                $('select.ng-invalid').first().focus();
                alert('Please check all required inputs!');

                return false;
            }
            else if($scope.checkSpelling()){
                $('.editor-wrapper.invalid-spellcheck').find('textarea.spellcheck').first().focus();
                alert('Spelling errors found. Please review and correct the highlighted words before submitting the form. \n\nNote: To see suggestions, click on misspelled word.');

                return false;
            }
            return true
        };

        $scope.checkSpelling = function(){
            if ($('.editor-wrapper.invalid-spellcheck').length > 0){
                return true;
            }

            return false;
        }

        $scope.markAsDone = function(CommentID){
            $scope.record.markAsDone = true;
            $scope.record.CommentIDtoComplete = CommentID;

            if($scope.validate()){
                $scope.save();
            }
        }

        $scope.markALLAsDone = function(Section, PartID){
            $scope.record.markALLAsDone = true;
            $scope.record.SectionToComplete = Section;
            $scope.record.PartToComplete = PartID;

            if($scope.validate()){
                $scope.save();
            }
        }

        $(document).on("click", ".add-comment-btn", function (event) {
            event.stopPropagation();

            let fieldId = $(this).data("field");
            let partID = $(this).data("partid");
            let $button = $(this);

            $(".floating-feedback").remove();

            if (allComments) {
                let filteredComments = allComments
                    .filter(c =>
                        c.Section == fieldId &&
                        c.PartID == partID &&
                        c.ReadAt == null &&
                        c.AssignedTo == '<?php echo $profile_idnum . '|' . $profile_dbname; ?>'
                    )
                    .map(c => {
                        c.Username = c.CreatedBy.split(' - ')[1];
                        return c;
                    });

                existingCommentsHTML = filteredComments.map(c =>
                    `<li class="list-group-item feedback-item">
                        <div class="feedback-header">
                            <div class="avatar">${c.Username.charAt(0).toUpperCase()}</div>
                            <div>
                                <span class="author">${c.Username}</span>
                                <span class="date">${ new Date(c.CreatedAt).toLocaleString('en-US', {
                                    dateStyle: 'medium',
                                    timeStyle: 'short',
                                    hour12: true
                                })}</span>
                            </div>
                        </div>
                        <div class="remarks">${c.Remarks}</div>
                        <div class='action-comment'><a href='#' class='done' data-id='${c.CommentID}'>Mark as Done</a></div>
                    </li>`
                ).join('');
            }

            let commentBox = $(`
                <div class="floating-feedback">
                    <div class="feedback-header-title">HR Feedback</div>
                    <div class="feedback-content">
                        <div class="feedback-list">
                            ${existingCommentsHTML}
                        </div>
                    </div>
                    <button class="resolve-btn">Mark All as Done</button>
                </div>
            `);

            // Function to update box position
            function updatePosition() {
                let rect = $button[0].getBoundingClientRect();
                let newTop = rect.top + window.scrollY;
                let newLeft = rect.right + window.scrollX + 10;

                // If the comment box goes above 350px from the top → remove it
                if (newTop < 350) {
                    commentBox.remove();
                    $(document).off("click.closeCommentBox");
                    $(window).off("scroll.updateCommentBox"); // or your scroll parent if different
                    return;
                }

                // Otherwise, update position normally
                commentBox.css({
                    top: newTop,
                    left: newLeft
                });
            }


            // Initial position
            $("body").append(commentBox);
            updatePosition();

            // Track scrolling on parent containers AND window
            // Add scroll tracking
            let $scrollParents = $button.parents().filter(function () {
                return /(auto|scroll)/.test($(this).css("overflow") + $(this).css("overflow-y") + $(this).css("overflow-x"));
            });
            $scrollParents = $scrollParents.add($(window));

            $scrollParents.on("scroll.updateCommentBox", updatePosition);

            // Close if clicked outside
            $(document).on("click.closeCommentBox", function (e) {
                if (!commentBox.is(e.target) && commentBox.has(e.target).length === 0 && !$(e.target).is(".add-comment-btn")) {
                    commentBox.remove();
                    $(document).off("click.closeCommentBox");
                    $scrollParents.off("scroll.updateCommentBox");
                }
            });

            $(document).on("click.action-comment", ".done", function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $scope.markAsDone(id);
                $(".floating-feedback").remove();
            });

            $(document).on("click", ".resolve-btn", function (e) {
                e.preventDefault();
                $scope.markALLAsDone(fieldId, partID);
            });
        });

    });

    $(document).on('input focusin change', '.editor-wrapper', function() {
        var content = $(this).find('textarea').val(); 
        var msg=$(this).closest('.textareaGroup').find('small.warningMsg');

        if(msg.length != 0){
            if (!content || content.length < 25) {
                $(this).css('background-color', 'hsl(0deg 25% 50%)');

                var $wrapper = $(this).closest('.work-result-wrapper');
                var rating = $wrapper.find('input.pccrate').val();
                if(rating==3){
                    $(this).css('background-color', '#fff');
                    msg.hide();
                }
                else{
                    msg.show();
                }
            } 
            else {
                $(this).css('background-color', '#fff');
                msg.hide();
            }
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

    $(document).on('input change focus', 'textarea.spellcheck', function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });

    
    $('#pmr_sign_doc').on('click', function(){
        var userConfirmed = confirm('You will be redirected to another page for signing document. Would you like to continue?');

        if(userConfirmed){
            window.open("<?php echo WEB; ?>/pmr_signing?ratee=<?php echo $_GET['ratee']; ?>");
        }
    });
    </script>
    <?php include('session.php'); ?>