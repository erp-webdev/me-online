<?php 
    $dateactivity = strtotime($my_registration[0]['activity_datestart']);
    $today = strtotime(date("%Y-%m-%d %H:%M:%S"));
    if($today <= $dateactivity){
        
    ?>

    <!DOCTYPE html>
        <html>
        <head>
            <title>Megaworld 35th Anniversary Fun Run 2024</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
            <link rel="stylesheet" href="https://use.typekit.net/oov2wcw.css">
            <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
            <style>
                .funrun{
                    position: relative;
                    font-family: 'Montserrat';
                    font-size: 14px;
                    /* background: rgb(18,77,138);
                    background: linear-gradient(284deg, rgba(18,77,138,1) 5%, rgba(166,255,64,1) 100%); */
                    background: rgb(182,211,66);
                    background: linear-gradient(100deg, rgba(182,211,66,1) 0%, rgba(0,166,222,1) 100%);
                }
                .round-box {
                    border-radius: 18px; 
                    box-shadow: 10px 5px 10px 5px rgba(0, 0, 0, 0.3);
                    width: 85%;
                    max-width:600px;
                }

                .frontpage {
                position: relative;
                height:93vh;
                background-color:#FFFFFF;
                background: url('<?php echo IMG_WEB ?>/funrun-pc.png') white;
                background-size: cover; 
                background-position: center; 
                background-repeat: no-repeat; 

                }
                .sec_marg{
                    margin-bottom:100px;
                    color: #FFFFFF;
                }
                
                .logo{
                    position: absolute;
                    bottom:30px;
                    right:15px;
                    max-width:180px;
                    max-height: 130px;
                }
                label{
                    font-size: 18px;
                }
                p{
                    font-size: 14px;
                }
                a{
                    font-size: 12px;
                }
                .section-title{
                    font-size: 20px;
                }
                .expand{
                    display: block;
                    justify-content: center;
                }

                @media only screen and (max-width: 800px) {
                    .expand{
                        display: flex;
                    }

                    .logo{
                        max-width:110px;
                        max-height: 100px;
                    }

                    label{
                        font-size: 14px;
                    }
                    p{
                        font-size: 12px;
                    }
                    .section-title{
                        font-size: 16px;
                    }

                    .frontpage::before {
                    max-width: 210px;
                    max-height: 280px;
                    }

                    .frontpage::after {
                    max-width: 310px;
                    max-height: 300px;
                    }

                    .frontpage {
                        background: url('<?php echo IMG_WEB ?>/funrun-cp.png') white;
                        background-size: cover; 
                        background-position: center; 
                        background-repeat: no-repeat; 
                        padding: 10px;

                        }
                }
            </style>
            <script>
                $(document).on('click','.imgView', function(){
                    var filename = $(this).data('image');
                    var img = "<?php echo IMG_WEB ?>/"+filename;
                    modalView(img);
                });

                function modalView(img){
                    $("#imgModal").modal("show");
                    var modal = $('#imgModal');
                    var imgInModal = $('#imginModal');
                    imgInModal.attr("src", img);
                    
                    modal.css('display', 'block');
                    
                    if ($(window).height() > $(window).width()) {
                        imgInModal.css({
                            'transform': 'rotate(90deg)',
                            'max-height': '100%',
                            'max-width': '100vh',
                            'height': '360px',
                            'width': '700px'
                        });
                    } else {
                        imgInModal.css({
                            'transform': 'none',
                            'width': '100%'
                        });
                    }
                }

                $(document).on('click','#imgModal', function(){
                    $("#imgModal").modal("hide");
                });

            </script>
        </head>
        <body class='funrun'> 
                <section class="frontpage sec_marg"></section>
                <?php if ($logstat==1){?>
                <section id='qr' class="d-flex justify-content-center sec_marg">
                    <div class="card round-box border-0 p-5 m-3">
                        <div class="text-center">
                            <label class="text-center section-title fw-bold" style="color:#124D8A;">REGISTRATION QR CODE</label><br>
                            <label class="mt-5" style="font-size: 16px; color:#000;"><strong><?php echo $profile_full ?></strong></label><br>
                            <label style="font-size: 13px; color:#000;"><strong><?php echo $profile_idnum ?></strong></label><br>
                            <p style="color:#000;"> 
                                <?php echo $company[0]['CompanyName']; ?>
                                <br>
                                <?php echo $profile_dept ?>
                            </p><br>
                            <img src="https://quickchart.io/chart?chs=300x300&cht=qr&chl=<?php echo $my_registration[0]['registry_id'] ?>&choe=UTF-8" alt="QR Code" style="width:90%; max-width:300px;"><br>
                            <p class="mt-3"><i>Note: Have your QR Code ready for scanning at the event's registration.</i> </p><br>
                        </div>
                    </div>
                </section>
                <?php  } 
                else{?>
                <section id='qr' class="d-flex justify-content-center sec_marg">
                    <div class="card border-0 round-box">
                        <div class="card-body">
                            <div class="text-center">
                                <label class="m-3">Log in <a style ="font-size: 16px;" class="text-primary" href="<?php echo WEB ?>/mfr35"><b>here</b></a> to see your registration QR Code.</label><br>
                            </div>
                        </div>
                    </div>
                </section>
                <?php }?>
                <section class="d-flex justify-content-center sec_marg">
                    <div class="card round-box border-0">
                        <div class="card-body">
                            <div class="text-center">
                                <label class="mt-5 text-center section-title fw-bold" style="color:#124D8A;">ROUTE</label><br>
                                <div class="mt-5 fw-bold" style="width:100%; font-size: 16px">NCR</div>
                                <div class="row m-3">
                                    <div class="col-6">
                                        <div class="fw-bold">3km MAP</div>
                                        <img  src="<?php echo IMG_WEB ?>/3kmap.png" alt="Fun Run 3km Route" style="width:100%;" class="imgView" data-image="3kmap.png">
                                    </div>
                                    <div class="col-6 ">
                                        <div class="fw-bold">5km MAP</div>
                                        <img  src="<?php echo IMG_WEB ?>/5kmap.png" alt="Fun Run 5km Route" style="width:100%;" class="imgView" data-image="5kmap.png">
                                    </div>
                                </div>

                                <div class="mt-5 fw-bold" style="width:100%; font-size: 16px">BACOLOD</div>
                                <div class="m-4">
                                    <div class="fw-bold">3.5km MAP</div>
                                    <img  src="<?php echo IMG_WEB ?>/3.5kmbacolod.jpg" alt="Fun Run 3km Route" style="width:50%;" class="imgView" data-image="3.5kmbacolod.jpg">
                                </div>

                                <div class="mt-5 fw-bold" style="width:100%; font-size: 16px">CEBU</div>
                                <div class="m-4">
                                    <div class="fw-bold">3.5km MAP</div>
                                    <img  src="<?php echo IMG_WEB ?>/3.5kmcebu.png" alt="Fun Run 3km Route" style="width:50%;" class="imgView" data-image="3.5kmcebu.png">
                                </div>

                                <div class="mt-5 fw-bold" style="width:100%; font-size: 16px">ILOILO</div>
                                <div class="m-4">
                                    <div class="fw-bold">3.5km MAP</div>
                                    <img  src="<?php echo IMG_WEB ?>/3.5kmIloilo.jpg" alt="Fun Run 3km Route" style="width:50%;" class="imgView" data-image="3.5kmIloilo.jpg">
                                </div>
                                <p class="mt-3"><i>Note: For a clear view of the map, please click on the image to enlarge it. </i></p><br>
                            </div>
                        </div>
                    </div>
                </section>
                <section id='programme' class="d-flex justify-content-center sec_marg">
                    <div class="text-center card round-box border-0 p-5 m-3">
                        <label class="mb-5 text-center section-title fw-bold" style="color:#124D8A;">PROGRAMME FOR NCR</label>
                        <label class="text-center fw-bold" style="color:#000;">3:00 AM</label><br>
                        <p>REGISTRATION</p>
                        <label class="text-center fw-bold" style="color:#000;">4:45 AM</label><br>
                        <p>START OF PROGRAMME</p>
                        <label class="text-center fw-bold" style="color:#000;">5:30 AM</label><br>
                        <p>GUNSTART 5KM</p>
                        <label class="text-center fw-bold" style="color:#000;">5:40 AM</label><br>
                        <p>GUNSTART 3KM</p>
                        <br>
                        <p>MESSAGE FROM LTGA</p>
                        <p>AWARDING OF RUNNERS</p>
                        <p>RAFFLE</p>
                        <p>MESSAGE FROM RASP</p>
                    </div>
                </section>
                <section id='programme' class="d-flex justify-content-center sec_marg">
                    <div class="text-center card round-box border-0 p-5 m-3">
                        <label class="mb-5 text-center section-title fw-bold" style="color:#124D8A;">PROGRAMME FOR REGIONAL</label>
                        <label class="text-center fw-bold" style="color:#000;">3:30 AM</label><br>
                        <p>REGISTRATION</p>
                        <label class="text-center fw-bold" style="color:#000;">4:30 AM</label><br>
                        <p>START OF PROGRAMME</p>
                        <label class="text-center fw-bold" style="color:#000;">5:40 AM</label><br>
                        <p>GUNSTART 3KM</p>
                        <br>
                        <p>PROGRAM PROPER</p>
                        <p>LIVESTREAM MESSAGE FROM LTGA</p>
                        <p>AWARDING OF RUNNERS</p>
                        <p>RAFFLE</p>
                        <p>CLOSING REMARKS</p>
                    </div>
                </section>
                <section id='reminders' class="d-flex justify-content-center sec_marg">
                    <div class="card round-box border-0 p-5 m-3">
                        <label class="text-center section-title fw-bold" style="color:#124D8A;">REMINDERS</label><br>
                        <div class="p-1 text-left">
                            <ul>
                                <li>For NCR employees: Registration starts at 3am to 5am only.</li>
                                <li>For Regional employees: Registration starts at 3:30am to 4:30am only.</li>
                                <li>Do not forget your QR Code.</li>
                                <li>Bring your ID.</li>
                                <li>No shirt No entry policy.</li>
                            </ul>
                        </div>
                    </div>
                </section>
        </body>
        <footer class="d-flex justify-content-center pt-5 " style="background: #FFFFFF; height: 20vh; width:100%">
            <div class="text-center" style="background: #FFFFFF; height: 20vh; width:100%">
                <a href="https://www.megaworldcorp.com/"><img class="align-items-center" src="<?php echo IMG_WEB ?>/gl - meg - lg.png" alt="" style="width:80%; max-width:500px;"></a><br>
                <label class="m-3 text-center" style="font-size: 10px;">All rights reserved 2024</label><br>
            </div>
        </footer>
        <!-- Modal -->
        <div class="modal modal-xl" id="imgModal" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog modal-dialog-centered expand" role="document">
                <img  class="modal-content" alt="Fun Run Route" id="imginModal">
            </div>
        </div>
    </html>

<?php } ?>

