<?php
require_once '../Model/RestaurantModel.php';

class RestaurantController
{

public $Object;

  function __construct()
  {
  $this->Object = new RestaurantModel();
  }

  public function get_all()
  {
    return $this->Object->get_allRestaurants();
  }
  public function get_Kitchen()
  {
    return $this->Object->get_allKitchen();
  }
  public function get_sessions($id)
  {
    return  $this->Object->get_allSessions($id);
  }
  public function get_LocationRestaurant($name)
  {
    return  $this->Object->get_Location($name);
  }
  public function get_RestaurantID($Rname)
  {
    return  $this->Object->get_restaurant_id($Rname);
  }

}


?>
