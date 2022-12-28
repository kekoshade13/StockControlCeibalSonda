<?php
include_once('assets/php/connection.php');
include 'assets/php/userClass.php';
include_once('assets/php/inventoryClass.php');
if($_SESSION['sesion_exito'] != 1) {
    header('Location: login.php');
} else {
    $dataUser = userClass::obtenerDatosUnUsuario($_SESSION['uid']);
    $obtenerEquipos = inventoryClass::obtenerEquipos();
    $obtenerTipoStock = inventoryClass::obtenerTiposStock();
}
?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <link href="assets/css/styles.css" rel="stylesheet" />
    <title>Inicio</title>
    <link rel="shortcut icon" href="assets/img/logos/logoprin.png">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-2" style="padding-left: 0;">
        <?php
            include 'assets/php/menu/menu.php';
        ?>
        </div>
        <div class="col-10 h-50">   
            <nav class="navbar navbar-expand-lg mb-5">
                <div class="container">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav" style="position: absolute; left: 80%; top: 5%;">
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="assets/img/img_perfil/<?php echo $dataUser->nombre_u; ?>/<?php echo $dataUser->nombre_u?>.jpeg" alt="" width="35" style="width: 40px; height: 40px;border-radius: 100px;">     
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
                </div>
                <div class="col-4">
                    <button class="btn btn-outline-primary mb-3 btnFiltros" style=""><svg xmlns="http:/www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter"viewBox="0 0 16 16">
                    <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 01h-11a.5.5 0 0 1-.5-.5z"/>
                    </svg> Filtros</button>
                    <div class="card d-none" id="pageFiltros">
                        <h5 class="card-header">Filtros</h5>
                        <div class="card-body">
                        <label for="codigoRep">Respuesto</label>
                        <input type="text" class="form-control w-50 d-inline-block mb-3" id="codigoRep" placeholder="Código" />
                        <select id="selectEquipos" class="form-select mb-3">
                            <option value="" selected disabled>Selecciona el modelo</option>
                            <?php foreach($obtenerEquipos as $equipo): ?>
                            <option value="<?php echo $equipo->id_equipo ?>"><?php echo $equipo->nameEq ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select id="selectTipoStock" class="form-select mb-3">
                            <option selected disabled value="">Tipo de Stock</option>
                            <?php foreach($obtenerTipoStock as $tipoStock): ?>
                            <option value="<?php echo $tipoStock->id_stock ?>"><?php echo $tipoStock->nameTipoStock ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="CheckCompatiblesR">
                            <label class="form-check-label" for="CheckCompatiblesR" onclick="desactivarActivar()">Repuestos Compatibles</label>
                        </div>
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
                <img src="assets/img/logos/logoceibal.png" alt="" width="150">
                <img src="assets/img/logos/logosonda.png" alt="" width="150">
            </div>
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
        data: {funcion: "filtrarInventario"},
        type: "post",
        success: function(e) {
            $('#tabla-movimientos').html(e);
         },
        error: function(e) {
            console.log(e);
        }
     });

     $(document).on('click', '.btnLimpiar', function(e) {
        $.ajax({
            url: 'assets/php/inventoryClass.php',
            data: {funcion: "filtrarInventario"},
            type: "post",
            success: function(e) {
                $('#tabla-movimientos').html(e);
                document.getElementById('codigoRep').value = '';
                document.getElementById('selectEquipos').value = '';
                document.getElementById('selectTipoStock').value = '';
                document.getElementById('CheckCompatiblesR').checked = false;
                $('#selectTipoStock').removeAttr('disabled');
            },
            error: function(e) {
                console.log(e);
            }
        });
     });

     $(document).on('click', '.btnFiltros', function(e) {
        e.preventDefault();
        var filtros = document.getElementById('pageFiltros');

        if(filtros.classList.contains('d-none')) {
            filtros.classList.remove('d-none');
        } else {
            filtros.classList.add('d-none');
        }
            var repCompatible = "";

        $(document).on('click', '.btnFiltrar', function(e) {
            var codigo = document.getElementById('codigoRep').value;
            var equipo = document.getElementById('selectEquipos').value;
            var tipoStock = document.getElementById('selectTipoStock').value;

            var repCompatible = "";
            if($('#CheckCompatiblesR').is(':checked')) {
                e.preventDefault();
                repCompatible = "Si";
                $('#selectTipoStock').attr('disabled', 'disabled');
            } else {
                repCompatible = "";
                $('#selectTipoStock').removeAttr('disabled');
            }

            $.ajax({
                url: 'assets/php/inventoryClass.php',
                data: {code: codigo, modelo: equipo, compatible: repCompatible, tipoEstado: tipoStock, funcion: "filtrarInventario"},
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

     function desactivarActivar() {
        if($('#CheckCompatiblesR').is(':checked')) {
                e.preventDefault();
                $('#CheckCompatiblesR').attr('disabled');
            } else {
                $('#CheckCompatiblesR').removeAttr('disabled');
            }
     }
</script>
</body>
</html>
