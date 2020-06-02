<!DOCTYPE html>
<?php
session_start();
require '../Controller/IndexController.php';

$indexObject = new IndexController();

//This array  will get the relevant text/information for the homepage
$info = array();
$info = $indexObject->getInfoText();


//these arrays will get the most recent news and updates, the first argument shows if its a half-sized(0) or fullsized(1) update, the second
//argument shows if it should be the most recent news/update(0) or less recent news/update(1)
$update1 = $indexObject->getUpdate(0, 0);
$update2 = $indexObject->getUpdate(0, 1);
$update3 = $indexObject->getUpdate(1, 0);
?>

<html>
  <head>
    <?php $indexObject->SetMetaTags('Home', 'IndexStyle') ?>
  </head>
  <body>

    <div class="video">
      <video autoplay loop>
        <source src="../Assets/filmpjeFinalVersion.mp4" type="video/mp4">
      </video>
      <input type="image" src="../Assets/arrow down.png" alt="Scroll down" id="buttonscrolldown" onclick="document.getElementById('navbar').scrollIntoView();">
    </div>

    <div id="navbar">
      <?php include_once('NavbarView.php'); ?>
    </div>

    <div class="background">
    </div>

    <?php  ?>

    <div class="section" id="introHP">
      <h1 class="introtext" id="introHF"><?php echo $info[0]["InfoText"] ?></h1>
      <p class="introtext" id="dateHF"><?php echo $info[1]["InfoText"]; ?></p>
      <p class="introtext" id="introtext"><?php echo $info[2]["InfoText"]; ?></p>
    </div>

    <div class="section" id="jazzHP">
      <div class="textcontainer">
        <h1 class="sectiontext" id="sectiontitle">Jazz</h1>
        <p class="sectiontext" id="sectiontext"><?php echo $info[3]["InfoText"]; ?></p>
        <a class="sectionlink" href="JazzView.php">More information</a>
      </div>
      <div class="imgcontainer" id="jazzimg">
      </div>
    </div>

    <div class="section" id="danceHP">
      <div class="imgcontainer" id="danceimg">
      </div>
      <div class ="textcontainer" id="dancetextcontainer">
        <h1 class="sectiontext" id="sectiontitle">Dance</h1>
        <p class="sectiontext" id="sectiontext"><?php echo $info[4]["InfoText"]; ?></p>
        <a class="sectionlink" href="#dance">More information</a>
      </div>
    </div>

    <div class="section" id="foodHP">
      <div class ="textcontainer" id="foodtextcontainer">
        <h1 class="sectiontext" id="sectiontitle">Food</h1>
        <p class="sectiontext" id="sectiontext"><?php echo $info[5]["InfoText"]; ?></p>
        <a class="sectionlink" href="food.php">More information</a>
      </div>
      <div class="imgcontainer" id="foodimg">
      </div>
    </div>

    <div class="updateblock" id="updatesheader">
      <h1 class="sectiontext" id="sectiontitle">Haarlem Festival News and Updates</h1>
    </div>

    <div class="updateblock" id="halfupdatecontainer">
      <div class="halfupdates" id="halfupdate1">
        <h1 class="sectiontext" id="sectiontitle"><?php if ($update1['Sort'] == 0) {echo 'Update:';} else{echo 'News';} ?></h1>
        <p class="sectiontext" id="updatetext"><?php echo $update1['Text']; ?></p>
        <p class="sectiontext" id="datetexthalf"><?php echo date('d-m-Y', strtotime($update1['Date'])); ?></p>
      </div>

      <div class="halfupdates" id="halfupdate2">
        <h1 class="sectiontext" id="sectiontitle"><?php if ($update2['Sort'] == 0) {echo 'Update:';} else{echo 'News';} ?></h1>
        <p class="sectiontext" id="updatetext"><?php echo $update2['Text']; ?></p>
         <p class="sectiontext" id="datetexthalf"><?php echo date('d-m-Y', strtotime($update2['Date'])); ?></p>
      </div>
    </div>

    <div class="updateblock" id="fullupdatecontainer">
      <h1 class="sectiontext" id="sectiontitle"><?php if ($update3['Sort'] == 0) {echo 'Update:';} else{echo 'News';} ?></h1>
      <p class="sectiontext" id="updatetext"><?php echo $update3['Text']; ?></p>
      <p class="sectiontext" id="datetextfull"><?php echo date('d-m-Y', strtotime($update3['Date'])); ?></p>
    </div>

    <div class="footer">
      <?php include_once('FooterView.php') ?>
    </div>
  </body>
</html>
