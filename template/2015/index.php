<?php include(TEMP . "/header.php"); ?>
<?php include(TEMP . "/ape_modal.php"); ?>
<?php if(date('Y-m-d') <= '2025-04-13'): ?>
    <?php include(TEMP . "/holy-week-2025.php"); ?>
<?php endif; ?>

<div id="floatdiv" class="floatdiv invisible">
    <div id="adview" class="fview" style="!important; display:none">
        <div class="closebutton cursorpoint" style=""><i class="fa fa-times-circle fa-3x redtext"></i></div>
        <div id="ads_data" class="floatdata margintop15" style="margin: auto">
            <div class="centertalign">
                <img src="https://portal.megaworldcorp.com/me/images/quality-policy.jpg" class="width100per">

                <!-- <a href="https://portal.megaworldcorp.com/me/images/quality-policy.jpg" target="_blank"><button class="bigbtn">View this Ad on Different Level</button></a> -->
            </div>
        </div>
    </div>
</div>
<?php
if ($clearance)
    include(TEMP . '/clearance.php'); ?>

<div id="mainsplashtext" class="mainsplashtext lefttalign">
    <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
    <div class="leftsplashtext lefttalign"><?php include(TEMP . "/menu.php"); ?></div>
    <div class="rightsplashtext lefttalign">

        <div class="notifloat">
            <?php
            $date1 = date("Y-m-d");
            $date2 = "2016-12-25";
            $diff = abs(strtotime($date2) - strtotime($date1));
            $xmascount = $diff / (60 * 60 * 24);
            ?>
            <?php if ($xmascount <= 100): ?>
                <!--div id="mainnotification" class="xmas centertalign whitetext mediumtext2">
                                    <b><?php echo $xmascount; ?> days to go before Xmas!</b>
                                </div><br-->
            <?php endif; ?>

            <?php if ($cutoff_date): ?>
                <div id="mainnotification" class="lefttalign whitetext marginbottom5 ">
                    <b class="smalltext lorangetext">REMINDER</b><br><br>
                    <?php if (date('Y-m-d H:i:s') >= '2017-11-03 00:00:00'): ?>
                        Deadline for this cutoff will be <?php echo date("F j, Y", strtotime($cutoff_date)); ?><br><br>
                    <?php endif; ?>

                    <?php if ($clearance): ?>
                        <a href=""><b class="smalltext whitetext">Clearance Application</b></a>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if (in_array($profile_dbname, ['ASIAAPMI', 'MREIT', 'ECOC', 'CITYLINK', 'ECINEMA', 'EREX', 'LCTM', 'MCTI', 'MLI', 'Rowenta', 'NCCAI', 'SIRUS', 'MEGAWORLD', 'GL', 'GLOBAL_HOTEL', 'TOWNSQUARE', 'LAFUERZA', 'NEWTOWN', 'MEGAPARK'])): ?>
                <?php
                $display = true;
                $deadline = '2025-12-31';
                $deadline_text = '';

                switch ($profile_dbname) {
                    case 'ASIAAPMI':
                        $deadline = '2025-01-31';

                        $deadline_text = '<br><span class="smalltext">Please submit your signed ITR on or before Jan 31st using this <br><b><a target="_blank" href="https://forms.gle/fENWhwirwjqz4KUDA" style="text-decoration: underline; color: blue">Form Link</a></b>.</span>';
                        break;
                }

                if (date('Y-m-d') <= date('Y-m-d', strtotime($deadline)))
                    $display = false;
                ?>

                <div class="dashcomp dashincentive2"
                    style="<?php if ($display)
                        echo 'display:none'; ?>; height: auto; background: #F0F0F0; padding: 5px; border-radius: 5px;-webkit-border-radius: 3px;-moz-border-radius: 3px;border:1px dashed #999">
                        <center class=" dgraytext smalltext2">
                            <a class="robotobold" style="color:blue; " href="<?php echo WEB; ?>/itr">
                                <span class="roboto orangetext mediumtext" style="text-decoration: underline;">Download Your
                                    2024 Income Tax Return Form (BIR
                                    2316)</span>
                            </a> <br>

                            <?php echo $deadline_text; ?>
                        </center>
                </div>
            <?php endif; ?>

            <?php if (!in_array($profile_dbname, ['ASIAAPMI',  'GLOBAL_HOTEL', 'NEWTOWN', 'MEGAPARK'])): ?>
                <?php
                    $viewingDate = '2025-04-25';
                    $displayAPE = (date('Y-m-d') < $viewingDate);
                ?>

                <div class="dashcomp dashincentive2"
                    style=" <?php if ($displayAPE)
                        echo 'display:none;'; ?> height: auto; background: #F0F0F0; padding: 5px; border-radius: 5px;-webkit-border-radius: 3px;-moz-border-radius: 3px;border:1px dashed #999">
                        <center class=" dgraytext smalltext2">
                            <a id="btnAPE" class="robotobold" style="color:blue;" >
                                <span class="roboto orangetext mediumtext" style="text-decoration: underline;">Download
                                    <?php echo date('Y'); ?> Annual Physical Examination Result</span>
                            </a> <br>
                        </center>
                </div>
            <?php endif; ?>

            <?php if ($profile_dbname != 'ECINEMA' && $profile_dbname != 'EPARKVIEW' && $profile_dbname != 'NEWTOWN' && $profile_dbname != 'LAFUERZA'): ?>

                <?php if (date('Y-m-d H:i:s') <= '2020-02-28 23:59:00'): ?>
                    <div id="mainnotification" class="lefttalign whitetext marginbottom25">
                        <b class="smalltext dorangetext">Valentine's Day Event Feedback</b>
                        <br>
                        Click
                        <a href="https://docs.google.com/forms/d/e/1FAIpQLSf-RzwbZQvDi3cYFsk5q735OrkKldULeJbcaVXvAACHQ0kz_Q/viewform?vc=0&c=0&w=1"
                            class="yellowtext" target="_blank">here</a>
                    </div>
                <?php endif; ?>

                <?php /*
<!--div id="mainnotification" class="lefttalign whitetext">
<b class="smalltext dorangetext">NOTIFICATIONS</b><br><br>
You have <a href="<?php echo WEB; ?>/notification" class="bold whitetext"><?php echo $unread_notification ? $unread_notification : 0; ?> unread notifications</a><br>
You have <a href="<?php echo WEB; ?>/pending" class="bold whitetext"><?php echo $pend_notification ? $pend_notification : 0; ?> pending requests</a>
</div-->
<!--div id="mainmemo" class="lefttalign whitetext margintop25">
<b class="smalltext dorangetext">MEMORANDA</b><br><br>
You have <a href="<?php echo WEB; ?>/memo" class="bold whitetext"><?php echo $unread_memo ? $unread_memo : 0; ?> recent memoranda</a>
</div--> 
*/ ?>

            <?php endif; ?>

            <div id="mainnotification" class="centertalign whitetext marginbottom25" style="">
                <?php if (in_array($profile_dbname, ['GL', 'MCTI'])): ?>
                    <a onclick="openfile('<?php echo WEB; ?>/lib/requests/download.php?type=a&file=GLDPA.pdf', 'Data Privacy Act Manual')"
                        target="_blank" style="">
                        <img width="150px" src="<?php echo WEB; ?>/images/dpa-icon.png" />
                    </a>
                <?php else: ?>
                    <?php if ($profile_dbname != 'ECINEMA' && $profile_dbname != 'EPARKVIEW' && $profile_dbname != 'NEWTOWN' && $profile_dbname != 'LAFUERZA'): ?>
                        <a onclick="openfile('<?php echo WEB; ?>/lib/requests/download.php?type=a&file=MWDPA.pdf', 'Data Privacy Act Manual')"
                            target="_blank" style="cursor: pointer">
                            <img width="150px" src="<?php echo WEB; ?>/images/dpa-icon.png" />
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div> <?php // end of dpa ?>

            <div id="mainnotification" class="centertalign whitetext marginbottom25" style="">
                <a target="_blank" style="cursor: pointer" onclick="create_log('corporate_governance')">
                    <img width="150px" src="<?php echo WEB; ?>/images/corporate_governance.png" />
                </a>
            </div> <?php // end of corp gov ?>

            <div id="mainnotification" class="centertalign whitetext marginbottom25" style="">
                <?php if (in_array($profile_dbname, ['GL', 'MCTI'])): ?>
                    <a onclick="openfile('<?php echo WEB; ?>/lib/requests/download.php?type=a&file=GLEmployeeHandbook.pdf', 'Employees` Handbook')"
                        target="_blank" style="">
                        <img width="150px" src="<?php echo WEB; ?>/images/glhandbook.png" />
                    </a>
                <?php elseif (in_array($profile_dbname, ['ASIAAPMI'])): ?>
                    <a onclick="openfile('<?php echo WEB; ?>/lib/requests/download.php?type=a&file=ASIAAPMIHANDBOOK.pdf', 'Employee`s Handbook')"
                        target="_blank" style="">
                        <img width="150px" src="<?php echo WEB; ?>/images/asiaapmi_handbook.png" />
                    </a>

                <?php else: ?>
                    <?php if ($profile_dbname != 'ECINEMA' && $profile_dbname != 'EPARKVIEW' && $profile_dbname != 'NEWTOWN' && $profile_dbname != 'LAFUERZA'): ?>
                        <a onclick="openfile('<?php echo WEB; ?>/lib/requests/download.php?type=a&file=EmployeeHandbook.pdf', 'Employee`s Handbook')"
                            target="_blank" style="" target="_blank">
                            <img width="150px" src="<?php echo WEB; ?>/images/mwhandbook.png" />
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div><?php // end of handbook ?>

            <div id="mainnotification" class="centertalign whitetext marginbottom25" style="">
                <a target="_blank" class="btnviewads-quality-policy">
                    <img width="150px" src="<?php echo WEB; ?>/images/quality-policy-icon.png" />
                </a>
            </div>

            <?php if (!in_array($profile_comp, ['ASIAAPMI', 'GLOBALHOTEL'])): ?>
                <div id="mainnotification" class="centertalign whitetext marginbottom25" style="">
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSeZ3HHajc62Dvas0CL7O5mN1QGPX8K1CWmMZOybhjhYFowWHw/viewform?authuser=3"
                        target="_blank">
                        <img width="150px" src="<?php echo WEB; ?>/images/traf.png" />
                    </a>
                </div>
            <?php endif; ?>

            <div id="mainnotification" class="centertalign whitetext marginbottom25" style="">
                <a href="https://tinyurl.com/yyp6m44z" target="_blank">
                    <img width="150px" src="<?php echo WEB; ?>/images/CLUBACC.png" />
                </a>
            </div>
            <?php // end of club access ?>

        </div>


        <?php if ($profile_comp == 'GLOBAL01'): ?>
            <div id="mainannouncement" class="mainbody lefttalign whitetext width60per">
                <b class="mediumtext lorangetext">WELCOME</b><br><br>
                <b>Global One Integrated Business Services, Inc.</b> is a wholly owned subsidiary of Megaworld Corporation,
                a prestigious real estate developer with over two decades of experience in creating pioneering townships and
                complete, integrated lifestyles.<br><br>Established on September 25, 2014, Global One offers a full range of
                real estate back office and front office support services, technical and research services, as well as
                development and operation services.<br><br>We offer various opportunities for employment. We also ensure
                career empowerment and advancement through formal and non-formal education and licensure review
                sponsorships.<br><br><br><br>
            </div>
            <div id="mainannouncement" class="mainbody lefttalign whitetext width60per">
                <b class="mediumtext lorangetext">VISION</b><br><br>
                <i>Our vision is to deliver competitive advantage primarily to the Megaworld Group<br>through business
                    process services and solutions that meet the highest global standards.</i>
            </div>
            <div id="mainannouncement" class="mainbody lefttalign whitetext width60per">
                <b class="mediumtext lorangetext">MISSION</b><br><br>
                <i>Our mission is to ensure service excellence with full client satisfaction through technical competence,
                    professionalism and integrity.</i>
            </div>
        <?php elseif ($profile_comp == 'LGMI01'): ?>
            <div id="mainannouncement" class="mainbody lefttalign whitetext width60per">
                <b class="mediumtext lorangetext">WELCOME</b><br><br>
                Established on September 18, 2014, <b>Luxury Global Malls</b>, Inc. is a wholly owned subsidiary of
                Megaworld Corporation that provides a full range of retail support operating services for the Megaworld
                Lifestyle Malls.<br><br>Luxury Global offers a wide array of employment opportunities, as well as
                initiatives for career empowerment and advancement. Megaworld, the No.1 township developer, residential
                property developer and BPO office developer and landlord in the Philippines, creates malls that have become
                premier lifestyle destinations. To date, it has eight luxury mall offerings in the most strategic locations
                in the metro.
            </div>
            <div id="mainannouncement" class="mainbody lefttalign whitetext width60per">
                <b class="mediumtext lorangetext">VISION</b><br><br>
                <i>Our vision is to deliver competitive advantage primarily to the Megaworld Group<br>through business
                    process services and solutions that meet the highest global standards.</i>
            </div>
            <div id="mainannouncement" class="mainbody lefttalign whitetext">
                <b class="mediumtext lorangetext">MISSION</b><br><br>
                <i>Our mission is to ensure service excellence with full client satisfaction through technical competence,
                    professionalism and integrity.</i>
            </div>
        <?php elseif ($profile_comp == 'ASIAAPMI'): ?>
            <div id="mainannouncement" class="mainbody lefttalign whitetext width60per">
                <b class="mediumtext lorangetext">Our Vision</b><br><br>
                <p>We aim to be <span class="smalltext lorangetext">excellent</span> — becoming a company that has dominant
                    mindshare and is the immediate first choice in property management.</p>
                <p>We aim to be <span class="smalltext lorangetext">different</span> — elevating property management with
                    personalized hospitality and hotel-caliber services that are engaging, relevant and sustainable.</p>
                <p>We aim to be <span class="smalltext lorangetext">memorable</span> — enriching the experiences of our
                    clients and our people in a way that impacts their well-being and inspires them to share their stories.
                </p>
            </div>
            <div id="mainannouncement" class="mainbody lefttalign whitetext  width60per">
                <b class="mediumtext lorangetext">Our Mission</b><br><br>
                <p>We are attentive to the spoken and unspoken needs of our clients—tailoring our services for exemplary
                    results.</p>
                <p>We find uncommon and creative ways to delight our clients.</p>
                <p>We ensure that our activities and initiatives are environmentally conscious and contribute to the
                    property’s sustainability.</p>
                <p>We explore opportunities to add value to our clients’ way of life.</p>
                <p>We amplify the positive stories of our clients and our people.</p>
            </div>
            <div id="mainannouncement" class="mainbody lefttalign whitetext  width60per">
                <b class="mediumtext lorangetext">Our Core Values</b><br><br>
                <!-- <p>
                                    <span class="smalltext lorangetext">Respect</span>
                                    We hold one another in high esteem, and appreciate our individual roles in the company.
                                </p>
                                <p>
                                    <span class="smalltext lorangetext">Integrity</span><br>
                                    We are honest, trustworthy, and uncompromising in doing what is right. 
                                </p>
                                <p>
                                    <span class="smalltext lorangetext">Industry</span><br>
                                    We gladly exert 100 percent energy and effort in our work.
                                </p>
                                <p>
                                    <span class="smalltext lorangetext">Loyalty</span><br>
                                    We support the company fully, and uphold our commitments to it and to our clients.
                                </p> -->
                <p>
                    <b class="">Respect</b> &#8226;
                    <b class="">Integrity</b> &#8226;
                    <b class="">Industry</b> &#8226;
                    <b class="">Loyalty</b>
                </p>
            </div>
            <div id="mainannouncement" class="mainbody lefttalign whitetext  width60per">
                <b class="mediumtext lorangetext">Our Commitment to Our People</b><br><br>
                <p>At Asia Affinity, we believe that in order to do our best in making our clients feel welcome and cared
                    for, our employees must also feel welcome and cared for.
                </p>
                <p>
                    We are a company that values every individual team member for their unique strengths and contributions.
                    We support and nurture their growth, and align their development with the achievement of their personal
                    aspirations.
                </p>
                <p>
                    Asia Affinity promotes diversity and inclusivity in the workplace. We believe that fresh perspectives
                    make us better and stronger as a company, and allow us to be increasingly responsive to our
                    ever-evolving client base.
                </p>
            </div>
        <?php else: ?>
            <div id="mainannouncement" class="mainbody lefttalign whitetext width60per">
                <b class="mediumtext lorangetext">WELCOME</b><br><br>
                The Company was founded by Andrew Tan and incorporated under Philippine law on August 24, 1989 to engage in
                the development, leasing and marketing of real estate. The Company initially established a reputation for
                building high-end residential condominiums and commercial properties located in convenient urban locations
                with easy access to offices as well as leisure and entertainment amenities in Metro Manila. Beginning in
                1996, in response to demand for the lifestyle convenience of having quality residences in close proximity to
                office and leisure facilities, the Company began to focus on the development of mixed-use communities,
                primarily for the middle-income market, by commencing the development of its Eastwood City community
                township. In addition, the Company engages in other property related activities such as project design,
                construction oversight and property management. In 1999, Eastwood City Cyberpark became the first IT park in
                the Philippines to be designated a PEZA special economic zone.
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
                <p><b><i>Integrity</i></b> &#8226; <b><i>Creativity</i></b> &#8226; <b><i>Innovation</i></b> &#8226;
                    <b><i>Excellence</i></b> &#8226; <b><i>Love for the Company</i></b>
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include(TEMP . "/footer.php"); ?>