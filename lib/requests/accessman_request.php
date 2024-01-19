<?php 
include("../../config.php"); 
include(LIB."/login/chklog.php");
include(CLASSES."/AccessManagement.php");

$accessman = new AccessManagement;

switch ($_GET['sec'])
{
    case 'actoggle':	
        $user_empid = $_POST['empid'];
        $user_dbname = $_POST['empiddb'];
        $company_db = $_POST['companydb'];
        $access = $_POST['toggleval'];

        echo $accessman->setAccess($user_empid, $user_dbname, $company_db, $access);
        break;
}
