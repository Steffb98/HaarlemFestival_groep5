<?php
require_once '../DAL/CMSRestaurantDAL.php';
$restaurant = new Restaurant;

//if filter is none, get all values, otherwise only filter items
if(isset($_GET['S'])){
  $_SESSION['ScheduleRestaurant'] = CMS_GetRestaurants($_GET['S']);
}
else{
  $_SESSION['ScheduleRestaurant'] = CMS_GetRestaurants();
}

//if event id is pressed, get all restaurant details+sessions
if (isset($_GET['EventId'])){
  $_SESSION['ChangeRestaurant'] = CMS_GetRestaurantsByID($_GET['EventId']);
  $_SESSION['ChangeRestaurantSessions'] = CMS_GetSessions($_GET['EventId']);
  $_SESSION['RestaurantChangeErr'] = '';
}

//submit changes
if(isset($_POST['Submit'])){
  $restaurant->AllRestaurant();
}

//creating a new restaurant
if(isset($_POST['ASubmit'])){
  $restaurant->NewRestaurant();
}

class Restaurant{
  //new restaurant
  function NewRestaurant(){
    global $restaurant;
    if ($_POST['ASubmit'] == "Submit"){
      $NewName = $_POST['NewName'];
      $NewStreet = $_POST['NewStreet'];
      $NewPostalCode = $_POST['NewPostalCode'];
      $NewText = $_POST['NewText'];
      $NewKitchen = $_POST['NewKitchen'];
      $NewStars = $_POST['NewStars'];
      $NewPrice = $_POST['NewPrice'];
      $Fish = $_POST['NewFish'];
      if(isset($_POST['Fish'])){$Fish = $_POST['Fish'];};

      if($Fish == 'on'){$Fish = 1;}
      else{$Fish = 0;}
      echo $Fish;

      //make an error variable,
      //make an checker variable,
      //while $checker is true, enter every if, if the value is not valid, set the checker to false, generate err msg,
      //and break out of the loop, this way not every if statement has to be walked through->efficient
      //if the checker is false(invalid input), put the error msg in a session,
      //return the values into the input boxes so the user won't have to type it again.
      //if the checker is true(all valid inputs), empty the inputs, empty the err, reload page and add the valid inputs to the DB
      $err = '';
      $checker = true;
      while ($checker==true) {
        if(!$restaurant->ValidateInput($NewName)){$checker = false; $err='Invalid name, avoid special characters'; break;}
        if(!$restaurant->ValidateInput($NewStreet)){$checker = false; $err='Invalid Street, avoid special characters'; break;}
        if(!$restaurant->ValidateInputPostalCode($NewPostalCode)){$checker = false; $err='Invalid Postal Code, (1234AB)'; break;}
        if(!$restaurant->ValidateInput($NewText)){$checker = false; $err='Invalid text, avoid special characters'; break;}
        if(!$restaurant->ValidateInput($NewKitchen)){$checker = false; $err="Invalid kitchen, seperate kitchens with ' , '."; break;}
        if(!is_numeric($NewStars)){$checker = false; $err='Invalid amount, of stars only use numbers'; break;}
        if(!$restaurant->ValidateInputPrice($NewPrice)){$checker = false; $err='Invalid price, use a "." as seperator'; break;}
        break;
      }
      if($checker == true){
        $NewLocation = $NewStreet.", ".$NewPostalCode.", Haarlem, Nederland";
        $NewImg = "fris.jpg";
        $_SESSION['RestaurantAErr'] = '';
        $_SESSION['RestaurantaValues'] = array('', '', '', '', '', '', '', '');
        header("Location: CMSRestaurantView.php");
        CMS_InsertRestaurant($NewName, $NewKitchen, $NewStars, $Fish, $NewText, $NewPrice, $NewLocation, $NewImg);
        $restaurant->NewRestaurantSessions($NewName);
      }
      else{
        $_SESSION['RestaurantAErr'] = $err;
        $_SESSION['RestaurantaValues'] = array($NewName, $NewStreet, $NewPostalCode, $NewText, $NewKitchen, $NewStars, $NewPrice, $Fish);
      }
    }
  }

  //new sessions
  function NewRestaurantSessions($newName){
    //get the restaurantID of the restaurant just created
    $newRestaurant = CMS_GetRestaurants($newName);
    $restaurantID = $newRestaurant[0]->RestaurantID;

    //make an array
    $sessionArray = array();

    $tempHighestRestaurantID = CMS_GetHighestRestaurant();
    $highestRestaurantID = $tempHighestRestaurantID->Restaraunts;
    //for 4 times starting on 26th ending on 29th make standard sessions, 3 each day...
    for ($i=26; $i <=29 ; $i++) {
      $rstSession1 = new stdClass();
      $highestRestaurantID = $highestRestaurantID + 1;
      $rstSession1->RSessionID = $highestRestaurantID;
      $rstSession1->RestaurantID = $restaurantID;
      $rstSession1->StartTime = "2020-07-".$i." 18:00:00";
      $rstSession1->Duration = 90;
      $rstSession1->MaxSeats = 40;
      array_push($sessionArray, $rstSession1);

      $rstSession2 = new stdClass();
      $highestRestaurantID = $highestRestaurantID + 1;
      $rstSession2->RSessionID = $highestRestaurantID;
      $rstSession2->RestaurantID = $restaurantID;
      $rstSession2->StartTime = "2020-07-".$i." 19:30:00";
      $rstSession2->Duration = 90;
      $rstSession2->MaxSeats = 40;
      array_push($sessionArray, $rstSession2);

      $rstSession3 = new stdClass();
      $highestRestaurantID = $highestRestaurantID + 1;
      $rstSession3->RSessionID = $highestRestaurantID;
      $rstSession3->RestaurantID = $restaurantID;
      $rstSession3->StartTime = "2020-07-".$i." 21:00:00";
      $rstSession3->Duration = 90;
      $rstSession3->MaxSeats = 40;
      array_push($sessionArray, $rstSession3);
    }
    CMS_AddRestaurantSessions($sessionArray);
  }

  //change restaurant
  function AllRestaurant(){
    global $restaurant;
    //get all values
    if ($_POST['Submit'] == "Submit"){
      $Name = $_POST['Name'];
      $Kitchen = $_POST['Kitchen'];
      $Stars = $_POST['Stars'];
      $Fish = '';
      if(isset($_POST['Fish'])){$Fish = $_POST['Fish'];};
      $Text = $_POST['Text'];
      $Price = $_POST['Price'];
      $Location = $_POST['Location'];
      $RestaurantID = $_POST['RestaurantID'];
      if($Fish == 'on'){$Fish = 1;}
      else{$Fish = 0;}

      //make an error variable,
      //make an checker variable,
      //while $checker is true, enter every if, if the value is not valid, set the checker to false, generate err msg,
      //and break out of the loop, this way not every if statement has to be walked through->efficient
      //if the checker is false(invalid input), put the error msg in a session,
      //return the values into the input boxes so the user won't have to type it again.
      //if the checker is true(all valid inputs), empty the inputs, empty the err, reload page and add the valid inputs to the DB
      $err = '';
      $checker = true;
      while ($checker==true) {
        if(!$restaurant->ValidateInput($Name)){$checker = false; $err='Invalid name, avoid special characters'; break;}
        if(!$restaurant->ValidateInput($Kitchen)){$checker = false; $err='Invalid kitchen, avoid special characters'; break;}
        if(!is_numeric($Stars)){$checker = false; $err='Invalid amount, of stars only use numbers'; break;}
        if(!$restaurant->ValidateInput($Text)){$checker = false; $err='Invalid text, avoid special characters'; break;}
        if(!$restaurant->ValidateInputPrice($Price)){$checker = false; $err='Invalid price, use a "." as seperator'; break;}
        if(!$restaurant->ValidateInput($Location)){$checker = false; $err='Invalid Location, avoid special characters'; break;}
        break;
      }

      //CMS_GetHighestRestaurant();

      //***check the Restaurant***
      //if checker is true, add values to DB
      //else, return err msg
      if($checker == true){
        $_SESSION['RestaurantChangeErr'] = '';
        CMS_UpdateRestaurant($Name, $Kitchen, (int)$Stars, (int)$Fish, $Text, (double)$Price, $Location, (int)$RestaurantID);
        header("location: CMSRestaurantView.php");
      }
      else{
        $_SESSION['RestaurantChangeErr'] = $err;
      }
    }

    //if Delete delete value, return to DB.
    else if($_POST['Submit'] == "Delete"){
      $restaurant->DeleteRestaurant();
    }
    else if($_POST['Submit'] == "Cancel"){
      $restaurant->CancelRestaurant();
    }
  }

  //cancel restaurant changes
  function CancelRestaurant(){
    header("location: CMSRestaurantView.php");
  }

  //change sessions
  function ChangeSessions(){
    $AmountOfRest = CMS_GetHighestRestaurant();

    //***check the restaurant sessions***
    //check every session sent by $_POST
    //get the Information
    //do a small check
    //if checker is succesfull, send shit to database else, return err msg
    for ($i=0; $i < $AmountOfRest->Restaraunts + 2; $i++) {
      if(isset($_POST['Date'.$i])){
        $SessionDate = $_POST['Date'.$i];
        $SessionTime = $_POST['Time'.$i];
        $SessionDuration = $_POST['Duration'.$i];
        $SessionMaxSeats = $_POST['MaxSeats'.$i];

        $checker2 = true;
        while ($checker2==true) {
          if(!is_numeric($SessionDuration)){$checker = false; $err='Invalid duration, only use numbers'; break;}
          if(!is_numeric($SessionMaxSeats)){$checker = false; $err='Invalid seat amount, only use numbers'; break;}
          break;
        }
        if($checker2 == true){
          CMS_UpdateRestaurantSession($SessionDate,$SessionTime,$SessionDuration,$SessionMaxSeats,$i); //$i is the session;
        }
        else{
          $_SESSION['RestaurantChangeErr'] = $err;
        }
      }
    }
  }

  //delete restaurant ;)
  function DeleteRestaurant(){
    $RestaurantID = $_POST['RestaurantID'];
    header("location: CMSRestaurantView.php");
    CMS_DeleteRestaurant($RestaurantID);
    CMS_DeleteRestaurantSessions($RestaurantID);
  }

  //validate inputprice
  function ValidateInputPrice($input){
    if(preg_match('/^\d+(\.\d{2})?$/', $input)){
      return true;
    }
    return false;
  }

  //validate input
  function ValidateInput($input){
    if(!preg_match('/[^a-z_\-:,.\'\s()&.0-9"  *"]/i', $input)){
      return true;
    }
    return false;
  }

  //validate dutch postalcode
  function ValidateInputPostalCode($input){
    if(preg_match('/^[1-9][0-9]{3} ?(?!sa|sd|ss)[a-z]{2}$/i', $input)){
      return true;
    }
    return false;
  }
}
?>
