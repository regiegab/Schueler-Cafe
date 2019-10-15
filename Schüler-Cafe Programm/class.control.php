<?php
class Control{


public function __construct($input){
$this->handleInput($input);
}

public function handleInput($input){
  echo "<br>Control: handleInput(\$input)";
  $model = new Model;
  $model->loadData($input);

  $view = new View;

  if(isset($input['template'])){
    echo "<br><br>load template: ".$input['template'];
    $view->display($input['template']);

  } else {
    echo "<br><br>no template!";
    $errorMessage = "No page requested!";
    $view->displayError($errorMessage);
  }

}

}


?>
