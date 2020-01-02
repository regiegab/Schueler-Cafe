<?php
class Magazine{
  // vars

  var $mInput; // Array
  var $return; // Array


  // functions
  //constructor
  public function __construct($input_from_control){
    echo "<br><br>Successfully opened \"class.magazine.php\"";
    $this->$mInput = $input_from_control;
    // var_dump($this->$mInput);
    $this->handleInput($this->$mInput);
  }

  //other functions
  private function handleInput($input){

    // switch to do different actions
    switch ($input){
      case "addProduct":
      //open menu with product, price, amount
      //add inserted values to db
      //INSERT INTO `magazine`(`ID`, `product`, `price`, `amount`) VALUES ([value-1],[value-2],[value-3],[value-4])
      break;
      case 'removeProduct':
        //remove the selected product from db
        //DELETE FROM `magazine` WHERE 0
      break;
      case 'editProduct':
        //open menu with price, amount of selected product
        //UPDATE `magazine` SET `ID`=[value-1],`product`=[value-2],`price`=[value-3],`amount`=[value-4] WHERE 1
        break;
      case "test":
        $this->return['test'] = "<br>   test successful<br>";
      default:
    }
  }

}
?>
