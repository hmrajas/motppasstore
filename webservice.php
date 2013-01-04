<?
session_start();


include("conf.php");
if ($_SESSION["access"]!="granted" ) { die("s!@dir"); }
//Catalogue




if ($_REQUEST["action"]=="") {

foreach ($servicedata as $key => $value) {



if ($key!="custom") {
   ?>   
<table width="80" border="0" align="left" cellpadding="4" cellspacing="4">
  <tr>
    <td align="center" nowrap="nowrap">   <a href=# onclick="load('webservice.php?action=create&service=<?=$key?>','load'); return false;"><img src=serviceicons/<?=$servicedata[$key]["icon"]?>  /><br />
<?=$servicedata[$key]["name"]?></a></td>
  </tr>
  
</table>

   
   <?
   
   }
}

}

if ($_REQUEST["action"]=="save") { 

//Saving PassCard

 
 
if (!is_dir($userdata.md5($_SESSION["email"])."-pc") ) { mkdir($userdata.md5($_SESSION["email"])."-pc"); }
$myFilter = new InputFilter($tags, $attr, 1, 1, 1);

$file=$myFilter->process( $_REQUEST["file"]);

if (strlen($file)<4){ $file=time(); }

$fullpath=$userdata.md5($_SESSION["email"])."-pc/".$file;

 $pc["form_url"]=$myFilter->process($_REQUEST["form_url"]);
$pc["service"]=$myFilter->process($_REQUEST["service"]);
$pc["name"]=$myFilter->process($_REQUEST["name"]);
$pc["date"]=$myFilter->process($_REQUEST["data"]);

if ($pc["service"]=="custom") {
$pc["ufield"]=$myFilter->process( $_REQUEST["ufield"]);

$pc["pfield"]=$myFilter->process($_REQUEST["pfield"]);

$pc["sname"]=$myFilter->process( $_REQUEST["sname"]);
$pc["svalue"]=$myFilter->process( $_REQUEST["svalue"]);
$pc["form_method"]=$myFilter->process( $_REQUEST["form_method"]);

$pc["additional"]=$myFilter->process( $_REQUEST["additional"]);
$pc["tag"]=$myFilter->process( $_REQUEST["tag"]);

}
 
file_put_contents($fullpath, serialize($pc)) ;




?>

<div id=pcsaved >Passcard saved  
 </div>
<?

}


if ($_REQUEST["action"]=="create") {
$myFilter = new InputFilter($tags, $attr, 1, 1, 1);
$file=$myFilter->process( $_REQUEST["file"]);
$service=$myFilter->process(  $_REQUEST["service"]);




 ?>
<script>
var encPair;
encPair="";
</script>

Creating <?=$servicedata[$service]["name"]?> PassCard  <br />
<span style="color:#990000; font-size:9px" id=nopassinfo></span><br />
<script>
if (window.myValue == " " ) {
document.getElementById('nopassinfo').innerHTML="no/short passphrase specified. please provide a passphrase";
}
</script>
<table width="525" height="125" border="0" cellpadding="3" cellspacing="4">
  <tr>
    <td width="97" nowrap="nowrap">PassCard Name</td>
    <td width="421"><input type="text" name="name" id="name" value="<?=$servicedata[$service]["name"]?>" /></td>
  </tr>
  
  <tr>
    <td nowrap="nowrap">Username/ID</td>
    <td><input type="text" name="user" id="user" /></td>
  </tr>
  <tr>
    <td nowrap="nowrap">Password</td>
    <td><input type="password" name="password" id="password" /></td>
  </tr>
 
  <tr>
    <td nowrap="nowrap">Login URL</td>
    <td><input name="form_url" type="text" id="form_url" value="<?=$servicedata[$service]["form_url"]?>" size="33" /></td>
  </tr>
  
 
  
  <tr>
    <td>Search tag</td>
    <td><input type="text" name="tag" id="tag" /></td>
  </tr>
  <tr>
    <td colspan="2">[<a href=#  onclick="if (window.myValue.length >2) { encPair=encrypt( 'Decrypted|PSSPRT|'+document.getElementById('user').value+'|PSSPRT|'+document.getElementById('password').value,window.myValue); load('webservice.php?action=save&service=<?=$service?>&tag='+document.getElementById('tag').value+'&name='+document.getElementById('name').value+'&data='+encPair+'&form_url='+escape(document.getElementById('form_url').value),'load');   return false; } else {document.getElementById('nopassinfo').innerHTML='no/short passphrase specified. please provide a passphrase';  return false;}" ><strong>save</strong></a>] [<a href=#  onclick="load('webservice.php','load'); return false;" >back</a>]</td>
  </tr>
</table>
         
 
<? }

?><?
if ($_REQUEST["action"]=="custom") {

$service="custom";




 ?>
<script>
var encPair;
encPair="";
</script>

Creating custom PassCard  <br />
<span style="color:#990000; font-size:9px" id=nopassinfo></span><br />
<script>
if (window.myValue == " " ) {
document.getElementById('nopassinfo').innerHTML="no/short passphrase specified. please provide a passphrase";
}
</script>
<table width="525" height="125" border="0" cellpadding="3" cellspacing="4">
  <tr>
    <td width="97" nowrap="nowrap">PassCard Name</td>
    <td width="421"><input type="text" name="name" id="name" value="Custom " /></td>
  </tr>
  
  <tr>
    <td nowrap="nowrap">Username field name</td>
    <td><input name="ufield" type="text" id="ufield" value="username" /></td>
  </tr>
  <tr>
    <td nowrap="nowrap">Username/ID</td>
    <td><input type="text" name="user" id="user" /></td>
  </tr>
  <tr>
    <td nowrap="nowrap">Password field name</td>
    <td><input name="pfield" type="text" id="pfield" value="password" /></td>
  </tr>
  <tr>
    <td nowrap="nowrap">Password</td>
    <td><input type="password" name="password" id="password" /></td>
  </tr>
  <tr>
    <td nowrap="nowrap">Login URL</td>
    <td><input name="form_url" type="text" id="form_url" value="<?=$servicedata[$service]["form_url"]?>" size="33" /></td>
  </tr>
  
 
  <tr>
    <td>Search tag</td>
    <td><input type="text" name="tag" id="tag" /></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">Submit button name</td>
    <td><input name="sname" type="text" id="sname" value="submit" /></td>
  </tr>
  <tr>
    <td valign="top">Submit button value</td>
    <td><input name="svalue" type="text" id="svalue" value="log in" /></td>
  </tr>
  <tr>
    <td valign="top">Form method</td>
    <td><input name="form_method" type="text" id="form_method" value="post" /></td>
  </tr>
  <tr>
    <td valign="top">Additional elements</td>
    <td><textarea name="additional" cols="31" rows="5" id="additional"></textarea></td>
  </tr>
  <tr>
    <td colspan="2">[<a href=#  onclick="if (window.myValue.length >2) { encPair=encrypt( 'Decrypted|PSSPRT|'+document.getElementById('user').value+'|PSSPRT|'+document.getElementById('password').value,window.myValue); load('webservice.php?action=save&service=<?=$service?>&tag='+document.getElementById('tag').value+'&name='+document.getElementById('name').value+'&form_method='+document.getElementById('form_method').value+'&sname='+document.getElementById('sname').value+'&svalue='+document.getElementById('svalue').value+'&ufield='+document.getElementById('ufield').value+'&additional='+document.getElementById('additional').value+'&pfield='+document.getElementById('pfield').value+'&data='+encPair+'&form_url='+escape(document.getElementById('form_url').value),'load');   return false; } else {document.getElementById('nopassinfo').innerHTML='no/short passphrase specified. please provide a passphrase';  return false;}" ><strong>save</strong></a>] [<a href=#  onclick="load('webservice.php','load'); return false;" >back</a>]</td>
  </tr>
</table>
         
 
<? }

?>