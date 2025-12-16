<?php

if ($logged == 1 && $profile_dbname != 'ECINEMA' && $profile_dbname != 'EPARKVIEW' && $profile_dbname != 'NEWTOWN' && $profile_dbname != 'LAFUERZA') {

        $id = $_GET["id"];
        if (!$id) :
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/activity'</script>";
        endif;

        # ASSIGNED VALUE
		$page_title = "QR Code";

		global $sroot, $profile_id, $unix3month;

		$id = substr($id, 0, strlen($id) - 10);
        $my_registration = $tblsql->get_registration($id, 0, 0, 0, $profile_id, $profile_dbname);
		
		// $table_draw_query = "SELECT * FROM SUBSIDIARY.DBO.TABLEDRAW$ WHERE EmpID = '$profile_id' AND DBNAME = '$profile_dbname'";
		// $table_draw = $mainsql->get_row($table_draw_query);
		// $dept_name = $table_draw[0]['TABLE ASSIGNMENT'];
		// $table = $table_draw[0]['TABLE NUMBER'];

		// $emp_dept_query = "SELECT DeptDesc FROM $profile_dbname.DBO.HRDepartment where DeptID = '$dept_id'";
		// $emp_dept = $mainsql->get_row($emp_dept_query);
		// $emp_dept = $emp_dept[0]['DeptDesc'];

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
?>
