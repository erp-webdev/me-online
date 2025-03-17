<div id="APEfloatdiv" class="floatdiv invisible">                                        
    <div id="apeview" class="fview">
        <div class="closebutton cursorpoint">
            <a onclick='$("#APEfloatdiv").addClass("invisible")'><i class="fa fa-times-circle fa-3x redtext"></i></a>
        </div>
        <div id="ape_title" class="robotobold cattext dbluetext">Annual Physical Examination Result</div>

        <div id="loadingIndicator" style="text-align: center; margin-top: 80px;">
            <i class="fa fa-spinner fa-spin fa-2x"></i> Please wait...
        </div>

        <div id="availableIndicator" style="text-align: center; margin-top: 80px; font-size: 0.9rem;">
            <i>Annual Physical Examination result is not yet available.</i>
        </div>

        <div id="ape_data" class="floatdata margintop15" style="display: none;"> 
            <div class="">            
                <div id="apeViewer" width="100%" height="700px">
                    <iframe id="filePreview" width="100%" height="250px" style="border: none; margin-bottom:10px;"></iframe>

                    <div style="margin-top: 10px; font-size: 0.7rem;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 5px;">
                            <span style="width: 30%; font-weight: bold;">Employee</span>
                            <span style="width: 70%; word-wrap: break-word;">
                                <?php echo $profile_full .' (' . $profile_idnum . ')' ?>
                            </span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 5px;">
                            <span style="width: 30%; font-weight: bold;">Schedule Date</span>
                            <span style="width: 70%; word-wrap: break-word;" id="MedicalDate"></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <span style="width: 30%; font-weight: bold;">Remarks</span>
                            <span style="width: 70%; word-wrap: break-word; max-height: 150px; overflow-y: auto; padding-right: 5px;" id="MedicalRemarks"></span>
                        </div>
                    </div>
                </div>
                <div style="display: flex; justify-content: center; align-items: center; margin-top: 15px;">
                    <button id='downloadAPE' class="bigbtn">Download</button>
                </div>
            </div>
        </div>
    </div>  
</div>

<script>
    $(document).ready(function() {
        $('#loadingIndicator').show();
        $('#availableIndicator').hide();
        $('#ape_data').hide();

        $('#btnAPE').click(function() {
            $('#APEfloatdiv').removeClass('invisible');
            $("#apeview").removeAttr("style");
            $.ajax({
                url: '<?php echo MEWEB; ?>/peoplesedge/api/employee/medical',
                type: 'GET',
                data: {
                    Action: 'View',
                    EmpID: '<?php echo $profile_idnum; ?>',
                    EmpDB: '<?php echo $profile_dbname; ?>',
                    CompanyID: '<?php echo $profile_comp; ?>'
                },
                dataType: 'json',
                success: function(data) {
                    if(data){
                        $('#filePreview').attr('src', data.url + '#toolbar=1&zoom=60');
                        $('#MedicalDate').text(data.MedicalDate);
                        $('#MedicalRemarks').text(data.MedicalRemarks);

                        $('#loadingIndicator').hide();
                        $('#availableIndicator').hide();
                        $('#ape_data').fadeIn();
                    }
                    else{
                        $('#loadingIndicator').hide();
                        $('#availableIndicator').show();
                        $('#ape_data').hide();
                    }
                },
                error: function(xhr, status, error) {
                    $('#loadingIndicator').hide();
                    $('#availableIndicator').show();
                    $('#ape_data').hide();
                }
            });
        });

        $('#downloadAPE').click(function() {
            window.location.href = '<?php echo MEWEB; ?>/peoplesedge/api/employee-file/medical?' +
            $.param({
                Action: 'Download',
                EmpID: '<?php echo $profile_idnum; ?>',
                EmpDB: '<?php echo $profile_dbname; ?>',
                CompanyID: '<?php echo $profile_comp; ?>'
            });
        });
    });
</script>
