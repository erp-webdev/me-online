    <?php include(TEMP."/header.php"); ?>
    <?php

// echo "TT:: " . $maxlifetime = ini_get("session.gc_maxlifetime");
     ?>
    <!-- BODY -->
        <?php date_default_timezone_set("Asia/Manila"); ?>
        <script type="text/javascript" src="<?php echo SCRIPT; ?>/addon-jqueryv2.min.js"></script>
          <script>
              $(function() {
                $( ".accordion" ).accordion({
                  heightStyle: "content"
                });
              });
          </script>
            <div id="mainsplashtext" class="mainsplashtext lefttalign">
                <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo SYSTEMNAME; ?></div>
                <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                <div class="rightsplashtext lefttalign">
                    <div id="paf" class="mainbody lefttalign whitetext">
                    
                    <style type="text/css">
                        .thr{
                            text-align: left !important;
                        }
                        .tdh{
                            color:#333;
                            background-color:#fff;
                            font-weight:bold;
                            font-size:11px;
                            opacity:.8;
                        }
                        td > a{
                            color:#fff !important;
                        }
                    </style>
                    <!-- If group exist return all the result -->
                    <?php if($group == 1) { ?>

                        <?php if(count($rater0) == 0 && count($rater1) == 0 && count($rater2) == 0 && count($rater3) == 0 && count($rater4) == 0 ) { ?>
                            <!-- check if no appraisal -->
                                <p style="text-align:center;background-color:#fff;font-weight:bold;color:#3063a4;padding:6px 0;font-size:1em;margin-top:25px;">You have no rights to view this appraisal group</p>
                        <?php } ?>

                    <!-- Check Group -->
                    <?php if(count($rater0) > 0 ) {  ?>
                    <h2 class="mediumtext lorangetext"><a href="<?php echo WEB; ?>/paf"><i class="mediumtext fa fa-arrow-left" style="color:#fff;opacity:.8;"></i></a> Ratee Score Viewer</h2>

                        <!-- Table for PAF Ratee -->
                        <?php if(count($rater0) > 1 ) { ?>
                        <div id="pafm" style="overflow-x:none;overflow-y:scroll;height:100px;">
                        <?php } ?>
                            <table class="tdata" width="99%" style="margin-top:15px;" cellspacing="0">
                        <?php foreach($rater0 as $row) { ?>
                                <?php
                                    if($row['DBNAME'] != $profile_dbname)
                                        continue;

                                 ?>

                                <tr>
                                    <th class="thr" width="180">Employee/Ratee</th>
                                    <th class="thr" width="80">Evaluator</th>
                                    <?php if($row['rempid2'] != NULL && $row['rempid2'] != 0) { ?><th class="thr" width="80">Approver2</th><?php } ?>
                                    <?php if($row['rempid3'] != NULL && $row['rempid3'] != 0) { ?><th class="thr" width="80">Approver3</th><?php } ?>
                                    <?php if($row['rempid4'] != NULL && $row['rempid4'] != 0) { ?><th class="thr" width="80">Approver4</th><?php } ?>
                                    <th class="thr" style="text-align:center !important;">Score</th>
                                    <th width="150" style="text-align:center !important;">Status</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td><?php echo ucwords(strtolower(strtoupper($row['rlname'].', '.$row['rfname']))); ?></td>
                                    <td <?php if($row['rstat1'] == 1){ echo 'style="color:#c6efce;"'; }?>><?php if($row['rstat1'] == NULL || $row['rstat1'] == 2) { echo ucwords(strtolower(strtoupper($row['r1lname']))); } else { echo '<i class="fa fa-check"></i> '.ucwords(strtolower(strtoupper($row['r1lname']))); } ?></td>
                                    <?php if($row['rempid2'] != NULL && $row['rempid2'] != 0) { ?><td <?php if($row['rstat2'] == 1){ echo 'style="color:#c6efce;"'; }?>><?php if($row['rstat2'] == NULL) { echo ucwords(strtolower(strtoupper($row['r2lname']))); } else { echo '<i class="fa fa-check"></i> '.ucwords(strtolower(strtoupper($row['r2lname']))); } ?></td><?php } ?>
                                    <?php if($row['rempid3'] != NULL && $row['rempid3'] != 0) { ?><td <?php if($row['rstat3'] == 1){ echo 'style="color:#c6efce;"'; }?>><?php if($row['rstat3'] == NULL) { echo ucwords(strtolower(strtoupper($row['r3lname']))); } else { echo '<i class="fa fa-check"></i> '.ucwords(strtolower(strtoupper($row['r3lname']))); } ?></td><?php } ?>
                                    <?php if($row['rempid4'] != NULL && $row['rempid4'] != 0) { ?><td <?php if($row['rstat4'] == 1){ echo 'style="color:#c6efce;"'; }?>><?php if($row['rstat4'] == NULL) { echo ucwords(strtolower(strtoupper($row['r4lname']))); } else { echo '<i class="fa fa-check"></i> '.ucwords(strtolower(strtoupper($row['r4lname']))); } ?></td><?php } ?>
                                    <td style="text-align:center !important;">
                                        <?php
                                            if($row['status'] == 'Completed') {
                                                echo $row['computed'];
                                            } else {
                                                echo '0';
                                            }
                                        ?>
                                    </td>
                                    <td style="text-align:center;">
                                        <?php
                                            if($row['status'] == 'Completed') {
                                                if($row['computed'] == 5) {
                                                    echo '<p style="color:#c6efce;">Exceptional</p>';
                                                } elseif($row['computed'] < 5 && $row['computed'] >= 4) {
                                                    echo '<p style="color:#c6efce;">Exceeds Expectations</p>';
                                                } elseif($row['computed'] < 4 && $row['computed'] >= 3) {
                                                    echo '<p style="color:#c6efce;">Meets Expectations</p>';
                                                } elseif($row['computed'] < 3 && $row['computed'] >= 2) {
                                                    echo '<p style="color:#c6efce;">Needs Improvement</p>';
                                                } elseif($row['computed'] < 2 && $row['computed'] >= 1) {
                                                    echo '<p style="color:#FF5656;">No Evidence of Skill</p>';
                                                }
                                            } elseif($row['rstat1'] == 1 && $row['status'] != 'Completed') {
                                                echo '<i class="fa fa-cog fa-spin"></i><span style="color:#5FFF77;"> On Process</span>';
                                            } else {
                                                echo '<p style="color:#FFA25F;"><i class="fa fa-warning"></i> Incomplete</p>';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if($row['status'] == 'Completed') {?>
                                        <a href="<?php echo WEB; ?>/pafglobal_view?groupid=<?php echo $row['gid']; ?>&appid=<?php echo $row['appid']; ?>&pafad=ratee" class="smlbtn" id="sendapp" style="float:right;margin-right:10px;background-color:#3EC2FB;">Result</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                        <?php } ?>
                            </table>
                            <!-- end of table Ratee -->
                    <?php } ?>
                    <?php if(count($rater0) > 1) { ?>
                    </div>
                    <?php } ?>


                    <?php if(count($rater1) > 0 || count($rater2) > 0 || count($rater3) > 0 || count($rater4) > 0 ) { ?>
                    <h3 class="mediumtext lorangetext"><?php if(count($rater0) == 0) { ?><a href="<?php echo WEB; ?>/paf"><i class="mediumtext fa fa-arrow-left" style="color:#fff;opacity:.8;"></i></a><?php } ?> Performance Appraisal Evaluator/Approver</h3>
                    <?php } ?>

                    <?php $counter = 0; $ratercount = array("1", "2", "3", "4"); ?>
                    <div id="tabslist">
                        <ul>
                        <?php foreach($ratercount as $c) { if(count(${"rater$c"}) > 0) { ?>
                            <?php if($c == 1){ ?>
                            <li><a href="#tabs-1">Evaluator</a></li>
                            <?php } else { ?>
                            <li><a href="#tabs-<?php echo $c; ?>">Approver<?php echo $c; ?></a></li>
                            <?php } ?>
                        <?php } } ?>
                    <!-- end of for ratercounter -->
                        </ul>
                    <?php foreach ($ratercount as $c) { if(count(${"rater$c"}) > 0) { ?>

                        <div id="tabs-<?php echo $c; ?>">
                        <!-- Table for PAF Rater 1 -->

                        <!-- Scroller start -->
                        <div id="pafm" <?php if(count(${"rater$c"}) > 0) { ?>style="overflow-x:none;overflow-y:scroll;height:365px;"<?php } ?>>

                        <?php $fin = $c-1; ?>
                        <h3><?php if($c == 1){ echo 'Evaluator'; } else { echo 'Approver '.$c; } ?></h3>

                        <table class="tdata" width="99%" style="margin-top:15px;" cellspacing="0">

                        <?php foreach(${"rater$c"} as $row) { ?>
                            <?php if(${"depdesc$c"} != $row['depdesc']) { ?>
                            <tr>
                                <td class="tdh" colspan="6"><?php echo ucwords(strtolower($row['depdesc'])); ?></td>
                            </tr>
                            <tr>
                                <th></th>
                                <th class="thr" width="180">Employee/Ratee</th>
                                <th class="thr" width="250">Position</th>
                                <th class="thr" style="text-align:center !important;" width="50">Score</th>
                                <th class="thr" style="text-align:center !important;" width="50">Percentage</th>
                                <th width="130" style="text-align:center !important;">Status</th>
                            </tr>
                            <?php ${"depdesc$c"} = $row['depdesc']; } ?>
                            <tr id="emp<?php echo $row['appid']; ?>">
                                 <td>
                                <?php if($c == 1){ ?>
                                    <?php if($row["rstat1"] == 0 || $row["rstat1"] == NULL) { ?>
                                    <a href="<?php echo WEB; ?>/pafglobal_evaluate?groupid=<?php echo $row['gid']; ?>&appid=<?php echo $row['appid']; ?>&rid=<?php echo $row['rempid']; ?>" class="smlbtn" style="float:right;margin-right:10px;">Rate</a>
                                    <?php } elseif($row["rstat1"] == 2) { ?>
                                    <a href="<?php echo WEB; ?>/pafglobal_evaluate?groupid=<?php echo $row['gid']; ?>&appid=<?php echo $row['appid']; ?>&rid=<?php echo $row['rempid']; ?>" class="smlbtn" style="float:right;margin-right:10px;">Continue</a>
                                    <?php } else { ?>
                                    <a href="<?php echo WEB; ?>/pafglobal_view?groupid=<?php echo $row['gid']; ?>&pafad=rater&sub=<?php echo $c; ?>&appid=<?php echo $row['appid']; ?>&rid=<?php echo $row['rempid']; ?>" class="smlbtn" style="float:right;margin-right:10px;background-color:#3EC2FB;">Result</a>
                                    <?php } ?>
                                <?php } else { ?>
                                    <?php switch ($c) { case 2: $x = 1; break; case 3: $x = 2; break; case 4: $x = 3; break; } ?>
                                    <?php if($row["rstat$x"] ==  1 && $row["rstat$c"] == NULL) { ?>
                                    <a href="<?php echo WEB; ?>/pafglobal_view?groupid=<?php echo $row['gid']; ?>&pafad=rater&sub=<?php echo $c; ?>&appid=<?php echo $row['appid']; ?>&rid=<?php echo $row['rempid']; ?>" class="smlbtn" style="float:right;margin-right:10px;">Evaluate</a>
                                    <?php } elseif($row["rstat$c"] == 1) { ?>
                                    <a href="<?php echo WEB; ?>/pafglobal_view?groupid=<?php echo $row['gid']; ?>&pafad=rater&sub=<?php echo $c; ?>&appid=<?php echo $row['appid']; ?>&rid=<?php echo $row['rempid']; ?>" class="smlbtn" style="float:right;margin-right:10px;background-color:#3EC2FB;">Result</a>
                                    <?php } ?>
                                <?php } ?>
                                </td>
                                <td><?php if($row['rcomm'] != NULL) { echo '<span style="color:#FCED5F;"><i class="fa fa-check"></i> '; } echo ucwords(strtolower(strtoupper($row['rlname'].', '.$row['rfname']))); if($row['rcomm'] != NULL) { echo '</span>'; } ?></td>
                                <td><?php echo $row['posdesc']; ?></td>
                                <td style="text-align:center !important;"><?php if($row['computed'] != NULL) { echo $row['computed']; } else { echo '0'; } ?></td>
                                <td style="text-align:center !important;"><?php if($row['computed'] != NULL) { $fxx = $row['computed'] / 5; echo round($fxx * 100); echo '%'; } else { echo '0'; } ?></td>
                                <td style="text-align:center;">
                                <?php
                                    if($row['status'] == 'Completed' && $row['computed'] != NULL) {
                                        if($row['computed'] == 5) {
                                            echo '<p style="color:#c6efce;">Exceptional</p>';
                                        } elseif($row['computed'] < 5 && $row['computed'] >= 4) {
                                            echo '<p style="color:#c6efce;">Exceeds Expectations</p>';
                                        } elseif($row['computed'] < 4 && $row['computed'] >= 3) {
                                            echo '<p style="color:#c6efce;">Meets Expectations</p>';
                                        } elseif($row['computed'] < 3 && $row['computed'] >= 2) {
                                            echo '<p style="color:#c6efce;">Needs Improvement</p>';
                                        } elseif($row['computed'] < 2 && $row['computed'] >= 1) {
                                            echo '<p style="color:#FF5656;">No Evidence of Skill</p>';
                                        }
                                    } elseif($row['rstat1'] == 1) {
                                        echo '<i class="fa fa-cog fa-spin"></i><span style="color:#5FFF77;"> On Process</span>';
                                    } else {
                                        echo '<p style="color:#FFA25F;"><i class="fa fa-warning"></i> Incomplete</p>';
                                    }
                                ?>
                                </td>

                            </tr>
                            <?php
                                if (($row['rempid2'] == NULL || $row['rempid2'] == 0) && ($row['rempid3'] == NULL || $row['rempid3'] == 0) && ($row['rempid4'] == NULL || $row['rempid4'] == 0)) {
                                    $auth = 'Final1';
                                    $flashRater = 1;
                                } elseif (($row['rempid2'] != NULL || $row['rempid2'] != 0) && ($row['rempid3'] == NULL || $row['rempid3'] == 0) && ($row['rempid4'] == NULL || $row['rempid4'] == 0)) {
                                    $auth = 'Final2';
                                    $flashRater = 2;
                                } elseif (($row['rempid2'] != NULL || $row['rempid2'] != 0) && ($row['rempid3'] != NULL || $row['rempid3'] != 0) && ($row['rempid4'] == NULL || $row['rempid4'] == 0)) {
                                    $auth = 'Final3';
                                    $flashRater = 3;
                                } elseif (($row['rempid2'] != NULL || $row['rempid2'] != 0) && ($row['rempid3'] != NULL || $row['rempid3'] != 0) && ($row['rempid4'] != NULL || $row['rempid4'] != 0)) {
                                    $auth = 'Final4';
                                    $flashRater = 4;
                                } else {
                                    $auth = '0';
                                    $flashRater = 0;
                                }
                             if($flashRater == $c && $c != 1) {
                            ?>
                            <tr>
                              <td colspan="6" style="width:100%;">
                                <div class="accordion">
                                <?php for ($g=1; $g < $flashRater; $g++) { ?>
                                    <h3 style="background-color:#fff;"><?php if($g == 1){ echo 'Evaluator - '; } else { echo 'Approver '.$g.' - '; } ?><?php echo ucwords(strtolower($row["r".$g."fname"])).' '.ucwords(strtolower($row["r".$g."lname"])); ?> (Comments and Recommendations)</h3>
                                    <div>
                                        <p><?php if($row["rcomm$g"] != NULL || $row["rcomm$g"] != '') { echo nl2br($row["rcomm$g"]); } else { echo 'No Comment'; } ?></p>
                                    </div>
                                <?php } ?>
                                </div>
                              </td>
                            </tr>
                            <?php } ?>
                        <?php } ?>
                        </table>

                        <!-- end of table rater -->
                            </div> <!-- Scroller end -->
                        </div>
                        <!-- end of tab -->
                    <?php } } ?>
                    <!-- end of for ratercounter -->
                    </div>

                    <!-- group -->
                    <?php } ?>

                    </div>
                </div>
            </div>
            <script>
                $(function() {
                    $( "#tabslist" ).tabs({
                        active: 0
                    });

                    $( "#tabslist" ).tabs( "option", "active", <?php echo isset($_GET[sub]) ? $_GET['sub'] - 1 : 0; ?>);
                    
                    $(document).ready(function () {
                        var target = $('#<?php echo $_GET['ref']; ?>')
                        if (target.length) {
                            $('html,body,#pafm').animate({
                                scrollTop: target.offset().top
                            }, 800);
                            return false;
                        }
                    });

                   
                });
            </script>

    <?php include(TEMP."/footer.php"); ?>
