	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->

                    <div id="floatdiv" class="floatdiv invisible">                                         
                        <!-- EDIT APPROVERS - BEGIN --> 
                        <div id="aedit" class="fedit2 invisible">
                            <div class="closebutton2 cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                            <div id="appr_title" class="appr_title robotobold cattext dbluetext"></div>
                            <div id="appr_data">
                            
                            </div>
                            <div id="appr_button" class="appr_button centertalign">
                                <input id="appempid" type="hidden" name="appempid" />
                                <input id="appcount" type="hidden" name="appcount" />
                                <button id="btnapprovers" class="btn">Update</button>
                            </div>
                        </div>
                        <!-- EDIT APPROVERS - END -->    
                    </div>
                    
                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainapprovers" class="mainbody lefttalign whitetext">  
                                <b class="mediumtext lorangetext">SYSTEM and DTR MANAGEMENT</b><br><br>    
                                <span class="smalltext lorangetext">You may view DTR of employees under your approval or if you've been assigned as admin.</span>                            
                                
                                <table class="width100per">
                                    <tr>
                                        <td><span class="fa fa-search"></span> Search: 
                                            <input type="text" id="searchdtrm" name="searchdtrm" value="<?php echo $_SESSION['searchdtrm'] ? $_SESSION['searchdtrm'] : ''; ?>" placeholder="by <?php echo $profile_nadd; ?> ID, lastname or firstname" class="smltxtbox width250" />&nbsp;
                                            <input type="button" id="btndtrm" name="btndtrm" value="Search" class="smlbtn" />
                                            <input type="button" id="btndtrmall" name="btndtrmall" value="View All" class="smlbtn<?php if (!$_SESSION['searchdtrm']) : ?> invisible<?php endif; ?>" />                                            
                                        </td>
                                        <td class="righttalign">
                                            <!--input type="button" id="btnread" name="btnread" value="Mark as Read" class="smlbtn btnred" />
                                            <input type="button" id="btnunread" name="btnunread" value="Mark as Unread" class="smlbtn btnred" /-->                            
                                        </td>
                                    </tr>
                                </table>
                                
                                <div id="dtrmdata">
                                <script type="text/javascript">
                                    $(function() {	

                                        $(".pstoggle").on("click", function() {	

                                            toggleval = $(this).attr('attribute');
                                            empid = $(this).attr('attribute2');
                                            dbname = $(this).attr('attribute3');

                                            pstoggleobj = $(this);

                                            $.ajax(
                                            {
                                                url: "<?php echo WEB; ?>/lib/requests/dtrman_request.php?sec=pstoggle",
                                                data: "toggleval=" + toggleval + "&empid=" + empid + "&dbname=" + dbname,
                                                type: "POST",
                                                complete: function(){
                                                    $("#loading").hide();
                                                },
                                                success: function(data) {
                                                    if (toggleval == 1) {
                                                        pstoggleobj.attr('attribute', 0);
                                                        pstoggleobj.removeClass('fa-times');
                                                        pstoggleobj.removeClass('redtext');
                                                        pstoggleobj.addClass('fa-check');
                                                        pstoggleobj.addClass('greentext');
                                                    }
                                                    else {
                                                        pstoggleobj.attr('attribute', 1);
                                                        pstoggleobj.removeClass('fa-check');
                                                        pstoggleobj.removeClass('greentext');
                                                        pstoggleobj.addClass('fa-times');
                                                        pstoggleobj.addClass('redtext');
                                                    }

                                                }
                                            })
                                        });

                                        $(".nebtoggle").on("click", function() {	

                                            toggleval = $(this).attr('attribute');
                                            empid = $(this).attr('attribute2');
                                            dbname = $(this).attr('attribute3');

                                            nebtoggleobj = $(this);

                                            $.ajax(
                                            {
                                                url: "<?php echo WEB; ?>/lib/requests/dtrman_request.php?sec=nebtoggle",
                                                data: "toggleval=" + toggleval + "&empid=" + empid + "&dbname=" + dbname,
                                                type: "POST",
                                                complete: function(){
                                                    $("#loading").hide();
                                                },
                                                success: function(data) {
                                                    if (toggleval == 1) {
                                                        nebtoggleobj.attr('attribute', 0);
                                                        nebtoggleobj.removeClass('fa-times');
                                                        nebtoggleobj.removeClass('redtext');
                                                        nebtoggleobj.addClass('fa-check');
                                                        nebtoggleobj.addClass('greentext');
                                                    }
                                                    else {
                                                        nebtoggleobj.attr('attribute', 1);
                                                        nebtoggleobj.removeClass('fa-check');
                                                        nebtoggleobj.removeClass('greentext');
                                                        nebtoggleobj.addClass('fa-times');
                                                        nebtoggleobj.addClass('redtext');
                                                    }

                                                }
                                            })
                                        });

                                        $(".aebtoggle").on("click", function() {	

                                            toggleval = $(this).attr('attribute');
                                            empid = $(this).attr('attribute2');
                                            dbname = $(this).attr('attribute3');

                                            aebtoggleobj = $(this);

                                            $.ajax(
                                            {
                                                url: "<?php echo WEB; ?>/lib/requests/dtrman_request.php?sec=aebtoggle",
                                                data: "toggleval=" + toggleval + "&empid=" + empid + "&dbname=" + dbname,
                                                type: "POST",
                                                complete: function(){
                                                    $("#loading").hide();
                                                },
                                                success: function(data) {
                                                    if (toggleval == 1) {
                                                        aebtoggleobj.attr('attribute', 0);
                                                        aebtoggleobj.removeClass('fa-times');
                                                        aebtoggleobj.removeClass('redtext');
                                                        aebtoggleobj.addClass('fa-check');
                                                        aebtoggleobj.addClass('greentext');
                                                    }
                                                    else {
                                                        aebtoggleobj.attr('attribute', 1);
                                                        aebtoggleobj.removeClass('fa-check');
                                                        aebtoggleobj.removeClass('greentext');
                                                        aebtoggleobj.addClass('fa-times');
                                                        aebtoggleobj.addClass('redtext');
                                                    }

                                                }
                                            })
                                        });
                                        
                                    });
                                </script>
                                <table border="0" cellspacing="0" class="tdata width100per">
                                    <?php if ($dtrman_data) : ?>
                                    <tr>
                                        <th width="15%"><?php echo ucfirst($profile_nadd); ?> ID</th>
                                        <th width="20%">Last Name</th>
                                        <th width="20%">First Name</th>
                                        <!--th width="15%">Company</th-->
                                        <th width="10%">Payslip Menu</th>
                                        <th width="17%" colspan="2">Notification Mail</th>
                                        <th width="18%">DTR</th>
                                    </tr>
                                    <!--tr>
                                        <th width="10%">New Request</th>
                                        <th width="10%">Approve/Disapprove Mail</th>
                                    </tr-->
                                    <?php foreach ($dtrman_data as $key => $value) : ?> 
                                    <?php 
                                        $chkps = $mainsql->get_psblock($value['EmpID'], $value['DBNAME']); 
                                        $chkneb = $mainsql->get_newemailblock($value['EmpID'], $value['DBNAME']);
                                        $chkaeb = $mainsql->get_appemailblock($value['EmpID'], $value['DBNAME']);
                                    ?>
                                    <tr class="trdata centertalign whitetext" db="<?php echo $value['DBNAME']; ?>">
                                        <td><?php echo $value['EmpID']; ?></td>
                                        <td><?php echo $value['LName']; ?></td>
                                        <td><?php echo $value['FName']; ?></td>
                                        <!--td><?php echo $value['DBNAME']; ?></td-->
                                        <td class="chkps centertalign"><?php if ($chkps) : ?><i attribute="0" attribute2="<?php echo $value['EmpID']; ?>" attribute3="<?php echo $value['DBNAME']; ?>" class="pstoggle fa fa-check greentext cursorpoint"></i><?php else : ?><i attribute="1" attribute2="<?php echo $value['EmpID']; ?>" attribute3="<?php echo $value['DBNAME']; ?>" class="pstoggle fa fa-times redtext cursorpoint"></i><?php endif; ?></td>
                                        <td class="chkps centertalign"><?php if ($chkneb) : ?><i attribute="0" attribute2="<?php echo $value['EmpID']; ?>" class="nebtoggle fa fa-check greentext cursorpoint"></i><?php else : ?><i attribute="1" attribute2="<?php echo $value['EmpID']; ?>" class="nebtoggle fa fa-times redtext cursorpoint"></i><?php endif; ?></td>
                                        <td class="chkps centertalign"><?php if ($chkaeb) : ?><i attribute="0" attribute2="<?php echo $value['EmpID']; ?>" class="aebtoggle fa fa-check greentext cursorpoint"></i><?php else : ?><i attribute="1" attribute2="<?php echo $value['EmpID']; ?>" class="aebtoggle fa fa-times redtext cursorpoint"></i><?php endif; ?></td>
                                        <td><a href="<?php echo WEB.'/userdtr?id='.md5($value['EmpID']).'&db='.trim($profile_dbname); ?>" class="lorangetext">View/Edit DTR</a></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if ($pages) : ?>
                                    <tr>
                                        <td colspan="7" class="centertalign"><?php echo $pages; ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php else : ?>
                                        <?php if (strlen($searchdtrm) < 3) : ?>
                                        <tr>
                                            <td class="bold centertalign noborder"><br><br>Search must be minimum of 3 characters <i>* <?php echo $profile_nadd; ?> ID must full (2015-01-XXXX)</i></td>
                                        </tr>
                                        <?php else : ?>
                                        <tr>
                                            <td class="bold centertalign noborder"><br><br>No employees listed</td>
                                        </tr>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </table>
                                <input type="hidden" id="dtrmpage" name="dtrmpage" value="<?php echo $page; ?>" />      
                                </div>
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>