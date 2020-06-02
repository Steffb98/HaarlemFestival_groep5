<?php
require_once '../DAL/DbConn.php';

$mysqli = Singleton::getInstance();

//get all activities if no filter is set or change is set,
//if filter is set get only rows with the filter
//if filter and change is set, get rows with the filter and return inmidiatly
function GetActivities(string $filter = NULL, bool $change = false){
  $activityList = array();


  if($filter == NULL && $change == false){
    global $mysqli;
    $stmt = $mysqli->query('SELECT A.ActivityId, A.Description,Time, A.Location, AmountOfVolunteers - COUNT(AV.ActivityID) AS VolunteersRequired, AmountOfVolunteers FROM Activity AS A LEFT JOIN ActivityVolunteer AS AV ON AV.ActivityID = A.ActivityID GROUP BY A.ActivityID ORDER BY AmountOfVolunteers DESC');
  }

  if($filter != NULL && $change == false){
    $filter = "%".$filter."%";
    global $mysqli;
    $stmt = $mysqli->stmt_init();
    $stmt->prepare('SELECT ActivityId, Description, Time, Location, AmountOfVolunteers FROM Activity WHERE Description LIKE ? OR Location LIKE ? OR AmountOfVolunteers LIKE ? OR ActivityId LIKE ? ORDER BY AmountOfVolunteers DESC');
    $stmt->bind_param("ssss", $filter, $filter, $filter, $filter);
    $stmt->execute();
    $stmt = $stmt->get_result();
  }

  if($filter != NULL && $change == true){
    $filter = "%".$filter."%";
    global $mysqli;
    $stmt = $mysqli->stmt_init();
    $stmt->prepare('SELECT ActivityId, Description, Time, Location, AmountOfVolunteers FROM Activity WHERE ActivityId LIKE ?');
    $stmt->bind_param("s", $filter);
    $stmt->execute();
    $stmt = $stmt->get_result();
    return mysqli_fetch_object($stmt);
  }

  $activityList = array();
  if($stmt != ''){
    while ($activity=mysqli_fetch_object($stmt)){
      array_push($activityList, $activity);
    }
  }
  return $activityList;
}

function CMS_AddActivity($AcDescription, $AcDate, $AcStartTime, int $AcVolReq, $AcLocation){

  $dateTime = date("Y-m-d", strtotime($AcDate))." ".date("G:i:s", strtotime($AcStartTime));

  global $mysqli;
  $stmt = $mysqli->stmt_init();
  $stmt->prepare('INSERT INTO Activity (Description, Time, Location, AmountOfVolunteers) VALUES (?, ?, ?, ?)');
  $stmt->bind_param("sssi", $AcDescription, $dateTime, $AcLocation, $AcVolReq);
  $stmt->execute();
}

function CMS_DeleteActivity($activityId){
  global $mysqli;
  $stmt = $mysqli->stmt_init();
  $stmt->prepare('DELETE FROM Activity WHERE ActivityID = ?');
  $stmt->bind_param("i", $activityId);
  $stmt->execute();
}

function CMS_EditActivity($description, $date, $startTime, $location, $volReq, $activityId){

  $dateTime = date("Y-m-d", strtotime($date))." ".date("G:i:s", strtotime($startTime));

  global $mysqli;
  $stmt = $mysqli->stmt_init();
  $stmt->prepare('UPDATE Activity SET Description = ?, Time = ?, Location = ?, AmountOfVolunteers = ? WHERE ActivityId = ?');
  $stmt->bind_param("sssii", $description, $dateTime, $location, $volReq, $activityId);
  $stmt->execute();
}

function CMS_GetVolunteers(){
  $volunteerList = array();

  global $mysqli;
  $stmt = $mysqli->query('SELECT V.VolunteerID, COUNT(*) AS Activities, Function, FirstName, LastName, Email, RegisterDate FROM Volunteer AS V LEFT JOIN ActivityVolunteer AS AV ON AV.VolunteerID = V.VolunteerID GROUP BY V.FirstName');

  if($stmt != ''){
    while ($item=mysqli_fetch_object($stmt)){
      array_push($volunteerList, $item);
    }
  }
  return $volunteerList;
}

function CMS_ActivityVolunteer($activityId){
  $volunteerList = array();

  global $mysqli;
  $stmt = $mysqli->stmt_init();
  $stmt->prepare('SELECT VolunteerID, ActivityVolunteerID, ActivityID FROM ActivityVolunteer WHERE ActivityID = ?');
  $stmt->bind_param("i", $activityId);
  $stmt->execute();
  $stmt = $stmt->get_result();

  if($stmt != ''){
    while ($item=mysqli_fetch_object($stmt)){
      array_push($volunteerList, $item);
    }
  }
  return $volunteerList;
}

function CMS_DeleteActivityVolunteer($volunteerID, $activityID){
  global $mysqli;
  $stmt = $mysqli->stmt_init();
  $stmt->prepare('DELETE FROM ActivityVolunteer WHERE ActivityID = ? AND VolunteerID = ?');
  $stmt->bind_param("ii", $activityID, $volunteerID);
  $stmt->execute();
}

function CMS_AddActivityVolunteer($volunteerID, $activityID){
  global $mysqli;
  $stmt = $mysqli->stmt_init();
  $stmt->prepare('INSERT INTO ActivityVolunteer (ActivityID, VolunteerID) VALUES (?, ?)');
  $stmt->bind_param("ii", $activityID, $volunteerID);
  $stmt->execute();
}
?>
