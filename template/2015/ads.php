	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->

                    <div id="floatdiv" class="floatdiv invisible">                                        
                        
                        <div id="adview" class="fview" style="display: none;">
                            <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                            <div id="adview_title" class="robotobold cattext dbluetext"></div>
                            <div id="ads_data" class="floatdata margintop15">
                            </div>
                        </div>
                        
                        <?php if ($profile_level == 7 || $profile_level == 9 || $profile_level == 10 || 
                            $accessman->hasAccess($profile_id, $profile_dbname, $profile_comp, 'ads')) : ?>
                        <!-- CREATE ADS - BEGIN --> 
                        <div id="adadd" class="fadd" style="display: none;">
                            <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                            <div id="adadd_title" class="robotobold cattext marginbottom15 dbluetext">Create Ads</div>
                            <table class="tdataform2 rightmargin margintop15 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">
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
                                    <td>Image</td>
                                    <td>
                                        <input type="file" name="activity_attach" id="activity_attach" class="txtbox width200" class="txtbox" /><br /><i>* must be image (jpg, jpeg, gif, png) or PDF and less than or equal 10Mb</i>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center" class="paddingtop45">
                                        <input type="submit" name="btncreateads" id="btncreateads" value="Create" class="btn btncreateads" />
                                        <input type="hidden" name="activity_user" id="activity_user" value="<?php echo $profile_id; ?>" />
                                        <input type="hidden" name="pagenum" id="pagenum" value="<?php echo $_GET['page'] ? $_GET['page'] : 1; ?>" />
                                    </td>
                                </tr>
                                </form>
                            </table>  
                        </div>
                        <!-- CREATE ADS - END -->                    
                        <!-- UPDATE ADS - BEGIN --> 
                        <div id="adedit" class="fedit" style="display: none;">
                            <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                            <div id="adedit_title" class="robotobold cattext dbluetext marginbottom15">Update Ads</div>
                            <input type="hidden" id="json_data" name="json_data" />
                            <table class="tdataform2 rightmargin margintop15 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">
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
                                    <td>Image</td>
                                    <td>
                                        <input type="file" name="activity_attach" id="uactivity_attach" class="txtbox width200" /><br /><i>* must be image (jpg, jpeg, gif, png) or PDF and less than or equal 10Mb</i>
                                    </td>
                                    
                                </tr>
                            
                                <tr>
                                    <td colspan="2" align="center" class="paddingtop45">
                                        <input type="submit" name="btnupdateads" value="Update" class="btn btnupdateads" />
                                        <input type="submit" name="btnresendads" value="Send Ads to Employees via Email" class="btn btnresendads" />
                                        <input type="hidden" name="activity_filename" id="uactivity_filename" />
                                        <input type="hidden" name="activity_db" id="uactivity_db" />
                                        <input type="hidden" name="activity_user" id="uactivity_user" value="<?php echo $profile_id; ?>" />
                                        <input type="hidden" name="activity_id" id="uactivity_id" />
                                        <input type="hidden" name="pagenum" id="pagenum" value="<?php echo $_GET['page'] ? $_GET['page'] : 1; ?>" />
                                    </td>
                                </tr>
                                </form>
                            </table> 
                        </div>
                        <!-- UPDATE ADS - END -->                    
                        <?php endif; ?>
                    </div>
                    
                    <div id="mainsplashtext" class="mainsplashtext lefttalign">  
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">
                            <div id="mainads" class="mainbody lefttalign whitetext">  
                                <b class="mediumtext lorangetext">ADS <?php var_dump($profile_dbname); ?></b><br><br>                                
                                
                                <table class="width100per">
                                    <tr>
                                        <td><span class="fa fa-search"></span> Search by: 
                                            <input type="text" id="searchads" name="searchads" value="<?php echo $_SESSION['searchads'] ? $_SESSION['searchads'] : ''; ?>" placeholder="ads title" class="searchads smltxtbox" />&nbsp;
                                            <input type="button" id="btnsearchads" name="btnsearchads" value="Search" class="smlbtn btnsearchads" />
                                            <input type="button" id="btnsearchallads" name="btnsearchallads" value="View All" class="btnsearchallads smlbtn<?php if (!$_SESSION['searchads']) : ?> invisible<?php endif; ?>" />                                            
                                        </td>
                                        <td class="righttalign">
                                            <?php if ($profile_level == 7 || $profile_level == 10 || $accessman->hasAccess($profile_id, $profile_dbname, '')) : ?>
                                            <input type="button" id="btnaddads" name="btnaddads" value="Create Ads" class="btnaddads smlbtn" />
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                                
                                <div id="adsdata">
                                <table border="0" cellspacing="0" class="tdata width100per margintop25">
                                    <?php if ($ads_data) : ?>
                                    <?php foreach ($ads_data as $key => $value) : ?>                                    
                                    <tr class="trdata centertalign">
                                        <td width="30%"<?php if ($key == 0) : ?> class="topborder"<?php endif; ?>><span attribute="<?php echo $value['activity_id']; ?>" attribute2="<?php echo $value['activity_title']; ?>" class="btnviewads"><img src="<?php echo WEB; ?>/uploads/<?php echo $value['activity_ads'] ? 'ads' : 'activity'; ?>/<?php echo $value['activity_filename']; ?>" class="activity_img cursorpoint" /></span></td>
                                        <td width="70%" class="lefttalign<?php if ($key == 0) : ?> topborder<?php endif; ?>"><span class="btnviewads cursorpoint bold" attribute="<?php echo $value['activity_id']; ?>" attribute2="<?php echo $value['activity_title']; ?>"><?php echo $value['activity_title']; ?></span><?php if ($profile_level == 7 || $profile_level == 10 || $accessman->hasAccess($profile_id, $profile_dbname, 'ads')) : ?><br><span class="btneditads cursorpoint" attribute="<?php echo $value['activity_id']; ?>">Edit</span> | <span class="btndelads cursorpoint" attribute="<?php echo $value['activity_id']; ?>">Delete</span><?php endif; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if ($pages) : ?>
                                    <tr>
                                        <td colspan="2" class="centertalign"><?php echo $pages; ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php else : ?>
                                    <tr>
                                        <td class="bold centertalign noborder"><br><br>You have no ads listed</td>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                                <input type="hidden" id="adspage" name="adspage" value="<?php echo $page; ?>" />   
                                </div>
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>