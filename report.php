<?php
include('fpdf186/fpdf.php');

$fpdf = new FPDF('P', 'mm', 'A4');

$fpdf->AddPage();

$fpdf->SetFont('Arial', 'B', 20);

//cell(width, height, text, border,end lie, align)
$fpdf->Cell(71, 10, '', 0, 0);
$fpdf->Cell(59, 5, 'Student List', 0, 0);
$fpdf->Cell(59, 10, '', 0, 1);

$fpdf->Cell(71, 10, '', 0, 1);
$fpdf->Cell(59, 5, 'Student List', 0, 0);
$fpdf->Cell(59, 10, '', 0, 1);
$fpdf->Output();
