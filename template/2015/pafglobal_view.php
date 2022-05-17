<?php include(TEMP."/header.php"); ?>
        <style>
            .print {
                display:none;
            }
            .no-print{
                display:block;
            }
            @media print{
                .print {
                    display:block;
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
            <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo SYSTEMNAME; ?></div>
            <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
            <div class="rightsplashtext lefttalign">
                <div class="print">
                <?php 
                    // Page versions
                    if($pafad == 'ratee'){
                       $appdt = date('Y-m-d', strtotime($viewAppraisal[0]['appdt']));
                    }
                    else{
                        $appdt = date('Y-m-d', strtotime($checkEvaluation[0]['appdt']));
                    }

                    if($appdt <= date('Y-m-d', strtotime('2017-12-31'))){
                        include(TEMP.'/pms/pafglobal_view_2017.php');
                    }elseif($appdt <= date('Y-m-d', strtotime('2018-12-31'))){
                        include(TEMP.'/pms/pafglobal_view_2018.php');
                    }else{ 
                        include(TEMP.'/pms/pafglobal_view_2019.php');
                    }

                 ?>
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


