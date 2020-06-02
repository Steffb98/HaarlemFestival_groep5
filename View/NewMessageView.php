<!DOCTYPE html>
<?php
session_start();
include_once('SideBars.php');
require('../Controller/NewMessageController.php');

?>
<html>
<head>
  <title>CMS New message</title>
  <link rel="stylesheet" href="../CSS/NewMessageStyle.css">
</head>
<body>
  <div class="MessageArea">
    <h2>New message</h2>
    <form method="post">
      <input type="submit" name="NMSubmit" value="Send"></input>
      <div>
      <label for="Subject">Subject: <span><?php if(isset($_SESSION['NewMessageErr'])){echo $_SESSION['NewMessageErr'];} ?></span></label>
        <input type="text" id="Subject" name="Subject" value="<?php if(isset($_SESSION['NewMessageData'])){echo $_SESSION['NewMessageData'][0];} ?>" required>
      </div>
      <p>message:</p>
      <textarea id="Text" name="Text" rows="9" cols="86" required><?php if(isset($_SESSION['NewMessageData'])){echo $_SESSION['NewMessageData'][1];} ?></textarea>
    </form>
  </div>
</body>
</html>
