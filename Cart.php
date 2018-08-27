<?php define("TAX", 0.1475);

class Cart {
	public $items=array();
	public $shippingMethod="standard";

	public function setItems($items){
		$this->items=$items;
	}

	public function setShippingMethod($shippingMethod){
		$this->shippingMethod=$shippingMethod;
	}

	public function getItems(){
		return $this->items;
	}

	public function getCartItem($item_id, $option1, $option2){
		$cartItem=array();

		foreach ($this->items as $item) {
			if($item["item_id"] == $item_id && $item["option1"] == $option1 && $item["option2"] == $option2){
				$cartItem = $item;
			}
		}

		return $cartItem;
	}

	public function getShippingMethod(){
		return $this->shippingMethod;
	}

	public function addItem($item_id, $cat_id, $item_title, $option1, $option2, $qty, $price){
		if(empty($this->items)){
			$this->items=array(
				array(
					"item_id" => $item_id,
					"cat_id" => $cat_id,
					"item_title" => $item_title,
					"option1" => $option1, 
					"option2" => $option2, 
					"qty" => $qty, 
					"price" => $price,
					"item_total" => number_format($qty * $price, 2)
					)
				);
		} else{
			$found=false;

			foreach($this->items as $index => $item){
				if($item["item_id"] == $item_id && $item["option1"] == $option1 && $item["option2"] == $option2){
					$this->items[$index]["qty"]+=$qty;
					$this->items[$index]["item_total"]+=$qty * $item["price"];
					$found=true;
				}
			}

			if(!$found){
				array_push($this->items, array(
					"item_id" => $item_id,
					"cat_id" => $cat_id,
					"item_title" => $item_title,
					"option1" => $option1, 
					"option2" => $option2, 
					"qty" => $qty, 
					"price" => $price,
					"item_total" => $qty * $price
					)
				);
			}
		}
	}

	public function getShippingElligible(){
		$elligible=false;

		foreach($this->items as $item){
			if($item["option2"] == "Physical Disk" || $item["cat_id"] == 4){
				$elligible=true;
			}
		}

		return $elligible;
	}

	public function removeItem($item_id, $option1, $option2){
		foreach($this->items as $index => $item){
			if($item["item_id"] == $item_id && $item["option1"] == $option1 && $item["option2"] == $option2){
				unset($this->items[$index]);
			}
		}
	}

	public function increaseQty($item_id, $option1, $option2, $increaseQty){
		foreach($this->items as $index => $item){
			if($item["item_id"] == $item_id && $item["option1"] == $option1 && $item["option2"] == $option2){
				$this->items[$index]["qty"]+=$increaseQty;
				$this->items[$index]["item_total"]+=$increaseQty * $item["price"];
			}
		}
	}

	public function decreaseQty($item_id, $option1, $option2, $decreaseQty){
		foreach($this->items as $index => $item){
			if($item["item_id"] == $item_id && $item["option1"] == $option1 && $item["option2"] == $option2){
				$this->items[$index]["qty"]-=$decreaseQty;
				$this->items[$index]["item_total"]-=$decreaseQty * $item["price"];
			}
		}
	}

	public function getSubTotal(){
		$subTotal=0;

		foreach($this->items as $item){
			$subTotal+=($item["qty"] * $item["price"]);
		}

		return $subTotal;
	}

	public function getShippingCost(){
		$shippingCost=0;

		if($this->getShippingElligible()){
			$methodList=array(
				"standard" => 7.50,
				"express" => 15,
				"vip" => 30
				);

			foreach($methodList as $key => $value){
				if($this->getShippingMethod() == $key){
					$shippingCost=$value;
				}
			}
		}

		return $shippingCost;
	}

	public function getTaxes(){
		$taxes=($this->getSubTotal() + $this->getShippingCost()) * TAX;

		return $taxes;
	}

	public function getTotal(){
		$total=$this->getSubTotal() + $this->getShippingCost() + $this->getTaxes();

		return $total;
	}
}

?>