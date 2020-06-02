<!DOCTYPE html>
<?php
session_start();
include_once('SideBars.php');
require('../Controller/UpdateController.php');

$getUpdates = new GetUpdates();
$getUpdates->GetUpdates2();
?>
<html>
<head>
  <title>CMS Updates</title>
  <link rel="stylesheet" href="../CSS/UpdateStyle.css">
</head>
<body>
  <div class="cardHolder">
    <?php $updates = $_SESSION['Updates'];
    foreach ($updates as $key) {?>
      <section class=card>
        <h2><?php if($key->Sort == 0){echo "News:";} else{echo "Update:";} ?></h2>
          <p id="Date"><?php echo $key->Date; ?></p>
        <p><?php echo $key->Text; ?></p>
      </section>
    <?php } ?>
  </div>
</body>
</html>
