<?php
	
	
        
        $id = $_GET["id"];
        if (!$id) :
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/activity'</script>";
        endif;
		
		global $sroot, $profile_id, $unix3month;
        $registrants = '';
        $today = date('Y-m-d');
        $d = '2018-08-31';

        if($today == '2018-08-31')
            $registrants = $tblsql->get_registrantmd5($id, 0, 0, 0, 2029);
        elseif($today == '2018-09-01')
            $registrants = $tblsql->get_registrantmd5($id, 0, 0, 0, 2030);
        else
            $registrants = $tblsql->get_registrantmd5($id, 0, 0, 0, 2106);

        // change this ------------------------------------------->^^^^ to activity id
        //var_dump($registrants);
        
        $return_arr = array();
        
        foreach ($registrants as $key => $value) :

            if ($value['registry_godirectly'] == 1) :
                $godir = 'Will go directly';
            else :
                $godir = 'Will take a tour bus';
            endif;

            if ($value['registry_status'] == 2) :
                $status = 'PRE-REGISTERED AND ATTENDED';
            elseif ($value['registry_status'] == 4) :
                $status = 'ALREADY ATTENDED';
            endif;

            $row_array['regid'] = utf8_encode($value['registry_id']);
            $row_array['empid'] = utf8_encode($value['EmpID']);
            $row_array['fullname'] = utf8_encode($value['FName'].' '.$value['LName']);
            $row_array['godir'] = utf8_encode($godir);
            $row_array['vehicle'] = utf8_encode($value['registry_vehicle']);
            $row_array['status'] = utf8_encode($status);
        
            array_push($return_arr, $row_array);
            $tblsql->attendeventregistry('', $value['registry_id']);
            
        endforeach;
        
        //var_dump($return_arr);
        echo json_encode($return_arr);
        
        
	
?>