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
	public function getAdapter();

	/**
	 * @param $adapter
	 *
	 * @return void
	 */
	public function setAdapter($adapter);

	/**
	 * @param $name
	 *
	 * @return void
	 */
	public function setQueueName($name);

	/**
	 * @return mixed
	 */
	public function getQueueName();
}