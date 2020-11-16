	<?php include(TEMP."/header.php"); ?>

    <!-- BODY -->

                    <div id="mainsplashtext" class="mainsplashtext lefttalign">
                        <div class="topsplashtext lefttalign robotobold cattext whitetext"><?php echo WELCOME; ?></div>
                        <div class="leftsplashtext lefttalign"><?php include(TEMP."/menu.php"); ?></div>
                        <div class="rightsplashtext lefttalign">

                            <?php foreach ($emp_data as $emp_data) : ?>

                            <?php if ($edit == 1) : ?>

                            <div id="uprofile" class="div9">

                                <form name="formpro" method="post" enctype="multipart/form-data">
                                    <?php if ($empid) : ?>
                                        <input type="hidden" name="eid" value="<?php echo $emp_data['emp_id']; ?>" />
                                        <input type="hidden" name="emphash" value="<?php echo $empid; ?>" />
                                    <?php endif ?>
                                    <div id="main" style="width: 100%; height: auto;">
                                    <div id="tabs">

                                        <div class="regup"><a href="<?php echo WEB; ?>/profile"><input type="button" value="Back to My Profile" class="btn" /></a></div>

                                        <div id="uidpic" class="uidpic" onmouseover="document.getElementById('picturediv').style.display = 'none';document.getElementById('uploaddiv').style.display = 'block';" onmouseout="document.getElementById('picturediv').style.display = 'block';document.getElementById('uploaddiv').style.display = 'none';">
                                            <div id="picturediv" style="padding-top: 75px;">
                                            <?php if ($profile_pic) : ?>
                                                <img src="<?php echo PAYWEB; ?>/imageuploader/<?php echo $profile_pic; ?>" width="200" height="200" />
                                            <?php else : ?>
                                                <?php if ($emp_data['Gender'] == 'FEMALE') : ?>
                                                <img src="<?php echo IMG_WEB; ?>/davatar_female.png" width="200" height="200" />
                                                <?php elseif ($emp_data['Gender'] == 'MALE'): ?>
                                                <img src="<?php echo IMG_WEB; ?>/davatar_male.png" width="200" height="200" />
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            </div>
                                            <div id="uploaddiv" style="display: none; color: #333; padding-top: 75px;">
                                                Update your ID picture<br><input name="binFile" size="10" type="file" value="<?php echo $emp_data['emp_resumefilename']; ?>" class="txtbox" style="width: 150px !important;"/><font size="-2"><b><br>(.gif/jpg and 100Kb only<br>1:1 ratio)</b></font>
                                            </div>

                                        </div>

                                        <b style="font-size:9px;">PRIVATE & CONFIDENTIAL</b><BR>
                                        <div style="font-size: 9px;">(<span class="lorangetext">*</span>) Field are required, please put <b>n/a</b> if not applicable</div>

                                        <br />

                                        <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                                            <tr>
                                                <td width="20%"><?php echo ucfirst($profile_nadd); ?> No.: <input attribute="<?php echo ucfirst($profile_nadd); ?> Number" type="text" name="empnum" size="12" id="empnum" class="txtbox" value="<?php echo $emp_data['EmpID']; ?>" readonly /><div id="checkIDerr" style="text-align: center; color: #F00;"></div></td>

                                                <td width="25%"><span class="redtext">*</span>  Position:
                                                    <!--input attribute="Position" type="text" name="position" size="30" id="position" class="txtbox" value="<?php //echo $position_data[0]['position_description']; ?>" readonly /--><input type="hidden" name="positionnum" id="positionnum" value="<?php echo $emp_data['emp_position']; ?>" />
                                                    <?php if ($posi_sel) : ?>
                                                    <select attribute="Position" name="PositionID" id="PositionID" class="txtbox" style="width: 150px;">
                                                        <option value="0" <?php echo $emp_data['PositionDesc'] == "" ? "selected" : ""; ?>>Select...</option>
                                                        <?php
                                                            foreach ($posi_sel as $key => $value) :
                                                            ?>
                                                                <option value="<?php echo $value['PositionID']; ?>" <?php echo $emp_data['PositionID'] == $value['PositionID'] ? "selected" : ""; ?>><?php echo $value['PositionDesc']; ?></option>
                                                            <?php
                                                            endforeach;
                                                        ?>
                                                    </select>
                                                    <?php endif; ?>
                                                </td>

                                                <td width="25%">Date Hired: <input type="text" name="datehired" size="10" id="datehired" class="txtbox" value="<?php echo date("Y-m-d", strtotime($emp_data['HireDate'])); ?>" maxlength="10" disabled></td>
                                            </tr>
                                        </table>
                                        <br /><b>Personal Data</b>
                                        <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                                            <tr>
                                                <td width="20%"><span class="lorangetext">*</span>  Last Name<br><input attribute="Last Name" type="text" name="LName" size="25" width="255" id="LName" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['LName']; ?>"></td>
                                                <td width="20%"><span class="lorangetext">*</span>  Extension Name<br><input attribute="Extension Name" type="text" name="LName" size="25" width="255" id="ExtensionName" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['ExtensionName']; ?>"></td>
                                                <td width="20%"><span class="lorangetext">*</span>  First Name<br><input attribute="First Name" type="text" name="FName" size="25" width="255" id="FName" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['FName']; ?>"></td>
                                                <td width="20%"><span class="lorangetext">*</span>  Middle Name<br><input attribute="Middle Name" type="text" name="MName" size="25" width="255" id="MName" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['MName']; ?>"></td>
                                                <td width="20%"><span class="lorangetext">*</span>  Nickname<br><input attribute="Nickname" type="text" name="NickName" size="20" width="255" id="NickName" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['NickName']; ?>"></td>
                                            </tr>
                                        </table><br>
                                        <table cellpadding="0" cellspacing="0" class="tdataform2" style="width: 100%;">
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
                                                                <?php $countries = array(
                                                                    'AF' => 'Afghanistan',
                                                                    'AX' => 'Aland Islands',
                                                                    'AL' => 'Albania',
                                                                    'DZ' => 'Algeria',
                                                                    'AS' => 'American Samoa',
                                                                    'AD' => 'Andorra',
                                                                    'AO' => 'Angola',
                                                                    'AI' => 'Anguilla',
                                                                    'AQ' => 'Antarctica',
                                                                    'AG' => 'Antigua And Barbuda',
                                                                    'AR' => 'Argentina',
                                                                    'AM' => 'Armenia',
                                                                    'AW' => 'Aruba',
                                                                    'AU' => 'Australia',
                                                                    'AT' => 'Austria',
                                                                    'AZ' => 'Azerbaijan',
                                                                    'BS' => 'Bahamas',
                                                                    'BH' => 'Bahrain',
                                                                    'BD' => 'Bangladesh',
                                                                    'BB' => 'Barbados',
                                                                    'BY' => 'Belarus',
                                                                    'BE' => 'Belgium',
                                                                    'BZ' => 'Belize',
                                                                    'BJ' => 'Benin',
                                                                    'BM' => 'Bermuda',
                                                                    'BT' => 'Bhutan',
                                                                    'BO' => 'Bolivia',
                                                                    'BA' => 'Bosnia And Herzegovina',
                                                                    'BW' => 'Botswana',
                                                                    'BV' => 'Bouvet Island',
                                                                    'BR' => 'Brazil',
                                                                    'IO' => 'British Indian Ocean Territory',
                                                                    'BN' => 'Brunei Darussalam',
                                                                    'BG' => 'Bulgaria',
                                                                    'BF' => 'Burkina Faso',
                                                                    'BI' => 'Burundi',
                                                                    'KH' => 'Cambodia',
                                                                    'CM' => 'Cameroon',
                                                                    'CA' => 'Canada',
                                                                    'CV' => 'Cape Verde',
                                                                    'KY' => 'Cayman Islands',
                                                                    'CF' => 'Central African Republic',
                                                                    'TD' => 'Chad',
                                                                    'CL' => 'Chile',
                                                                    'CN' => 'China',
                                                                    'CX' => 'Christmas Island',
                                                                    'CC' => 'Cocos (Keeling) Islands',
                                                                    'CO' => 'Colombia',
                                                                    'KM' => 'Comoros',
                                                                    'CG' => 'Congo',
                                                                    'CD' => 'Congo, Democratic Republic',
                                                                    'CK' => 'Cook Islands',
                                                                    'CR' => 'Costa Rica',
                                                                    'CI' => 'Cote D\'Ivoire',
                                                                    'HR' => 'Croatia',
                                                                    'CU' => 'Cuba',
                                                                    'CY' => 'Cyprus',
                                                                    'CZ' => 'Czech Republic',
                                                                    'DK' => 'Denmark',
                                                                    'DJ' => 'Djibouti',
                                                                    'DM' => 'Dominica',
                                                                    'DO' => 'Dominican Republic',
                                                                    'EC' => 'Ecuador',
                                                                    'EG' => 'Egypt',
                                                                    'SV' => 'El Salvador',
                                                                    'GQ' => 'Equatorial Guinea',
                                                                    'ER' => 'Eritrea',
                                                                    'EE' => 'Estonia',
                                                                    'ET' => 'Ethiopia',
                                                                    'FK' => 'Falkland Islands (Malvinas)',
                                                                    'FO' => 'Faroe Islands',
                                                                    'FJ' => 'Fiji',
                                                                    'FI' => 'Finland',
                                                                    'FR' => 'France',
                                                                    'GF' => 'French Guiana',
                                                                    'PF' => 'French Polynesia',
                                                                    'TF' => 'French Southern Territories',
                                                                    'GA' => 'Gabon',
                                                                    'GM' => 'Gambia',
                                                                    'GE' => 'Georgia',
                                                                    'DE' => 'Germany',
                                                                    'GH' => 'Ghana',
                                                                    'GI' => 'Gibraltar',
                                                                    'GR' => 'Greece',
                                                                    'GL' => 'Greenland',
                                                                    'GD' => 'Grenada',
                                                                    'GP' => 'Guadeloupe',
                                                                    'GU' => 'Guam',
                                                                    'GT' => 'Guatemala',
                                                                    'GG' => 'Guernsey',
                                                                    'GN' => 'Guinea',
                                                                    'GW' => 'Guinea-Bissau',
                                                                    'GY' => 'Guyana',
                                                                    'HT' => 'Haiti',
                                                                    'HM' => 'Heard Island & Mcdonald Islands',
                                                                    'VA' => 'Holy See (Vatican City State)',
                                                                    'HN' => 'Honduras',
                                                                    'HK' => 'Hong Kong',
                                                                    'HU' => 'Hungary',
                                                                    'IS' => 'Iceland',
                                                                    'IN' => 'India',
                                                                    'ID' => 'Indonesia',
                                                                    'IR' => 'Iran, Islamic Republic Of',
                                                                    'IQ' => 'Iraq',
                                                                    'IE' => 'Ireland',
                                                                    'IM' => 'Isle Of Man',
                                                                    'IL' => 'Israel',
                                                                    'IT' => 'Italy',
                                                                    'JM' => 'Jamaica',
                                                                    'JP' => 'Japan',
                                                                    'JE' => 'Jersey',
                                                                    'JO' => 'Jordan',
                                                                    'KZ' => 'Kazakhstan',
                                                                    'KE' => 'Kenya',
                                                                    'KI' => 'Kiribati',
                                                                    'KR' => 'Korea',
                                                                    'KW' => 'Kuwait',
                                                                    'KG' => 'Kyrgyzstan',
                                                                    'LA' => 'Lao People\'s Democratic Republic',
                                                                    'LV' => 'Latvia',
                                                                    'LB' => 'Lebanon',
                                                                    'LS' => 'Lesotho',
                                                                    'LR' => 'Liberia',
                                                                    'LY' => 'Libyan Arab Jamahiriya',
                                                                    'LI' => 'Liechtenstein',
                                                                    'LT' => 'Lithuania',
                                                                    'LU' => 'Luxembourg',
                                                                    'MO' => 'Macao',
                                                                    'MK' => 'Macedonia',
                                                                    'MG' => 'Madagascar',
                                                                    'MW' => 'Malawi',
                                                                    'MY' => 'Malaysia',
                                                                    'MV' => 'Maldives',
                                                                    'ML' => 'Mali',
                                                                    'MT' => 'Malta',
                                                                    'MH' => 'Marshall Islands',
                                                                    'MQ' => 'Martinique',
                                                                    'MR' => 'Mauritania',
                                                                    'MU' => 'Mauritius',
                                                                    'YT' => 'Mayotte',
                                                                    'MX' => 'Mexico',
                                                                    'FM' => 'Micronesia, Federated States Of',
                                                                    'MD' => 'Moldova',
                                                                    'MC' => 'Monaco',
                                                                    'MN' => 'Mongolia',
                                                                    'ME' => 'Montenegro',
                                                                    'MS' => 'Montserrat',
                                                                    'MA' => 'Morocco',
                                                                    'MZ' => 'Mozambique',
                                                                    'MM' => 'Myanmar',
                                                                    'NA' => 'Namibia',
                                                                    'NR' => 'Nauru',
                                                                    'NP' => 'Nepal',
                                                                    'NL' => 'Netherlands',
                                                                    'AN' => 'Netherlands Antilles',
                                                                    'NC' => 'New Caledonia',
                                                                    'NZ' => 'New Zealand',
                                                                    'NI' => 'Nicaragua',
                                                                    'NE' => 'Niger',
                                                                    'NG' => 'Nigeria',
                                                                    'NU' => 'Niue',
                                                                    'NF' => 'Norfolk Island',
                                                                    'MP' => 'Northern Mariana Islands',
                                                                    'NO' => 'Norway',
                                                                    'OM' => 'Oman',
                                                                    'PK' => 'Pakistan',
                                                                    'PW' => 'Palau',
                                                                    'PS' => 'Palestinian Territory, Occupied',
                                                                    'PA' => 'Panama',
                                                                    'PG' => 'Papua New Guinea',
                                                                    'PY' => 'Paraguay',
                                                                    'PE' => 'Peru',
                                                                    'PH' => 'Philippines',
                                                                    'PN' => 'Pitcairn',
                                                                    'PL' => 'Poland',
                                                                    'PT' => 'Portugal',
                                                                    'PR' => 'Puerto Rico',
                                                                    'QA' => 'Qatar',
                                                                    'RE' => 'Reunion',
                                                                    'RO' => 'Romania',
                                                                    'RU' => 'Russian Federation',
                                                                    'RW' => 'Rwanda',
                                                                    'BL' => 'Saint Barthelemy',
                                                                    'SH' => 'Saint Helena',
                                                                    'KN' => 'Saint Kitts And Nevis',
                                                                    'LC' => 'Saint Lucia',
                                                                    'MF' => 'Saint Martin',
                                                                    'PM' => 'Saint Pierre And Miquelon',
                                                                    'VC' => 'Saint Vincent And Grenadines',
                                                                    'WS' => 'Samoa',
                                                                    'SM' => 'San Marino',
                                                                    'ST' => 'Sao Tome And Principe',
                                                                    'SA' => 'Saudi Arabia',
                                                                    'SN' => 'Senegal',
                                                                    'RS' => 'Serbia',
                                                                    'SC' => 'Seychelles',
                                                                    'SL' => 'Sierra Leone',
                                                                    'SG' => 'Singapore',
                                                                    'SK' => 'Slovakia',
                                                                    'SI' => 'Slovenia',
                                                                    'SB' => 'Solomon Islands',
                                                                    'SO' => 'Somalia',
                                                                    'ZA' => 'South Africa',
                                                                    'GS' => 'South Georgia And Sandwich Isl.',
                                                                    'ES' => 'Spain',
                                                                    'LK' => 'Sri Lanka',
                                                                    'SD' => 'Sudan',
                                                                    'SR' => 'Suriname',
                                                                    'SJ' => 'Svalbard And Jan Mayen',
                                                                    'SZ' => 'Swaziland',
                                                                    'SE' => 'Sweden',
                                                                    'CH' => 'Switzerland',
                                                                    'SY' => 'Syrian Arab Republic',
                                                                    'TW' => 'Taiwan',
                                                                    'TJ' => 'Tajikistan',
                                                                    'TZ' => 'Tanzania',
                                                                    'TH' => 'Thailand',
                                                                    'TL' => 'Timor-Leste',
                                                                    'TG' => 'Togo',
                                                                    'TK' => 'Tokelau',
                                                                    'TO' => 'Tonga',
                                                                    'TT' => 'Trinidad And Tobago',
                                                                    'TN' => 'Tunisia',
                                                                    'TR' => 'Turkey',
                                                                    'TM' => 'Turkmenistan',
                                                                    'TC' => 'Turks And Caicos Islands',
                                                                    'TV' => 'Tuvalu',
                                                                    'UG' => 'Uganda',
                                                                    'UA' => 'Ukraine',
                                                                    'AE' => 'United Arab Emirates',
                                                                    'GB' => 'United Kingdom',
                                                                    'US' => 'United States',
                                                                    'UM' => 'United States Outlying Islands',
                                                                    'UY' => 'Uruguay',
                                                                    'UZ' => 'Uzbekistan',
                                                                    'VU' => 'Vanuatu',
                                                                    'VE' => 'Venezuela',
                                                                    'VN' => 'Viet Nam',
                                                                    'VG' => 'Virgin Islands, British',
                                                                    'VI' => 'Virgin Islands, U.S.',
                                                                    'WF' => 'Wallis And Futuna',
                                                                    'EH' => 'Western Sahara',
                                                                    'YE' => 'Yemen',
                                                                    'ZM' => 'Zambia',
                                                                    'ZW' => 'Zimbabwe'
                                                                ); ?>
                                                                <select name="Country" id="Country" class="txtbox" style="width: 200px;">
                                                                    <option value="" <?php echo $emp_data['Country'] ? "selected" : ""; ?>>Select...</option>
                                                                    <?php foreach($countries as $key => $value) : ?>
                                                                    <option value="<?php echo $value; ?>" <?php echo $emp_data['Country'] == $key ? "selected" : ""; ?>><?php echo $value; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select><br><span style="font-size: 10px;"><span class="lorangetext">*</span>  Country</span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table><br>
                                        <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                                            <tr>
                                                <td><span class="lorangetext">*</span> Home No.<br/><input attribute="Home Number" type="text" name="HomeNumber" size="20" id="HomeNumber" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['HomeNumber']; ?>"></td>
                                                <td><span class="lorangetext">*</span> Mobile No.<br/><input attribute="Mobile Number" type="text" name="MobileNumber" size="20" id="MobileNumber" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['MobileNumber']; ?>"></td>
                                                <td colspan="2"><span class="lorangetext">*</span> E-mail<br/><input attribute="E-mail Address" type="text" name="EmailAdd" size="30" id="EmailAdd" onChange="checkemail()" class="txtbox" value="<?php echo $emp_data['EmailAdd']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><span class="lorangetext">*</span>  Date of Birth <b><font size="-2">(yyyy-mm-dd)</font></b>
                                                    <br><input type="text" name="BirthDate" size="10" id="BirthDate" class="datepick2 txtbox" value="<?php if  ($emp_data['BirthDate'] != NULL) : echo date("Y-m-d", strtotime($emp_data['BirthDate'])); else : echo date("Y-m-d", strtotime("-16 years")); endif; ?>" maxlength="10">
                                                </td>
                                                <td><span class="lorangetext">*</span>  Place of Birth<br><input attribute="Birthplace" type="text" name="BirthPlace" size="25" id="BirthPlace" value="<?php echo $emp_data['BirthPlace'] ? $emp_data['BirthPlace'] : ""; ?>" class="txtbox"></td>
                                                <td><span class="lorangetext">*</span>  Gender<br>
                                                    <select name="Gender" id="Gender" class="txtbox">
                                                        <option value="M" <?php echo $emp_data['Gender'] == "M" ? 'selected' : ''; ?>>Male</option>
                                                        <option value="F" <?php echo $emp_data['Gender'] == "F" ? 'selected' : ''; ?>>Female</option>
                                                    </select>
                                                </td>
                                                <td><span class="lorangetext">*</span>  Civil Status
                                                    <select name="Status" id="Status" class="txtbox">
                                                        <option value="S" <?php echo $emp_data['Status'] == "S" ? 'selected' : ''; ?>>Single</option>
                                                        <option value="M" <?php echo $emp_data['Status'] == "M" ? 'selected' : ''; ?>>Married</option>
                                                        <option value="W" <?php echo $emp_data['Status'] == "W" ? 'selected' : ''; ?>>Widowed</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="lorangetext">*</span>  Social Security Number<input attribute="SSS Number" type="text" name="SSSNbr" id="SSSNbr" size="20" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['SSSNbr']; ?>"></td>
                                                <td><span class="lorangetext">*</span>  Tax Identification Number<input attribute="TIN Number" type="text" name="TINNbr" id="TINNbr" size="20" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['TINNbr']; ?>"></td>
                                                <td><span class="lorangetext">*</span>  Philhealth Number<input attribute="Philhealth Number" type="text" name="PhilHealthNbr" id="PhilHealthNbr" size="20" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['PhilHealthNbr']; ?>"></td>
                                                <td><span class="lorangetext">*</span>  HDMF Number<input attribute="HDMF Number" type="text" name="PagibigNbr" id="PagibigNbr" size="20" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['PagibigNbr']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><span class="lorangetext">*</span> Citizenship <input attribute="Citizenship" type="text" name="Citizenship" id="Citizenship" size="30" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['Citizenship']; ?>"></td>
                                                <td colspan="2"><span class="lorangetext">*</span> Religion <input attribute="Religion" type="text" name="Religion" id="Religion" size="30" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['Religion']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td><span class="lorangetext">*</span>  Blood Type<br><select attribute="Blood Type" type="text" name="BloodType" id="BloodType" onChange="upperCase(this)" class="txtbox">
                                                        <option value="A"<?php echo $emp_data['BloodType'] == 'A' ? ' selected' : ''; ?>>A</option>
                                                        <option value="B"<?php echo $emp_data['BloodType'] == 'B' ? ' selected' : ''; ?>>B</option>
                                                        <option value="AB"<?php echo $emp_data['BloodType'] == 'AB' ? ' selected' : ''; ?>>B</option>
                                                        <option value="O"<?php echo $emp_data['BloodType'] == 'O' ? ' selected' : ''; ?>>O</option>
                                                    </select>
                                                    </td>
                                                <td><span class="lorangetext">*</span>  Skin Complexion<br><input attribute="Skin Complexion" type="text" name="SkinComplexion" id="SkinComplexion" size="20" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['SkinComplexion']; ?>"></td>
                                                <td><span class="lorangetext">*</span>  Height<br><input attribute="Height" type="text" name="Height" id="Height" size="10" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['Height']; ?>"> ft-in</td>
                                                <td><span class="lorangetext">*</span>  Weight<br><input attribute="Weight" type="text" name="Weight" id="Weight" size="10" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['Weight']; ?>"> lbs</td>
                                            </tr>
                                        </table>
                                        <br />

                                        <b>Family Background</b>
                                        <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;" id="tblFamily">
                                            <?php if ($family_data) : ?>
                                            <?php foreach ($family_data as $key => $value) : ?>
                                                <tr>
                                                    <td width="20%">
                                                        Relationship<br>
                                                        <select type="text" name="FamRelation[<?php echo $key; ?>]" id="FamRelation[<?php echo $key; ?>]" class="txtbox width135">
                                                            <option value="FATHER"<?php echo $value['Relation'] == "FATHER" ? ' selected' : ''; ?>>FATHER</option>
                                                            <option value="MOTHER"<?php echo $value['Relation'] == "MOTHER" ? ' selected' : ''; ?>>MOTHER</option>
                                                            <option value="SIBLING"<?php echo fnmatch("SIBLING*", $value['Relation']) ? ' selected' : ''; ?>>SIBLING</option>
                                                            <option value="SPOUSE"<?php echo $value['Relation'] == "SPOUSE" ? ' selected' : ''; ?>>SPOUSE</option>
                                                            <option value="CHILD"<?php echo fnmatch("CHILD*", $value['Relation']) ? ' selected' : ''; ?>>CHILD</option>
                                                        </select>
                                                    </td>
                                                    <td width="40%">
                                                        Name<br>
                                                        <input type="text" name="FamName[<?php echo $key; ?>]" size="30" id="FamName[<?php echo $key; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php echo $value['Name']; ?>">
                                                    <td width="20%">
                                                        Birthday<br>
                                                        <input type="text" name="FamBirthDate[<?php echo $key; ?>]" size="10" id="FamBirthDate[<?php echo $key; ?>]"  value="<?php echo $value['BirthDate'] ? date("Y-m-d", strtotime($value['BirthDate'])) : date("Y-m-d"); ?>" class="datepickchild txtbox">
                                                    </td>
                                                    <td width="20%">
                                                        Profession<br>
                                                        <input type="text" name="FamOccupation[<?php echo $key; ?>]" size="20" id="FamOccupation[<?php echo $key; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php echo $value['Occupation']; ?>">
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td width="20%">
                                                        Relationship<br>
                                                        <select type="text" name="FamRelation[0]" id="FamRelation[0]" class="txtbox width135">
                                                            <option value="FATHER">FATHER</option>
                                                            <option value="MOTHER">MOTHER</option>
                                                            <option value="SIBLING">SIBLING</option>
                                                            <option value="SPOUSE">SPOUSE</option>
                                                            <option value="CHILD">CHILD</option>
                                                        </select>
                                                    </td>
                                                    <td width="40%">
                                                        Name<br>
                                                        <input type="text" name="FamName[0]" size="30" id="FamName[0]" onChange="upperCase(this)" class="txtbox" value="">
                                                    <td width="20%">
                                                        Birthday<br>
                                                        <input type="text" name="FamBirthDate[0]" size="10" id="FamBirthDate[0]"  value="<?php echo date("Y-m-d"); ?>" class="datepickchild txtbox">
                                                    </td>
                                                    <td width="20%">
                                                        Profession<br>
                                                        <input type="text" name="FamOccupation[0]" size="20" id="FamOccupation[0]" onChange="upperCase(this)" class="txtbox" value="">
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </table><br>

                                        <input type="button" class="addFamily btn" attribute="<?php echo $family_data ? count($family_data) : "1"; ?>" value="Add Family" /><br><br>



                                        <br /><b>Education History</b>
                                        <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;" id="tblSchool">
                                            <tr>
                                                <td width="20%" align="center">Attainment</td>
                                                <td width="40%" align="center">School</td>
                                                <td width="20%" align="center">Year</td>
                                                <td width="20%" align="center">Course</td>
                                            </tr>

                                            <?php if ($education_data) : ?>
                                            <?php foreach ($education_data as $key => $value) : ?>
                                            <tr>
                                                <td class="valign-bottom centertalign">
                                                    <select type="text" name="EducAttainment[<?php echo $key; ?>]" id="EducAttainment[<?php echo $key; ?>]" class="txtbox width135">
                                                        <option value="COLLEGE GRADUATE"<?php echo $value['EducAttainment'] == "COLLEGE GRADUATE" ? ' selected' : ''; ?>>COLLEGE GRADUATE</option>
                                                        <option value="COLLEGE LEVEL"<?php echo $value['EducAttainment'] == "COLLEGE LEVEL" ? ' selected' : ''; ?>>COLLEGE LEVEL</option>
                                                        <option value="TWO YEARS COURSE"<?php echo $value['EducAttainment'] == "TWO YEARS COURSE" ? ' selected' : ''; ?>>TWO YEARS COURSE</option>
                                                        <option value="VOCATIONAL"<?php echo $value['EducAttainment'] == "VOCATIONAL" ? ' selected' : ''; ?>>VOCATIONAL</option>
                                                    </select>
                                                </td>
                                                <td><input attribute="School Name" type="text" name="School[<?php echo $key; ?>]" size="50" id="School[<?php echo $key; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php echo $value['School']; ?>"></td>
                                                <td class="valign-bottom centertalign"><input type="text" name="YearGraduated[<?php echo $key; ?>]" size="10" id="YearGraduated[<?php echo $key; ?>]" class="txtbox" value="<?php echo $value['YearGraduated']; ?>"></td>

                                                <td class="valign-bottom centertalign"><input type="text" name="Course[<?php echo $key; ?>]" size="30" id="Course[<?php echo $key; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php echo $value['Course']; ?>"></td>
                                            </tr>
                                            <?php endforeach; ?>
                                            <?php else : ?>
                                            <tr>
                                                <td class="valign-bottom centertalign">
                                                    <select type="text" name="EducAttainment[0]" id="EducAttainment[0]" class="txtbox width135">
                                                        <option value="COLLEGE GRADUATE">COLLEGE GRADUATE</option>
                                                        <option value="COLLEGE LEVEL">COLLEGE LEVEL</option>
                                                        <option value="TWO YEARS COURSE">TWO YEARS COURSE</option>
                                                        <option value="VOCATIONAL">VOCATIONAL</option>
                                                    </select>
                                                </td>
                                                <td><input attribute="School Name" type="text" name="School[0]" size="50" id="School[0]" onChange="upperCase(this)" class="txtbox" value=""></td>
                                                <td class="valign-bottom centertalign"><input type="text" name="YearGraduated[0]" size="10" id="YearGraduated[0]" class="txtbox" value=""></td>

                                                <td class="valign-bottom centertalign"><input type="text" name="Course[0]" size="30" id="Course[0]" onChange="upperCase(this)" class="txtbox" value=""></td>
                                            </tr>
                                            <?php endif; ?>
                                        </table>
                                        <br>

                                        <input type="button" class="addSchool btn" attribute="<?php echo $education_data ? count($education_data) + 1 : "1"; ?>" value="Add School" /><br><br>





                                        <br /><b>Previous Work</b>
                                        <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;" id="tblHistory">
                                            <tr>
                                                <td width="40%" align="center">COMPANY NAME</td>
                                                <td width="20%" align="center">POSITION HELD</td>
                                                <td width="40%" align="center">DATES EMPLOYED</td>
                                            </tr>
                                            <?php if ($prevwork_data) : ?>
                                                <?php foreach ($prevwork_data as $key => $value) : ?>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="PrevCompany[<?php echo $key; ?>]" size="45" id="PrevCompany[<?php echo $key; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php echo $value['PrevCompany']; ?>">
                                                        </td>
                                                        <td class="valign-center">
                                                            <input type="text" name="PrevPosition[<?php echo $key; ?>]" size="20" id="PrevPosition[<?php echo $key; ?>]" onChange="upperCase(this)" class="txtbox" value="<?php echo $value['PrevPosition']; ?>">
                                                        </td>
                                                        <td class="valign-center">
                                                            From <input type="text" name="DateStarted[<?php echo $key; ?>]" size="10" id="DateStarted[<?php echo $key; ?>]" class="datepick2 txtbox" value="<?php echo date("Y-m-d", strtotime($value['DateStarted'])); ?>">&nbsp;&nbsp;&nbsp;To <input type="text" name="DateResigned[<?php echo $key; ?>]" size="10" id="DateResigned[<?php echo $key; ?>]" class="datepick2 txtbox" value="<?php echo date("Y-m-d", strtotime($value['DateResigned'])); ?>">
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <?php for($i=0; $i<=3; $i++) : ?>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="PrevCompany[<?php echo $i; ?>]" size="45" id="PrevCompany[<?php echo $i; ?>]" onChange="upperCase(this)" class="txtbox" value="">
                                                        </td>
                                                        <td class="valign-center">
                                                            <input type="text" name="PrevPosition[<?php echo $i; ?>]" size="20" id="PrevPosition[<?php echo $i; ?>]" onChange="upperCase(this)" class="txtbox">
                                                        </td>
                                                        <td class="valign-center">
                                                            From <input type="text" name="DateStarted[<?php echo $i;  ?>]" size="10" id="DateStarted[<?php echo $i; ?>]" class="datepick2 txtbox" value="<?php echo date("Y-m-d"); ?>">&nbsp;&nbsp;&nbsp;To <input type="text" name="DateResigned[<?php echo $i;  ?>]" size="10" id="DateResigned[<?php echo $i;  ?>]" value="<?php echo date("Y-m-d"); ?>" class="datepick2 txtbox">
                                                        </td>
                                                    </tr>
                                                <?php endfor; ?>
                                            <?php endif; ?>
                                        </table>
                                        <br><input type="button" class="addPrevWork btn" attribute="<?php echo $prevwork_data ? count($prevwork_data) + 1 : "5"; ?>" value="Add Previous Work" /><br><br>

                                        <br /><b>Corporate Information</b>
                                        <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                                            <tr>

                                                <td><span class="lorangetext">*</span> Department:
                                                    <?php if ($dept_sel) : ?>
                                                    <select attribute="Department" name="DeptID" id="DeptID" class="txtbox" style="width: 200px;">
                                                        <option value="0" <?php echo $emp_data['emp_corpdept'] == 0 ? "selected" : ""; ?>>Select...</option>
                                                        <?php
                                                            foreach ($dept_sel as $key => $value) :
                                                            ?>
                                                                <option value="<?php echo $value['DeptID']; ?>" <?php echo $emp_data['DeptDesc'] == $value['DeptDesc'] ? "selected" : ""; ?>><?php echo strtoupper($value['DeptDesc']); ?></option>
                                                            <?php
                                                            endforeach;
                                                        ?>
                                                    </select>
                                                    <?php endif; ?>
                                                </td>


                                                <td><span class="lorangetext">*</span> Office E-mail <input attribute="Office E-mail Address" type="text" name="EmailAdd2" size="30" id="EmailAdd2" onChange="checkemail()" class="txtbox" value="<?php echo $emp_data['EmailAdd2']; ?>"></td>

                                            </tr>
                                            <tr>
                                                <td><span class="lorangetext">*</span> Office No. <input attribute="Office Number" type="text" name="OfficeNumber" size="20" id="OfficeNumber" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['OfficeNumber']; ?>"></td>
                                                <td><span class="lorangetext">*</span> Office Ext. <input attribute="Office Ext" type="text" name="OfficeExtNumber" size="20" id="OfficeExtNumber" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['OfficeExtNumber']; ?>"></td>
                                            </tr>
                                        </table>


                                        <br /><b>Person to Notify in Case of Emergency</b>
                                        <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                                            <tr>
                                                <td colspan="2"><span class="lorangetext">*</span>  In case of emergency, notify Mr. Ms. <input attribute="Contact Name to Notify" type="text" name="ContactPerson" size="45" id="ContactPerson" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['ContactPerson']; ?>"></td>
                                                <td><span class="lorangetext">*</span>  Home No <input attribute="Home Number to Notify" type="text" name="ContactTelNbr" size="15" id="ContactTelNbr" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['ContactTelNbr']; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><span class="lorangetext">*</span>  Address <input attribute="Contact Address to Notify" type="text" name="ContactAddress" size="80" id="ContactAddress" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['ContactAddress']; ?>"></td>
                                                <td><span class="lorangetext">*</span>  Mobile No <input attribute="Mobile Number to Notify" type="text" name="ContactMobileNbr" size="15" id="ContactMobileNbr" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['ContactMobileNbr']; ?>"></td>
                                            </tr>
                                        </table>
                                        <br>
                                        <div id="lasttable"></div>

                                        <div align="center">
                                            <br><input type="submit" class="bigbtn" value="Update">
                                        </div>

                                    </div>
                                    </div>
                                </form>
                            </div>

                            <?php elseif ($edit == 2) : ?>

                            <div id="uprofile2" class="div9">

                                <form name="formpro" method="post" enctype="multipart/form-data">
                                    <div id="main" style="width: 100%; height: auto; margin-top: 50px;">
                                    <div id="tabs">

                                        <b style="font-size:9px;">PRIVATE & CONFIDENTIAL</b><BR>
                                        <div style="font-size: 9px;">(<span class="lorangetext">*</span>) Field are required, please put <b>n/a</b> if not applicable</div>

                                        <br /><b>Personal Data</b>
                                        <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Full Name: <b><?php echo $emp_data['FName'].' '.$emp_data['MName'].' '.$emp_data['LName'] . " " . $emp_data['ExtensionName']; ?></b></td>
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
                                                    <option value="FEMALE"<?php echo ($emp_data['Gender'] == 'F' || $emp_data['Gender'] == 'FEMALE') ? ' selected' : ''; ?>>FEMALE</option>
                                                    <option value="MALE"<?php echo ($emp_data['Gender'] == 'M' || $emp_data['Gender'] == 'MALE') ? ' selected' : ''; ?>>MALE</option>
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
                                                <td><span class="lorangetext">*</span> Mobile No.<br/><input attribute="Mobile No." type="text" name="MobileNumber" size="20" id="MobileNumber" class="txtbox" value="<?php echo $emp_data['MobileNumber']; ?>">
																								</td>
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
                                                <td><span class="lorangetext">*</span>  Personal E-mail<br><input attribute="Personal E-mail" type="text" name="EmailAdd2" size="20" id="EmailAdd2" class="txtbox" value="<?php echo $emp_data['EmailAdd2']; ?>"><input type="button" id="samplebutton"></td>
                                                <td><span class="lorangetext">*</span> Corporate E-mail<br/><input attribute="Corporate E-mail" type="text" name="EmailAdd" size="20" id="EmailAdd" class="txtbox" value="<?php echo $emp_data['EmailAdd']; ?>"></td>
                                            </tr>
                                        </table><br>
										<table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                                            <tr>
												<td><span class="lorangetext"></span> BloodType<br/>
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
                                        <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                                            <tr>
                                                <td>TIN No: <b><?php echo $emp_data['TINNbr']; ?></b></td>
                                                <td>SSS No: <b><?php echo $emp_data['SSSNbr']; ?></b></td>
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
																<input attribute="Unit/Street" type="text" name="OffUnitStreet" size="30" id="OffUnitStreet" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['OffUnitStreet']; ?>"><br><span style="font-size: 10px;"><span class="lorangetext">*</span> Unit/Street</span>
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
																<input type="text" name="OffZip" size="10" id="OffZip" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['OffZip'] ? $emp_data['Zip'] : "1000"; ?>"><br><span style="font-size: 10px;"><span class="lorangetext">*</span>  ZIP Code</span>
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
                                                            <td> &nbsp;
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
                                                <td><span class="lorangetext">*</span> Mother's Maiden Name<br><input attribute="Mother's Maiden Name" type="text" name="MotherMaiden" size="30" id="MotherMaiden" class="txtbox" value="<?php echo $emp_data['MotherMaiden']; ?>"></td>
                                            </tr>
                                        </table><br>
                                        <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                                            <tr>
                                                <td><span class="lorangetext">*</span> Spouse Name<br><input attribute="Spouse Name" type="text" name="SpouseName" size="30" id="SpouseName" class="txtbox" value="<?php echo $emp_data['SpouseName']; ?>"></td>
                                                <td><span class="lorangetext">*</span> Spouse Occupation<br/><input attribute="Spouse Occupation" type="text" name="SpouseOccupation" size="30" id="SpouseOccupation" class="txtbox" value="<?php echo $emp_data['SpouseOccupation']; ?>"></td>
                                            </tr>
                                        </table><br>
                                        <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                                            <tr>
                                                <td>Source of Income<br><input attribute="Source of Income" type="text" name="IncomeSource" size="30" id="IncomeSource" class="txtbox" value="EMPLOYMENT" readonly></td>
                                                <td><span class="lorangetext">*</span> Other Source of Income<br><input attribute="Other Source of Income" type="text" name="OtherIncomeSource" size="30" id="OtherIncomeSource" class="txtbox" value="<?php echo $emp_data['OtherIncomeSource']; ?>"></td>
                                            </tr>
                                        </table><br>
                                        <br /><b>Government Dependent/s</b>
                                        <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                                            <tr>
                                                <td colspan="4">No. of dependent<br>
                                                    <input id="dempid" type="hidden" value="<?php echo $emp_data['EmpID']; ?>">
                                                    <input id="ddbname" type="hidden" value="<?php echo $profile_dbname; ?>">
                                                    <select name="NumDependent" id="NumDependent" class="txtbox">
                                                        <?php for($i=0; $i<=10; $i++) : ?>
                                                        <option value="<?php echo $i; ?>"<?php echo $count_dep==$i ? ' selected' : ''; ?>><?php echo $i; ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                        <div id="divdependent">
                                            <?php if ($dependent_data) :
                                                $idep = 0; ?>
                                                <table cellpadding="5" cellspacing="0" class="tdataform2" style="width: 100%;">
                                                    <?php foreach ($dependent_data as $key => $value) :
                                                        ?>
                                                        <tr>
                                                            <td><span class="lorangetext">*</span> Name<br><input attribute="Dependent Name" type="text" name="Dependent[<?php echo $idep; ?>]" size="35" id="Dependent<?php echo $idep; ?>" onChange="upperCase(this)" value="<?php echo $value['Dependent']; ?>" class="txtbox"></td>
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
                                                <td colspan="2"><span class="lorangetext">*</span>  Address <br><input attribute="Contact Address to Notify" type="text" name="ContactAddress" size="60" id="ContactAddress" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['ContactAddress']; ?>"><br>
                                                    <input type="checkbox" id="samewithadd" class="samewithadd" /> <label for="samewithadd">same as address above</label>
                                                </td>
                                                <td><span class="lorangetext">*</span>  Mobile No <br><input attribute="Mobile Number to Notify" type="text" name="ContactMobileNbr" size="15" id="ContactMobileNbr" onChange="upperCase(this)" class="txtbox" value="<?php echo $emp_data['ContactMobileNbr']; ?>"></td><br>
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
										    <tr>
                                                <td colspan="3" class="tinytext"><p style="text-align:justify"><input type="checkbox" id="disclaim" name="disclaim" value="1" />I declare, that all information provided herein have been made by me in good faith, verified by me, and to the best of my knowledge and belief, are true and correct as of the date indicated herein; and that I have not withheld anything which would affect the processing and evaluation of my employment, and affect the Company’s ability to perform its obligations under any potential or existing contract and/or my ability to enjoy the benefits of my employment with the Company. I expressly authorize the Company, its employees, representatives, related companies and third-party service providers to collect, use, process and share my information provided herein, with any person or organization, such as banks or other financial institutions, who may assist in the fulfillment of my employment and to use my contact details to contact me by phone, text, SMS, email or other electronic communication for verification or other purpose in connection with my employment. In addition hereto, I hereby agree and consent that those information possessed and collected by the Company may be used and processed for the following reasons, but is not limited to: processing my employment records; determining and reviewing salaries, incentives, bonuses and other benefits; consideration for promotion, career development, training, transfer, performance monitoring, health and safety administration and security and access control; monitoring compliance with our internal rules and policies and adherence to our Employee Handbook; complying with the compliance and disclosure requirements of any and all governmental and/or quasi-governmental departments and/or agencies, regulatory and/or statutory body; and purposes relating thereto. I fully understand that my continued employment with the Company is deemed consent for it collect, process and store the data in accordance with the above. My failure to consent to the above may result in the Company’s inability to perform its obligations under any potential or existing contract and/or my ability to enjoy the benefits of my employment with the Company.</p></td>
                                            </tr>
                                        </table>
                                        <br>
                                        <div id="lasttable"></div>

                                        <div align="center">
                                            <input type="hidden" name="empnum" id="empnum" value="<?php echo $emp_data['EmpID']; ?>" />
                                            <input type="hidden" name="dbname" id="dbname" value="<?php echo $profile_dbname; ?>" />
                                            <input type="hidden" name="LName" id="LName" value="<?php echo $emp_data['LName']; ?>" />
                                            <input type="hidden" name="FName" id="FName" value="<?php echo $emp_data['FName']; ?>" />
                                            <input type="hidden" name="MName" id="MName" value="<?php echo $emp_data['MName']; ?>" />
                                            <br><input type="submit" class="bigbtn" value="Update">
                                        </div>

                                    </div>
                                    </div>
                                </form>
                            </div>

                            <?php else : ?>

                            <div id="memodiv9" class="div9 whitetext">
                                <div id="idpic" class="idpic">
                                    <div id="picturediv">
                                    <?php if ($profile_pic) : ?>
                                        <img src="<?php echo PAYWEB; ?>/imageuploader/<?php echo $profile_pic; ?>" width="200" height="200" />
                                    <?php else : ?>
                                        <?php if ($emp_data['Gender'] == 'F') : ?>
                                        <img src="<?php echo IMG_WEB; ?>/davatar_female.png" width="200" height="200" />
                                        <?php else : ?>
                                        <img src="<?php echo IMG_WEB; ?>/davatar_male.png" width="200" height="200" />
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    </div>
                                </div>

                                <div class="profile_info">
                                    <b class="mediumtext lorangetext"><?php echo strtoupper($emp_data['LName']).', '.strtoupper($emp_data['FName']).' '.strtoupper($emp_data['MName']); ?></b><br><br>
                                    <div class="lorangetext roboto cattext2">Personal Information</div>
                                    <div>
                                        <p>
                                            <b><?php echo ucfirst($profile_nadd); ?> No.:</b> <?php echo $emp_data['EmpID']; ?><br/>
                                            <!--b>Position:</b> <?php echo $emp_data['PositionDesc']; ?><br/-->
                                            <b>Date Hired:</b> <?php echo date("F j, Y", strtotime($emp_data['HireDate'])); ?><br/>
                                            <b>Nickname:</b> <?php echo $emp_data['NickName']; ?><br/>
                                            <b>Address:</b> <?php echo $emp_data['UnitStreet']; ?>, <?php echo $emp_data['Barangay'] ? $emp_data['Barangay'].', ' : ''; ?><?php echo $emp_data['TownCity']; ?> <?php echo $emp_data['Zip']; ?><br/>
                                            <b>Contact No.:</b> <?php echo $emp_data['MobileNumber']; ?><br/>
                                            <b>Personal Email:</b> <?php echo $emp_data['EmailAdd2']; ?><br/>
                                            <b>Corporate Email:</b> <?php echo $emp_data['EmailAdd']; ?><br/>
                                            <!--b>Birthdate:</b> <?php echo date("F j, Y", strtotime($emp_data['BirthDate'])); ?><br/-->
                                            <b>Birthplace:</b> <?php echo $emp_data['BirthPlace']; ?><br/>
                                            <b>Gender:</b> <?php echo $emp_data['Gender'][0] == "F" ? "FEMALE" : "MALE"; ?><br/>
                                            <!--b>Civil Status:</b> <?php if ($emp_data['Status'][0] == 'S') : echo "SINGLE"; elseif ($emp_data['Status'][0] == 'M') : echo "MARRIED"; else : echo "WIDOWED"; endif; ?><br/-->
                                            <b>SSS No.:</b> <?php echo $emp_data['SSSNbr']; ?><br/>
                                            <b>TIN No.:</b> <?php echo $emp_data['TINNbr']; ?><br/>
                                            <b>PhilHealth No.:</b> <?php echo $emp_data['PhilHealthNbr']; ?><br/>
                                            <b>Pag-IBIG No.:</b> <?php echo $emp_data['PagibigNbr']; ?><br/><br/>
                                        </p>
                                    </div>
                                    <?php if ($family_data) : ?>
                                    <div class="lorangetext roboto cattext2">Family Background</div>
                                    <div>
                                        <p>

                                            <table class="tdataform">
                                                <tr>
                                                    <th width="20%" align="center">&nbsp;</th>
                                                    <th width="30%" align="center">Name</th>
                                                    <th width="25%" align="center">Birthday</th>
                                                    <th width="25%" align="center">Profession</th>
                                                </tr>
                                                <?php foreach($family_data as $key => $value) : ?>
                                                <tr>
                                                    <td><b><?php echo $value['Relation']; ?></b></td>
                                                    <td><?php echo $value['Name']; ?></td>
                                                    <td align="center"><?php echo $value['BirthDate'] ? date("F j, Y", strtotime($value['BirthDate'])) : 'N/A'; ?></td>
                                                    <td align="center"><?php echo $value['Occupation'] ? $value['Occupation'] : 'N/A'; ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </table><br/>
                                        </p>
                                    </div>
                                    <?php endif; ?>

                                    <?php if ($education_data || $training_data || $skill_data) : ?>
                                    <div class="lorangetext roboto cattext2">Education and Skills</div>
                                    <div>
                                        <p>
                                            <?php if ($education_data) : ?>
                                            <table class="tdataform">
                                                <tr>
                                                    <th width="20%" align="center">Level</th>
                                                    <th width="40%" align="center">Schools Name</th>
                                                    <th width="20%" align="center">Year</th>
                                                    <th width="20%" align="center">Course &amp; Award Recieved</th>
                                                </tr>

                                                <?php foreach ($education_data as $value) : ?>
                                                <tr>
                                                    <td><?php echo $value['EducAttainment']; ?></td>
                                                    <td><?php echo $value['School']; ?></td>
                                                    <td class="valign-bottom centertalign"><?php echo $value['YearGraduated']; ?></td>
                                                    <td class="valign-bottom centertalign"><?php echo $value['Course'] ? $value['Course'] : "N/A"; ?></td>
                                                </tr>
                                                <?php endforeach; ?>

                                            </table><br/>
                                            <?php endif; ?>

                                            <?php if ($training_data) : ?>
                                                <table class="tdataform">
                                                    <tr>
                                                        <td width="70%" align="center">Seminars Attended</td>
                                                        <td width="30%" align="center">Date Taken</td>
                                                    </tr>
                                                    <?php foreach ($training_data as $key => $value) : ?>
                                                        <tr>
                                                            <td><?php echo $value['TrainingDesc']; ?></td>
                                                            <td class="centertalign"><?php echo date("F j, Y", strtotime($value['DateFrom'])); ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </table><br/>
                                            <?php endif; ?>

                                            <?php if ($skill_data) : ?>
                                            <b>Other Skills: </b>
                                            <?php foreach ($skill_array as $key => $value) : ?>
                                                <?php echo $key != 0 ? ",&nbsp;" : ""; ?><?php echo $value['Competency']; ?>
                                            <?php endforeach; ?><br/><br/>
                                            <?php endif; ?>

                                        </p>
                                    </div>
                                    <?php endif; ?>

                                    <?php if ($prevwork_data) : ?>
                                    <div class="lorangetext roboto cattext2">Previous Work</div>
                                    <div>
                                        <p>
                                            <table class="tdataform">
                                                <tr>
                                                    <th width="35%" align="center">COMPANY NAME</th>
                                                    <th width="25%" align="center">POSITION HELD</th>
                                                    <th width="20%" align="center">REASON FOR LEAVING</th>
                                                    <th width="20%" align="center">DATES EMPLOYED</th>
                                                </tr>
                                                <?php foreach ($prevwork_data as $key => $value) : ?>
                                                    <tr>
                                                        <td>
                                                            <b><?php echo $value['PrevCompany']; ?></b>
                                                        </td>
                                                        <td class="valign-center">
                                                            <?php echo $value['PrevPosition']; ?>
                                                        </td>
                                                        <td class="valign-center">
                                                            <?php echo stripslashes($value['Reason']) ? stripslashes($value['Reason']) : "N/A"; ?>
                                                        </td>
                                                        <td class="valign-center">
                                                            <b>From:</b><br/><?php echo date("F j, Y", strtotime($value['DateStarted'])); ?><br>
                                                            <b>To:</b><br/><?php echo date("F j, Y", strtotime($value['DateResigned'])); ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </table><br/>
                                        </p>
                                    </div>
                                    <?php endif; ?>

                                    <?php if ($emp_data['ContactPerson']) : ?>
                                    <div class="lorangetext roboto cattext2">Person to Notify in Case of Emergency</div>
                                    <div>
                                        <p>
                                            <b>Name:</b> <?php echo $emp_data['ContactPerson']; ?><br/>
                                            <b>Address:</b> <?php echo $emp_data['ContactAddress']; ?><br/>
                                            <b>Tel. No.:</b> <?php echo $emp_data['ContactTelNbr'] ? $emp_data['ContactTelNbr'] : 'N/A'; ?><br/>
                                            <b>Mobile No.:</b> <?php echo $emp_data['ContactMobileNbr'] ? $emp_data['ContactMobileNbr'] : 'N/A'; ?>
                                        </p>
                                    </div>
                                    <?php endif; ?>

                                    <div align="center">
                                        <br><a href="<?php echo WEB; ?>/profile?edit=2"><input type="button" class="btn" value="Update My ID Profile"></a>
                                    </div>


                                </div>

                            </div>

                            <?php endif; ?>

                            <?php endforeach; ?>
                        </div>
                    </div>
    <?php include(TEMP."/footer.php"); ?>


		<script>

		$(document).ready(function (){

			$('#MobileNumber').inputmask({"mask": "9999 999 9999"});

			// $("#EmailAdd2").inputmask("{1,20}@{1,20}.*{3}");

			Inputmask("email").mask("#EmailAdd2");

			//email mask
		  // $("#EmailAdd2").inputmask({
		  //   mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
		  //   greedy: false,
		  //   onBeforePaste: function (pastedValue, opts) {
		  //     pastedValue = pastedValue.toLowerCase();
		  //     return pastedValue.replace("mailto:", "");
		  //   },
		  //   definitions: {
		  //     '*': {
		  //       validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
		  //       casing: "lower"
		  //     }
		  //   }
		  // });


			$("#samplebutton").on('click', function(){

				// var userinput = $('#EmailAdd2').val();
				// var pattern = "/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i";
				//
				// if(!(pattern.test(userinput)))
				// {
				//   alert('not a valid e-mail address');
				// }​

				var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
				if(userinput.match(mailformat))
				{
				alert("Valid email address!");
				}
				else
				{
				alert("You have entered an invalid email address!");
				}

				// if(!($('#EmailAdd2').inputmask("isComplete"))){
				// 	alert("Your personal e-mail address is either incomplete or incorrect.");
				// }else{
				// 	alert($('#EmailAdd2').inputmask("isComplete"));
				// }

			});



		});



		</script>
