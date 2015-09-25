<?php namespace Congredi\NotificationSystem\NotificationTypes\Abstracts;

use Congredi\NotificationSystem\NotificationTypes\Interfaces\NotificationTypeInterface;

abstract class AbstractNotificationType implements NotificationTypeInterface
{
	/**
	 * This is the notification service wich will be used to fire notifications.
	 *
	 * @var
	 */
	protected $notificationService;

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

	/**
	 * @param $notificationService
	 */
	public function setNotificationService($notificationService)
	{
		$this->notificationService = $notificationService;
	}

	/**
	 * @return mixed
	 */
	public function getNotificationService()
	{
		return $this->notificationService;
	}
}