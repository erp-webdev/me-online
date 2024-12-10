<?php 
    $activity_date = $my_registration ? $my_registration[0]['activity_datestart'] : strtotime('2024-12-20'); //2024-12-20
    $dateactivity = date('Y-m-d', $activity_date);
    $today = date('Y-m-d');
    $dayBeforeActivity = date('Y-m-d', strtotime($dateactivity . ' -1 day'));
    if ($today >= $dayBeforeActivity && $today <= $dateactivity){
   ?>

    <!DOCTYPE html>
        <html>
        <head>
            <title>BACOLOD Winter Wonderland Christmas 2024</title>
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
                    filter: hue-rotate(190deg) saturate(2) brightness(1.2);
                }

                .round-box {
                    border: 3px solid transparent; 
                    border-image: linear-gradient(50deg, #6B7992 4%,  #6F708F 47%,  #214A76 100%) 1; 
                    width: 85%;
                    max-width:600px;
                    border-radius: 10px;
                }

                .frontpage {
                     position: relative;
                    height:100vh;
                    background: url('<?php echo IMG_WEB ?>/bacolod-wwc-pc.png') no-repeat center center;
                    background-size: cover;
                    z-index: 1;
                    overflow: hidden;
                }

                .snowflake {
                    position: absolute;
                    display: block;
                    background: white; 
                    border-radius: 50%; 
                    opacity: 0.6;
                }

                .snowflake.small {
                    width: 5px;
                    height: 5px;
                }

                .snowflake.medium {
                    width: 8px;
                    height: 8px;
                }

                .snowflake.large {
                    width: 12px;
                    height: 12px;
                }

                @keyframes fall {
                    0% {
                        transform: translateY(0) rotate(0deg);
                    }
                    100% {
                        transform: translateY(120vh) rotate(360deg); 
                    }
                }

                .snowflake {
                    animation-name: fall;
                    animation-timing-function: linear;
                    animation-iteration-count: infinite;
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
                    color: #014c85;
                }
                dd{
                    margin-bottom: 15px;
                }
                .section-title{
                    font-size: 1.5em;
                    font-weight: bold; 
                    color: #014c85;
        
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
                        background: url('<?php echo IMG_WEB ?>/bacolod-wwc-cp.png');
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

                $(function() {
                    var body = $('.frontpage'),
                        template = $('.template.snowflake'),
                        snowflakes = 70;

                    var size = 'small';
                    var createSnowflake = function() {
                        var leftPosition = Math.random() * 100;
                        var animationDuration = 10 + Math.random() * 10; 
                        var delay = Math.random() * 10; 

                        template.clone().removeAttr('id').css({
                            top: '-10%', 
                            left: leftPosition + '%', 
                            animationDelay: delay + 's',
                            animationDuration: animationDuration + 's'
                        }).addClass(size).appendTo(body);
                    };

                    for (var i = 0; i < snowflakes; i++) {
                        if (i % 2 === 0) {
                            size = 'small';
                        } else if (i % 3 === 0) {
                            size = 'large';
                        } else {
                            size = 'medium';
                        }

                        createSnowflake();
                    }
                });

            </script>
        </head>
        <body class='glamball'> 
            <section class="frontpage sec_marg">
                <div class="template snowflake"></div>
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
                                <label class="m-3">Log in <a href="<?php echo WEB ?>/bwwc24"><b>here</b></a> to see your registration QR Code.</label><br>
                            </div>
                        </div>
                    </div>
                </section>
                <?php }?>
                <section class="d-flex justify-content-center sec_marg d-none">
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
                            <dt>STARTERS</dt>
                            <dd>Smoked Chorizo and Roasted Garlic Dip</dd>
                            <dd>Vegetable Spring Roll</dd>

                            <dt>SOUP</dt>
                            <dd>Spinach and Potato</dd>

                            <dt>SALAD</dt>
                            <dd>Roasted Herb Chicken with Potato</dd>

                            <dt>MAIN COURSE</dt>
                            <dd>Beef Medallions</dd>
                            <dd>Rosemary Rubbed Roasted</dd>
                            <dd>Smoked Barbecue Glazed Ribs</dd>

                            <dt>CARVING</dt>
                            <dd>US Angus Beef</dd>

                            <dt>PASTA</dt>
                            <dd>Penne - Bolognese</dd>

                            <dt>STARCH</dt>
                            <dd>Steamed Rice</dd>

                            <dt>VEGETABLE</dt>
                            <dd>Stir Fry</dd>

                            <dt>DESSERTS</dt>
                            <dd>Blondies and Brownies</dd>
                            <dd>British Sticky Toffee Pudding</dd>
                            <dd>Eclair (Mini Salted Caramel Eclair & Mini Coffee Eclair)</dd>

                            <dt>Lechon and Churros</dt>

                            <dt>DRINKS</dt>
                            <dd>Soda and Iced Tea (mixed)</dd>
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
                            <dd>RAFFLE</dd>
                            <dd>GROUP PRESENTATION</dd>
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
                <label class="m-3 text-center" style="font-size: 10px;">All rights reserved 2024</label><br>
            </div>
        </footer>
    </html>

<?php } 
    else{
        echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/qrcode/".$my_registration[0]['registry_id']."'</script>";
       
    }    
?>

