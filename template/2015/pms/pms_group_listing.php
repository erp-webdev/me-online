<div class="rightsplashtext lefttalign">

    <div id="paf" class="mainbody lefttalign whitetext">
        <h2 class="mediumtext lorangetext"> Performance Management </h2>
        <table class="tdata " id="pafgrouptable" cellspacing="0" width="100%">
        </table>
    </div>

</div>
<script>
    let apiUrl = 'https://dev.megaworldcorp.com:8081/peoplesedge/api/pmsv1/my-groups?EmpID=<?php echo $profile_idnum; ?>&EmpDB=<?php echo $profile_dbname; ?>';
    axios.get(apiUrl)
        .then(response => {
            const groups = response.data;
            let tableHtml = '';
            tableHtml += `<tr>
                                <th class="thr" style="text-align: center;">View</th>
                                <th class="thr" style="text-align: left">Title</th>
                                <th style="text-align: center">Appraisal Date</th>
                                <th style="text-align: center">Status</th>
                            </tr>`;
            groups.forEach(group => {
                // Parse the AppraisalDate string into a Date object
                const appraisalDate = new Date(group.AppraisalDate);

                // Format the Date object as a string in the format "YYYY-MM-DD"
                const formattedAppraisalDate = appraisalDate.toISOString().slice(0, 10);

                tableHtml += `
                    <tr>
                        <td style="padding: 10px"><a href="pms?page=eval&GroupID=${group.id}" class="smlbtn" style="background-color:#3EC2FB; text-align: center;">View</a></td>
                        <td class="">${group.Title}</td>
                        <td class="" style="text-align: center">${formattedAppraisalDate}</td>
                        <td class="" style="text-align: center">${group.Status}</td>
                    </tr>
                `;
            });
            document.getElementById('pafgrouptable').innerHTML = tableHtml;
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
</script>