<?php
class Magazine{

  // vars
  var $mInput; // Array: input coming from control class
  var $products; //Array: a list of all the products
  var $settings; // Array with all the settings imported from db
  var $categories; //Array: a list of all the categories

  var $db_return; // Array: the query that should be executed in db
  var $return; // Array: what should be returned to control class (later passed to template)

  // functions

  //constructor
  public function __construct($input_from_control,$products,$settings,$categories){
    echo "<br><br>Successfully opened \"class.magazine.php\"";

    $this->settings = $settings;
    $this->products = $products;
    $this->categories = $categories;
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
          $this->addProduct($input['product_name'],$input['category'],$input['amount'],$input['price'],$input['refill']);
        break;
        case 'removeProduct':
          $this->deleteProduct($input['productId']);
        break;
        case 'editProduct':
        $parameters = [
          'product' => $input['product_name'],
          'category_ID' => $input['category'],
          'amount' => $input['amount'],
          'price' => $input['price'],
          'refill' => $input['refill'],
        ];
        $this->editProduct($input['productId'],$parameters);
        break;

        case "addCategory":
          $this->addCategory($input['category_name'],$input['describtion']);
        break;
        case 'removeCategory':
          $this->removeCategory($input['category_Id']);
        break;
        case 'editCategory':
        $parameters = [
          'category' => $input['category_name'],
          'describtion' => $input['describtion'],
        ];
        $this->editCategory($input['categoryId'],$parameters);
        break;

        default:
        $this->displayProducts();
      }//end switch
    }else{
      $this->displayProducts();
    } // end if
  } // end handleInput()

  /**
    * function adds a new product to db
    * @param String product_name
    * @param String category
    * @param String amount
    * @param String price
    * @param String refill
    */
  public function addCategory($category_name,$describtion){
    $role_needed = $this->settings['magazine_minimumRoleAddCategory'];
    if($this->compareRole($role_needed)){
      echo "<br>add category<br>".$category_name.$describtion."<br>";

      $this->db_return['action'] = "add";
      $this->db_return['add'] = 'INSERT INTO `categories_products`(`ID`, `category`, `describtion`) VALUES (NULL,\''.$category_name.'\',\''.$describtion.'\')';
    } else {
      $this->permissionInsufficient();
    }
  }

  /**
    * function deletes a product
    * @param int productId
    */
  public function removeCategory($categoryId){
    $role_needed = $this->settings['magazine_minimumRoleDeleteCategory'];
    if($this->compareRole($role_needed)){
      echo "delete category".$categoryId;
      $this->db_return['action'] = "delete";
      $this->db_return['delete'] = 'DELETE FROM `categories_products` WHERE `ID` = '.$categoryId;
    } else {
      $this->permissionInsufficient();
    }
  } // end removeCategory

  /**
    * function edits a category
    * @param int productId
    * @param String product_name
    * @param String category
    * @param String amount
    * @param String price
    * @param String refill
    */
  // public function editUser($productId,$product_name,$category,$amount,$price,$refill){
  public function editCategory($categoryId,$parameters){
    $role_needed = $this->settings['magazine_minimumRoleEditCategory'];
    if($this->compareRole($role_needed)){

      $query = $this->createEditQuery('categories_products',$parameters);

      $query = $query.' WHERE `ID` = '.$categoryId;

      $this->db_return['action'] = "edit";
      $this->db_return['edit'] = $query;
      // var_dump($query);
    } else {
      $this->permissionInsufficient();
    }
  } // end editCategory

  /**
    * function displays all products
    * @param Array array of all products
    */
  private function displayProducts(){
    $products = $this->products;
    $categories = $this->categories;
    $this->return['productList'] = $products;
    $this->return['categoryList'] = $categories;
  }

  /**
    * function adds a new product to db
    * @param String product_name
    * @param String category
    * @param String amount
    * @param String price
    * @param String refill
    */
  public function addProduct($product_name,$category,$amount,$price,$refill){
    $role_needed = $this->settings['magazine_minimumRoleAdd'];
    if($this->compareRole($role_needed)){
      echo "<br>add product<br>".$product_name.$category.$amount.$price.$refill."<br>";

      $this->db_return['action'] = "add";
      $this->db_return['add'] = 'INSERT INTO `magazine`(`ID`, `product`, `price`, `amount`, `category_ID`, `refill`) VALUES (NULL,\''.$product_name.'\',\''.$price.'\',\''.$amount.'\',\''.$category.'\',\''.$refill.'\')';
    } else {
      $this->permissionInsufficient();
    }
  }

  /**
    * function deletes a product
    * @param int productId
    */
  public function deleteProduct($productId){
    $role_needed = $this->settings['magazine_minimumRoleDelete'];
    if($this->compareRole($role_needed)){
      echo "delete product".$productId;
      $this->db_return['action'] = "delete";
      $this->db_return['delete'] = 'DELETE FROM `magazine` WHERE `ID` = '.$productId;
    } else {
      $this->permissionInsufficient();
    }
  }

  /**
    * function edits a product
    * @param int productId
    * @param String product_name
    * @param String category
    * @param String amount
    * @param String price
    * @param String refill
    */
  // public function editUser($productId,$product_name,$category,$amount,$price,$refill){
  public function editProduct($productId,$parameters){
    $role_needed = $this->settings['magazine_minimumRoleEdit'];
    if($this->compareRole($role_needed)){
      // echo "<br>edit user<br>".$product_name,$category,$amount,$price,$refill."<br>";
      $query = $this->createEditQuery('magazine',$parameters);
      //
      //
      // $query = 'UPDATE `magazine` SET ';
      // $komma = false;
      // if($product_name != null){
      //   $query = $query.'`product`=\''.$product_name.'\'';
      //   $komma = true;
      // }
      //
      // if($price != null){
      //   if($komma==true){
      //     $query = $query.',';
      //   }
      //   $query = $query.'`price`=\''.$price.'\'';
      //   $komma = true;
      // }else{
      //   // $komma = false;
      // }
      //
      // if($amount != null){
        // if($komma==true){
        //   $query = $query.',';
        // }
      //   $query = $query.'`amount`='.$amount;
      // }else{
      //   // $komma = false;
      // }
      //
      // if($category != null){
      //   if($komma==true){
      //     $query = $query.',';
      //   }
      //   $query = $query.'`category_ID`=\''.$category.'\'';
      // }

      $query = $query.' WHERE `ID` = '.$productId;

      $this->db_return['action'] = "edit";
      $this->db_return['edit'] = $query;
      // var_dump($query);
    } else {
      $this->permissionInsufficient();
    }
  }

  /**
    * creates most of the edit query needed ín order to edit a product/category entry in db
    * @param Array parameters (that should be edited)
    */
  private function createEditQuery($section,$parameters){
    // $query = 'UPDATE `$section` SET ';
    $query = $query.'UPDATE `';
    $query = $query.$section;
    $query = $query.'` SET ';

    // echo "<br><br>";
    // var_dump($parameters);
    // echo "<br><br>";
    $komma = false;
    foreach ($parameters as $key => $value) {
      if($parameters[$key] != null){
        // echo "<br>Komma $key:<br>";
        // var_dump($komma);
        // echo "<br><br>";
        if($komma==true){
          $query = $query.',';
        } // end if 2
        $query = $query.'`'.$key.'`=\''.$value.'\'';
        $komma = true;
      } else {

      } // end if 1
    } // end foreach
    return $query;
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
