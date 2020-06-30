<?php

class Shop{

  // vars
  var $mInput; // Array
  var $db_return; // Array
  var $return; // Array

  var $products; //Array: a list of all the products
  var $settings; // Array with all the settings imported from db
  var $categories; //Array: a list of all the categories

  // functions

  //constructor
  public function __construct($input_from_control,$products,$settings,$categories){
    echo "<br><br>Successfully opened \"class.shop.php\"";

    $this->settings = $settings;
    $this->products = $products;
    $this->categories = $categories;
    $this->$mInput = $input_from_control;

    $this->handleInput($this->$mInput);
  }

  //other functions

  /**
    * processes the input from the control class
    * @param Array input
    */
  private function handleInput($input){

    // switch to do different actions

    switch ($input['shop']){
      case 'buy':

      break;
      case 'delete':

      break;
      default:
      $this->default();

    }//end switch

  }// end handleInput()

  public function default(){
    $this->return['productList'] = $this->products;
    $this->return['categoryList'] = $this->categories;
  }


}
?>
