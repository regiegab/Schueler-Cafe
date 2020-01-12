<?php
class shop{
  // vars

  var $mInput; // Array
  var $return; // Array
  var $products; //Array
  var $db_return; // Array
  var $cartContent; //Array

  // functions
  //constructor
  public function __construct($input_from_control,$products){
    echo "<br><br>Successfully opened \"class.shop.php\"";
    $this->products = $products;
    $this->$mInput = $input_from_control;
    // var_dump($this->products);
    $this->handleInput($this->$mInput);
  }
  //other functions
  private function handleInput($input){

    // switch to do different actions


    switch ($input['shop']){
      case "buy":

      break;
      case 'delete':

      break;

      case "test":
        $this->return['test'] = "<br>   test successful<br>";
      break;
      default:
      $this->cartContent = "cart";
      $this->openCart($this->cartContent);
      $this->displayProducts($this->products);
    }//end switch
  }// end handleInput()
  public function displayProducts($products){
    $this->return['products'] = $products;
  }

  public function openCart($cartContent){
    if (isset($cartContent)) {

      $this->return['cart'] = $cartContent;
      echo $cartContent;
    }



  }


}
?>






}









 ?>
