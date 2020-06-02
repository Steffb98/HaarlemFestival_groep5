<?php
require_once '../DAL/JazzDAL.php';

$jazzObject = new JazzDAL();

if (isset($_POST['JazzSearchBar']))
{
  $search = $_POST['JazzSearchBar'];
  if(strlen($search) >= 3){
    $search = "%".$search."%";
    $bandID = $jazzObject->GetBandIDSearchDB($search);

    if (mysqli_num_rows($bandID) > 0)
    {
      $bandID1 = mysqli_fetch_assoc($bandID);
      $_SESSION['FoundBandName'] = $bandID1;
      $_SESSION['FoundBands'] = mysqli_fetch_array($jazzObject->getBandSessionsWithBandID($bandID1['BandID']));
      header('location:JazzView.php');
      die();
    }
    else {
      $_SESSION['JazzSearchError'] = 'There were no results with this search.';
      header('location:JazzView.php');
      die();
    }
  }
  else {
    $_SESSION['JazzSearchError'] = 'Your search must be atleast 3 characters long';
    header('location:JazzView.php');
    die();
  }
}

class JazzController
{
  public $Object;

  function __construct()
  {
    $this->Object = new JazzDAL();
  }

  public function getBandSessions()
  {
    return $this->Object->getBandSessionsDB();
  }
  public function getBandSession($sessionID)
  {
    return $this->Object->getBandSessionDB($sessionID);
  }
  public function getBandName($id)
  {
    return $this->Object->getBandNameDB($id);
  }

  public function getHall($locationID)
  {
    return $this->Object->getHallDB($locationID);
  }

  public function getJazzBand($bandID)
  {
    return $this->Object->getJazzBandDB($bandID);
  }

  public function get_IdJazz($name)
  {
    return $this->Object->getJazzId($name);
  }

  public function get_AddressJazz($hall){
    return $this->Object->get_AddressJazzDB($hall);
  }

  public function GetEarliestDate(){
    $startTime = $this->Object->GetEarliestDateDB();
    $earliestDate = $startTime->format('Y-m-d');
    return $earliestDate;
  }
}
?>
