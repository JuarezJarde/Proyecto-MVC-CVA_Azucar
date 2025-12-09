<?php
require_once __DIR__ . '/../db/db.php';; 

class ModeloUsuarios {
    private $db;

    public function __construct() {
        $this->db = Conectar::conexion();
    }

    //FUNCIONES DE VALIDACIÓN Y REGISTRO ---
    public function existeEnUsuarios($correo) {
        $sql = "SELECT * FROM usuarios WHERE correo = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function existeEnSolicitudes($correo) {
        $sql = "SELECT * FROM solicitudes_registro WHERE correo = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function registrarSolicitud($nombre, $correo, $password) {
        $sql = "INSERT INTO solicitudes_registro (nombre_completo, correo, password, estado) VALUES (?, ?, ?, 'pendiente')";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $nombre, $correo, $password);
        return $stmt->execute();
    }

    public function obtenerUsuarioPorCorreo($correo) {
        $sql = "SELECT * FROM usuarios WHERE correo = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    //FUNCIONES DE CONTEO (DASHBOARD) ---
    public function contarUsuariosActivos() {
        $sql = "SELECT COUNT(*) as total FROM usuarios WHERE estatus = 'activo'";
        $resultado = $this->db->query($sql);
        return $resultado ? $resultado->fetch_assoc()['total'] : 0;
    }

    public function contarSolicitudesPendientes() {
        $sql = "SELECT COUNT(*) as total FROM solicitudes_registro WHERE estado = 'pendiente'";
        $resultado = $this->db->query($sql);
        return $resultado ? $resultado->fetch_assoc()['total'] : 0;
    }

    public function contarInventario() {
        $sql = "SELECT SUM(cantidad_stock) as total FROM inventario"; 
        $resultado = $this->db->query($sql);
        if ($resultado) {
            $fila = $resultado->fetch_assoc();
            return $fila['total'] ? $fila['total'] : 0;
        }
        return 0;
    }

    //FUNCIONES DE LISTADO (TABLAS) ---

    //Lista de espera
    public function obtenerSolicitudesPendientes() {
        $sql = "SELECT * FROM solicitudes_registro WHERE estado = 'pendiente'";
        $resultado = $this->db->query($sql);
        $datos = [];
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $datos[] = $row;
            }
        }
        return $datos;
    }

    //Lista de Usuarios (Para verlos y bloquearlos)
    public function obtenerUsuariosConRoles($mi_id) {
        $sql = "SELECT usuarios.*, roles.nombre_rol 
                FROM usuarios 
                JOIN roles ON usuarios.id_rol = roles.id_rol 
                WHERE id_usuario != ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $mi_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $datos = [];
        while ($row = $resultado->fetch_assoc()) {
            $datos[] = $row;
        }
        return $datos;
    }

    //Servicios
    public function obtenerServicios() {
        $sql = "SELECT * FROM servicios";
        $resultado = $this->db->query($sql);
        $datos = [];
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $datos[] = $row;
            }
        }
        return $datos;
    }
    
    //Usuarios para Gestión de Roles
    public function obtenerUsuariosParaRoles($mi_id) {
        $sql = "SELECT u.*, r.nombre_rol 
                FROM usuarios u
                JOIN roles r ON u.id_rol = r.id_rol
                WHERE u.id_usuario != ? AND u.estatus = 'activo'";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $mi_id);
        $stmt->execute();
        $res = $stmt->get_result();
        
        $datos = [];
        while ($row = $res->fetch_assoc()) {
            $datos[] = $row;
        }
        return $datos;
    }

    //FUNCIONES DE ACCIÓN (ADMINISTRADOR) ---

    //APROBAR USUARIO
    public function aprobarUsuario($id_solicitud, $id_rol_asignar) {
        //Obtener datos de la solicitud
        $sqlGet = "SELECT * FROM solicitudes_registro WHERE id_solicitud = ?";
        $stmtGet = $this->db->prepare($sqlGet);
        $stmtGet->bind_param("i", $id_solicitud);
        $stmtGet->execute();
        $res = $stmtGet->get_result();

        if ($res->num_rows > 0) {
            $datos = $res->fetch_assoc();
            

            $sqlInsert = "INSERT INTO usuarios (nombre_usuario, nombre_completo, correo, password, id_rol, estatus, fecha_registro) 
              VALUES (?, ?, ?, ?, ?, 'activo', NOW())";
            $stmtInsert = $this->db->prepare($sqlInsert);
            $stmtInsert->bind_param("ssssi", 
                $datos['correo'],           // nombre_usuario
                $datos['nombre_completo'],  // nombre_completo
                $datos['correo'],           // correo
                $datos['password'],         // password
                $id_rol_asignar             // id_rol
            );
            
            if ($stmtInsert->execute()) {
                //Si se creó bien, se borra la solicitud
                $this->rechazarSolicitud($id_solicitud);
                return true;
            }
        }
        return false;
    }

    //RECHAZAR SOLICITUD (Eliminar de la lista de espera)
    public function rechazarSolicitud($id_solicitud) {
        $sql = "DELETE FROM solicitudes_registro WHERE id_solicitud = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_solicitud);
        return $stmt->execute();
    }

    //CAMBIAR ESTADO (Bloquear / Activar)
    public function cambiarEstadoUsuario($id_usuario, $nuevo_estado) {
        $sql = "UPDATE usuarios SET estatus = ? WHERE id_usuario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("si", $nuevo_estado, $id_usuario);
        return $stmt->execute();
    }

    //CAMBIAR ROL (Ascender / Degradar)
    public function cambiarRolUsuario($id_usuario, $nuevo_rol) {
        $sql = "UPDATE usuarios SET id_rol = ? WHERE id_usuario = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $nuevo_rol, $id_usuario);
        return $stmt->execute();
    }
    //REPORTES Y ESTADÍSTICAS
    public function obtenerUsuariosPorMes() {
        // Esta consulta agrupa por Mes y Año y cuenta cuántos hay
        $sql = "SELECT 
                    MONTHNAME(fecha_registro) as mes, 
                    MONTH(fecha_registro) as numero_mes,
                    COUNT(*) as total 
                FROM usuarios 
                WHERE estatus = 'activo'
                GROUP BY YEAR(fecha_registro), MONTH(fecha_registro)
                ORDER BY fecha_registro ASC";
        
        $resultado = $this->db->query($sql);
        $datos = [];
        while ($row = $resultado->fetch_assoc()) {
            $datos[] = $row;
        }
        return $datos;
    }
}
?>