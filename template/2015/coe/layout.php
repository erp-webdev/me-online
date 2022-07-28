<?php include(TEMP .'/coe/common.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COE Certificates</title>
    <style>
        
        @page {
            size: A4;
            padding: 1in;
        }

        @page{
            @bottom-center{
                content: 'testing';
            }
        }

    </style>
</head>
<body>
<page >
    <div class="container">
        <div class="header">
        <?php  include(TEMP.'/coe/header.php'); ?>
        </div>

        <div class="content">
        
        <?php

        switch ($coe[0]["type"]) {
            case 'COENONCASHADVANCEMENT':
                include(TEMP . '/coe/coe_non_cash_advancement.php');
                break;
            
            default:
                # code...
                break;
        }

        ?>
        </div>

       
    </div>
    <div class="footer">
        <?php    include(TEMP.'/coe/footer.php'); ?>
        </div>
</page>
</body>
</html>