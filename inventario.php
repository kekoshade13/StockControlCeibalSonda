<?php
include_once('assets/php/connection.php');
include 'assets/php/userClass.php';
include_once('assets/php/inventoryClass.php');
$inventario = inventoryClass::obtenerInventario();
$pagina = 0;
if($_SESSION['sesion_exito'] != 1) {
    header('Location: login.php');
} else {
    $dataUser = userClass::obtenerDatosUnUsuario($_SESSION['uid']);
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
                        <ul class="navbar-nav">
                            <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="#">Features</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="#">Pricing</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link disabled">Disabled</a>
                            </li>
                        </ul>
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
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($inventario as $inv) {
                    ?>
                    <tr>
                        <th scope="row"><?php echo $inv->code ?></th>
                        <th><?php echo $inv->name ?></th>
                        <th><?php echo $inv->qty ?></th>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>                
            </table>  

            <div class="row mx-auto">
                <div class="col-xs-12 col-sm-6 mx-auto">
                    <div class="col-xs-12 col-sm-6 mx-auto">
                        <p>Página <?php echo inventoryClass::$pagina ?> de <?php echo inventoryClass::$paginas ?> </p>
                    </div>
                    <nav aria-label="Page navigation example">
                        <form action="assets/php/inventoryClass.php">
                            <ul class="pagination">
                                <?php
                                
                                    for($x = 1; $x <= inventoryClass::$paginas; $x++) {
                                        ?>
                                        <li class="page-item <?php if($pagina == $x) {echo 'active'; }?>"><a class="page-link" href="inventario.php?pag=<?php echo $x ?>"><?php echo $x ?></a></li>
                                        <?php
                                    }
                                ?>
                            </ul>
                        </form>
                     </nav>
                </div>
                        </div>
            <div class="logosCompany" style="position:absolute; bottom: 0px; right: 0px; opacity: 0.9;">
                <img src="assets/img/logos/logoceibal.png" alt="" width="150">
                <img src="assets/img/logos/logosonda.png" alt="" width="150">
            </div>
        </div>
    </div>        
</div>
</body>
</html>
