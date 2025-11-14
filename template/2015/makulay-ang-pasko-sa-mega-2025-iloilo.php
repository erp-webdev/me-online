<?php 
    $activity_date = $my_registration ? $my_registration[0]['activity_datestart'] : strtotime('2025-11-14'); //2025-12-11
    $dateactivity = date('Y-m-d', $activity_date);
    $today = date('Y-m-d');
    $dayBeforeActivity = date('Y-m-d', strtotime($dateactivity . ' -1 day'));
    if ($today >= $dayBeforeActivity && $today <= $dateactivity) {
        $_SESSION['mega-christmas'] = "0";
        $_SESSION['ncr']="0";
        $_SESSION['cebu']="0";
        $_SESSION['bacolod']="0";
        $_SESSION['iloilo']="1";
   ?>

    <!DOCTYPE html>
        <html>
        <head>
            <title>MAKULAY ANG PASKO SA MEGA 2025 ILOILO</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
            <link rel="stylesheet" href="https://use.typekit.net/oov2wcw.css">  
            <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
            <style>
                .party-theme{
                    position: relative;
                    font-family: 'Montserrat', sans-serif;
                    font-size: 15px;
                    background: white;
                }
  
                .party-theme::before{
                    content: "";
                    /* background: url('<?php echo IMG_WEB ?>/goldsnow.jpg') center center; */
                    position: absolute;
                    top: 30vh;
                    right: 0px;
                    bottom: 20vh;
                    left: 0px;
                    opacity: 0.3;
                }

                .round-box {
                    position: relative;
                    border: 3px solid transparent; 
                    border-image: linear-gradient(65deg,
                                    #007A5E 0%,
                                    #007A5E 12%,
                                    #8DC63F 22%,
                                    #8DC63F 34%,
                                    #C05FA8 44%,
                                    #C05FA8 56%,
                                    #6C4099 66%,
                                    #6C4099 78%,
                                    #EF4023 86%,
                                    #F7941D 100%) 1;
                    width: 85%;
                    max-width:600px;
                    border-radius: 10px;
                    z-index: 3;
                    padding-top: 30px; 
                    background: #fff; 
                }

                .round-box::before {
                    content: "";
                    position: absolute;
                    top: 0;
                    left: 50%;
                    transform: translateX(-50%);
                    width: 100%;
                    max-width: 600px;
                    height: 50px; 
                    background-image: url("<?php echo IMG_WEB ?>/star.png");
                    margin-top: 10px;
                    margin-left: -8px;
                    background-size: contain;
                    background-repeat: no-repeat;
                    background-position: right top;
                }

                .frontpage {
                    position: relative;
                    height:100vh;
                    background: url('<?php echo IMG_WEB ?>/makulay-ang-pasko-sa-mega-2025-pc-iloilo.png') no-repeat center center;
                    background-size: cover;
                    z-index: 1;
                    overflow: hidden;
                }

                #tsparticles {
                    position: relative;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100vh;
                    z-index: 2; 
                }
                
                .sec_marg{
                    padding-top:50px;
                    padding-bottom:50px;
                    color: #000;
                }
    
                label{
                    font-size: 1.5em;
                    color: #000;
                }
                .idnum{
                    font-size: 1em;
                    color: #000;
                }
                p, ul{
                    color: #000;
                }
                a, dt{
                    color: #d76400ff;
                }
                dd{
                    margin-bottom: 15px;
                }
                .section-title{
                    font-size: 1.5em;
                    font-weight: bold; 
                    color: #d76400ff;
        
                }
                .expand{
                    display: block;
                    justify-content: center;
                }

                footer{
                    background: #FFF; 
                    height: 20vh; 
                    width:100%
                }

                @media only screen and (max-width: 800px) {
                    .expand{
                        display: flex;
                    }

                    .section-title, label{
                        font-size: 1em;
                    }
                    .idnum, p, dd, ul, span{
                        font-size: 0.9em;
                    }

                    .frontpage {
                        background: url('<?php echo IMG_WEB ?>/makulay-ang-pasko-sa-mega-2025-mobile-iloilo.webp');
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
                            'height': '260px',
                            'width': '1000px'
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
        <body class='party-theme'> 
                <section class="frontpage sec_marg">
                    <div id="tsparticles"></div>
                </section>
                <?php if ($logstat==1){?>
                <section id='qr' class="d-flex justify-content-center sec_marg">
                    <div class="card round-box  p-5 m-3">
                        <div class="text-center">
                            <label class="text-center section-title fw-bold">REGISTRATION QR CODE</label><br>
                            <label class="mt-5"><strong><?php echo $profile_full ?></strong></label><br>
                            <label class="idnum"><strong><?php echo $profile_idnum ?></strong></label><br>
                            <p> 
                                <?php echo $company[0]['CompanyName']; ?>
                                <br>
                                <?php echo $profile_dept ?>
                            </p><br>
                            <img src="https://quickchart.io/chart?chs=300x300&cht=qr&chl=<?php echo $my_registration[0]['registry_id'] ?>&choe=UTF-8" alt="QR Code" style="width:90%; max-width:300px;"><br>
                            <p class="mt-3">Note: Have your QR Code ready for scanning at the event's registration and claiming of food.</p><br>
                        </div>
                    </div>
                </section>
                <?php  } 
                else{?>
                <section class="d-flex justify-content-center sec_marg">
                    <div class="card  round-box">
                        <div class="card-body">
                            <div class="text-center">
                                <label class="mx-3 mb-3">Log in <a href="<?php echo WEB ?>/mega-christmas-page-checker"><b>here</b></a> to see your registration QR Code.</label><br>
                            </div>
                        </div>
                    </div>
                </section>
                <?php }?>
                <section class="d-flex justify-content-center sec_marg d-none">
                    <div class="card round-box ">
                        <div class="card-body">
                            <div class="text-center">
                                <label class="text-center section-title fw-bold">FLOOR PLAN</label><br>
                                <div class="m-4">
                                    <?php if (!($my_registration[0]['registry_seat']=="")){?>
                                        <span>Your seat number is</span>
                                        <label class="mb-3"><strong><?php echo $my_registration[0]['registry_seat']?></strong></label><br>
                                    <?php }?>
                                    <div class="fw-bold">Main Hall</div>
                                    <img src="<?php echo IMG_WEB ?>/mgb-mainhall.png" alt="Main Hall" class="imgView" style="width:90%;" data-image="mgb-mainhall.png"><br>

                                    <div class="fw-bold">Sky Box</div>
                                    <img src="<?php echo IMG_WEB ?>/mgb-skybox.png" alt="Sky Box" class="imgView" style="width:90%;" data-image="mgb-skybox.png"><br>
                                </div>
                                <p class="mt-3">Note: For a clear view of the floor plan, please click on the image to enlarge it.</p><br>
                            </div>
                        </div>
                    </div>
                </section>
                <section id='food' class="d-flex justify-content-center sec_marg">
                    <div class="text-center card round-box  p-5 m-3">
                        <label class="mb-5 text-center section-title fw-bold">FOOD MENU</label>
                        <dl>
                            <dt class="text-center fw-bold">COLD FOOD</dt>
                            <dd>Ham and Cheese Triangle</dd>

                            <dt class="text-center fw-bold">SALAD</dt>
                            <dd>Macaroni De Luxe</dd>

                            <dt class="text-center fw-bold">MAIN COURSE</dt>
                            <dd>Lasagna</dd>
                            <dd>Salisbury Steak</dd>
                            <dd>Baked Chicken in Herbs</dd>
                            <dd>Steamed Fish Oriental</dd>
                            <dd>Lechon</dd>

                            <dt class="text-center fw-bold">DESSERT</dt>
                            <dd>Sago Melaka</dd>
                            <dd>Black Sambo</dd>

                            <dt class="text-center fw-bold">DRINKS</dt>
                            <dd>Iced Tea</dd>
                        </dl>
                    </div>
                </section>
                <section id='programme' class="d-flex justify-content-center sec_marg">
                    <div class="text-center card round-box  p-5 m-3">
                        <label class="mb-5 text-center section-title fw-bold">PROGRAMME</label>
                        <dl>
                            <dt class="text-center fw-bold">3:00 PM</dt>
                            <dd>REGISTRATION</dd>
                            <dt class="text-center fw-bold">4:00 PM</dt>
                            <dd>5 MINUTES COUNTDOWN</dd>
                            <dd>DOXOLOGY</dd>
                            <dd>OPENING MESSAGE</dd>
                            <dd>RAFFLE</dd>
                            <dd>SERVICE AWARDS</dd>
                            <dd>VIDEO MESSAGE</dd>
                            <dd>DINNER</dd>
                            <dd>1ST SET BAND</dd>
                            <dd>GROUP PRESENTATION</dd>
                            <dd>AWARDING: STAR OF THE NIGHT</dd>
                            <dd>RAFFLE</dd>
                            <dd>CLOSING REMARKS</dd>
                            <dd>RAFFLE</dd>
                            <dd>CHRISTMAS PARTY SDE</dd>
                            <dd>FINAL SET BAND</dd>
                        </dl>
                    </div>
                </section>
                <section id='reminders' class="d-flex justify-content-center sec_marg">
                    <div class="card round-box  p-5 m-3">
                        <label class="text-center section-title fw-bold">REMINDERS</label><br>
                        <div class="p-1 text-left">
                            <ul>
                                <li>Registration starts at 3:00 PM</li>
                                <li>Only pre-registered employees with QR codes will be allowed to attend the Christmas Party</li>
                                <li>Present your QR code at the Registration Area</li>
                                <li>For Service Awardees, they should be at the venue on or before 3:00PM. Upon arrival, claim your plaque, pin and printed photo at the Registration Area.</li>
                            </ul>
                        </div>
                    </div>
                </section>
        </body>
        <!-- Modal -->
        <div class="modal modal-xl" id="imgModal" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog modal-dialog-centered expand" role="document">
                <img  class="modal-content" alt="Fun Run Route" id="imginModal">
            </div>
        </div>
        <footer class="d-flex justify-content-center pt-5 ">
            <div class="text-center" style="background: #FFFFFF; height: 20vh; width:100%">
                <a href="https://www.megaworldcorp.com/"><img class="align-items-center" src="<?php echo IMG_WEB ?>/gl - meg - lg.png" alt="" style="width:80%; max-width:500px;"></a><br>
                <label class="m-3 text-center" style="font-size: 10px;">All rights reserved 2025</label><br>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/tsparticles@1.37.4/tsparticles.min.js"></script>
        <script>
            tsParticles.load("tsparticles", {
                fpsLimit: 60,
                background: {
                    color: "transparent"
                },
                particles: {
                    color: { value: "#ffffff" },
                    move: {
                        direction: "none",
                        enable: true,
                        outModes: "bounce",
                        random: true,
                        speed: 0.4,
                        straight: false
                    },
                    number: {
                        density: {
                            enable: true,
                            area: 800
                        },
                        value: 50
                    },
                    opacity: {
                        animation: {
                            enable: true,
                            speed: 1,
                            minimumValue: 0.1,
                            sync: false
                        },
                        value: { min: 0.1, max: 0.8 }
                    },
                    shape: {
                        type: "image",
                        image: [
                            {
                                src:'<?php echo IMG_WEB ?>/star.png'
                            }
                        ]
                    },
                    size: {
                        value: { min: 1, max: 10 }
                    },
                    life: {
                        count: 0
                    }
                }
            });
        </script>
    </html>

<?php } 
    else{
        $_SESSION['iloilo']="0";
        echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/qrcode/".$my_registration[0]['registry_id']."'</script>";
    }    
?>

