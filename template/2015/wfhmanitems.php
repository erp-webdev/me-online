<?php include(TEMP."/header.php"); ?>

<!-- BODY -->
<div id="mainsplashtext" class="mainsplashtext lefttalign">  
    <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
    <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
    <div class="rightsplashtext lefttalign">
        <div id="mainapprovers" class="mainbody lefttalign whitetext">  
            <b class="mediumtext lorangetext">WFH MANAGEMENT</b><br><br>                                
            
            <?php /*
            <table class="width100per">
                <tr>
                    <td><span class="fa fa-search"></span> Search: 
                        <input type="text" id="searchwciman" name="searchwciman" value="<?php echo $_SESSION['searchwciman'] ? $_SESSION['searchwciman'] : ''; ?>" placeholder="by <?php echo $profile_nadd; ?> ID, lastname or firstname" class="smltxtbox width250" />&nbsp;
                        <input type="button" id="btnwciman" name="btnwciman" value="Search" class="smlbtn" />
                        <input type="button" id="btnwcimanall" name="btnwcimanall" value="View All" class="smlbtn<?php if (!$_SESSION['searchwciman']) : ?> invisible<?php endif; ?>" />                                            
                    </td>
                    <td class="righttalign">
                        <!--input type="button" id="btnread" name="btnread" value="Mark as Read" class="smlbtn btnred" />
                        <input type="button" id="btnunread" name="btnunread" value="Mark as Unread" class="smlbtn btnred" /-->                            
                    </td>
                </tr>
            </table> */?>

            <table class="width100per">
                <tr>
                    <td>EmployeeID</td>
                    <td><?php echo $wciman_data[0][EmpID]; ?></td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td><?php echo $wciman_data[0][FullName]; ?></td>
                </tr>
            </table>
            
            <div id="wcimandata">
            <table border="0" cellspacing="0" class="tdata width100per">
                <?php if ($wciman_data) : ?>
                <tr>
                    <th width="20%"><?php echo ucfirst($profile_nadd); ?> ID</th>
                    <th width="30%">Last Name</th>
                    <th width="30%">First Name</th>
                    <th width="20%">DTRDate</th>
                </tr>
                <?php foreach ($wciman_data as $key => $value) : ?>    
                <tr class="trdata centertalign whitetext">
                    <td><?php echo $value['EmpID']; ?></td>
                    <td><?php echo $value['LName']; ?></td>
                    <td><?php echo $value['FName']; ?></td>
                    <td><?php echo $value['DTRDate']; ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if ($pages) : ?>
                <tr>
                    <td colspan="4" class="centertalign"><?php echo $pages; ?></td>
                </tr>
                <?php endif; ?>
                <?php else : ?>
                <tr>
                    <td class="bold centertalign noborder"><br><br>No available WFH Clearance</td>
                </tr>
                <?php endif; ?>
            </table>
            <input type="hidden" id="wcimanpage" name="wcimanpage" value="<?php echo $page; ?>" />      
            </div>
        </div>
    </div>
</div>

<?php include(TEMP."/footer.php"); ?>