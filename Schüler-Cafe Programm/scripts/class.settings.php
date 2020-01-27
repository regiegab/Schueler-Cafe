<?php
class Settings{

  var $input; // Array


  // variables
  var $token_lenght = 50; // number of chars in the token string
  var $maximalSessionTime = 1; // int in minutes

  public function __construct($input){
    $this->input = $input;

    if($this->input['accessToDb']){
      // change variables to the values from the db

    }

  }



}


?>
