<?
session_start();


include("conf.php");
if ($_SESSION["access"]!="granted" ) { die("s!@dir"); }
//Catalogue




 
$file=preg_replace('/[^A-Za-z0-9_]/', '', $_REQUEST["file"]);



$fullpath=$userdata.md5($_SESSION["email"])."-pc/".$file;

unlink($fullpath);

?>
<h5>The passcard has been deleted</h5>

<input type=button onclick=" load('passcards.php','passcards');" value="OK" />