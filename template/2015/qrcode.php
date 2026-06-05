	
<?php 
    $dateactivity = date('Y-m-d', $my_registration[0]['activity_datestart']);
    $today = date('Y-m-d');
    $dayBeforeActivity = date('Y-m-d', strtotime($dateactivity . ' -1 day'));
    
    if (($today >= $dayBeforeActivity && $today <= $dateactivity) && in_array($_GET['title'], 
            [
                'MAKULAY ANG PASKO SA MEGA 2025',
                'MAKULAY ANG PASKO SA MEGA 2025 MACTAN NEWTOWN',
                'MAKULAY ANG PASKO SA MEGA 2025 BACOLOD',
                'MAKULAY ANG PASKO SA MEGA 2025 ILOILO'
            ])) {
        if($_GET['title']=="MAKULAY ANG PASKO SA MEGA 2025") {
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/makulay-ang-pasko-sa-mega-2025'</script>";
        }
        else if($_GET['title']=="MAKULAY ANG PASKO SA MEGA 2025 MACTAN NEWTOWN") {
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/makulay-ang-pasko-sa-mega-2025-cebu'</script>";
        }
        else if($_GET['title']=="MAKULAY ANG PASKO SA MEGA 2025 BACOLOD") {
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/makulay-ang-pasko-sa-mega-2025-bacolod'</script>";
        }
        else if($_GET['title']=="MAKULAY ANG PASKO SA MEGA 2025 ILOILO") {
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/makulay-ang-pasko-sa-mega-2025-iloilo'</script>";
        }
    }
    else{?>

    <?php include(TEMP."/header.php"); ?>
    <style>
        .qr-pass-wrap {
            max-width: 760px;
            margin: 0 auto;
        }

        . {
            padding: 24px;
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 18px;
            background: rgba(13, 35, 60, 0.52);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.04);
        }

        .qr-pass-header {
            padding-bottom: 18px;
            margin-bottom: 22px;
            border-bottom: 1px dashed rgba(255, 255, 255, 0.2);
        }

        .qr-pass-title {
            display: block;
            margin-bottom: 8px;
            color: #ffbc47;
            font-size: 28px;
            line-height: 1.1;
            letter-spacing: 0.02em;
        }

        .qr-pass-subtitle {
            color: rgba(255, 255, 255, 0.7);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }

        .qr-pass-body {
            display: flex;
            gap: 26px;
            align-items: flex-start;
        }

        .qr-pass-meta {
            flex: 1 1 0;
            min-width: 0;
        }

        .qr-pass-name {
            margin: 0 0 6px;
            color: #ffffff;
            font-size: 24px;
            line-height: 1.05;
        }

        .qr-pass-id {
            margin: 0 0 22px;
            color: rgba(255, 255, 255, 0.72);
            font-size: 16px;
        }

        .qr-pass-label {
            display: block;
            margin-bottom: 6px;
            color: rgba(255, 255, 255, 0.72);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.14em;
        }

        .qr-pass-cinema {
            display: inline-block;
            padding: 10px 14px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            font-size: 20px;
            font-weight: 700;
        }

        .qr-code-panel {
            flex: 0 0 320px;
            padding: 16px;
            border-radius: 10px;
            background: #ffffff;
            text-align: center;
            border: 1px solid rgba(0, 0, 0, 0.12);
        }

        .qr-code-panel img {
            display: block;
            width: 100%;
            max-width: 284px;
            height: auto;
            margin: 0 auto;
        }

        .qr-code-caption {
            margin-top: 12px;
            color: #29425d;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .qr-pass-actions {
            margin-top: 24px;
        }

        @media screen and (max-width: 900px) {
            .qr-pass-body {
                flex-direction: column;
            }

            .qr-code-panel {
                flex-basis: auto;
                width: 100%;
                max-width: 320px;
            }
        }
    </style>
    <div id="mainsplashtext" class="mainsplashtext lefttalign">
        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
        <div class="rightsplashtext lefttalign">
            <div id="mainnotification" class="mainbody lefttalign whitetext">
                <div class="qr-pass-wrap">
                    <div class="">
                        <div class="qr-pass-header">
                            <span class="qr-pass-subtitle">Event Registration Pass</span>
                            <b class="qr-pass-title"><?php echo $_GET['title']; ?></b>
                        </div>

                        <div class="qr-pass-body">
                            <div class="qr-pass-meta">
                                <h1 class="qr-pass-name"><?php echo $profile_full; ?></h1>
                                <div class="qr-pass-id"><?php echo $profile_idnum; ?></div>

                <?php /*
                <!-- <?php if($my_registration[0]['registry_godirectly'] == 0){ ?>
                    <?php if($my_registration[0]['registry_vrin'] == 1) { ?>
                        <span class="whitetext">Company Vehicle from <b class="whitetext"><?php echo $my_registration[0]['registry_pickup_location']; ?></b> to <?php echo $my_registration[0]['activity_venue']; ?></span> <br>
                    <?php } ?>
                    <?php if($my_registration[0]['registry_vrout'] == 1){ ?>
                        <span class="whitetext">Company Vehicle from <?php echo $my_registration[0]['activity_venue']; ?> to <b class="whitetext"><?php echo $my_registration[0]['registry_pickup_location']; ?></b></span>
                    <?php } ?>
                <?php } else { ?>
                        <span class="whitetext">I'll go directly</span>
                <?php } ?> -->
                */ ?>

                                <span class="qr-pass-label">Assigned Cinema</span>
                                <div class="qr-pass-cinema"><?php echo $my_registration[0]['registry_location']; ?></div>
                            </div>
                <?php /*
                <!-- <span class="whitetext">Seat Plan: <h3 class="mediumtext"><?php echo $my_registration[0]['registry_seat'] ?  $my_registration[0]['registry_seat'] : 'TBA'; ?></h3></span> -->
                <br><br>
                <!-- <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?php echo $id; ?>&choe=UTF-8" width="300" height="300" onerror="alert('QR Code failed to load. Please check your internet connection');" alt="Registration QR Code"> -->
                */ ?>
                            <div class="qr-code-panel">
                                <img src="https://quickchart.io/chart?chs=300x300&cht=qr&chl=<?php echo $id; ?>&choe=UTF-8" width="300" height="300" onerror="alert('QR Code failed to load. Please check your internet connection');" alt="Registration QR Code">
                                <div class="qr-code-caption">Present this QR at check-in</div>
                            </div>
                        </div>
                <?php /*
                
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
                <br><span class="whitetext">Seat Plan: <b>To Be Determined</b></span><br>
                <span>Please check back later</span>
                -->
                */ ?>
                        <div class="clearboth qr-pass-actions">
                            <button onclick="window.history.back();" class="btn btnred">Back</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include(TEMP."/footer.php"); }?>
