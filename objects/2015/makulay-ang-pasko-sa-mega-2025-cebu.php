<?php

if ($logged == 1 && $profile_dbname != 'ECINEMA' && $profile_dbname != 'EPARKVIEW' && $profile_dbname != 'NEWTOWN' && $profile_dbname != 'LAFUERZA') {

        $id = $_GET["id"];
       
        # ASSIGNED VALUE
		$page_title = "MAKULAY ANG PASKO SA MEGA 2025 MACTAN NEWTOWN";
		global $sroot, $profile_id, $unix3month;

		$id = substr($id, 0, strlen($id) - 10);
        $my_registration = $tblsql->get_registration($id, 0, 0, 0, $profile_id, $profile_dbname);
        $company = $tblsql->get_company($profile_comp, $profile_dbname);
        
        //AUDIT TRAIL
        $audit['EMPID'] = $profile_idnum;
        $audit['TASKS'] = "ACCESSED ACTIVITY PAGE";
        $audit['DATA'] = $page_title;
        $audit['DATE'] = date("m/d/Y H:i:s.000");

        $audit_log = $mainsql->log_action($audit, 'add');
	}
?>
