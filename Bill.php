<?php

class Bill {
	public $items=array();
	public $customer_info=array();
	public $shipping_info=array();
	public $billing_info=array();
	public $credit_info=array();
	public $subtotal=0;
	public $shipping_cost=0;
	public $taxes=0;
	public $total=0;

	public function __construct($items, $fname, $lname, $email, $shipping_address, $shipping_city, $shipping_zip, $billing_address, $billing_city, $billing_zip, $credit_number, $credit_type, $subtotal, $shipping_cost, $taxes, $total){
		$this->items=$items;
		$this->customer_info=array(
			"fname" => $fname,
			"lname" => $lname,
			"email" => $email
			);
		$this->shipping_info=array(
			"address" => $shipping_address,
			"city" => $shipping_city,
			"zip" => $shipping_zip
			);
		$this->billing_info=array(
			"address" => $billing_address,
			"city" => $billing_city,
			"zip" => $billing_zip
			);
		$this->credit_info=array(
			"number" => $credit_number,
			"type" => $credit_type
			);
		$this->subtotal=$subtotal;
		$this->shipping_cost=$shipping_cost;
		$this->taxes=$taxes;
		$this->total=$total;
	}

	public function setItems($items){
		$this->items=$items;
	}

	public function setCustomerInfo($fname, $lname, $email){
		$this->customer_info=array(
			"fname" => $fname,
			"lname" => $lname,
			"email" => $email
			);
	}

	public function setShippingInfo($shipping_address, $shipping_city, $shipping_zip){
		$this->shipping_info=array(
			"address" => $shipping_address,
			"city" => $shipping_city,
			"zip" => $shipping_zip
			);
	}

	public function setBillingInfo($billing_address, $billing_city, $billing_zip){
		$this->billing_info=array(
			"address" => $billing_address,
			"city" => $billing_city,
			"zip" => $billing_zip
			);
	}

	public function setCreditCard($credit_number, $credit_type){
		$this->credit_info=array(
			"number" => $credit_number,
			"type" => $credit_type
			);
	}

	public function setSubTotal($subtotal){
		$this->subtotal=$subtotal;
	}

	public function setShippingCost($shipping_cost){
		$this->shipping_cost=$shipping_cost;
	}

	public function setTaxes($taxes){
		$this->taxes=$taxes;
	}

	public function setTotal($total){
		$this->total=$total;
	}

	public function getItems(){
		return $this->items;
	}

	public function getCustomerInfo(){
		return $this->customer_info;
	}

	public function getShippingInfo(){
		return $this->shipping_info;
	}

	public function getBillingInfo(){
		return $this->billing_info;
	}

	public function getCreditCard(){
		return $this->credit_info;
	}

	public function getSubTotal(){
		return $this->subtotal;
	}

	public function getShippingCost(){
		return $this->shipping_cost;
	}

	public function getTaxes(){
		return $this->taxes;
	}

	public function getTotal(){
		return $this->total;
	}
	
}

?>