<?php
session_start();
require_once '../modelos/ModeloUsuarios.php';

// Seguridad: SOLO SuperUsuario (ID 1)
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: panel.php"); // Lo devolvemos al panel si no es Super
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_usuario = $_POST['id_usuario'];
    $nuevo_rol = $_POST['nuevo_rol'];

    $modelo = new ModeloUsuarios();
    
    if ($modelo->cambiarRolUsuario($id_usuario, $nuevo_rol)) {
        header("Location: panel.php?msg=rol_cambiado&tab=roles");
    } else {
        header("Location: panel.php?msg=error&tab=roles");
    }

} else {
    header("Location: panel.php");
}
?>