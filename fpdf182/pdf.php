<?php
session_start();
require ('../pdf/fpdf.php');
require_once '../Controller/orderController.php';
$object = new orderController();
$result = $object->get_allOrders($_SESSION['id']);
$name = $object->get_name($_SESSION['id']);

//get info for the right pdf that belongs to the drawing
$price = $_POST['price'];
$amount = $_POST['amount'];
$vat = $_POST['vat'];
$namePic = $_POST['name'];
$img = $_POST['img'];

while($row = mysqli_fetch_assoc($result))
{

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetLineWidth(0.5);
$pdf->Rect(10,10,180,85);

$pdf->SetXY(55, 10);
$pdf->SetFont('courier', 'B', 16);
$pdf->Cell(40,10,'Drawings by Kimberly van Gelder');

$pdf->SetFont('courier','B', 12);
$pdf->SetXY(10, 25);
$pdf->Cell(40,10, 'Nederland');

//$pdf->Ln();
$pdf->SetXY(10, 30);
$pdf->SetFont('courier', 'B', 10);
$pdf->Cell(40,10, 'Noord-Holland');

$pdf->SetXY(10, 35);
$pdf->Cell(40,10, 'Ergens in de buurt van Haarlem');

$pdf->SetXY(80, 25);
$pdf->SetFont('courier', 'B', 12);
$pdf->Cell(40,10, 'UserID');

$pdf->Ln();
$pdf->SetXY(80, 30);
$pdf->SetFont('courier', '', 10);
$pdf->Cell(40,10, $_SESSION['id']);

$pdf->SetXY(80, 40);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40,10, 'User name');

$pdf->SetXY(80, 45);
$pdf->SetFont('courier', '', 10);
$pdf->Cell(40,10, $name['naam']);

$pdf->SetXY(80, 60);
$pdf->SetFont('courier', 'B', 10);
$pdf->Cell(40,10, 'Organisator: Kimberly B.V.');

$pdf->SetXY(80, 75);
$pdf->SetFont('courier', 'B', 10);
$pdf->Cell(40,10, 'Opend Always');

$pdf->SetXY(80, 80);
$pdf->SetFont('courier', 'B', 10);
$pdf->Cell(40,10, 'Meer info: www.565459.infhaarlem.nl');

$pdf->SetXY(80, 85);
$pdf->SetFont('courier', 'B', 10);
$pdf->Cell(40,10, 'De best drawings in de world');

$pdf->SetXY(140, 30);
$pdf->SetFont('courier', 'B', 10);
$pdf->Cell(40,10, 'Price for the order:');

$pdf->SetXY(140, 35);
$pdf->SetFont('courier', '', 10);
$pdf->Cell(40,10, number_format($price,2));

$pdf->SetXY(140, 40);
$pdf->SetFont('courier', 'B', 10);
$pdf->Cell(40,10, 'VAT:');

$pdf->SetXY(140, 45);
$pdf->SetFont('courier', '', 10);
$pdf->Cell(40,10, number_format($vat,2));

$pdf->SetXY(140, 50);
$pdf->SetFont('courier', 'B', 10);
$pdf->Cell(40,10, 'Amount:');

$pdf->SetXY(140, 55);
$pdf->SetFont('courier', '', 10);
$pdf->Cell(40,10, $amount);

$pdf->SetXY(95, 100);
$pdf->SetFont('courier', 'B', 16);
$pdf->Cell(40,10, $namePic);

$pdf->image($img, 35, 120, 150);

}
$pdf->Output('I');
 ?>
