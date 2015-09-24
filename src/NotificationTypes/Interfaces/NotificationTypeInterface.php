<?php namespace Congredi\Notifications\NotificationTypes\Interfaces;


interface NotificationTypeInterface
{
	/**
	 * Returns the fully qualified name of the implemented class
	 *
	 * @return mixed
	 */
	public static function className();
}