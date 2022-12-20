<?php
include_once('../assets/php/connection.php');
include '../assets/php/userClass.php';
include_once('../assets/php/inventoryClass.php');

$admin = $_SESSION['uid'];
$connectAdmin =  userClass::obtenerDatosUnUsuario($admin);

if(!$connectAdmin->class == "Admin") {
    header('Location: ../login.php');
} else {
    $dataUser = userClass::obtenerDatosUnUsuario($_SESSION['uid']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/jquery-3.6.1.min.js"></script>
    <link href="../assets/css/styles.css" rel="stylesheet" />
    <title>Document</title>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-2" style="padding-left: 0;">
            <div class="nav-MenuVert">
                <nav class="navbar navbar-expand d-flex flex-column align-items-start" id="sidebar">
                    <a href="../index.php" class="navbar-brand text-light mt-5 d-block mx-auto">
                        <div class="display-6" style="font-size: 30px;">StockControl
                        </div>
                    </a>
                    <ul class="navbar-nav d-flex flex-column mt-5 w-100">
                        <li class="nav-item w-100 mt-3">
                            <a href="movimientos.php" class="nav-link text-light pl-4">Movimientos Generales</a>
                        </li>
                        <li class="nav-item w-100 mt-3">
                            <a href="../inventario.php" class="nav-link text-light pl-4">Inventario</a>
                        </li>
                                
                        <li class="nav-item w-100 mt-3">
                            <a href="../admin/reportes.php" class="nav-link text-light pl-4">Reportes</a>
                        </li>
                        <li class="nav-item w-100" style="margin-top: 100%;">
                            <a href="../index.php" class="nav-link text-light pl-4">Volver</a>
                        </li>
                    </ul>
                </nav>  
            </div>
        </div>

            <div class="col-10">  
                <nav class="navbar navbar-expand-lg mb-5">
                    <div class="container">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav" style="position: absolute; left: 80%; top: 5%;">
                                    <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php echo $dataUser->nombre." ".$dataUser->apellido ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
                                    </ul>
                                    </li>
                                </ul>
                        </div>
                    </div>
                </nav>
                <div class="row">
                    <div class="col-8">
                        
                        <div id="tabla-movimientos" style="height: 450px; overflow-y: scroll;">
                            
                        </div>
                        <div class="row mx-auto">
                            <div class="col-xs-12 col-sm-6 mx-auto">
                            <div class="col-xs-12 col-sm-6 mx-auto">
                        </div>
                    </div>
                </div>

                        
                </div>
                <div class="col-4">
                    <button class="btn btn-outline-primary mb-3 btnFiltros" style=""><svg xmlns="http:/www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter"viewBox="0 0 16 16">
                    <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 01h-11a.5.5 0 0 1-.5-.5z"/>
                    </svg> Filtros</button>
                    <div class="card d-none" id="pageFiltros">
                        <h5 class="card-header">Filtros</h5>
                        <div class="card-body">
                        <label for="start">Fecha Inicio:</label>
                        <input type="date" class="mb-4" id="startDate" name="trip-start"
                            value="2022-11-01"
                            min="2022-01-01" max="3018-12-31"> <br>
                        <label for="start">Fecha Final:</label>
                        <input type="date" class="mb-4" id="endDate" name="trip-start"
                            value="2022-11-10"
                            min="2022-01-01" max="3018-01-01"> <br>
                        <label for="codigoRep">Respuesto</label>
                        <input type="text" class="form-control w-50 d-inline-block mb-3" id="codigoRep"placeholder="Código" />
                        <button class="btn btn-outline-primary w-100 btnFiltrar">Filtrar</button>
                    </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
            <div class="logosCompany" style="position:absolute; bottom: 0px; right: 0px; opacity: 0.9;">
                <img src="assets/img/logos/logoceibal.png" alt="" width="150">
                <img src="assets/img/logos/logosonda.png" alt="" width="150">
            </div>
    </div>        
</div>

<script>
    
    jQuery(document).ready(function(){
            // Listen for the input event.
            jQuery("#codigoRep").on('input', function (evt) {
                // Allow only numbers.
                jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
            });
        });
    $.ajax({
        url: 'assets/php/inventoryClass.php',
        data: {funcion: "filtrarMovimientosGenerales"},
        type: "post",
        success: function(e) {
            $('#tabla-movimientos').html(e);
         },
        error: function(e) {
            console.log(e);
        }
     });

     $(document).on('click', '.btnFiltros', function(e) {
        e.preventDefault();
        var filtros = document.getElementById('pageFiltros');

        if(filtros.classList.contains('d-none')) {
            filtros.classList.remove('d-none');
        } else {
            filtros.classList.add('d-none');
        }

        $(document).on('click', '.btnFiltrar', function(e) {
            var fechaIni = document.getElementById('startDate').value;
            var fechaFin = document.getElementById('endDate').value;
            var codigo = document.getElementById('codigoRep').value;

            $.ajax({
                url: 'assets/php/inventoryClass.php',
                data: {dateIni: fechaIni, dateFin: fechaFin, code: codigo, funcion: "filtrarMovimientosGenerales"},
                type: "post",
                success: function(event) {
                    $('#tabla-movimientos').html(event);
                },
                error: function(e) {
                    $('#tabla-movimientos').html("Ha ocurrido un error.");
                }
            });
        });
     });
</script>
</body>
</html>