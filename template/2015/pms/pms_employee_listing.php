<div class="rightsplashtext lefttalign">
    <div id="paf" class="mainbody lefttalign whitetext">
        <h2 class="mediumtext lorangetext">
            <a href="<?php echo WEB; ?>/pms"><i class="mediumtext fa fa-arrow-left"
                    style="color:#fff;opacity:.8;"></i></a> <span class="grouptitle"></span>
        </h2>
        <div class="myscore">
            <hr>
            <h2 class="mediumtext lorangetext">My Performance</h2>
            <table class="tdata " id="pafmyevaluation" cellspacing="0" width="100%"></table>
        </div>
        <div class="myapproval">
            <h2 class="mediumtext lorangetext">For Review / Approval</h2>
            <div id="pafaccordion" class="accordion ui-accordion ui-widget ui-helper-reset"></div>
            <i>*Incomplete - Evaluation is under approval of pre-requisite approver/Evaluator</i>
        </div>
    </div>
</div>
<script>
    let apiUrl = '<?php echo MEWEB; ?>/peoplesedge/api/pmsv1/my-evaluations?EmpID=<?php echo $profile_idnum; ?>&EmpDB=<?php echo $profile_dbname; ?>&GroupID=<?php echo $_GET['GroupID']; ?>';
    axios.get(apiUrl)
        .then(response => {
            const group = response.data.group;
            const evaluations = response.data.evaluations;
            const departments = response.data.departments;
            const myevaluation = response.data.myevaluation;

            $('.grouptitle').html(group.Title);
            $('.myscore').hide();

            if (evaluations.length == null || evaluations.length == 0) {
                $('.myapproval').hide();
            }

            if (myevaluation != null) {
                $('.myscore').show();

                let form = '&form=mega';
                if(group.EvaluationForm == 'evaluation-form-2024-global')
                    form = '&form=global';
                else if(group.EvaluationForm == 'regularization-form-2024-global')
                    form = '&form=regularization';
                else if(group.EvaluationForm == 'regularization-form-2024-mega')
                    form = '&form=regularizationMega';

                let btnresult = `<a href="<?php echo WEB; ?>/pafview?groupid=${myevaluation.GroupID}&appid=${myevaluation.EvaluationID}&pafad=ratee" class="smlbtn" id="sendapp" style="float:right;margin-right:10px;background-color:#3EC2FB;display:${myevaluation.Status == 'Completed' ? '': 'none'}">Result</a>`;

                if(group.EvaluationForm == 'evaluation-form-2024-global' || group.CompanyID == 'GLOBAL01' ){
                    btnresult = `<a href="<?php echo WEB; ?>/pafglobal_view?groupid=${myevaluation.GroupID}&appid=${myevaluation.EvaluationID}&pafad=ratee" class="smlbtn" id="sendapp" style="float:right;margin-right:10px;background-color:#3EC2FB;display:${myevaluation.Status == 'Completed' ? '': 'none'}">Result</a>`;
                }
                
                
                if(group.AppraisalDate>'2024-01-01'){
                    if(group.EvaluationForm == 'evaluation-form-2024-global'){
                        btnresult = `<a href="<?php echo WEB; ?>/pms?page=result&ratee=${myevaluation.EvaluationID}${form}" class="smlbtn" id="sendapp" style="float:right;margin-right:10px;background-color:#3EC2FB;display:${myevaluation.Status == 'Completed' ? '': 'none'}">Result</a>`;
                    }else{
                        btnresult = `<a href="<?php echo WEB; ?>/pms?page=result&ratee=${myevaluation.EvaluationID}${form}" class="smlbtn" id="sendapp" style="float:right;margin-right:10px;background-color:#3EC2FB;display:${myevaluation.Status == 'Completed' ? '': 'none'}">Result</a>`;
                    }
                }

                let tableHtml = '';
                tableHtml += `<tr>
                                        <th class="thr" style="text-align: left">Employee/Ratee</th>
                                        <th class="thr" style="text-align: left">Evaluator</th>
                                        <th class="thr" style="text-align: left">Approver 2</th>
                                        <th class="thr" style="text-align: left">Approver 3</th>
                                        <th class="thr" style="text-align: left">Approver 4</th>
                                        <th class="thr" style="text-align: center">Score</th>
                                        <th class="thr" style="text-align: center">Status</th>
                                        <th style="text-align: center"></th>
                                    </tr>`;

                tableHtml += `<tr>
                                        <td class="thr" style="">${myevaluation.FullName}</td>
                                        <td class="thr" style="text-align: left; ${myevaluation.Rater1Status == 1 ? 'color:#c6efce;' : ''}"><span style="${myevaluation.Rater1FullName == null ? 'display:none' : ''}">${myevaluation.Rater1Status == 1 ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'} ${myevaluation.Rater1FullName}</span></td>
                                        <td class="thr" style="text-align: left; ${myevaluation.Rater2Status == 1 ? 'color:#c6efce;' : ''}"><span style="${myevaluation.Rater2FullName == null ? 'display:none' : ''}">${myevaluation.Rater2Status == 1 ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'} ${myevaluation.Rater2FullName}</span></td>
                                        <td class="thr" style="text-align: left; ${myevaluation.Rater3Status == 1 ? 'color:#c6efce;' : ''}"><span style="${myevaluation.Rater3FullName == null ? 'display:none' : ''}">${myevaluation.Rater3Status == 1 ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'} ${myevaluation.Rater3FullName}</span></td>
                                        <td class="thr" style="text-align: left; ${myevaluation.Rater4Status == 1 ? 'color:#c6efce;' : ''}"><span style="${myevaluation.Rater4FullName == null ? 'display:none' : ''}">${myevaluation.Rater4Status == 1 ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'} ${myevaluation.Rater4FullName}</span></td>
                                        <td class="thr" style="text-align: center">${myevaluation.Status == 'Completed' ? Number(Math.round(myevaluation.total_computed_score + 'e2') + 'e-2') : ''}</td>
                                        <td class="thr" style="text-align: center">${myevaluation.Status}</td>
                                        <td style="text-align: center">${btnresult}</td>
                                    </tr>`;

                document.getElementById('pafmyevaluation').innerHTML = tableHtml;

            }

            if (evaluations != null) {

                for (let j = 0; j < departments.length; j++) {

                    let additionalColumn = ``;
                    if(group.EvaluationType == 'Regularization'){
                        additionalColumn = `<th class="thr" style="text-align: left">End Of Contract</th>`;
                    }
                    let empHtml = '';
                    let tableHtml = `<table class="tdata" cellspacing="0" width="100%" >
                                                <tr>
                                                    <th class="thr" style=""></th>
                                                    <th class="thr" style="text-align: left">Employee/Ratee</th>
                                                    <th class="thr" style="text-align: left; display:none">Rank / Position</th>
                                                    `+ additionalColumn +`
                                                    <th class="thr" style="text-align: left">Score</th>
                                                    <th class="thr" style="text-align: left">Percentage</th>
                                                    <th class="thr" style="text-align: center">Status</th>
                                                    <th style="text-align: center"></th>
                                                </tr>`;

                    var empPerDept = 0;
                    for (let i = 0; i < evaluations.length; i++) {
                        if (evaluations[i].Department == departments[j]) {
                            let raterStatus = false;
                            let btn = '<i>Incomplete</i>';
                            let form = '&form=mega';
                            if(group.EvaluationForm == 'evaluation-form-2024-global')
                                form = '&form=global';
                            else if(group.EvaluationForm == 'regularization-form-2024-global')
                                form = '&form=regularization';
                            else if(group.EvaluationForm == 'regularization-form-2024-mega')
                                form = '&form=regularizationMega';

                            if (evaluations[i].Status == 'Completed') {

                                btn = `<a href="pms?page=paf&ratee=${evaluations[i].EvaluationID}${form}" class="smlbtn" style="background-color:blue; text-align: center; padding: 3px">Result</a>`;

                                if(group.AppraisalDate <= '2023-12-31'){
                                    let l = 1;

                                    if(evaluations[i].Rater1EmpID == '<?php echo $profile_idnum; ?>' && 
                                        evaluations[i].Rater1DB == '<?php echo $profile_dbname; ?>'){
                                            l = 1;
                                    }else if(evaluations[i].Rater2EmpID == '<?php echo $profile_idnum; ?>' && 
                                        evaluations[i].Rater2DB == '<?php echo $profile_dbname; ?>'){
                                            l = 2;
                                    }else if(evaluations[i].Rater3EmpID == '<?php echo $profile_idnum; ?>' && 
                                        evaluations[i].Rater3DB == '<?php echo $profile_dbname; ?>'){
                                            l = 3;
                                    }else if(evaluations[i].Rater4EmpID == '<?php echo $profile_idnum; ?>' && 
                                        evaluations[i].Rater4DB == '<?php echo $profile_dbname; ?>'){
                                            l = 4;
                                    }

                                    if(group.EvaluationForm == 'evaluation-form-2024-mega'){
                                        btn = ` <a href="<?php echo WEB; ?>/pafview?groupid=${evaluations[i].GroupID}&pafad=rater&sub=${l}&appid=${evaluations[i].EvaluationID}&rid=${evaluations[i].EmpID}" class="smlbtn" style="float:right;margin-right:10px;background-color:#3EC2FB;">Result</a>`;
                                    }else{
                                        btn = ` <a href="<?php echo WEB; ?>/pafglobal_view?groupid=${evaluations[i].GroupID}&pafad=rater&sub=${l}&appid=${evaluations[i].EvaluationID}&rid=${evaluations[i].EmpID}" class="smlbtn" style="float:right;margin-right:10px;background-color:#3EC2FB;">Result</a>`;
                                    }
                                }


                            } else {

                                if (evaluations[i].Rater1EmpID == '<?php echo $profile_idnum; ?>' && evaluations[i].Rater1DB == '<?php echo $profile_dbname; ?>') {
                                    if (evaluations[i].Rater1Status != 1 && evaluations[i].for_approval_level == 1) {
                                        btn = `<a href="pms?page=paf&ratee=${evaluations[i].EvaluationID}${form}" class="smlbtn" style="background-color:green; text-align: center;">Evaluate</a>`;
                                    } else if (evaluations[i].Rater1Status == 1) {
                                        btn = `<a href="pms?page=paf&ratee=${evaluations[i].EvaluationID}${form}" class="smlbtn" style="background-color:blue; text-align: center; padding: 3px">Result</a>`;
                                    }
                                } else if (evaluations[i].Rater2EmpID == '<?php echo $profile_idnum; ?>' && evaluations[i].Rater2DB == '<?php echo $profile_dbname; ?>') {
                                    if (evaluations[i].Rater2Status != 1 && evaluations[i].for_approval_level == 2) {
                                        btn = `<a href="pms?page=paf&ratee=${evaluations[i].EvaluationID}${form}" class="smlbtn" style="background-color:green; text-align: center;">For ${evaluations[i].final_approver_level == 2 ? ' Final ' : ''} Approval</a>`;
                                    } else if (evaluations[i].Rater2Status == 1) {
                                        btn = `<a href="pms?page=paf&ratee=${evaluations[i].EvaluationID}${form}" class="smlbtn" style="background-color:blue; text-align: center; padding: 3px">Result</a>`;
                                    }
                                } else if (evaluations[i].Rater3EmpID == '<?php echo $profile_idnum; ?>' && evaluations[i].Rater3DB == '<?php echo $profile_dbname; ?>') {
                                    if (evaluations[i].Rater3Status != 1 && evaluations[i].for_approval_level == 3) {
                                        btn = `<a href="pms?page=paf&ratee=${evaluations[i].EvaluationID}${form}" class="smlbtn" style="background-color:green; text-align: center;">For ${evaluations[i].final_approver_level == 3 ? ' Final ' : ''} Approval</a>`;
                                    } else if (evaluations[i].Rater3Status == 1) {
                                        btn = `<a href="pms?page=paf&ratee=${evaluations[i].EvaluationID}${form}" class="smlbtn" style="background-color:blue; text-align: center; padding: 3px">Result</a>`;
                                    }
                                } else if (evaluations[i].Rater4EmpID == '<?php echo $profile_idnum; ?>' && evaluations[i].Rater4DB == '<?php echo $profile_dbname; ?>') {
                                    if (evaluations[i].Rater4Status != 1 && evaluations[i].for_approval_level == 4) {
                                        btn = `<a href="pms?page=paf&ratee=${evaluations[i].EvaluationID}${form}" class="smlbtn" style="background-color:green; text-align: center;">For Final Approval</a>`;
                                    } else if (evaluations[i].Rater4Status == 1) {
                                        btn = `<a href="pms?page=paf&ratee=${evaluations[i].EvaluationID}${form}" class="smlbtn" style="background-color:blue; text-align: center; padding: 3px">Result</a>`;
                                    }
                                }
                            }

                            if(group.EvaluationType == 'Regularization'){
                                let formattedDate = "";
                                let current = new Date();
                                let evaldate = new Date(evaluations[i].EvaluationDate);
                                let date = new Date(evaluations[i].EndOfContractDate);
                                let options = { year: 'numeric', month: 'long', day:'numeric' };
                                formattedDate = date.toLocaleDateString('en-US', options);

                                if(resetTime(evaldate) <= resetTime(current) && (evaluations[i].EvaluationDate)){
                                    empHtml += `<tr>
                                            <td class="thr" style="text-align: center">${btn}</td>
                                            <td class="thr">${evaluations[i].FullName}</td>
                                            <td class="thr" style="display:none">${evaluations[i].Rank} /<br> ${evaluations[i].Position}</td>
                                            <td class="thr" style="text-align: center">${formattedDate}</td>
                                            <td class="thr" style="text-align: center">${Number(Math.round(evaluations[i].total_computed_score + 'e2') + 'e-2')}</td>
                                            <td class="thr" style="text-align: center">${Number(Math.round((evaluations[i].total_computed_score / 5 * 100) + 'e2') + 'e-2')}</td>
                                            <td class="thr" style="text-align: center">${evaluations[i].Status}</td>
                                        </tr>`;

                                    empPerDept++;
                                }
                            }
                            else{
                                empHtml += `<tr>
                                            <td class="thr" style="text-align: center">${btn}</td>
                                            <td class="thr">${evaluations[i].FullName}</td>
                                            <td class="thr" style="display:none">${evaluations[i].Rank} /<br> ${evaluations[i].Position}</td>
                                            <td class="thr" style="text-align: center">${Number(Math.round(evaluations[i].total_computed_score + 'e2') + 'e-2')}</td>
                                            <td class="thr" style="text-align: center">${Number(Math.round((evaluations[i].total_computed_score / 5 * 100) + 'e2') + 'e-2')}</td>
                                            <td class="thr" style="text-align: center">${evaluations[i].Status}</td>
                                        </tr>`;
                                empPerDept++;
                            }
                            
                        }
                    }

                    tableHtml += empHtml + `</table>`;

                    let d = `display: block;`;
                    if(empPerDept == 0){
                        d = `display: none;`;
                    }

                    let x = `<h3 style="`+d+`background-color:#fff;" class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-accordion-51-header-0" aria-controls="ui-accordion-51-panel-0" aria-selected="false" tabindex="-1">
                                    <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span>${departments[j]}</h3>

                                <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" id="ui-accordion-51-panel-0" aria-labelledby="ui-accordion-51-header-0" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">${tableHtml}</div>`;

                    // tableHtml += `<tr><th class="thr lorangetext" colspan="7" style="text-align: left">${department.name}</th></tr>`;
                    $('#pafaccordion').append(x);
                };

                // document.getElementById('pafaccordion').innerHTML = deptHtml;
                $(function () {
                    $(".accordion").accordion({
                        active: false,
                        collapsible: true,
                    });
                });
            }

        })
        .catch(error => {
            console.error('Error fetching data:', error);
            document.getElementById('pafaccordion').innerHTML = 'an error occured';

        });

    function resetTime(date) {
        return new Date(date.getFullYear(), date.getMonth(), date.getDate());
    }
</script>