<?php

    $pafsample = $pafsql->pafsample();

    echo '<table><tr><td>Ratee</td><td>Rater 1</td><td>Rater 2</td><td>Rater 3</td><td>Rater 4</td></tr>';

    foreach ($pafsample as $key => $value) :

        $pafsub = $pafsql->getsub($value['RateeEmpID']);
        $pafnsub1 = $pafsql->getnonsub($value['RaterEmpID']);
        $pafnsub2 = $pafsql->getnonsub($value['Rater2EmpID']);
        $pafnsub3 = $pafsql->getnonsub($value['Rater3EmpID']);
        $pafnsub4 = $pafsql->getnonsub($value['Rater4EmpID']);

        echo '<tr><td>'.$pafsub[0]['FName'].' '.$pafsub[0]['LName'].'<br>('.$value['RateeEmpID'].')</td><td>'.$pafnsub1[0]['FName'].' '.$pafnsub1[0]['LName'].'<br>('.$value['RaterEmpID'].')</td><td>'.$pafnsub2[0]['FName'].' '.$pafnsub2[0]['LName'].'<br>('.$value['Rater2EmpID'].')</td><td>'.$pafnsub3[0]['FName'].' '.$pafnsub3[0]['LName'].'<br>('.$value['Rater3EmpID'].')</td><td>'.$pafnsub4[0]['FName'].' '.$pafnsub4[0]['LName'].'<br>('.$value['Rater4EmpID'].')</td></tr>';

    endforeach;

    echo '</table>';

?>