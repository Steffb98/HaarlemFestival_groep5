<?php
require_once '../DAL/DbConn.php';

$mysqli = Singleton::getInstance();

function CMS_NewMessage($volunteerID, $subject, $date, $text){
  global $mysqli;
  $messageQuery = $mysqli->stmt_init();
  $messageQuery->prepare('INSERT INTO Messages (VolunteerID, Subject, Date, Text) VALUES (?, ?, ?, ?)');
  $messageQuery->bind_param('isss', $volunteerID, $subject, $date, $text);
  $messageQuery->execute();
  $messageQuery = $messageQuery->get_result();
}

?>
