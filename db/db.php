<?php
class Conectar {
    public static function conexion() {
        // Ajusta aquí tus credenciales si cambian
        $conexion = new mysqli("localhost", "root", "", "cva_azucar_db");
        
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }
        
        $conexion->query("SET NAMES 'utf8'"); // Para que las ñ y tildes se vean bien
        return $conexion;
    }
}
?>