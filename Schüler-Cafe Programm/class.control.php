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
var $settings;


public function __construct($input){
  $this->view = new View;
  $this->model = new Model;

  @$this->input = $input;

  // $settingsArray = array();
  $this->input['settings_initial'] = true;
  // echo $this->input['settings'];
  @$settingsList = $this->model->getSpecificData('SELECT * FROM `settings`'); // SELECT `ID`, `setting`, `value`, `description` FROM `settings`
  $this->settings = new Settings($this->input,$settingsList);
  if(isset($this->settings->db_return['action'])){
    if($this->settings->db_return['action'] == "reset"){
      $this->resetSettings();
    } // end if 2
  } // end if 1

  // $settingsArray['accessToDb'] = true; // here should be checked whether there is a connection to the db
  // $this->settings = new Settings($settingsArray);
  // $this->applySettings();

  // checks whether user is still logge in
  if($this->checkLoginState() || $this->isInput_doLogin($input)){
    // $this->input = $input;
    //is session set?
    //check if user login valid
    $this->handleInput($input);
    //for debug purposes - establish the DB connection and perform a sample Query
    //will be called every time
    $this->checkDBConnection();
  }else{
  echo "info_connection_expired";
  // die(json_encode($result));
  $this->view->display("Templates/login.html", $this->viewData);
}
}
public function handleInput($input){
  // echo "<br>Control: handleInput(\$input)";
  $template = "Templates/login.html";
  if (isset($input['action'])){
    switch($input['action']){
      case "doLogin":
        $result = array();
        $myArray = $this->checkLogin($this->input);
        if ($myArray != null) {
          //create token
          $token = $this->generateRandomString($this->settings->settings['general_tokenLenght']);
          //save token
          $_SESSION['usertoken'] = $token;
          $_SESSION['userId'] = $myArray['userId'];
          $_SESSION['role'] = $myArray['role'];
          //save token in DB
          $this->model->updateToken($myArray['userId'],$token);

          $result['status'] = "success";
          $result['message'] = "Login erfolgreich!".$_SESSION['usertoken'];

        } else {
          $result['status'] = "error";
          $result['message'] = "Daten inkorrekt!";
        }
        die(json_encode($result));
        break;
      case "doLogout":
        session_unset();
        break;
      case "mainMenu":
        $template = "Templates/main.php";
        break;
      case "open_shop":
        $template = "Templates/shop.php";
        echo "<br><br>open_shop<br>";
        $products = $this->model->getSpecificData('SELECT `ID`, `product`, `amount`, `price` FROM `magazine`');
        $this->shop = new Shop($this->input,$products);
        if(isset($this->shop->return)){
          $this->viewData = $this->shop->return;
        }
        // this is necessary to send the information from the shop class to the view class / template
        if(isset($input['finishtrans']) ){
          //lese JSON String aus cart
          //vervollständige Einkauf (Methode in Shop)
          //$this->shop->finishTransaction();
        }
        /*
        if(isset($this->shop->db_return['action'])){
          switch ($this->shop->db_return['action']){
            case "delete":
              if(isset($this->shop->db_return['delete'])){

              $this->model->deleteData($this->shop->db_return['delete']);

              ?>
              <!-- this reloads the page so that the change can be seen in the html output -->
              <!DOCTYPE html>
              <html>
                <script type="text/javascript">
                  location.replace("http://susocafe.bplaced.net/index.php?action=open_shop");
                </script>
              </html>
              <?php
              die();
            }  // end if inner
          } // end switch
        } // ebd outer if
        */
        break;
      // case "edit":
      //     break;
      case "open_magazine":
        echo "<br><br>open_magazine<br>";
        // $this->magazine = new Magazine($this->input);
        // include("scripts/control/magazine.php");
        $products = $this->model->getSpecificData('SELECT `ID`, `product`, `amount`, `price` FROM `magazine`');
        $this->magazine = new Magazine($this->input,$products,$this->settings->settings);
        // this is necessary to send the information from the magazine class to the view class / template
        if(isset($this->magazine->return)){
          $this->viewData = $this->magazine->return;
        }
        if(isset($this->magazine->db_return['action'])){
          switch ($this->magazine->db_return['action']){
            case "delete":
              if(isset($this->magazine->db_return['delete'])){
                $this->model->deleteData($this->magazine->db_return['delete']);
                $this->locationReplace("action=open_magazine");
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
        $this->users = new Users($this->input,$userList,$this->settings->settings);
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
        echo "<br><br>open_settings<br>";

          $this->input['settings_initial'] = false;
          $settingsList = $this->model->getSpecificData('SELECT * FROM `settings`');
          // // debug
          //   echo "var_dump($settingsList);:<br>";
          //   var_dump($settingsList);
          //   echo "<br><br>";
          $this->settings = new Settings($this->input,$settingsList);

        // this is necessary to send the information from the settings class to the view class / template
        if(isset($this->settings->return)){
          $this->viewData = $this->settings->return;
        } // end if

        // var_dump($this->settings->db_return);
        if(isset($this->settings->db_return['action'])){
          switch ($this->settings->db_return['action']){
            case "change":
              if(isset($this->settings->db_return['change'])){
                // var_dump($this->settings->db_return['change']);
                // echo "<br>control<br>";
                $this->model->editData($this->settings->db_return['change']);
                $this->locationReplace("action=open_settings");
              }
              break;
            case "reset":
              echo "<br>RESET!!!(control)<br>";
              var_dump($this->settings->db_return['backup']);
              // UPDATE `settings` SET `value`=[value-3] WHERE `setting`
              $this->resetSettings();
              $this->locationReplace("");
              break;
            default:
              // echo "<br><br>defaulr<br>control<br><br><br><br><br>asdfghdhkjbn4jkw<br><br>trh<br><br>drth";
          } // end switch
        } // end if
        $template = "Templates/settings.php";
          // include("scripts/control/userInterface.php");
          // userInterface($input);
        break;
      case "open_logs":
        // include("scripts/control/logs.php");
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
 * a function to check whether the demanded action is "doLogin"
 */
private function isInput_doLogin($input){
  $return = false;
  if(isset($input['action'])){
    if($input['action'] == "doLogin"){
      $return = true;
    }
  }
  return $return;
}

/**
 * a function to generate a randomized string
 * @param int length of the string
 */
private function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


/**
 * function to debug database connection
 *
 */
public function checkDBConnection(){
  echo 'DEBUG NOTES:<br>';
  var_dump($_SESSION);
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


private function checkLoginState(){
  $return = false;

  if(isset($_SESSION['usertoken'])){
    $now = date('Y-m-d H:i:s');

    $token = $_SESSION['usertoken'];
    $userId = $_SESSION['userId'];

    $sessionTime = $this->model->getSpecificData('SELECT `loginTime` FROM `login_token` WHERE `token`=\''.$token.'\' AND `userId` = '.$userId);
    $sessionTime_string = $sessionTime[0][0];

    $now_time = strtotime($now);
    $sessionTime_time = strtotime($sessionTime_string);

    $timeDifference = $this->settings->settings['general_maximalSessionTime'];
    $maxTime = date('Y-m-d H:i:s', strtotime('+'.$timeDifference.' minutes',$sessionTime_time));
    $maxTime_time = strtotime($maxTime);

    $maxTime_int = $maxTime_time;
    $nowTime_int = $now_time;

    // echo "maxTime_int = $maxTime_int; nowTime_int = $nowTime_int";

    if ($maxTime_int > $nowTime_int){
     // echo "now is later";
     $return = true;
   }else{
     // echo "sth is wrong";
   }
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
  // echo "input:<br>";
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

/**
  * resets all settuings to default values
  */
private function resetSettings(){
  $backup = $this->settings->db_return['backup'];
  foreach ($backup as $key => $value) {
    echo "<br>key:$key | value: $value<br>";
    $query = "UPDATE `settings` SET `value` = $value WHERE `setting` = \"$key\"";
    $this->model->editData($query);
  } // end foreach
}

} //end Control
?>
