<?php
require_once ('DbConn.php');
require_once '../Model/FoodModel.php';
$mysqli = Singleton::getInstance();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class RestaurantDAL
{
  function __construct()
  {
    // code...
  }
  public Function get_allRestaurants()
  {
    global $mysqli;
    $restaurants = array();
    $stmt = $mysqli->query('SELECT * FROM Restaurant');
    if($stmt != ''){
      foreach ($stmt as $item) {
        $tempItem = new FoodModel($item["RestaurantID"], $item["Name"],$item["Kitchen"], $item["Stars"], $item["Fish"], $item["Text"], $item["Price"], $item["Location"], $item["IMG"]);
        array_push($restaurants, $tempItem);
      }
    }
    return $restaurants;
  }
  public Function get_allSessions($id)
  {
    global $mysqli;
    $sessions = array();
    $sql = "SELECT * FROM RestaurantSessions WHERE RestaurantID = ?";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt = $stmt->get_result();
    if($stmt != ''){
      while ($item=mysqli_fetch_object($stmt)){
        array_push($sessions, $item);
      }
    }
    return $sessions;
  }
  public Function get_Location($name)
  {
    global $mysqli;
    $sql = "SELECT Location FROM Restaurant WHERE Name = ?";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s",$name);
    $stmt->execute();
    $result = $stmt->get_result();
    return $row = mysqli_fetch_assoc($result);
  }
  public Function get_allKitchen()
  {
    global $mysqli;
    $KitchenArray = array();
    $stmt = $mysqli->query("SELECT DISTINCT substring_index(substring_index(Kitchen, ', ', 1), ',', -1) Kitchen from Restaurant union
    select substring_index(substring_index(Kitchen, ',', 2), ' ', -1) Kitchen from Restaurant union
    select substring_index(substring_index(Kitchen, ',', 3), ' ', -1) Kitchen from Restaurant");
    if($stmt != ''){
      while ($item=mysqli_fetch_object($stmt)){
        array_push($KitchenArray, $item);
      }
    }
    return $KitchenArray;
  }
  public function get_restaurant_id($Rname)
  {
    global $mysqli;
    $sql = "SELECT RestaurantID FROM Restaurant WHERE Name = ?";
    $stmt = $mysqli->stmt_init();
    $stmt->prepare($sql);
    $stmt->bind_param("s",$Rname);
    $stmt->execute();
    $result = $stmt->get_result();
    return $row = mysqli_fetch_assoc($result);
  }
}



?>
