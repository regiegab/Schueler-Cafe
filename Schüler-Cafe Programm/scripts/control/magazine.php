<?php
echo "opened magazine";
function magazine($input){

  if($this->control->checkLoginState()== true){
    echo "session has not expired yet";
  }

  switch ($input['magazine']){
    case "addProduct":
      echo "addProduct";
    break;
    default:
  } // end switch

 }

?>
