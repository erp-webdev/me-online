<?php   
		
    if ($logged == 1) :
	        
        //*********************** MAIN CODE START **********************\\
			
		# ASSIGNED VALUE
        $empid = $_GET['id'] ? $_GET['id'] : $profile_hash;
        $edit = $_GET['edit'];
		$page_title = $edit ? "Update Profile" : "My Profile";	
		
		//***********************  MAIN CODE END  **********************\\
        
        global $sroot;

        $emp_data = $register->get_upmember_by_hash($empid);      
        //var_dump($emp_data[0]['EmpID']);
        $family_data = $register->get_upfamily_data($emp_data[0]['EmpID']);        
        if (!$family_data) :
            $family_data = $register->get_family_data($emp_data[0]['EmpID']);        
        endif;
        $education_data = $register->get_upeducation_data($emp_data[0]['EmpID']);  
        if (!$education_data) :
            $education_data = $register->get_education_data($emp_data[0]['EmpID']);  
        endif;
        $prevwork_data = $register->get_upprevwork_data($emp_data[0]['EmpID']);
        if (!$prevwork_data) :
            $prevwork_data = $register->get_prevwork_data($emp_data[0]['EmpID']);
        endif;
        $pix_data = $mainsql->get_upimage($emp_data[0]['EmpID']);
        if (!$pix_data) :
            $pix_data = $mainsql->get_image(1, $emp_data[0]['EmpID']);
        endif;

	else :

        echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."'</script>";		

	endif;
	
?>