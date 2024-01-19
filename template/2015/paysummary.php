	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
                    
                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainnotification" class="mainbody lefttalign whitetext">  
                                <b class="mediumtext lorangetext">PAYROLL SUMMARY</b><br><br>
                                
                                <table>
                                    
                                    <tr>
                                        <td><input type="radio" name="ps_method" value="year" checked />&nbsp;
                                            Year: 
                                            <select name="ps_year" class="width95 smltxtbox">
                                                <option>2015</option>    
                                                <option>2014</option>    
                                            </select>
                                        </td>
                                        <td><input type="radio" name="ps_method" value="ranger" />&nbsp;
                                            Range: 
                                            <select name="ps_range1" class="width95 smltxtbox">
                                                <option>2015</option>    
                                                <option>2014</option>    
                                            </select>&nbsp;to&nbsp;
                                            <select name="ps_range2" class="width95 smltxtbox">
                                                <option>2015</option>    
                                                <option>2014</option>    
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                                
                                <table border="0" cellspacing="0" class="tdata margintop25 tinytext width100per">
                                    <tr>
                                        <th width="5%">Year</th>
                                        <th width="15%">Gross Pay</th>
                                        <th width="15%">Basic Pay</th>
                                        <th width="15%">Tax Income</th>
                                        <th width="15%">SSS</th>
                                        <th width="10%">PhilHealth</th>
                                        <th width="10%">Pag-IBIG</th>
                                        <th width="15%">Withholding Tax</th>
                                    </tr>
                                    <tr class="trdata centertalign">
                                        <td>2014</td>
                                        <td>302,547.63</td>
                                        <td>442,415.25</td>
                                        <td>409,548.63</td>
                                        <td>4,352.80</td>
                                        <td>2,614.30</td>
                                        <td>1,200.00</td>
                                        <td>85,125.63</td>
                                    </tr>
                                    <tr class="trdata centertalign">
                                        <td>2015</td>
                                        <td>205,456.51</td>
                                        <td>203,154.41</td>
                                        <td>201,155.45</td>
                                        <td>1,911.15</td>
                                        <td>1,779.45</td>
                                        <td>600.00</td>
                                        <td>46,665.57</td>
                                    </tr>
                                    <tr class="bold trdata centertalign">
                                        <td>Total</td>
                                        <td>508,004.04</td>
                                        <td>645,569.66</td>
                                        <td>610,704.08</td>
                                        <td>6,263.95</td>
                                        <td>4393.75</td>
                                        <td>1,800.00</td>
                                        <td>131,791.20</td>
                                    </tr>
                                </table>
                                
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>