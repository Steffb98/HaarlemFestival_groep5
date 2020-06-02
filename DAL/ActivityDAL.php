<?php
require_once '../DAL/DbConn.php';

$mysqli = Singleton::getInstance();

function CMS_GetActivity(string $userId){
  $activityArray = array();

  global $mysqli;
  $activityQuery = $mysqli->stmt_init();
  $activityQuery->prepare('SELECT AV.VolunteerId, AV.ActivityId, A.Time, A.Location, A.Description FROM ActivityVolunteer AS AV JOIN Activity AS A ON AV.ActivityId=A.ActivityId WHERE VolunteerId = ? AND A.Time>=Now() ORDER BY A.Time');
  $activityQuery->bind_param("s", $userId);
  $activityQuery->execute();
  $activityQuery = $activityQuery->get_result();

  if($activityQuery != ''){
    while ($activity=mysqli_fetch_object($activityQuery)){
      array_push($activityArray, $activity);
    }
  }

  return $activityArray;
}

?>
