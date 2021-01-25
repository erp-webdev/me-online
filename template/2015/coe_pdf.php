<style type="text/css">

</style>
<div id="myDivToPrint" style="display: inline-block; height: 750px;">

<?php
//R&F to AVP -- Ms Malou
$rfavp = array(
	'RF','RF II','SRF','SRF II','AS','AS II','AS III','S','S II','S III',
	'SS','SS II','SS III','AM','AM II','AM III','MGR-A','M','M II','M III',
	'SM','SM II','SM III','AVP', //end of megaworld ranks
	'RF','R001','R002','R003','R004','S005','S006','S007','S008','S','SS',
	'M009','M010','M011','M012','M','M-TTTI','SM','SM - TTTI','D013','D014',
	'AVP-TTTI','AVP' // end of GL RANKS
);
//vp & up - Ms. Lourdes
$vpup = array(
	'SAVP','FVP', //end of GL RANKS
	'SAVP', 'VP', 'EVP','SEVP','SVP','FVP','COO','D015','D016' // end of MEGA RANKS
);

$companies = [

	'GLOBAL01' => 'Makati City',
	'LGMI01' => 'Makati City',
	'MEGA01' => 'Makati City',
	'TOWN01' => '3/F Forbestown Information Center, Rizal Drive corner 26th Street, Bonifacio Global City, Taguig',
	'SUNT01' => '26th Floor, Alliance Global Tower, 36th Street cor 11th Avenue, Uptown Bonifacio',
	'NCCAI' => 'Star Cruises Centre, 100 Andrews Avenue, Newport City, Vlllamor Air Base, Pasay City, Metro Man',
	'MLI01' => '19/F Alliance Global Tower, 36th Street corner 11th Avenue, Uptown Bonifacio, Taguig City, 1634',
	'MCTI' => 'CAPITOL BOULEVARD, BARANGAY STO. NI�O, CITY OF SAN FERNANDO, PAMPANGA',
	'LUCK01' => '5F Lucky Chinatown Mall, Reina Regente St. corner Dela Reina St., Brgy. 293, Zone 28, Binondo, Manila',
	'ERA01' => '30th Floor, Alliance Global Tower, 36th Street cor 11th Avenue, Uptown Bonifacio, Taguig City',
	'ECOC01' => 'GF The World Center Building, 330 Senator Gil Puyat Avenue, Makati City',
	'CITYLINK01' => 'Ground Floor, McKinley Parking Building, Service Road 2, Mckinley Town Center, Fort Bonifacio Taguig'

];

if($coe[0]["type"] == "COEAPPROVEDLEAVE"){ // COE with Approved Leave

	$start_date = $coe[0]["leave_from"];
	$end_date = $coe[0]["leave_to"];
	$return_date = $coe[0]["leave_return"];
?>
		<h3 align="center" style="padding-top: 150px; letter-spacing: 10px;">CERTIFICATION</h3>
		&nbsp;

		<div style="text-align: justify;  text-justify: inter-word;">
			<p style="padding-top: 15px; padding-left: 50px; padding-right: 50px;">This is to certify that <b><?php echo ucwords(strtolower($emp_info[0]["Salutation"]))." ".strtoupper($emp_info[0]["FullName"]); ?></b> is currently employed with <b><?php echo $emp_info[0]["CompanyName"]; ?></b>
			as <b><?php echo $emp_info[0]["PositionDesc"]." - ".$emp_info[0]["DeptDesc"]."</b> for ".$emp_info[0]["DivisionName"]." Division Since <b>".$emp_info[0]["HireDate"]; ?>
			<?php if($emp_info[0]["DateResigned"]){ echo "to ".$emp_info[0]["DateResigned"]."</b>"; }else{ ?>
			up to the present.</b></p>
			<?php } ?>

			<p style="padding-left: 50px; padding-right: 50px;">This is to further certify that <?php echo ucwords(strtolower($emp_info[0]["salutation"]))." ".strtoupper($emp_info[0]["FullName"]); ?> shall be on leave from <b><?php echo date('F d, Y', strtotime($start_date))." to ".date('F d, Y', strtotime($end_date)); ?>
			</b>as approved by the Management. He is expected to report back for work on <b><?php echo date('F d, Y', strtotime($return_date)); ?></b>.</p>

			<p style="padding-left: 50px; padding-right: 50px;">This certification is being issued upon the request of <?php echo ucwords(strtolower($emp_info[0]["salutation"]))." ".strtoupper($emp_info[0]["FullName"]); ?>
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

		<h3 align="center" style="padding-top: 150px; letter-spacing: 10px;">CERTIFICATION</h3>
		&nbsp;

		<div style="text-align: justify;  text-justify: inter-word;">
			<p style="padding-top: 15px; padding-left: 50px; padding-right: 50px;">This certifies that <b><?php echo strtoupper($emp_info[0]["FullName"]); ?></b> is a
			<b><?php echo $emp_info[0]["PositionDesc"]."</b> under <b>".$emp_info[0]["DivisionName"]." Division</b> of <b>".$emp_info[0]["CompanyName"]."</b> since <b>".$emp_info[0]["HireDate"]; ?>
			<?php if($emp_info[0]["DateResigned"]){ echo "to ".$emp_info[0]["DateResigned"]."</b>"; }else{ ?>
			up to the present.</b></p>
			<?php } ?>

			<p style="padding-left: 50px; padding-right: 50px;">This also certifies that <b><?php echo strtoupper($emp_info[0]["FullName"])."</b> and <b>".strtoupper($coe[0]["correction_name"]); ?>
			</b>is the same person as <?php echo strtoupper($emp_info[0]["FullName"]); ?>.</p>

			<p style="padding-left: 50px; padding-right: 50px;">This certification is being issued upon the request of <?php echo ucwords(strtolower($emp_info[0]["Salutation"]))." ".strtoupper($emp_info[0]["FullName"]); ?>
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

		<h3 align="center" style="padding-top: 150px; letter-spacing: 10px;">CERTIFICATION</h3>
		&nbsp;

		<div style="text-align: justify;  text-justify: inter-word;">
			<p style="padding-top: 15px; padding-left: 50px; padding-right: 50px;">This certifies that <b><?php echo strtoupper($emp_info[0]["FullName"]); ?></b> is a
			<b><?php echo $emp_info[0]["PositionDesc"]."</b> under <b>".$emp_info[0]["DivisionName"]." Division</b> of <b>".$emp_info[0]["CompanyName"]."</b> since <b>".$emp_info[0]["HireDate"]; ?>
			<?php if($emp_info[0]["DateResigned"]){ echo "to ".$emp_info[0]["DateResigned"]."</b>"; }else{ ?>
			up to the present.</b></p>
			<?php } ?>

			<p style="padding-left: 50px; padding-right: 50px;">Furthermore, this is to certify that he is qualified for a
			<?php if($coe[0]["hpa_percent"] == '25%'){ ?>
				twenty five percent (25%)
			<?php }else if($coe[0]["hpa_percent"] == '30%'){ ?>
			 	thirty percent (30%)
			<?php }else if($coe[0]["hpa_percent"] == '35%'){ ?>
				thirty five percent (35%)
			<?php } ?>
			discount in the company's housing program as stated in our employee handbook.</p>

			<p style="padding-left: 50px; padding-right: 50px;">This certification is being issued upon the request of <?php echo ucwords(strtolower($emp_info[0]["Salutation"]))." ".strtoupper($emp_info[0]["FullName"])."
			as a requirement for the Deed of Absolute Sale of ".$emp_info[0]["Gender2"]." ".date('jS', mktime(0, 0, 0, 0, $coe[0]["avail_no"], 0)); ?> property availment under the company's housing program.</p>

			<p style="padding-left: 50px; padding-right: 50px;">Given this <?php echo date('jS')." day of ".date('F, Y'); ?> at <?php echo $companies[$emp_info[0]['CompanyID']]; ?>, Philippines.</p>
		</div>

		<?php
}elseif ($coe[0]["type"] == "COEGOODMORAL") { // COE with Good Moral
		?>

		<h3 align="center" style="padding-top: 150px; letter-spacing: 10px;">CERTIFICATION</h3>
		&nbsp;

		<div style="text-align: justify;  text-justify: inter-word;">
			<p style="padding-top: 15px; padding-left: 50px; padding-right: 50px;">This certifies that <b><?php echo strtoupper($emp_info[0]["FullName"]); ?></b> is a
			<b><?php echo $emp_info[0]["PositionDesc"]."</b> under <b>".$emp_info[0]["DivisionName"]." Division</b> of <b>".$emp_info[0]["CompanyName"]."</b> since <b>".$emp_info[0]["HireDate"]; ?>
			<?php if($emp_info[0]["DateResigned"]){ echo "to ".$emp_info[0]["DateResigned"]."</b>"; }else{ ?>
			up to the present.</b></p>
			<?php } ?>

			<p style="padding-left: 50px; padding-right: 50px;">This further certifies that <?php echo $emp_info[0]["Gender"] ?> has no derogatory record on file.</p>

			<p style="padding-left: 50px; padding-right: 50px;">This certification is being issued upon the request of <?php echo ucwords(strtolower($emp_info[0]["Salutation"]))." ".strtoupper($emp_info[0]["FullName"]); ?>
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
		<p style="text-align: center;"><img src="<?php echo IMG_WEB; ?>/gl_coe.png"/></p>

		<h3 align="center" style="padding-top: 150px; letter-spacing: 10px;">CERTIFICATION</h3>
		&nbsp;

		<div style="text-align: justify;  text-justify: inter-word;">
			<p style="padding-top: 15px; padding-left: 50px; padding-right: 50px;">This certifies that <b><?php echo strtoupper($emp_info[0]["FullName"]); ?></b> was employed as
			<b><?php echo $emp_info[0]["PositionDesc"]."</b> by <b>".$emp_info[0]["CompanyName"]."</b> from <b>".$emp_info[0]["HireDate"]; ?>
			<?php if($emp_info[0]["DateResigned"]){ echo "to ".$emp_info[0]["DateResigned"]."</b>"; }else{ ?>
			up to the present.</b></p>
			<?php } ?>

			<?php
			if ($emp_info[0]["CompanyID"] == 'GLOBAL01' || $emp_info[0]["CompanyID"] == 'LGMI01' || $emp_info[0]["CompanyID"] == 'MIB01') {
			?>
			<p style="padding-left: 50px; padding-right: 50px;">This does not certify that <?php echo $emp_info[0]["CompanyName"];?> has cleared <?php echo $emp_info[0]["Gender2"]; ?> of
			all of <?php echo $emp_info[0]["Gender2"]; ?> accountabilities with the Company.</p>
			<?php } ?>

			<p style="padding-left: 50px; padding-right: 50px;">This certification is being issued upon the request of <?php echo ucwords(strtolower($emp_info[0]["Salutation"]))." ".strtoupper($emp_info[0]["FullName"]); ?>
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

		<h3 align="center" style="padding-top: 150px; letter-spacing: 10px;">CERTIFICATION</h3>
		&nbsp;

		<div style="text-align: justify;  text-justify: inter-word;">

			<p style="padding-top: 15px; padding-left: 50px; padding-right: 50px;">This certifies that <b><?php echo strtoupper($emp_info[0]["FullName"]); ?></b> is currently employed as
			<b><?php echo $emp_info[0]["PositionDesc"]."</b> under <b>".$emp_info[0]["DivisionName"]." Division</b> of <b>".$emp_info[0]["CompanyName"]."</b> since <b>".$emp_info[0]["HireDate"]; ?>
			<?php if($emp_info[0]["DateResigned"]){ echo "to ".$emp_info[0]["DateResigned"]."</b>"; }else{ ?>
			up to the present.</b></p>
			<?php } ?>

			<p style="padding-left: 50px; padding-right: 50px;">This certification is being issued upon the request of <?php echo ucwords(strtolower($emp_info[0]["Salutation"]))." ".strtoupper($emp_info[0]["FullName"]); ?>
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
}elseif ($coe[0]["type"] == "COEJOBDESC") { // CoE with Job Description

		$tasks = json_decode($coe[0]["job_desc"], true);
		?>
			<h3 align="center" style="padding-top: 150px; letter-spacing: 10px;">CERTIFICATION</h3>
			&nbsp;

		<div style="text-align: justify;  text-justify: inter-word;">
			<p style="padding-top: 15px; padding-left: 50px; padding-right: 50px;">This certifies that <b><?php echo strtoupper($emp_info[0]["FullName"]); ?></b> was employed as
			<b><?php echo $emp_info[0]["PositionDesc"]."</b> under <b>".$emp_info[0]["DivisionName"]." Division</b> of <b>".$emp_info[0]["CompanyName"]."</b> since <b>".$emp_info[0]["HireDate"]; ?>
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

			<p style="padding-left: 50px; padding-right: 50px;">This certification is being issued upon the request of <?php echo ucwords(strtolower($emp_info[0]["Salutation"]))." ".strtoupper($emp_info[0]["FullName"]); ?>
			<?php if($coe[0]["other_reason"]){ ?>
				as a requirement for <?php echo $emp_info[0]["Gender2"]. " ".$coe[0]["other_reason"]; ?>.</p>
			<?php }else{ ?>
				for whatever legal purpose it may serve.</p>
			<?php } ?>

			<p style="padding-left: 50px; padding-right: 50px;">Given this <?php echo date('jS')." day of ".date('F, Y'); ?> at <?php echo $companies[$emp_info[0]['CompanyID']]; ?>, Philippines.</p>
		</div>
		&nbsp;<br />


		<?php
}elseif ($coe[0]["type"] == "COECOMPENSATION") { // CoE with Compensation
		?>

		<h3 align="center" style="padding-top: 150px">CERTIFICATION OF EMPLOYMENT AND COMPENSATION</h3>
		&nbsp;

		<div style="text-align: justify;  text-justify: inter-word;">
			<p style="padding-top: 15px; padding-left: 50px; padding-right: 50px;">This is to certify that <b><?php echo strtoupper($emp_info[0]["FullName"]); ?></b> is an
				employee of <b><?php echo $emp_info[0]["CompanyName"]; ?></b> since <b><?php echo $emp_info[0]["HireDate"]; ?>
			<?php if($emp_info[0]["DateResigned"]){ echo "to ".$emp_info[0]["DateResigned"].".</b>"; }else{ ?>
			</b>and presently holding a regular appointment for the position of <b><?php echo $emp_info[0]["PositionDesc"]; ?>.</b></p>
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

			<p style="padding-left: 50px; padding-right: 50px;">This document is issued upon the request of <b><?php echo ucwords(strtolower($emp_info[0]["Salutation"]))." ".strtoupper($emp_info[0]["FullName"]); ?>
			<?php if($coe[0]["other_reason"]){ ?>
				for <?php echo $emp_info[0]["Gender2"]. " <i>".$coe[0]["other_reason"]; ?></i></b>.</p>
			<?php }else{ ?>
			</b>for whatever legal purpose it may serve.</p>
			<?php } ?>

			<p style="padding-left: 50px; padding-right: 50px;">Given this <b><?php echo date('jS')." day of ".date('F, Y'); ?></b> at <?php echo $companies[$emp_info[0]['CompanyID']]; ?>, Philippines.</p>
		</div>
		&nbsp;
		<p style="padding-top: 15px; padding-left: 50px; padding-right: 50px;">Certified by:</p>

	<?php
}
	?>
	<!-- FOOTER -->
	&nbsp;<br />

	<?php

		// Signatory
		if($coe[0]["type"] == 'COECOMPENSATION'){
			if(in_array($emp_info[0]["RankID"], $vpup)){ // for vp and up
			?>
				<b><p style="padding-top: 40px; padding-left: 50px; padding-right: 50px;">LOURDES O. RAMILLO<br />
				<i>Vice President - Financial Reporting Group<i></p></b>
			<?php
			}elseif (in_array($emp_info[0]["RankID"], $rfavp)) { // for r&f to avp
			?>
				<b><p style="padding-top: 40px; padding-left: 50px; padding-right: 50px;">MARILOU C. GUARIÑA<br />
				<i>ASSISTANT VICE PRESIDENT - Payroll</i></p></b>
			<?php
			}
		}else{
			if($emp_info[0]["CompanyID"] == 'MCTI'){
			?>
				<b><p style="padding-top: 40px; padding-left: 50px; padding-right: 50px;">JOEY I. VILLAFUERTE<br />
				FIRST VICE PRESIDENT, CONTROLLERSHIP GROUP</p></b>
			<?php
			}elseif ($emp_info[0]["CompanyID"] == 'GLOBAL01' || $emp_info[0]["CompanyID"] == 'LGMI01' || $emp_info[0]["CompanyID"] == 'MIB01') {
			?>
				<b><p style="padding-top: 40px; padding-left: 50px; padding-right: 50px;">JOSEPHINE F. ALIM<br />
				Associate Director</b>
			<?php
			}else{
			?>
				<b><p style="padding-top: 40px; padding-left: 50px; padding-right: 50px;">RAFAEL ANTONIO S. PEREZ<br />
				Head, Human Resources and<br />
				Corporate Administration Division</p></b>
			<?php
			}
		}
		// End Signatory
		?>

		&nbsp;<br />

		<?php
		if($coe[0]["type"] != 'COECOMPENSATION'){
		?>
			<p style="font-size: 10px; padding-top: 15px; text-align: right; padding-right: 50px"><b>THIS DOCUMENT IS PRIVATE AND CONFIDENTIAL.<br />
			FOR EMPLOYMENT DETAILS PURPOSES ONLY.<br />
			NOT AS EMPLOYEE CLEARANCE.</b></p>
		<?php
		}
		?>

		&nbsp;<br />

		<?php
		if (($emp_info[0]["CompanyID"] == 'GLOBAL01' || $emp_info[0]["CompanyID"] == 'LGMI01' || $emp_info[0]["CompanyID"] == 'MIB01') && $coe[0]["type"] == 'COESEPARATED') {
		// COE Separated Footer
		?>
			<p style="font-size: 10px; padding-left: 50px; padding-right: 50px;">Ref No.:<?php echo $coe[0]["ref_no"]; ?></p>
			&nbsp;<br />
			<p style="font-size: 10px; text-align: center;">Unit G, Ground Floor, 331 Building, 331 Sen. Gil Puyat Avenue, Barangay Bel-Air, Makati City 1200 • Tels (632) 5411979 / 8946345 <br />
			<a href="www.globalcompanies.com.ph">www.globalcompanies.com.ph</a> • Email: <a href="globalonehr@globalcompanies.com.ph">globalonehr@globalcompanies.com.ph</a></p>
		<?php
		}else{
		// COE Others Footer
		?>
			<p style="font-size: 10px; padding-left: 50px; padding-right: 50px;">Ref No.:<?php echo $coe[0]["ref_no"]; ?></p>
		<?php
		}
		?>
	<!-- FOOTER END -->
	</div>
	<?php
