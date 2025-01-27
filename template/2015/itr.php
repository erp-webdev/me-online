<?php
if (file_exists($itr_file)) {
    $file = file_get_contents($itr_file);
    header("Content-type: application/octet-stream");
    header("Content-disposition: attachment;filename=$hashed_filename");
    echo $file;
    exit;
}
?>
<?php include(TEMP . "/header.php"); ?>
<div id="mainsplashtext" class="mainsplashtext lefttalign">
    <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
    <div class="leftsplashtext lefttalign"><?php include(TEMP . "/menu.php"); ?></div>
    <div class="rightsplashtext lefttalign">

        <div id="mainnotification" class="mainbody lefttalign whitetext">
            <b class="hugetext4 lorangetext">ITR not found</b><br><br>
            <br>
            Your 2024 Income Tax Return Form (BIR 2316) was not found.
            <br><br>
            *Available only for employee who received salary for the year 2024
            <br>
            * For further inquiries, contact Payroll Department
            <!-- <br><b>For Global One Employees, your ITR will be available on 22 February 2021.</b> -->
        </div>

    </div>
</div>

<?php include(TEMP . "/footer.php"); ?>