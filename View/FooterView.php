<!DOCTYPE html>
<?php require_once '../Controller/IndexController.php';
$indexObject = new IndexController(); ?>
<html lang="en" dir="ltr">
  <head>
    <?php $indexObject->SetMetaTags('', 'FooterStyle') ?>
  </head>
  <body>
    <footer>
      <ul>
        <li><a href="#Instagram"><img src="../Assets/InstagramIcon.png" class="Icon" id="InstagramIcon" alt="Instagram_Icon"><p id="Instagramtext">Instagram</p></a></li>
        <li><a href="#Facebook"><img src="../Assets/FacebookIcon.png" class="Icon" id="FacebookIcon" alt="Instagram_Icon"><p id="facebooktext">Facebook</p></a></li>
        <li><p>Haarlem Festival</p></li>
        <li><p>Zijlweg 7</p></li>
        <li><p>1234AA Haarlem</p></li>
        <li><a href="ContactView.php">Contact</a></li>
        <li><a href="LoginView.php">Volunteer Login</a></li>
      </ul>
    </footer>
  </body>
</html>
