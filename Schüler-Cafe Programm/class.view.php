<?php
class View{

public function display($template){

  if(@include("Templates/".$template)){

  }else{
    echo "<br><br>invalid template!!!";
    $errorMessage = "There was an unknown error with loading your web page!";
    $this->displayError($errorMessage);
  } // else Ende

} // function Ende

public function displayError($errorMessage){
  echo "<br><br><br>".$errorMessage;
  @include("Templates/errorWithLoadingPage.html");
}


}


?>
