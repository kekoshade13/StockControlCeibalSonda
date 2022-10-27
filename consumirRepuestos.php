<?php 
include 'assets/php/userClass.php';
include 'assets/php/inventoryClass.php';
$usuario = userClass::obtenerDatosUnUsuario($_SESSION['uid']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consumir Repuestos</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet" />
</head>
<body>
    <div class="container-fluid">
            <div class="row">
                <!-- -------------------------------------------------------------- Menu -------------------------------------------------------------- -->
                <div class="col-2" style="padding-left: 0;">
                <?php
                    include 'assets/php/menu/menu.php';
                ?>
                </div>
                <!-- -------------------------------------------------------------- Fin Menu -------------------------------------------------------------- -->
                
                <!-- -------------------------------------------------------------- Contenedor Principal -------------------------------------------------------------- -->
                <div class="col-10">
                <div class="dropdown btn-group" style="position:relative; top: 100px; left: 50px;">
                    <a class="btn border-success dropdown-toggle btn-lg" href="#" id="resultadoConsumo" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        Seleccionar acción
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><button class="btn dropdown-item btn-lg" id="consumirRep" type="button" onclick="mostrarConsumirODevolver('consumirRep')">Consumir Repuestos</button></li>
                        <li><button class="btn dropdown-item btn-lg" id="devolverRep" type="button" onclick="mostrarConsumirODevolver('devolverRep')">Devolver Repuestos</button></li>
                    </ul>
                </div>

                
                    <div class="w-100 font-weight-bold" style="display: flex; height: 90%;justify-content: center; align-items: center; font-size: 23px;">
                        
                        <!-- -------------------------------------------------------------- Consumo Repuestos -------------------------------------------------------------- -->
                        
                        <div class="col-6 m-2" id="consumirRepuesto" style="display: inline-block;">
                            <form id="consumirForm">
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Usuario</label>
                                    <div class="col-sm-10 mb-4">
                                    <input type="text" readonly class="form-control-plaintext" name="nombre" id="staticName" value="<?php echo $usuario->nombre_u; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                     <label for="inputRepuesto" class="col-sm-2 col-form-label">Repuesto</label>
                                    <div class="col-sm-10 mb-5">
                                    <input type="text" class="form-control" id="inputRepuesto" name="code" placeholder="Código del repuesto">
                                    </div>
                                </div>
                                <input type="button" class="btn btn-success consumRep w-100" value="Consumir Repuesto" />
                            </form>
                        </div>

                        <!-- -------------------------------------------------------------- Fin Consumo Repuestos -------------------------------------------------------------- -->
                        
                        <!-- -------------------------------------------------------------- Devolución Repuestos -------------------------------------------------------------- -->
                        
                        <div class="col-6 m-2" id="devolverRepuesto" style="display: none;">
                            <form id="consumirForm">
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Usuario</label>
                                    <div class="col-sm-10 mb-4">
                                    <input type="text" readonly class="form-control-plaintext" name="nombre" id="staticName1" value="<?php echo $usuario->nombre_u; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                     <label for="inputRepuesto" class="col-sm-2 col-form-label">Repuesto</label>
                                    <div class="col-sm-10 mb-5">
                                    <input type="text" class="form-control" id="inputRepuesto1" name="code" placeholder="Código del repuesto">
                                    </div>
                                </div>
                                <input type="button" id="consumRep" class="btn btn-danger consumRep w-100" value="Devolver Repuesto" />
                            </form>
                        </div>

                        <!-- -------------------------------------------------------------- Fin Devolución Repuestos -------------------------------------------------------------- -->
                        
                        <div class="logosCompany" style="position:absolute; bottom: 0px; right: 0px; opacity: 0.9;">
                            <img src="assets/img/logos/logoceibal.png" alt="" width="150">
                            <img src="assets/img/logos/logosonda.png" alt="" width="150">
                        </div>
                    </div>
                </div>
            </div>
    </div>



    <!-- All of JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script>

        function mostrarConsumirODevolver(valOM) {
                var resultadoConsumo = document.getElementById('resultadoConsumo');
                if(valOM == 'devolverRep') {
                    document.getElementById('devolverRepuesto').style.display = "inline-block";
                    document.getElementById('devolverRepuesto').style.display = "inline-block";
                    document.getElementById('consumirRepuesto').style.display = "none";
                    resultadoConsumo.classList.remove('border-success');
                    resultadoConsumo.classList.add('border-danger');
                    document.getElementById('resultadoConsumo').innerHTML = "Devolver Repuestos";
                } else if(valOM == 'consumirRep') {
                    document.getElementById('consumirRepuesto').style.display = "inline-block";
                    document.getElementById('consumirRepuesto').style.display = "inline-block";
                    document.getElementById('devolverRepuesto').style.display = "none";
                    resultadoConsumo.classList.remove('border-danger');
                    resultadoConsumo.classList.add('border-success');
                    document.getElementById('resultadoConsumo').innerHTML = "Consumir Repuestos";
                }
            }
    </script>
</body>
</html>