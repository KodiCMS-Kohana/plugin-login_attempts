<?php defined('SYSPATH') or die('No direct script access.');

class Model_User_IP extends ORM {
	
	const BLOCKED = 1;
	const ALLOWED = 0;

	protected $_primary_key = 'ip';
	
	public static $statuses = array(
		0 => 'Allowed',
		1 => 'Blocked'
	);
	
	
	public function add_ip($ip = NULL)
	{
		if( ! Valid::ip($ip))
		{
			$ip = Request::$client_ip;
		}

		$values = array(
			'count' => DB::expr('count + 1'),
			'last_login' => time()
		);
		
		$this->reset(TRUE)->where('ip', '=', $ip)->find();
	
		if($this->loaded())
		{
			$this->values($values)->update();
		}
		else
		{
			$values['ip'] = $ip;
			$values['blocked'] = self::ALLOWED;
			$this->values($values)->create();
		}
		
		return $this;
	}
	
	public function allowed_ip($ip = NULL)
	{
		if( ! Valid::ip($ip))
		{
			$ip = Request::$client_ip;
		}

		return DB::select('blocked')
			->from($this->table_name())
			->where('ip', '=', $ip)
			->limit(1)
			->execute()
			->get('blocked') == self::ALLOWED;
	}
	
	public function change_status(array $ips, $status = self::ALLOWED)
	{
		if( ! empty($ips))
		{
			DB::update($this->table_name())
				->set(array('blocked' => $status))
				->where('ip', 'in', $ips)
				->execute();
		}

		$update = DB::update($this->table_name())
			->set(array('blocked' =>  $status === self::ALLOWED ? self::BLOCKED : self::ALLOWED));
		
		if( ! empty($ips))
		{
			$update->where('ip', 'not in', $ips);
		}
	
		$update->execute();
	}
}