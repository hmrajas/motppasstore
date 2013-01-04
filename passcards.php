<?
session_start();


include("conf.php");
if ($_SESSION["access"]!="granted" ) { die("s!@dir"); }
		  
		  //Show passcards
		  // open this directory 
$myDirectory = opendir($userdata.md5($_SESSION["email"])."-pc");

// get each entry
while($entryName = readdir($myDirectory)) {
	$dirArray[] = $entryName;
}

// close directory
closedir($myDirectory);

//	count elements in array
$indexCount	= count($dirArray);
 

// sort 'em
sort($dirArray);
		 $myFilter = new InputFilter($tags, $attr, 1, 1, 1);
$search=0;
if ($_REQUEST["tag"]!="") {
$tag=$myFilter->process( $_REQUEST["tag"]); $search=1;}

 
// loop through the array of files and print them all
for($index=0; $index < $indexCount; $index++) {
$data="";
        if (substr("$dirArray[$index]", 0, 1) != "."){ // don't list hidden files
		
		//read contents
		
		$data=file_get_contents( $userdata.md5($_SESSION["email"])."-pc/".$dirArray[$index]);
		 
		 $pcdata=unserialize($data);
		 $key=$pcdata["service"];
		// print_r($pcdata);
		$pcdata["date"]=$pcdata["date"];
		 
		 if ($pcdata["service"]=="custom") {
		 
		 $servicedata["custom"]["form_method"]=$pcdata["form_method"];
		 $servicedata["custom"]["username_field"]=$pcdata["ufield"];
 		 $servicedata["custom"]["password_field"]=$pcdata["pfield"];
		 $servicedata["custom"]["submit_button"]=$pcdata["sname"];
 		 $servicedata["custom"]["submit_button_value"]=$pcdata["svalue"];
		 $servicedata["custom"]["more"]=$pcdata["additional"];
		 
		 
		 }
		 


if ( stristr($pcdata["tag"],$tag)!==false || $search==0  ) {  
 
 
		 ?>
         <div id=directlogin<?=$dirArray[$index]?> > </div>
          <table width="110" border="0" align="left" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" style="margin-right:20px;margin-top:20px; border-bottom-style: solid; border-bottom-width: 2px; border-bottom-color: EEEEEE;border-right-style: solid; border-right-width: 2px; border-right-color: EEEEEE;">
            <tr>
              <td align="center"><?=$pcdata["name"]?> </td>
            </tr>
            <tr>
             
              <td align="center" valign="top"><a href="#" onclick="showlogin('<?=$key?>','<?=$dirArray[$index]?>','<?=$pcdata["name"]?>','<?=$pcdata["date"]?>','<?=$pcdata["form_url"]?>')"><img src="serviceicons/<?=$servicedata[$key]["icon"]?>" alt=""  /><br />
              </a>                 </td> 
            </tr>
            <tr>
              <td align="center" valign="top"><a href="#" onclick="dlogin(<?=$dirArray[$index]?>,'<?=$pcdata["date"]?>')"><img  title="direct login" src="images/login.png" alt="" width="16" height="16" /></a> 
                <a href="#" onclick="showlogin('<?=$key?>','<?=$dirArray[$index]?>','<?=$pcdata["name"]?>','<?=$pcdata["date"]?>','<?=$pcdata["form_url"]?>','<?=$pcdata["ufield"]?>','<?=$pcdata["pfield"]?>','<?=$pcdata["form_method"]?>','<?=$pcdata["sname"]?>','<?=$pcdata["svalue"]?>','<?=$pcdata["additional"]?>','<?=$pcdata["tag"]?>')"><img src="images/edit.png" title="show or edit the passcard" alt="" width="16" height="16" /></a> 
              <a href="#" onclick="deletepc(<?=$dirArray[$index]?>); return false;"><img src="images/delete.png" title="delete this passcard" alt="" width="16" height="16"  /></a></td>
            </tr>
          </table>
          <div style="display:none">
          <form id=form<?=$dirArray[$index]?>   method="<?=$servicedata[$pcdata["service"]]["form_method"]?>" action="<?=$pcdata["form_url"]?>" target="_blank">
          <input id=user<?=$dirArray[$index]?>  type=text name="<?=$servicedata[$pcdata["service"]]["username_field"]?>"   />
                    <input  id=pass<?=$dirArray[$index]?> type=text name="<?=$servicedata[$pcdata["service"]]["password_field"]?>"   />
                    
             <input type=submit id=submit<?=$dirArray[$index]?> name="<?=$servicedata[$pcdata["service"]]["submit_button"]?>" value="<?=$servicedata[$pcdata["service"]]["submit_button_value"]?>"   />
             <?=$servicedata[$pcdata["service"]]["more"]?>
          </form>
          
           </div>
          
         <?
		 
		 }
		
	}
}



		  
		  
		  ?>
		  