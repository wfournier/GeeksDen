<?php include "Cart.php"; include "Bill.php";
session_start();

include 'connection.php';

$conn = newCon();

if ($conn->connect_error) {
	echo "Couldn't make a connection";
	exit;
}

if(isset($_GET["action"])){
	$action=$_GET["action"];

	//add section
	if($action == "add"){
		if(isset($_POST["item_id"]) && isset($_POST["item_title"]) && isset($_POST["qty"]) && isset($_POST["item_price"])){
			if(is_numeric($_POST["qty"]) && $_POST["qty"] > 0 && $_POST["qty"] <= $_POST["item_stock"]){
				$item_id=$_POST["item_id"];
				$cat_id=$_POST["cat_id"];
				$item_title=$_POST["item_title"];
				$qty=$_POST["qty"];
				$price=$_POST["item_price"];

				$cart=new Cart;

				if(isset($_POST["option1"]) && isset($_POST["option2"])){
					$option1=$_POST["option1"];
					$option2=$_POST["option2"];
					if(!isset($_SESSION["cart"])){
						$cart->addItem($item_id, $cat_id, $item_title, $option1, $option2, $qty, $price);
					} else{
						$cart=$_SESSION["cart"];
						$cart->addItem($item_id, $cat_id, $item_title, $option1, $option2, $qty, $price);
					}
				}
				$_SESSION["cart"]=$cart;
				header("Location: showitem.php?item_id=" .$_POST["item_id"] ."&&qty=" .$_POST["qty"] ."&&option1=" .$_POST["option1"] ."&&option2=" .$_POST["option2"] ."&&added=true");
				exit;
			} else{
				header("Location: showitem.php?item_id=" .$_POST["item_id"] ."&&qty=" .$_POST["qty"] ."&&option1=" .$_POST["option1"] ."&&option2=" .$_POST["option2"] ."&&error=true");
				exit;
			}
		} 
		//increase section
	} else if($action == "increase"){
		if(isset($_GET["item_id"]) && isset($_GET["increaseQty"]) && isset($_GET["option1"]) && isset($_GET["option2"])){
			$_SESSION["cart"]->increaseQty($_GET["item_id"], $_GET["option1"], $_GET["option2"], $_GET["increaseQty"]);
			header("Location: showcart.php");
			exit;
		} 
		//decrease section
	} else if($action == "decrease"){
		if(isset($_GET["item_id"]) && isset($_GET["decreaseQty"]) && isset($_GET["option1"]) && isset($_GET["option2"])){
			if($_SESSION["cart"]->getCartItem($_GET["item_id"], $_GET["option1"], $_GET["option2"])["qty"] < 2){
				$_SESSION["cart"]->removeItem($_GET["item_id"], $_GET["option1"], $_GET["option2"]);
			} else{
				$_SESSION["cart"]->decreaseQty($_GET["item_id"], $_GET["option1"], $_GET["option2"], $_GET["decreaseQty"]);
			}
			header("Location: showcart.php");
			exit;
		} 
		//remove section
	} else if($action == "remove"){
		if(isset($_GET["item_id"]) && isset($_GET["option1"]) && isset($_GET["option2"])){
			$_SESSION["cart"]->removeItem($_GET["item_id"], $_GET["option1"], $_GET["option2"]);
			header("Location: showcart.php");
			exit;
		} 
		//empty section
	} else if($action == "empty"){
		unset($_SESSION["cart"]);
		header("Location: showcart.php");
		exit;
		//update shipping section
	} else if($action == "updateShipping"){
		$_SESSION["cart"]->setShippingMethod($_POST["shipping"]);
		header("Location: checkout.php");
		exit;
		//confirm section
	} else if($action == "confirm"){
		if(isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["email"]) && isset($_POST["shipping_address"]) && isset($_POST["shipping_city"]) && isset($_POST["shipping_zip"]) && isset($_POST["billing_address"]) && isset($_POST["billing_city"]) && isset($_POST["billing_zip"]) && isset($_POST["credit_number"])){
			$fname=$_POST["fname"];
			$lname=$_POST["lname"];
			$email=$_POST["email"];
			$shipping_address=$_POST["shipping_address"];
			$shipping_city=$_POST["shipping_city"];
			$shipping_zip=$_POST["shipping_zip"];
			$billing_address=$_POST["billing_address"];
			$billing_city=$_POST["billing_city"];
			$billing_zip=$_POST["billing_zip"];
			$credit_number=$_POST["credit_number"];
			$credit_type=$_POST["credit_type"];

			if(!is_numeric($fname) && $fname != "" && !is_numeric($lname) && $lname != "" && (bool)preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i", $email) && $email != "" && (bool)preg_match("~[0-9]~", $shipping_address) && (bool)preg_match("/[a-z]/i", $shipping_address) && strpos($shipping_address, " ") && $shipping_address != "" && !is_numeric($shipping_city) && $shipping_city != "" && (bool)preg_match("/^([a-zA-Z]\d[a-zA-Z])\ {0,1}(\d[a-zA-Z]\d)$/", str_replace(' ', '', strtolower($shipping_zip))) && $shipping_zip != "" && (bool)preg_match("~[0-9]~", $credit_number) && (strpos($credit_number, " ") || strpos($credit_number, "-")) && strlen($credit_number) >= 16 && is_numeric(substr($credit_number, -4)) && $credit_number != "" && (((bool)preg_match("~[0-9]~", $billing_address) && (bool)preg_match("/[a-z]/i", $billing_address) && strpos($billing_address, " ")) || $billing_address == "") && !is_numeric($billing_city) && (((bool)preg_match("/^([a-zA-Z]\d[a-zA-Z])\ {0,1}(\d[a-zA-Z]\d)$/", str_replace(' ', '', strtolower($billing_zip)))) || $billing_zip == "") && !(($billing_address != "" || $billing_city != "" || $billing_zip != "") && ($billing_address == "" || $billing_city == "" || $billing_zip == ""))){
				foreach ($_SESSION["cart"]->getItems() as $item) {
					$adjust_stock_sql="UPDATE store_items SET stock = stock - " .$item["qty"] ." WHERE id = " .$item["item_id"];
					$adjust_stock_res=$conn->query($adjust_stock_sql) or die("adjust_stock_res: " .$conn->error);
				}
				if($billing_address == "" || $billing_city == "" || $billing_zip == ""){
					$billing_address=$_POST["shipping_address"];
					$billing_city=$_POST["shipping_city"];
					$billing_zip=$_POST["shipping_zip"];
				}
				$bill=new Bill($_SESSION["cart"]->getItems(), $fname, $lname, $email, $shipping_address, $shipping_city, $shipping_zip, $billing_address, $billing_city, $billing_zip, $credit_number, $credit_type, $_SESSION["cart"]->getSubTotal(), $_SESSION["cart"]->getShippingCost(), $_SESSION["cart"]->getTaxes(), $_SESSION["cart"]->getTotal());
				$_SESSION["bill"]=serialize($bill);
				unset($_SESSION["cart"]);
				header("Location: invoice.php");
				exit;
			} else{
				$error_fields="";
				if(!(!is_numeric($fname) && $fname != "")){
					$error_fields.="fname-";
				}
				if(!(!is_numeric($lname) && $lname != "")){
					$error_fields.="lname-";
				}
				if(!((bool)preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i", $email) && $email != "")){
					$error_fields.="email-";
				}
				if(!((bool)preg_match("~[0-9]~", $shipping_address) && (bool)preg_match("/[a-z]/i", $shipping_address) && strpos($shipping_address, " ") && $shipping_address != "")){
					$error_fields.="shipping_address-";
				}
				if(!(!is_numeric($shipping_city) && $shipping_city != "")){
					$error_fields.="shipping_city-";
				}
				if(!((bool)preg_match("/^([a-zA-Z]\d[a-zA-Z])\ {0,1}(\d[a-zA-Z]\d)$/", str_replace(' ', '', strtolower($shipping_zip))) && $shipping_zip != "")){
					$error_fields.="shipping_zip-";
				}
				if(!((bool)preg_match("~[0-9]~", $credit_number) && (strpos($credit_number, " ") || strpos($credit_number, "-")) && strlen($credit_number) >= 16 && is_numeric(substr($credit_number, -4)) && $credit_number != "")){
					$error_fields.="credit_number-";
				}
				if($billing_address != "" || $billing_city != "" || $billing_zip != ""){
					if(!((bool)preg_match("~[0-9]~", $billing_address) && (bool)preg_match("/[a-z]/i", $billing_address) && strpos($billing_address, " ") && $billing_address != "")){
						$error_fields.="billing_address-";
					}
					if(!(!is_numeric($billing_city) && $billing_city != "")){
						$error_fields.="billing_city-";
					}
					if(!((bool)preg_match("/^([a-zA-Z]\d[a-zA-Z])\ {0,1}(\d[a-zA-Z]\d)$/", str_replace(' ', '', strtolower($billing_zip))) && $billing_zip != "")){
						$error_fields.="billing_zip-";
					}
				}
				header("Location: checkout.php?error=true&&fname=" .$fname ."&&lname=" .$lname ."&&email=" .$email ."&&shipping_address=" .$shipping_address ."&&shipping_city=" .$shipping_city ."&&shipping_zip=" .$shipping_zip ."&&billing_address=" .$billing_address ."&&billing_city=" .$billing_city ."&&billing_zip=" .$billing_zip ."&&credit_number=" .$credit_number ."&&credit_type=" .$credit_type ."&&error_fields=" .substr($error_fields, 0, -1));
				exit;
			}
		}
	} else{
		echo("Invalid action<br>");
		echo("<a href=\"index.php\">return</a>");
	}
} 
?>