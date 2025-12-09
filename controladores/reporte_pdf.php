<?php
require('fpdf/fpdf.php');
require_once '../modelos/ModeloUsuarios.php';

class PDF extends FPDF {
    // Cabecera de página
    function Header() {
        $this->SetFont('Arial','B',14);
        // Título
        $this->Cell(0,10, mb_convert_encoding('Reporte de Usuarios Registrados', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $this->Ln(5);
        
        // Encabezados de tabla
        $this->SetFont('Arial','B',10);
        $this->SetFillColor(102, 172, 76); // Color #66AC4C
        $this->SetTextColor(255); // Blanco
        
        $this->Cell(10, 10, 'ID', 1, 0, 'C', true);
        $this->Cell(60, 10, 'Nombre', 1, 0, 'C', true);
        $this->Cell(60, 10, 'Correo', 1, 0, 'C', true);
        $this->Cell(30, 10, 'Rol', 1, 0, 'C', true);
        $this->Cell(30, 10, 'Fecha', 1, 1, 'C', true); // El 1 final hace salto de línea
    }

    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10, 'Pagina '.$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}

// Creación del objeto PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0); // Negro

// Obtener datos
$modelo = new ModeloUsuarios();
$lista = $modelo->obtenerUsuariosConRoles(0);

foreach ($lista as $u) {
    $pdf->Cell(10, 10, $u['id_usuario'], 1);
    $pdf->Cell(60, 10, mb_convert_encoding($u['nombre_completo'], 'ISO-8859-1', 'UTF-8'), 1);
    $pdf->Cell(60, 10, $u['correo'], 1);
    $pdf->Cell(30, 10, mb_convert_encoding($u['nombre_rol'], 'ISO-8859-1', 'UTF-8'), 1);
    
    // Fecha (si no existe, ponemos hoy)
    $fecha = isset($u['fecha_registro']) ? date('d/m/Y', strtotime($u['fecha_registro'])) : date('d/m/Y');
    $pdf->Cell(30, 10, $fecha, 1, 1);
}

$pdf->Output();
?>