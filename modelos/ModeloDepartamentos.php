<?php
require_once __DIR__ . '/../db/db.php';

class ModeloDepartamentos {
    private $db;

    public function __construct() {
        $this->db = Conectar::conexion();
    }

    public function obtenerDepartamentos() {
        $sql = "SELECT * FROM config_departamentos WHERE estatus = 1";
        $res = $this->db->query($sql);
        $datos = [];
        while ($row = $res->fetch_assoc()) $datos[] = $row;
        return $datos;
    }

    public function existeDepartamento($nombre, $prefijo) {
        $sql = "SELECT id_departamento FROM config_departamentos WHERE nombre_departamento = ? OR prefijo = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $nombre, $prefijo);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0; // Devuelve TRUE si ya existe
    }

    public function agregarDepartamento($nombre, $prefijo, $sufijo) {
        if ($this->existeDepartamento($nombre, $prefijo)) {
            return "duplicado";
        }

        $sql = "INSERT INTO config_departamentos (nombre_departamento, prefijo, sufijo) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $nombre, strtoupper($prefijo), strtoupper($sufijo));
        
        if ($stmt->execute()) {
            return "exito";
        } else {
            return "error";
        }
    }

    // Busca los datos de un departamento específico para generar el código
    public function obtenerPrefijos($nombre_departamento) {
        $sql = "SELECT prefijo, sufijo FROM config_departamentos WHERE nombre_departamento = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $nombre_departamento);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>