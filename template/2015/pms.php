
<?php include(TEMP."/header.php"); ?>
<script type="text/javascript" src="<?php echo JS; ?>/axios.min.js"></script>
<div id="mainsplashtext" class="mainsplashtext lefttalign">
    <div class="topsplashtext lefttalign robotobold cattext whitetext">
        Welcome to <?php echo SYSTEMNAME; ?>
    </div>
    <div class="leftsplashtext lefttalign">
        <?php include(TEMP."/menu.php"); ?>
    </div>

    <?php if(!isset($_GET['page'])) : ?>
        <?php include(TEMP.'/pms/pms_group_listing.php'); ?>
    <?php elseif($_GET['page'] == 'eval') : ?>
        <?php include(TEMP.'/pms/pms_employee_listing.php'); ?>
    <?php elseif($_GET['page'] == 'paf') : ?>
        <?php if(isset($_GET['form'])): ?>
            <?php if($_GET['form'] == 'global') : ?>
                <?php include(TEMP.'/pms/pms_evaluation_form_global.php'); ?>
            <?php else: ?>
                <?php include(TEMP.'/pms/pms_evaluation_form_mega.php'); ?>
            <?php endif; ?>
        <?php else: ?>
            <?php include(TEMP.'/pms/pms_evaluation_form_mega.php'); ?>
        <?php endif; ?>
    <?php elseif($_GET['page'] == 'pafmega') : ?>
        <?php include(TEMP.'/pms/pms_evaluation_form_mega.php'); ?>
    <?php elseif($_GET['page'] == 'result') : ?>
        <?php if($_GET['form'] == 'global') : ?>
            <?php include(TEMP.'/pms/pms_evaluation_form_global.php'); ?>
        <?php else: ?>
            <?php include(TEMP.'/pms/pms_evaluation_form_mega.php'); ?>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php include(TEMP."/footer.php"); ?>