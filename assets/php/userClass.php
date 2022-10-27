<?php
include_once('connection.php');
session_start();
class userClass {
    public static function userLogin($ci, $contrasenia) {   

        try {
            $db = getDB();
            $query = $db->prepare("SELECT * FROM users WHERE ci=:ci AND pass=:pass");
            $query->bindParam('ci', $ci, PDO::PARAM_STR);
            $query->bindParam('pass', $contrasenia, PDO::PARAM_STR);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_OBJ);
            $count = $query->rowCount();

            if($count > 0) {
                $_SESSION['uid'] = $data->id_user;
                return true;
            } else {
                 return false;
            }
            
            $query->execute();
        } catch(PDOException $e) {
            echo '"error":{"text:"'. $e->getMessage().'}}';
        }
        $db->null;
        $query->null;
    }

    public static function registrarUsuario($nombre, $ci, $pass, $class) {
        $db = getDB();
        try {

            $query = $db->prepare("INSERT INTO users (nombre_u, ci, pass, class) VALUES ('$nombre', '$ci', '$pass', '$class')");
            $query->execute();

            if($query) {
                return true;
            } else {
                return false;
            }
        } catch(PDOException $e) {
            echo '"error":{"text:"'. $e->getMessage().'}}';
        }
        
    }

    public static function obtenerDatosUnUsuario($id) {
        try {
            $db = getDB();
            $query = $db->prepare("SELECT * FROM users WHERE id_user=:id");
            $query->bindParam('id', $id, PDO::PARAM_STR);
            $query->execute();
            
            $count = $query->rowCount();

            if($count > 0) {
                $dataUser = $query->fetch(PDO::FETCH_OBJ);
                return $dataUser;
            }
        } catch(PDOException $e) {
            echo '"error":{"text:"'. $e->getMessage().'}}';
        }
    }
}

?>  