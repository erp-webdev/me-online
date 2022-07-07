<?php include(TEMP."/header.php"); ?>

<?php  
var_dump($rwh_app);
if($rwh_app[0]["EmpID"] == $profile_idnum) : ?>

<?php	include(TEMP.'/wfh/wfh.php'); ?>
	
<?php endif; ?>

<?php include(TEMP."/footer.php"); ?>
