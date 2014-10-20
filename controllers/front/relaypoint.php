<?php

require_once(dirname(__FILE__).'/../../classes/MyModCarrierRelayPoint.php');

class MyModCarrierRelayPointModuleFrontController extends ModuleFrontController
{
	public function initContent()
	{
		parent::initContent();

		// Check relay point integrity
		if (Tools::getValue('relay_point_token') != md5($this->module->name.urldecode(Tools::getValue('relay_point'))._COOKIE_KEY_))
		{
			echo json_encode('Error');
			exit;
		}

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
