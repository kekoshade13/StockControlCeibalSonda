<?php
include_once('assets/php/connection.php');
include_once('assets/php/inventoryClass.php');

$movimientos = inventoryClass::obtenerMovimientos();


if(isset($_GET['pag'])) {
    $pagina = $_GET['pag'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <link href="assets/css/styles.css" rel="stylesheet" />
    <title>Document</title>
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
                        <th scope="col">N°</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Código</th>
                        <th scope="col">Tipo de Movimiento</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($movimientos as $mov) {
                    ?>
                    <tr>
                        <th scope="row"><?php echo $mov->id_movement ?></th>
                        <th><?php echo $mov->nombre ?></th>
                        <th><?php echo $mov->code ?></th>
                        <th><?php echo $mov->move ?></th>
                        <th><?php echo $mov->qty ?></th>
                        <th><?php echo $mov->date ?></th>
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
                                    <li class="page-item <?php if($pagina == $x) {echo 'active'; }?>"><a class="page-link" href="movimientos.php?pag=<?php echo $x ?>"><?php echo $x ?></a></li>
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