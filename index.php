<?php
include_once('assets/php/userClass.php');
if($_SESSION['sesion_exito'] != 1) {
    header('Location: login.php');
} else {
    $dataUser = userClass::obtenerDatosUnUsuario($_SESSION['uid']);
}
?>

<!DOCTYPE html>
<!-- CUALQUIER PARECIDO CON EL TILO ES MERA COINCIDENCIA -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-3.6.1.min.js"></script>
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link rel="shortcut icon" href="assets/img/logos/logoprin.png">
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
                <div class="contenedor w-100 h-100">
                <?php
                include 'assets/php/menu/menu2.php';
                ?>
                <div class="mensaje-bienvenida w-100" style=" height: 60%;display:flex; align-items: center; justify-content: center;">
                <?php
                            if($dataUser) {
                                if($dataUser->genero == "F") {
                                    ?>
                                    <p class="h2 display-4 text-animation typing-animation">Bienvenida <?php echo  $dataUser->nombre;?></p>
                                    <?php
                                } else {
                                    ?>
                                    <p class="h2 display-4 text-animation typing-animation">Bienvenido <?php echo  $dataUser->nombre;?></p>
                                    <?php
                                }
                            
                            }
                        ?>
                </div>

                    <div class="logosCompany" style="position:absolute; bottom: 0px; right: 0px; opacity: 0.9;">
                        <img src="assets/img/logos/logoceibal.png" alt="" width="150">
                        <img src="assets/img/logos/logosonda.png" alt="" width="150">
                        <div id="embed-iframe"></div>
                    </div>
                            
                </div>
            </div>
        </div>
    </div>
    <style>
        body {
	background: linear-gradient(-45deg, #FFFFFF, #04a19c, #2b69f2, #FFFFFF);
	background-size: 400% 400%;
	animation: gradient 30s ease infinite;
	height: 100vh;
}

@keyframes gradient {
	0% {
		background-position: 0% 50%;
	}
	50% {
		background-position: 100% 50%;
	}
	100% {
		background-position: 0% 50%;
	}
}
        .text-animation{
    border-right: 2px solid rgb(255, 255, 255, .75);
    color: rgba(255, 255, 255, .75);
    font-size: 4em;
    text-align: center;
    height: 11vh;
    margin: 0 auto;
    white-space: nowrap;
    overflow: hidden;
    width: 100%;
}

.typing-animation{
    animation: blinkCursor 500ms steps(40) infinite normal, typing 4s steps(40) 1s normal both;
}
@keyframes blinkCursor {
    from{
    border-color: rgba(255, 255, 255, .75);
    }
    to{
    border-right-color: transparent;
    }
}

@keyframes typing {
    from{
    width: 0;
    }
    to{
    width: 10em;
    }
}
    </style>
</body>
</html>
