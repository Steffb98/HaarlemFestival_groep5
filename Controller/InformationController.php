<?php
require_once '../DAL/InformationDAL.php';
$inf = new Information;

//check which page is requested to edit
if(isset($_GET['Edit'])){
  $inf->GetInformation($_GET['Edit']);
}

//if submit button is pressed
if(isset($_POST['InfSubmit'])){
  $inf->CheckInformation();
}

class Information{
  function GetInformation($page){
    //check which option is choosen and get all editable textfields.
    if($page == 'Edit Home'){
      $_SESSION['Information'] = CMS_GetInformation(0);
    }
    else if($page == 'Edit Jazz'){
      $_SESSION['Information'] = CMS_GetInformation(1);
    }
    else if($page == 'Edit Dance'){
      $_SESSION['Information'] = CMS_GetInformation(2);
    }
    else if($page == 'Edit Restaurant'){
      $_SESSION['Information'] = CMS_GetInformation(3);
    }
  }
  //check the information if any mistakes are made
  function CheckInformation(){
    global $inf;
    unset($_POST['InfSubmit']);
    $valueList = array();

    //the key is both the textID and page so they need to be split
    foreach ($_POST as $key => $value) {
      $tempVar = explode("_", $key);
      $textID = $tempVar[0];
      $page = $tempVar[1];
      $infoText = $value;

      //test a few things to see if the input is valid
      $checker = true;
      if(preg_match('/[$=@#|<>^*%]/', $value)){
        $checker = false;
      }
      else if(!is_numeric($textID)){
        $checker = false;
      }
      //if valid clear the input fields, send inputs to the DB
      if ($checker == true){
        $_SESSION['InformationErr'] = '';
        CMS_ChangeInformation($textID, $value);

      }
      if ($checker == false){
        break;
      }
    }
    //if checker is valse, set all values in a class to return in a session and be placed
    //in a textfield so the user won't have to type it agian.
    if ($checker == false){
      $err = 'Invalid symbols used in the one or more text fields';
      $_SESSION['InformationErr'] = $err;

      foreach ($_POST as $key => $value) {
        $tempVar = explode("_", $key);
        $textID = $tempVar[0];
        $page = $tempVar[1];
        $infoText = $value;
        $values = new stdClass;
        $values->TextID = $textID;
        $values->InfoText = $infoText;
        $values->Page = $page;
        array_push($valueList, $values);
      }
      $_SESSION['Information'] = $valueList;
    }
    else{
      $inf->GetInformation(0);
      header('location: InformationView.php');
    }
  }
}
?>
