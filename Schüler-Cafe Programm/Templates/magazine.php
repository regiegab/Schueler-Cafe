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
          echo "<li>$id.$product.$amount.$price.</li>";
          echo "<br>";
          // echo implode(" ",$value);

        } // end foreach
      } // end if
      ?>
    </ul>
   </div>

   <div style="color:darkgreen">
     here the text of the magazine template ends
   </div>

  </body>
</html>
