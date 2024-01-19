<?php

    $refnum = $_GET['id'];
              
    $application_data = $tblsql->get_notification($refnum);   
    $application_data2 = $tblsql->get_nrequest(1, $refnum);
    $appobt_data = $tblsql->get_obtdata($refnum);

    $appuser_data = $register->get_allmember($application_data[0]['EmpID']);
    $appdept_data = $mainsql->get_dept_data($appuser_data[0]['DeptID']);

    $approver_data1 = $register->get_allmember($application_data[0]['Signatory01']);
    $approver_data2 = $register->get_allmember($application_data[0]['Signatory02']);
    $approver_data3 = $register->get_allmember($application_data[0]['Signatory03']);
    $approver_data4 = $register->get_allmember($application_data[0]['Signatory04']);
    $approver_data5 = $register->get_allmember($application_data[0]['Signatory05']);
    $approver_data6 = $register->get_allmember($application_data[0]['Signatory06']);

    $requestor_data = $register->get_allmember($application_data[0]['EmpID']);

    // get the HTML
    ob_start();

    include(TEMP.'/otpdf.php');
    $content = ob_get_clean();

    // convert in PDF
    require_once(DOCUMENT.'/lib/html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'Letter', 'en');
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('obtpdf.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

?>