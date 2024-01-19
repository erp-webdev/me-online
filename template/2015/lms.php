    <?php include(TEMP."/header.php"); ?>

        <!-- BODY -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="<?php echo JS; ?>/addon-jqueryv2.min.js"></script>
            <div id="mainsplashtext" class="mainsplashtext lefttalign">
                <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                <div class="rightsplashtext lefttalign">
                    <div id="lms" class="mainbody lefttalign whitetext">

                        <b class="mediumtext lorangetext">Learning and Development</b><br><br>

                        <?php

                            switch ($subpage) {
                                case 'employee':
                                    include(TEMP.'/lms/employee.php');
                                    break;

                                default:
                                    include(TEMP.'/lms/main.php');
                                    break;
                            }


                         ?>


                    </div>
                </div>

    <?php include(TEMP."/footer.php"); ?>
