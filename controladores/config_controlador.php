<?php
session_start();
require_once '../modelos/ModeloConfiguracion.php';

// Seguridad: Solo SuperUsuario (Rol ID 1)
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: panel.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $color = $_POST['color'];
    $titulo = $_POST['titulo'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    $modelo = new ModeloConfiguracion();

    if ($modelo->actualizarConfiguracion($color, $titulo, $telefono, $email)) {
        header("Location: panel.php?msg=config_guardada&tab=config-pagina");
    } else {
        header("Location: panel.php?msg=error&tab=config-pagina");
    }

} else {
    header("Location: panel.php");
}
?>