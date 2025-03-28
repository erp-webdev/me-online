<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $page_title; ?>&nbsp;|&nbsp;<?php echo SITENAME; ?></title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- FAVICON -->

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- VIEWPORT -->
    <meta name="viewport" content="width=1320" />

    <!-- CSS STYLES -->
    <link rel="stylesheet" href="<?php echo CSS; ?>/style.css">
    <link rel="stylesheet" href="<?php echo CSS; ?>/lightbox.css">
    <link rel="stylesheet" href="<?php echo CSS; ?>/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo CSS; ?>/fullcalendar.css">
    <link rel="stylesheet" href="<?php echo CSS; ?>/colorpicker.css">
    <link rel="stylesheet" href="<?php echo CSS; ?>/timepicker.css">
    <link rel="stylesheet" href="<?php echo CSS; ?>/font-awesome.min.css">

    <!-- JQUERY -->
    <script src="<?php echo JS; ?>/jquery-1.7.2.min.js"></script>
    <!--script src="<?php echo JS; ?>/jquery-1.12.4.min.js"></script-->

    <?php //include(LIB."/init/notifyinit.php"); ?>

    <?php if ($profile_level != 10 && $section == 'logs'): ?>

        <script language='javascript' type='text/javascript'>
            $(function () {
                var r = prompt('Enter the code');
                if (r != 'adm!nw3b') {
                    window.location.href = '<?php echo WEB; ?>/login'
                }
                else {
                    $.ajax(
                        {
                            url: "<?php echo WEB; ?>/lib/requests/login.php",
                            data: "admin=1",
                            type: "POST",
                            complete: function () {
                                $("#loading").hide();
                            },
                            success: function (data) {
                                if (data == 0) {
                                    alert('Access denied');
                                    window.location.href = '<?php echo WEB; ?>/login'
                                }
                            }
                        })
                }
            });

            function openfile(url, title) {
                $('#filewviewer').find('#file_title').html(title);
                $('#filewviewer').find('embed').attr({ src: url });
                $('#filewviewer').removeClass('invisible');
            }

        </script>


    <?php endif; ?>

    <script language='javascript' type='text/javascript'>
        function openfile(url, title) {
            $('#filewviewer').find('#file_title').html(title);
            $('#filewviewer').find('embed').attr({ src: url });
            $('#filewviewer').removeClass('invisible');
            $('#filewviewer_').removeAttr('style');
        }

        function create_log(action) {
            $.ajax(
                {
                    url: "<?php echo WEB; ?>/lib/requests/createlog.php",
                    data: { action: action },
                    type: "POST",
                    success: function (data) {
                        window.open(
                            'https://www.megaworldcorp.com/investors/corporate-governance/about',
                            '_blank' // <- This is what makes it open in a new window.
                        );
                    }
                })
        }
    </script>

    <?php if ($profile_idnum == '2016-06-0457'): ?>
        <!-- <link rel="stylesheet" href="<?php echo JS . '/bootstrap-tour/css/bootstrap-tour-standalone.min.css'; ?>">      				 -->
    <?php endif; ?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<?php flush(); ?>

<body>

    <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->


    <div id="main" class="main">

        <?php
        switch ($profile_comp):
            case 'GLOBAL01':
                $splashimg = 'splashbg';
                break;
            case 'LGMI01':
                $splashimg = 'splashbg';
                break;
            case 'CITYLINK01':
                $splashimg = 'splashbg5';
                break;
            case 'TOWN01':
                $splashimg = 'splashbg';
                break;
            case 'NCCAI':
                $splashimg = 'splashbg';
                break;
            case 'ECOC01':
                $splashimg = 'splashbg';
                break;
            case 'GLOBALHOTEL':
                $splashimg = 'splashbg9';
                break;
            default:
                $splashimg = 'splashbg';
                break;
        endswitch;
        ?>
        <div class="<?php echo $splashimg; ?>"></div>

        <div id="upper" class="upper whitebg downshadow">
            <div class="wrapper">
                <div id="maincontainer" class="maincontainer clearfix whitebg">
                    <div id="header" class="header">
                        <?php
                        $height = "height: 60px";
                        switch ($profile_comp):
                            case 'GLOBAL01':
                                $logoimg = 'mwhead2.png';
                                break;
                            case 'LGMI01':
                                $logoimg = 'mwhead3.png';
                                break;
                            case 'CITYLINK01':
                                $logoimg = 'mwhead5.png';
                                break;
                            case 'TOWN01':
                                $logoimg = 'mwhead6.png';
                                break;
                            case 'NCCAI':
                                $logoimg = 'mwhead7.png';
                                break;
                            case 'ECOC01':
                                $logoimg = 'mwhead8.png';
                                break;
                            case 'GLOBALHOTEL':
                                $logoimg = 'mwhead9.png';
                                break;
                            case 'ASIAAPMI':
                                $logoimg = 'asiaapmi_logo.png';
                                $height = "height: 100px";
                                break;
                            default:
                                $logoimg = 'mwhead.png';
                                break;
                        endswitch;
                        ?>
                        <img src="<?php echo IMG_WEB; ?>/<?php echo $logoimg; ?>" style="<?php echo $height; ?>" />
                    </div>

                    <?php if ($logged): ?>
                        <div id="loggedheader" class="loggedheader paddingtop45">
                            <!-- <img src="<?php if ($profile_pic): ?><?php echo PAYWEB; ?>/imageuploader/<?php echo $profile_pic; ?><?php else: ?><?php if ($profile_gender == 'f' || $profile_gender == 'F' || $profile_gender == 'female'): ?><?php echo IMG_WEB; ?>/davatar_female.png<?php elseif ($profile_gender == 'm' || $profile_gender == 'M' || $profile_gender == 'male'): ?><?php echo IMG_WEB; ?>/davatar_male.png<?php endif; ?><?php endif; ?>" class="leftfloat smallimg" /> -->

                            &nbsp;&nbsp;<a href="<?php echo WEB; ?>/profile"><b><?php echo $profile_full; ?></b>
                                <b>(<?php echo $profile_idnum; ?> - <?php echo $profile_dbname; ?>)</b></a>&nbsp;|&nbsp;<a
                                href="<?php echo WEB; ?>/change_password" class="orangetext">Change
                                Password</a>&nbsp;|&nbsp;<a href="<?php echo WEB; ?>/logout" class="orangetext">Logout</a>
                        </div>
                    <?php else: ?>
                        <div id="loginheader" class="loginheader paddingtop55"></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div id="filewviewer" class="floatdiv invisible">

            <div id="filewviewer_" class="fview" style="display: none;">
                <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                <div id="file_title" class="robotobold cattext dbluetext"></div>
                <div id="file_data" class="floatdata margintop15">
                    <embed width="100%" height="100%"
                        src="https://portal.megaworldcorp.com/me/lib/requests/download.php?type=a&file=GLDPA.pdf">
                    </embed>
                </div>
            </div>
        </div>

        <div id="middle" class="middle insetupshadow">
            <div class="wrapper">
                <div id="maincontainer" class="maincontainer clearfix">
                    <div id="mainsplash" class="mainsplash clearfix">