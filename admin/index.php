<?php
include '../assets/php/userClass.php';
include '../assets/php/inventoryClass.php';
$admin = $_SESSION['uid'];
$connectAdmin =  userClass::obtenerDatosUnUsuario($admin);
if(!$connectAdmin->class == "Admin") {
    header("Location:../index.php");
} else {
    $listaUsuarios = userClass::obtenerUsuarios();
    $obtenerEquipos = inventoryClass::obtenerEquipos();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de administracion</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet" />
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
                                <li class="nav-item w-100 mt-3">
                                    <a href="movimientos.php" class="nav-link text-light pl-4">Movimientos Generales</a>
                                </li>
                                <li class="nav-item w-100 mt-3">
                                    <a href="../inventario.php" class="nav-link text-light pl-4">Inventario</a>
                                </li>
                                
                                <li class="nav-item w-100 mt-3">
                                    <a href="../admin/reportes.php" class="nav-link text-light pl-4">Reportes</a>
                                </li>
                                <li class="nav-item w-100" style="margin-top: 100%;">
                                    <a href="../index.php" class="nav-link text-light pl-4">Volver</a>
                                </li>
                            </ul>
                        </nav>  
                    </div>
                </div>
                <!-- -------------------------------------------------------------- Fin Menu -------------------------------------------------------------- -->
                
                <!-- -------------------------------------------------------------- Contenedor Principal -------------------------------------------------------------- -->
                <div class="col-10">
                
                <nav class="navbar navbar-expand-lg mb-4">
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
                <div class="listaTareas col-8">
                    <!-- Gestiones -->
                    <div class="dropdown btn-group col-6" id="admGest0" style="position:relative; left: 50px;">
                        <a class="btn border-success dropdown-toggle btn-lg" href="#" id="resultGestionP" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            Seleccionar acción
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><button class="btn dropdown-item btn-lg" id="gestionUsuarios" type="button" onclick="admGestiones('gestUsu')">Gestion Usuarios</button></li>
                            <li><button class="btn dropdown-item btn-lg" id="gestionRepuestos" type="button" onclick="admGestiones('gestRepu')">Gestion Repuestos</button></li>
                        </ul>
                    </div>
                    
                    <!-- Tareas Especificas -->

                    <!-- Tarea: Gestion Repuestos -->
                    <div class="dropdown btn-group d-none col-6" id="admGest1" style="position:relative; top: 5px; left: 50px;">
                        <a class="btn border-success dropdown-toggle btn-lg" id="resultadoGestionR" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            Seleccionar acción
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><button class="btn dropdown-item btn-lg" id="addStock" type="button" onclick="admGestiones('gestRepu', 'addStock')">Aumentar Stock</button></li>
                            <li><button class="btn dropdown-item btn-lg" id="deleteStock" type="button" onclick="admGestiones('gestRepu', 'deleteStock')">Reducir Stock</button></li>
                            <li><button class="btn dropdown-item btn-lg" id="addNewRepuest" type="button" onclick="admGestiones('gestRepu', 'addNewRepuest')">Añadir Nuevo Repuesto</button></li>
                        </ul>
                    </div>
                    <!-- Tarea: Gestion Usuarios -->
                    <div class="dropdown btn-group d-none col-6" id="admGest2" style="position:relative; top: 5px; left: 50px;">
                        <a class="btn border-success dropdown-toggle btn-lg" href="#" id="resultadoGestionU" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            Seleccionar acción
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><button class="btn dropdown-item btn-lg" id="addUser" type="button" onclick="admGestiones('gestUsu', 'addUser')">Añadir Usuarios</button></li>
                            <li><button class="btn dropdown-item btn-lg" id="deleteUser" type="button" onclick="admGestiones('gestUsu', 'mostrarUser')">Lista de Usuarios</button></li>
                        </ul>
                    </div>
                </div>

                
                    <div class="w-100 font-weight-bold" style="height: 70%; justify-content: center; align-items: center; font-size: 23px;">
                        
                        <!-- -------------------------------------------------------------- Gestion Usuarios -------------------------------------------------------------- -->
                        <center>
                        <div class="col-8 m-2 d-none" id="anadirUsuario" style="display: inline-block;">
                            <form>
                                <div class="form-group row">
                                    <h5 class="display-5 mb-5">Registro de Usuarios</h1>
                                    <div class="col-sm-6 mb-4">
                                        <input type="text" class="form-control" name="nombre" id="inputNombre" placeholder="Ingresa el nombre">
                                    </div>

                                    <div class="col-sm-6 mb-4">
                                        <input type="text" class="form-control" id="inputApellido" name="apellido" placeholder="Ingresa el apellido">
                                    </div>

                                    <div class="col-sm-6 mb-4">
                                        <input type="text" class="form-control" id="inputUsuario" name="nombre_u" placeholder="Ingresa el nombre de usuario">
                                    </div>

                                    <div class="col-sm-6">
                                    <input type="password" class="form-control" id="inputContrasenia" name="contrasenia" placeholder="Ingresa la contraseña">
                                    </div>
                                    
                                    <div class="col-sm-6 mb-2">
                                        <input type="text" class="form-control val" id="inputCedula" name="cedula" placeholder="Ingresa la cedula">
                                        <small id="cedulaInfo" class="form-text text-muted" style="font-size: 18px;">Ingresa la cedula sin punto ni guión.</small>
                                    </div>

                                    <div class="col-sm-6 mb-2">
                                        <select class="form-select" id="selectGenero">
                                            <option value="" selected disabled>Selecciona el genero.</option>
                                            <option value="F">Femenino</option>
                                            <option value="M">Masculino</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-6 mb-2">
                                        <input type="file" class="form-control" id="inputImageProfile" />
                                    </div>

                                    <div class="form-check col-sm-6">
                                        <input class="form-check-input" type="checkbox" value="" id="isAdmin">
                                        <label class="form-check-label" for="isAdmin">
                                            Administrador
                                        </label>
                                    </div>
                                </div>
                                <input type="button" class="btn btn-success btnAddUser w-100" value="Añadir Usuario" />
                            </form>
                        </div>

                        <div class="col-8 m-2 d-none" id="mostrarUser" style="display: inline-block; height: 400px; overflow-y: scroll;">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Apellido</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Tipo Usuario</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach($listaUsuarios as $lista) {

                                    ?>
                                <tr>
                                    <th scope="row"><?php echo $lista->nombre; ?></th>
                                    <th><?php echo $lista->apellido; ?></th>
                                    <th><?php echo $lista->nombre_u; ?></th>
                                    <th><?php echo $lista->class; ?></th>
                                    <th><button class="btn btn-danger eliminarUser" onclick="eliminarUsuario('<?php echo $lista->id_user; ?>')">Eliminar</button></th>
                                </tr>
                                    <?php

                                }
                                ?>
                                
                            </tbody>                
                        </table>  
                        </div>

                        <!-- -------------------------------------------------------------- Fin Gestion Usuarios -------------------------------------------------------------- -->

                        <!-- -------------------------------------------------------------- Gestion Repuestos -------------------------------------------------------------- -->

                        <div class="col-8 m-2 d-none" id="anadirStock" style="display: inline-block;">
                            <form>
                                <div class="form-group row">
                                    <h5 class="display-5 mb-5">Añadir Stock</h1>
                                    
                                    <label for="inputAddCodigo" class="form-label col-sm-3">Código</label>
                                    <div class="col-sm-8 mb-4">
                                        <input type="text" class="form-control btnCodeAumentar" name="codeAddStock" id="inputAddCodigo" placeholder="Ingresa el código">
                                        <small id="codeInfo" class="form-text text-muted" style="font-size: 18px;">Solo se aceptan valores numéricos.</small>
                                    </div>

                                    <label for="inputAddCantidad" class="form-label col-sm-3">Cantidad</label>
                                    <div class="col-sm-8 mb-4">
                                        <input type="text" class="form-control btnQtyAumentar" id="inputAddCantidad" name="qtyAddStock" placeholder="Ingresa la cantidad a ingresar">
                                        <small id="cantidadInfo" class="form-text text-muted" style="font-size: 18px;">Solo se aceptan valores numéricos.</small>
                                    </div>
                                    <label for="tipoStock" class="form-label col-sm-3">Tipo de Stock</label>
                                    <div class="col-sm-8 mb-4" id="tipoStock">
                                        <select class="form-select" id="selectTipoStock">
                                            <option selected value="">Tipo de stock</option>
                                            <option value="1">Origen</option>
                                            <option value="2">Sano</option>
                                            <option value="3">Remanufacturados</option>
                                            <option value="4">Free</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="button" class="btn btn-success btnAumentarStock w-100 mb-2" id="buttonOper" value="Añadir Stock" />
                            </form>
                        </div>

                        <div class="col-8 m-2 d-none" id="reducirStock" style="display: inline-block;">
                            <form>
                                <div class="form-group row">
                                    <h5 class="display-5 mb-5">Reducir Stock</h1>
                                    
                                    <label for="inputRemoveCodigo" class="form-label col-sm-3">Código</label>
                                    <div class="col-sm-8 mb-4">
                                        <input type="text" class="form-control codeDelete" name="codeRemoveStock" id="inputRemoveCodigo" placeholder="Ingresa el código">
                                        <small id="codeInfo" class="form-text text-muted" style="font-size: 18px;">Solo se aceptan valores numéricos.</small>
                                    </div>

                                    <label for="inputRemoveCantidad" class="form-label col-sm-3">Cantidad</label>
                                    <div class="col-sm-8 mb-4">
                                        <input type="text" class="form-control qtyDelete" id="inputRemoveCantidad" name="qtyRemoveStock" placeholder="Ingresa la cantidad a reducir">
                                        <small id="cantidadInfo" class="form-text text-muted" style="font-size: 18px;">Solo se aceptan valores numéricos.</small>
                                    </div>
                                    <label for="tipoStockDevo" class="form-label col-sm-3">Tipo de Stock</label>
                                    <div class="col-sm-8 mb-4" id="tipoStockDevo">
                                        <select class="form-select" id="selectTipoStockDevo">
                                            <option selected value="">Tipo de stock</option>
                                            <option value="1">Origen</option>
                                            <option value="2">Sano</option>
                                            <option value="3">Remanufacturados</option>
                                            <option value="4">Free</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="button" class="btn btn-danger btnReducirStock w-100 mb-2" value="Reducir Stock" />
                            </form>
                        </div>

                        <div class="col-8 m-2 d-none" id="addNewCode" style="display: inline-block;">
                            <form>
                                <div class="form-group row">
                                    <h5 class="display-5 mb-4">Añadir Nuevo Producto</h1>
                                    
                                    <label for="inputAddNewCodigo" class="form-label col-sm-3">Código: </label>
                                    <div class="col-sm-8 mb-3">
                                        <input type="text" class="form-control newCode" name="codeAddNew" id="inputAddNewCodigo" placeholder="Ingresa el código">
                                        <small id="codeInfo" class="form-text text-muted" style="font-size: 18px; text-align: left!important;">Solo se aceptan valores numéricos.</small>
                                    </div>

                                    <label for="inputNewNombre" class="form-label col-sm-3">Nombre del repuesto</label>
                                    <div class="col-sm-8 mb-1">
                                        <input type="text" class="form-control" id="inputNewNombre" name="qtyRemoveStock" placeholder="Ingresa el nombre del repuesto">
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-sm-4" style="margin-left: 192px;">
                                            <select name="select_equipo" id="seleccion_Equipo" class="form-select">
                                                <option selected value="">Selecciona el Equipo</option>
                                                <?php foreach($obtenerEquipos as $equipo): ?>
                                                <option value="<?php echo $equipo->id_equipo ?>"><?php echo $equipo->nameEquipos ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4 mb-3 selectpicker" id="selectRepComp">
                                            <select multiple name="select_equipoComp" id="seleccion_EquipoComp" class="form-select" data-live-search="true">
                                                <option selected value="">Equipo Compatible</option>
                                                <?php foreach($obtenerEquipos as $equipo): ?>
                                                <option value="<?php echo $equipo->id_equipo ?>"><?php echo $equipo->nameEquipos ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        
                                    </div>
                                </div>
                                <input type="button" class="btn btn-success w-100 mb-2 btnAddNewRepuest" value="Añadir Nuevo Repuesto" />
                            </form>
                        </div>
                        <div class="col-sm-7 alert alert-success text-center m-3 d-none" id="messageRep" role="alert"></div>

                        <!-- -------------------------------------------------------------- Fin Gestion Repuestos -------------------------------------------------------------- -->
                        
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

    <script>
        // Gestion Usuarios
        var formAddUser = document.getElementById('anadirUsuario');
        var formMostrarUser = document.getElementById('mostrarUser');
        // Gestion Repuestos 
        var formAddStock = document.getElementById('anadirStock');
        var formReducirStock = document.getElementById('reducirStock');
        var formAddNewProduct = document.getElementById('addNewCode');

        var responseMessage = document.getElementById('messageRep');
        
        function admGestiones(admGestP, admGestG) {
            var gestUsuarios = document.getElementById('admGest2');
            var gestRepuestos = document.getElementById('admGest1');
            if(admGestP == 'gestUsu') {
                responseMessage.classList.add('d-none');
                gestRepuestos.classList.add('d-none');
                gestUsuarios.classList.remove('d-none');

                formAddStock.classList.add('d-none');
                formReducirStock.classList.add('d-none');
                formAddNewProduct.classList.add('d-none');

                document.getElementById('resultGestionP').innerHTML = "Gestion Usuarios";

                admGestionUsuario(admGestG);
            } else if(admGestP == 'gestRepu') {
                responseMessage.classList.add('d-none');
                gestUsuarios.classList.add('d-none');
                gestRepuestos.classList.remove('d-none');

                formMostrarUser.classList.add('d-none');
                formAddUser.classList.add('d-none');

                document.getElementById('resultGestionP').innerHTML = "Gestion Repuestos";

                admGestionRepuestos(admGestG);
            }
        }

        function admGestionUsuario(admGestU) {
            if(admGestU == 'addUser') {
                responseMessage.classList.add('d-none');
                document.getElementById('resultadoGestionU').innerHTML = "Añadir Usuarios";
                formMostrarUser.classList.add('d-none');
                formAddUser.classList.remove('d-none');
                jQuery(document).ready(function(){
                    // Listen for the input event.
                    jQuery("#inputCedula").on('input', function (evt) {
                        // Allow only numbers.
                        jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
                    });
                });
                jQuery(document).ready(function(){
                    // Listen for the input event.
                    jQuery("#inputUsuario").on('input', function (evt) {
                        // Allow only numbers.
                        jQuery(this).val(jQuery(this).val().replace(/[^a-zA-Z]/g, ''));
                    });
                });
                jQuery(document).ready(function(){
                    // Listen for the input event.
                    jQuery("#inputNombre").on('input', function (evt) {
                        // Allow only numbers.
                        jQuery(this).val(jQuery(this).val().replace(/[^a-zA-Z]/g, ''));
                    });
                });
                jQuery(document).ready(function(){
                    // Listen for the input event.
                    jQuery("#inputApellido").on('input', function (evt) {
                        // Allow only numbers.
                        jQuery(this).val(jQuery(this).val().replace(/[^a-zA-Z]/g, ''));
                    });
                });

                $(document).on('click', '.btnAddUser', function(event) {
                    var nombre = document.getElementById('inputNombre').value;
                    var apellido = document.getElementById('inputApellido').value;
                    var nombreUser = document.getElementById('inputUsuario').value;
                    var contrasenia = document.getElementById('inputContrasenia').value;
                    var cedula = document.getElementById('inputCedula').value;
                    var genero = document.getElementById('selectGenero').value;
                    var isAdmin = "";

                    if($('#isAdmin').is(':checked')) {
                        isAdmin = "Admin";
                    }

                    if(nombre.trim() != "" && apellido.trim() != "" && nombreUser.trim() != "" && contrasenia.trim() != "" && cedula.trim() != "" && genero.trim() != "") {
                        if(cedula.length < 8 || cedula.length > 8) {
                            responseMessage.classList.remove('d-none');
                            responseMessage.classList.remove('alert-success');
                            responseMessage.classList.add('alert-danger');
                            responseMessage.innerHTML = "¡La cedula tiene que contener 8 digitos!.";
                        } else {
                            $.ajax({
                                url: "../assets/php/userClass.php",
                                data: {name: nombre, lastname: apellido, nombre_u: nombreUser, password: contrasenia, ci: cedula, class: isAdmin, gender: genero, funcion: "addUser"},
                                type: "POST",
                                dataType: "JSON",
                                success: function(e) {
                                    var message = JSON.parse(e);
                                    if(message == 1) {
                                        responseMessage.classList.remove('d-none');
                                        responseMessage.innerHTML = "Usuario ingresado correctamente.";
                                        window.location.reload(true);
                                    } else if(message == 0) {
                                        responseMessage.classList.remove('d-none');
                                        responseMessage.innerHTML = "El usuario ya se encuentra en uso.";
                                    } else if(message == 2) {
                                        responseMessage.classList.remove('d-none');
                                        responseMessage.innerHTML = "El Documento ("+cedula+") se encuentra en uso";
                                    }
                                }
                            });
                        }
                    } else {
                        responseMessage.classList.remove('d-none');
                        responseMessage.classList.remove('alert-success');
                        responseMessage.classList.add('alert-danger');
                        responseMessage.innerHTML = "¡Debes completar todos los campos!.";
                    }
                });
            } else if(admGestU == 'mostrarUser') {
                responseMessage.classList.add('d-none');
                document.getElementById('resultadoGestionU').innerHTML = "Lista de Usuarios";
                formAddUser.classList.add('d-none');
                formMostrarUser.classList.remove('d-none');
            }
        }

        function admGestionRepuestos(admGestR) {
            if(admGestR == 'addStock') {
                responseMessage.classList.add('d-none');
                document.getElementById('resultadoGestionR').innerHTML = "Aumentar Stock";

                formReducirStock.classList.add('d-none');
                formAddNewProduct.classList.add('d-none');
                formAddStock.classList.remove('d-none');

                jQuery(document).ready(function(){
                    // Listen for the input event.
                    jQuery(".btnQtyAumentar").on('input', function (evt) {
                        // Allow only numbers.
                        jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
                    });
                });
                jQuery(document).ready(function(){
                    // Listen for the input event.
                    jQuery(".btnCodeAumentar").on('input', function (evt) {
                        // Allow only numbers.
                        jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
                    });
                });

                $(document).on('click', '.btnAumentarStock', function(event) {
                    var aumentCode = document.getElementById('inputAddCodigo').value;
                    var aumentQty = document.getElementById('inputAddCantidad').value;
                    var tipoStock = document.getElementById('selectTipoStock').value;

                    if(aumentCode.trim() != "") {
                        if(aumentQty.trim() != "") {
                            if(aumentCode.length < 6 || aumentCode.length > 6) {
                                messageRep.classList.remove('d-none');
                                messageRep.classList.remove('alert-success');
                                messageRep.classList.add('alert-danger');
                                messageRep.innerHTML = "Debes ingresar un repuesto con 6 digitos.";

                                document.getElementById('inputAddCantidad').value = "";
                                document.getElementById('inputAddCodigo').value = "";
                            } else {
                                $.ajax({
                                    url: "../assets/php/inventoryClass.php",
                                    data: { codeAument: aumentCode, cantidad: aumentQty, tipoEstado: tipoStock, funcion: "aumentStock" },
                                    type: "POST",
                                    dataType: "JSON",
                                    success: function(e) {
                                        var message = JSON.parse(e);

                                        if(message == 1) {
                                            responseMessage.classList.add('d-none');
                                            responseMessage.classList.remove('d-none');

                                            responseMessage.innerHTML = "Se ha actualizado el stock.";

                                            document.getElementById('inputAddCantidad').value = "";
                                            document.getElementById('inputAddCodigo').value = "";
                                        } else {
                                            responseMessage.classList.add('d-none');
                                            responseMessage.classList.remove('d-none');

                                            responseMessage.innerHTML = "Ha ocurrido un error.";

                                            document.getElementById('inputAddCantidad').value = "";
                                            document.getElementById('inputAddCodigo').value = "";
                                        }
                                    },
                                    error: function(e) {
                                        alert("Error");
                                    }
                                });
                            }
                        } else {
                            messageRep.classList.remove('d-none');
                            messageRep.classList.remove('alert-success');
                            messageRep.classList.add('alert-danger');
                            messageRep.innerHTML = "Tienes que asignar una cantidad.";

                            document.getElementById('inputAddCantidad').value = "";
                            document.getElementById('inputAddCodigo').value = "";
                        }
                    } else {
                        messageRep.classList.remove('d-none');
                        messageRep.classList.remove('alert-success');
                        messageRep.classList.add('alert-danger');
                        messageRep.innerHTML = "No puedes dejar el valor del código vacio :(.";

                        document.getElementById('inputAddCantidad').value = "";
                        document.getElementById('inputAddCodigo').value = "";
                    }
                });
            } else if(admGestR == 'deleteStock') {
                responseMessage.classList.add('d-none');
                document.getElementById('resultadoGestionR').innerHTML = "Reducir Stock";

                formAddNewProduct.classList.add('d-none');
                formAddStock.classList.add('d-none');
                formReducirStock.classList.remove('d-none');
                jQuery(document).ready(function(){
                    // Listen for the input event.
                    jQuery(".qtyDelete").on('input', function (evt) {
                        // Allow only numbers.
                        jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
                    });
                });
                jQuery(document).ready(function(){
                    // Listen for the input event.
                    jQuery(".codeDelete").on('input', function (evt) {
                        // Allow only numbers.
                        jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
                    });
                });

                $(document).on('click', '.btnReducirStock', function(event) {
                    var codeDelete = document.getElementById('inputRemoveCodigo').value;
                    var qtyDelete = document.getElementById('inputRemoveCantidad').value;
                    var tipoStockDevo = document.getElementById('selectTipoStockDevo').value;

                    if(codeDelete.trim() != "") {
                        if(qtyDelete.trim() != "") {
                            if(codeDelete.length < 6 || codeDelete.length > 6) {
                                messageRep.classList.remove('d-none');
                                messageRep.classList.remove('alert-success');
                                messageRep.classList.add('alert-danger');
                                messageRep.innerHTML = "Debes ingresar un repuesto con 6 digitos.";

                                document.getElementById('inputRemoveCodigo').value = "";
                                document.getElementById('inputRemoveCantidad').value = "";
                            } else {
                                if(tipoStockDevo != "") {
                                    $.ajax({
                                        url: "../assets/php/inventoryClass.php",
                                        data: { deleteCode: codeDelete, cantDelete: qtyDelete, tipoStock: tipoStockDevo, funcion: "reduceStock" },
                                        type: "POST",
                                        dataType: "JSON",
                                        success: function(e) {
                                            var message = JSON.parse(e);
                                            if(message == 1) {
                                                responseMessage.classList.add('d-none');
                                                responseMessage.classList.remove('d-none');

                                                responseMessage.innerHTML = "Se ha actualizado el stock.";

                                                document.getElementById('inputRemoveCodigo').value = "";
                                                document.getElementById('inputRemoveCantidad').value = "";
                                            } else if(e == 2) {
                                                responseMessage.classList.add('d-none');
                                                responseMessage.classList.remove('d-none');
                                                messageRep.classList.add('alert-danger');
                                                
                                                responseMessage.innerHTML = "El stock no cuenta con la cantidad que deseas reducir.";
                                                
                                                document.getElementById('inputRemoveCodigo').value = "";
                                                document.getElementById('inputRemoveCantidad').value = "";
                                            } else {
                                                responseMessage.classList.add('d-none');
                                                responseMessage.classList.remove('d-none');
                                                messageRep.classList.add('alert-danger');

                                                responseMessage.innerHTML = "Ha ocurrido un error.";
                                                
                                                document.getElementById('inputRemoveCodigo').value = "";
                                                document.getElementById('inputRemoveCantidad').value = "";
                                            }
                                        }
                                    });
                                } else {
                                    messageRep.classList.remove('d-none');
                                    messageRep.classList.remove('alert-success');
                                    messageRep.classList.add('alert-danger');
                                    messageRep.innerHTML = "Tienes que asignar el tipo de stock.";
                                    
                                    document.getElementById('inputRemoveCodigo').value = "";
                                    document.getElementById('inputRemoveCantidad').value = "";
                                }
                                
                            }
                        } else {
                            messageRep.classList.remove('d-none');
                            messageRep.classList.remove('alert-success');
                            messageRep.classList.add('alert-danger');
                            messageRep.innerHTML = "Tienes que asignar una cantidad.";
                            
                            document.getElementById('inputRemoveCodigo').value = "";
                            document.getElementById('inputRemoveCantidad').value = "";
                        }
                    } else {
                        messageRep.classList.remove('d-none');
                        messageRep.classList.remove('alert-success');
                        messageRep.classList.add('alert-danger');
                        messageRep.innerHTML = "No puedes dejar el valor del código vacio :(.";

                        document.getElementById('inputRemoveCodigo').value = "";
                        document.getElementById('inputRemoveCantidad').value = "";
                    }
                });
            } else if(admGestR == 'addNewRepuest') {
                responseMessage.classList.add('d-none');
                document.getElementById('resultadoGestionR').innerHTML = "Añadir Nuevo Repuesto";
                
                formReducirStock.classList.add('d-none');
                formAddStock.classList.add('d-none');
                formAddNewProduct.classList.remove('d-none');
                jQuery(document).ready(function(){
                    // Listen for the input event.
                    jQuery(".newCode").on('input', function (evt) {
                        // Allow only numbers.
                        jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
                    });
                });
                $(document).on('click', '.btnAddNewRepuest', function(event) {
                    var newCodigo = document.getElementById('inputAddNewCodigo').value;
                    var newNameRepuest = document.getElementById('inputNewNombre').value;
                    var newRepEquipos = document.getElementById('seleccion_Equipo').value;
                    var eqCompatible = document.getElementById('seleccion_EquipoComp').value;

                    if(newCodigo.trim() != "") {
                        if(newNameRepuest.trim() != "") {
                            if(newCodigo.length < 6 || newCodigo.length > 6) {
                                messageRep.classList.remove('d-none');
                                messageRep.classList.remove('alert-success');
                                messageRep.classList.add('alert-danger');
                                messageRep.innerHTML = "Debes ingresar un repuesto con 6 digitos.";

                                document.getElementById('inputAddNewCodigo').value = "";
                                document.getElementById('inputNewNombre').value = "";
                                } else {
                                    if(newRepEquipos != "") {
                                        $.ajax({
                                            url: "../assets/php/inventoryClass.php",
                                            data: {newCode: newCodigo, newNombre: newNameRepuest, newRepEquipo: newRepEquipos, eqComp: eqCompatible, funcion: "addNewRepuest"},
                                            type: "POST",
                                            dataType: "JSON",
                                            success: function(e) {
                                                var message = JSON.parse(e);
                                                if(message == 1) {
                                                    responseMessage.classList.add('d-none');
                                                    responseMessage.classList.remove('d-none');

                                                    responseMessage.innerHTML = "Repuesto ingresado correctamente.";
                                                    
                                                    document.getElementById('inputAddNewCodigo').value = "";
                                                    document.getElementById('inputNewNombre').value = "";
                                                } else {
                                                    responseMessage.classList.add('d-none');
                                                    responseMessage.classList.remove('d-none');

                                                    responseMessage.innerHTML = "Ha ocurrido un error.";

                                                    document.getElementById('inputAddNewCodigo').value = "";
                                                    document.getElementById('inputNewNombre').value = "";
                                                }
                                            },
                                            error: function(e) {
                                                alert(e);
                                            }
                                        });
                                    } else {
                                        messageRep.classList.remove('d-none');
                                        messageRep.classList.remove('alert-success');
                                        messageRep.classList.add('alert-danger');
                                        messageRep.innerHTML = "Tienes que asignarle un equipo al repuesto.";
                                    }
                                }
                        } else {
                            messageRep.classList.remove('d-none');
                            messageRep.classList.remove('alert-success');
                            messageRep.classList.add('alert-danger');
                            messageRep.innerHTML = "No puedes dejar el valor del nombre vacio :(.";
                        
                            document.getElementById('inputAddNewCodigo').value = "";
                            document.getElementById('inputNewNombre').value = "";
                        }
                    } else {
                        messageRep.classList.remove('d-none');
                        messageRep.classList.remove('alert-success');
                        messageRep.classList.add('alert-danger');
                        messageRep.innerHTML = "No puedes dejar el valor del código vacio :(.";
                        
                        document.getElementById('inputAddNewCodigo').value = "";
                        document.getElementById('inputNewNombre').value = "";
                    }
                });
            }
        }

        function eliminarUsuario(id_user) {
            var id = id_user;

            $(document).on('click', '.eliminarUser', function(event) {
                $.ajax({
                    url: "../assets/php/userClass.php",
                    data: {id_user: id, funcion: "deleteUser"},
                    type: "POST",
                    dataType: "JSON",
                    success: function(e) {
                        var message = JSON.parse(e);

                        if(message == 1) {
                            alert("¡Se eliminó el usuario correctamente!");
                            window.location.reload(true);
                        } else {
                            alert("¡No se ha podido eliminar!");
                        }
                    }
                });
            });
        }
    </script>
</body>
</html>