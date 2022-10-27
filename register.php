<?php
include 'assets/php/userClass.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form id="" method="POST">
        <input type="text" name="nombre_u" id="nombreU" placeholder="Ingresa tu usuario">
        <input type="text" name="ci" id="ci" placeholder="Ingresa tu cedula">
        <input type="password" name="pass" id="pass" placeholder="Ingresa tu contraseña">
        <input type="text" name="class" id="class" placeholder="Que tipo de usuario sera?">
        <input type="submit" name="btnRegistrar" value="Registrar">
    </form>
<?php

if(!empty($_POST['btnRegistrar'])) {
    $nombre = $_POST['nombre_u'];
    $ci = $_POST['ci'];
    $pass = $_POST['pass'];
    $class = $_POST['class'];
    if(strlen(trim($nombre)) > 1 && strlen(trim($ci)) > 1 && strlen(trim($pass)) > 1 && strlen(trim($class)) > 1) {
        $result = userClass::registrarUsuario($nombre, $ci, $pass, $class);
        if($result) {
            header("Location: login.php");
        } else {
            header("Location: register.php");
        }
    }
}

?>
</body>
</html>

<?php
                        if(isset($_POST['consumirRepuesto'])) {
                            $nombre = $_POST['nombre'];
                            $code = $_POST['code'];

                            if(strlen(trim($nombre)) > 1 && strlen(trim($code)) > 1) {
                                $result = inventoryClass::consumirRepuestos($nombre, $code);

                                if($result) {
                                    ?>
                                        <script>
                                            alert("Repuesto consumido correctamente");
                                        </script>
                                    <?php
                                } else {
                                    ?>
                                        <script>
                                            alert("Ha ocurrido un error. Contacte a un administrador.");
                                        </script>
                                    <?php
                                }
                            }
                        }                        
                    ?>
                    $stmt = $db->prepare("INSERT INTO Movements (nombre, code, move, qty, date) VALUES ('$nombre', '$code', 'Salida', 1, current_timestamp())");
                    $stmt->execute();
    
                    $stmt = $db->prepare("UPDATE SpareParts SET qty = qty - 1 WHERE code = ?");
                    $stmt->execute([$code]);

                    $solut = 1;
                    echo json_encode($solut);