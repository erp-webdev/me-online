	
<?php 
    $dateactivity = strtotime($my_registration[0]['activity_datestart']);
    $today = strtotime(date("%Y-%m-%d %H:%M:%S"));
    if($today <= $dateactivity){
        if($_GET['title']=="MEGA-SAYANG PASKONG PILIPINO 2023") {
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/mega-sayang-paskong-pilipino'</script>";
        }
        else if($_GET['title']=="Megaworld 35th Anniversary Fun Run 2024") {
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/megaworld-35th-anniversary-fun-run'</script>";
        }
    }
    else{?>

    <?php include(TEMP."/header.php"); ?>
    <!-- BODY -->
    <div id="mainsplashtext" class="mainsplashtext lefttalign">
        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
        <div class="rightsplashtext lefttalign">
            <div id="mainnotification" class="mainbody lefttalign whitetext">
                <b class="mediumtext lorangetext"><?php echo $_GET['title']; ?></b><br><br>

                <span class="whitetext"><span class="mediumtext"><?php echo $profile_full; ?></span></span><br>
                <span class="whitetext"><span class="mediumtext"><?php echo $profile_idnum; ?></span></span><br>
                <br>
                
                <?php if($my_registration[0]['registry_godirectly'] == 0){ ?>
                    <?php if($my_registration[0]['registry_vrin'] == 1) { ?>
                        <span class="whitetext">Company Vehicle from <b class="whitetext"><?php echo $my_registration[0]['registry_pickup_location']; ?></b> to <?php echo $my_registration[0]['activity_venue']; ?></span> <br>
                    <?php } ?>
                    <?php if($my_registration[0]['registry_vrout'] == 1){ ?>
                        <span class="whitetext">Company Vehicle from <?php echo $my_registration[0]['activity_venue']; ?> to <b class="whitetext"><?php echo $my_registration[0]['registry_pickup_location']; ?></b></span>
                    <?php } ?>
                <?php } else { ?>
                        <span class="whitetext">I'll go directly</span>
                <?php } ?>

                <!-- <span class="whitetext">Cinema: <h3 class="mediumtext"><?php echo $my_registration[0]['registry_location']; ?></h3></span> -->
                <br><br>
                <!-- <span class="whitetext">Seat Plan: <h3 class="mediumtext"><?php echo $my_registration[0]['registry_seat'] ?  $my_registration[0]['registry_seat'] : 'TBA'; ?></h3></span> -->
                <br><br>
                <!-- <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?php echo $id; ?>&choe=UTF-8" width="300" height="300" onerror="alert('QR Code failed to load. Please check your internet connection');" alt="Registration QR Code"> -->

                <img src="https://quickchart.io/chart?chs=300x300&cht=qr&chl=<?php echo $id; ?>&choe=UTF-8" width="300" height="300" onerror="alert('QR Code failed to load. Please check your internet connection');" alt="Registration QR Code">
                
                <!-- <a  class="cursorpoint yellowtext" target="_blank" href="../uploads/activity/vaxcert/<?php echo $my_registration[0]['registry_vaxpath']; ?>">View Vaccination Certificate / Card </a> <br> 
                <span class="whitetext">Vaccination Status: 

                    <?php switch($my_registration[0]['registry_vaxstatus']){
                        // case 1: echo 'First Dose';
                        case 2: echo 'Second Dose'; break;
                        case 3: echo 'Booster 1'; break;
                        case 4: echo 'Booster 2'; break;
                    } ?>
                
                </span> <br>
                <span class="whitetext">Last Vaccination Date: <?php echo date('Y-m-d', $my_registration[0]['registry_vaxlastdate']); ?></span>
                <br>
                <br>
                <span class="whitetext">Group Table Assignment: <?php echo $my_registration[0]['registry_seat']; ?></span>
                -->
                <br><span class="whitetext">Seat Plan: <b>To Be Determined</b></span><br>
                <span>Please check back later</span>
                
                <div class="clearboth">
                    <button onclick="window.history.back();" class="btn btnred margintop25">Back</button>
                </div>
            </div>
        </div>
    </div>
    <?php include(TEMP."/footer.php"); }?>
