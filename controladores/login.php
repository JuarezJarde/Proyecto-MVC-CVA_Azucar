<?php
session_start();
require_once '../modelos/ModeloUsuarios.php';
require_once '../modelos/ModeloAuditoria.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $correo = $_POST['email']; 
    $password_ingresada = $_POST['password'];

    $modelo = new ModeloUsuarios();
    $usuario = $modelo->obtenerUsuarioPorCorreo($correo);

    if ($usuario) {
        // Verificar contraseña
        if (password_verify($password_ingresada, $usuario['password'])) {
            
            // Verificar estado
            if ($usuario['estatus'] == 'activo') {
                
                //LOGIN CORRECTO
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nombre'] = $usuario['nombre_completo']; // o nombre_usuario
                $_SESSION['rol'] = $usuario['id_rol'];

                $audit = new ModeloAuditoria();
                $audit->registrarAccion($usuario['nombre_completo'], "Login Exitoso", "Inicio de sesión desde IP: " . $_SERVER['REMOTE_ADDR']);
                header("Location: panel.php"); 
                exit();

            } else {
                // Usuario existe pero está BLOQUEADO o INACTIVO
                header("Location: ../index.php?msg=usuario_inactivo");
                exit();
            }

        } else {
            // Contraseña incorrecta
            header("Location: ../index.php?msg=login_fallido");
            exit();
        }

    } else {
        // Correo no encontrado
        header("Location: ../index.php?msg=email_no_encontrado");
        exit();
    }
} else {
    header("Location: ../index.php");
}
?>