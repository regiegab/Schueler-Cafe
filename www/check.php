<?php

//Here you could check if a login is successful and return the required data.
//could be helpful to specify mistakes (i.e. loginname unknown or password mismatch


if(isset($_POST ) ) {
die( json_encode( array("name"=>$_POST['name']) ) );

} else {
die( json_encode(array("name"=>"error") ) );
} 

?>