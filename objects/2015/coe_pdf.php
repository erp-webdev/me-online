<?php
	require_once(DOCUMENT.'/lib/phpmailer/src/Exception.php');
	require_once(DOCUMENT.'/lib/phpmailer/src/PHPMailer.php');
	require_once(DOCUMENT.'/lib/phpmailer/src/SMTP.php');
	require_once(DOCUMENT.'/lib/tcpdf/tcpdf.php');

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	class CoePdf extends TCPDF {
		public $company;

		public function footer()
		{
			$id = $_POST["id"];
			$emp_comp = $this->company;

			$footer = '<div id="footer" style="position:absolute; bottom: 50px; text-align:center; width: 100%">';
				
			if ((in_array($emp_comp, ['GLOBAL01', 'LGMI01'])) ) {
				$footer .= '<p style="font-size: 8px; text-align: center;">Unit G, Ground Floor, 331 Building, 331 Sen. Gil Puyat Avenue, Barangay Bel-Air, Makati City 1200 • Tels (632) 5411979 / 8946345 <br />
				<a href="www.globalcompanies.com.ph">www.globalcompanies.com.ph</a> • Email: <a href="globalonehr@globalcompanies.com.ph">globalonehr@globalcompanies.com.ph</a></p>';

			} elseif (($emp_comp == 'MEGA01')) {

				$footer .= '<p style="font-size: 8px; text-align: center;">25/F Alliance Global Tower, 36th Street corner 11th Avenue Uptown Bonifacio, Taguig City 1634 <br />
				Trunkline: (632) 905-2900 • (632) 905-2800 <br />
				www.megaworldcorp.com • Email: infodesk@megaworldcorp.com</p>';

			} elseif (($emp_comp == 'MCTI') ) {
				$footer .= '<p style="font-size:8px; color: #005f2f; text-align: center;">Capitol Boulevard, Barangay Sto. Niño, City of San Fernando, Pampanga 2000 | Tels 045-963-1990<br />
				www.capitaltownpampanga.com | Email info: info@capitaltownpampanga</p>';

			} elseif (($emp_comp == 'ASIAAPMI') ) {
					$footer .= '<p style="font-size:8px; color: #005f2f; text-align: center;">6/F One World Square, Upper McKinley Road, Taguig City, NCR Philippines, 1634<br />
					Telefax No. 8524-4284 | wwww.asia-affinity.com</p>';
			}
			var_dump($footer); exit;
			$footer .= '</div>';

			$this->writeHTML($footer, false, true, false, true);
		}
	}


	if ($logged == 1 && $_POST["send"] == "true" ) {

		$id = $_POST["id"];
		$type = $_GET["type"];

		$sql = "SELECT * FROM COERequests WHERE id = $id";

		$coe = $mainsql->get_row($sql);
		$emp_id = $coe[0]['emp_id'];
		$emp_comp = $coe[0]['company'];

		$coe_status = $coe[0]['status'];
		$coetype = $coe[0]['type'];
		$coerefno = $coe[0]['ref_no'];
		$coe_updated_at = $coe[0]['updated_at'];

		if(in_array($coe_status, ['On Process', 'For Release'])){

			$datetoday = date('Y-m-d');
			$coe_update = 
			"UPDATE COERequests set status = 'Done', released_by = '$profile_idnum', released_at = GETDATE() 
			Where id = $id and released_at IS NULL";

			$coe_update = $mainsql->get_execute($coe_update);
			if(!$coe_update){
				echo "<div style='text-align: center;'><h3>There was an error in updating & sending the CoE. Please contact ISM for further assistance.</h3></div>";
				exit(0);
			}
		}

		$query = "SELECT top 1
					CASE
						WHEN A.GENDER = 'F' or A.GENDER = 'FEMALE' THEN 'MS.'
						WHEN A.GENDER = 'M' or A.GENDER = 'MALE' THEN 'MR.'
					END AS Salutation,
					CASE
						WHEN A.GENDER = 'F' or A.GENDER = 'FEMALE' THEN 'She'
						WHEN A.GENDER = 'M' or A.GENDER = 'MALE' THEN 'He'
					END AS Gender,
					CASE
						WHEN A.GENDER = 'F' or A.GENDER = 'FEMALE' THEN 'her'
						WHEN A.GENDER = 'M' or A.GENDER = 'MALE' THEN 'his'
					END AS Gender2,
					CASE
						WHEN A.GENDER = 'F' or A.GENDER = 'FEMALE' THEN 'her'
						WHEN A.GENDER = 'M' or A.GENDER = 'MALE' THEN 'him'
					END AS Gender3,
					A.FName+' '+
					 
					 CASE WHEN RTRIM(LTRIM(ISNULL(A.MNAME, ''))) <> '' 
						THEN SUBSTRING(A.MNAME, 1, 1) +  '. ' ELSE ' ' END +A.LName AS FullName,
					A.LName,
					A.Allowance,
					A.MonthlyRate,
					A.RankID,
					B.RankDesc,
					C.DeptDesc,
					D.DivisionName,
					E.PositionDesc,
					A.HireDate as HireDate,
					getdate() as CurrentDate,
					DATEADD(day, -1, A.DateResigned) as DateResigned ,
					A.CompanyID,
					F.CompanyName,
					A.Active,
					A.EmailAdd,
					A.EmailAdd2
					FROM
						viewhrempmaster A
					LEFT JOIN
						HRRank B on A.RankID = B.RankID
					LEFT JOIN
						HRDepartment C on A.DeptID = C.DeptID
					LEFT JOIN
						HRDivision D on A.DivisionID = D.DivisionID
					LEFT JOIN
						HRPosition E on A.PositionID = E.PositionID
					LEFT JOIN
						HRCompany F on A.CompanyID = F.CompanyID
					WHERE
						A.EmpID = '$emp_id'";

		$emp_info = $mainsql->get_row($query);

		if(!empty($emp_info[0]['DateResigned'])){
            if(date('Y-m-d', strtotime($emp_info[0]['DateResigned'])) > date('Y-m-d'))
                    $emp_info[0]['DateResigned'] = null;
            }
		
		$emp_info[0]['HireDate'] = $emp_info[0]['HireDate'] ?  date('F j, Y', strtotime($emp_info[0]['HireDate'])) : null;
		$emp_info[0]['CurrentDate'] = $emp_info[0]['CurrentDate'] ?  date('F j, Y', strtotime($emp_info[0]['CurrentDate'])) : null;
		$DateResigned2 = $emp_info[0]['DateResigned'] ?  date('Y-m-d', strtotime($emp_info[0]['DateResigned'])) : null;
		$emp_info[0]['DateResigned'] = $emp_info[0]['DateResigned'] ?  date('F j, Y', strtotime($emp_info[0]['DateResigned'])) : null;

		
		ob_start();
		include(TEMP.'/coe_pdf.php');
		$content = ob_get_clean();

		$pdf = new CoePdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->company = $emp_comp;

		$pdf->SetPrintHeader(false);
		$pdf->SetPrintFooter(true);
		$pdf->SetLeftMargin(25);
		$pdf->SetRightMargin(25);
		$pdf->SetTopMargin(0);
		$pdf->SetAutoPageBreak(TRUE, 0);
		$pdf->SetFont('times');
		$pdf->AddPage();
		$pdf->writeHTML($content);

		ob_end_clean();
		$file_attachment = $pdf->Output('CertificateOfEmployment.pdf', 'S');

		$email = new PHPMailer();
		$email->SetFrom(NOTIFICATION_EMAIL); //Name is optional

		$message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 95%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>Certificate of Employment Request</span><br><br>Hi,<br><br>";
		$message .= "Your Certificate of Employment ($coetype) with a Reference No. ".$coerefno." has been Done at ".date('F j, Y', strtotime($coe_updated_at)).".<br><br>";
		$message .= "Kindly see the attached file.";
		$message .= "<br><br>Thanks,<br>";
		$message .= SITENAME." Admin";
		$message .= "<hr />".MAILFOOT."</div>";

		$email->Subject   = 'CoE Request Completed';
		$email->Body      = $message;
		$email->IsHTML(true);

		if($emp_info[0]['Active']){
			// $email->AddAddress('shart.global@megaworldcorp.com');
			$email->AddAddress( $emp_info[0]['EmailAdd'] );
		}else {
			// $email->AddAddress('shart.global@megaworldcorp.com');
			$email->AddAddress( $emp_info[0]['EmailAdd2'] );
		}

		$email->AddStringAttachment($file_attachment , 'CertificateOfEmployment.pdf', 'base64', 'application/pdf');

		if($email->Send()) {
		    echo "<div style='text-align: center;'><h3>The CoE has been successfully sent to the employee.</h3></div>";
		}else {
		    echo "<div style='text-align: center;'><h3>There was an error in sending the CoE. Please contact ISM for further assistance.</h3></div>";
		}

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
?>
