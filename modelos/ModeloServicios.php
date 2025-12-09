<?php
require_once __DIR__ . '/../db/db.php';

class ModeloServicios {
    private $db;

    public function __construct() {
        $this->db = Conectar::conexion();
    }

    //LISTAR TODOS LOS SERVICIOS
    public function obtenerServicios() {
        $sql = "SELECT * FROM servicios ORDER BY id_servicio DESC"; // Los más nuevos primero
        $resultado = $this->db->query($sql);
        
        $datos = [];
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $datos[] = $row;
            }
        }
        return $datos;
    }

    //AGREGAR NUEVO SERVICIO
    public function agregarServicio($titulo, $descripcion, $ruta_imagen) {
        $sql = "INSERT INTO servicios (titulo, descripcion_servicio, imagen_url, activo) VALUES (?, ?, ?, 1)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $titulo, $descripcion, $ruta_imagen);
        
        return $stmt->execute();
    }

    //ELIMINAR SERVICIO
    public function eliminarServicio($id) {
        // Primero obtenemos la ruta de la imagen para borrar
        $sqlImg = "SELECT imagen_url FROM servicios WHERE id_servicio = ?";
        $stmt = $this->db->prepare($sqlImg);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $fila = $res->fetch_assoc();

        // Borramos el registro de la BD
        $sql = "DELETE FROM servicios WHERE id_servicio = ?";
        $stmtDelete = $this->db->prepare($sql);
        $stmtDelete->bind_param("i", $id);
        
        if ($stmtDelete->execute()) {
            // Si se borró de la BD, devolvemos la ruta de la imagen para que el controlador la borre
            return $fila['imagen_url']; 
        }
        return false;
    }
}
?>