<?php
include_once('assets/php/userClass.php');
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
                    <div class="mensaje-bienvenida">
                        <?php
                            if(isset($_GET['id'])) {
                                 if($_SESSION['uid'] == $_GET['id']) {
                                    $dataUser = userClass::obtenerDatosUnUsuario($_GET['id']);
                                    if($dataUser) {
                                    ?>
                                        <p class="h1 display-4">Bienvenido <?php echo  $dataUser->nombre_u;?></p>
                                    <?php
                                    }
                                } else {
                                    header("Location: index.php?id=".$_SESSION['uid']);
                                }
                            }
                        ?>
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
