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
        <div id="mainsplashtext" class="mainsplashtext lefttalign">
            <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
            <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
            <div class="rightsplashtext lefttalign ">
                <div class="print">
                    <!-- kevs::
                    <?php echo json_decode($viewAppraisal); ?>
                  -->
                <?php
    
                    if($pafad == 'ratee'){
                        $appdt = date('Y-m-d', strtotime($viewAppraisal[0]['appdt']));
                    }else{
                        $appdt = date('Y-m-d', strtotime($checkEvaluation[0]['appdt']));
                    }
                    
                    if($appdt <= date('Y-m-d', strtotime('2018-12-31'))){
                        include(TEMP.'/pms/pafview_old.php');
                    }else{
                        include(TEMP.'/pms/pafview_2019.php');
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
