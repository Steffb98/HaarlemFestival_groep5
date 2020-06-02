<?php
require_once '../DAL/DbConn.php';

$mysqli = Singleton::getInstance();
//insert update, if $updNew = news make it 0 else 1 do this for size and font too, easier in DB
function CMS_InsertUpdate($text, $updNew, $size, $font, $volunteerID){
  if($updNew == 'News'){$updNew = 0;}
  else{$updNew = 1;}

  if($size == 'Small'){$size = 0;}
  else{$size = 1;}

  if($font == 'Lato'){$font = 0;}
  else{$font = 1;}
  //get current date
  $date = date("Y-m-d G:i:s");
  //insert into database
  global $mysqli;
  $activityQuery = $mysqli->stmt_init();
  $activityQuery->prepare('INSERT INTO UpdateWebsite (VolunteerID, Date, Text, Sort, Size, Font) VALUES (?,?,?,?,?,?)');
  $activityQuery->bind_param("issiii", $volunteerID, $date, $text, $updNew, $size, $font);
  $activityQuery->execute();
}

function CMS_GetUpdate($updateID){
  global $mysqli;
  $stmt = $mysqli->stmt_init();
  $stmt->prepare('SELECT UpdateID, Date, Sort, Size, Font, Text FROM UpdateWebsite WHERE UpdateID = ? ORDER BY Date DESC');
  $stmt->bind_param("i", $updateID);
  $stmt->execute();
  $stmt = $stmt->get_result();


  if($stmt != ''){
    while ($update=mysqli_fetch_object($stmt)){
      return $update;
    }
  }
}
//same as above but now edit
function CMS_EditUpdate($text, $updNew, $size, $font, $volunteerID, $updateID){
  if($updNew == 'News'){$updNew = 0;}
  else{$updNew = 1;}

  if($size == 'Small'){$size = 0;}
  else{$size = 1;}

  if($font == 'Lato'){$font = 0;}
  else{$font = 1;}

  $date = date("Y-m-d G:i:s");

  global $mysqli;
  $activityQuery = $mysqli->stmt_init();
  $activityQuery->prepare('UPDATE UpdateWebsite SET VolunteerID = ?, Date = ?, Text = ?, Sort = ?, Size = ?, Font = ? WHERE UpdateID = ?');
  $activityQuery->bind_param("issiiii", $volunteerID, $date, $text, $updNew, $size, $font, $updateID);
  $activityQuery->execute();
}
//delete
function CMS_DeleteUpdate($updateID){
  global $mysqli;
  $activityQuery = $mysqli->stmt_init();
  $activityQuery->prepare('DELETE FROM UpdateWebsite WHERE UpdateID = ?');
  $activityQuery->bind_param("i", $updateID);
  $activityQuery->execute();
}


?>
