<?php
require_once '../DAL/DbConn.php';

$mysqli = Singleton::getInstance();

function CMS_GetMessage(string $filter = NULL){
  global $mysqli;
  $messageList = array();

  if($filter == NULL){
    $messageQuery = $mysqli->query('SELECT Date, MessageId, Subject, Text, (SELECT CONCAT(V.FirstName, " ", V.LastName ) FROM Volunteer AS V WHERE V.VolunteerID = M.VolunteerID) AS Name FROM Messages AS M ORDER BY Date DESC');
  }

  else{
    $filter = "%".$filter."%";

    global $mysqli;
    $messageQuery = $mysqli->stmt_init();
    $messageQuery->prepare('SELECT Date, MessageId, Subject, Text, (SELECT CONCAT(V.FirstName, " ", V.LastName ) FROM Volunteer AS V WHERE V.VolunteerID = M.VolunteerID) AS Name FROM Messages AS M WHERE (SELECT CONCAT(V.FirstName, " ", V.LastName ) FROM Volunteer AS V WHERE V.VolunteerID = M.VolunteerID) LIKE ? OR Subject LIKE ? OR Date LIKE ? OR Text LIKE ? ORDER BY Date DESC');
    $messageQuery->bind_param("ssss", $filter, $filter, $filter, $filter);
    $messageQuery->execute();
    $messageQuery = $messageQuery->get_result();
  }

  if($messageQuery != ''){
    while ($message=mysqli_fetch_object($messageQuery)){
      array_push($messageList, $message);
    }
  }
  return $messageList;
}

?>
