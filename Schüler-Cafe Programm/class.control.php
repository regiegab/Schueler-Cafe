<?php

class Control{

var $model;
var $view;
/*
*all data passed on to the view
*/
var $viewData; // array
var $input; // array --> GET and POST

// vars for the the different sections of the shop
var $magazine;
var $users;

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

          $_SESSION['userId'] = $myArray['userId'];
          $_SESSION['role'] = $myArray['role'];

          //save token in DB
          $this->model->updateToken($myArray['userId'],$token);
          $template = "Templates/main.php";
        } else {
          ?><!DOCTYPE html>
          <html>
            <head>
            </head>
            <body>

            </body>
            <script type="text/javascript">
              alert("Data incorrect!");
            </script>
          </html>
          <?php
        }

      break;
      case "doLogout":
        // Logout
      break;

      case "mainMenu":
        $template = "Templates/main.php";
        break;

      case "open_shop":
        include("scripts/control/sale.php");
        // sale($input);
      break;

      case "open_magazine":
        echo "<br><br>open_magazine<br>";
        // $this->magazine = new Magazine($this->input);
        // include("scripts/control/magazine.php");
        $products = $this->model->getSpecificData('SELECT `ID`, `product`, `amount`, `price` FROM `magazine`');
        $this->magazine = new Magazine($this->input,$products);
        // this is necessary to send the information from the magazine class to the view class / template
        if(isset($this->magazine->return)){
          $this->viewData = $this->magazine->return;
        }

        if(isset($this->magazine->db_return['action'])){
          switch ($this->magazine->db_return['action']){
            case "delete":
              if(isset($this->magazine->db_return['delete'])){

                $this->model->deleteData($this->magazine->db_return['delete']);

                ?>
                <!-- this reloads the page so that the change can be seen in the html output -->
                <!DOCTYPE html>
                <html>
                  <script type="text/javascript">
                    location.replace("http://susocafe.bplaced.net/index.php?action=open_magazine");
                  </script>
                </html>
                <?php
                die();
              }  // end if inner
              break;
            case "edit":
              break;
            default:
              // echo "<br><br>defaulr<br>control<br><br><br><br><br>asdfghdhkjbn4jkw<br><br>trh<br><br>drth";
          } // end switch
        } // end if

        $template = "Templates/magazine.php";

      break;
      //case "open_magazine":
      //  include("scripts/control/magazine.php");
      case "open_userInterface":
        echo "<br><br>open_userInterface<br>";
        // get data from all users from db
        $userList = $this->model->getSpecificData('SELECT `ID`, `login`, `role`, `description` FROM `user`');
        $this->users = new Users($this->input,$userList);
        // include("scripts/control/magazine.php");

        // this is necessary to send the information from the users class to the view class / template
        if(isset($this->users->return)){
          $this->viewData = $this->users->return;
        } // end if

        // if Users wants to do sth with db thier query should be executed
        // var_dump($this->users->db_return);
        if(isset($this->users->db_return['action'])){
          switch ($this->users->db_return['action']){
            case "delete":
              if(isset($this->users->db_return['delete'])){
                // echo "<br><br><br>control<br><br>delete<br><br><br>asdfghdhkjbn4jkw<br><br>trh<br><br>drth";
                $this->model->deleteData($this->users->db_return['delete']);
                // $anInput['userInterface'] = "default";
                // $this->users = new Users($anInput,$userList);
                $this->locationReplace("action=open_userInterface");
              }  // end if inner
              break;
            case "edit":
              if(isset($this->users->db_return['edit'])){
                // var_dump($this->users->db_return['add']);
                // echo "<br>control<br>";
                $this->model->editData($this->users->db_return['edit']);
                $this->locationReplace("action=open_userInterface");
              }
              break;
            case "add":
              if(isset($this->users->db_return['add'])){
                // var_dump($this->users->db_return['add']);
                // echo "<br>control<br>";
                $this->model->addData($this->users->db_return['add']);
                $this->locationReplace("action=open_userInterface");
              }
              break;
            default:
              // echo "<br><br>defaulr<br>control<br><br><br><br><br>asdfghdhkjbn4jkw<br><br>trh<br><br>drth";
          } // end switch
        } // end if

        $template = "Templates/userInterface.php";
          // include("scripts/control/userInterface.php");
          // userInterface($input);
        break;

      case "open_settings":
        echo "<br><br>open settings<br>";
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

/**
  * opens a new location
  * @param Array location
  */
private function locationReplace($location){
  echo $location;
  ?>
  <!-- this reloads the page so that the change can be seen in the html output -->
  <!DOCTYPE html>
  <html>
    <script type="text/javascript">
      location.replace("http://susocafe.bplaced.net/index.php\?<?php echo $location; ?>");
    </script>
  </html>
  <?php
  die();
}

} //end Control


?>
