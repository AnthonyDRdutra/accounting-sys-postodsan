<?php
Include "CRUD_logic.php";

$fectdata = new \Include\clientmodule\CRUD_logic();

$request = $_POST["query"];
$result = $fectdata->fetchdata($request);

echo $result;
