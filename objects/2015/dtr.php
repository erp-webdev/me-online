<?php

	if ($logged == 1) {

		# PAGINATION
		$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
		$start = NUM_ROWS * ($page - 1);

		//*********************** MAIN CODE START **********************\\

		# ASSIGNED VALUE
		$page_title = "Daily Time Record";

		//***********************  MAIN CODE END  **********************\\

		global $sroot, $profile_id, $unix3month;

        $yearend = strtotime(date('Y').'-12-15');
        $yearval = date('U') > $yearend ? date("Y") + 1 : date("Y");
        $dtr_year = $mainsql->get_dtr_year($profile_comp);

        if(isset($_GET['pryear']) && isset($_GET['period'])){
            $dtr_period = $mainsql->get_dtr_period_by_id($_GET['pryear'], $profile_comp, $_GET['period']);
        }else{
            $dtr_period = $mainsql->get_dtr_period($yearval, $profile_comp, 1);
        }
        
        //var_dump($dtr_period);

        $cleanfrom = str_replace("  ", " ", $dtr_period[0]['PeriodFrom']);
        $cleanto = str_replace("  ", " ", $dtr_period[0]['PeriodTo']);


        $expfrom = explode(" ", $cleanfrom);
        $expto = explode(" ", $cleanto);

        $dfrom = strtotime($expfrom[0].' '.$expfrom[1].' '.$expfrom[2].' 00:00:00');
        $dto = strtotime($expto[0].' '.$expto[1].' '.$expto[2].' 23:59:59');
        $posted = $dtr_period[0]['AttPost'];
        $daynow = date('j');

        //var_dump($dtr_period[0]['PeriodFrom'].' '.$dtr_period[0]['PeriodTo'].' '.$posted);

        if ($posted == 0) :

            while($dfrom < $dto + 86400) :

                $_POST['strEMPID'] = $profile_idnum;
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

                if ($dfrom > $lastpoint) :
                    $dtr_calculate = $mainsql->dtr_action($_POST, 'calculate');
                endif;

                //$dtr_calculate = $mainsql->dtr_action($_POST, 'calculate');

                //var_dump($dfrom);

                $dfrom = $dfrom + 86400;
            endwhile;
        endif;

        //$dtr_data = $mainsql->get_dtr_data($profile_idnum, date("m/d/Y", strtotime($dtr_period[0])), date("m/d/Y", strtotime($dtr_period[1])));

        $dtr_data = $mainsql->get_dtr_data($profile_idnum, date("m/d/Y", strtotime($expfrom[0].' '.$expfrom[1].' '.$expfrom[2].' 00:00:00')), date("m/d/Y", strtotime($expto[0].' '.$expto[1].' '.$expto[2].' 23:59:59')), $profile_comp);  

        //var_dump($dtr_data);

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}

?>
