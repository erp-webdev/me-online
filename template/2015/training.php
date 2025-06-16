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
                                                    
                                for($year=date('Y'); $year >= 2025; $year-- ) { ?>
                                    <option value="<?php echo $year ?>" <?php echo $yearval == $year ? ' selected' : ''; ?>><?php echo $year ?></option>    
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                </table>
                <table border="0" cellspacing="0" class="tdata width100per">
                    <thead>
                        <tr>
                            <th colspan="6" ></th>
                            <th colspan="2" >Training Bond Period </th>
                        </tr>
                        <tr>
                            <th style='text-align:center; width:4%;'>#</th>
                            <th style='text-align:center; width:15%;'>Training Date</th>
                            <th style='text-align:left; width:25%;'>Training Program</th>
                            <th style='text-align:center; width:10%;'>Category</th>
                            <th style='text-align:center; width:6%;'>Training Hours</th>
                            <th style='text-align:center; width:10%;'>Training Cost</th>
                            <th style='text-align:center; width:15%;'>Start of Bond</th>
                            <th style='text-align:center; width:15%;'>End of Bond</th>
                        </tr>
                    </thead>
                </table>
                <div id="training_data" style="max-height: 300px; overflow-y: auto;">
                    <table border="0" cellspacing="0" class="tdata width100per"  style="border-collapse: collapse;">
                        <tbody>
                        <?php $total_trainings = 0; ?>
                        <?php if ($trainings): ?>
                            <?php foreach ($trainings as $index => $training): ?>
                                <tr>
                                    <td style='text-align:center; width:4%;'><?php echo $index + 1; ?></td>
                                    <td style='text-align:center; width:15%;'><?php echo $training['TrainingDate']; ?></td>
                                    <td style='text-align:left; width:25%;'><?php echo $training['TrainingDesc']; ?></td>
                                    <td style='text-align:center; width:10%;'><?php echo $training['Category']; ?></td>
                                    <td style='text-align:center; width:6%;'><?php echo number_format($training['TrainingHrs'], 2); ?></td>
                                    <td style='text-align:center; width:10%;'><?php echo number_format($training['TrainingCost'], 2); ?></td>
                                    <td style='text-align:center; width:15%;'><?php echo $training['Bond'] ? date('Y-m-d', strtotime($training['BondStart'])) : 'NONE'; ?></td>
                                    <td style='text-align:center; width:15%;'><?php echo $training['Bond'] ? date('Y-m-d', strtotime($training['BondExpiry'])) : 'NONE'; ?></td>
                                </tr>
                                <?php $total_trainings += $training['TrainingHrs']; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" style='text-align: center;'><i>NO TRAINING RECORDS AVAILABLE</i></td>
                            </tr>
                        <?php endif; ?>
                        </tbody>

                    </table>
                </div>
                <table style='margin-top:5%' class="width100per">
                    <tr>
                        <th colspan="7" style='text-align: end; width:90%'>Total Training Hours:</th>
                        <th><?php echo number_format($total_trainings, 2); ?></th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
<?php include(TEMP."/footer.php"); ?>
