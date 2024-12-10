<?php

if ($logged == 1 && $profile_dbname != 'ECINEMA' && $profile_dbname != 'EPARKVIEW' && $profile_dbname != 'NEWTOWN' && $profile_dbname != 'LAFUERZA') {

        $id = $_GET["id"];
       
        # ASSIGNED VALUE
		$page_title = "ILOILO GLITZ AND GLAM";

		global $sroot, $profile_id, $unix3month;

		$id = substr($id, 0, strlen($id) - 10);
        $my_registration = $tblsql->get_registration($id, 0, 0, 0, $profile_id, $profile_dbname);
        $company = $tblsql->get_company($profile_comp, $profile_dbname);
	}
?>
