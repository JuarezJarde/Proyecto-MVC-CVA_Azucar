<?php
session_start();
require_once '../modelos/ModeloDepartamentos.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $prefijo = trim($_POST['prefijo']);
    $sufijo = trim($_POST['sufijo']);

    $modelo = new ModeloDepartamentos();
    $resultado = $modelo->agregarDepartamento($nombre, $prefijo, $sufijo);

    if ($resultado == "exito") {
        header("Location: panel.php?msg=depto_ok&tab=codigos");
    } elseif ($resultado == "duplicado") {

        header("Location: panel.php?msg=error_duplicado&tab=codigos");
    } else {
        header("Location: panel.php?msg=error&tab=codigos");
    }
}
?>