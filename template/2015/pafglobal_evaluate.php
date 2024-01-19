<?php include(TEMP."/header.php"); ?>
        <style>
            .print {
                display:block;
            }
            .no-print{
                display:block;
            }
            @media print{
                .print {
                    display:block;
                    overflow:none !important;
                    max-height:100%  !important;
                    margin-top:inherit  !important;
                }
                .no-print{
                    display:none;
                }
                
            }
        </style>
    <!-- BODY -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script type="text/javascript" src="<?php echo JS; ?>/addon-jqueryv2.min.js"></script>
    <!-- <script type="text/javascript" src="<?php echo JS; ?>/gibberish.min.js"></script> -->
        <div id="mainsplashtext" class="mainsplashtext lefttalign">  
            <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
            <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
            <div class="rightsplashtext lefttalign">
                <div id="pafevaluateglobal" class="mainbody lefttalign whitetext">  
                    <div class="print">
                    <?php 
                        // Page versions
                        $appdt = date('Y-m-d', strtotime($evaluateRatee[0]['appdt']));

                        if($appdt >= date('Y-m-d', strtotime('2023-01-01'))){
                            include(TEMP.'/pms/pafglobal_evaluate_2023.php');
                        }else if($appdt >= date('Y-m-d', strtotime('2019-01-01'))){
                            include(TEMP.'/pms/pafglobal_evaluate_2019.php');
                        }
                     ?>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var jsPrintAll = function () {
            setTimeout(function () {
                window.print();
            }, 500);
        }
        </script>
<?php include(TEMP."/footer.php"); ?>