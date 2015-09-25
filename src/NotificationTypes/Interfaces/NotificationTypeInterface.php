<?php namespace Congredi\NotificationSystem\NotificationTypes\Interfaces;


interface NotificationTypeInterface
{
	/**
	 * Returns the fully qualified name of the implemented class
	 *
	 * @return mixed
	 */
	public static function className();

	/**
	 * @return mixed
	 */
	public function getNotificationService();

	/**
	 * @param $notificationService
	 * @return mixed
	 */
	public function setNotificationService($notificationService);
}