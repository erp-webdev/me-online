 <table class="width100per">
    <tr>
        <td><span class="fa fa-search"></span> Search:
            <input type="text" id="searchdtrm" name="searchdtrm" value="<?php echo $_SESSION['searchdtrm'] ? $_SESSION['searchdtrm'] : ''; ?>" placeholder="by <?php echo $profile_nadd; ?> ID, lastname or firstname" class="smltxtbox width250" />&nbsp;
            <input type="button" id="btndtrm" name="btndtrm" value="Search" class="smlbtn" />
            <input type="button" id="btndtrmall" name="btndtrmall" value="View All" class="smlbtn<?php if (!$_SESSION['searchdtrm']) : ?> invisible<?php endif; ?>" />
        </td>
    </tr>
</table>
<?php if($lmsdata): ?>
<table border="0" cellspacing="0" class="tdata width100per">

    <tr>
        <th width="15%">ID</th>
        <th width="30%">Employee</th>
        <th width="30%">Position</th>
        <th width="5%">View</th>
    </tr>

    <?php foreach($lmsdata as $data) : ?>

    <tr>
        <td><?php echo $data['EmpID']; ?></td>
        <td><?php echo $data['FullName']; ?></td>
        <td><?php echo $data['PositionDesc']; ?></td>
        <td><a href="<?php echo WEB.'/lms?subpage=employee&EmpID='.$data['EmpID'].'&db='.trim($data['DBNAME']); ?>" class="lorangetext">View</a></td>
    </tr>

    <?php endforeach; ?>

</table>
<?php endif; ?>
