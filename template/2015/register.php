	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->
    
            <div id="lowerlist" class="lowerlist solidbottom">
                <div id="regis" class="div9">                    
                    
                    <form name="formreg" method="post" enctype="multipart/form-data">
                        <?php if ($empid) : ?>
                            <input type="hidden" name="eid" value="<?php echo $data_array['emp_id']; ?>" />
                            <input type="hidden" name="emphash" value="<?php echo $empid; ?>" />
                        <?php endif ?>
                        <div id="main" style="width: 100%; height: auto;">
                        <div id="tabs">
                            
                            <div class="regup"><a href="<?php echo WEB; ?>"><input type="button" value="Back" class="btn" /></a></div>
                                        
                            <div id="ridpic" class="ridpic" >
                                
                                <span class="redtext">*</span> Upload your ID picture<br><input id="binFile" name="binFile" size="10" type="file" value="<?php echo $data_array['emp_resumefilename']; ?>" class="txtbox" style="width: 150px !important;"/><font size="-2"><b><br>(.gif/jpg and 100Kb only<br>1:1 ratio)</b></font>
                            </div>
                                
                            <b style="font-size:9px;">PRIVATE & CONFIDENTIAL</b><BR>
                            <div style="font-size: 9px;">(<span class="redtext">*</span>) Field are required, please put <b>n/a</b> if not applicable</div>
                        
                            <br />
                                
                            <table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">
                                <tr>
                                    <td width="20%"><span class="redtext">*</span> <?php echo ucfirst($profile_nadd); ?> No.: <input attribute="<?php echo ucfirst($profile_nadd); ?> Number" type="text" name="empnum" size="6" id="empnum" onChange="upperCase(this); checkID(this);" class="txtbox" value="<?php echo $data_array['emp_idnum']; ?>" /><div id="checkIDerr" style="text-align: center; color: #F00;"></div></td>
                                    <td width="55%"><span class="redtext">*</span> Position: 
                                        <?php if ($position_sel) : ?>
                                        <select attribute="Position" name="position" id="position" class="txtbox" style="width: 200px;" onChange="positionChk(this); updatePos(this);" />
                                            <option value="0" <?php echo $data_array['emp_position'] == 0 ? "selected" : ""; ?>>Select...</option>
                                            <?php                                                 
                                                foreach ($position_sel as $key => $value) :
                                                ?>
                                                    <option value="<?php echo $value['position_id']; ?>" <?php echo $data_array['emp_position'] == $value['position_id'] ? "selected" : ""; ?>><?php echo $value['position_description']; ?></option>
                                                <?php    
                                                endforeach;    
                                            ?>                      
                                            <option value="1000000">OTHER...</option>
                                        </select>
                                        <?php endif; ?>
                                        <div id="divotherpos" style="display: none;"><input type="text" name="otherpos" size="20" id="otherpos" class="txtbox"  onChange="upperCase(this); updatePos2(this);"></div>
                                    </td>
                                    <td width="25%"><span class="redtext">*</span> Date Hired: <input type="text" name="datehired" size="10" id="datehired" class="datepick2 txtbox" value="<?php if  ($data_array['emp_datehired'] != '0000-00-00' && $data_array['emp_datehired'] != NULL) : echo $data_array['emp_datehired']; else : echo date("Y-m-d"); endif; ?>" maxlength="10" onChange="updateHired(this);"></td>
                                </tr>
                            </table>
                            <br /><b>Personal Data</b>
                            <table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">
                                <tr>
                                    <td width="25%"><span class="redtext">*</span> Last Name<br><input attribute="Last Name" type="text" name="lastname" size="25" width="255" id="lastname" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_lastname']; ?>"></td>
                                    <td width="25%"><span class="redtext">*</span> First Name<br><input attribute="First Name" type="text" name="firstname" size="25" width="255" id="firstname" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_firstname']; ?>"></td>
                                    <td width="25%"><span class="redtext">*</span> Middle Name<br><input attribute="Middle Name" type="text" name="middlename" size="25" width="255" id="middlename" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_middlename']; ?>"></td>
                                    <td width="5%">Suffix<br>
                                        <select attribute="Suffix" type="text" name="suffixname" width="60" id="suffixname" class="txtbox">
                                            <option value="" <?php echo $emp_data['emp_suffixname'] == "" ? "selected" : ""; ?>></option>
                                            <option value="SR" <?php echo $data_array['emp_suffixname'] == "SR" ? "selected" : ""; ?>>SR</option>
                                            <option value="JR" <?php echo $data_array['emp_suffixname'] == "JR" ? "selected" : ""; ?>>JR</option>
                                            <option value="II" <?php echo $data_array['emp_suffixname'] == "II" ? "selected" : ""; ?>>II</option>
                                            <option value="III" <?php echo $data_array['emp_suffixname'] == "III" ? "selected" : ""; ?>>III</option>
                                        </select>
                                    </td>
                                    <td width="20%"><span class="redtext">*</span> Nickname<br><input attribute="Nickname" type="text" name="nickname" size="20" width="255" id="nickname" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_nickname']; ?>"></td>
                                </tr>
                            </table><br>
                            <table border="1" cellpadding="0" cellspacing="0" style="width: 100%;">
                                <tr>
                                    <td>
                                        <table border="0" cellpadding="5" cellspacing="0" style="width: 100%;">
                                            <tr>
                                                <td colspan="4">Present Address:</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input attribute="Address Number" type="text" name="address_num" size="10" id="address_num" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_addressnum']; ?>"><br><span style="font-size: 10px;"><span class="redtext">*</span> Number</span>
                                                </td>
                                                <td>
                                                    <input attribute="Street Address" type="text" name="address_street" size="35" id="address_street" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_addressstreet']; ?>"><br><span style="font-size: 10px;"><span class="redtext">*</span> Street</span>
                                                </td>
                                                <td>
                                                    <input attribute="Barangay" type="text" name="address_brgy" size="25" id="address_brgy" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_addressbrgy']; ?>"><br><span style="font-size: 10px;"><span class="redtext">*</span> Barangay/Subdivision</span>
                                                </td>
                                                <td>
                                                    <input attribute="City" type="text" name="address_city" size="30" id="address_city" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_addresscity']; ?>"><br><span style="font-size: 10px;"><span class="redtext">*</span> City</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <input attribute="Region" type="text" name="address_region" size="30" id="address_region" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_addressregion']; ?>"><br><span style="font-size: 10px;"><span class="redtext">*</span> Region</span>
                                                </td>
                                                <td>
                                                    <input type="text" name="address_zip" size="10" id="address_zip" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_addresszip'] ? $data_array['emp_addresszip'] : "1000"; ?>"><br><span style="font-size: 10px;"><span class="redtext">*</span> ZIP Code</span>
                                                </td>
                                                <td>
                                                    <?php $countries = array("Philippines", "Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe"); ?>                                    
                                                    <select name="address_country" id="address_country" class="txtbox" style="width: 200px;">
                                                        <option value="0" <?php echo $data_array['emp_addresscountry'] == 0 ? "selected" : ""; ?>>Select...</option>
                                                        <?php foreach($countries as $value) : ?>
                                                        <option value="<?php echo $value; ?>" <?php echo $data_array['emp_addresscountry'] == $value ? "selected" : ""; ?>><?php echo $value; ?></option>
                                                        <?php endforeach; ?>
                                                    </select><br><span style="font-size: 10px;"><span class="redtext">*</span> Country</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>  
                                </tr>
                            </table><br>
                            <table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">
                                <tr>
                                    <td colspan="2"><span class="redtext">*</span> Provicial Address: <input attribute="Provincial Address" type="text" name="provincial_address" size="60" id="provincial_address" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_address2']; ?>"></td>
                                    <td><span class="redtext">*</span> Contact No.<input attribute="Contact Number" type="text" name="contact" size="20" id="contact" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_contact']; ?>"></td>
                                    <td><span class="redtext">*</span> E-mail<input attribute="E-mail Address" type="text" name="email" size="20" id="email" onChange="checkemail()" class="txtbox" value="<?php echo $data_array['emp_email']; ?>"></td>
                                </tr>
                                <tr>
                                    <td><span class="redtext">*</span> Date of Birth <b><font size="-2">(yyyy-mm-dd)</font></b>
                                        <br><input type="text" name="birthday" size="10" id="birthday" class="datepick txtbox" value="<?php if  ($data_array['emp_bday'] != '0000-00-00' && $data_array['emp_bday'] != NULL) : echo $data_array['emp_bday']; else : echo date("Y-m-d", strtotime("-16 years")); endif; ?>" maxlength="10">
                                    </td>
                                    <td><span class="redtext">*</span> Place of Birth<br><input attribute="Birthplace" type="text" name="birthplace" size="25" id="birthplace" value="<?php echo $data_array['emp_bplace'] ? $data_array['emp_bplace'] : ""; ?>" class="txtbox" onChange="upperCase(this)"></td>
                                    <td align="center"><span class="redtext">*</span> Gender
                                        <select name="sex" id="sex" class="txtbox">
                                            <option value="m" <?php echo $data_array['emp_sex'] == "m" ? 'selected' : ''; ?>>Male</option>
                                            <option value="f" <?php echo $data_array['emp_sex'] == "f" ? 'selected' : ''; ?>>Female</option>
                                        </select>
                                    </td>
                                    <td><span class="redtext">*</span> Civil Status
                                        <select name="civil" id="civil" class="txtbox">
                                            <option value="s" <?php echo $data_array['emp_civil'] == "s" ? 'selected' : ''; ?>>Single</option>
                                            <option value="m" <?php echo $data_array['emp_civil'] == "m" ? 'selected' : ''; ?>>Married</option>
                                            <option value="w" <?php echo $data_array['emp_civil'] == "w" ? 'selected' : ''; ?>>Widowed</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="redtext">*</span> Social Security Number<input attribute="SSS Number" type="text" name="sss" id="sss" size="20" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_sss']; ?>"></td>
                                    <td><span class="redtext">*</span> Tax Identification Number<input attribute="TIN Number" type="text" name="tin" id="tin" size="20" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_tin']; ?>"></td>
                                    <td><span class="redtext">*</span> Philhealth Number<input attribute="Philhealth Number" type="text" name="philhealth" id="philhealth" size="20" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_philhealth']; ?>"></td>
                                    <td><span class="redtext">*</span> HDMF Number<input attribute="HDMF Number" type="text" name="pagibig" id="pagibig" size="20" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_pagibig']; ?>"></td>
                                </tr>
                            </table>
                            <br /><b>Family Background</b>
                            <table border="1" cellpadding="0" cellspacing="0" style="width: 100%;">                
                                <tr>
                                    <td>
                                        <table border="0" cellpadding="5" cellspacing="0" style="width: 100%;">
                                            <tr>
                                                <td width="30%">Spouse's Name<br><input type="text" name="spouse_name" size="30" id="spouse_name" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_spousename']; ?>"></td>
                                                <td width="10%">Birthday<br><input type="text" name="spouse_bday" size="10" id="spouse_bday" value="<?php echo $data_array['emp_spousebday'] ? $data_array['emp_spousebday'] : date("Y-m-d"); ?>" class="datepick txtbox"></td>
                                                <td width="30%">Company/Address<br><input type="text" name="spouse_comp" size="30" id="spouse_comp" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_spousecompany']; ?>"></td>
                                                <td width="20%">Occupation<br><input type="text" name="spouse_work" size="20" id="spouse_work" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_spousework']; ?>"></td>
                                                <td width="10%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <?php
                                    $child_array = html_entity_decode($data_array['emp_children'], ENT_QUOTES); 
                                    $child_array = unserialize($child_array);                    
                                ?>
                                <tr>
                                    <td>
                                        <table border="0" cellpadding="5" cellspacing="0" style="width: 100%;" id="tblChild">
                                            <?php if ($child_array) : ?>
                                                <?php foreach ($child_array as $key => $value) : ?>
                                                    <tr>
                                                        <td width="30%">
                                                            Child's Name<br>
                                                            <input type="text" name="child_name[<?php echo $key; ?>]" size="30" id="child_name[<?php echo $key; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php echo $value['name']; ?>">
                                                        <td width="10%">
                                                            Birthday<br>
                                                            <input type="text" name="child_bday[<?php echo $key; ?>]" size="10" id="child_bday[<?php echo $key; ?>]"  value="<?php echo $value['bday'] ? $value['bday'] : date("Y-m-d");; ?>" class="datepickchild txtbox">
                                                        </td>
                                                        <td width="20%">
                                                            Company/Address/School<br>
                                                            <input type="text" name="child_comp[<?php echo $key; ?>]" size="20" id="child_comp[<?php echo $key; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php echo $value['company']; ?>">
                                                        </td>
                                                        <td width="15%">
                                                            Occupation/Level<br>
                                                            <input type="text" name="child_work[<?php echo $key; ?>]" size="15" id="child_work[<?php echo $key; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php echo $value['work']; ?>">
                                                        </td>
                                                        <td width="15%">
                                                            To be include in<br>
                                                            <input type="checkbox" name="child_bir[0]" size="5" id="child_bir[0]" value="1" /> <font size="-2">BIR 2316 </font><br><input type="checkbox" name="child_ph[0]" size="5" id="child_ph[0]" value="1" /><font size="-2"> PhilHealth </font><br><input type="checkbox" name="child_mc[0]" size="5" id="child_mc[0]" value="1" /> <font size="-2">MediCard </font>
                                                        </td>
                                                        <td width="10%" class="valign-bottom"><input type="button" class="addChild btn <?php if (($key + 1) != count($child_array)) : echo "invisible"; endif; ?>" attribute="<?php echo $key + 1; ?>" value="Add" /></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td width="30%">
                                                        Child's Name<br>
                                                        <input type="text" name="child_name[0]" size="30" id="child_name[0]" onChange="upperCase(this)" class="txtbox">
                                                    <td width="10%">
                                                        Birthday<br>
                                                        <input type="text" name="child_bday[0]" size="10" id="child_bday[0]" value="<?php echo date("Y-m-d"); ?>" class="datepickchild txtbox">
                                                    </td>
                                                    <td width="20%">
                                                        Company/Address/School<br>
                                                        <input type="text" name="child_comp[0]" size="20" id="child_comp[0]" onChange="upperCase(this)" class="txtbox">
                                                    </td>
                                                    <td width="15%">
                                                        Occupation/Level<br>
                                                        <input type="text" name="child_work[0]" size="15" id="child_work[0]" onChange="upperCase(this)" class="txtbox">
                                                    </td>
                                                    <td width="15%">
                                                        To be include in<br>
                                                        <input type="checkbox" name="child_bir[0]" size="5" id="child_bir[0]" value="1" /> <font size="-2">BIR 2316 </font><br><input type="checkbox" name="child_ph[0]" size="5" id="child_ph[0]" value="1" /> <font size="-2">PhilHealth </font><br><input type="checkbox" name="child_mc[0]" size="5" id="child_mc[0]" value="1" /> <font size="-2">MediCard </font>
                                                    </td>
                                                    <td width="10%" class="valign-bottom"><input type="button" class="addChild btn" attribute="1" value="Add" /></td>
                                                </tr>
                                            <?php endif; ?>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table border="0" cellpadding="5" cellspacing="0" style="width: 100%;">
                                            <tr>
                                                <td width="30%"><span class="redtext">*</span> Father's Name<br><input attribute="Father's Name" type="text" name="father_name" size="30" id="father_name" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_fathername']; ?>"></td>
                                                <td width="10%"><span class="redtext">*</span> Birthday<br><input type="text" name="father_bday" size="10"  value="<?php echo $data_array['emp_fatherbday'] ? $data_array['emp_fatherbday'] : date("Y-m-d"); ?>" id="father_bday" class="datepick txtbox"></td>
                                                <td width="30%"><span class="redtext">*</span> Company/Address<br><input attribute="Father's Company/Address" type="text" name="father_comp" size="30" id="father_comp" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_fathercompany']; ?>"></td>
                                                <td width="20%">Occupation<br><input attribute="Father's Occupation" type="text" name="father_work" size="20" id="father_work" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_fatherwork']; ?>"></td>
                                                <td width="10%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table border="0" cellpadding="5" cellspacing="0" style="width: 100%;">
                                            <tr>
                                                <td width="30%"><span class="redtext">*</span> Mother's Name<br><input attribute="Mother's Name" type="text" name="mother_name" size="30" id="mother_name" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_mothername']; ?>"></td>
                                                <td width="10%"><span class="redtext">*</span> Birthday<br><input type="text" name="mother_bday" size="10" id="mother_bday" value="<?php echo $data_array['emp_motherbday'] ? $data_array['emp_motherbday'] : date("Y-m-d"); ?>" class="datepick txtbox"></td>
                                                <td width="30%"><span class="redtext">*</span> Company/Address<br><input attribute="Mother's Company/Address" type="text" name="mother_comp" size="30" id="mother_comp" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_mothercompany']; ?>"></td>
                                                <td width="20%">Occupation<br><input attribute="Mother's Occupation" type="text" name="mother_work" size="20" id="mother_work" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_motherwork']; ?>"></td>
                                                <td width="10%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <?php
                                    $brosis_array = html_entity_decode($data_array['emp_brosis'], ENT_QUOTES); 
                                    $brosis_array = unserialize($brosis_array);                    
                                ?>
                                <tr>
                                    <td>
                                        <table border="0" cellpadding="5" cellspacing="0" style="width: 100%;" id="tblBrod">
                                            <?php if ($brosis_array) : ?>
                                                <?php foreach ($brosis_array as $key => $value) : ?>
                                                    <tr>
                                                        <td width="30%">
                                                            Name of Brothers/Sisters<br>
                                                            <input type="text" name="brod_name[<?php echo $key; ?>]" size="30" id="brod_name[<?php echo $key; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php echo $value['name']; ?>">
                                                        </td>
                                                        <td width="10%">
                                                            Birthday<br>
                                                            <input type="text" value="<?php echo $value['bday'] ? $value['bday'] : date("Y-m-d"); ?>" name="brod_bday[<?php echo $key; ?>]" size="10" id="brod_bday[<?php echo $key; ?>]" class="datepickchild txtbox">
                                                        </td>
                                                        <td width="30%">
                                                            Company/Address<br>
                                                            <input type="text" name="brod_comp[<?php echo $key; ?>]" size="30" id="brod_comp[<?php echo $key; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php echo $value['company']; ?>">
                                                        </td>
                                                        <td width="20%">
                                                            Occupation<br>
                                                            <input type="text" name="brod_work[<?php echo $key; ?>]" size="20" id="brod_work[<?php echo $key; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php echo $value['work']; ?>">
                                                        </td>
                                                        <td width="10%" class="valign-bottom"><input type="button" class="addBrod btn" attribute="<?php echo $key + 1; ?>" value="Add" /></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td width="30%">
                                                        Name of Brothers/Sisters<br>
                                                        <input type="text" name="brod_name[0]" size="30" id="brod_name[0]" onChange="upperCase(this)" class="txtbox">
                                                    </td>
                                                    <td width="10%">
                                                        Birthday<br>
                                                        <input type="text" name="brod_bday[0]" size="10" id="brod_bday[0]" value="<?php echo date("Y-m-d"); ?>" class="datepickchild txtbox">
                                                    </td>
                                                    <td width="30%">
                                                        Company/Address<br>
                                                        <input type="text" name="brod_comp[0]" size="30" id="brod_comp[0]" onChange="upperCase(this)" class="txtbox">
                                                    </td>
                                                    <td width="20%">
                                                        Occupation<br>
                                                        <input type="text" name="brod_work[0]" size="20" id="brod_work[0]" onChange="upperCase(this)" class="txtbox">
                                                    </td>
                                                    <td width="10%" class="valign-bottom"><input type="button" class="addBrod btn" attribute="1" value="Add" /></td>
                                                </tr>
                                            <?php endif; ?>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                
                        
                            <?php
                                $schoolname = explode("|", $data_array['emp_schoolname']);
                                $schoolfrom = explode("|", $data_array['emp_schoolfrom']);
                                $schoolto = explode("|", $data_array['emp_schoolto']);
                                $schooldegree = explode("|", $data_array['emp_schooldegree']);
                            ?>
                            
                            <br /><b>Education, Training & Skills History</b>
                            <table border="1" cellpadding="5" cellspacing="0" style="width: 100%;" id="tblSchool">
                                <tr>
                                    <td width="40%" align="center">Schools Name & Address</td>
                                    <td width="20%" align="center">From</td>
                                    <td width="20%" align="center">To</td>
                                    <td width="20%" align="center">Course & Award Recieved</td>
                                </tr>
                                
                                <tr>
                                    <td><span class="redtext">*</span> Elementary<br><input attribute="Elementary School Name" type="text" name="schoolname[0]" size="50" id="schoolname[0]" onChange="upperCase(this)" class="txtbox" value="<?php echo $schoolname[0]; ?>"></td>
                                    <td class="valign-bottom centertalign"><input type="text" name="schoolfrom[0]" size="10" id="schoolfrom[0]" class="datepick2 txtbox" value="<?php echo $schoolfrom[0] ? $schoolfrom[0] : date("Y-m-d"); ?>"></td>
                                    <td class="valign-bottom centertalign"><input type="text" name="schoolto[0]" size="10" id="schoolto[0]" class="datepick2 txtbox" value="<?php echo $schoolto[0] ? $schoolto[0] : date("Y-m-d"); ?>"></td>
                                    <td class="valign-bottom centertalign"><input type="text" name="schooldegree[0]" size="30" id="schooldegree[0]" onChange="upperCase(this)" class="txtbox" value="<?php echo $schooldegree[0]; ?>"></td>
                                </tr>
                                
                                <tr>
                                    <td><span class="redtext">*</span> High School<br><input attribute="High School Name" type="text" name="schoolname[1]" size="50" id="schoolname[1]" onChange="upperCase(this)" class="txtbox" value="<?php echo $schoolname[1]; ?>"></td>
                                    <td class="valign-bottom centertalign"><input type="text" name="schoolfrom[1]" size="10" id="schoolfrom[1]" class="datepick2 txtbox" value="<?php echo $schoolfrom[1] ? $schoolfrom[1] : date("Y-m-d"); ?>"></td>
                                    <td class="valign-bottom centertalign"><input type="text" name="schoolto[1]" size="10" id="schoolto[1]" class="datepick2 txtbox" value="<?php echo $schoolto[1] ? $schoolto[1] : date("Y-m-d"); ?>"></td>
                                    <td class="valign-bottom centertalign"><input type="text" name="schooldegree[1]" size="30" id="schooldegree[1]" onChange="upperCase(this)" class="txtbox" value="<?php echo $schooldegree[1]; ?>"></td>
                                </tr>
                                <tr>
                                    <td>College<br><input type="text" name="schoolname[2]" size="50" id="schoolname[2]" onChange="upperCase(this)" class="txtbox" value="<?php echo $schoolname[2]; ?>"></td>
                                    <td class="valign-bottom centertalign"><input type="text" name="schoolfrom[2]" size="10" id="schoolfrom[2]" class="datepick2 txtbox" value="<?php echo $schoolfrom[2] ? $schoolfrom[2] : date("Y-m-d"); ?>"></td>
                                    <td class="valign-bottom centertalign"><input type="text" name="schoolto[2]" size="10" id="schoolto[2]" class="datepick2 txtbox" value="<?php echo $schoolto[2] ? $schoolto[2] : date("Y-m-d"); ?>"></td>
                                    <td class="valign-bottom centertalign"><input type="text" name="schooldegree[2]" size="30" id="schooldegree[2]" onChange="upperCase(this)" class="txtbox" value="<?php echo $schooldegree[2]; ?>"></td>
                                </tr>
                                <tr>
                                    <td>Vocational<br><input type="text" name="schoolname[3]" size="50" id="schoolname[3]" onChange="upperCase(this)" class="txtbox" value="<?php echo $schoolname[3]; ?>"></td>
                                    <td class="valign-bottom centertalign"><input type="text" name="schoolfrom[3]" size="10" id="schoolfrom[3]" class="datepick2 txtbox" value="<?php echo $schoolfrom[3] ? $schoolfrom[3] : date("Y-m-d"); ?>"></td>
                                    <td class="valign-bottom centertalign"><input type="text" name="schoolto[3]" size="10" id="schoolto[3]" class="datepick2 txtbox" value="<?php echo $schoolto[3] ? $schoolto[3] : date("Y-m-d"); ?>"></td>
                                    <td class="valign-bottom centertalign"><input type="text" name="schooldegree[3]" size="30" id="schooldegree[3]" onChange="upperCase(this)" class="txtbox" value="<?php echo $schooldegree[3]; ?>"></td>
                                </tr>
                                
                                <?php $schcount = count($schoolname); ?>
                                
                                <?php if ($schcount >= 6) : ?>
                                    <?php foreach ($schoolname as $key => $value) : ?>
                                        <?php if ($key >= 4) : ?>
                                        <tr>
                                            <td>Others<br><input type="text" name="schoolname[<?php echo $key; ?>]" size="50" id="schoolname[<?php echo $key; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php echo $schoolname[$key]; ?>"></td>
                                            <td class="valign-bottom centertalign"><input type="text" name="schoolfrom[<?php echo $key; ?>]" size="10" id="schoolfrom[<?php echo $key; ?>]" class="datepick2 txtbox" value="<?php echo $schoolfrom[$key] ? $schoolfrom[$key] : date("Y-m-d"); ?>"></td>
                                            <td class="valign-bottom centertalign"><input type="text" name="schoolto[<?php echo $key; ?>]" size="10" id="schoolto[<?php echo $key; ?>]" class="datepick2 txtbox" value="<?php echo $schoolto[$key] ? $schoolto[$key] : date("Y-m-d"); ?>"></td>
                                            <td class="valign-bottom centertalign"><input type="text" name="schooldegree[<?php echo $key; ?>]" size="30" id="schooldegree[<?php echo $key; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php echo $schooldegree[$key]; ?>"></td>
                                        </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    
                                    <tr>
                                        <td>Others<br><input type="text" name="schoolname[4]" size="50" id="schoolname[4]" onChange="upperCase(this)" class="txtbox" value="<?php echo $schoolname[4]; ?>"></td>
                                        <td class="valign-bottom centertalign"><input type="text" name="schoolfrom[4]" size="10" id="schoolfrom[4]" class="datepick2 txtbox" value="<?php echo $schoolfrom[4] ? $schoolfrom[4] : date("Y-m-d"); ?>"></td>
                                        <td class="valign-bottom centertalign"><input type="text" name="schoolto[4]" size="10" id="schoolto[4]" class="datepick2 txtbox" value="<?php echo $schoolto[4] ? $schoolto[4] : date("Y-m-d"); ?>"></td>
                                        <td class="valign-bottom centertalign"><input type="text" name="schooldegree[4]" size="30" id="schooldegree[4]" onChange="upperCase(this)" class="txtbox" value="<?php echo $schooldegree[4]; ?>"></td>
                                    </tr>
                                        
                                <?php endif; ?>
                                
                            </table>
                            <br>    
                            
                            <input type="button" class="addSchool btn" attribute="<?php echo $schcount >= 6 ? count($schoolname) + 1 : "6"; ?>" value="Add School" /><br><br>
                            
                            <?php
                                $govlic_array = html_entity_decode($data_array['emp_govlic'], ENT_QUOTES); 
                                $govlic_array = unserialize($govlic_array);                    
                            ?>
                            <table border="1" cellpadding="5" cellspacing="0" style="width: 100%;" id="tblExam">
                                <tr>
                                    <td width="50%" align="center">Government/Licensure Examinations</td>
                                    <td width="25%" align="center">Rating</td>
                                    <td width="25%" align="center">Date Taken</td>
                                </tr>
                                <?php if ($govlic_array) : ?>
                                    <?php foreach ($govlic_array as $key => $value) : ?>
                                        <tr>
                                            <td><input type="text" name="exam_name[<?php echo $key; ?>]" size="60" id="exam_name[<?php echo $key; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php echo $value['name']; ?>"></td>
                                            <td class="centertalign"><input type="text" name="exam_rating[<?php echo $key; ?>]" size="20" id="exam_rating[<?php echo $key; ?>]" class="txtbox" value="<?php echo $value['rating']; ?>"></td>
                                            <td class="centertalign"><input type="text" name="exam_date[<?php echo $key; ?>]" size="20" id="exam_date[<?php echo $key; ?>]" class="datepick2 txtbox" value="<?php echo $value['date']; ?>"></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td><input type="text" name="exam_name[0]" size="60" id="exam_name[0]" onChange="upperCase(this)" class="txtbox"></td>
                                        <td class="centertalign"><input type="text" name="exam_rating[0]" size="20" id="exam_rating[0]" class="txtbox"></td>
                                        <td class="centertalign"><input type="text" name="exam_date[0]" size="20" id="exam_date[0]" class="datepick2 txtbox"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="exam_name[1]" size="60" id="exam_name[1]" onChange="upperCase(this)" class="txtbox"></td>
                                        <td class="centertalign"><input type="text" name="exam_rating[1]" size="20" id="exam_rating[1]" class="txtbox"></td>
                                        <td class="centertalign"><input type="text" name="exam_date[1]" size="20" id="exam_date[1]" class="datepick2 txtbox"></td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                            <br><input type="button" class="addExam btn" attribute="<?php echo $govlic_array ? count($govlic_array) + 1 : "3"; ?>" value="Add Government/Licensure Examinations" /><br><br>
                            <?php
                                $seminar_array = html_entity_decode($data_array['emp_seminar'], ENT_QUOTES); 
                                $seminar_array = unserialize($seminar_array);                    
                            ?>
                            <table border="1" cellpadding="5" cellspacing="0" style="width: 100%;" id="tblSeminar">
                                <tr>
                                    <td width="50%" align="center">Seminars Attended</td>
                                    <td width="25%" align="center">Place</td>
                                    <td width="25%" align="center">Date Taken</td>
                                </tr>
                                <?php if ($seminar_array) : ?>
                                    <?php foreach ($seminar_array as $key => $value) : ?>
                                        <tr>
                                            <td><input type="text" name="seminar_title[<?php echo $key; ?>]" size="60" id="seminar_title[<?php echo $key; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php echo $value['title']; ?>"></td>
                                            <td class="centertalign"><input type="text" name="seminar_place[<?php echo $key; ?>]" size="20" id="seminar_place[<?php echo $key; ?>]" class="txtbox" value="<?php echo $value['place']; ?>"></td>
                                            <td class="centertalign"><input type="text" name="seminar_date[<?php echo $key; ?>]" size="20" id="seminar_date[<?php echo $key; ?>]" class="datepick2 txtbox" value="<?php echo $value['date']; ?>"></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td><input type="text" name="seminar_title[0]" size="60" id="seminar_title[0]" onChange="upperCase(this)" class="txtbox"></td>
                                        <td class="centertalign"><input type="text" name="seminar_place[0]" size="20" id="seminar_place[0]" onChange="upperCase(this)" class="txtbox"></td>
                                        <td class="centertalign"><input type="text" name="seminar_date[0]" size="20" id="seminar_date[0]" class="datepick2 txtbox"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="seminar_title[1]" size="60" id="seminar_title[1]" onChange="upperCase(this)" class="txtbox"></td>
                                        <td class="centertalign"><input type="text" name="seminar_place[1]" size="20" id="seminar_place[1]" onChange="upperCase(this)" class="txtbox"></td>
                                        <td class="centertalign"><input type="text" name="seminar_date[1]" size="20" id="seminar_date[1]" class="datepick2 txtbox"></td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                            <br><input type="button" class="addSeminar btn" attribute="<?php echo $seminar_array ? count($seminar_array) + 1 : "3"; ?>" value="Add Seminars Attended" /><br><br>
                            <table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">
                                <tr>
                                    <td>
                                        <?php
                                            $skill_array = html_entity_decode($data_array['emp_skill'], ENT_QUOTES); 
                                            $skill_array = unserialize($skill_array);                    
                                        ?>                        
                                        <span class="redtext">*</span> Other Skills
                                        <table border="0" cellpadding="5" cellspacing="0" style="width: 100%;" id="tblSkill">
                                            <?php if ($skill_array) : ?>
                                                <?php foreach ($skill_array as $key => $value) : ?>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="skill[<?php echo $key; ?>]" size="40" id="skill[<?php echo $key; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php echo $value['name']; ?>">
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td>
                                                        <input attribute="Skills" type="text" name="skill[0]" size="40" id="skill[0]" onChange="upperCase(this)" class="txtbox"></td>
                                                </tr>
                                            <?php endif; ?>
                                        </table>
                                        <input type="button" class="addSkill btn" attribute="<?php echo $skill_array ? count($skill_array) + 1 : "1"; ?>" value="Add Skill" /><br><br>
                                    </td>
                                </tr>
                            </table><br>
                            
                            <?php
                                $org_array = html_entity_decode($data_array['emp_organization'], ENT_QUOTES); 
                                $org_array = unserialize($org_array);                    
                            ?>
                            <table border="1" cellpadding="5" cellspacing="0" style="width: 100%;" id="tblOrg">
                                <tr>
                                    <td width="50%" align="center">Organization</td>
                                    <td width="25%" align="center">Position</td>
                                    <td width="25%" align="center">Year</td>
                                </tr>
                                <?php if ($org_array) : ?>
                                    <?php foreach ($org_array as $key => $value) : ?>
                                        <tr>
                                            <td><input type="text" name="org_name[<?php echo $key; ?>]" size="60" id="org_name[<?php echo $key; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php echo $value['name']; ?>"></td>
                                            <td class="centertalign"><input type="text" name="org_position[<?php echo $key; ?>]" size="20" id="org_position[<?php echo $key; ?>]" class="txtbox" value="<?php echo $value['position']; ?>"></td>
                                            <td class="centertalign"><input type="text" name="org_year[<?php echo $key; ?>]" size="20" id="org_year[<?php echo $key; ?>]" class="txtbox" value="<?php echo $value['year']; ?>"></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td><input type="text" name="org_name[0]" size="60" id="org_name[0]" onChange="upperCase(this)" class="txtbox"></td>
                                        <td class="centertalign"><input type="text" name="org_position[0]" size="20" id="org_position[0]" onChange="upperCase(this)" class="txtbox"></td>
                                        <td class="centertalign"><input type="text" name="org_year[0]" size="20" id="org_year[0]" class="txtbox"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="org_name[1]" size="60" id="org_name[1]" onChange="upperCase(this)" class="txtbox"></td>
                                        <td class="centertalign"><input type="text" name="org_position[1]" size="20" id="org_position[1]" onChange="upperCase(this)" class="txtbox"></td>
                                        <td class="centertalign"><input type="text" name="org_year[1]" size="20" id="org_year[1]" class="txtbox"></td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                            <br><input type="button" class="addOrg btn" attribute="<?php echo $org_array ? count($org_array) + 1 : "3"; ?>" value="Add Organization" /><br><br>
                
                            
                            <?php
                                $history_array = html_entity_decode($data_array['emp_history'], ENT_QUOTES); 
                                $history_array = unserialize($history_array);                    
                            ?>
                            <br /><b>Employment History</b>
                            <table border="1" cellpadding="5" cellspacing="0" style="width: 100%;" id="tblHistory">
                                <tr>
                                    <td width="35%" align="center">COMPANY NAME</td>
                                    <td width="25%" align="center">POSITION HELD</td>
                                    <td width="10%" align="center">SALARY</td>
                                    <td width="20%" align="center">REASON FOR LEAVING</td>
                                    <td width="10%" align="center">DATES EMPLOYED</td>
                                </tr>
                                <?php if ($history_array) : ?>
                                    <?php foreach ($history_array as $key => $value) : ?>
                                        <tr>
                                            <td>
                                                Name<br><input type="text" name="comp_name[<?php echo $key; ?>]" size="30" id="comp_name[<?php echo $key; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php if ($key == 0) : echo "MEGAWORLD CORPORATION"; endif; ?>" <?php if ($key == 0) : ?>readonly<?php endif; ?>><br>
                                                Address<br><input type="text" name="comp_address[<?php echo $key; ?>]" size="30" id="comp_address[<?php echo $key; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php if ($key == 0) : echo "THE WORLD CENTER BUILDING, 330 SEN. GIL PUYAT AVENUE, MAKATI CITY"; endif; ?>" <?php if ($key == 0) : ?>readonly<?php endif; ?>><br>
                                                Tel. No.<br><input type="text" name="comp_telno[<?php echo $key; ?>]" size="30" id="comp_telno[<?php echo $key; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php if ($key == 0) : echo "867-8826"; endif; ?>" <?php if ($key == 0) : ?>readonly<?php endif; ?>>
                                            </td>
                                            <td class="valign-center">
                                                Position<br><input type="text" name="comp_position[<?php echo $key; ?>]" size="20" id="comp_position<?php if ($key != 0) : ?>[<?php echo $key; ?>]<?php endif; ?>" onChange="upperCase(this)" class="txtbox" value="<?php echo $value['position']; ?>" <?php if ($key == 0) : ?>readonly<?php endif; ?>><br>
                                                Name of immediate supervisor<br><input type="text" name="comp_supervisor[<?php echo $key; ?>]" size="20" id="comp_supervisor[<?php echo $key; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php echo $value['supervisor']; ?>">
                                            </td>
                                            <td class="valign-center">
                                                <?php if ($key != 0) : ?><input type="text" name="comp_salary[<?php echo $key; ?>]" size="10" id="comp_salary[<?php echo $key; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php echo $value['salary']; ?>"><?php endif; ?>
                                            </td>
                                            <td class="valign-center">
                                                <?php if ($key != 0) : ?><input type="text" name="comp_reason[<?php echo $key; ?>]" size="20" id="comp_reason[<?php echo $key; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php echo stripslashes($value['Reason']); ?>"><?php endif; ?>
                                            </td>
                                            <td class="valign-center">
                                                From<br><input type="text" name="comp_from[<?php echo $key; ?>]" size="10" id="comp_from<?php if ($key != 0) : ?>[<?php echo $key; ?>]<?php endif; ?>" class="<?php if ($i != 0) : ?>datepick2<?php endif; ?> txtbox" value="<?php echo $value['from']; ?>" <?php if ($key == 0) : ?>readonly<?php endif; ?>><br>
                                                <?php if ($key != 0) : ?>To<br><input type="text" name="comp_to[<?php echo $key; ?>]" size="10" id="comp_to[<?php echo $key; ?>]" class="datepick2 txtbox" value="<?php echo $value['to']; ?>"><?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <?php for($i=0; $i<=3; $i++) : ?>
                                        <tr>
                                            <td>
                                                Name<br><input type="text" name="comp_name[<?php echo $i; ?>]" size="30" id="comp_name[<?php echo $i; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php if ($i == 0) : echo "MEGAWORLD CORPORATION"; endif; ?>" <?php if ($i == 0) : ?>readonly<?php endif; ?>><br>
                                                Address<br><input type="text" name="comp_address[<?php echo $i; ?>]" size="30" id="comp_address[<?php echo $i; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php if ($i == 0) : echo "THE WORLD CENTER BUILDING, 330 SEN. GIL PUYAT AVENUE, MAKATI CITY"; endif; ?>" <?php if ($i == 0) : ?>readonly<?php endif; ?>><br>
                                                Tel. No.<br><input type="text" name="comp_telno[<?php echo $i; ?>]" size="30" id="comp_telno[<?php echo $i; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php if ($i == 0) : echo "867-8826"; endif; ?>" <?php if ($i == 0) : ?>readonly<?php endif; ?>>
                                            </td>
                                            <td class="valign-center">
                                                Position<br><input type="text" name="comp_position[<?php echo $i; ?>]" size="20" id="comp_position<?php if ($i != 0) : ?>[<?php echo $i; ?>]<?php endif; ?>" onChange="upperCase(this)" class="txtbox" <?php if ($i == 0) : ?>readonly<?php endif; ?>><br>
                                                <?php if ($i == 0) { ?><span class="redtext">*</span> <?php } ?>Name of immediate supervisor<br><input attribute="Supervisor" type="text" name="comp_supervisor[<?php echo $i; ?>]" size="20" id="comp_supervisor[<?php echo $i; ?>]" onChange="upperCase(this)" class="txtbox">
                                            </td>
                                            <td class="valign-center">
                                                <?php if ($i != 0) : ?><input type="text" name="comp_salary[<?php echo $i; ?>]" size="10" id="comp_salary[<?php echo $i; ?>]" onChange="upperCase(this)" class="txtbox"><?php endif; ?>
                                            </td>
                                            <td class="valign-center">
                                                <?php if ($i != 0) : ?><input type="text" name="comp_reason[<?php echo $i; ?>]" size="20" id="comp_reason[<?php echo $i; ?>]" onChange="upperCase(this)" class="txtbox"><?php endif; ?>
                                            </td>
                                            <td class="valign-center">
                                                From<br><input type="text" name="comp_from[<?php echo $i;  ?>]" size="10" id="comp_from<?php if ($i != 0) : ?>[<?php echo $i; ?>]<?php endif; ?>" class="<?php if ($i != 0) : ?>datepick2<?php endif; ?> txtbox" value="<?php echo date("Y-m-d"); ?>" <?php if ($i == 0) : ?>readonly<?php endif; ?>><br>
                                                <?php if ($i != 0) : ?>To<br><input type="text" name="comp_to[<?php echo $i;  ?>]" size="10" id="comp_to[<?php echo $i;  ?>]" value="<?php echo date("Y-m-d"); ?>" class="datepick2 txtbox"><?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endfor; ?>
                                <?php endif; ?>
                            </table>            
                            <br><input type="button" class="addHistory btn" attribute="<?php echo $history_array ? count($history_array) + 1 : "5"; ?>" value="Add Employment History" /><br><br>            
                            
                            <?php
                                $refername = explode("|", $data_array['emp_referencename']);
                                $referpos = explode("|", $data_array['emp_referenceposition']);
                                $refercomp = explode("|", $data_array['emp_referencecompany']);
                                $referadd = explode("|", $data_array['emp_referenceaddress']);
                                $refertel = explode("|", $data_array['emp_referencetelno']);
                            ?>
                        
                            <br /><b>Corporate Information</b>
                            <table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">
                                <tr>
                                    <td width="30%"><span class="redtext">*</span> Division:<br/>
                                        <?php if ($dept_sel) : ?>
                                        <select attribute="Division" name="division" id="division" class="txtbox" style="width: 230px;" />
                                            <option value="0" selected>Select...</option>
                                            <?php                                                 
                                                foreach ($div_sel as $key => $value) :
                                                ?>
                                                    <option value="<?php echo $value['div_id']; ?>"><?php echo strtoupper($value['div_name']); ?></option>
                                                <?php    
                                                endforeach;    
                                            ?>                      
                                        </select>
                                        <?php endif; ?>
                                    </td>
                                    <td width="30%">Group:<br/>
                                        <?php if ($grp_sel) : ?>
                                        <select attribute="Group" name="dgroup" id="dgroup" class="txtbox" style="width: 230px;" />
                                            <option value="0" selected>Select...</option>
                                            <?php                                                 
                                                foreach ($grp_sel as $key => $value) :
                                                ?>
                                                    <option value="<?php echo $value['dgroup_id']; ?>"><?php echo strtoupper($value['dgroup_name']); ?></option>
                                                <?php    
                                                endforeach;    
                                            ?>             
                                            <option value="29999">N/A</option>
                                        </select>
                                        <?php endif; ?>
                                    </td>
                                    <td width="40%" colspan="2"><span class="redtext">*</span> Department:<br/>
                                        <?php if ($dept_sel) : ?>
                                        <select attribute="Department" name="department" id="department" class="txtbox" style="width: 300px;" />
                                            <option value="0" selected>Select...</option>
                                            <?php                                                 
                                                foreach ($dept_sel as $key => $value) :
                                                ?>
                                                    <option value="<?php echo $value['dept_id']; ?>"><?php echo strtoupper($value['dept_name']); ?></option>
                                                <?php    
                                                endforeach;    
                                            ?>                      
                                        </select>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="redtext">*</span> Section:<br/>
                                        <?php if ($sec_sel) : ?>
                                        <select attribute="Section" name="dsection" id="dsection" class="txtbox" style="width: 230px;" />
                                            <option value="0" selected>Select...</option>
                                            <?php                                                 
                                                foreach ($sec_sel as $key => $value) :
                                                ?>
                                                    <option value="<?php echo $value['sec_id']; ?>"><?php echo strtoupper($value['sec_name']); ?></option>
                                                <?php    
                                                endforeach;    
                                            ?>                             
                                            <option value="29999">N/A</option>
                                        </select>
                                        <?php endif; ?>
                                    </td>
                                    <td><span class="redtext">*</span> Contact Local<br/><input attribute="Contact Local" type="text" name="local" size="20" id="local" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['emp_corptel']; ?>"></td>
                                    <td colspan="2"><span class="redtext">*</span> Megaworld E-mail<br/><input attribute="Megaworld E-mail" type="text" name="corp_email" size="30" id="corp_email" onChange="checkemail()" class="txtbox" value="<?php echo $emp_data['emp_corpemail'] ? $emp_data['emp_corpemail'] : '@megaworldcorp.com'; ?>"><br><i>* this will serve as email notification and alerts from HR Portal</i></td>
                                </tr>                            
                                <!--tr>
                                    <td colspan="2"><input type="checkbox" name="iamhead" id="iamhead" class="iamhead" value="1" > I am a head/manager/supervisor</td>
                                    <td colspan="2">
                                        <span class="redtext">*</span> Immediate Head
                                        <select name="ihead" id="ihead" class="txtbox" style="width: 300px;" />
                                        </select>
                                    </td>
                                </tr-->
                            </table>
                                    
                            <br /><b>References</b>
                            <table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">
                                <tr>
                                    <td colspan="3"><span class="redtext">*</span> In case of emergency, notify Mr. Ms. <input attribute="Contact Name to Notify" type="text" name="emergency_name" size="82" id="emergency_name" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_emergencyname']; ?>"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><span class="redtext">*</span> Address <input attribute="Contact Address to Notify" type="text" name="emergency_address" size="70" id="emergency_address" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_emergencyadd']; ?>"></td>
                                    <td><span class="redtext">*</span> Tel. No <input attribute="Contact Number to Notify" type="text" name="emergency_telno" size="10" id="emergency_telno" onChange="upperCase(this)" class="txtbox" value="<?php echo $data_array['emp_emergencytelno']; ?>"></td>
                                </tr>
                            </table>
                            <br>
                            <table id="lasttable" border="1" cellpadding="5" cellspacing="0" style="width: 100%;">
                                <tr><td colspan="2" style="font-weight: bold; text-align: center;">GUIDELINES IN UPDATING RECORDS</td></tr>
                                <tr>
                                    <td width="50%">
                                        <b>1. BIR</b><br>
                                        Two copies of duly accomplished BIR 2305 Form<br>
                                        One photocopy of Birth Certificate of Beneficiary/ies (if applicable only)<br>					
                                        One photocopy of Marriage Certificate (if applicable only)<br><br>
                                        
                                        <b>2. PAG-IBIG</b><br>
                                        Two copies of duly accomplished Pag-IBIG MCIF (Member’s Change of Information Form)<br>
                                        One photocopy of Birth Certificate of Beneficiary/ies (if applicable only)<br>	
                                        One photocopy of Marriage Certificate (if applicable only)<br><br>
                                        
                                        <b>3. PHILHEALTH</b><br>
                                        Two copies of duly accomplished Philhealth Member Registration Form (PMRF)<br>
                                        One photocopy of Birth Certificate of Employee<br>
                                        One photocopy of Birth Certificate of Beneficiary/ies (if applicable only)<br>
                                        One photocopy of Marriage Certificate (if applicable only)<br>
                                        One photocopy of Senior Citizen ID of Parent/s (if beneficiaries are parents)<br>
                                    </td>
                                    <td width="50%" style="vertical-align: top;">
                                        <b>4. SSS</b><br>
                                        Two copies of duly accomplished SSS Member Data Change Request Form<br>
                                        Original and one photocopy of Birth Certificate of Beneficiary/ies (if applicable only)<br>
                                        Original and one photocopy of Marriage Certificate (if applicable only)<br><br>
                                        
                                        <b>5. MEDICARD (FOR NEWLY BORN DEPENDENT ONLY)</b><br>
                                        One copy of duly accomplished Medicard Enrollment Form<br>				
                                        One photocopy of Birth Certificate of Beneficiary/ies (if applicable only)<br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: left;">
                                        <span class="redtext">*</span> <input attribute="You must disclaim that you full understand on updating records" type="checkbox" name="disclaim" id="disclaim" value="1" >I understand that in order to fully update my records, all documentary requirement should be submitted to HRD<br><br><b>Declaration Statement</b><br>I certify that the information in this <?php echo ucfirst($profile_nadd); ?> 201 Form is true and correct to the best of my knowledge and that any misrepresentation, falsification or willful omission herein shall be sufficient reason for dismissal from or refusal by this company.
                                    </td>
                                </tr>
                            </table>            
                            
                            <div align="center">
                                <br><input type="submit" class="bigbtn" value="Save and Send My Password">
                            </div>
                        
                        </div>
                        </div>
                    </form>   
                    
                </div>
            </div>

    <?php include(TEMP."/footer.php"); ?>