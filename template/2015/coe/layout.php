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
            background: rgb(204,204,204); 
        }

        /*page {
            background: white;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
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
        }*/

        @page{
            background: white;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
            width: 21cm;
            height: 29.7cm;
        }

        .container {
            min-height:100%;
            position:relative;
            margin: 1in;
        }

        .header {
            padding:1in;
        }
        
        .body {
            padding:1in;
            padding-bottom:0.5in;   /* Height of the footer */
        }

        .footer {
            position:absolute;
            bottom:0;
            width:100%;
            height:0.5in;   /* Height of the footer */
        }

        @media print {
            body, @page {
                margin: 0;
                box-shadow: 0;
            }
        }

    </style>
</head>
<body>
    
<?php 
    // header
    include(TEMP.'/coe/header.php');

    switch ($coe[0]["type"]) {
        case 'COENONCASHADVANCEMENT':
            include(TEMP . '/coe/coe_non_cash_advancement.php');
            break;
        
        default:
            # code...
            break;
    }

    // footer
    include(TEMP.'/coe/footer.php');
?>


</body>
</html>