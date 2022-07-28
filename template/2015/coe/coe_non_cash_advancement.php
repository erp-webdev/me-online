<h3 align="center" style="padding-top: 40px; letter-spacing: 10px;">CERTIFICATION</h3>
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
    
    <p style="padding-left: 50px; padding-right: 50px;">This certification is being issued upon the request of <?php echo ucwords(strtolower($emp_info[0]["Salutation"]))." ".ucwords(strtolower(mb_convert_encoding($emp_info[0]["LName"], 'UTF-8', 'HTML-ENTITIES'))); ?>
    for the purpose of complying with the documentary requirements for <?php echo $emp_info[0]["Gender2"]?> SSS <?php echo strtolower($coe[0]["category"]) ?> benefit claim.</p>

    <p style="padding-left: 50px; padding-right: 50px;">Given this <?php echo date('jS')." day of ".date('F Y'); ?> at <?php echo $companies[$emp_info[0]['CompanyID']]; ?>, Philippines.</p>
</div>

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