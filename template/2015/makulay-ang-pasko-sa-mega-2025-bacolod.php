<?php 
    $activity_date = $my_registration ? $my_registration[0]['activity_datestart'] : strtotime('2025-11-10'); //2025-12-12
    $dateactivity = date('Y-m-d', $activity_date);
    $today = date('Y-m-d');
    $dayBeforeActivity = date('Y-m-d', strtotime($dateactivity . ' -1 day'));
    if ($today >= $dayBeforeActivity && $today <= $dateactivity) {
        $_SESSION['mega-christmas'] = "0";
        $_SESSION['ncr']="0";
        $_SESSION['cebu']="0";
        $_SESSION['bacolod']="1";
        $_SESSION['iloilo']="0";
   ?>

    <!DOCTYPE html>
        <html>
        <head>
            <title><?php echo $page_title;?></title>
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
                    background: url('<?php echo IMG_WEB ?>/bacolod-bg.png') center center repeat;
                    position: absolute;
                    top: 30vh;
                    right: 0px;
                    bottom: 20vh;
                    left: 0px;
                }

                .round-box {
                    position: relative; 
                    border: 3px solid transparent;
                    border-image: linear-gradient(50deg, 
                                                #9A2B63,
                                                #ffffff,
                                                #86A32E
                                                ) 1;
                    width: 85%;
                    max-width: 600px;
                    border-radius: 10px;
                    padding-top: 60px; 
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
                    background-image: url("<?php echo IMG_WEB ?>/banner.png");
                    background-size: contain;
                    background-repeat: no-repeat;
                    background-position: center top;
                }

                .frontpage {
                     position: relative;
                    height:100vh;
                    background: url('<?php echo IMG_WEB ?>/makulay-ang-pasko-sa-mega-2025-pc-bacolod.png') no-repeat center center;
                    background-size: cover;
                    z-index: 1;
                    overflow: hidden;
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
                    color: #9A2B63;
                }
                dd{
                    margin-bottom: 15px;
                }
                .section-title{
                    font-size: 1.5em;
                    font-weight: bold; 
                    color: #9A2B63;
        
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
                        background: url('<?php echo IMG_WEB ?>/makulay-ang-pasko-sa-mega-2025-mobile-bacolod.png');
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
                <section class="frontpage sec_marg"></section>
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
                                <label class="m-3">Log in <a href="<?php echo WEB ?>/mega-christmas-page-checker"><b>here</b></a> to see your registration QR Code.</label><br>
                            </div>
                        </div>
                    </div>
                </section>
                <?php }?>
                <section class="d-flex justify-content-center sec_marg">
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
                                <li>Registration starts at 3:00 PM.</li>
                                <li>Only pre-registered employees with QR codes will be allowed to attend the Christmas Party.</li>
                                <li>Present your QR code at the Registration Area.</li>
                                <li>For Service Awardees, they should be at the venue on or before 3:00 PM. Upon arrival, claim your plaque, pin, and printed photo at the Registration Area.</li>
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
    </html>

<?php } 
    else{
        $_SESSION['bacolod']="0";
        echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/qrcode/".$my_registration[0]['registry_id']."'</script>";
    }    
?>

