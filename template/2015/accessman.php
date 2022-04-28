<?php include(TEMP."/header.php"); ?>

<div id="mainsplashtext" class="mainsplashtext lefttalign">  
    <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
    <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
    <div class="rightsplashtext lefttalign">
        <div id="mainapprovers" class="mainbody lefttalign whitetext">  
            <b class="mediumtext lorangetext">ACCESS MANAGEMENT</b><br><br>                                
            
            <table class="width100per">
                <tr>
                    <td><span class="fa fa-search"></span> Search: 
                        <input type="text" id="searchpsman" name="searchpsman" value="<?php echo $_SESSION['searchpsman'] ? $_SESSION['searchpsman'] : ''; ?>" placeholder="by <?php echo $profile_nadd; ?> ID, lastname or firstname" class="smltxtbox width250" />&nbsp;
                        <input type="button" id="btnpsman" name="btnpsman" value="Search" class="smlbtn" />
                        <input type="button" id="btnpsmanall" name="btnpsmanall" value="View All" class="smlbtn<?php if (!$_SESSION['searchpsman']) : ?> invisible<?php endif; ?>" />                                            
                    </td>
                    <td class="righttalign">
                        <!--input type="button" id="btnread" name="btnread" value="Mark as Read" class="smlbtn btnred" />
                        <input type="button" id="btnunread" name="btnunread" value="Mark as Unread" class="smlbtn btnred" /-->                            
                    </td>
                </tr>
            </table>
            
            <div id="empdata">
                <table border="0" cellspacing="0" class="tdata width100per">
                    <?php if ($emp_data) : ?>
                    <tr>
                        <th width="15%">EmpID</th>
                        <th width="23%">Name</th>
                        <th width="">DTR</th>
                        <th width="">PAYSLIP</th>
                        <th width="">REQUESTS</th>
                        <th width="">APPROVERS</th>
                        <th width="">ACTIVITIES</th>
                        <th width="">MEMO</th>
                        <th width="">ADS</th>
                        <th width="">BIRTHDAY</th>
                    </tr>
                    <?php foreach ($emp_data as $key => $value) : ?>                                    
                    <tr class="btnempdata cursorpoint trdata centertalign whitetext" attribute="<?php echo md5($value['EmpID']); ?>">
                        <td><?php echo $value['EmpID']; ?></td>
                        <td><?php echo $value['LName']; ?></td>
                        <td><?php echo $value['FName']; ?></td>
                        <td><?php echo $value['PositionDesc']; ?></td>
                        <td><?php echo $value['DeptDesc']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if ($pages) : ?>
                    <tr>
                        <td colspan="7" class="centertalign"><?php echo $pages; ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php else : ?>
                    <tr>
                        <td class="bold centertalign noborder"><br><br>You have no employees listed</td>
                    </tr>
                    <?php endif; ?>
                </table>
                <input type="hidden" id="emppage" name="emppage" value="<?php echo $page; ?>" />   
            </div>
        </div>
    </div>
</div>

<?php include(TEMP."/footer.php"); ?>