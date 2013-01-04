<?
date_default_timezone_set('UTC'); 

ini_set('session.gc-maxlifetime', 10);
ini_set('session.cache_expire', 10);

include ("conf.php");


session_start();



 function string2array($string,&$myarray){
      $lines = explode("\n",$string);
      foreach ($lines as $value){
         $items = explode("^",$value);
         if (sizeof($items) == 2){
            $myarray[$items[0]] = $items[1];
         }
         else if (sizeof($items) == 3){
            $myarray[$items[0]][$items[1]] = $items[2];
         }
      }
   }
   
   
function checkOTP($pin,$otp,$initsecret)
{

 
 $maxperiod = 5*60; // in seconds = +/- 3 minutes
 $time=time();
 
 for($i = $time - $maxperiod; $i <= $time + $maxperiod; $i++)
 {
    $md5 = substr(md5(substr($i,0,-1).$initsecret.$pin),0,6);
    if($otp == $md5) return(true);
 }
return(false);
}




if ( $_REQUEST["action"]=="logout") {

 session_destroy(); 
 header("Location:index.php");
 die();
}

if ($_SESSION["access"]!="granted" && $_REQUEST["action"]=="auth") {

$c_username=preg_replace('/[^A-Za-z0-9@._]/', '', $_REQUEST["username"]);
 
$myFilter = new InputFilter($tags, $attr, 1, 1, 1);


$c_otp=$myFilter->process( $_REQUEST["otp"]);
$enteredpass=md5($_REQUEST["passphrase"]);
 
//Read user data
 
// Read the file back from the disk
   $serString = file_get_contents($userdata.md5($c_username));
   
  
 
    
   
   // Convert the content back to an array
  $userinfo=unserialize($serString);

//Check entered OTP
$pin=$userinfo["pin"];
$initsecret=$userinfo["init"];

 

if  ( checkOTP($pin,$c_otp,$initsecret) === false ) {  

 




 }

if  ( checkOTP($pin,$c_otp,$initsecret) === true && $enteredpass==$userinfo["password"] )  {

  $_SESSION["access"]="granted";
  $_SESSION["username"]=ucfirst($userinfo["name"]);
  $_SESSION["email"]=$userinfo["email"];
  $_SESSION['passphraseShort']=substr(md5($enteredpass),0,12);
  
   
   }
   
   

}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><?

 



?>
<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<title><?=$servicename?></title>
	<meta name="author" content="EH" />
	<link rel="stylesheet" href="css/main.css" type="text/css" />
    <script language="JavaScript"><!--
var dg=''
function makeArray(n) {
 for (var i=1; i<=n; i++) {
  this[i]=0
 }
 return this
}
function rc4(key, text) {
 var i, x, y, t, x2;
 status("rc4")
 s=makeArray(0);

 for (i=0; i<256; i++) {
  s[i]=i
 }
 y=0
 for (x=0; x<256; x++) {
  y=(key.charCodeAt(x % key.length) + s[x] + y) % 256
  t=s[x]; s[x]=s[y]; s[y]=t
 }
 x=0;  y=0;
 var z=""
 for (x=0; x<text.length; x++) {
  x2=x % 256
  y=( s[x2] + y) % 256
  t=s[x2]; s[x2]=s[y]; s[y]=t
  z+= String.fromCharCode((text.charCodeAt(x) ^ s[(s[x2] + s[y]) % 256]))
 }
 return z
}
function badd(a,b) { // binary add
 var r=''
 var c=0
 while(a || b) {
  c=chop(a)+chop(b)+c
  a=a.slice(0,-1); b=b.slice(0,-1)
  if(c & 1) {
   r="1"+r
  } else {
   r="0"+r
  }
  c>>=1
 }
 if(c) {r="1"+r}
 return r
}
function chop(a) {
 if(a.length) {
  return parseInt(a.charAt(a.length-1))
 } else {
  return 0
 }
}
function bsub(a,b) { // binary subtract
 var r=''
 var c=0
 while(a) {
  c=chop(a)-chop(b)-c
  a=a.slice(0,-1); b=b.slice(0,-1)
  if(c==0) {
   r="0"+r
  }
  if(c == 1) {
   r="1"+r
   c=0
  }
  if(c == -1) {
   r="1"+r
   c=1
  }
  if(c==-2) {
   r="0"+r
   c=1
  }
 }
 if(b || c) {return ''}
 return bnorm(r)
}
function bnorm(r) { // trim off leading 0s
 var i=r.indexOf('1')
 if(i == -1) {
  return '0'
 } else {
  return r.substr(i)
 }
}
function bmul(a,b) { // binary multiply
 var r=''; var p=''
 while(a) {
  if(chop(a) == '1') {
   r=badd(r,b+p)
  }
  a=a.slice(0,-1)
  p+='0'
 }
 return r;
}
function bmod(a,m) { // binary modulo
 return bdiv(a,m).mod
}
function bdiv(a,m) { // binary divide & modulo
 // this.q = quotient this.mod=remainder
 var lm=m.length, al=a.length
 var p='',d
 this.q=''
 for(n=0; n<al; n++) {
  p=p+a.charAt(n);
  if(p.length<lm || (d=bsub(p,m)) == '') {
   this.q+='0'
  } else {
   if(this.q.charAt(0)=='0') {
    this.q='1'
   } else {
    this.q+="1"
   }
   p=d
  }
 }
 this.mod=bnorm(p)
 return this
}
function bmodexp(x,y,m) { // binary modular exponentiation
 var r='1'
 status("bmodexp "+x+" "+y+" "+m)

 while(y) {
  if(chop(y) == 1) {
   r=bmod(bmul(r,x),m)
  }
  y=y.slice(0,y.length-1)
  x=bmod(bmul(x,x),m)
 }
 return bnorm(r)
}
function modexp(x,y,m) { // modular exponentiation
 // convert packed bits (text) into strings of 0s and 1s
 return b2t(bmodexp(t2b(x),t2b(y),t2b(m)))
}
function i2b(i) { // convert integer to binary
 var r=''
 while(i) {
  if(i & 1) { r="1"+r} else {r="0"+r}
  i>>=1;
 }
 return r? r:'0'
}
function t2b(s) {
 var r=''
 if(s=='') {return '0'}
 while(s.length) {
  var i=s.charCodeAt(0)
  s=s.substr(1)
  for(n=0; n<8; n++) {
   r=((i & 1)? '1':'0') + r
   i>>=1;
  }
 }
 return bnorm(r)
}
function b2t(b) {
 var r=''; var v=0; var m=1
 while(b.length) {
  v|=chop(b)*m
  b=b.slice(0,-1)
  m<<=1
  if(m==256 || b=='') {
   r+=String.fromCharCode(v)
   v=0; m=1
  }
 }
 return r
}
b64s='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_"'
function textToBase64(t) {
 status("t 2 b64")
 var r=''; var m=0; var a=0; var tl=t.length-1; var c
 for(n=0; n<=tl; n++) {
  c=t.charCodeAt(n)
  r+=b64s.charAt((c << m | a) & 63)
  a = c >> (6-m)
  m+=2
  if(m==6 || n==tl) {
   r+=b64s.charAt(a)
   if((n%45)==44) {r+="\n"}
   m=0
   a=0
  }
 }
 return r
}
function base64ToText(t) {
 status("b64 2 t")
 var r=''; var m=0; var a=0; var c
 for(n=0; n<t.length; n++) {
  c=b64s.indexOf(t.charAt(n))
  if(c >= 0) {
   if(m) {
    r+=String.fromCharCode((c << (8-m))&255 | a)
   }
   a = c >> m
   m+=2
   if(m==8) { m=0 }
  }
 }
 return r
}

function rand(n) {  return Math.floor(Math.random() * n) }
function rstring(s,l) {
 var r=""
 var sl=s.length
 while(l-->0) {
  r+=s.charAt(rand(sl))
 }
 //status("rstring "+r)
 return r
}
function key2(k) {
 var l=k.length
 var kl=l
 var r=''
 while(l--) {
  r+=k.charAt((l*3)%kl)
 }
 return r
}
function rsaEncrypt(keylen,key,mod,text) {
 // I read that rc4 with keys larger than 256 bytes doesn't significantly
 // increase the level of rc4 encryption because it's sbuffer is 256 bytes
 // makes sense to me, but what do i know...

 status("encrypt")
 if(text.length >= keylen) {
  var sessionkey=rc4(rstring(text,keylen),rstring(text,keylen))

  // session key must be less than mod, so mod it
  sessionkey=b2t(bmod(t2b(sessionkey),t2b(mod)))
  alert("sessionkey="+sessionkey)

  // return the rsa encoded key and the encrypted text
  // i'm double encrypting because it would seem to me to
  // lessen known-plaintext attacks, but what do i know
  return modexp(sessionkey,key,mod) +
   rc4(key2(sessionkey),rc4(sessionkey,text))
 } else {

  // don't need a session key
  return modexp(text,key,mod)
 }
}
function rsaDecrypt(keylen,key,mod,text) {
 status("decrypt")
 if(text.length <= keylen) {
  return modexp(text,key,mod)
 } else {

  // sessionkey is first keylen bytes
  var sessionkey=text.substr(0,keylen)
  text=text.substr(keylen)

  // un-rsa the session key
  sessionkey=modexp(sessionkey,key,mod)
  alert("sessionkey="+sessionkey)

  // double decrypt the text
  return rc4(sessionkey,rc4(key2(sessionkey,text),text))
 }
}
function trim2(d) { return d.substr(0,d.lastIndexOf('1')+1) }
function bgcd(u,v) { // return greatest common divisor
 // algorythm from http://algo.inria.fr/banderier/Seminar/Vallee/index.html
 var d, t
 while(1) {
  d=bsub(v,u)
  //alert(v+" - "+u+" = "+d)
  if(d=='0') {return u}
  if(d) {
   if(d.substr(-1)=='0') {
    v=d.substr(0,d.lastIndexOf('1')+1) // v=(v-u)/2^val2(v-u)
   } else v=d
  } else {
   t=v; v=u; u=t // swap u and v
  }
 }
}

function isPrime(p) {
 var n,p1,p12,t
 p1=bsub(p,'1')
 t=p1.length-p1.lastIndexOf('1')
 p12=trim2(p1)
 for(n=0; n<2; n+=mrtest(p,p1,p12,t)) {
  if(n<0) return 0
 }
 return 1
}
function mrtest(p,p1,p12,t) {
 // Miller-Rabin test from forum.swathmore.edu/dr.math/
 var n,a,u
  a='1'+rstring('01',Math.floor(p.length/2)) // random a
  //alert("mrtest "+p+", "+p1+", "+a+"-"+p12)
  u=bmodexp(a,p12,p)
  if(u=='1') {return 1}
  for(n=0;n<t;n++) {
   u=bmod(bmul(u,u),p)
   //dg+=u+" "
   if(u=='1') return -100
   if(u==p1) return 1
  }
  return -100
}
pfactors='11100011001110101111000110001101'
 // this number is 3*5*7*11*13*17*19*23*29*31*37
function prime(bits) {
 // return a prime number of bits length
 var p='1'+rstring('001',bits-2)+'1'
 while( ! isPrime(p)) {
  p=badd(p,'10'); // add 2
 }
 alert("p is "+p)
 return p
}
function genkey(bits) {
 q=prime(bits)
 do {
  p=q
  q=prime(bits)
 } while(bgcd(p,q)!='1')
 p1q1=bmul(bsub(p,'1'),bsub(q,'1'))
 // now we need a d, e,  and an n so that:
 //  p1q1*n-1=de  -> bmod(bsub(bmul(d,e),'1'),p1q1)='0'
 // or more specifically an n so that d & p1q1 are rel prime and factor e
 n='1'+rstring('001',Math.floor(bits/3)+2)
 alert('n is '+n)
 factorMe=badd(bmul(p1q1,n),'1')
 alert('factor is '+factorMe)
 //e=bgcd(factorMe,p1q1)
 //alert('bgcd='+e)
 e='1'
 // is this always 1?
 //r=bdiv(factorMe,e)
 //alert('r='+r.q+" "+r.mod)
 //if(r.mod != '0') {alert('Mod Error!')}
 //factorMe=r.q
 d=bgcd(factorMe,'11100011001110101111000110001101')
 alert('d='+d)
 if(d == '1' && e == '1') {alert('Factoring failed '+factorMe+' p='+p+' q='+q)}
 e=bmul(e,d)
 r=bdiv(factorMe,d)
 d=r.q
 if(r.mod != '0') {alert('Mod Error 2!')}

 this.mod=b2t(bmul(p,q))
 this.pub=b2t(e)
 this.priv=b2t(d)
}
function status(a) { }//alert(a)}
// --></script>
    	<script type="text/javascript" src="jquery.js"></script>
        <style type="text/css">
<!--
.style3 {font-size: x-small}
-->
        </style>
</head>


<script>


function getFile(filename)
{ oxmlhttp = null;
try
{ oxmlhttp = new XMLHttpRequest();
oxmlhttp.overrideMimeType("text/xml");
}
catch(e)
{ try
{ oxmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
}
catch(e)
{ return null;
}
}
if(!oxmlhttp) return null;
try
{ oxmlhttp.open("GET",filename,false);
oxmlhttp.send(null);
}
catch(e)
{ return null;
}
return oxmlhttp.responseText;
}



			 function ahah(url, target) {
document.getElementById(target).innerHTML = ' <img src=images/loading.gif /><small> loading...</small>';
if (window.XMLHttpRequest) {
req = new XMLHttpRequest();
} else if (window.ActiveXObject) {
req = new ActiveXObject("Microsoft.XMLHTTP");
}
if (req != undefined) {
req.onreadystatechange = function() {ahahDone(url, target);};
req.open("GET", url, true);
req.send("");
}
}

function ahahDone(url, target) {
if (req.readyState == 4) { // only If req Is "loaded"
if (req.status == 200) { // only If "OK"
document.getElementById(target).innerHTML = req.responseText;
} else {
document.getElementById(target).innerHTML=" :\n"+ req.status + "\n" +req.statusText;
}
}
}

function load(name, div) {
    ahah(name,div);
    return false;
}


</script>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/base/jquery-ui.css" type="text/css" media="all" />
			<link rel="stylesheet" href="http://static.jquery.com/ui/css/demo-docs-theme/ui.theme.css" type="text/css" media="all" />
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js" type="text/javascript"></script>
			<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js" type="text/javascript"></script>
			<script src="http://jquery-ui.googlecode.com/svn/tags/latest/external/jquery.bgiframe-2.1.2.js" type="text/javascript"></script>
			<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/i18n/jquery-ui-i18n.min.js" type="text/javascript"></script>
<body>
	<div id="content">
		<p id="top">Secure your passwords with <?=$servicename?></p>
		
 	<h1 style="background-image:url(images/keys1.png); background-repeat:no-repeat; height:70px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$servicename?></h1> <ul id="menu">
			<li><a class="current" href="index.php">Home</a></li>
			<li><a href="?action=register">Create an account</a></li>
			
			
		
		</ul>
	 
		<div id="pitch">	
			<p><?=$serviceinfo?></p>
		</div>
	
		<div id="main">
        	<? if ($_REQUEST["action"]=="register") { ?>
             <link rel="stylesheet" type="text/css" href="tabcontent.css" />

<script type="text/javascript" src="tabcontent.js">

/***********************************************
* Tab Content script v2.2- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>

   <h2>Create an account</h2>
   <p> Follow the instructions below to create an account with <?=$servicename?></p>

<h3>Step 1. Install mOTP application on your mobile device</h3>
mOTP (or  Mobile-OTP) is a free "strong authentication" solution for java capable mobile devices like phones or PDAs.<br />
There also are free implementations of mOTP for Android, WebOS and iPhone/iPad devices.<br />

Choose your client below and download and/or install mOTP on your mobile device.<br />
<br />


<ul id="countrytabs" class="shadetabs">
<li><a href="#" rel="country1" class="selected">Standard phones</a></li>
<li><a href="#" rel="country2">Android&#8482;</a></li>
<li><a href="#" rel="country3">iPhone/iPad&#8482;</a></li>
<li><a href="#" rel="country4">WebOS&#8482;</a></li>
</ul>

<div style="border:1px solid gray; width:450px; margin-bottom: 1em; padding: 10px">

<div id="country1" class="tabcontent" >
Java MIDLet for Standard phone and BlackBerry (J2ME)<br />
download <a href="clients/MobileOTP.jar">JAR</a> / <a href="clients/MobileOTP.jad">JAD</a></div>

<div id="country2" class="tabcontent" >
mOTP for Android is available on Android Market<br />
You can also <a href="clients/mOTP.apk">download</a> from our site</div>

<div id="country3" class="tabcontent" >
mOTP Application is available on iTunes<br />
see this <a href="http://itunes.apple.com/br/app/motp-mobile-onetimepasswords/id318414073?mt=8" target="_blank">page</a> for more information</div>

<div id="country4" class="tabcontent" >
mOTP application for WebOs based phones <br />
<a href="http://developer.palm.com/appredirect/?packageid=com.supersaveit.mobile-otp" target="_blank">download</a><br />
</div>

</div>

<script type="text/javascript">

var countries=new ddtabcontent("countrytabs")
countries.setpersist(true)
countries.setselectedClassTarget("link") //"link" or "linkparent"
countries.init()

</script>
 
<h3>Step 2. Initialize mOTP on your mobile device and generate the "Init-Secret" code</h3>         
	   <p>Load the MIDlet on the devices you plan to use. Installation of the .jar and .jad file is vendor specific. Usually java enabled phones come with some kind of application installer for PCs that allows to install MIDlets over IrDA or serial cable.
When the MIDlet is installed, run it. You can enter PINs to generate one time passwords, but to use them you will need to initialize the device first and write the Init-Secret into the appropriate user-record on the authentication server.<br />

To initialize the token, press 0000. Enter an arbitrary sequence of 25 keys as a random seed. The Init-Secret that will be shown is not to be written down anywhere else but the server itself<br />

<h3>Step 3. Complete your registration</h3>         
<p>Finish the process  by entering your information and Init-Secret in the <a href="?action=register2">registration form</a> </p>
		  
          <? } ?>
          
          <? if ($_REQUEST["action"]=="register2") { ?>
<link rel="stylesheet" href="css/general.css" type="text/css" />
            <h2>Complete your registration</h2>
	     
		
       <? include ("validation.php"); ?>
       	<? if( isset($_POST['send']) && $_REQUEST['pinReg']!=$regkey && (!validateName($_POST['name']) || !validateEmail($_POST['email']) || !validatePasswords($_POST['pass1'], $_POST['pass2']) || !validateMessage($_POST['message']) ) ):?>
			
           	<div id="error">
					<ul>
						<? if(!validateName($_POST['name'])):?>
							<li><strong>Invalid Name:</strong> We want names with more than 1 letter!</li>
						<?endif?>
						<?if(!validateEmail($_POST['email'])):?>
							<li><strong>Invalid E-mail:</strong> Type a valid e-mail please </li>
						<?endif?>
						<?if(!validatePasswords($_POST['pass1'], $_POST['pass2'])):?>
							<li><strong>PINs are invalid:</strong> PINs doesn't match or are invalid!</li>
						<?endif?>
						<?if(!validatePasswords2($_POST['passp1'], $_POST['passp2'])):?>
							<li><strong>Passphrases are invalid:</strong> Passphrase doesn't match or are invalid!</li>
						<?endif?>
						
						<?if(!validateMessage($_POST['message'])):?>
							<li><strong>Invalid init-Secret:</strong></li>
						<?endif?>
                        
                        <?if(!validatePhone($_POST['phone'])):?>
							<li><strong>Invalid  Phone number:</strong></li>
						<?endif?>
                              <?if($_REQUEST['pinReg']!=$regkey):?>
							<li><strong>Registration key invalid: Kindly note that this service is not open to public. 
Please enter the registration key provided to you by your administrator to complete the registration</strong></li>
						<?endif?>
                        
			  </ul>
                    
                    Please go <a href="javascript:history.go(-1)" >back</a> and correct the entered information.
                    
		  </div>
			<?elseif(isset($_POST['send'])):?>
            
            <?
			
			//register account
			
			//check if user exists
			
			$filename=md5($_POST["email"]);
			$fullpath=$userdata.$filename;
			 
			if (file_exists($fullpath) ) { ?><div id="error" class="valid">
					<ul>
						<strong>Email address already registered! <br /> The address you provided is already in use by another member</strong>
					</ul>
				</div>
                
                 <? } else { 
			//Register
			
		//clean name
		
		$myFilter = new InputFilter($tags, $attr, 1, 1, 1);
		
		$userinfo["name"]=$myFilter->process($_REQUEST["name"]);
		$userinfo["lastname"]=$myFilter->process( $_REQUEST["lastname"]);
		$userinfo["email"]=$myFilter->process( $_REQUEST["email"]);	
		$userinfo["pin"]=$myFilter->process( $_REQUEST["pass1"]);
		$userinfo["password"]=md5($_REQUEST["passp1"]);
	 
		$userinfo["init"]=$myFilter->process( $_REQUEST["message"]);
		$userinfo["phone"]=$myFilter->process($_REQUEST["phone"]);
		
		
		// print_r($userinfo);
		$serializeduserinfo=serialize($userinfo);
		
		//save info
//	echo $fullpath;
		 //$f1 = fopen($fullpath,"w+");
  // fwrite($f1,$serializeduserinfo);
  // fclose($f1);
 file_put_contents($fullpath, $serializeduserinfo);



   
   	if (!file_exists($fullpath) ) { ?><div id="error" class="valid">
					<ul>
						<strong>Error! User file cannot be created <br /> Check path/chmod of the data folder</strong>
					</ul>
				</div>
                
                 <? } else {
				 
			
			?>
				<div id="error" class="valid">
					<ul>
						<strong>Congratulations! Your account is ready to use. You may now login and start creating your passwords list!</strong>
					</ul>
				</div>
                
                <?  } } ?>
		<?endif?>
<? if( !isset($_POST['send']) ) { ?>
  <p><strong>Important!</strong> This part of registration should be done on a computer free of viruses and trojans. We highly recommend to <strong>boot up using a Live CD Linux distro</strong> (or any other equivalent &quot;read-only&quot; OS) to complete your registration . Only this can guarantee that your sensitive information will not be stolen. Once registered, you can freely log on to your <?=$servicename?> account from any computer, even infected with a virus or a trojan: OTP will guarantee tha your account can only be accessed by you.</p>
		<form method="post" id="customForm" action="">
       <? if ($regkey!="") { ?>  
       
         <div id="error" class="valid">
					<ul>
				Kindly note that this service is not open to public.Please enter the registration key provided to you by your administrator to complete the registration
					</ul>
		  </div>
                
                
                
        <div>
				<label for="pinReg">Registration Key</label>
				<input id="pinReg" name="pinReg" type="text" /><span id="pinRegInfo">Please enter the registration key </span>
		  </div> 
          <? } ?>
          
          
          <div id="error" class="valid">
					<ul>
						 Please enter your personal information 
					</ul>
		  </div>
                
         
                
		
          
          
          
                
		  <div>
				<label for="name">Name</label>
				<input id="name" name="name" type="text" />
				<span id="nameInfo">Please provide your name</span>
		  </div>
            <div>
				<label for="lastname">Last Name</label>
				<input id="lastname" name="lastname" type="text" />
				<span id="lastnameInfo">Please provide your last name</span>
			</div>
            
		  <div>
				<label for="email">E-mail</label>
				<input id="email" name="email" type="text" />
				<span id="emailInfo">Valid E-mail please, will be used for access retrieval!</span>
		  </div><br />

		  <div id="error" class="valid">
					<ul>
						 <strong>Passphrase!</strong> Please provide a passphrase below. The passphrase will be used to encrypt your passwords and also as the first auth factor when logging in. 
					</ul>
		  </div>
                
			<div>
				<label for="passp1">Passphrase</label>
				<input id="passp1" name="passp1" type="password" />
				<span id="passp1Info">Minimum 8 chars</span>
			</div>
		  <div>
				<label for="passp2">Confirm Passphrase</label>
				<input id="passp2" name="passp2" type="password" />
				<span id="passp2Info">should match the Passphrase</span>
		  </div>
		  <br>
		  
            <div id="error" class="valid">
					<ul>
						 <strong>Attention!</strong> Please provide a PIN Code below. Try not to lose it. We currently do not recover lost PINs 
					</ul>
		  </div>
                
			<div>
				<label for="pass1">PIN code</label>
				<input id="pass1" name="pass1" type="password" />
				<span id="pass1Info">4 digits</span>
			</div>
		  <div>
				<label for="pass2">Confirm PIN</label>
				<input id="pass2" name="pass2" type="password" />
				<span id="pass2Info">4 digits</span>
		  </div>
		  
		  

			<div>
				<label for="message">Init-Secret of your mOTP device</label>
			  <input name="message" type="text" id="message" value="" size="" />
                <span id="MessageInfo">Please provide init-secret string generated by your mobile device </span>
		  </div>
          
          
          	<div>
			  <label for="phone">Please provide your mobile phone number</label>
			  <input name="phone" type="text" id="phone" value="" size="" />
                <span id="phoneinfo">Will be used to regain access to your account in case of emergency </span>
		  </div>
          
          
            
<div id="error" class="valid">
						 By clicking the button below, I confirm that
                         
					<ul>
 <li>	I understand that <?=$servicename?> will not be able to restore access if my mobile application is lost or corrupted, or I forget my PIN
 </li>
  <li>	I have read and agreed to the Terms of Service
 </li>
					</ul>
		  </div>
                
                
			<div>
				<input id="send" name="send" type="submit" value="Send" />
			</div>
		</form>
	 

	<script type="text/javascript" src="validation.js"></script>
 	
    <? } ?>
			
<? } ?>
          
          
          
			<? if ($_REQUEST["action"]=="") { ?>
<?=$serviceintro?>            

		  
          <? } ?>
          
          <? if ($_SESSION["access"]=="granted" &&  $_REQUEST["action"]=="passcards") { ?>
       <script>
 
	 

function encrypt(str, pwd) {
  if(pwd == null || pwd.length <= 0) {
    alert("Please enter a password with which to encrypt the message.");
    return null;
  }
  var prand = "";
  for(var i=0; i<pwd.length; i++) {
    prand += pwd.charCodeAt(i).toString();
  }
  var sPos = Math.floor(prand.length / 5);
  var mult = parseInt(prand.charAt(sPos) + prand.charAt(sPos*2) + prand.charAt(sPos*3) + prand.charAt(sPos*4) + prand.charAt(sPos*5));
  var incr = Math.ceil(pwd.length / 2);
  var modu = Math.pow(2, 31) - 1;
  if(mult < 2) {
    alert("Algorithm cannot find a suitable hash. Please choose a different password. \nPossible considerations are to choose a more complex or longer password.");
    return null;
  }
  var salt = Math.round(Math.random() * 1000000000) % 100000000;
  prand += salt;
  while(prand.length > 10) {
    prand = (parseInt(prand.substring(0, 10)) + parseInt(prand.substring(10, prand.length))).toString();
  }
  prand = (mult * prand + incr) % modu;
  var enc_chr = "";
  var enc_str = "";
  for(var i=0; i<str.length; i++) {
    enc_chr = parseInt(str.charCodeAt(i) ^ Math.floor((prand / modu) * 255));
    if(enc_chr < 16) {
      enc_str += "0" + enc_chr.toString(16);
    } else enc_str += enc_chr.toString(16);
    prand = (mult * prand + incr) % modu;
  }
  salt = salt.toString(16);
  while(salt.length < 8)salt = "0" + salt;
  enc_str += salt;
  return enc_str;
}

function decrypt(str, pwd) {
  if(str == null || str.length < 8) {
    alert("A salt value could not be extracted from the encrypted message because it's length is too short. The message cannot be decrypted.");
    return;
  }
  if(pwd == null || pwd.length <= 0) {
    alert("Please enter a password with which to decrypt the message.");
    return;
  }
  var prand = "";
  for(var i=0; i<pwd.length; i++) {
    prand += pwd.charCodeAt(i).toString();
  }
  var sPos = Math.floor(prand.length / 5);
  var mult = parseInt(prand.charAt(sPos) + prand.charAt(sPos*2) + prand.charAt(sPos*3) + prand.charAt(sPos*4) + prand.charAt(sPos*5));
  var incr = Math.round(pwd.length / 2);
  var modu = Math.pow(2, 31) - 1;
  var salt = parseInt(str.substring(str.length - 8, str.length), 16);
  str = str.substring(0, str.length - 8);
  prand += salt;
  while(prand.length > 10) {
    prand = (parseInt(prand.substring(0, 10)) + parseInt(prand.substring(10, prand.length))).toString();
  }
  prand = (mult * prand + incr) % modu;
  var enc_chr = "";
  var enc_str = "";
  for(var i=0; i<str.length; i+=2) {
    enc_chr = parseInt(parseInt(str.substring(i, i+2), 16) ^ Math.floor((prand / modu) * 255));
    enc_str += String.fromCharCode(enc_chr);
    prand = (mult * prand + incr) % modu;
  }
  return enc_str;
}
 
 
 
 
</script>

            
          <script>
	// increase the default animation speed to exaggerate the effect
	$.fx.speeds._default = 1000;
	$(function() {
		$( "#newpasscard" ).dialog({
			autoOpen: false,
			modal: true,
			show: "blind",
			hide: "slide",
			minWidth: "600" ,
			minHeight: "200" ,
			 beforeClose: function(event, ui) { load('passcards.php','passcards'); },
			  open: function(event, ui) { cleansaved(); }
		});
		
		$( "#dialog" ).dialog({
			autoOpen: false,
			modal: true,
			show: "blind",
			hide: "slide",
			minWidth: "400" ,
			minHeight: "200" ,
			  beforeClose: function(event, ui) { load('passcards.php','passcards'); }
		});
		
		
		$( "#editpasscard" ).dialog({
			autoOpen: false,
			show: "blind",
			modal: true,
			hide: "slide",
			minWidth: "600" ,
			minHeight: "200" ,
			  beforeClose: function(event, ui) { load('passcards.php','passcards'); }
		});
		
		$( "#deleter" ).click(function() {
			$( "#dialog" ).dialog( "open" );
			return false;
		});
			

	$( "#editer" ).click(function() {
			$( "#editpasscard" ).dialog( "open" );
			return false;
		});
		
		
		$( "#opener" ).click(function() {
			$( "#newpasscard" ).dialog( "open" );
			return false;
		});
	});
	
	
		
		
	</script>
        <div id="dialog" title="Delete PassCard" style="display:none">
	<p><input type=hidden id=deletefile /> You are about to delete the passcard selected. Please note that this operation cannot be undone.<br />
    <div id=deleteresult>
<input type=button value=Delete  onclick="load('deletepc.php?file='+document.getElementById('deletefile').value,'deleteresult'); return false;" /></div></p>
</div>
<button id=editer style="display:none">Edit</button>
<button id=deleter style="display:none">Delete</button>
   <h3>Passcards</h3>
		 
 
		  
      
        <div align="right">[<a href="#" onClick="load('passcards.php','passcards'); return false;">all passcards</a>] [ <a href="#" onClick="return false;"><span id="opener">new passcard</span></a>] [ <a href="#" onClick="var answer = prompt ('enter search tag',''); if (answer!=null ) { load('passcards.php?tag='+answer,'passcards') }; return false;"><span id="opener">search</span></a>]</div>
<? include ("newpasscard.php"); ?>
           <? include ("editpasscard.php"); ?>
           <script>
		 function cleansaved() {
		   				  if (document.getElementById('pcsaved')!= null) {
				  document.getElementById('pcsaved').innerHTML="";
				  }
				  
				  }
				  
		 function  dlogin(id, data)  {
		 
		 
		  var dData;
		  dData=decrypt(data,window.myValue); 
		  
		  if (dData.substr(0,9)!="Decrypted") {
		  
		  alert ("Decryption failed. Please check the passphrase");
		  } else {
		  
		  var brokenstring=dData.split('|PSSPRT|');
		  document.getElementById('user'+id).value=brokenstring[1];
		  document.getElementById('pass'+id).value=brokenstring[2];
		   
		  	document.getElementById('submit'+id).click();	  
		  
		  }
		  
		  
		  
		  return false;
		  }
		  
		   function  deletepc (file) {
			
			
			document.getElementById('deletefile').value=file;
			document.getElementById('deleteresult').innerHTML="<input type=button value=Delete  onclick=\"load('deletepc.php?file='+document.getElementById('deletefile').value,'deleteresult'); return false;\" />";
			 document.getElementById('deleter').click();
			 
			}
			
		   function  showlogin (service, file, name, data, url, ufield,pfield,ftype,sname,svalue,addit,tag) {
		 
 
		  
		  var dData;
		  dData=decrypt(data,window.myValue); 
		  
		  if (dData.substr(0,9)!="Decrypted") {
		  
		  alert ("Decryption failed. Please check the passphrase");
		  } else {
		  
		  
		  
		  var brokenstring=dData.split('|PSSPRT|');
	 
		  document.getElementById('euser').value=brokenstring[1];
		  document.getElementById('epassword').value=brokenstring[2];
	  document.getElementById('eservice').value=service;
	  	  document.getElementById('efile').value=file;
		    document.getElementById('ename').value=name;
			document.getElementById('etag').value=tag;
		  		  document.getElementById('eform_url').value=url;
				  
				  if (document.getElementById('pcsaved')!= null) {
				  document.getElementById('pcsaved').innerHTML="";
				  }
				  
				  if(service=="custom") {
				  
				  document.getElementById('customedit').style.display='';
				  
				  document.getElementById('esname').value=sname;
		    document.getElementById('esvalue').value=svalue;
			document.getElementById('eftype').value=ftype;
				document.getElementById('eufield').value=ufield;
								document.getElementById('epfield').value=pfield;
								document.getElementById('eadd').value=addit;
			
			
				  } else {
				  
				  document.getElementById('customedit').style.display='none';
				  
				  
				  }
				  
				  
		   document.getElementById('editer').click();
		  }
		  
		  
		  
		  return false;
		  }
		  
		  
		  
		  </script>
         
         
          <script>
		  var myValue;
 
myValue='<?=$_SESSION['passphraseShort']?>';
		  
		 function  forgetpp() {
		 
		 document.getElementById("passphrase").value="";
		 myValue=document.getElementById("passphrase").value;
		 document.getElementById("ppinfo").innerHTML="[ no passphrase defined for this session ]";
		 document.getElementById("ppforget").innerHTML="";
		 }
		  
		  
		  function savepp() {
		  myValue=document.getElementById("passphrase").value;
		  document.getElementById("ppinfo").innerHTML="<font color=green>passphrase set</font>  ";
		  //document.getElementById("ppforget").innerHTML="&nbsp; <input type=button value='forget' class=ui-button-text-icon-primary onClick='forgetpp()'> ";
		  document.getElementById("passphrase").value="";
		  //load('passcards.php','passcards');
		  
		  }
		  
		  
		  function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}


		  </script>
        
         <div id=passcards  ><br />
<br />

         
         Please enter your passphrase on the right
         
         </div>  
          <script>
		  load('passcards.php','passcards');
		  </script>
          
            <? } ?>
          
          
          
          <? if ($_REQUEST["action"]=="auth") {


if  ( $_SESSION["access"]!="granted") { echo "<h2>Authorization failed</h2> <p>Using static passwords for authentication, as it is commonly done, has quite a few security drawbacks: passwords can be guessed, forgotten, written down and stolen, eavesdropped or deliberately being told to other people.</p>" ; }

if  ( $_SESSION["access"]=="granted" )  {

   echo " <h2>Welcome, ".$newArray[0]["name"]." ".$newArray[0]["lastname"]."</h2>";
   ?> 
          <p><?=$loggedininfo?></p><?
   
   
   $name=$newArray[0]["name"];
   }
   
   

}

?><div class="x"></div>
	  </div>
		<? if ($_SESSION["access"]!="granted") { ?> <div class="col last">
			<h4>Login to your <?=$servicename?> account</h4>
		  <div>
		    <form id="form1" method="post" action="?action=auth">
			
				  <table width="100%" border="0" cellpadding="3" cellspacing="3">
                    <tr>
                      <td>Username</td>
                      <td><input name="username" type="text" id="username" value="" size="25" /></td>
                    </tr>
                    <tr>
					<tr>
                      <td>Passphrase</td>
                      <td><input name="passphrase" type="password" id="passphrase" value="" size="25" /></td>
                    </tr>
                    <tr>
					
					
                      <td>OTP</td>
                      <td><input name="otp" type="password" id="otp" value="" size="25" /></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center"><input name="button" type="submit" class="img" id="button" value="Log in" /></td>
                    </tr>
                  </table>
			
		    </form>
				
                
              <a href="?action=register"><strong> Create an account  </strong></a></div>
		</div>  <? } ?>
      		<? if ($_SESSION["access"]=="granted") { ?> <div class="col last">
			 <? if ($_REQUEST["action"]=="passcards") { ?> 
              <!--  
             <h4>Passphrase</h4>
             <table   width="100%" align="center" cellpadding="6" cellspacing="6"  >
  <tr>
    <td>		   Please enter your passphrase [<a href=#  onclick="return false;" title=" this passphrase will be used as default encryption salt for new passcards and will be used as default decryption salt for saved passcards. Please remember your passphrase. You are the only one who will know it - we will not store this information on our server" >?</a>]<br /> 
<input name=passphrase type=password   id=passphrase onkeypress="if (event.keyCode==13) { savepp();} " size="20"  style="height:16px" />&nbsp;<em><span class="current" id="ppinfo">no passphrase</span></em><br />

<input type=button styles="font-size:22px; font-family:Verdana, Arial, Helvetica, sans-serif; border:thin; background-color:#999999" onclick="savepp()" value=OK /><span id=ppforget></span><br />
<br /><br />


 </td>
    </tr>
 
  
</table> -->
<? } ?><h4>User: <? echo $_SESSION["username"]; ?></h4>
            <div> <p><a href=?action=passcards>PassCards</a></p>
            
            <p><a href=?action=logout>Log out</a></p>
            
           
            
		  
          <script src="jquery.idletimer.js" type="text/javascript"></script>
<script src="jquery.idletimeout.js" type="text/javascript"></script>
           
 
 
<div id="ddialog" title="Your session is about to expire!">
	<p>
		<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>
		You will be logged off in <span id="dialog-countdown" style="font-weight:bold"></span> seconds.
	</p>
	
	<p>Do you want to continue your session?</p>
</div>

 
<script type="text/javascript">
// setup the dialog
$("#ddialog").dialog({
	autoOpen: false,
	modal: true,
	width: 400,
	height: 200,
	closeOnEscape: false,
	draggable: false,
	resizable: false,
	buttons: {
		'Yes, Keep Working': function(){
			$(this).dialog('close');
		},
		'No, Logoff': function(){
			// fire whatever the configured onTimeout callback is.
			// using .call(this) keeps the default behavior of "this" being the warning
			// element (the dialog in this case) inside the callback.
			$.idleTimeout.options.onTimeout.call(this);
		}
	}
});

// cache a reference to the countdown element so we don't have to query the DOM for it on each ping.
var $countdown = $("#dialog-countdown");

// start the idle timer plugin
$.idleTimeout('#ddialog', 'div.ui-dialog-buttonpane button:first', {
	idleAfter: <?=$idletimer?>,
	pollingInterval: 2,
	keepAliveURL: 'keepalive.php',
	serverResponseEquals: 'OK',
	onTimeout: function(){
		window.location = "index.php?action=logout";
	},
	onIdle: function(){
		$(this).dialog("open");
	},
	onCountdown: function(counter){
		$countdown.html(counter); // update the counter
	}
});

</script>
 


		  </div>
	  </div>  <? } ?>
       
      
		
		<div id="footer">
			<p id="right">
				 
			</p>
			<p>
				 
			</p>
			<p>Copyright &copy; <?=date("Y")?> | <?=$servicename?></p>
		</div>
	</div>
</body>
</html>
