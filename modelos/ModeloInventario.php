<?php
require_once __DIR__ . '/../db/db.php';

class ModeloInventario {
    private $db;

    public function __construct() {
        $this->db = Conectar::conexion();
    }

    //LISTAR INVENTARIO
    public function obtenerInventario() {
        $sql = "SELECT * FROM inventario ORDER BY id_producto DESC";
        $resultado = $this->db->query($sql);
        
        $datos = [];
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $datos[] = $row;
            }
        }
        return $datos;
    }

    //AGREGAR PRODUCTO
    public function agregarProducto($codigo, $nombre, $cantidad, $unidad) {
        $sql = "INSERT INTO inventario (codigo_producto, nombre_producto, cantidad_stock, unidad_medida) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        // 'ssds' significa String, String, Decimal/Double, String
        $stmt->bind_param("ssds", $codigo, $nombre, $cantidad, $unidad);
        
        return $stmt->execute();
    }

    //ELIMINAR PRODUCTO
    public function eliminarProducto($id) {
        $sql = "DELETE FROM inventario WHERE id_producto = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
}
?>