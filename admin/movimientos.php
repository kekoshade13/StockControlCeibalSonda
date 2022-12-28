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
    $dataUsuariosG = userClass::obtenerUsuarios();
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
    <link rel="shortcut icon" href="../assets/img/logos/logoprin.png">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-2" style="padding-left: 0;">
            <div class="nav-MenuVert">
                <nav class="navbar navbar-expand d-flex flex-column align-items-start" id="sidebar">
                <img src="../assets/img/logos/logoprin.png" alt="" width="200" height="150">
                    <a href="index.php" class="navbar-brand text-light d-block mx-auto">
                        <div class="display-6" style="font-size: 30px;">StockControl
                        </div>
                        <p class="text-center" style="font-size: 15px;">Administrador</p>
                    </a>
                    <ul class="navbar-nav d-flex flex-column mt-5 w-100">
                        <li class="nav-item w-100 mt-3">
                            <a href="movimientos.php" class="nav-link text-light pl-4">Movimientos Generales</a>
                        </li>
                                
                        <li class="nav-item w-100 mt-3">
                            <a href="../admin/reportes.php" class="nav-link text-light pl-4">Reportes</a>
                        </li>
                        <li class="nav-item w-100" style="margin-top: 30%;">
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
                                    <img src="../assets/img/img_perfil/<?php echo $dataUser->nombre_u; ?>/<?php echo $dataUser->nombre_u?>.jpeg" alt="" width="35" style="width: 40px; height: 40px;border-radius: 100px;">     
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
                    <div class="card d-none col-12" id="pageFiltros">
                        <h5 class="card-header">Filtros</h5>
                        <div class="card-body">
                        <label for="start">Fecha Inicio:</label>
                        <input type="date" class="mb-3" id="startDate" name="trip-start"> <br>
                        <label for="start">Fecha Final:</label>
                        <input type="date" class="mb-3" id="endDate" name="trip-start"> <br>
                        <label for="codigoRep">Respuesto</label>
                        <input type="text" class="form-control w-50 d-inline-block mb-3" id="codigoRep"placeholder="Código" />
                        <select class="form-select mb-3" id="tipoMov" style="margin-bottom: 5px;">
                            <option value="" selected disabled>Tipo de movimiento</option>
                            <option value="Entrada">Entrada</option>
                            <option value="Salida">Salida</option>
                        </select>
                        <select class="form-select mb-3" id="tipoStock" style="margin-bottom: 5px;">
                            <option value="" selected disabled>Tipo de Stock</option>
                            <option value="1">Origen</option>
                            <option value="2">Sano</option>
                            <option value="3">Remanufacturado</option>
                            <option value="4">Free</option>
                        </select>
                        <select class="form-select mb-3" id="selectUsuario" style="margin-bottom: 5px;">
                            <option value="" selected disabled>Usuario</option>
                            <?php foreach($dataUsuariosG as $userData) {?>
                            <option value="<?php echo $userData->nombre_u ?>"><?php echo $userData->nombre_u ?></option>
                            <?php } ?>
                        </select>
                        <div class="row">
                            <button class="btn btn-outline-primary col-7 btnFiltrar" style="margin-right: 15px; margin-left: 22px;">Filtrar</button>
                            <button class="btn btn-outline-danger col-3 btnLimpiar">Limpiar</button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
            <div class="logosCompany" style="position:absolute; bottom: 0px; right: 0px; opacity: 0.9;">
                <img src="../assets/img/logos/logoceibal.png" alt="" width="150">
                <img src="../assets/img/logos/logosonda.png" alt="" width="150">
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
        var functtion = {
            funcion: "filtrarMovimientosGenerales"
        };
    $.ajax({
        url: '../assets/php/inventoryClass.php',
        data: functtion,
        type: "POST",
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
            var tipoMov = document.getElementById('tipoMov').value;
            var tipoStock = document.getElementById('tipoStock').value;
            var usuario = document.getElementById('selectUsuario').value;
            $.ajax({
                url: '../assets/php/inventoryClass.php',
                data: {dateIni: fechaIni, dateFin: fechaFin, code: codigo, nombre_u: usuario, tipoMovi: tipoMov, tipoStoc: tipoStock, funcion: "filtrarMovimientosGenerales"},
                type: "post",
                success: function(event) {
                    $('#tabla-movimientos').html(event);
                },
                error: function(e) {
                    $('#tabla-movimientos').html("Ha ocurrido un error.");
                }
            });
        });

        $(document).on('click', '.btnLimpiar', function(event) {

        $.ajax({
            url: '../assets/php/inventoryClass.php',
            data: functtion,
            type: "post",
            success: function(e) {
                document.getElementById('startDate').value = '';
                document.getElementById('endDate').value = '';
                document.getElementById('codigoRep').value = '';
                document.getElementById('tipoMov').value = '';
                document.getElementById('tipoStock').value = '';
                document.getElementById('selectUsuario').value = '';
                $('#tabla-movimientos').html(e);
            },
            error: function(e) {
                console.log(e);
            }
            });
        });
    });
</script>
</body>
</html>