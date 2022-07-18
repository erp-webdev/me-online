<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COE</title>
    <link rel="stylesheet" href="<?php echo CSS; ?>/coe.css">
</head>
<body>
    <?php $send_pdf = $_POST['send'] == 'true' ? true : false; ?>

<div class="main-page">
    <div class="sub-page">

        <div class="header">
            <?php if ($coe[0]["company"] == 'GLOBAL01') { ?>
                <p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/gl_coe.png"/></p>
            <?php } elseif ($coe[0]["company"] == 'LGMI01') {?>
                <p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/lgmi_coe.png"/></p>
            <?php } elseif ($coe[0]["company"] == 'SIRUS') {?>
                <p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/sirus_coe.png"/></p>
            <?php } elseif ($coe[0]["company"] == 'MEGA01') {?>
                <p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/mega_coe.png"/></p>
            <?php } elseif ($coe[0]["company"] == 'TOWN01') {?>
                <p><img style="width: <?php echo $send_pdf ? '200px' : '250px'; ?>;" src="<?php echo IMG_WEB; ?>/townsquare_coe.png"/></p>
            <?php } elseif ($coe[0]["company"] == 'NCCAI') {?>
                <!--  -->
                <p><img style="width: <?php echo $send_pdf ? '200px' : '250px'; ?>;" src="<?php echo IMG_WEB; ?>/nccai_coe.png"/></p>
            <?php } elseif ($coe[0]["company"] == 'FCI01') {?>
                <!-- NOT INCLUDED -->
                <p><img style="width: <?php echo $send_pdf ? '100px' : '150px'; ?>;" src="<?php echo IMG_WEB; ?>/firstcentro_coe.png"/></p>
            <?php } elseif ($coe[0]["company"] == 'CITYLINK01') {?>
                <p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/citylink_coe.png"/></p>
            <?php } elseif ($coe[0]["company"] == 'ECC02') {?>
                <!--  -->
                <p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/ecinema_coe.png"/></p>
            <?php } elseif ($coe[0]["company"] == 'ECOC01') {?>
                <p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/ecoc_coe.png"/></p>
            <?php } elseif ($coe[0]["company"] == 'ERA01') {?>
                <p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/erex_coe.png"/></p>
            <?php } elseif ($coe[0]["company"] == 'LUCK01') {?>
                <p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/lctm_coe.png"/></p>
            <?php } elseif ($coe[0]["company"] == 'LFI01') {?>
                <!--  -->
                <p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/lafuerza_coe.png"/></p>
            <?php } elseif ($coe[0]["company"] == 'MLI01') {?>
                <p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/mli_coe.png"/></p>
            <?php } elseif ($coe[0]["company"] == 'MCTI') {?>
                <p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/mcti_coe.png"/></p>
            <?php } elseif ($coe[0]["company"] == 'SUNT01') {?>
                <p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/suntrust_coe.png"/></p>
            <?php } elseif ($coe[0]["company"] == 'ASIAAPMI') {?>
                <p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/asiaapmi_coe.png"/></p>
            <?php } else {?>
                <p><img style="width: <?php echo $send_pdf ? '150px' : '200px'; ?>;" src="<?php echo IMG_WEB; ?>/blank_coe.png"/></p>
            <?php } ?>
        </div>

        <div class="content">
            <?php
                //R&F to Supervisor
                $rfs = array(
                    'RF','RF II','SRF','SRF II','AS','AS II','AS III','S','S II','S III',
                    'SS','SS II','SS III',
                    'RF','R001','R002','R003','R004','S005','S006','S007','S008','S','SS',
                    
                );
                $man = array('AM','AM II','AM III','MGR-A','M','M II','M III',
                            'SM','SM II','SM III', //end of megaworld ranks);
                            'M009','M010','M011','M012','M','M-TTTI','SM','SM - TTTI','D013','D014',
                            ); // end of GL RANKS

                $avp = array('AVP','AVP-TTTI', 'SAVP');
                //vp & up - Ms. Lourdes
                $vpup = array(
                    'FVP', //end of GL RANKS
                    'VP', 'EVP','SEVP','SVP','FVP','COO','D015','D016' // end of MEGA RANKS
                );

                $companies = [

                    'GLOBAL01' => 'Makati City',
                    'LGMI01' => 'Makati City',
                    'MEGA01' => '25th Floor, Alliance Global Tower 36th Street cor. 11th Avenu, Uptown Bonifacio Taguig',
                    'TOWN01' => '3/F Forbestown Information Center, Rizal Drive corner 26th Street, Bonifacio Global City, Taguig',
                    'SUNT01' => '26th Floor, Alliance Global Tower, 36th Street cor 11th Avenue, Uptown Bonifacio',
                    'NCCAI' => 'Star Cruises Centre, 100 Andrews Avenue, Newport City, Vlllamor Air Base, Pasay City, Metro Manila',
                    'MLI01' => '19/F Alliance Global Tower, 36th Street corner 11th Avenue, Uptown Bonifacio, Taguig City, 1634',
                    'MCTI' => 'Capital Boulevard, Barangay Sto. Niño, City of San Fernando, Pampanga',
                    'LUCK01' => '5F Lucky Chinatown Mall, Reina Regente St. corner Dela Reina St., Brgy. 293, Zone 28, Binondo, Manila',
                    'ERA01' => '30th Floor, Alliance Global Tower, 36th Street cor 11th Avenue, Uptown Bonifacio, Taguig City',
                    'ECOC01' => 'GF The World Center Building, 330 Senator Gil Puyat Avenue, Makati City',
                    'CITYLINK01' => 'Ground Floor, McKinley Parking Building, Service Road 2, Mckinley Town Center, Fort Bonifacio Taguig',
                    'SIRUS' => 'Lot 28-7 Along M.A Roxas Highway, Clark Freeport Zone',
                    'ASIAAPMI' => '24F ALLIANCE GLOBAL TOWER 36TH STREET CORNER 11 AVENUE UPTOWN BONIFACIO TAGUIG CITY'
                ];

                switch($coe[0]["type"]){
                    case  "COEAPPROVEDLEAVE":
                        $start_date = $coe[0]["leave_from"];
                        $end_date = $coe[0]["leave_to"];
                        $return_date = $coe[0]["leave_return"];
                        include(TEMP.'/coe/approved-leave.php');
                        break;
                }

                    
            ?>

            <div class="ref">
                <span>HR Action No.: HRA2022-0001</span>
            </div> <!-- ref -->
            <div class="footer">
                <p>25/F Alliance Global Tower, 36th Street corner 11th Avenue Uptown Bonifacio, Taguig City 1634 <br> Trunkline: (632) 905-2900 • (632) 905-2800 <br /> www.megaworldcorp.com • Email: infodesk@megaworldcorp.com</p>
            </div> <!-- footer -->
        </div> <!-- content -->
    </div> <!-- sub-page -->
</div> <!-- main-page -->


      