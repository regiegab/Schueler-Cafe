<?php
class View{
var $data;

public function display($template, $data){
  $this->data = $data;
  if(include($template)){
  }else{
    echo "<br><br>invalid template!!!";
    $errorMessage = "There was an unknown error with loading your web page!; template: ".$template;
    $this->displayError($errorMessage);
  } // else Ende

} // function Ende

public function displayError($errorMessage){
  echo "<br><br><br>".$errorMessage;
  @include("Templates/errorWithLoadingPage.html");
}


}


?>
