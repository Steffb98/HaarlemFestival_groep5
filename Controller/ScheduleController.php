<?php
require_once '../DAL/ScheduleDAL.php';
require_once 'ActivityAEController.php';
$validate = new ActivityAE;

//make sessions to fill the lists of artists
$_SESSION['ScheduleJazz'] = CMS_GetEvents("Jazz");
$_SESSION['ScheduleDance']= CMS_GetEvents("Dance");

//if a band/DJ is chosen to edit, the event is retrieved and the locations+bandnames in the second one;
if (isset($_GET['EventId'])){
  $_SESSION['ScheduleEditEvent'] = CMS_EditEvent($_GET['EventId'], $_GET['Event']);
  GetEventLocation();
}

function GetEventLocation(){
  $_SESSION['ScheduleEditEventFilters'] = CMS_EditEventFilters();
}


//if the changes are submitted
if(isset($_POST['SubmitChanges'])){
  //check if the change button is pressed
  if($_POST['SubmitChanges'] == "Change"){

    //get all the given values
    $StartDate = $_POST['StartDate'];
    $StartTime = $_POST['StartTime'];
    $EndDate = $_POST['EndDate'];
    $EndTime = $_POST['EndTime'];
    $Location = $_POST['EditLocation'];
    $Price = $_POST['Price'];
    $Seats = $_POST['Seats'];
    $SessionId = $_POST['Id'];
    $Event = $_GET['Event'];

    //make an empty error string;
    $err = '';
    //set a checker on true;
    $checker = true;
    //check each value if the input is valid, is not $checker is set to false,
    //we break out of the while so no more functions have to be checked,
    //and make an error message
    while ($checker==true) {
      if(!$validate->ValidateInputDate(date("d-m-Y", strtotime($StartDate)))){$checker = false; $err='Invalid start date'; break;}
      if(!$validate->ValidateInputDate(date("d-m-Y", strtotime($EndDate)))){$checker = false; $err='Invalid end date'; break;}
      if(!$validate->ValidateInputTime(date("H:i", strtotime($StartTime)))){$checker = false; $err='Invalid start time'; break;}
      if(!$validate->ValidateInputTime(date("H:i", strtotime($StartTime)))){$checker = false; $err='Invalid end time'; break;}
      if(!ValidateInputPrice($Price)){$checker = false; $err='Invalid price, use point for decimals'; break;}
      if(!is_numeric($Seats)){$checker = false; $err='Invalid seat number, use only numbers'; break;}
      if(!is_numeric($Location)){$checker = false; $err='Invalid location'; break;}
      break; //break to not enter the while loop again.
    }

    //if the checker is still on true all the inputs are valid.
    if($checker == true){
      //errormsg is cleared
      $_SESSION['ScheduleCErr'] = '';
      //the values are sent to the database for inserting/updating
      CMS_UpdateEvent($StartDate, $StartTime, $EndDate, $EndTime, $Location, $Price, $Seats, $SessionId, $Event);
      //back to scheduleview.php
      header("Location: ScheduleView.php");
    }
    else{
      $_SESSION['ScheduleCErr'] = $err;//else, the error is displayed
    }
  }
  //if the deletebutton is pressed, the event is deleted.
  if($_POST['SubmitChanges'] == "Delete"){
    CMS_DeleteEvent($_POST['Id'], $_GET['Event']);
    header("Location: ScheduleView.php");      //back to scheduleview.php
  }
}

//simple function to check if the price is formatted correctly
function ValidateInputPrice($input){
  if(preg_match('/^\d+(\.\d{2})?$/', $input)){
    return true;
  }
  return false;
}


function GetArtists(){
  return CMS_GetArtists();
}

if(isset($_POST['SubmitNew'])){
  if($_POST['SubmitNew'] == "Submit"){
    $NewArtist = $_POST['NewArtist'];
    $NewStartDate = $_POST['NewStartDate'];
    $NewStartTime = $_POST['NewStartTime'];
    $NewEndDate = $_POST['NewEndDate'];
    $NewEndTime = $_POST['NewEndTime'];
    $NewLocation = round(abs($_POST['NewLocation']));
    $NewPrice = round(abs($_POST['NewPrice']));
    $NewSeats = round(abs($_POST['NewSeats']));
    $tempNew = explode("-", $NewArtist);
    $NewArtist = $tempNew[0];
    $NewEvent = $tempNew[1];

    //make an empty error string;
    $err2 = '';
    //set a checker on true;
    $checker = true;
    //check each value if the input is valid, is not $checker is set to false,
    //we break out of the while so no more functions have to be checked,
    //and make an error message
    while ($checker==true) {
      if(!ValidateInputDate(date("d-m-Y", strtotime($NewStartDate)))){$checker = false; $err2='Invalid start date'; break;}
      if(!ValidateInputTime(date("H:i", strtotime($NewStartTime)))){$checker = false; $err2='Invalid start time'; break;}
      if(!ValidateInputDate(date("d-m-Y", strtotime($NewEndDate)))){$checker = false; $err2='Invalid end date'; break;}
      if(!ValidateInputTime(date("H:i", strtotime($NewEndTime)))){$checker = false; $err2='Invalid end time'; break;}
      if(!is_numeric($NewLocation)){$checker = false; $err2='Invalid location'; break;}
      if(!ValidateInputPrice($NewPrice)){$checker = false; $err2='Invalid price, use a point for decimals'; break;}
      if(!is_numeric($NewSeats)){$checker = false; $err2='Invalid seat number, use only numbers'; break;}
      if($NewEvent != "Jazz" && $NewEvent != "Dance"){$checker = false; $err2='Invalid artist'; break;}
      break; //break to not enter the while loop again.
    }

    if($checker == true){
      $startDateTime = (string)date("Y-m-d", strtotime($NewStartDate))." ".date("H:i:s", strtotime($NewStartTime));
      $endDateTime =   (string)date("Y-m-d", strtotime($NewEndDate))." ".date("H:i:s", strtotime($NewEndTime));
      CMS_NewEvent($NewEvent, $NewArtist, $startDateTime, $endDateTime, $NewLocation, $NewPrice, $NewSeats);
      $_SESSION['ScheduleNValues'] = array('','','','','','','','');
      $_SESSION['ScheduleNERR'] = '';
      header("Refresh:0");
    }
    else{
      $_SESSION['ScheduleNValues'] = array($tempNew,$NewStartDate,$NewStartTime,$NewEndDate,$NewEndTime,$NewLocation,$NewPrice,$NewSeats);
      $_SESSION['ScheduleNERR'] = $err2;
    }
  }

  if($_POST['SubmitNew'] == "Cancel"){

  }
}
?>
