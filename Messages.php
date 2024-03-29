<?php

/**
 * Message
 * 
 * @package Message
 * @author Max Software Ltd
 */
class Message {
	
	protected static $_messages = array();

	/**
	 * Message::_init()
	 * 
	 */
	public static function _init()
	{
		$current = Session::get('_messages');
        
		if ($current)
		{
			self::$_messages = unserialize($current);
		}
		else
		{
			self::reset();
		}
	}

	/**
	 * Message::notice()
	 * 
	 * @param mixed $m
	 */
	public static function notice($m)
	{
		self::add('notice', $m);
	}

	/**
	 * Message::error()
	 * 
	 * @param mixed $m
	 */
	public static function error($m)
	{
		self::add('error', $m);
	}

	/**
	 * Message::info()
	 * 
	 * @param mixed $m
	 */
	public static function info($m)
	{
		self::add('info', $m);
	}

	/**
	 * Message::add()
	 * 
	 * @param string $type (notice, error, info)
	 * @param mixed $message
	 */
	protected static function add($type, $message)
	{
		self::$_messages->{$type}[] = $message;
		self::write();
	}

	/**
	 * Message::get()
	 * 
	 */
	public static function get()
	{
		$messages = self::$_messages;
		foreach ($messages as $k => $v)
		{
			if ( ! count($v))
			{
				unset($messages->{$k});
			}	
		}

		self::reset();
		self::write();

		return count((array) $messages) == 0 ? null : $msgs;
	}

	/**
	 * Message::reset()
	 * 
	 */
	public static function reset()
	{
		self::$_messages = (object) array(
			'notice' => array(),
			'error' => array(),
			'info' => array()
		);
	}

	/**
	 * Message::write()
	 * 
	 */
	public static function write()
	{
		Session::set('_messages', serialize(self::$_messages));
	}
}