<?php include(TEMP."/header.php"); ?>

<?php 
	if($wfh_user[0]["EmpID"] == $profile_idnum && $wfh_user[0]["DBNAME"] == $profile_dbname) {
		include(TEMP."/wfh/wfh.php"); 
	}else{
		include(TEMP."/wfh/wfh_clearance.php"); 
	}

?>

<?php include(TEMP."/footer.php"); ?>
