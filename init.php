<?php defined('SYSPATH') or die('No direct access allowed.');

$plugin = Plugin::factory('login_attempts', array(
	'title' => 'Login attempts',
))->register();

Observer::observe( array('admin_login_validation', 'login_validation'), function($post, $plugin) {

	if(Login_Attempts::get_total() >= $plugin->max_attempts_for_captcha)
	{
		$post
			->label('captcha', __('Captcha'))
			->rules('captcha', array(
				array('not_empty'),
				array('Captcha::valid'),
			));
	}

}, $plugin);

Observer::observe( array('login_before', 'admin_login_before'), function($post, $plugin) {

	$error = FALSE;

	if( ! ORM::factory('user_ip')->allowed_ip())
	{
		$error = TRUE;
		Messages::errors(__('Access denied.', array(
			':ip' => Request::$client_ip
		)));
	}

	if( ! Login_Attempts::denied())
	{
		$period = $plugin->period;

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

}, $plugin);


Observer::observe( array('login_success', 'admin_login_success'), function($username) {
	
	Login_Attempts::clear();
	ORM::factory('user_ip')->add_ip();

});

Observer::observe( 'template_before_render', function($username) {
	
	if( AuthUser::isLoggedIn() AND ! ORM::factory('user_ip')->allowed_ip())
	{
		AuthUser::logout();
		HTTP::redirect( (string) Route::get('user')->uri(array( 'action' => 'login' )), 302);
	}

});


Observer::observe( array('admin_login_failed', 'login_failed'), function($post) {

	Login_Attempts::add();

});

Observer::observe( 'admin_login_form', function($plugin) {

	$total_attempts = Login_Attempts::get_total();

	if( ! Login_Attempts::denied() )
	{
		echo View::factory('login_attempts/denied', array(
			'period' => $plugin->period
		));
	}
	else if($total_attempts >= $plugin->max_attempts_for_captcha)
	{
		echo View::factory('login_attempts/captcha');
	}

}, $plugin);