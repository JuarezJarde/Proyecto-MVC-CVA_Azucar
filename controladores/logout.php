<?php
session_start();
require_once '../modelos/ModeloAuditoria.php'; // <--- Importante

// --- AUDITORÍA ---
if(isset($_SESSION['nombre'])){
    $audit = new ModeloAuditoria();
    $audit->registrarAccion($_SESSION['nombre'], "Logout", "Cierre de sesión correcto.");
}
// -----------------

session_unset();
session_destroy();
header("Location: ../index.php");
exit();
?>