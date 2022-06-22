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