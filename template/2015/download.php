	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->

                    <div id="floatdiv" class="floatdiv invisible">                                        
                        
                        <div id="mview" class="fview" style="display: none;">
                            <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                            <div id="mview_title" class="robotobold cattext dbluetext"></div>
                            <div id="ads_data" class="floatdata margintop15">
                            </div>
                        </div>
                        
                        <?php if ($profile_level == 7 || $profile_level == 9 || $profile_level == 10) : ?>
                        <!-- CREATE MEMO - BEGIN --> 
                        <div id="madd" class="fadd" style="display: none;">
                            <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                            <div id="madd_title" class="robotobold cattext dbluetext">Create Ads</div>
                            <table class="tdataform2 rightmargin margintop10 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">
                                <form name="create_ads" id="create_ads" action="?ignore-page-cache=true" method="POST" enctype="multipart/form-data">
                                <tr>
                                    <td>Ads Title</td>
                                    <td>
                                        <input type="text" name="activity_title" id="activity_title" value="<?php echo $_POST['activity_title']; ?>" class="txtbox width300" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date</td>
                                    <td>
                                        <input type="text" name="activity_date" id="activity_date" class="txtbox checkindate width95" value="<?php echo date("Y-m-d"); ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Attachment</td>
                                    <td>
                                        <input type="file" name="activity_attach" id="activity_attach" class="txtbox width200" class="txtbox" /><br /><i>* must be image (jpg, jpeg, gif, png) or PDF and less than or equal 10Mb</i>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center">
                                        <input type="submit" name="btncreateads" id="btncreateads" value="Create" class="btn btncreateads" />
                                        <input type="hidden" name="activity_user" id="activity_user" value="<?php echo $profile_id; ?>" />
                                        <input type="hidden" name="pagenum" id="pagenum" value="<?php echo $_GET['page'] ? $_GET['page'] : 1; ?>" />
                                    </td>
                                </tr>
                                </form>
                            </table>  
                        </div>
                        <!-- CREATE MEMO - END -->                    
                        <!-- UPDATE MEMO - BEGIN --> 
                        <div id="medit" class="fedit" style="display: none;">
                            <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                            <div id="medit_title" class="robotobold cattext dbluetext">Update Ads</div>
                            <input type="hidden" id="json_data" name="json_data" />
                            <table class="tdataform2 rightmargin margintop10 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">
                                <form name="edit_ads" id="edit_ads" method="POST" action="?ignore-page-cache=true" enctype="multipart/form-data">
                                
                                <tr>
                                    <td>Ads Title</td>
                                    <td>
                                        <input type="text" name="activity_title" id="uactivity_title" class="txtbox width300" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date</td>
                                    <td>
                                        <input type="text" name="activity_date" id="uactivity_date" class="txtbox checkindate width95" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Attachment</td>
                                    <td>
                                        <input type="file" name="activity_attach" id="uactivity_attach" class="txtbox width200" /><br /><i>* must be image (jpg, jpeg, gif, png) or PDF and less than or equal 10Mb</i>
                                    </td>
                                    
                                </tr>
                            
                                <tr>
                                    <td colspan="2" align="center">
                                        <input type="submit" name="btnupdateads" value="Update" class="btn btnupdateads" />
                                        <input type="submit" name="btnresendads" value="Send Ads to Employees via Email" class="btn btnresendads" />
                                        <input type="hidden" name="activity_attachment" id="uactivity_attachment" />
                                        <input type="hidden" name="activity_user" id="uactivity_user" />
                                        <input type="hidden" name="activity_id" id="uactivity_id" />
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
                                <b class="mediumtext lorangetext">FORMS</b><br><br>                                
                                
                                <table class="width100per">
                                    <tr>
                                        <td><!--span class="fa fa-search"></span> Search by: 
                                            <input type="text" id="searchdownload" name="searchdownload" value="<?php echo $_SESSION['searchdownload'] ? $_SESSION['searchdownload'] : ''; ?>" placeholder="download title" class="smltxtbox" />&nbsp;
                                            <input type="button" id="btnsearchdownload" name="btnsearchdownload" value="Search" class="smlbtn btnsearchdownload" />
                                            <input type="button" id="btnsearchalldownload" name="btnsearchalldownload" value="View All" class="btnsearchalldownload smlbtn<?php if (!$_SESSION['searchdownload']) : ?> invisible<?php endif; ?>" /-->                                            
                                        </td>
                                        <td class="righttalign">
                                            <?php if ($profile_level == 7 || $profile_level == 9 || $profile_level == 10) : ?>
                                            <input type="button" id="btnadddownload" name="btnadddownload" value="Upload Forms" class="btnadddownload smlbtn" />
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                                
                                <div id="downdata" class="dirheight">
                                <div class="valigntop<?php if ($download_count > 20) : ?> twocolumn<?php endif; ?> width100per margintop25">
                                    <ul class="downlist">                        
                                    <?php if ($download_cat) : ?>
                                    <?php foreach ($download_cat as $key => $value) : ?>                            
                                        <?php if ($value['download_cat'] != '0') : ?>
                                            <div class="roboto cattext2 margintop30bot20"><?php echo $value['download_cat']; ?></div>
                                        <?php endif; ?>
                                        <?php $downloads = $tblsql->get_download(0, 0, 0, $searchdown, 0, $value['download_cat'], 0); ?>
                                        <?php if ($downloads) : ?>
                                        <?php foreach ($downloads as $k => $v) : ?>                            
                                        <li>
                                            <a href="<?php echo WEB; ?>/uploads/download/<?php echo $v['download_filename']; ?>" target="_blank">
                                                <b><i class="fa <?php echo $tblsql->get_download_icon($v['download_attachtype'], $v['download_filename']); ?> fa-lg"></i>&nbsp;&nbsp;<?php echo $v['download_title']; ?></b></a><br>&nbsp;&nbsp;&nbsp;&nbsp;<span class="adminbox"> <a class="btneditdown whitetext cursorpoint" attribute="<?php echo $v['download_id']; ?>">Edit</a> | <a class="btndeldown redtext cursorpoint" attribute="<?php echo $v['download_id']; ?>">Delete</a></span>

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