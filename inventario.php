<?php
include_once('assets/php/connection.php');
include 'assets/php/userClass.php';
include_once('assets/php/inventoryClass.php');
$inventario = inventoryClass::obtenerInventario();
$pagina = 1;
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
            
            <div class="col-8">
            <table  id="tablaMovimientos" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col" class="th-sm">Código</th>
                        <th scope="col" class="th-sm">Nombre</th>
                        <th scope="col" class="th-sm">Cantidad</th>
                    </tr>
                </thead>
                <tbody id="productTable">
                    <?php foreach($inventario as $inv): ?>
                        <tr>
                        <td><?php echo $inv['code'] ?></td>
                        <td><?php echo $inv['name'] ?></td>
                        <td><?php echo $inv['qty'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table> 

            <div class="row mx-auto">
                <div class="col-xs-12 col-sm-6 mx-auto">
                    <div class="col-xs-12 col-sm-6 mx-auto">
                        <p>Página <?php echo inventoryClass::$pagina ?> de <?php echo inventoryClass::$paginas ?> </p>
                    </div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                            <?php if(inventoryClass::$pagina == 1): ?>
                                <li class="page-item disabled">
                                    <a class="page-link" href="">Previous</a>
                                </li>
                            <?php else: ?>
                                <li class="page-item">
                                    <a class="page-link" href="inventario.php?pag=<?php echo (inventoryClass::$pagina-1); ?>">Previous</a>
                                </li>
                            <?php endif;
                                $totalPagination = inventoryClass::$conteo / inventoryClass::$productosPorPagina-15;
                                for($i = 1; $i<$totalPagination+1; $i++) {
                                    if(inventoryClass::$pagina == $i) {
                                        echo '<li class="page-item active"><a class="page-link" href="inventario.php?pag='.$i.'">'.$i.'</a></li>';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="inventario.php?pag='.$i.'">'.$i.'</a></li>';
                                    }
                                }
                                ?>
                            <?php if(inventoryClass::$pagina == inventoryClass::$paginas): ?>
                                <li class="page-item">
                                    <a class="page-link disabled" href="">Siguiente</a>
                                </li>
                            <?php else: ?>
                                <li class="page-item">
                                    <a class="page-link" href="inventario.php?pag=<?php echo (inventoryClass::$pagina+1); ?>">Siguiente</a>
                                </li>
                            <?php endif;?>
                            </ul>
                        </nav>
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
</body>
</html>
