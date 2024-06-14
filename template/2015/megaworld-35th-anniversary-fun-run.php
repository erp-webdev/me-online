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
                    background: rgb(18,77,138);
                    background: linear-gradient(284deg, rgba(18,77,138,1) 5%, rgba(166,255,64,1) 100%);
                }
                .round-box {
                    border-radius: 18px; 
                    box-shadow: 10px 5px 10px 5px rgba(0, 0, 0, 0.3);
                    width: 85%;
                }

                .funrun::before{
                    content: "";
                    background: url('');
                    position: absolute;
                    top: 0px;
                    right: 0px;
                    bottom: 0px;
                    left: 0px;
                    opacity: 0.4;
                }
                .sec_marg{
                    margin-bottom:100px;
                    color: #FFFFFF;
                }

                .frontpage {
                position: relative;
                height:100vh;
                background-color:#FFFFFF;

                }

                .frontpage::before,
                .frontpage::after {
                content: '';
                position: absolute;
                background-size: cover;
                background-repeat: no-repeat;
                }

                .frontpage::before {
                top: 0;
                right: 0;
                width: 100%;
                height: 60vh;
                max-width: 300px;
                max-height: 320px;
                background-image: url(''); 
                }

                .frontpage::after {
                bottom: 0;
                left: 0;
                width: 100%;
                height: 60vh;
                max-width: 610px;
                max-height: 400px;
                background-image: url('');
                }

                .heartmega{
                    position: absolute;
                    top:10px;
                    left:5px;
                    max-width:110px;
                    max-height: 75px;
                }

                .megafunrun-div{
                    position: absolute;
                    top:35vh;
                    left:6%;
                    right:4%;
                    max-width:100%;
                }

                .megafunrun{
                    max-width:100%;
                    max-height:100%;
                    display:block;
                    margin: 0 auto;
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

                @media only screen and (max-width: 800px) {
                    .frontpage{
                        padding: 10px;
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
                }
            </style>
            <script>
                $(document).on('click','#imgView', function(){
                    $("#imgModal").modal("show");
                    var modal = $('#imgModal');
                    var imgInModal = $('#imginModal');
                    
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
                });

                $(document).on('click','#imgModal', function(){
                    $("#imgModal").modal("hide");
                });

            </script>
        </head>
        <body class='funrun'> 
                <section class="frontpage sec_marg">
                    <img class="heartmega" src="<?php echo IMG_WEB ?>/mw.png" alt="oneheartonemega" >
                    <div class="megafunrun-div">
                        <img src="<?php echo IMG_WEB ?>/megafunrun-frontpic.png" class="megafunrun" alt="frontpic" >
                    </div>
                    <img class="logo" src="<?php echo IMG_WEB ?>/megafunrun-logo.png">
                </section>
                <?php if ($logstat==1){?>
                <section id='qr' class="d-flex justify-content-center sec_marg">
                    <div class="card round-box border-0 p-5 m-3">
                        <div class="text-center">
                            <label class="text-center section-title fw-bold" style="color:#124D8A;">REGISTRATION QR CODE</label><br>
                            <label class="mt-5" style="font-size: 16px; color:#000;"><strong><?php echo $profile_full ?></strong></label><br>
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
                <?php  } ?>
                <section class="d-flex justify-content-center sec_marg">
                    <div class="card round-box border-0 p-5 m-3">
                        <div class="card-body">
                            <div class="text-center">
                                <label class="mb-3 text-center section-title fw-bold" style="color:#124D8A;">ROUTE</label><br>
                                <img  src="<?php echo IMG_WEB ?>/megasaya-floorplan.png" alt="Fun Run Route" style="width:100%;" id="imgView"><br>
                                <p class="mt-3"><i>Note: For a clear view of the map, please click on the image to enlarge it. </i></p><br>
                            </div>
                        </div>
                    </div>
                </section>
                <section id='programme' class="d-flex justify-content-center sec_marg">
                    <div class="text-center card round-box border-0 p-5 m-3">
                        <label class="mb-5 text-center section-title fw-bold" style="color:#124D8A;">PROGRAMME</label>
                        <label class="text-center fw-bold" style="color:#000;">2:00 PM</label><br>
                        <p>REGISTRATION</p><br>
                        <label class="text-center fw-bold" style="color:#000;">4:00 PM</label><br>
                        <p>START OF PROGRAM</p>
                        <p>MESSAGE OF ALT</p>
                        <p>RAFFLE</p>
                        <p>SERVICE AWARDS</p>
                        <p>DINNER</p>
                        <p>NEOCOLOURS</p>
                        <p>LOLA AMOUR</p>
                        <p>MAJOR RAFFLE</p>
                        <p>MESSAGE OF RASP </p>
                        <p>CHRISTMAS PARTY SDE</p>
                    </div>
                </section>
                <section id='reminders' class="d-flex justify-content-center sec_marg">
                    <div class="card round-box border-0 p-5 m-3">
                        <label class="text-center section-title fw-bold" style="color:#124D8A;">REMINDERS</label><br>
                        <div class="p-1 text-left">
                            <p><b>1.</b> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque sagittis dignissim nibh ac accumsan.</p>
                            <p><b>2.</b> Nam sed auctor odio, sit amet aliquet nulla. Proin eu diam non diam iaculis maximus.</p>
                            <p><b>3.</b> Aliquam et commodo elit. Mauris sollicitudin risus eu quam vestibulum rhoncus.</p>
                            <p><b>4.</b> Praesent at ante faucibus, faucibus dui quis, efficitur leo. Curabitur eget feugiat mi. Nullam eu lobortis ante. </p>
                            <p><b>5.</b> Sed at erat et metus euismod faucibus. Nulla quis cursus ante. Ut a enim nec neque consectetur dignissim non vitae neque. Nunc maximus sagittis tortor. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                        </div>
                    </div>
                </section>
        </body>
        <footer class="d-flex justify-content-center pt-5 " style="background: #FFFFFF; height: 20vh; width:100%">
            <div class="text-center" style="background: #FFFFFF; height: 20vh; width:100%">
                <a href="https://www.megaworldcorp.com/"><img class="align-items-center" src="https://upload.wikimedia.org/wikipedia/commons/a/a3/Megaworld_New_Logo_Horizontal.png" alt="" style="width:30%; max-width:105px;"></a>
                <a href="https://www.globalcompanies.com.ph/"><img class="align-items-center" src="https://www.globalcompanies.com.ph/assets/img/global_one_and_luxury_global_malls-logo1.jpg" alt="" style="width:60%; max-width:210px;"></a><br>
                <label class="m-3 text-center">All rights reserved 2024</label><br>
            </div>
        </footer>
        <!-- Modal -->
        <div class="modal modal-xl" id="imgModal" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog modal-dialog-centered d-flex justify-content-center" role="document">
                <img  class="modal-content" src="<?php echo IMG_WEB ?>/megasaya-floorplan.png" alt="Fun Run Route" id="imginModal">
            </div>
        </div>
    </html>

<?php } ?>

