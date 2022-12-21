<?php
include 'assets/php/userClass.php';

if(isset($_SESSION['sesion_exito']) != 0) {
    $dataUser = userClass::obtenerDatosUnUsuario($_SESSION['uid']);
    header("Location: index.php");
}
?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-3.6.1.min.js"></script>
    <link href="assets/css/styles.css" rel="stylesheet" />
    <title>Login Prueba</title>
    <style>
        body {
            background-image: url('assets/img/ceibal.png');
            background-repeat: repeat;
            background-position: center, no-cover;
        }
    </style>
</head>
<body class="bg-light" b >
    <div class="wrapper row col-12 w-100">
        <div id="formcontent" class="w-25">
             <form id="" method="POST">
                <div class="form-control">
                    <div class="col-md-6 mb-5 w-100">
                        <p class="text-center" style="font-size: 35px;">Bienvenido/a al sistema</p>
                    </div>
                    <div>
                        <label id="lblUsuario">Cédula</label>
                        <input type="text" id="txtUsuario" name="ci" class="form-control" placeholder="Ingresa tu cedula" required>
                    </div>
                    <div>
                        <label ID="lblPassword">Contraseña</label>
                        <input id="txtPassword" type="password" name="contrasenia" class="form-control" placeholder="Ingresa tu contraseña" required>
                    </div>
                    <hr />
                    <div class="row">
                        <label id="lblError" class="alert-danger"></label>
                    </div>
                    <br />
                    <div class="row">
                        <input type="submit" id="btnLogin" class="btn btn-primary btn-dark" name="btnLogin" value="Ingresar">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="logosCompany" style="position:absolute; bottom: 0px; left: 0px; opacity: 0.9;">
                        <img src="assets/img/logos/logoceibal.png" alt="" width="150">
                        <img src="assets/img/logos/logosonda.png" alt="" width="150">
                        <div id="embed-iframe"></div>
                    </div>
    <?php
        if(!empty($_POST['btnLogin'])) {
            $ci = $_POST['ci'];
            $pass = $_POST['contrasenia'];
            ?>
            <?php
            if(strlen(trim($ci)) > 1 && strlen(trim($pass)) > 1) {
                $id = userClass::userLogin($ci, $pass);
                if($id) {
                    header("Location: index.php");
                } else {
                    header('Location: login.php');
                }
            } else {
                echo 'no';
            }
        }
    ?>
</body>
</html>