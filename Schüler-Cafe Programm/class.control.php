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

      case "doLogin":
        $myArray = $this->checkLogin($this->input);
        if ($myArray != null) {
          //create token
          $token = "qwertzuiop";
          //save token
          $_SESSION['usertoken'] = $token;
          //save token in DB
          $this->model->updateToken($myArray['userId'],$token);
          $template = "Templates/main.php";
        }

      break;
      case "doLogout":
        // Logout
      break;


      case "open_shop":
        include("scripts/control/sale.php");
        // sale($input);
      break;
      //case "open_magazine":
      //  include("scripts/control/magazine.php");
      //break;
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
  /*echo '--------------------------------<br>';
  echo 'database returns the following data (as an array_dump) : <br>';
  var_dump($this->model->getData() ); //getData is a function of Model to perform a simple Query
  echo '<br>--------------------------------<br>';
  */
}

function checkLoginState(){
  $return = false;
  var_dump($_SESSION);
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

  // data from GET / POST
  echo "input:<br>";
  $insertedUsername = $input['username'];
  $insertedPassword = $input['password'];

    return $this->model->checkLoginData($insertedUsername,$insertedPassword);


}



} //end Control


?>
