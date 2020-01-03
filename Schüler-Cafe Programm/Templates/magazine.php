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
   </div>

   <div style="color:darkgreen">
     here the text of the magazine template ends
   </div>

  </body>
</html>
