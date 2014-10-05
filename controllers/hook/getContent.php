<?php

class MyModCarrierGetContentController
{
	public function __construct($module, $file, $path)
	{
		$this->file = $file;
		$this->module = $module;
		$this->context = Context::getContext(); $this->_path = $path;
	}

	public function testAPIConnection($mca_email, $mca_token)
	{
		$url = 'http://localhost/api/index.php';
		$params = '?mca_email='.$mca_email.'&mca_token='.$mca_token.'&method=testConnection';
		$result = json_decode(file_get_contents($url.$params), true);
		if ($result == 'Success')
			return true;
		return false;
	}

	public function processConfiguration()
	{
		if (Tools::isSubmit('mymodcarrier_form'))
		{
			Configuration::updateValue('MYMOD_CA_EMAIL', Tools::getValue('MYMOD_CA_EMAIL'));
			Configuration::updateValue('MYMOD_CA_TOKEN', Tools::getValue('MYMOD_CA_TOKEN'));
			if ($this->testAPIConnection(Tools::getValue('MYMOD_CA_EMAIL'), Tools::getValue('MYMOD_CA_TOKEN')))
				$this->context->smarty->assign('confirmation', 'ok');
			else
				$this->context->smarty->assign('confirmation', 'ko');
		}
	}

	public function renderForm()
	{
		$inputs = array(
			array('name' => 'MYMOD_CA_EMAIL', 'label' => $this->module->l('E-mail'), 'type' => 'text'),
			array('name' => 'MYMOD_CA_TOKEN', 'label' => $this->module->l('Token'), 'type' => 'text'),
		);

		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->module->l('My Module configuration'),
					'icon' => 'icon-wrench'
				),
				'input' => $inputs,
				'submit' => array('title' => $this->module->l('Save'))
			)
		);

		$helper = new HelperForm();
		$helper->table = 'mymodcarrier';
		$helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
		$helper->allow_employee_form_lang = (int)Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG');
		$helper->submit_action = 'mymodcarrier_form';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->module->name.'&tab_module='.$this->module->tab.'&module_name='.$this->module->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->tpl_vars = array(
			'fields_value' => array(
				'MYMOD_CA_EMAIL' => Tools::getValue('MYMOD_CA_EMAIL', Configuration::get('MYMOD_CA_EMAIL')),
				'MYMOD_CA_TOKEN' => Tools::getValue('MYMOD_CA_TOKEN', Configuration::get('MYMOD_CA_TOKEN')),
			),
			'languages' => $this->context->controller->getLanguages()
		);

		return $helper->generateForm(array($fields_form));
	}

	public function run()
	{
		$this->processConfiguration();
		$html_confirmation_message = $this->module->display($this->file, 'getContent.tpl');
		$html_form = $this->renderForm();
		return $html_confirmation_message.$html_form;
	}
}
