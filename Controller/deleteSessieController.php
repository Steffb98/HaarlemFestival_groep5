<?php
session_start();
$idTickets = $_GET['id'];
$newCartItemsTotal = array();
$uniqId = md5(uniqId(rand(),1));
foreach($_SESSION['products'] as $cart)
{
  if($cart['uniqid'] == $idTickets)
  {
    //moet niks gebeuren
  }
  else
  {
       $newCartItems = array('uniqid' => $uniqId, 'name' => $cart['name'],'price' =>$cart['price'], 'amount' => $cart['amount'], 'location' => $cart['location'], 'date' => $cart['date'],'time' => $cart['time'], 'id' => $cart['id'], 'specialText' => $cart['specialText'], 'type' => $cart['type']);
       array_push($newCartItemsTotal, $newCartItems);
  }
}
$_SESSION['products'] = $newCartItemsTotal;
header("Location:../View/cartView.php");

?>
