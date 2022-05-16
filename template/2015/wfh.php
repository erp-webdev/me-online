<?php include(TEMP."/header.php"); ?>

<?php 
	if($wfh_user[0]["EmpID"] == $profile_idnum && $wfh_user[0]["DBNAME"] == $profile_dbname) {
		include(TEMP."/wfh/wfh.php"); 
	}else{
		// TODO: CHECK AND SETUP APPROVERS
		// Approver 1: Company Nurse
		// Approver 2: Immediate Head
		include(TEMP."/wfh/wfh_clearance.php"); 
	}

?>

<?php include(TEMP."/footer.php"); ?>
