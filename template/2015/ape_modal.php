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
            <div id='apeViewer'></div>
        </div>
    </div>  
</div>

<script>
    $(document).ready(function() {
        $('#btnAPE').click(function() {
            $('#loadingIndicator').show();
            $('#availableIndicator').hide();
            $('#ape_data').hide();

            $('#APEfloatdiv').removeClass('invisible');
            $("#apeview").removeAttr("style");

            $.ajax({
                url: '<?php echo WEB; ?>/ape',
                type: 'GET',
                success: function(data) {
                    if(data){
                        $("#apeViewer").html(data);
                        $('#loadingIndicator').hide();
                        $('#availableIndicator').hide();
                        $('#ape_data').fadeIn();

                        $('#downloadAPE').click(function() {
                            const downloadUrl = $(this).data('url');
                            const accessToken = '<?php echo $_SESSION['peoplesedge_access_token']; ?>';

                            fetch(downloadUrl, {
                                headers: { 
                                    'Authorization': `Bearer ${accessToken}`
                                }
                            })
                            .then(response => response.blob())
                            .then(blob => {
                                const filename = downloadUrl.split('/').pop();
                                const blobUrl = URL.createObjectURL(blob);

                                Object.assign(document.createElement('a'), {
                                    href: blobUrl,
                                    download: filename
                                }).click();

                                URL.revokeObjectURL(blobUrl);
                            });
                        });
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
    });
</script>
