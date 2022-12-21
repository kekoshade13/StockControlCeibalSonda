<?php
error_reporting(E_ALL);
include_once('connection.php');

if(!empty($_POST['funcion'])) {

    switch($_POST['funcion']) {
        case "consumirRepuestos":
            if(!empty($_POST['name']) && !empty($_POST['code']) && !empty($_POST['tipoEstado'])) {
                $usuario = $_POST['name'];
                $codigo = $_POST['code'];
                $tipoEstado = $_POST['tipoEstado'];
            }
            inventoryClass::consumirRepuestos($codigo, $usuario, $tipoEstado);
            break;
        case "devolverRepuestos":
            if(!empty($_POST['name']) && !empty($_POST['code']) && !empty($_POST['tipoEstado'])) {
                $usuario1 = $_POST['name'];
                $codigo1 = $_POST['code'];
                $tipoStock1 = $_POST['tipoEstado'];
            }
            inventoryClass::devolverRepuestos($codigo1, $usuario1, $tipoStock1);
            break;
        case 'addNewRepuest':
            if(!empty($_POST['newCode']) && !empty($_POST['newNombre']) && !empty($_POST['newRepEquipo'])) {
                $newCodigo = $_POST['newCode'];
                $newNameCode = $_POST['newNombre'];
                $newRepEquipo = $_POST['newRepEquipo'];

                if(!empty($_POST['eqComp'])) {
                    $eqComp = $_POST['eqComp'];
                } else {
                    $eqComp = "";
                }
        
                inventoryClass::addNewRepuesto($newCodigo, $newNameCode, $newRepEquipo, $eqComp);
            }
            break;
        case 'reduceStock':
            if(!empty($_POST['deleteCode']) && !empty($_POST['cantDelete']) && !empty($_POST['tipoStock'])) {
                $codeDelete = $_POST['deleteCode'];
                $cantDelete = $_POST['cantDelete'];
                $tipoStock = $_POST['tipoStock'];

                inventoryClass::reducirStock($codeDelete, $cantDelete, $tipoStock);
            }
            break;
        case 'aumentStock':
            if(!empty($_POST['codeAument']) && !empty($_POST['cantidad']) && !empty($_POST['tipoEstado'])) {
                $codeAument = $_POST['codeAument'];
                $cantidad = $_POST['cantidad'];
                $tipoStock = $_POST['tipoEstado'];
                inventoryClass::aumentarStock($codeAument, $cantidad, $tipoStock);
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
            if(!empty($_POST['tipoMovi'])) {
                $tipoMov = $_POST['tipoMovi'];
            } else {
                $tipoMov = '';
            }
            if(!empty($_POST['tipoStoc'])) {
                $tipoStoc = $_POST['tipoStoc'];
            } else {
                $tipoStoc = '';
            }
            inventoryClass::obtenerMovimientos($nombre, $fechaI, $fechaF, $code, $tipoMov, $tipoStoc);
            break;
        case 'filtrarMovimientosGenerales':
            inventoryClass::obtenerMovimientosGenerales();
            break;
        case 'filtrarInventario':
            if(!empty($_POST['code'])) {
                $codigo = $_POST['code'];
            } else {
                $codigo = "";
            }
            if(!empty($_POST['modelo'])) {
                $modelo = $_POST['modelo'];
            } else {
                $modelo = "";
            }

            if(!empty($_POST['compatible'])) {
                $compatible = $_POST['compatible'];
            } else {
                $compatible = "";
            }
            if(!empty($_POST['tipoEstado'])) {
                $tipoStock = $_POST['tipoEstado'];
            } else {
                $tipoStock = "";
            }
            inventoryClass::obtenerInventario($codigo, $modelo, $compatible, $tipoStock);
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
    
    public static function obtenerInventario($codigo, $modelo, $compatible, $tipoStock) {
        try {
            $db = getDB();

            self::$pagina = isset($_GET['pag']) ? (int)$_GET['pag'] : 1;

            self::$productosPorPagina = 8;

            $inicio  = (self::$pagina>1) ? ((self::$pagina * self::$productosPorPagina)-self::$productosPorPagina) : 0;

            $registros = "SELECT * FROM SpareParts";

            if(!empty($modelo)) {
                $registros .= " as sp inner join equipos as eq on sp.id_equip=eq.id_equipo where sp.id_equip = $modelo";
            }

            if(!empty($codigo) && !empty($modelo)) {
                $registros .= " and code = $codigo";
            } else if(!empty($codigo)){
                $registros .= " where code = ".$codigo;
            }

            if(!empty($tipoStock) && !empty($modelo)) {
                $registros .= " and tipostock = $tipoStock";
            } else if(!empty($tipoStock) && !empty($codigo)) {
                $registros .= " and tipostock = $tipoStock";
            } else if(!empty($tipoStock)) {
                $registros .= " where tipostock = $tipoStock";
            }

            if(!empty($compatible)) {
                $registroComp = $db->prepare('select * from spareparts as sp inner join equipos_repuestos as eqR inner join equipos as eq on eqR.repuesto_id=sp.id_code and eqR.equipo_id=eq.id_equipo where eqR.repuesto_id;
                ');
                $registroComp->execute();
                $registroComp = $registroComp->fetchAll();

            }

            $registros .= " as sp inner join repuestos_estados as repE inner join tipoStock as ts on repE.id_repuesto=sp.id_code and repE.id_estado=ts.id_stock where repE.id_repuesto";

            $registros = $db->prepare($registros);

            $registros->execute();

            $registros = $registros->fetchAll();

            $tabla = '<table class="table table-striped">
            <thead>
            <th>Código</th>
            <th>Nombre</th>';
            if(!empty($compatible)) {
                $tabla .= '<th>Compatible con</th>';
            } else {
                $tabla .= '
                <th>Cantidad</th>
                <th>Tipo de Stock</th>
                </thead><tbody>';
            }
            
            foreach($registros as $reg) {
                $tabla .= '<tr>
                    <td>'.$reg['code'].'</td>
                    <td>'.$reg['name'].'</td>';
                    if(!empty($compatible)) {
                        foreach($registroComp as $regComp) {
                        $nameEq = inventoryClass::obtenerUnEquipo($regComp['id_equipo']);
                        foreach($nameEq as $name) {
                            $tabla .= '<td>' . $name->name . '</td>';
                        }
                        
                        }
                    } else {
                        $tabla .= '<td>'.$reg['qty'].'</td>';
                        $tipoStock = inventoryClass::obtenerUnTipoStock($reg['id_stock']);
                        foreach($tipoStock as $tStock) {
                            $tabla .= '<td>'.$tStock->nameTipoStock.'</td>';
                        }
                    }

                    $tabla .= '</tr>';
            }

            $tabla .= '</tbody></table>';
            echo $tabla;
        } catch(PDOException $e) {
            echo '"error":{"text:"'. $e->getMessage().'}}';
        }
    }

    public static function obtenerMovimientos($nombre_u, $fechaI, $fechaF, $codigo, $tipoMov, $tipoStoc) {
        try {
            $db = getDB();

            $registros = "SELECT * FROM Movements WHERE nombre = ?";

            if(!empty($fechaI)) {
                $registros .= " AND date >= '".$fechaI."'";
            }
            if(!empty($fechaF)) {
                $registros .= " AND date <= '".$fechaF."'";
            }
            if(!empty($codigo)) {
                $registros .= " AND code LIKE ".$codigo;
            }
            if(!empty($tipoMov)) {
                $registros .= " AND move = '$tipoMov'";
            }
            if(!empty($tipoStoc)) {
                $registros .= " AND tipoStock = '$tipoStoc'";
            }

            $registros .= " order by fechaTotal desc";

            $registros = $db->prepare($registros);

            $registros->execute([$nombre_u]);

            $registros = $registros->fetchAll();

            $tabla = '<table class="table table-striped">
            <thead>
            <th>Código</th>
            <th>Tipo de Stock</th>
            <th>Movimiento</th>
            <th>Cantidad</th>
            <th>Fecha</th>
            <th>Hora</th>
            </thead><tbody>';
            foreach($registros as $reg) {
                $tabla .= '<tr><td>'.$reg['code'].'</td>';
                $obtenerTipoStock = inventoryClass::obtenerUnTipoStock($reg['tipoStock']);
                foreach($obtenerTipoStock as $tipoStock) {
                    $tabla .= '<td>'.$tipoStock->nameTipoStock.'</td>';
                }
                $tabla .= '<td>'.$reg['move'].'</td>
                    <td>'.$reg['qty'].'</td>
                    <td>'.$reg['date'].'</td>
                    <td>'.$reg['hora'].'</td>
                    </tr>';
            }

            $tabla .= '</tbody></table>';
            echo $tabla;
        } catch(PDOException $e) {
            echo '"error":{"text:"'. $e->getMessage().'}}';
        }
    }

    public static function obtenerMovimientosGenerales() {
        try {
            $db = getDB();

            $registros = "SELECT SQL_CALC_FOUND_ROWS * FROM Movements";

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

            $registros->execute();

            $registros = $registros->fetchAll();

            $tabla = '<table class="table table-striped">
            <thead>
            <th>Código</th>
            <th>Tipo de Stock</th>
            <th>Movimiento</th>
            <th>Cantidad</th>
            <th>Fecha</th>
            </thead><tbody>';
            foreach($registros as $reg) {
                $tabla .= '<tr><td>'.$reg['code'].'</td>';
                $obtenerTipoStock = inventoryClass::obtenerUnTipoStock($reg['tipoStock']);
                foreach($obtenerTipoStock as $tipoStock) {
                    $tabla .= '<td>'.$tipoStock->nameTipoStock.'</td>';
                }
                $tabla .= '<td>'.$reg['move'].'</td>
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

    public static function consumirRepuestos($codigo, $nombre, $tipoStock) {
        $db = getDB();
        try {
            $stmt = $db->prepare("SELECT * FROM SpareParts where code = ?");
            $stmt->execute([$codigo]);
            
            $count = $stmt->rowCount();
            if($count > 0) {
                $validEstado = $db->prepare("SELECT * FROM SpareParts WHERE code = ? and tipoStock = ?");
                $validEstado->execute([$codigo, $tipoStock]);
                $countEstado = $validEstado->rowCount();
                if($countEstado > 0) {
                    $cantidad = $validEstado->fetch(PDO::FETCH_OBJ);
                    if($cantidad->qty > 0) {
                        $update = $db->prepare("UPDATE spareparts SET qty = qty - 1 where code = ? AND tipoStock = ?");
                        $update->execute([$codigo, $tipoStock]);
                        date_default_timezone_set('America/Buenos_Aires');

                        $fecha = date('His');
                        $movement = $db->prepare("INSERT INTO movements (nombre, code, move, qty, tipoStock, date, hora, fechaTotal) VALUES
                        ('$nombre', '$codigo', 'Salida', 1, '$tipoStock', current_time(), $fecha, current_timestamp())");
                        $movement->execute();
                        echo json_encode(1);
                    } else {
                        echo json_encode(2);
                    }
                } else {
                    echo json_encode(3);
                }
            } else {
                echo json_encode(4);
            }
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function devolverRepuestos($codigo, $nombre, $tipoStock) {
        $db = getDB();
        try {
            $stmt = $db->prepare("SELECT * FROM spareparts where code = ?");
            $stmt->execute([$codigo]);
            
            $count = $stmt->rowCount();
            $cantidad = $stmt->fetch(PDO::FETCH_OBJ);
            if($count > 0) {
                $validEstado = $db->prepare("SELECT * FROM SpareParts WHERE code = ? and tipoStock = ?");
                $validEstado->execute([$codigo, $tipoStock]);
                $countEstado = $validEstado->rowCount();

                if($countEstado > 0) {
                    if($cantidad->qty >= 0) {
                        $update = $db->prepare("UPDATE spareparts SET qty = qty + 1 where code = ? AND tipoStock = ?");
                        $update->execute([$codigo, $tipoStock]);
                        
                        date_default_timezone_set('America/Buenos_Aires');

                        $fecha = date('His');

                        if($update) {
                            $movement = $db->prepare("INSERT INTO movements (nombre, code, move, qty, tipoStock, date, hora, fechaTotal) VALUES
                            ('$nombre', '$codigo', 'Entrada', 1, '$tipoStock', current_time(), $fecha, current_timestamp())");
                            $movement->execute();
                            echo json_encode(1);
                        }
                    } else {
                        echo json_encode(2);
                    }
                } else {
                    echo json_encode(3);
                }
                
            } else {
                echo json_encode(4);
            }
        }catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function addNewRepuesto($code, $name, $equipo, $eqComp) {
        $db = getDB();

        try {
            $verify = $db->prepare("SELECT * FROM SpareParts WHERE code = ?");
            $verify->execute([$code]);

            $count = $verify->rowCount();

            if($count > 0) {
                echo json_encode(0);
            } else {
                $stmt = $db->prepare("INSERT INTO SpareParts (code, name, id_equip, id_equip_comp, tipoStock) VALUES (?, ?, ?, ?, 1)");
                $stmt->execute([$code, $name, $equipo, $eqComp]);
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

    public static function reducirStock($code, $qty, $tipoStock) {
        $db = getDB();
        try {
            $consulta = $db->prepare("SELECT * FROM SpareParts WHERE code = ?");
            $consulta->execute([$code]);
            $count = $consulta->rowCount();
            $dataStock = $consulta->fetch(PDO::FETCH_OBJ);
            if($count > 0) {
                $verificarEstado = $db->prepare("select * from spareparts where code = ? and tipoStock = ?");
                $verificarEstado->execute([$code, $tipoStock]);
                $countEst = $verificarEstado->rowCount();

                if($countEst > 0) {
                    $actualizarCantidad = $db->prepare("UPDATE SpareParts SET qty = qty - $qty WHERE code = $code AND tipoStock = $tipoStock");
                    $actualizarCantidad->execute();

                    if($actualizarCantidad) {
                        echo json_encode(1);
                    } else {
                        echo json_encode(0);
                    }
                } else {
                    $codigo = $dataStock->code;
                    $name = $dataStock->name;
                    $id_equipo = $dataStock->id_equip;
                    $id_equipo_comp = $dataStock->id_equip_comp;

                    $crearTipoStock = $db->prepare("INSERT INTO SpareParts (code, name, id_equip, id_equip_comp, tipoStock) VALUES (?, ?, ?, ?, ?)");
                    $crearTipoStock->execute([$codigo, $name, $id_equipo, $id_equipo_comp, $tipoStock]);

                    if($crearTipoStock) {
                        $actualizarCantidad = $db->prepare("UPDATE SpareParts SET qty = qty - $qty WHERE code = $code AND tipoStock = $tipoStock");
                        $actualizarCantidad->execute();
                        if($actualizarCantidad) {
                            echo json_encode(1);
                        } else {
                            echo json_encode(0);
                        }
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

    public static function aumentarStock($code, $qty, $tipoStock) {
        $db = getDB();
        try {
            $consulta = $db->prepare("SELECT * FROM SpareParts WHERE code = ?");
            $consulta->execute([$code]);
            $count = $consulta->rowCount();
            $dataStock = $consulta->fetch(PDO::FETCH_OBJ);
            if($count > 0) {
                $verificarEstado = $db->prepare("select * from spareparts where code = ? and tipoStock = ?");
                $verificarEstado->execute([$code, $tipoStock]);
                $countEst = $verificarEstado->rowCount();

                if($countEst > 0) {
                    $actualizarCantidad = $db->prepare("UPDATE SpareParts SET qty = qty + $qty WHERE code = $code AND tipoStock = $tipoStock");
                    $actualizarCantidad->execute();

                    if($actualizarCantidad) {
                        echo json_encode(1);
                    } else {
                        echo json_encode(0);
                    }
                } else {
                    $codigo = $dataStock->code;
                    $name = $dataStock->name;
                    $id_equipo = $dataStock->id_equip;
                    $id_equipo_comp = $dataStock->id_equip_comp;

                    $crearTipoStock = $db->prepare("INSERT INTO SpareParts (code, name, id_equip, id_equip_comp, tipoStock) VALUES (?, ?, ?, ?, ?)");
                    $crearTipoStock->execute([$codigo, $name, $id_equipo, $id_equipo_comp, $tipoStock]);

                    if($crearTipoStock) {
                        $actualizarCantidad = $db->prepare("UPDATE SpareParts SET qty = qty + $qty WHERE code = $code AND tipoStock = $tipoStock");
                        $actualizarCantidad->execute();
                        if($actualizarCantidad) {
                            echo json_encode(1);
                        } else {
                            echo json_encode(0);
                        }
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

    public static function obtenerUnEquipo($id) {
        $db = getDB();
        try {
            $stmt = $db->prepare("SELECT * FROM equipos where id_equipo = ?");
            $stmt->execute([$id]);

            $count = $stmt->rowCount();

            if($count > 0) {
                $dataEquipos = $stmt->fetchAll(PDO::FETCH_OBJ);

                return $dataEquipos;
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerUnTipoStock($id) {
        $db = getDB();
        try {
            $stmt = $db->prepare("SELECT * FROM tipostock where id_stock = ?");
            $stmt->execute([$id]);

            $count = $stmt->rowCount();

            if($count > 0) {
                $dataTipoStock = $stmt->fetchAll(PDO::FETCH_OBJ);

                return $dataTipoStock;
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerEquipos() {
        $db = getDB();
        try {
            $stmt = $db->prepare("SELECT * FROM equipos");
            $stmt->execute();

            $count = $stmt->rowCount();

            if($count > 0) {
                $dataEquipos = $stmt->fetchAll(PDO::FETCH_OBJ);

                return $dataEquipos;
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerTiposStock() {
        $db = getDB();
        try {
            $stmt = $db->prepare("SELECT * FROM tipostock");
            $stmt->execute();

            $count = $stmt->rowCount();

            if($count > 0) {
                $dataTipoStock = $stmt->fetchAll(PDO::FETCH_OBJ);

                return $dataTipoStock;
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

}

?>