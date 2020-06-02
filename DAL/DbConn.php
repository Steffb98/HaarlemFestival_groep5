<?php
class Singleton{
  //simple singelton class
  private static $instance = null;

  private function __construct()
  {
  }

  public static function getInstance()
  {
    if (self::$instance == null)
    {
      self::$instance = new mysqli('hfteam5.infhaarlem.nl', 'hfteam5', 'Q7hPJxxbD', 'hfteam5_HaarlemFestival');
    }
    return self::$instance;
  }
}

?>
