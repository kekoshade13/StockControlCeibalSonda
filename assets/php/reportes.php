<?php

require "../../vendor/autoload.php";
require_once('connection.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$db = getDB();
try {
        $documento = new Spreadsheet();
        $documento
            ->getProperties()
            ->setCreator("Creado por José Paz")
            ->setLastModifiedBy('José Paz')
            ->setTitle('Consumo De Repuestos Detallado')
            ->setDescription('Archivo generado automaticamente');
        
        $hojaDeProductos = $documento->getActiveSheet();
        $hojaDeProductos->setTitle("Consumo");
        
        $encabezado = ["Salida"];
        $hojaDeProductos->fromArray($encabezado, null, 'A1');
        $encabezado1 = ["Código del repuesto", "Cantidad"];
        $hojaDeProductos->fromArray($encabezado1, null, 'A2');

        $hojaDeProductos->setCellValue('C1', 'Entrada');

        $nombre = $_POST['select_usuario'];
        $fechaIni = "";
        $fechaFin = "";
            
        $sql = "select distinct code, count(qty) as cantidad from Movements where nombre ='$nombre'";

        if(!empty($_POST['fechaIni'])) {
            $fechaIni = $_POST['fechaIni'];

            $sql .= " and date >= '$fechaIni'";
        }
        if(!empty($_POST['fechaFin'])) {
            $fechaFin = $_POST['fechaFin'];
            $sql .= " and date < '$fechaFin'";
        }

        $sql .= " and move = 'Salida' group by code order by code asc";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        
        $numeroDeFila = 3;
        while($res = $stmt->fetch(PDO::FETCH_OBJ)) {
            $hojaDeProductos->setCellValueByColumnAndRow(1, $numeroDeFila, $res->code);
            $hojaDeProductos->setCellValueByColumnAndRow(2, $numeroDeFila, $res->cantidad);
            $numeroDeFila++;
        }

        $sql1 = "select distinct code, count(qty) as cantidad from Movements where nombre ='$nombre'";

        if(!empty($_POST['fechaIni'])) {
            $fechaIni = $_POST['fechaIni'];

            $sql1 .= " and date >= '$fechaIni'";
        }
        if(!empty($_POST['fechaFin'])) {
            $fechaFin = $_POST['fechaFin'];
            $sql1 .= " and date < '$fechaFin'";
        }

        $sql1 .= " and move = 'Entrada' group by code order by code asc";

        $stmt1 = $db->prepare($sql1);
        $stmt1->execute();

        $numeroDeFila1 = 3;
        while($res1 = $stmt1->fetch(PDO::FETCH_OBJ)) {
            $hojaDeProductos->setCellValueByColumnAndRow(3, $numeroDeFila1, $res1->cantidad);
            $hojaDeProductos->setCellValueByColumnAndRow(4, $numeroDeFila1, $res1->code);
            $numeroDeFila1++;
        }

        $fileName="consumoSalidaYEntradaStock.xlsx";
        $writer = new Xlsx($documento);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
        exit();
} catch(PDOException $e) {
    echo '"error":{"text:"'. $e->getMessage().'}}';
}

?>

