    <?php include(TEMP."/header.php"); ?>

        <!-- BODY -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="<?php echo JS; ?>/addon-jqueryv2.min.js"></script>
            <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                <div class="rightsplashtext lefttalign">
                    <div id="pafevaluate" class="mainbody lefttalign whitetext">  
                        
                        <?php 

                            $appdt = date('Y-m-d', strtotime($evaluateRatee[0]['appdt']));
                            if($appdt <= '2018-12-31')
                                include(TEMP.'/pms/pafevaluate_old.php');
                            else
                                include(TEMP.'/pms/pafevaluate_2019.php');

                         ?>

                    </div>
                </div>

    <?php include(TEMP."/footer.php"); ?>