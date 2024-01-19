<?php

    //if ($logged == 1 && $profile_level != 8) {
		
		global $sroot, $profile_id, $unix3month;

        $id = $_REQUEST["id"] ? (int)$_REQUEST["id"] : 1 ;
        $type = $_REQUEST["type"] ? (int)$_REQUEST["type"] : 1 ;
        $image = $mainsql->get_image($type, $id);

        if ($type == 2) :           
            $filetype = "attachments";
        elseif ($type == 3) :           
            $filetype = "attachments";
        else :
            $filetype = "profilepic";
        endif;


        if ($image) :
                        
            if ($type == 2) :
                if ($image[0]['ExtensionFN'] == "pdf" || $image[0]['ExtensionFN'] == "PDF") :
                    header("Content-type: application/pdf");
                    header("Content-Disposition: inline; filename='".$image[0]['Comments']."'");
                else :
                    header("Content-type: image/jpeg");
                endif;
                print $image[0]['emp_piccontent'];
            elseif () :
                header("Content-type: image/jpeg");
                print $image[0]['activity_image'];
            endif;

            

        else : 

            $page_title = "File Not Found";	

            ?>

            <?php include(TEMP."/header.php"); ?>
    
            <div id="lowerlist" class="lowerlist solidbottom">
                <div class="menudiv left3">
                </div>
                <div class="div6" style="height: 150px; padding-top: 50px;"> 
                    Cannot load the file, its <?php echo $filetype; ?> has been inactive or deleted. <a href="<?php echo WEB; ?>">Back to Home</a>
                </div>
            </div>

            <?php include(TEMP."/footer.php"); ?>

            <?php

        endif;

        //}

    
