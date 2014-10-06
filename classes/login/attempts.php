<?php defined( 'SYSPATH' ) or die( 'No direct access allowed.' );

/**
 * @package		KodiCMS
 */
class Login_Attempts {
	
	/**
	 * 
	 * @param string $key
	 * @return string
	 */
	public static function config($key)
	{
		return Plugins::get_registered('login_attempts')->get($key);
	}

	public static function get_total($ip = NULL)
	{
		if( ! Valid::ip($ip))
		{
			$ip = Request::$client_ip;
		}
		
		return DB::select('attempts')
			->from('user_login_attempts')
			->where('ip', '=', $ip)
			->limit(1)
			->execute()
			->get('attempts');
	}

	public static function denied($ip = NULL)
	{
		if( ! Valid::ip($ip))
		{
			$ip = Request::$client_ip;
		}
		
		$result = DB::select('attempts', array(DB::expr('(CASE when last_login is not NULL and DATE_ADD(last_login, INTERVAL :period MINUTE) > NOW() then 1 else 0 end)', array(':period' => self::config('period'))), 'denied'))
			->from('user_login_attempts')->where('ip', '=', $ip)
			->limit(1)
			->execute()
			->current();
	
		if($result === NULL)
		{
			return TRUE;
		}
		else if($result['attempts'] >= self::config('max_attempts'))
		{
			if($result['denied'] == 1)
			{
				return FALSE;
			}
			else
			{
				self::clear($ip);
				return TRUE;
			}
		}
	
		return TRUE;
	}
	
	public static function add($ip = NULL)
	{
		if( ! Valid::ip($ip))
		{
			$ip = Request::$client_ip;
		}
		
		$attempts = self::get_total();
		
		if($attempts === NULL)
		{
			$data = array(
				'ip' => $ip,
				'attempts' => 0,
				'last_login' => date('Y-m-d H:i:s')
			);
			
			DB::insert('user_login_attempts')
				->columns(array_keys($data))
				->values($data)
				->execute();
		}
		else
		{
			$attempts = $attempts + 1;
			
			$update = DB::update('user_login_attempts')
				->set(array('attempts' => $attempts))
				->where('ip', '=', $ip);
			
			if($attempts == self::config('max_attempts'))
			{
				$update->set(array('last_login' => date('Y-m-d H:i:s')));
			}
			
			$update->execute();
		}
	}

	public static function clear($ip = NULL)
	{
		if( ! Valid::ip($ip))
		{
			$ip = Request::$client_ip;
		}
		
		return (bool) DB::update('user_login_attempts')
			->set(array('attempts' => 0))
			->where('ip', '=', $ip)
			->execute();
	}
}