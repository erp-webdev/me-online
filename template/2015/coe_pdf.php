<div id="myDivToPrint" style="height: 750px;">
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
	</div>
	&nbsp;

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

	if($coe[0]["type"] == "COEAPPROVEDLEAVE"){ // COE with Approved Leave

		$start_date = $coe[0]["leave_from"];
		$end_date = $coe[0]["leave_to"];
		$return_date = $coe[0]["leave_return"];
	?>
			<h3 align="center" style="padding-top: 40px; letter-spacing: 10px;">CERTIFICATION</h3>
			&nbsp;

			<div style="text-align: justify;  text-justify: inter-word;">
				<p style="padding-top: 15px; padding-left: 50px; padding-right: 50px;">This is to certify that <b><?php echo $emp_info[0]["Salutation"]." ".strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?></b>
					<?php if($emp_info[0]["DateResigned"]){ ?>
						was employed
					<?php }else{ ?>
						is currently employed
					<?php } ?>
					with <b><?php echo $emp_info[0]["CompanyName"]; ?></b>
				as <b><?php echo $emp_info[0]["PositionDesc"]." - ".$emp_info[0]["DeptDesc"]."</b> for ".$emp_info[0]["DivisionName"]." DIVISION Since <b>".$emp_info[0]["HireDate"]; ?>
				<?php if($emp_info[0]["DateResigned"]){ echo "to ".$emp_info[0]["DateResigned"]."</b>"; }else{ ?>
				up to the present.</b></p>
				<?php } ?>

				<p style="padding-left: 50px; padding-right: 50px;">This is to further certify that <?php echo $emp_info[0]["salutation"]." ".strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?> shall be on leave from <b><?php echo date('F d, Y', strtotime($start_date))." to ".date('F d, Y', strtotime($end_date)); ?>
				</b>as approved by the Management. <?php echo $emp_info[0]["Gender"]; ?> is expected to report back for work on <b><?php echo date('F d, Y', strtotime($return_date)); ?></b>.</p>

				<p style="padding-left: 50px; padding-right: 50px;">This certification is being issued upon the request of <?php echo $emp_info[0]["salutation"]." ".strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?>
				<?php if($coe[0]["other_reason"]){ ?>
					as a requirement for <?php echo $emp_info[0]["Gender2"]. " ".$coe[0]["other_reason"]; ?>.</p>
				<?php }else{ ?>
					for whatever legal purpose it may serve.</p>
				<?php } ?>
				<p style="padding-left: 50px; padding-right: 50px;">Given this <?php echo date('jS')." day of ".date('F, Y'); ?> at <?php echo $companies[$emp_info[0]['CompanyID']]; ?>, Philippines.</p>
			</div>

			<?php
	}elseif ($coe[0]["type"] == "COECORRECTIONNAME") { // COE with Correction Name
			?>

			<h3 align="center" style="padding-top: 40px; letter-spacing: 10px;">CERTIFICATION</h3>
			&nbsp;

			<div style="text-align: justify;  text-justify: inter-word;">
				<p style="padding-top: 15px; padding-left: 50px; padding-right: 50px;">This certifies that <b><?php echo strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?></b> is<?php if( in_array(strtolower(substr($emp_info[0]["PositionDesc"],0,1)), ['a','e','i','o','u']) ){ echo ' an '; }else{ echo ' a '; }?>
				<b><?php
				if((in_array($coe[0]["company"], ['GLOBAL01', 'LGMI01'])) && $coe[0]["type"] != 'COECOMPENSATION'){
					echo $emp_info[0]["PositionDesc"]."</b> under <b>".$emp_info[0]["DeptDesc"].' / '.$emp_info[0]["DivisionName"]." DIVISION</b> of <b>".$emp_info[0]["CompanyName"]."</b> since <b>".$emp_info[0]["HireDate"];
				}else{
					echo $emp_info[0]["PositionDesc"]."</b> under <b>".$emp_info[0]["DivisionName"]." DIVISION</b> of <b>".$emp_info[0]["CompanyName"]."</b> since <b>".$emp_info[0]["HireDate"];
				}
				?>
				<?php if($emp_info[0]["DateResigned"]){ echo "to ".$emp_info[0]["DateResigned"]."</b>"; }else{ ?>
				up to the present.</b></p>
				<?php } ?>

				<p style="padding-left: 50px; padding-right: 50px;">This also certifies that <b><?php echo strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES'))."</b> and <b>".strtoupper($coe[0]["correction_name"]); ?>
				</b>is the same person as <?php echo strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?>.</p>

				<p style="padding-left: 50px; padding-right: 50px;">This certification is being issued upon the request of <?php echo $emp_info[0]["Salutation"]." ".strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?>
				<?php if($coe[0]["other_reason"]){ ?>
					as a requirement for <?php echo $emp_info[0]["Gender2"]. " ".$coe[0]["other_reason"]; ?>.</p>
				<?php }else{ ?>
					for whatever legal purpose it may serve.</p>
				<?php } ?>

				<p style="padding-left: 50px; padding-right: 50px;">Given this <?php echo date('jS')." day of ".date('F, Y'); ?> at <?php echo $companies[$emp_info[0]['CompanyID']]; ?>, Philippines.</p>
			</div>

			<?php
	}elseif ($coe[0]["type"] == "COEHOUSINGPLAN") { //COE with HPA
			?>

			<h3 align="center" style="padding-top: 40px; letter-spacing: 10px;">CERTIFICATION</h3>
			&nbsp;

			<div style="text-align: justify;  text-justify: inter-word;">
				<p style="padding-top: 15px; padding-left: 50px; padding-right: 50px;">This certifies that <b><?php echo strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?></b> is<?php if( in_array(strtolower(substr($emp_info[0]["PositionDesc"],0,1)), ['a','e','i','o','u']) ){ echo ' an '; }else{ echo ' a '; }?>
				<b><?php
				if((in_array($coe[0]["company"], ['GLOBAL01', 'LGMI01'])) && $coe[0]["type"] != 'COECOMPENSATION'){
					echo $emp_info[0]["PositionDesc"]."</b> under <b>". $emp_info[0]["DeptDesc"].' / '.$emp_info[0]["DivisionName"]." DIVISION</b> of <b>".$emp_info[0]["CompanyName"]."</b> since <b>".$emp_info[0]["HireDate"];
				}else{
					echo $emp_info[0]["PositionDesc"]."</b> under <b>".$emp_info[0]["DivisionName"]." DIVISION</b> of <b>".$emp_info[0]["CompanyName"]."</b> since <b>".$emp_info[0]["HireDate"];
				}
				?>
				<?php if($emp_info[0]["DateResigned"]){ echo "to ".$emp_info[0]["DateResigned"]."</b>"; }else{ ?>
				up to the present.</b></p>
				<?php } ?>

				<p style="padding-left: 50px; padding-right: 50px;">Furthermore, this is to certify that <?php echo strtolower($emp_info[0]["Gender"]); ?> is qualified for a
				<?php if($coe[0]["hpa_percent"] == '25%'){ ?>
					twenty five percent (25%)
				<?php }else if($coe[0]["hpa_percent"] == '30%'){ ?>
				 	thirty percent (30%)
				<?php }else if($coe[0]["hpa_percent"] == '35%'){ ?>
					thirty five percent (35%)
				<?php } ?>
				discount in the company's housing program as stated in our employee handbook.</p>

				<p style="padding-left: 50px; padding-right: 50px;">This certification is being issued upon the request of <?php echo $emp_info[0]["Salutation"]." ".strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES'))."
				as a requirement for the Deed of Absolute Sale of ".$emp_info[0]["Gender2"]." ".date('jS', mktime(0, 0, 0, 0, $coe[0]["avail_no"], 0)); ?> property availment under the company's housing program.</p>

				<p style="padding-left: 50px; padding-right: 50px;">Given this <?php echo date('jS')." day of ".date('F, Y'); ?> at <?php echo $companies[$emp_info[0]['CompanyID']]; ?>, Philippines.</p>
			</div>

			<?php
	}elseif ($coe[0]["type"] == "COEGOODMORAL") { // COE with Good Moral
			?>

			<h3 align="center" style="padding-top: 40px; letter-spacing: 10px;">CERTIFICATION</h3>
			&nbsp;

			<div style="text-align: justify;  text-justify: inter-word;">
				<p style="padding-top: 15px; padding-left: 50px; padding-right: 50px;">This certifies that <b><?php echo strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?></b> is<?php if( in_array(strtolower(substr($emp_info[0]["PositionDesc"],0,1)), ['a','e','i','o','u']) ){ echo ' an '; }else{ echo ' a '; }?>
				<b><?php
				if((in_array($coe[0]["company"], ['GLOBAL01', 'LGMI01'])) && $coe[0]["type"] != 'COECOMPENSATION'){
					echo $emp_info[0]["PositionDesc"]."</b> under <b>".$emp_info[0]["DeptDesc"].' / '.$emp_info[0]["DivisionName"]." DIVISION</b> of <b>".$emp_info[0]["CompanyName"]."</b> since <b>".$emp_info[0]["HireDate"];
				}else{
					echo $emp_info[0]["PositionDesc"]."</b> under <b>".$emp_info[0]["DivisionName"]." DIVISION</b> of <b>".$emp_info[0]["CompanyName"]."</b> since <b>".$emp_info[0]["HireDate"];
				}
				?>
				<?php if($emp_info[0]["DateResigned"]){ echo "to ".$emp_info[0]["DateResigned"]."</b>"; }else{ ?>
				up to the present.</b></p>
				<?php } ?>

				<p style="padding-left: 50px; padding-right: 50px;">This further certifies that <?php echo strtolower($emp_info[0]["Gender"]); ?> has no derogatory record on file.</p>

				<p style="padding-left: 50px; padding-right: 50px;">This certification is being issued upon the request of <?php echo $emp_info[0]["Salutation"]." ".strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?>
				<?php if($coe[0]["other_reason"]){ ?>
					as a requirement for <?php echo $emp_info[0]["Gender2"]. " ".$coe[0]["other_reason"];?>.</p>
				<?php }else{ ?>
					for whatever legal purpose it may serve.</p>
				<?php } ?>

				<p style="padding-left: 50px; padding-right: 50px;">Given this <?php echo date('jS')." day of ".date('F, Y'); ?> at <?php echo $companies[$emp_info[0]['CompanyID']]; ?>, Philippines.</p>
			</div>

			<?php
	}elseif ($coe[0]["type"] == 'COESEPARATED') {
			?>

			<h3 align="center" style="padding-top: 40px; letter-spacing: 10px;">CERTIFICATION</h3>
			&nbsp;

			<div style="text-align: justify;  text-justify: inter-word;">
				<p style="padding-top: 15px; padding-left: 50px; padding-right: 50px;">This certifies that <b><?php echo strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?></b>
					<?php if($emp_info[0]["DateResigned"]){ ?>
						was employed as
					<?php }else{ ?>
						is currently employed as
					<?php } ?>
				<b><?php echo $emp_info[0]["PositionDesc"]."</b> by <b>".$emp_info[0]["CompanyName"]."</b> from <b>".$emp_info[0]["HireDate"]; ?>
				<?php if($emp_info[0]["DateResigned"]){ echo "to ".$emp_info[0]["DateResigned"]."</b>"; }else{ ?>
				up to the present.</b></p>
				<?php } ?>

				<?php
				if ($emp_info[0]["CompanyID"] == 'GLOBAL01' || $emp_info[0]["CompanyID"] == 'LGMI01') {
				?>
				<p style="padding-left: 50px; padding-right: 50px;">This does not certify that <?php echo $emp_info[0]["CompanyName"];?> has cleared <?php echo $emp_info[0]["Gender3"]; ?> of
				all of <?php echo $emp_info[0]["Gender2"]; ?> accountabilities with the Company.</p>
				<?php } ?>

				<p style="padding-left: 50px; padding-right: 50px;">This certification is being issued upon the request of <?php echo $emp_info[0]["Salutation"]." ".strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?>
				<?php
					if($coe[0]["other_reason"]){
				?>
						as a requirement for <?php echo $emp_info[0]["Gender2"]. " ".$coe[0]["other_reason"];?>.</p>
				<?php
					}else if($coe[0]["reason"]){
						if($coe[0]["category"] == 'VISA'){
				 ?>
							as a requirement for <?php echo $emp_info[0]["Gender2"]. " ".$coe[0]["category"]."(";
							foreach($countries as $key => $country){
								if($coe[0]["reason"] == $key){
									echo $country;
								}
							}
							?>).</p>
				<?php
						}else{
				?>
							as a requirement for <?php echo $emp_info[0]["Gender2"]. " ".$coe[0]["reason"];?>.</p>
				<?php
						}
					}else{
				?>
						for whatever legal purpose it may serve.</p>
				<?php
					}
				?>

				<p style="padding-left: 50px; padding-right: 50px;">Given this <?php echo date('jS')." day of ".date('F, Y'); ?> at <?php echo $companies[$emp_info[0]['CompanyID']]; ?>, Philippines.</p>
			</div>

			<?php
	}elseif ($coe[0]["type"] == "COE") {
			?>

			<h3 align="center" style="padding-top: 40px; letter-spacing: 10px;">CERTIFICATION</h3>
			&nbsp;

			<div style="text-align: justify;  text-justify: inter-word;">

				<p style="padding-top: 15px; padding-left: 50px; padding-right: 50px;">This certifies that <b><?php echo strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?></b>
					<?php if($emp_info[0]["DateResigned"]){ ?>
						was employed as
					<?php }else{ ?>
						is currently employed as
					<?php } ?>
				<b><?php
				if((in_array($coe[0]["company"], ['GLOBAL01', 'LGMI01'])) && $coe[0]["type"] != 'COECOMPENSATION'){
					echo $emp_info[0]["PositionDesc"]."</b> under <b>".$emp_info[0]["DeptDesc"].' / '.$emp_info[0]["DivisionName"]." DIVISION</b> of <b>".$emp_info[0]["CompanyName"]."</b> since <b>".$emp_info[0]["HireDate"];
				}else{
					echo $emp_info[0]["PositionDesc"]."</b> under <b>".$emp_info[0]["DivisionName"]." DIVISION</b> of <b>".$emp_info[0]["CompanyName"]."</b> since <b>".$emp_info[0]["HireDate"];
				}
				?>
				<?php if($emp_info[0]["DateResigned"]){ echo "to ".$emp_info[0]["DateResigned"]."</b>"; }else{ ?>
				up to the present.</b></p>
				<?php } ?>

				<p style="padding-left: 50px; padding-right: 50px;">This certification is being issued upon the request of <?php echo $emp_info[0]["Salutation"]." ".strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?>
				<?php
					if($coe[0]["other_reason"]){
				?>
						as a requirement for <?php echo $emp_info[0]["Gender2"]. " ".$coe[0]["other_reason"];?>.</p>
				<?php
					}else if($coe[0]["reason"]){
						if($coe[0]["category"] == 'VISA'){
				 ?>
							as a requirement for <?php echo $emp_info[0]["Gender2"]. " ".$coe[0]["category"]."(";
							foreach($countries as $key => $country){
								if($coe[0]["reason"] == $key){
									echo $country;
								}
							}
							?>).</p>
				<?php
						}else{
				?>
							as a requirement for <?php echo $emp_info[0]["Gender2"]. " ".$coe[0]["reason"];?>.</p>
				<?php
						}
					}else{
				?>
						for whatever legal purpose it may serve.</p>
				<?php
					}
				?>

				<p style="padding-left: 50px; padding-right: 50px;">Given this <?php echo date('jS')." day of ".date('F, Y'); ?> at <?php echo $companies[$emp_info[0]['CompanyID']]; ?>, Philippines.</p>
			</div>

			<?php
	}elseif ($coe[0]["type"] == "COENONCASHADVANCEMENT") {
			?>

			<h3 align="center" style="padding-top: 40px; letter-spacing: 10px;">CERTIFICATION</h3>
			&nbsp;

			<div style="text-align: justify;  text-justify: inter-word;">

				<p style="padding-top: 15px; padding-left: 50px; padding-right: 50px;">This certifies that <b><?php echo ucwords(strtolower($emp_info[0]["Salutation"]." ".$emp_info[0]["FullName"])); ?></b>
					<?php if($emp_info[0]["DateResigned"]){ ?>
						was employed as
					<?php }else{ ?>
						is currently employed as
					<?php } ?>
				<b><?php
				echo ucwords(strtolower($emp_info[0]["PositionDesc"]))."</b> by <b>".ucwords(strtolower($emp_info[0]["CompanyName"]))."</b> from <b>".$emp_info[0]["HireDate"];
				?>
				<?php if($emp_info[0]["DateResigned"]){ echo "to ".$emp_info[0]["DateResigned"].".</b>"; }else{ ?>
				up to the present.</b></p>
				<?php } ?>

				<p style="padding-left: 50px; padding-right: 50px;"> This is to further certify that <?php echo strtolower($emp_info[0]["Gender"])?> did not receive any advance payment from the company for <?php echo $emp_info[0]["Gender2"]?> SSS <?php echo strtolower($coe[0]["category"]) ?> benefit.</p>
				
				<p style="padding-left: 50px; padding-right: 50px;">This certification is being issued upon the request of <?php echo ucwords(strtolower($emp_info[0]["Salutation"]))." ".ucwords(strtolower(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES'))); ?>
				for the purpose of complying with the documentary requirements for <?php echo $emp_info[0]["Gender2"]?> SSS <?php echo strtolower($coe[0]["category"]) ?> benefit claim.</p>

				<p style="padding-left: 50px; padding-right: 50px;">Given this <?php echo date('jS')." day of ".date('F Y'); ?> at <?php echo $companies[$emp_info[0]['CompanyID']]; ?>, Philippines.</p>
			</div>

			<?php
	}elseif ($coe[0]["type"] == "COEFORCOMPENSATION") {
			?>

			<h3 align="center" style="padding-top: 40px; letter-spacing: 10px;">CERTIFICATION</h3>
			&nbsp;

			<div style="text-align: justify;  text-justify: inter-word;">

				<p style="padding-top: 15px; padding-left: 50px; padding-right: 50px;">This certifies that <b><?php echo strtoupper($emp_info[0]["FullName"]); ?></b>
					<?php if($emp_info[0]["DateResigned"]){ ?>
						was employed as
					<?php }else{ ?>
						is currently employed as
					<?php } ?>
				<b><?php
				echo strtoupper($emp_info[0]["PositionDesc"])."</b> by <b>".strtoupper($emp_info[0]["CompanyName"])."</b> from <b>".$emp_info[0]["HireDate"];
				?>
				<?php if($emp_info[0]["DateResigned"]){ echo "to ".$emp_info[0]["DateResigned"].".</b>"; }else{ ?>
				up to the present.</b></p>
				<?php } ?>

				<p style="padding-left: 50px; padding-right: 50px;">This certification is being issued upon the request of <?php echo strtoupper($emp_info[0]["Salutation"])." ".strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?>
				as a requirment for <?php echo $emp_info[0]["Gender2"]?> Employee Compensation Application. <?php echo $emp_info[0]["Gender"]?> last reported for work on <?php echo $emp_info[0]["other_reason"] ?>.</p>

				<p style="padding-left: 50px; padding-right: 50px;">Given this <?php echo date('jS')." day of ".date('F Y'); ?> at <?php echo $companies[$emp_info[0]['CompanyID']]; ?>, Philippines.</p>
			</div>

			<?php
	}elseif ($coe[0]["type"] == "COEJOBDESC") { // CoE with Job Description

			$tasks = json_decode($coe[0]["job_desc"], true);
			?>
				<h3 align="center" style="padding-top: 40px; letter-spacing: 10px;">CERTIFICATION</h3>
				&nbsp;

			<div style="text-align: justify;  text-justify: inter-word;">
				<p style="padding-top: 15px; padding-left: 50px; padding-right: 50px;">This certifies that <b><?php echo strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?></b>
					<?php if($emp_info[0]["DateResigned"]){ ?>
						was employed as
					<?php }else{ ?>
						is currently employed as
					<?php } ?>
				<b><?php
				if((in_array($coe[0]["company"], ['GLOBAL01', 'LGMI01'])) && $coe[0]["type"] != 'COECOMPENSATION'){
					echo $emp_info[0]["PositionDesc"]."</b> under <b>".$emp_info[0]["DeptDesc"].' / '.$emp_info[0]["DivisionName"]." DIVISION</b> of <b>".$emp_info[0]["CompanyName"]."</b> since <b>".$emp_info[0]["HireDate"];
				}else{
					echo $emp_info[0]["PositionDesc"]."</b> under <b>".$emp_info[0]["DivisionName"]." DIVISION</b> of <b>".$emp_info[0]["CompanyName"]."</b> since <b>".$emp_info[0]["HireDate"];
				}
				?>
				<?php if($emp_info[0]["DateResigned"]){ echo "to ".$emp_info[0]["DateResigned"]."</b>"; }else{ ?>
				up to the present.</b></p>
				<?php } ?>

				<p style="padding-left: 50px; padding-right: 50px;">As <?php if( in_array(strtolower(substr($emp_info[0]["PositionDesc"],0,1)), ['a','e','i','o','u']) ){ echo ' an '; }else{ echo ' a '; }echo $emp_info[0]["PositionDesc"].", ". strtolower($emp_info[0]["Gender"]); ?> <?php if($emp_info[0]["DateResigned"]){ echo "had"; }else{ ?>
				has<?php } ?> the following main responsibilities:</p>

				<ul style="padding-left: 100px;">
				<?php foreach($tasks as $task){ ?>
				<li><?php echo $task;?></li>
				<?php } ?>
				</ul>

				<p style="padding-left: 50px; padding-right: 50px;">This certification is being issued upon the request of <?php echo $emp_info[0]["Salutation"]." ".strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?>
				<?php if($coe[0]["other_reason"]){ ?>
					as a requirement for <?php echo $emp_info[0]["Gender2"]. " ".$coe[0]["other_reason"]; ?>.</p>
				<?php }else{ ?>
					for whatever legal purpose it may serve.</p>
				<?php } ?>

				<p style="padding-left: 50px; padding-right: 50px;">Given this <?php echo date('jS')." day of ".date('F, Y'); ?> at <?php echo $companies[$emp_info[0]['CompanyID']]; ?>, Philippines.</p>
			</div>
			<?php
				echo !$send_pdf ? '&nbsp;<br />'  : '';
			?>


			<?php
	}elseif ($coe[0]["type"] == "COECOMPENSATION") { // CoE with Compensation
		?>

		<h3 align="center" style="padding-top: 40px">CERTIFICATION OF EMPLOYMENT AND COMPENSATION</h3>
		&nbsp;

		<?php if(!$DateResigned2 || date('Y-m-d', strtotime($DateResigned2)) > date('Y-m-d')) : ?>
		<div style="text-align: justify;  text-justify: inter-word;">
			<p style="padding-top: 15px; padding-left: 50px; padding-right: 50px;">This is to certify that <b><?php echo strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?></b> is an
				employee of <b><?php echo $emp_info[0]["CompanyName"]; ?></b> since <b><?php echo $emp_info[0]["HireDate"]; ?>
			<?php if($emp_info[0]["DateResigned"]){ echo "to ".$emp_info[0]["DateResigned"].".</b>"; }else{ ?>
			</b>and presently holding a <?php echo strtolower($emp_info[0]["StatusDesc"]); ?> appointment for the position of <b><?php echo $emp_info[0]["PositionDesc"]; ?>.</b></p>
			<?php } ?>

			<p style="padding-left: 50px; padding-right: 50px;"><?php echo ucwords(strtolower($emp_info[0]["Gender2"])); ?> current monthly compensation are as follows:</p>
			<!-- nbsp for the pdf conversion, tcpdf doesn't support inline block, and padding. TCPDF has different implementation for tables -->
			<p style="padding-left: 50px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Basic Salary</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php if(true){echo number_format($emp_info[0]["MonthlyRate"], 2);}else{ echo "SAMPLE"; }; ?></b></p>
			<?php if($emp_info[0]["Allowance"] != 0){ ?>
					<p style="padding-left: 50px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Allowance</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><u><?php echo number_format($emp_info[0]["Allowance"], 2); ?></u></b></p>
					<p style="padding-left: 50px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><u><?php echo number_format($emp_info[0]["Allowance"] + $emp_info[0]["MonthlyRate"], 2); ?></u></b></p>
			<?php } ?>

			<p style="padding-left: 50px; padding-right: 50px;">In addition to the above compensation package, <?php echo strtolower($emp_info[0]["Gender"]); ?> receives the mandatory
			13th month pay during the twelve (12) month period.</p>

			<p style="padding-left: 50px; padding-right: 50px;">This document is issued upon the request of <b><?php echo $emp_info[0]["Salutation"]." ".strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?>
			<?php if($coe[0]["other_reason"]){ ?>
				for <?php echo $emp_info[0]["Gender2"]. " <i>".$coe[0]["other_reason"]; ?></i></b>.</p>
			<?php }else{ ?>
			</b>for whatever legal purpose it may serve.</p>
			<?php } ?>

			<p style="padding-left: 50px; padding-right: 50px;">Given this <?php echo date('jS')." day of ".date('F, Y'); ?> at <?php echo $companies[$emp_info[0]['CompanyID']]; ?>, Philippines.</p>
		</div>
		<?php elseif(date('Y-m-d', strtotime($DateResigned2)) <= date('Y-m-d')): ?>
		<div style="text-align: justify;  text-justify: inter-word;">
			<p style="padding-top: 15px; padding-left: 50px; padding-right: 50px;">This is to certify that <b><?php echo strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?></b> is a former
				employee of <b><?php echo $emp_info[0]["CompanyName"]; ?></b> from <b><?php echo $emp_info[0]["HireDate"]; ?> to 
			<?php echo $emp_info[0]["DateResigned"]; ?> </b> with last held position of <b><?php echo $emp_info[0]["PositionDesc"]; ?>.</b></p>

			<p style="padding-left: 50px; padding-right: 50px;"><?php echo ucwords(strtolower($emp_info[0]["Gender2"])); ?> last monthly compensation are as follows:</p>
			<!-- nbsp for the pdf conversion, tcpdf doesn't support inline block, and padding. TCPDF has different implementation for tables -->
			<p style="padding-left: 50px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Basic Salary</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php if(true){echo number_format($emp_info[0]["MonthlyRate"], 2);}else{ echo ""; }; ?></b></p>
			<?php if($emp_info[0]["Allowance"] != 0){ ?>
					<p style="padding-left: 50px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Allowance</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><u><?php echo number_format($emp_info[0]["Allowance"], 2); ?></u></b></p>
					<p style="padding-left: 50px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><u><?php echo number_format($emp_info[0]["Allowance"] + $emp_info[0]["MonthlyRate"], 2); ?></u></b></p>
			<?php } ?>

			<p style="padding-left: 50px; padding-right: 50px;">In addition to the above compensation package, <?php echo strtolower($emp_info[0]["Gender"]); ?> receives the mandatory
			13th month pay during the twelve (12) month period.</p>

			<p style="padding-left: 50px; padding-right: 50px;">This document is issued upon the request of <b><?php echo $emp_info[0]["Salutation"]." ".strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?>
			<?php if($coe[0]["other_reason"]){ ?>
				for <?php echo $emp_info[0]["Gender2"]. " <i>".$coe[0]["other_reason"]; ?></i></b>.
			<?php }else{ ?>
			</b>for whatever legal purpose it may serve.
			<?php } ?>  Hence, the company hold no responsibility for any misrepresentation of facts and data  enumerated herein.</p>

			<p style="padding-left: 50px; padding-right: 50px;">Given this <?php echo date('jS')." day of ".date('F, Y'); ?> at <?php echo $companies[$emp_info[0]['CompanyID']]; ?>, Philippines.</p>
		</div>
		<?php endif; ?>
		&nbsp;
		<!-- <p style="padding-top: 15px; padding-left: 50px; padding-right: 50px;">Certified by:</p> -->

	<?php
}elseif ($coe[0]["type"] == "COECOMPENSATION") { // CoE with Compensation
	?>

	<h3 align="center" style="padding-top: 40px">CERTIFICATION OF EMPLOYMENT AND COMPENSATION</h3>
	&nbsp;

	<?php if(!$DateResigned2 || date('Y-m-d', strtotime($DateResigned2)) > date('Y-m-d')) : ?>
	<div style="text-align: justify;  text-justify: inter-word;">
		<p style="padding-top: 15px; padding-left: 50px; padding-right: 50px;">This is to certify that <b><?php echo strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?></b> is an
			employee of <b><?php echo $emp_info[0]["CompanyName"]; ?></b> since <b><?php echo $emp_info[0]["HireDate"]; ?>
		<?php if($emp_info[0]["DateResigned"]){ echo "to ".$emp_info[0]["DateResigned"].".</b>"; }else{ ?>
		</b>and presently holding a <?php echo strtolower($emp_info[0]["StatusDesc"]); ?> appointment for the position of <b><?php echo $emp_info[0]["PositionDesc"]; ?>.</b></p>
		<?php } ?>

		<p style="padding-left: 50px; padding-right: 50px;"><?php echo ucwords(strtolower($emp_info[0]["Gender2"])); ?> current monthly compensation are as follows:</p>
		<!-- nbsp for the pdf conversion, tcpdf doesn't support inline block, and padding. TCPDF has different implementation for tables -->
		<p style="padding-left: 50px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Basic Salary</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php if(true){echo number_format($emp_info[0]["MonthlyRate"], 2);}else{ echo "SAMPLE"; }; ?></b></p>
		<?php if($emp_info[0]["Allowance"] != 0){ ?>
				<p style="padding-left: 50px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Allowance</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><u><?php echo number_format($emp_info[0]["Allowance"], 2); ?></u></b></p>
				<p style="padding-left: 50px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><u><?php echo number_format($emp_info[0]["Allowance"] + $emp_info[0]["MonthlyRate"], 2); ?></u></b></p>
		<?php } ?>

		<p style="padding-left: 50px; padding-right: 50px;">In addition to the above compensation package, <?php echo strtolower($emp_info[0]["Gender"]); ?> receives the mandatory
		13th month pay during the twelve (12) month period.</p>

		<p style="padding-left: 50px; padding-right: 50px;">This document is issued upon the request of <b><?php echo $emp_info[0]["Salutation"]." ".strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?>
		<?php if($coe[0]["other_reason"]){ ?>
			for <?php echo $emp_info[0]["Gender2"]. " <i>".$coe[0]["other_reason"]; ?></i></b>.</p>
		<?php }else{ ?>
		</b>for whatever legal purpose it may serve.</p>
		<?php } ?>

		<p style="padding-left: 50px; padding-right: 50px;">Given this <?php echo date('jS')." day of ".date('F, Y'); ?> at <?php echo $companies[$emp_info[0]['CompanyID']]; ?>, Philippines.</p>
	</div>
	<?php elseif(date('Y-m-d', strtotime($DateResigned2)) <= date('Y-m-d')): ?>
	<div style="text-align: justify;  text-justify: inter-word;">
		<p style="padding-top: 15px; padding-left: 50px; padding-right: 50px;">This is to certify that <b><?php echo strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?></b> is a former
			employee of <b><?php echo $emp_info[0]["CompanyName"]; ?></b> from <b><?php echo $emp_info[0]["HireDate"]; ?> to 
		<?php echo $emp_info[0]["DateResigned"]; ?> </b> with last held position of <b><?php echo $emp_info[0]["PositionDesc"]; ?>.</b></p>

		<p style="padding-left: 50px; padding-right: 50px;"><?php echo ucwords(strtolower($emp_info[0]["Gender2"])); ?> last monthly compensation are as follows:</p>
		<!-- nbsp for the pdf conversion, tcpdf doesn't support inline block, and padding. TCPDF has different implementation for tables -->
		<p style="padding-left: 50px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Basic Salary</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php if(true){echo number_format($emp_info[0]["MonthlyRate"], 2);}else{ echo ""; }; ?></b></p>
		<?php if($emp_info[0]["Allowance"] != 0){ ?>
				<p style="padding-left: 50px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Allowance</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><u><?php echo number_format($emp_info[0]["Allowance"], 2); ?></u></b></p>
				<p style="padding-left: 50px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><u><?php echo number_format($emp_info[0]["Allowance"] + $emp_info[0]["MonthlyRate"], 2); ?></u></b></p>
		<?php } ?>

		<p style="padding-left: 50px; padding-right: 50px;">In addition to the above compensation package, <?php echo strtolower($emp_info[0]["Gender"]); ?> receives the mandatory
		13th month pay during the twelve (12) month period.</p>

		<p style="padding-left: 50px; padding-right: 50px;">This document is issued upon the request of <b><?php echo $emp_info[0]["Salutation"]." ".strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?>
		<?php if($coe[0]["other_reason"]){ ?>
			for <?php echo $emp_info[0]["Gender2"]. " <i>".$coe[0]["other_reason"]; ?></i></b>.
		<?php }else{ ?>
		</b>for whatever legal purpose it may serve.
		<?php } ?>  Hence, the company hold no responsibility for any misrepresentation of facts and data  enumerated herein.</p>

		<p style="padding-left: 50px; padding-right: 50px;">Given this <?php echo date('jS')." day of ".date('F, Y'); ?> at <?php echo $companies[$emp_info[0]['CompanyID']]; ?>, Philippines.</p>
	</div>
	<?php endif; ?>
	&nbsp;
	<!-- <p style="padding-top: 15px; padding-left: 50px; padding-right: 50px;">Certified by:</p> -->

<?php
}
	?>
	<?php
		echo !$send_pdf ? '&nbsp;<br />'  : '';
	?>

	<!-- Signatory START -->
	<?php
		if($coe[0]["type"] == 'COECOMPENSATION'){

			$COEC_APPROVERS = [
				"GLOBAL01" => [
					'prepared' => [
						'name' => 'SULAT, CLARA NUÑEZ',
						'id' => '2021-02-0013',
						'designation' => 'PAYROLL ASSOCIATE',
						'esign' => 'coe_csulat.png',
						'email' => 'cnsulat.global@megaworldcorp.com'
					],
					'approver' => [
						'RFSP' => [
							'name' => 'ARLENE A. BRANCO',
							'id' => '2014-10-0004',
							'designation' => 'Payroll Manager',
							'esign' => 'coe_abranco.png',
							'email' => 'abranco@megaworldcorp.com'
						],
						'M' => [
							'name' => 'ARLENE A. BRANCO',
							'id' => '2014-10-0004',
							'designation' => 'Payroll Manager',
							'esign' => 'coe_abranco.png',
							'email' => 'abranco@megaworldcorp.com'
						],
						'AVP'=>[
							'name' => 'ARLENE A. BRANCO',
							'id' => '2014-10-0004',
							'designation' => 'Payroll Manager',
							'esign' => 'coe_abranco.png',
							'email' => 'abranco@megaworldcorp.com'
						],
						'VP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
					]
				
					],
				
				"LGMI01" => [
					'prepared' => [
						'name' => 'IRENE S. ESLIT',
						'id' => '2021-06-0163',
						'designation' => 'Payroll Analyst',
						'esign' => 'coe_ieslit.png',
						'email' => 'ieslit.global@megaworldcorp.com'
					],
					'approver' => [
						'RFSP' => [
							'name' => 'ARLENE A. BRANCO',
							'id' => '2014-10-0004',
							'designation' => 'Payroll Manager',
							'esign' => 'coe_abranco.png',
							'email' => 'abranco@megaworldcorp.com'
						],
						'M' => [
							'name' => 'ARLENE A. BRANCO',
							'id' => '2014-10-0004',
							'designation' => 'Payroll Manager',
							'esign' => 'coe_abranco.png',
							'email' => 'abranco@megaworldcorp.com'
						],
						'AVP'=>[
							'name' => 'ARLENE A. BRANCO',
							'id' => '2014-10-0004',
							'designation' => 'Payroll Manager',
							'esign' => 'coe_abranco.png',
							'email' => 'abranco@megaworldcorp.com'
						],
						'VP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
					]
				
					],

				"GLOBALHOTEL" => [
					'prepared' => [
						'name' => 'IRENE S. ESLIT',
						'id' => '2021-06-0163',
						'designation' => 'Payroll Analyst',
						'esign' => 'coe_ieslit.png',
						'email' => 'ieslit.global@megaworldcorp.com'
					],
					'approver' => [
						'RFSP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'M' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'AVP'=>[
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'VP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
					]
				
					],

				"ECOC01" => [
					'prepared' => [
						'name' => 'MA. VERONICA S. TERMULO',
						'id' => '2011-03-V837',
						'designation' => 'Payroll Supervisor', 
						'esign' => 'coe_mtermulo.png',
						'email' => 'vtermulo@megaworldcorp.com'
					],
					'approver' => [
						'RFSP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'M' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'AVP'=>[
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'VP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
					]
				
					],
					
				"MLI01" => [
					'prepared' => [
						'name' => 'MA. VERONICA S. TERMULO',
						'id' => '2011-03-V837',
							'designation' => 'Payroll Supervisor', 
							'esign' => 'coe_mtermulo.png',
							'email' => 'vtermulo@megaworldcorp.com'
					],
					'approver' => [
						'RFSP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'M' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'AVP'=>[
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'VP' => [
							'name' => 'RAMILO, LOURDES ONG',
							'id' => '1997-03-8638',
							'designation' => 'Vice President',
							'esign' => 'coe_lramilo.png',
							'email' => 'dramilo@megaworldcorp.com'
						],
					]
				
					], 
				"MREIT_FMI" => [
					'prepared' => [
						'name' => 'MA. VERONICA S. TERMULO',
						'id' => '2011-03-V837',
						'designation' => 'Payroll Supervisor', 
						'esign' => 'coe_mtermulo.png',
						'email' => 'vtermulo@megaworldcorp.com'
					],
					'approver' => [
						'RFSP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'M' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'AVP'=>[
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'VP' => [
							'name' => 'LOURDES O. RAMILO',
							'id' => '1997-03-8638',
							'designation' => 'Vice President',
							'esign' => 'coe_lramilo.png',
							'email' => 'dramilo@megaworldcorp.com'
						],
					]
				
					],

				"MREIT_INC" => [
					'prepared' => [
						'name' => 'MA. VERONICA S. TERMULO',
						'id' => '2011-03-V837',
						'designation' => 'Payroll Supervisor', 
						'esign' => 'coe_mtermulo.png',
						'email' => 'vtermulo@megaworldcorp.com'
					],
					'approver' => [
						'RFSP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'M' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'AVP'=>[
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'VP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
					]
				
					],

				"MREIT_PMI" => [
					'prepared' => [
						'name' => 'MA. VERONICA S. TERMULO',
						'id' => '2011-03-V837',
						'designation' => 'Payroll Supervisor', 
						'esign' => 'coe_mtermulo.png',
						'email' => 'vtermulo@megaworldcorp.com'
					],
					'approver' => [
						'RFSP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'M' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'AVP'=>[
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'VP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
					]
				
					],

				"Rowenta" => [
					'prepared' => [
						'name' => 'MA. VERONICA S. TERMULO',
						'id' => '2011-03-V837',
						'designation' => 'Payroll Supervisor', 
						'esign' => 'coe_mtermulo.png',
						'email' => 'vtermulo@megaworldcorp.com'
					],
					'approver' => [
						'RFSP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'M' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'AVP'=>[
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'VP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
					]
				
					],
					
				"LUCK01" => [
					'prepared' => [
						'name' => 'MA. VERONICA S. TERMULO',
						'id' => '2011-03-V837',
						'designation' => 'Payroll Supervisor', 
							'esign' => 'coe_mtermulo.png',
							'email' => 'vtermulo@megaworldcorp.com'
					],
					'approver' => [
						'RFSP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'M' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'AVP'=>[
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'VP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
					]
				
					],

				"SIRUS" => [
					'prepared' => [
						'name' => 'MA. VERONICA S. TERMULO',
						'id' => '2011-03-V837',
						'designation' => 'Payroll Supervisor', 
							'esign' => 'coe_mtermulo.png',
							'email' => 'vtermulo@megaworldcorp.com'
					],
					'approver' => [
						'RFSP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'M' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'AVP'=>[
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'VP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
					]
				
					],

				"ERA01" => [
					'prepared' => [
						'name' => 'MA. VERONICA S. TERMULO',
						'id' => '2011-03-V837',
						'designation' => 'Payroll Supervisor', 
							'esign' => 'coe_mtermulo.png',
							'email' => 'vtermulo@megaworldcorp.com'
					],
					'approver' => [
						'RFSP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'M' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'AVP'=>[
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'VP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
					]
				
					],

				"ECC02" => [
					'prepared' => [
						'name' => 'MA. VERONICA S. TERMULO',
						'id' => '2011-03-V837',
						'designation' => 'Payroll Supervisor', 
							'esign' => 'coe_mtermulo.png',
							'email' => 'vtermulo@megaworldcorp.com'
					],
					'approver' => [
						'RFSP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'M' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'AVP'=>[
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'VP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
					]
				
					],

				"CITYLINK01" => [
					'prepared' => [
						'name' => 'MA. VERONICA S. TERMULO',
						'id' => '2011-03-V837',
						'designation' => 'Payroll Supervisor', 
							'esign' => 'coe_mtermulo.png',
							'email' => 'vtermulo@megaworldcorp.com'
					],
					'approver' => [
						'RFSP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'M' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'AVP'=>[
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'VP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
					]
				
					],

				"NCCAI" => [
					'prepared' => [
						'name' => 'MA. VERONICA S. TERMULO',
						'id' => '2011-03-V837',
						'designation' => 'Payroll Supervisor', 
							'esign' => 'coe_mtermulo.png',
							'email' => 'vtermulo@megaworldcorp.com'
					],
					'approver' => [
						'RFSP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'M' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'AVP'=>[
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'VP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
					]
				
					],

				"MEGA01" => [
					'prepared' => [
						'name' => 'MAE HAZEL B. ANASTACIO',
						'id' => '2015-11-0550',
						'designation' => 'Senior Payroll Associate',
							'esign' => 'coe_manastacio.png',
							'email' => 'manastacio.global@megaworldcorp.com'
					],
					'approver' => [
						'RFSP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'M' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'AVP'=>[
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'VP' => [
							'name' => 'RAMILO, LOURDES ONG',
							'id' => '1997-03-8638',
							'designation' => 'Vice President',
							'esign' => 'coe_lramilo.png',
							'email' => 'dramilo@megaworldcorp.com'
						],
					]
				
					],

				"TOWN01" => [
					'prepared' => [
						'name' => 'MAE HAZEL B. ANASTACIO',
						'id' => '2015-11-0550',
						'designation' => 'Senior Payroll Associate',
							'esign' => 'abranco.png',
							'email' => 'manastacio.global@megaworldcorp.com'
					],
					'approver' => [
						'RFSP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'M' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'AVP'=>[
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'VP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
					]
				
					],

				"LFI01" => [
					'prepared' => [
						'name' => 'MAE HAZEL B. ANASTACIO',
						'id' => '2015-11-0550',
						'designation' => 'Senior Payroll Associate',
							'esign' => 'abranco.png',
							'email' => 'manastacio.global@megaworldcorp.com'
					],
					'approver' => [
						'RFSP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'M' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'AVP'=>[
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'VP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
					]
				
					],

				"NEWTOWN01" => [
					'prepared' => [
						'name' => 'MAE HAZEL B. ANASTACIO',
						'id' => '2015-11-0550',
						'designation' => 'Senior Payroll Associate',
							'esign' => 'abranco.png',
							'email' => 'manastacio.global@megaworldcorp.com'
					],
					'approver' => [
						'RFSP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'M' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'AVP'=>[
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'VP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
					]
				
					],

				"ASIAAPMI" => [
					'prepared' => [
						'name' => 'JERIZA MAE V. SIOCO',
						'id' => '2020-09-0022',
						'designation' => 'Payroll Manager',
						'esign' => 'coe_jsioco.png',
						'email' => 'jsioco@asia-affinity.com'
					],
					'approver' => [
						'RFSP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'M' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'AVP'=>[
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
						'VP' => [
							'name' => 'MARILOU C. GUARINA',
							'id' => '1994-03-8275',
							'designation' => 'Senior Assistant Vice President',
							'esign' => 'coe_mguarina.png',
							'email' => 'mguarina@megaworldcorp.com'
						],
					]
				
				]
			];


			?>

			<table style="width:100%; ">
				<tr width="100%">
					<?php if($emp_info[0]['CompanyID'] != 'ASIAAPMI') : ?>
					<td style="padding-left: 25px">
						<span>Prepared By:</span> 
						<br><br>
						<?php  if($send_pdf) :  ?>
						<span><img style="height: 50px" src="<?php echo IMG_WEB; ?>/coe/<?php echo $COEC_APPROVERS[$emp_info[0]['CompanyID']]
						['prepared']['esign']; ?>"/></span><br>
						<?php else: ?>
						<span><?php echo $COEC_APPROVERS[$emp_info[0]['CompanyID']]['prepared']['name']; ?></span><br>
						<span><?php echo $COEC_APPROVERS[$emp_info[0]['CompanyID']]['prepared']['designation']; ?></span>
						<?php endif; ?>
					</td>
					<?php endif; ?>
					<td style="padding-left: 25px">
						<?php
						
							$rank_approver = '';
							if(in_array($emp_info[0]['RankID'], $rfs))
								$rank_approver = 'RFSP';
							elseif(in_array($emp_info[0]['RankID'], $man))
								$rank_approver = 'M';
							elseif(in_array($emp_info[0]['RankID'], $avp))
								$rank_approver = 'AVP';
							elseif(in_array($emp_info[0]['RankID'], $vpup))
								$rank_approver = 'VP';

						?>

						<span>Certified By:</span> 
						<br><br>
						<?php  if($send_pdf) :  ?>
						<span><img style="height: 50px" src="<?php echo IMG_WEB; ?>/coe/<?php echo $COEC_APPROVERS[$emp_info[0]['CompanyID']]['approver'][$rank_approver]['esign']; ?>"/></span> <br>
						<?php else: ?>
						<span><?php 

							echo $COEC_APPROVERS[$emp_info[0]['CompanyID']]['approver'][$rank_approver]['name']; 
						
						?></span><br>
						<span>
							<?php echo $COEC_APPROVERS[$emp_info[0]['CompanyID']]['approver'][$rank_approver]['designation']; ?>
						</span>
						<?php endif; ?>

					</td>
				</tr>
			</table>

		<?php

		}else{ // HR COE
			if($coe[0]["company"] == 'MCTI'){
			?>

				<?php
				if($send_pdf){
				?>
					<img style="width: 150px" src="<?php echo IMG_WEB; ?>/coe/coe_gl.png"/>
				<?php
				}else{
				?>
				<b><p style="padding-top: 40px; <?php echo $send_pdf ? '' : 'padding-bottom: 40px;'; ?> padding-left: 50px; padding-right: 50px;">JOEY I. VILLAFUERTE<br />
				FIRST VICE PRESIDENT, CONTROLLERSHIP GROUP</p></b>
				<?php
				}
				?>

			<?php
			}elseif ($coe[0]["company"] == 'GLOBAL01' || $coe[0]["company"] == 'LGMI01' || $coe[0]["company"] == 'MIB01') {
			?>

				<?php
				if($send_pdf){
				?>
					<img style="width: 150px" src="<?php echo IMG_WEB; ?>/coe/coe_gl.png"/>
				<?php
				}else{
				?>
				<b><p style="padding-top: 40px; <?php echo $send_pdf ? '' : 'padding-bottom: 40px;'; ?> padding-left: 50px; padding-right: 50px;">JOSEPHINE A. CARBON<br />
				Associate Director</b>
				<?php
				}
				?>

			<?php
			}else{
			?>

				<?php
				if($send_pdf){
				?>
					<img style="width: 150px" src="<?php echo IMG_WEB; ?>/coe/coe_etc.png"/>
				<?php
				}else{
				?>
				<b><p style="padding-top: 40px; <?php echo $send_pdf ? '' : 'padding-bottom: 40px;'; ?> padding-left: 50px; padding-right: 50px;">RAFAEL ANTONIO S. PEREZ<br />
				Head, Human Resources and<br />
				Corporate Administration Division</p></b>
				<?php
				}
				?>

			<?php
			}
		}
		?>
	 	<!-- Signatory END -->

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

		</b><p style="font-size: <?php echo $send_pdf ? '8px' : '10px'; ?>; padding-left: 50px; padding-right: 50px;">Ref No.:<?php echo $coe[0]["ref_no"]; ?></p>

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
