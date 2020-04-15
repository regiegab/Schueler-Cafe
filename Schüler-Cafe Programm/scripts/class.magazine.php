<?php
class Magazine{

  // vars
  var $mInput; // Array
  var $return; // Array
  var $products; //Array
  var $db_return; // Array

  var $settings; // Array with all the settings from db

  // functions

  //constructor
  public function __construct($input_from_control,$products,$settings){
    echo "<br><br>Successfully opened \"class.magazine.php\"";

    $this->settings = $settings;

    $this->products = $products;
    $this->$mInput = $input_from_control;
    // var_dump($this->products);
    $this->handleInput($this->$mInput);
  }

  //other functions

  /**
    * processes the input from the control class
    * @param Array input
    */
  private function handleInput($input){

    // switch to do different actions
    if(isset($input['magazine'])){
      switch ($input['magazine']){
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
        // case "test":
        //   $this->return['test'] = "<br>   test successful<br>";
        // break;
        default:
        $this->displayProducts($this->products);
      }//end switch
    }else{
      $this->displayProducts($this->products);
    }
  }// end handleInput()

  private function displayProducts($products){
    $this->return['productList'] = $products;
  }


  /**
    * function deletes a product
    * @param int userId
    */
  public function deleteProduct($product){

      echo "delete product".$product;
      $this->db_return['action'] = "delete";
      $this->db_return['delete'] = 'DELETE FROM `magazine` WHERE `ID` = '.$product;

  }

  /**
    * function adds a product
    * @param String username
    * @param String password
    * @param String role
    * @param String description
    */
  public function addProduct(){

  }

  /**
    * function edits product
    * @param int userID
    * @param String username
    * @param String password
    * @param String role
    * @param String description
    */
  public function editProduct(){

  }

}
?>
