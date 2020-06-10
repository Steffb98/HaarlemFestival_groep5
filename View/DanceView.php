<?php
require '../Controller/IndexController.php';
require '../Controller/DanceController.php';

$indexObject = new IndexController();
$danceObject = new DanceController();

?>
<head>
<?php $indexObject->SetMetaTags('Dance evenement','DanceStyle')?>

</head>

<body onload="Change('Friday July 27', '2020-07-27')">

  <div id="DanceNavbar">
		<?php include_once('NavbarView.php'); ?>
	</div>

  <header class="header"></header>

  <?php
  $intro = $indexObject->getInfoText();
  ?>

  <div class="section" id="introdancepage">
    <h1 class="dancetext" id="introdancetitle">Dance</h1>
    <p class="dancetext" id="introdancetext"><?php echo $intro[7]['InfoText']; ?></p>
    <div class="backgroundsection1">
    </div>
  </div>

  <div class="section" id="dancedjbanner" onclick="ShowMTDJ()">
    <h1 class="dancetext" id="MTDJtitle"> Meet the DJ's</h1>
    <p class="dancetext" id="MTDJtext">Click on this banner for an overview of all the dj's!</p>
  </div>

  <div class="section" id="MTDJpopout" style="display: none">
    <div class="MTDJjazzrows">
      <?php for ($DJID=1; $DJID <= 6; $DJID++) {
        $rowband = $danceObject->getDanceDJ($DJID);
        ?>
        <div class="MTDJspecificdj" id="dancedjrow">
          <img class="fotodjs" src=../Assets/<?php echo $rowband["IMG"] ?>>
          <div class="MTDJdancenamebackground">
            <p class="MTDJspecificname"><?php echo $rowband["Name"] ?></p>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>

  <div class="section" id="date">
		<h3 id="ticketstext"> Tickets </h3>
		<button type="button"	id="2020-07-27" class="btn" name="Friday July 27"  onclick="Change(this.name,this.id)" >Friday</br> July 27th</button>
		<button type="button"	id="2020-07-28" class="btn" name="Saturday July 28" onclick="Change(this.name,this.id)" >Saturday</br> July 28th</button>
		<button type="button"	id="2020-07-29" class="btn" name="Sunday July 29"  onclick="Change(this.name,this.id)">Sunday</br> July 29th</button>
    <button type="button"	id="combiticket" class="btn" name="combitickets"  onclick="Change(this.name,this.id)">Combitickets</button>
</div>

<div class="section" id="danceticketcontainerreg">
  <h1 class="dancetext" id="danceticketdate"></h1>
  <table class="dancetickettable" id="dancetickettable26">
    <tr>
      <th>DJ</th>
      <th>Time</th>
      <th>Club</th>
      <th>Price</th>
      <th>Amount</th>
    </tr>
    <?php
    $dancesessions = $danceObject->getDJSessions();
    foreach ($dancesessions as $rowSessions) {
      $rowDJs = $danceObject->getDJName($rowSessions["DJID"]);
      $rowLocation = $danceObject->getLocation($rowSessions["LocationID"]);
      $date = date('Y-m-d', strtotime($rowSessions["StartTime"]));
      ?>
      <tr class="dancetickettr" data-id=<?php echo $date ?>>
        <td class="danceDJnames" id="<?php echo $rowDJs["Name"] ?>" data-id=<?php echo $date ?>><?php echo $rowDJs["Name"] ?></td>
        <?php $starttime = date('H:i', strtotime($rowSessions["StartTime"]));
        $endtime = date('H:i', strtotime($rowSessions["EndTime"]));
        $timespan = $starttime." - ".$endtime;?>
        <td class="dancetimespan" id="<?php echo $timespan ?>" data-id=<?php echo $date ?>><?php echo $timespan ?></td>
        <td class="dancelocationnames" id="<?php echo $rowLocation['Venue'] ?>" data-id=<?php echo $date; ?>><?php echo $rowLocation["Venue"] ?></td>
        <td class="danceprices" id="<?php echo "€".number_format($rowSessions["Price"],2,',', ' ' )." p.p." ?>" data-id=<?php echo $date; ?>><?php echo "€".number_format($rowSessions["Price"],2,',', ' ' )." p.p." ?></td>
        <td><select class="danceticketamountreg" data-id=<?php echo $date ?>>
          <?php
          for ($i=1; $i<=10; $i++){
            echo "<option value="; echo $i; echo ">"; echo $i; echo "</option>";
          }
          ?>
        </select></td>
        <td class="dancecartbutton" data-id=<?php echo $date ?>>
          <button type="button" name="danceticketbutton" class="dancebuttonticket">
            <img src="../Assets/white-shopping-cart-icon-9.jpg" alt="shoppingcart" id="danceticketshoppingcart"></td>
          </button>
        </tr>
      <?php } ?>
    </table>
  </div>

  <div class="section" id="danceticketcontainerregcombi" style="display: none">
    <h1 class="dancetext" id="danceticketdate">Combi tickets</h1>
    <table class="dancetickettable" id="dancetickettable">
      <tr>
        <th>Type of ticket</th>
        <th>Time</th>
        <th>Club</th>
        <th>Price</th>
        <th>Amount</th>
      </tr>
      <?php
      $dancesessions = $danceObject->getDJSessionsAllDays();
      foreach ($dancesessions as $rowSessions) {
        $rowDJs = $danceObject->getDJName($rowSessions["DJID"]);
        $rowLocation = $danceObject->getLocation($rowSessions["LocationID"]);
        $date = date('Y-m-d', strtotime($rowSessions["StartTime"]));
        ?>
        <tr class="dancetickettr" data-id=<?php echo $date ?>>
          <td class="danceDJnames" id="<?php echo $rowDJs["Name"] ?>" data-id=<?php echo $date ?>><?php echo $rowDJs["Name"] ?></td>
          <?php $starttime = date('H:i', strtotime($rowSessions["StartTime"]));
          $endtime = date('H:i', strtotime($rowSessions["EndTime"]));
          $timespan = $starttime." - ".$endtime;?>
          <td class="dancetimespan" id="<?php echo $timespan ?>" data-id=<?php echo $date ?>><?php echo $timespan ?></td>
          <td class="dancelocationnames" id="<?php echo $rowLocation['Venue'] ?>" data-id=<?php echo $date; ?>><?php echo $rowLocation["Venue"] ?></td>
          <td class="danceprices" id="<?php echo "€".number_format($rowSessions["Price"],2,',', ' ' )." p.p." ?>" data-id=<?php echo $date; ?>><?php echo "€".number_format($rowSessions["Price"],2,',', ' ' )." p.p." ?></td>
          <td><select class="danceticketamountreg" data-id=<?php echo $date ?>>
            <?php
            for ($i=1; $i<=10; $i++){
              echo "<option value="; echo $i; echo ">"; echo $i; echo "</option>";
            }
            ?>
          </select></td>
          <td class="dancecartbutton" data-id=<?php echo $date ?>>
            <button type="button" name="danceticketbutton" class="dancebuttonticketCombi">
              <img src="../Assets/white-shopping-cart-icon-9.jpg" alt="shoppingcart" id="danceticketshoppingcart"></td>
            </button>
          </tr>
        <?php } ?>
      </table>
    </div>

    <form action= "../Controller/DanceAddToCartController.php" id="addToCart" class="modal fade" role="dialog" method="post">
      <h4 dance="dance2text" id="dancemodalheader">Would you like to add the following tickets to your cart?</h4>
      <div  class= "modal-name" id= "modal-name" style="margin-left: 7vw; padding: 0.5vw;"></div>
      <div  class= "modal-time" id= "modal-time" style="margin-left: 7vw; padding: 0.5vw;"></div>
      <div  class= "modal-price" id= "modal-price" style="margin-left: 7vw; padding: 0.5vw;"></div>
      <div  class= "modal-number" id= "modal-number" style="margin-left: 7vw; padding: 0.5vw;"></div>
      <div  class= "modal-number" id= "modal-hall" style="margin-left: 7vw; padding: 0.5vw;"></div>

      <input type="hidden" id="modal-nameField" name="name" value=" ">
      <input type="hidden" id="modal-timeField" name="time" value=" ">
      <input type="hidden" id="modal-priceField" name="price" value=" ">
      <input type="hidden" id="modal-numberField" name="number" value=" ">
      <input type="hidden" id="modal-hallField" name="hall" value=" ">
      <input type="hidden" id="modal-dateField" name="date" value=" ">

      <input type="submit" value="cancel" name="cancel"class="cancelbtn">
      <input type="submit" value="Confirm, continue shopping" name="continue"class="confirmbtn" rel="modal:close">
      <input type="submit" value="Confirm, go to cart" class="confirmbtn" name="confirm" rel="modal:close">
    </form>

<div id="DanceFooter">
  <?php include_once('FooterView.php'); ?>
</div>



</body>

<script type="text/javascript">
var date;

function ShowMTDJ(){
  var displayMTDJ = document.getElementById("MTDJpopout");
  if (displayMTDJ.style.display=="none") {
    document.getElementById("MTDJpopout").style.display="inline-block";
    document.getElementById("date").style.top = "200%";
    document.getElementById("danceticketcontainerregcombi").style.top = "240%";
    document.getElementById("danceticketcontainerreg").style.top = "240%";
    document.getElementById("DanceFooter").style.top = "120vw";

  }
  else {
    document.getElementById("MTDJpopout").style.display="none";
    document.getElementById("date").style.top = "110%";
    document.getElementById("danceticketcontainerregcombi").style.top = "145%";
    document.getElementById("danceticketcontainerreg").style.top = "145%";
    document.getElementById("DanceFooter").style.top = "80vw";
  }
}

$(document).ready(function(){
  // code to read selected table rowb cell data (values).
  $(".dancebuttonticket").on('click',function(){
    var currentRow=$(this).closest("tr");
    var colName=currentRow.find("td:eq(0)").attr('id');
    var colTime=currentRow.find("td:eq(1)").attr('id');
    var colHall=currentRow.find("td:eq(2)").attr('id');
    var colPrice=currentRow.find("td:eq(3)").attr('id');
    var colAmount=currentRow.find(".danceticketamountreg option:selected").attr('value');
    var colDate=date;
    $("#modal-name").html("DJ: "+colName);
    $("#modal-time").html("Time: "+colTime);
    $("#modal-hall").html("Location: "+colHall);
    $("#modal-price").html("The price: "+colPrice);
    $("#modal-number").html("Number of tickets: "+colAmount);
    document.getElementById("modal-nameField").value = colName;
    document.getElementById("modal-timeField").value = colTime;
    document.getElementById("modal-hallField").value = colHall;
    document.getElementById("modal-priceField").value = colPrice;
    document.getElementById("modal-numberField").value = colAmount;
    document.getElementById("modal-dateField").value = colDate;
    $('#addToCart').modal('show');
  });
});

$(document).ready(function(){
  $(".dancebuttonticketCombi").on('click',function(){
    var currentRow=$(this).closest("tr");
    var colName=currentRow.find("td:eq(0)").attr('id');
    var colTime=currentRow.find("td:eq(1)").attr('id');
    var colHall="All competing clubs";
    var colPrice=currentRow.find("td:eq(2)").attr('id');
    var colAmount=currentRow.find(".danceticketamountreg option:selected").attr('value');
    var colDate=date;
    $("#modal-name").html(colName);
    $("#modal-time").html("Time: "+colTime);
    $("#modal-hall").html("Location: "+colHall);
    $("#modal-price").html("The price: "+colPrice);
    $("#modal-number").html("Number of tickets: "+colAmount);
    document.getElementById("modal-nameField").value = colName;
    document.getElementById("modal-timeField").value = colTime;
    document.getElementById("modal-hallField").value = colHall;
    document.getElementById("modal-priceField").value = colPrice;
    document.getElementById("modal-numberField").value = colAmount;
    document.getElementById("modal-dateField").value = colDate;
    $('#addToCart').modal('show');
  });
});

function Change(name,id)
{
  date = id;
  document.getElementById("danceticketdate").innerHTML = name;
  document.getElementsByTagName("table")[0].setAttribute("id",id);

  if (id == 'combiticket') {
    document.getElementById("danceticketcontainerreg").style.display="none";
    document.getElementById("danceticketcontainerregcombi").style.display="inline-block";
  }
  else
  {
    document.getElementById("danceticketcontainerreg").style.display="inline-block";
    document.getElementById("danceticketcontainerregcombi").style.display="none";
    $(".danceDJnames").hide();
    $(".danceDJnames[data-id='" + id + "']").show();
    $(".dancetimespan").hide();
    $(".dancetimespan[data-id='" + id + "']").show();
    $(".dancelocationnames").hide();
    $(".dancelocationnames[data-id='" + id + "']").show();
    $(".danceprices").hide();
    $(".danceprices[data-id='" + id + "']").show();
    $(".danceticketamountreg").hide();
    $(".danceticketamountreg[data-id='" + id + "']").show();
    $(".dancecartbutton").hide();
    $(".dancecartbutton[data-id='" + id + "']").show();
    $(".dancetickettr").hide();
    $(".dancetickettr[data-id='" + id + "']").show();
  }
}

</script>
