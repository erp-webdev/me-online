<?php

	$cookiename = 'megasubs_user';

	$username = $_SESSION[$cookiename];	
    $password = $_SESSION['megasubs_password'] ? $_SESSION['megasubs_password'] : NULL;	
    $userdb = $_SESSION['megasubs_db'];	
	
	if ($username) {	        
		$redirectUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$_SESSION['login_url'] = $redirectUrl;
		$_SESSION['logout_url'] = $redirectUrl;	
		
		$checkname = $logsql->check_member($username, $password);
		
		if (!$checkname) 
		{
			$logstat = 0;		
		}
		else 
		{
			$userdata = $logsql->get_member2($username, $password, $userdb);        
			
			$logstat = 1;
			$logfname = $userdata[0]['FName'].' '.$userdata[0]['LName'];
            $lognick = $userdata[0]['FName'];
			$logname = $userdata[0]['EmpID'];
            $logpic = $userdata[0]['IMAGEPATH'];
			$userid = $userdata[0]['EmpID'];	
			$email = $userdata[0]['EmailAdd'];	
			$bday = $userdata[0]['BirthDate'];	
			$company = $userdata[0]['CompanyID'];
			$sss = $userdata[0]['SSSNbr'];		
			$tin = $userdata[0]['TINNbr'];	
			$phealth = $userdata[0]['PhilHealthNbr'];	
			$pagibig = $userdata[0]['PagibigNbr'];	
			$acctnum = $userdata[0]['AccountNo'];	
			$location = $userdata[0]['LocationID'];	
            $compressed = $userdata[0]['Compressed'];	
            
            $dbname = $userdb ? $userdb : $userdata[0]['DBNAME'];	
            
            //var_dump($userdb);
            
            $minothours = $userdata[0]['MinOTHrs'];	
            
            $usertax = $logsql->get_memtax($userdata[0]['TaxID']);
            $taxdesc = $usertax[0]['Description'];	
            
            
		}		
	}
	else
	{
		$logstat = 0;
	}

?>