<?php namespace Congredi\Notifications\NotificationTypes\Abstracts;

use Congredi\Notifications\NotificationTypes\Interfaces\NotificationTypeInterface;

abstract class AbstractNotificationType implements NotificationTypeInterface
{
	/**
	 * @param array $properties Easy way to set attributes at construction
	 */
	public function __construct($properties = [])
	{
		foreach ($properties as $name => $value) {
			$this->$name = $value;
		}
	}

	/**
	 * Returns the fully qualified name of this class.
	 *
	 * @return string the fully qualified name of this class.
	 */
	public static function className()
	{
		return static::class;
	}
}