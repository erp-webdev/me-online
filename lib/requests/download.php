<?php 

	include("../../config.php"); 
	include(LIB."/login/chklog.php");

    if($logstat != 1){
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
        exit;
    }

    if (isset($_REQUEST["file"]) && isset($_REQUEST['type'])) {
        // Get parameters
        // $file = urldecode($_REQUEST["file"]); // Decode URL-encoded string
        $file = urldecode($_REQUEST["file"]); // Decode URL-encoded string
        /* Check if the file name includes illegal characters
        like "../" using the regular expression */
        $folder = "/uploads/download/";

        switch ($_REQUEST['type']) {
            case 'forms':
                $folder = "/uploads/download/";
                break;
            case 'memo':
                $folder = "/uploads/download/";
                break;
            case 'activity':
                $folder = "/uploads/download/";
                break;
            case 'ads':
                $folder = "/uploads/download/";
                break;
            default:
                $folder = "/uploads/download/";
                break;
        }

        // $filepath = "images/" . $file;
        $filepath = DOCUMENT . $folder . $file;
        
        // Process download
        if (file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header("Content-Type: ".mime_content_type($filepath));
            // header('Content-Type: application/octet-stream');
            // header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            flush(); // Flush system output buffer
            readfile($filepath);
            // fopen($filepath, 'rb');
            
            die();
        } else {
            echo "<script language='javascript' type='text/javascript'>window.location.href='https://portal.megaworldcorp.com/me/404'</script>";
        }
        
    } else {
        echo "<script language='javascript' type='text/javascript'>window.location.href='https://portal.megaworldcorp.com/me/404'</script>";
    }

	
?>			