<?php
require_once __DIR__ . '/../db/db.php';
require_once 'ModeloDepartamentos.php';

class ModeloCodigos {
    private $db;

    public function __construct() {
        $this->db = Conectar::conexion();
    }

    public function generarYGuardarCodigo($nombre_formato, $nombre_departamento) {
        try {
            //BUSCAR PREFIJO Y SUFIJO EN LA BD
            $modeloDept = new ModeloDepartamentos();
            $datosDept = $modeloDept->obtenerPrefijos($nombre_departamento);

            if (!$datosDept) return false; // Si no existe el departamento

            $prefijo = $datosDept['prefijo'];
            $sufijo = $datosDept['sufijo'];

            //Transacción y Generación
            $this->db->begin_transaction();
            
            $sql = "SELECT MAX(numero_secuencia) as maximo FROM inventario_codigos WHERE prefijo = ? FOR UPDATE";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("s", $prefijo);
            $stmt->execute();
            $fila = $stmt->get_result()->fetch_assoc();

            // Generar nuevo número secuencial
            $nuevoNumero = ($fila['maximo']) ? $fila['maximo'] + 1 : 1;
            //str_pad para rellenar con ceros a la izquierda hasta 4 dígitos
            $codigoGenerado = $prefijo . str_pad($nuevoNumero, 4, "0", STR_PAD_LEFT) . "-" . $sufijo;

            $sqlInsert = "INSERT INTO inventario_codigos (codigo_completo, prefijo, numero_secuencia, sufijo, nombre_formato, modulo_sistema) VALUES (?, ?, ?, ?, ?, ?)";
            $stmtInsert = $this->db->prepare($sqlInsert);
            $stmtInsert->bind_param("ssisss", $codigoGenerado, $prefijo, $nuevoNumero, $sufijo, $nombre_formato, $nombre_departamento);
            
            if ($stmtInsert->execute()) {
                $this->db->commit();
                return true;
            } else {
                $this->db->rollback();
                return false;
            }
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }

    //FUNCIÓN PARA REPORTES Y FILTROS
    public function obtenerCodigosFiltrados($mes = null, $departamento = null) {
        $sql = "SELECT * FROM inventario_codigos WHERE 1=1";
        $tipos = "";
        $params = [];

        // Filtrar por mes
        if (!empty($mes)) {
            $sql .= " AND MONTH(fecha_creacion) = ?";
            $tipos .= "i";
            $params[] = $mes;
        }
        // Filtrar por departamento/modulo
        if (!empty($departamento)) {
            $sql .= " AND modulo_sistema = ?";
            $tipos .= "s";
            $params[] = $departamento;
        }
        // Ordenar por ID descendente
        $sql .= " ORDER BY id_codigo DESC";

        // Preparar consulta dinámica
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($tipos, ...$params);
        }
        
        $stmt->execute();
        $res = $stmt->get_result();
        
        $datos = [];
        while ($row = $res->fetch_assoc()) $datos[] = $row;
        return $datos;
    }
}
?>