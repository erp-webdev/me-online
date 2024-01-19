	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->

                    <div id="mainsplashtext" class="mainsplashtext lefttalign">
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">

                            <?php foreach ($emp_data as $emp_data) : ?>

                            <div id="uprofile3" class="div9">

                                <form name="formpro" method="post" enctype="multipart/form-data">
                                    <div id="main" style="width: 100%; height: auto; margin-top: 50px;">
                                    <div id="tabs">

                                        <br /><b>Personal Data</b>
                                        <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Full Name: <b><?php echo $emp_data['FName'].' '.$emp_data['MName'].' '.$emp_data['LName']; ?></b></td>
                                            </tr>
                                        </table><br>
                                        <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                                            <tr>
                                                <td><span class="lorangetext">*</span> Nickname<br><input attribute="Nickname" type="text" name="NickName" size="20" width="255" id="NickName" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['NickName']; ?>"></td>
                                            </tr>
                                        </table><br>
                                        <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                                            <tr>
                                                <td><span class="lorangetext">*</span> Gender<br>
                                                <select name="EGender" id="EGender" class="txtbox" style="width: 165px;">
                                                    <option value="F"<?php echo ($emp_data['Gender'] == 'F' || $emp_data['Gender'] == 'FEMALE') ? ' selected' : ''; ?>>FEMALE</option>
                                                    <option value="M"<?php echo ($emp_data['Gender'] == 'M' || $emp_data['Gender'] == 'MALE') ? ' selected' : ''; ?>>MALE</option>
                                                </select>
                                                </td>
                                                <td><span class="lorangetext">*</span> Nationality<br/>
                                                <select name="Citizenship" id="Citizenship" class="txtbox">
                                                    <?php foreach($nationality as $key => $value) : ?>
                                                    <option value="<?php echo $value; ?>" <?php echo $emp_data['Citizenship'] == $value ? "selected" : ""; ?>><?php echo $value; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                </td>
                                            </tr>
                                        </table><br>
                                        <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                                            <tr>
                                                <td>Telephone<br><input attribute="Telephone" type="text" name="HomeNumber" size="20" id="HomeNumber" class="txtbox" value="<?php echo $emp_data['HomeNumber']; ?>"></td>
                                                <td><span class="lorangetext">*</span> Mobile No.<br/><input attribute="Mobile No." type="text" name="MobileNumber" size="20" id="MobileNumber" class="txtbox" value="<?php echo $emp_data['MobileNumber']; ?>"></td>
                                            </tr>
                                        </table><br>
                                        <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                                            <tr>
                                                <td><span class="lorangetext">*</span> Birthdate<br><input attribute="Birthdate" type="text" name="BirthDate" size="20" id="BirthDate" class="txtbox datepickchild" value="<?php echo date('Y-m-d', strtotime($emp_data['BirthDate'])); ?>"></td>
                                                <td><span class="lorangetext">*</span> Birthplace<br/><input attribute="Birthplace" type="text" name="BirthPlace" size="20" id="BirthPlace" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['BirthPlace']; ?>"></td>
                                            </tr>
                                        </table><br>
                                        <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                                            <tr>
                                                <td><span class="lorangetext">*</span>  Personal E-mail<br><input attribute="Personal E-mail" type="text" name="EmailAdd2" size="20" id="EmailAdd2" class="txtbox" value="<?php echo $emp_data['EmailAdd2']; ?>"></td>
                                                <td><span class="lorangetext">*</span> Corporate E-mail<br/><input attribute="Corporate E-mail" type="text" name="EmailAdd" size="20" id="EmailAdd" class="txtbox" value="<?php echo $emp_data['EmailAdd']; ?>"></td>
                                            </tr>
                                        </table><br>
										<table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
											<tr>
												<td><span class="lorangetext">*</span> BloodType<br/>
													<select name="BloodType" id="BloodType" class="txtbox" style="width: 165px;">
														<option value="" <?php echo $emp_data['BloodType'] ? "selected" : ""; ?>>Select...</option>
														<option value="A+" <?php echo $emp_data['BloodType'] ==  'A+'? "selected" : ""; ?>>A+</option>
														<option value="A-" <?php echo $emp_data['BloodType'] ==  'A-'? "selected" : ""; ?>>A-</option>
														<option value="B+" <?php echo $emp_data['BloodType'] ==  'B+'? "selected" : ""; ?>>B+</option>
														<option value="B-" <?php echo $emp_data['BloodType'] ==  'B-'? "selected" : ""; ?>>B-</option>
														<option value="O+" <?php echo $emp_data['BloodType'] ==  'O+'? "selected" : ""; ?>>O+</option>
														<option value="O-" <?php echo $emp_data['BloodType'] ==  'O-'? "selected" : ""; ?>>O-</option>
														<option value="AB+" <?php echo $emp_data['BloodType'] ==  'AB+'? "selected" : ""; ?>>AB+</option>
														<option value="AB-" <?php echo $emp_data['BloodType'] ==  'AB-'? "selected" : ""; ?>>AB-</option>
													</select>
												</td>
											</tr>
										</table><br>
                                        <table cellpadding="0" cellspacing="0" class="tdataform2" style="width: 100%;">

											<tr>
												<td>
													<table border="0" cellpadding="5" cellspacing="0" class="tdataform" style="width: 100%;">
														<tr>
															<td colspan="4">Office Address:</td>
														</tr>
														<tr>
															<td colspan="2">
																<input attribute="Unit/Street" type="text" name="OffUnitStreet" size="30" id="OffUnitStreet" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['OffUnitStreet']; ?>"><br><span style="font-size: 10px;"><span class="lorangetext">*</span>  Unit/Street</span>
															</td>
															<td>
																<input attribute="Barangay" type="text" name="OffBarangay" size="25" id="OffBarangay" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['OffBarangay']; ?>"><br><span style="font-size: 10px;"><span class="lorangetext">*</span>  Barangay/Subdivision</span>
															</td>
															<td>
																<input attribute="City" type="text" name="OffTownCity" size="30" id="OffTownCity" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['OffTownCity']; ?>"><br><span style="font-size: 10px;"><span class="lorangetext">*</span>  City</span>
															</td>
														</tr>
														<tr>
															<td colspan="2">
																<input attribute="Province" type="text" name="OffStateProvince" size="30" id="OffStateProvince" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['OffStateProvince']; ?>"><br><span style="font-size: 10px;"><span class="lorangetext">*</span>  Province</span>
															</td>
															<td>
																<input type="text" name="OffZip" size="10" id="OffZip" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['OffZip'] ? $emp_data['OffZip'] : "1000"; ?>"><br><span style="font-size: 10px;"><span class="lorangetext">*</span>  ZIP Code</span>
															</td>
															<td>
																<select name="OffRegion" id="OffRegion" class="txtbox" style="width: 200px;">
																	<option value="" <?php echo $emp_data['OffRegion'] ? "selected" : ""; ?>>Select...</option>
																	<?php foreach($regions as $key => $value) : ?>
																	<option value="<?php echo $value; ?>" <?php echo $emp_data['OffRegion'] == $value ? "selected" : ""; ?>><?php echo $value; ?></option>
																	<?php endforeach; ?>
																</select><br><span style="font-size: 10px;"><span class="lorangetext">*</span>  Region</span>
															</td>
														</tr>
														<tr>
															<td>
																<select name="OffCountry" id="OffCountry" class="txtbox" style="width: 200px;">
																	<option value="" <?php echo $emp_data['OffCountry'] ? "selected" : ""; ?>>Select...</option>
																	<?php foreach($countries as $key => $value) : ?>
																	<option value="<?php echo $value; ?>" <?php echo $emp_data['OffCountry'] == $value ? "selected" : ""; ?>><?php echo $value; ?></option>
																	<?php endforeach; ?>
																</select><br><span style="font-size: 10px;"><span class="lorangetext">*</span>  Country</span>
															</td>
														</tr>
													</table>
												</td>
											</tr>


                                            <tr>
                                                <td>
                                                    <table border="0" cellpadding="5" cellspacing="0" class="tdataform" style="width: 100%;">
                                                        <tr>
                                                            <td colspan="4">Present Address:</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <input attribute="Unit/Street" type="text" name="UnitStreet" size="30" id="UnitStreet" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['UnitStreet']; ?>"><br><span style="font-size: 10px;"><span class="lorangetext">*</span>  Unit/Street</span>
                                                            </td>
                                                            <td>
                                                                <input attribute="Barangay" type="text" name="Barangay" size="25" id="Barangay" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['Barangay']; ?>"><br><span style="font-size: 10px;"><span class="lorangetext">*</span>  Barangay/Subdivision</span>
                                                            </td>
                                                            <td>
                                                                <input attribute="City" type="text" name="TownCity" size="30" id="TownCity" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['TownCity']; ?>"><br><span style="font-size: 10px;"><span class="lorangetext">*</span>  City</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <input attribute="Province" type="text" name="StateProvince" size="30" id="StateProvince" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['StateProvince']; ?>"><br><span style="font-size: 10px;"><span class="lorangetext">*</span>  Province</span>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="Zip" size="10" id="Zip" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['Zip'] ? $emp_data['Zip'] : "1000"; ?>"><br><span style="font-size: 10px;"><span class="lorangetext">*</span>  ZIP Code</span>
                                                            </td>
                                                            <td>
                                                                <select name="Country" id="Country" class="txtbox" style="width: 200px;">
                                                                    <option value="" <?php echo $emp_data['Country'] ? "selected" : ""; ?>>Select...</option>
                                                                    <?php foreach($countries as $key => $value) : ?>
                                                                    <option value="<?php echo $value; ?>" <?php echo $emp_data['Country'] == $value ? "selected" : ""; ?>><?php echo $value; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select><br><span style="font-size: 10px;"><span class="lorangetext">*</span>  Country</span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table border="0" cellpadding="5" cellspacing="0" class="tdataform" style="width: 100%;">
                                                        <tr>
                                                            <td colspan="4">Permanent Address:</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <input attribute="Unit/Street" type="text" name="PermUnitStreet" size="30" id="PermUnitStreet" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['PermUnitStreet']; ?>"><br><span style="font-size: 10px;"><span class="lorangetext">*</span>  Unit/Street</span>
                                                            </td>
                                                            <td>
                                                                <input attribute="Barangay" type="text" name="PermBarangay" size="25" id="PermBarangay" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['PermBarangay']; ?>"><br><span style="font-size: 10px;"><span class="lorangetext">*</span>  Barangay/Subdivision</span>
                                                            </td>
                                                            <td>
                                                                <input attribute="City" type="text" name="PermTownCity" size="30" id="PermTownCity" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['PermTownCity']; ?>"><br><span style="font-size: 10px;"><span class="lorangetext">*</span>  City</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <input attribute="Province" type="text" name="PermStateProvince" size="30" id="PermStateProvince" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['PermStateProvince']; ?>"><br><span style="font-size: 10px;"><span class="lorangetext">*</span>  Province</span>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="PermZip" size="10" id="PermZip" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['PermZip'] ? $emp_data['PermZip'] : "1000"; ?>"><br><span style="font-size: 10px;"><span class="lorangetext">*</span>  ZIP Code</span>
                                                            </td>
                                                            <td>
                                                                &nbsp;
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input id="chksameadd" type="checkbox" name="chksameadd"<?php echo ($emp_data['UnitStreet'] == $emp_data['PermUnitStreet']) ? ' checked' : ''; ?>/> <label for="chksameadd">same as present address</label>
                                                </td>
                                            </tr>
                                        </table><br />
                                        <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                                            <tr>
                                                <td><span class="lorangetext">*</span> Mother's Maiden Name<br><input attribute="Mother's Maiden Name" type="text" name="MotherMaiden" size="20" id="MotherMaiden" class="txtbox" value="<?php echo $emp_data['MotherMaiden']; ?>"></td>
                                            </tr>
                                        </table><br>
                                        <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                                            <tr>
                                                <td><span class="lorangetext">*</span> Spouse Name<br><input attribute="Spouse Name" type="text" name="SpouseName" size="20" id="SpouseName" class="txtbox" value="<?php echo $emp_data['SpouseName']; ?>"></td>
                                                <td>Spouse Occupation<br/><input attribute="Spouse Occupation" type="text" name="SpouseOccupation" size="20" id="SpouseOccupation" class="txtbox" value="<?php echo $emp_data['SpouseOccupation']; ?>"></td>
                                            </tr>
                                        </table><br>
                                        <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                                            <tr>
                                                <td>Source of Income<br><input attribute="Source of Income" type="text" name="IncomeSource" size="30" id="IncomeSource" class="txtbox" value="EMPLOYMENT" readonly></td>
                                                <td><span class="lorangetext">*</span> Other Source of Income<br><input attribute="Other Source of Income" type="text" name="OtherIncomeSource" size="30" id="OtherIncomeSource" class="txtbox" value="<?php echo $emp_data['OtherIncomeSource']; ?>"></td>
                                            </tr>
                                        </table><br>
                                        <br /><b>Government Dependent/s</b>
                                        <input id="uempid" type="hidden" value="<?php echo $emp_data['EmpID']; ?>">
                                        <input id="udbname" type="hidden" value="<?php echo $emp_data['DBNAME']; ?>">
                                        <div id="udivdependent">
                                            <?php if ($dependent_data) :
                                                $idep = 0; ?>
                                                <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                                                    <?php foreach ($dependent_data as $key => $value) :
                                                        ?>
                                                        <tr>
                                                            <td><span class="lorangetext">*</span> Name<br><input attribute="Dependent Name" type="text" name="Dependent[<?php echo $idep; ?>]" size="30" id="Dependent<?php echo $idep; ?>" onChange="upperCase(this)" value="<?php echo $value['Dependent']; ?>" class="txtbox"></td>
                                                            <td>Gender <br>
                                                                <select attribute="Dependent Gender" type="text" name="Gender[<?php echo $idep; ?>]" id="Gender<?php echo $idep; ?>" onChange="upperCase(this)" class="txtbox">
                                                                    <option value="F"<?php echo $value['Gender'] == 'F' ? ' selected' : ''; ?>>F</option>
                                                                    <option value="M"<?php echo $value['Gender'] == 'M' ? ' selected' : ''; ?>>M</option>
                                                                </select>
                                                            </td>
															<td>Relationship <br>
																<!-- <input attribute="Dependent Relation" type="text" name="Relation[<?php //echo $idep; ?>]" size="20" id="Relation<?php //echo $idep; ?>" onChange="upperCase(this)" value="<?php //echo $value['Relation']; ?>" class="txtbox"></td> -->
																<select attribute="Dependent Relation" type="text" name="Relation[<?php echo $idep; ?>]" id="Relation<?php echo $idep; ?>" onChange="upperCase(this)" class="txtbox">
																	<option value="" selected>Select...</option>
																	<option value="FATHER"<?php echo $value['Relation'] == 'FATHER' ? ' selected' : ''; ?>>FATHER</option>
																	<option value="MOTHER"<?php echo $value['Relation'] == 'MOTHER' ? ' selected' : ''; ?>>MOTHER</option>
																	<option value="CHILD"<?php echo $value['Relation'] == 'CHILD' ? ' selected' : ''; ?>>CHILD</option>
																</select>
															</td>
															<td>Birthdate <br><input attribute="Dependent Birthdate" type="text" name="Birthdate[<?php echo $idep; ?>]" size="15" id="Birthdate<?php echo $idep; ?>" value="<?php echo date('Y-m-d', strtotime($value['Birthdate'])); ?>" class="datepick2 txtbox" readonly></td>
                                                            <td>PWD <br><input attribute="Dependent PWD" type="checkbox" name="pwd[<?php echo $idep; ?>]" size="15" id="pwd<?php echo $idep; ?>" value="1"<?php echo $value['pwd'] ? ' checked' : ''; ?>>
                                                            <input type="hidden" name="SeqID[<?php echo $idep; ?>]" id="SeqID<?php echo $idep; ?>" value="<?php echo $value['SeqID']; ?>"></td>
                                                            <td><?php echo !$value['SeqID'] ? '<span attribute="'.$value['DepID'].'" attribute2="'.$empid.'" class="deldept fa fa-times redtext cursorpoint"></span>' : ''; ?></td>
                                                        </tr>
                                                        <?php
                                                        $idep++;
                                                    endforeach; ?>
                                                </table>
                                            <?php endif; ?>
                                        </div>
                                        <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                        <br /><b>Person to Notify in Case of Emergency</b>
                                        <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                                            <tr>
                                                <td colspan="2"><span class="lorangetext">*</span>  In case of emergency, notify Mr. Ms. <br><input attribute="Contact Name to Notify" type="text" name="ContactPerson" size="40" id="ContactPerson" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['ContactPerson']; ?>"></td>
                                                <td>Home No <br><input attribute="Home Number to Notify" type="text" name="ContactTelNbr" size="15" id="ContactTelNbr" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['ContactTelNbr']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><span class="lorangetext">*</span>  Address <br><input attribute="Contact Address to Notify" type="text" name="ContactAddress" size="60" id="ContactAddress" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['ContactAddress']; ?>"></td>
                                                <td><span class="lorangetext">*</span>  Mobile No <br><input attribute="Mobile Number to Notify" type="text" name="ContactMobileNbr" size="15" id="ContactMobileNbr" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['ContactMobileNbr']; ?>"></td>
                                            </tr>
											<tr>
												<td colspan="4"><br/>
													Medical History<br/>
													<p style="text-indent: 10px">1. Have you been hospitalized or was diagnosed with a disease within the last 5 years?</p>
													<p style="text-indent: 50px">a. Name of disease (diagnosis)</p>
													<p style="text-indent: 50px">b. Surgery procedure done if there is any</p>
													<textarea rows="4" style="width: 100%; height: 50%;" name="MedHistory" id="MedHistory" class="txtbox" value="<?php echo $emp_data['MedHistory']; ?>"><?php echo $emp_data['MedHistory']; ?></textarea>
													<p style="text-indent: 10px">2. List of Maintenance Medications</p>
													<textarea rows="4" style="width: 100%; height: 50%;" name="Medication" id="Medication" class="txtbox" value="<?php echo $emp_data['Medication']; ?>"><?php echo $emp_data['Medication']; ?></textarea>
												</td>
											</tr>
                                        </table>
                                        <br>
                                        <div id="lasttable"></div>

                                        <div align="center">
                                            <input type="hidden" name="empnum" id="empnum" value="<?php echo $emp_data['EmpID']; ?>" />
                                            <input type="hidden" name="dbname" id="dbname" value="<?php echo $emp_data['DBNAME']; ?>" />

                                            <input type="submit" class="btn" value="Approve">&nbsp;<a href="<?php echo WEB; ?>/empupdate"><input id="btnempreject" type="button" name="btnempreject" class="redbtn" value="Back"></a>
                                        </div>

                                    </div>
                                    </div>
                                </form>
                            </div>


                            <?php endforeach; ?>
                        </div>
                    </div>

    <?php include(TEMP."/footer.php"); ?>
