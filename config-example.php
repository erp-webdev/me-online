<?php

# MAINTENANCE
$maintenance = 0;

if ($maintenance) :
    echo "<script language='javascript' type='text/javascript'>window.location.href='https://dev.megaworldcorp.com/me/indexmnt.php'</script>";
endif;

# IP TO BLOCK
$iptoaccess = $_SERVER['REMOTE_ADDR'];

session_start();

# ERROR HANDLING
error_reporting(1);
ini_set('error_reporting', E_ALL-E_NOTICE);
ini_set('display_errors', 1);

# TEMPLATE VERSION
if ($_GET['temp']) define("VERSION", $_GET['temp']);
else define("VERSION", "2015");

	# DATABASE CONNECTION
	define("DBHOST", "192.168.13.33");
	define("DBUSER", "SUBSONLINE");
	define("DBPASS", "Br5K8-e&");
	define("DBNAME", "SUBSIDIARY");

	define("DBHOST1", "192.168.13.33");
	define("DBUSER1", "kayag");
	define("DBPASS1", "Kevs0430$");
    define("DBNAME1", "DBPMS7");

	# MAIL DATABASE CONNECTION
	define("MAIL_DBHOST", "mw-onlinedb02");
	define("MAIL_DBUSER", "root");
    define("MAIL_DBPASS", "MEGAWORLDadm1n");
	define("MAIL_DBNAME", "mailq");


    $comp = $_SESSION['ssep_comp'];

    //var_dump($comp);
    define("SITENAME", "ME ONLINE");
    define("SYSTEMNAME", "ME ONLINE");
    define("WELCOME", "Welcome to ME Online");
    define("COMPNAME", "Megaworld Corporation and its subsidiary");

    //var_dump(DBNAME);

	$doc_root = dirname(__FILE__);

	# WEB FOLDERS
	define("ROOT", "https://dev.megaworldcorp.com:8081/me");
	define("UNIWEB", "https://dev.megaworldcorp.com:8081/me");
	define("PAYWEB", "https://dev.megaworldcorp.com:8081/megapay");
	define("WEB", ROOT);
	define("JSCRIPT", WEB."/js");
	define("JS", WEB."/script");
	define("CSS", WEB."/css");
	define("UFILE", WEB."/files");
	define("LIB_WEB", WEB."/lib");
	define("CLASSES_WEB", WEB."/lib/class");
	define("IMG_WEB", WEB."/images");
	define("REQUEST_WEB", WEB."/requests");
	define("OBJ_WEB", WEB."/objects/".VERSION);
	define("TEMP_WEB", WEB."/template/".VERSION);

	define("DOCUMENT", $doc_root);
	define("LIB", DOCUMENT."/lib");
	define("CLASSES", DOCUMENT."/lib/class");
	define("IMG", DOCUMENT."/images");
	define("FILES_DIR", DOCUMENT."/images/files");
	define("REQUEST", DOCUMENT."/requests");
	define("OBJROOT", DOCUMENT."/objects");
	define("OBJ", DOCUMENT."/objects/".VERSION);
	define("TEMP", DOCUMENT."/template/".VERSION);

define("ADMIN_CONTACT", "802-9592, 802-9593, 802-9597 or 802-9598");
define("TECH_CONTACT", "local 8324");
define("ADMIN_EMAIL", "TECHSERVE@megaworldcorp.com");

define("NOTIFICATION_EMAIL", "noreply@alias.megaworldcorp.com");
define("MAIL_TEST", true);

$sroot = ROOT;
$wwwroot = WWW;

# INCLUDE CLASS
include(CLASSES."/tblsql.class.php");
include(CLASSES."/logsql.class.php");
include(CLASSES."/mail.class.php");
//include(CLASSES."/validation.class.php");
//include(CLASSES."/extra.class.php");

# INITIATE CLASS
$tblsql		 		    = new tblsql;
$logsql 			 	= new logsql;
$mails 			 	= new mails;


//$validation		 	= new validation;
//$extra  			 	= new extra;

# PAGINATION
define("QS_VAR", "page"); // the variable name inside the query string (don't use this name inside other links)
define("STR_FWD", "&gt;"); // the string is used for a link (step forward)
define("STR_BWD", "&lt;"); // the string is used for a link (step backward)
define("NUM_LINKS", 5); // the number of links inside the navigation (the default value)
define("NUM_ROWS", 10);
define("NOTI_NUM_ROWS", 10); // row numbers of notifications
define("APPR_NUM_ROWS", 10); // row numbers of approvers management
define("ACT_NUM_ROWS", 4); // row numbers of activity
define("MEMO_NUM_ROWS", 8); // row numbers of memo
define("GAL_NUM_ROWS", 12);
define("DIR_NUM_ROWS", 20);
define("LOGS_NUM_ROWS", 15); // row numbers of logs
define("REQ_NUM_ROWS", 5); // row numbers of logs

# MAIL
define("MAILFOOT", "For any concerns regarding ME Online, please contact the Megaworld Payroll Department @ 802-9592, 802-9593, 802-9597 or 802-9598. This email is system generated, please do not reply. ");

# USER COOKIE
$usercook = unserialize($_COOKIE['mega1_cookie']);
$cookname = $usercook['user_name'];
define("COOKNAME", $cookname);

if (isset($_COOKIE['mega1_cookie'])){
	$spot_cookie = 1;
	define("COOKNAME", strtoupper(COOKNAME));
	define("COOKNAME2", COOKNAME);
}

#DATE VARIABLE
date_default_timezone_set('UTC+8');

$date10year = date("Y-m-d", strtotime("-10 year"));
$date1year = date("Y-m-d", strtotime("-1 year"));
$date6month = date("Y-m-d", strtotime("-6 month"));
$date3month = date("Y-m-d", strtotime("-3 month"));
$date1month = date("Y-m-d", strtotime("-1 month"));
$date2week = date("Y-m-d", strtotime("-2 weeks"));
$date1week = date("Y-m-d", strtotime("-1 weeks"));
$date1day = date("Y-m-d", strtotime("-1 days"));
$datenow = date("Y-m-d");

$unix3month = date("U", strtotime("+3 month"));

define("UNIX3MONTH", $unix3month);

//WELCOME REMARKS
$welcome = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?";

//WEB FOOTER
$wfooter = "For any inquiries regarding ME-Online contents and technical assistance, contact: Information Systems Management.<br>Email:<a href='mailto:".ADMIN_EMAIL."'>".ADMIN_EMAIL."</a> with a clear description of your request or call us at ".TECH_CONTACT.".";

//DEFAULT TIME IN AND OUT
$def_timein = '08:30:00';
$def_timeout = '17:30:00';


$adminarray2 = array("2007-05-M483", "2010-06-V464", "2010-06-V613", "2012-09-U693", "2014-03-N605", "2013-08-N300", "2011-04-V850", "2012-01-U209", "2013-09-N361", "2010-02-M669", "2008-06-M829", "2014-10-0003", "2014-10-0005", "2015-05-0243", "2016-09-0636", "2017-01-0792", "2015-05-0250", "2016-04-0278", "2016-04-0279", "2016-04-0280", "2017-01-0819", "2017-05-1031", "2017-05-1033", "2017-05-1034", "2017-05-1037", "2017-07-1152", "2017-07-1153", "2017-07-1166", "2017-07-1167", "2017-07-1176", "2017-09-1287", "2016-05-0422", "2014-10-0002", "2016-04-0276", "2014-10-0568", "2016-03-0261", "2017-02-0864", "2017-04-0959", "2014-01-N506", "2014-05-N791", "2017-07-1176", "2016-06-0457", "2020-04-0107","2018-08-0446","2019-09-0571","2019-02-0033","2020-03-0006", "2021-08-0289", "2021-11-0444", "2016-06-0457"); //admin's employee ID for memo separated by comma

$adminarray3 = array("2014-05-N791","2007-05-M483", "2008-06-M829", "2010-02-M669", "2010-06-V464", "2010-06-V613", "2011-04-V850", "2012-01-U209", "2012-09-U693", "2013-08-N300", "2013-09-N361", "2014-03-N605", "2014-03-N679", "2015-01-0064", "2015-05-0250", "2016-03-0241", "2016-04-0274", "2016-04-0278", "2016-04-0279", "2016-04-0280", "2016-05-0363", "2016-05-0406", "2016-05-0407", "2016-10-0695", "2017-01-0819", "2014-10-0003", "2014-10-0005", "2015-05-0243", "2016-09-0636", "2017-01-0792", "2014-10-0002", "2016-04-0276", "2016-05-0422", "2014-01-N506", "2014-10-0568", "2016-05-0338", "2015-05-0250","2017-02-0825","2017-01-0792","2016-05-0363","2016-05-0407","2016-10-0695","2016-09-0636","2016-05-0422","2017-02-0864", "2018-08-0446","2019-09-0571","2019-02-0033", "2021-08-0289", "2021-11-0444", "2016-06-0457"); //admin's employee ID for memo separated by comma
$regions = array(
																	'ARMM' => 'ARMM (Autonomous Region in Muslim Mindanao)',
																	'CAR' => 'CAR (Cordillera Administrative Region)',
																	'NCR' => 'NCR (National Capital Region)',
																	'RI' => 'Region 1 (Ilocos Region)',
																	'RII' => 'Region 2 (Cagayan Valley)',
																	'RIII' => 'Region 3 (Central Luzon)',
																	'RIVA' => 'Region 4A (CALABARZON)',
																	'RIVB' => 'Region 4B (MIMAROPA)',
																	'RV' => 'Region 5 (Bicol Region)',
																	'RVI' => 'Region 6 (Western Visayas)',
																	'RVII' => 'Region 7 (Central Visayas)',
																	'RVIII' => 'Region 8 (Eastern Visayas)',
																	'RIX' => 'Region 9 (Zamboanga Peninsula)',
																	'RX' => 'Region 10 (Northern Mindanao)',
																	'RXI' => 'Region 11 (Davao Region)',
																	'RXII' => 'Region 12 (SOCCSKSARGEN)',
																	'RXIII' => 'Region 13 (Caraga Region)'
																);

$timearray = array("06:00:00"=>"6:00AM","06:30:00"=>"6:30AM","07:00:00"=>"7:00AM","07:30:00"=>"7:30AM","08:00:00"=>"8:00AM","08:30:00"=>"8:30AM","09:00:00"=>"9:00AM","09:30:00"=>"9:30AM","10:00:00"=>"10:00AM","10:30:00"=>"10:30AM","11:00:00"=>"11:00AM","11:30:00"=>"11:30AM","12:00:00"=>"12:00NN","12:30:00"=>"12:30PM","13:00:00"=>"1:00PM","13:30:00"=>"1:30PM","14:00:00"=>"2:00PM","14:30:00"=>"2:30PM","15:00:00"=>"3:00PM","15:30:00"=>"3:30PM","16:00:00"=>"4:00PM","16:30:00"=>"4:30PM","17:00:00"=>"5:00PM","17:30:00"=>"5:30PM","18:00:00"=>"6:00PM","18:30:00"=>"6:30PM","19:00:00"=>"7:00PM","19:30:00"=>"7:30PM","20:00:00"=>"8:00PM","20:30:00"=>"8:30PM","21:00:00"=>"9:00PM","21:30:00"=>"9:30PM","22:00:00"=>"10:00PM","22:30:00"=>"10:30PM","23:00:00"=>"11:00PM");

$countries = array('AF' => 'Afghanistan', 'AX' => 'Aland Islands', 'AL' => 'Albania', 'DZ' => 'Algeria', 'AS' => 'American Samoa', 'AD' => 'Andorra', 'AO' => 'Angola', 'AI' => 'Anguilla', 'AQ' => 'Antarctica', 'AG' => 'Antigua And Barbuda', 'AR' => 'Argentina', 'AM' => 'Armenia', 'AW' => 'Aruba', 'AU' => 'Australia', 'AT' => 'Austria', 'AZ' => 'Azerbaijan', 'BS' => 'Bahamas', 'BH' => 'Bahrain', 'BD' => 'Bangladesh', 'BB' => 'Barbados', 'BY' => 'Belarus', 'BE' => 'Belgium', 'BZ' => 'Belize', 'BJ' => 'Benin', 'BM' => 'Bermuda', 'BT' => 'Bhutan', 'BO' => 'Bolivia', 'BA' => 'Bosnia And Herzegovina', 'BW' => 'Botswana', 'BV' => 'Bouvet Island', 'BR' => 'Brazil', 'IO' => 'British Indian Ocean Territory', 'BN' => 'Brunei Darussalam', 'BG' => 'Bulgaria', 'BF' => 'Burkina Faso', 'BI' => 'Burundi', 'KH' => 'Cambodia', 'CM' => 'Cameroon', 'CA' => 'Canada', 'CV' => 'Cape Verde', 'KY' => 'Cayman Islands', 'CF' => 'Central African Republic', 'TD' => 'Chad', 'CL' => 'Chile', 'CN' => 'China', 'CX' => 'Christmas Island', 'CC' => 'Cocos (Keeling) Islands', 'CO' => 'Colombia', 'KM' => 'Comoros', 'CG' => 'Congo', 'CD' => 'Congo, Democratic Republic', 'CK' => 'Cook Islands', 'CR' => 'Costa Rica', 'CI' => 'Cote D\'Ivoire', 'HR' => 'Croatia', 'CU' => 'Cuba', 'CY' => 'Cyprus', 'CZ' => 'Czech Republic', 'DK' => 'Denmark', 'DJ' => 'Djibouti', 'DM' => 'Dominica', 'DO' => 'Dominican Republic', 'EC' => 'Ecuador', 'EG' => 'Egypt', 'SV' => 'El Salvador', 'GQ' => 'Equatorial Guinea', 'ER' => 'Eritrea', 'EE' => 'Estonia', 'ET' => 'Ethiopia', 'FK' => 'Falkland Islands (Malvinas)', 'FO' => 'Faroe Islands', 'FJ' => 'Fiji', 'FI' => 'Finland', 'FR' => 'France', 'GF' => 'French Guiana', 'PF' => 'French Polynesia', 'TF' => 'French Southern Territories', 'GA' => 'Gabon', 'GM' => 'Gambia', 'GE' => 'Georgia', 'DE' => 'Germany', 'GH' => 'Ghana', 'GI' => 'Gibraltar', 'GR' => 'Greece', 'GL' => 'Greenland', 'GD' => 'Grenada', 'GP' => 'Guadeloupe', 'GU' => 'Guam', 'GT' => 'Guatemala', 'GG' => 'Guernsey', 'GN' => 'Guinea', 'GW' => 'Guinea-Bissau', 'GY' => 'Guyana', 'HT' => 'Haiti', 'HM' => 'Heard Island & Mcdonald Islands', 'VA' => 'Holy See (Vatican City State)', 'HN' => 'Honduras', 'HK' => 'Hong Kong', 'HU' => 'Hungary', 'IS' => 'Iceland', 'IN' => 'India', 'ID' => 'Indonesia', 'IR' => 'Iran, Islamic Republic Of', 'IQ' => 'Iraq', 'IE' => 'Ireland', 'IM' => 'Isle Of Man', 'IL' => 'Israel', 'IT' => 'Italy', 'JM' => 'Jamaica', 'JP' => 'Japan', 'JE' => 'Jersey', 'JO' => 'Jordan', 'KZ' => 'Kazakhstan', 'KE' => 'Kenya', 'KI' => 'Kiribati', 'KR' => 'Korea', 'KW' => 'Kuwait', 'KG' => 'Kyrgyzstan', 'LA' => 'Lao People\'s Democratic Republic', 'LV' => 'Latvia', 'LB' => 'Lebanon', 'LS' => 'Lesotho', 'LR' => 'Liberia', 'LY' => 'Libyan Arab Jamahiriya', 'LI' => 'Liechtenstein', 'LT' => 'Lithuania', 'LU' => 'Luxembourg', 'MO' => 'Macao', 'MK' => 'Macedonia', 'MG' => 'Madagascar', 'MW' => 'Malawi', 'MY' => 'Malaysia', 'MV' => 'Maldives', 'ML' => 'Mali', 'MT' => 'Malta', 'MH' => 'Marshall Islands', 'MQ' => 'Martinique', 'MR' => 'Mauritania', 'MU' => 'Mauritius', 'YT' => 'Mayotte', 'MX' => 'Mexico', 'FM' => 'Micronesia, Federated States Of', 'MD' => 'Moldova', 'MC' => 'Monaco', 'MN' => 'Mongolia', 'ME' => 'Montenegro', 'MS' => 'Montserrat', 'MA' => 'Morocco', 'MZ' => 'Mozambique', 'MM' => 'Myanmar', 'NA' => 'Namibia', 'NR' => 'Nauru', 'NP' => 'Nepal', 'NL' => 'Netherlands', 'AN' => 'Netherlands Antilles', 'NC' => 'New Caledonia', 'NZ' => 'New Zealand', 'NI' => 'Nicaragua', 'NE' => 'Niger', 'NG' => 'Nigeria', 'NU' => 'Niue', 'NF' => 'Norfolk Island', 'MP' => 'Northern Mariana Islands', 'NO' => 'Norway', 'OM' => 'Oman', 'PK' => 'Pakistan', 'PW' => 'Palau', 'PS' => 'Palestinian Territory, Occupied', 'PA' => 'Panama', 'PG' => 'Papua New Guinea', 'PY' => 'Paraguay', 'PE' => 'Peru', 'PH' => 'Philippines', 'PN' => 'Pitcairn', 'PL' => 'Poland', 'PT' => 'Portugal', 'PR' => 'Puerto Rico', 'QA' => 'Qatar', 'RE' => 'Reunion', 'RO' => 'Romania',  'RU' => 'Russian Federation', 'RW' => 'Rwanda', 'BL' => 'Saint Barthelemy', 'SH' => 'Saint Helena', 'KN' => 'Saint Kitts And Nevis', 'LC' => 'Saint Lucia', 'MF' => 'Saint Martin', 'PM' => 'Saint Pierre And Miquelon', 'VC' => 'Saint Vincent And Grenadines', 'WS' => 'Samoa', 'SM' => 'San Marino', 'ST' => 'Sao Tome And Principe', 'SA' => 'Saudi Arabia', 'SN' => 'Senegal', 'RS' => 'Serbia', 'SC' => 'Seychelles', 'SL' => 'Sierra Leone', 'SG' => 'Singapore', 'SK' => 'Slovakia', 'SI' => 'Slovenia', 'SB' => 'Solomon Islands', 'SO' => 'Somalia', 'ZA' => 'South Africa', 'GS' => 'South Georgia And Sandwich Isl.', 'ES' => 'Spain', 'LK' => 'Sri Lanka', 'SD' => 'Sudan', 'SR' => 'Suriname', 'SJ' => 'Svalbard And Jan Mayen', 'SZ' => 'Swaziland', 'SE' => 'Sweden', 'CH' => 'Switzerland', 'SY' => 'Syrian Arab Republic', 'TW' => 'Taiwan', 'TJ' => 'Tajikistan', 'TZ' => 'Tanzania', 'TH' => 'Thailand', 'TL' => 'Timor-Leste', 'TG' => 'Togo', 'TK' => 'Tokelau', 'TO' => 'Tonga', 'TT' => 'Trinidad And Tobago', 'TN' => 'Tunisia', 'TR' => 'Turkey', 'TM' => 'Turkmenistan', 'TC' => 'Turks And Caicos Islands', 'TV' => 'Tuvalu', 'UG' => 'Uganda', 'UA' => 'Ukraine', 'AE' => 'United Arab Emirates', 'GB' => 'United Kingdom', 'US' => 'United States', 'UM' => 'United States Outlying Islands', 'UY' => 'Uruguay', 'UZ' => 'Uzbekistan', 'VU' => 'Vanuatu', 'VE' => 'Venezuela', 'VN' => 'Viet Nam', 'VG' => 'Virgin Islands, British', 'VI' => 'Virgin Islands, U.S.', 'WF' => 'Wallis And Futuna', 'EH' => 'Western Sahara', 'YE' => 'Yemen', 'ZM' => 'Zambia', 'ZW' => 'Zimbabwe');

$nationality = array('Filipino', 'Afghan', 'Albanian', 'Algerian', 'American', 'Andorran', 'Angolan', 'Antiguans', 'Argentinean', 'Armenian', 'Australian', 'Austrian', 'Azerbaijani', 'Bahamian', 'Bahraini', 'Bangladeshi', 'Barbadian', 'Barbudans', 'Batswana', 'Belarusian', 'Belgian', 'Belizean', 'Beninese', 'Bhutanese', 'Bolivian', 'Bosnian', 'Brazilian', 'British', 'Bruneian', 'Bulgarian', 'Burkinabe', 'Burmese', 'Burundian', 'Cambodian', 'Cameroonian', 'Canadian', 'Cape Verdean', 'Central African', 'Chadian', 'Chilean', 'Chinese', 'Colombian', 'Comoran', 'Congolese', 'Costa Rican', 'Croatian', 'Cuban', 'Cypriot', 'Czech', 'Danish', 'Djibouti', 'Dominican', 'Dutch', 'East Timorese', 'Ecuadorean', 'Egyptian', 'Emirian', 'Equatorial Guinean', 'Eritrean', 'Estonian', 'Ethiopian', 'Fijian', 'Finnish', 'French', 'Gabonese', 'Gambian', 'Georgian', 'German', 'Ghanaian', 'Greek', 'Grenadian', 'Guatemalan', 'Guinea-Bissauan', 'Guinean', 'Guyanese', 'Haitian', 'Herzegovinian', 'Honduran', 'Hungarian', 'Icelander', 'Indian', 'Indonesian', 'Iranian', 'Iraqi', 'Irish', 'Israeli', 'Italian', 'Ivorian', 'Jamaican', 'Japanese', 'Jordanian', 'Kazakhstani', 'Kenyan', 'Kittian and Nevisian', 'Kuwaiti', 'Kyrgyz', 'Laotian', 'Latvian', 'Lebanese', 'Liberian', 'Libyan', 'Liechtensteiner', 'Lithuanian', 'Luxembourger', 'Macedonian', 'Malagasy', 'Malawian', 'Malaysian', 'Maldivan', 'Malian', 'Maltese', 'Marshallese', 'Mauritanian', 'Mauritian', 'Mexican', 'Micronesian', 'Moldovan', 'Monacan', 'Mongolian', 'Moroccan', 'Mosotho', 'Motswana', 'Mozambican', 'Namibian', 'Nauruan', 'Nepalese', 'Netherlander', 'New Zealander', 'Ni-Vanuatu', 'Nicaraguan', 'Nigerian', 'Nigerien', 'North Korean', 'Northern Irish', 'Norwegian', 'Omani', 'Pakistani', 'Palauan', 'Panamanian', 'Papua New Guinean', 'Paraguayan', 'Peruvian', 'Polish', 'Portuguese', 'Qatari', 'Romanian', 'Russian', 'Rwandan', 'Saint Lucian', 'Salvadoran', 'Samoan', 'San Marinese', 'Sao Tomean', 'Saudi', 'Scottish', 'Senegalese', 'Serbian', 'Seychellois', 'Sierra Leonean', 'Singaporean', 'Slovakian', 'Slovenian', 'Solomon Islander', 'Somali', 'South African', 'South Korean', 'Spanish', 'Sri Lankan', 'Sudanese', 'Surinamer', 'Swazi', 'Swedish', 'Swiss', 'Syrian', 'Taiwanese', 'Tajik', 'Tanzanian', 'Thai', 'Togolese', 'Tongan', 'Trinidadian or Tobagonian', 'Tunisian', 'Turkish', 'Tuvaluan', 'Ugandan', 'Ukrainian', 'Uruguayan', 'Uzbekistani', 'Venezuelan', 'Vietnamese', 'Welsh', 'Yemenite', 'Zambian', 'Zimbabwean');

// CONNECT TO DB
//$con = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
/*if (mysqli_connect_errno($con))
{
	echo "Failed to connect to database: " . mysqli_connect_error();
}*/
$con = mssql_connect(DBHOST, DBUSER, DBPASS);
if (!$con) {
    die('Something went wrong while connecting to database<br>'.mssql_get_last_message(void));
}

//EMAIL INIT
/*ini_set("SMTP", "mail.megaworldcorp.com");
ini_set("smtp_port", "587");
ini_set("sendmail_from", "noreply2@megaworldcorp.com");*/

?>
