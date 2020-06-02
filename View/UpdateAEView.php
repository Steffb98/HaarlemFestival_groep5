<!DOCTYPE html>
<?php
session_start();
include_once('SideBars.php');
require('../Controller/UpdateAEController.php');
if($loggedInUser->Function != 3){
  header('location: DashboardView.php');
}
?>
<html>
<head>
  <title>CMS Edit Updates</title>
  <link rel="stylesheet" href="../CSS/UpdateStyle.css">
  <link rel="stylesheet" href="../CSS/UpdateAEStyle.css">
</head>
<body>
  <section class="NewUpdate">
    <h2>New update</h2>
    <?php
    if(isset($_SESSION['UpdateAEData'])){$data = $_SESSION['UpdateAEData'];}
    if(isset($_SESSION['UpdateAEErr'])){$err = $_SESSION['UpdateAEErr'];
      echo '<p>'.$err.'</p>';}else{echo '<p> </p>';}?>
      <form method="post">
        <div class="TextBox">
          <label for="UpdNew">Text</label>
          <textarea name="Text" rows="8" cols="80"><?php if(isset($data)){echo $data[0];} ?></textarea>
        </div>

        <div class="checkbox">
          <p>Update/News</p>
          <label class="container">News
            <input type="radio" <?php if(isset($data)){if($data[1] == 'News'){echo 'checked="checked"';}else{echo 'checked="checked"';}}?> name="UpdNew" value="News">
            <span class="checkmark"></span>
          </label>
          <label class="container">Update
            <input type="radio" <?php if(isset($data)){if($data[1] == 'Update'){echo 'checked="checked"';}}?> name="UpdNew" value="Update">
            <span class="checkmark"></span>
          </label>
        </div>

        <div class="checkbox">
          <p>Size</p>
          <label class="container">Big
            <input type="radio" <?php if(isset($data)){if($data[2] == 'Big'){echo 'checked="checked"';}else{echo 'checked="checked"';}}?> name="Size" value="Big">
            <span class="checkmark"></span>
          </label>
          <label class="container">Small
            <input type="radio" <?php if(isset($data)){if($data[2] == 'Small'){echo 'checked="checked"';}}?> name="Size" value="Small">
            <span class="checkmark"></span>
          </label>
        </div>

        <div class="checkbox">
          <p>Font</p>
          <label class="container">Lato
            <input type="radio" <?php if(isset($data)){if($data[3] == 'Lato'){echo 'checked="checked"';}else{echo 'checked="checked"';}}?> name="Font" value="Lato">
            <span class="checkmark"></span>
          </label>
          <label id=SpecialSnowflake class="container">sans-serif
            <input type="radio" <?php if(isset($data)){if($data[3] == 'Sans-serif'){echo 'checked="checked"';}}?> name="Font" value="Sans-serif">
            <span class="checkmark"></span>
          </label>
        </div>
        <input type="submit" name="Preview" value="Preview">
        <input type="submit" name="Cancel" value="Cancel">
        <input type="submit" name="Submit" value="Submit">
        <?php if(isset($data[4])){echo '
          <input type="submit" name="Delete" value="Delete">
          <input type="hidden" name="Hidden" value="'.$data[4].'">';
        } ?>
      </form>
    </section>
    <section id="Preview">
      <?php if(isset($_SESSION['UpdateAEPreview'])){$preview = $_SESSION['UpdateAEPreview']; ?>
      <h2><?php if(isset($preview)){echo $preview[1];}?></h2>
      <p id="Text"><?php if(isset($preview)){echo $preview[0];}?></p>
      <p id="Date"><?php if(isset($preview)){echo $preview[4];}
    }?></p>
  </section>
  <div class="cardHolder">
    <?php $updates = $_SESSION['Updates'];
    foreach ($updates as $key) {?>
      <section class=card>
        <h2><?php if($key->Sort == 0){echo "News:";} else{echo "Update:";
        }?><a href="UpdateAEView.php?UpdID=<?php echo $key->UpdateID;?>"><i class="fas fa-edit"></i></a></h2>
        <p id="Date"><?php echo $key->Date; ?></p>
        <p><?php echo $key->Text; ?></p>
      </section>
    <?php } ?>
  </div>
</body>
<?php
if(isset($preview)){
  if($preview[2] == 'Small'){ echo
    '<script>var preview = document.getElementById("Preview");
    preview.style.width = "20vw";</script>';
  }
  else{ echo
    '<script>var preview = document.getElementById("Preview");
    preview.style.width = "40vw";</script>';
  }
  if($preview[3] == 'Lato'){ echo
    '<script>var preview = document.getElementById("Preview");
    preview.style.fontFamily = "Lato, sans-serif";</script>';
  }
  else{ echo
    '<script>var preview = document.getElementById("Preview");
    preview.style.fontFamily = "sans-serif";</script>';
  }
}?>
</html>
