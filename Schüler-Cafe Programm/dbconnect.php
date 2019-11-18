<?php
class Connect {
  public function __construct{}{
  }

$db = mysqli_connect("localhost", "susocafe_mysql", "DiuSCDB%2019!", "susocafe");
if(!$db)
{
  exit("Verbindungsfehler: ".mysqli_connect_error());
}
}
?>
