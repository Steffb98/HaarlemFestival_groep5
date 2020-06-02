<?php
session_start();
  require_once 'ticketsDBController.php';
  $object = new ticketController();
  $order = $object->orderID();
  //put tickets in database
  foreach($_SESSION['products'] as $cart)
  {
    $result1 = $object->getSessionID($cart['type'],$cart['id'],$cart['date'],$cart['time']);
  	$result = $object->ticketinDB($order['OrderID'],$cart['specialText'],$_SESSION['User_ID'],$_SESSION['TotalPrice'],$cart['amount'],$result1['SessionID'],$cart['type']);
  }
//unset session for the tickets
unset($_SESSION["products"]);
 $Price =  $_POST['totalPrice'];
 $totalPrice = number_format((int)$Price, 2);
 print_r($totalPrice);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once ("mollie/vendor/autoload.php");
require_once ("mollie/examples/functions.php");
/*
 * Initialize the Mollie API library with your API key.
 *
 * See: https://www.mollie.com/dashboard/developers/api-keys
 */
$mollie = new \Mollie\Api\MollieApiClient();
$mollie->setApiKey("test_Ds3fz4U9vNKxzCfVvVHJT2sgW5ECD8");

// print_r($mollie);

$payment = $mollie->payments->create([
    "amount" => [ "currency" => "EUR", "value" => $totalPrice ],
    "description" => "Tickets Haarlem Festival",
    "redirectUrl" => "http://hfteam5.infhaarlem.nl/View/redirectView.php",
    "webhookUrl"  => "http://hfteam5.infhaarlem.nl/Controller/webhook.php",
]);

header("Location: " . $payment->getCheckoutUrl(), true, 303);
?>
