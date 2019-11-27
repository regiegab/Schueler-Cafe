<?php
class Control{

var $model;
var $view;
/*
*all data passed on to the view
*/
var $viewData; // array
var $input; // array --> GET and POST

public function __construct($input){
  $this->view = new View;
  $this->model = new Model;

  // checks whether user is still logge in
  if($this->checkLoginState()){
    $this->input = $input;
    //is session set?
    //check if user login valid

    $this->handleInput($input);

    //for debug purposes - establish the DB connection and perform a sample Query
    //will be called every time
    $this->checkDBConnection();
  }else{
  echo "info_connection_expired";
  $this->view->display("Templates/login.html", $this->viewData);
}


}

public function handleInput($input){
  // echo "<br>Control: handleInput(\$input)";

  $template = "Templates/login.html";

  if (isset($input['action'])){

    switch($input['action']){

      // //OPTION1 - processing javascript requests
      // case "js":
      //   $returnArray = array();
      //   //javascript posts to server
      //   if($input['action'] == "buy") {
      //     $returnArray = array("status"=> 200, "product" => $input['name']);
      //     }
      //     die(json_encode($returnArray));
      //     break;
      // case "login":
      //   //check login data
      //   $template = "startseite.php";
      //   break;
      // case "kasse":

      //OPTION2 - processing javascript requests
      //check if javascript request

        // if($input['action'] == "buy") {
        //   $returnArray = array();
        //   $returnArray = array("status"=> 200, "product" => $input['name']);
        //   die(json_encode($returnArray));
        //   }
        //
        // //Kassentenmplate
        // $template = "kasse.php";
        // $this->viewData['products'] = array("p1" => "Kaffee", "p2"=>"Muffin" );//$this->model->getAllProducts();
        // break;
      case "doLogin":
        $myArray = $this->checkLogin($this->input);
        $template = $myArray['template'];
      break;
      case "doLogout":
        // Logout
      break;


      case "open_shop":
        include("scripts/control/sale.php");
        // sale($input);
      break;
      case "open_magazine":
        include("scripts/control/magazine.php");
        // magazine($input);
      break;
      case "open_userInterface":
        include("scripts/control/userInterface.php");
        // userInterface($input);
      break;
      case "open_settings":
        include("scripts/control/settings.php");
        // settings($input);
      break;
      case "open_logs":
        include("scripts/control/logs.php");
        // logs($input);
      break;
      default:
        $template = "Templates/login.html";

    } //end switch

  }//end if





    // echo "<br><br>load template: ".$template;
    $this->view->display($template, $this->viewData);

} //end handleInput()



/**
 * function to debug database connection
 *
 */
private function checkDBConnection(){
  echo 'DEBUG NOTES:<br>';
  echo '--------------------------------<br>';
  echo "test_connection<br>";
  foreach ($this->model->connection->success as $key => $value) {
    echo $key . " : " . $value . '<br>';
  }

  //perform a sample Query
  echo '--------------------------------<br>';
  echo 'database returns the following data (as an array_dump) : <br>';
  var_dump($this->model->getData() ); //getData is a function of Model to perform a simple Query
  echo '<br>--------------------------------<br>';
}

function checkLoginState(){
  $return = false;

  if(true){
    $return = true;
  }
  return $return;
}

/**
  * function to check compare inserted data in login form with db'
  * returns true if data is correct
  * @param Array loginData
  */

private function checkLogin($input){
  // get data from db
  $db = $this->model->getUserData();

  var_dump($db);
  echo "<br><br>";

  // data from GET / POST
  echo "input:<br>";
  $insertedUsername = $input['username'];
  $insertedPassword = $input['password'];
  var_dump($insertedUsername);
  var_dump($insertedPassword);
  echo "<br><br>";

  // $columns = array(); // the key from $db for matching users is saved in this array
  // $x = 0; // variable to count matching usernames
  $success; // array if username matches [0] = true and if password matches [1] = true and with key for matching user in $db [1]
  foreach ($db as $key => $value) {
    if($insertedUsername == $value[1]){
      // $columns[$x] = $key;
      // echo "<br><br>username_match".$x."<br><br>";
      // $matchingUsers[$x] = $value;
      $matchingUsers[$key] = $value;
      $success[0] = true;
      $success[2] = $key;
      break;
      // $x++;
    } else {
      $success[0] = false;
      $success[1] = false;
    }// end if
  }

  // echo "<br><br>\$columns:<br>";
  // var_dump($columns);
  // echo "<br><br>";
  //
  echo "matching users:<br>";
  // $matchingUsers = array(); // the data of matching users is saved in this array
  // $y = 0; // variable to count matching users
  // foreach ($columns as $key => $value) {
  //   $matchingUsers[$y] = $db[$value];
  //   // var_dump($db[$value]);
  //   // echo "<br><br>";
  //   $y++;
  // }
  var_dump($matchingUsers);
  echo "<br><br>";

  // compare password with username
  if($success[0]){
    foreach ($matchingUsers as $key => $value) {
      if($value !== null){
        if($value[2] == $insertedPassword){
          $success[1] = true;
          // $success[2] = $key;
          break;
        } // end if 3
      } // end if 2
    } // end foreach
  } // end if 1


  echo "matching user:<br>";
  var_dump($success);
  echo "<br><br>";

  //check data with SQLiteDatabase
  $return = array();
  if($success[0] && $success[1]){ // if data is correct
    echo "<br><br>logged in";
    // go to main menu
    $userNumber = $success[2];
    $return['template'] = "Templates/main.php";
    $return['userNumber'] = $userNumber;
    return $return;
  }else{
    // go back to Login
    echo "info_incorrect_username_or_password";
    $return['template'] = "Templates/login.html";
    return $return;
  } // end else
}



} //end Control


?>
