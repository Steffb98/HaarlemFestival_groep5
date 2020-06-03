<?php
session_start();
?>
<!DOCTYPE html5>
<html lang="en">
<head>
	<meta charset= "utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../CSS/cartStyle.css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/df166940c3.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</script>
</head>
<body>
<?php
if(empty($_SESSION['products']))
{
	echo'<style type="text/css">
			#empty
			{
					display: block;
			}
			#tickets
			{
				display: none;
			}
			#login
			{
				display: none;
			}
			</style>';
	}
	else if(!isset($_SESSION['User_ID']) || empty($_SESSION['User_ID']))
	{
		echo'<style type="text/css">
				#empty
				{
						display: none;
				}
				#tickets
				{
					display: block;
				}
				#login
				{
					display: block;
				}
				#payButton
				{
					display: none;
				}
				</style>';
	}

?>

	<div id="cartnavbar">
		<?php include_once('NavbarView.php'); ?>
	</div>

  <header class="header">
    <h1 id="cartTitle" >Shopping Cart</h1>
  </header>

  <div id="empty" class="ShoppingCart">
    <p> Your shopping cart is currently empty </P>
  </div>

<form action="../Controller/payController.php" method="post">
	<div id="tickets" class="ShoppingCart">
		<?php
			if(isset($_GET['error']))
			{
				if($_GET['error'] == "limit")
				{
					echo '<p class= "error"> The minimum amount for tickets is 1 and the maximum is 10  </p>';
				}
			}
			?>
		<table style="width:90%" cellspacing="22">
			<tr>
				<th>Tickets (<?php echo sizeof($_SESSION['products']) ?>x)</th>
				<th>Amount</th>
				<th>Price</th>
			</tr>
			<tr>
			<?php foreach($_SESSION['products'] as $cart){?>
				<td>
					<p value="<?php print $cart['name'];?>"><?php print $cart['name'];?></p>
				</td>
				<td>
					<a href="../Controller/changeAmountController.php?id=<?php print $cart['id']?>&amount=<?php print $cart['amount']?>&value=min"><p><i class="fas fa-minus"></i></a>
					<a href="../Controller/changeAmountController.php?id=<?php print $cart['id']?>&amount=<?php print $cart['amount']?>&value=plus"><i class="fas fa-plus"></i></a><?php print $cart['amount'];?></p>
				</td>
				<td>
					<p><?php print $cart['price'];?>,00 p.p.</p>
				</td>
				<td>
					<a href="../Controller/deleteSessieController.php?id=<?php print $cart['uniqid']?>"><i class="fas fa-trash"></i></a>
				</td>
			</tr>
			<tr>
				<td class="specialText">
					<p>	- Time: <?php print $cart['time'];?></P>
					<p>	- Date: <?php print $cart['date'];?><p>
					<p>	- Location: <br> <?php print $cart['location'];?><p>
						<?php if($cart['specialText'] != NULL)
						{ ?>
							<p>	- Special request: <br> <?php print $cart['specialText'];?><p>
			<?php } ?>
					<hr>
				</td>
			</tr>
		<?php }	?>
			<tr>
				<td>
					<p> Total with VAT<p>
				</td>
				<td></td>
				<?php $totalSum = 0;?>
				<?php foreach($_SESSION['products'] as $cart){?>
					<?php
					$total = ($cart['price']) * $cart['amount'];
					$totalSum += $total;
				}?>
				<td>
					<p><i id="EuroTeken" class="fas fa-euro-sign"></i><?php echo $totalSum?>,00 <p>
				</td>
			</tr>
			<tr>
				<td>
					<p>VAT 21%<p>
				</td>
				<td></td>
				<?php
				$totalBtw = 0;
				$totalBtw= $totalSum * 0.21?>
				<td>
					<p><i id="EuroTeken" class="fas fa-euro-sign"></i><?php echo number_format($totalBtw,2)?> <p>
				</td>
			</tr>
		</table>
		<input type="hidden" name="totalPrice" value= <?php echo $totalSum ?>>
		<input id= "payButton" type="submit" value="Pay" name="price" class="PayButton">
	</div>
</form>

<div id="login" class="ShoppingCart">
	<p> You have to have an account and be logged in to pay for your tickets </P>
	<a class="link "href="UserloginView.php">Login to your account</a> <a class="link" href="UserregisterView.php">Make your account</a>
</div>

	<div class="cartfooter">
		<?php include_once('FooterView.php') ?>
	</div>

</body>
</html>
