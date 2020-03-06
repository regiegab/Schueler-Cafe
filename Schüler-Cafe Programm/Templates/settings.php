<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <!-- test div -->

   <div style="color:brown;">
    <br>
    <br>
    <br>
    <br>
    here the text of the settings template begins
    <br>
    <!-- <?php
    var_dump($this->data);
    if(isset($this->data['test'])){
      echo $this->data['test'];
    }
    ?> -->
   </div>

   <div id=goToMenuDiv>
     <button type="button" onclick="location.replace('index.php?action=mainMenu')">Go back to menu</button>
   </div>

   <div id="settingsList" style="color:purple;display:none;">
     <h1>Settings:</h1>
     <lo id="editField" style="display:none">
       <h2>Edit</h2><br>
       <a id="setting_edit_memory" style="display:inline"></a>:

       <!-- in the <a></a> the settingId is saved -->
       <form><a id="settingId" style="display:none"></a>
         <input type="number" id="edit_value" placeholder="new value"> |
         <input type="number" id="edit_security_level" placeholder="new security level"> |
         <input type="text" id="edit_description" placeholder="new description"> |
         <input type ="button" onclick="editSetting()" value="Submit">
         <input type ="button" onclick="hideEdit()" value="cancel">
       </form>
     </lo>

     <ul style="list-style-type:none">
       <?php
       if(isset($this->data['settingsList'])){
         foreach ($this->data['settingsList'] as $value) {
           // var_dump($value);
           $name = $value[0];
           $setting_name = $value[1];
           $setting_value = $value[2];
           $security_level = $value[3];
           $description = $value[4];
           echo "<li name=\"$name\">$setting_name | value: $setting_value | security level: <a id=\"old_security_level$name\">$security_level</a> | $description | <button type=\"button\" onclick='openEdit($name,\"$setting_name\")'>edit</button></li>";
           echo "<br>";
           // echo implode(" ",$value);
         } // end foreach
       } // end if
       ?>
     </ul>
     </div>


   <div style="color:brown;">
     here the text of the settings template ends
   </div>
  </body>
  <script type="text/javascript">
    var show_settingsList = <?php if(isset($this->data['settingsList'])){echo "true";}else{echo "false";} ?>;
    if(show_settingsList == true){
      document.getElementById('settingsList').style.display = "inline";
    }

    // dislplays the edit form
    function openEdit(settingId,setting_name){
      document.getElementById('settingId').innerHTML = settingId;
      document.getElementById('setting_edit_memory').innerHTML = setting_name;
      document.getElementById('editField').style.display = "inline";
    }

    // hides the edit form
    function hideEdit(){
      document.getElementById('editField').style.display = 'none';
    }

    // transmitts the changed input to the class.users.php script
    function editSetting(){
      var settingId = document.getElementById('settingId').innerHTML;
      // console.log(settingId);
      var newValue = document.getElementById('edit_value').value;
      // console.log(edit_value);
      var security_level = document.getElementById('edit_security_level').value;
      // console.log(edit_security_level);
      var description = document.getElementById('edit_description').value;
      // console.log(description);
      var old_security_level_id = "old_security_level"+settingId;
      var old_security_level = document.getElementById(old_security_level_id).innerHTML;
      // console.log(old_security_level);
      // console.log("index.php?action=open_settings&settings=changeSetting&setting="+settingId+"&value="+newValue+"&security_level="+security_level+"&description="+description+"&old_security_level="+old_security_level);
      location.replace("index.php?action=open_settings&settings=changeSetting&setting="+settingId+"&value="+newValue+"&security_level="+security_level+"&description="+description+"&old_security_level="+old_security_level);
    }
  </script>
</html>
