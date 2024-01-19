<?php
    
ini_set('display_errors', 0);

    
    $dbname = array('EPARKVIEW','ECINEMA');

    foreach ($dbname as $value) :
        $renamecnt = 0;

        $files = glob(DOCUMENT.'/uploads/itr/tobeconvert/'.$value.'/*');

        foreach ($files as $fileitems) :

            $filearray = explode('/', $fileitems);
            $fileitemarray = explode('.', $filearray[9]);
            $change = str_replace(trim($fileitemarray[0]), md5('mega_2018'.$value.$fileitemarray[0]), $fileitems);
            //echo $fileitemarray[0];
            //if (strlen(trim($fileitemarray[0])) == 12) :
                $renameitr = rename($fileitems, $change);
                if ($renameitr) : $renamecnt++; endif;
            //endif;

        endforeach;

        echo $renamecnt.' '.$value.' ITR file has been renamed<br>';

    endforeach;

?>