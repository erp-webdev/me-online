<?php 
    $dateactivity = date('Y-m-d',$my_registration[0]['activity_datestart']);
    $today = date('Y-m-d');
    if($today == $dateactivity || true){
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
                    filter: hue-rotate(180deg) saturate(3) brightness(1.2);
                }
/* 
                .glamball::after {
                    content: "";
                    background: url('<?php echo IMG_WEB ?>/ray.gif') no-repeat center center;
                    background-size: cover;
                    transform: scaleX(-1);
                    transform-origin: center;
                    position: absolute;
                    top: 0;
                    left: 0;
                    right:0;
                    width: 100%;
                    height: 100vh;
                    z-index: 2;
                    opacity: 0.1; 
                } */

                .round-box {
                    border: 3px solid transparent; 
                    border-image: linear-gradient(34deg, #00001C 4%, #3B6B8E 29%, #3B6B8E 47%, #3B6B8E 75%, #0A0A25 100%) 1; 
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

                .shine {
                    display: block;
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAlgAAAJYCAMAAACJuGjuAAADAFBMVEX///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////+/LkhhAAAA/3RSTlMAAQIDBAUGBwgJCgsMDQ4PEBESExQVFhcYGRobHB0eHyAhIiMkJSYnKCkqKywtLi8wMTIzNDU2Nzg5Ojs8PT4/QEFCQ0RFRkdISUpLTE1O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);
                    background-repeat: no-repeat;
                    background-position:center;
                    background-size: 100% 100%;
                    overflow: hidden;
                    z-index: 3;
                    color: tansparent;
                    -moz-opacity: 0.0;
                    opacity: 0.0;
                    animation: glitter 6s linear 0s infinite normal;
                    -webkit-animation: glitter 6s linear 0s infinite normal;
                    -moz-animation: glitter 8s linear 0s infinite normal;
                    -ms-animation: glitter 8s linear 0s infinite normal;
                    -o-animation: glitter 8s linear 0s infinite normal;
                }

                .shine.small {
                    width: 20px;
                    height: 20px;
                }

                .shine.medium {
                    width: 30px;
                    height: 30px;
                }

                .shine.large {
                    width: 50px;
                    height: 50px;
                }

                @-webkit-keyframes glitter {
                    0% {
                        -webkit-transform: scale(0.3) rotate(0deg);
                        opacity: 0;
                    }
                    25% {
                        -webkit-transform: scale(1) rotate(360deg);
                        opacity: 1;
                    }
                    50% {
                        -webkit-transform: scale(0.3) rotate(720deg);
                        opacity: 0;
                    }
                    100% {
                        -webkit-transform: scale(0.3) rotate(0deg);
                        opacity: 0;
                    }
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
                    .idnum, p, dd, ul{
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

                $(function() {
                    var body = $('.frontpage'),
                        template = $('.template.shine'),
                        stars =  80,
                        sparkle = 40;
                    
                        
                    var size = 'small';
                    var createStar = function() {
                        template.clone().removeAttr('id').css({
                        top: (Math.random() * 100) + '%',
                        left: (Math.random() * 100) + '%',
                        webkitAnimationDelay: (Math.random() * sparkle) + 's',
                        mozAnimationDelay: (Math.random() * sparkle) + 's'
                        }).addClass(size).appendTo(body);
                    };
                    
                    for(var i = 0; i < stars; i++) {
                        if(i % 2 === 0) {
                        size = 'small';
                        } else if(i % 3 === 0) {
                        size = 'large';
                        } else {
                        size = 'medium';
                        }
                        
                        createStar();
                    }
                });
            </script>
        </head>
        <body class='glamball'> 
                <section class="frontpage sec_marg">
                    <div class="template shine"></div>
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
                                        <p>Your seat number is </p><br>
                                        <label class="mb-3 fs-5"><strong><?php echo $my_registration[0]['registry_seat']?></strong></label><br>
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
                                <li>Company Bus first trip at 12:00 noon.</li>
                                <li>Registration starts at 2:00pm.</li>
                                <li>Do not forget your QR Code.</li>
                                <li>Bring your Company ID.</li>
                                <li>For Service Awardees, be ready at the right side of the stage.</li>
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

