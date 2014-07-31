<?php defined( 'SYSPATH' ) or die( 'No direct script access.' );

class Plugin_Login_Attempts extends Plugin_Decorator {
	
	public function default_settings()
	{
		return array(
			'period' => Config::get('login_attempts', 'period'),
			'max_attempts' => Config::get('login_attempts', 'max_attempts'),
			'max_attempts_for_captcha' => Config::get('login_attempts', 'max_attempts_for_captcha'),
		);
	}
	
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
}