<?php
require_once '../DAL/RevenueDAL.php';

//make some sessions about the jazz/dance and food sales
$_SESSION['GlobalSalesArray'] = MakeGlobalSalesArray();
$_SESSION['SalesJazzArray'] = CMS_JazzDanceFoodSales2('Jazz');
$_SESSION['SalesDanceArray'] = CMS_JazzDanceFoodSales2('Dance');
$_SESSION['SalesFoodArray'] = CMS_JazzDanceFoodSales2('Food');

function MakeGlobalSalesArray(){
  //make a new array
  $salesArray = array();

  //get all sales from the 3 events
  $jazzSales = CMS_JazzDanceFoodSales2('Jazz');
  $danceSales = CMS_JazzDanceFoodSales2('Dance');
  $foodSales = CMS_JazzDanceFoodSales2('Food');

  //get all jazz sales and add them to one total jazz sales amount
  $jazzTotal = 0;
  foreach ($jazzSales as $key) {
    $jazzTotal += $key->Price;
  }

  //get all dance sales and add them to one total dance sales amount
  $danceTotal = 0;
  foreach ($danceSales as $key) {
    $danceTotal += $key->Price;
  }

  //get all food sales and add them to one total food sales amount
  $foodTotal = 0;
  foreach ($foodSales as $key) {
    $foodTotal += $key->Price;
  }

  //add all totals to one salesarray;
  array_push($salesArray, $jazzTotal);
  array_push($salesArray, $danceTotal);
  array_push($salesArray, $foodTotal);
  return $salesArray;
}
?>
