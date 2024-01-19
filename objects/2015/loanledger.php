<?php
	
	if ($logged == 1) {

		# PAGINATION
		$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
		$start = NUM_ROWS * ($page - 1);
		
		//*********************** MAIN CODE START **********************\\
			
		# ASSIGNED VALUE
		$page_title = "Loan Ledger";	
		
		//***********************  MAIN CODE END  **********************\\
		
		global $sroot, $profile_id, $unix3month;

        $loanledger_data = $mainsql->get_emploan($profile_id);
        $loan_data = $mainsql->get_loandata($loanledger_data[0]['ApplyTo']);
        
        $payslip_oddesc = $mainsql->get_payslip_oddesc();

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>