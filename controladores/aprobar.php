<?php
session_start();
require_once '../modelos/ModeloUsuarios.php';

// Seguridad
if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2)) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $accion = $_POST['accion']; // 'aprobar' o 'rechazar'
    $id_solicitud = $_POST['id_solicitud'];
    
    $modelo = new ModeloUsuarios();

    if ($accion == 'aprobar') {
        $id_rol = $_POST['id_rol_asignar'];
        
        if ($modelo->aprobarUsuario($id_solicitud, $id_rol)) {
            // Éxito con alerta bonita
            header("Location: panel.php?msg=aprobado&tab=usuarios");
        } else {
            header("Location: panel.php?msg=error&tab=usuarios");
        }

    } elseif ($accion == 'rechazar') {
        
        if ($modelo->rechazarSolicitud($id_solicitud)) {
            header("Location: panel.php?msg=rechazado&tab=usuarios");
        } else {
            header("Location: panel.php?msg=error&tab=usuarios");
        }
    }
} else {
    // Si intentan entrar directo por URL
    header("Location: panel.php");
}
?>