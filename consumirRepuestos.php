<?php 
include 'assets/php/userClass.php';
if($_SESSION['sesion_exito'] != 1) {
    header('Location: login.php');
} else {
    $dataUser = userClass::obtenerDatosUnUsuario($_SESSION['uid']);
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
                        
                        <div class="col-6 m-2 d-none" id="consumirRepuesto" style="display: inline-block;">
                            <form id="consumirForm">
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Usuario</label>
                                    <div class="col-sm-10 mb-4">
                                    <input type="text" readonly class="form-control-plaintext" name="nombre" id="staticName" value="<?php echo $dataUser->nombre_u; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                     <label for="inputRepuesto" class="col-sm-2 col-form-label">Repuesto</label>
                                    <div class="col-sm-10 mb-5">
                                    <input type="text" class="form-control" id="inputRepuesto" name="code" placeholder="Código del repuesto" pattern="[0,9]">
                                    </div>
                                </div>
                                <input type="button" class="btn btn-success consumRep w-100" id="buttonOper" value="Consumir Repuesto" />
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
    </div>



    <!-- All of JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script>
        var messageRep = document.getElementById('messageRep');

        $(document).on('click', '.consumRep', function(e) {
            var tipoOperacion = document.getElementById("resultadoConsumo");
            var codigo = document.getElementById("inputRepuesto").value;
            var nombre = document.getElementById("staticName").value;

            if(tipoOperacion.innerHTML == "Consumir Repuestos") {
                messageRep.classList.add('d-none');
                if(codigo != "") {
                    if(codigo.length < 6 || codigo.length > 6) {
                        messageRep.classList.remove('d-none');
                        messageRep.classList.remove('alert-success');
                        messageRep.classList.add('alert-danger');
                        messageRep.innerHTML = "Debes ingresar un repuesto con 6 digitos.";
                        document.getElementById('inputRepuesto').value = "";
                    } else {
                        $.ajax({
                            url: "assets/php/inventoryClass.php",
                            data: {name: nombre, code: codigo, funcion: "consumirRepuestos"},
                            type: "post",
                            dataType: "json",
                            success: function(e) {
                                var message = JSON.parse(e);
                                if(message == 1) {
                                    messageRep.classList.remove('d-none');
                                    messageRep.classList.remove('alert-danger');
                                    messageRep.classList.add('alert-success');
                                    messageRep.innerHTML = "Se ha consumido el repuesto: " + codigo + " correctamente.";
                                    document.getElementById('inputRepuesto').value = "";
                                } else if(message == 2) {
                                    messageRep.classList.remove('d-none');
                                    messageRep.classList.remove('alert-success');
                                    messageRep.classList.add('alert-danger');
                                    messageRep.innerHTML = "No contamos con stock del repuesto: " + codigo + ". Por favor, ¡Contacta a un administrador!";
                                    document.getElementById('inputRepuesto').value = "";
                                } else if(message == 3) {
                                    messageRep.classList.remove('d-none');
                                    messageRep.classList.remove('alert-success');
                                    messageRep.classList.add('alert-danger');
                                    messageRep.innerHTML = "¡El código que estas ingresando no existe!";
                                    document.getElementById('inputRepuesto').value = "";
                                }
                            }
                        });
                    }
                } else {
                    alert("Debes ingresar un código correcto.");
                }
            } else if(tipoOperacion.innerHTML == "Devolver Repuestos") {
                var codigo = document.getElementById("inputRepuesto").value;
                var nombre = document.getElementById("staticName").value;
                if(codigo != "") {
                    if(codigo.length < 6 || codigo.length > 6) {
                        messageRep.classList.remove('d-none');
                        messageRep.classList.remove('alert-success');
                        messageRep.classList.add('alert-danger');
                        messageRep.innerHTML = "Debes ingresar un repuesto con 6 digitos.";
                        document.getElementById('inputRepuesto').value = "";
                    } else {
                        $.ajax({
                            url: "assets/php/inventoryClass.php",
                            data: {name: nombre, code: codigo, funcion: "devolverRepuestos"},
                            type: "POST",
                            dataType: "JSON",
                            success: function(e) {
                                var message = JSON.parse(e);
                                if(message == 1) {
                                    messageRep.classList.remove('d-none');
                                    messageRep.classList.remove('alert-success');
                                    messageRep.classList.add('alert-danger');
                                    messageRep.innerHTML = "Se ha devuelto el repuesto: " + codigo + " correctamente.";
                                    document.getElementById('inputRepuesto').value = "";
                                } else if(message == 3){
                                    messageRep.classList.remove('d-none');
                                    messageRep.classList.remove('alert-success');
                                    messageRep.classList.add('alert-danger');
                                    messageRep.innerHTML = "¡El código que estas ingresando no existe!";
                                } else {
                                    messageRep.classList.remove('d-none');
                                    messageRep.classList.remove('alert-success');
                                    messageRep.classList.add('alert-danger');
                                    messageRep.innerHTML = "¡Ha ocurrido un error!";
                                }
                            }
                        });
                    }
                    
                } else {
                    alert("Debes ingresar un código correcto.");
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
                    document.getElementById('inputRepuesto').placeholder = "Codigo del repuesto a devolver";
                    resultadoConsumo.classList.remove('border-success');
                    resultadoConsumo.classList.add('border-danger');
                    tipoBoton.classList.remove('btn-success');
                    tipoBoton.classList.add('btn-danger');
                    tipoBoton.value = "Devolver repuesto";
                    document.getElementById('resultadoConsumo').innerHTML = "Devolver Repuestos";
                } else if(valOM == 'consumirRep') {
                    messageRep.classList.add('d-none');
                    consumo.classList.remove('d-none');
                    document.getElementById('inputRepuesto').placeholder = "Codigo del repuesto";
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