<?php
session_start();
$idTickets = $_GET['id'];
$newCartItemsTotal = array();
foreach($_SESSION['products'] as $cart)
{
  if($cart['uniqid'] == $idTickets)
  {
    //moet niks gebeuren
  }
  else
  {
       array_push($newCartItemsTotal, $cart);
  }
}
$_SESSION['products'] = $newCartItemsTotal;
header("Location:../View/cartView.php");

?>
