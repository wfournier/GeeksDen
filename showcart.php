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
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<h1>Your Cart</h1>
					<table class="table table-hover" border="2">
						<tr>
							<th>Id</th><th>Item Name</th><th>Option 1</th><th>Option 2</th><th>Quantity</th><th>Unit Price</th><th>Line Total</th>
						</tr>
						<?php
						if(isset($_SESSION["cart"])){
							$cart=$_SESSION["cart"];
							if(!empty($_SESSION["cart"]->getItems())){
								$cartList=$cart->getItems();
								?>
								<?php
								foreach ($cartList as $item) {
									echo("<tr>");
									echo("<td>" .$item["item_id"] ."</td><td>" .$item["item_title"] ."</td><td>" .$item["option1"] ."</td><td>" .$item["option2"] 
										."</td><td style=\"text-align: center;\"><a href=\"process.php?action=decrease&&decreaseQty=1&&item_id=" .$item["item_id"] ."&&option1=" .$item["option1"] ."&&option2=" .$item["option2"] 
										."\"><i class=\"glyphicon glyphicon-minus btn\" style=\"color: red;\"></i></a>" .$item["qty"] ."<a href=\"process.php?action=increase&&increaseQty=1&&item_id=" .$item["item_id"] 
										."&&option1=" .$item["option1"] ."&&option2=" .$item["option2"] ."\"><i class=\"glyphicon glyphicon-plus btn\"></i></a><br><a href=\"process.php?action=remove&&item_id=" .$item["item_id"] 
										."&&option1=" .$item["option1"] ."&&option2=" .$item["option2"] ."\" class=\"btn btn-danger btn-xs\">Remove</a></td><td>$" .$item["price"] ."</td><td>$" .$item["item_total"] ."</td>");
									echo("</tr>");
								}
								echo("<tr>");
								echo("<td colspan=\"6\">Subtotal</td><td>$" .number_format($cart->getSubTotal(), 2) ."</td>");
								echo("</tr>");
								if($cart->getShippingElligible()){
									echo("<tr>");
									echo("<td colspan=\"6\">Standard Shipping Cost</td><td>$" .number_format($cart->getShippingCost(), 2) ."</td>");
									echo("</tr>");
									echo("<caption align=\"bottom\">*You can choose a different shipping option on the checkout screen</caption>");
								}
								echo("<tr>");
								echo("<td colspan=\"6\">Taxes</td><td>$" .number_format($cart->getTaxes(), 2) ."</td>");
								echo("</tr>");
								echo("<tr>");
								echo("<td colspan=\"6\">Total</td><td>$" .number_format($cart->getTotal(), 2) ."</td>");
								echo("</tr>");
							} else{
								unset($_SESSION["cart"]);
								echo("<tr>");
								echo("<td colspan=\"7\" style=\"text-align: center;\"><b>Your cart is empty</b></td>");
								echo("</tr>");
							}
						} else{
							echo("<tr>");
							echo("<td colspan=\"7\" style=\"text-align: center;\"><b>Your cart is empty</b></td>");
							echo("</tr>");
						}
						?>
					</table><br>
					<a href="index.php" class="btn btn-primary btn-lg">Continue Shopping</a>
					<a href="process.php?action=empty" class="btn btn-danger btn-lg">Empty Cart</a>
					<?php
					if(isset($_SESSION["cart"])){
						$cart=$_SESSION["cart"];
						if(!empty($_SESSION["cart"]->getItems())){
							echo("<a href=\"checkout.php\" class=\"btn btn-success btn-lg\" style=\"float: right;\">Checkout</a>");
						}
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