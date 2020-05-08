<?php
	
	if ($logged == 1) {
        
        if ($profile_level) :

            $empid = $_GET['id'] ? $_GET['id'] : $profile_hash;
            $dbname = $_GET['db'] ? $_GET['db'] : 'SUBSIDIARY';
        
            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NUM_ROWS * ($page - 1);

            //*********************** MAIN CODE START **********************\\

            # ASSIGNED VALUE
            $page_title = "DTR Management";	

            //***********************  MAIN CODE END  **********************\\

            global $sroot, $profile_id, $unix3month;
        
            $dtr_year = $mainsql->get_dtr_year($profile_comp);          
            $yearend = strtotime(date('Y').'-12-15');
            $yearval = date('U') > $yearend ? date("Y") + 1 : date("Y");
            $dtr_period = $mainsql->get_dtr_period($yearval, $profile_comp, 1);   

            $emp_data = $register->get_member_by_hash($empid, $dbname);  
            $udtr_idnum = $_GET['id'] ? $emp_data[0]['EmpID'] : $profile_idnum;
            $udtr_comp = $_GET['id'] ? $emp_data[0]['CompanyID'] : $profile_comp;
            $udtr_full = $_GET['id'] ? $emp_data[0]['FName'].' '.$emp_data[0]['LName'] : $profile_full;
            $udtr_location = $_GET['id'] ? $emp_data[0]['LocationID'] : $profile_location;
            $udtr_minothours = $_GET['id'] ? $emp_data[0]['MinOTHrs'] : $profile_minothours;
        
            $empdata = $logsql->get_member($udtr_idnum);
            $profile_location = $empdata[0]['LocationID']; 

            //var_dump($emp_data);
        
            $dtr_year = $mainsql->get_dtr_year($udtr_comp, $dbname);     
            $dtr_period = $mainsql->get_dtr_period(date("Y"), $udtr_comp, 1, $dbname);          

            //var_dump($dtr_period);

            $expfrom = explode(" ", $dtr_period[0]['PeriodFrom']);
            $expto = explode(" ", $dtr_period[0]['PeriodTo']);

            $dfrom = strtotime($expfrom[0].' '.$expfrom[1].' '.$expfrom[2].' 00:00:00');
            $dto = strtotime($expto[0].' '.$expto[1].' '.$expto[2].' 23:59:59');
            $posted = $dtr_period[0]['AttPost'];

            if ($posted == 0) :

                while($dfrom < $dto + 86400) : 

                    $_POST['strEMPID'] = $udtr_idnum;            
                    $_POST['dteDTRDate'] = date("m/d/Y", $dfrom);
                    $_POST['OVERWRITE'] = 0;
                    $_POST['STATUS'] = 'INITIAL'; 
                    $_POST['intFINALPAY'] = 0;             


                    $daydtr = date('j', $dfrom);
                    $month15 = date('U', strtotime(date('Y-m-15')));                        
                    $lastyear = date('Y', strtotime("-1 month"));
                    $lastmonth = date('m', strtotime("-1 month"));
                    $lastday = date('t', strtotime("-1 month"));
                    $month15l = date('U', strtotime(date($lastyear.'-'.$lastmonth.'-15')));   
                    $monthlast = date('U', strtotime(date($lastyear.'-'.$lastmonth.'-'.$lastday)));
            
                    if ($daynow >= 3 && $daynow < 18) :
                        $lastpoint = $monthlast;
                    else :
                        if ($daynow >= 1 && $daynow < 3) :
                            $lastpoint = $month15l;
                        else :
                            $lastpoint = $month15;
                        endif;
                    endif;  

                    // temporary disabled: jan 31,2020 kevs
                    /*
                    if ($dfrom > $lastpoint) :
                        $dtr_calculate = $mainsql->dtr_action($_POST, 'calculate');
                    endif;   
                    */             

                    // $dtr_calculate = $mainsql->dtr_action($_POST, 'calculate');

                    //var_dump($dfrom);
                    

                    $dfrom = $dfrom + 86400;
                endwhile;     
            endif;

            $dtr_data = $mainsql->get_dtr_data($udtr_idnum, date("m/d/Y", strtotime($expfrom[0].' '.$expfrom[1].' '.$expfrom[2].' 00:00:00')), date("m/d/Y", strtotime($expto[0].' '.$expto[1].' '.$expto[2].' 23:59:59')), $udtr_comp, $dbname);  
        
        else :
        
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";    
        
        endif;
        
	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>