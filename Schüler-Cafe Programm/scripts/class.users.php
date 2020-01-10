<?php
class Users{
  // vars

  var $uInput; // Array
  var $userList; // Array
  var $return; // Array
  var $db_return; // Array


  // functions
  // constructor
  public function __construct($input_from_control,$userList){
    echo "<br><br>Successfully opened \"class.users.php\"<br>";
    $this->userList = $userList;
    $this->$uInput = $input_from_control;

    $this->handleInput($this->$uInput);
  }

  // other functions
  private function handleInput($input){
    // switch to do different actions
    if(isset($input['userInterface'])){
      switch ($input['userInterface']){
        case "addUser":
          $this->addUser($input['username'],$input['password'],$input['role'],$input['description']);
        break;
        case 'deleteUser':
          $this->deleteUser($input['user']);
          // $this->show_userList($this->userList);
        break;
        case 'editUser':
          $this->editUser($input['user'],$input['edit']);
          // $this->show_userList($this->userList);
        break;
        case "test":
        // echo "<br>test class<br>";
          $this->return['test'] = "<br>   test successful<br>";
        break;
        default:
          //show list of all users
          $this->show_userList($this->userList);
      } // end switch
    } else {
      $this->show_userList($this->userList);
    } // end if



  } // end handleInput()

  public function show_userList($userList){
    // var_dump($userList);
    echo "<br><br>";
    $this->return['userList'] = $userList;
  }

  /**
    * function to send an alert (HTML)
    * @param String message
    */
  private function alert($message){
    ?><!DOCTYPE html>
    <html>
      <head>
      </head>
      <body>

      </body>
      <script type="text/javascript">
        alert("<?php echo $message; ?>");
      </script>
    </html>
    <?php
  }


  /**
    * function to compare necessary role status with user
    * returns true if role status is high enough
    * @param int role_needed
    */
  private function compareRole($role_needed){
    if ($role_needed <= $_SESSION['role']) {
      return true;
    } else {
      return false;
    }
  }


  /**
    * function edits user
    * @param int userId
    * @param String what should be edited
    */
  public function editUser($user,$edit){
    $role_needed = 4;
    if($this->compareRole($role_needed)){
      echo "edit user".$user;
    } else {
      $this->permissionInsufficient();
    }
  }

  /**
    * function deletes an user
    * @param int userId
    */
  public function deleteUser($user){
    $role_needed = 4;
    if($this->compareRole($role_needed)){
      echo "delete user".$user;
      $this->db_return['action'] = "delete";
      $this->db_return['delete'] = 'DELETE FROM `user` WHERE `ID` = '.$user;
    } else {
      $this->permissionInsufficient();
    }
  }

  /**
    * function adds a new user
    * @param String username
    * @param String password
    * @param String role
    * @param String description
    */
  public function addUser($username,$password,$role,$description){
    $role_needed = 4;
    if($this->compareRole($role_needed)){
      echo "<br>add user<br>".$username.$password.$role.$description."<br>";
      $this->db_return['action'] = "add";
      $this->db_return['add'] = 'INSERT INTO `user`(`ID`, `login`, `password`, `role`, `description`) VALUES (NULL,\''.$username.'\',\''.$password.'\',\''.$role.'\',\''.$description.'\')';
    } else {
      $this->permissionInsufficient();
    }
  }

  // if the permission of the acting user is insufficient an error message will be displayed and the default userInterface will be displayed
  private function permissionInsufficient(){
    $this->alert("You do not have the permission to do that!");
    ?>
    <!-- this reloads the page so that the change can be seen in the html output -->
    <!DOCTYPE html>
    <html>
      <script type="text/javascript">
        location.replace("http://susocafe.bplaced.net/index.php?action=open_userInterface");
      </script>
    </html>
    <?php
  }

}
?>
