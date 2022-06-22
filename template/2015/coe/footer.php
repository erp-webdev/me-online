<?php
    if ((in_array($coe[0]["company"], ['GLOBAL01', 'LGMI01'])) ) {
    ?>
        <p style="font-size: <?php echo $send_pdf ? '8px' : '10px'; ?>; text-align: center;">Unit G, Ground Floor, 331 Building, 331 Sen. Gil Puyat Avenue, Barangay Bel-Air, Makati City 1200 • Tels (632) 5411979 / 8946345 <br />
        <a href="www.globalcompanies.com.ph">www.globalcompanies.com.ph</a> • Email: <a href="globalonehr@globalcompanies.com.ph">globalonehr@globalcompanies.com.ph</a></p>
    <?php
    } elseif (($coe[0]["company"] == 'MEGA01')) {
    ?>
        <p style="font-size: <?php echo $send_pdf ? '8px' : '10px'; ?>; text-align: center;">25/F Alliance Global Tower, 36th Street corner 11th Avenue Uptown Bonifacio, Taguig City 1634 <br />
        Trunkline: (632) 905-2900 • (632) 905-2800 <br />
        www.megaworldcorp.com • Email: infodesk@megaworldcorp.com</p>
    <?php
    } elseif (($coe[0]["company"] == 'MCTI') ) {
    ?>
        <p style="font-size: <?php echo $send_pdf ? '8px' : '10px'; ?>; color: #005f2f; text-align: center;">Capitol Boulevard, Barangay Sto. Niño, City of San Fernando, Pampanga 2000 | Tels 045-963-1990<br />
        www.capitaltownpampanga.com | Email info: info@capitaltownpampanga</p>
    <?php
    } elseif (($coe[0]["company"] == 'ASIAAPMI') ) {
    ?>
        <p style="font-size: <?php echo $send_pdf ? '8px' : '10px'; ?>; color: #005f2f; text-align: center;">6/F One World Square, Upper McKinley Road, Taguig City, NCR Philippines, 1634<br />
        Telefax No. 8524-4284 | wwww.asia-affinity.com</p>
    <?php
    }
?>