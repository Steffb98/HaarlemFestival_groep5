<?php
require_once '../DAL/DbConn.php';

$mysqli = Singleton::getInstance();

function CMS_EditAccount($firstName, $lastName, $email, $volunteerID ,$newAccount, $password){
  global $mysqli;
  $stmt = $mysqli->stmt_init();
  $stmt->prepare('UPDATE Volunteer SET FirstName = ?, LastName = ?, Email = ?, newAccount = ?, Password = ? WHERE VolunteerID = ?');
  $stmt->bind_param("sssisi", $firstName, $lastName, $email, $newAccount, $password, $volunteerID);
  $stmt->execute();
  $stmt = $stmt->get_result();
}

function CMS_EditAccount2($firstName, $lastName, $email, $volunteerID ,$newAccount){
  global $mysqli;
  $stmt = $mysqli->stmt_init();
  $stmt->prepare('UPDATE Volunteer SET FirstName = ?, LastName = ?, Email = ?, newAccount = ? WHERE VolunteerID = ?');
  $stmt->bind_param("sssii", $firstName, $lastName, $email, $newAccount, $volunteerID);
  $stmt->execute();
  $stmt = $stmt->get_result();
}

?>
