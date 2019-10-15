<?php
class Control{

public function __construct($input){
$this->handleInput($input);
}

public function handleInput($input){
  echo "handleInput(\$input)";
}

}


?>
