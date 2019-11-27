<?php
class Model{

  var $connection;

  /**
   * constructor establishes th connection to the database
   */
  public function __construct(){
    $this->connection = new Connect();

  }



  /**
   * a template function to gather some data from the database
   */
  public function getData() {

    $data = $this->connection->basicQuery("SELECT * FROM user");
    if ($data != null) {
      //go through rows and process the data
      foreach($data as $d) {
        //you can now access every field with $d[index] and do whatever you like with it
        //i.e. make a json String out of it
      }
      //or simply return the whole array
      return $data;

      } else {
      //query was empty
        return null;  //or whatever else you need
      }

  }

// kann gelöscht werden
//   public function loadData($input){
//     echo "<br>Model: loadData";
//   }
// }


?>
