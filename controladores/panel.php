<?php
session_start();
require_once '../modelos/ModeloUsuarios.php';
require_once '../modelos/ModeloServicios.php';
require_once '../modelos/ModeloInventario.php';
require_once '../modelos/ModeloConfiguracion.php';
require_once '../modelos/ModeloAuditoria.php';

//SEGURIDAD
if (!isset($_SESSION['id_usuario'])) {
    header("Location: inicio.php");
    exit();
}

//DATOS DE SESIÓN
$nombre_usuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : "Usuario";
$id_rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : 3;
$id_mi_usuario = $_SESSION['id_usuario'];//para no obtener mi propio ID

//DEFINIR ROL
$rol_usuario = "Usuario";
if ($id_rol == 1) {
    $rol_usuario = "SuperUsuario";
} elseif ($id_rol == 2) {
    $rol_usuario = "Administrador";
}

//pide los datos
$modelo = new ModeloUsuarios();

//estadisticas
$total_usuarios = $modelo->contarUsuariosActivos();
$total_solicitudes = $modelo->contarSolicitudesPendientes();
$total_inventario = $modelo->contarInventario();

//listas
$lista_pendientes = [];
$lista_usuarios = [];
$lista_servicios = [];
$lista_roles = [];
$lista_config = [];
$lista_logs = [];
//se cargan las listas solo si es admin o superusuario
if ($id_rol == 1 || $id_rol == 2) {
    $lista_pendientes = $modelo->obtenerSolicitudesPendientes();
    $lista_usuarios = $modelo->obtenerUsuariosConRoles($id_mi_usuario);
    $lista_servicios = $modelo->obtenerServicios();

    $modeloServicios = new ModeloServicios();
    $lista_servicios = $modeloServicios->obtenerServicios(); // <--- USAR

    $modeloInventario = new ModeloInventario();
    $lista_inventario = $modeloInventario->obtenerInventario();
}

if ($id_rol == 1) {
    $lista_roles = $modelo->obtenerUsuariosParaRoles($id_mi_usuario);
    $modeloConfig = new ModeloConfiguracion();
    $lista_config = $modeloConfig->obtenerConfiguracion();

    $modeloAuditoria = new ModeloAuditoria();
    $lista_logs = $modeloAuditoria->obtenerLogs();
}

//MOSTRAR LA VISTA
require_once '../vistas/admin_vista.php';
?>