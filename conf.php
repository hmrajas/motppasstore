<?

error_reporting(0);


$userdata="/html/projects/passtore/data-secure/"; //Data folder for user db - to be located OUTSIDE OF PUBLIC_HTML folder

$servicename="MOTP Passtore ";
$serviceinfo=$servicename." gives you the tools to organize your passwords all in one place. Easy to access and even more secure. Your passwords will be kept on the server encrypted by passcode known by you only. Your Passtore account can only be accessed using onetime passwords (OTP) which completely mitigates the threat of keylogger and similar type trojans, as well as the man-in-the-middle attacks";
$serviceintro="<h2>How does it work?</h2><p>Intro text</p>";
$regkey="3219";


$loggedininfo=" <h2>Logged in</h2>Here you can put links to your protected area etc";


$idletimer='120';


$servicedata["custom"]["name"]="Custom";  //Do not edit
$servicedata["custom"]["icon"]="custom.png"; // Do not edit




$servicedata["google"]["name"]="Google";
$servicedata["google"]["icon"]="google_32.png";
$servicedata["google"]["form_url"]="https://www.google.com/accounts/ServiceLoginAuth";
$servicedata["google"]["form_method"]="post";
$servicedata["google"]["username_field"]="Email";
$servicedata["google"]["password_field"]="password";
$servicedata["google"]["submit_button"]="signIn";
$servicedata["google"]["submit_button_value"]="Sign in";
$servicedata["google"]["more"]=" ";
$servicedata["google"]["script"]="



 ";



$servicedata["fb"]["name"]="FaceBook";
$servicedata["fb"]["icon"]="facebook_32.png";
$servicedata["fb"]["form_url"]="https://www.facebook.com/login.php?login_attempt=1";
$servicedata["fb"]["form_method"]="POST";
$servicedata["fb"]["username_field"]="email";
$servicedata["fb"]["password_field"]="pass";
$servicedata["fb"]["submit_button"]="Log in";
$servicedata["fb"]["more"]=" ";

$servicedata["fb"]["script"]="



 ";
 
 

$servicedata["citrix6"]["name"]="Citrix WI";
$servicedata["citrix6"]["icon"]="ctx6.png";
$servicedata["citrix6"]["form_url"]="";
$servicedata["citrix6"]["form_method"]="POST";
$servicedata["citrix6"]["username_field"]="user";
$servicedata["citrix6"]["password_field"]="password";
$servicedata["citrix6"]["submit_button"]="Log On";
$servicedata["citrix6"]["more"]="  <input type='hidden' name='LoginType' value='Explicit'> ";


$servicedata["citrix6"]["script"]="



 ";
 
 
 $servicedata["uniwebmail"]["name"]="UNICEF Web Mail";
$servicedata["uniwebmail"]["icon"]="unimail.png";
$servicedata["uniwebmail"]["form_url"]="https://webmail.unicef.org/pkmslogin.form";
$servicedata["uniwebmail"]["form_method"]="POST";
$servicedata["uniwebmail"]["username_field"]="username";
$servicedata["uniwebmail"]["password_field"]="password";
$servicedata["uniwebmail"]["submit_button"]="Log On";
$servicedata["uniwebmail"]["more"]="  <INPUT TYPE=HIDDEN NAME=login-form-type VALUE=pwd>  ";


$servicedata["uniwebmail"]["script"]="



 ";
 
 
 $servicedata["wordpress"]["name"]="WordPress";
$servicedata["wordpress"]["icon"]="wordpress_32.png";
$servicedata["wordpress"]["form_url"]="";
$servicedata["wordpress"]["form_method"]="POST";
$servicedata["wordpress"]["username_field"]="log";
$servicedata["wordpress"]["password_field"]="pwd";
$servicedata["wordpress"]["submit_button"]="Log On";
$servicedata["wordpress"]["more"]="    ";


$servicedata["wordpress"]["script"]="



 ";

 include ("class.inputfilter.php");

?>
