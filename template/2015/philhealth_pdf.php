<div id="myDivToPrint2">
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

	if ($coe[0]["type"] == "PHILHEALTHCSF") {
	?>
	
	<img style="width: 100%; position: absolute; top: 75px; left: 0px;" src="<?php echo IMG_WEB; ?>/ClaimSignatureForm_a.png"/></p>
	<body style="size: Legal; font-size: 7pt; font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif">
		<!-- Start Print Alignment -->
		<?php 

		$ph_no = clean_str($emp_info[0]["PhilHealthNbr"]);
		place_text(substr($ph_no, 0, 2), 82, 71, 'letter-spacing: 10px');
		place_text(substr($ph_no, 2, 9), 92.5, 71, 'letter-spacing: 8px');
		place_text(substr($ph_no, 11, 1), 129.5, 71, 'letter-spacing: 10px');

		place_text(mb_convert_encoding($emp_info[0]["LName"], 'UTF-8', 'HTML-ENTITIES'), 9.5, 79, '');
		place_text(mb_convert_encoding($emp_info[0]["FName"], 'UTF-8', 'HTML-ENTITIES'), 43, 79, '');
		// place_text($philhealth->LName, 10, 54, ''); For Extension
		place_text(mb_convert_encoding($emp_info[0]["MName"], 'UTF-8', 'HTML-ENTITIES'), 112, 79, '');


		place_text(date('m', strtotime($emp_info[0]["BirthDate"])), 145, 80.60, 'letter-spacing: 5.5px');
		place_text(date('d', strtotime($emp_info[0]["BirthDate"])), 155, 80.60, 'letter-spacing: 5.5px;');
		place_text(date('Y', strtotime($emp_info[0]["BirthDate"])), 165, 80.60, 'letter-spacing: 7.3px;');

		// $ph_no = clean_str($philhealth->PhilHealthNbr_Comp);
		// place_text(substr($ph_no, 0, 2), 62, 171.5, 'letter-spacing: 8px');
		// place_text(substr($ph_no, 2, 9), 72, 171.5, 'letter-spacing: 8px');
		// place_text(substr($ph_no, 11, 1),109, 171.5, 'letter-spacing:8px');

		// place_text($philhealth->CompanyName, 39, 175.3, '');
		// place_text($approver->name, 10, 198, '');
		// place_text($approver->position, 83, 198, '');

		?>
	</body>
	<?php
	} 
	?>
	<?php
		echo !$send_pdf ? '&nbsp;<br />'  : '';
	?>


		<!-- Breaklines START -  for Template - TCPDF cant render css height of div - FOOTER BREAKLINES -->
		<?php if (in_array($coe[0]["type"], ['COE', 'COEGOODMORAL', 'COEGOODMORAL', 'COESEPARATED'])){ ?>
			&nbsp;<br />&nbsp;<br />&nbsp;<br />&nbsp;<br />&nbsp;<br />
			&nbsp;<br />&nbsp;<br />&nbsp;<br />
			<?php if($coe[0]["type"] == 'COE' && !$send_pdf){ ?>
				&nbsp;<br />&nbsp;<br />&nbsp;<br />
				&nbsp;<br />
			<?php } ?>
		<?php } elseif (in_array($coe[0]["type"], ['COEHOUSINGPLAN', 'COEAPPROVEDLEAVE', 'COECORRECTIONNAME'])) { ?>
			&nbsp;<br />&nbsp;<br />&nbsp;<br />&nbsp;<br />&nbsp;<br />
		<?php } ?>
		<!-- Breaklines END -->

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

		<!-- </b><p style="font-size: <?php echo $send_pdf ? '8px' : '10px'; ?>; padding-left: 50px; padding-right: 50px;">Ref No.:<?php echo $coe[0]["ref_no"]; ?></p> -->

		<div style="position:absolute; bottom: 50px; text-align:center; width: 100%">
		<?php
		if ((in_array($coe[0]["company"], ['GLOBAL01', 'LGMI01'])) ) {
		?>
			&nbsp;<br />
			<p style="font-size: <?php echo $send_pdf ? '8px' : '10px'; ?>; text-align: center;">Unit G, Ground Floor, 331 Building, 331 Sen. Gil Puyat Avenue, Barangay Bel-Air, Makati City 1200 • Tels (632) 5411979 / 8946345 <br />
			<a href="www.globalcompanies.com.ph">www.globalcompanies.com.ph</a> • Email: <a href="globalonehr@globalcompanies.com.ph">globalonehr@globalcompanies.com.ph</a></p>
		<?php
		} elseif (($coe[0]["company"] == 'MEGA01')) {
		?>
			&nbsp;
			<p style="font-size: <?php echo $send_pdf ? '8px' : '10px'; ?>; text-align: center;">25/F Alliance Global Tower, 36th Street corner 11th Avenue Uptown Bonifacio, Taguig City 1634 <br />
			Trunkline: (632) 905-2900 • (632) 905-2800 <br />
			www.megaworldcorp.com • Email: infodesk@megaworldcorp.com</p>
		<?php
		} elseif (($coe[0]["company"] == 'MCTI') ) {
		?>
			&nbsp;<br />
			<p style="font-size: <?php echo $send_pdf ? '8px' : '10px'; ?>; color: #005f2f; text-align: center;">Capitol Boulevard, Barangay Sto. Niño, City of San Fernando, Pampanga 2000 | Tels 045-963-1990<br />
			www.capitaltownpampanga.com | Email info: info@capitaltownpampanga</p>
		<?php
		} elseif (($coe[0]["company"] == 'ASIAAPMI') ) {
		?>
			&nbsp;<br />
			<p style="font-size: <?php echo $send_pdf ? '8px' : '10px'; ?>; color: #005f2f; text-align: center;">6/F One World Square, Upper McKinley Road, Taguig City, NCR Philippines, 1634<br />
			Telefax No. 8524-4284 | wwww.asia-affinity.com</p>
		<?php
		}
		?>
		</div>
		<!-- FOOTER END -->
</div>
<?php
