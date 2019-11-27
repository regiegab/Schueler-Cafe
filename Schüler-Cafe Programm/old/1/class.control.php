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
}

public function handleInput($input){
  echo "<br>Control: handleInput(\$input)";

  $template = "Schüler-Cafe Programm\Templates\login.html";

  //$this->model->loadData($input);

  if (isset($input['type'])){

    switch($input['type']){

      //OPTION1 - processing javascript requests
      case "js":
        $returnArray = array();
        //javascript posts to server
        if($input['action'] == "buy") {
          $returnArray = array("status"=> 200, "product" => $input['name']);
          }
          die(json_encode($returnArray));
          break;
      case "login":
        //check login data
        $template = "startseite.php";
        break;
      case "kasse":

      //OPTION2 - processing javascript requests
      //check if javascript request
        if($input['action'] == "buy") {
          $returnArray = array();
          $returnArray = array("status"=> 200, "product" => $input['name']);
          die(json_encode($returnArray));
          }

        //Kassentenmplate
        $template = "kasse.php";
        $this->viewData['products'] = array("p1" => "Kaffee", "p2"=>"Muffin" );//$this->model->getAllProducts();
        break;
      default:
        $template = "Schüler-Cafe Programm\Templates\login.html";
        break;

    } //end switch

  }//end if


  $view = new View;


    echo "<br><br>load template: ".$template;
    $view->display($template, $this->viewData);

} //end handleInput()




} //end Control


?>
