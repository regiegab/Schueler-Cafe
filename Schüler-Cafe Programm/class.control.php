<?php
class Control{

var $model;
/*
*all data passed on to the view
*/
var $viewData; // array

public function __construct($input){
//is session set?
//check if user login valid
$this->handleInput($input);
$this->model = new Model;

//for debug purposes - establish the DB connection and perform a sample Query
//will be called every time
$this->checkDBConnection();

}

public function handleInput($input){
  // echo "<br>Control: handleInput(\$input)";

  $template = "Templates/login.html";

  //$this->model->loadData($input);

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
        echo "test_doLogin";
        //check data with SQLiteDatabase

        // go to main menu
        // $template = "Templates/main.html";
        $template = "Templates/login.html";
      break;
      default:
        
        $template = "Templates/login.html";

    } //end switch

  }//end if


  $view = new View;


    // echo "<br><br>load template: ".$template;
    $view->display($template, $this->viewData);

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




} //end Control


?>
