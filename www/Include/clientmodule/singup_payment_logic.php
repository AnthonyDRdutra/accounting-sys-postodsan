<?php
include "client_crud_logic.php";

$input_name = strtolower($_POST['client_name_input_payment']);
$input_value = $_POST['input_value_payment'];
$input_atendee = $_POST['atendee_payment'];
$type = 1;

try {
    $processticket = new \Include\clientmodule\client_crud_logic();


    switch($processticket ->Create_client($input_name)){

        //Reg sucess , create and use new 'id'
        case 0:
            $lastClientId = $processticket->LastID();
            echo $lastClientId;
            $input_booksID = $lastClientId;
            $processticket ->CreateDebtPayment($input_name, $input_value, $input_atendee, $input_booksID, $type);
            echo "data sucessfully inserted and created the new id";
            break;

        //client already registered
        case 1:
            $input_booksID = $_POST['books_id'];
            $processticket ->CreateDebtPayment($input_name, $input_value, $input_atendee, $input_booksID, $type);
            echo "data sucessfully inserted and loaded the id";
            break;
        case -1:
            echo 'input not provided';
            break;
    }

} catch (Exception $e){
    echo "Error: ".  $e->getMessage();
}

