<?php
include_once('assets/php/userClass.php');
if($_SESSION['sesion_exito'] != 1) {
    header('Location: login.php');
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
    <title>Document</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <link href="assets/css/styles.css" rel="stylesheet" />
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-2" style="padding-left: 0;">
        <?php
             include 'assets/php/menu/menu.php';
        ?>
        </div>
        <div class="col-10">
            <div class="contenedor">
            <?php
            include 'assets/php/menu/menu2.php';
            ?>
                <div class="dropdown btn-group" style="position:relative; top: 30px; left: 50px;">
                    <a class="btn border-success dropdown-toggle btn-lg" href="#" id="resultadoConsumo" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        Seleccionar acción
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <?php
                            $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                            for($m=0; $m<=12; $m++) {
                        ?>
                                <li><button class="btn dropdown-item btn-lg" id="consumirRep" type="button" onclick="mostrarConsumirODevolver('consumirRep')"><?php echo $meses[$m] ?></button></li>
                        <?php
                            }
                        ?>
                    </ul>
                </div>
                <div class="logosCompany" style="position:absolute; bottom: 0px; right: 0px; opacity: 0.9;">
                    <img src="assets/img/logos/logoceibal.png" alt="" width="150">
                    <img src="assets/img/logos/logosonda.png" alt="" width="150">
                </div>
                        
            </div>
         </div>
    </div>
</div>
</body>
</html>