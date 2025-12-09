<?php
session_start();
require_once '../modelos/ModeloServicios.php';

// Seguridad: Solo Admins
if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2)) {
    header("Location: panel.php");
    exit();
}

$modelo = new ModeloServicios();

// ----------------AGREGAR SERVICIO----------------
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion']) && $_POST['accion'] == 'crear') {
    
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    
    // Mamejo de la IMAGEN
    $nombre_archivo = $_FILES['imagen']['name'];
    $temporal = $_FILES['imagen']['tmp_name'];
    
    // Ruta donde se guardará FÍSICAMENTE en el servidor
    // __DIR__ es la carpeta controladores. Salimos (..) y entramos a Assets/Images/servicios/
    $carpeta_destino = __DIR__ . '/../Assets/Images/servicios/';
    
    // Crear carpeta si no existe
    if (!file_exists($carpeta_destino)) {
        mkdir($carpeta_destino, 0777, true);
    }

    // Generamos un nombre único para evitar que se sobrescriban fotos (ej: 17823_caña.jpg)
    $nuevo_nombre = time() . "_" . basename($nombre_archivo);
    $ruta_fisica = $carpeta_destino . $nuevo_nombre;
    
    // Ruta que guardaremos en la BASE DE DATOS (Relativa para HTML)
    $ruta_db = "../Assets/Images/servicios/" . $nuevo_nombre;

    if (move_uploaded_file($temporal, $ruta_fisica)) {
        // Si la imagen subió bien, guardamos en BD
        if ($modelo->agregarServicio($titulo, $descripcion, $ruta_db)) {
            header("Location: panel.php?msg=servicio_creado&tab=servicios");
        } else {
            header("Location: panel.php?msg=error&tab=servicios");
        }
    } else {
        header("Location: panel.php?msg=error_imagen&tab=servicios");
    }
}

// --------------------ELIMINAR SERVICIO----------------------
if (isset($_GET['accion']) && $_GET['accion'] == 'eliminar') {
    $id = $_GET['id'];
    
    // El modelo devuelve la ruta de la imagen si borró bien
    $ruta_imagen = $modelo->eliminarServicio($id);
    
    if ($ruta_imagen) {
        // Borrar el archivo físico para no llenar el servidor de basura
        // Convertimos la ruta relativa DB (../Assets...) en ruta absoluta del sistema
        $archivo_a_borrar = __DIR__ . '/' . $ruta_imagen;
        if (file_exists($archivo_a_borrar)) {
            unlink($archivo_a_borrar);
        }
        header("Location: panel.php?msg=servicio_eliminado&tab=servicios");
    } else {
        header("Location: panel.php?msg=error&tab=servicios");
    }
}
?>