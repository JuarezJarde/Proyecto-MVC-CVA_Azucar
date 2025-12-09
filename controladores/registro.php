<?php
require_once '../modelos/ModeloUsuarios.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //OBTENER DATOS
    $nombre = $_POST['nombre_completo'];
    $correo = $_POST['email'];
    $pass_original = $_POST['password'];
    $pass_confirm = $_POST['password_confirm'];

    //VALIDAR QUE COINCIDAN
    if ($pass_original !== $pass_confirm) {
        header("Location: ../index.php?msg=pass_no_coincide");
        exit(); 
    }

    // ============================================================
    //VALIDACIÓN DE SEGURIDAD
    // ============================================================
    
    // CAMBIA ESTO A 'false' PARA QUTIAR LA VALIDACIONES POR QUE ME DAN PEREZA
    $activar_seguridad = true; 

    if ($activar_seguridad) {
        //Longitud mínima de 8 caracteres
        if (strlen($pass_original) < 8) {
            header("Location: ../index.php?msg=pass_muy_corta");
            exit();
        }

        //Debe tener al menos un número
        if (!preg_match("#[0-9]+#", $pass_original)) {
            header("Location: ../index.php?msg=pass_sin_numero");
            exit();
        }
        //Aqui se ponen mas validaciones si quieren pero me da pereza
    }
    // ============================================================


    $modelo = new ModeloUsuarios();

    //VERIFICAR DUPLICADOS
    if ($modelo->existeEnUsuarios($correo)) {
        header("Location: ../index.php?msg=usuario_existe");
    
    } elseif ($modelo->existeEnSolicitudes($correo)) {
        header("Location: ../index.php?msg=solicitud_existe");
    
    } else {
        // Encriptamos la contraseña validada
        $pass_encriptada = password_hash($pass_original, PASSWORD_DEFAULT);

        if ($modelo->registrarSolicitud($nombre, $correo, $pass_encriptada)) {
            header("Location: ../index.php?msg=registro_exito");
        } else {
            header("Location: ../index.php?msg=error_registro");
        }
    }

} else {
    header("Location: ../index.php");
}
?>