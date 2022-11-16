<?php
error_reporting(E_ALL);
include_once('connection.php');

if(!empty($_POST['funcion'])) {

    switch($_POST['funcion']) {
        case "consumirRepuestos":
            if(!empty($_POST['name']) && !empty($_POST['code'])) {
                $usuario = $_POST['name'];
                $codigo = $_POST['code'];
            }
            inventoryClass::consumirRepuestos($codigo, $usuario);
            break;
        case "devolverRepuestos":
            if(!empty($_POST['name']) && !empty($_POST['code'])) {
                $usuario1 = $_POST['name'];
                $codigo1 = $_POST['code'];
            }
            inventoryClass::devolverRepuestos($codigo1, $usuario1);
            break;
        case 'addNewRepuest':
            if(!empty($_POST['newCode']) && !empty($_POST['newNombre'])) {
                $newCodigo = $_POST['newCode'];
                $newNameCode = $_POST['newNombre'];
        
                inventoryClass::addNewRepuesto($newCodigo, $newNameCode);
            }
            break;
        case 'reduceStock':
            if(!empty($_POST['deleteCode']) && !empty($_POST['cantDelete'])) {
                $codeDelete = $_POST['deleteCode'];
                $cantDelete = $_POST['cantDelete'];

                inventoryClass::reducirStock($codeDelete, $cantDelete);
            }
            break;
        case 'aumentStock':
            if(!empty($_POST['codeAument']) && !empty($_POST['cantidad'])) {
                $codeAument = $_POST['codeAument'];
                $cantidad = $_POST['cantidad'];
                inventoryClass::aumentarStock($codeAument, $cantidad);
            }
            break;
        case 'filtrarMovimientos':
            if(!empty($_POST['nombre_u'])) {
                $nombre = $_POST['nombre_u'];
            } else {
                $nombre = '';
            }
            if(!empty($_POST['dateIni'])) {
                $fechaI = $_POST['dateIni'];
            } else {
                $fechaI = '';
            }
            if(!empty($_POST['dateFin'])) {
                $fechaF = $_POST['dateFin'];
            } else {
                $fechaF = '';
            }
            if(!empty($_POST['code'])) {
                $code = $_POST['code'];
            } else {
                $code = '';
            }
            inventoryClass::obtenerMovimientos($nombre, $fechaI, $fechaF, $code);
            break;
    }
}

class inventoryClass {

    public static $pagina = 0;
    public static $paginas = 0;
    public static $productosPorPagina = 0;
    public static $conteo = 0;

    public function __construct(int $pagina, int $paginas, int $productosPorPagina, int $conteo) {
        $this->pagina = $pagina;
        $this->paginas = $paginas;
        $this->productosPorPagina = $productosPorPagina;
        $this->conteo = $conteo;
    }
    
    public static function obtenerInventario() {
        try {
            $db = getDB();

            self::$pagina = isset($_GET['pag']) ? (int)$_GET['pag'] : 1;

            self::$productosPorPagina = 8;

            $inicio  = (self::$pagina>1) ? ((self::$pagina * self::$productosPorPagina)-self::$productosPorPagina) : 0;

            $registros = "SELECT SQL_CALC_FOUND_ROWS * FROM SpareParts";

            $registros .= " LIMIT $inicio, ".self::$productosPorPagina;

            $registros = $db->prepare($registros);

            $registros->execute();

            $registros = $registros->fetchAll();

            self::$conteo = $db->query("SELECT FOUND_ROWS() as total");
            self::$conteo = self::$conteo->fetch()['total'];

            self::$paginas = ceil(self::$conteo / self::$productosPorPagina);

            return $registros;
        } catch(PDOException $e) {
            echo '"error":{"text:"'. $e->getMessage().'}}';
        }
    }

    public static function obtenerMovimientos($nombre_u, $fechaI, $fechaF, $codigo) {
        try {
            $db = getDB();

            self::$pagina = isset($_GET['pag']) ? (int)$_GET['pag'] : 1;

            self::$productosPorPagina = 8;

            $inicio  = (self::$pagina>1) ? ((self::$pagina * self::$productosPorPagina)-self::$productosPorPagina) : 0;

            $registros = "SELECT SQL_CALC_FOUND_ROWS * FROM Movements WHERE nombre = ?";

            if(!empty($fechaI)) {
                $registros .= " AND date >= '".$fechaI."'";
            }
            if(!empty($fechaF)) {
                $registros .= " AND date <= '".$fechaF."'";
            }
            if(!empty($codigo)) {
                $registros .= " AND code LIKE ".$codigo;
            }

            $registros .= " order by date desc";

            $registros = $db->prepare($registros);

            $registros->execute([$nombre_u]);

            $registros = $registros->fetchAll();

            self::$conteo = $db->query("SELECT FOUND_ROWS() as total");
            self::$conteo = self::$conteo->fetch()['total'];

            self::$paginas = ceil(self::$conteo / self::$productosPorPagina);

            $tabla = '<table class="table table-striped">
            <thead>
            <th>Nombre</th>
            <th>Código</th>
            <th>Cantidad</th>
            <th>Fecha</th>
            </thead><tbody>';
            foreach($registros as $reg) {
                $tabla .= '<tr>
                    <td>'.$reg['nombre'].'</td>
                    <td>'.$reg['code'].'</td>
                    <td>'.$reg['qty'].'</td>
                    <td>'.$reg['date'].'</td>
                    </tr>';
            }

            $tabla .= '</tbody></table>';
            echo $tabla;
        } catch(PDOException $e) {
            echo '"error":{"text:"'. $e->getMessage().'}}';
        }
    }

    public static function consumirRepuestos($codigo, $nombre) {
        $db = getDB();
        try {
            $stmt = $db->prepare("SELECT * FROM spareparts where code = ?");
            $stmt->execute([$codigo]);
            
            $count = $stmt->rowCount();
            $cantidad = $stmt->fetch(PDO::FETCH_OBJ);
            if($count > 0) {
                if($cantidad->qty > 0) {
                    $update = $db->prepare("UPDATE spareparts SET qty = qty - 1 where code = ?");
                    $update->execute([$codigo]);

                    $movement = $db->prepare("INSERT INTO movements (nombre, code, move, qty, date) VALUES
                    ('$nombre', '$codigo', 'Salida', 1, current_timestamp())");
                    $movement->execute();
                    echo json_encode(1);
                } else {
                    echo json_encode(2);
                }
            } else {
                echo json_encode(3);
            }
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function devolverRepuestos($codigo, $nombre) {
        $db = getDB();
        try {
            $stmt = $db->prepare("SELECT * FROM spareparts where code = ?");
            $stmt->execute([$codigo]);
            
            $count = $stmt->rowCount();
            $cantidad = $stmt->fetch(PDO::FETCH_OBJ);
            if($count > 0) {
                if($cantidad->qty >= 0) {
                    $update = $db->prepare("UPDATE spareparts SET qty = qty + 1 where code = ?");
                    $update->execute([$codigo]);

                    if($update) {
                        $movement = $db->prepare("INSERT INTO movements (nombre, code, move, qty, date) VALUES
                        ('$nombre', '$codigo', 'Entrada', 1, current_timestamp())");
                        $movement->execute();
                        echo json_encode(1);
                    }
                } else {
                    echo json_encode(2);
                }
            } else {
                echo json_encode(3);
            }
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function addNewRepuesto($code, $name) {
        $db = getDB();

        try {
            $stmt = $db->prepare("INSERT INTO SpareParts (code, name) VALUES (?, ?)");
            $stmt->execute([$code, $name]);

            $verify = $db->prepare("SELECT * FROM SpareParts WHERE code = ?");
            $verify->execute([$code]);

            $count = $verify->rowCount();

            if($count > 0) {
                echo json_encode(0);
            } else {
                if($stmt) {
                    echo json_encode(1);
                } else {
                    echo json_encode(0);
                }
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function reducirStock($code, $qty) {
        $db = getDB();
        try {
            $consulta = $db->prepare("SELECT * FROM SpareParts WHERE code = ?");
            $consulta->execute([$code]);
            $cantidad = $consulta->fetch(PDO::FETCH_OBJ);
            if($cantidad->qty > 0) {
                if($qty > $cantidad->qty) {
                    echo json_encode(2);
                } else {
                    $stmt = $db->prepare("UPDATE SpareParts SET qty = qty - $qty WHERE code = $code");
                    $stmt->execute();
                    if($stmt) {
                        echo json_encode(1);
                    } else {
                        echo json_encode(0);
                    }
                }
            } else {
                echo json_encode(0);
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function aumentarStock($code, $qty) {
        $db = getDB();
        try {
            $stmt = $db->prepare("UPDATE SpareParts SET qty = qty + $qty WHERE code = $code");
            $stmt->execute();

            $consulta = $db->prepare("SELECT * FROM SpareParts WHERE code = ?");
            $consulta->execute([$code]);
            $cantidad = $consulta->fetch(PDO::FETCH_OBJ);
            if($cantidad->qty > 0) {
                if($stmt) {
                    echo json_encode(1);
                } else {
                    echo json_encode(0);
                }
            } else {
                echo json_encode(0);
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

}

?>