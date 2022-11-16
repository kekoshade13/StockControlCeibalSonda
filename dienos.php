<?php
include_once('assets/php/connection.php');
include 'assets/php/userClass.php';

if(isset($_GET['pag'])) {
    $pagina = $_GET['pag'];
}

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
  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div id="tabla" class="col-sm-3">

</div>


<script>
            var user = "JPAZ";
            $.ajax({
                url: 'assets/php/inventoryClass.php',
                data: {nombre_u: user, funcion: "filtrarMovimientos"},
                type: "post",
                success: function(e) {
                    $('#tabla').html(e);
                },
                error: function(e) {
                    $('#tabla').html = e;
                }
            });
</script>
</body>
</html>