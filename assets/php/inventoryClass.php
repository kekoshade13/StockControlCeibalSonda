<?php
error_reporting(E_ALL);
include_once('connection.php');
$usuario = isset($_GET['name']);
$codigo = isset($_GET['code']);

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

}

?>