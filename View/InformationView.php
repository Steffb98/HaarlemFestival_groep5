<?php
session_start();
include_once('SideBars.php');
require('../Controller/InformationController.php');
if($loggedInUser->Function != 3){
  header('location: DashboardView.php');
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>CMS Edit Information</title>
  <link rel="stylesheet" href="../CSS/InformationStyle.css">
</head>
<body>
  <form class="EditTabs" method="get">
    <input type="submit" name="Edit" value="Edit Home">
    <input type="submit" name="Edit" value="Edit Jazz">
    <input type="submit" name="Edit" value="Edit Dance">
    <input type="submit" name="Edit" value="Edit Restaurant">
  </form>

  <section class="EditPanel">
    <?php if(isset($_SESSION['Information'])){
      $informationList = $_SESSION['Information'];
      if(isset($_SESSION['InformationErr'])){echo '<p>'.$_SESSION['InformationErr'].'</p>';}?>
      <form class="Information" method="post">
        <?php foreach ($informationList as $key) {?>
          <span><?php echo $key->Page.": "; ?></span>
          <textarea type="text" rows="4" cols="59" name="<?php echo $key->TextID."_".$key->Page; ?>"><?php echo $key->InfoText; ?></textarea>
        <?php } ?>
      <input type="submit" name="InfSubmit" value="Submit">
    <?php } ?>
    </form>
  </section>
</body>

</html>
