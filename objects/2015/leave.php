<?php

	if ($logged == 1) {

        //$lv_app = 0;

        if ($lv_app) :

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NUM_ROWS * ($page - 1);

            //*********************** MAIN CODE START **********************\\

            # ASSIGNED VALUE
            $page_title = "Leave Application";

            //***********************  MAIN CODE END  **********************\\

            global $sroot, $profile_id, $unix3month;

            $leave_data = $mainsql->get_leave();
						$cnt = 0;

						while($cnt < 4) :

								$lbalancepost['EMPID'] = $profile_idnum;
								if($cnt == 0){
									$lbalancepost['LEAVEID'] = 'L01';
								}elseif ($cnt == 1) {
									$lbalancepost['LEAVEID'] = 'L02';
								}elseif ($cnt == 2) {
									$lbalancepost['LEAVEID'] = 'L03';
								}elseif ($cnt == 3) {
									$lbalancepost['LEAVEID'] = 'L05';
								}

								$calculate_balance = $mainsql->calculate_lbalance($lbalancepost, $dbname);
								$cnt++;

						endwhile;

            // REGISTER LEAVE
            if ($_POST['btnleaveapply'] || $_POST['btnleaveapply_x']) :


                //GET LEAVE BALANCE

                $ltype = $_POST['leave_type'];
                if ($ltype) :
                    if ($ltype == 'L01' || $ltype == 'L03') :
                        $leave_bal = $mainsql->get_newleavebal_byid_pryear($profile_idnum, $ltype, date('Y', strtotime($_POST['leave_to'])));

                        if ($leave_bal[0]['BALANCE']) :
                            $balance = round($leave_bal[0]['BALANCE'] * 2, 0) / 2;
                        else :
                            $balance = 0;
                        endif;
                    else :
                        $leave_bal = $mainsql->get_leavebal_byid($profile_idnum, $ltype);

                        if ($leave_bal[0]['BalanceHrs']) :
                            $balance = round($leave_bal[0]['BalanceHrs'] * 2, 0) / 2;
                        else :
                            $balance = 0;
                        endif;
                    endif;
                else :
                    $balance = 0;
                endif;
                $balanceval = $balance <= 0 ? 0 : $balance;


                //CHECK DATE IF ITS APPLIED - START

                $leavestart = date("Y-m-d", strtotime($_POST['leave_from']));
                $leaveend = date("Y-m-d", strtotime($_POST['leave_to']));

                if ($_POST['totaldays'] == 0) :
                    echo '{"success": false, "error": "You\'ve no date series on leave details. Please check DTR first"}';
                    exit();
                endif;

                $getleaveapplied = $mainsql->get_leavedata_applied($profile_idnum, $leavestart, $leaveend);
                if ($getleaveapplied) :
                    echo '{"success": false, "error": "One of the date on leave has been applied or approved "}';
                    exit();
                endif;

                //CHECK DATE IF ITS APPLIED - END

                $allowedExts = array("JPG", "JPEG", "GIF", "PNG", "PDF", "jpg", "jpeg", "gif", "png", "pdf");

								//test for leave balance
								// $bal1 = $_POST['balance'];
								// $day1 = $_POST['days'];
								//
								// echo '{"success": false, "error": " '.$bal1.' >= '.$day1.'  && '.$balanceval.' => '.$day1.' "}';
								// exit();


                if ($_POST['balance'] >= $_POST['days'] && $balanceval >= $_POST['days']) :


                    if ($_POST['leave_type'] == "L01" && count($_POST['leave_duration']) >= 3) :
                        if (!$_FILES['attachment1']['name']) :
                            echo '{"success": false, "error": "Attachment is required on 3 or more day sick leave"}';
                            exit();
                        endif;
                    endif;

                    if ($_POST['leave_type'] == "L12") :
                        $bdaymonth = date('n', strtotime($profile_bday));
                        if ($bdaymonth != date('n', strtotime($_POST['leave_from']))) :
                            echo '{"success": false, "error": "This is not your birthday month"}';
                            exit();
                        endif;
                    endif;

                    $errorfile = 0;
                    for($i=1; $i<=5; $i++) :

                        if ($_FILES['attachment'.$i]['name']) :
                            $filename = $_FILES['attachment'.$i]['name'];
                            $filesize = $_FILES['attachment'.$i]['size'];

                            $tempext = explode(".", $filename);
                            $extension = end($tempext);

                            if (($filesize >= 209715) || !in_array($extension, $allowedExts)) :
                                $errorfile++;
                            endif;
                        endif;
                    endfor;

                    if ($errorfile) :
                        echo '{"success": false, "error": "One of the attachment isn\'t PDF, JPG nor GIF and/or not less then 200Kb"}';
                        exit();
                    endif;


                    //LEAVE ITEMS
                    $mail_details = '';

                    $err_item = 0;
                    $leaveitemcount = count($_POST['leave_duration']);
										$backend_count = 0;
										$backend_hours = 0;
										$coverage_dates = array();

										while($backend_count < $leaveitemcount){

											$leaveduration = $_POST['leave_duration'][$backend_count];
											$leavedate = $_POST['leave_date'][$backend_count];
											$leavepay = $_POST['leave_pay'][$backend_count];
											$leavetype = $_POST['leave_type'];
											$leaveempid = $_POST['empid'];
											array_push($coverage_dates, $_POST['leave_date'][$backend_count]);

											if($leavepay){

												$leavsched = $mainsql->get_schedshiftdtr($profile_idnum, $leavedate);
		                    $leaveshift = $mainsql->get_shift($leavsched[0]['ShiftID']);
		                    $leavehours = $leaveshift[0]['NUMHrs'] - $leaveshift[0]['BreakHours'];

												if ($leavetype == "L01" || $leavetype == "L03"){

													if($leaveduration == 'WD'){
														if($profile_compressed){
															$backend_hours += $leavehours;
														}else{
															$backend_hours += 1;
														}
													}else if($leaveduration == 'HD1' or $leaveduration == 'HD2'){
														if($leavehours >= 8){
															if($profile_compressed){
																$backend_hours += $leavehours / 2;
															}else{
																$backend_hours += 0.5;
															}
														}else{
															if($profile_compressed){
																$backend_hours += $leavehours;
															}else{
																$backend_hours += 0.5;
															}
														}
													}
												}else{
													if ($leaveduration == "WD") :
	                                $backend_hours += 8;
	                        elseif ($leaveduration == "HD1") :
	                                $backend_hours += 4;
	                        elseif ($leaveduration == "HD2") :
	                                $backend_hours += 4;
	                        else :
	                            $backend_hours += 0;
	                        endif;
												}

											}
											$backend_count++;
										}
										$coverage_max = max($coverage_dates);
										$coverage_min = min($coverage_dates);

										//re iteration here to calculate duration with pay
										//after compare again to balance $balanceval


										if($_POST['leave_type'] == 'L01' || $_POST['leave_type'] == 'L03'){
											$usable_lbalance = $mainsql->get_usablebal($profile_idnum, $_POST['leave_type']);
											$balanceval = $usable_lbalance[0]['BalanceHrs'];
										}

										echo '{"success": false, "error": "Dev Test: BalanceVal: '.$balanceval.' BackendHours: '.$backend_hours.' Compressed: '.$profile_compressed.'"}';
										exit();

										if($balanceval < $backend_hours){
											echo '{"success": false, "error": "Your leave with pay is greater than your leave balance"}';
											exit();
										}

                    $cnti = 0;

                    while($cnti < $leaveitemcount) :

                        if ($cnti == 0) :
                            $litempost['REQNBR'] = 0;
                        else :
                            $litempost['REQNBR'] = $add_leaveitem;
                        endif;
                        $litempost['DURATION'] = $_POST['leave_duration'][$cnti];
                        $litempost['LEAVEDATE'] = $_POST['leave_date'][$cnti];
                        $litempost['WITHPAY'] = $_POST['leave_pay'][$cnti];
                        $litempost['ABSENTID'] = $_POST['leave_type'];
                        $litempost['EMPID'] = $_POST['empid'];

                        $add_leaveitem = $mainsql->leave_action($litempost, 'add_item');

                        if ($add_leaveitem) :
                            $mail_details .= "<tr><td>".date('M j', strtotime($_POST['leave_date'][$cnti]))."</td><td>".$_POST['leave_duration'][$cnti]."</td><td>".($_POST['leave_pay'][$cnti] ? 'Yes' : 'No')."</td></tr>";
                            $cnti++;
                        endif;

                    endwhile;

                    if (!$cnti) :
                        echo '{"success": false, "error": "No leave details has been set. Please check your DTR first."}';
                        exit();
                    endif;

                    /*foreach ($_POST['leave_duration'] as $key => $value) :

                        $litempost['REQNBR'] = $add_leave;
                        $litempost['DURATION'] = $value;
                        $litempost['LEAVEDATE'] = $_POST['leave_date'][$key];
                        $litempost['WITHPAY'] = $_POST['leave_pay'][$key];

                        $mail_details .= "<tr><td>".date('M j', strtotime($_POST['leave_date'][$key]))."</td><td>".$value."</td><td>".($_POST['leave_pay'][$key] ? 'Yes' : 'No')."</td></tr>";
                        $add_leaveitem = $mainsql->leave_action($litempost, 'add_item');

                        if ($add_leaveitem != 1) : $err_item++; endif;

                    endforeach; */

                    $leavepost['EMPID'] = $_POST['empid'];
                    $leavepost['REQNBR'] = $add_leaveitem;
                    $leavepost['TRANS'] = "APPLY";
                    $leavepost['ABSENTID'] = $_POST['leave_type'];
                    $leavepost['ABSENTFROMDATE'] = $coverage_min;
                    $leavepost['ABSENTTODATE'] = $coverage_max;
                    $leavepost['DAYS'] = $_POST['days'];
                    $leavepost['HOURS'] = $_POST['days'] * 8;
                    $leavepost['REASON'] = addslashes($_POST['leave_reason']);
                    $leavepost['APPROVER01'] = $_POST['approver1'];
                    $leavepost['APPROVER02'] = $_POST['approver2'];
                    $leavepost['APPROVER03'] = $_POST['approver3'];
                    $leavepost['APPROVER04'] = $_POST['approver4'];
                    $leavepost['APPROVER05'] = $_POST['approver5'];
                    $leavepost['APPROVER06'] = $_POST['approver6'];
                    $leavepost['DBAPPROVER01'] = $_POST['dbapprover1'];
                    $leavepost['DBAPPROVER02'] = $_POST['dbapprover2'];
                    $leavepost['DBAPPROVER03'] = $_POST['dbapprover3'];
                    $leavepost['DBAPPROVER04'] = $_POST['dbapprover4'];
                    $leavepost['DBAPPROVER05'] = $_POST['dbapprover5'];
                    $leavepost['DBAPPROVER06'] = $_POST['dbapprover6'];
                    $leavepost['USER'] = $_POST['user'];
                    $leavepost['REMARKS'] = "";

                    $add_leave = $mainsql->leave_action($leavepost, 'add');
                    //var_dump($add_leave);
                    if($add_leave) :

                        for($i=1; $i<=5; $i++) :

                            //var_dump($_FILES['attachment'.$i]);

                            if ($_FILES['attachment'.$i]['name']) :

                                $image = $_FILES['attachment'.$i]['tmp_name'];
                                $filename = $_FILES['attachment'.$i]['name'];
                                $filesize = $_FILES['attachment'.$i]['size'];
                                $filetype = $_FILES['attachment'.$i]['type'];

                                $tempext = explode(".", $filename);
                                $extension = end($tempext);

                                if (($filesize < 10485760) && in_array($extension, $allowedExts)) :

                                    $path = "uploads/leave/";
                                    $fixname = 'attach_'.$add_leave.'_'.$i.'.'.$extension;
                                    $target_path = $path.$fixname;

                                    $filemove = move_uploaded_file($image, $target_path);

                                    $attach['attachfile'] = $fixname;
                                    $attach['attachtype'] = $filetype;
                                    $attach['reqnbr'] = $add_leave;
                                    //var_dump($filemove);

                                    if($filemove) :
                                        $add_attach = $mainsql->attach_action($attach, 'add');
                                    endif;

                                endif;

                            endif;

                        endfor;

                        $requestor = $register->get_member($_POST['empid']);
                        $request_info = $tblsql->get_mrequest(2, 0, 0, 0, $add_leave, 0, NULL, NULL, NULL, NULL);
                        $approver = $logsql->get_allmember($_POST['approver1'], $_POST['dbapprover1']);

                        $reqemailblock = $mainsql->get_newemailblock($_POST['empid']);
                        $appemailblock = $mainsql->get_newemailblock($_POST['approver1']);

                        if ($reqemailblock) :
                            //SEND EMAIL (REQUESTOR)

                            $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New Leave Request</span><br><br>Hi ".$requestor[0]['NickName'].",<br><br>";
                            $message .= "You opened a new request for leave with Reference No: ".$add_leave." on ".date('F j, Y')." and it's subject for approval. ";
                            $message .= "<br><br><table border='1' cellpadding='3' cellspacing='0' style='border: 1px solid #666; font-size: 12px; font-family: Verdana;'>";
                            $message .= "<tr><td style='background-color: #024485; color: #FFF; text-align: center'><b>Date</b></td><td style='background-color: #024485; color: #FFF; text-align: center'><b>Duration</b></td><td style='background-color: #024485; color: #FFF; text-align: center'><b>With Pay</b></td></tr>";
                            $message .= $mail_details;
                            $message .= "</table>";
                            $message .= "<br><br>Thanks,<br>";
                            $message .= SITENAME." Admin";
                            $message .= "<hr />".MAILFOOT."</div>";

                            $headers = "From: ".NOTIFICATION_EMAIL."\r\n";
                            $headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                            $sendmail = mail($requestor[0]['EmailAdd'], "New Leave Request", $message, $headers);
                        endif;

                        if ($appemailblock) :
                            //SEND EMAIL (APPROVER)

                            $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>New Leave Request from ".$requestor[0]['FName']." ".$requestor[0]['LName']."</span><br><br>Hi ".$approver[0]['NickName'].",<br><br>";
                            $message .= "New request ".$requestor[0]['FName']." ".$requestor[0]['LName']." for leave with Reference No: ".$add_leave." on ".date('F j, Y')." for your approval. ";
                            $message .= "<br><br><table border='1' cellpadding='3' cellspacing='0' style='border: 1px solid #666; font-size: 12px; font-family: Verdana;'>";
                            $message .= "<tr><td style='background-color: #024485; color: #FFF; text-align: center'><b>Date</b></td><td style='background-color: #024485; color: #FFF; text-align: center'><b>Duration</b></td><td style='background-color: #024485; color: #FFF; text-align: center'><b>With Pay</b></td></tr>";
                            $message .= $mail_details;
                            $message .= "</table>";
                            $message .= "<br><br>Thanks,<br>";
                            $message .= SITENAME." Admin";
			    $message .= "<br>Click<a href='https://portal.megaworldcorp.com/me/login'> here</a> to login";
                            $message .= "<hr />".MAILFOOT."</div>";

                            $headers = "From: ".NOTIFICATION_EMAIL."\r\n";
                            $headers .= "Reply-To: ".NOTIFICATION_EMAIL."\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                            $sendmail = mail($approver[0]['EmailAdd'], "New Leave Request for your Approval", $message, $headers);
                        endif;

                        //READ STATUS
                        if ($_POST['approver1'] && $add_leave) :
                            $insert_read = $mainsql->insert_read($_POST['approver1'], $add_leave);
                        endif;

                        //AUDIT TRAIL
                        $post['EMPID'] = $profile_idnum;
                        $post['TASKS'] = "CREATE_LEAVE";
                        $post['DATA'] = $add_leave;
                        $post['DATE'] = date("m/d/Y H:i:s.000");

                        $log = $mainsql->log_action($post, 'add');

                        if ($err_item) :
                            echo '{"success": false, "error": "One or more of leave item hasn\'t been process due network problem. Please forward email notification with its request ID."}';
                            exit();
                        else :
                            echo '{"success": true}';
                            exit();
                        endif;

                    else :
                        echo '{"success": false, "error": "There was a problem on leave application"}';
                        exit();
                    endif;
                else :
                    echo '{"success": false, "error": "Your leave with pay is greater than your leave balance."}';
                    exit();
                endif;


            endif;

        else :

            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."'</script>";

        endif;
	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}

?>
