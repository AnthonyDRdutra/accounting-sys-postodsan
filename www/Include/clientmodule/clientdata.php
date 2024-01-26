<?php

include "CRUD_logic.php";
$list = new \Include\CRUD_logic();
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
    <script src="../bootstrap/js/bootstrap.min.js"></script>

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

        body {
            font-family: "Lucida Console", monospace;
            background-color:black;
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
    <a href='/Include/Signupform.php'>Voltar</a>
    <div class='row container-fluid'>
        <div class=" mt-2 col" style="max-width: 450px">


            <!--Tabela de Débitos-->
            <div  class =" ml-2 mr-3 text-primary text-center" style="min-width: 410px">
                <h4>Débitos</h4>
            </div>
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                <table class=" table-hover ml-2 text-primary border-white" border="2px;" style=min-width: 410px">
                    <th class="text-center">Nome</th>
                    <th class="text-center">Valor</th>
                    <th class="text-center">Data e Hora</th>
                    <th class="text-center">Responsável</th>
                    <th class="text-center">Ações</th>

                    <?php foreach ($list->Client_Debt_list($id) as $dbpostodsan): ?>
                        <tr>
                            <td class="text-center"><?=$dbpostodsan['name'];?></td>
                            <td class="text-center text-primary">R$ <div><?=$dbpostodsan['value'];?></div></td>
                            <td class="text-center"><?=$dbpostodsan['date'];?></td>
                            <td class="text-center"><?=$dbpostodsan['ateendee'];?></td>

                            <td>
                                <div class="row " align="center" style="max-width: min-content; max-height: fit-content">
                                    <div class="col ml-2">
                                        <a href="#" class="delete-debtticket text-danger" data-id="<?=$dbpostodsan['id'];?>">
                                            *<h4>X</h4>*
                                        </a>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

        <!--Tabela de Pagamentos-->
        <div class="mt-2 col" style="max-width: 450px">
            <div class ="ml-2 mr-3 text-center text-primary border-white" style="min-width: 410px">
                <h4>Adiantamentos</h4>
            </div>
            <table class="table-hover ml-2 text-primary border-white" border="2px;" style="min-width: 410px; max-width: 410px;">
                <th class="text-center">Nome</th>
                <th class="text-center">Valor</th>
                <th class="text-center">Data e Hora</th>
                <th class="text-center">Responsável</th>
                <th class="text-center">Ações</th>

                <?php foreach ($list->Client_payment_list($id) as $dbpostodsan): ?>
                    <tr class="mb-1 text-primary">
                        <td class="text-center"><?=$dbpostodsan['name'];?></td>
                        <td class="text-center">R$ <div><?=$dbpostodsan['value'];?></div></td>
                        <td class="text-center"><?=$dbpostodsan['date'];?></td>
                        <td class="text-center"><?=$dbpostodsan['atendee'];?></td>

                        <td>
                            <div class="row " align="center" style="max-width: fit-content; max-height: fit-content">
                                <div class="col ml-2">
                                    <a href="#" class="delete-paymentticket text-danger" data-id="<?=$dbpostodsan['id'];?>">
                                        *<h4>X</h4>*
                                    </a>
                                </div>
                            </div>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </table>
        </div>


        <!--Tabela de metricas-->
        <div class="col container text-primary align-content-center" style="max-width: 410px;max-height: 100px">
            <div class=" col" align="center" >
               <h2> <?php echo $selectedClient['client_name'] ?> </h2>
            </div>
            <table>
                <?php foreach ($list->Metriclist($id) as $dbpostodsan): ?>
                <tr>
                    <td class="text-center "> Débitos <div> R$ <?=$dbpostodsan['metric_debts'];?></div>
                        <hr></td>

                    <td class="text-center "> Adiantamentos  <div>R$ <?=$dbpostodsan['metric_payments'];?></div>
                        <hr></td>

                    <td class="text-center "> Restante  <div>R$ <?=$dbpostodsan['metric_topay'];?></div>
                        <hr></td>

                <?php endforeach; ?>
            </table>
            <div class="col border-white" style="max-height: 450px;">

                <!--Card de Cadastro de pagamentos-->
                <div class="row mt-3" style ='min-width: 380px; max-width: 380px;'>
                    ~/// Registro de Pagamento
                    <div class="card bg-white border-white card-body roundedcustom1" border="2px;">
                        <div class="row h-auto w-auto" align="center" >
                            <input type="text" name="client_name_input_payment" id="client_name_input_payment" class="container form-control  input-group-lg text-primary bg-dark roundedcustom1" autocomplete="off" placeholder="Nome do Cliente..." value="<?php echo $selectedClient['client_name']; ?>" readonly>
                        </div>
                        <div class="row h-auto w-auto">
                            <input type="number" name="input_value_payment" id="input_value_payment" class="text-primary bg-dark roundedcustom1 container form-control" placeholder="Valor (R$)...">
                        </div>
                        <div class="row h-auto w-auto">
                            <label for="dropdown" class="text-dark">Responsável:</label>
                            <select class="form-control text-primary bg-dark roundedcustom1" id="dropdown" name="atendee_payment">
                                <?php
                                foreach($list->Attendeelist() as $dbpostodsan):
                                    $atendeename = $dbpostodsan['atendee_name'];
                                    echo "<option value='" . htmlspecialchars($atendeename). "' id='atendee" . "' name='atendee'>" . htmlspecialchars($atendeename) . "</option>";
                                endforeach; ?>
                            </select>
                            <div class="col" align="center">
                                <button type="submit" class="btn bg-white roundedcustom1 mt-1" style="max-width: 200px; max-height: 40px;" id="btn_store_payment">
                                    <h4>Salvar</h4>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>


                <!--Card de Cadastro de Débitos-->
                <div class="row mt-1" style ='min-width: 380px; max-width: 380px;'>
                    ~/// Registro de Débito
                        <div class="card card-body bg-dark text-primary border-white" style ='min-width: 380px; max-width: 380px; max-height: 220px;'>
                            <div class="row h-auto w-auto" align="center" >
                                <input type="text" name="client_name_input" id="client_name_input" class="roundedcustom1 bg-dark text-primary bordercustom1 container form-control input-group-lg" autocomplete="off" placeholder="Nome do Cliente..." value="<?php echo $selectedClient['client_name']; ?>" readonly>
                            </div>
                            <div class="row mt-1 h-auto w-auto">
                                <input type="number" name="input_value" id="input_value" class="roundedcustom1 bg-dark text-primary bordercustom1 container form-control" placeholder="Valor (R$)...">
                            </div>
                            <div class="row h-auto w-auto">
                                <label for="dropdown">Responsável:</label>
                                <select class="roundedcustom1 text-muted bg-white bordercustom1 form-control" id="dropdown" name="atendee">
                                    <?php
                                    foreach($list->Attendeelist() as $dbpostodsan):
                                        $atendeename = $dbpostodsan['atendee_name'];
                                        echo "<option value='" . htmlspecialchars($atendeename). "' id='atendee" . "' name='atendee'>" . htmlspecialchars($atendeename) . "</option>";
                                    endforeach; ?>
                                </select>
                                <div class="col mt-1" align="center">
                                    <button type="submit" class="btn text-primary bg-dark roundedcustom1" style="min-width: 20px; max-height: 40px;" id="btn_store">
                                        <h4>Salvar</h4>
                                    </button>
                                </div>
                            </div>
                        </div>

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
					location.reload();
                    
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
