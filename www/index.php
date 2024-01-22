<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <title>Bootstrap Sidebar</title>
    <style>

        body {
            padding-top: 56px; /* Adjusted for the fixed navbar */
            background-color: #F2F2F2;
        }
        div{
            border: 2px solid #050505;
        }
        hr {
            border: 1px;
            clear:both;
            display: flex;
            width: 100%;
            background: radial-gradient(circle, #F2F2F2 0%, #6c757d 100%);
            height: 0px;
        }
    </style>
</head>
<body>
   <div class="container border-dark bg-custom1 roundedcustom1 text-white" style="height: auto" >
       <h2 class="mt-3 border-0"><img src="Include/clientmodule/assets/gas-pump-xxl.png" width="40" height="40">Gerencial Posto DSAN</h2>
       <hr>
           <div class="row rounded border-0"">

               <a href="Include/Signupform.php" class=" roundedcustom1 nav-item bg-dark col p-3 mb-1 mt-1 ml-1 mr-1 btn-outline-secondary text-white w-25" style=" max-width: 200px;" align="center">
                   <span class="font-weight-bold"><img src="Include/clientmodule/assets/Database_fill.png" width="50" height="50" align="left">Clientes & Débitos</span>
               </a>

            <div class="col border-0"">Cadastros</div>
               <div class="col border-0"">Produtos</div>
               <div class="col border-0"">Listagens</div>
       </div>
       <div class="row rounded border-0"">
             <a href="#" class="nav-item roundedcustom1 font-weight-bold col ml-1 mr-1 mt-1 mb-1 btn-outline-success alert-danger h-auto " style="height: 50px;">
               <img class="mt-1" src="Include/clientmodule/assets/notebook_duotone_line.png" width="50" height="50">
               <span class="container btntext-uppercase text-white align-text-top" style="max-width: fit-content">Caixa</span>
           </a>
       </div>
</body>
</html>