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
    $uniqId = md5(uniqId(rand(),1));
    $tempArray = array();
    //if the session is empty or unset make the session
    if(!isset($_SESSION['products']) || empty($_SESSION['products']) )
    {
			  $_SESSION['products'] = array();
        $newCartItems = array('uniqid' => $uniqId,'name' => $name." + ".$id,'price' =>$newPrice, 'amount' => $amount, 'location' => $location, 'date' => $date,'time' => $time, 'id' => $id, 'specialText' => $specialtext, 'type' => $type);
        array_push($tempArray, $newCartItems);

		}else{
      foreach ($_SESSION['products'] as $product ) {

        if($product['id'] == $id){
          $product['amount'] += $amount;
        }else{
          $newCartItems = array('uniqid' => $uniqId,'name' => $name,'price' =>$newPrice, 'amount' => $amount, 'location' => $location, 'date' => $date,'time' => $time, 'id' => $id, 'specialText' => $specialtext, 'type' => $type);
          array_push($tempArray, $newCartItems);
        }

        array_push($tempArray, $product);
      }
    //  $newCartItems = array('uniqid' => $uniqId,'name' => $name." + ".$id,'price' =>$newPrice, 'amount' => $amount, 'location' => $location, 'date' => $date,'time' => $time, 'id' => $id, 'specialText' => $specialtext, 'type' => $type);
      //  array_push($tempArray, $newCartItems);
    }
    $_SESSION['products'] = $tempArray;



  }
}
?>
