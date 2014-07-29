<?php defined('SYSPATH') or die('No direct access allowed.');

Plugin::factory('login_attempts', array(
	'title' => 'Login attempts',
))->register();

Observer::observe( 'admin_login_validation', function($post) {

	if(Login_Attempts::get_total() >= Config::get('login_attempts', 'max_attempts_for_captcha'))
	{
		$post
			->label('captcha', __('Captcha'))
			->rules('captcha', array(
				array('not_empty'),
				array('Captcha::valid'),
			));
	}
});

Observer::observe( 'admin_login_before', function($post) {

	$error = FALSE;
	
	if( ! Login_Attempts::denied())
	{
		$period = Config::get('login_attempts', 'period');

		Messages::errors(__('Access denied for :period minutes.', array(
			':period' => $period
		)));
		
		Kohana::$log->add(Log::ALERT, 'Access denied for :period minutes', 
			array(
				':period' => $period,
				':value' => $post['username']
			))->write();
		
		$error = TRUE;
	}
	
	if($error === TRUE)
	{
		HTTP::redirect( (string) Route::get('user')->uri(array( 'action' => 'login' )), 302);
	}
});


Observer::observe( 'admin_login_success', function($username) {
	Login_Attempts::clear();
});


Observer::observe( 'admin_login_failed', function($post) {
	Login_Attempts::add();
});

Observer::observe( 'admin_login_form', function() {
	$total_attempts = Login_Attempts::get_total();

	if( ! Login_Attempts::denied() )
	{
		echo View::factory('login_attempts/denied', array(
			'period' => Config::get('login_attempts', 'period')
		));
	}
	else if($total_attempts >= Config::get('login_attempts', 'max_attempts_for_captcha'))
	{
		echo View::factory('login_attempts/captcha');
	}
});