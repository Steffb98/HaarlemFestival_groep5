<?php

class Session
{
  function __construct()
  {

  }
  Function addToCart($name,$price,$amount,$location,$date,$time,$id,$specialtext,$type)
  {
    $price = preg_replace("/[^0-9\,]/", "", $price);
    $newPrice= (float) $price;
    //if the session is empty or unset make the session
    if(!isset($_SESSION['products']) || empty($_SESSION['products']) )
    {
			  $_SESSION['products'] = array();
		}

      $newCartItems = array('name' => $name,'price' =>$newPrice, 'amount' => $amount, 'location' => $location, 'date' => $date,'time' => $time, 'id' => $id, 'specialText' => $specialtext, 'type' => $type);
      array_push($_SESSION['products'], $newCartItems);
  }
}
?>
