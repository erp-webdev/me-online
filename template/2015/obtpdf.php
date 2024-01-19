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
        <span class="title">Official Business Trip Form</span>
        <hr />
        <b>Request Number:</b> <?php echo $refnum; ?><br /> 
        <b>ID Number:</b> <?php echo $application_data[0]['EmpID']; ?><br /> 
        <b>Name:</b> <?php echo $appuser_data[0]['FName'].' '.$appuser_data[0]['LName']; ?><br /> 
        <b>Department:</b> <?php echo $appdept_data[0]['DeptDesc']; ?><br /> 
        <b>Date Filed:</b> <?php echo date('F j, Y | g:ia', strtotime($application_data[0]['DateFiled'])); ?><br />         
        <hr />
        <b>Date of Trip:</b> <?php echo date('F j, Y', strtotime($application_data2[0]['OBTimeINDate'])); ?><br /> 
        <b>End of Trip:</b> <?php echo date('F j, Y', strtotime($application_data2[0]['OBTimeOutDate'])); ?><br /> 
        <b>No. of Days:</b> <?php echo $application_data2[0]['Days']; ?><br /> 
        <b>Destination:</b> <?php echo $application_data2[0]['Destination']; ?><br />      
        <b>Purpose:</b> <?php echo $application_data2[0]['Reason']; ?><br />      
        <hr /><br />
        <div class="subtitle">List of OBT Applied</div>
        <table class="tdata" border="1" cellpadding="0" cellspacing="0" style="width: 100%;">
            <tr>
                <th style="width: 200px; height: 2px;">In</th>
                <th style="width: 200px; height: 2px;">Out</th>                            
            </tr>
            <?php if ($appobt_data) { ?>
            <?php foreach ($appobt_data as $key => $value) { ?>
            <tr>
                <td style="width: 200px; height: 2px;"><?php echo date("M j, Y g:ia", strtotime($value['ObTimeInDate'])); ?></td>
                <td style="width: 200px; height: 2px;"><?php echo date("M j, Y g:ia", strtotime($value['ObTimeOutDate'])); ?></td>  
            </tr>
            <?php } ?>
            <?php } ?>
        </table><br /><br /><br />
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