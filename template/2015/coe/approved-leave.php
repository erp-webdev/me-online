<div class="title title-spaced">CERTIFICATION</div>

<p>
    This is to certify that <strong><?php 
        echo $emp_info[0]["Salutation"]." ".strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?></strong> <?php 
        if($emp_info[0]["DateResigned"]) echo 'was employed'; else echo 'is currently employed'; ?> with <strong><?php echo $emp_info[0]["CompanyName"]; ?></strong> as <strong><?php echo $emp_info[0]["PositionDesc"]." - ".$emp_info[0]["DeptDesc"]."</strong>  Since <strong>".$emp_info[0]["HireDate"]; ?> </strong> <?php if($emp_info[0]["DateResigned"]) echo 'to ' . .$emp_info[0]["DateResigned"]; else echo 'up to the present.'; ?>
</p>
<p>
    This is to further certify that <?php echo $emp_info[0]["salutation"]." ".strtoupper(mb_convert_encoding($emp_info[0]["FullName"], 'UTF-8', 'HTML-ENTITIES')); ?> shall be on leave from <b><?php echo date('F d, Y', strtotime($start_date))." to ".date('F d, Y', strtotime($end_date)); ?> </b>as approved by the Management. <?php echo $emp_info[0]["Gender"]; ?> is expected to report back for work on <b><?php echo date('F d, Y', strtotime($return_date)); ?></b>.
</p>
<p>
    This certification is being issued upon the request of <?php echo $emp_info[0]["salutation"]." ".strtoupper(mb_convert_encoding($emp_info[0]["LName"], 'UTF-8', 'HTML-ENTITIES')); ?>
                <?php if($coe[0]["other_reason"]){ ?>
                    as a requirement for <?php echo $emp_info[0]["Gender2"]. " ".$coe[0]["other_reason"]; ?>.</p>
                <?php }else{ ?>
                    for whatever legal purpose it may serve.</p>
                <?php } ?>
                <p style="padding-left: 50px; padding-right: 50px;">Given this <?php echo date('jS')." day of ".date('F, Y'); ?> at <?php echo $companies[$emp_info[0]['CompanyID']]; ?>, Philippines.
</p>
