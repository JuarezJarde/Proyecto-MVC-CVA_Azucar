<?php
session_start();
require_once '../modelos/ModeloUsuarios.php';

// Seguridad
if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2)) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_usuario = $_POST['id_usuario'];
    $estado_actual = $_POST['estado_actual'];
    
    // Invertimos el estado
    $nuevo_estado = ($estado_actual == 'activo') ? 'inactivo' : 'activo';

    $modelo = new ModeloUsuarios();
    
    if ($modelo->cambiarEstadoUsuario($id_usuario, $nuevo_estado)) {
        header("Location: panel.php?msg=estado_cambiado&tab=usuarios");
    } else {
        header("Location: panel.php?msg=error&tab=usuarios");
    }

} else {
    header("Location: panel.php");
}
?>