<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script type="text/javascript" src="<?php echo JS; ?>/addon-jqueryv2.min.js"></script>
    <!-- <script type="text/javascript" src="<?php echo JS; ?>/gibberish.min.js"></script> -->
        <div id="mainsplashtext" class="mainsplashtext lefttalign">  
            <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
            <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
            <div class="rightsplashtext lefttalign">
                <div id="pafevaluateglobal" class="mainbody lefttalign whitetext">  
                    <div class="printform">
                    <?php 
                        // Page versions
                        $appdt = date('Y-m-d', strtotime($evaluateRatee[0]['appdt']));

                        if($appdt >= date('Y-m-d', strtotime('2019-01-01'))){
                            include(TEMP.'/pms/pafglobal_evaluate_2019.php');
                        }
                     ?>
                    </div>
                </div>
            </div>
        </div>

<?php include(TEMP."/footer.php"); ?>