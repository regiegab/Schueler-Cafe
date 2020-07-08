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
      // var_dump($cart_items_array);

      $result = $this->checkAvailability($cart_items_array);
      $alerts = $result['alerts'];
      $query = $result['query'];

      echo "<br<br>sizeof:".sizeof($alerts);

      if(sizeof($alerts) == 0){
        $this->db_return['action1'] = "add";
        $this->db_return['add'] = 'INSERT INTO `purchases`(`cartContents`, `sum`) VALUES (\''.$cart_items_string.'\',\''.$sum.'\')';
        $this->db_return['action2'] = "process";
        $this->db_return['process'] = $query;
        echo "<br><br>add:<br>";
        var_dump($this->db_return['add']);
        echo "<br><br>process:<br>";
        var_dump($this->db_return['process']);
      }else{
        // echo "<br>alerts:<br>";
        // var_dump($alerts);
        $productAlerts = "Kauf fehlgeschlagen! Von folgenden Produkten sind nur noch auf Lager: ";
        foreach ($alerts as $key => $value) {
          $productAlerts = $productAlerts.$value['productName'].": ".$value['availableAmount']." | ";
        } // end foreach
        $this->alert($productAlerts);
        ?>
          <!-- this reloads the page so that the change can be seen in the html output -->
          <!DOCTYPE html>
          <html>
            <script type="text/javascript">
              location.replace("index.php?action=open_shop");
            </script>
          </html>
        <?php
        // echo "<br><br>alerts message:<br>";
        // echo $productAlerts;
      } // end if 2

    } else {
      $this->permissionInsufficient();
    } // end if 1
  } // end processOrder

  private function checkAvailability($items){
    $products = $this->products;
    echo "<br><br>Products:";
    var_dump($products);
    echo "<br>Items:";
    var_dump($items);

    $alerts = array();

    // the query that is later be sent to the db
    $query = array();

    //  checks whether there is enough of a product in the magazine
    foreach ($items as $keyItems => $valueItems) {
      $itemAmount = $valueItems[1];
      $itemId = $valueItems[0];
      foreach ($products as $keyProducts => $currentProduct) {
        $productId = $currentProduct[0];

        // match the current item (from the cart) with the corresponding product (from the magazine)
        if ($itemId == $productId) {
          $productAmount = $currentProduct[3];

          // here is checked wether the customer wants to buy to much of the product
          // if so the id and the amount of the product in stock is saved and later displayed
          if ($itemAmount > $productAmount) {
            $productName = $currentProduct[1];
            $currentAlert = array('productName' => $productName, 'availableAmount' => $productAmount);
            array_push($alerts,$currentAlert);
          }else{
            $newAmount = $productAmount - $itemAmount;
            $currentQuery = 'UPDATE `magazine` SET `amount`=\''.$newAmount.'\' WHERE `ID`=\''.$productId.'\';';
            array_push($query,$currentQuery);
          } // end if
        } // end if


      } // end foreach 2
    } // end foreach 1

    $result = array('alerts' => $alerts,'query' => $query);
    return $result;
  } // end checkAvailability

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
        location.replace("index.php?action=open_shop");
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
