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
	
	public function set_settings( array $data )
	{
		if(empty($data['blocked_ip']))
		{
			$data['blocked_ip'] = array();
		}
	
		ORM::factory('user_ip')->change_status($data['blocked_ip'], Model_User_IP::BLOCKED);
		unset($data['blocked_ip']);

		return parent::set_settings($data);
	}
	
	public function allowed_ip_list()
	{
		return ORM::factory('user_ip')
			->find_all()
			->as_array('ip', 'ip');
	}
	
	public function blocked_ip_list()
	{
		return ORM::factory('user_ip')
			->where('blocked', '=', Model_User_IP::BLOCKED)
			->find_all()
			->as_array('ip', 'ip');
	}
}