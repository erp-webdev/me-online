	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->

                    <div id="floatdiv" class="floatdiv invisible">                                        
                        
                        <div id="mview" class="fview" style="display: none;">
                            <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                            <div id="mview_title" class="robotobold cattext dbluetext"></div>
                            <div id="ads_data" class="floatdata margintop15">
                            </div>
                        </div>
                        
                        <?php if ($profile_level == 7 || $profile_level == 9 || $profile_level == 10 || $profile_idnum == "2016-06-0457") : ?>
                        <!-- CREATE MEMO - BEGIN --> 
                        <div id="dladd" class="fadd" style="display: none;">
                            <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                            <div id="dladd_title" class="robotobold cattext dbluetext">Create Form</div>
                            <table class="tdataform2 rightmargin margintop10 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">
                                <form name="create_forms" id="create_forms" action="?ignore-page-cache=true" method="POST" enctype="multipart/form-data">
                                <tr>
                                    <td>Form Name</td>
                                    <td>
                                        <input type="text" name="download_title" id="download_title" value="<?php echo $_POST['download_title']; ?>" class="txtbox width300" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Category</td>
                                    <td>
                                        <select name="download_cat" id="download_cat" class="txtbox width95">
                                            <option value="0">No category</option>
                                            <option value="Loan Form">Loan Form</option>
                                            <option value="BIR Forms">BIR Form</option>
                                            <option value="Pag-IBIG Forms">Pag-IBIG Form</option>
                                            <option value="PhilHealth Forms">PhilHealth Form</option>
                                            <option value="SSS Forms">SSS Form</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Attachment</td>
                                    <td>
                                        <input type="file" name="download_filename" id="download_filename" class="txtbox width200" class="txtbox" /><br /><i>* must be image (jpg, jpeg, gif, png) or PDF and less than or equal 10Mb</i>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center">
                                        <input type="submit" name="btncreateform" id="btncreateform" value="Create" class="btn btncreateform" />
                                        <input type="hidden" name="download_user" id="download_user" value="<?php echo $profile_id; ?>" />
                                        <input type="hidden" name="pagenum" id="pagenum" value="<?php echo $_GET['page'] ? $_GET['page'] : 1; ?>" />
                                    </td>
                                </tr>
                                </form>
                            </table>  
                        </div>
                        <!-- CREATE MEMO - END -->                    
                        <!-- UPDATE MEMO - BEGIN --> 
                        <div id="dledit" class="fedit" style="display: none;">
                            <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                            <div id="dledit_title" class="robotobold cattext dbluetext">Update Form</div>
                            <input type="hidden" id="json_data" name="json_data" />
                            <table class="tdataform2 rightmargin margintop10 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">
                                <form name="edit_forms" id="edit_forms" method="POST" action="?ignore-page-cache=true" enctype="multipart/form-data">
                                
                                <tr>
                                    <td>Form Name</td>
                                    <td>
                                        <input type="text" name="download_title" id="udownload_title" class="txtbox width300" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Category</td>
                                    <td>
                                        <select name="download_cat" id="udownload_cat" class="txtbox width95">
                                            <option value="0">No category</option>
                                            <option value="Loan Form">Loan Form</option>
                                            <option value="BIR Forms">BIR Form</option>
                                            <option value="Pag-IBIG Forms">Pag-IBIG Form</option>
                                            <option value="PhilHealth Forms">PhilHealth Form</option>
                                            <option value="SSS Forms">SSS Form</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Attachment</td>
                                    <td>
                                        <input type="file" name="download_attach" id="udownload_attach" class="txtbox width200" /><br /><i>* must be image (jpg, jpeg, gif, png) or PDF and less than or equal 10Mb</i>
                                    </td>
                                    
                                </tr>
                            
                                <tr>
                                    <td colspan="2" align="center">
                                        <input type="submit" name="btnupdateform" value="Update" class="btn btnupdateform" />
                                        <input type="hidden" name="download_attachment" id="udownload_attachment" />
                                        <input type="hidden" name="download_user" id="udownload_user" value="<?php echo $profile_id; ?>" />
                                        <input type="hidden" name="download_id" id="udownload_id" />
                                        <input type="hidden" name="pagenum" id="pagenum" value="<?php echo $_GET['page'] ? $_GET['page'] : 1; ?>" />
                                    </td>
                                </tr>
                                </form>
                            </table> 
                        </div>
                        <!-- UPDATE MEMO - END -->                    
                        <?php endif; ?>
                    </div>
                    
                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainads" class="mainbody lefttalign whitetext">  
                                <b class="mediumtext lorangetext">FORMS</b>
                                <table class="width100per">
                                    <tr>
                                        <td><span class="fa fa-search"></span> Search by: 
                                            <input type="text" id="searchform" name="searchform" value="<?php echo $_SESSION['searchform'] ? $_SESSION['searchform'] : ''; ?>" placeholder="form title" class="smltxtbox searchform" />&nbsp;
                                            <input type="button" id="btnsearchform" name="btnsearchform" value="Search" class="smlbtn btnsearchform" />
                                            <input type="button" id="btnsearchallform" name="btnsearchallform" value="View All" class="btnsearchallform smlbtn<?php if (!$_SESSION['searchform']) : ?> invisible<?php endif; ?>" />     
                                        </td>
                                        <td class="righttalign">
                                            <?php if ($profile_level == 7 || $profile_level == 10) : ?>
                                            <input type="button" id="btnaddform" name="btnaddform" value="Upload Forms" class="btnaddform smlbtn" />
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                                
                                <div id="downdata" class="dirheight">
                                <div class="valigntop<?php if ($form_count > 20) : ?> twocolumn2<?php endif; ?> width100per margintop25">
                                    <ul class="downlist">                        
                                    <?php if ($form_cat) : ?>
                                    <?php foreach ($form_cat as $key => $value) : ?>                            
                                        <?php if ($value['download_cat'] != '0') : ?>
                                            <div class="roboto cattext2 margintop30bot20"><?php echo $value['download_cat']; ?></div>
                                        <?php endif; ?>
                                        <?php $forms = $tblsql->get_form(0, 0, 0, $searchform, 0, $value['download_cat'], 0); ?>
                                        <?php if ($forms) : ?>
                                        <?php foreach ($forms as $k => $v) : ?>                            
                                        <li>
                                            <a href="<?php echo WEB; ?>/uploads/download/<?php echo $v['download_filename']; ?>" target="_blank">
                                                <b><i class="fa <?php echo $tblsql->get_form_icon($v['download_attachtype'], $v['download_filename']); ?> fa-lg"></i>&nbsp;&nbsp;<?php echo $v['download_title']; ?></b></a><br>&nbsp;&nbsp;&nbsp;&nbsp;<?php if ($profile_level == 7 || $profile_level == 10 || $profile_idnum == "2016-06-0457") : ?> <a class="btneditform whitetext cursorpoint" attribute="<?php echo $v['download_id']; ?>">Edit</a> | <a class="btndelform redtext cursorpoint" attribute="<?php echo $v['download_id']; ?>">Delete</a><?php endif; ?>

                                        </li>
                                        <?php endforeach; ?>
                                        <?php else : ?>No form found on this category<?php endif; ?>
                                    <?php endforeach; ?>
                                    <?php if ($pages) : ?>
                                    <tr>
                                        <td colspan="2" align="center"><?php echo $pages; ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php else : ?>No form category found<?php endif; ?>
                                    </ul>                  
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>