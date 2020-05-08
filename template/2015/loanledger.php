	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->

                    
                    
                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainnotification" class="mainbody lefttalign whitetext">  
                                <b class="mediumtext lorangetext">LOAN LEDGER</b><br><br>
                                
                                <?php 
                                    if ($loanledger_data) :
                                    ?>
                                
                                    <table>
                                        <tr>
                                            <td>Loan Application: 
                                                <select id="loan_num" name="loan_num" class="smltxtbox">
                                                    <?php foreach ($loanledger_data as $key => $value) : ?>
                                                    <option value="<?php echo $value['ApplyTo']; ?>"><?php echo date('Y-m-d', strtotime($value['DateGranted'])).' | '; ?>
                                                    <?php
                                                        if ($value['OExtID'] == 'OD01') : echo $payslip_oddesc[0]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD02') : echo $payslip_oddesc[1]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD03') : echo $payslip_oddesc[2]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD04') : echo $payslip_oddesc[3]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD05') : echo $payslip_oddesc[4]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD06') : echo $payslip_oddesc[5]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD07') : echo $payslip_oddesc[6]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD08') : echo $payslip_oddesc[7]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD09') : echo $payslip_oddesc[8]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD10') : echo $payslip_oddesc[9]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD11') : echo $payslip_oddesc[10]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD12') : echo $payslip_oddesc[11]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD13') : echo $payslip_oddesc[12]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD14') : echo $payslip_oddesc[13]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD15') : echo $payslip_oddesc[14]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD16') : echo $payslip_oddesc[15]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD17') : echo $payslip_oddesc[16]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD18') : echo $payslip_oddesc[17]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD19') : echo $payslip_oddesc[18]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD20') : echo $payslip_oddesc[19]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD21') : echo $payslip_oddesc[20]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD22') : echo $payslip_oddesc[21]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD23') : echo $payslip_oddesc[22]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD24') : echo $payslip_oddesc[23]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD25') : echo $payslip_oddesc[24]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD26') : echo $payslip_oddesc[25]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD27') : echo $payslip_oddesc[26]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD28') : echo $payslip_oddesc[27]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD29') : echo $payslip_oddesc[28]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD30') : echo $payslip_oddesc[29]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD31') : echo $payslip_oddesc[30]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD32') : echo $payslip_oddesc[31]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD33') : echo $payslip_oddesc[32]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD34') : echo $payslip_oddesc[33]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD35') : echo $payslip_oddesc[34]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD36') : echo $payslip_oddesc[35]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD37') : echo $payslip_oddesc[36]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD38') : echo $payslip_oddesc[37]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD39') : echo $payslip_oddesc[38]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD40') : echo $payslip_oddesc[39]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD41') : echo $payslip_oddesc[40]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD42') : echo $payslip_oddesc[41]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD43') : echo $payslip_oddesc[42]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD44') : echo $payslip_oddesc[43]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD45') : echo $payslip_oddesc[44]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD46') : echo $payslip_oddesc[45]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD47') : echo $payslip_oddesc[46]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD48') : echo $payslip_oddesc[47]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD49') : echo $payslip_oddesc[48]["OExtDesc"];
                                                        elseif ($value['OExtID'] == 'OD50') : echo $payslip_oddesc[49]["OExtDesc"];
                                                        endif; 
                                                    ?>
                                                    </option>    
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>

                                    <div id="loandata" class="innerdata">
                                    <table border="0" cellspacing="0" class="tdata" style="width: 100%">
                                        <tr>
                                            <th width="10%">Rec No.</th>
                                            <th width="10%">PRYear</th>
                                            <th width="15%">Reference Date</th>
                                            <th width="20%">Loan Description</th>
                                            <th width="15%">Loan Amount</th>
                                            <th width="15%">Payment</th>
                                            <th width="15%">Balance</th>
                                        </tr>

                                        <?php 
                                            if ($loan_data) :

                                                foreach ($loan_data as $key => $value) : 
                                                    switch($value['TranType']) :
                                                        case 'L':
                                                        ?>
                                                        <tr class="trdata centertalign">
                                                            <td><?php echo $value['SeqID']; ?></td>
                                                            <td><?php echo $value['PRYear']; ?></td>
                                                            <td>&nbsp;</td>
                                                            <td>
                                                                <?php
                                                                    if ($value['OExtID'] == 'OD01') : echo $payslip_oddesc[0]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD02') : echo $payslip_oddesc[1]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD03') : echo $payslip_oddesc[2]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD04') : echo $payslip_oddesc[3]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD05') : echo $payslip_oddesc[4]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD06') : echo $payslip_oddesc[5]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD07') : echo $payslip_oddesc[6]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD08') : echo $payslip_oddesc[7]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD09') : echo $payslip_oddesc[8]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD10') : echo $payslip_oddesc[9]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD11') : echo $payslip_oddesc[10]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD12') : echo $payslip_oddesc[11]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD13') : echo $payslip_oddesc[12]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD14') : echo $payslip_oddesc[13]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD15') : echo $payslip_oddesc[14]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD16') : echo $payslip_oddesc[15]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD17') : echo $payslip_oddesc[16]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD18') : echo $payslip_oddesc[17]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD19') : echo $payslip_oddesc[18]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD20') : echo $payslip_oddesc[19]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD21') : echo $payslip_oddesc[20]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD22') : echo $payslip_oddesc[21]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD23') : echo $payslip_oddesc[22]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD24') : echo $payslip_oddesc[23]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD25') : echo $payslip_oddesc[24]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD26') : echo $payslip_oddesc[25]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD27') : echo $payslip_oddesc[26]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD28') : echo $payslip_oddesc[27]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD29') : echo $payslip_oddesc[28]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD30') : echo $payslip_oddesc[29]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD31') : echo $payslip_oddesc[30]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD32') : echo $payslip_oddesc[31]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD33') : echo $payslip_oddesc[32]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD34') : echo $payslip_oddesc[33]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD35') : echo $payslip_oddesc[34]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD36') : echo $payslip_oddesc[35]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD37') : echo $payslip_oddesc[36]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD38') : echo $payslip_oddesc[37]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD39') : echo $payslip_oddesc[38]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD40') : echo $payslip_oddesc[39]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD41') : echo $payslip_oddesc[40]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD42') : echo $payslip_oddesc[41]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD43') : echo $payslip_oddesc[42]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD44') : echo $payslip_oddesc[43]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD45') : echo $payslip_oddesc[44]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD46') : echo $payslip_oddesc[45]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD47') : echo $payslip_oddesc[46]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD48') : echo $payslip_oddesc[47]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD49') : echo $payslip_oddesc[48]["OExtDesc"];
                                                                    elseif ($value['OExtID'] == 'OD50') : echo $payslip_oddesc[49]["OExtDesc"];
                                                                    endif; 
                                                                ?>
                                                            </td> <td><?php echo number_format($value['TotalPayable'], 2, '.', ','); ?></td>
                                                            <td>&nbsp;</td>                     
                                                            <td><?php echo number_format($balance += $value['TotalPayable'], 2, '.', ','); ?></td>
                                                        </tr>
                                                        <?php
                                                        break;
                                                        case 'P':
                                                        ?>
                                                        <tr class="trdata centertalign">
                                                            <td><?php echo $value['SeqID']; ?></td>
                                                            <td><?php echo $value['PRYear']; ?></td>
                                                            <td><?php echo date('M j, Y', strtotime($value['RefDate'])); ?></td>
                                                            <td>&nbsp;</td> 
                                                            <td>&nbsp;</td>
                                                            <td><?php echo number_format(abs($value['Amount']), 2, '.', ','); ?></td>             
                                                            <td><?php echo number_format($balance += $value['Amount'], 2, '.', ','); ?></td>
                                                        </tr>
                                                        <?php
                                                        break;
                                                    endswitch;
                                                endforeach;
                                            ?>
                                            <tr class="trdata">
                                                <td colspan="6" class="lefttalign bold">Balance:</td>
                                                <td class="centertalign"><?php echo number_format($balance, 2, '.', ','); ?></td>
                                            </tr>
                                            <?php
                                            else :
                                                ?>
                                                <tr class="trdata">
                                                    <td colspan="7" class="centertalign">No record found</td>
                                                </tr>    
                                                <?php                                            
                                            endif;
                                        ?>
                                    </table>
                                    </div>
                                
                                    <?php else : ?>
                                
                                    <table border="0" cellspacing="0" style="width: 100%">
                                        <tr class="trdata">
                                            <td class="centertalign">No loan has been applied</td>
                                        </tr>    
                                    </table>
                                
                                    <?php endif; ?>
                                
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>