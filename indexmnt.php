<?php $sitename = 'ME Online'; 
# MAINTENANCE
$live = 1;
    
if ($live) :
    echo "<script language='javascript' type='text/javascript'>window.location.href='https://portal.megaworldcorp.com/me'</script>";
endif;
?>
<html>
    <head>
        <title>Site Maintenance | <?php echo $sitename; ?></title>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
    </head>
    <body>
        <div style="margin: 50px auto; width: 600px">
            <div style="display: inline-block; width: 600px; text-align: center">
                <img src="sitemaintain.png" border="0">
            </div>
            <div style="display: inline-block; width: 600px; margin: 20px auto; text-align: center; font-family: Verdana">
                <b><?php echo $sitename; ?> is currently under maintenance.</b><br>We should be back as soon as possible<br>Sorry for inconvenience. Thank you.
            </div>            
        </div>
    </body>
</html>