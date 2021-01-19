<?php

$id = $_GET["id"];
$type = $_GET["type"];
if($_GET["send"] == "true"){
	$send_email = TRUE;
}else{
	$send_email = FALSE;
}

$sql = "SELECT * FROM COERequests WHERE id = $id";

$coe = $mainsql->get_row($sql);
$emp_id = $coe[0]['emp_id'];

$query = "SELECT top 1
			CASE
				WHEN A.GENDER = 'F' or A.GENDER = 'FEMALE' THEN 'Ms.'
				WHEN A.GENDER = 'M' or A.GENDER = 'MALE' THEN 'Mr.'
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
			A.FName+' '+SUBSTRING(A.MNAME, 1, 1)+'. '+A.LName AS FullName,
			A.Allowance,
			A.MonthlyRate,
			A.RankID,
			B.RankDesc,
			C.DeptDesc,
			D.DivisionName,
			E.PositionDesc,
			A.HireDate as HireDate,
			getdate() as CurrentDate,
			A.DateResigned as DateResigned,
			A.CompanyID,
			F.CompanyName
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

$emp_info[0]['HireDate'] = $emp_info[0]['HireDate'] ?  date('F j, Y', strtotime($emp_info[0]['HireDate'])) : null;
$emp_info[0]['CurrentDate'] = $emp_info[0]['CurrentDate'] ?  date('F j, Y', strtotime($emp_info[0]['CurrentDate'])) : null;
$emp_info[0]['DateResigned'] = $emp_info[0]['DateResigned'] ?  date('F j, Y', strtotime($emp_info[0]['DateResigned'])) : null;

ob_start();
include(TEMP.'/coe_pdf.php');
$content = ob_get_clean();

require_once(DOCUMENT.'/lib/tcpdf/tcpdf.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->SetLeftMargin(25);
$pdf->SetRightMargin(25);
$pdf->SetTopMargin(50);
$pdf->SetFont('times');
$pdf->AddPage();
$pdf->writeHTML($content);


ob_end_clean();
$file_attach = $pdf->Output('Certificate of Employment.pdf', 'E');


$message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 95%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>Certificate of Employment Request</span><br><br>Hi ,<br><br>";

$message .= "Your Certificate of Employment has been processed, Kindly see the attached file.";
$message .= "<br><br>Thanks,<br>";
$message .= SITENAME." Admin";
$message .= "<hr />".MAILFOOT."</div>";

$headers = "From: ".NOTIFICATION_EMAIL."\r\n";
$headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


$semi_rand = md5(time());

$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

$headers .= "\nMIME-Version: 1.0\n" .
    "Content-Type: multipart/mixed;\n" .
    " boundary=\"{$mime_boundary}\"";

$message = "This is a multi-part message in MIME format.\n\n" .
    "-{$mime_boundary}\n" .
    "Content-Type: text/plain; charset=\"iso-8859-1\n" .
    "Content-Transfer-Encoding: 7bit\n\n" .
    $message .= "\n\n";

$data = chunk_split(base64_encode($file_attach));

$message .= "–{$mime_boundary}\n" .
    "Content-Type: {$fileatttype};\n" .
    " name=\"{$fileattname}\"\n" .
    "Content-Disposition: attachment;\n" .
    " filename=\"{$fileattname}\"\n" .
    "Content-Transfer-Encoding: base64\n\n" .
    $data . "\n\n" .
    "-{$mime_boundary}-\n";

$emp_sendmail = mail('shart.global@megaworldcorp.com', "COE Request Update", $message, $headers);

?>
