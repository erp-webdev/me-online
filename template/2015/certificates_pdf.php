<div id="myDivToPrint3">
	<div style="text-align: center; padding-top: 10px;">

		<?php $send_pdf = $_POST['send'] == 'true' ? true : false; ?>

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
							<td align='center'> <? echo $r['SSSEmployee']; ?></td>
							<td align='center'> <? echo $r['SSSEmployer']; ?></td>
							<td align='center'> <? echo $r['SSSEmployee']+$r['SSSEmployer']; ?></td>
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
							<td style='text-decoration: underline overline; font-weight:bold' align='center'>".$totalemployee."</td>
							<td style='text-decoration: underline overline; font-weight:bold' align='center'>".$totalemployer."</td>
							<td style='text-decoration: underline overline; font-weight:bold' align='center'>".$total."</td>
						</tr>";
				
				echo	"</table> <br> <br><br> <br>";
				echo	"<table style='width:100%'>";
				
				echo	"</table>";


		?>

	</body>
	<?php
	} else {
		?>
		
		<img style="width: 100%; position: absolute; top: 75px; left: 0px;" src="<?php echo IMG_WEB; ?>/ClaimForm1_a.png"/></p>
		<body style="size: Legal; font-size: 7pt; font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif">
			<!-- Start Print Alignment -->
			<?php 
	
	
			$ph_no = clean_str($emp_info[0]["PhilHealthNbr"]);
			place_text(substr($ph_no, 0, 2), 83.5, 88, 'letter-spacing: 9px');
			place_text(substr($ph_no, 2, 9), 94, 88, 'letter-spacing: 7px');
			place_text(substr($ph_no, 11, 1), 131.5, 88, 'letter-spacing: 10px');
	
			place_text(mb_convert_encoding($emp_info[0]["LName"], 'UTF-8', 'HTML-ENTITIES'), 11, 115, '');
			place_text(mb_convert_encoding($emp_info[0]["FName"], 'UTF-8', 'HTML-ENTITIES'), 44.5, 115, '');
			// place_text($philhealth->LName, 10, 54, ''); For Extension
			place_text(mb_convert_encoding($emp_info[0]["MName"], 'UTF-8', 'HTML-ENTITIES'), 113.5, 115, '');
	
	
			place_text(date('m', strtotime($emp_info[0]["BirthDate"])), 147.50, 97, 'letter-spacing: 5.5px');
			place_text(date('d', strtotime($emp_info[0]["BirthDate"])), 157.50, 97, 'letter-spacing: 5.5px;');
			place_text(date('Y', strtotime($emp_info[0]["BirthDate"])), 167.50, 97, 'letter-spacing: 7.3px;');
	
			$ph_no = clean_str($emp_info[0]["CompPhilHealthNbr"]);
			place_text(substr($ph_no, 0, 2), 64, 248.5, 'letter-spacing: 8px');
			place_text(substr($ph_no, 2, 9), 74, 248.5, 'letter-spacing: 7px');
			place_text(substr($ph_no, 11, 1),112, 248.5, 'letter-spacing:8px');
	
			place_text($emp_info[0]["CompanyName"], 39, 257.5, '');
			place_text($approver->name, 11.5, 284.5, '');
			place_text($approver->position, 85.5, 284.5, '');
	
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
