	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
                    <div id="floatdiv" class="floatdiv ">                                        
                        <div id="adview" class="fview" style="width: 700px !important; ">
                            <div class="closebutton cursorpoint" style="margin-left: 700px" onclick="stopmeg(this)"><i class="fa fa-times-circle fa-3x redtext"></i></div>
                            <div id="ads_data" class="floatdata margintop15">
                                <video id="meg33" width="100%" controls >
                                    <source src="<?php echo WEB; ?>/uploads/ltg_megaworld_turns_33.mp4" type="video/mp4" autoplay>
                                </video>
                            </div>
                            <div id="adview_title" class="robotobold cattext dbluetext" style="text-align:center">Megaworld Turns 33</div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function () {
                            // $(".floatdiv").removeClass("invisible");
                            // $("#adview").show({
                            //     effect : 'slide',
                            //     easing : 'easeOutQuart',
                            //     direction : 'up',
                            //     duration : 500
                            // });
                        });

                        function stopmeg() {
                            var vid = document.getElementById("meg33");
                            vid.pause();
                        }
                    </script>
                    <div id="mainsplashtext" class="mainsplashtext lefttalign" >
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">

                            <div class="notifloat">
                                <?php
                                    $date1 = date("Y-m-d");
                                    $date2 = "2016-12-25";
                                    $diff = abs(strtotime($date2) - strtotime($date1));
                                    $xmascount = $diff / (60 * 60 * 24);
                                    //var_dump($xmascount);
                                ?>
                                <?php if ($xmascount <= 100) : ?>
                                <!--div id="mainnotification" class="xmas centertalign whitetext mediumtext2">
                                    <b><?php echo $xmascount; ?> days to go before Xmas!</b>
                                </div><br-->
                                <?php endif; ?>

                                <?php if ($cutoff_date) : ?>
                                <div id="mainnotification" class="lefttalign whitetext marginbottom25">
                                    <b class="smalltext dorangetext">REMINDER</b><br><br>
                                    <?php if (date('Y-m-d H:i:s') >= '2017-11-03 00:00:00') : ?>
                                    Deadline for this cutoff will be <?php echo date("F j, Y", strtotime($cutoff_date)); ?><br><br>
                                    <?php endif; ?>

                                    <?php if (date('Y-m-d H:i:s') <= '2017-11-10 18:00:00') : ?>
                                    <span class="yellowtext">Timekeeping forms for November 10, 2017 Payday should be SUBMITTED and APPROVED before November 2, 2017.<br>This is due to the early cutoff and the series of long Holidays.<br><br>Raw and Processed DTR from Offsite Locations should also be submitted on the same date.</span>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>

                                <?php if(in_array($profile_dbname, ['ASIAAPMI', 'CITYLINK', 'LCTM', 'MLI', 'SIRUS', 
                                    'ECOC', 'ECINEMA', 'MCTI', 'EREX', 'Rowenta', 'NCCAI', 'MREIT', 'TOWNSQUARE', 'MEGAWORLD', 'GL', 'GLOBAL_HOTEL', 'NEWTOWN', 'LAFUERZA'])): ?>
                                <?php
                                    $display = true;
									$deadline = '2022-01-25';

                                    if(in_array($profile_dbname, ['TOWNSQUARE', 'MEGAWORLD', 'GL', 'GLOBAL_HOTEL', 'NEWTOWN', 'LAFUERZA'])){
                                        $deadline = '2022-02-11';
                                            if(date('Y-m-d') > date('Y-m-d' ,strtotime($deadline)))
                                                $display = false;
                                    }

                                    switch ($profile_dbname) {
                                        case 'ASIAAPMI':
											$deadline = '2022-02-28';
                                            if(date('Y-m-d') > date('Y-m-d' ,strtotime($deadline)))
                                                $display = false;
											break;
										default:
											$display = true;
                                    }
                                 ?>

                                <div class="dashcomp dashincentive invisible" style="width: 90%; margin: 0; padding: 5%; <?php if(!$display) echo 'display:none'; ?>">
                                    <span class="roboto orangetext mediumtext">Your 2021 Income Tax Return Form (BIR 2316)</span><br><br>
                                    <center class="robotobold dgraytext smalltext2"><a style="color:blue"  href="<?php echo WEB; ?>/itr" >Download here</a>
                                    <?php if (in_array($profile_dbname, ['GL', 'LAFUERZA', 'MCTI', 'MLI', 'NCCAI', 'TOWNSQUARE', 'MEGAWORLD','GLOBAL_HOTEL', 'SUNTRUST', 'NEWTOWN', 
                                    'SIRUS', 'LCTM', 'EREX', 'ECOC', 'ECINEMA', 'CITYLINK', 'Rowenta', 'MREIT'])) : ?>
                                    
                                    </center>
                                   
                                        <br>- Due Date: <b><?php echo date('F j, Y', strtotime($deadline)); ?></b>
                                        <br>- Fill-up item No. <b>6, 6A, 7, 52 & 54</b>
                                        <br>- Save in .pdf file with name format (ALL CAPS) <br><b style="font-size: 9px"> SURNAME_9DIGITTINNO.-0000_12312021</b>
                                        <br> <b><i style="font-size:8px;"> ex: DELACRUZ_123-456-789-0000_12312021.pdf</i><b>
                                        <br>- Send the ITR to  
                                            <?php 
                                                $itr_mailto="";
                                                if(in_array($profile_dbname, [''])){
                                                    $itr_mailto= 'manastacio.global@megaworldcorp.com';
                                                }elseif(in_array($profile_dbname, ['LCTM', 'MLI', 'CITYLINK'])){
                                                    $itr_mailto= 'mpcasabon.global@megaworldcorp.com';
                                                }elseif(in_array($profile_dbname, ['Rowenta', 'SIRUS', 'ECOC'])){
                                                    $itr_mailto= 'jeleazar.global@megaworldcorp.com';
                                                }elseif(in_array($profile_dbname, ['ECINEMA', 'MCTI', 'EREX'])){
                                                    $itr_mailto= ' jfabay.global@megaworldcorp.com';
                                                }elseif(in_array($profile_dbname, ['TOWNSQUARE', 'MEGAWORLD', 'GL', 'GLOBAL_HOTEL', 'NEWTOWN', 'LAFUERZA'])){
                                                    $itr_mailto= 'payroll.bir2316@megaworldcorp.com';
                                                }

                                            ?>
                                        <b ><a style="font-size:9px;  color:blue" href="mailto: <?php echo $itr_mailto; ?> "><?php echo $itr_mailto; ?></a> </b>
                                        <br>- Subject : <b>ITR 2021 - Company Name<b>
                                        <br><i>Non-submission, BIR impose 1,000 penalty for each employee which will be charge to employee</i>
                                    </ul>
                                    
                                    <?php endif; ?>
                                </div>
                                <br>
                                <br>
                                <?php endif; ?>
                                <?php if ($profile_dbname != 'ECINEMA' && $profile_dbname != 'EPARKVIEW' && $profile_dbname != 'NEWTOWN' && $profile_dbname != 'LAFUERZA') : ?>

                                <div id="mainnotification" class=" dashincentive lefttalign whitetext marginbottom25">
                                    <b class="">Megaworld Turns 33</b>
                                </div>

                                <!--<?php if (date('Y-m-d') >= '2018-01-08') : ?>
                                <div id="mainnotification" class="lefttalign whitetext marginbottom25">
                                    <b class="smalltext dorangetext">2018 EVENT PREFERENCE</b><br>
                                    Please answer question on the link below<br>Click <a href="https://goo.gl/forms/JvTQi4FyKoRlcHbc2" class="yellowtext" target="_blank">here</a>
                                </div>
                                <?php endif; ?>-->


                                <!--div id="mainnotification" class="lefttalign whitetext">
                                    <b>VIDEOS</b><br>
                                    <span class="smalltext dorangetext">
                                    Sportsfest 2017 -
                                    <a href="https://youtu.be/UK_16gf0vPE" class="yellowtext" target="_blank">WATCH THIS!!!</a>
                                    </span>
                                </div-->
                                <!--<?php if (date('Y-m-d H:i:s')) : ?>
                                <div id="mainnotification" class="lefttalign whitetext marginbottom25">
                                    <b class="smalltext dorangetext">Mother's Day Feedback</b><br>Click <a href="https://goo.gl/forms/hyHzA1VBx3dyWnbo1" class="yellowtext" target="_blank">here</a>
                                </div>
                                <?php endif; ?>-->


                                 <?php if (date('Y-m-d H:i:s') <= '2020-02-28 23:59:00') : ?>
                                <div id="mainnotification" class="lefttalign whitetext marginbottom25">
                                    <b class="smalltext dorangetext">Valentine's Day Event Feedback</b><br> Click <a href="https://docs.google.com/forms/d/e/1FAIpQLSf-RzwbZQvDi3cYFsk5q735OrkKldULeJbcaVXvAACHQ0kz_Q/viewform?vc=0&c=0&w=1" class="yellowtext" target="_blank">here</a>
                                </div>
                                <?php endif; ?>

                                <?php if (date('Y-m-d H:i:s') <= '2018-12-06 23:59:00') : ?>
                                <div id="mainnotification" class="lefttalign whitetext marginbottom25">
                                    <b class="smalltext dorangetext">Family Fun Day Event Feedback</b><br> Click <a href="https://docs.google.com/forms/d/1AzV9i25EDUQYfMHZBXt6LuVrd9PRSfI_6x2JbFDu78s/viewform?edit_requested=true%5C" class="yellowtext" target="_blank">here</a>
                                </div>
                                <?php endif; ?>

                                 <?php if (date('Y-m-d H:i:s') <= '2019-08-09 23:59:00') : ?>
                                <div id="mainnotification" class="lefttalign whitetext marginbottom25">
                                    <b class="smalltext dorangetext">Company Anniversary Feedback</b><br> Click <a href="https://docs.google.com/forms/d/e/1FAIpQLSft3dud2_ZIHZ4ago6P1Ci2yKDxbk4XIuvpDUBkhD0b82xM8A/viewform" class="yellowtext" target="_blank">here</a>
                                </div>
                                <?php endif; ?>

                                 <?php if (date('Y-m-d H:i:s') <= '2020-01-17 23:59:00') : ?>
                                <div id="mainnotification" class="lefttalign whitetext marginbottom25">
                                    <b class="smalltext dorangetext">The Dazzling Christmas Ball 2019: A Megaworld Celebration Event Feedback Form  </b><br> Click <a href="https://docs.google.com/forms/d/e/1FAIpQLSfP1bUvCRfi8cUgFdiGG9howOypHlb4d6jYp9Hwri6iV-nrGA/viewform?vc=0&c=0&w=1" class="yellowtext" target="_blank">here</a>
                                </div>
                                <?php endif; ?>

                                <?php if (in_array($profile_dbname , ['GL']) ) : ?>
                                     <?php if (date('Y-m-d H:i:s') <= '2019-10-31 23:59:00') : ?>
                                    <div id="mainnotification" class="lefttalign whitetext marginbottom25">
                                        <b class="smalltext dorangetext">5th Year Anniversary Celebration Feedback</b><br> Click <a href="https://docs.google.com/forms/d/e/1FAIpQLSc5iQP8R91TTo7_P-8vTT5Qr3AZNvn77zyDd5HfUiw858TrSQ/viewform?vc=0&c=0&w=1" class="yellowtext" target="_blank">here</a>
                                    </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <!--div id="mainnotification" class="lefttalign whitetext margintop25">
                                    <b class="smalltext dorangetext">Megaworld EATscapades Survey </b><br>Please answer the survey on the link provided. Click <a href="https://goo.gl/forms/f46lEAm9rDlc8wLo2" class="yellowtext" target="_blank">here</a></b>
                                </div-->
                                <!--div id="mainnotification" class="lefttalign whitetext">
                                    <b class="smalltext dorangetext">NOTIFICATIONS</b><br><br>
                                    You have <a href="<?php echo WEB; ?>/notification" class="bold whitetext"><?php echo $unread_notification ? $unread_notification : 0; ?> unread notifications</a><br>
                                    You have <a href="<?php echo WEB; ?>/pending" class="bold whitetext"><?php echo $pend_notification ? $pend_notification : 0; ?> pending requests</a>
                                </div-->
                                <!--div id="mainmemo" class="lefttalign whitetext margintop25">
                                    <b class="smalltext dorangetext">MEMORANDA</b><br><br>
                                    You have <a href="<?php echo WEB; ?>/memo" class="bold whitetext"><?php echo $unread_memo ? $unread_memo : 0; ?> recent memoranda</a>
                                </div-->

                                <?php endif; ?>

                                <?php if (in_array($profile_dbname , ['GL', 'MCTI']) ) : ?>
                                <div id="mainnotification" class="lefttalign whitetext marginbottom25" style="">
                                    <b class="smallte   xt dorangetext">Data Privacy Act Manual</b><br> Click <a href="<?php echo WEB; ?>/uploads/download/GLDPA.pdf" class="yellowtext" target="_blank">here</a>
                                </div>
                                <?php else : ?>
                                    <?php if ($profile_dbname != 'ECINEMA' && $profile_dbname != 'EPARKVIEW' && $profile_dbname != 'NEWTOWN' && $profile_dbname != 'LAFUERZA') : ?>
                                        <div id="mainnotification" class="lefttalign whitetext marginbottom25">
                                            <b class="smalltext dorangetext">Data Privacy Act Manual</b><br> Click <a href="<?php echo WEB; ?>/uploads/download/MWDPA.pdf" class="yellowtext" target="_blank">here</a>
                                        </div>

                                    <?php endif; ?>
                                <?php endif; ?>

                            </div>

                            <?php if (in_array($profile_dbname , ['GL', 'MCTI']) ) : ?>
                            <a href="<?php echo WEB; ?>/uploads/download/GLEmployeeHandbook.pdf" target="_blank" style="float: right; bottom: 150px; position: absolute; right: 29px;">
                                <img src="<?php echo WEB; ?>/images/glhandbook.png"  />
                            </a>

                            <?php elseif (in_array($profile_dbname , ['ASIAAPMI'])) : ?>
                            
                            <a href="<?php echo WEB; ?>/uploads/download/KER_Version_AA_UPDATED_HANDBOOK_Page1-99_May 30_2022.pdf" target="_blank" style="float: right; bottom: 150px; position: absolute; right: 29px;">
                                <img src="<?php echo WEB; ?>/images/asiaapmi_handbook.png"  />
                            </a>

                            <?php else : ?>
                            <?php if ($profile_dbname != 'ECINEMA' && $profile_dbname != 'EPARKVIEW' && $profile_dbname != 'NEWTOWN' && $profile_dbname != 'LAFUERZA') : ?>
                            <a href="<?php echo WEB; ?>/uploads/download/EmployeeHandbook.pdf" target="_blank"  style="float: right; bottom: 150px; position: absolute; right: 29px;">
                                <img src="<?php echo WEB; ?>/images/mwhandbook.png" />
                            </a>

                            <?php endif; ?>
                            <?php endif; ?>

                            <a href="https://tinyurl.com/yyp6m44z" target="_blank" style="float: right; bottom: 25px; position: absolute; right: 29px;">
                                <img src="<?php echo WEB; ?>/images/CLUBACC.png" />
                            </a>

                            <?php if ($profile_comp == 'GLOBAL01') : ?>
                            <div id="mainannouncement" class="mainbody lefttalign whitetext width60per">
                                <b class="mediumtext lorangetext">WELCOME</b><br><br>
                                <b>Global One Integrated Business Services, Inc.</b> is a wholly owned subsidiary of Megaworld Corporation, a prestigious real estate developer with over two decades of experience in creating pioneering townships and complete, integrated lifestyles.<br><br>Established on September 25, 2014, Global One offers a full range of real estate back office and front office support services, technical and research services, as well as development and operation services.<br><br>We offer various opportunities for employment. We also ensure career empowerment and advancement through formal and non-formal education and licensure review sponsorships.<br><br><br><br>
                            </div>
                            <div id="mainannouncement" class="mainbody lefttalign whitetext width60per">
                                <b class="mediumtext lorangetext">VISION</b><br><br>
                                <i>Our vision is to deliver competitive advantage primarily to the Megaworld Group<br>through business process services and solutions that meet the highest global standards.</i>
                            </div>
                            <div id="mainannouncement" class="mainbody lefttalign whitetext width60per">
                                <b class="mediumtext lorangetext">MISSION</b><br><br>
                                <i>Our mission is to ensure service excellence with full client satisfaction through technical competence, professionalism and integrity.</i>
                            </div>
                            <?php elseif ($profile_comp == 'LGMI01') : ?>
                            <div id="mainannouncement" class="mainbody lefttalign whitetext width60per">
                                <b class="mediumtext lorangetext">WELCOME</b><br><br>
                                Established on September 18, 2014, <b>Luxury Global Malls</b>, Inc. is a wholly owned subsidiary of Megaworld Corporation that provides a full range of retail support operating services for the Megaworld Lifestyle Malls.<br><br>Luxury Global offers a wide array of employment opportunities, as well as initiatives for career empowerment and advancement. Megaworld, the No.1 township developer, residential property developer and BPO office developer and landlord in the Philippines, creates malls that have become premier lifestyle destinations. To date, it has eight luxury mall offerings in the most strategic locations in the metro.
                            </div>
                            <div id="mainannouncement" class="mainbody lefttalign whitetext width60per">
                                <b class="mediumtext lorangetext">VISION</b><br><br>
                                <i>Our vision is to deliver competitive advantage primarily to the Megaworld Group<br>through business process services and solutions that meet the highest global standards.</i>
                            </div>
                            <div id="mainannouncement" class="mainbody lefttalign whitetext">
                                <b class="mediumtext lorangetext">MISSION</b><br><br>
                                <i>Our mission is to ensure service excellence with full client satisfaction through technical competence, professionalism and integrity.</i>
                            </div>
                            <?php else : ?>
                            <div id="mainannouncement" class="mainbody lefttalign whitetext width60per">
                                <b class="mediumtext lorangetext">WELCOME</b><br><br>
                                The Company was founded by Andrew Tan and incorporated under Philippine law on August 24, 1989 to engage in the development, leasing and marketing of real estate. The Company initially established a reputation for building high-end residential condominiums and commercial properties located in convenient urban locations with easy access to offices as well as leisure and entertainment amenities in Metro Manila. Beginning in 1996, in response to demand for the lifestyle convenience of having quality residences in close proximity to office and leisure facilities, the Company began to focus on the development of mixed-use communities, primarily for the middle-income market, by commencing the development of its Eastwood City community township. In addition, the Company engages in other property related activities such as project design, construction oversight and property management. In 1999, Eastwood City Cyberpark became the first IT park in the Philippines to be designated a PEZA special economic zone.
                            </div>
                            <div id="mainannouncement" class="mainbody lefttalign whitetext width60per">
                                <b class="mediumtext lorangetext">VISION</b><br><br>
                                <p>We <b><i>uplift lives, impact society, </i></b>and help <b><i>shape the nation</i></b>.</p>
                            </div>
                            <div id="mainannouncement" class="mainbody lefttalign whitetext width60per">
                                <b class="mediumtext lorangetext">MISSION</b><br><br>
                                <p>We <b><i>pioneer</i></b> concepts that promote integrated lifestyles in the townships we build.</p>
                                <p>We advocate <b><i>responsible stewardship</i></b> of the environment.</p>
                                <p>We deliver <b><i>long-term value</i></b> for our employees and shareholders.</p>
                                <p>We <b><i>spur economic growth</i></b> all over the country.</p>
                            </div>
                             <div id="mainannouncement" class="mainbody lefttalign whitetext width60per">
                                <b class="mediumtext lorangetext">VALUES</b><br><br>
                                <p><b><i>Integrity</i></b> &#8226; <b><i>Creativity</i></b> &#8226; <b><i>Innovation</i></b> &#8226; <b><i>Excellence</i></b> &#8226; <b><i>Love for the Company</i></b></p>
                            </div>
                            <?php endif; ?>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>
