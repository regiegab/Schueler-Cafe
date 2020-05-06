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

        ?>

          <div onClick="addToCart(<?php echo $id; ?>,'<?php echo $product; ?>','<?php echo $price; ?>');">

            <div><?php echo $id; ?></div>

            <div><?php echo $product; ?></div>

            <div><?php echo $amount; ?></div>

            <div><?php echo $price; ?></div>

          </div>

        <?php  echo "<br>";

          // echo implode(" ",$value);



        } // end foreach

      } // end if

      ?>

      <div>

      Einkaufswagen:

        <div id="cart">





        </div>

      </div>



       <div>

            <table style=overflow-x:auto;>



              <th>Produkt</th>

              <th>Preis</th>



              <?php

             echo"

              </tr>

              <td> $product </td>

              <td> $price </td>

              "

               ?>

<td> <button type="button">buy</button> </td>

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

      <script type="application/javascript">

      var cart = [];


      function addToCart(id, productname, price) {

        //add to

      text = id + " " + productname + " " + price;

      document.getElementById('cart').innerHTML = text;

      }

      </script>

      </body>

      </html>
