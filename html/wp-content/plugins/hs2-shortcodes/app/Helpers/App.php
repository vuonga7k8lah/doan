<?php

namespace HSSC\Helpers;
/**
 * Class App
 * @package HSSC\Helpers
 */
class App
{
	private static $aRegistry = [];

	/**
	 * @param $key
	 * @param $value
	 */
	public static function bind($key, $value)
	{
		self::$aRegistry[$key] = $value;
	}

	/**
	 * @param $key
	 * @return false|mixed
	 */
	public static function get($key)
	{
		return array_key_exists($key, self::$aRegistry) ? self::$aRegistry[$key] : false;
	}

}