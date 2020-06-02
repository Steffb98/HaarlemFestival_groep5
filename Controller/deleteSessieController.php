<?php
session_start();
$idTickets = $_GET['id'];
$newCartItemsTotal = array();
foreach($_SESSION['products'] as $cart)
{
  if($cart['id'] == $idTickets)
  {
    //moet niks gebeuren
  }
  else
  {
       $newCartItems = array('name' => $cart['name'],'price' =>$cart['price'], 'amount' => $cart['amount'], 'location' => $cart['location'], 'date' => $cart['date'],'time' => $cart['time'], 'id' => $cart['id'], 'specialText' => $cart['specialText'], 'type' => $cart['type']);
       array_push($newCartItemsTotal, $newCartItems);
  }
}
$_SESSION['products'] = $newCartItemsTotal;
header("Location:../View/cartView.php");

?>
