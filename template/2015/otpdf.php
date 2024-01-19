<style type="text/css">
    .doc
    {
        width: 85%;
        padding: 50px;
    }
    .title
    {
        font-weight: bold;
        font-size: 20px;        
    }
    .subtitle
    {
        font-weight: bold;
        font-size: 16px; 
        padding: 5px;
    }
    .tdata 
    {
        width: 100% !important;
        border-radius: 5px;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
    }
    .tdata th
    {
        color: #FFF;
        background-color: #333;
    }
    .tdata td, .tdata th
    {
        padding: 5px;
    }
</style>
<page style="font-size: 14px">
    <div class="doc">
        <span class="title">Overtime Form</span>
        <hr />
        <b>Request Number:</b> <?php echo $refnum; ?><br /> 
        <b>ID Number:</b> <?php echo $application_data[0]['EmpID']; ?><br /> 
        <b>Name:</b> <?php echo $appuser_data[0]['FName'].' '.$appuser_data[0]['LName']; ?><br /> 
        <b>Department:</b> <?php echo $appdept_data[0]['DeptDesc']; ?><br /> 
        <b>Date Filed:</b> <?php echo date('F j, Y | g:ia', strtotime($application_data2[0]['ReqDate'])); ?><br />         
        <hr />
        <b>DTR Date:</b> <?php echo date('F j, Y', strtotime($application_data2[0]['DtrDate'])); ?><br /> 
        <b>From:</b> <?php echo date('F j | g:ia', strtotime($application_data2[0]['FromDate'])); ?><br /> 
        <b>To:</b> <?php echo date('F j | g:ia', strtotime($application_data2[0]['ToDate'])); ?><br /> 
        <b>Type:</b> <?php echo $application_data2[0]['OTType']; ?><br />      
        <b>Applied Hours:</b> <?php echo $application_data2[0]['Hrs']; ?><br />      
        <?php if ($application_data[0]['Approved'] == 1) : ?>
        <b>Approved Hours:</b> <?php echo $application_data2[0]['ApprovedHrs'] ? $application_data2[0]['ApprovedHrs'] : 0; ?><br />      
        <?php endif; ?>
        <b>Reason:</b> <?php echo $application_data2[0]['Reason']; ?><br />      
        <br /><br /><br />
        ________________________________________<br />
        Prepared by <?php echo $requestor_data[0]['FName'].' '.$requestor_data[0]['LName']; ?> on <?php echo date('m/d/y g:ia', strtotime($application_data[0]['DateFiled'])); ?><br /><br /><br />
        <?php if (trim($application_data[0]['Signatory01'])) : ?>
        ________________________________________<br />
        <?php if (trim($application_data[0]['ApprovedDate01'])) : ?>
        Approved by <?php echo $approver_data1[0]['FName'].' '.$approver_data1[0]['LName']; ?> on <?php echo date('m/d/y g:ia', strtotime($application_data[0]['ApprovedDate01'])); ?> as Level 1<br /><br />
        <?php else : ?>
        To be approved by <?php echo $approver_data1[0]['FName'].' '.$approver_data1[0]['LName']; ?> as Level 1<br /><br /><br /><br />
        <?php endif; ?>
        <?php endif; ?>
        <?php if (trim($application_data[0]['Signatory02'])) : ?>
        ________________________________________<br />
        <?php if (trim($application_data[0]['ApprovedDate02'])) : ?>
        Approved by <?php echo $approver_data2[0]['FName'].' '.$approver_data2[0]['LName']; ?> on <?php echo date('m/d/y g:ia', strtotime($application_data[0]['ApprovedDate02'])); ?> as Level 2<br /><br />
        <?php else : ?>
        To be approved by <?php echo $approver_data2[0]['FName'].' '.$approver_data2[0]['LName']; ?> as Level 2<br /><br /><br /><br />
        <?php endif; ?>
        <?php endif; ?>
        <?php if (trim($application_data[0]['Signatory03'])) : ?>
        ________________________________________<br />
        <?php if (trim($application_data[0]['ApprovedDate03'])) : ?>
        Approved by <?php echo $approver_data3[0]['FName'].' '.$approver_data3[0]['LName']; ?> on <?php echo date('m/d/y g:ia', strtotime($application_data[0]['ApprovedDate03'])); ?> as Level 3<br /><br />
        <?php else : ?>
        To be approved by <?php echo $approver_data3[0]['FName'].' '.$approver_data3[0]['LName']; ?> as Level 3<br /><br /><br /><br />
        <?php endif; ?>
        <?php endif; ?>
        <?php if (trim($application_data[0]['Signatory04'])) : ?>
        ________________________________________<br />
        <?php if (trim($application_data[0]['ApprovedDate04'])) : ?>
        Approved by <?php echo $approver_data4[0]['FName'].' '.$approver_data4[0]['LName']; ?> on <?php echo date('m/d/y g:ia', strtotime($application_data[0]['ApprovedDate04'])); ?> as Level 4<br /><br />
        <?php else : ?>
        To be approved by <?php echo $approver_data4[0]['FName'].' '.$approver_data4[0]['LName']; ?> as Level 4<br /><br /><br /><br />
        <?php endif; ?>
        <?php endif; ?>
        <?php if (trim($application_data[0]['Signatory05'])) : ?>
        ________________________________________<br />
        <?php if (trim($application_data[0]['ApprovedDate05'])) : ?>
        Approved by <?php echo $approver_data5[0]['FName'].' '.$approver_data5[0]['LName']; ?> on <?php echo date('m/d/y g:ia', strtotime($application_data[0]['ApprovedDate05'])); ?> as Level 5<br /><br />
        <?php else : ?>
        To be approved by <?php echo $approver_data5[0]['FName'].' '.$approver_data5[0]['LName']; ?> as Level 5<br /><br /><br /><br />
        <?php endif; ?>
        <?php endif; ?>
        <?php if (trim($application_data[0]['Signatory06'])) : ?>
        ________________________________________<br />
        <?php if (trim($application_data[0]['ApprovedDate06'])) : ?>
        Approved by <?php echo $approver_data6[0]['FName'].' '.$approver_data6[0]['LName']; ?> on <?php echo date('m/d/y g:ia', strtotime($application_data[0]['ApprovedDate06'])); ?> as Level 6
        <?php else : ?>
        To be approved by <?php echo $approver_data6[0]['FName'].' '.$approver_data6[0]['LName']; ?> as Level 6
        <?php endif; ?>
        <?php endif; ?>
    </div>
</page>