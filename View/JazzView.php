<!DOCTYPE html>
<!--- LINE 353 wtf gebeurt hier --->
<!--- LINE 34 META HEAD TAGs --->
<!--- LINE 58 jazz introtext --->
<!--- LINE 71 MTB banner? --->

<html lang="en" dir="ltr">
<?php
session_start();
if (isset($_SESSION['jazzAddError'])) {
  $error = $_SESSION['jazzAddError'];
  echo '<script type="text/javascript">alert("'.$error.'");</script>';
  unset($_SESSION['jazzAddError']);
}
if (isset($_SESSION['JazzSearchError'])) {
  $jazzSearchError = $_SESSION['JazzSearchError'];
  unset($_SESSION['JazzSearchError']);
}
if (isset($_SESSION['FoundBands'])) {
  $jazzFoundBands = $_SESSION['FoundBands'];
  unset($_SESSION['FoundBands']);
}
else {
  $jazzFoundBands = 0;
}
if (isset($_SESSION['FoundBandName'])) {
  $jazzFoundBandName = $_SESSION['FoundBandName'];
  unset($_SESSION['FoundBandName']);
}
require '../Controller/JazzController.php';
require '../Controller/IndexController.php';

$indexObject = new IndexController();
$jazzObject = new JazzController();
?>
<head>
  <?php $indexObject->SetMetaTags('Jazz evenement', 'JazzStyle') ?>  
</head>
<body onload="ChangeDateDefault()">
  <?php
  $intro = $indexObject->getInfoText();
  ?>
  <div class="jazzbg"></div>

  <div id="jazznavbar">
    <?php include_once('NavbarView.php'); ?>
  </div>
  <div class="banner" id="jazzbanner"></div>

  <div class="section" id="introjazzpage">
    <h1 class="jazztext" id="introjazztitle">Jazz</h1>
    <p class="jazztext" id="introjazztext"><?php echo $intro[6]['InfoText']; ?></p>
    <div class="backgroundsection1">
    </div>
  </div>

  <div class="section" id="jazzbandsbanner" onclick="ShowMTB()">
    <h1 class="jazztext" id="MTBtitle"> Meet the bands</h1>
    <p class="jazztext" id="MTBtext">Click on this banner for an overview of all the bands!</p>
  </div>


  <div class="section" id="MTBpopout" style="display:none">
    <div class="MTBjazzrows">
      <?php for ($bandID=1; $bandID < 6; $bandID++) {
        $rowband = $jazzObject->getJazzBand($bandID);
        ?>
        <div class="MTBspecificband" id="jazzbandsrow1">
          <img class="fotobands" src=../Assets/<?php echo $rowband["IMG"] ?> alt="gumbokings">
          <div class="MTBjazznamebackground">
            <p class="MTBspecificname"><?php echo $rowband["Name"] ?></p>
          </div>
        </div>
      <?php } ?>
    </div>

    <div class="MTBjazzrows">
      <?php for ($bandID=6; $bandID < 11; $bandID++) {
        $rowband = $jazzObject->getJazzBand($bandID);
        ?>
        <div class="MTBspecificband" id="jazzbandsrow2">
          <img class="fotobands" src=../Assets/<?php echo $rowband["IMG"] ?> alt="gumbokings">
          <div class="MTBjazznamebackground">
            <p class="MTBspecificname"><?php echo $rowband["Name"] ?></p>
          </div>
        </div>
      <?php } ?>
    </div>

    <div class="MTBjazzrows">
      <?php for ($bandID=11; $bandID < 16; $bandID++) {
        $rowband =$jazzObject->getJazzBand($bandID);
        ?>
        <div class="MTBspecificband" id="jazzbandsrow3">
          <img class="fotobands" src=../Assets/<?php echo $rowband["IMG"] ?> alt=<?php echo $rowband["Name"] ?>>
          <div class="MTBjazznamebackground">
            <p class="MTBspecificname"><?php echo $rowband["Name"] ?></p>
          </div>
        </div>
      <?php } ?>
    </div>

    <div class="MTBjazzrows" id="MTBjazzrows4">
      <?php for ($bandID=16; $bandID < 19; $bandID++) {
        $rowband = $jazzObject->getJazzBand($bandID);
        ?>
        <div class="MTBspecificband" id="jazzbandsrow4">
          <img class="fotobands" src=../Assets/<?php echo $rowband["IMG"] ?> alt=<?php echo $rowband["Name"] ?>>
          <div class="MTBjazznamebackground">
            <p class="MTBspecificname"><?php echo $rowband["Name"] ?></p>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>

  <div class="section" id="jazzticketdatepicker">
    <h1 class="jazztext" id="jazzdatepickertitle">Program + Buy tickets</h1>
    <button type="button" id="2020-07-26" class="2020-07-26" name="Thursday July 26" onclick="ChangeDate(this.name,this.id)">Thursday the 26th</button>
    <button type="button" id="2020-07-27" class="2020-07-27" name="Friday July 27" onclick="ChangeDate(this.name,this.id)">Friday the 27th</button>
    <button type="button" id="2020-07-28" class="2020-07-28" name="Saturday July 28" onclick="ChangeDate(this.name,this.id)">Saturday the 28th</button>
    <button type="button" id="2020-07-29" class="2020-07-29" name="Sunday July 29" onclick="ChangeDate(this.name, this.id)">Sunday the 29th</button>
    <button type="button" id="Check ticket name" class="jazzcombibutton" name="Combo tickets" onclick="ChangeDate(this.name, this.id)">Combitickets</button>
  </div>



  <!--popup form for adding to cart -->
  <form action="../Controller/JazzAddToCartController.php" id="addToCart" class="modal fade" role="dialog" method="post">
    <h4 jazz="jazztext" id="jazzmodalheader">Would you like to add the following tickets to your cart?</h4>
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

  <div class="section" id="jazzticketcontainerreg">
    <h1 class="jazztext" id="jazzticketdate">Thursday 26 July</h1>
    <table class="jazztickettable" id="jazztickettable26">
      <tr>
        <th>Band</th>
        <th>Time</th>
        <th>Hall</th>
        <th>Price</th>
        <th>Amount</th>
      </tr>
      <?php
      $jazzsessions = $jazzObject->getBandSessions();
      foreach ($jazzsessions as $rowSessions) {
        $rowBands = $jazzObject->getBandName($rowSessions["BandID"]);
        $rowHall = $jazzObject->getHall($rowSessions['LocationID']);

        $date = date('Y-m-d', strtotime($rowSessions["StartTime"]));
        ?>
        <tr class="jazztickettr" data-id=<?php echo $date ?>>
          <td class="jazzbandnames" id="<?php echo $rowBands["Name"] ?>" data-id=<?php echo $date ?>><?php echo $rowBands["Name"] ?></td>
          <?php $starttime = date('H:i', strtotime($rowSessions["StartTime"]));
          $endtime = date('H:i', strtotime($rowSessions["EndTime"]));
          $timespan = $starttime." - ".$endtime;?>
          <td class="jazztimespan" id="<?php echo $timespan ?>" data-id=<?php echo $date ?>><?php echo $timespan ?></td>
          <td class="jazzhallnames" id="<?php echo $rowHall['Venue'] ?>" data-id=<?php echo $date; ?>><?php echo $rowHall['Venue'] ?></td>
          <td class="jazzprices" id="<?php echo "€".number_format($rowSessions["Price"],2,',', ' ' )." p.p." ?>" data-id=<?php echo $date; ?>><?php echo "€".number_format($rowSessions["Price"],2,',', ' ' )." p.p." ?></td>
          <td><select class="jazzticketamountreg" data-id=<?php echo $date ?>>
            <?php
            for ($i=1; $i<=10; $i++){
              echo "<option value="; echo $i; echo ">"; echo $i; echo "</option>";
            }
            ?>
          </select></td>
          <td class="jazzcartbutton" data-id=<?php echo $date ?>>
            <button type="button" name="jazzticketbutton" class="jazzbuttonticket">
              <img src="../Assets/white-shopping-cart-icon-9.jpg" alt="shoppingcart" id="jazzticketshoppingcart"></td>
            </button>
          </tr>
        <?php } ?>
      </table>
    </div>

    <div class="section" id="jazzticketcontainer29" style="display:none">
      <h1 class="jazztext" id="jazzticketdate">Sunday 29 July</h1>
      <table class="jazztickettable" id="jazztickettable29">
        <tr>
          <th>Band</th>
          <th>Time</th>
        </tr>
        <tr>
          <?php
          foreach ($jazzsessions as $rowSessions) {
            if ($rowSessions['BSessionID'] > 18 && $rowSessions['BSessionID'] < 25) {
              $rowBands = $jazzObject->getBandName($rowSessions["BandID"]);
              ?>
              <td><?php echo $rowBands["Name"] ?></td>
              <td><?php $starttime = date('H:i', strtotime($rowSessions["StartTime"]));
              $endtime = date('H:i', strtotime($rowSessions["EndTime"]));
              $timespan = $starttime." - ".$endtime;
              echo $timespan ?></td>
            </tr>
          <?php } } ?>
        </table>
        <div class="jazzticketcontainerinfo29">
          <p>The shows on Sunday 29 July are free to attend for everyone.
            They will take place on the Grote Markt in Haarlem. Reservations are not needed to attend any of these shows.</p>
          </div>
        </div>

        <div class="section" id="jazzticketcontainercombi" style="display:none">
          <h1 class="jazztext" id="jazzticketdate">Combi tickets</h1>
          <table class="jazztickettable" id="jazztickettablecombi">
            <tr>
              <th>Date</th>
              <th>Time</th>
              <th>Price</th>
              <th>Amount</th>
            </tr>
            <tr>
              <?php
              for ($sessionID=25; $sessionID < 29; $sessionID++) {
                $rowSessions = $jazzObject->getBandSession($sessionID);
                $rowBands = $jazzObject->getBandName($rowSessions[0]->BandID);
                ?>
                <td id="<?php echo $rowBands["Name"] ?>"><?php echo $rowBands["Name"] ?></td>
                <?php $starttime = date('H:i', strtotime($rowSessions[0]->StartTime));
                $endtime = date('H:i', strtotime($rowSessions[0]->EndTime));
                $timespan = $starttime." - ".$endtime; ?>
                <td id="<?php echo $timespan ?>"><?php echo $timespan ?></td>
                <td id="<?php echo "€".number_format($rowSessions[0]->Price,2,',', ' ' )." p.p." ?>"><?php echo "€".number_format($rowSessions[0]->Price,2,',', ' ' )." p.p." ?></td>
                <td><select class="jazzticketamount">
                  <?php
                  for ($i=1; $i<=9; $i++){
                    echo "<option value="; echo $i; echo ">"; echo $i; echo "</option>";
                  }
                  ?>
                </select></td>
                <td>
                  <button type="button" name="jazzticketbutton" class="jazzbuttonticketcombi">
                    <img src="../Assets/white-shopping-cart-icon-9.jpg" alt="shoppingcart" id="jazzticketshoppingcart"></td>
                  </button>
                </tr>
              <?php } ?>
            </table>
          </div>

          <form class="JazzSearchBarContainer" id="JazzSearchBarContainerID" method="POST">
            <p id="jazzsearcherror"><?php if (!empty($jazzSearchError)) {
              echo $jazzSearchError;
            } ?></p>
            <input class="JazzSearchBar" name="JazzSearchBar" type="text" placeholder="Search for a band.. ">
          </form>

          <!-- searchbar part -->
          <?php if ($jazzFoundBands != 0) { ?>
            <div class="section" id="jazzticketcontainersearch">
              <h1 class="jazztext" id="jazzticketdate1">Search results</h1>
              <table class="jazztickettable" id="jazztickettable26">
                <tr>
                  <th>Band</th>
                  <th>Day</th>
                  <th>Time</th>
                </tr>
                <tr>
                  <td><?php echo $jazzFoundBandName['Name'] ?></td>
                  <td><?php echo date('d', strtotime($jazzFoundBands['StartTime']))."th of july" ?></td>
                  <td><?php $starttime = date('H:i', strtotime($jazzFoundBands["StartTime"]));
                  $endtime = date('H:i', strtotime($jazzFoundBands["EndTime"]));
                  $timespan = $starttime." - ".$endtime;
                  echo $timespan;?></td>
                </tr>
              </table>
              <div class="searchinfo">
                <p>If you'd like to purchase tickets for these shows go to the respective date at the Program+buy tickets section</p>
              </div>
            </div>
          <?php } ?>

          <div id="jazzfooter">
            <?php include_once('FooterView.php') ?>
          </div>

        </body>

        <script type="text/javascript">
        var date;
        $(document).ready(function(){
          // code to read selected table rowb cell data (values).
          $(".jazzbuttonticket").on('click',function(){
            var currentRow=$(this).closest("tr");
            var colName=currentRow.find("td:eq(0)").attr('id');
            var colTime=currentRow.find("td:eq(1)").attr('id');
            var colHall=currentRow.find("td:eq(2)").attr('id');
            var colPrice=currentRow.find("td:eq(3)").attr('id');
            var colAmount=currentRow.find(".jazzticketamountreg option:selected").attr('value');
            var colDate=date;
            $("#modal-name").html("Band: "+colName);
            $("#modal-time").html("Time: "+colTime);
            $("#modal-hall").html("Location: Patronaat "+colHall);
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
          $(".jazzbuttonticketcombi").on('click',function(){
            var currentRow=$(this).closest("tr");
            var colName=currentRow.find("td:eq(0)").attr('id');
            var colTime=currentRow.find("td:eq(1)").attr('id');
            var colHall="Patronaat";
            var colPrice=currentRow.find("td:eq(2)").attr('id');
            var colAmount=currentRow.find(".jazzticketamount option:selected").attr('value');
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

        function showAlert(alert){
          alert(alert);
        }

        function ChangeDateDefault(){
          /////////////////WTF GEBEURT HIER????????\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
          alert("hoi");
          var date = <?php echo $jazzObject->GetEarliestDate() ?>;
          var button = document.getElementById(date);
          var id = button.getAttribute('id');
          var name = button.getAttribute("name");
          ChangeDate(name, id);
        }

        function ChangeDate(name,id)
        {
          date = id;
          document.getElementById("jazzticketdate").innerHTML = name;
          document.getElementsByTagName("table")[0].setAttribute("id",id);

          if (id == '2020-07-29') {
            document.getElementById("jazzticketcontainerreg").style.display="none";
            document.getElementById("jazzticketcontainer29").style.display="inline-block";
            document.getElementById("jazzticketcontainercombi").style.display="none";
          }
          else if (id == 'Check ticket name') {
            document.getElementById("jazzticketcontainerreg").style.display="none";
            document.getElementById("jazzticketcontainer29").style.display="none";
            document.getElementById("jazzticketcontainercombi").style.display="inline-block";
          }
          else
          {
            document.getElementById("jazzticketcontainerreg").style.display="inline-block";
            document.getElementById("jazzticketcontainer29").style.display="none";
            document.getElementById("jazzticketcontainercombi").style.display="none";
            $(".jazzbandnames").hide();
            $(".jazzbandnames[data-id='" + id + "']").show();
            $(".jazztimespan").hide();
            $(".jazztimespan[data-id='" + id + "']").show();
            $(".jazzhallnames").hide();
            $(".jazzhallnames[data-id='" + id + "']").show();
            $(".jazzprices").hide();
            $(".jazzprices[data-id='" + id + "']").show();
            $(".jazzticketamountreg").hide();
            $(".jazzticketamountreg[data-id='" + id + "']").show();
            $(".jazzcartbutton").hide();
            $(".jazzcartbutton[data-id='" + id + "']").show();
            $(".jazztickettr").hide();
            $(".jazztickettr[data-id='" + id + "']").show();
          }
        }

        function ShowMTB(){
          var displayMTB = document.getElementById("MTBpopout");
          if (displayMTB.style.display=="none") {
            document.getElementById("MTBpopout").style.display="inline-block";
            document.getElementById("jazzticketdatepicker").style.top = "283%";
            document.getElementById("jazzticketcontainercombi").style.top = "325%";
            document.getElementById("jazzticketcontainerreg").style.top = "325%";
            document.getElementById("JazzSearchBarContainerID").style.top = "395%";
            document.getElementById("jazzticketcontainersearch").style.top = "413%";
            document.getElementById("jazzticketcontainer29").style.top = "325%";
            document.getElementById("jazzfooter").style.top = "222vw";
          }
          else {
            document.getElementById("MTBpopout").style.display="none";
            document.getElementById("jazzticketdatepicker").style.top = "123%";
            document.getElementById("jazzticketcontainercombi").style.top = "165%";
            document.getElementById("JazzSearchBarContainerID").style.top = "233%";
            document.getElementById("jazzticketcontainerreg").style.top = "165%";
            document.getElementById("jazzticketcontainer29").style.top = "165%";
            document.getElementById("jazzticketcontainersearch").style.top = "250%";
            document.getElementById("jazzfooter").style.top = "143vw";
          }
        }

        function Changesearch(){
          document.getElementById("jazzticketcontainerreg").style.display="none";
          document.getElementById("jazzticketcontainer29").style.display="none";
          document.getElementById("jazzticketcontainercombi").style.display="inline-block";
        }

        </script>
        </html>
