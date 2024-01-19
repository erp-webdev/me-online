<?php
include("../config.php"); 
include(LIB."/login/chklog.php");

if($logstat != 1){
    echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";

}
else{
    $filepath = DOCUMENT . '/uploads/'.$_GET['file'];
        
    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header("Content-Type: ".mime_content_type($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        flush(); 
        readfile($filepath);
        
    } else {
        echo "<script language='javascript' type='text/javascript'>window.location.href='https://portal.megaworldcorp.com/me/404'</script>";
    }
}

?>