<?php

        $id = $_GET["id"];
        if (!$id) :
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/activity'</script>";
        endif;

        # ASSIGNED VALUE
		$page_title = "QR Code";

		global $sroot, $profile_id, $unix3month;

		// $table_draw_query = "SELECT * FROM SUBSIDIARY.DBO.TABLEDRAW$ WHERE EmpID = '$profile_id' AND DBNAME = '$profile_dbname'";
		// $table_draw = $mainsql->get_row($table_draw_query);
		// $dept_name = $table_draw[0]['TABLE ASSIGNMENT'];
		// $table = $table_draw[0]['TABLE NUMBER'];
	
		$sql = "SELECT * 
			FROM SUBSIDIARY.DBO.HREventRegistry r
			LEFT JOIN SUBSIDIARY.DBO.HRActivity b ON r.registry_activityid = b.activity_id
			WHERE HASHBYTES('SHA1', b.activity_id + 'qr' + r.registry_uid)='".$id."'";
		$result = $mainsql->get_row($sql);
		var_dump($result); exit;
		// $emp_dept_query = "SELECT DeptDesc FROM $profile_dbname.DBO.HRDepartment where DeptID = '$dept_id'";
		// $emp_dept = $mainsql->get_row($emp_dept_query);
		// $emp_dept = $emp_dept[0]['DeptDesc'];


?>
