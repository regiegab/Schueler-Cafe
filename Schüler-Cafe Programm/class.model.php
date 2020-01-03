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
    $data = $this->connection->basicQuery("SELECT * FROM magazine");
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

  /**
   * a function to gather the data of the user table
   */



  /**
   * check Login Data
   * @param string username
   * @param string password
   */
  public function checkLoginData($login,$pw){

      $data = $this->connection->basicQuery('SELECT id,login,role FROM user
    WHERE login="'. $login . '" AND password = "'. $pw .'"');
    if (!empty($data) ){
        $array = array();
        $array['userId'] = $data[0][0];
        //add other values

        $userId = $array['userId'];

        $role = $this->connection->basicQuery('SELECT role FROM user WHERE ID='.$userId);
        $array['role'] = $role[0][0];
        return $array;
    } else {
        return null;
    }
  }

  /**
   * update user token
   * sends created userToken to database
   * @param int userId
   * @param string Token
   */
  public function updateToken($id,$token) {
      $now = date('Y-m-d H:i');
      $this->connection->basicQuery("INSERT INTO login_token (`token`,`userId`,`loginTime`)
      VALUES ('$token','$id','$now') " );

  }


  /**
   * a function to perform a query that requests data from the db
   * @param string the query
   */
  public function getSpecificData($query){
      $return = $this->connection->basicQuery($query);
      return $return;
  }

  /**
   * a function to perform a query that deletes data from the db
   * @param string the query
   */
  public function deleteData($query){
    // echo "<br><br>model<br><br><br><br><br><br>asdfghdhkjbn4jkw<br><br>trh<br><br>drth";
      $return = $this->connection->deleteQuery($query);
      return $return;
  }


}


?>
