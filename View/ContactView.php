<!DOCTYPE html>
<?php require_once '../Controller/IndexController.php';
$indexObject = new IndexController(); ?>
<html lang="en" dir="ltr">
  <head>
    <?php $indexObject->SetMetaTags('Contact us', 'ContactStyle') ?>
  </head>
  <body>
    <div id="navbar">
      <?php include_once('NavbarView.php'); ?>
    </div>

    <p id="contacttitle">CONTACT US</p>
    <form class="contact-form" action="../Controller/ContactController.php" method="post">
      <?php if ($_GET['ver'] == "mailsent") { ?>
        <script type="text/javascript">
          alert('Thank you for your mail! We will respond as soon as possible.')
        </script>
      <?php } ?>
      <input type="text" class="contactinput" id="contacttextinput" name="name" placeholder="Full Name">
      <input type="email" class="contactinput" id="contacttextinput" name="mail" placeholder="Your e-mail">
      <input type="text" class="contactinput" id="contacttextinput" name="subject" placeholder="Subject">
      <textarea name="message" class="contactinput" id="contacttextarea" placeholder="Message..."></textarea>
      <button type="submit" id="contactbutton" name="submit">Send mail</button>
    </form>
    <div class="footer">
      <?php include_once('FooterView.php') ?>
    </div>
  </body>
</html>
