<?php
require_once '../DAL/DbConn.php';

$mysqli = Singleton::getInstance();

function CMS_GetVolunteers(string $filter = NULL){
  $userList = array();

  if($filter == NULL){
    global $mysqli;
    $usersQuery = $mysqli->query('SELECT VolunteerID, Function, FirstName, LastName, Email, RegisterDate FROM Volunteer');
  }

  if($filter != NULL){
    $filter = "%".$filter."%";

    global $mysqli;
    $usersQuery = $mysqli->stmt_init();
    $usersQuery->prepare('SELECT VolunteerID, Function, FirstName, LastName ,EmailAddress ,RegistrationDate FROM Volunteer WHERE VolunteerId LIKE ? OR FirstName LIKE ? OR LastName LIKE ? OR EmailAddress LIKE ? OR RegistrationDate LIKE ?');
    $usersQuery->bind_param("sssss", $filter, $filter, $filter, $filter, $filter);
    $usersQuery->execute();
    $usersQuery = $usersQuery->get_result();
  }

  if($usersQuery != ''){
    while ($user=mysqli_fetch_object($usersQuery)){
      array_push($userList, $user);
    }
  }
  return $userList;
}

function CMS_GetEditVolunteers($volunteerId){
  global $mysqli;
  $stmt = $mysqli->stmt_init();
  $stmt->prepare('SELECT VolunteerID, NewAccount ,Function, FirstName, LastName, Email, RegisterDate FROM Volunteer WHERE VolunteerID = ?');
  $stmt->bind_param("i", $volunteerId);
  $stmt->execute();
  $stmt = $stmt->get_result();

  return mysqli_fetch_object($stmt);
}

function CMS_ChangeVolunteer($FirstName, $LastName, $Emai, $Rank, $RegisterDate, $volunteerId){
  global $mysqli;
  $RegisterDate = date("Y-m-d G:i:s", strtotime($RegisterDate));

  $stmt = $mysqli->stmt_init();
  $stmt->prepare('UPDATE Volunteer SET FirstName = ?, LastName = ?, Function = ?, Email = ?, RegisterDate = ? WHERE VolunteerID = ?');
  $stmt->bind_param("ssissi", $FirstName, $LastName, $Rank, $Emai, $RegisterDate, $volunteerId);
  $stmt->execute();
}

function CMS_NewVolunteer($FirstName, $LastName, $email, $rank, $date, $newAccount, $password){
  global $mysqli;
  $stmt = $mysqli->stmt_init();
  $stmt->prepare('INSERT INTO Volunteer (Function, FirstName, LastName, Password, Email, RegisterDate, NewAccount) values (?, ?, ?, ?, ?, ?, ?)');
  $stmt->bind_param("isssssi", $rank, $FirstName, $LastName, $password, $email, $date, $newAccount);
  $stmt->execute();
}

function SearchEmail($email){
  global $mysqli;

  $stmt = $mysqli->stmt_init();
  $stmt->prepare('SELECT VolunteerID FROM Volunteer WHERE Email = ?');
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt = $stmt->get_result();

  if($stmt != ''){
    while ($item=mysqli_fetch_object($stmt)){
      return $item;
    }
  }
  else{
    return NULL;
  }
}

function CMS_VolunteerLogin($volunteerID){
  global $mysqli;

  $stmt = $mysqli->stmt_init();
  $stmt->prepare('SELECT VolunteerID, Function, FirstName, LastName, Password, Email, RegisterDate, NewAccount FROM Volunteer WHERE VolunteerID = ?');
  $stmt->bind_param("i", $volunteerID);
  $stmt->execute();
  $stmt = $stmt->get_result();

  if($stmt != ''){
    while ($item=mysqli_fetch_object($stmt)){
      return $item;
    }
  }
}


?>
