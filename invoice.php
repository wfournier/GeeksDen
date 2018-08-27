<?php include "Cart.php"; include "Bill.php";
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
	<div id="main" style="padding-top: 80px;">
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
		date_default_timezone_set("America/New_York");
		$bill;
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
			<?php
			if(!isset($_SESSION["bill"])){
				echo("<b style=\"color: red;\">No bill to be shown!</b>");
			} else{
				$bill=unserialize($_SESSION["bill"]);
				?>
				<div class="row" style="height: 100px;">
					<div class="col-md-6 col-sm-6">
						<h1>The Geek's Den</h1>
						<h5 style="color: red;">A COPY OF THIS RECEIPT WILL BE SENT TO YOU BY EMAIL</h5>
					</div>
					<div class="col-md-6 col-sm-6">
						<?php
						echo("<h4 style=\"text-align: right\">DATE: " .date("Y/m/d") ."</h4>");
						echo("<h4 style=\"text-align: right\">TIME: " .date("h:i:sa") ."</h4>");
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<h4>SHIP TO:</h4><br>
						<ul style="list-style-type: none;">
							<?php
							echo("<li><h4>" .ucwords($bill->getCustomerInfo()["lname"] .", " .$bill->getCustomerInfo()["fname"]) ."</h4></li>");
							echo("<li><h4>" .ucwords($bill->getShippingInfo()["address"]) .", " .ucwords($bill->getShippingInfo()["city"]) ."</h4></li>");
							echo("<li><h4>" .strtoupper(substr(str_replace(' ', '', $bill->getShippingInfo()["zip"]), 0, 3) ." " .substr(str_replace(' ', '', $bill->getShippingInfo()["zip"]), 3, 6)) ."</h4></li>");
							echo("<li><h4>" .$bill->getCustomerInfo()["email"] ."</h4></li>");
							?>
						</ul>
					</div>
					<div class="col-md-6 col-sm-6">
						<h4>BILL TO:</h4><br>
						<ul style="list-style-type: none;">
							<?php
							echo("<li><h4>" .ucwords($bill->getCustomerInfo()["lname"] .", " .$bill->getCustomerInfo()["fname"]) ."</h4></li>");
							echo("<li><h4>" .ucwords($bill->getBillingInfo()["address"]) .", " .ucwords($bill->getBillingInfo()["city"]) ."</h4></li>");
							echo("<li><h4>" .strtoupper(substr(str_replace(' ', '', $bill->getBillingInfo()["zip"]), 0, 3) ." " .substr(str_replace(' ', '', $bill->getBillingInfo()["zip"]), 3, 6)) ."</h4></li>");
							echo("<li><h4>XXXX-XXXX-XXXX-" .substr($bill->getCreditCard()["number"], -4) ." " .$bill->getCreditCard()["type"] ."</h4></li>");
							?>
						</ul><br>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<table class="table table-striped" border="2">
							<tr>
								<th>ITEM ID</th><th>DESCRIPTION</th><th>OPTION 1</th><th>OPTION 2</th><th>QUANTITY</th><th>UNIT PRICE</th><th>LINE TOTAL</th>
							</tr>
							<?php
							foreach($bill->getItems() as $item){
								echo("<tr>");
								echo("<td>" .$item["item_id"] ."</td><td>" .$item["item_title"] ."</td><td>" .$item["option1"] ."</td><td>" .$item["option2"] ."</td><td>" .$item["qty"] ."</td><td>$" .$item["price"] ."</td><td>$" .$item["item_total"] ."</td>");
								echo("</tr>");
							}
							?>
							<tr>
								<?php
								echo("<td colspan=\"6\" style=\"text-align: right; border: none;\">SUBTOTAL</td><td>$" .number_format($bill->getSubTotal(), 2) ."</td>");
								?>
							</tr>
							<tr>
								<?php
								echo("<td colspan=\"6\" style=\"text-align: right; border: none;\">SHIPPING & HANDLING</td><td>$" .number_format($bill->getShippingCost(), 2) ."</td>");
								?>
							</tr>
							<tr>
								<?php
								echo("<td colspan=\"6\" style=\"text-align: right; border: none;\">TAXES (14.75%)</td><td>$" .number_format($bill->getTaxes(), 2) ."</td>");
								?>
							</tr>
							<tr>
								<?php
								echo("<td colspan=\"6\" style=\"text-align: right; border: none;\">TOTAL DUE</td><td>$" .number_format($bill->getTotal(), 2) ."</td>");
								?>
							</tr>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<h1 style="text-align: center;">THANK YOU FOR DOING BUSINESS WITH US!</h1><br>
						<?php
					}
					?>
					<a href="index.php" class="btn btn-primary btn-md" style="float: right;">Return to Homepage</a>
				</div>
			</div>
		</div>
	</div><br />
<footer>
	&copy;William Fournier, 2017
</footer>
</body>
</html>
<?php
	unset($_SESSION["bill"]);
?>