<?php
require_once '../DAL/DbConn.php';

$mysqli = Singleton::getInstance();
//get users, if $filter is 0, this means no search...
function CMS_GetUsers(string $filter = NULL){
  $userList = array();

  if($filter == NULL){
    global $mysqli;
    $usersQuery = $mysqli->query('SELECT UserId, FirstName, LastName, EmailAddress ,RegistrationDate FROM User');
  }

  if($filter != NULL){
    $filter = "%".$filter."%";

    global $mysqli;
    $usersQuery = $mysqli->stmt_init();
    $usersQuery->prepare('SELECT UserId, FirstName, LastName, EmailAddress, RegistrationDate FROM User WHERE UserId LIKE ? OR FirstName LIKE ? OR LastName LIKE ? OR EmailAddress LIKE ? OR RegistrationDate LIKE ?');
    $usersQuery->bind_param("sssss", $filter, $filter, $filter, $filter, $filter);
    $usersQuery->execute();
    $usersQuery = $usersQuery->get_result();
  }
  //make update
  if($usersQuery != ''){
    while ($user=mysqli_fetch_object($usersQuery)){
      array_push($userList, $user);
    }
  }
  return $userList;
}

function CMS_GetTickets(int $userId){
  $tempticketList = array();
  //get the OrderRegelID, and sessionID from the user with $userId
  global $mysqli;
  $ticketQuery = $mysqli->stmt_init();
  $ticketQuery->prepare('SELECT OrderRegelID, RSessionID, DSessionID, BSessionID FROM OrderCart AS O WHERE UserID = ?');
  $ticketQuery->bind_param("i", $userId);
  $ticketQuery->execute();
  $ticketQuery = $ticketQuery->get_result();

  while ($ticket=mysqli_fetch_object($ticketQuery)){
    array_push($tempticketList, $ticket);
  }
  //for each ticket in the database
  $ticketList = array();
  foreach ($tempticketList as $key) {
    //intitalize the statement
    $stmt = $mysqli->stmt_init();
    //check if the DSessionID != NULL (this means that RSessionID and BSessionID are NULL)
    //if DSessionID != NULL, this means a Dance Ticket is sold and dance information is retrieved
    //this is the same for
    if($key->DSessionID != NULL){
      $stmt->prepare('SELECT (SELECT CONCAT(U.FirstName, " ", U.LastName ) FROM User AS U WHERE U.UserId = O.UserID) AS Name, DJ.Name AS Description, DS.StartTime, Amount, "NULL" AS Restaurant, OrderRegelID, OrderID, DS.DSessionID AS SessionID FROM OrderCart AS O JOIN DJSessions as DS ON DS.DSessionID = O.DSessionID JOIN DJ AS DJ ON DJ.DJID = DS.DJID WHERE OrderRegelID = ?');
      $stmt->bind_param("i", $key->OrderRegelID);
    }
    else if($key->RSessionID != NULL){
      $stmt->prepare('SELECT (SELECT CONCAT(U.FirstName, " ", U.LastName ) FROM User AS U WHERE U.UserId = O.UserID) AS Name, R.Name AS Description, RS.StartTime, Amount, "YES" AS Restaurant, OrderRegelID, OrderID, RS.RSessionID AS SessionID FROM OrderCart AS O JOIN RestaurantSessions as RS ON RS.RSessionID = O.RSessionID JOIN Restaurant AS R ON R.RestaurantID = RS.RestaurantID WHERE OrderRegelID = ?');
      $stmt->bind_param("i", $key->OrderRegelID);
    }
    else if($key->BSessionID != NULL){
      $stmt->prepare('SELECT (SELECT CONCAT(U.FirstName, " ", U.LastName ) FROM User AS U WHERE U.UserId = O.UserID) AS Name, B.Name AS Description, BS.StartTime, Amount, "NULL" AS Restaurant, OrderRegelID, OrderID, BS.BSessionID AS SessionID FROM OrderCart AS O JOIN BandSessions as BS ON BS.BSessionID = O.BSessionID JOIN Band AS B ON B.BandID = BS.BandID WHERE OrderRegelID = ?');
      $stmt->bind_param("i", $key->OrderRegelID);
    }
    $stmt->execute();
    $stmt = $stmt->get_result();
    //put the tickets in a ticket list
    array_push($ticketList, mysqli_fetch_object($stmt));
  }


  return $ticketList;
}
//select the restaurant information with RsessionID = ?
function CMS_GetRestaurant($rSessionID){
  global $mysqli;
  $stmt = $mysqli->stmt_init();
  $stmt->prepare('SELECT RestaurantID FROM RestaurantSessions WHERE RSessionID = ?');
  $stmt->bind_param("i", $rSessionID);
  $stmt->execute();
  $stmt = $stmt->get_result();
  $stmt = mysqli_fetch_object($stmt);

  //2nd statemnt select all starttimes form the restaurantID from the vorige query (filters sold out tickets).
  global $mysqli;
  $stmt2 = $mysqli->stmt_init();
  //shitty statement because it doesn't filter sold out tickets
  //$stmt2->prepare('SELECT StartTime, RSessionID, R.Name FROM RestaurantSessions AS RS JOIN Restaurant AS R ON R.RestaurantID = RS.RestaurantID WHERE R.RestaurantID = ?');

  //filter sold out tickets too
  $stmt2->prepare('SELECT StartTime, RS.RSessionID, R.Name ,O.Amount ,SUM(O.Amount) AS Sales, RS.MaxSeats FROM RestaurantSessions AS RS LEFT JOIN OrderCart AS O ON RS.RSessionID = O.RSessionID JOIN Restaurant AS R ON R.RestaurantID = RS.RestaurantID WHERE R.RestaurantID = ? GROUP BY RS.RSessionID HAVING SUM(O.Amount) < RS.MaxSeats OR O.Amount IS NULL');
  $stmt2->bind_param("i", $stmt->RestaurantID);
  $stmt2->execute();
  $stmt2 = $stmt2->get_result();

  $sessionList = array();
  if($stmt2 != ''){
    while ($item=mysqli_fetch_object($stmt2)){
      array_push($sessionList, $item);
    }
  }
  return $sessionList;
}

//update the RsessionID if the restraunt date needs to be changed
function CMS_ChangeOrder($newTime, $orderID, $oldTime){
  global $mysqli;
  $stmt = $mysqli->stmt_init();
  $stmt->prepare('UPDATE OrderCart SET RSessionID = ? WHERE OrderRegelID = ?');
  $stmt->bind_param("ii", $newTime, $orderID);
  $stmt->execute();
}

function CMS_DELETEReservation($orderRegelID){
  global $mysqli;
  $stmt = $mysqli->stmt_init();
  $stmt->prepare('DELETE FROM OrderCart WHERE OrderRegelID = ?');
  $stmt->bind_param("i", $orderRegelID);
  $stmt->execute();
}

?>
