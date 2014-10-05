<?php

class MyModCarrierGetOrderShippingCostController
{
	public function __construct($module, $file, $path)
	{
		$this->file = $file;
		$this->module = $module;
		$this->context = Context::getContext();
		$this->_path = $path;
	}

	public function getDeliveryService()
	{
		$url = 'http://localhost/api/index.php';
		$params = '?mca_email='.Configuration::get('MYMOD_CA_EMAIL').'&mca_token='.Configuration::get('MYMOD_CA_TOKEN').'&method=getShippingCost&city='.$this->city;
		$result = json_decode(file_get_contents($url.$params), true);
		return $result;
	}

	public function getShippingCost($id_carrier, $delivery_service)
	{
		$shipping_cost = false;
		if ($id_carrier == Configuration::get('MYMOD_CA_CLDE') && isset($delivery_service['ClassicDelivery']))
			$shipping_cost = (int)$delivery_service['ClassicDelivery'];
		if ($id_carrier == Configuration::get('MYMOD_CA_REPO') && isset($delivery_service['RelayPoint']))
			$shipping_cost = (int)$delivery_service['RelayPoint'];
		return $shipping_cost;
	}

	public function loadCity($cart)
	{
		$address = new Address($cart->id_address_delivery);
		$this->city = $address->city;
	}

	public function run($cart, $shipping_fees)
	{
		$this->loadCity($cart);
		$delivery_service = $this->getDeliveryService();
		$shipping_cost = $this->getShippingCost($this->module->id_carrier, $delivery_service);
		if ($shipping_cost === false)
			return false;
		return $shipping_cost + $shipping_fees;
	}
}