<?php
	
	if ($logged == 1) {

		# PAGINATION
		$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
		$start = NUM_ROWS * ($page - 1);
		
		//*********************** MAIN CODE START **********************\\
			
		# ASSIGNED VALUE
		$page_title = "Payslip";	
		
		//***********************  MAIN CODE END  **********************\\
		
		global $sroot, $profile_id, $unix3month;
        
        $val = array();
        $value = array('memo_title' => 'Hello1', 'memo_attach' => 'hello.pdf', 'memo_user' => 1, 'memo_date' => '10/26/1981');

        $knum = 0;
        foreach ($value as $key => $value) :        
            $val[$knum]['field_name'] = $key;        
            $val[$knum]['field_value'] = $value;        
            $val[$knum]['field_type'] = 'SQLVARCHAR';      
            $val[$knum]['field_isoutput'] = false;
            $val[$knum]['field_isnull'] = false;
            $val[$knum]['field_maxlen'] = 512;
            $knum++;
        endforeach;
        
        var_dump($val);

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>