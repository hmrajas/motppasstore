  <div id=editpasscard title="Edit PassCard" class="passcard last" >
    
 <table width="550" height="158" border="0" cellpadding="4" cellspacing="4">
  <tr>
    <td colspan="2" id=  ><table width="100%" border="0" cellpadding="1" cellspacing="1">
  <tr>
    <td width="8%">&nbsp;</td>
    <td width="33%">PassCard Name</td>
    <td width="59%"><input type="text" name="name" id="ename" /><input type=hidden id=eservice  /><input type=hidden id=efile  /></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>Username/ID</td>
    <td><input type="text" name="user" id="euser" /></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">Password</td>
    <td><input type="password" name="password" id="epassword" />&nbsp;[<a href=# onclick="if (document.getElementById('epassword').type=='password') { (document.getElementById('epassword').type='text')} else { (document.getElementById('epassword').type='password') }">show/hide</a>] </td>
  </tr>
   <tr>
     <td>&nbsp;</td>
     <td>Form URL</td>
     <td><input type="text" name="form_url" id="eform_url" /></td>
   </tr>
   <tr>
    <td>&nbsp;</td>
    <td>Search tag</td>
    <td><input type="text" name="tag" id="etag" /></td>
   </tr>
  <tr>
  <tr>
    <td colspan="3" align="right"><br />
<fieldset id=customedit style="display:noned; padding:10px"><legend>custom parameters</legend>
<table width="100%" align="center">
<tr><td nowrap="nowrap">Username field name</td>
    <td><input name="eufield" type="text" id="eufield" value=" " /></td>
    </tr>
<tr><td nowrap="nowrap">Password field name</td>
    <td><input name="epfield" type="text" id="epfield" value=" " /></td>
    </tr>

<tr><td nowrap="nowrap">Form type</td>
    <td><input name="eftype" type="text" id="eftype" value=" " /></td>
    </tr>
    
   <tr><td nowrap="nowrap">Submit button name</td>
    <td><input name="esname" type="text" id="esname" value=" " /></td>
    </tr>
    
     <tr><td nowrap="nowrap">Submit button value</td>
    <td><input name="esvalue" type="text" id="esvalue" value=" " /></td>
    </tr>
     <tr>
       <td valign="top" nowrap="nowrap">Additional parameters</td>
       <td><textarea name="eadd" cols="33" rows="4" id="eadd"> </textarea></td>
     </tr>
</table>
    </fieldset></td>
  </tr>
  <tr>
    <td colspan="3" align="right"><div id=editresult style="color:#009999" > </div><br />
 [<a href=#  onclick="if (window.myValue.length >2) { var encPair=encrypt( 'Decrypted|PSSPRT|'+document.getElementById('euser').value+'|PSSPRT|'+document.getElementById('epassword').value,window.myValue); document.getElementById('hash').value=encPair; load('webservice.php?action=save&data='+encPair+'&file='+document.getElementById('efile').value+'&service='+document.getElementById('eservice').value+'&form_url='+escape(document.getElementById('eform_url').value)+'&tag='+document.getElementById('etag').value+'&name='+document.getElementById('ename').value+'&ufield='+document.getElementById('eufield').value+'&pfield='+document.getElementById('epfield').value+'&sname='+document.getElementById('esname').value+'&svalue='+document.getElementById('esvalue').value+'&form_method='+document.getElementById('eftype').value+'&additional='+document.getElementById('eadd').value,'editresult');   return false; load('passcards.php','passcards'); } else {alert('no/short passphrase specified. please provide a passphrase');  return false; load('passcards.php','passcards'); }" ><strong>save</strong></a>]  </td>
  </tr>
</table> 
</td>
    </tr>
  
   
</table>
 <input type="hidden"   id="hash" size="88" />
 
        
          </div>
          
           