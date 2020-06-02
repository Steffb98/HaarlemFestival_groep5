<?php
require_once '../DAL/DbConn.php';

$mysqli = Singleton::getInstance();

//if decider(jazz,dance,food) is that specific event, get those events
//not in use anymore
// function CMS_JazzDanceFoodSales(string $decider){
//   global $mysqli;
//
//   if ($decider == 'Jazz'){
//     $stmt = $mysqli->query('SELECT B.Name, BS.Price, BS.StartTime, BS.AmountOfSeats, BS.Maxseats FROM BandSessions AS BS JOIN Band AS B WHERE B.BandId = BS.BandId && BS.MaxSeats > 0 ORDER BY B.Name');
//   }
//   if ($decider == 'Dance'){
//     $stmt = $mysqli->query('SELECT D.Name, DJS.Price, DJS.StartTime, DJS.AmountOfSeats, DJS.Maxseats FROM DJSessions AS DJS JOIN DJ AS D WHERE D.DJID = DJS.DJID ORDER BY D.Name');
//   }
//
//   if ($decider == 'Food'){
//     $stmt = $mysqli->query('SELECT F.Name, F.Price, RS.StartTime ,RS.AmountOfSeats, RS.Maxseats FROM RestaurantSessions AS RS JOIN Restaurant AS F WHERE F.RestaurantId = RS.RestaurantId ORDER BY F.Name');
//   }
//   // make object out of them
//   $salesArray = array();
//   if($stmt != ''){
//     while ($item=mysqli_fetch_object($stmt)){
//       array_push($salesArray, $item);
//     }
//   }
//   return $salesArray;
// }

function CMS_JazzDanceFoodSales2(string $decider){
  global $mysqli;
  $amountOfSessions = '';
  $revenueList = array();

  //select max sessionID from the event asked for by $decider
  if ($decider == 'Jazz'){
    $stmt = $mysqli->query('SELECT MAX(BSessionID) AS COUNT FROM BandSessions');
  }
  else if ($decider == 'Dance'){
    $stmt = $mysqli->query('SELECT MAX(DSessionID) AS COUNT FROM DJSessions');
  }

  else if ($decider == 'Food'){
    $stmt = $mysqli->query('SELECT MAX(RSessionID) AS COUNT FROM RestaurantSessions');
  }
  //make them some objects
  if($stmt != ''){
    while ($item=mysqli_fetch_object($stmt)){
      $amountOfSessions = $item;
    }
  }
  //if the decider is jazz, select the sum from all sales in the ordercart, select the sold seats for that festival
  //put those in an array and do this for every festival if asked for that. example:
  //  totalsales:  €120
  //  chairs sold: 6
  //  //chairs %:  5%
  if ($decider == 'Jazz'){
    for ($i=1; $i <= $amountOfSessions->COUNT; $i++) {
      $stmt = $mysqli->query('SELECT SUM(OC.TotalPrice) AS Price, ((SUM(Amount) / Maxseats) * 100) AS PercentageSold, BS.MaxSeats ,B.Name, BS.StartTime FROM OrderCart AS OC JOIN BandSessions AS BS ON OC.BSessionID = BS.BSessionID JOIN Band AS B ON B.BandID = BS.BandID WHERE OC.BSessionID IS NOT NULL AND OC.BSessionID = '.$i);
      $item = mysqli_fetch_object($stmt);
      array_push($revenueList, $item);
    }
  }
  else if ($decider == 'Dance'){
    for ($i=1; $i <= $amountOfSessions->COUNT; $i++) {
      $stmt = $mysqli->query('SELECT SUM(OC.TotalPrice) AS Price, ((SUM(Amount) / Maxseats) * 100) AS PercentageSold, D.Name, DS.StartTime FROM OrderCart AS OC JOIN DJSessions AS DS ON OC.DSessionID = DS.DSessionID JOIN DJ AS D ON D.DJID = DS.DJID WHERE OC.DSessionID IS NOT NULL AND OC.DSessionID = '.$i);
      $item = mysqli_fetch_object($stmt);
      array_push($revenueList, $item);
    }
  }

  else if ($decider == 'Food'){
    for ($i=1; $i <= $amountOfSessions->COUNT; $i++) {
      $stmt = $mysqli->query('SELECT SUM(OC.TotalPrice) AS Price, ((SUM(Amount) / Maxseats) * 100) AS PercentageSold, R.Name, RS.StartTime, RS.RSessionID FROM OrderCart AS OC JOIN RestaurantSessions AS RS ON OC.RSessionID = RS.RSessionID JOIN Restaurant AS R ON R.RestaurantID = RS.RestaurantID WHERE OC.RSessionID IS NOT NULL AND OC.RSessionID = '.$i);
      $item = mysqli_fetch_object($stmt);
      array_push($revenueList, $item);
    }
  }
  return $revenueList;
}

?>
