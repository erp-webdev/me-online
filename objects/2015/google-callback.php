<?php

$client = new Google_Client();
$client->setClientId('1084522201209-pv03787uk91ilv0r2ltdroc3v2bn3gb7.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri(WEB.'/google-callback');
$client->addScope('email');
$client->addScope('profile');

if (isset($_GET['code'])) {
	// Exchange authorization code for an access token
	$_SESSION['access_token'] = $client->fetchAccessTokenWithAuthCode($_GET['code']);
	$client->setAccessToken($_SESSION['access_token']);

   $service = new Google_Service_Oauth2($client);
   $google_user = $service->userinfo->get();

   $email_domain = substr(strrchr($google_user->email, "@"), 1); 
   $allowed_domains = ['megaworldcorp.com', 'globalcompanies.com'];

    if (in_array($email_domain, $allowed_domains)) {
      $cookiename = 'megasubs_user';
      $checkfmem = $logsql->check_member_by_email($google_user->email);
      $getmem = $logsql->get_member_by_email($google_user->email);
   
      if (($checkfmem == 1 && $getmem[0]['DBNAME'] != 'MARKETING'))
      {
         $expire = time() + 60;
         $_SESSION[$cookiename] = $getmem[0]['EmpID'];
         $_SESSION['ssep_comp'] = $getmem[0]['CompanyID'];
         $_SESSION['megasubs_password'] = $getmem[0]['EPassword'];
         $_SESSION['megasubs_db'] = $getmem[0]['DBNAME'];
   
         //AUDIT TRAIL
         $post['EMPID'] = $getmem[0]['EmpID'];
         $post['TASKS'] = "LOGIN";
         $post['DATA'] = $getmem[0]['EmpID'];
         $post['DATE'] = date("m/d/Y H:i:s.000");
         $log = $logsql->log_action($post, 'add');
   
         $success = 1;
      } 
      elseif ($checkfmem > 1)
      {
            $_SESSION['dbnamelist'] ='';
            foreach ($getmem as $key => $value) :
              $_SESSION['dbnamelist'] .= "<option value='".trim($value['DBNAME'])."'>".trim($value['DBNAME'])."</option>";
            endforeach;
            
            $success = 2;
      }
      else{
   
         $sucess=0;
      }
    } else {
      echo "<script language='javascript' type='text/javascript'>
               alert('Access denied. Only users from allowed domains are permitted.');
               window.location.href='".WEB."';
            </script>";
    }
} 
else{
   $token = $_SESSION['access_token'];
	$client->setAccessToken($token);

   $service = new Google_Service_Oauth2($client);
   $google_user = $service->userinfo->get();

   if($_POST['logdbname']){
      $getmem = $logsql->get_member_by_email($google_user->email, $_POST['logdbname']);     
      
      $expire = time() + 60;
      $_SESSION[$cookiename] = $getmem[0]['EmpID'];
      $_SESSION['ssep_comp'] = $getmem[0]['CompanyID'];
      $_SESSION['megasubs_password'] = $getmem[0]['EPassword'];
      $_SESSION['megasubs_db'] = $getmem[0]['DBNAME'];

      //AUDIT TRAIL
      $post['EMPID'] = $getmem[0]['EmpID'];
      $post['TASKS'] = "LOGIN";
      $post['DATA'] = $getmem[0]['EmpID'];
      $post['DATE'] = date("m/d/Y H:i:s.000");
      $log = $logsql->log_action($post, 'add');

      $success = 1;
   }
}

echo $sucess;
if($success==1){
   echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."'</script>";
}
else if($success ==0){
   echo "<script language='javascript' type='text/javascript'>
            alert('User selected is not authorized.');
            window.location.href='".WEB."';
          </script>";
}
?>