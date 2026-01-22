<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PMR Document Signing</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <style>
        ::-webkit-file-upload-button {
            border: none;
            border-radius: 4px;
            padding: -10px;
            margin-left: -0.6em;
            margin-top: -1em;
            border-right: 2px solid #ccc; 
            background-color: white;
            height: 50px;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            initSignaturePad();
            $(document).on('change', '.signature-method-wrapper input[name="signatureMethod"]', function() {
                const wrapper = $(this).closest('.signature-method-wrapper');

                if ($(this).val() === 'upload') {
                    wrapper.find('#uploadSection').removeClass('d-none');
                    wrapper.find('#drawSection').addClass('d-none');
                } else {
                    wrapper.find('#uploadSection').addClass('d-none');
                    wrapper.find('#drawSection').removeClass('d-none');
                    initSignaturePad();
                }
            });

            function initSignaturePad(){
                const canvas = document.getElementById('signature-pad');
                const ctx = canvas.getContext('2d');
                ctx.lineWidth = 3;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';
                ctx.strokeStyle = 'black';

                let drawing = false;
                let lastPos = { x: 0, y: 0 };

                function getPos(e) {
                    const rect = canvas.getBoundingClientRect();
                    const scaleX = canvas.width / rect.width;
                    const scaleY = canvas.height / rect.height;

                    const x = ((e.touches ? e.touches[0].clientX : e.clientX) - rect.left) * scaleX;
                    const y = ((e.touches ? e.touches[0].clientY : e.clientY) - rect.top) * scaleY;
                    return {x, y};
                }

                $(canvas).on('mousedown touchstart', function(e) {
                    drawing = true;
                    lastPos = getPos(e);
                });

                $(canvas).on('mouseup mouseleave touchend', function() {
                    drawing = false;
                });

                $(canvas).on('mousemove touchmove', function(e) {
                    if (!drawing) return;
                    e.preventDefault();
                    const pos = getPos(e);

                    ctx.beginPath();
                    ctx.moveTo(lastPos.x, lastPos.y);
                    ctx.quadraticCurveTo(lastPos.x, lastPos.y, pos.x, pos.y);
                    ctx.stroke();

                    lastPos = pos;
                });

                $('#clear-btn').on('click', function() {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                });

                $('#download-btn').on('click', function() {
                    const link = document.createElement('a');
                    link.download = 'signature.png';
                    link.href = canvas.toDataURL('image/png');
                    link.click();
                });    

                let blankCanvas = canvas.toDataURL("image/png");
                $("#blankSignPad").val(blankCanvas);
                $(document).on("click", '.e-sign-button', function () {
                    let method = $('input[name="signatureMethod"]:checked').val();
                    if (method === "draw") {
                        let signatureData = canvas.toDataURL("image/png");
                        $("#signaturePadInput").val(signatureData);
                    }
                });
            }

            $(document).on('click', '#signDocBtn', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: $(this).data('title'),
                    icon: 'warning',
                    text: $(this).data('desc'),
                    showCancelButton: true,
                    focusConfirm: false,
                    confirmButtonText: '<i class="fas fa-check"></i> Confirm',
                    confirmButtonColor: 'orange',
                    cancelButtonText: '<i class="fas fa-ban"></i> Cancel'
                }).then((confirm) => {
                    if (confirm.isConfirmed) {
                        Swal.fire({
                            title: 'Thank you for your patience!', 
                            text: 'Please wait while updating the documents...',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        });

                        let form = $('#RateeSignForm')[0];
                        let formData = new FormData(form);
                        
                        $.ajax({
                            url: "<?php echo MEWEB.'/peoplesedge/api/employee/pmr/'.$evaluation['EvaluationID'].'/documents/sign' ?>",
                            method: 'POST',
                            data: formData,
                            processData: false,   
                            contentType: false,  
                            headers: {
                                "Accept": "application/json",
                                "Authorization": "Bearer <?php echo $access_token; ?>" 
                            },
                            success: function (response) {
                                console.log(response.message);
                                Swal.fire({
                                    title: response.type,
                                    icon: response.icon,
                                    text: response.message,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false,
                                    confirmButtonText: "Okay"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $('#RateeEsignatureModal').hide();
                                            location.reload();
                                        }
                                });
                            },
                            error: function (xhr, status, error) {
                                console.error('Error:', xhr.responseText || error);
                            }
                        });
                    }
                });
            });
        });
    </script>
</head>
<body>
    <?php if(!isset($error_message)):?>
        <div class="w-100">
            <div class="card card-outline card-primary">
                <h3 class='mt-3 mx-5'>PMR Document Signing</h3>
                <div class="card mx-5">
                    <div class="card-header align-items-center p-3">
                        <h2 class="card-title">
                            <strong>
                                [<span class="copy" data-copy="<?php echo $evaluation['EmpID']; ?>"><?php echo $evaluation['EmpID']; ?></span>]
                                <?php echo $evaluation['FullName']; ?>
                            </strong> 
                            <span class="badge 
                                <?php 
                                    if ($evaluation['status'] !== 'Completed') {
                                        echo $evaluation['status'] !== 'Incomplete' ? 'badge-warning' : 'badge-info';
                                    } else {
                                        echo 'badge-success';
                                    }
                                ?>">
                                <?php echo $evaluation['status']; ?> Evaluation
                            </span> 

                            <?php if ($evaluation['status'] == 'Completed'): ?>
                                <?php if (!empty($post_evaluation)): ?>
                                    <?php
                                        $badge_color = 'badge-info';
                                        if ($post_evaluation['Status'] == 'Post Evaluation Completed') {
                                            $badge_color = 'badge-success';
                                        } elseif ($post_evaluation['Status'] == 'Post Evaluation Returned') {
                                            $badge_color = 'badge-danger';
                                        } elseif (in_array($post_evaluation['Status'], ['Post Evaluation Reprocess', 'Post Evaluation Initiated'])) {
                                            $badge_color = 'badge-warning';
                                        }
                                    ?>
                                    <span class="badge <?php echo $badge_color; ?>">
                                        <?php echo $post_evaluation['Status']; ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-warning">Post Evaluation Not Yet Initiated</span>
                                <?php endif; ?>
                            <?php endif; ?>

                            <div>
                                <small>
                                    <i class="fas fa-info-circle" title="Rank"></i> 
                                    <span class="font-weight-bold"><?php echo $evaluation['Rank']; ?></span> <br>
                                    <i class="fas fa-info-circle" title="Position"></i> 
                                    <?php echo $evaluation['Position']; ?><br>
                                    <i class="fas fa-info-circle" title="Department"></i>
                                    <?php echo $evaluation['Department']; ?><br>
                                </small>
                            </div>
                        </h2>

                        <div class='card-tools m-3'>
                            <?php if (!empty($post_evaluation) && $post_evaluation['Status'] == 'Post Evaluation Completed'): ?>
                                <h5 class="text-success"><b>ALREADY SIGNED</b></h5>
                            <?php else: ?>
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#RateeEsignatureModal">
                                    Sign Documents
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class='card-body'>
                        <?php
                            $with_available_doc = false;
                            if (!empty($documents) && count($documents) > 0) {
                                $with_available_doc = true;
                            }
                        ?>

                        <div class="<?php echo $with_available_doc ? '' : 'd-none'; ?>">
                            <?php if (!empty($documents)): ?>
                                <?php foreach ($documents as $document): ?>
                                    <h5 class="mt-3"><b><?php echo $document['Particulars']; ?></b></h5>
                                    <iframe class="docframe"
                                        src="<?php echo $document['ViewablePath']; ?>#zoom=120" 
                                        width="100%" 
                                        height="1000" 
                                        style="border:1px solid #f3f1f1ff; background: transparent; 
                                            margin-top: -100px;  
                                            clip-path: inset(100px 0 0 0);" 
                                        allowtransparency="true">
                                    </iframe>
                                <?php endforeach; ?>
                            <?php endif; ?>  
                        </div>

                        <form id="RateeSignForm" method="POST" enctype="multipart/form-data">
                            <div id="RateeEsignatureModal" class="modal fade" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h4 class="modal-title d-flex align-items-center gap-2">
                                                <x-lord-icon src="signature-sig.json" state="hover-jump" stroke="solid" />&nbsp;
                                                Sign Documents
                                            </h4>
                                        </div>

                                        <div class="modal-body">
                                            <div class="signature-method-wrapper position-relative">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <label class="mb-0">&nbsp;</label>
                                                    <div class="btn-group btn-group-toggle" data-toggle="buttons" style="border: 1px solid #007bff; border-radius: 50px; overflow: hidden;">
                                                        <label style="margin-right: -15px" class="p-1 px-3 btn btn-xs btn-outline-primary rounded-pill border-0 active">
                                                            <input type="radio" name="signatureMethod" value="upload" autocomplete="off"> Upload
                                                        </label>
                                                        <label class="p-1 px-3 btn btn-xs btn-outline-primary rounded-pill border-0">
                                                            <input type="radio" name="signatureMethod" value="draw" autocomplete="off" checked> Draw
                                                        </label>
                                                    </div>
                                                </div>

                                                <div style='margin-top: -30px;'>
                                                    <div id="uploadSection" class="form-group d-none">
                                                        <div class="form-group">
                                                            <label for="">Upload Esignature</label>
                                                            <input type="file" name="EsignatureFile" class="form-control" accept=".png">
                                                            <small class="form-text text-muted">
                                                                Accepts PNG Image only with transparent background, a 2:1 ratio and maximum 2 MB in size.
                                                            </small>
                                                            <input type='hidden' name='uploadedEsignPath' value="<?php echo isset($esign) ? $esign['EsignPath'] : ''; ?>">
                                                        </div>
                                                    </div>

                                                    <div id="drawSection" class="form-group">
                                                        <div class="form-group">
                                                            <label for="">Draw Signature</label>
                                                            <div class="border rounded p-2 d-flex justify-content-center position-relative mx-auto" style="max-width: 500px; max-height:250px;">
                                                                <input type="hidden" name="blankSignPad" id="blankSignPad">
                                                                <input type="hidden" name="signaturePad" id="signaturePadInput">

                                                                <h6 class="position-absolute text-muted" style="top: 50%; left: 50%; transform: translate(-50%, -50%);pointer-events:none; opacity:0.2;">
                                                                    <i>(Signature Here)</i>
                                                                </h6>
                                                                <h4 class="position-absolute text-muted" 
                                                                    style="top: 70%; left: 50%; transform: translate(-50%, -50%); pointer-events:none; opacity:0.1; white-space: nowrap;">
                                                                    <b id='EmployeeName'><?php echo $evaluation['FullName']; ?></b>
                                                                </h4>

                                                                <canvas id="signature-pad" name="signaturePad" width="1000" height="500" 
                                                                    style="border:1px dashed #ccc; width:100%; max-width: 500px; max-height:250px; touch-action: none;">
                                                                </canvas>

                                                                <button type="button" id="clear-btn" class="btn btn-link btn-sm position-absolute" 
                                                                    style="bottom: 10px; right: 12px;">
                                                                    Clear Signature
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-left">
                                                <hr class="my-4" style="margin: 20px auto;">
                                                <p class="mx-3">
                                                    <i class="text-muted">
                                                        In accordance with the Data Privacy Act of 2012 (R.A. 10173), your signature will be used for the sole purpose of signing this specific form and will not be used for any other document or purpose without your separate and explicit consent.
                                                    </i>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-light" data-dismiss="modal" id="CancelEsignBtn">Cancel</button>
                                            <button type="button" class="btn btn-primary e-sign-button" id="signDocBtn"
                                                data-title="Sign Post Evaluation Documents" 
                                                data-desc="Are you sure you want to sign these post evaluation documents?">
                                                Proceed
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php else:?>
        <div class="alert alert-danger">
            <strong> WARNING! </strong><br><?php echo $error_message; ?>
        </div>
    <?php endif; ?>
</body>
</html>