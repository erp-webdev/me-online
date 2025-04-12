<div id="APEfloatdiv" class="floatdiv invisible">                                        
    <div id="apeview" class="fview">
        <div class="closebutton cursorpoint">
            <a onclick='$("#APEfloatdiv").addClass("invisible")'><i class="fa fa-times-circle fa-3x redtext"></i></a>
        </div>
        <div id="ape_title" class="robotobold cattext dbluetext">Annual Physical Examination Result</div>

        <div id="loadingIndicator" style="text-align: center; margin-top: 80px;">
            <i class="fa fa-spinner fa-spin fa-2x"></i> Please wait...
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
            $('#ape_data').hide();

            $('#APEfloatdiv').removeClass('invisible');
            $("#apeview").removeAttr("style");

            $.ajax({
                url: '<?php echo WEB; ?>/ape',
                type: 'GET',
                success: function(data) {
                    const accessToken = '<?php echo $_SESSION['peoplesedge_access_token']; ?>';
                        
                    if(accessToken){
                        $("#apeViewer").html(data);
                        $('#loadingIndicator').hide();
                        $('#ape_data').fadeIn();

                        $('#downloadAPE').click(function() {
                            const downloadUrl = $(this).data('url');

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
                        $('#APEfloatdiv').addClass('invisible');
                        alert('Something went wrong! Error: <?php echo $_SESSION['peoplesedge_login_error']; ?>')
                    }
                },
                error: function(xhr, status, error) {
                    $('#loadingIndicator').hide();
                    $('#ape_data').hide();
                }
            });
        });
    });
</script>
