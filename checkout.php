<?php include "Cart.php";
session_start();
?>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="script.js"></script>
	<script>
	$(document).ready(function(){
		$("#showBilling").click(function(){
			$("#billing-address").toggle();
			$("#billing-zip").toggle();
			$("#billing-city").toggle();
		});
	});
	</script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>The Geek's Den</title>
</head>
<body>
	<div id="main" style="padding-top: 60px;">
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="navbar-header">
				<a onclick="openNav()"><i class="navbar-brand glyphicon glyphicon-th-list btn"></i></a>
				<a href="index.php"><i class="navbar-brand glyphicon glyphicon-home btn"></i></a>
			</div>
			<div class="collapse navbar-collapse navbar-menubuilder">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="showcart.php" style="padding-right: 30px"><i class="glyphicon glyphicon-shopping-cart btn"></i></a>
					</li>
				</ul>
			</div>
		</nav>
		<?php
		$cart=new Cart;
		$file=simplexml_load_file("categories.xml");
		?>
		<div id="mySidenav" class="sidenav" style="padding-top: 120px;">
			<a href="javascript:void(0)" class="closebtn" onclick="closeNav()" style="padding-top: 80px;">&times;</a>
			<?php
			foreach ($file->category as $category) {
				echo("<a href=\"" .$category->link ."\">" .$category->name ."</a>");
			}
			?>
		</div>
		<div class="container cust_container">
			<div class="row">
				<div class="col-md-4 col-sm-6">
					<h1>1 - Shipping Method</h1><br>
					<?php
					if(isset($_SESSION["cart"])){
						$cart=$_SESSION["cart"];
						if(!empty($_SESSION["cart"]->getItems())){
							if($_SESSION["cart"]->getShippingElligible()){
								?>
								<p style="color: green"><b>If your order contains digital downloads,<br>they will be delivered by email.<br><br>(Every other items will be shipped normally)</b></p><br>
								<form action="process.php?action=updateShipping" method="post" id="shippingForm">
									<div class="radio">
										<label><input type="radio" name="shipping" onclick="updateShipping()" value="standard" <?php echo $cart->getShippingMethod() == "standard" ? "checked" : "" ?>>*Standard ($7.50)</label>
									</div>
									<div class="radio">
										<label><input type="radio" name="shipping" onclick="updateShipping()" value="express" <?php echo $cart->getShippingMethod() == "express" ? "checked" : "" ?>>*Express ($15.00)</label>
									</div>
									<div class="radio">
										<label><input type="radio" name="shipping" onclick="updateShipping()" value="vip" <?php echo $cart->getShippingMethod() == "vip" ? "checked" : "" ?>>*VIP ($30.00)</label>
									</div><br>
									<button type="submit" class="btn btn-warning btn-lg">Update Shipping Method</button><br><br>
									<fieldset>
										<legend>Approximate Delivery Times</legend>
										Standard: 4-7 Days<br>
										Express: 1-3 Days<br>
										VIP: 1 Day
									</fieldset>
								</form><br>
								<?php
							} else{
								?>
								<p style="color: red"><b>Your order is not elligible for shipping<br><br>(All items are digital downloads and will be delivered by email)</b></p>
								<?php
							}
						}
					}
					?>
				</div>
				<div class="col-md-4 col-sm-6">
					<h1>2 - Shipping Information</h1>
					<form action="process.php?action=confirm" method="post">
						<div class="input-group">
							<div class="row">
								<div class="col-md-5 col-sm-6">
									<label for="fname" <?php echo (isset($_GET["error_fields"]) && (bool)substr_count($_GET["error_fields"], "fname")) ? "style=\"color: red;\"" : "" ?>>First Name:</label>
									<input type="text" placeholder="e.g. John" class="form-control" id="fname" name="fname" value="<?php echo isset($_GET['fname']) && (isset($_SESSION['cart']) || !empty($cart->getItems())) ? $_GET['fname'] : '' ?>">
								</div>
								<div class="col-md-5 col-sm-6">
									<label for="lname" <?php echo (isset($_GET["error_fields"]) && (bool)substr_count($_GET["error_fields"], "lname")) ? "style=\"color: red;\"" : "" ?>>Last Name:</label>
									<input type="text" placeholder="e.g. Doe" class="form-control" id="lname" name="lname" value="<?php echo isset($_GET['lname']) && (isset($_SESSION['cart']) || !empty($cart->getItems())) ? $_GET['lname'] : '' ?>">
								</div>
							</div>
						</div><br>
						<div class="form-group">
							<label for="email" <?php echo (isset($_GET["error_fields"]) && (bool)substr_count($_GET["error_fields"], "email")) ? "style=\"color: red;\"" : "" ?>>Email address:</label>
							<input type="text" placeholder="e.g. john@doe.com" class="form-control" id="email" name="email" value="<?php echo isset($_GET['email']) && (isset($_SESSION['cart']) || !empty($cart->getItems())) ? $_GET['email'] : '' ?>" style="max-width: 359;">
						</div>
						<div class="form-group">
							<label for="shipping_address" <?php echo (isset($_GET["error_fields"]) && (bool)substr_count($_GET["error_fields"], "shipping_address")) ? "style=\"color: red;\"" : "" ?>>Shipping Address:</label>
							<input type="text" placeholder="e.g. 123 Main St" class="form-control" id="shipping_address" name="shipping_address" value="<?php echo isset($_GET['shipping_address']) && (isset($_SESSION['cart']) || !empty($cart->getItems())) ? $_GET['shipping_address'] : '' ?>" style="max-width: 359;">
						</div>
						<div class="input-group">
							<div class="row">
								<div class="col-md-5 col-sm-6">
									<label for="shipping_city" <?php echo (isset($_GET["error_fields"]) && (bool)substr_count($_GET["error_fields"], "shipping_city")) ? "style=\"color: red;\"" : "" ?>>Shipping City:</label>
									<input type="text" placeholder="e.g. Anytown" class="form-control" id="shipping_city" name="shipping_city" value="<?php echo isset($_GET['shipping_city']) && (isset($_SESSION['cart']) || !empty($cart->getItems())) ? $_GET['shipping_city'] : '' ?>">
								</div>
								<div class="col-md-5 col-sm-6">
									<label for="shipping_zip" <?php echo (isset($_GET["error_fields"]) && (bool)substr_count($_GET["error_fields"], "shipping_zip")) ? "style=\"color: red;\"" : "" ?>>Shipping Zip:</label>
									<input type="text" placeholder="e.g. A1B 2C3" class="form-control" id="shipping_zip" name="shipping_zip" value="<?php echo isset($_GET['shipping_zip']) && (isset($_SESSION['cart']) || !empty($cart->getItems())) ? $_GET['shipping_zip'] : '' ?>">
								</div>
							</div>
						</div><br>
						<a class="btn btn-primary btn-xs" id="showBilling">Billing Address is Different</a><br><br>
						<div class="form-group" id="billing-address" <?php echo (isset($_GET["billing_address"]) && $_GET["billing_address"] != "") || (isset($_GET["billing_zip"]) && $_GET["billing_zip"] != "") || (isset($_GET["billing_address"]) && $_GET["billing_address"] != "") ? "" : "hidden" ?>>
							<label for="billing_address" <?php echo (isset($_GET["error_fields"]) && (bool)substr_count($_GET["error_fields"], "billing_address")) ? "style=\"color: red;\"" : "" ?>>Billing Address:</label>
							<input type="text" placeholder="e.g. 123 Main St" class="form-control" id="billing_address" name="billing_address" value="<?php echo isset($_GET['billing_address']) && (isset($_SESSION['cart']) || !empty($cart->getItems())) ? $_GET['billing_address'] : '' ?>" style="max-width: 359;">
						</div>
						<div class="row">
							<div class="col-md-5 col-sm-6" id="billing-city" <?php echo (isset($_GET["billing_address"]) && $_GET["billing_address"] != "") || (isset($_GET["billing_zip"]) && $_GET["billing_zip"] != "") || (isset($_GET["billing_address"]) && $_GET["billing_address"] != "") ? "" : "hidden" ?>>
								<label for="billing_city" <?php echo (isset($_GET["error_fields"]) && (bool)substr_count($_GET["error_fields"], "billing_city")) ? "style=\"color: red;\"" : "" ?>>Billing City:</label>
								<input type="text" placeholder="e.g. Anytown" class="form-control" id="billing_city" name="billing_city" value="<?php echo isset($_GET['billing_city']) && (isset($_SESSION['cart']) || !empty($cart->getItems())) ? $_GET['billing_city'] : '' ?>">
							</div>
							<div class="col-md-5 col-sm-6" id="billing-zip" <?php echo (isset($_GET["billing_address"]) && $_GET["billing_address"] != "") || (isset($_GET["billing_zip"]) && $_GET["billing_zip"] != "") || (isset($_GET["billing_address"]) && $_GET["billing_address"] != "") ? "" : "hidden" ?>>
								<label for="billing_zip" <?php echo (isset($_GET["error_fields"]) && (bool)substr_count($_GET["error_fields"], "billing_zip")) ? "style=\"color: red;\"" : "" ?>>Billing Zip:</label>
								<input type="text" placeholder="e.g. A1B 2C3" class="form-control" id="billing_zip" name="billing_zip" value="<?php echo isset($_GET['billing_zip']) && (isset($_SESSION['cart']) || !empty($cart->getItems())) ? $_GET['billing_zip'] : '' ?>">
							</div>
						</div><br>
						<div class="form-group">
							<label for="credit_type">Payment Option:</label>
							<select class="form-control" id="credit_type" name="credit_type" style="max-width: 359;">
								<option value="Visa" <?php echo isset($_GET["credit_type"]) && $_GET["credit_type"] == "Visa" ? "selected" : "" ?>>Visa</option>
								<option value="Mastercard" <?php echo isset($_GET["credit_type"]) && $_GET["credit_type"] == "Mastercard" ? "selected" : "" ?>>Mastercard</option>
								<option value="American Express" <?php echo isset($_GET["credit_type"]) && $_GET["credit_type"] == "American Express" ? "selected" : "" ?>>American Express</option>
							</select>
						</div>
						<div class="form-group">
							<label for="credit_number" <?php echo (isset($_GET["error_fields"]) && (bool)substr_count($_GET["error_fields"], "credit_number")) ? "style=\"color: red;\"" : "" ?>>Credit Card Number:</label>
							<input type="text" placeholder="e.g. 1111-2222-3333-4444" class="form-control" id="credit_number" name="credit_number" value="<?php echo isset($_GET['credit_number']) && (isset($_SESSION['cart']) || !empty($cart->getItems())) ? $_GET['credit_number'] : '' ?>" style="max-width: 359;">
						</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<h1>3 - Confirm Payment</h1>
						<table class="table">
							<tr>
								<?php
								echo("<td style=\"border-top: none;\">Subtotal</td><td style=\"border-top: none;\">$" .number_format($cart->getSubTotal(), 2) ."</td>");
								?>
							</tr>
							<tr>
								<?php
								echo("<td style=\"border-top: none;\">Shipping</td><td style=\"border-top: none;\">$" .number_format($cart->getShippingCost(), 2) ."</td>");
								?>
							</tr>
							<tr>
								<?php
								echo("<td style=\"border-top: none;\">Taxes</td><td style=\"border-top: none;\">$" .number_format($cart->getTaxes(), 2) ."</td>");
								?>
							</tr>
							<tr>
								<?php
								echo("<td>Total</td><td>$" .number_format($cart->getTotal(), 2) ."</td>");
								?>
							</tr>
						</table>
						<?php
						if(isset($_SESSION["cart"])){
							?>
							<button type="submit" class="btn btn-success btn-lg">Confirm Purchase</button><br><br>
							<?php
						} else{
							echo("<b style=\"color: red;\">Your cart is empty.</b><br><br>");
							echo("<a href=\"index.php\" class=\"btn btn-primary btn-md\">Return To Shop</a>");
						}
						?>
					</form>
					<?php
					if(isset($_GET["error"]) && (isset($_SESSION["cart"]) || !empty($cart->getItems()))){
						echo("<b style=\"color: red;\">The payment information you entered is invalid.<br>
							Please try again.</b>");
					}
					?>
				</div>
			</div>
		</div>
	</div><br />
<footer>
	&copy;William Fournier, 2017
</footer>
</body>
</html>