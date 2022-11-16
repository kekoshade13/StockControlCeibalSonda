<?php
include 'assets/php/userClass.php';

if(isset($_SESSION['sesion_exito']) != 0) {
    $dataUser = userClass::obtenerDatosUnUsuario($_SESSION['uid']);
    header("Location: index.php?id=$dataUser->id_user");
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
</head>
<body class="bg-light">
    <div class="wrapper">
        <div id="formcontent">
             <form id="" method="POST">
                <div class="form-control">
                     <div class="col-md-6 text-center mb-5">
                         <label class="h2" id="lblBienvenida">Bienvenido al sistema</label>
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