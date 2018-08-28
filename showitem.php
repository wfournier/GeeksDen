<?php
include 'connection.php';

$conn = newCon();

if ($conn->connect_error) {
	echo "Couldn't make a connection";
	exit;
}
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
	<div id="main" style="padding-top: 100px;">
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
				<?php
				$item_id=$_GET["item_id"];
				$cat_title="";

				if(isset($_GET["item_id"])){
					if($_GET["item_id"] == $item_id){
						$get_item_sql = "SELECT id, cat_id, item_title, item_price, item_desc, item_image, stock FROM store_items WHERE id = " .$item_id;
						$get_item_res = $conn->query($get_item_sql) or die("get_item_res: " .$conn->error) or die("get_item_res1: " .$conn->error);

						if($get_item_res->num_rows < 1){
							echo("<i>Invalid item selection</i>");
						} else{
							$item=$get_item_res->fetch_array();

							$item_id = $item["id"];
							$cat_id = $item["cat_id"];
							$cat_title="";
							$item_title=stripslashes($item["item_title"]);
							$item_price=$item["item_price"];
							$item_desc=$item["item_desc"];
							$item_image=$item["item_image"];
							$item_stock=$item["stock"];

							foreach ($file->category as $category) {
								if($category["id"] == $cat_id){
									$cat_title=$category->name;
								}
							}
							?>
							<div class="col-md-6 col-sm-6">
								<div class="thumbnail">
									<?php
									echo("<img src=\"Images/" .$item_image ."\" title=\"" .$item_title ."\" alt=\"" .$item_title ."\">");
									?>
								</div>
								<div class="caption">
									<?php
									echo("<h3>" .$item_title ."</h3>");
									echo("<p>" .$item_desc ."</p>");
									echo("<h1>$" .$item_price ."</h1>");

									$get_item_res->free();
									?>
								</div>
							</div>
							<div class="col-md-4 col-sm-6">
								<form action="process.php?action=add" method="post">
									<div class="form-group">
										<label for="qty">Quantity:</label>
										<input type="text" class="form-control" id="qty" placeholder="Enter quantity" name="qty" value="<?php echo isset($_GET['qty']) ? $_GET['qty'] : '' ?>">
									</div>
									<?php
									if($cat_id == 1 || $cat_id == 2 || $cat_id == 3){
										?>
										<div class="form-group">
											<label for="option1">Edition:</label>
											<select class="form-control" name="option1">
												<?php
												$get_options_sql="SELECT item_edition FROM store_item_edition WHERE item_id = " .$item_id ." AND cat_id = " .$cat_id;
												$get_options_res=$conn->query($get_options_sql) or die("get_options_res2: " .$conn->error);

												if($get_options_res->num_rows < 1){
													echo("<p><i>Invalid selection</i></p>");
												} else{
													while($options = $get_options_res->fetch_array()){
														$edition=$options["item_edition"];
														$selected="";
														if(isset($_GET["option1"])){
															if($_GET["option1"] == $edition){
																$selected="selected";
															}
														}
														echo("<option value=\"" .$edition ."\" " .$selected .">" .$edition ."</option>");
													}
												}																	

												$get_options_res->free();
												?>
											</select>
										</div>
										<div class="form-group">
											<label for="option2">Type:</label>
											<select class="form-control" name="option2">
												<?php
												$get_options_sql="SELECT item_type FROM store_item_type WHERE item_id = " .$item_id ." AND cat_id = " .$cat_id;
												$get_options_res=$conn->query($get_options_sql) or die("get_options_res3: " .$conn->error);

												if($get_options_res->num_rows < 1){
													echo("<p><i>Invalid selection</i></p>");
												} else{
													while($options = $get_options_res->fetch_array()){
														$type=$options["item_type"];
														$selected="";
														if(isset($_GET["option2"])){
															if($_GET["option2"] == $type){
																$selected="selected";
															}
														}
														echo("<option value=\"" .$type ."\" " .$selected .">" .$type ."</option>");
													}
												}																	

												$get_options_res->free();
												?>
											</select>
											<?php
											echo("<input type=\"hidden\" name=\"item_id\" value=\"" .$item_id ."\">");
											echo("<input type=\"hidden\" name=\"cat_id\" value=\"" .$cat_id ."\">");
											echo("<input type=\"hidden\" name=\"item_title\" value=\"" .$item_title ."\">");
											echo("<input type=\"hidden\" name=\"item_price\" value=\"" .$item_price ."\">");
											echo("<input type=\"hidden\" name=\"item_stock\" value=\"" .$item_stock ."\">");
											?>
										</div>
										<?php
									} else if($cat_id == 4){
										?>
										<form action="process.php?action=add">
											<div class="form-group">
												<label for="option1">Color:</label>
												<select class="form-control" name="option1">
													<?php
													$get_options_sql="SELECT item_color FROM store_item_color WHERE item_id = " .$item_id ." AND cat_id = " .$cat_id;
													$get_options_res=$conn->query($get_options_sql) or die("get_options_res4: " .$conn->error);

													if($get_options_res->num_rows < 1){
														echo("<p><i>Invalid selection</i></p>");
													} else{
														while($options = $get_options_res->fetch_array()){
															$color=$options["item_color"];
															$selected="";
															if(isset($_GET["option1"])){
																if($_GET["option1"] == $color){
																	$selected="selected";
																}
															}
															echo("<option value=\"" .$color ."\" " .$selected .">" .$color ."</option>");
														}
													}																	

													$get_options_res->free();
													?>
												</select>
											</div>
											<div class="form-group">
												<label for="option2">Size:</label>
												<select class="form-control" name="option2">
													<?php
													$get_options_sql="SELECT item_size FROM store_item_size WHERE item_id = " .$item_id ." AND cat_id = " .$cat_id;
													$get_options_res=$conn->query($get_options_sql) or die("get_options_res5: " .$conn->error);

													if($get_options_res->num_rows < 1){
														echo("<p><i>Invalid selection</i></p>");
													} else{
														while($options = $get_options_res->fetch_array()){
															$size=$options["item_size"];
															$selected="";
															if(isset($_GET["option2"])){
																if($_GET["option2"] == $size){
																	$selected="selected";
																}
															}
															echo("<option value=\"" .$size ."\" " .$selected .">" .$size ."</option>");
														}
													}																	

													$get_options_res->free();
													?>
												</select>
												<?php
												echo("<input type=\"hidden\" name=\"item_id\" value=\"" .$item_id ."\">");
												echo("<input type=\"hidden\" name=\"cat_id\" value=\"" .$cat_id ."\">");
												echo("<input type=\"hidden\" name=\"item_title\" value=\"" .$item_title ."\">");
												echo("<input type=\"hidden\" name=\"item_price\" value=\"" .$item_price ."\">");
												echo("<input type=\"hidden\" name=\"item_stock\" value=\"" .$item_stock ."\">");
												?>
											</div>
											<?php
										}
										if($item_stock < 1){
											echo("<h3>Sorry, but this item is currently out of stock");
										} else{
											echo("<button type=\"submit\" class=\"btn btn-success btn-lg\">Add to Cart</button>");
										}
										echo("<h2>Stock Left: " .$item_stock ."</h2><br>");
										if(isset($_GET["added"])){
											echo("<b style=\"color: green;\">Your item has been successfully added to the cart!</b><br><br>");
											echo("<a href=\"showcart.php\" class=\"btn btn-primary btn-lg\">See Your Cart</a>");
										} else if(isset($_GET["error"])){
											echo("<b style=\"color: red;\">Sorry, an error occured.<br><br>
												You either entered invalid data or entered a quantity exceeding the amount in stock for the selected item.<br><br></b>");
										}
										?>
									</form>
								</div>
								<?php
							}
						}
					}
					?>
				</div>
			</div>
		</div><br />
<footer>
	&copy;William Fournier, 2017
</footer>
	</body>
	</html>