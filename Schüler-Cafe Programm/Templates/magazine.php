<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Magazine</title>
  </head>
  <body>

    <br>
    <br>
    <br>
    <br>
    here the text of the magazine template begins
    <br>

    <div id="product_List" style="color:green;">

      <?php
      var_dump($this->data);
      // if(isset($this->data['test'])){
      //   echo $this->data['test'];
      // }
      ?>

      <h1>Product List</h1>

      <lo id="editField" style="display:none">
        <h2>Edit</h2><br>
        <a id="product_edit_memory" style="display:inline"></a>:
        <!-- in the <a></a> the productId is saved -->
        <form><a id="productId" style="display:none"></a>
          <input type="text" id="edit_name" placeholder="neuer Produktname">
          <select id="edit_category">
            <?php
            // creates the drop-down menu to select the category
              if(isset($this->data['categoryList'])){
                foreach ($this->data['categoryList'] as $key => $value) {
                  echo "<option value=\"".$value[0]."\">".$value[1]."</option>";
                } // end foreach
              } // end if
            ?>
          </select>
          <input type="number" id="edit_amount" placeholder="neue Anzahl">
          <input type="number" id="edit_price" placeholder="neuer Preis pro Produkt">
          <input type="number" id="edit_refill" placeholder="neue Nachfüllwarnung bei...">
          <input type ="button" onclick="editProduct()" value="Submit">
          <input type ="button" onclick="hideEdit()" value="cancel">
        </form>
      </lo>


      <ul style="list-style-type:none">
        <?php
        if(isset($this->data['productList'])){
          echo "<div>
                <table style=overflow-x:auto;>
                  <tr>
                    <th>ID</th>
                    <th>Produkt</th>
                    <th>Kategorie</th>
                    <th>Anzahl</th>
                    <th>Preis</th>
                    <th>Nachfüllwarnung bei...</th>
                  </tr>";
          foreach ($this->data['productList'] as $value) {
            // var_dump($value);
            $id = $value[0];
            $product = $value[1];
            $price = $value[2];
            $amount = $value[3];
            $category_Id = $value[4];
            $refill_at = $value[5];

            // echo "<br><br>";
            // var_dump($this->data['categoryList']);
            // echo "<br>";

            // --> display category name instead of its id
            $category_name = null;
            if(isset($this->data['categoryList'])){
              foreach ($this->data['categoryList'] as $key => $value1) {
                if($category_Id == $this->data['categoryList'][$key][0]){
                  $category_name = $this->data['categoryList'][$key][1];
                } // end if
              } // end foreach

              // echo "<br>";
              // var_dump($category_name);
              // echo "<br>";
            } // end if


            //echo "<div><table>$id.$product.$amount.$price.</table></div>";
            //echo "<br>";
            // echo implode(" ",$value);
            echo "  <tr>
                      <td> $id </td>
                      <td> $product </td>
                      <td> $category_name </td>
                      <td> $amount </td>
                      <td> $price </td>
                      <td> $refill_at </td>
                      <td> <button onclick='deleteProduct($id, \"$product\")'>Löschen</button> </td>
                      <td> <button onclick='openEdit($id, \"$product\")'>Produkt bearbeiten</button> </td>
                    </tr>";
          } // end foreach

          echo" </table>
                </div>";
        } // end if
        ?>

      </ul>

      <button type="button" onclick="openAdd()">Add Product</button>
      <button type="button" onclick="document.getElementById('category_list').style.display = 'inline'">Show categories</button>
      <button type="button" onclick="document.getElementById('category_list').style.display = 'none'">Hide categories</button><br>

      <lo id="addField" style="display:none">
        <h2>Add Product</h2><br>
        <form>
          <input type="text" id="add_name" placeholder="Produktname">
          <select id="add_category">
            <?php
            // creates the drop-down menu to select the category
              if(isset($this->data['categoryList'])){
                foreach ($this->data['categoryList'] as $key => $value) {
                  echo "<option value=\"".$value[0]."\">".$value[1]."</option>";
                } // end foreach
              } // end if
            ?>
          </select>
          <input type="number" id="add_amount" placeholder="Anzahl">
          <input type="number" id="add_price" placeholder="Preis pro Produkt">
          <input type="number" id="add_refill" placeholder="Nachfüllwarnung bei...">
          <input type ="button" onclick="addProduct()" value="Submit">
          <input type ="button" onclick="hideAdd()" value="cancel">
        </form>
      </lo><br><br>
    </div>




    <div id="category_list" style="display:none">

      <lo id="editField_category" style="display:none">
        <h2>Edit</h2><br>
        <a id="category_edit_memory" style="display:inline"></a>:
        <!-- in the <a></a> the productId is saved -->
        <form><a id="categoryId" style="display:none"></a>
          <input type="text" id="edit_name_category" placeholder="neue Kategoriebezeichnung">
          <input type="text" id="edit_describtion_category" placeholder="neue Kategoriebeschreibung">
          <input type ="button" onclick="editCategory()" value="Submit">
          <input type ="button" onclick="document.getElementById('editField_category').style.display = 'none'" value="cancel">
        </form>
      </lo>

      <?php
      if(isset($this->data['categoryList'])){
        echo "<div>
              <table style=overflow-x:auto;>
                <tr>
                  <th>Kategoriebezeichnung</th>
                  <th>Beschreibung</th>
                </tr>";
        foreach ($this->data['categoryList'] as $category_Id => $value) {
          // var_dump($value);
          $category_Id = $value[0];
          $category_name = $value[1];
          $describtion = $value[2];

          //echo "<div><table>$id.$product.$amount.$price.</table></div>";
          //echo "<br>";
          // echo implode(" ",$value);
          echo "  <tr>
                    <td> $category_name </td>
                    <td> $describtion </td>
                    <td> <button onclick='deleteCategory($category_Id, \"$category_name\")'>Löschen</button> </td>
                    <td> <button onclick='openEditCategory($category_Id, \"$category_name\")'>Kategorie bearbeiten</button> </td>
                  </tr>";
        } // end foreach

        echo" </table>
              </div>";
      } // end if
      ?>

      <button type="button" onclick="openAddCategory()">Add Category</button>
      Hinweis: Es können nur Kategorien gelöscht werden, die von keinem Produkt mehr benutzt werden!<br>

      <lo id="addFieldCategory" style="display:none">
        <h2>Add Category</h2><br>
        <form>
          <input type="text" id="add_name_category" placeholder="Kategoriebezeichnung">
          <input type="text" id="add_describtion_category" placeholder="Beschreibung">
          <input type ="button" onclick="addCategory()" value="Submit">
          <input type ="button" onclick="document.getElementById('addFieldCategory').style.display = 'none'" value="cancel">
        </form>
      </lo><br><br>
    </div>

  </body>

  <script type="text/javascript">

    function deleteCategory(category_Id, category_name){
      if(confirm("Do you really want to delete this category \""+category_name+"\"?")){
        // console.log("index.php?action=open_magazine&magazine=removeProduct&productId="+productId);
        location.replace("index.php?action=open_magazine&magazine=removeCategory&category_Id="+category_Id);
      } // end if
    } // end deleteCategory

    function openEditCategory(category_Id, category_name){
      document.getElementById('categoryId').innerHTML = category_Id;
      document.getElementById('category_edit_memory').innerHTML = category_name;
      document.getElementById('editField_category').style.display = "inline";
    } // end deleteCategory

    function openAddCategory(){
      document.getElementById('addFieldCategory').style.display = "inline";
    } // end openAddCategory

    function addCategory(){
      var category_name = document.getElementById('add_name_category').value;
      var describtion = document.getElementById('add_describtion_category').value;

      location.replace("index.php?action=open_magazine&magazine=addCategory&category_name="+category_name+"&describtion="+describtion);
    } // end deleteCategory

    function editCategory(){
      var categoryId = document.getElementById('categoryId').innerHTML;
      var category_name = document.getElementById('edit_name_category').value;
      var describtion = document.getElementById('edit_describtion_category').value;
      location.replace("index.php?action=open_magazine&magazine=editCategory&categoryId="+categoryId+"&category_name="+category_name+"&describtion="+describtion);
    } // end editCategory





    function openAdd(){
      document.getElementById('addField').style.display = "inline";
    } // end openAdd

    function hideAdd(){
      document.getElementById('addField').style.display = 'none';
    } // end hideAdd

    // transmitts the data for the new product to the class.magazine.php script
    function addProduct(){
      var product_name = document.getElementById('add_name').value;
      // console.log(product_name);
      var category = document.getElementById('add_category').value;
      // console.log(category);
      var amount  = document.getElementById('add_amount').value;
      // console.log(amount);
      var price = document.getElementById('add_price').value;
      // console.log(price);
      var refill = document.getElementById('add_refill').value;
      // console.log(refill);

      // console.log("index.php?action=open_magazine&magazine=addProduct&product_name="+product_name+"&category="+category+"&amount="+amount+"&price="+price+"&refill="+refill);
      location.replace("index.php?action=open_magazine&magazine=addProduct&product_name="+product_name+"&category="+category+"&amount="+amount+"&price="+price+"&refill="+refill);
    } // end addProduct

    function deleteProduct(productId,product_name){
      if(confirm("Do you really want to delete the product \""+product_name+"\"?")){
        // console.log("index.php?action=open_magazine&magazine=removeProduct&productId="+productId);
        location.replace("index.php?action=open_magazine&magazine=removeProduct&productId="+productId);
      } // end if
    } // end deleteProduct

    // dislplays the edit form
    function openEdit(productId,product_name){
      document.getElementById('productId').innerHTML = productId;
      document.getElementById('product_edit_memory').innerHTML = product_name;
      document.getElementById('editField').style.display = "inline";
    }

    // hides the edit form
    function hideEdit(){
      document.getElementById('editField').style.display = 'none';
    }

    // transmitts the changed input to the class.users.php script
    function editProduct(){
      var productId = document.getElementById('productId').innerHTML;
      // console.log(productId);
      var product_name = document.getElementById('edit_name').value;
      // console.log(product_name);
      var category = document.getElementById('edit_category').value;
      // console.log(category);
      var amount  = document.getElementById('edit_amount').value;
      // console.log(amount);
      var price = document.getElementById('edit_price').value;
      // console.log(price);
      var refill = document.getElementById('edit_refill').value;
      // console.log(refill);

      // console.log("index.php?action=open_magazine&magazine=editProduct&productId="+productId+"product_name="+product_name+"&category="+category+"&amount="+amount+"&price="+price+"&refill="+refill);
      location.replace("index.php?action=open_magazine&magazine=editProduct&productId="+productId+"&product_name="+product_name+"&category="+category+"&amount="+amount+"&price="+price+"&refill="+refill);
    } // end editProduct

  </script>

</html>
