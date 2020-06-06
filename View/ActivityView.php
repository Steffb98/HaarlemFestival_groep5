<!DOCTYPE html>
<?php
session_start();
include_once('SideBars.php');
require('../Controller/ActivityController.php');

$getActivity = new GetActivity();
$getActivity->GetActivity();
?>
<html>
<head>
  <title>CMS Activity</title>
  <link rel="stylesheet" href="../CSS/ActivityStyle.css">
</head>
<body>
  <section class="cardHolder">
    <?php $days = $_SESSION['days'];
    if($days != NULL){
      foreach ($days as $key1) {
        if ($key1 != NULL){  ?>
          <div class="card">
            <h2><?php if($key1 != NULL){echo date("l d F", strtotime($key1[0]->Time));} ?></h2>
            <?php foreach ($key1 as $key){?>
              <div class="TimeActivity">
                <a><?php echo date("H:i",strtotime($key->Time)); ?></a>
                <i class="far fa-circle"></i>
                <div id="Description">
                  <a><?php echo $key->Description?></a>
                  <a id="DLocation"><?php echo "<br/>", "Aanwezig bij: ", $key->Location; ?></a>
                </div>
              </div>
            <?php } ?>
          </div>
        <?php }
      }
    }
    else{?>
      <div class="card" id="ActivityCard">
        <h2>no activities yet</h2>
      </div>
    <?php } ?>
  </section>
</body>
</html>
