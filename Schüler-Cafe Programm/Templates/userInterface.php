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
    here the text of the userInterface template begins
    <br>
    <!-- <?php
    var_dump($this->data);
    if(isset($this->data['test'])){
      echo $this->data['test'];
    }
    ?> -->
   </div>

   <div id="userList" style="color:purple;display:none;">
     <h1>User List</h1>
     <lo id="editField" style="display:none">
       <h2>Edit</h2><br>
       <a id="username_edit_memory" style="display:inline"></a>:
       <!-- in the <a></a> the userId is saved -->
       <form><a id="userId" style="display:none"></a>
         <input type="text" id="edit_username" placeholder="new username"> |
         <input type="password" id="edit_password" placeholder="new password"> |
         <input type="number" id="edit_role" placeholder="new role"> |
         <input type="text" id="edit_description" placeholder="new description"> |
         <input type ="button" onclick="editUser()" value="Submit">
         <input type ="button" onclick="hideEdit()" value="cancel">
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
           echo "<li name=\"$name\">$username | role: $role | $description | <button onclick='openEdit($name,\"$username\")'>edit</button> | <button onclick='deleteUser($name,\"$username\")'>delete</button></li>";
           echo "<br>";
           // echo implode(" ",$value);
         } // end foreach
       } // end if
       ?>
     </ul>

     <button onclick="openAdd()">Add User</button><br>
     <lo id="addField" style="display:none">
       <h2>Add User</h2><br>
       <form>
         <input type="text" id="add_username" placeholder="username">
         <input type="password" id="add_password" placeholder="password">
         <input type="number" id="add_role" placeholder="role">
         <input type="text" id="add_description" placeholder="description">
         <input type ="button" onclick="addUser()" value="Submit">
         <input type ="button" onclick="hideAdd()" value="cancel">
       </form>
     </lo><br><br>
   </div> <!-- userList -->




   <div style="color:brown;">
     here the text of the userInterface template ends
   </div>
  </body>
  <script type="text/javascript">
    var show_userList = <?php if(isset($this->data['userList'])){echo "true";}else{echo "false";} ?>;
    if(show_userList == true){
      document.getElementById('userList').style.display = "inline";
    }

    // dislplays the edit form
    function openEdit(userId,username){
      document.getElementById('userId').innerHTML = userId;
      document.getElementById('username_edit_memory').innerHTML = username;
      document.getElementById('editField').style.display = "inline";
    }

    // hides the edit form
    function hideEdit(){
      document.getElementById('editField').style.display = 'none';
    }

    // transmitts the changed input to the class.users.php script
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


    function openAdd(){
      document.getElementById('addField').style.display = "inline";
    }

    function hideAdd(){
      document.getElementById('addField').style.display = 'none';
    }

    // transmitts the data for the new user to the class.users.php script
    function addUser(){
      var username = document.getElementById('add_username').value;
      // console.log(username);
      var password = document.getElementById('add_password').value;
      // console.log(password);
      var role  = document.getElementById('add_role').value;
      // console.log(role);
      var description = document.getElementById('add_description').value;
      // console.log(description);
      location.replace("index.php?action=open_userInterface&userInterface=addUser&username="+username+"&password="+password+"&role="+role+"&description="+description);
    }

    function deleteUser(userId,username){
      if(confirm("Do you really want to delete the user \""+username+"\"?")){
        location.replace("index.php?action=open_userInterface&userInterface=deleteUser&user="+userId);
      }

    }
  </script>
</html>
