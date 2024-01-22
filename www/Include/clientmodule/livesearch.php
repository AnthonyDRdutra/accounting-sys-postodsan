<?php
include "CRUD_logic.php"; // Replace with the actual filename containing your class

if (isset($_POST['input'])) {
    $input = $_POST['input'];
    $yourClassInstance = new \Include\clientmodule\CRUD_logic(); // Replace with the actual class name
    $debtListing = $yourClassInstance->LiveDebtListing($input);

    if (!empty($debtListing)) {
        echo "<table class=' table table-hover text-dark border-white text-center'>
                
                    <tr>
                         <th>Cliente</th>
                            <th>Valor</th>
                            <th>Adiantamentos</th>
                            <th>A Pagar</th>
                            <th>mais...</th>
                    </tr>
                
                ";

        foreach ($debtListing as $row) {
            echo "<tr>
                    <td>{$row['client_name']}</td>
                    <td>R$ {$row['debt']}</td>
                    <td>R$ {$row['payed']}</td>
                    <td>R$ {$row['topay']}</td>
                     <td>
                        <a href='/Include/clientdata.php?id={$row['client_id']}'>
                            <img src='assets/pngegg.png' height='20' width='20'>
                        </a>
                    </td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "<h6 class='text-warning'>No matching results</h6>";
    }
}