<?php
include_once('assets/php/connection.php');
include_once('assets/php/inventoryClass.php');

$inventario = inventoryClass::obtenerInventario();


if(isset($_GET['pag'])) {
    $pagina = $_GET['pag'];
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
        <div class="col-10">   
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
                                        if(isset($pagina) == $x) {
                                            ?>
                                            <li class="page-item active">
                                            
                                            <a class="page-link" href="inventario.php?pag=<?php echo $x ?>"><?php echo $x ?>
                                            </a>
                                            </li>
                                            <?php
                                        } else {
                                            
                                        }
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
