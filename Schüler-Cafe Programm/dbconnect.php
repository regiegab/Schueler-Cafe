<?php
class Connect {
  public function __construct{}{
  }

$db = mysqli_connect("localhost", "Benutzername", "Passwort", "Datenbankname");
if(!$db)
{
  exit("Verbindungsfehler: ".mysqli_connect_error());
}
}
?>
