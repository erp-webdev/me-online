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
        $pryear = date("Y");

        if(isset($_GET['pryear']) && isset($_GET['period'])){
            $payper = $_GET['period'];
            $pryear = $_GET['pryear'];
        }

        $dtr_year = $mainsql->get_dtr_year($profile_comp);     
        $payslip_period = $mainsql->get_payslip_period($pryear, $profile_comp);          
        //var_dump($payslip_period[1]['PeriodID']);
        $payper = isset($_GET['period']) ? $_GET['period'] : $payslip_period[1]['PeriodID'] ? $payslip_period[1]['PeriodID'] : $payslip_period[0]['PeriodID'];
        
        $payslip_data = $mainsql->get_payslip_data($profile_idnum, $pryear, $payper); 
        
        $payslip_oedesc = $mainsql->get_payslip_oedesc(); 
        $payslip_oddesc = $mainsql->get_payslip_oddesc(); 
        
        //LOANS
        // $payslip_loans = $mainsql->get_payslip_loan($profile_idnum);
        $payslip_loans = $mainsql->get_payslip_loan2($profile_idnum, $pryear, $payper);
        
        //EARNED TAXABLE
        $payslip_oemaster1 = $mainsql->get_payslip_oemaster($profile_idnum, $pryear, $payper, 1);         
        //EARNED NON-TAXABLE
        $payslip_oemaster2 = $mainsql->get_payslip_oemaster($profile_idnum, $pryear, $payper);  
        
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
        $payslip_getetaxable = $mainsql->get_payslip_allownacevalue($profile_idnum, $arrot, $pryear, $payper);   
        //EARNED NON-TAXABLE
        $payslip_getenontaxable = $mainsql->get_payslip_allownacevalue($profile_idnum, $arron, $pryear, $payper);       
        //DEDUCTION
        $payslip_getdeduction = $mainsql->get_payslip_allownacevalue($profile_idnum, $arrod, $pryear, $payper); 
        
        $payslip_earn = $mainsql->get_payslip_otherearn($profile_idnum, $pryear, $payper, 1); 
        $payslip_earn2 = $mainsql->get_payslip_otherearn($profile_idnum, $pryear, $payper, 0); 
        $payslip_deduct = $mainsql->get_payslip_otherdeduct($profile_idnum, $pryear, $payper); 
        
        //DEDUCT TAXABLE
        $payslip_odmaster = $mainsql->get_payslip_odmaster($profile_idnum, $pryear, $payper); 
        
        $payslip_otmaster = $mainsql->get_payslip_otmaster($profile_idnum, $pryear, $payper); 
                
        $leave_data = $mainsql->get_leave();

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>