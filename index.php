<?php
session_start();

require_once 'modelos/ModeloServicios.php';
require_once 'modelos/ModeloConfiguracion.php';

// intanciamos y pedimos
$modeloServicios = new ModeloServicios();
$lista_servicios_publicos = $modeloServicios->obtenerServicios();

$modeloConfig = new ModeloConfiguracion();
$config = $modeloConfig->obtenerConfiguracion();

//Cargar la Vista
// La vista 'home_vista.php' ahora tendrá disponible la variable $lista_servicios_publicos
include 'vistas/home_vista.php';
?>