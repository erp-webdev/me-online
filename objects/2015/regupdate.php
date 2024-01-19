<?php
        
        $id = $_REQUEST["id"];
        $bus = $_REQUEST["bus"];
        if (!$id && !$bus) :
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/activity'</script>";
        else :
            $post['registry_vehicle'] = $bus ? 'Bus No.: '.$bus : '';
            $update_reg = $tblsql->attendeventregistry($post, $id);
        endif;

?>