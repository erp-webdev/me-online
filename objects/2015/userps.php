<?php
	
	if ($logged == 1) {

        $empid = $_GET['id'] ? $_GET['id'] : $profile_hash;

		# PAGINATION
		$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
		$start = NUM_ROWS * ($page - 1);
		
		//*********************** MAIN CODE START **********************\\
			
		# ASSIGNED VALUE
		$page_title = "Payslip";	
		
		//***********************  MAIN CODE END  **********************\\
		
		global $sroot, $profile_id, $unix3month;
        
        $emp_data = $register->get_member_by_hash($empid);  
        
        $ups_idnum = $_GET['id'] ? $emp_data[0]['EmpID'] : $profile_idnum;
        $ups_comp = $_GET['id'] ? $emp_data[0]['CompanyID'] : $profile_comp;
        $ups_full = $_GET['id'] ? $emp_data[0]['FName'].' '.$emp_data[0]['LName'] : $profile_full;
        $ups_dept = $_GET['id'] ? $emp_data[0]['DeptDesc'] : $profile_dept;		
        $ups_sss = $_GET['id'] ? $emp_data[0]['SSSNbr'] : $profile_sss;		
        $ups_tin = $_GET['id'] ? $emp_data[0]['TINNbr'] : $profile_tin;	
        $ups_acctnum = $_GET['id'] ? $emp_data[0]['AccountNo'] : $profile_acctnum;	
            
        $usertax = $register->get_memtax($emp_data[0]['TaxID']);
        $ups_taxdesc = $_GET['id'] ? $usertax[0]['Description'] : $profile_taxdesc;	

        $dtr_year = $mainsql->get_dtr_year($ups_comp);     
        $payslip_period = $mainsql->get_payslip_period(date("Y"), $ups_comp);          
        //var_dump($payslip_period[1]['PeriodID']);
        
        $payper = $payslip_period[1]['PeriodID'] ? $payslip_period[1]['PeriodID'] : $payslip_period[0]['PeriodID'];
        
        $payslip_data = $mainsql->get_payslip_data($ups_idnum, date("Y"), $payper); 
        
        $payslip_oedesc = $mainsql->get_payslip_oedesc(); 
        $payslip_oddesc = $mainsql->get_payslip_oddesc(); 
        
        //LOANS
        $payslip_loans = $mainsql->get_payslip_loan($ups_idnum);
        
        //EARNED TAXABLE
        $payslip_oemaster1 = $mainsql->get_payslip_oemaster($ups_idnum, date("Y"), $payper, 1);         
        //EARNED NON-TAXABLE
        $payslip_oemaster2 = $mainsql->get_payslip_oemaster($ups_idnum, date("Y"), $payper);  
        
        //EARNED TAXABLE
        $payslip_etaxable = $mainsql->get_payslip_allowancetype(2);         
        //EARNED NON-TAXABLE
        $payslip_enontaxable = $mainsql->get_payslip_allowancetype(1);         
        //DEDUCTION
        $payslip_deduction = $mainsql->get_payslip_allowancetype(3);         

        $i = 0;
        foreach ($payslip_etaxable as $key => $value) :            
            $iot[$i] = 'B.'.$value['OExtID'];
            $i++;  
        endforeach;
        $arrot = implode(',', $iot);

        $i = 0;
        foreach ($payslip_enontaxable as $key => $value) :            
            $ion[$i] = 'B.'.$value['OExtID'];
            $i++;  
        endforeach;
        $arron = implode(',', $ion);

        $i = 0;
        foreach ($payslip_deduction as $key => $value) :            
            $iod[$i] = 'B.'.$value['OExtID'];
            $i++;  
        endforeach;
        $arrod = implode(',', $iod);

        //var_dump($arrod);

        //EARNED TAXABLE
        $payslip_getetaxable = $mainsql->get_payslip_allownacevalue($ups_idnum, $arrot, date("Y"), $payper);   
        //EARNED NON-TAXABLE
        $payslip_getenontaxable = $mainsql->get_payslip_allownacevalue($ups_idnum, $arron, date("Y"), $payper);       
        //DEDUCTION
        $payslip_getdeduction = $mainsql->get_payslip_allownacevalue($ups_idnum, $arrod, date("Y"), $payper); 
        
        $payslip_earn = $mainsql->get_payslip_otherearn($ups_idnum, date("Y"), $payper, 1); 
        $payslip_earn2 = $mainsql->get_payslip_otherearn($ups_idnum, date("Y"), $payper, 0); 
        $payslip_deduct = $mainsql->get_payslip_otherdeduct($ups_idnum, date("Y"), $payper); 
        
        //DEDUCT TAXABLE
        $payslip_odmaster = $mainsql->get_payslip_odmaster($ups_idnum, date("Y"), $payper); 
        
        $payslip_otmaster = $mainsql->get_payslip_otmaster($ups_idnum, date("Y"), $payper); 
                
        $leave_data = $mainsql->get_leave();

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>