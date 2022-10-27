<?php 
include 'assets/php/connection.php';
$code = 120036;
$db = getDB();
$consulta = $db->prepare("SELECT qty FROM SpareParts where code= ?");
$consulta->execute([$code]);

$count = $consulta->rowCount();

if($count) {
    echo 'hola';
} else {
    echo 'adios';
}