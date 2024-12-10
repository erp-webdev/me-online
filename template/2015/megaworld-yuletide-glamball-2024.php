<?php 
    $activity_date = $my_registration ? $my_registration[0]['activity_datestart'] : strtotime('2024-12-12'); // 2024-12-12
    $dateactivity = date('Y-m-d', $activity_date);
    $today = date('Y-m-d');
    $dayBeforeActivity = date('Y-m-d', strtotime($dateactivity . ' -1 day'));
    if ($today >= $dayBeforeActivity && $today <= $dateactivity) {
   ?>

    <!DOCTYPE html>
        <html>
        <head>
            <title>MEGAWORLD YULETIDE GLAM BALL 2024</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
            <link rel="stylesheet" href="https://use.typekit.net/oov2wcw.css">  
            <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
            <style>
                .glamball{
                    position: relative;
                    font-family: 'Montserrat', sans-serif;
                    font-size: 15px;
                    background: white;
                }
  
                .glamball::before{
                    content: "";
                    background: url('<?php echo IMG_WEB ?>/goldsnow.jpg') center center;
                    position: absolute;
                    top: 30vh;
                    right: 0px;
                    bottom: 20vh;
                    left: 0px;
                    opacity: 0.3;
                }

                .round-box {
                    border: 3px solid transparent; 
                    border-image: linear-gradient(34deg, #871B06 4%, #D61302 29%, #ED1514 47%, #D61302 75%, #881B06 100%) 1; 
                    width: 85%;
                    max-width:600px;
                    border-radius: 10px;
                }

                .frontpage {
                     position: relative;
                    height:100vh;
                    background: url('<?php echo IMG_WEB ?>/glam-desktop.png') no-repeat center center;
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
                    z-index: 3; 
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
                    color: #D61302;
                }
                dd{
                    margin-bottom: 15px;
                }
                .section-title{
                    font-size: 1.5em;
                    font-weight: bold; 
                    color: #D61302;
        
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
                        background: url('<?php echo IMG_WEB ?>/glam-mobile.png');
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
        <body class='glamball'> 
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
                                <label class="m-3">Log in <a href="<?php echo WEB ?>/mygb24"><b>here</b></a> to see your registration QR Code.</label><br>
                            </div>
                        </div>
                    </div>
                </section>
                <?php }?>
                <section class="d-flex justify-content-center sec_marg">
                    <div class="card round-box ">
                        <div class="card-body">
                            <div class="text-center">
                                <label class="mt-5 text-center section-title fw-bold">FLOOR PLAN</label><br>
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
                            <dt class="text-center fw-bold">SALAD BAR</dt>
                            <dd>Curly green, Iceberg, Lollo rosso, Romaine</dd>
                            <dd>Carrot, Cucumber, Roma Tomatoes, Red beans</dd>
                            <dd>Cheddar Cheese, Parmesan Cheese, Croutons, Lemon wedges</dd>
                            <dd>Thousand Island dressing, Kalamansi Vinaigrette, Caesar Dressing</dd>
                            <dd>Corn kernel, Curly green lettuce</dd>

                            <dt class="text-center fw-bold">APPETIZER</dt>
                            <dd>Beancurd Salad</dd>
                            <dd>Thai Pomelo Salad with Shrimp</dd>
                            <dd>Chinese Soy Chicken, BBQ Pork Asado</dd>

                            <dt class="text-center fw-bold">(SERVED PER TABLE ON A PLATTER)</dt>
                            <dd>Christmas Rumball</dd>
                            <dd>Casava Cake</dd>
                            <dd>Bibingka Malagkit</dd>
                            <dd>Soft and Hard Roll, Butter</dd>

                            <dt class="text-center fw-bold">SOUP</dt>
                            <dd>Pumpkin Soup</dd>

                            <dt class="text-center fw-bold">MAIN COURSE</dt>
                            <dd>Korean Marinated Meatball</dd>
                            <dd>Lasagna</dd>
                            <dd>Yuletide Roast Chicken</dd>
                            <dd>With Lemon Butter, Rosemary and Basil</dd>
                            <dd>Taiwanese Sticky Pork Riblets</dd>
                            <dd>Steamed Rice</dd>

                            <dt class="text-center fw-bold">CARVING</dt>
                            <dd>Lechon Belly Roll</dd>

                            <dt class="text-center fw-bold">DESSERTS</dt>
                            <dd>Mango Sago</dd>
                            <dd>Matcha Cheesecake</dd>
                            <dd>Fresh Fruits</dd>
                        </dl>

                    </div>
                </section>
                <section id='programme' class="d-flex justify-content-center sec_marg">
                    <div class="text-center card round-box  p-5 m-3">
                        <label class="mb-5 text-center section-title fw-bold">PROGRAMME</label>
                        <dl>
                            <dt class="text-center fw-bold">2:00 PM</dt>
                            <dd>REGISTRATION</dd>
                            <dt class="text-center fw-bold">4:00 PM</dt>
                            <dd>START OF PROGRAM</dd>
                            <dd>DOXOLOGY</dd>
                            <dd>MESSAGE OF ALT</dd>
                            <dd>RAFFLE</dd>
                            <dd>SERVICE AWARDS</dd>
                            <dd>RAFFLE</dd>
                            <dd>DINNER</dd>
                            <dd>FRONT ACT - JOEY G.</dd>
                            <dd>RAFFLE</dd>
                            <dd>MAIN ACT - SILENT SANCTUARY</dd>
                            <dd>RAFFLE</dd>
                            <dd>MESSAGE OF RASP </dd>
                            <dd>CHRISTMAS PARTY SDE</dd>
                        </dl>
                    </div>
                </section>
                <section id='reminders' class="d-flex justify-content-center sec_marg">
                    <div class="card round-box  p-5 m-3">
                        <label class="text-center section-title fw-bold">REMINDERS</label><br>
                        <div class="p-1 text-left">
                            <ul>
                                <li>Registration starts at 2:00pm.</li>
                                <li>Do not forget your QR Code.</li>
                                <li>Bring your Company ID.</li>
                                <li>To all Service Awardees: 
                                    <ul>
                                        <li>Claiming of plaques and pins will take place from 2:00 to 4:00pm at Executive West 16 (15, 20, 25 & 30 years) and Executive East 19 (5 & 10 years).</li>
                                        <li>Please be ready at around 4:45 PM (after Dr. Tan’s speech) on the right side of the stage.</li>
                                    </ul>
                                </li>
                                <li>Company Bus to MGB first trip as follows:
                                    <ul>
                                        <li>AGT 1:00PM</li>
                                        <li>TWS 1:15PM</li>
                                        <li>GCP 12:00PM</li>
                                    </ul>
                                </li>
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
                <label class="m-3 text-center" style="font-size: 10px;">All rights reserved 2024</label><br>
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
                        outModes: "out",
                        random: false,
                        speed: 1,
                        straight: false
                    },
                    number: {
                        density: {
                            enable: true,
                            area: 600
                        },
                        value: 80
                    },
                    opacity: {
                        animation: {
                            enable: true,
                            speed: 0.08,
                            sync: true,
                            startValue: "max",
                            count: 1,
                            destroy: "min"
                        },
                        value: {
                            min: 0,
                            max: 1
                        }
                    },
                    shape: {
                        type: "circle"
                    },
                    size: {
                        value: { min: 1, max: 2 }
                    },
                    life: {
                        duration: {
                            sync: false,
                            value: 10 // lifespan of each particle in seconds
                        },
                        count: 1 // infinite regeneration
                    }
                },
                emitters: {
                    direction: "none",
                    life: {
                        count: 0, // infinite
                        duration: 0.2, // how often particles are emitted
                        delay: 0.1 // delay between emissions
                    },
                    rate: {
                        delay: 0.2, // delay between particle bursts
                        quantity: 2 // particles per burst
                    },
                    size: {
                        width: 100, // emitter width
                        height: 100 // emitter height
                    },
                    position: {
                        x: 50,
                        y: 50 // emitter position (in percentage)
                    }
                }
            });
        </script>
    </html>

<?php } 
    else{
        echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/qrcode/".$my_registration[0]['registry_id']."'</script>";
       
    }    
?>

