<?php
include "client_crud_logic.php";

$input_name = strtolower($_POST['client_name_input']);
$input_value = $_POST['input_value'];
$input_atendee = $_POST['atendee'];
$type = 0;

try {
    $processticket = new \Include\clientmodule\client_crud_logic();


    switch($processticket ->Create_client($input_name)){

        //Reg success , create and use new 'id'
        case 0:
            $lastClientId = $processticket->LastID();
            $input_booksID = $lastClientId;
            $processticket ->Create_Debt_or_Payment($input_name, $input_value, $input_atendee, $input_booksID, $type);

            break;

        //client already registered
        case 1:
            $input_booksID = $_POST['books_id'];
            $processticket ->Create_Debt_or_Payment($input_name, $input_value, $input_atendee, $input_booksID, $type);

            echo "\ndata sucessfully inserted and loaded the id";
            break;

        //not able to get input
        case -1:
            echo 'input not provided';
            break;
    }

} catch (Exception $e){
    echo "Error: ".  $e->getMessage();
}

