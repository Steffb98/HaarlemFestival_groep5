<!DOCTYPE html>
<?php
session_start();
include_once('SideBars.php');
require('../Controller/RevenueController.php');
if($loggedInUser->Function != 3){
  header('location: DashboardView.php');
}
?>
<html>
<head>
  <title>CMS Revenue</title>
  <link rel="stylesheet" href="../CSS/RevenueStyle.css">
</head>
<body>
  <?php
  $salesArray = $_SESSION['GlobalSalesArray'];
  $salesJazzArray = $_SESSION['SalesJazzArray'];
  $salesDanceArray = $_SESSION['SalesDanceArray'];
  $salesFoodArray = $_SESSION['SalesFoodArray'];
  ?>
  <h1 id="Jazzh1">Jazz Sales: €<?php echo $salesArray[0]; ?>,-</h1>
  <div class="ScrollableTable" id="JazzTable">
    <table>
      <tr>
        <th>Band</th>
        <th>Date</th>
        <th>Revenue</th>
        <th>Percentage sold</th>
      </tr>
      <?php foreach ($salesJazzArray as $key) {
        if($key->Name != ''){?>
          <tr>
            <td><?php echo $key->Name;?></td>
            <td><?php echo $key->StartTime; ?></td>
            <td>€<?php if($key->Price == NULL){echo '0';}else{echo $key->Price;}?></td>
            <td><?php if($key->MaxSeats == 0){echo 'FREE';}else{ if($key->PercentageSold == NULL){echo '0%';}else{echo round($key->PercentageSold,2).'%';}}?></td>
          </tr>
        <?php }
      } ?>
    </table>
  </div>

  <h1 id="Danceh1">Dance Sales: €<?php echo $salesArray[1]; ?>,-</h1>
  <div class="ScrollableTable" id="DanceTable">
    <table>
      <tr>
        <th>DJs</th>
        <th>Date</th>
        <th>Revenue</th>
        <th>Percentage sold</th>
      </tr>
      <?php foreach ($salesDanceArray as $key) {
        if($key->Name != ''){?>
          <tr>
            <td><?php echo $key->Name;?></td>
            <td><?php echo $key->StartTime; ?></td>
            <td>€<?php if($key->Price == NULL){echo '0';}else{echo $key->Price;}?></td>
            <td><?php if($key->PercentageSold == NULL){echo '0%';}else{echo round($key->PercentageSold,2).'%';}?></td>
          </tr>
        <?php }
      } ?>
    </table>
  </div>


  <h1 id="Foodh1">Food Sales: €<?php echo $salesArray[2]; ?>,-</h1>
  <div class="ScrollableTable" id="FoodTable">
    <table>
      <tr>
        <th>Restaurant</th>
        <th>Date</th>
        <th>Revenue</th>
        <th>Percentage sold</th>
      </tr>
      <?php foreach ($salesFoodArray as $key) {
        if($key->Name != ''){?>
          <tr>
            <td><?php echo $key->Name;?></td>
            <td><?php echo $key->StartTime; ?></td>
            <td>€<?php if($key->Price == NULL){echo '0';}else{echo $key->Price;}?></td>
            <td><?php if($key->PercentageSold == NULL){echo '0%';}else{echo round($key->PercentageSold,2).'%';}?></td>
          </tr>
        <?php }
      } ?>
    </table>
  </div>
</body>
</html>
