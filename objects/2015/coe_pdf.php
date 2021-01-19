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

if($send_email){


	require_once(DOCUMENT.'/lib/tcpdf/tcpdf.php');
	// Create new PDF
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	$pdf->SetFont("helvetica", '', 10);

	$pdf->AddPage();

	// Important: this will prevent the generation of the PDF in the browser
	// as we are filling the output buffer of PHP


	// create some HTML content
	$html = '<h1>HTML Example</h1>
	<h2>List</h2>
	List example:
	<ol>
		<li><b>bold text</b></li>
		<li><i>italic text</i></li>
		<li><u>underlined text</u></li>
		<li><b>b<i>bi<u>biu</u>bi</i>b</b></li>
		<li><a href="http://www.tecnick.com" dir="ltr">link to http://www.tecnick.com</a></li>
		<li>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.<br />Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</li>
		<li>SUBLIST
			<ol>
				<li>row one
					<ul>
						<li>sublist</li>
					</ul>
				</li>
				<li>row two</li>
			</ol>
		</li>
		<li><b>T</b>E<i>S</i><u>T</u> <del>line through</del></li>
		<li><font size="+3">font + 3</font></li>
		<li><small>small text</small> normal <small>small text</small> normal <sub>subscript</sub> normal <sup>superscript</sup> normal</li>
	</ol>
	</div>';

	// Output the HTML content
	$pdf->writeHTML($html, true, false, true, false, '');

	$pdf->lastPage();
	ob_end_clean();
	$pdf->Output('example_006.pdf', 'I');


}else{
	?>
	<!-- <div style="padding-bottom: 250px;"> -->
		<!-- <center><h3>Please close print preview.</h3></center></div> -->
	<?php
	include('coe_template_request.php');
	?>
	<script>
		$(document).ready(function(){
			$(".closebutton").click();
			// $('#myDivToPrint').removeAttr("style");
			// $('#myDivToPrint').css({"display":"inline-block"});
			var divToPrint=document.getElementById("myDivToPrint");
			newWin= window.open("");
			newWin.document.write(divToPrint.outerHTML);
			var is_chrome = Boolean(newWin.chrome);

			if (is_chrome) {
				setTimeout(function() { // wait until all resources loaded
					newWin.print();
					// alert("Please close print preview.");
					newWin.close();
				}, 250);
			} else {
				newWin.print();
				newWin.close();
			}
		});
	</script>
	<?
}
?>
