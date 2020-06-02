<?php
require_once '../DAL/DbConn.php';

$mysqli = Singleton::getInstance();

function SearchUser($email, $password){
 global $mysqli;

 $stmt = $mysqli->stmt_init();
 $stmt->prepare('SELECT VolunteerID, Function, FirstName, LastName, Password, Email, RegisterDate, NewAccount FROM Volunteer WHERE Email = ? AND Password = ?');
 $stmt->bind_param("ss", $email, $password);
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

?>
