<?php

class MyModCarrierDisplayCarrierListController
{
	public function __construct($module, $file, $path)
	{
		$this->file = $file;
		$this->module = $module;
		$this->context = Context::getContext();
		$this->_path = $path;
	}

	public function loadCity($cart)
	{
		$address = new Address($cart->id_address_delivery);
		$this->city = $address->city;
	}

	public function getRelayPoint()
	{
		// If Cache exists, we return it
		$cache_key = md5($this->module->name.'. getRelayPoint.'.$this->city);
		if ($result = Cache::getInstance()->get($cache_key))
			return json_decode($result, true);

		$url = 'http://localhost/api/index.php';
		$params = '?mca_email='.Configuration::get('MYMOD_CA_EMAIL').'&mca_token='.Configuration::get('MYMOD_CA_TOKEN').'&method=getRelayPoint&city='.$this->city;
		$result = json_decode(file_get_contents($url.$params), true);

		// Add security token
		foreach ($result as $k => $v)
			$result[$k]['token'] = md5($this->module->name.$v['name'].': '.$v['address']._COOKIE_KEY_);

		// Cache result
		Cache::getInstance()->set($cache_key, json_encode($result));

		return $result;
	}

	public function run()
	{
		$this->loadCity($this->context->cart);
		$relay_point = $this->getRelayPoint();

		$this->context->controller->addJS($this->_path.'views/js/mymodcarrier.js');

		$ajax_link = $this->context->link->getModuleLink('mymodcarrier', 'relaypoint', array('controller' => 'relaypoint'));
		$this->context->smarty->assign('mymodcarrier_ajax_link', $ajax_link);
		$this->context->smarty->assign('id_carrier_relay_point', Configuration::get('MYMOD_CA_REPO'));
		$this->context->smarty->assign('mymodcarrier_relay_point', $relay_point);

		return $this->module->display($this->file, 'displayCarrierList.tpl');
	}
}