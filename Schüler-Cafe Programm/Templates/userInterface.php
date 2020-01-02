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

   <div id="userList" style="color:blue">
     <h1>User List</h1>
     <ul style="list-style-type:none">
       <?php
       if (isset($this->data['userList'])){
         foreach ($this->data['userList'] as $value) {
           // var_dump($value);
           $name = $value[0];
           $username = $value[1];
           $role = $value[2];
           $description = $value[3];
           echo "<li name=\"".$name."\">".$username." | role: ".$role." | ".$description." | <button>edit</button> | <button>delete</button></li>";
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
</html>
