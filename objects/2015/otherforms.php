<?php

	if ($logged == 1) {

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NUM_ROWS * ($page - 1);

            //*********************** MAIN CODE START **********************\\

            # ASSIGNED VALUE
            $page_title = "Other Forms";

            //***********************  MAIN CODE END  **********************\\

            global $sroot, $profile_id, $unix3month;

						$forms = array(
							[
								"name" => "purchase_request",
								"title" => "Purchase Request",
								"items" =>
									[
										"name" => "dtrdate",
										"title" => "DTR Date",
										"hclass" => "form-control input-sm datepick5",
										"defaultValue" => "date('Y-m-d')"
									],
								"approvers" => "frmApplicationWHWeb",
								"customApprovers" =>
									[
										"EmpID" => "2019-02-0033",
										"DBNAME" => "GL",
										"NAME" => "Spencer"
									],
								"isApproved" => 1,
								"dateApproved" => "2020-07-15",
								"formStatus" => "APPROVED",
								"dateApplied" => "2020-07-01"
							],
							[
								"name" => "travel_form",
								"title" => "Travel Form",
								"items" =>
									[
										[
											"name" => "dtrdate",
											"title" => "DTR Date",
											"hclass" => "form-control input-sm datepick5"
										],
										[
											"name" => "gender",
											"title" => "Gender",
											"type" => "radio",
											"hclass" => "form-control input-sm",
											"options" =>
												[
													['value' => 'male', 'text' => 'Male'],
													['value' => 'female', 'text' => 'Female']
												]
										]
									],
								"approvers" => "frmApplicationWHWeb",
								"customApprovers" =>
									[
										"EmpID" => "2019-02-0033",
										"DBNAME" => "GL",
										"NAME" => "Spencer"
									],
								"isApproved" => 1,
								"dateApproved" => "2020-07-15",
								"formStatus" => "APPROVED",
								"dateApplied" => "2020-07-01"
							]
						);
	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}

?>
