<?php
require_once '../DAL/CMSUserDAL.php';

$orderID = '';

//get all message if S is not set, else, only filter the messages where filter
if (isset($_GET['S'])){
  $_SESSION['CMS_UserList'] = CMS_GetUsers($_GET['S']);
}
else{
  $_SESSION['CMS_UserList'] = CMS_GetUsers();
}

//if user is pressed, generate ticket list
if (isset($_GET['UserId'])){
  $_SESSION['CMS_TicketList'] = CMS_GetTickets($_GET['UserId']);
}

//if restaurant id and order id is set
if (isset($_GET['OrdID']) && isset($_GET['ResID'])){
  //if they are both numeric
  if(is_numeric($_GET['OrdID']) && is_numeric($_GET['ResID'])){
    //make a session with sessions
    $_SESSION['EditSession'] = CMS_GetRestaurant($_GET['ResID']);
    $orderID = $_GET['OrdID'];
  }
}
//change
if (isset($_POST['S'])){
  if($_POST['S'] == "Change"){
    $newTime = $_POST['CSessions'];
    $oldTime = $_GET['ResID'];
    $orderID = $_POST['Ord'];

    //check if $newtime is numeric, not decimal, not less than zero
    $checker = true;
    if(!is_numeric($newTime) || !is_numeric($orderID)){
      $checker == false;
    }
    else if (strpos($newTime, "." ) !== true || strpos($newTime, "." ) !== true ) {
      $checker == false;
    }
    else if($newTime <= 0 || $orderID <= 0){
      $checker == false;
    }
    if($checker == true){
      //if true, unset a session, change order time in the database, reload page
      CMS_ChangeOrder($newTime, $orderID, $oldTime);
      unset($_SESSION['CMS_TicketList']);
      header("location: CMSUserView.php");
    }
  }
}
//delete
if (isset($_POST['D'])){
  $orderID = $_POST['Ord'];

  $checker = true;
  //check if $orderID is numeric, not decimal, not less than zero
  if(!is_numeric($orderID)){
    $checker == false;
  }
  else if (strpos($orderID, "." ) !== true ) {
    $checker == false;
  }
  else if($orderID <= 0){
    $checker == false;
  }
  //if so, delete reservation, unset session and relad page
  if($checker == true){
    CMS_DELETEReservation($orderID);
    unset($_SESSION['CMS_TicketList']);
    header("location: CMSUserView.php");
  }
}
?>
