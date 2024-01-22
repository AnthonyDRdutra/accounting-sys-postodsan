<?php
include "CRUD_logic.php";

$delete = new \Include\clientmodule\CRUD_logic();
$id = $_POST['id'];

$delete->Delete_client_payment($id);