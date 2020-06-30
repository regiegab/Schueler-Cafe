<?php

//Here you could check if a login is successful and return the required data.
//could be helpful to specify mistakes (i.e. loginname unknown or password mismatch


if(isset($_POST['name'] ) ) {
die( json_encode( array("name"=>$_POST['name'],"lastlogin"=>"12.01.2020","role"=>1) ) );

} else {
die( json_encode(array("name"=>"error","lastlogin"=>"12.01.2020","role"=>1)  ) );
} 

?>