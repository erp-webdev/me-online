<?php

    $refnum = $_GET['id'];
    $dbname = $_GET['dbname'];

    $application_data = $mainsql->get_notification($refnum, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, $dbname);
    $application_data2 = $tblsql->get_nrequest(4, $refnum);
    $appobt_data = $tblsql->get_obtdata($refnum);

    $appuser_data = $register->get_allmember($application_data[0]['EmpID']);
    $appdept_data = $mainsql->get_dept_data($appuser_data[0]['DeptID']);

    $approver_data1 = $logsql->get_allmember($application_data[0]['Signatory01'], $application_data[0]['DB_NAME01']);
    $approver_data2 = $logsql->get_allmember($application_data[0]['Signatory02'], $application_data[0]['DB_NAME02']);
    $approver_data3 = $logsql->get_allmember($application_data[0]['Signatory03'], $application_data[0]['DB_NAME03']);
    $approver_data4 = $logsql->get_allmember($application_data[0]['Signatory04'], $application_data[0]['DB_NAME04']);
    $approver_data5 = $logsql->get_allmember($application_data[0]['Signatory05'], $application_data[0]['DB_NAME05']);
    $approver_data6 = $logsql->get_allmember($application_data[0]['Signatory06'], $application_data[0]['DB_NAME06']);

    $requestor_data = $register->get_allmember($application_data[0]['EmpID']);

    // get the HTML
    ob_start();

    include(TEMP.'/obtpdf.php');
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
