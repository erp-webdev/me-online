<?php 
include("../../config.php"); 
include(LIB."/login/chklog.php");
include(CLASSES."/Clearance.php");

$clearance = new Clearance;

switch ($_GET['sec'])
{
    case 'update':	
        $empid = $_POST['empid'];
        $dbname = $_POST['empiddb'];
        $email = $_POST['personalemail'];
        $contact = $_POST['contactno'];
        $add = $_POST['permanentadd'];

        echo $clearance->update($empid, $dbname, $email, $contact, $add);
        break;
}
