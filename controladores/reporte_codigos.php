<?php
require_once '../modelos/ModeloCodigos.php';

$mes = $_GET['mes'] ?? '';
$depto = $_GET['departamento'] ?? '';

$modelo = new ModeloCodigos();
$datos = $modelo->obtenerCodigosFiltrados($mes, $depto);

// Forzar descarga de Excel
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Reporte_Codigos_$mes.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1'>";
echo "<tr style='background:#66AC4C; color:white;'>
        <th>Código</th><th>Formato</th><th>Departamento</th><th>Fecha</th>
      </tr>";

foreach ($datos as $d) {
    echo "<tr>
            <td>{$d['codigo_completo']}</td>
            <td>{$d['nombre_formato']}</td>
            <td>{$d['modulo_sistema']}</td>
            <td>{$d['fecha_creacion']}</td>
          </tr>";
}
echo "</table>";
?>