	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->

                    <div id="floatdiv" class="floatdiv invisible">
                        <?php if (in_array($profile_level, [7, 9, 10]) || 
                            $accessman->hasAccess($profile_id, $profile_dbname, 'memo')) : ?>
                        <!-- CREATE MEMO - BEGIN -->
                        
                        <div id="madd" class="fadd" style="display: none;">
                            <div class="closebutton cursorpoint"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                            <div id="madd_title" class="robotobold cattext dbluetext">Create Memo</div>
                            <table class="tdataform2 rightmargin margintop10 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">
                                <form name="create_memo" id="create_memo" action="?ignore-page-cache=true" method="POST" enctype="multipart/form-data">
                                <tr>
                                    <td>Memo Title</td>
                                    <td>
                                        <input type="text" name="memo_title" id="memo_title" value="<?php echo $_POST['memo_title']; ?>" class="txtbox width300" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date</td>
                                    <td>
                                        <input type="text" name="memo_date" id="memo_date" class="txtbox checkindate width95" value="<?php echo date("Y-m-d"); ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Attachment</td>
                                    <td>
                                        <input type="file" name="memo_attach" id="memo_attach" class="txtbox width200" class="txtbox" /><br /><i>* must be image (jpg, jpeg, gif, png) or PDF and less than or equal 10Mb</i>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center">
                                        <input type="submit" name="btncreatememo" id="btncreatememo" value="Create" class="btn btncreatememo" />
                                        <input type="hidden" name="memo_user" id="memo_user" value="<?php echo $profile_id; ?>" />
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
                            <div id="medit_title" class="robotobold cattext dbluetext">Update Memo</div>
                            <input type="hidden" id="json_data" name="json_data" />
                            <table class="tdataform2 rightmargin margintop10 vsmalltext" width="100%" border="0" cellpadding="0" cellspacing="0">
                                <form name="edit_memo" id="edit_memo" method="POST" action="?ignore-page-cache=true" enctype="multipart/form-data">

                                <tr>
                                    <td>Memo Title</td>
                                    <td>
                                        <input type="text" name="memo_title" id="umemo_title" class="txtbox width300" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date</td>
                                    <td>
                                        <input type="text" name="memo_date" id="umemo_date" class="txtbox checkindate width95" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Attachment</td>
                                    <td>
                                        <input type="file" name="memo_attach" id="umemo_attach" class="txtbox width200" /><br /><i>* must be image (jpg, jpeg, gif, png) or PDF and less than or equal 10Mb</i>
                                    </td>

                                </tr>

                                <tr>
                                    <td colspan="2" align="center">
                                        <input type="submit" name="btnupdatememo" value="Update" class="btn btnupdatememo" />
                                        <input type="submit" name="btnresendmemo" value="Send Memo to Employees via Email" class="btn btnresendmemo" />
                                        <input type="hidden" name="memo_filename" id="umemo_filename" />
                                        <input type="hidden" name="memo_db" id="umemo_db" />
                                        <input type="hidden" name="memo_user" id="umemo_user" value="<?php echo $profile_id; ?>" />
                                        <input type="hidden" name="memo_id" id="umemo_id" />
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
                            <div id="mainmemo" class="mainbody lefttalign whitetext">
                                <b class="mediumtext lorangetext">MEMORANDUM</b><br><br>

                                <table class="width100per">
                                    <tr>
                                        <td><span class="fa fa-search"></span> Search:
                                            <input type="text" id="memofrom" name="memofrom" value="<?php echo $_SESSION['memofrom'] ? $_SESSION['memofrom'] : '08/01/2014'; ?>" placeholder="From.." class="smltxtbox width55 datepick" /> -
                                            <input type="text" id="memoto" name="memoto" value="<?php echo $_SESSION['memoto'] ? $_SESSION['memoto'] : date("m/d/Y"); ?>" placeholder="To..." class="smltxtbox width55 datepick" /> by
                                            <input type="text" id="searchmemo" name="searchmemo" value="<?php echo $_SESSION['searchmemo'] ? $_SESSION['searchmemo'] : ''; ?>" placeholder="memo title" class="smltxtbox searchmemo" />&nbsp;
                                            <input type="button" id="btnsearchmemo" name="btnsearchmemo" value="Search" class="smlbtn btnsearchmemo" />
                                            <input type="button" id="btnsearchallmemo" name="btnsearchallmemo" value="View All" class="btnsearchallmemo smlbtn<?php if (!$_SESSION['searchmemo'] && !$_SESSION['memofrom'] && !$_SESSION['memoto']) : ?> invisible<?php endif; ?>" />
                                        </td>
                                        <td class="righttalign">
                                            <?php if ($profile_level == 7 || $profile_level == 10 ) : ?>
                                            <input type="button" id="btnaddmemo" name="btnaddmemo" value="Create Memo" class="btnaddmemo smlbtn" />
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>

                                <div id="memodata">
                                <table border="0" cellspacing="0" class="tdata width100per margintop25">
                                    <?php if ($memo_data) : ?>
                                    <?php foreach ($memo_data as $key => $value) : ?>
                                    <tr class="trdata centertalign">
                                        <td width="30%"<?php if ($key == 0) : ?> class="topborder"<?php endif; ?>>
                                            <a href="<?php echo WEB; ?>/uploads/memo/<?php echo $value['announce_filename']; ?>" target="_blank">
                                                <button class="smlbtn cursorpoint">View</button>
                                            </a>
                                        </td>
                                        <td width="70%" class="lefttalign<?php if ($key == 0) : ?> topborder<?php endif; ?>"><span class="bold"><?php echo $value['announce_title']; ?></span><br>Published: <?php echo date('F j, Y', $value['announce_date']); ?><?php if ($profile_level == 7 || $profile_level == 10 || $profile_idnum == "2016-06-0457") : ?><br><span class="btneditmemo cursorpoint" attribute="<?php echo $value['announce_id']; ?>">Edit</span> | <span class="btndelmemo cursorpoint" attribute="<?php echo $value['announce_id']; ?>">Delete</span><?php endif; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if ($pages) : ?>
                                    <tr>
                                        <td colspan="2" class="centertalign"><?php echo $pages; ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php else : ?>
                                    <tr>
                                        <td class="bold centertalign noborder"><br><br>You have no memo listed</td>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                                <input type="hidden" id="memopage" name="memopage" value="<?php echo $page; ?>" />
                                </div>
                            </div>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>
