<!DOCTYPE html>
<?php
session_start();
include_once('SideBars.php');
require('../Controller/VolunteerController.php');
if($loggedInUser->Function != 3){
  header('location: DashboardView.php');
}
?>
<html>
<head>
  <title>CMS Volunteer</title>
  <link rel="stylesheet" href="../CSS/VolunteerStyle.css">
</head>
<body>
  <form method="get" class="Search">
    <input type="text" value="<?php if(isset($_GET['S'])){echo $_GET['S'];}?>" placeholder="<?php if(isset($_GET['S'])){echo $_GET['S'];} else{echo 'Search users';}?>" name="S">
    <button type="submit"><i class="fa fa-search"></i></button>
  </form>
  <div class="Table">
    <div class="Head">
      <p id="Name">Name</p>
      <p id="Email">Email</p>
      <p id="Rank">Rank</p>
    </div>
    <div class="Body">
      <?php if(isset($_SESSION['CMS_VolunteerList'])){ foreach ($_SESSION['CMS_VolunteerList'] as $key => $volunteer) { ?>
        <div>
          <form method="get">
            <input type="hidden" name="VolunteerId" value="<?php echo $volunteer->VolunteerID; ?>"/>
            <input type="submit" name="Name" class="Name" value="<?php echo $volunteer->FirstName, " ", $volunteer->LastName; ?>"/>
          </form>
          <p id="Email"><?php echo $volunteer->Email; ?></p>
          <p id="Rank"><?php echo $volunteer->Function; ?></p>
        </div>
      <?php }
    } ?>
  </div>
</div>
<section id="ChangeVolunteer">
  <h2>Change Volunteer</h2>
  <form method="post">
    <?php
    if(isset($_SESSION['CMS_EditVolunteer'])) {$editVolunteer = $_SESSION['CMS_EditVolunteer'];}
    if(isset($_SESSION['ActivityAECAErr'])) {$editActivityErr = $_SESSION['ActivityAECAErr'];}
    ?>
    <p>First name <input type="text" name="VFirstName" value="<?php if(isset($editVolunteer)){echo $editVolunteer->FirstName;} ?>"required></p>
    <p>Last name <input type="text" name="VLastName" value="<?php if(isset($editVolunteer)){echo $editVolunteer->LastName;} ?>"required></p>
    <p>Email <input type="email" name="VEmai" value="<?php if(isset($editVolunteer)){echo $editVolunteer->Email;}?>" required></p>
    <p>Rank <input type="number" min="1" max="3" name="VRank" value="<?php if(isset($editVolunteer)){echo $editVolunteer->Function;}?>" required></p>
    <p>RegisterDate <input name="VRegisterDate" placeholder="dd-mm-yyyy" value="<?php if(isset($editVolunteer)){echo date("d-m-Y",strtotime($editVolunteer->RegisterDate));}?>" required></p>
    <p id="Error"><?php if(isset($_SESSION['CMS_VolunteerErr'])){echo $_SESSION['CMS_VolunteerErr'];} ?></p>
    <input type="submit" name="VSubmit" value="Change">
    <input type="submit" name="VDelete" value="Delete" formnovalidate>
    <input type="submit" name="VLogin" value="Login" formnovalidate>
  </form>
</section>
<section id="Activities">
  <h2>Activities</h2>
  <div class="CardHolder">
    <?php if(isset($_SESSION['VActivity'])){
      $activityList = $_SESSION['VActivity'];
      if($activityList != NULL){
        for ($i=0; $i <= 3; $i++) {
          if(isset($activityList[$i]) != NULL){?>
            <div class="Activity">
              <p><span>Date: </span><?php echo date("d-m-Y G:i", strtotime($activityList[$i]->Time)) ?></p>
              <p><?php echo $activityList[$i]->Description;?></p>
            </div>
          <?php }
        }
      }
    }?>
  </div>
</section>
<section id="NewVolunteer">
  <h2>New Volunteer</h2>
  <form method="post">
    <?php
    if(isset($_SESSION['CMS_NewVolData'])) {$newVol = $_SESSION['CMS_NewVolData'];}
    if(isset($_SESSION['CMS_NewVolErr'])) {$newVolErr = $_SESSION['CMS_NewVolErr'];}
    ?>
    <p>Email <input type="email" name="VNEmail" value="<?php if(isset($newVol)){echo $newVol[0];}?>" required></p>
    <p>Rank <input type="number" min="1" max="3" name="VNRank" value="<?php if(isset($newVol)){echo $newVol[1];}?>" required></p>
    <p id="Error"><?php if(isset($_SESSION['CMS_NewVolErr'])){echo $_SESSION['CMS_NewVolErr'];} ?></p>
    <input type="submit" name="VNSubmit" value="Add">
  </form>
</section>
</body>


<script>
var editPopup = document.getElementById("ChangeVolunteer");
var activitypopup = document.getElementById("Activities");

if (/VolunteerId/.test(window.location.href)){
  editPopup.style.pointerEvents = "auto";
  editPopup.style.opacity = "1";
  editPopup.scrollIntoView();

  activitypopup.style.pointerEvents = "auto";
  activitypopup.style.opacity = "1";
}
</script>

</html>
