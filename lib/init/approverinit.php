<?php

    $approvers = $mainsql->get_approvers($logname, 0, $dbname);

    //var_dump($dbname);

    foreach($approvers as $key => $value) :

        if ($value['TYPE'] == 'frmApplicationLVWeb') :
            if ($value['SIGNATORYID1'] || $value['SIGNATORYID2'] || $value['SIGNATORYID3'] || $value['SIGNATORYID4'] || $value['SIGNATORYID5'] || $value['SIGNATORYID6']) :
                $lv_app = array(1 => array(0 => $value['SIGNATORY1'], 1 => $value['SIGNATORYID1'], 2 => ($value['SIGNATORYID1'] == '1994-03-8275' || $value['SIGNATORYID1'] == '2009-09-V206' || $value['SIGNATORYID1'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB1'])),
                                2 => array(0 => $value['SIGNATORY2'], 1 => $value['SIGNATORYID2'], 2 => ($value['SIGNATORYID2'] == '1994-03-8275' || $value['SIGNATORYID2'] == '2009-09-V206' || $value['SIGNATORYID2'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB2'])),
                                3 => array(0 => $value['SIGNATORY3'], 1 => $value['SIGNATORYID3'], 2 => ($value['SIGNATORYID3'] == '1994-03-8275' || $value['SIGNATORYID3'] == '2009-09-V206' || $value['SIGNATORYID3'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB3'])),
                                4 => array(0 => $value['SIGNATORY4'], 1 => $value['SIGNATORYID4'], 2 => ($value['SIGNATORYID4'] == '1994-03-8275' || $value['SIGNATORYID4'] == '2009-09-V206' || $value['SIGNATORYID4'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB4'])),
                                5 => array(0 => $value['SIGNATORY5'], 1 => $value['SIGNATORYID5'], 2 => ($value['SIGNATORYID5'] == '1994-03-8275' || $value['SIGNATORYID5'] == '2009-09-V206' || $value['SIGNATORYID5'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB5'])),
                                6 => array(0 => $value['SIGNATORY6'], 1 => $value['SIGNATORYID6'], 2 => ($value['SIGNATORYID6'] == '1994-03-8275' || $value['SIGNATORYID6'] == '2009-09-V206' || $value['SIGNATORYID6'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB6']))
                               );
            else :
                $lv_app = NULL;
            endif;
        elseif ($value['TYPE'] == 'frmApplicationWHWeb') :

            $wfh_user = $mainsql->get_wfh_user($logname, $dbname);
            var_dump($wfh_user);
            if ($value['SIGNATORYID1'] || $value['SIGNATORYID2'] || $value['SIGNATORYID3'] || $value['SIGNATORYID4'] || $value['SIGNATORYID5'] || $value['SIGNATORYID6']) :
                $wh_app = array(1 => array(0 => $value['SIGNATORY1'], 1 => $value['SIGNATORYID1'], 2 => ($value['SIGNATORYID1'] == '1994-03-8275' || $value['SIGNATORYID1'] == '2009-09-V206' || $value['SIGNATORYID1'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB1'])),
                                2 => array(0 => $value['SIGNATORY2'], 1 => $value['SIGNATORYID2'], 2 => ($value['SIGNATORYID2'] == '1994-03-8275' || $value['SIGNATORYID2'] == '2009-09-V206' || $value['SIGNATORYID2'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB2'])),
                                3 => array(0 => $value['SIGNATORY3'], 1 => $value['SIGNATORYID3'], 2 => ($value['SIGNATORYID3'] == '1994-03-8275' || $value['SIGNATORYID3'] == '2009-09-V206' || $value['SIGNATORYID3'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB3'])),
                                4 => array(0 => $value['SIGNATORY4'], 1 => $value['SIGNATORYID4'], 2 => ($value['SIGNATORYID4'] == '1994-03-8275' || $value['SIGNATORYID4'] == '2009-09-V206' || $value['SIGNATORYID4'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB4'])),
                                5 => array(0 => $value['SIGNATORY5'], 1 => $value['SIGNATORYID5'], 2 => ($value['SIGNATORYID5'] == '1994-03-8275' || $value['SIGNATORYID5'] == '2009-09-V206' || $value['SIGNATORYID5'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB5'])),
                                6 => array(0 => $value['SIGNATORY6'], 1 => $value['SIGNATORYID6'], 2 => ($value['SIGNATORYID6'] == '1994-03-8275' || $value['SIGNATORYID6'] == '2009-09-V206' || $value['SIGNATORYID6'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB6']))
                               );
            else :
                $wh_app = NULL;
            endif;
        elseif ($value['TYPE'] == 'frmApplicationOTWeb') :
            if ($value['SIGNATORYID1'] || $value['SIGNATORYID2'] || $value['SIGNATORYID3'] || $value['SIGNATORYID4'] || $value['SIGNATORYID5'] || $value['SIGNATORYID6']) :
                $ot_app = array(1 => array(0 => $value['SIGNATORY1'], 1 => $value['SIGNATORYID1'], 2 => ($value['SIGNATORYID1'] == '1994-03-8275' || $value['SIGNATORYID1'] == '2009-09-V206' || $value['SIGNATORYID1'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB1'])),
                                2 => array(0 => $value['SIGNATORY2'], 1 => $value['SIGNATORYID2'], 2 => ($value['SIGNATORYID2'] == '1994-03-8275' || $value['SIGNATORYID2'] == '2009-09-V206' || $value['SIGNATORYID2'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB2'])),
                                3 => array(0 => $value['SIGNATORY3'], 1 => $value['SIGNATORYID3'], 2 => ($value['SIGNATORYID3'] == '1994-03-8275' || $value['SIGNATORYID3'] == '2009-09-V206' || $value['SIGNATORYID3'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB3'])),
                                4 => array(0 => $value['SIGNATORY4'], 1 => $value['SIGNATORYID4'], 2 => ($value['SIGNATORYID4'] == '1994-03-8275' || $value['SIGNATORYID4'] == '2009-09-V206' || $value['SIGNATORYID4'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB4'])),
                                5 => array(0 => $value['SIGNATORY5'], 1 => $value['SIGNATORYID5'], 2 => ($value['SIGNATORYID5'] == '1994-03-8275' || $value['SIGNATORYID5'] == '2009-09-V206' || $value['SIGNATORYID5'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB5'])),
                                6 => array(0 => $value['SIGNATORY6'], 1 => $value['SIGNATORYID6'], 2 => ($value['SIGNATORYID6'] == '1994-03-8275' || $value['SIGNATORYID6'] == '2009-09-V206' || $value['SIGNATORYID6'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB6']))
                               );
            else :
                $ot_app = NULL;
            endif;
        elseif ($value['TYPE'] == 'frmApplicationOBWeb') :
            if ($value['SIGNATORYID1'] || $value['SIGNATORYID2'] || $value['SIGNATORYID3'] || $value['SIGNATORYID4'] || $value['SIGNATORYID5'] || $value['SIGNATORYID6']) :
                $ob_app = array(1 => array(0 => $value['SIGNATORY1'], 1 => $value['SIGNATORYID1'], 2 => ($value['SIGNATORYID1'] == '1994-03-8275' || $value['SIGNATORYID1'] == '2009-09-V206' || $value['SIGNATORYID1'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB1'])),
                                2 => array(0 => $value['SIGNATORY2'], 1 => $value['SIGNATORYID2'], 2 => ($value['SIGNATORYID2'] == '1994-03-8275' || $value['SIGNATORYID2'] == '2009-09-V206' || $value['SIGNATORYID2'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB2'])),
                                3 => array(0 => $value['SIGNATORY3'], 1 => $value['SIGNATORYID3'], 2 => ($value['SIGNATORYID3'] == '1994-03-8275' || $value['SIGNATORYID3'] == '2009-09-V206' || $value['SIGNATORYID3'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB3'])),
                                4 => array(0 => $value['SIGNATORY4'], 1 => $value['SIGNATORYID4'], 2 => ($value['SIGNATORYID4'] == '1994-03-8275' || $value['SIGNATORYID4'] == '2009-09-V206' || $value['SIGNATORYID4'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB4'])),
                                5 => array(0 => $value['SIGNATORY5'], 1 => $value['SIGNATORYID5'], 2 => ($value['SIGNATORYID5'] == '1994-03-8275' || $value['SIGNATORYID5'] == '2009-09-V206' || $value['SIGNATORYID5'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB5'])),
                                6 => array(0 => $value['SIGNATORY6'], 1 => $value['SIGNATORYID6'], 2 => ($value['SIGNATORYID6'] == '1994-03-8275' || $value['SIGNATORYID6'] == '2009-09-V206' || $value['SIGNATORYID6'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB6']))
                               );
            else :
                $ob_app = NULL;
            endif;
        /*elseif ($value['TYPE'] == 'frmApplicationMAWeb') :
            $ma_app = array(1 => array(0 => $value['SIGNATORY1'], 1 => $value['SIGNATORYID1']), 2 =>  array(0 => $value['SIGNATORY2'], 1 => $value['SIGNATORYID2']), 3 => array(0 => $value['SIGNATORY3'], 1 => $value['SIGNATORYID3']), 4 => array(0 => $value['SIGNATORY4'], 1 => $value['SIGNATORYID4']), 5 => array(0 => $value['SIGNATORY5'], 1 => $value['SIGNATORYID5']), 6 => array(0 => $value['SIGNATORY6'], 1 => $value['SIGNATORYID6']));*/
        elseif ($value['TYPE'] == 'frmApplicationMDWeb') :
            if ($value['SIGNATORYID1'] || $value['SIGNATORYID2'] || $value['SIGNATORYID3'] || $value['SIGNATORYID4'] || $value['SIGNATORYID5'] || $value['SIGNATORYID6']) :
                $md_app = array(1 => array(0 => $value['SIGNATORY1'], 1 => $value['SIGNATORYID1'], 2 => ($value['SIGNATORYID1'] == '1994-03-8275' || $value['SIGNATORYID1'] == '2009-09-V206' || $value['SIGNATORYID1'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB1'])),
                                2 => array(0 => $value['SIGNATORY2'], 1 => $value['SIGNATORYID2'], 2 => ($value['SIGNATORYID2'] == '1994-03-8275' || $value['SIGNATORYID2'] == '2009-09-V206' || $value['SIGNATORYID2'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB2'])),
                                3 => array(0 => $value['SIGNATORY3'], 1 => $value['SIGNATORYID3'], 2 => ($value['SIGNATORYID3'] == '1994-03-8275' || $value['SIGNATORYID3'] == '2009-09-V206' || $value['SIGNATORYID3'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB3'])),
                                4 => array(0 => $value['SIGNATORY4'], 1 => $value['SIGNATORYID4'], 2 => ($value['SIGNATORYID4'] == '1994-03-8275' || $value['SIGNATORYID4'] == '2009-09-V206' || $value['SIGNATORYID4'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB4'])),
                                5 => array(0 => $value['SIGNATORY5'], 1 => $value['SIGNATORYID5'], 2 => ($value['SIGNATORYID5'] == '1994-03-8275' || $value['SIGNATORYID5'] == '2009-09-V206' || $value['SIGNATORYID5'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB5'])),
                                6 => array(0 => $value['SIGNATORY6'], 1 => $value['SIGNATORYID6'], 2 => ($value['SIGNATORYID6'] == '1994-03-8275' || $value['SIGNATORYID6'] == '2009-09-V206' || $value['SIGNATORYID6'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB6']))
                               );
            else :
                $md_app = NULL;
            endif;
        elseif ($value['TYPE'] == 'frmApplicationSCWeb') :
            if ($value['SIGNATORYID1'] || $value['SIGNATORYID2'] || $value['SIGNATORYID3'] || $value['SIGNATORYID4'] || $value['SIGNATORYID5'] || $value['SIGNATORYID6']) :
                $sc_app = array(1 => array(0 => $value['SIGNATORY1'], 1 => $value['SIGNATORYID1'], 2 => ($value['SIGNATORYID1'] == '1994-03-8275' || $value['SIGNATORYID1'] == '2009-09-V206' || $value['SIGNATORYID1'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB1'])),
                                2 => array(0 => $value['SIGNATORY2'], 1 => $value['SIGNATORYID2'], 2 => ($value['SIGNATORYID2'] == '1994-03-8275' || $value['SIGNATORYID2'] == '2009-09-V206' || $value['SIGNATORYID2'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB2'])),
                                3 => array(0 => $value['SIGNATORY3'], 1 => $value['SIGNATORYID3'], 2 => ($value['SIGNATORYID3'] == '1994-03-8275' || $value['SIGNATORYID3'] == '2009-09-V206' || $value['SIGNATORYID3'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB3'])),
                                4 => array(0 => $value['SIGNATORY4'], 1 => $value['SIGNATORYID4'], 2 => ($value['SIGNATORYID4'] == '1994-03-8275' || $value['SIGNATORYID4'] == '2009-09-V206' || $value['SIGNATORYID4'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB4'])),
                                5 => array(0 => $value['SIGNATORY5'], 1 => $value['SIGNATORYID5'], 2 => ($value['SIGNATORYID5'] == '1994-03-8275' || $value['SIGNATORYID5'] == '2009-09-V206' || $value['SIGNATORYID5'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB5'])),
                                6 => array(0 => $value['SIGNATORY6'], 1 => $value['SIGNATORYID6'], 2 => ($value['SIGNATORYID6'] == '1994-03-8275' || $value['SIGNATORYID6'] == '2009-09-V206' || $value['SIGNATORYID6'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB6']))
                               );
            else :
                $sc_app = NULL;
            endif;
        elseif ($value['TYPE'] == 'frmApplicationMAWeb') :
            if ($value['SIGNATORYID1'] || $value['SIGNATORYID2'] || $value['SIGNATORYID3'] || $value['SIGNATORYID4'] || $value['SIGNATORYID5'] || $value['SIGNATORYID6']) :
                $ma_app = array(1 => array(0 => $value['SIGNATORY1'], 1 => $value['SIGNATORYID1'], 2 => ($value['SIGNATORYID1'] == '1994-03-8275' || $value['SIGNATORYID1'] == '2009-09-V206' || $value['SIGNATORYID1'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB1'])),
                                2 => array(0 => $value['SIGNATORY2'], 1 => $value['SIGNATORYID2'], 2 => ($value['SIGNATORYID2'] == '1994-03-8275' || $value['SIGNATORYID2'] == '2009-09-V206' || $value['SIGNATORYID2'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB2'])),
                                3 => array(0 => $value['SIGNATORY3'], 1 => $value['SIGNATORYID3'], 2 => ($value['SIGNATORYID3'] == '1994-03-8275' || $value['SIGNATORYID3'] == '2009-09-V206' || $value['SIGNATORYID3'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB3'])),
                                4 => array(0 => $value['SIGNATORY4'], 1 => $value['SIGNATORYID4'], 2 => ($value['SIGNATORYID4'] == '1994-03-8275' || $value['SIGNATORYID4'] == '2009-09-V206' || $value['SIGNATORYID4'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB4'])),
                                5 => array(0 => $value['SIGNATORY5'], 1 => $value['SIGNATORYID5'], 2 => ($value['SIGNATORYID5'] == '1994-03-8275' || $value['SIGNATORYID5'] == '2009-09-V206' || $value['SIGNATORYID5'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB5'])),
                                6 => array(0 => $value['SIGNATORY6'], 1 => $value['SIGNATORYID6'], 2 => ($value['SIGNATORYID6'] == '1994-03-8275' || $value['SIGNATORYID6'] == '2009-09-V206' || $value['SIGNATORYID6'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB6']))
                               );
            else :
                $ma_app = NULL;
            endif;
        elseif ($value['TYPE'] == 'frmApplicationNPWeb') :
            if ($value['SIGNATORYID1'] || $value['SIGNATORYID2'] || $value['SIGNATORYID3'] || $value['SIGNATORYID4'] || $value['SIGNATORYID5'] || $value['SIGNATORYID6']) :
                $np_app = array(1 => array(0 => $value['SIGNATORY1'], 1 => $value['SIGNATORYID1'], 2 => ($value['SIGNATORYID1'] == '1994-03-8275' || $value['SIGNATORYID1'] == '2009-09-V206' || $value['SIGNATORYID1'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB1'])),
                                2 => array(0 => $value['SIGNATORY2'], 1 => $value['SIGNATORYID2'], 2 => ($value['SIGNATORYID2'] == '1994-03-8275' || $value['SIGNATORYID2'] == '2009-09-V206' || $value['SIGNATORYID2'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB2'])),
                                3 => array(0 => $value['SIGNATORY3'], 1 => $value['SIGNATORYID3'], 2 => ($value['SIGNATORYID3'] == '1994-03-8275' || $value['SIGNATORYID3'] == '2009-09-V206' || $value['SIGNATORYID3'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB3'])),
                                4 => array(0 => $value['SIGNATORY4'], 1 => $value['SIGNATORYID4'], 2 => ($value['SIGNATORYID4'] == '1994-03-8275' || $value['SIGNATORYID4'] == '2009-09-V206' || $value['SIGNATORYID4'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB4'])),
                                5 => array(0 => $value['SIGNATORY5'], 1 => $value['SIGNATORYID5'], 2 => ($value['SIGNATORYID5'] == '1994-03-8275' || $value['SIGNATORYID5'] == '2009-09-V206' || $value['SIGNATORYID5'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB5'])),
                                6 => array(0 => $value['SIGNATORY6'], 1 => $value['SIGNATORYID6'], 2 => ($value['SIGNATORYID6'] == '1994-03-8275' || $value['SIGNATORYID6'] == '2009-09-V206' || $value['SIGNATORYID6'] == '2011-03-V835' ? 'MEGAWORLD' : $value['SIGNATORYDB6']))
                               );
            else :
                $np_app = NULL;
            endif;
        /*elseif ($value['TYPE'] == 'frmApplicationTSWeb') :
            $ts_app = array(1 => array(0 => $value['SIGNATORY1'], 1 => $value['SIGNATORYID1']), 2 =>  array(0 => $value['SIGNATORY2'], 1 => $value['SIGNATORYID2']), 3 => array(0 => $value['SIGNATORY3'], 1 => $value['SIGNATORYID3']), 4 => array(0 => $value['SIGNATORY4'], 1 => $value['SIGNATORYID4']), 5 => array(0 => $value['SIGNATORY5'], 1 => $value['SIGNATORYID5']), 6 => array(0 => $value['SIGNATORY6'], 1 => $value['SIGNATORYID6']));*/
        endif;



    endforeach;

    //var_dump($lv_app);

?>
