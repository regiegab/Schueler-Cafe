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

        } // end foreach
      } // end if
      ?>
       <div>
            <table style=overflow-x:auto;>

              <th>Produkt</th>
              <th>Preis</th>

              <?php
              echo"
              </tr>
              <td> $product </td>
              <td> $price </td>"
               ?>
               <td> <button type="button" name="buy" onclick="<?php $cartContent ?>" >buy</button> </td>
            </table>
          </div>
              </ul>
             </div>

      <div id="cart">
        <?php
          var_dump($this->data['cart']);

         ?>
      </div>




      <div style="color:darkgreen">
        here the text of the shop template ends
      </div>

      </body>
      </html>
