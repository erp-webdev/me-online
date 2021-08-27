                        <?php if ($section != NULL) { ?><a href="<?php echo WEB; ?>" onclick="clickAndDisable(this);"><?php } ?><div<?php if ($section == NULL) { ?> class="dselected"<?php } ?>>Dashboard</div><?php if ($section != NULL) { ?></a><?php } ?>

                        <?php if ($profile_dbname != 'OJTPAY') : ?>
                        <!--a href="<?php echo WEB; ?>/notification"><div<?php if ($section == "notification") { ?> class="dselected"<?php } ?>>Notifications<?php if ($unread_notification) : ?>&nbsp;&nbsp;<div class="circount"><?php echo $unread_notification; ?></div><?php endif; ?></div></a-->
                        <?php if ($section != "pending") : ?><a href="<?php echo WEB; ?>/pending" onclick="clickAndDisable(this);"><?php endif; ?><div<?php if ($section == "pending") { ?> class="dselected"<?php } ?>>Pending Requests<?php if ($pend_notification) : ?>&nbsp;&nbsp;<div class="circount"><?php echo $pend_notification; ?></div><?php endif; ?></div><?php if ($section != "pending") : ?></a><?php endif; ?>
                        <?php endif; ?>

                        <?php if ($profile_dbname != 'ECINEMA' && $profile_dbname != 'EPARKVIEW' && $profile_dbname != 'NEWTOWN' && $profile_dbname != 'LAFUERZA') : ?>

                        <span class="spanred">NEW!</span><?php if ($section != "ads") { ?><a href="<?php echo WEB; ?>/ads" onclick="clickAndDisable(this);"><?php } ?><div<?php if ($section == "ads") { ?> class="dselected"<?php } ?>>Ads</div><?php if ($section != "ads") { ?></a><?php } ?>
                        <span class="spanred">NEW!</span><?php if ($section != "activity") { ?><a href="<?php echo WEB; ?>/activity" onclick="clickAndDisable(this);"><?php } ?><div<?php if ($section == "activity") { ?> class="dselected"<?php } ?>>Activities</div><?php if ($section != "activity") { ?></a><?php } ?>
                        <span class="spanred">NEW!</span><?php if ($section != "memo") { ?><a href="<?php echo WEB; ?>/memo" onclick="clickAndDisable(this);"><?php } ?><div<?php if ($section == "memo") { ?> class="dselected"<?php } ?>>Memorandum</div><?php if ($section != "memo") { ?></a><?php } ?>


			<?php
			if(in_array($profile_dbname, ['ASIAPMI', 'CITYLINK', 'ECOC', 'ECINEMA', 'EREX', 'LAFUERZA', 'LCTM', 'GL', 'MEGAWORLD', 'MLI', 'NCCAI', 'SIRUS', 'SUNTRUST', 'TOWNSQUARE'])){
				if(date('Y-m-d') >= '2021-05-03' || $profile_idnum == '2019-02-0033' || $profile_idnum == '2016-06-0457' || $profile_idnum == '2013-08-N300'){ ?>
					<span class="spanred">NEW!</span>
				<?php
					if ($section != "coe") {?>
						<a href="<?php echo WEB; ?>/coe" onclick="clickAndDisable(this);"><?php
					} ?>
					<div
				<?php
					if ($section == "coe") {?>
						class="dselected"<?php
					} ?> >COE Requisition</div>
				<?php
					if ($section != "coe") {
				?>	</a><?php
					}
				}
			}

			 ?>

                        <?php endif; ?>

                        <?php if($profile_idnum == '2016-06-0457' || $profile_idnum == '2019-02-0033') : ?>

                        <span class="spanred">NEW!</span><?php if ($section != "lms") { ?><a href="<?php echo WEB; ?>/lms" onclick="clickAndDisable(this);"><?php } ?><div<?php if ($section == "lms") { ?> class="dselected"<?php } ?>>LMS</div><?php if ($section != "lms") { ?></a><?php } ?>

                        <?php endif; // end of LMS menu?>


                        <?php if (in_array($profile_dbname, ['MEGAWORLD', 'MLI', 'GL'])) : ?><span class="spanred">NEW!</span><?php if ($section != "forms") { ?><a href="<?php echo WEB; ?>/forms" onclick="clickAndDisable(this);"><?php } ?><div<?php if ($section == "forms") { ?> class="dselected"<?php } ?>>Forms</div><?php if ($section != "forms") { ?></a><?php } ?><?php endif; ?>

                        <?php if ($section != "directory") { ?><a href="<?php echo WEB; ?>/directory" onclick="clickAndDisable(this);"><?php } ?><div<?php if ($section == "directory") { ?> class="dselected"<?php } ?>>Corporate Phone Directory</div><?php if ($section != "directory") { ?></a><?php } ?>
                        <!--a href="<?php echo WEB; ?>/message"><div<?php if ($section == "message") { ?> class="dselected"<?php } ?>>Messages</div></a-->
                        <?php if ($lv_app || $ot_app || $ob_app || $md_app || $np_app || $sc_app || $wh_app) : ?>
                        <div id="subapp">
                        <div class="appsubmenu downshadow" style="display: none; z-index: 200;">
                            <?php if ($lv_app) : ?><a href="<?php echo WEB; ?>/leave" onclick="clickAndDisable(this);"><div<?php if ($section == "leave") { ?> class="dselected"<?php } ?>>Leave</div></a><?php endif; ?>
                            <?php if ($ot_app) : ?><a href="<?php echo WEB; ?>/overtime" onclick="clickAndDisable(this);"><div<?php if ($section == "overtime") { ?> class="dselected"<?php } ?>>Overtime</div></a><?php endif; ?>
                            <?php if ($ob_app) : ?><a href="<?php echo WEB; ?>/obt" onclick="clickAndDisable(this);"><div<?php if ($section == "obt") { ?> class="dselected"<?php } ?>>Official Business Trip</div></a><?php endif; ?>
                            <?php if ($md_app) : ?><a href="<?php echo WEB; ?>/mandtr" onclick="clickAndDisable(this);"><div<?php if ($section == "mandtr") { ?> class="dselected"<?php } ?>>Manual DTR</div></a><?php endif; ?>
                            <?php if ($np_app) : ?><a href="<?php echo WEB; ?>/npa" onclick="clickAndDisable(this);"><div<?php if ($section == "npa") { ?> class="dselected"<?php } ?>>No Punching Authorization</div></a><?php endif; ?>
							<?php if ($sc_app) : ?><a href="<?php echo WEB; ?>/timesched" onclick="clickAndDisable(this);"><div<?php if ($section == "timesched") { ?> class="dselected"<?php } ?>>Time Scheduler</div></a><?php endif; ?>
                            <?php
                            // $empids_wfh = array("2014-07-N923", "2004-04-8966","2016-06-0457","2000-06-8166","2018-11-0605","2016-06-0144","2010-12-V034","2020-03-0079","1999-09-8123","2019-02-0033","2007-06-M314","2015-03-0093","2019-01-0028","2019-02-0070","2018-08-0453","2016-06-0464","2019-07-0386","2017-04-0933","2018-07-0406","2019-07-0457","2009-07-V177","2011-08-U036",
                            //                     "1993-07-8463","2008-04-M764","2011-07-V980","2006-06-M168","2001-12-8773","1998-08-8602","2001-07-M219","2013-06-N202","2012-05-U417","2008-02-M719","2005-09-M103","2006-06-M163","1997-06-8727","2012-04-U354","1991-10-8274","2007-05-M477","1991-08-8310","1987-07-8128","1996-01-8509","1997-03-8638","2008-06-M829","2013-02-U861","2002-09-8855","1997-05-8715","2012-01-U197",
                            //                     "2001-10-8752","2009-07-V176","2013-03-U940","2016-04-0140","2016-06-0145","2017-11-0016","2019-01-0000","2019-02-0002","2019-09-0133","1990-03-8284");
                                      // && in_array($profile_idnum, $empids_wfh)
                            if ($wh_app) :
                              if($wfh_user[0]["EmpID"] == $profile_idnum && $wfh_user[0]["DBNAME"] == $profile_dbname){?>
                                <a href="<?php echo WEB; ?>/wfh" onclick="clickAndDisable(this);"><div<?php if ($section == "wfh") { ?> class="dselected"<?php } ?>>Work From Home</div></a>
                            <?php
                              }
                            endif; ?>


                            <?php if (false) : ?><a href="<?php echo WEB; ?>/otherforms" onclick="clickAndDisable(this);"><div<?php if ($section == "otherforms") { ?> class="dselected"<?php } ?>>Other Forms</div></a><?php endif; ?>
                        </div>
                        <a id="applink" class="cursorpoint"><div<?php if ($section == "wfh" || $section == "leave" || $section == "overtime" || $section == "obt" || $section == "meal" || $section == "mandtr" || $section == "cts" || $section == "npa" || $section == "timesched") { ?> class="dselected"<?php } ?>>Application</div></a>
                        </div>
                        <?php endif; ?>
                        <?php if ($profile_dbname != 'OJTPAY') : ?>
                        <?php if ($section != "myrequest") : ?><a href="<?php echo WEB; ?>/myrequest" onclick="clickAndDisable(this);"><?php endif; ?><div<?php if ($section == "myrequest") { ?> class="dselected"<?php } ?>>My Request</div><?php if ($section != "myrequest") : ?></a><?php endif; ?>
                        <?php endif; ?>
                        <?php if (!$_SESSION['megassep_admin'] && $profile_dbname != 'OJTPAY') : ?>
                        <?php if ($section != "leavebal") { ?><a href="<?php echo WEB; ?>/leavebal" onclick="clickAndDisable(this);"><?php } ?><div<?php if ($section == "leavebal") { ?> class="dselected"<?php } ?>>Leave Balance</div><?php if ($section != "leavebal") { ?></a><?php } ?>
                        <?php if ($llblock) { ?>
                        <span class="spanred">NEW!</span><?php if ($section != "loanledger") { ?><a href="<?php echo WEB; ?>/loanledger" onclick="clickAndDisable(this);"><?php } ?><div<?php if ($section == "loanledger") { ?> class="dselected"<?php } ?>>Loan Ledger</div><?php if ($section != "loanledger") { ?></a><?php } ?>
                        <?php } ?>
                        <?php endif; ?>
                        <?php if ($section != "dtr") { ?><a href="<?php echo WEB; ?>/dtr" onclick="clickAndDisable(this);"><?php } ?><div<?php if ($section == "dtr") { ?> class="dselected"<?php } ?>>Daily Time Record</div><?php if ($section != "dtr") { ?></a><?php } ?>
                        <?php if (!$_SESSION['megassep_admin'] && $profile_dbname != 'OJTPAY') : ?>
                        <?php if ($psblock && $profile_dbname != 'OJTPAY') : ?>
                        <?php if ($section != "payslip") { ?><a href="<?php echo WEB; ?>/payslip" onclick="clickAndDisable(this);"><?php } ?><div<?php if ($section == "payslip") { ?> class="dselected"<?php } ?>>Payslip</div><?php if ($section != "payslip") { ?></a><?php } ?>
                        <?php endif; ?>
                        <?php endif; ?>

						<?php //if ($profile_dbname != 'ECINEMA' && $profile_dbname != 'EPARKVIEW' && $profile_dbname != 'NEWTOWN') : ?>
                        <?php if ($profile_dbname != 'EPARKVIEW' && $profile_dbname != 'NEWTOWN') : ?>
                        <a href="<?php echo WEB; ?>/paf" onclick="clickAndDisable(this);"><div<?php if (($section == "paf")||($section == "pafevaluate")||($section == "pafview")) { ?> class="dselected"<?php } ?>>Performance Management</div></a>
                        <?php endif; ?>

                        <!-- addon -->
                        <!--a href="<?php echo WEB; ?>/paysummary"><div<?php if ($section == "paysummary") { ?> class="dselected"<?php } ?>>Payroll Summary</div></a-->
                        <?php if ($profile_level >= 9 || $profile_idnum == '2019-02-0033') : ?>
                        <!--a href="<?php echo WEB; ?>/userman"><div<?php if ($section == "userman") { ?> class="dselected"<?php } ?>>Employees Management</div></a-->
                        <?php if ($section != "reqman") { ?><a href="<?php echo WEB; ?>/reqman" onclick="clickAndDisable(this);"><?php } ?><div<?php if ($section == "reqman") { ?> class="dselected"<?php } ?>>Requests Management</div><?php if ($section != "reqman") { ?></a><?php } ?>
                        <?php if ($section != "approvers") { ?><a href="<?php echo WEB; ?>/approvers" onclick="clickAndDisable(this);"><?php } ?><div<?php if ($section == "approvers") { ?> class="dselected"<?php } ?>>Approvers Management</div><?php if ($section != "approvers") { ?></a><?php } ?>
                        <?php if ($section != "dtrman") { ?><a href="<?php echo WEB; ?>/dtrman" onclick="clickAndDisable(this);"><?php } ?><div<?php if ($section == "dtrman") { ?> class="dselected"<?php } ?>>System &amp; DTR Management</div><?php if ($section != "dtrman") { ?></a><?php } ?>

                        <?php endif; ?>

                        <?php if ($profile_ps) : ?>
                        <a href="<?php echo WEB; ?>/pslipman"><div<?php if ($section == "pslipman") { ?> class="dselected"<?php } ?>>Payslip Management</div></a>
                        <?php endif; ?>


                        <?php if (in_array($profile_idnum, $adminarray3)) : ?>
                        <?php if ($section != "empupdate") { ?><a href="<?php echo WEB; ?>/empupdate" onclick="clickAndDisable(this);"><?php } ?><div<?php if ($section == "empupdate") { ?> class="dselected"<?php } ?>>Updates Management</div><?php if ($section != "empupdate") { ?></a><?php } ?>
                        <?php if ($section != "bday") { ?><a href="<?php echo WEB; ?>/bday" onclick="clickAndDisable(this);"><?php } ?><div<?php if ($section == "bday") { ?> class="dselected"<?php } ?>>Birthday Card Management</div><?php if ($section != "bday") { ?></a><?php } ?>
                        <?php endif; ?>

                        <?php


                            if ($profile_dbname == 'GL') : $hash = 'gl0b_2018';
                            else : $hash = 'mega_2018';
                            endif;

                            $itrfile = DOCUMENT.'/uploads/itr/2018/'.md5($hash.$profile_dbname.$profile_idnum).'.pdf';

                            //var_dump($hash.' '.$profile_dbname);

                            ?>
                            <?php

                            if (file_exists($itrfile) && ($profile_dbname == 'ECINEMA' || $profile_dbname == 'EPARKVIEW' || $profile_dbname == 'GLOBAL_HOTEL') && date('Y-m-d') <= '2018-02-19') :
                                ?>
                                <div class="dashcomp dashincentive">
                                    <span class="roboto orangetext mediumtext">Your 2017 Income Tax Return Form (BIR 2316)</span><br><br>
                                    <center class="robotobold dgraytext smalltext2"><a href="<?php echo WEB; ?>/uploads/itr/2018/<?php echo md5($hash.$profile_dbname.$profile_idnum); ?>.pdf" target="_blank">Download here</a>
                                    <?php if ($profile_dbname != 'GL') : ?>
                                    <br><br><span class="vsmalltext ">(Due Date: Feb 19, 2018)</span></center>
                                    <?php endif; ?>
                                </div>
                                <?php
                            else :
                                ?>
                                <!--div class="dashcomp dashincentive">
                                    <span class="roboto dbluetext cattext2">Your 2015 Income Tax Return Form (BIR 2316)</span><br><br>
                                    <center>No ITR has been uploaded on your acount. Please contact local 242.</center>
                                </div-->
                                <?php
                            endif;
                        ?>
