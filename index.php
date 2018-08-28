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
		<div class="jumbotron">
			<h1 class="display-3">The Geek's Den</h1>
			<p class="lead">
				This is where all geeks unite!<br>
				Here, you can find everything related to technology such as video games, electronic music, sci-fi movies, and more!
			</p>
			<hr class="my-2">
			<p>
				You can browse store categories and see your cart by using the bar on top, or choose an item from the featured section underneath!<br>
				Enjoy!
			</p>
		</div>
		<?php
		$get_featured_sql="SELECT id, item_title, item_desc, item_image FROM store_items WHERE featured = 'yes' ORDER BY cat_id, item_title";
		$get_featured_res=$conn->query($get_featured_sql) or die("get_featured_sql: " .$conn->error);

		if($get_featured_res->num_rows < 1){
			echo("<h2><i>There are no featured items</i></h2>");
		} else{
			?>
			<h1 class="display-3">Featured Items</h1>
			<div id="myCarousel" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<?php
						for($x = 0; $x < $get_featured_res->num_rows; $x++){
							if($x==0){
								echo("<li data-target=\"#myCarousel\" data-slide-to=\"" .$x ."\" class=\"active\"></li>");
							} else{
								echo("<li data-target=\"#myCarousel\" data-slide-to=\"" .$x ."\"></li>");
							}
						}
					?>
				</ol>

				<div class="carousel-inner" style="max-width: 1000px; max-height:562px; margin: 0 auto">
					<?php
					$active=true;
					while($items = $get_featured_res->fetch_array()){
						$item_id = $items["id"];
						$item_title=stripslashes($items["item_title"]);
						$item_desc=$items["item_desc"];
						$item_image=$items["item_image"];
						$item_image_featured=substr_replace($item_image, "_featured", (strlen($item_image) - 4), 0);

						if($active){
							echo("<div class=\"item active\">");
							$active=false;
						} else{
							echo("<div class=\"item\">");
						}
						echo("<a href=\"showitem.php?item_id=" .$item_id ."\"><img src=\"Images/Featured/" .$item_image_featured ."\" title=\"" .$item_title ."\" alt=\"" .$item_title ."\"></a>");
						echo("<div class=\"carousel-caption\">");
						echo("<h3>" .$item_title ."</h3>");
						echo("<p>" .$item_desc ."</p>");
						?>
					</div>
				</div>
				<?php
			}
			?>
		</div>

		<a class="left carousel-control" href="#myCarousel" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#myCarousel" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right"></span>
			<span class="sr-only">Next</span>
		</a>
	</div><br />
<footer>
	&copy;William Fournier, 2017
</footer>
	<?php
	$get_featured_res->free();
}
?>
</body>
</html>