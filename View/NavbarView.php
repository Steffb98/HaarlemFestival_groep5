<!DOCTYPE html>
<?php require_once '../Controller/IndexController.php';
$indexObject = new IndexController(); ?>
<html lang="en" dir="ltr">
  <head>
    <?php $indexObject->SetMetaTags('', 'NavBarStyle') ?>
  </head>
  <body>
    <nav>
      <ul>
        <li><a href="../IndexView.php" ><img  src="../Assets/Haarlem FestivalLogo2.png" alt="logo" class="logo"></a></li>
        <li><a href="JazzView.php"><p class="navbartext" id="navbarjazztext">Jazz Festival</p></a></li>
        <li><a href="danceView.php"><p class="navbartext" id="navbardancetext">Dance Festival</p></a></li>
        <li><a href="food.php"><p class="navbartext" id="navbarfoodtext">Food Festival</p></a></li>
        <li><a href="ContactView.php" id="contact"><p class="navbartext" id="navbarcontacttext">Contact</p></a></li>
        <li><a href="#updates"><p class="navbartext" id="navbarnewstext">News and Updates</p></a></li>
        <li><a href="UserloginView.php" class="iconlink"><img src="../Assets/HoofdBlank.png" alt="user" id="userimg"></a></li>
        <li><a href="cartView.php" class="iconlink"><img src="../Assets/white-shopping-cart-icon-9.jpg" alt="shoppingcart" id="shoppingcart"></a></li>
      </ul>
    </nav>
  </body>
</html>
