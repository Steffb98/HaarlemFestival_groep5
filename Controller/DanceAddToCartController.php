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
  header("location: ../View/DanceView.php");
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

  require_once 'DanceController.php';
  $dancecontr = new DanceController();
  $result = mysqli_fetch_assoc($dancecontr->get_AddressDance($hall));
  $id = $dancecontr->get_DanceID($name);
  $specialtext = NULL;
  $type = "dance";
  $session = new Session;
  try {
    CheckAmount($amount);

  } catch (\Exception $e) {
    $_SESSION['danceAddError'] = $e->GetMessage();
    header("Location:../View/DanceView.php");
  }
  $session->AddToCart($name,$price,$amount,$result['Address'],$date,$time,$id['DJID'],$specialtext,$type);

  if(isset($_POST['continue']))
  {
    header("Location:../View/DanceView.php");
  }
  else if (isset($_POST['confirm']))
  {
    header("Location:../View/cartView.php");
  }

}

?>
