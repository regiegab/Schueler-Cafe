<?php
class Users{
  // vars

  var $uInput; // Array
  var $userList; // Array
  var $return; // Array


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
    switch ($input){
      case "addUser":
      //open menu with product, price, amount
      //add inserted values to db
      //INSERT INTO `magazine`(`ID`, `product`, `price`, `amount`) VALUES ([value-1],[value-2],[value-3],[value-4])
      break;
      case 'removeUser':
        //remove the selected product from db
        //DELETE FROM `magazine` WHERE 0
      break;
      case 'editUser':
        //open menu with price, amount of selected product
        //UPDATE `magazine` SET `ID`=[value-1],`product`=[value-2],`price`=[value-3],`amount`=[value-4] WHERE 1
      break;
      case "test":
      // echo "<br>test class<br>";
        $this->return['test'] = "<br>   test successful<br>";
      break;
      default:
        //show list of all users
        $userList = $this->userList;
        $this->show_userList($userList);
    }


  } // end handleInput()

  private function show_userList($userList){
    // var_dump($userList);
    echo "<br><br>";
    $this->return['userList'] = $userList;
  }


}
?>
