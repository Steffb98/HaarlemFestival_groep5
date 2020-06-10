<?php
session_start();
require ('fpdf.php');
require_once ('../Controller/UserController.php');
$object = new UserController();
$pdf = new FPDF();

$userID = $_SESSION['User_ID'];
$results = $object->GetTicketsWithUserID($userID);

foreach($results as $result)
{
$pdf -> AddPage();

$pdf->SetLineWidth(0.5);
$pdf->Rect(10, 20, 180, 85);

$pdf -> SetXY(10, 10);
$pdf -> SetFont('Arial', 'B', 20);
$pdf -> Cell(40, 10, 'Haarlem Festival');

$pdf -> SetXY(10, 20);
$pdf -> SetFont('Arial', '', 18);
$pdf -> Cell(40, 10, $result->GetName());

$pdf -> SetXY(10, 30);
$pdf -> SetFont('Arial', 'B', 16);
$pdf -> Cell(40, 10, 'Date:');

$pdf -> SetXY(10, 35);
$pdf -> SetFont('Arial', '', 12);
$pdf -> Cell(40, 10, date('d-m-Y', strtotime($result->getStartTime())));

$pdf -> SetXY(10, 45);
$pdf -> SetFont('Arial', 'B', 16);
$pdf -> Cell(40, 10, 'Start Time:');

$pdf -> SetXY(10, 50);
$pdf -> SetFont('Arial', '', 12);
$pdf -> Cell(40, 10, date('H:i', strtotime($result->getStartTime())));

$pdf -> SetXY(10, 60);
$pdf -> SetFont('Arial', 'B', 16);
$pdf -> Cell(40, 10, 'End Time:');

$pdf -> SetXY(10, 65);
$pdf -> SetFont('Arial', '', 12);
$pdf -> Cell(40, 10, date('H:i', strtotime($result->getEndTime())));

$loc = explode(",", $result->getAddress());
$address = $loc[1];
$postalCode = $loc[2];
$city = $loc[3];

$pdf -> SetXY(10, 75);
$pdf -> SetFont('Arial', 'B', 16);
$pdf -> Cell(40, 10, 'Location:');

$pdf -> SetXY(10, 80);
$pdf -> SetFont('Arial', '', 12);
$pdf -> Cell(40, 10, $result->getVenue());

$pdf -> SetXY(10, 85);
$pdf -> SetFont('Arial', '', 12);
$pdf -> Cell(40, 10, $address);

$pdf -> SetXY(10, 90);
$pdf -> SetFont('Arial', '', 12);
$pdf -> Cell(40, 10, $postalCode . ' ' . $city);

$pdf -> SetXY(80, 30);
$pdf -> SetFont('Arial', 'B', 16);
$pdf -> Cell(40, 10, 'Customer ID:');

$pdf -> SetXY(80, 35);
$pdf -> SetFont('Arial', '', 12);
$pdf -> Cell(40, 10, $userID);

$pdf -> SetXY(80, 45);
$pdf -> SetFont('Arial', 'B', 16);
$pdf -> Cell(40, 10, 'Name:');

$pdf -> SetXY(80, 50);
$pdf -> SetFont('Arial', '', 12);
$pdf -> Cell(40, 10, $result->getUser()->getFirstName() . ' ' . $result->getUser()->getLastName());

$pdf -> SetXY(140, 45);
$pdf -> SetFont('Arial', 'B', 12);
$pdf -> Cell(40, 10, 'Amount of tickets');

$pdf -> SetXY(140, 50);
$pdf -> SetFont('Arial', '', 10);
$pdf -> Cell(40, 10, $result->getAmountOfTickets());

$pdf -> SetXY(80, 60);
$pdf -> SetFont('Arial', 'B', 16);
$pdf -> Cell(40, 10, 'TicketID:');

$pdf -> SetXY(80, 65);
$pdf -> SetFont('Arial', '', 12);
$pdf -> Cell(40, 10, $result->getOrderID());

$pdf -> SetXY(140, 30);
$pdf -> SetFont('Arial', 'B', 12);
$pdf -> Cell(40, 10, 'Price:');

$pdf -> SetXY(140, 35);
$pdf -> SetFont('Arial', '', 10);
$pdf -> Cell (40, 10, $result->getTotalPrice() . ' euro');


$img = "../Assets/HaarlemFestivalLogo.png";
$pdf->image($img, 150, 60, 50);

$img2 = "../Assets/Share_with_Care.png";
$pdf->image($img2, 10, 110, 85);

$img3 = "../Assets/Haarlem.jpeg";
$pdf->image($img3, 10, 156, 85);

$img4 = "../Assets/cafeBrinkman.png";
$pdf->image($img4, 100, 110, 100);

$pdf-> SetXY (10, 210);
$pdf -> SetFont('Arial', '', 8);
$pdf -> Cell(40, 10, 'Op de overeenkomst met betrekking tot dit toegangsbewijs zijn de algemene');
$pdf -> SetXY(10, 215);
$pdf ->Cell(40, 10, 'voorwaarden van het Haarlem Festival van toepassing. De organisator zal op verzoek');
$pdf -> SetXY(10, 220);
$pdf -> Cell(40, 10, 'de tekst van al zijn algemene voorwaarden ter hand stellen');
$pdf -> SetXY(10, 230);
$pdf -> Cell(40, 10, 'Verder is bovendien het volgende bepaald:');
$pdf -> SetXY(10, 235);
$pdf -> Cell(40, 10, '- Dit toegangsbewijs is en blijft eigendom van de organisator. De organisator');
$pdf -> SetXY(10, 240);
$pdf -> Cell(40, 10, 'kan doorverkoop of anderszins commercieel gebruik van het toegangsbewijs verbieden');
$pdf -> Setxy(10, 245);
$pdf -> Cell(40, 10, '- Alleen de houder die bij de entree als eerste een toegangsbewijs met een');
$pdf -> SetXY(10, 250);
$pdf -> Cell(40, 10, 'geldige barcode toont, krijgt toegang tot het evenement.');
$pdf -> SetXY(10, 255);
$pdf -> Cell(40, 10, '- De organisator heeft het recht het evenement te verplaatsen of te annuleren');
$pdf -> SetXY(10, 260);
$pdf -> Cell(40, 10, 'Je bent gebonden aan de huisregels van de organisator en de locatie');
$pdf -> SetXY(10, 265);
$pdf -> Cell(40, 10, 'waar het evenement plaat svindt');
}
$pdf -> Output('I');
?>                                                                                                                                                                               
