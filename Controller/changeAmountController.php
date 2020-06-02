<?php
session_start();
$id = $_GET['id'];
$amount= $_GET['amount'];
$value = $_GET['value'];
$newCartItemsTotal = array();

 if($value =='min' && ($amount == 1 || $amount < 1) || $value == 'plus' && ($amount == 10 || $amount > 10))
 {
   header("Location:../View/cartView.php?error=limit");
 }
 else
 {
   foreach($_SESSION['products'] as $cart)
   {
    //if the id is equal to the id in the cart then change amount
     if($cart['id'] == $id)
     {
       //deduct 1 if it is min
       if($value == 'min')
       {
          $amount= $amount - 1;
       }
       //add 1 if it is plus
       else if($value == 'plus')
       {
         $amount= $amount + 1;
       }
       $cart['amount'] = (string)$amount;

     }
     //put everything back in the cart
     $newCartItems = array('name' => $cart['name'],'price' =>$cart['price'], 'amount' => $cart['amount'], 'location' => $cart['location'], 'date' => $cart['date'],'time' => $cart['time'], 'id' => $cart['id'], 'specialText' => $cart['specialText'], 'type' => $cart['type']);
     array_push($newCartItemsTotal, $newCartItems);


   }
   $_SESSION['products'] = $newCartItemsTotal;
   header("Location:../View/cartView.php");
 }
?>
