<?php
include "CRUD_logic.php";
$list = new \Include\CRUD_logic();
?>

<head title="Cadastro de Débito">
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css">

    <script src="jquery3.7.1.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <!--AJAX Scripts-->
    <script>
        $(document).ready(function () {
            $('#client_name_input').typeahead({
                source: function (query, result) {
                    $.ajax({
                        url: "fetch.php",
                        method: "POST",
                        data: { query: query },
                        dataType: "json",
                        success: function (data) {
                            console.log("Data from fetch.php:", data); // Log the received data
                            result($.map(data, function (item) {
                                return {
                                    id: item.id,
                                    value: item.client_name
                                };
                            }));
                        },
                        error: function (xhr, status, error) {
                            console.error("Error fetching data:", error); // Log any errors
                        }
                    });
                },
                displayText: function (item) {
                    return item.value;
                }
            });

            $('#client_name_input_payment').typeahead({
                source: function (query, result) {
                    $.ajax({
                        url: "fetch.php",
                        method: "POST",
                        data: { query: query },
                        dataType: "json",
                        success: function (data) {
                            console.log("Data from fetch.php:", data); // Log the received data
                            result($.map(data, function (item) {
                                return {
                                    id: item.id,
                                    value: item.client_name
                                };
                            }));
                        },
                        error: function (xhr, status, error) {
                            console.error("Error fetching data:", error); // Log any errors
                        }
                    });
                },
                displayText: function (item) {
                    return item.value;
                }
            });
        });

    </script>

    <style>

        body {
            font-family: "Lucida Console", monospace;
            background-color:black;
        }
        hr {
            border: 0px;
            clear:both;
            display: flex;
            width: 100%;
            background: radial-gradient(circle, #353a4a 0%, #F2F2F2 100%);
            height: 1px;
        }
    </style>
</head>

<body>

<div class="row container ml-0">
    <form method="post">
        <a href='/index.php'>Voltar</a>
        <div class="row">
            <div class="col ml-0 w-auto h-auto">

                <!--Live search-->

                <div class=" container-fluid card card-body border-white border-dark bg-dark text-primary  mt-1" style="min-width: 550px;">
                    <div class='row'>
                        <div class="col-5">Pesquisa de Cliente
                            <input class="bg-dark border-white text-primary form-control" type="live_search" id="live_search" name="search" style="max-width: fit-content; text-decoration-color: white" placeholder="nome do cliente...">

                            <!--livesearch-->
                            <div class="container-fluid" id="search_result" style="min-width: 550px;">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <hr>


            <!--Card de Cadastro de Débito-->
            <div class="col mt-1" align="Left">
                <p style="max-height: 24px" align="Left">
                    <button class="btn btn-dark border-white ml-0" style="width: fit-content; height: auto" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Cadastrar Débito
                    </button>
                </p>

                <div class="collapse row" style="width: fit-content" id="collapseExample">

                    <div class="col text-primary"> ///Débito////
                        <div class="card card-body border-white bg-dark mt-1">
                            <div class="row mb-1 h-auto w-auto" align="center" >
                                <input type="text" name="client_name_input" id="client_name_input" class="container bg-dark border-white text-primary form-control input-group-lg" autocomplete="off" placeholder="Nome do Cliente...">
                            </div>~~~~

                            <div class="row mt-1 mb-1 h-auto w-auto text-primary">
                                <input type="number" name="input_value" id="input_value" class="container bg-dark border-white text-primary form-control" placeholder="Valor (R$)...">
                            </div>~~~~

                            <div class="row mt-1 mb-1 h-auto w-auto">
                                <label for="dropdown" class="text-primary">Responsável:</label>
                                <select class="form-control border-white bg-dark text-primary" id="dropdown" name="atendee">
                                    <?php
                                    foreach($list->Attendeelist() as $dbpostodsan):
                                        $atendeename = $dbpostodsan['atendee_name'];
                                        echo "<option value='" . htmlspecialchars($atendeename). "' id='atendee" . "' name='atendee'>" . htmlspecialchars($atendeename) . "</option>";
                                    endforeach; ?>
                                </select>
                            </div>
                            <div class="col mt-1 mb-1" align="center">
                                <button type="submit" class="btn btn-danger border-white" style="min-width: 250px; max-height: 40px;" id="btn_store">
                                    salvar
                                </button>
                            </div>
                        </div>

                    </div>


                    <div class="col text-primary">///Pagamento///
                        <div class="card card-body bg-dark border-white mt-1">
                            <div class="row mb-1 h-auto w-auto" align="center" >
                                <input type="text" name="client_name_input_payment" id="client_name_input_payment" class="container border-white form-control bg-dark text-primary input-group-lg" autocomplete="off" placeholder="Nome do Cliente...">
                            </div>~~~~

                            <div class="row mt-1 mb-1 h-auto w-auto text-primary">
                                <input type="number" name="input_value_payment" id="input_value_payment" class="container bg-dark border-white form-control" placeholder="Valor (R$)..." style="color: #fff;">
                            </div>~~~~

                            <div class="row mt-1 mb-1 h-auto w-auto">
                                <label for="dropdown" class="text-primary bg-dark text-primary">Responsável:</label>
                                <select class="form-control border-white bg-dark text-primary" id="dropdown" name="atendee_payment">
                                    <?php
                                    foreach($list->Attendeelist() as $dbpostodsan):
                                        $atendeename = $dbpostodsan['atendee_name'];
                                        echo "<option value='" . htmlspecialchars($atendeename). "' id='atendee" . "' name='atendee'>" . htmlspecialchars($atendeename) . "</option>";
                                    endforeach; ?>
                                </select>
                            </div>

                            <div class="col mt-1 mb-1" align="center">
                                <button type="submit" class="btn btn-info border-white" style="min-width: 250px; max-height: 40px;" id="btn_store_payment">
                                    salvar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>

        <!--dropdown listagem de débitos-->
        <div class="col mb-3 w-auto h-auto">

                <p  class="mb-3" style="max-height: 24px" align="Left">
                    <button class="btn btn-secondary ml-0 border-white border-dark bg-dark" style="width: fit-content; height: auto" type="button" data-toggle="collapse" data-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample">
                        Listagem de Débitos
                    </button>
                </p>


            <div class="collapse container-fluid" id="collapseExample2">

                <!-- card da listagem -->
                <div class=" container-fluid card card-body border-white bg-dark mt-1" style="min-width: 550px;">

                    <table class="table table-hover text-primary border-white text-center">

                        <tr>
                            <th>Cliente</th>
                            <th>Valor</th>
                            <th>Adiantamentos</th>
                            <th>A Pagar</th>
                            <th>mais...</th>
                        </tr>

                        <?php foreach ($list->DebtListing() as $dbpostodsan): ?>

                            <tr>
                                <td class="align-content-center"><?=$dbpostodsan['client_name'];?></td>

                                <td>R$<?=$dbpostodsan['debt'];?></td>

                                <td>R$<?=$dbpostodsan['payed'];?></td>

                                <td>R$<?=$dbpostodsan['topay'];?></td>

                                <td>
                                    <a href="/Include/clientdata.php?id=<?=$dbpostodsan['client_id'];?>">

                                        <img src="assets/Chart_alt_fill.png" height="20" width="20">
                                    </a>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>

        <hr>

        <!--(WIP) DropDown Contratantes-->
        <div class="col ml-0 w-auto h-auto">

            <p style="max-height: 24px" align="Left">

                <button class="btn btn-secondary ml-0" style="width: fit-content; height: auto" type="button" data-toggle="collapse" data-target="#collapseExample4" aria-expanded="false" aria-controls="collapseExample">
                    Contratantes
                </button>

            </p>

            <div class="collapse container-fluid" id="collapseExample4">

                <div class="card card-body bg-success mt-1"></div>

            </div>
        </div>
    </form>

    <!--end scripts ajax-->
    <script>
        $(document). ready(function(){
            console.log("page ready");

            $("#live_search").keyup(function () {
                var input = $(this).val();

                if (input != "") {
                    $.ajax({
                        url: "livesearch.php",
                        method: "POST",
                        data: { input: input },
                        success: function (data) {
                            $("#search_result").html(data);
                        }
                    });
                } else {
                    $("#search_result").html("");
                 //   $("#search_result").css("display", "none");
                }
            });

            $("#btn_store").on("click", function(event){
                event.preventDefault();

                var selectedClient = $('#client_name_input').typeahead('getActive');

                if (selectedClient) {
                    var clientId = selectedClient.id;
                    // Include the 'id' in the form data
                    $('form').append('<input type="hidden" name="books_id" value="' + clientId + '">');
                }

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
                //location.reload();
            })
        })
    </script>

    <script>
        $(document). ready(function(){
            console.log("page ready");

            $("#btn_store_payment").on("click", function(event){
                event.preventDefault();

                var selectedClient = $('#client_name_input_payment').typeahead('getActive');

                if (selectedClient) {
                    var clientId = selectedClient.id;
                    // Include the 'id' in the form data
                    $('form').append('<input type="hidden" name="books_id" value="' + clientId + '">');
                }

                $.ajax({
                    url: "singup_payment_logic.php",
                    method:"post",
                    data: $('form').serialize(),
                    dataType: "text",
                    success: function (response) {
                        console.log(response); // Log the response for debugging
                        $('form')[0].reset();
                        console.log("Form cleared");
                    }
                })
                //location.reload();
            })
        })
    </script>

</div>

</body>

