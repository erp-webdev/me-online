<?php 
$date=date("Ymd");
if($date=="20231206"){?>

    <!DOCTYPE html>
        <html>
        <head>
            <title>MEGA-SAYANG PASKONG PILIPINO 2023</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
            <link rel="stylesheet" href="https://use.typekit.net/oov2wcw.css">
            <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
            <style>
                .snowflakes{
                    position: relative;
                    font-family: 'Montserrat';
                    font-size: 14px;
                    background-color: #d4af37;
                }
                .snowflakes::before{
                    content: "";
                    background: url('<?php echo IMG_WEB ?>/snowflakes.png');
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
                background-image: url('<?php echo IMG_WEB ?>/megasayangpic2.png'); 
                }

                .frontpage::after {
                bottom: 0;
                left: 0;
                width: 100%;
                height: 60vh;
                max-width: 610px;
                max-height: 400px;
                background-image: url('<?php echo IMG_WEB ?>/megasayangpic1.png');
                }

                .heartmega{
                    position: absolute;
                    top:10px;
                    left:5px;
                    max-width:110px;
                    max-height: 75px;
                }

                .megasaya-div{
                    position: absolute;
                    top:35vh;
                    left:6%;
                    right:4%;
                    max-width:100%;
                }

                .megasaya{
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
                });

                $(document).on('click','#imgModal', function(){
                    $("#imgModal").modal("hide");
                });

            </script>
        </head>
        <body class='snowflakes'>
                <section class="frontpage sec_marg">
                    <img class="heartmega" src="<?php echo IMG_WEB ?>/mw.png" alt="oneheartonemega" >
                    <div class="megasaya-div">
                        <img src="<?php echo IMG_WEB ?>/megasayang-frontpic.png" class="megasaya" alt="frontpic" >
                    </div>
                    <img class="logo" src="<?php echo IMG_WEB ?>/megasaya-logo.png">
                </section>
                <?php if ($logstat==1){?>
                <section id='qr' class="d-flex justify-content-center sec_marg">
                            <div class="text-center mt-5">
                                <label class="text-center section-title fw-bold" style="color:#b90e0a;">REGISTRATION QR CODE</label><br>
                                <label class="mt-5" style="font-size: 16px; color:#000;"><strong><?php echo $profile_full ?></strong></label><br>
                                <p> 
                                    <?php echo $company[0]['CompanyName']; ?>
                                    <br>
                                    <?php echo $profile_dept ?>
                                </p><br>
                                <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?php echo $my_registration[0]['registry_id'] ?>&choe=UTF-8" alt="QR Code" style="width:90%; max-width:300px;"><br>
                                <p class="mt-3">Reminders:  <br> Have your QR Code ready for scanning <br> at the event's registration and food claiming. </p><br>
                            </div>
                </section>
                <section id='seat' class="d-flex justify-content-center sec_marg">
                    <div class="card border-0 bg-transparent">
                        <div class="card-body">
                            <div class="text-center">
                                <label class=" text-center section-title fw-bold" style="color:#b90e0a;">FLOOR PLAN</label><br>
                                <?php if (!($my_registration[0]['registry_seat']=="")){?>
                                    <label class="mt-5 text-white">Your seat number is </label><br>
                                    <label class="mb-3 fs-5"><strong><?php echo $my_registration[0]['registry_seat']?></strong></label><br>
                                <?php }?>
                                <img src="<?php echo IMG_WEB ?>/megasaya-floorplan.png" alt="Seat Plan" style="width:90%;" id="imgView"><br>
                            </div>
                        </div>
                    </div>
                </section>
                <?php  }else{ ?>
                    <section id='seat' class="d-flex justify-content-center sec_marg">
                        <div class="card border-0 bg-transparent">
                            <div class="card-body">
                                <div class="text-center">
                                    <label class="m-5 text-center section-title fw-bold" style="color:#b90e0a;">FLOOR PLAN</label><br>
                                    <label class="mb-3 text-white">Log in <a class="text-danger fw-bold" href="<?php echo WEB ?>/mspp">here</a> to see your seat number.</label><br>
                                    <img src="<?php echo IMG_WEB ?>/megasaya-floorplan.png" alt="Seat Plan" style="width:90%;" id="imgView"><br>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php  } ?>
                <section id='food' class="d-flex justify-content-center sec_marg" >
                    <div class="text-center" >
                        <label class="mb-5 text-center section-title fw-bold" style="color:#b90e0a;">FOOD MENU</label><br>

                        <label class="text-center fw-bold" style="color:#000;">ENSALADAS<br>(SELECTION OF FILIPINO SALADS)</label><br>
                        <p class="ms-5 me-5">Luntiang Dahon sa Hardin<br>
                                            Curly green, Iceberg, Lollo rosso Romaine<br>
                                            Carrot, Cucumber, Roma Tomatoes, Red beans<br>
                                            Cheddar Cheese Parmesan Cheese, Croutons, Lemon wedges<br>
                                            Thousand island dressing, Kalamansi Vinaigrette, Caesar Dressing<br>
                                            Corn kernel, Curly green lettuce
                        </p><br>
                        <label class="text-center fw-bold" style="color:#000;">
                                            PAMPAGANA<br>
                                            APPETIZER
                        </label><br>
                        <p class="ms-5 me-5">
                                            (SERVED ON THE BUFFET)<br>
                                            Guimaras Mango Salad With Pulled Pork Cilantro<br>
                                            Lumpiang Shanghai with Sweet and Sour Sauce<br>
                                            Chicken Galantine<br>
                                            (SERVED PER TABLE ON A PLATTER)<br>
                                            Sticky Rice with Coconut Milk<br>
                                            Maja Blanca<br>
                                            Bibingka<br>
                                            Soft and Hard Roll, Butter
                        </p><br>
                        <label class="text-center fw-bold" style="color:#000;">SABAW<br>SOUP</label><br>
                        <p class="ms-5 me-5">Bulalo (served with Malunggay Pandesal)</p><br>
                        <label class="text-center fw-bold" style="color:#000;">MGA ULAM<br>(HOT MAIN DISH)</label><br>
                        <p class="ms-5 me-5">BariIla Pasta in Pesto with Chicken<br>
                                            Beef Morcon<br>
                                            Man Ho's Style Braised Bean Curd with Ground Pork, Shitake Mushroom and Scallions<br>
                                            Roasted chicken with Toyomansi dip<br>
                                            Pan Fried Hake Fillet on Warm Potato Salad and Chopped Bacon<br>
                                            Steamed Rice
                        </p><br>
                        <label class="text-center fw-bold" style="color:#000;">CARVING</label><br>
                        <p class="ms-5 me-5">Lechon<br>Slow Roasted Pig with Roasted Potatoes and Tomato and Garlic confit with Liver sauce<br>
                                            Glenhams Christmas Ham<br>
                                            Maple Syrup, Pepper Sauce
                        </p><br>
                        <label class="text-center fw-bold" style="color:#000;">MGA PANGHIMAGAS<br>DESSERTS</label><br>
                        <p class="ms-5 me-5">Tres Leches Cake<br>
                                            Traditional Buko Pandan (Pandan flavored gelatin with shredded young coconut in sweet cream)<br>
                                            Salted Caramel Cake Fudge<br>
                                            Turon with Sesame Seed<br>
                                            Sariwang Prutas sa Panahon (Fresh fruits in season)
                        </p><br>
                        </div>
                </section>
                <section id='programme' class="d-flex justify-content-center sec_marg">
                    <div class="text-center">
                        <label class="mb-5 text-center section-title fw-bold" style="color:#b90e0a;">PROGRAMME</label><br>

                        <label class="text-center fw-bold" style="color:#000;">2:00 PM</label><br><br>
                        <p>REGISTRATION</p><br>
                        <label class="text-center fw-bold" style="color:#000;">4:00 PM</label><br><br>
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
        </body>
        <footer class="d-flex justify-content-center pt-5 " style="background: #FFFFFF; height: 20vh; width:100%">
            <div class="text-center" style="background: #FFFFFF; height: 20vh; width:100%">
                <a href="https://www.megaworldcorp.com/"><img class="align-items-center" src="https://upload.wikimedia.org/wikipedia/commons/a/a3/Megaworld_New_Logo_Horizontal.png" alt="Menu" style="width:30%; max-width:105px;"></a>
                <a href="https://www.globalcompanies.com.ph/"><img class="align-items-center" src="https://www.globalcompanies.com.ph/assets/img/global_one_and_luxury_global_malls-logo1.jpg" alt="Menu" style="width:60%; max-width:210px;"></a><br>
                <label class="m-3 text-center">All rights reserved 2023</label><br>
            </div>
        </footer>
        <!-- Modal -->
        <div class="modal" id="imgModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 100%;" role="document">
                <div class="modal-content">
                    <img src="<?php echo IMG_WEB ?>/megasaya-floorplan.png" alt="Seat Plan" style="width:100%;">
                </div>
            </div>
        </div>
    </html>

<?php } ?>

