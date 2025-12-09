<?php
// Configurar cabeceras para que el navegador descargue el archivo
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=reporte_usuarios_" . date("Y-m-d") . ".xls");

require_once '../modelos/ModeloUsuarios.php';
$modelo = new ModeloUsuarios();
$lista = $modelo->obtenerUsuariosConRoles(0); // 0 para traer a todos
?>

<table border="1">
    <thead>
        <tr style="background-color: #66AC4C; color: white;">
            <th>ID</th>
            <th>Nombre Completo</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Estatus</th>
            <th>Fecha Registro</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($lista as $u) { ?>
            <tr>
                <td><?php echo $u['id_usuario']; ?></td>
                <td><?php echo mb_convert_encoding($u['nombre_completo'], 'UTF-16LE', 'UTF-8'); ?></td>
                <td><?php echo $u['correo']; ?></td>
                <td><?php echo $u['nombre_rol']; ?></td>
                <td><?php echo $u['estatus']; ?></td>
                <td><?php echo isset($u['fecha_registro']) ? $u['fecha_registro'] : 'N/A'; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>