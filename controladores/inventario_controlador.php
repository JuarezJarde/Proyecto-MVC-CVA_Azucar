<?php
session_start();
require_once '../modelos/ModeloInventario.php';

// Seguridad
if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2)) {
    header("Location: panel.php");
    exit();
}

$modelo = new ModeloInventario();

// ---AGREGAR PRODUCTO---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion']) && $_POST['accion'] == 'crear') {
    
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $unidad = $_POST['unidad']; // Kg, Sacos, Toneladas

    if ($modelo->agregarProducto($codigo, $nombre, $cantidad, $unidad)) {
        header("Location: panel.php?msg=producto_creado&tab=inventario");
        exit();
    } else {
        header("Location: panel.php?msg=error&tab=inventario");
        exit();
    }
}

// ---ELIMINAR PRODUCTO ---
if (isset($_GET['accion']) && $_GET['accion'] == 'eliminar') {
    $id = $_GET['id'];
    
    if ($modelo->eliminarProducto($id)) {
        header("Location: panel.php?msg=producto_eliminado&tab=inventario");
        exit();
    } else {
        header("Location: panel.php?msg=error&tab=inventario");
        exit();
    }
}

// ---SEGURIDAD ---
header("Location: panel.php?msg=error_accion_no_detectada&tab=inventario");
exit();
?>