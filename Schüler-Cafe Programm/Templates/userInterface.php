<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <!-- test div -->

   <div style="color:green;">
    <br>
    <br>
    <br>
    <br>
    here the text of the userInterface template begins
    <br>
    <?php
    var_dump($this->data);
    if(isset($this->data['test'])){
      echo $this->data['test'];
    }
    ?>
   </div>

   <div id="userList" style="color:blue;display:none;">
     <h1>User List</h1>
     <lo id="editField" style="display:none">
       <h2>Edit</h2>:<br>
       <!-- in the <a></a> the userId is saved -->
       <form><a id="userId" style="display:none"></a>
         <input type="text" id="edit_username" placeholder="username"> |
         <input type="text" id="edit_password" placeholder="password"> |
         <input type="number" id="edit_role" placeholder="role"> |
         <input type="text" id="edit_description" placeholder="description"> |
         <input type ="button" onclick="editUser()" value="Submit">
         <input type ="button" onclick="hideEditField()" value="cancel">
       </form>
     </lo>
     <ul style="list-style-type:none">
       <?php
       if(isset($this->data['userList'])){
         foreach ($this->data['userList'] as $value) {
           // var_dump($value);
           $name = $value[0];
           $username = $value[1];
           $role = $value[2];
           $description = $value[3];
           echo "<li name=\"".$name."\">".$username." | role: ".$role." | ".$description." | <button onclick=\"openEdit(".$name.")\">edit</button> | <button onclick='deleteUser(".$name.",\"".$username."\")'>delete</button></li>";
           echo "<br>";
           // echo implode(" ",$value);

         } // end foreach
       } // end if
       ?>
     </ul>
   </div>

   <div style="color:darkgreen">
     here the text of the userInterface template ends
   </div>
  </body>
  <script type="text/javascript">
    var show_userList = <?php if(isset($this->data['userList'])){echo "true";}else{echo "false";} ?>;
    if(show_userList == true){
      document.getElementById('userList').style.display = "inline";
    }

    function openEdit(userId){
      document.getElementById('userId').innerHTML = userId;
      document.getElementById('editField').style.display = "inline";
    }

    function hideEditField(){
      document.getElementById('editField').style.display = 'none';
    }

    function editUser(){
      var userId = document.getElementById('userId').innerHTML;
      // console.log(userId);
      var username = document.getElementById('edit_username').value;
      // console.log(username);
      var password = document.getElementById('edit_password').value;
      // console.log(password);
      var role  = document.getElementById('edit_role').value;
      // console.log(role);
      var description = document.getElementById('edit_description').value;
      // console.log(description);
      location.replace("index.php?action=open_userInterface&userInterface=editUser&user="+userId+"&username="+username+"&password="+password+"&role="+role+"&description="+description);
    }

    function deleteUser(userId,username){
      if(confirm("Do you really want to delete the user \""+username+"\"?")){
        location.replace("index.php?action=open_userInterface&userInterface=deleteUser&user="+userId);
      }

    }
  </script>
</html>
