<?php
include("class.control.php");
include("class.view.php");
include("class.model.php");

$input = array_merge($_GET,$_POST);
new Control($input);
?>
