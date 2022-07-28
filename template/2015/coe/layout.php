<?php include(TEMP .'/coe/common.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COE Certificates</title>
    <style>
        body {
            width: 21cm;
            height: 29.7cm;
        }
        page {
            background: white;
            display: block;
            margin: 0 auto;
        }
        page[size="A4"] {  
            width: 21cm;
            height: 29.7cm; 
        }
        page[size="A4"][layout="portrait"] {
            width: 29.7cm;
            height: 21cm;  
        }
        page[size="A4"][layout="landscape"] {
            height: 29.7cm;
            width: 21cm;  
        }
        .container {
            position:relative;
            margin: 1in;
            width: 21cm;
            height: 29.7cm;
        }
        .footer {
            position:absolute !important;
            bottom:0;
            width:100%;
            height:1in;   /* Height of the footer */
            margin: 1in;
        }

        .content{
            height: 26;
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
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        
       
    </div>
    <div class="footer">
        <?php    include(TEMP.'/coe/footer.php'); ?>
        </div>
   
</page>
</body>
</html>