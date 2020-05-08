<?php 
    if ($logged == 1 && $profile_level != 8) {
		$itr_file = DOCUMENT.'/uploads/itr/2020/'.$profile_dbname.'/'.$profile_idnum.'.pdf';
		$hashed_filename = $profile_full . ' _ITR_2020' . '.pdf';
	}else{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}

 ?>