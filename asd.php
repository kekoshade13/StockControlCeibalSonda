<?php 
include 'assets/php/connection.php';
$code = 1211111111111;
$db = getDB();
try {
    $stmt = $db->prepare("SELECT * FROM spareparts where code = ?");
    $stmt->execute([$code]);
    

    $count = $stmt->rowCount();
    if($count) {
        echo "hola";
    } else {
        echo "adios";
    }
}catch(PDOException $e) {
    echo e->getMessage();
}