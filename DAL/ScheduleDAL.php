<?php
require_once '../DAL/DbConn.php';

$mysqli = Singleton::getInstance();

function CMS_GetEvents(string $filter){
  global $mysqli;
  //check for filter and get one of the 2 events
  if($filter == "Jazz"){
    $stmt = $mysqli->query('SELECT BS.BSessionId, B.BandID, B.Name, BS.Price, BS.StartTime, BS.EndTime, BS.MaxSeats, L.Venue FROM Band AS B JOIN BandSessions AS BS ON BS.BandID = B.BandID JOIN Location AS L ON L.LocationId = BS.LocationId ORDER BY BS.StartTime asc');
  }

  if($filter == "Dance"){
    $stmt = $mysqli->query('SELECT DS.DSessionId, DJ.DJID, DJ.Name, DS.Price, DS.StartTime, DS.EndTime, DS.MaxSeats, L.Venue FROM DJ AS DJ JOIN DJSessions AS DS ON DS.DJID = DJ.DJID JOIN Location AS L ON L.LocationId = DS.LocationId ORDER BY DS.StartTime asc');
  }
  //make objects
  $EventArray = array();
  if($stmt != ''){
    while ($item=mysqli_fetch_object($stmt)){
      array_push($EventArray, $item);
    }
  }
  return $EventArray;
}
//eventfilter show the event, filter is the ID
function CMS_EditEvent(string $filter, string $eventFilter){
  global $mysqli;

  if($eventFilter == "Jazz"){
    $EventQuery = $mysqli->stmt_init();
    $EventQuery->prepare('SELECT BS.BSessionId AS SessionId, B.BandID, B.Name, BS.Price, BS.StartTime, BS.EndTime, BS.MaxSeats, L.Venue FROM Band AS B JOIN BandSessions AS BS ON BS.BandID = B.BandID JOIN Location AS L ON L.LocationId = BS.LocationId WHERE BS.BSessionId = ?');
    $EventQuery->bind_param("s", $filter);
    $EventQuery->execute();
    $EventQuery = $EventQuery->get_result();
  }

  if($eventFilter == "Dance"){
    $EventQuery = $mysqli->stmt_init();
    $EventQuery->prepare('SELECT DS.DSessionId AS SessionId, DJ.DJID, DJ.Name, DS.Price, DS.StartTime, DS.EndTime, DS.MaxSeats, L.Venue FROM DJ AS DJ JOIN DJSessions AS DS ON DS.DJID = DJ.DJID JOIN Location AS L ON L.LocationId = DS.LocationId WHERE DS.DSessionId = ?');
    $EventQuery->bind_param("s", $filter);
    $EventQuery->execute();
    $EventQuery = $EventQuery->get_result();
  }
  //objects
  if($EventQuery != ''){
    while ($event=mysqli_fetch_object($EventQuery)){
      return $event;
    }
  }
}
//edit event location
function CMS_EditEventFilters(){
  global $mysqli;

  $locationQuery = $mysqli->query('SELECT L.Venue, L.LocationID FROM Location AS L');

  $locationList = array();
  if($locationQuery != ''){
    while ($item=mysqli_fetch_object($locationQuery)){
      array_push($locationList, $item);
    }
  }
  return $locationList;
}

//update an existing event with the data passed as variable and $Event is the decider for the festival
function CMS_UpdateEvent($StartDate, $StartTime, $EndDate, $EndTime, $Location, $Price, $Seats, $SessionId, $Event){
  global $mysqli;

  $startDateTime = (string)date("Y-m-d", strtotime($StartDate))." ".date("H:i:s", strtotime($StartTime));
  $endDateTime =   (string)date("Y-m-d", strtotime($EndDate))." ".date("H:i:s", strtotime($EndTime));

  $CEventQuery = $mysqli->stmt_init();

  if($Event == "Jazz"){
    $CEventQuery->prepare("UPDATE BandSessions SET StartTime = ?, EndTime = ?, MaxSeats = ?, Price = ? WHERE BSessionId = ?");
  }
  if($Event == "Dance"){
    $CEventQuery->prepare("UPDATE DJSessions SET StartTime = ?, EndTime = ?, MaxSeats = ?, Price = ? WHERE DSessionId = ?");
  }

  $CEventQuery->bind_param("sssss", $startDateTime, $endDateTime, $Seats, $Price, $SessionId);
  $CEventQuery->execute();
}

//delete event by sessionID and event
function CMS_DeleteEvent($SessionId, $Event){
  global $mysqli;

  $CDeleteQuery = $mysqli->stmt_init();

  if($Event == "Jazz"){
    $CDeleteQuery->prepare("DELETE FROM BandSessions WHERE BSessionID = ?");
  }
  if($Event == "Dance"){
    $CDeleteQuery->prepare("DELETE FROM DJSessions WHERE DSessionID = ?");
  }

  $CDeleteQuery->bind_param("s", $SessionId);
  $CDeleteQuery->execute();
}

//get all artists/DJ's to be placed in a list
function CMS_GetArtists(){
  global $mysqli;

  $bandQuery = $mysqli->query('SELECT B.BandID AS ID, B.Name, "Jazz" AS Type FROM Band AS B');
  $djQuery = $mysqli->query('SELECT D.DJID AS ID, D.Name, "Dance" AS Type FROM DJ AS D');
  //make objects
  $ArtistArray = array();
  if($bandQuery != ''){
    while ($item=mysqli_fetch_object($bandQuery)){
      array_push($ArtistArray, $item);
    }
  }
  if($djQuery != ''){
    while ($item=mysqli_fetch_object($djQuery)){
      array_push($ArtistArray, $item);
    }
  }
  return $ArtistArray;
}

//place new event in correct database with $typeEvent
function CMS_NewEvent($typeEvent, $artistID, $startDateTime, $endDateTime, $locationID, $price, $seats){
  global $mysqli;
  $EventQuery = $mysqli->stmt_init();

  if($typeEvent == "Jazz"){
    $EventQuery->prepare('INSERT INTO BandSessions (BandID, LocationID, StartTime, EndTime, AmountOfSeats, MaxSeats, Price) VALUES (?, ?, ?, ?, ?, ?, ?)');
  }
  if ($typeEvent == "Dance"){
    $EventQuery->prepare('INSERT INTO DJSessions (DJID, LocationID, StartTime, EndTime, AmountOfSeats, MaxSeats, Price) VALUES (?, ?, ?, ?, ?, ?, ?)');
  }
  $EventQuery->bind_param("sssssss", $artistID, $locationID, $startDateTime, $endDateTime, $seats, $seats, $price);
  $EventQuery->execute();
}

?>
