<div id="myDivToPrint3">
	<div style="text-align: center; padding-top: 10px;">

		<?php $send_pdf = $_POST['send'] == 'true' ? true : false; ?>
		<?php if ($coe[0]["company"] == 'GLOBAL01') { ?>
			<p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/gl_coe.png"/></p>
		<?php } elseif ($coe[0]["company"] == 'LGMI01') {?>
			<p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/lgmi_coe.png"/></p>
		<?php } elseif ($coe[0]["company"] == 'SIRUS') {?>
			<p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/sirus_coe.png"/></p>
		<?php } elseif ($coe[0]["company"] == 'MEGA01') {?>
			<p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/mega_coe.png"/></p>
		<?php } elseif ($coe[0]["company"] == 'TOWN01') {?>
			<p><img style="width: <?php echo $send_pdf ? '200px' : '250px'; ?>;" src="<?php echo IMG_WEB; ?>/townsquare_coe.png"/></p>
		<?php } elseif ($coe[0]["company"] == 'NCCAI') {?>
			<!--  -->
			<p><img style="width: <?php echo $send_pdf ? '200px' : '250px'; ?>;" src="<?php echo IMG_WEB; ?>/nccai_coe.png"/></p>
		<?php } elseif ($coe[0]["company"] == 'FCI01') {?>
			<!-- NOT INCLUDED -->
			<p><img style="width: <?php echo $send_pdf ? '100px' : '150px'; ?>;" src="<?php echo IMG_WEB; ?>/firstcentro_coe.png"/></p>
		<?php } elseif ($coe[0]["company"] == 'CITYLINK01') {?>
			<p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/citylink_coe.png"/></p>
		<?php } elseif ($coe[0]["company"] == 'ECC02') {?>
			<!--  -->
			<p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/ecinema_coe.png"/></p>
		<?php } elseif ($coe[0]["company"] == 'ECOC01') {?>
			<p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/ecoc_coe.png"/></p>
		<?php } elseif ($coe[0]["company"] == 'ERA01') {?>
			<p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/erex_coe.png"/></p>
		<?php } elseif ($coe[0]["company"] == 'LUCK01') {?>
			<p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/lctm_coe.png"/></p>
		<?php } elseif ($coe[0]["company"] == 'LFI01') {?>
			<!--  -->
			<p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/lafuerza_coe.png"/></p>
		<?php } elseif ($coe[0]["company"] == 'MLI01') {?>
			<p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/mli_coe.png"/></p>
		<?php } elseif ($coe[0]["company"] == 'MCTI') {?>
			<p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/mcti_coe.png"/></p>
		<?php } elseif ($coe[0]["company"] == 'SUNT01') {?>
			<p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/suntrust_coe.png"/></p>
		<?php } elseif ($coe[0]["company"] == 'ASIAAPMI') {?>
			<p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/asiaapmi_coe.png"/></p>
		<?php } else {?>
			<p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/blank_coe.png"/></p>
		<?php } ?>

	<?php
	//R&F to Supervisor
	$rfs = array(
		'RF','RF II','SRF','SRF II','AS','AS II','AS III','S','S II','S III',
		'SS','SS II','SS III',
		'RF','R001','R002','R003','R004','S005','S006','S007','S008','S','SS',
		
	);
	$man = array('AM','AM II','AM III','MGR-A','M','M II','M III',
				'SM','SM II','SM III', //end of megaworld ranks);
				'M009','M010','M011','M012','M','M-TTTI','SM','SM - TTTI','D013','D014',
				); // end of GL RANKS
	
	$avp = array('AVP','AVP-TTTI', 'SAVP');
	//vp & up - Ms. Lourdes
	$vpup = array(
		'FVP', //end of GL RANKS
		'VP', 'EVP','SEVP','SVP','FVP','COO','D015','D016' // end of MEGA RANKS
	);

	$companies = [

		'GLOBAL01' => 'Makati City',
		'LGMI01' => 'Makati City',
		'MEGA01' => '25th Floor, Alliance Global Tower 36th Street cor. 11th Avenu, Uptown Bonifacio Taguig',
		'TOWN01' => '3/F Forbestown Information Center, Rizal Drive corner 26th Street, Bonifacio Global City, Taguig',
		'SUNT01' => '26th Floor, Alliance Global Tower, 36th Street cor 11th Avenue, Uptown Bonifacio',
		'NCCAI' => 'Star Cruises Centre, 100 Andrews Avenue, Newport City, Vlllamor Air Base, Pasay City, Metro Manila',
		'MLI01' => '19/F Alliance Global Tower, 36th Street corner 11th Avenue, Uptown Bonifacio, Taguig City, 1634',
		'MCTI' => 'Capital Boulevard, Barangay Sto. Niño, City of San Fernando, Pampanga',
		'LUCK01' => '5F Lucky Chinatown Mall, Reina Regente St. corner Dela Reina St., Brgy. 293, Zone 28, Binondo, Manila',
		'ERA01' => '30th Floor, Alliance Global Tower, 36th Street cor 11th Avenue, Uptown Bonifacio, Taguig City',
		'ECOC01' => 'GF The World Center Building, 330 Senator Gil Puyat Avenue, Makati City',
		'CITYLINK01' => 'Ground Floor, McKinley Parking Building, Service Road 2, Mckinley Town Center, Fort Bonifacio Taguig',
		'SIRUS' => 'Lot 28-7 Along M.A Roxas Highway, Clark Freeport Zone',
		'ASIAAPMI' => '24F ALLIANCE GLOBAL TOWER 36TH STREET CORNER 11 AVENUE UPTOWN BONIFACIO TAGUIG CITY'
	];

	function moneyformat($x)
	{
		return number_format($x,2,'.',',');
	}
	function get_approver($company_id)
	{
	$dbapp = ['name' => '', 'position' => '', 'db_name' =>''];
	switch(true)
		{
			case in_array($company_id, ['GLOBAL01']) :
				$dbapp['name'] = 'ARLENE A. BRANCO';
				$dbapp['position'] = 'PAYROLL MANAGER';
				$dbapp['db_name'] = 'GL';
			break;
			case in_array($company_id, ['LGMI01']) :
				$dbapp['name'] = 'ARLENE A. BRANCO';
				$dbapp['position'] = 'PAYROLL MANAGER';
				$dbapp['db_name'] = 'GL';
			break;
			case in_array($company_id, ['MEGA01', 'MEGAWORLD']) :
				   $dbapp['name'] = 'ARLENE A. BRANCO';
				$dbapp['position'] = 'PAYROLL MANAGER';
				$dbapp['db_name'] = 'GL';
			break;
			case in_array($company_id, ['LCCI']) :
				   $dbapp['name'] = 'ARLENE A. BRANCO';
				$dbapp['position'] = 'PAYROLL MANAGER';
				$dbapp['db_name'] = 'GL';
			break;
			case in_array($company_id, ['LCTM']) :
				   $dbapp['name'] = 'ARLENE A. BRANCO';
				$dbapp['position'] = 'PAYROLL MANAGER';
				$dbapp['db_name'] = 'GL';
			break;
			case in_array($company_id, ['LAFUERZA']) :
				   $dbapp['name'] = 'ARLENE A. BRANCO';
				$dbapp['position'] = 'PAYROLL MANAGER';
				$dbapp['db_name'] = 'GL';
			break;
			case in_array($company_id, ['MLI']) :
				$dbapp['name'] = 'ARLENE A. BRANCO';
				$dbapp['position'] = 'PAYROLL MANAGER';
				$dbapp['db_name'] = 'GL';
			break;
			case in_array($company_id, ['TDI']) :
				$dbapp['name'] = 'ARLENE A. BRANCO';
				$dbapp['position'] = 'PAYROLL MANAGER';
				$dbapp['db_name'] = 'GL';
			break;
			case in_array($company_id, ['ECOC']) :
				$dbapp['name'] = 'ARLENE A. BRANCO';
				$dbapp['position'] = 'PAYROLL MANAGER';
				$dbapp['db_name'] = 'GL';
			break;
			case in_array($company_id, ['SUNTRUST']) :
				$dbapp['name'] = 'ARLENE A. BRANCO';
				$dbapp['position'] = 'PAYROLL MANAGER';
				$dbapp['db_name'] = 'GL';
			break;
			case in_array($company_id, ['EREX']) :
				$dbapp['name'] = 'ARLENE A. BRANCO';
				$dbapp['position'] = 'PAYROLL MANAGER';
				$dbapp['db_name'] = 'GL';
			break;
			case in_array($company_id, ['CITYLINK']) :
				$dbapp['name'] = 'ARLENE A. BRANCO';
				$dbapp['position'] = 'PAYROLL MANAGER';
				$dbapp['db_name'] = 'GL';
			break;
			case in_array($company_id, ['LUCK01']) :
				$dbapp['name'] = 'ARLENE A. BRANCO';
				$dbapp['position'] = 'PAYROLL MANAGER';
				$dbapp['db_name'] = 'GL';
			break;
			case in_array($company_id, ['NCCAI']) :
				$dbapp['name'] = 'ARLENE A. BRANCO';
				$dbapp['position'] = 'PAYROLL MANAGER';
				$dbapp['db_name'] = 'GL';
			break;
			case $company_id == 'GLOBALHOTEL' :
				$dbapp['name'] = 'Bernadette Roxas';
				$dbapp['position'] = 'HR Director';
				$dbapp['db_name'] = 'GL';
			break;
			case in_array($company_id, ['NEWTOWN']) :
				$dbapp['name'] = 'ARLENE A. BRANCO';
				$dbapp['position'] = 'PAYROLL MANAGER';
				$dbapp['db_name'] = 'GL';
			break;
			case in_array($company_id, ['MCTI']) :
				$dbapp['name'] = 'ARLENE A. BRANCO';
				$dbapp['position'] = 'PAYROLL MANAGER';
				$dbapp['db_name'] = 'GL';
			break;
			case in_array($company_id, ['MARKETING']) :
				$dbapp['name'] = 'ARLENE A. BRANCO';
				$dbapp['position'] = 'PAYROLL MANAGER';
				$dbapp['db_name'] = 'GL';
			break;
			case in_array($company_id, ['FIRSTCENTRO']) :
				$dbapp['name'] = 'ARLENE A. BRANCO';
				$dbapp['position'] = 'PAYROLL MANAGER';
				$dbapp['db_name'] = 'GL';
			break;
			default:
			break;
		}

		return (object)$dbapp;
	}

	function place_text($str, $x, $y, $style)
	{
		$x .= 'mm';
		$y .= 'mm';
	   echo "<span style='position:absolute; top: $y; left: $x; $style'>$str</span>";
	}
	
	function strip_dash($str)
	{
		return str_replace('-', '', $str);
	}
	
	function strip_whitespace($str)
	{
		return str_replace(' ', '', $str);    
	}
	
	function clean_str($str)
	{
		$str = strip_dash($str);
		$str = strip_whitespace($str);
		return $str;
	}

	

	if ($coe[0]["type"] == "SSSCERT") {
	?>
	<body>
	<div style='margin-top: 45px; text-align: center; font-size: 35px; text-decoration: underline; margin-bottom: 50px;'><b>CERTIFICATE</div>
	<p style='text-align: justify'>This is to certify that <?php echo $emp_info[0]["FullName"]  ?> with SSS # <?php echo $emp_info[0]["CompSSSNbr"]  ?> has remitted the following
            SSS PREMIUM Contribution of Mr./Ms. <?php echo $emp_info[0]["FullName"]  ?> with SSS # <?php echo $emp_info[0]["SSSNbr"]  ?>.</p><br>	
	<!-- Start Print Alignment -->
	<table>
		<tr style='width: 100%' >
    	    <td style='width:125px;text-align:center;height:70px'>   APPLICATION <br> MONTH     </td>
    	    <td style='width:125px;text-align:center;height:70px'>   SSS <br> RECIEPT NO.       </td>
    	    <td style='width:100px;text-align:center;height:70px'>   DATE <br> REMITTED         </td>
    	    <td style='width:100px;text-align:center;height:70px'>   EMPLOYEE <br> SHARE        </td>
    	    <td style='width:100px;text-align:center;height:70px'>   EMPLOYER <br> SHARE        </td>
    	    <td style='width:100px;text-align:center;height:70px'>   TOTAL                      </td>
    	</tr>

		<?php
				$approver = get_approver($emp_info[0]["CompanyID"]);
				$query = "
			SELECT 	SSSMonth,
					SSSYear,
					ReceiptNo,
					ReceiptDate,
					SSSEmployee,
					SSSEmployer,
					EndDate 
			FROM dbo.SSSRemit 
			WHERE 	EmpID='".$emp_id."' 
			AND 	EndDate BETWEEN '". date('m/d/Y',strtotime($coe[0]["leave_from"]))."' 
					AND '".date('m/d/Y',strtotime($coe[0]["leave_to"]))."' 
			ORDER BY EndDate ASC";

				$employees = $mainsql->get_row($query);
				$total=0;
				$totalemployer=0;
				$totalemployee=0;
				 
				foreach($employees as $r)
				{ 
					?>
						<tr>
							<td align='center'> <? echo date('F',strtotime($r['EndDate'])); ?> </td>
							<td align='center'> <? echo $r['ReceiptNo']; ?></td>
							<td align='center'> <? echo date('m/d/Y',strtotime($r['ReceiptDate'])); ?></td>
							<td align='center'> <? echo moneyformat($r['SSSEmployee']); ?></td>
							<td align='center'> <? echo moneyformat($r['SSSEmployer']); ?></td>
							<td align='center'> <? echo moneyformat($r['SSSEmployee']+$r['SSSEmployer']); ?></td>
						</tr>
						<?php
					$total          +=       $r['SSSEmployee'] + $r['SSSEmployer'];
					$totalemployee  +=       $r['SSSEmployee'];
					$totalemployer  +=       $r['SSSEmployer'];
				}
				
				echo	"<tr>
							<td align='center' style='font-weight:bold'>TOTAL</td>
							<td> </td>
							<td></td>
							<td style='text-decoration: underline overline; font-weight:bold' align='center'>".moneyformat($totalemployee)."</td>
							<td style='text-decoration: underline overline; font-weight:bold' align='center'>".moneyformat($totalemployer)."</td>
							<td style='text-decoration: underline overline; font-weight:bold' align='center'>".moneyformat($total)."</td>
						</tr>";
				
				echo	"</table> <br> <br><br> <br>";
				echo	"<table style='width:100%'>";
				
				echo	"</table>";
				echo " <table style='width:100%'> ";
				switch(strtoupper($emp_info[0]["CompanyID"]))
				{
					case 'ASIAAPMI':
				        echo ' <tr>
				                        <td colspan="2" align="left">Prepared by:</td>
				                    </tr>
				                    <tr>
				                        <td colspan="2" style="text-align:left;font-weight:bold;height: 50px;vertical-align: bottom;">Jeriza Mae V. Sioco</td>
				                    <tr>
				                        <td colspan="2" align="left">PAYROLL MANAGER</td>
				                    </tr>';
				    break;
					
				    case 'GLOBAL01':
				        echo ' <tr>
				                        <td colspan="2" align="center">Prepared by:</td>
				                        <td colspan="2" align="center">Checked by:</td>
				                    </tr>
				                    <tr>
				                        <td colspan="2" style="text-align:center;font-weight:bold;height: 10px;vertical-align: bottom;">Jeriza Mae V. Sioco</td>
				                        <td colspan="2" style="text-align:center;font-weight:bold;vertical-align: bottom;">Arlene A. Branco</td>
				                    <tr>
				                        <td colspan="2" align="center">PAYROLL ANALYST</td>
				                        <td colspan="2" align="center">PAYROLL MANAGER</td>
				                    </tr>';
				    break;
					
				    case 'LGMI01':
				        echo ' <tr>
				                        <td colspan="2" align="center">Prepared by:</td>
				                        <td colspan="2" align="center">Checked by:</td>
				                    </tr>
				                    <tr>
				                        <td colspan="2" style="text-align:center;font-weight:bold;height: 50px;vertical-align: bottom;">Mae Hazel B. Anastacio</td>
				                        <td colspan="2" style="text-align:center;font-weight:bold;vertical-align: bottom;">Arlene A. Branco</td>
				                    <tr>
				                        <td colspan="2" align="center">PAYROLL ANALYST</td>
				                        <td colspan="2" align="center">PAYROLL MANAGER</td>
				                    </tr>';
				    break;
					
				    case 'MEGA01':
				        echo '
				                    <tr>
				                        <td colspan="2" align="center">Prepared by:</td>
				                        <td colspan="2" align="center">Certified by:</td>
				                    </tr>
				                    <tr>
				                        <td colspan="2" style="text-align:center;font-weight:bold;height: 50px;vertical-align: bottom; width:350px">'.$_SESSION['ipay_users'].'</td>
				                        <td colspan="2" style="text-align:center;font-weight:bold;vertical-align: bottom;">'.strtoupper('Marilou C. GuariÑa').'</td>
				                    </tr>
				                    <tr>
				                        <td colspan="2" align="center">PAYROLL ASSOCIATE</td>
				                        <td colspan="2" align="center">ASSISTANT VICE PRESIDENT</td>
				                    </tr>';
				    break;
					
				    case 'LUCK01':
				        echo ' <tr>
				                        <td colspan="2" align="center">Prepared by:</td>
				                        <td colspan="2" align="center">Certified by:</td>
				                    </tr>
				                    <tr>
				                        <td colspan="2" style="text-align:center;font-weight:bold;height: 50px;vertical-align: bottom; width:350px">'.$_SESSION['ipay_users'].'</td>
				                        <td colspan="2" style="text-align:center;font-weight:bold;vertical-align: bottom;">'.strtoupper('Marilou C. GuariÑa').'</td>
				                    </tr>
				                    <tr>
				                        <td colspan="2" align="center">PAYROLL ASSOCIATE</td>
				                        <td colspan="2" align="center">ASSISTANT VICE PRESIDENT</td>
				                    </tr>';
				    break;
					
				    case 'MLI01':
				        echo ' <tr>
				                        <td colspan="2" align="center">Prepared by:</td>
				                        <td colspan="2" align="center">Certified by:</td>
				                    </tr>
				                    <tr>
				                        <td colspan="2" style="text-align:center;font-weight:bold;height: 50px;vertical-align: bottom; width:350px">'.$_SESSION['ipay_users'].'</td>
				                        <td colspan="2" style="text-align:center;font-weight:bold;vertical-align: bottom;">'.strtoupper('Marilou C. GuariÑa').'</td>
				                    </tr>
				                    <tr>
				                        <td colspan="2" align="center">PAYROLL ASSOCIATE</td>
				                        <td colspan="2" align="center">ASSISTANT VICE PRESIDENT</td>
				                    </tr>';
				    break;
					
				    case 'TDI':
				        echo '<tr>
				                        <td colspan="2" align="center">Prepared by:</td>
				                        <td colspan="2" align="center">Certified by:</td>
				                    </tr>
				                    <tr>
				                        <td colspan="2" align="center">Sonia O. Rodriguez</td>
				                        <td colspan="2" align="center">Marilou C. Guarina</td>
				                    </tr>';
				    break;
					
				    case 'ECOC':
				       echo '<tr>
				                        <td colspan="2" align="center">Prepared by:</td>
				                        <td colspan="2" align="center">Certified by:</td>
				                    </tr>
				                    <tr>
				                        <td colspan="2" align="center">Sonia O. Rodriguez</td>
				                        <td colspan="2" align="center">Marilou C. Guarina</td>
				                    </tr>';
				    break;
					
				    case 'SUNTRUST':
				        echo '<tr>
				                        <td colspan="2" align="center">Prepared by:</td>
				                        <td colspan="2" align="center">Certified by:</td>
				                    </tr>
				                    <tr>
				                        <td colspan="2" align="center">Sonia O. Rodriguez</td>
				                        <td colspan="2" align="center">Marilou C. Guarina</td>
				                    </tr>';
				    break;
					
				    case 'EREX':
				        echo '<tr>
				                        <td colspan="2" align="center">Prepared by:</td>
				                        <td colspan="2" align="center">Certified by:</td>
				                    </tr>
				                    <tr>
				                        <td colspan="2" align="center">Sonia O. Rodriguez</td>
				                        <td colspan="2" align="center">Marilou C. Guarina</td>
				                    </tr>';
				    break;
					
				    case 'CITYLINK':
				        echo '<tr>
				                        <td colspan="2" align="center">Prepared by:</td>
				                        <td colspan="2" align="center">Certified by:</td>
				                    </tr>
				                    <tr>
				                        <td colspan="2" align="center">Sonia O. Rodriguez</td>
				                        <td colspan="2" align="center">Marilou C. Guarina</td>
				                    </tr>';
				    break;
					
				    case 'NCCAI':
				        echo ' <tr>
				                        <td colspan="2" align="center">Prepared by:</td>
				                        <td colspan="2" align="center">Checked by:</td>
				                    </tr>
				                    <tr>
				                        <td colspan="2" style="text-align:center;font-weight:bold;height: 50px;vertical-align: bottom; width:350px">'.$_SESSION['ipay_users'].'</td>
				                        <td colspan="2" style="text-align:center;font-weight:bold;vertical-align: bottom;">'.strtoupper('Marilou C. GuariÑa').'</td>
				                    </tr>
				                    <tr>
				                        <td colspan="2" align="center">PAYROLL ASSOCIATE</td>
				                        <td colspan="2" align="center">ASSISTANT VICE PRESIDENT</td>
				                    </tr>';
				    break;
					
				    case 'LFI01':
				         echo '<tr>
				                        <td colspan="2" align="center">Prepared by:</td>
				                        <td colspan="2" align="center">Certified by:</td>
				                    </tr>
				                    <tr>
				                        <td colspan="2" style="text-align:center;font-weight:bold; height:50px; vertical-align:bottom; width:350px">'.$_SESSION['ipay_users'].'</td>
				                        <td colspan="2" style="text-align:center;font-weight:bold;vertical-align: bottom;">'.strtoupper('Marilou C. GuariÑa').'</td>
				                    </tr>
				                    <tr>
				                        <td colspan="2" align="center">PAYROLL ASSOCIATE</td>
				                        <td colspan="2" align="center">ASSISTANT VICE PRESIDENT</td>
				                    </tr>';
				    break;
					
				    case 'MCTI':
				        echo '<tr>
				                        <td colspan="2" align="center"> Prepared by: </td>
				                        <td colspan="2" align="center"> Certified by: </td>
				                    </tr>
				                    <tr>
				                        <td colspan="2" style="text-align:center; font-weight:bold; height:50px; vertical-align:bottom; width:350px">'.$_SESSION['ipay_users'].'</td>
				                        <td colspan="2" style="text-align:center; font-weight:bold; vertical-align:bottom;">'.strtoupper('JASON P. FALLER').'</td>
				                    </tr>
				                    <tr>
				                        <td colspan="2" align="center">PAYROLL ASSOCIATE</td>
				                        <td colspan="2" align="center">VICE PRESIDENT</td>
				                    </tr>';
				       break;
					
				     case 'GLOBALHOTEL' || 'GLOBAL_HOTEL' :
				        echo '<tr>
				                        <td colspan="2" align="center"> Prepared by: </td>
				                        <td colspan="2" align="center"> Certified by: </td>
				                    </tr>
				                    <tr>
				                        <td colspan="2" style="text-align:center; font-weight:bold; height:50px; vertical-align:bottom; width:350px">'.$_SESSION['ipay_users'].'</td>
				                        <td colspan="2" style="text-align:center; font-weight:bold; vertical-align:bottom;">'.strtoupper('Marilou C. GuariÑa').'</td>
				                    </tr>
				                    <tr>
				                        <td colspan="2" align="center">PAYROLL ASSOCIATE</td>
				                        <td colspan="2" align="center">ASSISTANT VICE PRESIDENT</td>
				                    </tr>';
				       break;
					
				    default:
				    break;
				}

				echo	"</table>";
		?>

	</body>
	<?php
	} elseif ($coe[0]["type"] == "PHILHEALTHCERT") {
		?>
		<body>
		<div style='margin-top: 45px; text-align: center; font-size: 35px; text-decoration: underline; margin-bottom: 50px;'><b>CERTIFICATE</div>
		<p style='text-align: justify'>This is to certify that <?php echo $emp_info[0]["FullName"]  ?> with SSS # <?php echo $emp_info[0]["CompSSSNbr"]  ?> has remitted the following
				SSS PREMIUM Contribution of Mr./Ms. <?php echo $emp_info[0]["FullName"]  ?> with SSS # <?php echo $emp_info[0]["SSSNbr"]  ?>.</p><br>	
		<!-- Start Print Alignment -->
		<table>
			<tr style='width: 100%' >
				<td style='width:125px;text-align:center;height:70px'>   APPLICATION <br> MONTH     </td>
				<td style='width:125px;text-align:center;height:70px'>   PHILHEALTH <br> RECIEPT NO.       </td>
				<td style='width:100px;text-align:center;height:70px'>   DATE <br> REMITTED         </td>
				<td style='width:100px;text-align:center;height:70px'>   EMPLOYEE <br> SHARE        </td>
				<td style='width:100px;text-align:center;height:70px'>   EMPLOYER <br> SHARE        </td>
				<td style='width:100px;text-align:center;height:70px'>   TOTAL                      </td>
			</tr>
	
			<?php
					$approver = get_approver($emp_info[0]["CompanyID"]);
					$query = "
				SELECT 	PHMonth,
                    PHYear,
                    ReceiptNo,
                    ReceiptDate,
                    PHEmployee,
                    PHEmployer,
                    EndDate
				FROM dbo.PHRemit 
				WHERE 	EmpID='".$emp_id."' 
				AND 	EndDate BETWEEN '". date('m/d/Y',strtotime($coe[0]["leave_from"]))."' 
						AND '".date('m/d/Y',strtotime($coe[0]["leave_to"]))."' 
				ORDER BY EndDate ASC";

				echo $query;
					$employees = $mainsql->get_row($query);
					$total=0;
					$totalemployer=0;
					$totalemployee=0;
					 
					foreach($employees as $r)
					{ 
						?>
							<tr>
								<td align='center'> <? echo date('F',strtotime($r['EndDate'])); ?> </td>
								<td align='center'> <? echo $r['ReceiptNo']; ?></td>
								<td align='center'> <? echo date('m/d/Y',strtotime($r['ReceiptDate'])); ?></td>
								<td align='center'> <? echo moneyformat($r['PHEmployee']); ?></td>
								<td align='center'> <? echo moneyformat($r['PHEmployer']); ?></td>
								<td align='center'> <? echo moneyformat($r['PHEmployee']+$r['PHEmployer']); ?></td>
							</tr>
							<?php
						$total          +=       $r['PHEmployee'] + $r['PHEmployer'];
						$totalemployee  +=       $r['PHEmployee'];
						$totalemployer  +=       $r['PHEmployer'];
					}
					
					echo	"<tr>
								<td align='center' style='font-weight:bold'>TOTAL</td>
								<td> </td>
								<td></td>
								<td style='text-decoration: underline overline; font-weight:bold' align='center'>".moneyformat($totalemployee)."</td>
								<td style='text-decoration: underline overline; font-weight:bold' align='center'>".moneyformat($totalemployer)."</td>
								<td style='text-decoration: underline overline; font-weight:bold' align='center'>".moneyformat($total)."</td>
							</tr>";
					
					echo	"</table> <br> <br><br> <br>";
					echo	"<table style='width:100%'>";
					
					echo	"</table>";
					echo " <table style='width:100%'> ";
					switch(strtoupper($emp_info[0]["CompanyID"]))
					{
						case 'ASIAAPMI':
							echo ' <tr>
											<td colspan="2" align="left">Prepared by:</td>
										</tr>
										<tr>
											<td colspan="2" style="text-align:left;font-weight:bold;height: 50px;vertical-align: bottom;">Jeriza Mae V. Sioco</td>
										<tr>
											<td colspan="2" align="left">PAYROLL MANAGER</td>
										</tr>';
						break;
						
						case 'GLOBAL01':
							echo ' <tr>
											<td colspan="2" align="center">Prepared by:</td>
											<td colspan="2" align="center">Checked by:</td>
										</tr>
										<tr>
											<td colspan="2" style="text-align:center;font-weight:bold;height: 10px;vertical-align: bottom;">Jeriza Mae V. Sioco</td>
											<td colspan="2" style="text-align:center;font-weight:bold;vertical-align: bottom;">Arlene A. Branco</td>
										<tr>
											<td colspan="2" align="center">PAYROLL ANALYST</td>
											<td colspan="2" align="center">PAYROLL MANAGER</td>
										</tr>';
						break;
						
						case 'LGMI01':
							echo ' <tr>
											<td colspan="2" align="center">Prepared by:</td>
											<td colspan="2" align="center">Checked by:</td>
										</tr>
										<tr>
											<td colspan="2" style="text-align:center;font-weight:bold;height: 50px;vertical-align: bottom;">Mae Hazel B. Anastacio</td>
											<td colspan="2" style="text-align:center;font-weight:bold;vertical-align: bottom;">Arlene A. Branco</td>
										<tr>
											<td colspan="2" align="center">PAYROLL ANALYST</td>
											<td colspan="2" align="center">PAYROLL MANAGER</td>
										</tr>';
						break;
						
						case 'MEGA01':
							echo '
										<tr>
											<td colspan="2" align="center">Prepared by:</td>
											<td colspan="2" align="center">Certified by:</td>
										</tr>
										<tr>
											<td colspan="2" style="text-align:center;font-weight:bold;height: 50px;vertical-align: bottom; width:350px">'.$_SESSION['ipay_users'].'</td>
											<td colspan="2" style="text-align:center;font-weight:bold;vertical-align: bottom;">'.strtoupper('Marilou C. GuariÑa').'</td>
										</tr>
										<tr>
											<td colspan="2" align="center">PAYROLL ASSOCIATE</td>
											<td colspan="2" align="center">ASSISTANT VICE PRESIDENT</td>
										</tr>';
						break;
						
						case 'LUCK01':
							echo ' <tr>
											<td colspan="2" align="center">Prepared by:</td>
											<td colspan="2" align="center">Certified by:</td>
										</tr>
										<tr>
											<td colspan="2" style="text-align:center;font-weight:bold;height: 50px;vertical-align: bottom; width:350px">'.$_SESSION['ipay_users'].'</td>
											<td colspan="2" style="text-align:center;font-weight:bold;vertical-align: bottom;">'.strtoupper('Marilou C. GuariÑa').'</td>
										</tr>
										<tr>
											<td colspan="2" align="center">PAYROLL ASSOCIATE</td>
											<td colspan="2" align="center">ASSISTANT VICE PRESIDENT</td>
										</tr>';
						break;
						
						case 'MLI01':
							echo ' <tr>
											<td colspan="2" align="center">Prepared by:</td>
											<td colspan="2" align="center">Certified by:</td>
										</tr>
										<tr>
											<td colspan="2" style="text-align:center;font-weight:bold;height: 50px;vertical-align: bottom; width:350px">'.$_SESSION['ipay_users'].'</td>
											<td colspan="2" style="text-align:center;font-weight:bold;vertical-align: bottom;">'.strtoupper('Marilou C. GuariÑa').'</td>
										</tr>
										<tr>
											<td colspan="2" align="center">PAYROLL ASSOCIATE</td>
											<td colspan="2" align="center">ASSISTANT VICE PRESIDENT</td>
										</tr>';
						break;
						
						case 'TDI':
							echo '<tr>
											<td colspan="2" align="center">Prepared by:</td>
											<td colspan="2" align="center">Certified by:</td>
										</tr>
										<tr>
											<td colspan="2" align="center">Sonia O. Rodriguez</td>
											<td colspan="2" align="center">Marilou C. Guarina</td>
										</tr>';
						break;
						
						case 'ECOC':
						   echo '<tr>
											<td colspan="2" align="center">Prepared by:</td>
											<td colspan="2" align="center">Certified by:</td>
										</tr>
										<tr>
											<td colspan="2" align="center">Sonia O. Rodriguez</td>
											<td colspan="2" align="center">Marilou C. Guarina</td>
										</tr>';
						break;
						
						case 'SUNTRUST':
							echo '<tr>
											<td colspan="2" align="center">Prepared by:</td>
											<td colspan="2" align="center">Certified by:</td>
										</tr>
										<tr>
											<td colspan="2" align="center">Sonia O. Rodriguez</td>
											<td colspan="2" align="center">Marilou C. Guarina</td>
										</tr>';
						break;
						
						case 'EREX':
							echo '<tr>
											<td colspan="2" align="center">Prepared by:</td>
											<td colspan="2" align="center">Certified by:</td>
										</tr>
										<tr>
											<td colspan="2" align="center">Sonia O. Rodriguez</td>
											<td colspan="2" align="center">Marilou C. Guarina</td>
										</tr>';
						break;
						
						case 'CITYLINK':
							echo '<tr>
											<td colspan="2" align="center">Prepared by:</td>
											<td colspan="2" align="center">Certified by:</td>
										</tr>
										<tr>
											<td colspan="2" align="center">Sonia O. Rodriguez</td>
											<td colspan="2" align="center">Marilou C. Guarina</td>
										</tr>';
						break;
						
						case 'NCCAI':
							echo ' <tr>
											<td colspan="2" align="center">Prepared by:</td>
											<td colspan="2" align="center">Checked by:</td>
										</tr>
										<tr>
											<td colspan="2" style="text-align:center;font-weight:bold;height: 50px;vertical-align: bottom; width:350px">'.$_SESSION['ipay_users'].'</td>
											<td colspan="2" style="text-align:center;font-weight:bold;vertical-align: bottom;">'.strtoupper('Marilou C. GuariÑa').'</td>
										</tr>
										<tr>
											<td colspan="2" align="center">PAYROLL ASSOCIATE</td>
											<td colspan="2" align="center">ASSISTANT VICE PRESIDENT</td>
										</tr>';
						break;
						
						case 'LFI01':
							 echo '<tr>
											<td colspan="2" align="center">Prepared by:</td>
											<td colspan="2" align="center">Certified by:</td>
										</tr>
										<tr>
											<td colspan="2" style="text-align:center;font-weight:bold; height:50px; vertical-align:bottom; width:350px">'.$_SESSION['ipay_users'].'</td>
											<td colspan="2" style="text-align:center;font-weight:bold;vertical-align: bottom;">'.strtoupper('Marilou C. GuariÑa').'</td>
										</tr>
										<tr>
											<td colspan="2" align="center">PAYROLL ASSOCIATE</td>
											<td colspan="2" align="center">ASSISTANT VICE PRESIDENT</td>
										</tr>';
						break;
						
						case 'MCTI':
							echo '<tr>
											<td colspan="2" align="center"> Prepared by: </td>
											<td colspan="2" align="center"> Certified by: </td>
										</tr>
										<tr>
											<td colspan="2" style="text-align:center; font-weight:bold; height:50px; vertical-align:bottom; width:350px">'.$_SESSION['ipay_users'].'</td>
											<td colspan="2" style="text-align:center; font-weight:bold; vertical-align:bottom;">'.strtoupper('JASON P. FALLER').'</td>
										</tr>
										<tr>
											<td colspan="2" align="center">PAYROLL ASSOCIATE</td>
											<td colspan="2" align="center">VICE PRESIDENT</td>
										</tr>';
						   break;
						
						 case 'GLOBALHOTEL' || 'GLOBAL_HOTEL' :
							echo '<tr>
											<td colspan="2" align="center"> Prepared by: </td>
											<td colspan="2" align="center"> Certified by: </td>
										</tr>
										<tr>
											<td colspan="2" style="text-align:center; font-weight:bold; height:50px; vertical-align:bottom; width:350px">'.$_SESSION['ipay_users'].'</td>
											<td colspan="2" style="text-align:center; font-weight:bold; vertical-align:bottom;">'.strtoupper('Marilou C. GuariÑa').'</td>
										</tr>
										<tr>
											<td colspan="2" align="center">PAYROLL ASSOCIATE</td>
											<td colspan="2" align="center">ASSISTANT VICE PRESIDENT</td>
										</tr>';
						   break;
						
						default:
						break;
					}
	
					echo	"</table>";
			?>
	
		</body>
		<?php
		} else {
			?>
			<body>
			<div style='margin-top: 45px; text-align: center; font-size: 35px; text-decoration: underline; margin-bottom: 50px;'><b>CERTIFICATE</div>
			<p style='text-align: justify'>This is to certify that <?php echo $emp_info[0]["FullName"]  ?> with SSS # <?php echo $emp_info[0]["CompSSSNbr"]  ?> has remitted the following
					SSS PREMIUM Contribution of Mr./Ms. <?php echo $emp_info[0]["FullName"]  ?> with SSS # <?php echo $emp_info[0]["SSSNbr"]  ?>.</p><br>	
			<!-- Start Print Alignment -->
			<table>
				<tr style='width: 100%' >
					<td style='width:125px;text-align:center;height:70px'>   APPLICATION <br> MONTH     </td>
					<td style='width:125px;text-align:center;height:70px'>   SSS <br> RECIEPT NO.       </td>
					<td style='width:100px;text-align:center;height:70px'>   DATE <br> REMITTED         </td>
					<td style='width:100px;text-align:center;height:70px'>   EMPLOYEE <br> SHARE        </td>
					<td style='width:100px;text-align:center;height:70px'>   EMPLOYER <br> SHARE        </td>
					<td style='width:100px;text-align:center;height:70px'>   TOTAL                      </td>
				</tr>
		
				<?php
						$approver = get_approver($emp_info[0]["CompanyID"]);
						$query = "
					SELECT 	PagIbigMonth,
					PagIbigYear,
					ReceiptNo,
					ReceiptDate,
					PagIbigEmployee,
					PagIbigEmployer,
					EndDate
					FROM dbo.PagibigRemit 
					WHERE 	EmpID='".$emp_id."' 
					AND 	EndDate BETWEEN '". date('m/d/Y',strtotime($coe[0]["leave_from"]))."' 
							AND '".date('m/d/Y',strtotime($coe[0]["leave_to"]))."' 
					ORDER BY EndDate ASC";
		
						$employees = $mainsql->get_row($query);
						$total=0;
						$totalemployer=0;
						$totalemployee=0;
						 
						foreach($employees as $r)
						{ 
							?>
								<tr>
									<td align='center'> <? echo date('F',strtotime($r['EndDate'])); ?> </td>
									<td align='center'> <? echo $r['ReceiptNo']; ?></td>
									<td align='center'> <? echo date('m/d/Y',strtotime($r['ReceiptDate'])); ?></td>
									<td align='center'> <? echo moneyformat($r['PagIbigEmployee']); ?></td>
									<td align='center'> <? echo moneyformat($r['PagIbigEmployer']); ?></td>
									<td align='center'> <? echo moneyformat($r['PagIbigEmployee']+$r['PagIbigEmployer']); ?></td>
								</tr>
								<?php
							$total          +=       $r['PagIbigEmployee'] + $r['PagIbigEmployer'];
							$totalemployee  +=       $r['PagIbigEmployee'];
							$totalemployer  +=       $r['PagIbigEmployer'];
						}
						
						echo	"<tr>
									<td align='center' style='font-weight:bold'>TOTAL</td>
									<td> </td>
									<td></td>
									<td style='text-decoration: underline overline; font-weight:bold' align='center'>".moneyformat($totalemployee)."</td>
									<td style='text-decoration: underline overline; font-weight:bold' align='center'>".moneyformat($totalemployer)."</td>
									<td style='text-decoration: underline overline; font-weight:bold' align='center'>".moneyformat($total)."</td>
								</tr>";
						
						echo	"</table> <br> <br><br> <br>";
						echo	"<table style='width:100%'>";
						
						echo	"</table>";
						echo " <table style='width:100%'> ";
						switch(strtoupper($emp_info[0]["CompanyID"]))
						{
							case 'ASIAAPMI':
								echo ' <tr>
												<td colspan="2" align="left">Prepared by:</td>
											</tr>
											<tr>
												<td colspan="2" style="text-align:left;font-weight:bold;height: 50px;vertical-align: bottom;">Jeriza Mae V. Sioco</td>
											<tr>
												<td colspan="2" align="left">PAYROLL MANAGER</td>
											</tr>';
							break;
							
							case 'GLOBAL01':
								echo ' <tr>
												<td colspan="2" align="center">Prepared by:</td>
												<td colspan="2" align="center">Checked by:</td>
											</tr>
											<tr>
												<td colspan="2" style="text-align:center;font-weight:bold;height: 10px;vertical-align: bottom;">Jeriza Mae V. Sioco</td>
												<td colspan="2" style="text-align:center;font-weight:bold;vertical-align: bottom;">Arlene A. Branco</td>
											<tr>
												<td colspan="2" align="center">PAYROLL ANALYST</td>
												<td colspan="2" align="center">PAYROLL MANAGER</td>
											</tr>';
							break;
							
							case 'LGMI01':
								echo ' <tr>
												<td colspan="2" align="center">Prepared by:</td>
												<td colspan="2" align="center">Checked by:</td>
											</tr>
											<tr>
												<td colspan="2" style="text-align:center;font-weight:bold;height: 50px;vertical-align: bottom;">Mae Hazel B. Anastacio</td>
												<td colspan="2" style="text-align:center;font-weight:bold;vertical-align: bottom;">Arlene A. Branco</td>
											<tr>
												<td colspan="2" align="center">PAYROLL ANALYST</td>
												<td colspan="2" align="center">PAYROLL MANAGER</td>
											</tr>';
							break;
							
							case 'MEGA01':
								echo '
											<tr>
												<td colspan="2" align="center">Prepared by:</td>
												<td colspan="2" align="center">Certified by:</td>
											</tr>
											<tr>
												<td colspan="2" style="text-align:center;font-weight:bold;height: 50px;vertical-align: bottom; width:350px">'.$_SESSION['ipay_users'].'</td>
												<td colspan="2" style="text-align:center;font-weight:bold;vertical-align: bottom;">'.strtoupper('Marilou C. GuariÑa').'</td>
											</tr>
											<tr>
												<td colspan="2" align="center">PAYROLL ASSOCIATE</td>
												<td colspan="2" align="center">ASSISTANT VICE PRESIDENT</td>
											</tr>';
							break;
							
							case 'LUCK01':
								echo ' <tr>
												<td colspan="2" align="center">Prepared by:</td>
												<td colspan="2" align="center">Certified by:</td>
											</tr>
											<tr>
												<td colspan="2" style="text-align:center;font-weight:bold;height: 50px;vertical-align: bottom; width:350px">'.$_SESSION['ipay_users'].'</td>
												<td colspan="2" style="text-align:center;font-weight:bold;vertical-align: bottom;">'.strtoupper('Marilou C. GuariÑa').'</td>
											</tr>
											<tr>
												<td colspan="2" align="center">PAYROLL ASSOCIATE</td>
												<td colspan="2" align="center">ASSISTANT VICE PRESIDENT</td>
											</tr>';
							break;
							
							case 'MLI01':
								echo ' <tr>
												<td colspan="2" align="center">Prepared by:</td>
												<td colspan="2" align="center">Certified by:</td>
											</tr>
											<tr>
												<td colspan="2" style="text-align:center;font-weight:bold;height: 50px;vertical-align: bottom; width:350px">'.$_SESSION['ipay_users'].'</td>
												<td colspan="2" style="text-align:center;font-weight:bold;vertical-align: bottom;">'.strtoupper('Marilou C. GuariÑa').'</td>
											</tr>
											<tr>
												<td colspan="2" align="center">PAYROLL ASSOCIATE</td>
												<td colspan="2" align="center">ASSISTANT VICE PRESIDENT</td>
											</tr>';
							break;
							
							case 'TDI':
								echo '<tr>
												<td colspan="2" align="center">Prepared by:</td>
												<td colspan="2" align="center">Certified by:</td>
											</tr>
											<tr>
												<td colspan="2" align="center">Sonia O. Rodriguez</td>
												<td colspan="2" align="center">Marilou C. Guarina</td>
											</tr>';
							break;
							
							case 'ECOC':
							   echo '<tr>
												<td colspan="2" align="center">Prepared by:</td>
												<td colspan="2" align="center">Certified by:</td>
											</tr>
											<tr>
												<td colspan="2" align="center">Sonia O. Rodriguez</td>
												<td colspan="2" align="center">Marilou C. Guarina</td>
											</tr>';
							break;
							
							case 'SUNTRUST':
								echo '<tr>
												<td colspan="2" align="center">Prepared by:</td>
												<td colspan="2" align="center">Certified by:</td>
											</tr>
											<tr>
												<td colspan="2" align="center">Sonia O. Rodriguez</td>
												<td colspan="2" align="center">Marilou C. Guarina</td>
											</tr>';
							break;
							
							case 'EREX':
								echo '<tr>
												<td colspan="2" align="center">Prepared by:</td>
												<td colspan="2" align="center">Certified by:</td>
											</tr>
											<tr>
												<td colspan="2" align="center">Sonia O. Rodriguez</td>
												<td colspan="2" align="center">Marilou C. Guarina</td>
											</tr>';
							break;
							
							case 'CITYLINK':
								echo '<tr>
												<td colspan="2" align="center">Prepared by:</td>
												<td colspan="2" align="center">Certified by:</td>
											</tr>
											<tr>
												<td colspan="2" align="center">Sonia O. Rodriguez</td>
												<td colspan="2" align="center">Marilou C. Guarina</td>
											</tr>';
							break;
							
							case 'NCCAI':
								echo ' <tr>
												<td colspan="2" align="center">Prepared by:</td>
												<td colspan="2" align="center">Checked by:</td>
											</tr>
											<tr>
												<td colspan="2" style="text-align:center;font-weight:bold;height: 50px;vertical-align: bottom; width:350px">'.$_SESSION['ipay_users'].'</td>
												<td colspan="2" style="text-align:center;font-weight:bold;vertical-align: bottom;">'.strtoupper('Marilou C. GuariÑa').'</td>
											</tr>
											<tr>
												<td colspan="2" align="center">PAYROLL ASSOCIATE</td>
												<td colspan="2" align="center">ASSISTANT VICE PRESIDENT</td>
											</tr>';
							break;
							
							case 'LFI01':
								 echo '<tr>
												<td colspan="2" align="center">Prepared by:</td>
												<td colspan="2" align="center">Certified by:</td>
											</tr>
											<tr>
												<td colspan="2" style="text-align:center;font-weight:bold; height:50px; vertical-align:bottom; width:350px">'.$_SESSION['ipay_users'].'</td>
												<td colspan="2" style="text-align:center;font-weight:bold;vertical-align: bottom;">'.strtoupper('Marilou C. GuariÑa').'</td>
											</tr>
											<tr>
												<td colspan="2" align="center">PAYROLL ASSOCIATE</td>
												<td colspan="2" align="center">ASSISTANT VICE PRESIDENT</td>
											</tr>';
							break;
							
							case 'MCTI':
								echo '<tr>
												<td colspan="2" align="center"> Prepared by: </td>
												<td colspan="2" align="center"> Certified by: </td>
											</tr>
											<tr>
												<td colspan="2" style="text-align:center; font-weight:bold; height:50px; vertical-align:bottom; width:350px">'.$_SESSION['ipay_users'].'</td>
												<td colspan="2" style="text-align:center; font-weight:bold; vertical-align:bottom;">'.strtoupper('JASON P. FALLER').'</td>
											</tr>
											<tr>
												<td colspan="2" align="center">PAYROLL ASSOCIATE</td>
												<td colspan="2" align="center">VICE PRESIDENT</td>
											</tr>';
							   break;
							
							 case 'GLOBALHOTEL' || 'GLOBAL_HOTEL' :
								echo '<tr>
												<td colspan="2" align="center"> Prepared by: </td>
												<td colspan="2" align="center"> Certified by: </td>
											</tr>
											<tr>
												<td colspan="2" style="text-align:center; font-weight:bold; height:50px; vertical-align:bottom; width:350px">'.$_SESSION['ipay_users'].'</td>
												<td colspan="2" style="text-align:center; font-weight:bold; vertical-align:bottom;">'.strtoupper('Marilou C. GuariÑa').'</td>
											</tr>
											<tr>
												<td colspan="2" align="center">PAYROLL ASSOCIATE</td>
												<td colspan="2" align="center">ASSISTANT VICE PRESIDENT</td>
											</tr>';
							   break;
							
							default:
							break;
						}
		
						echo	"</table>";
				?>
		
			</body>
			<?php
			}
		?>
	<?php
		echo !$send_pdf ? '&nbsp;<br />'  : '';
	?>

		<!-- FOOTER START -->
		<?php
		if((in_array($coe[0]["company"], ['GLOBAL01', 'LGMI01'])) && $coe[0]["type"] != 'COECOMPENSATION' && $coe[0]["type"] == 'COESEPARATED'){
		?>
			<p style="font-size: <?php echo $send_pdf ? '8px' : '10px'; ?>; text-align: right; padding-right: 50px"><b>THIS DOCUMENT IS PRIVATE AND CONFIDENTIAL.<br />
			FOR EMPLOYMENT DETAILS PURPOSES ONLY.<br />
			NOT AS EMPLOYEE CLEARANCE.</b></p>
		<?php
		} elseif (($coe[0]["company"] == 'MEGA01') && $coe[0]["type"] != 'COECOMPENSATION') {
		?>
			<?php
				if($send_pdf){
				?>
					<p style="font-size: <?php echo $send_pdf ? '8px' : '10px'; ?>; text-align: right; padding-right: 50px">This is a system generated document. Any alteration on this document is not valid.</p>
				<?php
				}
			?>
		<?php
		}
		?>
</div>
<?php
