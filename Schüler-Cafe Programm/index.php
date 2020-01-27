<?php
session_start();

include("class.control.php");
include("class.view.php");
include("class.model.php");
include("class.connect.php");

include("scripts/class.magazine.php");
include("scripts/class.users.php");
include("scripts/class.shop.php");
include("scripts/class.settings.php");




$input = array_merge($_GET,$_POST);


new Control($input);





// $_SESSION[token] = "932erzöj3wh57p883hzoshgöoiduhöj";


?>
