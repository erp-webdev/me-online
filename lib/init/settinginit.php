<?php

    $settings = $tblsql->get_set();
    //var_dump($settings);

    /*define("ANNOUNCEMENT", $setting[0]['set_announce'] ? $setting[0]['set_announce'] : "");
    define("MAILFOOT", $setting[0]['set_mailfoot'] ? $setting[0]['set_mailfoot'] : "");
    define("NUM_ROWS", $setting[0]['set_numrows'] ? $setting[0]['set_numrows'] : 20); // the number of records on each page*/

    define("LAST_NOTIFY", $settings[0]['set_lastnotify'] ? date('Y-m-d', strtotime(str_replace(' 12:00:00:AM', '', $settings[0]['set_lastnotify']))) : NULL);
    //echo '<!--'.LAST_NOTIFY.'-->';
?>