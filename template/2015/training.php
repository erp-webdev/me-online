<?php include(TEMP."/header.php"); ?>

<!-- BODY -->
    <div id="mainsplashtext" class="mainsplashtext lefttalign">
        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
        <div class="rightsplashtext lefttalign">
            <div id="mainnotification" class="mainbody lefttalign whitetext">
                <b class="mediumtext lorangetext">TRAINING RECORDS</b><br><br>
                <table class="marginbottom20">
                    <tr>
                        <td>Year: 
                            <select id="training_year" name="training_year" class="smltxtbox" onchange="location.href='<?php echo WEB; ?>/training?year=' + this.value;">
                                <?php 
                                    if(isset($_GET['year']))
                                        $yearval = $_GET['year'];
                                                    
                                for($year=date('Y'); $year >= 2010; $year-- ) { ?>
                                    <option value="<?php echo $year ?>" <?php echo $yearval == $year ? ' selected' : ''; ?>><?php echo $year ?></option>    
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                </table>

                <div id="training_data">
                    <table border="0" cellspacing="0" class="tdata width100per">
                        <tr>
                            <th colspan="6"> </th>
                            <th colspan="2">Training Bond Period</th>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>Training Date</th>
                            <th>Training Program</th>
                            <th>Category</th>
                            <th>Training Hours</th>
                            <th>Training Cost</th>
                            <th>Start of Bond</th>
                            <th>End of Bond</th>
                        </tr>

                        <?php if($trainings) {?>
                        <?php foreach($trainings as $index => $training) { ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo $training['DateFrom']; ?></td>
                                <td><?php echo $training['TrainingDesc']; ?></td>
                                <td><?php echo $training['Category']; ?></td>
                                <td><?php echo number_format($training['TrainingHrs'],2); ?></td>
                                <td><?php echo number_format($training['TrainingCost'], 2); ?></td>
                                <td><?php echo date('Y-m-d', strtotime('-' . number_format($training['BondDuration'],0) . ' month', strtotime($training['BondExpiry']))); ?></td>
                                <td><?php echo $training['BondExpiry']; ?></td>
                            </tr>
                            <?php $total_trainings += $training['TrainingHrs']; ?>
                        <?php }
                        } ?>
                    </table>
                    <table style='margin-top:5%' class="width100per">
                        <tr>
                            <th colspan="7" style='text-align: end;'>Total Training Hours:</th>
                            <th><?php echo $total_trainings; ?></th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php include(TEMP."/footer.php"); ?>
