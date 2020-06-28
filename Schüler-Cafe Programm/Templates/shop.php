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
    </div>

    <div id="categories_overview">

    </div>

    <div id="allProducts">

    </div>


    <div id="cart">
      <h2>Einkaufswagen</h2>
      <?php
      echo "<table style=overflow-x:auto;>
        <tr>
          <th>ID</th>
          <th>Produkt</th>
          <th>Kategorie</th>
          <th>Anzahl</th>
          <th>Preis pro Stück</th>
          <th>Preis gesamt</th>
          <th></th>
        </tr>
        <tr>
          <td> $ </td>
          <td> $ </td>
          <td> $ </td>
          <td> $ </td>
          <td> $ </td>
          <td> $ </td>
          <td> <button onclick=\"\">Entfernen</button> </td>
        </tr>";
       ?>
       <br><br>

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

    </script>
</html>
