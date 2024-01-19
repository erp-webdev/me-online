<?php 
session_start();
echo json_encode($_SESSION['LAST_ACTIVITY']);

 ?>