<!--<?php // if($rstat1 == 2) { ?>pow<?php// } ?>-->
<!-- <?php //echo "tt:: " . ini_get('session.gc_maxlifetime'); ?> -->
<?php if (count($evaluateRatee) > 0) { ?>
<b class="mediumtext lorangetext"><a href="<?php echo WEB; ?>/pafglobal?groupid=<?php echo $groupid; ?>"><i class="mediumtext fa fa-arrow-left" style="color:#fff;opacity:.8;"></i></a> Performance Appraisal Form - Supervisor/Rater</b><br><br>
<div class="print" style="overflow-x:none;overflow-y:scroll;max-height:514px;">

<form id="frm_paf" method="post" <?php //action="?ignore-page-cache=true" ?> enctype="multipart/form-data">
        <fieldset>
    <?php foreach($evaluateRatee as $row) {

        $gresp = $row['gresp'];
        $cmscore = $row['cmscore'] * 0.10;
        $apscore = $row['apscore'] * 0.10;
        $s5score = $row['s5score'] * 0.05;
        $tscore = $row['tscore'] * 0.05;

        $hrtot = $cmscore + $apscore + $s5score + $tscore; ?>

      <?php if($r1 == $r2) { $max1i = 1; ?><input type="hidden" name="final" value="Completed"><?php } else { $max1i = 2; ?><input type="hidden" name="final" value="Incomplete"><?php } ?>

      <input type="hidden" value="<?php echo $row['posid']; ?>" name="posid" />
      <input type="hidden" value="<?php echo $row['rempid']; ?>" name="rempid" />
      <input type="hidden" value="<?php echo $row['appid']; ?>" name="appid" />
      <input type="hidden" value="<?php echo $rstat1; ?>" name="checkifsave" />
      <input type="hidden" value="1" name="sub" />

      <input type="hidden" value="<?php echo $row['rfname']; ?>"  name="rname">
      <input type="hidden" value="<?php echo $row['readd']; ?>"  name="readd">
      <input type="hidden" value="<?php echo $row['r1fname']; ?>"  name="r1name">
      <input type="hidden" value="<?php echo $row['r1eadd']; ?>" name="r1eadd">
      <input type="hidden" value="<?php echo $row['r2fname']; ?>"  name="r2name">
      <input type="hidden" value="<?php echo $row['r2eadd']; ?>" name="r2eadd">
      <input type="hidden" value="<?php echo $row['r3fname']; ?>"  name="r3name">
      <input type="hidden" value="<?php echo $row['r3eadd']; ?>" name="r3eadd">
      <input type="hidden" value="<?php echo $row['r4fname']; ?>"  name="r4name">
      <input type="hidden" value="<?php echo $row['r4eadd']; ?>" name="r4eadd">

    <hr></hr>
    <table style="width:100%;">
        <thead>
            <tr>
                <th colspan="2" style="font-weight:italic;">(For <?php echo $row['randesc']; ?> Position) <span style="font-weight:normal;">*Confidential</span></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><b class="smallesttext lwhitetext">Employee Name:</b> <span style="font-weight:normal;"><?php echo ucwords(strtolower($row['rfname'].' '.$row['rlname'])); ?></span></td>
                <td><b class="smallesttext lwhitetext">Department:</b> <span style="font-weight:normal;"><?php echo ucwords(strtolower($row['depdesc'])); ?></span></td>
            </tr>
            <tr>
                <td><b class="smallesttext lwhitetext">Designation:</b> <span style="font-weight:normal;"><?php if($row['posdesc'] != NULL) { echo ucwords(strtolower($row['posdesc'])); } else { echo 'No Designated Position'; } ?></span></td>
                <td><b class="smallesttext lwhitetext">Date Hired:</b> <span style="font-weight:normal;"><?php echo date('Y-m-d', strtotime($row['hdate'])); ?></span></td>
            </tr>
            <tr>
            <td>

            <b class="smallesttext lwhitetext">Period:</b>

            <?php if( strpos(strtolower($row['Title']), 'regularization') !== false ) : ?>

            <span style="font-weight:normal;">
                From | <u><?php echo date('m-d-Y', strtotime($row['hdate'])); // echo date('Y-m-d', strtotime($row['dtfrom'])); ?></u>
                To | <u><?php if( empty($row['PermanencyDate'])) echo 'not set'; else echo date('m-d-Y', strtotime($row['PermanencyDate'])); ?></u>
            </span>

            <?php else: ?>

            <span style="font-weight:normal;">
                From | <u><?php echo date('m-d-Y', strtotime($row['perfrom'])); // echo date('Y-m-d', strtotime($row['dtfrom'])); ?></u>
                To | <u><?php echo date('m-d-Y', strtotime($row['perto']));// echo date ('Y-m-d', strtotime($row['dtto'])); ?></u>
            </span>

            <?php endif; ?>

            </td>


                <td><b class="smallesttext lwhitetext">Date Appraisal:</b> <span style="font-weight:normal;"><?php echo date('Y-m-d', strtotime($row['appdt'])); ?></span></td>
            </tr>
        </tbody>
    </table>
    <hr></hr>
    <?php } ?>

    <div style="border:2px solid #fff;padding-left:5px;width:98%;">
        <p><strong>Use the following rating scale for each relevant part of this form :</strong></p>
        <table>
            <tr>
                <td>5</td>
                <td>Exceptional</td>
                <td>Conisistently exceeds expectations in all areas under review. Clearly outstanding.</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Superior</td>
                <td>Exceeds expectations in most areas. Always meets expectations in areas under review.</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Good</td>
                <td>Fully meets expectations. Solid performer.</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Developing</td>
                <td>Meets most expectations. Needs improvments in identified areas.</td>
            </tr>
            <tr>
                <td>1</td>
                <td>Insufficient</td>
                <td>Does not meet expectations. Immediate and continuous improvement needed.</td>
            </tr>
        </table>
    </div>
    <br />

    <!-- Part 1 -->
    <div style="border:1px solid #fff;padding:0 5px;width:98%;">
        <h4>I. GENERAL RESPONSIBILITIES <span style="font-size:10px;font-weight:normal;">(Reason for position, according to job description)</span></h4>
        <?php if($gresp != NULL) { ?>
        <p style="margin-left:20px;"><?php echo $gresp; ?></p>
        <?php } else { ?>
        <p style="background-color:#fff;color:red;padding:5px;">General Responsiblity is not set by HR</p>
        <?php } ?>
    </div><!-- End of part 1 -->
    <br />

    <style type="text/css">
        .warning{
            border:1px solid #A90000;
        }
    </style>

    <?php if(count($checkWResults) > 0) { ?>
    <input type="hidden" id="globalpart3" value="1">
    <!-- Part 3 -->
    <div style="border:1px solid #fff;padding-left:5px;padding-right:5px;width:98%;">
        <h4>II. WORK RESULTS</h4>
        <div style="font-size:9px;float:left;width:30%;">
            Parameter: Achievement (%()w/ Rating)<br />
            64 below (1)<br />
            65-74 (2)<br />
            75-84 (3)<br />
            85-94 (4)<br />
            95-100 (5)
        </div>
        <div style="font-size:10px;float:left;width:70%;">
            Minimum of 3 objective according the SMART goal definition, and carried over from the last review period. Results achieved to be stated by Job Holder and commented by Reviewing Mgr. An additional objective is added in case of staff management responsibilities as "PMS". Weight is the importance of each objective versus the others. Achievement % is the volume of the objective achieved, and the rating is the quality of what has been achieved. Examples can be found in PMS Guidelines.
        </div>
        <div style="clear:both;"></div>
        <?php $countwr = 0; $countobj1 = 1; foreach ($checkWResults as $row) { $fwobj += $row['wobj']; $fwrobj += $row['wwrating'];  ?>
        <input type="hidden" name="wid[]" value="<?php echo $row['wid']; ?>">
        <div class="work-result-wrapper">
            <p style="text-decoration:underline;font-weight:bold;">OBJECTIVE <?php echo $countobj1++; ?></p>
            <!-- objectives and ratings -->
            <div style="float:left;width:380px;">
                <div style="float:left;width:380px;">
                    <p><textarea style="display:none;" name="wrp3obj[]"><?php echo $row['wrobj']; ?></textarea><?php echo $row['wrobj']; ?></p>
                    <p><span style="color:#F8FABC"><strong>Measurement of Success: </strong><?php echo $row['MOA']; ?></span></p>
                </div>
            </div>

            <div style="width:320px;float:right;font-size:9px;margin-bottom:10px;">
                <ul style="list-style-type: none;margin:0;padding: 0;font-weight:bold;">
                    <li style="display: inline;">Weight</li>
                    <li style="display: inline;padding-left:10px;">Achievement %</li>
                    <li style="display: inline;padding-left:41px;">Rating</li>
                    <li style="display: inline;padding-left:20px;">Weighted Rating</li>
                </ul>
            </div>
            <div style="width:320px;float:right;font-size:9px;">
                <input name="wrp3weight[]" type="hidden" value="<?php echo $row['wobj']; ?>" class="width25 smltxtbox calcp3w" style="width:35px;">&nbsp;&nbsp;<?php echo $row['wobj']; ?>%
                <input name="wrp3achieve[]" value="<?php echo $row['wachieve'] ?>" type="number" min="1" max="100" class="width25 smltxtbox calcp3a checker" style="width:35px;margin-left:30px;"> %</span>
                <input type="number" name="wrp3rating[]" class="width25 smltxtbox calcp3r checker" style="margin-left: 45px" min="1" max="5" value="<?php echo $row['wrating']; ?>">
               <!--  <select name="wrp3rating[]"  class="width25 smltxtbox calcp3r checker" style="margin-left:45px;">
                  <option value=""></option>
                  <option value="5" <?php if($row['wrating'] == 5) { echo 'selected'; } ?> >5</option>
                  <option value="4" <?php if($row['wrating'] == 4) { echo 'selected'; } ?> >4</option>
                  <option value="3" <?php if($row['wrating'] == 3) { echo 'selected'; } ?> >3</option>
                  <option value="2" <?php if($row['wrating'] == 2) { echo 'selected'; } ?> >2</option>
                  <option value="1" <?php if($row['wrating'] == 1) { echo 'selected'; } ?> >1</option>
                </select> -->
                <input name="wrp3wrating[]" class="wrating" type="hidden" value="<?php echo $row['wwrating'] ?>"><span style="margin-left:46px;"><?php $totalwr += $row['wwrating']; echo $row['wwrating']; ?></span>
            </div>

            <div style="clear:both;"></div>
            <!-- cooments and achievments textarea -->
            <p style="float:left;"> Results Achieved: </p>
                <input name="wrp3resachieve[]" type="text" value="<?php echo $row['wresachieve'] ?>" style="margin-left:5px;margin-top:7px;float:left;width:83%;" class="smltxtbox checker">
                <div style="clear:both;"></div>
            <p style="float:left;"> Comments: </p>
                <input name="wrp3remarks[]" type="text" value="<?php echo $row['wremarks'] ?>" style="margin-left:42px;margin-top:7px;float:left;width:83%;" class="smltxtbox checker">
                <div style="clear:both;"></div>
        </div><!-- end of work result of each objectives -->
        <hr></hr>
        <?php $countwr++; } ?>

        <!-- script for Adding new row for goals -->
        <script type="text/javascript">

               $(".calcp3a").on('input', function () {
                    var self = $(this);
                    var unitVal = self.next().val() / 100;
                    var unitWeight = self.prev().val() / 100;
                    var x1 = unitWeight * unitVal * self.val()
                    var x1fin = parseFloat(x1.toFixed(2));
                    self.next().next().val(x1fin);
                    self.next().next().next().html(x1fin);
                   fnAlltotal();
               });

               $(".calcp3r").on('change', function () {
                    var self = $(this);
                    var qtyVal = self.prev().val() / 100;
                    var unitWeight = self.prev().prev().val() / 100;
                    var x2 = unitWeight * qtyVal * self.val();
                    var x2fin = parseFloat(x2.toFixed(2));
                    self.next().val(x2fin);
                    self.next().next().html(x2fin);
                  fnAlltotal();
               });

               function fnAlltotal(){
                     var total=0
                     var pcctotal=0

                     $(".wrating").each(function(){
                          total += parseFloat($(this).val()||0);
                     });
                     var gtotal = parseFloat(total.toFixed(2));

                     $(".twrating").val(gtotal);
                     $("#twrating").html(gtotal);

                     $(".pccwrating").each(function(){
                          pcctotal += parseFloat($(this).val()||0);
                     });
                     var pccgtotal = parseFloat(pcctotal.toFixed(2));

                     $("#pccwrating").html(pccgtotal);
                     $("#fpccwrating").html(pccgtotal);

                     var compgtotal = parseFloat((gtotal * 0.35).toFixed(2));
                     var comppccgtotal = parseFloat((pccgtotal * 0.35).toFixed(2));
                     var fvperfeval = compgtotal + comppccgtotal;

                     var op = comppccgtotal + compgtotal + <?php echo $hrtot; ?>;
                     var ep = parseInt(Math.round(op / 5 * 100));

                     $("#fvperfeval").html(fvperfeval.toFixed(2));
                     $("#ftwrating").html(gtotal);
                     $("#fvtwrating").html(compgtotal.toFixed(2));
                     $("#fvtpccwrating").html(comppccgtotal.toFixed(2));
                     $("#op").html(op.toFixed(2));
                     $("#overp").val(op.toFixed(2));
                     $("#pe").html(ep);

                     var kevpartATotal = parseFloat($('#partATotal').html());
                     var kevpartBTotal = parseFloat($('#fvperfeval').text());

                     var kevgrandtotal = kevpartATotal + kevpartBTotal;

                     $("#op").html(kevgrandtotal.toFixed(2));
                     $("#overp").val(kevgrandtotal.toFixed(2));

                     var computed_score = parseFloat(kevgrandtotal.toFixed(2));
                     var reg_increase = parseFloat($('#reg_increase').val());
                     var pro_increase = parseFloat($('#pro_increase').val());
                     var inc = reg_increase;
                     var rank = $('input[name="promotion"]').data('promote');
                     var prom = $('input[name="promotion"]').val();

                     if(rank != $.trim(prom) && prom != '' && prom != undefined){
                        inc = pro_increase;
                     }

					 $('input[name="increase"]').attr({
	                     max: inc
	                 });

                     var sys_gen_inc = (computed_score / 5 ) * (inc);
                     $('#sys_gen_inc').html(sys_gen_inc.toFixed(2));

                     if(op == 5) { $('.note').hide('fast'); $('.note5').show('slow'); }
                     else if(op < 5 && op >= 4) { $('.note').hide('fast'); $('.note4').show('slow'); }
                     else if(op < 4 && op >= 3) { $('.note').hide('fast'); $('.note3').show('slow'); }
                     else if(op < 3 && op >= 2) { $('.note').hide('fast'); $('.note2').show('slow'); }
                     else if(op < 2 && op >= 1) { $('.note').hide('fast'); $('.note1').show('slow'); }
               }

               $(document).on('change', 'input[name="promotion"]', function(){
                fnAlltotal();
               });

               $(document).on("keypress", 'form', function (e) {
                    var code = e.keyCode || e.which;
                    if (code == 13) {
                        e.preventDefault();
                        return false;
                    }
                });

        </script>

        <!-- Overall work result -->
        <div style="padding:10px;margin-top:-15px;">
            <table class="tdata" cellspacing="0" style="width:180px;float:right;font-size:9px;">
                <tr>
                    <th>Final Weight</th>
                    <th style="text-align:center !important;">Final Weighted rating</th>
                </tr>
                <tr>
                    <td style="text-align:center;"><input name="totalp3w" class="smltxtbox totalp3w" style="width:33px;" type="hidden" value="0"><span id="totalp3w"><?php echo $fwobj; ?></span>%</td>
                    <td style="text-align:center;"><input name="totalp3wr" class="smltxtbox twrating" style="width:33px;" type="hidden" value="0"><span id="twrating"><?php echo $fwrobj; ?></span></td>
                </tr>
            </table>
            <h4 style="float:right;margin-top:23px;margin-right:20px;">Overall Work Results</h4>
            <div style="clear:both;"></div>
        </div><!-- end of overall work result -->
    </div><!-- End of part 3 -->
    <br />
    <!-- Computation for work results weight -->
    <?php } else { ?>
    <input type="hidden" id="globalpart3" value="">
    <table style="width:100%;">
        <tr style="background-color:#fff;">
            <td colspan="7" style="text-align:center;font-weight:bold;color:#A70606;"> Kindly inform the HR for the Part II Work Result Form </td>
        </tr>
    </table><br />
    <?php } ?>


    <?php if(count($checkRank) > 0) { ?>
    <input type="hidden" id="globalpart4" value="1">
    <!-- Part 4 Start -->
    <div style="border:1px solid #fff;padding-left:5px;padding-right:5px;width:98%;">
        <h4>III. PERSONAL CORE COMPETENCIES<span style="font-size:10px;font-weight:normal;"> (Minimum of 5 items agreed by both parties) </span></h4>

        <?php $countpcc = 1; foreach($checkRank AS $row) { ?>
        <input type="hidden" name="pccid[]" value="<?php echo $row['pccid']; ?>">
        <input type="hidden" name="pcccode[]" value="<?php echo $row['code']; ?>">
        <div class="work-result-wrapper">
            <p style="text-decoration:underline;font-weight:bold;margin-bottom:-5px;">
                <?php echo $countpcc++ ?>) <input name="pcctitle[]" type="hidden" value="<?php echo $row['competency']; ?>"><?php echo ucwords(strtolower($row['competency'])); ?>
            </p>
            <!-- objectives and ratings -->
            <div style="float:left;width:380px;">
                <p><textarea name="pccjd[]" type="hidden" style="display:none;"><?php echo $row['jd']; ?></textarea><?php echo $row['jd']; ?>&nbsp;</p>
            </div>
            <div style="width:220px;float:right;font-size:9px;margin-bottom:10px;">
                <ul style="list-style-type: none;margin:0;padding: 0;font-weight:bold;">
                    <li style="display: inline;">Weight</li>
                    <li style="display: inline;padding-left:41px;">Rating</li>
                    <li style="display: inline;padding-left:20px;">Weighted Rating</li>
                </ul>
            </div>
            <div style="width:220px;float:right;font-size:9px;">
                <input name="pccweight[]" style="width:35px;" type="hidden" value="<?php echo $row['gweight']; ?>" class="width25 smltxtbox pccweight"><?php $totalw += $row['gweight']; echo '&nbsp;&nbsp;'.$row['gweight']; ?>%
                    <input type="number" name="pccrate[]" style="margin-left:50px;" class="width25 smltxtbox pccrate checker" min="1" max="5" value="<?php echo $row['grating']; ?>">
               <!--  <select name="pccrate[]" style="margin-left:50px;" class="width25 smltxtbox pccrate checker">
                  <option value=""></option>
                  <option value="5" <?php if($row['grating'] == 5) { echo 'selected'; } ?> >5</option>
                  <option value="4" <?php if($row['grating'] == 4) { echo 'selected'; } ?> >4</option>
                  <option value="3" <?php if($row['grating'] == 3) { echo 'selected'; } ?> >3</option>
                  <option value="2" <?php if($row['grating'] == 2) { echo 'selected'; } ?> >2</option>
                  <option value="1" <?php if($row['grating'] == 1) { echo 'selected'; } ?> >1</option>
                </select> -->
                <input  name="pccwrating[]" class="pccwrating" type="hidden" value="<?php echo $row['gwrating']; ?>"><span style="margin-left:46px;"><?php $totalpcc += $row['gwrating']; echo $row['gwrating']; ?></span>
            </div>
            <div style="width:710px;float:left;">
            <!-- cooments and achievments textarea -->
            Comments:
            <span class="px" style="<?php if($row['grating'] == 3){ ?>display:none;<?php } ?>font-style:italic;margin-left:5px;font-size:10px;">(*Required field, if your rating is greater than or less than 3 to justify your rating to this employee)</span>
            <input name="pccremarks[]" type="text" style="position:relative;margin-top:2px;float:left;width:98.8%;" class="smltxtbox <?php if($row['grating'] != 3){ ?>checker<?php } ?>" value="<?php echo $row['remarks'] ?>">
            </div>
            <div style="clear:both;"></div>

        </div><!-- end of work result of each objectives -->
        <hr></hr>
        <?php } ?>

        <!-- script for goalsls -->
        <script type="text/javascript">

                $(".pccrate").on('change', function () {
                    var pccself = parseFloat($(this).val());
                    var self = $(this);
                    var qtyVal = parseFloat(self.prev().val()) / 100;
                    var x1pcc = parseFloat(qtyVal * self.val());
                    var x1pccfin = parseFloat(x1pcc.toFixed(2));
                    self.next().val(x1pccfin);
                    self.next().next().html(x1pccfin);

                    if(pccself != 3){
                        //$('p').find('p').css('display','block');
                        //var newreq = pccg.next().next().next().next().show('slow');
                        $(this).parent().next('div').find('span').show("fast");
                        $(this).parent().next('div').find('input:text').addClass('checker');
                        //newreq.next().addClass('checker');
                    } else {
                        //var newreq = self.next().next().next().next().hide('slow');
                        $(this).parent().next('div').find('span').hide("fast");
                        var inputer = $(this).parent().next('div').find('input:text').removeClass('checker');
                        inputer.css("background-color", "#fff");
                        //$(this).parent().next('div').find('input:text').addClass('smltxtbox');
                        //newreq.next().removeClass('checker');
                    }

                  fnAlltotalpcc();
                });

                function fnAlltotalpcc(){
                     var total=0
                     var pcctotal=0

                     $(".wrating").each(function(){
                          total += parseFloat($(this).val()||0);
                     });
                     var gtotal = parseFloat(total.toFixed(2));

                     $(".twrating").val(gtotal);
                     $("#twrating").html(gtotal);

                     $(".pccwrating").each(function(){
                          pcctotal += parseFloat($(this).val()||0);
                     });
                     var pccgtotal = parseFloat(pcctotal.toFixed(2));

                     $("#pccwrating").html(pccgtotal);
                     $("#fpccwrating").html(pccgtotal);

                     var compgtotal = gtotal * 0.35;
                     var comppccgtotal = pccgtotal * 0.35;
                     var fvperfeval = compgtotal + comppccgtotal;

                     var op = comppccgtotal + compgtotal + <?php echo $hrtot; ?>;
                     var ep = parseInt(Math.round(op / 5 * 100));

                     $("#fvperfeval").html(fvperfeval.toFixed(2));
                     $("#ftwrating").html(gtotal);
                     $("#fvtwrating").html(compgtotal.toFixed(2));
                     $("#fvtpccwrating").html(comppccgtotal.toFixed(2));
                     $("#op").html(op.toFixed(2));
                     $("#overp").val(op.toFixed(2));
                     $("#pe").html(ep);

                     var kevpartATotal = parseFloat($('#partATotal').html());
                     var kevpartBTotal = parseFloat($('#fvperfeval').text());

                     var kevgrandtotal = kevpartATotal + kevpartBTotal;

                     var computed_score = parseFloat(kevgrandtotal.toFixed(2));
                     var reg_increase = parseFloat($('#reg_increase').val());
                     var pro_increase = parseFloat($('#pro_increase').val());
                     var inc = reg_increase;
                     var rank = $('input[name="promotion"]').data('promote');
                     var prom = $('input[name="promotion"]').val();

                     if(rank != $.trim(prom) && prom != '' && prom != undefined){
                        inc = pro_increase;
                     }

					 $('input[name="increase"]').attr({
	                     max: inc
	                 });

                     var sys_gen_inc = (computed_score / 5 ) * (inc);
                     $('#sys_gen_inc').html(sys_gen_inc.toFixed(2));

                     $("#op").html(kevgrandtotal.toFixed(2));
                     $("#overp").val(kevgrandtotal.toFixed(2));

                     if(op == 5) { $('.note').hide('fast'); $('.note5').show('slow'); }
                     else if(op < 5 && op >= 4) { $('.note').hide('fast'); $('.note4').show('slow'); }
                     else if(op < 4 && op >= 3) { $('.note').hide('fast'); $('.note3').show('slow'); }
                     else if(op < 3 && op >= 2) { $('.note').hide('fast'); $('.note2').show('slow'); }
                     else if(op < 2 && op >= 1) { $('.note').hide('fast'); $('.note1').show('slow'); }
                }

                $(document).on('input[name="promotion"]', '.promotion', function(event) {
                 fnAlltotalpcc();
                });

        </script>

        <!-- Overall work result -->
        <div style="padding:5px;">
            <table class="tdata" cellspacing="0" style="width:220px;float:right;font-size:9px;">
                <tr>
                    <th>Final Weight</th>
                    <th style="text-align:center !important;">Final Weighted rating</th>
                </tr>
                <tr>
                    <td style="text-align:center;"><?php echo $totalw; ?>%</td>
                    <td style="text-align:center;"><span id="pccwrating"><?php echo $totalpcc; ?></span></td>
                </tr>
            </table>
            <h4 style="float:right;margin-top:12px;margin-right:20px;">Overall Personal Core Comptencies</h4>
            <div style="clear:both;"></div>
        </div><!-- end of overall work result -->
    </div><!-- End of part 4 -->
    <br />

    <?php } else { ?>
    <input type="hidden" id="globalPart4" value="">
    <table style="width:100%;">
        <tr style="background-color:#fff;">
            <td colspan="7" style="text-align:center;font-weight:bold;color:#A70606;"> Kindly inform the HR for the Part III Personal Core Competency Assessment Form </td>
        </tr>
    </table><br />
    <?php } ?>

    <!-- Part 5 start -->
    <div style="border:1px solid #fff;padding-left:5px;padding-right:5px;width:98%;">
        <h4>IV. SETTING OBJECTIVES FOR NEXT REVIEW PERIOD</h4>
        <p style="font-weight:bold;">WORK RESULTS <span style="font-weight:normal;">(Minimum 3 SMART objectives and potential PMS, set by Reviewing Manager)</span></p>

        <div class="work-result-wrapper" id="partvwrap">
            <div id="partvwork">

            <?php if($checkifsave == 2) { ?>
               <?php $countcswr = 1; if(count($checksetwr) > 0) { foreach ($checksetwr as $row) { ?>
                  <p style="text-decoration:underline;font-weight:bold;">
                      OBJECTIVE <?php echo $countcswr++; ?>
                  </p>
                  <!-- objectives and ratings -->
                  <div style="float:left;width:380px;">
                      <textarea name="setobj[]" style="width:167%;" class="checker"><?php echo $row['Objective']; ?></textarea>
                  </div>
                  <div style="width:60px;float:right;font-size:9px;">
                      <p style="font-weight:bold;">Weight</p>
                      <input name="setweight[]" style="width:35px;" type="number" value="<?php $setw += $row['Weight']; echo $row['Weight'] ?>" min="1" max="100" class="width25 smltxtbox p5w checker"> %
                  </div>
                  <div style="clear:both;"></div>

                  <!-- cooments and achievments textarea -->
                  <div style="margin-top:-15px;">
                  <p> Measurement of accomplishment: </p>
                      <input name="setmoa[]" type="text" value="<?php echo $row['MOA'] ?>" style="margin-top:-8px;width:89%;" class="smltxtbox checker">
                      <div style="clear:both;"></div>
                  </div>
                  <hr></hr>
               <?php } ?>
               <?php } else { ?>
                  <?php for ($i=1; $i <= 3; $i++) { ?>
                  <p style="text-decoration:underline;font-weight:bold;">
                      OBJECTIVE <?php echo $countcswr++; ?>
                  </p>
                  <!-- objectives and ratings -->
                  <div style="float:left;width:380px;">
                      <textarea name="setobj[]" style="width:167%;" class="checker"></textarea>
                  </div>
                  <div style="width:60px;float:right;font-size:9px;">
                      <p style="font-weight:bold;">Weight</p>
                      <input name="setweight[]" style="width:35px;" type="number" min="1" max="100" class="width25 smltxtbox p5w checker"> %
                  </div>
                  <div style="clear:both;"></div>

                  <!-- cooments and achievments textarea -->
                  <div style="margin-top:-15px;">
                  <p> Measurement of accomplishment: </p>
                      <input name="setmoa[]" type="text" style="margin-top:-8px;width:89%;" class="smltxtbox checker">
                      <div style="clear:both;"></div>
                  </div>
                  <hr></hr>
               <?php } ?>
               <?php } ?>
            <?php } else { ?>
               <?php for ($i=1; $i <= 3; $i++) { ?>
                  <p style="text-decoration:underline;font-weight:bold;">
                      OBJECTIVE <?php echo $i; ?>
                  </p>
                  <!-- objectives and ratings -->
                  <div style="float:left;width:380px;">
                      <textarea name="setobj[]" style="width:167%;" class="checker"></textarea>
                  </div>
                  <div style="width:60px;float:right;font-size:9px;">
                      <p style="font-weight:bold;">Weight</p>
                      <input name="setweight[]" style="width:35px;" type="number" min="1" max="100" class="width25 smltxtbox p5w checker"> %
                  </div>
                  <div style="clear:both;"></div>

                  <!-- cooments and achievments textarea -->
                  <div style="margin-top:-15px;">
                  <p> Measurement of accomplishment: </p>
                      <input name="setmoa[]" type="text" style="margin-top:-8px;width:89%;" class="smltxtbox checker">
                      <div style="clear:both;"></div>
                  </div>
                  <hr></hr>
               <?php } ?>
            <?php } ?>

            </div>
        </div><!-- end of work result of each objectives -->
        <a class="smlbtn" id="addrowv" style="background-color:#3EC2FB;" >Add Objective</a>
        <a class="smlbtn" id="delrowv" style="background-color:#D20404;" >Remove Objective</a>
        <!-- Overall work result -->
        <div style="margin-top:-20px;">
            <table class="tdata" cellspacing="0" style="width:100px;float:right;font-size:9px;">
                <tr>
                    <th>Total Weight</th>
                </tr>
                <tr>
                    <td style="text-align:center;"><input name="totalp5w" type="hidden" value="<?php echo $setw; ?>" class="totalp5w"><span id="totalp5w"><?php echo $setw; ?></span>%</td>
                </tr>
            </table>
            <div style="clear:both;"></div>
        </div><!-- end of overall work result -->
        <!-- script for Adding new row for goals -->
        <script type="text/javascript">
            $(document).ready(function(){
                var counter = <?php if($checkifsave){ echo $countcswr; } else{ echo '4'; } ?>;
                $("#addrowv").click(function () {
                    if(counter>50){
                        //alert("Only 10 textboxes allow");
                        return false;
                    }
                var newTextBoxDiv = $(document.createElement('div'))
                     .attr("id", 'partvwork' + counter);

                newTextBoxDiv.after().html('<p style="text-decoration:underline;font-weight:bold;">' +
                        'OBJECTIVE ' + counter +
                    '</p>' +
                    '<div style="float:left;width:380px;">' +
                        '<textarea name="setobj[]" style="width:167%;" class="checker"></textarea>' +
                    '</div>' +
                    '<div style="width:60px;float:right;font-size:9px;">' +
                        '<p style="font-weight:bold;">Weight</p>' +
                        '<input name="setweight[]" style="width:35px;" type="number" min="1" max="100" class="width25 smltxtbox p5w checker"> %' +
                    '</div>' +
                    '<div style="clear:both;"></div>' +
                    '<div style="margin-top:-15px;">' +
                    '<p> Measrement of accomplishment: </p>' +
                        '<input name="setmoa[]" type="text" style="margin-top:-8px;width:89%;" class="smltxtbox checker">' +
                        '<div style="clear:both;"></div>' +
                    '</div>' +
                    '<hr></hr>');
                newTextBoxDiv.appendTo("#partvwrap");
                counter++;
                });

                $("#delrowv").click(function(){
                    if(counter == <?php if($checkifsave){ echo count($checksetwr) + 1; } else{ echo '4'; } ?>)
                    {
                        //alert("No more forms to remove");
                        return false;
                    }
                        counter--;
                        $("#partvwork" + counter).remove();
                });

                $(document).on('change', 'input', function(){
                    var totalp5w = 0;
                    $('.p5w').each(function(){
                        if($(this).val() != '')
                        {
                            totalp5w += parseInt($(this).val());
                        }
                    });
                    $('#totalp5w').html(totalp5w);
                    $('.totalp5w').val(totalp5w);
                    if (totalp5w > 100) {
                        //$('#errdialog').prop('title', 'Error');
                        $('#errorp').html('Setting objectives for next review period total weight must be equals to 100%');
                        $( "#errdialog" ).dialog({
                            title: "Error in Part 5"
                        });
                        return false;
                    }
                });
            });
            $(document).on("keypress", 'form', function (e) {
                var code = e.keyCode || e.which;
                if (code == 13) {
                    e.preventDefault();
                    return false;
                }
            });
        </script>

        <!-- Overall work result -->
        <div>
            <h4>PERSONAL CORE COMPETENCIES <span style="font-size:10px;font-weight:normal;">(Minimum of 5 items agreed by both parties)</span></h4>
            <div class="pcc-main-wrapper">

                  <!-- for 1 to 5 pcc -->
                  <div class="pcc-left-wrapper" style="float:left;width:49%;">
                     <table>
                        <tr>
                            <th style="width:300px;"></th>
                            <th style="width:20px;text-align:center;border:1px solid #fff;font-size:8px;">Weight</th>
                        </tr>
                  <?php foreach($checkpcc as $row) {  ?>
                        <?php if($row['Order'] <= 5){ ?>
                           <tr>
                               <td style="text-align:right;"> <?php echo $row['Order']; ?>. <input name="setpccname[]" type="text" value="<?php echo $row['Competency']; ?>" class="smltxtbox" style="width:245px;" readonly></td>
                               <td><input name="setpccw[]" type="number" value="<?php $w1 += $row['Weight']; echo $row['Weight']; ?>" min="0" max="100" class="smltxtbox calcp5w checker" style="width:35px;"></td>
                           </tr>
                        <?php } ?>
                  <?php } ?>
                     </table>
                  </div>

                  <!-- for 6 to 10 pcc -->
                  <div class="pcc-right-wrapper" style="float:left;width:49%;">
                     <table>
                        <tr>
                            <th style="width:300px;"></th>
                            <th style="width:20px;text-align:center;border:1px solid #fff;font-size:8px;">Weight</th>
                        </tr>
                        <?php foreach($checkpcc as $row) { ?>
                           <?php if($row['Order'] > 5 && $row['Order'] <= 10){ ?>
                                 <tr>
                                     <td style="text-align:right;"> <?php echo $row['Order']; ?>. <input name="setpccname[]" type="text" value="<?php echo $row['Competency']; ?>" class="smltxtbox" style="width:245px;" <?php if($row['Order'] == '9' || $row['Order'] == '10') { } else { ?>readonly<?php } ?>></td>
                                     <td><input name="setpccw[]" value="<?php $w2 += $row['Weight']; echo $row['Weight']; ?>" type="number" min="0" max="100" class="smltxtbox calcp5w <?php if($row['Order'] != 9 && $row['Order'] != 10) { ?>checker<?php } ?>" style="width:35px;"></td>
                                 </tr>
                           <?php } ?>
                        <?php } ?>
                        <?php if(count($checkpcc) != 10):  ?>
                                <?php for($i = count($checkpcc) + 1; $i <= 10; $i++): ?>
                                <tr>
                                    <td style="text-align:right;"> <?php echo $i; ?>. <input name="setpccname[]" type="text" value="" class="smltxtbox" style="width:245px;"></td>
                                    <td><input name="setpccw[]" value="" type="number" min="0" max="100" class="smltxtbox calcp5w" style="width:35px;"></td>
                                </tr>
                                <?php endfor; ?>
                            <?php endif; ?>
                        <tr>
                            <td style="text-align:right;">Total Weight: </td>
                            <td style="text-align:center;"><input type="hidden" class="totalp5w2" value="<?php echo $w1 + $w2; ?>" ><span id="totalp5w2"><?php echo $w1 + $w2; ?></span>%</td>
                        </tr>
                     </table>
                  </div>
                <div style="clear:both;"></div>
            </div> <!-- end of pcc main wrapper -->
            <hr></hr >
            <h4 style="margin-top:5px;">Comments on next year's objectives :</h4>
            <textarea name="nobjective" style="width:99%;" class="smltxtbox checker"><?php echo $nobj; ?></textarea>

        </div><!-- end of overall work result -->
    </div><!-- End of part 5 -->
    <br />

    <!-- Computation for work results weight -->
    <script type="text/javascript">
        $(document).on('change', 'input', function(){
            var calcp5w = 0;
            $('.calcp5w').each(function(){
                if($(this).val() != '')
                {
                    calcp5w += parseInt($(this).val());
                }
            });
            $('#totalp5w2').html(calcp5w);
            $('.totalp5w2').val(calcp5w);
            if (calcp5w > 100) {
                //$('#errdialog').prop('title', 'Error');
                $('#errorp').html('Personal core competencies total weight must be equals to 100%');
                $( "#errdialog" ).dialog({
                    title: "Error in Part 5"
                });
                return false;
            }
        });
    </script>

     <?php foreach($evaluateRatee AS $row) { ?>
        <?php
            if(($row['cmscore'] != NULL) && ($row['apscore'] != NULL) && ($row['S5Score'] != NULL) && ($row['tscore'] != NULL)){
            $cmscore = $row['cmscore'] * 0.10;
            $apscore = $row['apscore'] * 0.10;
            $s5score = $row['S5Score'] * 0.05;
            $tscore = $row['tscore'] * 0.05;
            $cmcomment = $row['CMComment'];
            $apcomment = $row['APComment'];
        ?>
        <input type="hidden" id="globalhr" value="1">
        <table style="border:1px solid #fff;width:99.6%;">
            <thead>
            <tr>
                <th style="text-align:left;width:350px;">A. HR RELATED EVALUATION - 30%</th>
                <th style="text-align:center;">% Value</th>
                <th style="text-align:center;">Rate</th>
                <th style="text-align:center;">Final Value</th>
            </tr>
            </thead>
            <tr>
                <td>Conduct and Compliance to the company policy <br>
                <td style="text-align:center;">10%</td>
                <td style="text-align:center;"><?php echo $row['cmscore']; ?></td>
                <td style="text-align:center;"><?php echo $cmscore; ?></td>
            </tr>
            <tr>
                <td>Attendance and Punctuality <br>
                <td style="text-align:center;">10%</td>
                <td style="text-align:center;"><?php echo $row['apscore']; ?></td>
                <td style="text-align:center;"><?php echo $apscore; ?></td>
            </tr>
            <tr>
                <td>Compliance to the 5S + 2 Process</td>
                <td style="text-align:center;">5%</td>
                <td style="text-align:center;"><?php echo $row['S5Score']; ?></td>
                <td style="text-align:center;"><?php echo $s5score; ?></td>
            </tr>
             <tr>
                <td>Learning and Development</td>
                <td style="text-align:center;">5%</td>
                <td style="text-align:center;"><?php echo $row['tscore']; ?></td>
                <td style="text-align:center;"><?php echo $tscore; ?></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align:center;"></td>
                <td style="text-align:right;font-weight:bold;">Total:</td>
                <td style="text-align:center;border-top:1px solid #fff;" id="partATotal">
                    <?php
                        echo $ffinal1 = $cmscore + $apscore + $s5score + $tscore;
                    ?></td>
            </tr>

        </table>
        <?php // if($checkifsave == 2) { ?>
        <h4 style="text-align:center;"> Final Summary </h4>
        <table style="border:1px solid #fff;width:99%;">
            <thead>
            <tr>
                <th style="text-align:left;width:350px;">B. PERFORMANCE EVALUATION - 70%</th>
                <th style="text-align:center;">% Value</th>
                <th style="text-align:center;">Rate</th>
                <th style="text-align:center;">Final Value</th>
            </tr>
            </thead>
            <tr>
                <td>PART II - Work Results </td>
                <td style="text-align:center;">35%</td>
                <td style="text-align:center;"><span id="ftwrating"><?php echo $totalwr; ?></span></td>
                <td style="text-align:center;"><span id="fvtwrating"><?php echo $s1 = round($totalwr * 0.35, 2); ?></span></td>
            </tr>
            <tr>
                <td>PART III - Personal Core Competencies</td>
                <td style="text-align:center;">35%</td>
                <td style="text-align:center;"><span id="fpccwrating"><?php echo $totalpcc; ?></span></td>
                <td style="text-align:center;"><span id="fvtpccwrating"><?php echo $s2 = round($totalpcc * 0.35, 2); ?></span></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align:center;"></td>
                <td style="text-align:right;font-weight:bold;">Total:</td>
                <td style="text-align:center;border-top:1px solid #fff;"><span id="fvperfeval"><?php echo $ffinal2 = round($s1 + $s2, 2); ?></span></td>
            </tr>

            <tr>
                <td style="font-weight:bold;text-align:right;">Overall Performance : </td>
                <td style="text-align:center;"><input name="op" type="hidden" value="<?php echo round($ffinal1 + $ffinal2, 2); ?>" id="overp" ><span id="op"><?php echo $grandtotal = round($ffinal1 + $ffinal2, 2); ?></span></td>
                <td style="text-align:center;"></td>
                <td style="text-align:center;"></td>
            </tr>

            <tr>
                <!--<td style="font-weight:bold;text-align:right;">Percentage Equivalent : </td>-->
                <!--<td style="text-align:center;"><span id="pe">0</span>%</td>-->
                 <?php if($grandtotal == 5) { $disp5 = "display:block;"; } else { $disp5 = "display:none;"; } ?>
                 <?php if($grandtotal < 5 && $grandtotal >= 4) { $disp4 = "display:block;"; } else { $disp4 = "display:none;"; } ?>
                 <?php if($grandtotal < 4 && $grandtotal >= 3) { $disp3 = "display:block;"; } else { $disp3 = "display:none;"; } ?>
                 <?php if($grandtotal < 3 && $grandtotal >= 2) { $disp2 = "display:block;"; } else { $disp2 = "display:none;"; } ?>
                 <?php if($grandtotal < 2 && $grandtotal >= 1) { $disp1 = "display:block;"; } else { $disp1 = "display:none;"; } ?>
                 <?php if($grandtotal == 0) { $disp0 = "display:block;"; } else { $disp0 = "display:none;"; } ?>
                <td style="text-align:center;background-color:#fff;font-weight:bold;color:#06A716;" colspan="4">
                  <p class="note5 note" style="<?php echo $disp5; ?>color:#06A716;">(<i class="fa fa-thumbs-up"></i>) This Employee is Exceptional</p>
                  <p class="note4 note" style="<?php echo $disp4; ?>color:#06A716;">(<i class="fa fa-thumbs-up"></i>) This Employee Exceeds Expectations</p>
                  <p class="note3 note" style="<?php echo $disp3; ?>color:#06A716;">(<i class="fa fa-thumbs-up"></i>) This Employee Meets Expectations</p>
                  <p class="note2 note" style="<?php echo $disp2; ?>color:#06A716;">(<i class="fa fa-thumbs-up"></i>) This Employee Needs Improvement</p>
                  <p class="note1 note" style="<?php echo $disp1; ?>color:#A70606;">(<i class="fa fa-thumbs-down"></i>) This Employee has No Evidence of Skill</p>
                  <p class="note0 note" style="<?php echo $disp0; ?>color:#06A716;">No Performance Evaluation Score</p>
               </td>
            </tr>
        </table><br />
        <?php // } ?>
        <?php } else { ?>
        <input type="hidden" id="globalhr" value="">
        <div style="width:99%;background-color:#fff;padding:2px;">
                <p style="text-align:center;font-weight:bold;color:#A70606;"> Kindly inform the HR for the Employee Conduct/Memo, Attendance and Punctuality, 5S + 2 Compliance and Training Scores </p>
        </div>
        <?php } ?>
    <?php } ?>

    <div style="border:1px solid #fff;padding-left:5px;padding-right:5px;width:98%;">
        <h4>V. DEVELOPMENT PLAN</h4>
        <p>A. Key competencies to strengthen performance in current job (set by reviewing mgr):</p>
        <textarea name="devplana" style="width:99%;" class="smltxtbox checker"><?php echo $devplana; ?></textarea>
        <!--<p>B. Employee desired career path within next 2 to 3 years (set by job holder):</p>
        <textarea style="width:99%;" class="smltxtbox"></textarea>-->
        <p>B. Key competencies needed to advance in employee desired career path (set by reviewing mgr):</p>
        <textarea name="devplanb" style="width:99%;" class="smltxtbox checker"><?php echo $devplanb; ?></textarea>
        <p>C. Planned development / training activities (agreed by reviewing mgr and as per the following priority / feasibility order):</p>
        <textarea name="devplanc" style="width:99%;" class="smltxtbox checker"><?php echo $devplanc; ?></textarea>
    </div><!-- End of part 6 -->
    <br />

    <!-- Part 2 -->
    <div style="border:1px solid #fff;padding-left:5px;width:98.6%;">
        <h4>VI. PERFORMANCE SUMMARY <span style="font-size:10px;font-weight:normal;">(Written by Reviewing Manager)</span></h4>
        <p><textarea name="remarks" class="perfsummary checker" style="width:98.4%;min-height:100px;"><?php echo $rcomm1; ?></textarea></p>
    </div><!-- End of part 2 -->
    <br />
        <h3><strong>Equivalent system generated percentage increase: </strong>
            <input type="hidden" id="computed_score" value="<?php echo $evaluateRatee[0]['computed']; ?>">
            <input type="hidden" id="reg_increase" value="<?php echo $appraisal[0]['Increase']; ?>">
            <input type="hidden" id="pro_increase" value="<?php echo $appraisal[0]['Proincrease']; ?>">
            <span id="sys_gen_inc">
              <?php

                  if($evaluateRatee[0]['Promotion'] != $evaluateRatee[0]['randesc'] && !empty(trim($evaluateRatee['Promotion'])))
                    echo round(($evaluateRatee[0]['computed'] / 5) * ($appraisal[0]['Increase'] / 100) *100, 2);
                  else
                    echo round(($evaluateRatee[0]['computed'] / 5) * ($appraisal[0]['Proincrease'] / 100) *100, 2);
                  ?>



              </span>%
        </h3>
        <p><strong>Final Recommendation;</strong> please fill up your desired recommendations below. </p>
        Promotion To Level: <input type="text" name="promotion" value="<?php echo $rprom1; ?>" list="ranks" autocomplete="off" onclick="this.value = ''; fnAlltotalpcc()" data-promote="<?php echo $evaluateRatee[0]['randesc']; ?>" style="">&nbsp;&nbsp;&nbsp;
        New Position Title: <input type="text" name="promotionpos" value="<?php echo $evaluateRatee[0]['promotePos']; ?>">&nbsp;&nbsp;&nbsp;<br><br>
        <datalist id="ranks">
          <?php
            $ranks = [
              'Rank and File 1',
              'Rank and File 2',
              'Senior Rank and File 1',
              'Senior Rank and File 2',
              'Junior Supervisor/Professional 1',
              'JUNIOR SUPERVISOR/PROFESSIONAL 2',
              'Senior Supervisor/Professional 1',
              'SENIOR SUPERVISOR/PROFESSIONAL 2',
              'Junior Manager 1',
              'Junior Manager 2',
              'Manager 1',
              'Manager 2',
              'Senior Manager 1',
              'Senior Manager 2',
              'Director 1',
              'Director 2'
            ];

            $i = false;
            foreach($ranks as $rank):
           ?>

          <option value="<?php echo $rank ?>">
                <?php
                    // echo $rank;

                    if($i){
                      echo '(system recommended)';
                      $i = false;
                    }

                    if($evaluateRatee[0]['randesc'] == $rank){
                      echo '(current rank)';
                      $i = true;
                    }

                ?>
          </option>

          <?php endforeach; ?>
        </datalist>

    <?php if($max1i == 1) { ?>
        Salary Increase: <input type="number" min="1" max="<?php echo  $rincr1; ?>" name="increase" value="<?php echo $evaluateRatee[0]['recinc']; ?>">%
        <br /><br />

    <?php } else { ?>
        <input type="hidden" name="increase" value="">
    <?php } ?>
     <p ><strong style="color:#F8FABC">Promotion History from the last 3 years: </strong> <br>
          <?php echo $evaluateRatee[0]['ProHistory']; ?>
          <br> <strong style="color:#F8FABC">Conduct and Memo History from the last 3 years: </strong> <br>
          <?php echo $evaluateRatee[0]['CMComment']; ?>
          <br> <strong style="color:#F8FABC">Attendance and Punctuality History from the last 3 years: </strong> <br>
          <?php echo $evaluateRatee[0]['APComment']; ?>
      </p>
    <!--
    <div style="border:1px solid #fff;padding-left:5px;padding-right:5px;width:98%;">
        <h4>VII. JOB HOLDER COMMENTS <span style="font-size:10px;font-weight:normal;">(Optional)</span></h4>
        <p> I Have read my performance review form and have discussed it with my manager. My acceptance acknowledges receipt of this form. However, I'd like to add the following: </p>
        <textarea style="width:99%;" class="smltxtbox"></textarea>
    </div>--><!-- End of part 6 -->
    <!--<br /> -->

    <button type="submit" value="1" name="procAppraisal" class="subapp smlbtn" id="submapp" style="float:right;margin-right:10px;">Submit Appraisal</button>&nbsp;&nbsp;&nbsp;
    <a onclick="myFunction()" class="relapp smlbtn" style="float:right;margin-right:10px;display:none;background-color:#3EC2FB;"><i class="fa fa-undo"></i> Refresh page</a>
    <a href="<?php echo WEB; ?>/pafglobal_view?groupid=<?php echo $groupid; ?>&pafad=rater&sub=1&appid=<?php echo $appid; ?>&rid=<?php echo $rid; ?>" class="viewapp smlbtn" id="viewapp" style="display:none;float:right;background-color:#3EC2FB;margin-right:10px;">View Result</a>
    <button type="submit" value="2" name="saveAppraisal" class="saveapp smlbtn" id="saveapp" style="float:right;background-color:#3EC2FB;margin-right:10px;">Save Appraisal</button>
    <br /><br />
</fieldset>
</div><!-- end of performance evaluation form -->

<div id="alert"></div>

<div id="errdialog" title="" style="display:none;">
    <p id="errorp"></p>
</div>

<script type="text/javascript">
    function myFunction() {
        location.reload();
    }

    $('#submapp').click(function(){
        var hasNoValue;
        $('.checker').each(function(i) {
            var cc1 = $(this).val();
            var ccfin = $.trim(cc1);
            if (ccfin == '' ) {
                 $( this ).css("background-color", "#FCC4C4");
                 hasNoValue = true;
            } else {
                 $( this ).css("background-color", "#fff");
            }
        });

        // $('input.checker[type="text"]').each(function(){
        //     var cc1 = $(this).val();
        //     var ccfin = $.trim(cc1);
        //     if (gibberish.detect(ccfin) != 1) {
        //          $( this ).css("background-color", "#FCC4C4");
        //          hasNoValue = true;
        //          console.log(ccfin + ": " + gibberish.detect(ccfin));
        //     } else {
        //          $( this ).css("background-color", "#fff");
        //     }
        // });

        if (hasNoValue) {
              $('#errorp').html('You must fill up all the fields with valid phrase or sentence or value, *Important so we can improve your subordinates capabilities');
              $( "#errdialog" ).dialog({
                 title: "Fill-up all the fields"
              });
              return false;
        }

        //Part 5 total weight distinction
        var ftotalp5w = $('.totalp5w').val();
        if (ftotalp5w != 100) {
            //$('#errdialog').prop('title', 'Error');
            $('#errorp').html('Setting objectives for next review period total weight must be equals to 100%');
            $( "#errdialog" ).dialog({
                title: "Warning in Part IV"
            });
            return false;
        }
        var ftotalp5w2 = $('.totalp5w2').val();
        //$(".needed1").prop('required',true);
        if (ftotalp5w2 != 100) {
            //$('#errdialog').prop('title', 'Error');
            $('#errorp').html('Personal core competencies total weight must be equals to 100%');
            $( "#errdialog" ).dialog({
                title: "Waring in Part IV"
            });
            return false;
        }

    });

    $('#saveapp').click(function(){
       // $('#submapp').hide('fast');
       // $('#saveapp').hide('fast');
    });

    $(document).on("keypress", 'form', function (e) {
        var code = e.keyCode || e.which;
        if (code == 13) {
            e.preventDefault();
            return false;
        }
    });

    fnAlltotalpcc();
</script>
<!-- end if -->
<?php } else { ?>
<p style="text-align:center;font-size:1.2em;margin-top:55px;">You have no rights to rate this employee</p>
<?php } ?>
