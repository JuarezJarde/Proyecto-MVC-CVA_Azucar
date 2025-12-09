<?php
session_start();
require_once '../modelos/ModeloCodigos.php';

// Seguridad: Solo SuperUsuarioy Administrador
if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2)) {
    header("Location: panel.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recogemos los datos del formulario
    $nombre_formato = $_POST['nombre_formato'];
    $modulo = $_POST['modulo'];

    $modelo = new ModeloCodigos();


    if ($modelo->generarYGuardarCodigo($nombre_formato, $modulo)) {

        header("Location: panel.php?msg=codigo_creado&tab=codigos");
    } else {

        header("Location: panel.php?msg=error&tab=codigos");
    }

} else {
    // Si intentan entrar directo sin POST
    header("Location: panel.php");
}
?>