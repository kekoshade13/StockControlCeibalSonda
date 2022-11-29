<?php
include_once '../assets/php/connection.php';
include '../assets/php/userClass.php';
$admin = $_SESSION['uid'];
$connectAdmin =  userClass::obtenerDatosUnUsuario($admin);
if(!$connectAdmin->class == "Admin") {
    header("Location:../index.php");
} else {
    $listaUsuarios = userClass::obtenerUsuarios();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/jquery-3.6.1.min.js"></script>
    <link href="../assets/css/styles.css" rel="stylesheet" />
</head>
<body>
    <div class="container-fluid">
            <div class="row">
                <!-- -------------------------------------------------------------- Menu -------------------------------------------------------------- -->
                <div class="col-2" style="padding-left: 0;">
                    <div class="nav-MenuVert">
                        <nav class="navbar navbar-expand d-flex flex-column align-items-start" id="sidebar">
                            <a href="../index.php" class="navbar-brand text-light mt-5 d-block mx-auto">
                                <div class="display-6" style="font-size: 30px;">StockControl
                                </div>
                            </a>
                            <ul class="navbar-nav d-flex flex-column mt-5 w-100">
                                <li class="nav-item w-100 mt-1">
                                    <a href="../consumirrepuestos.php" class="nav-link text-light pl-4">Consumo repuestos</a>
                                </li>
                                <li class="nav-item w-100 mt-3">
                                    <a href="../movimientos.php" class="nav-link text-light pl-4">Movimientos</a>
                                </li>
                                <li class="nav-item w-100 mt-3">
                                    <a href="../inventario.php" class="nav-link text-light pl-4">Inventario</a>
                                </li>
                                
                                <li class="nav-item w-100 mt-3">
                                    <a href="../admin/reportes.php" class="nav-link text-light pl-4">Reportes</a>
                                </li>
                                <li class="nav-item w-100" style="margin-top: 80%;">
                                    <a href="../admin/index.php" class="nav-link text-light pl-4">Admin</a>
                                </li>
                            </ul>
                        </nav>  
                    </div>
                </div>
                <!-- -------------------------------------------------------------- Fin Menu -------------------------------------------------------------- -->
                
                <!-- -------------------------------------------------------------- Contenedor Principal -------------------------------------------------------------- -->
                <div class="col-10">
                    <nav class="navbar navbar-expand-lg mb-5">
                        <div class="container">
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <ul class="navbar-nav" style="position: absolute; left: 80%; top: 5%;">
                                        <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <?php echo $connectAdmin->nombre." ".$connectAdmin->apellido ?>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="../logout.php">Cerrar Sesión</a></li>
                                        </ul>
                                        </li>
                                    </ul>
                            </div>
                        </div>
                    </nav>
                    
                    <div class="col-8">
                        <form action="../assets/php/reportes.php" method="POST">
                            <div class="form row">
                                <div class="form-group col-md-6">
                                    <label for="start">Fecha Final:</label>
                                    <input type="date" class="form-control" name="fechaIni" placeholder="Fecha Inicial" id="start"> <br>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="end">Fecha Final:</label>
                                    <input type="date" class="form-control" name="fechaFin" placeholder="Fecha Final" id="end">
                                    <br>
                                </div>
                            </div>  
                            <div class="form-group">
                                <label for="selectUser">Selecciona el usuario</label>
                                <select name="select_usuario" id="selectUser" class="form-select form-select-lg mb-3">
                                <?php foreach($listaUsuarios as $usu): ?>
                                    <option value="<?php echo $usu->nombre_u ?>"><?php echo $usu->nombre_u ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>                          

                            <input type="submit" value="Descargar Reporte" name="btnDownload" class="btn btn-outline-info text-dark">
                            <a href="../assets/planillaReporteStock.xlsx" class="btn btn-outline-info text-dark">Descargar Planilla Base</a>
                        </form>
                    </div>
                        
                        <div class="logosCompany" style="position:absolute; bottom: 0px; right: 0px; opacity: 0.9;">
                            <img src="../assets/img/logos/logoceibal.png" alt="" width="150">
                            <img src="../assets/img/logos/logosonda.png" alt="" width="150">
                        </div>
                    </div>
                    </center>
                </div>
            </div>
    </div>



    <!-- All of JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
</body>
</html>