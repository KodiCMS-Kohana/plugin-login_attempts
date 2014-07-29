<?php defined( 'SYSPATH' ) or die( 'No direct script access.' );

class Plugin_Login_Attempts extends Plugin_Type_Config {
	
	public function rules()
	{
		return array(
			'period' => array(
				array('not_empty'),
				array('numeric'),
			),
			'max_attempts' => array(
				array('not_empty'),
				array('numeric'),
			),
			'max_attempts_for_captcha' => array(
				array('not_empty'),
				array('numeric'),
			),
		);
	}
	
	public function filters()
	{
		return array(
			'period' => array(
				array('intval')
			),
			'max_attempts' => array(
				array('intval')
			),
			'max_attempts_for_captcha' => array(
				array('intval')
			),
		);
	}
	
	protected function _config_group_key()
	{
		return $this->id();
	}
}