<?php
session_start();
include("class.control.php");
include("class.view.php");
include("class.model.php");

$input = array_merge($_GET,$_POST);
new Control($input);

// $_SESSION[token] = "932erzöj3wh57p883hzoshgöoiduhöj";
?>
