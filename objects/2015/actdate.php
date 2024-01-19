<?php
	
    //$ads = 1;
	$act_data = $tblsql->get_activities(0, 0, 0, NULL, 0, 0, 0, 0, 0, 'GL');
    //var_dump($memo_data);
    $update_count = 0;

    foreach($act_data as $key => $value) :

        //var_dump($value['announce_pubdate']);
        $value['activity_date'] = strtotime($value['activity_date']);

        $update_new_data = $tblsql->activity_action($value, 'update', $value['activity_id']);
        if ($update_new_data) : 
            $update_count++;
        endif;

    endforeach;

    echo $update_count." activity has been update its date file";
	
?>