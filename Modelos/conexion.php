<?php
class Conexion {
    static public function conectar(){
        $dbs = 'mysql:dbname=inventarios;host=localhost';
        $usuario = 'root';
        $contrasena = '';
        try{
            $base = new PDO($dbs, $usuario, $contrasena);
           
            return $base;
        } catch(PDOException $e){
            echo 'Fallo la conexion';
        }
    }
}

?>