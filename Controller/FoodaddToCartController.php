<?php
require_once 'CartController.php';
session_start();

    if (isset($_POST['cancel']))
    {
      header("location: ../View/food.php");
      exit();
    }
    else
    {
      $Rname = $_POST['name'];
      $time = $_POST['time'];
      $price = $_POST['price'];
      $amount = $_POST['number'];
      $request = $_POST['request'];
      $specialtext = $_POST['textarea'];
      $date = $_POST['date'];

      if($request == "yes")
      {
        //check the specialText
        if(!preg_match("/^[a-zA-Z ]*$/",$specialtext))
        {
          $specialtext = preg_replace("/[^a-zA-Z0-9\s]/", "", $specialtext);
        }

      }
      else
      {
        $request = "no";
        $specialtext = NULL;
      }
      require_once 'RestaurantController.php';
      $location = new RestaurantController();
      $result = $location->get_LocationRestaurant($Rname);
      $id = $location->get_RestaurantID($Rname);
      $type = "food";

      //add foo event to cart
       $session = new Session;
       $session->AddToCart($Rname,$price,$amount,$result['Location'],$date,$time,$id['RestaurantID'],$specialtext,$type);
       if(isset($_POST['continue']))
       {
         header("Location:../View/food.php");
       }
       elseif (isset($_POST['confirm']))
       {
           header("Location:../View/cartView.php");
       }

    }

?>
