<?php

require_once(dirname(__FILE__).'/../../classes/MyModCarrierRelayPoint.php');

class MyModCarrierRelayPointModuleFrontController extends ModuleFrontController
{
	public function initContent()
	{
		parent::initContent();

		// Retrieve relay point cart association
		$id_cart = (int)$this->context->cookie->id_cart;
		$relaypoint = MyModCarrierRelayPoint::getRelayPointByCartId($id_cart);

		// Add / update relay point cart association
		$relaypoint->id_cart = $id_cart;
		$relaypoint->relay_point = urldecode(Tools::getValue('relay_point'));
		if ($relaypoint->id > 0)
			$relaypoint->update();
		else
			$relaypoint->add();

		// Return result
		echo json_encode('Success');
		exit;
	}
}
