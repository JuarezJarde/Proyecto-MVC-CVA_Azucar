<?php
require_once __DIR__ . '/../db/db.php';

class ModeloAuditoria {
    private $db;

    public function __construct() {
        $this->db = Conectar::conexion();
    }

    //registrar una accion
    public function registrarAccion($usuario, $accion, $detalles = "") {
        $sql = "INSERT INTO auditoria (usuario, accion, detalles) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $usuario, $accion, $detalles);
        return $stmt->execute();
    }

    //leer logs
    public function obtenerLogs() {
        // Traemos los últimos 50 movimientos, los más nuevos primero
        $sql = "SELECT * FROM auditoria ORDER BY fecha_hora DESC LIMIT 50"; 
        $resultado = $this->db->query($sql);
        
        $datos = [];
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $datos[] = $row;
            }
        }
        return $datos;
    }
}
?>