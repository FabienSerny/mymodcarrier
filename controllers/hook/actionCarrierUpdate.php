<?php

class MyModCarrierActionCarrierUpdateController
{
	public function __construct($module, $file, $path)
	{
		$this->file = $file;
		$this->module = $module;
		$this->context = Context::getContext();
		$this->_path = $path;
	}

	public function run($params)
	{
		$old_id_carrier = (int)$params['id_carrier'];
		$new_id_carrier = (int)$params['carrier']->id;
		if (Configuration::get('MYMOD_CA_CLDE') == $old_id_carrier)
			Configuration::updateValue('MYMOD_CA_CLDE', $new_id_carrier);
		if (Configuration::get('MYMOD_CA_REPO') == $old_id_carrier)
			Configuration::updateValue('MYMOD_CA_REPO', $new_id_carrier);
	}
}