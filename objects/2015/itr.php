<?php
if ($logged == 1 && $profile_level != 8) {
	$lname = $userdata[0]['LName'];
	$tin = $userdata[0]['TINNbr'];

	$tin_ = str_split(substr(preg_replace('/[^A-Za-z0-9]/', '', $tin), 0, 9), 3);
	$tin = implode('', $tin_);
	$year = date('Y');
	$prevyear = $year - 1;

	$filename = "$lname" . _ . "$tin" . "0000_1231" . $prevyear . ".pdf";

	$itr_file = DOCUMENT . '/uploads/itr/' . $year . '/' . $profile_dbname . '/' . $profile_idnum . '.pdf';
	$hashed_filename = $filename;
} else {
	echo "<script language='javascript' type='text/javascript'>window.location.href='" . WEB . "/login'</script>";
}

?>