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
				<?php
				$cat_id=$_GET["cat_id"];

				if(isset($_GET["cat_id"])){
					if($_GET["cat_id"] == $cat_id){
						$cat_title="";

						$get_items_sql="SELECT id, item_title, item_price, item_desc, item_image FROM store_items WHERE cat_id = '" .$cat_id ."' ORDER BY item_title";
						$get_items_res=$conn->query($get_items_sql) or die("get_items_sql: " .$conn->error);

						foreach ($file->category as $category) {
							if($category["id"] == $_GET["cat_id"]){
								$cat_title=$category->name;
							}
						}
						echo("<h1>" .$cat_title ."</h1><br>");

						if($get_items_res->num_rows < 1){
							echo("<p><i>Sorry, there are no items in this category.</p></i>");
						} else{
							while($items = $get_items_res->fetch_array()){
								$item_id = $items["id"];
								$item_title=stripslashes($items["item_title"]);
								$item_price=$items["item_price"];
								$item_desc=$items["item_desc"];
								$item_image=$items["item_image"];

								?>
								<div class="col-md-3 col-sm-6">
									<div class="thumbnail">
										<?php
										echo("<a href=\"showitem.php?item_id=" .$item_id ."\"><img src=\"Images/" .$item_image ."\" title=\"" .$item_title ."\" alt=\"" .$item_title ."\"></a>");
										?>
									</div>
									<div class="caption">
										<?php
										echo("<h3>" .$item_title ."</h3>");
										echo("<p>" .$item_desc ."</p>");
										echo("<h4>$" .$item_price ."</h4>")
										?>
										<p>
											<?php
											echo("<a href=\"showitem.php?item_id=" .$item_id ."\" class=\"btn btn-info btn-lg\">View Item</a>");
											?>
										</p>
									</div>
								</div>
								<?php
							}
							$get_items_res->free();
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