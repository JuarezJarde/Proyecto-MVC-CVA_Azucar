<?php
require_once __DIR__ . '/../db/db.php';

class ModeloConfiguracion {
    private $db;

    public function __construct() {
        $this->db = Conectar::conexion();
    }

    //OBTENER CONFIGURACIÓN
    public function obtenerConfiguracion() {
        // Usamos id_configuracion = 1 (la única fila que habrá)
        $sql = "SELECT * FROM configuracion_web WHERE id_configuracion = 1";
        $resultado = $this->db->query($sql);
        return $resultado->fetch_assoc();
    }

    //ACTUALIZAR CONFIGURACIÓN
    public function actualizarConfiguracion($color, $titulo, $telefono, $email) {
        $sql = "UPDATE configuracion_web SET 
                color_principal = ?, 
                titulo_sitio = ?, 
                telefono = ?, 
                email_contacto = ? 
                WHERE id_configuracion = 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssss", $color, $titulo, $telefono, $email);
        
        return $stmt->execute();
    }
}
?>