	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
    
            <div id="lowerlist" class="lowerlist solidbottom">
                <div class="menudiv left3">
                    <?php include(TEMP."/menu.php"); ?>
                </div>
                <div class="div6"> 
                    
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>                            
                            <td align="left">
                                <form action="<?php echo WEB; ?>/user" method="POST" enctype="multipart/form-data">
                                <i class="fa fa-search fa-lg"></i> 
                                Search <?php if ($_POST['searchuser'] || $_SESSION['searchuser']) : ?>result for <?php endif; ?>
                                <input type="text" name="searchuser" value="<?php echo $_POST['searchuser'] ? $_POST['searchuser'] : $_SESSION['searchuser']; ?>" placeholder="by name..." class="txtbox searchuser" />
                                <input type="submit" name="btnsearchuser" value="Search" class="btn btnsearchuser" />
                                <?php if ($_POST['searchuser'] || $_SESSION['searchuser']) : ?>
                                <input type="button" name="btnsearchalluser" value="View All" class="btn btnsearchalluser" />    
                                <?php endif; ?>    
                                </form>
                            </td>
                        </tr>
                    </table>
                    
                    <div id="user_table"> 
                    <table class="tdata" width="100%">
                        <tr>
                            <th width="5%">ID</th>
                            <th width="30%">Full Name</th>
                            <th width="15%">Department</th>
                            <th width="20%">E-mail Address</th>
                            <th width="10%">Local</th>
                            <th width="20%" colspan="2">Manage</th>
                        </tr>
                        <?php if ($users) : ?>
                        <?php foreach ($users as $key => $value) : ?>
                        <tr>
                            <td><?php echo $value['emp_idnum']; ?></td>
                            <td><b><?php echo $value['emp_firstname'].' '.$value['emp_lastname']; ?></b></td>
                            <td class="centertalign"><?php echo $value['dept_name']; ?></td>                                  
                            <td class="centertalign"><?php echo $value['emp_corpemail'] ? '<a href="mailto:'.$value['emp_corpemail'].'">'.$value['emp_corpemail'].'</a>' : 'not available'; ?></td>
                            <td class="centertalign"><a href="tel:<?php echo $value['emp_corptel']; ?>"><?php echo $value['emp_corptel']; ?></a></td>
                            <td class="centertalign ustatusDiv<?php echo $value['emp_id']; ?>"><a class="approveUser cursorpoint" attribute="<?php echo $value['emp_id']; ?>" attribute2="<?php echo $value['emp_status']; ?>"><i class="fa <?php echo $value['emp_status'] == 2 ? "fa-unlock-alt greentext" : "fa-lock redtext"; ?> fa-lg"></i></a></td>                   
                            <td class="centertalign"><a title="Delete Employee" class="delUser cursorpoint" attribute="<?php echo $value['emp_id']; ?>"><i class="fa fa-trash-o fa-lg redtext"></i></a></td>                   
                            
                        </tr>
                        <?php endforeach; ?>
                        <?php if ($pages) : ?>
                        <tr>
                            <td colspan="7" align="center" class="whitebg"><?php echo $pages; ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="7" align="center">No new user list found</td>
                        </tr>
                        <?php endif; ?>
                    </table>
                    </div>
                    
                </div>
            </div>

    <?php include(TEMP."/footer.php"); ?>