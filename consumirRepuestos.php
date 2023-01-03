<?php 
include 'assets/php/userClass.php';
include 'assets/php/inventoryClass.php';
if($_SESSION['sesion_exito'] != 1) {
    header('Location: login.php');
} else {
    $dataUser = userClass::obtenerDatosUnUsuario($_SESSION['uid']);
    $obtenerTipoStock = inventoryClass::obtenerTiposStock();
}

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
    <script src="assets/js/jquery-3.6.1.min.js"></script>
    <link rel="shortcut icon" href="assets/img/logos/logoprin.png">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        $(document).keyup(function(event) {
            if (event.which === 13) {
                var tipoOperacion = document.getElementById("resultadoConsumo");
                if(tipoOperacion.innerHTML == "Consumir Repuestos") {
                    $('.consumRep').click();
                } else if(tipoOperacion.innerHTML == "Devolver Repuestos") {
                    $('.consumRep').click();
                }
            }
        });
    </script>
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
                <?php
                include 'assets/php/menu/menu2.php';
                ?>
            <div class="dropdown btn-group" style="position:relative; top: 30px; left: 50px;">
                <a class="btn border-success dropdown-toggle btn-lg" href="#" id="resultadoConsumo" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    Seleccionar acción
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li><button class="btn dropdown-item btn-lg" id="consumirRep" type="button" onclick="mostrarConsumirODevolver('consumirRep')">Consumir Repuestos</button></li>
                    <li><button class="btn dropdown-item btn-lg" id="devolverRep" type="button" onclick="mostrarConsumirODevolver('devolverRep')">Devolver Repuestos</button></li>
                </ul>
            </div>

                
            <div class="w-100 font-weight-bold" style="display: flex; height: 75%;justify-content: center; align-items: center; font-size: 23px;">
                        
                        <!-- -------------------------------------------------------------- Consumo Repuestos -------------------------------------------------------------- -->
                        
                <div class="col-7 m-2 d-none" id="consumirRepuesto" style="display: inline-block;">
                    <form id="consumirForm">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Usuario</label>
                            <div class="col-sm-10 mb-4">
                                <input type="text"  style="margin-left: 15px;" readonly class="form-control-plaintext" name="nombre" id="staticName" value="<?php echo $dataUser->nombre_u; ?>">
                            </div>
                        </div>
                            
                        <div class="form-group row mb-3">
                            <div class="col-sm-5 row">
                                <div class="col-sm-6">
                                    <label for="nEscuela">Escuela:</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" style="" class="form-control nEscuela" name="nEscuela" id="nEscuela" pattern="[0,9]" placeholder="Escuela">
                                </div>
                            </div>
                            
                            <div class="col-sm-7 row mb-3">
                                <div class="col-sm-2">
                                    <label for="nSerie">Serie:</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control nSerie" style="margin-left: 37px;" name="nSerie" id="nSerie" pattern="[0,9]" placeholder="Ingresa la serie del equipo">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="form-group row mb-3 col-5">
                                <label for="inputRepuesto" class="col-sm-6 col-form-label mr-5">Repuesto:</label>
                                <div class="col-sm-6 mb-3">
                                    <input type="text" style="margin-top: 3px;" class="form-control codeConsum" id="inputRepuesto" name="code" placeholder="Código" pattern="[0,9]">
                                </div>
                            </div>

                            <div class="form-group row mb-3 col-7">
                                <label for="selectTipoStock" class="col-sm-6 col-form-label">Tipo de Stock:</label>
                                <div class="col-sm-6 mb-3">
                                    <select class="form-select" id="selectTipoStock"  style="margin-top: 3px;">
                                        <option value="" selected disabled>Stock</option>
                                        <?php foreach($obtenerTipoStock as $tipoStock) { ?>
                                            <option value="<?php echo $tipoStock->id_stock ?>"><?php echo $tipoStock->nameTipoStock ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-sm-5 row">
                                <div class="form-check" style="margin-top: 5px;margin-left: 12px;">
                                    <input class="form-check-input" type="checkbox" value="" id="checkFlasheoAj">
                                    <label class="form-check-label" for="checkFlasheoAj">
                                        Flasheo/Ajuste
                                    </label>
                                </div>
                            </div>

                            <div class="col-sm-7 row">
                                <div class="col-sm-6">
                                    <label for="selectStockSalida" class="col-form-label">Stock Salida:</label>
                                </div>
                                <div class="col-sm-6">
                                    <select class="form-select" id="selectStockSalida"  style="margin-top: 3px;">
                                        <option value="" selected disabled>Salida Stock</option>
                                        <option value="1">Verificar</option>
                                        <option value="2">Destruir</option>
                                        <option value="3">Sano</option>
                                    </select>
                                </div>
                                
                            </div>
                        </div>
                        <input type="button" class="btn btn-success consumRep w-100" id="buttonOper" value="Consumir Repuesto"/>
                    </form>
                    <div class="alert alert-success text-center m-3 d-none" id="messageRep" role="alert"></div>
                </div>

                        <!-- -------------------------------------------------------------- Fin Consumo Repuestos -------------------------------------------------------------- -->
                        
                <div class="logosCompany" style="position:absolute; bottom: 0px; right: 0px; opacity: 0.9;">
                    <img src="assets/img/logos/logoceibal.png" alt="" width="150">
                    <img src="assets/img/logos/logosonda.png" alt="" width="150">
                </div>
            </div>
        </div>
    </div>



    <!-- All of JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script>
        jQuery(document).ready(function(){
            // Listen for the input event.
            jQuery("#inputRepuesto").on('input', function (evt) {
                // Allow only numbers.
                jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
            });
        });
        jQuery(document).ready(function(){
            // Listen for the input event.
            jQuery(".nEscuela").on('input', function (evt) {
                // Allow only numbers.
                jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
            });
        });
        var messageRep = document.getElementById('messageRep');
        $(document).ready(function() {
            toastr.options = {
				'closeButton': true,
				'debug': false,
				'newestOnTop': true,
				'progressBar': false,
				'positionClass': 'toast-top-right',
				'preventDuplicates': false,
				'showDuration': '500',
				'hideDuration': '1000',
				'timeOut': '5000',
				'extendedTimeOut': '1000',
				'showEasing': 'swing',
				'hideEasing': 'linear',
				'showMethod': 'fadeIn',
				'hideMethod': 'fadeOut',
			}
        });
        $(document).on('click', '.consumRep', function(e) {
            var tipoOperacion = document.getElementById("resultadoConsumo");
            var codigo = document.getElementById("inputRepuesto").value;
            var nombre = document.getElementById("staticName").value;
            var tipoStock = document.getElementById('selectTipoStock').value;

            if(tipoOperacion.innerHTML == "Consumir Repuestos") {
                messageRep.classList.add('d-none');
                if(codigo != "") {
                    if(codigo.length < 6 || codigo.length > 6) {
                        toastr.error('Debes ingresar un repuesto de 6 digitos.','Error');
                        document.getElementById('inputRepuesto').value = "";
                    } else {
                        if(tipoStock != "") {
                            $.ajax({
                                url: "assets/php/inventoryClass.php",
                                data: {name: nombre, code: codigo, tipoEstado: tipoStock, funcion: "consumirRepuestos"},
                                type: "post",
                                dataType: "json",
                                success: function(e) {
                                    var message = JSON.parse(e);
                                    if(message == 1) {
                                        toastr.success("Se ha consumido el repuesto: " + codigo + " correctamente.",'Repuesto Consumido.');
                                        document.getElementById('inputRepuesto').value = "";
                                    } else if(message == 2) {
                                        toastr.warning("No contamos con stock del repuesto: " + codigo + ".",'Falta de Stock.');
                                        document.getElementById('inputRepuesto').value = "";
                                    } else if(message == 3) {
                                        toastr.error("El repuesto: " + codigo + " no existe en ese estado. Intenta nuevamente.",'Código Inexistente..');
                                        document.getElementById('inputRepuesto').value = "";
                                    } else if(message == 4) {
                                        toastr.error("El repuesto: " + codigo + " no existe. Intenta nuevamente.",'Código Inexistente..');
                                        document.getElementById('inputRepuesto').value = "";
                                    }
                                }
                            });   
                        } else {
                            toastr.error('Debes seleccionar un tipo de stock.','Error');
                            document.getElementById('inputRepuesto').value = "";
                        }
                    }
                } else {
                    toastr.error('Debes ingresar un código correcto.','Error');
                    document.getElementById('inputRepuesto').value = "";
                }
            } else if(tipoOperacion.innerHTML == "Devolver Repuestos") {
                var codigo = document.getElementById("inputRepuesto").value;
                var nombre = document.getElementById("staticName").value;
                var tipoStock = document.getElementById('selectTipoStock').value;

                if(codigo != "") {
                    if(codigo.length < 6 || codigo.length > 6) {
                        toastr.error('Debes ingresar un repuesto de 6 digitos.','Error');
                        document.getElementById('inputRepuesto').value = "";
                    } else {
                        if(tipoStock != "") {
                            $.ajax({
                                url: "assets/php/inventoryClass.php",
                                data: {name: nombre, code: codigo, tipoEstado: tipoStock, funcion: "devolverRepuestos"},
                                type: "POST",
                                dataType: "JSON",
                                success: function(e) {
                                    var message = JSON.parse(e);
                                    if(message == 1) {
                                        toastr.success("Se ha devuelto el repuesto: " + codigo + " correctamente.",'Repuesto Devuelto.');
                                        document.getElementById('inputRepuesto').value = "";
                                    } else if(message == 3){
                                        toastr.warning("El código: " + codigo + " no existe en ese estado. ¡Intenta Nuevamente!");
                                        document.getElementById('inputRepuesto').value = "";
                                    } else if(message == 4) {
                                        toastr.warning("El código: " + codigo + " no existe. ¡Intenta Nuevamente!");
                                        document.getElementById('inputRepuesto').value = "";
                                    } else {
                                        toastr.error("Ha ocurrido un error.");
                                        document.getElementById('inputRepuesto').value = "";
                                    }
                                }
                            });
                        } else {
                            toastr.error('Debes seleccionar un tipo de stock.','Error');
                            document.getElementById('inputRepuesto').value = "";
                        }
                    }
                    
                } else {
                    toastr.error('Debes ingresar un código correcto.','Error');
                        document.getElementById('inputRepuesto').value = "";
                }
            }
        }); 

        function mostrarConsumirODevolver(valOM) {
                var resultadoConsumo = document.getElementById('resultadoConsumo');
                var tipoBoton = document.getElementById('buttonOper');
                var consumo = document.getElementById('consumirRepuesto');
                if(valOM == 'devolverRep') {
                    messageRep.classList.add('d-none');
                    consumo.classList.remove('d-none');
                    document.getElementById('inputRepuesto').placeholder = "Código";
                    resultadoConsumo.classList.remove('border-success');
                    resultadoConsumo.classList.add('border-danger');
                    tipoBoton.classList.remove('btn-success');
                    tipoBoton.classList.add('btn-danger');
                    tipoBoton.value = "Devolver repuesto";
                    document.getElementById('resultadoConsumo').innerHTML = "Devolver Repuestos";
                } else if(valOM == 'consumirRep') {
                    messageRep.classList.add('d-none');
                    consumo.classList.remove('d-none');
                    document.getElementById('inputRepuesto').placeholder = "Código";
                    resultadoConsumo.classList.remove('border-danger');
                    resultadoConsumo.classList.add('border-success');
                    tipoBoton.classList.remove('btn-danger');
                    tipoBoton.classList.add('btn-success');
                    tipoBoton.value = "Consumir Repuesto";
                    document.getElementById('resultadoConsumo').innerHTML = "Consumir Repuestos";
                }
            }
    </script>
</body>
</html>