<?php
require_once '../DAL/DbConn.php';

$mysqli = Singleton::getInstance();

function CMS_GetRestaurants(string $filter = NULL){
  global $mysqli;

  //if filter(search) is null get all, else get only the filter
  if($filter == NULL){
    $RestaurantQuery = $mysqli->query('SELECT R.RestaurantID, R.Name, R.Kitchen, R.Stars, R.Fish, R.Text, R.Price, R.Location, R.IMG FROM Restaurant AS R');
  }
  else{
    $filter = "%".$filter."%";

    $RestaurantQuery = $mysqli->stmt_init();
    $RestaurantQuery->prepare('SELECT R.RestaurantID, R.Name, R.Kitchen, R.Stars, R.Fish, R.Text, R.Price, R.Location, R.IMG FROM Restaurant AS R WHERE R.Name LIKE ? OR R.Kitchen LIKE ? OR R.Text LIKE ?');
    $RestaurantQuery->bind_param("sss", $filter, $filter, $filter);
    $RestaurantQuery->execute();
    $RestaurantQuery = $RestaurantQuery->get_result();
  }
  //make an array and place every row into that array as an object
  $RestaurantArray = array();
  if($RestaurantQuery != ''){
    while ($item=mysqli_fetch_object($RestaurantQuery)){
      array_push($RestaurantArray, $item);
    }
  }
  return $RestaurantArray;
}

function CMS_GetRestaurantsByID(string $RestaurantID){
  global $mysqli;
  $RestaurantQuery = $mysqli->stmt_init();
  $RestaurantQuery->prepare('SELECT R.RestaurantID, R.Name, R.Kitchen, R.Stars, R.Fish, R.Text, R.Price, R.Location, R.IMG FROM Restaurant AS R WHERE RestaurantID = ?');
  $RestaurantQuery->bind_param("s", $RestaurantID);
  $RestaurantQuery->execute();
  $RestaurantQuery = $RestaurantQuery->get_result();

  if($RestaurantQuery != ''){
    while ($item=mysqli_fetch_object($RestaurantQuery)){
      return $item;
    }
  }
}

function CMS_GetSessions(string $RestaurantID){
  global $mysqli;
  $sessionList = array();

  $sessionQuery = $mysqli->stmt_init();
  $sessionQuery->prepare('SELECT RSessionId, StartTime, Duration, MaxSeats FROM RestaurantSessions WHERE RestaurantID = ? ORDER BY RSessionId');
  $sessionQuery->bind_param("s", $RestaurantID);
  $sessionQuery->execute();
  $sessionQuery = $sessionQuery->get_result();

  if($sessionQuery != ''){
    while ($item=mysqli_fetch_object($sessionQuery)){
      array_push($sessionList, $item);
    }
  }
  return $sessionList;
}

function CMS_UpdateRestaurant(string $Name, string $Kitchen, int $Stars, int $Fish, string $Text, string $Price, string $Location, int $RestaurantID){
  global $mysqli;
  $sessionList = array();

  $sessionQuery = $mysqli->stmt_init();
  $sessionQuery->prepare('UPDATE Restaurant SET Name = ?, Kitchen = ?, Stars = ?, Fish = ?, Text = ?, Price = ?, Location = ? WHERE RestaurantID = ?');
  $sessionQuery->bind_param("ssiisssi", $Name, $Kitchen, $Stars, $Fish, $Text, $Price, $Location ,$RestaurantID);
  $sessionQuery->execute();
}

function CMS_UpdateRestaurantSession($SessionDate,$SessionTime,$SessionDuration,$SessionMaxSeats,$RSessionID){
  global $mysqli;
  $SessionDateTime = $SessionDate." ".date("G:i:s",strtotime($SessionTime));

  $sessionQuery = $mysqli->stmt_init();
  $sessionQuery->prepare('UPDATE RestaurantSessions SET StartTime = ?, Duration = ?, MaxSeats = ? WHERE RSessionID = ?');
  $sessionQuery->bind_param("siii", $SessionDateTime, $SessionDuration, $SessionMaxSeats, $RSessionID);
  $sessionQuery->execute();
}

function CMS_DeleteRestaurant($restaurantID){
  global $mysqli;
  $sessionQuery = $mysqli->stmt_init();
  $sessionQuery->prepare('DELETE FROM Restaurant WHERE RestaurantID = ?');
  $sessionQuery->bind_param("i", $restaurantID);
  $sessionQuery->execute();
}

function CMS_DeleteRestaurantSessions($restaurantID){
  global $mysqli;
  $sessionQuery = $mysqli->stmt_init();
  $sessionQuery->prepare('DELETE FROM RestaurantSessions WHERE RestaurantID = ?');
  $sessionQuery->bind_param("i", $restaurantID);
  $sessionQuery->execute();
}

function CMS_InsertRestaurant($NewName, $NewKitchen, $Stars, $Fish, $NewText, $NewPrice, $NewLocation, $NewImg){
  global $mysqli;
  $sessionQuery = $mysqli->stmt_init();
  $sessionQuery->prepare('INSERT INTO Restaurant (Name, Kitchen, Stars, Fish, Text, Price, Location, IMG) VALUES (?,?,?,?,?,?,?,?)');
  $sessionQuery->bind_param("ssiissss", $NewName, $NewKitchen, $Stars, $Fish, $NewText, $NewPrice, $NewLocation, $NewImg);
  $sessionQuery->execute();
}

function CMS_GetHighestRestaurant(){
  global $mysqli;
  $stmt = $mysqli->query('SELECT MAX(RSessionID) AS Restaraunts FROM RestaurantSessions');

  if($stmt != ''){
    while ($item=mysqli_fetch_object($stmt)){
      return $item;
    }
  }
}

function CMS_AddRestaurantSessions($sessionArray){
  global $mysqli;
  foreach ($sessionArray as $item) {
    $sessionQuery = $mysqli->stmt_init();
    $sessionQuery->prepare('INSERT INTO RestaurantSessions (RSessionID, RestaurantID, StartTime, Duration, AmountOfSeats, MaxSeats) VALUES (?,?,?,?,?,?)');
    $sessionQuery->bind_param("iisiii", $item->RSessionID, $item->RestaurantID, $item->StartTime, $item->Duration, $item->MaxSeats, $item->MaxSeats);
    $sessionQuery->execute();
  }
}
?>
