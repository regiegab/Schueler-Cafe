<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Shop</title>
  </head>
  <body>
    <!-- test div -->
    <div style="color:green;">
      <br>
      <br>
      <br>
      <br>
      here the text of the shop template begins
      <br>
      <?php
        echo "<br><br>ProductList:<br>";
        var_dump($this->data['productList']);
        echo "<br>";
        echo "<br>";
        var_dump($this->data['categoryList']);
        echo "<br><br>";
       ?>
    </div>

    <div id="categories_overview" style="display:inline">
      <h2>Kategorien</h2>
      <button id="category_all" onclick="openCategory('all')">Alles Anzeigen</button>
      <?php
        if(isset($this->data['categoryList']) && isset($this->data['productList'])){

          $products = $this->data['productList'];
          $categories = $this->data['categoryList'];
          foreach ($categories as $key => $value) {
            echo "<button id=\"category_$value[0]\" onclick=\"openCategory($value[0])\">$value[1]</button>";
          } // end foreach


          foreach ($categories as $key => $valueCategories) {
            echo "  <div id=\"items_category_$valueCategories[0]\" style=\"display:none\">";

            echo "<h3>$valueCategories[1]</h3>";

            echo "<table style=overflow-x:auto;>
                    <tr>
                      <th>ID</th>
                      <th>Produkt</th>
                      <th>Kategorie</th>
                      <th>Anzahl</th>
                      <th>Preis</th>
                      <th><button onclick=\"closeCategory($valueCategories[0])\">Schließen</button></th>
                    </tr>";

            foreach ($products as $key => $valueProducts) {
              if($valueProducts[4] == $valueCategories[0]){
                $id = $valueProducts[0];
                $product = $valueProducts[1];
                $price = $valueProducts[2];
                $amount = $valueProducts[3];
                $category_Id = $valueProducts[4];

                // --> display category name instead of its id
                $category_name = null;
                if(isset($this->data['categoryList'])){
                  $category_name = $this->data['categoryList'][$category_Id][1];

                } // end if

                echo "  <tr>
                          <td> $id </td>
                          <td> $product </td>
                          <td> $category_name </td>
                          <td> $amount </td>
                          <td> $price </td>
                          <td> <button onclick='addToCart($id,\"$product\",\"$category_name\",$price)'>Zum Einkaufswagen hinzufügen</button> </td>
                        </tr>";
              } // end if
            } // end foreach
            echo" </table><br><br>";
            echo "  </div>";

          } // end foreach

        } // end if
      ?>
    </div>

    <div id="items_category_all" style="display:none">
      <ul style="list-style-type:none">
        <?php
        if(isset($this->data['productList'])){
          echo "<div>
                <h3>Alle Produkte</h3>
                <table style=overflow-x:auto;>
                  <tr>
                    <th>ID</th>
                    <th>Produkt</th>
                    <th>Kategorie</th>
                    <th>Anzahl</th>
                    <th>Preis</th>
                    <th><button onclick=\"closeCategory('all')\">Schließen</button></th>
                  </tr>";
          foreach ($this->data['productList'] as $value) {
            // var_dump($value);
            $id = $value[0];
            $product = $value[1];
            $price = $value[2];
            $amount = $value[3];
            $category_Id = $value[4];

            // echo "<br><br>";
            // var_dump($this->data['categoryList']);
            // echo "<br>";

            // --> display category name instead of its id
            $category_name = null;
            if(isset($this->data['categoryList'])){
              $category_name = $this->data['categoryList'][$category_Id][1];
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
                      <td> <button onclick='addToCart($id,\"$product\",\"$category_name\",$price)'>Zum Einkaufswagen hinzufügen</button> </td>
                    </tr>";
          } // end foreach

          echo" </table><br><br>
                </div>";
        } // end if
        ?>

      </ul>
    </div>


    <div id="cart" style="display:none">

      <br><h2>Einkaufswagen</h2>

      <table style="overflow-x:auto;" id="cart_container">
        <tr>
          <th>ID</th>
          <th>Produkt</th>
          <th>Kategorie</th>
          <th>Anzahl</th>
          <th>Preis pro Stück</th>
          <th>Gesamtpreis</th>
          <th><button onclick="closeCart()">Einkaufswagen schließen</button><button onclick="clearCart()">Einkaufswagen leeren</button></th>
        </tr>
      </table>

      <!-- the IDs of all products in the cart are saved here -->
      <a id="cart_Ids" style="display:none"></a>


      <br><a style=""></a>Summe: <aa id="cart_sum">0</aa></a> <button onclick="buy()">Kaufen</button>


    </div>

    <!-- test div -->
    <div style="color:green;">
      <br>
      <br>
      <br>
      <br>
      here the text of the shop template ends
      <br>
    </div>

  </body>

  <script type="application/javascript">

    function addToCart(id, product_name, category, price){
      document.getElementById('cart').style.display = "inline";

      var amount;

      // check wether the product is already in the cart
      // true --> amount++
      // false --> make a new entry
      var checkCartForProduct_id = id + "_cart";
      var checkCartForProduct_element = document.getElementById(checkCartForProduct_id);
      if(checkCartForProduct_element != null) {
        if (document.getElementById(checkCartForProduct_id).innerHTML != "") {
          var product_amount_id = id + "_cart_amount";
          amount = parseInt(document.getElementById(product_amount_id).innerHTML);
          amount++;
          // console.log("Amount:"+amount);
          var totalPrice = parseFloat(price) * amount;
          // console.log("totalPrice:"+totalPrice);
          // console.log(document.getElementById(checkCartForProduct_id).innerHTML);
          document.getElementById(checkCartForProduct_id).innerHTML = "<td>"+id+"</td><td>"+product_name+"</td><td>"+category+"</td><td><lo id=\""+id+"_cart_amount\">"+amount+"</lo></td><td>"+price+"</td><td><lo id=\""+id+"_cart_totalPrice\">"+totalPrice+"</lo></td><td><button onclick=\"deleteFromCart("+id+")\">Entfernen</button></td>";
        } else{
          document.getElementById(checkCartForProduct_id).innerHTML = "<td>"+id+"</td><td>"+product_name+"</td><td>"+category+"</td><td><lo id=\""+id+"_cart_amount\">1</lo></td><td>"+price+"</td><td><lo id=\""+id+"_cart_totalPrice\">"+price+"</lo></td><td><button onclick=\"deleteFromCart("+id+")\">Entfernen</button></td>";
        } // end if 2
      }else{
        var newItem = "<tr id=\""+id+"_cart\"><td>"+id+"</td><td>"+product_name+"</td><td>"+category+"</td><td><lo id=\""+id+"_cart_amount\">1</lo></td><td>"+price+"</td><td><lo id=\""+id+"_cart_totalPrice\">"+price+"</lo></td><td><button onclick=\"deleteFromCart("+id+")\">Entfernen</button></td></tr>";
        console.log(newItem);
        var cart = document.getElementById('cart_container').innerHTML;
        cart += newItem;
        document.getElementById('cart_container').innerHTML = cart;
      } // end if 1

      // var addIdToArray = id + "_cart_totalPrice";
      var addIdToArray = id + "_cart";
      cartSum("add", addIdToArray);

    } // end addToCart

    function cartSum(action, id){
      // saves the ids of all products (the id of their individual total price) of the cart
      var ids_string = document.getElementById('cart_Ids').innerHTML;
      var ids_array = ids_string.split(',');

      if(action == "add"){
        // check whether the id is already in the array
        if(ids_array.includes(id) == false) {
          ids_array.push(id);
        } // end if 2
      } // end if 1

      if(action == "remove"){
        ids_array = ids_array.filter(
          (item) => {
            return item != id;
          }
        );
      } // end if

      if(action == "clear"){
        document.getElementById('cart_Ids').innerHTML = "";
      }else{
        document.getElementById('cart_Ids').innerHTML = ids_array;
      } // end if

      // display sum of all total prices
      var sum = 0;
      // ids_array.forEach(myFunction);
      ids_array.forEach((item, index) => {
        var id_totalPrice = item + "_totalPrice";
        if(document.getElementById(id_totalPrice) != null){
          // console.log("item:"+item);
          // console.log("idex:"+index);
          // console.log(document.getElementById(item).innerHTML);
          sum += parseFloat(document.getElementById(id_totalPrice).innerHTML);
        } // end if
      });
      document.getElementById('cart_sum').innerHTML = sum;
    } // end cartSum

    function deleteFromCart(id){
      var product_id = id + "_cart";
      document.getElementById(product_id).innerHTML = "";
      // var sum_product_id = product_id + "_totalPrice";
      // cartSum("remove", sum_product_id);
      cartSum("remove", product_id);

    } // end deleteFromCart

    function closeCart(){
      document.getElementById('cart').style.display = "none";
    } // end closeCart

    function clearCart(){
      var clearedCartText = "<tr><th>ID</th><th>Produkt</th><th>Kategorie</th><th>Anzahl</th><th>Preis pro Stück</th><th>Gesamtpreis</th><th><button onclick=\"closeCart()\">Einkaufswagen schließen</button><button onclick=\"clearCart()\">Einkaufswagen leeren</button></th></tr>";
      document.getElementById('cart_container').innerHTML = clearedCartText;
      cartSum("clear", null);
    } // end clearCart

    function openCategory(categoryId){
      var id = 'items_category_'+categoryId;
      document.getElementById(id).style.display = "inline";
    } // end openCategory

    function closeCategory(categoryId){
      var id = 'items_category_'+categoryId;
      document.getElementById(id).style.display = "none";
    } // end closeCategory

    function buy(){
      var ids_string = document.getElementById('cart_Ids').innerHTML;
      var ids_array = ids_string.split(',');
      if(ids_array[0] == ""){
        ids_array.splice(0,1);
      } // end if
      var sum = parseFloat(document.getElementById('cart_sum').innerHTML);
      var cartItems_array = [];
      var time = "now";

      if(confirm("Bitte bezahlen Sie "+sum+" Euro.")){

        ids_array.forEach((id, index) => {
          var id_product = parseInt(id);
          var id_amount = id + "_amount";
          if(document.getElementById(id) != null && document.getElementById(id_amount) != null && sum != 0){
            var product_amount = parseInt(document.getElementById(id_amount).innerHTML);
            console.log("id:"+id+" | amount:"+product_amount+" | sum:"+sum);
            var current_product = [id_product, product_amount];
            cartItems_array.push(current_product);
            // alert("kein Fehler!");
          }else{
            // alert("Fehler!");
          } // end if 2

        }); // end foreach

        var cartItems_json_string = JSON.stringify(cartItems_array);
        console.log(cartItems_json_string);

        console.log("index.php?action=open_shop&shop=buy&cart_items="+cartItems_json_string+"&sum="+sum+"&time="+time);
        location.replace("index.php?action=open_shop&shop=buy&cart_items="+cartItems_json_string+"&sum="+sum+"&time="+time);

      }else{
        alert("Kaufvorgang abgebrochen!");
      } // end if 1
    } // end buy

  </script>
</html>
