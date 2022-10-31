<?php
error_reporting(E_ALL);
include_once('connection.php');
if(!empty($_POST['funcion']) && !empty($_POST['name']) && !empty($_POST['code'])) {
    $usuario = $_POST['name'];
    $codigo = $_POST['code'];
    
    switch($_POST['funcion']) {
        case "consumirRepuestos":
            inventoryClass::consumirRepuestos($codigo, $usuario);
            break;
        case "devolverRepuestos":
            inventoryClass::devolverRepuestos($codigo, $usuario);
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
            self::$productosPorPagina = 10;
            self::$pagina = 1;
            if(isset($_GET['pag'])) {
                self::$pagina = $_GET['pag'];
            }

                $offset = (self::$pagina - 1) * self::$productosPorPagina;

                $stmt = $db->query("SELECT COUNT(*) AS conteo FROM SpareParts");
                self::$conteo = $stmt->fetchObject()->conteo;

                self::$paginas = ceil(self::$conteo / self::$productosPorPagina);

                $busqueda = $db->prepare("SELECT * FROM SpareParts LIMIT 10 OFFSET $offset");
                $busqueda->execute();

                $resultado = $busqueda->fetchAll(PDO::FETCH_OBJ);

                return $resultado;
                $db->null;
        } catch(PDOException $e) {
            echo '"error":{"text:"'. $e->getMessage().'}}';
        }
    }

    public static function obtenerMovimientos() {
        try {
            $db = getDB();
            self::$productosPorPagina = 10;
            self::$pagina = 1;
            if(isset($_GET['pag'])) {
                self::$pagina = $_GET['pag'];
            }

                $offset = (self::$pagina - 1) * self::$productosPorPagina;

                $stmt = $db->query("SELECT COUNT(*) AS conteo FROM Movements");
                self::$conteo = $stmt->fetchObject()->conteo;

                self::$paginas = ceil(self::$conteo / self::$productosPorPagina);

                $busqueda = $db->prepare("SELECT * FROM Movements LIMIT 10 OFFSET $offset");
                $busqueda->execute();

                $resultado = $busqueda->fetchAll(PDO::FETCH_OBJ);

                return $resultado;

                $db->null;
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
                    echo json_encode(0);
                }
            } else {
                echo json_encode(0);
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
                    echo json_encode(0);
                }
            } else {
                echo json_encode(0);
            }
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

}

?>