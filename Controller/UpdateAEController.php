<?php
require_once '../DAL/UpdateAEDAL.php';
require_once '../Controller/UpdateController.php';

$update = new Update;
$getUpdate = new GetUpdates;
$getUpdate->GetUpdates2();

//get the logged in user
$loggedInUser = $_SESSION['LoggedInUser'];

//if preview button is pressed, do preview method
if (isset($_POST['Preview'])){
  $update->Preview();
}

//if submit button is pressed, do submit method
if (isset($_POST['Submit'])){
  $update->Submit();
}

//if cancel button is pressed, clear all input values
if(isset($_POST['Cancel'])){
  $_SESSION['UpdateAEPreview'] = array('', '', '', '', '');
  $_SESSION['UpdateAEData'] = array('', '', '', '');
  $_SESSION['UpdateAEErr'] = '';
}

//if delete button is pressed, clear all input values and delete the update
if(isset($_POST['Delete'])){
  $_SESSION['UpdateAEPreview'] = array('', '', '', '', '');
  $_SESSION['UpdateAEData'] = array('', '', '', '');
  $_SESSION['UpdateAEErr'] = '';
  CMS_DeleteUpdate($_POST['Hidden']);
  header('location: UpdateAEView.php');
}

if(isset($_GET['UpdID'])){
  $updateID = $_GET['UpdID'];
  $update->GetUpdate($updateID);
}

class Update
{
  function Preview(){
    //get all values
    global $update;
    $Text = $_POST['Text'];
    $UpdNew = $_POST['UpdNew'];
    $Size = $_POST['Size'];
    $Font = $_POST['Font'];
    //check the values for text and checkboxes
    $check = $update->CheckValues($Text, $UpdNew, $Size, $Font);

    //if check is true make a session so you can preview
    //delete the err msg
    if ($check == true){
      $_SESSION['UpdateAEPreview'] = array($Text, $UpdNew, $Size, $Font, date("d-m-Y"));
      $_SESSION['UpdateAEData'] = array($Text, $UpdNew, $Size, $Font);
      $_SESSION['UpdateAEErr'] = '';

    }
    else{
      //place err msg
      $_SESSION['UpdateAEData'] = array($Text, $UpdNew, $Size, $Font);
      $_SESSION['UpdateAEErr'] = 'invalid characters used or invalid size/font/update option';
    }
  }

  function Submit(){
    //get all post information
    global $update;
    global $loggedInUser;
    $Text = $_POST['Text'];
    $UpdNew = $_POST['UpdNew'];
    $Size = $_POST['Size'];
    $Font = $_POST['Font'];
    //check the values for text and checkboxes
    $check = $update->CheckValues($Text, $UpdNew, $Size, $Font);

    //if check is true make a session so you can preview
    //delete the err msg
    if ($check == true){
      $_SESSION['UpdateAEPreview'] = array('', '', '', '', '');
      $_SESSION['UpdateAEData'] = array('', '', '', '');
      $_SESSION['UpdateAEErr'] = '';

      //if hidden post is available, this means we edit an update instead of making a new one
      //so we enter another DAL page thing...
      if(isset($_POST['Hidden'])){
        CMS_EditUpdate($Text, $UpdNew, $Size, $Font, $loggedInUser->VolunteerID, $_POST['Hidden']);
      }
      else{
        CMS_InsertUpdate($Text, $UpdNew, $Size, $Font, $loggedInUser->VolunteerID);
      }
      header('location: UpdateAEView.php');
    }
    else{
      //make the err msg and such for if it fails
      $_SESSION['UpdateAEData'] = array($Text, $UpdNew, $Size, $Font);
      $_SESSION['UpdateAEErr'] = 'invalid characters used or invalid size/font/update option';
    }
  }

  //get update :)
  function GetUpdate($updateID){
    //check if updateId is: numeric, no decimal, not less than 0
    $checker = true;
    if(!is_numeric($updateID)){
      $checker = false;
    }
    else if (strpos($updateID, "." ) !== false) {
      $checker = false;
    }
    else if($updateID <= 0){
      $checker = false;
    }
    //if checker is true, convert a values from digit to word
    //make update DATA
    if($checker == true){
      $update = CMS_GetUpdate($updateID);
      if($update->Sort == 0){$update->Sort = 'News';} else{$update->Sort = 'Update';};
      if($update->Size == 0){$update->Size = 'Small';} else{$update->Size = 'Big';};
      if($update->Font == 0){$update->Font = 'Lato';} else{$update->Font = 'Sans-serif';};
      $_SESSION['UpdateAEData'] = array($update->Text, $update->Sort, $update->Size, $update->Font, $update->UpdateID);
      $_SESSION['UpdateAEPreview'] = array($update->Text, $update->Sort, $update->Size, $update->Font, date("d-m-Y"));
      header('location: UpdateAEView.php');
    }
  }
  //check alll update values
  function CheckValues($text, $updNew, $size, $font){
    $checker = true;
    //check the text msg for weird characters
    if(preg_match('/[$=@#|<>^*]/', $text)){
      $checker = false;
    }
    //check if one of 2 is pressed if not return false
    else if($updNew != 'News' && $updNew != 'Update'){
      $checker = false;
    }
    //check if one of 2 is pressed if not return false
    else if($size != 'Big' && $size != 'Small'){
      $checker = false;
    }
    //check if one of 2 is pressed if not return false
    else if($font != 'Lato' && $font != 'Sans-serif'){
      $checker = false;
    }

    if($checker == true){
      return true;
    }
    return false;
  }
}

?>
