<?php

$image1 = "HaarlemFestivalLogo.png";
$image2 = "LegoWorldUtrecht.jpg";
$image3 = "ShareWithCare.png";
$image4 = "anotherImage.jpg";

require('fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetLineWidth(0.5);
$pdf->Rect(10, 20, 180, 85);
$pdf->Image($image1, 153, 3, 50);


$pdf->SetXY(14,30);
$pdf->SetFont('Arial', '', 24);
$pdf->Cell(0,0,'Haarlem Festival Ticket');

$pdf->SetXY(14,40);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0,0,'Customer Id');
$pdf->SetXY(14,45);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0,0,'123984');

$pdf->SetXY(14,53);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0,0,'Customer Name');
$pdf->SetXY(14,58);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0,0,'Theo de Vries');

$pdf->SetXY(14,53);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0,0,'Ticket Number');
$pdf->SetXY(14,58);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0,0,'Theo de Vries');

$pdf->Output();


?>
