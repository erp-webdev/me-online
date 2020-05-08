<?php

    if ($logged == 1) :

        //*********************** MAIN CODE START **********************\\

		# ASSIGNED VALUE
        $empid = $_GET['id'] ? $_GET['id'] : $profile_hash;
        $edit = $_GET['edit'];
		$page_title = $edit ? "Update Profile" : "My Profile";

		//***********************  MAIN CODE END  **********************\\

        global $sroot;

        if ($_POST) :

            $post['TRANS'] = 0;
            $post['DBNAME'] = $_POST['dbname'];

            $post['EmpID'] = $_POST['empnum'];

            $post['EMPID'] = $_POST['empnum'];

            $post['LName'] = $_POST['LName'];
            $post['FName'] = $_POST['FName'];
            $post['MName'] = $_POST['MName'];
            $post['NickName'] = strtoupper($_POST['NickName']);

            $post['EmailAdd2'] = $_POST['EmailAdd2'];
            $post['EmailAdd'] = $_POST['EmailAdd'];

            $post['UnitStreet'] = $_POST['UnitStreet'];
            $post['Barangay'] = $_POST['Barangay'];
            $post['TownCity'] = $_POST['TownCity'];
            $post['StateProvince'] = $_POST['StateProvince'];
            $post['Zip'] = $_POST['Zip'];
            $post['Region'] = '';
            $post['Country'] = $_POST['Country'];



            $post['PermUnitStreet'] = $_POST['PermUnitStreet'];
            $post['PermBarangay'] = $_POST['PermBarangay'];
            $post['PermTownCity'] = $_POST['PermTownCity'];
            $post['PermStateProvince'] = $_POST['PermStateProvince'];
            $post['PermZip'] = $_POST['PermZip'];
            $post['PermRegion'] = '';
            $post['PermCountry'] = $_POST['PermCountry'];

            $post['HomeNumber'] = $_POST['HomeNumber'];
            $post['MobileNumber'] = $_POST['MobileNumber'];

            $post['Gender'] = $_POST['EGender'];
            $post['Citizenship'] = $_POST['Citizenship'];
            $post['BirthDate'] = date('m/d/Y 00:00:00.000', strtotime($_POST['BirthDate']));
            $post['BirthPlace'] = strtoupper($_POST['BirthPlace']);

            $post['MotherMaiden'] = strtoupper($_POST['MotherMaiden']);
            $post['SpouseName'] = strtoupper($_POST['SpouseName']);
            $post['SpouseOccupation'] = strtoupper($_POST['SpouseOccupation']);
            $post['IncomeSource'] = strtoupper($_POST['IncomeSource']);
            $post['OtherIncomeSource'] = strtoupper($_POST['OtherIncomeSource']);

            $post['ContactPerson'] = $_POST['ContactPerson'];
            $post['ContactAddress'] = $_POST['ContactAddress'];
            $post['ContactTelNbr'] = $_POST['ContactTelNbr'] ? $_POST['ContactTelNbr'] : NULL;
            $post['ContactMobileNbr'] = $_POST['ContactMobileNbr'];

            if (!$_POST['NickName'] || !$_POST['EmailAdd'] || !$_POST['EmailAdd2'] || !$_POST['UnitStreet'] || !$_POST['Barangay'] || !$_POST['TownCity'] || !$_POST['StateProvince'] || !$_POST['Zip'] || !$_POST['PermUnitStreet'] || !$_POST['PermBarangay'] || !$_POST['PermTownCity'] || !$_POST['PermStateProvince'] || !$_POST['PermZip'] || !$_POST['MobileNumber'] || !$_POST['BirthDate'] || !$_POST['BirthPlace'] || !$_POST['SpouseName'] || !$_POST['SpouseOccupation'] || !$_POST['MotherMaiden'] || !$_POST['OtherIncomeSource']  || !$_POST['ContactPerson'] || !$_POST['ContactAddress'] || !$_POST['ContactMobileNbr'] || !$_POST['OffUnitStreet']
			|| !$_POST['OffBarangay'] || !$_POST['OffTownCity'] || !$_POST['OffStateProvince'] || !$_POST['OffZip'] || !$_POST['OffRegion'] || !$_POST['OffCountry']) :
                echo '{"success": false, "error": "All fields with * are required"}';
                exit();
            endif;

            $sqldeldep = $logsql->del_dependent($_POST['empnum'], 0, $_POST['dbname']);

            foreach ($_POST['Dependent'] as $key => $value) :
                $postdep['EmpID'] = $_POST['empnum'];
                $postdep['Dependent'] = $value;
                $postdep['Relation'] = $_POST['Relation'][$key];
                $postdep['Gender'] = $_POST['Gender'][$key];
                $postdep['Birthdate'] = date('m/d/Y 00:00:00.000', strtotime($_POST['Birthdate'][$key]));
                $postdep['pwd'] = $_POST['pwd'][$key] ? 1 : 0;
                $postdep['SeqID'] = $_POST['SeqID'][$key] ? $_POST['SeqID'][$key] : 0;
                $postdep['DBNAME'] = $profile_dbname;

                //var_dump($postdep['Birthdate']);

                $sqldep = $logsql->update_dependent($postdep);
            endforeach;


			$post['OffUnitStreet'] = $_POST['OffUnitStreet'];
			$post['OffBarangay'] = $_POST['OffBarangay'];
			$post['OffTownCity'] = $_POST['OffTownCity'];
			$post['OffStateProvince'] = $_POST['OffStateProvince'];
			$post['OffZip'] = $_POST['OffZip'];
			$post['OffRegion'] = $_POST['OffRegion'];
			$post['OffCountry'] = $_POST['OffCountry'];

			$post['BloodType'] = $_POST['BloodType'];
			$post['MedHistory'] = $_POST['MedHistory'];
			$post['Medication'] = $_POST['Medication'];

            $sql = $logsql->update_member2($post);

            //AUDIT TRAIL
            //$log = $main->log_action("UPDATE_PROFILE", $add_user, $add_user);

            if ($sql) :
                echo '{"success": true}';
                exit();
            else :
				echo '{"success": false, "error": "error"}';
                exit();
            endif;

        endif;

        /*if ($_POST) :

            if ($_FILES["binFile"]["name"]) :
                $allowedExts = array("jpg", "jpeg", "gif");
                $temp = explode(".", $_FILES["binFile"]["name"]);
                $extension = end($temp);
                if (($_FILES["binFile"]["size"] < 102400) && in_array($extension, $allowedExts)) :
                    if ($_FILES["binFile"]["error"] > 0) :
                        echo '{"success":false,"error":"Error:'.$_FILES["binFile"]["error"].'"}';
                        exit();
                    else :

                        $image = $_FILES['binFile']['tmp_name'];
                        $fp = fopen($image, 'r');
                        $content = fread($fp, filesize($image));
                        $image_post['PICTURE'] = addslashes($content);
                        $image_post['EMPID'] = $_POST['empnum'];
                        $image_post['TRANS'] = 0;
                        fclose($fp);

                        $post['TRANS'] = 0;

                        $post['EmpID'] = $_POST['empnum'];

                        $post['EMPID'] = $_POST['empnum'];

                        $post['HireDate'] = $_POST['HireDate'];

                        $post['LName'] = $_POST['LName'];
                        $post['FName'] = $_POST['FName'];
                        $post['MName'] = $_POST['MName'];
                        $post['NickName'] = $_POST['NickName'];

                        $post['UnitStreet'] = $_POST['UnitStreet'];
                        $post['Barangay'] = $_POST['Barangay'];
                        $post['TownCity'] = $_POST['TownCity'];
                        $post['StateProvince'] = $_POST['StateProvince'];
                        $post['Zip'] = $_POST['Zip'];
                        $post['Region'] = '';
                        $post['Country'] = $_POST['Country'];

                        $post['BirthDate'] = $_POST['BirthDate'];
                        $post['BirthPlace'] = $_POST['BirthPlace'];
                        $post['Religion'] = $_POST['Religion'];
                        $post['Citizenship'] = $_POST['Citizenship'];
                        $post['Gender'] = $_POST['Gender'];

                        $post['HomeNumber'] = $_POST['HomeNumber'];
                        $post['MobileNumber'] = $_POST['MobileNumber'];
                        $post['OfficeNumber'] = $_POST['OfficeNumber'];
                        $post['OfficeExtNumber'] = $_POST['OfficeExtNumber'];
                        $post['EmailAdd'] = $_POST['EmailAdd'];
                        $post['EmailAdd2'] = $_POST['EmailAdd2'];

                        $post['SSSNbr'] = $_POST['SSSNbr'];
                        $post['TINNbr'] = $_POST['TINNbr'];
                        $post['PhilHealthNbr'] = $_POST['PhilHealthNbr'];
                        $post['PagibigNbr'] = $_POST['PagibigNbr'];

                        $post['Status'] = $_POST['Status'];
                        $post['ContactPerson'] = $_POST['ContactPerson'];
                        $post['ContactAddress'] = $_POST['ContactAddress'];
                        $post['ContactTelNbr'] = $_POST['ContactTelNbr'];
                        $post['ContactMobileNbr'] = $_POST['ContactMobileNbr'];

                        $post['Height'] = $_POST['Height'];
                        $post['Weight'] = $_POST['Weight'];
                        $post['BloodType'] = $_POST['BloodType'];
                        $post['SkinComplexion'] = $_POST['SkinComplexion'];

                        $family_post = array();
                        foreach ($_POST['FamRelation'] as $key => $value) :
                            if ($_POST['FamName'][$key]) :
                                $family_post[$key]['EMPID'] = $_POST['empnum'];
                                $family_post[$key]['TRANS'] = 0;
                                $family_post[$key]['NAME'] = $_POST['FamName'][$key];
                                $family_post[$key]['RELATION'] = $_POST['FamRelation'][$key];
                                $family_post[$key]['FAMBIRTHDATE'] = date('Y-m-d 00:00:00.000', strtotime($_POST['FamBirthDate'][$key]));
                                $family_post[$key]['FAMOCCUPATION'] = $_POST['FamOccupation'][$key];
                            endif;
                        endforeach;

                        $independent_post = array();
                        foreach ($_POST['DEPRELATION'] as $key => $value) :
                            if ($_POST['DEPRELATION'][$key]) :
                                $independent_post[$key]['EMPID'] = $_POST['empnum'];
                                $independent_post[$key]['TRANS'] = 0;
                                $independent_post[$key]['DEPENDENT'] = NULL;
                                $independent_post[$key]['DEPRELATION'] = NULL;
                                $independent_post[$key]['DEPADDRESS'] = NULL;
                                $independent_post[$key]['DEPTELNBR'] = NULL;
                                $independent_post[$key]['DEPMOBILENO'] = NULL;
                                $independent_post[$key]['DEPEMAILADD'] = NULL;
                                $independent_post[$key]['DEPGENDER'] = NULL;
                                $independent_post[$key]['DEPBIRTHDATE'] = NULL;
                                $independent_post[$key]['DEPPHILHEALTH'] = 0;
                                $independent_post[$key]['DEPTAX'] = 0;
                            endif;
                        endforeach;

                        $education_post = array();
                        foreach ($_POST['EducAttainment'] as $key => $value) :
                            if ($_POST['School'][$key]) :
                                $education_post[$key]['EMPID'] = $_POST['empnum'];
                                $education_post[$key]['TRANS'] = 0;
                                $education_post[$key]['EDUCATTAINMENT'] = $_POST['EducAttainment'][$key];
                                $education_post[$key]['SCHOOL'] = $_POST['School'][$key];
                                $education_post[$key]['COURSE'] = $_POST['Course'][$key];
                                $education_post[$key]['YEARGRADUATED'] = $_POST['YearGraduated'][$key];
                            endif;
                        endforeach;

                        $prevwork_post = array();
                        foreach ($_POST['PrevCompany'] as $key => $value) :
                            if ($_POST['PrevCompany'][$key]) :
                                $prevwork_post[$key]['EMPID'] = $_POST['empnum'];
                                $prevwork_post[$key]['TRANS'] = 0;
                                $prevwork_post[$key]['PREVCOMPANY'] = $_POST['PrevCompany'][$key];
                                $prevwork_post[$key]['PREVPOSITION'] = $_POST['PrevPosition'][$key];
                                $prevwork_post[$key]['DATESTARTED'] = $_POST['DateStarted'][$key];
                                $prevwork_post[$key]['DATERESIGNED'] = $_POST['DateResigned'][$key];
                            endif;
                        endforeach;


                        $org_post['EMPID'] = $_POST['empnum'];
                        $org_post['TRANS'] = 0;
                        $org_post['DEPTID'] = $_POST['DeptID'];
                        $org_post['POSITIONID'] = $_POST['PositionID'];

                        $sql = $register->update_member($post);
                        $sql2 = $register->update_family($family_post);
                        //$sql3 = $register->update_independent($independent_post, $post['eid']);
                        $sql4 = $register->update_education($education_post);
                        $sql5 = $register->update_prevwork($prevwork_post);
                        $sql6 = $register->update_org($org_post);
                        $sql7 = $register->update_picture($image_post);

                        //AUDIT TRAIL
                        //$log = $main->log_action("UPDATE_PROFILE", $add_user, $add_user);

                        if (!$sql2) :
                            echo '{"success":false,"error":"Family data is required"}';
                            exit();
                        elseif (!$sql4) :
                            echo '{"success":false,"error":"Education data is required"}';
                            exit();
                        elseif (!$sql5) :
                            echo '{"success":false,"error":"Previous work data is required"}';
                            exit();
                        elseif (!$sql6) :
                            echo '{"success":false,"error":"Position and department is required"}';
                            exit();
                        elseif ($sql1) :
                            echo '{"success":true}';
                            exit();
                        else :
                            echo '{"success":false,"error":"Error in update"}';
                            exit();
                        endif;

                    endif;
                else :
                    echo '{"success":false,"error":"Invalid file"}';
                    exit();
                endif;

            else :

                $post['TRANS'] = 0;

                $post['EmpID'] = $_POST['empnum'];

                $post['EMPID'] = $_POST['empnum'];

                $post['LName'] = $_POST['LName'];
                $post['FName'] = $_POST['FName'];
                $post['MName'] = $_POST['MName'];
                $post['NickName'] = $_POST['NickName'];

                $post['UnitStreet'] = $_POST['UnitStreet'];
                $post['Barangay'] = $_POST['Barangay'];
                $post['TownCity'] = $_POST['TownCity'];
                $post['StateProvince'] = $_POST['StateProvince'];
                $post['Zip'] = $_POST['Zip'];
                $post['Region'] = '';
                $post['Country'] = $_POST['Country'];

                $post['BirthDate'] = $_POST['BirthDate'];
                $post['BirthPlace'] = $_POST['BirthPlace'];
                $post['Religion'] = $_POST['Religion'];
                $post['Citizenship'] = $_POST['Citizenship'];
                $post['Gender'] = $_POST['Gender'];

                $post['HomeNumber'] = $_POST['HomeNumber'];
                $post['MobileNumber'] = $_POST['MobileNumber'];
                $post['OfficeNumber'] = $_POST['OfficeNumber'];
                $post['OfficeExtNumber'] = $_POST['OfficeExtNumber'];
                $post['EmailAdd'] = $_POST['EmailAdd'];
                $post['EmailAdd2'] = $_POST['EmailAdd2'];

                $post['SSSNbr'] = $_POST['SSSNbr'];
                $post['TINNbr'] = $_POST['TINNbr'];
                $post['PhilHealthNbr'] = $_POST['PhilHealthNbr'];
                $post['PagibigNbr'] = $_POST['PagibigNbr'];

                $post['Status'] = $_POST['Status'];
                $post['ContactPerson'] = $_POST['ContactPerson'];
                $post['ContactAddress'] = $_POST['ContactAddress'];
                $post['ContactTelNbr'] = $_POST['ContactTelNbr'];
                $post['ContactMobileNbr'] = $_POST['ContactMobileNbr'];

                $post['Height'] = $_POST['Height'];
                $post['Weight'] = $_POST['Weight'];
                $post['BloodType'] = $_POST['BloodType'];
                $post['SkinComplexion'] = $_POST['SkinComplexion'];

                $family_post = array();
                foreach ($_POST['FamRelation'] as $key => $value) :
                    if (trim($_POST['FamName'][$key])) :
                        $family_post[$key]['EMPID'] = $_POST['empnum'];
                        $family_post[$key]['TRANS'] = 0;
                        $family_post[$key]['NAME'] = $_POST['FamName'][$key];
                        $family_post[$key]['RELATION'] = $_POST['FamRelation'][$key];
                        $family_post[$key]['FAMBIRTHDATE'] = date('Y-m-d 00:00:00.000', strtotime($_POST['FamBirthDate'][$key]));
                        $family_post[$key]['FAMOCCUPATION'] = $_POST['FamOccupation'][$key];
                    endif;
                endforeach;

                $independent_post = array();
                foreach ($_POST['DEPRELATION'] as $key => $value) :
                    if ($_POST['DEPRELATION'][$key]) :
                        $independent_post[$key]['EMPID'] = $_POST['empnum'];
                        $independent_post[$key]['TRANS'] = 0;
                        $independent_post[$key]['DEPENDENT'] = NULL;
                        $independent_post[$key]['DEPRELATION'] = NULL;
                        $independent_post[$key]['DEPADDRESS'] = NULL;
                        $independent_post[$key]['DEPTELNBR'] = NULL;
                        $independent_post[$key]['DEPMOBILENO'] = NULL;
                        $independent_post[$key]['DEPEMAILADD'] = NULL;
                        $independent_post[$key]['DEPGENDER'] = NULL;
                        $independent_post[$key]['DEPBIRTHDATE'] = NULL;
                        $independent_post[$key]['DEPPHILHEALTH'] = 0;
                        $independent_post[$key]['DEPTAX'] = 0;
                    endif;
                endforeach;

                $education_post = array();
                foreach ($_POST['EducAttainment'] as $key => $value) :
                    if ($_POST['School'][$key]) :
                        $education_post[$key]['EMPID'] = $_POST['empnum'];
                        $education_post[$key]['TRANS'] = 0;
                        $education_post[$key]['EDUCATTAINMENT'] = $_POST['EducAttainment'][$key];
                        $education_post[$key]['SCHOOL'] = $_POST['School'][$key];
                        $education_post[$key]['COURSE'] = $_POST['Course'][$key];
                        $education_post[$key]['YEARGRADUATED'] = $_POST['YearGraduated'][$key];
                    endif;
                endforeach;

                $prevwork_post = array();
                foreach ($_POST['PrevCompany'] as $key => $value) :
                    if ($_POST['PrevCompany'][$key]) :
                        $prevwork_post[$key]['EMPID'] = $_POST['empnum'];
                        $prevwork_post[$key]['TRANS'] = 0;
                        $prevwork_post[$key]['PREVCOMPANY'] = $_POST['PrevCompany'][$key];
                        $prevwork_post[$key]['PREVPOSITION'] = $_POST['PrevPosition'][$key];
                        $prevwork_post[$key]['DATESTARTED'] = $_POST['DateStarted'][$key];
                        $prevwork_post[$key]['DATERESIGNED'] = $_POST['DateResigned'][$key];
                    endif;
                endforeach;

                $org_post['EMPID'] = $_POST['empnum'];
                $org_post['TRANS'] = 0;
                $org_post['DEPTID'] = $_POST['DeptID'];
                $org_post['POSITIONID'] = $_POST['PositionID'];

                $sql = $register->update_member($post);
                $sql2 = $register->update_family($family_post);
                //$sql3 = $register->update_independent($independent_post);
                $sql4 = $register->update_education($education_post);
                $sql5 = $register->update_prevwork($prevwork_post);
                $sql6 = $register->update_org($org_post);

                //AUDIT TRAIL
                //$log = $main->log_action("UPDATE_PROFILE", $add_user, $add_user);

                if (!$sql2) :
                    echo '{"success":false,"error":"Family data is required"}';
                    exit();
                elseif (!$sql4) :
                    echo '{"success":false,"error":"Education data is required"}';
                    exit();
                elseif (!$sql5) :
                    echo '{"success":false,"error":"Previous work data is required"}';
                    exit();
                elseif (!$sql6) :
                    echo '{"success":false,"error":"Position and department is required"}';
                    exit();
                elseif ($sql) :
                    echo '{"success":true}';
                    exit();
                else :
                    echo '{"success":false,"error":"Error in update"}';
                    exit();
                endif;

            endif;

        endif;*/

        $emp_data = $register->get_member_by_hash2($empid);
        $family_data = $register->get_family_data($emp_data[0]['EmpID']);
        $education_data = $register->get_education_data($emp_data[0]['EmpID']);
        $training_data = $register->get_training_data($emp_data[0]['EmpID']);
        $skill_data = $register->get_skill_data($emp_data[0]['EmpID']);
        $prevwork_data = $register->get_prevwork_data($emp_data[0]['EmpID']);
        $pix_data = $mainsql->get_image(1, $emp_data[0]['EmpID']);

        $posi_sel = $mainsql->get_posi_data();
        $dept_sel = $mainsql->get_dept_data();

        $dependent_data = $mainsql->get_dep_data($emp_data[0]['EmpID'], $profile_dbname);
        $count_dep = count($dependent_data);
        //var_dump($dependent_data);

	else :

        echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."'</script>";

	endif;

?>
