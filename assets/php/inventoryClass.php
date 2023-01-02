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
        
                inventoryClass::addNewRepuesto($newCodigo, $newNameCode, $newRepEquipo);
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
            if(!empty($_POST['nombre_u'])) {
                $nombre1 = $_POST['nombre_u'];
            } else {
                $nombre1 = '';
            }
            if(!empty($_POST['dateIni'])) {
                $fechaI1 = $_POST['dateIni'];
            } else {
                $fechaI1 = '';
            }
            if(!empty($_POST['dateFin'])) {
                $fechaF1 = $_POST['dateFin'];
            } else {
                $fechaF1 = '';
            }
            if(!empty($_POST['code'])) {
                $code1 = $_POST['code'];
            } else {
                $code1 = '';
            }
            if(!empty($_POST['tipoMovi'])) {
                $tipoMov1 = $_POST['tipoMovi'];
            } else {
                $tipoMov1 = '';
            }
            if(!empty($_POST['tipoStoc'])) {
                $tipoStoc1 = $_POST['tipoStoc'];
            } else {
                $tipoStoc1 = '';
            }
            inventoryClass::obtenerMovimientosGenerales($nombre1, $fechaI1, $fechaF1, $code1, $tipoMov1, $tipoStoc1);
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
        case 'obtenerRepEqComp':
            if(!empty($_POST['code'])) {
                $codeEqComp1 = $_POST['code'];
            } else {
                $codeEqComp1 = '';
            }
            if(!empty($_POST['newEqComp'])) {
                $newEqComp = $_POST['newEqComp'];
            } else {
                $newEqComp = '';
            }

            inventoryClass::obtenerRepuestosCompatibles($codeEqComp1, $newEqComp);
            break;
    }
}

class inventoryClass {

    public function __construct(int $pagina, int $paginas, int $productosPorPagina, int $conteo) {
    }
    
    public static function obtenerInventario($codigo, $modelo, $compatible, $tipoStock) {
        try {
            $db = getDB();

            $registros = "SELECT * FROM SpareParts";
            $registroComp = "select * from spareparts";

            //Obtener id de un codigo especifico.
            if(!empty($codigo)) {
                $codeRepInv = $db->prepare("SELECT * FROM SpareParts where code = $codigo");
                $codeRepInv->execute([$codigo]);

                $countCode = $codeRepInv->rowCount();
                if($countCode > 0) {
                    $codeRepInv = $codeRepInv->fetch();
                    $idCodigo = $codeRepInv['id_code'];
                } else {
                    $codigo = '';
                }
            }
            if(empty($compatible)) {
                $registros .= " as sp inner join repuestos_estados as repE inner join tipoStock as ts on repE.id_repuesto=sp.id_code and repE.id_estado=ts.id_stock";
                //Filtros funcionales de a uno.
                if(!empty($codigo) && !empty($modelo) && !empty($tipoStock)) {
                    $registros .= " where repE.id_repuesto = $idCodigo and sp.id_equip = $modelo and ts.id_stock = $tipoStock";
                } else if(!empty($codigo) && !empty($modelo)) {
                    $registros .= " where repE.id_repuesto like $idCodigo and sp.id_equip = $modelo";
                } else if(!empty($modelo) && !empty($tipoStock)) {
                    $registros .= " where sp.id_equip = $modelo and ts.id_stock = $tipoStock";
                } else if(!empty($codigo) && !empty($tipoStock)) {
                    $registros .= " where ts.id_stock = $tipoStock and repE.id_repuesto = $idCodigo";
                } else if(!empty($codigo)) {
                    $registros .= " where repE.id_repuesto like $idCodigo";
                } else if(!empty($tipoStock)) {
                    $registros .= " where ts.id_Stock = $tipoStock";
                } else if(!empty($modelo) && !empty($tipoStock)) {
                    $registros .= " where sp.id_equip = $modelo and ts.id_stock = $tipoStock";
                } else if(!empty($modelo)) {
                    $registros .= " where sp.id_equip = $modelo";
                }
                // Fin filtros   
                
                $registros = $db->prepare($registros);
    
                $registros->execute();
    
                $registros = $registros->fetchAll();
            }
            if(!empty($compatible)) {
                $registroComp = "select * from spareparts as sp inner join equipos_repuestos as eqR inner join equipos as eq  on eqR.repuesto_id=sp.id_code and eqR.equipo_id=eq.id_equipo";
            
                if(!empty($codigo) && !empty($modelo)) {
                    $registroComp .= " where eqR.repuesto_id = $idCodigo and eqR.equipo_id = $modelo";
                } else if(!empty($codigo)) {
                    $registroComp .= " where eqR.repuesto_id = $idCodigo";
                } else if(!empty($modelo)) {
                    $registroComp .= " where eqR.equipo_id = $modelo";
                }
                $registroComp = $db->prepare($registroComp);
                $registroComp->execute();
                $registroComp = $registroComp->fetchAll();
            }
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

            if(!empty($compatible)) {
                foreach($registroComp as $regComp) {
                    $tabla .= "<tr><td>".$regComp['code']."</td>
                    <td>".$regComp['name']."</td>
                    <td>".$regComp['nameEq']."</td>";
                }

                
                $tabla .= "</tr>";
            } else if(!empty($compatible) && !empty($codigo)) {

            }

            if(empty($compatible)) {
                foreach($registros as $reg) {
                    $tabla .= "<tr><td>" . $reg['code'] . "</td>
                    <td>".$reg['name']."</td>
                    <td>".$reg['qty']."</td>
                    <td>".$reg['nameTipoStock']."</td></tr>";
                }
            }

            $tabla .= '</tbody></table>';
            echo $tabla;
        } catch(PDOException $e) {
            echo '"error":{"text:"'. $e->getMessage().'}}';
        }
    }

    public static function obtenerInventarioCompatibles($codigo, $modelo, $compatible, $tipoStock) {

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

    public static function obtenerMovimientosGenerales($nombre_u, $fechaI, $fechaF, $codigo, $tipoMov, $tipoStoc) {
        try {
            $db = getDB();

            $registros = "SELECT * FROM Movements";

            if(!empty($fechaF) && !empty($fechaI) && !empty($codigo) && !empty($tipoMov) && !empty($tipoStoc) && !empty($nombre_u)) {
                $registros .= " where date >= '".$fechaI."' and date <= '$fechaF' and code like $codigo and move = '$tipoMov' and tipoStock = '$tipoStoc' and nombre = '$nombre_u'";
            } else if(!empty($fechaF) && !empty($nombre_u) && !empty($codigo) && !empty($tipoMov) && !empty($tipoStoc)) {
                $registros .= " where code like $codigo and move = '$tipoMov' and tipoStock = '$tipoStoc' and nombre = '$nombre_u' and date <= '$fechaF'";
            } else if(!empty($fechaI) && !empty($nombre_u) && !empty($codigo) && !empty($tipoMov) && !empty($tipoStoc)) {
                $registros .= " where code like $codigo and move = '$tipoMov' and tipoStock = '$tipoStoc' and nombre = '$nombre_u' and date >= '$fechaI'";
            } else if(!empty($fechaI) && !empty($fechaF) && !empty($tipoMov) && !empty($tipoStoc) && !empty($nombre_u)) {
                $registros .= " where date >= '$fechaI' and date <= '$fechaF' and move = '$tipoMov' and tipoStock = '$tipoStoc' and nombre = '$nombre_u'";
            } else if(!empty($fechaF) && !empty($fechaI) && !empty($codigo) && !empty($tipoMov) && !empty($tipoStoc)) {
                $registros .= " where date >= '".$fechaI."' and date <= '$fechaF' and code like $codigo and move = '$tipoMov' and tipoStock = '$tipoStoc'";
            } else if(!empty($fechaF) && !empty($fechaI) && !empty($codigo) && !empty($tipoMov)) {
                $registros .= " where date >= '".$fechaI."' and date <= '$fechaF' and code like $codigo and move = '$tipoMov'";
            } else if(!empty($fechaI) && !empty($codigo) && !empty($tipoMov) && !empty($tipoStoc)) {
                $registros .= " where code like $codigo and move = '$tipoMov' and tipoStock = '$tipoStoc' and date >= '$fechaI'";
            } else if(!empty($nombre_u) && !empty($codigo) && !empty($tipoMov) && !empty($tipoStoc)) {
                $registros .= " where code like $codigo and move = '$tipoMov' and tipoStock = '$tipoStoc' and nombre = '$nombre_u'";
            } else if(!empty($fechaI) && !empty($fechaF) && !empty($tipoMov) && !empty($tipoStoc)) {
                $registros .= " where date >= '$fechaI' and date <= '$fechaF' and move = '$tipoMov' and tipoStock = '$tipoStoc'";
            } else if(!empty($fechaI) && !empty($fechaF) && !empty($tipoStoc) && !empty(($nombre_u))) {
                $registros .= " where date >= '$fechaI' and date <= '$fechaF' and tipoStock = '$tipoStoc' and nombre = '$nombre_u'";
            } else if(!empty($nombre_u) && !empty($codigo) && !empty($tipoMov) && !empty($tipoStoc)) {
                $registros .= " where nombre = '$nombre_u' and code like $codigo and move = '$tipoMov'";
            } else if(!empty($fechaI) && !empty($tipoMov) && !empty($nombre_u)) {
                $registros .= " where nombre = '$nombre_u' and move = '$tipoMov' and date >= '$fechaI'";
            } else if(!empty($codigo) && !empty($fechaF) && !empty($fechaI)) {
                $registros .= " where date >= '".$fechaI."' and date <= '$fechaF' and code like $codigo";
            } else if(!empty($fechaI) && !empty($codigo) && !empty($tipoMov)) {
                $registros .= " where code like $codigo and move = '$tipoMov' and date >= '$fechaI'";
            } else if(!empty($tipoMov) && !empty($fechaF) && !empty($fechaI)) {
                $registros .= " where date >= '".$fechaI."' and date <= '$fechaF' and move = '$tipoMov'";
            } else if(!empty($tipoStoc) && !empty($fechaF) && !empty($fechaI)) {
                $registros .= " where date >= '".$fechaI."' and date <= '$fechaF' and tipoStock = '$tipoStoc'";
            } else if(!empty($codigo) && !empty($tipoMov) && !empty($tipoStoc)) {
                $registros .= " WHERE code LIKE $codigo and move = '$tipoMov' and tipoStock = '$tipoStoc'";
            } else if(!empty($nombre_u) && !empty($fechaF) && !empty($fechaI)) {
                $registros .= " where date >= '".$fechaI."' and date <= '$fechaF' and nombre = '$nombre_u'";
            } else if(!empty($nombre_u) && !empty($tipoMov) && !empty($codigo)) {
                $registros .= " where code like $codigo and move = '$tipoMov' and nombre = '$nombre_u'";
            } else if(!empty($fechaF) && !empty($codigo) && !empty($tipoMov)) {
                $registros .= " where code like $codigo and move = '$tipoMov' and date <= '$fechaF'";
            } else if(!empty($nombre_u) && !empty($tipoMov) && !empty($tipoStoc)) {
                $registros .= " WHERE nombre = '$nombre_u' and move = '$tipoMov' and tipoStock = '$tipoStoc'";
            } else if(!empty($nombre_u) && !empty($fechaI) && !empty($tipoStoc)) {
                $registros .= " where date >= '$fechaI' and tipoStock = '$tipoStoc' and nombre = '$nombre_u'";
            } else if(!empty($fechaI) && !empty($fechaF)) {
                $registros .= " where date >= '$fechaI' and date <= '$fechaF'";
            } else if(!empty($tipoMov) && !empty($tipoStoc)) {
                $registros .= " where move = '$tipoMov' and tipoStock = '$tipoStoc'";
            } else if(!empty($fechaI) and !empty($codigo)) {
                $registros .= " where date >= '$fechaI' and code like $codigo";
            } else if (!empty($fechaI) && !empty($tipoMov)) {
                $registros .= " where date >= '$fechaI' and move = '$tipoMov'";
            } else if(!empty($fechaI) && !empty($tipoStoc)) {
                $registros .= " where date >= '$fechaI' and tipoStock = '$tipoStoc'";
            } else if(!empty($fechaI) && !empty($nombre_u)) {
                $registros .= " where nombre = '$nombre_u' and date >= '$fechaI'";
            } else if (!empty($fechaF) && !empty($codigo)) {
                $registros .= " where date <= '$fechaF' and code like $codigo";
            } else if(!empty($fechaF) && !empty($tipoMov)) {
                $registros .= " where date <= '$fechaF' and move = '$tipoMov'";
            } else if(!empty($fechaF) && !empty($tipoStoc)) {
                $registros .= " where date <= '$fechaF' and tipoStock = '$tipoStoc'";
            } else if(!empty($fechaF) && !empty($nombre_u)) {
                $registros .= " where nombre = '$nombre_u' and date <= '$fechaF'";
            } else if(!empty($codigo) && !empty($nombre_u)) {
                $registros .= " where code like $codigo and nombre = '$nombre_u'";
            } else if(!empty($tipoMov) && !empty($nombre_u)) {
                $registros .= " where move = '$tipoMov' and nombre = '$nombre_u'";
            } else if(!empty($tipoStoc) && !empty($nombre_u)) {
                $registros .= " where tipoStock = '$tipoStoc' and nombre = '$nombre_u'";
            } else if(!empty($fechaI)) {
                $registros .= " WHERE date >= '".$fechaI."'";
            } else if(!empty($codigo)) {
                $registros .= " WHERE code LIKE ".$codigo;
            } else if(!empty($tipoMov)) {
                $registros .= " WHERE move = '$tipoMov'";
            } else if(!empty($tipoStoc)) {
                $registros .= " WHERE tipoStock = '$tipoStoc'";
            } else if(!empty($fechaF)) {
                $registros .= " where date <= '$fechaF'";
            } else if(!empty($nombre_u)) {
                $registros .= " where nombre = '$nombre_u'";
            }

            $registros .= " order by date desc";

            $registros = $db->prepare($registros);

            $registros->execute();

            $registros = $registros->fetchAll();

            $tabla = '<table class="table table-striped">
            <thead>
            <th>Usuario</th>
            <th>Código</th>
            <th>Tipo de Stock</th>
            <th>Movimiento</th>
            <th>Cantidad</th>
            <th>Fecha</th>
            <th>Hora</th>
            </thead><tbody>';
            foreach($registros as $reg) {
                $tabla .= '<tr><td>'.$reg['nombre'].'</td>
                <td>'.$reg['code'].'</td>';
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

    public static function obtenerRepuestosCompatibles($code, $equipo) {
        $db = getDB();
        try {
            $idCode = inventoryClass::obtenerDatosCodigos($code);
            $dataGen = inventoryClass::obtenerDataCode($code);

            $stmt = $db->prepare("select * from spareparts as sp inner join equipos_repuestos as eqR inner join equipos as eq  on eqR.repuesto_id=sp.id_code and eqR.equipo_id=eq.id_equipo where eqR.repuesto_id = ?");
            $stmt->execute([$idCode]);

            $obtenerEquipos = inventoryClass::obtenerEquipos();

            $obtenerEqCompNoAnadidos= inventoryClass::obtenerEquiposCompatiblesNoAnadidos($code);

            $count = $stmt->rowCount();
            if($count > 0) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $datos = '<div class="row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="row mb-5">
                        <div class="col-6 mb-3">
                            <label for="equipCompGest">Nombre del repuesto:</label>
                        </div>
                        <div class="col-6" id="eqRepComp">
                            <input type="text" class="form-control" value="'.$dataGen['name'].'" disabled/>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-6 mb-3">
                            <label for="listaEqComp">Equipos Compatibles:</label>
                        </div>
                        <div class="col-6 listaEqCompatibles" id="listaEqComp">
                            <div style="width: 200px; height: 200px; overflow-y: scroll;">
                                <ul>';
                                    foreach($data as $repComp) {
                                    $datos .= '<li>'.$repComp['nameEq'].'</li>';
                                    }

                                    $datos .= '
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row col-9">
                        <div class="col-6 row mb-5" style="margin-left: 35px;">
                            <div class="col-12 mb-3">
                                <label for="equipCompGest" class="w-100 text-center" style="border-bottom: solid 1px green">Agregar</label>
                            </div>
                            <div class="col-12">
                                <div class="w-100" style="height: 150px;">
                                    <select name="" id="" size="4" class="w-100" style="border-radius: 10px;">';
                                    foreach($obtenerEqCompNoAnadidos as $equiposs) {
                                        $datos .= '<option value="' . $equiposs->id_equipo . '">' . $equiposs->nameEq. '</option>';
                                    }
                                    $datos .= '</select>
                                </div>
                                <button type="button" class="btn btn-outline-success w-100">Añadir</button>
                            </div>
                        </div>

                        <div class="col-6 row mb-5">
                            <div class="col-12 mb-3">
                                <label for="equipCompGest" class="w-100 text-center" style="border-bottom: solid 1px red">Quitar</label>
                            </div>
                            <div class="col-12">
                                <div class="w-100" style="height: 150px;">
                                    <select name="" id="" size="4" class="w-100" style="border-radius: 10px;">';
                                    foreach($data as $repComp) {
                                        $datos .= '<option value="'.$repComp['nameEq'].'">'.$repComp['nameEq'].'</option>';
                                    }
                                    $datos .= '</select>
                                </div>
                                <button type="button" class="btn btn-outline-danger w-100">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
                echo $datos;
            } else {
                echo json_encode(0);
            }
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
                $idCodigo = inventoryClass::obtenerDatosCodigos($codigo);
                $validEstado = $db->prepare("SELECT * FROM repuestos_estados WHERE id_repuesto = ? and id_estado = ?");
                $validEstado->execute([$idCodigo, $tipoStock]);
                $countEstado = $validEstado->rowCount();
                if($countEstado > 0) {
                    $cantidad = $validEstado->fetch(PDO::FETCH_OBJ);
                    if($cantidad->qty > 0) {
                        $update = $db->prepare("UPDATE repuestos_estados SET qty = qty - 1 where id_repuesto = ? AND id_estado = ?");
                        $update->execute([$idCodigo, $tipoStock]);
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
            $idCodigo = inventoryClass::obtenerDatosCodigos($codigo);
            $cantidad = $stmt->fetch(PDO::FETCH_OBJ);
            if($count > 0) {
                $validEstado = $db->prepare("SELECT * FROM repuestos_estados WHERE id_repuesto = ? and id_estado = ?");
                $validEstado->execute([$idCodigo, $tipoStock]);
                $countEstado = $validEstado->rowCount();
                $cantidadTR = $validEstado->fetch(PDO::FETCH_OBJ);
                if($countEstado > 0) {
                    if($cantidadTR->qty >= 0) {
                        $update = $db->prepare("UPDATE repuestos_estados SET qty = qty + 1 where id_repuesto = ? AND id_estado = ?");
                        $update->execute([$idCodigo, $tipoStock]);
                        
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

    public static function addNewRepuesto($code, $name, $equipo) {
        $db = getDB();

        try {
            $verify = $db->prepare("SELECT * FROM SpareParts WHERE code = ?");
            $verify->execute([$code]);

            $count = $verify->rowCount();

            if($count > 0) {
                echo json_encode(2);
            } else {
                $stmt = $db->prepare("INSERT INTO SpareParts (code, name, id_equip) VALUES (?, ?, ?)");
                $stmt->execute([$code, $name, $equipo]);
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
            $stmt = $db->prepare("SELECT * FROM SpareParts WHERE code = ?");
            $stmt->execute([$code]);

            $count = $stmt->rowCount();
            $resultData = $stmt->fetch();

            if($count > 0) {
                $stmt1 = $db->prepare("SELECT * FROM repuestos_estados WHERE id_repuesto = ? AND id_estado = ?");
                $stmt1->execute([$resultData['id_code'], $tipoStock]);

                $countRE = $stmt1->rowCount();

                if($countRE > 0) {
                    $stateRepAument = $stmt1->fetch();
                    if($stateRepAument['qty'] >= 0 && $stateRepAument['qty'] >= $qty) {
                        $stmt2 = $db->prepare("UPDATE repuestos_estados SET qty = qty - $qty WHERE id = ?");
                        $stmt2->execute([$stateRepAument['id']]);
                        echo json_encode(1);
                    } else {
                        echo json_encode(2);
                    }
                } else {
                    echo json_encode(3);
                }
            } else {
                echo json_encode(3);
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function aumentarStock($code, $qty, $tipoStock) {
        $db = getDB();
        try {
            $stmt = $db->prepare("SELECT * FROM SpareParts WHERE code = ?");
            $stmt->execute([$code]);

            $count = $stmt->rowCount();
            $resultData = $stmt->fetch();

            if($count > 0) {
                $stmt1 = $db->prepare("SELECT * FROM repuestos_estados WHERE id_repuesto = ? AND id_estado = ?");
                $stmt1->execute([$resultData['id_code'], $tipoStock]);

                $countRE = $stmt1->rowCount();

                if($countRE > 0) {
                    $stateRepAument = $stmt1->fetch();
                    $stmt2 = $db->prepare("UPDATE repuestos_estados SET qty = qty + $qty WHERE id = ?");
                    $stmt2->execute([$stateRepAument['id']]);
                    echo json_encode(1);
                } else {
                    $stmt3 = $db->prepare("INSERT INTO repuestos_estados (id_repuesto, id_estado, qty) VALUES (?, ?, 0)");
                    $stmt3->execute([$resultData['id_code'], $tipoStock]);

                    $stmt4 = $db->prepare("SELECT * FROM repuestos_estados WHERE id_repuesto = ? AND id_estado = ?");
                    $stmt4->execute([$resultData['id_code'], $tipoStock]);

                    $countRE1 = $stmt4->rowCount();

                    if($countRE1 > 0) {
                        $newStateRep = $stmt4->fetch();
                        $idRepEst = $newStateRep['id'];
                        $stmt5 = $db->prepare("UPDATE repuestos_estados SET qty = qty + $qty WHERE id = ?");
                        $stmt5->execute([$idRepEst]);

                        echo json_encode(2);
                    } else {
                        echo json_encode(0);
                    }
                }
            } else {
                echo json_encode(3);
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

    public static function obtenerDatosCodigos($code)
    {
        $db = getDB();

        try {
            $stmt = $db->prepare("SELECT * FROM SpareParts where code = ?");
            $stmt->execute([$code]);

            $countCode = $stmt->rowCount();
            if($countCode > 0) {
                $stmt = $stmt->fetch();
                $idCodigo = $stmt['id_code'];
                return $idCodigo;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerEquiposCompatiblesNoAnadidos($code) {
        $db = getDB();

        try {
            $id = inventoryClass::obtenerDatosCodigos($code);
            $stmt = $db->prepare("select * from equipos where id_equipo not in (select equipo_id from equipos_repuestos where repuesto_id = '$id')");

            $stmt->execute();

            $datos = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $datos;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerDataCode($code) {
        $db = getDB();

        try {
            $stmt = $db->prepare("SELECT * FROM SpareParts where code = ?");
            $stmt->execute([$code]);

            $countCode = $stmt->rowCount();
            if($countCode > 0) {
                $stmt = $stmt->fetch();
                return $stmt;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
        
}

?>