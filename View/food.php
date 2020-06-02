<!DOCTYPE html5>
<html lang="en">
<head>
	<meta charset= "utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../CSS/foodStyle.css">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/df166940c3.js" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
</head>
<body onload="filterSelection('all')">

	<div id="foodnavbar">
		<?php include_once('NavbarView.php'); ?>
	</div>

	<header class="header">
		<h1 id="bannertitle">Food Festival</h1>
	</header>

	<div id="myBtnContainer" class="btnContainer">
		<button class="btnFilter active" onclick="filterSelection('all')"> Show all</button>
		<?php
		require_once '../Controller/RestaurantController.php';
		$kitchen = new RestaurantController();
		$kitchenList = $kitchen->get_Kitchen();
		  foreach ($kitchenList as $key){?>
					<button class="btnFilter" onclick="filterSelection('<?php echo $key->Kitchen; ?>')"> <?php echo $key->Kitchen; ?></button>
	<?php	} ?>
	</div>

	<?php
	require_once '../Controller/RestaurantController.php';
	$object = new RestaurantController();
	$result = $object->get_all();
	foreach ($result as $key)
	{?>
		<div class="block <?php echo $key->Kitchen ?>">
			<div class="row">
				<td><img src= ../Assets/<?php echo $key->IMG;?> class="block1"></td>
				<h4><?php echo $key->Name;?></h4>
				<div class="text"><p><?php echo $key->Text; ?></p></div>
				<?php if($key->Fish == true)
				{?>
					<div class="icons">
						<i class="fas fa-globe-europe"></i>
						<i class="fas fa-leaf"></i>
						<i class="fas fa-fish"></i>
					</div>
				<?php } else if($key->Fish == false)
				{?>
					<div class="icons">
						<i class="fas fa-globe-europe"></i>
						<i class="fas fa-leaf"></i>
					</div>
				<?php } ?>
				<div class="star">
					<?php
					for ($i=1; $i <= $key->Stars; $i++)
					{?>
						<i class="fas fa-star"></i>
					<?php } ?>
				</div>
			</div>
		</div>
	<?php	} ?>

	<div class="date">
		<h3> Tickets </h3>
		<button type="button" id="2020-07-26" value="2020-07-26" class="btn" name="Thursday July 26" onclick="Change(this.name,this.id)">Thursday</br> July 26th</button>
		<button type="button"	id="2020-07-27" value="2020-07-27" class="btn" name="Friday July 27"  onclick="Change(this.name,this.id)" >Friday</br> July 27th</button>
		<button type="button"	id="2020-07-28" value="2020-07-28" class="btn" name="Saturday July 28" onclick="Change(this.name,this.id)" >Saturday</br> July 28th</button>
		<button type="button"	id="2020-07-29" value="2020-07-29" class="btn" name="Sunday July 29"  onclick="Change(this.name,this.id)">Sunday</br> July 29th</button>
	</div>

	<!--popup form for adding to cart -->
	<form action="../Controller/FoodaddToCartController.php" id="addToCart" class="modal fade" role="dialog" method="post">
		<?php
			if(isset($_GET['error']))
			{
				if($_GET['error'] == "special")
				{
					echo '<p class= "error"> please write your special request. </p>';
				}
			}
			?>
		<h4>Would you like to confirm your reservation</h4>
		<div  class= "modal-name"id= "modal-name" style="margin-left: 7vw; padding: 0.5vw;"><p>name restaurant</p></div>
		<div  class= "modal-time"id= "modal-time" style="margin-left: 7vw; padding: 0.5vw;"><p>time session</p></div>
		<div  class= "modal-price"id= "modal-price" style="margin-left: 7vw; padding: 0.5vw;"><p>price restaurant</p></div>
		<div  class= "modal-number"id= "modal-number" style="margin-left: 7vw; padding: 0.5vw;"><p>numer restaurant</p></div>
		<div  class= "modal-request"id= "modal-request" style="margin-left: 7vw; padding: 0.5vw;"><p>special request</p></div>
		<div class= "modal-text" id= "modal-text" style="margin-left: 6vw; margin-bottom: -3vw;display:none">
			<textarea  name="textarea" class="foodpopuptextarea" placeholder="Please write your special request here"></textarea>
		</div>
		<input type="hidden" id="modal-nameField" name="name" value=" ">
		<input type="hidden" id="modal-timeField" name="time" value=" ">
		<input type="hidden" id="modal-priceField" name="price" value=" ">
		<input type="hidden" id="modal-numberField" name="number" value=" ">
		<input type="hidden" id="modal-requestField" name="request" value=" ">
		<input type="hidden" id="modal-dateField" name="date" value=" ">

		<input type="submit" value="cancel" name="cancel"class="cancelbtn">
		<input type="submit" value="Confirm, continue shopping" name="continue"class="confirmbtn" rel="modal:close">
		<input type="submit" value="Confirm, go to cart" class="confirmbtn" name="confirm" rel="modal:close">
	</form>

	<div class="ticket" id=tickets>
		<h2 id="text"> Thursday July 26th</h2>
		<table id=" " style="width:90%" cellspacing="22">
			<tr>
				<th>Restaurants</th>
				<th>Time</th>
				<th>Special request</th>
				<th>Price*</th>
				<th>Amount</th>
			</tr>
			<?php
			require_once '../Controller/RestaurantController.php';
			$object1 = new RestaurantController();
			$result = $object1->get_all();
			foreach ($result as $key)
			{?>
				<tr>
					<td><?php echo $key->Name;?></td>
					<td>
						<select id="time">
							<?php
							$sessions = $object1->get_sessions($key->RestaurantID);
							foreach ($sessions as $ses)
							{?>
								<?php
								$starttijd = $ses->StartTime;
								$time =  date('H:i', strtotime($starttijd));
								$date = date('Y-m-d', strtotime($starttijd));
								?>
								<option class="timeOption" value=<?php echo $date;?> data-id=<?php echo $date;?>><?php echo $time;?></option>
							<?php } ?>
						</select>
					</td>
					<td>
						<input id="<?php echo $key->RestaurantID;?>_request" name="request" value="yes" type="radio">Yes
						<input id="<?php echo $key->RestaurantID;?>_request1" name="request" value="no" type="radio" >No
					</td>
					<td>€<?php echo $key->Price;?>,00 p.p.</td>
					<td>
						<select id="number">
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
						</select>
					</td>
					<td>
						<button type="button" class="cart" style="border: 0; background: transparent">
							<img src="../Assets/cart.png"  style="width:2vw;height:2vw;border:0;">
						</button>
					</td>
				</tr>
			<?php	} ?>

		</tr>
	</table>
</div>

<div class="note">
	<p> * You only have to pay 10 euro for the reservation, this will be reducted from your bill in the restaurant </p>
</div>

<div class="footer">
	<?php include_once('FooterView.php') ?>
</div>

</body>
<script type='text/javascript'>
$(document).ready(function(){
	// code to read selected table rowb cell data (values).
	$(".cart").on('click',function(){
		var currentRow=$(this).closest("tr");
		var col1=currentRow.find("td:eq(0)").text();
		var col2=currentRow.find("#time option:selected").text();
		var col3=currentRow.find("input[name='request']:checked").val();
		var col4=currentRow.find("td:eq(3)").text();
		var col5=currentRow.find("#number option:selected").text();
		var col6=currentRow.find("#time option:selected").val();
		$("#modal-name").html("Restaurant: "+col1);
		$("#modal-time").html("Time: "+col2);
		$("#modal-request").html("Special request: "+col3);
		$("#modal-price").html("The price: "+col4);
		$("#modal-number").html("Number of people: "+col5);
		document.getElementById("modal-nameField").value = col1;
		document.getElementById("modal-timeField").value = col2;
		document.getElementById("modal-requestField").value = col3;
		document.getElementById("modal-priceField").value = col4;
		document.getElementById("modal-numberField").value = col5;
		document.getElementById("modal-dateField").value = col6;
		if  (col3 == 'yes')
		{
			document.getElementById("modal-text").style.display="block";
		}
		else if(col3 == "no")
		{
			document.getElementById("modal-text").style.display="none";
		}
		else
		{
			$("#modal-request").html("*WARNING Special request was not specified so it will be NO by default ");
			document.getElementById("modal-text").style.display="none";
		}
		$('#addToCart').modal('show');
	});
});

function Change(name,id)
{
	document.getElementById("text").innerHTML = name;
	document.getElementsByTagName("table")[0].setAttribute("id",id);
        if (id === "")
				{
           $(".timeOption").show();
        }
				else
				{
           $(".timeOption").hide();
           $(".timeOption[data-id='" + id + "']").show().prop('selected', true);
        }
}

function filterSelection(c)
{
	$('#2020-07-26').click();
	var x, i;
	x = document.getElementsByClassName("Block");
	if (c == "all") c = "";
	// Add the "show" class (display:inline-block) to the filtered elements, and remove the "show" class from the elements that are not selected
	for (i = 0; i < x.length; i++) {
		RemoveClass(x[i], "show");
		if (x[i].className.indexOf(c) > -1) AddClass(x[i], "show");
	}
}

// Show filtered elements
function AddClass(element, name) {
	var i, arr1, arr2;
	arr1 = element.className.split(" ");
	arr2 = name.split(" ");
	for (i = 0; i < arr2.length; i++) {
		if (arr1.indexOf(arr2[i]) == -1) {
			element.className += " " + arr2[i];
		}
	}
}

// Hide elements that are not selected
function RemoveClass(element, name) {
	var i, arr1, arr2;
	arr1 = element.className.split(" ");
	arr2 = name.split(" ");
	for (i = 0; i < arr2.length; i++) {
		while (arr1.indexOf(arr2[i]) > -1) {
			arr1.splice(arr1.indexOf(arr2[i]), 1);
		}
	}
	element.className = arr1.join(" ");
}

// Add active class to the current button (highlight it)
var btnContainer = document.getElementById("myBtnContainer");
var btns = btnContainer.getElementsByClassName("btnFilter");
for (var i = 0; i < btns.length; i++)
{
	btns[i].addEventListener("click", function()
	{
		var current = document.getElementsByClassName("active");
		current[0].className = current[0].className.replace(" active", "");
		this.className += " active";
	});
}

</script>

</html>
