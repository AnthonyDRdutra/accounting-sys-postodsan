<?php

include "C:/phpdesktop-chrome-57.0-rc-php-8/www/Include/clientmodule/client_crud_logic.php";
$list = new \Include\clientmodule\CRUD_logic();
$id = filter_input(INPUT_GET, 'id');
 foreach ($list->ClientList() as $client){
     if ($client['id']==$id){
         $selectedClient = $client;
     }
 }
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.css">

    <script src="jquery3.7.1.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="../../bootstrap/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>



    <style>

        table {
            border-spacing: 10px;
        }
        th, td{
            border: none;
            padding: 8px;
        }
        div{
            border: 0px solid #0FFF50;
        }

        body {
            padding-top: 56px; /* Adjusted for the fixed navbar */
            background-color: #F2F2F2;
        }
        hr {
            border: 1px;
            clear:both;
            display: flex;
            width: 100%;
            background-color: #969696;
            height: 0px;
        }
    </style>
</head>
<body>
<form method="POST">
    <a href='/Include/clientmodule/Signupform.php'>Voltar</a>
    <div class='row container-fluid'>
        <div class=" mt-2 col container-fluid" style="max-width: 550px">


            <!--Tabela de Débitos-->
            <div class ="ml-2 mr-3 bg-dark text-white text-center norounded" style="min-width: 500px">
                <h4>Débitos</h4>
            </div>
            <table class=" table-hover ml-2 bg-custom1 norounded" style="min-width: 500px">
                <th class="text-center">Nome</th>
                <th class="text-center">Valor</th>
                <th class="text-center">Data e Hora</th>
                <th class="text-center">Responsável</th>
                <th class="text-center">Ações</th>

                <?php foreach ($list->Client_Debt_list($id) as $dbpostodsan): ?>
                    <tr>
                        <td class="text-center"><?=$dbpostodsan['name'];?></td>
                        <td class="text-center text-white norounded bg-dark font-weight-bold">R$<?=$dbpostodsan['value'];?></td>
                        <td class="text-center"><?=$dbpostodsan['date'];?></td>
                        <td class="text-center"><?=$dbpostodsan['ateendee'];?></td>

                        <td>
                            <div class="row " align="center" style="max-width: min-content; max-height: fit-content">
                                <div class="col ml-2">
                                    <a href="#" class="delete-debtticket" data-id="<?=$dbpostodsan['id'];?>">
                                        <img src="assets/Dell_duotone.png" class="bg-danger rounded" height="25" width="25">
                                    </a>
                                </div>
                            </div>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!--Tabela de Pagamentos-->
        <div class="mt-2 col container-fluid" style="max-width: 550px">
            <div  class ="ml-2 mr-3 text-center text-white border-white bg-dark norounded" style="min-width: 500px">
                <h4>Adiantamentos</h4>
            </div>
            <table class="table-hover ml-2 bg-custom1 border-dark norounded" style="min-width: 500px">
                <th class="text-center">Nome</th>
                <th class="text-center">Valor</th>
                <th class="text-center">Data e Hora</th>
                <th class="text-center">Responsável</th>
                <th class="text-center">Ações</th>

                <?php foreach ($list->Client_payment_list($id) as $dbpostodsan): ?>
                    <tr class="mb-1">
                        <td class="text-center"><?=$dbpostodsan['name'];?></td>
                        <td class="text-center text-white norounded bg-dark font-weight-bold">R$<?=$dbpostodsan['value'];?></td>
                        <td class="text-center"><?=$dbpostodsan['date'];?></td>
                        <td class="text-center"><?=$dbpostodsan['atendee'];?></td>

                        <td>
                            <div class="row " align="center" style="max-width: fit-content; max-height: fit-content">
                                <div class="col ml-2">
                                    <a href="#" class="delete-paymentticket" data-id="<?=$dbpostodsan['id'];?>">
                                        <img src="assets/Dell_duotone.png" class="bg-danger rounded" height="25" width="25">
                                    </a>
                                </div>
                            </div>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </table>
        </div>


        <!--Tabela de metricas-->
        <div class="col container align-content-Left mt-2 text-white " style="max-width: 550px;max-height: 100px">
            <div class="text-dark col mb-1" align="center" >
               <h2> <?php echo $selectedClient['client_name'] ?> </h2>
            </div>
            <table>
                <?php foreach ($list->Metriclist($id) as $dbpostodsan): ?>
                <tr>
                    <td class="text-center text-dark font-weight-bold"> <h2>Débitos</h2>R$ <?=$dbpostodsan['metric_debts'];?>
                        <hr></td>

                    <td class="text-center text-dark font-weight-bold"> <h2>Adiantamentos</h2>R$ <?=$dbpostodsan['metric_payments'];?>
                        <hr></td>

                    <td class="text-center text-dark font-weight-bold"><h2>Restante</h2> R$ <?=$dbpostodsan['metric_topay'];?>
                        <hr></td>

                <?php endforeach; ?>
            </table>
            <div class="col border-white rounded bg-dark mt-3">



                <!--Card de Cadastro de pagamentos-->
                <div>
                    <h4 class="mt-3">Cadastrar Pagamento</h4>
                    <hr>
                </div>
                <div class="col mt-3">
                    <div class="card card-body bg-success mt-1">
                        <div class="row mb-1 h-auto w-auto" align="center" >
                            <input type="text" name="client_name_input_payment" id="client_name_input_payment" class="container form-control input-group-lg" autocomplete="off" placeholder="Nome do Cliente..." value="<?php echo $selectedClient['client_name']; ?>" readonly>
                        </div>
                        <div class="row mt-1 mb-1 h-auto w-auto text-white">
                            <input type="number" name="input_value_payment" id="input_value_payment" class="container form-control" placeholder="Valor (R$)...">
                        </div>
                        <div class="row mt-1 mb-1 h-auto w-auto">
                            <label for="dropdown" class="text-white">Responsável:</label>
                            <select class="form-control" id="dropdown" name="atendee_payment">
                                <?php
                                foreach($list->Attendeelist() as $dbpostodsan):
                                    $atendeename = $dbpostodsan['atendee_name'];
                                    echo "<option value='" . htmlspecialchars($atendeename). "' id='atendee" . "' name='atendee'>" . htmlspecialchars($atendeename) . "</option>";
                                endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col mt-1 mb-1" align="center">
                        <button type="submit" class="btn btn-info" style="min-width: 250px; max-height: 40px;" id="btn_store_payment">
                            <img src="assets/save.png" height="20" width="20">
                        </button>
                    </div>

                </div>


                <!--Card de Cadastro de Débitos-->
                <div class="col mt-3">
                    <div>
                        <h4>Cadastrar Débito</h4>
                        <hr>
                    </div>

                    <div class="card card-body bg-danger mt-1">
                        <div class="row mb-1 h-auto w-auto" align="center" >
                            <input type="text" name="client_name_input" id="client_name_input" class="container form-control input-group-lg" autocomplete="off" placeholder="Nome do Cliente..." value="<?php echo $selectedClient['client_name']; ?>" readonly>
                        </div>
                        <div class="row mt-1 mb-1 h-auto w-auto text-white">
                            <input type="number" name="input_value" id="input_value" class="container form-control" placeholder="Valor (R$)...">
                        </div>
                        <div class="row mt-1 mb-1 h-auto w-auto">
                            <label for="dropdown" class="text-white">Responsável:</label>
                            <select class="form-control" id="dropdown" name="atendee">
                                <?php
                                foreach($list->Attendeelist() as $dbpostodsan):
                                    $atendeename = $dbpostodsan['atendee_name'];
                                    echo "<option value='" . htmlspecialchars($atendeename). "' id='atendee" . "' name='atendee'>" . htmlspecialchars($atendeename) . "</option>";
                                endforeach; ?>
                            </select>
                        </div>
                    </div>
                        <div class="col mt-1 mb-1" align="center">
                            <button type="submit" class="btn btn-info" style="min-width: 250px; max-height: 40px;" id="btn_store">
                                <img src="assets/save.png" height="20" width="20">
                            </button>
                        </div>
                </div>


            </div>
        </div>

    </div>
</form>

<!--Ajax scripts-->
<script>
    $(document).ready(function () {

        //AJAX Delete debt ticket
        $('.delete-debtticket').on('click', function (event) {
            event.preventDefault();

            var paymentId = $(this).data('id');

            // AJAX request
            $.ajax({
                type: 'POST',
                url: 'Delete_debt.php',
                data: { id: paymentId },
                success: function (response) {
                    console.log(response);
                    location.reload();
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        });

        //AJAX delete payment ticket
        $('.delete-paymentticket').on('click', function (event) {
            event.preventDefault();

            var paymentId = $(this).data('id');

            // AJAX request
            $.ajax({
                type: 'POST',
                url: 'Delete_payment.php',
                data: { id: paymentId },
                success: function (response) {
                    console.log(response);
                    location.reload();
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        });

        //AJAX store debt and create client
        $("#btn_store").on("click", function(event){
            //event.preventDefault();

            $('form').append('<input type="hidden" name="books_id" value="<?php echo $selectedClient['id'];?>">');

            $.ajax({
                url: "singup_logic.php",
                method:"post",
                data: $('form').serialize(),
                dataType: "text",
                success: function (response) {
                    console.log(response); // Log the response for debugging
                    $('form')[0].reset();
                    console.log("Form cleared");
                }
            })
        })

        //AJAX Store payment
        $("#btn_store_payment").on("click", function(event){
            event.preventDefault();

            $('form').append('<input type="hidden" name="books_id" value="<?php echo $selectedClient['id'];?>">');

            $.ajax({
                url: "singup_payment_logic.php",
                method:"post",
                data: $('form').serialize(),
                dataType: "text",
                success: function (response) {
                    console.log(response); // Log the response for debugging
                    // $('form')[0].reset();
                    console.log("Form cleared");
                    location.reload();
                }
            })

        })
    });
</script>

</body>
