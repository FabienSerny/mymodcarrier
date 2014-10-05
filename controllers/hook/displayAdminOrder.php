<?php

require_once(dirname(__FILE__).'/../../classes/MyModCarrierRelayPoint.php');

class MyModCarrierDisplayAdminOrderController
{
	public function __construct($module, $file, $path)
	{
		$this->file = $file;
		$this->module = $module;
		$this->context = Context::getContext();
		$this->_path = $path;
	}

	public function run()
	{
		// Check if selected carrier is relay point carrier
		$order = new Order((int)Tools::getValue('id_order'));
		if ($order->id_carrier != Configuration::get('MYMOD_CA_REPO'))
			return '';

		// Retrieve relay point cart association
		$id_cart = (int)$order->id_cart;
		$relaypoint = MyModCarrierRelayPoint::getRelayPointByCartId($id_cart);
		$this->context->smarty->assign('relaypoint', $relaypoint);

		return $this->module->display($this->file, 'displayAdminOrder.tpl');
	}
}