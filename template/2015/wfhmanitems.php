<?php include(TEMP."/header.php"); ?>

<!-- BODY -->
<div id="mainsplashtext" class="mainsplashtext lefttalign">  
    <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
    <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
    <div class="rightsplashtext lefttalign">
        <div id="mainapprovers" class="mainbody lefttalign whitetext">  
            
            <b class="mediumtext lorangetext">
                <a href="<?php echo WEB; ?>/wfhman"><i class="mediumtext fa fa-arrow-left" style="color:#fff;opacity:.8;"></i></a> 
                WFH MANAGEMENT
            </b>
            <br><br>                                
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
                    <td>
                            <td><b>EmpID</b> </td>
                            <td><?php echo $wciman_data[0][EmpID]; ?></td>
                    </td>
                    <td>
                            <td><b>Department</b></td>
                            <td><?php echo $wciman_data[0][DeptDesc]; ?></td>
                    </td>
                </tr>
                <tr>
                    <td>
                            <td><b>Name</b></td>
                            <td><?php echo $wciman_data[0][FullName]; ?></td>
                    </td>
                    <td>
                        &nbsp;
                    </td>
                </tr>
            </table>
            <hr>
            <div id="wcimandata">
            <table border="0" cellspacing="0" class="tdata width100per">
                <?php if ($wciman_data) : ?>
                <tr>
                    <th width="">Reference</th>
                    <th width="">Type</th>
                    <th width="">DTR Date</th>
                    <th width="">Work Hours</th>
                    <th width="">Status</th>
                    <th width="">Action</th>
                </tr>
                <?php foreach ($wciman_data as $key => $value) : ?>    
                <tr class="trdata centertalign whitetext">
                    <td><?php echo $value['RefNbr']; ?></td>
                    <td><?php echo strtoupper($value['ClearanceType']); ?></td>
                    <td><?php echo date('Y-m-d', strtotime($value['DTRDate'])); ?></td>
                    <td>
                        <?php if($value['FormStatus'] == 'APPROVED') : ?>
                        <input type="number" id="workhours" name="workhours" value="<?php   echo $value['DTRWorkHours'];  ?>" min="0" max="9" step="0.5">
                        <?php else : ?>
                        <?php   echo $value['DTRWorkHours'];  ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($value['FormStatus'] == 'APPROVED') : ?>
                        <select name="formstatus" id="formstatus" class="width95 smltxtbox">
                            <option value="APPROVED" <?php if($value['FormStatus'] == 'APPROVED') echo 'selected'; ?> >APPROVED</option>
                            <option value="CANCELLED" <?php if($value['FormStatus'] == 'CANCELLED') echo 'selected'; ?>>CANCELLED</option>
                        </select>
                        <?php else : ?>
                        <?php   echo $value['FormStatus'];  ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($value['FormStatus'] == 'APPROVED') : ?>
                        <button type="submit" id="wfhciupdate" name="wfhciupdate" value="<?php  echo $value['SeqID'];  ?>"><i class="fa fa-save"></i></button>
                            <i id="updated-success" class="fa fa-check" style="color:green; display:none"></i>
                            <i id="updated-error" class="fa fa-wrong" style="color:red; "></i>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>

                    <?php if ($pages) : ?>
                    <tr>
                        <td colspan="5" class="centertalign"><?php echo $pages; ?></td>
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