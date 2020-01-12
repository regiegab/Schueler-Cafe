<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Magazine</title>
  </head>
  <body>
    <!-- test div -->
   <div style="color:green;">
    <br>
    <br>
    <br>
    <br>
    here the text of the magazine template begins
    <br>
    <?php
    var_dump($this->data);
    if(isset($this->data['test'])){
      echo $this->data['test'];
    }
    ?>
    <ul style="list-style-type:none">
      <?php
      if(isset($this->data['products'])){
        foreach ($this->data['products'] as $value) {
          // var_dump($value);
          $id = $value[0];
          $product = $value[1];
          $amount = $value[2];
          $price = $value[3];
          //echo "<div><table>$id.$product.$amount.$price.</table></div>";
          //echo "<br>";
          // echo implode(" ",$value);
echo " <div>
      <table style=overflow-x:auto;>
        <th>ID</th>
        <th>Produkt</th>
        <th>Anzahl</th>
        <th>Preis</th>
      </tr>
      <td> $id </td>
        <td> $product </td>
        <td> $amount </td>
        <td> $price </td>
        <td> <button onclick='deleteProduct($id, $product)'>Löschen</button> </td>
        <td> <button onclick='editProduct($product)'>Produkt bearbeiten</button> </td>
    <tr>
      </table>
    </div>
        </ul>
       </div>

       ";


        } // end foreach
      } // end if


      ?>
      <script type="text/javascript">
      function deleteUser(productID,product){
        if(confirm(Do you really want to delete the product \+product+\?)){
          location.replace(index.php?action=open_magzine&magazine=deleteProduct&product=+productID);
        }
        </script>
      <div style="color:darkgreen">
        here the text of the magazine template ends
      </div>

      </body>
      </html>
