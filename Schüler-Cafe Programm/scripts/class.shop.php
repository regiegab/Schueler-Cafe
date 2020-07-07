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
      var_dump($input['cart_items']);
      var_dump($input['sum']);
      var_dump($input['time']);
      $this->processOrder($input['cart_items'],$input['sum'],$input['time']);
      break;
      default:
      $this->default();

    }//end switch

  }// end handleInput()

  private function default(){
    $this->return['productList'] = $this->products;
    $this->return['categoryList'] = $this->categories;
  } // end default

  /**
    * function adds a new product to db
    * @param String product_name
    * @param String category
    * @param String amount
    * @param String price
    * @param String refill
    */
  private function processOrder($cart_items_string,$sum,$time){
    $role_needed = $this->settings['shop_minimumRoleBuy'];
    if($this->compareRole($role_needed)){
      echo "<br>buy product<br>".$cart_items_string.$sum.$time."<br>";
      $cart_items_array = json_decode($cart_items_string);
      var_dump($cart_items_array);

      $this->db_return['action'] = "add";
      $this->db_return['add'] = 'INSERT INTO `purchases`(`cartContents`, `sum`) VALUES (\''.$cart_items_string.'\',\''.$sum.'\')';
    } else {
      $this->permissionInsufficient();
    }
  } // end processOrder


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

  // if the permission of the acting user is insufficient an error message will be displayed and the default userInterface will be displayed
  private function permissionInsufficient(){
    $this->alert("You do not have the permission to do that!");
    ?>
    <!-- this reloads the page so that the change can be seen in the html output -->
    <!DOCTYPE html>
    <html>
      <script type="text/javascript">
        location.replace("index.php?action=open_magazine");
      </script>
    </html>
    <?php
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


}
?>
