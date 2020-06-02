<?php
require_once 'CartController.php';
session_start();

function CheckAmount($amount){
  if ($amount < 1 || $amount > 10) {
    throw new Exception("Pick a number between 1 and 10s.");
  }
}

if (isset($_POST['cancel']))
{
  header("location: ../View/JazzView.php");
  exit();
}
else
{
  $name = $_POST['name'];
  $time = $_POST['time'];
  $price = $_POST['price'];
  $amount = $_POST['number'];
  $hall = $_POST['hall'];
  $date = $_POST['date'];

  require_once 'JazzController.php';
  $jazzcontr = new JazzController();
  $result = mysqli_fetch_assoc($jazzcontr->get_AddressJazz($hall));
  $id = $jazzcontr->get_IdJazz($name);
  $specialtext = NULL;
  $type = "jazz";
  $session = new Session;
  try {
    CheckAmount($amount);

  } catch (\Exception $e) {
    $_SESSION['jazzAddError'] = $e->GetMessage();
    header("Location:../View/JazzView.php");
  }
  $session->AddToCart($name,$price,$amount,$result['Address'],$date,$time,$id['BandID'],$specialtext,$type);

  if(isset($_POST['continue']))
  {
    header("Location:../View/JazzView.php");
  }
  elseif (isset($_POST['confirm']))
  {
    header("Location:../View/cartView.php");
  }

}

?>
\
