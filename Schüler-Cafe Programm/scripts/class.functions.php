<?php
class Functions{

  /**
    * function to send an alert (HTML)
    * @param String message
    */
  public function alert($message){
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
