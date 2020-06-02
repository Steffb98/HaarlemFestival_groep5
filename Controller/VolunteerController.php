<?php
require_once '../DAL/VolunteerDAL.php';


$volunteer = new Volunteer();
$volunteer->GetActivity();

//get all message if S is not set, else, only filter the messages where filter
if (isset($_GET['S'])){
  $_SESSION['CMS_VolunteerList'] = CMS_GetVolunteers($_GET['S']);
}
else{
  $_SESSION['CMS_VolunteerList'] = CMS_GetVolunteers();
}

//if volunteer is pressed, check if value is numeric, not decimal, not less than zero
if (isset($_GET['VolunteerId'])){
  $volunteerId = $_GET['VolunteerId'];
  $checker = true;

  if(!is_numeric($volunteerId)){
    $checker == false;
  }
  else if (strpos($volunteerId, "." ) !== true) {
    $checker == false;
  }
  else if($volunteerId <= 0){
    $checker == false;
  }
  //if so, get edit information
  if($checker == true){
    $_SESSION['CMS_EditVolunteer'] = CMS_GetEditVolunteers($volunteerId);
  }
}

//if login button is pressed, do function
if (isset($_POST['VLogin'])){
  $volunteer->LoginAsVolunteer($_GET['VolunteerId']);
}

//if submit button is pressed, do function
if (isset($_POST['VSubmit'])){
  $volunteer->ChangeVolunteer();
}

//if submit button is pressed, do function
if (isset($_POST['VNSubmit'])){
  $volunteer->NewVolunteer();
}

class Volunteer
{
  function NewVolunteer(){
    //get information
    global $volunteer;
    $email = $_POST['VNEmail'];
    $rank = $_POST['VNRank'];

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
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){$checker = false; $err='Invalid email'; break;}
      if(!is_numeric($rank)){$checker = false; $err='Invalid Rank, try using numbers'; break;}
      if(!(1 < $rank) && ($rank > 3)){$checker = false; $err='Invalid Rank, only 1, 2 and 3 are valid'; break;}
      if(SearchEmail($email) != NULL){$checker = false; $err='Invalid email, already in use'; break;}
      break;
    }
    if ($checker == true){
      $password = $volunteer->GeneratePassword();
      $hashPassword = hash("sha512", $password);
      CMS_NewVolunteer('FirstName', 'LastName', $email, $rank, date("Y-m-d G:i:s"), 1, $hashPassword);
      $_SESSION['CMS_NewVolData'] = array('','');
      mail($email,"New account Haarlem Festival",$email." ".$password,["From hfteam5@localhost"]);
      $_SESSION['CMS_NewVolErr'] = '';
    }
    else{
      $_SESSION['CMS_NewVolData'] = array($email, $rank);
      $_SESSION['CMS_NewVolErr'] = $err;
    }
    header("Location: VolunteerView.php");
  }

  function ChangeVolunteer(){
    global $volunteer;

    //get information
    $FirstName = $_POST['VFirstName'];
    $LastName = $_POST['VLastName'];
    $Emai = $_POST['VEmai'];
    $Rank = $_POST['VRank'];
    $RegisterDate = $_POST['VRegisterDate'];

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
      if(!$volunteer->ValidateInput($FirstName)){$checker = false; $err='Invalid first name'; break;}
      if(!$volunteer->ValidateInput($LastName)){$checker = false; $err='Invalid last name'; break;}
      if(!filter_var($Emai, FILTER_VALIDATE_EMAIL)){$checker = false; $err='Invalid email'; break;}
      if(!$volunteer->ValidateInputDate($RegisterDate)){$checker = false; $err='Invalid date, write as: dd-mm-yyyy '; break;}
      if(!is_numeric($Rank)){$checker = false; $err='Invalid Rank, try using numbers Thijs ;)'; break;}
      if(!(1 < $Rank) && ($Rank > 3)){$checker = false; $err='Invalid Rank, only 1, 2 and 3 are valid'; break;}
      break;
    }

    if($checker == false){
      $values = new stdClass;
      $values->FirstName = $FirstName;
      $values->LastName = $LastName;
      $values->Email = $Emai;
      $values->Function = $Rank;
      $values->RegisterDate = $RegisterDate;

      $_SESSION['CMS_VolunteerErr'] = $err;
      $_SESSION['CMS_EditVolunteer'] = $values;
    }
    else{
      $values = new stdClass;
      $values->FirstName = '';
      $values->LastName = '';
      $values->Email = '';
      $values->Function = '';
      $values->RegisterDate = '';

      $_SESSION['CMS_EditVolunteer'] = $values;
      $_SESSION['CMS_VolunteerErr'] = '';
      CMS_ChangeVolunteer($FirstName, $LastName, $Emai, $Rank, $RegisterDate, $_GET['VolunteerId']);
      header("Location: VolunteerView.php");
    }
  }

  //validate input
  function ValidateInput($input){
    if(!preg_match('/[^a-z_\-:,.0-9"  *"]/i', $input)){
      return true;
    }
    return false;
  }

//validate input date
  function ValidateInputDate($input){
    if(preg_match('/^([0-2][0-9]|(3)[0-1])(\-)(((0)[0-9])|((1)[0-2]))(\-)\d{4}$/i', $input)){
      return true;
    }
    return false;
  }

  //get activities if volunteer is pressed
  function GetActivity(){
    require_once '../DAL/ActivityDAL.php';
    if(isset($_GET['VolunteerId'])){
      if(is_numeric($_GET['VolunteerId'])){
        $_SESSION['VActivity'] = CMS_GetActivity($_GET['VolunteerId']);
      }
    }
  }
  //generate a password if volunteer adds a new volunteer
  //this password can be used by the new volunteer for the first login
  function GeneratePassword(){
    $checker = true;
    while($checker == true){
      $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charLength = strlen($char);
      $randString = '';
      for ($i = 0; $i < 10; $i++) {
        $randString .= $char[rand(0, $charLength - 1)];
      }

      //check a few password qritueria of hoe je dat ook schrijft
      if(preg_match('/[A-Z]/', $randString)){
        if(preg_match('/[a-z]/', $randString)){
          if(preg_match('/[0-9]/', $randString)){
            $checker = false;
            return $randString;
          }
        }
      }
    }
  }
  //login as a volunteer, make an alert that you are logged in as another volunteer
  function LoginAsVolunteer($volunteerID){
    $volunteer = CMS_GetEditVolunteers($volunteerID);
    echo '<script type="text/javascript">alert("je logt nu in als '.$volunteer->FirstName.' '.$volunteer->LastName.'")</script>';
    $_SESSION['LoggedInUser'] = CMS_VolunteerLogin($volunteerID);
    header("Refresh:0");
  }
}

?>
