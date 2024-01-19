<?php    
	
	if ($logged == 1) :

		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."'</script>";		

	else :
	        
        //*********************** MAIN CODE START **********************\\
			
		# ASSIGNED VALUE
		$page_title = "Registration";	
		
		//***********************  MAIN CODE END  **********************\\
        
        global $sroot;
        
        if ($_POST) :
        
            if ($_FILES["binFile"]["name"]) :
                $allowedExts = array("jpg", "jpeg", "gif");
                $temp = explode(".", $_FILES["binFile"]["name"]);
                $extension = end($temp);
                if (($_FILES["binFile"]["size"] < 102400) && in_array($extension, $allowedExts)) :
                    if ($_FILES["binFile"]["error"] > 0) :
                        echo '{"success": false, "error": "Error: '.$_FILES["binFile"]["error"].'"}';
                        exit();
                    else :

                        $image = $_FILES['binFile']['tmp_name'];
                        $fp = fopen($image, 'r');
                        $content = fread($fp, filesize($image));
                        $post['content'] = addslashes($content);
                        fclose($fp);
                            
                        $post['binFile_name'] = $_FILES['binFile']['name'];
                        $post['binFile_size'] = $_FILES['binFile']['size'];
                        $post['binFile_type'] = $_FILES['binFile']['type'];

                        $passwordgen = $register->random_password();
                        $post['passwordgen'] = $passwordgen;
        
                        $post['eid'] = $_POST['eid']; 
                        $post['ehash'] = $_POST['emphash']; 
                    
                        $post['empnum'] = $_POST['empnum'];
                    
                        $post['dateapp'] = $_POST['dateko'];
                        $post['postapp'] = $_POST['position'];
                        $post['otherpos'] = $_POST['otherpos'];
                    
                        if ($post['postapp'] == 1000000) :
                            $sqlmaxpos = $main->get_position(0, NULL, 0, 0, NULL, 0, 1);
                            foreach ($sqlmaxpos as $rowmaxpos) :
                                $max_array = $rowmaxpos;
                            endforeach;  
                            $newposid = (int)$max_array['posid'] + 1;
                            $sqlchkpos = $main->get_position(0, $otherpos, 0, 0, NULL, 1, 0);
                            if ($sqlchkpos == 0) :
                                $sqlinspos = $main->position_action($otherpos, 'add', $newposid);
                                $postapp = $newposid;
                            endif;
                        endif;
                        
                        $post['lastname'] = $_POST['lastname'];
                        $post['firstname'] = $_POST['firstname'];
                        $post['middlename'] = $_POST['middlename'];
                        $post['nickname'] = $_POST['nickname'];
                        $post['suffixname'] = $_POST['suffixname'];
                    
                        $post['addressnumber'] = $_POST['address_num'];
                        $post['addressstreet'] = $_POST['address_street'];
                        $post['addressbrgy'] = $_POST['address_brgy'];
                        $post['addresscity'] = $_POST['address_city'];
                        $post['addressregion'] = $_POST['address_region'];
                        $post['addresszip'] = $_POST['address_zip'];
                        $post['addresscountry'] = $_POST['address_country'];
                    
                        $post['provincialaddress'] = $_POST['provincial_address'];
                    
                        $post['contactno'] = $_POST['contact'];
                        $post['email'] = $_POST['email'];
                        $post['birthday'] = $_POST['birthday'];
                        $post['birthplace'] = $_POST['birthplace'];
                        $post['sex'] = $_POST['sex'];
                        $post['civil'] = $_POST['civil'];
                    
                        $post['sss'] = $_POST['sss'];
                        $post['tin'] = $_POST['tin'];
                        $post['philhealth'] = $_POST['philhealth'];
                        $post['hdmf'] = $_POST['pagibig'];
                    
                        $post['spouse'] = $_POST['spouse_name'];
                        $post['sbday'] = $_POST['spouse_bday'];
                        $post['scomp'] = $_POST['spouse_comp'];
                        $post['soccupation'] = $_POST['spouse_work'];
                    
                        $children_data = array();
                        foreach ($_POST['child_name'] as $key => $value) :
                            if ($_POST['child_name'][$key]) :
                                $children_data[$key]['name'] = $_POST['child_name'][$key];
                                $children_data[$key]['bday'] = $_POST['child_age'][$key];
                                $children_data[$key]['company'] = $_POST['child_comp'][$key];
                                $children_data[$key]['work'] = $_POST['child_work'][$key];
                                $children_data[$key]['cbir'] = $_POST['child_bir'][$key];
                                $children_data[$key]['cph'] = $_POST['child_ph'][$key];
                                $children_data[$key]['cmc'] = $_POST['child_mc'][$key];
                            endif;
                        endforeach;
                        $children_data = serialize($children_data);
                        $post['children_data'] = htmlentities($children_data, ENT_QUOTES);
                    
                        $post['father'] = $_POST['father_name'];
                        $post['fbday'] = $_POST['father_bday'];
                        $post['fcomp'] = $_POST['father_comp'];
                        $post['foccupation'] = $_POST['father_work'];
                    
                        $post['mother'] = $_POST['mother_name'];
                        $post['mbday'] = $_POST['mother_bday'];
                        $post['mcomp'] = $_POST['mother_comp'];
                        $post['moccupation'] = $_POST['mother_work'];
                    
                        $post['datehired'] = $_POST['datehired'];
                    
                        $brosis_data = array();
                        foreach ($_POST['brod_name'] as $key => $value) :
                            if ($_POST['brod_name'][$key]) :
                                $brosis_data[$key]['name'] = $_POST['brod_name'][$key];
                                $brosis_data[$key]['bday'] = $_POST['brod_bday'][$key];
                                $brosis_data[$key]['company'] = $_POST['brod_comp'][$key];
                                $brosis_data[$key]['work'] = $_POST['brod_work'][$key];
                            endif;
                        endforeach;
                        $brosis_data = serialize($brosis_data);
                        $post['brosis_data'] = htmlentities($brosis_data, ENT_QUOTES);
                        
                        $post['school'] = "";
                        foreach ($_POST['schoolname'] as $key => $value) :        
                            if ($key != 0) : $post['school'] .= "|"; endif;
                            $post['school'] .= $_POST['schoolname'][$key];
                        endforeach;
                    
                        $post['from'] = "";
                        foreach ($_POST['schoolfrom'] as $key => $value) :
                            if ($key != 0) : $post['from'] .= "|"; endif;
                            $post['from'] .= $_POST['schoolfrom'][$key];
                        endforeach;
                    
                        $post['to'] = "";
                        foreach ($_POST['schoolto'] as $key => $value) :
                            if ($key != 0) : $post['to'] .= "|"; endif;
                            $post['to'] .= $_POST['schoolto'][$key];
                        endforeach;
                    
                        $post['degree'] = "";
                        foreach ($_POST['schooldegree'] as $key => $value) :
                            if ($key != 0) : $post['degree'] .= "|"; endif;
                            $post['degree'] .= $_POST['schooldegree'][$key];
                        endforeach;
                    
                        $govlic_data = array();
                        foreach ($_POST['exam_name'] as $key => $value) :
                            if ($_POST['exam_name'][$key]) :
                                $govlic_data[$key]['name'] = $_POST['exam_name'][$key];
                                $govlic_data[$key]['rating'] = $_POST['exam_rating'][$key];
                                $govlic_data[$key]['date'] = $_POST['exam_date'][$key];
                            endif;
                        endforeach;
                        $govlic_data = serialize($govlic_data);
                        $post['govlic_data'] = htmlentities($govlic_data, ENT_QUOTES);
                    
                        $seminar_data = array();
                        foreach ($_POST['seminar_title'] as $key => $value) :
                            if ($_POST['seminar_title'][$key]) :
                                $seminar_data[$key]['title'] = $_POST['seminar_title'][$key];
                                $seminar_data[$key]['place'] = $_POST['seminar_place'][$key];
                                $seminar_data[$key]['date'] = $_POST['seminar_date'][$key];
                            endif;
                        endforeach;
                        $seminar_data = serialize($seminar_data);
                        $post['seminar_data'] = htmlentities($seminar_data, ENT_QUOTES);
                    
                        $otherskills = array();
                        foreach ($_POST['skill'] as $key => $value) :    
                            if ($_POST['skill'][$key]) $otherskills[$key]['name'] = $_POST['skill'][$key];
                        endforeach;
                        $otherskills = serialize($otherskills);
                        $post['otherskills'] = htmlentities($otherskills, ENT_QUOTES);
                    
                        $organization = array();
                        foreach ($_POST['org_name'] as $key => $value) :
                            if ($_POST['org_name'][$key]) :
                                $organization[$key]['name'] = $_POST['org_name'][$key];
                                $organization[$key]['position'] = $_POST['org_position'][$key];
                                $organization[$key]['year'] = $_POST['org_year'][$key];
                            endif;
                        endforeach;
                        $organization = serialize($organization);
                        $post['organization'] = htmlentities($organization, ENT_QUOTES);
                    
                        $hcomp = array();
                        foreach ($_POST['comp_name'] as $key => $value) :
                            if ($_POST['comp_name'][$key]) :
                                $hcomp[$key]['name'] = $_POST['comp_name'][$key];
                                $hcomp[$key]['address'] = $_POST['comp_address'][$key];
                                $hcomp[$key]['telno'] = $_POST['comp_telno'][$key];
                                $hcomp[$key]['position'] = $_POST['comp_position'][$key];
                                $hcomp[$key]['supervisor'] = $_POST['comp_supervisor'][$key];
                                $hcomp[$key]['salary'] = $_POST['comp_salary'][$key];
                                $hcomp[$key]['reason'] = $_POST['comp_reason'][$key];
                                $hcomp[$key]['from'] = $_POST['comp_from'][$key];
                                $hcomp[$key]['to'] = $_POST['comp_to'][$key];
                            endif;
                        endforeach;
                        $hcomp = serialize($hcomp);
                        $post['hcomp'] = htmlentities($hcomp, ENT_QUOTES);
                        
                        $post['ref'] = $_POST['refer1_name']."|".$_POST['refer2_name']."|".$_POST['refer3_name'];
                        $post['refpos'] = $_POST['refer1_position']."|".$_POST['refer2_position']."|".$_POST['refer3_position'];
                        $post['refcomp'] = $_POST['refer1_comp']."|".$_POST['refer2_comp']."|".$_POST['refer3_comp'];
                        $post['refadd'] = $_POST['refer1_address']."|".$_POST['refer2_address']."|".$_POST['refer3_address'];
                        $post['refno'] = $_POST['refer1_telno']."|".$_POST['refer2_telno']."|".$_POST['refer3_telno'];
                        $post['emergency'] = $_POST['emergency_name'];
                        $post['eadd'] = $_POST['emergency_address'];
                        $post['ephone'] = $_POST['emergency_telno'];

                        $post['cdiv'] = $_POST['division'];
                        $post['cgrp'] = $_POST['dgroup'];
                        $post['cdept'] = $_POST['department'];
                        $post['csec'] = $_POST['dsection'];
                        $post['cphone'] = $_POST['local'];
                        $post['cemail'] = $_POST['corp_email'];
                        $post['capprover'] = $_POST['ihead'];
                    
                        $post['elevel'] = $_POST['iamhead'] == 1 ? 2 : 1;
                        
                        $sql = $register->add_member($post);

                        //AUDIT TRAIL
                        //$log = $main->log_action("REGISTER_USER", $add_user, $add_user);
                                        
                        $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>HR Portal Account Registration</span><br><br>Hi ".$_POST['nickname'].",<br><br>";
                        $message .= "Your registration with Employee ID. ".$_POST['empnum']." is on process and subject for approval by your immediate head.<br><br>";
                        $message .= "Thanks,<br>";
                        $message .= "HR Portal Admin";
                        $message .= "<hr />".MAILFOOT."</div>";
                        
                        $headers = "From: noreply@alias.megaworldcorp.com\r\n";
                        $headers .= "Reply-To: noreply@megaworldcorp.com\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                
                        $sendmail = mail($_POST['corp_email'], "HR Portal Account Registration", $message, $headers);                    
                        $approver_info = $register->get_member_by_id($_POST['ihead']);
                               
                        if ($sendmail) : 
                            $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>HR Portal Account Registration</span><br><br>Hi ".$approver_info[0]['nickname'].",<br><br>";
                            $message .= $_POST['firstname']." ".$_POST['lastname']." has been registered on Megaworld HR Portal with Employee ID. ".$_POST['empnum']." and waiting for your approval.<br><br>";
                            $message .= "Please click <a>here</a><br><br>";
                            $message .= "Thanks,<br>";
                            $message .= "HR Portal Admin";
                            $message .= "<hr />".MAILFOOT."</div>";
                            
                            $headers = "From: noreply@alias.megaworldcorp.com\r\n";
                            $headers .= "Reply-To: noreply@megaworldcorp.com\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    
                            $sendmail = mail($_POST['corp_email'], "HR Portal Account Registration", $message, $headers);

                            echo '{"success": true}';
                        else : 
                            echo '{"success": false, "error": "Mail server problem"}';
                        endif;
                        exit();
            
                    endif;    
                else :
                    echo '{"success": false, "error": "Invalid file"}';
                    exit();
                endif;

            endif;
    
        endif;
        
        $position_sel = $main->get_position(0, NULL, 0, 0, NULL, 0, 0);
        $dept_sel = $main->get_dept(0, NULL, 0, 0, NULL, 0);

	endif;
	
?>