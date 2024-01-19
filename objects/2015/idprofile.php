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

                $post['TRANS'] = 1;
                $post['DBNAME'] = $_POST['dbname'];

                $post['EmpID'] = $_POST['empnum'];

                $post['EMPID'] = $_POST['empnum'];

                $post['LName'] = $_POST['LName'];
                $post['FName'] = $_POST['FName'];
                $post['MName'] = $_POST['MName'];
                $post['NickName'] = $_POST['NickName'];

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

                if (!$_POST['NickName'] || !$_POST['EmailAdd'] || !$_POST['EmailAdd2'] || !$_POST['UnitStreet'] || !$_POST['Barangay'] || !$_POST['TownCity'] || !$_POST['StateProvince'] || !$_POST['Zip'] || !$_POST['PermUnitStreet'] || !$_POST['PermBarangay'] || !$_POST['PermTownCity'] || !$_POST['PermStateProvince'] || !$_POST['PermZip'] || !$_POST['MobileNumber'] || !$_POST['BirthDate'] || !$_POST['BirthPlace'] || !$_POST['MotherMaiden'] || !$_POST['ContactPerson'] || !$_POST['ContactAddress'] || !$_POST['ContactMobileNbr']) :
                    echo '{"success": false, "error": "All fields with * are required"}';
                    exit();
                endif;

                $sqldeldep = $logsql->del_dependent($_POST['uempid'], 0, $_POST['udbname']);
                $usqlerror = 0;

                foreach ($_POST['Dependent'] as $key => $value) :
                    $postdep['EmpID'] = $_POST['empnum'];
                    $postdep['Dependent'] = $value;
                    $postdep['Relation'] = $_POST['Relation'][$key];
                    $postdep['Gender'] = $_POST['Gender'][$key];
                    $postdep['Birthdate'] = date('m/d/Y 00:00:00.000', strtotime($_POST['Birthdate'][$key]));
                    $postdep['pwd'] = $_POST['pwd'][$key] ? 1 : 0;
                    $postdep['SeqID'] = $_POST['SeqID'][$key];
                    $postdep['DBNAME'] = $profile_dbname;

                    if ($_POST['SeqID'][$key] != 0) :
                        $usqldep = $register->update_fdependent($postdep);
                    else :
                        $usqldep = $register->insert_fdependent($postdep);
                    endif;

                    if (!$usqldep) :
                        $usqlerror++;
                    endif;
                endforeach;

                if (!$usqlerror) :
                    $sql = $register->update_member2($post);
                else :
                    $sql = 0;
                endif;

                //AUDIT TRAIL
                //$log = $main->log_action("UPDATE_PROFILE", $add_user, $add_user);

                if ($sql) :
                    echo '{"success": true}';
                    exit();
                else :
                    echo '{"success": false, "error": "Error in update"}';
                    exit();
                endif;

            endif;

            $emp_data = $logsql->get_upmember_by_hash($empid);

            $dependent_data = $logsql->get_depdata_by_hash($empid);

	else :

        echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."'</script>";

	endif;

?>
