<?php
	
    //$ads = 1;
	$memo_data = $tblsql->get_memos(0, 0, 0, NULL, 0, 0, 0, 'GL');
    //var_dump($memo_data);
    $update_count = 0;

    foreach($memo_data as $key => $value) :

        var_dump($value['announce_pubdate']);
        $value['announce_date'] = strtotime($value['announce_pubdate']);

        $update_new_data = $tblsql->memo_action($value, 'update', $value['announce_id']);
        if ($update_new_data) : 
            $update_count++;
        endif;

    endforeach;

    echo $update_count." memo has been update its date file";
	
?>