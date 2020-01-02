<?php
echo "opened magazine";
if($this->control->checkLoginState() == true){
 echo "session has not expired yet";
}else{
 echo "session expired";
}
function magazine($input){



  switch ($input['magazine']){
    case "addProduct":
    //open menu with product, price, amount
    //add inserted values to db
    //INSERT INTO `magazine`(`ID`, `product`, `price`, `amount`) VALUES ([value-1],[value-2],[value-3],[value-4])
    break;
    case 'removeProduct':
      //remove the selected product from db
      //DELETE FROM `magazine` WHERE 0
    break;
    case 'editProduct':
      //open menu with price, amount of selected product
      //UPDATE `magazine` SET `ID`=[value-1],`product`=[value-2],`price`=[value-3],`amount`=[value-4] WHERE 1
      break;

    default:
  } // end switch

 }

?>
